<?php

namespace App\Livewire\Publik\Informasi;

use App\Models\Sapras as SaprasModel;
use App\Models\Kecamatan;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Sarana & Prasarana - KORMI Kabupaten Bandung')]
class Sapras extends Component
{
    #[Url(as: 'kategori')]
    public string $jenisDipilih = 'Semua';

    #[Url(as: 'cari')]
    public string $cari = '';

    #[Url(as: 'kecamatan')]
    public string $kecamatanDipilih = 'Semua';

    public function filterKategori(string $kategori): void
    {
        $this->jenisDipilih = $kategori;
    }

    public function render()
    {
        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();

        $query = SaprasModel::with('kecamatan');

        if ($this->jenisDipilih !== 'Semua') {
            $query->where('kategori_fasilitas', $this->jenisDipilih);
        }

        if ($this->kecamatanDipilih !== 'Semua') {
            $query->whereHas('kecamatan', function ($q) {
                $q->where('slug', $this->kecamatanDipilih)
                  ->orWhere('nama_kecamatan', $this->kecamatanDipilih);
            });
        }

        if (!empty($this->cari)) {
            $query->where(function ($q) {
                $q->where('nama_fasilitas', 'like', '%' . $this->cari . '%')
                  ->orWhere('alamat_lengkap', 'like', '%' . $this->cari . '%')
                  ->orWhere('jenis_olahraga_tersedia', 'like', '%' . $this->cari . '%');
            });
        }

        $fasilitasData = $query->orderBy('nama_fasilitas')->get();

        return view('livewire.publik.informasi.sapras', [
            'fasilitasData' => $fasilitasData,
            'kecamatanList' => $kecamatanList,
        ])->layout('components.layouts.app');
    }
}


