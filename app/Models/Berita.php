<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends ModelDasar
{
    use SoftDeletes;

    const DELETED_AT = 'dihapus_pada';

    protected $table = 'kormi_berita';

    protected $casts = [
        'status_unggulan' => 'boolean',
        'tanggal_publikasi' => 'datetime',
        'jumlah_dilihat' => 'integer',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id');
    }

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'penulis_id');
    }
}
