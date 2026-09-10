<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-bedasGreen/20 border border-bedasGreen/30 rounded-full text-bedasGreen text-xs font-bold uppercase tracking-widest mb-4">Penggerak Masyarakat</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Duta Olahraga Desa & Kelurahan</h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Mengenal para pegiat dan penggerak olahraga masyarakat di 280 Desa dan Kelurahan se-Kabupaten Bandung.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <!-- Filter & Search -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-10">
                <div class="w-full md:w-72">
                    <select wire:model.live="kecamatanDipilih" class="w-full px-5 py-3 rounded-full border border-slate-200 focus:outline-none focus:border-bedasGreen text-sm font-semibold">
                        <option value="">Semua Kecamatan (31)</option>
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="relative w-full md:w-80">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="Cari nama duta / desa..." 
                        class="w-full px-5 py-3 rounded-full border border-slate-200 focus:outline-none focus:border-bedasGreen text-sm pl-11 shadow-sm">
                    <i data-lucide="search" class="w-4 h-4 absolute left-4 top-3.5 text-slate-400"></i>
                </div>
            </div>

            <!-- Grid Duta -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($dutaList as $duta)
                    <div class="p-6 bg-white border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl transition-all text-center group">
                        <div class="w-20 h-20 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-bedasGreen mb-4 font-black text-2xl group-hover:scale-105 transition-transform shadow-inner">
                            {{ substr($duta->nama_lengkap, 0, 1) }}
                        </div>
                        <h4 class="font-black text-slate-800 text-base leading-snug mb-1 group-hover:text-bedasGreen transition-colors">{{ $duta->nama_lengkap }}</h4>
                        <p class="text-xs font-bold text-bedasGreen uppercase tracking-wider mb-2">Desa {{ $duta->desaKelurahan->nama_desa_kelurahan ?? '-' }}</p>
                        <span class="inline-block px-3 py-1 bg-slate-50 border border-slate-100 rounded-full text-[10px] font-semibold text-slate-500 uppercase tracking-widest">
                            Kec. {{ $duta->kecamatan->nama_kecamatan }}
                        </span>
                    </div>
                @empty
                    <div class="col-span-4 p-12 text-center text-slate-400 text-sm font-medium bg-slate-50 rounded-3xl">
                        Tidak ditemukan data Duta Olahraga yang sesuai.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $dutaList->links() }}
            </div>
        </div>
    </section>
</div>
