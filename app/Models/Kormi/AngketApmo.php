<?php

namespace App\Models\Kormi;

use App\Models\Core\ModelDasar;
use App\Models\Core\Pengguna;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AngketApmo extends ModelDasar
{
    protected $table = 'kormi_angket_apmo';

    protected $fillable = [
        'pengguna_id',
        'nama_lengkap',
        'usia',
        'jenis_kelamin',
        'tinggi_badan',
        'berat_badan',
        'alamat',
        'kecamatan',
        'desa',
        'kabupaten_kota',
        'pekerjaan',
        'pekerjaan_lainnya',
        'melakukan_olahraga',
        'frekuensi_berat',
        'durasi_berat_jam',
        'durasi_berat_menit',
        'durasi_berat_tidak_tahu',
        'frekuensi_sedang',
        'durasi_sedang_jam',
        'durasi_sedang_menit',
        'durasi_sedang_tidak_tahu',
        'frekuensi_jalan',
        'durasi_jalan_jam',
        'durasi_jalan_menit',
        'durasi_jalan_tidak_tahu',
        'cabang_olahraga',
        'cabang_lainnya',
        'tujuan_olahraga',
        'tujuan_lainnya',
        'jalur_olahraga',
        'jalur_lainnya',
        'pernah_malas',
        'duduk_jam',
        'duduk_menit',
        'duduk_tidak_tahu',
        'alasan_tidak_olahraga',
        'alasan_lainnya',
        'fasilitas_olahraga',
    ];

    protected $casts = [
        'usia' => 'integer',
        'tinggi_badan' => 'integer',
        'berat_badan' => 'integer',
        'melakukan_olahraga' => 'boolean',
        'durasi_berat_jam' => 'integer',
        'durasi_berat_menit' => 'integer',
        'durasi_berat_tidak_tahu' => 'boolean',
        'durasi_sedang_jam' => 'integer',
        'durasi_sedang_menit' => 'integer',
        'durasi_sedang_tidak_tahu' => 'boolean',
        'durasi_jalan_jam' => 'integer',
        'durasi_jalan_menit' => 'integer',
        'durasi_jalan_tidak_tahu' => 'boolean',
        'duduk_jam' => 'integer',
        'duduk_menit' => 'integer',
        'duduk_tidak_tahu' => 'boolean',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
