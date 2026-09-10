<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gradient-to-r from-emerald-900 via-teal-900 to-emerald-800 p-6 md:p-8 rounded-3xl text-white shadow-xl relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 text-emerald-300 text-xs font-bold uppercase tracking-widest mb-2">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>Manajemen Agenda & Pertandingan</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight">Kelola Event & Festival FORKAB</h1>
            <p class="text-emerald-100/80 text-sm mt-1 max-w-xl">
                Kelola kalender kejuaraan, festival olahraga masyarakat, cabang perlombaan Inorga, dan jadwal tahapan pertandingan.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3 relative z-10">
            <button wire:click="bukaModalKelolaKategori" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-2xl font-bold text-xs flex items-center gap-2 border border-white/15 transition-all cursor-pointer shadow-sm">
                <i data-lucide="tag" class="w-4 h-4 text-emerald-300"></i>
                <span>Kategori Event</span>
            </button>
            @if($mode === 'tabel')
                <button wire:click="bukaFormTambahEvent" class="px-5 py-2.5 bg-gradient-to-r from-lime-400 to-emerald-400 text-emerald-950 hover:brightness-105 rounded-2xl font-extrabold text-xs flex items-center gap-2 transition-all cursor-pointer shadow-lg shadow-lime-500/20">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Event Baru</span>
                </button>
            @else
                <button wire:click="kembaliKeTabel" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-2xl font-bold text-xs flex items-center gap-2 border border-white/15 transition-all cursor-pointer">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Kembali ke Daftar</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Flash Notification -->
    @if (session()->has('pesan'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-xs animate-fade-in">
            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                <i data-lucide="check" class="w-5 h-5"></i>
            </div>
            <p class="text-xs font-bold">{{ session('pesan') }}</p>
        </div>
    @endif

    {{-- ==========================================
         MODE 1: TABEL DAFTAR EVENT
         ========================================== --}}
    @if($mode === 'tabel')
        <!-- Stat Badges -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-5 bg-white rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="trophy" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500">Total Agenda Event</p>
                    <h3 class="text-xl font-black text-slate-900 mt-0.5">{{ $totalEvent }} Event</h3>
                </div>
            </div>
            <div class="p-5 bg-white rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500">Total Cabang Dipertandingkan</p>
                    <h3 class="text-xl font-black text-slate-900 mt-0.5">{{ $totalCabang }} Cabang</h3>
                </div>
            </div>
            <div class="p-5 bg-white rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-lime-50 text-lime-600 flex items-center justify-center shrink-0">
                    <i data-lucide="globe" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500">Status Publikasi Aktif</p>
                    <h3 class="text-xl font-black text-slate-900 mt-0.5">{{ $totalPublish }} Tayang</h3>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-white p-4 rounded-3xl border border-slate-200/80 shadow-xs">
            <div class="relative w-full sm:w-80">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input type="text" wire:model.live.debounce.300ms="cari" placeholder="Cari nama event / lokasi..." class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0">
                <button wire:click="$set('kategoriDipilih', 'Semua')" class="px-3 py-1.5 rounded-xl font-bold text-xs whitespace-nowrap transition-all {{ $kategoriDipilih === 'Semua' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua ({{ $totalEvent }})
                </button>
                @foreach($kategoriList as $kat)
                    <button wire:click="$set('kategoriDipilih', '{{ $kat->id }}')" class="px-3 py-1.5 rounded-xl font-bold text-xs whitespace-nowrap transition-all {{ $kategoriDipilih === $kat->id ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $kat->nama_kategori }} ({{ $kat->events_count }})
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Grid Cards of Events -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse($eventList as $ev)
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-all group">
                    <div>
                        <!-- Event Banner / Placeholder -->
                        <div class="relative h-40 bg-gradient-to-tr from-emerald-950 to-teal-900 overflow-hidden">
                            @if($ev->banner_url)
                                <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($ev->banner_url) }}" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300" alt="{{ $ev->judul_event }}">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-emerald-300/40 p-4 text-center">
                                    <i data-lucide="trophy" class="w-12 h-12 mb-1"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider">Tanpa Banner</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex items-center gap-1.5">
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-500/90 text-white font-black text-[10px] backdrop-blur-md">
                                    {{ $ev->tahun_edisi }}
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-black/60 text-white font-bold text-[10px] backdrop-blur-md">
                                    {{ $ev->kategoriEvent?->nama_kategori ?? 'Umum' }}
                                </span>
                            </div>

                            <div class="absolute top-3 right-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $ev->status_publikasi ? 'bg-lime-400 text-slate-950' : 'bg-slate-700 text-slate-300' }}">
                                    {{ $ev->status_publikasi ? 'Tayang' : 'Draft' }}
                                </span>
                            </div>

                            <!-- Date Overlay -->
                            <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-xs font-semibold">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-lime-400"></i>
                                    {{ $ev->tanggal_mulai ? $ev->tanggal_mulai->format('d M') : '-' }} - {{ $ev->tanggal_selesai ? $ev->tanggal_selesai->format('d M Y') : '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5">
                            <h3 class="font-black text-slate-900 text-base leading-snug line-clamp-2 mb-2 group-hover:text-emerald-700 transition-colors">
                                {{ $ev->judul_event }}
                            </h3>
                            <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-3">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                <span class="truncate">{{ $ev->lokasi_utama }}</span>
                            </p>

                            <!-- Quick Stats -->
                            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-slate-100 text-center">
                                <div class="p-2 bg-slate-50 rounded-xl">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Cabang</span>
                                    <p class="text-xs font-black text-slate-800">{{ $ev->cabang->count() }} Inorga</p>
                                </div>
                                <div class="p-2 bg-slate-50 rounded-xl">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Jadwal</span>
                                    <p class="text-xs font-black text-slate-800">{{ $ev->jadwal->count() }} Tahapan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2">
                        <button wire:click="bukaDetailEvent('{{ $ev->id }}')" class="flex-1 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs flex items-center justify-center gap-1.5 transition-all cursor-pointer shadow-xs">
                            <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                            <span>Kelola Cabang & Jadwal</span>
                        </button>
                        <button wire:click="bukaFormEditEvent('{{ $ev->id }}')" title="Edit Event" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 hover:text-emerald-700 transition-all cursor-pointer">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </button>
                        <button wire:click="hapusEvent('{{ $ev->id }}')" wire:confirm="Yakin ingin menghapus event ini? Semua cabang dan jadwal terkait akan ikut terhapus." title="Hapus Event" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition-all cursor-pointer">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="calendar-x" class="w-8 h-8"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base">Belum Ada Agenda Event</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Klik tombol "Tambah Event Baru" untuk membuat agenda FORKAB, FORPROV, atau festival olahraga baru.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $eventList->links() }}
        </div>
    @endif

    {{-- ==========================================
         MODE 2: FORM TAMBAH / EDIT EVENT UTAMA
         ========================================== --}}
    @if($mode === 'form_event')
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 md:p-8">
            <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2">
                <i data-lucide="edit-3" class="w-5 h-5 text-emerald-600"></i>
                <span>{{ $editEventId ? 'Edit Data Event' : 'Tambah Event Baru' }}</span>
            </h2>

            <form wire:submit="simpanEvent" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Judul Event -->
                    <div class="md:col-span-2 space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Judul Event / Festival *</label>
                        <input type="text" wire:model.live.debounce.300ms="judulEvent" wire:model="judul_event" placeholder="Contoh: FORKAB Kabupaten Bandung Ke-IV 2026" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                        @error('judul_event') <p class="text-[11px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kategori Event -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Kategori *</label>
                        <select wire:model="kategori_event_id" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_event_id') <p class="text-[11px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Slug URL -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Slug URL</label>
                        <input type="text" wire:model="slug" placeholder="forkab-kabupaten-bandung-2026" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                        @error('slug') <p class="text-[11px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tahun Edisi -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Tahun Edisi *</label>
                        <input type="number" wire:model="tahun_edisi" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                        @error('tahun_edisi') <p class="text-[11px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Lokasi Utama -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Lokasi / Venue Utama *</label>
                        <input type="text" wire:model="lokasi_utama" placeholder="Contoh: Stadion Si Jalak Harupat, Kutawaringin" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                        @error('lokasi_utama') <p class="text-[11px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Tanggal Mulai *</label>
                        <input type="date" wire:model="tanggal_mulai" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                        @error('tanggal_mulai') <p class="text-[11px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Tanggal Selesai *</label>
                        <input type="date" wire:model="tanggal_selesai" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                        @error('tanggal_selesai') <p class="text-[11px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status Publikasi -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Status Tayang</label>
                        <select wire:model="status_publikasi" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                            <option value="1">Publikasi (Tayang di Portal)</option>
                            <option value="0">Draft (Sembunyikan Sementara)</option>
                        </select>
                    </div>

                    <!-- Upload Banner -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Banner Utama (JPG/PNG/WEBP, Max 5MB)</label>
                        <input type="file" wire:model="uploadBanner" accept="image/*" class="w-full px-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        @if($banner_url && !$uploadBanner)
                            <p class="text-[10px] text-emerald-600 font-bold">Banner tersimpan: {{ basename($banner_url) }}</p>
                        @endif
                        @error('uploadBanner') <p class="text-[11px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Upload Logo Event -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Logo / Maskot Event (Max 3MB)</label>
                        <input type="file" wire:model="uploadLogo" accept="image/*" class="w-full px-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        @if($logo_event_url && !$uploadLogo)
                            <p class="text-[10px] text-emerald-600 font-bold">Logo tersimpan: {{ basename($logo_event_url) }}</p>
                        @endif
                        @error('uploadLogo') <p class="text-[11px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tautan Eksternal -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Tautan Web / Pendaftaran Eksternal</label>
                        <input type="url" wire:model="tautan_eksternal" placeholder="https://..." class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                        @error('tautan_eksternal') <p class="text-[11px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Deskripsi Lengkap -->
                    <div class="md:col-span-3 space-y-1.5">
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider">Deskripsi & Gambaran Umum Event</label>
                        <textarea wire:model="deskripsi_lengkap" rows="5" placeholder="Tuliskan latar belakang, tujuan, ketentuan umum, dan rangkaian kegiatan..." class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" wire:click="kembaliKeTabel" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs flex items-center gap-2 transition-all cursor-pointer shadow-lg shadow-emerald-600/20">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- ==========================================
         MODE 3: DETAIL EVENT (CABANG & JADWAL)
         ========================================== --}}
    @if($mode === 'detail_event' && $activeEvent)
        <div class="space-y-6">
            <!-- Active Event Summary Bar -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 text-[10px] font-black">
                            {{ $activeEvent->tahun_edisi }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-700 text-[10px] font-bold">
                            {{ $activeEvent->kategoriEvent?->nama_kategori }}
                        </span>
                    </div>
                    <h2 class="text-xl font-black text-slate-900">{{ $activeEvent->judul_event }}</h2>
                    <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-2">
                        <span><i data-lucide="map-pin" class="w-3.5 h-3.5 inline text-slate-400"></i> {{ $activeEvent->lokasi_utama }}</span>
                        <span>•</span>
                        <span><i data-lucide="calendar" class="w-3.5 h-3.5 inline text-slate-400"></i> {{ $activeEvent->tanggal_mulai?->format('d M') }} - {{ $activeEvent->tanggal_selesai?->format('d M Y') }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click="bukaFormEditEvent('{{ $activeEvent->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs flex items-center gap-1.5 transition-all cursor-pointer">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        <span>Edit Info Event</span>
                    </button>
                    <button wire:click="kembaliKeTabel" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-xs flex items-center gap-1.5 transition-all cursor-pointer">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Kembali</span>
                    </button>
                </div>
            </div>

            <!-- Flash Pesan Sub -->
            @if(session()->has('pesan_sub'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-xs">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                    <p class="text-xs font-bold">{{ session('pesan_sub') }}</p>
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                <button wire:click="$set('tabAktif', 'cabang')" class="px-5 py-2.5 rounded-2xl font-black text-xs flex items-center gap-2 transition-all cursor-pointer {{ $tabAktif === 'cabang' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i data-lucide="award" class="w-4 h-4"></i>
                    <span>Cabang Lomba ({{ $activeEvent->cabang->count() }})</span>
                </button>
                <button wire:click="$set('tabAktif', 'jadwal')" class="px-5 py-2.5 rounded-2xl font-black text-xs flex items-center gap-2 transition-all cursor-pointer {{ $tabAktif === 'jadwal' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    <span>Jadwal & Tahapan ({{ $activeEvent->jadwal->count() }})</span>
                </button>
                <button wire:click="$set('tabAktif', 'info')" class="px-5 py-2.5 rounded-2xl font-black text-xs flex items-center gap-2 transition-all cursor-pointer {{ $tabAktif === 'info' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    <span>Ringkasan & Juknis</span>
                </button>
            </div>

            {{-- TAB: CABANG LOMBA --}}
            @if($tabAktif === 'cabang')
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider">Daftar Cabang Olahraga / Lomba Dipertandingkan</h3>
                        <button wire:click="bukaModalTambahCabang" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs flex items-center gap-2 transition-all cursor-pointer shadow-xs">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            <span>Tambah Cabang</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($activeEvent->cabang as $cab)
                            <div class="p-5 bg-white rounded-3xl border border-slate-200/80 shadow-xs flex flex-col justify-between hover:border-emerald-300 transition-all">
                                <div>
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                            <i data-lucide="{{ $cab->ikon ?? 'award' }}" class="w-5 h-5"></i>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[10px] font-bold truncate max-w-[140px]">
                                            {{ $cab->inorga?->singkatan ?? 'Non-Inorga' }}
                                        </span>
                                    </div>
                                    <h4 class="font-black text-slate-900 text-sm leading-snug mb-1">{{ $cab->nama_cabang }}</h4>
                                    <p class="text-xs text-slate-500 mb-2">Kategori: <strong class="text-slate-700">{{ $cab->kategori_peserta }}</strong></p>
                                    @if($cab->aturan_juknis_url)
                                        <a href="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($cab->aturan_juknis_url) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 hover:text-emerald-700 mb-2">
                                            <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                            <span>Unduh Dokumen Juknis</span>
                                        </a>
                                    @endif
                                </div>

                                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 mt-2">
                                    <button wire:click="bukaModalEditCabang('{{ $cab->id }}')" class="p-1.5 text-slate-500 hover:text-emerald-600 transition-colors cursor-pointer" title="Edit Cabang">
                                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                                    </button>
                                    <button wire:click="hapusCabang('{{ $cab->id }}')" wire:confirm="Hapus cabang lomba ini?" class="p-1.5 text-slate-500 hover:text-rose-600 transition-colors cursor-pointer" title="Hapus Cabang">
                                        <i data-lucide="trash" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white p-8 rounded-3xl border border-slate-200 text-center">
                                <p class="text-xs text-slate-500 font-bold">Belum ada cabang lomba yang didaftarkan pada event ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- TAB: JADWAL & TAHAPAN --}}
            @if($tabAktif === 'jadwal')
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider">Rundown & Jadwal Pelaksanaan</h3>
                        <button wire:click="bukaModalTambahJadwal" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs flex items-center gap-2 transition-all cursor-pointer shadow-xs">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            <span>Tambah Jadwal</span>
                        </button>
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black uppercase text-slate-500 tracking-wider">
                                    <th class="p-4">Fase / Tahapan</th>
                                    <th class="p-4">Tanggal & Waktu</th>
                                    <th class="p-4">Nama Kegiatan / Lomba</th>
                                    <th class="p-4">Lokasi / Arena</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium">
                                @forelse($activeEvent->jadwal as $jdw)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="p-4 font-black text-slate-800">{{ $jdw->fase_tahapan }}</td>
                                        <td class="p-4 text-slate-600 whitespace-nowrap">
                                            <div>{{ $jdw->tanggal ? $jdw->tanggal->format('d M Y') : '-' }}</div>
                                            <div class="text-[11px] text-slate-400">{{ substr($jdw->jam_mulai, 0, 5) }} - {{ substr($jdw->jam_selesai, 0, 5) }} WIB</div>
                                        </td>
                                        <td class="p-4 font-bold text-slate-900">{{ $jdw->nama_kegiatan }}</td>
                                        <td class="p-4 text-slate-600">{{ $jdw->tempat_arena }}</td>
                                        <td class="p-4">
                                            @if($jdw->status_tahapan === 'selesai')
                                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px]">Selesai</span>
                                            @elseif($jdw->status_tahapan === 'berlangsung')
                                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px] animate-pulse">Berlangsung</span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 font-bold text-[10px]">Akan Datang</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-right whitespace-nowrap">
                                            <button wire:click="bukaModalEditJadwal('{{ $jdw->id }}')" class="p-1.5 text-slate-500 hover:text-emerald-600 transition-colors cursor-pointer" title="Edit Jadwal">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </button>
                                            <button wire:click="hapusJadwal('{{ $jdw->id }}')" wire:confirm="Hapus jadwal kegiatan ini?" class="p-1.5 text-slate-500 hover:text-rose-600 transition-colors cursor-pointer" title="Hapus Jadwal">
                                                <i data-lucide="trash" class="w-4 h-4"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-slate-400 font-bold">Belum ada jadwal pertandingan yang tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- TAB: INFO & DESKRIPSI --}}
            @if($tabAktif === 'info')
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">
                    <div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Gambaran Umum</h4>
                        <div class="prose prose-sm text-slate-700 max-w-none">
                            {!! nl2br(e($activeEvent->deskripsi_lengkap ?? 'Belum ada deskripsi lengkap.')) !!}
                        </div>
                    </div>

                    @if($activeEvent->tautan_eksternal)
                        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200/80 flex items-center justify-between">
                            <span class="text-xs font-bold text-emerald-900">Tautan Resmi Pendaftaran / Portal Luar:</span>
                            <a href="{{ $activeEvent->tautan_eksternal }}" target="_blank" class="px-4 py-1.5 bg-emerald-600 text-white rounded-xl font-extrabold text-xs flex items-center gap-1.5 hover:bg-emerald-700">
                                <span>Buka Tautan</span>
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif

    {{-- ==========================================
         MODAL: TAMBAH / EDIT CABANG LOMBA
         ========================================== --}}
    @if($bukaModalCabang)
        <div class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 animate-scale-up">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                        <i data-lucide="award" class="w-5 h-5 text-emerald-600"></i>
                        <span>{{ $editCabangId ? 'Edit Cabang Lomba' : 'Tambah Cabang Lomba' }}</span>
                    </h3>
                    <button wire:click="$set('bukaModalCabang', false)" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form wire:submit="simpanCabang" class="space-y-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Nama Cabang / Pertandingan *</label>
                        <input type="text" wire:model="cabang_nama" placeholder="Contoh: Senam Tera Indonesia (STI) Perorangan" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500">
                        @error('cabang_nama') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Afiliasi Inorga (Opsional)</label>
                        <select wire:model="cabang_inorga_id" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500">
                            <option value="">-- Umum / Non-Inorga --</option>
                            @foreach($inorgaList as $ino)
                                <option value="{{ $ino->id }}">{{ $ino->singkatan }} - {{ $ino->nama_inorga }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Kategori Peserta</label>
                        <input type="text" wire:model="cabang_kategori_peserta" placeholder="Contoh: Umum, Usia 40+, Pelajar" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Dokumen Juknis / Petunjuk Teknis (PDF/DOC, Max 10MB)</label>
                        <input type="file" wire:model="uploadJuknis" accept=".pdf,.doc,.docx" class="w-full px-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        @if($cabang_juknis_url && !$uploadJuknis)
                            <p class="text-[10px] text-emerald-600 font-bold">File tersimpan: {{ basename($cabang_juknis_url) }}</p>
                        @endif
                        @error('uploadJuknis') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" wire:click="$set('bukaModalCabang', false)" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs cursor-pointer">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ==========================================
         MODAL: TAMBAH / EDIT JADWAL TAHAPAN
         ========================================== --}}
    @if($bukaModalJadwal)
        <div class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 animate-scale-up">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                        <i data-lucide="clock" class="w-5 h-5 text-emerald-600"></i>
                        <span>{{ $editJadwalId ? 'Edit Jadwal' : 'Tambah Jadwal Rundown' }}</span>
                    </h3>
                    <button wire:click="$set('bukaModalJadwal', false)" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form wire:submit="simpanJadwal" class="space-y-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Fase / Babak *</label>
                        <input type="text" wire:model="jadwal_fase" placeholder="Contoh: Technical Meeting / Babak Penyisihan / Grand Final" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500">
                        @error('jadwal_fase') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Nama Agenda / Kegiatan *</label>
                        <input type="text" wire:model="jadwal_nama_kegiatan" placeholder="Contoh: Pertandingan Egrang Putri" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500">
                        @error('jadwal_nama_kegiatan') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Tanggal *</label>
                            <input type="date" wire:model="jadwal_tanggal" class="w-full px-2 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Jam Mulai</label>
                            <input type="time" wire:model="jadwal_jam_mulai" class="w-full px-2 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Jam Selesai</label>
                            <input type="time" wire:model="jadwal_jam_selesai" class="w-full px-2 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Lokasi / Venue Arena *</label>
                        <input type="text" wire:model="jadwal_tempat_arena" placeholder="Contoh: Lapangan Panahan SJH" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500">
                        @error('jadwal_tempat_arena') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Status Tahapan *</label>
                        <select wire:model="jadwal_status" class="w-full px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500">
                            <option value="akan_datang">Akan Datang</option>
                            <option value="berlangsung">Sedang Berlangsung</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" wire:click="$set('bukaModalJadwal', false)" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs cursor-pointer">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ==========================================
         MODAL: KELOLA KATEGORI EVENT
         ========================================== --}}
    @if($bukaModalKategori)
        <div class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-5 animate-scale-up">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                        <i data-lucide="tag" class="w-5 h-5 text-emerald-600"></i>
                        <span>Kelola Kategori Event</span>
                    </h3>
                    <button wire:click="$set('bukaModalKategori', false)" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                @if(session()->has('pesan_kategori'))
                    <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-bold">
                        {{ session('pesan_kategori') }}
                    </div>
                @endif
                @if(session()->has('error_kategori'))
                    <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-bold">
                        {{ session('error_kategori') }}
                    </div>
                @endif

                <!-- Form Input Kategori -->
                <form wire:submit="simpanKategori" class="flex gap-2">
                    <input type="text" wire:model="nama_kategori" placeholder="Nama kategori baru (contoh: Festival Budaya)" class="flex-1 px-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500">
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shrink-0 cursor-pointer">
                        {{ $editKategoriId ? 'Update' : 'Tambah' }}
                    </button>
                </form>
                @error('nama_kategori') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror

                <!-- List Kategori -->
                <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                    @foreach($kategoriList as $kat)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-2xl border border-slate-200/80">
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">{{ $kat->nama_kategori }}</h4>
                                <span class="text-[10px] text-slate-400">{{ $kat->events_count }} Event terhubung</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <button wire:click="editKategori('{{ $kat->id }}')" class="p-1 text-slate-400 hover:text-emerald-600 cursor-pointer" title="Edit">
                                    <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                </button>
                                <button wire:click="hapusKategori('{{ $kat->id }}')" wire:confirm="Hapus kategori ini?" class="p-1 text-slate-400 hover:text-rose-600 cursor-pointer" title="Hapus">
                                    <i data-lucide="trash" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end pt-3 border-t border-slate-100">
                    <button type="button" wire:click="$set('bukaModalKategori', false)" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
