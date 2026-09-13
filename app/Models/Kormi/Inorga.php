<?php

namespace App\Models\Kormi;

use App\Models\Kormi\EventCabang;

use App\Models\Core\ModelDasar;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inorga extends ModelDasar
{
    protected $table = 'kormi_inorga';

    protected $fillable = [
        'id',
        'komisi_id',
        'nama_inorga',
        'singkatan',
        'slug',
        'nama_ketua',
        'kontak_person',
        'nomor_telepon',
        'email',
        'alamat_sekretariat',
        'nomor_sk',
        'tanggal_sk',
        'jumlah_klub_anggota',
        'logo_url',
        'status_keanggotaan',
        'deskripsi_kegiatan',
    ];

    protected $casts = [
        'tanggal_sk' => 'date',
        'jumlah_klub_anggota' => 'integer',
    ];

    public function komisi(): BelongsTo
    {
        return $this->belongsTo(KomisiInorga::class, 'komisi_id');
    }

    public function eventCabang(): HasMany
    {
        return $this->hasMany(EventCabang::class, 'inorga_id');
    }

    public function getInitialDuaHurufAttribute(): string
    {
        $clean = preg_replace('/[^A-Za-z0-9]/', '', $this->singkatan ?? '');
        return strtoupper(substr($clean ?: 'IN', 0, 2));
    }

    public function getLogoGambarUrlAttribute(): ?string
    {
        if (empty($this->logo_url)) {
            return null;
        }

        if (str_starts_with($this->logo_url, 'http://') || str_starts_with($this->logo_url, 'https://')) {
            return $this->logo_url;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($this->logo_url) ?? null;
    }
}
