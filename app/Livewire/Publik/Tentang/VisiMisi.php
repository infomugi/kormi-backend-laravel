<?php

namespace App\Livewire\Publik\Tentang;

use Livewire\Component;

class VisiMisi extends Component
{
    public function render()
    {
        $visiRecord = \App\Models\VisiMisiModel::aktif()->jenis('visi')->urut()->first();
        $misiRecords = \App\Models\VisiMisiModel::aktif()->jenis('misi')->urut()->get();

        $visi = $visiRecord?->konten ?? "Mewujudkan masyarakat Kabupaten Bandung yang sehat, bugar, berkarakter, dan berdaya saing melalui pemberdayaan olahraga masyarakat yang inklusif menuju Indonesia Bugar 2045.";

        if ($misiRecords->isNotEmpty()) {
            $colors = ['text-blue-500', 'text-green-500', 'text-purple-500', 'text-orange-500', 'text-teal-500', 'text-red-500'];
            $bgs = ['bg-blue-50', 'bg-green-50', 'bg-purple-50', 'bg-orange-50', 'bg-teal-50', 'bg-red-50'];
            $icons = ['activity', 'trending-up', 'shield-check', 'calendar', 'globe', 'map-pin'];

            $misiList = [];
            foreach ($misiRecords as $idx => $m) {
                $misiList[] = [
                    'title' => 'Misi ' . ($idx + 1),
                    'desc' => $m->konten,
                    'icon' => $m->ikon ?: $icons[$idx % count($icons)],
                    'color' => $colors[$idx % count($colors)],
                    'bg' => $bgs[$idx % count($bgs)],
                ];
            }
        } else {
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
        }

        return view('livewire.publik.tentang.visi-misi', [
            'visi' => $visi,
            'misiList' => $misiList,
        ])->layout('components.layouts.app', ['title' => 'Visi & Misi - KORMI Kabupaten Bandung']);
    }
}
