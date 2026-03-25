<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->with(['categories', 'tags'])
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->paginate(12);

        $categories = ProjectCategory::orderBy('name')->get();
        $tags = ProjectTag::orderBy('name')->get();

        return view('admin.projects.index', compact('projects', 'categories', 'tags'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails/projects', 'public');
        }

        $project = Project::create($data);
        $project->categories()->sync($request->input('category_ids', []));
        $project->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails/projects', 'public');
        }

        $project->update($data);
        $project->categories()->sync($request->input('category_ids', []));
        $project->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        $project->categories()->detach();
        $project->tags()->detach();
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
