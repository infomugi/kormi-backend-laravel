@props([
    'count' => 0,
    'label' => 'item dipilih',
    'resetAction' => 'resetSelection'
])

@if($count > 0)
    <div {{ $attributes->merge(['class' => 'p-3.5 sm:p-4 bg-slate-900/95 backdrop-blur-md text-white rounded-2xl sm:rounded-3xl shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-3 animate-in fade-in slide-in-from-bottom-3 duration-200 border border-slate-800 ring-1 ring-white/10 sticky bottom-4 z-40']) }}>
        <div class="flex items-center gap-3">
            <span class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm ring-2 ring-indigo-400/30">
                {{ $count }}
            </span>
            <div>
                <p class="text-xs font-black text-white leading-tight">{{ $count }} {{ $label }}</p>
                <p class="text-[10px] text-slate-400 font-medium">Pilih aksi massal yang ingin diterapkan</p>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap justify-end">
            {{ $slot }}

            @if($resetAction)
                <div class="h-5 w-[1px] bg-slate-800 mx-1 hidden sm:block"></div>
                <button 
                    type="button" 
                    wire:click="{{ $resetAction }}" 
                    class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all cursor-pointer flex items-center gap-1 text-xs font-semibold"
                    title="Batalkan Pilihan"
                >
                    <i data-lucide="x" class="w-4 h-4"></i>
                    <span class="hidden md:inline text-[11px]">Batal</span>
                </button>
            @endif
        </div>
    </div>
@endif
