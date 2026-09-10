<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class SdiProgram extends ModelDasar
{
    protected $table = 'kormi_sdi_program';

    public function jadwal(): HasMany
    {
        return $this->hasMany(SdiJadwal::class, 'program_id');
    }
}
