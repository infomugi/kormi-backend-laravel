<div class="space-y-6">
    <!-- Header -->
    <x-ui.header 
        title="Log Partisipasi Olahraga Masyarakat" 
        subtitle="Data pencatatan keaktifan olahraga mandiri warga dan laporan kegiatan massal Duta Olahraga se-Kabupaten Bandung."
        icon="activity"
        badge="APMO Tracker"
    >
        <x-slot:actions>
            <x-ui.button 
                href="{{ route('admin.partisipasi.statistik') }}" 
                variant="emerald" 
                icon="bar-chart-3"
            >
                Dashboard Statistik APMO
            </x-ui.button>
        </x-slot:actions>
    </x-ui.header>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <x-ui.stat-card 
            title="Total Sesi Olahraga" 
            :value="number_format($totalEntri)" 
            icon="activity"
            description="Semua catatan aktivitas"
        />
        <x-ui.stat-card 
            title="Total Warga Terlibat" 
            :value="number_format($totalPartisipan)" 
            icon="users"
            description="Partisipan akumulatif"
            badge="Orang-Sesi"
            badgeType="emerald"
        />
        <x-ui.stat-card 
            title="Pencatatan Mandiri" 
            :value="number_format($totalMandiri)" 
            icon="user"
            description="Input mandiri oleh warga"
        />
        <x-ui.stat-card 
            title="Via Duta Olahraga" 
            :value="number_format($totalViaDuta)" 
            icon="award"
            description="Kegiatan massal / binaan desa"
            badge="Duta Desa"
            badgeType="amber"
        />
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="lg:col-span-2">
                <x-form.input 
                    wire:model.live.debounce.300ms="cari" 
                    placeholder="Cari aktivitas, nama warga, duta, atau lokasi..." 
                    icon="search"
                />
            </div>
            <div>
                <x-form.select wire:model.live="metodeDipilih">
                    <option value="Semua">Metode: Semua Saluran</option>
                    <option value="mandiri">Mandiri (Warga)</option>
                    <option value="via_duta">Via Duta Olahraga</option>
                </x-form.select>
            </div>
            <div>
                <x-form.select wire:model.live="statusDipilih">
                    <option value="Semua">Status: Semua</option>
                    <option value="valid">Valid (Disetujui)</option>
                    <option value="pending_review">Pending Review</option>
                    <option value="ditolak">Ditolak</option>
                </x-form.select>
            </div>
            <div>
                <x-form.select wire:model.live="kecamatanDipilih">
                    <option value="Semua">Kecamatan: Semua Wilayah</option>
                    @foreach($daftarKecamatan as $kec)
                        <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                    @endforeach
                </x-form.select>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session()->has('pesan'))
        <x-ui.alert type="success" :dismissible="true">
            {{ session('pesan') }}
        </x-ui.alert>
    @endif

    <!-- Bulk Action Bar -->
    @if(!empty($selectedRows))
        <div class="bg-emerald-900 text-white p-4 rounded-2xl flex flex-wrap items-center justify-between gap-3 shadow-lg">
            <div class="flex items-center gap-2 text-xs sm:text-sm font-bold">
                <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-lime-300">{{ count($selectedRows) }}</span>
                <span>aktivitas terpilih</span>
            </div>
            <div class="flex items-center gap-2">
                <button 
                    type="button"
                    wire:click="bulkVerifikasi('valid')"
                    class="px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold transition cursor-pointer"
                >
                    Setujui Massal (Valid)
                </button>
                <button 
                    type="button"
                    wire:click="bulkHapus"
                    wire:confirm="Yakin ingin menghapus data aktivitas yang dipilih?"
                    class="px-3 py-1.5 rounded-xl bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 text-xs font-bold transition cursor-pointer"
                >
                    Hapus
                </button>
            </div>
        </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 font-bold text-[11px] uppercase tracking-wider">
                    <tr>
                        <th class="p-4 w-10 text-center">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        </th>
                        <th class="p-4">Tanggal & Waktu</th>
                        <th class="p-4">Aktivitas & Cabor</th>
                        <th class="p-4">Pencatat / Pelapor</th>
                        <th class="p-4">Wilayah & Lokasi</th>
                        <th class="p-4 text-center">Peserta</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($daftarAktivitas as $item)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="p-4 text-center">
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $item->id }}" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="font-bold text-slate-800">{{ $item->tanggal_aktivitas ? $item->tanggal_aktivitas->format('d M Y') : '-' }}</span>
                                <span class="block text-[11px] text-slate-400 mt-0.5">{{ $item->durasi_menit }} Menit</span>
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-slate-900 block">{{ $item->nama_aktivitas }}</span>
                                <span class="text-[11px] text-emerald-600 font-semibold">
                                    {{ $item->inorga?->nama_inorga ?? 'Olahraga Umum' }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($item->metode_pencatatan === 'via_duta')
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200/80">Duta</span>
                                        <span class="font-bold text-slate-800">{{ $item->duta?->nama_lengkap ?? $item->pengguna?->nama_lengkap }}</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-full bg-sky-50 text-sky-700 text-[10px] font-bold border border-sky-200/80">Warga</span>
                                        <span class="font-bold text-slate-800">{{ $item->pengguna?->nama_lengkap }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="font-medium text-slate-800 block">Kec. {{ $item->kecamatan?->nama_kecamatan }}</span>
                                <span class="text-[11px] text-slate-500 block">{{ $item->nama_tempat ?: ($item->desa?->nama_desa_kelurahan ?? '-') }}</span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="font-black text-slate-800 px-2.5 py-1 rounded-xl bg-slate-100">
                                    {{ $item->jumlah_peserta }}
                                </span>
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                @if($item->status_verifikasi === 'valid')
                                    <x-ui.badge variant="emerald" :dot="true">Valid</x-ui.badge>
                                @elseif($item->status_verifikasi === 'pending_review')
                                    <x-ui.badge variant="amber" :dot="true">Review</x-ui.badge>
                                @else
                                    <x-ui.badge variant="rose" :dot="true">Ditolak</x-ui.badge>
                                @endif
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button 
                                        type="button" 
                                        wire:click="bukaDetail('{{ $item->id }}')" 
                                        class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition cursor-pointer"
                                        title="Lihat Detail & Foto Bukti"
                                    >
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                    <button 
                                        type="button" 
                                        wire:click="hapus('{{ $item->id }}')" 
                                        wire:confirm="Hapus catatan aktivitas ini?"
                                        class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 transition cursor-pointer"
                                        title="Hapus"
                                    >
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i data-lucide="inbox" class="w-8 h-8 text-slate-300"></i>
                                    <p class="font-medium text-xs">Belum ada catatan aktivitas olahraga yang sesuai filter.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($daftarAktivitas->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $daftarAktivitas->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Detail & Verifikasi -->
    @if($tampilkanModalDetail && $aktivitasTerpilih)
        <div class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" wire:click="$set('tampilkanModalDetail', false)"></div>
            <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-10 my-8">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900">Detail Aktivitas Olahraga</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $aktivitasTerpilih->nama_aktivitas }}</p>
                    </div>
                    <button type="button" wire:click="$set('tampilkanModalDetail', false)" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center cursor-pointer">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                    <!-- Foto Kegiatan jika ada -->
                    @if($aktivitasTerpilih->foto_kegiatan)
                        <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-100">
                            <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($aktivitasTerpilih->foto_kegiatan) ?? asset($aktivitasTerpilih->foto_kegiatan) }}" alt="Foto Kegiatan" class="w-full h-64 object-cover">
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-400 block font-bold uppercase tracking-wider text-[10px]">Pelapor / Metode</span>
                            <span class="font-extrabold text-slate-800 text-sm mt-0.5 block">
                                {{ $aktivitasTerpilih->metode_pencatatan === 'via_duta' ? 'Via Duta: ' . ($aktivitasTerpilih->duta?->nama_lengkap ?? 'Duta') : $aktivitasTerpilih->pengguna?->nama_lengkap }}
                            </span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-400 block font-bold uppercase tracking-wider text-[10px]">Tanggal & Durasi</span>
                            <span class="font-extrabold text-slate-800 text-sm mt-0.5 block">
                                {{ $aktivitasTerpilih->tanggal_aktivitas->format('d F Y') }} ({{ $aktivitasTerpilih->durasi_menit }} Menit)
                            </span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-400 block font-bold uppercase tracking-wider text-[10px]">Lokasi Kegiatan</span>
                            <span class="font-extrabold text-slate-800 text-sm mt-0.5 block">
                                Kec. {{ $aktivitasTerpilih->kecamatan?->nama_kecamatan }}
                            </span>
                            <span class="text-slate-500 text-[11px]">{{ $aktivitasTerpilih->nama_tempat }}</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-400 block font-bold uppercase tracking-wider text-[10px]">Partisipan</span>
                            <span class="font-extrabold text-slate-800 text-sm mt-0.5 block">
                                {{ $aktivitasTerpilih->jumlah_peserta }} Orang
                            </span>
                            <span class="text-slate-500 text-[11px] capitalize">{{ str_replace('_', ' ', $aktivitasTerpilih->jenis_partisipasi) }}</span>
                        </div>
                    </div>

                    @if($aktivitasTerpilih->catatan)
                        <div class="p-3.5 rounded-2xl bg-amber-50/60 border border-amber-200/80 text-xs">
                            <span class="font-bold text-amber-900 block mb-1">Catatan Tambahan:</span>
                            <p class="text-amber-800">{{ $aktivitasTerpilih->catatan }}</p>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3">
                    <button 
                        type="button" 
                        wire:click="verifikasi('{{ $aktivitasTerpilih->id }}', 'ditolak')" 
                        class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition cursor-pointer"
                    >
                        Tolak Aktivitas
                    </button>
                    <div class="flex items-center gap-2">
                        <button 
                            type="button" 
                            wire:click="$set('tampilkanModalDetail', false)" 
                            class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition cursor-pointer"
                        >
                            Tutup
                        </button>
                        <button 
                            type="button" 
                            wire:click="verifikasi('{{ $aktivitasTerpilih->id }}', 'valid')" 
                            class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition cursor-pointer shadow-md shadow-emerald-600/20"
                        >
                            Setujui (Valid)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
