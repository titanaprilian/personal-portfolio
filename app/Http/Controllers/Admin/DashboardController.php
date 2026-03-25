<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Experience;
use App\Models\Post;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProjects = Project::count();
        $totalPosts = Post::count();
        $publishedPosts = Post::published()->count();
        $draftPosts = $totalPosts - $publishedPosts;
        $unreadMessages = Contact::whereNull('read_at')->count();
        $totalSkills = Skill::count();
        $totalExperiences = Experience::count();

        $postStatusData = [
            'labels' => ['Published', 'Draft'],
            'data' => [$publishedPosts, $draftPosts],
        ];

        $skillsByCategory = Skill::query()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->pluck('count', 'category');

        $skillsCategoryData = [
            'labels' => $skillsByCategory->keys()->values()->toArray(),
            'data' => $skillsByCategory->values()->toArray(),
        ];

        $postsPerMonth = Post::query()
            ->whereNotNull('published_at')
            ->where('published_at', '>=', now()->subMonths(6))
            ->selectRaw("DATE_FORMAT(published_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $months->put($key, $postsPerMonth->get($key, 0));
        }

        $postsTimelineData = [
            'labels' => $months->keys()->map(fn ($m) => \Carbon\Carbon::parse($m.'-01')->format('M Y'))->toArray(),
            'data' => $months->values()->toArray(),
        ];

        $recentProjects = Project::query()
            ->with(['categories', 'tags'])
            ->latest()
            ->limit(5)
            ->get();

        $recentMessages = Contact::query()
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProjects',
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'unreadMessages',
            'totalSkills',
            'totalExperiences',
            'postStatusData',
            'skillsCategoryData',
            'postsTimelineData',
            'recentProjects',
            'recentMessages',
        ));
    }
}
