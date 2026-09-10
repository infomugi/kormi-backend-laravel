<div class="space-y-8">
    
    <!-- 1. GREETING HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <span>Good morning, {{ explode(' ', auth()->user()->nama_lengkap ?? 'Admin')[0] }}</span>
                <span class="text-3xl sm:text-4xl">👋</span>
            </h1>
            <p class="text-xs sm:text-sm font-semibold text-slate-400 mt-1">Selamat datang di Panel Administrasi & Eksekutif Portal KORMI Kabupaten Bandung.</p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-4 py-2 rounded-full bg-white border border-slate-200/90 text-xs font-bold text-slate-700 shadow-2xs flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                <span>{{ \Carbon\Carbon::now()->format('l, d F Y') }}</span>
            </span>
        </div>
    </div>

    <!-- 2. QUICK ACTION PILLS (COLORFUL BADGES WITH PLUS ICON) -->
    <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none">
        <a href="{{ route('admin.berita') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="newspaper" class="w-4 h-4"></i>
            <span>Tulis Berita +</span>
        </a>

        <a href="{{ route('admin.galeri') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="image" class="w-4 h-4"></i>
            <span>Unggah Galeri +</span>
        </a>

        <a href="{{ route('admin.unduhan') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="file-text" class="w-4 h-4"></i>
            <span>Dokumen SK +</span>
        </a>

        <a href="{{ route('admin.duta') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="user-check" class="w-4 h-4"></i>
            <span>Duta Olahraga +</span>
        </a>

        <a href="{{ route('admin.inorga') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-lime-600 hover:bg-lime-700 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="shapes" class="w-4 h-4"></i>
            <span>Inorga & Komisi +</span>
        </a>

        <a href="{{ route('admin.klasemen') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="trophy" class="w-4 h-4"></i>
            <span>Input Medali +</span>
        </a>

        <a href="{{ route('admin.sapras') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="map-pin" class="w-4 h-4"></i>
            <span>Fasilitas SAPRAS +</span>
        </a>

        <a href="{{ route('admin.event') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="calendar" class="w-4 h-4"></i>
            <span>Event & Jadwal +</span>
        </a>

        <a href="{{ route('admin.pengurus') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="user-check" class="w-4 h-4"></i>
            <span>Pengurus +</span>
        </a>

        <a href="{{ route('admin.proker') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-emerald-900 hover:bg-slate-900 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="clipboard-list" class="w-4 h-4"></i>
            <span>Program Kerja +</span>
        </a>

        <a href="{{ route('admin.pengaturan') }}" wire:navigate class="px-4 py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition-all whitespace-nowrap cursor-pointer">
            <i data-lucide="settings" class="w-4 h-4"></i>
            <span>Pengaturan Situs</span>
        </a>
    </div>

    <!-- 3. MAIN DASHBOARD GRID (LEFT 2-COLUMNS CONTENT + RIGHT TO-DO & UPGRADE PRO SIDEBAR) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
        
        <!-- LEFT 8-COLS: MAIN METRICS & CHARTS -->
        <div class="xl:col-span-8 space-y-8">
            
            <!-- ROW A: TOP 2 SUMMARY CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Card 1: Most Issued Content / Berita Terpopuler -->
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-7 shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-xs text-slate-400 font-semibold mb-3">
                            <span class="flex items-center gap-1.5 text-slate-700 font-bold">
                                <span>Publikasi Unggulan</span>
                                <i data-lucide="info" class="w-3.5 h-3.5 text-slate-400"></i>
                            </span>
                            <span>Minggu Ini</span>
                        </div>

                        <div class="flex items-start justify-between gap-4 mt-2">
                            <div>
                                <span class="px-2 py-0.5 rounded-md bg-cyan-100 text-cyan-800 text-[10px] font-black uppercase tracking-wider inline-flex items-center gap-1">
                                    <i data-lucide="newspaper" class="w-3 h-3"></i> Berita Utama
                                </span>
                                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 mt-2 line-clamp-2 leading-snug">
                                    {{ $beritaTerbaru->first()->judul ?? 'Persiapan Menuju FORKAB 2026 Kabupaten Bandung' }}
                                </h3>
                                <span class="text-xs font-bold text-emerald-600 flex items-center gap-1 mt-2">
                                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
                                    <span>+18% pembaca baru</span>
                                </span>
                            </div>

                            <div class="text-right shrink-0">
                                <span class="text-3xl font-black text-slate-900 block leading-none">{{ $totalBerita }}</span>
                                <span class="text-[10px] font-bold text-slate-400 block mt-1">Total Berita</span>
                                
                                <!-- Mini Sparkline Wave -->
                                <div class="mt-3 flex items-center justify-end text-emerald-500">
                                    <svg class="w-16 h-6 stroke-current" fill="none" viewBox="0 0 64 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 18 L16 12 L30 16 L44 6 L62 10" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('admin.berita') }}" wire:navigate class="text-xs font-bold text-slate-700 hover:text-slate-950">Lihat semua artikel & berita</a>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                    </div>
                </div>

                <!-- Card 2: Assignment / Progress Duta Olahraga -->
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-7 shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-xs text-slate-400 font-semibold mb-3">
                            <span class="flex items-center gap-1.5 text-slate-700 font-bold">
                                <span>Partisipasi Duta Olahraga</span>
                                <i data-lucide="info" class="w-3.5 h-3.5 text-slate-400"></i>
                            </span>
                        </div>

                        <div class="mt-2">
                            <div class="flex items-baseline justify-between">
                                <span class="text-2xl sm:text-3xl font-black text-slate-900">{{ $totalDuta }} Terdaftar</span>
                                <span class="text-xs font-bold text-slate-400">{{ 280 - $totalDuta }} Desa tersisa</span>
                            </div>

                            <!-- Dual Color Progress Bar -->
                            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden mt-4 flex">
                                <div class="bg-emerald-600 h-full rounded-full" style="width: {{ min(100, round(($totalDuta / 280) * 100)) }}%;"></div>
                            </div>
                            <span class="text-[11px] font-bold text-slate-400 block mt-2">Target 280 Desa/Kelurahan se-Kabupaten Bandung</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('admin.duta') }}" wire:navigate class="text-xs font-bold text-slate-700 hover:text-emerald-700 flex items-center gap-2">
                            <i data-lucide="user-check" class="w-4 h-4 text-emerald-600"></i>
                            <span>Kelola data duta olahraga</span>
                        </a>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                    </div>
                </div>
            </div>

            <!-- ROW B: SEMI-DONUT GAUGE CHART & TOP INORGA/KONTINGEN LIST -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                
                <!-- Semi-Donut Gauge (Col-Span 6) -->
                <div class="md:col-span-6 bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-7 shadow-xs">
                    <div class="flex items-center justify-between mb-4">
                        <span class="flex items-center gap-1.5 text-sm font-black text-slate-900">
                            <span>Status Konten & Data</span>
                            <i data-lucide="info" class="w-3.5 h-3.5 text-slate-400"></i>
                        </span>
                        <span class="text-xs font-bold text-slate-500 flex items-center gap-1 cursor-pointer">
                            <span>By status</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-6 mt-6">
                        <!-- Semi-donut Visual Arc -->
                        <div class="relative w-44 h-28 flex items-end justify-center shrink-0">
                            <svg class="w-44 h-44 -rotate-90 absolute top-0" viewBox="0 0 100 100">
                                <!-- Background Arc -->
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#e2e8f0" stroke-width="12" stroke-dasharray="125 250" stroke-linecap="round" />
                                <!-- Emerald Green Section (Berita) -->
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#059669" stroke-width="12" stroke-dasharray="45 250" stroke-linecap="round" />
                                <!-- Bedas Lime Section (Unduhan) -->
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#8ed500" stroke-width="12" stroke-dasharray="30 250" stroke-dashoffset="-48" stroke-linecap="round" />
                                <!-- Amber Section (Inorga) -->
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#f59e0b" stroke-width="12" stroke-dasharray="25 250" stroke-dashoffset="-80" stroke-linecap="round" />
                                <!-- Teal Section (Galeri) -->
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#0d9488" stroke-width="12" stroke-dasharray="18 250" stroke-dashoffset="-107" stroke-linecap="round" />
                            </svg>
                            <div class="text-center z-10 pb-1">
                                <span class="text-[10px] font-bold text-slate-400 block uppercase">Total Konten</span>
                                <span class="text-3xl font-black text-slate-900 leading-none">{{ $totalBerita + $totalUnduhan + $totalInorga }}</span>
                            </div>
                        </div>

                        <!-- Legend List with Percentage -->
                        <div class="flex-1 w-full space-y-2.5 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2 font-bold text-slate-700">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span> Berita Terbit
                                </span>
                                <span class="font-black text-slate-900">84%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2 font-bold text-slate-700">
                                    <span class="w-2.5 h-2.5 rounded-full bg-teal-600"></span> Galeri Foto
                                </span>
                                <span class="font-black text-slate-900">8%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2 font-bold text-slate-700">
                                    <span class="w-2.5 h-2.5 rounded-full bg-lime-600"></span> Inorga Aktif
                                </span>
                                <span class="font-black text-slate-900">5%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2 font-bold text-slate-700">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Dokumen SK
                                </span>
                                <span class="font-black text-slate-900">3%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Kontingen / Kecamatan Leaderboard (Col-Span 6) -->
                <div class="md:col-span-6 bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-7 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="flex items-center gap-1.5 text-sm font-black text-slate-900">
                                <span>Klasemen Unggulan FORKAB</span>
                                <i data-lucide="info" class="w-3.5 h-3.5 text-slate-400"></i>
                            </span>
                        </div>

                        <!-- 3 Top Ranked Kecamatan -->
                        <div class="space-y-3.5 mt-4">
                            <!-- #1 -->
                            <div class="flex items-center justify-between gap-3 p-2.5 rounded-2xl bg-amber-50/50 border border-amber-100">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-black text-amber-700">#1</span>
                                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center font-black text-xs">
                                        🥇
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900">{{ $topKecamatan->kecamatan->nama_kecamatan ?? 'Kecamatan Margahayu' }}</h4>
                                        <span class="text-[10px] text-slate-500 font-medium">Kontingen Juara Umum</span>
                                    </div>
                                </div>
                                <span class="text-xs font-black text-amber-700 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span> 100 pts
                                </span>
                            </div>

                            <!-- #2 -->
                            <div class="flex items-center justify-between gap-3 p-2.5 rounded-2xl hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-black text-slate-400">#2</span>
                                    <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-black text-xs">
                                        🥈
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900">Kecamatan Soreang</h4>
                                        <span class="text-[10px] text-slate-400 font-medium">Runner Up Kontingen</span>
                                    </div>
                                </div>
                                <span class="text-xs font-black text-slate-600 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-slate-400"></span> 80 pts
                                </span>
                            </div>

                            <!-- #3 -->
                            <div class="flex items-center justify-between gap-3 p-2.5 rounded-2xl hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-black text-slate-400">#3</span>
                                    <div class="w-8 h-8 rounded-full bg-amber-200 text-amber-900 flex items-center justify-center font-black text-xs">
                                        🥉
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900">Kecamatan Baleendah</h4>
                                        <span class="text-[10px] text-slate-400 font-medium">Peringkat 3 Medali</span>
                                    </div>
                                </div>
                                <span class="text-xs font-black text-amber-900 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-amber-600"></span> 75 pts
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 text-left">
                        <a href="{{ route('admin.klasemen') }}" wire:navigate class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1">
                            <span>Lihat Semua Klasemen</span>
                            <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ROW C: BOTTOM DATA TABLE (UNGGRADED QUIZ / ARTIKEL VERIFIKASI) -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-7 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <span class="flex items-center gap-1.5 text-sm font-black text-slate-900">
                        <span>Publikasi & Liputan Terkini</span>
                        <i data-lucide="info" class="w-3.5 h-3.5 text-slate-400"></i>
                    </span>
                    <a href="{{ route('admin.berita') }}" wire:navigate class="text-xs font-bold text-emerald-700 hover:underline">Kelola Berita</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs min-w-[550px]">
                        <thead>
                            <tr class="text-[11px] font-bold text-slate-400 border-b border-slate-100 pb-3">
                                <th class="pb-3 font-semibold w-10">No</th>
                                <th class="pb-3 font-semibold">Judul Publikasi</th>
                                <th class="pb-3 font-semibold">Kategori</th>
                                <th class="pb-3 font-semibold">Penulis</th>
                                <th class="pb-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($beritaTerbaru as $idx => $item)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="py-3.5 font-bold text-slate-900">{{ $idx + 1 }}</td>
                                    <td class="py-3.5 font-bold text-slate-900 max-w-[260px] truncate">
                                        {{ $item->judul }}
                                    </td>
                                    <td class="py-3.5 text-slate-600">
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                            <i data-lucide="tag" class="w-3.5 h-3.5 text-slate-400"></i>
                                            {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-emerald-700 text-white flex items-center justify-center text-[10px] font-bold">
                                                {{ substr($item->penulis->nama_lengkap ?? 'Admin', 0, 1) }}
                                            </div>
                                            <span class="text-slate-800 font-semibold">{{ $item->penulis->nama_lengkap ?? 'Admin KORMI' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 text-right">
                                        <a href="{{ route('admin.berita') }}" wire:navigate class="px-4 py-1.5 rounded-xl border border-slate-200 text-slate-800 font-bold text-xs hover:bg-emerald-700 hover:text-white hover:border-emerald-700 transition-all inline-block shadow-2xs">
                                            Kelola
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400">Belum ada publikasi berita.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- RIGHT 4-COLS: TO-DO LIST & PRO / EXECUTIVE CARD -->
        <div class="xl:col-span-4 space-y-6">
            
            <!-- 1. TO-DO LIST CARD -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-7 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <span class="flex items-center gap-1.5 text-sm font-black text-slate-900">
                        <span>Agenda KORMI</span>
                        <i data-lucide="info" class="w-3.5 h-3.5 text-slate-400"></i>
                    </span>
                </div>

                <div class="space-y-4">
                    <!-- Add Task Input -->
                    <div class="flex items-center gap-2 text-xs font-bold text-emerald-700 hover:text-emerald-900 cursor-pointer pb-2">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Tambah agenda kegiatan baru...</span>
                    </div>

                    <!-- Item 1 -->
                    <div class="space-y-1 pt-2 border-t border-slate-100">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="mt-0.5 rounded-full border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">Rapat Koordinasi 31 KORCAM</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">Sosialisasi teknis pembinaan FOTRADKAB</span>
                                <span class="text-[10px] font-bold text-rose-500 flex items-center gap-1 mt-1">
                                    <i data-lucide="calendar" class="w-3 h-3"></i> Besok, 09:00 WIB
                                </span>
                            </div>
                        </label>
                    </div>

                    <!-- Item 2 -->
                    <div class="space-y-1 pt-3 border-t border-slate-100">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="mt-0.5 rounded-full border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">Verifikasi SK Inorga Baru (OPT)</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">Pemeriksaan kelengkapan berkas AD/ART</span>
                                <span class="text-[10px] font-bold text-emerald-700 flex items-center gap-1 mt-1">
                                    <i data-lucide="flag" class="w-3 h-3"></i> Prioritas Tinggi
                                </span>
                            </div>
                        </label>
                    </div>

                    <!-- Item 3 -->
                    <div class="space-y-1 pt-3 border-t border-slate-100">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="mt-0.5 rounded-full border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">Update Klasemen Medali FORKAB</span>
                                <span class="text-[10px] font-bold text-emerald-600 flex items-center gap-1 mt-1">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i> Hari Ini
                                </span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- 2. UPGRADE / EXECUTIVE SUPPORT CARD -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/60 border border-emerald-200/80 rounded-3xl p-6 sm:p-7 shadow-xs space-y-5">
                <div>
                    <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-600 text-white text-[10px] font-black uppercase tracking-wider mb-2">
                        <span>KORMI BEDAS 2026</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-900">Pusat Data Terpadu</h3>
                    <p class="text-xs font-black text-emerald-800 mt-0.5">KORMI Kabupaten Bandung</p>
                </div>

                <div class="space-y-2.5 text-xs font-bold text-slate-800">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                        <span>31 Kecamatan Terkoneksi</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                        <span>Integrasi Database Duta 280 Desa</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                        <span>Sistem Realtime Medali FORKAB</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                        <span>Manajemen Arsip SK & Regulasi</span>
                    </div>
                </div>

                <p class="text-[11px] text-slate-600 leading-relaxed font-medium">
                    Panel kendali terpadu untuk memantau kemajuan olahraga rekreasi dan tradisional masyarakat se-Kabupaten Bandung.
                </p>

                <a href="{{ route('beranda') }}" target="_blank" class="w-full py-3 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-sm transition-all cursor-pointer">
                    <i data-lucide="zap" class="w-4 h-4 fill-white"></i>
                    <span>Buka Portal Utama</span>
                </a>
            </div>
        </div>
    </div>
</div>
