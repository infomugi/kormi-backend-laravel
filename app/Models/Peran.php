<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Peran extends ModelDasar
{
    protected $table = 'kormi_peran';

    public function pengguna(): HasMany
    {
        return $this->hasMany(Pengguna::class, 'peran_id');
    }
}
