<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-bedasGreen/20 border border-bedasGreen/30 rounded-full text-bedasGreen text-xs font-bold uppercase tracking-widest mb-4">Masa Bakti 2025 - 2029</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Susunan Pengurus <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedasGreen to-bedasLime">KORMI</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Susunan kepengurusan Komite Olahraga Masyarakat Indonesia Kabupaten Bandung sebagai penggerak dan pembina olahraga masyarakat.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-5xl space-y-8">
            @foreach($struktur as $kat)
                <div class="p-8 bg-slate-50 border border-slate-100 rounded-3xl shadow-sm hover:shadow-md transition-all">
                    <h3 class="text-xl font-black text-slate-800 uppercase mb-4 pb-3 border-b border-slate-200/60 flex items-center gap-3">
                        <span class="w-2.5 h-6 bg-bedasGreen rounded-full inline-block"></span>
                        {{ $kat['title'] }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($kat['members'] as $member)
                            <div class="p-4 bg-white rounded-2xl border border-slate-100 text-sm font-semibold text-slate-700 flex items-center gap-3 shadow-xs">
                                <i data-lucide="check" class="w-4 h-4 text-bedasGreen shrink-0"></i>
                                <span>{{ $member }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
