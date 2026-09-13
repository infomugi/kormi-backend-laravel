<?php

namespace App\Livewire\Backend\Kormi\Organisasi;

use App\Models\Kormi\VisiMisiModel;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Visi & Misi - KORMI CMS')]
class VisiMisiKelola extends Component
{
    use WithPagination;

    public string $mode = 'tabel';
    public string $cari = '';
    public string $filterJenis = 'semua';
    public string $statusFilter = 'Semua';

    // Sorting & Pagination
    public string $sortField = 'urutan';
    public string $sortDirection = 'asc';
    public int $perPage = 10;
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'

    // Bulk selection
    public array $selectedVisiMisi = [];
    public bool $pilihSemua = false;

    // Form fields
    public ?string $editId = null;
    public string $jenis = 'misi';
    public string $konten = '';
    public string $ikon = '';
    public int $urutan = 0;
    public bool $status_tampil = true;

    protected function rules(): array
    {
        return [
            'jenis' => 'required|in:visi,misi,nilai_utama,motto,tujuan',
            'konten' => 'required|string|min:5',
            'ikon' => 'nullable|string|max:50',
            'urutan' => 'integer|min:0',
            'status_tampil' => 'boolean',
        ];
    }

    public function updatedCari(): void
    {
        $this->resetPage();
    }

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
        $item = VisiMisiModel::findOrFail($id);
        $this->editId = $item->id;
        $this->jenis = $item->jenis;
        $this->konten = $item->konten;
        $this->ikon = $item->ikon ?? '';
        $this->urutan = $item->urutan;
        $this->status_tampil = (bool) $item->status_tampil;
        $this->mode = 'form';
        $this->resetErrorBag();
    }

    public function simpan(): void
    {
        $this->validate();

        $data = [
            'jenis' => $this->jenis,
            'konten' => trim($this->konten),
            'ikon' => $this->ikon ? trim($this->ikon) : null,
            'urutan' => $this->urutan,
            'status_tampil' => $this->status_tampil,
        ];

        if ($this->editId) {
            VisiMisiModel::findOrFail($this->editId)->update($data);
            session()->flash('pesan', 'Data visi/misi berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            VisiMisiModel::create($data);
            session()->flash('pesan', 'Data visi/misi baru berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        VisiMisiModel::findOrFail($id)->delete();
        session()->flash('pesan', 'Data visi/misi berhasil dihapus.');
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
            $this->selectedVisiMisi = VisiMisiModel::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedVisiMisi = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedVisiMisi = [];
        $this->pilihSemua = false;
    }

    public function setFilterJenis(string $jenis): void
    {
        $this->filterJenis = $jenis;
        $this->resetPage();
    }

    public function setFilterStatus(string $status): void
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->filterJenis = 'semua';
        $this->statusFilter = 'Semua';
        $this->resetPage();
    }

    public function toggleStatus(string $id): void
    {
        $item = VisiMisiModel::findOrFail($id);
        $item->status_tampil = !$item->status_tampil;
        $item->save();
        session()->flash('pesan', 'Status visibilitas data ' . strtoupper($item->jenis) . ' berhasil diperbarui!');
    }

    public function bulkSetStatus(bool $status): void
    {
        if (empty($this->selectedVisiMisi)) return;
        VisiMisiModel::whereIn('id', $this->selectedVisiMisi)->update(['status_tampil' => $status]);
        $text = $status ? 'ditampilkan di publik' : 'disembunyikan';
        session()->flash('pesan', count($this->selectedVisiMisi) . ' butir visi/misi berhasil ' . $text . '.');
        $this->resetSelection();
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedVisiMisi)) return;
        VisiMisiModel::whereIn('id', $this->selectedVisiMisi)->delete();
        session()->flash('pesan', count($this->selectedVisiMisi) . ' butir visi/misi berhasil dihapus.');
        $this->resetSelection();
    }

    public function resetInput(): void
    {
        $this->editId = null;
        $this->jenis = 'misi';
        $this->konten = '';
        $this->ikon = '';
        $this->urutan = 0;
        $this->status_tampil = true;
    }

    public function render()
    {
        $jenisOptions = ['visi', 'misi', 'nilai_utama', 'motto', 'tujuan'];
        $jenisLabels = [
            'visi' => 'Visi',
            'misi' => 'Misi',
            'nilai_utama' => 'Nilai Utama',
            'motto' => 'Motto',
            'tujuan' => 'Tujuan',
        ];

        $query = VisiMisiModel::query()
            ->when($this->filterJenis !== 'semua', fn($q) => $q->where('jenis', $this->filterJenis))
            ->when($this->statusFilter !== 'Semua', function ($q) {
                if ($this->statusFilter === 'Tampil') {
                    $q->where('status_tampil', true);
                } elseif ($this->statusFilter === 'Disembunyikan') {
                    $q->where('status_tampil', false);
                }
            })
            ->when($this->cari, fn($q) => $q->where('konten', 'like', "%{$this->cari}%")
                ->orWhere('jenis', 'like', "%{$this->cari}%")
                ->orWhere('ikon', 'like', "%{$this->cari}%"));

        if (in_array($this->sortField, ['urutan', 'jenis', 'konten', 'status_tampil', 'created_at'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->orderBy('jenis')->orderBy('urutan');
        }

        $counts = [];
        foreach ($jenisOptions as $j) {
            $counts[$j] = VisiMisiModel::where('jenis', $j)->count();
        }

        return view('livewire.backend.kormi.organisasi.visimisi-kelola', [
            'visiMisiList' => $query->paginate($this->perPage),
            'jenisOptions' => $jenisOptions,
            'jenisLabels' => $jenisLabels,
            'counts' => $counts,
            'totalVisiMisi' => VisiMisiModel::count(),
            'totalTampil' => VisiMisiModel::where('status_tampil', true)->count(),
            'totalSembunyi' => VisiMisiModel::where('status_tampil', false)->count(),
        ]);
    }
}
