<?php

namespace App\Livewire\Frontend\Media;

use App\Models\Content\GaleriAlbum;
use App\Models\Content\GaleriFoto;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Galeri Kegiatan - KORMI Kabupaten Bandung')]
class GaleriIndex extends Component
{
    #[Url(as: 'album')]
    public string $albumDipilih = 'Semua';

    public function filterAlbum(string $judul): void
    {
        $this->albumDipilih = $judul;
    }

    public function render()
    {
        $albumList = GaleriAlbum::where('status_tampil', true)->orderBy('judul_album')->get();

        $query = GaleriFoto::with('album');

        if ($this->albumDipilih !== 'Semua') {
            $query->whereHas('album', function ($q) {
                $q->where('judul_album', $this->albumDipilih);
            });
        }

        $fotoList = $query->get();

        return view('livewire.frontend.media.galeri-index', [
            'albumList' => $albumList,
            'fotoList' => $fotoList,
        ])->layout('components.layouts.app');
    }
}
