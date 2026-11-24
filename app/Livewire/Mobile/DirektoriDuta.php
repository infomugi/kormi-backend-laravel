<?php

namespace App\Livewire\Mobile;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.mobile')]
#[Title('Direktori Duta Olahraga - KORMI Kabupaten Bandung')]
class DirektoriDuta extends \App\Livewire\Frontend\Kormi\Tentang\DutaOlahragaIndex
{
    public function render()
    {
        return view('livewire.mobile.direktori-duta', $this->dataTampilan());
    }
}
