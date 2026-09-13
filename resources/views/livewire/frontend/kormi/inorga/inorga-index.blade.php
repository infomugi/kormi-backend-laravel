<div>
    <!-- 1. COMPACT PRO HERO SECTION -->
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" onerror="this.style.display='none'" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="award" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Kelembagaan Olahraga Rekreasi</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Induk Organisasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">(INORGA)</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Direktori resmi induk organisasi cabang olahraga rekreasi yang terdaftar dan bernaung di bawah KORMI Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    <!-- 2. MAIN CONTENT DIRECTORY & FILTER -->
    <section class="py-16 bg-slate-50/60 relative">
        <div class="container mx-auto px-6 max-w-6xl">
            
            <!-- Controls Bar: Filter Pills + Search Input -->
            <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/90 shadow-lg shadow-slate-200/50 mb-10 flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4">
                
                <!-- Filter Komisi Pills -->
                <div class="flex flex-wrap items-center gap-2">
                    <button 
                        wire:click="$set('komisiDipilih', 'Semua')" 
                        class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all {{ $komisiDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-md' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600' }}">
                        Semua Rumpun
                    </button>
                    @foreach($komisiList as $kom)
                        @php
                            $isTrad = str_contains(strtolower($kom->nama_komisi), 'tradisional') || $kom->singkatan === 'OTDA';
                            $isKebug = str_contains(strtolower($kom->nama_komisi), 'kesehatan') || $kom->singkatan === 'OKK';
                            $activeBg = $isTrad ? 'bg-emerald-600 text-white shadow-emerald-600/30' : ($isKebug ? 'bg-blue-600 text-white shadow-blue-600/30' : 'bg-amber-600 text-white shadow-amber-600/30');
                        @endphp
                        <button 
                            wire:click="$set('komisiDipilih', '{{ $kom->singkatan }}')" 
                            class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all {{ $komisiDipilih === $kom->singkatan ? $activeBg . ' shadow-md' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600' }}">
                            {{ $kom->singkatan }} ({{ $kom->inorga_count }})
                        </button>
                    @endforeach
                </div>

                <!-- Search Box -->
                <div class="relative w-full lg:w-80">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="Cari singkatan atau nama inorga..." 
                        class="w-full px-4 py-2.5 rounded-full bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:border-emerald-500 text-xs font-semibold pl-10 shadow-inner transition-all">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-3 text-slate-400"></i>
                </div>
            </div>

            <!-- INORGA GRID (ULTRA-PRO CLEAN CARDS) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($inorgaList as $ino)
                    @php
                        $singkatanKomisi = $ino->komisi->singkatan ?? 'KORMI';
                        $isTrad = str_contains(strtolower($ino->komisi->nama_komisi ?? ''), 'tradisional') || $singkatanKomisi === 'OTDA';
                        $isKebug = str_contains(strtolower($ino->komisi->nama_komisi ?? ''), 'kesehatan') || $singkatanKomisi === 'OKK';
                        
                        $avatarGradient = $isTrad ? 'from-emerald-500 to-teal-600' : ($isKebug ? 'from-blue-500 to-indigo-600' : 'from-amber-500 to-orange-600');
                        $badgeBg = $isTrad ? 'bg-emerald-50 text-emerald-700 border-emerald-200/80' : ($isKebug ? 'bg-blue-50 text-blue-700 border-blue-200/80' : 'bg-amber-50 text-amber-700 border-amber-200/80');
                        $cardHoverBorder = $isTrad ? 'hover:border-emerald-300' : ($isKebug ? 'hover:border-blue-300' : 'hover:border-amber-300');
                        $statusAktif = strtolower($ino->status_keanggotaan ?? 'aktif') === 'aktif';
                    @endphp

                    <div class="group relative bg-white rounded-3xl p-6 border border-slate-200/80 {{ $cardHoverBorder }} shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between block text-left transform hover:-translate-y-1 overflow-hidden">
                        <!-- Top Accent Line -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r {{ $avatarGradient }} opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div>
                            <!-- Header Card: Avatar Logo/Initials + Komisi Badge -->
                            <div class="flex items-start justify-between mb-5">
                                @if($ino->logo_gambar_url)
                                    <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 p-2 flex items-center justify-center group-hover:scale-105 transition-transform shadow-sm">
                                        <img src="{{ $ino->logo_gambar_url }}" class="w-full h-full object-contain" alt="{{ $ino->singkatan }}" />
                                    </div>
                                @else
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $avatarGradient }} flex items-center justify-center text-white font-black text-xl tracking-tight shadow-md group-hover:scale-105 transition-transform">
                                        {{ $ino->initial_dua_huruf }}
                                    </div>
                                @endif

                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $badgeBg }} shadow-sm">
                                    {{ $singkatanKomisi }}
                                </span>
                            </div>

                            <!-- Title & Subtitle -->
                            <div class="space-y-1.5 mb-4">
                                <h3 class="text-xl font-black tracking-tight text-slate-900 group-hover:text-emerald-600 transition-colors">
                                    {{ $ino->singkatan }}
                                </h3>
                                <h4 class="text-xs text-slate-500 font-bold uppercase tracking-wider leading-snug">
                                    {{ $ino->nama_inorga }}
                                </h4>
                                @if($ino->deskripsi_kegiatan)
                                    <p class="text-xs text-slate-500 font-medium leading-relaxed line-clamp-2 pt-1">
                                        {{ $ino->deskripsi_kegiatan }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Footer Info Bar -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-semibold text-slate-500">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full {{ $statusAktif ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                                <span class="font-bold {{ $statusAktif ? 'text-emerald-700' : 'text-slate-500' }} uppercase">
                                    {{ $ino->status_keanggotaan ?? 'Aktif' }}
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-1 font-bold text-slate-700 bg-slate-50 px-2.5 py-1 rounded-full border border-slate-100">
                                <i data-lucide="shield" class="w-3 h-3 text-slate-400"></i>
                                <span>{{ $ino->jumlah_klub_anggota }} Klub Anggota</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-slate-300 text-slate-400">
                        <i data-lucide="search-x" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
                        <p class="text-sm font-bold text-slate-600">Tidak ada data INORGA yang cocok dengan pencarian.</p>
                        <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian lain atau pilih "Semua Rumpun".</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
