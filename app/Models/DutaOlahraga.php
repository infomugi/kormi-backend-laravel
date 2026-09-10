<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DutaOlahraga extends ModelDasar
{
    protected $table = 'kormi_duta_olahraga';

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function desaKelurahan(): BelongsTo
    {
        return $this->belongsTo(DesaKelurahan::class, 'desa_kelurahan_id');
    }
}
