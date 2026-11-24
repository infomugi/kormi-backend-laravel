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

    protected function dataTampilan(): array
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

        return [
            'berita' => $berita,
            'beritaTerkait' => $beritaTerkait,
        ];
    }

    public function render()
    {
        $data = $this->dataTampilan();

        return view('livewire.frontend.media.berita-detail', $data)
            ->layout('components.layouts.app', ['title' => $data['berita']->judul . ' - KORMI Kabupaten Bandung']);
    }
}
