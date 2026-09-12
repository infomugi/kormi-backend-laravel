<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="target" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Agenda Strategis & Matriks Kegiatan</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Program <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Kerja Organisasi</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Peta jalan program kerja terstruktur KORMI Kabupaten Bandung untuk memajukan partisipasi olahraga, pembinaan inorga, dan penguatan kesehatan masyarakat.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. STICKY FILTER BIDANG KOMISI BAR --}}
    <section class="py-5 bg-white/95 backdrop-blur-md sticky top-16 md:top-20 z-30 border-b border-slate-100 shadow-sm shadow-slate-100/50">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
                    @foreach(['Semua', 'OTKB', 'OKK', 'OPT', 'SDM'] as $bid)
                        @php
                            $label = match($bid) {
                                'Semua' => 'Semua Bidang',
                                'OTKB' => 'Bidang OTKB',
                                'OKK' => 'Bidang OKK',
                                'OPT' => 'Bidang OPT',
                                'SDM' => 'Bidang SDM',
                                default => "Bidang {$bid}"
                            };
                        @endphp
                        <button 
                            wire:click="filterBidang('{{ $bid }}')" 
                            class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap flex items-center gap-1.5 {{ $bidangDipilih === $bid ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                        >
                            <i data-lucide="{{ $bid === 'Semua' ? 'layers' : 'check-circle-2' }}" class="w-3.5 h-3.5 {{ $bidangDipilih === $bid ? 'text-emerald-400' : 'text-slate-400' }}"></i>
                            <span>{{ $label }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="hidden sm:flex items-center gap-2 text-xs font-bold text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Menampilkan <strong class="text-slate-700">{{ count($prokerList) }}</strong> Program Kerja</span>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. GRID PROGRAM KERJA CARDS --}}
    <section class="py-14 bg-slate-50/50 min-h-[50vh]">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($prokerList as $p)
                    @php
                        $statusText = strtolower($p['status']);
                        $statusBadge = match(true) {
                            str_contains($statusText, 'berjalan') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            str_contains($statusText, 'selesai') => 'bg-blue-50 text-blue-700 border-blue-200',
                            str_contains($statusText, 'rencana') => 'bg-amber-50 text-amber-700 border-amber-200',
                            default => 'bg-slate-100 text-slate-700 border-slate-200'
                        };
                    @endphp
                    
                    <div class="group bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            {{-- Header Card: Icon + Status Badge --}}
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform shrink-0">
                                    <i data-lucide="{{ $p['icon'] }}" class="w-6 h-6"></i>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusBadge }}">
                                    @if(str_contains($statusText, 'berjalan'))
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    @endif
                                    <span>{{ $p['status'] }}</span>
                                </span>
                            </div>

                            {{-- Bidang Chip --}}
                            <div class="mb-2">
                                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-100">
                                    Bidang {{ $p['bidang'] }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-base sm:text-lg font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition-colors mb-2">
                                {{ $p['judul'] }}
                            </h3>

                            {{-- Description --}}
                            <p class="text-xs text-slate-600 leading-relaxed mb-4">
                                {{ $p['deskripsi'] }}
                            </p>
                        </div>

                        {{-- Footer Meta: Target & Periode Pelaksanaan --}}
                        <div class="pt-4 border-t border-slate-100 space-y-2 text-xs">
                            <div class="flex items-center gap-1.5 text-slate-500">
                                <i data-lucide="users" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                <span class="text-[11px]">Sasaran: <strong class="text-slate-800">{{ $p['target'] }}</strong></span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] font-bold text-slate-400">
                                <span class="flex items-center gap-1 text-slate-600">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                    {{ $p['periode'] }}
                                </span>
                                <span class="text-slate-500 font-black">TA {{ $p['tahun'] }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-md mx-auto shadow-sm my-6">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-4 border border-slate-200">
                            <i data-lucide="target" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 uppercase">Program Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-6">Belum ada agenda program kerja untuk bidang ini.</p>
                        <button wire:click="filterBidang('Semua')" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-emerald-600 transition-colors inline-flex items-center gap-2">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span>Lihat Semua Bidang</span>
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

