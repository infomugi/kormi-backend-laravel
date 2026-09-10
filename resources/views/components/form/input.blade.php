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
    $hasLeadingIcon = ($icon || $hasIcon);

    $heightAndText = match($size) {
        'sm' => 'py-1.5 text-xs rounded-xl',
        'lg' => 'py-3 sm:py-4 text-sm sm:text-base lg:text-lg font-extrabold rounded-xl sm:rounded-2xl',
        default => 'py-2.5 sm:py-3 text-xs sm:text-sm rounded-xl sm:rounded-2xl',
    };

    // Left padding based on icon presence
    if ($hasLeadingIcon) {
        $padLeft = match($size) {
            'sm' => 'pl-9',
            'lg' => 'pl-12 sm:pl-14',
            default => 'pl-11 sm:pl-12',
        };
    } else {
        $padLeft = match($size) {
            'sm' => 'pl-3',
            'lg' => 'pl-4 sm:pl-5',
            default => 'pl-3.5 sm:pl-4',
        };
    }

    // Right padding based on clearable / size
    if ($clearable) {
        $padRight = 'pr-9 sm:pr-10';
    } else {
        $padRight = match($size) {
            'sm' => 'pr-3',
            'lg' => 'pr-4 sm:pr-5',
            default => 'pr-3.5 sm:pr-4',
        };
    }
@endphp

<div class="relative w-full group">
    @if($icon)
        <div class="absolute left-3.5 sm:left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-600 pointer-events-none z-10 flex items-center justify-center transition-colors">
            <i data-lucide="{{ $icon }}" class="{{ $size === 'lg' ? 'w-5 h-5' : ($size === 'sm' ? 'w-3.5 h-3.5' : 'w-4 h-4') }}"></i>
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
                'class' => "w-full bg-slate-50/70 hover:bg-slate-100/60 focus:bg-white border border-slate-200 focus:border-emerald-600 focus:ring-3 focus:ring-emerald-600/15 focus:outline-none text-slate-900 font-medium placeholder:font-normal placeholder:text-slate-400 shadow-2xs transition-all duration-200 {$heightAndText} {$padLeft} {$padRight} " . ($prefix ? 'rounded-l-none' : '') . ($suffix ? 'rounded-r-none' : '')
            ]) }}
        >

        @if($suffix)
            <span class="inline-flex items-center px-3 text-xs font-bold text-slate-500 bg-slate-100/80 border border-l-0 border-slate-200 rounded-r-xl select-none">
                {{ $suffix }}
            </span>
        @endif
    </div>
</div>
