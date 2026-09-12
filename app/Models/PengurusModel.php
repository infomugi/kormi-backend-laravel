<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengurusModel extends ModelDasar
{
    protected $table = 'kormi_pengurus';

    protected $fillable = [
        'id',
        'periode_id',
        'nama_lengkap',
        'jabatan',
        'kategori_bidang',
        'foto_url',
        'urutan',
        'status_tampil',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'status_tampil' => 'boolean',
    ];

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeKepengurusan::class, 'periode_id');
    }

    public function scopeTampil($query)
    {
        return $query->where('status_tampil', true);
    }

    public function scopeUrut($query)
    {
        return $query->orderBy('urutan');
    }

    public function getFotoFullUrlAttribute(): ?string
    {
        if (empty($this->foto_url)) {
            return null;
        }

        if (str_starts_with($this->foto_url, 'http://') || str_starts_with($this->foto_url, 'https://')) {
            return $this->foto_url;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($this->foto_url);
    }
}
