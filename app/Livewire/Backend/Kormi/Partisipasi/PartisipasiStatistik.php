<?php

namespace App\Livewire\Backend\Kormi\Partisipasi;

use App\Models\Kormi\PartisipasiAktivitas;
use App\Models\Kormi\Inorga;
use App\Models\Master\Kecamatan;
use App\Models\Core\Pengguna;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.backend')]
#[Title('Dashboard Statistik APMO - KORMI CMS')]
class PartisipasiStatistik extends Component
{
    public int $periodeHari = 30; // 7, 30, 90, 365

    public function updatedPeriodeHari(): void
    {
        // Re-render
    }

    public function render()
    {
        $startDate = now()->subDays($this->periodeHari)->toDateString();

        // 1. Indikator Utama
        $totalAktivitas = PartisipasiAktivitas::valid()->where('tanggal_aktivitas', '>=', $startDate)->count();
        $totalPartisipan = PartisipasiAktivitas::valid()->where('tanggal_aktivitas', '>=', $startDate)->sum('jumlah_peserta');
        $totalDurasiMenit = PartisipasiAktivitas::valid()->where('tanggal_aktivitas', '>=', $startDate)->sum('durasi_menit');
        $totalWargaUnik = PartisipasiAktivitas::valid()->where('tanggal_aktivitas', '>=', $startDate)->distinct('pengguna_id')->count('pengguna_id');
        $totalDutaAktif = PartisipasiAktivitas::valid()->where('metode_pencatatan', 'via_duta')->where('tanggal_aktivitas', '>=', $startDate)->distinct('duta_id')->count('duta_id');

        // 2. Leaderboard Kecamatan Teraktif
        $kecamatanStat = Kecamatan::withCount(['partisipasi as total_kegiatan' => function ($q) use ($startDate) {
                $q->where('status_verifikasi', 'valid')->where('tanggal_aktivitas', '>=', $startDate);
            }])
            ->withSum(['partisipasi as total_orang' => function ($q) use ($startDate) {
                $q->where('status_verifikasi', 'valid')->where('tanggal_aktivitas', '>=', $startDate);
            }], 'jumlah_peserta')
            ->orderByDesc('total_kegiatan')
            ->limit(10)
            ->get();

        // 3. Inorga Terpopuler
        $inorgaStat = Inorga::withCount(['partisipasi as total_kegiatan' => function ($q) use ($startDate) {
                $q->where('status_verifikasi', 'valid')->where('tanggal_aktivitas', '>=', $startDate);
            }])
            ->withSum(['partisipasi as total_orang' => function ($q) use ($startDate) {
                $q->where('status_verifikasi', 'valid')->where('tanggal_aktivitas', '>=', $startDate);
            }], 'jumlah_peserta')
            ->orderByDesc('total_kegiatan')
            ->limit(8)
            ->get();

        return view('livewire.backend.kormi.partisipasi.partisipasi-statistik', [
            'totalAktivitas' => $totalAktivitas,
            'totalPartisipan' => $totalPartisipan,
            'totalDurasiJam' => round($totalDurasiMenit / 60, 1),
            'totalWargaUnik' => $totalWargaUnik,
            'totalDutaAktif' => $totalDutaAktif,
            'kecamatanStat' => $kecamatanStat,
            'inorgaStat' => $inorgaStat,
        ]);
    }
}
