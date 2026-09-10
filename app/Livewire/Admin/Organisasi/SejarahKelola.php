<?php

namespace App\Livewire\Admin\Organisasi;

use App\Models\LinimasaSejarah;
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
            ->when($this->cari, fn($q) => $q->where('judul', 'like', "%{$this->cari}%")
                ->orWhere('tahun', 'like', "%{$this->cari}%"))
            ->orderBy('urutan')
            ->orderBy('tahun');

        return view('livewire.admin.organisasi.sejarah-kelola', [
            'sejarahList' => $query->paginate(10),
            'totalSejarah' => LinimasaSejarah::count(),
        ]);
    }
}
