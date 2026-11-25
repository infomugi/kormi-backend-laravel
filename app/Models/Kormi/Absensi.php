<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;
use App\Models\Core\Pengguna;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends ModelDasar
{
    use SoftDeletes;

    const DELETED_AT = 'dihapus_pada';

    protected $table = 'kormi_absensi';

    protected $fillable = [
        'pengguna_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'latitude',
        'longitude',
        'akurasi_meter',
        'alamat',
        'foto_masuk',
        'latitude_pulang',
        'longitude_pulang',
        'akurasi_meter_pulang',
        'alamat_pulang',
        'foto_pulang',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'latitude' => 'float',
        'longitude' => 'float',
        'akurasi_meter' => 'float',
        'latitude_pulang' => 'float',
        'longitude_pulang' => 'float',
        'akurasi_meter_pulang' => 'float',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function sudahPulang(): bool
    {
        return $this->jam_pulang !== null;
    }

    public function getJamMasukRapiAttribute(): ?string
    {
        return $this->jam_masuk ? substr($this->jam_masuk, 0, 5) : null;
    }

    public function getJamPulangRapiAttribute(): ?string
    {
        return $this->jam_pulang ? substr($this->jam_pulang, 0, 5) : null;
    }

    public function getFotoMasukUrlAttribute(): ?string
    {
        if (empty($this->foto_masuk)) {
            return null;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($this->foto_masuk);
    }

    public function getFotoPulangUrlAttribute(): ?string
    {
        if (empty($this->foto_pulang)) {
            return null;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($this->foto_pulang);
    }
}
