<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Infrastruktur & Fasilitas Olahraga</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Sarana & <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Prasarana Wilayah</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Pusat data gelanggang, stadion, GOR, lapangan terbuka, dan sarana olahraga rekreasi masyarakat di seluruh wilayah Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. STICKY FILTER & SEARCH TOOLBAR --}}
    <section class="py-5 bg-white/95 backdrop-blur-md sticky top-16 md:top-20 z-30 border-b border-slate-100 shadow-sm shadow-slate-100/50">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
                {{-- Category Pill Tabs --}}
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
                    @foreach(['Semua', 'Stadion', 'Lapangan', 'GOR', 'Kolam Renang', 'Lintasan', 'Taman Olahraga'] as $j)
                        <button 
                            wire:click="filterKategori('{{ $j }}')" 
                            class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap flex items-center gap-1.5 {{ $jenisDipilih === $j ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                        >
                            @if($j === 'Semua')
                                <i data-lucide="layers" class="w-3.5 h-3.5 {{ $jenisDipilih === $j ? 'text-emerald-400' : 'text-slate-400' }}"></i>
                            @else
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 {{ $jenisDipilih === $j ? 'text-lime-300' : 'text-slate-400' }}"></i>
                            @endif
                            <span>{{ $j }}</span>
                        </button>
                    @endforeach
                </div>

                {{-- Filters: Kecamatan Dropdown + Search --}}
                <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap">
                    {{-- Kecamatan Select --}}
                    <div class="w-full sm:w-44 shrink-0">
                        <select 
                            wire:model.live="kecamatanDipilih"
                            class="w-full bg-slate-50 border border-slate-200/90 rounded-2xl px-3 py-2.5 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm"
                        >
                            <option value="Semua">Semua Kecamatan</option>
                            @foreach($kecamatanList as $kec)
                                <option value="{{ $kec->slug }}">{{ $kec->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative w-full sm:w-64 shrink-0">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="cari" 
                            placeholder="Cari venue / nama jalan..." 
                            class="w-full bg-slate-50 border border-slate-200/90 rounded-2xl px-4 py-2.5 pl-9 text-xs font-bold text-slate-800 placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm"
                        />
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        @if(!empty($cari))
                            <button wire:click="$set('cari', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. CONTENT LIST SECTION --}}
    <section class="py-12 bg-slate-50/50 min-h-[50vh]">
        <div class="container mx-auto px-6 max-w-7xl">
            {{-- Result Indicator --}}
            <div class="flex items-center justify-between gap-4 mb-6">
                <div class="text-xs font-bold text-slate-500">
                    Menampilkan <strong class="text-slate-800">{{ $fasilitasData->count() }}</strong> fasilitas olahraga
                    @if($jenisDipilih !== 'Semua')
                        kategori <span class="text-emerald-600 font-bold">{{ $jenisDipilih }}</span>
                    @endif
                    @if($kecamatanDipilih !== 'Semua')
                        di wilayah <span class="text-emerald-600 font-bold">Kec. {{ ucfirst($kecamatanDipilih) }}</span>
                    @endif
                </div>
                <div class="text-[11px] font-semibold text-slate-400 hidden sm:flex items-center gap-1.5">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-emerald-500"></i>
                    <span>Tersedia untuk pembinaan & kegiatan masyarakat</span>
                </div>
            </div>

            {{-- Facilities Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($fasilitasData as $f)
                    @php
                        $kondisiClass = match($f->status_kondisi) {
                            'Baik', 'Sangat Baik' => 'bg-emerald-500 text-white',
                            'Perlu Renovasi' => 'bg-amber-500 text-white',
                            'Rusak' => 'bg-rose-500 text-white',
                            default => 'bg-blue-600 text-white'
                        };
                    @endphp
                    
                    <div class="group bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            {{-- Image Cover with Badges --}}
                            <div class="relative h-48 sm:h-52 overflow-hidden bg-slate-100">
                                <img 
                                    src="{{ $f->foto_url }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" 
                                    alt="{{ $f->nama_fasilitas }}"
                                    loading="lazy"
                                    onerror="this.src='https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=800'"
                                />
                                
                                {{-- Category Badge --}}
                                <div class="absolute top-4 left-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-white/95 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-wider text-slate-800 shadow-sm border border-slate-200/50">
                                        <i data-lucide="tag" class="w-3 h-3 text-emerald-600"></i>
                                        <span>{{ $f->kategori_fasilitas }}</span>
                                    </span>
                                </div>

                                {{-- Condition Badge --}}
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm {{ $kondisiClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                        <span>{{ $f->status_kondisi ?: 'Tersedia' }}</span>
                                    </span>
                                </div>

                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>

                            {{-- Content Body --}}
                            <div class="p-6">
                                <h3 class="text-base sm:text-lg font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition-colors mb-3">
                                    {{ $f->nama_fasilitas }}
                                </h3>

                                <div class="space-y-2.5 text-xs text-slate-600">
                                    {{-- Location --}}
                                    <div class="flex items-start gap-2">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                                        <div>
                                            <span class="font-bold text-slate-800">Kec. {{ $f->kecamatan->nama_kecamatan ?? 'Kabupaten Bandung' }}</span>
                                            @if(!empty($f->alamat_lengkap))
                                                <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $f->alamat_lengkap }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Capacity --}}
                                    @if(!empty($f->kapasitas))
                                        <div class="flex items-center gap-2 text-[11px]">
                                            <i data-lucide="users" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                                            <span>Kapasitas: <strong class="text-slate-800">{{ $f->kapasitas }}</strong></span>
                                        </div>
                                    @endif

                                    {{-- Available Sports Tags --}}
                                    @if(!empty($f->jenis_olahraga_tersedia))
                                        <div class="pt-2 border-t border-slate-100">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Cabang Rekreasi / Olahraga:</span>
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach(explode(',', $f->jenis_olahraga_tersedia) as $cabor)
                                                    <span class="px-2.5 py-0.5 rounded-lg bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-100">
                                                        {{ trim($cabor) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Footer Card Action --}}
                        <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-3">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-500"></i>
                                <span>Milik Publik / Pemkab</span>
                            </div>

                            @if(!empty($f->alamat_lengkap))
                                <a 
                                    href="https://www.google.com/maps/search/?api=1&query={{ urlencode($f->nama_fasilitas . ' ' . $f->alamat_lengkap . ' Kabupaten Bandung') }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1 text-xs font-black text-emerald-600 hover:text-emerald-700 hover:underline"
                                >
                                    <span>Petunjuk Arah</span>
                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-md mx-auto shadow-sm my-6">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-4 border border-slate-200">
                            <i data-lucide="map-pin-off" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 uppercase">Fasilitas Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-6">Tidak ada sarana atau prasarana olahraga yang sesuai dengan filter pilihan Anda.</p>
                        <button wire:click="$set('cari', ''); $set('jenisDipilih', 'Semua'); $set('kecamatanDipilih', 'Semua')" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-emerald-600 transition-colors inline-flex items-center gap-2">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span>Reset Filter & Pencarian</span>
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

