<?php

namespace App\Livewire\Frontend\Kormi\Tentang;

use App\Models\Kormi\KordikPengurus;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Koordinator Kecamatan (Kordik) - KORMI Kabupaten Bandung')]
class Kordik extends Component
{
    #[Url(as: 'cari')]
    public string $cari = '';

    public function render()
    {
        $query = KordikPengurus::with('kecamatan')->where('status_aktif', true);

        if (!empty($this->cari)) {
            $query->where(function ($q) {
                $q->where('nama_ketua', 'like', "%{$this->cari}%")
                  ->orWhere('nama_sekretaris', 'like', "%{$this->cari}%")
                  ->orWhere('nama_bendahara', 'like', "%{$this->cari}%")
                  ->orWhereHas('kecamatan', fn($kq) => $kq->where('nama_kecamatan', 'like', "%{$this->cari}%"));
            });
        }

        $dbKordik = $query->leftJoin('ref_kecamatan', 'kormi_kordik_pengurus.kecamatan_id', '=', 'ref_kecamatan.id')
            ->orderBy('ref_kecamatan.nama_kecamatan', 'asc')
            ->select('kormi_kordik_pengurus.*')
            ->get();

        $kordikList = $dbKordik->map(fn($item) => [
            'id' => $item->id,
            'nama' => $item->nama_ketua ?: 'Belum Ditetapkan',
            'initial' => $item->initial_dua_huruf,
            'foto' => $item->foto_ketua_full_url,
            'kec' => $item->kecamatan ? 'Kecamatan ' . $item->kecamatan->nama_kecamatan : 'Kecamatan',
            'nama_kecamatan' => $item->kecamatan?->nama_kecamatan ?? '-',
            'alamat_kantor' => $item->kecamatan?->alamat_kantor ?? 'Kantor Kecamatan ' . ($item->kecamatan?->nama_kecamatan ?? ''),
            'sekretaris' => $item->nama_sekretaris ?: '-',
            'bendahara' => $item->nama_bendahara ?: '-',
            'telepon' => $item->nomor_telepon ?: ($item->kecamatan?->nomor_telepon ?? null),
        ]);

        return view('livewire.frontend.kormi.tentang.kordik', [
            'kordikList' => $kordikList,
        ])->layout('components.layouts.app');
    }
}

