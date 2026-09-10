<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBerita extends ModelDasar
{
    protected $table = 'kormi_kategori_berita';

    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'kategori_id');
    }
}
