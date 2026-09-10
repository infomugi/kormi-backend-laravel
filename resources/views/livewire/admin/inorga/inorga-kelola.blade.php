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
        <!-- VIEW MODE: TABEL DAFTAR INORGA             -->
        <!-- ========================================== -->
        <div wire:key="inorga-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola Induk Organisasi Olahraga"
                subtitle="Data Inorga terdaftar di bawah 3 Komisi Resmi KORMI: OTDA (Tradisional), OKK (Kebugaran), dan OPT (Petualangan)."
                badge="Kelembagaan & Anggota • Induk Olahraga (INORGA)"
                icon="shapes"
                color="amber"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormTambah" 
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Tambah Inorga</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Inorga"
                    :value="number_format($totalInorga)"
                    unit="Induk"
                    subtitle="Semua cabor terdaftar"
                    icon="shapes"
                    color="amber"
                    :active="$komisiDipilih === 'Semua' && $statusDipilih === 'Semua'"
                    loading-target="resetSemuaFilter, setFilterKomisi, setFilterStatus"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Inorga Aktif"
                    :value="number_format($totalAktif)"
                    unit="Aktif"
                    subtitle="Terverifikasi resmi"
                    icon="check-circle"
                    color="emerald"
                    :pulse="true"
                    :active="$statusDipilih === 'aktif'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('aktif')"
                />

                <x-table.stats-card
                    title="Verifikasi / Tenggang"
                    :value="number_format($totalTenggang)"
                    unit="Organisasi"
                    subtitle="Perlu peninjauan berkas"
                    icon="alert-circle"
                    color="rose"
                    :active="in_array($statusDipilih, ['verifikasi', 'masa_tenggang'])"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('verifikasi')"
                />

                <x-table.stats-card
                    title="Total Klub Anggota"
                    :value="number_format($totalKlub)"
                    unit="Klub"
                    subtitle="Klub / sanggar / komunitas"
                    icon="users"
                    color="indigo"
                    loading-target="cari, setFilterKomisi"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar search-placeholder="Cari singkatan, nama inorga, ketua..." search-model="cari">
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                        <button 
                            type="button"
                            wire:click="setFilterKomisi('Semua')" 
                            class="px-4 py-2 rounded-2xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap shrink-0 flex items-center gap-1.5 {{ $komisiDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <span>Semua Komisi</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $komisiDipilih === 'Semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $totalInorga }}</span>
                        </button>

                        @foreach($komisiList as $k)
                            <button 
                                type="button"
                                wire:click="setFilterKomisi('{{ $k->id }}')" 
                                class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $komisiDipilih === $k->id ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                            >
                                <i data-lucide="layers" class="w-3.5 h-3.5 {{ $komisiDipilih === $k->id ? 'text-white' : 'text-amber-600' }}"></i>
                                <span>{{ $k->singkatan }} - {{ $k->nama_komisi }}</span>
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $komisiDipilih === $k->id ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $k->inorga_count }}</span>
                            </button>
                        @endforeach
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <!-- Status Filter -->
                    <select wire:model.live="statusDipilih" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="Semua">Semua Status</option>
                        <option value="aktif">Aktif Terdaftar</option>
                        <option value="verifikasi">Dalam Verifikasi</option>
                        <option value="masa_tenggang">Masa Tenggang</option>
                        <option value="tidak_aktif">Tidak Aktif</option>
                    </select>

                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="singkatan">Urutan: Singkatan (A-Z)</option>
                        <option value="nama_inorga">Urutan: Nama Inorga</option>
                        <option value="jumlah_klub_anggota">Urutan: Klub Terbanyak</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="asc">Menaik (ASC)</option>
                        <option value="desc">Menurun (DESC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all cursor-pointer">
                        <option value="12">12 / hal</option>
                        <option value="24">24 / hal</option>
                        <option value="48">48 / hal</option>
                    </select>

                    <!-- View Switcher with localStorage persistence -->
                    <div 
                        x-data="{
                            mode: localStorage.getItem('kormi_inorga_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_inorga_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_inorga_view') && localStorage.getItem('kormi_inorga_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_inorga_view'));
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
            <x-table.bulk-bar :count="count($selectedInorga)" label="Inorga dipilih" reset-action="resetSelection">
                <button 
                    type="button" 
                    wire:click="bulkSetStatus('aktif')" 
                    class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                    <span>Set Aktif</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkSetStatus('verifikasi')" 
                    class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                    <span>Set Verifikasi</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDelete" 
                    wire:confirm="Yakin ingin menghapus {{ count($selectedInorga) }} Inorga terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. CONTENT (DATATABLE & GRID CARDS) -->
            @if($tampilanMode === 'tabel')
                <x-table.card>
                    <x-table.table loading-target="cari, komisiDipilih, statusDipilih, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
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
                                    sort-field="singkatan" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Singkatan & Logo
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="nama_inorga" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Nama Lengkap Inorga
                                </x-table.th>
                                <x-table.th>Komisi Induk</x-table.th>
                                <x-table.th 
                                    align="center" 
                                    sortable 
                                    sort-field="jumlah_klub_anggota" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Jumlah Klub
                                </x-table.th>
                                <x-table.th align="center">Status</x-table.th>
                                <x-table.th align="right">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>
                        <x-table.tbody>
                            @forelse($inorgaList as $ino)
                                <x-table.tr wire:key="row-inorga-{{ $ino->id }}" :selected="in_array($ino->id, $selectedInorga)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-3.5 w-10">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedInorga" 
                                            value="{{ $ino->id }}" 
                                            class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Singkatan & Logo -->
                                    <x-table.td>
                                        <div class="flex items-center gap-3">
                                            @if($ino->logo_url)
                                                <img 
                                                    src="{{ $ino->logo_url }}" 
                                                    alt="{{ $ino->singkatan }}" 
                                                    class="w-9 h-9 rounded-xl object-contain bg-white border border-slate-200 p-1 shrink-0 shadow-2xs"
                                                >
                                            @else
                                                <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-center justify-center font-black text-xs shrink-0">
                                                    {{ substr($ino->singkatan, 0, 2) }}
                                                </div>
                                            @endif
                                            <span class="font-black text-slate-900 text-xs tracking-wider">
                                                {{ $ino->singkatan }}
                                            </span>
                                        </div>
                                    </x-table.td>

                                    <!-- Nama Lengkap Inorga & Ketua -->
                                    <x-table.td>
                                        <div class="min-w-0 max-w-md space-y-0.5">
                                            <a 
                                                href="javascript:void(0)" 
                                                wire:click="bukaFormEdit('{{ $ino->id }}')" 
                                                class="font-black text-slate-900 text-xs hover:text-amber-600 line-clamp-1 leading-tight transition-colors cursor-pointer"
                                            >
                                                {{ $ino->nama_inorga }}
                                            </a>
                                            <div class="text-[11px] text-slate-400 font-medium flex items-center gap-2">
                                                @if($ino->nama_ketua)
                                                    <span>Ketua: {{ $ino->nama_ketua }}</span>
                                                    <span>•</span>
                                                @endif
                                                <span>Slug: {{ $ino->slug }}</span>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Komisi Induk -->
                                    <x-table.td>
                                        @php
                                            $komisiSingkat = $ino->komisi->singkatan ?? '';
                                            $komisiColor = match($komisiSingkat) {
                                                'OTDA' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'OKK' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'OPT' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                default => 'bg-slate-100 text-slate-700 border-slate-200'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $komisiColor }}">
                                            {{ $ino->komisi->singkatan ?? '-' }}
                                        </span>
                                    </x-table.td>

                                    <!-- Jumlah Klub -->
                                    <x-table.td align="center">
                                        <span class="inline-flex items-center gap-1 font-black text-slate-800 bg-slate-100 px-3 py-1 rounded-xl text-xs">
                                            <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i>
                                            {{ $ino->jumlah_klub_anggota }} Klub
                                        </span>
                                    </x-table.td>

                                    <!-- Status Keanggotaan -->
                                    <x-table.td align="center">
                                        @php
                                            $statusClass = match($ino->status_keanggotaan) {
                                                'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'verifikasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'masa_tenggang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                default => 'bg-rose-50 text-rose-700 border-rose-200'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusClass }}">
                                            {{ str_replace('_', ' ', $ino->status_keanggotaan) }}
                                        </span>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="right">
                                        <div class="flex items-center justify-end gap-1">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="warning" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdit('{{ $ino->id }}')"
                                                wire:click="bukaFormEdit('{{ $ino->id }}')" 
                                                title="Edit Inorga" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="hapus('{{ $ino->id }}')"
                                                wire:click="hapus('{{ $ino->id }}')" 
                                                wire:confirm="Yakin ingin menghapus Inorga ini dari sistem CMS?" 
                                                title="Hapus Inorga" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="7" 
                                    icon="shapes" 
                                    title="Belum ada Inorga yang sesuai" 
                                    description="Silakan tambah Induk Organisasi Olahraga baru ke sistem."
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    @if($inorgaList->hasPages())
                        <x-slot:footer>
                            <div class="px-4 py-3 flex items-center justify-between">
                                {{ $inorgaList->links() }}
                            </div>
                        </x-slot:footer>
                    @endif
                </x-table.card>
            @else
                <!-- GRID VIEW FOR INORGA -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($inorgaList as $ino)
                        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between group">
                            <div>
                                <div class="flex items-start justify-between gap-3 mb-4">
                                    @php
                                        $komisiSingkat = $ino->komisi->singkatan ?? '';
                                        $komisiColor = match($komisiSingkat) {
                                            'OTDA' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'OKK' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'OPT' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            default => 'bg-slate-100 text-slate-700 border-slate-200'
                                        };
                                        $statusClass = match($ino->status_keanggotaan) {
                                            'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'verifikasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'masa_tenggang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            default => 'bg-rose-50 text-rose-700 border-rose-200'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $komisiColor }}">
                                        {{ $ino->komisi->singkatan ?? '-' }}
                                    </span>

                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusClass }}">
                                        {{ str_replace('_', ' ', $ino->status_keanggotaan) }}
                                    </span>
                                </div>

                                <div class="flex items-start gap-3.5">
                                    @if($ino->logo_url)
                                        <img 
                                            src="{{ $ino->logo_url }}" 
                                            alt="{{ $ino->singkatan }}" 
                                            class="w-12 h-12 rounded-2xl object-contain bg-white border border-slate-200 p-1 shrink-0 shadow-2xs"
                                        >
                                    @else
                                        <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 flex items-center justify-center font-black text-sm shrink-0">
                                            {{ substr($ino->singkatan, 0, 2) }}
                                        </div>
                                    @endif

                                    <div class="min-w-0 flex-1">
                                        <span class="font-black text-slate-900 text-sm tracking-wider block">
                                            {{ $ino->singkatan }}
                                        </span>
                                        <h3 class="font-bold text-slate-700 text-xs group-hover:text-amber-600 transition-colors line-clamp-2 leading-snug mt-0.5">
                                            {{ $ino->nama_inorga }}
                                        </h3>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-500">
                                    @if($ino->nama_ketua)
                                        <p class="flex items-center gap-1.5">
                                            <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                            <span class="truncate">Ketua: <strong class="text-slate-700">{{ $ino->nama_ketua }}</strong></span>
                                        </p>
                                    @endif
                                    @if($ino->kontak_person)
                                        <p class="flex items-center gap-1.5">
                                            <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                            <span class="truncate">{{ $ino->kontak_person }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 mt-4 border-t border-slate-100">
                                <span class="inline-flex items-center gap-1 font-bold text-slate-600 text-xs bg-slate-100 px-2.5 py-1 rounded-xl">
                                    <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i>
                                    <span>{{ $ino->jumlah_klub_anggota }} Klub</span>
                                </span>

                                <div class="flex items-center gap-1.5">
                                    <x-table.action-btn 
                                        size="sm"
                                        variant="warning" 
                                        icon="edit-3" 
                                        loading-target="bukaFormEdit('{{ $ino->id }}')"
                                        wire:click="bukaFormEdit('{{ $ino->id }}')" 
                                        title="Edit Inorga" 
                                    />

                                    <x-table.action-btn 
                                        size="sm"
                                        variant="danger" 
                                        icon="trash-2" 
                                        loading-target="hapus('{{ $ino->id }}')"
                                        wire:click="hapus('{{ $ino->id }}')" 
                                        wire:confirm="Yakin ingin menghapus Inorga ini dari sistem CMS?" 
                                        title="Hapus Inorga" 
                                    />
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                            <i data-lucide="shapes" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                            <p class="text-sm font-bold text-slate-600">Belum ada Inorga ditemukan.</p>
                            <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-amber-600 text-white font-bold text-xs cursor-pointer">
                                + Tambah Inorga Baru
                            </button>
                        </div>
                    @endforelse
                </div>

                @if($inorgaList->hasPages())
                    <div class="mt-4">
                        {{ $inorgaList->links() }}
                    </div>
                @endif
            @endif
        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM INORGA (UI KIT)    -->
        <!-- ========================================== -->
        <div class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header 
                :title="$inorgaId ? 'Edit Data Kelembagaan Inorga' : 'Pendaftaran Induk Organisasi Baru'"
                subtitle="Isi singkatan cabor, pilih komisi induk KORMI, nama ketua, dan unggah logo resmi."
                :badge="$inorgaId ? 'Mode Edit Inorga' : 'Inorga Baru'"
                icon="shapes"
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
                        {{ $inorgaId ? 'Perbarui Inorga' : 'Simpan Inorga' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Data Organisasi -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Informasi Induk Organisasi" 
                            subtitle="Identitas cabor, komisi pengampu, dan status keanggotaan."
                            icon="file-text"
                            size="default"
                        >
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Singkatan -->
                                <x-form.field label="Singkatan / Akronim Inorga" name="singkatan" :required="true">
                                    <x-form.input 
                                        name="singkatan" 
                                        wire:model="singkatan" 
                                        placeholder="Contoh: PORTINA, FOKBI..." 
                                        class="uppercase font-extrabold tracking-wider"
                                    />
                                </x-form.field>

                                <!-- Komisi Induk -->
                                <x-form.field label="Komisi Induk KORMI" name="komisi_id" :required="true">
                                    <x-form.select name="komisi_id" wire:model="komisi_id">
                                        @foreach($komisiList as $k)
                                            <option value="{{ $k->id }}">{{ $k->singkatan }} - {{ $k->nama_komisi }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>
                            </div>

                            <!-- Nama Lengkap Inorga -->
                            <x-form.field label="Nama Lengkap Organisasi" name="nama_inorga" :required="true">
                                <x-form.input 
                                    name="nama_inorga" 
                                    wire:model="nama_inorga" 
                                    placeholder="Contoh: Persatuan Olahraga Tradisional Indonesia..." 
                                    size="lg"
                                />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Status Keanggotaan -->
                                <x-form.field label="Status Keanggotaan" name="status_keanggotaan" :required="true">
                                    <x-form.select name="status_keanggotaan" wire:model="status_keanggotaan">
                                        <option value="aktif">Aktif Terdaftar</option>
                                        <option value="verifikasi">Dalam Verifikasi</option>
                                        <option value="masa_tenggang">Masa Tenggang</option>
                                        <option value="tidak_aktif">Tidak Aktif</option>
                                    </x-form.select>
                                </x-form.field>

                                <!-- Jumlah Klub Anggota -->
                                <x-form.field label="Jumlah Klub / Sanggar Terdata" name="jumlah_klub_anggota" :required="true">
                                    <x-form.input 
                                        type="number"
                                        name="jumlah_klub_anggota" 
                                        wire:model="jumlah_klub_anggota" 
                                        min="0"
                                    />
                                </x-form.field>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Nama Ketua -->
                                <x-form.field label="Nama Ketua Pengurus" name="nama_ketua">
                                    <x-form.input 
                                        name="nama_ketua" 
                                        wire:model="nama_ketua" 
                                        placeholder="Nama ketua pengurus..."
                                        icon="user"
                                    />
                                </x-form.field>

                                <!-- Kontak Person -->
                                <x-form.field label="Kontak Person / Telepon" name="kontak_person">
                                    <x-form.input 
                                        name="kontak_person" 
                                        wire:model="kontak_person" 
                                        placeholder="0812xxxx / email..."
                                        icon="phone"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Deskripsi Kegiatan -->
                            <x-form.field label="Deskripsi / Cakupan Olahraga (Opsional)" name="deskripsi_singkat">
                                <x-form.textarea 
                                    name="deskripsi_singkat" 
                                    wire:model="deskripsi_singkat" 
                                    placeholder="Jelaskan cabang olahraga rekreasi, jenis permainan atau kegiatan binaan inorga ini..."
                                    rows="3"
                                />
                            </x-form.field>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Logo Upload & Guide -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Logo Upload -->
                        <x-form.card 
                            title="Logo Resmi Inorga" 
                            subtitle="Format PNG transparan disarankan (Maks 5MB)"
                            icon="image"
                            size="default"
                        >
                            <x-form.image-upload 
                                :upload="$uploadLogo" 
                                :savedImage="$logo_url" 
                                name="uploadLogo"
                                inputId="uploadLogoInorga"
                                title="Klik atau seret logo ke sini"
                                subtitle="PNG, JPG, WEBP (Maks. 5MB)"
                            />
                        </x-form.card>

                        <!-- Guide Info Card -->
                        <div class="bg-amber-50/70 border border-amber-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-amber-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="info" class="w-4 h-4 text-amber-600"></i>
                                <span>3 Komisi Resmi KORMI</span>
                            </h4>
                            <div class="space-y-2 text-xs text-amber-950">
                                <div class="bg-white/80 p-2.5 rounded-xl border border-amber-200/60">
                                    <strong>OTDA:</strong> Olahraga Tradisional & Budaya (Dagongan, Egrang, Sumpitan, dll).
                                </div>
                                <div class="bg-white/80 p-2.5 rounded-xl border border-amber-200/60">
                                    <strong>OKK:</strong> Kesehatan & Kebugaran (Senam, Yoga, Jalan Sehat, dll).
                                </div>
                                <div class="bg-white/80 p-2.5 rounded-xl border border-amber-200/60">
                                    <strong>OPT:</strong> Petualangan & Tantangan (Skateboard, Panjat Tebing, Airsoft, dll).
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. STICKY ACTION BAR -->
                <x-form.action-bar>
                    <x-form.button 
                        variant="secondary" 
                        size="default" 
                        icon="arrow-left" 
                        wire:click="kembaliKeTabel"
                    >
                        Batal
                    </x-form.button>

                    <x-form.button 
                        variant="warning" 
                        size="default" 
                        type="submit" 
                        icon="check" 
                        loading-target="simpan"
                    >
                        {{ $inorgaId ? 'Perbarui Inorga' : 'Simpan Inorga ke Database' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

</div>
