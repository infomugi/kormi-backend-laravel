<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="medal" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Garda Terdepan Olahraga Desa</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Duta Olahraga <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Desa & Kelurahan</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Mengenal sosok penggerak, motivator, dan pegiat olahraga masyarakat di 280 Desa dan Kelurahan dari 31 Kecamatan se-Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. STICKY FILTER & SEARCH TOOLBAR --}}
    <section class="py-5 bg-white/95 backdrop-blur-md sticky top-16 md:top-20 z-30 border-b border-slate-100 shadow-sm shadow-slate-100/50">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                {{-- Left: Filter Kecamatan Dropdown --}}
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-64 shrink-0">
                        <select 
                            wire:model.live="kecamatanDipilih"
                            class="w-full bg-slate-50 border border-slate-200/90 rounded-2xl px-4 py-2.5 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm"
                        >
                            <option value="">Semua Wilayah Kecamatan (31)</option>
                            @foreach($kecamatanList as $kec)
                                <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(!empty($kecamatanDipilih))
                        <button 
                            wire:click="$set('kecamatanDipilih', '')" 
                            class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition-colors whitespace-nowrap"
                        >
                            Reset
                        </button>
                    @endif
                </div>

                {{-- Right: Live Search Box --}}
                <div class="relative w-full md:w-80 shrink-0">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="Cari nama duta / desa..." 
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

    {{-- 3. CONTENT DUTA OLAHRAGA GRID --}}
    <section class="py-12 bg-slate-50/50 min-h-[50vh]">
        <div class="container mx-auto px-6 max-w-7xl">
            {{-- Result Indicator --}}
            <div class="flex items-center justify-between gap-4 mb-6">
                <div class="text-xs font-bold text-slate-500">
                    Menampilkan <strong class="text-slate-800">{{ $dutaList->total() }}</strong> Duta Olahraga Desa
                    @if(!empty($cari))
                        dengan kata kunci "<span class="text-emerald-600">{{ $cari }}</span>"
                    @endif
                </div>
                <div class="text-[11px] font-semibold text-slate-400 hidden sm:flex items-center gap-1.5">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-500"></i>
                    <span>SK Duta Resmi KORMI Kab. Bandung</span>
                </div>
            </div>

            {{-- Grid Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @forelse($dutaList as $duta)
                    <div class="group bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 text-center flex flex-col justify-between relative overflow-hidden">
                        {{-- Top Badge: Unggulan / Active --}}
                        <div class="absolute top-4 right-4">
                            @if($duta->status_unggulan)
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 ring-4 ring-amber-100 block" title="Duta Unggulan"></span>
                            @else
                                <span class="w-2 h-2 rounded-full bg-emerald-500 block" title="Aktif"></span>
                            @endif
                        </div>

                        <div>
                            {{-- Avatar Profile with Fallback Initial --}}
                            <div class="relative w-20 h-20 mx-auto mb-4">
                                @if($duta->foto_duta_url)
                                    <img 
                                        src="{{ $duta->foto_duta_url }}" 
                                        alt="{{ $duta->nama_lengkap }}" 
                                        class="w-full h-full rounded-2xl object-cover ring-2 ring-emerald-500/20 shadow-md group-hover:scale-105 transition-transform"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >
                                    <div class="w-full h-full rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-black text-xl items-center justify-center shadow-md hidden">
                                        {{ $duta->initial_dua_huruf }}
                                    </div>
                                @else
                                    <div class="w-full h-full rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-black text-xl flex items-center justify-center shadow-md shadow-emerald-500/15 group-hover:scale-105 transition-transform">
                                        {{ $duta->initial_dua_huruf }}
                                    </div>
                                @endif
                            </div>

                            {{-- Name & Status --}}
                            <h3 class="text-sm md:text-base font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition-colors mb-1.5 line-clamp-1">
                                {{ $duta->nama_lengkap }}
                            </h3>

                            <div class="mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-100">
                                    Desa {{ $duta->desaKelurahan->nama_desa_kelurahan ?? '-' }}
                                </span>
                            </div>

                            @if(!empty($duta->gelar_prestasi))
                                <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed mb-2 italic">
                                    "{{ $duta->gelar_prestasi }}"
                                </p>
                            @endif
                        </div>

                        {{-- Footer Card: Kecamatan & Tahun --}}
                        <div class="pt-3 mt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-400">
                            <span class="flex items-center gap-1 text-slate-600">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-emerald-500"></i>
                                Kec. {{ $duta->kecamatan->nama_kecamatan }}
                            </span>
                            <span class="text-slate-400 font-semibold">{{ $duta->tahun_pemilihan ?: 2026 }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-md mx-auto shadow-sm my-6">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-4 border border-slate-200">
                            <i data-lucide="user-x" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 uppercase">Duta Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-6">Tidak ditemukan data Duta Olahraga yang sesuai dengan filter wilayah atau kata kunci pencarian Anda.</p>
                        <button wire:click="$set('cari', ''); $set('kecamatanDipilih', '')" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-emerald-600 transition-colors inline-flex items-center gap-2">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span>Reset Pencarian</span>
                        </button>
                    </div>
                @endforelse
            </div>

            {{-- Pagination Links --}}
            @if($dutaList->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $dutaList->links() }}
                </div>
            @endif
        </div>
    </section>
</div>

