<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;

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

    public function getInitialDuaHurufAttribute(): string
    {
        $nama = preg_replace('/^(h\.|hj\.|dr\.|drs\.|ir\.|prof\.)\s+/i', '', trim($this->nama_lengkap ?? ''));
        $words = preg_split('/\s+/', $nama);
        if (empty($words) || empty($words[0])) {
            return 'KM';
        }
        if (count($words) === 1) {
            return strtoupper(substr($words[0], 0, 2));
        }
        return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
    }
}
