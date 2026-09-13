<div x-data="{ 
    lightbox: null, 
    currentIndex: 0,
    items: [],
    open(img, title, album, date, index) { 
        this.lightbox = { img, title, album, date }; 
        this.currentIndex = index;
        document.body.style.overflow = 'hidden';
    },
    close() {
        this.lightbox = null;
        document.body.style.overflow = 'auto';
    },
    next() {
        if (!this.items.length) return;
        this.currentIndex = (this.currentIndex + 1) % this.items.length;
        const nextItem = this.items[this.currentIndex];
        this.lightbox = { 
            img: nextItem.img, 
            title: nextItem.title, 
            album: nextItem.album, 
            date: nextItem.date 
        };
    },
    prev() {
        if (!this.items.length) return;
        this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
        const prevItem = this.items[this.currentIndex];
        this.lightbox = { 
            img: prevItem.img, 
            title: prevItem.title, 
            album: prevItem.album, 
            date: prevItem.date 
        };
    }
}" 
x-init="
    $watch('lightbox', value => {
        if (value && window.lucide) {
            setTimeout(() => window.lucide.createIcons(), 50);
        }
    })
">
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="camera" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Dokumentasi Visual & Galeri</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Galeri <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Aksi & Kegiatan</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Dokumentasi visual semarak festival olahraga rekreasi, kejuaraan, pengukuhan, dan aktivitas komunitas binaan KORMI Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. STICKY FILTER ALBUM BAR --}}
    <section class="py-5 bg-white/95 backdrop-blur-md sticky top-16 md:top-20 z-30 border-b border-slate-100 shadow-sm shadow-slate-100/50">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1 w-full md:w-auto">
                    <button 
                        wire:click="filterAlbum('Semua')"
                        class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap flex items-center gap-1.5 {{ $albumDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        <i data-lucide="layers" class="w-3.5 h-3.5 {{ $albumDipilih === 'Semua' ? 'text-emerald-400' : 'text-slate-400' }}"></i>
                        <span>Semua Album</span>
                    </button>
                    @foreach($albumList as $album)
                        <button 
                            wire:click="filterAlbum('{{ $album->judul_album }}')"
                            class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap flex items-center gap-1.5 {{ $albumDipilih === $album->judul_album ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                        >
                            <i data-lucide="folder" class="w-3.5 h-3.5 {{ $albumDipilih === $album->judul_album ? 'text-lime-300' : 'text-slate-400' }}"></i>
                            <span>{{ $album->judul_album }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="hidden sm:flex items-center gap-2 text-xs font-bold text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Menampilkan <strong class="text-slate-700">{{ $fotoList->count() }}</strong> Dokumentasi Foto</span>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. GALLERY PHOTO MOSAIC GRID --}}
    <section class="py-12 bg-slate-50/50 min-h-[50vh]">
        <div class="container mx-auto px-6 max-w-7xl">
            @if($fotoList->isNotEmpty())
                {{-- JSON Items for Alpine navigation --}}
                <div x-init="items = {{ json_encode($fotoList->map(fn($item, $idx) => [
                    'index' => $idx,
                    'img' => $item->foto_url,
                    'title' => $item->judul_foto,
                    'album' => $item->album->judul_album ?? 'Kegiatan KORMI',
                    'date' => \Carbon\Carbon::parse($item->album->tanggal_kegiatan ?? $item->created_at ?? now())->translatedFormat('d M Y')
                ])) }};"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 auto-rows-[240px]">
                    @foreach($fotoList as $index => $item)
                        @php
                            $gridClass = 'col-span-1 row-span-1';
                            if ($albumDipilih === 'Semua' && !empty($item->tipe_grid) && $item->tipe_grid !== 'normal') {
                                if (str_contains($item->tipe_grid, 'col-span-2') && str_contains($item->tipe_grid, 'row-span-2')) {
                                    $gridClass = 'col-span-1 sm:col-span-2 row-span-1 sm:row-span-2';
                                } elseif (str_contains($item->tipe_grid, 'col-span-2')) {
                                    $gridClass = 'col-span-1 sm:col-span-2 row-span-1';
                                } elseif (str_contains($item->tipe_grid, 'row-span-2')) {
                                    $gridClass = 'col-span-1 row-span-1 sm:row-span-2';
                                }
                            }
                        @endphp
                        
                        <div 
                            class="{{ $gridClass }} group relative overflow-hidden rounded-3xl bg-white border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 cursor-pointer"
                            @click="open('{{ $item->foto_url }}', '{{ addslashes($item->judul_foto) }}', '{{ addslashes($item->album->judul_album ?? 'Kegiatan KORMI') }}', '{{ \Carbon\Carbon::parse($item->album->tanggal_kegiatan ?? $item->created_at ?? now())->translatedFormat('d M Y') }}', {{ $index }})"
                        >
                            {{-- Image with smooth zoom --}}
                            <img 
                                src="{{ $item->foto_url }}" 
                                class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" 
                                alt="{{ $item->judul_foto }}"
                                loading="lazy"
                                onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'"
                            />
                            
                            {{-- Gradient Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-5">
                                <div class="transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-emerald-500/90 text-white backdrop-blur-sm">
                                            {{ $item->album->judul_album ?? 'Kegiatan' }}
                                        </span>
                                        <span class="text-[10px] font-semibold text-slate-300">
                                            {{ \Carbon\Carbon::parse($item->album->tanggal_kegiatan ?? $item->created_at ?? now())->translatedFormat('M Y') }}
                                        </span>
                                    </div>
                                    <h3 class="text-white text-sm md:text-base font-black leading-snug drop-shadow-sm">
                                        {{ $item->judul_foto }}
                                    </h3>
                                </div>
                            </div>

                            {{-- Corner Action Indicator --}}
                            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="w-9 h-9 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/30 shadow-lg group-hover:scale-110 transition-transform">
                                    <i data-lucide="maximize-2" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-lg mx-auto shadow-sm my-8">
                    <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mx-auto mb-4 border border-emerald-100">
                        <i data-lucide="image-off" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 uppercase">Belum Ada Foto</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-6">Belum ada dokumentasi foto yang diunggah untuk album pilihan ini.</p>
                    <button wire:click="filterAlbum('Semua')" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-emerald-600 transition-colors inline-flex items-center gap-2">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Lihat Semua Album</span>
                    </button>
                </div>
            @endif
        </div>
    </section>

    {{-- 4. ULTRA-PRO LIGHTBOX MODAL (Alpine.js) --}}
    <div 
        x-show="lightbox" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-[200] bg-slate-950/95 backdrop-blur-xl flex items-center justify-center p-4 md:p-8"
        style="display: none;"
        @keydown.escape.window="close()"
        @keydown.arrow-right.window="next()"
        @keydown.arrow-left.window="prev()"
    >
        {{-- Close Button --}}
        <button 
            @click="close()" 
            class="absolute top-5 right-5 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all duration-200 z-50 border border-white/15"
            title="Tutup (Esc)"
        >
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        {{-- Prev Button --}}
        <button 
            @click.stop="prev()" 
            class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center transition-all duration-200 z-50 border border-white/15 hover:scale-105"
            title="Sebelumnya (Panah Kiri)"
        >
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </button>

        {{-- Next Button --}}
        <button 
            @click.stop="next()" 
            class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center transition-all duration-200 z-50 border border-white/15 hover:scale-105"
            title="Berikutnya (Panah Kanan)"
        >
            <i data-lucide="chevron-right" class="w-6 h-6"></i>
        </button>

        {{-- Lightbox Content --}}
        <div class="max-w-6xl max-h-[92vh] w-full flex flex-col items-center justify-center" @click.outside="close()">
            <template x-if="lightbox">
                <div class="w-full flex flex-col items-center space-y-4">
                    {{-- Active Image View --}}
                    <div class="relative max-h-[72vh] flex items-center justify-center rounded-2xl overflow-hidden shadow-2xl bg-black/40 border border-white/10">
                        <img 
                            :src="lightbox.img" 
                            :alt="lightbox.title" 
                            class="max-h-[72vh] max-w-full w-auto object-contain rounded-2xl"
                        >
                    </div>

                    {{-- Metadata & Caption Bar --}}
                    <div class="text-center max-w-2xl px-4 py-2 bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 w-full">
                        <div class="flex items-center justify-center gap-2 mb-1">
                            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-400" x-text="lightbox.album"></span>
                            <span class="text-white/40">•</span>
                            <span class="text-[10px] font-semibold text-slate-300" x-text="lightbox.date"></span>
                        </div>
                        <h4 class="text-sm md:text-base font-black text-white" x-text="lightbox.title"></h4>
                        <div class="text-[10px] text-slate-400 mt-1">
                            Gunakan tombol panah keyboard (← / →) atau tombol di samping untuk menavigasi foto.
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

