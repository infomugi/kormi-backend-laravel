<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1450133064473-71024230f91b?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="folder-down" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Repositori & Dokumen Publik</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Pusat <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Unduhan & Regulasi</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Akses resmi dokumen Anggaran Dasar / ART, Surat Keputusan, petunjuk teknis kejuaraan, format laporan, dan berkas kelembagaan KORMI Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. STICKY FILTER & SEARCH TOOLBAR --}}
    <section class="py-5 bg-white/95 backdrop-blur-md sticky top-16 md:top-20 z-30 border-b border-slate-100 shadow-sm shadow-slate-100/50">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                {{-- Category Tabs --}}
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
                    <button 
                        wire:click="$set('kategoriDipilih', 'Semua')" 
                        class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap flex items-center gap-1.5 {{ $kategoriDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        <i data-lucide="layers" class="w-3.5 h-3.5 {{ $kategoriDipilih === 'Semua' ? 'text-emerald-400' : 'text-slate-400' }}"></i>
                        <span>Semua Berkas</span>
                    </button>
                    @foreach($kategoriList as $kat)
                        <button 
                            wire:click="$set('kategoriDipilih', '{{ $kat->slug }}')" 
                            class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap flex items-center gap-1.5 {{ $kategoriDipilih === $kat->slug ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                        >
                            <i data-lucide="file-text" class="w-3.5 h-3.5 {{ $kategoriDipilih === $kat->slug ? 'text-lime-300' : 'text-slate-400' }}"></i>
                            <span>{{ $kat->nama_kategori }}</span>
                        </button>
                    @endforeach
                </div>

                {{-- Live Search Input --}}
                <div class="relative w-full md:w-80 shrink-0">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="Ketik nama berkas / kata kunci..." 
                        class="w-full bg-slate-50 border border-slate-200/90 rounded-2xl px-4 py-2.5 pl-10 text-xs font-bold text-slate-800 placeholder:text-slate-400 placeholder:font-normal focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm"
                    />
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    @if(!empty($cari))
                        <button wire:click="$set('cari', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- 3. CONTENT LIST SECTION --}}
    <section class="py-12 bg-slate-50/50 min-h-[50vh]">
        <div class="container mx-auto px-6 max-w-6xl">
            {{-- Search & Result Indicator --}}
            <div class="flex items-center justify-between gap-4 mb-6">
                <div class="text-xs font-bold text-slate-500">
                    Menampilkan <strong class="text-slate-800">{{ $dokumenList->total() }}</strong> berkas dokumen
                    @if(!empty($cari))
                        dengan kata kunci "<span class="text-emerald-600">{{ $cari }}</span>"
                    @endif
                </div>
                <div class="text-[11px] font-semibold text-slate-400 hidden sm:flex items-center gap-1.5">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-500"></i>
                    <span>Semua berkas terverifikasi resmi KORMI</span>
                </div>
            </div>

            {{-- Document Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                @forelse($dokumenList as $doc)
                    @php
                        $ext = strtoupper($doc->ekstensi_berkas ?: 'PDF');
                        $extBadge = match($ext) {
                            'PDF' => 'bg-rose-50 text-rose-700 border-rose-200',
                            'DOC', 'DOCX' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'XLS', 'XLSX' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'ZIP', 'RAR' => 'bg-amber-50 text-amber-700 border-amber-200',
                            default => 'bg-purple-50 text-purple-700 border-purple-200',
                        };
                        $iconName = match($ext) {
                            'PDF' => 'file-text',
                            'DOC', 'DOCX' => 'file-edit',
                            'XLS', 'XLSX' => 'file-spreadsheet',
                            'ZIP', 'RAR' => 'archive',
                            default => 'file',
                        };
                    @endphp
                    
                    <div class="group bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            {{-- Top Header Card: Icon + Category Badge + Ext --}}
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm shrink-0 group-hover:scale-105 transition-transform">
                                        <i data-lucide="{{ $doc->nama_ikon ?: $iconName }}" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200/80">
                                            {{ $doc->kategori->nama_kategori ?? 'Dokumen Umum' }}
                                        </span>
                                    </div>
                                </div>

                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black tracking-wider uppercase border {{ $extBadge }}">
                                    {{ $ext }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-sm md:text-base font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition-colors line-clamp-2">
                                {{ $doc->judul_dokumen }}
                            </h3>

                            @if(!empty($doc->deskripsi))
                                <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">
                                    {{ $doc->deskripsi }}
                                </p>
                            @endif
                        </div>

                        {{-- Footer Card: Meta Details & Download Button --}}
                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 text-[11px] font-bold text-slate-400">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="hard-drive" class="w-3.5 h-3.5 text-slate-400"></i>
                                    {{ $doc->ukuran_berkas ?: '1.2 MB' }}
                                </span>
                                <span>•</span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="download" class="w-3.5 h-3.5 text-emerald-500"></i>
                                    {{ number_format($doc->jumlah_unduhan) }}x unduh
                                </span>
                            </div>

                            <button 
                                wire:click="unduhBerkas('{{ $doc->id }}')" 
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 hover:shadow-lg transition-all duration-200 active:scale-95 shrink-0"
                            >
                                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                <span>Unduh Berkas</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-md mx-auto shadow-sm my-6">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-4 border border-slate-200">
                            <i data-lucide="file-search" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 uppercase">Dokumen Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-6">Tidak ada berkas atau regulasi yang sesuai dengan filter dan kata kunci pencarian Anda.</p>
                        <button wire:click="$set('cari', ''); $set('kategoriDipilih', 'Semua')" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-emerald-600 transition-colors inline-flex items-center gap-2">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span>Reset Pencarian</span>
                        </button>
                    </div>
                @endforelse
            </div>

            {{-- Pagination Links --}}
            @if($dokumenList->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $dokumenList->links() }}
                </div>
            @endif
        </div>
    </section>
</div>

