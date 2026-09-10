<div class="space-y-6">

    <!-- FLASH NOTIFICATION -->
    @if(session()->has('pesan'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-900 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xs animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
                <div>
                    <p class="font-extrabold text-emerald-950">Berhasil!</p>
                    <p class="text-xs text-emerald-800 font-medium">{{ session('pesan') }}</p>
                </div>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 p-1.5 rounded-lg transition-colors cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

        <!-- ========================================================= -->
        <!-- VIEW MODE: TABEL & DAFTAR BERITA                          -->
        <!-- ========================================================= -->
        <div wire:key="berita-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                        <span>PUBLIKASI MEDIA</span>
                        <span>•</span>
                        <span class="text-indigo-600 font-black">BERITA & ARTIKEL</span>
                    </div>
                    <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Berita & Publikasi</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Pusat manajemen konten warta, siaran pers liputan, dan dokumentasi inorga KORMI Kabupaten Bandung.</p>
                </div>
                
                <div class="flex items-center gap-2.5 self-start md:self-auto flex-wrap">
                    <button 
                        type="button" 
                        wire:click="bukaModalTambahKategori"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs shadow-2xs transition-all cursor-pointer active:scale-95"
                    >
                        <i data-lucide="tag" class="w-4 h-4 text-indigo-600"></i>
                        <span>+ Kategori Baru</span>
                    </button>

                    <a 
                        href="{{ route('admin.berita.tambah') }}" 
                        wire:navigate
                        class="inline-flex items-center justify-center gap-2.5 px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95"
                    >
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Tulis Berita Baru</span>
                    </a>
                </div>
            </div>

            <!-- 2. KPI METRIC STATS -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
                <!-- Total Berita -->
                <div 
                    wire:click="resetSemuaFilter"
                    class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/80 shadow-xs hover:border-indigo-200 hover:shadow-md transition-all cursor-pointer group"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Berita</span>
                        <div class="w-9 h-9 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="newspaper" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-black text-slate-900 mt-2">{{ number_format($totalBerita) }} <span class="text-xs font-bold text-slate-400">Post</span></p>
                    <p class="text-[10px] text-slate-400 mt-1">Klik untuk lihat semua</p>
                </div>

                <!-- Terbit (Live) -->
                <div 
                    wire:click="setFilterStatus('published')"
                    class="bg-white rounded-3xl p-4 sm:p-5 border {{ $statusDipilih === 'published' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200/80' }} shadow-xs hover:border-emerald-300 hover:shadow-md transition-all cursor-pointer group"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Terbit (Live)</span>
                        <div class="w-9 h-9 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform relative">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 absolute top-1.5 right-1.5 animate-pulse"></span>
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-black text-emerald-600 mt-2">{{ number_format($totalPublished) }} <span class="text-xs font-bold text-slate-400">Live</span></p>
                    <p class="text-[10px] text-slate-400 mt-1">Tayang di portal</p>
                </div>

                <!-- Draf Disimpan -->
                <div 
                    wire:click="setFilterStatus('draft')"
                    class="bg-white rounded-3xl p-4 sm:p-5 border {{ $statusDipilih === 'draft' ? 'border-amber-500 ring-2 ring-amber-500/20' : 'border-slate-200/80' }} shadow-xs hover:border-amber-300 hover:shadow-md transition-all cursor-pointer group"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Draf Disimpan</span>
                        <div class="w-9 h-9 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="file-edit" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-black text-amber-600 mt-2">{{ number_format($totalDraft) }} <span class="text-xs font-bold text-slate-400">Draf</span></p>
                    <p class="text-[10px] text-slate-400 mt-1">Belum dipublikasikan</p>
                </div>

                <!-- Berita Utama / Headline -->
                <div 
                    wire:click="setFilterUnggulan('1')"
                    class="bg-white rounded-3xl p-4 sm:p-5 border {{ $unggulanDipilih === '1' ? 'border-amber-500 ring-2 ring-amber-500/20' : 'border-slate-200/80' }} shadow-xs hover:border-amber-300 hover:shadow-md transition-all cursor-pointer group"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Headline Utama</span>
                        <div class="w-9 h-9 rounded-2xl bg-amber-100/70 text-amber-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="star" class="w-4 h-4 fill-amber-500 text-amber-500"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-black text-slate-900 mt-2">{{ number_format($totalUnggulan) }} <span class="text-xs font-bold text-slate-400">Hero</span></p>
                    <p class="text-[10px] text-slate-400 mt-1">Sorotan beranda publik</p>
                </div>

                <!-- Total Pembaca & Avg -->
                <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/80 shadow-xs col-span-2 lg:col-span-1">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pembaca</span>
                        <div class="w-9 h-9 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-black text-slate-900 mt-2">{{ number_format($totalViews) }} <span class="text-xs font-bold text-slate-400">Views</span></p>
                    <p class="text-[10px] text-slate-400 mt-1">Rata-rata: ~{{ number_format($rataRataViews) }}/post</p>
                </div>
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs space-y-3">
                <!-- Row 1: Category Filter Scroll -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                    <button 
                        type="button"
                        wire:click="setFilterKategori('Semua')" 
                        class="px-4 py-2 rounded-2xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap flex items-center gap-1.5 {{ $kategoriDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                    >
                        <span>Semua Kategori</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $kategoriDipilih === 'Semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $totalBerita }}</span>
                    </button>

                    @foreach($kategoriList as $k)
                        <button 
                            type="button"
                            wire:click="setFilterKategori('{{ $k->id }}')" 
                            class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap transition-all cursor-pointer flex items-center gap-2 {{ $kategoriDipilih === $k->id ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $k->kode_warna_hex ?: '#4f46e5' }}"></span>
                            <span>{{ $k->nama_kategori }}</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $kategoriDipilih === $k->id ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $k->berita_count }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Row 2: Search, Status, Sort, View Toggle -->
                <div class="flex flex-col lg:flex-row items-center justify-between gap-3 pt-2 border-t border-slate-100">
                    <!-- Left: Search Box -->
                    <div class="relative w-full lg:w-96">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="cari" 
                            placeholder="Cari judul artikel, ringkasan, isi konten..." 
                            class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-400 placeholder:font-normal"
                        >
                        @if($cari)
                            <button 
                                type="button" 
                                wire:click="$set('cari', '')" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 rounded-md cursor-pointer"
                            >
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            </button>
                        @endif
                    </div>

                    <!-- Right Controls -->
                    <div class="flex items-center gap-2.5 w-full lg:w-auto flex-wrap justify-end">
                        <!-- Status Filter -->
                        <select wire:model.live="statusDipilih" class="px-3 py-2 bg-slate-50 border border-slate-200 text-slate-700 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="Semua">Semua Status</option>
                            <option value="published">Status: Published</option>
                            <option value="draft">Status: Draft</option>
                            <option value="archived">Status: Archived</option>
                        </select>

                        <!-- Featured Filter -->
                        <select wire:model.live="unggulanDipilih" class="px-3 py-2 bg-slate-50 border border-slate-200 text-slate-700 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="Semua">Semua Sorotan</option>
                            <option value="1">⭐ Berita Utama</option>
                            <option value="0">Berita Standar</option>
                        </select>

                        <!-- Sort By -->
                        <select wire:model.live="urutkan" class="px-3 py-2 bg-slate-50 border border-slate-200 text-slate-700 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="terbaru">Urutan: Terbaru</option>
                            <option value="terlama">Urutan: Terlama</option>
                            <option value="terpopuler">Urutan: Terbanyak Dilihat</option>
                            <option value="judul_asc">Judul: A - Z</option>
                        </select>

                        <!-- Per Page -->
                        <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50 border border-slate-200 text-slate-700 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="10">10 / hal</option>
                            <option value="25">25 / hal</option>
                            <option value="50">50 / hal</option>
                        </select>

                        <!-- View Switcher -->
                        <div class="flex items-center p-1 bg-slate-100 rounded-2xl border border-slate-200 shrink-0">
                            <button 
                                type="button" 
                                wire:click="$set('tampilanMode', 'tabel')" 
                                class="p-1.5 rounded-xl transition-all cursor-pointer {{ $tampilanMode === 'tabel' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-400 hover:text-slate-700' }}"
                                title="Tampilan Tabel Data"
                            >
                                <i data-lucide="list" class="w-4 h-4"></i>
                            </button>
                            <button 
                                type="button" 
                                wire:click="$set('tampilanMode', 'grid')" 
                                class="p-1.5 rounded-xl transition-all cursor-pointer {{ $tampilanMode === 'grid' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-400 hover:text-slate-700' }}"
                                title="Tampilan Kartu / Grid"
                            >
                                <i data-lucide="layout-grid" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. FLOATING BULK ACTIONS BAR (When items selected) -->
            @if(count($selectedBerita) > 0)
                <div class="p-3.5 sm:p-4 bg-slate-900 text-white rounded-2xl shadow-xl flex flex-col sm:flex-row items-center justify-between gap-3 animate-in fade-in slide-in-from-bottom-3 duration-200">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-indigo-500 text-white font-black text-xs flex items-center justify-center shrink-0">
                            {{ count($selectedBerita) }}
                        </span>
                        <span class="text-xs font-bold text-slate-200">Artikel dipilih</span>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap justify-end">
                        <button 
                            type="button" 
                            wire:click="bulkPublish" 
                            class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5"
                        >
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                            <span>Terbitkan</span>
                        </button>

                        <button 
                            type="button" 
                            wire:click="bulkDraft" 
                            class="px-3 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5"
                        >
                            <i data-lucide="file-edit" class="w-3.5 h-3.5"></i>
                            <span>Jadikan Draf</span>
                        </button>

                        <button 
                            type="button" 
                            wire:click="bulkToggleUnggulan(true)" 
                            class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5"
                        >
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                            <span>Jadikan Utama</span>
                        </button>

                        <button 
                            type="button" 
                            wire:click="bulkDelete" 
                            wire:confirm="Yakin ingin menghapus {{ count($selectedBerita) }} artikel terpilih secara permanen?"
                            class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5"
                        >
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            <span>Hapus Terpilih</span>
                        </button>

                        <button 
                            type="button" 
                            wire:click="resetSelection" 
                            class="p-1.5 text-slate-400 hover:text-white rounded-lg transition-colors cursor-pointer"
                            title="Batalkan Pilihan"
                        >
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- 5. DATA PRESENTATION: TABLE OR GRID -->
            @if($tampilanMode === 'tabel')
                <!-- TABLE VIEW -->
                <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-50 text-[10px] uppercase font-black tracking-wider text-slate-400 border-b border-slate-200/80">
                                <tr>
                                    <th class="w-12 px-5 py-4 text-center">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="pilihSemua" 
                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                        >
                                    </th>
                                    <th class="px-6 py-4">Berita & Ringkasan</th>
                                    <th class="px-6 py-4">Kategori</th>
                                    <th class="px-6 py-4">Status & Sorotan</th>
                                    <th class="px-6 py-4">Statistik</th>
                                    <th class="px-6 py-4">Tanggal Rilis</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($beritaList as $b)
                                    <tr wire:key="row-berita-{{ $b->id }}" class="hover:bg-slate-50/80 transition-colors {{ in_array($b->id, $selectedBerita) ? 'bg-indigo-50/30' : '' }}">
                                        <!-- Checkbox -->
                                        <td class="px-5 py-4 text-center">
                                            <input 
                                                type="checkbox" 
                                                wire:model.live="selectedBerita" 
                                                value="{{ $b->id }}" 
                                                class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                            >
                                        </td>

                                        <!-- Thumbnail & Title -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start gap-4 max-w-xl">
                                                <div class="relative shrink-0 group">
                                                    <img 
                                                        src="{{ $b->gambar_url }}" 
                                                        class="w-20 h-16 rounded-2xl object-cover border border-slate-200/80 shadow-2xs group-hover:scale-105 transition-transform" 
                                                        alt="{{ $b->judul }}"
                                                        onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=400'"
                                                    >
                                                    @if($b->status_unggulan)
                                                        <span class="absolute -top-1.5 -left-1.5 w-5 h-5 bg-amber-400 text-slate-900 rounded-full flex items-center justify-center text-[10px] shadow-xs" title="Berita Utama">⭐</span>
                                                    @endif
                                                </div>

                                                <div class="space-y-1">
                                                    <a 
                                                        href="javascript:void(0)" 
                                                        wire:click="bukaFormEdit('{{ $b->id }}')" 
                                                        class="font-black text-slate-900 text-xs sm:text-sm hover:text-indigo-600 line-clamp-1 leading-snug transition-colors cursor-pointer"
                                                    >
                                                        {{ $b->judul }}
                                                    </a>
                                                    <p class="text-[11px] text-slate-500 line-clamp-1 font-normal">{{ $b->ringkasan }}</p>
                                                    <div class="flex items-center gap-2 text-[10px] text-slate-400 pt-0.5">
                                                        <span class="font-bold text-slate-600">{{ $b->penulis->nama_lengkap ?? 'Redaksi KORMI' }}</span>
                                                        <span>•</span>
                                                        <span class="flex items-center gap-1">
                                                            <i data-lucide="clock" class="w-3 h-3"></i>
                                                            <span>~{{ $b->estimasi_menit_baca }} mnt baca</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Category Badge -->
                                        <td class="px-6 py-4">
                                            <span 
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border shadow-2xs"
                                                style="background-color: {{ $b->kategori->kode_warna_hex ? $b->kategori->kode_warna_hex.'15' : '#4f46e515' }}; color: {{ $b->kategori->kode_warna_hex ?: '#4f46e5' }}; border-color: {{ $b->kategori->kode_warna_hex ? $b->kategori->kode_warna_hex.'30' : '#4f46e530' }};"
                                            >
                                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $b->kategori->kode_warna_hex ?: '#4f46e5' }}"></span>
                                                <span>{{ $b->kategori->nama_kategori ?? 'Umum' }}</span>
                                            </span>
                                        </td>

                                        <!-- Status & Featured Toggle -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                @php
                                                    $statusStyle = match($b->status_publikasi) {
                                                        'published' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                        'draft'     => 'bg-amber-50 text-amber-700 border-amber-200',
                                                        'archived'  => 'bg-slate-100 text-slate-700 border-slate-200',
                                                        default     => 'bg-slate-100 text-slate-700 border-slate-200'
                                                    };
                                                @endphp

                                                <button 
                                                    type="button" 
                                                    wire:click="toggleStatus('{{ $b->id }}')" 
                                                    class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusStyle }} hover:scale-105 transition-all cursor-pointer"
                                                    title="Klik untuk ubah status (Published / Draft / Archived)"
                                                >
                                                    {{ $b->status_publikasi }}
                                                </button>
                                                
                                                <button 
                                                    type="button" 
                                                    wire:key="star-btn-{{ $b->id }}"
                                                    wire:click="toggleUnggulan('{{ $b->id }}')" 
                                                    class="p-1.5 rounded-xl transition-all hover:scale-125 cursor-pointer {{ $b->status_unggulan ? 'text-amber-500 bg-amber-50' : 'text-slate-300 hover:text-amber-400 hover:bg-slate-100' }}" 
                                                    title="{{ $b->status_unggulan ? 'Hapus dari Berita Utama' : 'Jadikan Berita Utama (Headline)' }}"
                                                >
                                                    <i data-lucide="star" class="w-4 h-4 {{ $b->status_unggulan ? 'fill-amber-400 text-amber-500' : '' }}"></i>
                                                </button>
                                            </div>
                                        </td>

                                        <!-- Views -->
                                        <td class="px-6 py-4 font-black text-slate-800">
                                            <div class="flex items-center gap-1.5 text-xs">
                                                <i data-lucide="eye" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>{{ number_format($b->jumlah_dilihat) }}</span>
                                            </div>
                                        </td>

                                        <!-- Publish Date -->
                                        <td class="px-6 py-4 text-slate-500 text-[11px] font-semibold">
                                            @if($b->tanggal_publikasi)
                                                <p class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($b->tanggal_publikasi)->format('d M Y') }}</p>
                                                <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($b->tanggal_publikasi)->diffForHumans() }}</p>
                                            @else
                                                <span class="text-slate-400 italic">Belum dijadwalkan</span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <!-- Quick Preview Modal -->
                                                <button 
                                                    type="button" 
                                                    wire:click="bukaModalPratinjau('{{ $b->id }}')" 
                                                    class="p-2 rounded-xl text-slate-400 hover:text-cyan-600 hover:bg-cyan-50 transition-colors cursor-pointer" 
                                                    title="Pratinjau Cepat"
                                                >
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                </button>

                                                <!-- View Live on Portal -->
                                                <a 
                                                    href="{{ route('berita.detail', $b->slug) }}" 
                                                    target="_blank" 
                                                    class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors cursor-pointer" 
                                                    title="Buka Halaman Publik"
                                                >
                                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                                </a>

                                                <!-- Duplicate -->
                                                <button 
                                                    type="button" 
                                                    wire:click="duplikatBerita('{{ $b->id }}')" 
                                                    class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer" 
                                                    title="Duplikasi Berita"
                                                >
                                                    <i data-lucide="copy" class="w-4 h-4"></i>
                                                </button>

                                                <!-- Edit Button -->
                                                <button 
                                                    type="button" 
                                                    wire:click="bukaFormEdit('{{ $b->id }}')" 
                                                    class="p-2 rounded-xl text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 transition-colors cursor-pointer font-bold" 
                                                    title="Edit Berita"
                                                >
                                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <button 
                                                    type="button" 
                                                    wire:click="konfirmasiHapus('{{ $b->id }}')" 
                                                    class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer" 
                                                    title="Hapus Berita"
                                                >
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                                            <div class="max-w-md mx-auto space-y-3">
                                                <div class="w-14 h-14 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto shadow-2xs">
                                                    <i data-lucide="newspaper" class="w-7 h-7"></i>
                                                </div>
                                                <h3 class="text-sm font-black text-slate-800">Tidak ada artikel berita ditemukan</h3>
                                                <p class="text-xs text-slate-400 font-medium">Coba sesuaikan kata kunci pencarian atau reset filter untuk menampilkan data berita lainnya.</p>
                                                <button 
                                                    type="button" 
                                                    wire:click="resetSemuaFilter" 
                                                    class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors cursor-pointer"
                                                >
                                                    Reset Semua Filter
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <span class="text-xs text-slate-500 font-medium">
                            Menampilkan <span class="font-bold text-slate-800">{{ $beritaList->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-800">{{ $beritaList->lastItem() ?? 0 }}</span> dari total <span class="font-bold text-slate-800">{{ $beritaList->total() }}</span> artikel
                        </span>
                        <div>
                            {{ $beritaList->links() }}
                        </div>
                    </div>
                </div>

            @else
                <!-- GRID / CARDS VIEW -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @forelse($beritaList as $b)
                        <div wire:key="grid-berita-{{ $b->id }}" class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs hover:shadow-lg hover:border-indigo-200 transition-all flex flex-col group {{ in_array($b->id, $selectedBerita) ? 'ring-2 ring-indigo-500' : '' }}">
                            <!-- Image Cover with Badges -->
                            <div class="relative h-48 bg-slate-100 overflow-hidden">
                                <img 
                                    src="{{ $b->gambar_url }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                    alt="{{ $b->judul }}"
                                    onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=600'"
                                >
                                
                                <!-- Top Bar Overlay -->
                                <div class="absolute top-3 inset-x-3 flex items-center justify-between pointer-events-auto">
                                    <span 
                                        class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider backdrop-blur-md bg-white/90 shadow-xs"
                                        style="color: {{ $b->kategori->kode_warna_hex ?: '#4f46e5' }};"
                                    >
                                        {{ $b->kategori->nama_kategori ?? 'Umum' }}
                                    </span>

                                    <div class="flex items-center gap-1.5">
                                        <button 
                                            type="button" 
                                            wire:click="toggleUnggulan('{{ $b->id }}')" 
                                            class="w-8 h-8 rounded-full backdrop-blur-md transition-transform active:scale-90 flex items-center justify-center shadow-xs cursor-pointer {{ $b->status_unggulan ? 'bg-amber-400 text-slate-900' : 'bg-white/80 text-slate-400 hover:text-amber-500' }}"
                                            title="Toggle Berita Utama"
                                        >
                                            <i data-lucide="star" class="w-4 h-4 {{ $b->status_unggulan ? 'fill-slate-900' : '' }}"></i>
                                        </button>

                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedBerita" 
                                            value="{{ $b->id }}" 
                                            class="w-5 h-5 rounded-lg text-indigo-600 focus:ring-indigo-500 cursor-pointer shadow-xs"
                                        >
                                    </div>
                                </div>

                                <!-- Status Badge Bottom-Left -->
                                <div class="absolute bottom-3 left-3">
                                    @php
                                        $gridStatusClass = match($b->status_publikasi) {
                                            'published' => 'bg-emerald-500 text-white',
                                            'draft'     => 'bg-amber-500 text-white',
                                            'archived'  => 'bg-slate-700 text-white',
                                            default     => 'bg-slate-600 text-white'
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider shadow-xs {{ $gridStatusClass }}">
                                        {{ $b->status_publikasi }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                <div class="space-y-2">
                                    <h3 class="font-black text-slate-900 text-base leading-snug line-clamp-2 hover:text-indigo-600 transition-colors cursor-pointer" wire:click="bukaFormEdit('{{ $b->id }}')">
                                        {{ $b->judul }}
                                    </h3>
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $b->ringkasan }}</p>
                                </div>

                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 font-black text-[10px] flex items-center justify-center uppercase">
                                            {{ substr($b->penulis->nama_lengkap ?? 'R', 0, 1) }}
                                        </div>
                                        <span class="font-bold text-slate-700 truncate max-w-[120px]">{{ $b->penulis->nama_lengkap ?? 'Redaksi' }}</span>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                            <span>{{ number_format($b->jumlah_dilihat) }}</span>
                                        </span>
                                        <span>{{ \Carbon\Carbon::parse($b->tanggal_publikasi ?? $b->dibuat_pada)->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <!-- Card Actions -->
                                <div class="grid grid-cols-4 gap-1.5 pt-2">
                                    <button 
                                        type="button" 
                                        wire:click="bukaModalPratinjau('{{ $b->id }}')" 
                                        class="py-2 rounded-xl bg-slate-100 hover:bg-cyan-50 hover:text-cyan-600 text-slate-600 font-bold text-xs transition-colors flex items-center justify-center gap-1 cursor-pointer" 
                                        title="Pratinjau"
                                    >
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <a 
                                        href="{{ route('berita.detail', $b->slug) }}" 
                                        target="_blank" 
                                        class="py-2 rounded-xl bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-600 font-bold text-xs transition-colors flex items-center justify-center gap-1 cursor-pointer" 
                                        title="Halaman Web"
                                    >
                                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <button 
                                        type="button" 
                                        wire:click="bukaFormEdit('{{ $b->id }}')" 
                                        class="py-2 rounded-xl bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 font-bold text-xs transition-all flex items-center justify-center gap-1 cursor-pointer" 
                                        title="Edit"
                                    >
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </button>

                                    <button 
                                        type="button" 
                                        wire:click="konfirmasiHapus('{{ $b->id }}')" 
                                        class="py-2 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-400 font-bold text-xs transition-colors flex items-center justify-center cursor-pointer" 
                                        title="Hapus"
                                    >
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center text-slate-400 bg-white border border-slate-200/80 rounded-3xl">
                            <i data-lucide="newspaper" class="w-10 h-10 text-slate-300 mx-auto mb-3"></i>
                            <h3 class="text-sm font-black text-slate-800">Tidak ada artikel berita</h3>
                            <p class="text-xs text-slate-400 mt-1">Coba sesuaikan filter atau tambahkan artikel berita baru.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination for Grid -->
                <div class="p-4 bg-white border border-slate-200/80 rounded-3xl shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="text-xs text-slate-500 font-medium">
                        Menampilkan <span class="font-bold text-slate-800">{{ $beritaList->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-800">{{ $beritaList->lastItem() ?? 0 }}</span> dari total <span class="font-bold text-slate-800">{{ $beritaList->total() }}</span> artikel
                    </span>
                    <div>
                        {{ $beritaList->links() }}
                    </div>
                </div>
            @endif

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- MODAL 1: QUICK LIVE PREVIEW                               -->
    <!-- ========================================================= -->
    @if($tampilkanModalPratinjau && $pratinjauBerita)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-3xl w-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden border border-slate-100">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">Pratinjau Cepat Berita</h3>
                            <p class="text-[11px] text-slate-400">Simulasi tampilan artikel pada portal publik</p>
                        </div>
                    </div>
                    <button 
                        type="button" 
                        wire:click="tutupModalPratinjau" 
                        class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer"
                    >
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Modal Scrollable Content -->
                <div class="p-6 sm:p-8 overflow-y-auto space-y-6">
                    <div>
                        <span 
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border mb-3"
                            style="background-color: {{ $pratinjauBerita->kategori->kode_warna_hex ? $pratinjauBerita->kategori->kode_warna_hex.'15' : '#4f46e515' }}; color: {{ $pratinjauBerita->kategori->kode_warna_hex ?: '#4f46e5' }}; border-color: {{ $pratinjauBerita->kategori->kode_warna_hex ? $pratinjauBerita->kategori->kode_warna_hex.'30' : '#4f46e530' }};"
                        >
                            {{ $pratinjauBerita->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">
                            {{ $pratinjauBerita->judul }}
                        </h2>
                        <div class="flex items-center gap-3 text-xs text-slate-400 font-medium mt-3">
                            <span class="font-bold text-slate-700">Oleh: {{ $pratinjauBerita->penulis->nama_lengkap ?? 'Redaksi' }}</span>
                            <span>•</span>
                            <span>{{ \Carbon\Carbon::parse($pratinjauBerita->tanggal_publikasi ?? $pratinjauBerita->dibuat_pada)->translatedFormat('d F Y') }}</span>
                            <span>•</span>
                            <span class="flex items-center gap-1"><i data-lucide="eye" class="w-3.5 h-3.5"></i> {{ number_format($pratinjauBerita->jumlah_dilihat) }} pembaca</span>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-2xs">
                        <img 
                            src="{{ $pratinjauBerita->gambar_url }}" 
                            class="w-full max-h-96 object-cover" 
                            alt="{{ $pratinjauBerita->judul }}"
                        >
                        @if($pratinjauBerita->keterangan_gambar)
                            <p class="p-3 text-[11px] text-slate-500 italic text-center bg-slate-50 border-t border-slate-100">{{ $pratinjauBerita->keterangan_gambar }}</p>
                        @endif
                    </div>

                    <!-- Excerpt -->
                    <div class="p-4 rounded-2xl bg-indigo-50/70 border-l-4 border-indigo-600 text-slate-800 text-xs sm:text-sm font-semibold leading-relaxed">
                        {{ $pratinjauBerita->ringkasan }}
                    </div>

                    <!-- Content -->
                    <div class="prose prose-slate max-w-none text-xs sm:text-sm leading-relaxed text-slate-800 whitespace-pre-line">
                        {{ $pratinjauBerita->isi_konten }}
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <a 
                        href="{{ route('berita.detail', $pratinjauBerita->slug) }}" 
                        target="_blank" 
                        class="text-xs font-bold text-indigo-600 hover:underline flex items-center gap-1.5"
                    >
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        <span>Buka Halaman Web Lengkap</span>
                    </a>

                    <button 
                        type="button" 
                        wire:click="tutupModalPratinjau" 
                        class="px-5 py-2.5 rounded-2xl bg-slate-900 text-white font-bold text-xs uppercase tracking-wider hover:bg-slate-800 transition-colors cursor-pointer"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================= -->
    <!-- MODAL 2: TAMBAH KATEGORI BARU CEPAT                       -->
    <!-- ========================================================= -->
    @if($tampilkanModalKategori)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden border border-slate-100 p-6 sm:p-7 space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <i data-lucide="tag" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900">Tambah Kategori Baru</h3>
                            <p class="text-[11px] text-slate-400">Buat klasifikasi berita baru langsung</p>
                        </div>
                    </div>
                    <button type="button" wire:click="tutupModalTambahKategori" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form wire:submit.prevent="simpanKategoriBaru" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori *</label>
                        <input 
                            type="text" 
                            wire:model="kategoriBaruNama" 
                            placeholder="Contoh: Liputan Khusus, Pengda..." 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                        @error('kategoriBaruNama') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Warna Aksen Kategori *</label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                wire:model.live="kategoriBaruWarna" 
                                class="w-12 h-10 rounded-xl border border-slate-200 p-1 cursor-pointer bg-white"
                            >
                            <input 
                                type="text" 
                                wire:model="kategoriBaruWarna" 
                                placeholder="#4f46e5" 
                                class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-mono font-bold uppercase"
                            >
                        </div>
                        @error('kategoriBaruWarna') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button 
                            type="button" 
                            wire:click="tutupModalTambahKategori" 
                            class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer"
                        >
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- ========================================================= -->
    <!-- MODAL 3: KONFIRMASI HAPUS AMAN                            -->
    <!-- ========================================================= -->
    @if($tampilkanModalHapus)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden border border-slate-100 p-6 sm:p-7 space-y-6 text-center">
                <div class="w-14 h-14 rounded-3xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto shadow-sm">
                    <i data-lucide="alert-triangle" class="w-7 h-7"></i>
                </div>

                <div class="space-y-2">
                    <h3 class="text-lg font-black text-slate-900">Hapus Artikel Berita?</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Apakah Anda yakin ingin menghapus artikel <br>
                        <span class="font-bold text-slate-900 italic">"{{ $hapusJudul }}"</span>?
                    </p>
                    <p class="text-[11px] text-rose-600 font-medium">Data dan berkas gambar terkait akan dihapus dari sistem.</p>
                </div>

                <div class="flex items-center justify-center gap-3 pt-2">
                    <button 
                        type="button" 
                        wire:click="batalHapus" 
                        class="px-6 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                    >
                        Batalkan
                    </button>

                    <button 
                        type="button" 
                        wire:click="prosesHapus" 
                        class="px-6 py-2.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-rose-600/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        <span>Ya, Hapus Sekarang</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
