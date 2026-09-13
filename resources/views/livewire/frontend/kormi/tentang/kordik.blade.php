<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Struktur Wilayah 31 Kecamatan</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Koordinator <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Kecamatan (Kordik)</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Struktur kepengurusan dan perwakilan koordinator olahraga rekreasi KORMI tingkat kecamatan se-Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. STICKY SEARCH TOOLBAR --}}
    <section class="py-5 bg-white/95 backdrop-blur-md sticky top-16 md:top-20 z-30 border-b border-slate-100 shadow-sm shadow-slate-100/50">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                    <span>Menampilkan <strong class="text-slate-800">{{ count($kordikList) }}</strong> Koordinator Kecamatan</span>
                    @if(!empty($cari))
                        <span>dengan kata kunci "<span class="text-emerald-600">{{ $cari }}</span>"</span>
                    @endif
                </div>

                {{-- Live Search Input --}}
                <div class="relative w-full sm:w-80">
                    <input 
                        type="text" 
                        wire:model.live.debounce.250ms="cari" 
                        placeholder="Cari kecamatan / nama ketua..." 
                        class="w-full bg-slate-50 border border-slate-200/90 rounded-2xl px-4 py-2.5 pl-10 text-xs font-bold text-slate-800 placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm"
                    />
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    @if(!empty($cari))
                        <button wire:click="$set('cari', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- 3. GRID KORDIK KECAMATAN --}}
    <section class="py-12 bg-slate-50/50 min-h-[50vh]">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($kordikList as $kordik)
                    <div class="group bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between relative overflow-hidden">
                        <div>
                            {{-- Header Card: Initial Avatar / Photo + District Badge --}}
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-black text-lg shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform shrink-0">
                                    {{ $kordik['initial'] }}
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-100">
                                    {{ $kordik['kec'] }}
                                </span>
                            </div>

                            {{-- Chairman Name & Position --}}
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-0.5">Ketua Koordinator</span>
                            <h3 class="text-base sm:text-lg font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition-colors mb-3">
                                {{ $kordik['nama'] }}
                            </h3>

                            {{-- Committee Members Details (Sekretaris / Bendahara) --}}
                            <div class="space-y-1.5 text-xs text-slate-500 bg-slate-50 p-3 rounded-2xl border border-slate-100 mb-3">
                                <div class="flex items-center justify-between text-[11px]">
                                    <span class="text-slate-400">Sekretaris:</span>
                                    <span class="font-bold text-slate-700">{{ $kordik['sekretaris'] }}</span>
                                </div>
                                <div class="flex items-center justify-between text-[11px]">
                                    <span class="text-slate-400">Bendahara:</span>
                                    <span class="font-bold text-slate-700">{{ $kordik['bendahara'] }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Card: Office Location & Contact --}}
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-400">
                            <span class="flex items-center gap-1 text-slate-600 truncate max-w-[200px]" title="{{ $kordik['alamat_kantor'] }}">
                                <i data-lucide="building" class="w-3.5 h-3.5 text-emerald-500 shrink-0"></i>
                                <span class="truncate">{{ $kordik['nama_kecamatan'] }}</span>
                            </span>

                            @if(!empty($kordik['telepon']))
                                <a 
                                    href="tel:{{ $kordik['telepon'] }}" 
                                    class="text-emerald-600 hover:text-emerald-700 hover:underline flex items-center gap-1"
                                >
                                    <i data-lucide="phone" class="w-3 h-3"></i>
                                    <span>Kontak</span>
                                </a>
                            @else
                                <span class="text-slate-400">Aktif</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-md mx-auto shadow-sm my-6">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-4 border border-slate-200">
                            <i data-lucide="map-pin-off" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 uppercase">Koordinator Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-6">Tidak ditemukan koordinator kecamatan yang sesuai dengan kata kunci pencarian Anda.</p>
                        <button wire:click="$set('cari', '')" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-emerald-600 transition-colors inline-flex items-center gap-2">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span>Reset Pencarian</span>
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

