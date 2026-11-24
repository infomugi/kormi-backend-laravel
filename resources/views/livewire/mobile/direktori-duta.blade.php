    {{-- Versi mobile dari /duta-olahraga — desain mobile_kormi.html --}}
    <div class="kd-mobile min-h-screen">
        <div class="kd-header">
            <div class="kd-brand">
                <div class="kd-brand-icon">K</div>
                <span class="kd-brand-title">KORMI Kab. Bandung</span>
            </div>
            <p class="kd-brand-sub">Direktori Duta Olahraga</p>
        </div>

        <div class="kd-sheet">
            <div class="kd-section-head">
                <div>
                    <h3>Duta Olahraga Desa</h3>
                    <p>Penggerak olahraga masyarakat di {{ $kecamatanList->count() }} kecamatan.</p>
                </div>
                <span class="kd-badge">{{ number_format($dutaList->total()) }} Duta</span>
            </div>

            <div class="kd-filter">
                <div class="kd-control">
                    <input type="text" wire:model.live.debounce.400ms="cari" class="kd-input" placeholder="Cari nama / desa…" aria-label="Cari duta olahraga">
                    <span class="kd-icon"><i data-lucide="search"></i></span>
                </div>
                @if($cari !== '' || $kecamatanDipilih !== '')
                    <button type="button" wire:click="$set('cari', ''); $set('kecamatanDipilih', '')" wire:loading.attr="disabled" class="kd-reset" aria-label="Reset pencarian">
                        <i data-lucide="rotate-ccw"></i>
                    </button>
                @endif
            </div>

            <div class="kd-control" style="margin-bottom: 14px;">
                <select wire:model.live="kecamatanDipilih" class="kd-select" aria-label="Filter kecamatan">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatanList as $kec)
                        <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                    @endforeach
                </select>
                <span class="kd-icon"><i data-lucide="chevron-down"></i></span>
            </div>

            <p class="kd-result-line">
                Menampilkan <strong>{{ number_format($dutaList->total()) }}</strong> duta
                @if($cari !== '')
                    untuk "<strong>{{ $cari }}</strong>"
                @endif
                @if($kecamatanDipilih !== '')
                    · <strong>{{ $dutaList->first()?->kecamatan?->nama_kecamatan ?? 'Kecamatan terpilih' }}</strong>
                @endif
            </p>

            @if($dutaList->isNotEmpty())
                <div class="kd-duta-grid">
                    @foreach($dutaList as $duta)
                        <div class="kd-duta-card">
                            <span class="kd-duta-dot {{ $duta->status_unggulan ? 'is-unggulan' : '' }}"></span>

                            <span class="kd-duta-avatar">
                                @if($duta->foto_duta_url)
                                    <img src="{{ $duta->foto_duta_url }}" alt="{{ $duta->nama_lengkap }}" loading="lazy">
                                @else
                                    {{ $duta->initial_dua_huruf }}
                                @endif
                            </span>

                            <span class="kd-duta-name">{{ $duta->nama_lengkap }}</span>

                            @if($duta->desaKelurahan)
                                <span class="kd-chip">Desa {{ $duta->desaKelurahan->nama_desa_kelurahan }}</span>
                            @endif

                            <span class="kd-duta-loc">
                                <i data-lucide="map-pin"></i>
                                <span>Kec. {{ $duta->kecamatan->nama_kecamatan }}</span>
                            </span>
                        </div>
                    @endforeach
                </div>

                @if($dutaList->lastPage() > 1)
                    <div class="kd-pagination">
                        <button type="button" wire:click="previousPage" wire:loading.attr="disabled" @disabled($dutaList->onFirstPage()) class="kd-page-btn">
                            <i data-lucide="chevron-left"></i>
                            <span>Sebelumnya</span>
                        </button>
                        <span class="kd-page-info">{{ $dutaList->currentPage() }} / {{ $dutaList->lastPage() }}</span>
                        <button type="button" wire:click="nextPage" wire:loading.attr="disabled" @disabled(! $dutaList->hasMorePages()) class="kd-page-btn">
                            <span>Berikutnya</span>
                            <i data-lucide="chevron-right"></i>
                        </button>
                    </div>
                @endif
            @else
                <div class="kd-empty">
                    <i data-lucide="user-x"></i>
                    <strong>Duta tidak ditemukan</strong>
                    <p>Tidak ada duta yang cocok dengan kata kunci atau wilayah terpilih.</p>
                    @if($cari !== '' || $kecamatanDipilih !== '')
                        <button type="button" wire:click="$set('cari', ''); $set('kecamatanDipilih', '')" class="kd-page-btn">Reset pencarian</button>
                    @endif
                </div>
            @endif

            <div class="kd-subhead">
                <h4>Ingin menjadi duta?</h4>
            </div>

            <a href="{{ route('mobile.daftar-duta') }}" wire:navigate class="kd-btn-primary">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Daftar Duta Olahraga</span>
            </a>

            <p class="kd-footnote">SK Duta resmi KORMI Kabupaten Bandung · data diperbarui berkala</p>
        </div>

        <x-mobile.tabbar aktif="direktori" />
    </div>
