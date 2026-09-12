@props([
    'name' => null,
    'rows' => 3,
    'size' => 'default', // 'sm', 'default', 'lg'
])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-2 text-xs rounded-xl',
        'default' => 'px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm rounded-xl sm:rounded-2xl',
        'lg' => 'px-4 sm:px-5 py-3 sm:py-4 text-sm sm:text-base font-bold rounded-xl sm:rounded-2xl',
    ][$size] ?? 'px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm rounded-xl sm:rounded-2xl';
@endphp

<textarea 
    @if($name) name="{{ $name }}" id="{{ $name }}" @endif
    rows="{{ $rows }}"
    {{ $attributes->merge([
        'class' => "w-full bg-slate-50/70 hover:bg-slate-100/60 focus:bg-white border border-slate-200 focus:border-emerald-600 focus:ring-3 focus:ring-emerald-600/15 focus:outline-none text-slate-900 font-medium placeholder:font-normal placeholder:text-slate-400 shadow-2xs transition-all duration-200 leading-relaxed {$sizeClasses}"
    ]) }}
></textarea>

