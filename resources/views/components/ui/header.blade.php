@props([
    'title',
    'subtitle' => null,
    'badge' => null,
    'icon' => null,
])

<div {{ $attributes->merge([
    'class' => "flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200/80 mb-6"
]) }}>
    <div class="flex items-start sm:items-center gap-3.5">
        @if($icon)
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20 shrink-0">
                <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
            </div>
        @endif
        <div>
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">{{ $title }}</h1>
                @if($badge)
                    <span class="px-2.5 py-0.5 text-xs font-extrabold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                        {{ $badge }}
                    </span>
                @endif
            </div>
            @if($subtitle)
                <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @if(isset($actions) && $actions->isNotEmpty())
        <div class="flex items-center gap-2.5 flex-wrap">
            {{ $actions }}
        </div>
    @endif
</div>
