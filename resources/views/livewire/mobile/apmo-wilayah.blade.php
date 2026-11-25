{{-- Monitoring Survei APMO per wilayah — versi mobile khusus Super Admin --}}
<div class="kd-mobile kd-laporan kd-apmo-wilayah min-h-screen">
    <header class="kd-verify-head">
        <a href="{{ route('mobile.dashboard') }}" wire:navigate class="kd-backlink kd-verify-back">
            <i data-lucide="arrow-left"></i> Dashboard
        </a>

        <div class="kd-verify-title">
            <span class="kd-verify-title-icon"><i data-lucide="radar"></i></span>
            <div>
                <h1>Monitoring APMO</h1>
                <p>Cakupan isian survei per kecamatan &amp; desa/kelurahan.</p>
            </div>
        </div>
    </header>

    <div class="kd-verify-body">
        <div class="kd-report-metrics">
            <div class="kd-report-metric">
                <strong>{{ number_format($ringkasan['totalIsian']) }}</strong>
                <span>Total isian</span>
            </div>
            <div class="kd-report-metric">
                <strong>{{ $ringkasan['kecamatanTerisi'] }}/{{ $ringkasan['kecamatanTotal'] }}</strong>
                <span>Kecamatan</span>
            </div>
            <div class="kd-report-metric">
                <strong>{{ $ringkasan['desaTerisi'] }}/{{ $ringkasan['desaTotal'] }}</strong>
                <span>Desa</span>
            </div>
        </div>

        @if($ringkasan['isianTanpaMaster'] > 0)
            <div class="kd-notice kd-notice-amber" role="status">
                <i data-lucide="alert-triangle"></i>
                <span>
                    {{ number_format($ringkasan['isianTanpaMaster']) }} isian memakai nama kecamatan yang tidak cocok dengan data master, jadi tidak masuk hitungan di bawah.
                </span>
            </div>
        @endif

        <div class="kd-verify-tabs" role="tablist" aria-label="Tingkat wilayah">
            <button type="button" role="tab" wire:click="pilihTab('kecamatan')"
                    aria-selected="{{ $tab === 'kecamatan' ? 'true' : 'false' }}"
                    class="kd-verify-tab {{ $tab === 'kecamatan' ? 'is-active' : '' }}">
                <span>Kecamatan</span>
                <span class="kd-verify-count">{{ $ringkasan['kecamatanTotal'] }}</span>
            </button>
            <button type="button" role="tab" wire:click="pilihTab('desa')"
                    aria-selected="{{ $tab === 'desa' ? 'true' : 'false' }}"
                    class="kd-verify-tab {{ $tab === 'desa' ? 'is-active' : '' }}">
                <span>Desa / Kelurahan</span>
                <span class="kd-verify-count">{{ $ringkasan['desaTotal'] }}</span>
            </button>
        </div>

        <div class="kd-filter">
            <div class="kd-control">
                <input type="text" wire:model.live.debounce.400ms="cari" class="kd-input" placeholder="Cari kecamatan / desa…" aria-label="Cari wilayah">
                <span class="kd-icon"><i data-lucide="search"></i></span>
            </div>
            @if($cari !== '')
                <button type="button" wire:click="$set('cari', '')" wire:loading.attr="disabled" class="kd-reset" aria-label="Reset pencarian">
                    <i data-lucide="rotate-ccw"></i>
                </button>
            @endif
        </div>

        <div class="kd-wilayah-sort" role="group" aria-label="Urutkan data wilayah">
            <button type="button" wire:click="urutkan('nama')" class="{{ $urut === 'nama' ? 'is-active' : '' }}" aria-pressed="{{ $urut === 'nama' ? 'true' : 'false' }}">
                <span>Nama</span>
                @if($urut === 'nama')
                    <i data-lucide="{{ $arah === 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                @else
                    <i data-lucide="chevrons-up-down"></i>
                @endif
            </button>
            <button type="button" wire:click="urutkan('total')" class="{{ $urut === 'total' ? 'is-active' : '' }}" aria-pressed="{{ $urut === 'total' ? 'true' : 'false' }}">
                <span>Jumlah isian</span>
                @if($urut === 'total')
                    <i data-lucide="{{ $arah === 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                @else
                    <i data-lucide="chevrons-up-down"></i>
                @endif
            </button>
        </div>

        <p class="kd-result-line">
            Menampilkan <strong>{{ count($baris) }}</strong> dari <strong>{{ number_format($totalBaris) }}</strong>
            {{ $tab === 'kecamatan' ? 'kecamatan' : 'desa/kelurahan' }}
            @php $belum = $tab === 'kecamatan' ? $ringkasan['kecamatanBelum'] : $ringkasan['desaBelum']; @endphp
            @if($belum > 0)
                · <strong class="kd-wilayah-note-danger">{{ number_format($belum) }} belum input</strong>
            @endif
        </p>

        @if(empty($baris))
            <div class="kd-empty">
                <i data-lucide="inbox"></i>
                <strong>Tidak ada wilayah yang cocok</strong>
                <p>
                    @if(trim($cari) !== '')
                        Ubah kata kunci atau kosongkan kolom pencarian.
                    @else
                        Data master {{ $tab === 'kecamatan' ? 'kecamatan' : 'desa/kelurahan' }} belum tersedia.
                    @endif
                </p>
                @if($cari !== '')
                    <button type="button" wire:click="$set('cari', '')" class="kd-page-btn">Reset pencarian</button>
                @endif
            </div>
        @else
            <div class="kd-wilayah-list">
                @foreach($baris as $item)
                    <article wire:key="{{ $tab }}-{{ $item['id'] }}" class="kd-wilayah-row {{ $item['total'] === 0 ? 'is-empty' : '' }}">
                        <span class="kd-wilayah-icon">
                            <i data-lucide="{{ $tab === 'kecamatan' ? 'map-pin' : 'house' }}"></i>
                        </span>

                        <div class="kd-wilayah-main">
                            <span class="kd-wilayah-name">
                                {{ $tab === 'kecamatan' ? 'Kec. ' : '' }}{{ $item['nama'] }}
                            </span>

                            @if($tab === 'kecamatan')
                                <span class="kd-wilayah-meta">
                                    <span>{{ $item['desa_terisi'] }}/{{ $item['jumlah_desa'] }} desa terisi</span>
                                    <span>· {{ $item['terakhir'] ?? 'belum ada isian' }}</span>
                                </span>
                                <span class="kd-wilayah-bar" aria-hidden="true">
                                    <span style="width: {{ $item['jumlah_desa'] > 0 ? round($item['desa_terisi'] / $item['jumlah_desa'] * 100) : 0 }}%; background: {{ $item['desa_terisi'] === 0 ? '#fda4af' : '#34d399' }};"></span>
                                </span>
                            @else
                                <span class="kd-wilayah-meta">
                                    <span>{{ $item['wilayah'] ? 'Kec. ' . $item['wilayah'] : 'Kecamatan tidak dikenal' }}</span>
                                    <span>· {{ $item['terakhir'] ?? 'belum ada isian' }}</span>
                                </span>
                            @endif
                        </div>

                        <div class="kd-wilayah-side">
                            <strong class="kd-wilayah-count">{{ number_format($item['total']) }}</strong>
                            <span class="kd-chip {{ $item['total'] === 0 ? 'kd-chip--danger' : 'kd-chip--lime' }}">
                                {{ $item['total'] === 0 ? 'Belum' : 'Sudah' }}
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($totalBaris > count($baris))
                <button type="button" wire:click="muatLagi" wire:loading.attr="disabled" class="kd-page-btn kd-wilayah-more">
                    <i data-lucide="chevrons-down"></i>
                    <span>Muat {{ min(40, $totalBaris - count($baris)) }} lainnya</span>
                </button>
            @endif
        @endif

        <p class="kd-footnote">Merah = belum ada isian · data mengikuti nama wilayah pada angket APMO</p>
    </div>

    <x-mobile.tabbar aktif="dashboard" />
</div>
