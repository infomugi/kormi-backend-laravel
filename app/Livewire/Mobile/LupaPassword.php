<?php

namespace App\Livewire\Mobile;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.mobile')]
#[Title('Lupa Kata Sandi - KORMI Kabupaten Bandung')]
class LupaPassword extends \App\Livewire\Backend\Auth\LupaPassword
{
    public function render()
    {
        return view('livewire.mobile.lupa-password');
    }
}
