<?php

namespace App\Livewire\Backend\Kormi\Partisipasi;

use App\Models\Kormi\PartisipasiAktivitas;
use App\Models\Kormi\Inorga;
use App\Models\Master\Kecamatan;
use App\Models\Master\DesaKelurahan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Log Partisipasi Warga - KORMI CMS')]
class PartisipasiKelola extends Component
{
    use WithPagination;

    public string $cari = '';
    public string $metodeDipilih = 'Semua'; // 'Semua', 'mandiri', 'via_duta'
    public string $statusDipilih = 'Semua'; // 'Semua', 'valid', 'pending_review', 'ditolak'
    public string $kecamatanDipilih = 'Semua';
    public string $inorgaDipilih = 'Semua';
    public int $perPage = 10;

    // Sorting
    public string $sortField = 'tanggal_aktivitas';
    public string $sortDirection = 'desc';

    // Modal Detail & Verifikasi
    public bool $tampilkanModalDetail = false;
    public ?string $aktivitasId = null;
    public ?PartisipasiAktivitas $aktivitasTerpilih = null;
    public string $alasanPenolakan = '';

    // Bulk selection
    public array $selectedRows = [];
    public bool $selectAll = false;

    public function updatedCari(): void
    {
        $this->resetPage();
        $this->selectedRows = [];
    }

    public function updatedMetodeDipilih(): void
    {
        $this->resetPage();
    }

    public function updatedStatusDipilih(): void
    {
        $this->resetPage();
    }

    public function updatedKecamatanDipilih(): void
    {
        $this->resetPage();
    }

    public function updatedInorgaDipilih(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function bukaDetail(string $id): void
    {
        $this->aktivitasTerpilih = PartisipasiAktivitas::with(['pengguna', 'duta', 'inorga', 'kecamatan', 'desa', 'sapras'])->findOrFail($id);
        $this->aktivitasId = $id;
        $this->alasanPenolakan = $this->aktivitasTerpilih->alasan_penolakan ?? '';
        $this->tampilkanModalDetail = true;
    }

    public function verifikasi(string $id, string $status): void
    {
        $aktivitas = PartisipasiAktivitas::findOrFail($id);
        $aktivitas->update([
            'status_verifikasi' => $status,
            'diverifikasi_oleh' => auth()->id(),
            'alasan_penolakan' => $status === 'ditolak' ? $this->alasanPenolakan : null,
        ]);

        $statusText = $status === 'valid' ? 'disetujui (valid)' : ($status === 'ditolak' ? 'ditolak' : 'pending');
        session()->flash('pesan', "Status aktivitas olahraga berhasil diubah menjadi {$statusText}!");
        $this->tampilkanModalDetail = false;
    }

    public function bulkVerifikasi(string $status): void
    {
        if (empty($this->selectedRows)) {
            return;
        }

        $count = PartisipasiAktivitas::whereIn('id', $this->selectedRows)->update([
            'status_verifikasi' => $status,
            'diverifikasi_oleh' => auth()->id(),
        ]);

        $statusText = $status === 'valid' ? 'disetujui (valid)' : 'ditolak';
        session()->flash('pesan', "{$count} data aktivitas berhasil diubah menjadi {$statusText} secara massal!");
        $this->selectedRows = [];
        $this->selectAll = false;
    }

    public function hapus(string $id): void
    {
        $aktivitas = PartisipasiAktivitas::findOrFail($id);
        $aktivitas->delete();
        session()->flash('pesan', 'Catatan aktivitas olahraga berhasil dihapus!');
    }

    public function bulkHapus(): void
    {
        if (empty($this->selectedRows)) {
            return;
        }

        $count = PartisipasiAktivitas::whereIn('id', $this->selectedRows)->delete();
        session()->flash('pesan', "{$count} data aktivitas berhasil dihapus!");
        $this->selectedRows = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function render()
    {
        $query = PartisipasiAktivitas::with(['pengguna', 'duta', 'inorga', 'kecamatan', 'desa'])
            ->when($this->metodeDipilih !== 'Semua', fn($q) => $q->where('metode_pencatatan', $this->metodeDipilih))
            ->when($this->statusDipilih !== 'Semua', fn($q) => $q->where('status_verifikasi', $this->statusDipilih))
            ->when($this->kecamatanDipilih !== 'Semua', fn($q) => $q->where('kecamatan_id', $this->kecamatanDipilih))
            ->when($this->inorgaDipilih !== 'Semua', fn($q) => $q->where('inorga_id', $this->inorgaDipilih))
            ->when($this->cari, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nama_aktivitas', 'like', '%' . $this->cari . '%')
                        ->orWhere('nama_tempat', 'like', '%' . $this->cari . '%')
                        ->orWhereHas('pengguna', fn($p) => $p->where('nama_lengkap', 'like', '%' . $this->cari . '%'))
                        ->orWhereHas('duta', fn($d) => $d->where('nama_lengkap', 'like', '%' . $this->cari . '%'));
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $daftarAktivitas = $query->paginate($this->perPage);

        return view('livewire.backend.kormi.partisipasi.partisipasi-kelola', [
            'daftarAktivitas' => $daftarAktivitas,
            'daftarKecamatan' => Kecamatan::orderBy('nama_kecamatan')->get(),
            'daftarInorga' => Inorga::orderBy('nama_inorga')->get(),
            'totalEntri' => PartisipasiAktivitas::count(),
            'totalMandiri' => PartisipasiAktivitas::where('metode_pencatatan', 'mandiri')->count(),
            'totalViaDuta' => PartisipasiAktivitas::where('metode_pencatatan', 'via_duta')->count(),
            'totalPartisipan' => PartisipasiAktivitas::sum('jumlah_peserta'),
        ]);
    }
}
