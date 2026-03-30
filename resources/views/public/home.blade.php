<x-layouts.app title="{{ config('app.name') }} — Portfolio">

  {{-- ════════════════════════════════════════════════════════
       SECTION 1: HERO
       ════════════════════════════════════════════════════════ --}}
  <section class="relative min-h-[90vh] flex items-center overflow-hidden">

    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                  w-[600px] h-[600px] rounded-full opacity-10 blur-3xl"
           style="background: radial-gradient(circle, var(--color-neon), transparent 70%)">
      </div>
    </div>

    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
         style="background-image:
                  linear-gradient(var(--color-neon) 1px, transparent 1px),
                  linear-gradient(90deg, var(--color-neon) 1px, transparent 1px);
                background-size: 40px 40px;">
    </div>

    <div class="relative z-10 w-full px-6 py-24">

      <div class="max-w-4xl mx-auto">

        {{-- Top row: left = text content, right = stats --}}
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-12">

          {{-- Left: Text content --}}
          <div class="flex-1">

            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                        border mb-8"
                 style="border-color: rgba(0,255,224,0.3);
                        background: rgba(0,255,224,0.05);
                        animation: fadeSlideUp 0.4s ease both">
              <span class="w-2 h-2 rounded-full animate-pulse"
                    style="background: var(--color-neon)"></span>
              <span class="text-xs font-display tracking-widest uppercase"
                    style="color: var(--color-neon)">
                Available for work
              </span>
            </div>

            <h1 class="font-display font-bold text-[--color-text] leading-[1.1] mb-6"
                style="font-size: clamp(2.8rem, 7vw, 5.5rem);
                       animation: fadeSlideUp 0.5s ease 0.05s both">
              {{ config('app.name') }}
            </h1>

            <p class="font-display font-bold mb-6"
               style="font-size: clamp(1.3rem, 3.5vw, 2.2rem);
                      color: var(--color-neon);
                      animation: fadeSlideUp 0.5s ease 0.1s both">
              Full Stack Developer
            </p>

            <p class="text-lg leading-relaxed max-w-xl mb-10"
               style="color: var(--color-muted);
                      animation: fadeSlideUp 0.5s ease 0.15s both">
              I build clean, performant web applications with a focus on
              great developer experience and elegant code. Currently working
              with Laravel, Next.js, and modern JavaScript.
            </p>

            <div class="flex flex-wrap items-center gap-4"
                 style="animation: fadeSlideUp 0.5s ease 0.2s both">

              <a href="{{ route('projects.index') }}"
                 class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
                        font-display text-sm font-bold tracking-wide
                        transition-all duration-200"
                 style="background: var(--color-neon);
                        color: var(--color-bg);
                        box-shadow: 0 0 24px var(--color-neon-dim);"
                 onmouseover="this.style.boxShadow='0 0 40px var(--color-neon-dim)'"
                 onmouseout="this.style.boxShadow='0 0 24px var(--color-neon-dim)'">
                View Projects
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
              </a>

              <a href="{{ route('contact') }}"
                 class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border
                        font-display text-sm font-bold tracking-wide transition-all duration-200"
                 style="border-color: var(--color-border);
                        color: var(--color-text);"
                 onmouseover="this.style.borderColor='rgba(0,255,224,0.4)';
                              this.style.color='var(--color-neon)'"
                 onmouseout="this.style.borderColor='var(--color-border)';
                             this.style.color='var(--color-text)'">
                Get in Touch
              </a>

              @if($activeResume)
                <a href="{{ route('resume.download') }}"
                   class="inline-flex items-center gap-2 text-sm font-display
                          transition-colors duration-200"
                   style="color: var(--color-muted);"
                   onmouseover="this.style.color='var(--color-neon)'"
                   onmouseout="this.style.color='var(--color-muted)'">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                       stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25
                         0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5
                         4.5V3" />
                  </svg>
                  Resume
                </a>
              @endif

            </div>

          </div>

          {{-- Right: Stats panel --}}
          <div class="flex flex-row lg:flex-col gap-8 lg:gap-6 lg:pt-12
                      border-t lg:border-t-0 lg:border-l"
               style="border-color: var(--color-border);
                      animation: fadeSlideUp 0.5s ease 0.25s both">
            @foreach([
              [$stats['projects'],    'Projects Built'],
              [$stats['posts'],      'Blog Posts'],
              [$stats['experience'], 'Years Experience'],
            ] as [$count, $label])
              <div>
                <p class="font-display text-2xl font-bold tabular-nums"
                   style="color: var(--color-neon)">
                  {{ $count }}+
                </p>
                <p class="text-xs font-display tracking-widest uppercase mt-0.5"
                   style="color: var(--color-muted)">
                  {{ $label }}
                </p>
              </div>
            @endforeach
          </div>

        </div>
      </div>

    </div>
  </section>

  {{-- ════════════════════════════════════════════════════════
       SECTION 2: FEATURED PROJECTS
       ════════════════════════════════════════════════════════ --}}
  @if($featuredProjects->isNotEmpty())
  <section class="max-w-6xl mx-auto px-6 py-20">

    <div class="flex items-end justify-between gap-4 mb-10">
      <div>
        <p class="font-display text-xs tracking-widest uppercase mb-2"
           style="color: var(--color-neon)">
          // featured work
        </p>
        <h2 class="font-display text-3xl font-bold"
            style="color: var(--color-text)">
          Selected Projects
        </h2>
      </div>
      <a href="{{ route('projects.index') }}"
         class="hidden sm:inline-flex items-center gap-1.5 text-sm font-display
                transition-colors duration-200 flex-shrink-0"
         style="color: var(--color-muted)"
         onmouseover="this.style.color='var(--color-neon)'"
         onmouseout="this.style.color='var(--color-muted)'">
        All projects
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
        </svg>
      </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach($featuredProjects as $index => $project)
        <x-public.project-card :project="$project" :index="$index" />
      @endforeach
    </div>

    <div class="mt-8 text-center sm:hidden">
      <a href="{{ route('projects.index') }}"
         class="text-sm font-display transition-colors duration-200"
         style="color: var(--color-neon)">
        View all projects →
      </a>
    </div>

  </section>
  @endif

  {{-- ════════════════════════════════════════════════════════
       SECTION 3: SKILLS ICON STRIP
       ════════════════════════════════════════════════════════ --}}
  @if($skills->isNotEmpty())
  <section class="border-y py-16"
           style="border-color: var(--color-border)">
    <div class="max-w-6xl mx-auto px-6">

      <div class="text-center mb-10">
        <p class="font-display text-xs tracking-widest uppercase mb-2"
           style="color: var(--color-neon)">
          // tech stack
        </p>
        <h2 class="font-display text-3xl font-bold"
            style="color: var(--color-text)">
          Skills & Tools
        </h2>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 lg:gap-x-12 gap-y-16">
        @foreach($skills as $category => $categorySkills)

          <div class="flex flex-col items-center">
            <h3 class="text-[10px] font-display tracking-[0.2em] uppercase opacity-40 border-b pb-2 mb-8 w-full text-center"
                style="color: var(--color-text); border-color: rgba(255,255,255,0.05)">
              {{ $category }}
            </h3>

            <div class="flex flex-wrap justify-center gap-y-10 gap-x-8 w-full">
              @foreach($categorySkills as $skill)
                <a href="{{ route('about') }}#skills"
                   class="group flex flex-col items-center justify-center text-center w-20"
                   title="{{ $skill->name }}">

                  <span class="text-[10px] font-display font-bold tracking-tight opacity-40 group-hover:opacity-100 transition-opacity truncate w-full mb-3 px-1"
                        style="color: var(--color-muted)">
                    {{ $skill->name }}
                  </span>

                  <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300
                              bg-white/[0.03] border border-white/[0.05] group-hover:bg-white/[0.08] group-hover:border-white/[0.1]">
                    @if($skill->icon)
                      <img src="https://cdn.simpleicons.org/{{ $skill->icon }}{{ in_array($skill->icon, ['elysia', 'nextjs', 'vscode']) ? '/ffffff' : '' }}"
                           alt="{{ $skill->name }}"
                           class="w-6 h-6 object-contain opacity-80 group-hover:opacity-100 transition-opacity"
                           loading="lazy" />
                    @else
                      <div class="font-display text-[10px] font-bold opacity-60 group-hover:opacity-100"
                           style="color: var(--color-neon)">
                        {{ strtoupper(substr($skill->name, 0, 2)) }}
                      </div>
                    @endif
                  </div>

                </a>
              @endforeach
            </div>
          </div>

        @endforeach
      </div>

      <div class="mt-10 text-center">
        <a href="{{ route('about') }}"
           class="inline-flex items-center gap-2 text-sm font-display
                  transition-colors duration-200"
           style="color: var(--color-muted)"
           onmouseover="this.style.color='var(--color-neon)'"
           onmouseout="this.style.color='var(--color-muted)'">
          See full skill details with proficiency levels →
        </a>
      </div>

    </div>
  </section>
  @endif

  {{-- ════════════════════════════════════════════════════════
       SECTION 4: WORK EXPERIENCE TEASER
       ════════════════════════════════════════════════════════ --}}
  @if($experiences->isNotEmpty())
  <section class="max-w-4xl mx-auto px-6 py-20">

    <div class="flex items-end justify-between gap-4 mb-10">
      <div>
        <p class="font-display text-xs tracking-widest uppercase mb-2"
           style="color: var(--color-neon)">
          // where I've worked
        </p>
        <h2 class="font-display text-3xl font-bold"
            style="color: var(--color-text)">
          Experience
        </h2>
      </div>
      <a href="{{ route('about') }}#experience"
         class="hidden sm:inline-flex items-center gap-1.5 text-sm font-display
                transition-colors flex-shrink-0"
         style="color: var(--color-muted)"
         onmouseover="this.style.color='var(--color-neon)'"
         onmouseout="this.style.color='var(--color-muted)'">
        Full history →
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @foreach($experiences as $index => $experience)

        @php
          $domain  = Str::slug($experience->company) . '.com';
          $logoUrl = "https://www.google.com/s2/favicons?domain={$domain}&sz=64";
        @endphp

        <div class="flex items-start gap-4 p-5 rounded-2xl border
                    transition-all duration-300"
             style="border-color: var(--color-border);
                    background: var(--color-surface);
                    animation: fadeSlideUp 0.5s ease {{ $index * 100 }}ms both"
             onmouseover="this.style.borderColor='rgba(0,255,224,0.2)'"
             onmouseout="this.style.borderColor='var(--color-border)'">

          <div x-data="{ logoFailed: false }"
               class="flex-shrink-0 w-10 h-10 rounded-xl overflow-hidden border"
               style="border-color: var(--color-border)">
            <img x-show="!logoFailed"
                 src="{{ $logoUrl }}"
                 alt="{{ $experience->company }}"
                 x-on:error="logoFailed = true"
                 class="w-full h-full object-contain p-1 bg-white/90" />
            <div x-show="logoFailed"
                 class="w-full h-full flex items-center justify-center"
                 style="background: rgba(0,255,224,0.08)">
              <span class="font-display text-sm font-bold"
                    style="color: var(--color-neon)">
                {{ strtoupper(substr($experience->company, 0, 1)) }}
              </span>
            </div>
          </div>

          <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-2">
              <h3 class="font-display text-sm font-bold"
                  style="color: var(--color-text)">
                {{ $experience->role }}
              </h3>
              @if($experience->is_current)
                <span class="flex-shrink-0 text-xs px-1.5 py-0.5 rounded font-display"
                      style="background: rgba(0,255,224,0.1);
                             border: 1px solid rgba(0,255,224,0.3);
                             color: var(--color-neon)">
                  Now
                </span>
              @endif
            </div>
            <p class="text-xs font-display mt-0.5"
               style="color: var(--color-muted)">
              {{ $experience->company }}
            </p>
            <p class="text-xs font-display mt-1.5"
               style="color: rgba(100,116,139,0.7)">
              {{ $experience->start_date->format('M Y') }}
              —
              {{ $experience->is_current
                  ? 'Present'
                  : ($experience->end_date?->format('M Y') ?? '—') }}
            </p>
          </div>

        </div>
      @endforeach
    </div>

    <div class="mt-6 text-center sm:hidden">
      <a href="{{ route('about') }}"
         class="text-sm font-display"
         style="color: var(--color-neon)">
        Full work history →
      </a>
    </div>

  </section>
  @endif

  {{-- ════════════════════════════════════════════════════════
       SECTION 5: CONTACT CTA
       ════════════════════════════════════════════════════════ --}}
  <section class="border-t"
           style="border-color: var(--color-border)">
    <div class="max-w-4xl mx-auto px-6 py-24 text-center relative overflow-hidden">

      <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2
                    w-96 h-48 opacity-10 blur-3xl"
             style="background: radial-gradient(ellipse,
                    var(--color-neon), transparent 70%)">
        </div>
      </div>

      <div class="relative z-10">
        <p class="font-display text-xs tracking-widest uppercase mb-4"
           style="color: var(--color-neon)">
          // let's work together
        </p>
        <h2 class="font-display text-3xl md:text-5xl font-bold mb-6 leading-tight"
            style="color: var(--color-text)">
          Have a project in mind?
        </h2>
        <p class="max-w-lg mx-auto leading-relaxed mb-10"
           style="color: var(--color-muted)">
          I'm always open to discussing new projects, creative ideas,
          or opportunities to be part of something amazing.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">
          <a href="{{ route('contact') }}"
             class="inline-flex items-center gap-2 px-8 py-4 rounded-xl
                    font-display text-base font-bold tracking-wide
                    transition-all duration-200"
             style="background: var(--color-neon);
                    color: var(--color-bg);
                    box-shadow: 0 0 30px var(--color-neon-dim);"
             onmouseover="this.style.boxShadow='0 0 50px var(--color-neon-dim)'"
             onmouseout="this.style.boxShadow='0 0 30px var(--color-neon-dim)'">
            Start a Conversation
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
          </a>

          <a href="mailto:{{ config('mail.from.address') }}"
             class="inline-flex items-center gap-2 px-6 py-4 rounded-xl border
                    font-display text-sm font-medium tracking-wide
                    transition-all duration-200"
             style="border-color: var(--color-border); color: var(--color-text);"
             onmouseover="this.style.borderColor='rgba(0,255,224,0.4)';
                          this.style.color='var(--color-neon)'"
             onmouseout="this.style.borderColor='var(--color-border)';
                         this.style.color='var(--color-text)'">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2
                   0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Email Directly
          </a>
        </div>
      </div>

    </div>
  </section>

</x-layouts.app>
