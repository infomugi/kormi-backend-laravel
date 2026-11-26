<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Survey APMO</title>
    <style>
        @page {
            margin: 26px 34px 46px 34px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8.8pt;
            line-height: 1.4;
            color: #181916;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            vertical-align: top;
        }

        .accent-bar {
            height: 6px;
            background: #c6fa28;
            margin-bottom: 16px;
        }

        /* ---------- Kop dokumen ---------- */
        .kop {
            width: 100%;
        }

        .kop-left {
            width: 60%;
            padding-right: 14px;
        }

        .kop-right {
            width: 40%;
        }

        .logo {
            width: 44px;
            height: 45px;
        }

        .kop-org {
            font-size: 11.5pt;
            font-weight: bold;
            letter-spacing: 0.02em;
            color: #1d1e1b;
            line-height: 1.2;
        }

        .kop-org-sub {
            font-size: 7pt;
            color: #7f827c;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .kop-title {
            margin-top: 7px;
            font-size: 15pt;
            font-weight: bold;
            letter-spacing: -0.01em;
            color: #1d1e1b;
        }

        .kop-desc {
            font-size: 8pt;
            color: #7f827c;
        }

        .meta {
            background: #f5f6f4;
            border: 1px solid #e6e8e1;
            padding: 9px 11px;
            font-size: 7.6pt;
        }

        .meta td {
            padding: 2px 0;
        }

        .meta .label {
            color: #7f827c;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 6.6pt;
            width: 46%;
            padding-right: 6px;
        }

        .meta .value {
            font-weight: bold;
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        .kop-rule {
            margin: 11px 0 12px;
            border-top: 2px solid #1d1e1b;
        }

        /* ---------- Seksi ---------- */
        .section {
            margin-bottom: 11px;
            page-break-inside: avoid;
        }

        .sec-head {
            margin-bottom: 7px;
        }

        .sec-num {
            display: inline-block;
            width: 16px;
            height: 16px;
            line-height: 16px;
            text-align: center;
            background: #1d1e1b;
            color: #c6fa28;
            font-size: 7.5pt;
            font-weight: bold;
            margin-right: 6px;
        }

        .sec-title {
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sec-note {
            color: #7f827c;
            font-size: 7.6pt;
            font-weight: normal;
            text-transform: none;
            letter-spacing: 0;
        }

        /* ---------- Tabel identitas ---------- */
        .kv {
            border: 1px solid #e6e8e1;
        }

        .kv th, .kv td {
            padding: 5px 8px;
            border-top: 1px solid #e6e8e1;
            font-size: 8.6pt;
        }

        .kv tr:first-child th,
        .kv tr:first-child td {
            border-top: none;
        }

        .kv th {
            width: 18%;
            background: #f5f6f4;
            text-align: left;
            font-size: 7.4pt;
            font-weight: normal;
            color: #7f827c;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .kv td {
            width: 32%;
            font-weight: bold;
        }

        .kv td.strong-full {
            font-weight: bold;
        }

        /* ---------- Metrik ringkasan ---------- */
        .metrics {
            border: 1px solid #e6e8e1;
            background: #f5f6f4;
        }

        .metrics td {
            width: 25%;
            padding: 7px 9px;
            border-left: 1px solid #e6e8e1;
        }

        .metrics td:first-child {
            border-left: none;
        }

        .metrics .metric-value {
            font-size: 12.5pt;
            font-weight: bold;
            letter-spacing: -0.01em;
            line-height: 1.2;
            font-variant-numeric: tabular-nums;
        }

        .metrics .metric-label {
            margin-top: 1px;
            font-size: 6.6pt;
            font-weight: bold;
            color: #7f827c;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .metrics .metric-sub {
            font-size: 7pt;
            color: #7f827c;
        }

        /* ---------- Tabel data ---------- */
        .tabel {
            border: 1px solid #e6e8e1;
            font-size: 8.6pt;
        }

        .tabel thead th {
            background: #1d1e1b;
            color: #ffffff;
            text-align: left;
            padding: 5px 8px;
            font-size: 7.2pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .tabel tbody td {
            padding: 5px 8px;
            border-top: 1px solid #e6e8e1;
            font-variant-numeric: tabular-nums;
        }

        .tabel tbody tr:nth-child(even) td {
            background: #fafbf8;
        }

        .tabel .angka {
            text-align: right;
            font-weight: bold;
        }

        .tabel tfoot td {
            padding: 7px 9px;
            border-top: 2px solid #1d1e1b;
            background: #eefcd0;
            font-weight: bold;
            font-size: 8.8pt;
        }

        .tabel tfoot .angka {
            text-align: right;
            font-size: 10pt;
        }

        /* ---------- Catatan status ---------- */
        .notice {
            padding: 8px 11px;
            border: 1px solid #f0dfa4;
            background: #fdf8e7;
            font-size: 8.6pt;
            page-break-inside: avoid;
        }

        .notice b {
            color: #6b5312;
        }

        .empty-value {
            color: #7f827c;
            font-weight: normal;
        }

        /* ---------- Foto bukti ---------- */
        .foto-wrap {
            padding: 9px;
            border: 1px solid #e6e8e1;
            background: #f5f6f4;
            display: inline-block;
        }

        .foto-wrap img {
            max-width: 250px;
            max-height: 190px;
        }

        .foto-caption {
            margin-top: 5px;
            font-size: 7.2pt;
            color: #7f827c;
        }

        /* ---------- Tanda tangan ---------- */
        .tutup {
            margin-top: 12px;
            page-break-inside: avoid;
        }

        .catatan {
            padding: 7px 10px;
            border-left: 3px solid #c6fa28;
            background: #fafbf8;
            font-size: 7.6pt;
            color: #55584f;
            margin-bottom: 10px;
        }

        .tanda {
            width: 100%;
        }

        .tanda td {
            width: 50%;
            font-size: 8.6pt;
        }

        .tanda .tanggal {
            font-size: 8.6pt;
        }

        .tanda .ruang {
            height: 38px;
        }

        .tanda .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .tanda .peran {
            font-size: 7.4pt;
            color: #7f827c;
        }
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
                <div class="kop-desc">Angket Partisipasi Masyarakat dalam Olahraga — ringkasan isian responden.</div>
            </td>
            <td class="kop-right">
                <table class="meta">
                    <tr>
                        <td class="label">No. Dokumen</td>
                        <td class="value">{{ $kodeDokumen }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Isian</td>
                        <td class="value">{{ $tanggalIsi }}</td>
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

    {{-- A. Identitas responden --}}
    <div class="section">
        <div class="sec-head"><span class="sec-num">A</span><span class="sec-title">Identitas Responden</span></div>
        <table class="kv">
            <colgroup>
                <col style="width: 18%;">
                <col style="width: 32%;">
                <col style="width: 18%;">
                <col style="width: 32%;">
            </colgroup>
            <tr>
                <th>Nama lengkap</th>
                <td class="strong-full" colspan="3">{{ $isian->nama_lengkap ?: '—' }}</td>
            </tr>
            <tr>
                <th>Usia</th>
                <td>{{ $isian->usia }} tahun</td>
                <th>Jenis kelamin</th>
                <td>{{ $jenisKelamin }}</td>
            </tr>
            <tr>
                <th>Tinggi badan</th>
                <td>{{ $isian->tinggi_badan ? $isian->tinggi_badan . ' cm' : '—' }}</td>
                <th>Berat badan</th>
                <td>{{ $isian->berat_badan ? $isian->berat_badan . ' kg' : '—' }}</td>
            </tr>
            <tr>
                <th>Pekerjaan</th>
                <td colspan="3">{{ $pekerjaan }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td colspan="3">{{ $isian->alamat ?: '—' }}</td>
            </tr>
            <tr>
                <th>Desa / Kelurahan</th>
                <td>{{ $isian->desa ?: '—' }}</td>
                <th>Kecamatan</th>
                <td>{{ $isian->kecamatan ?: '—' }}</td>
            </tr>
            <tr>
                <th>Kabupaten / Kota</th>
                <td>{{ $isian->kabupaten_kota ?: '—' }}</td>
                <th>Tanggal isian</th>
                <td>{{ $tanggalIsi }}</td>
            </tr>
        </table>
    </div>

    {{-- B. Ringkasan kebugaran --}}
    <div class="section">
        <div class="sec-head"><span class="sec-num">B</span><span class="sec-title">Ringkasan Status</span></div>
        <table class="metrics">
            <tr>
                <td>
                    <div class="metric-value">{{ $imt !== null ? number_format($imt, 1, ',', '.') : '—' }}</div>
                    <div class="metric-label">Indeks Massa Tubuh</div>
                    <div class="metric-sub">{{ $imtLabel ? 'Kategori ' . $imtLabel : 'Tinggi/berat belum lengkap' }}</div>
                </td>
                <td>
                    <div class="metric-value">{{ $olahraga ? 'Aktif' : 'Tidak aktif' }}</div>
                    <div class="metric-label">Status olahraga</div>
                    <div class="metric-sub">{{ $olahraga ? 'Melakukan olahraga rutin' : 'Belum melakukan olahraga' }}</div>
                </td>
                <td>
                    <div class="metric-value">{{ $olahraga ? number_format($totalMenitMinggu) . ' mnt' : '—' }}</div>
                    <div class="metric-label">Estimasi / minggu</div>
                    <div class="metric-sub">{{ $olahraga ? '±' . number_format($totalMenitMinggu / 60, 1) . ' jam per minggu' : 'Tidak ada aktivitas tercatat' }}</div>
                </td>
                <td>
                    <div class="metric-value" style="font-size: 10pt;">{{ $duduk }}</div>
                    <div class="metric-label">Lama duduk / hari</div>
                    <div class="metric-sub">{{ $isian->pernah_malas === 'pernah' ? 'Dalam 7 hari terakhir' : 'Tidak dilaporkan' }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- C. Kebiasaan olahraga --}}
    <div class="section">
        <div class="sec-head">
            <span class="sec-num">C</span><span class="sec-title">Kebiasaan Olahraga</span>
            <span class="sec-note">— dalam satu minggu terakhir</span>
        </div>

        @if($olahraga)
            <table class="tabel">
                <thead>
                    <tr>
                        <th style="width: 34%;">Jenis olahraga</th>
                        <th style="width: 22%;">Frekuensi</th>
                        <th style="width: 22%;">Durasi / sesi</th>
                        <th style="width: 22%; text-align: right;">Estimasi / minggu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aktivitas as $baris)
                        <tr>
                            <td>{{ $baris['label'] }}</td>
                            <td>{{ $baris['frekuensi'] }}</td>
                            <td>{{ $baris['durasi'] }}</td>
                            <td class="angka" style="text-align: right;">
                                {{ $baris['menitMinggu'] !== null ? number_format($baris['menitMinggu']) . ' mnt' : '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total estimasi waktu olahraga</td>
                        <td class="angka">{{ number_format($totalMenitMinggu) }} menit</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="notice">
                <b>Responden menyatakan belum melakukan olahraga.</b>
                Alasan utama: {{ $alasan }}.
            </div>
        @endif
    </div>

    {{-- D. Preferensi & fasilitas --}}
    <div class="section">
        <div class="sec-head"><span class="sec-num">D</span><span class="sec-title">Preferensi &amp; Fasilitas</span></div>
        <table class="kv">
            <colgroup>
                <col style="width: 18%;">
                <col style="width: 32%;">
                <col style="width: 18%;">
                <col style="width: 32%;">
            </colgroup>
            @if($olahraga)
                <tr>
                    <th>Cabang favorit</th>
                    <td>{{ $cabang }}</td>
                    <th>Tujuan olahraga</th>
                    <td>{{ $tujuan }}</td>
                </tr>
                <tr>
                    <th>Jalur olahraga</th>
                    <td>{{ $jalur }}</td>
                    <th>Penilaian fasilitas</th>
                    <td>{{ $fasilitas }}</td>
                </tr>
            @else
                <tr>
                    <th>Alasan utama</th>
                    <td colspan="3">{{ $alasan }}</td>
                </tr>
                <tr>
                    <th>Penilaian fasilitas</th>
                    <td colspan="3">{{ $fasilitas }}</td>
                </tr>
            @endif
            <tr>
                <th>Lama duduk / hari</th>
                <td colspan="3">{{ $duduk }}</td>
            </tr>
        </table>
    </div>

    {{-- E. Foto bukti --}}
    @if($foto)
        <div class="section">
            <div class="sec-head"><span class="sec-num">E</span><span class="sec-title">Foto Bukti Kegiatan</span></div>
            <div class="foto-wrap">
                <img src="{{ $foto }}" alt="Foto bukti survey {{ $isian->nama_lengkap }}">
                <div class="foto-caption">Dokumentasi yang diunggah bersama isian tanggal {{ $tanggalIsi }}.</div>
            </div>
        </div>
    @endif

    <div class="tutup">
        <div class="catatan">
            Data pada laporan ini bersumber dari isian Survey APMO yang tersimpan pada Sistem Informasi
            KORMI Kabupaten Bandung. Dokumen dihasilkan otomatis oleh sistem dan sah tanpa tanda tangan basah.
        </div>

        <table class="tanda">
            <tr>
                <td class="tanggal">Bandung, {{ $tanggalIsi }}</td>
                <td class="tanggal" style="text-align: right;">Dicetak oleh,</td>
            </tr>
            <tr>
                <td class="ruang"></td>
                <td class="ruang"></td>
            </tr>
            <tr>
                <td class="nama">{{ $isian->nama_lengkap ?: '—' }}</td>
                <td class="nama" style="text-align: right;">{{ $dicetakOleh ?: '—' }}</td>
            </tr>
            <tr>
                <td class="peran">Responden</td>
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
