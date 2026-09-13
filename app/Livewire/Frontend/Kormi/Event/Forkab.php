<?php

namespace App\Livewire\Frontend\Kormi\Event;

use Livewire\Component;

class Forkab extends Component
{
    public function render()
    {
        $eventForkab = \App\Models\Kormi\Event::with(['cabang.inorga', 'jadwal', 'klasemen.kecamatan'])
            ->where('judul_event', 'like', '%FORKAB%')
            ->where('status_publikasi', true)
            ->latest('tahun_edisi')
            ->first();

        if ($eventForkab && $eventForkab->cabang->isNotEmpty()) {
            $colors = ['bg-pink-500', 'bg-red-500', 'bg-blue-500', 'bg-cyan-500', 'bg-indigo-500', 'bg-emerald-500', 'bg-orange-500', 'bg-purple-500'];
            $caborRekreasi = $eventForkab->cabang->map(fn($c, $idx) => [
                'nama' => $c->nama_cabang,
                'icon' => $c->ikon ?? 'activity',
                'desc' => 'Kategori: ' . ($c->kategori_peserta ?? 'Umum') . ($c->inorga ? ' (' . $c->inorga->singkatan . ')' : ''),
                'color' => $colors[$idx % count($colors)],
            ])->toArray();
        } else {
            $caborRekreasi = [
                ['nama' => 'Senam Aerobik', 'icon' => 'activity', 'desc' => 'Kompetisi senam aerobik beregu menggabungkan gerakan dinamis.', 'color' => 'bg-pink-500'],
                ['nama' => 'Fun Run 5K', 'icon' => 'zap', 'desc' => 'Lomba lari santai 5 kilometer terbuka untuk semua kalangan usia.', 'color' => 'bg-red-500'],
                ['nama' => 'Bersepeda Santai', 'icon' => 'bike', 'desc' => 'Fun ride bersepeda santai mengelilingi rute ikonik Kabupaten Bandung.', 'color' => 'bg-blue-500'],
                ['nama' => 'Renang Rekreasi', 'icon' => 'waves', 'desc' => 'Kompetisi renang gaya bebas dan estafet rekreasi.', 'color' => 'bg-cyan-500'],
                ['nama' => 'Layang-Layang', 'icon' => 'wind', 'desc' => 'Festival layang-layang hias dan aduan tradisional.', 'color' => 'bg-indigo-500'],
                ['nama' => 'Panahan Tradisional', 'icon' => 'target', 'desc' => 'Lomba panahan tradisional (jemparingan) khas Sunda.', 'color' => 'bg-emerald-500'],
                ['nama' => 'Tenis Meja', 'icon' => 'table', 'desc' => 'Pertandingan tenis meja rekreasi tunggal dan ganda antar kecamatan.', 'color' => 'bg-orange-500'],
                ['nama' => 'Petanque', 'icon' => 'circle-dot', 'desc' => 'Olahraga melempar bola besi yang semakin populer di masyarakat.', 'color' => 'bg-purple-500'],
            ];
        }

        if ($eventForkab && $eventForkab->klasemen->isNotEmpty()) {
            $klasemen = $eventForkab->klasemen()
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
                ['peringkat' => 1, 'kecamatan' => 'Margahayu', 'emas' => 10, 'perak' => 6, 'perunggu' => 4],
                ['peringkat' => 2, 'kecamatan' => 'Dayeuhkolot', 'emas' => 8, 'perak' => 8, 'perunggu' => 5],
                ['peringkat' => 3, 'kecamatan' => 'Baleendah', 'emas' => 7, 'perak' => 5, 'perunggu' => 7],
                ['peringkat' => 4, 'kecamatan' => 'Ciparay', 'emas' => 6, 'perak' => 7, 'perunggu' => 3],
                ['peringkat' => 5, 'kecamatan' => 'Soreang', 'emas' => 5, 'perak' => 6, 'perunggu' => 8],
                ['peringkat' => 6, 'kecamatan' => 'Katapang', 'emas' => 5, 'perak' => 4, 'perunggu' => 5],
                ['peringkat' => 7, 'kecamatan' => 'Cileunyi', 'emas' => 4, 'perak' => 5, 'perunggu' => 6],
                ['peringkat' => 8, 'kecamatan' => 'Rancaekek', 'emas' => 4, 'perak' => 3, 'perunggu' => 4],
            ];
        }

        if ($eventForkab && $eventForkab->jadwal->isNotEmpty()) {
            $timeline = $eventForkab->jadwal->map(fn($j) => [
                'phase' => $j->fase_tahapan,
                'date' => $j->tanggal ? $j->tanggal->format('d M Y') : '-',
                'desc' => $j->nama_kegiatan . ' di ' . $j->tempat_arena,
                'status' => $j->status_tahapan === 'selesai' ? 'done' : ($j->status_tahapan === 'berlangsung' ? 'active' : 'upcoming'),
            ])->toArray();
        } else {
            $timeline = [
                ['phase' => 'Pendaftaran', 'date' => '1 - 30 Juni 2026', 'desc' => 'Pendaftaran kontingen kecamatan melalui Koordinator Kecamatan.', 'status' => 'done'],
                ['phase' => 'Technical Meeting', 'date' => '15 Juli 2026', 'desc' => 'Rapat teknis dan undian bagan pertandingan di sekretariat KORMI.', 'status' => 'done'],
                ['phase' => 'Babak Penyisihan', 'date' => '1 - 15 Agustus 2026', 'desc' => 'Pertandingan babak penyisihan di masing-masing zona wilayah.', 'status' => 'active'],
                ['phase' => 'Babak Final', 'date' => '25 - 30 Agustus 2026', 'desc' => 'Grand final seluruh cabang olahraga di Stadion Si Jalak Harupat.', 'status' => 'upcoming'],
                ['phase' => 'Penutupan & Awarding', 'date' => '30 Agustus 2026', 'desc' => 'Upacara penutupan dan penyerahan piala bergilir Bupati Bandung.', 'status' => 'upcoming'],
            ];
        }

        return view('livewire.frontend.kormi.event.forkab', [
            'caborRekreasi' => $caborRekreasi,
            'klasemen' => $klasemen,
            'timeline' => $timeline,
        ])->layout('components.layouts.app', ['title' => 'FORKAB - KORMI Kabupaten Bandung']);
    }
}
