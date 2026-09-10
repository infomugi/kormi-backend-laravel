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
    public string $filterTahun = '';
    public string $filterBidang = '';

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
            'tujuan_kegiatan' => $this->tujuan_kegiatan ?: null,
            'target_sasaran' => $this->target_sasaran ?: null,
            'estimasi_anggaran' => $this->estimasi_anggaran,
            'status_kegiatan' => $this->status_kegiatan,
            'bulan_mulai' => $this->bulan_mulai,
            'bulan_selesai' => $this->bulan_selesai,
            'ikon' => $this->ikon ?: 'activity',
        ];

        if ($this->editId) {
            ProgramKerja::findOrFail($this->editId)->update($data);
            session()->flash('pesan', 'Program kerja berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            ProgramKerja::create($data);
            session()->flash('pesan', 'Program kerja baru berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $item = ProgramKerja::findOrFail($id);
        $item->delete();
        session()->flash('pesan', 'Program kerja berhasil dihapus.');
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
        $bidangList = ProgramKerja::distinct()->pluck('nama_bidang')->sort()->values();
        $tahunList = ProgramKerja::distinct()->pluck('tahun_anggaran')->sort()->values();

        $query = ProgramKerja::query()
            ->when($this->filterTahun, fn($q) => $q->where('tahun_anggaran', $this->filterTahun))
            ->when($this->filterBidang, fn($q) => $q->where('nama_bidang', $this->filterBidang))
            ->when($this->cari, fn($q) => $q->where('nama_kegiatan', 'like', "%{$this->cari}%"))
            ->orderByDesc('tahun_anggaran')
            ->orderBy('nama_bidang')
            ->orderBy('bulan_mulai');

        $statusCounts = [
            'rencana' => ProgramKerja::where('status_kegiatan', 'rencana')->count(),
            'berjalan' => ProgramKerja::where('status_kegiatan', 'berjalan')->count(),
            'selesai' => ProgramKerja::where('status_kegiatan', 'selesai')->count(),
            'ditunda' => ProgramKerja::where('status_kegiatan', 'ditunda')->count(),
        ];

        return view('livewire.admin.organisasi.proker-kelola', [
            'prokerList' => $query->paginate(15),
            'bidangList' => $bidangList,
            'tahunList' => $tahunList,
            'statusCounts' => $statusCounts,
            'totalProker' => ProgramKerja::count(),
        ]);
    }
}
