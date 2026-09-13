<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriEvent extends ModelDasar
{
    protected $table = 'event_kategori';

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'kategori_event_id');
    }
}
