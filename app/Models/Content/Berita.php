<?php

namespace App\Models\Content;

use App\Models\Core\Pengguna;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends ModelDasar
{
    use SoftDeletes;

    const DELETED_AT = 'dihapus_pada';

    protected $table = 'media_berita';

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

    public function getGambarUrlAttribute(): string
    {
        if (empty($this->gambar_utama)) {
            return 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800';
        }

        if (str_starts_with($this->gambar_utama, 'http://') || str_starts_with($this->gambar_utama, 'https://')) {
            return $this->gambar_utama;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($this->gambar_utama) 
            ?? 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800';
    }

    public function getEstimasiMenitBacaAttribute(): int
    {
        $jumlahKata = str_word_count(strip_tags($this->isi_konten ?? ''));
        return max(1, (int) ceil($jumlahKata / 200));
    }
}

