@props(['project' => null, 'index' => 0])

<a href="{{ route('projects.show', $project) }}"
   class="group flex flex-col rounded-2xl border border-[--color-border]
          bg-[--color-surface] hover:border-[--color-neon]/40
          transition-all duration-300 overflow-hidden"
   style="animation: fadeSlideUp 0.4s ease both;
          animation-delay: {{ $index * 60 }}ms;">

    <div class="aspect-video bg-[--color-bg] overflow-hidden relative">
        @if($project->thumbnail)
            <img src="{{ Storage::url($project->thumbnail) }}"
                 alt="{{ $project->title }}"
                 class="w-full h-full object-cover group-hover:scale-105
                        transition-transform duration-500" />
        @else
            <div class="w-full h-full flex items-center justify-center relative"
                 style="background: linear-gradient(135deg, #0d0d1a, var(--color-surface))">
                <div class="absolute inset-0 opacity-[0.07]"
                     style="background-image:
                       linear-gradient(var(--color-neon) 1px, transparent 1px),
                       linear-gradient(90deg, var(--color-neon) 1px, transparent 1px);
                       background-size: 24px 24px;"></div>
                <span class="font-display text-3xl font-bold text-[--color-border] relative z-10">
                    {{ strtoupper(substr($project->title, 0, 2)) }}
                </span>
            </div>
        @endif

        @if($project->featured_order)
            <div class="absolute top-3 right-3">
                <span class="text-xs px-2 py-0.5 rounded font-display
                             bg-[--color-neon]/10 border border-[--color-neon]/40
                             text-[--color-neon]">
                    ★ Slot {{ $project->featured_order }}
                </span>
            </div>
        @endif
    </div>

    <div class="flex flex-col flex-1 p-5">

        @if($project->categories->isNotEmpty())
            <div class="flex flex-wrap gap-1 mb-3">
                @foreach($project->categories->take(2) as $cat)
                    <span class="text-xs text-[--color-muted] font-display
                                 tracking-wide uppercase">
                        {{ $cat->name }}
                        @if(!$loop->last) · @endif
                    </span>
                @endforeach
            </div>
        @endif

        <h3 class="font-display text-base font-bold text-[--color-text]
                   group-hover:text-[--color-neon] transition-colors leading-snug mb-2">
            {{ $project->title }}
        </h3>

        <p class="text-[--color-muted] text-sm leading-relaxed line-clamp-2 flex-1">
            {{ $project->description }}
        </p>

        <div class="flex items-center justify-between mt-4 pt-4
                    border-t border-[--color-border]">
            <div class="flex flex-wrap gap-1">
                @foreach($project->tags->take(3) as $tag)
                    <span class="text-xs font-mono text-[--color-muted]/70 px-1.5 py-0.5
                                 rounded bg-white/5">
                        #{{ $tag->name }}
                    </span>
                @endforeach
                @if($project->tags->count() > 3)
                    <span class="text-xs font-mono text-[--color-muted]/50">
                        +{{ $project->tags->count() - 3 }}
                    </span>
                @endif
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
