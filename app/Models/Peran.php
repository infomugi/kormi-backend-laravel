<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Peran extends ModelDasar
{
    protected $table = 'sys_peran';

    protected $casts = [
        'hak_akses' => 'array',
    ];

    /**
     * Definisi Master Modul / Hak Akses Menu CMS
     */
    public const DAFTAR_MODUL = [
        'media' => [
            'nama' => 'Publikasi Media & Berkas',
            'deskripsi' => 'Pengelolaan warta berita, galeri dokumentasi foto, dan berkas unduhan publik.',
            'items' => [
                'berita' => ['nama' => 'Berita & Warta', 'deskripsi' => 'Buat, edit, terbitkan berita & artikel warta KORMI', 'routes' => ['admin.berita', 'admin.berita.tambah', 'admin.berita.edit']],
                'galeri' => ['nama' => 'Galeri Foto & Album', 'deskripsi' => 'Kelola album kegiatan dan arsip foto dokumentasi', 'routes' => ['admin.galeri']],
                'unduhan' => ['nama' => 'Dokumen Unduhan', 'deskripsi' => 'Upload & kelola dokumen SK, formulir, dan regulasi', 'routes' => ['admin.unduhan']],
            ],
        ],
        'wilayah' => [
            'nama' => 'Wilayah & KORCAM',
            'deskripsi' => 'Pengelolaan duta olahraga kecamatan/desa, koordinator pendidikan, dan sarana prasarana.',
            'items' => [
                'duta' => ['nama' => 'Duta Olahraga', 'deskripsi' => 'Data duta olahraga di 31 kecamatan dan desa se-Kabupaten Bandung', 'routes' => ['admin.duta']],
                'kordik' => ['nama' => 'Kordik Kecamatan', 'deskripsi' => 'Struktur pengurus Kordik dan koordinator wilayah kecamatan', 'routes' => ['admin.kordik']],
                'sapras' => ['nama' => 'Sarana & Prasarana', 'deskripsi' => 'Inventaris lapangan, venue, dan sarana olahraga masyarakat', 'routes' => ['admin.sapras']],
            ],
        ],
        'olahraga' => [
            'nama' => 'INORGA & Kompetisi',
            'deskripsi' => 'Pengelolaan induk organisasi olahraga, komisi rumpun, event olahraga, dan perolehan medali.',
            'items' => [
                'inorga' => ['nama' => 'Induk Organisasi (INORGA)', 'deskripsi' => 'Daftar induk organisasi olahraga masyarakat binaan KORMI', 'routes' => ['admin.inorga']],
                'event' => ['nama' => 'Event & FORKAB', 'deskripsi' => 'Manajemen event festival olahraga rekreasi & kompetisi daerah', 'routes' => ['admin.event']],
                'klasemen' => ['nama' => 'Klasemen Medali', 'deskripsi' => 'Pencatatan perolehan medali FORKAB per kontingen / kecamatan', 'routes' => ['admin.klasemen']],
            ],
        ],
        'organisasi' => [
            'nama' => 'Kelembagaan & Program',
            'deskripsi' => 'Profil kelembagaan KORMI, visi misi, linimasa sejarah, jajaran pengurus, dan program kerja.',
            'items' => [
                'sejarah' => ['nama' => 'Linimasa Sejarah', 'deskripsi' => 'Perjalanan dan rekam jejak sejarah KORMI Kabupaten Bandung', 'routes' => ['admin.sejarah']],
                'visimisi' => ['nama' => 'Visi, Misi & Tujuan', 'deskripsi' => 'Rumusan visi misi, nilai organisasi, dan tujuan strategis', 'routes' => ['admin.visimisi']],
                'pengurus' => ['nama' => 'Struktur Pengurus', 'deskripsi' => 'Bagan kepengurusan, dewan penasehat, dan bidang organisasi', 'routes' => ['admin.pengurus']],
                'proker' => ['nama' => 'Program Kerja', 'deskripsi' => 'Kalender program kerja tahunan dan capaian kegiatan', 'routes' => ['admin.proker']],
            ],
        ],
        'anugerah' => [
            'nama' => 'Indeks & Penghargaan',
            'deskripsi' => 'Sport Development Index (SDI) dan Anugerah Penggerak Olahraga (APMO).',
            'items' => [
                'sdi' => ['nama' => 'Sport Development Index (SDI)', 'deskripsi' => 'Data dan capaian 9 dimensi indeks pembangunan olahraga', 'routes' => ['admin.sdi']],
                'apmo' => ['nama' => 'Anugerah APMO', 'deskripsi' => 'Kategori dan daftar penerima anugerah insan penggerak olahraga', 'routes' => ['admin.apmo']],
            ],
        ],
        'sistem' => [
            'nama' => 'Sistem & Pengaturan',
            'deskripsi' => 'Manajemen akun pengguna dan konfigurasi portal resmi.',
            'items' => [
                'pengguna' => ['nama' => 'Kelola Pengguna', 'deskripsi' => 'Manajemen akun admin, verifikasi pendaftaran, dan reset sandi', 'routes' => ['admin.pengguna']],
                'pengaturan' => ['nama' => 'Pengaturan Portal', 'deskripsi' => 'Konfigurasi identitas situs, kontak resmi, SEO, dan media sosial', 'routes' => ['admin.pengaturan']],
            ],
        ],
    ];

    public function pengguna(): HasMany
    {
        return $this->hasMany(Pengguna::class, 'peran_id');
    }

    /**
     * Cek apakah role memiliki izin untuk modul/fitur tertentu
     */
    public function punyaAkses(string $modulKey): bool
    {
        if ($this->slug === 'super-admin' || $this->slug === 'superadmin' || $this->slug === 'admin') {
            return true;
        }

        $akses = $this->hak_akses ?? [];
        return in_array($modulKey, $akses, true) || in_array('*', $akses, true);
    }
}
