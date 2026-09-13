<?php

namespace App\Models\Master;

use App\Models\Kormi\Sapras;

use App\Models\Kormi\DutaOlahraga;

use App\Models\Kormi\KordikPengurus;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends ModelDasar
{
    protected $table = 'ref_kecamatan';

    public function desaKelurahan(): HasMany
    {
        return $this->hasMany(DesaKelurahan::class, 'kecamatan_id');
    }

    public function kordikPengurus(): HasMany
    {
        return $this->hasMany(KordikPengurus::class, 'kecamatan_id');
    }

    public function dutaOlahraga(): HasMany
    {
        return $this->hasMany(DutaOlahraga::class, 'kecamatan_id');
    }

    public function sapras(): HasMany
    {
        return $this->hasMany(Sapras::class, 'kecamatan_id');
    }

    public function partisipasi(): HasMany
    {
        return $this->hasMany(\App\Models\Kormi\PartisipasiAktivitas::class, 'kecamatan_id');
    }
}
