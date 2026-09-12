<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DutaOlahraga extends ModelDasar
{
    protected $table = 'kormi_duta_olahraga';

    protected $fillable = [
        'id',
        'kecamatan_id',
        'desa_kelurahan_id',
        'nama_lengkap',
        'tahun_pemilihan',
        'kategori_duta',
        'gelar_prestasi',
        'deskripsi_prestasi',
        'akun_instagram',
        'nomor_telepon',
        'email',
        'jenis_kelamin',
        'pekerjaan_profesi',
        'pendidikan_terakhir',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_domisili',
        'foto_url',
        'status_aktif',
        'status_unggulan',
    ];

    protected $casts = [
        'tahun_pemilihan' => 'integer',
        'status_aktif'    => 'boolean',
        'status_unggulan' => 'boolean',
        'tanggal_lahir'   => 'date',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function desaKelurahan(): BelongsTo
    {
        return $this->belongsTo(DesaKelurahan::class, 'desa_kelurahan_id');
    }

    /**
     * Helper backward compatibility: get prestasis alias
     */
    public function getPrestasiAttribute(): ?string
    {
        return $this->deskripsi_prestasi ?: $this->gelar_prestasi;
    }

    /**
     * Helper backward compatibility: get kontak alias
     */
    public function getKontakAttribute(): ?string
    {
        return $this->nomor_telepon ?: $this->akun_instagram;
    }
}
