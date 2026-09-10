<?php

namespace App\Models;

class ProgramKerja extends ModelDasar
{
    protected $table = 'kormi_program_kerja';

    protected $casts = [
        'tahun_anggaran' => 'integer',
        'estimasi_anggaran' => 'decimal:2',
        'bulan_mulai' => 'integer',
        'bulan_selesai' => 'integer',
    ];

    public function scopeTahun($query, int $tahun)
    {
        return $query->where('tahun_anggaran', $tahun);
    }

    public function scopeBidang($query, string $bidang)
    {
        return $query->where('nama_bidang', $bidang);
    }

    /**
     * Format anggaran ke Rupiah
     */
    public function getAnggaranRupiahAttribute(): string
    {
        if (empty($this->estimasi_anggaran)) {
            return '-';
        }
        return 'Rp ' . number_format($this->estimasi_anggaran, 0, ',', '.');
    }

    /**
     * Label nama bulan dalam Bahasa Indonesia
     */
    public function getBulanMulaiLabelAttribute(): ?string
    {
        return $this->labelBulan($this->bulan_mulai);
    }

    public function getBulanSelesaiLabelAttribute(): ?string
    {
        return $this->labelBulan($this->bulan_selesai);
    }

    private function labelBulan(?int $bulan): ?string
    {
        if (!$bulan) return null;
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        return $namaBulan[$bulan] ?? null;
    }
}
