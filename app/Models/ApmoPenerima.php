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

    public function getFotoUrlAttribute(): ?string
    {
        $val = $this->attributes['foto_url'] ?? null;

        if (empty($val)) {
            return null;
        }

        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($val);
    }
}

