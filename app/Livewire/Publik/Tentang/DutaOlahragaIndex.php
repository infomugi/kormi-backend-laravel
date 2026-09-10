<?php

namespace App\Livewire\Publik\Tentang;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kecamatan;
use App\Models\DutaOlahraga;

class DutaOlahragaIndex extends Component
{
    use WithPagination;

    public string $cari = '';
    public string $kecamatanDipilih = '';

    public function updatingCari() { $this->resetPage(); }
    public function updatingKecamatanDipilih() { $this->resetPage(); }

    public function render()
    {
        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();
        
        $dutaList = DutaOlahraga::with(['kecamatan', 'desaKelurahan'])
            ->when($this->kecamatanDipilih !== '', fn($q) => $q->where('kecamatan_id', $this->kecamatanDipilih))
            ->when($this->cari !== '', function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                        ->orWhereHas('desaKelurahan', fn($d) => $d->where('nama_desa_kelurahan', 'like', '%' . $this->cari . '%'))
                        ->orWhereHas('kecamatan', fn($k) => $k->where('nama_kecamatan', 'like', '%' . $this->cari . '%'));
                });
            })
            ->orderBy('nama_lengkap')
            ->paginate(12);

        return view('livewire.publik.tentang.duta-olahraga-index', [
            'kecamatanList' => $kecamatanList,
            'dutaList' => $dutaList,
        ])->layout('components.layouts.app', ['title' => 'Duta Olahraga - KORMI Kabupaten Bandung']);
    }
}
