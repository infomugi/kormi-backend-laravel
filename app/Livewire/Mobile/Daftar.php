<?php

namespace App\Livewire\Mobile;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.mobile')]
#[Title('Daftar Akun - KORMI Kabupaten Bandung')]
class Daftar extends \App\Livewire\Backend\Auth\Daftar
{
    public function render()
    {
        return view('livewire.mobile.daftar');
    }

    protected function tujuanSetelahDaftar(): string
    {
        return route('mobile.login');
    }
}
