{{-- Halaman Laporan APMO mobile — riwayat & statistik survei --}}
<div class="kd-mobile kd-laporan min-h-screen">
    <div class="kd-header">
        <div class="kd-brand">
            <div class="kd-brand-icon">K</div>
            <span class="kd-brand-title">KORMI Kab. Bandung</span>
        </div>
        <p class="kd-brand-sub">Laporan APMO</p>
    </div>

    <div class="kd-sheet">
        <div class="kd-section-head">
            <div>
                <h3>Laporan APMO</h3>
                <p>Riwayat &amp; statistik hasil Survei APMO.</p>
            </div>
            <span class="kd-badge">{{ $ringkasan ? number_format($ringkasan['total']) . ' isian' : 'Wilayah' }}</span>
        </div>

        {{-- Tab utama --}}
        <div class="kd-seg" role="tablist" aria-label="Jenis laporan">
            <button type="button" role="tab" wire:click="pilihTab('riwayat')"
                    aria-selected="{{ $tab === 'riwayat' ? 'true' : 'false' }}"
                    class="{{ $tab === 'riwayat' ? 'is-active' : '' }}">
                <i data-lucide="history"></i>
                <span>Riwayat APMO</span>
            </button>
            <button type="button" role="tab" wire:click="pilihTab('statistik')"
                    aria-selected="{{ $tab === 'statistik' ? 'true' : 'false' }}"
                    class="{{ $tab === 'statistik' ? 'is-active' : '' }}">
                <i data-lucide="chart-column"></i>
                <span>Statistik APMO</span>
            </button>
        </div>

        {{-- Lingkup data --}}
        <div class="kd-seg kd-seg--soft" role="group" aria-label="Sumber data laporan">
            <button type="button" wire:click="pilihLingkup('saya')"
                    class="{{ $lingkup === 'saya' ? 'is-active' : '' }}">
                <i data-lucide="user-round"></i>
                <span>Saya</span>
            </button>
            <button type="button" wire:click="pilihLingkup('desa')"
                    class="{{ $lingkup === 'desa' ? 'is-active' : '' }}">
                <i data-lucide="house"></i>
                <span>Desa</span>
            </button>
            <button type="button" wire:click="pilihLingkup('kecamatan')"
                    class="{{ $lingkup === 'kecamatan' ? 'is-active' : '' }}">
                <i data-lucide="building-2"></i>
                <span>Kecamatan</span>
            </button>
        </div>

        <p class="kd-report-scope">
            <i data-lucide="map-pin"></i>
            {{ $namaLingkup }}
        </p>

        @if(! $aktifWilayah)
            <div class="kd-notice kd-notice-amber">
                <i data-lucide="alert-triangle"></i>
                <span>
                    {{ $lingkup === 'desa' ? 'Desa/kelurahan' : 'Kecamatan' }} Anda belum diatur.
                    <a href="{{ route('mobile.profil') }}" wire:navigate style="font-weight: 800; color: inherit; text-decoration: underline;">Lengkapi profil</a>
                    agar laporan wilayah tampil.
                </span>
            </div>

            <div class="kd-empty">
                <i data-lucide="{{ $lingkup === 'desa' ? 'house' : 'building-2' }}"></i>
                <strong>Wilayah belum tersedia</strong>
                <p>Sementara ini Anda tetap dapat melihat riwayat isian dari akun sendiri.</p>
                <button type="button" wire:click="pilihLingkup('saya')" class="kd-page-btn">Lihat isian saya</button>
            </div>
        @else
            {{-- Ringkasan singkat --}}
            @if($tab === 'riwayat' || $lingkup !== 'saya')
                <div class="kd-report-metrics">
                    <div class="kd-report-metric">
                        <strong>{{ number_format($ringkasan['total']) }}</strong>
                        <span>Isian</span>
                    </div>
                    <div class="kd-report-metric">
                        <strong>{{ $ringkasan['persenAktif'] }}%</strong>
                        <span>Aktif olahraga</span>
                    </div>
                    <div class="kd-report-metric">
                        <strong>{{ $ringkasan['usiaRata'] !== null ? $ringkasan['usiaRata'] : '—' }}</strong>
                        <span>Rata usia</span>
                    </div>
                </div>
            @endif

            @if($tab === 'riwayat')
                @if($daftar->isEmpty())
                    <div class="kd-empty">
                        <i data-lucide="clipboard-list"></i>
                        <strong>Belum ada isian APMO</strong>
                        <p>
                            {{ $lingkup === 'saya'
                                ? 'Isi Survei APMO untuk melihat riwayat dan statistik pribadi Anda.'
                                : 'Belum ada warga di wilayah ini yang mengisi Survei APMO.' }}
                        </p>
                        @if($lingkup === 'saya')
                            <a href="{{ route('mobile.angket') }}" wire:navigate class="kd-page-btn">Isi Survei APMO</a>
                        @endif
                    </div>
                @else
                    <p class="kd-result-line">
                        Menampilkan <strong>{{ number_format($daftar->total()) }}</strong> isian terbaru
                    </p>

                    <div class="kd-home-card">
                        @foreach($daftar as $baris)
                            <div class="kd-item" wire:key="isian-{{ $baris->id }}" @if($lingkup === 'saya') style="border-bottom: 0; padding-bottom: 6px;" @endif>
                                @if($baris->foto_bukti_url)
                                    <span class="kd-module-icon" style="overflow: hidden; padding: 0;">
                                        <img src="{{ $baris->foto_bukti_url }}" alt="Foto bukti survey {{ $baris->nama_lengkap }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                                    </span>
                                @else
                                    <span class="kd-module-icon"><i data-lucide="clipboard-check"></i></span>
                                @endif
                                <span class="kd-item-body">
                                    <span class="kd-item-title">{{ $baris->nama_lengkap }}</span>
                                    <span class="kd-item-meta">
                                        <i data-lucide="calendar"></i>
                                        {{ \Carbon\Carbon::parse($baris->dibuat_pada)->timezone('Asia/Jakarta')->translatedFormat('d M Y') }}
                                        <span>· {{ $baris->usia }} th</span>
                                        <span>· {{ $baris->jenis_kelamin === 'wanita' ? 'Perempuan' : 'Laki-laki' }}</span>
                                    </span>
                                    <span class="kd-item-meta">
                                        <i data-lucide="map-pin"></i>
                                        {{ $baris->desa ?: '—' }}
                                        <span>· {{ $baris->kecamatan ?: '—' }}</span>
                                    </span>
                                </span>
                                <span class="kd-chip {{ $baris->melakukan_olahraga ? 'kd-chip--lime' : 'kd-chip--warn' }}">
                                    {{ $baris->melakukan_olahraga ? 'Olahraga' : 'Tidak' }}
                                </span>
                            </div>

                            @if($lingkup === 'saya')
                                <div wire:key="aksi-{{ $baris->id }}" style="padding: 0 0 12px 46px;">
                                    @if($hapusId === $baris->id)
                                        <div class="kd-verify-actions">
                                            <button type="button" wire:click="batalHapus" class="kd-verify-btn is-ghost">
                                                <i data-lucide="x"></i>
                                                <span>Batal</span>
                                            </button>
                                            <button type="button" wire:click="hapus('{{ $baris->id }}')"
                                                    wire:loading.attr="disabled" wire:target="hapus"
                                                    class="kd-verify-btn is-danger">
                                                <i data-lucide="trash-2"></i>
                                                <span wire:loading.remove wire:target="hapus">Hapus permanen</span>
                                                <span wire:loading wire:target="hapus">Menghapus...</span>
                                            </button>
                                        </div>
                                    @else
                                        <div class="kd-verify-actions">
                                            <a href="{{ route('mobile.angket.ubah', $baris) }}" wire:navigate class="kd-verify-btn is-ghost">
                                                <i data-lucide="pencil"></i>
                                                <span>Ubah</span>
                                            </a>
                                            <a href="{{ route('mobile.laporan.pdf', $baris) }}" class="kd-verify-btn is-pdf" title="Unduh hasil survey (PDF)">
                                                <i data-lucide="file-down"></i>
                                                <span>PDF</span>
                                            </a>
                                            <button type="button" wire:click="konfirmasiHapus('{{ $baris->id }}')" class="kd-verify-btn is-danger">
                                                <i data-lucide="trash-2"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if($daftar->hasPages())
                        <div class="kd-pagination">
                            <button type="button" wire:click="previousPage" wire:loading.attr="disabled" @disabled($daftar->onFirstPage()) class="kd-page-btn">
                                <i data-lucide="chevron-left"></i>
                                <span>Sebelumnya</span>
                            </button>
                            <span class="kd-page-info">{{ $daftar->currentPage() }} / {{ $daftar->lastPage() }}</span>
                            <button type="button" wire:click="nextPage" wire:loading.attr="disabled" @disabled(! $daftar->hasMorePages()) class="kd-page-btn">
                                <span>Berikutnya</span>
                                <i data-lucide="chevron-right"></i>
                            </button>
                        </div>
                    @endif
                @endif
            @elseif($lingkup === 'saya')
                @if(! $statistik['ada'])
                    <div class="kd-empty">
                        <i data-lucide="chart-column"></i>
                        <strong>Belum ada statistik</strong>
                        <p>Isi Survei APMO untuk melihat rangkuman kebiasaan olahraga Anda.</p>
                        <a href="{{ route('mobile.angket') }}" wire:navigate class="kd-page-btn">Isi Survei APMO</a>
                    </div>
                @else
                    <div class="kd-report-metrics">
                        <div class="kd-report-metric">
                            <strong>{{ number_format($statistik['jumlah']) }}</strong>
                            <span>Kali isi</span>
                        </div>
                        <div class="kd-report-metric">
                            <strong>{{ $statistik['imt'] !== null ? $statistik['imt'] : '—' }}</strong>
                            <span>IMT{{ $statistik['imtLabel'] ? ' · ' . $statistik['imtLabel'] : '' }}</span>
                        </div>
                        <div class="kd-report-metric">
                            <strong class="is-text">{{ $statistik['duduk'] }}</strong>
                            <span>Duduk/hari</span>
                        </div>
                    </div>

                    <div class="kd-report-card">
                        <h5>Profil terakhir</h5>
                        @foreach($statistik['profil'] as $baris)
                            <div class="kd-report-kv">
                                <span>{{ $baris['label'] }}</span>
                                <strong>{{ $baris['nilai'] }}</strong>
                            </div>
                        @endforeach
                    </div>

                    @if($statistik['olahraga'])
                        <div class="kd-report-card">
                            <h5>Kebiasaan olahraga <span>per minggu</span></h5>
                            @foreach($statistik['aktivitas'] as $aktivitas)
                                <div class="kd-report-kv">
                                    <span>{{ $aktivitas['label'] }}</span>
                                    <strong>
                                        {{ $aktivitas['frekuensi'] }}
                                        <small>
                                            {{ $aktivitas['durasi'] }} / sesi
                                            @if($aktivitas['menitMinggu'])
                                                · ±{{ number_format($aktivitas['menitMinggu']) }} mnt
                                            @endif
                                        </small>
                                    </strong>
                                </div>
                            @endforeach
                            <div class="kd-report-kv">
                                <span>Total waktu olahraga</span>
                                <strong>
                                    {{ number_format($statistik['totalMenitMinggu']) }} menit
                                    <small>±{{ number_format($statistik['totalMenitMinggu'] / 60, 1) }} jam / minggu</small>
                                </strong>
                            </div>
                        </div>

                        <div class="kd-report-card">
                            <h5>Preferensi olahraga</h5>
                            <div class="kd-report-kv">
                                <span>Cabang favorit</span>
                                <strong>{{ $statistik['cabang'] }}</strong>
                            </div>
                            <div class="kd-report-kv">
                                <span>Tujuan</span>
                                <strong>{{ $statistik['tujuan'] }}</strong>
                            </div>
                            <div class="kd-report-kv">
                                <span>Bersama</span>
                                <strong>{{ $statistik['jalur'] }}</strong>
                            </div>
                        </div>
                    @else
                        <div class="kd-report-card">
                            <h5>Alasan belum olahraga</h5>
                            <div class="kd-report-kv">
                                <span>Alasan utama</span>
                                <strong>{{ $statistik['alasan'] }}</strong>
                            </div>
                        </div>
                    @endif

                    <div class="kd-report-card">
                        <h5>Fasilitas olahraga</h5>
                        <div class="kd-report-kv">
                            <span>Penilaian fasilitas</span>
                            <strong>{{ $statistik['fasilitas'] }}</strong>
                        </div>
                        <div class="kd-report-kv">
                            <span>Lama duduk / hari</span>
                            <strong>{{ $statistik['duduk'] }}</strong>
                        </div>
                    </div>

                    <p class="kd-footnote">Dirangkum dari pengisian terakhir {{ $statistik['tanggal'] }}.</p>
                @endif
            @else
                @if(! $statistik['ada'])
                    <div class="kd-empty">
                        <i data-lucide="chart-column"></i>
                        <strong>Belum ada data wilayah</strong>
                        <p>Belum ada warga di {{ $namaLingkup }} yang mengisi Survei APMO.</p>
                    </div>
                @else
                    <div class="kd-report-card">
                        <h5>Status olahraga</h5>
                        @php $maksStatus = max(1, $statistik['total']); @endphp
                        <div class="kd-report-bar">
                            <span class="kd-report-bar-top">
                                <span>Aktif berolahraga</span>
                                <strong>{{ number_format($statistik['aktif']) }} <span class="kd-report-bar-note">({{ round($statistik['aktif'] / $maksStatus * 100) }}%)</span></strong>
                            </span>
                            <span class="kd-report-track"><span style="width: {{ round($statistik['aktif'] / $maksStatus * 100) }}%"></span></span>
                        </div>
                        <div class="kd-report-bar">
                            <span class="kd-report-bar-top">
                                <span>Tidak berolahraga</span>
                                <strong>{{ number_format($statistik['pasif']) }} <span class="kd-report-bar-note">({{ round($statistik['pasif'] / $maksStatus * 100) }}%)</span></strong>
                            </span>
                            <span class="kd-report-track"><span style="width: {{ round($statistik['pasif'] / $maksStatus * 100) }}%"></span></span>
                        </div>
                    </div>

                    <div class="kd-report-card">
                        <h5>Jenis kelamin</h5>
                        @foreach($statistik['gender'] as $bar)
                            <div class="kd-report-bar">
                                <span class="kd-report-bar-top">
                                    <span>{{ $bar['label'] }}</span>
                                    <strong>{{ number_format($bar['jumlah']) }} <span class="kd-report-bar-note">({{ $bar['persen'] }}%)</span></strong>
                                </span>
                                <span class="kd-report-track"><span style="width: {{ $bar['persen'] }}%"></span></span>
                            </div>
                        @endforeach
                    </div>

                    @if(count($statistik['cabang']))
                        <div class="kd-report-card">
                            <h5>Cabang olahraga terpopuler <span>dari yang aktif</span></h5>
                            @foreach($statistik['cabang'] as $bar)
                                <div class="kd-report-bar">
                                    <span class="kd-report-bar-top">
                                        <span>{{ $bar['label'] }}</span>
                                        <strong>{{ number_format($bar['jumlah']) }} <span class="kd-report-bar-note">({{ $bar['persen'] }}%)</span></strong>
                                    </span>
                                    <span class="kd-report-track"><span style="width: {{ $bar['persen'] }}%"></span></span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="kd-report-card">
                        <h5>Frekuensi olahraga sedang <span>per minggu</span></h5>
                        @foreach($statistik['frekuensi'] as $bar)
                            <div class="kd-report-bar">
                                <span class="kd-report-bar-top">
                                    <span>{{ $bar['label'] }}</span>
                                    <strong>{{ number_format($bar['jumlah']) }} <span class="kd-report-bar-note">({{ $bar['persen'] }}%)</span></strong>
                                </span>
                                <span class="kd-report-track"><span style="width: {{ $bar['persen'] }}%"></span></span>
                            </div>
                        @endforeach
                    </div>

                    <div class="kd-report-card">
                        <h5>Penilaian fasilitas olahraga</h5>
                        @foreach($statistik['fasilitas'] as $bar)
                            <div class="kd-report-bar">
                                <span class="kd-report-bar-top">
                                    <span>{{ $bar['label'] }}</span>
                                    <strong>{{ number_format($bar['jumlah']) }} <span class="kd-report-bar-note">({{ $bar['persen'] }}%)</span></strong>
                                </span>
                                <span class="kd-report-track"><span style="width: {{ $bar['persen'] }}%"></span></span>
                            </div>
                        @endforeach
                    </div>

                    @if($statistik['terakhir'])
                        <p class="kd-footnote">Isian terakhir {{ $statistik['terakhir'] }}.</p>
                    @endif
                @endif
            @endif
        @endif

        <p class="kd-footnote">KORMI Kabupaten Bandung · Laporan Survei APMO</p>
    </div>

    <x-mobile.tabbar aktif="laporan" />
</div>
