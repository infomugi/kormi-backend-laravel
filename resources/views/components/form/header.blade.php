@props([
    'title' => 'Formulir',
    'subtitle' => null,
    'badge' => null,
    'backUrl' => null,
    'backTitle' => 'Kembali',
    'icon' => 'file-text',
])

<div {{ $attributes->merge(['class' => 'bg-gradient-to-r from-emerald-900 via-teal-900 to-emerald-800 p-4 sm:p-6 lg:p-7 rounded-2xl sm:rounded-3xl text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4']) }}>
    <div class="absolute right-0 top-0 w-72 sm:w-96 h-72 sm:h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative z-10 flex items-center gap-3 sm:gap-4">
        @if($backUrl)
            <a 
                href="{{ $backUrl }}" 
                wire:navigate
                class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all cursor-pointer shrink-0 border border-white/15 active:scale-95 shadow-xs"
                title="{{ $backTitle }}"
            >
                <i data-lucide="arrow-left" class="w-4 h-4 sm:w-5 sm:h-5"></i>
            </a>
        @endif
        <div class="min-w-0">
            @if($badge)
                <div class="flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-xs font-bold text-emerald-300 uppercase tracking-wider mb-0.5 sm:mb-1">
                    <i data-lucide="{{ $icon }}" class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0"></i>
                    <span>{{ $badge }}</span>
                </div>
            @endif
            <h1 class="text-lg sm:text-2xl lg:text-3xl font-black tracking-tight leading-tight">
                {{ $title }}
            </h1>
            @if($subtitle)
                <p class="text-xs text-emerald-100/80 mt-0.5 hidden sm:block">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>

    @if(isset($actions))
        <div class="relative z-10 flex items-center gap-2 sm:gap-3 self-stretch sm:self-auto justify-end flex-wrap pt-2 sm:pt-0 border-t border-white/10 sm:border-0">
            {{ $actions }}
        </div>
    @endif
</div>
