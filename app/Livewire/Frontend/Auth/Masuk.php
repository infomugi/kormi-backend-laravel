<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.guest')]
#[Title('Masuk - KORMI Kabupaten Bandung')]
class Masuk extends \App\Livewire\Backend\Auth\Masuk
{
    public function render()
    {
        return view('livewire.frontend.auth.masuk');
    }
}
