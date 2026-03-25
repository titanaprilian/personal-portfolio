@php
    $path = parse_url($href, PHP_URL_PATH);
    $path = ltrim($path, '/');
    $isActive = request()->is($path) || request()->is($path . '/*');
@endphp

<a
    href="{{ $href }}"
    class="text-xs tracking-widest uppercase font-medium transition-all duration-200 {{ $isActive ? 'text-[--color-neon] border-b border-[--color-neon]' : 'text-[--color-muted] hover:text-[--color-neon]' }}"
    @if($isActive)
        style="text-shadow: 0 0 10px rgba(0,255,224,0.5);"
    @endif
>
    {{ $label }}
</a>
