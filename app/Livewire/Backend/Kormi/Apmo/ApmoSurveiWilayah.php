<?php

namespace App\Livewire\Backend\Kormi\Apmo;

use App\Services\RekapSurveiApmoWilayah;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Monitoring Survei APMO per Wilayah - KORMI CMS')]
class ApmoSurveiWilayah extends Component
{
    #[Url(as: 'tab')]
    public string $tab = 'kecamatan';

    #[Url(as: 'urut')]
    public string $urut = 'nama';

    #[Url(as: 'arah')]
    public string $arah = 'asc';

    public string $cari = '';

    public function mount(): void
    {
        if (! in_array($this->tab, ['kecamatan', 'desa'], true)) {
            $this->tab = 'kecamatan';
        }

        if (! in_array($this->urut, ['nama', 'total'], true)) {
            $this->urut = 'nama';
        }

        if (! in_array($this->arah, ['asc', 'desc'], true)) {
            $this->arah = 'asc';
        }
    }

    public function pilihTab(string $tab): void
    {
        if (in_array($tab, ['kecamatan', 'desa'], true)) {
            $this->tab = $tab;
        }
    }

    public function urutkan(string $kolom): void
    {
        if (! in_array($kolom, ['nama', 'total'], true)) {
            return;
        }

        if ($this->urut === $kolom) {
            $this->arah = $this->arah === 'asc' ? 'desc' : 'asc';
        } else {
            $this->urut = $kolom;
            $this->arah = $kolom === 'total' ? 'desc' : 'asc';
        }
    }

    public function render(RekapSurveiApmoWilayah $rekap)
    {
        $data = $rekap->rekap();
        $semua = $this->tab === 'kecamatan' ? $data['kecamatan'] : $data['desa'];

        return view('livewire.backend.kormi.apmo.apmo-survei-wilayah', [
            'baris' => $rekap->saringDanUrut($semua, $this->cari, $this->urut, $this->arah),
            'ringkasan' => $data['ringkasan'],
        ]);
    }
}
