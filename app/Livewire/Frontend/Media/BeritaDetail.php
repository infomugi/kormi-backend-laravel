<?php

namespace App\Livewire\Frontend\Media;

use App\Models\Content\Berita;
use Livewire\Attributes\Title;
use Livewire\Component;

class BeritaDetail extends Component
{
    public string $slug;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $berita = Berita::with('kategori', 'penulis')
            ->where('slug', $this->slug)
            ->where('status_publikasi', 'published')
            ->firstOrFail();

        // Increment views count
        $berita->increment('jumlah_dilihat');

        $beritaTerkait = Berita::with('kategori')
            ->where('id', '!=', $berita->id)
            ->where('kategori_id', $berita->kategori_id)
            ->where('status_publikasi', 'published')
            ->limit(3)
            ->get();

        return view('livewire.frontend.media.berita-detail', [
            'berita' => $berita,
            'beritaTerkait' => $beritaTerkait,
        ])->layout('components.layouts.app', ['title' => $berita->judul . ' - KORMI Kabupaten Bandung']);
    }
}
