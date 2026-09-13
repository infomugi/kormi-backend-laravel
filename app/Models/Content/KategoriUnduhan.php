<?php

namespace App\Models\Content;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriUnduhan extends ModelDasar
{
    protected $table = 'media_kategori_unduhan';

    public function unduhan(): HasMany
    {
        return $this->hasMany(Unduhan::class, 'kategori_id');
    }
}
