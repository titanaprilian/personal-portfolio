<x-layouts.app title="Message Sent — {{ config('app.name') }}">

  <div class="min-h-[70vh] flex items-center justify-center px-6">
    <div class="max-w-lg w-full text-center"
         style="animation: fadeSlideUp 0.6s ease both">

      <div class="w-20 h-20 rounded-full mx-auto mb-8 flex items-center
                  justify-center relative"
           style="background: rgba(0,255,224,0.08);
                  border: 1px solid rgba(0,255,224,0.3);
                  box-shadow: 0 0 40px rgba(0,255,224,0.15)">
        <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24"
             stroke="currentColor"
             style="color: var(--color-neon)">
          <path stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <div class="absolute inset-0 rounded-full animate-ping opacity-20"
             style="border: 1px solid var(--color-neon)"></div>
      </div>

      <p class="font-display text-[--color-neon] text-xs tracking-widest
                uppercase mb-4">
        // message received
      </p>
      <h1 class="font-display text-3xl md:text-4xl font-bold
                 text-[--color-text] mb-4">
        Thanks for reaching out!
      </h1>
      <p class="text-[--color-muted] leading-relaxed mb-10">
        Your message has been received and I'll get back to you
        as soon as possible. In the meantime, feel free to explore
        more of my work.
      </p>

      <div class="flex flex-wrap items-center justify-center gap-3">
        <a href="{{ route('projects.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                  font-display text-sm font-medium tracking-wide
                  text-[--color-bg] transition-all duration-200"
           style="background: var(--color-neon);
                  box-shadow: 0 0 20px var(--color-neon-dim);">
          View Projects
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
          </svg>
        </a>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                  border font-display text-sm font-medium tracking-wide
                  text-[--color-text] hover:text-[--color-neon] transition-all duration-200"
           style="border-color: var(--color-border)">
          Back to Home
        </a>
      </div>

    </div>
  </div>

</x-layouts.app>
