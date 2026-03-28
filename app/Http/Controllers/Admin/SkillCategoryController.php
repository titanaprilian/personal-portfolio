<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSkillCategoryRequest;
use App\Http\Requests\Admin\UpdateSkillCategoryRequest;
use App\Models\SkillCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SkillCategoryController extends Controller
{
    public function index(): View
    {
        $categories = SkillCategory::query()
            ->withCount('skills')
            ->orderBy('name')
            ->get();

        return view('admin.skills-categories.index', compact('categories'));
    }

    public function store(StoreSkillCategoryRequest $request): RedirectResponse
    {
        SkillCategory::create($request->validated());

        return redirect()->route('admin.skills-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function update(UpdateSkillCategoryRequest $request, SkillCategory $skill_category): RedirectResponse
    {
        $skill_category->update($request->validated());

        return redirect()->route('admin.skills-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(SkillCategory $skill_category): RedirectResponse
    {
        if ($skill_category->skills()->count() > 0) {
            return redirect()->route('admin.skills-categories.index')
                ->with('error', 'Cannot delete category with associated skills.');
        }

        $skill_category->delete();

        return redirect()->route('admin.skills-categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
