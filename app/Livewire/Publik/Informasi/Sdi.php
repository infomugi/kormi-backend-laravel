<?php

namespace App\Livewire\Publik\Informasi;

use App\Models\SdiJadwal;
use App\Models\SdiProgram;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Sumber Daya Insani (SDI) - KORMI Kabupaten Bandung')]
class Sdi extends Component
{
    #[Url(as: 'status')]
    public string $statusFilter = 'Semua';

    public function filterStatus(string $status): void
    {
        $this->statusFilter = $status;
    }

    public function render()
    {
        $programList = SdiProgram::where('status_aktif', true)->withCount('jadwal')->get();

        $query = SdiJadwal::with('program')->orderBy('tanggal_mulai', 'asc');

        if ($this->statusFilter !== 'Semua') {
            $query->where('status_pendaftaran', $this->statusFilter);
        }

        $jadwalList = $query->get();

        return view('livewire.publik.informasi.sdi', [
            'programList' => $programList,
            'jadwalList' => $jadwalList,
        ])->layout('components.layouts.app');
    }
}


