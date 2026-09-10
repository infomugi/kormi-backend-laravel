<?php

namespace App\Livewire\Publik\Unduhan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Unduhan;
use App\Models\KategoriUnduhan;

class UnduhanIndex extends Component
{
    use WithPagination;

    public string $cari = '';
    public string $kategoriDipilih = 'Semua';

    public function updatingCari()
    {
        $this->resetPage();
    }

    public function unduhBerkas(string $id)
    {
        $dokumen = Unduhan::findOrFail($id);
        $dokumen->increment('jumlah_unduhan');
        
        // Simulasi trigger download file
        return redirect()->back();
    }

    public function render()
    {
        $kategoriList = KategoriUnduhan::orderBy('nama_kategori')->get();

        $dokumenList = Unduhan::with('kategori')
            ->where('status_publik', true)
            ->when($this->kategoriDipilih !== 'Semua', function ($q) {
                $q->whereHas('kategori', fn($k) => $k->where('slug', $this->kategoriDipilih));
            })
            ->when($this->cari !== '', function ($q) {
                $q->where('judul_dokumen', 'like', '%' . $this->cari . '%');
            })
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('livewire.publik.unduhan.unduhan-index', [
            'kategoriList' => $kategoriList,
            'dokumenList' => $dokumenList,
        ])->layout('components.layouts.app', ['title' => 'Pusat Unduhan - KORMI Kabupaten Bandung']);
    }
}
