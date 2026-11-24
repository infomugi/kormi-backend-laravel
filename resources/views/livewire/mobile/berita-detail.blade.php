{{-- Detail berita mobile — desain mobile_kormi.html --}}
<div class="kd-mobile min-h-screen">
    <div class="kd-header">
        <div class="kd-brand">
            <div class="kd-brand-icon">K</div>
            <span class="kd-brand-title">KORMI Kab. Bandung</span>
        </div>
        <p class="kd-brand-sub">Berita KORMI</p>
    </div>

    <div class="kd-sheet">
        <a href="{{ route('mobile.berita') }}" wire:navigate class="kd-backlink">
            <i data-lucide="chevron-left"></i>
            <span>Semua berita</span>
        </a>

        <div style="display: flex; flex-wrap: wrap; gap: 5px; margin: 10px 0 8px;">
            @if($berita->kategori)
                <span class="kd-chip kd-chip--dark">{{ $berita->kategori->nama_kategori }}</span>
            @endif
            <span class="kd-chip">{{ $berita->estimasi_menit_baca }} menit baca</span>
        </div>

        <h2 class="kd-article-title">{{ $berita->judul }}</h2>

        <p class="kd-article-meta">
            <i data-lucide="user"></i>
            {{ $berita->penulis->nama_lengkap ?? 'Redaksi KORMI' }}
            <span>· {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d M Y') }}</span>
            <span>· {{ number_format($berita->jumlah_dilihat ?? 0) }}x dibaca</span>
        </p>

        <div class="kd-article-hero">
            <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'">
        </div>

        @if(!empty($berita->ringkasan))
            <p class="kd-article-lead">{{ $berita->ringkasan }}</p>
        @endif

        <div class="kd-article">
            {!! $berita->isi_konten !!}
        </div>

        @if($beritaTerkait->isNotEmpty())
            <div class="kd-subhead" style="margin-top: 8px;">
                <h4>Berita Terkait</h4>
                <a href="{{ route('mobile.berita') }}" wire:navigate>Semua warta</a>
            </div>

            @foreach($beritaTerkait as $rel)
                <a href="{{ route('mobile.berita.detail', $rel->slug) }}" wire:navigate class="kd-item">
                    <span class="kd-item-thumb">
                        <img src="{{ $rel->gambar_url }}" alt="{{ $rel->judul }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'">
                    </span>
                    <span class="kd-item-body">
                        <span class="kd-item-title">{{ $rel->judul }}</span>
                        <span class="kd-item-meta">
                            <i data-lucide="calendar"></i>
                            {{ \Carbon\Carbon::parse($rel->tanggal_publikasi)->translatedFormat('d M Y') }}
                            <span>· {{ $rel->estimasi_menit_baca }} mnt</span>
                        </span>
                    </span>
                </a>
            @endforeach
        @endif

        <p class="kd-footnote">KORMI Kabupaten Bandung · Warta olahraga masyarakat</p>
    </div>

    <x-mobile.tabbar aktif="berita" />
</div>
