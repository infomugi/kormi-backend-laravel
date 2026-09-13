<?php

namespace App\Livewire\Frontend\Kormi\Tentang;

use App\Models\Kormi\ProgramKerja;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Program Kerja Strategis - KORMI Kabupaten Bandung')]
class Proker extends Component
{
    #[Url(as: 'bidang')]
    public string $bidangDipilih = 'Semua';

    public function filterBidang(string $bidang): void
    {
        $this->bidangDipilih = $bidang;
    }

    public function render()
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $query = ProgramKerja::query();

        if ($this->bidangDipilih !== 'Semua') {
            $query->where('nama_bidang', 'like', "%{$this->bidangDipilih}%");
        }

        $dbProker = $query->orderBy('bulan_mulai')->get();

        $prokerList = $dbProker->map(function ($item) use ($namaBulan) {
            $periode = '-';
            if ($item->bulan_mulai && $item->bulan_selesai) {
                $periode = $item->bulan_mulai === $item->bulan_selesai 
                    ? $namaBulan[$item->bulan_mulai] ?? "Bulan {$item->bulan_mulai}"
                    : ($namaBulan[$item->bulan_mulai] ?? "Bulan {$item->bulan_mulai}") . ' - ' . ($namaBulan[$item->bulan_selesai] ?? "Bulan {$item->bulan_selesai}");
            }

            return [
                'id' => $item->id,
                'judul' => $item->nama_kegiatan,
                'bidang' => $item->nama_bidang,
                'status' => $item->status_kegiatan ?: 'Rencana',
                'deskripsi' => $item->tujuan_kegiatan ?? $item->target_sasaran ?? 'Program kerja bidang ' . $item->nama_bidang,
                'target' => $item->target_sasaran ?? 'Pegiat & Masyarakat',
                'periode' => $periode,
                'tahun' => $item->tahun_anggaran ?? 2026,
                'icon' => $item->ikon ?: 'activity',
            ];
        });

        return view('livewire.frontend.kormi.tentang.proker', [
            'prokerList' => $prokerList,
        ])->layout('components.layouts.app');
    }
}

