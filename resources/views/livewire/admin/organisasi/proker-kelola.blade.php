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

                    <!-- View Switcher -->
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
                                    class="w-48"
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
                                    class="w-36"
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
                                <x-table.th align="center" class="w-28">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>

                        <x-table.tbody>
                            @forelse($prokerList as $item)
                                <x-table.tr :selected="in_array($item->id, $selectedProker)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedProker" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Program Kerja & Sasaran -->
                                    <x-table.td>
                                        <div class="flex items-start gap-3.5">
                                            <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-200/80 text-amber-700 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                                                <i data-lucide="{{ $item->ikon ?: 'activity' }}" class="w-5 h-5"></i>
                                            </div>

                                            <div class="min-w-0">
                                                <h3 class="font-black text-slate-900 text-sm leading-snug group-hover:text-amber-600 transition-colors">
                                                    {{ $item->nama_kegiatan }}
                                                </h3>
                                                @if($item->target_sasaran)
                                                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                                        <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i>
                                                        <span>Sasaran: {{ $item->target_sasaran }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Bidang & Tahun -->
                                    <x-table.td>
                                        <div class="space-y-1">
                                            <span class="font-bold text-slate-800 text-xs block">
                                                {{ $item->nama_bidang }}
                                            </span>
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

                                    <!-- Estimasi Anggaran -->
                                    <x-table.td align="right">
                                        <span class="font-black text-slate-900 text-xs font-mono">
                                            {{ $item->anggaran_rupiah }}
                                        </span>
                                    </x-table.td>

                                    <!-- Status Kegiatan -->
                                    <x-table.td align="center">
                                        @php
                                            $statusMap = [
                                                'rencana' => ['bg' => 'bg-blue-50 text-blue-700 border-blue-200', 'dot' => 'bg-blue-500', 'label' => 'Rencana'],
                                                'berjalan' => ['bg' => 'bg-amber-50 text-amber-700 border-amber-200', 'dot' => 'bg-amber-500', 'label' => 'Berjalan'],
                                                'selesai' => ['bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500', 'label' => 'Selesai'],
                                                'ditunda' => ['bg' => 'bg-rose-50 text-rose-700 border-rose-200', 'dot' => 'bg-rose-500', 'label' => 'Ditunda'],
                                            ];
                                            $st = $statusMap[$item->status_kegiatan] ?? ['bg' => 'bg-slate-50 text-slate-700 border-slate-200', 'dot' => 'bg-slate-500', 'label' => ucfirst($item->status_kegiatan)];
                                        @endphp
                                        <div 
                                            x-data="{ open: false }" 
                                            class="relative inline-block text-left"
                                        >
                                            <button 
                                                @click="open = !open" 
                                                type="button" 
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer border {{ $st['bg'] }} hover:shadow-2xs"
                                                title="Klik untuk ubah status"
                                            >
                                                <span class="w-1.5 h-1.5 rounded-full {{ $st['dot'] }}"></span>
                                                <span>{{ $st['label'] }}</span>
                                                <i data-lucide="chevron-down" class="w-2.5 h-2.5 opacity-60"></i>
                                            </button>

                                            <div 
                                                x-show="open" 
                                                @click.outside="open = false" 
                                                x-transition 
                                                class="absolute right-0 z-30 mt-1 w-32 origin-top-right rounded-2xl bg-white p-1.5 shadow-lg border border-slate-200 text-left"
                                                style="display: none;"
                                            >
                                                <button type="button" wire:click="updateStatus('{{ $item->id }}', 'rencana')" @click="open = false" class="w-full text-left px-2.5 py-1.5 rounded-xl text-xs font-bold text-blue-700 hover:bg-blue-50 cursor-pointer flex items-center gap-2">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Rencana
                                                </button>
                                                <button type="button" wire:click="updateStatus('{{ $item->id }}', 'berjalan')" @click="open = false" class="w-full text-left px-2.5 py-1.5 rounded-xl text-xs font-bold text-amber-700 hover:bg-amber-50 cursor-pointer flex items-center gap-2">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Berjalan
                                                </button>
                                                <button type="button" wire:click="updateStatus('{{ $item->id }}', 'selesai')" @click="open = false" class="w-full text-left px-2.5 py-1.5 rounded-xl text-xs font-bold text-emerald-700 hover:bg-emerald-50 cursor-pointer flex items-center gap-2">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                                </button>
                                                <button type="button" wire:click="updateStatus('{{ $item->id }}', 'ditunda')" @click="open = false" class="w-full text-left px-2.5 py-1.5 rounded-xl text-xs font-bold text-rose-700 hover:bg-rose-50 cursor-pointer flex items-center gap-2">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditunda
                                                </button>
                                            </div>
                                        </div>
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
                                                title="Edit Program" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="hapus('{{ $item->id }}')"
                                                wire:click="hapus('{{ $item->id }}')" 
                                                wire:confirm="Yakin ingin menghapus program kerja ini?" 
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

                                <div class="flex items-start gap-3 my-3">
                                    <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
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
                                    <button wire:click="bukaFormEdit('{{ $item->id }}')" title="Edit Program" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-amber-50 hover:text-amber-600 transition-all cursor-pointer">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <button wire:click="hapus('{{ $item->id }}')" wire:confirm="Yakin ingin menghapus program ini?" title="Hapus Program" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition-all cursor-pointer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
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
                                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $idx => $mName)
                                            <option value="{{ $idx + 1 }}">{{ $mName }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <x-form.field label="Bulan Selesai" name="bulan_selesai">
                                    <x-form.select name="bulan_selesai" wire:model="bulan_selesai">
                                        <option value="">-- Pilih Bulan Selesai --</option>
                                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $idx => $mName)
                                            <option value="{{ $idx + 1 }}">{{ $mName }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>
                            </div>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Status, Ikon & Preview -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Status & Ikon Card -->
                        <x-form.card 
                            title="Status & Simbol Visual" 
                            subtitle="Status pelaksanaan dan ikon grafis program."
                            icon="sliders"
                        >
                            <!-- Status Kegiatan -->
                            <x-form.field label="Status Kegiatan" name="status_kegiatan" :required="true">
                                <x-form.select name="status_kegiatan" wire:model.live="status_kegiatan">
                                    <option value="rencana">Rencana (Tahap Perencanaan)</option>
                                    <option value="berjalan">Berjalan (Sedang Berlangsung)</option>
                                    <option value="selesai">Selesai (Telah Terlaksana)</option>
                                    <option value="ditunda">Ditunda (Pending / Reschedule)</option>
                                </x-form.select>
                            </x-form.field>

                            <!-- Ikon Lucide -->
                            <x-form.field label="Nama Ikon (Lucide)" name="ikon">
                                <x-form.input 
                                    name="ikon" 
                                    wire:model.live.debounce.300ms="ikon" 
                                    placeholder="activity, trophy, flame..." 
                                    icon="smile"
                                />
                            </x-form.field>

                            <!-- Quick Icon Suggestions -->
                            <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-2xl flex items-center gap-2 flex-wrap">
                                @foreach(['activity', 'trophy', 'flame', 'award', 'flag', 'calendar', 'users', 'target'] as $ic)
                                    <button 
                                        type="button" 
                                        wire:click="$set('ikon', '{{ $ic }}')"
                                        class="p-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-amber-50 hover:text-amber-600 hover:border-amber-200 transition-all cursor-pointer shadow-2xs"
                                        title="{{ $ic }}"
                                    >
                                        <i data-lucide="{{ $ic }}" class="w-3.5 h-3.5"></i>
                                    </button>
                                @endforeach
                            </div>
                        </x-form.card>

                        <!-- Live Card Preview -->
                        <x-form.card 
                            title="Pratinjau Kartu" 
                            subtitle="Simulasi visual program kerja."
                            icon="eye"
                        >
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="px-2 py-0.5 rounded-full bg-slate-200 text-slate-700 font-bold text-[10px]">
                                        TA {{ $tahun_anggaran }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $status_kegiatan === 'selesai' ? 'bg-emerald-100 text-emerald-800' : ($status_kegiatan === 'berjalan' ? 'bg-amber-100 text-amber-800' : ($status_kegiatan === 'ditunda' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800')) }}">
                                        {{ ucfirst($status_kegiatan) }}
                                    </span>
                                </div>

                                <div class="flex items-start gap-3 pt-1">
                                    <div class="w-9 h-9 rounded-xl bg-amber-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-amber-600/20">
                                        <i data-lucide="{{ $ikon ?: 'activity' }}" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xs font-black text-slate-900 line-clamp-2">
                                            {{ $nama_kegiatan ?: 'Nama kegiatan program kerja...' }}
                                        </h4>
                                        <p class="text-[11px] text-slate-500 mt-0.5">
                                            {{ $nama_bidang ?: 'Nama Bidang Pelaksana' }}
                                        </p>
                                    </div>
                                </div>

                                @if($estimasi_anggaran)
                                    <div class="pt-2 border-t border-slate-200 flex justify-between text-xs">
                                        <span class="text-slate-400 font-bold">Anggaran:</span>
                                        <span class="font-mono font-black text-emerald-600">Rp {{ number_format($estimasi_anggaran, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>
                        </x-form.card>
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
                        {{ $editId ? 'Perbarui Program' : 'Simpan Program' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

</div>
