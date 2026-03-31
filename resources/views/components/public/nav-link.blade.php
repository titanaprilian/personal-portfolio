@php
    $path = parse_url($href, PHP_URL_PATH);
    $path = ltrim($path, '/');
    $isActive = request()->is($path) || request()->is($path . '/*');
@endphp

<a
    href="{{ $href }}"
    class="text-xs tracking-widest uppercase font-medium transition-all duration-200 {{ $isActive ? 'text-indigo-600 dark:text-indigo-400 border-b border-indigo-600 dark:border-indigo-400' : 'text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400' }}"
>
    {{ $label }}
</a>
