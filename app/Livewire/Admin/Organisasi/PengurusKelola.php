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
#[Title('Kelola Pengurus - KORMI CMS')]
class PengurusKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel';
    public string $cari = '';
    public string $filterPeriode = '';

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
        $periodeAktif = PeriodeKepengurusan::aktif()->first();
        if ($periodeAktif) {
            $this->periode_id = $periodeAktif->id;
            $this->filterPeriode = $periodeAktif->id;
        }
    }

    public function updatedCari(): void { $this->resetPage(); }
    public function updatedFilterPeriode(): void { $this->resetPage(); }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->resetInput();
    }

    public function bukaFormTambah(): void
    {
        $this->resetInput();
        $periodeAktif = PeriodeKepengurusan::aktif()->first();
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
        $this->status_tampil = $item->status_tampil;
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
            'kategori_bidang' => $this->kategori_bidang ?: null,
            'foto_url' => $pathFoto,
            'urutan' => $this->urutan,
            'status_tampil' => $this->status_tampil,
        ];

        if ($this->editId) {
            PengurusModel::findOrFail($this->editId)->update($data);
            session()->flash('pesan', 'Data pengurus berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            PengurusModel::create($data);
            session()->flash('pesan', 'Pengurus baru berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $item = PengurusModel::findOrFail($id);
        app(StorageService::class)->hapusFile($item->foto_url);
        $item->delete();
        session()->flash('pesan', 'Data pengurus berhasil dihapus.');
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

        $query = PengurusModel::with('periode')
            ->when($this->filterPeriode, fn($q) => $q->where('periode_id', $this->filterPeriode))
            ->when($this->cari, fn($q) => $q->where('nama_lengkap', 'like', "%{$this->cari}%")
                ->orWhere('jabatan', 'like', "%{$this->cari}%"))
            ->orderBy('urutan');

        return view('livewire.admin.organisasi.pengurus-kelola', [
            'periodeList' => $periodeList,
            'pengurusList' => $query->paginate(15),
            'totalPengurus' => PengurusModel::count(),
        ]);
    }
}
