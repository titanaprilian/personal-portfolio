<x-layouts.app title="Projects — {{ config('app.name') }}">

<section class="max-w-6xl mx-auto px-6 pt-20 pb-10">
    <p class="font-display text-[--color-neon] text-xs tracking-widest uppercase mb-3">
        // my work
    </p>
    <h1 class="font-display text-4xl md:text-5xl font-bold text-[--color-text] leading-tight">
        Projects
    </h1>
    <p class="mt-4 text-[--color-muted] text-base max-w-xl leading-relaxed">
        A collection of things I've built — from side projects to production systems.
    </p>
</section>

@if($featuredProjects->isNotEmpty() && !$selectedCategory && !$selectedTag)
<section class="max-w-6xl mx-auto px-6 mb-14">

    <div class="flex items-center gap-3 mb-6">
        <div class="h-px flex-1 bg-[--color-border]"></div>
        <span class="text-xs font-display text-[--color-neon] tracking-widest uppercase">
            Featured
        </span>
        <div class="h-px flex-1 bg-[--color-border]"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        @if($featuredProjects->isNotEmpty())
            @php $primary = $featuredProjects->first(); @endphp
            <a href="{{ route('projects.show', $primary) }}"
               class="group relative rounded-2xl overflow-hidden border border-[--color-border]
                      bg-[--color-surface] hover:border-[--color-neon]/40
                      transition-all duration-300 min-h-64 flex flex-col"
               style="animation: fadeSlideUp 0.5s ease both;">

                @if($primary->thumbnail)
                    <div class="absolute inset-0">
                        <img src="{{ Storage::url($primary->thumbnail) }}"
                             alt="{{ $primary->title }}"
                             class="w-full h-full object-cover opacity-40
                                    group-hover:opacity-60 transition-opacity duration-300" />
                        <div class="absolute inset-0"
                             style="background: linear-gradient(to top, var(--color-surface) 30%, transparent)">
                        </div>
                    </div>
                @else
                    <div class="absolute inset-0"
                         style="background: linear-gradient(135deg, var(--color-surface), #0d0d1a)">
                    </div>
                    <div class="absolute inset-0 opacity-10"
                         style="background-image: linear-gradient(var(--color-neon) 1px, transparent 1px),
                                linear-gradient(90deg, var(--color-neon) 1px, transparent 1px);
                                background-size: 32px 32px;">
                    </div>
                @endif

                <div class="relative mt-auto p-6">
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($primary->tags->take(3) as $tag)
                            <span class="text-xs px-2 py-0.5 rounded font-display
                                         border border-[--color-neon]/30 text-[--color-neon]">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                    <h2 class="font-display text-xl font-bold text-[--color-text]
                               group-hover:text-[--color-neon] transition-colors">
                        {{ $primary->title }}
                    </h2>
                    <p class="text-[--color-muted] text-sm mt-2 line-clamp-2">
                        {{ $primary->description }}
                    </p>
                    <div class="flex items-center gap-2 mt-4 text-[--color-neon] text-xs font-display">
                        View project
                        <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                </div>
            </a>
        @endif

        <div class="flex flex-col gap-4">
            @foreach($featuredProjects->skip(1)->take(2) as $index => $project)
                <a href="{{ route('projects.show', $project) }}"
                   class="group relative rounded-2xl overflow-hidden border border-[--color-border]
                          bg-[--color-surface] hover:border-[--color-neon]/40
                          transition-all duration-300 flex-1 min-h-28 flex flex-col"
                   style="animation: fadeSlideUp {{ 0.5 + ($index + 1) * 0.1 }}s ease both;">

                    @if($project->thumbnail)
                        <div class="absolute inset-0">
                            <img src="{{ Storage::url($project->thumbnail) }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-full object-cover opacity-30
                                        group-hover:opacity-50 transition-opacity duration-300" />
                            <div class="absolute inset-0"
                                 style="background: linear-gradient(to top, var(--color-surface) 40%, transparent)">
                            </div>
                        </div>
                    @else
                        <div class="absolute inset-0"
                             style="background: linear-gradient(135deg, var(--color-surface), #0d0d1a)">
                        </div>
                    @endif

                    <div class="relative mt-auto p-4">
                        <h3 class="font-display text-sm font-bold text-[--color-text]
                                   group-hover:text-[--color-neon] transition-colors">
                            {{ $project->title }}
                        </h3>
                        <p class="text-[--color-muted] text-xs mt-1 line-clamp-1">
                            {{ $project->description }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>
@endif

<section class="max-w-6xl mx-auto px-6 mb-8">
    <div class="flex flex-wrap items-center gap-3">

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('projects.index', array_filter(['tag' => $selectedTag])) }}"
               class="{{ !$selectedCategory
                    ? 'border-[--color-neon] text-[--color-neon] bg-[--color-neon]/10'
                    : 'border-[--color-border] text-[--color-muted] hover:border-[--color-neon]/40 hover:text-[--color-text]' }}
                    px-3 py-1.5 rounded-full border text-xs font-display tracking-wide
                    transition-all duration-200 cursor-pointer select-none">
                All
            </a>

            @foreach($categories as $category)
                <a href="{{ route('projects.index', array_filter(['category' => $category->slug, 'tag' => $selectedTag])) }}"
                   class="{{ $selectedCategory === $category->slug
                        ? 'border-[--color-neon] text-[--color-neon] bg-[--color-neon]/10'
                        : 'border-[--color-border] text-[--color-muted] hover:border-[--color-neon]/40 hover:text-[--color-text]' }}
                        px-3 py-1.5 rounded-full border text-xs font-display tracking-wide
                        transition-all duration-200 cursor-pointer select-none">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        @if($tags->isNotEmpty())
            <div class="w-px h-5 bg-[--color-border]"></div>
        @endif

        <div class="flex flex-wrap gap-2">
            @foreach($tags as $tag)
                <a href="{{ route('projects.index', array_filter(['category' => $selectedCategory, 'tag' => $tag->slug])) }}"
                   class="{{ $selectedTag === $tag->slug
                        ? 'border-[--color-neon] text-[--color-neon] bg-[--color-neon]/10'
                        : 'border-[--color-border] text-[--color-muted]/60 hover:border-[--color-neon]/40 hover:text-[--color-text]' }}
                        px-3 py-1.5 rounded-full border text-xs font-mono
                        transition-all duration-200 cursor-pointer select-none">
                    #{{ $tag->name }}
                </a>
            @endforeach
        </div>

        @if($selectedCategory || $selectedTag)
            <a href="{{ route('projects.index') }}"
               class="text-xs text-[--color-muted] hover:text-[--color-neon]
                      transition-colors ml-auto underline underline-offset-2">
                Clear filters ×
            </a>
        @endif

    </div>
</section>

<section class="max-w-6xl mx-auto px-6 mb-6">
    <p class="text-xs text-[--color-muted] font-display">
        @if($selectedCategory || $selectedTag)
            {{ $projects->total() }} {{ Str::plural('project', $projects->total()) }} found
            @if($selectedCategory)
                in <span class="text-[--color-neon]">{{ $categories->firstWhere('slug', $selectedCategory)?->name }}</span>
            @endif
            @if($selectedTag)
                tagged <span class="text-[--color-neon]">#{{ $tags->firstWhere('slug', $selectedTag)?->name }}</span>
            @endif
        @else
            {{ $projects->total() }} {{ Str::plural('project', $projects->total()) }} total
        @endif
    </p>
</section>

<section class="max-w-6xl mx-auto px-6 pb-20">

    @if($projects->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-16 h-16 rounded-2xl border border-[--color-border]
                        bg-[--color-surface] flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-[--color-muted]" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0
                           1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z" />
                </svg>
            </div>
            <p class="font-display text-[--color-text] text-sm mb-2">No projects found</p>
            <p class="text-[--color-muted] text-xs mb-4">
                Try clearing your filters to see all projects.
            </p>
            <a href="{{ route('projects.index') }}"
               class="text-xs text-[--color-neon] hover:underline font-display">
                Clear filters →
            </a>
        </div>

    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($projects as $index => $project)
                <x-public.project-card :project="$project" :index="$index" />
            @endforeach
        </div>

        @if($projects->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $projects->links('pagination::tailwind') }}
            </div>
        @endif

    @endif
</section>

</x-layouts.app>
