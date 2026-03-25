@props(['title' => '', 'height' => 'h-48'])

<div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 shadow-sm">
    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
        {{ $title }}
    </h3>
    <div class="{{ $height }}">
        {{ $slot }}
    </div>
</div>
