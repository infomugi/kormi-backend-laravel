@props([
    'title' => '',
    'value' => '0',
    'unit' => '',
    'subtitle' => '',
    'icon' => 'bar-chart-2',
    'color' => 'indigo', // indigo, emerald, amber, cyan, rose, slate
    'active' => false,
    'pulse' => false,
    'loadingTarget' => null,
])

@php
    $colorMap = [
        'indigo' => [
            'iconBg' => 'bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white',
            'valueText' => 'text-slate-900',
            'activeBorder' => 'border-indigo-500/90 ring-1 ring-indigo-500/20 bg-indigo-50/30',
            'hoverBorder' => 'hover:border-indigo-300 hover:shadow-sm',
            'pulse' => 'bg-indigo-500',
            'accent' => 'bg-indigo-600',
        ],
        'emerald' => [
            'iconBg' => 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white',
            'valueText' => 'text-emerald-700',
            'activeBorder' => 'border-emerald-500/90 ring-1 ring-emerald-500/20 bg-emerald-50/30',
            'hoverBorder' => 'hover:border-emerald-300 hover:shadow-sm',
            'pulse' => 'bg-emerald-500',
            'accent' => 'bg-emerald-600',
        ],
        'amber' => [
            'iconBg' => 'bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white',
            'valueText' => 'text-amber-700',
            'activeBorder' => 'border-amber-500/90 ring-1 ring-amber-500/20 bg-amber-50/30',
            'hoverBorder' => 'hover:border-amber-300 hover:shadow-sm',
            'pulse' => 'bg-amber-500',
            'accent' => 'bg-amber-600',
        ],
        'cyan' => [
            'iconBg' => 'bg-cyan-50 text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white',
            'valueText' => 'text-slate-900',
            'activeBorder' => 'border-cyan-500/90 ring-1 ring-cyan-500/20 bg-cyan-50/30',
            'hoverBorder' => 'hover:border-cyan-300 hover:shadow-sm',
            'pulse' => 'bg-cyan-500',
            'accent' => 'bg-cyan-600',
        ],
        'rose' => [
            'iconBg' => 'bg-rose-50 text-rose-600 group-hover:bg-rose-600 group-hover:text-white',
            'valueText' => 'text-rose-700',
            'activeBorder' => 'border-rose-500/90 ring-1 ring-rose-500/20 bg-rose-50/30',
            'hoverBorder' => 'hover:border-rose-300 hover:shadow-sm',
            'pulse' => 'bg-rose-500',
            'accent' => 'bg-rose-600',
        ],
        'slate' => [
            'iconBg' => 'bg-slate-100 text-slate-600 group-hover:bg-slate-800 group-hover:text-white',
            'valueText' => 'text-slate-900',
            'activeBorder' => 'border-slate-500/90 ring-1 ring-slate-500/20 bg-slate-50',
            'hoverBorder' => 'hover:border-slate-300 hover:shadow-sm',
            'pulse' => 'bg-slate-500',
            'accent' => 'bg-slate-600',
        ],
    ];

    $c = $colorMap[$color] ?? $colorMap['indigo'];
    $borderClass = $active ? $c['activeBorder'] : 'border-slate-200/80 bg-white hover:border-slate-300';
@endphp

<div {{ $attributes->merge(['class' => "relative rounded-2xl p-3 sm:p-3.5 border {$borderClass} shadow-2xs {$c['hoverBorder']} hover:-translate-y-0.5 transition-all duration-150 cursor-pointer group select-none overflow-hidden"]) }}>
    <!-- Active Indicator Bar -->
    @if($active)
        <div class="absolute top-0 left-0 right-0 h-1 {{ $c['accent'] }}"></div>
    @endif

    <!-- Skeleton Loading Shimmer Overlay -->
    @if($loadingTarget)
        <div wire:loading.delay.shorter wire:target="{{ $loadingTarget }}" class="absolute inset-0 bg-slate-100/90 backdrop-blur-[2px] z-10 p-3 flex flex-col justify-between animate-pulse">
            <div class="flex items-center justify-between">
                <div class="h-2.5 w-14 bg-slate-300 rounded"></div>
                <div class="w-6 h-6 rounded-lg bg-slate-300"></div>
            </div>
            <div class="h-5 w-10 bg-slate-300 rounded mt-1"></div>
            <div class="h-2 w-20 bg-slate-200 rounded mt-0.5"></div>
        </div>
    @endif

    <div class="flex items-center justify-between gap-2">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider truncate">{{ $title }}</span>
        <div class="w-7 h-7 rounded-xl {{ $c['iconBg'] }} flex items-center justify-center group-hover:scale-105 transition-all duration-150 relative shrink-0 shadow-2xs">
            @if($pulse)
                <span class="w-1.5 h-1.5 rounded-full {{ $c['pulse'] }} absolute top-1 right-1 animate-pulse"></span>
            @endif
            <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 transition-transform"></i>
        </div>
    </div>
    
    <div class="flex items-baseline gap-1 mt-1">
        <span class="text-xl font-extrabold {{ $c['valueText'] }} tracking-tight leading-none">{{ $value }}</span>
        @if($unit)
            <span class="text-[11px] font-bold text-slate-400">{{ $unit }}</span>
        @endif
    </div>

    @if($subtitle)
        <p class="text-[10px] text-slate-400 mt-1 font-medium truncate leading-tight">
            {{ $subtitle }}
        </p>
    @endif
</div>
