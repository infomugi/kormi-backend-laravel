{{-- Halaman Berita mobile — desain mobile_kormi.html --}}
<div class="kd-mobile min-h-screen">
    <div class="kd-header">
        <div class="kd-brand">
            <div class="kd-brand-icon">K</div>
            <span class="kd-brand-title">KORMI Kab. Bandung</span>
        </div>
        <p class="kd-brand-sub">Berita KORMI</p>
    </div>

    <div class="kd-sheet">
        <div class="kd-section-head">
            <div>
                <h3>Berita & Artikel</h3>
                <p>Warta resmi olahraga rekreasi masyarakat Kabupaten Bandung.</p>
            </div>
            <span class="kd-badge">{{ number_format($beritaList->total()) }} Warta</span>
        </div>

        <div class="kd-filter">
            <div class="kd-control">
                <input type="text" wire:model.live.debounce.400ms="cari" class="kd-input" placeholder="Cari berita…" aria-label="Cari berita">
                <span class="kd-icon"><i data-lucide="search"></i></span>
            </div>
            @if($cari !== '')
                <button type="button" wire:click="$set('cari', '')" wire:loading.attr="disabled" class="kd-reset" aria-label="Reset pencarian">
                    <i data-lucide="rotate-ccw"></i>
                </button>
            @endif
        </div>

        @if($beritaUtama && $cari === '')
            <a href="{{ route('mobile.berita.detail', $beritaUtama->slug) }}" wire:navigate class="kd-item" style="margin-bottom: 14px;">
                <span class="kd-item-thumb">
                    <img src="{{ $beritaUtama->gambar_url }}" alt="{{ $beritaUtama->judul }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'">
                </span>
                <span class="kd-item-body">
                    <span class="kd-item-title">{{ $beritaUtama->judul }}</span>
                    <span class="kd-item-meta">
                        <i data-lucide="calendar"></i>
                        {{ \Carbon\Carbon::parse($beritaUtama->tanggal_publikasi)->translatedFormat('d M Y') }}
                        <span>· {{ $beritaUtama->estimasi_menit_baca }} mnt</span>
                    </span>
                </span>
            </a>
        @endif

        <p class="kd-result-line">
            Menampilkan <strong>{{ number_format($beritaList->total()) }}</strong> berita
            @if($cari !== '')
                untuk "<strong>{{ $cari }}</strong>"
            @endif
        </p>

        @forelse($beritaList as $news)
            @if($cari === '' && $beritaUtama && $news->id === $beritaUtama->id)
                @continue
            @endif
            <a href="{{ route('mobile.berita.detail', $news->slug) }}" wire:navigate class="kd-item">
                <span class="kd-item-thumb">
                    <img src="{{ $news->gambar_url }}" alt="{{ $news->judul }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800'">
                </span>
                <span class="kd-item-body">
                    <span class="kd-item-title">{{ $news->judul }}</span>
                    <span class="kd-item-meta">
                        <i data-lucide="calendar"></i>
                        {{ \Carbon\Carbon::parse($news->tanggal_publikasi)->translatedFormat('d M Y') }}
                        <span>· {{ $news->estimasi_menit_baca }} mnt</span>
                        @if($news->kategori)
                            <span>· {{ $news->kategori->nama_kategori }}</span>
                        @endif
                    </span>
                </span>
            </a>
        @empty
            <div class="kd-empty">
                <i data-lucide="newspaper"></i>
                <strong>Berita tidak ditemukan</strong>
                <p>Coba kata kunci lain atau kembali ke daftar berita terbaru.</p>
                @if($cari !== '')
                    <button type="button" wire:click="$set('cari', '')" class="kd-page-btn">Reset pencarian</button>
                @endif
            </div>
        @endforelse

        @if($beritaList->hasPages())
            <div class="kd-pagination">
                <button type="button" wire:click="previousPage" wire:loading.attr="disabled" @disabled($beritaList->onFirstPage()) class="kd-page-btn">
                    <i data-lucide="chevron-left"></i>
                    <span>Sebelumnya</span>
                </button>
                <span class="kd-page-info">{{ $beritaList->currentPage() }} / {{ $beritaList->lastPage() }}</span>
                <button type="button" wire:click="nextPage" wire:loading.attr="disabled" @disabled(! $beritaList->hasMorePages()) class="kd-page-btn">
                    <span>Berikutnya</span>
                    <i data-lucide="chevron-right"></i>
                </button>
            </div>
        @endif

        <p class="kd-footnote">KORMI Kabupaten Bandung · Warta olahraga masyarakat</p>
    </div>

    <x-mobile.tabbar aktif="berita" />
</div>
