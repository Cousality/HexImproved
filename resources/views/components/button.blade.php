@props([
    'href' => null,
    'method' => 'GET',
    'type' => 'button',
    'variant' => 'primary',
    'size' => null,
])

@php
    $method = strtoupper($method);

    $classes = collect(['hexed-button', "hexed-button--{$variant}", $size ? "hexed-button--{$size}" : null])
        ->filter()
        ->implode(' ');
@endphp

@if ($href && $method !== 'GET')
    <form action="{{ $href }}" method="POST">
        @csrf

        @if ($method !== 'POST')
            @method($method)
        @endif

        <button type="submit" {{ $attributes->class($classes) }}>
            {{ $slot }}
        </button>
    </form>
@elseif ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </button>
@endif
