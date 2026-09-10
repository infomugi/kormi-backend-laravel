<?php

namespace App\Livewire\Publik\Tentang;

use Livewire\Component;

class VisiMisi extends Component
{
    public function render()
    {
        $visi = "Mewujudkan masyarakat Kabupaten Bandung yang sehat, bugar, berkarakter, dan berdaya saing melalui pemberdayaan olahraga masyarakat yang inklusif menuju Indonesia Bugar 2045.";

        $misiList = [
            [
                'title' => 'Pengembangan Olahraga Masyarakat',
                'desc' => 'Mendorong dan memfasilitasi berbagai jenis olahraga yang mudah diakses oleh seluruh lapisan masyarakat.',
                'icon' => 'activity',
                'color' => 'text-blue-500',
                'bg' => 'bg-blue-50'
            ],
            [
                'title' => 'Peningkatan Angka Partisipasi',
                'desc' => 'Melaksanakan program edukasi dan sosialisasi untuk menumbuhkan kesadaran gaya hidup aktif dan bugar.',
                'icon' => 'trending-up',
                'color' => 'text-green-500',
                'bg' => 'bg-green-50'
            ],
            [
                'title' => 'Pembinaan INORGA yang Komprehensif',
                'desc' => 'Memperkuat kapasitas kelembagaan dan kompetensi SDM induk-induk organisasi olahraga.',
                'icon' => 'shield-check',
                'color' => 'text-purple-500',
                'bg' => 'bg-purple-50'
            ],
            [
                'title' => 'Pelaksanaan Festival Olahraga',
                'desc' => 'Menyelenggarakan FORKAB dan FOTRADKAB secara rutin sebagai ajang silaturahmi dan unjuk kemampuan.',
                'icon' => 'calendar',
                'color' => 'text-orange-500',
                'bg' => 'bg-orange-50'
            ],
            [
                'title' => 'Pemasalan ke Tingkat Desa',
                'desc' => 'Memastikan kegiatan olahraga menjangkau seluruh 280 desa dan kelurahan di 31 kecamatan.',
                'icon' => 'globe',
                'color' => 'text-teal-500',
                'bg' => 'bg-teal-50'
            ],
            [
                'title' => 'Pengembangan Sport Tourism',
                'desc' => 'Mengintegrasikan olahraga masyarakat dengan promosi pariwisata alam Kabupaten Bandung.',
                'icon' => 'map-pin',
                'color' => 'text-red-500',
                'bg' => 'bg-red-50'
            ]
        ];

        return view('livewire.publik.tentang.visi-misi', [
            'visi' => $visi,
            'misiList' => $misiList,
        ])->layout('components.layouts.app', ['title' => 'Visi & Misi - KORMI Kabupaten Bandung']);
    }
}
