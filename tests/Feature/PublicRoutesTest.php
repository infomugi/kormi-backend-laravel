<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
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
        $response = $this->get('/berita/persiapan-menuju-forkab-2026-rapat-koordinasi-wilayah');
        $response->assertStatus(200);
        $response->assertSee('Persiapan Menuju FORKAB 2026');
    }
}
