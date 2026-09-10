<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SdiPeserta extends ModelDasar
{
    protected $table = 'kormi_sdi_peserta';

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(SdiJadwal::class, 'jadwal_id');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}
