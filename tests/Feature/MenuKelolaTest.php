<?php

namespace Tests\Feature;

use App\Livewire\Backend\Pengaturan\MenuKelola;
use App\Models\Core\Menu;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class MenuKelolaTest extends TestCase
{
    use DatabaseTransactions;
    protected function setUp(): void
    {
        parent::setUp();

        // Setup Super Admin role and user
        $peran = Peran::firstOrCreate(
            ['slug' => 'super-admin'],
            ['nama_peran' => 'Super Administrator', 'deskripsi' => 'Full access', 'hak_akses' => ['*']]
        );

        $admin = Pengguna::firstOrCreate(
            ['email' => 'admin_menu_test@kormibdg.id'],
            [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'peran_id' => $peran->id,
                'nama_lengkap' => 'Admin Menu Tester',
                'kata_sandi' => bcrypt('password123'),
                'status_aktif' => true,
            ]
        );

        $this->actingAs($admin);
    }

    public function test_super_admin_can_access_menu_kelola_page()
    {
        $response = $this->get(route('admin.menu'));
        $response->assertStatus(200);
        $response->assertSee('Manajemen Menu Navigasi');
    }

    public function test_can_switch_menu_groups()
    {
        Livewire::test(MenuKelola::class)
            ->assertSet('grup', 'frontend_header')
            ->call('setGrup', 'frontend_footer')
            ->assertSet('grup', 'frontend_footer')
            ->call('setGrup', 'backend_sidebar')
            ->assertSet('grup', 'backend_sidebar');
    }

    public function test_can_create_new_menu_item()
    {
        Livewire::test(MenuKelola::class)
            ->call('bukaModalTambah')
            ->set('nama', 'Menu Uji Coba')
            ->set('tautan', '/uji-coba')
            ->set('icon', 'sparkles')
            ->set('target', '_self')
            ->set('urutan', 99)
            ->set('badge', 'Baru')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('sys_menu', [
            'nama' => 'Menu Uji Coba',
            'tautan' => '/uji-coba',
            'icon' => 'sparkles',
            'badge' => 'Baru',
        ]);
    }

    public function test_can_inline_update_menu_item()
    {
        $menu = Menu::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'grup' => 'frontend_header',
            'nama' => 'Menu Asli',
            'tautan' => '/asli',
            'urutan' => 1,
            'status_aktif' => true,
        ]);

        Livewire::test(MenuKelola::class)
            ->call('updateInline', $menu->id, 'nama', 'Menu Terupdate Inline')
            ->call('updateInline', $menu->id, 'tautan', '/link-baru')
            ->call('updateInline', $menu->id, 'urutan', 5);

        $menu->refresh();
        $this->assertEquals('Menu Terupdate Inline', $menu->nama);
        $this->assertEquals('/link-baru', $menu->tautan);
        $this->assertEquals(5, $menu->urutan);
    }

    public function test_can_toggle_menu_status()
    {
        $menu = Menu::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'grup' => 'frontend_header',
            'nama' => 'Menu Toggle Test',
            'tautan' => '/toggle',
            'status_aktif' => true,
        ]);

        Livewire::test(MenuKelola::class)
            ->call('toggleAktif', $menu->id);

        $this->assertFalse($menu->fresh()->status_aktif);

        Livewire::test(MenuKelola::class)
            ->call('toggleAktif', $menu->id);

        $this->assertTrue($menu->fresh()->status_aktif);
    }

    public function test_can_clone_or_duplicate_menu_item()
    {
        $parent = Menu::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'grup' => 'frontend_header',
            'nama' => 'Menu Master Clone',
            'tautan' => '/master-clone',
            'urutan' => 2,
            'status_aktif' => true,
        ]);

        $child = Menu::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'grup' => 'frontend_header',
            'induk_id' => $parent->id,
            'nama' => 'Sub Menu Master Clone',
            'tautan' => '/sub-master-clone',
            'urutan' => 1,
            'status_aktif' => true,
        ]);

        Livewire::test(MenuKelola::class)
            ->call('duplikatMenu', $parent->id);

        $this->assertDatabaseHas('sys_menu', [
            'nama' => 'Menu Master Clone (Salinan)',
            'tautan' => '/master-clone',
        ]);

        $this->assertDatabaseHas('sys_menu', [
            'nama' => 'Sub Menu Master Clone',
            'tautan' => '/sub-master-clone',
        ]);
    }

    public function test_can_reorder_menus()
    {
        $m1 = Menu::create(['id' => (string)\Illuminate\Support\Str::uuid(), 'grup' => 'frontend_header', 'nama' => 'Item 1', 'tautan' => '#', 'urutan' => 1]);
        $m2 = Menu::create(['id' => (string)\Illuminate\Support\Str::uuid(), 'grup' => 'frontend_header', 'nama' => 'Item 2', 'tautan' => '#', 'urutan' => 2]);

        Livewire::test(MenuKelola::class)
            ->call('updateUrutan', [$m2->id, $m1->id]);

        $this->assertEquals(1, $m2->fresh()->urutan);
        $this->assertEquals(2, $m1->fresh()->urutan);
    }

    public function test_can_delete_menu_item()
    {
        $menu = Menu::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'grup' => 'frontend_header',
            'nama' => 'Menu Mau Dihapus',
            'tautan' => '/hapus',
            'status_aktif' => true,
        ]);

        Livewire::test(MenuKelola::class)
            ->call('hapus', $menu->id);

        $this->assertDatabaseMissing('sys_menu', [
            'id' => $menu->id,
        ]);
    }
}
