    {{-- Dashboard khusus peran Duta Olahraga — desain mobile_kormi.html --}}
    <div class="kd-mobile min-h-screen">
        <div class="kd-header">
            <div class="kd-brand">
                <div class="kd-brand-icon">K</div>
                <span class="kd-brand-title">KORMI Kab. Bandung</span>
            </div>
            <p class="kd-brand-sub">Dashboard Duta Olahraga</p>
        </div>

        <div class="kd-sheet">
            <div class="kd-section-head">
                <div>
                    <h3>Halo, {{ \Illuminate\Support\Str::words($user->nama_lengkap, 2, '') }}</h3>
                    <p>Ringkasan peran dan aktivitas olahraga Anda.</p>
                </div>
                <span class="kd-badge">Duta</span>
            </div>

            <div class="kd-account" style="display: flex; align-items: center; gap: 12px;">
                <span class="kd-duta-avatar" style="width: 52px; height: 52px; font-size: 17px;">
                    @if($duta?->foto_duta_url)
                        <img src="{{ $duta->foto_duta_url }}" alt="{{ $user->nama_lengkap }}" loading="lazy">
                    @else
                        {{ $duta?->initial_dua_huruf ?? strtoupper(\Illuminate\Support\Str::substr($user->nama_lengkap, 0, 2)) }}
                    @endif
                </span>
                <div style="min-width: 0; flex: 1;">
                    <strong style="display: block; font-size: 13px; font-weight: 800; line-height: 1.35;">{{ $user->nama_lengkap }}</strong>
                    <div style="display: flex; flex-wrap: wrap; gap: 5px; margin-top: 6px;">
                        @if($duta?->desaKelurahan)
                            <span class="kd-chip">Desa {{ $duta->desaKelurahan->nama_desa_kelurahan }}</span>
                        @endif
                        @if($duta?->kecamatan)
                            <span class="kd-chip">Kec. {{ $duta->kecamatan->nama_kecamatan }}</span>
                        @endif
                    </div>
                </div>
            </div>

            @if(! $duta)
                <div class="kd-notice kd-notice-amber">
                    <i data-lucide="link-2-off"></i>
                    <span>Akun Anda belum terhubung dengan data Duta Olahraga. <a href="{{ route('mobile.daftar-duta') }}" wire:navigate style="font-weight: 800; color: inherit; text-decoration: underline;">Lengkapi pendaftaran duta</a>.</span>
                </div>
            @elseif($duta->sedangMenunggu())
                <div class="kd-notice kd-notice-amber">
                    <i data-lucide="clock"></i>
                    <span>Pendaftaran duta Anda sedang <strong>menunggu verifikasi</strong> Administrator KORMI.</span>
                </div>
            @endif

            <div class="kd-subhead">
                <h4>Ringkasan Aktivitas</h4>
                <span class="kd-chip {{ $stats['valid'] > 0 ? 'kd-chip--dark' : '' }}">{{ $stats['valid'] }} valid</span>
            </div>

            <div class="kd-stats">
                <div class="kd-stat">
                    <span class="kd-stat-icon"><i data-lucide="activity"></i></span>
                    <span>
                        <span class="kd-stat-value">{{ $stats['total'] }}</span>
                        <span class="kd-stat-label">Total Sesi</span>
                    </span>
                </div>
                <div class="kd-stat">
                    <span class="kd-stat-icon"><i data-lucide="calendar-check"></i></span>
                    <span>
                        <span class="kd-stat-value">{{ $stats['bulanIni'] }}</span>
                        <span class="kd-stat-label">Bulan Ini</span>
                    </span>
                </div>
                <div class="kd-stat">
                    <span class="kd-stat-icon"><i data-lucide="users"></i></span>
                    <span>
                        <span class="kd-stat-value">{{ number_format($stats['peserta']) }}</span>
                        <span class="kd-stat-label">Peserta</span>
                    </span>
                </div>
                <div class="kd-stat">
                    <span class="kd-stat-icon"><i data-lucide="shield-check"></i></span>
                    <span>
                        <span class="kd-stat-value">{{ $stats['valid'] }}</span>
                        <span class="kd-stat-label">Terverifikasi</span>
                    </span>
                </div>
            </div>

            <div class="kd-success-actions" style="margin: 16px 0 4px;">
                <a href="{{ route('partisipasi.catat') }}" wire:navigate class="kd-btn-primary">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Catat Aktivitas Olahraga</span>
                </a>
                <a href="{{ route('partisipasi.riwayat') }}" wire:navigate class="kd-btn-ghost">
                    <i data-lucide="history" class="w-4 h-4"></i>
                    <span>Riwayat Aktivitas</span>
                </a>
            </div>

            <div class="kd-subhead">
                <h4>Aktivitas Terbaru</h4>
                <a href="{{ route('partisipasi.riwayat') }}" wire:navigate>Lihat semua</a>
            </div>

            @forelse($terbaru as $log)
                <div class="kd-item">
                    <span class="kd-module-icon"><i data-lucide="footprints"></i></span>
                    <span class="kd-item-body">
                        <span class="kd-item-title">{{ $log->nama_aktivitas }}</span>
                        <span class="kd-item-meta" style="text-transform: none;">
                            {{ \Carbon\Carbon::parse($log->tanggal_aktivitas)->translatedFormat('d M Y') }}
                            <span>· {{ $log->durasi_menit }} menit · {{ $log->jumlah_peserta }} peserta</span>
                        </span>
                    </span>
                    @if($log->status_verifikasi === 'valid')
                        <span class="kd-chip">Valid</span>
                    @elseif($log->status_verifikasi === 'ditolak')
                        <span class="kd-chip kd-chip--danger">Ditolak</span>
                    @else
                        <span class="kd-chip kd-chip--warn">Menunggu</span>
                    @endif
                </div>
            @empty
                <div class="kd-empty">
                    <i data-lucide="activity"></i>
                    <strong>Belum ada aktivitas tercatat</strong>
                    <p>Catat sesi olahraga pertama Anda dan kontribusikan pada APMO Kabupaten Bandung.</p>
                    <a href="{{ route('partisipasi.catat') }}" wire:navigate class="kd-page-btn">Catat sekarang</a>
                </div>
            @endforelse

            <form method="POST" action="{{ route('admin.keluar') }}" style="margin-top: 18px;">
                @csrf
                <button type="submit" class="kd-btn-ghost" style="width: 100%;">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Keluar dari Akun</span>
                </button>
            </form>

            <p class="kd-footnote">Masuk sebagai {{ $user->email }}</p>
        </div>

        <x-mobile.tabbar aktif="dashboard" />
    </div>
