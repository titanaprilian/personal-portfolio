@props(['post', 'index' => 0])

<a href="{{ route('blog.show', $post) }}"
   class="group flex flex-col rounded-2xl border border-[--color-border]
          bg-[--color-surface] hover:border-[--color-neon]/40
          overflow-hidden transition-all duration-300"
   style="animation: fadeSlideUp 0.4s ease both;
          animation-delay: {{ $index * 60 }}ms;">

  <div class="aspect-video bg-[--color-bg] overflow-hidden relative flex-shrink-0">
    @if($post->thumbnail)
      <img src="{{ Storage::url($post->thumbnail) }}"
           alt="{{ $post->title }}"
           class="w-full h-full object-cover group-hover:scale-105
                  transition-transform duration-500" />
    @else
      <div class="w-full h-full flex items-center justify-center relative"
           style="background: linear-gradient(135deg, #0d0d1a, var(--color-surface))">
        <div class="absolute inset-0 opacity-[0.06]"
             style="background-image:
               linear-gradient(var(--color-neon) 1px, transparent 1px),
               linear-gradient(90deg, var(--color-neon) 1px, transparent 1px);
               background-size: 24px 24px;"></div>
        <span class="font-display text-3xl font-bold text-[--color-border] relative z-10">
          {{ strtoupper(substr($post->title, 0, 2)) }}
        </span>
      </div>
    @endif

    @if($post->category)
      <div class="absolute top-3 left-3">
        <span class="text-xs px-2 py-0.5 rounded font-display tracking-wide
                     bg-[--color-bg]/80 border border-[--color-border]
                     text-[--color-muted] backdrop-blur-sm">
          {{ $post->category->name }}
        </span>
      </div>
    @endif
  </div>

  <div class="flex flex-col flex-1 p-5">

    <h3 class="font-display text-base font-bold text-[--color-text]
               group-hover:text-[--color-neon] transition-colors
               leading-snug mb-2 line-clamp-2">
      {{ $post->title }}
    </h3>

    <p class="text-[--color-muted] text-sm leading-relaxed line-clamp-3 flex-1">
      {{ Str::limit(strip_tags($post->body), 120) }}
    </p>

    @if($post->tags->isNotEmpty())
      <div class="flex flex-wrap gap-1 mt-3">
        @foreach($post->tags->take(3) as $tag)
          <span class="text-xs font-mono text-[--color-muted]/70
                       px-1.5 py-0.5 rounded bg-white/5">
            #{{ $tag->name }}
          </span>
        @endforeach
        @if($post->tags->count() > 3)
          <span class="text-xs font-mono text-[--color-muted]/40">
            +{{ $post->tags->count() - 3 }}
          </span>
        @endif
      </div>
    @endif

    <div class="flex items-center justify-between mt-4 pt-4
                border-t border-[--color-border]">
      <div class="flex items-center gap-3 text-xs text-[--color-muted] font-display">
        <span class="flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          {{ $post->reading_time ?? 1 }} min read
        </span>
        <span class="text-[--color-border]">·</span>
        <span>{{ $post->published_at->format('M d, Y') }}</span>
      </div>

      <svg class="w-4 h-4 text-[--color-muted] group-hover:text-[--color-neon]
                  group-hover:translate-x-1 transition-all duration-200 flex-shrink-0"
           fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
          stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
      </svg>
    </div>

  </div>
</a>
