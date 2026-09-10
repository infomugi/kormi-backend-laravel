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

    @if($mode === 'tabel')
        <!-- ========================================== -->
        <!-- VIEW MODE: TABEL & DAFTAR PENGGUNA         -->
        <!-- ========================================== -->

        <!-- 1. HEADER & PRIMARY ACTION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                    <span>ADMINISTRASI SISTEM</span>
                    <span>•</span>
                    <span class="text-indigo-600">MANAJEMEN PENGGUNA</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Pengguna CMS</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Manajemen hak akses, role administrator, dan akun pengelola KORMI Kabupaten Bandung.</p>
            </div>
            
            <button 
                type="button" 
                wire:click="bukaFormTambah" 
                class="inline-flex items-center justify-center gap-2.5 px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 hover:shadow-lg transition-all cursor-pointer self-start sm:self-auto active:scale-95"
            >
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Tambah Pengguna Baru</span>
            </button>
        </div>

        <!-- 2. MINI KPI STATS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Akun</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalPengguna }} <span class="text-xs font-bold text-slate-400">User</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="user-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Akun Aktif</p>
                    <p class="text-2xl font-black text-emerald-600 mt-0.5">{{ $totalAktif }} <span class="text-xs font-bold text-slate-400">Aktif</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                    <i data-lucide="user-x" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Non-Aktif</p>
                    <p class="text-2xl font-black text-rose-500 mt-0.5">{{ $totalNonAktif }} <span class="text-xs font-bold text-slate-400">Akun</span></p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Role Admin</p>
                    <p class="text-2xl font-black text-indigo-600 mt-0.5">{{ $totalAdmin }} <span class="text-xs font-bold text-slate-400">Admin</span></p>
                </div>
            </div>
        </div>

        <!-- 3. BULK ACTIONS FLOATING TOOLBAR -->
        @if(count($selectedUsers) > 0)
            <div class="bg-slate-900 text-white rounded-2xl p-4 shadow-xl border border-slate-800 flex flex-wrap items-center justify-between gap-3 animate-in fade-in slide-in-from-top-2 duration-200">
                <div class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-xl bg-indigo-500 text-white font-black text-xs flex items-center justify-center">
                        {{ count($selectedUsers) }}
                    </span>
                    <span class="text-xs font-bold text-slate-200">
                        Pengguna Terpilih
                    </span>
                </div>

                <div class="flex items-center flex-wrap gap-2">
                    <!-- Bulk Disable Login -->
                    <button 
                        type="button"
                        wire:click="bulkDisableLogin"
                        wire:confirm="Nonaktifkan akses login untuk akun terpilih?"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-500/20 text-rose-300 hover:bg-rose-500 hover:text-white text-xs font-bold transition-all cursor-pointer"
                    >
                        <i data-lucide="user-x" class="w-3.5 h-3.5"></i>
                        <span>Disable Login</span>
                    </button>

                    <!-- Bulk Enable Login -->
                    <button 
                        type="button"
                        wire:click="bulkEnableLogin"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500 hover:text-white text-xs font-bold transition-all cursor-pointer"
                    >
                        <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                        <span>Enable Login</span>
                    </button>

                    <!-- Bulk Reset Password -->
                    <button 
                        type="button"
                        wire:click="bukaModalBulkResetPassword" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500/20 text-amber-300 hover:bg-amber-500 hover:text-white text-xs font-bold transition-all cursor-pointer"
                    >
                        <i data-lucide="key" class="w-3.5 h-3.5"></i>
                        <span>Reset Password</span>
                    </button>

                    <!-- Bulk Delete -->
                    <button 
                        type="button"
                        wire:click="bulkHapus"
                        wire:confirm="Yakin ingin menghapus seluruh akun pengguna terpilih secara permanen?"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 text-rose-400 hover:bg-rose-600 hover:text-white text-xs font-bold transition-all cursor-pointer"
                    >
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus Terpilih</span>
                    </button>

                    <!-- Cancel Selection -->
                    <button 
                        type="button"
                        wire:click="$set('selectedUsers', [])"
                        class="px-2.5 py-1.5 rounded-xl text-slate-400 hover:text-white text-xs font-semibold cursor-pointer"
                    >
                        Batal
                    </button>
                </div>
            </div>
        @endif

        <!-- 4. MAIN TABLE & FILTERS CONTAINER -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            
            <!-- Filters Toolbar -->
            <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <!-- Search -->
                <div class="relative flex-1 max-w-md">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="cari" 
                        placeholder="Cari nama, email, atau nomor HP..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                    >
                </div>

                <!-- Dropdown Filters -->
                <div class="flex items-center gap-3">
                    <select 
                        wire:model.live="peranDipilih" 
                        class="bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold rounded-2xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 cursor-pointer"
                    >
                        <option value="Semua">Semua Peran / Role</option>
                        @foreach($peranList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_peran }}</option>
                        @endforeach
                    </select>

                    <select 
                        wire:model.live="statusDipilih" 
                        class="bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold rounded-2xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 cursor-pointer"
                    >
                        <option value="Semua">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-4 w-10 text-center">
                                <input 
                                    type="checkbox" 
                                    wire:model.live="selectAll"
                                    class="w-4 h-4 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                >
                            </th>
                            <th class="py-4 px-4">Pengguna</th>
                            <th class="py-4 px-4">Role & Hak Akses</th>
                            <th class="py-4 px-4">Kontak / WA</th>
                            <th class="py-4 px-4">Status</th>
                            <th class="py-4 px-4">Terakhir Masuk</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                        @forelse($penggunaList as $user)
                            <tr 
                                wire:key="row-user-{{ $user->id }}" 
                                class="hover:bg-slate-50/60 transition-colors {{ in_array((string)$user->id, $selectedUsers) ? 'bg-indigo-50/40' : '' }}"
                            >
                                <!-- Checkbox -->
                                <td class="py-4 px-4 text-center">
                                    <input 
                                        type="checkbox" 
                                        value="{{ (string) $user->id }}"
                                        wire:model.live="selectedUsers"
                                        class="w-4 h-4 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                    >
                                </td>

                                <!-- User Avatar & Info -->
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-700 font-extrabold flex items-center justify-center shrink-0 border border-indigo-100 overflow-hidden shadow-xs">
                                            @if($user->foto_profil_url)
                                                <img src="{{ $user->foto_profil_url }}" alt="{{ $user->nama_lengkap }}" class="w-full h-full object-cover" onerror="this.remove()">
                                            @else
                                                <span>{{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-900 text-sm">{{ $user->nama_lengkap }}</span>
                                            <span class="block text-slate-400 text-xs">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Role -->
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl font-bold text-[11px] bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        <i data-lucide="shield" class="w-3 h-3 text-indigo-500"></i>
                                        <span>{{ $user->peran ? $user->peran->nama_peran : 'Administrator' }}</span>
                                    </span>
                                </td>

                                <!-- Phone -->
                                <td class="py-4 px-4">
                                    @if($user->nomor_telepon)
                                        <a 
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->nomor_telepon) }}" 
                                            target="_blank" 
                                            class="inline-flex items-center gap-1.5 text-slate-600 hover:text-emerald-600 font-semibold"
                                        >
                                            <i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-500"></i>
                                            <span>{{ $user->nomor_telepon }}</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic text-[11px]">- Belum ada -</span>
                                    @endif
                                </td>

                                <!-- Status Toggle -->
                                <td class="py-4 px-4">
                                    <button 
                                        type="button"
                                        wire:click="toggleStatus('{{ $user->id }}')" 
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl font-bold text-[11px] transition-all cursor-pointer {{ $user->status_aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100' }}"
                                        title="Klik untuk mengubah status aktif"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full {{ $user->status_aktif ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        <span>{{ $user->status_aktif ? 'Aktif' : 'Non-Aktif' }}</span>
                                    </button>
                                </td>

                                <!-- Last Login -->
                                <td class="py-4 px-4 text-slate-500 text-[11px]">
                                    @if($user->terakhir_masuk)
                                        <span class="font-semibold text-slate-700">{{ $user->terakhir_masuk->diffForHumans() }}</span>
                                        <span class="block text-[10px] text-slate-400">{{ $user->terakhir_masuk->format('d M Y, H:i') }}</span>
                                    @else
                                        <span class="text-slate-400 italic">Belum pernah masuk</span>
                                    @endif
                                </td>

                                <!-- Action Buttons -->
                                <td class="py-4 px-6 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <!-- Reset Password -->
                                        <button 
                                            type="button"
                                            wire:click="bukaModalResetPassword('{{ $user->id }}')" 
                                            title="Reset Password Pengguna" 
                                            class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-xl transition-colors cursor-pointer"
                                        >
                                            <i data-lucide="key" class="w-4 h-4"></i>
                                        </button>

                                        <!-- Edit User -->
                                        <button 
                                            type="button"
                                            wire:click="bukaFormEdit('{{ $user->id }}')" 
                                            title="Edit Profil Pengguna" 
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors cursor-pointer"
                                        >
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>

                                        <!-- Delete User -->
                                        @if(auth()->id() !== $user->id)
                                            <button 
                                                type="button"
                                                wire:click="hapus('{{ $user->id }}')" 
                                                wire:confirm="Apakah Anda yakin ingin menghapus pengguna {{ $user->nama_lengkap }}?"
                                                title="Hapus Pengguna" 
                                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors cursor-pointer"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400 font-medium">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <i data-lucide="users" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-slate-600 font-bold text-sm">Tidak ada data pengguna yang cocok</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba kata kunci pencarian atau ubah filter status.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $penggunaList->links() }}
            </div>

        </div>

    @else
        <!-- ========================================== -->
        <!-- VIEW MODE: FULL IN-PAGE EDITOR FORM        -->
        <!-- ========================================== -->

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xs space-y-8 animate-in fade-in duration-150">
            
            <!-- Form Header & Back Button -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer"
                        title="Kembali ke Daftar Pengguna"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                            <span>FORMULIR PENGGUNA</span>
                            <span>•</span>
                            <span class="text-indigo-600">{{ $penggunaId ? 'EDIT AKUN' : 'AKUN BARU' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            {{ $penggunaId ? 'Edit Data Pengguna CMS' : 'Tambah Pengguna Baru CMS' }}
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
                        wire:loading.attr="disabled"
                        class="px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span wire:loading.remove wire:target="simpan">{{ $penggunaId ? 'Perbarui Pengguna' : 'Simpan Pengguna' }}</span>
                        <span wire:loading.flex wire:target="simpan" class="items-center gap-2">
                            <span>Menyimpan...</span>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Form Content Grid -->
            <form wire:submit="simpan" class="space-y-6 max-w-4xl">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Nama Lengkap Pengguna <span class="text-rose-500">*</span></label>
                        <input 
                            type="text" 
                            wire:model="nama_lengkap" 
                            placeholder="Contoh: Budi Santoso, S.Pd." 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                        >
                        @error('nama_lengkap') <span class="text-[11px] text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                        <input 
                            type="email" 
                            wire:model="email" 
                            placeholder="nama@kormikabbdg.or.id" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                        >
                        @error('email') <span class="text-[11px] text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Nomor Telepon / WhatsApp</label>
                        <input 
                            type="tel" 
                            wire:model="nomor_telepon" 
                            placeholder="08123456789" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                        >
                        @error('nomor_telepon') <span class="text-[11px] text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Peran / Role -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Peran / Hak Akses (Role)</label>
                        <select 
                            wire:model="peran_id" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer"
                        >
                            <option value="">-- Pilih Peran --</option>
                            @foreach($peranList as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_peran }}</option>
                            @endforeach
                        </select>
                        @error('peran_id') <span class="text-[11px] text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-slate-100">
                    <!-- Password -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">
                            {{ $penggunaId ? 'Kata Sandi Baru (Kosongkan jika tidak ingin diganti)' : 'Kata Sandi *' }}
                        </label>
                        <div class="relative">
                            <input 
                                type="{{ $showPassword ? 'text' : 'password' }}" 
                                wire:model="kata_sandi" 
                                placeholder="{{ $penggunaId ? 'Biarkan kosong bila tidak berubah' : 'Minimal 6 karakter' }}" 
                                class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            >
                            <button 
                                type="button" 
                                wire:click="toggleShowPassword" 
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer"
                            >
                                <i data-lucide="{{ $showPassword ? 'eye-off' : 'eye' }}" class="w-4 h-4"></i>
                            </button>
                        </div>
                        @error('kata_sandi') <span class="text-[11px] text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Foto Profil Upload -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">
                            Foto Profil (Opsional)
                            <span class="font-normal text-slate-400 ml-1">&mdash; jpg/png/webp, maks. 5MB</span>
                        </label>

                        @if($uploadFotoProfil)
                            <div class="mb-2 flex items-center gap-3 p-3 bg-emerald-50 border border-emerald-200 rounded-2xl">
                                <img src="{{ $uploadFotoProfil->temporaryUrl() }}" class="w-12 h-12 rounded-xl object-cover shrink-0" alt="Preview">
                                <div class="text-xs">
                                    <p class="font-bold text-emerald-700">{{ $uploadFotoProfil->getClientOriginalName() }}</p>
                                    <p class="text-emerald-600">{{ round($uploadFotoProfil->getSize() / 1024, 1) }} KB &mdash; siap diunggah ke MinIO</p>
                                </div>
                            </div>
                        @elseif($foto_profil)
                            @php $tmpProfil = app(\App\Services\StorageService::class)->getTemporaryUrl($foto_profil) @endphp
                            @if($tmpProfil)
                                <div class="mb-2 flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-2xl">
                                    <img src="{{ $tmpProfil }}" class="w-12 h-12 rounded-xl object-cover shrink-0" alt="Foto Profil Saat Ini">
                                    <div class="text-xs">
                                        <p class="font-semibold text-slate-600">Foto profil saat ini</p>
                                        <p class="text-slate-400 font-mono">{{ Str::limit($foto_profil, 40) }}</p>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <label for="uploadFotoProfilPengguna" class="flex items-center gap-3 w-full px-4 py-3 bg-slate-50 border-2 border-dashed {{ $uploadFotoProfil ? 'border-emerald-400 bg-emerald-50' : 'border-slate-200 hover:border-indigo-400' }} text-slate-700 rounded-2xl text-xs font-semibold cursor-pointer transition-all">
                            <i data-lucide="upload-cloud" class="w-5 h-5 {{ $uploadFotoProfil ? 'text-emerald-500' : 'text-indigo-400' }} shrink-0"></i>
                            <span class="truncate">{{ $uploadFotoProfil ? 'Ganti: ' . $uploadFotoProfil->getClientOriginalName() : 'Klik untuk pilih foto profil' }}</span>
                        </label>
                        <input id="uploadFotoProfilPengguna" type="file" wire:model="uploadFotoProfil" accept="image/jpeg,image/png,image/webp" class="hidden">
                        @error('uploadFotoProfil') <span class="text-xs text-rose-600 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Status Aktif Toggle -->
                <div class="pt-4 border-t border-slate-100">
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            wire:model="status_aktif" 
                            class="w-5 h-5 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                        >
                        <div>
                            <span class="block text-xs font-bold text-slate-800">Status Akun Aktif</span>
                            <span class="block text-[11px] text-slate-400">Pengguna dengan status aktif dapat masuk ke dashboard CMS KORMI.</span>
                        </div>
                    </label>
                </div>

                <!-- Action Submit -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <button 
                        type="button" 
                        wire:click="kembaliKeTabel" 
                        class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="px-8 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span wire:loading.remove wire:target="simpan">{{ $penggunaId ? 'Perbarui Pengguna' : 'Simpan Pengguna' }}</span>
                        <span wire:loading.flex wire:target="simpan" class="items-center gap-2">
                            <span>Menyimpan...</span>
                        </span>
                    </button>
                </div>

            </form>

        </div>

    @endif

    <!-- MODAL SINGLE RESET PASSWORD -->
    @if($tampilkanModalReset)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs animate-in fade-in duration-150">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-5">
                
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold shrink-0">
                        <i data-lucide="key" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Reset Kata Sandi</h3>
                        <p class="text-xs text-slate-500 font-medium">Reset password untuk: <strong class="text-slate-800">{{ $resetUserName }}</strong></p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Baru yang Dihasilkan</label>
                        <input 
                            type="text" 
                            wire:model="resetPasswordBaru" 
                            class="w-full px-4 py-3 bg-amber-50/60 border border-amber-200 rounded-2xl text-sm font-mono font-bold text-amber-900 focus:outline-none"
                        >
                        <p class="text-[11px] text-slate-400 mt-1.5">Salin password ini dan berikan kepada pengguna terkait.</p>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button 
                            type="button" 
                            wire:click="kembaliKeTabel" 
                            class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs cursor-pointer transition-colors"
                        >
                            Batal
                        </button>
                        <button 
                            type="button" 
                            wire:click="simpanResetPassword" 
                            class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-xs shadow-md shadow-amber-600/20 cursor-pointer transition-all active:scale-95"
                        >
                            Terapkan Password Baru
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endif

    <!-- MODAL BULK RESET PASSWORD -->
    @if($tampilkanModalBulkReset)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs animate-in fade-in duration-150">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-5">
                
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold shrink-0">
                        <i data-lucide="key" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Reset Password Massal</h3>
                        <p class="text-xs text-slate-500 font-medium">Atur kata sandi baru untuk <strong class="text-slate-800">{{ count($selectedUsers) }}</strong> akun terpilih</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Baru Massal</label>
                        <input 
                            type="text" 
                            wire:model="bulkPasswordBaru" 
                            placeholder="Minimal 6 karakter"
                            class="w-full px-4 py-3 bg-amber-50/60 border border-amber-200 rounded-2xl text-sm font-mono font-bold text-amber-900 focus:outline-none"
                        >
                        @error('bulkPasswordBaru') <span class="text-[11px] text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                        <p class="text-[11px] text-slate-400 mt-1.5">Seluruh akun yang dipilih akan mendapatkan kata sandi ini.</p>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button 
                            type="button" 
                            wire:click="kembaliKeTabel" 
                            class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs cursor-pointer transition-colors"
                        >
                            Batal
                        </button>
                        <button 
                            type="button" 
                            wire:click="simpanBulkResetPassword" 
                            class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-xs shadow-md shadow-amber-600/20 cursor-pointer transition-all active:scale-95"
                        >
                            Reset Password Sekarang
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endif

</div>
