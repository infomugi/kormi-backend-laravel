<div>
    {{-- HERO HEADER --}}
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950">
        <div class="absolute inset-0 z-0">
            <img src="{{ $berita->gambar_utama }}" class="w-full h-full object-cover opacity-20" alt="Hero Background">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="max-w-4xl space-y-4 reveal active">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-2">
                    <span class="text-xs font-bold text-bedasLime tracking-widest uppercase">{{ $berita->kategori->nama_kategori ?? 'Berita' }}</span>
                    <span class="text-white/40">•</span>
                    <span class="text-xs font-medium text-slate-300">{{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black leading-tight tracking-tight text-white">
                    {{ $berita->judul }}
                </h1>
                <div class="flex items-center justify-center gap-4 text-xs font-medium text-slate-400 pt-2">
                    <span>Oleh: <strong class="text-white">{{ $berita->penulis->nama_lengkap ?? 'Admin KORMI' }}</strong></span>
                    <span>•</span>
                    <span><i data-lucide="eye" class="w-3.5 h-3.5 inline -mt-0.5"></i> {{ number_format($berita->jumlah_dilihat) }} pembaca</span>
                </div>
            </div>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-4xl">
            {{-- Main Image --}}
            <div class="rounded-3xl overflow-hidden shadow-2xl mb-12 border border-slate-100">
                <img src="{{ $berita->gambar_utama }}" class="w-full h-auto max-h-[500px] object-cover" alt="{{ $berita->judul }}">
            </div>

            {{-- Body Content --}}
            <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed space-y-6">
                <p class="text-xl font-semibold text-slate-900 leading-relaxed border-l-4 border-bedasGreen pl-6 py-1 italic bg-slate-50 rounded-r-2xl">
                    {{ $berita->ringkasan }}
                </p>
                <div class="space-y-4 text-base md:text-lg">
                    {!! $berita->isi_konten !!}
                </div>
            </div>

            {{-- Back button & share --}}
            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('berita') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-slate-100 text-slate-700 font-bold text-xs uppercase tracking-widest hover:bg-bedasGreen hover:text-white transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Berita
                </a>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-2">Bagikan:</span>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:scale-110 transition-transform">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- RELATED NEWS --}}
    @if($beritaTerkait->count() > 0)
    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-6 md:px-12">
            <h2 class="text-2xl font-black text-slate-900 mb-8 uppercase tracking-tight">Berita Terkait</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($beritaTerkait as $rel)
                    <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 card-hover transition-all group cursor-pointer flex flex-col justify-between">
                        <div>
                            <div class="relative h-[180px] overflow-hidden">
                                <img src="{{ $rel->gambar_utama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $rel->judul }}">
                            </div>
                            <div class="p-6 space-y-3">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($rel->tanggal_publikasi)->translatedFormat('d M Y') }}</span>
                                <h3 class="text-base font-black leading-tight group-hover:text-bedasGreen transition-colors line-clamp-2 text-slate-800">
                                    <a href="{{ route('berita.detail', $rel->slug) }}" wire:navigate>{{ $rel->judul }}</a>
                                </h3>
                            </div>
                        </div>
                        <div class="px-6 pb-6">
                            <a href="{{ route('berita.detail', $rel->slug) }}" wire:navigate class="text-xs font-bold text-bedasGreen flex items-center gap-1 hover:gap-2 transition-all">
                                Baca <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
