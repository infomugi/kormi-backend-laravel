<?php

namespace App\Livewire\Publik;

use Livewire\Component;
use App\Models\Inorga;
use App\Models\Unduhan;

class Beranda extends Component
{
    public function render()
    {
        $kegiatanGrid = [
            ['name' => 'Inorga', 'icon' => 'award', 'color' => 'bg-green-500', 'link' => route('inorga'), 'external' => false],
            ['name' => 'Fotradkab', 'icon' => 'info', 'color' => 'bg-blue-500', 'link' => route('fotradkab'), 'external' => false],
            ['name' => 'Forkab', 'icon' => 'calendar', 'color' => 'bg-orange-500', 'link' => route('forkab'), 'external' => false],
            ['name' => 'Bedas Run', 'icon' => 'zap', 'color' => 'bg-red-500', 'link' => 'https://bandungbedasrun.kormibdg.id', 'external' => true],
            ['name' => 'Apmo', 'icon' => 'trophy', 'color' => 'bg-purple-500', 'link' => route('apmo'), 'external' => false],
            ['name' => 'SDI', 'icon' => 'users', 'color' => 'bg-cyan-500', 'link' => route('sdi'), 'external' => false],
            ['name' => 'Sapras', 'icon' => 'map-pin', 'color' => 'bg-indigo-500', 'link' => route('sapras'), 'external' => false],
            ['name' => 'Unduhan', 'icon' => 'download', 'color' => 'bg-emerald-500', 'link' => route('unduhan'), 'external' => false]
        ];

        $beritaList = \App\Models\Berita::with('kategori')
            ->where('status_publikasi', 'published')
            ->orderByDesc('tanggal_publikasi')
            ->limit(3)
            ->get();

        $totalInorga = Inorga::count();
        $totalUnduhan = Unduhan::count();
        $totalDuta = \App\Models\DutaOlahraga::count();

        return view('livewire.publik.beranda', [
            'kegiatanGrid' => $kegiatanGrid,
            'beritaList' => $beritaList,
            'totalInorga' => $totalInorga,
            'totalUnduhan' => $totalUnduhan,
            'totalDuta' => $totalDuta,
        ])->layout('components.layouts.app');
    }
}
