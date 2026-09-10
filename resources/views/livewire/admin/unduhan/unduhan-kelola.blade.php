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
        <!-- VIEW MODE: TABEL DAFTAR DOKUMEN UNDUHAN   -->
        <!-- ========================================== -->
        <div wire:key="unduhan-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                        <span>REPOSITORI PUBLIK</span>
                        <span>•</span>
                        <span class="text-emerald-600 font-black">DOKUMEN & REGULASI</span>
                    </div>
                    <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Berkas & Unduhan</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Upload dan kelola regulasi, SK, formulir pendaftaran, juknis, dan materi resmi KORMI Kabupaten Bandung.</p>
                </div>

                <div class="flex items-center gap-2.5 self-start md:self-auto flex-wrap">
                    <button 
                        type="button" 
                        wire:click="bukaFormTambah" 
                        class="inline-flex items-center justify-center gap-2.5 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95"
                    >
                        <i data-lucide="file-plus" class="w-4 h-4"></i>
                        <span>Unggah Dokumen Baru</span>
                    </button>
                </div>
            </div>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Dokumen"
                    :value="number_format($totalDokumen)"
                    unit="Berkas"
                    subtitle="Semua file terarsip"
                    icon="files"
                    color="indigo"
                    :active="$kategoriDipilih === 'Semua' && $statusDipilih === 'Semua'"
                    loading-target="resetSemuaFilter, setFilterKategori, setFilterStatus"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Dokumen Publik"
                    :value="number_format($totalPublik)"
                    unit="Tampil"
                    subtitle="Dapat diunduh publik"
                    icon="globe"
                    color="emerald"
                    :pulse="true"
                    :active="$statusDipilih === 'publik'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('publik')"
                />

                <x-table.stats-card
                    title="Dokumen Privat"
                    :value="number_format($totalPrivat)"
                    unit="Privat"
                    subtitle="Arsip internal"
                    icon="lock"
                    color="slate"
                    :active="$statusDipilih === 'privat'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('privat')"
                />

                <x-table.stats-card
                    title="Total Diunduh"
                    :value="number_format($totalHits)"
                    unit="Kali"
                    subtitle="Akumulasi unduhan"
                    icon="download"
                    color="amber"
                    loading-target="cari, setFilterKategori"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar search-placeholder="Cari judul dokumen, deskripsi berkas..." search-model="cari">
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                        <button 
                            type="button"
                            wire:click="setFilterKategori('Semua')" 
                            class="px-4 py-2 rounded-2xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap shrink-0 flex items-center gap-1.5 {{ $kategoriDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <span>Semua Kategori</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $kategoriDipilih === 'Semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $totalDokumen }}</span>
                        </button>

                        @foreach($kategoriList as $k)
                            <button 
                                type="button"
                                wire:click="setFilterKategori('{{ $k->id }}')" 
                                class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $kategoriDipilih === $k->id ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                            >
                                <i data-lucide="folder" class="w-3.5 h-3.5 {{ $kategoriDipilih === $k->id ? 'text-white' : 'text-emerald-600' }}"></i>
                                <span>{{ $k->nama_kategori }}</span>
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $kategoriDipilih === $k->id ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $k->unduhan_count }}</span>
                            </button>
                        @endforeach
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <!-- Status Filter -->
                    <select wire:model.live="statusDipilih" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="Semua">Semua Akses</option>
                        <option value="publik">Publik</option>
                        <option value="privat">Privat</option>
                    </select>

                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="dibuat_pada">Urutan: Tanggal Rilis</option>
                        <option value="judul_dokumen">Urutan: Judul (A-Z)</option>
                        <option value="jumlah_unduhan">Urutan: Terpopuler</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="desc">Terbaru (DESC)</option>
                        <option value="asc">Terlama (ASC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="10">10 / hal</option>
                        <option value="25">25 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>
                </x-slot:actions>
            </x-table.filter-bar>

            <!-- 4. FLOATING BULK ACTIONS BAR -->
            <x-table.bulk-bar :count="count($selectedUnduhan)" label="dokumen dipilih" reset-action="resetSelection">
                <button 
                    type="button" 
                    wire:click="bulkPublish" 
                    class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="globe" class="w-3.5 h-3.5"></i>
                    <span>Jadikan Publik</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkPrivate" 
                    class="px-3 py-1.5 rounded-xl bg-slate-700 hover:bg-slate-800 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                    <span>Jadikan Privat</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDelete" 
                    wire:confirm="Yakin ingin menghapus {{ count($selectedUnduhan) }} dokumen terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. DATA TABLE -->
            <x-table.card>
                <x-table.table loading-target="cari, kategoriDipilih, statusDipilih, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
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
                                sort-field="judul_dokumen" 
                                :current-sort="$sortField" 
                                :current-direction="$sortDirection"
                            >
                                Informasi Dokumen
                            </x-table.th>
                            <x-table.th>Kategori</x-table.th>
                            <x-table.th align="center">Format</x-table.th>
                            <x-table.th>Ukuran</x-table.th>
                            <x-table.th 
                                align="center" 
                                sortable 
                                sort-field="jumlah_unduhan" 
                                :current-sort="$sortField" 
                                :current-direction="$sortDirection"
                            >
                                Total Unduhan
                            </x-table.th>
                            <x-table.th align="center">Akses</x-table.th>
                            <x-table.th align="right">Aksi</x-table.th>
                        </tr>
                    </x-table.thead>
                    <x-table.tbody>
                        @forelse($unduhanList as $u)
                            <x-table.tr wire:key="row-unduhan-{{ $u->id }}" :selected="in_array($u->id, $selectedUnduhan)">
                                <!-- Checkbox -->
                                <x-table.td align="center" class="!px-3.5 w-10">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="selectedUnduhan" 
                                        value="{{ $u->id }}" 
                                        class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                    >
                                </x-table.td>

                                <!-- Document Title -->
                                <x-table.td>
                                    <div class="flex items-center gap-3.5 max-w-lg">
                                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 font-black text-xs {{ strtoupper($u->ekstensi_berkas) === 'PDF' ? 'bg-rose-50 text-rose-600 border border-rose-100' : (in_array(strtoupper($u->ekstensi_berkas), ['DOC', 'DOCX']) ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100') }}">
                                            <i data-lucide="file-text" class="w-5 h-5"></i>
                                        </div>
                                        <div class="min-w-0 space-y-0.5">
                                            <a 
                                                href="javascript:void(0)" 
                                                wire:click="bukaFormEdit('{{ $u->id }}')" 
                                                class="font-black text-slate-900 text-xs hover:text-emerald-600 line-clamp-1 leading-tight transition-colors cursor-pointer"
                                            >
                                                {{ $u->judul_dokumen }}
                                            </a>
                                            <span class="text-[11px] text-slate-400 font-medium">Oleh: {{ $u->pengunggah->nama_lengkap ?? 'Admin KORMI' }} • {{ \Carbon\Carbon::parse($u->dibuat_pada)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </x-table.td>

                                <!-- Category -->
                                <x-table.td>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                        <i data-lucide="folder" class="w-3 h-3 text-emerald-600"></i>
                                        <span>{{ $u->kategori->nama_kategori ?? '-' }}</span>
                                    </span>
                                </x-table.td>

                                <!-- Format -->
                                <x-table.td align="center">
                                    <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ strtoupper($u->ekstensi_berkas) === 'PDF' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                        {{ $u->ekstensi_berkas }}
                                    </span>
                                </x-table.td>

                                <!-- File Size -->
                                <x-table.td class="text-slate-500 font-bold">
                                    {{ $u->ukuran_berkas }}
                                </x-table.td>

                                <!-- Downloads Count -->
                                <x-table.td align="center">
                                    <span class="inline-flex items-center gap-1 font-black text-slate-800 bg-slate-100 px-3 py-1 rounded-xl text-xs">
                                        <i data-lucide="download-cloud" class="w-3.5 h-3.5 text-slate-400"></i>
                                        {{ number_format($u->jumlah_unduhan) }}x
                                    </span>
                                </x-table.td>

                                <!-- Public Status -->
                                <x-table.td align="center">
                                    <button 
                                        type="button"
                                        wire:click="toggleStatusPublik('{{ $u->id }}')" 
                                        class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer {{ $u->status_publik ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:scale-105' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:scale-105' }}"
                                        title="Ubah status akses"
                                    >
                                        {{ $u->status_publik ? 'Publik' : 'Privat' }}
                                    </button>
                                </x-table.td>

                                <!-- Actions -->
                                <x-table.td align="right">
                                    <div class="flex items-center justify-end gap-1">
                                        <x-table.action-btn 
                                            size="sm"
                                            variant="success" 
                                            icon="edit-3" 
                                            loading-target="bukaFormEdit('{{ $u->id }}')"
                                            wire:click="bukaFormEdit('{{ $u->id }}')" 
                                            title="Edit Dokumen" 
                                        />

                                        <x-table.action-btn 
                                            size="sm"
                                            variant="danger" 
                                            icon="trash-2" 
                                            loading-target="hapus('{{ $u->id }}')"
                                            wire:click="hapus('{{ $u->id }}')" 
                                            wire:confirm="Yakin ingin menghapus dokumen ini dari repositori unduhan?"
                                            title="Hapus Dokumen" 
                                        />
                                    </div>
                                </x-table.td>
                            </x-table.tr>
                        @empty
                            <x-table.empty 
                                colspan="8" 
                                icon="files" 
                                title="Belum ada berkas unduhan" 
                                description="Silakan unggah dokumen regulasi atau SK baru ke sistem."
                            />
                        @endforelse
                    </x-table.tbody>
                </x-table.table>

                @if($unduhanList->hasPages())
                    <x-slot:footer>
                        <div class="px-4 py-3 flex items-center justify-between">
                            {{ $unduhanList->links() }}
                        </div>
                    </x-slot:footer>
                @endif
            </x-table.card>
        </di    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM DOKUMEN UNDUHAN   -->
        <!-- ========================================== -->
        <div class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header 
                :title="$unduhanId ? 'Edit Data Berkas & Regulasi' : 'Unggah Berkas Baru ke Portal'"
                subtitle="Isi detail informasi dokumen, pilih kategori berkas, dan unggah file lampiran resmi."
                :badge="$unduhanId ? 'Mode Edit Dokumen' : 'Dokumen Baru'"
                icon="files"
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
                        {{ $unduhanId ? 'Perbarui Dokumen' : 'Simpan Dokumen' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Metadata & Berkas Upload -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Informasi Utama Dokumen" 
                            subtitle="Judul resmi, klasifikasi kategori, dan deskripsi ringkas."
                            icon="file-text"
                            size="default"
                        >
                            <!-- Judul Dokumen -->
                            <x-form.field label="Judul Dokumen / Nama Regulasi" name="judul_dokumen" :required="true">
                                <x-form.input 
                                    name="judul_dokumen" 
                                    wire:model="judul_dokumen" 
                                    placeholder="Contoh: SK Penetapan Cabang Olahraga FORKAB 2026..." 
                                    size="lg"
                                    icon="file-type"
                                />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Kategori Dokumen -->
                                <x-form.field label="Kategori Dokumen" name="kategori_id" :required="true">
                                    <x-form.select name="kategori_id" wire:model="kategori_id">
                                        @foreach($kategoriList as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <!-- Akses Publikasi -->
                                <x-form.field label="Status Akses Publik" name="status_publik">
                                    <div class="h-[46px] px-4 bg-slate-50/80 border border-slate-200 rounded-2xl flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-700">Tampilkan ke Publik</span>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="statusPublik" wire:model="status_publik" class="sr-only peer">
                                            <div class="w-10 h-5.5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4.5 after:w-4.5 after:transition-all peer-checked:bg-emerald-600"></div>
                                        </label>
                                    </div>
                                </x-form.field>
                            </div>

                            <!-- Deskripsi Singkat -->
                            <x-form.field label="Keterangan / Ringkasan Dokumen (Opsional)" name="deskripsi_singkat">
                                <x-form.textarea 
                                    name="deskripsi_singkat" 
                                    wire:model="deskripsi_singkat" 
                                    placeholder="Tuliskan catatan singkat mengenai isi atau tujuan dokumen ini..."
                                    rows="3"
                                />
                            </x-form.field>
                        </x-form.card>

                        <!-- Upload Card -->
                        <x-form.card 
                            title="Lampiran Berkas File" 
                            subtitle="Format PDF, DOCX, XLSX, atau ZIP (Maksimal 50MB)"
                            icon="upload-cloud"
                            size="default"
                        >
                            <x-form.file-upload 
                                :upload="$uploadBerkas" 
                                :savedPath="$berkas_path" 
                                name="uploadBerkas"
                                inputId="uploadBerkasDokumen"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar"
                                title="Klik atau seret berkas dokumen ke sini"
                                subtitle="PDF, DOCX, XLSX, ZIP (Maks. 50MB)"
                            />
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Format & File Presets -->
                    <div class="lg:col-span-4 space-y-6">
                        <x-form.card 
                            title="Spesifikasi Berkas" 
                            subtitle="Format dan ukuran terdeteksi otomatis."
                            icon="sliders"
                            size="default"
                        >
                            <!-- Badge Preview -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-2xl flex items-center justify-center font-black text-sm uppercase {{ strtoupper($ekstensi_berkas) === 'PDF' ? 'bg-rose-50 text-rose-600 border border-rose-200' : 'bg-blue-50 text-blue-600 border border-blue-200' }}">
                                    <i data-lucide="file-text" class="w-5 h-5"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase {{ strtoupper($ekstensi_berkas) === 'PDF' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $ekstensi_berkas ?: 'PDF' }}
                                        </span>
                                        <span class="text-xs font-bold text-slate-800">{{ $ukuran_berkas ?: '0 MB' }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-0.5 truncate">{{ $berkas_path ? basename($berkas_path) : 'Belum ada file' }}</p>
                                </div>
                            </div>

                            <!-- Ekstensi & Ukuran Fields -->
                            <div class="grid grid-cols-2 gap-3">
                                <x-form.field label="Format" name="ekstensi_berkas" :required="true">
                                    <x-form.input 
                                        name="ekstensi_berkas" 
                                        wire:model="ekstensi_berkas" 
                                        placeholder="PDF" 
                                        class="uppercase font-bold"
                                    />
                                </x-form.field>

                                <x-form.field label="Ukuran" name="ukuran_berkas">
                                    <x-form.input 
                                        name="ukuran_berkas" 
                                        wire:model="ukuran_berkas" 
                                        placeholder="1.5 MB" 
                                    />
                                </x-form.field>
                            </div>
                        </x-form.card>
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
                        variant="emerald" 
                        size="default" 
                        type="submit" 
                        icon="check" 
                        loading-target="simpan"
                    >
                        {{ $unduhanId ? 'Perbarui Dokumen' : 'Simpan ke Repositori' }}
                    </x-form.button>
                </x-form.action-bar>
            </form>
        </div>
    @endif

</div>
