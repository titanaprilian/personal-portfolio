<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectTag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategory = $request->query('category');
        $selectedTag = $request->query('tag');

        $projects = Project::query()
            ->with(['categories', 'tags'])
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->whereHas('categories', fn ($q) => $q->where('slug', $selectedCategory));
            })
            ->when($selectedTag, function ($query) use ($selectedTag) {
                $query->whereHas('tags', fn ($q) => $q->where('slug', $selectedTag));
            })
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $featuredProjects = Project::query()
            ->with(['categories', 'tags'])
            ->where('featured', true)
            ->orderBy('order')
            ->limit(3)
            ->get();

        $categories = ProjectCategory::orderBy('name')->get();
        $tags = ProjectTag::orderBy('name')->get();

        return view('public.projects.index', compact(
            'projects',
            'featuredProjects',
            'categories',
            'tags',
            'selectedCategory',
            'selectedTag',
        ));
    }

    public function show(Project $project): View
    {
        $project->load(['categories', 'tags']);

        $relatedProjects = Project::query()
            ->with(['categories', 'tags'])
            ->whereHas('categories', fn ($q) => $q->whereIn('id', $project->categories->pluck('id'))
            )
            ->where('id', '!=', $project->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        if ($relatedProjects->count() < 3) {
            $exclude = $relatedProjects->pluck('id')->push($project->id);
            $filler = Project::query()
                ->with(['categories', 'tags'])
                ->whereNotIn('id', $exclude)
                ->inRandomOrder()
                ->limit(3 - $relatedProjects->count())
                ->get();
            $relatedProjects = $relatedProjects->merge($filler);
        }

        return view('public.projects.show', compact('project', 'relatedProjects'));
    }
}
