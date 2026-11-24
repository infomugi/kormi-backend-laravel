<?php

namespace App\Livewire\Mobile;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.mobile')]
#[Title('Berita - KORMI Kabupaten Bandung')]
class Berita extends \App\Livewire\Frontend\Media\BeritaIndex
{
    public function render()
    {
        return view('livewire.mobile.berita', $this->dataTampilan());
    }
}
