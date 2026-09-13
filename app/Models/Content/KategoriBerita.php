<?php

namespace App\Models\Content;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBerita extends ModelDasar
{
    protected $table = 'media_kategori_berita';

    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'kategori_id');
    }
}
