<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1517649763962-0c623266ddc0?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="users" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Masa Bakti {{ $periodeAktif ? $periodeAktif->tahun_mulai . ' - ' . $periodeAktif->tahun_selesai : '2025 - 2029' }}</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Susunan Pengurus <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">KORMI</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Jajaran kepengurusan Komite Olahraga Masyarakat Indonesia Kabupaten Bandung sebagai penggerak, pembina, dan pelayan olahraga rekreasi masyarakat.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. STICKY FILTER & SEARCH TOOLBAR --}}
    <section class="py-4 bg-white/95 backdrop-blur-md sticky top-16 md:top-20 z-30 border-b border-slate-100 shadow-sm shadow-slate-100/50">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                {{-- Bidang Category Pills --}}
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 scrollbar-none max-w-full">
                    <button 
                        wire:click="setBidang('semua')" 
                        class="px-4 py-2 rounded-full text-xs font-bold transition-all shrink-0 {{ $filterBidang === 'semua' ? 'bg-slate-950 text-white shadow-md shadow-slate-950/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        Semua Bidang
                    </button>
                    @foreach($bidangTersedia as $bidang)
                        <button 
                            wire:click="setBidang('{{ $bidang }}')" 
                            class="px-4 py-2 rounded-full text-xs font-bold transition-all shrink-0 {{ strtolower($filterBidang) === strtolower($bidang) ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                        >
                            {{ $bidang }}
                        </button>
                    @endforeach
                </div>

                {{-- Live Search Input --}}
                <div class="relative w-full sm:w-72">
                    <input 
                        type="text" 
                        wire:model.live.debounce.250ms="cari" 
                        placeholder="Cari nama atau jabatan..." 
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

    {{-- 3. STRUCTURE SECTIONS & CARDS --}}
    <section class="py-12 bg-slate-50/50 min-h-[50vh]">
        <div class="container mx-auto px-6 max-w-7xl space-y-12">
            @forelse($sortedGroups as $kategoriTitle => $pengurusList)
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-8 shadow-sm transition-all">
                    {{-- Section Title with Category Badge & Count --}}
                    <div class="flex items-center justify-between flex-wrap gap-3 pb-4 mb-6 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-7 bg-emerald-600 rounded-full"></div>
                            <div>
                                <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight uppercase">
                                    {{ $kategoriTitle }}
                                </h2>
                                <span class="text-[11px] font-semibold text-slate-400">
                                    Struktur Kepengurusan KORMI Kab. Bandung
                                </span>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200/60">
                            {{ count($pengurusList) }} Personil
                        </span>
                    </div>

                    {{-- Members Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($pengurusList as $pengurus)
                            <div class="group bg-slate-50/70 hover:bg-white rounded-2xl border border-slate-200/70 hover:border-emerald-300 p-4 transition-all duration-300 hover:shadow-lg flex items-center gap-4">
                                {{-- Avatar: Photo with Fallback Initials --}}
                                @if(!empty($pengurus->foto_full_url))
                                    <img 
                                        src="{{ $pengurus->foto_full_url }}" 
                                        alt="{{ $pengurus->nama_lengkap }}" 
                                        class="w-14 h-14 rounded-2xl object-cover border-2 border-emerald-100 group-hover:scale-105 transition-transform shrink-0 shadow-xs"
                                        loading="lazy"
                                    />
                                @else
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform shrink-0">
                                        {{ $pengurus->initial_dua_huruf }}
                                    </div>
                                @endif

                                {{-- Details: Name & Position --}}
                                <div class="min-w-0 flex-1">
                                    <span class="text-[10px] font-extrabold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100 inline-block mb-1">
                                        {{ $pengurus->jabatan }}
                                    </span>
                                    <h3 class="text-xs sm:text-sm font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition-colors line-clamp-2">
                                        {{ $pengurus->nama_lengkap }}
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-md mx-auto shadow-sm my-6">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-4 border border-slate-200">
                        <i data-lucide="users" class="w-8 h-8 text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 uppercase">Pengurus Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-6">Tidak ditemukan data pengurus yang cocok dengan kriteria filter atau pencarian Anda.</p>
                    <button wire:click="setBidang('semua'); $set('cari', '');" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-emerald-600 transition-colors inline-flex items-center gap-2">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Reset Filter</span>
                    </button>
                </div>
            @endforelse
        </div>
    </section>
</div>
