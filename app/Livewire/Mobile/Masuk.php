<?php

namespace App\Livewire\Mobile;

use App\Models\Core\Pengguna;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.mobile')]
#[Title('Masuk - KORMI Kabupaten Bandung')]
class Masuk extends \App\Livewire\Backend\Auth\Masuk
{
    public function render()
    {
        return view('livewire.mobile.login');
    }

    protected function tujuanSetelahMasuk(Pengguna $user): string
    {
        if ($user->isDutaOlahraga()
            || $user->isPegiatOlahraga()
            || $user->hasRole('super-admin', 'admin-korcam', 'admin-inorga', 'editor-berita')) {
            return route('mobile.dashboard');
        }

        return parent::tujuanSetelahMasuk($user);
    }
}
