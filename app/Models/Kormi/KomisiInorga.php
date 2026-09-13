<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\HasMany;

class KomisiInorga extends ModelDasar
{
    protected $table = 'kormi_komisi_inorga';

    public function inorga(): HasMany
    {
        return $this->hasMany(Inorga::class, 'komisi_id');
    }
}
