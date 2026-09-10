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
        <!-- VIEW MODE: TABEL KOORDINATOR KECAMATAN     -->
        <!-- ========================================== -->
        <div wire:key="kordik-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola KORDIK Kecamatan"
                subtitle="Daftar koordinator tingkat kecamatan (KORDIK) KORMI se-Kabupaten Bandung per periode masa bakti."
                badge="Kelembagaan & Struktur • Koordinator Kecamatan"
                icon="map-pin"
                color="teal"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormTambah"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-teal-600 via-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-teal-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4 transition-transform group-hover:rotate-90 duration-200"></i>
                        <span>Tambah KORDIK Baru</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total KORDIK"
                    :value="number_format($totalKordik)"
                    unit="Wilayah"
                    subtitle="Seluruh riwayat arsip"
                    icon="users"
                    color="teal"
                    :active="empty($filterPeriode) && $statusFilter === 'Semua'"
                    loading-target="setFilterPeriode, resetSemuaFilter"
                    wire:click="setFilterPeriode('')"
                />

                <x-table.stats-card
                    title="Cakupan Wilayah"
                    :value="number_format($totalKecamatanTerisi)"
                    unit="/ {{ $totalKecamatan }} Kec"
                    subtitle="Kecamatan terisi kordik"
                    icon="map-pin"
                    color="blue"
                    loading-target="filterPeriode"
                />

                <x-table.stats-card
                    title="KORDIK Aktif"
                    :value="number_format($totalAktif)"
                    unit="Aktif"
                    subtitle="Struktur operasional"
                    icon="shield-check"
                    color="emerald"
                    :pulse="true"
                    :active="$statusFilter === 'Aktif'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('Aktif')"
                />

                <x-table.stats-card
                    title="Non-Aktif / Draf"
                    :value="number_format($totalNonAktif)"
                    unit="Draf"
                    subtitle="Masa bakti selesai"
                    icon="shield-off"
                    color="slate"
                    :active="$statusFilter === 'Non-Aktif'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('Non-Aktif')"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                search-placeholder="Cari kecamatan, nama ketua, sekretaris, bendahara, no SK..." 
                search-model="cari"
            >
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                        <button 
                            type="button"
                            wire:click="setFilterPeriode('')" 
                            class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ empty($filterPeriode) ? 'bg-teal-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                            <span>Semua Periode</span>
                        </button>

                        @foreach($periodeList as $p)
                            <button 
                                type="button"
                                wire:click="setFilterPeriode('{{ $p->id }}')" 
                                class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $filterPeriode === $p->id ? 'bg-teal-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                            >
                                <span>{{ $p->nama_periode }} ({{ $p->tahun_mulai }}-{{ $p->tahun_selesai }})</span>
                                @if($p->status_aktif)
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <!-- Filter Kecamatan -->
                    <select wire:model.live="filterKecamatan" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all cursor-pointer max-w-xs">
                        <option value="semua">Semua Kecamatan</option>
                        @foreach($kecamatanList as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
                        @endforeach
                    </select>

                    <!-- Filter Status -->
                    <select wire:model.live="statusFilter" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all cursor-pointer">
                        <option value="Semua">Semua Status</option>
                        <option value="Aktif">KORDIK Aktif</option>
                        <option value="Non-Aktif">Non-Aktif / Demisioner</option>
                    </select>

                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all cursor-pointer">
                        <option value="dibuat_pada">Urutan: Waktu Input</option>
                        <option value="nama_ketua">Urutan: Nama Ketua</option>
                        <option value="status_aktif">Urutan: Status Keaktifan</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all cursor-pointer">
                        <option value="desc">Terbaru / Z-A (DESC)</option>
                        <option value="asc">Terlama / A-Z (ASC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all cursor-pointer">
                        <option value="10">10 / hal</option>
                        <option value="20">20 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>

                    <!-- View Switcher -->
                    <div 
                        x-data="{
                            mode: localStorage.getItem('kormi_kordik_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_kordik_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_kordik_view') && localStorage.getItem('kormi_kordik_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_kordik_view'));
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
            <x-table.bulk-bar :count="count($selectedKordik)" label="KORDIK dipilih" reset-action="resetSelection">
                <button 
                    type="button" 
                    wire:click="bulkSetStatus(true)" 
                    class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                    <span>Aktifkan</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkSetStatus(false)" 
                    class="px-3 py-1.5 rounded-xl bg-slate-700 hover:bg-slate-800 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="shield-off" class="w-3.5 h-3.5"></i>
                    <span>Non-Aktifkan</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDelete" 
                    wire:confirm="Yakin ingin menghapus {{ count($selectedKordik) }} data koordinator kecamatan terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. CONTENT (DATATABLE & GRID CARDS) -->
            @if($tampilanMode === 'tabel')
                <x-table.card>
                    <x-table.table loading-target="cari, filterPeriode, filterKecamatan, statusFilter, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
                        <x-table.thead>
                            <tr>
                                <x-table.th align="center" class="w-12 !px-4">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="pilihSemua" 
                                        class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 cursor-pointer"
                                    >
                                </x-table.th>
                                <x-table.th class="w-52">Wilayah Kecamatan</x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="nama_ketua" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Pengurus Inti (KSB)
                                </x-table.th>
                                <x-table.th class="w-40">Kontak & SK</x-table.th>
                                <x-table.th align="center" class="w-36">Periode</x-table.th>
                                <x-table.th 
                                    align="center"
                                    sortable 
                                    sort-field="status_aktif" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-28"
                                >
                                    Status
                                </x-table.th>
                                <x-table.th align="center" class="w-28">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>

                        <x-table.tbody>
                            @forelse($kordikList as $item)
                                <x-table.tr :selected="in_array($item->id, $selectedKordik)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedKordik" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Wilayah Kecamatan -->
                                    <x-table.td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-2xl bg-teal-50 border border-teal-200/80 text-teal-700 flex items-center justify-center shrink-0">
                                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-black text-slate-900 text-sm">
                                                    Kec. {{ $item->kecamatan?->nama_kecamatan ?? '-' }}
                                                </h3>
                                                <p class="text-[11px] text-slate-400 font-mono">
                                                    Kode: {{ $item->kecamatan?->kode_kecamatan ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Pengurus Inti KSB -->
                                    <x-table.td>
                                        <div class="flex items-start gap-3.5">
                                            @if($item->foto_ketua_url)
                                                <div class="w-11 h-11 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 shadow-2xs">
                                                    <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($item->foto_ketua_url) }}" class="w-full h-full object-cover" alt="{{ $item->nama_ketua }}">
                                                </div>
                                            @else
                                                <div class="w-11 h-11 rounded-2xl bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center shrink-0 font-black text-xs shadow-2xs">
                                                    {{ strtoupper(substr($item->nama_ketua, 0, 2)) }}
                                                </div>
                                            @endif

                                            <div class="space-y-1 min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <span class="px-2 py-0.5 rounded-md bg-teal-100 text-teal-800 text-[10px] font-black uppercase">Ketua</span>
                                                    <span class="font-black text-slate-900 text-xs">{{ $item->nama_ketua }}</span>
                                                </div>
                                                @if($item->nama_sekretaris)
                                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold">Sekr</span>
                                                        <span class="truncate">{{ $item->nama_sekretaris }}</span>
                                                    </div>
                                                @endif
                                                @if($item->nama_bendahara)
                                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold">Bend</span>
                                                        <span class="truncate">{{ $item->nama_bendahara }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Kontak & SK -->
                                    <x-table.td>
                                        <div class="space-y-1 text-xs">
                                            @if($item->nomor_telepon)
                                                <div class="flex items-center gap-1.5 text-slate-700">
                                                    <i data-lucide="phone" class="w-3.5 h-3.5 text-teal-600"></i>
                                                    <span>{{ $item->nomor_telepon }}</span>
                                                </div>
                                            @endif
                                            @if($item->nomor_sk)
                                                <div class="flex items-center gap-1.5 text-slate-500 text-[11px]">
                                                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-slate-400"></i>
                                                    <span class="truncate">{{ $item->nomor_sk }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </x-table.td>

                                    <!-- Periode -->
                                    <x-table.td align="center">
                                        <span class="px-2.5 py-1 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-700 font-bold text-xs inline-block">
                                            {{ $item->periode?->nama_periode ?? '-' }}
                                        </span>
                                    </x-table.td>

                                    <!-- Status Aktif -->
                                    <x-table.td align="center">
                                        <button 
                                            type="button" 
                                            wire:click="toggleStatus('{{ $item->id }}')" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer border {{ $item->status_aktif ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200' }}"
                                            title="Klik untuk mengubah status aktif KORDIK"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full {{ $item->status_aktif ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            <span>{{ $item->status_aktif ? 'Aktif' : 'Non-Aktif' }}</span>
                                        </button>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="primary" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdit('{{ $item->id }}')"
                                                wire:click="bukaFormEdit('{{ $item->id }}')" 
                                                title="Edit KORDIK" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="hapus('{{ $item->id }}')"
                                                wire:click="hapus('{{ $item->id }}')" 
                                                wire:confirm="Yakin ingin menghapus data koordinator kecamatan ini?" 
                                                title="Hapus KORDIK" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="7" 
                                    icon="users" 
                                    title="Belum ada data koordinator kecamatan" 
                                    description="Silakan tambahkan struktur personil KORDIK di setiap kecamatan."
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    @if($kordikList->hasPages())
                        <x-slot:footer>
                            <div class="px-4 py-3 flex items-center justify-between">
                                {{ $kordikList->links() }}
                            </div>
                        </x-slot:footer>
                    @endif
                </x-table.card>
            @else
                <!-- Grid View Mode -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($kordikList as $item)
                        <div wire:key="grid-kordik-{{ $item->id }}" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between group {{ in_array($item->id, $selectedKordik) ? 'ring-2 ring-teal-500' : '' }}">
                            <div>
                                <div class="flex items-start justify-between gap-3 mb-4">
                                    <div class="flex items-center gap-2">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedKordik" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 cursor-pointer shadow-xs"
                                        >
                                        <span class="px-3 py-1 rounded-2xl bg-teal-50 text-teal-800 border border-teal-200 font-black text-xs">
                                            Kec. {{ $item->kecamatan?->nama_kecamatan ?? '-' }}
                                        </span>
                                    </div>

                                    <button 
                                        type="button" 
                                        wire:click="toggleStatus('{{ $item->id }}')" 
                                        class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $item->status_aktif ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' }}"
                                    >
                                        {{ $item->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                                    </button>
                                </div>

                                <div class="flex items-start gap-3.5 mb-4">
                                    @if($item->foto_ketua_url)
                                        <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 shadow-2xs">
                                            <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($item->foto_ketua_url) }}" class="w-full h-full object-cover" alt="{{ $item->nama_ketua }}">
                                        </div>
                                    @else
                                        <div class="w-16 h-16 rounded-2xl bg-teal-50 border border-teal-200 text-teal-700 flex items-center justify-center font-black text-lg shrink-0 shadow-2xs">
                                            {{ strtoupper(substr($item->nama_ketua, 0, 2)) }}
                                        </div>
                                    @endif

                                    <div class="min-w-0 space-y-1">
                                        <p class="text-[10px] font-black uppercase text-teal-600 tracking-wider">Ketua KORDIK</p>
                                        <h3 class="text-sm font-black text-slate-900 group-hover:text-teal-600 transition-colors line-clamp-1">
                                            {{ $item->nama_ketua }}
                                        </h3>
                                        @if($item->nomor_telepon)
                                            <p class="text-xs text-slate-500 flex items-center gap-1">
                                                <i data-lucide="phone" class="w-3 h-3 text-teal-600"></i>
                                                <span>{{ $item->nomor_telepon }}</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-slate-400 font-bold">Sekretaris:</span>
                                        <span class="font-bold text-slate-700 truncate max-w-[150px]">{{ $item->nama_sekretaris ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-400 font-bold">Bendahara:</span>
                                        <span class="font-bold text-slate-700 truncate max-w-[150px]">{{ $item->nama_bendahara ?: '-' }}</span>
                                    </div>
                                    @if($item->nomor_sk)
                                        <div class="flex justify-between pt-1 border-t border-slate-200/60">
                                            <span class="text-slate-400 font-bold">No. SK:</span>
                                            <span class="font-mono text-[11px] text-slate-600 truncate max-w-[150px]">{{ $item->nomor_sk }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400">{{ $item->periode?->nama_periode ?? '-' }}</span>

                                <div class="flex items-center gap-1.5">
                                    <button wire:click="bukaFormEdit('{{ $item->id }}')" title="Edit KORDIK" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-teal-50 hover:text-teal-600 transition-all cursor-pointer">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <button wire:click="hapus('{{ $item->id }}')" wire:confirm="Yakin ingin menghapus kordik ini?" title="Hapus KORDIK" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition-all cursor-pointer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                            <i data-lucide="map-pin" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                            <p class="text-sm font-bold text-slate-600">Belum ada data koordinator kecamatan yang sesuai filter.</p>
                            <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-teal-600 text-white font-bold text-xs cursor-pointer">
                                + Tambah KORDIK Baru
                            </button>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $kordikList->links() }}
                </div>
            @endif

        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM KORDIK (UI KIT)    -->
        <!-- ========================================== -->
        <div wire:key="kordik-view-form" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$editId ? 'Edit Koordinator Kecamatan' : 'Tambah Koordinator Kecamatan Baru'"
                subtitle="Susun susunan kepengurusan koordinator kecamatan (Ketua, Sekretaris, Bendahara) dan legalitas SK."
                :badge="$editId ? 'Mode Edit KORDIK' : 'KORDIK Baru'"
                icon="map-pin"
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
                        loading-target="simpan"
                        wire:click="simpan"
                    >
                        {{ $editId ? 'Perbarui KORDIK' : 'Simpan KORDIK' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT (2 Columns: 8 cols Input + 4 cols Foto & Info) -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Form Data -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Wilayah & Personil Pengurus" 
                            subtitle="Parameter wilayah kecamatan, masa bakti, dan susunan kepengurusan inti KORDIK."
                            icon="user-check"
                        >
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Kecamatan -->
                                <x-form.field label="Wilayah Kecamatan" name="kecamatan_id" :required="true">
                                    <x-form.select name="kecamatan_id" wire:model="kecamatan_id">
                                        @foreach($kecamatanList as $kec)
                                            <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <!-- Periode -->
                                <x-form.field label="Periode Masa Bakti" name="periode_id" :required="true">
                                    <x-form.select name="periode_id" wire:model="periode_id">
                                        @foreach($periodeList as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama_periode }} ({{ $p->tahun_mulai }}-{{ $p->tahun_selesai }}) {{ $p->status_aktif ? '★ [Aktif]' : '' }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>
                            </div>

                            <!-- Nama Ketua -->
                            <x-form.field label="Nama Ketua KORDIK" name="nama_ketua" :required="true">
                                <x-form.input 
                                    name="nama_ketua" 
                                    wire:model="nama_ketua" 
                                    placeholder="Nama lengkap ketua koordinator kecamatan..." 
                                    icon="user"
                                />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Nama Sekretaris -->
                                <x-form.field label="Nama Sekretaris" name="nama_sekretaris">
                                    <x-form.input 
                                        name="nama_sekretaris" 
                                        wire:model="nama_sekretaris" 
                                        placeholder="Nama lengkap sekretaris..." 
                                        icon="user-check"
                                    />
                                </x-form.field>

                                <!-- Nama Bendahara -->
                                <x-form.field label="Nama Bendahara" name="nama_bendahara">
                                    <x-form.input 
                                        name="nama_bendahara" 
                                        wire:model="nama_bendahara" 
                                        placeholder="Nama lengkap bendahara..." 
                                        icon="user-check"
                                    />
                                </x-form.field>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Nomor Telepon -->
                                <x-form.field label="Nomor Telepon / WhatsApp" name="nomor_telepon">
                                    <x-form.input 
                                        name="nomor_telepon" 
                                        wire:model="nomor_telepon" 
                                        placeholder="Contoh: 081234567890" 
                                        icon="phone"
                                    />
                                </x-form.field>

                                <!-- Nomor SK -->
                                <x-form.field label="Nomor SK Pengukuhan" name="nomor_sk">
                                    <x-form.input 
                                        name="nomor_sk" 
                                        wire:model="nomor_sk" 
                                        placeholder="Contoh: SK/012/KORMI-KB/2024" 
                                        icon="file-text"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Status Aktif Toggle -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <label for="statusAktifKordik" class="text-xs font-black text-slate-900 cursor-pointer">Status Kepengurusan Aktif</label>
                                    <p class="text-xs text-slate-500">Struktur koordinator kecamatan aktif akan ditampilkan pada direktori wilayah portal publik.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="statusAktifKordik" wire:model="status_aktif" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                                </label>
                            </div>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Foto Ketua & Info -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Foto Card -->
                        <x-form.card 
                            title="Foto Ketua KORDIK" 
                            subtitle="Foto resmi ketua koordinator kecamatan."
                            icon="image"
                        >
                            <x-form.image-upload
                                :upload="$uploadFoto"
                                :saved-path="$foto_ketua_url"
                                name="uploadFoto"
                                input-id="uploadFotoKetuaKordik"
                                empty-title="Unggah Foto Ketua KORDIK"
                                empty-subtitle="Format JPG, PNG, WEBP (Maksimal 10MB)"
                                :max-size-m-b="10"
                                aspect-ratio="h-60 sm:h-72"
                            />
                        </x-form.card>

                        <!-- Guide Information Card -->
                        <div class="bg-teal-50/70 border border-teal-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-teal-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="info" class="w-4 h-4 text-teal-600"></i>
                                <span>Peran KORDIK</span>
                            </h4>
                            <p class="text-xs text-teal-950 leading-relaxed">
                                Koordinator Kecamatan (KORDIK) bertindak sebagai perpanjangan tangan KORMI Kabupaten Bandung dalam menggerakkan, memantau, dan mengembangkan olahraga rekreasi masyarakat hingga ke tingkat desa dan kelurahan.
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
                        variant="primary" 
                        icon="save" 
                        loading-target="simpan"
                    >
                        {{ $editId ? 'Perbarui KORDIK' : 'Simpan KORDIK' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

</div>
