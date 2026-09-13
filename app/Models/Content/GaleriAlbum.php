<?php

namespace App\Models\Content;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\HasMany;

class GaleriAlbum extends ModelDasar
{
    protected $table = 'media_galeri_album';

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'status_tampil' => 'boolean',
    ];

    public function foto(): HasMany
    {
        return $this->hasMany(GaleriFoto::class, 'album_id')->orderBy('urutan', 'asc');
    }
}
