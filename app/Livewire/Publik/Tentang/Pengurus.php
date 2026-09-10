<?php

namespace App\Livewire\Publik\Tentang;

use Livewire\Component;

class Pengurus extends Component
{
    public function render()
    {
        $struktur = [
            [
                'title' => 'Pelindung',
                'members' => ['Bupati Bandung', 'Wakil Bupati Bandung']
            ],
            [
                'title' => 'Dewan Kehormatan',
                'members' => [
                    'H. Cucun Ahmad Syamsurijal, M.A.P',
                    'H. Asep Romy Romaya, S.E.',
                    'H. Agus Yasmin',
                    'Hj. Renie Rahayu Fauzie, S.H.'
                ]
            ],
            [
                'title' => 'Dewan Pembina',
                'members' => [
                    'Sekretaris Daerah Kabupaten Bandung',
                    'Asisten Pemerintahan dan Kesejahteraan Rakyat',
                    'Kepala Dinas Pemuda dan Olahraga',
                    'Kepala Dinas Pendidikan',
                    'Kepala Dinas Kebudayaan',
                    'Kepala Dinas Pariwisata dan Ekonomi Kreatif',
                    'Kepala Dinas Kesehatan',
                    'Kepala Dinas Koperasi dan UKM',
                    'Kepala Dinas Perdagangan dan Perindustrian',
                    'Kepala Dinas Komunikasi dan Informatika'
                ]
            ],
            [
                'title' => 'Dewan Pakar',
                'members' => ['Al Hijaz Farabi DY, S.IP.', 'Ating Rochyadi, M.Pd.']
            ],
            [
                'title' => 'Pengurus Harian',
                'members' => [
                    'Ketua Umum: Hj. Emma Dety Permanawati, S.Pd.I., M.M.',
                    'Wakil Ketua: Margin Winaya, S.H., Ir. Hj. Tintin Indyati Amiyana, Linda Herlina, Hamdan Nursidik, S.E.Sy.',
                    'Sekretaris Umum: Muhammad Iqbal Nurhidayatullah, S.IP.',
                    'Wakil Sekretaris: Arief Sulaiman Martondi, S.E., M.M.',
                    'Bendahara Umum: Witri Andayani, S.P.',
                    'Wakil Bendahara: Siti Nur Arofah, S.IP.'
                ]
            ],
            [
                'title' => 'Komisi Olahraga Tradisional & Kreasi Budaya (OTKB)',
                'members' => [
                    'Ketua Komisi: Arya Wiranata, S.Pd.',
                    'Anggota: Yatti Mulyati, Yoga Jibja Pratama, Kharisma Nayra Althafunisa, Hernando, Humaira Hayun Islamy'
                ]
            ],
            [
                'title' => 'Komisi Olahraga Kesehatan & Kebugaran (OKK)',
                'members' => [
                    'Ketua Komisi: Tohir',
                    'Anggota: Ir. Ela Musliawati, Muhammad Reza Putra Nurhendi, Rizha Rafli Ghifari, Saadillah Amir Husaeni'
                ]
            ],
            [
                'title' => 'Komisi Olahraga Petualangan & Tantangan (OPT)',
                'members' => [
                    'Ketua Komisi: Zico Prasetya Aldrine',
                    'Anggota: Fajar Saeful Rahman, Gunawan, Wendi Purwanto, Dariel Fadhlilah Konjala, S.Par., M.Si.'
                ]
            ]
        ];

        return view('livewire.publik.tentang.pengurus', [
            'struktur' => $struktur,
        ])->layout('components.layouts.app', ['title' => 'Susunan Pengurus - KORMI Kabupaten Bandung']);
    }
}
