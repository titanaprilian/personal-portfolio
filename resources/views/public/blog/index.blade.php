<x-layouts.app title="Blog — {{ config('app.name') }}">

  <section class="max-w-6xl mx-auto px-6 pt-20 pb-10">
    <p class="font-display text-[--color-neon] text-xs tracking-widest uppercase mb-3">
      // writing
    </p>
    <h1 class="font-display text-4xl md:text-5xl font-bold text-[--color-text] leading-tight">
      Blog
    </h1>
    <p class="mt-4 text-[--color-muted] text-base max-w-xl leading-relaxed">
      Thoughts on code, tools, and the craft of building software.
    </p>
  </section>

  <section class="max-w-6xl mx-auto px-6 mb-8 space-y-4">

    <form method="GET" action="{{ route('blog.index') }}" class="relative">
      @if($selectedCategory)
        <input type="hidden" name="category" value="{{ $selectedCategory }}" />
      @endif
      @if($selectedTag)
        <input type="hidden" name="tag" value="{{ $selectedTag }}" />
      @endif
      <div class="absolute inset-y-0 left-0 flex items-center pl-3
                  pointer-events-none w-10">
        <svg class="w-4 h-4 text-[--color-muted]" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <input
        type="text"
        name="search"
        value="{{ $search }}"
        placeholder="Search posts..."
        class="w-full ps-10 pe-12 py-3 rounded-xl border border-[--color-border]
               bg-[--color-surface] text-[--color-text] text-sm font-display
               placeholder-[--color-muted] focus:outline-none
               focus:border-[--color-neon]/40 transition-colors"
        style="caret-color: var(--color-neon)"
      />
      @if($search)
        <a href="{{ route('blog.index', array_filter(['category' => $selectedCategory, 'tag' => $selectedTag])) }}"
           class="absolute inset-y-0 right-0 flex items-center px-3
                  text-[--color-muted] hover:text-[--color-neon] transition-colors text-xs font-mono">
          ✕
        </a>
      @endif
    </form>

    <div class="flex flex-wrap items-center gap-3">

      <div class="flex flex-wrap gap-2">
        <a href="{{ route('blog.index', array_filter(['search' => $search, 'tag' => $selectedTag])) }}"
           class="{{ !$selectedCategory
             ? 'border-[--color-neon] text-[--color-neon] bg-[--color-neon]/10'
             : 'border-[--color-border] text-[--color-muted] hover:border-[--color-neon]/40 hover:text-[--color-text]' }}
             px-3 py-1.5 rounded-full border text-xs font-display
             tracking-wide transition-all duration-200">
          All
        </a>

        @foreach($categories as $category)
          <a href="{{ route('blog.index', array_filter(['search' => $search, 'category' => $category->slug, 'tag' => $selectedTag])) }}"
             class="{{ $selectedCategory === $category->slug
               ? 'border-[--color-neon] text-[--color-neon] bg-[--color-neon]/10'
               : 'border-[--color-border] text-[--color-muted] hover:border-[--color-neon]/40 hover:text-[--color-text]' }}
               px-3 py-1.5 rounded-full border text-xs font-display
               tracking-wide transition-all duration-200">
            {{ $category->name }}
          </a>
        @endforeach
      </div>

      @if($tags->isNotEmpty())
        <div class="w-px h-5 bg-[--color-border]"></div>
      @endif

      <div class="flex flex-wrap gap-2">
        @foreach($tags as $tag)
          <a href="{{ route('blog.index', array_filter(['search' => $search, 'category' => $selectedCategory, 'tag' => $tag->slug])) }}"
             class="{{ $selectedTag === $tag->slug
               ? 'border-[--color-neon] text-[--color-neon] bg-[--color-neon]/10'
               : 'border-[--color-border] text-[--color-muted]/60 hover:border-[--color-neon]/40 hover:text-[--color-text]' }}
               px-3 py-1.5 rounded-full border text-xs font-mono
               transition-all duration-200">
            #{{ $tag->name }}
          </a>
        @endforeach
      </div>

      @if($selectedCategory || $selectedTag || $search)
        <a href="{{ route('blog.index') }}"
           class="text-xs text-[--color-muted] hover:text-[--color-neon]
                  transition-colors ml-auto underline underline-offset-2 font-display">
          Clear all
        </a>
      @endif

    </div>

  </section>

  <section class="max-w-6xl mx-auto px-6 mb-6">
    <p class="text-xs text-[--color-muted] font-display">
      @if($search || $selectedCategory || $selectedTag)
        {{ $posts->total() }} {{ Str::plural('post', $posts->total()) }} found
        @if($search)
          matching <span class="text-[--color-neon]">"{{ $search }}"</span>
        @endif
        @if($selectedCategory)
          in <span class="text-[--color-neon]">
            {{ $categories->firstWhere('slug', $selectedCategory)?->name }}
          </span>
        @endif
        @if($selectedTag)
          tagged <span class="text-[--color-neon]">
            #{{ $tags->firstWhere('slug', $selectedTag)?->name }}
          </span>
        @endif
      @else
        {{ $posts->total() }} {{ Str::plural('post', $posts->total()) }} published
      @endif
    </p>
  </section>

  <section class="max-w-6xl mx-auto px-6 pb-20">

    @if($posts->isEmpty())
      <div class="flex flex-col items-center justify-center py-24 text-center">
        <div class="w-16 h-16 rounded-2xl border border-[--color-border]
                    bg-[--color-surface] flex items-center justify-center mb-4">
          <svg class="w-7 h-7 text-[--color-muted]" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125
                 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0
                 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125
                 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621
                 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
          </svg>
        </div>
        <p class="font-display text-[--color-text] text-sm mb-2">
          No posts found
        </p>
        <p class="text-[--color-muted] text-xs mb-4">
          @if($search)
            No posts match "{{ $search }}". Try a different search term.
          @else
            Try clearing your filters to see all posts.
          @endif
        </p>
        <a href="{{ route('blog.index') }}"
           class="text-xs text-[--color-neon] hover:underline font-display">
          Clear all filters
        </a>
      </div>

    @else

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($posts as $index => $post)
          <x-public.post-card :post="$post" :index="$index" />
        @endforeach
      </div>

      @if($posts->hasPages())
        <div class="mt-12 flex justify-center">
          <nav class="flex items-center gap-1 font-display text-xs">

            @if($posts->onFirstPage())
              <span class="px-3 py-2 rounded-lg border border-[--color-border]
                           text-[--color-muted]/40 cursor-not-allowed">
                Prev
              </span>
            @else
              <a href="{{ $posts->previousPageUrl() }}"
                 class="px-3 py-2 rounded-lg border border-[--color-border]
                        text-[--color-muted] hover:border-[--color-neon]/40
                        hover:text-[--color-neon] transition-all duration-200">
                Prev
              </a>
            @endif

            @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
              @if($page == $posts->currentPage())
                <span class="px-3 py-2 rounded-lg border text-xs font-bold"
                      style="border-color: var(--color-neon);
                             color: var(--color-neon);
                             background: rgba(0,255,224,0.08)">
                  {{ $page }}
                </span>
              @else
                <a href="{{ $url }}"
                   class="px-3 py-2 rounded-lg border border-[--color-border]
                          text-[--color-muted] hover:border-[--color-neon]/40
                          hover:text-[--color-neon] transition-all duration-200">
                  {{ $page }}
                </a>
              @endif
            @endforeach

            @if($posts->hasMorePages())
              <a href="{{ $posts->nextPageUrl() }}"
                 class="px-3 py-2 rounded-lg border border-[--color-border]
                        text-[--color-muted] hover:border-[--color-neon]/40
                        hover:text-[--color-neon] transition-all duration-200">
                Next
              </a>
            @else
              <span class="px-3 py-2 rounded-lg border border-[--color-border]
                           text-[--color-muted]/40 cursor-not-allowed">
                Next
              </span>
            @endif

          </nav>
        </div>

        <p class="text-center text-xs text-[--color-muted] font-display mt-3">
          Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}
          · {{ $posts->total() }} total {{ Str::plural('post', $posts->total()) }}
        </p>
      @endif

    @endif

  </section>

</x-layouts.app>
