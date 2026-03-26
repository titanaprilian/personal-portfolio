<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->with(['category', 'tags'])
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->paginate(12);

        $categories = PostCategory::orderBy('name')->get();
        $tags = PostTag::orderBy('name')->get();

        return view('admin.blog.index', compact('posts', 'categories', 'tags'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails/posts', 'public');
        }

        $data['reading_time'] = $this->calculateReadingTime($data['body'] ?? '');

        if (! isset($data['order'])) {
            $data['order'] = Post::getNextOrder();
        }

        $post = Post::create($data);
        $post->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post created successfully.');
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails/posts', 'public');
        }

        $data['reading_time'] = $this->calculateReadingTime($data['body'] ?? '');

        $post->update($data);
        $post->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function updateOrder(Post $post): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), [
            'order' => ['required', 'integer', 'min:0', new \App\Rules\UniquePostOrder],
        ]);

        if ($validator->fails()) {
            if (request()->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $order = request()->input('order');

        $post->update(['order' => $order]);

        if (request()->expectsJson()) {
            return response()->json(['success' => 'Post order updated.']);
        }

        return back()->with('success', 'Post order updated.');
    }

    private function calculateReadingTime(string $html): int
    {
        $text = strip_tags($html);
        $wordCount = str_word_count($text);

        return max(1, (int) ceil($wordCount / 200));
    }
}
