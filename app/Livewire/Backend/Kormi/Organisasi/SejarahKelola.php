<?php

namespace App\Livewire\Backend\Kormi\Organisasi;

use App\Models\Kormi\LinimasaSejarah;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Sejarah / Linimasa - KORMI CMS')]
class SejarahKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel';
    public string $cari = '';
    public string $statusFilter = 'Semua';

    // Sorting & Pagination
    public string $sortField = 'urutan';
    public string $sortDirection = 'asc';
    public int $perPage = 10;
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'

    // Bulk selection
    public array $selectedSejarah = [];
    public bool $pilihSemua = false;

    // Form fields
    public ?string $editId = null;
    public string $tahun = '';
    public string $judul = '';
    public string $deskripsi = '';
    public string $gambar_url = '';
    public $uploadGambar = null;
    public int $urutan = 0;
    public bool $status_tampil = true;

    protected function rules(): array
    {
        return [
            'tahun' => 'required|string|max:10',
            'judul' => 'required|string|min:3|max:200',
            'deskripsi' => 'required|string|min:10',
            'urutan' => 'integer|min:0',
            'status_tampil' => 'boolean',
            'uploadGambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
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
        $item = LinimasaSejarah::findOrFail($id);
        $this->editId = $item->id;
        $this->tahun = $item->tahun;
        $this->judul = $item->judul;
        $this->deskripsi = $item->deskripsi;
        $this->gambar_url = $item->gambar_url ?? '';
        $this->urutan = $item->urutan;
        $this->status_tampil = $item->status_tampil;
        $this->uploadGambar = null;
        $this->mode = 'form';
        $this->resetErrorBag();
    }

    public function simpan(): void
    {
        $this->validate();

        $storage = app(StorageService::class);

        $pathGambar = $this->gambar_url;
        if ($this->uploadGambar) {
            if ($this->editId && !empty($this->gambar_url)) {
                $storage->hapusFile($this->gambar_url);
            }
            $pathGambar = $storage->uploadGambar($this->uploadGambar, 'sejarah');
        }

        $data = [
            'tahun' => $this->tahun,
            'judul' => trim($this->judul),
            'deskripsi' => trim($this->deskripsi),
            'gambar_url' => $pathGambar,
            'urutan' => $this->urutan,
            'status_tampil' => $this->status_tampil,
        ];

        if ($this->editId) {
            LinimasaSejarah::findOrFail($this->editId)->update($data);
            session()->flash('pesan', 'Timeline sejarah berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            LinimasaSejarah::create($data);
            session()->flash('pesan', 'Timeline sejarah baru berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $item = LinimasaSejarah::findOrFail($id);
        app(StorageService::class)->hapusFile($item->gambar_url);
        $item->delete();
        session()->flash('pesan', 'Timeline sejarah berhasil dihapus.');
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
            $this->selectedSejarah = LinimasaSejarah::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedSejarah = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedSejarah = [];
        $this->pilihSemua = false;
    }

    public function setFilterStatus(string $status): void
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->statusFilter = 'Semua';
        $this->resetPage();
    }

    public function toggleStatus(string $id): void
    {
        $item = LinimasaSejarah::findOrFail($id);
        $item->status_tampil = !$item->status_tampil;
        $item->save();
        session()->flash('pesan', 'Status visibilitas timeline tahun ' . $item->tahun . ' berhasil diperbarui!');
    }

    public function bulkSetStatus(bool $status): void
    {
        if (empty($this->selectedSejarah)) return;
        LinimasaSejarah::whereIn('id', $this->selectedSejarah)->update(['status_tampil' => $status]);
        $text = $status ? 'ditampilkan di publik' : 'disembunyikan';
        session()->flash('pesan', count($this->selectedSejarah) . ' timeline sejarah berhasil ' . $text . '.');
        $this->resetSelection();
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedSejarah)) return;
        $items = LinimasaSejarah::whereIn('id', $this->selectedSejarah)->get();
        $storage = app(StorageService::class);
        foreach ($items as $item) {
            $storage->hapusFile($item->gambar_url);
            $item->delete();
        }
        session()->flash('pesan', count($this->selectedSejarah) . ' data timeline sejarah berhasil dihapus.');
        $this->resetSelection();
    }

    public function resetInput(): void
    {
        $this->editId = null;
        $this->tahun = '';
        $this->judul = '';
        $this->deskripsi = '';
        $this->gambar_url = '';
        $this->uploadGambar = null;
        $this->urutan = 0;
        $this->status_tampil = true;
    }

    public function render()
    {
        $query = LinimasaSejarah::query()
            ->when($this->statusFilter !== 'Semua', function ($q) {
                if ($this->statusFilter === 'Tampil') {
                    $q->where('status_tampil', true);
                } elseif ($this->statusFilter === 'Disembunyikan') {
                    $q->where('status_tampil', false);
                }
            })
            ->when($this->cari, fn($q) => $q->where('judul', 'like', "%{$this->cari}%")
                ->orWhere('tahun', 'like', "%{$this->cari}%")
                ->orWhere('deskripsi', 'like', "%{$this->cari}%"));

        if (in_array($this->sortField, ['urutan', 'tahun', 'judul', 'status_tampil', 'created_at'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->orderBy('urutan')->orderBy('tahun');
        }

        return view('livewire.backend.kormi.organisasi.sejarah-kelola', [
            'sejarahList' => $query->paginate($this->perPage),
            'totalSejarah' => LinimasaSejarah::count(),
            'totalTampil' => LinimasaSejarah::where('status_tampil', true)->count(),
            'totalSembunyi' => LinimasaSejarah::where('status_tampil', false)->count(),
            'tahunPertama' => LinimasaSejarah::orderBy('tahun')->value('tahun'),
            'tahunTerakhir' => LinimasaSejarah::orderByDesc('tahun')->value('tahun'),
        ]);
    }
}
