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
        <!-- VIEW MODE: TABEL STRUKTUR PENGURUS         -->
        <!-- ========================================== -->
        <div wire:key="pengurus-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola Struktur Pengurus KORMI"
                subtitle="Daftar jajaran dewan pengurus, pembina, pimpinan harian, dan bidang kerja KORMI Kabupaten Bandung."
                badge="Kelembagaan & Struktur • Struktur Organisasi"
                icon="users"
                color="blue"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormTambah"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-blue-600 via-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-blue-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="user-plus" class="w-4 h-4 transition-transform group-hover:scale-110 duration-200"></i>
                        <span>Tambah Pengurus Baru</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Pengurus"
                    :value="number_format($totalPengurus)"
                    unit="Personil"
                    subtitle="Seluruh periode arsip"
                    icon="users"
                    color="blue"
                    :active="empty($filterPeriode) && $statusFilter === 'Semua'"
                    loading-target="setFilterPeriode, resetSemuaFilter"
                    wire:click="setFilterPeriode('')"
                />

                <x-table.stats-card
                    title="Periode Terpilih"
                    :value="number_format($totalPengurusPeriode)"
                    unit="Personil"
                    subtitle="{{ Str::limit($namaPeriodeAktif, 20) }}"
                    icon="calendar-check"
                    color="indigo"
                    :active="!empty($filterPeriode)"
                    loading-target="setFilterPeriode"
                />

                <x-table.stats-card
                    title="Tampil di Publik"
                    :value="number_format($totalTampil)"
                    unit="Aktif"
                    subtitle="Dapat diakses publik"
                    icon="eye"
                    color="emerald"
                    :pulse="true"
                    :active="$statusFilter === 'Tampil'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('Tampil')"
                />

                <x-table.stats-card
                    title="Kategori Bidang"
                    :value="number_format($totalBidang)"
                    unit="Divisi"
                    subtitle="Seksi & komisi kerja"
                    icon="network"
                    color="purple"
                    loading-target="filterBidang"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                search-placeholder="Cari nama pengurus, jabatan struktural, bidang..." 
                search-model="cari"
            >
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                        <button 
                            type="button"
                            wire:click="setFilterPeriode('')" 
                            class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ empty($filterPeriode) ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                            <span>Semua Periode</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ empty($filterPeriode) ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $totalPengurus }}</span>
                        </button>

                        @foreach($periodeList as $p)
                            <button 
                                type="button"
                                wire:click="setFilterPeriode('{{ $p->id }}')" 
                                class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $filterPeriode === $p->id ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
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
                    <!-- Filter Bidang -->
                    <select wire:model.live="filterBidang" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        <option value="semua">Semua Bidang Kerja</option>
                        @foreach($bidangList as $b)
                            <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>

                    <!-- Filter Status -->
                    <select wire:model.live="statusFilter" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        <option value="Semua">Semua Status</option>
                        <option value="Tampil">Tampil di Publik</option>
                        <option value="Disembunyikan">Disembunyikan</option>
                    </select>

                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        <option value="urutan">Urutan: Posisi Hirarki</option>
                        <option value="nama_lengkap">Urutan: Nama Pengurus</option>
                        <option value="jabatan">Urutan: Jabatan</option>
                        <option value="created_at">Urutan: Waktu Input</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        <option value="asc">Awal ke Akhir / A-Z (ASC)</option>
                        <option value="desc">Akhir ke Awal / Z-A (DESC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer">
                        <option value="10">10 / hal</option>
                        <option value="20">20 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>

                    <!-- View Switcher with localStorage persistence -->
                    <div 
                        x-data="{
                            mode: localStorage.getItem('kormi_pengurus_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_pengurus_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_pengurus_view') && localStorage.getItem('kormi_pengurus_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_pengurus_view'));
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
            <x-table.bulk-bar :count="count($selectedPengurus)" label="Pengurus dipilih" reset-action="resetSelection">
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
                    wire:confirm="Yakin ingin menghapus {{ count($selectedPengurus) }} pengurus terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. CONTENT (DATATABLE & GRID CARDS) -->
            @if($tampilanMode === 'tabel')
                <x-table.card>
                    <x-table.table loading-target="cari, filterPeriode, filterBidang, statusFilter, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
                        <x-table.thead>
                            <tr>
                                <x-table.th align="center" class="w-12 !px-4">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="pilihSemua" 
                                        class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer"
                                    >
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="nama_lengkap" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Profil & Nama Pengurus
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="jabatan" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-64"
                                >
                                    Jabatan & Bidang Kerja
                                </x-table.th>
                                <x-table.th align="center" class="w-40">Periode</x-table.th>
                                <x-table.th 
                                    align="center" 
                                    sortable 
                                    sort-field="urutan" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-24"
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
                                <x-table.th align="right" class="w-32">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>

                        <x-table.tbody>
                            @forelse($pengurusList as $item)
                                <x-table.tr wire:key="row-pengurus-{{ $item->id }}" :selected="in_array($item->id, $selectedPengurus)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-3.5 w-10">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedPengurus" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Profil & Foto (With Inline Edit Nama) -->
                                    <x-table.td>
                                        <div class="flex items-center gap-3.5">
                                            @if($item->foto_url)
                                                <div 
                                                    wire:click="bukaPratinjau('{{ $item->id }}')"
                                                    class="w-12 h-12 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 shadow-2xs cursor-pointer hover:opacity-90 transition-opacity"
                                                >
                                                    <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($item->foto_url) }}" class="w-full h-full object-cover" alt="{{ $item->nama_lengkap }}">
                                                </div>
                                            @else
                                                <div 
                                                    wire:click="bukaPratinjau('{{ $item->id }}')"
                                                    class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-200 text-blue-700 flex items-center justify-center shrink-0 font-black text-sm shadow-2xs cursor-pointer hover:bg-blue-100 transition-colors"
                                                >
                                                    {{ strtoupper(substr($item->nama_lengkap, 0, 2)) }}
                                                </div>
                                            @endif

                                            <div class="min-w-0 max-w-md flex-1">
                                                <!-- Inline Editable Nama Lengkap -->
                                                <div 
                                                    x-data="{ 
                                                        editing: false, 
                                                        val: '{{ addslashes($item->nama_lengkap) }}',
                                                        save() {
                                                            if (this.val.trim() !== '' && this.val !== '{{ addslashes($item->nama_lengkap) }}') {
                                                                $wire.updateFieldInline('{{ $item->id }}', 'nama_lengkap', this.val);
                                                            }
                                                            this.editing = false;
                                                        }
                                                    }"
                                                >
                                                    <div x-show="!editing" @dblclick="editing = true; $nextTick(() => $refs.namaInput.focus())" class="cursor-pointer group/inline flex items-center gap-1.5">
                                                        <h3 class="font-black text-slate-900 text-sm group-hover/inline:text-blue-600 transition-colors truncate">
                                                            {{ $item->nama_lengkap }}
                                                        </h3>
                                                        <i data-lucide="edit-2" class="w-3 h-3 text-slate-300 opacity-0 group-hover/inline:opacity-100 transition-opacity shrink-0"></i>
                                                    </div>
                                                    <input 
                                                        x-ref="namaInput"
                                                        x-show="editing" 
                                                        x-model="val" 
                                                        @keydown.enter="save()" 
                                                        @keydown.escape="editing = false; val = '{{ addslashes($item->nama_lengkap) }}'" 
                                                        @blur="save()"
                                                        type="text" 
                                                        class="w-full px-2 py-0.5 bg-blue-50 border border-blue-300 rounded text-xs font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    >
                                                </div>

                                                <p class="text-[11px] text-slate-400 mt-0.5">
                                                    ID: <span class="font-mono text-[10px]">{{ substr($item->id, 0, 8) }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Jabatan & Bidang (With Inline Edit Jabatan & Bidang) -->
                                    <x-table.td>
                                        <div class="space-y-1">
                                            <!-- Inline Edit Jabatan -->
                                            <div 
                                                x-data="{ 
                                                    editing: false, 
                                                    val: '{{ addslashes($item->jabatan) }}',
                                                    save() {
                                                        if (this.val.trim() !== '' && this.val !== '{{ addslashes($item->jabatan) }}') {
                                                            $wire.updateFieldInline('{{ $item->id }}', 'jabatan', this.val);
                                                        }
                                                        this.editing = false;
                                                    }
                                                }"
                                            >
                                                <div x-show="!editing" @dblclick="editing = true; $nextTick(() => $refs.jabInput.focus())" class="cursor-pointer group/inline flex items-center gap-1">
                                                    <span class="font-bold text-slate-900 text-xs block group-hover/inline:text-blue-600">
                                                        {{ $item->jabatan }}
                                                    </span>
                                                    <i data-lucide="edit-2" class="w-2.5 h-2.5 text-slate-300 opacity-0 group-hover/inline:opacity-100 transition-opacity"></i>
                                                </div>
                                                <input 
                                                    x-ref="jabInput"
                                                    x-show="editing" 
                                                    x-model="val" 
                                                    @keydown.enter="save()" 
                                                    @keydown.escape="editing = false; val = '{{ addslashes($item->jabatan) }}'" 
                                                    @blur="save()"
                                                    type="text" 
                                                    class="w-full px-1.5 py-0.5 bg-blue-50 border border-blue-300 rounded text-xs font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                >
                                            </div>

                                            <!-- Inline Edit Kategori Bidang -->
                                            <div 
                                                x-data="{ 
                                                    editing: false, 
                                                    val: '{{ addslashes($item->kategori_bidang ?? '') }}',
                                                    save() {
                                                        if (this.val !== '{{ addslashes($item->kategori_bidang ?? '') }}') {
                                                            $wire.updateFieldInline('{{ $item->id }}', 'kategori_bidang', this.val);
                                                        }
                                                        this.editing = false;
                                                    }
                                                }"
                                            >
                                                <div x-show="!editing" @dblclick="editing = true; $nextTick(() => $refs.bidInput.focus())" class="cursor-pointer group/inline inline-flex items-center gap-1">
                                                    @if($item->kategori_bidang)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                                            <i data-lucide="tag" class="w-2.5 h-2.5 text-slate-400"></i>
                                                            <span>{{ $item->kategori_bidang }}</span>
                                                        </span>
                                                    @else
                                                        <span class="text-[10px] text-slate-400 italic">+ Tambah Bidang</span>
                                                    @endif
                                                    <i data-lucide="edit-2" class="w-2.5 h-2.5 text-slate-300 opacity-0 group-hover/inline:opacity-100 transition-opacity"></i>
                                                </div>
                                                <input 
                                                    x-ref="bidInput"
                                                    x-show="editing" 
                                                    x-model="val" 
                                                    @keydown.enter="save()" 
                                                    @keydown.escape="editing = false; val = '{{ addslashes($item->kategori_bidang ?? '') }}'" 
                                                    @blur="save()"
                                                    type="text" 
                                                    placeholder="Nama Bidang..."
                                                    class="w-full px-1.5 py-0.5 bg-blue-50 border border-blue-300 rounded text-[10px] text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                >
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Periode -->
                                    <x-table.td align="center">
                                        <span class="px-2.5 py-1 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-700 font-bold text-xs inline-block">
                                            {{ $item->periode?->nama_periode ?? '-' }}
                                        </span>
                                    </x-table.td>

                                    <!-- Urutan (Inline Editable) -->
                                    <x-table.td align="center">
                                        <div 
                                            x-data="{ 
                                                editing: false, 
                                                val: '{{ $item->urutan }}',
                                                save() {
                                                    if (this.val !== '' && this.val != '{{ $item->urutan }}') {
                                                        $wire.updateFieldInline('{{ $item->id }}', 'urutan', this.val);
                                                    }
                                                    this.editing = false;
                                                }
                                            }"
                                        >
                                            <span 
                                                x-show="!editing" 
                                                @dblclick="editing = true; $nextTick(() => $refs.urutInput.focus())"
                                                class="font-bold text-slate-600 text-xs bg-slate-100 px-2.5 py-1 rounded-xl cursor-pointer hover:bg-blue-100 hover:text-blue-900 transition-colors"
                                                title="Klik 2x untuk ubah nomor urut"
                                            >
                                                #{{ $item->urutan }}
                                            </span>
                                            <input 
                                                x-ref="urutInput"
                                                x-show="editing" 
                                                x-model="val" 
                                                @keydown.enter="save()" 
                                                @keydown.escape="editing = false; val = '{{ $item->urutan }}'" 
                                                @blur="save()"
                                                type="number" 
                                                min="0"
                                                class="w-14 px-1 py-0.5 bg-blue-50 border border-blue-300 rounded text-center text-xs font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                            >
                                        </div>
                                    </x-table.td>

                                    <!-- Status Tampil -->
                                    <x-table.td align="center">
                                        <button 
                                            type="button" 
                                            wire:click="toggleStatus('{{ $item->id }}')" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer border {{ $item->status_tampil ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200' }}"
                                            title="Klik untuk mengubah status visibilitas publik"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full {{ $item->status_tampil ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            <span>{{ $item->status_tampil ? 'Tampil' : 'Draft' }}</span>
                                        </button>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="right">
                                        <div class="flex items-center justify-end gap-1">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="secondary" 
                                                icon="eye" 
                                                wire:click="bukaPratinjau('{{ $item->id }}')" 
                                                title="Lihat Profil Pengurus" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="primary" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdit('{{ $item->id }}')"
                                                wire:click="bukaFormEdit('{{ $item->id }}')" 
                                                title="Edit Data Lengkap" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="secondary" 
                                                icon="copy" 
                                                wire:click="duplikatPengurus('{{ $item->id }}')" 
                                                title="Duplikat Pengurus" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                wire:click="konfirmasiHapus('{{ $item->id }}')" 
                                                title="Hapus Pengurus" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="7" 
                                    icon="users" 
                                    title="Belum ada data pengurus" 
                                    description="Silakan tambahkan personil kepengurusan KORMI sesuai periode masa bakti."
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    @if($pengurusList->hasPages())
                        <x-slot:footer>
                            <div class="px-4 py-3 flex items-center justify-between">
                                {{ $pengurusList->links() }}
                            </div>
                        </x-slot:footer>
                    @endif
                </x-table.card>
            @else
                <!-- Grid View Mode -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @forelse($pengurusList as $item)
                        <div wire:key="grid-pengurus-{{ $item->id }}" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between group {{ in_array($item->id, $selectedPengurus) ? 'ring-2 ring-blue-500' : '' }}">
                            <div>
                                <div class="flex items-start justify-between gap-3 mb-4">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="selectedPengurus" 
                                        value="{{ $item->id }}" 
                                        class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 cursor-pointer shadow-xs"
                                    >

                                    <button 
                                        type="button" 
                                        wire:click="toggleStatus('{{ $item->id }}')" 
                                        class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $item->status_tampil ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' }}"
                                    >
                                        {{ $item->status_tampil ? 'Tampil' : 'Draft' }}
                                    </button>
                                </div>

                                <div class="text-center mb-4 cursor-pointer" wire:click="bukaPratinjau('{{ $item->id }}')">
                                    @if($item->foto_url)
                                        <div class="w-20 h-20 rounded-3xl overflow-hidden bg-slate-100 border-2 border-white shadow-md mx-auto mb-3">
                                            <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($item->foto_url) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $item->nama_lengkap }}">
                                        </div>
                                    @else
                                        <div class="w-20 h-20 rounded-3xl bg-blue-50 border-2 border-white text-blue-700 flex items-center justify-center font-black text-xl shadow-md mx-auto mb-3">
                                            {{ strtoupper(substr($item->nama_lengkap, 0, 2)) }}
                                        </div>
                                    @endif

                                    <h3 class="text-sm font-black text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                                        {{ $item->nama_lengkap }}
                                    </h3>
                                    <p class="text-xs font-bold text-blue-700 mt-0.5">
                                        {{ $item->jabatan }}
                                    </p>
                                    @if($item->kategori_bidang)
                                        <span class="inline-block px-2 py-0.5 mt-2 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                            {{ $item->kategori_bidang }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="pt-4 mt-2 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400">Urutan: #{{ $item->urutan }}</span>

                                <div class="flex items-center gap-1.5">
                                    <x-table.action-btn 
                                        size="sm"
                                        variant="secondary" 
                                        icon="eye" 
                                        wire:click="bukaPratinjau('{{ $item->id }}')" 
                                        title="Pratinjau Pengurus" 
                                    />
                                    <x-table.action-btn 
                                        size="sm"
                                        variant="primary" 
                                        icon="edit-3" 
                                        wire:click="bukaFormEdit('{{ $item->id }}')" 
                                        title="Edit Pengurus" 
                                    />
                                    <x-table.action-btn 
                                        size="sm"
                                        variant="danger" 
                                        icon="trash-2" 
                                        wire:click="konfirmasiHapus('{{ $item->id }}')" 
                                        title="Hapus Pengurus" 
                                    />
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                            <i data-lucide="users" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                            <p class="text-sm font-bold text-slate-600">Belum ada data pengurus yang sesuai filter.</p>
                            <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-blue-600 text-white font-bold text-xs cursor-pointer">
                                + Tambah Pengurus Baru
                            </button>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $pengurusList->links() }}
                </div>
            @endif

        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM PENGURUS (UI KIT)  -->
        <!-- ========================================== -->
        <div wire:key="pengurus-view-form" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$editId ? 'Edit Data Pengurus Organisasi' : 'Tambah Personil Pengurus Baru'"
                subtitle="Lengkapi identitas, jabatan struktural, kategori bidang kerja, dan pas foto resmi pengurus KORMI."
                :badge="$editId ? 'Mode Edit Pengurus' : 'Pengurus Baru'"
                icon="users"
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
                        {{ $editId ? 'Perbarui Pengurus' : 'Simpan Pengurus' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT (2 Columns: 8 cols Metadata + 4 cols Foto & Info) -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Metadata Pengurus -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Biodata & Jabatan Organisasi" 
                            subtitle="Parameter kepengurusan, masa bakti periode, jabatan dan seksi bidang kerja."
                            icon="user-check"
                        >
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Periode Kepengurusan -->
                                <x-form.field label="Periode Masa Bakti" name="periode_id" :required="true">
                                    <x-form.select name="periode_id" wire:model="periode_id">
                                        @foreach($periodeList as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama_periode }} ({{ $p->tahun_mulai }}-{{ $p->tahun_selesai }}) {{ $p->status_aktif ? '★ [Aktif]' : '' }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <!-- Urutan -->
                                <x-form.field label="Urutan Hierarki / Posisi" name="urutan">
                                    <x-form.input 
                                        type="number" 
                                        name="urutan" 
                                        wire:model="urutan" 
                                        min="0"
                                        icon="hash"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Nama Lengkap -->
                            <x-form.field label="Nama Lengkap & Gelar Pengurus" name="nama_lengkap" :required="true">
                                <x-form.input 
                                    name="nama_lengkap" 
                                    wire:model="nama_lengkap" 
                                    placeholder="Contoh: Hj. Emma Dety Permanawati, S.Pd.I., M.M." 
                                    icon="user"
                                    size="lg"
                                />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Jabatan Struktural -->
                                <x-form.field label="Jabatan Struktural" name="jabatan" :required="true">
                                    <x-form.input 
                                        name="jabatan" 
                                        wire:model="jabatan" 
                                        placeholder="Contoh: Ketua Umum, Sekretaris Umum, Ketua Harian..." 
                                        icon="briefcase"
                                    />
                                </x-form.field>

                                <!-- Kategori Bidang -->
                                <x-form.field label="Kategori Bidang / Komisi" name="kategori_bidang">
                                    <x-form.input 
                                        name="kategori_bidang" 
                                        wire:model="kategori_bidang" 
                                        placeholder="Pimpinan Harian, Bidang Olahraga Tradisional..." 
                                        icon="network"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Quick Suggestions for Bidang -->
                            <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-2xl flex items-center gap-2 flex-wrap">
                                <span class="text-[11px] font-bold text-slate-500">Pilihan Cepat Bidang:</span>
                                @foreach(['Pimpinan Harian', 'Sekretariat', 'Kebendaharaan', 'Bidang Olahraga Tradisional & Kreasi Budaya', 'Bidang Olahraga Kesehatan & Kebugaran', 'Bidang Olahraga Petualangan & Tantangan', 'Humas, Publikasi & Kerjasama'] as $sampleBidang)
                                    <button 
                                        type="button" 
                                        wire:click="$set('kategori_bidang', '{{ $sampleBidang }}')"
                                        class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                                    >
                                        <span>{{ $sampleBidang }}</span>
                                    </button>
                                @endforeach
                            </div>

                            <!-- Status Tampil Toggle -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <label for="statusTampilPengurus" class="text-xs font-black text-slate-900 cursor-pointer">Tampilkan di Halaman Profil Publik</label>
                                    <p class="text-xs text-slate-500">Pengurus dengan status aktif akan ditampilkan pada bagan struktur organisasi portal publik.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="statusTampilPengurus" wire:model="status_tampil" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Pas Foto & Info -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Foto Card -->
                        <x-form.card 
                            title="Pas Foto Resmi" 
                            subtitle="Format foto portrait formal background rapi."
                            icon="image"
                        >
                            <x-form.image-upload
                                :upload="$uploadFoto"
                                :saved-path="$foto_url"
                                name="uploadFoto"
                                input-id="uploadPasFotoPengurus"
                                empty-title="Unggah Foto Pengurus"
                                empty-subtitle="Format JPG, PNG, WEBP (Maksimal 10MB)"
                                :max-size-m-b="10"
                                aspect-ratio="h-60 sm:h-72"
                            />
                        </x-form.card>

                        <!-- Guide Information Card -->
                        <div class="bg-blue-50/70 border border-blue-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-blue-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="info" class="w-4 h-4 text-blue-600"></i>
                                <span>Urutan Struktur</span>
                            </h4>
                            <p class="text-xs text-blue-950 leading-relaxed">
                                Gunakan <strong>Urutan Hierarki</strong> bernilai kecil (1, 2, 3...) untuk posisi pimpinan utama (Pelindung, Penasihat, Ketua Umum), disusul jajaran wakil ketua, sekretaris, bendahara, dan ketua komisi/bidang.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 3. ACTION BAR -->
                <x-form.action-bar 
                    cancel-text="Batal & Kembali" 
                    cancel-action="kembaliKeTabel" 
                    :submit-text="$editId ? 'Perbarui Pengurus' : 'Simpan Pengurus ke Database'" 
                    loading-target="simpan" 
                />
            </form>
        </div>
    @endif

    <!-- ========================================================= -->
    <!-- MODAL: PRATINJAU KARTU PROFIL PENGURUS LENGKAP            -->
    <!-- ========================================================= -->
    @if($tampilkanModalPratinjau && $pratinjauPengurus)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i data-lucide="user-check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">Profil Pengurus KORMI</h3>
                            <p class="text-[10px] text-slate-400">Periode {{ $pratinjauPengurus->periode?->nama_periode ?? '-' }} ({{ $pratinjauPengurus->periode?->tahun_mulai }}-{{ $pratinjauPengurus->periode?->tahun_selesai }})</p>
                        </div>
                    </div>
                    <button type="button" wire:click="tutupPratinjau" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto space-y-5 text-center">
                    <div class="relative w-28 h-28 mx-auto rounded-3xl overflow-hidden bg-slate-100 border-2 border-white shadow-lg">
                        @if($pratinjauPengurus->foto_url)
                            <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($pratinjauPengurus->foto_url) }}" class="w-full h-full object-cover" alt="{{ $pratinjauPengurus->nama_lengkap }}">
                        @else
                            <div class="w-full h-full bg-blue-50 text-blue-700 flex items-center justify-center font-black text-3xl">
                                {{ strtoupper(substr($pratinjauPengurus->nama_lengkap, 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center justify-center gap-2 flex-wrap mb-1">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200">
                                Urutan Hierarki: #{{ $pratinjauPengurus->urutan }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $pratinjauPengurus->status_tampil ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                {{ $pratinjauPengurus->status_tampil ? 'Publik' : 'Draft' }}
                            </span>
                        </div>
                        <h2 class="text-lg font-black text-slate-900 leading-snug">{{ $pratinjauPengurus->nama_lengkap }}</h2>
                        <p class="text-sm font-bold text-blue-600">{{ $pratinjauPengurus->jabatan }}</p>
                        @if($pratinjauPengurus->kategori_bidang)
                            <p class="text-xs text-slate-500 font-medium">{{ $pratinjauPengurus->kategori_bidang }}</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs text-left">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Jabatan</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauPengurus->jabatan }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Masa Bakti</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauPengurus->periode?->nama_periode ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <button 
                        type="button" 
                        wire:click="bukaFormEdit('{{ $pratinjauPengurus->id }}')" 
                        class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer flex items-center gap-1.5"
                    >
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                        <span>Edit Data Pengurus</span>
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
    <!-- MODAL: KONFIRMASI HAPUS PENGURUS                          -->
    <!-- ========================================================= -->
    @if($tampilkanModalHapus)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden border border-slate-100 p-6 sm:p-7 space-y-6 text-center">
                <div class="w-14 h-14 rounded-3xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto shadow-sm">
                    <i data-lucide="alert-triangle" class="w-7 h-7"></i>
                </div>

                <div class="space-y-2">
                    <h3 class="text-lg font-black text-slate-900">Hapus Data Pengurus?</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Apakah Anda yakin ingin menghapus data pengurus <br>
                        <span class="font-bold text-slate-900 italic">"{{ $hapusNama }}"</span>?
                    </p>
                    <p class="text-[11px] text-rose-600 font-medium">Data dan berkas pas foto terkait akan dihapus secara permanen dari server.</p>
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
