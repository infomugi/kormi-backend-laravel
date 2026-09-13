<?php

namespace Tests\Feature;

use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class ImpersonateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_super_admin_can_impersonate_user_and_leave()
    {
        $superAdminRole = Peran::where('slug', 'super-admin')->first();
        $pegiatRole = Peran::where('slug', 'pegiat-olahraga')->first();

        $superAdmin = Pengguna::create([
            'nama_lengkap' => 'Super Administrator Test',
            'email' => 'superadmin_test@kormikabupatenbandung.id',
            'kata_sandi' => bcrypt('password123'),
            'peran_id' => $superAdminRole->id,
            'status_aktif' => true,
        ]);

        $pegiat = Pengguna::create([
            'nama_lengkap' => 'Pegiat Test',
            'email' => 'pegiat_test@kormikabupatenbandung.id',
            'kata_sandi' => bcrypt('password123'),
            'peran_id' => $pegiatRole->id,
            'status_aktif' => true,
        ]);

        // Login as super admin
        $this->actingAs($superAdmin);

        // Call impersonate in Livewire component
        Livewire::test(\App\Livewire\Backend\Pengguna\PenggunaKelola::class)
            ->call('impersonate', $pegiat->id)
            ->assertRedirect(route('beranda'));

        // Check active session & user
        $this->assertEquals($pegiat->id, auth()->id());
        $this->assertEquals($superAdmin->id, session('impersonator_id'));
        $this->assertEquals($superAdmin->nama_lengkap, session('impersonator_name'));

        // Now test leave impersonation route
        $response = $this->get(route('admin.impersonate.leave'));
        $response->assertRedirect(route('admin.pengguna'));

        // Verify restored user
        $this->assertEquals($superAdmin->id, auth()->id());
        $this->assertFalse(session()->has('impersonator_id'));
    }

    public function test_super_admin_impersonating_cms_user_redirects_to_admin_dashboard()
    {
        $superAdminRole = Peran::where('slug', 'super-admin')->first();
        $editorRole = Peran::where('slug', 'editor-berita')->first();

        $superAdmin = Pengguna::create([
            'nama_lengkap' => 'Super Administrator Test',
            'email' => 'superadmin_test2@kormikabupatenbandung.id',
            'kata_sandi' => bcrypt('password123'),
            'peran_id' => $superAdminRole->id,
            'status_aktif' => true,
        ]);

        $editor = Pengguna::create([
            'nama_lengkap' => 'Editor Test',
            'email' => 'editor_test@kormikabupatenbandung.id',
            'kata_sandi' => bcrypt('password123'),
            'peran_id' => $editorRole->id,
            'status_aktif' => true,
        ]);

        $this->actingAs($superAdmin);

        Livewire::test(\App\Livewire\Backend\Pengguna\PenggunaKelola::class)
            ->call('impersonate', $editor->id)
            ->assertRedirect(route('admin.dashboard'));

        $this->assertEquals($editor->id, auth()->id());
        $this->assertEquals($superAdmin->id, session('impersonator_id'));
    }

    public function test_non_super_admin_cannot_impersonate()
    {
        $editorRole = Peran::where('slug', 'editor-berita')->first();
        $pegiatRole = Peran::where('slug', 'pegiat-olahraga')->first();

        $editor = Pengguna::create([
            'nama_lengkap' => 'Editor Test',
            'email' => 'editor_test3@kormikabupatenbandung.id',
            'kata_sandi' => bcrypt('password123'),
            'peran_id' => $editorRole->id,
            'status_aktif' => true,
        ]);

        $pegiat = Pengguna::create([
            'nama_lengkap' => 'Pegiat Test',
            'email' => 'pegiat_test3@kormikabupatenbandung.id',
            'kata_sandi' => bcrypt('password123'),
            'peran_id' => $pegiatRole->id,
            'status_aktif' => true,
        ]);

        $this->actingAs($editor);

        Livewire::test(\App\Livewire\Backend\Pengguna\PenggunaKelola::class)
            ->call('impersonate', $pegiat->id)
            ->assertForbidden();

        $this->assertEquals($editor->id, auth()->id());
        $this->assertFalse(session()->has('impersonator_id'));
    }
}
