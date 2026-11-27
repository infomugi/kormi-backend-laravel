<?php

namespace Tests\Feature;

use App\Livewire\Mobile\DaftarDuta;
use App\Models\Core\Pengguna;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use App\Services\StorageService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Fokus: unggah pas foto di /mobile/daftar-duta harus selalu memberi hasil yang
 * jelas (pratinjau tampil, atau pesan kesalahan berbahasa Indonesia), bukan
 * halaman error 500 dan bukan foto yang hilang diam-diam.
 */
class MobileDaftarDutaFotoTest extends TestCase
{
    use DatabaseTransactions;

    protected Kecamatan $kecamatan;
    protected DesaKelurahan $desa;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('minio');
        RateLimiter::clear('duta-daftar:127.0.0.1');

        $this->kecamatan = Kecamatan::first() ?? Kecamatan::create([
            'nama_kecamatan' => 'Kecamatan Uji Foto',
            'slug'           => 'kecamatan-uji-foto-' . Str::lower(Str::random(6)),
        ]);

        $this->desa = DesaKelurahan::where('kecamatan_id', $this->kecamatan->id)->first()
            ?? DesaKelurahan::create([
                'kecamatan_id'        => $this->kecamatan->id,
                'nama_desa_kelurahan' => 'Desa Uji Foto',
                'slug'                => 'desa-uji-foto-' . Str::lower(Str::random(6)),
                'jenis'               => 'desa',
            ]);
    }

    private function dataPendaftaranValid(array $override = []): array
    {
        return array_merge([
            'nama_lengkap'           => 'Duta Foto ' . Str::random(8),
            'jenis_kelamin'          => 'P',
            'tanggal_lahir'          => '1995-03-03',
            'kecamatan_id'           => $this->kecamatan->id,
            'desa_kelurahan_id'      => $this->desa->id,
            'alamat_domisili'        => 'Jl. Uji Foto No. 10, RT 01 RW 02',
            'nomor_telepon'          => '081200001234',
            'email'                  => 'foto.uji.' . Str::lower(Str::random(12)) . '@example.test',
            'kategori_duta'          => 'Duta Olahraga Masyarakat',
            'setuju_syarat'          => true,
            'pernyataan_kebenaran'   => true,
            'kata_sandi'             => 'rahasia12345',
            'konfirmasi_kata_sandi'  => 'rahasia12345',
        ], $override);
    }

    public function test_unggah_foto_valid_menampilkan_pratinjau_di_langkah_tiga(): void
    {
        Livewire::test(DaftarDuta::class)
            ->set('currentStep', 3)
            ->set('foto', UploadedFile::fake()->image('duta.jpg', 600, 800))
            ->assertHasNoErrors()
            ->assertSee('Ganti Foto Duta')
            ->assertSee('<img', false);
    }

    public function test_berkas_bukan_gambar_langsung_ditolak_dengan_pesan_indonesia(): void
    {
        Livewire::test(DaftarDuta::class)
            ->set('currentStep', 3)
            ->set('foto', UploadedFile::fake()->create('foto-duta.jpg', 40, 'application/octet-stream'))
            ->assertHasErrors('foto')
            ->assertSet('foto', null)
            ->assertSee('Berkas foto harus berupa gambar.');
    }

    public function test_foto_heic_yang_tidak_terkonversi_ditolak_dengan_pesan_khusus(): void
    {
        Livewire::test(DaftarDuta::class)
            ->set('currentStep', 3)
            ->set('foto', UploadedFile::fake()->create('IMG_0001.HEIC', 800, 'image/heic'))
            ->assertHasErrors('foto')
            ->assertSet('foto', null)
            ->assertSee('HEIC');
    }

    public function test_error_foto_hilang_setelah_memilih_foto_valid_pengganti(): void
    {
        Livewire::test(DaftarDuta::class)
            ->set('currentStep', 3)
            ->set('foto', UploadedFile::fake()->create('salah.pdf', 40, 'application/pdf'))
            ->assertHasErrors('foto')
            ->set('foto', UploadedFile::fake()->image('benar.jpg'))
            ->assertHasNoErrors()
            ->assertSee('Ganti Foto Duta');
    }

    public function test_pendaftaran_dengan_foto_tersimpan_ke_storage(): void
    {
        $data = $this->dataPendaftaranValid();

        Livewire::test(DaftarDuta::class)
            ->set($data)
            ->set('currentStep', 4)
            ->set('foto', UploadedFile::fake()->image('duta.jpg'))
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $duta = DutaOlahraga::where('email', $data['email'])->first();
        $this->assertNotNull($duta);
        $this->assertNotEmpty($duta->foto_url);
        Storage::disk('minio')->assertExists($duta->foto_url);
    }

    public function test_kegagalan_storage_menampilkan_pesan_bukan_error_500(): void
    {
        $data = $this->dataPendaftaranValid();

        $this->mock(StorageService::class, function ($mock) {
            $mock->shouldReceive('uploadGambar')->once()->andThrow(new \RuntimeException('MinIO tidak tersedia'));
        });

        Livewire::test(DaftarDuta::class)
            ->set($data)
            ->set('currentStep', 4)
            ->set('foto', UploadedFile::fake()->image('duta.jpg'))
            ->call('submit')
            ->assertHasErrors('foto')
            ->assertSet('berhasil', false)
            ->assertSee('Foto gagal diunggah ke penyimpanan');

        $this->assertDatabaseMissing('kormi_duta_olahraga', ['email' => $data['email']]);
        $this->assertDatabaseMissing('sys_pengguna', ['email' => $data['email']]);
        $this->assertNull(Pengguna::where('email', $data['email'])->first());
    }
}
