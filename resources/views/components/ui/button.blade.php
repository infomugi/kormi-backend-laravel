@props([
    'variant' => 'primary', // 'primary', 'secondary', 'draft', 'danger', 'ghost', 'emerald', 'outline'
    'size' => 'default', // 'sm', 'default', 'lg'
    'icon' => null,
    'iconPosition' => 'left', // 'left', 'right'
    'href' => null,
    'target' => null,
    'loadingTarget' => null,
    'type' => 'button',
])

@php
    $variantClasses = [
        'primary' => 'bg-gradient-to-r from-lime-400 via-emerald-400 to-teal-400 hover:brightness-105 text-emerald-950 font-black shadow-[0_4px_14px_rgba(16,185,129,0.35)] hover:shadow-[0_6px_20px_rgba(16,185,129,0.45)] border border-lime-300/40',
        'emerald' => 'bg-emerald-600 hover:bg-emerald-700 text-white font-black shadow-md shadow-emerald-600/25 border-emerald-500/30',
        'secondary' => 'bg-slate-100 hover:bg-slate-200/90 text-slate-700 font-bold border border-slate-200/60 shadow-2xs',
        'draft' => 'bg-gradient-to-r from-amber-50 to-orange-50/70 hover:from-amber-100 hover:to-orange-100 text-amber-950 border border-amber-300/80 font-extrabold shadow-2xs',
        'danger' => 'bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold shadow-2xs',
        'ghost' => 'bg-white/10 hover:bg-white/20 text-white font-bold border border-white/20 backdrop-blur-xs shadow-2xs',
        'outline' => 'bg-transparent hover:bg-slate-100 text-slate-700 border border-slate-300 font-bold',
    ][$variant] ?? 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold';

    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-[11px] rounded-lg sm:rounded-xl gap-1.5',
        'default' => 'px-4 sm:px-5 py-2 sm:py-2.5 text-xs uppercase tracking-wider rounded-xl sm:rounded-2xl gap-1.5 sm:gap-2',
        'lg' => 'px-6 sm:px-8 py-2.5 sm:py-3 text-xs uppercase tracking-wider rounded-xl sm:rounded-2xl gap-2 font-black',
    ][$size] ?? 'px-4 sm:px-5 py-2 sm:py-2.5 text-xs uppercase tracking-wider rounded-xl sm:rounded-2xl gap-1.5 sm:gap-2';
@endphp

@if($href)
    <a 
        href="{{ $href }}"
        @if($target) target="{{ $target }}" @endif
        {{ $attributes->merge([
            'class' => "inline-flex items-center justify-center transition-all duration-200 cursor-pointer active:scale-95 disabled:opacity-50 disabled:pointer-events-none select-none {$variantClasses} {$sizeClasses}"
        ]) }}
    >
        @if($icon && $iconPosition === 'left')
            <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0"></i>
        @endif

        <span>{{ $slot }}</span>

        @if($icon && $iconPosition === 'right')
            <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0"></i>
        @endif
    </a>
@else
    <button 
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' => "inline-flex items-center justify-center transition-all duration-200 cursor-pointer active:scale-95 disabled:opacity-50 disabled:pointer-events-none select-none {$variantClasses} {$sizeClasses}"
        ]) }}
    >
        @if($loadingTarget)
            <span wire:loading.remove wire:target="{{ $loadingTarget }}" class="inline-flex items-center gap-1.5 sm:gap-2">
                @if($icon && $iconPosition === 'left')
                    <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0"></i>
                @endif

                <span>{{ $slot }}</span>

                @if($icon && $iconPosition === 'right')
                    <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0"></i>
                @endif
            </span>
            <span wire:loading.flex wire:target="{{ $loadingTarget }}" class="items-center gap-1.5">
                <i data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i>
                <span>Memproses...</span>
            </span>
        @else
            @if($icon && $iconPosition === 'left')
                <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0"></i>
            @endif

            <span>{{ $slot }}</span>

            @if($icon && $iconPosition === 'right')
                <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0"></i>
            @endif
        @endif
    </button>
@endif
