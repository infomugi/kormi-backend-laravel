<div class="min-h-[85vh] py-8 sm:py-12 bg-gradient-to-b from-slate-50 via-slate-50/50 to-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 space-y-6">

        <!-- Top Navigation Bar & Action Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <a href="{{ route('beranda') }}" wire:navigate class="p-2 rounded-xl bg-white border border-slate-200/80 text-slate-500 hover:text-emerald-700 hover:border-emerald-300 transition-all shadow-xs group" title="Kembali ke Beranda">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform"></i>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-800 text-[10px] font-black uppercase tracking-wider border border-emerald-200/60">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            APMO Portfolio
                        </span>
                        <span class="text-xs font-semibold text-slate-400">• Log & Capaian Olahraga Saya</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <a 
                    href="{{ route('partisipasi.catat') }}" 
                    wire:navigate
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 hover:brightness-105 active:scale-98 text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-emerald-600/20"
                >
                    <i data-lucide="plus" class="w-3.5 h-3.5 stroke-[3]"></i>
                    <span>Catat Olahraga</span>
                </a>
                @if(auth()->user()->isDutaOlahraga() || auth()->user()->isSuperAdmin() || auth()->user()->isAdminKorcam())
                    <a 
                        href="{{ route('partisipasi.duta') }}" 
                        wire:navigate
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-amber-500 hover:bg-amber-600 active:scale-98 text-white font-bold text-xs uppercase tracking-wider transition shadow-xs"
                    >
                        <i data-lucide="award" class="w-3.5 h-3.5"></i>
                        <span>Portal Duta</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- ========================================== -->
        <!-- PROFILE & APMO STATUS HERO CARD            -->
        <!-- ========================================== -->
        <div class="relative overflow-hidden bg-gradient-to-r from-emerald-900 via-slate-900 to-teal-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-slate-900/5">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <!-- User Profile & Domisili -->
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-emerald-950 flex items-center justify-center font-black text-xl shadow-lg ring-4 ring-white/10 shrink-0">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-white">{{ auth()->user()->nama_lengkap }}</h1>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $badgeColor === 'amber' ? 'bg-amber-500/20 text-amber-300 border-amber-400/40' : ($badgeColor === 'emerald' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-400/40' : 'bg-sky-500/20 text-sky-300 border-sky-400/40') }}">
                                {{ $badgeLevel }}
                            </span>
                        </div>
                        <p class="text-xs text-emerald-200/80 flex items-center gap-2 flex-wrap">
                            <span><i data-lucide="map-pin" class="w-3.5 h-3.5 inline mr-0.5"></i> Kec. {{ auth()->user()->kecamatan?->nama_kecamatan ?? 'Kab. Bandung' }}</span>
                            <span>•</span>
                            <span>{{ auth()->user()->peran?->nama_peran ?? 'Pegiat Olahraga' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Monthly Target Badge Pill -->
                <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/10 flex items-center gap-3 shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-lime-400 text-slate-950 flex items-center justify-center font-black text-sm shadow-xs">
                        {{ $sesiBulanIni }}/12
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase tracking-wider text-emerald-200/90 font-bold leading-none">Target APMO Bulanan</span>
                        <span class="text-xs font-black text-white">{{ $sesiBulanIni >= 12 ? 'Target Tercapai 🎉' : (12 - $sesiBulanIni) . ' Sesi lagi ke Emas' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- PERSONAL APMO KPI METRICS GRID             -->
        <!-- ========================================== -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
            <!-- Total Sesi -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="activity" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Sesi</span>
                    <span class="text-lg sm:text-xl font-black text-slate-900">{{ number_format($totalSesi) }}</span>
                    <span class="block text-[10px] text-slate-400 mt-0.5">Semua entri tercatat</span>
                </div>
            </div>

            <!-- Akumulasi Jam -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Durasi</span>
                    <span class="text-lg sm:text-xl font-black text-slate-900">{{ number_format($totalJam, 1) }} Jam</span>
                    <span class="block text-[10px] text-slate-400 mt-0.5">Waktu aktif fisik</span>
                </div>
            </div>

            <!-- Sesi 30 Hari Terakhir -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-lime-50 text-lime-800 flex items-center justify-center shrink-0">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">30 Hari Terakhir</span>
                    <span class="text-lg sm:text-xl font-black text-slate-900">{{ number_format($sesiBulanIni) }} Sesi</span>
                    <span class="block text-[10px] text-emerald-600 font-bold mt-0.5">Standar APMO</span>
                </div>
            </div>

            <!-- Status Badge APMO -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                    <i data-lucide="trophy" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Keaktifan</span>
                    <span class="text-xs sm:text-sm font-black text-slate-900 truncate block">{{ $badgeLevel }}</span>
                    <span class="block text-[10px] text-amber-600 font-bold mt-0.5">Level APMO</span>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TIMELINE & LOGS CONTAINER                  -->
        <!-- ========================================== -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-900/[0.03] overflow-hidden">
            
            <!-- Table Header & Controls -->
            <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-0.5">
                    <h3 class="text-base sm:text-lg font-black tracking-tight text-slate-900 flex items-center gap-2">
                        <i data-lucide="history" class="w-5 h-5 text-emerald-600"></i>
                        <span>Riwayat Sesi Olahraga Saya</span>
                    </h3>
                    <p class="text-xs text-slate-500">Semua aktivitas fisik yang telah Anda submit ke sistem.</p>
                </div>

                <!-- Filter Controls -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                    <!-- Search Input -->
                    <div class="relative min-w-[200px]">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i data-lucide="search" class="w-3.5 h-3.5"></i>
                        </div>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="cari"
                            placeholder="Cari aktivitas..."
                            class="w-full pl-8.5 pr-3 py-1.5 rounded-xl border border-slate-200/90 text-xs font-semibold text-slate-800 placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 outline-hidden"
                        >
                    </div>

                    <!-- Filter Metode Tabs -->
                    <div class="inline-flex items-center p-1 rounded-xl bg-slate-100 text-xs font-bold">
                        <button 
                            type="button" 
                            wire:click="$set('filterMetode', 'semua')"
                            class="px-3 py-1 rounded-lg transition {{ $filterMetode === 'semua' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}"
                        >
                            Semua
                        </button>
                        <button 
                            type="button" 
                            wire:click="$set('filterMetode', 'mandiri')"
                            class="px-3 py-1 rounded-lg transition {{ $filterMetode === 'mandiri' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}"
                        >
                            Mandiri
                        </button>
                        <button 
                            type="button" 
                            wire:click="$set('filterMetode', 'via_duta')"
                            class="px-3 py-1 rounded-lg transition {{ $filterMetode === 'via_duta' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}"
                        >
                            Via Duta
                        </button>
                    </div>
                </div>
            </div>

            <!-- List of Activities -->
            <div class="divide-y divide-slate-100">
                @forelse($riwayatList as $item)
                    <div class="p-5 sm:p-6 hover:bg-slate-50/70 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <!-- Thumbnail / Icon -->
                            @if($item->foto_kegiatan)
                                <img 
                                    src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($item->foto_kegiatan) ?? asset($item->foto_kegiatan) }}" 
                                    alt="Foto" 
                                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl object-cover shrink-0 border border-slate-200/90 shadow-xs"
                                >
                            @else
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100">
                                    <i data-lucide="dumbbell" class="w-6 h-6"></i>
                                </div>
                            @endif

                            <!-- Details -->
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-black text-slate-900 text-sm sm:text-base">{{ $item->nama_aktivitas }}</h4>
                                    
                                    @if($item->metode_pencatatan === 'via_duta')
                                        <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 text-[10px] font-black border border-amber-200/70">
                                            Via Duta
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">
                                            Mandiri
                                        </span>
                                    @endif

                                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-black border border-emerald-200/70">
                                        {{ $item->durasi_menit }} Menit
                                    </span>
                                </div>

                                <p class="text-xs text-slate-500 flex items-center gap-1.5 flex-wrap">
                                    <span class="font-semibold text-slate-700"><i data-lucide="calendar" class="w-3.5 h-3.5 inline text-slate-400 mr-0.5"></i>{{ $item->tanggal_aktivitas->format('d F Y') }}</span>
                                    <span>•</span>
                                    <span><i data-lucide="map-pin" class="w-3.5 h-3.5 inline text-slate-400 mr-0.5"></i>{{ $item->nama_tempat }} (Kec. {{ $item->kecamatan?->nama_kecamatan }})</span>
                                    @if($item->inorga)
                                        <span>•</span>
                                        <span class="text-emerald-700 font-bold">{{ $item->inorga->singkatan ?? $item->inorga->nama_inorga }}</span>
                                    @endif
                                </p>

                                @if($item->catatan)
                                    <p class="text-xs text-slate-500 italic bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100 mt-1 max-w-xl">
                                        "{{ $item->catatan }}"
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Right Status & Participants -->
                        <div class="text-left sm:text-right shrink-0 flex sm:flex-col items-center sm:items-end justify-between gap-2 border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-100">
                            @if($item->status_verifikasi === 'valid')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-black border border-emerald-200/80">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Terverifikasi
                                </span>
                            @elseif($item->status_verifikasi === 'pending_review')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-black border border-amber-200/80">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Pending Review
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-black border border-rose-200/80">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Ditolak
                                </span>
                            @endif

                            @if($item->jumlah_peserta > 1)
                                <span class="text-[11px] font-bold text-slate-500 flex items-center gap-1">
                                    <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i>
                                    {{ $item->jumlah_peserta }} Peserta
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-16 text-center text-slate-400 space-y-4">
                        <div class="w-14 h-14 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto shadow-inner">
                            <i data-lucide="activity" class="w-6 h-6"></i>
                        </div>
                        <div class="space-y-1">
                            <h4 class="text-sm font-bold text-slate-700">Belum Ada Sesi Olahraga Tercatat</h4>
                            <p class="text-xs text-slate-400 max-w-sm mx-auto">Mulai catat aktivitas olahraga harian Anda sekarang dan kumpulkan badge APMO Kabupaten Bandung.</p>
                        </div>
                        <a 
                            href="{{ route('partisipasi.catat') }}" 
                            wire:navigate
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-emerald-600/20"
                        >
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Catat Sesi Pertama
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Footer -->
            @if($riwayatList->hasPages())
                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/50">
                    {{ $riwayatList->links() }}
                </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- APMO KNOWLEDGE & FAQ BANNER                -->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="flame" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800">Streak Mingguan</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Pertahankan konsistensi berolahraga minimal 3 kali sepekan.</p>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800">Tingkat Badge APMO</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Dapatkan Badge Emas dengan 12 kali pencatatan tiap bulannya.</p>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center shrink-0">
                    <i data-lucide="users-round" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800">Duta Olahraga</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Kegiatan massal RT/RW dapat dicatatkan oleh Duta Desa setempat.</p>
                </div>
            </div>
        </div>

    </div>
</div>
