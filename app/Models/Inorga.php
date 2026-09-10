<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inorga extends ModelDasar
{
    protected $table = 'kormi_inorga';

    protected $casts = [
        'tanggal_sk' => 'date',
        'jumlah_klub_anggota' => 'integer',
    ];

    public function komisi(): BelongsTo
    {
        return $this->belongsTo(KomisiInorga::class, 'komisi_id');
    }

    public function eventCabang(): HasMany
    {
        return $this->hasMany(EventCabang::class, 'inorga_id');
    }
}
