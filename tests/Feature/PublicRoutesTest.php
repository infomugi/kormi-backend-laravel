<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    public function test_all_public_pages_render_successfully(): void
    {
        $routes = [
            '/',
            '/tentang/sejarah',
            '/tentang/visi-misi',
            '/tentang/pengurus',
            '/tentang/koordinator-kecamatan',
            '/tentang/duta-olahraga',
            '/tentang/program-kerja',
            '/inorga',
            '/fotradkab',
            '/forkab',
            '/apmo',
            '/sdi',
            '/sapras',
            '/berita',
            '/galeri',
            '/unduhan',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_berita_detail_page_renders_successfully(): void
    {
        $berita = \App\Models\Berita::where('status_publikasi', 'published')->first();
        if (! $berita) {
            $kategori = \App\Models\KategoriBerita::firstOrCreate(
                ['slug' => 'kegiatan'],
                ['nama_kategori' => 'Kegiatan', 'deskripsi' => 'Berita kegiatan']
            );
            $penulis = \App\Models\Pengguna::first();
            $berita = \App\Models\Berita::create([
                'judul' => 'Persiapan Menuju FORKAB 2026',
                'slug' => 'persiapan-menuju-forkab-2026-rapat-koordinasi-wilayah',
                'ringkasan' => 'Rapat koordinasi persiapan FORKAB',
                'isi_konten' => '<p>Konten berita persiapan FORKAB</p>',
                'gambar_utama' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800',
                'kategori_id' => $kategori->id,
                'penulis_id' => $penulis?->id,
                'status_publikasi' => 'published',
                'tanggal_publikasi' => now(),
            ]);
        }

        $response = $this->get('/berita/' . $berita->slug);
        $response->assertStatus(200);
        $response->assertSee($berita->judul);
    }
}
