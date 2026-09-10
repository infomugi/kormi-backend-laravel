<?php

namespace App\Livewire\Publik\Tentang;

use Livewire\Component;
use App\Models\LinimasaSejarah;

class Sejarah extends Component
{
    public function render()
    {
        $milestones = [
            [
                'tahun' => '2000 - 2010',
                'judul' => 'Era Perintisan (FOMI)',
                'deskripsi' => 'Berdiri sebagai wadah awal penghimpun induk-induk olahraga tradisional dan senam rekreasi di Kabupaten Bandung dengan pembinaan berpusat di komunitas lokal.',
                'posisi' => 'left'
            ],
            [
                'tahun' => '2011 - 2019',
                'judul' => 'Transformasi & Penguatan (FORMI)',
                'deskripsi' => 'Bertransformasi menjadi FORMI Kabupaten Bandung dengan konsolidasi kelembagaan di 31 kecamatan dan penyelenggaraan Festival Olahraga Rekreasi skala massal.',
                'posisi' => 'right'
            ],
            [
                'tahun' => '2020 - 2022',
                'judul' => 'Restrukturisasi KORMI',
                'deskripsi' => 'Perubahan nomenklatur resmi menjadi KORMI sesuai dinamika regulasi nasional dan penataan 3 rumpun komisi olahraga (OTDA, OKK, OPT).',
                'posisi' => 'left'
            ],
            [
                'tahun' => '2023 - 2026+',
                'judul' => 'Era Akselerasi Menuju Indonesia Bugar',
                'deskripsi' => 'Pengukuhan Duta Olahraga di 280 desa/kelurahan, digitalisasi portal informasi, serta pembinaan berkelanjutan menuju masyarakat Kabupaten Bandung yang Bedas.',
                'posisi' => 'right'
            ],
        ];

        return view('livewire.publik.tentang.sejarah', [
            'milestones' => $milestones,
        ])->layout('components.layouts.app', ['title' => 'Sejarah KORMI Kabupaten Bandung']);
    }
}
