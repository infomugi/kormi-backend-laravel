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
        <!-- VIEW MODE: TABEL & KATALOG APMO            -->
        <!-- ========================================== -->

        <!-- 1. HEADER & PRIMARY ACTIONS -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                    <span>ANUGERAH & APRESIASI</span>
                    <span>•</span>
                    <span class="text-amber-600">APMO KORMI</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Anugerah Penggerak Olahraga (APMO)</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Penganugerahan tahunan kepada tokoh, inorga, penggerak desa, dan pegiat olahraga masyarakat berprestasi di Kabupaten Bandung.</p>
            </div>

            <div class="flex items-center gap-3 self-start sm:self-auto">
                <button 
                    type="button" 
                    wire:click="bukaFormEdisiTambah" 
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-slate-900/10 transition-all cursor-pointer active:scale-95"
                >
                    <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                    <span>Buat Edisi</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bukaFormPenerimaTambah" 
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 transition-all cursor-pointer active:scale-95"
                >
                    <i data-lucide="trophy" class="w-4 h-4"></i>
                    <span>Tambah Penerima</span>
                </button>
            </div>
        </div>

        <!-- 2. MINI KPI STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Penerima</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalPenerima }} <span class="text-xs font-bold text-slate-400">Tokoh / Inorga</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <i data-lucide="calendar" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Edisi Penganugerahan</p>
                    <p class="text-2xl font-black text-indigo-600 mt-0.5">{{ $totalEdisi }} <span class="text-xs font-bold text-slate-400">Tahun</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="sparkles" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Edisi Terbaru</p>
                    <p class="text-2xl font-black text-emerald-600 mt-0.5">2026 <span class="text-xs font-bold text-slate-400">Bedas Juara</span></p>
                </div>
            </div>
        </div>

        <!-- 3. TAB CONTROLS & FILTER -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex flex-col lg:flex-row items-center justify-between gap-4">
            <!-- Tabs (Penerima vs Edisi) -->
            <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl w-full lg:w-auto">
                <button 
                    type="button"
                    wire:click="$set('tabAktif', 'penerima')" 
                    class="flex-1 lg:flex-none px-6 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer {{ $tabAktif === 'penerima' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}"
                >
                    <span class="flex items-center justify-center gap-2">
                        <i data-lucide="trophy" class="w-4 h-4"></i>
                        Penerima Anugerah ({{ $totalPenerima }})
                    </span>
                </button>
                <button 
                    type="button"
                    wire:click="$set('tabAktif', 'edisi')" 
                    class="flex-1 lg:flex-none px-6 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer {{ $tabAktif === 'edisi' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}"
                >
                    <span class="flex items-center justify-center gap-2">
                        <i data-lucide="calendar-range" class="w-4 h-4"></i>
                        Edisi & Tema ({{ $totalEdisi }})
                    </span>
                </button>
            </div>

            <!-- Filter Tahun & Search Input -->
            <div class="flex items-center gap-3 w-full lg:w-auto">
                @if($tabAktif === 'penerima')
                    <select wire:model.live="tahunDipilih" class="px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="Semua">Semua Tahun</option>
                        @foreach($semuaEdisi as $ed)
                            <option value="{{ $ed->tahun }}">Tahun {{ $ed->tahun }}</option>
                        @endforeach
                    </select>
                @endif

                <div class="relative flex-1 lg:w-72">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="{{ $tabAktif === 'penerima' ? 'Cari nama / kategori...' : 'Cari tahun / tema...' }}" 
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition-all"
                    >
                </div>
            </div>
        </div>

        <!-- 4. CONTENT (TAB 1: PENERIMA ANUGERAH) -->
        @if($tabAktif === 'penerima')
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($daftarPenerima as $penerima)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-6 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $penerima->kategori_penghargaan }}
                                </span>
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black bg-slate-900 text-white">
                                    {{ $penerima->tahun->tahun ?? '2026' }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3.5 mb-3">
                                <img 
                                    src="{{ $penerima->foto_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200' }}" 
                                    class="w-12 h-12 rounded-2xl object-cover border border-slate-200 shrink-0" 
                                    alt="{{ $penerima->nama_penerima }}"
                                    onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200'"
                                >
                                <div>
                                    <h3 class="text-sm font-black text-slate-900 group-hover:text-amber-600 transition-colors line-clamp-1">{{ $penerima->nama_penerima }}</h3>
                                    <span class="text-[11px] text-slate-400 font-medium line-clamp-1">{{ $penerima->asal_lembaga_wilayah ?: 'Kabupaten Bandung' }}</span>
                                </div>
                            </div>

                            <p class="text-xs text-slate-600 line-clamp-3 bg-slate-50 p-3.5 rounded-2xl border border-slate-100 leading-relaxed">
                                {{ $penerima->deskripsi_capaian }}
                            </p>
                        </div>

                        <div class="pt-4 mt-6 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-400">Urutan: #{{ $penerima->urutan }}</span>

                            <div class="flex items-center gap-1.5">
                                <button 
                                    type="button" 
                                    wire:click="bukaFormPenerimaEdit('{{ $penerima->id }}')" 
                                    class="p-2 rounded-xl text-amber-600 hover:bg-amber-50 font-bold text-xs transition-colors cursor-pointer"
                                    title="Edit Penerima"
                                >
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="hapusPenerima('{{ $penerima->id }}')" 
                                    wire:confirm="Yakin ingin menghapus data penerima anugerah APMO ini?"
                                    class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 font-bold text-xs transition-colors cursor-pointer"
                                    title="Hapus Penerima"
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                        <i data-lucide="award" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                        <p class="text-sm font-bold text-slate-600">Belum ada penerima anugerah yang sesuai filter.</p>
                        <button type="button" wire:click="bukaFormPenerimaTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-amber-600 text-white font-bold text-xs cursor-pointer">
                            + Tambah Penerima Anugerah
                        </button>
                    </div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $daftarPenerima->links() }}
            </div>

        @else
            <!-- 5. CONTENT (TAB 2: EDISI TAHUN) -->
            <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-[10px] uppercase font-black tracking-wider text-slate-400 border-b border-slate-200/80">
                            <tr>
                                <th class="py-4 px-6">Tahun Edisi</th>
                                <th class="py-4 px-6">Tema Acara</th>
                                <th class="py-4 px-6">Tanggal Penganugerahan</th>
                                <th class="py-4 px-6">Tempat / Venue</th>
                                <th class="py-4 px-6 text-center">Penerima</th>
                                <th class="py-4 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($daftarEdisi as $edisi)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="py-4 px-6">
                                        <span class="font-black text-slate-900 text-base bg-amber-50 text-amber-800 border border-amber-200 px-3.5 py-1.5 rounded-2xl inline-block">
                                            {{ $edisi->tahun }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 font-bold text-slate-900">
                                        {{ $edisi->tema_acara ?: '-' }}
                                    </td>
                                    <td class="py-4 px-6 text-slate-700 font-semibold">
                                        {{ $edisi->tanggal_penganugerahan ? \Carbon\Carbon::parse($edisi->tanggal_penganugerahan)->format('d F Y') : '-' }}
                                    </td>
                                    <td class="py-4 px-6 text-slate-500">
                                        {{ $edisi->tempat_acara ?: '-' }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="font-black text-slate-800 bg-slate-100 px-3 py-1 rounded-xl text-xs">
                                            {{ $edisi->penerima_count }} Tokoh
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button 
                                                type="button" 
                                                wire:click="bukaFormEdisiEdit('{{ $edisi->id }}')" 
                                                class="p-2 rounded-xl text-amber-600 hover:bg-amber-50 font-bold text-xs transition-colors cursor-pointer"
                                                title="Edit Edisi"
                                            >
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </button>
                                            <button 
                                                type="button" 
                                                wire:click="hapusEdisi('{{ $edisi->id }}')" 
                                                wire:confirm="Yakin ingin menghapus edisi APMO ini beserta seluruh data penerimanya?"
                                                class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 font-bold text-xs transition-colors cursor-pointer"
                                                title="Hapus Edisi"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-16 text-center bg-white">
                                        <i data-lucide="calendar-x" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-sm font-bold text-slate-600">Belum ada edisi tahunan APMO yang terdaftar.</p>
                                        <button type="button" wire:click="bukaFormEdisiTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-slate-900 text-white font-bold text-xs cursor-pointer">
                                            + Buat Edisi Tahun Baru
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                    {{ $daftarEdisi->links() }}
                </div>
            </div>
        @endif

    @elseif($mode === 'form_penerima')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM PENERIMA APMO      -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Katalog APMO"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR PENERIMA ANUGERAH</span>
                            <span>•</span>
                            <span class="text-amber-600">{{ $editPenerimaId ? 'EDIT PENERIMA' : 'PENERIMA BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $editPenerimaId ? 'Edit Biodata Penerima APMO' : 'Registrasi Penerima Anugerah Penggerak Olahraga' }}
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
                        wire:click="simpanPenerima" 
                        class="px-6 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editPenerimaId ? 'Perbarui Data' : 'Simpan Penerima' }}</span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpanPenerima" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Left: Metadata Form -->
                    <div class="lg:col-span-7 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Edisi Tahun APMO *</label>
                                <select wire:model="apmo_tahun_id" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all">
                                    @foreach($semuaEdisi as $ed)
                                        <option value="{{ $ed->id }}">Tahun {{ $ed->tahun }} - {{ $ed->tema_acara ?: 'APMO' }}</option>
                                    @endforeach
                                </select>
                                @error('apmo_tahun_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Anugerah *</label>
                                <select wire:model="kategori_penghargaan" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all">
                                    <option value="Tokoh Olahraga Rekreasi">Tokoh Olahraga Rekreasi</option>
                                    <option value="Penggerak Olahraga Desa">Penggerak Olahraga Desa</option>
                                    <option value="Inorga Teraktif & Berprestasi">Inorga Teraktif & Berprestasi</option>
                                    <option value="Pelatih / Instruktur Berdedikasi">Pelatih / Instruktur Berdedikasi</option>
                                    <option value="Tokoh Pelestari Olahraga Tradisional">Tokoh Pelestari Olahraga Tradisional</option>
                                    <option value="Mitra Kerja Pendukung KORMI">Mitra Kerja Pendukung KORMI</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Penerima / Nama Organisasi *</label>
                            <input 
                                type="text" 
                                wire:model="nama_penerima" 
                                placeholder="Contoh: Dr. H. Dadang Supriatna, S.Ip., M.Si..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                            >
                            @error('nama_penerima') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Asal Lembaga / Wilayah Kecamatan</label>
                                <input 
                                    type="text" 
                                    wire:model="asal_lembaga_wilayah" 
                                    placeholder="Contoh: Kecamatan Soreang / Paguyuban Egrang..." 
                                    class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                                >
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil *</label>
                                <input 
                                    type="number" 
                                    wire:model="urutan" 
                                    class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                                    min="1"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Capaian & Alasan Penganugerahan *</label>
                            <textarea 
                                wire:model="deskripsi_capaian" 
                                rows="4" 
                                placeholder="Uraikan dedikasi, kontribusi, dan capaian luar biasa yang diraih..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-amber-500 focus:outline-none transition-all leading-relaxed"
                            ></textarea>
                            @error('deskripsi_capaian') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Right: Photo Upload -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 space-y-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="upload-cloud" class="w-4 h-4 text-amber-600"></i>
                                <span>Foto Tokoh ke MinIO</span>
                            </h3>

                            <!-- Preview -->
                            <div class="w-full h-56 rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 bg-slate-100 flex items-center justify-center">
                                @if($uploadFotoPenerima)
                                    <img src="{{ $uploadFotoPenerima->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                                @elseif($foto_url)
                                    @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($foto_url) @endphp
                                    <img src="{{ $tmpUrl }}" class="w-full h-full object-cover rounded-2xl" alt="Foto Penerima" onerror="this.closest('div').innerHTML='<div class=&quot;text-center&quot;><p class=&quot;text-xs text-slate-400&quot;>Tidak dapat memuat foto</p></div>'">
                                @else
                                    <div class="text-center">
                                        <i data-lucide="user-x" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-xs text-slate-400">Belum ada foto</p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    File Foto Penerima {{ !$editPenerimaId ? '*' : '(opsional)' }}
                                    <span class="normal-case font-normal text-slate-400 ml-1">(jpg/png/webp &mdash; maks. 5MB)</span>
                                </label>
                                <label for="uploadFotoApmo" class="flex items-center gap-3 w-full px-4 py-3 bg-white border-2 border-dashed {{ $uploadFotoPenerima ? 'border-emerald-400 bg-emerald-50' : 'border-slate-200 hover:border-amber-400' }} text-slate-600 rounded-2xl text-xs font-semibold cursor-pointer transition-colors">
                                    <i data-lucide="upload" class="w-5 h-5 {{ $uploadFotoPenerima ? 'text-emerald-500' : 'text-amber-500' }} shrink-0"></i>
                                    <span class="truncate">{{ $uploadFotoPenerima ? $uploadFotoPenerima->getClientOriginalName() : 'Klik untuk pilih foto penerima' }}</span>
                                </label>
                                <input id="uploadFotoApmo" type="file" wire:model="uploadFotoPenerima" accept="image/jpeg,image/png,image/webp" class="hidden">
                                @error('uploadFotoPenerima') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                                @if($uploadFotoPenerima)
                                    <p class="text-[11px] text-emerald-600 font-semibold mt-1">&#10003; {{ round($uploadFotoPenerima->getSize() / 1024, 1) }} KB &mdash; siap diunggah ke MinIO</p>
                                @endif
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
                        class="px-8 py-3 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editPenerimaId ? 'Perbarui Data Penerima' : 'Simpan Penerima ke APMO' }}</span>
                    </button>
                </div>
            </form>
        </div>

    @elseif($mode === 'form_edisi')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM EDISI APMO         -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Katalog APMO"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR EDISI TAHUNAN</span>
                            <span>•</span>
                            <span class="text-amber-600">{{ $editEdisiId ? 'EDIT EDISI' : 'EDISI BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $editEdisiId ? 'Edit Rincian Edisi APMO' : 'Buat Edisi Tahunan APMO Baru' }}
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
                        wire:click="simpanEdisi" 
                        class="px-6 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editEdisiId ? 'Perbarui Edisi' : 'Simpan Edisi APMO' }}</span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpanEdisi" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun Penganugerahan *</label>
                        <input 
                            type="number" 
                            wire:model="tahun" 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                            min="2000" 
                            max="2100"
                        >
                        @error('tahun') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tema Acara / Slogan</label>
                        <input 
                            type="text" 
                            wire:model="tema_acara" 
                            placeholder="Contoh: Olahraga Rekreasi untuk Indonesia Bugar 2026..." 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Pelaksanaan Acara</label>
                        <input 
                            type="date" 
                            wire:model="tanggal_penganugerahan" 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tempat / Venue Acara</label>
                        <input 
                            type="text" 
                            wire:model="tempat_acara" 
                            placeholder="Contoh: Gedung Budaya Sabilulungan Soreang..." 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan / Deskripsi Edisi</label>
                    <textarea 
                        wire:model="deskripsi" 
                        rows="3" 
                        placeholder="Rangkuman atau catatan penyelenggaraan APMO..." 
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                    ></textarea>
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
                        class="px-8 py-3 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editEdisiId ? 'Perbarui Edisi' : 'Simpan Edisi APMO' }}</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
