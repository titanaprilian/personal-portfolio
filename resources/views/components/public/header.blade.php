<header
    x-data="{ mobileOpen: false }"
    class="sticky top-0 z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-800"
>
    <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="{{ Route::has('home') ? route('home') : '#' }}" class="font-display text-xl font-bold text-indigo-600 dark:text-indigo-400 no-underline">
            {{ config('app.name') }}
        </a>

        <div class="hidden lg:flex items-center gap-8">
            <x-public.nav-link href="{{ Route::has('home') ? route('home') : '#' }}" label="Home" />
            <x-public.nav-link href="{{ Route::has('projects.index') ? route('projects.index') : '#' }}" label="Projects" />
            <x-public.nav-link href="{{ Route::has('blog.index') ? route('blog.index') : '#' }}" label="Blog" />
            <x-public.nav-link href="{{ Route::has('about') ? route('about') : '#' }}" label="About" />
            <x-public.nav-link href="{{ Route::has('contact') ? route('contact') : '#' }}" label="Contact" />
            <x-public.dark-mode-toggle />
        </div>

        <div class="flex items-center gap-2 lg:hidden">
            <x-public.dark-mode-toggle />
            <button
                @click="mobileOpen = !mobileOpen"
                class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
            >
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </nav>

    <x-public.mobile-menu />
</header>
