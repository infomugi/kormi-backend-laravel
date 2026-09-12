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

            <!-- Card 1: Judul, Slug & Sinopsis (Clean & Ultra Sleek) -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-6 shadow-xs space-y-4">
                
                <!-- Judul Artikel -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between text-xs">
                        <label for="inputJudulBerita" class="font-extrabold text-slate-800 tracking-tight flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Judul Artikel Berita <span class="text-rose-500">*</span></span>
                        </label>
                        <span class="text-[11px] font-bold text-slate-400 font-mono">{{ strlen($judul) }}/255</span>
                    </div>
                    <input 
                        id="inputJudulBerita"
                        type="text" 
                        wire:model.live.debounce.300ms="judul"
                        placeholder="Tulis judul berita yang menarik dan informatif..." 
                        class="w-full px-4 py-3 bg-slate-50/50 hover:bg-slate-50 focus:bg-white border border-slate-200 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/10 focus:outline-none text-slate-900 font-bold text-sm sm:text-base rounded-xl transition-all placeholder:font-normal placeholder:text-slate-400 shadow-2xs"
                    >
                    @error('judul') <span class="text-xs text-rose-600 font-bold block mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Slug & Permalink URL (Clean Inline Pill) -->
                <div class="p-2 sm:p-2.5 bg-slate-50/80 rounded-xl border border-slate-200/70 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                    <div class="flex items-center gap-1.5 min-w-0 flex-1">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 shrink-0 flex items-center gap-1 px-1">
                            <i data-lucide="link-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                            <span class="hidden sm:inline">Permalink:</span>
                        </span>
                        <div class="flex items-center flex-1 min-w-0 bg-white px-2.5 py-1 rounded-lg border border-slate-200/90 font-mono text-[11px]">
                            <span class="text-slate-400 font-semibold select-none">/berita/</span>
                            <input 
                                type="text" 
                                wire:model.live.debounce.300ms="slug" 
                                placeholder="slug-url-artikel" 
                                class="w-full bg-transparent border-0 p-0 text-slate-800 font-bold focus:outline-none focus:ring-0 text-[11px] pl-0.5"
                            >
                        </div>
                    </div>
                    <button 
                        type="button" 
                        wire:click="generateSlugOtomatis" 
                        class="text-[10px] font-extrabold text-emerald-700 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100/80 px-2.5 py-1 rounded-lg border border-emerald-200/60 transition-all cursor-pointer flex items-center justify-center gap-1 shrink-0 active:scale-95"
                        title="Perbarui slug mengikuti judul"
                    >
                        <i data-lucide="refresh-cw" class="w-2.5 h-2.5"></i>
                        <span>Sinkron Judul</span>
                    </button>
                </div>
                @error('slug') <span class="text-xs text-rose-600 font-bold block">{{ $message }}</span> @enderror

                <!-- Sinopsis / Ringkasan -->
                <div class="space-y-1.5 pt-1">
                    <div class="flex items-center justify-between text-xs">
                        <label for="textareaRingkasan" class="font-extrabold text-slate-800 tracking-tight flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                            <span>Sinopsis / Cuplikan Singkat <span class="text-rose-500">*</span></span>
                        </label>
                        <div class="flex items-center gap-2">
                            <button 
                                type="button" 
                                wire:click="generateRingkasanOtomatis" 
                                class="text-[10px] text-emerald-700 hover:text-emerald-900 font-extrabold hover:underline cursor-pointer flex items-center gap-1 active:scale-95"
                                title="Ekstrak 1-2 kalimat awal dari naskah berita"
                            >
                                <i data-lucide="sparkles" class="w-3 h-3 text-emerald-600"></i>
                                <span>Ekstrak Naskah</span>
                            </button>
                            <span class="text-slate-300">•</span>
                            <span class="text-[11px] font-bold text-slate-400 font-mono">{{ strlen($ringkasan) }}/500</span>
                        </div>
                    </div>
                    <textarea 
                        id="textareaRingkasan"
                        wire:model.live.debounce.300ms="ringkasan" 
                        rows="2" 
                        placeholder="Tulis sinopsis ringkas 1-2 kalimat padat sebagai cuplikan di beranda dan meta deskripsi Google..." 
                        class="w-full px-3.5 py-2.5 bg-slate-50/50 hover:bg-slate-50 focus:bg-white border border-slate-200 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/10 focus:outline-none text-slate-900 font-medium text-xs sm:text-sm rounded-xl transition-all placeholder:text-slate-400 leading-relaxed shadow-2xs"
                    ></textarea>
                    @error('ringkasan') <span class="text-xs text-rose-600 font-bold block mt-1">{{ $message }}</span> @enderror
                </div>

            </div>

            <!-- Card 2: Naskah Editor Lengkap & Mode Switcher (Ultra Sleek & Premium) -->
            <div 
                x-data="kormiEditor($wire.entangle('isi_konten'))"
                @keydown.window.escape="if(isFullscreen) toggleFullscreen()"
                class="relative"
            >
                <div 
                    :class="isFullscreen 
                        ? 'fixed inset-0 z-[100] bg-slate-950/98 backdrop-blur-2xl p-4 sm:p-6 flex flex-col justify-between overflow-hidden shadow-2xl animate-in fade-in duration-200' 
                        : 'bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden transition-all'"
                >
                    <!-- Unified Premium Top Header Bar -->
                    <div 
                        class="px-4 py-3 sm:px-5 sm:py-3.5 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-3"
                        :class="isFullscreen ? 'border-slate-800 bg-slate-900/90' : 'border-slate-100 bg-slate-50/50'"
                    >
                        <!-- Left: Label & Presets -->
                        <div class="flex items-center gap-3 flex-wrap">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 ring-4 ring-emerald-500/20"></span>
                                <span class="text-xs font-black uppercase tracking-wider" :class="isFullscreen ? 'text-white' : 'text-slate-800'">
                                    Naskah Berita <span class="text-rose-500">*</span>
                                </span>
                            </div>

                            <!-- Preset Template Pills -->
                            <div class="flex items-center gap-1 pl-2 border-l" :class="isFullscreen ? 'border-slate-700' : 'border-slate-200'">
                                <span class="text-[9px] font-extrabold uppercase tracking-wider text-slate-400 mr-0.5">Template:</span>
                                <button 
                                    type="button" 
                                    wire:click="terapkanTemplate('liputan')" 
                                    class="px-2 py-0.5 rounded-md bg-emerald-50 hover:bg-emerald-100/80 text-emerald-700 border border-emerald-200/60 text-[10px] font-bold transition-all cursor-pointer active:scale-95"
                                >
                                    Liputan
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="terapkanTemplate('siaran_pers')" 
                                    class="px-2 py-0.5 rounded-md bg-teal-50 hover:bg-teal-100/80 text-teal-700 border border-teal-200/60 text-[10px] font-bold transition-all cursor-pointer active:scale-95"
                                >
                                    Siaran Pers
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="terapkanTemplate('pengumuman')" 
                                    class="px-2 py-0.5 rounded-md bg-amber-50 hover:bg-amber-100/80 text-amber-700 border border-amber-200/60 text-[10px] font-bold transition-all cursor-pointer active:scale-95"
                                >
                                    Pengumuman
                                </button>
                            </div>
                        </div>

                        <!-- Right: Search, Font Size, Segmented Modes, Fullscreen -->
                        <div class="flex items-center gap-2 self-end sm:self-auto flex-wrap">
                            <!-- Find & Replace Toggle Button -->
                            <button 
                                type="button" 
                                @click="showFindReplace = !showFindReplace"
                                class="p-1.5 rounded-lg border transition-all cursor-pointer"
                                :class="showFindReplace 
                                    ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs' 
                                    : (isFullscreen ? 'bg-slate-800 border-slate-700 text-slate-400 hover:text-white' : 'bg-white border-slate-200 text-slate-500 hover:text-slate-800 hover:bg-slate-50')"
                                title="Cari dan Ganti Kata"
                            >
                                <i data-lucide="search" class="w-3.5 h-3.5"></i>
                            </button>

                            <!-- Font Size Selector -->
                            <div class="flex items-center rounded-lg border p-0.5" :class="isFullscreen ? 'bg-slate-800 border-slate-700' : 'bg-white border-slate-200'">
                                <button type="button" @click="fontSize = 'text-xs'" :class="fontSize === 'text-xs' ? 'bg-slate-900 text-white shadow-xs font-black' : 'text-slate-400 hover:text-slate-700'" class="px-1.5 py-0.5 rounded text-[10px] transition-all cursor-pointer">S</button>
                                <button type="button" @click="fontSize = 'text-sm'" :class="fontSize === 'text-sm' ? 'bg-slate-900 text-white shadow-xs font-black' : 'text-slate-400 hover:text-slate-700'" class="px-1.5 py-0.5 rounded text-[10px] transition-all cursor-pointer">M</button>
                                <button type="button" @click="fontSize = 'text-base'" :class="fontSize === 'text-base' ? 'bg-slate-900 text-white shadow-xs font-black' : 'text-slate-400 hover:text-slate-700'" class="px-1.5 py-0.5 rounded text-[10px] transition-all cursor-pointer">L</button>
                            </div>

                            <!-- Premium Segmented Tab Mode Switcher (Visual, HTML, MD, View, Split) -->
                            <div class="flex items-center p-0.5 rounded-lg border bg-slate-100/90 border-slate-200" :class="isFullscreen ? 'bg-slate-800 border-slate-700' : ''">
                                <!-- Visual Mode -->
                                <button 
                                    type="button" 
                                    @click="setMode('visual')" 
                                    class="px-2.5 py-1 rounded-md text-[11px] font-bold transition-all cursor-pointer flex items-center gap-1"
                                    :class="editorMode === 'visual' ? 'bg-white text-emerald-700 shadow-2xs font-extrabold' : 'text-slate-500 hover:text-slate-800'"
                                    title="Mode Visual WYSIWYG (Langsung format naskah seperti Microsoft Word)"
                                >
                                    <i data-lucide="layout-template" class="w-3.5 h-3.5"></i>
                                    <span>Visual</span>
                                </button>
                                <!-- HTML Mode -->
                                <button 
                                    type="button" 
                                    @click="setMode('html')" 
                                    class="px-2.5 py-1 rounded-md text-[11px] font-bold transition-all cursor-pointer flex items-center gap-1"
                                    :class="editorMode === 'html' ? 'bg-white text-emerald-700 shadow-2xs font-extrabold' : 'text-slate-500 hover:text-slate-800'"
                                    title="Mode HTML (Edit kode HTML / Auto Paste Markdown jadi Clean HTML)"
                                >
                                    <i data-lucide="code-2" class="w-3.5 h-3.5"></i>
                                    <span>HTML</span>
                                </button>
                                <!-- MD Mode -->
                                <button 
                                    type="button" 
                                    @click="setMode('md')" 
                                    class="px-2.5 py-1 rounded-md text-[11px] font-bold transition-all cursor-pointer flex items-center gap-1"
                                    :class="editorMode === 'md' ? 'bg-white text-emerald-700 shadow-2xs font-extrabold' : 'text-slate-500 hover:text-slate-800'"
                                    title="Mode Markdown (Sintaks #, **, >)"
                                >
                                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                    <span>MD</span>
                                </button>
                                <!-- View Mode -->
                                <button 
                                    type="button" 
                                    @click="setMode('view')" 
                                    class="px-2.5 py-1 rounded-md text-[11px] font-bold transition-all cursor-pointer flex items-center gap-1"
                                    :class="editorMode === 'view' ? 'bg-white text-emerald-700 shadow-2xs font-extrabold' : 'text-slate-500 hover:text-slate-800'"
                                    title="Mode Pratinjau Visual Artikel Penuh"
                                >
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    <span>View</span>
                                </button>
                                <!-- Split Mode -->
                                <button 
                                    type="button" 
                                    @click="setMode('split')" 
                                    class="px-2.5 py-1 rounded-md text-[11px] font-bold transition-all cursor-pointer hidden md:flex items-center gap-1"
                                    :class="editorMode === 'split' ? 'bg-white text-emerald-700 shadow-2xs font-extrabold' : 'text-slate-500 hover:text-slate-800'"
                                    title="Tampilan Editor & Pratinjau Berdampingan"
                                >
                                    <i data-lucide="columns-2" class="w-3.5 h-3.5"></i>
                                    <span>Split</span>
                                </button>
                            </div>

                            <!-- Hidden file input for direct in-content image upload -->
                            <input 
                                type="file" 
                                id="inputUploadFotoArtikel" 
                                accept="image/png,image/jpeg,image/webp,image/jpg" 
                                class="hidden" 
                                @change="handleDirectImageUpload($event)"
                            >

                            <!-- Fullscreen Mode Button -->
                            <button 
                                type="button" 
                                @click="toggleFullscreen()" 
                                class="p-1.5 rounded-lg border transition-all cursor-pointer flex items-center gap-1 text-[11px] font-extrabold active:scale-95"
                                :class="isFullscreen 
                                    ? 'bg-rose-600 text-white border-rose-600 shadow-xs' 
                                    : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50 shadow-2xs'"
                                :title="isFullscreen ? 'Keluar Fullscreen (Esc)' : 'Mode Layar Penuh'"
                            >
                                <i :data-lucide="isFullscreen ? 'minimize-2' : 'maximize-2'" class="w-3.5 h-3.5 text-emerald-600" :class="isFullscreen ? '!text-white' : ''"></i>
                                <span class="hidden lg:inline" x-text="isFullscreen ? 'Keluar' : 'Fokus'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Expandable Find & Replace Bar -->
                    <div x-show="showFindReplace" x-transition.duration.150ms class="p-3 border-b flex flex-col sm:flex-row items-stretch sm:items-center gap-2" :class="isFullscreen ? 'bg-slate-900 border-slate-800' : 'bg-slate-50/80 border-slate-100'">
                        <div class="flex items-center gap-1.5 flex-1 min-w-0 bg-white px-3 py-1.5 rounded-lg border border-slate-200">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                            <input 
                                type="text" 
                                x-model="searchWord" 
                                placeholder="Cari kata/frasa dalam naskah..." 
                                class="w-full text-xs font-semibold focus:outline-none text-slate-800"
                            >
                        </div>
                        <div class="flex items-center gap-1.5 flex-1 min-w-0 bg-white px-3 py-1.5 rounded-lg border border-slate-200">
                            <i data-lucide="replace" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                            <input 
                                type="text" 
                                x-model="replaceWord" 
                                placeholder="Ganti dengan kata..." 
                                class="w-full text-xs font-semibold focus:outline-none text-slate-800"
                            >
                        </div>
                        <button 
                            type="button" 
                            @click="findAndReplaceAll()" 
                            class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all cursor-pointer shrink-0 active:scale-95 shadow-2xs"
                        >
                            Ganti Semua
                        </button>
                    </div>

                    <!-- PRO RICH FORMATTING TOOLBAR -->
                    <div 
                        x-show="editorMode === 'visual' || editorMode === 'html' || editorMode === 'md' || editorMode === 'split'" 
                        class="px-3.5 py-2 border-b flex items-center justify-between gap-2 flex-wrap select-none"
                        :class="isFullscreen ? 'bg-slate-900/95 border-slate-800' : 'bg-white border-slate-100'"
                    >
                        <!-- Left Group: Formatting Icons -->
                        <div class="flex items-center gap-1 flex-wrap">
                            <!-- Bold -->
                            <button type="button" @click="editorMode === 'html' ? insertFormat('<strong>', '</strong>', 'Teks Tebal') : insertFormat('**', '**', 'Teks Tebal')" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 font-black text-xs cursor-pointer text-slate-800 flex items-center justify-center transition-all active:scale-90" title="Tebal (Ctrl+B)">
                                <b>B</b>
                            </button>
                            <!-- Italic -->
                            <button type="button" @click="editorMode === 'html' ? insertFormat('<em>', '</em>', 'Teks Miring') : insertFormat('*', '*', 'Teks Miring')" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 font-serif italic font-bold text-xs cursor-pointer text-slate-800 flex items-center justify-center transition-all active:scale-90" title="Miring (Ctrl+I)">
                                <i>I</i>
                            </button>
                            <!-- Highlighter -->
                            <button type="button" @click="insertFormat('<mark>', '</mark>', 'Sorotan')" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs cursor-pointer text-amber-600 flex items-center justify-center transition-all active:scale-90" title="Sorotan Warna Kuning">
                                <i data-lucide="highlighter" class="w-3.5 h-3.5"></i>
                            </button>
                            <!-- Strikethrough -->
                            <button type="button" @click="editorMode === 'html' ? insertFormat('<del>', '</del>', 'Coret') : insertFormat('~~', '~~', 'Coret')" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 font-bold text-xs cursor-pointer text-slate-500 line-through flex items-center justify-center transition-all active:scale-90" title="Coret Teks">
                                S
                            </button>

                            <div class="h-4 w-px bg-slate-200 dark:bg-slate-700 mx-1"></div>

                            <!-- Headings Group -->
                            <div class="flex items-center rounded-md border border-slate-200 bg-slate-50 p-0.5">
                                <button type="button" @click="insertLineFormat('## ', 'h2')" class="px-1.5 py-0.5 rounded hover:bg-white font-black text-[10px] cursor-pointer text-slate-800" title="Heading 2">H2</button>
                                <button type="button" @click="insertLineFormat('### ', 'h3')" class="px-1.5 py-0.5 rounded hover:bg-white font-black text-[10px] cursor-pointer text-slate-800" title="Heading 3">H3</button>
                                <button type="button" @click="insertLineFormat('#### ', 'h4')" class="px-1.5 py-0.5 rounded hover:bg-white font-bold text-[10px] cursor-pointer text-slate-600" title="Heading 4">H4</button>
                            </div>

                            <div class="h-4 w-px bg-slate-200 dark:bg-slate-700 mx-1"></div>

                            <!-- Lists -->
                            <button type="button" @click="insertList('ul')" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 font-bold text-xs cursor-pointer text-slate-700 flex items-center justify-center transition-all active:scale-90" title="Daftar Poin">
                                <i data-lucide="list" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" @click="insertList('ol')" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 font-bold text-xs cursor-pointer text-slate-700 flex items-center justify-center transition-all active:scale-90" title="Daftar Nomor">
                                <i data-lucide="list-ordered" class="w-3.5 h-3.5"></i>
                            </button>

                            <div class="h-4 w-px bg-slate-200 dark:bg-slate-700 mx-1"></div>

                            <!-- Elements: Quote, Table, Divider -->
                            <button type="button" @click="insertCallout('quote')" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs cursor-pointer text-indigo-700 flex items-center justify-center transition-all active:scale-90" title="Kutipan Wawancara">
                                <i data-lucide="quote" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" @click="insertCallout('info')" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs cursor-pointer text-teal-700 flex items-center justify-center transition-all active:scale-90" title="Kotak Info">
                                <i data-lucide="info" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" @click="insertTable()" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs cursor-pointer text-slate-700 flex items-center justify-center transition-all active:scale-90" title="Sisipkan Tabel">
                                <i data-lucide="table" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" @click="insertDivider()" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs cursor-pointer text-slate-500 flex items-center justify-center transition-all active:scale-90" title="Garis Pembatas">
                                <i data-lucide="minus" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>

                        <!-- Right Group: Clean HTML, Links, Images & Eraser -->
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <!-- Clean HTML Format Button -->
                            <button 
                                type="button" 
                                @click="konversiKeHtmlBersih()" 
                                class="px-2.5 py-1 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-[10px] font-extrabold cursor-pointer flex items-center gap-1 transition-all active:scale-90 shadow-2xs" 
                                title="Rapikan naskah dan format ke Clean Semantic HTML"
                            >
                                <i data-lucide="sparkles" class="w-3 h-3 text-emerald-600"></i>
                                <span>Clean HTML</span>
                            </button>

                            <button type="button" @click="insertLink()" class="px-2 py-1 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 text-[11px] font-bold text-blue-700 cursor-pointer flex items-center gap-1 transition-all active:scale-90" title="Sisipkan Link">
                                <i data-lucide="link" class="w-3 h-3"></i>
                                <span class="hidden sm:inline">Link</span>
                            </button>

                            <button type="button" @click="insertEmbedImage()" class="px-2 py-1 rounded-md bg-slate-50 hover:bg-slate-100 border border-slate-200 text-[11px] font-bold text-emerald-700 cursor-pointer flex items-center gap-1 transition-all active:scale-90" title="Sisipkan Foto Eksternal">
                                <i data-lucide="image-plus" class="w-3 h-3"></i>
                                <span class="hidden sm:inline">Foto</span>
                            </button>

                            <button type="button" @click="bersihkanFormat()" class="w-7 h-7 rounded-md bg-slate-50 hover:bg-rose-50 border border-slate-200 text-slate-400 hover:text-rose-600 cursor-pointer flex items-center justify-center transition-all active:scale-90" title="Bersihkan Format Tag">
                                <i data-lucide="eraser" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Notification Banner: Paste Markdown Converted -->
                    <div 
                        x-show="notifPasteMd" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-bold flex items-center justify-between shadow-xs"
                    >
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-check" class="w-4 h-4 text-emerald-200"></i>
                            <span x-text="notifMessage"></span>
                        </div>
                        <button type="button" @click="notifPasteMd = false" class="text-white/80 hover:text-white cursor-pointer p-0.5">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>

                    <!-- Loading Banner for Image Upload -->
                    <div 
                        x-show="isUploadingImage" 
                        x-transition 
                        class="px-4 py-2.5 bg-emerald-600 text-white text-xs font-bold flex items-center justify-between shadow-xs animate-pulse"
                    >
                        <div class="flex items-center gap-2">
                            <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                            <span>Sedang mengunggah foto ke storage server... Mohon tunggu sebentar...</span>
                        </div>
                    </div>

                    <!-- MAIN WORKSPACE: VISUAL, SINGLE (HTML/MD), SPLIT OR FULL PREVIEW (VIEW) -->
                    <div 
                        class="grid gap-0 transition-all flex-1 min-h-0" 
                        :class="[
                            editorMode === 'split' ? 'grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-slate-100' : 'grid-cols-1',
                            isFullscreen ? 'overflow-hidden' : ''
                        ]"
                    >
                        <!-- 1. Visual WYSIWYG ContentEditable Panel -->
                        <div 
                            x-show="editorMode === 'visual'" 
                            class="relative flex flex-col flex-1 min-h-[380px] p-4 sm:p-6 bg-white overflow-y-auto" 
                            :class="isFullscreen ? 'h-full min-h-0 bg-slate-900 text-slate-100' : ''"
                        >
                            <div class="absolute top-3 right-4 z-10 select-none pointer-events-none">
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider shadow-2xs border bg-teal-100 text-teal-800 border-teal-300">
                                    MODE VISUAL WYSIWYG
                                </span>
                            </div>

                            <div 
                                id="visualEditorContainer"
                                contenteditable="true"
                                @input="syncFromVisual()"
                                @blur="syncFromVisual()"
                                class="w-full flex-1 prose prose-slate max-w-none text-sm sm:text-base leading-relaxed focus:outline-none min-h-[350px] font-normal"
                                :class="[
                                    fontSize,
                                    isFullscreen ? 'prose-invert text-slate-100' : 'text-slate-800'
                                ]"
                            ></div>
                        </div>

                        <!-- 2. Textarea Editor Panel (HTML & MD) -->
                        <div 
                            x-show="editorMode === 'html' || editorMode === 'md' || editorMode === 'split'" 
                            class="relative flex flex-col flex-1 min-h-[380px]" 
                            :class="isFullscreen ? 'h-full min-h-0' : ''"
                        >
                            <!-- Badge Mode Active -->
                            <div class="absolute top-3 right-4 z-10 select-none pointer-events-none">
                                <span 
                                    class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider shadow-2xs border"
                                    :class="editorMode === 'md' 
                                        ? 'bg-amber-100/90 text-amber-800 border-amber-300/60' 
                                        : 'bg-emerald-100/90 text-emerald-800 border-emerald-300/60'"
                                    x-text="editorMode === 'md' ? 'MODE MARKDOWN' : 'MODE HTML CLEAN'"
                                ></span>
                            </div>

                            <textarea 
                                id="textareaNaskahBerita"
                                wire:model.live.debounce.300ms="isi_konten" 
                                @paste="handlePaste($event)"
                                rows="16" 
                                :placeholder="editorMode === 'md' 
                                    ? '# Judul Berita\n\nTulis artikel dalam format Markdown biasa... Saat berganti ke mode HTML akan otomatis dikonversi jadi Clean HTML!' 
                                    : '<p>Tuliskan naskah berita liputan, kutipan wawancara narasumber, atau paste teks Markdown Anda di sini (otomatis diubah jadi Clean HTML)...</p>'" 
                                class="w-full flex-1 p-4 sm:p-5 bg-white focus:bg-white border-0 focus:ring-0 focus:outline-none text-slate-900 font-normal leading-relaxed placeholder:text-slate-400 font-sans resize-y min-h-[380px]"
                                :class="[
                                    fontSize, 
                                    isFullscreen ? 'h-full min-h-0 resize-none bg-slate-900 text-slate-100' : ''
                                ]"
                                @keydown.ctrl.b.prevent="editorMode === 'html' ? insertFormat('<strong>', '</strong>') : insertFormat('**', '**')"
                                @keydown.ctrl.i.prevent="editorMode === 'html' ? insertFormat('<em>', '</em>') : insertFormat('*', '*')"
                                @keydown.ctrl.k.prevent="insertLink()"
                            ></textarea>
                            
                            @error('isi_konten') 
                                <div class="px-4 py-2 bg-rose-50 text-xs text-rose-600 font-bold flex items-center gap-1 border-t border-rose-100">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                                </div> 
                            @enderror
                        </div>

                        <!-- Live Interactive Article Preview Panel (VIEW & SPLIT) -->
                        <div 
                            x-show="editorMode === 'view' || editorMode === 'split'" 
                            class="p-5 sm:p-7 bg-slate-50/70 overflow-y-auto max-h-[600px] space-y-4" 
                            :class="isFullscreen ? 'bg-slate-900 h-full max-h-none text-slate-100' : ''"
                        >
                            <!-- Header Info Simulation -->
                            <div class="space-y-2 pb-4 border-b" :class="isFullscreen ? 'border-slate-800' : 'border-slate-200/80'">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-emerald-600 text-white shadow-2xs">
                                        {{ $kategoriList->firstWhere('id', $kategori_id)?->nama_kategori ?? 'Kategori Berita' }}
                                    </span>
                                    @if($status_unggulan)
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-amber-500 text-white flex items-center gap-1 shadow-2xs">
                                            <i data-lucide="star" class="w-2.5 h-2.5 fill-white"></i>
                                            <span>Headline</span>
                                        </span>
                                    @endif
                                    <span class="text-[11px] font-bold ml-auto text-slate-400">
                                        {{ Carbon\Carbon::now()->translatedFormat('d F Y') }}
                                    </span>
                                </div>

                                <h2 class="text-xl sm:text-2xl font-black leading-snug tracking-tight" :class="isFullscreen ? 'text-white' : 'text-slate-900'">
                                    {{ $judul ?: 'Judul Naskah Berita Anda' }}
                                </h2>

                                @if($ringkasan)
                                    <div class="p-3.5 rounded-xl bg-emerald-500/10 border-l-4 border-emerald-600 text-xs sm:text-sm font-semibold leading-relaxed italic" :class="isFullscreen ? 'text-emerald-300' : 'text-slate-800'">
                                        {{ $ringkasan }}
                                    </div>
                                @endif
                            </div>

                            <!-- Thumbnail Preview in Article -->
                            <div class="rounded-xl overflow-hidden border border-slate-200 bg-white shadow-2xs">
                                @if($uploadGambar)
                                    <img src="{{ $uploadGambar->temporaryUrl() }}" class="w-full h-44 sm:h-64 object-cover" alt="Pratinjau Foto">
                                @elseif($gambar_utama)
                                    @php $prevUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($gambar_utama) ?? $gambar_utama @endphp
                                    <img src="{{ $prevUrl }}" class="w-full h-44 sm:h-64 object-cover" alt="Foto Berita">
                                @else
                                    <div class="h-32 bg-slate-100 flex flex-col items-center justify-center text-slate-400 gap-1">
                                        <i data-lucide="image" class="w-6 h-6 text-slate-300"></i>
                                        <span class="text-[11px] font-bold">(Thumbnail Foto Utama)</span>
                                    </div>
                                @endif
                                @if($keterangan_gambar)
                                    <div class="px-3 py-1.5 bg-slate-900/80 text-white text-[10px] font-medium italic text-center">
                                        {{ $keterangan_gambar }}
                                    </div>
                                @endif
                            </div>

                            <!-- Rendered HTML Live Article Content -->
                            <div class="prose prose-slate max-w-none text-xs sm:text-sm leading-relaxed font-normal" :class="isFullscreen ? 'prose-invert text-slate-200' : 'text-slate-800'">
                                @if(!empty(trim($isi_konten)))
                                    {!! $isi_konten !!}
                                @else
                                    <p class="text-slate-400 italic">Naskah isi konten berita yang Anda tulis akan muncul secara live di sini...</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- PRO STATUS BAR & METRICS (Ultra Clean) -->
                    @php
                        $wordCount = str_word_count(strip_tags($isi_konten));
                        $charCount = mb_strlen($isi_konten);
                        $parCount = !empty(trim($isi_konten)) ? count(preg_split('/\n+/', trim($isi_konten))) : 0;
                        $estRead = max(1, (int) ceil($wordCount / 200));
                    @endphp
                    <div 
                        class="px-4 py-2.5 border-t flex items-center justify-between text-xs font-medium flex-wrap gap-2.5 shrink-0"
                        :class="isFullscreen ? 'bg-slate-900 border-slate-800 text-slate-300' : 'bg-slate-50/70 border-slate-100 text-slate-600'"
                    >
                        <div class="flex items-center gap-3 font-semibold flex-wrap">
                            <span class="flex items-center gap-1.5" :class="isFullscreen ? 'text-white' : 'text-slate-900'">
                                <i data-lucide="file-text" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span><b>{{ number_format($wordCount) }}</b> Kata</span>
                            </span>
                            <span class="text-slate-300 dark:text-slate-700">•</span>
                            <span><b>{{ number_format($charCount) }}</b> Karakter</span>
                            <span class="text-slate-300 dark:text-slate-700">•</span>
                            <span><b>{{ $parCount }}</b> Paragraf</span>
                        </div>

                        <div class="flex items-center gap-2 flex-wrap">
                            <div class="flex items-center gap-1 text-emerald-700 dark:text-emerald-300 font-bold bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200/60 px-2 py-0.5 rounded-md text-[10px]">
                                <i data-lucide="clock" class="w-3 h-3 text-emerald-600"></i>
                                <span>Estimasi: ~{{ $estRead }} menit baca</span>
                            </div>
                            <div class="hidden sm:flex items-center gap-1 text-slate-400 text-[10px]">
                                <span>Shortcut: <b>Ctrl+B</b>, <b>Ctrl+I</b>, <b>Ctrl+K</b></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- RIGHT 4-COLS: PUBLISHING META, MEDIA & SEO AUDITOR        -->
        <!-- ========================================================= -->
        <div class="lg:col-span-4 space-y-3.5 sm:space-y-4">

            <!-- Card A: Status Publikasi & Jadwal (Ultra Clean) -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-xs space-y-4">
                
                <div class="flex items-center gap-2 pb-2.5 border-b border-slate-100">
                    <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center shrink-0">
                        <i data-lucide="send" class="w-3.5 h-3.5"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Status & Jadwal</h3>
                        <p class="text-[10px] text-slate-400">Pengaturan penayangan artikel</p>
                    </div>
                </div>

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
                        size="sm"
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

                <!-- Headline Switch (Clean Minimalist Design) -->
                <div class="p-3 rounded-xl bg-amber-50/60 border border-amber-200/80 flex items-start gap-2.5 transition-all">
                    <input 
                        type="checkbox" 
                        id="formUnggulanBerita" 
                        wire:model="status_unggulan" 
                        class="w-4 h-4 mt-0.5 rounded text-amber-600 focus:ring-amber-500 cursor-pointer"
                    >
                    <label for="formUnggulanBerita" class="cursor-pointer select-none min-w-0">
                        <span class="block text-xs font-black text-amber-950 flex items-center gap-1">
                            <i data-lucide="star" class="w-3.5 h-3.5 text-amber-500 fill-amber-400 shrink-0"></i>
                            <span>Jadikan Berita Utama (Headline)</span>
                        </span>
                        <span class="block text-[10px] text-amber-800/80 font-medium mt-0.5 leading-snug">
                            Tampilkan di carousel headline banner beranda portal.
                        </span>
                    </label>
                </div>
            </div>

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
