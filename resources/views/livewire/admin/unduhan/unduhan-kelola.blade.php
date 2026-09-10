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

        <!-- 1. HEADER & PRIMARY ACTION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                    <span>REPOSITORI PUBLIK</span>
                    <span>•</span>
                    <span class="text-emerald-600">DOKUMEN & REGULASI</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Berkas & Unduhan</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Upload dan kelola regulasi, SK, formulir pendaftaran, juknis, dan materi resmi KORMI Kabupaten Bandung.</p>
            </div>

            <button 
                type="button" 
                wire:click="bukaFormTambah" 
                class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer self-start sm:self-auto active:scale-95"
            >
                <i data-lucide="file-plus" class="w-4 h-4"></i>
                <span>Unggah Dokumen Baru</span>
            </button>
        </div>

        <!-- 2. MINI KPI STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="files" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Dokumen</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalDokumen }} <span class="text-xs font-bold text-slate-400">Berkas</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <i data-lucide="globe" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dokumen Publik</p>
                    <p class="text-2xl font-black text-blue-600 mt-0.5">{{ $totalPublik }} <span class="text-xs font-bold text-slate-400">Tampil</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="download" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Diunduh</p>
                    <p class="text-2xl font-black text-amber-600 mt-0.5">{{ number_format($totalHits) }} <span class="text-xs font-bold text-slate-400">Kali</span></p>
                </div>
            </div>
        </div>

        <!-- 3. FILTER & SEARCH CONTROLS -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex flex-col lg:flex-row items-center justify-between gap-4">
            <!-- Category Pills -->
            <div class="flex items-center gap-2 w-full lg:w-auto overflow-x-auto pb-2 lg:pb-0 scrollbar-none">
                <button 
                    type="button"
                    wire:click="$set('kategoriDipilih', 'Semua')" 
                    class="px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap cursor-pointer {{ $kategoriDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}"
                >
                    Semua Kategori ({{ $totalDokumen }})
                </button>
                @foreach($kategoriList as $k)
                    <button 
                        type="button"
                        wire:click="$set('kategoriDipilih', '{{ $k->id }}')" 
                        class="px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap cursor-pointer {{ $kategoriDipilih === $k->id ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}"
                    >
                        {{ $k->nama_kategori }} ({{ $k->unduhan_count }})
                    </button>
                @endforeach
            </div>

            <!-- Search input -->
            <div class="relative w-full lg:w-72">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="cari" 
                    placeholder="Cari judul berkas..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all"
                >
            </div>
        </div>

        <!-- 4. DATA TABLE -->
        <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-[10px] uppercase font-black tracking-wider text-slate-400 border-b border-slate-200/80">
                        <tr>
                            <th class="py-4 px-6">Informasi Dokumen</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6 text-center">Format</th>
                            <th class="py-4 px-6">Ukuran</th>
                            <th class="py-4 px-6 text-center">Total Unduhan</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($unduhanList as $u)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 font-black text-xs {{ strtoupper($u->ekstensi_berkas) === 'PDF' ? 'bg-rose-50 text-rose-600' : (in_array(strtoupper($u->ekstensi_berkas), ['DOC', 'DOCX']) ? 'bg-blue-50 text-blue-600' : 'bg-emerald-50 text-emerald-600') }}">
                                            <i data-lucide="file-text" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-slate-900 text-sm group-hover:text-emerald-600 transition-colors">{{ $u->judul_dokumen }}</h4>
                                            <span class="text-[11px] text-slate-400 font-medium">Oleh: {{ $u->pengunggah->nama_lengkap ?? 'Admin KORMI' }} • {{ \Carbon\Carbon::parse($u->dibuat_pada)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $u->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-black uppercase {{ strtoupper($u->ekstensi_berkas) === 'PDF' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                        {{ $u->ekstensi_berkas }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-slate-500 font-bold">{{ $u->ukuran_berkas }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center gap-1 font-black text-slate-800 bg-slate-100 px-3 py-1 rounded-xl text-xs">
                                        <i data-lucide="download-cloud" class="w-3.5 h-3.5 text-slate-400"></i>
                                        {{ number_format($u->jumlah_unduhan) }}x
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <button 
                                        type="button"
                                        wire:click="toggleStatusPublik('{{ $u->id }}')" 
                                        class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer {{ $u->status_publik ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}"
                                        title="Klik untuk mengubah status"
                                    >
                                        {{ $u->status_publik ? 'Publik' : 'Privat' }}
                                    </button>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button 
                                            type="button" 
                                            wire:click="bukaFormEdit('{{ $u->id }}')" 
                                            class="p-2 rounded-xl text-emerald-600 hover:bg-emerald-50 transition-colors cursor-pointer font-bold" 
                                            title="Edit Dokumen"
                                        >
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>
                                        <button 
                                            type="button" 
                                            wire:click="hapus('{{ $u->id }}')" 
                                            wire:confirm="Yakin ingin menghapus dokumen ini dari repositori unduhan?" 
                                            class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer font-bold" 
                                            title="Hapus Dokumen"
                                        >
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center bg-white">
                                    <i data-lucide="file-x" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                    <p class="text-sm font-bold text-slate-600">Tidak ada dokumen unduhan yang sesuai pencarian.</p>
                                    <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-emerald-600 text-white font-bold text-xs cursor-pointer">
                                        + Unggah Dokumen Baru
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                {{ $unduhanList->links() }}
            </div>
        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM DOKUMEN UNDUHAN   -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Daftar Dokumen"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR BERKAS UNDUHAN</span>
                            <span>•</span>
                            <span class="text-emerald-600">{{ $unduhanId ? 'EDIT DOKUMEN' : 'DOKUMEN BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $unduhanId ? 'Edit Data Berkas & Regulasi' : 'Unggah Berkas Baru ke Portal' }}
                        </h2>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="button" 
                        wire:click="simpan" 
                        class="px-6 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $unduhanId ? 'Perbarui Dokumen' : 'Simpan Dokumen' }}</span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Left: Metadata Form -->
                    <div class="lg:col-span-7 space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Dokumen / Nama Regulasi *</label>
                            <input 
                                type="text" 
                                wire:model="judul_dokumen" 
                                placeholder="Contoh: SK Penetapan Cabang Olahraga FORKAB 2026..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-emerald-500 focus:outline-none transition-all"
                            >
                            @error('judul_dokumen') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Dokumen *</label>
                                <select wire:model="kategori_id" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-emerald-500 focus:outline-none transition-all">
                                    @foreach($kategoriList as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Upload Berkas *
                                    <span class="normal-case font-normal text-slate-400 ml-1">(pdf, doc, docx, xlsx, ppt &mdash; maks. 20MB)</span>
                                </label>
                                <label for="uploadBerkasUnduhan" class="flex items-center gap-3 w-full px-4 py-3.5 bg-slate-50 border-2 border-dashed {{ $uploadBerkas ? 'border-emerald-400 bg-emerald-50' : 'border-slate-200 hover:border-emerald-400' }} text-slate-700 rounded-2xl text-xs font-bold cursor-pointer transition-all">
                                    <i data-lucide="file-up" class="w-5 h-5 {{ $uploadBerkas ? 'text-emerald-500' : 'text-emerald-600' }} shrink-0"></i>
                                    <span class="truncate">{{ $uploadBerkas ? $uploadBerkas->getClientOriginalName() : 'Klik untuk pilih berkas dokumen' }}</span>
                                </label>
                                <input id="uploadBerkasUnduhan" type="file" wire:model="uploadBerkas" accept=".pdf,.doc,.docx,.xlsx,.xls,.ppt,.pptx" class="hidden">
                                @error('uploadBerkas') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                                @if($uploadBerkas)
                                    <p class="text-[11px] text-emerald-600 font-semibold mt-1.5">&#10003; {{ strtoupper($uploadBerkas->getClientOriginalExtension()) }} &bull; {{ round($uploadBerkas->getSize() / 1024, 1) }} KB &mdash; siap diunggah ke MinIO</p>
                                @elseif($berkas_path)
                                    <p class="text-[11px] text-slate-400 font-mono mt-1.5">Berkas saat ini: {{ Str::limit($berkas_path, 45) }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Visibility Setting Card -->
                        <div class="p-5 rounded-3xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                            <div class="space-y-0.5">
                                <label for="statusPublik" class="text-xs font-black text-slate-900 cursor-pointer">Publikasikan Dokumen</label>
                                <p class="text-xs text-slate-500">Jika aktif, dokumen akan muncul dan dapat diunduh oleh publik di portal resmi.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="statusPublik" wire:model="status_publik" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Right: Format & File Specification Presets -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 space-y-5">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="file-check" class="w-4 h-4 text-emerald-600"></i>
                                <span>Format & Spesifikasi File</span>
                            </h3>

                            <!-- Format badge preview -->
                            <div class="p-4 rounded-2xl bg-white border border-slate-200 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-sm uppercase {{ strtoupper($ekstensi_berkas) === 'PDF' ? 'bg-rose-50 text-rose-600' : 'bg-blue-50 text-blue-600' }}">
                                    <i data-lucide="file-text" class="w-6 h-6"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase {{ strtoupper($ekstensi_berkas) === 'PDF' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $ekstensi_berkas ?: 'PDF' }}
                                        </span>
                                        <span class="text-xs font-bold text-slate-700">{{ $ukuran_berkas ?: '0 MB' }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-1 truncate">{{ $berkas_path ?: 'Belum ditentukan' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ekstensi Format *</label>
                                    <input 
                                        type="text" 
                                        wire:model="ekstensi_berkas" 
                                        placeholder="PDF" 
                                        class="w-full px-4 py-2.5 bg-white border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold uppercase focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    >
                                    @error('ekstensi_berkas') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estimasi Ukuran *</label>
                                    <input 
                                        type="text" 
                                        wire:model="ukuran_berkas" 
                                        placeholder="1.5 MB" 
                                        class="w-full px-4 py-2.5 bg-white border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    >
                                    @error('ukuran_berkas') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Preset Chips -->
                            <div class="pt-2 border-t border-slate-200">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Preset Format Cepat:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <button type="button" wire:click="setFormatPreset('PDF', '1.8 MB')" class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 text-slate-700 font-bold text-[10px] cursor-pointer">PDF (1.8 MB)</button>
                                    <button type="button" wire:click="setFormatPreset('PDF', '4.2 MB')" class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 text-slate-700 font-bold text-[10px] cursor-pointer">PDF Buku (4.2 MB)</button>
                                    <button type="button" wire:click="setFormatPreset('DOCX', '850 KB')" class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 text-slate-700 font-bold text-[10px] cursor-pointer">Word DOCX (850 KB)</button>
                                    <button type="button" wire:click="setFormatPreset('XLSX', '1.2 MB')" class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 text-slate-700 font-bold text-[10px] cursor-pointer">Excel XLSX (1.2 MB)</button>
                                    <button type="button" wire:click="setFormatPreset('ZIP', '15.4 MB')" class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 text-slate-700 font-bold text-[10px] cursor-pointer">Arsip ZIP (15.4 MB)</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                    >
                        Batal & Kembali
                    </button>
                    <button 
                        type="submit" 
                        class="px-8 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $unduhanId ? 'Perbarui Dokumen' : 'Simpan Dokumen ke Repositori' }}</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
