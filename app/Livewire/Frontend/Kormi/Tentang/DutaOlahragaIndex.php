<?php

namespace App\Livewire\Frontend\Kormi\Tentang;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Master\Kecamatan;
use App\Models\Kormi\DutaOlahraga;

class DutaOlahragaIndex extends Component
{
    use WithPagination;

    public string $cari = '';
    public string $kecamatanDipilih = '';

    public function updatingCari() { $this->resetPage(); }
    public function updatingKecamatanDipilih() { $this->resetPage(); }

    public function render()
    {
        return view('livewire.frontend.kormi.tentang.duta-olahraga-index', $this->dataTampilan())
            ->layout('components.layouts.app', ['title' => 'Duta Olahraga - KORMI Kabupaten Bandung']);
    }

    protected function dataTampilan(): array
    {
        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();

        $dutaList = DutaOlahraga::with(['kecamatan', 'desaKelurahan'])
            ->where('status_aktif', true)
            ->where('status_pendaftaran', DutaOlahraga::STATUS_DISETUJUI)
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

        return [
            'kecamatanList' => $kecamatanList,
            'dutaList' => $dutaList,
        ];
    }
}
