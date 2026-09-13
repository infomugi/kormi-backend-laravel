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
        <div wire:key="pengguna-view-tabel" class="space-y-6">

            <!-- 1. HEADER & PRIMARY ACTION (COMPACT PRO COMPONENT) -->
            <x-table.header
                title="Kelola Pengguna CMS"
                subtitle="Manajemen hak akses, role administrator, kredensial login, dan akun pengelola KORMI Kabupaten Bandung."
                badge="Administrasi Sistem • Manajemen Pengguna"
                icon="users"
                color="blue"
            >
                <x-slot:actions>
                    <div class="flex items-center gap-2.5">
                        <a 
                            href="{{ route('admin.peran') }}" 
                            wire:navigate
                            class="inline-flex items-center justify-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs uppercase tracking-wider border border-emerald-200/80 transition-all cursor-pointer"
                        >
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                            <span>Peran & Hak Akses</span>
                        </a>
                        <button 
                            type="button" 
                            wire:click="bukaFormTambah"
                            class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-blue-600 via-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-blue-600/20 hover:shadow-lg transition-all cursor-pointer active:scale-95 group"
                        >
                            <i data-lucide="user-plus" class="w-4 h-4 transition-transform group-hover:scale-110 duration-200"></i>
                            <span>Tambah Pengguna Baru</span>
                        </button>
                    </div>
                </x-slot:actions>
            </x-table.header>

            <!-- 2. FULL-WIDTH KPI METRIC STATS (4 Cards Symmetric Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 w-full">
                <x-table.stats-card
                    title="Total Pengguna"
                    :value="number_format($totalPengguna)"
                    unit="User"
                    subtitle="Semua akun terdaftar"
                    icon="users"
                    color="slate"
                    :active="$peranDipilih === 'Semua' && $statusDipilih === 'Semua'"
                    loading-target="resetSemuaFilter, setFilterPeran, setFilterStatus"
                    wire:click="resetSemuaFilter"
                />

                <x-table.stats-card
                    title="Akun Aktif"
                    :value="number_format($totalAktif)"
                    unit="User"
                    subtitle="Bisa login ke CMS"
                    icon="user-check"
                    color="emerald"
                    :pulse="true"
                    :active="$statusDipilih === 'Aktif'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('Aktif')"
                />

                <x-table.stats-card
                    title="Akun Non-Aktif"
                    :value="number_format($totalNonAktif)"
                    unit="User"
                    subtitle="Akses login ditutup"
                    icon="user-x"
                    color="rose"
                    :active="$statusDipilih === 'Non-Aktif'"
                    loading-target="setFilterStatus"
                    wire:click="setFilterStatus('Non-Aktif')"
                />

                <x-table.stats-card
                    title="Role Admin"
                    :value="number_format($totalAdmin)"
                    unit="Akun"
                    subtitle="Hak akses struktural"
                    icon="shield-check"
                    color="indigo"
                    loading-target="cari, setFilterPeran"
                />
            </div>

            <!-- 3. FILTER & SEARCH TOOLBAR -->
            <x-table.filter-bar 
                search-placeholder="Cari nama pengguna, email, nomor WhatsApp..." 
                search-model="cari"
            >
                <x-slot:top>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none w-full">
                        <button 
                            type="button"
                            wire:click="setFilterStatus('Semua')" 
                            class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $statusDipilih === 'Semua' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <span>Semua Status</span>
                        </button>
                        <button 
                            type="button"
                            wire:click="setFilterStatus('Aktif')" 
                            class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $statusDipilih === 'Aktif' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <span>Aktif</span>
                        </button>
                        <button 
                            type="button"
                            wire:click="setFilterStatus('Non-Aktif')" 
                            class="px-3.5 py-2 rounded-2xl text-xs font-bold whitespace-nowrap shrink-0 transition-all cursor-pointer flex items-center gap-2 {{ $statusDipilih === 'Non-Aktif' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200/80' }}"
                        >
                            <span>Non-Aktif</span>
                        </button>
                    </div>
                </x-slot:top>

                <x-slot:actions>
                    <!-- Role Filter -->
                    <select 
                        wire:model.live="peranDipilih" 
                        class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer max-w-[180px]"
                    >
                        <option value="Semua">Semua Role Peran</option>
                        @foreach($peranList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_peran }}</option>
                        @endforeach
                    </select>

                    <!-- Sort By -->
                    <select wire:model.live="sortField" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="dibuat_pada">Urutan: Terdaftar</option>
                        <option value="nama_lengkap">Urutan: Nama Lengkap</option>
                        <option value="email">Urutan: Email</option>
                        <option value="status_aktif">Urutan: Status</option>
                    </select>

                    <!-- Direction -->
                    <select wire:model.live="sortDirection" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="desc">Z-A / Terbaru (DESC)</option>
                        <option value="asc">A-Z / Terlama (ASC)</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage" class="px-3 py-2 bg-slate-50/80 hover:bg-slate-100/80 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="10">10 / hal</option>
                        <option value="20">20 / hal</option>
                        <option value="50">50 / hal</option>
                    </select>

                    <!-- View Switcher -->
                    <div 
                        x-data="{
                            mode: localStorage.getItem('kormi_pengguna_view') || @js($tampilanMode),
                            setMode(val) {
                                this.mode = val;
                                localStorage.setItem('kormi_pengguna_view', val);
                                $wire.set('tampilanMode', val);
                            }
                        }"
                        x-init="
                            if (localStorage.getItem('kormi_pengguna_view') && localStorage.getItem('kormi_pengguna_view') !== @js($tampilanMode)) {
                                $wire.set('tampilanMode', localStorage.getItem('kormi_pengguna_view'));
                            }
                        "
                        class="flex items-center p-1 bg-slate-100 rounded-2xl border border-slate-200 shrink-0"
                    >
                        <button 
                            type="button" 
                            @click="setMode('tabel')" 
                            :class="mode === 'tabel' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-400 hover:text-slate-700'"
                            class="p-1.5 rounded-xl transition-all cursor-pointer"
                            title="Tampilan Datatable"
                        >
                            <i data-lucide="list" class="w-4 h-4"></i>
                        </button>
                        <button 
                            type="button" 
                            @click="setMode('grid')" 
                            :class="mode === 'grid' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-400 hover:text-slate-700'"
                            class="p-1.5 rounded-xl transition-all cursor-pointer"
                            title="Tampilan Grid Kartu"
                        >
                            <i data-lucide="layout-grid" class="w-4 h-4"></i>
                        </button>
                    </div>
                </x-slot:actions>
            </x-table.filter-bar>

            <!-- 4. FLOATING BULK ACTIONS BAR -->
            <x-table.bulk-bar :count="count($selectedUsers)" label="Pengguna dipilih" reset-action="$set('selectedUsers', [])">
                <button 
                    type="button" 
                    wire:click="bulkEnableLogin" 
                    class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                    <span>Enable Login</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkDisableLogin" 
                    wire:confirm="Nonaktifkan akses login untuk akun pengguna terpilih?"
                    class="px-3 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="user-x" class="w-3.5 h-3.5"></i>
                    <span>Disable Login</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bukaModalBulkResetPassword" 
                    class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="key" class="w-3.5 h-3.5"></i>
                    <span>Reset Password</span>
                </button>

                <button 
                    type="button" 
                    wire:click="bulkHapus" 
                    wire:confirm="Yakin ingin menghapus seluruh akun pengguna terpilih secara permanen?"
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus Terpilih</span>
                </button>
            </x-table.bulk-bar>

            <!-- 5. CONTENT (DATATABLE & GRID CARDS) -->
            @if($tampilanMode === 'tabel')
                <x-table.card>
                    <x-table.table loading-target="cari, peranDipilih, statusDipilih, sortField, sortDirection, perPage, gotoPage, nextPage, previousPage">
                        <x-table.thead>
                            <tr>
                                <x-table.th align="center" class="w-12 !px-4">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="selectAll" 
                                        class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                    >
                                </x-table.th>
                                <x-table.th 
                                    sortable 
                                    sort-field="nama_lengkap" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Informasi Profil & Email
                                </x-table.th>
                                <x-table.th>Role Peran</x-table.th>
                                <x-table.th>Kontak / WhatsApp</x-table.th>
                                <x-table.th 
                                    align="center"
                                    sortable 
                                    sort-field="status_aktif" 
                                    :current-sort="$sortField" 
                                    :current-direction="$sortDirection"
                                >
                                    Status
                                </x-table.th>
                                <x-table.th>Waktu Terdaftar</x-table.th>
                                <x-table.th align="center" class="w-32">Aksi</x-table.th>
                            </tr>
                        </x-table.thead>

                        <x-table.tbody>
                            @forelse($penggunaList as $user)
                                <x-table.tr :selected="in_array((string)$user->id, $selectedUsers)">
                                    <!-- Checkbox -->
                                    <x-table.td align="center" class="!px-4">
                                        <input 
                                            type="checkbox" 
                                            value="{{ (string) $user->id }}"
                                            wire:model.live="selectedUsers" 
                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                        >
                                    </x-table.td>

                                    <!-- User Info & Avatar -->
                                    <x-table.td>
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-700 font-extrabold flex items-center justify-center shrink-0 border border-indigo-100 overflow-hidden shadow-2xs">
                                                @if($user->foto_profil_url)
                                                    <img src="{{ $user->foto_profil_url }}" alt="{{ $user->nama_lengkap }}" class="w-full h-full object-cover">
                                                @else
                                                    <span>{{ substr($user->nama_lengkap, 0, 2) }}</span>
                                                @endif
                                            </div>

                                            <div class="min-w-0">
                                                <h3 class="font-black text-slate-900 text-sm leading-snug group-hover:text-indigo-600 transition-colors">
                                                    {{ $user->nama_lengkap }}
                                                </h3>
                                                <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1.5 font-medium">
                                                    <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i>
                                                    <span class="truncate">{{ $user->email }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </x-table.td>

                                    <!-- Role -->
                                    <x-table.td>
                                        @php
                                            $roleBadge = match($user->peran->nama_peran ?? '') {
                                                'Super Admin' => 'bg-purple-50 text-purple-700 border-purple-200/80',
                                                'Admin' => 'bg-indigo-50 text-indigo-700 border-indigo-200/80',
                                                default => 'bg-slate-100 text-slate-700 border-slate-200/80'
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider border {{ $roleBadge }}">
                                            {{ $user->peran->nama_peran ?? 'Pengguna' }}
                                        </span>
                                    </x-table.td>

                                    <!-- Telepon -->
                                    <x-table.td>
                                        @if($user->nomor_telepon)
                                            <span class="font-bold text-slate-700 text-xs flex items-center gap-1.5">
                                                <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>{{ $user->nomor_telepon }}</span>
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-xs font-medium">-</span>
                                        @endif
                                    </x-table.td>

                                    <!-- Status -->
                                    <x-table.td align="center">
                                        <button 
                                            type="button" 
                                            wire:click="toggleStatus('{{ $user->id }}')" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer border {{ $user->status_aktif ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-rose-50 text-rose-700 border-rose-200 hover:bg-rose-100' }}"
                                            title="Klik untuk mengubah status aktif akun"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full {{ $user->status_aktif ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                            <span>{{ $user->status_aktif ? 'Aktif' : 'Non-Aktif' }}</span>
                                        </button>
                                    </x-table.td>

                                    <!-- Tanggal Terdaftar -->
                                    <x-table.td>
                                        <span class="text-xs text-slate-500 font-medium">
                                            {{ \Carbon\Carbon::parse($user->dibuat_pada)->format('d M Y') }}
                                        </span>
                                    </x-table.td>

                                    <!-- Actions -->
                                    <x-table.td align="center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <x-table.action-btn 
                                                size="sm"
                                                variant="warning" 
                                                icon="edit-3" 
                                                loading-target="bukaFormEdit('{{ $user->id }}')"
                                                wire:click="bukaFormEdit('{{ $user->id }}')" 
                                                title="Edit Pengguna" 
                                            />

                                            <button 
                                                type="button" 
                                                wire:click="bukaModalResetPassword('{{ $user->id }}')" 
                                                class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all cursor-pointer"
                                                title="Reset Password"
                                            >
                                                <i data-lucide="key" class="w-4 h-4"></i>
                                            </button>

                                            <x-table.action-btn 
                                                size="sm"
                                                variant="danger" 
                                                icon="trash-2" 
                                                loading-target="hapus('{{ $user->id }}')"
                                                wire:click="hapus('{{ $user->id }}')" 
                                                wire:confirm="Yakin ingin menghapus pengguna '{{ $user->nama_lengkap }}'?" 
                                                title="Hapus Pengguna" 
                                            />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty 
                                    colspan="7" 
                                    icon="users" 
                                    title="Belum ada pengguna ditemukan" 
                                    description="Silakan tambahkan akun administrator atau staf pengelola baru."
                                />
                            @endforelse
                        </x-table.tbody>
                    </x-table.table>

                    @if($penggunaList->hasPages())
                        <x-slot:footer>
                            <div class="px-4 py-3 flex items-center justify-between">
                                {{ $penggunaList->links() }}
                            </div>
                        </x-slot:footer>
                    @endif
                </x-table.card>
            @else
                <!-- Grid View Mode -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($penggunaList as $user)
                        <div wire:key="grid-user-{{ $user->id }}" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between group {{ in_array((string)$user->id, $selectedUsers) ? 'ring-2 ring-indigo-500' : '' }}">
                            <div>
                                <div class="flex items-start justify-between gap-3 mb-4">
                                    <div class="flex items-center gap-2">
                                        <input 
                                            type="checkbox" 
                                            value="{{ (string) $user->id }}"
                                            wire:model.live="selectedUsers" 
                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer shadow-xs"
                                        >
                                        <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider border {{ $user->peran->nama_peran === 'Super Admin' ? 'bg-purple-50 text-purple-700 border-purple-200' : 'bg-indigo-50 text-indigo-700 border-indigo-200' }}">
                                            {{ $user->peran->nama_peran ?? 'Pengguna' }}
                                        </span>
                                    </div>

                                    <button 
                                        type="button" 
                                        wire:click="toggleStatus('{{ $user->id }}')" 
                                        class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $user->status_aktif ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}"
                                    >
                                        {{ $user->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                                    </button>
                                </div>

                                <div class="flex items-center gap-3.5 mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-700 font-black text-base flex items-center justify-center shrink-0 border border-indigo-100 overflow-hidden shadow-xs">
                                        @if($user->foto_profil_url)
                                            <img src="{{ $user->foto_profil_url }}" alt="{{ $user->nama_lengkap }}" class="w-full h-full object-cover">
                                        @else
                                            <span>{{ substr($user->nama_lengkap, 0, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="text-sm font-black text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $user->nama_lengkap }}</h3>
                                        <span class="text-xs text-slate-400 font-medium line-clamp-1 mt-0.5">{{ $user->email }}</span>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-slate-100 space-y-1 text-xs text-slate-500">
                                    <p class="flex items-center gap-1.5">
                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>{{ $user->nomor_telepon ?: '-' }}</span>
                                    </p>
                                    <p class="flex items-center gap-1.5">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>Terdaftar {{ \Carbon\Carbon::parse($user->dibuat_pada)->format('d M Y') }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-end gap-1.5">
                                <button wire:click="bukaFormEdit('{{ $user->id }}')" title="Edit Pengguna" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all cursor-pointer">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <button wire:click="bukaModalResetPassword('{{ $user->id }}')" title="Reset Password" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-amber-50 hover:text-amber-600 transition-all cursor-pointer">
                                    <i data-lucide="key" class="w-4 h-4"></i>
                                </button>
                                <button wire:click="hapus('{{ $user->id }}')" wire:confirm="Yakin ingin menghapus pengguna ini?" title="Hapus Pengguna" class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition-all cursor-pointer">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                            <i data-lucide="users" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                            <p class="text-sm font-bold text-slate-600">Belum ada pengguna ditemukan.</p>
                            <button type="button" wire:click="bukaFormTambah" class="mt-4 px-5 py-2.5 rounded-2xl bg-indigo-600 text-white font-bold text-xs cursor-pointer">
                                + Tambah Pengguna Baru
                            </button>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $penggunaList->links() }}
                </div>
            @endif

        </div>

    @elseif($mode === 'form')
        <!-- ========================================== -->
        <!-- VIEW MODE: IN-PAGE FORM PENGGUNA (UI KIT)  -->
        <!-- ========================================== -->
        <div wire:key="pengguna-view-form" class="space-y-6 animate-in fade-in duration-150 max-w-7xl mx-auto">
            <!-- 1. FORM HEADER BANNER -->
            <x-form.header
                :title="$penggunaId ? 'Edit Data Pengguna CMS' : 'Registrasi Akun Pengguna Baru'"
                subtitle="Atur identitas akun, role hak akses, nomor kontak WhatsApp, dan kata sandi login."
                :badge="$penggunaId ? 'Mode Edit Akun' : 'Akun Baru'"
                icon="user"
            >
                <x-slot:actions>
                    <x-form.button 
                        variant="ghost" 
                        size="default" 
                        icon="arrow-left" 
                        wire:click="kembaliKeTabel"
                    >
                        Batal
                    </x-form.button>
                    <x-form.button 
                        variant="primary" 
                        size="default" 
                        icon="check" 
                        loading-target="simpan"
                        wire:click="simpan"
                    >
                        {{ $penggunaId ? 'Perbarui Pengguna' : 'Simpan Pengguna' }}
                    </x-form.button>
                </x-slot:actions>
            </x-form.header>

            <!-- 2. MAIN FORM CONTENT (2 Columns: 8 cols Metadata + 4 cols Foto & Info) -->
            <form wire:submit.prevent="simpan" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Left Column (8 cols): Data Akun & Akses -->
                    <div class="lg:col-span-8 space-y-6">
                        <x-form.card 
                            title="Informasi Akun & Kredensial" 
                            subtitle="Identitas nama, email login, nomor kontak WhatsApp, dan hak akses."
                            icon="user-check"
                        >
                            <!-- Nama Lengkap -->
                            <x-form.field label="Nama Lengkap Pengguna" name="nama_lengkap" :required="true">
                                <x-form.input 
                                    name="nama_lengkap" 
                                    wire:model="nama_lengkap" 
                                    placeholder="Contoh: Budi Santoso, S.Pd." 
                                    size="lg"
                                    class="font-black text-slate-900"
                                />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Email -->
                                <x-form.field label="Alamat Email Login" name="email" :required="true">
                                    <x-form.input 
                                        type="email" 
                                        name="email" 
                                        wire:model="email" 
                                        placeholder="nama@kormikabbdg.or.id" 
                                        icon="mail"
                                    />
                                </x-form.field>

                                <!-- Nomor Telepon -->
                                <x-form.field label="Nomor Telepon / WhatsApp" name="nomor_telepon">
                                    <x-form.input 
                                        type="tel" 
                                        name="nomor_telepon" 
                                        wire:model="nomor_telepon" 
                                        placeholder="08123456789" 
                                        icon="phone"
                                    />
                                </x-form.field>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Role / Hak Akses -->
                                <x-form.field label="Peran / Hak Akses (Role)" name="peran_id" :required="true">
                                    <x-form.select name="peran_id" wire:model="peran_id">
                                        <option value="">-- Pilih Peran --</option>
                                        @foreach($peranList as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama_peran }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <!-- Kata Sandi -->
                                <x-form.field 
                                    :label="$penggunaId ? 'Kata Sandi Baru (Kosongkan jika tetap)' : 'Kata Sandi Login'" 
                                    name="kata_sandi" 
                                    :required="!$penggunaId"
                                >
                                    <div class="relative">
                                        <x-form.input 
                                            :type="$showPassword ? 'text' : 'password'" 
                                            name="kata_sandi" 
                                            wire:model="kata_sandi" 
                                            :placeholder="$penggunaId ? 'Biarkan kosong bila tidak berubah' : 'Minimal 6 karakter'" 
                                            icon="lock"
                                        />
                                        <button 
                                            type="button" 
                                            wire:click="toggleShowPassword" 
                                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer z-10"
                                        >
                                            <i data-lucide="{{ $showPassword ? 'eye-off' : 'eye' }}" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </x-form.field>
                            </div>

                            <!-- Status Aktif Toggle -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <label for="statusAktifPengguna" class="text-xs font-black text-slate-900 cursor-pointer">Status Akun Aktif</label>
                                    <p class="text-xs text-slate-500">Pengguna dengan status aktif dapat masuk ke dashboard CMS KORMI.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="statusAktifPengguna" wire:model="status_aktif" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>
                        </x-form.card>
                    </div>

                    <!-- Right Column (4 cols): Foto Profil & Guide -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Foto Profil Card -->
                        <x-form.card 
                            title="Foto Profil Pengguna" 
                            subtitle="Visual avatar akun pengelola CMS."
                            icon="image"
                        >
                            <x-form.image-upload
                                :upload="$uploadFotoProfil"
                                :saved-path="$foto_profil"
                                name="uploadFotoProfil"
                                input-id="uploadFotoProfilPengguna"
                                empty-title="Unggah Foto Profil"
                                empty-subtitle="Format JPG, PNG, WEBP (Maksimal 5MB)"
                                :max-size-m-b="5"
                                aspect-ratio="h-48 sm:h-56"
                            />
                        </x-form.card>

                        <!-- Guide Information Card -->
                        <div class="bg-indigo-50/70 border border-indigo-200/80 rounded-3xl p-5 space-y-3">
                            <h4 class="text-xs font-black text-indigo-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="shield" class="w-4 h-4 text-indigo-600"></i>
                                <span>Keamanan Akun CMS</span>
                            </h4>
                            <div class="space-y-2 text-xs text-indigo-950 leading-relaxed">
                                <p>Pastikan peran pengguna sesuai wewenang. Password dienkripsi dengan standar aman Bcrypt.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. ACTION BAR -->
                <x-form.action-bar>
                    <x-form.button 
                        type="button" 
                        variant="secondary" 
                        wire:click="kembaliKeTabel"
                    >
                        Batal
                    </x-form.button>

                    <x-form.button 
                        type="submit" 
                        variant="primary" 
                        icon="save" 
                        loading-target="simpan"
                    >
                        {{ $penggunaId ? 'Perbarui Pengguna' : 'Simpan Pengguna' }}
                    </x-form.button>
                </x-form.action-bar>
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
