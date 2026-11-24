<?php

namespace Tests\Feature;

use App\Services\StorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('minio');
    }

    /** Foto normal yang memuat byte acak menyerupai pola skrip tidak boleh ditolak. */
    public function test_foto_jpeg_dengan_byte_menyerupai_pola_skrip_tetap_diterima(): void
    {
        $file = UploadedFile::fake()->image('foto.jpg', 20, 20);

        // Simulasi data biner/EXIF yang memuat urutan byte mirip pola lama (<% %> dan exec( ).
        $byteAcak = "\x00\xFF<%\x91\x22\x8C\x00Response.Write(1)%>\x00\xFFexec (x)\x00\x9A\x1B";
        file_put_contents($file->getRealPath(), file_get_contents($file->getRealPath()) . $byteAcak);

        $path = app(StorageService::class)->uploadGambar($file, 'duta/pendaftaran');

        $this->assertNotEmpty($path);
        $this->assertStringEndsWith('.jpg', $path);
        Storage::disk('minio')->assertExists($path);
    }

    /** Gambar polyglot yang menyisipkan tag PHP tetap harus ditolak. */
    public function test_gambar_dengan_tag_php_ditolak(): void
    {
        $file = UploadedFile::fake()->image('jahat.png', 20, 20);
        file_put_contents(
            $file->getRealPath(),
            file_get_contents($file->getRealPath()) . '<?php system($_GET["c"]); ?>'
        );

        try {
            app(StorageService::class)->uploadGambar($file, 'duta/pendaftaran');
            $this->fail('Berkas dengan tag PHP seharusnya ditolak.');
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('pola kode berbahaya', $e->getMessage());
        }

        $this->assertEmpty(Storage::disk('minio')->allFiles());
    }

    /** Berkas yang bukan gambar valid (header palsu) harus ditolak. */
    public function test_berkas_bukan_gambar_valid_ditolak(): void
    {
        $file = UploadedFile::fake()->createWithContent('palsu.jpg', 'ini bukan gambar sama sekali');

        try {
            app(StorageService::class)->uploadGambar($file, 'duta/pendaftaran');
            $this->fail('Berkas non-gambar seharusnya ditolak.');
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('Format berkas gambar tidak valid', $e->getMessage());
        }

        $this->assertEmpty(Storage::disk('minio')->allFiles());
    }
}
