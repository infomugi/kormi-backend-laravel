<?php

namespace App\Livewire\Mobile;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.mobile')]
#[Title('Layanan - KORMI Kabupaten Bandung')]
class Layanan extends Component
{
    public function render()
    {
        $user = auth()->user();

        $modulCms = [
            'berita' => ['nama' => 'Berita & Warta', 'desc' => 'Kelola publikasi berita KORMI', 'icon' => 'newspaper', 'route' => 'admin.berita'],
            'galeri' => ['nama' => 'Galeri Foto', 'desc' => 'Album dan dokumentasi kegiatan', 'icon' => 'camera', 'route' => 'admin.galeri'],
            'unduhan' => ['nama' => 'Dokumen Unduhan', 'desc' => 'SK, formulir, dan regulasi', 'icon' => 'download', 'route' => 'admin.unduhan'],
            'duta' => ['nama' => 'Duta Olahraga', 'desc' => 'Verifikasi pendaftaran duta', 'icon' => 'users', 'route' => 'admin.duta'],
            'kordik' => ['nama' => 'Kordik Kecamatan', 'desc' => 'Pengurus koordinator wilayah', 'icon' => 'map', 'route' => 'admin.kordik'],
            'sapras' => ['nama' => 'Sarana Prasarana', 'desc' => 'Inventaris venue olahraga', 'icon' => 'building-2', 'route' => 'admin.sapras'],
            'inorga' => ['nama' => 'INORGA', 'desc' => 'Induk organisasi olahraga', 'icon' => 'award', 'route' => 'admin.inorga'],
            'event' => ['nama' => 'Event & FORKAB', 'desc' => 'Agenda festival olahraga', 'icon' => 'flag', 'route' => 'admin.event'],
            'klasemen' => ['nama' => 'Klasemen Medali', 'desc' => 'Perolehan medali kecamatan', 'icon' => 'trophy', 'route' => 'admin.klasemen'],
            'partisipasi' => ['nama' => 'Partisipasi APMO', 'desc' => 'Verifikasi aktivitas warga', 'icon' => 'activity', 'route' => 'admin.partisipasi.log'],
            'pengguna' => ['nama' => 'Pengguna', 'desc' => 'Akun dan hak akses', 'icon' => 'user-cog', 'route' => 'admin.pengguna'],
            'pengaturan' => ['nama' => 'Pengaturan Situs', 'desc' => 'Konfigurasi portal KORMI', 'icon' => 'settings', 'route' => 'admin.pengaturan'],
        ];

        $aksesCms = match (true) {
            $user->isSuperAdmin() => array_keys($modulCms),
            $user->isEditorBerita() => ['berita', 'galeri', 'unduhan'],
            $user->isAdminKorcam() => ['duta', 'kordik', 'sapras'],
            $user->isAdminInorga() => ['inorga', 'event', 'klasemen'],
            default => [],
        };

        $layananPartisipasi = [];

        if ($user->isDutaOlahraga() || $user->isPegiatOlahraga()) {
            $layananPartisipasi[] = ['nama' => 'Catat Aktivitas', 'desc' => 'Catat sesi olahraga untuk APMO', 'icon' => 'clipboard-pen', 'route' => 'partisipasi.catat'];
            $layananPartisipasi[] = ['nama' => 'Riwayat Aktivitas', 'desc' => 'Status verifikasi dan badge APMO', 'icon' => 'history', 'route' => 'partisipasi.riwayat'];

            if (! $user->duta) {
                $layananPartisipasi[] = ['nama' => 'Daftar Duta', 'desc' => 'Ajukan diri sebagai duta olahraga desa', 'icon' => 'user-plus', 'route' => 'mobile.daftar-duta'];
            }
        }

        $informasiPublik = [
            ['nama' => 'Direktori Duta', 'desc' => 'Cari duta olahraga desa', 'icon' => 'users', 'route' => 'mobile.direktori-duta'],
            ['nama' => 'Berita KORMI', 'desc' => 'Warta dan artikel terbaru', 'icon' => 'newspaper', 'route' => 'mobile.berita'],
            ['nama' => 'Program APMO', 'desc' => 'Anugerah Peserta Olahraga Masyarakat', 'icon' => 'trophy', 'route' => 'apmo'],
            ['nama' => 'SDI', 'desc' => 'Sumber daya insani keolahragaan', 'icon' => 'graduation-cap', 'route' => 'sdi'],
            ['nama' => 'Sapras', 'desc' => 'Sarana dan prasarana olahraga', 'icon' => 'building-2', 'route' => 'sapras'],
            ['nama' => 'Unduhan', 'desc' => 'Dokumen dan formulir publik', 'icon' => 'download', 'route' => 'unduhan'],
            ['nama' => 'Kontak', 'desc' => 'Hubungi sekretariat KORMI', 'icon' => 'message-square', 'route' => 'kontak'],
        ];

        $badgePeran = match (true) {
            $user->isSuperAdmin() => 'Super Admin',
            $user->isAdminKorcam() => 'Korcam',
            $user->isAdminInorga() => 'Inorga',
            $user->isEditorBerita() => 'Editor',
            $user->isDutaOlahraga() => 'Duta',
            default => 'Pegiat',
        };

        return view('livewire.mobile.layanan', [
            'user' => $user,
            'roleLabel' => $user->peran?->nama_peran ?? 'Pengguna',
            'badgePeran' => $badgePeran,
            'layananPartisipasi' => $layananPartisipasi,
            'modulCms' => array_values(array_intersect_key($modulCms, array_flip($aksesCms))),
            'informasiPublik' => $informasiPublik,
        ]);
    }
}
