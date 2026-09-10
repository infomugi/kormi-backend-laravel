@props([
    'backUrl' => null,
    'backText' => 'Kembali ke Daftar',
    'backMobileText' => 'Batal',
])

<div {{ $attributes->merge(['class' => 'col-span-full bg-white/95 backdrop-blur-md border border-slate-200/90 rounded-2xl sm:rounded-3xl p-3 sm:p-4.5 shadow-[0_10px_35px_-5px_rgba(0,0,0,0.12)] flex flex-row items-center justify-between gap-2 sm:gap-4 sticky bottom-2 sm:bottom-4 z-20 transition-all']) }}>
    @if($backUrl)
        <a 
            href="{{ $backUrl }}" 
            wire:navigate
            class="px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-slate-100 hover:bg-slate-200/90 text-slate-700 font-bold text-[11px] sm:text-xs uppercase tracking-wider transition-all duration-200 cursor-pointer inline-flex items-center justify-center gap-1.5 active:scale-95 shrink-0 border border-slate-200/60 shadow-2xs"
        >
            <i data-lucide="arrow-left" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
            <span class="hidden sm:inline">{{ $backText }}</span>
            <span class="sm:hidden">{{ $backMobileText }}</span>
        </a>
    @else
        <div></div>
    @endif

    <div class="flex items-center gap-2 sm:gap-3 justify-end flex-wrap">
        {{ $slot }}
    </div>
</div>
