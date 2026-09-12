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
        <!-- VIEW MODE: TABEL DAFTAR EVENT              -->
        <!-- ========================================== -->
        <div wire:key="event-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola Event & Festival FORKAB"
                subtitle="Kelola kalender kejuaraan daerah, festival olahraga masyarakat, cabang perlombaan Inorga, dan jadwal tahapan pertandingan."
                badge="Agenda & Kompetisi • Event & Festival FORKAB"
                icon="calendar"
                color="emerald"
            >
                <x-slot:actions>
                    <button 
                        type="button" 
                        wire:click="bukaModalKelolaKategori"
                        class="inline-flex items-center justify-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-white hover:bg-slate-50 border border-slate-200/90 text-slate-700 font-bold text-xs shadow-2xs hover:shadow-xs transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="tag" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>Kategori Event</span>
                    </button>

                    <button 
                        type="button" 
                        wire:click="bukaFormTambahEvent"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4 transition-transform group-hover:rotate-90 duration-200"></i>
                        <span>Tambah Event Baru</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Agenda"
                    :value="number_format($totalEvent)"
                    unit="Event"
                    subtitle="Semua agenda kejuaraan"
                    icon="calendar"
                    color="emerald"
                    :active="$kategoriDipilih === 'Semua' && $statusPublikasiFilter === 'Semua'"
                    loading-target="resetSemuaFilter, setFilterKategori, setFilterStatus"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Event Tayang"
                    :value="number_format($totalPublish)"
                    unit="Tayang"
                    subtitle="Tampil di portal publik"
                    icon="globe"
                    color="lime"
                    :pulse="true"
                    :active="$statusPublikasiFilter === '1'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('1')"
                />

                <x-table.stats-card
                    title="Status Draft"
                    :value="number_format($totalDraft)"
                    unit="Draft"
                    subtitle="Belum dipublikasikan"
                    icon="file-edit"
                    color="amber"
                    :active="$statusPublikasiFilter === '0'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('0')"
                />

                <x-table.stats-card
                    title="Total Cabang"
                    :value="number_format($totalCabang)"
                    unit="Cabang"
                    subtitle="Nomor lomba terdaftar"
                    icon="award"
                    color="teal"
                    loading-target="cari, setFilterKategori"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar search-placeholder="Cari judul event, lokasi venue..." search-model="cari">
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                        <button 
                            type="button"
                            wire:click="setFilterKategori('Semua')" 
                            class="px-4 py-2 rounded-2xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap shrink-0 flex items-center gap-1.5 {{ $kategoriDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <span>Semua Kategori</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $kategoriDipilih === 'Semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $totalEvent }}</span>
                        </button>

                        @foreach($kategoriList as $kat)
                            <button 
                                type="button"
                                wire:click="setFilterKategori('{{ $kat->id }}')" 
                                class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $kategoriDipilih === $kat->id ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                            >
                                <i data-lucide="tag" class="w-3.5 h-3.5 {{ $kategoriDipilih === $kat->id ? 'text-white' : 'text-emerald-600' }}"></i>
                                <span>{{ $kat->nama_kategori }}</span>
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $kategoriDipilih === $kat->id ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kat->events_count }}</span>
                            </button>
                        @endforeach
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <!-- Status Filter -->
                    <select wire:model.live="statusPublikasiFilter" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="Semua">Semua Status</option>
                        <option value="1">Tayang (Publikasi)</option>
                        <option value="0">Draft (Tersimpan)</option>
                    </select>

                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="tanggal_mulai">Urutan: Tanggal Mulai</option>
                        <option value="judul_event">Urutan: Judul Event</option>
                        <option value="tahun_edisi">Urutan: Tahun Edisi</option>
                        <option value="lokasi_utama">Urutan: Lokasi / Venue</option>
                        <option value="created_at">Urutan: Waktu Input</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="desc">Terbaru (DESC)</option>
                        <option value="asc">Terlama (ASC)</option>
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
                            mode: localStorage.getItem('kormi_event_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_event_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_event_view') && localStorage.getItem('kormi_event_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_event_view'));
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
            <x-table.bulk-bar :count="count($selectedEvent)" label="Event dipilih" reset-action="resetSelection">
                <button 
                    type="button" 
                    wire:click="bulkPublish" 
                    class="px-3 py-1.5 rounded-xl bg-lime-600 hover:bg-lime-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="globe" class="w-3.5 h-3.5"></i>
                    <span>Publikasikan</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDraft" 
                    class="px-3 py-1.5 rounded-xl bg-slate-700 hover:bg-slate-800 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="eye-off" class="w-3.5 h-3.5"></i>
                    <span>Set Draft</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDelete" 
                    wire:confirm="Yakin ingin menghapus {{ count($selectedEvent) }} event terpilih beserta seluruh cabang dan jadwalnya?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. CONTENT (DATATABLE & GRID CARDS) -->
            @if($tampilanMode === 'tabel')
                <x-table.card>
                    <x-table.table loading-target="cari, kategoriDipilih, statusPublikasiFilter, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
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
                                    sort-field="judul_event" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Event / Kejuaraan
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="tanggal_mulai" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Waktu & Lokasi
                                </x-table.th>
                                <x-table.th align="center">
                                    Cabang & Jadwal
                                </x-table.th>
                                <x-table.th align="center">
                                    Status
                                </x-table.th>
                                <x-table.th align="right">
                                    Aksi
                                </x-table.th>
                            </tr>
                        </x-table.thead>

                        <x-table.tbody>
                            @forelse($eventList as $ev)
                                <tr wire:key="row-event-{{ $ev->id }}" class="hover:bg-slate-50/80 transition-colors {{ in_array($ev->id, $selectedEvent) ? 'bg-emerald-50/40' : '' }}">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-4">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedEvent" 
                                            value="{{ $ev->id }}" 
                                            class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- Event Title & Info -->
                                    <x-table.td>
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-14 h-12 rounded-xl bg-slate-100 border border-slate-200/80 overflow-hidden shrink-0 flex items-center justify-center relative">
                                                @if($ev->banner_url)
                                                    <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($ev->banner_url) }}" alt="{{ $ev->judul_event }}" class="w-full h-full object-cover">
                                                @else
                                                    <i data-lucide="trophy" class="w-5 h-5 text-slate-400"></i>
                                                @endif
                                                <span class="absolute bottom-0 inset-x-0 bg-slate-900/80 text-[8px] font-black text-white text-center py-0.5">
                                                    {{ $ev->tahun_edisi }}
                                                </span>
                                            </div>
                                            <div class="min-w-0 max-w-sm lg:max-w-md">
                                                <div class="flex items-center gap-2 mb-0.5">
                                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-bold text-[10px]">
                                                        {{ $ev->kategoriEvent?->nama_kategori ?? 'Umum' }}
                                                    </span>
                                                </div>
                                                <a href="javascript:void(0)" wire:click="bukaDetailEvent('{{ $ev->id }}')" class="font-extrabold text-slate-900 text-xs sm:text-sm hover:text-emerald-600 transition-colors line-clamp-1">
                                                    {{ $ev->judul_event }}
                                                </a>
                                                <p class="text-[11px] text-slate-400 truncate mt-0.5">
                                                    Slug: {{ $ev->slug }}
                                                </p>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Waktu & Lokasi -->
                                    <x-table.td>
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-1.5 text-slate-700 font-bold text-xs">
                                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                                <span>{{ $ev->tanggal_mulai ? $ev->tanggal_mulai->format('d M') : '-' }} - {{ $ev->tanggal_selesai ? $ev->tanggal_selesai->format('d M Y') : '-' }}</span>
                                            </div>
                                            <div class="flex items-center gap-1.5 text-slate-500 text-[11px]">
                                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                                <span class="truncate max-w-[200px]">{{ $ev->lokasi_utama }}</span>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Cabang & Jadwal Counts -->
                                    <x-table.td align="center">
                                        <div class="inline-flex items-center gap-2">
                                            <span class="px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-800 text-[11px] font-black border border-emerald-100/80" title="Jumlah Cabang Lomba">
                                                {{ $ev->cabang->count() }} Cabang
                                            </span>
                                            <span class="px-2.5 py-1 rounded-xl bg-teal-50 text-teal-800 text-[11px] font-black border border-teal-100/80" title="Jumlah Jadwal Rundown">
                                                {{ $ev->jadwal->count() }} Jadwal
                                            </span>
                                        </div>
                                    </x-table.td>

                                    <!-- Status Publikasi -->
                                    <x-table.td align="center">
                                        <button 
                                            type="button" 
                                            wire:click="toggleStatusPublikasi('{{ $ev->id }}')" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer {{ $ev->status_publikasi ? 'bg-lime-100 text-lime-800 hover:bg-lime-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                                            title="Klik untuk mengubah status"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full {{ $ev->status_publikasi ? 'bg-lime-500' : 'bg-slate-400' }}"></span>
                                            <span>{{ $ev->status_publikasi ? 'Tayang' : 'Draft' }}</span>
                                        </button>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button 
                                                type="button" 
                                                wire:click="bukaDetailEvent('{{ $ev->id }}')" 
                                                class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl text-xs font-bold flex items-center gap-1 transition-all cursor-pointer" 
                                                title="Kelola Cabang & Jadwal"
                                            >
                                                <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                                                <span>Kelola</span>
                                            </button>

                                            <button 
                                                type="button" 
                                                wire:click="bukaFormEditEvent('{{ $ev->id }}')" 
                                                class="p-2 rounded-xl text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all cursor-pointer" 
                                                title="Edit Event"
                                            >
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </button>

                                            <button 
                                                type="button" 
                                                wire:click="hapusEvent('{{ $ev->id }}')" 
                                                wire:confirm="Yakin ingin menghapus event '{{ $ev->judul_event }}'? Seluruh cabang dan jadwal terkait akan ikut terhapus." 
                                                class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all cursor-pointer" 
                                                title="Hapus Event"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </x-table.td>
                                </tr>
                            @empty
                                <x-table.empty 
                                    colspan="6" 
                                    title="Tidak Ada Agenda Event" 
                                    description="Belum ada data event atau filter pencarian tidak menemukan hasil."
                                    icon="calendar-x"
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    <x-slot:pagination>
                        {{ $eventList->links() }}
                    </x-slot:pagination>
                </x-table.card>
            @else
                <!-- GRID VIEW MODE -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @forelse($eventList as $ev)
                        <div wire:key="grid-event-{{ $ev->id }}" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-all group {{ in_array($ev->id, $selectedEvent) ? 'ring-2 ring-emerald-500' : '' }}">
                            <div>
                                <!-- Event Banner / Placeholder -->
                                <div class="relative h-44 bg-gradient-to-tr from-emerald-950 to-teal-900 overflow-hidden">
                                    @if($ev->banner_url)
                                        <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($ev->banner_url) }}" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300" alt="{{ $ev->judul_event }}">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-emerald-300/40 p-4 text-center">
                                            <i data-lucide="trophy" class="w-12 h-12 mb-1"></i>
                                            <span class="text-[10px] font-bold uppercase tracking-wider">Tanpa Banner</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>
                                    
                                    <!-- Badges -->
                                    <div class="absolute top-3 left-3 flex items-center gap-1.5">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedEvent" 
                                            value="{{ $ev->id }}" 
                                            class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer shadow-sm"
                                        >
                                        <span class="px-2.5 py-1 rounded-lg bg-emerald-500/90 text-white font-black text-[10px] backdrop-blur-md">
                                            {{ $ev->tahun_edisi }}
                                        </span>
                                        <span class="px-2.5 py-1 rounded-lg bg-black/60 text-white font-bold text-[10px] backdrop-blur-md">
                                            {{ $ev->kategoriEvent?->nama_kategori ?? 'Umum' }}
                                        </span>
                                    </div>

                                    <div class="absolute top-3 right-3">
                                        <button 
                                            type="button" 
                                            wire:click="toggleStatusPublikasi('{{ $ev->id }}')" 
                                            class="px-2.5 py-1 rounded-full text-[10px] font-black cursor-pointer {{ $ev->status_publikasi ? 'bg-lime-400 text-slate-950' : 'bg-slate-700 text-slate-300' }}"
                                        >
                                            {{ $ev->status_publikasi ? 'Tayang' : 'Draft' }}
                                        </button>
                                    </div>

                                    <!-- Date Overlay -->
                                    <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-xs font-semibold">
                                        <span class="flex items-center gap-1.5">
                                            <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-lime-400"></i>
                                            <span>{{ $ev->tanggal_mulai ? $ev->tanggal_mulai->format('d M') : '-' }} - {{ $ev->tanggal_selesai ? $ev->tanggal_selesai->format('d M Y') : '-' }}</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-5">
                                    <h3 class="font-black text-slate-900 text-base leading-snug line-clamp-2 mb-2 group-hover:text-emerald-700 transition-colors">
                                        {{ $ev->judul_event }}
                                    </h3>
                                    <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-3">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                        <span class="truncate">{{ $ev->lokasi_utama }}</span>
                                    </p>

                                    <!-- Quick Stats -->
                                    <div class="grid grid-cols-2 gap-2 pt-3 border-t border-slate-100 text-center">
                                        <div class="p-2 bg-slate-50 rounded-xl">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">Cabang</span>
                                            <p class="text-xs font-black text-slate-800">{{ $ev->cabang->count() }} Inorga</p>
                                        </div>
                                        <div class="p-2 bg-slate-50 rounded-xl">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">Jadwal</span>
                                            <p class="text-xs font-black text-slate-800">{{ $ev->jadwal->count() }} Tahapan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Actions -->
                            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2">
                                <button wire:click="bukaDetailEvent('{{ $ev->id }}')" class="flex-1 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs flex items-center justify-center gap-1.5 transition-all cursor-pointer shadow-xs">
                                    <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                                    <span>Kelola Cabang & Jadwal</span>
                                </button>
                                <button wire:click="bukaFormEditEvent('{{ $ev->id }}')" title="Edit Event" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 hover:text-emerald-700 transition-all cursor-pointer">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <button wire:click="hapusEvent('{{ $ev->id }}')" wire:confirm="Yakin ingin menghapus event ini? Semua cabang dan jadwal terkait akan ikut terhapus." title="Hapus Event" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition-all cursor-pointer">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center">
                            <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="calendar-x" class="w-8 h-8"></i>
                            </div>
                            <h3 class="font-extrabold text-slate-900 text-base">Belum Ada Agenda Event</h3>
                            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Klik tombol "Tambah Event Baru" untuk membuat agenda FORKAB, FORPROV, atau festival olahraga baru.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $eventList->links() }}
                </div>
            @endif
        </div>
    @endif

    {{-- ==========================================
         MODE 2: FORM TAMBAH / EDIT EVENT UTAMA
         ========================================== --}}
    @if($mode === 'form_event')
        <div wire:key="event-view-form" class="space-y-6">
            <x-form.header
                title="{{ $editEventId ? 'Edit Data Event' : 'Tambah Event Baru' }}"
                subtitle="Lengkapi informasi agenda event kejuaraan, waktu pelaksanaan, dan venue utama."
                back-route="javascript:void(0)"
                wire:click.prevent="kembaliKeTabel"
            />

            <form wire:submit="simpanEvent" class="space-y-6">
                <x-form.card title="Informasi Pokok Event" icon="trophy">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Judul Event -->
                        <div class="md:col-span-2">
                            <x-form.field label="Judul Event / Festival" name="judul_event" required>
                                <x-form.input 
                                    name="judul_event" 
                                    wire:model.live.debounce.300ms="judul_event" 
                                    placeholder="Contoh: FORKAB Kabupaten Bandung Ke-IV 2026" 
                                    required 
                                />
                            </x-form.field>
                        </div>

                        <!-- Kategori Event -->
                        <div>
                            <x-form.field label="Kategori Event" name="kategori_event_id" required>
                                <x-form.select name="kategori_event_id" wire:model="kategori_event_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoriList as $kat)
                                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </x-form.select>
                            </x-form.field>
                        </div>

                        <!-- Slug URL -->
                        <div>
                            <x-form.field label="Slug URL" name="slug">
                                <x-form.input 
                                    name="slug" 
                                    wire:model="slug" 
                                    placeholder="forkab-kabupaten-bandung-2026" 
                                />
                            </x-form.field>
                        </div>

                        <!-- Tahun Edisi -->
                        <div>
                            <x-form.field label="Tahun Edisi" name="tahun_edisi" required>
                                <x-form.input 
                                    type="number" 
                                    name="tahun_edisi" 
                                    wire:model="tahun_edisi" 
                                    required 
                                />
                            </x-form.field>
                        </div>

                        <!-- Status Publikasi -->
                        <div>
                            <x-form.field label="Status Publikasi" name="status_publikasi">
                                <x-form.select name="status_publikasi" wire:model="status_publikasi">
                                    <option value="1">Publikasi (Tayang di Portal)</option>
                                    <option value="0">Draft (Sembunyikan Sementara)</option>
                                </x-form.select>
                            </x-form.field>
                        </div>

                        <!-- Lokasi Utama -->
                        <div class="md:col-span-3">
                            <x-form.field label="Lokasi / Venue Utama" name="lokasi_utama" required>
                                <x-form.input 
                                    name="lokasi_utama" 
                                    wire:model="lokasi_utama" 
                                    placeholder="Contoh: Kompleks Stadion Si Jalak Harupat, Kutawaringin" 
                                    required 
                                />
                            </x-form.field>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div>
                            <x-form.field label="Tanggal Mulai" name="tanggal_mulai" required>
                                <x-form.datepicker 
                                    name="tanggal_mulai" 
                                    wire:model="tanggal_mulai" 
                                    :enableTime="false"
                                    dateFormat="Y-m-d"
                                    altFormat="j F Y"
                                    placeholder="Pilih tanggal mulai..."
                                />
                            </x-form.field>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div>
                            <x-form.field label="Tanggal Selesai" name="tanggal_selesai" required>
                                <x-form.datepicker 
                                    name="tanggal_selesai" 
                                    wire:model="tanggal_selesai" 
                                    :enableTime="false"
                                    dateFormat="Y-m-d"
                                    altFormat="j F Y"
                                    placeholder="Pilih tanggal selesai..."
                                />
                            </x-form.field>
                        </div>

                        <!-- Tautan Eksternal -->
                        <div>
                            <x-form.field label="Tautan Web / Pendaftaran Eksternal" name="tautan_eksternal">
                                <x-form.input 
                                    type="url" 
                                    name="tautan_eksternal" 
                                    wire:model="tautan_eksternal" 
                                    placeholder="https://..." 
                                />
                            </x-form.field>
                        </div>

                        <!-- Deskripsi Lengkap -->
                        <div class="md:col-span-3">
                            <x-form.field label="Deskripsi & Gambaran Umum Event" name="deskripsi_lengkap">
                                <x-form.textarea 
                                    name="deskripsi_lengkap" 
                                    wire:model="deskripsi_lengkap" 
                                    rows="5" 
                                    placeholder="Tuliskan latar belakang, tujuan, ketentuan umum, dan rangkaian kegiatan..."
                                />
                            </x-form.field>
                        </div>
                    </div>
                </x-form.card>

                <!-- Media & Visual Card -->
                <x-form.card title="Media & Visual Event" icon="image">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Banner Utama -->
                        <div>
                            <x-form.field label="Banner Utama Event (JPG/PNG/WEBP, Max 5MB)" name="uploadBanner">
                                <x-form.image-upload
                                    :upload="$uploadBanner"
                                    :saved-path="$banner_url"
                                    name="uploadBanner"
                                    empty-title="Unggah Banner Utama"
                                    empty-subtitle="Format JPG, PNG, WEBP (Maksimal 5MB)"
                                    :max-size-m-b="5"
                                    aspect-ratio="h-44 sm:h-52"
                                />
                            </x-form.field>
                        </div>

                        <!-- Logo / Maskot -->
                        <div>
                            <x-form.field label="Logo / Maskot Event (Max 3MB)" name="uploadLogo">
                                <x-form.image-upload
                                    :upload="$uploadLogo"
                                    :saved-path="$logo_event_url"
                                    name="uploadLogo"
                                    empty-title="Unggah Logo / Maskot"
                                    empty-subtitle="Format JPG, PNG, WEBP (Maksimal 3MB)"
                                    :max-size-m-b="3"
                                    aspect-ratio="h-44 sm:h-52"
                                />
                            </x-form.field>
                        </div>
                    </div>
                </x-form.card>

                <!-- Action Bar -->
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
                        loading-target="simpanEvent"
                    >
                        Simpan Data Event
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

    {{-- ==========================================
         MODE 3: DETAIL EVENT (CABANG & JADWAL)
         ========================================== --}}
    @if($mode === 'detail_event' && $activeEvent)
        <div wire:key="event-view-detail" class="space-y-6">
            <!-- Active Event Summary Bar -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 text-[10px] font-black">
                            {{ $activeEvent->tahun_edisi }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-700 text-[10px] font-bold">
                            {{ $activeEvent->kategoriEvent?->nama_kategori }}
                        </span>
                    </div>
                    <h2 class="text-xl font-black text-slate-900">{{ $activeEvent->judul_event }}</h2>
                    <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-2">
                        <span><i data-lucide="map-pin" class="w-3.5 h-3.5 inline text-slate-400"></i> {{ $activeEvent->lokasi_utama }}</span>
                        <span>•</span>
                        <span><i data-lucide="calendar" class="w-3.5 h-3.5 inline text-slate-400"></i> {{ $activeEvent->tanggal_mulai?->format('d M') }} - {{ $activeEvent->tanggal_selesai?->format('d M Y') }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <x-form.button 
                        type="button" 
                        variant="secondary" 
                        icon="edit-3" 
                        wire:click="bukaFormEditEvent('{{ $activeEvent->id }}')"
                    >
                        Edit Info Event
                    </x-form.button>
                    <x-form.button 
                        type="button" 
                        variant="secondary" 
                        icon="arrow-left" 
                        wire:click="kembaliKeTabel"
                    >
                        Kembali
                    </x-form.button>
                </div>
            </div>

            <!-- Flash Pesan Sub -->
            @if(session()->has('pesan_sub'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-xs">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                    <p class="text-xs font-bold">{{ session('pesan_sub') }}</p>
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                <button wire:click="$set('tabAktif', 'cabang')" class="px-5 py-2.5 rounded-2xl font-black text-xs flex items-center gap-2 transition-all cursor-pointer {{ $tabAktif === 'cabang' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i data-lucide="award" class="w-4 h-4"></i>
                    <span>Cabang Lomba ({{ $activeEvent->cabang->count() }})</span>
                </button>
                <button wire:click="$set('tabAktif', 'jadwal')" class="px-5 py-2.5 rounded-2xl font-black text-xs flex items-center gap-2 transition-all cursor-pointer {{ $tabAktif === 'jadwal' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    <span>Jadwal & Tahapan ({{ $activeEvent->jadwal->count() }})</span>
                </button>
                <button wire:click="$set('tabAktif', 'info')" class="px-5 py-2.5 rounded-2xl font-black text-xs flex items-center gap-2 transition-all cursor-pointer {{ $tabAktif === 'info' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    <span>Ringkasan & Juknis</span>
                </button>
            </div>

            {{-- TAB: CABANG LOMBA --}}
            @if($tabAktif === 'cabang')
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider">Daftar Cabang Olahraga / Lomba Dipertandingkan</h3>
                        <x-form.button 
                            type="button" 
                            variant="emerald" 
                            icon="plus" 
                            size="sm"
                            wire:click="bukaModalTambahCabang"
                        >
                            Tambah Cabang
                        </x-form.button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($activeEvent->cabang as $cab)
                            <div class="p-5 bg-white rounded-3xl border border-slate-200/80 shadow-xs flex flex-col justify-between hover:border-emerald-300 transition-all">
                                <div>
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                            <i data-lucide="{{ $cab->ikon ?? 'award' }}" class="w-5 h-5"></i>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[10px] font-bold truncate max-w-[140px]">
                                            {{ $cab->inorga?->singkatan ?? 'Non-Inorga' }}
                                        </span>
                                    </div>
                                    <h4 class="font-black text-slate-900 text-sm leading-snug mb-1">{{ $cab->nama_cabang }}</h4>
                                    <p class="text-xs text-slate-500 mb-2">Kategori: <strong class="text-slate-700">{{ $cab->kategori_peserta }}</strong></p>
                                    @if($cab->aturan_juknis_url)
                                        <a href="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($cab->aturan_juknis_url) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 hover:text-emerald-700 mb-2">
                                            <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                            <span>Unduh Dokumen Juknis</span>
                                        </a>
                                    @endif
                                </div>

                                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 mt-2">
                                    <button wire:click="bukaModalEditCabang('{{ $cab->id }}')" class="p-1.5 text-slate-500 hover:text-emerald-600 transition-colors cursor-pointer" title="Edit Cabang">
                                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                                    </button>
                                    <button wire:click="hapusCabang('{{ $cab->id }}')" wire:confirm="Hapus cabang lomba ini?" class="p-1.5 text-slate-500 hover:text-rose-600 transition-colors cursor-pointer" title="Hapus Cabang">
                                        <i data-lucide="trash" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white p-8 rounded-3xl border border-slate-200 text-center">
                                <p class="text-xs text-slate-500 font-bold">Belum ada cabang lomba yang didaftarkan pada event ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- TAB: JADWAL & TAHAPAN --}}
            @if($tabAktif === 'jadwal')
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider">Rundown & Jadwal Pelaksanaan</h3>
                        <x-form.button 
                            type="button" 
                            variant="emerald" 
                            icon="plus" 
                            size="sm"
                            wire:click="bukaModalTambahJadwal"
                        >
                            Tambah Jadwal
                        </x-form.button>
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black uppercase text-slate-500 tracking-wider">
                                    <th class="p-4">Fase / Tahapan</th>
                                    <th class="p-4">Tanggal & Waktu</th>
                                    <th class="p-4">Nama Kegiatan / Lomba</th>
                                    <th class="p-4">Lokasi / Arena</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium">
                                @forelse($activeEvent->jadwal as $jdw)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="p-4 font-black text-slate-800">{{ $jdw->fase_tahapan }}</td>
                                        <td class="p-4 text-slate-600 whitespace-nowrap">
                                            <div>{{ $jdw->tanggal ? $jdw->tanggal->format('d M Y') : '-' }}</div>
                                            <div class="text-[11px] text-slate-400">{{ substr($jdw->jam_mulai, 0, 5) }} - {{ substr($jdw->jam_selesai, 0, 5) }} WIB</div>
                                        </td>
                                        <td class="p-4 font-bold text-slate-900">{{ $jdw->nama_kegiatan }}</td>
                                        <td class="p-4 text-slate-600">{{ $jdw->tempat_arena }}</td>
                                        <td class="p-4">
                                            @if($jdw->status_tahapan === 'selesai')
                                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px]">Selesai</span>
                                            @elseif($jdw->status_tahapan === 'berlangsung')
                                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px] animate-pulse">Berlangsung</span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 font-bold text-[10px]">Akan Datang</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-right whitespace-nowrap">
                                            <button wire:click="bukaModalEditJadwal('{{ $jdw->id }}')" class="p-1.5 text-slate-500 hover:text-emerald-600 transition-colors cursor-pointer" title="Edit Jadwal">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </button>
                                            <button wire:click="hapusJadwal('{{ $jdw->id }}')" wire:confirm="Hapus jadwal kegiatan ini?" class="p-1.5 text-slate-500 hover:text-rose-600 transition-colors cursor-pointer" title="Hapus Jadwal">
                                                <i data-lucide="trash" class="w-4 h-4"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-slate-400 font-bold">Belum ada jadwal pertandingan yang tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- TAB: INFO & DESKRIPSI --}}
            @if($tabAktif === 'info')
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">
                    <div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Gambaran Umum</h4>
                        <div class="prose prose-sm text-slate-700 max-w-none">
                            {!! nl2br(e($activeEvent->deskripsi_lengkap ?? 'Belum ada deskripsi lengkap.')) !!}
                        </div>
                    </div>

                    @if($activeEvent->tautan_eksternal)
                        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200/80 flex items-center justify-between">
                            <span class="text-xs font-bold text-emerald-900">Tautan Resmi Pendaftaran / Portal Luar:</span>
                            <a href="{{ $activeEvent->tautan_eksternal }}" target="_blank" class="px-4 py-1.5 bg-emerald-600 text-white rounded-xl font-extrabold text-xs flex items-center gap-1.5 hover:bg-emerald-700">
                                <span>Buka Tautan</span>
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif

    {{-- ==========================================
         MODAL: TAMBAH / EDIT CABANG LOMBA
         ========================================== --}}
    <x-form.modal
        :show="$bukaModalCabang"
        title="{{ $editCabangId ? 'Edit Cabang Lomba' : 'Tambah Cabang Lomba' }}"
        subtitle="Nomor pertandingan atau kejuaraan Inorga"
        icon="award"
        on-close="$set('bukaModalCabang', false)"
        max-width="max-w-md"
    >
        <form wire:submit="simpanCabang" class="space-y-4">
            <x-form.field label="Nama Cabang / Pertandingan" name="cabang_nama" required>
                <x-form.input 
                    name="cabang_nama" 
                    wire:model="cabang_nama" 
                    placeholder="Contoh: Senam Tera Indonesia (STI) Perorangan" 
                    required 
                />
            </x-form.field>

            <x-form.field label="Afiliasi Inorga (Opsional)" name="cabang_inorga_id">
                <x-form.select name="cabang_inorga_id" wire:model="cabang_inorga_id">
                    <option value="">-- Umum / Non-Inorga --</option>
                    @foreach($inorgaList as $ino)
                        <option value="{{ $ino->id }}">{{ $ino->singkatan }} - {{ $ino->nama_inorga }}</option>
                    @endforeach
                </x-form.select>
            </x-form.field>

            <x-form.field label="Kategori Peserta" name="cabang_kategori_peserta">
                <x-form.input 
                    name="cabang_kategori_peserta" 
                    wire:model="cabang_kategori_peserta" 
                    placeholder="Contoh: Umum, Usia 40+, Pelajar" 
                />
            </x-form.field>

            <x-form.field label="Dokumen Juknis / Petunjuk Teknis" name="uploadJuknis">
                <x-form.file-upload
                    :upload="$uploadJuknis"
                    :saved-path="$cabang_juknis_url"
                    name="uploadJuknis"
                    accept=".pdf,.doc,.docx"
                    :max-size-m-b="10"
                    title="Unggah Dokumen Juknis"
                    subtitle="Format PDF, DOC, DOCX (Maksimal 10MB)"
                />
            </x-form.field>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <x-form.button 
                    type="button" 
                    variant="secondary" 
                    wire:click="$set('bukaModalCabang', false)"
                >
                    Batal
                </x-form.button>
                <x-form.button 
                    type="submit" 
                    variant="emerald" 
                    loading-target="simpanCabang"
                >
                    Simpan
                </x-form.button>
            </div>
        </form>
    </x-form.modal>

    {{-- ==========================================
         MODAL: TAMBAH / EDIT JADWAL TAHAPAN
         ========================================== --}}
    <x-form.modal
        :show="$bukaModalJadwal"
        title="{{ $editJadwalId ? 'Edit Jadwal' : 'Tambah Jadwal Rundown' }}"
        subtitle="Rangkaian jadwal tahapan pertandingan"
        icon="clock"
        on-close="$set('bukaModalJadwal', false)"
        max-width="max-w-md"
    >
        <form wire:submit="simpanJadwal" class="space-y-4">
            <x-form.field label="Fase / Babak" name="jadwal_fase" required>
                <x-form.input 
                    name="jadwal_fase" 
                    wire:model="jadwal_fase" 
                    placeholder="Contoh: Technical Meeting / Babak Penyisihan / Final" 
                    required 
                />
            </x-form.field>

            <x-form.field label="Nama Agenda / Kegiatan" name="jadwal_nama_kegiatan" required>
                <x-form.input 
                    name="jadwal_nama_kegiatan" 
                    wire:model="jadwal_nama_kegiatan" 
                    placeholder="Contoh: Pertandingan Egrang Putri" 
                    required 
                />
            </x-form.field>

            <div class="grid grid-cols-3 gap-2">
                <div class="col-span-1">
                    <x-form.field label="Tanggal" name="jadwal_tanggal" required>
                        <x-form.datepicker 
                            name="jadwal_tanggal" 
                            wire:model="jadwal_tanggal" 
                            :enableTime="false"
                            dateFormat="Y-m-d"
                            altFormat="j F Y"
                            placeholder="Pilih tanggal..."
                        />
                    </x-form.field>
                </div>
                <div>
                    <x-form.field label="Jam Mulai" name="jadwal_jam_mulai">
                        <x-form.input 
                            type="time" 
                            name="jadwal_jam_mulai" 
                            wire:model="jadwal_jam_mulai" 
                        />
                    </x-form.field>
                </div>
                <div>
                    <x-form.field label="Jam Selesai" name="jadwal_jam_selesai">
                        <x-form.input 
                            type="time" 
                            name="jadwal_jam_selesai" 
                            wire:model="jadwal_jam_selesai" 
                        />
                    </x-form.field>
                </div>
            </div>

            <x-form.field label="Lokasi / Venue Arena" name="jadwal_tempat_arena" required>
                <x-form.input 
                    name="jadwal_tempat_arena" 
                    wire:model="jadwal_tempat_arena" 
                    placeholder="Contoh: Lapangan Panahan SJH" 
                    required 
                />
            </x-form.field>

            <x-form.field label="Status Tahapan" name="jadwal_status" required>
                <x-form.select name="jadwal_status" wire:model="jadwal_status" required>
                    <option value="akan_datang">Akan Datang</option>
                    <option value="berlangsung">Sedang Berlangsung</option>
                    <option value="selesai">Selesai</option>
                </x-form.select>
            </x-form.field>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <x-form.button 
                    type="button" 
                    variant="secondary" 
                    wire:click="$set('bukaModalJadwal', false)"
                >
                    Batal
                </x-form.button>
                <x-form.button 
                    type="submit" 
                    variant="emerald" 
                    loading-target="simpanJadwal"
                >
                    Simpan
                </x-form.button>
            </div>
        </form>
    </x-form.modal>

    {{-- ==========================================
         MODAL: KELOLA KATEGORI EVENT
         ========================================== --}}
    <x-form.modal
        :show="$bukaModalKategori"
        title="Kelola Kategori Event"
        subtitle="Kategori pengelompokan agenda dan festival"
        icon="tag"
        on-close="$set('bukaModalKategori', false)"
        max-width="max-w-lg"
    >
        <div class="space-y-4">
            @if(session()->has('pesan_kategori'))
                <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-bold">
                    {{ session('pesan_kategori') }}
                </div>
            @endif
            @if(session()->has('error_kategori'))
                <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-bold">
                    {{ session('error_kategori') }}
                </div>
            @endif

            <!-- Form Input Kategori -->
            <form wire:submit="simpanKategori" class="flex gap-2">
                <div class="flex-1">
                    <x-form.input 
                        name="nama_kategori" 
                        wire:model="nama_kategori" 
                        placeholder="Nama kategori baru (contoh: Festival Budaya)" 
                    />
                </div>
                <x-form.button 
                    type="submit" 
                    variant="emerald" 
                    loading-target="simpanKategori"
                >
                    {{ $editKategoriId ? 'Update' : 'Tambah' }}
                </x-form.button>
            </form>
            @error('nama_kategori') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror

            <!-- List Kategori -->
            <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                @foreach($kategoriList as $kat)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-2xl border border-slate-200/80">
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs">{{ $kat->nama_kategori }}</h4>
                            <span class="text-[10px] text-slate-400">{{ $kat->events_count }} Event terhubung</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <button wire:click="editKategori('{{ $kat->id }}')" class="p-1 text-slate-400 hover:text-emerald-600 cursor-pointer" title="Edit">
                                <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                            </button>
                            <button wire:click="hapusKategori('{{ $kat->id }}')" wire:confirm="Hapus kategori ini?" class="p-1 text-slate-400 hover:text-rose-600 cursor-pointer" title="Hapus">
                                <i data-lucide="trash" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end pt-3 border-t border-slate-100">
                <x-form.button 
                    type="button" 
                    variant="secondary" 
                    wire:click="$set('bukaModalKategori', false)"
                >
                    Tutup
                </x-form.button>
            </div>
        </div>
    </x-form.modal>
</div>
