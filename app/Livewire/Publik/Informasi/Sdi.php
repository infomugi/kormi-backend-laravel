<?php

namespace App\Livewire\Publik\Informasi;

use App\Models\SdiJadwal;
use App\Models\SdiProgram;
use Livewire\Component;

class Sdi extends Component
{
    public function render()
    {
        $programList = SdiProgram::where('status_aktif', true)->get();
        $jadwalList = SdiJadwal::with('program')->orderBy('tanggal_mulai')->get();

        return view('livewire.publik.informasi.sdi', [
            'programList' => $programList,
            'jadwalList' => $jadwalList,
        ])->layout('components.layouts.app', ['title' => 'Sumber Daya Insani (SDI) - KORMI Kabupaten Bandung']);
    }
}

