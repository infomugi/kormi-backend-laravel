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
                <i data-lucide="compass" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Landasan & Komitmen Strategis</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Visi & <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Misi</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Arah pandang dan komitmen strategis KORMI Kabupaten Bandung dalam membangun kebugaran jasmani masyarakat menuju Indonesia Bugar 2045.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. VISI SECTION --}}
    <section class="py-14 bg-white relative overflow-hidden">
        <div class="container mx-auto px-6 max-w-5xl relative z-10">
            <div class="relative bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 rounded-3xl p-8 sm:p-12 text-white border border-slate-800 shadow-2xl overflow-hidden text-center">
                <!-- Background ambient lights -->
                <div class="absolute top-0 right-0 w-80 h-80 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-lime-400/10 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Watermark Quote Icon -->
                <div class="absolute -bottom-6 -right-6 text-slate-800/40 pointer-events-none">
                    <i data-lucide="quote" class="w-48 h-48"></i>
                </div>

                <div class="relative z-10 max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-widest border border-emerald-500/30 mb-6">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                        <span>Visi Utama KORMI Kabupaten Bandung</span>
                    </div>

                    <h2 class="text-xl sm:text-3xl md:text-4xl font-black leading-snug sm:leading-snug tracking-tight text-slate-50 italic">
                        "{!! nl2br(e($visi)) !!}"
                    </h2>

                    <div class="mt-8 flex items-center justify-center gap-3">
                        <div class="h-1 w-12 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-full"></div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Indonesia Bugar 2045</span>
                        <div class="h-1 w-12 bg-gradient-to-r from-teal-400 to-lime-400 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. MISI SECTION --}}
    <section class="py-14 bg-slate-50/60 border-t border-slate-100">
        <div class="container mx-auto px-6 max-w-7xl">
            {{-- Section Title --}}
            <div class="text-center max-w-2xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase tracking-widest border border-emerald-200 mb-3">
                    <i data-lucide="target" class="w-3.5 h-3.5"></i>
                    <span>Misi Strategis</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight uppercase">
                    Pilar Aksi & Program Kunci
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                    Enam pilar implementasi dalam mewujudkan pembudayaan olahraga masyarakat yang berkelanjutan.
                </p>
            </div>

            {{-- Misi Grid (Rounded-3xl Cards) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($misiList as $misi)
                    <div class="group bg-white rounded-3xl border border-slate-200/90 p-7 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between relative overflow-hidden">
                        {{-- Top Glow Accent on Hover --}}
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-lime-400 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                        <div>
                            {{-- Card Header: Icon & Number Badge --}}
                            <div class="flex items-center justify-between mb-5">
                                <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-black shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                                    <i data-lucide="{{ $misi['icon'] }}" class="w-6 h-6"></i>
                                </div>
                                <span class="text-2xl font-black text-slate-300 group-hover:text-emerald-500 transition-colors font-mono">
                                    {{ $misi['number'] }}
                                </span>
                            </div>

                            {{-- Misi Content --}}
                            <h3 class="text-xs font-black uppercase tracking-wider text-emerald-800 mb-2">
                                Pilar Misi #{{ $misi['number'] }}
                            </h3>
                            <p class="text-sm font-semibold text-slate-700 leading-relaxed group-hover:text-slate-900 transition-colors">
                                {{ $misi['desc'] }}
                            </p>
                        </div>

                        {{-- Card Footer Checkmark --}}
                        <div class="pt-5 mt-5 border-t border-slate-100 flex items-center gap-2 text-[11px] font-bold text-emerald-700">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-500"></i>
                            <span>Komitmen KORMI Kab. Bandung</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. 3 PILAR OLAHRAGA CALLOUT --}}
    <section class="py-14 bg-white border-t border-slate-100">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="bg-gradient-to-r from-emerald-50 via-teal-50 to-lime-50 rounded-3xl p-8 sm:p-10 border border-emerald-200/70">
                <div class="flex items-center justify-between flex-wrap gap-6 mb-8">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-emerald-800 block mb-1">Rumpun Olahraga Masyarakat</span>
                        <h3 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">3 Komisi Utama KORMI</h3>
                    </div>
                    <a href="{{ route('inorga') }}" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-emerald-600 transition-colors inline-flex items-center gap-2 shadow-sm">
                        <span>Lihat Direktori INORGA</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-xs">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-black mb-3">
                            <i data-lucide="sparkles" class="w-5 h-5"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-900 mb-1">Komisi OTKB</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Olahraga Tradisional & Kreasi Budaya: Pelestarian kaulinan urang lembur & senam kreasi daerah.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-xs">
                        <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-black mb-3">
                            <i data-lucide="heart-pulse" class="w-5 h-5"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-900 mb-1">Komisi OKK</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Olahraga Kesehatan & Kebugaran: Senam kebugaran, yoga, aerobik, dan gaya hidup sehat.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-xs">
                        <div class="w-10 h-10 rounded-xl bg-lime-100 text-lime-700 flex items-center justify-center font-black mb-3">
                            <i data-lucide="mountain" class="w-5 h-5"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-900 mb-1">Komisi OPT</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Olahraga Petualangan & Tantangan: Olahraga ekstrem, offroad, airsoft, panahan, dan alam terbuka.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
