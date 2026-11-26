<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Livewire\Mobile\Angket;
use App\Models\Kormi\AngketApmo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LaporanApmoPdfController extends Controller
{
    public function __invoke(Request $request, AngketApmo $isian)
    {
        $pengguna = $request->user();

        abort_unless($pengguna && $isian->pengguna_id === $pengguna->id, 403);

        $pdf = Pdf::loadView('pdf.apmo.laporan', $this->data($isian, $pengguna->nama_lengkap))
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('defaultFont', 'DejaVu Sans');

        $nama = Str::slug($isian->nama_lengkap ?: 'responden') ?: 'responden';
        $tanggal = Carbon::parse($isian->dibuat_pada)->timezone('Asia/Jakarta')->format('Y-m-d');

        return $pdf->download("Laporan-Survey-APMO-{$nama}-{$tanggal}.pdf");
    }

    private function data(AngketApmo $isian, ?string $dicetakOleh): array
    {
        $tinggi = (int) $isian->tinggi_badan;
        $berat = (int) $isian->berat_badan;
        $imt = ($tinggi > 0 && $berat > 0) ? round($berat / (($tinggi / 100) ** 2), 1) : null;

        $aktivitas = [];
        $totalMenitMinggu = 0;

        foreach (['berat' => 'Olahraga berat', 'sedang' => 'Olahraga sedang', 'jalan' => 'Jalan kaki'] as $jenis => $label) {
            $frekuensi = $isian->{'frekuensi_' . $jenis};
            $jam = (int) $isian->{'durasi_' . $jenis . '_jam'};
            $menit = (int) $isian->{'durasi_' . $jenis . '_menit'};
            $tidakTahu = (bool) $isian->{'durasi_' . $jenis . '_tidak_tahu'};
            $menitMinggu = $this->menitPerMinggu($frekuensi, $jam, $menit, $tidakTahu);
            $totalMenitMinggu += $menitMinggu ?? 0;

            $aktivitas[] = [
                'label' => $label,
                'frekuensi' => Angket::OPSI_FREKUENSI[$frekuensi] ?? '—',
                'durasi' => $tidakTahu ? 'Tidak tahu' : $this->formatDurasi($jam, $menit),
                'menitMinggu' => $menitMinggu,
            ];
        }

        $tanggalIsi = Carbon::parse($isian->dibuat_pada)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y');

        return [
            'isian' => $isian,
            'dicetakOleh' => $dicetakOleh,
            'kodeDokumen' => 'APMO-' . strtoupper(substr($isian->id, 0, 8)),
            'tanggalIsi' => $tanggalIsi,
            'dicetakPada' => now('Asia/Jakarta')->locale('id')->isoFormat('D MMM Y, HH.mm') . ' WIB',
            'logo' => $this->logoSrc(),
            'foto' => $this->fotoDataUri($isian->foto_bukti),
            'jenisKelamin' => match ($isian->jenis_kelamin) {
                'pria' => 'Laki-laki',
                'wanita' => 'Perempuan',
                default => '—',
            },
            'pekerjaan' => Angket::OPSI_PEKERJAAN[$isian->pekerjaan] ?? ($isian->pekerjaan_lainnya ?: '—'),
            'imt' => $imt,
            'imtLabel' => $this->labelImt($imt),
            'olahraga' => (bool) $isian->melakukan_olahraga,
            'aktivitas' => $aktivitas,
            'totalMenitMinggu' => $totalMenitMinggu,
            'duduk' => $isian->pernah_malas !== 'pernah'
                ? '—'
                : ($isian->duduk_tidak_tahu ? 'Tidak tahu' : $this->formatDurasi((int) $isian->duduk_jam, (int) $isian->duduk_menit)),
            'cabang' => $this->labelOpsi(Angket::OPSI_CABANG, $isian->cabang_olahraga, $isian->cabang_lainnya),
            'tujuan' => $this->labelOpsi(Angket::OPSI_TUJUAN, $isian->tujuan_olahraga, $isian->tujuan_lainnya),
            'jalur' => $this->labelOpsi(Angket::OPSI_JALUR, $isian->jalur_olahraga, $isian->jalur_lainnya),
            'fasilitas' => $this->labelOpsi(Angket::OPSI_FASILITAS, $isian->fasilitas_olahraga),
            'alasan' => $this->labelOpsi(Angket::OPSI_ALASAN, $isian->alasan_tidak_olahraga, $isian->alasan_lainnya),
        ];
    }

    private function logoSrc(): ?string
    {
        $path = public_path('assets/image/logo-kormi.png');

        if (! is_file($path)) {
            return null;
        }

        return 'data:image/png;base64,' . base64_encode(file_get_contents($path));
    }

    private function fotoDataUri(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        try {
            $biner = Str::startsWith($path, ['http://', 'https://'])
                ? @file_get_contents($path)
                : Storage::disk('minio')->get($path);
        } catch (\Throwable) {
            return null;
        }

        if (! $biner) {
            return null;
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($biner) ?: 'image/jpeg';

        return 'data:' . $mime . ';base64,' . base64_encode($biner);
    }

    private function formatDurasi(int $jam, int $menit): string
    {
        if ($jam <= 0 && $menit <= 0) {
            return '—';
        }

        $bagian = [];

        if ($jam > 0) {
            $bagian[] = $jam . ' jam';
        }

        if ($menit > 0) {
            $bagian[] = $menit . ' menit';
        }

        return implode(' ', $bagian);
    }

    private function menitPerMinggu(?string $frekuensi, int $jam, int $menit, bool $tidakTahu): ?int
    {
        $kali = match ($frekuensi) {
            '1' => 1,
            '2' => 2,
            '3' => 3,
            'lebih' => 4,
            default => null,
        };

        $perSesi = $jam * 60 + $menit;

        if ($kali === null || $tidakTahu || $perSesi <= 0) {
            return null;
        }

        return $kali * $perSesi;
    }

    private function labelImt(?float $imt): ?string
    {
        if ($imt === null) {
            return null;
        }

        return match (true) {
            $imt < 18.5 => 'Kurang',
            $imt < 25 => 'Normal',
            $imt < 30 => 'Berlebih',
            default => 'Obesitas',
        };
    }

    private function labelOpsi(array $opsi, ?string $kunci, ?string $lainnya = null): string
    {
        if (! $kunci) {
            return '—';
        }

        if ($kunci === 'lainnya' && $lainnya) {
            return $lainnya;
        }

        return $opsi[$kunci] ?? ucfirst(str_replace('_', ' ', $kunci));
    }
}
