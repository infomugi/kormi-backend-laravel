<div>
    <!-- HERO HEADER -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-bedasGreen/20 border border-bedasGreen/30 rounded-full text-bedasGreen text-xs font-bold uppercase tracking-widest mb-4">Pusat Informasi</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Unduhan Dokumen</h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Akses dan unduh regulasi resmi, formulir pendaftaran, surat keputusan, dan materi keolahragaan.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <!-- Filter & Live Search -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-10">
                <div class="flex flex-wrap gap-2">
                    <button 
                        wire:click="$set('kategoriDipilih', 'Semua')" 
                        class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $kategoriDipilih === 'Semua' ? 'bg-bedasGreen text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua
                    </button>
                    @foreach($kategoriList as $kat)
                        <button 
                            wire:click="$set('kategoriDipilih', '{{ $kat->slug }}')" 
                            class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $kategoriDipilih === $kat->slug ? 'bg-bedasGreen text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $kat->nama_kategori }}
                        </button>
                    @endforeach
                </div>

                <div class="relative w-full md:w-80">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="Cari dokumen..." 
                        class="w-full px-5 py-3 rounded-full border border-slate-200 focus:outline-none focus:border-bedasGreen text-sm pl-11 shadow-sm">
                    <i data-lucide="search" class="w-4 h-4 absolute left-4 top-3.5 text-slate-400"></i>
                </div>
            </div>

            <!-- List Card Dokumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($dokumenList as $doc)
                    <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-green-50 text-bedasGreen flex items-center justify-center font-bold shrink-0">
                                <i data-lucide="{{ $doc->nama_ikon }}" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm leading-tight mb-1">{{ $doc->judul_dokumen }}</h4>
                                <div class="flex items-center gap-3 text-[11px] text-slate-400">
                                    <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600 font-semibold">{{ $doc->kategori->nama_kategori }}</span>
                                    <span>{{ $doc->ukuran_berkas }}</span>
                                    <span>{{ number_format($doc->jumlah_unduhan) }}x diunduh</span>
                                </div>
                            </div>
                        </div>

                        <button 
                            wire:click="unduhBerkas('{{ $doc->id }}')" 
                            class="px-4 py-2 bg-bedasGreen text-white text-xs font-bold rounded-full hover:bg-green-600 transition-all inline-flex items-center gap-1.5 shrink-0 shadow-md">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i> Unduh
                        </button>
                    </div>
                @empty
                    <div class="col-span-2 p-12 text-center text-slate-400 text-sm font-medium bg-slate-50 rounded-2xl">
                        Tidak ditemukan dokumen yang sesuai dengan pencarian Anda.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $dokumenList->links() }}
            </div>
        </div>
    </section>
</div>
