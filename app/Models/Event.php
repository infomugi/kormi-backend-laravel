<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends ModelDasar
{
    protected $table = 'kormi_event';

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'status_publikasi' => 'boolean',
        'tahun_edisi' => 'integer',
    ];

    public function cabang(): HasMany
    {
        return $this->hasMany(EventCabang::class, 'event_id');
    }

    public function klasemen(): HasMany
    {
        return $this->hasMany(EventKlasemenMedali::class, 'event_id');
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(EventJadwal::class, 'event_id');
    }
}
