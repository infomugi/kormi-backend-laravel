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

    public function getFotoUrlAttribute(): string
    {
        $val = $this->attributes['foto_url'] ?? null;

        if (empty($val)) {
            return 'https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=800';
        }

        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($val) 
            ?? 'https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=800';
    }
}

