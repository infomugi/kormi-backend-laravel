<?php

namespace Tests\Feature;

use App\Livewire\Mobile\Profil;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class MobileProfilTest extends TestCase
{
    use DatabaseTransactions;

    private function penggunaUji(): Pengguna
    {
        return Pengguna::create([
            'peran_id' => Peran::where('slug', 'pegiat-olahraga')->firstOrFail()->id,
            'nama_lengkap' => 'Warga Uji Profil',
            'email' => 'uji.profil.' . uniqid() . '@contoh.id',
            'nomor_telepon' => '081200001111',
            'kata_sandi' => 'sandi-lama-123',
            'status_aktif' => true,
        ]);
    }

    public function test_ubah_nama_dan_nomor_telepon_tersimpan(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        Livewire::test(Profil::class)
            ->assertSet('nama_lengkap', 'Warga Uji Profil')
            ->assertSet('nomor_telepon', '081200001111')
            ->set('nama_lengkap', 'Nama Baru Uji')
            ->set('nomor_telepon', '081299998888')
            ->call('simpanDataAkun')
            ->assertHasNoErrors()
            ->assertSet('nama_lengkap', 'Nama Baru Uji');

        $this->assertDatabaseHas('sys_pengguna', [
            'id' => $user->id,
            'nama_lengkap' => 'Nama Baru Uji',
            'nomor_telepon' => '081299998888',
        ]);
    }

    public function test_ubah_data_akun_menolak_nama_kosong(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        Livewire::test(Profil::class)
            ->set('nama_lengkap', '')
            ->call('simpanDataAkun')
            ->assertHasErrors(['nama_lengkap' => 'required']);

        $this->assertSame('Warga Uji Profil', $user->fresh()->nama_lengkap);
    }

    public function test_unggah_foto_profil_baru_dan_hapus_foto_lama(): void
    {
        Storage::fake('minio');

        $user = $this->penggunaUji();
        $this->actingAs($user);

        $fotoPertama = UploadedFile::fake()->image('profil-1.jpg', 40, 40);

        Livewire::test(Profil::class)
            ->set('foto_profil_baru', $fotoPertama)
            ->call('simpanDataAkun')
            ->assertHasNoErrors();

        $pathPertama = $user->fresh()->foto_profil;
        $this->assertNotNull($pathPertama);
        Storage::disk('minio')->assertExists($pathPertama);

        $fotoKedua = UploadedFile::fake()->image('profil-2.png', 40, 40);

        Livewire::test(Profil::class)
            ->set('foto_profil_baru', $fotoKedua)
            ->call('simpanDataAkun')
            ->assertHasNoErrors();

        $pathKedua = $user->fresh()->foto_profil;
        $this->assertNotSame($pathPertama, $pathKedua);
        Storage::disk('minio')->assertExists($pathKedua);
        Storage::disk('minio')->assertMissing($pathPertama);
    }

    public function test_unggah_berkas_bukan_gambar_ditolak(): void
    {
        Storage::fake('minio');

        $user = $this->penggunaUji();
        $this->actingAs($user);

        Livewire::test(Profil::class)
            ->set('foto_profil_baru', UploadedFile::fake()->create('dokumen.pdf', 20, 'application/pdf'))
            ->call('simpanDataAkun')
            ->assertHasErrors(['foto_profil_baru']);

        $this->assertNull($user->fresh()->foto_profil);
    }

    public function test_ganti_kata_sandi_memerlukan_sandi_lama_yang_benar(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        Livewire::test(Profil::class)
            ->set('kata_sandi_lama', 'sandi-salah')
            ->set('kata_sandi_baru', 'sandi-baru-123')
            ->set('konfirmasi_kata_sandi', 'sandi-baru-123')
            ->call('gantiKataSandi')
            ->assertHasErrors(['kata_sandi_lama']);

        $this->assertTrue(Hash::check('sandi-lama-123', $user->fresh()->kata_sandi));
    }

    public function test_konfirmasi_kata_sandi_harus_sama(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        Livewire::test(Profil::class)
            ->set('kata_sandi_lama', 'sandi-lama-123')
            ->set('kata_sandi_baru', 'sandi-baru-123')
            ->set('konfirmasi_kata_sandi', 'sandi-baru-456')
            ->call('gantiKataSandi')
            ->assertHasErrors(['konfirmasi_kata_sandi']);

        $this->assertTrue(Hash::check('sandi-lama-123', $user->fresh()->kata_sandi));
    }

    public function test_ganti_kata_sandi_berhasil_disimpan_ter_hash(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        Livewire::test(Profil::class)
            ->set('kata_sandi_lama', 'sandi-lama-123')
            ->set('kata_sandi_baru', 'sandi-baru-123')
            ->set('konfirmasi_kata_sandi', 'sandi-baru-123')
            ->call('gantiKataSandi')
            ->assertHasNoErrors()
            ->assertSet('kata_sandi_lama', '')
            ->assertSet('kata_sandi_baru', '')
            ->assertSet('konfirmasi_kata_sandi', '');

        $kataSandiBaru = $user->fresh()->kata_sandi;
        $this->assertNotSame('sandi-baru-123', $kataSandiBaru);
        $this->assertTrue(Hash::check('sandi-baru-123', $kataSandiBaru));
    }

    public function test_halaman_profil_menampilkan_form_ubah_akun_dan_ganti_sandi(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        $this->get('/mobile/profil')
            ->assertOk()
            ->assertSee('Ubah Data Akun')
            ->assertSee('Nama Lengkap')
            ->assertSee('Pilih Foto Profil')
            ->assertSee('Ganti Kata Sandi')
            ->assertSee('Kata Sandi Saat Ini')
            ->assertSee('Perbarui Kata Sandi');
    }
}
