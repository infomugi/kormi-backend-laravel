<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DesaKelurahan extends ModelDasar
{
    protected $table = 'kormi_desa_kelurahan';

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function dutaOlahraga(): HasMany
    {
        return $this->hasMany(DutaOlahraga::class, 'desa_kelurahan_id');
    }
}
