<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;
use App\Models\Master\Kecamatan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApmoTargetWilayah extends ModelDasar
{
    protected $table = 'kormi_apmo_target_wilayah';

    protected $fillable = [
        'tahun',
        'kecamatan_id',
        'estimasi_populasi',
        'target_persen_apmo',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'estimasi_populasi' => 'integer',
        'target_persen_apmo' => 'float',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}
