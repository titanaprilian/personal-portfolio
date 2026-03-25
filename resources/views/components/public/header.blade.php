<header
    x-data="{ mobileOpen: false }"
    class="sticky top-0 z-50 bg-[--color-bg]/90 backdrop-blur-md border-b border-[--color-border]"
    style="box-shadow: 0 1px 0 0 rgba(0,255,224,0.15);"
>
    <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="{{ Route::has('home') ? route('home') : '#' }}" class="font-display text-xl font-bold text-[--color-neon] no-underline">
            {{ config('app.name') }}
        </a>

        <div class="hidden lg:flex items-center gap-8">
            <x-public.nav-link href="{{ Route::has('home') ? route('home') : '#' }}" label="Home" />
            <x-public.nav-link href="{{ Route::has('projects.index') ? route('projects.index') : '#' }}" label="Projects" />
            <x-public.nav-link href="{{ Route::has('blog.index') ? route('blog.index') : '#' }}" label="Blog" />
            <x-public.nav-link href="{{ Route::has('about') ? route('about') : '#' }}" label="About" />
            <x-public.nav-link href="{{ Route::has('contact') ? route('contact') : '#' }}" label="Contact" />
        </div>

        <button
            @click="mobileOpen = !mobileOpen"
            class="lg:hidden text-[--color-muted] hover:text-[--color-neon] transition-colors"
        >
            <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </nav>

    <x-public.mobile-menu />
</header>
