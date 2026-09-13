<div class="space-y-6">

    <!-- FLASH NOTIFICATIONS -->
    @if (session()->has('pesan'))
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

    @if (session()->has('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-800 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xs animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                </div>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-rose-500 hover:text-rose-800 p-1.5 rounded-lg transition-colors cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    <!-- 1. HEADER & PRIMARY ACTION -->
    <x-table.header
        title="Peran & Hak Akses Menu"
        subtitle="Manajemen tingkatan peran administrator (RBAC), pengaturan izin akses modul, dan wewenang navigasi menu CMS KORMI."
        badge="Administrasi Sistem • Hak Akses Menu"
        icon="shield-check"
        color="emerald"
    >
        <x-slot:actions>
            <div class="flex items-center gap-2.5">
                <a 
                    href="{{ route('admin.pengguna') }}" 
                    wire:navigate
                    class="inline-flex items-center justify-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-all cursor-pointer"
                >
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>Kelola Pengguna</span>
                </a>
                <button 
                    type="button" 
                    wire:click="bukaFormTambah"
                    class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                >
                    <i data-lucide="plus-circle" class="w-4 h-4 transition-transform group-hover:scale-110 duration-200"></i>
                    <span>Tambah Peran Baru</span>
                </button>
            </div>
        </x-slot:actions>
    </x-table.header>

    <!-- 2. SEARCH & FILTER BAR -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="relative w-full sm:w-80">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input 
                type="text" 
                wire:model.live.debounce.300ms="cari"
                placeholder="Cari nama peran / deskripsi..." 
                class="w-full pl-10 pr-4 py-2 sm:py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-xs sm:text-sm text-slate-800 transition-all font-medium outline-hidden"
            />
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto justify-end text-xs font-bold text-slate-500">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span>Total: {{ $peranList->count() }} Peran Terdaftar</span>
        </div>
    </div>

    <!-- 3. ROLE CARDS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-5">
        @forelse($peranList as $peran)
            @php
                $isSuperAdmin = in_array($peran->slug, ['super-admin', 'superadmin'], true);
                $aksesArray = is_array($peran->hak_akses) ? $peran->hak_akses : [];
                $isSystemDefault = in_array($peran->slug, ['super-admin', 'admin-korcam', 'admin-inorga', 'editor-berita'], true);
            @endphp
            <div wire:key="peran-card-{{ $peran->id }}" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col justify-between group">
                
                <!-- Card Top Header -->
                <div class="p-5 sm:p-6 border-b border-slate-100 bg-gradient-to-br from-slate-50/70 via-white to-white">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 {{ $isSuperAdmin ? 'bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-md shadow-amber-500/20' : ($peran->slug === 'admin-korcam' ? 'bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-md shadow-blue-500/20' : ($peran->slug === 'admin-inorga' ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/20' : 'bg-gradient-to-br from-purple-500 to-indigo-600 text-white shadow-md shadow-purple-500/20')) }}">
                                <i data-lucide="{{ $isSuperAdmin ? 'crown' : ($peran->slug === 'admin-korcam' ? 'map-pin' : ($peran->slug === 'admin-inorga' ? 'trophy' : 'newspaper')) }}" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">{{ $peran->nama_peran }}</h3>
                                    @if($isSystemDefault)
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-extrabold uppercase tracking-wider border border-slate-200/80">Sistem</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-mono font-bold bg-slate-100 text-slate-700">
                                        {{ $peran->slug }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                                        <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i>
                                        {{ $peran->pengguna_count }} Akun Pengguna
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-1.5 shrink-0">
                            <button 
                                type="button" 
                                wire:click="editPeran('{{ $peran->id }}')"
                                class="p-2 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 transition-colors cursor-pointer"
                                title="Edit Peran & Hak Akses"
                            >
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            @if(!$isSystemDefault)
                                <button 
                                    type="button" 
                                    wire:click="konfirmasiHapus('{{ $peran->id }}')"
                                    class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-700 transition-colors cursor-pointer"
                                    title="Hapus Peran"
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            @endif
                        </div>
                    </div>

                    @if($peran->deskripsi)
                        <p class="text-xs text-slate-600 mt-3 leading-relaxed font-medium">
                            {{ $peran->deskripsi }}
                        </p>
                    @endif
                </div>

                <!-- Card Body: Permissions Badges -->
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="text-[11px] font-black uppercase tracking-wider text-slate-400 mb-3 flex items-center justify-between">
                            <span>Izin Akses Modul CMS:</span>
                            @if($isSuperAdmin)
                                <span class="text-amber-600 font-extrabold flex items-center gap-1">
                                    <i data-lucide="check-check" class="w-3.5 h-3.5"></i> Full Unlimited Access
                                </span>
                            @else
                                <span class="text-emerald-700 font-extrabold">
                                    {{ count($aksesArray) }} Modul Diizinkan
                                </span>
                            @endif
                        </div>

                        @if($isSuperAdmin)
                            <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-amber-900 text-xs font-semibold flex items-center gap-3">
                                <i data-lucide="shield-alert" class="w-5 h-5 text-amber-600 shrink-0"></i>
                                <span>Super Admin memiliki hak otoritas tertinggi tanpa batas pada seluruh menu publikasi, wilayah, organisasi, dan pengaturan sistem.</span>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach($daftarModul as $grupKey => $grup)
                                    @php
                                        $modulAktifDiGrup = [];
                                        foreach($grup['items'] as $itemKey => $item) {
                                            if (in_array($itemKey, $aksesArray, true)) {
                                                $modulAktifDiGrup[] = $item['nama'];
                                            }
                                        }
                                    @endphp
                                    <div class="p-2.5 rounded-xl border {{ count($modulAktifDiGrup) > 0 ? 'bg-emerald-50/40 border-emerald-200/80' : 'bg-slate-50/50 border-slate-100 opacity-60' }}">
                                        <div class="text-[10px] font-black uppercase tracking-wider {{ count($modulAktifDiGrup) > 0 ? 'text-emerald-800' : 'text-slate-400' }} mb-1">
                                            {{ $grup['nama'] }}
                                        </div>
                                        @if(count($modulAktifDiGrup) > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($modulAktifDiGrup as $namaItem)
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white border border-emerald-200 text-emerald-800 text-[10px] font-bold">
                                                        <i data-lucide="check" class="w-2.5 h-2.5 text-emerald-600"></i>
                                                        {{ $namaItem }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-[10px] text-slate-400 italic">Tidak ada akses</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Footer Action in Card -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium">Diperbarui: {{ $peran->diperbarui_pada ? $peran->diperbarui_pada->diffForHumans() : '-' }}</span>
                        <button 
                            type="button" 
                            wire:click="editPeran('{{ $peran->id }}')"
                            class="text-emerald-700 hover:text-emerald-800 font-bold inline-flex items-center gap-1 cursor-pointer group-hover:translate-x-0.5 transition-transform"
                        >
                            <span>Atur Hak Akses</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white p-12 rounded-3xl border border-slate-200 text-center space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                    <i data-lucide="shield-off" class="w-6 h-6"></i>
                </div>
                <h4 class="text-base font-bold text-slate-700">Tidak ada peran ditemukan</h4>
                <p class="text-xs text-slate-500">Coba kata kunci pencarian lain atau tambahkan peran baru.</p>
            </div>
        @endforelse
    </div>

    <!-- ============================================================ -->
    <!-- MODAL FORM: TAMBAH / EDIT PERAN & HAK AKSES                   -->
    <!-- ============================================================ -->
    @if($tampilkanModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-150 overflow-y-auto">
            <div class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl border border-slate-200 overflow-hidden my-auto max-h-[90vh] flex flex-col">
                
                <!-- Modal Header -->
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900">
                                {{ $peranId ? 'Edit Peran & Hak Akses' : 'Tambah Peran Baru' }}
                            </h3>
                            <p class="text-xs text-slate-500 font-medium">Tentukan nama peran, slug identifikasi, dan checklist hak akses menu CMS.</p>
                        </div>
                    </div>
                    <button 
                        type="button" 
                        wire:click="$set('tampilkanModal', false)"
                        class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer"
                    >
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div class="p-6 overflow-y-auto space-y-6 flex-1">
                    
                    <!-- 1. IDENTITAS PERAN -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Peran <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                wire:model.live="nama_peran"
                                placeholder="Contoh: Admin KORCAM" 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-xs sm:text-sm font-medium outline-hidden"
                            />
                            @error('nama_peran') <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Slug Identifikasi <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                wire:model="slug"
                                placeholder="contoh: admin-korcam" 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-xs sm:text-sm font-mono font-medium outline-hidden"
                            />
                            @error('slug') <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat Wewenang</label>
                            <input 
                                type="text" 
                                wire:model="deskripsi"
                                placeholder="Penjelasan ringkas tanggung jawab dan wewenang peran ini..." 
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-xs sm:text-sm font-medium outline-hidden"
                            />
                            @error('deskripsi') <span class="text-[11px] text-rose-500 font-semibold block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- 2. CHECKLIST HAK AKSES MODUL -->
                    <div class="space-y-3 pt-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800">Checklist Hak Akses Modul CMS</h4>
                                <p class="text-[11px] text-slate-500 font-medium">Pilih modul mana saja yang dapat diakses dan dikelola oleh peran ini.</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button 
                                    type="button" 
                                    wire:click="pilihSemuaAkses"
                                    class="text-[11px] font-bold text-emerald-700 hover:text-emerald-800 px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition-colors cursor-pointer"
                                >
                                    Pilih Semua
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="kosongkanSemuaAkses"
                                    class="text-[11px] font-bold text-slate-600 hover:text-slate-800 px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer"
                                >
                                    Kosongkan
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                            @foreach($daftarModul as $grupKey => $grup)
                                <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200/90 space-y-3">
                                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                                        <div>
                                            <h5 class="text-xs font-black text-slate-900 uppercase tracking-wider">{{ $grup['nama'] }}</h5>
                                            <p class="text-[10px] text-slate-500">{{ $grup['deskripsi'] }}</p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        @foreach($grup['items'] as $itemKey => $item)
                                            @php
                                                $isChecked = in_array($itemKey, $hak_akses, true);
                                            @endphp
                                            <label class="flex items-start gap-3 p-2.5 rounded-xl transition-all cursor-pointer select-none {{ $isChecked ? 'bg-white shadow-xs border border-emerald-200' : 'hover:bg-white/70 border border-transparent' }}">
                                                <input 
                                                    type="checkbox" 
                                                    wire:click="toggleAkses('{{ $itemKey }}')"
                                                    {{ $isChecked ? 'checked' : '' }}
                                                    class="mt-0.5 rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4 cursor-pointer"
                                                />
                                                <div class="flex-1">
                                                    <span class="block text-xs font-bold {{ $isChecked ? 'text-emerald-950' : 'text-slate-800' }}">
                                                        {{ $item['nama'] }}
                                                    </span>
                                                    <span class="block text-[10px] text-slate-500 font-medium">
                                                        {{ $item['deskripsi'] }}
                                                    </span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/80 flex items-center justify-end gap-3 shrink-0">
                    <button 
                        type="button" 
                        wire:click="$set('tampilkanModal', false)"
                        class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-200 transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="button" 
                        wire:click="simpan"
                        class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all cursor-pointer active:scale-95"
                    >
                        Simpan Peran & Hak Akses
                    </button>
                </div>

            </div>
        </div>
    @endif

    <!-- ============================================================ -->
    <!-- MODAL CONFIRM DELETE                                         -->
    <!-- ============================================================ -->
    @if($tampilkanModalHapus)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-150">
            <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl border border-slate-200 p-6 space-y-5 text-center">
                <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto shadow-inner">
                    <i data-lucide="alert-triangle" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900">Hapus Peran?</h3>
                    <p class="text-xs text-slate-600 mt-1 font-medium">
                        Anda yakin ingin menghapus peran <strong class="text-slate-900">"{{ $hapusPeranNama }}"</strong>? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="flex items-center justify-center gap-3">
                    <button 
                        type="button" 
                        wire:click="$set('tampilkanModalHapus', false)"
                        class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="button" 
                        wire:click="hapus"
                        class="px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition-all cursor-pointer"
                    >
                        Ya, Hapus Peran
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
