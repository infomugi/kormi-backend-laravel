<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Survey APMO Wilayah</title>
    <style>
        @include('pdf.apmo.partials.gaya')
    </style>
</head>
<body>
    <div class="accent-bar"></div>

    <table class="kop">
        <tr>
            <td class="kop-left">
                <table>
                    <tr>
                        <td style="width: 54px;">
                            @if($logo)
                                <img class="logo" src="{{ $logo }}" alt="Logo KORMI">
                            @endif
                        </td>
                        <td>
                            <div class="kop-org">KORMI KABUPATEN BANDUNG</div>
                            <div class="kop-org-sub">Komite Olahraga Rekreasi Masyarakat Indonesia</div>
                        </td>
                    </tr>
                </table>
                <div class="kop-title">Laporan Hasil Survey APMO</div>
                <div class="kop-desc">Rekapitulasi partisipasi olahraga masyarakat — {{ $judulWilayah }}.</div>
            </td>
            <td class="kop-right">
                <table class="meta">
                    <tr>
                        <td class="label">No. Dokumen</td>
                        <td class="value">{{ $kodeDokumen }}</td>
                    </tr>
                    <tr>
                        <td class="label">Wilayah</td>
                        <td class="value">{{ $judulWilayah }}</td>
                    </tr>
                    <tr>
                        <td class="label">Dicetak Pada</td>
                        <td class="value">{{ $dicetakPada }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="kop-rule"></div>

    {{-- A. Ringkasan wilayah --}}
    <div class="section">
        <div class="sec-head">
            <span class="sec-num">A</span><span class="sec-title">Ringkasan Wilayah</span>
            <span class="sec-note">— sumber: seluruh isian Survey APMO wilayah ini</span>
        </div>
        <table class="metrics">
            <tr>
                <td>
                    <div class="metric-value">{{ number_format($ringkasan['total']) }}</div>
                    <div class="metric-label">Total isian</div>
                    <div class="metric-sub">Responden terdata</div>
                </td>
                <td>
                    <div class="metric-value">{{ $ringkasan['persenAktif'] }}%</div>
                    <div class="metric-label">Aktif olahraga</div>
                    <div class="metric-sub">{{ number_format($ringkasan['aktif']) }} dari {{ number_format($ringkasan['total']) }} responden</div>
                </td>
                <td>
                    <div class="metric-value">{{ $ringkasan['usiaRata'] !== null ? number_format($ringkasan['usiaRata'], 1, ',', '.') : '—' }}</div>
                    <div class="metric-label">Rata-rata usia</div>
                    <div class="metric-sub">Tahun</div>
                </td>
                <td>
                    <div class="metric-value" style="font-size: 10pt;">{{ $ringkasan['terakhir'] ?: '—' }}</div>
                    <div class="metric-label">Isian terakhir</div>
                    <div class="metric-sub">{{ $ringkasan['terakhir'] ? 'Tanggal pengisian terbaru' : 'Belum ada isian' }}</div>
                </td>
            </tr>
        </table>
    </div>

    @if(! $statistik['ada'])
        <div class="notice">
            <b>Belum ada isian Survey APMO di {{ $judulWilayah }}.</b>
            Laporan ini hanya memuat ringkasan kosong dan akan diperbarui otomatis setelah warga mengisi survey.
        </div>
    @else
        @php
            $persenPasif = $statistik['total'] > 0 ? max(0, 100 - (int) round($statistik['aktif'] / $statistik['total'] * 100)) : 0;
        @endphp

        {{-- B. Status olahraga --}}
        <div class="section">
            <div class="sec-head"><span class="sec-num">B</span><span class="sec-title">Status Olahraga</span></div>
            <table class="tabel">
                <thead>
                    <tr>
                        <th style="width: 34%;">Status</th>
                        <th style="width: 14%; text-align: right;">Jumlah</th>
                        <th style="width: 12%; text-align: right;">Porsi</th>
                        <th style="width: 40%;">Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Aktif berolahraga</td>
                        <td class="angka">{{ number_format($statistik['aktif']) }}</td>
                        <td class="angka">{{ $ringkasan['persenAktif'] }}%</td>
                        <td><div class="track"><div class="fill is-lime" style="width: {{ $ringkasan['persenAktif'] }}%"></div></div></td>
                    </tr>
                    <tr>
                        <td>Tidak berolahraga</td>
                        <td class="angka">{{ number_format($statistik['pasif']) }}</td>
                        <td class="angka">{{ $persenPasif }}%</td>
                        <td><div class="track"><div class="fill" style="width: {{ $persenPasif }}%"></div></div></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total responden</td>
                        <td class="angka">{{ number_format($statistik['total']) }}</td>
                        <td class="angka">100%</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- C. Jenis kelamin --}}
        <div class="section">
            <div class="sec-head"><span class="sec-num">C</span><span class="sec-title">Jenis Kelamin Responden</span></div>
            <table class="tabel">
                <thead>
                    <tr>
                        <th style="width: 34%;">Jenis kelamin</th>
                        <th style="width: 14%; text-align: right;">Jumlah</th>
                        <th style="width: 12%; text-align: right;">Porsi</th>
                        <th style="width: 40%;">Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statistik['gender'] as $bar)
                        <tr>
                            <td>{{ $bar['label'] }}</td>
                            <td class="angka">{{ number_format($bar['jumlah']) }}</td>
                            <td class="angka">{{ $bar['persen'] }}%</td>
                            <td><div class="track"><div class="fill" style="width: {{ $bar['persen'] }}%"></div></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- D. Cabang olahraga terpopuler --}}
        <div class="section">
            <div class="sec-head">
                <span class="sec-num">D</span><span class="sec-title">Cabang Olahraga Terpopuler</span>
                <span class="sec-note">— dari responden yang aktif berolahraga</span>
            </div>
            <table class="tabel">
                <thead>
                    <tr>
                        <th style="width: 34%;">Cabang olahraga</th>
                        <th style="width: 14%; text-align: right;">Jumlah</th>
                        <th style="width: 12%; text-align: right;">Porsi</th>
                        <th style="width: 40%;">Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statistik['cabang'] as $bar)
                        <tr>
                            <td>{{ $bar['label'] }}</td>
                            <td class="angka">{{ number_format($bar['jumlah']) }}</td>
                            <td class="angka">{{ $bar['persen'] }}%</td>
                            <td><div class="track"><div class="fill" style="width: {{ $bar['persen'] }}%"></div></div></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-value">Belum ada data cabang olahraga.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- E. Frekuensi olahraga sedang --}}
        <div class="section">
            <div class="sec-head">
                <span class="sec-num">E</span><span class="sec-title">Frekuensi Olahraga Sedang</span>
                <span class="sec-note">— per minggu, dari responden yang aktif</span>
            </div>
            <table class="tabel">
                <thead>
                    <tr>
                        <th style="width: 34%;">Frekuensi</th>
                        <th style="width: 14%; text-align: right;">Jumlah</th>
                        <th style="width: 12%; text-align: right;">Porsi</th>
                        <th style="width: 40%;">Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statistik['frekuensi'] as $bar)
                        <tr>
                            <td>{{ $bar['label'] }}</td>
                            <td class="angka">{{ number_format($bar['jumlah']) }}</td>
                            <td class="angka">{{ $bar['persen'] }}%</td>
                            <td><div class="track"><div class="fill" style="width: {{ $bar['persen'] }}%"></div></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- F. Penilaian fasilitas --}}
        <div class="section">
            <div class="sec-head">
                <span class="sec-num">F</span><span class="sec-title">Penilaian Fasilitas Olahraga</span>
                <span class="sec-note">— dari seluruh responden</span>
            </div>
            <table class="tabel">
                <thead>
                    <tr>
                        <th style="width: 34%;">Penilaian</th>
                        <th style="width: 14%; text-align: right;">Jumlah</th>
                        <th style="width: 12%; text-align: right;">Porsi</th>
                        <th style="width: 40%;">Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statistik['fasilitas'] as $bar)
                        <tr>
                            <td>{{ $bar['label'] }}</td>
                            <td class="angka">{{ number_format($bar['jumlah']) }}</td>
                            <td class="angka">{{ $bar['persen'] }}%</td>
                            <td><div class="track"><div class="fill" style="width: {{ $bar['persen'] }}%"></div></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="tutup">
        <div class="catatan">
            Data pada laporan ini dirangkum otomatis dari seluruh isian Survey APMO wilayah {{ $judulWilayah }}
            yang tersimpan pada Sistem Informasi KORMI Kabupaten Bandung. Dokumen sah tanpa tanda tangan basah.
        </div>

        <table class="tanda">
            <tr>
                <td></td>
                <td class="tanggal" style="text-align: right;">Bandung, {{ $tanggalCetak }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="ruang"></td>
            </tr>
            <tr>
                <td></td>
                <td class="nama" style="text-align: right;">{{ $dicetakOleh ?: '—' }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="peran" style="text-align: right;">Pengguna Sistem Informasi KORMI</td>
            </tr>
        </table>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $warna = [0.5, 0.51, 0.49];
            $y = $pdf->get_height() - 26;

            $pdf->page_text(
                34,
                $y,
                "KORMI Kabupaten Bandung · Laporan Survey APMO · {{ $kodeDokumen }}",
                $font,
                6.8,
                $warna
            );
            $pdf->page_text(
                $pdf->get_width() - 100,
                $y,
                'Halaman {PAGE_NUM} dari {PAGE_COUNT}',
                $font,
                6.8,
                $warna
            );
        }
    </script>
</body>
</html>
