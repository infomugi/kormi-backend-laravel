<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-indigo-500/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-indigo-500/20 border border-indigo-500/30 rounded-full text-indigo-400 text-xs font-bold uppercase tracking-widest mb-4">Infrastruktur Olahraga</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Sarana & <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-400">Prasarana</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Direktori gelanggang, stadion, taman, dan fasilitas olahraga masyarakat di Kabupaten Bandung.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <!-- Filter Kategori Fasilitas -->
            <div class="flex justify-center flex-wrap gap-2 mb-12">
                @foreach(['Semua', 'Stadion', 'Lapangan', 'GOR', 'Kolam Renang', 'Lintasan', 'Taman Olahraga'] as $j)
                    <button 
                        wire:click="$set('jenisDipilih', '{{ $j }}')" 
                        class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $jenisDipilih === $j ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $j }}
                    </button>
                @endforeach
            </div>

            <!-- Grid Sapras -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($fasilitasData as $f)
                    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 overflow-hidden bg-slate-100">
                                <img src="{{ $f->foto_url ?: 'https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=600' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $f->nama_fasilitas }}" />
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-wider text-slate-800 shadow-sm">
                                        {{ $f->kategori_fasilitas }}
                                    </span>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $f->status_kondisi === 'Baik' ? 'bg-green-500 text-white' : ($f->status_kondisi === 'Perlu Renovasi' ? 'bg-amber-500 text-white' : 'bg-blue-500 text-white') }}">
                                        {{ $f->status_kondisi }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="font-black text-slate-800 text-lg leading-tight mb-2 group-hover:text-indigo-600 transition-colors">{{ $f->nama_fasilitas }}</h4>
                                <div class="space-y-1 text-xs text-slate-500">
                                    <p class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-indigo-500"></i> Kec. {{ $f->kecamatan->nama_kecamatan ?? '-' }}</p>
                                    <p class="flex items-center gap-1.5"><i data-lucide="users" class="w-3.5 h-3.5 text-indigo-500"></i> Kapasitas: {{ $f->kapasitas }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-slate-400">
                        <p class="font-bold">Belum ada data fasilitas untuk kategori ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
