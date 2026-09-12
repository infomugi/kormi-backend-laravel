<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KordikPengurus extends ModelDasar
{
    protected $table = 'kormi_kordik_pengurus';

    protected $fillable = [
        'id',
        'kecamatan_id',
        'periode_id',
        'nama_ketua',
        'nama_sekretaris',
        'nama_bendahara',
        'nomor_telepon',
        'nomor_sk',
        'foto_ketua_url',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeKepengurusan::class, 'periode_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    public function getFotoKetuaFullUrlAttribute(): ?string
    {
        if (empty($this->foto_ketua_url)) {
            return null;
        }

        if (str_starts_with($this->foto_ketua_url, 'http://') || str_starts_with($this->foto_ketua_url, 'https://')) {
            return $this->foto_ketua_url;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($this->foto_ketua_url);
    }
}
