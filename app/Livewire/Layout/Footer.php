<?php

namespace App\Livewire\Layout;

use App\Models\Core\Menu;
use App\Models\Core\PengaturanSitus;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        $settings = PengaturanSitus::pluck('nilai_pengaturan', 'kunci_pengaturan')->toArray();

        $dynamicFooterMenus = Menu::grup('frontend_footer')
            ->aktif()
            ->orderBy('urutan', 'asc')
            ->get();

        if ($dynamicFooterMenus->isNotEmpty()) {
            $footerLinks = $dynamicFooterMenus->map(function ($menu) {
                return [
                    'nama' => $menu->nama,
                    'tautan' => $this->formatTautan($menu->tautan),
                    'target' => $menu->target ?? '_self',
                    'external' => $menu->target === '_blank' || str_starts_with($menu->tautan, 'http'),
                ];
            })->toArray();
        } else {
            $footerLinks = [
                ['nama' => 'Visi & Misi', 'tautan' => route('visimisi'), 'target' => '_self', 'external' => false],
                ['nama' => 'Struktur Pengurus', 'tautan' => route('pengurus'), 'target' => '_self', 'external' => false],
                ['nama' => 'Direktori Inorga', 'tautan' => route('inorga'), 'target' => '_self', 'external' => false],
                ['nama' => 'KORCAM Kecamatan', 'tautan' => route('kordikecamatan'), 'target' => '_self', 'external' => false],
                ['nama' => 'Pusat Unduhan', 'tautan' => route('unduhan'), 'target' => '_self', 'external' => false],
            ];
        }

        return view('livewire.layout.footer', [
            'footerLinks' => $footerLinks,
            'alamatKantor' => $settings['kontak_alamat'] ?? 'Komplek Stadion Si Jalak Harupat, Soreang, Kutawaringin, Kab. Bandung',
            'teleponKantor' => $settings['kontak_telepon'] ?? '(022) 123 456 7890',
            'emailKantor' => $settings['kontak_email'] ?? 'sekretariat@kormibdg.id',
            'deskripsiSitus' => $settings['situs_deskripsi'] ?? 'Mewujudkan masyarakat Kabupaten Bandung yang sehat, bugar, dan berkarakter melalui pemberdayaan olahraga masyarakat secara inklusif.',
            'instagram' => $settings['sosmed_instagram'] ?? 'https://instagram.com/kormikabupatenbandung',
            'facebook' => $settings['sosmed_facebook'] ?? 'https://facebook.com/kormikabupatenbandung',
            'youtube' => $settings['sosmed_youtube'] ?? 'https://youtube.com/@kormikabupatenbandung',
        ]);
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
