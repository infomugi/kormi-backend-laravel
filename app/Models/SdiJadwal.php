<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SdiJadwal extends ModelDasar
{
    protected $table = 'kormi_sdi_jadwal';

    public function program(): BelongsTo
    {
        return $this->belongsTo(SdiProgram::class, 'program_id');
    }

    public function peserta(): HasMany
    {
        return $this->hasMany(SdiPeserta::class, 'jadwal_id');
    }
}
