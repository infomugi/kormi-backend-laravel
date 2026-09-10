<?php

namespace App\Models;

class LinimasaSejarah extends ModelDasar
{
    protected $table = 'kormi_linimasa_sejarah';

    protected $casts = [
        'urutan' => 'integer',
        'status_tampil' => 'boolean',
    ];

    public function scopeTampil($query)
    {
        return $query->where('status_tampil', true);
    }

    public function scopeAktif($query)
    {
        return $query->where('status_tampil', true);
    }

    public function scopeUrut($query)
    {
        return $query->orderBy('urutan')->orderBy('tahun');
    }

    public function getGambarFullUrlAttribute(): ?string
    {
        if (empty($this->gambar_url)) {
            return null;
        }

        if (str_starts_with($this->gambar_url, 'http://') || str_starts_with($this->gambar_url, 'https://')) {
            return $this->gambar_url;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($this->gambar_url);
    }
}
