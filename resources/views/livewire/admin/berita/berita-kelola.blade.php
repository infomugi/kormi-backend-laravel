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
        <!-- VIEW MODE: TABEL & DAFTAR BERITA           -->
        <!-- ========================================== -->
        <div wire:key="berita-view-tabel" class="space-y-6">

        <!-- 1. HEADER & PRIMARY ACTION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                    <span>PUBLIKASI MEDIA</span>
                    <span>•</span>
                    <span class="text-indigo-600">BERITA & ARTIKEL</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Berita & Artikel</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Publikasikan liputan event, dokumentasi inorga, dan siaran pers KORMI Kabupaten Bandung.</p>
            </div>
            
            <button 
                type="button" 
                wire:key="btn-tambah-berita"
                wire:click="bukaFormTambah" 
                class="inline-flex items-center justify-center gap-2.5 px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 hover:shadow-lg transition-all cursor-pointer self-start sm:self-auto active:scale-95"
            >
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tulis Berita Baru</span>
            </button>
        </div>


        <!-- 2. MINI KPI METRIC STATS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <i data-lucide="newspaper" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Berita</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalBerita }} <span class="text-xs font-bold text-slate-400">Post</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Terbit (Live)</p>
                    <p class="text-2xl font-black text-emerald-600 mt-0.5">{{ $totalPublished }} <span class="text-xs font-bold text-slate-400">Artikel</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="file-edit" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Draf Disimpan</p>
                    <p class="text-2xl font-black text-amber-600 mt-0.5">{{ $totalDraft }} <span class="text-xs font-bold text-slate-400">Draf</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0">
                    <i data-lucide="eye" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pembaca</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ number_format($totalViews) }} <span class="text-xs font-bold text-slate-400">Hits</span></p>
                </div>
            </div>
        </div>

        <!-- 3. FILTER & SEARCH TOOLBAR -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex flex-col lg:flex-row items-center justify-between gap-4">
            <!-- Category Filter Pills -->
            <div class="flex items-center gap-2 w-full lg:w-auto overflow-x-auto pb-2 lg:pb-0 scrollbar-none">
                <button 
                    type="button"
                    wire:click="$set('kategoriDipilih', 'Semua')" 
                    class="px-4 py-2 rounded-2xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap {{ $kategoriDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                >
                    Semua Kategori ({{ $totalBerita }})
                </button>
                @foreach($kategoriList as $k)
                    <button 
                        type="button"
                        wire:click="$set('kategoriDipilih', '{{ $k->id }}')" 
                        class="px-4 py-2 rounded-2xl text-xs font-bold whitespace-nowrap transition-all cursor-pointer {{ $kategoriDipilih === $k->id ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                    >
                        {{ $k->nama_kategori }} ({{ $k->berita_count }})
                    </button>
                @endforeach
            </div>

            <!-- Right Side: Status Select & Search Input -->
            <div class="flex items-center gap-3 w-full lg:w-auto">
                <select wire:model.live="statusDipilih" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="Semua">Semua Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    <option value="archived">Archived</option>
                </select>

                <div class="relative flex-1 lg:w-72">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="Cari judul artikel..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                    >
                </div>
            </div>
        </div>

        <!-- 4. TABLE LIST CARD -->
        <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-[10px] uppercase font-black tracking-wider text-slate-400 border-b border-slate-200/80">
                        <tr>
                            <th class="px-6 py-4">Berita & Ringkasan</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Status & Utama</th>
                            <th class="px-6 py-4">Pembaca</th>
                            <th class="px-6 py-4">Tanggal Terbit</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($beritaList as $b)
                            <tr wire:key="row-berita-{{ $b->id }}" class="hover:bg-slate-50/70 transition-colors">
                                <!-- Thumbnail & Title -->
                                <td class="px-6 py-4 flex items-center gap-4">
                                    <img 
                                        src="{{ $b->gambar_utama ?: 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=400' }}" 
                                        class="w-16 h-14 rounded-2xl object-cover shrink-0 border border-slate-200/80 shadow-2xs" 
                                        alt="{{ $b->judul }}"
                                        onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=400'"
                                    >
                                    <div class="max-w-md">
                                        <h4 class="font-black text-slate-900 text-xs sm:text-sm line-clamp-1 leading-snug">{{ $b->judul }}</h4>
                                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-1 font-medium">{{ $b->ringkasan }}</p>
                                        <span class="text-[10px] text-slate-400 font-bold mt-1 block">Oleh: {{ $b->penulis->nama_lengkap ?? 'Redaksi KORMI' }}</span>
                                    </div>
                                </td>

                                <!-- Category Badge -->
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $b->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>

                                <!-- Status & Featured Toggle -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @php
                                            $statusClass = [
                                                'published' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'draft' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'archived' => 'bg-slate-100 text-slate-700 border-slate-200',
                                            ][$b->status_publikasi] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusClass }}">
                                            {{ $b->status_publikasi }}
                                        </span>
                                        
                                        <button 
                                            type="button" 
                                            wire:key="btn-toggle-star-{{ $b->id }}"
                                            wire:click="toggleUnggulan('{{ $b->id }}')" 
                                            class="p-1 rounded-lg text-xs transition-transform hover:scale-125 cursor-pointer" 
                                            title="{{ $b->status_unggulan ? 'Hapus dari Berita Utama' : 'Jadikan Berita Utama' }}"
                                        >
                                            {{ $b->status_unggulan ? '⭐' : '☆' }}
                                        </button>
                                    </div>
                                </td>

                                <!-- Views -->
                                <td class="px-6 py-4 font-black text-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="eye" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>{{ number_format($b->jumlah_dilihat) }}</span>
                                    </div>
                                </td>

                                <!-- Publish Date -->
                                <td class="px-6 py-4 text-slate-500 text-[11px] font-bold">
                                    {{ \Carbon\Carbon::parse($b->tanggal_publikasi)->format('d M Y') }}
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- View Live on Portal -->
                                        <a 
                                            href="{{ route('berita.detail', $b->slug) }}" 
                                            target="_blank" 
                                            class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors cursor-pointer" 
                                            title="Lihat di Portal Publik"
                                        >
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>

                                        <!-- Edit Button (Direct In-Page Form) -->
                                        <button 
                                            type="button" 
                                            wire:key="btn-edit-berita-{{ $b->id }}"
                                            wire:click="bukaFormEdit('{{ $b->id }}')" 
                                            class="p-2 rounded-xl text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 transition-colors cursor-pointer font-bold" 
                                            title="Edit Berita"
                                        >
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button 
                                            type="button" 
                                            wire:key="btn-hapus-berita-{{ $b->id }}"
                                            wire:click="hapus('{{ $b->id }}')" 
                                            wire:confirm="Yakin ingin menghapus berita ini?"
                                            class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer" 
                                            title="Hapus Berita"
                                        >
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-bold text-xs">
                                    <i data-lucide="newspaper" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                    <span>Tidak ada berita atau artikel yang cocok dengan pencarian.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $beritaList->links() }}
            </div>
        </div>
        </div>

    @else
        <!-- ========================================== -->
        <!-- VIEW MODE: FULL IN-PAGE EDITOR FORM        -->
        <!-- ========================================== -->

        <div wire:key="berita-view-form" class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Back Button -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:key="btn-batal-form-top-icon"
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Daftar Berita"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR EDITOR</span>
                            <span>•</span>
                            <span class="text-indigo-600">{{ $beritaId ? 'EDIT ARTIKEL' : 'ARTIKEL BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $beritaId ? 'Edit Rincian Berita' : 'Tulis Publikasi Berita Baru' }}
                        </h2>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button 
                        type="button" 
                        wire:key="btn-batal-form-top"
                        wire:click="kembaliKeTabel" 
                        class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="button" 
                        wire:key="btn-simpan-form-top"
                        wire:click="simpan" 
                        class="px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $beritaId ? 'Perbarui Berita' : 'Simpan & Terbitkan' }}</span>
                    </button>
                </div>
            </div>


            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <!-- Title & Category Row -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <div class="lg:col-span-8 space-y-6">
                        <!-- Judul Berita -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Artikel Berita *</label>
                            <input 
                                type="text" 
                                wire:model="judul" 
                                placeholder="Contoh: KORMI Kabupaten Bandung Siapkan 280 Duta Olahraga Desa..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:outline-none transition-all"
                            >
                            @error('judul') <span class="text-xs text-rose-600 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Ringkasan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ringkasan / Sinopsis Artikel *</label>
                            <textarea 
                                wire:model="ringkasan" 
                                rows="3" 
                                placeholder="Tulis ringkasan berita 1-2 paragraf untuk cuplikan pada kartu berita portal..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-indigo-500 focus:outline-none transition-all leading-relaxed"
                            ></textarea>
                            @error('ringkasan') <span class="text-xs text-rose-600 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Isi Konten Lengkap -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Isi Lengkap Naskah Berita *</label>
                            <textarea 
                                wire:model="isi_konten" 
                                rows="12" 
                                placeholder="Tulis artikel atau berita lengkap di sini..." 
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-indigo-500 focus:outline-none transition-all leading-relaxed"
                            ></textarea>
                            @error('isi_konten') <span class="text-xs text-rose-600 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Right Column: Meta, Category, Image & Status -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Category & Status Box -->
                        <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 space-y-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="settings" class="w-4 h-4 text-indigo-600"></i>
                                <span>Pengaturan Penerbitan</span>
                            </h3>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori *</label>
                                <select wire:model="kategori_id" class="w-full px-4 py-3 bg-white border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    @foreach($kategoriList as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi *</label>
                                <select wire:model="status_publikasi" class="w-full px-4 py-3 bg-white border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="published">Published (Tayang Langsung)</option>
                                    <option value="draft">Draft (Draf Tersimpan)</option>
                                    <option value="archived">Archived (Arsip)</option>
                                </select>
                            </div>

                            <div class="flex items-center gap-2 pt-2 border-t border-slate-200">
                                <input type="checkbox" id="formUnggulan" wire:model="status_unggulan" class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="formUnggulan" class="text-xs text-slate-700 cursor-pointer font-bold select-none">Berita Utama / Hero Banner</label>
                            </div>
                        </div>

                        <!-- Thumbnail Image Box -->
                        <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 space-y-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="image" class="w-4 h-4 text-indigo-600"></i>
                                <span>Gambar Utama (Thumbnail)</span>
                            </h3>

                            <!-- Image Preview -->
                            <div class="w-full h-44 rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 bg-slate-100 relative flex items-center justify-center">
                                @if($uploadGambar)
                                    <img src="{{ $uploadGambar->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview Gambar Baru">
                                    <div class="absolute bottom-2 right-2 bg-emerald-500 text-white text-[10px] font-bold px-2 py-1 rounded-xl">Siap Diupload</div>
                                @elseif($gambar_utama)
                                    @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($gambar_utama) @endphp
                                    <img src="{{ $tmpUrl }}" class="w-full h-full object-cover" alt="Gambar Utama" onerror="this.src=''; this.closest('div').querySelector('.text-slate-400') && null">
                                @else
                                    <div class="text-center">
                                        <i data-lucide="image-off" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-xs text-slate-400">Belum ada gambar</p>
                                    </div>
                                @endif
                            </div>

                            <!-- File Upload Input -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Pilih File Gambar {{ !$beritaId ? '*' : '' }}
                                    <span class="normal-case font-normal text-slate-400 ml-1">(jpg, jpeg, png, webp &mdash; maks. 5MB)</span>
                                </label>
                                <label for="uploadGambarBerita" class="flex items-center gap-3 w-full px-4 py-3 bg-white border-2 border-dashed {{ $uploadGambar ? 'border-emerald-400 bg-emerald-50' : 'border-slate-200 hover:border-indigo-400' }} text-slate-600 rounded-2xl text-xs font-semibold cursor-pointer transition-colors">
                                    <i data-lucide="upload-cloud" class="w-5 h-5 {{ $uploadGambar ? 'text-emerald-500' : 'text-indigo-400' }} shrink-0"></i>
                                    <span class="truncate">{{ $uploadGambar ? $uploadGambar->getClientOriginalName() : 'Klik untuk pilih file gambar' }}</span>
                                </label>
                                <input id="uploadGambarBerita" type="file" wire:model="uploadGambar" accept="image/jpeg,image/png,image/webp" class="hidden">
                                @error('uploadGambar') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                                @if($uploadGambar)
                                    <p class="text-[11px] text-emerald-600 font-semibold mt-1">&#10003; {{ round($uploadGambar->getSize() / 1024, 1) }} KB &mdash; siap diunggah ke MinIO</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Sticky-like Action Footer -->
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
                        wire:loading.attr="disabled"
                        class="px-8 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span wire:loading.remove wire:target="simpan">{{ $beritaId ? 'Perbarui Berita' : 'Simpan & Terbitkan Berita' }}</span>
                        <span wire:loading.flex wire:target="simpan" class="items-center gap-2">
                            <span>Menyimpan...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
