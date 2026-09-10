<?php

namespace App\Models;

class VisiMisiModel extends ModelDasar
{
    protected $table = 'kormi_visi_misi';

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
        return $query->orderBy('urutan');
    }

    public function scopeJenis($query, string $jenis)
    {
        return $query->where('jenis', $jenis);
    }
}
