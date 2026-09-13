<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodeKepengurusan extends ModelDasar
{
    protected $table = 'kormi_periode_kepengurusan';

    protected $casts = [
        'tahun_mulai' => 'integer',
        'tahun_selesai' => 'integer',
        'status_aktif' => 'boolean',
    ];

    public function pengurus(): HasMany
    {
        return $this->hasMany(PengurusModel::class, 'periode_id');
    }

    public function kordik(): HasMany
    {
        return $this->hasMany(KordikPengurus::class, 'periode_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    /**
     * Format label periode: "2024-2028"
     */
    public function getLabelPeriodeAttribute(): string
    {
        return $this->tahun_mulai . '-' . $this->tahun_selesai;
    }
}
