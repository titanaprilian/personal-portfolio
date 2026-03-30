<x-layouts.app title="Too Many Requests — {{ config('app.name') }}">
    <div class="min-h-[60vh] flex items-center justify-center px-6 pt-20 pb-24">
        <div class="max-w-md w-full text-center" style="animation: fadeSlideUp 0.5s ease both">
            <p class="font-display text-[--color-neon] text-xs tracking-widest uppercase mb-3">
                // error 429
            </p>
            <h1 class="font-display text-5xl md:text-6xl font-bold text-[--color-text] leading-tight mb-6">
                Slow Down
            </h1>
            <p class="text-[--color-muted] leading-relaxed mb-10 text-lg">
                You've made too many requests. Please wait a moment before trying again.
            </p>
            <a href="{{ route('home') }}" 
               class="inline-block px-8 py-3.5 rounded-xl font-display text-sm font-bold tracking-widest uppercase transition-all duration-200"
               style="background: var(--color-neon); color: var(--color-bg); box-shadow: 0 0 20px var(--color-neon-dim)"
               onmouseover="this.style.boxShadow='0 0 35px var(--color-neon-dim)'"
               onmouseout="this.style.boxShadow='0 0 20px var(--color-neon-dim)'">
                Back to Home
            </a>
        </div>
    </div>
</x-layouts.app>
