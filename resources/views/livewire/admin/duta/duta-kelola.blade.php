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
                title="Katalog & Kader Duta Olahraga Masyarakat"
                subtitle="Data profil duta penggerak olahraga di 31 Kecamatan dan 280 Desa/Kelurahan se-Kabupaten Bandung."
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
                        <span>Tambah Duta Baru</span>
                    </button>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Duta Terdata"
                    :value="number_format($totalDuta)"
                    unit="Kader"
                    subtitle="Duta olahraga masyarakat"
                    icon="award"
                    color="indigo"
                    :active="$kecamatanDipilih === 'Semua' && $tahunDipilih === 'Semua' && $unggulanDipilih === 'Semua'"
                    loading-target="resetSemuaFilter, kecamatanDipilih, tahunDipilih"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Cakupan Kecamatan"
                    :value="number_format($totalKecamatanTerwakili)"
                    unit="/ 31 Kec"
                    subtitle="Wilayah telah memiliki kader"
                    icon="map-pin"
                    color="emerald"
                    :pulse="true"
                    loading-target="kecamatanDipilih"
                    wire:click="$set('kecamatanDipilih', 'Semua')"
                />

                <x-table.stats-card
                    title="Duta Unggulan (Top)"
                    :value="number_format($dutaUnggulanCount)"
                    unit="Tokoh"
                    subtitle="Kader berprestasi utama"
                    icon="star"
                    color="amber"
                    :active="$unggulanDipilih === 'ya'"
                    loading-target="unggulanDipilih"
                    wire:click="$set('unggulanDipilih', 'ya')"
                />

                <x-table.stats-card
                    title="Edisi Tahun Ini"
                    :value="number_format($dutaTahunIni)"
                    unit="Orang"
                    subtitle="Pemilihan periode 2026"
                    icon="calendar"
                    color="indigo"
                    :active="$tahunDipilih == 2026"
                    loading-target="tahunDipilih"
                    wire:click="$set('tahunDipilih', '2026')"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                search-placeholder="Cari nama duta, profesi, gelar, instagram, desa/kecamatan..." 
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
                        <option value="Duta Senam & Kesehatan">Duta Senam & Kesehatan</option>
                        <option value="Duta Olahraga Tradisional">Duta Olahraga Tradisional</option>
                    </select>

                    <!-- Filter Status Unggulan -->
                    <select wire:model.live="unggulanDipilih" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="Semua">Semua Sorotan</option>
                        <option value="ya">⭐ Duta Unggulan</option>
                        <option value="tidak">Duta Reguler</option>
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
                        <option value="dibuat_pada">Urut: Tanggal Didaftarkan</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="asc">Menaik (ASC)</option>
                        <option value="desc">Menurun (DESC)</option>
                    </select>

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
                    wire:click="bulkToggleUnggulan(true)" 
                    class="px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 text-xs font-black transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                    <span>Set Duta Unggulan</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkToggleAktif(true)" 
                    class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                    <span>Set Aktif</span>
                </button>

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
                    <x-table.table loading-target="cari, kecamatanDipilih, tahunDipilih, kategoriDipilih, statusDipilih, unggulanDipilih, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
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
                                    Profil Duta & Gelar
                                </x-table.th>
                                <x-table.th>Wilayah Penugasan</x-table.th>
                                <x-table.th>Kontak & Sosmed</x-table.th>
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
                                <x-table.th align="center">Sorotan</x-table.th>
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

                                    <!-- Profil Duta with Inline Edit -->
                                    <x-table.td>
                                        <div class="flex items-center gap-3.5 max-w-md">
                                            <div class="relative shrink-0 group cursor-pointer" wire:click="bukaPratinjau('{{ $d->id }}')">
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
                                                @if($d->status_unggulan)
                                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-amber-400 text-slate-900 rounded-full flex items-center justify-center text-[9px] shadow-xs" title="Duta Unggulan">⭐</span>
                                                @endif
                                            </div>

                                            <div class="min-w-0 flex-1 space-y-0.5">
                                                <x-table.editable-cell 
                                                    :model-id="$d->id" 
                                                    field="nama_lengkap" 
                                                    :value="$d->nama_lengkap"
                                                    placeholder="Nama lengkap duta..."
                                                >
                                                    <span class="font-black text-slate-900 text-xs sm:text-sm hover:text-indigo-600 line-clamp-1 leading-tight transition-colors cursor-pointer block">
                                                        {{ $d->nama_lengkap }}
                                                    </span>
                                                </x-table.editable-cell>

                                                <div class="flex items-center gap-2 text-[11px] text-slate-400 font-medium">
                                                    @if($d->gelar_prestasi)
                                                        <span class="text-indigo-600 font-semibold truncate max-w-[180px]">{{ $d->gelar_prestasi }}</span>
                                                        <span>•</span>
                                                    @endif
                                                    <span class="text-slate-400">{{ $d->jenis_kelamin === 'P' ? 'Perempuan' : 'Laki-laki' }}</span>
                                                    @if($d->pekerjaan_profesi)
                                                        <span>•</span>
                                                        <span class="truncate max-w-[120px]">{{ $d->pekerjaan_profesi }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Wilayah Penugasan -->
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

                                    <!-- Kontak & Sosmed -->
                                    <x-table.td>
                                        <div class="space-y-1 text-xs">
                                            @if($d->nomor_telepon)
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $d->nomor_telepon) }}" target="_blank" class="flex items-center gap-1.5 text-slate-700 hover:text-emerald-600 font-semibold transition-colors">
                                                    <i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-600"></i>
                                                    <span>{{ $d->nomor_telepon }}</span>
                                                </a>
                                            @else
                                                <span class="text-slate-300 text-[11px] italic">Tanpa Nomor HP</span>
                                            @endif

                                            @if($d->akun_instagram)
                                                <a href="https://instagram.com/{{ $d->akun_instagram }}" target="_blank" class="flex items-center gap-1 text-[11px] text-pink-600 hover:underline font-bold">
                                                    <i data-lucide="instagram" class="w-3 h-3"></i>
                                                    <span>@<span>{{ $d->akun_instagram }}</span></span>
                                                </a>
                                            @endif
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

                                    <!-- Sorotan Unggulan -->
                                    <x-table.td align="center">
                                        <button 
                                            type="button" 
                                            wire:click="toggleUnggulan('{{ $d->id }}')" 
                                            class="w-7 h-7 rounded-xl flex items-center justify-center transition-all cursor-pointer {{ $d->status_unggulan ? 'bg-amber-100 text-amber-600 hover:bg-amber-200' : 'bg-slate-100 text-slate-300 hover:text-amber-500 hover:bg-amber-50' }}"
                                            title="Toggle Duta Unggulan"
                                        >
                                            <i data-lucide="star" class="w-4 h-4 {{ $d->status_unggulan ? 'fill-current' : '' }}"></i>
                                        </button>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="right">
                                        <div class="flex items-center justify-end gap-1">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="secondary" 
                                                icon="eye" 
                                                wire:click="bukaPratinjau('{{ $d->id }}')" 
                                                title="Lihat Profil Lengkap" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="indigo" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdit('{{ $d->id }}')"
                                                wire:click="bukaFormEdit('{{ $d->id }}')" 
                                                title="Edit Biodata Lengkap" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="secondary" 
                                                icon="copy" 
                                                wire:click="duplikatDuta('{{ $d->id }}')" 
                                                title="Duplikat Data" 
                                            />

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                wire:click="konfirmasiHapus('{{ $d->id }}')" 
                                                title="Hapus Data Duta" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="8" 
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
                        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between group {{ in_array($d->id, $selectedDuta) ? 'ring-2 ring-indigo-500' : '' }}">
                            <div>
                                <div class="relative h-48 rounded-2xl overflow-hidden bg-slate-100 mb-4 border border-slate-100 cursor-pointer" wire:click="bukaPratinjau('{{ $d->id }}')">
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

                                    <div class="absolute top-2.5 left-2.5 flex items-center gap-1.5">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-900/80 text-white backdrop-blur-xs shadow-xs">
                                            {{ $d->tahun_pemilihan }}
                                        </span>
                                        @if($d->status_unggulan)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400 text-slate-900 shadow-xs flex items-center gap-1">
                                                ⭐ Unggulan
                                            </span>
                                        @endif
                                    </div>

                                    <div class="absolute top-2.5 right-2.5">
                                        <input 
                                            type="checkbox" 
                                            wire:model.live="selectedDuta" 
                                            value="{{ $d->id }}" 
                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer shadow-md"
                                        >
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">
                                        <i data-lucide="map-pin" class="w-3 h-3"></i>
                                        <span>Kec. {{ $d->kecamatan->nama_kecamatan ?? '-' }}</span>
                                    </span>
                                    <h3 class="font-black text-slate-900 text-sm group-hover:text-indigo-600 transition-colors line-clamp-1 mt-1 cursor-pointer" wire:click="bukaPratinjau('{{ $d->id }}')">{{ $d->nama_lengkap }}</h3>
                                    <p class="text-xs text-slate-500 font-medium line-clamp-1">{{ $d->desaKelurahan->nama_desa_kelurahan ? 'Desa ' . $d->desaKelurahan->nama_desa_kelurahan : 'Kader Kecamatan' }}</p>
                                    
                                    @if($d->gelar_prestasi || $d->prestasi)
                                        <p class="text-[11px] text-slate-400 line-clamp-2 mt-2 pt-2 border-t border-slate-100 italic">{{ $d->gelar_prestasi ?: $d->prestasi }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 mt-4 border-t border-slate-100 text-xs">
                                <span class="text-[10px] font-bold text-slate-400 truncate max-w-[110px]">{{ $d->nomor_telepon ?: ($d->akun_instagram ? '@'.$d->akun_instagram : 'Tanpa Kontak') }}</span>
                                <div class="flex items-center gap-1.5">
                                    <x-table.action-btn 
                                        size="sm"
                                        variant="secondary" 
                                        icon="eye" 
                                        wire:click="bukaPratinjau('{{ $d->id }}')" 
                                        title="Pratinjau Profil" 
                                    />
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
                                        wire:click="konfirmasiHapus('{{ $d->id }}')" 
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
                :title="$dutaId ? 'Edit Biodata Lengkap Duta Olahraga' : 'Registrasi & Pendataan Duta Olahraga Baru'"
                subtitle="Lengkapi data profil detail kader, penugasan wilayah, riwayat prestasi olahraga, dan pas foto resmi."
                :badge="$dutaId ? 'Mode Edit Duta' : 'Pendaftaran Duta Baru'"
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
                    
                    <!-- Left Column (7 cols): Detailed Personal & Location Info -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- CARD 1: IDENTITAS UTAMA -->
                        <x-form.card 
                            title="Identitas Kader Duta" 
                            subtitle="Informasi personal dan kependudukan duta olahraga."
                            icon="user-check"
                            size="default"
                        >
                            <!-- Nama Lengkap & Jenis Kelamin -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-2">
                                    <x-form.field label="Nama Lengkap Beserta Gelar" name="nama_lengkap" :required="true">
                                        <x-form.input 
                                            name="nama_lengkap" 
                                            wire:model="nama_lengkap" 
                                            placeholder="Contoh: Rian Hidayat, S.Pd., M.Or." 
                                            size="lg"
                                            icon="user"
                                        />
                                    </x-form.field>
                                </div>

                                <div>
                                    <x-form.field label="Jenis Kelamin" name="jenis_kelamin" :required="true">
                                        <x-form.select name="jenis_kelamin" wire:model="jenis_kelamin">
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </x-form.select>
                                    </x-form.field>
                                </div>
                            </div>

                            <!-- Tempat & Tanggal Lahir -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Tempat Lahir (Kota/Kab)" name="tempat_lahir">
                                    <x-form.input 
                                        type="text"
                                        name="tempat_lahir" 
                                        wire:model="tempat_lahir" 
                                        placeholder="Contoh: Bandung" 
                                        icon="map-pin"
                                    />
                                </x-form.field>

                                <x-form.field label="Tanggal Lahir" name="tanggal_lahir">
                                    <x-form.datepicker 
                                        name="tanggal_lahir" 
                                        wire:model="tanggal_lahir" 
                                        :enableTime="false"
                                        dateFormat="Y-m-d"
                                        altFormat="j F Y"
                                        placeholder="Pilih tanggal lahir..."
                                    />
                                </x-form.field>
                            </div>

                            <!-- Profesi & Pendidikan -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Profesi / Pekerjaan Saat Ini" name="pekerjaan_profesi">
                                    <x-form.input 
                                        type="text"
                                        name="pekerjaan_profesi" 
                                        wire:model="pekerjaan_profesi" 
                                        placeholder="Contoh: Guru Olahraga / Atlet / Wiraswasta" 
                                        icon="briefcase"
                                    />
                                </x-form.field>

                                <x-form.field label="Pendidikan Terakhir" name="pendidikan_terakhir">
                                    <x-form.select name="pendidikan_terakhir" wire:model="pendidikan_terakhir">
                                        <option value="">-- Pilih Jenjang --</option>
                                        <option value="SMA/SMK">SMA / SMK Sederajat</option>
                                        <option value="Diploma (D3/D4)">Diploma (D3/D4)</option>
                                        <option value="Sarjana (S1)">Sarjana (S1)</option>
                                        <option value="Magister (S2)">Magister (S2)</option>
                                        <option value="Doktor (S3)">Doktor (S3)</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </x-form.select>
                                </x-form.field>
                            </div>
                        </x-form.card>

                        <!-- CARD 2: PENUGASAN & WILAYAH -->
                        <x-form.card 
                            title="Penugasan Wilayah & Klasifikasi" 
                            subtitle="Kecamatan penempatan, kategori pembinaan, dan tahun pemilihan."
                            icon="map"
                            size="default"
                        >
                            <!-- Wilayah Kecamatan & Desa -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Kecamatan Penugasan" name="kecamatan_id" :required="true">
                                    <x-form.select name="kecamatan_id" wire:model.live="kecamatan_id">
                                        @foreach($kecamatanList as $kec)
                                            <option value="{{ $kec->id }}">Kec. {{ $kec->nama_kecamatan }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <x-form.field label="Desa / Kelurahan Penugasan" name="desa_kelurahan_id">
                                    <x-form.select name="desa_kelurahan_id" wire:model="desa_kelurahan_id">
                                        <option value="">-- Koordinator Tingkat Kecamatan --</option>
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
                                        <option value="Duta Senam & Kesehatan">Duta Senam & Kesehatan</option>
                                        <option value="Duta Olahraga Tradisional">Duta Olahraga Tradisional</option>
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

                            <!-- Alamat Domisili -->
                            <x-form.field label="Alamat Domisili Lengkap (Opsional)" name="alamat_domisili">
                                <x-form.textarea 
                                    name="alamat_domisili" 
                                    wire:model="alamat_domisili" 
                                    placeholder="Jalan, RT/RW, Dusun, atau patokan alamat..."
                                    rows="2"
                                />
                            </x-form.field>
                        </x-form.card>

                        <!-- CARD 3: PRESTASI & PENGALAMAN -->
                        <x-form.card 
                            title="Rekam Jejak & Prestasi Olahraga" 
                            subtitle="Gelar penghargaan, lisensi keolahragaan, atau kontribusi pembinaan."
                            icon="trophy"
                            size="default"
                        >
                            <!-- Gelar Singkat Prestasi -->
                            <x-form.field label="Gelar Prestasi Utama / Highlight" name="gelar_prestasi">
                                <x-form.input 
                                    type="text"
                                    name="gelar_prestasi" 
                                    wire:model="gelar_prestasi" 
                                    placeholder="Contoh: Juara 1 Senam Bugar Jabar 2025 / Instruktur Berlisensi" 
                                    icon="award"
                                />
                            </x-form.field>

                            <!-- Deskripsi Lengkap -->
                            <x-form.field label="Deskripsi Pengalaman & Riwayat Keolahragaan" name="deskripsi_prestasi">
                                <x-form.textarea 
                                    name="deskripsi_prestasi" 
                                    wire:model="deskripsi_prestasi" 
                                    placeholder="Tuliskan jejak rekam kejuaraan, sertifikasi kepelatihan, atau peran penggerak di masyarakat..."
                                    rows="4"
                                />
                            </x-form.field>
                        </x-form.card>

                    </div>

                    <!-- Right Column (5 cols): Photo & Status Flags -->
                    <div class="lg:col-span-5 space-y-6">
                        
                        <!-- Pas Foto Profil -->
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

                        <!-- Kontak & Media Sosial -->
                        <x-form.card 
                            title="Kontak & Kanal Media Sosial" 
                            subtitle="Akses komunikasi langsung dan publikasi kader."
                            icon="phone"
                            size="default"
                        >
                            <x-form.field label="Nomor WhatsApp / Telepon" name="nomor_telepon">
                                <x-form.input 
                                    type="text"
                                    name="nomor_telepon" 
                                    wire:model="nomor_telepon" 
                                    placeholder="Contoh: 081234567890" 
                                    icon="phone"
                                />
                            </x-form.field>

                            <x-form.field label="Alamat Email (Opsional)" name="email">
                                <x-form.input 
                                    type="email"
                                    name="email" 
                                    wire:model="email" 
                                    placeholder="Contoh: duta@kormibdg.id" 
                                    icon="mail"
                                />
                            </x-form.field>

                            <x-form.field label="Username Akun Instagram (Opsional)" name="akun_instagram">
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 font-bold text-xs">@</span>
                                    <input 
                                        type="text" 
                                        wire:model="akun_instagram" 
                                        placeholder="username_instagram" 
                                        class="w-full pl-8 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl text-xs font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                                    >
                                </div>
                            </x-form.field>
                        </x-form.card>

                        <!-- Status Publikasi & Sorotan -->
                        <x-form.card 
                            title="Pengaturan Status & Sorotan" 
                            subtitle="Tentukan visibilitas pada direktori publik."
                            icon="sliders"
                            size="default"
                        >
                            <div class="space-y-4">
                                <label class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-200/80 cursor-pointer hover:bg-slate-100/60 transition-colors">
                                    <div class="space-y-0.5">
                                        <p class="text-xs font-black text-slate-900">⭐ Duta Olahraga Unggulan</p>
                                        <p class="text-[11px] text-slate-500">Tampilkan pada sorotan banner halaman utama.</p>
                                    </div>
                                    <input type="checkbox" wire:model="status_unggulan" class="w-5 h-5 rounded text-amber-500 focus:ring-amber-400 cursor-pointer">
                                </label>

                                <label class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-200/80 cursor-pointer hover:bg-slate-100/60 transition-colors">
                                    <div class="space-y-0.5">
                                        <p class="text-xs font-black text-slate-900">Status Keaktifan Kader</p>
                                        <p class="text-[11px] text-slate-500">Duta berstatus aktif dalam kegiatan.</p>
                                    </div>
                                    <input type="checkbox" wire:model="status_aktif" class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                </label>
                            </div>
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

    <!-- ========================================================= -->
    <!-- MODAL: PRATINJAU KARTU PROFIL DUTA LENGKAP               -->
    <!-- ========================================================= -->
    @if($tampilkanModalPratinjau && $pratinjauDuta)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <i data-lucide="award" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">Profil Duta Olahraga Masyarakat</h3>
                            <p class="text-[10px] text-slate-400">Kabupaten Bandung • Periode {{ $pratinjauDuta->tahun_pemilihan }}</p>
                        </div>
                    </div>
                    <button type="button" wire:click="tutupPratinjau" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto space-y-6">
                    <div class="flex flex-col sm:flex-row items-center gap-5">
                        <div class="w-32 h-36 rounded-2xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200 shadow-sm relative">
                            @if($pratinjauDuta->foto_url)
                                @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($pratinjauDuta->foto_url) @endphp
                                <img src="{{ $tmpUrl }}" class="w-full h-full object-cover" alt="{{ $pratinjauDuta->nama_lengkap }}">
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-indigo-600 to-violet-500 text-white font-black text-3xl flex items-center justify-center">
                                    {{ strtoupper(substr($pratinjauDuta->nama_lengkap, 0, 2)) }}
                                </div>
                            @endif
                            @if($pratinjauDuta->status_unggulan)
                                <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full bg-amber-400 text-slate-900 text-[9px] font-black shadow-xs">⭐ Top</span>
                            @endif
                        </div>

                        <div class="space-y-1.5 text-center sm:text-left flex-1 min-w-0">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200">
                                {{ $pratinjauDuta->kategori_duta }}
                            </span>
                            <h2 class="text-xl font-black text-slate-900">{{ $pratinjauDuta->nama_lengkap }}</h2>
                            <p class="text-xs font-bold text-slate-500 flex items-center justify-center sm:justify-start gap-1">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-indigo-600"></i>
                                <span>Kecamatan {{ $pratinjauDuta->kecamatan->nama_kecamatan ?? '-' }}</span>
                                <span>•</span>
                                <span>{{ $pratinjauDuta->desaKelurahan->nama_desa_kelurahan ? 'Desa ' . $pratinjauDuta->desaKelurahan->nama_desa_kelurahan : 'Kader Kecamatan' }}</span>
                            </p>
                            @if($pratinjauDuta->gelar_prestasi)
                                <p class="text-xs text-amber-600 font-bold italic">{{ $pratinjauDuta->gelar_prestasi }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Detail Data Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Jenis Kelamin</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauDuta->jenis_kelamin === 'P' ? 'Perempuan' : 'Laki-laki' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Pendidikan</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauDuta->pendidikan_terakhir ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Profesi</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauDuta->pekerjaan_profesi ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">WhatsApp</span>
                            <span class="font-bold text-slate-800">{{ $pratinjauDuta->nomor_telepon ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Instagram</span>
                            <span class="font-bold text-pink-600">{{ $pratinjauDuta->akun_instagram ? '@'.$pratinjauDuta->akun_instagram : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Status</span>
                            <span class="font-bold {{ $pratinjauDuta->status_aktif ? 'text-emerald-600' : 'text-slate-400' }}">{{ $pratinjauDuta->status_aktif ? 'Aktif' : 'Non-Aktif' }}</span>
                        </div>
                    </div>

                    @if($pratinjauDuta->deskripsi_prestasi || $pratinjauDuta->prestasi)
                        <div class="space-y-1.5">
                            <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider">Catatan Prestasi & Pengalaman:</h4>
                            <p class="text-xs text-slate-600 leading-relaxed p-3.5 rounded-2xl bg-indigo-50/50 border border-indigo-100 whitespace-pre-line">
                                {{ $pratinjauDuta->deskripsi_prestasi ?: $pratinjauDuta->prestasi }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <button 
                        type="button" 
                        wire:click="bukaFormEdit('{{ $pratinjauDuta->id }}')" 
                        class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer flex items-center gap-1.5"
                    >
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                        <span>Edit Biodata</span>
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
    <!-- MODAL: KONFIRMASI HAPUS DUTA                              -->
    <!-- ========================================================= -->
    @if($tampilkanModalHapus)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden border border-slate-100 p-6 sm:p-7 space-y-6 text-center">
                <div class="w-14 h-14 rounded-3xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto shadow-sm">
                    <i data-lucide="alert-triangle" class="w-7 h-7"></i>
                </div>

                <div class="space-y-2">
                    <h3 class="text-lg font-black text-slate-900">Hapus Data Duta Olahraga?</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Apakah Anda yakin ingin menghapus data duta <br>
                        <span class="font-bold text-slate-900 italic">"{{ $hapusNama }}"</span>?
                    </p>
                    <p class="text-[11px] text-rose-600 font-medium">Data dan pas foto terkait akan dihapus secara permanen dari server.</p>
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
