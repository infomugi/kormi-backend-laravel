<?php

namespace App\Livewire\Admin\Sapras;

use App\Models\Kecamatan;
use App\Models\Sapras as SaprasModel;
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
    public string $cari = '';
    public string $kategoriDipilih = 'Semua';

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
            'kecamatan_id'           => 'required|exists:kormi_kecamatan,id',
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
    }

    public function updatedKategoriDipilih(): void
    {
        $this->resetPage();
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
        app(StorageService::class)->hapusFile($item->foto_url);
        $item->delete();
        session()->flash('pesan', 'Fasilitas "' . $nama . '" berhasil dihapus.');
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

    public function render()
    {
        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();

        $query = SaprasModel::with('kecamatan')
            ->when($this->kategoriDipilih !== 'Semua', fn($q) => $q->where('kategori_fasilitas', $this->kategoriDipilih))
            ->when($this->cari, fn($q) => $q->where('nama_fasilitas', 'like', "%{$this->cari}%"))
            ->orderBy('nama_fasilitas');

        $totalFasilitas = SaprasModel::count();
        $totalKondisiBaik = SaprasModel::where('status_kondisi', 'Baik')->count();
        $totalKecamatan = SaprasModel::distinct('kecamatan_id')->count('kecamatan_id');

        return view('livewire.admin.sapras.sapras-kelola', [
            'kecamatanList' => $kecamatanList,
            'saprasList' => $query->paginate(10),
            'totalFasilitas' => $totalFasilitas,
            'totalKondisiBaik' => $totalKondisiBaik,
            'totalKecamatan' => $totalKecamatan,
        ]);
    }
}
