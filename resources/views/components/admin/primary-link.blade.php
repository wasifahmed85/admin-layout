@props([
    'href' => 'javascript:void(0)',
    'target' => '_self',
    'secondary' => false,
    'disabled' => false,
])

@php
    $classes = collect([
        'inline-flex items-center px-4 py-2 text-sm font-medium uppercase tracking-wide rounded-sm shadow-sm transition-colors duration-200',
        $disabled 
            ? 'bg-gray-400 text-white cursor-not-allowed pointer-events-none' 
            : ($secondary 
                ? 'bg-orange-600 hover:bg-red-700 text-white' 
                : 'bg-blue-600 hover:bg-blue-700 text-white'),
    ])->filter()->implode(' ');
@endphp

<a
    href="{{ $href }}"
    target="{{ $target }}"
    {{ $disabled ? 'aria-disabled=true' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</a>
