<?php

namespace App\Livewire\Admin\Event;

use App\Models\Event;
use App\Models\EventKlasemenMedali;
use App\Models\Kecamatan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Kelola Klasemen Medali Event FORKAB - KORMI CMS')]
class KlasemenKelola extends Component
{
    public string $eventDipilih = '';
    public string $cari = '';
    public array $medaliData = [];

    public function mount(): void
    {
        $event = Event::first();
        if ($event) {
            $this->eventDipilih = $event->id;
            $this->muatDataKlasemen();
        }
    }

    public function updatedEventDipilih(): void
    {
        $this->muatDataKlasemen();
    }

    public function muatDataKlasemen(): void
    {
        if (empty($this->eventDipilih)) {
            $this->medaliData = [];
            return;
        }

        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();
        $this->medaliData = [];

        foreach ($kecamatanList as $kec) {
            $klasemen = EventKlasemenMedali::firstOrCreate(
                ['event_id' => $this->eventDipilih, 'kecamatan_id' => $kec->id],
                ['jumlah_emas' => 0, 'jumlah_perak' => 0, 'jumlah_perunggu' => 0, 'total_medali' => 0, 'peringkat' => 0]
            );

            $this->medaliData[$kec->id] = [
                'nama' => $kec->nama_kecamatan,
                'emas' => $klasemen->jumlah_emas,
                'perak' => $klasemen->jumlah_perak,
                'perunggu' => $klasemen->jumlah_perunggu,
                'total' => $klasemen->total_medali,
            ];
        }
    }

    public function updateMedali(string $kecamatanId, string $jenis, int|string $nilai): void
    {
        $nilai = max(0, (int) $nilai);
        $this->medaliData[$kecamatanId][$jenis] = $nilai;

        $emas = (int) $this->medaliData[$kecamatanId]['emas'];
        $perak = (int) $this->medaliData[$kecamatanId]['perak'];
        $perunggu = (int) $this->medaliData[$kecamatanId]['perunggu'];
        $total = $emas + $perak + $perunggu;

        $this->medaliData[$kecamatanId]['total'] = $total;

        EventKlasemenMedali::where('event_id', $this->eventDipilih)
            ->where('kecamatan_id', $kecamatanId)
            ->update([
                'jumlah_emas' => $emas,
                'jumlah_perak' => $perak,
                'jumlah_perunggu' => $perunggu,
                'total_medali' => $total,
            ]);

        session()->flash('pesan', 'Perolehan medali Kecamatan ' . $this->medaliData[$kecamatanId]['nama'] . ' berhasil diperbarui!');
    }

    public function render()
    {
        $eventList = Event::orderByDesc('tahun_edisi')->get();

        $query = EventKlasemenMedali::with('kecamatan')
            ->where('event_id', $this->eventDipilih)
            ->when($this->cari, function ($q) {
                $q->whereHas('kecamatan', fn($kq) => $kq->where('nama_kecamatan', 'like', "%{$this->cari}%"));
            })
            ->orderByDesc('jumlah_emas')
            ->orderByDesc('jumlah_perak')
            ->orderByDesc('jumlah_perunggu')
            ->orderByDesc('total_medali');

        $klasemenList = $query->get();

        $totalEmas = EventKlasemenMedali::where('event_id', $this->eventDipilih)->sum('jumlah_emas');
        $totalPerak = EventKlasemenMedali::where('event_id', $this->eventDipilih)->sum('jumlah_perak');
        $totalPerunggu = EventKlasemenMedali::where('event_id', $this->eventDipilih)->sum('jumlah_perunggu');
        $totalSemua = $totalEmas + $totalPerak + $totalPerunggu;

        return view('livewire.admin.event.klasemen-kelola', [
            'eventList' => $eventList,
            'klasemenList' => $klasemenList,
            'totalEmas' => $totalEmas,
            'totalPerak' => $totalPerak,
            'totalPerunggu' => $totalPerunggu,
            'totalSemua' => $totalSemua,
            'top3' => $klasemenList->take(3),
        ]);
    }
}
