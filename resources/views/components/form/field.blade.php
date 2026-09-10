@props([
    'label' => null,
    'name' => null,
    'required' => false,
    'icon' => null,
    'indicatorColor' => 'bg-emerald-600',
    'badge' => null,
    'hint' => null,
    'counter' => null,
    'maxCount' => null,
    'action' => null,
])

<div class="space-y-1.5">
    @if($label || $counter !== null || $action)
        <div class="flex items-center justify-between gap-2">
            @if($label)
                <label @if($name) for="{{ $name }}" @endif class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full {{ $indicatorColor }}"></span>
                    <span>{{ $label }}</span>
                    @if($required)
                        <span class="text-rose-500 font-bold">*</span>
                    @endif
                    @if($badge)
                        <span class="ml-1 px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-slate-100 text-slate-600 uppercase">{{ $badge }}</span>
                    @endif
                </label>
            @endif

            <div class="flex items-center gap-2.5 ml-auto">
                @if($action)
                    {{ $action }}
                @endif

                @if($counter !== null)
                    <span class="text-[10px] sm:text-[11px] font-bold {{ $maxCount && $counter > ($maxCount * 0.9) ? 'text-amber-600 font-extrabold' : 'text-slate-400' }}">
                        {{ $counter }}{{ $maxCount ? ' / ' . $maxCount : '' }}
                    </span>
                @endif
            </div>
        </div>
    @endif

    <div class="relative">
        @if($icon)
            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none flex items-center justify-center">
                <i data-lucide="{{ $icon }}" class="w-4 h-4 text-slate-400"></i>
            </div>
        @endif

        {{ $slot }}
    </div>

    @if($hint)
        <p class="text-[11px] text-slate-400 leading-normal">{{ $hint }}</p>
    @endif

    @if($name)
        @error($name)
            <span class="text-xs text-rose-600 font-bold flex items-center gap-1 mt-1 animate-in fade-in duration-150">
                <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                <span>{{ $message }}</span>
            </span>
        @enderror
    @endif
</div>
