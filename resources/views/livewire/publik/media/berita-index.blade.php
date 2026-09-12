<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1504711434969-e33886168d5c?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="newspaper" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Pusat Publikasi & Media Center</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Warta & <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Liputan Terkini</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Informasi aktual mengenai agenda kejuaraan, prestasi pegiat, pembinaan komunitas, dan kebijakan KORMI Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. FEATURED HEADLINE (ULTRA-PRO EDITORIAL) --}}
    @if($beritaUtama && $kategoriDipilih === 'Semua' && empty($cari))
        <section class="py-12 bg-white relative">
            <div class="container mx-auto px-6 max-w-6xl">
                <a href="{{ route('berita.detail', $beritaUtama->slug) }}" wire:navigate class="group relative bg-white rounded-3xl overflow-hidden border border-slate-200/90 shadow-xl shadow-slate-200/50 hover:border-emerald-300 transition-all duration-300 block transform hover:-translate-y-0.5">
                    <div class="grid lg:grid-cols-12 items-center">
                        <div class="lg:col-span-7 relative h-72 lg:h-[380px] overflow-hidden bg-slate-100">
                            <img src="{{ $beritaUtama->gambar_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $beritaUtama->judul }}" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'" />
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent lg:hidden"></div>
                            <div class="absolute top-4 left-4">
                                <span class="bg-gradient-to-r from-rose-500 to-red-600 text-white text-[10px] font-black px-3.5 py-1.5 rounded-full uppercase tracking-wider shadow-lg flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                    <span>Liputan Utama</span>
                                </span>
                            </div>
                        </div>

                        <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 space-y-4 text-left">
                            <div class="flex items-center gap-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                <span class="px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-extrabold border border-emerald-200/60">
                                    {{ $beritaUtama->kategori->nama_kategori ?? 'Berita' }}
                                </span>
                                <span>•</span>
                                <span class="flex items-center gap-1 text-slate-500">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-emerald-600"></i>
                                    {{ \Carbon\Carbon::parse($beritaUtama->tanggal_publikasi)->translatedFormat('d F Y') }}
                                </span>
                            </div>

                            <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 leading-snug group-hover:text-emerald-600 transition-colors tracking-tight">
                                {{ $beritaUtama->judul }}
                            </h2>

                            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed line-clamp-3">
                                {{ $beritaUtama->ringkasan }}
                            </p>

                            <div class="pt-2 flex items-center gap-3">
                                <span class="px-5 py-2.5 rounded-full bg-slate-900 text-white group-hover:bg-emerald-600 text-xs font-black uppercase tracking-wider shadow-md transition-all flex items-center gap-2">
                                    <span>Baca Liputan Lengkap</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                                </span>
                                <span class="text-xs font-semibold text-slate-400">
                                    {{ $beritaUtama->estimasi_menit_baca ?? 2 }} mnt baca
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </section>
    @endif

    {{-- 3. FILTER & DIRECTORY GRID --}}
    <section class="py-14 bg-slate-50/60 relative">
        <div class="container mx-auto px-6 max-w-6xl">
            
            {{-- SEARCH & FILTER BAR --}}
            <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/90 shadow-lg shadow-slate-200/50 mb-10 flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
                <div class="flex flex-wrap items-center gap-2">
                    <button 
                        wire:click="filterKategori('Semua')"
                        class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all {{ $kategoriDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-md' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600' }}"
                    >
                        Semua Kategori
                    </button>
                    @foreach($kategoriList as $kat)
                        <button 
                            wire:click="filterKategori('{{ $kat->slug }}')"
                            class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all {{ $kategoriDipilih === $kat->slug ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600' }}"
                        >
                            {{ $kat->nama_kategori }}
                        </button>
                    @endforeach
                </div>

                {{-- Search Box --}}
                <div class="w-full md:w-80 relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="Cari judul atau topik berita..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-full text-xs font-semibold bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:border-emerald-500 transition-all shadow-inner"
                    >
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                </div>
            </div>

            {{-- NEWS GRID --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($beritaList as $news)
                    <a href="{{ route('berita.detail', $news->slug) }}" wire:navigate class="group bg-white rounded-3xl overflow-hidden border border-slate-200/80 hover:border-emerald-300 shadow-sm hover:shadow-xl transition-all duration-300 block hover:-translate-y-1 flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 sm:h-52 overflow-hidden bg-slate-100">
                                <img src="{{ $news->gambar_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $news->judul }}" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'" />
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
                                <div class="absolute top-3.5 left-3.5">
                                    <span class="bg-emerald-600 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                                        {{ $news->kategori->nama_kategori ?? 'Berita' }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-5 space-y-2.5 text-left">
                                <div class="flex items-center gap-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    <span class="flex items-center gap-1 text-slate-500">
                                        <i data-lucide="calendar" class="w-3 h-3 text-emerald-500"></i>
                                        {{ \Carbon\Carbon::parse($news->tanggal_publikasi)->translatedFormat('d M Y') }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1 text-slate-500">
                                        <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i>
                                        {{ $news->estimasi_menit_baca ?? 2 }} mnt baca
                                    </span>
                                </div>
                                <h3 class="text-base font-black leading-snug group-hover:text-emerald-600 transition-colors line-clamp-2 tracking-tight text-slate-900">
                                    {{ $news->judul }}
                                </h3>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed line-clamp-2">
                                    {{ $news->ringkasan }}
                                </p>
                            </div>
                        </div>
                        <div class="px-5 pb-5 pt-1 text-left border-t border-slate-50">
                            <span class="text-xs font-black text-emerald-600 group-hover:text-emerald-700 inline-flex items-center gap-1">
                                <span>Selengkapnya</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-slate-300 text-slate-400">
                        <i data-lucide="search-x" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
                        <p class="text-sm font-bold text-slate-600">Tidak ada artikel atau berita yang sesuai.</p>
                        <p class="text-xs text-slate-400 mt-1">Gunakan kata kunci lain atau pilih "Semua Kategori".</p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="mt-12 flex justify-center">
                {{ $beritaList->links() }}
            </div>
        </div>
    </section>
</div>
