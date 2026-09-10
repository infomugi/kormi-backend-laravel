<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class StorageService
{
    /**
     * Disk MinIO yang digunakan untuk semua upload.
     */
    protected string $disk = 'minio';

    /**
     * Upload gambar ke MinIO dan kembalikan path file.
     * Mendukung TemporaryUploadedFile dari Livewire maupun UploadedFile biasa.
     *
     * @param  TemporaryUploadedFile|UploadedFile  $file
     * @param  string  $folder  Folder tujuan (contoh: 'berita', 'galeri/foto')
     * @return string  Path file yang tersimpan di MinIO
     */
    public function uploadGambar($file, string $folder = 'gambar'): string
    {
        $ekstensi = $file->getClientOriginalExtension() ?: 'jpg';
        $namaFile = Str::uuid() . '.' . $ekstensi;
        $path = $folder . '/' . $namaFile;

        Storage::disk($this->disk)->put(
            $path,
            file_get_contents($file->getRealPath()),
            'private'
        );

        return $path;
    }

    /**
     * Upload berkas dokumen ke MinIO dan kembalikan path file.
     *
     * @param  TemporaryUploadedFile|UploadedFile  $file
     * @param  string  $folder  Folder tujuan (contoh: 'unduhan', 'dokumen')
     * @return string  Path file yang tersimpan di MinIO
     */
    public function uploadBerkas($file, string $folder = 'dokumen'): string
    {
        $ekstensi = $file->getClientOriginalExtension() ?: 'pdf';
        $namaFile = Str::uuid() . '.' . $ekstensi;
        $path = $folder . '/' . $namaFile;

        Storage::disk($this->disk)->put(
            $path,
            file_get_contents($file->getRealPath()),
            'private'
        );

        return $path;
    }

    /**
     * Hapus file dari MinIO berdasarkan path.
     * Tidak error jika file tidak ditemukan.
     *
     * @param  string|null  $path
     * @return bool
     */
    public function hapusFile(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        // Jangan hapus jika path adalah URL eksternal (http/https)
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return false;
        }

        try {
            return Storage::disk($this->disk)->delete($path);
        } catch (\Throwable $e) {
            // Abaikan error penghapusan
            return false;
        }
    }

    /**
     * Generate temporary signed URL untuk mengakses file private di MinIO.
     * URL berlaku selama durasi yang ditentukan (default 60 menit).
     *
     * @param  string|null  $path
     * @param  int  $menitExpiry  Durasi signed URL dalam menit
     * @return string|null  Signed URL atau null jika path kosong
     */
    public function getTemporaryUrl(?string $path, int $menitExpiry = 60): ?string
    {
        if (empty($path)) {
            return null;
        }

        // Path berupa URL eksternal — kembalikan langsung
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        try {
            return Storage::disk($this->disk)->temporaryUrl(
                $path,
                now()->addMinutes($menitExpiry)
            );
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Cek apakah path adalah URL eksternal (bukan path MinIO).
     */
    public function isUrlEksternal(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }
        return Str::startsWith($path, ['http://', 'https://']);
    }

    /**
     * Ambil ukuran file yang diupload dalam format human-readable.
     */
    public function getUkuranBerkas($file): string
    {
        $bytes = $file->getSize();

        if ($bytes < 1024) {
            return $bytes . ' B';
        } elseif ($bytes < 1024 * 1024) {
            return round($bytes / 1024, 1) . ' KB';
        } else {
            return round($bytes / (1024 * 1024), 1) . ' MB';
        }
    }

    /**
     * Ambil ekstensi file dalam huruf kapital.
     */
    public function getEkstensi($file): string
    {
        return strtoupper($file->getClientOriginalExtension() ?: 'FILE');
    }
}
