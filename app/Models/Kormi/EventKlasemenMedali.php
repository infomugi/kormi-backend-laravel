<?php

namespace App\Models\Kormi;

use App\Models\Master\Kecamatan;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventKlasemenMedali extends ModelDasar
{
    protected $table = 'event_klasemen_medali';

    protected $casts = [
        'jumlah_emas' => 'integer',
        'jumlah_perak' => 'integer',
        'jumlah_perunggu' => 'integer',
        'total_medali' => 'integer',
        'peringkat' => 'integer',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}
