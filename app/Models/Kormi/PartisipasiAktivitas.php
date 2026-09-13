<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;
use App\Models\Core\Pengguna;
use App\Models\Master\Kecamatan;
use App\Models\Master\DesaKelurahan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class PartisipasiAktivitas extends ModelDasar
{
    use SoftDeletes;

    const DELETED_AT = 'dihapus_pada';

    protected $table = 'kormi_partisipasi_aktivitas';

    protected $fillable = [
        'pengguna_id',
        'metode_pencatatan',
        'duta_id',
        'inorga_id',
        'kecamatan_id',
        'desa_kelurahan_id',
        'nama_aktivitas',
        'tanggal_aktivitas',
        'waktu_mulai',
        'durasi_menit',
        'jenis_partisipasi',
        'jumlah_peserta',
        'daftar_nama_peserta',
        'kategori_lokasi',
        'sapras_id',
        'nama_tempat',
        'latitude',
        'longitude',
        'foto_kegiatan',
        'foto_daftar_hadir',
        'catatan',
        'status_verifikasi',
        'alasan_penolakan',
        'diverifikasi_oleh',
    ];

    protected $casts = [
        'tanggal_aktivitas' => 'date',
        'durasi_menit' => 'integer',
        'jumlah_peserta' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function duta(): BelongsTo
    {
        return $this->belongsTo(DutaOlahraga::class, 'duta_id');
    }

    public function inorga(): BelongsTo
    {
        return $this->belongsTo(Inorga::class, 'inorga_id');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function desa(): BelongsTo
    {
        return $this->belongsTo(DesaKelurahan::class, 'desa_kelurahan_id');
    }

    public function sapras(): BelongsTo
    {
        return $this->belongsTo(Sapras::class, 'sapras_id');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'diverifikasi_oleh');
    }

    /**
     * Scope filter validitas
     */
    public function scopeValid(Builder $query): Builder
    {
        return $query->where('status_verifikasi', 'valid');
    }

    /**
     * Scope filter rentang hari
     */
    public function scopeDalamHari(Builder $query, int $days = 30): Builder
    {
        return $query->where('tanggal_aktivitas', '>=', now()->subDays($days)->toDateString());
    }

    /**
     * Scope filter kecamatan
     */
    public function scopeKecamatan(Builder $query, ?string $kecamatanId): Builder
    {
        if ($kecamatanId) {
            return $query->where('kecamatan_id', $kecamatanId);
        }
        return $query;
    }
}
