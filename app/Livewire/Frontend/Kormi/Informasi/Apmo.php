<?php

namespace App\Livewire\Frontend\Kormi\Informasi;

use App\Models\Kormi\ApmoPenerima;
use App\Models\Kormi\ApmoTahun;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Anugerah Prestasi (APMO) - KORMI Kabupaten Bandung')]
class Apmo extends Component
{
    #[Url(as: 'tahun')]
    public int $tahunDipilih = 2025;

    public function filterTahun(int $thn): void
    {
        $this->tahunDipilih = $thn;
    }

    public function render()
    {
        $tahunList = ApmoTahun::orderByDesc('tahun')->get();
        
        if ($tahunList->isNotEmpty() && !in_array($this->tahunDipilih, $tahunList->pluck('tahun')->toArray())) {
            $this->tahunDipilih = $tahunList->first()->tahun;
        }

        $tahunAktif = $tahunList->firstWhere('tahun', $this->tahunDipilih);

        $penerimaList = ApmoPenerima::whereHas('tahun', fn($q) => $q->where('tahun', $this->tahunDipilih))
            ->orderBy('urutan')
            ->get();

        return view('livewire.frontend.kormi.informasi.apmo', [
            'tahunList' => $tahunList,
            'tahunAktif' => $tahunAktif,
            'penerimaList' => $penerimaList,
        ])->layout('components.layouts.app');
    }
}


