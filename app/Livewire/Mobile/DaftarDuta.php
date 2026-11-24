<?php

namespace App\Livewire\Mobile;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.mobile')]
#[Title('Pendaftaran Duta Olahraga - KORMI Kabupaten Bandung')]
class DaftarDuta extends \App\Livewire\Frontend\Kormi\Tentang\DutaOlahragaDaftar
{
    public function render()
    {
        return view('livewire.mobile.daftar-duta', $this->dataTampilan());
    }
}
