<?php

namespace App\Livewire\Frontend\Media;

use App\Models\Content\Berita;
use App\Models\Content\KategoriBerita;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Berita & Artikel - KORMI Kabupaten Bandung')]
class BeritaIndex extends Component
{
    use WithPagination;

    #[Url(as: 'kategori')]
    public string $kategoriDipilih = 'Semua';

    #[Url(as: 'cari')]
    public string $cari = '';

    public function filterKategori(string $slug): void
    {
        $this->kategoriDipilih = $slug;
        $this->resetPage();
    }

    public function updatedCari(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $kategoriList = KategoriBerita::orderBy('nama_kategori')->get();

        $query = Berita::with('kategori', 'penulis')
            ->where('status_publikasi', 'published')
            ->orderByDesc('tanggal_publikasi');

        if ($this->kategoriDipilih !== 'Semua') {
            $query->whereHas('kategori', function ($q) {
                $q->where('slug', $this->kategoriDipilih);
            });
        }

        if (!empty($this->cari)) {
            $query->where(function ($q) {
                $q->where('judul', 'like', '%' . $this->cari . '%')
                  ->orWhere('ringkasan', 'like', '%' . $this->cari . '%');
            });
        }

        $beritaList = $query->paginate(6);
        $beritaUtama = Berita::with('kategori')
            ->where('status_publikasi', 'published')
            ->where('status_unggulan', true)
            ->first() ?? Berita::with('kategori')->where('status_publikasi', 'published')->first();

        return view('livewire.frontend.media.berita-index', [
            'kategoriList' => $kategoriList,
            'beritaList' => $beritaList,
            'beritaUtama' => $beritaUtama,
        ])->layout('components.layouts.app');
    }
}
