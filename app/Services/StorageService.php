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

        // 2. Pastikan struktur gambar benar-benar valid (bukan berkas rusak / header palsu)
        $infoGambar = @getimagesize($realPath);
        $tipeGambarValid = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP, IMAGETYPE_GIF];

        if ($infoGambar === false || !in_array($infoGambar[2] ?? null, $tipeGambarValid, true)) {
            throw new \InvalidArgumentException('Berkas gambar rusak atau strukturnya tidak valid.');
        }

        // 3. Anti-Shell / Anti-Backdoor Scanner (hanya tag eksekusi PHP yang berbahaya).
        // Pola seperti eval()/system()/<script>/<% %> sengaja tidak dipakai untuk gambar karena
        // data biner JPEG/PNG/WEBP yang terkompresi dapat memuat urutan byte acak yang menyerupai
        // pola tersebut sehingga foto normal ikut tertolak (false positive). Short-echo `<?=`
        // (3 byte) juga dibuang dengan alasan yang sama — urutan `3C 3F 3D` bisa muncul acak di
        // data JPEG ber-entropi tinggi. Tag `<?php` dan `__halt_compiler` tetap diblokir. Objek
        // disimpan private + nama UUID dan hanya diakses via signed URL, jadi tidak pernah
        // dieksekusi sebagai PHP; pola yang lolos bukan risiko eksekusi.
        $content = file_get_contents($realPath);
        if ($this->containsPhpPayload($content)) {
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
        if ($this->containsPhpPayload($content)) {
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
     * Periksa apakah konten berkas mengandung tag pembuka PHP (indikator polyglot shell/backdoor).
     *
     * Sengaja hanya memindai tag PHP yang praktis tidak mungkin muncul acak pada data biner sah,
     * bukan nama fungsi (eval/system/exec) atau pola `<% %>`. Pola short-echo `<?=` (3 byte) juga
     * dibuang karena terlalu pendek: pada JPEG/PNG ber-entropi tinggi urutan byte `3C 3F 3D` dapat
     * muncul secara kebetulan sehingga foto normal ikut tertolak (false positive). Tag `<?php` dan
     * `__halt_compiler` tetap diblokir. Objek disimpan private di MinIO dengan nama UUID dan hanya
     * diakses lewat signed URL, sehingga tidak pernah dieksekusi sebagai PHP — pola yang lolos
     * bukan risiko eksekusi.
     */
    protected function containsPhpPayload(string $content): bool
    {
        $polaTagPhp = [
            '/<\?php/i',
            '/__halt_compiler\s*\(/i',
        ];

        foreach ($polaTagPhp as $pattern) {
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
     * Ambil isi mentah berkas dari MinIO (atau URL eksternal).
     */
    public function getIsiFile(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        try {
            return $this->isUrlEksternal($path)
                ? @file_get_contents($path)
                : Storage::disk($this->disk)->get($path);
        } catch (\Throwable $e) {
            return null;
        }
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
