<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Livewire\Mobile\Angket;
use App\Models\Core\Pengguna;
use App\Models\Kormi\AngketApmo;
use App\Models\Kormi\DutaOlahraga;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LaporanWilayahPdfController extends Controller
{
    public function __invoke(Request $request, string $lingkup)
    {
        $pengguna = $request->user();

        abort_unless($pengguna && in_array($lingkup, ['desa', 'kecamatan'], true), 404);
        abort_unless($this->bolehAkses($pengguna), 403);

        $wilayah = $this->wilayah($pengguna);
        $namaWilayah = $lingkup === 'desa' ? $wilayah['desa'] : $wilayah['kecamatan'];

        abort_unless($namaWilayah, 404);

        $kueri = AngketApmo::query();

        if ($lingkup === 'desa') {
            $kueri->where('desa', $wilayah['desa']);
        } else {
            $kueri->where('kecamatan', $wilayah['kecamatan']);
        }

        $pdf = Pdf::loadView('pdf.apmo.wilayah', [
            'judulWilayah' => ($lingkup === 'desa' ? 'Desa ' : 'Kecamatan ') . $namaWilayah,
            'lingkup' => $lingkup,
            'ringkasan' => $this->ringkasan($kueri),
            'statistik' => $this->statistikWilayah($kueri),
            'dicetakOleh' => $pengguna->nama_lengkap,
            'kodeDokumen' => 'APMO-WIL-' . strtoupper(substr(sha1($lingkup . '|' . $namaWilayah), 0, 8)),
            'dicetakPada' => now('Asia/Jakarta')->locale('id')->isoFormat('D MMM Y, HH.mm') . ' WIB',
            'tanggalCetak' => now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y'),
            'logo' => $this->logoSrc(),
        ])
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('defaultFont', 'DejaVu Sans');

        $slug = Str::slug($namaWilayah) ?: 'wilayah';
        $tanggal = now('Asia/Jakarta')->format('Y-m-d');

        return $pdf->download("Laporan-Survey-APMO-" . ucfirst($lingkup) . "-{$slug}-{$tanggal}.pdf");
    }

    private function bolehAkses(Pengguna $user): bool
    {
        return $user->isDutaOlahraga()
            || $user->isPegiatOlahraga()
            || $user->hasRole('super-admin', 'admin-korcam', 'admin-inorga', 'editor-berita');
    }

    private function wilayah(Pengguna $user): array
    {
        $duta = $user->duta ?? DutaOlahraga::where('pengguna_id', $user->id)->first();

        return [
            'desa' => $duta?->desaKelurahan?->nama_desa_kelurahan ?? $user->desa?->nama_desa_kelurahan,
            'kecamatan' => $duta?->kecamatan?->nama_kecamatan ?? $user->kecamatan?->nama_kecamatan,
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

    private function ringkasan(Builder $kueri): array
    {
        $total = (clone $kueri)->count();
        $aktif = (clone $kueri)->where('melakukan_olahraga', true)->count();
        $usiaRata = (clone $kueri)->avg('usia');
        $terakhir = (clone $kueri)->max('dibuat_pada');

        return [
            'total' => $total,
            'aktif' => $aktif,
            'pasif' => $total - $aktif,
            'persenAktif' => $total > 0 ? (int) round($aktif / $total * 100) : 0,
            'usiaRata' => $usiaRata !== null ? round((float) $usiaRata, 1) : null,
            'terakhir' => $terakhir
                ? Carbon::parse($terakhir)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM Y')
                : null,
        ];
    }

    private function statistikWilayah(Builder $kueri): array
    {
        $total = (clone $kueri)->count();

        if ($total === 0) {
            return ['ada' => false];
        }

        $aktif = (clone $kueri)->where('melakukan_olahraga', true)->count();

        $gender = (clone $kueri)
            ->selectRaw('jenis_kelamin as kunci, COUNT(*) as jumlah')
            ->groupBy('jenis_kelamin')
            ->pluck('jumlah', 'kunci');

        $cabang = (clone $kueri)
            ->where('melakukan_olahraga', true)
            ->whereNotNull('cabang_olahraga')
            ->selectRaw('cabang_olahraga as kunci, COUNT(*) as jumlah')
            ->groupBy('cabang_olahraga')
            ->orderByDesc('jumlah')
            ->limit(5)
            ->get()
            ->map(fn ($baris) => [
                'label' => Angket::OPSI_CABANG[$baris->kunci] ?? ucfirst(str_replace('_', ' ', $baris->kunci)),
                'jumlah' => (int) $baris->jumlah,
                'persen' => $aktif > 0 ? (int) round($baris->jumlah / $aktif * 100) : 0,
            ])
            ->all();

        $frekuensiRaw = (clone $kueri)
            ->where('melakukan_olahraga', true)
            ->whereNotNull('frekuensi_sedang')
            ->selectRaw('frekuensi_sedang as kunci, COUNT(*) as jumlah')
            ->groupBy('frekuensi_sedang')
            ->pluck('jumlah', 'kunci');

        $frekuensi = collect(Angket::OPSI_FREKUENSI)
            ->map(fn ($label, $kunci) => [
                'label' => $label,
                'jumlah' => $jumlah = (int) ($frekuensiRaw[$kunci] ?? 0),
                'persen' => $aktif > 0 ? (int) round($jumlah / $aktif * 100) : 0,
            ])
            ->values()
            ->all();

        $fasilitasRaw = (clone $kueri)
            ->whereNotNull('fasilitas_olahraga')
            ->selectRaw('fasilitas_olahraga as kunci, COUNT(*) as jumlah')
            ->groupBy('fasilitas_olahraga')
            ->pluck('jumlah', 'kunci');

        $fasilitas = collect(Angket::OPSI_FASILITAS)
            ->map(fn ($label, $kunci) => [
                'label' => $label,
                'jumlah' => $jumlah = (int) ($fasilitasRaw[$kunci] ?? 0),
                'persen' => $total > 0 ? (int) round($jumlah / $total * 100) : 0,
            ])
            ->values()
            ->all();

        return [
            'ada' => true,
            'total' => $total,
            'aktif' => $aktif,
            'pasif' => $total - $aktif,
            'gender' => [
                ['label' => 'Laki-laki', 'jumlah' => $pria = (int) ($gender['pria'] ?? 0), 'persen' => (int) round($pria / $total * 100)],
                ['label' => 'Perempuan', 'jumlah' => $wanita = (int) ($gender['wanita'] ?? 0), 'persen' => (int) round($wanita / $total * 100)],
            ],
            'cabang' => $cabang,
            'frekuensi' => $frekuensi,
            'fasilitas' => $fasilitas,
        ];
    }
}
