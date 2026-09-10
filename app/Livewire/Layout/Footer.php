<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        $settings = \App\Models\PengaturanSitus::pluck('nilai_pengaturan', 'kunci_pengaturan')->toArray();

        return view('livewire.layout.footer', [
            'alamatKantor' => $settings['kontak_alamat'] ?? 'Komplek Stadion Si Jalak Harupat, Soreang, Kutawaringin, Kab. Bandung',
            'teleponKantor' => $settings['kontak_telepon'] ?? '(022) 123 456 7890',
            'emailKantor' => $settings['kontak_email'] ?? 'sekretariat@kormibdg.id',
            'deskripsiSitus' => $settings['situs_deskripsi'] ?? 'Mewujudkan masyarakat Kabupaten Bandung yang sehat, bugar, dan berkarakter melalui pemberdayaan olahraga masyarakat secara inklusif.',
            'instagram' => $settings['sosmed_instagram'] ?? 'https://instagram.com/kormikabupatenbandung',
            'facebook' => $settings['sosmed_facebook'] ?? 'https://facebook.com/kormikabupatenbandung',
            'youtube' => $settings['sosmed_youtube'] ?? 'https://youtube.com/@kormikabupatenbandung',
        ]);
    }
}
