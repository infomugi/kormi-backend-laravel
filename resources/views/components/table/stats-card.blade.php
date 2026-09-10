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
            'activeBorder' => 'border-indigo-500 ring-2 ring-indigo-500/20 bg-indigo-50/20',
            'hoverBorder' => 'hover:border-indigo-300 hover:shadow-md',
            'pulse' => 'bg-indigo-500',
            'accent' => 'bg-indigo-500',
        ],
        'emerald' => [
            'iconBg' => 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white',
            'valueText' => 'text-emerald-700',
            'activeBorder' => 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-50/20',
            'hoverBorder' => 'hover:border-emerald-300 hover:shadow-md',
            'pulse' => 'bg-emerald-500',
            'accent' => 'bg-emerald-500',
        ],
        'amber' => [
            'iconBg' => 'bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white',
            'valueText' => 'text-amber-700',
            'activeBorder' => 'border-amber-500 ring-2 ring-amber-500/20 bg-amber-50/20',
            'hoverBorder' => 'hover:border-amber-300 hover:shadow-md',
            'pulse' => 'bg-amber-500',
            'accent' => 'bg-amber-500',
        ],
        'cyan' => [
            'iconBg' => 'bg-cyan-50 text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white',
            'valueText' => 'text-slate-900',
            'activeBorder' => 'border-cyan-500 ring-2 ring-cyan-500/20 bg-cyan-50/20',
            'hoverBorder' => 'hover:border-cyan-300 hover:shadow-md',
            'pulse' => 'bg-cyan-500',
            'accent' => 'bg-cyan-500',
        ],
        'rose' => [
            'iconBg' => 'bg-rose-50 text-rose-600 group-hover:bg-rose-600 group-hover:text-white',
            'valueText' => 'text-rose-700',
            'activeBorder' => 'border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20',
            'hoverBorder' => 'hover:border-rose-300 hover:shadow-md',
            'pulse' => 'bg-rose-500',
            'accent' => 'bg-rose-500',
        ],
        'slate' => [
            'iconBg' => 'bg-slate-100 text-slate-600 group-hover:bg-slate-800 group-hover:text-white',
            'valueText' => 'text-slate-900',
            'activeBorder' => 'border-slate-500 ring-2 ring-slate-500/20 bg-slate-50',
            'hoverBorder' => 'hover:border-slate-300 hover:shadow-md',
            'pulse' => 'bg-slate-500',
            'accent' => 'bg-slate-500',
        ],
    ];

    $c = $colorMap[$color] ?? $colorMap['indigo'];
    $borderClass = $active ? $c['activeBorder'] : 'border-slate-200/80 bg-white';
@endphp

<div {{ $attributes->merge(['class' => "relative rounded-2xl sm:rounded-3xl p-4 sm:p-5 border {$borderClass} shadow-xs {$c['hoverBorder']} transition-all duration-200 cursor-pointer group select-none overflow-hidden"]) }}>
    <!-- Active Indicator Bar -->
    @if($active)
        <div class="absolute top-0 left-0 right-0 h-1 {{ $c['accent'] }}"></div>
    @endif

    <!-- Skeleton Loading Shimmer Overlay -->
    @if($loadingTarget)
        <div wire:loading.delay.shorter wire:target="{{ $loadingTarget }}" class="absolute inset-0 bg-slate-100/90 backdrop-blur-[2px] z-10 p-4 sm:p-5 flex flex-col justify-between animate-pulse">
            <div class="flex items-center justify-between">
                <div class="h-3 w-16 bg-slate-300 rounded-md"></div>
                <div class="w-8 h-8 rounded-xl bg-slate-300"></div>
            </div>
            <div class="h-6 w-12 bg-slate-300 rounded-md mt-2"></div>
            <div class="h-2.5 w-24 bg-slate-200 rounded-md mt-1"></div>
        </div>
    @endif

    <div class="flex items-center justify-between">
        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ $title }}</span>
        <div class="w-9 h-9 rounded-2xl {{ $c['iconBg'] }} flex items-center justify-center group-hover:scale-110 group-hover:shadow-sm transition-all duration-200 relative shrink-0">
            @if($pulse)
                <span class="w-2 h-2 rounded-full {{ $c['pulse'] }} absolute top-1.5 right-1.5 animate-pulse"></span>
            @endif
            <i data-lucide="{{ $icon }}" class="w-4 h-4 transition-transform duration-200"></i>
        </div>
    </div>
    
    <p class="text-2xl font-black {{ $c['valueText'] }} mt-2 tracking-tight">
        {{ $value }} 
        @if($unit)
            <span class="text-xs font-bold text-slate-400 font-sans tracking-normal ml-0.5">{{ $unit }}</span>
        @endif
    </p>

    @if($subtitle)
        <p class="text-[10px] text-slate-400 mt-1 font-medium flex items-center gap-1">
            <span>{{ $subtitle }}</span>
        </p>
    @endif
</div>
