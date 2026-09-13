<div class="space-y-6">
    <!-- Header -->
    <x-ui.header 
        title="Dashboard Statistik APMO (Angka Partisipasi Masyarakat Olahraga)" 
        subtitle="Analitik data partisipasi olahraga masyarakat per kecamatan dan cabor inorga terpopuler se-Kabupaten Bandung."
        icon="bar-chart-2"
        badge="Analytics Engine"
    >
        <x-slot:actions>
            <div class="flex items-center gap-2">
                <x-form.select wire:model.live="periodeHari" size="sm">
                    <option value="7">7 Hari Terakhir</option>
                    <option value="30">30 Hari Terakhir (Standar APMO)</option>
                    <option value="90">3 Bulan Terakhir</option>
                    <option value="365">1 Tahun Terakhir</option>
                </x-form.select>
                <x-ui.button 
                    href="{{ route('admin.partisipasi.log') }}" 
                    variant="secondary" 
                    icon="list"
                >
                    Log Data Entri
                </x-ui.button>
            </div>
        </x-slot:actions>
    </x-ui.header>

    <!-- Stat Cards KPI APMO -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6">
        <x-ui.stat-card 
            title="Total Partisipan" 
            :value="number_format($totalPartisipan)" 
            icon="users"
            description="Warga terdata berolahraga"
            badge="Orang-Sesi"
            badgeType="emerald"
        />
        <x-ui.stat-card 
            title="Sesi Olahraga" 
            :value="number_format($totalAktivitas)" 
            icon="activity"
            description="Log kegiatan terverifikasi"
        />
        <x-ui.stat-card 
            title="Akumulasi Jam" 
            :value="number_format($totalDurasiJam) . ' Jam'" 
            icon="clock"
            description="Total waktu olahraga warga"
        />
        <x-ui.stat-card 
            title="Pegiat Unik" 
            :value="number_format($totalWargaUnik)" 
            icon="user-check"
            description="Warga aktif individu"
        />
        <x-ui.stat-card 
            title="Duta Penggerak" 
            :value="number_format($totalDutaAktif)" 
            icon="award"
            description="Duta desa aktif melapor"
            badge="Fasilitator"
            badgeType="amber"
        />
    </div>

    <!-- Grid 2 Kolom: Leaderboard Wilayah & Cabor Populer -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Leaderboard Kecamatan -->
        <x-ui.card 
            title="Peringkat Partisipasi Wilayah (Kecamatan Teraktif)" 
            description="Berdasarkan total kegiatan dan jumlah masyarakat yang berolahraga"
            icon="map-pin"
        >
            <div class="divide-y divide-slate-100">
                @forelse($kecamatanStat as $index => $kec)
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-black {{ $index < 3 ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600' }}">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <h4 class="font-extrabold text-slate-800 text-sm">Kec. {{ $kec->nama_kecamatan }}</h4>
                                <span class="text-xs text-slate-500">{{ number_format($kec->total_kegiatan ?? 0) }} sesi kegiatan</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-black text-emerald-600 text-sm block">
                                {{ number_format($kec->total_orang ?? 0) }}
                            </span>
                            <span class="text-[11px] text-slate-400">Warga Terlibat</span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 text-xs">Belum ada data partisipasi wilayah pada periode ini.</div>
                @endforelse
            </div>
        </x-ui.card>

        <!-- Inorga / Cabor Terpopuler -->
        <x-ui.card 
            title="Induk Olahraga (INORGA) Terpopuler" 
            description="Rumpun olahraga rekreasi paling banyak diminati warga"
            icon="trophy"
        >
            <div class="divide-y divide-slate-100">
                @forelse($inorgaStat as $index => $ino)
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-black {{ $index < 3 ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <h4 class="font-extrabold text-slate-800 text-sm">{{ $ino->nama_inorga }}</h4>
                                <span class="text-xs text-slate-500">{{ $ino->komisi?->nama_komisi ?? 'Olahraga Rekreasi' }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-black text-slate-800 text-sm block">
                                {{ number_format($ino->total_kegiatan ?? 0) }} Sesi
                            </span>
                            <span class="text-[11px] text-emerald-600 font-bold">{{ number_format($ino->total_orang ?? 0) }} Partisipan</span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 text-xs">Belum ada data kegiatan inorga pada periode ini.</div>
                @endforelse
            </div>
        </x-ui.card>
    </div>
</div>
