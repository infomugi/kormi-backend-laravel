<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sapras extends ModelDasar
{
    protected $table = 'kormi_sapras';

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}
