<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unduhan extends ModelDasar
{
    use SoftDeletes;

    const DELETED_AT = 'dihapus_pada';

    protected $table = 'kormi_unduhan';

    protected $casts = [
        'status_publik' => 'boolean',
        'jumlah_unduhan' => 'integer',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriUnduhan::class, 'kategori_id');
    }

    public function pengunggah(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengunggah_id');
    }
}
