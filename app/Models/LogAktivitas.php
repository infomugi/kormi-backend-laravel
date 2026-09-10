<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogAktivitas extends ModelDasar
{
    protected $table = 'kormi_log_aktivitas';

    // Log hanya insert, tidak perlu updated_at
    const UPDATED_AT = null;

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    /**
     * Catat aktivitas baru ke log.
     */
    public static function catat(
        string $jenisAksi,
        string $namaTabel,
        ?string $idEntitas = null,
        ?array $dataLama = null,
        ?array $dataBaru = null
    ): static {
        return static::create([
            'pengguna_id' => auth()->id(),
            'jenis_aksi' => $jenisAksi,
            'nama_tabel' => $namaTabel,
            'id_entitas' => $idEntitas,
            'data_lama' => $dataLama,
            'data_baru' => $dataBaru,
            'alamat_ip' => request()->ip(),
            'agen_pengguna' => request()->userAgent(),
        ]);
    }
}
