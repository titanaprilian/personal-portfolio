<div class="flex h-16 items-center justify-center border-b border-gray-200 dark:border-gray-700 px-4">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gray-800 dark:text-gray-100">
        {{ config('app.name') }}
    </a>
    <button
        @click="sidebarOpen = false"
        class="absolute left-4 top-4 lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
    >
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
