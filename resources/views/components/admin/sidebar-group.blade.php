<div x-data="{ open: true }">
    <button
        @click="open = !open"
        class="flex w-full items-center justify-between px-4 py-2 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
    >
        <span>{{ $label }}</span>
        <svg
            :class="open ? 'rotate-180' : ''"
            class="h-4 w-4 transition-transform"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div x-show="open" x-transition class="mt-1 space-y-1">
        {{ $slot }}
    </div>
</div>
