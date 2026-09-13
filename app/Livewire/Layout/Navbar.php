<?php

namespace App\Livewire\Layout;

use App\Models\Core\Menu;
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
        $dynamicMenus = Menu::grup('frontend_header')
            ->aktif()
            ->utama()
            ->with(['anak' => fn($q) => $q->aktif()->orderBy('urutan', 'asc')])
            ->orderBy('urutan', 'asc')
            ->get();

        if ($dynamicMenus->isNotEmpty()) {
            $menuItems = $dynamicMenus->map(function ($menu) {
                $item = [
                    'name' => $menu->nama,
                    'link' => $this->formatTautan($menu->tautan),
                    'icon' => $menu->icon,
                    'badge' => $menu->badge,
                    'external' => $menu->target === '_blank' || str_starts_with($menu->tautan, 'http'),
                ];

                if ($menu->anak && $menu->anak->isNotEmpty()) {
                    $item['sub'] = $menu->anak->map(function ($sub) {
                        return [
                            'name' => $sub->nama,
                            'link' => $this->formatTautan($sub->tautan),
                            'icon' => $sub->icon,
                            'badge' => $sub->badge,
                            'external' => $sub->target === '_blank' || str_starts_with($sub->tautan, 'http'),
                        ];
                    })->toArray();
                }

                return $item;
            })->toArray();
        } else {
            // Fallback default
            $menuItems = [
                ['name' => 'Beranda', 'link' => route('beranda'), 'external' => false],
                ['name' => 'Profil', 'sub' => [
                    ['name' => 'Sejarah KORMI', 'link' => route('sejarah'), 'external' => false],
                    ['name' => 'Visi & Misi', 'link' => route('visimisi'), 'external' => false],
                    ['name' => 'Struktur Pengurus', 'link' => route('pengurus'), 'external' => false],
                    ['name' => 'KORCAM (Koordinator Kecamatan)', 'link' => route('kordikecamatan'), 'external' => false],
                    ['name' => 'Program Kerja', 'link' => route('proker'), 'external' => false],
                ]],
                ['name' => 'Keolahragaan', 'sub' => [
                    ['name' => 'Direktori Inorga (Induk Olahraga)', 'link' => route('inorga'), 'external' => false],
                    ['name' => 'Duta Olahraga Masyarakat', 'link' => route('dutaolahraga'), 'external' => false],
                    ['name' => 'Pelatihan & Sertifikasi SDI', 'link' => route('sdi'), 'external' => false],
                    ['name' => 'Sarana & Prasarana (Sapras)', 'link' => route('sapras'), 'external' => false],
                ]],
                ['name' => 'Partisipasi Warga', 'sub' => [
                    ['name' => 'Catat Aktivitas Olahraga', 'link' => route('partisipasi.catat'), 'external' => false],
                    ['name' => 'Riwayat & Badge APMO Saya', 'link' => route('partisipasi.riwayat'), 'external' => false],
                    ['name' => 'Tentang APMO & Indeks Partisipasi', 'link' => route('apmo'), 'external' => false],
                ]],
                ['name' => 'Event', 'sub' => [
                    ['name' => 'FORKAB (Festival Olahraga Kab. Bandung)', 'link' => route('forkab'), 'external' => false],
                    ['name' => 'FOTRADKAB (Olahraga Tradisional)', 'link' => route('fotradkab'), 'external' => false],
                    ['name' => 'Bandung Bedas Run', 'link' => 'https://bandungbedasrun.kormibdg.id', 'external' => true],
                ]],
                ['name' => 'Media & Publikasi', 'sub' => [
                    ['name' => 'Berita & Warta Olahraga', 'link' => route('berita'), 'external' => false],
                    ['name' => 'Galeri Foto & Dokumentasi', 'link' => route('galeri'), 'external' => false],
                    ['name' => 'Pusat Unduhan & Dokumen', 'link' => route('unduhan'), 'external' => false],
                ]],
                ['name' => 'Kontak', 'link' => route('kontak'), 'external' => false]
            ];
        }

        return view('livewire.layout.navbar', ['menuItems' => $menuItems]);
    }

    private function formatTautan(string $tautan): string
    {
        if (empty($tautan) || $tautan === '#') {
            return '#';
        }

        if (str_starts_with($tautan, 'http://') || str_starts_with($tautan, 'https://') || str_starts_with($tautan, '//')) {
            return $tautan;
        }

        if (str_starts_with($tautan, '/')) {
            return url($tautan);
        }

        if (\Illuminate\Support\Facades\Route::has($tautan)) {
            return route($tautan);
        }

        return url($tautan);
    }
}
