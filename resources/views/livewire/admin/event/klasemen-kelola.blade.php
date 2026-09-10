<div class="space-y-6">

    <!-- FLASH NOTIFICATION -->
    @if(session()->has('pesan'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xs animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
                <span>{{ session('pesan') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1.5 rounded-lg transition-colors cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    <!-- 1. HEADER & EVENT SELECTOR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                <span>EVENT & KOMPETISI</span>
                <span>•</span>
                <span class="text-amber-600">KLASEMEN PEROLEHAN MEDALI</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Input & Kelola Klasemen Medali</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui perolehan medali Emas, Perak, Perunggu untuk 31 Kontingen Kecamatan se-Kabupaten Bandung secara realtime.</p>
        </div>

        <div class="flex items-center gap-3 bg-white p-2 rounded-2xl border border-slate-200/80 shadow-xs self-start sm:self-auto">
            <span class="text-xs font-bold text-slate-500 pl-2">Pilih Event:</span>
            <select wire:model.live="eventDipilih" class="px-4 py-2 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500">
                @foreach($eventList as $e)
                    <option value="{{ $e->id }}">{{ $e->judul_event }} ({{ $e->tahun_edisi }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- 2. MINI KPI STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-black text-lg shrink-0">
                🥇
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Emas</p>
                <p class="text-2xl font-black text-amber-600 mt-0.5">{{ $totalEmas }} <span class="text-xs font-bold text-slate-400">Keping</span></p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center font-black text-lg shrink-0">
                🥈
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Perak</p>
                <p class="text-2xl font-black text-slate-700 mt-0.5">{{ $totalPerak }} <span class="text-xs font-bold text-slate-400">Keping</span></p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-100/40 text-amber-900 flex items-center justify-center font-black text-lg shrink-0">
                🥉
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Perunggu</p>
                <p class="text-2xl font-black text-amber-900 mt-0.5">{{ $totalPerunggu }} <span class="text-xs font-bold text-slate-400">Keping</span></p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="trophy" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Medali</p>
                <p class="text-2xl font-black text-emerald-600 mt-0.5">{{ $totalSemua }} <span class="text-xs font-bold text-slate-400">Terdistribusi</span></p>
            </div>
        </div>
    </div>

    <!-- 3. TOP 3 PODIUM PREVIEW -->
    @if($top3->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($top3 as $idx => $juara)
                <div class="p-5 rounded-3xl border shadow-xs flex items-center justify-between {{ $idx === 0 ? 'bg-amber-500 text-white border-amber-600 shadow-amber-500/20' : ($idx === 1 ? 'bg-slate-800 text-white border-slate-900' : 'bg-white text-slate-900 border-amber-200') }}">
                    <div class="flex items-center gap-3.5">
                        <span class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-base {{ $idx === 0 ? 'bg-white/20 text-white' : ($idx === 1 ? 'bg-white/10 text-white' : 'bg-amber-100 text-amber-900') }}">
                            #{{ $idx + 1 }}
                        </span>
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-wider opacity-80 block">{{ $idx === 0 ? 'Peringkat 1 (Puncak)' : 'Peringkat ' . ($idx + 1) }}</span>
                            <h4 class="font-black text-sm lg:text-base tracking-tight">{{ $juara->kecamatan->nama_kecamatan ?? '-' }}</h4>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="flex items-center gap-1.5 text-xs font-black justify-end">
                            <span class="px-2 py-0.5 rounded-lg {{ $idx === 0 ? 'bg-amber-600' : ($idx === 1 ? 'bg-slate-700' : 'bg-amber-50 text-amber-800') }}">🥇 {{ $juara->jumlah_emas }}</span>
                            <span class="px-2 py-0.5 rounded-lg {{ $idx === 0 ? 'bg-amber-600' : ($idx === 1 ? 'bg-slate-700' : 'bg-slate-100 text-slate-700') }}">🥈 {{ $juara->jumlah_perak }}</span>
                            <span class="px-2 py-0.5 rounded-lg {{ $idx === 0 ? 'bg-amber-600' : ($idx === 1 ? 'bg-slate-700' : 'bg-amber-100 text-amber-900') }}">🥉 {{ $juara->jumlah_perunggu }}</span>
                        </div>
                        <span class="text-[11px] font-black opacity-90 mt-1 block">Total: {{ $juara->total_medali }} Medali</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- 4. SEARCH & FILTER -->
    <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-xs font-bold text-slate-700">Tabel Live Edit: Ubah angka medali di kolom bawah untuk memperbarui peringkat otomatis.</span>
        </div>

        <div class="relative w-72">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input 
                type="text" 
                wire:model.live.debounce.300ms="cari" 
                placeholder="Cari kecamatan..." 
                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition-all"
            >
        </div>
    </div>

    <!-- 5. KLASEMEN LIVE-EDIT TABLE -->
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-[10px] uppercase font-black tracking-wider text-slate-400 border-b border-slate-200/80">
                    <tr>
                        <th class="py-4 px-6 text-center w-20">Peringkat</th>
                        <th class="py-4 px-6">Kontingen Kecamatan (31 Wilayah)</th>
                        <th class="py-4 px-6 text-center text-amber-700">🥇 Emas</th>
                        <th class="py-4 px-6 text-center text-slate-600">🥈 Perak</th>
                        <th class="py-4 px-6 text-center text-amber-800">🥉 Perunggu</th>
                        <th class="py-4 px-6 text-center font-black text-slate-900">Total Medali</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($klasemenList as $index => $item)
                        <tr class="hover:bg-slate-50/80 transition-colors {{ $index < 3 ? 'bg-amber-50/10' : '' }}">
                            <td class="py-4 px-6 text-center">
                                @if($index === 0)
                                    <span class="w-8 h-8 rounded-xl bg-amber-500 text-white inline-flex items-center justify-center font-black text-xs shadow-sm">1</span>
                                @elseif($index === 1)
                                    <span class="w-8 h-8 rounded-xl bg-slate-800 text-white inline-flex items-center justify-center font-black text-xs shadow-sm">2</span>
                                @elseif($index === 2)
                                    <span class="w-8 h-8 rounded-xl bg-amber-700 text-white inline-flex items-center justify-center font-black text-xs shadow-sm">3</span>
                                @else
                                    <span class="font-bold text-slate-400">#{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <h4 class="font-black text-slate-900 text-sm">{{ $item->kecamatan->nama_kecamatan ?? '-' }}</h4>
                                <span class="text-[11px] text-slate-400 font-medium">Kabupaten Bandung</span>
                            </td>
                            
                            {{-- Input Emas --}}
                            <td class="py-4 px-6 text-center">
                                <input 
                                    type="number" 
                                    min="0"
                                    value="{{ $item->jumlah_emas }}"
                                    wire:change="updateMedali('{{ $item->kecamatan_id }}', 'emas', $event.target.value)"
                                    class="w-20 px-3 py-2 text-center bg-amber-50/80 border border-amber-300 text-amber-900 rounded-xl text-xs font-black focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition-all shadow-2xs"
                                >
                            </td>

                            {{-- Input Perak --}}
                            <td class="py-4 px-6 text-center">
                                <input 
                                    type="number" 
                                    min="0"
                                    value="{{ $item->jumlah_perak }}"
                                    wire:change="updateMedali('{{ $item->kecamatan_id }}', 'perak', $event.target.value)"
                                    class="w-20 px-3 py-2 text-center bg-slate-100 border border-slate-300 text-slate-800 rounded-xl text-xs font-black focus:bg-white focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all shadow-2xs"
                                >
                            </td>

                            {{-- Input Perunggu --}}
                            <td class="py-4 px-6 text-center">
                                <input 
                                    type="number" 
                                    min="0"
                                    value="{{ $item->jumlah_perunggu }}"
                                    wire:change="updateMedali('{{ $item->kecamatan_id }}', 'perunggu', $event.target.value)"
                                    class="w-20 px-3 py-2 text-center bg-amber-100/40 border border-amber-500/40 text-amber-950 rounded-xl text-xs font-black focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-700 transition-all shadow-2xs"
                                >
                            </td>

                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center gap-1 font-black text-slate-900 bg-slate-100 px-4 py-2 rounded-xl text-sm">
                                    {{ $item->total_medali }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center bg-white">
                                <i data-lucide="trophy" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-bold text-slate-600">Tidak ada data klasemen untuk event ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
