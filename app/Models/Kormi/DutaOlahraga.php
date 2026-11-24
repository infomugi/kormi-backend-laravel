<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;
use App\Models\Core\Pengguna;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DutaOlahraga extends ModelDasar
{
    public const STATUS_MENUNGGU = 'menunggu';
    public const STATUS_DISETUJUI = 'disetujui';
    public const STATUS_DITOLAK = 'ditolak';

    protected $table = 'kormi_duta_olahraga';

    protected $fillable = [
        'id',
        'kecamatan_id',
        'desa_kelurahan_id',
        'nama_lengkap',
        'tahun_pemilihan',
        'kategori_duta',
        'gelar_prestasi',
        'deskripsi_prestasi',
        'akun_instagram',
        'nomor_telepon',
        'email',
        'jenis_kelamin',
        'pekerjaan_profesi',
        'pendidikan_terakhir',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_domisili',
        'foto_url',
        'status_aktif',
        'status_unggulan',
        'status_pendaftaran',
        'disetujui_pada',
        'disetujui_oleh',
        'catatan_verifikasi',
        'pengguna_id',
    ];

    protected $casts = [
        'tahun_pemilihan' => 'integer',
        'status_aktif'    => 'boolean',
        'status_unggulan' => 'boolean',
        'tanggal_lahir'   => 'date',
        'disetujui_pada'  => 'datetime',
    ];

    /**
     * Hanya data yang sudah disetujui administrator.
     */
    public function scopeDisetujui(Builder $query): Builder
    {
        return $query->where('status_pendaftaran', self::STATUS_DISETUJUI);
    }

    /**
     * Data pendaftaran yang masih menunggu verifikasi.
     */
    public function scopeMenunggu(Builder $query): Builder
    {
        return $query->where('status_pendaftaran', self::STATUS_MENUNGGU);
    }

    public function sedangMenunggu(): bool
    {
        return $this->status_pendaftaran === self::STATUS_MENUNGGU;
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function desaKelurahan(): BelongsTo
    {
        return $this->belongsTo(DesaKelurahan::class, 'desa_kelurahan_id');
    }

    public function partisipasi(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PartisipasiAktivitas::class, 'duta_id');
    }

    public function pengguna(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\Core\Pengguna::class, 'duta_id');
    }

    /**
     * Akun pengguna pemilik pendaftaran (diisi sejak submit, ditautkan saat disetujui).
     */
    public function akunPendaftar(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function disetujuiOleh(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'disetujui_oleh');
    }

    public function getFotoDutaUrlAttribute(): ?string
    {
        $val = $this->attributes['foto_url'] ?? null;

        if (empty($val)) {
            return null;
        }

        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($val);
    }

    public function getInitialDuaHurufAttribute(): string
    {
        $words = preg_split('/\s+/', trim($this->nama_lengkap ?: 'Duta'));
        if (count($words) >= 2) {
            return strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
        }
        return strtoupper(mb_substr($this->nama_lengkap ?: 'DU', 0, 2));
    }

    /**
     * Helper backward compatibility: get prestasis alias
     */
    public function getPrestasiAttribute(): ?string
    {
        return $this->deskripsi_prestasi ?: $this->gelar_prestasi;
    }

    /**
     * Helper backward compatibility: get kontak alias
     */
    public function getKontakAttribute(): ?string
    {
        return $this->nomor_telepon ?: $this->akun_instagram;
    }
}

