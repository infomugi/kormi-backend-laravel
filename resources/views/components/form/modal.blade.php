@props([
    'show' => false,
    'title' => 'Modal Dialog',
    'subtitle' => null,
    'icon' => null,
    'onClose' => 'tutupModal',
    'maxWidth' => 'max-w-md',
])

@if($show)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
        <div class="bg-white rounded-2xl sm:rounded-3xl {{ $maxWidth }} w-full shadow-2xl overflow-hidden border border-slate-100 p-5 sm:p-7 space-y-5 sm:space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if($icon)
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i data-lucide="{{ $icon }}" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-sm sm:text-base font-black text-slate-900">{{ $title }}</h3>
                        @if($subtitle)
                            <p class="text-[10px] sm:text-[11px] text-slate-400">{{ $subtitle }}</p>
                        @endif
                    </div>
                </div>
                <button type="button" wire:click="{{ $onClose }}" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg cursor-pointer">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <div>
                {{ $slot }}
            </div>
        </div>
    </div>
@endif
