{{-- Dashboard mobile gaya super app — fokus Absensi & Survei APMO --}}
@php
    $avatar = $user->foto_profil_url ?: $duta?->foto_duta_url;
    $namaKata = preg_split('/\s+/', trim($user->nama_lengkap));
    $inisial = count($namaKata) > 1
        ? strtoupper(mb_substr($namaKata[0], 0, 1) . mb_substr($namaKata[count($namaKata) - 1], 0, 1))
        : strtoupper(mb_substr($user->nama_lengkap, 0, 2));
    $desa = $duta?->desaKelurahan?->nama_desa_kelurahan ?? $user->desa?->nama_desa_kelurahan;
    $kecamatan = $duta?->kecamatan?->nama_kecamatan ?? $user->kecamatan?->nama_kecamatan;
    $lokasi = collect([$desa ? 'Desa ' . $desa : null, $kecamatan ? 'Kec. ' . $kecamatan : null])->filter();
    $tahap = $absensi['tahap'];
    $judulAbsen = match ($tahap) {
        'selesai' => 'Kehadiran hari ini lengkap',
        'pulang' => 'Sudah absen masuk',
        default => 'Belum absen masuk',
    };
    $labelAbsen = match ($tahap) {
        'selesai' => 'Lengkap',
        'pulang' => 'Sudah Masuk',
        default => 'Belum Absen',
    };
    $chipAbsen = match ($tahap) {
        'selesai' => 'kd-chip--lime',
        'pulang' => 'kd-chip--soft',
        default => 'kd-chip--warn',
    };
    $ctaAbsen = match ($tahap) {
        'selesai' => 'Lihat Rekap Kehadiran',
        'pulang' => 'Absen Pulang Sekarang',
        default => 'Absen Masuk Sekarang',
    };
@endphp

<div class="kd-mobile kd-home min-h-screen">
    <header class="kd-home-head">
        <div class="kd-home-top">
            <div class="kd-home-brand">
                <span class="kd-home-logo">K</span>
                <span class="kd-home-brand-text">
                    <strong>KORMI</strong>
                    <span>Kab. Bandung</span>
                </span>
            </div>
            <a href="{{ route('mobile.profil') }}" wire:navigate class="kd-home-avatar" aria-label="Buka profil {{ $user->nama_lengkap }}">
                @if($avatar)
                    <img src="{{ $avatar }}" alt="{{ $user->nama_lengkap }}" loading="lazy">
                @else
                    <span>{{ $inisial }}</span>
                @endif
            </a>
        </div>

        <div class="kd-home-greet">
            <p>{{ $sapaan }},</p>
            <h1>{{ $user->nama_lengkap }}</h1>
            <div class="kd-home-meta">
                <span class="kd-home-pill is-role">{{ $badgePeran }}</span>
                @if($lokasi->isNotEmpty())
                    <span class="kd-home-pill"><i data-lucide="map-pin"></i>{{ $lokasi->implode(' · ') }}</span>
                @endif
            </div>
        </div>
    </header>

    <div class="kd-home-body">
        @if($isDuta)
            {{-- Hero absensi hari ini --}}
            <section class="kd-home-att" aria-label="Status absensi hari ini">
            <div class="kd-home-att-head">
                <span class="kd-home-att-icon"><i data-lucide="fingerprint"></i></span>
                <span class="kd-home-att-copy">
                    <span class="kd-home-overline">Absensi hari ini</span>
                    <strong>{{ $judulAbsen }}</strong>
                </span>
                <span class="kd-chip {{ $chipAbsen }}">{{ $labelAbsen }}</span>
            </div>

            <div class="kd-home-att-times">
                <span class="kd-home-time">
                    <span>Masuk</span>
                    <strong class="{{ $absensi['hariIni'] ? '' : 'is-muted' }}">
                        {{ $absensi['hariIni']->jam_masuk_rapi ?? '--:--' }} WIB
                    </strong>
                </span>
                <span class="kd-home-time">
                    <span>Pulang</span>
                    <strong class="{{ $absensi['hariIni']?->sudahPulang() ? '' : 'is-muted' }}">
                        {{ $absensi['hariIni']->jam_pulang_rapi ?? '--:--' }} WIB
                    </strong>
                </span>
            </div>

            <span class="kd-home-att-date">
                <i data-lucide="clock"></i>
                {{ $absensi['tanggalRapi'] }} · {{ $absensi['jamSekarang'] }} WIB
            </span>

            <a href="{{ route('mobile.absensi') }}" wire:navigate class="kd-home-att-cta">
                <span>{{ $ctaAbsen }}</span>
                <i data-lucide="arrow-right"></i>
            </a>
        </section>

        {{-- Kartu survei APMO --}}
        <section class="kd-home-apmo" aria-label="Survei APMO">
            <div class="kd-home-apmo-top">
                <span class="kd-home-apmo-icon"><i data-lucide="clipboard-list"></i></span>
                <span class="kd-home-apmo-copy">
                    <span class="kd-home-overline">Program APMO</span>
                    <strong>Survei APMO</strong>
                </span>
                <span class="kd-chip">{{ $apmo['sudah'] ? 'Sudah diisi' : 'Belum diisi' }}</span>
            </div>

            <p>
                @if($apmo['sudah'])
                    Terakhir diisi {{ $apmo['waktuRapi'] }} · {{ $apmo['jumlah'] }} kali pengisian. Perbarui jawaban bila kebiasaan olahraga Anda berubah.
                @else
                    Bantu KORMI memetakan kebiasaan dan fasilitas olahraga warga Kabupaten Bandung. Cukup 3 menit.
                @endif
            </p>

            <a href="{{ route('mobile.angket') }}" wire:navigate class="kd-home-apmo-cta">
                <span>{{ $apmo['sudah'] ? 'Perbarui Jawaban Survei' : 'Isi Survei Sekarang' }}</span>
                <i data-lucide="arrow-up-right"></i>
            </a>
            </section>
        @endif

        {{-- Pemberitahuan peran --}}
        @if(! $isPengelola && ! $duta)
            <div class="kd-notice kd-notice-lime">
                <i data-lucide="award"></i>
                <span>Anda belum terdaftar sebagai Duta Olahraga. <a href="{{ route('mobile.daftar-duta') }}" wire:navigate style="font-weight: 800; color: inherit; text-decoration: underline;">Ajukan pendaftaran</a>.</span>
            </div>
        @elseif($duta?->sedangMenunggu())
            <div class="kd-notice kd-notice-amber">
                <i data-lucide="clock"></i>
                <span>Pendaftaran duta Anda sedang <strong>menunggu verifikasi</strong> Administrator KORMI.</span>
            </div>
        @elseif($isPengelola && $isSuper && $dutaMenunggu > 0)
            <div class="kd-notice kd-notice-amber">
                <i data-lucide="user-plus"></i>
                <span><strong>{{ $dutaMenunggu }} pendaftaran duta</strong> menunggu verifikasi. <a href="{{ route('mobile.persetujuan') }}" wire:navigate style="font-weight: 800; color: inherit; text-decoration: underline;">Tinjau sekarang</a>.</span>
            </div>
        @endif

        {{-- Menu cepat --}}
        <div class="kd-home-sect">
            <h2>Layanan cepat</h2>
            <a href="{{ route('mobile.layanan') }}" wire:navigate>Semua menu</a>
        </div>

        <div class="kd-home-quick">
            @foreach($aksiCepat as $aksi)
                <a href="{{ route($aksi['route']) }}" wire:navigate class="kd-home-quick-item">
                    <span class="kd-home-quick-icon is-{{ $aksi['tint'] }}"><i data-lucide="{{ $aksi['icon'] }}"></i></span>
                    <span class="kd-home-quick-label">{{ $aksi['label'] }}</span>
                </a>
            @endforeach
        </div>

        {{-- Metrik pribadi --}}
        <div class="kd-home-metrics" @if(! $isDuta) style="grid-template-columns: repeat(2, minmax(0, 1fr));" @endif>
            @if($isDuta)
                <div class="kd-home-metric">
                    <strong>{{ number_format($metrik['kehadiran']) }}</strong>
                    <span>Hadir bulan ini</span>
                </div>
            @endif
            <div class="kd-home-metric">
                <strong>{{ number_format($metrik['aktivitas']) }}</strong>
                <span>Sesi aktivitas</span>
            </div>
            <div class="kd-home-metric">
                <strong>{{ number_format($metrik['valid']) }}</strong>
                <span>Terverifikasi</span>
            </div>
        </div>

        @if($isPengelola)
            {{-- Ringkasan data peran --}}
            <div class="kd-home-sect">
                <h2>Ringkasan data</h2>
                <span class="kd-chip kd-chip--dark">{{ count($modul) }} modul</span>
            </div>

            <div class="kd-stats">
                @foreach($adminStats as $stat)
                    <div class="kd-stat">
                        <span class="kd-stat-icon"><i data-lucide="{{ $stat['icon'] }}"></i></span>
                        <span>
                            <span class="kd-stat-value">{{ $stat['value'] }}</span>
                            <span class="kd-stat-label">{{ $stat['label'] }}</span>
                        </span>
                    </div>
                @endforeach
            </div>

            @if($isSuper)
                {{-- Antrean persetujuan khusus Super Admin --}}
                <div class="kd-home-sect">
                    <h2>Persetujuan</h2>
                    <a href="{{ route('mobile.persetujuan') }}" wire:navigate>Kelola semua</a>
                </div>

                @if($pesanPersetujuan)
                    <div class="kd-notice {{ $galatPersetujuan ? 'kd-notice-rose' : 'kd-notice-lime' }}" role="status" aria-live="polite">
                        <i data-lucide="{{ $galatPersetujuan ? 'alert-circle' : 'check-circle' }}"></i>
                        <span>{{ $pesanPersetujuan }}</span>
                    </div>
                @endif

                @if(count($antreanPersetujuan))
                    <div class="kd-home-card kd-home-approve">
                        @foreach($antreanPersetujuan as $baris)
                            <div class="kd-item" wire:key="setuju-{{ $baris['jenis'] }}-{{ $baris['id'] }}">
                                <span class="kd-module-icon">
                                    <i data-lucide="{{ $baris['jenis'] === 'duta' ? 'user-plus' : 'user-check' }}"></i>
                                </span>
                                <span class="kd-item-body">
                                    <span class="kd-item-title">{{ $baris['judul'] }}</span>
                                    <span class="kd-item-meta kd-home-approve-meta">{{ $baris['meta'] }}</span>
                                </span>
                                <button type="button"
                                        wire:click="{{ $baris['jenis'] === 'duta' ? 'setujuiDuta' : 'setujuiAkun' }}('{{ $baris['id'] }}')"
                                        wire:confirm="Setujui {{ $baris['jenis'] === 'duta' ? 'pendaftaran' : 'akun' }} {{ $baris['judul'] }}?"
                                        wire:loading.attr="disabled"
                                        class="kd-home-approve-btn">
                                    Setujui
                                </button>
                            </div>
                        @endforeach
                    </div>

                    @if($dutaMenunggu + $akunMenunggu > count($antreanPersetujuan))
                        <a href="{{ route('mobile.persetujuan') }}" wire:navigate class="kd-home-approve-more">
                            {{ $dutaMenunggu + $akunMenunggu }} item menunggu · Tinjau semua
                            <i data-lucide="arrow-right"></i>
                        </a>
                    @endif
                @else
                    <div class="kd-notice kd-notice-lime">
                        <i data-lucide="badge-check"></i>
                        <span>Tidak ada antrean persetujuan. Semua pendaftaran dan akun sudah diproses.</span>
                    </div>
                @endif
            @endif

            {{-- Modul pengelolaan --}}
            <div class="kd-home-sect">
                <h2>Kelola organisasi</h2>
                <a href="{{ route('mobile.layanan') }}" wire:navigate>Semua menu</a>
            </div>

            <div class="kd-modules">
                @foreach(array_slice($modul, 0, 9) as $item)
                    <a href="{{ route($item['route']) }}" class="kd-module">
                        <span class="kd-module-icon"><i data-lucide="{{ $item['icon'] }}"></i></span>
                        <span>
                            <span class="kd-module-name">{{ $item['label'] }}</span>
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- Daftar terbaru sesuai peran --}}
            <div class="kd-home-sect">
                <h2>{{ $terbaruJudul }}</h2>
                <a href="{{ $terbaruLink }}" wire:navigate>Lihat semua</a>
            </div>

            @if(count($terbaruAdmin))
                <div class="kd-home-card">
                    @foreach($terbaruAdmin as $baris)
                        <a href="{{ $baris['url'] }}" class="kd-item">
                            <span class="kd-module-icon"><i data-lucide="{{ $terbaruIcon }}"></i></span>
                            <span class="kd-item-body">
                                <span class="kd-item-title">{{ $baris['judul'] }}</span>
                                <span class="kd-item-meta" style="text-transform: none;">{{ $baris['meta'] }}</span>
                            </span>
                            <i data-lucide="chevron-right" class="w-4 h-4" style="color: #c3c6bf; flex-shrink: 0;"></i>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="kd-empty">
                    <i data-lucide="{{ $terbaruIcon }}"></i>
                    <strong>Belum ada data</strong>
                    <p>Data {{ strtolower($terbaruJudul) }} akan tampil di sini setelah ditambahkan melalui CMS.</p>
                </div>
            @endif
        @else
            {{-- Aktivitas olahraga terbaru --}}
            <div class="kd-home-sect">
                <h2>Aktivitas terbaru</h2>
                <a href="{{ route('partisipasi.riwayat') }}" wire:navigate>Lihat semua</a>
            </div>

            @if($terbaruAktivitas->isNotEmpty())
                <div class="kd-home-card">
                    @foreach($terbaruAktivitas as $log)
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
                    @endforeach
                </div>
            @else
                <div class="kd-empty">
                    <i data-lucide="activity"></i>
                    <strong>Belum ada aktivitas tercatat</strong>
                    <p>Catat sesi olahraga pertama Anda dan kontribusikan pada APMO Kabupaten Bandung.</p>
                    <a href="{{ route('partisipasi.catat') }}" wire:navigate class="kd-page-btn">Catat sekarang</a>
                </div>
            @endif
        @endif

        {{-- Kabar KORMI --}}
        @if($berita->isNotEmpty())
            <div class="kd-home-sect">
                <h2>Kabar KORMI</h2>
                <a href="{{ route('mobile.berita') }}" wire:navigate>Semua berita</a>
            </div>

            <div class="kd-home-news">
                @foreach($berita as $kabar)
                    <a href="{{ route('mobile.berita.detail', $kabar->slug) }}" wire:navigate class="kd-home-news-card">
                        <img src="{{ $kabar->gambar_url }}" alt="{{ $kabar->judul }}" loading="lazy"
                             onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'">
                        <span class="kd-home-news-body">
                            <span class="kd-home-news-title">{{ $kabar->judul }}</span>
                            <span class="kd-home-news-meta">
                                {{ \Carbon\Carbon::parse($kabar->tanggal_publikasi)->translatedFormat('d M Y') }}
                                <span>· {{ $kabar->estimasi_menit_baca ?? 2 }} mnt baca</span>
                            </span>
                        </span>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="kd-home-foot">
            <span>Masuk sebagai {{ $user->email }}</span>
            <form method="POST" action="{{ route('admin.keluar') }}">
                @csrf
                <button type="submit">Keluar</button>
            </form>
        </div>
    </div>

    <x-mobile.tabbar aktif="dashboard" />
</div>
