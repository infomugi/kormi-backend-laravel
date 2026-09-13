<?php

namespace App\Livewire\Frontend\Kormi\Inorga;

use Livewire\Component;
use App\Models\Kormi\KomisiInorga;
use App\Models\Kormi\Inorga;

class InorgaIndex extends Component
{
    public string $komisiDipilih = 'Semua';
    public string $cari = '';

    public function render()
    {
        $komisiList = KomisiInorga::withCount('inorga')->get();

        $inorgaList = Inorga::with('komisi')
            ->when($this->komisiDipilih !== 'Semua', function ($q) {
                $q->whereHas('komisi', fn($k) => $k->where('singkatan', $this->komisiDipilih));
            })
            ->when($this->cari !== '', function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nama_inorga', 'like', '%' . $this->cari . '%')
                        ->orWhere('singkatan', 'like', '%' . $this->cari . '%');
                });
            })
            ->orderBy('singkatan')
            ->get();

        return view('livewire.frontend.kormi.inorga.inorga-index', [
            'komisiList' => $komisiList,
            'inorgaList' => $inorgaList,
        ])->layout('components.layouts.app', ['title' => 'Induk Organisasi (Inorga) - KORMI Kabupaten Bandung']);
    }
}
