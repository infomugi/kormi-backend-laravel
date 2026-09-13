<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\HasMany;

class ApmoTahun extends ModelDasar
{
    protected $table = 'kormi_apmo_tahun';

    public function penerima(): HasMany
    {
        return $this->hasMany(ApmoPenerima::class, 'apmo_tahun_id');
    }
}
