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
        <!-- VIEW MODE: TABEL DAFTAR DUTA OLAHRAGA     -->
        <!-- ========================================== -->
        <div wire:key="duta-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Katalog Duta Olahraga Desa & Kecamatan"
                subtitle="Data kader dan duta penggerak olahraga di 31 Kecamatan dan 280 Desa/Kelurahan se-Kabupaten Bandung."
                badge="Pembinaan & Penggerak • Duta Olahraga"
                icon="award"
                color="indigo"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormTambah" 
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Tambah Duta</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Duta Olahraga"
                    :value="number_format($totalDuta)"
                    unit="Orang"
                    subtitle="Kader pembina masyarakat"
                    icon="award"
                    color="indigo"
                    :active="$kecamatanDipilih === 'Semua' && $tahunDipilih === 'Semua'"
                    loading-target="resetSemuaFilter, kecamatanDipilih, tahunDipilih"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Kecamatan Terwakili"
                    :value="number_format($totalKecamatanTerwakili)"
                    unit="/ 31"
                    subtitle="Cakupan wilayah aktif"
                    icon="map-pin"
                    color="emerald"
                    :pulse="true"
                    loading-target="kecamatanDipilih"
                    wire:click="$set('kecamatanDipilih', 'Semua')"
                />

                <x-table.stats-card
                    title="Duta Tahun Ini"
                    :value="number_format($dutaTahunIni)"
                    unit="Kader"
                    subtitle="Pemilihan periode 2026"
                    icon="calendar"
                    color="amber"
                    :active="$tahunDipilih == 2026"
                    loading-target="tahunDipilih"
                    wire:click="$set('tahunDipilih', '2026')"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                search-placeholder="Cari nama duta, prestasi, desa/kelurahan..." 
                search-model="cari"
            >
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none flex-1 max-w-full">
                        <button 
                            type="button"
                            wire:click="$set('kecamatanDipilih', 'Semua')" 
                            class="px-3.5 py-1.5 rounded-2xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap shrink-0 flex items-center gap-1.5 {{ $kecamatanDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <span>Semua Wilayah</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $kecamatanDipilih === 'Semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $totalDuta }}</span>
                        </button>

                        @foreach($kecamatanList as $kec)
                            <button 
                                type="button"
                                wire:click="$set('kecamatanDipilih', '{{ $kec->id }}')" 
                                class="px-3 py-1.5 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-1.5 {{ $kecamatanDipilih === $kec->id ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                            >
                                <i data-lucide="map-pin" class="w-3 h-3 {{ $kecamatanDipilih === $kec->id ? 'text-white' : 'text-slate-400' }}"></i>
                                <span>{{ $kec->nama_kecamatan }}</span>
                            </button>
                        @endforeach
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <!-- Filter Kategori -->
                    <select wire:model.live="kategoriDipilih" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="Semua">Semua Kategori</option>
                        <option value="Duta Olahraga Masyarakat">Duta Olahraga Masyarakat</option>
                        <option value="Duta Pemuda & Kebugaran">Duta Pemuda & Kebugaran</option>
                        <option value="Duta Lansia Bugar">Duta Lansia Bugar</option>
                        <option value="Duta Pelajar Berprestasi">Duta Pelajar Berprestasi</option>
                    </select>

                    <!-- Filter Tahun -->
                    <select wire:model.live="tahunDipilih" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="Semua">Semua Tahun</option>
                        @foreach($tahunList as $th)
                            <option value="{{ $th }}">Tahun {{ $th }}</option>
                        @endforeach
                    </select>

                    <!-- Sort Field -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="nama_lengkap">Urut: Nama Lengkap</option>
                        <option value="tahun_pemilihan">Urut: Tahun Pemilihan</option>
                        <option value="created_at">Urut: Tanggal Didaftarkan</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="asc">Menaik (ASC)</option>
                        <option value="desc">Menurun (DESC)</option>
                    </select>

                    <!-- Per Page -->
                    <!-- View Switcher with localStorage persistence -->
                    <div 
                        x-data="{
                            mode: localStorage.getItem('kormi_duta_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_duta_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_duta_view') && localStorage.getItem('kormi_duta_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_duta_view'));
                            }
                        "
                        class="flex items-center p-1 bg-slate-100 rounded-2xl border border-slate-200 shrink-0"
                    >
                        <button 
                            type="button" 
                            @click="setMode('tabel')" 
                            :class="mode === 'tabel' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-400 hover:text-slate-700'"
                            class="p-1.5 rounded-xl transition-all cursor-pointer"
                            title="Tampilan Tabel Data"
                        >
                            <i data-lucide="list" class="w-4 h-4"></i>
                        </button>
                        <button 
                            type="button" 
                            @click="setMode('grid')" 
                            :class="mode === 'grid' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-400 hover:text-slate-700'"
                            class="p-1.5 rounded-xl transition-all cursor-pointer"
                            title="Tampilan Kartu / Grid Profil"
                        >
                            <i data-lucide="layout-grid" class="w-4 h-4"></i>
                        </button>
                    </div>
                </x-slot:actions>
            </x-table.filter-bar>

            <!-- 4. FLOATING BULK ACTIONS BAR -->
            <x-table.bulk-bar :count="count($selectedDuta)" label="duta dipilih" reset-action="resetSelection">
                <button 
                    type="button" 
                    wire:click="bulkDelete" 
                    wire:confirm="Yakin ingin menghapus {{ count($selectedDuta) }} data duta terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. DATA PRESENTATION (TABEL / GRID) -->
            @if($tampilanMode === 'tabel')
                <!-- FULL-WIDTH DATA TABLE -->
                <x-table.card>
                    <x-table.table loading-target="cari, kecamatanDipilih, tahunDipilih, kategoriDipilih, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
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
                                    sort-field="nama_lengkap" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Profil Duta Olahraga
                                </x-table.th>
                                <x-table.th>Wilayah Penugasan</x-table.th>
                                <x-table.th>Kategori & Peran</x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="tahun_pemilihan" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    align="center"
                                >
                                    Periode
                                </x-table.th>
                                <x-table.th align="right">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>
                        <x-table.tbody>
                            @forelse($dutaList as $d)
                                <x-table.tr wire:key="row-duta-{{ $d->id }}" :selected="in_array($d->id, $selectedDuta)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-3.5 w-10">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedDuta" 
                                            value="{{ $d->id }}" 
                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Profil Duta -->
                                    <x-table.td>
                                        <div class="flex items-center gap-3.5 max-w-md">
                                            <div class="relative shrink-0 group">
                                                @if($d->foto_url)
                                                    @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($d->foto_url) @endphp
                                                    <img 
                                                        src="{{ $tmpUrl ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=300' }}" 
                                                        class="w-12 h-12 rounded-2xl object-cover border border-slate-200/80 shadow-2xs group-hover:scale-105 transition-transform" 
                                                        alt="{{ $d->nama_lengkap }}"
                                                        onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=300'"
                                                    >
                                                @else
                                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white font-black text-sm flex items-center justify-center shadow-xs">
                                                        {{ strtoupper(substr($d->nama_lengkap, 0, 2)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0 space-y-0.5">
                                                <a 
                                                    href="javascript:void(0)" 
                                                    wire:click="bukaFormEdit('{{ $d->id }}')" 
                                                    class="font-black text-slate-900 text-xs sm:text-sm hover:text-indigo-600 line-clamp-1 leading-tight transition-colors cursor-pointer"
                                                >
                                                    {{ $d->nama_lengkap }}
                                                </a>
                                                <div class="flex items-center gap-2 text-[11px] text-slate-400 font-medium">
                                                    @if($d->kontak)
                                                        <span class="flex items-center gap-1">
                                                            <i data-lucide="phone" class="w-3 h-3 text-slate-400"></i>
                                                            <span>{{ $d->kontak }}</span>
                                                        </span>
                                                        <span>•</span>
                                                    @endif
                                                    <span>ID: {{ substr($d->id, 0, 8) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Wilayah -->
                                    <x-table.td>
                                        <div class="space-y-1">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                                <i data-lucide="map-pin" class="w-3 h-3 text-indigo-600"></i>
                                                <span>Kec. {{ $d->kecamatan->nama_kecamatan ?? '-' }}</span>
                                            </span>
                                            <p class="text-[11px] text-slate-500 font-bold pl-1">
                                                {{ $d->desaKelurahan->nama_desa_kelurahan ? 'Desa ' . $d->desaKelurahan->nama_desa_kelurahan : 'Tingkat Kecamatan' }}
                                            </p>
                                        </div>
                                    </x-table.td>

                                    <!-- Kategori -->
                                    <x-table.td>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                            <i data-lucide="award" class="w-3 h-3 text-amber-600"></i>
                                            <span>{{ $d->kategori_duta }}</span>
                                        </span>
                                    </x-table.td>

                                    <!-- Periode -->
                                    <x-table.td align="center">
                                        <span class="px-3 py-1 rounded-xl text-xs font-black bg-slate-100 text-slate-900 border border-slate-200">
                                            {{ $d->tahun_pemilihan }}
                                        </span>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="right">
                                        <div class="flex items-center justify-end gap-1">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="indigo" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdit('{{ $d->id }}')"
                                                wire:click="bukaFormEdit('{{ $d->id }}')" 
                                                title="Edit Data Duta" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="hapus('{{ $d->id }}')"
                                                wire:click="hapus('{{ $d->id }}')" 
                                                wire:confirm="Yakin ingin menghapus data duta olahraga ini?" 
                                                title="Hapus Data Duta" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="6" 
                                    icon="award" 
                                    title="Belum ada data Duta Olahraga" 
                                    description="Silakan tambahkan data duta atau kader penggerak olahraga di wilayah Anda."
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    @if($dutaList->hasPages())
                        <x-slot:footer>
                            <div class="px-4 py-3 flex items-center justify-between">
                                {{ $dutaList->links() }}
                            </div>
                        </x-slot:footer>
                    @endif
                </x-table.card>
            @else
                <!-- GRID PROFIL CARDS VIEW -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    @forelse($dutaList as $d)
                        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between group">
                            <div>
                                <div class="relative h-44 rounded-2xl overflow-hidden bg-slate-100 mb-4 border border-slate-100">
                                    @if($d->foto_url)
                                        @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($d->foto_url) @endphp
                                        <img 
                                            src="{{ $tmpUrl ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400' }}" 
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                            alt="{{ $d->nama_lengkap }}"
                                            onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400'"
                                        >
                                    @else
                                        <div class="w-full h-full bg-gradient-to-tr from-indigo-600 to-violet-500 text-white font-black text-2xl flex items-center justify-center">
                                            {{ strtoupper(substr($d->nama_lengkap, 0, 2)) }}
                                        </div>
                                    @endif

                                    <div class="absolute top-2.5 left-2.5">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-900/80 text-white backdrop-blur-xs shadow-xs">
                                            {{ $d->tahun_pemilihan }}
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">
                                        <i data-lucide="map-pin" class="w-3 h-3"></i>
                                        <span>Kec. {{ $d->kecamatan->nama_kecamatan ?? '-' }}</span>
                                    </span>
                                    <h3 class="font-black text-slate-900 text-sm group-hover:text-indigo-600 transition-colors line-clamp-1 mt-1">{{ $d->nama_lengkap }}</h3>
                                    <p class="text-xs text-slate-500 font-medium line-clamp-1">{{ $d->desaKelurahan->nama_desa_kelurahan ? 'Desa ' . $d->desaKelurahan->nama_desa_kelurahan : 'Kader Kecamatan' }}</p>
                                    
                                    @if($d->prestasi)
                                        <p class="text-[11px] text-slate-400 line-clamp-2 mt-2 pt-2 border-t border-slate-100 italic">{{ $d->prestasi }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 mt-4 border-t border-slate-100 text-xs">
                                <span class="text-[10px] font-bold text-slate-400 truncate max-w-[120px]">{{ $d->kontak ?: 'Tanpa Kontak' }}</span>
                                <div class="flex items-center gap-1.5">
                                    <x-table.action-btn 
                                        size="sm"
                                        variant="indigo" 
                                        icon="edit-3" 
                                        loading-target="bukaFormEdit('{{ $d->id }}')"
                                        wire:click="bukaFormEdit('{{ $d->id }}')" 
                                        title="Edit Duta" 
                                    />
                                    <x-table.action-btn 
                                        size="sm"
                                        variant="danger" 
                                        icon="trash-2" 
                                        loading-target="hapus('{{ $d->id }}')"
                                        wire:click="hapus('{{ $d->id }}')" 
                                        wire:confirm="Yakin ingin menghapus data duta olahraga ini?" 
                                        title="Hapus Duta" 
                                    />
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                            <i data-lucide="award" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                            <p class="text-sm font-bold text-slate-600">Belum ada data Duta Olahraga yang sesuai.</p>
                            <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-indigo-600 text-white font-bold text-xs cursor-pointer">
                                + Tambah Duta Olahraga
                            </button>
                        </div>
                    @endforelse
                </div>

                @if($dutaList->hasPages())
                    <div class="mt-4">
                        {{ $dutaList->links() }}
                    </div>
                @endif
            @endif
        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM DUTA OLAHRAGA     -->
        <!-- ========================================== -->
        <div class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header 
                :title="$dutaId ? 'Edit Biodata Duta Olahraga' : 'Registrasi Duta Olahraga Baru'"
                subtitle="Lengkapi data profil kader duta penggerak, pilih wilayah penugasan, dan unggah pas foto resmi."
                :badge="$dutaId ? 'Mode Edit Duta' : 'Duta Baru'"
                icon="award"
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
                        {{ $dutaId ? 'Perbarui Data Duta' : 'Simpan Duta Olahraga' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (7 cols): Metadata -->
                    <div class="lg:col-span-7 space-y-6">
                        <x-form.card 
                            title="Biodata & Informasi Wilayah" 
                            subtitle="Identitas lengkap kader dan wilayah penugasan di Kabupaten Bandung."
                            icon="user-check"
                            size="default"
                        >
                            <!-- Nama Lengkap -->
                            <x-form.field label="Nama Lengkap Beserta Gelar" name="nama_lengkap" :required="true">
                                <x-form.input 
                                    name="nama_lengkap" 
                                    wire:model="nama_lengkap" 
                                    placeholder="Contoh: Rian Hidayat, S.Pd." 
                                    size="lg"
                                    icon="user"
                                />
                            </x-form.field>

                            <!-- Wilayah Kecamatan & Desa -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Kecamatan Penugasan" name="kecamatan_id" :required="true">
                                    <x-form.select name="kecamatan_id" wire:model.live="kecamatan_id">
                                        @foreach($kecamatanList as $kec)
                                            <option value="{{ $kec->id }}">Kec. {{ $kec->nama_kecamatan }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <x-form.field label="Desa / Kelurahan" name="desa_kelurahan_id">
                                    <x-form.select name="desa_kelurahan_id" wire:model="desa_kelurahan_id">
                                        <option value="">-- Tingkat Kecamatan --</option>
                                        @foreach($desaList as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama_desa_kelurahan }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>
                            </div>

                            <!-- Kategori & Tahun -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Kategori Duta" name="kategori_duta" :required="true">
                                    <x-form.select name="kategori_duta" wire:model="kategori_duta">
                                        <option value="Duta Olahraga Masyarakat">Duta Olahraga Masyarakat</option>
                                        <option value="Duta Pemuda & Kebugaran">Duta Pemuda & Kebugaran</option>
                                        <option value="Duta Lansia Bugar">Duta Lansia Bugar</option>
                                        <option value="Duta Pelajar Berprestasi">Duta Pelajar Berprestasi</option>
                                    </x-form.select>
                                </x-form.field>

                                <x-form.field label="Tahun Pemilihan" name="tahun_pemilihan" :required="true">
                                    <x-form.input 
                                        type="number"
                                        name="tahun_pemilihan" 
                                        wire:model="tahun_pemilihan" 
                                        min="2020" 
                                        max="2030"
                                        icon="calendar"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Kontak & Telepon -->
                            <x-form.field label="Nomor Telepon / WhatsApp (Opsional)" name="kontak">
                                <x-form.input 
                                    type="text"
                                    name="kontak" 
                                    wire:model="kontak" 
                                    placeholder="Contoh: 081234567890" 
                                    icon="phone"
                                />
                            </x-form.field>

                            <!-- Prestasi / Catatan -->
                            <x-form.field label="Catatan Prestasi & Pengalaman Organisasi (Opsional)" name="prestasi">
                                <x-form.textarea 
                                    name="prestasi" 
                                    wire:model="prestasi" 
                                    placeholder="Tuliskan jejak rekam, kejuaraan, atau kontribusi olahraga masyarakat..."
                                    rows="3"
                                />
                            </x-form.field>
                        </x-form.card>
                    </div>

                    <!-- Right Column (5 cols): Photo Upload -->
                    <div class="lg:col-span-5 space-y-6">
                        <x-form.card 
                            title="Pas Foto Resmi Duta" 
                            subtitle="Unggah foto profil formal kader duta olahraga."
                            icon="image"
                            size="default"
                        >
                            <x-form.image-upload 
                                :upload="$uploadFotoDuta" 
                                :savedPath="$foto_url" 
                                name="uploadFotoDuta"
                                inputId="uploadFotoDutaInput"
                                accept="image/jpeg,image/png,image/webp"
                                :maxSizeMB="5"
                                emptyTitle="Pilih Pas Foto Duta"
                                emptySubtitle="Format JPG, PNG, WEBP (Maks. 5MB)"
                                aspectRatio="h-72 sm:h-80"
                            />
                        </x-form.card>
                    </div>
                </div>

                <!-- 3. ACTION BAR FOOTER -->
                <x-form.action-bar 
                    cancel-text="Batal & Kembali" 
                    cancel-action="kembaliKeTabel" 
                    :submit-text="$dutaId ? 'Perbarui Data Duta' : 'Simpan Duta Olahraga'" 
                    loading-target="simpan" 
                />
            </form>
        </div>
    @endif

</div>
