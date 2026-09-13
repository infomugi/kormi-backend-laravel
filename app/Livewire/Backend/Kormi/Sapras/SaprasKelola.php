<?php

namespace App\Livewire\Backend\Kormi\Sapras;

use App\Models\Master\Kecamatan;
use App\Models\Kormi\Sapras as SaprasModel;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Sarana & Prasarana Olahraga - KORMI CMS')]
class SaprasKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel'; // 'tabel' atau 'form'
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'
    public string $cari = '';
    public string $kategoriDipilih = 'Semua';
    public string $statusKondisiFilter = 'Semua'; // 'Semua', 'Baik', 'Perlu Renovasi', 'Dalam Pembangunan'
    public string $kecamatanFilter = 'Semua';
    public string $sortField = 'nama_fasilitas';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    // Bulk selection
    public array $selectedSapras = [];
    public bool $pilihSemua = false;

    // Backward compatibility for automated tests
    public bool $tampilkanModal = false;

    // Form fields
    public ?string $editId = null;
    public string $kecamatan_id = '';
    public string $nama_fasilitas = '';
    public string $kategori_fasilitas = 'Stadion';
    public string $alamat_lengkap = '';
    public string $kapasitas = '5.000 orang';
    public string $status_kondisi = 'Baik';
    public string $jenis_olahraga_tersedia = 'Senam, Egrang, Sepakbola, Atletik Rekreasi';
    public string $foto_url = '';      // path MinIO
    public $uploadFoto = null;         // file upload sementara

    protected function rules(): array
    {
        $rules = [
            'kecamatan_id'           => 'required|exists:ref_kecamatan,id',
            'nama_fasilitas'         => 'required|min:3|max:150',
            'kategori_fasilitas'     => 'required|string',
            'alamat_lengkap'         => 'required|min:5',
            'status_kondisi'         => 'required|in:Baik,Perlu Renovasi,Dalam Pembangunan',
            'jenis_olahraga_tersedia'=> 'required|string',
        ];

        $rules['uploadFoto'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240';

        return $rules;
    }

    protected $messages = [
        'uploadFoto.required' => 'Foto fasilitas wajib diunggah untuk data baru.',
        'uploadFoto.image'    => 'File harus berupa gambar.',
        'uploadFoto.mimes'    => 'Format gambar harus jpg, jpeg, png, atau webp.',
        'uploadFoto.max'      => 'Ukuran foto maksimal 10 MB.',
    ];

    public function mount(): void
    {
        $firstKec = Kecamatan::first();
        if ($firstKec) {
            $this->kecamatan_id = $firstKec->id;
        }
    }

    public function updatedCari(): void
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedKategoriDipilih(): void
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedStatusKondisiFilter(): void
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedKecamatanFilter(): void
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedPerPage(): void
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
        $this->resetPage();
    }

    public function updatedPilihSemua(bool $value): void
    {
        if ($value) {
            $this->selectedSapras = $this->getSaprasQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedSapras = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedSapras = [];
        $this->pilihSemua = false;
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->kategoriDipilih = 'Semua';
        $this->statusKondisiFilter = 'Semua';
        $this->kecamatanFilter = 'Semua';
        $this->sortField = 'nama_fasilitas';
        $this->sortDirection = 'asc';
        $this->resetPage();
        $this->resetSelection();
    }

    public function setFilterKategori(string $kategori): void
    {
        $this->kategoriDipilih = $kategori;
        $this->resetPage();
        $this->resetSelection();
    }

    public function setFilterStatus(string $status): void
    {
        $this->statusKondisiFilter = $status;
        $this->resetPage();
        $this->resetSelection();
    }

    public function setFilterKecamatan(string $kecamatanId): void
    {
        $this->kecamatanFilter = $kecamatanId;
        $this->resetPage();
        $this->resetSelection();
    }

    public function bulkSetKondisi(string $kondisi): void
    {
        if (empty($this->selectedSapras)) return;

        SaprasModel::whereIn('id', $this->selectedSapras)->update(['status_kondisi' => $kondisi]);
        $count = count($this->selectedSapras);
        session()->flash('pesan', "Status kondisi {$count} fasilitas berhasil diubah menjadi {$kondisi}.");
        $this->resetSelection();
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedSapras)) return;

        $items = SaprasModel::whereIn('id', $this->selectedSapras)->get();
        $storage = app(StorageService::class);

        foreach ($items as $item) {
            if ($item->foto_url) {
                $storage->hapusFile($item->foto_url);
            }
            $item->delete();
        }

        $count = count($this->selectedSapras);
        session()->flash('pesan', "{$count} data fasilitas berhasil dihapus.");
        $this->resetSelection();
    }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->tampilkanModal = false;
        $this->resetInput();
    }

    public function bukaFormTambah(): void
    {
        $this->resetInput();
        $firstKec = Kecamatan::first();
        if ($firstKec) {
            $this->kecamatan_id = $firstKec->id;
        }
        $this->mode = 'form';
        $this->tampilkanModal = true;
        $this->resetErrorBag();
    }

    public function bukaModalTambah(): void
    {
        $this->bukaFormTambah();
    }

    public function bukaFormEdit(string $id): void
    {
        $item = SaprasModel::findOrFail($id);
        $this->editId                  = $item->id;
        $this->kecamatan_id            = $item->kecamatan_id;
        $this->nama_fasilitas          = $item->nama_fasilitas;
        $this->kategori_fasilitas      = $item->kategori_fasilitas;
        $this->alamat_lengkap          = $item->alamat_lengkap;
        $this->kapasitas               = $item->kapasitas ?? '';
        $this->status_kondisi          = $item->status_kondisi;
        $this->jenis_olahraga_tersedia = $item->jenis_olahraga_tersedia;
        $this->foto_url                = $item->foto_url ?? '';
        $this->uploadFoto              = null;
        $this->mode = 'form';
        $this->tampilkanModal = true;
        $this->resetErrorBag();
    }

    public function bukaModalEdit(string $id): void
    {
        $this->bukaFormEdit($id);
    }

    public function setPresetFoto(string $url): void
    {
        // Dipertahankan untuk kompatibilitas view lama — tidak digunakan saat MinIO aktif
        $this->foto_url = $url;
    }

    public function simpan(): void
    {
        $this->validate();

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $pathFoto = $this->foto_url;
        if ($this->uploadFoto) {
            if ($this->editId && !empty($this->foto_url)) {
                $storage->hapusFile($this->foto_url);
            }
            $pathFoto = $storage->uploadGambar($this->uploadFoto, 'sapras');
        }

        $data = [
            'kecamatan_id'           => $this->kecamatan_id,
            'nama_fasilitas'         => trim($this->nama_fasilitas),
            'kategori_fasilitas'     => $this->kategori_fasilitas,
            'alamat_lengkap'         => trim($this->alamat_lengkap),
            'kapasitas'              => $this->kapasitas,
            'status_kondisi'         => $this->status_kondisi,
            'jenis_olahraga_tersedia'=> $this->jenis_olahraga_tersedia,
            'foto_url'               => $pathFoto,
        ];

        if ($this->editId) {
            $item = SaprasModel::findOrFail($this->editId);
            $item->update($data);
            session()->flash('pesan', 'Fasilitas "' . $this->nama_fasilitas . '" berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            SaprasModel::create($data);
            session()->flash('pesan', 'Fasilitas baru berhasil ditambahkan ke direktori!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $item = SaprasModel::findOrFail($id);
        $nama = $item->nama_fasilitas;
        if ($item->foto_url) {
            app(StorageService::class)->hapusFile($item->foto_url);
        }
        $item->delete();
        session()->flash('pesan', 'Fasilitas "' . $nama . '" berhasil dihapus.');
        $this->resetSelection();
    }

    public function resetInput(): void
    {
        $this->editId                  = null;
        $this->nama_fasilitas          = '';
        $this->kategori_fasilitas      = 'Stadion';
        $this->alamat_lengkap          = '';
        $this->kapasitas               = '';
        $this->status_kondisi          = 'Baik';
        $this->jenis_olahraga_tersedia = 'Senam, Olahraga Tradisional, Kebugaran';
        $this->foto_url                = '';
        $this->uploadFoto              = null;
    }

    protected function getSaprasQuery()
    {
        $allowedSorts = ['nama_fasilitas', 'kategori_fasilitas', 'status_kondisi', 'created_at'];
        $sort = in_array($this->sortField, $allowedSorts) ? $this->sortField : 'nama_fasilitas';
        $direction = strtolower($this->sortDirection) === 'desc' ? 'desc' : 'asc';

        return SaprasModel::with('kecamatan')
            ->when($this->kategoriDipilih !== 'Semua', fn($q) => $q->where('kategori_fasilitas', $this->kategoriDipilih))
            ->when($this->statusKondisiFilter !== 'Semua', fn($q) => $q->where('status_kondisi', $this->statusKondisiFilter))
            ->when($this->kecamatanFilter !== 'Semua', fn($q) => $q->where('kecamatan_id', $this->kecamatanFilter))
            ->when($this->cari, fn($q) => $q->where(function ($sub) {
                $sub->where('nama_fasilitas', 'like', "%{$this->cari}%")
                    ->orWhere('alamat_lengkap', 'like', "%{$this->cari}%")
                    ->orWhere('jenis_olahraga_tersedia', 'like', "%{$this->cari}%")
                    ->orWhereHas('kecamatan', fn($kq) => $kq->where('nama_kecamatan', 'like', "%{$this->cari}%"));
            }))
            ->orderBy($sort, $direction);
    }

    public function render()
    {
        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();
        $saprasList = $this->getSaprasQuery()->paginate($this->perPage);

        $totalFasilitas = SaprasModel::count();
        $totalKondisiBaik = SaprasModel::where('status_kondisi', 'Baik')->count();
        $totalRenovasi = SaprasModel::where('status_kondisi', 'Perlu Renovasi')->count();
        $totalKecamatan = SaprasModel::distinct('kecamatan_id')->count('kecamatan_id');

        return view('livewire.backend.kormi.sapras.sapras-kelola', [
            'kecamatanList' => $kecamatanList,
            'saprasList' => $saprasList,
            'totalFasilitas' => $totalFasilitas,
            'totalKondisiBaik' => $totalKondisiBaik,
            'totalRenovasi' => $totalRenovasi,
            'totalKecamatan' => $totalKecamatan,
        ]);
    }
}
