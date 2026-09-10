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
        <!-- VIEW MODE: TABEL & KATALOG GALERI         -->
        <!-- ========================================== -->

        <!-- 1. HEADER & PRIMARY ACTIONS -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                    <span>MEDIA DOKUMENTASI</span>
                    <span>•</span>
                    <span class="text-indigo-600">GALERI & ALBUM</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Katalog Galeri Foto & Album</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola arsip dokumentasi visual kegiatan, event FORKAB, dan inorga KORMI Kabupaten Bandung.</p>
            </div>

            <div class="flex items-center gap-3 self-start sm:self-auto">
                <button 
                    type="button" 
                    wire:click="bukaFormTambahAlbum" 
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-slate-900/10 transition-all cursor-pointer active:scale-95"
                >
                    <i data-lucide="folder-plus" class="w-4 h-4"></i>
                    <span>Buat Album</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bukaFormTambahFoto" 
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer active:scale-95"
                >
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    <span>Unggah Foto</span>
                </button>
            </div>
        </div>

        <!-- 2. MINI KPI STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <i data-lucide="image" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Foto</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalFoto }} <span class="text-xs font-bold text-slate-400">File</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <i data-lucide="folder" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Album</p>
                    <p class="text-2xl font-black text-purple-600 mt-0.5">{{ $totalAlbum }} <span class="text-xs font-bold text-slate-400">Album</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Album Publik</p>
                    <p class="text-2xl font-black text-emerald-600 mt-0.5">{{ $totalAlbumAktif }} <span class="text-xs font-bold text-slate-400">Aktif</span></p>
                </div>
            </div>
        </div>

        <!-- 3. TAB CONTROLS & FILTER -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex flex-col lg:flex-row items-center justify-between gap-4">
            <!-- Tabs (Foto vs Album) -->
            <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl w-full lg:w-auto">
                <button 
                    type="button"
                    wire:click="$set('tabAktif', 'foto')" 
                    class="flex-1 lg:flex-none px-6 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer {{ $tabAktif === 'foto' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}"
                >
                    <span class="flex items-center justify-center gap-2">
                        <i data-lucide="grid" class="w-4 h-4"></i>
                        Foto Dokumentasi ({{ $totalFoto }})
                    </span>
                </button>
                <button 
                    type="button"
                    wire:click="$set('tabAktif', 'album')" 
                    class="flex-1 lg:flex-none px-6 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer {{ $tabAktif === 'album' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}"
                >
                    <span class="flex items-center justify-center gap-2">
                        <i data-lucide="folder-archive" class="w-4 h-4"></i>
                        Daftar Album ({{ $totalAlbum }})
                    </span>
                </button>
            </div>

            <!-- Filter Album & Search Input -->
            <div class="flex items-center gap-3 w-full lg:w-auto">
                @if($tabAktif === 'foto')
                    <select wire:model.live="albumDipilih" class="px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="Semua">Semua Album</option>
                        @foreach($albumList as $a)
                            <option value="{{ $a->id }}">{{ $a->judul_album }} ({{ $a->foto_count }})</option>
                        @endforeach
                    </select>
                @endif

                <div class="relative flex-1 lg:w-72">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="{{ $tabAktif === 'foto' ? 'Cari judul foto...' : 'Cari album / lokasi...' }}" 
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                    >
                </div>
            </div>
        </div>

        <!-- 4. CONTENT GRID (TAB 1: FOTO DOKUMENTASI) -->
        @if($tabAktif === 'foto')
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($fotoList as $foto)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all overflow-hidden flex flex-col justify-between group">
                        <!-- Image Container -->
                        <div class="relative h-48 bg-slate-100 overflow-hidden">
                            <img 
                                src="{{ $foto->gambar_url ?: 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=400' }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                alt="{{ $foto->judul_foto }}"
                                onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=400'"
                            >
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-900/80 text-white backdrop-blur-xs">
                                    {{ $foto->album->judul_album ?? 'Umum' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Info -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-black text-slate-900 text-sm line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $foto->judul_foto }}</h3>
                                @if($foto->deskripsi)
                                    <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $foto->deskripsi }}</p>
                                @endif
                            </div>

                            <div class="flex items-center justify-between pt-4 mt-4 border-t border-slate-100 text-xs">
                                <span class="text-[10px] font-bold text-slate-400">Urutan: #{{ $foto->urutan }}</span>
                                <div class="flex items-center gap-1.5">
                                    <button 
                                        type="button" 
                                        wire:click="bukaFormEditFoto('{{ $foto->id }}')" 
                                        class="p-2 rounded-xl text-indigo-600 hover:bg-indigo-50 transition-colors cursor-pointer font-bold"
                                        title="Edit Foto"
                                    >
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <button 
                                        type="button" 
                                        wire:click="hapusFoto('{{ $foto->id }}')" 
                                        wire:confirm="Yakin ingin menghapus foto dokumentasi ini?"
                                        class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                                        title="Hapus Foto"
                                    >
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                        <i data-lucide="image" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                        <p class="text-sm font-bold text-slate-600">Belum ada foto dokumentasi yang sesuai.</p>
                        <button type="button" wire:click="bukaFormTambahFoto" class="mt-4 px-5 py-2.5 rounded-2xl bg-indigo-600 text-white font-bold text-xs cursor-pointer">
                            + Unggah Foto Sekarang
                        </button>
                    </div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $fotoList->links() }}
            </div>
        @else
            <!-- 5. CONTENT GRID (TAB 2: DAFTAR ALBUM) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($daftarAlbum as $album)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-6 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $album->status_tampil ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $album->status_tampil ? 'Publik' : 'Disembunyikan' }}
                                </span>
                                <span class="text-xs font-bold text-slate-400 flex items-center gap-1.5">
                                    <i data-lucide="image" class="w-3.5 h-3.5"></i>
                                    {{ $album->foto_count }} Foto
                                </span>
                            </div>

                            <h3 class="text-base font-black text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $album->judul_album }}</h3>
                            
                            <div class="mt-2 space-y-1 text-xs text-slate-500 font-medium">
                                <p class="flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                    <span>{{ \Carbon\Carbon::parse($album->tanggal_kegiatan)->format('d F Y') }}</span>
                                </p>
                                @if($album->lokasi)
                                    <p class="flex items-center gap-1.5">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                        <span>{{ $album->lokasi }}</span>
                                    </p>
                                @endif
                            </div>

                            @if($album->deskripsi)
                                <p class="text-xs text-slate-600 line-clamp-2 mt-3 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                                    {{ $album->deskripsi }}
                                </p>
                            @endif
                        </div>

                        <div class="pt-4 mt-6 border-t border-slate-100 flex items-center justify-between">
                            <button 
                                type="button" 
                                wire:click="$set('albumDipilih', '{{ $album->id }}'); $set('tabAktif', 'foto');" 
                                class="text-xs font-bold text-indigo-600 hover:underline flex items-center gap-1 cursor-pointer"
                            >
                                <span>Buka Foto</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </button>

                            <div class="flex items-center gap-1.5">
                                <button 
                                    type="button" 
                                    wire:click="bukaFormEditAlbum('{{ $album->id }}')" 
                                    class="p-2 rounded-xl text-indigo-600 hover:bg-indigo-50 font-bold text-xs transition-colors cursor-pointer"
                                    title="Edit Album"
                                >
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="hapusAlbum('{{ $album->id }}')" 
                                    wire:confirm="Yakin ingin menghapus album ini beserta seluruh fotonya?"
                                    class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 font-bold text-xs transition-colors cursor-pointer"
                                    title="Hapus Album"
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                        <i data-lucide="folder-archive" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                        <p class="text-sm font-bold text-slate-600">Belum ada album kegiatan ditemukan.</p>
                        <button type="button" wire:click="bukaFormTambahAlbum" class="mt-4 px-5 py-2.5 rounded-2xl bg-slate-900 text-white font-bold text-xs cursor-pointer">
                            + Buat Album Sekarang
                        </button>
                    </div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $daftarAlbum->links() }}
            </div>
        @endif

    @elseif($mode === 'form_foto')
        <!-- ========================================== -->
        <!-- VIEW MODE: FULL IN-PAGE PHOTO FORM         -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Back Button -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Galeri"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR FOTO DOKUMENTASI</span>
                            <span>•</span>
                            <span class="text-indigo-600">{{ $editFotoId ? 'EDIT FOTO' : 'FOTO BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $editFotoId ? 'Edit Rincian Foto Galeri' : 'Unggah Foto Dokumentasi Baru' }}
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
                        wire:click="simpanFoto" 
                        class="px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editFotoId ? 'Perbarui Foto' : 'Simpan Foto' }}</span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpanFoto" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Left: Metadata Form -->
                    <div class="lg:col-span-7 space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Album Kegiatan *</label>
                            <select wire:model="album_id" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-indigo-500 focus:outline-none transition-all">
                                @foreach($albumList as $a)
                                    <option value="{{ $a->id }}">{{ $a->judul_album }}</option>
                                @endforeach
                            </select>
                            @error('album_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Foto / Keterangan Singkat *</label>
                            <input 
                                type="text" 
                                wire:model="judul_foto" 
                                placeholder="Contoh: Pembukaan FORKAB Kabupaten Bandung 2026..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-indigo-500 focus:outline-none transition-all"
                            >
                            @error('judul_foto') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tampilan Grid</label>
                                <select wire:model="tipe_grid" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:border-indigo-500 focus:outline-none">
                                    <option value="normal">Ukuran Normal (1x1)</option>
                                    <option value="col-span-2">Lebar (2x1)</option>
                                    <option value="col-span-2 row-span-2">Kotak Besar (2x2)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil *</label>
                                <input 
                                    type="number" 
                                    wire:model="urutan_foto" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:border-indigo-500 focus:outline-none" 
                                    min="1"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Tambahan</label>
                            <textarea 
                                wire:model="deskripsi_foto" 
                                rows="4" 
                                placeholder="Catatan atau deskripsi dokumentasi..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-indigo-500 focus:outline-none transition-all leading-relaxed"
                            ></textarea>
                        </div>
                    </div>

                    <!-- Right: Photo Upload -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 space-y-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="upload-cloud" class="w-4 h-4 text-indigo-600"></i>
                                <span>Upload Foto ke MinIO</span>
                            </h3>

                            <!-- Preview -->
                            <div class="w-full h-56 rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 bg-slate-100 flex items-center justify-center">
                                @if($uploadFoto)
                                    <img src="{{ $uploadFoto->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                                @elseif($gambar_url)
                                    @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($gambar_url) @endphp
                                    <img src="{{ $tmpUrl }}" class="w-full h-full object-cover" alt="Foto">
                                @else
                                    <div class="text-center">
                                        <i data-lucide="image-off" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-xs text-slate-400">Belum ada foto</p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    File Foto {{ !$editFotoId ? '*' : '(opsional, untuk ganti foto)' }}
                                    <span class="normal-case font-normal text-slate-400 ml-1">(maks. 10MB)</span>
                                </label>
                                <label for="uploadFotoGaleri" class="flex items-center gap-3 w-full px-4 py-3 bg-white border-2 border-dashed {{ $uploadFoto ? 'border-emerald-400 bg-emerald-50' : 'border-slate-200 hover:border-indigo-400' }} text-slate-600 rounded-2xl text-xs font-semibold cursor-pointer transition-colors">
                                    <i data-lucide="upload" class="w-5 h-5 {{ $uploadFoto ? 'text-emerald-500' : 'text-indigo-400' }} shrink-0"></i>
                                    <span class="truncate">{{ $uploadFoto ? $uploadFoto->getClientOriginalName() : 'Klik untuk pilih foto (jpg/png/webp)' }}</span>
                                </label>
                                <input id="uploadFotoGaleri" type="file" wire:model="uploadFoto" accept="image/jpeg,image/png,image/webp" class="hidden">
                                @error('uploadFoto') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                                @if($uploadFoto)
                                    <p class="text-[11px] text-emerald-600 font-semibold mt-1">&#10003; {{ round($uploadFoto->getSize() / 1024, 1) }} KB &mdash; siap diunggah</p>
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
                        class="px-8 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editFotoId ? 'Perbarui Foto' : 'Simpan Foto ke Galeri' }}</span>
                    </button>
                </div>
            </form>
        </div>

    @elseif($mode === 'form_album')
        <!-- ========================================== -->
        <!-- VIEW MODE: FULL IN-PAGE ALBUM FORM         -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Back Button -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Galeri"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR ALBUM KEGIATAN</span>
                            <span>•</span>
                            <span class="text-slate-900">{{ $editAlbumId ? 'EDIT ALBUM' : 'ALBUM BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $editAlbumId ? 'Edit Rincian Album Kegiatan' : 'Buat Album Kegiatan Baru' }}
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
                        wire:click="simpanAlbum" 
                        class="px-6 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-slate-900/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editAlbumId ? 'Perbarui Album' : 'Simpan Album Baru' }}</span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpanAlbum" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Left: Metadata Form -->
                    <div class="lg:col-span-7 space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama / Judul Album *</label>
                            <input 
                                type="text" 
                                wire:model="judul_album" 
                                placeholder="Contoh: Festival Olahraga Rekreasi Kabupaten (FORKAB) 2026..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-slate-900 focus:outline-none transition-all"
                            >
                            @error('judul_album') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Pelaksanaan</label>
                                <input 
                                    type="date" 
                                    wire:model="tanggal_kegiatan" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:border-slate-900 focus:outline-none"
                                >
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi / Tempat Acara</label>
                                <input 
                                    type="text" 
                                    wire:model="lokasi" 
                                    placeholder="Contoh: Stadion Si Jalak Harupat" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:border-slate-900 focus:outline-none"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Ringkas Album</label>
                            <textarea 
                                wire:model="deskripsi_album" 
                                rows="4" 
                                placeholder="Keterangan singkat seputar pelaksanaan event dokumentasi..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-slate-900 focus:outline-none transition-all leading-relaxed"
                            ></textarea>
                        </div>

                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" id="albumTampil" wire:model="status_tampil" class="w-4 h-4 rounded text-slate-900 focus:ring-slate-900">
                            <label for="albumTampil" class="text-xs text-slate-700 cursor-pointer font-bold select-none">Tampilkan Album di Portal Publik</label>
                        </div>
                    </div>

                    <!-- Right: Cover Upload -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 space-y-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="upload-cloud" class="w-4 h-4 text-slate-900"></i>
                                <span>Upload Sampul Album ke MinIO</span>
                            </h3>

                            <!-- Preview -->
                            <div class="w-full h-56 rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 bg-slate-100 flex items-center justify-center">
                                @if($uploadSampul)
                                    <img src="{{ $uploadSampul->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview Sampul">
                                @elseif($gambar_sampul)
                                    @php $tmpSampul = app(\App\Services\StorageService::class)->getTemporaryUrl($gambar_sampul) @endphp
                                    <img src="{{ $tmpSampul }}" class="w-full h-full object-cover" alt="Sampul">
                                @else
                                    <div class="text-center">
                                        <i data-lucide="image-off" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-xs text-slate-400">Belum ada sampul</p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    File Sampul Album {{ !$editAlbumId ? '*' : '(opsional)' }}
                                    <span class="normal-case font-normal text-slate-400 ml-1">(maks. 10MB)</span>
                                </label>
                                <label for="uploadSampulAlbum" class="flex items-center gap-3 w-full px-4 py-3 bg-white border-2 border-dashed {{ $uploadSampul ? 'border-emerald-400 bg-emerald-50' : 'border-slate-200 hover:border-slate-800' }} text-slate-600 rounded-2xl text-xs font-semibold cursor-pointer transition-colors">
                                    <i data-lucide="upload" class="w-5 h-5 {{ $uploadSampul ? 'text-emerald-500' : 'text-slate-500' }} shrink-0"></i>
                                    <span class="truncate">{{ $uploadSampul ? $uploadSampul->getClientOriginalName() : 'Klik untuk pilih gambar sampul' }}</span>
                                </label>
                                <input id="uploadSampulAlbum" type="file" wire:model="uploadSampul" accept="image/jpeg,image/png,image/webp" class="hidden">
                                @error('uploadSampul') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                                @if($uploadSampul)
                                    <p class="text-[11px] text-emerald-600 font-semibold mt-1">&#10003; {{ round($uploadSampul->getSize() / 1024, 1) }} KB &mdash; siap diunggah</p>
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
                        class="px-8 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-slate-900/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editAlbumId ? 'Perbarui Album' : 'Simpan Album Baru' }}</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
