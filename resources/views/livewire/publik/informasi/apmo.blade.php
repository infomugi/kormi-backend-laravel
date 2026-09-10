<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-bedasGreen/20 border border-bedasGreen/30 rounded-full text-bedasGreen text-xs font-bold uppercase tracking-widest mb-4">Apresiasi Tertinggi</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Anugerah Prestasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedasGreen to-bedasLime">Masyarakat Olahraga (APMO)</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Penghargaan prestisius bagi tokoh, pegiat, pelatih, inorga, dan insan olahraga rekreasi berprestasi.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <!-- Tab Tahun -->
            <div class="flex justify-center gap-3 mb-16">
                @foreach($tahunList as $thn)
                    <button 
                        wire:click="$set('tahunDipilih', {{ $thn }})" 
                        class="px-8 py-3 rounded-full text-sm font-black transition-all {{ $tahunDipilih === $thn ? 'bg-bedasGreen text-white shadow-xl scale-105' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        APMO {{ $thn }}
                    </button>
                @endforeach
            </div>

            <!-- Grid Awardees -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($penerimaList as $item)
                    <div class="p-8 bg-slate-50 border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <i data-lucide="award" class="w-7 h-7"></i>
                                </div>
                                <div>
                                    <span class="inline-block text-xs font-bold text-bedasGreen uppercase tracking-wider">{{ $item->kategori_penghargaan }}</span>
                                    <h4 class="font-black text-slate-800 text-xl leading-tight">{{ $item->nama_penerima }}</h4>
                                </div>
                            </div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">{{ $item->asal_lembaga_wilayah }}</p>
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $item->deskripsi_capaian }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-slate-400">
                        <p class="font-bold">Belum ada daftar penerima anugerah APMO untuk tahun {{ $tahunDipilih }}.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
