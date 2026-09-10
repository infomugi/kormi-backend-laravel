<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use Tests\TestCase;

class AdminCmsRoutesTest extends TestCase
{
    public function test_guest_is_redirected_to_login_when_accessing_admin_pages(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/masuk');
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/admin/masuk');
        $response->assertStatus(200);
        $response->assertSee('KORMI CMS');
    }

    public function test_register_page_renders_successfully(): void
    {
        $response = $this->get('/admin/daftar');
        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Baru');
    }

    public function test_forgot_password_page_renders_successfully(): void
    {
        $response = $this->get('/admin/lupa-password');
        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi');
    }

    public function test_authenticated_admin_can_access_all_cms_modules(): void
    {
        $admin = Pengguna::first();

        $routes = [
            '/admin',
            '/admin/berita',
            '/admin/galeri',
            '/admin/unduhan',
            '/admin/inorga',
            '/admin/duta',
            '/admin/klasemen',
            '/admin/sapras',
            '/admin/sdi',
            '/admin/apmo',
            '/admin/pengguna',
            '/admin/sejarah',
            '/admin/visi-misi',
            '/admin/pengurus',
            '/admin/kordik',
            '/admin/proker',
            '/admin/event',
            '/admin/pengaturan',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($admin)->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_api_v1_endpoints(): void
    {
        $this->get('/api/v1/pengaturan')->assertStatus(200);
        $this->get('/api/v1/berita')->assertStatus(200);
        $this->get('/api/v1/inorga')->assertStatus(200);
        $this->get('/api/v1/event')->assertStatus(200);
        $this->get('/api/v1/sapras')->assertStatus(200);
    }
}
