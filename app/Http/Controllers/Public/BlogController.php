<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search', '');
        $selectedCategory = $request->query('category', '');
        $selectedTag = $request->query('tag', '');

        $posts = Post::query()
            ->with(['category', 'tags'])
            ->published()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $selectedCategory));
            })
            ->when($selectedTag, function ($query) use ($selectedTag) {
                $query->whereHas('tags', fn ($q) => $q->where('slug', $selectedTag));
            })
            ->orderBy('order')
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = PostCategory::orderBy('name')->get();
        $tags = PostTag::orderBy('name')->get();

        return view('public.blog.index', compact(
            'posts',
            'categories',
            'tags',
            'search',
            'selectedCategory',
            'selectedTag',
        ));
    }

    public function show(Post $post): View
    {
        if (! $post->published_at || $post->published_at->isFuture()) {
            abort(404);
        }

        $post->load(['category', 'tags']);

        $relatedByCategory = collect();
        if ($post->category) {
            $relatedByCategory = Post::query()
                ->with(['category', 'tags'])
                ->published()
                ->where('id', '!=', $post->id)
                ->where('category_id', $post->category_id)
                ->inRandomOrder()
                ->limit(2)
                ->get();
        }

        $excludeIds = $relatedByCategory->pluck('id')->push($post->id);
        $relatedByTags = Post::query()
            ->with(['category', 'tags'])
            ->published()
            ->whereNotIn('id', $excludeIds)
            ->whereHas('tags', fn ($q) => $q->whereIn('id', $post->tags->pluck('id')))
            ->inRandomOrder()
            ->limit(2)
            ->get();

        $relatedPosts = $relatedByCategory->merge($relatedByTags)->take(3);

        if ($relatedPosts->count() < 3) {
            $excludeIds = $relatedPosts->pluck('id')->push($post->id);
            $filler = Post::query()
                ->with(['category', 'tags'])
                ->published()
                ->whereNotIn('id', $excludeIds)
                ->inRandomOrder()
                ->limit(3 - $relatedPosts->count())
                ->get();
            $relatedPosts = $relatedPosts->merge($filler);
        }

        $extracted = $this->extractHeadings($post->body_html ?? '');
        $headings = $extracted['headings'] ?? [];
        $body = $extracted['body'] ?? $post->body_html;

        return view('public.blog.show', compact('post', 'relatedPosts', 'headings', 'body'));
    }

    private function extractHeadings(string $html): array
    {
        if (empty(trim($html))) {
            return ['headings' => [], 'body' => $html];
        }

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->encoding = 'UTF-8';
        libxml_use_internal_errors(true);
        $dom->loadHTML(
            '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body>'.$html.'</body></html>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        $headings = [];
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//h1 | //h2');

        foreach ($nodes as $node) {
            $text = trim($node->textContent);
            $level = (int) substr($node->nodeName, 1);
            $slug = Str::slug($text);

            $node->setAttribute('id', $slug);

            $headings[] = [
                'level' => $level,
                'text' => $text,
                'slug' => $slug,
            ];
        }

        $body = '';
        $bodyNode = $dom->getElementsByTagName('body')->item(0);
        if ($bodyNode) {
            foreach ($bodyNode->childNodes as $child) {
                $body .= $dom->saveHTML($child);
            }
        }

        return ['headings' => $headings, 'body' => $body];
    }
}
