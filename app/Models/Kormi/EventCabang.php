<?php

namespace App\Models\Kormi;

use App\Models\Kormi\Inorga;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCabang extends ModelDasar
{
    protected $table = 'event_cabang';

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function inorga(): BelongsTo
    {
        return $this->belongsTo(Inorga::class, 'inorga_id');
    }
}
