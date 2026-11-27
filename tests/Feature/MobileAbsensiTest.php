<?php

namespace Tests\Feature;

use App\Livewire\Mobile\Absensi;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\Absensi as AbsensiHarian;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class MobileAbsensiTest extends TestCase
{
    use DatabaseTransactions;

    private function penggunaUji(): Pengguna
    {
        return Pengguna::create([
            'peran_id' => Peran::where('slug', 'pegiat-olahraga')->firstOrFail()->id,
            'nama_lengkap' => 'Warga Uji Absensi',
            'email' => 'uji.absensi.' . uniqid() . '@contoh.id',
            'nomor_telepon' => '081200002222',
            'kata_sandi' => 'sandi-lama-123',
            'status_aktif' => true,
        ]);
    }

    public function test_tab_absensi_tampil_di_footer_mobile(): void
    {
        $this->actingAs($this->penggunaUji());

        $this->get('/mobile/profil')
            ->assertOk()
            ->assertSee('Absensi')
            ->assertSee('kd-tabbar', false);
    }

    public function test_halaman_absensi_menampilkan_form_foto_dan_koordinat(): void
    {
        $this->actingAs($this->penggunaUji());

        $this->get('/mobile/absensi')
            ->assertOk()
            ->assertSee('Foto Kehadiran')
            ->assertSee('Koordinat Lokasi')
            ->assertSee('Absen Masuk Sekarang')
            ->assertSee('kd-tabbar', false);
    }

    public function test_absensi_masuk_menyimpan_foto_dan_koordinat(): void
    {
        Storage::fake('minio');

        $user = $this->penggunaUji();
        $this->actingAs($user);

        Livewire::test(Absensi::class)
            ->set('foto', UploadedFile::fake()->image('selfie.jpg', 60, 60))
            ->set('latitude', -6.9570)
            ->set('longitude', 107.6380)
            ->set('akurasi_meter', 12.5)
            ->set('alamat', 'Sekretariat KORMI Kabupaten Bandung')
            ->call('simpan')
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $absen = AbsensiHarian::where('pengguna_id', $user->id)->first();

        $this->assertNotNull($absen);
        $this->assertNotNull($absen->jam_masuk);
        $this->assertNull($absen->jam_pulang);
        $this->assertSame(-6.957, $absen->latitude);
        $this->assertSame(107.638, $absen->longitude);
        Storage::disk('minio')->assertExists($absen->foto_masuk);
    }

    public function test_absensi_tanpa_foto_atau_lokasi_ditolak(): void
    {
        $this->actingAs($this->penggunaUji());

        Livewire::test(Absensi::class)
            ->set('latitude', -6.9570)
            ->set('longitude', 107.6380)
            ->call('simpan')
            ->assertHasErrors(['foto' => 'required']);

        Livewire::test(Absensi::class)
            ->set('foto', UploadedFile::fake()->image('selfie.jpg', 60, 60))
            ->call('simpan')
            ->assertHasErrors(['latitude' => 'required']);
    }

    public function test_absensi_menolak_berkas_bukan_gambar_dan_ukuran_berlebih(): void
    {
        Storage::fake('minio');

        $user = $this->penggunaUji();
        $this->actingAs($user);

        $komponen = Livewire::test(Absensi::class)
            ->set('foto', UploadedFile::fake()->create('catatan.pdf', 20, 'application/pdf'))
            ->set('latitude', -6.9570)
            ->set('longitude', 107.6380)
            ->call('simpan')
            ->assertHasErrors(['foto' => 'image']);

        $this->assertSame('Foto kehadiran harus berupa gambar.', $komponen->errors()->first('foto'));

        $komponen = Livewire::test(Absensi::class)
            ->set('foto', UploadedFile::fake()->image('selfie-besar.jpg', 320, 320)->size(11000))
            ->set('latitude', -6.9570)
            ->set('longitude', 107.6380)
            ->call('simpan')
            ->assertHasErrors(['foto' => 'max']);

        $this->assertSame('Ukuran foto maksimal 10MB.', $komponen->errors()->first('foto'));
        $this->assertSame(0, AbsensiHarian::where('pengguna_id', $user->id)->count());
    }

    public function test_absensi_pulang_melengkapi_kehadiran_hari_ini(): void
    {
        Storage::fake('minio');

        $user = $this->penggunaUji();
        $this->actingAs($user);

        AbsensiHarian::create([
            'pengguna_id' => $user->id,
            'tanggal' => now('Asia/Jakarta')->toDateString(),
            'jam_masuk' => '07:30:00',
            'latitude' => -6.9570,
            'longitude' => 107.6380,
            'foto_masuk' => 'absensi/masuk.jpg',
        ]);

        Livewire::test(Absensi::class)
            ->assertViewHas('tahap', 'pulang')
            ->set('foto', UploadedFile::fake()->image('selfie-pulang.jpg', 60, 60))
            ->set('latitude', -6.9571)
            ->set('longitude', 107.6381)
            ->call('simpan')
            ->assertHasNoErrors();

        $absen = AbsensiHarian::where('pengguna_id', $user->id)->first();

        $this->assertNotNull($absen->jam_pulang);
        $this->assertNotNull($absen->foto_pulang);
        Storage::disk('minio')->assertExists($absen->foto_pulang);

        Livewire::test(Absensi::class)->assertViewHas('tahap', 'selesai');
    }

    public function test_absensi_masuk_bisa_diisi_ulang_setelah_baris_hari_ini_dihapus(): void
    {
        Storage::fake('minio');

        $user = $this->penggunaUji();
        $this->actingAs($user);

        $lama = AbsensiHarian::create([
            'pengguna_id' => $user->id,
            'tanggal' => now('Asia/Jakarta')->toDateString(),
            'jam_masuk' => '06:15:00',
            'latitude' => -6.9570,
            'longitude' => 107.6380,
            'foto_masuk' => 'absensi/lama.jpg',
        ]);

        Storage::disk('minio')->put('absensi/lama.jpg', 'foto lama');
        $lama->delete();

        Livewire::test(Absensi::class)
            ->assertViewHas('tahap', 'masuk')
            ->set('foto', UploadedFile::fake()->image('selfie-baru.jpg', 60, 60))
            ->set('latitude', -6.9571)
            ->set('longitude', 107.6381)
            ->call('simpan')
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $absen = AbsensiHarian::withTrashed()
            ->where('pengguna_id', $user->id)
            ->where('tanggal', now('Asia/Jakarta')->toDateString())
            ->sole();

        $this->assertFalse($absen->trashed());
        $this->assertSame(-6.9571, $absen->latitude);
        $this->assertNull($absen->jam_pulang);
        $this->assertNotSame('absensi/lama.jpg', $absen->foto_masuk);
        Storage::disk('minio')->assertExists($absen->foto_masuk);
        Storage::disk('minio')->assertMissing('absensi/lama.jpg');
    }
}
