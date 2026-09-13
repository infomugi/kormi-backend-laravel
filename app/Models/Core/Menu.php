<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'sys_menu';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'grup',
        'induk_id',
        'nama',
        'tautan',
        'icon',
        'target',
        'urutan',
        'status_aktif',
        'badge',
        'hak_akses',
        'deskripsi',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke menu induk
     */
    public function induk(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'induk_id');
    }

    /**
     * Relasi ke submenu anak
     */
    public function anak(): HasMany
    {
        return $this->hasMany(Menu::class, 'induk_id')->orderBy('urutan', 'asc');
    }

    /**
     * Scope menu utama (tanpa induk)
     */
    public function scopeUtama(Builder $query): Builder
    {
        return $query->whereNull('induk_id');
    }

    /**
     * Scope menu aktif
     */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status_aktif', true);
    }

    /**
     * Scope grup tertentu
     */
    public function scopeGrup(Builder $query, string $grup): Builder
    {
        return $query->where('grup', $grup);
    }

    /**
     * Sinkronisasi data menu default KORMI
     */
    public static function sinkronkanDefault(?string $grup = null): void
    {
        if (!$grup || $grup === 'frontend_header') {
            self::sinkronkanFrontendHeader();
        }

        if (!$grup || $grup === 'frontend_footer') {
            self::sinkronkanFrontendFooter();
        }

        if (!$grup || $grup === 'backend_sidebar') {
            self::sinkronkanBackendSidebar();
        }
    }

    private static function sinkronkanFrontendHeader(): void
    {
        $items = [
            ['nama' => 'Beranda', 'tautan' => '/', 'icon' => 'home', 'urutan' => 1],
            [
                'nama' => 'Profil', 'tautan' => '#', 'icon' => 'info', 'urutan' => 2,
                'sub' => [
                    ['nama' => 'Sejarah KORMI', 'tautan' => '/sejarah', 'icon' => 'book-open', 'urutan' => 1],
                    ['nama' => 'Visi & Misi', 'tautan' => '/visi-misi', 'icon' => 'target', 'urutan' => 2],
                    ['nama' => 'Struktur Pengurus', 'tautan' => '/pengurus', 'icon' => 'users', 'urutan' => 3],
                    ['nama' => 'KORCAM (Koordinator Kecamatan)', 'tautan' => '/kordik-kecamatan', 'icon' => 'map-pin', 'urutan' => 4],
                    ['nama' => 'Program Kerja', 'tautan' => '/proker', 'icon' => 'calendar-check', 'urutan' => 5],
                ]
            ],
            [
                'nama' => 'Keolahragaan', 'tautan' => '#', 'icon' => 'trophy', 'urutan' => 3,
                'sub' => [
                    ['nama' => 'Direktori Inorga (Induk Olahraga)', 'tautan' => '/inorga', 'icon' => 'layers', 'urutan' => 1],
                    ['nama' => 'Duta Olahraga Masyarakat', 'tautan' => '/duta-olahraga', 'icon' => 'award', 'urutan' => 2],
                    ['nama' => 'Pelatihan & Sertifikasi SDI', 'tautan' => '/sdi', 'icon' => 'graduation-cap', 'urutan' => 3],
                    ['nama' => 'Sarana & Prasarana (Sapras)', 'tautan' => '/sapras', 'icon' => 'building-2', 'urutan' => 4],
                ]
            ],
            [
                'nama' => 'Partisipasi Warga', 'tautan' => '#', 'icon' => 'activity', 'urutan' => 4,
                'sub' => [
                    ['nama' => 'Catat Aktivitas Olahraga', 'tautan' => '/partisipasi/catat', 'icon' => 'clipboard-pen', 'urutan' => 1],
                    ['nama' => 'Riwayat & Badge APMO Saya', 'tautan' => '/partisipasi/riwayat', 'icon' => 'sparkles', 'urutan' => 2],
                    ['nama' => 'Tentang APMO & Indeks Partisipasi', 'tautan' => '/apmo', 'icon' => 'bar-chart-3', 'urutan' => 3],
                ]
            ],
            [
                'nama' => 'Event', 'tautan' => '#', 'icon' => 'calendar', 'urutan' => 5,
                'sub' => [
                    ['nama' => 'FORKAB (Festival Olahraga Kab. Bandung)', 'tautan' => '/forkab', 'icon' => 'flame', 'urutan' => 1],
                    ['nama' => 'FOTRADKAB (Olahraga Tradisional)', 'tautan' => '/fotradkab', 'icon' => 'swords', 'urutan' => 2],
                    ['nama' => 'Bandung Bedas Run', 'tautan' => 'https://bandungbedasrun.kormibdg.id', 'icon' => 'external-link', 'target' => '_blank', 'urutan' => 3],
                ]
            ],
            [
                'nama' => 'Media & Publikasi', 'tautan' => '#', 'icon' => 'newspaper', 'urutan' => 6,
                'sub' => [
                    ['nama' => 'Berita & Warta Olahraga', 'tautan' => '/berita', 'icon' => 'file-text', 'urutan' => 1],
                    ['nama' => 'Galeri Foto & Dokumentasi', 'tautan' => '/galeri', 'icon' => 'image', 'urutan' => 2],
                    ['nama' => 'Pusat Unduhan & Dokumen', 'tautan' => '/unduhan', 'icon' => 'download', 'urutan' => 3],
                ]
            ],
            ['nama' => 'Kontak', 'tautan' => '/kontak', 'icon' => 'phone', 'urutan' => 7],
        ];

        self::where('grup', 'frontend_header')->delete();

        foreach ($items as $item) {
            $parent = self::create([
                'id' => (string) Str::uuid(),
                'grup' => 'frontend_header',
                'nama' => $item['nama'],
                'tautan' => $item['tautan'],
                'icon' => $item['icon'] ?? null,
                'target' => $item['target'] ?? '_self',
                'urutan' => $item['urutan'],
                'status_aktif' => true,
            ]);

            if (isset($item['sub'])) {
                foreach ($item['sub'] as $sub) {
                    self::create([
                        'id' => (string) Str::uuid(),
                        'grup' => 'frontend_header',
                        'induk_id' => $parent->id,
                        'nama' => $sub['nama'],
                        'tautan' => $sub['tautan'],
                        'icon' => $sub['icon'] ?? null,
                        'target' => $sub['target'] ?? '_self',
                        'urutan' => $sub['urutan'],
                        'status_aktif' => true,
                    ]);
                }
            }
        }
    }

    private static function sinkronkanFrontendFooter(): void
    {
        $items = [
            ['nama' => 'Beranda Utama', 'tautan' => '/', 'icon' => 'home', 'urutan' => 1],
            ['nama' => 'Berita & Warta Terkini', 'tautan' => '/berita', 'icon' => 'newspaper', 'urutan' => 2],
            ['nama' => 'Direktori Induk Olahraga (INORGA)', 'tautan' => '/inorga', 'icon' => 'layers', 'urutan' => 3],
            ['nama' => 'Klasemen Medali FORKAB', 'tautan' => '/forkab', 'icon' => 'trophy', 'urutan' => 4],
            ['nama' => 'Partisipasi Warga (APMO)', 'tautan' => '/partisipasi/catat', 'icon' => 'activity', 'urutan' => 5],
            ['nama' => 'Hubungi KORMI Kab. Bandung', 'tautan' => '/kontak', 'icon' => 'phone', 'urutan' => 6],
            ['nama' => 'Portal CMS Pengurus', 'tautan' => '/admin/masuk', 'icon' => 'lock', 'urutan' => 7],
        ];

        self::where('grup', 'frontend_footer')->delete();

        foreach ($items as $item) {
            self::create([
                'id' => (string) Str::uuid(),
                'grup' => 'frontend_footer',
                'nama' => $item['nama'],
                'tautan' => $item['tautan'],
                'icon' => $item['icon'] ?? null,
                'target' => $item['target'] ?? '_self',
                'urutan' => $item['urutan'],
                'status_aktif' => true,
            ]);
        }
    }

    private static function sinkronkanBackendSidebar(): void
    {
        $items = [
            ['nama' => 'Dashboard Utama', 'tautan' => 'admin.dashboard', 'icon' => 'layout-dashboard', 'urutan' => 1],
            [
                'nama' => 'Publikasi & Media', 'tautan' => '#', 'icon' => 'newspaper', 'urutan' => 2,
                'sub' => [
                    ['nama' => 'Berita & Artikel', 'tautan' => 'admin.berita', 'icon' => 'file-text', 'urutan' => 1],
                    ['nama' => 'Galeri Foto & Video', 'tautan' => 'admin.galeri', 'icon' => 'image', 'urutan' => 2],
                    ['nama' => 'Pusat Unduhan & Dokumen', 'tautan' => 'admin.unduhan', 'icon' => 'download', 'urutan' => 3],
                ]
            ],
            [
                'nama' => 'Keolahragaan & Kecamatan', 'tautan' => '#', 'icon' => 'trophy', 'urutan' => 3,
                'sub' => [
                    ['nama' => 'Induk Olahraga (INORGA)', 'tautan' => 'admin.inorga', 'icon' => 'layers', 'urutan' => 1],
                    ['nama' => 'Duta Olahraga', 'tautan' => 'admin.duta', 'icon' => 'award', 'urutan' => 2],
                    ['nama' => 'Koordinator Kecamatan (KORCAM)', 'tautan' => 'admin.kordik', 'icon' => 'map-pin', 'urutan' => 3],
                    ['nama' => 'Sarana & Prasarana', 'tautan' => 'admin.sapras', 'icon' => 'building-2', 'urutan' => 4],
                    ['nama' => 'Sumber Daya Insani (SDI)', 'tautan' => 'admin.sdi', 'icon' => 'graduation-cap', 'urutan' => 5],
                ]
            ],
            [
                'nama' => 'Kejuaraan & Partisipasi', 'tautan' => '#', 'icon' => 'flame', 'urutan' => 4,
                'sub' => [
                    ['nama' => 'Event & Kejuaraan', 'tautan' => 'admin.event', 'icon' => 'calendar', 'urutan' => 1],
                    ['nama' => 'Klasemen Medali FORKAB', 'tautan' => 'admin.klasemen', 'icon' => 'medal', 'urutan' => 2],
                    ['nama' => 'Partisipasi Warga (APMO)', 'tautan' => 'admin.partisipasi.log', 'icon' => 'activity', 'urutan' => 3],
                    ['nama' => 'Statistik & Indeks Partisipasi', 'tautan' => 'admin.partisipasi.statistik', 'icon' => 'bar-chart-3', 'urutan' => 4],
                ]
            ],
            [
                'nama' => 'Profil & Organisasi', 'tautan' => '#', 'icon' => 'building', 'urutan' => 5,
                'sub' => [
                    ['nama' => 'Sejarah KORMI', 'tautan' => 'admin.sejarah', 'icon' => 'book-open', 'urutan' => 1],
                    ['nama' => 'Visi & Misi', 'tautan' => 'admin.visimisi', 'icon' => 'target', 'urutan' => 2],
                    ['nama' => 'Pengurus KORMI', 'tautan' => 'admin.pengurus', 'icon' => 'users', 'urutan' => 3],
                    ['nama' => 'Program Kerja', 'tautan' => 'admin.proker', 'icon' => 'calendar-check', 'urutan' => 4],
                ]
            ],
            [
                'nama' => 'Pengaturan & Akses', 'tautan' => '#', 'icon' => 'settings', 'urutan' => 6,
                'sub' => [
                    ['nama' => 'Kelola Pengguna CMS', 'tautan' => 'admin.pengguna', 'icon' => 'user-cog', 'urutan' => 1],
                    ['nama' => 'Peran & Hak Akses (RBAC)', 'tautan' => 'admin.peran', 'icon' => 'shield', 'urutan' => 2],
                    ['nama' => 'Menu Navigasi Web & CMS', 'tautan' => 'admin.menu', 'icon' => 'menu', 'urutan' => 3],
                    ['nama' => 'Pengaturan Situs', 'tautan' => 'admin.pengaturan', 'icon' => 'sliders', 'urutan' => 4],
                ]
            ]
        ];

        self::where('grup', 'backend_sidebar')->delete();

        foreach ($items as $item) {
            $parent = self::create([
                'id' => (string) Str::uuid(),
                'grup' => 'backend_sidebar',
                'nama' => $item['nama'],
                'tautan' => $item['tautan'],
                'icon' => $item['icon'] ?? null,
                'target' => '_self',
                'urutan' => $item['urutan'],
                'status_aktif' => true,
            ]);

            if (isset($item['sub'])) {
                foreach ($item['sub'] as $sub) {
                    self::create([
                        'id' => (string) Str::uuid(),
                        'grup' => 'backend_sidebar',
                        'induk_id' => $parent->id,
                        'nama' => $sub['nama'],
                        'tautan' => $sub['tautan'],
                        'icon' => $sub['icon'] ?? null,
                        'target' => '_self',
                        'urutan' => $sub['urutan'],
                        'status_aktif' => true,
                    ]);
                }
            }
        }
    }
}
