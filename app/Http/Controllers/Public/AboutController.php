<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Resume;
use App\Models\Skill;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $skills = Skill::query()
            ->with('skillCategory')
            ->orderBy('name')
            ->get()
            ->groupBy(fn ($skill) => $skill->skillCategory?->name ?? 'Uncategorized');

        $experiences = Experience::query()
            ->orderByDesc('is_current')
            ->orderByDesc('start_date')
            ->get();

        $resume = Resume::where('is_active', true)->first();

        return view('public.about', compact('skills', 'experiences', 'resume'));
    }
}
