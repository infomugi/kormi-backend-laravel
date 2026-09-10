<?php

namespace App\Livewire\Publik\Event;

use Livewire\Component;

class Fotradkab extends Component
{
    public function render()
    {
        $eventFotradkab = \App\Models\Event::with(['cabang.inorga', 'klasemen.kecamatan'])
            ->where(function($q) {
                $q->where('judul_event', 'like', '%FOTRADKAB%')
                  ->orWhere('judul_event', 'like', '%Tradisional%');
            })
            ->where('status_publikasi', true)
            ->latest('tahun_edisi')
            ->first();

        if ($eventFotradkab && $eventFotradkab->cabang->isNotEmpty()) {
            $colors = ['bg-amber-500', 'bg-red-500', 'bg-orange-500', 'bg-blue-500', 'bg-green-500', 'bg-emerald-500', 'bg-purple-500', 'bg-indigo-500'];
            $caborTradisional = $eventFotradkab->cabang->map(fn($c, $idx) => [
                'nama' => $c->nama_cabang,
                'icon' => $c->ikon ?? 'footprints',
                'desc' => 'Kategori Peserta: ' . ($c->kategori_peserta ?? '31 Kecamatan'),
                'peserta' => $c->kategori_peserta ?? '31 Kecamatan',
                'color' => $colors[$idx % count($colors)],
            ])->toArray();
        } else {
            $caborTradisional = [
                ['nama' => 'Egrang', 'icon' => 'footprints', 'desc' => 'Olahraga tradisional berjalan dengan dua tongkat kayu panjang sebagai penumpu kaki.', 'peserta' => '31 Kecamatan', 'color' => 'bg-amber-500'],
                ['nama' => 'Tarik Tambang', 'icon' => 'grip', 'desc' => 'Adu kekuatan tim dalam menarik tali ke arah masing-masing. Membutuhkan kerja sama tim.', 'peserta' => '31 Kecamatan', 'color' => 'bg-red-500'],
                ['nama' => 'Balap Karung', 'icon' => 'zap', 'desc' => 'Lomba lari dengan kaki dimasukkan ke dalam karung mengasah keseimbangan.', 'peserta' => '31 Kecamatan', 'color' => 'bg-orange-500'],
                ['nama' => 'Gobag Sodor', 'icon' => 'move', 'desc' => 'Permainan beregu yang mengandalkan kelincahan, kecepatan, dan strategi.', 'peserta' => '24 Kecamatan', 'color' => 'bg-blue-500'],
                ['nama' => 'Lari Bakiak', 'icon' => 'footprints', 'desc' => 'Lomba lari berkelompok menggunakan bakiak kayu melatih kekompakan.', 'peserta' => '31 Kecamatan', 'color' => 'bg-green-500'],
                ['nama' => 'Panjat Pinang', 'icon' => 'award', 'desc' => 'Memanjat pohon pinang berpelumas untuk mengambil hadiah di puncak.', 'peserta' => '20 Kecamatan', 'color' => 'bg-emerald-500'],
                ['nama' => 'Galah Asin', 'icon' => 'target', 'desc' => 'Permainan tradisional Sunda mengandalkan kelincahan menghindari penjaga.', 'peserta' => '28 Kecamatan', 'color' => 'bg-purple-500'],
                ['nama' => 'Hadang', 'icon' => 'shield', 'desc' => 'Permainan beregu melewati garis pertahanan lawan secara tangkas.', 'peserta' => '26 Kecamatan', 'color' => 'bg-indigo-500'],
            ];
        }

        if ($eventFotradkab && $eventFotradkab->klasemen->isNotEmpty()) {
            $klasemen = $eventFotradkab->klasemen()
                ->with('kecamatan')
                ->orderByDesc('jumlah_emas')
                ->orderByDesc('jumlah_perak')
                ->orderByDesc('jumlah_perunggu')
                ->take(10)
                ->get()
                ->map(fn($k, $idx) => [
                    'peringkat' => $idx + 1,
                    'kecamatan' => $k->kecamatan?->nama_kecamatan ?? 'Kecamatan',
                    'emas' => $k->jumlah_emas,
                    'perak' => $k->jumlah_perak,
                    'perunggu' => $k->jumlah_perunggu,
                ])->toArray();
        } else {
            $klasemen = [
                ['peringkat' => 1, 'kecamatan' => 'Soreang', 'emas' => 8, 'perak' => 5, 'perunggu' => 3],
                ['peringkat' => 2, 'kecamatan' => 'Baleendah', 'emas' => 6, 'perak' => 7, 'perunggu' => 4],
                ['peringkat' => 3, 'kecamatan' => 'Ciparay', 'emas' => 5, 'perak' => 4, 'perunggu' => 6],
                ['peringkat' => 4, 'kecamatan' => 'Dayeuhkolot', 'emas' => 4, 'perak' => 6, 'perunggu' => 5],
                ['peringkat' => 5, 'kecamatan' => 'Margahayu', 'emas' => 4, 'perak' => 3, 'perunggu' => 7],
                ['peringkat' => 6, 'kecamatan' => 'Cileunyi', 'emas' => 3, 'perak' => 5, 'perunggu' => 4],
                ['peringkat' => 7, 'kecamatan' => 'Rancaekek', 'emas' => 3, 'perak' => 4, 'perunggu' => 3],
                ['peringkat' => 8, 'kecamatan' => 'Katapang', 'emas' => 2, 'perak' => 4, 'perunggu' => 5],
            ];
        }

        return view('livewire.publik.event.fotradkab', [
            'caborTradisional' => $caborTradisional,
            'klasemen' => $klasemen,
        ])->layout('components.layouts.app', ['title' => 'FOTRADKAB - KORMI Kabupaten Bandung']);
    }
}
