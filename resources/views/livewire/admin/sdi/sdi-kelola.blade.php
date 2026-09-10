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
        <!-- VIEW MODE: TABEL & KATALOG SDI             -->
        <!-- ========================================== -->

        <!-- 1. HEADER & PRIMARY ACTIONS -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                    <span>SUMBER DAYA INSANI</span>
                    <span>•</span>
                    <span class="text-blue-600">PELATIHAN & SERTIFIKASI</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola SDI & Sertifikasi Instruktur</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola program kurikulum pelatihan, sertifikasi juri/wasit/instruktur, dan jadwal angkatan pelatihan se-Kabupaten Bandung.</p>
            </div>

            <div class="flex items-center gap-3 self-start sm:self-auto">
                <button 
                    type="button" 
                    wire:click="bukaFormProgramTambah" 
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-slate-900/10 transition-all cursor-pointer active:scale-95"
                >
                    <i data-lucide="book-plus" class="w-4 h-4"></i>
                    <span>Buat Program</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bukaFormJadwalTambah" 
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-blue-600/20 transition-all cursor-pointer active:scale-95"
                >
                    <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                    <span>Buka Jadwal</span>
                </button>
            </div>
        </div>

        <!-- 2. MINI KPI STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Program</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalProgram }} <span class="text-xs font-bold text-slate-400">Kurikulum</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="calendar" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jadwal Angkatan</p>
                    <p class="text-2xl font-black text-emerald-600 mt-0.5">{{ $totalJadwal }} <span class="text-xs font-bold text-slate-400">Batch</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peserta Terdaftar</p>
                    <p class="text-2xl font-black text-purple-600 mt-0.5">{{ number_format($totalPendaftar) }} <span class="text-xs font-bold text-slate-400">Orang</span></p>
                </div>
            </div>
        </div>

        <!-- 3. TAB CONTROLS & SEARCH -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex flex-col lg:flex-row items-center justify-between gap-4">
            <!-- Tabs (Program vs Jadwal) -->
            <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl w-full lg:w-auto">
                <button 
                    type="button"
                    wire:click="$set('tabAktif', 'program')" 
                    class="flex-1 lg:flex-none px-6 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer {{ $tabAktif === 'program' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}"
                >
                    <span class="flex items-center justify-center gap-2">
                        <i data-lucide="book-open" class="w-4 h-4"></i>
                        Program Pelatihan ({{ $totalProgram }})
                    </span>
                </button>
                <button 
                    type="button"
                    wire:click="$set('tabAktif', 'jadwal')" 
                    class="flex-1 lg:flex-none px-6 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer {{ $tabAktif === 'jadwal' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}"
                >
                    <span class="flex items-center justify-center gap-2">
                        <i data-lucide="calendar-days" class="w-4 h-4"></i>
                        Jadwal & Angkatan ({{ $totalJadwal }})
                    </span>
                </button>
            </div>

            <!-- Search input -->
            <div class="relative w-full lg:w-72">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="cari" 
                    placeholder="{{ $tabAktif === 'program' ? 'Cari judul program...' : 'Cari angkatan / lokasi...' }}" 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                >
            </div>
        </div>

        <!-- 4. CONTENT (TAB 1: PROGRAM PELATIHAN) -->
        @if($tabAktif === 'program')
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($daftarProgram as $prog)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-6 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $prog->jenis_sertifikasi ?? 'Sertifikasi KORMI' }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $prog->status_aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $prog->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </div>

                            <h3 class="text-base font-black text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2">{{ $prog->judul_program }}</h3>
                            
                            @if($prog->sasaran_peserta)
                                <p class="text-xs text-slate-500 mt-2 flex items-center gap-1.5 font-medium">
                                    <i data-lucide="target" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                    <span>Sasaran: {{ $prog->sasaran_peserta }}</span>
                                </p>
                            @endif

                            @if($prog->standar_kompetensi)
                                <p class="text-xs text-slate-600 line-clamp-2 mt-3 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                                    {{ $prog->standar_kompetensi }}
                                </p>
                            @endif
                        </div>

                        <div class="pt-4 mt-6 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400 flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                {{ $prog->jadwal_count }} Jadwal Angkatan
                            </span>

                            <div class="flex items-center gap-1.5">
                                <button 
                                    type="button" 
                                    wire:click="bukaFormProgramEdit('{{ $prog->id }}')" 
                                    class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 font-bold text-xs transition-colors cursor-pointer"
                                    title="Edit Program"
                                >
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="hapusProgram('{{ $prog->id }}')" 
                                    wire:confirm="Yakin ingin menghapus program pelatihan ini?"
                                    class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 font-bold text-xs transition-colors cursor-pointer"
                                    title="Hapus Program"
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                        <i data-lucide="book-open" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                        <p class="text-sm font-bold text-slate-600">Belum ada program pelatihan yang terdaftar.</p>
                        <button type="button" wire:click="bukaFormProgramTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-blue-600 text-white font-bold text-xs cursor-pointer">
                            + Buat Program Baru
                        </button>
                    </div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $daftarProgram->links() }}
            </div>

        @else
            <!-- 5. CONTENT (TAB 2: JADWAL & ANGKATAN) -->
            <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-[10px] uppercase font-black tracking-wider text-slate-400 border-b border-slate-200/80">
                            <tr>
                                <th class="py-4 px-6">Nama Angkatan / Program</th>
                                <th class="py-4 px-6">Pelaksanaan</th>
                                <th class="py-4 px-6">Lokasi</th>
                                <th class="py-4 px-6 text-center">Kuota & Pendaftar</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($daftarJadwal as $jadwal)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="py-4 px-6">
                                        <h4 class="font-black text-slate-900 text-sm group-hover:text-blue-600 transition-colors">{{ $jadwal->nama_angkatan }}</h4>
                                        <span class="text-[11px] text-slate-400">{{ $jadwal->program->judul_program ?? '-' }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-slate-700 font-bold">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-slate-500 font-medium">
                                        {{ $jadwal->lokasi_pelatihan }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="font-black text-slate-800 bg-slate-100 px-3 py-1 rounded-xl text-xs">
                                            {{ $jadwal->jumlah_pendaftar }} / {{ $jadwal->kuota_peserta }} Peserta
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @php
                                            $statusBadge = match($jadwal->status_pendaftaran) {
                                                'dibuka' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'berlangsung' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'penuh' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                default => 'bg-slate-100 text-slate-600 border-slate-200'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusBadge }}">
                                            {{ $jadwal->status_pendaftaran }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button 
                                                type="button" 
                                                wire:click="bukaFormJadwalEdit('{{ $jadwal->id }}')" 
                                                class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 font-bold text-xs transition-colors cursor-pointer"
                                                title="Edit Jadwal"
                                            >
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </button>
                                            <button 
                                                type="button" 
                                                wire:click="hapusJadwal('{{ $jadwal->id }}')" 
                                                wire:confirm="Yakin ingin menghapus jadwal angkatan ini?"
                                                class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 font-bold text-xs transition-colors cursor-pointer"
                                                title="Hapus Jadwal"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-16 text-center bg-white">
                                        <i data-lucide="calendar-x" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-sm font-bold text-slate-600">Belum ada jadwal pelatihan yang dibuka.</p>
                                        <button type="button" wire:click="bukaFormJadwalTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-blue-600 text-white font-bold text-xs cursor-pointer">
                                            + Buka Jadwal Baru
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                    {{ $daftarJadwal->links() }}
                </div>
            </div>
        @endif

    @elseif($mode === 'form_program')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM PROGRAM PELATIHAN  -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Katalog SDI"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR PROGRAM SDI</span>
                            <span>•</span>
                            <span class="text-blue-600">{{ $editProgramId ? 'EDIT PROGRAM' : 'PROGRAM BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $editProgramId ? 'Edit Kurikulum Program Pelatihan' : 'Buat Program Sertifikasi & Pelatihan Baru' }}
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
                        wire:click="simpanProgram" 
                        class="px-6 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-blue-600/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editProgramId ? 'Perbarui Program' : 'Simpan Program' }}</span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpanProgram" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Left: Metadata Form -->
                    <div class="lg:col-span-7 space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Program Pelatihan *</label>
                            <input 
                                type="text" 
                                wire:model="judul_program" 
                                placeholder="Contoh: Sertifikasi Instruktur Senam Bedas Level 1..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 focus:outline-none transition-all"
                            >
                            @error('judul_program') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sasaran Peserta</label>
                                <input 
                                    type="text" 
                                    wire:model="sasaran_peserta" 
                                    placeholder="Contoh: Instruktur Senam Desa & Guru Olahraga..." 
                                    class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-blue-500 focus:outline-none transition-all"
                                >
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Sertifikasi</label>
                                <select wire:model="jenis_sertifikasi" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-blue-500 focus:outline-none transition-all">
                                    <option value="Nasional KORMI">Nasional KORMI</option>
                                    <option value="Daerah KORMI Kab. Bandung">Daerah KORMI Kab. Bandung</option>
                                    <option value="Lisensi Juri / Wasit Inorga">Lisensi Juri / Wasit Inorga</option>
                                    <option value="Instruktur Kebugaran Terakreditasi">Instruktur Kebugaran Terakreditasi</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Standar Kompetensi & Kurikulum</label>
                            <textarea 
                                wire:model="standar_kompetensi" 
                                rows="4" 
                                placeholder="Kompetensi dasar, jam pelatihan, materi kurikulum..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:border-blue-500 focus:outline-none transition-all leading-relaxed"
                            ></textarea>
                        </div>

                        <!-- Active status toggle -->
                        <div class="p-5 rounded-3xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                            <div class="space-y-0.5">
                                <label for="statusAktif" class="text-xs font-black text-slate-900 cursor-pointer">Status Program Aktif</label>
                                <p class="text-xs text-slate-500">Program aktif dapat dibuka jadwal angkatan dan pendaftarannya.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="statusAktif" wire:model="status_aktif" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Right: Photo & Presets -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 space-y-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="image" class="w-4 h-4 text-blue-600"></i>
                                <span>Banner Program</span>
                            </h3>

                            <!-- Preview -->
                            <div class="w-full h-48 rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 bg-slate-100 flex items-center justify-center">
                                @if($uploadBanner)
                                    <img src="{{ $uploadBanner->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                                @elseif($banner_url)
                                    @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($banner_url) @endphp
                                    <img src="{{ $tmpUrl }}" class="w-full h-full object-cover" alt="Banner Program" onerror="this.closest('div').innerHTML='<div class=&quot;text-center&quot;><p class=&quot;text-xs text-slate-400&quot;>Tidak dapat memuat banner</p></div>'">
                                @else
                                    <div class="text-center">
                                        <i data-lucide="image-off" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-xs text-slate-400">Belum ada banner</p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    File Banner {{ !$editProgramId ? '*' : '(opsional)' }}
                                    <span class="normal-case font-normal text-slate-400 ml-1">(jpg/png/webp &mdash; maks. 10MB)</span>
                                </label>
                                <label for="uploadBannerSdi" class="flex items-center gap-3 w-full px-4 py-3 bg-white border-2 border-dashed {{ $uploadBanner ? 'border-emerald-400 bg-emerald-50' : 'border-slate-200 hover:border-blue-400' }} text-slate-600 rounded-2xl text-xs font-semibold cursor-pointer transition-colors">
                                    <i data-lucide="upload" class="w-5 h-5 {{ $uploadBanner ? 'text-emerald-500' : 'text-blue-500' }} shrink-0"></i>
                                    <span class="truncate">{{ $uploadBanner ? $uploadBanner->getClientOriginalName() : 'Klik untuk pilih banner program' }}</span>
                                </label>
                                <input id="uploadBannerSdi" type="file" wire:model="uploadBanner" accept="image/jpeg,image/png,image/webp" class="hidden">
                                @error('uploadBanner') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                                @if($uploadBanner)
                                    <p class="text-[11px] text-emerald-600 font-semibold mt-1">&#10003; {{ round($uploadBanner->getSize() / 1024, 1) }} KB &mdash; siap diunggah ke MinIO</p>
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
                        class="px-8 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-blue-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editProgramId ? 'Perbarui Program' : 'Simpan Program Pelatihan' }}</span>
                    </button>
                </div>
            </form>
        </div>

    @elseif($mode === 'form_jadwal')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM JADWAL ANGKATAN    -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Katalog SDI"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR JADWAL ANGKATAN</span>
                            <span>•</span>
                            <span class="text-blue-600">{{ $editJadwalId ? 'EDIT JADWAL' : 'JADWAL BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $editJadwalId ? 'Edit Rincian Angkatan Pelatihan' : 'Buka Jadwal Angkatan Pelatihan Baru' }}
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
                        wire:click="simpanJadwal" 
                        class="px-6 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-blue-600/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editJadwalId ? 'Perbarui Jadwal' : 'Simpan Jadwal' }}</span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpanJadwal" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <div class="lg:col-span-8 space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Program Pelatihan *</label>
                            <select wire:model="program_id" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 focus:outline-none transition-all">
                                @foreach($semuaProgram as $p)
                                    <option value="{{ $p->id }}">{{ $p->judul_program }}</option>
                                @endforeach
                            </select>
                            @error('program_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Angkatan / Batch *</label>
                            <input 
                                type="text" 
                                wire:model="nama_angkatan" 
                                placeholder="Contoh: Angkatan I - Wilayah Soreang & Sekitarnya..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 focus:outline-none transition-all"
                            >
                            @error('nama_angkatan') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Mulai *</label>
                                <input 
                                    type="date" 
                                    wire:model="tanggal_mulai" 
                                    class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-blue-500 focus:outline-none transition-all"
                                >
                                @error('tanggal_mulai') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Selesai *</label>
                                <input 
                                    type="date" 
                                    wire:model="tanggal_selesai" 
                                    class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-blue-500 focus:outline-none transition-all"
                                >
                                @error('tanggal_selesai') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi Pelatihan / Venue *</label>
                            <input 
                                type="text" 
                                wire:model="lokasi_pelatihan" 
                                placeholder="Contoh: Gedung Ormas KORMI / GOR Si Jalak Harupat..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 focus:outline-none transition-all"
                            >
                            @error('lokasi_pelatihan') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="lg:col-span-4 space-y-5">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 space-y-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Kapasitas & Status</h3>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kuota Peserta *</label>
                                <input 
                                    type="number" 
                                    wire:model="kuota_peserta" 
                                    class="w-full px-4 py-3 bg-white border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    min="1"
                                >
                                @error('kuota_peserta') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Pendaftaran *</label>
                                <select wire:model="status_pendaftaran" class="w-full px-4 py-3 bg-white border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="dibuka">Dibuka (Menerima Peserta)</option>
                                    <option value="berlangsung">Sedang Berlangsung</option>
                                    <option value="penuh">Kuota Penuh</option>
                                    <option value="selesai">Selesai</option>
                                </select>
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
                        class="px-8 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-blue-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $editJadwalId ? 'Perbarui Jadwal' : 'Simpan Jadwal Angkatan' }}</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
