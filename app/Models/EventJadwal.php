<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventJadwal extends ModelDasar
{
    protected $table = 'event_jadwal';

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
