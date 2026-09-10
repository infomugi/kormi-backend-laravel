<?php

namespace App\Livewire\Publik\Tentang;

use Livewire\Component;

class Proker extends Component
{
    public string $bidangDipilih = 'Semua';

    public function render()
    {
        $dbProker = \App\Models\ProgramKerja::when($this->bidangDipilih !== 'Semua', function ($q) {
                $q->where('nama_bidang', 'like', "%{$this->bidangDipilih}%");
            })
            ->orderBy('bulan_mulai')
            ->get();

        if ($dbProker->isNotEmpty() || ($this->bidangDipilih !== 'Semua' && \App\Models\ProgramKerja::count() > 0)) {
            $prokerList = $dbProker->map(fn($item) => [
                'judul' => $item->nama_kegiatan,
                'bidang' => $item->nama_bidang,
                'status' => ucfirst($item->status_kegiatan),
                'deskripsi' => $item->tujuan_kegiatan ?? $item->target_sasaran ?? 'Program kerja bidang ' . $item->nama_bidang,
                'icon' => $item->ikon ?? 'activity',
                'color' => 'bg-emerald-500',
            ])->toArray();
        } else {
            $prokerList = [
                [
                    'judul' => 'Festival Olahraga Rekreasi Desa (FORDESWITA)',
                    'bidang' => 'OTKB',
                    'status' => 'Rutin Tahunan',
                    'deskripsi' => 'Menggabungkan olahraga tradisional dengan promosi destinasi wisata lokal di berbagai desa Kabupaten Bandung untuk meningkatkan perekonomian dan kebugaran warga.',
                    'icon' => 'map',
                    'color' => 'bg-blue-500'
                ],
                [
                    'judul' => 'Senam Bedas Massal Terpadu',
                    'bidang' => 'OKK',
                    'status' => 'Berjalan',
                    'deskripsi' => 'Kegiatan senam massal berskala besar yang melibatkan puluhan ribu peserta dari berbagai instansi dan masyarakat umum, bertujuan memecahkan rekor partisipasi.',
                    'icon' => 'users',
                    'color' => 'bg-green-500'
                ],
                [
                    'judul' => 'Kejuaraan Panjat Tebing & Susur Gua Pemula',
                    'bidang' => 'OPT',
                    'status' => 'Perencanaan 2026',
                    'deskripsi' => 'Kompetisi pencarian bibit pegiat olahraga petualangan dan tantangan dari kalangan pemuda dan pelajar di kawasan pegunungan Kabupaten Bandung.',
                    'icon' => 'mountain',
                    'color' => 'bg-orange-500'
                ],
                [
                    'judul' => 'Pelatihan & Sertifikasi Instruktur Senam',
                    'bidang' => 'SDM',
                    'status' => 'Selesai',
                    'deskripsi' => 'Program peningkatan kapasitas instruktur senam lokal untuk disertifikasi dan ditempatkan sebagai penggerak olahraga di setiap RW/Desa.',
                    'icon' => 'award',
                    'color' => 'bg-purple-500'
                ],
                [
                    'judul' => 'Lomba Cipta Senam Kreasi Bedas',
                    'bidang' => 'OKK',
                    'status' => 'Segera Hadir',
                    'deskripsi' => 'Kompetisi terbuka menciptakan gerakan senam kreasi baru yang memadukan unsur budaya Sunda dan visi Bandung Bedas.',
                    'icon' => 'music',
                    'color' => 'bg-pink-500'
                ],
                [
                    'judul' => 'Jelajah Alam Bedas (Hiking & Trail)',
                    'bidang' => 'OPT',
                    'status' => 'Berjalan',
                    'deskripsi' => 'Eksplorasi jalur alam Kabupaten Bandung sambil melakukan kampanye pelestarian lingkungan dan pungut sampah bersama (Eco-Sports).',
                    'icon' => 'compass',
                    'color' => 'bg-red-500'
                ]
            ];

            if ($this->bidangDipilih !== 'Semua') {
                $prokerList = array_filter($prokerList, fn($p) => $p['bidang'] === $this->bidangDipilih);
            }
        }

        return view('livewire.publik.tentang.proker', [
            'prokerList' => $prokerList,
        ])->layout('components.layouts.app', ['title' => 'Program Kerja - KORMI Kabupaten Bandung']);
    }
}
