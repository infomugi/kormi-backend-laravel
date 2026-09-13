@props([
    'title',
    'value',
    'icon' => null,
    'badge' => null,
    'badgeType' => 'emerald', // 'emerald', 'amber', 'rose', 'sky'
    'description' => null,
    'trend' => null, // 'up', 'down'
    'trendValue' => null,
])

<div {{ $attributes->merge([
    'class' => "bg-white p-5 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs hover:shadow-md transition-all duration-200"
]) }}>
    <div class="flex items-center justify-between gap-3 mb-3">
        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $title }}</span>
        @if($icon)
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
            </div>
        @endif
    </div>

    <div class="flex items-baseline gap-2">
        <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $value }}</h3>
        @if($badge)
            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                {{ $badge }}
            </span>
        @endif
    </div>

    @if($description || $trendValue)
        <div class="mt-2.5 flex items-center gap-1.5 text-xs text-slate-500">
            @if($trendValue)
                <span class="inline-flex items-center gap-0.5 font-bold {{ $trend === 'down' ? 'text-rose-600' : 'text-emerald-600' }}">
                    <i data-lucide="{{ $trend === 'down' ? 'trending-down' : 'trending-up' }}" class="w-3.5 h-3.5"></i>
                    {{ $trendValue }}
                </span>
            @endif
            @if($description)
                <span>{{ $description }}</span>
            @endif
        </div>
    @endif
</div>
