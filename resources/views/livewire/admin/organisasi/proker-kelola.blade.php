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
        <!-- VIEW MODE: TABEL PROGRAM KERJA             -->
        <!-- ========================================== -->
        <div wire:key="proker-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola Program Kerja KORMI"
                subtitle="Perencanaan kegiatan strategis, alokasi estimasi anggaran, jadwal bulanan, dan progres realisasi program per bidang."
                badge="Kelembagaan & Struktur • Program Kerja"
                icon="briefcase"
                color="amber"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormTambah"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-amber-600 via-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4 transition-transform group-hover:rotate-90 duration-200"></i>
                        <span>Tambah Program Baru</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Program"
                    :value="number_format($totalProkerFilter)"
                    unit="Kegiatan"
                    subtitle="{{ $filterTahun !== 'semua' ? 'Tahun Anggaran ' . $filterTahun : 'Semua tahun anggaran' }}"
                    icon="briefcase"
                    color="amber"
                    :active="$filterStatus === 'semua' && $filterTahun === 'semua' && $filterBidang === 'semua'"
                    loading-target="resetSemuaFilter, setFilterTahun, setFilterStatus"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Alokasi Anggaran"
                    :value="'Rp ' . number_format($totalAnggaran / 1000000, 1) . ' Jt'"
                    unit="Estimasi"
                    subtitle="Rp {{ number_format($totalAnggaran, 0, ',', '.') }}"
                    icon="wallet"
                    color="emerald"
                    loading-target="filterTahun, filterBidang"
                />

                <x-table.stats-card
                    title="Berjalan & Selesai"
                    :value="number_format($totalAktifBerjalan)"
                    unit="Proker"
                    subtitle="{{ $statusCounts['selesai'] }} Selesai • {{ $statusCounts['berjalan'] }} Berjalan"
                    icon="check-circle-2"
                    color="blue"
                    :pulse="true"
                    :active="$filterStatus === 'berjalan' || $filterStatus === 'selesai'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('berjalan')"
                />

                <x-table.stats-card
                    title="Rencana / Ditunda"
                    :value="number_format($statusCounts['rencana'] + $statusCounts['ditunda'])"
                    unit="Pending"
                    subtitle="{{ $statusCounts['rencana'] }} Rencana • {{ $statusCounts['ditunda'] }} Ditunda"
                    icon="clock"
                    color="purple"
                    :active="$filterStatus === 'rencana' || $filterStatus === 'ditunda'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('rencana')"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                search-placeholder="Cari nama kegiatan, bidang, target sasaran, tujuan..." 
                search-model="cari"
            >
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                        <button 
                            type="button"
                            wire:click="setFilterStatus('semua')" 
                            class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $filterStatus === 'semua' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <span>Semua Status</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $filterStatus === 'semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalProkerFilter }}</span>
                        </button>

                        @foreach([
                            'rencana' => ['label' => 'Rencana', 'color' => 'bg-blue-600'],
                            'berjalan' => ['label' => 'Sedang Berjalan', 'color' => 'bg-amber-600'],
                            'selesai' => ['label' => 'Selesai Terlaksana', 'color' => 'bg-emerald-600'],
                            'ditunda' => ['label' => 'Ditunda', 'color' => 'bg-rose-600'],
                        ] as $stKey => $stCfg)
                            <button 
                                type="button"
                                wire:click="setFilterStatus('{{ $stKey }}')" 
                                class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $filterStatus === $stKey ? $stCfg['color'] . ' text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                            >
                                <span>{{ $stCfg['label'] }}</span>
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $filterStatus === $stKey ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $statusCounts[$stKey] ?? 0 }}</span>
                            </button>
                        @endforeach
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <!-- Filter Tahun -->
                    <select wire:model.live="filterTahun" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="semua">Semua Tahun</option>
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}">Tahun {{ $t }}</option>
                        @endforeach
                    </select>

                    <!-- Filter Bidang -->
                    <select wire:model.live="filterBidang" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer max-w-xs">
                        <option value="semua">Semua Bidang</option>
                        @foreach($bidangList as $b)
                            <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>

                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="tahun_anggaran">Urutan: Tahun Anggaran</option>
                        <option value="nama_kegiatan">Urutan: Nama Kegiatan</option>
                        <option value="nama_bidang">Urutan: Bidang Kerja</option>
                        <option value="estimasi_anggaran">Urutan: Besaran Anggaran</option>
                        <option value="bulan_mulai">Urutan: Bulan Pelaksanaan</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="desc">Terbaru / Z-A (DESC)</option>
                        <option value="asc">Terlama / A-Z (ASC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="10">10 / hal</option>
                        <option value="20">20 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>

                    <!-- View Switcher with localStorage persistence -->
                    <div 
                        x-data="{
                            mode: localStorage.getItem('kormi_proker_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_proker_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_proker_view') && localStorage.getItem('kormi_proker_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_proker_view'));
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
            <x-table.bulk-bar :count="count($selectedProker)" label="Program dipilih" reset-action="resetSelection">
                <button 
                    type="button" 
                    wire:click="bulkSetStatus('berjalan')" 
                    class="px-3 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="play" class="w-3.5 h-3.5"></i>
                    <span>Set Berjalan</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkSetStatus('selesai')" 
                    class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                    <span>Set Selesai</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkSetStatus('rencana')" 
                    class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                    <span>Set Rencana</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDelete" 
                    wire:confirm="Yakin ingin menghapus {{ count($selectedProker) }} program kerja terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. CONTENT (DATATABLE & GRID CARDS) -->
            @if($tampilanMode === 'tabel')
                <x-table.card>
                    <x-table.table loading-target="cari, filterTahun, filterBidang, filterStatus, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
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
                                    sort-field="nama_kegiatan" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Program Kerja & Sasaran
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="nama_bidang" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-52"
                                >
                                    Bidang & Tahun
                                </x-table.th>
                                <x-table.th 
                                    align="center" 
                                    sortable 
                                    sort-field="bulan_mulai" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-36"
                                >
                                    Jadwal
                                </x-table.th>
                                <x-table.th 
                                    align="right" 
                                    sortable 
                                    sort-field="estimasi_anggaran" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-40"
                                >
                                    Anggaran
                                </x-table.th>
                                <x-table.th 
                                    align="center" 
                                    sortable 
                                    sort-field="status_kegiatan" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-32"
                                >
                                    Status
                                </x-table.th>
                                <x-table.th align="right" class="w-32">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>

                        <x-table.tbody>
                            @forelse($prokerList as $item)
                                <x-table.tr wire:key="row-proker-{{ $item->id }}" :selected="in_array($item->id, $selectedProker)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-3.5 w-10">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedProker" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Program Kerja & Sasaran (With Inline Edit Nama & Sasaran) -->
                                    <x-table.td>
                                        <div class="flex items-start gap-3.5">
                                            <div 
                                                wire:click="bukaPratinjau('{{ $item->id }}')"
                                                class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-200/80 text-amber-700 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs cursor-pointer hover:bg-amber-100 transition-colors"
                                                title="Lihat detail program"
                                            >
                                                <i data-lucide="{{ $item->ikon ?: 'activity' }}" class="w-5 h-5"></i>
                                            </div>

                                            <div class="min-w-0 max-w-lg flex-1">
                                                <!-- Inline Edit Nama Kegiatan -->
                                                <div 
                                                    x-data="{ 
                                                        editing: false, 
                                                        val: '{{ addslashes($item->nama_kegiatan) }}',
                                                        save() {
                                                            if (this.val.trim() !== '' && this.val !== '{{ addslashes($item->nama_kegiatan) }}') {
                                                                $wire.updateFieldInline('{{ $item->id }}', 'nama_kegiatan', this.val);
                                                            }
                                                            this.editing = false;
                                                        }
                                                    }"
                                                >
                                                    <div x-show="!editing" @dblclick="editing = true; $nextTick(() => $refs.namaInput.focus())" class="cursor-pointer group/inline flex items-start gap-1">
                                                        <h3 class="font-black text-slate-900 text-sm leading-snug group-hover/inline:text-amber-600 transition-colors line-clamp-1">
                                                            {{ $item->nama_kegiatan }}
                                                        </h3>
                                                        <i data-lucide="edit-2" class="w-3 h-3 text-slate-300 opacity-0 group-hover/inline:opacity-100 transition-opacity shrink-0 mt-1"></i>
                                                    </div>
                                                    <input 
                                                        x-ref="namaInput"
                                                        x-show="editing" 
                                                        x-model="val" 
                                                        @keydown.enter="save()" 
                                                        @keydown.escape="editing = false; val = '{{ addslashes($item->nama_kegiatan) }}'" 
                                                        @blur="save()"
                                                        type="text" 
                                                        class="w-full px-2 py-0.5 bg-amber-50 border border-amber-300 rounded text-xs font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-amber-500"
                                                    >
                                                </div>

                                                <!-- Inline Edit Target Sasaran -->
                                                <div 
                                                    x-data="{ 
                                                        editing: false, 
                                                        val: '{{ addslashes($item->target_sasaran ?? '') }}',
                                                        save() {
                                                            if (this.val !== '{{ addslashes($item->target_sasaran ?? '') }}') {
                                                                $wire.updateFieldInline('{{ $item->id }}', 'target_sasaran', this.val);
                                                            }
                                                            this.editing = false;
                                                        }
                                                    }"
                                                    class="mt-1"
                                                >
                                                    <div x-show="!editing" @dblclick="editing = true; $nextTick(() => $refs.sasaranInput.focus())" class="cursor-pointer group/inline flex items-center gap-1.5 text-xs text-slate-500">
                                                        <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                                        <span class="truncate">{{ $item->target_sasaran ? 'Sasaran: ' . $item->target_sasaran : '+ Tambah Sasaran' }}</span>
                                                        <i data-lucide="edit-2" class="w-2.5 h-2.5 text-slate-300 opacity-0 group-hover/inline:opacity-100 transition-opacity shrink-0"></i>
                                                    </div>
                                                    <input 
                                                        x-ref="sasaranInput"
                                                        x-show="editing" 
                                                        x-model="val" 
                                                        @keydown.enter="save()" 
                                                        @keydown.escape="editing = false; val = '{{ addslashes($item->target_sasaran ?? '') }}'" 
                                                        @blur="save()"
                                                        type="text" 
                                                        placeholder="Target sasaran peserta..."
                                                        class="w-full px-1.5 py-0.5 bg-amber-50 border border-amber-300 rounded text-[11px] text-slate-900 focus:outline-none focus:ring-1 focus:ring-amber-500"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Bidang & Tahun (With Inline Edit Bidang) -->
                                    <x-table.td>
                                        <div class="space-y-1">
                                            <!-- Inline Edit Bidang -->
                                            <div 
                                                x-data="{ 
                                                    editing: false, 
                                                    val: '{{ addslashes($item->nama_bidang) }}',
                                                    save() {
                                                        if (this.val.trim() !== '' && this.val !== '{{ addslashes($item->nama_bidang) }}') {
                                                            $wire.updateFieldInline('{{ $item->id }}', 'nama_bidang', this.val);
                                                        }
                                                        this.editing = false;
                                                    }
                                                }"
                                            >
                                                <div x-show="!editing" @dblclick="editing = true; $nextTick(() => $refs.bidangInput.focus())" class="cursor-pointer group/inline flex items-center gap-1">
                                                    <span class="font-bold text-slate-800 text-xs block group-hover/inline:text-amber-600">
                                                        {{ $item->nama_bidang }}
                                                    </span>
                                                    <i data-lucide="edit-2" class="w-2.5 h-2.5 text-slate-300 opacity-0 group-hover/inline:opacity-100 transition-opacity"></i>
                                                </div>
                                                <input 
                                                    x-ref="bidangInput"
                                                    x-show="editing" 
                                                    x-model="val" 
                                                    @keydown.enter="save()" 
                                                    @keydown.escape="editing = false; val = '{{ addslashes($item->nama_bidang) }}'" 
                                                    @blur="save()"
                                                    type="text" 
                                                    class="w-full px-1.5 py-0.5 bg-amber-50 border border-amber-300 rounded text-xs font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-amber-500"
                                                >
                                            </div>

                                            <span class="inline-block px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-black text-[10px]">
                                                TA {{ $item->tahun_anggaran }}
                                            </span>
                                        </div>
                                    </x-table.td>

                                    <!-- Jadwal Bulan -->
                                    <x-table.td align="center">
                                        @if($item->bulan_mulai)
                                            <span class="px-2.5 py-1 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-700 font-bold text-xs inline-block">
                                                {{ $item->bulan_mulai_label }}
                                                @if($item->bulan_selesai && $item->bulan_selesai !== $item->bulan_mulai)
                                                    - {{ $item->bulan_selesai_label }}
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-slate-300 font-bold text-xs">-</span>
                                        @endif
                                    </x-table.td>

                                    <!-- Estimasi Anggaran (With Inline Edit Anggaran) -->
                                    <x-table.td align="right">
                                        <div 
                                            x-data="{ 
                                                editing: false, 
                                                val: '{{ (int) $item->estimasi_anggaran }}',
                                                save() {
                                                    if (this.val !== '{{ (int) $item->estimasi_anggaran }}') {
                                                        $wire.updateFieldInline('{{ $item->id }}', 'estimasi_anggaran', this.val);
                                                    }
                                                    this.editing = false;
                                                }
                                            }"
                                        >
                                            <div x-show="!editing" @dblclick="editing = true; $nextTick(() => $refs.anggaranInput.focus())" class="cursor-pointer group/inline inline-flex items-center gap-1 justify-end">
                                                <span class="font-black text-slate-900 text-xs font-mono group-hover/inline:text-amber-600">
                                                    {{ $item->anggaran_rupiah }}
                                                </span>
                                                <i data-lucide="edit-2" class="w-2.5 h-2.5 text-slate-300 opacity-0 group-hover/inline:opacity-100 transition-opacity"></i>
                                            </div>
                                            <input 
                                                x-ref="anggaranInput"
                                                x-show="editing" 
                                                x-model="val" 
                                                @keydown.enter="save()" 
                                                @keydown.escape="editing = false; val = '{{ (int) $item->estimasi_anggaran }}'" 
                                                @blur="save()"
                                                type="number" 
                                                class="w-28 px-1.5 py-0.5 bg-amber-50 border border-amber-300 rounded text-right text-xs font-mono font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-amber-500"
                                            >
                                        </div>
                                    </x-table.td>

                                    <!-- Status Kegiatan (Dropdown Instant) -->
                                    <x-table.td align="center">
                                        <select 
                                            wire:change="updateFieldInline('{{ $item->id }}', 'status_kegiatan', $event.target.value)"
                                            class="text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full border cursor-pointer focus:outline-none focus:ring-1 focus:ring-amber-500 {{ match($item->status_kegiatan) {
                                                'rencana' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'berjalan' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                default => 'bg-rose-50 text-rose-700 border-rose-200'
                                            } }}"
                                        >
                                            <option value="rencana" {{ $item->status_kegiatan === 'rencana' ? 'selected' : '' }}>Rencana</option>
                                            <option value="berjalan" {{ $item->status_kegiatan === 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                                            <option value="selesai" {{ $item->status_kegiatan === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditunda" {{ $item->status_kegiatan === 'ditunda' ? 'selected' : '' }}>Ditunda</option>
                                        </select>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="right">
                                        <div class="flex items-center justify-end gap-1">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="secondary" 
                                                icon="eye" 
                                                wire:click="bukaPratinjau('{{ $item->id }}')" 
                                                title="Lihat Detail Program" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="warning" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdit('{{ $item->id }}')"
                                                wire:click="bukaFormEdit('{{ $item->id }}')" 
                                                title="Edit Data Lengkap" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="secondary" 
                                                icon="copy" 
                                                wire:click="duplikatProker('{{ $item->id }}')" 
                                                title="Duplikat Program" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                wire:click="konfirmasiHapus('{{ $item->id }}')" 
                                                title="Hapus Program" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="7" 
                                    icon="briefcase" 
                                    title="Belum ada data program kerja" 
                                    description="Silakan tambahkan rencana kegiatan dan program kerja KORMI."
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    @if($prokerList->hasPages())
                        <x-slot:footer>
                            <div class="px-4 py-3 flex items-center justify-between">
                                {{ $prokerList->links() }}
                            </div>
                        </x-slot:footer>
                    @endif
                </x-table.card>
            @else
                <!-- Grid View Mode -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($prokerList as $item)
                        @php
                            $statusMap = [
                                'rencana' => ['bg' => 'bg-blue-50 text-blue-700 border-blue-200', 'label' => 'Rencana'],
                                'berjalan' => ['bg' => 'bg-amber-50 text-amber-700 border-amber-200', 'label' => 'Berjalan'],
                                'selesai' => ['bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'label' => 'Selesai'],
                                'ditunda' => ['bg' => 'bg-rose-50 text-rose-700 border-rose-200', 'label' => 'Ditunda'],
                            ];
                            $st = $statusMap[$item->status_kegiatan] ?? ['bg' => 'bg-slate-50 text-slate-700 border-slate-200', 'label' => ucfirst($item->status_kegiatan)];
                        @endphp
                        <div wire:key="grid-proker-{{ $item->id }}" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between group {{ in_array($item->id, $selectedProker) ? 'ring-2 ring-amber-500' : '' }}">
                            <div>
                                <div class="flex items-start justify-between gap-3 mb-3.5">
                                    <div class="flex items-center gap-2">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedProker" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer shadow-xs"
                                        >
                                        <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 font-black text-[10px]">
                                            TA {{ $item->tahun_anggaran }}
                                        </span>
                                    </div>

                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $st['bg'] }}">
                                        {{ $st['label'] }}
                                    </span>
                                </div>

                                <div class="flex items-start gap-3 my-3 cursor-pointer" wire:click="bukaPratinjau('{{ $item->id }}')">
                                    <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs group-hover:scale-105 transition-transform">
                                        <i data-lucide="{{ $item->ikon ?: 'activity' }}" class="w-5 h-5"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="text-sm font-black text-slate-900 group-hover:text-amber-600 transition-colors line-clamp-2 leading-snug">
                                            {{ $item->nama_kegiatan }}
                                        </h3>
                                        <p class="text-xs font-semibold text-slate-500 mt-1">
                                            {{ $item->nama_bidang }}
                                        </p>
                                    </div>
                                </div>

                                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 text-xs">
                                    @if($item->target_sasaran)
                                        <div class="flex justify-between">
                                            <span class="text-slate-400 font-bold">Sasaran:</span>
                                            <span class="font-bold text-slate-700 truncate max-w-[150px]">{{ $item->target_sasaran }}</span>
                                        </div>
                                    @endif
                                    @if($item->bulan_mulai)
                                        <div class="flex justify-between">
                                            <span class="text-slate-400 font-bold">Jadwal:</span>
                                            <span class="font-bold text-slate-700">{{ $item->bulan_mulai_label }}{{ $item->bulan_selesai && $item->bulan_selesai !== $item->bulan_mulai ? ' - ' . $item->bulan_selesai_label : '' }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between pt-1 border-t border-slate-200/60">
                                        <span class="text-slate-400 font-bold">Anggaran:</span>
                                        <span class="font-mono font-black text-emerald-600">{{ $item->anggaran_rupiah }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400">ID: {{ substr($item->id, 0, 8) }}</span>

                                <div class="flex items-center gap-1.5">
                                    <x-table.action-btn 
                                        size="sm"
                                        variant="secondary" 
                                        icon="eye" 
                                        wire:click="bukaPratinjau('{{ $item->id }}')" 
                                        title="Pratinjau Program" 
                                    />
                                    <x-table.action-btn 
                                        size="sm"
                                        variant="warning" 
                                        icon="edit-3" 
                                        wire:click="bukaFormEdit('{{ $item->id }}')" 
                                        title="Edit Program" 
                                    />
                                    <x-table.action-btn 
                                        size="sm"
                                        variant="danger" 
                                        icon="trash-2" 
                                        wire:click="konfirmasiHapus('{{ $item->id }}')" 
                                        title="Hapus Program" 
                                    />
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                            <i data-lucide="briefcase" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                            <p class="text-sm font-bold text-slate-600">Belum ada program kerja yang sesuai filter.</p>
                            <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-amber-600 text-white font-bold text-xs cursor-pointer">
                                + Tambah Program Baru
                            </button>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $prokerList->links() }}
                </div>
            @endif

        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM PROKER (UI KIT)    -->
        <!-- ========================================== -->
        <div wire:key="proker-view-form" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$editId ? 'Edit Data Program Kerja' : 'Tambah Program Kerja Baru'"
                subtitle="Susun rencana kegiatan, alokasi anggaran biaya, target penerima manfaat, dan linimasa jadwal pelaksanaan."
                :badge="$editId ? 'Mode Edit Proker' : 'Proker Baru'"
                icon="briefcase"
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
                        {{ $editId ? 'Perbarui Program' : 'Simpan Program' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT (2 Columns: 8 cols Input + 4 cols Preview & Info) -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Form Data -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Parameter & Rincian Kegiatan" 
                            subtitle="Parameter tahun anggaran, bidang pelaksana, nama kegiatan, dan tujuan strategis."
                            icon="file-text"
                        >
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Tahun Anggaran -->
                                <x-form.field label="Tahun Anggaran" name="tahun_anggaran" :required="true">
                                    <x-form.input 
                                        type="number" 
                                        name="tahun_anggaran" 
                                        wire:model="tahun_anggaran" 
                                        min="2020" 
                                        max="2035"
                                        icon="calendar"
                                    />
                                </x-form.field>

                                <!-- Nama Bidang -->
                                <x-form.field label="Bidang Pelaksana" name="nama_bidang" :required="true">
                                    <x-form.input 
                                        name="nama_bidang" 
                                        wire:model="nama_bidang" 
                                        placeholder="Contoh: Bidang Olahraga Tradisional" 
                                        icon="network"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Quick Suggestions for Bidang -->
                            <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-2xl flex items-center gap-2 flex-wrap">
                                <span class="text-[11px] font-bold text-slate-500">Pilihan Cepat Bidang:</span>
                                @foreach(['Sekretariat', 'Kebendaharaan', 'Bidang Olahraga Tradisional', 'Bidang Olahraga Kesehatan & Kebugaran', 'Bidang Olahraga Petualangan', 'Humas & Publikasi'] as $sampleBidang)
                                    <button 
                                        type="button" 
                                        wire:click="$set('nama_bidang', '{{ $sampleBidang }}')"
                                        class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-amber-50 hover:text-amber-700 hover:border-amber-200 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                                    >
                                        <span>{{ $sampleBidang }}</span>
                                    </button>
                                @endforeach
                            </div>

                            <!-- Nama Kegiatan -->
                            <x-form.field label="Nama Program / Kegiatan" name="nama_kegiatan" :required="true">
                                <x-form.input 
                                    name="nama_kegiatan" 
                                    wire:model="nama_kegiatan" 
                                    placeholder="Contoh: Festival Olahraga Rekreasi Tradisional Tingkat Kabupaten Bandung 2026..." 
                                    size="lg"
                                />
                            </x-form.field>

                            <!-- Tujuan Kegiatan -->
                            <x-form.field label="Tujuan & Latar Belakang" name="tujuan_kegiatan">
                                <x-form.textarea 
                                    name="tujuan_kegiatan" 
                                    wire:model="tujuan_kegiatan" 
                                    rows="3" 
                                    placeholder="Uraikan target capaian, latar belakang urgensi program, dan hasil yang diharapkan..."
                                />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Target Sasaran -->
                                <x-form.field label="Target Sasaran Peserta" name="target_sasaran">
                                    <x-form.input 
                                        name="target_sasaran" 
                                        wire:model="target_sasaran" 
                                        placeholder="Contoh: Pelajar, Lansia, Komunitas Inorga..." 
                                        icon="users"
                                    />
                                </x-form.field>

                                <!-- Estimasi Anggaran -->
                                <x-form.field label="Estimasi Anggaran (Rp)" name="estimasi_anggaran">
                                    <x-form.input 
                                        type="number" 
                                        name="estimasi_anggaran" 
                                        wire:model="estimasi_anggaran" 
                                        step="10000" 
                                        min="0" 
                                        placeholder="Contoh: 75000000" 
                                        icon="dollar-sign"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Jadwal Pelaksanaan -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Bulan Mulai" name="bulan_mulai">
                                    <x-form.select name="bulan_mulai" wire:model="bulan_mulai">
                                        <option value="">-- Pilih Bulan Mulai --</option>
                                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $idx => $bln)
                                            <option value="{{ $idx + 1 }}">{{ $bln }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <x-form.field label="Bulan Selesai" name="bulan_selesai">
                                    <x-form.select name="bulan_selesai" wire:model="bulan_selesai">
                                        <option value="">-- Pilih Bulan Selesai --</option>
                                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $idx => $bln)
                                            <option value="{{ $idx + 1 }}">{{ $bln }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>
                            </div>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Status & Ikon Settings -->
                    <div class="lg:col-span-4 space-y-6">
                        <x-form.card 
                            title="Status & Pengaturan Visual" 
                            subtitle="Status realisasi tahapan dan ikon kegiatan."
                            icon="settings"
                        >
                            <!-- Status Kegiatan -->
                            <x-form.field label="Status Realisasi" name="status_kegiatan" :required="true">
                                <x-form.select name="status_kegiatan" wire:model="status_kegiatan">
                                    <option value="rencana">Rencana</option>
                                    <option value="berjalan">Sedang Berjalan</option>
                                    <option value="selesai">Selesai Terlaksana</option>
                                    <option value="ditunda">Ditunda</option>
                                </x-form.select>
                            </x-form.field>

                            <!-- Ikon Visual -->
                            <x-form.field label="Ikon Kegiatan (Lucide)" name="ikon">
                                <x-form.select name="ikon" wire:model="ikon">
                                    <option value="activity">Activity (Standar)</option>
                                    <option value="trophy">Trophy (Kejuaraan/Festival)</option>
                                    <option value="award">Award (Penghargaan)</option>
                                    <option value="target">Target (Pelatihan/Bimtek)</option>
                                    <option value="users">Users (Komunitas/Sosialisasi)</option>
                                    <option value="map-pin">Map Pin (Wilayah/Ekspedisi)</option>
                                    <option value="calendar">Calendar (Agenda Rutin)</option>
                                    <option value="zap">Zap (Aksi Cepat)</option>
                                </x-form.select>
                            </x-form.field>
                        </x-form.card>

                        <!-- Guide Information Card -->
                        <div class="bg-amber-50/70 border border-amber-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-amber-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="info" class="w-4 h-4 text-amber-600"></i>
                                <span>Alur Program Kerja</span>
                            </h4>
                            <p class="text-xs text-amber-950 leading-relaxed">
                                Program kerja yang disetujui akan dipublikasikan ke portal utama KORMI sebagai bentuk transparansi rencana aksi pembinaan olahraga rekreasi masyarakat di Kabupaten Bandung.
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
                        {{ $editId ? 'Perbarui Program' : 'Simpan Program ke Database' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

    <!-- ========================================================= -->
    <!-- MODAL: PRATINJAU KARTU DETAIL PROGRAM KERJA               -->
    <!-- ========================================================= -->
    @if($tampilkanModalPratinjau && $pratinjauProker)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i data-lucide="{{ $pratinjauProker->ikon ?: 'briefcase' }}" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">Detail Program Kerja KORMI</h3>
                            <p class="text-[10px] text-slate-400">Tahun Anggaran {{ $pratinjauProker->tahun_anggaran }} • {{ $pratinjauProker->nama_bidang }}</p>
                        </div>
                    </div>
                    <button type="button" wire:click="tutupPratinjau" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto space-y-5">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700">
                                TA {{ $pratinjauProker->tahun_anggaran }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ match($pratinjauProker->status_kegiatan) {
                                'rencana' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                'berjalan' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                'selesai' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                default => 'bg-rose-50 text-rose-700 border border-rose-200'
                            } }}">
                                {{ ucfirst($pratinjauProker->status_kegiatan) }}
                            </span>
                        </div>
                        <h2 class="text-lg font-black text-slate-900 leading-snug">{{ $pratinjauProker->nama_kegiatan }}</h2>
                        <p class="text-xs font-bold text-amber-700">{{ $pratinjauProker->nama_bidang }}</p>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Estimasi Anggaran</span>
                            <span class="font-bold text-emerald-600 font-mono">{{ $pratinjauProker->anggaran_rupiah }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Jadwal Pelaksanaan</span>
                            <span class="font-bold text-slate-800">
                                {{ $pratinjauProker->bulan_mulai_label ?? '-' }}{{ $pratinjauProker->bulan_selesai && $pratinjauProker->bulan_selesai !== $pratinjauProker->bulan_mulai ? ' - ' . $pratinjauProker->bulan_selesai_label : '' }}
                            </span>
                        </div>
                        @if($pratinjauProker->target_sasaran)
                            <div class="col-span-2">
                                <span class="text-[10px] text-slate-400 font-bold uppercase block">Target Sasaran</span>
                                <span class="font-bold text-slate-800">{{ $pratinjauProker->target_sasaran }}</span>
                            </div>
                        @endif
                    </div>

                    @if($pratinjauProker->tujuan_kegiatan)
                        <div class="space-y-1.5">
                            <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider">Tujuan & Latar Belakang:</h4>
                            <p class="text-xs text-slate-600 leading-relaxed p-3.5 rounded-2xl bg-amber-50/50 border border-amber-100 whitespace-pre-line">
                                {{ $pratinjauProker->tujuan_kegiatan }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <button 
                        type="button" 
                        wire:click="bukaFormEdit('{{ $pratinjauProker->id }}')" 
                        class="px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer flex items-center gap-1.5"
                    >
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                        <span>Edit Data Program</span>
                    </button>

                    <button 
                        type="button" 
                        wire:click="tutupPratinjau" 
                        class="px-5 py-2 rounded-xl bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider hover:bg-slate-300 transition-colors cursor-pointer"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================= -->
    <!-- MODAL: KONFIRMASI HAPUS PROKER                            -->
    <!-- ========================================================= -->
    @if($tampilkanModalHapus)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden border border-slate-100 p-6 sm:p-7 space-y-6 text-center">
                <div class="w-14 h-14 rounded-3xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto shadow-sm">
                    <i data-lucide="alert-triangle" class="w-7 h-7"></i>
                </div>

                <div class="space-y-2">
                    <h3 class="text-lg font-black text-slate-900">Hapus Program Kerja?</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Apakah Anda yakin ingin menghapus program kerja <br>
                        <span class="font-bold text-slate-900 italic">"{{ $hapusNama }}"</span>?
                    </p>
                    <p class="text-[11px] text-rose-600 font-medium">Data yang dihapus tidak dapat dipulihkan kembali.</p>
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
                        <span>Ya, Hapus Data</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
