<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Post;
use App\Models\Project;
use App\Models\Skill;
use Carbon\Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProjects = Project::query()
            ->with(['categories', 'tags'])
            ->featured()
            ->limit(3)
            ->get();

        if ($featuredProjects->count() < 3) {
            $exclude = $featuredProjects->pluck('id');
            $filler = Project::query()
                ->with(['categories', 'tags'])
                ->whereNotIn('id', $exclude)
                ->orderByDesc('created_at')
                ->limit(3 - $featuredProjects->count())
                ->get();
            $featuredProjects = $featuredProjects->merge($filler);
        }

        $skills = Skill::query()
            ->with('skillCategory')
            ->orderBy('name')
            ->get()
            ->groupBy(fn ($skill) => $skill->skillCategory?->name ?? 'Uncategorized');

        $experiences = Experience::query()
            ->orderByDesc('is_current')
            ->orderByDesc('start_date')
            ->limit(2)
            ->get();

        $stats = [
            'projects' => Project::count(),
            'posts' => Post::published()->count(),
            'experience' => Experience::min('start_date')
                ? (int) Carbon::parse(Experience::min('start_date'))->diffInYears(now())
                : 0,
        ];

        $activeResume = \App\Models\Resume::where('is_active', true)->first();

        return view('public.home', compact(
            'featuredProjects',
            'skills',
            'experiences',
            'stats',
            'activeResume',
        ));
    }
}
