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
        <!-- VIEW MODE: TABEL VISI & MISI               -->
        <!-- ========================================== -->
        <div wire:key="visimisi-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola Visi & Misi Organisasi"
                subtitle="Pedoman arah strategis, cita-cita luhur, misi operasional, nilai utama, motto, dan tujuan organisasi KORMI Kabupaten Bandung."
                badge="Kelembagaan & Struktur • Visi, Misi & Nilai"
                icon="target"
                color="indigo"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaFormTambah"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4 transition-transform group-hover:rotate-90 duration-200"></i>
                        <span>Tambah Butir Baru</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Butir"
                    :value="number_format($totalVisiMisi)"
                    unit="Butir"
                    subtitle="Semua pedoman arah"
                    icon="target"
                    color="indigo"
                    :active="$filterJenis === 'semua' && $statusFilter === 'Semua'"
                    loading-target="resetSemuaFilter, setFilterJenis, setFilterStatus"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Visi & Misi"
                    :value="number_format(($counts['visi'] ?? 0) + ($counts['misi'] ?? 0))"
                    unit="Pilar"
                    subtitle="{{ ($counts['visi'] ?? 0) }} Visi • {{ ($counts['misi'] ?? 0) }} Misi"
                    icon="compass"
                    color="blue"
                    :active="$filterJenis === 'visi' || $filterJenis === 'misi'"
                    loading-target="setFilterJenis"
                    wire:click="setFilterJenis('misi')"
                />

                <x-table.stats-card
                    title="Nilai, Motto & Tujuan"
                    :value="number_format(($counts['nilai_utama'] ?? 0) + ($counts['motto'] ?? 0) + ($counts['tujuan'] ?? 0))"
                    unit="Butir"
                    subtitle="Fondasi budaya kerja"
                    icon="award"
                    color="purple"
                    :active="in_array($filterJenis, ['nilai_utama', 'motto', 'tujuan'])"
                    loading-target="setFilterJenis"
                    wire:click="setFilterJenis('nilai_utama')"
                />

                <x-table.stats-card
                    title="Tampil di Publik"
                    :value="number_format($totalTampil)"
                    unit="Aktif"
                    subtitle="Dapat dibaca publik"
                    icon="eye"
                    color="emerald"
                    :pulse="true"
                    :active="$statusFilter === 'Tampil'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('Tampil')"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                search-placeholder="Cari narasi visi, misi, nilai, atau ikon..." 
                search-model="cari"
            >
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                        <button 
                            type="button"
                            wire:click="setFilterJenis('semua')" 
                            class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $filterJenis === 'semua' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <span>Semua Kategori</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $filterJenis === 'semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalVisiMisi }}</span>
                        </button>

                        @foreach($jenisOptions as $opt)
                            <button 
                                type="button"
                                wire:click="setFilterJenis('{{ $opt }}')" 
                                class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $filterJenis === $opt ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                            >
                                <span>{{ $jenisLabels[$opt] }}</span>
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $filterJenis === $opt ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $counts[$opt] ?? 0 }}</span>
                            </button>
                        @endforeach
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <!-- Status Filter Dropdown -->
                    <select wire:model.live="statusFilter" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="Semua">Semua Status</option>
                        <option value="Tampil">Tampil di Publik</option>
                        <option value="Disembunyikan">Disembunyikan</option>
                    </select>

                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="urutan">Urutan: Nomor Urut</option>
                        <option value="jenis">Urutan: Kategori Jenis</option>
                        <option value="konten">Urutan: Teks Konten</option>
                        <option value="created_at">Urutan: Waktu Input</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="asc">Awal ke Akhir / A-Z (ASC)</option>
                        <option value="desc">Akhir ke Awal / Z-A (DESC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="10">10 / hal</option>
                        <option value="20">20 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>

                    <!-- View Switcher -->
                    <div 
                        x-data="{
                            mode: localStorage.getItem('kormi_visimisi_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_visimisi_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_visimisi_view') && localStorage.getItem('kormi_visimisi_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_visimisi_view'));
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
            <x-table.bulk-bar :count="count($selectedVisiMisi)" label="Butir dipilih" reset-action="resetSelection">
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
                    wire:confirm="Yakin ingin menghapus {{ count($selectedVisiMisi) }} butir visi/misi terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. CONTENT (DATATABLE & GRID CARDS) -->
            @if($tampilanMode === 'tabel')
                <x-table.card>
                    <x-table.table loading-target="cari, filterJenis, statusFilter, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
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
                                    sort-field="jenis" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                    class="w-36"
                                >
                                    Kategori
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="konten" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Isi Narasi & Butir Pedoman
                                </x-table.th>
                                <x-table.th align="center" class="w-24">Ikon</x-table.th>
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
                            @forelse($visiMisiList as $item)
                                <x-table.tr :selected="in_array($item->id, $selectedVisiMisi)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedVisiMisi" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Kategori Badge -->
                                    <x-table.td>
                                        @php
                                            $badgeConfig = [
                                                'visi' => ['bg' => 'bg-blue-50 text-blue-800 border-blue-200/80', 'icon' => 'compass'],
                                                'misi' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200/80', 'icon' => 'target'],
                                                'nilai_utama' => ['bg' => 'bg-purple-50 text-purple-800 border-purple-200/80', 'icon' => 'star'],
                                                'motto' => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200/80', 'icon' => 'flame'],
                                                'tujuan' => ['bg' => 'bg-rose-50 text-rose-800 border-rose-200/80', 'icon' => 'award'],
                                            ];
                                            $cfg = $badgeConfig[$item->jenis] ?? ['bg' => 'bg-slate-50 text-slate-800 border-slate-200/80', 'icon' => 'tag'];
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-2xl border font-black text-xs uppercase tracking-wider {{ $cfg['bg'] }}">
                                            <i data-lucide="{{ $cfg['icon'] }}" class="w-3.5 h-3.5"></i>
                                            <span>{{ $jenisLabels[$item->jenis] ?? $item->jenis }}</span>
                                        </span>
                                    </x-table.td>

                                    <!-- Konten -->
                                    <x-table.td>
                                        <div class="space-y-1">
                                            <p class="font-medium text-slate-900 text-sm leading-relaxed">
                                                {{ $item->konten }}
                                            </p>
                                        </div>
                                    </x-table.td>

                                    <!-- Ikon Preview -->
                                    <x-table.td align="center">
                                        @if($item->ikon)
                                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-slate-100 border border-slate-200 text-slate-700" title="{{ $item->ikon }}">
                                                <i data-lucide="{{ $item->ikon }}" class="w-4 h-4"></i>
                                            </div>
                                        @else
                                            <span class="text-slate-300 font-bold text-xs">-</span>
                                        @endif
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
                                            title="Klik untuk mengubah visibilitas di portal publik"
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
                                                variant="primary" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdit('{{ $item->id }}')"
                                                wire:click="bukaFormEdit('{{ $item->id }}')" 
                                                title="Edit Data" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="hapus('{{ $item->id }}')"
                                                wire:click="hapus('{{ $item->id }}')" 
                                                wire:confirm="Yakin ingin menghapus butir visi/misi ini?" 
                                                title="Hapus Data" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="7" 
                                    icon="target" 
                                    title="Belum ada butir visi & misi" 
                                    description="Silakan tambahkan butir visi, misi, nilai utama, motto, atau tujuan organisasi."
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    @if($visiMisiList->hasPages())
                        <x-slot:footer>
                            <div class="px-4 py-3 flex items-center justify-between">
                                {{ $visiMisiList->links() }}
                            </div>
                        </x-slot:footer>
                    @endif
                </x-table.card>
            @else
                <!-- Grid View Mode -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($visiMisiList as $item)
                        @php
                            $badgeConfig = [
                                'visi' => ['bg' => 'bg-blue-50 text-blue-800 border-blue-200', 'icon' => 'compass', 'accent' => 'border-blue-500'],
                                'misi' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'icon' => 'target', 'accent' => 'border-emerald-500'],
                                'nilai_utama' => ['bg' => 'bg-purple-50 text-purple-800 border-purple-200', 'icon' => 'star', 'accent' => 'border-purple-500'],
                                'motto' => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200', 'icon' => 'flame', 'accent' => 'border-amber-500'],
                                'tujuan' => ['bg' => 'bg-rose-50 text-rose-800 border-rose-200', 'icon' => 'award', 'accent' => 'border-rose-500'],
                            ];
                            $cfg = $badgeConfig[$item->jenis] ?? ['bg' => 'bg-slate-50 text-slate-800 border-slate-200', 'icon' => 'tag', 'accent' => 'border-slate-400'];
                        @endphp
                        <div wire:key="grid-visimisi-{{ $item->id }}" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between group {{ in_array($item->id, $selectedVisiMisi) ? 'ring-2 ring-indigo-500' : '' }}">
                            <div>
                                <div class="flex items-start justify-between gap-3 mb-3.5">
                                    <div class="flex items-center gap-2">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedVisiMisi" 
                                            value="{{ $item->id }}" 
                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer shadow-xs"
                                        >
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-2xl border font-black text-xs uppercase tracking-wider {{ $cfg['bg'] }}">
                                            <i data-lucide="{{ $cfg['icon'] }}" class="w-3.5 h-3.5"></i>
                                            <span>{{ $jenisLabels[$item->jenis] ?? $item->jenis }}</span>
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

                                <div class="flex items-start gap-3 my-2">
                                    @if($item->ikon)
                                        <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-700 shrink-0 mt-0.5 shadow-2xs">
                                            <i data-lucide="{{ $item->ikon }}" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                    <p class="text-sm font-medium text-slate-900 leading-relaxed">
                                        {{ $item->konten }}
                                    </p>
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400">Urutan: #{{ $item->urutan }}</span>

                                <div class="flex items-center gap-1.5">
                                    <button wire:click="bukaFormEdit('{{ $item->id }}')" title="Edit Data" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all cursor-pointer">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <button wire:click="hapus('{{ $item->id }}')" wire:confirm="Yakin ingin menghapus butir ini?" title="Hapus Data" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition-all cursor-pointer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                            <i data-lucide="target" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                            <p class="text-sm font-bold text-slate-600">Belum ada butir visi & misi yang sesuai filter.</p>
                            <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-indigo-600 text-white font-bold text-xs cursor-pointer">
                                + Tambah Butir Baru
                            </button>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $visiMisiList->links() }}
                </div>
            @endif

        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM VISI & MISI        -->
        <!-- ========================================== -->
        <div wire:key="visimisi-view-form" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$editId ? 'Edit Butir Visi & Misi' : 'Tambah Butir Pedoman Organisasi'"
                subtitle="Formulir penyusunan visi, misi, motto, nilai-nilai utama, dan tujuan strategis KORMI."
                :badge="$editId ? 'Mode Edit Data' : 'Data Baru'"
                icon="target"
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
                        {{ $editId ? 'Perbarui Data' : 'Simpan Data' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT (2 Columns: 8 cols Input + 4 cols Preview & Info) -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Form Inputs -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Parameter & Narasi Pedoman" 
                            subtitle="Tentukan klasifikasi kategori pedoman, nomor urut, ikon simbol, dan teks narasi lengkap."
                            icon="file-text"
                        >
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <!-- Jenis Kategori -->
                                <x-form.field label="Kategori Jenis" name="jenis" :required="true">
                                    <x-form.select name="jenis" wire:model.live="jenis">
                                        @foreach($jenisOptions as $j)
                                            <option value="{{ $j }}">{{ $jenisLabels[$j] }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <!-- Ikon Lucide -->
                                <x-form.field label="Nama Ikon (Lucide)" name="ikon" hint="Contoh: target, award, star, flame, heart">
                                    <x-form.input 
                                        name="ikon" 
                                        wire:model.live.debounce.300ms="ikon" 
                                        placeholder="target, star, heart..." 
                                        icon="smile"
                                    />
                                </x-form.field>

                                <!-- Urutan -->
                                <x-form.field label="Nomor Urutan" name="urutan">
                                    <x-form.input 
                                        type="number" 
                                        name="urutan" 
                                        wire:model="urutan" 
                                        min="0"
                                        icon="hash"
                                    />
                                </x-form.field>
                            </div>

                            <!-- Saran Ikon Cepat -->
                            <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-2xl flex items-center gap-2 flex-wrap">
                                <span class="text-[11px] font-bold text-slate-500">Ikon Populer:</span>
                                @foreach(['target', 'compass', 'award', 'star', 'flame', 'heart', 'shield', 'check-circle', 'zap', 'flag'] as $iconSample)
                                    <button 
                                        type="button" 
                                        wire:click="$set('ikon', '{{ $iconSample }}')"
                                        class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                                    >
                                        <i data-lucide="{{ $iconSample }}" class="w-3 h-3"></i>
                                        <span>{{ $iconSample }}</span>
                                    </button>
                                @endforeach
                            </div>

                            <!-- Konten Narasi -->
                            <x-form.field label="Isi Narasi / Butir Teks" name="konten" :required="true">
                                <x-form.textarea 
                                    name="konten" 
                                    wire:model="konten" 
                                    rows="5" 
                                    placeholder="Tuliskan butir narasi visi, misi, nilai utama, motto, atau tujuan organisasi secara jelas dan inspiratif..."
                                />
                            </x-form.field>

                            <!-- Status Tampil Toggle -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <label for="statusTampilVisiMisi" class="text-xs font-black text-slate-900 cursor-pointer">Tampilkan di Halaman Publik</label>
                                    <p class="text-xs text-slate-500">Butir dengan status aktif akan ditampilkan di halaman publik portal KORMI.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="statusTampilVisiMisi" wire:model="status_tampil" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Live Preview & Panduan -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Live Card Preview -->
                        <x-form.card 
                            title="Pratinjau Kartu" 
                            subtitle="Simulasi tampilan visual pada kartu profil publik."
                            icon="eye"
                        >
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-indigo-100 text-indigo-800 border border-indigo-200">
                                        {{ $jenisLabels[$jenis] ?? $jenis }}
                                    </span>
                                    <span class="text-xs font-bold text-slate-400">#{{ $urutan }}</span>
                                </div>

                                <div class="flex items-start gap-3 pt-2">
                                    @if($ikon)
                                        <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-indigo-600/20">
                                            <i data-lucide="{{ $ikon }}" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                    <p class="text-xs sm:text-sm font-semibold text-slate-800 leading-relaxed">
                                        {{ $konten ?: 'Pratinjau isi narasi butir pedoman akan muncul di sini secara real-time...' }}
                                    </p>
                                </div>
                            </div>
                        </x-form.card>

                        <!-- Guide Information Card -->
                        <div class="bg-indigo-50/70 border border-indigo-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-indigo-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="info" class="w-4 h-4 text-indigo-600"></i>
                                <span>Panduan Kategori</span>
                            </h4>
                            <ul class="text-xs text-indigo-950 space-y-2 leading-relaxed">
                                <li>• <strong>Visi:</strong> Cita-cita jangka panjang organisasi.</li>
                                <li>• <strong>Misi:</strong> Langkah strategis mewujudkan visi.</li>
                                <li>• <strong>Nilai Utama:</strong> Prinsip integritas dan etos kerja.</li>
                                <li>• <strong>Motto:</strong> Slogan penyemangat organisasi.</li>
                                <li>• <strong>Tujuan:</strong> Target capaian terukur KORMI.</li>
                            </ul>
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
                        {{ $editId ? 'Perbarui Data' : 'Simpan Data' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

</div>
