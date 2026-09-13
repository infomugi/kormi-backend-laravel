<?php

namespace App\Livewire\Frontend\Kormi\Tentang;

use App\Models\Kormi\VisiMisiModel;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Visi & Misi - KORMI Kabupaten Bandung')]
class VisiMisi extends Component
{
    public function render()
    {
        $visiRecord = VisiMisiModel::tampil()->jenis('visi')->urut()->first();
        $misiRecords = VisiMisiModel::tampil()->jenis('misi')->urut()->get();

        $visi = $visiRecord?->konten ?? "Mewujudkan masyarakat Kabupaten Bandung yang sehat, bugar, berkarakter, dan berdaya saing melalui pemberdayaan olahraga masyarakat yang inklusif menuju Indonesia Bugar 2045.";

        $icons = ['activity', 'trending-up', 'shield-check', 'calendar', 'globe', 'map-pin'];

        if ($misiRecords->isNotEmpty()) {
            $misiList = [];
            foreach ($misiRecords as $idx => $m) {
                $misiList[] = [
                    'number' => sprintf('%02d', $idx + 1),
                    'desc'   => $m->konten,
                    'icon'   => $m->ikon ?: ($icons[$idx % count($icons)] ?? 'check-circle'),
                ];
            }
        } else {
            $defaultMisi = [
                'Mendorong dan memfasilitasi berbagai jenis olahraga rekreasi yang mudah diakses dan menyenangkan oleh seluruh lapisan masyarakat.',
                'Melaksanakan program edukasi dan sosialisasi masif untuk menumbuhkan kesadaran gaya hidup aktif, sehat, dan bugar.',
                'Memperkuat kapasitas kelembagaan, pembinaan, dan kompetensi SDM seluruh Induk Organisasi Olahraga (INORGA).',
                'Menyelenggarakan ajang festival olahraga (FORKAB & FOTRADKAB) secara rutin dan profesional sebagai wadah kebersamaan.',
                'Memastikan pemasalan dan pemerataan aktivitas olahraga menjangkau seluruh 280 desa dan kelurahan di 31 kecamatan.',
                'Mengintegrasikan olahraga masyarakat dengan ekosistem sport tourism dan pelestarian budaya lokal Kabupaten Bandung.',
            ];

            $misiList = [];
            foreach ($defaultMisi as $idx => $mText) {
                $misiList[] = [
                    'number' => sprintf('%02d', $idx + 1),
                    'desc'   => $mText,
                    'icon'   => $icons[$idx % count($icons)] ?? 'check-circle',
                ];
            }
        }

        return view('livewire.frontend.kormi.tentang.visi-misi', [
            'visi' => $visi,
            'misiList' => $misiList,
        ])->layout('components.layouts.app');
    }
}

