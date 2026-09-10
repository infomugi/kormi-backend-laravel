<div class="space-y-4 sm:space-y-6">

    <!-- FLASH NOTIFICATION -->
    @if(session()->has('pesan'))
        <div class="p-3.5 sm:p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xs animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="check" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
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

        <!-- 1. HEADER & PRIMARY ACTION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
            <div>
                <div class="flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5 sm:mb-1">
                    <span>PEMBINAAN & PENGGERAK</span>
                    <span>•</span>
                    <span class="text-indigo-600">DUTA OLAHRAGA MASYARAKAT</span>
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Duta Olahraga Desa & Kecamatan</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5 sm:mt-1">Data kader dan duta penggerak olahraga di 31 Kecamatan dan 280 Desa/Kelurahan.</p>
            </div>

            <button 
                type="button" 
                wire:click="bukaFormTambah" 
                class="inline-flex items-center gap-2 px-4 py-2.5 sm:px-5 sm:py-3 rounded-xl sm:rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer self-start sm:self-auto active:scale-95"
            >
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Tambah Duta Baru</span>
            </button>
        </div>

        <!-- 2. MINI KPI STATS -->
        <div class="grid grid-cols-3 gap-2.5 sm:gap-4">
            <div class="bg-white rounded-2xl sm:rounded-3xl p-3 sm:p-5 border border-slate-200/80 shadow-xs flex items-center gap-2.5 sm:gap-4">
                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-4 h-4 sm:w-6 sm:h-6"></i>
                </div>
                <div>
                    <p class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Duta</p>
                    <p class="text-base sm:text-2xl font-black text-slate-900 mt-0.5">{{ $totalDuta }} <span class="text-[9px] sm:text-xs font-bold text-slate-400">Orang</span></p>
                </div>
            </div>

            <div class="bg-white rounded-2xl sm:rounded-3xl p-3 sm:p-5 border border-slate-200/80 shadow-xs flex items-center gap-2.5 sm:gap-4">
                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="map-pin" class="w-4 h-4 sm:w-6 sm:h-6"></i>
                </div>
                <div>
                    <p class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kecamatan</p>
                    <p class="text-base sm:text-2xl font-black text-emerald-600 mt-0.5">{{ $totalKecamatanTerwakili }} <span class="text-[9px] sm:text-xs font-bold text-slate-400">/ 31</span></p>
                </div>
            </div>

            <div class="bg-white rounded-2xl sm:rounded-3xl p-3 sm:p-5 border border-slate-200/80 shadow-xs flex items-center gap-2.5 sm:gap-4">
                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="calendar" class="w-4 h-4 sm:w-6 sm:h-6"></i>
                </div>
                <div>
                    <p class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tahun 2026</p>
                    <p class="text-base sm:text-2xl font-black text-amber-600 mt-0.5">{{ $dutaTahunIni }} <span class="text-[9px] sm:text-xs font-bold text-slate-400">Kader</span></p>
                </div>
            </div>
        </div>

        <!-- 3. FILTER & SEARCH CONTROLS -->
        <div class="bg-white border border-slate-200/80 p-3 sm:p-4 rounded-2xl sm:rounded-3xl shadow-xs flex flex-col lg:flex-row items-center justify-between gap-3 sm:gap-4">
            <!-- Kecamatan Dropdown Filter -->
            <div class="flex items-center gap-2 sm:gap-3 w-full lg:w-auto">
                <span class="text-xs font-bold text-slate-500 whitespace-nowrap">Wilayah:</span>
                <select 
                    wire:model.live="kecamatanDipilih" 
                    class="w-full sm:w-auto px-3 py-2 sm:px-4 sm:py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl sm:rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="Semua">Semua Kecamatan (31 Wilayah)</option>
                    @foreach($kecamatanList as $kec)
                        <option value="{{ $kec->id }}">Kec. {{ $kec->nama_kecamatan }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Search input -->
            <div class="relative w-full lg:w-72">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="cari" 
                    placeholder="Cari nama duta / desa..." 
                    class="w-full pl-9 pr-3 py-2 sm:pl-10 sm:pr-4 sm:py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl sm:rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                >
            </div>
        </div>

        <!-- 4. DATA TABLE -->
        <div class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600 min-w-[650px]">
                    <thead class="bg-slate-50 text-[10px] uppercase font-black tracking-wider text-slate-400 border-b border-slate-200/80">
                        <tr>
                            <th class="py-3 px-4 sm:py-4 sm:px-6">Nama Lengkap Duta</th>
                            <th class="py-3 px-4 sm:py-4 sm:px-6">Kecamatan</th>
                            <th class="py-3 px-4 sm:py-4 sm:px-6">Desa / Kelurahan</th>
                            <th class="py-3 px-4 sm:py-4 sm:px-6">Kategori</th>
                            <th class="py-3 px-4 sm:py-4 sm:px-6 text-center">Tahun</th>
                            <th class="py-3 px-4 sm:py-4 sm:px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($dutaList as $d)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-3 px-4 sm:py-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center font-black text-xs shrink-0">
                                            {{ strtoupper(substr($d->nama_lengkap, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-black text-slate-900 text-xs sm:text-sm group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $d->nama_lengkap }}</h4>
                                            <span class="text-[10px] sm:text-[11px] text-slate-400 font-medium">ID: {{ substr($d->id, 0, 8) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 sm:py-4 sm:px-6">
                                    <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200 whitespace-nowrap">
                                        {{ $d->kecamatan->nama_kecamatan ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 sm:py-4 sm:px-6 text-slate-700 font-bold whitespace-nowrap">
                                    {{ $d->desaKelurahan->nama_desa_kelurahan ?? 'Tingkat Kecamatan' }}
                                </td>
                                <td class="py-3 px-4 sm:py-4 sm:px-6">
                                    <span class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg text-[10px] sm:text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 whitespace-nowrap">
                                        {{ $d->kategori_duta }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 sm:py-4 sm:px-6 text-center font-black text-slate-900">
                                    {{ $d->tahun_pemilihan }}
                                </td>
                                <td class="py-3 px-4 sm:py-4 sm:px-6 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button 
                                            type="button" 
                                            wire:click="bukaFormEdit('{{ $d->id }}')" 
                                            class="p-1.5 sm:p-2 rounded-xl text-indigo-600 hover:bg-indigo-50 transition-colors cursor-pointer font-bold" 
                                            title="Edit Data Duta"
                                        >
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                                        </button>
                                        <button 
                                            type="button" 
                                            wire:click="hapus('{{ $d->id }}')" 
                                            wire:confirm="Yakin ingin menghapus data duta olahraga ini?" 
                                            class="p-1.5 sm:p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer font-bold" 
                                            title="Hapus Data Duta"
                                        >
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center bg-white">
                                    <i data-lucide="award" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                    <p class="text-sm font-bold text-slate-600">Belum ada data Duta Olahraga yang sesuai filter.</p>
                                    <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-indigo-600 text-white font-bold text-xs cursor-pointer">
                                        + Tambah Duta Olahraga
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-3.5 sm:p-5 border-t border-slate-100 bg-slate-50/50">
                {{ $dutaList->links() }}
            </div>
        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM DUTA OLAHRAGA     -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl p-4 sm:p-8 lg:p-10 shadow-xs space-y-6 sm:space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 pb-4 sm:pb-6 border-b border-slate-100">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-2.5 sm:p-3 rounded-xl sm:rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali"
                    >
                        <i data-lucide="arrow-left" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-1.5 text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR DATA DUTA OLAHRAGA</span>
                            <span>•</span>
                            <span class="text-indigo-600">{{ $dutaId ? 'EDIT DUTA' : 'DUTA BARU' }}</span>
                        </div>
                        <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight">
                            {{ $dutaId ? 'Edit Biodata Duta Olahraga' : 'Registrasi Duta Olahraga' }}
                        </h2>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl sm:rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="button" 
                        wire:click="simpan" 
                        class="px-5 py-2 sm:px-6 sm:py-2.5 rounded-xl sm:rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-1.5 sm:gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $dutaId ? 'Perbarui' : 'Simpan' }}</span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpan" class="space-y-4 sm:space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8 items-start">
                    <!-- Left: Metadata Form -->
                    <div class="lg:col-span-7 space-y-4 sm:space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">Nama Lengkap Duta *</label>
                            <input 
                                type="text" 
                                wire:model="nama_lengkap" 
                                placeholder="Nama lengkap..." 
                                class="w-full px-4 py-2.5 sm:px-5 sm:py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-bold focus:bg-white focus:border-indigo-500 focus:outline-none transition-all"
                            >
                            @error('nama_lengkap') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">Kecamatan *</label>
                                <select wire:model.live="kecamatan_id" class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl sm:rounded-2xl text-xs font-bold focus:bg-white focus:border-indigo-500 focus:outline-none transition-all">
                                    @foreach($kecamatanList as $kec)
                                        <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                                @error('kecamatan_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">Desa / Kelurahan</label>
                                <select wire:model="desa_kelurahan_id" class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl sm:rounded-2xl text-xs font-bold focus:bg-white focus:border-indigo-500 focus:outline-none transition-all">
                                    <option value="">-- Tingkat Kecamatan --</option>
                                    @foreach($desaList as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama_desa_kelurahan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">Kategori Duta *</label>
                                <select wire:model="kategori_duta" class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl sm:rounded-2xl text-xs font-bold focus:bg-white focus:border-indigo-500 focus:outline-none transition-all">
                                    <option value="Duta Olahraga Masyarakat">Duta Olahraga Masyarakat</option>
                                    <option value="Duta Pemuda & Kebugaran">Duta Pemuda & Kebugaran</option>
                                    <option value="Duta Lansia Bugar">Duta Lansia Bugar</option>
                                    <option value="Duta Pelajar Berprestasi">Duta Pelajar Berprestasi</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">Tahun Pemilihan *</label>
                                <input 
                                    type="number" 
                                    wire:model="tahun_pemilihan" 
                                    class="w-full px-4 py-2.5 sm:px-4 sm:py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl sm:rounded-2xl text-xs font-bold focus:bg-white focus:border-indigo-500 focus:outline-none transition-all"
                                    min="2020" 
                                    max="2030"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Right: Foto Upload -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl sm:rounded-3xl p-4 sm:p-6 space-y-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="upload-cloud" class="w-4 h-4 text-indigo-600"></i>
                                <span>Foto Duta ke MinIO</span>
                            </h3>

                            <!-- Preview -->
                            <div class="w-full h-48 rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 bg-slate-100 flex items-center justify-center">
                                @if($uploadFotoDuta)
                                    <img src="{{ $uploadFotoDuta->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                                @elseif($foto_url)
                                    @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($foto_url) @endphp
                                    <img src="{{ $tmpUrl }}" class="w-full h-full object-cover" alt="Foto Duta" onerror="this.closest('div').innerHTML='<div class=&quot;text-center&quot;><p class=&quot;text-xs text-slate-400&quot;>Tidak dapat memuat foto</p></div>'">
                                @else
                                    <div class="text-center">
                                        <i data-lucide="user-x" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-xs text-slate-400">Belum ada foto duta</p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    File Foto {{ !$dutaId ? '*' : '(opsional)' }}
                                    <span class="normal-case font-normal text-slate-400 ml-1">(maks. 5MB)</span>
                                </label>
                                <label for="uploadFotoDuta" class="flex items-center gap-3 w-full px-4 py-3 bg-white border-2 border-dashed {{ $uploadFotoDuta ? 'border-emerald-400 bg-emerald-50' : 'border-slate-200 hover:border-indigo-400' }} text-slate-600 rounded-2xl text-xs font-semibold cursor-pointer transition-colors">
                                    <i data-lucide="upload" class="w-5 h-5 {{ $uploadFotoDuta ? 'text-emerald-500' : 'text-indigo-400' }} shrink-0"></i>
                                    <span class="truncate">{{ $uploadFotoDuta ? $uploadFotoDuta->getClientOriginalName() : 'Pilih foto duta (jpg/png/webp)' }}</span>
                                </label>
                                <input id="uploadFotoDuta" type="file" wire:model="uploadFotoDuta" accept="image/jpeg,image/png,image/webp" class="hidden">
                                @error('uploadFotoDuta') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                                @if($uploadFotoDuta)
                                    <p class="text-[11px] text-emerald-600 font-semibold mt-1">&#10003; {{ round($uploadFotoDuta->getSize() / 1024, 1) }} KB &mdash; siap diunggah</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex items-center justify-end gap-2.5 sm:gap-3 pt-4 sm:pt-6 border-t border-slate-100">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="px-4 py-2.5 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 sm:px-8 sm:py-3 rounded-xl sm:rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-1.5 sm:gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $dutaId ? 'Perbarui Duta' : 'Simpan Duta' }}</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
