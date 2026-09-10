<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriFoto extends ModelDasar
{
    protected $table = 'kormi_galeri_foto';

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(GaleriAlbum::class, 'album_id');
    }
}
