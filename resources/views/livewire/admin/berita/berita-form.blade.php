<div class="space-y-3.5 sm:space-y-5">

    <!-- 1. TOP HEADER BANNER (Ultra Pro & Compact) -->
    <div class="bg-gradient-to-r from-emerald-950 via-teal-950 to-slate-900 px-4 py-3 sm:px-6 sm:py-4 rounded-xl sm:rounded-2xl text-white shadow-md relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-emerald-800/40">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 flex items-center gap-3 min-w-0">
            <a 
                href="{{ route('admin.berita') }}" 
                wire:navigate
                class="w-8.5 h-8.5 sm:w-9.5 sm:h-9.5 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all cursor-pointer shrink-0 border border-white/15 active:scale-95 shadow-2xs"
                title="Kembali ke Daftar Berita"
            >
                <i data-lucide="arrow-left" class="w-4 h-4 sm:w-4.5 sm:h-4.5"></i>
            </a>
            <div class="min-w-0">
                <div class="flex items-center gap-1.5 text-[9px] sm:text-[10px] font-black text-emerald-300 uppercase tracking-widest leading-none mb-1">
                    <span>PUBLIKASI MEDIA</span>
                    <span class="text-white/30">•</span>
                    <span class="text-lime-400 font-extrabold">{{ $beritaId ? 'MODE EDIT' : 'DRAF BARU' }}</span>
                </div>
                <h1 class="text-base sm:text-xl lg:text-2xl font-black tracking-tight leading-tight truncate">
                    {{ $beritaId ? 'Sunting Naskah Berita' : 'Tulis Publikasi Berita' }}
                </h1>
            </div>
        </div>

        <!-- Quick Top Action Group -->
        <div class="relative z-10 flex items-center gap-2 self-end sm:self-auto shrink-0">
            <x-form.button 
                :href="route('admin.berita')" 
                variant="ghost" 
                size="sm" 
                icon="x"
                wire:navigate
            >
                <span>Batal</span>
            </x-form.button>

            <x-form.button 
                type="button" 
                wire:click="simpanDraft" 
                variant="draft" 
                size="sm" 
                icon="file-edit"
                loadingTarget="simpanDraft"
            >
                <span>Draf</span>
            </x-form.button>

            <x-form.button 
                type="button" 
                wire:click="simpan" 
                variant="primary" 
                size="sm" 
                icon="check-circle"
                loadingTarget="simpan"
            >
                <span>{{ $beritaId ? 'Perbarui' : 'Terbitkan' }}</span>
            </x-form.button>
        </div>
    </div>

    <!-- FLASH NOTIFICATION -->
    @if(session()->has('pesan'))
        <div class="p-3 sm:p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center justify-between shadow-xs animate-in fade-in slide-in-from-top-1 duration-150">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-6 h-6 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-2xs">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                </div>
                <p class="text-xs text-emerald-900 font-medium truncate">{{ session('pesan') }}</p>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 p-1 rounded-lg cursor-pointer shrink-0">
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    @endif

    <!-- MAIN FORM GRID (8 Cols Content / 4 Cols Meta) -->
    <form wire:submit.prevent="simpan" class="grid grid-cols-1 lg:grid-cols-12 gap-3.5 sm:gap-5 items-start">
        
        <!-- ========================================================= -->
        <!-- LEFT 8-COLS: ARTICLE TITLE, SLUG & RICH CONTENT           -->
        <!-- ========================================================= -->
        <div class="lg:col-span-8 space-y-3.5 sm:space-y-4">

            <!-- Card 1: Judul, Slug & Sinopsis -->
            <x-form.card>
                <!-- Judul Artikel -->
                <x-form.field 
                    label="Judul Artikel Berita" 
                    name="judul" 
                    required 
                    indicatorColor="bg-emerald-600"
                    :counter="strlen($judul)"
                    :maxCount="255"
                >
                    <x-form.input 
                        name="judul"
                        wire:model.live.debounce.300ms="judul" 
                        size="lg"
                        placeholder="Tulis judul berita yang menarik dan informatif..." 
                    />
                </x-form.field>

                <!-- Slug & Permalink Row -->
                <div class="p-2.5 sm:p-3 bg-slate-50/90 rounded-xl border border-slate-200/80 space-y-1.5">
                    <div class="flex items-center justify-between text-[11px] font-bold text-slate-600">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="link-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                            <span>Permalink URL:</span>
                        </span>
                        <button 
                            type="button" 
                            wire:click="generateSlugOtomatis" 
                            class="text-[10px] text-emerald-700 hover:text-emerald-900 font-extrabold cursor-pointer flex items-center gap-1 hover:underline active:scale-95"
                        >
                            <i data-lucide="refresh-cw" class="w-2.5 h-2.5"></i>
                            <span>Sinkron Judul</span>
                        </button>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <span class="text-[11px] font-semibold text-slate-400 shrink-0 select-none bg-slate-200/70 px-2 py-1 rounded-lg">/berita/</span>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="slug" 
                            placeholder="slug-url-artikel-otomatis" 
                            class="flex-1 min-w-0 px-2.5 py-1 bg-white border border-slate-200 text-slate-800 rounded-lg text-[11px] font-mono font-bold focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20"
                        >
                    </div>
                    @error('slug') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Sinopsis / Ringkasan -->
                <x-form.field 
                    label="Sinopsis / Cuplikan Singkat" 
                    name="ringkasan" 
                    required 
                    indicatorColor="bg-teal-600"
                    :counter="strlen($ringkasan)"
                    :maxCount="500"
                >
                    <x-slot:action>
                        <button 
                            type="button" 
                            wire:click="generateRingkasanOtomatis" 
                            class="text-[10px] text-emerald-700 hover:text-emerald-900 font-bold hover:underline cursor-pointer flex items-center gap-1 active:scale-95"
                            title="Ekstrak 1-2 kalimat pertama dari naskah berita"
                        >
                            <i data-lucide="sparkles" class="w-3 h-3 text-emerald-600"></i>
                            <span>Ekstrak Naskah</span>
                        </button>
                    </x-slot:action>

                    <x-form.textarea 
                        name="ringkasan"
                        wire:model.live.debounce.300ms="ringkasan" 
                        rows="2" 
                        placeholder="Tulis sinopsis ringkas 1-2 kalimat padat sebagai cuplikan di beranda dan meta deskripsi Google..." 
                    />
                </x-form.field>
            </x-form.card>

            <!-- Card 2: Naskah Editor Lengkap & Shortcut Template -->
            <x-form.card>
                <!-- Quick Template Pills inside Editor Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-2.5 border-b border-slate-100">
                    <div>
                        <label class="block text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            <span>Naskah Isi Berita <span class="text-rose-500">*</span></span>
                        </label>
                    </div>

                    <!-- Editor vs Preview Switcher -->
                    <div class="flex items-center p-0.5 bg-slate-100 rounded-xl border border-slate-200/80 self-start sm:self-auto shrink-0">
                        <button 
                            type="button" 
                            wire:click="$set('tabEditor', 'editor')" 
                            class="px-2.5 py-1 rounded-lg text-[11px] font-bold transition-all cursor-pointer flex items-center gap-1 {{ $tabEditor === 'editor' ? 'bg-white text-emerald-800 shadow-2xs font-extrabold' : 'text-slate-500 hover:text-slate-800' }}"
                        >
                            <i data-lucide="edit-3" class="w-3 h-3 {{ $tabEditor === 'editor' ? 'text-emerald-600' : '' }}"></i>
                            <span>Editor</span>
                        </button>
                        <button 
                            type="button" 
                            wire:click="$set('tabEditor', 'preview')" 
                            class="px-2.5 py-1 rounded-lg text-[11px] font-bold transition-all cursor-pointer flex items-center gap-1 {{ $tabEditor === 'preview' ? 'bg-white text-emerald-800 shadow-2xs font-extrabold' : 'text-slate-500 hover:text-slate-800' }}"
                        >
                            <i data-lucide="eye" class="w-3 h-3 {{ $tabEditor === 'preview' ? 'text-emerald-600' : '' }}"></i>
                            <span>Pratinjau</span>
                        </button>
                    </div>
                </div>

                <!-- Template Shortcut Strip -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-none text-[11px]">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider shrink-0 flex items-center gap-1">
                        <i data-lucide="wand-2" class="w-3 h-3 text-emerald-600"></i>
                        <span>Template:</span>
                    </span>
                    <button 
                        type="button" 
                        wire:click="terapkanTemplate('liputan')" 
                        class="px-2 py-0.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/80 font-bold transition-colors cursor-pointer shrink-0"
                    >
                        Liputan Acara
                    </button>
                    <button 
                        type="button" 
                        wire:click="terapkanTemplate('siaran_pers')" 
                        class="px-2 py-0.5 rounded-lg bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200/80 font-bold transition-colors cursor-pointer shrink-0"
                    >
                        Siaran Pers
                    </button>
                    <button 
                        type="button" 
                        wire:click="terapkanTemplate('pengumuman')" 
                        class="px-2 py-0.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/80 font-bold transition-colors cursor-pointer shrink-0"
                    >
                        Pengumuman
                    </button>
                </div>

                @if($tabEditor === 'editor')
                    <!-- Compact Markdown Toolbar -->
                    <div class="flex items-center gap-1 p-1.5 bg-slate-50 rounded-xl border border-slate-200/80 text-xs text-slate-600 flex-wrap select-none" x-data="{
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
                        <button type="button" @click="insertFormat('**', '**')" class="px-2 py-1 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-extrabold text-[11px] cursor-pointer shadow-2xs text-slate-800" title="Tebal (Bold)">
                            <span>B</span>
                        </button>
                        <button type="button" @click="insertFormat('*', '*')" class="px-2 py-1 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-serif italic font-bold text-[11px] cursor-pointer shadow-2xs text-slate-800" title="Miring (Italic)">
                            <span>I</span>
                        </button>
                        <div class="h-3.5 w-px bg-slate-200 mx-0.5"></div>
                        <button type="button" @click="insertFormat('## ', '\n')" class="px-2 py-1 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-black text-[10px] cursor-pointer shadow-2xs text-slate-800" title="Heading 2">
                            <span>H2</span>
                        </button>
                        <button type="button" @click="insertFormat('### ', '\n')" class="px-2 py-1 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-black text-[10px] cursor-pointer shadow-2xs text-slate-800" title="Heading 3">
                            <span>H3</span>
                        </button>
                        <div class="h-3.5 w-px bg-slate-200 mx-0.5"></div>
                        <button type="button" @click="insertFormat('> ', '\n')" class="px-2 py-1 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-bold text-[10px] cursor-pointer shadow-2xs text-slate-800" title="Kutipan">
                            <span>&ldquo; Kutipan &rdquo;</span>
                        </button>
                        <button type="button" @click="insertFormat('- ', '\n')" class="px-2 py-1 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 font-bold text-[10px] cursor-pointer shadow-2xs text-slate-800" title="Daftar List">
                            <span>• List</span>
                        </button>
                    </div>

                    <!-- Textarea Editor -->
                    <div>
                        <textarea 
                            id="textareaNaskahBerita"
                            wire:model.live.debounce.300ms="isi_konten" 
                            rows="13" 
                            placeholder="Tuliskan naskah lengkap berita liputan, kutipan wawancara narasumber, dan jalannya acara..." 
                            class="w-full px-3.5 py-3 bg-slate-50/70 hover:bg-slate-100/60 focus:bg-white border border-slate-200 focus:border-emerald-600 focus:ring-3 focus:ring-emerald-600/15 focus:outline-none text-slate-900 rounded-xl text-xs sm:text-sm font-medium leading-relaxed placeholder:text-slate-400 font-sans shadow-2xs transition-all"
                        ></textarea>
                        @error('isi_konten') <span class="text-xs text-rose-600 mt-1 block font-bold flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}</span> @enderror
                    </div>

                    <!-- Compact Word Count Bar -->
                    @php
                        $wordCount = str_word_count(strip_tags($isi_konten));
                        $charCount = strlen($isi_konten);
                        $estRead = max(1, (int) ceil($wordCount / 200));
                    @endphp
                    <div class="p-2 bg-slate-50 rounded-xl border border-slate-200/80 flex items-center justify-between text-[11px] text-slate-600 font-medium flex-wrap gap-2">
                        <div class="flex items-center gap-2 font-semibold">
                            <span><b>{{ number_format($wordCount) }}</b> Kata</span>
                            <span class="text-slate-300">•</span>
                            <span><b>{{ number_format($charCount) }}</b> Karakter</span>
                        </div>
                        <div class="flex items-center gap-1 text-emerald-800 font-bold bg-emerald-100/70 px-2 py-0.5 rounded-md text-[10px]">
                            <i data-lucide="clock" class="w-3 h-3 text-emerald-600"></i>
                            <span>Baca: ~{{ $estRead }} mnt</span>
                        </div>
                    </div>
                @else
                    <!-- Live Preview Display -->
                    <div class="p-4 sm:p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-3.5">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-emerald-600 text-white">
                                    {{ $kategoriList->firstWhere('id', $kategori_id)?->nama_kategori ?? 'Kategori Berita' }}
                                </span>
                                @if($status_unggulan)
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-amber-500 text-white flex items-center gap-1">
                                        <i data-lucide="star" class="w-2.5 h-2.5 fill-white"></i>
                                        <span>Headline</span>
                                    </span>
                                @endif
                                <span class="text-[10px] text-slate-400 font-bold ml-auto">
                                    Status: <strong class="uppercase text-slate-700">{{ $status_publikasi }}</strong>
                                </span>
                            </div>

                            <h2 class="text-lg sm:text-xl font-black text-slate-900 leading-tight">
                                {{ $judul ?: 'Judul Berita Belum Diisi' }}
                            </h2>
                        </div>

                        <!-- Image Preview in Portal Look -->
                        <div class="rounded-xl overflow-hidden border border-slate-200 bg-white shadow-2xs">
                            @if($uploadGambar)
                                <img src="{{ $uploadGambar->temporaryUrl() }}" class="w-full h-44 sm:h-64 object-cover" alt="Pratinjau Foto">
                            @elseif($gambar_utama)
                                @php $prevUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($gambar_utama) ?? $gambar_utama @endphp
                                <img src="{{ $prevUrl }}" class="w-full h-44 sm:h-64 object-cover" alt="Foto Berita">
                            @else
                                <div class="h-36 bg-slate-100 flex flex-col items-center justify-center text-slate-400 gap-1">
                                    <i data-lucide="image" class="w-6 h-6 text-slate-300"></i>
                                    <span class="text-[11px] font-bold">(Thumbnail Belum Diunggah)</span>
                                </div>
                            @endif
                        </div>

                        @if($ringkasan)
                            <div class="p-3 rounded-xl bg-emerald-50/80 border-l-3 border-emerald-600 text-slate-800 text-xs font-semibold leading-relaxed">
                                {{ $ringkasan }}
                            </div>
                        @endif

                        <div class="prose prose-slate max-w-none text-xs leading-relaxed text-slate-800 space-y-2 whitespace-pre-line font-normal">
                            {{ $isi_konten ?: 'Naskah isi konten berita masih kosong...' }}
                        </div>
                    </div>
                @endif
            </x-form.card>
        </div>

        <!-- ========================================================= -->
        <!-- RIGHT 4-COLS: PUBLISHING META, MEDIA & SEO AUDITOR        -->
        <!-- ========================================================= -->
        <div class="lg:col-span-4 space-y-3.5 sm:space-y-4">

            <!-- Card A: Status Publikasi & Jadwal -->
            <x-form.card 
                title="Status & Jadwal Tayang" 
                icon="send"
            >
                <!-- Status Publikasi -->
                <x-form.field label="Status Publikasi" name="status_publikasi" required>
                    @php
                        $statusOptions = [
                            ['value' => 'published', 'label' => 'Published (Tayang Publik)', 'badge' => 'Live', 'color' => '#10b981'],
                            ['value' => 'draft', 'label' => 'Draft (Konsep Internal)', 'badge' => 'Draf', 'color' => '#f59e0b'],
                            ['value' => 'archived', 'label' => 'Archived (Diarsipkan)', 'badge' => 'Arsip', 'color' => '#64748b'],
                        ];
                    @endphp
                    <x-form.searchable-select 
                        name="status_publikasi"
                        wire:model="status_publikasi"
                        :options="$statusOptions"
                        placeholder="Pilih Status..."
                        searchPlaceholder="Cari status..."
                        :required="true"
                    />
                </x-form.field>

                <!-- Jadwal Tanggal Terbit dengan Flatpickr -->
                <x-form.field label="Jadwal Rilis" name="tanggal_publikasi">
                    <x-form.datepicker 
                        name="tanggal_publikasi"
                        wire:model="tanggal_publikasi"
                        placeholder="Pilih tanggal & waktu..."
                        :enableTime="true"
                    />
                </x-form.field>

                <!-- Penulis / Kontributor -->
                <x-form.field label="Penulis / Kontributor" name="penulis_id">
                    @php
                        $penulisOptions = $penulisList->map(fn($p) => [
                            'value' => (string) $p->id,
                            'label' => $p->nama_lengkap,
                            'description' => $p->email,
                            'badge' => $p->peran?->nama_peran ?? 'Kontributor',
                        ])->toArray();
                    @endphp
                    <x-form.searchable-select 
                        name="penulis_id"
                        wire:model="penulis_id"
                        :options="$penulisOptions"
                        placeholder="Pilih Penulis..."
                        searchPlaceholder="Cari nama atau email..."
                    />
                </x-form.field>

                <!-- Headline Switch -->
                <div class="p-2.5 sm:p-3 rounded-xl bg-amber-50/70 border border-amber-200 flex items-start gap-2.5">
                    <input 
                        type="checkbox" 
                        id="formUnggulanBerita" 
                        wire:model="status_unggulan" 
                        class="w-4 h-4 mt-0.5 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                    >
                    <label for="formUnggulanBerita" class="cursor-pointer select-none min-w-0">
                        <span class="block text-xs font-black text-amber-950 flex items-center gap-1">
                            <i data-lucide="star" class="w-3.5 h-3.5 text-amber-600 fill-amber-500 shrink-0"></i>
                            <span>Jadikan Berita Utama (Headline)</span>
                        </span>
                        <span class="block text-[10px] text-amber-800 font-medium mt-0.5 leading-snug">
                            Tampilkan di carousel headline banner beranda portal.
                        </span>
                    </label>
                </div>
            </x-form.card>

            <!-- Card B: Kategori Berita -->
            <x-form.card 
                title="Kategori Berita" 
                icon="tag"
            >
                <x-slot:headerActions>
                    <button 
                        type="button" 
                        wire:click="bukaModalTambahKategori" 
                        class="text-[10px] text-emerald-700 hover:text-emerald-900 font-extrabold cursor-pointer flex items-center gap-1 hover:underline active:scale-95"
                    >
                        <i data-lucide="plus-circle" class="w-3 h-3"></i>
                        <span>+ Kategori Baru</span>
                    </button>
                </x-slot:headerActions>

                <x-form.field name="kategori_id" required>
                    @php
                        $katOptions = $kategoriList->map(fn($k) => [
                            'value' => (string) $k->id,
                            'label' => $k->nama_kategori,
                            'badge' => $k->berita_count . ' post',
                            'color' => $k->kode_warna_hex ?? '#059669',
                        ])->toArray();
                    @endphp
                    <x-form.searchable-select 
                        name="kategori_id"
                        wire:model="kategori_id"
                        :options="$katOptions"
                        placeholder="Pilih Kategori..."
                        searchPlaceholder="Ketik untuk mencari kategori..."
                        :required="true"
                    />
                </x-form.field>
            </x-form.card>

            <!-- Card C: Thumbnail & Foto Media (Dropzone + Client-Side Compress) -->
            <x-form.card 
                title="Thumbnail & Foto Utama" 
                icon="image"
            >
                <x-form.image-upload 
                    :upload="$uploadGambar"
                    :savedPath="$gambar_utama"
                    name="uploadGambar"
                    inputId="uploadGambarBerita"
                    placeholderText="{{ $beritaId ? 'Ganti Berkas Foto' : 'Pilih Berkas Foto Utama' }}"
                    aspectRatio="h-32 sm:h-40"
                />

                <!-- Caption Foto -->
                <x-form.field label="Keterangan / Sumber Foto" name="keterangan_gambar">
                    <x-form.input 
                        name="keterangan_gambar"
                        wire:model="keterangan_gambar" 
                        placeholder="Contoh: Dok. Humas KORMI Kab. Bandung..." 
                        size="sm"
                    />
                </x-form.field>
            </x-form.card>

            <!-- Card D: SEO Auditor & SERP Simulator -->
            <x-form.card>
                <x-form.seo-auditor 
                    :score="$seoScore"
                    :checklist="$seoChecklist"
                    :slug="$slug"
                    :title="$judul"
                    :description="$ringkasan"
                />
            </x-form.card>

        </div>

        <!-- ========================================================= -->
        <!-- BOTTOM FIXED STICKY ACTION BAR                            -->
        <!-- ========================================================= -->
        <x-form.action-bar :backUrl="route('admin.berita')">
            <x-form.button 
                type="button" 
                wire:click="simpanDraft" 
                variant="draft" 
                size="default" 
                icon="file-edit"
                loadingTarget="simpanDraft"
            >
                <span class="hidden xs:inline">Simpan Draf</span>
                <span class="xs:hidden">Draf</span>
            </x-form.button>

            <x-form.button 
                type="submit" 
                variant="primary" 
                size="default" 
                icon="check"
                loadingTarget="simpan"
            >
                <span>{{ $beritaId ? 'Perbarui Publikasi' : 'Terbitkan Sekarang' }}</span>
            </x-form.button>
        </x-form.action-bar>

    </form>

    <!-- ========================================================= -->
    <!-- MODAL TAMBAH KATEGORI CEPAT                               -->
    <!-- ========================================================= -->
    <x-form.modal 
        :show="$tampilkanModalKategori"
        title="Tambah Kategori Berita"
        subtitle="Buat klasifikasi berita baru langsung"
        icon="tag"
        onClose="tutupModalTambahKategori"
    >
        <form wire:submit.prevent="simpanKategoriBaru" class="space-y-3.5">
            <x-form.field label="Nama Kategori" name="kategoriBaruNama" required>
                <x-form.input 
                    name="kategoriBaruNama"
                    wire:model="kategoriBaruNama" 
                    placeholder="Contoh: Liputan Khusus, Raker..." 
                />
            </x-form.field>

            <x-form.field label="Warna Aksen Kategori" name="kategoriBaruWarna" required>
                <div class="flex items-center gap-2.5">
                    <input 
                        type="color" 
                        wire:model.live="kategoriBaruWarna" 
                        class="w-10 h-9 rounded-xl border border-slate-200 p-1 cursor-pointer bg-white"
                    >
                    <x-form.input 
                        name="kategoriBaruWarna"
                        wire:model="kategoriBaruWarna" 
                        placeholder="#059669" 
                        class="font-mono uppercase font-bold"
                    />
                </div>
            </x-form.field>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <x-form.button 
                    type="button" 
                    wire:click="tutupModalTambahKategori" 
                    variant="secondary" 
                    size="sm"
                >
                    Batal
                </x-form.button>
                
                <x-form.button 
                    type="submit" 
                    variant="primary" 
                    size="sm"
                >
                    Simpan Kategori
                </x-form.button>
            </div>
        </form>
    </x-form.modal>

</div>
