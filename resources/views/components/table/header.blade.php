@props([
    'title' => 'Kelola Data',
    'subtitle' => null,
    'badge' => null,
    'icon' => 'layers',
    'color' => 'indigo', // 'indigo', 'emerald', 'blue', 'amber', 'purple', 'rose', 'teal'
])

@php
    $colorConfig = [
        'indigo' => [
            'gradient' => 'from-indigo-600 via-indigo-600 to-violet-600',
            'ring' => 'ring-indigo-50 border-white/20',
            'shadow' => 'shadow-indigo-600/20',
            'badge' => 'bg-indigo-50/90 border-indigo-200/70 text-indigo-700',
            'dot' => 'bg-indigo-600',
            'ambient' => 'bg-indigo-500/10',
            'bgGradient' => 'from-white via-slate-50/80 to-indigo-50/30',
        ],
        'emerald' => [
            'gradient' => 'from-emerald-600 via-emerald-600 to-teal-600',
            'ring' => 'ring-emerald-50 border-white/20',
            'shadow' => 'shadow-emerald-600/20',
            'badge' => 'bg-emerald-50/90 border-emerald-200/70 text-emerald-700',
            'dot' => 'bg-emerald-600',
            'ambient' => 'bg-emerald-500/10',
            'bgGradient' => 'from-white via-slate-50/80 to-emerald-50/30',
        ],
        'blue' => [
            'gradient' => 'from-blue-600 via-blue-600 to-cyan-600',
            'ring' => 'ring-blue-50 border-white/20',
            'shadow' => 'shadow-blue-600/20',
            'badge' => 'bg-blue-50/90 border-blue-200/70 text-blue-700',
            'dot' => 'bg-blue-600',
            'ambient' => 'bg-blue-500/10',
            'bgGradient' => 'from-white via-slate-50/80 to-blue-50/30',
        ],
        'amber' => [
            'gradient' => 'from-amber-600 via-amber-600 to-orange-600',
            'ring' => 'ring-amber-50 border-white/20',
            'shadow' => 'shadow-amber-600/20',
            'badge' => 'bg-amber-50/90 border-amber-200/70 text-amber-800',
            'dot' => 'bg-amber-600',
            'ambient' => 'bg-amber-500/10',
            'bgGradient' => 'from-white via-slate-50/80 to-amber-50/30',
        ],
        'purple' => [
            'gradient' => 'from-purple-600 via-purple-600 to-fuchsia-600',
            'ring' => 'ring-purple-50 border-white/20',
            'shadow' => 'shadow-purple-600/20',
            'badge' => 'bg-purple-50/90 border-purple-200/70 text-purple-700',
            'dot' => 'bg-purple-600',
            'ambient' => 'bg-purple-500/10',
            'bgGradient' => 'from-white via-slate-50/80 to-purple-50/30',
        ],
        'rose' => [
            'gradient' => 'from-rose-600 via-rose-600 to-pink-600',
            'ring' => 'ring-rose-50 border-white/20',
            'shadow' => 'shadow-rose-600/20',
            'badge' => 'bg-rose-50/90 border-rose-200/70 text-rose-700',
            'dot' => 'bg-rose-600',
            'ambient' => 'bg-rose-500/10',
            'bgGradient' => 'from-white via-slate-50/80 to-rose-50/30',
        ],
        'teal' => [
            'gradient' => 'from-teal-600 via-teal-600 to-emerald-600',
            'ring' => 'ring-teal-50 border-white/20',
            'shadow' => 'shadow-teal-600/20',
            'badge' => 'bg-teal-50/90 border-teal-200/70 text-teal-700',
            'dot' => 'bg-teal-600',
            'ambient' => 'bg-teal-500/10',
            'bgGradient' => 'from-white via-slate-50/80 to-teal-50/30',
        ],
    ];

    $cfg = $colorConfig[$color] ?? $colorConfig['indigo'];
@endphp

<div {{ $attributes->merge(['class' => "hidden sm:block relative bg-gradient-to-br {$cfg['bgGradient']} rounded-2xl sm:rounded-3xl p-4 sm:p-5 lg:px-6 lg:py-4.5 border border-slate-200/90 shadow-xs overflow-hidden"]) }}>
    <!-- Decorative Ambient Blur -->
    <div class="absolute -right-10 -top-10 w-48 h-48 {{ $cfg['ambient'] }} rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <!-- Left: Compact Emblem Icon + Hierarchy -->
        <div class="flex items-center gap-3.5 sm:gap-4 min-w-0">
            @if($icon)
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-gradient-to-tr {{ $cfg['gradient'] }} text-white flex items-center justify-center shrink-0 shadow-md {{ $cfg['shadow'] }} ring-3 sm:ring-4 {{ $cfg['ring'] }} border">
                    <i data-lucide="{{ $icon }}" class="w-5 h-5 sm:w-5.5 sm:h-5.5"></i>
                </div>
            @endif

            <div class="min-w-0 space-y-0.5">
                @if($badge)
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full border {{ $cfg['badge'] }} text-[10px] sm:text-[11px] font-black uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full {{ $cfg['dot'] }} animate-pulse"></span>
                        <span>{{ $badge }}</span>
                    </div>
                @endif

                <h1 class="text-lg sm:text-xl lg:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate">
                    {{ $title }}
                </h1>

                @if($subtitle)
                    <p class="text-xs text-slate-500 leading-snug truncate max-w-xl">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Right: Actions Slot -->
        @if(isset($actions) || $slot->isNotEmpty())
            <div class="flex items-center gap-2 sm:gap-2.5 self-stretch sm:self-auto justify-end flex-wrap shrink-0 pt-2 sm:pt-0 border-t border-slate-200/60 sm:border-0">
                {{ $actions ?? $slot }}
            </div>
        @endif
    </div>
</div>
