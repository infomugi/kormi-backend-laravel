<?php

namespace App\Livewire\Mobile;

use App\Models\Kormi\AngketApmo;
use App\Models\Master\Kecamatan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.mobile')]
#[Title('Beranda - KORMI Kabupaten Bandung')]
class Beranda extends \App\Livewire\Frontend\Beranda
{
    public function render()
    {
        $data = $this->dataTampilan();

        if (auth()->check()) {
            $data['apmoKecamatan'] = $this->rekapApmoKecamatan();
        }

        return view('livewire.mobile.beranda', $data);
    }

    private function rekapApmoKecamatan(): array
    {
        $agregat = AngketApmo::query()
            ->selectRaw('LOWER(TRIM(kecamatan)) as kunci, COUNT(*) as total')
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '!=', '')
            ->groupByRaw('LOWER(TRIM(kecamatan))')
            ->pluck('total', 'kunci');

        $baris = Kecamatan::orderBy('nama_kecamatan')
            ->get(['id', 'nama_kecamatan'])
            ->map(fn (Kecamatan $kecamatan) => [
                'id' => $kecamatan->id,
                'nama' => $kecamatan->nama_kecamatan,
                'total' => (int) ($agregat[mb_strtolower(trim($kecamatan->nama_kecamatan))] ?? 0),
            ])
            ->sortBy([['total', 'desc'], ['nama', 'asc']])
            ->values()
            ->all();

        return [
            'total' => array_sum(array_column($baris, 'total')),
            'terisi' => count(array_filter($baris, fn ($item) => $item['total'] > 0)),
            'jumlahKecamatan' => count($baris),
            'maks' => max(1, max(array_column($baris, 'total') ?: [0])),
            'baris' => $baris,
        ];
    }
}
