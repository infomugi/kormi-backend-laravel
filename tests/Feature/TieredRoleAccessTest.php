<?php

namespace Tests\Feature;

use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TieredRoleAccessTest extends TestCase
{
    use DatabaseTransactions;

    public function test_super_admin_can_access_all_routes(): void
    {
        $superAdminRole = Peran::where('slug', 'super-admin')->first();
        $user = Pengguna::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'peran_id' => $superAdminRole->id,
            'nama_lengkap' => 'Super Admin Test',
            'email' => 'superadmin_test@kormibdg.id',
            'kata_sandi' => \Illuminate\Support\Facades\Hash::make('password'),
            'status_aktif' => true,
        ]);

        $routes = [
            '/admin',
            '/admin/dashboard',
            '/admin/berita',
            '/admin/galeri',
            '/admin/unduhan',
            '/admin/duta',
            '/admin/kordik',
            '/admin/sapras',
            '/admin/inorga',
            '/admin/event',
            '/admin/klasemen',
            '/admin/sdi',
            '/admin/apmo',
            '/admin/pengguna',
            '/admin/peran',
            '/admin/sejarah',
            '/admin/visi-misi',
            '/admin/pengurus',
            '/admin/proker',
            '/admin/pengaturan',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($user, 'web')->get($route);
            $this->assertEquals(200, $response->status(), "Route {$route} failed with status " . $response->status());
        }
    }

    public function test_editor_berita_permissions(): void
    {
        $role = Peran::where('slug', 'editor-berita')->first();
        $user = Pengguna::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'peran_id' => $role->id,
            'nama_lengkap' => 'Editor Berita Test',
            'email' => 'editor_test@kormibdg.id',
            'kata_sandi' => \Illuminate\Support\Facades\Hash::make('password'),
            'status_aktif' => true,
        ]);

        // Allowed routes
        $this->actingAs($user, 'web')->get('/admin')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/dashboard')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/berita')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/galeri')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/unduhan')->assertStatus(200);

        // Forbidden routes
        $this->actingAs($user, 'web')->get('/admin/inorga')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/duta')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/kordik')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/sapras')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/pengguna')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/pengaturan')->assertStatus(403);
    }

    public function test_admin_korcam_permissions(): void
    {
        $role = Peran::where('slug', 'admin-korcam')->first();
        $user = Pengguna::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'peran_id' => $role->id,
            'nama_lengkap' => 'Admin Korcam Test',
            'email' => 'korcam_test@kormibdg.id',
            'kata_sandi' => \Illuminate\Support\Facades\Hash::make('password'),
            'status_aktif' => true,
        ]);

        // Allowed routes
        $this->actingAs($user, 'web')->get('/admin')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/dashboard')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/duta')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/kordik')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/sapras')->assertStatus(200);

        // Forbidden routes
        $this->actingAs($user, 'web')->get('/admin/berita')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/inorga')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/event')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/pengguna')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/pengaturan')->assertStatus(403);
    }

    public function test_admin_inorga_permissions(): void
    {
        $role = Peran::where('slug', 'admin-inorga')->first();
        $user = Pengguna::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'peran_id' => $role->id,
            'nama_lengkap' => 'Admin Inorga Test',
            'email' => 'inorga_test@kormibdg.id',
            'kata_sandi' => \Illuminate\Support\Facades\Hash::make('password'),
            'status_aktif' => true,
        ]);

        // Allowed routes
        $this->actingAs($user, 'web')->get('/admin')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/dashboard')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/inorga')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/event')->assertStatus(200);
        $this->actingAs($user, 'web')->get('/admin/klasemen')->assertStatus(200);

        // Forbidden routes
        $this->actingAs($user, 'web')->get('/admin/berita')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/duta')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/kordik')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/sapras')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/pengguna')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/peran')->assertStatus(403);
        $this->actingAs($user, 'web')->get('/admin/pengaturan')->assertStatus(403);
    }

    public function test_peran_kelola_crud_and_permissions(): void
    {
        $superAdminRole = Peran::where('slug', 'super-admin')->first();
        $admin = Pengguna::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'peran_id' => $superAdminRole->id,
            'nama_lengkap' => 'Admin Peran Test',
            'email' => 'admin_peran@kormibdg.id',
            'kata_sandi' => \Illuminate\Support\Facades\Hash::make('password'),
            'status_aktif' => true,
        ]);

        $this->actingAs($admin, 'web');

        // Test Livewire Peran Component
        \Livewire\Livewire::test(\App\Livewire\Backend\Pengguna\PeranKelola::class)
            ->call('bukaFormTambah')
            ->set('nama_peran', 'Staff Publikasi Wilayah')
            ->set('slug', 'staff-publikasi-wilayah')
            ->set('deskripsi', 'Staf pengelola berita wilayah khusus')
            ->set('hak_akses', ['berita', 'duta'])
            ->call('simpan')
            ->assertHasNoErrors();

        $peranBaru = Peran::where('slug', 'staff-publikasi-wilayah')->first();
        $this->assertNotNull($peranBaru);
        $this->assertEquals(['berita', 'duta'], $peranBaru->hak_akses);
        $this->assertTrue($peranBaru->punyaAkses('berita'));
        $this->assertTrue($peranBaru->punyaAkses('duta'));
        $this->assertFalse($peranBaru->punyaAkses('inorga'));
    }
}
