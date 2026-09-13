<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\HasMany;

class SdiProgram extends ModelDasar
{
    protected $table = 'kormi_sdi_program';

    public function jadwal(): HasMany
    {
        return $this->hasMany(SdiJadwal::class, 'program_id');
    }
}
