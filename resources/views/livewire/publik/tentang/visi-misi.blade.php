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
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Visi & <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedasGreen to-bedasLime">Misi</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Arah pandang dan komitmen strategis KORMI Kabupaten Bandung dalam membangun kebugaran jasmani masyarakat.</p>
        </div>
    </section>

    <!-- VISI -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-4xl text-center">
            <span class="inline-block px-4 py-1 bg-green-50 text-bedasGreen text-xs font-black uppercase tracking-widest rounded-full mb-4">Visi Utama</span>
            <h2 class="text-2xl sm:text-4xl font-black text-slate-800 leading-snug uppercase mb-8">
                "{{ $visi }}"
            </h2>
            <div class="w-20 h-1 bg-bedasGreen mx-auto rounded-full"></div>
        </div>
    </section>

    <!-- MISI -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1 bg-green-50 text-bedasGreen text-xs font-black uppercase tracking-widest rounded-full mb-3">Misi Strategis</span>
                <h3 class="text-2xl sm:text-4xl font-black uppercase text-slate-900">Pilar Misi Organisasi</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($misiList as $m)
                    <div class="p-8 bg-white border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl transition-all">
                        <div class="w-12 h-12 {{ $m['bg'] }} {{ $m['color'] }} rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <i data-lucide="{{ $m['icon'] }}" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-black text-slate-800 text-lg mb-2 leading-tight">{{ $m['title'] }}</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ $m['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
