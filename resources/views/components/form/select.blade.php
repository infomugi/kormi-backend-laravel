@props([
    'name' => null,
    'size' => 'default', // 'sm', 'default'
])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-xs rounded-xl',
        'default' => 'px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs font-bold rounded-xl sm:rounded-2xl',
    ][$size] ?? 'px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs font-bold rounded-xl sm:rounded-2xl';
@endphp

<select 
    @if($name) name="{{ $name }}" id="{{ $name }}" @endif
    {{ $attributes->merge([
        'class' => "w-full bg-slate-50/80 border border-slate-200 text-slate-900 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 transition-all duration-200 cursor-pointer {$sizeClasses}"
    ]) }}
>
    {{ $slot }}
</select>
