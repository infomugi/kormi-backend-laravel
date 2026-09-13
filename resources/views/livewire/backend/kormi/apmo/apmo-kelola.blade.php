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
        <!-- VIEW MODE: TABEL & KATALOG APMO            -->
        <!-- ========================================== -->
        <div wire:key="apmo-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTIONS (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola Anugerah Penggerak Olahraga (APMO)"
                subtitle="Penganugerahan tahunan kepada tokoh, inorga, penggerak desa, pelatih, dan pegiat olahraga masyarakat berprestasi di Kabupaten Bandung."
                badge="Anugerah & Apresiasi • APMO KORMI"
                icon="heart-pulse"
                color="rose"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormEdisiTambah"
                        class="inline-flex items-center justify-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-white hover:bg-slate-50 border border-slate-200/90 text-slate-700 font-bold text-xs shadow-2xs hover:shadow-xs transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="calendar-plus" class="w-3.5 h-3.5 text-rose-600"></i>
                        <span>Buat Edisi Tahun</span>
                    </button>

                    <button 
                        type="button" 
                        wire:click="bukaFormPenerimaTambah"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-rose-600 via-rose-600 to-pink-600 hover:from-rose-500 hover:to-pink-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-rose-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="trophy" class="w-4 h-4 transition-transform group-hover:rotate-12 duration-200"></i>
                        <span>Tambah Penerima Anugerah</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Penerima"
                    :value="number_format($totalPenerima)"
                    unit="Tokoh"
                    subtitle="Insan olahraga berprestasi"
                    icon="award"
                    color="amber"
                    :active="$tabAktif === 'penerima' && $tahunDipilih === 'Semua' && $kategoriFilter === 'Semua'"
                    loading-target="resetSemuaFilter, setFilterKategori"
                    wire:click="$set('tabAktif', 'penerima')"
                />

                <x-table.stats-card
                    title="Edisi Penyelenggaraan"
                    :value="number_format($totalEdisi)"
                    unit="Edisi"
                    subtitle="Tahun penganugerahan"
                    icon="calendar"
                    color="indigo"
                    :active="$tabAktif === 'edisi'"
                    wire:click="$set('tabAktif', 'edisi')"
                />

                <x-table.stats-card
                    title="Edisi Terbaru"
                    :value="(string) ($edisiTerbaru->tahun ?? date('Y'))"
                    unit="Tahun"
                    subtitle="{{ $edisiTerbaru->tema_acara ?? 'Bedas Juara' }}"
                    icon="sparkles"
                    color="emerald"
                    :pulse="true"
                    wire:click="$set('tabAktif', 'edisi')"
                />

                <x-table.stats-card
                    title="Kategori Penghargaan"
                    value="6"
                    unit="Bidang"
                    subtitle="Klasifikasi anugerah"
                    icon="layers"
                    color="purple"
                    wire:click="$set('tabAktif', 'penerima')"
                />
            </div>

            <!-- 3. TAB SWITCHER -->
            <div class="bg-white border border-slate-200/80 p-1.5 rounded-2xl shadow-2xs flex items-center gap-2 w-fit">
                <button 
                    type="button"
                    wire:click="$set('tabAktif', 'penerima')" 
                    class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer flex items-center gap-2 {{ $tabAktif === 'penerima' ? 'bg-amber-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100' }}"
                >
                    <i data-lucide="trophy" class="w-4 h-4"></i>
                    <span>Daftar Penerima Anugerah ({{ $totalPenerima }})</span>
                </button>
                <button 
                    type="button"
                    wire:click="$set('tabAktif', 'edisi')" 
                    class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer flex items-center gap-2 {{ $tabAktif === 'edisi' ? 'bg-amber-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100' }}"
                >
                    <i data-lucide="calendar-range" class="w-4 h-4"></i>
                    <span>Edisi & Tema Acara ({{ $totalEdisi }})</span>
                </button>
            </div>

            <!-- 4. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                :search-placeholder="$tabAktif === 'penerima' ? 'Cari nama penerima, asal wilayah, deskripsi...' : 'Cari tahun, tema acara, tempat...'" 
                search-model="cari"
            >
                @if($tabAktif === 'penerima')
                    <x-slot:top>
                        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                            @foreach(['Semua', 'Tokoh Olahraga Rekreasi', 'Penggerak Olahraga Desa', 'Inorga Teraktif & Berprestasi', 'Pelatih / Instruktur Berdedikasi', 'Tokoh Pelestari Olahraga Tradisional', 'Mitra Kerja Pendukung KORMI'] as $kat)
                                <button 
                                    type="button"
                                    wire:click="setFilterKategori('{{ $kat }}')" 
                                    class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $kategoriFilter === $kat ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                                >
                                    <span>{{ $kat }}</span>
                                </button>
                            @endforeach
                        </div>
                    </x-slot:top>
                @endif

                <x-slot:actions>
                    @if($tabAktif === 'penerima')
                        <!-- Edisi Tahun Filter -->
                        <select wire:model.live="tahunDipilih" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                            <option value="Semua">Semua Edisi Tahun</option>
                            @foreach($semuaEdisi as $ed)
                                <option value="{{ $ed->tahun }}">Tahun {{ $ed->tahun }}</option>
                            @endforeach
                        </select>
                    @endif

                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        @if($tabAktif === 'penerima')
                            <option value="urutan">Urutan: Posisi / Ranking</option>
                            <option value="nama_penerima">Urutan: Nama Penerima</option>
                            <option value="kategori_penghargaan">Urutan: Kategori</option>
                        @else
                            <option value="tahun">Urutan: Tahun Edisi</option>
                            <option value="tanggal_penganugerahan">Urutan: Tanggal Acara</option>
                        @endif
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="asc">A-Z / Naik (ASC)</option>
                        <option value="desc">Z-A / Turun (DESC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="9">9 / hal</option>
                        <option value="18">18 / hal</option>
                        <option value="36">36 / hal</option>
                    </select>

                    @if($tabAktif === 'penerima')
                        <!-- View Switcher for Penerima -->
                        <div 
                            x-data="{
                                mode: localStorage.getItem('kormi_apmo_view') || @js($tampilanMode),
                                setMode(val) {
                                    this.mode = val;
                                    localStorage.setItem('kormi_apmo_view', val);
                                    $wire.set('tampilanMode', val);
                                }
                            }"
                            x-init="
                                if (localStorage.getItem('kormi_apmo_view') && localStorage.getItem('kormi_apmo_view') !== @js($tampilanMode)) {
                                    $wire.set('tampilanMode', localStorage.getItem('kormi_apmo_view'));
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
                    @endif
                </x-slot:actions>
            </x-table.filter-bar>

            <!-- 5. FLOATING BULK ACTIONS BAR -->
            @if($tabAktif === 'penerima')
                <x-table.bulk-bar :count="count($selectedPenerima)" label="Penerima dipilih" reset-action="resetSelectionPenerima">
                    <button 
                        type="button" 
                        wire:click="bulkDeletePenerima" 
                        wire:confirm="Yakin ingin menghapus {{ count($selectedPenerima) }} data penerima anugerah APMO terpilih?"
                        class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                    >
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                </x-table.bulk-bar>
            @else
                <x-table.bulk-bar :count="count($selectedEdisi)" label="Edisi dipilih" reset-action="resetSelectionEdisi">
                    <button 
                        type="button" 
                        wire:click="bulkDeleteEdisi" 
                        wire:confirm="Yakin ingin menghapus {{ count($selectedEdisi) }} edisi tahunan APMO terpilih beserta seluruh penerimanya?"
                        class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                    >
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                </x-table.bulk-bar>
            @endif

            <!-- 6. CONTENT TAB 1: PENERIMA ANUGERAH -->
            @if($tabAktif === 'penerima')
                @if($tampilanMode === 'tabel')
                    <x-table.card>
                        <x-table.table loading-target="cari, tahunDipilih, kategoriFilter, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
                            <x-table.thead>
                                <tr>
                                    <x-table.th align="center" class="w-12 !px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="pilihSemuaPenerima" 
                                            class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                                        >
                                    </x-table.th>
                                    <x-table.th 
                                        sortable 
                                        sort-field="nama_penerima" 
                                        :current-sort="$sortField" 
                                        :current-direction="$sortDirection"
                                    >
                                        Profil Tokoh / Penerima
                                    </x-table.th>
                                    <x-table.th 
                                        sortable 
                                        sort-field="kategori_penghargaan" 
                                        :current-sort="$sortField" 
                                        :current-direction="$sortDirection"
                                    >
                                        Kategori Penghargaan
                                    </x-table.th>
                                    <x-table.th>Edisi Tahun</x-table.th>
                                    <x-table.th 
                                        align="center"
                                        sortable 
                                        sort-field="urutan" 
                                        :current-sort="$sortField" 
                                        :current-direction="$sortDirection"
                                    >
                                        Urutan
                                    </x-table.th>
                                    <x-table.th align="center" class="w-24">Aksi</x-table.th>
                                </tr>
                            </x-table.thead>

                            <x-table.tbody>
                                @forelse($daftarPenerima as $penerima)
                                    <x-table.tr :selected="in_array($penerima->id, $selectedPenerima)">
                                        <!-- Checkbox -->
                                        <x-table.td align="center" class="!px-4">
                                            <input 
                                                type="checkbox" 
                                                wire:model.live="selectedPenerima" 
                                                value="{{ $penerima->id }}" 
                                                class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                                            >
                                        </x-table.td>

                                        <!-- Info Tokoh -->
                                        <x-table.td>
                                            <div class="flex items-start gap-3.5">
                                                <div class="w-12 h-12 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 relative">
                                                    @if($penerima->foto_url)
                                                        <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($penerima->foto_url) }}" class="w-full h-full object-cover" alt="{{ $penerima->nama_penerima }}">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                                            <i data-lucide="user" class="w-6 h-6"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="min-w-0">
                                                    <h3 class="font-black text-slate-900 text-sm leading-snug group-hover:text-amber-600 transition-colors">
                                                        {{ $penerima->nama_penerima }}
                                                    </h3>
                                                    <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                                                        <i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i>
                                                        <span>{{ $penerima->asal_lembaga_wilayah ?: 'Kabupaten Bandung' }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </x-table.td>

                                        <!-- Kategori -->
                                        <x-table.td>
                                            <span class="px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200/60 text-amber-800 text-xs font-bold">
                                                {{ $penerima->kategori_penghargaan }}
                                            </span>
                                        </x-table.td>

                                        <!-- Edisi Tahun -->
                                        <x-table.td>
                                            <span class="font-black text-slate-900 text-xs bg-slate-100 px-3 py-1 rounded-xl">
                                                Tahun {{ $penerima->tahun->tahun ?? '2026' }}
                                            </span>
                                        </x-table.td>

                                        <!-- Urutan -->
                                        <x-table.td align="center">
                                            <span class="font-bold text-slate-500 text-xs">
                                                #{{ $penerima->urutan }}
                                            </span>
                                        </x-table.td>

                                        <!-- Actions -->
                                        <x-table.td align="center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <x-table.action-btn 
                                                    size="sm"
                                                    variant="warning" 
                                                    icon="edit-3" 
                                                    loading-target="bukaFormPenerimaEdit('{{ $penerima->id }}')"
                                                    wire:click="bukaFormPenerimaEdit('{{ $penerima->id }}')" 
                                                    title="Edit Penerima" 
                                                />

                                                <x-table.action-btn 
                                                    size="sm"
                                                    variant="danger" 
                                                    icon="trash-2" 
                                                    loading-target="hapusPenerima('{{ $penerima->id }}')"
                                                    wire:click="hapusPenerima('{{ $penerima->id }}')" 
                                                    wire:confirm="Yakin ingin menghapus data penerima anugerah APMO ini?" 
                                                    title="Hapus Penerima" 
                                                />
                                            </div>
                                        </x-table.td>
                                    </x-table.tr>
                                @empty
                                    <x-table.empty 
                                        colspan="6" 
                                        icon="trophy" 
                                        title="Belum ada penerima anugerah" 
                                        description="Silakan tambahkan profil tokoh penggerak olahraga penerima anugerah APMO."
                                    />
                                @endforelse
                            </x-table.tbody>
                        </x-table.table>

                        @if($daftarPenerima->hasPages())
                            <x-slot:footer>
                                <div class="px-4 py-3 flex items-center justify-between">
                                    {{ $daftarPenerima->links() }}
                                </div>
                            </x-slot:footer>
                        @endif
                    </x-table.card>
                @else
                    <!-- Grid View for Penerima -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($daftarPenerima as $penerima)
                            <div wire:key="grid-penerima-{{ $penerima->id }}" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-6 flex flex-col justify-between group {{ in_array($penerima->id, $selectedPenerima) ? 'ring-2 ring-amber-500' : '' }}">
                                <div>
                                    <div class="flex items-start justify-between gap-3 mb-4">
                                        <div class="flex items-center gap-2">
                                            <input 
                                                type="checkbox" 
                                                wire:model.live="selectedPenerima" 
                                                value="{{ $penerima->id }}" 
                                                class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer shadow-xs"
                                            >
                                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                                {{ $penerima->kategori_penghargaan }}
                                            </span>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-xl text-[10px] font-black bg-slate-900 text-white">
                                            {{ $penerima->tahun->tahun ?? '2026' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3.5 mb-3.5">
                                        <div class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                            @if($penerima->foto_url)
                                                <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($penerima->foto_url) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" alt="{{ $penerima->nama_penerima }}">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                                    <i data-lucide="user" class="w-6 h-6"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="text-sm font-black text-slate-900 group-hover:text-amber-600 transition-colors line-clamp-1">{{ $penerima->nama_penerima }}</h3>
                                            <span class="text-[11px] text-slate-400 font-medium line-clamp-1">{{ $penerima->asal_lembaga_wilayah ?: 'Kabupaten Bandung' }}</span>
                                        </div>
                                    </div>

                                    <p class="text-xs text-slate-600 line-clamp-3 bg-slate-50 p-3.5 rounded-2xl border border-slate-100 leading-relaxed">
                                        {{ $penerima->deskripsi_capaian }}
                                    </p>
                                </div>

                                <div class="pt-4 mt-6 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-slate-400">Urutan: #{{ $penerima->urutan }}</span>

                                    <div class="flex items-center gap-1.5">
                                        <button 
                                            type="button" 
                                            wire:click="bukaFormPenerimaEdit('{{ $penerima->id }}')" 
                                            class="p-2 rounded-xl text-amber-600 hover:bg-amber-50 font-bold text-xs transition-colors cursor-pointer"
                                            title="Edit Penerima"
                                        >
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>
                                        <button 
                                            type="button" 
                                            wire:click="hapusPenerima('{{ $penerima->id }}')" 
                                            wire:confirm="Yakin ingin menghapus data penerima anugerah APMO ini?"
                                            class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 font-bold text-xs transition-colors cursor-pointer"
                                            title="Hapus Penerima"
                                        >
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                                <i data-lucide="award" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-bold text-slate-600">Belum ada penerima anugerah yang sesuai filter.</p>
                                <button type="button" wire:click="bukaFormPenerimaTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-amber-600 text-white font-bold text-xs cursor-pointer">
                                    + Tambah Penerima Anugerah
                                </button>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $daftarPenerima->links() }}
                    </div>
                @endif

            <!-- 7. CONTENT TAB 2: EDISI TAHUN -->
            @else
                <x-table.card>
                    <x-table.table loading-target="cari, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
                        <x-table.thead>
                            <tr>
                                <x-table.th align="center" class="w-12 !px-4">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="pilihSemuaEdisi" 
                                        class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                                    >
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="tahun" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Tahun Edisi
                                </x-table.th>
                                <x-table.th>Tema Acara & Slogan</x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="tanggal_penganugerahan" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Tanggal Pelaksanaan
                                </x-table.th>
                                <x-table.th>Tempat / Venue</x-table.th>
                                <x-table.th align="center">Penerima Terdata</x-table.th>
                                <x-table.th align="center" class="w-24">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>

                        <x-table.tbody>
                            @forelse($daftarEdisi as $edisi)
                                <x-table.tr :selected="in_array($edisi->id, $selectedEdisi)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedEdisi" 
                                            value="{{ $edisi->id }}" 
                                            class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Tahun Edisi -->
                                    <x-table.td>
                                        <span class="font-black text-slate-900 text-sm bg-amber-50 text-amber-800 border border-amber-200 px-3 py-1.5 rounded-2xl inline-block">
                                            {{ $edisi->tahun }}
                                        </span>
                                    </x-table.td>

                                    <!-- Tema -->
                                    <x-table.td>
                                        <h4 class="font-bold text-slate-900 text-sm">
                                            {{ $edisi->tema_acara ?: '-' }}
                                        </h4>
                                    </x-table.td>

                                    <!-- Tanggal -->
                                    <x-table.td>
                                        <div class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-amber-500"></i>
                                            <span>{{ $edisi->tanggal_penganugerahan ? \Carbon\Carbon::parse($edisi->tanggal_penganugerahan)->format('d F Y') : '-' }}</span>
                                        </div>
                                    </x-table.td>

                                    <!-- Tempat -->
                                    <x-table.td>
                                        <div class="text-xs font-medium text-slate-600 flex items-center gap-1.5 max-w-xs truncate">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                            <span class="truncate">{{ $edisi->tempat_acara ?: '-' }}</span>
                                        </div>
                                    </x-table.td>

                                    <!-- Penerima Count -->
                                    <x-table.td align="center">
                                        <span class="font-black text-slate-800 bg-slate-100 px-3 py-1 rounded-xl text-xs inline-flex items-center gap-1">
                                            <i data-lucide="award" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <span>{{ $edisi->penerima_count }} Tokoh</span>
                                        </span>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="warning" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdisiEdit('{{ $edisi->id }}')"
                                                wire:click="bukaFormEdisiEdit('{{ $edisi->id }}')" 
                                                title="Edit Edisi" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="hapusEdisi('{{ $edisi->id }}')"
                                                wire:click="hapusEdisi('{{ $edisi->id }}')" 
                                                wire:confirm="Yakin ingin menghapus edisi APMO ini beserta seluruh data penerimanya?" 
                                                title="Hapus Edisi" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="7" 
                                    icon="calendar-x" 
                                    title="Belum ada edisi tahunan APMO" 
                                    description="Silakan buat edisi penganugerahan tahun baru."
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    @if($daftarEdisi->hasPages())
                        <x-slot:footer>
                            <div class="px-4 py-3 flex items-center justify-between">
                                {{ $daftarEdisi->links() }}
                            </div>
                        </x-slot:footer>
                    @endif
                </x-table.card>
            @endif

        </div>

    @elseif($mode === 'form_penerima')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM PENERIMA APMO      -->
        <!-- ========================================== -->
        <div wire:key="apmo-view-form-penerima" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$editPenerimaId ? 'Edit Biodata Penerima APMO' : 'Registrasi Penerima Anugerah Penggerak Olahraga'"
                subtitle="Lengkapi data tokoh / inorga penerima apresiasi penghargaan, capaian prestasi, dan foto dokumentasi."
                :badge="$editPenerimaId ? 'Mode Edit Penerima' : 'Penerima Baru'"
                icon="trophy"
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
                        variant="warning" 
                        size="default" 
                        icon="check" 
                        loading-target="simpanPenerima"
                        wire:click="simpanPenerima"
                    >
                        {{ $editPenerimaId ? 'Perbarui Data' : 'Simpan Penerima' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT (2 Columns: 8 cols Metadata + 4 cols Photo Upload & Guide) -->
            <form wire:submit.prevent="simpanPenerima" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Metadata Profil Tokoh -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Profil Tokoh & Kategori Penghargaan" 
                            subtitle="Identitas penerima, tahun edisi penyelenggaraan, dan rincian capaian."
                            icon="user-check"
                        >
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Edisi Tahun APMO -->
                                <x-form.field label="Edisi Tahun APMO" name="apmo_tahun_id" :required="true">
                                    <x-form.select name="apmo_tahun_id" wire:model="apmo_tahun_id">
                                        @foreach($semuaEdisi as $ed)
                                            <option value="{{ $ed->id }}">Tahun {{ $ed->tahun }} - {{ $ed->tema_acara ?: 'APMO' }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <!-- Kategori Anugerah -->
                                <x-form.field label="Kategori Anugerah" name="kategori_penghargaan" :required="true">
                                    <x-form.select name="kategori_penghargaan" wire:model="kategori_penghargaan">
                                        <option value="Tokoh Olahraga Rekreasi">Tokoh Olahraga Rekreasi</option>
                                        <option value="Penggerak Olahraga Desa">Penggerak Olahraga Desa</option>
                                        <option value="Inorga Teraktif & Berprestasi">Inorga Teraktif & Berprestasi</option>
                                        <option value="Pelatih / Instruktur Berdedikasi">Pelatih / Instruktur Berdedikasi</option>
                                        <option value="Tokoh Pelestari Olahraga Tradisional">Tokoh Pelestari Olahraga Tradisional</option>
                                        <option value="Mitra Kerja Pendukung KORMI">Mitra Kerja Pendukung KORMI</option>
                                    </x-form.select>
                                </x-form.field>
                            </div>

                            <!-- Nama Penerima -->
                            <x-form.field label="Nama Lengkap Penerima / Nama Lembaga" name="nama_penerima" :required="true">
                                <x-form.input 
                                    name="nama_penerima" 
                                    wire:model="nama_penerima" 
                                    placeholder="Contoh: Dr. H. Dadang Supriatna, S.Ip., M.Si / PORTINA..." 
                                    size="lg"
                                    class="font-black text-slate-900"
                                />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Asal Lembaga / Wilayah -->
                                <x-form.field label="Asal Lembaga / Wilayah Kecamatan" name="asal_lembaga_wilayah">
                                    <x-form.input 
                                        name="asal_lembaga_wilayah" 
                                        wire:model="asal_lembaga_wilayah" 
                                        placeholder="Contoh: Kecamatan Soreang / Paguyuban Egrang..." 
                                        icon="map-pin"
                                    />
                                </x-form.field>

                                <!-- Urutan -->
                                <x-form.field label="Urutan Posisi Tampil" name="urutan" :required="true">
                                    <x-form.input 
                                        type="number" 
                                        name="urutan" 
                                        wire:model="urutan" 
                                        min="1"
                                        icon="hash"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Deskripsi Capaian -->
                            <x-form.field label="Deskripsi Capaian & Alasan Penganugerahan" name="deskripsi_capaian" :required="true">
                                <x-form.textarea 
                                    name="deskripsi_capaian" 
                                    wire:model="deskripsi_capaian" 
                                    rows="4" 
                                    placeholder="Uraikan dedikasi, kontribusi, inovasi, dan capaian luar biasa yang berhasil diraih..."
                                />
                            </x-form.field>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Photo Upload & Guide -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Photo Card -->
                        <x-form.card 
                            title="Foto Resmi Tokoh / Piagam" 
                            subtitle="Visual profil dokumentasi penerima APMO."
                            icon="image"
                        >
                            <x-form.image-upload
                                :upload="$uploadFotoPenerima"
                                :saved-path="$foto_url"
                                name="uploadFotoPenerima"
                                input-id="uploadFotoApmo"
                                empty-title="Unggah Foto Penerima"
                                empty-subtitle="Format JPG, PNG, WEBP (Maksimal 5MB)"
                                :max-size-m-b="5"
                                aspect-ratio="h-56 sm:h-64"
                            />
                        </x-form.card>

                        <!-- Guide Information Card -->
                        <div class="bg-amber-50/70 border border-amber-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-amber-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="award" class="w-4 h-4 text-amber-600"></i>
                                <span>Kriteria Anugerah APMO</span>
                            </h4>
                            <p class="text-xs text-amber-950 leading-relaxed">
                                Penerima APMO dinilai berdasarkan konsistensi pengabdian terhadap pemajuan olahraga rekreasi dan kebugaran masyarakat di Kabupaten Bandung.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 3. ACTION BAR -->
                <x-form.action-bar>
                    <x-form.button 
                        type="button" 
                        variant="secondary" 
                        wire:click="kembaliKeTabel"
                    >
                        Batal
                    </x-form.button>

                    <x-form.button 
                        type="submit" 
                        variant="warning" 
                        icon="save" 
                        loading-target="simpanPenerima"
                    >
                        {{ $editPenerimaId ? 'Perbarui Data' : 'Simpan Penerima' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>

    @elseif($mode === 'form_edisi')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM EDISI TAHUN APMO   -->
        <!-- ========================================== -->
        <div wire:key="apmo-view-form-edisi" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$editEdisiId ? 'Edit Rincian Edisi APMO' : 'Buat Edisi Tahunan APMO Baru'"
                subtitle="Atur tahun edisi penghargaan, tema acara, tempat pelaksanaan, dan tanggal seremonial."
                :badge="$editEdisiId ? 'Mode Edit Edisi' : 'Edisi Baru'"
                icon="calendar-plus"
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
                        variant="warning" 
                        size="default" 
                        icon="check" 
                        loading-target="simpanEdisi"
                        wire:click="simpanEdisi"
                    >
                        {{ $editEdisiId ? 'Perbarui Edisi' : 'Simpan Edisi' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT -->
            <form wire:submit.prevent="simpanEdisi" class="space-y-6">
                <x-form.card 
                    title="Informasi Penyelenggaraan Edisi APMO" 
                    subtitle="Parameter tahun, tanggal seremoni penganugerahan, dan venue tempat acara."
                    icon="calendar"
                >
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Tahun -->
                        <x-form.field label="Tahun Penganugerahan" name="tahun" :required="true">
                            <x-form.input 
                                type="number" 
                                name="tahun" 
                                wire:model="tahun" 
                                min="2000" 
                                max="2100"
                                size="lg"
                                class="font-black text-slate-900"
                            />
                        </x-form.field>

                        <!-- Tema Acara -->
                        <x-form.field label="Tema Acara / Slogan" name="tema_acara">
                            <x-form.input 
                                name="tema_acara" 
                                wire:model="tema_acara" 
                                placeholder="Contoh: Olahraga Rekreasi untuk Indonesia Bugar 2026..." 
                                icon="sparkles"
                            />
                        </x-form.field>

                        <!-- Tanggal Acara -->
                        <x-form.field label="Tanggal Pelaksanaan Acara" name="tanggal_penganugerahan">
                            <x-form.datepicker 
                                name="tanggal_penganugerahan" 
                                wire:model="tanggal_penganugerahan" 
                                :enableTime="false"
                                dateFormat="Y-m-d"
                                altFormat="j F Y"
                                placeholder="Pilih tanggal acara..."
                            />
                        </x-form.field>

                        <!-- Tempat Acara -->
                        <x-form.field label="Tempat / Venue Acara" name="tempat_acara">
                            <x-form.input 
                                name="tempat_acara" 
                                wire:model="tempat_acara" 
                                placeholder="Contoh: Gedung Budaya Sabilulungan Soreang..." 
                                icon="map-pin"
                            />
                        </x-form.field>
                    </div>

                    <!-- Catatan / Deskripsi -->
                    <x-form.field label="Catatan / Rangkuman Edisi" name="deskripsi">
                        <x-form.textarea 
                            name="deskripsi" 
                            wire:model="deskripsi" 
                            rows="3" 
                            placeholder="Rangkuman atau catatan penyelenggaraan penganugerahan APMO tahun ini..."
                        />
                    </x-form.field>
                </x-form.card>

                <!-- 3. ACTION BAR -->
                <x-form.action-bar>
                    <x-form.button 
                        type="button" 
                        variant="secondary" 
                        wire:click="kembaliKeTabel"
                    >
                        Batal
                    </x-form.button>

                    <x-form.button 
                        type="submit" 
                        variant="warning" 
                        icon="save" 
                        loading-target="simpanEdisi"
                    >
                        {{ $editEdisiId ? 'Perbarui Edisi' : 'Simpan Edisi APMO' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

</div>
