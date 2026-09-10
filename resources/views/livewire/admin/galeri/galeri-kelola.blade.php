<div class="space-y-6">

    <!-- FLASH NOTIFICATION -->
    @if(session()->has('pesan'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xs animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
                <span>{{ session('pesan') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1.5 rounded-lg transition-colors cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    @if($mode === 'tabel')
        <!-- ========================================== -->
        <!-- VIEW MODE: TABEL & KATALOG GALERI         -->
        <!-- ========================================== -->
        <div wire:key="galeri-view-katalog" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTIONS (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Katalog Galeri Foto & Album"
                subtitle="Kelola arsip dokumentasi visual kegiatan, event FORKAB, dan inorga KORMI Kabupaten Bandung."
                badge="Media Dokumentasi • Galeri & Album"
                icon="images"
                color="indigo"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormTambahAlbum" 
                        class="inline-flex items-center justify-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-white hover:bg-slate-50 border border-slate-200/90 text-slate-700 font-bold text-xs shadow-2xs transition-all cursor-pointer active:scale-95"
                    >
                        <i data-lucide="folder-plus" class="w-3.5 h-3.5 text-indigo-600"></i>
                        <span>+ Buat Album</span>
                    </button>

                    <button 
                        type="button" 
                        wire:click="bukaFormBulkFoto('{{ $albumDipilih }}')" 
                        class="inline-flex items-center justify-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-800 font-bold text-xs shadow-2xs transition-all cursor-pointer active:scale-95"
                    >
                        <i data-lucide="images" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>+ Unggah Banyak</span>
                    </button>

                    <button 
                        type="button" 
                        wire:click="bukaFormTambahFoto" 
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95"
                    >
                        <i data-lucide="upload" class="w-4 h-4"></i>
                        <span>Unggah Foto</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Foto"
                    :value="number_format($totalFoto)"
                    unit="File"
                    subtitle="Dokumentasi tersimpan"
                    icon="image"
                    color="indigo"
                    :active="$tabAktif === 'foto' && $albumDipilih === 'Semua'"
                    loading-target="tabAktif, resetSemuaFilter, setFilterAlbum"
                    wire:click="$set('tabAktif', 'foto'); resetSemuaFilter();"
                />

                <x-table.stats-card
                    title="Total Album"
                    :value="number_format($totalAlbum)"
                    unit="Album"
                    subtitle="Kategori acara & event"
                    icon="folder"
                    color="amber"
                    :active="$tabAktif === 'album'"
                    loading-target="tabAktif"
                    wire:click="$set('tabAktif', 'album')"
                />

                <x-table.stats-card
                    title="Album Publik"
                    :value="number_format($totalAlbumAktif)"
                    unit="Aktif"
                    subtitle="Tayang di galeri publik"
                    icon="check-circle"
                    color="emerald"
                    :pulse="true"
                    loading-target="tabAktif"
                    wire:click="$set('tabAktif', 'album')"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                :search-placeholder="$tabAktif === 'foto' ? 'Cari judul foto, keterangan dokumentasi...' : 'Cari nama album, lokasi acara...'" 
                search-model="cari"
            >
                <x-slot:top>
                    <div class="flex items-center justify-between gap-4 flex-wrap w-full">
                        <!-- Tabs (Foto vs Album) -->
                        <div class="flex items-center p-1 bg-slate-100 rounded-2xl border border-slate-200">
                            <button 
                                type="button"
                                wire:click="$set('tabAktif', 'foto')" 
                                class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer flex items-center gap-2 {{ $tabAktif === 'foto' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}"
                            >
                                <i data-lucide="image" class="w-4 h-4 {{ $tabAktif === 'foto' ? 'text-indigo-600' : '' }}"></i>
                                <span>Foto Dokumentasi ({{ $totalFoto }})</span>
                            </button>
                            <button 
                                type="button"
                                wire:click="$set('tabAktif', 'album')" 
                                class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer flex items-center gap-2 {{ $tabAktif === 'album' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}"
                            >
                                <i data-lucide="folder-archive" class="w-4 h-4 {{ $tabAktif === 'album' ? 'text-indigo-600' : '' }}"></i>
                                <span>Daftar Album ({{ $totalAlbum }})</span>
                            </button>
                        </div>

                        <!-- Album Filter Chips when on Foto tab -->
                        @if($tabAktif === 'foto')
                            <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none flex-1 max-w-full">
                                <button 
                                    type="button"
                                    wire:click="setFilterAlbum('Semua')" 
                                    class="px-3.5 py-1.5 rounded-2xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap shrink-0 flex items-center gap-1.5 {{ $albumDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                                >
                                    <span>Semua Album</span>
                                    <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $albumDipilih === 'Semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $totalFoto }}</span>
                                </button>

                                @foreach($albumList as $a)
                                    <button 
                                        type="button"
                                        wire:click="setFilterAlbum('{{ $a->id }}')" 
                                        class="px-3 py-1.5 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $albumDipilih === $a->id ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                                    >
                                        <i data-lucide="folder" class="w-3 h-3 text-indigo-500"></i>
                                        <span>{{ $a->judul_album }}</span>
                                        <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $albumDipilih === $a->id ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $a->foto_count }}</span>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    @if($tabAktif === 'foto')
                        <!-- Urutan Foto -->
                        <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                            <option value="urutan">Urutan: Posisi Grid</option>
                            <option value="created_at">Urutan: Terbaru Diunggah</option>
                            <option value="judul_foto">Urutan: Judul Foto (A-Z)</option>
                        </select>

                        <!-- Direction -->
                        <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                            <option value="asc">Menaik (ASC)</option>
                            <option value="desc">Menurun (DESC)</option>
                        </select>
                    @else
                        <!-- Filter Status Album -->
                        <select wire:model.live="albumStatusFilter" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                            <option value="semua">Semua Status Album</option>
                            <option value="publik">Publik (Aktif)</option>
                            <option value="draft">Disembunyikan</option>
                        </select>

                        <!-- Urutan Album -->
                        <select wire:model.live="albumSortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                            <option value="tanggal_kegiatan">Urutan: Tanggal Kegiatan</option>
                            <option value="judul_album">Urutan: Judul Album (A-Z)</option>
                            <option value="created_at">Urutan: Terbaru Dibuat</option>
                        </select>

                        <!-- Direction -->
                        <select wire:model.live="albumSortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                            <option value="desc">Menurun (DESC)</option>
                            <option value="asc">Menaik (ASC)</option>
                        </select>
                    @endif

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="12">12 / hal</option>
                        <option value="24">24 / hal</option>
                        <option value="48">48 / hal</option>
                    </select>

                    <!-- View Switcher with localStorage persistence -->
                    <div 
                        x-data="{
                            mode: localStorage.getItem('kormi_galeri_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_galeri_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_galeri_view') && localStorage.getItem('kormi_galeri_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_galeri_view'));
                            }
                        "
                        class="flex items-center p-1 bg-slate-100 rounded-2xl border border-slate-200 shrink-0"
                    >
                        <button 
                            type="button" 
                            @click="setMode('grid')" 
                            :class="mode === 'grid' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-400 hover:text-slate-700'"
                            class="p-1.5 rounded-xl transition-all cursor-pointer"
                            title="Tampilan Grid Kartu"
                        >
                            <i data-lucide="layout-grid" class="w-4 h-4"></i>
                        </button>
                        <button 
                            type="button" 
                            @click="setMode('tabel')" 
                            :class="mode === 'tabel' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-400 hover:text-slate-700'"
                            class="p-1.5 rounded-xl transition-all cursor-pointer"
                            title="Tampilan Datatable"
                        >
                            <i data-lucide="list" class="w-4 h-4"></i>
                        </button>
                    </div>
                </x-slot:actions>
            </x-table.filter-bar>

            <!-- 4. FLOATING BULK ACTIONS BAR -->
            @if($tabAktif === 'foto')
                <x-table.bulk-bar :count="count($selectedFoto)" label="foto dipilih" reset-action="resetSelection">
                    <button 
                        type="button" 
                        wire:click="bulkDeleteFoto" 
                        wire:confirm="Yakin ingin menghapus {{ count($selectedFoto) }} foto terpilih secara permanen?"
                        class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                    >
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                </x-table.bulk-bar>
            @else
                <x-table.bulk-bar :count="count($selectedAlbum)" label="album dipilih" reset-action="resetSelection">
                    <button 
                        type="button" 
                        wire:click="bulkDeleteAlbum" 
                        wire:confirm="Yakin ingin menghapus {{ count($selectedAlbum) }} album terpilih beserta seluruh fotonya secara permanen?"
                        class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                    >
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                </x-table.bulk-bar>
            @endif

            <!-- 5. CONTENT PRESENTATION (FOTO DOKUMENTASI) -->
            @if($tabAktif === 'foto')
                @if($tampilanMode === 'tabel')
                    <!-- TABLE VIEW FOR FOTO -->
                    <x-table.card>
                        <x-table.table loading-target="cari, albumDipilih, tabAktif, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
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
                                        sort-field="judul_foto" 
                                        :current-sort="$sortField" 
                                        :current-direction="$sortDirection"
                                    >
                                        Foto & Keterangan
                                    </x-table.th>
                                    <x-table.th>Album Acara</x-table.th>
                                    <x-table.th 
                                        sortable 
                                        sort-field="urutan" 
                                        :current-sort="$sortField" 
                                        :current-direction="$sortDirection"
                                    >
                                        Urutan Grid
                                    </x-table.th>
                                    <x-table.th>Format Grid</x-table.th>
                                    <x-table.th align="right">Aksi</x-table.th>
                                </tr>
                            </x-table.thead>
                            <x-table.tbody>
                                @forelse($fotoList as $foto)
                                    <x-table.tr wire:key="row-foto-{{ $foto->id }}" :selected="in_array($foto->id, $selectedFoto)">
                                        <!-- Checkbox -->
                                        <x-table.td align="center" class="!px-3.5 w-10">
                                            <input 
                                                type="checkbox" 
                                                wire:model.live="selectedFoto" 
                                                value="{{ $foto->id }}" 
                                                class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                            >
                                        </x-table.td>

                                        <!-- Photo & Title -->
                                        <x-table.td>
                                            <div class="flex items-center gap-3.5 max-w-lg">
                                                <div class="relative shrink-0 group">
                                                    <img 
                                                        src="{{ $foto->gambar_url ?: 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=300' }}" 
                                                        class="w-16 h-12 rounded-xl object-cover border border-slate-200/80 shadow-2xs group-hover:scale-105 transition-transform" 
                                                        alt="{{ $foto->judul_foto }}"
                                                        onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=300'"
                                                    >
                                                </div>
                                                <div class="min-w-0 space-y-0.5">
                                                    <a 
                                                        href="javascript:void(0)" 
                                                        wire:click="bukaFormEditFoto('{{ $foto->id }}')" 
                                                        class="font-black text-slate-900 text-xs hover:text-indigo-600 line-clamp-1 leading-tight transition-colors cursor-pointer"
                                                    >
                                                        {{ $foto->judul_foto }}
                                                    </a>
                                                    @if($foto->deskripsi)
                                                        <p class="text-[11px] text-slate-400 line-clamp-1 font-normal leading-normal">{{ $foto->deskripsi }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </x-table.td>

                                        <!-- Album Badge -->
                                        <x-table.td>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                                <i data-lucide="folder" class="w-3 h-3 text-indigo-600"></i>
                                                <span>{{ $foto->album->judul_album ?? 'Umum' }}</span>
                                            </span>
                                        </x-table.td>

                                        <!-- Urutan -->
                                        <x-table.td class="font-extrabold text-slate-900">
                                            #{{ $foto->urutan }}
                                        </x-table.td>

                                        <!-- Grid Type -->
                                        <x-table.td>
                                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600">
                                                {{ $foto->tipe_grid ?? 'normal' }}
                                            </span>
                                        </x-table.td>

                                        <!-- Actions -->
                                        <x-table.td align="right">
                                            <div class="flex items-center justify-end gap-1">
                                                <x-table.action-btn 
                                                    size="sm"
                                                    variant="indigo" 
                                                    icon="edit-3" 
                                                    loading-target="bukaFormEditFoto('{{ $foto->id }}')"
                                                    wire:click="bukaFormEditFoto('{{ $foto->id }}')" 
                                                    title="Edit Rincian Foto" 
                                                />

                                                <x-table.action-btn 
                                                    size="sm"
                                                    variant="danger" 
                                                    icon="trash-2" 
                                                    loading-target="hapusFoto('{{ $foto->id }}')"
                                                    wire:click="hapusFoto('{{ $foto->id }}')" 
                                                    wire:confirm="Yakin ingin menghapus foto ini dari galeri?"
                                                    title="Hapus Foto" 
                                                />
                                            </div>
                                        </x-table.td>
                                    </x-table.tr>
                                @empty
                                    <x-table.empty 
                                        colspan="6" 
                                        icon="image" 
                                        title="Belum ada foto dokumentasi" 
                                        description="Silakan unggah foto baru ke dalam album kegiatan Anda."
                                    />
                                @endforelse
                            </x-table.tbody>
                        </x-table.table>

                        @if($fotoList->hasPages())
                            <x-slot:footer>
                                <div class="px-4 py-3 flex items-center justify-between">
                                    {{ $fotoList->links() }}
                                </div>
                            </x-slot:footer>
                        @endif
                    </x-table.card>
                @else
                    <!-- GRID CARDS VIEW FOR FOTO -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                        @forelse($fotoList as $foto)
                            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all overflow-hidden flex flex-col justify-between group">
                                <!-- Image Container -->
                                <div class="relative h-48 bg-slate-100 overflow-hidden">
                                    <img 
                                        src="{{ $foto->gambar_url ?: 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=400' }}" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                        alt="{{ $foto->judul_foto }}"
                                        onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=400'"
                                    >
                                    <div class="absolute top-3 left-3">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-900/80 text-white backdrop-blur-xs shadow-xs">
                                            {{ $foto->album->judul_album ?? 'Umum' }}
                                        </span>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-white/90 text-slate-800 backdrop-blur-xs shadow-xs">
                                            #{{ $foto->urutan }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Info -->
                                <div class="p-5 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-black text-slate-900 text-sm line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $foto->judul_foto }}</h3>
                                        @if($foto->deskripsi)
                                            <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $foto->deskripsi }}</p>
                                        @endif
                                    </div>

                                    <div class="flex items-center justify-between pt-4 mt-4 border-t border-slate-100 text-xs">
                                        <span class="text-[10px] font-bold text-slate-400">Grid: {{ $foto->tipe_grid }}</span>
                                        <div class="flex items-center gap-1.5">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="indigo" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEditFoto('{{ $foto->id }}')"
                                                wire:click="bukaFormEditFoto('{{ $foto->id }}')" 
                                                title="Edit Foto" 
                                            />
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="hapusFoto('{{ $foto->id }}')"
                                                wire:click="hapusFoto('{{ $foto->id }}')" 
                                                wire:confirm="Yakin ingin menghapus foto dokumentasi ini?"
                                                title="Hapus Foto" 
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                                <i data-lucide="image" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-bold text-slate-600">Belum ada foto dokumentasi yang sesuai.</p>
                                <button type="button" wire:click="bukaFormTambahFoto" class="mt-4 px-5 py-2.5 rounded-2xl bg-indigo-600 text-white font-bold text-xs cursor-pointer">
                                    + Unggah Foto Sekarang
                                </button>
                            </div>
                        @endforelse
                    </div>

                    @if($fotoList->hasPages())
                        <div class="mt-4">
                            {{ $fotoList->links() }}
                        </div>
                    @endif
                @endif
            @else
                <!-- 6. CONTENT PRESENTATION (TAB 2: DAFTAR ALBUM) -->
                @if($tampilanMode === 'tabel')
                    <!-- DATATABLE VIEW FOR ALBUMS -->
                    <x-table.card>
                        <x-table.table loading-target="cari, tabAktif, albumSortField, albumSortDirection, albumStatusFilter, perPage, gotoPage, nextPage, previousPage">
                            <x-table.thead>
                                <tr>
                                    <x-table.th align="center" class="w-12 !px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="pilihSemuaAlbum" 
                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                        >
                                    </x-table.th>
                                    <x-table.th 
                                        sortable 
                                        sort-field="judul_album" 
                                        :current-sort="$albumSortField" 
                                        :current-direction="$albumSortDirection"
                                    >
                                        Album & Sampul
                                    </x-table.th>
                                    <x-table.th 
                                        sortable 
                                        sort-field="tanggal_kegiatan" 
                                        :current-sort="$albumSortField" 
                                        :current-direction="$albumSortDirection"
                                    >
                                        Waktu & Lokasi
                                    </x-table.th>
                                    <x-table.th align="center">Jumlah Foto</x-table.th>
                                    <x-table.th align="center">Status Publikasi</x-table.th>
                                    <x-table.th align="right">Aksi</x-table.th>
                                </tr>
                            </x-table.thead>
                            <x-table.tbody>
                                @forelse($daftarAlbum as $album)
                                    <x-table.tr wire:key="row-album-{{ $album->id }}" :selected="in_array($album->id, $selectedAlbum)">
                                        <!-- Checkbox -->
                                        <x-table.td align="center" class="!px-3.5 w-10">
                                            <input 
                                                type="checkbox" 
                                                wire:model.live="selectedAlbum" 
                                                value="{{ $album->id }}" 
                                                class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                            >
                                        </x-table.td>

                                        <!-- Album Info & Cover -->
                                        <x-table.td>
                                            <div class="flex items-center gap-3.5 max-w-md">
                                                <div class="relative shrink-0 group">
                                                    <img 
                                                        src="{{ $album->gambar_sampul_url ?: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=300' }}" 
                                                        class="w-16 h-12 rounded-xl object-cover border border-slate-200/80 shadow-2xs group-hover:scale-105 transition-transform" 
                                                        alt="{{ $album->judul_album }}"
                                                        onerror="this.src='https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=300'"
                                                    >
                                                </div>
                                                <div class="min-w-0 space-y-0.5">
                                                    <a 
                                                        href="javascript:void(0)" 
                                                        wire:click="bukaFormEditAlbum('{{ $album->id }}')" 
                                                        class="font-black text-slate-900 text-xs hover:text-indigo-600 line-clamp-1 leading-tight transition-colors cursor-pointer"
                                                    >
                                                        {{ $album->judul_album }}
                                                    </a>
                                                    @if($album->deskripsi)
                                                        <p class="text-[11px] text-slate-400 line-clamp-1 font-normal leading-normal">{{ $album->deskripsi }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </x-table.td>

                                        <!-- Date & Location -->
                                        <x-table.td>
                                            <div class="space-y-0.5 text-xs">
                                                <div class="font-bold text-slate-700 flex items-center gap-1.5">
                                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                                    <span>{{ \Carbon\Carbon::parse($album->tanggal_kegiatan)->format('d M Y') }}</span>
                                                </div>
                                                @if($album->lokasi)
                                                    <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                                        <i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i>
                                                        <span class="line-clamp-1">{{ $album->lokasi }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-table.td>

                                        <!-- Foto Count & Quick Link -->
                                        <x-table.td align="center">
                                            <button 
                                                type="button" 
                                                wire:click="$set('albumDipilih', '{{ $album->id }}'); $set('tabAktif', 'foto');"
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/80 transition-all cursor-pointer"
                                                title="Lihat foto dalam album ini"
                                            >
                                                <i data-lucide="image" class="w-3.5 h-3.5"></i>
                                                <span>{{ $album->foto_count }} Foto</span>
                                            </button>
                                        </x-table.td>

                                        <!-- Status Toggle -->
                                        <x-table.td align="center">
                                            <button 
                                                type="button" 
                                                wire:click="toggleStatusAlbum('{{ $album->id }}')" 
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer {{ $album->status_tampil ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}"
                                            >
                                                <span class="w-1.5 h-1.5 rounded-full {{ $album->status_tampil ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                                <span>{{ $album->status_tampil ? 'Publik' : 'Draft' }}</span>
                                            </button>
                                        </x-table.td>

                                        <!-- Actions -->
                                        <x-table.td align="right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button 
                                                    type="button" 
                                                    wire:click="bukaFormBulkFoto('{{ $album->id }}')" 
                                                    class="px-2.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-[11px] transition-all cursor-pointer flex items-center gap-1"
                                                    title="Unggah Banyak Foto ke Album Ini"
                                                >
                                                    <i data-lucide="upload-cloud" class="w-3.5 h-3.5"></i>
                                                    <span>+ Foto</span>
                                                </button>

                                                <x-table.action-btn 
                                                    size="sm"
                                                    variant="indigo" 
                                                    icon="edit-3" 
                                                    loading-target="bukaFormEditAlbum('{{ $album->id }}')"
                                                    wire:click="bukaFormEditAlbum('{{ $album->id }}')" 
                                                    title="Edit Album" 
                                                />

                                                <x-table.action-btn 
                                                    size="sm"
                                                    variant="danger" 
                                                    icon="trash-2" 
                                                    loading-target="hapusAlbum('{{ $album->id }}')"
                                                    wire:click="hapusAlbum('{{ $album->id }}')" 
                                                    wire:confirm="Yakin ingin menghapus album ini beserta seluruh fotonya?"
                                                    title="Hapus Album" 
                                                />
                                            </div>
                                        </x-table.td>
                                    </x-table.tr>
                                @empty
                                    <x-table.empty 
                                        colspan="6" 
                                        icon="folder-archive" 
                                        title="Belum ada album kegiatan" 
                                        description="Silakan buat album kegiatan baru untuk mengelompokkan dokumentasi foto."
                                    />
                                @endforelse
                            </x-table.tbody>
                        </x-table.table>

                        @if($daftarAlbum->hasPages())
                            <x-slot:footer>
                                <div class="px-4 py-3 flex items-center justify-between">
                                    {{ $daftarAlbum->links() }}
                                </div>
                            </x-slot:footer>
                        @endif
                    </x-table.card>
                @else
                    <!-- GRID CARDS VIEW FOR ALBUMS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($daftarAlbum as $album)
                            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-6 flex flex-col justify-between group">
                                <div>
                                    <div class="flex items-start justify-between gap-3 mb-4">
                                        <button 
                                            type="button" 
                                            wire:click="toggleStatusAlbum('{{ $album->id }}')"
                                            class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer {{ $album->status_tampil ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}"
                                        >
                                            {{ $album->status_tampil ? 'Publik' : 'Disembunyikan' }}
                                        </button>
                                        <span class="text-xs font-bold text-slate-400 flex items-center gap-1.5">
                                            <i data-lucide="image" class="w-3.5 h-3.5"></i>
                                            {{ $album->foto_count }} Foto
                                        </span>
                                    </div>

                                    <h3 class="text-base font-black text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $album->judul_album }}</h3>
                                    
                                    <div class="mt-2 space-y-1 text-xs text-slate-500 font-medium">
                                        <p class="flex items-center gap-1.5">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                            <span>{{ \Carbon\Carbon::parse($album->tanggal_kegiatan)->format('d F Y') }}</span>
                                        </p>
                                        @if($album->lokasi)
                                            <p class="flex items-center gap-1.5">
                                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                                <span>{{ $album->lokasi }}</span>
                                            </p>
                                        @endif
                                    </div>

                                    @if($album->deskripsi)
                                        <p class="text-xs text-slate-600 line-clamp-2 mt-3 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                                            {{ $album->deskripsi }}
                                        </p>
                                    @endif
                                </div>

                                <div class="pt-4 mt-6 border-t border-slate-100 flex items-center justify-between">
                                    <button 
                                        type="button" 
                                        wire:click="$set('albumDipilih', '{{ $album->id }}'); $set('tabAktif', 'foto');" 
                                        class="text-xs font-bold text-indigo-600 hover:underline flex items-center gap-1 cursor-pointer"
                                    >
                                        <span>Buka Foto</span>
                                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <div class="flex items-center gap-1.5">
                                        <button 
                                            type="button" 
                                            wire:click="bukaFormBulkFoto('{{ $album->id }}')" 
                                            class="px-2.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-[11px] transition-all cursor-pointer flex items-center gap-1"
                                            title="Unggah Banyak Foto ke Album Ini"
                                        >
                                            <i data-lucide="upload-cloud" class="w-3.5 h-3.5"></i>
                                            <span>+ Foto</span>
                                        </button>

                                        <x-table.action-btn 
                                            size="sm"
                                            variant="indigo" 
                                            icon="edit-3" 
                                            loading-target="bukaFormEditAlbum('{{ $album->id }}')"
                                            wire:click="bukaFormEditAlbum('{{ $album->id }}')" 
                                            title="Edit Album" 
                                        />
                                        <x-table.action-btn 
                                            size="sm"
                                            variant="danger" 
                                            icon="trash-2" 
                                            loading-target="hapusAlbum('{{ $album->id }}')"
                                            wire:click="hapusAlbum('{{ $album->id }}')" 
                                            wire:confirm="Yakin ingin menghapus album ini beserta seluruh fotonya?"
                                            title="Hapus Album" 
                                        />
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                                <i data-lucide="folder-archive" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-bold text-slate-600">Belum ada album kegiatan ditemukan.</p>
                                <button type="button" wire:click="bukaFormTambahAlbum" class="mt-4 px-5 py-2.5 rounded-2xl bg-slate-900 text-white font-bold text-xs cursor-pointer">
                                    + Buat Album Sekarang
                                </button>
                            </div>
                        @endforelse
                    </div>

                    @if($daftarAlbum->hasPages())
                        <div class="mt-4">
                            {{ $daftarAlbum->links() }}
                        </div>
                    @endif
                @endif
            @endif
        </div>

    @elseif($mode === 'form_foto')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE PHOTO FORM (UI KIT)     -->
        <!-- ========================================== -->
        <div class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header 
                :title="$editFotoId ? 'Edit Rincian Foto Galeri' : 'Unggah Foto Dokumentasi Baru'"
                subtitle="Isi judul foto, pilih album kegiatan terkait, tentukan posisi urutan & tata letak grid."
                :badge="$editFotoId ? 'Mode Edit Foto' : 'Foto Baru'"
                icon="image"
            >
                <x-slot:actions>
                    <x-form.button 
                        variant="ghost" 
                        size="default" 
                        icon="arrow-left" 
                        wire:click="kembaliKeTabel"
                    >
                        Batal
                    </x-form.button>
                    <x-form.button 
                        variant="primary" 
                        size="default" 
                        icon="check" 
                        loading-target="simpanFoto"
                        wire:click="simpanFoto"
                    >
                        {{ $editFotoId ? 'Perbarui Foto' : 'Simpan Foto' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT -->
            <form wire:submit.prevent="simpanFoto" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (7 cols): Metadata -->
                    <div class="lg:col-span-7 space-y-6">
                        <x-form.card 
                            title="Informasi & Rincian Foto" 
                            subtitle="Klasifikasi album, judul dokumentasi, dan pengaturan grid."
                            icon="file-text"
                            size="default"
                        >
                            <!-- Album -->
                            <x-form.field label="Album Acara / Kegiatan" name="album_id" :required="true">
                                <x-form.select name="album_id" wire:model="album_id">
                                    @foreach($albumList as $a)
                                        <option value="{{ $a->id }}">{{ $a->judul_album }}</option>
                                    @endforeach
                                </x-form.select>
                            </x-form.field>

                            <!-- Judul Foto -->
                            <x-form.field label="Judul Foto / Keterangan Singkat" name="judul_foto" :required="true">
                                <x-form.input 
                                    name="judul_foto" 
                                    wire:model="judul_foto" 
                                    placeholder="Contoh: Pembukaan FORKAB Kabupaten Bandung 2026..." 
                                    size="lg"
                                    icon="type"
                                />
                            </x-form.field>

                            <!-- Layout Grid & Urutan -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Format Ukuran Grid" name="tipe_grid">
                                    <x-form.select name="tipe_grid" wire:model="tipe_grid">
                                        <option value="normal">Ukuran Normal (1x1)</option>
                                        <option value="col-span-2">Lebar Horizontal (2x1)</option>
                                        <option value="col-span-2 row-span-2">Kotak Besar (2x2)</option>
                                    </x-form.select>
                                </x-form.field>

                                <x-form.field label="Nomor Urutan Tampil" name="urutan_foto" :required="true">
                                    <x-form.input 
                                        type="number"
                                        name="urutan_foto" 
                                        wire:model="urutan_foto" 
                                        min="1"
                                        icon="hash"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Deskripsi -->
                            <x-form.field label="Deskripsi / Catatan Tambahan (Opsional)" name="deskripsi_foto">
                                <x-form.textarea 
                                    name="deskripsi_foto" 
                                    wire:model="deskripsi_foto" 
                                    placeholder="Tuliskan catatan atau deskripsi momen kegiatan..."
                                    rows="4"
                                />
                            </x-form.field>
                        </x-form.card>
                    </div>

                    <!-- Right Column (5 cols): Photo Upload & Storage -->
                    <div class="lg:col-span-5 space-y-6">
                        <x-form.card 
                            title="File Foto Dokumentasi" 
                            subtitle="Format JPG, PNG, atau WEBP resolusi tinggi."
                            icon="image"
                            size="default"
                        >
                            <x-form.image-upload 
                                :upload="$uploadFoto" 
                                :savedPath="$gambar_url" 
                                name="uploadFoto"
                                inputId="uploadFotoGaleri"
                                accept="image/jpeg,image/png,image/webp"
                                :maxSizeMB="10"
                                emptyTitle="Pilih Foto Dokumentasi"
                                emptySubtitle="JPG, PNG, WEBP (Maksimal 10MB)"
                                aspectRatio="h-64 sm:h-72"
                            />
                        </x-form.card>
                    </div>
                </div>

                <!-- 3. ACTION BAR FOOTER -->
                <x-form.action-bar 
                    cancel-text="Batal & Kembali" 
                    cancel-action="kembaliKeTabel" 
                    :submit-text="$editFotoId ? 'Perbarui Foto' : 'Simpan Foto ke Galeri'" 
                    loading-target="simpanFoto" 
                />
            </form>
        </div>

    @elseif($mode === 'form_album')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE ALBUM FORM (UI KIT)    -->
        <!-- ========================================== -->
        <div class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header 
                :title="$editAlbumId ? 'Edit Rincian Album Kegiatan' : 'Buat Album Kegiatan Baru'"
                subtitle="Kelola wadah arsip kegiatan, tanggal pelaksanaan, lokasi, dan status tayang publik."
                :badge="$editAlbumId ? 'Mode Edit Album' : 'Album Baru'"
                icon="folder"
            >
                <x-slot:actions>
                    <x-form.button 
                        variant="ghost" 
                        size="default" 
                        icon="arrow-left" 
                        wire:click="kembaliKeTabel"
                    >
                        Batal
                    </x-form.button>
                    <x-form.button 
                        variant="primary" 
                        size="default" 
                        icon="check" 
                        loading-target="simpanAlbum"
                        wire:click="simpanAlbum"
                    >
                        {{ $editAlbumId ? 'Perbarui Album' : 'Simpan Album' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT -->
            <form wire:submit.prevent="simpanAlbum" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (7 cols): Album Metadata -->
                    <div class="lg:col-span-7 space-y-6">
                        <x-form.card 
                            title="Informasi Album Acara" 
                            subtitle="Nama album, jadwal pelaksanaan, lokasi, serta keterbukaan publik."
                            icon="folder-open"
                            size="default"
                        >
                            <!-- Nama Album -->
                            <x-form.field label="Nama / Judul Album Kegiatan" name="judul_album" :required="true">
                                <x-form.input 
                                    name="judul_album" 
                                    wire:model="judul_album" 
                                    placeholder="Contoh: Festival Olahraga Rekreasi Kabupaten (FORKAB) 2026..." 
                                    size="lg"
                                    icon="folder"
                                />
                            </x-form.field>

                            <!-- Tanggal & Lokasi -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Tanggal Pelaksanaan" name="tanggal_kegiatan">
                                    <x-form.input 
                                        type="date"
                                        name="tanggal_kegiatan" 
                                        wire:model="tanggal_kegiatan" 
                                        icon="calendar"
                                    />
                                </x-form.field>

                                <x-form.field label="Lokasi / Tempat Acara" name="lokasi">
                                    <x-form.input 
                                        type="text"
                                        name="lokasi" 
                                        wire:model="lokasi" 
                                        placeholder="Contoh: Stadion Si Jalak Harupat"
                                        icon="map-pin"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Deskripsi Album -->
                            <x-form.field label="Deskripsi / Keterangan Album (Opsional)" name="deskripsi_album">
                                <x-form.textarea 
                                    name="deskripsi_album" 
                                    wire:model="deskripsi_album" 
                                    placeholder="Keterangan singkat seputar pelaksanaan event dokumentasi..."
                                    rows="3"
                                />
                            </x-form.field>

                            <!-- Status Tampil Switch -->
                            <x-form.field label="Status Akses Publik" name="status_tampil">
                                <div class="h-[46px] px-4 bg-slate-50/80 border border-slate-200 rounded-2xl flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-700">Tampilkan Album di Portal Publik</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="statusTampilAlbum" wire:model="status_tampil" class="sr-only peer">
                                        <div class="w-10 h-5.5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4.5 after:w-4.5 after:transition-all peer-checked:bg-emerald-600"></div>
                                    </label>
                                </div>
                            </x-form.field>
                        </x-form.card>
                    </div>

                    <!-- Right Column (5 cols): Cover Upload & Bulk Photo Upload -->
                    <div class="lg:col-span-5 space-y-6">
                        <x-form.card 
                            title="Sampul Depan Album" 
                            subtitle="Foto utama yang mewakili album di portal publik."
                            icon="image"
                            size="default"
                        >
                            <x-form.image-upload 
                                :upload="$uploadSampul" 
                                :savedPath="$gambar_sampul" 
                                name="uploadSampul"
                                inputId="uploadSampulAlbum"
                                accept="image/jpeg,image/png,image/webp"
                                :maxSizeMB="10"
                                emptyTitle="Pilih Foto Sampul Album"
                                emptySubtitle="JPG, PNG, WEBP (Maksimal 10MB)"
                                aspectRatio="h-44 sm:h-52"
                            />
                        </x-form.card>

                        <!-- Sekaligus Tambah Banyak Foto ke Album -->
                        <x-form.card 
                            title="Unggah Sekaligus Foto Album" 
                            subtitle="Pilih banyak foto kegiatan sekaligus untuk langsung dimasukkan ke album ini."
                            icon="images"
                            size="default"
                        >
                            <div 
                                x-data="{
                                    isDragging: false,
                                    handleFiles(files) {
                                        if (!files || files.length === 0) return;
                                        @this.uploadMultiple('uploadAlbumBulkFoto', files, () => {
                                            this.isDragging = false;
                                        }, () => {
                                            this.isDragging = false;
                                        });
                                    }
                                }"
                                class="space-y-4"
                            >
                                <div 
                                    @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false"
                                    @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
                                    @click="$refs.albumBulkInput.click()"
                                    class="w-full p-6 rounded-2xl border-2 border-dashed transition-all duration-200 relative flex flex-col items-center justify-center cursor-pointer group select-none text-center"
                                    :class="isDragging ? 'border-emerald-500 bg-emerald-50/70 ring-4 ring-emerald-500/10' : 'border-slate-200/90 bg-slate-50/60 hover:bg-slate-100/70 hover:border-emerald-400'"
                                >
                                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-emerald-600 flex items-center justify-center mx-auto mb-2 shadow-2xs group-hover:scale-110 transition-transform">
                                        <i data-lucide="folder-up" class="w-5 h-5"></i>
                                    </div>
                                    <p class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 transition-colors">
                                        Klik untuk Pilih Banyak Foto Sekaligus
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Mendukung multi-select (JPG, PNG, WEBP)</p>
                                </div>

                                <input 
                                    x-ref="albumBulkInput" 
                                    id="uploadAlbumBulkFotoInput" 
                                    type="file" 
                                    multiple 
                                    accept="image/jpeg,image/png,image/webp" 
                                    @change="handleFiles($event.target.files)"
                                    class="hidden"
                                >

                                @error('uploadAlbumBulkFoto')
                                    <span class="text-xs text-rose-600 font-bold block">{{ $message }}</span>
                                @enderror

                                @if(!empty($uploadAlbumBulkFoto))
                                    <div class="space-y-2 pt-2">
                                        <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                                            <span>{{ count($uploadAlbumBulkFoto) }} Foto Siap Diunggah:</span>
                                            <button 
                                                type="button" 
                                                wire:click="$set('uploadAlbumBulkFoto', [])" 
                                                class="text-[11px] text-rose-600 hover:underline cursor-pointer"
                                            >
                                                Hapus Semua
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-4 sm:grid-cols-5 gap-2 max-h-48 overflow-y-auto p-1.5 bg-slate-50 rounded-2xl border border-slate-100">
                                            @foreach($uploadAlbumBulkFoto as $idx => $photo)
                                                <div class="relative group aspect-square rounded-xl overflow-hidden border border-slate-200 bg-white">
                                                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover" alt="Foto">
                                                    <button 
                                                        type="button" 
                                                        wire:click="hapusFileAlbumBulkUpload({{ $idx }})" 
                                                        class="absolute top-1 right-1 w-5 h-5 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-xs cursor-pointer"
                                                        title="Hapus foto ini"
                                                    >
                                                        <i data-lucide="x" class="w-3 h-3"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </x-form.card>
                    </div>
                </div>

                <!-- 3. ACTION BAR FOOTER -->
                <x-form.action-bar 
                    cancel-text="Batal & Kembali" 
                    cancel-action="kembaliKeTabel" 
                    :submit-text="$editAlbumId ? 'Perbarui Album' : 'Simpan Album Baru'" 
                    loading-target="simpanAlbum" 
                />
            </form>
        </div>

    @elseif($mode === 'form_bulk_foto')
        <!-- ========================================== -->
        <!-- VIEW MODE: BULK UPLOAD PHOTOS TO ALBUM     -->
        <!-- ========================================== -->
        <div class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header 
                title="Unggah Banyak Foto ke Album Sekaligus"
                subtitle="Pilih album tujuan, beri judul dasar (opsional), lalu seret atau pilih puluhan foto sekaligus."
                badge="Multi-Upload Galeri"
                icon="images"
            >
                <x-slot:actions>
                    <x-form.button 
                        variant="ghost" 
                        size="default" 
                        icon="arrow-left" 
                        wire:click="kembaliKeTabel"
                    >
                        Batal
                    </x-form.button>
                    <x-form.button 
                        variant="primary" 
                        size="default" 
                        icon="upload-cloud" 
                        loading-target="simpanBulkFoto"
                        wire:click="simpanBulkFoto"
                    >
                        Unggah Semua Foto ({{ count($uploadBulkFoto) }})
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT -->
            <form wire:submit.prevent="simpanBulkFoto" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (5 cols): Metadata -->
                    <div class="lg:col-span-5 space-y-6">
                        <x-form.card 
                            title="Tujuan Album & Penamaan" 
                            subtitle="Tentukan album target dan format judul otomatis foto."
                            icon="folder-check"
                            size="default"
                        >
                            <!-- Pilih Album -->
                            <x-form.field label="Pilih Album Kegiatan Target" name="bulk_album_id" :required="true">
                                <x-form.select name="bulk_album_id" wire:model="bulk_album_id">
                                    <option value="">-- Pilih Album --</option>
                                    @foreach($albumList as $a)
                                        <option value="{{ $a->id }}">{{ $a->judul_album }} ({{ $a->foto_count }} Foto)</option>
                                    @endforeach
                                </x-form.select>
                            </x-form.field>

                            <!-- Prefix Judul Foto -->
                            <x-form.field label="Awalan / Prefix Judul Foto (Opsional)" name="bulk_judul_prefix">
                                <x-form.input 
                                    name="bulk_judul_prefix" 
                                    wire:model="bulk_judul_prefix" 
                                    placeholder="Contoh: Senam Massal FORKAB" 
                                    icon="type"
                                />
                                <p class="text-[11px] text-slate-400 mt-1 font-medium">
                                    Jika diisi, foto akan otomatis diberi nomor: <em>"{{ $bulk_judul_prefix ?: 'Dokumentasi' }} 01", "02", dst</em>. Jika kosong, akan menggunakan nama asli file.
                                </p>
                            </x-form.field>

                            <!-- Deskripsi Bersama -->
                            <x-form.field label="Deskripsi Bersama untuk Semua Foto (Opsional)" name="bulk_deskripsi">
                                <x-form.textarea 
                                    name="bulk_deskripsi" 
                                    wire:model="bulk_deskripsi" 
                                    placeholder="Catatan atau keterangan yang berlaku untuk seluruh foto ini..."
                                    rows="3"
                                />
                            </x-form.field>
                        </x-form.card>
                    </div>

                    <!-- Right Column (7 cols): Multi-File Upload Dropzone & Grid Preview -->
                    <div class="lg:col-span-7 space-y-6">
                        <x-form.card 
                            title="Pilih Berkas Foto (Multi-File)" 
                            subtitle="Maksimal 10MB per foto. Format yang didukung: JPG, PNG, WEBP."
                            icon="upload-cloud"
                            size="default"
                        >
                            <div 
                                x-data="{
                                    isDragging: false,
                                    handleFiles(files) {
                                        if (!files || files.length === 0) return;
                                        @this.uploadMultiple('uploadBulkFoto', files, () => {
                                            this.isDragging = false;
                                        }, () => {
                                            this.isDragging = false;
                                        });
                                    }
                                }"
                                class="space-y-5"
                            >
                                <!-- Multi-Upload Dropzone Area -->
                                <div 
                                    @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false"
                                    @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
                                    @click="$refs.bulkFileInput.click()"
                                    class="w-full p-8 sm:p-10 rounded-2xl border-2 border-dashed transition-all duration-200 relative flex flex-col items-center justify-center cursor-pointer group select-none text-center"
                                    :class="isDragging ? 'border-emerald-500 bg-emerald-50/70 scale-[0.99] ring-4 ring-emerald-500/10' : '{{ !empty($uploadBulkFoto) ? 'border-emerald-500 bg-emerald-50/20' : 'border-slate-200/90 bg-slate-50/60 hover:bg-slate-100/70 hover:border-emerald-400/80' }}'"
                                >
                                    <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 text-emerald-600 flex items-center justify-center mx-auto mb-3 shadow-2xs group-hover:scale-110 transition-transform">
                                        <i data-lucide="cloud-upload" class="w-6 h-6"></i>
                                    </div>
                                    <h4 class="text-sm font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                                        Seret & Lepaskan Banyak Foto di Sini, atau Klik untuk Memilih
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-1 max-w-sm">
                                        Anda dapat menahan tombol <kbd class="px-1.5 py-0.5 rounded bg-slate-200 text-slate-700 text-[10px] font-mono">Ctrl</kbd> atau <kbd class="px-1.5 py-0.5 rounded bg-slate-200 text-slate-700 text-[10px] font-mono">Shift</kbd> untuk memilih banyak foto sekaligus di jendela file.
                                    </p>
                                </div>

                                <input 
                                    x-ref="bulkFileInput" 
                                    id="uploadBulkFotoInput" 
                                    type="file" 
                                    multiple 
                                    accept="image/jpeg,image/png,image/webp" 
                                    @change="handleFiles($event.target.files)"
                                    class="hidden"
                                >

                                @error('uploadBulkFoto')
                                    <span class="text-xs text-rose-600 font-bold block flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                        <span>{{ $message }}</span>
                                    </span>
                                @enderror

                                @error('uploadBulkFoto.*')
                                    <span class="text-xs text-rose-600 font-bold block flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                        <span>{{ $message }}</span>
                                    </span>
                                @enderror

                                <!-- Preview Grid of Uploaded Photos -->
                                @if(!empty($uploadBulkFoto))
                                    <div class="space-y-3 pt-2">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-black text-slate-900">Total Terpilih:</span>
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                                                    {{ count($uploadBulkFoto) }} Foto
                                                </span>
                                            </div>
                                            <button 
                                                type="button" 
                                                wire:click="$set('uploadBulkFoto', [])" 
                                                class="text-xs text-rose-600 hover:text-rose-800 font-bold hover:underline cursor-pointer flex items-center gap-1"
                                            >
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                <span>Bersihkan Semua</span>
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 max-h-96 overflow-y-auto p-2 bg-slate-50/80 rounded-2xl border border-slate-100">
                                            @foreach($uploadBulkFoto as $idx => $photo)
                                                <div class="relative group aspect-square rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-2xs">
                                                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                                                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-2">
                                                        <button 
                                                            type="button" 
                                                            wire:click="hapusFileBulkUpload({{ $idx }})" 
                                                            class="p-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white shadow-md transition-all cursor-pointer"
                                                            title="Hapus foto ini"
                                                        >
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                    </div>
                                                    <div class="absolute bottom-1.5 left-1.5 right-1.5 bg-slate-900/80 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-md truncate backdrop-blur-xs">
                                                        #{{ $idx + 1 }} {{ $photo->getClientOriginalName() }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </x-form.card>
                    </div>
                </div>

                <!-- 3. ACTION BAR FOOTER -->
                <x-form.action-bar 
                    cancel-text="Batal & Kembali" 
                    cancel-action="kembaliKeTabel" 
                    :submit-text="'Unggah ' . (count($uploadBulkFoto) > 0 ? count($uploadBulkFoto) . ' Foto ke Album' : 'Foto')" 
                    loading-target="simpanBulkFoto" 
                />
            </form>
        </div>
    @endif
</div>
