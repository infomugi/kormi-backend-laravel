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
        <!-- VIEW MODE: TABEL LINIMASA SEJARAH          -->
        <!-- ========================================== -->
        <div wire:key="sejarah-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola Linimasa Sejarah KORMI"
                subtitle="Dokumentasi tonggak sejarah, peristiwa penting, dan rekam jejak perjalanan KORMI Kabupaten Bandung dari masa ke masa."
                badge="Kelembagaan & Struktur • Linimasa Sejarah"
                icon="clock"
                color="amber"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormTambah"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-amber-600 via-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4 transition-transform group-hover:rotate-90 duration-200"></i>
                        <span>Tambah Peristiwa Baru</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Peristiwa"
                    :value="number_format($totalSejarah)"
                    unit="Timeline"
                    subtitle="Semua rekam peristiwa"
                    icon="clock"
                    color="amber"
                    :active="$statusFilter === 'Semua'"
                    loading-target="resetSemuaFilter, setFilterStatus"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Tampil di Publik"
                    :value="number_format($totalTampil)"
                    unit="Aktif"
                    subtitle="Dapat dibaca pengunjung"
                    icon="eye"
                    color="emerald"
                    :pulse="true"
                    :active="$statusFilter === 'Tampil'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('Tampil')"
                />

                <x-table.stats-card
                    title="Disembunyikan"
                    :value="number_format($totalSembunyi)"
                    unit="Draft"
                    subtitle="Belum dipublikasikan"
                    icon="eye-off"
                    color="slate"
                    :active="$statusFilter === 'Disembunyikan'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('Disembunyikan')"
                />

                <x-table.stats-card
                    title="Rentang Waktu"
                    :value="($tahunPertama && $tahunTerakhir ? $tahunPertama . ' - ' . $tahunTerakhir : '-')"
                    unit="Periode"
                    subtitle="Cakupan linimasa"
                    icon="calendar-range"
                    color="purple"
                    loading-target="cari"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                search-placeholder="Cari tahun, judul peristiwa, narasi sejarah..." 
                search-model="cari"
            >
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                        @foreach(['Semua', 'Tampil', 'Disembunyikan'] as $st)
                            <button 
                                type="button"
                                wire:click="setFilterStatus('{{ $st }}')" 
                                class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $statusFilter === $st ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                            >
                                <span>{{ $st === 'Semua' ? 'Semua Status' : ($st === 'Tampil' ? 'Tampil di Publik' : 'Disembunyikan') }}</span>
                            </button>
                        @endforeach
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="urutan">Urutan: Posisi Kronologis</option>
                        <option value="tahun">Urutan: Tahun Peristiwa</option>
                        <option value="judul">Urutan: Judul Peristiwa</option>
                        <option value="created_at">Urutan: Waktu Input</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="asc">Awal ke Akhir / A-Z (ASC)</option>
                        <option value="desc">Akhir ke Awal / Z-A (DESC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="10">10 / hal</option>
                        <option value="20">20 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>

                    <!-- View Switcher -->
                    <div 
                        x-data="{
                            mode: localStorage.getItem('kormi_sejarah_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_sejarah_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_sejarah_view') && localStorage.getItem('kormi_sejarah_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_sejarah_view'));
                            }
                        "
                        class="flex items-center p-1 bg-slate-100 rounded-2xl border border-slate-200 shrink-0"
                    >
                        <button 
                            type="button" 
                            @click="setMode('tabel')" 
                            :class="mode === 'tabel' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-400 hover:text-slate-700'"
                            class="p-1.5 rounded-xl transition-all cursor-pointer"
                            title="Tampilan Datatable"
                        >
                            <i data-lucide="list" class="w-4 h-4"></i>
                        </button>
                        <button 
                            type="button" 
                            @click="setMode('grid')" 
                            :class="mode === 'grid' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-400 hover:text-slate-700'"
                            class="p-1.5 rounded-xl transition-all cursor-pointer"
                            title="Tampilan Grid Kartu"
                        >
                            <i data-lucide="layout-grid" class="w-4 h-4"></i>
                        </button>
                    </div>
                </x-slot:actions>
            </x-table.filter-bar>

            <!-- 4. FLOATING BULK ACTIONS BAR -->
            <x-table.bulk-bar :count="count($selectedSejarah)" label="Peristiwa dipilih" reset-action="resetSelection">
                <button 
                    type="button" 
                    wire:click="bulkSetStatus(true)" 
                    class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                    <span>Tampilkan ke Publik</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkSetStatus(false)" 
                    class="px-3 py-1.5 rounded-xl bg-slate-700 hover:bg-slate-800 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="eye-off" class="w-3.5 h-3.5"></i>
                    <span>Sembunyikan</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDelete" 
                    wire:confirm="Yakin ingin menghapus {{ count($selectedSejarah) }} timeline peristiwa terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. CONTENT (DATATABLE & GRID CARDS) -->
            @if($tampilanMode === 'tabel')
                <x-table.card>
                    <x-table.table loading-target="cari, statusFilter, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
                        <x-table.thead>
                            <tr>
                                <x-table.th align="center" class="w-12 !px-4">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="pilihSemua" 
                                        class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                                    >
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="tahun" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-28"
                                >
                                    Tahun
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="judul" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Peristiwa & Deskripsi Sejarah
                                </x-table.th>
                                <x-table.th 
                                    align="center"
                                    sortable 
                                    sort-field="urutan" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-20"
                                >
                                    Urutan
                                </x-table.th>
                                <x-table.th 
                                    align="center"
                                    sortable 
                                    sort-field="status_tampil" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-32"
                                >
                                    Status
                                </x-table.th>
                                <x-table.th align="center" class="w-28">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>

                        <x-table.tbody>
                            @forelse($sejarahList as $item)
                                <x-table.tr :selected="in_array($item->id, $selectedSejarah)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedSejarah" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Tahun Badge -->
                                    <x-table.td>
                                        <span class="px-3.5 py-1.5 rounded-2xl bg-amber-50 text-amber-800 border border-amber-200/80 font-black text-sm tracking-wider inline-block">
                                            {{ $item->tahun }}
                                        </span>
                                    </x-table.td>

                                    <!-- Judul & Deskripsi -->
                                    <x-table.td>
                                        <div class="flex items-start gap-3.5">
                                            @if($item->gambar_url)
                                                <div class="w-12 h-12 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                                    <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($item->gambar_url) }}" class="w-full h-full object-cover" alt="{{ $item->judul }}">
                                                </div>
                                            @endif

                                            <div class="min-w-0">
                                                <h3 class="font-black text-slate-900 text-sm leading-snug group-hover:text-amber-600 transition-colors">
                                                    {{ $item->judul }}
                                                </h3>
                                                <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                                    {{ $item->deskripsi }}
                                                </p>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Urutan -->
                                    <x-table.td align="center">
                                        <span class="font-bold text-slate-600 text-xs bg-slate-100 px-2.5 py-1 rounded-xl">
                                            #{{ $item->urutan }}
                                        </span>
                                    </x-table.td>

                                    <!-- Status Tampil -->
                                    <x-table.td align="center">
                                        <button 
                                            type="button" 
                                            wire:click="toggleStatus('{{ $item->id }}')" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer border {{ $item->status_tampil ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200' }}"
                                            title="Klik untuk mengubah status tampil di halaman publik"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full {{ $item->status_tampil ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            <span>{{ $item->status_tampil ? 'Tampil' : 'Draft' }}</span>
                                        </button>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="warning" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdit('{{ $item->id }}')"
                                                wire:click="bukaFormEdit('{{ $item->id }}')" 
                                                title="Edit Sejarah" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="hapus('{{ $item->id }}')"
                                                wire:click="hapus('{{ $item->id }}')" 
                                                wire:confirm="Yakin ingin menghapus timeline sejarah ini?" 
                                                title="Hapus Sejarah" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="6" 
                                    icon="clock" 
                                    title="Belum ada timeline sejarah" 
                                    description="Silakan tambahkan peristiwa penting dalam perjalanan organisasi KORMI."
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    @if($sejarahList->hasPages())
                        <x-slot:footer>
                            <div class="px-4 py-3 flex items-center justify-between">
                                {{ $sejarahList->links() }}
                            </div>
                        </x-slot:footer>
                    @endif
                </x-table.card>
            @else
                <!-- Grid View Mode -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($sejarahList as $item)
                        <div wire:key="grid-sejarah-{{ $item->id }}" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between group {{ in_array($item->id, $selectedSejarah) ? 'ring-2 ring-amber-500' : '' }}">
                            <div>
                                <div class="flex items-start justify-between gap-3 mb-4">
                                    <div class="flex items-center gap-2">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedSejarah" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer shadow-xs"
                                        >
                                        <span class="px-3 py-1 rounded-2xl bg-amber-50 text-amber-800 border border-amber-200 font-black text-xs">
                                            {{ $item->tahun }}
                                        </span>
                                    </div>

                                    <button 
                                        type="button" 
                                        wire:click="toggleStatus('{{ $item->id }}')" 
                                        class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $item->status_tampil ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' }}"
                                    >
                                        {{ $item->status_tampil ? 'Tampil' : 'Draft' }}
                                    </button>
                                </div>

                                @if($item->gambar_url)
                                    <div class="h-36 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 mb-3.5">
                                        <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($item->gambar_url) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $item->judul }}">
                                    </div>
                                @endif

                                <h3 class="text-sm font-black text-slate-900 group-hover:text-amber-600 transition-colors line-clamp-2 mb-2 leading-snug">
                                    {{ $item->judul }}
                                </h3>

                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                    {{ $item->deskripsi }}
                                </p>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400">Urutan: #{{ $item->urutan }}</span>

                                <div class="flex items-center gap-1.5">
                                    <button wire:click="bukaFormEdit('{{ $item->id }}')" title="Edit Sejarah" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-amber-50 hover:text-amber-600 transition-all cursor-pointer">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <button wire:click="hapus('{{ $item->id }}')" wire:confirm="Yakin ingin menghapus timeline ini?" title="Hapus Sejarah" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition-all cursor-pointer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                            <i data-lucide="clock" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                            <p class="text-sm font-bold text-slate-600">Belum ada peristiwa linimasa sejarah.</p>
                            <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-amber-600 text-white font-bold text-xs cursor-pointer">
                                + Tambah Peristiwa Baru
                            </button>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $sejarahList->links() }}
                </div>
            @endif

        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM SEJARAH (UI KIT)   -->
        <!-- ========================================== -->
        <div wire:key="sejarah-view-form" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$editId ? 'Edit Data Linimasa Sejarah' : 'Tambah Peristiwa Sejarah Baru'"
                subtitle="Susun tonggak sejarah, tahun peristiwa, narasi kronologis, dan foto dokumentasi arsip."
                :badge="$editId ? 'Mode Edit Sejarah' : 'Peristiwa Baru'"
                icon="clock"
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
                        loading-target="simpan"
                        wire:click="simpan"
                    >
                        {{ $editId ? 'Perbarui Peristiwa' : 'Simpan Peristiwa' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT (2 Columns: 8 cols Metadata + 4 cols Foto & Info) -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Metadata Sejarah -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Detail Peristiwa & Kronologi" 
                            subtitle="Parameter tahun kejadian, judul tonggak sejarah, dan narasi lengkap peristiwa."
                            icon="file-text"
                        >
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Tahun -->
                                <x-form.field label="Tahun Peristiwa" name="tahun" :required="true">
                                    <x-form.input 
                                        name="tahun" 
                                        wire:model="tahun" 
                                        placeholder="Contoh: 2021 / 2021-2025" 
                                        size="lg"
                                        class="font-black text-slate-900"
                                        icon="calendar"
                                    />
                                </x-form.field>

                                <!-- Urutan -->
                                <x-form.field label="Urutan Kronologis" name="urutan">
                                    <x-form.input 
                                        type="number" 
                                        name="urutan" 
                                        wire:model="urutan" 
                                        min="0"
                                        icon="hash"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Judul Peristiwa -->
                            <x-form.field label="Judul Tonggak Peristiwa Sejarah" name="judul" :required="true">
                                <x-form.input 
                                    name="judul" 
                                    wire:model="judul" 
                                    placeholder="Contoh: Pembentukan Pengurus Perdana KORMI Kabupaten Bandung..." 
                                />
                            </x-form.field>

                            <!-- Deskripsi -->
                            <x-form.field label="Narasi Deskripsi Sejarah" name="deskripsi" :required="true">
                                <x-form.textarea 
                                    name="deskripsi" 
                                    wire:model="deskripsi" 
                                    rows="5" 
                                    placeholder="Uraikan detail latar belakang, keputusan musyawarah, pencapaian bersejarah, atau dampak peristiwa ini bagi KORMI..."
                                />
                            </x-form.field>

                            <!-- Status Tampil Toggle -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <label for="statusTampilSejarah" class="text-xs font-black text-slate-900 cursor-pointer">Tampilkan di Halaman Publik</label>
                                    <p class="text-xs text-slate-500">Peristiwa dengan status aktif akan ditampilkan pada linimasa sejarah portal publik.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="statusTampilSejarah" wire:model="status_tampil" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                                </label>
                            </div>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Foto Dokumentasi & Panduan -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Foto Card -->
                        <x-form.card 
                            title="Foto Arsip / Dokumentasi" 
                            subtitle="Visual arsip foto peristiwa bersejarah."
                            icon="image"
                        >
                            <x-form.image-upload
                                :upload="$uploadGambar"
                                :saved-path="$gambar_url"
                                name="uploadGambar"
                                input-id="uploadFotoSejarah"
                                empty-title="Unggah Foto Arsip Sejarah"
                                empty-subtitle="Format JPG, PNG, WEBP (Maksimal 10MB)"
                                :max-size-m-b="10"
                                aspect-ratio="h-48 sm:h-56"
                            />
                        </x-form.card>

                        <!-- Guide Information Card -->
                        <div class="bg-amber-50/70 border border-amber-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-amber-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="info" class="w-4 h-4 text-amber-600"></i>
                                <span>Linimasa Publik</span>
                            </h4>
                            <p class="text-xs text-amber-950 leading-relaxed">
                                Susunan urutan timeline diatur berdasarkan nilai <strong>Urutan Kronologis</strong> terkecil ke terbesar, lalu disusul tahun peristiwa.
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
                        loading-target="simpan"
                    >
                        {{ $editId ? 'Perbarui Peristiwa' : 'Simpan Peristiwa' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

</div>
