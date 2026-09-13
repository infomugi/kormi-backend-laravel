<div class="space-y-0 text-slate-800">
    <!-- ========================================================== -->
    <!-- 1. HERO SECTION: UTAMA & PINTU GERBANG PORTAL KORMI       -->
    <!-- ========================================================== -->
    <section class="relative min-h-[88vh] flex items-center justify-center pt-28 pb-20 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background with refined particle mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" onerror="this.style.display='none'" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/85 to-slate-950"></div>
            <!-- Concentrated glow spotlights -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[650px] h-[650px] bg-emerald-500/20 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-[400px] h-[400px] bg-lime-400/15 blur-[130px] rounded-full"></div>
            <div class="absolute top-1/2 left-10 w-[350px] h-[350px] bg-teal-500/15 blur-[120px] rounded-full"></div>
            <!-- Subtle Grid Lines Effect -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b10_1px,transparent_1px),linear-gradient(to_bottom,#1e293b10_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_40%,#000_70%,transparent_100%)] opacity-40"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <!-- Official Header Badge with Glow -->
            <div class="inline-flex items-center gap-3 sm:gap-4 px-4 py-2 rounded-full bg-white/[0.07] border border-white/15 backdrop-blur-2xl shadow-[0_0_30px_rgba(16,185,129,0.15)] mb-6 hover:border-emerald-400/40 hover:bg-white/[0.1] transition-all duration-300">
                <img src="{{ asset('assets/image/logo-kab-bandung.png') }}" class="h-6 sm:h-7 object-contain drop-shadow" alt="Logo Kab Bandung" />
                <div class="w-px h-4 bg-white/20"></div>
                <img src="{{ asset('assets/image/logo-bedas.png') }}" class="h-6 sm:h-7 object-contain drop-shadow" alt="Logo Bedas" />
                <div class="w-px h-4 bg-white/20"></div>
                <img src="{{ asset('assets/image/logo-kormi.png') }}" class="h-6 sm:h-7 object-contain drop-shadow" alt="Logo Kormi" />
            </div>

            <div class="max-w-4xl space-y-5">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 backdrop-blur-md">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Portal Resmi Komite Olahraga Masyarakat Indonesia</span>
                </div>
                
                <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-black leading-[1.08] tracking-tight text-white uppercase drop-shadow-sm">
                    KORMI <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">KABUPATEN BANDUNG</span>
                </h1>
                
                <p class="text-sm sm:text-base md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed opacity-90">
                    Mewadahi, membina, dan mengembangkan olahraga rekreasi untuk menciptakan masyarakat Kabupaten Bandung yang <span class="text-emerald-400 font-bold">Sehat</span>, <span class="text-lime-300 font-bold">Bugar</span>, dan <span class="text-teal-300 font-bold">Gembira</span>.
                </p>

                <!-- Action Hub Buttons -->
                <div class="flex flex-wrap justify-center items-center gap-3.5 pt-4">
                    <a href="{{ route('partisipasi.catat') }}" wire:navigate class="px-7 py-3.5 bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white rounded-full font-black text-xs shadow-xl shadow-emerald-950/50 hover:shadow-emerald-500/30 transition-all duration-300 hover:-translate-y-0.5 active:scale-95 flex items-center gap-2.5 uppercase tracking-wider group border border-emerald-400/30">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Catat Olahraga Warga</span>
                    </a>
                    <a href="{{ route('inorga') }}" wire:navigate class="px-6 py-3.5 bg-white/[0.08] hover:bg-white/[0.15] border border-white/15 text-white rounded-full font-bold text-xs backdrop-blur-xl transition-all duration-300 hover:-translate-y-0.5 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-lime-400"></i>
                        <span>Direktori INORGA</span>
                    </a>
                    <a href="#modul-terpadu" class="px-5 py-3.5 hover:text-emerald-400 text-slate-300 hover:bg-white/5 rounded-full font-bold text-xs transition-all uppercase tracking-wider">
                        Jelajahi Fitur
                    </a>
                </div>
            </div>
        </div>

        <!-- Sleek bottom blend -->
        <div class="absolute bottom-0 left-0 right-0 h-14 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    <!-- ========================================================== -->
    <!-- 2. EXECUTIVE METRICS BAR: STATISTIK KEOLAHRAGAAN & WARGA  -->
    <!-- ========================================================== -->
    <section class="relative z-20 -mt-12 max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 p-4 sm:p-5 bg-white/95 rounded-3xl border border-slate-200/90 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.09)] backdrop-blur-2xl">
            <!-- Metric 1: INORGA -->
            <a href="{{ route('inorga') }}" wire:navigate class="group p-4 sm:p-4.5 rounded-2xl bg-slate-50/80 hover:bg-emerald-50/70 border border-slate-200/70 hover:border-emerald-300/90 transition-all duration-300 flex items-center gap-3.5 text-left hover:shadow-md">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-md shadow-emerald-500/25 group-hover:scale-110 group-hover:rotate-2 transition-transform shrink-0">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </div>
                <div class="min-w-0">
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none">{{ $stats['totalInorga'] }}</span>
                        <span class="text-emerald-600 font-black text-lg leading-none">+</span>
                    </div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-wider mt-1 group-hover:text-emerald-700 transition-colors truncate">INORGA Induk</div>
                </div>
            </a>

            <!-- Metric 2: KORCAM -->
            <a href="{{ route('kordikecamatan') }}" wire:navigate class="group p-4 sm:p-4.5 rounded-2xl bg-slate-50/80 hover:bg-blue-50/70 border border-slate-200/70 hover:border-blue-300/90 transition-all duration-300 flex items-center gap-3.5 text-left hover:shadow-md">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/25 group-hover:scale-110 group-hover:rotate-2 transition-transform shrink-0">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                </div>
                <div class="min-w-0">
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none">{{ $stats['totalKecamatan'] }}</span>
                        <span class="text-blue-600 font-bold text-xs uppercase leading-none">Kec</span>
                    </div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-wider mt-1 group-hover:text-blue-700 transition-colors truncate">KORCAM Wilayah</div>
                </div>
            </a>

            <!-- Metric 3: PARTISIPASI AKTIF WARGA -->
            <a href="{{ route('partisipasi.riwayat') }}" wire:navigate class="group p-4 sm:p-4.5 rounded-2xl bg-slate-50/80 hover:bg-lime-50/70 border border-slate-200/70 hover:border-lime-300/90 transition-all duration-300 flex items-center gap-3.5 text-left hover:shadow-md">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-lime-500 to-emerald-600 flex items-center justify-center text-white shadow-md shadow-lime-500/25 group-hover:scale-110 group-hover:rotate-2 transition-transform shrink-0">
                    <i data-lucide="activity" class="w-5 h-5"></i>
                </div>
                <div class="min-w-0">
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none">{{ number_format($stats['totalAktivitasWarga'] > 0 ? $stats['totalAktivitasWarga'] : $stats['totalDuta']) }}</span>
                        <span class="text-lime-600 font-black text-sm uppercase leading-none">{{ $stats['totalAktivitasWarga'] > 0 ? 'Log' : 'Duta' }}</span>
                    </div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-wider mt-1 group-hover:text-lime-700 transition-colors truncate">Aktivitas APMO</div>
                </div>
            </a>

            <!-- Metric 4: SAPRAS OLAHRAGA -->
            <a href="{{ route('sapras') }}" wire:navigate class="group p-4 sm:p-4.5 rounded-2xl bg-slate-50/80 hover:bg-purple-50/70 border border-slate-200/70 hover:border-purple-300/90 transition-all duration-300 flex items-center gap-3.5 text-left hover:shadow-md">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-fuchsia-600 flex items-center justify-center text-white shadow-md shadow-purple-500/25 group-hover:scale-110 group-hover:rotate-2 transition-transform shrink-0">
                    <i data-lucide="building" class="w-5 h-5"></i>
                </div>
                <div class="min-w-0">
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none">{{ $stats['totalSapras'] }}</span>
                        <span class="text-purple-600 font-black text-lg leading-none">+</span>
                    </div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-wider mt-1 group-hover:text-purple-700 transition-colors truncate">Fasilitas Sarpras</div>
                </div>
            </a>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- 3. MODUL PARTISIPASI WARGA (APMO LIVE TRACKER BANNER)     -->
    <!-- ========================================================== -->
    <section class="py-14 bg-white relative">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 via-slate-900 to-teal-950 p-6 sm:p-10 text-white shadow-xl shadow-emerald-950/10 border border-emerald-800/40">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                <div class="absolute -right-16 -top-16 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 grid md:grid-cols-12 gap-6 items-center">
                    <div class="md:col-span-8 space-y-3 text-left">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-[10px] font-black uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Modul Partisipasi & Kebugaran Warga
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight uppercase">
                            Catat Aktivitas Olahraga Anda, <span class="text-lime-300">Raih Badge APMO!</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal max-w-2xl">
                            Setiap sesi senam, lari pagi, gowes, atau permainan tradisional yang Anda lakukan berkontribusi langsung pada perhitungan <strong>Angka Partisipasi Masyarakat Olahraga (APMO)</strong> Kabupaten Bandung Bedas.
                        </p>
                    </div>

                    <div class="md:col-span-4 flex flex-col sm:flex-row md:flex-col gap-3">
                        <a 
                            href="{{ route('partisipasi.catat') }}" 
                            wire:navigate
                            class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:brightness-110 active:scale-98 text-white font-black text-xs uppercase tracking-wider transition-all shadow-lg shadow-emerald-900/40 flex items-center justify-center gap-2"
                        >
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                            <span>Catat Sesi Sekarang</span>
                        </a>
                        <a 
                            href="{{ route('partisipasi.riwayat') }}" 
                            wire:navigate
                            class="px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/20 active:scale-98 text-white font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2"
                        >
                            <i data-lucide="award" class="w-4 h-4 text-amber-400"></i>
                            <span>Riwayat & Capaian Saya</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- 4. MODUL PROFIL & KEPEMIMPINAN STRATEGIS                   -->
    <!-- ========================================================== -->
    <section class="py-16 bg-slate-50/70 relative overflow-hidden">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="grid lg:grid-cols-12 gap-10 items-center">
                
                <!-- Foto Pimpinan (Ultra-Clean Executive Display) -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative w-full max-w-[400px]">
                        <!-- Ambient backdrop glow -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500/20 to-lime-400/20 rounded-[2.5rem] blur-2xl transform -rotate-2 scale-95 pointer-events-none"></div>

                        <div class="relative bg-white rounded-[2.5rem] p-4 border border-slate-200/90 shadow-2xl shadow-slate-200/70 overflow-hidden">
                            <!-- Image Container -->
                            <div class="relative rounded-2xl overflow-hidden bg-gradient-to-b from-slate-50 to-emerald-50/40 p-2">
                                <img src="{{ asset('assets/image/foto-pimpinan.png') }}" class="w-full h-auto object-contain hover:scale-[1.03] transition-transform duration-500" alt="Bupati & Ketua KORMI" onerror="this.src='https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800'" />
                            </div>

                            <!-- Executive Label Banner -->
                            <div class="mt-3 p-3.5 bg-gradient-to-r from-slate-950 via-slate-900 to-emerald-950 text-white rounded-2xl border border-slate-800 shadow-md text-center space-y-1">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[9px] font-black uppercase tracking-widest border border-emerald-500/30">
                                    <i data-lucide="shield-check" class="w-3 h-3"></i> Kolaborasi Kepemimpinan
                                </div>
                                <h5 class="text-xs font-black tracking-wide text-white uppercase">Sinergi Pemkab & KORMI</h5>
                                <p class="text-[10px] text-slate-400 font-medium">Mewujudkan Masyarakat Kabupaten Bandung BEDAS</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konten Penjelasan & 3 Pilar -->
                <div class="lg:col-span-7 space-y-5 text-left">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100/80 text-emerald-800 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-300/40">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-emerald-600"></i> Komitmen & Visi Strategis
                    </div>
                    
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase leading-tight tracking-tight text-slate-900">
                        Membangun Budaya Hidup Bugar Melalui <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Olahraga Rekreasi</span>
                    </h2>
                    
                    <p class="text-slate-600 leading-relaxed text-sm font-normal">
                        KORMI Kabupaten Bandung berkomitmen menghidupkan kembali tradisi olahraga rakyat, memperkuat kebugaran massal masyarakat, serta memfasilitasi minat generasi muda dalam olahraga tantangan dan petualangan.
                    </p>

                    <!-- 3 Cards: Sehat, Bugar, Gembira -->
                    <div class="grid sm:grid-cols-3 gap-3.5 pt-1">
                        <!-- 01. Sehat -->
                        <div class="group relative p-4 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-300">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i data-lucide="heart" class="w-4 h-4"></i>
                            </div>
                            <div class="text-emerald-700 font-black text-sm uppercase tracking-wider">01. SEHAT</div>
                            <p class="text-[11px] text-slate-500 font-medium leading-relaxed mt-1">Kondisi fisik prima dan terbebas dari ancaman penyakit.</p>
                        </div>

                        <!-- 02. Bugar -->
                        <div class="group relative p-4 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-teal-300 transition-all duration-300">
                            <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i data-lucide="zap" class="w-4 h-4"></i>
                            </div>
                            <div class="text-teal-700 font-black text-sm uppercase tracking-wider">02. BUGAR</div>
                            <p class="text-[11px] text-slate-500 font-medium leading-relaxed mt-1">Stamina energik untuk menjalani produktivitas kerja harian.</p>
                        </div>

                        <!-- 03. Gembira -->
                        <div class="group relative p-4 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-lime-400 transition-all duration-300">
                            <div class="w-8 h-8 rounded-xl bg-lime-50 text-lime-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i data-lucide="smile" class="w-4 h-4"></i>
                            </div>
                            <div class="text-lime-700 font-black text-sm uppercase tracking-wider">03. GEMBIRA</div>
                            <p class="text-[11px] text-slate-500 font-medium leading-relaxed mt-1">Aktivitas rekreatif penuh keceriaan dan silaturahmi.</p>
                        </div>
                    </div>

                    <div class="pt-2 flex flex-wrap gap-3">
                        <a href="{{ route('sejarah') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-900 text-white hover:bg-emerald-600 text-xs font-bold uppercase tracking-wider shadow-md transition-all duration-200 group">
                            <span>Sejarah KORMI</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('pengurus') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold uppercase tracking-wider shadow-xs transition-all duration-200">
                            <span>Struktur Pengurus</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- 5. MODUL KEOLAHRAGAAN: 3 RUMPUN KOMISI & DIREKTORI INORGA  -->
    <!-- ========================================================== -->
    <section id="komisi-section" class="py-16 bg-white relative">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-3">
                <div class="space-y-1 text-left">
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-200/60">Modul Keolahragaan</span>
                    <h3 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900">3 Rumpun Komisi Olahraga</h3>
                </div>
                <p class="text-xs text-slate-500 max-w-md text-left md:text-right">Mewadahi puluhan induk organisasi olahraga rekreasi (INORGA) sesuai spesifikasi rumpun pembinaan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($komisiList as $komisi)
                    @php
                        $isTradisional = str_contains(strtolower($komisi->nama_komisi), 'tradisional') || $komisi->singkatan === 'OTDA';
                        $isKebugaran = str_contains(strtolower($komisi->nama_komisi), 'kesehatan') || $komisi->singkatan === 'OKK';
                        $bgGradient = $isTradisional ? 'from-emerald-600 to-teal-800' : ($isKebugaran ? 'from-blue-600 to-indigo-800' : 'from-amber-600 to-orange-800');
                        $iconName = $isTradisional ? 'flag' : ($isKebugaran ? 'heart-pulse' : 'compass');
                    @endphp
                    <div class="relative group rounded-3xl bg-slate-900 text-white p-6 overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">
                        <!-- Top subtle glow -->
                        <div class="absolute top-0 right-0 w-36 h-36 bg-gradient-to-br {{ $bgGradient }} opacity-25 blur-2xl rounded-full group-hover:opacity-45 transition-opacity"></div>
                        
                        <div class="relative z-10 space-y-4">
                            <div class="flex justify-between items-center">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $bgGradient }} flex items-center justify-center text-white shadow-md">
                                    <i data-lucide="{{ $iconName }}" class="w-5 h-5"></i>
                                </div>
                                <span class="px-2.5 py-0.5 bg-white/10 rounded-full text-[10px] font-black uppercase tracking-wider text-emerald-400 border border-white/10">
                                    {{ $komisi->singkatan ?? 'KOMISI' }}
                                </span>
                            </div>

                            <div class="space-y-1.5 text-left">
                                <h4 class="text-lg font-black uppercase leading-snug tracking-tight">{{ $komisi->nama_komisi }}</h4>
                                <p class="text-slate-400 text-xs leading-relaxed">
                                    @if($isTradisional)
                                        Melestarikan olahraga tradisional, permainan rakyat nusantara, dan kreasi budaya.
                                    @elseif($isKebugaran)
                                        Meningkatkan kebugaran jasmani melalui senam, aerobik, dan olahraga massal.
                                    @else
                                        Mewadahi olahraga tantangan, petualangan alam terbuka, dan hobi modern.
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="relative z-10 pt-5 mt-5 border-t border-white/10 flex items-center justify-between">
                            <div class="text-left">
                                <div class="text-xl font-black text-white leading-none">{{ $komisi->inorga_count }}</div>
                                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">INORGA Terdaftar</div>
                            </div>
                            <a href="{{ route('inorga') }}?komisi={{ $komisi->id }}" wire:navigate class="w-8 h-8 rounded-full bg-white/10 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-colors" title="Lihat Daftar INORGA">
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- 6. MODUL EVENT & FESTIVAL OLAHRAGA MASYARAKAT             -->
    <!-- ========================================================== -->
    <section class="py-16 bg-slate-50/80 relative overflow-hidden">
        <div class="container mx-auto px-6 max-w-6xl">
            <!-- Bedas Run Flagship Banner -->
            <div class="relative group overflow-hidden rounded-3xl border border-emerald-500/20 shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 mb-8">
                <div class="absolute inset-0 z-0 overflow-hidden rounded-3xl">
                    <img src="{{ asset('assets/image/event-card-bg.jpg') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Event Background" onerror="this.src='https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=1200'" />
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-800/95 via-emerald-900/90 to-slate-950/90 mix-blend-multiply"></div>
                </div>

                <div class="relative z-10 p-6 sm:p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-3 text-left max-w-xl">
                        <span class="inline-block px-3 py-1 rounded-full bg-white/15 text-white font-extrabold text-[10px] uppercase tracking-wider border border-white/20">
                            Modul Event & Festival
                        </span>
                        <h2 class="text-2xl sm:text-4xl font-black text-white leading-tight uppercase tracking-tight">
                            BANDUNG BEDAS RUN <span class="text-lime-300">2026</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                            Ajang lari rekreasi terbesar di Kabupaten Bandung. Taklukkan rute ikonik dan rayakan semangat bugar bersama ribuan pelari!
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 shrink-0">
                        <a href="https://bandungbedasrun.kormibdg.id/" target="_blank" rel="noopener noreferrer" class="px-6 py-3 bg-white text-emerald-800 hover:bg-slate-100 rounded-full font-black text-xs uppercase tracking-wider shadow-lg transition-all flex items-center justify-center gap-2">
                            <span>Portal Registrasi</span>
                            <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                        </a>
                        <a href="{{ route('forkab') }}" wire:navigate class="px-5 py-3 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-full font-bold text-xs uppercase tracking-wider transition-all text-center">
                            Info FORKAB
                        </a>
                        <a href="{{ route('fotradkab') }}" wire:navigate class="px-5 py-3 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-full font-bold text-xs uppercase tracking-wider transition-all text-center">
                            Info FOTRADKAB
                        </a>
                    </div>
                </div>
            </div>

            <!-- Event Agenda List Grid -->
            @if($eventList->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($eventList as $ev)
                        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm flex gap-4 items-center">
                            <div class="w-28 h-20 rounded-xl overflow-hidden bg-slate-100 shrink-0">
                                <img src="{{ $ev->banner_url ?? 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800' }}" class="w-full h-full object-cover" alt="{{ $ev->judul_event }}" />
                            </div>
                            <div class="space-y-1 flex-1 text-left min-w-0">
                                <span class="text-[9px] font-black px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-md uppercase tracking-wider">
                                    {{ $ev->kategoriEvent->nama_kategori ?? 'Agenda' }}
                                </span>
                                <h4 class="text-sm font-black text-slate-900 leading-snug truncate">{{ $ev->judul_event }}</h4>
                                <div class="text-[11px] font-semibold text-slate-400 flex items-center gap-1.5 truncate">
                                    <i data-lucide="map-pin" class="w-3 h-3 text-emerald-600 shrink-0"></i>
                                    <span class="truncate">{{ $ev->lokasi_utama }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- 7. ONE-STOP MATRIKS MODUL & FITUR LENGKAP APLIKASI         -->
    <!-- ========================================================== -->
    <section id="modul-terpadu" class="py-20 bg-white relative">
        <div class="container mx-auto px-6 max-w-6xl">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
                <div class="space-y-2 text-left">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100/80 text-emerald-800 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-300/40">
                        <i data-lucide="grid" class="w-3 h-3 text-emerald-600"></i> Ekosistem Fitur & Layanan
                    </span>
                    <h3 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase tracking-tight text-slate-900">
                        Pusat Layanan & Data KORMI
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-xl">
                        Akses terpadu ke seluruh modul: direktori keolahragaan, sistem SDI/APMO, inventaris sarpras, hingga repositori unduhan resmi.
                    </p>
                </div>
                <div class="hidden sm:flex items-center gap-2 text-xs font-bold text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>8 Modul Sistem Terintegrasi</span>
                </div>
            </div>

            <!-- Grid 8 Modul Pro Matrix -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($kegiatanGrid as $item)
                    <a href="{{ $item['link'] }}" {{ ($item['external'] ?? false) ? 'target="_blank" rel="noopener noreferrer"' : 'wire:navigate' }} class="group relative bg-slate-50/70 hover:bg-white rounded-3xl p-5 border border-slate-200/80 hover:border-emerald-300 shadow-xs hover:shadow-xl transition-all duration-300 block text-left transform hover:-translate-y-1 overflow-hidden flex flex-col justify-between">
                        <!-- Top Accent Bar -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r {{ $item['bg_gradient'] }} opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div>
                            <!-- Header Card: Icon + Category Badge -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $item['bg_gradient'] }} flex items-center justify-center text-white shadow-md group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                                    <i data-lucide="{{ $item['icon'] }}" class="w-6 h-6"></i>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider {{ $item['bg_light'] }} {{ $item['text_color'] }} border border-slate-100">
                                    {{ $item['badge'] }}
                                </span>
                            </div>

                            <!-- Title & Description -->
                            <div class="space-y-1.5">
                                <h4 class="font-black text-base uppercase tracking-tight text-slate-900 group-hover:text-emerald-600 transition-colors flex items-center gap-1.5">
                                    <span>{{ $item['name'] }}</span>
                                    @if($item['external'] ?? false)
                                        <i data-lucide="external-link" class="w-3.5 h-3.5 opacity-50 group-hover:opacity-100 transition-opacity"></i>
                                    @endif
                                </h4>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed line-clamp-3">
                                    {{ $item['desc'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Footer Action Link -->
                        <div class="pt-4 mt-4 border-t border-slate-200/60 flex items-center justify-between">
                            <span class="text-[11px] font-black uppercase tracking-wider text-slate-600 group-hover:text-emerald-600 transition-colors">
                                Masuk Modul
                            </span>
                            <div class="w-7 h-7 rounded-full bg-white group-hover:bg-emerald-500 group-hover:text-white flex items-center justify-center text-slate-500 transition-all duration-300 shadow-xs">
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- 8. MODUL MEDIA: WARTA & BERITA TERKINI                     -->
    <!-- ========================================================== -->
    <section class="py-20 bg-slate-50/70 relative">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-10 gap-4">
                <div class="space-y-2 text-left">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100/80 text-emerald-800 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-300/40">
                        <i data-lucide="newspaper" class="w-3 h-3 text-emerald-600"></i> Media Center & Publikasi
                    </span>
                    <h3 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase tracking-tight text-slate-900">
                        Warta & Liputan Terkini
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-xl">
                        Informasi liputan agenda, capaian prestasi pegiat, dan pengumuman resmi KORMI Kabupaten Bandung.
                    </p>
                </div>
                <a href="{{ route('berita') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white hover:bg-emerald-50 border border-slate-200/90 text-xs font-black uppercase tracking-wider text-slate-700 hover:text-emerald-700 transition-all shadow-sm group shrink-0">
                    <span>Semua Warta</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($beritaList as $news)
                    <a href="{{ route('berita.detail', $news->slug) }}" wire:navigate class="group cursor-pointer bg-white rounded-3xl overflow-hidden border border-slate-200/80 hover:border-emerald-300 shadow-sm hover:shadow-xl transition-all duration-300 block hover:-translate-y-1 flex flex-col justify-between">
                        <div>
                            <!-- Image Container with Gradient Overlay -->
                            <div class="relative h-48 sm:h-52 overflow-hidden bg-slate-100">
                                <img src="{{ $news->gambar_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $news->judul }}" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'" />
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
                                <div class="absolute top-3.5 left-3.5">
                                    <span class="bg-emerald-600 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                                        {{ $news->kategori->nama_kategori ?? 'Warta KORMI' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Body Content -->
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
                                <h4 class="text-base font-black leading-snug group-hover:text-emerald-600 transition-colors line-clamp-2 tracking-tight text-slate-900">
                                    {{ $news->judul }}
                                </h4>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed line-clamp-2">
                                    {{ $news->ringkasan }}
                                </p>
                            </div>
                        </div>

                        <!-- Read More Link -->
                        <div class="px-5 pb-5 pt-1 text-left border-t border-slate-50">
                            <span class="text-xs font-black text-emerald-600 group-hover:text-emerald-700 inline-flex items-center gap-1">
                                <span>Selengkapnya</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-dashed border-slate-300 text-slate-400">
                        <i data-lucide="newspaper" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
                        <p class="text-sm font-bold">Belum ada publikasi berita terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- 9. MODUL DOKUMENTASI: GALERI AKSI & KEGIATAN LAPANGAN      -->
    <!-- ========================================================== -->
    @if($galeriList->isNotEmpty())
        <section class="py-20 bg-white relative">
            <div class="container mx-auto px-6 max-w-6xl">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-10 gap-4">
                    <div class="space-y-2 text-left">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100/80 text-emerald-800 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-300/40">
                            <i data-lucide="camera" class="w-3 h-3 text-emerald-600"></i> Dokumentasi Lapangan
                        </span>
                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase tracking-tight text-slate-900">
                            Galeri Aksi & Semangat Bugar
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-xl">
                            Potret keseruan, keceriaan, dan kekompakan warga serta pegiat olahraga masyarakat di 31 kecamatan.
                        </p>
                    </div>
                    <a href="{{ route('galeri') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-100 hover:bg-emerald-50 text-xs font-black uppercase tracking-wider text-slate-700 hover:text-emerald-700 transition-all group shrink-0">
                        <span>Lihat Semua Foto</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3.5">
                    @foreach($galeriList as $foto)
                        <div class="group relative h-40 sm:h-44 rounded-2xl overflow-hidden bg-slate-100 shadow-sm border border-slate-200/70 hover:border-emerald-400 hover:shadow-lg transition-all duration-300 cursor-pointer">
                            <img src="{{ $foto->foto_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $foto->judul_foto }}" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'" />
                            
                            <!-- Overlay Text with Glass Effect on Hover -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 p-3 flex flex-col justify-end text-left">
                                <span class="text-[9px] font-black uppercase tracking-widest text-emerald-400 mb-0.5">Dokumentasi</span>
                                <p class="text-[11px] font-bold text-white leading-snug line-clamp-2">{{ $foto->judul_foto }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- ========================================================== -->
    <!-- 10. MODUL KONTAK & KEMITRAAN KOMUNITAS                     -->
    <!-- ========================================================== -->
    <section class="py-16 bg-slate-50 relative overflow-hidden">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-900 to-emerald-950 p-8 sm:p-12 text-white shadow-2xl border border-slate-800 flex flex-col md:flex-row items-center justify-between gap-8">
                <!-- Ambient glow in card -->
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-emerald-500/15 blur-3xl rounded-full pointer-events-none"></div>
                <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-teal-500/10 blur-3xl rounded-full pointer-events-none"></div>

                <div class="relative z-10 space-y-3 text-left max-w-xl">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black tracking-wider uppercase bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i> Sinergi Bersama KORMI
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white leading-tight">
                        Punya Komunitas Olahraga Rekreasi?
                    </h2>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed font-normal">
                        Daftarkan komunitas Anda menjadi bagian dari INORGA KORMI Kabupaten Bandung atau jalin koordinasi dengan KORCAM di wilayah kecamatan Anda.
                    </p>
                </div>

                <div class="relative z-10 flex flex-col sm:flex-row md:flex-col gap-3 shrink-0 w-full sm:w-auto">
                    <a href="{{ route('kontak') }}" wire:navigate class="px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-white rounded-full font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-950/40 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                        <span>Hubungi Sekretariat</span>
                    </a>
                    <a href="{{ route('kordikecamatan') }}" wire:navigate class="px-6 py-3 bg-white/10 hover:bg-white/15 border border-white/20 text-white rounded-full font-bold text-xs uppercase tracking-wider transition-all text-center">
                        Daftar KORCAM
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
