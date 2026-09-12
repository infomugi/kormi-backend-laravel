<?php

namespace App\Livewire\Publik\Tentang;

use App\Models\LinimasaSejarah;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Sejarah & Kilas Perjalanan - KORMI Kabupaten Bandung')]
class Sejarah extends Component
{
    public function render()
    {
        $dbMilestones = LinimasaSejarah::tampil()->urut()->get();

        if ($dbMilestones->isNotEmpty()) {
            $milestones = $dbMilestones->map(fn($item, $idx) => [
                'id'        => $item->id,
                'tahun'     => $item->tahun ?? '',
                'judul'     => $item->judul ?? '',
                'deskripsi' => $item->deskripsi ?? '',
                'gambar'    => $item->gambar_full_url,
                'posisi'    => $idx % 2 === 0 ? 'left' : 'right',
            ])->toArray();
        } else {
            $milestones = [
                [
                    'tahun'     => '2000 - 2010',
                    'judul'     => 'Era Perintisan (FOMI)',
                    'deskripsi' => 'Berdiri sebagai wadah awal penghimpun induk-induk olahraga tradisional dan senam rekreasi di Kabupaten Bandung dengan pembinaan berpusat di komunitas lokal.',
                    'gambar'    => null,
                    'posisi'    => 'left'
                ],
                [
                    'tahun'     => '2011 - 2019',
                    'judul'     => 'Transformasi & Penguatan (FORMI)',
                    'deskripsi' => 'Bertransformasi menjadi FORMI Kabupaten Bandung dengan konsolidasi kelembagaan di 31 kecamatan dan penyelenggaraan Festival Olahraga Rekreasi skala massal.',
                    'gambar'    => null,
                    'posisi'    => 'right'
                ],
                [
                    'tahun'     => '2020 - 2022',
                    'judul'     => 'Restrukturisasi KORMI',
                    'deskripsi' => 'Perubahan nomenklatur resmi menjadi KORMI sesuai dinamika regulasi nasional dan penataan 3 rumpun komisi olahraga (OTKB, OKK, OPT).',
                    'gambar'    => null,
                    'posisi'    => 'left'
                ],
                [
                    'tahun'     => '2023 - 2026+',
                    'judul'     => 'Era Akselerasi Menuju Indonesia Bugar',
                    'deskripsi' => 'Pengukuhan Duta Olahraga di 280 desa/kelurahan, digitalisasi portal informasi, serta pembinaan berkelanjutan menuju masyarakat Kabupaten Bandung yang Bedas.',
                    'gambar'    => null,
                    'posisi'    => 'right'
                ],
            ];
        }

        return view('livewire.publik.tentang.sejarah', [
            'milestones' => $milestones,
        ])->layout('components.layouts.app');
    }
}

