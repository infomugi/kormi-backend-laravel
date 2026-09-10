<?php

namespace App\Livewire\Admin;

use App\Models\Berita;
use App\Models\DutaOlahraga;
use App\Models\Inorga;
use App\Models\Kecamatan;
use App\Models\Unduhan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Dashboard - KORMI CMS')]
class Dashboard extends Component
{
    public function render()
    {
        $totalBerita = Berita::count();
        $totalUnduhan = Unduhan::count();
        $totalInorga = Inorga::count();
        $totalDuta = DutaOlahraga::count();
        $totalKecamatan = Kecamatan::count();
        $totalViews = Berita::sum('jumlah_dilihat');

        $komisiOtdaCount = Inorga::whereHas('komisi', fn($q) => $q->where('singkatan', 'OTDA'))->count();
        $komisiOkkCount = Inorga::whereHas('komisi', fn($q) => $q->where('singkatan', 'OKK'))->count();
        $komisiOptCount = Inorga::whereHas('komisi', fn($q) => $q->where('singkatan', 'OPT'))->count();

        $topKecamatan = \App\Models\EventKlasemenMedali::with('kecamatan')
            ->orderByDesc('jumlah_emas')
            ->orderByDesc('jumlah_perak')
            ->orderByDesc('jumlah_perunggu')
            ->first();

        $beritaTerbaru = Berita::with('kategori', 'penulis')
            ->orderByDesc('dibuat_pada')
            ->limit(5)
            ->get();

        $unduhanTerbaru = Unduhan::with('kategori')
            ->orderByDesc('dibuat_pada')
            ->limit(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'totalBerita' => $totalBerita,
            'totalUnduhan' => $totalUnduhan,
            'totalInorga' => $totalInorga,
            'totalDuta' => $totalDuta,
            'totalKecamatan' => $totalKecamatan,
            'totalViews' => $totalViews,
            'komisiOtdaCount' => $komisiOtdaCount,
            'komisiOkkCount' => $komisiOkkCount,
            'komisiOptCount' => $komisiOptCount,
            'topKecamatan' => $topKecamatan,
            'beritaTerbaru' => $beritaTerbaru,
            'unduhanTerbaru' => $unduhanTerbaru,
        ]);
    }
}
