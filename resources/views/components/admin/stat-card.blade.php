@props([
    'label' => '',
    'value' => 0,
    'color' => 'indigo',
    'href' => null,
    'sub' => null,
])

@php
    $colorMap = [
        'indigo' => ['bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'icon' => 'text-indigo-600 dark:text-indigo-400', 'ring' => 'ring-indigo-100 dark:ring-indigo-800'],
        'violet' => ['bg' => 'bg-violet-50 dark:bg-violet-900/20', 'icon' => 'text-violet-600 dark:text-violet-400', 'ring' => 'ring-violet-100 dark:ring-violet-800'],
        'emerald' => ['bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 'icon' => 'text-emerald-600 dark:text-emerald-400', 'ring' => 'ring-emerald-100 dark:ring-emerald-800'],
        'amber' => ['bg' => 'bg-amber-50 dark:bg-amber-900/20', 'icon' => 'text-amber-600 dark:text-amber-400', 'ring' => 'ring-amber-100 dark:ring-amber-800'],
        'rose' => ['bg' => 'bg-rose-50 dark:bg-rose-900/20', 'icon' => 'text-rose-600 dark:text-rose-400', 'ring' => 'ring-rose-100 dark:ring-rose-800'],
        'sky' => ['bg' => 'bg-sky-50 dark:bg-sky-900/20', 'icon' => 'text-sky-600 dark:text-sky-400', 'ring' => 'ring-sky-100 dark:ring-sky-800'],
    ];
    $c = $colorMap[$color] ?? $colorMap['indigo'];
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    {{ $href ? "href={$href}" : '' }}
    class="group flex items-center gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 shadow-sm {{ $href ? 'hover:border-indigo-300 dark:hover:border-indigo-700 transition-colors cursor-pointer' : '' }}"
>
    <div class="flex-shrink-0 w-12 h-12 rounded-xl {{ $c['bg'] }} ring-1 {{ $c['ring'] }} flex items-center justify-center">
        <div class="{{ $c['icon'] }} w-6 h-6">
            {{ $slot }}
        </div>
    </div>

    <div class="min-w-0 flex-1">
        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide truncate">
            {{ $label }}
        </p>
        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-0.5 tabular-nums">
            {{ number_format($value) }}
        </p>
        @if($sub)
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 truncate">
                {{ $sub }}
            </p>
        @endif
    </div>
</{{ $tag }}>
