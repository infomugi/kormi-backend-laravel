<?php

namespace App\Livewire\Frontend\Kormi\Tentang;

use App\Models\Kormi\PengurusModel;
use App\Models\Kormi\PeriodeKepengurusan;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Susunan Pengurus - KORMI Kabupaten Bandung')]
class Pengurus extends Component
{
    #[Url(as: 'bidang')]
    public string $filterBidang = 'semua';

    #[Url(as: 'cari')]
    public string $cari = '';

    public function setBidang(string $bidang): void
    {
        $this->filterBidang = $bidang;
    }

    public function render()
    {
        $periodeAktif = PeriodeKepengurusan::aktif()->first() 
            ?? PeriodeKepengurusan::orderByDesc('tahun_mulai')->first();

        $query = PengurusModel::tampil()
            ->when($periodeAktif, fn($q) => $q->where('periode_id', $periodeAktif->id))
            ->when(!empty($this->cari), function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nama_lengkap', 'like', "%{$this->cari}%")
                        ->orWhere('jabatan', 'like', "%{$this->cari}%")
                        ->orWhere('kategori_bidang', 'like', "%{$this->cari}%");
                });
            })
            ->urut();

        $pengurusCollection = $query->get();

        // Kategori hierarchy order
        $kategoriOrder = [
            'Pelindung',
            'Dewan Kehormatan',
            'Dewan Pembina',
            'Dewan Pakar',
            'Pengurus Harian',
            'Komisi OTKB',
            'Komisi OKK',
            'Komisi OPT',
        ];

        $bidangTersedia = PengurusModel::tampil()
            ->when($periodeAktif, fn($q) => $q->where('periode_id', $periodeAktif->id))
            ->whereNotNull('kategori_bidang')
            ->where('kategori_bidang', '!=', '')
            ->distinct()
            ->pluck('kategori_bidang')
            ->toArray();

        // Group by kategori_bidang
        $grouped = $pengurusCollection->groupBy(function ($item) {
            return $item->kategori_bidang ?: 'Pengurus Lainnya';
        });

        // Filter if specific bidang selected
        if ($this->filterBidang !== 'semua' && !empty($this->filterBidang)) {
            $grouped = $grouped->filter(function ($items, $key) {
                return strtolower($key) === strtolower($this->filterBidang);
            });
        }

        // Sort groups based on standard hierarchy
        $sortedGroups = [];
        foreach ($kategoriOrder as $kat) {
            if ($grouped->has($kat)) {
                $sortedGroups[$kat] = $grouped->get($kat);
            }
        }
        foreach ($grouped as $key => $items) {
            if (!isset($sortedGroups[$key])) {
                $sortedGroups[$key] = $items;
            }
        }

        return view('livewire.frontend.kormi.tentang.pengurus', [
            'periodeAktif'    => $periodeAktif,
            'sortedGroups'    => $sortedGroups,
            'bidangTersedia'  => $bidangTersedia,
            'totalPengurus'   => $pengurusCollection->count(),
        ])->layout('components.layouts.app');
    }
}

