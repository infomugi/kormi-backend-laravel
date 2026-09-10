<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApmoPenerima extends ModelDasar
{
    protected $table = 'kormi_apmo_penerima';

    public function tahun(): BelongsTo
    {
        return $this->belongsTo(ApmoTahun::class, 'apmo_tahun_id');
    }
}
