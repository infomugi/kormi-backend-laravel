<?php

namespace App\Livewire\Mobile;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.mobile')]
#[Title('Beranda - KORMI Kabupaten Bandung')]
class Beranda extends \App\Livewire\Frontend\Beranda
{
    public function render()
    {
        return view('livewire.mobile.beranda', $this->dataTampilan());
    }
}
