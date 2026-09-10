<div>
    {{-- HERO SECTION --}}
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1504711434969-e33886168d5c?q=80&w=2000" class="w-full h-full object-cover opacity-20" alt="Hero Background">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="max-w-4xl space-y-4 reveal active">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-4">
                    <i data-lucide="newspaper" class="w-4 h-4 text-bedasLime"></i>
                    <span class="text-xs font-bold text-white tracking-widest uppercase">Media Center</span>
                </div>
                <h1 class="text-4xl md:text-6xl font-black leading-[1.1] tracking-tighter text-white uppercase">
                    Berita & <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedasGreen to-bedasLime">Artikel</span>
                </h1>
                <p class="text-base md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed opacity-90 pt-4">
                    Informasi terbaru seputar kegiatan, prestasi, dan program olahraga rekreasi masyarakat Kabupaten Bandung.
                </p>
            </div>
        </div>
    </section>

    {{-- FEATURED NEWS --}}
    @if($beritaUtama && $kategoriDipilih === 'Semua' && empty($cari))
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <div class="reveal active">
                <div class="grid lg:grid-cols-2 gap-8 bg-slate-50 rounded-[2.5rem] overflow-hidden border border-slate-100 group cursor-pointer hover:shadow-xl transition-all">
                    <div class="relative h-[300px] lg:h-auto overflow-hidden">
                        <img src="{{ $beritaUtama->gambar_utama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $beritaUtama->judul }}">
                        <div class="absolute top-6 left-6">
                            <span class="bg-bedasGreen text-white text-[9px] font-black px-4 py-2 rounded-full uppercase tracking-widest shadow-xl">
                                {{ $beritaUtama->kategori->nama_kategori ?? 'Berita' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-8 md:p-12 flex flex-col justify-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">
                            🔥 Berita Utama • {{ \Carbon\Carbon::parse($beritaUtama->tanggal_publikasi)->translatedFormat('d M Y') }}
                        </span>
                        <h2 class="text-2xl md:text-3xl font-black text-slate-900 leading-tight mb-4 group-hover:text-bedasGreen transition-colors">
                            <a href="{{ route('berita.detail', $beritaUtama->slug) }}" wire:navigate>{{ $beritaUtama->judul }}</a>
                        </h2>
                        <p class="text-sm text-slate-500 leading-relaxed mb-6">{{ $beritaUtama->ringkasan }}</p>
                        <a href="{{ route('berita.detail', $beritaUtama->slug) }}" wire:navigate class="self-start px-6 py-3 bg-bedasGreen text-white rounded-full font-black text-xs uppercase tracking-widest hover:bg-bedasGreen/90 transition-all flex items-center gap-2">
                            Baca Selengkapnya <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- FILTER & GRID SECTION --}}
    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-6 md:px-12">
            
            {{-- SEARCH & FILTER --}}
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-12">
                <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                    <button 
                        wire:click="filterKategori('Semua')"
                        class="px-5 py-2.5 rounded-full text-[11px] font-black uppercase tracking-widest transition-all {{ $kategoriDipilih === 'Semua' ? 'bg-bedasGreen text-white shadow-lg shadow-bedasGreen/20' : 'bg-white text-slate-600 border border-slate-200 hover:border-bedasGreen hover:text-bedasGreen' }}"
                    >
                        Semua
                    </button>
                    @foreach($kategoriList as $kat)
                        <button 
                            wire:click="filterKategori('{{ $kat->slug }}')"
                            class="px-5 py-2.5 rounded-full text-[11px] font-black uppercase tracking-widest transition-all {{ $kategoriDipilih === $kat->slug ? 'bg-bedasGreen text-white shadow-lg shadow-bedasGreen/20' : 'bg-white text-slate-600 border border-slate-200 hover:border-bedasGreen hover:text-bedasGreen' }}"
                        >
                            {{ $kat->nama_kategori }}
                        </button>
                    @endforeach
                </div>

                {{-- Search Box --}}
                <div class="w-full md:w-72 relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="Cari berita..." 
                        class="w-full pl-11 pr-4 py-2.5 rounded-full text-xs font-semibold bg-white border border-slate-200 focus:outline-none focus:border-bedasGreen focus:ring-2 focus:ring-bedasGreen/20 transition-all shadow-sm"
                    >
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                </div>
            </div>

            {{-- NEWS GRID --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($beritaList as $news)
                    <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 card-hover transition-all group cursor-pointer flex flex-col justify-between">
                        <div>
                            <div class="relative h-[220px] overflow-hidden">
                                <img src="{{ $news->gambar_utama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $news->judul }}">
                                <div class="absolute top-4 left-4">
                                    <span class="bg-bedasGreen text-white text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest shadow-xl">
                                        {{ $news->kategori->nama_kategori ?? 'Berita' }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6 space-y-3">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    {{ \Carbon\Carbon::parse($news->tanggal_publikasi)->translatedFormat('d M Y') }}
                                </span>
                                <h3 class="text-lg font-black leading-tight group-hover:text-bedasGreen transition-colors line-clamp-2 tracking-tight text-slate-800">
                                    <a href="{{ route('berita.detail', $news->slug) }}" wire:navigate>{{ $news->judul }}</a>
                                </h3>
                                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $news->ringkasan }}</p>
                            </div>
                        </div>
                        <div class="px-6 pb-6 pt-2">
                            <a href="{{ route('berita.detail', $news->slug) }}" wire:navigate class="text-xs font-bold text-bedasGreen flex items-center gap-1 hover:gap-2 transition-all">
                                Baca Selengkapnya <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <i data-lucide="inbox" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                        <p class="text-slate-500 font-bold">Tidak ada berita yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="mt-12">
                {{ $beritaList->links() }}
            </div>
        </div>
    </section>
</div>
