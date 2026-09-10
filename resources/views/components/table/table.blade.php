@props([
    'loadingTarget' => null,
])

<div class="relative overflow-x-auto scrollbar-thin scrollbar-thumb-slate-200">
    @if($loadingTarget)
        <!-- Livewire Animated Loading Overlay with Skeleton Shimmer -->
        <div wire:loading.delay.shorter wire:target="{{ $loadingTarget }}" class="absolute inset-0 z-30 bg-white/75 backdrop-blur-[2px] transition-all flex flex-col justify-start">
            <!-- Top Progress Bar -->
            <div class="h-1 w-full bg-slate-100 overflow-hidden relative">
                <div class="w-full h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500 animate-pulse"></div>
            </div>
            
            <!-- Center Floating Loading Badge -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-2xl bg-white/95 border border-slate-200/90 text-slate-800 shadow-2xl backdrop-blur-md animate-in zoom-in-95 duration-150">
                    <div class="w-4 h-4 border-2 border-indigo-600 border-t-transparent rounded-full animate-spin shrink-0"></div>
                    <span class="text-xs font-black tracking-wide text-slate-900">Memperbarui data...</span>
                </div>
            </div>
        </div>
    @endif

    <table {{ $attributes->merge(['class' => 'w-full text-left text-xs text-slate-600 border-collapse']) }}>
        {{ $slot }}
    </table>
</div>
