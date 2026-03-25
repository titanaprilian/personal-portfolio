@props(['name', 'value' => ''])

<div
    x-data="iconPicker('{{ $name }}', '{{ $value }}')"
    x-init="initFromDataAttribute()"
    x-effect="checkForExternalUpdate()"
    class="relative"
>
    <input type="hidden" :name="name" :value="selectedSlug">

    <button
        type="button"
        @click="open = !open"
        class="flex items-center gap-3 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-indigo-400 transition-colors w-full"
    >
        <template x-if="selectedSlug">
            <img
                :src="`https://cdn.simpleicons.org/${selectedSlug}`"
                class="w-6 h-6 object-contain"
                :alt="selectedTitle"
            >
        </template>
        <template x-if="!selectedSlug">
            <div class="w-6 h-6 rounded bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                <span class="text-gray-400 text-xs">?</span>
            </div>
        </template>
        <span class="text-sm text-gray-700 dark:text-gray-300 flex-1 text-left">
            <span x-text="selectedTitle || 'Select an icon'"></span>
        </span>
        <span class="text-gray-400 text-xs" x-text="open ? '▲' : '▼'"></span>
    </button>

    <template x-if="selectedSlug">
        <button
            type="button"
            @click.stop="selectedSlug = ''; selectedTitle = ''"
            class="absolute right-8 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 text-xs px-1"
            title="Clear icon"
        >✕</button>
    </template>

    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute z-50 mt-1 w-full min-w-72 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-xl"
        style="display: none"
    >
        <div class="p-3 border-b border-gray-100 dark:border-gray-700">
            <input
                type="text"
                x-model.debounce.300ms="search"
                placeholder="Search icons... (e.g. laravel, docker)"
                class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                @keydown.escape="open = false"
            >
        </div>

        <div x-show="loading" class="p-6 text-center text-sm text-gray-400">
            Loading icons...
        </div>

        <div
            x-show="!loading"
            class="grid grid-cols-6 gap-1 p-3 max-h-64 overflow-y-auto"
        >
            <template x-for="icon in filteredIcons.slice(0, 60)" :key="icon.slug">
                <button
                    type="button"
                    @click="selectIcon(icon)"
                    :title="icon.title"
                    :class="selectedSlug === icon.slug
                        ? 'ring-2 ring-indigo-500 bg-indigo-50 dark:bg-indigo-900/30'
                        : 'hover:bg-gray-100 dark:hover:bg-gray-800'"
                    class="flex flex-col items-center justify-center p-2 rounded-lg transition-colors gap-1"
                >
                    <img
                        :src="`https://cdn.simpleicons.org/${icon.slug}`"
                        :alt="icon.title"
                        class="w-6 h-6 object-contain"
                        loading="lazy"
                        @{{ $el.style.opacity = '0.2' }}
                    >
                    <span class="text-gray-500 dark:text-gray-400 text-[10px] truncate w-full text-center"
                        x-text="icon.title"></span>
                </button>
            </template>

            <div
                x-show="filteredIcons.length === 0 && !loading"
                class="col-span-6 py-6 text-center text-sm text-gray-400"
            >
                No icons found for "<span x-text="search"></span>"
            </div>
        </div>

        <div class="px-3 py-2 border-t border-gray-100 dark:border-gray-700 text-xs text-gray-400 text-right">
            Showing <span x-text="Math.min(filteredIcons.length, 60)"></span>
            of <span x-text="filteredIcons.length"></span> results
        </div>
    </div>
</div>
