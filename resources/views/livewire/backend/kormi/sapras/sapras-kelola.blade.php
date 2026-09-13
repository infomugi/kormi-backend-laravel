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
        <!-- VIEW MODE: TABEL DAFTAR SARANA PRASARANA  -->
        <!-- ========================================== -->
        <div wire:key="sapras-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola Sarana & Prasarana Olahraga"
                subtitle="Direktori stadion, GOR, lapangan terbuka, lintasan, dan taman kebugaran masyarakat se-Kabupaten Bandung."
                badge="Infrastruktur & Venue • Sarana & Prasarana"
                icon="building-2"
                color="emerald"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormTambah"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4 transition-transform group-hover:rotate-90 duration-200"></i>
                        <span>Tambah Fasilitas Baru</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Fasilitas"
                    :value="number_format($totalFasilitas)"
                    unit="Venue"
                    subtitle="Semua titik sarana olahraga"
                    icon="building-2"
                    color="emerald"
                    :active="$kategoriDipilih === 'Semua' && $statusKondisiFilter === 'Semua' && $kecamatanFilter === 'Semua'"
                    loading-target="resetSemuaFilter, setFilterKategori, setFilterStatus, setFilterKecamatan"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Kondisi Baik"
                    :value="number_format($totalKondisiBaik)"
                    unit="Prima"
                    subtitle="Siap dipergunakan"
                    icon="check-circle"
                    color="lime"
                    :pulse="true"
                    :active="$statusKondisiFilter === 'Baik'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('Baik')"
                />

                <x-table.stats-card
                    title="Perlu Renovasi"
                    :value="number_format($totalRenovasi)"
                    unit="Perbaikan"
                    subtitle="Memerlukan pemeliharaan"
                    icon="alert-circle"
                    color="amber"
                    :active="$statusKondisiFilter === 'Perlu Renovasi'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('Perlu Renovasi')"
                />

                <x-table.stats-card
                    title="Sebaran Wilayah"
                    :value="number_format($totalKecamatan)"
                    unit="Kecamatan"
                    subtitle="Cakupan titik venue"
                    icon="map-pin"
                    color="purple"
                    loading-target="cari, setFilterKategori"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar search-placeholder="Cari nama fasilitas, alamat, jenis cabor..." search-model="cari">
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                        @foreach(['Semua', 'Stadion', 'Lapangan', 'GOR', 'Kolam Renang', 'Lintasan', 'Taman Olahraga'] as $kat)
                            <button 
                                type="button"
                                wire:click="setFilterKategori('{{ $kat }}')" 
                                class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $kategoriDipilih === $kat ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                            >
                                <span>{{ $kat }}</span>
                            </button>
                        @endforeach
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <!-- Kecamatan Filter -->
                    <select wire:model.live="kecamatanFilter" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer max-w-[170px]">
                        <option value="Semua">Semua Kecamatan</option>
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                        @endforeach
                    </select>

                    <!-- Kondisi Filter -->
                    <select wire:model.live="statusKondisiFilter" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="Semua">Semua Kondisi</option>
                        <option value="Baik">Baik (Siap Pakai)</option>
                        <option value="Perlu Renovasi">Perlu Renovasi</option>
                        <option value="Dalam Pembangunan">Dalam Pembangunan</option>
                    </select>

                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="nama_fasilitas">Urutan: Nama Fasilitas</option>
                        <option value="kategori_fasilitas">Urutan: Kategori</option>
                        <option value="status_kondisi">Urutan: Kondisi Fisik</option>
                        <option value="created_at">Urutan: Waktu Input</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="asc">A-Z / Terlama (ASC)</option>
                        <option value="desc">Z-A / Terbaru (DESC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="10">10 / hal</option>
                        <option value="20">20 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>

                    <!-- View Switcher with localStorage persistence -->
                    <div 
                        x-data="{
                            mode: localStorage.getItem('kormi_sapras_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_sapras_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_sapras_view') && localStorage.getItem('kormi_sapras_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_sapras_view'));
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
            <x-table.bulk-bar :count="count($selectedSapras)" label="Fasilitas dipilih" reset-action="resetSelection">
                <button 
                    type="button" 
                    wire:click="bulkSetKondisi('Baik')" 
                    class="px-3 py-1.5 rounded-xl bg-lime-600 hover:bg-lime-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                    <span>Set Kondisi Baik</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkSetKondisi('Perlu Renovasi')" 
                    class="px-3 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                    <span>Set Renovasi</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDelete" 
                    wire:confirm="Yakin ingin menghapus {{ count($selectedSapras) }} data fasilitas terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. CONTENT (DATATABLE & GRID CARDS) -->
            @if($tampilanMode === 'tabel')
                <x-table.card>
                    <x-table.table loading-target="cari, kategoriDipilih, statusKondisiFilter, kecamatanFilter, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
                        <x-table.thead>
                            <tr>
                                <x-table.th align="center" class="w-12 !px-4">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="pilihSemua" 
                                        class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                    >
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="nama_fasilitas" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Informasi Fasilitas & Alamat
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="kategori_fasilitas" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Kategori
                                </x-table.th>
                                <x-table.th>
                                    Kecamatan & Kapasitas
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="status_kondisi" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    align="center"
                                >
                                    Kondisi
                                </x-table.th>
                                <x-table.th align="right">
                                    Aksi
                                </x-table.th>
                            </tr>
                        </x-table.thead>

                        <x-table.tbody>
                            @forelse($saprasList as $item)
                                <tr wire:key="row-sapras-{{ $item->id }}" class="hover:bg-slate-50/80 transition-colors {{ in_array($item->id, $selectedSapras) ? 'bg-emerald-50/40' : '' }}">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedSapras" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Facility Info -->
                                    <x-table.td>
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-14 h-12 rounded-xl bg-slate-100 border border-slate-200/80 overflow-hidden shrink-0 flex items-center justify-center relative">
                                                @if($item->foto_url)
                                                    <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($item->foto_url) }}" alt="{{ $item->nama_fasilitas }}" class="w-full h-full object-cover">
                                                @else
                                                    <i data-lucide="building-2" class="w-5 h-5 text-slate-400"></i>
                                                @endif
                                            </div>
                                            <div class="min-w-0 max-w-sm lg:max-w-md">
                                                <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm hover:text-emerald-600 transition-colors line-clamp-1">
                                                    {{ $item->nama_fasilitas }}
                                                </h4>
                                                <p class="text-[11px] text-slate-400 truncate mt-0.5">
                                                    <i data-lucide="map-pin" class="w-3 h-3 inline text-slate-400"></i> {{ $item->alamat_lengkap }}
                                                </p>
                                                <p class="text-[10px] text-emerald-700 font-semibold truncate mt-0.5">
                                                    Cabor: {{ $item->jenis_olahraga_tersedia }}
                                                </p>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Category -->
                                    <x-table.td>
                                        <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200/80">
                                            {{ $item->kategori_fasilitas }}
                                        </span>
                                    </x-table.td>

                                    <!-- Kecamatan & Capacity -->
                                    <x-table.td>
                                        <div class="space-y-0.5">
                                            <div class="font-bold text-slate-800 text-xs flex items-center gap-1.5">
                                                <i data-lucide="map" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                                <span>{{ $item->kecamatan->nama_kecamatan ?? '-' }}</span>
                                            </div>
                                            <div class="text-[11px] text-slate-500 flex items-center gap-1.5">
                                                <i data-lucide="users" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                                <span>{{ $item->kapasitas ?: 'Tidak dicantumkan' }}</span>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Condition -->
                                    <x-table.td align="center">
                                        @php
                                            $kondisiBadge = match($item->status_kondisi) {
                                                'Baik' => 'bg-lime-100 text-lime-800 border-lime-200/80',
                                                'Perlu Renovasi' => 'bg-amber-100 text-amber-800 border-amber-200/80',
                                                default => 'bg-blue-100 text-blue-800 border-blue-200/80'
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $kondisiBadge }}">
                                            {{ $item->status_kondisi }}
                                        </span>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button 
                                                type="button" 
                                                wire:click="bukaFormEdit('{{ $item->id }}')" 
                                                class="p-2 rounded-xl text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all cursor-pointer" 
                                                title="Edit Fasilitas"
                                            >
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </button>

                                            <button 
                                                type="button" 
                                                wire:click="hapus('{{ $item->id }}')" 
                                                wire:confirm="Yakin ingin menghapus data fasilitas '{{ $item->nama_fasilitas }}'?" 
                                                class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all cursor-pointer" 
                                                title="Hapus Fasilitas"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </x-table.td>
                                </tr>
                            @empty
                                <x-table.empty 
                                    colspan="6" 
                                    title="Tidak Ada Sarana Prasarana" 
                                    description="Belum ada data sarana prasarana olahraga atau pencarian tidak menemukan hasil."
                                    icon="building-2"
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    <x-slot:pagination>
                        {{ $saprasList->links() }}
                    </x-slot:pagination>
                </x-table.card>
            @else
                <!-- GRID VIEW MODE -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @forelse($saprasList as $item)
                        <div wire:key="grid-sapras-{{ $item->id }}" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-all group {{ in_array($item->id, $selectedSapras) ? 'ring-2 ring-emerald-500' : '' }}">
                            <div>
                                <!-- Photo Banner / Placeholder -->
                                <div class="relative h-44 bg-gradient-to-tr from-emerald-950 to-teal-900 overflow-hidden">
                                    @if($item->foto_url)
                                        <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($item->foto_url) }}" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300" alt="{{ $item->nama_fasilitas }}">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-emerald-300/40 p-4 text-center">
                                            <i data-lucide="building-2" class="w-12 h-12 mb-1"></i>
                                            <span class="text-[10px] font-bold uppercase tracking-wider">Tanpa Foto</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>
                                    
                                    <!-- Badges -->
                                    <div class="absolute top-3 left-3 flex items-center gap-1.5">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedSapras" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer shadow-sm"
                                        >
                                        <span class="px-2.5 py-1 rounded-lg bg-black/60 text-white font-bold text-[10px] backdrop-blur-md">
                                            {{ $item->kategori_fasilitas }}
                                        </span>
                                    </div>

                                    <div class="absolute top-3 right-3">
                                        @php
                                            $gridKondisiBadge = match($item->status_kondisi) {
                                                'Baik' => 'bg-lime-400 text-slate-950',
                                                'Perlu Renovasi' => 'bg-amber-400 text-slate-950',
                                                default => 'bg-blue-400 text-slate-950'
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $gridKondisiBadge }}">
                                            {{ $item->status_kondisi }}
                                        </span>
                                    </div>

                                    <!-- Bottom Overlay -->
                                    <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-xs font-semibold">
                                        <span class="flex items-center gap-1.5 truncate">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-lime-400 shrink-0"></i>
                                            <span class="truncate">{{ $item->kecamatan->nama_kecamatan ?? '-' }}</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-5">
                                    <h3 class="font-black text-slate-900 text-base leading-snug line-clamp-2 mb-2 group-hover:text-emerald-700 transition-colors">
                                        {{ $item->nama_fasilitas }}
                                    </h3>
                                    <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-3">
                                        <i data-lucide="map" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                        <span class="truncate">{{ $item->alamat_lengkap }}</span>
                                    </p>

                                    <!-- Quick Stats -->
                                    <div class="grid grid-cols-2 gap-2 pt-3 border-t border-slate-100 text-center">
                                        <div class="p-2 bg-slate-50 rounded-xl">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">Kapasitas</span>
                                            <p class="text-xs font-black text-slate-800 truncate">{{ $item->kapasitas ?: '-' }}</p>
                                        </div>
                                        <div class="p-2 bg-slate-50 rounded-xl">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">Kondisi</span>
                                            <p class="text-xs font-black text-slate-800">{{ $item->status_kondisi }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Actions -->
                            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                                <button wire:click="bukaFormEdit('{{ $item->id }}')" title="Edit Fasilitas" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 hover:text-emerald-700 transition-all cursor-pointer">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <button wire:click="hapus('{{ $item->id }}')" wire:confirm="Yakin ingin menghapus fasilitas ini?" title="Hapus Fasilitas" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition-all cursor-pointer">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center">
                            <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="building" class="w-8 h-8"></i>
                            </div>
                            <h3 class="font-extrabold text-slate-900 text-base">Belum Ada Sarana Prasarana</h3>
                            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Klik tombol "Tambah Fasilitas Baru" untuk mendaftarkan venue atau sarana olahraga baru.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $saprasList->links() }}
                </div>
            @endif
        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM SARANA PRASARANA  -->
        <!-- ========================================== -->
        <div wire:key="sapras-view-form" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$editId ? 'Edit Data Venue / Fasilitas' : 'Registrasi Sarana & Prasarana Olahraga'"
                subtitle="Lengkapi data spesifikasi venue, kapasitas penonton, kondisi fisik, alamat, dan foto dokumentasi."
                :badge="$editId ? 'Mode Edit Venue' : 'Fasilitas Baru'"
                icon="building-2"
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
                        variant="emerald" 
                        size="default" 
                        icon="check" 
                        loading-target="simpan"
                        wire:click="simpan"
                    >
                        {{ $editId ? 'Perbarui Fasilitas' : 'Simpan Fasilitas' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT (2 Columns: 8 cols Metadata + 4 cols Photo Upload & Info) -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Data Fasilitas & Lokasi -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Informasi Utama & Spesifikasi Venue" 
                            subtitle="Identitas sarana olahraga, kategori, wilayah kecamatan, dan kondisi fisik."
                            icon="file-text"
                        >
                            <!-- Nama Fasilitas -->
                            <x-form.field label="Nama Fasilitas / Venue Olahraga" name="nama_fasilitas" :required="true">
                                <x-form.input 
                                    name="nama_fasilitas" 
                                    wire:model="nama_fasilitas" 
                                    placeholder="Contoh: Stadion Si Jalak Harupat, GOR Soreang..." 
                                    size="lg"
                                    class="font-black text-slate-900"
                                />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Kategori Fasilitas -->
                                <x-form.field label="Kategori Fasilitas" name="kategori_fasilitas" :required="true">
                                    <x-form.select name="kategori_fasilitas" wire:model="kategori_fasilitas">
                                        <option value="Stadion">Stadion</option>
                                        <option value="Lapangan">Lapangan</option>
                                        <option value="GOR">GOR</option>
                                        <option value="Kolam Renang">Kolam Renang</option>
                                        <option value="Lintasan">Lintasan</option>
                                        <option value="Taman Olahraga">Taman Olahraga</option>
                                    </x-form.select>
                                </x-form.field>

                                <!-- Kecamatan -->
                                <x-form.field label="Kecamatan Wilayah" name="kecamatan_id" :required="true">
                                    <x-form.select name="kecamatan_id" wire:model="kecamatan_id">
                                        @foreach($kecamatanList as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Kapasitas -->
                                <x-form.field label="Kapasitas Penonton / Pengguna" name="kapasitas">
                                    <x-form.input 
                                        name="kapasitas" 
                                        wire:model="kapasitas" 
                                        placeholder="Contoh: 5.000 penonton, 50 orang..." 
                                        icon="users"
                                    />
                                </x-form.field>

                                <!-- Status Kondisi -->
                                <x-form.field label="Status Kondisi Fisik" name="status_kondisi" :required="true">
                                    <x-form.select name="status_kondisi" wire:model="status_kondisi">
                                        <option value="Baik">Baik (Siap Pakai)</option>
                                        <option value="Perlu Renovasi">Perlu Renovasi</option>
                                        <option value="Dalam Pembangunan">Dalam Pembangunan</option>
                                    </x-form.select>
                                </x-form.field>
                            </div>

                            <!-- Alamat Lengkap -->
                            <x-form.field label="Alamat Lengkap Venue" name="alamat_lengkap" :required="true">
                                <x-form.textarea 
                                    name="alamat_lengkap" 
                                    wire:model="alamat_lengkap" 
                                    rows="3" 
                                    placeholder="Jalan, nomor, RT/RW, desa/kelurahan, dan patokan lokasi..."
                                />
                            </x-form.field>

                            <!-- Jenis Olahraga Tersedia -->
                            <x-form.field label="Jenis Olahraga / Cabor yang Tersedia" name="jenis_olahraga_tersedia" :required="true">
                                <x-form.input 
                                    name="jenis_olahraga_tersedia" 
                                    wire:model="jenis_olahraga_tersedia" 
                                    placeholder="Contoh: Senam Bedas, Egrang, Sepakbola, Atletik, Lari, Panahan..." 
                                    icon="activity"
                                />
                            </x-form.field>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Foto Upload & Info Panduan -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Foto Card -->
                        <x-form.card 
                            title="Foto Utama Venue" 
                            subtitle="Dokumentasi foto fasilitas sarana olahraga."
                            icon="image"
                        >
                            <x-form.image-upload
                                :upload="$uploadFoto"
                                :saved-path="$foto_url"
                                name="uploadFoto"
                                input-id="uploadFotoSapras"
                                empty-title="Unggah Foto Fasilitas"
                                empty-subtitle="Format JPG, PNG, WEBP (Maksimal 10MB)"
                                :max-size-m-b="10"
                                aspect-ratio="h-48 sm:h-56"
                            />
                        </x-form.card>

                        <!-- Guide Information Card -->
                        <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                                <span>Standar Kelayakan Venue</span>
                            </h4>
                            <div class="space-y-2 text-xs text-emerald-950">
                                <div class="bg-white/80 p-2.5 rounded-xl border border-emerald-200/60">
                                    <strong>Kondisi Baik:</strong> Fasilitas aman, terawat, dan siap digunakan masyarakat/event.
                                </div>
                                <div class="bg-white/80 p-2.5 rounded-xl border border-emerald-200/60">
                                    <strong>Perlu Renovasi:</strong> Terdapat kerusakan sarana yang memerlukan penanganan dinas/pengelola.
                                </div>
                            </div>
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
                        variant="emerald" 
                        icon="save" 
                        loading-target="simpan"
                    >
                        {{ $editId ? 'Perbarui Fasilitas' : 'Simpan Fasilitas' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

</div>
