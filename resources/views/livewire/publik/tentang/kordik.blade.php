<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-bedasGreen/20 border border-bedasGreen/30 rounded-full text-bedasGreen text-xs font-bold uppercase tracking-widest mb-4">31 Wilayah</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Koordinator <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedasGreen to-bedasLime">Kecamatan</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Struktur koordinator olahraga rekreasi tingkat kecamatan (Kordik) se-Kabupaten Bandung.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <!-- Search -->
            <div class="flex justify-between items-center mb-10">
                <h3 class="text-xl font-black uppercase text-slate-800">Daftar Koordinator Kecamatan</h3>
                <div class="relative w-full max-w-xs">
                    <input 
                        type="text" 
                        wire:model.live.debounce.250ms="cari" 
                        placeholder="Cari kecamatan / nama..." 
                        class="w-full px-5 py-2.5 rounded-full border border-slate-200 focus:outline-none focus:border-bedasGreen text-sm pl-10 shadow-xs">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-3 text-slate-400"></i>
                </div>
            </div>

            <!-- Grid Kordik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($kordikList as $kordik)
                    <div class="p-6 bg-slate-50 border border-slate-100 rounded-3xl shadow-xs hover:shadow-lg transition-all group flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 text-bedasGreen flex items-center justify-center font-black text-base shrink-0 group-hover:bg-bedasGreen group-hover:text-white transition-colors shadow-xs">
                            <i data-lucide="user-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="inline-block text-[10px] font-black text-bedasGreen uppercase tracking-widest mb-1">{{ $kordik['kec'] }}</span>
                            <h4 class="font-bold text-slate-800 text-base leading-tight">{{ $kordik['nama'] }}</h4>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 p-12 text-center text-slate-400 text-sm font-medium bg-slate-50 rounded-3xl">
                        Tidak ditemukan koordinator kecamatan yang sesuai.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
