<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class Navbar extends Component
{
    public bool $isMenuOpen = false;

    public function toggleMenu()
    {
        $this->isMenuOpen = !$this->isMenuOpen;
    }

    public function render()
    {
        $menuItems = [
            ['name' => 'Beranda', 'link' => route('beranda'), 'external' => false],
            ['name' => 'Tentang Kami', 'sub' => [
                ['name' => 'Sejarah', 'link' => route('sejarah'), 'external' => false],
                ['name' => 'Visi Misi', 'link' => route('visimisi'), 'external' => false],
                ['name' => 'Pengurus Kormi', 'link' => route('pengurus'), 'external' => false],
                ['name' => 'Koordinator Kecamatan', 'link' => route('kordikecamatan'), 'external' => false],
                ['name' => 'Duta Olahraga', 'link' => route('dutaolahraga'), 'external' => false],
                ['name' => 'Program Kerja', 'link' => route('proker'), 'external' => false]
            ]],
            ['name' => 'Informasi', 'sub' => [
                ['name' => 'Inorga', 'link' => route('inorga'), 'external' => false],
                ['name' => 'Fotradkab', 'link' => route('fotradkab'), 'external' => false],
                ['name' => 'Forkab', 'link' => route('forkab'), 'external' => false],
                ['name' => 'Bandung Bedas Run', 'link' => 'https://bandungbedasrun.kormibdg.id', 'external' => true],
                ['name' => 'Apmo', 'link' => route('apmo'), 'external' => false],
                ['name' => 'Sdi', 'link' => route('sdi'), 'external' => false],
                ['name' => 'Sapras', 'link' => route('sapras'), 'external' => false]
            ]],
            ['name' => 'Media', 'sub' => [
                ['name' => 'Berita & Artikel', 'link' => route('berita'), 'external' => false],
                ['name' => 'Galeri', 'link' => route('galeri'), 'external' => false]
            ]],
            ['name' => 'Unduhan', 'link' => route('unduhan'), 'external' => false],
            ['name' => 'Hubungi Kami', 'link' => route('kontak'), 'external' => false]
        ];

        return view('livewire.layout.navbar', ['menuItems' => $menuItems]);
    }
}
