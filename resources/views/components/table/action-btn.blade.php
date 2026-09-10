@props([
    'variant' => 'default', // default, success, danger, warning, info
    'size' => 'md', // sm, md
    'icon' => null,
    'loadingTarget' => null,
])

@php
    $variants = [
        'default' => 'bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 border-slate-200/80',
        'indigo'  => 'bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white border-indigo-100 shadow-2xs',
        'success' => 'bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white border-emerald-100 shadow-2xs',
        'danger'  => 'bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border-rose-100 shadow-2xs',
        'warning' => 'bg-amber-50 hover:bg-amber-600 text-amber-700 hover:text-white border-amber-100 shadow-2xs',
        'info'    => 'bg-cyan-50 hover:bg-cyan-600 text-cyan-700 hover:text-white border-cyan-100 shadow-2xs',
    ];

    $sizes = [
        'sm' => 'p-1.5 rounded-lg text-xs',
        'md' => 'p-2 rounded-xl text-xs',
        'pill' => 'px-3 py-1.5 rounded-xl text-xs font-bold gap-1.5',
    ];

    $varClass = $variants[$variant] ?? $variants['default'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->merge(['class' => "relative inline-flex items-center justify-center border transition-all duration-150 cursor-pointer active:scale-95 disabled:opacity-50 {$varClass} {$sizeClass}"]) }}>
        @if($loadingTarget)
            <span wire:loading.delay.shorter wire:target="{{ $loadingTarget }}" class="inline-block w-3.5 h-3.5 border-2 border-current border-t-transparent rounded-full animate-spin shrink-0"></span>
        @endif
        @if($icon)
            <i @if($loadingTarget) wire:loading.remove wire:target="{{ $loadingTarget }}" @endif data-lucide="{{ $icon }}" class="w-4 h-4 shrink-0"></i>
        @endif
        @if($slot->isNotEmpty())
            <span>{{ $slot }}</span>
        @endif
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => "relative inline-flex items-center justify-center border transition-all duration-150 cursor-pointer active:scale-95 disabled:opacity-50 {$varClass} {$sizeClass}"]) }}>
        @if($loadingTarget)
            <span wire:loading.delay.shorter wire:target="{{ $loadingTarget }}" class="inline-block w-3.5 h-3.5 border-2 border-current border-t-transparent rounded-full animate-spin shrink-0"></span>
        @endif
        @if($icon)
            <i @if($loadingTarget) wire:loading.remove wire:target="{{ $loadingTarget }}" @endif data-lucide="{{ $icon }}" class="w-4 h-4 shrink-0"></i>
        @endif
        @if($slot->isNotEmpty())
            <span>{{ $slot }}</span>
        @endif
    </button>
@endif
