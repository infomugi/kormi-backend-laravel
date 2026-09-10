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
        <!-- VIEW MODE: TABEL & KATALOG SDI             -->
        <!-- ========================================== -->
        <div wire:key="sdi-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTIONS (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola SDI & Sertifikasi Instruktur"
                subtitle="Direktori kurikulum pelatihan, sertifikasi juri/wasit/instruktur olahraga rekreasi, dan pendaftaran angkatan batch se-Kabupaten Bandung."
                badge="Sumber Daya Insani • Pelatihan & Sertifikasi"
                icon="graduation-cap"
                color="purple"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormProgramTambah"
                        class="inline-flex items-center justify-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-white hover:bg-slate-50 border border-slate-200/90 text-slate-700 font-bold text-xs shadow-2xs hover:shadow-xs transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="book-plus" class="w-3.5 h-3.5 text-purple-600"></i>
                        <span>Buat Program Baru</span>
                    </button>

                    <button 
                        type="button" 
                        wire:click="bukaFormJadwalTambah"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-purple-600 via-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-purple-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="calendar-plus" class="w-4 h-4 transition-transform group-hover:rotate-90 duration-200"></i>
                        <span>Buka Jadwal Angkatan</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Kurikulum"
                    :value="number_format($totalProgram)"
                    unit="Program"
                    subtitle="Standar kompetensi aktif"
                    icon="graduation-cap"
                    color="blue"
                    :active="$tabAktif === 'program' && $jenisSertifikasiFilter === 'Semua'"
                    loading-target="setFilterJenisSertifikasi, resetSemuaFilter"
                    wire:click="$set('tabAktif', 'program')"
                />

                <x-table.stats-card
                    title="Program Aktif"
                    :value="number_format($totalProgramAktif)"
                    unit="Siap Dibuka"
                    subtitle="Kurikulum berjalan"
                    icon="check-circle"
                    color="emerald"
                    :pulse="true"
                    loading-target="setFilterJenisSertifikasi"
                    wire:click="$set('tabAktif', 'program')"
                />

                <x-table.stats-card
                    title="Jadwal Angkatan"
                    :value="number_format($totalJadwal)"
                    unit="Batch"
                    subtitle="Total batch pelatihan"
                    icon="calendar-days"
                    color="purple"
                    :active="$tabAktif === 'jadwal' && $statusPendaftaranFilter === 'Semua'"
                    loading-target="setFilterStatusPendaftaran"
                    wire:click="$set('tabAktif', 'jadwal')"
                />

                <x-table.stats-card
                    title="Total Peserta"
                    :value="number_format($totalPendaftar)"
                    unit="Orang"
                    subtitle="Peserta & instruktur terdata"
                    icon="users"
                    color="amber"
                    loading-target="cari"
                />
            </div>

            <!-- 3. TAB SWITCHER -->
            <div class="bg-white border border-slate-200/80 p-1.5 rounded-2xl shadow-2xs flex items-center gap-2 w-fit">
                <button 
                    type="button"
                    wire:click="$set('tabAktif', 'program')" 
                    class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer flex items-center gap-2 {{ $tabAktif === 'program' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100' }}"
                >
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                    <span>Kurikulum Program ({{ $totalProgram }})</span>
                </button>
                <button 
                    type="button"
                    wire:click="$set('tabAktif', 'jadwal')" 
                    class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer flex items-center gap-2 {{ $tabAktif === 'jadwal' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100' }}"
                >
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                    <span>Jadwal Angkatan ({{ $totalJadwal }})</span>
                </button>
            </div>

            <!-- 4. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                :search-placeholder="$tabAktif === 'program' ? 'Cari judul kurikulum, sasaran peserta...' : 'Cari nama angkatan, lokasi venue...'" 
                search-model="cari"
            >
                @if($tabAktif === 'program')
                    <x-slot:top>
                        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                            @foreach(['Semua', 'Nasional KORMI', 'Daerah KORMI Kab. Bandung', 'Lisensi Juri / Wasit Inorga', 'Instruktur Kebugaran Terakreditasi'] as $jenis)
                                <button 
                                    type="button"
                                    wire:click="setFilterJenisSertifikasi('{{ $jenis }}')" 
                                    class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $jenisSertifikasiFilter === $jenis ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                                >
                                    <span>{{ $jenis }}</span>
                                </button>
                            @endforeach
                        </div>
                    </x-slot:top>
                @else
                    <x-slot:top>
                        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                            @foreach(['Semua', 'dibuka', 'berlangsung', 'penuh', 'selesai'] as $st)
                                <button 
                                    type="button"
                                    wire:click="setFilterStatusPendaftaran('{{ $st }}')" 
                                    class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $statusPendaftaranFilter === $st ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                                >
                                    <span>{{ ucfirst($st) }}</span>
                                </button>
                            @endforeach
                        </div>
                    </x-slot:top>
                @endif

                <x-slot:actions>
                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        @if($tabAktif === 'program')
                            <option value="dibuat_pada">Urutan: Waktu Input</option>
                            <option value="judul_program">Urutan: Judul Program</option>
                            <option value="jenis_sertifikasi">Urutan: Sertifikasi</option>
                        @else
                            <option value="tanggal_mulai">Urutan: Tanggal Mulai</option>
                            <option value="nama_angkatan">Urutan: Nama Angkatan</option>
                            <option value="jumlah_pendaftar">Urutan: Jumlah Pendaftar</option>
                        @endif
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        <option value="desc">Terbaru / Z-A (DESC)</option>
                        <option value="asc">Terlama / A-Z (ASC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        <option value="8">8 / hal</option>
                        <option value="12">12 / hal</option>
                        <option value="24">24 / hal</option>
                    </select>

                    @if($tabAktif === 'program')
                        <!-- View Switcher for Program -->
                        <div 
                            x-data="{
                                mode: localStorage.getItem('kormi_sdi_view') || @js($tampilanMode),
                                setMode(val) {
                                    this.mode = val;
                                    localStorage.setItem('kormi_sdi_view', val);
                                    $wire.set('tampilanMode', val);
                                }
                            }"
                            x-init="
                                if (localStorage.getItem('kormi_sdi_view') && localStorage.getItem('kormi_sdi_view') !== @js($tampilanMode)) {
                                    $wire.set('tampilanMode', localStorage.getItem('kormi_sdi_view'));
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
            @if($tabAktif === 'program')
                <x-table.bulk-bar :count="count($selectedProgram)" label="Program dipilih" reset-action="resetSelectionProgram">
                    <button 
                        type="button" 
                        wire:click="bulkSetStatusProgram(true)" 
                        class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                    >
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                        <span>Set Aktif</span>
                    </button>

                    <button 
                        type="button" 
                        wire:click="bulkSetStatusProgram(false)" 
                        class="px-3 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                    >
                        <i data-lucide="slash" class="w-3.5 h-3.5"></i>
                        <span>Set Non-Aktif</span>
                    </button>

                    <button 
                        type="button" 
                        wire:click="bulkDeleteProgram" 
                        wire:confirm="Yakin ingin menghapus {{ count($selectedProgram) }} program pelatihan terpilih?"
                        class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                    >
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                </x-table.bulk-bar>
            @else
                <x-table.bulk-bar :count="count($selectedJadwal)" label="Jadwal dipilih" reset-action="resetSelectionJadwal">
                    <button 
                        type="button" 
                        wire:click="bulkSetStatusJadwal('dibuka')" 
                        class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                    >
                        <i data-lucide="door-open" class="w-3.5 h-3.5"></i>
                        <span>Set Dibuka</span>
                    </button>

                    <button 
                        type="button" 
                        wire:click="bulkSetStatusJadwal('selesai')" 
                        class="px-3 py-1.5 rounded-xl bg-slate-700 hover:bg-slate-800 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                    >
                        <i data-lucide="check-square" class="w-3.5 h-3.5"></i>
                        <span>Set Selesai</span>
                    </button>

                    <button 
                        type="button" 
                        wire:click="bulkDeleteJadwal" 
                        wire:confirm="Yakin ingin menghapus {{ count($selectedJadwal) }} jadwal terpilih?"
                        class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                    >
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                </x-table.bulk-bar>
            @endif

            <!-- 6. CONTENT TAB 1: PROGRAM KURIKULUM -->
            @if($tabAktif === 'program')
                @if($tampilanMode === 'tabel')
                    <x-table.card>
                        <x-table.table loading-target="cari, jenisSertifikasiFilter, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
                            <x-table.thead>
                                <tr>
                                    <x-table.th align="center" class="w-12 !px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="pilihSemuaProgram" 
                                            class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer"
                                        >
                                    </x-table.th>
                                    <x-table.th 
                                        sortable 
                                        sort-field="judul_program" 
                                        :current-sort="$sortField" 
                                        :current-direction="$sortDirection"
                                    >
                                        Kurikulum & Sasaran Peserta
                                    </x-table.th>
                                    <x-table.th 
                                        sortable 
                                        sort-field="jenis_sertifikasi" 
                                        :current-sort="$sortField" 
                                        :current-direction="$sortDirection"
                                    >
                                        Sertifikasi
                                    </x-table.th>
                                    <x-table.th align="center">Jadwal Angkatan</x-table.th>
                                    <x-table.th 
                                        align="center"
                                        sortable 
                                        sort-field="status_aktif" 
                                        :current-sort="$sortField" 
                                        :current-direction="$sortDirection"
                                    >
                                        Status
                                    </x-table.th>
                                    <x-table.th align="center" class="w-24">Aksi</x-table.th>
                                </tr>
                            </x-table.thead>

                            <x-table.tbody>
                                @forelse($daftarProgram as $prog)
                                    <x-table.tr :selected="in_array($prog->id, $selectedProgram)">
                                        <!-- Checkbox -->
                                        <x-table.td align="center" class="!px-4">
                                            <input 
                                                type="checkbox" 
                                                wire:model.live="selectedProgram" 
                                                value="{{ $prog->id }}" 
                                                class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer"
                                            >
                                        </x-table.td>

                                        <!-- Info Program -->
                                        <x-table.td>
                                            <div class="flex items-start gap-3.5">
                                                <div class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 relative group">
                                                    @if($prog->banner_url)
                                                        <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($prog->banner_url) }}" class="w-full h-full object-cover" alt="{{ $prog->judul_program }}">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                                            <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="min-w-0">
                                                    <h3 class="font-black text-slate-900 text-sm leading-snug group-hover:text-blue-600 transition-colors">
                                                        {{ $prog->judul_program }}
                                                    </h3>
                                                    <div class="flex items-center gap-2 mt-1 text-xs text-slate-500">
                                                        <span class="flex items-center gap-1">
                                                            <i data-lucide="target" class="w-3.5 h-3.5 text-slate-400"></i>
                                                            <span>{{ $prog->sasaran_peserta ?: '-' }}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </x-table.td>

                                        <!-- Jenis Sertifikasi -->
                                        <x-table.td>
                                            <span class="px-2.5 py-1 rounded-lg bg-blue-50 border border-blue-200/60 text-blue-700 text-xs font-bold">
                                                {{ $prog->jenis_sertifikasi ?? 'Nasional KORMI' }}
                                            </span>
                                        </x-table.td>

                                        <!-- Jadwal Count -->
                                        <x-table.td align="center">
                                            <span class="inline-flex items-center gap-1.5 font-bold text-slate-700 text-xs bg-slate-100 px-3 py-1 rounded-xl">
                                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>{{ $prog->jadwal_count }} Batch</span>
                                            </span>
                                        </x-table.td>

                                        <!-- Status -->
                                        <x-table.td align="center">
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $prog->status_aktif ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                                {{ $prog->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                                            </span>
                                        </x-table.td>

                                        <!-- Actions -->
                                        <x-table.td align="center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <x-table.action-btn 
                                                    size="sm"
                                                    variant="warning" 
                                                    icon="edit-3" 
                                                    loading-target="bukaFormProgramEdit('{{ $prog->id }}')"
                                                    wire:click="bukaFormProgramEdit('{{ $prog->id }}')" 
                                                    title="Edit Program" 
                                                />

                                                <x-table.action-btn 
                                                    size="sm"
                                                    variant="danger" 
                                                    icon="trash-2" 
                                                    loading-target="hapusProgram('{{ $prog->id }}')"
                                                    wire:click="hapusProgram('{{ $prog->id }}')" 
                                                    wire:confirm="Yakin ingin menghapus kurikulum program pelatihan ini?" 
                                                    title="Hapus Program" 
                                                />
                                            </div>
                                        </x-table.td>
                                    </x-table.tr>
                                @empty
                                    <x-table.empty 
                                        colspan="6" 
                                        icon="graduation-cap" 
                                        title="Belum ada program pelatihan" 
                                        description="Silakan buat kurikulum dan standar kompetensi pelatihan baru."
                                    />
                                @endforelse
                            </x-table.tbody>
                        </x-table.table>

                        @if($daftarProgram->hasPages())
                            <x-slot:footer>
                                <div class="px-4 py-3 flex items-center justify-between">
                                    {{ $daftarProgram->links() }}
                                </div>
                            </x-slot:footer>
                        @endif
                    </x-table.card>
                @else
                    <!-- Grid View for Program -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @forelse($daftarProgram as $prog)
                            <div wire:key="grid-prog-{{ $prog->id }}" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-all group {{ in_array($prog->id, $selectedProgram) ? 'ring-2 ring-blue-500' : '' }}">
                                <div>
                                    <!-- Banner -->
                                    <div class="relative h-44 bg-gradient-to-tr from-blue-950 to-slate-900 overflow-hidden">
                                        @if($prog->banner_url)
                                            <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($prog->banner_url) }}" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300" alt="{{ $prog->judul_program }}">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center text-blue-300/40 p-4 text-center">
                                                <i data-lucide="graduation-cap" class="w-12 h-12 mb-1"></i>
                                                <span class="text-[10px] font-bold uppercase tracking-wider">Tanpa Banner</span>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>
                                        
                                        <!-- Top Badges -->
                                        <div class="absolute top-3 left-3 flex items-center gap-1.5">
                                            <input 
                                                type="checkbox" 
                                                wire:model.live="selectedProgram" 
                                                value="{{ $prog->id }}" 
                                                class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer shadow-sm"
                                            >
                                            <span class="px-2.5 py-1 rounded-lg bg-black/60 text-white font-bold text-[10px] backdrop-blur-md">
                                                {{ $prog->jenis_sertifikasi ?? 'KORMI' }}
                                            </span>
                                        </div>

                                        <div class="absolute top-3 right-3">
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $prog->status_aktif ? 'bg-emerald-400 text-slate-950' : 'bg-slate-300 text-slate-800' }}">
                                                {{ $prog->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                                            </span>
                                        </div>

                                        <!-- Bottom Overlay -->
                                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-xs font-semibold">
                                            <span class="flex items-center gap-1.5 truncate">
                                                <i data-lucide="target" class="w-3.5 h-3.5 text-blue-400 shrink-0"></i>
                                                <span class="truncate">{{ $prog->sasaran_peserta ?: '-' }}</span>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Body -->
                                    <div class="p-5">
                                        <h3 class="font-black text-slate-900 text-base leading-snug line-clamp-2 mb-2 group-hover:text-blue-600 transition-colors">
                                            {{ $prog->judul_program }}
                                        </h3>
                                        @if($prog->standar_kompetensi)
                                            <p class="text-xs text-slate-500 line-clamp-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                                {{ $prog->standar_kompetensi }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-500 flex items-center gap-1">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                        {{ $prog->jadwal_count }} Batch
                                    </span>

                                    <div class="flex items-center gap-1.5">
                                        <button wire:click="bukaFormProgramEdit('{{ $prog->id }}')" title="Edit Program" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 hover:text-blue-600 transition-all cursor-pointer">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>
                                        <button wire:click="hapusProgram('{{ $prog->id }}')" wire:confirm="Yakin ingin menghapus program ini?" title="Hapus Program" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition-all cursor-pointer">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center">
                                <div class="w-16 h-16 rounded-3xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="graduation-cap" class="w-8 h-8"></i>
                                </div>
                                <h3 class="font-extrabold text-slate-900 text-base">Belum Ada Program Pelatihan</h3>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Klik tombol "Buat Program Baru" untuk mendaftarkan kurikulum sertifikasi SDI.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $daftarProgram->links() }}
                    </div>
                @endif

            <!-- 7. CONTENT TAB 2: JADWAL & ANGKATAN -->
            @else
                <x-table.card>
                    <x-table.table loading-target="cari, statusPendaftaranFilter, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
                        <x-table.thead>
                            <tr>
                                <x-table.th align="center" class="w-12 !px-4">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="pilihSemuaJadwal" 
                                        class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer"
                                    >
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="nama_angkatan" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Angkatan & Program Kurikulum
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="tanggal_mulai" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Waktu Pelaksanaan
                                </x-table.th>
                                <x-table.th>Lokasi Venue</x-table.th>
                                <x-table.th align="center" sortable sort-field="jumlah_pendaftar" :current-sort="$sortField" :current-direction="$sortDirection">
                                    Kuota & Pendaftar
                                </x-table.th>
                                <x-table.th 
                                    align="center"
                                    sortable 
                                    sort-field="status_pendaftaran" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Status
                                </x-table.th>
                                <x-table.th align="center" class="w-24">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>

                        <x-table.tbody>
                            @forelse($daftarJadwal as $jadwal)
                                <x-table.tr :selected="in_array($jadwal->id, $selectedJadwal)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedJadwal" 
                                            value="{{ $jadwal->id }}" 
                                            class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Info Angkatan & Program -->
                                    <x-table.td>
                                        <h4 class="font-black text-slate-900 text-sm group-hover:text-blue-600 transition-colors">
                                            {{ $jadwal->nama_angkatan }}
                                        </h4>
                                        <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-1.5">
                                            <i data-lucide="book-open" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <span>{{ $jadwal->program->judul_program ?? '-' }}</span>
                                        </p>
                                    </x-table.td>

                                    <!-- Tanggal -->
                                    <x-table.td>
                                        <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-blue-500"></i>
                                            <span>{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') }}</span>
                                        </div>
                                    </x-table.td>

                                    <!-- Lokasi -->
                                    <x-table.td>
                                        <div class="text-xs font-medium text-slate-600 flex items-center gap-1.5 max-w-xs truncate">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                            <span class="truncate">{{ $jadwal->lokasi_pelatihan }}</span>
                                        </div>
                                    </x-table.td>

                                    <!-- Kuota -->
                                    <x-table.td align="center">
                                        <span class="font-black text-slate-800 bg-slate-100 px-3 py-1 rounded-xl text-xs inline-flex items-center gap-1">
                                            <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <span>{{ $jadwal->jumlah_pendaftar }} / {{ $jadwal->kuota_peserta }}</span>
                                        </span>
                                    </x-table.td>

                                    <!-- Status -->
                                    <x-table.td align="center">
                                        @php
                                            $stBadge = match($jadwal->status_pendaftaran) {
                                                'dibuka' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'berlangsung' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'penuh' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                default => 'bg-slate-100 text-slate-600 border-slate-200'
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $stBadge }}">
                                            {{ ucfirst($jadwal->status_pendaftaran) }}
                                        </span>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="warning" 
                                                icon="edit-3" 
                                                loading-target="bukaFormJadwalEdit('{{ $jadwal->id }}')"
                                                wire:click="bukaFormJadwalEdit('{{ $jadwal->id }}')" 
                                                title="Edit Jadwal" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="hapusJadwal('{{ $jadwal->id }}')"
                                                wire:click="hapusJadwal('{{ $jadwal->id }}')" 
                                                wire:confirm="Yakin ingin menghapus jadwal angkatan ini?" 
                                                title="Hapus Jadwal" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="7" 
                                    icon="calendar-x" 
                                    title="Belum ada jadwal pelatihan" 
                                    description="Silakan buka jadwal angkatan pelatihan baru untuk kurikulum yang tersedia."
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    @if($daftarJadwal->hasPages())
                        <x-slot:footer>
                            <div class="px-4 py-3 flex items-center justify-between">
                                {{ $daftarJadwal->links() }}
                            </div>
                        </x-slot:footer>
                    @endif
                </x-table.card>
            @endif

        </div>

    @elseif($mode === 'form_program')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM PROGRAM KURIKULUM  -->
        <!-- ========================================== -->
        <div wire:key="sdi-view-form-program" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$editProgramId ? 'Edit Kurikulum Program Pelatihan' : 'Buat Program Sertifikasi & Pelatihan Baru'"
                subtitle="Susun judul program SDI, sasaran peserta, standar kurikulum kompetensi, dan banner resmi."
                :badge="$editProgramId ? 'Mode Edit Kurikulum' : 'Kurikulum Baru'"
                icon="graduation-cap"
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
                        loading-target="simpanProgram"
                        wire:click="simpanProgram"
                    >
                        {{ $editProgramId ? 'Perbarui Program' : 'Simpan Program' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT (2 Columns: 8 cols Metadata + 4 cols Banner & Guide) -->
            <form wire:submit.prevent="simpanProgram" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Data Kurikulum -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Spesifikasi Kurikulum & Kompetensi" 
                            subtitle="Rincian judul kurikulum pelatihan, sasaran peserta, dan jenis akreditasi sertifikasi."
                            icon="file-text"
                        >
                            <!-- Judul Program -->
                            <x-form.field label="Judul Program Pelatihan / Sertifikasi" name="judul_program" :required="true">
                                <x-form.input 
                                    name="judul_program" 
                                    wire:model="judul_program" 
                                    placeholder="Contoh: Sertifikasi Instruktur Senam Bedas Level 1..." 
                                    size="lg"
                                    class="font-black text-slate-900"
                                />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Sasaran Peserta -->
                                <x-form.field label="Sasaran Peserta" name="sasaran_peserta">
                                    <x-form.input 
                                        name="sasaran_peserta" 
                                        wire:model="sasaran_peserta" 
                                        placeholder="Contoh: Instruktur Senam Desa, Wasit Inorga..." 
                                        icon="target"
                                    />
                                </x-form.field>

                                <!-- Jenis Sertifikasi -->
                                <x-form.field label="Jenis Sertifikasi" name="jenis_sertifikasi" :required="true">
                                    <x-form.select name="jenis_sertifikasi" wire:model="jenis_sertifikasi">
                                        <option value="Nasional KORMI">Nasional KORMI</option>
                                        <option value="Daerah KORMI Kab. Bandung">Daerah KORMI Kab. Bandung</option>
                                        <option value="Lisensi Juri / Wasit Inorga">Lisensi Juri / Wasit Inorga</option>
                                        <option value="Instruktur Kebugaran Terakreditasi">Instruktur Kebugaran Terakreditasi</option>
                                    </x-form.select>
                                </x-form.field>
                            </div>

                            <!-- Standar Kompetensi -->
                            <x-form.field label="Standar Kompetensi & Materi Kurikulum" name="standar_kompetensi">
                                <x-form.textarea 
                                    name="standar_kompetensi" 
                                    wire:model="standar_kompetensi" 
                                    rows="4" 
                                    placeholder="Uraikan kompetensi dasar, jumlah jam pelajaran (JP), dan materi kurikulum yang diujikan..."
                                />
                            </x-form.field>

                            <!-- Status Aktif Toggle -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <label for="statusAktif" class="text-xs font-black text-slate-900 cursor-pointer">Status Kurikulum Aktif</label>
                                    <p class="text-xs text-slate-500">Program aktif dapat dibuka jadwal pendaftaran angkatan batch baru.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="statusAktif" wire:model="status_aktif" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Banner Upload & Guide -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Banner Card -->
                        <x-form.card 
                            title="Banner / Poster Program" 
                            subtitle="Visual publikasi promosi kurikulum SDI."
                            icon="image"
                        >
                            <x-form.image-upload
                                :upload="$uploadBanner"
                                :saved-path="$banner_url"
                                name="uploadBanner"
                                input-id="uploadBannerSdi"
                                empty-title="Unggah Banner Pelatihan"
                                empty-subtitle="Format JPG, PNG, WEBP (Maksimal 10MB)"
                                :max-size-m-b="10"
                                aspect-ratio="h-48 sm:h-56"
                            />
                        </x-form.card>

                        <!-- Guide Information Card -->
                        <div class="bg-blue-50/70 border border-blue-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-blue-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="shield-check" class="w-4 h-4 text-blue-600"></i>
                                <span>Pedoman Sertifikasi SDI</span>
                            </h4>
                            <div class="space-y-2 text-xs text-blue-950">
                                <div class="bg-white/80 p-2.5 rounded-xl border border-blue-200/60">
                                    <strong>Kurikulum Terstandar:</strong> Setiap program harus memiliki standar kompetensi jelas sebelum jadwal angkatan dibuka.
                                </div>
                                <div class="bg-white/80 p-2.5 rounded-xl border border-blue-200/60">
                                    <strong>Akreditasi:</strong> Sertifikat diterbitkan resmi berjenjang bersama Pengurus Inorga / KORMI.
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
                        variant="primary" 
                        icon="save" 
                        loading-target="simpanProgram"
                    >
                        {{ $editProgramId ? 'Perbarui Program' : 'Simpan Program' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>

    @elseif($mode === 'form_jadwal')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM JADWAL ANGKATAN    -->
        <!-- ========================================== -->
        <div wire:key="sdi-view-form-jadwal" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$editJadwalId ? 'Edit Rincian Angkatan Pelatihan' : 'Buka Jadwal Angkatan Pelatihan Baru'"
                subtitle="Tentukan kurikulum program induk, jadwal tanggal pelaksanaan, kuota peserta, dan lokasi venue."
                :badge="$editJadwalId ? 'Mode Edit Batch' : 'Batch Baru'"
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
                        variant="primary" 
                        size="default" 
                        icon="check" 
                        loading-target="simpanJadwal"
                        wire:click="simpanJadwal"
                    >
                        {{ $editJadwalId ? 'Perbarui Jadwal' : 'Simpan Jadwal' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT -->
            <form wire:submit.prevent="simpanJadwal" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Data Batch & Jadwal -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Informasi Angkatan & Waktu Pelaksanaan" 
                            subtitle="Tautan program pelatihan, nama angkatan batch, tanggal mulai & selesai, serta lokasi."
                            icon="calendar"
                        >
                            <!-- Pilih Program -->
                            <x-form.field label="Program Kurikulum Induk" name="program_id" :required="true">
                                <x-form.select name="program_id" wire:model="program_id">
                                    @foreach($semuaProgram as $p)
                                        <option value="{{ $p->id }}">{{ $p->judul_program }}</option>
                                    @endforeach
                                </x-form.select>
                            </x-form.field>

                            <!-- Nama Angkatan -->
                            <x-form.field label="Nama Angkatan / Batch" name="nama_angkatan" :required="true">
                                <x-form.input 
                                    name="nama_angkatan" 
                                    wire:model="nama_angkatan" 
                                    placeholder="Contoh: Angkatan I - Wilayah Soreang & Sekitarnya..." 
                                    size="lg"
                                    class="font-black text-slate-900"
                                />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Tanggal Mulai -->
                                <x-form.field label="Tanggal Mulai Pelaksanaan" name="tanggal_mulai" :required="true">
                                    <x-form.input 
                                        type="date" 
                                        name="tanggal_mulai" 
                                        wire:model="tanggal_mulai" 
                                    />
                                </x-form.field>

                                <!-- Tanggal Selesai -->
                                <x-form.field label="Tanggal Selesai Pelaksanaan" name="tanggal_selesai" :required="true">
                                    <x-form.input 
                                        type="date" 
                                        name="tanggal_selesai" 
                                        wire:model="tanggal_selesai" 
                                    />
                                </x-form.field>
                            </div>

                            <!-- Lokasi Pelatihan -->
                            <x-form.field label="Lokasi Venue / Tempat Pelatihan" name="lokasi_pelatihan" :required="true">
                                <x-form.input 
                                    name="lokasi_pelatihan" 
                                    wire:model="lokasi_pelatihan" 
                                    placeholder="Contoh: Gedung Ormas KORMI / GOR Si Jalak Harupat..." 
                                    icon="map-pin"
                                />
                            </x-form.field>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Kapasitas & Status -->
                    <div class="lg:col-span-4 space-y-6">
                        <x-form.card 
                            title="Kuota & Status Pendaftaran" 
                            subtitle="Batas kuota peserta dan ketersediaan form registrasi."
                            icon="settings"
                        >
                            <!-- Kuota Peserta -->
                            <x-form.field label="Kuota Maksimal Peserta" name="kuota_peserta" :required="true">
                                <x-form.input 
                                    type="number" 
                                    name="kuota_peserta" 
                                    wire:model="kuota_peserta" 
                                    min="1"
                                    icon="users"
                                />
                            </x-form.field>

                            <!-- Status Pendaftaran -->
                            <x-form.field label="Status Pendaftaran" name="status_pendaftaran" :required="true">
                                <x-form.select name="status_pendaftaran" wire:model="status_pendaftaran">
                                    <option value="dibuka">Dibuka (Menerima Peserta)</option>
                                    <option value="berlangsung">Sedang Berlangsung</option>
                                    <option value="penuh">Kuota Penuh</option>
                                    <option value="selesai">Selesai</option>
                                </x-form.select>
                            </x-form.field>
                        </x-form.card>

                        <!-- Info Card -->
                        <div class="bg-purple-50/70 border border-purple-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-purple-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="info" class="w-4 h-4 text-purple-600"></i>
                                <span>Manajemen Batch</span>
                            </h4>
                            <p class="text-xs text-purple-950 leading-relaxed">
                                Peserta yang mendaftar secara publik akan otomatis mengurangi sisa kuota yang tersedia hingga status berubah menjadi <strong>Kuota Penuh</strong>.
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
                        loading-target="simpanJadwal"
                    >
                        {{ $editJadwalId ? 'Perbarui Jadwal' : 'Simpan Jadwal' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

</div>
