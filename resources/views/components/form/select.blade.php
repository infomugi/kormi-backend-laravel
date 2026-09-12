@props([
    'name' => null,
    'size' => 'default', // 'sm', 'default', 'lg'
])

@php
    $sizeClasses = [
        'sm' => 'py-1.5 pl-3 pr-8 text-xs rounded-xl',
        'default' => 'py-2.5 sm:py-3 pl-3.5 sm:pl-4 pr-10 text-xs sm:text-sm font-bold rounded-xl sm:rounded-2xl',
        'lg' => 'py-3 sm:py-4 pl-4 sm:pl-5 pr-11 text-sm sm:text-base font-extrabold rounded-xl sm:rounded-2xl',
    ][$size] ?? 'py-2.5 sm:py-3 pl-3.5 sm:pl-4 pr-10 text-xs sm:text-sm font-bold rounded-xl sm:rounded-2xl';
@endphp

<div class="relative w-full group">
    <select 
        @if($name) name="{{ $name }}" id="{{ $name }}" @endif
        {{ $attributes->merge([
            'class' => "w-full appearance-none bg-slate-50/70 hover:bg-slate-100/60 focus:bg-white border border-slate-200 focus:border-emerald-600 focus:ring-3 focus:ring-emerald-600/15 focus:outline-none text-slate-900 font-bold transition-all duration-200 cursor-pointer shadow-2xs {$sizeClasses}"
        ]) }}
    >
        {{ $slot }}
    </select>

    <!-- Custom Select Chevron Arrow -->
    <div class="absolute right-3.5 sm:right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-hover:text-slate-600 group-focus-within:text-emerald-600 transition-colors flex items-center justify-center">
        <i data-lucide="chevron-down" class="w-4 h-4"></i>
    </div>
</div>

