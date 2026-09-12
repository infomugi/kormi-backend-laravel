<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-amber-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-emerald-500/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-500/15 text-amber-400 text-[10px] font-black tracking-[0.2em] uppercase border border-amber-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="trophy" class="w-3.5 h-3.5 text-amber-400"></i>
                <span>Apresiasi Tertinggi Olahraga Rekreasi</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Anugerah Prestasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-yellow-200 to-emerald-400">Masyarakat Olahraga</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Pemberian anugerah prestisius bagi tokoh pembina, atlet tradisional, pelatih berdedikasi, inorga teladan, dan insan olahraga berprestasi di Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. STICKY YEAR SELECTION BAR --}}
    <section class="py-5 bg-white/95 backdrop-blur-md sticky top-16 md:top-20 z-30 border-b border-slate-100 shadow-sm shadow-slate-100/50">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
                    @foreach($tahunList as $thn)
                        <button 
                            wire:click="filterTahun({{ $thn->tahun }})"
                            class="px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap flex items-center gap-2 {{ $tahunDipilih === $thn->tahun ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                        >
                            <i data-lucide="award" class="w-3.5 h-3.5 {{ $tahunDipilih === $thn->tahun ? 'text-amber-400' : 'text-slate-400' }}"></i>
                            <span>APMO {{ $thn->tahun }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="hidden sm:flex items-center gap-2 text-xs font-bold text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Menampilkan <strong class="text-slate-700">{{ $penerimaList->count() }}</strong> Penerima Anugerah</span>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. THEME & EVENT BANNER CALLOUT --}}
    @if($tahunAktif)
        <section class="py-8 bg-slate-50 border-b border-slate-100">
            <div class="container mx-auto px-6 max-w-6xl">
                <div class="bg-gradient-to-br from-slate-900 via-slate-850 to-slate-900 rounded-3xl p-6 sm:p-8 text-white border border-slate-800 shadow-xl relative overflow-hidden">
                    <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-amber-500/10 blur-3xl rounded-full pointer-events-none"></div>
                    <div class="absolute -left-12 -top-12 w-64 h-64 bg-emerald-500/10 blur-3xl rounded-full pointer-events-none"></div>

                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-2">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 text-amber-300 text-[10px] font-black uppercase tracking-widest border border-amber-400/30">
                                <span>Tema Resmi APMO {{ $tahunAktif->tahun }}</span>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-white leading-tight">
                                "{{ $tahunAktif->tema_acara }}"
                            </h3>
                            @if(!empty($tahunAktif->deskripsi))
                                <p class="text-xs text-slate-300 max-w-2xl leading-relaxed">
                                    {{ $tahunAktif->deskripsi }}
                                </p>
                            @endif
                        </div>

                        <div class="shrink-0 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/15 text-xs space-y-2">
                            <div class="flex items-center gap-2 text-slate-300">
                                <i data-lucide="calendar" class="w-4 h-4 text-amber-400 shrink-0"></i>
                                <span>{{ \Carbon\Carbon::parse($tahunAktif->tanggal_penganugerahan)->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-300">
                                <i data-lucide="map-pin" class="w-4 h-4 text-emerald-400 shrink-0"></i>
                                <span>{{ $tahunAktif->tempat_acara }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- 4. AWARDEES PROFILE GRID --}}
    <section class="py-14 bg-white min-h-[50vh]">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($penerimaList as $index => $item)
                    <div class="group bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-amber-300 transition-all duration-300 flex flex-col justify-between relative overflow-hidden">
                        {{-- Watermark Rank Icon --}}
                        <div class="absolute -right-3 -bottom-3 text-slate-100 group-hover:text-amber-50 group-hover:scale-110 transition-all duration-500 pointer-events-none">
                            <i data-lucide="medal" class="w-32 h-32 opacity-40"></i>
                        </div>

                        <div class="relative z-10">
                            {{-- Header Card: Icon / Avatar + Badge --}}
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform shrink-0">
                                        <i data-lucide="award" class="w-7 h-7"></i>
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200 mb-1">
                                            {{ $item->kategori_penghargaan }}
                                        </span>
                                        <h3 class="text-base sm:text-lg font-black text-slate-900 leading-snug group-hover:text-amber-700 transition-colors">
                                            {{ $item->nama_penerima }}
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            {{-- Asal Lembaga / Wilayah Chip --}}
                            <div class="flex items-center gap-1.5 text-xs font-bold text-slate-500 mb-3 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100 w-fit">
                                <i data-lucide="briefcase" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                <span>{{ $item->asal_lembaga_wilayah }}</span>
                            </div>

                            {{-- Description of Achievement --}}
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                {{ $item->deskripsi_capaian }}
                            </p>
                        </div>

                        {{-- Footer Card --}}
                        <div class="relative z-10 pt-4 mt-5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400 font-bold">
                            <span class="flex items-center gap-1 text-[11px]">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-500"></i>
                                Terverifikasi APMO {{ $tahunDipilih }}
                            </span>
                            <span class="text-[10px] uppercase tracking-wider text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200/60 font-black">
                                Penghargaan Ke-{{ $item->urutan ?? ($index + 1) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-slate-50 rounded-3xl border border-slate-200/80 p-12 text-center max-w-md mx-auto shadow-sm my-6">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-4 border border-slate-200 shadow-xs">
                            <i data-lucide="trophy" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 uppercase">Belum Ada Data</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-6">Daftar penerima anugerah APMO untuk tahun {{ $tahunDipilih }} belum dipublikasikan.</p>
                        @if($tahunList->isNotEmpty())
                            <button wire:click="filterTahun({{ $tahunList->first()->tahun }})" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-emerald-600 transition-colors inline-flex items-center gap-2">
                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                <span>Lihat APMO {{ $tahunList->first()->tahun }}</span>
                            </button>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

