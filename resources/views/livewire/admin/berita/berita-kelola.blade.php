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

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola Berita & Publikasi"
                subtitle="Pusat manajemen konten warta, siaran pers liputan, dan dokumentasi inorga KORMI Kabupaten Bandung."
                badge="Publikasi Media • Berita & Artikel"
                icon="newspaper"
                color="indigo"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaModalTambahKategori"
                        class="inline-flex items-center justify-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-white hover:bg-slate-50 border border-slate-200/90 text-slate-700 font-bold text-xs shadow-2xs hover:shadow-xs transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="tag" class="w-3.5 h-3.5 text-indigo-600"></i>
                        <span>+ Kategori Baru</span>
                    </button>

                    <a 
                        href="{{ route('admin.berita.tambah') }}" 
                        wire:navigate
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4 transition-transform group-hover:rotate-90 duration-200"></i>
                        <span>Tulis Berita Baru</span>
                    </a>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. KPI METRIC STATS (6 Cards Symmetric Grid with Animated Shimmer Placeholder) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-2.5 sm:gap-3">
                <x-table.stats-card
                    title="Total Berita"
                    :value="number_format($totalBerita)"
                    unit="Post"
                    subtitle="Semua artikel warta"
                    icon="newspaper"
                    color="indigo"
                    :active="$kategoriDipilih === 'Semua' && $statusDipilih === 'Semua' && $unggulanDipilih === 'Semua'"
                    loading-target="resetSemuaFilter, setFilterKategori, setFilterStatus, setFilterUnggulan"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Terbit (Live)"
                    :value="number_format($totalPublished)"
                    unit="Live"
                    subtitle="Tayang di portal"
                    icon="check-circle"
                    color="emerald"
                    :active="$statusDipilih === 'published'"
                    :pulse="true"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('published')"
                />

                <x-table.stats-card
                    title="Draf Disimpan"
                    :value="number_format($totalDraft)"
                    unit="Draf"
                    subtitle="Belum publikasi"
                    icon="file-edit"
                    color="amber"
                    :active="$statusDipilih === 'draft'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('draft')"
                />

                <x-table.stats-card
                    title="Headline Utama"
                    :value="number_format($totalUnggulan)"
                    unit="Hero"
                    subtitle="Sorotan beranda"
                    icon="star"
                    color="amber"
                    :active="$unggulanDipilih === '1'"
                    loading-target="setFilterUnggulan"
                    wire:click="setFilterUnggulan('1')"
                />

                <x-table.stats-card
                    title="Kategori Aktif"
                    :value="number_format($kategoriList->count())"
                    unit="Topik"
                    subtitle="Klasifikasi konten"
                    icon="tag"
                    color="slate"
                    loading-target="bukaModalTambahKategori"
                    wire:click="bukaModalTambahKategori"
                />

                <x-table.stats-card
                    title="Total Pembaca"
                    :value="number_format($totalViews)"
                    unit="Views"
                    :subtitle="'~' . number_format($rataRataViews) . ' /post rata-rata'"
                    icon="eye"
                    color="cyan"
                    loading-target="cari, urutkan, setFilterKategori"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR (PRO REDESIGN) -->
            <x-table.filter-bar search-placeholder="Cari judul artikel, sinopsis, isi konten..." search-model="cari">
                <x-slot:top>
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-none w-full">
                        <button 
                            type="button"
                            wire:click="setFilterKategori('Semua')" 
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap shrink-0 flex items-center gap-2 {{ $kategoriDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-sm ring-1 ring-slate-900/20' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 hover:text-slate-900 border border-slate-200/70' }}"
                        >
                            <span>Semua Kategori</span>
                            <span class="px-1.5 py-0.5 rounded-md text-[10px] font-black {{ $kategoriDipilih === 'Semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalBerita }}</span>
                        </button>

                        @foreach($kategoriList as $k)
                            <button 
                                type="button"
                                wire:click="setFilterKategori('{{ $k->id }}')" 
                                class="px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $kategoriDipilih === $k->id ? 'bg-slate-900 text-white shadow-sm ring-1 ring-slate-900/20' : 'bg-slate-100 hover:bg-slate-200/80 text-slate-600 hover:text-slate-900 border border-slate-200/70' }}"
                            >
                                <span class="w-2 h-2 rounded-full shrink-0 ring-1 ring-white/60" style="background-color: {{ $k->kode_warna_hex ?: '#4f46e5' }}"></span>
                                <span>{{ $k->nama_kategori }}</span>
                                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-black {{ $kategoriDipilih === $k->id ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $k->berita_count }}</span>
                            </button>
                        @endforeach
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <div class="flex items-center gap-2 w-full lg:w-auto flex-wrap sm:flex-nowrap">
                        <!-- Status Filter -->
                        <select wire:model.live="statusDipilih" class="h-10 px-3 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer shadow-2xs">
                            <option value="Semua">Semua Status</option>
                            <option value="published">Status: Published</option>
                            <option value="draft">Status: Draft</option>
                            <option value="archived">Status: Archived</option>
                        </select>

                        <!-- Featured Filter -->
                        <select wire:model.live="unggulanDipilih" class="h-10 px-3 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer shadow-2xs">
                            <option value="Semua">Semua Sorotan</option>
                            <option value="1">⭐ Berita Utama</option>
                            <option value="0">Berita Standar</option>
                        </select>

                        <!-- Sort By -->
                        <select wire:model.live="urutkan" class="h-10 px-3 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer shadow-2xs">
                            <option value="terbaru">Urutan: Terbaru</option>
                            <option value="terlama">Urutan: Terlama</option>
                            <option value="terpopuler">Terbanyak Dilihat</option>
                            <option value="judul_asc">Judul: A - Z</option>
                        </select>

                        <!-- Per Page -->
                        <select wire:model.live="perPage" class="h-10 px-3 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer shadow-2xs">
                            <option value="10">10 / hal</option>
                            <option value="25">25 / hal</option>
                            <option value="50">50 / hal</option>
                        </select>

                        <!-- Active Filters Reset Button -->
                        @php
                            $filterAktifCount = ($statusDipilih !== 'Semua' ? 1 : 0) + ($unggulanDipilih !== 'Semua' ? 1 : 0) + ($kategoriDipilih !== 'Semua' ? 1 : 0) + ($cari ? 1 : 0) + ($urutkan !== 'terbaru' ? 1 : 0);
                        @endphp
                        @if($filterAktifCount > 0)
                            <button 
                                type="button" 
                                wire:click="resetSemuaFilter" 
                                class="h-10 px-3 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs active:scale-95 shrink-0"
                                title="Reset Semua Filter"
                            >
                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                <span>Reset</span>
                                <span class="w-4 h-4 rounded-full bg-rose-200 text-rose-800 text-[10px] font-black flex items-center justify-center">{{ $filterAktifCount }}</span>
                            </button>
                        @endif

                        <!-- View Switcher with localStorage persistence -->
                        <div 
                            x-data="{
                                mode: localStorage.getItem('kormi_datatable_view') || @js($tampilanMode),
                                setMode(val) {
                                    this.mode = val;
                                    localStorage.setItem('kormi_datatable_view', val);
                                    $wire.set('tampilanMode', val);
                                }
                            }"
                            x-init="
                                if (localStorage.getItem('kormi_datatable_view') && localStorage.getItem('kormi_datatable_view') !== @js($tampilanMode)) {
                                    $wire.set('tampilanMode', localStorage.getItem('kormi_datatable_view'));
                                }
                            "
                            class="h-10 flex items-center p-1 bg-slate-100 rounded-xl border border-slate-200 shrink-0 shadow-2xs"
                        >
                            <button 
                                type="button" 
                                @click="setMode('tabel')" 
                                :class="mode === 'tabel' ? 'bg-white text-slate-900 shadow-xs font-bold' : 'text-slate-400 hover:text-slate-700'"
                                class="h-full px-2.5 rounded-lg transition-all cursor-pointer flex items-center justify-center"
                                title="Tampilan Tabel Data"
                            >
                                <i data-lucide="list" class="w-4 h-4"></i>
                            </button>
                            <button 
                                type="button" 
                                @click="setMode('grid')" 
                                :class="mode === 'grid' ? 'bg-white text-slate-900 shadow-xs font-bold' : 'text-slate-400 hover:text-slate-700'"
                                class="h-full px-2.5 rounded-lg transition-all cursor-pointer flex items-center justify-center"
                                title="Tampilan Kartu / Grid"
                            >
                                <i data-lucide="layout-grid" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </x-slot:actions>
            </x-table.filter-bar>

            <!-- 4. FLOATING BULK ACTIONS BAR (When items selected) -->
            <x-table.bulk-bar :count="count($selectedBerita)" label="artikel dipilih" reset-action="resetSelection">
                <button 
                    type="button" 
                    wire:click="bulkPublish" 
                    class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    <span>Terbitkan</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDraft" 
                    class="px-3 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="file-edit" class="w-3.5 h-3.5"></i>
                    <span>Jadikan Draf</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkToggleUnggulan(true)" 
                    class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                    <span>Jadikan Utama</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDelete" 
                    wire:confirm="Yakin ingin menghapus {{ count($selectedBerita) }} artikel terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. DATA PRESENTATION: TABLE OR GRID -->
            @if($tampilanMode === 'tabel')
                <!-- TABLE VIEW -->
                <x-table.card>
                    <x-table.table loading-target="cari, statusDipilih, unggulanDipilih, kategoriDipilih, urutkan, perPage, gotoPage, nextPage, previousPage">
                        <x-table.thead>
                            <tr>
                                <x-table.th align="center" class="w-12 !px-4">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="pilihSemua" 
                                        class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                    >
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="judul" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Berita & Ringkasan
                                </x-table.th>
                                <x-table.th>Kategori</x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="status_publikasi" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Status & Sorotan
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="jumlah_dilihat" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Statistik
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="tanggal_publikasi" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Tanggal Rilis
                                </x-table.th>
                                <x-table.th align="right">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>
                        <x-table.tbody>
                            @forelse($beritaList as $b)
                                <x-table.tr wire:key="row-berita-{{ $b->id }}" :selected="in_array($b->id, $selectedBerita)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-3.5 w-10">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedBerita" 
                                            value="{{ $b->id }}" 
                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Thumbnail & Title (Inline Editable) -->
                                    <x-table.td>
                                        <div class="flex items-center gap-3 max-w-lg">
                                            <div class="relative shrink-0 group">
                                                <img 
                                                    src="{{ $b->gambar_url }}" 
                                                    class="w-14 h-11 sm:w-16 sm:h-12 rounded-xl object-cover border border-slate-200/80 shadow-2xs group-hover:scale-105 transition-transform" 
                                                    alt="{{ $b->judul }}"
                                                    onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=300'"
                                                >
                                                @if($b->status_unggulan)
                                                    <span class="absolute -top-1 -left-1 w-4 h-4 bg-amber-400 text-slate-900 rounded-full flex items-center justify-center text-[9px] shadow-xs" title="Berita Utama">⭐</span>
                                                @endif
                                            </div>

                                            <div class="min-w-0 flex-1 space-y-1">
                                                <!-- Editable Judul -->
                                                <x-table.editable-cell 
                                                    :model-id="$b->id" 
                                                    field="judul" 
                                                    :value="$b->judul"
                                                    placeholder="Tulis judul berita..."
                                                >
                                                    <span class="font-black text-slate-900 text-xs hover:text-indigo-600 line-clamp-1 leading-tight transition-colors block">
                                                        {{ $b->judul }}
                                                    </span>
                                                </x-table.editable-cell>

                                                <!-- Editable Ringkasan -->
                                                <x-table.editable-cell 
                                                    :model-id="$b->id" 
                                                    field="ringkasan" 
                                                    type="textarea"
                                                    :value="$b->ringkasan"
                                                    placeholder="Tambah ringkasan singkat..."
                                                >
                                                    <p class="text-[11px] text-slate-400 line-clamp-1 font-normal leading-normal">{{ $b->ringkasan ?: 'Klik untuk tambah ringkasan...' }}</p>
                                                </x-table.editable-cell>

                                                <div class="flex items-center gap-2 text-[10px] text-slate-400">
                                                    <span class="font-bold text-slate-600 truncate max-w-[120px]">{{ $b->penulis->nama_lengkap ?? 'Redaksi' }}</span>
                                                    <span>•</span>
                                                    <span class="flex items-center gap-1">
                                                        <i data-lucide="clock" class="w-3 h-3 text-slate-300"></i>
                                                        <span>{{ $b->estimasi_menit_baca }} mnt</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Category Badge (Inline Editable Select) -->
                                    <x-table.td>
                                        @php
                                            $kategoriOptions = $kategoriList->map(fn($k) => [
                                                'value' => (string) $k->id,
                                                'label' => $k->nama_kategori,
                                                'color' => $k->kode_warna_hex ?: '#4f46e5'
                                            ])->toArray();
                                        @endphp
                                        <x-table.editable-cell 
                                            :model-id="$b->id" 
                                            field="kategori_id" 
                                            type="select"
                                            :options="$kategoriOptions"
                                            :value="(string) $b->kategori_id"
                                        >
                                            <span 
                                                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border shadow-2xs whitespace-nowrap hover:scale-105 transition-all"
                                                style="background-color: {{ $b->kategori->kode_warna_hex ? $b->kategori->kode_warna_hex.'15' : '#4f46e515' }}; color: {{ $b->kategori->kode_warna_hex ?: '#4f46e5' }}; border-color: {{ $b->kategori->kode_warna_hex ? $b->kategori->kode_warna_hex.'30' : '#4f46e530' }};"
                                            >
                                                <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: {{ $b->kategori->kode_warna_hex ?: '#4f46e5' }}"></span>
                                                <span>{{ $b->kategori->nama_kategori ?? 'Umum' }}</span>
                                            </span>
                                        </x-table.editable-cell>
                                    </x-table.td>

                                    <!-- Status & Featured Toggle (Inline Editable Select & Star) -->
                                    <x-table.td>
                                        <div class="flex items-center gap-1.5">
                                            @php
                                                $statusStyle = match($b->status_publikasi) {
                                                    'published' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
                                                    'draft'     => 'bg-amber-50 text-amber-700 border-amber-200/80',
                                                    'archived'  => 'bg-slate-100 text-slate-700 border-slate-200',
                                                    default     => 'bg-slate-100 text-slate-700 border-slate-200'
                                                };
                                                $statusOptions = [
                                                    ['value' => 'published', 'label' => 'Published (Live)', 'color' => '#10b981'],
                                                    ['value' => 'draft', 'label' => 'Draft', 'color' => '#f59e0b'],
                                                    ['value' => 'archived', 'label' => 'Archived', 'color' => '#64748b'],
                                                ];
                                            @endphp

                                            <x-table.editable-cell 
                                                :model-id="$b->id" 
                                                field="status_publikasi" 
                                                type="select"
                                                :options="$statusOptions"
                                                :value="$b->status_publikasi"
                                            >
                                                <span 
                                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusStyle }} hover:scale-105 transition-all whitespace-nowrap inline-block"
                                                >
                                                    {{ $b->status_publikasi }}
                                                </span>
                                            </x-table.editable-cell>
                                            
                                            <button 
                                                type="button" 
                                                wire:key="star-btn-{{ $b->id }}"
                                                wire:click="toggleUnggulan('{{ $b->id }}')" 
                                                class="p-1 rounded-lg transition-all hover:scale-110 cursor-pointer shrink-0 {{ $b->status_unggulan ? 'text-amber-500 bg-amber-50' : 'text-slate-300 hover:text-amber-400 hover:bg-slate-100' }}" 
                                                title="{{ $b->status_unggulan ? 'Hapus dari Berita Utama' : 'Jadikan Berita Utama' }}"
                                            >
                                                <i data-lucide="star" class="w-3.5 h-3.5 {{ $b->status_unggulan ? 'fill-amber-400 text-amber-500' : '' }}"></i>
                                            </button>
                                        </div>
                                    </x-table.td>

                                    <!-- Views (Inline Editable Number) -->
                                    <x-table.td class="font-extrabold text-slate-800">
                                        <x-table.editable-cell 
                                            :model-id="$b->id" 
                                            field="jumlah_dilihat" 
                                            type="number"
                                            :value="(string) $b->jumlah_dilihat"
                                            placeholder="0"
                                        >
                                            <div class="inline-flex items-center gap-1.5 text-xs text-slate-700">
                                                <i data-lucide="eye" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>{{ number_format($b->jumlah_dilihat) }}</span>
                                            </div>
                                        </x-table.editable-cell>
                                    </x-table.td>

                                    <!-- Publish Date -->
                                    <x-table.td class="text-slate-500 text-xs font-semibold whitespace-nowrap">
                                        @if($b->tanggal_publikasi)
                                            <p class="font-bold text-slate-800 text-xs">{{ \Carbon\Carbon::parse($b->tanggal_publikasi)->format('d M Y') }}</p>
                                            <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($b->tanggal_publikasi)->diffForHumans() }}</p>
                                        @else
                                            <span class="text-slate-400 italic text-[11px]">Draf belum terbit</span>
                                        @endif
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="right">
                                        <div class="flex items-center justify-end gap-1">
                                            <!-- Quick Preview Modal -->
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="info" 
                                                icon="eye" 
                                                loading-target="bukaModalPratinjau('{{ $b->id }}')"
                                                wire:click="bukaModalPratinjau('{{ $b->id }}')" 
                                                title="Pratinjau Cepat" 
                                            />

                                            <!-- View Live on Portal -->
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="default" 
                                                icon="external-link" 
                                                href="{{ route('berita.detail', $b->slug) }}" 
                                                target="_blank" 
                                                rel="noopener noreferrer"
                                                title="Buka Halaman Publik" 
                                            />

                                            <!-- Duplicate -->
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="default" 
                                                icon="copy" 
                                                loading-target="duplikatBerita('{{ $b->id }}')"
                                                wire:click="duplikatBerita('{{ $b->id }}')" 
                                                title="Duplikasi Berita" 
                                            />

                                            <!-- Edit Button -->
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="indigo" 
                                                icon="edit-3" 
                                                href="{{ route('admin.berita.edit', $b->id) }}" 
                                                wire:navigate
                                                title="Edit Berita" 
                                            />

                                            <!-- Delete Button -->
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="konfirmasiHapus('{{ $b->id }}')"
                                                wire:click="konfirmasiHapus('{{ $b->id }}')" 
                                                title="Hapus Berita" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="7" 
                                    icon="newspaper" 
                                    title="Tidak ada artikel berita ditemukan" 
                                    description="Coba sesuaikan kata kunci pencarian atau reset filter untuk menampilkan data berita lainnya."
                                    reset-action="resetSemuaFilter"
                                    reset-text="Reset Semua Filter"
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $beritaList->links() }}
                    </div>
                </x-table.card>

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
                                    <a href="{{ route('admin.berita.edit', $b->id) }}" wire:navigate class="block">
                                        <h3 class="font-black text-slate-900 text-base leading-snug line-clamp-2 hover:text-indigo-600 transition-colors">
                                            {{ $b->judul }}
                                        </h3>
                                    </a>
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
                                        rel="noopener noreferrer"
                                        class="py-2 rounded-xl bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-600 font-bold text-xs transition-colors flex items-center justify-center gap-1 cursor-pointer" 
                                        title="Halaman Web"
                                    >
                                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <a 
                                        href="{{ route('admin.berita.edit', $b->id) }}" 
                                        wire:navigate
                                        class="py-2 rounded-xl bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 font-bold text-xs transition-all flex items-center justify-center gap-1 cursor-pointer" 
                                        title="Edit"
                                    >
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </a>

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
                <x-table.card padding="p-4">
                    {{ $beritaList->links() }}
                </x-table.card>
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
