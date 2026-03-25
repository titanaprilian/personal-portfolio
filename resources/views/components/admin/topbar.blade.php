<header class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-6 dark:bg-gray-900 dark:border-gray-700">
    <div class="flex items-center gap-4">
        <button
            @click="sidebarOpen = true"
            class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
        >
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            {{ $title ?? 'Admin' }}
        </h2>
    </div>

    <div class="flex items-center gap-4">
        <x-admin.dark-mode-toggle />

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-500 transition-colors"
            >
                Logout
            </button>
        </form>
    </div>
</header>
