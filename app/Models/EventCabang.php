<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCabang extends ModelDasar
{
    protected $table = 'kormi_event_cabang';

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function inorga(): BelongsTo
    {
        return $this->belongsTo(Inorga::class, 'inorga_id');
    }
}
