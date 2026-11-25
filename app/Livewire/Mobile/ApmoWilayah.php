<?php

namespace App\Livewire\Mobile;

use App\Services\RekapSurveiApmoWilayah;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.mobile')]
#[Title('Monitoring Survei APMO - KORMI Kabupaten Bandung')]
class ApmoWilayah extends Component
{
    #[Url(as: 'tab')]
    public string $tab = 'kecamatan';

    #[Url(as: 'urut')]
    public string $urut = 'nama';

    #[Url(as: 'arah')]
    public string $arah = 'asc';

    public string $cari = '';

    public int $batas = 40;

    public function mount(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403);

        if (! in_array($this->tab, ['kecamatan', 'desa'], true)) {
            $this->tab = 'kecamatan';
        }

        if (! in_array($this->urut, ['nama', 'total'], true)) {
            $this->urut = 'nama';
        }

        $this->arah = $this->arah === 'desc' ? 'desc' : 'asc';
    }

    public function pilihTab(string $tab): void
    {
        if (! in_array($tab, ['kecamatan', 'desa'], true)) {
            return;
        }

        $this->tab = $tab;
        $this->batas = 40;
        $this->resetValidation();
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

        $this->batas = 40;
    }

    public function updatedCari(): void
    {
        $this->batas = 40;
    }

    public function muatLagi(): void
    {
        $this->batas += 40;
    }

    public function render(RekapSurveiApmoWilayah $rekap)
    {
        $data = $rekap->rekap();
        $semua = $this->tab === 'kecamatan' ? $data['kecamatan'] : $data['desa'];
        $baris = $rekap->saringDanUrut($semua, $this->cari, $this->urut, $this->arah);

        return view('livewire.mobile.apmo-wilayah', [
            'ringkasan' => $data['ringkasan'],
            'baris' => array_slice($baris, 0, $this->batas),
            'totalBaris' => count($baris),
        ]);
    }
}
