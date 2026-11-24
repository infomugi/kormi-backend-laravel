<?php

namespace App\Livewire\Mobile;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.mobile')]
#[Title('Berita - KORMI Kabupaten Bandung')]
class BeritaDetail extends \App\Livewire\Frontend\Media\BeritaDetail
{
    public function render()
    {
        return view('livewire.mobile.berita-detail', $this->dataTampilan());
    }
}
