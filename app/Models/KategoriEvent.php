<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriEvent extends ModelDasar
{
    protected $table = 'kormi_kategori_event';

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'kategori_event_id');
    }
}
