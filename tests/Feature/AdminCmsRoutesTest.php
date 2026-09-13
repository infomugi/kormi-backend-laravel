<?php

namespace Tests\Feature;

use App\Models\Core\Pengguna;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminCmsRoutesTest extends TestCase
{
    use DatabaseTransactions;
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

    public function test_user_registration_requires_admin_approval_to_login(): void
    {
        $regEmail = 'calon_admin_' . time() . '@kormibdg.id';

        \Livewire\Livewire::test(\App\Livewire\Backend\Auth\Daftar::class)
            ->set('nama_lengkap', 'Calon Pengguna KORMI')
            ->set('email', $regEmail)
            ->set('nomor_telepon', '08123456789')
            ->set('kata_sandi', 'password123')
            ->set('konfirmasi_kata_sandi', 'password123')
            ->set('setuju_syarat', true)
            ->call('daftar')
            ->assertHasNoErrors()
            ->assertRedirect('/admin/masuk');

        $user = Pengguna::where('email', $regEmail)->first();
        $this->assertNotNull($user);
        $this->assertFalse((bool) $user->status_aktif);
        $this->assertFalse(\Illuminate\Support\Facades\Auth::check());

        // Attempting to login should be blocked because status_aktif is false
        \Livewire\Livewire::test(\App\Livewire\Backend\Auth\Masuk::class)
            ->set('email', $regEmail)
            ->set('kata_sandi', 'password123')
            ->call('login')
            ->assertHasErrors(['email']);

        $this->assertFalse(\Illuminate\Support\Facades\Auth::check());

        // Admin approves the account
        $user->update(['status_aktif' => true]);

        // Now user can successfully login
        \Livewire\Livewire::test(\App\Livewire\Backend\Auth\Masuk::class)
            ->set('email', $regEmail)
            ->set('kata_sandi', 'password123')
            ->call('login')
            ->assertHasNoErrors();

        $this->assertTrue(\Illuminate\Support\Facades\Auth::check());
        $this->assertEquals($user->id, \Illuminate\Support\Facades\Auth::id());

        // Clean up
        $user->delete();
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
