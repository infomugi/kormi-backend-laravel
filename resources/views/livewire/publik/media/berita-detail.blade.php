<div>
    {{-- 1. HERO HEADER WITH CLEAN EDITORIAL TITLE --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="{{ $berita->gambar_url }}" class="w-full h-full object-cover opacity-15 scale-105 blur-xs" alt="{{ $berita->judul }}" onerror="this.style.display='none'" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="max-w-4xl space-y-4">
                {{-- Breadcrumb / Category Tag --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-wider uppercase border border-emerald-500/30 backdrop-blur-md">
                    <a href="{{ route('berita') }}" wire:navigate class="hover:text-white transition-colors">Warta</a>
                    <span class="text-white/40">/</span>
                    <span>{{ $berita->kategori->nama_kategori ?? 'Umum' }}</span>
                </div>

                {{-- Headline Title --}}
                <h1 class="text-2xl sm:text-4xl md:text-5xl font-black leading-tight tracking-tight text-white">
                    {{ $berita->judul }}
                </h1>

                {{-- Meta Details --}}
                <div class="flex items-center justify-center gap-3 sm:gap-4 text-xs font-semibold text-slate-300 pt-2 flex-wrap">
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="user" class="w-3.5 h-3.5 text-emerald-400"></i>
                        <span class="text-white font-bold">{{ $berita->penulis->nama_lengkap ?? 'Redaksi KORMI' }}</span>
                    </span>
                    <span class="text-slate-500">•</span>
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-emerald-400"></i>
                        <span>{{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                    </span>
                    <span class="text-slate-500">•</span>
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>{{ $berita->estimasi_menit_baca ?? 2 }} mnt baca</span>
                    </span>
                    <span class="text-slate-500">•</span>
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="eye" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>{{ number_format($berita->jumlah_dilihat ?? 0) }}x dibaca</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. ARTICLE BODY CONTENT --}}
    <section class="py-14 bg-white relative">
        <div class="container mx-auto px-6 max-w-4xl">
            
            {{-- Main Featured Image with Frame --}}
            <div class="rounded-3xl overflow-hidden shadow-2xl border border-slate-200/90 mb-10 bg-slate-100">
                <img 
                    src="{{ $berita->gambar_url }}" 
                    class="w-full h-auto max-h-[520px] object-cover" 
                    alt="{{ $berita->judul }}" 
                    onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'" 
                />
            </div>

            {{-- Lead Paragraph Quote --}}
            @if(!empty($berita->ringkasan))
                <div class="p-6 sm:p-8 rounded-3xl bg-slate-50 border-l-4 border-emerald-500 text-slate-800 text-base md:text-lg font-semibold leading-relaxed mb-10 shadow-xs">
                    "{{ $berita->ringkasan }}"
                </div>
            @endif

            {{-- Main Rich Body Content --}}
            <article class="prose prose-slate prose-base sm:prose-lg max-w-none text-slate-700 leading-relaxed font-normal">
                {!! $berita->isi_konten !!}
            </article>

            {{-- Action & Share Toolbar --}}
            <div class="mt-14 pt-8 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <a 
                    href="{{ route('berita') }}" 
                    wire:navigate 
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 font-black text-xs uppercase tracking-wider transition-all shadow-xs"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Kembali ke Warta Berita</span>
                </a>

                <div class="flex items-center gap-2.5">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider mr-1">Bagikan Artikel:</span>
                    <a 
                        href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        class="w-10 h-10 rounded-2xl bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white flex items-center justify-center transition-all border border-emerald-200/80 shadow-xs" 
                        title="Bagikan ke WhatsApp"
                    >
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                    </a>
                    <a 
                        href="https://facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        class="w-10 h-10 rounded-2xl bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white flex items-center justify-center transition-all border border-blue-200/80 shadow-xs" 
                        title="Bagikan ke Facebook"
                    >
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. RELATED NEWS SECTION --}}
    @if(isset($beritaTerkait) && $beritaTerkait->count() > 0)
        <section class="py-16 bg-slate-50/70 border-t border-slate-200/80">
            <div class="container mx-auto px-6 max-w-6xl">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-emerald-800 block">Kategori Terkait</span>
                        <h3 class="text-xl sm:text-2xl font-black text-slate-900 uppercase tracking-tight">
                            Warta Rekomendasi Lainnya
                        </h3>
                    </div>
                    <a href="{{ route('berita') }}" wire:navigate class="px-4 py-2 rounded-full bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:text-emerald-600 hover:border-emerald-300 uppercase tracking-wider flex items-center gap-1.5 transition-all shadow-xs">
                        <span>Lihat Semua</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($beritaTerkait as $rel)
                        <a 
                            href="{{ route('berita.detail', $rel->slug) }}" 
                            wire:navigate 
                            class="group bg-white rounded-3xl overflow-hidden border border-slate-200/80 hover:border-emerald-300 shadow-sm hover:shadow-xl transition-all duration-300 block hover:-translate-y-1 flex flex-col justify-between"
                        >
                            <div>
                                <div class="relative h-44 overflow-hidden bg-slate-100">
                                    <img 
                                        src="{{ $rel->gambar_url }}" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                        alt="{{ $rel->judul }}" 
                                        onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'" 
                                    />
                                    <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-lg bg-slate-900/80 backdrop-blur-md text-[10px] font-black text-white uppercase tracking-wider">
                                        {{ $rel->kategori->nama_kategori ?? 'Warta' }}
                                    </span>
                                </div>
                                <div class="p-5 space-y-2 text-left">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">
                                        {{ \Carbon\Carbon::parse($rel->tanggal_publikasi)->translatedFormat('d M Y') }}
                                    </span>
                                    <h4 class="text-sm font-black leading-snug group-hover:text-emerald-600 transition-colors line-clamp-2 text-slate-900">
                                        {{ $rel->judul }}
                                    </h4>
                                </div>
                            </div>
                            <div class="px-5 pb-5 pt-1 text-left">
                                <span class="text-xs font-extrabold text-emerald-600 group-hover:underline inline-flex items-center gap-1">
                                    <span>Baca Selengkapnya</span>
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

