<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-bedasGreen/20 border border-bedasGreen/30 rounded-full text-bedasGreen text-xs font-bold uppercase tracking-widest mb-4">Agenda Strategis</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Program <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedasGreen to-bedasLime">Kerja</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Rangkaian program kerja strategis KORMI Kabupaten Bandung dalam memajukan keolahragaan masyarakat.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <!-- Filter Bidang -->
            <div class="flex justify-center flex-wrap gap-2 mb-12">
                @foreach(['Semua', 'OTKB', 'OKK', 'OPT', 'SDM'] as $bid)
                    <button 
                        wire:click="$set('bidangDipilih', '{{ $bid }}')" 
                        class="px-6 py-2.5 rounded-full text-xs font-bold transition-all {{ $bidangDipilih === $bid ? 'bg-bedasGreen text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Bidang {{ $bid }}
                    </button>
                @endforeach
            </div>

            <!-- Grid Proker -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($prokerList as $p)
                    <div class="p-8 bg-white border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-6">
                                <div class="w-12 h-12 {{ $p['color'] }} text-white rounded-2xl flex items-center justify-center shadow-md">
                                    <i data-lucide="{{ $p['icon'] }}" class="w-6 h-6"></i>
                                </div>
                                <span class="px-3 py-1 bg-slate-50 border border-slate-200/60 rounded-full text-[10px] font-black uppercase tracking-wider text-slate-600">
                                    {{ $p['status'] }}
                                </span>
                            </div>
                            <span class="inline-block text-xs font-bold text-bedasGreen uppercase tracking-wider mb-2">Bidang {{ $p['bidang'] }}</span>
                            <h4 class="font-black text-slate-800 text-xl leading-snug mb-3 group-hover:text-bedasGreen transition-colors">{{ $p['judul'] }}</h4>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ $p['deskripsi'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
