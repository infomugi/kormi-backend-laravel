@props([
    'name' => null,
    'type' => 'text',
    'hasIcon' => false,
    'icon' => null,
    'size' => 'default', // 'sm', 'default', 'lg'
    'clearable' => false,
    'prefix' => null,
    'suffix' => null,
])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-xs rounded-xl',
        'default' => 'px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm rounded-xl sm:rounded-2xl',
        'lg' => 'px-4 sm:px-5 py-3 sm:py-4 text-sm sm:text-base lg:text-lg font-extrabold rounded-xl sm:rounded-2xl',
    ][$size] ?? 'px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm rounded-xl sm:rounded-2xl';

    $paddingLeft = ($icon || $hasIcon) ? ($size === 'lg' ? 'pl-11 sm:pl-12' : 'pl-10') : '';
    $paddingRight = $clearable ? 'pr-9' : '';
@endphp

<div class="relative w-full group">
    @if($icon)
        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-600 pointer-events-none z-10 flex items-center justify-center transition-colors">
            <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
        </div>
    @endif

    <div class="flex items-center w-full">
        @if($prefix)
            <span class="inline-flex items-center px-3 text-xs font-bold text-slate-500 bg-slate-100/80 border border-r-0 border-slate-200 rounded-l-xl select-none">
                {{ $prefix }}
            </span>
        @endif

        <input 
            type="{{ $type }}"
            @if($name) name="{{ $name }}" id="{{ $name }}" @endif
            {{ $attributes->merge([
                'class' => "w-full bg-slate-50/70 hover:bg-slate-100/60 focus:bg-white border border-slate-200 focus:border-emerald-600 focus:ring-3 focus:ring-emerald-600/15 focus:outline-none text-slate-900 font-medium placeholder:font-normal placeholder:text-slate-400 shadow-2xs transition-all duration-200 {$sizeClasses} {$paddingLeft} {$paddingRight} " . ($prefix ? 'rounded-l-none' : '') . ($suffix ? 'rounded-r-none' : '')
            ]) }}
        >

        @if($suffix)
            <span class="inline-flex items-center px-3 text-xs font-bold text-slate-500 bg-slate-100/80 border border-l-0 border-slate-200 rounded-r-xl select-none">
                {{ $suffix }}
            </span>
        @endif
    </div>
</div>
