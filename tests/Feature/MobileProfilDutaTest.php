<?php

namespace Tests\Feature;

use App\Livewire\Mobile\Profil;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class MobileProfilDutaTest extends TestCase
{
    use DatabaseTransactions;

    private function penggunaUji(string $slugPeran = 'pegiat-olahraga'): Pengguna
    {
        return Pengguna::create([
            'peran_id' => Peran::where('slug', $slugPeran)->firstOrFail()->id,
            'nama_lengkap' => 'Pengguna Profil Uji ' . Str::random(4),
            'email' => 'profil-duta-' . Str::lower(Str::random(8)) . '@example.test',
            'kata_sandi' => Hash::make('password123'),
            'status_aktif' => true,
        ]);
    }

    private function wilayahUji(): array
    {
        $kecamatan = Kecamatan::orderBy('nama_kecamatan')->firstOrFail();
        $desa = DesaKelurahan::where('kecamatan_id', $kecamatan->id)
            ->orderBy('nama_desa_kelurahan')
            ->firstOrFail();

        return [$kecamatan, $desa];
    }

    public function test_pengguna_biasa_mendapat_tautan_pendaftaran_duta(): void
    {
        $user = $this->penggunaUji();

        $this->actingAs($user)
            ->get('/mobile/profil')
            ->assertOk()
            ->assertSee('Profil Duta Olahraga')
            ->assertSee('Daftar Sebagai Duta Olahraga')
            ->assertSee(route('mobile.daftar-duta'), false)
            ->assertDontSee('Hubungkan Profil Duta');
    }

    public function test_hubungkan_profil_duta_membuat_catatan_tertaut_dan_menunggu_verifikasi(): void
    {
        $user = $this->penggunaUji('duta-olahraga');
        [$kecamatan, $desa] = $this->wilayahUji();

        $this->actingAs($user);

        Livewire::test(Profil::class)
            ->call('pilihTab', 'data')
            ->assertSee('Belum terhubung')
            ->assertSee('Simpan & Hubungkan Profil Duta')
            ->set('nama_lengkap', 'Duta Uji Pendaftaran')
            ->set('nomor_telepon', '081234567899')
            ->set('duta_kategori', 'Duta Olahraga Masyarakat')
            ->set('duta_jenis_kelamin', 'L')
            ->set('duta_kecamatan_id', $kecamatan->id)
            ->set('duta_desa_kelurahan_id', null)
            ->call('simpanDataAkun')
            ->assertHasErrors('duta_desa_kelurahan_id');

        Livewire::test(Profil::class)
            ->call('pilihTab', 'data')
            ->set('nama_lengkap', 'Duta Uji Pendaftaran')
            ->set('nomor_telepon', '081234567899')
            ->set('duta_kategori', 'Duta Olahraga Masyarakat')
            ->set('duta_jenis_kelamin', 'L')
            ->set('duta_kecamatan_id', $kecamatan->id)
            ->set('duta_desa_kelurahan_id', $desa->id)
            ->set('duta_alamat', 'Jalan Uji Profil Nomor 10')
            ->set('duta_instagram', '@dutauji')
            ->call('simpanDataAkun')
            ->assertHasNoErrors()
            ->assertSet('duta_instagram', 'dutauji');

        $duta = DutaOlahraga::where('pengguna_id', $user->id)->firstOrFail();

        $this->assertSame(DutaOlahraga::STATUS_MENUNGGU, $duta->status_pendaftaran);
        $this->assertFalse((bool) $duta->status_aktif);
        $this->assertSame('Duta Uji Pendaftaran', $duta->nama_lengkap);
        $this->assertSame($kecamatan->id, $duta->kecamatan_id);
        $this->assertSame($desa->id, $duta->desa_kelurahan_id);
        $this->assertSame('dutauji', $duta->akun_instagram);
        $this->assertSame($user->email, $duta->email);

        $user->refresh();
        $this->assertSame('Duta Uji Pendaftaran', $user->nama_lengkap);
        $this->assertSame('081234567899', $user->nomor_telepon);
        $this->assertSame($kecamatan->id, $user->kecamatan_id);
        $this->assertSame($desa->id, $user->desa_kelurahan_id);
    }

    public function test_edit_data_menyimpan_akun_dan_profil_duta_terhubung_sekaligus(): void
    {
        $user = $this->penggunaUji();
        [$kecamatan, $desa] = $this->wilayahUji();

        $duta = DutaOlahraga::create([
            'kecamatan_id' => $kecamatan->id,
            'desa_kelurahan_id' => $desa->id,
            'nama_lengkap' => $user->nama_lengkap,
            'jenis_kelamin' => 'P',
            'tahun_pemilihan' => now()->year,
            'kategori_duta' => 'Duta Olahraga Masyarakat',
            'status_aktif' => false,
            'status_unggulan' => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
            'pengguna_id' => $user->id,
        ]);

        $this->actingAs($user);

        Livewire::test(Profil::class)
            ->call('pilihTab', 'data')
            ->assertSee('Terhubung')
            ->set('nama_lengkap', 'Nama Baru Terhubung')
            ->set('nomor_telepon', '081200001234')
            ->set('duta_kategori', 'Duta Pemuda & Kebugaran')
            ->set('duta_jenis_kelamin', 'P')
            ->set('duta_kecamatan_id', $kecamatan->id)
            ->set('duta_desa_kelurahan_id', $desa->id)
            ->set('duta_pekerjaan', 'Pelatih Senam')
            ->set('duta_gelar_prestasi', 'Juara 1 Senam Kreasi')
            ->call('simpanDataAkun')
            ->assertHasNoErrors();

        $user->refresh();
        $duta->refresh();

        $this->assertSame('Nama Baru Terhubung', $user->nama_lengkap);
        $this->assertSame('081200001234', $user->nomor_telepon);
        $this->assertSame('Pelatih Senam', $user->pekerjaan);
        $this->assertSame('Nama Baru Terhubung', $duta->nama_lengkap);
        $this->assertSame('Duta Pemuda & Kebugaran', $duta->kategori_duta);
        $this->assertSame('Pelatih Senam', $duta->pekerjaan_profesi);
        $this->assertSame('Juara 1 Senam Kreasi', $duta->gelar_prestasi);
        $this->assertSame(1, DutaOlahraga::where('pengguna_id', $user->id)->count());
    }

    public function test_halaman_profil_menampilkan_profil_duta_terhubung(): void
    {
        $user = $this->penggunaUji('duta-olahraga');
        [$kecamatan, $desa] = $this->wilayahUji();

        DutaOlahraga::create([
            'kecamatan_id' => $kecamatan->id,
            'desa_kelurahan_id' => $desa->id,
            'nama_lengkap' => 'Duta Terhubung Uji',
            'jenis_kelamin' => 'L',
            'tahun_pemilihan' => 2026,
            'kategori_duta' => 'Duta Olahraga Masyarakat',
            'status_aktif' => true,
            'status_unggulan' => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_DISETUJUI,
            'pengguna_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->get('/mobile/profil')
            ->assertOk()
            ->assertSee('Duta Terhubung Uji')
            ->assertSee('Disetujui')
            ->assertSee('Edit Profil Duta')
            ->assertDontSee('Hubungkan Profil Duta');
    }
}
