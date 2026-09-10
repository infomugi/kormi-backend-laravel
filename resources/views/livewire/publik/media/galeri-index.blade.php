<div x-data="{ lightbox: null, open(img, title, album, date) { this.lightbox = { img, title, album, date }; } }">
    {{-- HERO SECTION --}}
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2000" class="w-full h-full object-cover opacity-20" alt="Hero">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-purple-500/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="max-w-4xl space-y-4 reveal active">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-4">
                    <i data-lucide="camera" class="w-4 h-4 text-purple-400"></i>
                    <span class="text-xs font-bold text-white tracking-widest uppercase">Dokumentasi</span>
                </div>
                <h1 class="text-4xl md:text-6xl font-black leading-[1.1] tracking-tighter text-white uppercase">
                    Galeri <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">Kegiatan</span>
                </h1>
                <p class="text-base md:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed opacity-90 pt-4">
                    Dokumentasi foto kegiatan olahraga rekreasi masyarakat KORMI Kabupaten Bandung.
                </p>
            </div>
        </div>
    </section>

    {{-- FILTER ALBUM --}}
    <section class="py-8 bg-white sticky top-[88px] z-30 border-b border-slate-100 backdrop-blur-md bg-white/95">
        <div class="container mx-auto px-6 md:px-12">
            <div class="flex flex-wrap gap-3 justify-center">
                <button 
                    wire:click="filterAlbum('Semua')"
                    class="px-5 py-2.5 rounded-full text-[11px] font-black uppercase tracking-widest transition-all {{ $albumDipilih === 'Semua' ? 'bg-bedasGreen text-white shadow-lg shadow-bedasGreen/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    Semua
                </button>
                @foreach($albumList as $album)
                    <button 
                        wire:click="filterAlbum('{{ $album->judul_album }}')"
                        class="px-5 py-2.5 rounded-full text-[11px] font-black uppercase tracking-widest transition-all {{ $albumDipilih === $album->judul_album ? 'bg-bedasGreen text-white shadow-lg shadow-bedasGreen/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        {{ $album->judul_album }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- GALLERY GRID --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 md:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 auto-rows-[220px]">
                @forelse($fotoList as $item)
                    <div 
                        class="{{ $albumDipilih === 'Semua' && $item->tipe_grid !== 'normal' ? $item->tipe_grid : 'col-span-1 row-span-1' }} relative group overflow-hidden rounded-3xl shadow-lg cursor-pointer bg-slate-100"
                        @click="open('{{ $item->gambar_url }}', '{{ addslashes($item->judul_foto) }}', '{{ addslashes($item->album->judul_album ?? '') }}', '{{ \Carbon\Carbon::parse($item->album->tanggal_kegiatan ?? now())->translatedFormat('M Y') }}')"
                    >
                        <img src="{{ $item->gambar_url }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $item->judul_foto }}">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
                            <span class="text-[9px] font-black text-white/70 uppercase tracking-widest mb-1">
                                {{ $item->album->judul_album ?? 'Kegiatan' }} • {{ \Carbon\Carbon::parse($item->album->tanggal_kegiatan ?? now())->translatedFormat('M Y') }}
                            </span>
                            <h3 class="text-white text-sm md:text-base font-black uppercase leading-tight">{{ $item->judul_foto }}</h3>
                        </div>

                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center">
                                <i data-lucide="maximize-2" class="w-5 h-5 text-white"></i>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <i data-lucide="image" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                        <p class="text-slate-500 font-bold">Belum ada foto dalam album ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- LIGHTBOX MODAL (Alpine.js) --}}
    <div 
        x-show="lightbox" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[200] bg-black/95 backdrop-blur-md flex items-center justify-center p-4 md:p-8"
        style="display: none;"
        @keydown.escape.window="lightbox = null"
    >
        <button 
            @click="lightbox = null" 
            class="absolute top-6 right-6 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors z-10"
        >
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>

        <div class="max-w-5xl max-h-[90vh] flex flex-col items-center" @click.outside="lightbox = null">
            <template x-if="lightbox">
                <div class="space-y-4 text-center">
                    <img :src="lightbox.img" :alt="lightbox.title" class="max-h-[75vh] w-auto rounded-2xl shadow-2xl object-contain mx-auto">
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-purple-400 uppercase tracking-widest" x-text="lightbox.album + ' • ' + lightbox.date"></span>
                        <h4 class="text-lg md:text-xl font-black text-white" x-text="lightbox.title"></h4>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
