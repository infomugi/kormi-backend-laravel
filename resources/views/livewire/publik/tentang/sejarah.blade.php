<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="history" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Jejak Langkah & Dedikasi</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Sejarah <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">KORMI</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Perjalanan panjang, transformasi kelembagaan, dan komitmen pembudayaan olahraga rekreasi di Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. NARASI TRANSFORMASI KELEMBAGAAN --}}
    <section class="py-14 bg-white relative overflow-hidden">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="bg-slate-50/80 rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200/60">
                    <div class="w-2.5 h-7 bg-emerald-600 rounded-full"></div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-emerald-800 block">Kilas Transformasi</span>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">Dari FOMI hingga KORMI</h2>
                    </div>
                </div>

                <div class="space-y-4 text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                    <p>
                        <span class="text-3xl font-black text-emerald-600 float-left mr-2.5 leading-none font-serif">K</span>
                        ORMI bermula dari <strong>Federasi Olahraga Masyarakat Indonesia (FOMI)</strong> yang didirikan oleh induk-induk organisasi olahraga sebagai pelopor pembudayaan olahraga rekreasi masyarakat. Seiring perkembangan regulasi dan dinamika kelembagaan, wadah ini bertransformasi menjadi <strong>Federasi Olahraga Rekreasi Masyarakat Indonesia (FORMI)</strong>.
                    </p>
                    <p>
                        Pada tahun 2020, secara resmi nomenklatur disesuaikan menjadi <strong>Komite Olahraga Rekreasi Masyarakat Indonesia (KORMI)</strong>, dan disempurnakan menjadi <strong>Komite Olahraga Masyarakat Indonesia</strong> pada Musyawarah Nasional Luar Biasa (Munaslub) 2023.
                    </p>
                    <p>
                        Di Kabupaten Bandung, KORMI hadir sebagai mitra strategis Pemerintah Daerah berdasarkan amanat <strong>Undang-Undang Nomor 11 Tahun 2022 tentang Keolahragaan</strong>, dengan fokus utama membugarkan masyarakat, melestarikan kaulinan tradisional, serta membangun karakter masyarakat yang sehat dan berdaya saing.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. TIMELINE LINIMASA (VERTICAL ROADMAP) --}}
    <section class="py-14 bg-slate-50/60 border-t border-slate-100">
        <div class="container mx-auto px-6 max-w-4xl">
            {{-- Section Title --}}
            <div class="text-center max-w-xl mx-auto mb-14">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase tracking-widest border border-emerald-200 mb-3">
                    <i data-lucide="milestone" class="w-3.5 h-3.5"></i>
                    <span>Linimasa Peristiwa</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight uppercase">
                    Tonggak Perjalanan KORMI Kab. Bandung
                </h2>
            </div>

            {{-- Timeline Container --}}
            <div class="relative">
                <!-- Vertical Center Line -->
                <div class="absolute left-4 sm:left-1/2 top-4 bottom-4 -translate-x-1/2 w-0.5 bg-gradient-to-b from-emerald-500 via-teal-400 to-emerald-200 pointer-events-none"></div>

                <div class="space-y-8 relative">
                    @foreach($milestones as $idx => $m)
                        <div class="relative flex items-center justify-between flex-col sm:flex-row gap-6 {{ $m['posisi'] === 'left' ? 'sm:flex-row-reverse' : '' }}">
                            
                            <!-- Content Card -->
                            <div class="w-full sm:w-[calc(50%-2rem)] pl-10 sm:pl-0">
                                <div class="group bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 relative overflow-hidden">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-100">
                                            {{ $m['tahun'] }}
                                        </span>
                                        <span class="text-xs font-mono font-bold text-slate-300">#0{{ $idx + 1 }}</span>
                                    </div>

                                    <h3 class="text-base sm:text-lg font-black text-slate-900 mb-2 group-hover:text-emerald-700 transition-colors">
                                        {{ $m['judul'] }}
                                    </h3>

                                    <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                                        {{ $m['deskripsi'] }}
                                    </p>

                                    @if(!empty($m['gambar']))
                                        <div class="mt-4 rounded-2xl overflow-hidden border border-slate-100">
                                            <img src="{{ $m['gambar'] }}" alt="{{ $m['judul'] }}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform" />
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Central Timeline Node Dot -->
                            <div class="absolute left-4 sm:left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-white border-4 border-emerald-500 flex items-center justify-center shadow-md shadow-emerald-500/20 z-10">
                                <div class="w-2 h-2 rounded-full bg-emerald-600"></div>
                            </div>

                            <!-- Empty Space for balance on desktop -->
                            <div class="hidden sm:block w-[calc(50%-2rem)]"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- 4. 3 RUMPUN KOMISI SUMMARY --}}
    <section class="py-14 bg-white border-t border-slate-100">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-800 block mb-1">Rumpun Pembinaan</span>
                <h3 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">3 Pilar Komisi Olahraga</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 hover:border-emerald-300 transition-all shadow-xs">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-black mb-4">
                        <i data-lucide="award" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-base font-black text-slate-900 mb-1">Komisi OTKB</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Olahraga Tradisional & Kreasi Budaya: Melestarikan kaulinan urang lembur, ketangkasan tradisional, dan kreasi budaya Sunda.</p>
                </div>

                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 hover:border-emerald-300 transition-all shadow-xs">
                    <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center font-black mb-4">
                        <i data-lucide="heart-pulse" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-base font-black text-slate-900 mb-1">Komisi OKK</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Olahraga Kesehatan & Kebugaran: Memasyarakatkan senam kebugaran, aerobik, yoga, dan aktivitas fisik promotif-preventif.</p>
                </div>

                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 hover:border-emerald-300 transition-all shadow-xs">
                    <div class="w-12 h-12 rounded-2xl bg-lime-100 text-lime-700 flex items-center justify-center font-black mb-4">
                        <i data-lucide="mountain" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-base font-black text-slate-900 mb-1">Komisi OPT</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Olahraga Petualangan & Tantangan: Olahraga ekstrem, offroad, airsoft, panahan, layang-layang, dan petualangan alam terbuka.</p>
                </div>
            </div>
        </div>
    </section>
</div>
