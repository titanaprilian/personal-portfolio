<div
    x-show="mobileOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="lg:hidden bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800"
>
    <div class="px-6 py-4 space-y-1">
        <a
            href="{{ Route::has('home') ? route('home') : '#' }}"
            @click="mobileOpen = false"
            class="block py-3 px-6 text-sm tracking-widest uppercase font-medium transition-colors {{ request()->is('/') || request()->is('') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400' }}"
        >
            Home
        </a>
        <a
            href="{{ Route::has('projects.index') ? route('projects.index') : '#' }}"
            @click="mobileOpen = false"
            class="block py-3 px-6 text-sm tracking-widest uppercase font-medium transition-colors {{ request()->is('projects*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400' }}"
        >
            Projects
        </a>
        <a
            href="{{ Route::has('blog.index') ? route('blog.index') : '#' }}"
            @click="mobileOpen = false"
            class="block py-3 px-6 text-sm tracking-widest uppercase font-medium transition-colors {{ request()->is('blog*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400' }}"
        >
            Blog
        </a>
        <a
            href="{{ Route::has('about') ? route('about') : '#' }}"
            @click="mobileOpen = false"
            class="block py-3 px-6 text-sm tracking-widest uppercase font-medium transition-colors {{ request()->is('about') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400' }}"
        >
            About
        </a>
        <a
            href="{{ Route::has('contact') ? route('contact') : '#' }}"
            @click="mobileOpen = false"
            class="block py-3 px-6 text-sm tracking-widest uppercase font-medium transition-colors {{ request()->is('contact') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400' }}"
        >
            Contact
        </a>
    </div>
</div>