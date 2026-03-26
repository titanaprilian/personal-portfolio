@props(['text' => ''])

<div x-data="{ show: false }" class="relative inline-flex" @click.outside="show = false">
    <button
        type="button"
        @mouseenter="show = true"
        @mouseleave="show = false"
        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors focus:outline-none"
    >
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </button>

    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute z-[100] w-64 px-3 py-2 text-sm text-gray-700 bg-white dark:text-gray-200 dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 normal-case"
        style="top: 100%; left: 50%; transform: translateX(-50%); margin-top: 8px; display: none;"
        @mouseenter="show = true"
        @mouseleave="show = false"
    >
        {{ $text }}
    </div>
</div>
