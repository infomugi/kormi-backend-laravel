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

    @if($mode === 'tabel')
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

                    <button 
                        type="button" 
                        wire:click="bukaFormTambah" 
                        class="inline-flex items-center justify-center gap-2.5 px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95"
                    >
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Tulis Berita Baru</span>
                    </button>
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
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 rounded-md"
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
                                            class="w-8 h-8 rounded-full backdrop-blur-md transition-transform active:scale-90 flex items-center justify-center shadow-xs {{ $b->status_unggulan ? 'bg-amber-400 text-slate-900' : 'bg-white/80 text-slate-400 hover:text-amber-500' }}"
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
                                        class="py-2 rounded-xl bg-slate-100 hover:bg-cyan-50 hover:text-cyan-600 text-slate-600 font-bold text-xs transition-colors flex items-center justify-center gap-1" 
                                        title="Pratinjau"
                                    >
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <a 
                                        href="{{ route('berita.detail', $b->slug) }}" 
                                        target="_blank" 
                                        class="py-2 rounded-xl bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-600 font-bold text-xs transition-colors flex items-center justify-center gap-1" 
                                        title="Halaman Web"
                                    >
                                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <button 
                                        type="button" 
                                        wire:click="bukaFormEdit('{{ $b->id }}')" 
                                        class="py-2 rounded-xl bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 font-bold text-xs transition-all flex items-center justify-center gap-1" 
                                        title="Edit"
                                    >
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </button>

                                    <button 
                                        type="button" 
                                        wire:click="konfirmasiHapus('{{ $b->id }}')" 
                                        class="py-2 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-400 font-bold text-xs transition-colors flex items-center justify-center" 
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

    @else
        <!-- ========================================================= -->
        <!-- VIEW MODE: FULL IN-PAGE EDITOR FORM                       -->
        <!-- ========================================================= -->

        <div wire:key="berita-view-form" class="space-y-6 animate-in fade-in duration-150">
            <!-- Form Top Header Bar -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer shrink-0"
                        title="Kembali ke Daftar Berita"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR EDITOR BERITA</span>
                            <span>•</span>
                            <span class="text-indigo-600 font-black">{{ $beritaId ? 'MODE EDIT' : 'BERITA BARU' }}</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                            {{ $beritaId ? 'Edit Naskah & Publikasi Berita' : 'Tulis Publikasi Berita Baru' }}
                        </h2>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                    >
                        Batal
                    </button>

                    <button 
                        type="button" 
                        wire:click="simpan" 
                        wire:loading.attr="disabled"
                        class="px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95 disabled:opacity-50"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span wire:loading.remove wire:target="simpan">{{ $beritaId ? 'Perbarui Berita' : 'Simpan & Terbitkan' }}</span>
                        <span wire:loading.flex wire:target="simpan" class="items-center gap-2">
                            <span>Menyimpan...</span>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid (8 cols main + 4 cols sidebar) -->
            <form wire:submit.prevent="simpan" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- LEFT COLUMN: MAIN CONTENT (8 cols) -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- Title & Slug Card -->
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-xs space-y-4">
                        <!-- Judul Berita -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Judul Artikel Berita <span class="text-rose-500">*</span></label>
                                <span class="text-[11px] font-bold {{ strlen($judul) > 200 ? 'text-amber-600' : 'text-slate-400' }}">{{ strlen($judul) }} / 255 karakter</span>
                            </div>
                            <input 
                                type="text" 
                                wire:model.live.debounce.300ms="judul" 
                                placeholder="Contoh: KORMI Kabupaten Bandung Siapkan 280 Duta Olahraga Desa..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-base font-extrabold focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-all placeholder:font-normal placeholder:text-slate-400"
                            >
                            @error('judul') <span class="text-xs text-rose-600 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Slug / Permalink Bar -->
                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
                            <div class="flex items-center justify-between text-xs font-bold text-slate-500">
                                <span class="flex items-center gap-1.5">
                                    <i data-lucide="link" class="w-3.5 h-3.5 text-indigo-600"></i>
                                    <span>Permalink URL:</span>
                                </span>
                                <button 
                                    type="button" 
                                    wire:click="generateSlugOtomatis" 
                                    class="text-[11px] text-indigo-600 hover:underline font-bold"
                                >
                                    Sinkronkan dari Judul
                                </button>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="text-xs font-medium text-slate-400 shrink-0 select-none">/berita/</span>
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.300ms="slug" 
                                    placeholder="slug-url-artikel" 
                                    class="flex-1 px-3 py-1.5 bg-white border border-slate-200 text-slate-800 rounded-xl text-xs font-mono font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                >
                            </div>
                            @error('slug') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Ringkasan / Sinopsis -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Ringkasan / Sinopsis Singkat <span class="text-rose-500">*</span></label>
                                <span class="text-[11px] font-bold {{ strlen($ringkasan) > 450 ? 'text-amber-600' : 'text-slate-400' }}">{{ strlen($ringkasan) }} / 500 karakter</span>
                            </div>
                            <textarea 
                                wire:model.live="ringkasan" 
                                rows="3" 
                                placeholder="Tulis sinopsis 1-2 paragraf padat sebagai cuplikan pengantar pada kartu berita dan media sosial..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-all leading-relaxed placeholder:text-slate-400"
                            ></textarea>
                            @error('ringkasan') <span class="text-xs text-rose-600 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Article Content Body with Tab Switcher -->
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-xs space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Naskah Isi Konten Lengkap <span class="text-rose-500">*</span></label>
                                <p class="text-[11px] text-slate-400 mt-0.5">Tulis naskah lengkap berita liputan, kutipan narasumber, dan informasi kegiatan.</p>
                            </div>

                            <!-- Tabs: Editor vs Live Preview -->
                            <div class="flex items-center p-1 bg-slate-100 rounded-2xl border border-slate-200/80 shrink-0">
                                <button 
                                    type="button" 
                                    wire:click="$set('tabEditor', 'editor')" 
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 {{ $tabEditor === 'editor' ? 'bg-white text-indigo-600 shadow-2xs' : 'text-slate-500 hover:text-slate-800' }}"
                                >
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    <span>Editor Teks</span>
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="$set('tabEditor', 'preview')" 
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 {{ $tabEditor === 'preview' ? 'bg-white text-indigo-600 shadow-2xs' : 'text-slate-500 hover:text-slate-800' }}"
                                >
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    <span>Pratinjau Langsung</span>
                                </button>
                            </div>
                        </div>

                        @if($tabEditor === 'editor')
                            <!-- Formatting Shortcut Tools -->
                            <div class="flex items-center gap-1.5 p-2 bg-slate-50 rounded-2xl border border-slate-200/80 text-xs text-slate-600 flex-wrap select-none" x-data="{
                                insertText(prefix, suffix = '') {
                                    const el = document.getElementById('textareaKonten');
                                    if (!el) return;
                                    const start = el.selectionStart;
                                    const end = el.selectionEnd;
                                    const text = el.value;
                                    const sel = text.substring(start, end);
                                    const replace = prefix + sel + suffix;
                                    el.value = text.substring(0, start) + replace + text.substring(end);
                                    el.focus();
                                    el.selectionStart = start + prefix.length;
                                    el.selectionEnd = end + prefix.length;
                                    $wire.set('isi_konten', el.value);
                                }
                            }">
                                <button type="button" @click="insertText('**', '**')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-bold text-xs" title="Tebal (Bold)">
                                    <span class="font-extrabold">B</span>
                                </button>
                                <button type="button" @click="insertText('*', '*')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-serif italic text-xs" title="Miring (Italic)">
                                    <span>I</span>
                                </button>
                                <button type="button" @click="insertText('## ', '\n')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-black text-xs" title="Heading 2">
                                    <span>H2</span>
                                </button>
                                <button type="button" @click="insertText('### ', '\n')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-black text-xs" title="Heading 3">
                                    <span>H3</span>
                                </button>
                                <button type="button" @click="insertText('> ', '\n')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-bold text-xs" title="Kutipan (Quote)">
                                    <span>" "</span>
                                </button>
                                <button type="button" @click="insertText('- ', '\n')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-bold text-xs" title="Bullet List">
                                    <span>• List</span>
                                </button>
                                <button type="button" @click="insertText('[Link Judul](', ')')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-bold text-xs" title="Tautan Link">
                                    <span>Link</span>
                                </button>
                                <span class="text-[10px] text-slate-400 ml-auto font-medium hidden sm:inline">Mendukung paragraf, baris baru, & Markdown format</span>
                            </div>

                            <!-- Content Textarea -->
                            <div>
                                <textarea 
                                    id="textareaKonten"
                                    wire:model.live.debounce.300ms="isi_konten" 
                                    rows="14" 
                                    placeholder="Tulis naskah lengkap berita liputan di sini. Gunakan enter untuk pemisah paragraf..." 
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-all leading-relaxed"
                                ></textarea>
                                @error('isi_konten') <span class="text-xs text-rose-600 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <!-- Word Count & Reading Time Bar -->
                            @php
                                $wordCount = str_word_count(strip_tags($isi_konten));
                                $charCount = strlen($isi_konten);
                                $estRead = max(1, (int) ceil($wordCount / 200));
                            @endphp
                            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200/80 flex items-center justify-between text-xs text-slate-500 font-medium">
                                <div class="flex items-center gap-3">
                                    <span><b>{{ number_format($wordCount) }}</b> kata</span>
                                    <span>•</span>
                                    <span><b>{{ number_format($charCount) }}</b> karakter</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-indigo-600 font-bold">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                    <span>Estimasi waktu baca: ~{{ $estRead }} menit</span>
                                </div>
                            </div>
                        @else
                            <!-- LIVE PREVIEW TAB -->
                            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 space-y-6">
                                <div class="space-y-2">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-indigo-100 text-indigo-700">
                                        {{ $kategoriList->firstWhere('id', $kategori_id)?->nama_kategori ?? 'Kategori Berita' }}
                                    </span>
                                    <h1 class="text-2xl font-black text-slate-900 leading-tight">
                                        {{ $judul ?: 'Judul Berita Belum Diisi' }}
                                    </h1>
                                    <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                                        <span>Oleh: {{ $penulisList->firstWhere('id', $penulis_id)?->nama_lengkap ?? 'Administrator' }}</span>
                                        <span>•</span>
                                        <span>{{ $tanggal_publikasi ? \Carbon\Carbon::parse($tanggal_publikasi)->translatedFormat('d F Y H:i') : now()->translatedFormat('d F Y') }}</span>
                                    </div>
                                </div>

                                <!-- Image in Preview -->
                                <div class="rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-2xs">
                                    @if($uploadGambar)
                                        <img src="{{ $uploadGambar->temporaryUrl() }}" class="w-full h-72 object-cover" alt="Preview Gambar">
                                    @elseif($gambar_utama)
                                        @php $prevUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($gambar_utama) ?? $gambar_utama @endphp
                                        <img src="{{ $prevUrl }}" class="w-full h-72 object-cover" alt="Gambar Utama">
                                    @else
                                        <div class="h-48 bg-slate-100 flex items-center justify-center text-slate-400 text-xs">
                                            <span>(Thumbnail Gambar Utama Belum Diunggah)</span>
                                        </div>
                                    @endif
                                    @if($keterangan_gambar)
                                        <p class="p-3 text-[11px] text-slate-500 italic text-center bg-slate-50 border-t border-slate-100">{{ $keterangan_gambar }}</p>
                                    @endif
                                </div>

                                <!-- Summary Callout -->
                                @if($ringkasan)
                                    <div class="p-4 rounded-2xl bg-indigo-50/70 border-l-4 border-indigo-600 text-slate-700 text-xs sm:text-sm font-semibold leading-relaxed">
                                        {{ $ringkasan }}
                                    </div>
                                @endif

                                <!-- Body content -->
                                <div class="prose prose-slate max-w-none text-xs sm:text-sm leading-relaxed text-slate-800 space-y-4 whitespace-pre-line">
                                    {{ $isi_konten ?: 'Naskah isi konten berita masih kosong...' }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- RIGHT COLUMN: METADATA, CATEGORY, MEDIA & SEO (4 cols) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- Publishing Settings Card -->
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <i data-lucide="send" class="w-4 h-4 text-indigo-600"></i>
                            <span>Pengaturan Penerbitan</span>
                        </h3>

                        <!-- Status Publikasi -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi <span class="text-rose-500">*</span></label>
                            <select wire:model="status_publikasi" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                                <option value="published">🟢 Published (Tayang Langsung)</option>
                                <option value="draft">🟡 Draft (Draf Tersimpan)</option>
                                <option value="archived">⚪ Archived (Arsip)</option>
                            </select>
                            @error('status_publikasi') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Jadwal Tanggal Terbit -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jadwal Tanggal & Waktu Rilis</label>
                            <input 
                                type="datetime-local" 
                                wire:model="tanggal_publikasi" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                            >
                            @error('tanggal_publikasi') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Penulis / Kontributor -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Penulis / Kontributor Naskah</label>
                            <select wire:model="penulis_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                                @foreach($penulisList as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_lengkap }} ({{ $p->email }})</option>
                                @endforeach
                            </select>
                            @error('penulis_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Headline / Berita Utama Toggle -->
                        <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200/80 flex items-start gap-3">
                            <input 
                                type="checkbox" 
                                id="formUnggulan" 
                                wire:model="status_unggulan" 
                                class="w-4 h-4 mt-0.5 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                            >
                            <label for="formUnggulan" class="cursor-pointer select-none">
                                <span class="block text-xs font-black text-amber-950">Jadikan Berita Utama (Headline)</span>
                                <span class="block text-[11px] text-amber-800 font-medium mt-0.5">Tampilkan sebagai hero slider pada halaman beranda portal publik.</span>
                            </label>
                        </div>
                    </div>

                    <!-- Category Selection Card -->
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="tag" class="w-4 h-4 text-indigo-600"></i>
                                <span>Kategori Berita</span>
                            </h3>
                            <button 
                                type="button" 
                                wire:click="bukaModalTambahKategori" 
                                class="text-[11px] text-indigo-600 hover:underline font-bold"
                            >
                                + Kategori Baru
                            </button>
                        </div>

                        <div>
                            <select wire:model="kategori_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoriList as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kategori }} ({{ $k->berita_count }} artikel)</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Thumbnail & Media Upload Card -->
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4 text-indigo-600"></i>
                            <span>Thumbnail & Foto Utama <span class="text-rose-500">*</span></span>
                        </h3>

                        <!-- Image Preview Box -->
                        <div class="w-full h-48 rounded-2xl overflow-hidden border-2 border-dashed {{ $uploadGambar ? 'border-emerald-400 bg-emerald-50/20' : 'border-slate-200 bg-slate-100' }} relative flex items-center justify-center group">
                            @if($uploadGambar)
                                <img src="{{ $uploadGambar->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview Gambar Baru">
                                <div class="absolute bottom-2 right-2 bg-emerald-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-xl shadow-xs">
                                    Siap Diupload
                                </div>
                            @elseif($gambar_utama)
                                @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($gambar_utama) ?? $gambar_utama @endphp
                                <img src="{{ $tmpUrl }}" class="w-full h-full object-cover" alt="Gambar Utama" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=400'">
                                <div class="absolute bottom-2 right-2 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-xl backdrop-blur-xs">
                                    Tersimpan
                                </div>
                            @else
                                <div class="text-center p-4">
                                    <div class="w-10 h-10 rounded-2xl bg-slate-200 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="image" class="w-5 h-5"></i>
                                    </div>
                                    <p class="text-xs font-bold text-slate-600">Belum ada gambar utama</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">JPG, PNG, WEBP maks. 5MB</p>
                                </div>
                            @endif
                        </div>

                        <!-- Upload Button -->
                        <div>
                            <label for="uploadGambarBerita" class="flex items-center justify-center gap-2.5 w-full px-4 py-3 bg-slate-50 hover:bg-slate-100 border-2 border-dashed {{ $uploadGambar ? 'border-emerald-400 text-emerald-700 bg-emerald-50/50' : 'border-slate-200 text-slate-600' }} rounded-2xl text-xs font-bold cursor-pointer transition-colors">
                                <i data-lucide="upload-cloud" class="w-4 h-4 text-indigo-600 shrink-0"></i>
                                <span class="truncate">{{ $uploadGambar ? $uploadGambar->getClientOriginalName() : ($beritaId ? 'Ganti File Gambar Utama' : 'Pilih File Gambar Utama') }}</span>
                            </label>
                            <input id="uploadGambarBerita" type="file" wire:model="uploadGambar" accept="image/jpeg,image/png,image/webp" class="hidden">
                            @error('uploadGambar') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            
                            @if($uploadGambar)
                                <div class="flex items-center justify-between mt-2 text-[11px] text-emerald-700 font-semibold px-1">
                                    <span>&#10003; {{ round($uploadGambar->getSize() / 1024, 1) }} KB terpilih</span>
                                    <button type="button" wire:click="$set('uploadGambar', null)" class="text-rose-600 hover:underline">Hapus</button>
                                </div>
                            @endif
                        </div>

                        <!-- Image Caption -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Keterangan / Caption Gambar</label>
                            <input 
                                type="text" 
                                wire:model="keterangan_gambar" 
                                placeholder="Contoh: Suasana pembukaan kejuaraan di Soreang..." 
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-400"
                            >
                            @error('keterangan_gambar') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Live Google SERP Preview Card -->
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-3">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <i data-lucide="search" class="w-4 h-4 text-indigo-600"></i>
                            <span>Simulasi Pratinjau Google SEO</span>
                        </h3>

                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-1 font-sans">
                            <div class="flex items-center gap-2 text-[11px] text-slate-500">
                                <span class="w-4 h-4 rounded-full bg-indigo-600 text-white text-[9px] flex items-center justify-center font-black">K</span>
                                <span class="truncate">kormi.kabupatenbandung.go.id &rsaquo; berita &rsaquo; {{ $slug ?: 'url-berita' }}</span>
                            </div>
                            <h4 class="text-sm font-bold text-blue-700 hover:underline cursor-pointer line-clamp-1">
                                {{ $judul ?: 'Judul Artikel Berita KORMI' }}
                            </h4>
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-normal">
                                {{ $ringkasan ?: 'Sinopsis cuplikan berita akan tampil di snippet mesin pencari Google...' }}
                            </p>
                        </div>
                    </div>

                </div>

                <!-- BOTTOM STICKY ACTION BAR -->
                <div class="col-span-full bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer w-full sm:w-auto"
                    >
                        Batal & Kembali
                    </button>

                    <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                        <button 
                            type="button" 
                            wire:click="$set('status_publikasi', 'draft')"
                            wire:click.prevent="simpan" 
                            wire:loading.attr="disabled"
                            class="px-6 py-3 rounded-2xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-extrabold text-xs uppercase tracking-wider transition-all cursor-pointer flex items-center gap-2"
                        >
                            <i data-lucide="file-edit" class="w-4 h-4 text-amber-600"></i>
                            <span>Simpan Sebagai Draf</span>
                        </button>

                        <button 
                            type="submit" 
                            wire:loading.attr="disabled"
                            class="px-8 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95 disabled:opacity-50"
                        >
                            <i data-lucide="check" class="w-4 h-4"></i>
                            <span wire:loading.remove wire:target="simpan">{{ $beritaId ? 'Perbarui Berita' : 'Simpan & Terbitkan' }}</span>
                            <span wire:loading.flex wire:target="simpan" class="items-center gap-2">
                                <span>Menyimpan...</span>
                            </span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    @endif

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
                    <button type="button" wire:click="tutupModalTambahKategori" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg">
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
