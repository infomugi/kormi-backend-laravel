<?php

namespace App\Livewire\Admin\Organisasi;

use App\Models\PengurusModel;
use App\Models\PeriodeKepengurusan;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Struktur Pengurus - KORMI CMS')]
class PengurusKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel';
    public string $cari = '';
    public string $filterPeriode = '';
    public string $filterBidang = 'semua';
    public string $statusFilter = 'Semua';

    // Sorting & Pagination
    public string $sortField = 'urutan';
    public string $sortDirection = 'asc';
    public int $perPage = 10;
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'

    // Bulk selection
    public array $selectedPengurus = [];
    public bool $pilihSemua = false;

    // Form fields
    public ?string $editId = null;
    public string $periode_id = '';
    public string $nama_lengkap = '';
    public string $jabatan = '';
    public string $kategori_bidang = '';
    public string $foto_url = '';
    public $uploadFoto = null;
    public int $urutan = 0;
    public bool $status_tampil = true;

    protected function rules(): array
    {
        return [
            'periode_id' => 'required|exists:kormi_periode_kepengurusan,id',
            'nama_lengkap' => 'required|string|min:2|max:150',
            'jabatan' => 'required|string|min:2|max:100',
            'kategori_bidang' => 'nullable|string|max:100',
            'urutan' => 'integer|min:0',
            'status_tampil' => 'boolean',
            'uploadFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ];
    }

    public function mount(): void
    {
        $periodeAktif = PeriodeKepengurusan::aktif()->first() ?? PeriodeKepengurusan::orderByDesc('tahun_mulai')->first();
        if ($periodeAktif) {
            $this->periode_id = $periodeAktif->id;
            $this->filterPeriode = $periodeAktif->id;
        }
    }

    public function updatedCari(): void { $this->resetPage(); }
    public function updatedFilterPeriode(): void { $this->resetPage(); }
    public function updatedFilterBidang(): void { $this->resetPage(); }
    public function updatedStatusFilter(): void { $this->resetPage(); }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->resetInput();
    }

    public function bukaFormTambah(): void
    {
        $this->resetInput();
        $periodeAktif = PeriodeKepengurusan::aktif()->first() ?? PeriodeKepengurusan::orderByDesc('tahun_mulai')->first();
        if ($periodeAktif) {
            $this->periode_id = $periodeAktif->id;
        }
        $this->mode = 'form';
        $this->resetErrorBag();
    }

    public function bukaFormEdit(string $id): void
    {
        $item = PengurusModel::findOrFail($id);
        $this->editId = $item->id;
        $this->periode_id = $item->periode_id;
        $this->nama_lengkap = $item->nama_lengkap;
        $this->jabatan = $item->jabatan;
        $this->kategori_bidang = $item->kategori_bidang ?? '';
        $this->foto_url = $item->foto_url ?? '';
        $this->urutan = $item->urutan;
        $this->status_tampil = (bool) $item->status_tampil;
        $this->uploadFoto = null;
        $this->mode = 'form';
        $this->resetErrorBag();
    }

    public function simpan(): void
    {
        $this->validate();

        $storage = app(StorageService::class);

        $pathFoto = $this->foto_url;
        if ($this->uploadFoto) {
            if ($this->editId && !empty($this->foto_url)) {
                $storage->hapusFile($this->foto_url);
            }
            $pathFoto = $storage->uploadGambar($this->uploadFoto, 'pengurus');
        }

        $data = [
            'periode_id' => $this->periode_id,
            'nama_lengkap' => trim($this->nama_lengkap),
            'jabatan' => trim($this->jabatan),
            'kategori_bidang' => $this->kategori_bidang ? trim($this->kategori_bidang) : null,
            'foto_url' => $pathFoto,
            'urutan' => $this->urutan,
            'status_tampil' => $this->status_tampil,
        ];

        if ($this->editId) {
            PengurusModel::findOrFail($this->editId)->update($data);
            session()->flash('pesan', 'Data pengurus ' . $this->nama_lengkap . ' berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            PengurusModel::create($data);
            session()->flash('pesan', 'Pengurus baru ' . $this->nama_lengkap . ' berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $item = PengurusModel::findOrFail($id);
        if ($item->foto_url) {
            app(StorageService::class)->hapusFile($item->foto_url);
        }
        $nama = $item->nama_lengkap;
        $item->delete();
        session()->flash('pesan', 'Data pengurus ' . $nama . ' berhasil dihapus.');
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
            $query = PengurusModel::query()
                ->when($this->filterPeriode, fn($q) => $q->where('periode_id', $this->filterPeriode));
            $this->selectedPengurus = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedPengurus = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedPengurus = [];
        $this->pilihSemua = false;
    }

    public function setFilterPeriode(string $periodeId): void
    {
        $this->filterPeriode = $periodeId;
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
        $this->filterBidang = 'semua';
        $this->statusFilter = 'Semua';
        $this->resetPage();
    }

    public function toggleStatus(string $id): void
    {
        $item = PengurusModel::findOrFail($id);
        $item->status_tampil = !$item->status_tampil;
        $item->save();
        session()->flash('pesan', 'Status visibilitas ' . $item->nama_lengkap . ' berhasil diperbarui!');
    }

    public function bulkSetStatus(bool $status): void
    {
        if (empty($this->selectedPengurus)) return;
        PengurusModel::whereIn('id', $this->selectedPengurus)->update(['status_tampil' => $status]);
        $text = $status ? 'ditampilkan di publik' : 'disembunyikan';
        session()->flash('pesan', count($this->selectedPengurus) . ' pengurus berhasil ' . $text . '.');
        $this->resetSelection();
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedPengurus)) return;
        $items = PengurusModel::whereIn('id', $this->selectedPengurus)->get();
        $storage = app(StorageService::class);
        foreach ($items as $item) {
            if ($item->foto_url) {
                $storage->hapusFile($item->foto_url);
            }
            $item->delete();
        }
        session()->flash('pesan', count($this->selectedPengurus) . ' data pengurus berhasil dihapus.');
        $this->resetSelection();
    }

    public function resetInput(): void
    {
        $this->editId = null;
        $this->nama_lengkap = '';
        $this->jabatan = '';
        $this->kategori_bidang = '';
        $this->foto_url = '';
        $this->uploadFoto = null;
        $this->urutan = 0;
        $this->status_tampil = true;
    }

    public function render()
    {
        $periodeList = PeriodeKepengurusan::orderByDesc('tahun_mulai')->get();
        $periodeAktifId = PeriodeKepengurusan::aktif()->value('id');

        $bidangList = PengurusModel::whereNotNull('kategori_bidang')
            ->where('kategori_bidang', '!=', '')
            ->distinct()
            ->pluck('kategori_bidang')
            ->toArray();

        $query = PengurusModel::with('periode')
            ->when($this->filterPeriode, fn($q) => $q->where('periode_id', $this->filterPeriode))
            ->when($this->filterBidang !== 'semua', fn($q) => $q->where('kategori_bidang', $this->filterBidang))
            ->when($this->statusFilter !== 'Semua', function ($q) {
                if ($this->statusFilter === 'Tampil') {
                    $q->where('status_tampil', true);
                } elseif ($this->statusFilter === 'Disembunyikan') {
                    $q->where('status_tampil', false);
                }
            })
            ->when($this->cari, fn($q) => $q->where(function($sub) {
                $sub->where('nama_lengkap', 'like', "%{$this->cari}%")
                    ->orWhere('jabatan', 'like', "%{$this->cari}%")
                    ->orWhere('kategori_bidang', 'like', "%{$this->cari}%");
            }));

        if (in_array($this->sortField, ['urutan', 'nama_lengkap', 'jabatan', 'kategori_bidang', 'status_tampil', 'created_at'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->orderBy('urutan')->orderBy('nama_lengkap');
        }

        $baseCountQuery = PengurusModel::query()
            ->when($this->filterPeriode, fn($q) => $q->where('periode_id', $this->filterPeriode));

        return view('livewire.admin.organisasi.pengurus-kelola', [
            'periodeList' => $periodeList,
            'bidangList' => $bidangList,
            'pengurusList' => $query->paginate($this->perPage),
            'totalPengurus' => PengurusModel::count(),
            'totalPengurusPeriode' => (clone $baseCountQuery)->count(),
            'totalTampil' => (clone $baseCountQuery)->where('status_tampil', true)->count(),
            'totalSembunyi' => (clone $baseCountQuery)->where('status_tampil', false)->count(),
            'totalBidang' => count($bidangList),
            'namaPeriodeAktif' => PeriodeKepengurusan::find($this->filterPeriode)?->nama_periode ?? 'Semua Periode',
        ]);
    }
}
