<div
    x-show="mobileOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="lg:hidden bg-[--color-surface] border-b border-[--color-border]"
>
    <div class="px-6 py-4 space-y-1">
        <a
            href="{{ Route::has('home') ? route('home') : '#' }}"
            @click="mobileOpen = false"
            class="block py-3 px-6 text-sm tracking-widest uppercase font-medium transition-colors {{ request()->is('/') || request()->is('') ? 'text-[--color-neon]' : 'text-[--color-muted] hover:text-[--color-neon]' }}"
        >
            Home
        </a>
        <a
            href="{{ Route::has('projects.index') ? route('projects.index') : '#' }}"
            @click="mobileOpen = false"
            class="block py-3 px-6 text-sm tracking-widest uppercase font-medium transition-colors {{ request()->is('projects*') ? 'text-[--color-neon]' : 'text-[--color-muted] hover:text-[--color-neon]' }}"
        >
            Projects
        </a>
        <a
            href="{{ Route::has('blog.index') ? route('blog.index') : '#' }}"
            @click="mobileOpen = false"
            class="block py-3 px-6 text-sm tracking-widest uppercase font-medium transition-colors {{ request()->is('blog*') ? 'text-[--color-neon]' : 'text-[--color-muted] hover:text-[--color-neon]' }}"
        >
            Blog
        </a>
        <a
            href="{{ Route::has('about') ? route('about') : '#' }}"
            @click="mobileOpen = false"
            class="block py-3 px-6 text-sm tracking-widest uppercase font-medium transition-colors {{ request()->is('about') ? 'text-[--color-neon]' : 'text-[--color-muted] hover:text-[--color-neon]' }}"
        >
            About
        </a>
        <a
            href="{{ Route::has('contact') ? route('contact') : '#' }}"
            @click="mobileOpen = false"
            class="block py-3 px-6 text-sm tracking-widest uppercase font-medium transition-colors {{ request()->is('contact') ? 'text-[--color-neon]' : 'text-[--color-muted] hover:text-[--color-neon]' }}"
        >
            Contact
        </a>
    </div>
</div>
