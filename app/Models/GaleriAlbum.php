<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class GaleriAlbum extends ModelDasar
{
    protected $table = 'kormi_galeri_album';

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'status_tampil' => 'boolean',
    ];

    public function foto(): HasMany
    {
        return $this->hasMany(GaleriFoto::class, 'album_id')->orderBy('urutan', 'asc');
    }
}
