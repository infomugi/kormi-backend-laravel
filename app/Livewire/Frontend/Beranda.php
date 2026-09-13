<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Kormi\Inorga;
use App\Models\Kormi\KomisiInorga;
use App\Models\Content\Unduhan;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Kormi\Event;
use App\Models\Content\Berita;
use App\Models\Content\GaleriFoto;
use App\Models\Master\Kecamatan;
use App\Models\Kormi\Sapras;

class Beranda extends Component
{
    public function render()
    {
        $kegiatanGrid = [
            [
                'name' => 'INORGA',
                'badge' => 'Kelembagaan',
                'desc' => 'Direktori & database seluruh induk organisasi olahraga rekreasi yang bernaung di KORMI.',
                'icon' => 'award',
                'bg_gradient' => 'from-emerald-500 to-teal-600',
                'text_color' => 'text-emerald-600',
                'bg_light' => 'bg-emerald-50/80',
                'border_color' => 'group-hover:border-emerald-500/50',
                'link' => route('inorga'),
                'external' => false
            ],
            [
                'name' => 'FOTRADKAB',
                'badge' => 'Festival Tradisional',
                'desc' => 'Festival olahraga tradisional & permainan rakyat nusantara tingkat Kabupaten Bandung.',
                'icon' => 'flag',
                'bg_gradient' => 'from-blue-500 to-indigo-600',
                'text_color' => 'text-blue-600',
                'bg_light' => 'bg-blue-50/80',
                'border_color' => 'group-hover:border-blue-500/50',
                'link' => route('fotradkab'),
                'external' => false
            ],
            [
                'name' => 'FORKAB',
                'badge' => 'Multi-Event',
                'desc' => 'Pekan festival olahraga rekreasi masyarakat antar-kontingen 31 kecamatan se-Kabupaten.',
                'icon' => 'trophy',
                'bg_gradient' => 'from-amber-500 to-orange-600',
                'text_color' => 'text-amber-600',
                'bg_light' => 'bg-amber-50/80',
                'border_color' => 'group-hover:border-amber-500/50',
                'link' => route('forkab'),
                'external' => false
            ],
            [
                'name' => 'BEDAS RUN',
                'badge' => 'Flagship Event',
                'desc' => 'Ajang lari massal tahunan ikonik menjangkau keindahan alam & destinasi Kabupaten Bandung.',
                'icon' => 'zap',
                'bg_gradient' => 'from-rose-500 to-red-600',
                'text_color' => 'text-rose-600',
                'bg_light' => 'bg-rose-50/80',
                'border_color' => 'group-hover:border-rose-500/50',
                'link' => 'https://bandungbedasrun.kormibdg.id',
                'external' => true
            ],
            [
                'name' => 'APMO',
                'badge' => 'Apresiasi & Tokoh',
                'desc' => 'Anugerah Penggerak Olahraga Masyarakat bagi tokoh & komunitas yang berjasa membina warga.',
                'icon' => 'medal',
                'bg_gradient' => 'from-purple-500 to-fuchsia-600',
                'text_color' => 'text-purple-600',
                'bg_light' => 'bg-purple-50/80',
                'border_color' => 'group-hover:border-purple-500/50',
                'link' => route('apmo'),
                'external' => false
            ],
            [
                'name' => 'SDI',
                'badge' => 'Data Statistik',
                'desc' => 'Sport Development Index: instrumen pengukur tingkat kebugaran & partisipasi olahraga masyarakat.',
                'icon' => 'trending-up',
                'bg_gradient' => 'from-cyan-500 to-blue-600',
                'text_color' => 'text-cyan-600',
                'bg_light' => 'bg-cyan-50/80',
                'border_color' => 'group-hover:border-cyan-500/50',
                'link' => route('sdi'),
                'external' => false
            ],
            [
                'name' => 'SAPRAS',
                'badge' => 'Infrastruktur',
                'desc' => 'Peta sebaran sarana, prasarana, gelanggang, dan fasilitas olahraga publik di 31 kecamatan.',
                'icon' => 'map-pin',
                'bg_gradient' => 'from-indigo-500 to-purple-600',
                'text_color' => 'text-indigo-600',
                'bg_light' => 'bg-indigo-50/80',
                'border_color' => 'group-hover:border-indigo-500/50',
                'link' => route('sapras'),
                'external' => false
            ],
            [
                'name' => 'UNDUHAN',
                'badge' => 'Regulasi & Dokumen',
                'desc' => 'Pusat unduhan SK kelembagaan, regulasi AD/ART, petunjuk teknis perlombaan, & format laporan.',
                'icon' => 'download',
                'bg_gradient' => 'from-teal-500 to-emerald-600',
                'text_color' => 'text-teal-600',
                'bg_light' => 'bg-teal-50/80',
                'border_color' => 'group-hover:border-teal-500/50',
                'link' => route('unduhan'),
                'external' => false
            ]
        ];

        // 1. Berita Terkini
        $beritaList = Berita::with('kategori')
            ->where('status_publikasi', 'published')
            ->orderByDesc('tanggal_publikasi')
            ->limit(3)
            ->get();

        // 2. Tiga Rumpun Komisi Olahraga
        $komisiList = KomisiInorga::withCount('inorga')
            ->orderBy('urutan')
            ->get();

        // 3. Event & Agenda Unggulan
        $eventList = Event::with('kategoriEvent')
            ->where('status_publikasi', true)
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(2)
            ->get();

        // 4. Galeri Foto Terpilih
        $galeriList = GaleriFoto::orderBy('urutan', 'asc')
            ->limit(6)
            ->get();

        // 5. Statistik & Metrik KORMI
        $stats = [
            'totalInorga' => Inorga::count(),
            'totalDuta' => DutaOlahraga::count(),
            'totalKecamatan' => Kecamatan::count(),
            'totalSapras' => Sapras::count(),
            'totalUnduhan' => Unduhan::count(),
            'totalAktivitasWarga' => \App\Models\Kormi\PartisipasiAktivitas::valid()->count(),
            'totalPesertaWarga' => \App\Models\Kormi\PartisipasiAktivitas::valid()->sum('jumlah_peserta'),
        ];

        return view('livewire.frontend.beranda', [
            'kegiatanGrid' => $kegiatanGrid,
            'beritaList' => $beritaList,
            'komisiList' => $komisiList,
            'eventList' => $eventList,
            'galeriList' => $galeriList,
            'stats' => $stats,
        ])->layout('components.layouts.app');
    }
}

