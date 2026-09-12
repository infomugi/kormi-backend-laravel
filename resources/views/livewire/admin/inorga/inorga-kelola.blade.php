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

            <!-- 1. HEADER & PRIMARY ACTION -->
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
            <x-table.filter-bar search-placeholder="Cari singkatan, nama inorga, nomor SK, ketua, kontak..." search-model="cari">
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
                        <option value="tanggal_sk">Urutan: Tanggal SK</option>
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
                    wire:click="bulkSetStatus('masa_tenggang')" 
                    class="px-3 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
                    <span>Set Tenggang</span>
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
                                <x-table.th>Legalitas / SK & Kontak</x-table.th>
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

                                    <!-- Singkatan & Logo (With Inline Edit Singkatan) -->
                                    <x-table.td>
                                        <div class="flex items-center gap-3">
                                            @if($ino->logo_url)
                                                <img 
                                                    src="{{ $ino->logo_url }}" 
                                                    alt="{{ $ino->singkatan }}" 
                                                    class="w-9 h-9 rounded-xl object-contain bg-white border border-slate-200 p-1 shrink-0 shadow-2xs cursor-pointer"
                                                    wire:click="bukaPratinjau('{{ $ino->id }}')"
                                                >
                                            @else
                                                <div 
                                                    wire:click="bukaPratinjau('{{ $ino->id }}')"
                                                    class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-center justify-center font-black text-xs shrink-0 cursor-pointer"
                                                >
                                                    {{ substr($ino->singkatan, 0, 2) }}
                                                </div>
                                            @endif
                                            
                                            <!-- Inline Editable Singkatan -->
                                            <div 
                                                x-data="{ 
                                                    editing: false, 
                                                    val: '{{ addslashes($ino->singkatan) }}',
                                                    save() {
                                                        if (this.val.trim() !== '' && this.val !== '{{ addslashes($ino->singkatan) }}') {
                                                            $wire.updateFieldInline('{{ $ino->id }}', 'singkatan', this.val);
                                                        }
                                                        this.editing = false;
                                                    }
                                                }"
                                                class="min-w-0"
                                            >
                                                <div x-show="!editing" @dblclick="editing = true; $nextTick(() => $refs.input.focus())" class="cursor-pointer group/inline flex items-center gap-1">
                                                    <span class="font-black text-slate-900 text-xs tracking-wider group-hover/inline:text-amber-600">
                                                        {{ $ino->singkatan }}
                                                    </span>
                                                    <i data-lucide="edit-2" class="w-3 h-3 text-slate-300 opacity-0 group-hover/inline:opacity-100 transition-opacity"></i>
                                                </div>
                                                <input 
                                                    x-ref="input"
                                                    x-show="editing" 
                                                    x-model="val" 
                                                    @keydown.enter="save()" 
                                                    @keydown.escape="editing = false; val = '{{ addslashes($ino->singkatan) }}'" 
                                                    @blur="save()"
                                                    type="text" 
                                                    class="px-1.5 py-0.5 bg-amber-50 border border-amber-300 rounded text-xs font-black text-slate-900 uppercase w-24 focus:outline-none focus:ring-1 focus:ring-amber-500"
                                                >
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Nama Lengkap Inorga & Ketua (With Inline Edit Nama Inorga) -->
                                    <x-table.td>
                                        <div class="min-w-0 max-w-md space-y-0.5">
                                            <!-- Inline Editable Nama Inorga -->
                                            <div 
                                                x-data="{ 
                                                    editing: false, 
                                                    val: '{{ addslashes($ino->nama_inorga) }}',
                                                    save() {
                                                        if (this.val.trim() !== '' && this.val !== '{{ addslashes($ino->nama_inorga) }}') {
                                                            $wire.updateFieldInline('{{ $ino->id }}', 'nama_inorga', this.val);
                                                        }
                                                        this.editing = false;
                                                    }
                                                }"
                                            >
                                                <div x-show="!editing" @dblclick="editing = true; $nextTick(() => $refs.namaInput.focus())" class="cursor-pointer group/inline flex items-start gap-1">
                                                    <span class="font-black text-slate-900 text-xs hover:text-amber-600 line-clamp-1 leading-tight transition-colors">
                                                        {{ $ino->nama_inorga }}
                                                    </span>
                                                    <i data-lucide="edit-2" class="w-3 h-3 text-slate-300 opacity-0 group-hover/inline:opacity-100 transition-opacity shrink-0 mt-0.5"></i>
                                                </div>
                                                <input 
                                                    x-ref="namaInput"
                                                    x-show="editing" 
                                                    x-model="val" 
                                                    @keydown.enter="save()" 
                                                    @keydown.escape="editing = false; val = '{{ addslashes($ino->nama_inorga) }}'" 
                                                    @blur="save()"
                                                    type="text" 
                                                    class="w-full px-2 py-1 bg-amber-50 border border-amber-300 rounded text-xs font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-amber-500"
                                                >
                                            </div>

                                            <div class="text-[11px] text-slate-400 font-medium flex items-center gap-2">
                                                @if($ino->nama_ketua)
                                                    <span class="truncate max-w-[140px]">Ketua: <strong class="text-slate-600">{{ $ino->nama_ketua }}</strong></span>
                                                    <span>•</span>
                                                @endif
                                                <span>Slug: {{ $ino->slug }}</span>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Komisi Induk (Inline Select) -->
                                    <x-table.td>
                                        <select 
                                            wire:change="updateFieldInline('{{ $ino->id }}', 'komisi_id', $event.target.value)"
                                            class="text-[10px] font-black uppercase tracking-wider px-2 py-1 rounded-full border cursor-pointer focus:outline-none focus:ring-1 focus:ring-amber-500 {{ match($ino->komisi->singkatan ?? '') {
                                                'OTDA' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'OKK' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'OPT' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                default => 'bg-slate-100 text-slate-700 border-slate-200'
                                            } }}"
                                        >
                                            @foreach($komisiList as $k)
                                                <option value="{{ $k->id }}" {{ $ino->komisi_id === $k->id ? 'selected' : '' }}>
                                                    {{ $k->singkatan }} - {{ $k->nama_komisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </x-table.td>

                                    <!-- Legalitas / SK & Kontak -->
                                    <x-table.td>
                                        <div class="text-xs space-y-0.5">
                                            @if($ino->nomor_sk)
                                                <div class="text-[11px] font-bold text-slate-700 flex items-center gap-1">
                                                    <i data-lucide="file-text" class="w-3 h-3 text-amber-600 shrink-0"></i>
                                                    <span class="truncate max-w-[160px]">{{ $ino->nomor_sk }}</span>
                                                </div>
                                            @else
                                                <span class="text-[10px] text-slate-400 italic block">Tanpa Nomor SK</span>
                                            @endif

                                            <div class="text-[10px] text-slate-500 flex items-center gap-1.5">
                                                @if($ino->nomor_telepon || $ino->kontak_person)
                                                    <span class="text-slate-600 font-semibold">{{ $ino->nomor_telepon ?: $ino->kontak_person }}</span>
                                                @endif
                                                @if($ino->email)
                                                    <span class="text-slate-400">• {{ $ino->email }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Jumlah Klub (Inline editable) -->
                                    <x-table.td align="center">
                                        <div 
                                            x-data="{ 
                                                editing: false, 
                                                val: '{{ $ino->jumlah_klub_anggota }}',
                                                save() {
                                                    if (this.val !== '' && this.val != '{{ $ino->jumlah_klub_anggota }}') {
                                                        $wire.updateFieldInline('{{ $ino->id }}', 'jumlah_klub_anggota', this.val);
                                                    }
                                                    this.editing = false;
                                                }
                                            }"
                                        >
                                            <span 
                                                x-show="!editing" 
                                                @dblclick="editing = true; $nextTick(() => $refs.klubInput.focus())"
                                                class="inline-flex items-center gap-1 font-black text-slate-800 bg-slate-100 px-3 py-1 rounded-xl text-xs cursor-pointer hover:bg-amber-100 hover:text-amber-900 transition-colors"
                                                title="Klik 2x untuk ubah jumlah klub"
                                            >
                                                <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i>
                                                {{ $ino->jumlah_klub_anggota }} Klub
                                            </span>
                                            <input 
                                                x-ref="klubInput"
                                                x-show="editing" 
                                                x-model="val" 
                                                @keydown.enter="save()" 
                                                @keydown.escape="editing = false; val = '{{ $ino->jumlah_klub_anggota }}'" 
                                                @blur="save()"
                                                type="number" 
                                                min="0"
                                                class="w-16 px-1.5 py-0.5 bg-amber-50 border border-amber-300 rounded text-center text-xs font-black text-slate-900 focus:outline-none focus:ring-1 focus:ring-amber-500"
                                            >
                                        </div>
                                    </x-table.td>

                                    <!-- Status Keanggotaan (Inline Select) -->
                                    <x-table.td align="center">
                                        <select 
                                            wire:change="updateFieldInline('{{ $ino->id }}', 'status_keanggotaan', $event.target.value)"
                                            class="text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full border cursor-pointer focus:outline-none focus:ring-1 focus:ring-amber-500 {{ match($ino->status_keanggotaan) {
                                                'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'verifikasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'masa_tenggang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                default => 'bg-rose-50 text-rose-700 border-rose-200'
                                            } }}"
                                        >
                                            <option value="aktif" {{ $ino->status_keanggotaan === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="verifikasi" {{ $ino->status_keanggotaan === 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                            <option value="masa_tenggang" {{ $ino->status_keanggotaan === 'masa_tenggang' ? 'selected' : '' }}>Masa Tenggang</option>
                                            <option value="tidak_aktif" {{ $ino->status_keanggotaan === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="right">
                                        <div class="flex items-center justify-end gap-1">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="secondary" 
                                                icon="eye" 
                                                wire:click="bukaPratinjau('{{ $ino->id }}')" 
                                                title="Lihat Profil Inorga" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="warning" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdit('{{ $ino->id }}')"
                                                wire:click="bukaFormEdit('{{ $ino->id }}')" 
                                                title="Edit Data Lengkap" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="secondary" 
                                                icon="copy" 
                                                wire:click="duplikatInorga('{{ $ino->id }}')" 
                                                title="Duplikat Inorga" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                wire:click="konfirmasiHapus('{{ $ino->id }}')" 
                                                title="Hapus Inorga" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="8" 
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
                        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between group {{ in_array($ino->id, $selectedInorga) ? 'ring-2 ring-amber-500' : '' }}">
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

                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusClass }}">
                                            {{ str_replace('_', ' ', $ino->status_keanggotaan) }}
                                        </span>
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedInorga" 
                                            value="{{ $ino->id }}" 
                                            class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                                        >
                                    </div>
                                </div>

                                <div class="flex items-start gap-3.5 cursor-pointer" wire:click="bukaPratinjau('{{ $ino->id }}')">
                                    @if($ino->logo_url)
                                        <img 
                                            src="{{ $ino->logo_url }}" 
                                            alt="{{ $ino->singkatan }}" 
                                            class="w-12 h-12 rounded-2xl object-contain bg-white border border-slate-200 p-1 shrink-0 shadow-2xs group-hover:scale-105 transition-transform"
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
                                    @if($ino->nomor_sk)
                                        <p class="flex items-center gap-1.5 text-[11px] text-amber-800 font-semibold">
                                            <i data-lucide="file-text" class="w-3.5 h-3.5 text-amber-600 shrink-0"></i>
                                            <span class="truncate">SK: {{ $ino->nomor_sk }}</span>
                                        </p>
                                    @endif
                                    @if($ino->nama_ketua)
                                        <p class="flex items-center gap-1.5">
                                            <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                            <span class="truncate">Ketua: <strong class="text-slate-700">{{ $ino->nama_ketua }}</strong></span>
                                        </p>
                                    @endif
                                    @if($ino->kontak_person || $ino->nomor_telepon)
                                        <p class="flex items-center gap-1.5">
                                            <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                            <span class="truncate">{{ $ino->nomor_telepon ?: $ino->kontak_person }}</span>
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
                                        variant="secondary" 
                                        icon="eye" 
                                        wire:click="bukaPratinjau('{{ $ino->id }}')" 
                                        title="Pratinjau Inorga" 
                                    />

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
                                        wire:click="konfirmasiHapus('{{ $ino->id }}')" 
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
                :title="$inorgaId ? 'Edit Data Kelembagaan Inorga' : 'Pendaftaran Induk Organisasi Olahraga Baru'"
                subtitle="Lengkapi identitas cabor, legalitas SK pengukuhan, komisi induk KORMI, kepengurusan, dan logo resmi."
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
                    <!-- Left Column (7 cols): Data Organisasi & Legalitas -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- CARD 1: IDENTITAS ORGANISASI -->
                        <x-form.card 
                            title="Identitas Induk Organisasi" 
                            subtitle="Singkatan cabor, nama resmi, dan komisi pengampu di KORMI."
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
                                        icon="users"
                                    />
                                </x-form.field>
                            </div>
                        </x-form.card>

                        <!-- CARD 2: LEGALITAS & KEPENGURUSAN -->
                        <x-form.card 
                            title="Legalitas SK & Kepengurusan" 
                            subtitle="Nomor SK pengukuhan, tanggal legalitas, dan pimpinan organisasi."
                            icon="award"
                            size="default"
                        >
                            <!-- Nomor SK & Tanggal SK -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Nomor SK Pengukuhan / SK KORMI" name="nomor_sk">
                                    <x-form.input 
                                        name="nomor_sk" 
                                        wire:model="nomor_sk" 
                                        placeholder="Contoh: 012/SK-KORMI/2025"
                                        icon="file-text"
                                    />
                                </x-form.field>

                                <x-form.field label="Tanggal SK Pengukuhan" name="tanggal_sk">
                                    <x-form.datepicker 
                                        name="tanggal_sk" 
                                        wire:model="tanggal_sk" 
                                        :enableTime="false"
                                        dateFormat="Y-m-d"
                                        altFormat="j F Y"
                                        placeholder="Pilih tanggal SK..."
                                    />
                                </x-form.field>
                            </div>

                            <!-- Nama Ketua & Kontak Person -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Nama Ketua Pengurus" name="nama_ketua">
                                    <x-form.input 
                                        name="nama_ketua" 
                                        wire:model="nama_ketua" 
                                        placeholder="Nama ketua pengurus..."
                                        icon="user"
                                    />
                                </x-form.field>

                                <x-form.field label="Nama Kontak Person (PIC)" name="kontak_person">
                                    <x-form.input 
                                        name="kontak_person" 
                                        wire:model="kontak_person" 
                                        placeholder="Nama sekretaris / PIC..."
                                        icon="user-check"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Deskripsi Cakupan Olahraga -->
                            <x-form.field label="Deskripsi / Cakupan Olahraga & Kegiatan" name="deskripsi_kegiatan">
                                <x-form.textarea 
                                    name="deskripsi_kegiatan" 
                                    wire:model="deskripsi_kegiatan" 
                                    placeholder="Jelaskan cabang olahraga rekreasi, jenis permainan atau kegiatan binaan inorga ini..."
                                    rows="3"
                                />
                            </x-form.field>
                        </x-form.card>

                    </div>

                    <!-- Right Column (5 cols): Logo Upload & Kontak Sekretariat -->
                    <div class="lg:col-span-5 space-y-6">
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
                                subtitle="PNG, JPG, WEBP, SVG (Maks. 5MB)"
                                aspectRatio="h-44 sm:h-52"
                            />
                        </x-form.card>

                        <!-- Kontak & Sekretariat -->
                        <x-form.card 
                            title="Kontak & Sekretariat Resmi" 
                            subtitle="Saluran komunikasi resmi dan lokasi sekretariat."
                            icon="map-pin"
                            size="default"
                        >
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Nomor Telepon / WA Resmi" name="nomor_telepon">
                                    <x-form.input 
                                        name="nomor_telepon" 
                                        wire:model="nomor_telepon" 
                                        placeholder="0812xxxxxxx"
                                        icon="phone"
                                    />
                                </x-form.field>

                                <x-form.field label="Email Resmi Organisasi" name="email">
                                    <x-form.input 
                                        type="email"
                                        name="email" 
                                        wire:model="email" 
                                        placeholder="sekretariat@inorga.id"
                                        icon="mail"
                                    />
                                </x-form.field>
                            </div>

                            <x-form.field label="Alamat Lengkap Sekretariat" name="alamat_sekretariat">
                                <x-form.textarea 
                                    name="alamat_sekretariat" 
                                    wire:model="alamat_sekretariat" 
                                    placeholder="Jl. Raya Soreang No..., Komplek Olahraga..."
                                    rows="2"
                                />
                            </x-form.field>
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
                <x-form.action-bar 
                    cancel-text="Batal & Kembali" 
                    cancel-action="kembaliKeTabel" 
                    :submit-text="$inorgaId ? 'Perbarui Inorga' : 'Simpan Inorga ke Database'" 
                    loading-target="simpan" 
                />
            </form>
        </div>
    @endif

    <!-- ========================================================= -->
    <!-- MODAL: PRATINJAU KARTU PROFIL INORGA LENGKAP              -->
    <!-- ========================================================= -->
    @if($tampilkanModalPratinjau && $pratinjauInorga)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i data-lucide="shapes" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">Profil Induk Organisasi Olahraga</h3>
                            <p class="text-[10px] text-slate-400">{{ $pratinjauInorga->komisi->singkatan ?? '-' }} • {{ $pratinjauInorga->komisi->nama_komisi ?? '' }}</p>
                        </div>
                    </div>
                    <button type="button" wire:click="tutupPratinjau" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto space-y-6">
                    <div class="flex flex-col sm:flex-row items-center gap-5">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden bg-white shrink-0 border border-slate-200 p-2 shadow-xs flex items-center justify-center">
                            @if($pratinjauInorga->logo_url)
                                <img src="{{ $pratinjauInorga->logo_url }}" class="w-full h-full object-contain" alt="{{ $pratinjauInorga->singkatan }}">
                            @else
                                <div class="w-full h-full bg-amber-50 text-amber-800 font-black text-2xl flex items-center justify-center rounded-xl">
                                    {{ substr($pratinjauInorga->singkatan, 0, 2) }}
                                </div>
                            @endif
                        </div>

                        <div class="space-y-1.5 text-center sm:text-left flex-1 min-w-0">
                            <div class="flex items-center justify-center sm:justify-start gap-2 flex-wrap">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $pratinjauInorga->singkatan }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ match($pratinjauInorga->status_keanggotaan) {
                                    'aktif' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                    'verifikasi' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                    'masa_tenggang' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    default => 'bg-rose-50 text-rose-700 border border-rose-200'
                                } }}">
                                    {{ str_replace('_', ' ', $pratinjauInorga->status_keanggotaan) }}
                                </span>
                            </div>
                            <h2 class="text-lg font-black text-slate-900 leading-snug">{{ $pratinjauInorga->nama_inorga }}</h2>
                            <p class="text-xs font-bold text-slate-500 flex items-center justify-center sm:justify-start gap-1">
                                <i data-lucide="layers" class="w-3.5 h-3.5 text-amber-600"></i>
                                <span>Komisi {{ $pratinjauInorga->komisi->singkatan ?? '-' }} ({{ $pratinjauInorga->komisi->nama_komisi ?? '-' }})</span>
                            </p>
                        </div>
                    </div>

                    <!-- Detail Legalitas & Kontak Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Nomor SK</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauInorga->nomor_sk ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Tanggal SK</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauInorga->tanggal_sk ? $pratinjauInorga->tanggal_sk->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Jumlah Klub</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauInorga->jumlah_klub_anggota }} Klub</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Nama Ketua</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauInorga->nama_ketua ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Kontak / WA</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauInorga->nomor_telepon ?: ($pratinjauInorga->kontak_person ?: '-') }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Email Resmi</span>
                            <span class="font-bold text-slate-800 truncate block">{{ $pratinjauInorga->email ?: '-' }}</span>
                        </div>
                    </div>

                    @if($pratinjauInorga->alamat_sekretariat)
                        <div class="space-y-1">
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Alamat Sekretariat:</span>
                            <p class="text-xs text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200/60 font-medium">
                                {{ $pratinjauInorga->alamat_sekretariat }}
                            </p>
                        </div>
                    @endif

                    @if($pratinjauInorga->deskripsi_kegiatan)
                        <div class="space-y-1.5">
                            <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider">Cakupan Olahraga & Kegiatan:</h4>
                            <p class="text-xs text-slate-600 leading-relaxed p-3.5 rounded-2xl bg-amber-50/50 border border-amber-100 whitespace-pre-line">
                                {{ $pratinjauInorga->deskripsi_kegiatan }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <button 
                        type="button" 
                        wire:click="bukaFormEdit('{{ $pratinjauInorga->id }}')" 
                        class="px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer flex items-center gap-1.5"
                    >
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                        <span>Edit Data Inorga</span>
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
    <!-- MODAL: KONFIRMASI HAPUS INORGA                            -->
    <!-- ========================================================= -->
    @if($tampilkanModalHapus)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden border border-slate-100 p-6 sm:p-7 space-y-6 text-center">
                <div class="w-14 h-14 rounded-3xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto shadow-sm">
                    <i data-lucide="alert-triangle" class="w-7 h-7"></i>
                </div>

                <div class="space-y-2">
                    <h3 class="text-lg font-black text-slate-900">Hapus Data Inorga?</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Apakah Anda yakin ingin menghapus data Inorga <br>
                        <span class="font-bold text-slate-900 italic">"{{ $hapusNama }}"</span>?
                    </p>
                    <p class="text-[11px] text-rose-600 font-medium">Data dan berkas logo terkait akan dihapus secara permanen dari server.</p>
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
