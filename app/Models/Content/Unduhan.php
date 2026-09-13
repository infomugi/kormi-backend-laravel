<?php

namespace App\Models\Content;

use App\Models\Core\Pengguna;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unduhan extends ModelDasar
{
    use SoftDeletes;

    const DELETED_AT = 'dihapus_pada';

    protected $table = 'media_unduhan';

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
