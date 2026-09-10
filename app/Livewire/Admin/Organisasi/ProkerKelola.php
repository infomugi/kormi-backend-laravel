<?php

namespace App\Livewire\Admin\Organisasi;

use App\Models\ProgramKerja;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Program Kerja - KORMI CMS')]
class ProkerKelola extends Component
{
    use WithPagination;

    public string $mode = 'tabel';
    public string $cari = '';
    public string $filterTahun = 'semua';
    public string $filterBidang = 'semua';
    public string $filterStatus = 'semua';

    // Sorting & Pagination
    public string $sortField = 'tahun_anggaran';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'

    // Bulk selection
    public array $selectedProker = [];
    public bool $pilihSemua = false;

    // Form fields
    public ?string $editId = null;
    public int $tahun_anggaran = 2026;
    public string $nama_bidang = '';
    public string $nama_kegiatan = '';
    public string $tujuan_kegiatan = '';
    public string $target_sasaran = '';
    public ?float $estimasi_anggaran = null;
    public string $status_kegiatan = 'rencana';
    public ?int $bulan_mulai = null;
    public ?int $bulan_selesai = null;
    public string $ikon = 'activity';

    protected function rules(): array
    {
        return [
            'tahun_anggaran' => 'required|integer|min:2020|max:2035',
            'nama_bidang' => 'required|string|min:2|max:100',
            'nama_kegiatan' => 'required|string|min:3|max:255',
            'tujuan_kegiatan' => 'nullable|string',
            'target_sasaran' => 'nullable|string|max:255',
            'estimasi_anggaran' => 'nullable|numeric|min:0',
            'status_kegiatan' => 'required|in:rencana,berjalan,selesai,ditunda',
            'bulan_mulai' => 'nullable|integer|min:1|max:12',
            'bulan_selesai' => 'nullable|integer|min:1|max:12',
            'ikon' => 'nullable|string|max:50',
        ];
    }

    public function updatedCari(): void { $this->resetPage(); }
    public function updatedFilterTahun(): void { $this->resetPage(); }
    public function updatedFilterBidang(): void { $this->resetPage(); }
    public function updatedFilterStatus(): void { $this->resetPage(); }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->resetInput();
    }

    public function bukaFormTambah(): void
    {
        $this->resetInput();
        $this->mode = 'form';
        $this->resetErrorBag();
    }

    public function bukaFormEdit(string $id): void
    {
        $item = ProgramKerja::findOrFail($id);
        $this->editId = $item->id;
        $this->tahun_anggaran = $item->tahun_anggaran;
        $this->nama_bidang = $item->nama_bidang;
        $this->nama_kegiatan = $item->nama_kegiatan;
        $this->tujuan_kegiatan = $item->tujuan_kegiatan ?? '';
        $this->target_sasaran = $item->target_sasaran ?? '';
        $this->estimasi_anggaran = $item->estimasi_anggaran;
        $this->status_kegiatan = $item->status_kegiatan;
        $this->bulan_mulai = $item->bulan_mulai;
        $this->bulan_selesai = $item->bulan_selesai;
        $this->ikon = $item->ikon ?? 'activity';
        $this->mode = 'form';
        $this->resetErrorBag();
    }

    public function simpan(): void
    {
        $this->validate();

        $data = [
            'tahun_anggaran' => $this->tahun_anggaran,
            'nama_bidang' => trim($this->nama_bidang),
            'nama_kegiatan' => trim($this->nama_kegiatan),
            'tujuan_kegiatan' => $this->tujuan_kegiatan ? trim($this->tujuan_kegiatan) : null,
            'target_sasaran' => $this->target_sasaran ? trim($this->target_sasaran) : null,
            'estimasi_anggaran' => $this->estimasi_anggaran,
            'status_kegiatan' => $this->status_kegiatan,
            'bulan_mulai' => $this->bulan_mulai,
            'bulan_selesai' => $this->bulan_selesai,
            'ikon' => $this->ikon ? trim($this->ikon) : 'activity',
        ];

        if ($this->editId) {
            ProgramKerja::findOrFail($this->editId)->update($data);
            session()->flash('pesan', 'Program kerja "' . $this->nama_kegiatan . '" berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            ProgramKerja::create($data);
            session()->flash('pesan', 'Program kerja baru "' . $this->nama_kegiatan . '" berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $item = ProgramKerja::findOrFail($id);
        $nama = $item->nama_kegiatan;
        $item->delete();
        session()->flash('pesan', 'Program kerja (' . $nama . ') berhasil dihapus.');
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function updatedPilihSemua(bool $value): void
    {
        if ($value) {
            $query = ProgramKerja::query()
                ->when($this->filterTahun !== 'semua', fn($q) => $q->where('tahun_anggaran', $this->filterTahun));
            $this->selectedProker = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedProker = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedProker = [];
        $this->pilihSemua = false;
    }

    public function setFilterTahun(string $tahun): void
    {
        $this->filterTahun = $tahun;
        $this->resetPage();
    }

    public function setFilterStatus(string $status): void
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->filterTahun = 'semua';
        $this->filterBidang = 'semua';
        $this->filterStatus = 'semua';
        $this->resetPage();
    }

    public function updateStatus(string $id, string $status): void
    {
        if (!in_array($status, ['rencana', 'berjalan', 'selesai', 'ditunda'])) return;
        $item = ProgramKerja::findOrFail($id);
        $item->status_kegiatan = $status;
        $item->save();
        session()->flash('pesan', 'Status program kerja "' . $item->nama_kegiatan . '" diubah menjadi ' . strtoupper($status) . '!');
    }

    public function bulkSetStatus(string $status): void
    {
        if (empty($this->selectedProker) || !in_array($status, ['rencana', 'berjalan', 'selesai', 'ditunda'])) return;
        ProgramKerja::whereIn('id', $this->selectedProker)->update(['status_kegiatan' => $status]);
        session()->flash('pesan', count($this->selectedProker) . ' program kerja berhasil diubah statusnya menjadi ' . strtoupper($status) . '.');
        $this->resetSelection();
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedProker)) return;
        ProgramKerja::whereIn('id', $this->selectedProker)->delete();
        session()->flash('pesan', count($this->selectedProker) . ' data program kerja berhasil dihapus.');
        $this->resetSelection();
    }

    public function resetInput(): void
    {
        $this->editId = null;
        $this->tahun_anggaran = (int) date('Y');
        $this->nama_bidang = '';
        $this->nama_kegiatan = '';
        $this->tujuan_kegiatan = '';
        $this->target_sasaran = '';
        $this->estimasi_anggaran = null;
        $this->status_kegiatan = 'rencana';
        $this->bulan_mulai = null;
        $this->bulan_selesai = null;
        $this->ikon = 'activity';
    }

    public function render()
    {
        $bidangList = ProgramKerja::whereNotNull('nama_bidang')->where('nama_bidang', '!=', '')->distinct()->pluck('nama_bidang')->sort()->values();
        $tahunList = ProgramKerja::distinct()->pluck('tahun_anggaran')->sortDesc()->values();

        $query = ProgramKerja::query()
            ->when($this->filterTahun !== 'semua', fn($q) => $q->where('tahun_anggaran', $this->filterTahun))
            ->when($this->filterBidang !== 'semua', fn($q) => $q->where('nama_bidang', $this->filterBidang))
            ->when($this->filterStatus !== 'semua', fn($q) => $q->where('status_kegiatan', $this->filterStatus))
            ->when($this->cari, fn($q) => $q->where(function($sub) {
                $sub->where('nama_kegiatan', 'like', "%{$this->cari}%")
                    ->orWhere('nama_bidang', 'like', "%{$this->cari}%")
                    ->orWhere('target_sasaran', 'like', "%{$this->cari}%")
                    ->orWhere('tujuan_kegiatan', 'like', "%{$this->cari}%");
            }));

        if (in_array($this->sortField, ['tahun_anggaran', 'nama_bidang', 'nama_kegiatan', 'estimasi_anggaran', 'status_kegiatan', 'bulan_mulai', 'created_at'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->orderByDesc('tahun_anggaran')->orderBy('nama_bidang')->orderBy('bulan_mulai');
        }

        $baseCountQuery = ProgramKerja::query()
            ->when($this->filterTahun !== 'semua', fn($q) => $q->where('tahun_anggaran', $this->filterTahun));

        $totalAnggaran = (clone $baseCountQuery)->sum('estimasi_anggaran');
        $statusCounts = [
            'rencana' => (clone $baseCountQuery)->where('status_kegiatan', 'rencana')->count(),
            'berjalan' => (clone $baseCountQuery)->where('status_kegiatan', 'berjalan')->count(),
            'selesai' => (clone $baseCountQuery)->where('status_kegiatan', 'selesai')->count(),
            'ditunda' => (clone $baseCountQuery)->where('status_kegiatan', 'ditunda')->count(),
        ];

        return view('livewire.admin.organisasi.proker-kelola', [
            'prokerList' => $query->paginate($this->perPage),
            'bidangList' => $bidangList,
            'tahunList' => $tahunList,
            'statusCounts' => $statusCounts,
            'totalProker' => ProgramKerja::count(),
            'totalProkerFilter' => (clone $baseCountQuery)->count(),
            'totalAnggaran' => $totalAnggaran,
            'totalAktifBerjalan' => ($statusCounts['berjalan'] + $statusCounts['selesai']),
        ]);
    }
}
