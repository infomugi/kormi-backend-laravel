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
        <!-- VIEW MODE: TABEL DAFTAR INORGA             -->
        <!-- ========================================== -->

        <!-- 1. HEADER & PRIMARY ACTION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                    <span>KELEMBAGAAN & ANGGOTA</span>
                    <span>•</span>
                    <span class="text-amber-600">INDUK OLAHRAGA (INORGA)</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Induk Organisasi Olahraga</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Data Inorga terdaftar di bawah 3 Komisi Resmi KORMI: OTDA (Tradisional), OKK (Kebugaran), dan OPT (Petualangan).</p>
            </div>

            <button 
                type="button" 
                wire:click="bukaFormTambah" 
                class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 transition-all cursor-pointer self-start sm:self-auto active:scale-95"
            >
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Inorga Baru</span>
            </button>
        </div>

        <!-- 2. MINI KPI STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="shapes" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Inorga</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalInorga }} <span class="text-xs font-bold text-slate-400">Organisasi</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Inorga Aktif</p>
                    <p class="text-2xl font-black text-emerald-600 mt-0.5">{{ $totalAktif }} <span class="text-xs font-bold text-slate-400">Terverifikasi</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Klub Terdata</p>
                    <p class="text-2xl font-black text-indigo-600 mt-0.5">{{ number_format($totalKlub) }} <span class="text-xs font-bold text-slate-400">Klub / Paguyuban</span></p>
                </div>
            </div>
        </div>

        <!-- 3. FILTER & SEARCH CONTROLS -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex flex-col lg:flex-row items-center justify-between gap-4">
            <!-- Commission Filter Pills -->
            <div class="flex items-center gap-2 w-full lg:w-auto overflow-x-auto pb-2 lg:pb-0 scrollbar-none">
                <button 
                    type="button"
                    wire:click="$set('komisiDipilih', 'Semua')" 
                    class="px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap cursor-pointer {{ $komisiDipilih === 'Semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}"
                >
                    Semua Komisi ({{ $totalInorga }})
                </button>
                @foreach($komisiList as $k)
                    <button 
                        type="button"
                        wire:click="$set('komisiDipilih', '{{ $k->id }}')" 
                        class="px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-wider transition-all whitespace-nowrap cursor-pointer {{ $komisiDipilih === $k->id ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}"
                    >
                        {{ $k->singkatan }} ({{ $k->inorga_count }})
                    </button>
                @endforeach
            </div>

            <!-- Search input -->
            <div class="relative w-full lg:w-72">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="cari" 
                    placeholder="Cari singkatan / nama inorga..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition-all"
                >
            </div>
        </div>

        <!-- 4. DATA TABLE -->
        <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-[10px] uppercase font-black tracking-wider text-slate-400 border-b border-slate-200/80">
                        <tr>
                            <th class="py-4 px-6">Singkatan</th>
                            <th class="py-4 px-6">Nama Lengkap Inorga</th>
                            <th class="py-4 px-6">Komisi Induk</th>
                            <th class="py-4 px-6 text-center">Jumlah Klub</th>
                            <th class="py-4 px-6 text-center">Status Keanggotaan</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($inorgaList as $ino)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-4 px-6">
                                    <span class="font-black text-slate-900 text-xs bg-slate-100 group-hover:bg-amber-100 group-hover:text-amber-900 px-3 py-1.5 rounded-xl border border-slate-200 transition-colors tracking-wider inline-block">
                                        {{ $ino->singkatan }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <h4 class="font-black text-slate-900 text-sm group-hover:text-amber-600 transition-colors">{{ $ino->nama_inorga }}</h4>
                                    <span class="text-[11px] text-slate-400 font-medium">Slug: {{ $ino->slug }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $komisiSingkat = $ino->komisi->singkatan ?? '';
                                        $komisiColor = match($komisiSingkat) {
                                            'OTDA' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'OKK' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'OPT' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            default => 'bg-slate-100 text-slate-700 border-slate-200'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $komisiColor }}">
                                        {{ $ino->komisi->singkatan ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center gap-1 font-black text-slate-800 bg-slate-100 px-3 py-1 rounded-xl text-xs">
                                        <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i>
                                        {{ $ino->jumlah_klub_anggota }} Klub
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @php
                                        $statusClass = match($ino->status_keanggotaan) {
                                            'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'verifikasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'masa_tenggang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            default => 'bg-rose-50 text-rose-700 border-rose-200'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusClass }}">
                                        {{ str_replace('_', ' ', $ino->status_keanggotaan) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button 
                                            type="button" 
                                            wire:click="bukaFormEdit('{{ $ino->id }}')" 
                                            class="p-2 rounded-xl text-amber-600 hover:bg-amber-50 transition-colors cursor-pointer font-bold" 
                                            title="Edit Inorga"
                                        >
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>
                                        <button 
                                            type="button" 
                                            wire:click="hapus('{{ $ino->id }}')" 
                                            wire:confirm="Yakin ingin menghapus inorga ini dari sistem CMS?" 
                                            class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer font-bold" 
                                            title="Hapus Inorga"
                                        >
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center bg-white">
                                    <i data-lucide="shapes" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                    <p class="text-sm font-bold text-slate-600">Tidak ada inorga yang sesuai kriteria pencarian.</p>
                                    <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-amber-600 text-white font-bold text-xs cursor-pointer">
                                        + Tambah Inorga Sekarang
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                {{ $inorgaList->links() }}
            </div>
        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM INORGA            -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            <!-- Form Header & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Daftar Inorga"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR INDUK ORGANISASI</span>
                            <span>•</span>
                            <span class="text-amber-600">{{ $inorgaId ? 'EDIT INORGA' : 'INORGA BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $inorgaId ? 'Edit Data Kelembagaan Inorga' : 'Pendaftaran Induk Organisasi Baru' }}
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
                        wire:click="simpan" 
                        class="px-6 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 transition-all cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $inorgaId ? 'Perbarui Inorga' : 'Simpan Inorga' }}</span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Left: Metadata Form -->
                    <div class="lg:col-span-7 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Singkatan Inorga *</label>
                                <input 
                                    type="text" 
                                    wire:model="singkatan" 
                                    placeholder="Contoh: PORTINA, FOKBI..." 
                                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold uppercase focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                                >
                                @error('singkatan') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Komisi Induk *</label>
                                <select wire:model="komisi_id" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all">
                                    @foreach($komisiList as $k)
                                        <option value="{{ $k->id }}">{{ $k->singkatan }} - {{ $k->nama_komisi }}</option>
                                    @endforeach
                                </select>
                                @error('komisi_id') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap Organisasi *</label>
                            <input 
                                type="text" 
                                wire:model="nama_inorga" 
                                placeholder="Contoh: Persatuan Olahraga Tradisional Indonesia..." 
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-sm font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                            >
                            @error('nama_inorga') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jumlah Klub Anggota *</label>
                                <input 
                                    type="number" 
                                    wire:model="jumlah_klub_anggota" 
                                    class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all"
                                    min="0"
                                >
                                @error('jumlah_klub_anggota') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Keanggotaan *</label>
                                <select wire:model="status_keanggotaan" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl text-xs font-bold focus:bg-white focus:border-amber-500 focus:outline-none transition-all">
                                    <option value="aktif">Aktif Terdaftar</option>
                                    <option value="verifikasi">Dalam Verifikasi</option>
                                    <option value="masa_tenggang">Masa Tenggang</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                                @error('status_keanggotaan') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right: Info Guide Box -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 space-y-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="info" class="w-4 h-4 text-amber-600"></i>
                                <span>Panduan 3 Komisi KORMI</span>
                            </h3>

                            <div class="space-y-3 text-xs">
                                <div class="p-3.5 rounded-2xl bg-white border border-amber-200/60">
                                    <span class="font-black text-amber-800 uppercase tracking-wider block mb-1">1. OTDA (Olahraga Tradisional & Budaya)</span>
                                    <p class="text-slate-600 leading-relaxed">Olahraga warisan budaya nusantara seperti Dagongan, Egrang, Terompah Panjang, Sumpitan, dll.</p>
                                </div>

                                <div class="p-3.5 rounded-2xl bg-white border border-emerald-200/60">
                                    <span class="font-black text-emerald-800 uppercase tracking-wider block mb-1">2. OKK (Kesehatan & Kebugaran)</span>
                                    <p class="text-slate-600 leading-relaxed">Senam kreasi, senam kebugaran, yoga rekreasi, jalan sehat (FOKBI, IOSKI, ASIAFI, dll).</p>
                                </div>

                                <div class="p-3.5 rounded-2xl bg-white border border-indigo-200/60">
                                    <span class="font-black text-indigo-800 uppercase tracking-wider block mb-1">3. OPT (Petualangan & Tantangan)</span>
                                    <p class="text-slate-600 leading-relaxed">Olahraga petualangan alam terbuka, airsoft, skateboard, panjat tebing, e-sport rekreasi.</p>
                                </div>
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
                        class="px-8 py-3 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-amber-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ $inorgaId ? 'Perbarui Inorga' : 'Simpan Inorga ke Database' }}</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
