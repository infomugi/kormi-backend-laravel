@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'iconColor' => 'text-emerald-600',
    'iconBg' => 'bg-emerald-500/10 border-emerald-500/20',
    'badge' => null,
    'badgeColor' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
    'headerActions' => null,
    'noPadding' => false,
    'hoverEffect' => true,
    'variant' => 'default', // 'default', 'subtle', 'accent'
    'size' => 'compact', // 'compact', 'default'
])

@php
    $variantBorder = [
        'default' => 'border-slate-200/80 hover:border-slate-300',
        'subtle' => 'border-slate-100 bg-slate-50/50',
        'accent' => 'border-emerald-500/30 ring-1 ring-emerald-500/10',
    ][$variant] ?? 'border-slate-200/80 hover:border-slate-300';

    $paddingClasses = $size === 'compact'
        ? 'p-3.5 sm:p-5 space-y-3 sm:space-y-4'
        : 'p-4 sm:p-6 lg:p-7 space-y-4 sm:space-y-5';

    $headerPadding = $size === 'compact'
        ? 'px-3.5 py-2.5 sm:px-5 sm:py-3'
        : 'px-4 py-3 sm:px-6 sm:py-3.5';
@endphp

<div {{ $attributes->merge(['class' => "bg-white border {$variantBorder} rounded-xl sm:rounded-2xl shadow-[0_2px_12px_-2px_rgba(0,0,0,0.04)] transition-all duration-200 relative " . ($hoverEffect ? 'hover:shadow-[0_8px_20px_-4px_rgba(0,0,0,0.07)]' : '')]) }}>
    @if($title || $headerActions || $badge || $icon)
        <div class="{{ $headerPadding }} border-b border-slate-100 rounded-t-xl sm:rounded-t-2xl flex flex-wrap items-center justify-between gap-2 bg-gradient-to-r from-slate-50/70 via-white to-slate-50/40">
            <div class="flex items-center gap-2 min-w-0">
                @if($icon)
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl {{ $iconBg }} border flex items-center justify-center shrink-0 shadow-2xs">
                        <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 sm:w-4 sm:h-4 {{ $iconColor }}"></i>
                    </div>
                @endif
                <div class="min-w-0">
                    <div class="flex items-center gap-1.5">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider truncate">
                            {{ $title }}
                        </h3>
                        @if($badge)
                            <span class="px-1.5 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider border {{ $badgeColor }}">
                                {{ $badge }}
                            </span>
                        @endif
                    </div>
                    @if($subtitle)
                        <p class="text-[10px] text-slate-400 truncate">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>

            @if($headerActions)
                <div class="flex items-center gap-1.5 shrink-0">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $noPadding ? '' : $paddingClasses }}">
        {{ $slot }}
    </div>
</div>
