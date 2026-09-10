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
        <!-- VIEW MODE: TABEL DAFTAR SARANA PRASARANA  -->
        <!-- ========================================== -->

        <!-- 1. HEADER & PRIMARY ACTION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                    <span>INFRASTRUKTUR & VENUE</span>
                    <span>•</span>
                    <span class="text-emerald-600">SARANA & PRASARANA</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Sarana & Prasarana Olahraga</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Direktori stadion, GOR, lapangan terbuka, lintasan, dan taman kebugaran masyarakat se-Kabupaten Bandung.</p>
            </div>

            <button 
                type="button" 
                wire:click="bukaFormTambah" 
                class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer self-start sm:self-auto active:scale-95"
            >
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Fasilitas Baru</span>
            </button>
        </div>

        <!-- 2. MINI KPI STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="building-2" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Fasilitas</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalFasilitas }} <span class="text-xs font-bold text-slate-400">Venue</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kondisi Prima (Baik)</p>
                    <p class="text-2xl font-black text-blue-600 mt-0.5">{{ $totalKondisiBaik }} <span class="text-xs font-bold text-slate-400">Siap Pakai</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <i data-lucide="map" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sebaran Wilayah</p>
                    <p class="text-2xl font-black text-purple-600 mt-0.5">{{ $totalKecamatan }} <span class="text-xs font-bold text-slate-400">Kecamatan</span></p>
                </div>
            </div>
        </div>

        <!-- 3. FILTER & SEARCH CONTROLS -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex flex-col lg:flex-row items-center justify-between gap-4">
            <!-- Category Pills -->
            <div class="flex items-center gap-2 w-full lg:w-auto overflow-x-auto pb-2 lg:pb-0 scrollbar-none">
                @foreach(['Semua', 'Stadion', 'Lapangan', 'GOR', 'Kolam Renang', 'Lintasan', 'Taman Olahraga'] as $kategori)
                    <button 
                        type="button"
                        wire:click="$set('kategoriDipilih', '{{ $kategori }}')" 
                        class="px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap cursor-pointer {{ $kategoriDipilih === $kategori ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}"
                    >
                        {{ $kategori }}
                    </button>
                @endforeach
            </div>

            <!-- Search input -->
            <div class="relative w-full lg:w-72">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="cari" 
                    placeholder="Cari nama fasilitas..." 
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
                            <th class="py-4 px-6">Informasi Fasilitas</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Kecamatan</th>
                            <th class="py-4 px-6">Kapasitas</th>
                            <th class="py-4 px-6 text-center">Kondisi</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($saprasList as $item)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <img 
                                            src="{{ $item->foto_url ?: 'https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=400' }}" 
                                            class="w-12 h-12 rounded-2xl object-cover border border-slate-200 shrink-0" 
                                            alt="{{ $item->nama_fasilitas }}"
                                            onerror="this.src='https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=400'"
                                        >
                                        <div>
                                            <h4 class="font-black text-slate-900 text-sm group-hover:text-emerald-600 transition-colors">{{ $item->nama_fasilitas }}</h4>
                                            <span class="text-[11px] text-slate-400 line-clamp-1">{{ $item->alamat_lengkap }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $item->kategori_fasilitas }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-800">
                                    {{ $item->kecamatan->nama_kecamatan ?? '-' }}
                                </td>
                                <td class="py-4 px-6 text-slate-500 font-semibold">
                                    {{ $item->kapasitas ?: '-' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @php
                                        $kondisiClass = match($item->status_kondisi) {
                                            'Baik' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'Perlu Renovasi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            default => 'bg-blue-50 text-blue-700 border-blue-200'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $kondisiClass }}">
                                        {{ $item->status_kondisi }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button 
                                            type="button" 
                                            wire:click="bukaFormEdit('{{ $item->id }}')" 
                                            class="p-2 rounded-xl text-emerald-600 hover:bg-emerald-50 transition-colors cursor-pointer font-bold" 
                                            title="Edit Fasilitas"
                                        >
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>
                                        <button 
                                            type="button" 
                                            wire:click="hapus('{{ $item->id }}')" 
                                            wire:confirm="Yakin ingin menghapus data fasilitas olahraga ini?" 
                                            class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer font-bold" 
                                            title="Hapus Fasilitas"
                                        >
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center bg-white">
                                    <i data-lucide="building" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                    <p class="text-sm font-bold text-slate-600">Belum ada sarana dan prasarana olahraga yang sesuai filter.</p>
                                    <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-emerald-600 text-white font-bold text-xs cursor-pointer">
                                        + Tambah Fasilitas Baru
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                {{ $saprasList->links() }}
            </div>
        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM SARANA PRASARANA  -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Daftar Fasilitas"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR SARANA & PRASARANA</span>
                            <span>•</span>
                            <span class="text-emerald-600">{{ $editId ? 'EDIT FASILITAS' : 'FASILITAS BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $editId ? 'Edit Data Venue / Fasilitas' : 'Registrasi Sarana Prasarana Olahraga' }}
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
                        <span>{{ $editId ? 'Perbarui Fasilitas' : 'Simpan Fasilitas' }}</span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Left: Metadata Form -->
                    <div class="lg:col-span-7 space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Fasilitas / Venue *</label>
                            <input 
                                type="text" 
                                wire:model="nama_fasilitas" 
                                placeholder="Contoh: Stadion Si Jalak Harupat, GOR Soreang..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-emerald-500 focus:outline-none transition-all"
                            >
                            @error('nama_fasilitas') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Fasilitas *</label>
                                <select wire:model="kategori_fasilitas" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-emerald-500 focus:outline-none transition-all">
                                    <option value="Stadion">Stadion</option>
                                    <option value="Lapangan">Lapangan</option>
                                    <option value="GOR">GOR</option>
                                    <option value="Kolam Renang">Kolam Renang</option>
                                    <option value="Lintasan">Lintasan</option>
                                    <option value="Taman Olahraga">Taman Olahraga</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kecamatan Lokasi *</label>
                                <select wire:model="kecamatan_id" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-emerald-500 focus:outline-none transition-all">
                                    @foreach($kecamatanList as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                                @error('kecamatan_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Lengkap *</label>
                            <textarea 
                                wire:model="alamat_lengkap" 
                                rows="3" 
                                placeholder="Jalan, nomor, desa/kelurahan, dan patokan lokasi..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-emerald-500 focus:outline-none transition-all"
                            ></textarea>
                            @error('alamat_lengkap') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kapasitas Penonton / Pengguna</label>
                                <input 
                                    type="text" 
                                    wire:model="kapasitas" 
                                    placeholder="Contoh: 5.000 orang" 
                                    class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-emerald-500 focus:outline-none transition-all"
                                >
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Kondisi Fisik *</label>
                                <select wire:model="status_kondisi" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-emerald-500 focus:outline-none transition-all">
                                    <option value="Baik">Baik (Siap Pakai)</option>
                                    <option value="Perlu Renovasi">Perlu Renovasi</option>
                                    <option value="Dalam Pembangunan">Dalam Pembangunan</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Olahraga Tersedia *</label>
                            <input 
                                type="text" 
                                wire:model="jenis_olahraga_tersedia" 
                                placeholder="Contoh: Senam Bedas, Egrang, Sepakbola, Atletik, Lari..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-emerald-500 focus:outline-none transition-all"
                            >
                            @error('jenis_olahraga_tersedia') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Right: Photo Preview & Presets -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 space-y-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="image" class="w-4 h-4 text-emerald-600"></i>
                                <span>Preview & Foto Venue</span>
                            </h3>

                            <!-- Preview -->
                            <div class="w-full h-56 rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 bg-slate-100 flex items-center justify-center">
                                @if($uploadFoto)
                                    <img src="{{ $uploadFoto->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                                @elseif($foto_url)
                                    @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($foto_url) @endphp
                                    <img src="{{ $tmpUrl }}" class="w-full h-full object-cover" alt="Foto Fasilitas" onerror="this.closest('div').innerHTML='<div class=&quot;text-center&quot;><i class=&quot;text-xs text-slate-400&quot;>Tidak dapat memuat gambar</i></div>'">
                                @else
                                    <div class="text-center">
                                        <i data-lucide="image-off" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-xs text-slate-400">Belum ada foto</p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    File Foto Fasilitas {{ !$saprasId ? '*' : '(opsional)' }}
                                    <span class="normal-case font-normal text-slate-400 ml-1">(jpg/png/webp &mdash; maks. 10MB)</span>
                                </label>
                                <label for="uploadFotoSapras" class="flex items-center gap-3 w-full px-4 py-3 bg-white border-2 border-dashed {{ $uploadFoto ? 'border-emerald-400 bg-emerald-50' : 'border-slate-200 hover:border-emerald-400' }} text-slate-600 rounded-2xl text-xs font-semibold cursor-pointer transition-colors">
                                    <i data-lucide="upload" class="w-5 h-5 {{ $uploadFoto ? 'text-emerald-500' : 'text-emerald-600' }} shrink-0"></i>
                                    <span class="truncate">{{ $uploadFoto ? $uploadFoto->getClientOriginalName() : 'Klik untuk pilih foto fasilitas' }}</span>
                                </label>
                                <input id="uploadFotoSapras" type="file" wire:model="uploadFoto" accept="image/jpeg,image/png,image/webp" class="hidden">
                                @error('uploadFoto') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                                @if($uploadFoto)
                                    <p class="text-[11px] text-emerald-600 font-semibold mt-1">&#10003; {{ round($uploadFoto->getSize() / 1024, 1) }} KB &mdash; siap diunggah ke MinIO</p>
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
                        class="px-8 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editId ? 'Perbarui Fasilitas' : 'Simpan Fasilitas ke Database' }}</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
