<?php

namespace App\Models\Content;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriFoto extends ModelDasar
{
    protected $table = 'media_galeri_foto';

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(GaleriAlbum::class, 'album_id');
    }

    public function getFotoUrlAttribute(): string
    {
        if (empty($this->gambar_url)) {
            return 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800';
        }

        if (str_starts_with($this->gambar_url, 'http://') || str_starts_with($this->gambar_url, 'https://')) {
            return $this->gambar_url;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($this->gambar_url) 
            ?? 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800';
    }
}
