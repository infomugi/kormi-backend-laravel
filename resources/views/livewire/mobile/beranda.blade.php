    {{-- Versi mobile dari / — desain mobile_kormi.html --}}
    <div class="kd-mobile min-h-screen">
        <div class="kd-header">
            <div class="kd-brand">
                <div class="kd-brand-icon">K</div>
                <span class="kd-brand-title">KORMI Kab. Bandung</span>
            </div>
            <p class="kd-brand-sub">Sehat, Bugar, Gembira</p>
        </div>

        <div class="kd-sheet">
            <div class="kd-section-head">
                <div>
                    <h3>Selamat Datang</h3>
                    <p>Portal resmi olahraga rekreasi masyarakat Kabupaten Bandung.</p>
                </div>
                <span class="kd-badge">Beranda</span>
            </div>

            @guest
                <div class="kd-success-actions">
                    <a href="{{ route('mobile.daftar-duta') }}" wire:navigate class="kd-btn-primary">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Daftar Duta Olahraga</span>
                    </a>
                    <a href="{{ route('mobile.login') }}" wire:navigate class="kd-btn-ghost">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Masuk</span>
                    </a>
                </div>
            @endguest

            @auth
            <div class="kd-control" style="margin-bottom: 14px;">
                <a href="{{ route('mobile.direktori-duta') }}" wire:navigate class="kd-searchlink">Cari duta olahraga…</a>
                <span class="kd-icon"><i data-lucide="search"></i></span>
            </div>

            <div class="kd-stats">
                <a href="{{ route('inorga') }}" wire:navigate class="kd-stat">
                    <span class="kd-stat-icon"><i data-lucide="award"></i></span>
                    <span>
                        <span class="kd-stat-value">{{ $stats['totalInorga'] }}</span>
                        <span class="kd-stat-label">INORGA</span>
                    </span>
                </a>
                <a href="{{ route('mobile.direktori-duta') }}" wire:navigate class="kd-stat">
                    <span class="kd-stat-icon"><i data-lucide="users"></i></span>
                    <span>
                        <span class="kd-stat-value">{{ $stats['totalDuta'] }}</span>
                        <span class="kd-stat-label">Duta Olahraga</span>
                    </span>
                </a>
                <a href="{{ route('kordikecamatan') }}" wire:navigate class="kd-stat">
                    <span class="kd-stat-icon"><i data-lucide="map-pin"></i></span>
                    <span>
                        <span class="kd-stat-value">{{ $stats['totalKecamatan'] }}</span>
                        <span class="kd-stat-label">Kecamatan</span>
                    </span>
                </a>
                <a href="{{ route('sapras') }}" wire:navigate class="kd-stat">
                    <span class="kd-stat-icon"><i data-lucide="building-2"></i></span>
                    <span>
                        <span class="kd-stat-value">{{ $stats['totalSapras'] }}</span>
                        <span class="kd-stat-label">Sapras</span>
                    </span>
                </a>
            </div>

            <div class="kd-success-actions" style="margin: 16px 0 4px;">
                <a href="{{ route('partisipasi.catat') }}" wire:navigate class="kd-btn-primary">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Catat Olahraga Warga</span>
                </a>
                <a href="{{ route('mobile.daftar-duta') }}" wire:navigate class="kd-btn-ghost">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>Daftar Duta Olahraga</span>
                </a>
            </div>

            <div class="kd-subhead" style="margin-top: 20px;">
                <h4>Survei &amp; Angket</h4>
            </div>

            <div class="kd-modules">
                <a href="{{ route('mobile.angket') }}" wire:navigate class="kd-module" style="grid-column: 1 / -1;">
                    <span class="kd-module-icon"><i data-lucide="clipboard-list"></i></span>
                    <span>
                        <span class="kd-module-name">Survey APMO</span>
                        <span class="kd-module-desc">Isi angket kebiasaan &amp; fasilitas olahraga Anda</span>
                    </span>
                </a>
            </div>

            <div class="kd-subhead">
                <h4>Survey APMO per Kecamatan</h4>
                <span class="kd-chip">{{ number_format($apmoKecamatan['total']) }} isian</span>
            </div>

            <div class="kd-apmo-mini">
                @foreach($apmoKecamatan['baris'] as $kec)
                    <div class="kd-apmo-mini-item {{ $kec['total'] === 0 ? 'is-empty' : '' }}">
                        <span class="kd-apmo-mini-top">
                            <span class="kd-apmo-mini-name">{{ $kec['nama'] }}</span>
                            <span class="kd-apmo-mini-num">{{ number_format($kec['total']) }}</span>
                        </span>
                        <span class="kd-apmo-mini-bar">
                            <span style="width: {{ round($kec['total'] / $apmoKecamatan['maks'] * 100) }}%"></span>
                        </span>
                    </div>
                @endforeach
            </div>

            <p class="kd-footnote">{{ $apmoKecamatan['terisi'] }}/{{ $apmoKecamatan['jumlahKecamatan'] }} kecamatan terisi · bar dibandingkan dengan isian terbanyak</p>

            <div class="kd-subhead">
                <h4>Berita Terkini</h4>
                <a href="{{ route('berita') }}" wire:navigate>Semua warta</a>
            </div>
            @forelse($beritaList as $news)
                <a href="{{ route('berita.detail', $news->slug) }}" wire:navigate class="kd-item">
                    <span class="kd-item-thumb">
                        <img src="{{ $news->gambar_url }}" alt="{{ $news->judul }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'">
                    </span>
                    <span class="kd-item-body">
                        <span class="kd-item-title">{{ $news->judul }}</span>
                        <span class="kd-item-meta">
                            <i data-lucide="calendar"></i>
                            {{ \Carbon\Carbon::parse($news->tanggal_publikasi)->translatedFormat('d M Y') }}
                            <span>· {{ $news->estimasi_menit_baca ?? 2 }} mnt</span>
                        </span>
                    </span>
                </a>
            @empty
                <div class="kd-empty">
                    <i data-lucide="newspaper"></i>
                    <strong>Belum ada berita</strong>
                    <p>Publikasi terbaru KORMI akan tampil di sini.</p>
                </div>
            @endforelse

            @if($eventList->isNotEmpty())
                <div class="kd-subhead">
                    <h4>Agenda Terdekat</h4>
                    <a href="{{ route('forkab') }}" wire:navigate>Lihat event</a>
                </div>

                @foreach($eventList as $ev)
                    <div class="kd-item">
                        <span class="kd-item-thumb">
                            <img src="{{ $ev->banner_url ?? asset('assets/image/event-card-bg.jpg') }}" alt="{{ $ev->judul_event }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800'">
                        </span>
                        <span class="kd-item-body">
                            <span class="kd-item-title">{{ $ev->judul_event }}</span>
                            <span class="kd-item-meta">
                                <i data-lucide="map-pin"></i>
                                {{ $ev->lokasi_utama }}
                            </span>
                        </span>
                    </div>
                @endforeach
            @endif

            <div class="kd-subhead">
                <h4>Layanan KORMI</h4>
                <span class="kd-chip">8 modul</span>
            </div>

            <div class="kd-modules">
                @foreach($kegiatanGrid as $item)
                    <a href="{{ $item['link'] }}" @if($item['external'] ?? false) target="_blank" rel="noopener noreferrer" @else wire:navigate @endif class="kd-module">
                        <span class="kd-module-icon"><i data-lucide="{{ $item['icon'] }}"></i></span>
                        <span>
                            <span class="kd-module-name">{{ $item['name'] }}</span>
                            <span class="kd-module-desc">{{ $item['desc'] }}</span>
                        </span>
                    </a>
                @endforeach
            </div>

            @if($galeriList->isNotEmpty())
                <div class="kd-subhead">
                    <h4>Galeri Kegiatan</h4>
                    <a href="{{ route('galeri') }}" wire:navigate>Semua foto</a>
                </div>

                <div class="kd-galeri">
                    @foreach($galeriList->take(3) as $foto)
                        <img src="{{ $foto->foto_url }}" alt="{{ $foto->judul_foto }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'">
                    @endforeach
                </div>
            @endif

            <a href="{{ route('kontak') }}" wire:navigate class="kd-notice kd-notice-dark" style="margin-top: 20px; text-decoration: none;">
                <i data-lucide="message-square"></i>
                <span>Punya komunitas olahraga? <strong>Hubungi sekretariat KORMI</strong> untuk bergabung.</span>
            </a>

            <p class="kd-footnote">KORMI Kabupaten Bandung · {{ $stats['totalKecamatan'] }} kecamatan · {{ $stats['totalDuta'] }} duta olahraga</p>
            @endauth
        </div>

        @auth
            <x-mobile.tabbar aktif="beranda" />
        @endauth
    </div>
