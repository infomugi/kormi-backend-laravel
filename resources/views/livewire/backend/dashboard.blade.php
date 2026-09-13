<div class="space-y-4 sm:space-y-5" x-data="{ activeTab: 'week' }">
    
    <!-- ========================================================================= -->
    <!-- 1. TOP HEADER / COMPACT EXECUTIVE BAR                                     -->
    <!-- ========================================================================= -->
    <div class="hidden sm:flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/80 shadow-2xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white flex items-center justify-center font-black text-base shadow-sm shadow-emerald-600/20 shrink-0">
                KB
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Dashboard KORMI Kabupaten Bandung</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-extrabold border border-emerald-200/60">CMS v2.6</span>
                </h1>
                <p class="text-[11px] sm:text-xs font-semibold text-slate-400">Pusat data terpadu olahraga rekreasi, inorga, program kerja, dan kejuaraan wilayah.</p>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <span class="px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] font-bold text-slate-600 flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="calendar" class="w-3.5 h-3.5 text-emerald-600"></i>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</span>
            </span>
            <a href="{{ route('admin.berita') }}" wire:navigate class="px-3.5 py-1.5 rounded-xl bg-slate-950 hover:bg-slate-800 text-white text-xs font-black shadow-2xs flex items-center gap-1.5 transition-all">
                <i data-lucide="plus" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Tulis Berita</span>
            </a>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 2. COMPACT STATS STRIP (6 PILL METRICS)                                  -->
    <!-- ========================================================================= -->
    <div class="hidden sm:grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <!-- Metric 1: Inorga -->
        <a href="{{ route('admin.inorga') }}" wire:navigate class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition-all flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="boxes" class="w-4.5 h-4.5"></i>
            </div>
            <div class="min-w-0">
                <span class="text-base font-black text-slate-900 block leading-tight">{{ $totalInorga }}</span>
                <span class="text-[10px] font-bold text-slate-400 truncate block">Inorga Aktif</span>
            </div>
        </a>

        <!-- Metric 2: Duta Olahraga -->
        <a href="{{ route('admin.duta') }}" wire:navigate class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:border-cyan-300 transition-all flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="user-check" class="w-4.5 h-4.5"></i>
            </div>
            <div class="min-w-0">
                <span class="text-base font-black text-slate-900 block leading-tight">{{ $totalDuta }}</span>
                <span class="text-[10px] font-bold text-slate-400 truncate block">Duta Olahraga</span>
            </div>
        </a>

        <!-- Metric 3: KORDIK Kecamatan -->
        <a href="{{ route('admin.kordik') }}" wire:navigate class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:border-sky-300 transition-all flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="map-pin" class="w-4.5 h-4.5"></i>
            </div>
            <div class="min-w-0">
                <span class="text-base font-black text-slate-900 block leading-tight">{{ $kordikAktif }}/31</span>
                <span class="text-[10px] font-bold text-slate-400 truncate block">Kordik Cam</span>
            </div>
        </a>

        <!-- Metric 4: Sarana & Venue -->
        <a href="{{ route('admin.sapras') }}" wire:navigate class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:border-purple-300 transition-all flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="building-2" class="w-4.5 h-4.5"></i>
            </div>
            <div class="min-w-0">
                <span class="text-base font-black text-slate-900 block leading-tight">{{ $totalSapras }}</span>
                <span class="text-[10px] font-bold text-slate-400 truncate block">Sarana & Venue</span>
            </div>
        </a>

        <!-- Metric 5: Total Berita -->
        <a href="{{ route('admin.berita') }}" wire:navigate class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:border-amber-300 transition-all flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="newspaper" class="w-4.5 h-4.5"></i>
            </div>
            <div class="min-w-0">
                <span class="text-base font-black text-slate-900 block leading-tight">{{ $totalBerita }}</span>
                <span class="text-[10px] font-bold text-slate-400 truncate block">Warta Berita</span>
            </div>
        </a>

        <!-- Metric 6: Total Anggaran Proker -->
        <a href="{{ route('admin.proker') }}" wire:navigate class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:border-indigo-300 transition-all flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="badge-dollar-sign" class="w-4.5 h-4.5"></i>
            </div>
            <div class="min-w-0">
                <span class="text-base font-black text-slate-900 block leading-tight">Rp {{ number_format($totalAnggaran / 1000000, 0) }}M</span>
                <span class="text-[10px] font-bold text-slate-400 truncate block">Pagu Proker</span>
            </div>
        </a>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. MAIN BENTO GRID (COMPACT STYLE)                                        -->
    <!-- ========================================================================= -->
    
    <!-- UPPER ROW: 3 Bento Cards (Activity Bar Graph, Progress Statistics, Active Highlight Event) -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-stretch">
        
        <!-- CARD 1: ACTIVITY (Bar Graph with Highlighted Column & Dotted Target) -->
        <div class="md:col-span-12 lg:col-span-4 bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between relative overflow-hidden">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-black text-slate-900 tracking-tight">Aktivitas Web & Pembaca</h2>
                    <div class="flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200/70 text-[10px] font-bold text-slate-600">
                        <i data-lucide="calendar-days" class="w-3 h-3 text-slate-400"></i>
                        <span>7 Hari</span>
                    </div>
                </div>

                <div class="flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ number_format($totalViews, 0, ',', '.') }}</span>
                    <span class="text-[11px] font-bold text-slate-400">Kunjungan</span>
                </div>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="inline-flex items-center gap-0.5 text-[11px] font-bold text-emerald-600">
                        <i data-lucide="trending-up" class="w-3 h-3"></i> +24.8%
                    </span>
                    <span class="text-[10px] text-slate-400 font-medium">minggu ini</span>
                </div>
            </div>

            <!-- Bar Chart Visualization (Compact) -->
            <div class="mt-4 pt-2 relative">
                <!-- Dotted Baseline Target -->
                <div class="absolute top-8 left-0 right-0 flex items-center z-10 pointer-events-none">
                    <div class="px-1.5 py-0.5 rounded bg-slate-900 text-white text-[9px] font-black">
                        5.2k avg
                    </div>
                    <div class="flex-1 border-b border-dashed border-slate-300 ml-1.5"></div>
                </div>

                <!-- 7 Bars Grid -->
                <div class="grid grid-cols-7 gap-2 items-end h-32 pb-4 pt-1">
                    @foreach($weeklyViews as $bar)
                        <div class="flex flex-col items-center gap-1.5 h-full justify-end group cursor-pointer">
                            <div class="w-full relative flex items-end justify-center rounded-xl transition-all duration-200 {{ !empty($bar['active']) ? 'bg-gradient-to-t from-violet-600 to-indigo-600 shadow-sm shadow-indigo-500/30' : 'bg-violet-100 group-hover:bg-violet-200' }}"
                                style="height: {{ $bar['height'] }};">
                                @if(!empty($bar['active']))
                                    <div class="absolute -top-6 px-1.5 py-0.5 rounded bg-indigo-600 text-white text-[9px] font-black shadow-2xs whitespace-nowrap">
                                        {{ $bar['val'] }}k
                                    </div>
                                @endif
                            </div>
                            <span class="text-[10px] font-bold {{ !empty($bar['active']) ? 'text-indigo-600 font-black' : 'text-slate-400 group-hover:text-slate-700' }}">
                                {{ $bar['day'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- CARD 2: PROGRESS STATISTICS (Multi-color Strip Progress + 3 Mini Circle Stats) -->
        <div class="md:col-span-12 lg:col-span-4 bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-black text-slate-900 tracking-tight">Progres Program Kerja</h2>
                    <a href="{{ route('admin.proker') }}" wire:navigate class="text-slate-400 hover:text-slate-700">
                        <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $overallProgressPct }}%</span>
                    <span class="text-[11px] font-bold text-slate-400">Realisasi Target</span>
                </div>

                <!-- Multi-segment Strip Progress Bar -->
                @php
                    $berjalanWidth = $totalProgramKerja > 0 ? round(($prokerBerjalan / $totalProgramKerja) * 100) : 0;
                    $selesaiWidth = $totalProgramKerja > 0 ? round(($prokerSelesai / $totalProgramKerja) * 100) : 0;
                    $rencanaWidth = $totalProgramKerja > 0 ? (100 - $berjalanWidth - $selesaiWidth) : 0;
                @endphp
                <div class="mt-3 space-y-1">
                    <div class="w-full h-2.5 bg-slate-100 rounded-full flex overflow-hidden p-0.5 gap-0.5">
                        <div class="bg-indigo-600 h-full rounded-full transition-all" style="width: {{ max(10, $berjalanWidth) }}%;"></div>
                        <div class="bg-emerald-500 h-full rounded-full transition-all" style="width: {{ max(10, $selesaiWidth) }}%;"></div>
                        <div class="bg-amber-500 h-full rounded-full transition-all" style="width: {{ max(10, $rencanaWidth) }}%;"></div>
                    </div>
                    <div class="flex justify-between text-[9px] font-extrabold text-slate-400">
                        <span class="text-indigo-600">{{ $berjalanWidth }}% Berjalan</span>
                        <span class="text-emerald-600">{{ $selesaiWidth }}% Selesai</span>
                        <span class="text-amber-600">{{ $rencanaWidth }}% Rencana</span>
                    </div>
                </div>
            </div>

            <!-- 3 Mini Metric Badges (In progress, Completed, Upcoming) -->
            <div class="grid grid-cols-3 gap-2 mt-4 p-3 rounded-2xl bg-slate-50/80 border border-slate-100">
                <!-- In progress (Indigo/Purple) -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-7 h-7 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="text-base font-black text-slate-900 mt-1 leading-none">{{ $prokerBerjalan }}</span>
                    <span class="text-[9px] font-bold text-slate-500 mt-0.5">Berjalan</span>
                </div>

                <!-- Completed (Emerald) -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="text-base font-black text-slate-900 mt-1 leading-none">{{ $prokerSelesai }}</span>
                    <span class="text-[9px] font-bold text-slate-500 mt-0.5">Selesai</span>
                </div>

                <!-- Upcoming (Amber/Orange) -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-7 h-7 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="text-base font-black text-slate-900 mt-1 leading-none">{{ $prokerRencana }}</span>
                    <span class="text-[9px] font-bold text-slate-500 mt-0.5">Rencana</span>
                </div>
            </div>
        </div>

        <!-- CARD 3: ACTIVE EVENT / HIGHLIGHT CARD -->
        <div class="md:col-span-12 lg:col-span-4 bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between">
            <div>
                <!-- Top Tags -->
                <div class="flex items-center gap-1.5 mb-2">
                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-[9px] font-extrabold uppercase">
                        {{ $activeEvent->kategoriEvent->nama_kategori ?? 'Event Akbar' }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200/60 text-[9px] font-extrabold uppercase">
                        Edisi {{ $activeEvent->tahun_edisi ?? 2026 }}
                    </span>
                </div>

                <!-- Event Title & Description -->
                <h3 class="text-sm sm:text-base font-black text-slate-900 leading-snug">
                    {{ $activeEvent->judul_event ?? 'Festival Olahraga Rekreasi Masyarakat (FORKAB) 2026' }}
                </h3>
                <p class="text-[11px] font-medium text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                    {{ $activeEvent->deskripsi_lengkap ?? 'Ajang festival olahraga rekreasi terbesar se-Kabupaten Bandung dengan partisipasi 31 kontingen kecamatan.' }}
                </p>

                <!-- Participants Avatars & Progress Metric -->
                <div class="grid grid-cols-2 gap-3 mt-4 pt-3 border-t border-slate-100">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 block mb-1.5">Duta Terdaftar</span>
                        <div class="flex items-center -space-x-1.5">
                            @forelse($topDutas as $duta)
                                <div class="w-6 h-6 rounded-full border border-white bg-gradient-to-br from-indigo-500 to-emerald-500 text-white flex items-center justify-center text-[9px] font-black"
                                    title="{{ $duta->nama_lengkap }}">
                                    {{ substr($duta->nama_lengkap, 0, 1) }}
                                </div>
                            @empty
                                <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[9px] font-bold text-slate-500">
                                    K
                                </div>
                            @endforelse
                            <span class="w-6 h-6 rounded-full border border-white bg-slate-900 text-white flex items-center justify-center text-[8px] font-bold">
                                +{{ max(0, $totalDuta - 4) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <span class="text-[10px] font-bold text-slate-400 block mb-1.5">Kesiapan Event</span>
                        <div class="flex items-center gap-1.5">
                            <div class="flex-1 h-5 rounded-lg bg-amber-100/80 p-0.5 flex items-center">
                                <div class="bg-amber-400 h-full rounded text-[9px] font-black text-amber-950 flex items-center justify-center px-1" style="width: 75%;">
                                    75%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Black Pill CTA Button (Compact) -->
            <div class="mt-4">
                <a href="{{ route('admin.event') }}" wire:navigate
                    class="w-full py-2.5 px-3.5 rounded-xl bg-slate-950 hover:bg-slate-800 text-white text-xs font-extrabold flex items-center justify-center gap-1.5 shadow-2xs transition-colors">
                    <span>Kelola & Lihat Jadwal Event</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-emerald-400"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- MIDDLE ROW: 2 Bento Cards (Distribution by Inorga/Platform + My Schedule Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-stretch">
        
        <!-- CARD 4: BY PLATFORM / INORGA & KOMISI DISTRIBUTION (Left 4-cols) -->
        <div class="md:col-span-12 lg:col-span-4 bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-sm font-black text-slate-900 tracking-tight">Kategori Inorga</h2>
                        <p class="text-[10px] font-semibold text-slate-400">Komisi & Klub Olahraga Aktif</p>
                    </div>
                    <a href="{{ route('admin.inorga') }}" wire:navigate class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                        Semua
                    </a>
                </div>

                <!-- 4 Inorga / Komisi Items (Compact) -->
                <div class="space-y-2.5">
                    <!-- Item 1: OTDA -->
                    <div class="flex items-center justify-between group p-1.5 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-200/60 text-emerald-600 flex items-center justify-center shrink-0">
                                <i data-lucide="swords" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-extrabold text-slate-900">OTDA</h4>
                                <span class="text-[10px] text-slate-400 font-medium">Tradisional & Budaya</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-black text-slate-900 block leading-tight">{{ $komisiOtdaCount }} Inorga</span>
                            <span class="text-[9px] text-emerald-600 font-bold">23 Klub</span>
                        </div>
                    </div>

                    <!-- Item 2: OKK -->
                    <div class="flex items-center justify-between group p-1.5 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 border border-blue-200/60 text-blue-600 flex items-center justify-center shrink-0">
                                <i data-lucide="heart-pulse" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-extrabold text-slate-900">OKK</h4>
                                <span class="text-[10px] text-slate-400 font-medium">Kesehatan & Kebugaran</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-black text-slate-900 block leading-tight">{{ $komisiOkkCount }} Inorga</span>
                            <span class="text-[9px] text-blue-600 font-bold">32 Klub</span>
                        </div>
                    </div>

                    <!-- Item 3: OPT -->
                    <div class="flex items-center justify-between group p-1.5 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-orange-50 border border-orange-200/60 text-orange-600 flex items-center justify-center shrink-0">
                                <i data-lucide="compass" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-extrabold text-slate-900">OPT</h4>
                                <span class="text-[10px] text-slate-400 font-medium">Petualangan & Tantangan</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-black text-slate-900 block leading-tight">{{ $komisiOptCount }} Inorga</span>
                            <span class="text-[9px] text-orange-600 font-bold">14 Klub</span>
                        </div>
                    </div>

                    <!-- Item 4: Sapras -->
                    <div class="flex items-center justify-between group p-1.5 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-purple-50 border border-purple-200/60 text-purple-600 flex items-center justify-center shrink-0">
                                <i data-lucide="building-2" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-extrabold text-slate-900">Sapras Wilayah</h4>
                                <span class="text-[10px] text-slate-400 font-medium">31 Kecamatan</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-black text-slate-900 block leading-tight">{{ $totalSapras }} Venue</span>
                            <span class="text-[9px] text-purple-600 font-bold">Tervalidasi</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500">Total {{ $totalInorga }} Induk Organisasi</span>
                <a href="{{ route('admin.inorga') }}" wire:navigate class="text-xs font-extrabold text-slate-900 hover:text-emerald-700 flex items-center gap-1">
                    <span>Kelola</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                </a>
            </div>
        </div>

        <!-- CARD 5: MY SCHEDULE / AGENDA TAHAPAN FORKAB (Right 8-cols, 3 Colored Cards) -->
        <div class="md:col-span-12 lg:col-span-8 bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between">
            <div>
                <!-- Schedule Header & Today Navigation -->
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-sm font-black text-slate-900 tracking-tight">Jadwal & Agenda Kegiatan</h2>
                        <p class="text-[10px] font-semibold text-slate-400">Tahapan pelaksanaan kegiatan FORKAB & Pelatihan SDI</p>
                    </div>

                    <div class="flex items-center gap-1 bg-slate-50 border border-slate-200/70 p-0.5 rounded-xl text-xs font-bold text-slate-700">
                        <button class="w-6 h-6 rounded-lg hover:bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 transition-colors">
                            <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                        </button>
                        <span class="px-1.5 font-black text-slate-900 text-[10px]">Bulan Ini</span>
                        <button class="w-6 h-6 rounded-lg hover:bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 transition-colors">
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                </div>

                <!-- 3 Interactive Schedule Cards (Compact) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    
                    <!-- Card 1: Selesai / Technical Meeting -->
                    <div class="p-4 rounded-2xl bg-slate-50/90 border border-slate-200/70 hover:border-slate-300 transition-all flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 block">15 Juli 2026 • 09:00</span>
                            <h4 class="text-xs font-black text-slate-900 mt-1 leading-snug">Technical Meeting FORKAB</h4>
                            <div class="mt-1.5">
                                <span class="px-1.5 py-0.5 rounded bg-blue-100 text-blue-800 text-[9px] font-bold">
                                    Selesai
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 pt-2 border-t border-slate-200/60">
                            <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[9px] font-bold">
                                TM
                            </div>
                            <div class="min-w-0">
                                <span class="text-[11px] font-bold text-slate-800 block truncate">Aula Dispora</span>
                                <span class="text-[9px] text-slate-400 block truncate">31 Kecamatan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: ACTIVE NOW / Babak Penyisihan -->
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-700 text-white shadow-md shadow-indigo-600/20 flex flex-col justify-between space-y-3 relative overflow-hidden">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-indigo-200">01 - 20 Agt • 08:00</span>
                            <span class="px-1.5 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[9px] font-black flex items-center gap-1 shadow-2xs">
                                <span class="w-1 h-1 rounded-full bg-slate-950 animate-ping"></span>
                                <span>Berlangsung</span>
                            </span>
                        </div>

                        <div>
                            <h4 class="text-xs sm:text-sm font-black text-white leading-snug">Babak Penyisihan Seluruh Cabor</h4>
                            <div class="mt-1.5">
                                <span class="px-2 py-0.5 rounded bg-white/20 text-white text-[9px] font-bold backdrop-blur-sm">
                                    Zona Wilayah
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 pt-2 border-t border-white/20">
                            <div class="w-6 h-6 rounded-full bg-white text-indigo-700 flex items-center justify-center text-[9px] font-black">
                                BP
                            </div>
                            <div class="min-w-0">
                                <span class="text-[11px] font-black text-white block truncate">Si Jalak Harupat</span>
                                <span class="text-[9px] text-indigo-200 block truncate">Semua Kontingen</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Akan Datang / Babak Final -->
                    <div class="p-4 rounded-2xl bg-slate-50/90 border border-slate-200/70 hover:border-slate-300 transition-all flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 block">25 - 30 Agt • 08:00</span>
                            <h4 class="text-xs font-black text-slate-900 mt-1 leading-snug">Grand Final & Pesta Rakyat</h4>
                            <div class="mt-1.5">
                                <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[9px] font-bold">
                                    Akan Datang
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 pt-2 border-t border-slate-200/60">
                            <div class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center text-[9px] font-bold">
                                GF
                            </div>
                            <div class="min-w-0">
                                <span class="text-[11px] font-bold text-slate-800 block truncate">Si Jalak Harupat</span>
                                <span class="text-[9px] text-slate-400 block truncate">Finalis Medali</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer Link -->
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.event') }}" wire:navigate class="text-xs font-bold text-slate-600 hover:text-slate-950 flex items-center gap-1.5">
                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                    <span>Kalender agenda tahunan lengkap</span>
                </a>
                <a href="{{ route('admin.klasemen') }}" wire:navigate class="text-xs font-extrabold text-emerald-600 hover:text-emerald-800 flex items-center gap-1">
                    <span>Klasemen Medali</span>
                    <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- 4. ADDITIONAL 4-BENTO COMPACT CARDS (SDI, APMO, GALERI FOTO, DOKUMEN UNDUHAN)-->
    <!-- ========================================================================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-stretch">
        
        <!-- CARD A: PELATIHAN SDI -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-slate-900">Pelatihan & SDI</h3>
                            <span class="text-[9px] text-slate-400 font-semibold block">Sertifikasi Daerah</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.sdi') }}" wire:navigate class="text-[11px] font-bold text-blue-600 hover:underline">Kelola</a>
                </div>

                <div class="space-y-2 mt-2">
                    @forelse($sdiJadwal as $sdi)
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center justify-between">
                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded {{ $sdi->status_pendaftaran === 'penuh' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $sdi->status_pendaftaran === 'penuh' ? 'Penuh' : 'Dibuka' }}
                                </span>
                                <span class="text-[10px] font-black text-slate-800">{{ $sdi->jumlah_pendaftar }}/{{ $sdi->kuota_peserta }} Pendaftar</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 mt-1 truncate">{{ $sdi->program->judul_program ?? $sdi->nama_angkatan }}</h4>
                            <span class="text-[10px] text-slate-400 block truncate mt-0.5">{{ $sdi->lokasi_pelatihan }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center">Tidak ada jadwal.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.sdi') }}" wire:navigate class="text-[11px] font-extrabold text-blue-600 flex items-center justify-between">
                    <span>Lihat Daftar Peserta</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

        <!-- CARD B: APRESIASI APMO -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i data-lucide="award" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-slate-900">Anugerah APMO</h3>
                            <span class="text-[9px] text-slate-400 font-semibold block">Tokoh & Pegiat</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.apmo') }}" wire:navigate class="text-[11px] font-bold text-amber-600 hover:underline">Kelola</a>
                </div>

                <div class="space-y-2 mt-2">
                    @forelse($apmoTerbaru as $apmo)
                        <div class="p-2 rounded-xl bg-amber-50/50 border border-amber-100 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                🏆
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-xs font-bold text-slate-900 truncate">{{ $apmo->nama_penerima }}</h4>
                                <span class="text-[9px] text-amber-800 truncate block">{{ $apmo->kategori_penghargaan }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center">Belum ada data.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.apmo') }}" wire:navigate class="text-[11px] font-extrabold text-amber-700 flex items-center justify-between">
                    <span>Arsip Penghargaan APMO</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

        <!-- CARD C: DOKUMENTASI GALERI FOTO -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                            <i data-lucide="image" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-slate-900">Galeri Foto</h3>
                            <span class="text-[9px] text-slate-400 font-semibold block">{{ $totalGaleri }} Foto Terunggah</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.galeri') }}" wire:navigate class="text-[11px] font-bold text-teal-600 hover:underline">Kelola</a>
                </div>

                <!-- 4 Photo Grid Thumbnails -->
                <div class="grid grid-cols-2 gap-1.5 mt-2">
                    @forelse($galeriTerbaru as $foto)
                        <div class="relative h-16 rounded-xl overflow-hidden group bg-slate-100">
                            <img src="{{ $foto->gambar_url }}" alt="{{ $foto->judul_foto }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-1">
                                <span class="text-[8px] font-bold text-white truncate">{{ $foto->judul_foto }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 py-4 text-center text-slate-400 text-xs">Belum ada foto.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.galeri') }}" wire:navigate class="text-[11px] font-extrabold text-teal-700 flex items-center justify-between">
                    <span>Semua Album Kegiatan</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

        <!-- CARD D: DOKUMEN & REGULASI UNDUHAN -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                            <i data-lucide="file-down" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-slate-900">Dokumen & SK</h3>
                            <span class="text-[9px] text-slate-400 font-semibold block">{{ $totalUnduhanDownloads }} Total Unduhan</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.unduhan') }}" wire:navigate class="text-[11px] font-bold text-rose-600 hover:underline">Kelola</a>
                </div>

                <div class="space-y-2 mt-2">
                    @forelse($unduhanTerbaru as $unduhan)
                        <div class="p-2 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-2">
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-slate-900 truncate">{{ $unduhan->judul_dokumen }}</h4>
                                <span class="text-[9px] text-slate-400 block">{{ $unduhan->ukuran_berkas }} • {{ $unduhan->jumlah_unduhan }}x unduh</span>
                            </div>
                            <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-rose-100 text-rose-800 shrink-0">
                                {{ $unduhan->ekstensi_berkas }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center">Belum ada dokumen.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.unduhan') }}" wire:navigate class="text-[11px] font-extrabold text-rose-700 flex items-center justify-between">
                    <span>Lihat Semua Berkas SK</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- 5. BOTTOM TABLE SECTION (Berita Terkini & Medali Klasemen Top)             -->
    <!-- ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start">
        
        <!-- Left 8-cols: Publikasi Berita Terbaru (Compact) -->
        <div class="lg:col-span-8 bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <i data-lucide="newspaper" class="w-3.5 h-3.5"></i>
                    </div>
                    <div>
                        <h3 class="text-xs sm:text-sm font-black text-slate-900">Publikasi & Liputan Terkini</h3>
                        <p class="text-[10px] font-semibold text-slate-400">Warta liputan kegiatan KORMI</p>
                    </div>
                </div>
                <a href="{{ route('admin.berita') }}" wire:navigate class="text-xs font-extrabold text-emerald-700 hover:underline">
                    Kelola Berita
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs min-w-[480px]">
                    <thead>
                        <tr class="text-[10px] font-bold text-slate-400 border-b border-slate-100 pb-2">
                            <th class="pb-2 font-semibold">Judul Publikasi</th>
                            <th class="pb-2 font-semibold">Kategori</th>
                            <th class="pb-2 font-semibold">Pembaca</th>
                            <th class="pb-2 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($beritaTerbaru as $item)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 font-bold text-slate-900 max-w-[280px]">
                                    <span class="line-clamp-1">{{ $item->judul }}</span>
                                    <span class="text-[9px] font-medium text-slate-400">{{ \Carbon\Carbon::parse($item->dibuat_pada)->diffForHumans() }}</span>
                                </td>
                                <td class="py-2.5">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[9px] font-bold">
                                        {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="py-2.5">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-600">
                                        <i data-lucide="eye" class="w-3 h-3 text-slate-400"></i>
                                        {{ number_format($item->jumlah_dilihat, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="py-2.5 text-right">
                                    <a href="{{ route('admin.berita') }}" wire:navigate class="px-3 py-1 rounded-xl border border-slate-200 text-slate-800 font-bold text-xs hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all inline-block shadow-2xs">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400">Belum ada publikasi berita.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right 4-cols: Top Klasemen Medali (Compact) -->
        <div class="lg:col-span-4 bg-white border border-slate-200/80 rounded-3xl p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                            <i data-lucide="trophy" class="w-3.5 h-3.5"></i>
                        </div>
                        <div>
                            <h3 class="text-xs sm:text-sm font-black text-slate-900">Klasemen Teratas</h3>
                            <p class="text-[10px] font-semibold text-slate-400">Peringkat Medali Kontingen</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 mt-2">
                    <!-- #1 Margahayu -->
                    <div class="p-2.5 rounded-2xl bg-amber-50/70 border border-amber-200/60 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-amber-500 text-white text-[10px] font-black flex items-center justify-center shadow-2xs">1</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">{{ $topKecamatan->kecamatan->nama_kecamatan ?? 'Margahayu' }}</h4>
                                <span class="text-[9px] text-amber-800 font-bold">Juara Bertahan</span>
                            </div>
                        </div>
                        <span class="text-xs font-black text-amber-700">🥇 {{ $topKecamatan->jumlah_emas ?? 12 }} Emas</span>
                    </div>

                    <!-- #2 Soreang -->
                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-slate-300 text-slate-700 text-[10px] font-black flex items-center justify-center">2</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">Soreang</h4>
                                <span class="text-[9px] text-slate-400 font-medium">Runner Up</span>
                            </div>
                        </div>
                        <span class="text-xs font-black text-slate-700">🥈 9 Emas</span>
                    </div>

                    <!-- #3 Baleendah -->
                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-amber-200 text-amber-900 text-[10px] font-black flex items-center justify-center">3</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">Baleendah</h4>
                                <span class="text-[9px] text-slate-400 font-medium">Peringkat 3</span>
                            </div>
                        </div>
                        <span class="text-xs font-black text-amber-800">🥉 7 Emas</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 pt-2.5 border-t border-slate-100">
                <a href="{{ route('admin.klasemen') }}" wire:navigate class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center justify-between">
                    <span>Lihat 31 Kecamatan</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

    </div>

</div>
