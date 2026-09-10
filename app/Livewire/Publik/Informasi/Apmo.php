<?php

namespace App\Livewire\Publik\Informasi;

use App\Models\ApmoPenerima;
use App\Models\ApmoTahun;
use Livewire\Component;

class Apmo extends Component
{
    public int $tahunDipilih = 2025;

    public function render()
    {
        $tahunList = ApmoTahun::orderByDesc('tahun')->pluck('tahun')->toArray();
        if (empty($tahunList)) {
            $tahunList = [2025, 2024];
        }

        $penerimaList = ApmoPenerima::whereHas('tahun', fn($q) => $q->where('tahun', $this->tahunDipilih))
            ->orderBy('urutan')
            ->get();

        return view('livewire.publik.informasi.apmo', [
            'tahunList' => $tahunList,
            'penerimaList' => $penerimaList,
        ])->layout('components.layouts.app', ['title' => 'Anugerah Prestasi (APMO) - KORMI Kabupaten Bandung']);
    }
}

