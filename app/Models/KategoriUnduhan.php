<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriUnduhan extends ModelDasar
{
    protected $table = 'kormi_kategori_unduhan';

    public function unduhan(): HasMany
    {
        return $this->hasMany(Unduhan::class, 'kategori_id');
    }
}
