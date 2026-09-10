<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-bedasGreen/20 border border-bedasGreen/30 rounded-full text-bedasGreen text-xs font-bold uppercase tracking-widest mb-4">Kelembagaan</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Induk Organisasi Olahraga (Inorga)</h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Daftar induk organisasi olahraga masyarakat yang terdaftar dan bernaung di bawah KORMI Kabupaten Bandung.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <!-- Filter Komisi & Search -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-10">
                <div class="flex flex-wrap gap-2">
                    <button 
                        wire:click="$set('komisiDipilih', 'Semua')" 
                        class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $komisiDipilih === 'Semua' ? 'bg-bedasGreen text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua Komisi
                    </button>
                    @foreach($komisiList as $kom)
                        <button 
                            wire:click="$set('komisiDipilih', '{{ $kom->singkatan }}')" 
                            class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $komisiDipilih === $kom->singkatan ? 'bg-bedasGreen text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $kom->singkatan }} ({{ $kom->inorga_count }})
                        </button>
                    @endforeach
                </div>

                <div class="relative w-full md:w-80">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="Cari singkatan / nama inorga..." 
                        class="w-full px-5 py-3 rounded-full border border-slate-200 focus:outline-none focus:border-bedasGreen text-sm pl-11 shadow-sm">
                    <i data-lucide="search" class="w-4 h-4 absolute left-4 top-3.5 text-slate-400"></i>
                </div>
            </div>

            <!-- Grid Inorga -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($inorgaList as $ino)
                    <div class="p-6 bg-white border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-bedasGreen font-black text-xl group-hover:scale-105 transition-transform shadow-inner">
                                    {{ substr($ino->singkatan, 0, 2) }}
                                </div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-white shadow-sm" style="background-color: {{ $ino->komisi->kode_warna_hex ?? '#16a34a' }}">
                                    {{ $ino->komisi->singkatan }}
                                </span>
                            </div>
                            <h4 class="font-black text-slate-800 text-xl leading-tight mb-1 group-hover:text-bedasGreen transition-colors">{{ $ino->singkatan }}</h4>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed mb-4">{{ $ino->nama_inorga }}</p>
                        </div>
                        <div class="pt-4 border-t border-slate-50 flex justify-between items-center text-xs text-slate-400">
                            <span>Status: <strong class="text-green-600 font-bold uppercase">{{ $ino->status_keanggotaan }}</strong></span>
                            <span>{{ $ino->jumlah_klub_anggota }} Klub Anggota</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 p-12 text-center text-slate-400 text-sm font-medium bg-slate-50 rounded-3xl">
                        Tidak ditemukan data Inorga yang sesuai.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
