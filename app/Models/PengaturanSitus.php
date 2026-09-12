<?php

namespace App\Models;

class PengaturanSitus extends ModelDasar
{
    protected $table = 'sys_pengaturan_situs';

    protected $guarded = ['id'];

    /**
     * Ambil nilai pengaturan berdasarkan kunci.
     */
    public static function ambil(string $kunci, $default = null): ?string
    {
        $pengaturan = static::where('kunci_pengaturan', $kunci)->first();
        return $pengaturan?->nilai_pengaturan ?? $default;
    }

    /**
     * Simpan atau perbarui nilai pengaturan.
     */
    public static function simpan(string $kunci, ?string $nilai, string $kelompok = 'umum'): static
    {
        return static::updateOrCreate(
            ['kunci_pengaturan' => $kunci],
            ['nilai_pengaturan' => $nilai, 'kelompok' => $kelompok]
        );
    }

    /**
     * Ambil semua pengaturan dalam satu kelompok.
     */
    public static function kelompok(string $kelompok): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('kelompok', $kelompok)->get();
    }
}
