<div class="border-t border-gray-200 dark:border-gray-700 p-4">
    @auth
        <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-gray-800 dark:text-gray-200">
                    {{ auth()->user()->name }}
                </p>
                <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                    {{ auth()->user()->email }}
                </p>
            </div>
        </div>
    @endauth
</div>
