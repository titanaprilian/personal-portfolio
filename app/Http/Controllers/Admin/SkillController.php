<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSkillRequest;
use App\Http\Requests\Admin\UpdateSkillRequest;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $skills = Skill::query()
            ->with('skillCategory')
            ->orderBy('name')
            ->paginate(20);

        $categories = SkillCategory::orderBy('name')->get();

        return view('admin.skills.index', compact('skills', 'categories'));
    }

    public function store(StoreSkillRequest $request): RedirectResponse
    {
        Skill::create($request->validated());

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill created successfully.');
    }

    public function update(UpdateSkillRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validated());

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully.');
    }
}
