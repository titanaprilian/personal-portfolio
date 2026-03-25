<x-layouts.admin title="Dashboard">

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Welcome back
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Here's what's happening with your portfolio.
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 mb-8">
        <x-admin.stat-card
            label="Projects"
            :value="$totalProjects"
            color="indigo"
            href="{{ route('admin.projects.index') }}"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
            </svg>
        </x-admin.stat-card>

        <x-admin.stat-card
            label="Blog Posts"
            :value="$totalPosts"
            color="violet"
            href="{{ route('admin.blog.index') }}"
            :sub="$publishedPosts . ' published · ' . $draftPosts . ' draft'"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
        </x-admin.stat-card>

        <x-admin.stat-card
            label="Unread Messages"
            :value="$unreadMessages"
            color="rose"
            href="{{ route('admin.contacts.index') }}"
            :sub="$unreadMessages > 0 ? 'Needs attention' : 'All caught up'"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
            </svg>
        </x-admin.stat-card>

        <x-admin.stat-card
            label="Skills"
            :value="$totalSkills"
            color="emerald"
            href="{{ route('admin.skills.index') }}"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
            </svg>
        </x-admin.stat-card>

        <x-admin.stat-card
            label="Experiences"
            :value="$totalExperiences"
            color="amber"
            href="{{ route('admin.experiences.index') }}"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
            </svg>
        </x-admin.stat-card>

        <x-admin.stat-card
            label="Published Rate"
            :value="$totalPosts > 0 ? round(($publishedPosts / $totalPosts) * 100) : 0"
            color="sky"
            :sub="$publishedPosts . ' of ' . $totalPosts . ' posts'"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
        </x-admin.stat-card>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <x-admin.chart-card title="Post Status" height="h-52">
            <canvas
                id="chart-post-status"
                x-data
                x-init="
                    const isDark = document.documentElement.classList.contains('dark');
                    new Chart($el, {
                        type: 'doughnut',
                        data: {
                            labels: {{ Js::from($postStatusData['labels']) }},
                            datasets: [{
                                data: {{ Js::from($postStatusData['data']) }},
                                backgroundColor: isDark ? ['#6366f1', '#374151'] : ['#6366f1', '#e5e7eb'],
                                borderWidth: 0,
                                hoverOffset: 4,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: { padding: 16, font: { size: 12 }, color: isDark ? '#9ca3af' : '#6b7280' }
                                }
                            },
                            cutout: '70%',
                        }
                    })
                "
            ></canvas>
        </x-admin.chart-card>

        <x-admin.chart-card title="Skills by Category" height="h-52">
            <canvas
                id="chart-skills-category"
                x-data
                x-init="
                    const isDark = document.documentElement.classList.contains('dark');
                    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';
                    const tickColor = isDark ? '#9ca3af' : '#6b7280';
                    new Chart($el, {
                        type: 'bar',
                        data: {
                            labels: {{ Js::from($skillsCategoryData['labels']) }},
                            datasets: [{
                                label: 'Skills',
                                data: {{ Js::from($skillsCategoryData['data']) }},
                                backgroundColor: ['#6366f1','#8b5cf6','#f59e0b','#10b981'],
                                borderRadius: 6,
                                borderSkipped: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1, color: tickColor },
                                    grid: { color: gridColor },
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { color: tickColor },
                                }
                            }
                        }
                    })
                "
            ></canvas>
        </x-admin.chart-card>

        <x-admin.chart-card title="Posts Published (Last 6 Months)" height="h-52">
            <canvas
                id="chart-posts-timeline"
                x-data
                x-init="
                    const isDark = document.documentElement.classList.contains('dark');
                    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';
                    const tickColor = isDark ? '#9ca3af' : '#6b7280';
                    new Chart($el, {
                        type: 'line',
                        data: {
                            labels: {{ Js::from($postsTimelineData['labels']) }},
                            datasets: [{
                                label: 'Posts',
                                data: {{ Js::from($postsTimelineData['data']) }},
                                borderColor: '#6366f1',
                                backgroundColor: 'rgba(99,102,241,0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#6366f1',
                                pointRadius: 4,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1, color: tickColor },
                                    grid: { color: gridColor },
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { color: tickColor },
                                }
                            }
                        }
                    })
                "
            ></canvas>
        </x-admin.chart-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Recently Added Projects
                </h3>
                <a href="{{ route('admin.projects.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                    View all →
                </a>
            </div>
            <ul class="divide-y divide-gray-50 dark:divide-gray-800">
                @forelse($recentProjects as $project)
                    <li class="flex items-center gap-3 px-5 py-3">
                        <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100 dark:bg-gray-800">
                            @if($project->thumbnail)
                                <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}" class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">
                                {{ $project->title }}
                            </p>
                            <div class="flex items-center gap-1 mt-0.5 flex-wrap">
                                @foreach($project->tags->take(2) as $tag)
                                    <span class="text-xs px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                                @if($project->featured)
                                    <span class="text-xs px-1.5 py-0.5 rounded bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                                        ★ Featured
                                    </span>
                                @endif
                            </div>
                        </div>
                        <span class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0">
                            {{ $project->created_at->diffForHumans(short: true) }}
                        </span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-gray-400 dark:text-gray-500">
                        No projects yet.
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Recent Messages
                </h3>
                <a href="{{ route('admin.contacts.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                    View all →
                </a>
            </div>
            <ul class="divide-y divide-gray-50 dark:divide-gray-800">
                @forelse($recentMessages as $message)
                    <li class="flex items-start gap-3 px-5 py-3 {{ is_null($message->read_at) ? 'bg-indigo-50/40 dark:bg-indigo-900/10' : '' }}">
                        <div class="mt-1.5 flex-shrink-0">
                            @if(is_null($message->read_at))
                                <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                            @else
                                <div class="w-2 h-2 rounded-full bg-transparent"></div>
                            @endif
                        </div>
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                            <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">
                                {{ strtoupper(substr($message->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate {{ is_null($message->read_at) ? 'font-semibold' : '' }}">
                                    {{ $message->name }}
                                </p>
                                <span class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0">
                                    {{ $message->created_at->diffForHumans(short: true) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                                {{ Str::limit($message->message, 70) }}
                            </p>
                        </div>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-gray-400 dark:text-gray-500">
                        No messages yet.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

</x-layouts.admin>
