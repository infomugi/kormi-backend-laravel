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
            
            // 1. Profil & Kelembagaan
            ['name' => 'Profil', 'sub' => [
                ['name' => 'Sejarah KORMI', 'link' => route('sejarah'), 'external' => false],
                ['name' => 'Visi & Misi', 'link' => route('visimisi'), 'external' => false],
                ['name' => 'Struktur Pengurus', 'link' => route('pengurus'), 'external' => false],
                ['name' => 'KORCAM (Koordinator Kecamatan)', 'link' => route('kordikecamatan'), 'external' => false],
                ['name' => 'Program Kerja', 'link' => route('proker'), 'external' => false],
            ]],

            // 2. Keolahragaan & Inorga
            ['name' => 'Keolahragaan', 'sub' => [
                ['name' => 'Direktori Inorga (Induk Olahraga)', 'link' => route('inorga'), 'external' => false],
                ['name' => 'Duta Olahraga Masyarakat', 'link' => route('dutaolahraga'), 'external' => false],
                ['name' => 'Pelatihan & Sertifikasi SDI', 'link' => route('sdi'), 'external' => false],
                ['name' => 'Sarana & Prasarana (Sapras)', 'link' => route('sapras'), 'external' => false],
            ]],

            // 3. Partisipasi Olahraga Masyarakat (APMO)
            ['name' => 'Partisipasi Warga', 'sub' => [
                ['name' => 'Catat Aktivitas Olahraga', 'link' => route('partisipasi.catat'), 'external' => false],
                ['name' => 'Riwayat & Badge APMO Saya', 'link' => route('partisipasi.riwayat'), 'external' => false],
                ['name' => 'Tentang APMO & Indeks Partisipasi', 'link' => route('apmo'), 'external' => false],
            ]],

            // 4. Event & Agenda
            ['name' => 'Event', 'sub' => [
                ['name' => 'FORKAB (Festival Olahraga Kab. Bandung)', 'link' => route('forkab'), 'external' => false],
                ['name' => 'FOTRADKAB (Olahraga Tradisional)', 'link' => route('fotradkab'), 'external' => false],
                ['name' => 'Bandung Bedas Run', 'link' => 'https://bandungbedasrun.kormibdg.id', 'external' => true],
            ]],

            // 5. Media & Informasi Publik
            ['name' => 'Media & Publikasi', 'sub' => [
                ['name' => 'Berita & Warta Olahraga', 'link' => route('berita'), 'external' => false],
                ['name' => 'Galeri Foto & Dokumentasi', 'link' => route('galeri'), 'external' => false],
                ['name' => 'Pusat Unduhan & Dokumen', 'link' => route('unduhan'), 'external' => false],
            ]],

            // 6. Kontak
            ['name' => 'Kontak', 'link' => route('kontak'), 'external' => false]
        ];

        return view('livewire.layout.navbar', ['menuItems' => $menuItems]);
    }
}
