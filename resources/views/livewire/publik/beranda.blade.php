<div>
    <!-- HERO SECTION -->
    <section class="relative min-h-[90vh] flex items-center justify-center pt-24 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-30" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-tr from-darkBlue via-slate-950/60 to-bedasGreen/20"></div>
            <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-bedasGreen/10 blur-[150px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="flex justify-center items-center gap-6 sm:gap-8 mb-10">
                <img src="{{ asset('assets/image/logo-kab-bandung.png') }}" class="h-10 sm:h-14 md:h-16 object-contain" alt="Logo Kab Bandung" />
                <img src="{{ asset('assets/image/logo-bedas.png') }}" class="h-10 sm:h-14 md:h-16 object-contain" alt="Logo Bedas" />
                <img src="{{ asset('assets/image/logo-kormi.png') }}" class="h-10 sm:h-14 md:h-16 object-contain" alt="Logo Kormi" />
            </div>

            <div class="max-w-4xl space-y-6">
                <p class="text-lg md:text-xl font-medium text-slate-400 tracking-[0.2em] uppercase">Selamat Datang di Website Resmi</p>
                <h2 class="text-3xl md:text-6xl font-black leading-[1.2] tracking-tighter text-white uppercase">
                    KORMI <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedasGreen to-bedasLime">KABUPATEN BANDUNG</span>
                </h2>
                <p class="text-base md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed opacity-80">
                    Mewujudkan masyarakat yang sehat, bugar, gembira, dan luar biasa melalui pemberdayaan olahraga masyarakat.
                </p>
                <div class="flex flex-wrap justify-center gap-4 pt-8">
                    <a href="{{ route('inorga') }}" wire:navigate class="px-8 py-3.5 bg-bedasGreen hover:bg-bedasGreen/90 text-white rounded-full font-black text-xs shadow-2xl transition-all hover:-translate-y-1 active:scale-95 flex items-center gap-3 uppercase tracking-widest">
                        Eksplorasi Inorga <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('sejarah') }}" wire:navigate class="px-8 py-3.5 bg-transparent border-2 border-white/20 text-white rounded-full font-black text-xs hover:bg-white/10 transition-all uppercase tracking-widest">
                        Tentang Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- NEWS SECTION -->
    <section class="py-20 bg-slate-50 relative text-slate-900">
        <div class="container mx-auto px-6 md:px-12">
            <div class="flex justify-between items-end mb-12">
                <div class="space-y-3">
                    <h3 class="text-3xl font-black tracking-tight uppercase">Berita & Informasi Terbaru</h3>
                    <div class="w-16 h-1.5 bg-bedasGreen rounded-full"></div>
                </div>
                <a href="{{ route('berita') }}" wire:navigate class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-bedasGreen hover:text-green-700 transition-colors">
                    Lihat Semua Berita <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($beritaList as $news)
                    <a href="{{ route('berita.detail', $news->slug) }}" wire:navigate class="group cursor-pointer bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-500 block">
                        <div class="relative h-[220px] overflow-hidden bg-slate-100">
                            <img src="{{ $news->gambar_utama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" alt="{{ $news->judul }}" />
                            <div class="absolute top-4 left-4">
                                <span class="bg-bedasGreen text-white text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest shadow-xl">
                                    {{ $news->kategori->nama_kategori ?? 'Berita' }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 space-y-3 text-left">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                {{ \Carbon\Carbon::parse($news->tanggal_publikasi)->translatedFormat('d M Y') }}
                            </span>
                            <h4 class="text-lg font-black leading-tight group-hover:text-bedasGreen transition-colors line-clamp-2 tracking-tight text-slate-800">{{ $news->judul }}</h4>
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $news->ringkasan }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12 text-slate-400">
                        <p class="font-bold">Belum ada publikasi berita.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- EVENT SECTION: BANDUNG BEDAS RUN -->
    <section class="py-16 relative overflow-hidden bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <div class="relative group overflow-hidden rounded-[3.5rem] border-2 border-bedasGreen/20 hover:border-white/50 shadow-[0_20px_50px_-12px_rgba(27,181,92,0.1)] hover:shadow-[0_40px_80px_-20px_rgba(27,181,92,0.25)] transition-all duration-500 transform hover:-translate-y-1.5">
                <div class="absolute inset-0 z-0 overflow-hidden rounded-[3.5rem]">
                    <img src="{{ asset('assets/image/event-card-bg.jpg') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" alt="Event Background" />
                    <div class="absolute inset-0 bg-gradient-to-br from-bedasGreen/95 via-bedasGreen/90 to-bedasLime/85 mix-blend-multiply"></div>
                </div>

                <div class="relative z-10 p-8 md:p-10 lg:p-12 flex flex-col lg:flex-row items-center gap-10">
                    <div class="lg:w-1/3 flex justify-center items-center">
                        <img src="{{ asset('assets/image/run-logo.png') }}" class="w-72 h-72 md:w-[450px] md:h-[450px] object-contain transition-transform duration-700 group-hover:scale-105" alt="Bandung Bedas Run Logo" />
                    </div>

                    <div class="lg:w-2/3 space-y-8 text-left">
                        <div class="space-y-4">
                            <h2 class="text-4xl md:text-7xl font-black text-white leading-none tracking-tight italic">
                                BANDUNG <br/>
                                <span class="drop-shadow-lg uppercase italic text-white/90">BEDAS RUN</span> 2026
                            </h2>
                            <p class="text-lg md:text-xl text-white/90 font-medium leading-relaxed max-w-xl">
                                Taklukkan rute ikonik Kabupaten Bandung dan rayakan semangat bugar bersama ribuan pelari lainnya!
                            </p>
                        </div>

                        <div class="flex pt-2">
                            <a href="https://bandungbedasrun.kormibdg.id/" target="_blank" rel="noopener noreferrer" class="px-12 py-5 bg-white text-bedasGreen hover:bg-slate-100 rounded-[2rem] font-black text-sm uppercase tracking-widest shadow-xl transition-all hover:-translate-y-1.5 active:scale-95 flex items-center gap-4 group">
                                Gabung Sekarang
                                <div class="flex items-center justify-center bg-bedasGreen/10 w-8 h-8 rounded-full group-hover:bg-bedasGreen group-hover:text-white transition-colors duration-300">
                                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PILAR UTAMA -->
    <section class="py-24 bg-slate-50 overflow-hidden text-slate-900">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-16">
                <h3 class="text-2xl sm:text-4xl font-black uppercase leading-none mb-4">Program & Pilar Utama</h3>
                <div class="w-12 h-1.5 bg-bedasGreen mx-auto rounded-full mb-4"></div>
                <p class="text-slate-500 font-medium max-w-2xl mx-auto text-sm md:text-base">Sinergi program olahraga untuk mewujudkan masyarakat yang bugar dan aktif.</p>
            </div>

            <div class="grid lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-5 flex justify-center">
                    <img src="{{ asset('assets/image/foto-pimpinan.png') }}" class="w-full max-w-[450px] object-contain" alt="Bupati & Ketua KORMI" />
                </div>

                <div class="lg:col-span-7">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($kegiatanGrid as $item)
                            <a href="{{ $item['link'] }}" {{ ($item['external'] ?? false) ? 'target="_blank" rel="noopener noreferrer"' : 'wire:navigate' }} class="bg-white p-6 rounded-[2rem] border border-slate-100 card-hover group transition-all block text-left">
                                <div class="{{ $item['color'] }} w-11 h-11 rounded-[1rem] flex items-center justify-center text-white mb-4 shadow-lg group-hover:scale-110 transition-transform">
                                    <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5"></i>
                                </div>
                                <h5 class="font-black text-sm uppercase tracking-wider mb-2 leading-tight text-slate-800 group-hover:text-bedasGreen transition-colors">{{ $item['name'] }}</h5>
                                <div class="w-8 h-1 bg-slate-200 rounded-full group-hover:w-full group-hover:bg-bedasGreen transition-all duration-500"></div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
