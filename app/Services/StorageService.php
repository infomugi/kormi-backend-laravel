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
     * Dilengkapi validasi MIME asli, anti-shell, anti-backdoor, dan ekstensi whitelist.
     *
     * @param  TemporaryUploadedFile|UploadedFile  $file
     * @param  string  $folder  Folder tujuan (contoh: 'berita', 'galeri/foto')
     * @return string  Path file yang tersimpan di MinIO
     * @throws \InvalidArgumentException Jika file terdeteksi berbahaya atau bukan gambar valid.
     */
    public function uploadGambar($file, string $folder = 'gambar'): string
    {
        $realPath = $file->getRealPath();
        if (!$realPath || !file_exists($realPath)) {
            throw new \InvalidArgumentException('Berkas tidak ditemukan atau gagal diunggah.');
        }

        // 1. Validasi MIME Type Asli (Magic Byte Inspection)
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($realPath);

        $allowedMimes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
        ];

        if (!isset($allowedMimes[$mime])) {
            throw new \InvalidArgumentException('Format berkas gambar tidak valid atau tidak diizinkan. Hanya diperbolehkan JPG, PNG, WEBP, dan GIF.');
        }

        // 2. Anti-Shell / Anti-Backdoor Scanner (Cek Payload PHP/Executable di dalam konten gambar)
        $content = file_get_contents($realPath);
        if ($this->containsExecutablePayload($content)) {
            throw new \InvalidArgumentException('Berkas ditolak karena mengandung pola kode berbahaya / skrip tidak sah.');
        }

        // 3. Sanitasi Ekstensi & Nama File (UUID acak murni, mencegah path traversal dan ekstensi ganda seperti shell.php.jpg)
        $ekstensi = $allowedMimes[$mime];
        $namaFile = Str::uuid() . '.' . $ekstensi;
        $path = trim($folder, '/') . '/' . $namaFile;

        Storage::disk($this->disk)->put(
            $path,
            $content,
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
        $realPath = $file->getRealPath();
        if (!$realPath || !file_exists($realPath)) {
            throw new \InvalidArgumentException('Berkas tidak ditemukan.');
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($realPath);

        $allowedMimes = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/zip' => 'zip',
        ];

        if (!isset($allowedMimes[$mime])) {
            throw new \InvalidArgumentException('Format dokumen tidak didukung atau dilarang.');
        }

        $content = file_get_contents($realPath);
        if ($this->containsExecutablePayload($content)) {
            throw new \InvalidArgumentException('Berkas ditolak karena mengandung kode berbahaya.');
        }

        $ekstensi = $allowedMimes[$mime];
        $namaFile = Str::uuid() . '.' . $ekstensi;
        $path = trim($folder, '/') . '/' . $namaFile;

        Storage::disk($this->disk)->put(
            $path,
            $content,
            'private'
        );

        return $path;
    }

    /**
     * Periksa apakah konten berkas mengandung payload shell/backdoor PHP/ASP/JSP/CGI atau tag eksekusi berbahaya.
     */
    protected function containsExecutablePayload(string $content): bool
    {
        // Pola berbahaya umum pada polyglot image, webshell, backdoor
        $suspiciousPatterns = [
            '/<\?php/i',
            '/<\?=/i',
            '/<script[\s\S]*?>/i',
            '/eval\s*\(/i',
            '/base64_decode\s*\(/i',
            '/system\s*\(/i',
            '/exec\s*\(/i',
            '/shell_exec\s*\(/i',
            '/passthru\s*\(/i',
            '/proc_open\s*\(/i',
            '/popen\s*\(/i',
            '/__halt_compiler\s*\(/i',
            '/<%.*?%>/s', // ASP tags
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
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
