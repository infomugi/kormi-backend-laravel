<div class="space-y-6">

    <!-- FLASH NOTIFICATION -->
    @if(session()->has('pesan'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-900 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xs animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
                <div>
                    <p class="font-extrabold text-emerald-950">Berhasil!</p>
                    <p class="text-xs text-emerald-800 font-medium">{{ session('pesan') }}</p>
                </div>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 p-1.5 rounded-lg transition-colors cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    <!-- Form Top Header Bar -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a 
                href="{{ route('admin.berita') }}" 
                wire:navigate
                class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer shrink-0 flex items-center justify-center"
                title="Kembali ke Daftar Berita"
            >
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                    <span>FORMULIR EDITOR BERITA</span>
                    <span>•</span>
                    <span class="text-indigo-600 font-black">{{ $beritaId ? 'MODE EDIT' : 'BERITA BARU' }}</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                    {{ $beritaId ? 'Edit Naskah & Publikasi Berita' : 'Tulis Publikasi Berita Baru' }}
                </h2>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a 
                href="{{ route('admin.berita') }}" 
                wire:navigate
                class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer inline-flex items-center"
            >
                Batal
            </a>

            <button 
                type="button" 
                wire:click="simpan" 
                wire:loading.attr="disabled"
                class="px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95 disabled:opacity-50"
            >
                <i data-lucide="check" class="w-4 h-4"></i>
                <span wire:loading.remove wire:target="simpan">{{ $beritaId ? 'Perbarui Berita' : 'Simpan & Terbitkan' }}</span>
                <span wire:loading.flex wire:target="simpan" class="items-center gap-2">
                    <span>Menyimpan...</span>
                </span>
            </button>
        </div>
    </div>

    <!-- Form Content Grid (8 cols main + 4 cols sidebar) -->
    <form wire:submit.prevent="simpan" onsubmit="return false;" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- LEFT COLUMN: MAIN CONTENT (8 cols) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Title & Slug Card -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-xs space-y-4">
                <!-- Judul Berita -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Judul Artikel Berita <span class="text-rose-500">*</span></label>
                        <span class="text-[11px] font-bold {{ strlen($judul) > 200 ? 'text-amber-600' : 'text-slate-400' }}">{{ strlen($judul) }} / 255 karakter</span>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="judul" 
                        placeholder="Contoh: KORMI Kabupaten Bandung Siapkan 280 Duta Olahraga Desa..." 
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-base font-extrabold focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-all placeholder:font-normal placeholder:text-slate-400"
                    >
                    @error('judul') <span class="text-xs text-rose-600 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Slug / Permalink Bar -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-500">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="link" class="w-3.5 h-3.5 text-indigo-600"></i>
                            <span>Permalink URL:</span>
                        </span>
                        <button 
                            type="button" 
                            wire:click="generateSlugOtomatis" 
                            class="text-[11px] text-indigo-600 hover:underline font-bold cursor-pointer"
                        >
                            Sinkronkan dari Judul
                        </button>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-slate-400 shrink-0 select-none">/berita/</span>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="slug" 
                            placeholder="slug-url-artikel" 
                            class="flex-1 px-3 py-1.5 bg-white border border-slate-200 text-slate-800 rounded-xl text-xs font-mono font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>
                    @error('slug') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Ringkasan / Sinopsis -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Ringkasan / Sinopsis Singkat <span class="text-rose-500">*</span></label>
                        <span class="text-[11px] font-bold {{ strlen($ringkasan) > 450 ? 'text-amber-600' : 'text-slate-400' }}">{{ strlen($ringkasan) }} / 500 karakter</span>
                    </div>
                    <textarea 
                        wire:model.live.debounce.300ms="ringkasan" 
                        rows="3" 
                        placeholder="Tulis sinopsis 1-2 paragraf padat sebagai cuplikan pengantar pada kartu berita dan media sosial..." 
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-all leading-relaxed placeholder:text-slate-400"
                    ></textarea>
                    @error('ringkasan') <span class="text-xs text-rose-600 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Article Content Body with Tab Switcher -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-xs space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div>
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Naskah Isi Konten Lengkap <span class="text-rose-500">*</span></label>
                        <p class="text-[11px] text-slate-400 mt-0.5">Tulis naskah lengkap berita liputan, kutipan narasumber, dan informasi kegiatan.</p>
                    </div>

                    <!-- Tabs: Editor vs Live Preview -->
                    <div class="flex items-center p-1 bg-slate-100 rounded-2xl border border-slate-200/80 shrink-0">
                        <button 
                            type="button" 
                            wire:click="$set('tabEditor', 'editor')" 
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 {{ $tabEditor === 'editor' ? 'bg-white text-indigo-600 shadow-2xs' : 'text-slate-500 hover:text-slate-800' }}"
                        >
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            <span>Editor Teks</span>
                        </button>
                        <button 
                            type="button" 
                            wire:click="$set('tabEditor', 'preview')" 
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 {{ $tabEditor === 'preview' ? 'bg-white text-indigo-600 shadow-2xs' : 'text-slate-500 hover:text-slate-800' }}"
                        >
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            <span>Pratinjau Langsung</span>
                        </button>
                    </div>
                </div>

                @if($tabEditor === 'editor')
                    <!-- Formatting Shortcut Tools -->
                    <div class="flex items-center gap-1.5 p-2 bg-slate-50 rounded-2xl border border-slate-200/80 text-xs text-slate-600 flex-wrap select-none" x-data="{
                        insertFormat(prefix, suffix = '') {
                            const el = document.getElementById('textareaNaskahBerita');
                            if (!el) return;
                            const start = el.selectionStart;
                            const end = el.selectionEnd;
                            const text = el.value;
                            const sel = text.substring(start, end);
                            const replace = prefix + sel + suffix;
                            el.value = text.substring(0, start) + replace + text.substring(end);
                            el.focus();
                            el.selectionStart = start + prefix.length;
                            el.selectionEnd = end + prefix.length;
                            el.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    }">
                        <button type="button" @click="insertFormat('**', '**')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-bold text-xs cursor-pointer" title="Tebal (Bold)">
                            <span class="font-extrabold">B</span>
                        </button>
                        <button type="button" @click="insertFormat('*', '*')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-serif italic text-xs cursor-pointer" title="Miring (Italic)">
                            <span>I</span>
                        </button>
                        <button type="button" @click="insertFormat('## ', '\n')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-black text-xs cursor-pointer" title="Heading 2">
                            <span>H2</span>
                        </button>
                        <button type="button" @click="insertFormat('### ', '\n')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-black text-xs cursor-pointer" title="Heading 3">
                            <span>H3</span>
                        </button>
                        <button type="button" @click="insertFormat('> ', '\n')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-bold text-xs cursor-pointer" title="Kutipan (Quote)">
                            <span>&ldquo; &rdquo;</span>
                        </button>
                        <button type="button" @click="insertFormat('- ', '\n')" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-bold text-xs cursor-pointer" title="Bullet List">
                            <span>• List</span>
                        </button>
                        <span class="text-[10px] text-slate-400 ml-auto font-medium hidden sm:inline">Mendukung format paragraf & baris baru</span>
                    </div>

                    <!-- Content Textarea -->
                    <div>
                        <textarea 
                            id="textareaNaskahBerita"
                            wire:model="isi_konten" 
                            rows="14" 
                            placeholder="Tulis naskah lengkap berita liputan di sini. Gunakan enter untuk pemisah paragraf..." 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-all leading-relaxed"
                        ></textarea>
                        @error('isi_konten') <span class="text-xs text-rose-600 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Word Count & Reading Time Bar -->
                    @php
                        $wordCount = str_word_count(strip_tags($isi_konten));
                        $charCount = strlen($isi_konten);
                        $estRead = max(1, (int) ceil($wordCount / 200));
                    @endphp
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200/80 flex items-center justify-between text-xs text-slate-500 font-medium">
                        <div class="flex items-center gap-3">
                            <span><b>{{ number_format($wordCount) }}</b> kata</span>
                            <span>•</span>
                            <span><b>{{ number_format($charCount) }}</b> karakter</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-indigo-600 font-bold">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                            <span>Estimasi waktu baca: ~{{ $estRead }} menit</span>
                        </div>
                    </div>
                @else
                    <!-- LIVE PREVIEW TAB -->
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 space-y-6">
                        <div class="space-y-2">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-indigo-100 text-indigo-700">
                                {{ $kategoriList->firstWhere('id', $kategori_id)?->nama_kategori ?? 'Kategori Berita' }}
                            </span>
                            <h1 class="text-2xl font-black text-slate-900 leading-tight">
                                {{ $judul ?: 'Judul Berita Belum Diisi' }}
                            </h1>
                            <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                                <span>Oleh: {{ $penulisList->firstWhere('id', $penulis_id)?->nama_lengkap ?? 'Administrator' }}</span>
                                <span>•</span>
                                <span>{{ $tanggal_publikasi ? \Carbon\Carbon::parse($tanggal_publikasi)->translatedFormat('d F Y H:i') : now()->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>

                        <!-- Image in Preview -->
                        <div class="rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-2xs">
                            @if($uploadGambar)
                                <img src="{{ $uploadGambar->temporaryUrl() }}" class="w-full h-72 object-cover" alt="Preview Gambar">
                            @elseif($gambar_utama)
                                @php $prevUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($gambar_utama) ?? $gambar_utama @endphp
                                <img src="{{ $prevUrl }}" class="w-full h-72 object-cover" alt="Gambar Utama">
                            @else
                                <div class="h-48 bg-slate-100 flex items-center justify-center text-slate-400 text-xs">
                                    <span>(Thumbnail Gambar Utama Belum Diunggah)</span>
                                </div>
                            @endif
                            @if($keterangan_gambar)
                                <p class="p-3 text-[11px] text-slate-500 italic text-center bg-slate-50 border-t border-slate-100">{{ $keterangan_gambar }}</p>
                            @endif
                        </div>

                        <!-- Summary Callout -->
                        @if($ringkasan)
                            <div class="p-4 rounded-2xl bg-indigo-50/70 border-l-4 border-indigo-600 text-slate-700 text-xs sm:text-sm font-semibold leading-relaxed">
                                {{ $ringkasan }}
                            </div>
                        @endif

                        <!-- Body content -->
                        <div class="prose prose-slate max-w-none text-xs sm:text-sm leading-relaxed text-slate-800 space-y-4 whitespace-pre-line">
                            {{ $isi_konten ?: 'Naskah isi konten berita masih kosong...' }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT COLUMN: METADATA, CATEGORY, MEDIA & SEO (4 cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Publishing Settings Card -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="send" class="w-4 h-4 text-indigo-600"></i>
                    <span>Pengaturan Penerbitan</span>
                </h3>

                <!-- Status Publikasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi <span class="text-rose-500">*</span></label>
                    <select wire:model="status_publikasi" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="published">🟢 Published (Tayang Langsung)</option>
                        <option value="draft">🟡 Draft (Draf Tersimpan)</option>
                        <option value="archived">⚪ Archived (Arsip)</option>
                    </select>
                    @error('status_publikasi') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Jadwal Tanggal Terbit -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jadwal Tanggal & Waktu Rilis</label>
                    <input 
                        type="datetime-local" 
                        wire:model="tanggal_publikasi" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                    >
                    @error('tanggal_publikasi') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Penulis / Kontributor -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Penulis / Kontributor Naskah</label>
                    <select wire:model="penulis_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        @foreach($penulisList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_lengkap }} ({{ $p->email }})</option>
                        @endforeach
                    </select>
                    @error('penulis_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Headline / Berita Utama Toggle -->
                <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200/80 flex items-start gap-3">
                    <input 
                        type="checkbox" 
                        id="formUnggulan" 
                        wire:model="status_unggulan" 
                        class="w-4 h-4 mt-0.5 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                    >
                    <label for="formUnggulan" class="cursor-pointer select-none">
                        <span class="block text-xs font-black text-amber-950">Jadikan Berita Utama (Headline)</span>
                        <span class="block text-[11px] text-amber-800 font-medium mt-0.5">Tampilkan sebagai hero slider pada halaman beranda portal publik.</span>
                    </label>
                </div>
            </div>

            <!-- Category Selection Card -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="tag" class="w-4 h-4 text-indigo-600"></i>
                        <span>Kategori Berita</span>
                    </h3>
                    <button 
                        type="button" 
                        wire:click="bukaModalTambahKategori" 
                        class="text-[11px] text-indigo-600 hover:underline font-bold cursor-pointer"
                    >
                        + Kategori Baru
                    </button>
                </div>

                <div>
                    <select wire:model="kategori_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriList as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }} ({{ $k->berita_count }} artikel)</option>
                        @endforeach
                    </select>
                    @error('kategori_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Thumbnail & Media Upload Card -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="image" class="w-4 h-4 text-indigo-600"></i>
                    <span>Thumbnail & Foto Utama <span class="text-rose-500">*</span></span>
                </h3>

                <!-- Image Preview Box -->
                <div class="w-full h-48 rounded-2xl overflow-hidden border-2 border-dashed {{ $uploadGambar ? 'border-emerald-400 bg-emerald-50/20' : 'border-slate-200 bg-slate-100' }} relative flex items-center justify-center group">
                    @if($uploadGambar)
                        <img src="{{ $uploadGambar->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview Gambar Baru">
                        <div class="absolute bottom-2 right-2 bg-emerald-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-xl shadow-xs">
                            Siap Diupload
                        </div>
                    @elseif($gambar_utama)
                        @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($gambar_utama) ?? $gambar_utama @endphp
                        <img src="{{ $tmpUrl }}" class="w-full h-full object-cover" alt="Gambar Utama" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=400'">
                        <div class="absolute bottom-2 right-2 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-xl backdrop-blur-xs">
                            Tersimpan
                        </div>
                    @else
                        <div class="text-center p-4">
                            <div class="w-10 h-10 rounded-2xl bg-slate-200 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                <i data-lucide="image" class="w-5 h-5"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-600">Belum ada gambar utama</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">JPG, PNG, WEBP maks. 5MB</p>
                        </div>
                    @endif
                </div>

                <!-- Upload Button -->
                <div>
                    <label for="uploadGambarBerita" class="flex items-center justify-center gap-2.5 w-full px-4 py-3 bg-slate-50 hover:bg-slate-100 border-2 border-dashed {{ $uploadGambar ? 'border-emerald-400 text-emerald-700 bg-emerald-50/50' : 'border-slate-200 text-slate-600' }} rounded-2xl text-xs font-bold cursor-pointer transition-colors">
                        <i data-lucide="upload-cloud" class="w-4 h-4 text-indigo-600 shrink-0"></i>
                        <span class="truncate">{{ $uploadGambar ? $uploadGambar->getClientOriginalName() : ($beritaId ? 'Ganti File Gambar Utama' : 'Pilih File Gambar Utama') }}</span>
                    </label>
                    <input id="uploadGambarBerita" type="file" wire:model="uploadGambar" accept="image/jpeg,image/png,image/webp" class="hidden">
                    @error('uploadGambar') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                    
                    @if($uploadGambar)
                        <div class="flex items-center justify-between mt-2 text-[11px] text-emerald-700 font-semibold px-1">
                            <span>&#10003; {{ round($uploadGambar->getSize() / 1024, 1) }} KB terpilih</span>
                            <button type="button" wire:click="$set('uploadGambar', null)" class="text-rose-600 hover:underline cursor-pointer">Hapus</button>
                        </div>
                    @endif
                </div>

                <!-- Image Caption -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Keterangan / Caption Gambar</label>
                    <input 
                        type="text" 
                        wire:model="keterangan_gambar" 
                        placeholder="Contoh: Suasana pembukaan kejuaraan di Soreang..." 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-400"
                    >
                    @error('keterangan_gambar') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Live Google SERP Preview Card -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-3">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4 text-indigo-600"></i>
                    <span>Simulasi Pratinjau Google SEO</span>
                </h3>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-1 font-sans">
                    <div class="flex items-center gap-2 text-[11px] text-slate-500">
                        <span class="w-4 h-4 rounded-full bg-indigo-600 text-white text-[9px] flex items-center justify-center font-black">K</span>
                        <span class="truncate">kormi.kabupatenbandung.go.id &rsaquo; berita &rsaquo; {{ $slug ?: 'url-berita' }}</span>
                    </div>
                    <h4 class="text-sm font-bold text-blue-700 hover:underline cursor-pointer line-clamp-1">
                        {{ $judul ?: 'Judul Artikel Berita KORMI' }}
                    </h4>
                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-normal">
                        {{ $ringkasan ?: 'Sinopsis cuplikan berita akan tampil di snippet mesin pencari Google...' }}
                    </p>
                </div>
            </div>

        </div>

        <!-- BOTTOM STICKY ACTION BAR -->
        <div class="col-span-full bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
            <a 
                href="{{ route('admin.berita') }}" 
                wire:navigate
                class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer w-full sm:w-auto inline-flex items-center justify-center"
            >
                Batal & Kembali
            </a>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <button 
                    type="button" 
                    wire:click="simpanDraft" 
                    wire:loading.attr="disabled"
                    class="px-6 py-3 rounded-2xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-extrabold text-xs uppercase tracking-wider transition-all cursor-pointer flex items-center gap-2"
                >
                    <i data-lucide="file-edit" class="w-4 h-4 text-amber-600"></i>
                    <span>Simpan Sebagai Draf</span>
                </button>

                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="px-8 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95 disabled:opacity-50"
                >
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span wire:loading.remove wire:target="simpan">{{ $beritaId ? 'Perbarui Berita' : 'Simpan & Terbitkan' }}</span>
                    <span wire:loading.flex wire:target="simpan" class="items-center gap-2">
                        <span>Menyimpan...</span>
                    </span>
                </button>
            </div>
        </div>

    </form>

    <!-- MODAL TAMBAH KATEGORI BARU -->
    @if($tampilkanModalKategori)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden border border-slate-100 p-6 sm:p-7 space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <i data-lucide="tag" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900">Tambah Kategori Baru</h3>
                            <p class="text-[11px] text-slate-400">Buat klasifikasi berita baru langsung</p>
                        </div>
                    </div>
                    <button type="button" wire:click="tutupModalTambahKategori" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form wire:submit.prevent="simpanKategoriBaru" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori *</label>
                        <input 
                            type="text" 
                            wire:model="kategoriBaruNama" 
                            placeholder="Contoh: Liputan Khusus, Pengda..." 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                        @error('kategoriBaruNama') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Warna Aksen Kategori *</label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                wire:model.live="kategoriBaruWarna" 
                                class="w-12 h-10 rounded-xl border border-slate-200 p-1 cursor-pointer bg-white"
                            >
                            <input 
                                type="text" 
                                wire:model="kategoriBaruWarna" 
                                placeholder="#4f46e5" 
                                class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-mono font-bold uppercase"
                            >
                        </div>
                        @error('kategoriBaruWarna') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button 
                            type="button" 
                            wire:click="tutupModalTambahKategori" 
                            class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer"
                        >
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
