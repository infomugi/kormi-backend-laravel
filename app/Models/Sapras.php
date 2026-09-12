<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sapras extends ModelDasar
{
    protected $table = 'sarpras_fasilitas';

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}
