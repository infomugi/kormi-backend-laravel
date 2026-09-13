<?php

namespace App\Livewire\Frontend\Kormi\Partisipasi;

use App\Models\Kormi\PartisipasiAktivitas;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.frontend')]
#[Title('Riwayat & Statistik Aktivitas Olahraga Saya - KORMI')]
class PartisipasiRiwayat extends Component
{
    use WithPagination;

    public string $cari = '';
    public string $filterMetode = 'semua'; // 'semua', 'mandiri', 'via_duta'

    public function updatingCari(): void
    {
        $this->resetPage();
    }

    public function updatingFilterMetode(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = auth()->id();

        $query = PartisipasiAktivitas::with(['inorga', 'kecamatan', 'desa'])
            ->where('pengguna_id', $userId)
            ->when($this->filterMetode !== 'semua', fn($q) => $q->where('metode_pencatatan', $this->filterMetode))
            ->when($this->cari, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nama_aktivitas', 'like', '%' . $this->cari . '%')
                        ->orWhere('nama_tempat', 'like', '%' . $this->cari . '%')
                        ->orWhere('catatan', 'like', '%' . $this->cari . '%');
                });
            })
            ->orderByDesc('tanggal_aktivitas');

        $riwayatList = $query->paginate(10);

        // Perhitungan Statistik Pribadi
        $totalSesi = PartisipasiAktivitas::where('pengguna_id', $userId)->count();
        $totalMenit = PartisipasiAktivitas::where('pengguna_id', $userId)->sum('durasi_menit');
        $totalPartisipan = PartisipasiAktivitas::where('pengguna_id', $userId)->sum('jumlah_peserta');

        // Sesi dalam 30 hari terakhir (Standar APMO)
        $sesiBulanIni = PartisipasiAktivitas::where('pengguna_id', $userId)
            ->where('tanggal_aktivitas', '>=', now()->subDays(30)->toDateString())
            ->count();

        // Level Badge
        $badgeLevel = 'Pemula';
        $badgeColor = 'neutral';
        if ($sesiBulanIni >= 12) {
            $badgeLevel = 'Pegiat Emas (Aktif Sempurna)';
            $badgeColor = 'amber';
        } elseif ($sesiBulanIni >= 6) {
            $badgeLevel = 'Pegiat Perak (Rutin)';
            $badgeColor = 'emerald';
        } elseif ($sesiBulanIni >= 1) {
            $badgeLevel = 'Pegiat Perunggu';
            $badgeColor = 'sky';
        }

        return view('livewire.frontend.kormi.partisipasi.partisipasi-riwayat', [
            'riwayatList' => $riwayatList,
            'totalSesi' => $totalSesi,
            'totalJam' => round($totalMenit / 60, 1),
            'totalPartisipan' => $totalPartisipan,
            'sesiBulanIni' => $sesiBulanIni,
            'badgeLevel' => $badgeLevel,
            'badgeColor' => $badgeColor,
        ]);
    }
}
