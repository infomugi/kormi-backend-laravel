<div>
    <!-- HERO -->
    <section class="relative min-h-[50vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-bedasGreen/20 border border-bedasGreen/30 rounded-full text-bedasGreen text-xs font-bold uppercase tracking-widest mb-4">Tentang Kami</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Sejarah <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedasGreen to-bedasLime">KORMI</span></h1>
            <p class="text-slate-400 max-w-2xl mx-auto text-sm sm:text-base font-medium">Perjalanan dan dedikasi Komite Olahraga Masyarakat Indonesia dalam mewujudkan masyarakat Kabupaten Bandung yang sehat, bugar, dan gembira.</p>
        </div>
    </section>

    <!-- NASIONAL & KOMISI -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-4xl text-slate-600 leading-relaxed text-base sm:text-lg text-justify md:text-left space-y-6">
            <div class="text-center mb-10">
                <h3 class="text-2xl sm:text-4xl font-black uppercase text-slate-900 mb-2">Transformasi Lembaga</h3>
                <div class="w-16 h-1 bg-bedasGreen mx-auto rounded-full"></div>
            </div>

            <p>
                <span class="text-4xl font-black text-slate-900 float-left mr-3 mt-1 leading-none">K</span>
                ORMI bermula dari <strong>Federasi Olahraga Masyarakat Indonesia (FOMI)</strong> yang didirikan oleh beberapa induk organisasi olahraga. Seiring dinamika kelembagaan dan regulasi, organisasi bertransformasi menjadi <strong>Federasi Olahraga Rekreasi Masyarakat Indonesia (FORMI)</strong> dan pada tahun 2020 resmi menjadi <strong>Komite Olahraga Rekreasi Masyarakat Indonesia (KORMI)</strong>, sebelum akhirnya disempurnakan menjadi <strong>Komite Olahraga Masyarakat Indonesia</strong> pada Munaslub 2023.
            </p>

            <p>
                KORMI adalah wadah resmi yang menaungi seluruh induk organisasi olahraga (Inorga) rekreasi masyarakat berdasarkan amanat <strong>Undang-Undang Nomor 11 Tahun 2022 tentang Keolahragaan</strong>.
            </p>

            <!-- 3 KOMISI -->
            <div class="pt-10">
                <h4 class="text-xl font-black text-slate-900 mb-6 uppercase text-center md:text-left">3 Komisi Olahraga Utama</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-50 border border-slate-100 p-6 rounded-3xl text-center md:text-left">
                        <div class="w-12 h-12 bg-green-100 text-bedasGreen rounded-2xl flex items-center justify-center mb-4 mx-auto md:mx-0">
                            <i data-lucide="award" class="w-6 h-6"></i>
                        </div>
                        <h5 class="font-bold text-slate-800 text-base leading-tight">Olahraga Tradisional & Kreasi Budaya (OTDA)</h5>
                    </div>

                    <div class="bg-slate-50 border border-slate-100 p-6 rounded-3xl text-center md:text-left">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-4 mx-auto md:mx-0">
                            <i data-lucide="activity" class="w-6 h-6"></i>
                        </div>
                        <h5 class="font-bold text-slate-800 text-base leading-tight">Olahraga Kesehatan & Kebugaran (OKK)</h5>
                    </div>

                    <div class="bg-slate-50 border border-slate-100 p-6 rounded-3xl text-center md:text-left">
                        <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-4 mx-auto md:mx-0">
                            <i data-lucide="mountain" class="w-6 h-6"></i>
                        </div>
                        <h5 class="font-bold text-slate-800 text-base leading-tight">Olahraga Petualangan & Tantangan (OPT)</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TIMELINE KABUPATEN BANDUNG -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="text-center mb-16">
                <h3 class="text-2xl sm:text-4xl font-black uppercase text-slate-900 mb-3">Linimasa KORMI Kab. Bandung</h3>
                <div class="w-16 h-1 bg-bedasGreen mx-auto rounded-full"></div>
            </div>

            <div class="space-y-8">
                @foreach($milestones as $m)
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition-all">
                        <span class="inline-block px-4 py-1 bg-green-50 text-bedasGreen font-black text-xs rounded-full uppercase tracking-widest mb-3">
                            {{ $m['tahun'] }}
                        </span>
                        <h4 class="text-xl font-black text-slate-800 mb-2">{{ $m['judul'] }}</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">{{ $m['deskripsi'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
