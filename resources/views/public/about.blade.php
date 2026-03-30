<x-layouts.app title="About — {{ config('app.name') }}">

  <section class="max-w-4xl mx-auto px-6 pt-20 pb-12"
           style="animation: fadeSlideUp 0.5s ease both">

    <p class="font-display text-[--color-neon] text-xs tracking-widest uppercase mb-3">
      // about me
    </p>
    <h1 class="font-display text-4xl md:text-5xl font-bold
               text-[--color-text] leading-tight mb-6">
      Hi, I'm <span style="color: var(--color-neon)">{{ config('app.name') }}</span>
    </h1>

    <div class="max-w-2xl space-y-4 text-[--color-muted] leading-relaxed">
      <p>
        A passionate software developer who loves building elegant solutions
        to complex problems. I specialize in full-stack web development with
        a focus on clean code, performance, and great developer experience.
      </p>
      <p>
        When I'm not coding, I write about software development, contribute to
        open source, and explore new technologies. This portfolio is a living
        record of my journey.
      </p>
    </div>

    @if($resume)
      <div class="mt-8 flex flex-wrap items-center gap-3">
        <a href="{{ route('resume.download') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                  font-display text-sm font-medium tracking-wide
                  text-[--color-bg] transition-all duration-200"
           style="background: var(--color-neon);
                  box-shadow: 0 0 20px var(--color-neon-dim);"
           onmouseover="this.style.boxShadow='0 0 35px var(--color-neon-dim)'"
           onmouseout="this.style.boxShadow='0 0 20px var(--color-neon-dim)'">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0
                 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5
                 4.5V3" />
          </svg>
          Download Resume
        </a>
        <span class="text-xs text-[--color-muted] font-display italic">
          {{ $resume->label }}
        </span>
      </div>
    @endif

  </section>

  <div class="max-w-4xl mx-auto px-6 mb-16">
    <div class="h-px"
         style="background: linear-gradient(90deg, transparent,
                var(--color-border), transparent)"></div>
  </div>

  <section class="max-w-4xl mx-auto px-6 mb-20">

    <p class="font-display text-[--color-neon] text-xs tracking-widest uppercase mb-2">
      // skills
    </p>
    <h2 class="font-display text-2xl font-bold text-[--color-text] mb-10">
      Tech Stack
    </h2>

    @if($skills->isEmpty())
      <p class="text-[--color-muted] text-sm font-display italic">
        No skills added yet.
      </p>
    @else

      <div class="space-y-12">
        @foreach($skills as $category => $categorySkills)

          <div>
            <div class="flex items-center gap-3 mb-6">
              <span class="font-display text-xs tracking-widest uppercase
                           text-[--color-neon]">
                {{ $category }}
              </span>
              <div class="flex-1 h-px bg-[--color-border]"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-5">
              @foreach($categorySkills as $skill)

                <div
                  x-data="skillBar({{ $skill->proficiency }})"
                  x-init="observe($el)"
                  class="skill-bar-item"
                >
                  <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">

                      @if($skill->icon)
                        <img
                          src="https://cdn.simpleicons.org/{{ $skill->icon }}{{ in_array($skill->icon, ['elysia', 'nextjs', 'vscode']) ? '/ffffff' : '' }}"
                          alt="{{ $skill->name }}"
                          class="w-4 h-4 object-contain opacity-80"
                          onerror="this.style.display='none'"
                        />
                      @endif

                      <span class="text-sm font-display text-[--color-text]">
                        {{ $skill->name }}
                      </span>
                    </div>

                    <span class="text-xs font-display font-bold tabular-nums"
                          style="color: var(--color-neon)"
                          x-text="displayed + '%'">
                      0%
                    </span>
                  </div>

                  <div class="h-1.5 rounded-full overflow-hidden"
                       style="background: var(--color-border)">
                    <div
                      class="h-full rounded-full transition-none"
                      :style="`width: ${displayed}%;
                               background: linear-gradient(90deg,
                                 var(--color-neon),
                                 rgba(0,255,224,0.5));
                               box-shadow: 0 0 8px var(--color-neon-dim);`"
                    ></div>
                  </div>

                </div>

              @endforeach
            </div>
          </div>

        @endforeach
      </div>

    @endif
  </section>

  <div class="max-w-4xl mx-auto px-6 mb-16">
    <div class="h-px"
         style="background: linear-gradient(90deg, transparent,
                var(--color-border), transparent)"></div>
  </div>

  <section class="max-w-4xl mx-auto px-6 pb-24">

    <p class="font-display text-[--color-neon] text-xs tracking-widest uppercase mb-2">
      // experience
    </p>
    <h2 class="font-display text-2xl font-bold text-[--color-text] mb-10">
      Work History
    </h2>

    @if($experiences->isEmpty())
      <p class="text-[--color-muted] text-sm font-display italic">
        No experience entries yet.
      </p>
    @else

      <div class="relative">

        <div class="absolute left-5 top-0 bottom-0 w-px"
             style="background: linear-gradient(to bottom,
                    var(--color-neon), var(--color-border))"></div>

        <div class="space-y-8">
          @foreach($experiences as $index => $experience)

            @php
              $domain  = Str::slug($experience->company) . '.com';
              $logoUrl = "https://www.google.com/s2/favicons?domain={$domain}&sz=64";
              $end     = $experience->is_current ? now() : $experience->end_date;
              $duration = $experience->start_date->diffForHumans($end, [
                  'parts'  => 2,
                  'join'   => ', ',
                  'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
              ]);
            @endphp

            <div
              class="relative flex gap-5 items-start"
              style="animation: fadeSlideUp 0.5s ease {{ $index * 100 }}ms both"
            >

              <div class="relative z-10 flex-shrink-0"
                   x-data="{ logoFailed: false }">
                <div class="w-10 h-10 rounded-xl overflow-hidden ring-2
                            border border-[--color-border]"
                     style="ring-color: var(--color-bg);
                            background: var(--color-surface)">
                  <img
                    x-show="!logoFailed"
                    src="{{ $logoUrl }}"
                    alt="{{ $experience->company }}"
                    x-on:error="logoFailed = true"
                    class="w-full h-full object-contain p-1.5 bg-white/90"
                  />
                  <div
                    x-show="logoFailed"
                    class="w-full h-full flex items-center justify-center"
                    style="background: rgba(0,255,224,0.08)"
                  >
                    <span class="font-display text-sm font-bold"
                          style="color: var(--color-neon)">
                      {{ strtoupper(substr($experience->company, 0, 1)) }}
                    </span>
                  </div>
                </div>
              </div>

              <div class="flex-1 min-w-0 rounded-xl border border-[--color-border]
                          p-5 transition-colors duration-300"
                   style="background: var(--color-surface)"
                   onmouseover="this.style.borderColor='rgba(0,255,224,0.2)'"
                   onmouseout="this.style.borderColor='var(--color-border)'">

                <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                  <div>
                    <h3 class="font-display font-bold text-[--color-text] text-sm">
                      {{ $experience->role }}
                    </h3>
                    <p class="text-xs text-[--color-muted] mt-0.5 font-display">
                      {{ $experience->company }}
                    </p>
                  </div>

                  @if($experience->is_current)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full
                                 text-xs font-display font-medium tracking-wide"
                          style="background: rgba(0,255,224,0.1);
                                 border: 1px solid rgba(0,255,224,0.3);
                                 color: var(--color-neon)">
                      Current
                    </span>
                  @endif
                </div>

                <div class="flex flex-wrap items-center gap-1.5 text-xs
                            text-[--color-muted] font-display mb-3">
                  <span>
                    {{ $experience->start_date->format('M Y') }}
                    —
                    {{ $experience->is_current
                        ? 'Present'
                        : ($experience->end_date?->format('M Y') ?? '—') }}
                  </span>
                  <span style="color: var(--color-border)">·</span>
                  <span style="color: rgba(0,255,224,0.6)">
                    {{ $duration }}
                  </span>
                </div>

                @if($experience->description)
                  <p class="text-sm leading-relaxed"
                     style="color: var(--color-muted)">
                    {{ $experience->description }}
                  </p>
                @endif

            </div>
          </div>

          @endforeach
        </div>
      </div>
    @endif

  </section>

</x-layouts.app>
