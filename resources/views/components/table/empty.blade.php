@props([
    'colspan' => 1,
    'icon' => 'database',
    'title' => 'Data tidak ditemukan',
    'description' => 'Tidak ada data yang sesuai dengan pencarian atau filter yang dipilih.',
    'resetAction' => null,
    'resetText' => 'Reset Semua Filter'
])

<tr>
    <td colspan="{{ $colspan }}" class="px-6 py-20 text-center text-slate-400">
        <div class="max-w-md mx-auto space-y-4">
            <div class="w-16 h-16 rounded-3xl bg-gradient-to-b from-slate-50 to-slate-100/80 border border-slate-200/80 text-slate-400 flex items-center justify-center mx-auto shadow-xs">
                <i data-lucide="{{ $icon }}" class="w-7 h-7 text-slate-400"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-base font-black text-slate-900 tracking-tight">{{ $title }}</h3>
                <p class="text-xs text-slate-500 font-normal leading-relaxed">{{ $description }}</p>
            </div>
            @if($resetAction)
                <div class="pt-2">
                    <button 
                        type="button" 
                        wire:click="{{ $resetAction }}" 
                        class="px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 font-bold text-xs shadow-2xs transition-all cursor-pointer inline-flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-indigo-600"></i>
                        <span>{{ $resetText }}</span>
                    </button>
                </div>
            @endif
        </div>
    </td>
</tr>
