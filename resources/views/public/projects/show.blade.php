<x-layouts.app :title="$project->title . ' — ' . config('app.name')">

  <div class="max-w-4xl mx-auto px-6 pt-10 pb-0">
    <nav class="flex items-center gap-2 text-xs font-display text-[--color-muted]">
      <a href="{{ route('home') }}"
         class="hover:text-[--color-neon] transition-colors">Home</a>
      <span>/</span>
      <a href="{{ route('projects.index') }}"
         class="hover:text-[--color-neon] transition-colors">Projects</a>
      <span>/</span>
      <span class="text-[--color-text] truncate max-w-48">{{ $project->title }}</span>
    </nav>
  </div>

  <section class="max-w-4xl mx-auto px-6 pt-10 pb-8"
           style="animation: fadeSlideUp 0.5s ease both;">

    @if($project->categories->isNotEmpty())
      <div class="flex flex-wrap gap-2 mb-4">
        @foreach($project->categories as $category)
          <a href="{{ route('projects.index', ['category' => $category->slug]) }}"
             class="text-xs font-display tracking-widest uppercase
                    text-[--color-neon] hover:underline underline-offset-2">
            {{ $category->name }}
          </a>
          @if(!$loop->last)
            <span class="text-[--color-border]">·</span>
          @endif
        @endforeach
      </div>
    @endif

    <h1 class="font-display text-4xl md:text-5xl font-bold text-[--color-text]
               leading-tight mb-4">
      {{ $project->title }}
    </h1>

    <p class="text-[--color-muted] text-lg leading-relaxed max-w-2xl mb-6">
      {{ $project->description }}
    </p>

    <div class="flex flex-wrap items-center gap-3 mb-8">
      @if($project->demo_url)
        <a href="{{ $project->demo_url }}"
           target="_blank"
           rel="noopener noreferrer"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                  font-display text-sm font-medium tracking-wide
                  text-[--color-bg] transition-all duration-200"
           style="background: var(--color-neon);
                  box-shadow: 0 0 20px var(--color-neon-dim);"
           onmouseover="this.style.boxShadow='0 0 30px var(--color-neon-dim)'"
           onmouseout="this.style.boxShadow='0 0 20px var(--color-neon-dim)'">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0
                 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
          </svg>
          Live Demo
        </a>
      @endif

      @if($project->github_url)
        <a href="{{ $project->github_url }}"
           target="_blank"
           rel="noopener noreferrer"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                  border border-[--color-border] font-display text-sm font-medium
                  tracking-wide text-[--color-text] hover:border-[--color-neon]/40
                  hover:text-[--color-neon] transition-all duration-200">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18
                     6.839 9.504.5.092.682-.217.682-.483
                     0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343
                     -3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466
                     -.908-.62.069-.608.069-.608 1.003.07 1.531 1.032
                     1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647
                     .35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951
                     0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272
                     .098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0
                     0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296
                     2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651
                     .64.7 1.028 1.595 1.028 2.688 0 3.848-2.339
                     4.695-4.566 4.943.359.309.678.92.678 1.855
                     0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019
                     10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
          </svg>
          View on GitHub
        </a>
      @endif

      @if(!$project->demo_url && !$project->github_url)
        <p class="text-xs text-[--color-muted] font-display italic">
          // no public links available for this project
        </p>
      @endif
    </div>

    <div class="flex flex-wrap items-center gap-3 text-xs text-[--color-muted] font-display">
      @if($project->featured_order)
        <span class="px-2 py-0.5 rounded border border-[--color-neon]/30
                     text-[--color-neon] bg-[--color-neon]/5">
          ★ Featured (Slot {{ $project->featured_order }})
        </span>
        <span class="text-[--color-border]">·</span>
      @endif
      <span>Added {{ $project->created_at->format('M Y') }}</span>
    </div>

  </section>

  @if($project->thumbnail)
  <section class="max-w-4xl mx-auto px-6 mb-10"
           style="animation: fadeSlideUp 0.5s ease 0.1s both;">

    <div class="flex gap-4 overflow-x-auto pb-3 scrollbar-thin
                snap-x snap-mandatory"
         style="scrollbar-color: var(--color-border) transparent;">

      <div class="flex-shrink-0 snap-start rounded-xl overflow-hidden border
                  border-[--color-border] cursor-zoom-in"
           x-data="{ lightbox: false }"
           @click="lightbox = true">
        <img src="{{ Storage::url($project->thumbnail) }}"
             alt="{{ $project->title }} — screenshot"
             class="h-72 w-auto max-w-none object-cover" />

        <div x-show="lightbox"
             @click.self="lightbox = false"
             @keydown.escape.window="lightbox = false"
             x-transition
             class="fixed inset-0 z-50 flex items-center justify-center p-4
                    bg-black/90 backdrop-blur-sm"
             style="display: none">
          <img src="{{ Storage::url($project->thumbnail) }}"
               alt="{{ $project->title }}"
               class="max-w-full max-h-full rounded-xl object-contain
                      shadow-2xl" />
          <button @click="lightbox = false"
                  class="absolute top-4 right-4 text-white/60 hover:text-white
                         transition-colors text-sm font-display">
            ✕ Close
          </button>
        </div>
      </div>

    </div>

    <p class="text-xs text-[--color-muted]/50 font-display mt-2">
      // scroll to see more screenshots
    </p>

  </section>
  @endif

  @if($project->tags->isNotEmpty())
  <section class="max-w-4xl mx-auto px-6 mb-10"
           style="animation: fadeSlideUp 0.5s ease 0.15s both;">

    <h2 class="font-display text-xs text-[--color-muted] tracking-widest
               uppercase mb-4">
      // tech stack
    </h2>

    <div class="flex flex-wrap gap-2">
      @foreach($project->tags as $tag)
        <a href="{{ route('projects.index', ['tag' => $tag->slug]) }}"
           class="group inline-flex items-center gap-1.5 font-mono text-xs
                  rounded border transition-all duration-200"
           style="padding: 0.3rem 0.65rem;
                  background: rgba(0,255,224,0.04);
                  border-color: var(--color-border);
                  color: var(--color-muted);"
           onmouseover="this.style.borderColor='rgba(0,255,224,0.4)';
                        this.style.color='var(--color-neon)';
                        this.style.background='rgba(0,255,224,0.08)'"
           onmouseout="this.style.borderColor='var(--color-border)';
                       this.style.color='var(--color-muted)';
                       this.style.background='rgba(0,255,224,0.04)'">
          <span class="w-1.5 h-1.5 rounded-full flex-shrink-0"
                style="background: var(--color-neon); opacity: 0.6"></span>
          {{ $tag->name }}
        </a>
      @endforeach
    </div>

  </section>
  @endif

  <div class="max-w-4xl mx-auto px-6 mb-10">
    <div class="h-px w-full"
         style="background: linear-gradient(90deg, transparent, var(--color-border), transparent)">
    </div>
  </div>

  @if($project->body)
  <section class="max-w-4xl mx-auto px-6 mb-16"
           style="animation: fadeSlideUp 0.5s ease 0.2s both;">

    <div class="prose-content">
      {{-- Body rendered as raw HTML — safe because content is admin-authored only --}}
      {!! $project->body !!}
    </div>

  </section>
  @endif

  @if($relatedProjects->isNotEmpty())
  <section class="border-t border-[--color-border] mt-8">
    <div class="max-w-6xl mx-auto px-6 py-16">

      <div class="flex items-center gap-3 mb-8">
        <div class="h-px flex-1 bg-[--color-border]"></div>
        <span class="text-xs font-display text-[--color-neon] tracking-widest uppercase">
          // related projects
        </span>
        <div class="h-px flex-1 bg-[--color-border]"></div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($relatedProjects as $index => $related)
          <x-public.project-card :project="$related" :index="$index" />
        @endforeach
      </div>

      <div class="mt-10 text-center">
        <a href="{{ route('projects.index') }}"
           class="inline-flex items-center gap-2 text-sm font-display
                  text-[--color-muted] hover:text-[--color-neon]
                  transition-colors tracking-wide">
          View all projects
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
          </svg>
        </a>
      </div>

    </div>
  </section>
  @endif

</x-layouts.app>
