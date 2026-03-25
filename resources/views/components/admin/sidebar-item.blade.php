@php
    $isActive = request()->url() === $href;
@endphp

<a
    href="{{ $href }}"
    class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg mx-2 transition-colors {{ $isActive ? 'bg-indigo-50 text-indigo-600 font-medium dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
>
    @if(isset($icon))
        {!! $icon !!}
    @endif
    {{ $label }}
    @if(isset($badge) && $badge > 0)
        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
            {{ $badge }}
        </span>
    @endif
</a>
