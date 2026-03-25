<x-layouts.app :title="$post->title . ' — ' . config('app.name')">

  <div
    x-data="readingProgress()"
    x-init="init()"
    class="fixed top-0 left-0 right-0 z-50 h-0.5"
    style="background: var(--color-border)"
  >
    <div
      :style="`width: ${progress}%`"
      class="h-full transition-none"
      style="background: linear-gradient(90deg, var(--color-neon), rgba(0,255,224,0.6));
             box-shadow: 0 0 8px var(--color-neon);"
    ></div>
  </div>

  {{-- Breadcrumb --}}
  <div class="max-w-4xl mx-auto px-6 pt-10">
    <nav class="flex items-center gap-2 text-xs font-display text-[--color-muted]">
      <a href="{{ route('home') }}"
         class="hover:text-[--color-neon] transition-colors">Home</a>
      <span>/</span>
      <a href="{{ route('blog.index') }}"
         class="hover:text-[--color-neon] transition-colors">Blog</a>
      <span>/</span>
      <span class="text-[--color-text] truncate max-w-48">{{ $post->title }}</span>
    </nav>
  </div>

  {{-- Header + Meta --}}
  <section class="max-w-4xl mx-auto px-6 pt-10 pb-8"
           style="animation: fadeSlideUp 0.5s ease both;">

    @if($post->category)
      <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
         class="text-xs font-display tracking-widest uppercase
                text-[--color-neon] hover:underline underline-offset-2 mb-4 block">
        {{ $post->category->name }}
      </a>
    @endif

    <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold
               text-[--color-text] leading-tight mb-6">
      {{ $post->title }}
    </h1>

    <div class="flex flex-wrap items-center gap-4 text-xs text-[--color-muted]
                font-display mb-6 pb-6 border-b border-[--color-border]">

      <span class="flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2
               0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        {{ $post->published_at->format('F j, Y') }}
      </span>

      <span class="text-[--color-border]">·</span>

      <span class="flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ $post->reading_time ?? 1 }} min read
      </span>

      @if($post->tags->isNotEmpty())
        <span class="text-[--color-border]">·</span>
        <span>{{ $post->tags->count() }} {{ Str::plural('tag', $post->tags->count()) }}</span>
      @endif

    </div>
  </section>

  {{-- Thumbnail --}}
  @if($post->thumbnail)
  <section class="max-w-4xl mx-auto px-6 mb-10"
           style="animation: fadeSlideUp 0.5s ease 0.1s both;">
    <div class="rounded-2xl overflow-hidden border border-[--color-border]">
      <img src="{{ Storage::url($post->thumbnail) }}"
           alt="{{ $post->title }}"
           class="w-full object-cover max-h-96" />
    </div>
  </section>
  @endif

  {{-- Mobile TOC (if headings exist) --}}
  @if(count($headings) > 0)
  <section class="max-w-4xl mx-auto px-6 mb-8 xl:hidden"
           x-data="{ open: false }">
    <button @click="open = !open"
            class="flex items-center justify-between w-full px-4 py-3
                   rounded-xl border border-[--color-border] bg-[--color-surface]
                   text-xs font-display hover:border-[--color-neon]/40 transition-colors">
      <span class="text-[--color-neon] tracking-widest uppercase">// contents</span>
      <svg :class="open ? 'rotate-180' : ''"
           class="w-4 h-4 transition-transform duration-200"
           fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
          stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </button>
    <div x-show="open" x-transition class="mt-2 px-4 py-3 rounded-xl
         border border-[--color-border] bg-[--color-surface] space-y-1">
      @foreach($headings as $heading)
        <a href="#{{ $heading['slug'] }}"
           @click="open = false"
           class="block text-xs font-display text-[--color-muted]
                  hover:text-[--color-neon] transition-colors py-0.5"
           style="{{ $heading['level'] === 1 ? 'padding-left: 0' :
                     ($heading['level'] === 2 ? 'padding-left: 1rem' :
                      'padding-left: 2rem') }}">
          {{ $heading['text'] }}
        </a>
      @endforeach
    </div>
  </section>
  @endif

  {{-- Main content: sidebar TOC + article body --}}
  @if(count($headings) > 0)
  <section class="max-w-5xl mx-auto px-6 mb-10">
    <div class="flex gap-12 items-start">
  @else
  <section class="max-w-4xl mx-auto px-6 mb-10">
  @endif

    {{-- Desktop TOC sidebar --}}
    @if(count($headings) > 0)
      <aside
        x-data="tocSidebar()"
        x-init="init()"
        class="hidden xl:block w-48 flex-shrink-0 sticky top-8 self-start
               max-h-[calc(100vh-4rem)] overflow-y-auto"
      >
        <p class="text-xs font-display text-[--color-neon] tracking-widest uppercase mb-4">
          // contents
        </p>
        <nav class="space-y-1">
          @foreach($headings as $heading)
            <a
              href="#{{ $heading['slug'] }}"
              :class="activeSlug === '{{ $heading['slug'] }}'
                ? 'text-[--color-neon] border-l-[--color-neon]'
                : 'text-[--color-muted] border-l-transparent hover:text-[--color-text]'"
              class="block border-l-2 transition-all duration-200 font-display text-xs
                     leading-relaxed py-0.5"
              style="{{ $heading['level'] === 1 ? 'padding-left: 0.75rem' :
                        ($heading['level'] === 2 ? 'padding-left: 1.25rem' :
                         'padding-left: 1.75rem') }}"
              @click.prevent="scrollToHeading('{{ $heading['slug'] }}')"
            >
              {{ $heading['text'] }}
            </a>
          @endforeach
        </nav>
      </aside>

      <div class="flex-1 min-w-0 max-w-3xl"
           x-data="readingProgress()"
           x-init="init()">
    @endif

    {{-- Post body --}}
    <article id="post-content">
      <div class="prose-content"
           id="prose-body"
           style="animation: fadeSlideUp 0.5s ease 0.15s both;">
        {!! $body !!}
      </div>
    </article>

    {{-- Tags --}}
    @if($post->tags->isNotEmpty())
      <div class="mt-12 pt-8 border-t border-[--color-border]">
        <p class="text-xs font-display text-[--color-muted] tracking-widest
                  uppercase mb-3">
          // tagged
        </p>
        <div class="flex flex-wrap gap-2">
          @foreach($post->tags as $tag)
            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}"
               class="inline-flex items-center gap-1.5 font-mono text-xs
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
              #{{ $tag->name }}
            </a>
          @endforeach
        </div>
      </div>
    @endif

    {{-- Back nav --}}
    <div class="mt-10 pt-6 border-t border-[--color-border]">
      <a href="{{ route('blog.index') }}"
         class="inline-flex items-center gap-2 text-xs font-display
                text-[--color-muted] hover:text-[--color-neon]
                transition-colors tracking-wide">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
        </svg>
        Back to Blog
      </a>
    </div>

    @if(count($headings) > 0)
      </div>{{-- closes flex-1 wrapper --}}
    @endif

  @if(count($headings) > 0)
    </div>{{-- closes flex gap-12 --}}
  @endif
  </section>

  {{-- Related Posts --}}
  @if($relatedPosts->isNotEmpty())
  <section class="border-t border-[--color-border]">
    <div class="max-w-6xl mx-auto px-6 py-16">

      <div class="flex items-center gap-3 mb-8">
        <div class="h-px flex-1 bg-[--color-border]"></div>
        <span class="text-xs font-display text-[--color-neon] tracking-widest uppercase">
          // related posts
        </span>
        <div class="h-px flex-1 bg-[--color-border]"></div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($relatedPosts as $index => $related)
          <x-public.post-card :post="$related" :index="$index" />
        @endforeach
      </div>

      <div class="mt-10 text-center">
        <a href="{{ route('blog.index') }}"
           class="inline-flex items-center gap-2 text-sm font-display
                  text-[--color-muted] hover:text-[--color-neon]
                  transition-colors tracking-wide">
          View all posts
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
