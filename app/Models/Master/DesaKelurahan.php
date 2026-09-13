<?php

namespace App\Models\Master;

use App\Models\Kormi\DutaOlahraga;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DesaKelurahan extends ModelDasar
{
    protected $table = 'ref_desa_kelurahan';

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function dutaOlahraga(): HasMany
    {
        return $this->hasMany(DutaOlahraga::class, 'desa_kelurahan_id');
    }
}
