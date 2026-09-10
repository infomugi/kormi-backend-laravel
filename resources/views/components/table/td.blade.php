@props([
    'align' => 'left',
    'compact' => false,
])

@php
    $alignClass = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };

    $paddingClass = $compact ? 'px-3.5 sm:px-4 py-2.5 sm:py-3' : 'px-4 sm:px-5 py-3 sm:py-3.5';
@endphp

<td {{ $attributes->merge(['class' => "{$paddingClass} {$alignClass} text-slate-600 align-middle"]) }}>
    {{ $slot }}
</td>
