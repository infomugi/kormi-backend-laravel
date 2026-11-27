<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Survey APMO</title>
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
