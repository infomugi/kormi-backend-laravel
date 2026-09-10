<?php

namespace App\Livewire\Publik\Informasi;

use App\Models\Sapras as SaprasModel;
use Livewire\Component;

class Sapras extends Component
{
    public string $jenisDipilih = 'Semua';

    public function render()
    {
        $query = SaprasModel::with('kecamatan');

        if ($this->jenisDipilih !== 'Semua') {
            $query->where('kategori_fasilitas', $this->jenisDipilih);
        }

        $fasilitasData = $query->get();

        return view('livewire.publik.informasi.sapras', [
            'fasilitasData' => $fasilitasData,
        ])->layout('components.layouts.app', ['title' => 'Sarana & Prasarana - KORMI Kabupaten Bandung']);
    }
}

