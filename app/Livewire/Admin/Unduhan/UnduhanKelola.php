<?php

namespace App\Livewire\Admin\Unduhan;

use App\Models\KategoriUnduhan;
use App\Models\Pengguna;
use App\Models\Unduhan;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Unduhan & Regulasi - KORMI CMS')]
class UnduhanKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel'; // 'tabel' atau 'form'
    public string $cari = '';
    public string $kategoriDipilih = 'Semua';

    // Backward compatibility for automated tests
    public bool $tampilkanModal = false;

    // Form fields
    public ?string $unduhanId = null;
    public string $judul_dokumen = '';
    public string $kategori_id = '';
    public string $berkas_path = '';       // path di MinIO
    public string $ekstensi_berkas = 'PDF';
    public string $ukuran_berkas = '';
    public string $deskripsi_singkat = '';
    public bool $status_publik = true;

    // File upload sementara
    public $uploadBerkas = null;

    protected function rules(): array
    {
        $rules = [
            'judul_dokumen'  => 'required|min:3|max:255',
            'kategori_id'    => 'required|exists:kormi_kategori_unduhan,id',
            'ekstensi_berkas'=> 'required|max:10',
        ];

        if (!$this->unduhanId) {
            $rules['uploadBerkas'] = 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:51200'; // max 50MB
        } else {
            $rules['uploadBerkas'] = 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:51200';
        }

        return $rules;
    }

    protected $messages = [
        'judul_dokumen.required'  => 'Judul dokumen wajib diisi.',
        'kategori_id.required'    => 'Kategori wajib dipilih.',
        'uploadBerkas.required'   => 'File dokumen wajib diunggah untuk data baru.',
        'uploadBerkas.file'       => 'Harus berupa file.',
        'uploadBerkas.mimes'      => 'Format file harus: pdf, doc, docx, xls, xlsx, ppt, pptx, zip, atau rar.',
        'uploadBerkas.max'        => 'Ukuran file maksimal 50 MB.',
    ];

    public function mount(): void
    {
        $firstKat = KategoriUnduhan::first();
        if ($firstKat) {
            $this->kategori_id = $firstKat->id;
        }
    }

    public function updatedCari(): void           { $this->resetPage(); }
    public function updatedKategoriDipilih(): void { $this->resetPage(); }

    /**
     * Update ekstensi dan ukuran otomatis saat file dipilih.
     */
    public function updatedUploadBerkas(): void
    {
        if ($this->uploadBerkas) {
            $storage = app(StorageService::class);
            $this->ekstensi_berkas = $storage->getEkstensi($this->uploadBerkas);
            $this->ukuran_berkas   = $storage->getUkuranBerkas($this->uploadBerkas);
        }
    }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->tampilkanModal = false;
        $this->resetForm();
    }

    public function bukaFormTambah(): void
    {
        $this->resetForm();
        $firstKat = KategoriUnduhan::first();
        if ($firstKat) {
            $this->kategori_id = $firstKat->id;
        }
        $this->mode = 'form';
        $this->tampilkanModal = true;
        $this->resetErrorBag();
    }

    public function bukaModalTambah(): void { $this->bukaFormTambah(); }

    public function bukaFormEdit(string $id): void
    {
        $u = Unduhan::findOrFail($id);
        $this->unduhanId       = $u->id;
        $this->judul_dokumen   = $u->judul_dokumen;
        $this->kategori_id     = $u->kategori_id;
        $this->berkas_path     = $u->berkas_path ?? '';
        $this->ekstensi_berkas = $u->ekstensi_berkas;
        $this->ukuran_berkas   = $u->ukuran_berkas;
        $this->status_publik   = (bool) $u->status_publik;
        $this->uploadBerkas    = null;
        $this->mode = 'form';
        $this->tampilkanModal = true;
        $this->resetErrorBag();
    }

    public function bukaModalEdit(string $id): void { $this->bukaFormEdit($id); }

    public function simpan(): void
    {
        $this->validate();

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $pengunggahId = auth()->id() ?? Pengguna::first()?->id ?? Unduhan::first()?->pengunggah_id;

        $pathBerkas     = $this->berkas_path;
        $ekstensi       = $this->ekstensi_berkas;
        $ukuran         = $this->ukuran_berkas;

        if ($this->uploadBerkas) {
            // Hapus berkas lama jika update
            if ($this->unduhanId && !empty($this->berkas_path)) {
                $storage->hapusFile($this->berkas_path);
            }
            $pathBerkas = $storage->uploadBerkas($this->uploadBerkas, 'unduhan');
            $ekstensi   = $storage->getEkstensi($this->uploadBerkas);
            $ukuran     = $storage->getUkuranBerkas($this->uploadBerkas);
        }

        $data = [
            'judul_dokumen'   => $this->judul_dokumen,
            'kategori_id'     => $this->kategori_id,
            'berkas_path'     => $pathBerkas,
            'ekstensi_berkas' => strtoupper($ekstensi),
            'ukuran_berkas'   => $ukuran,
            'status_publik'   => $this->status_publik,
            'pengunggah_id'   => $pengunggahId,
        ];

        if ($this->unduhanId) {
            Unduhan::findOrFail($this->unduhanId)->update($data);
            session()->flash('pesan', 'Dokumen unduhan berhasil diperbarui!');
        } else {
            $data['id']              = (string) Str::uuid();
            $data['jumlah_unduhan']  = 0;
            Unduhan::create($data);
            session()->flash('pesan', 'Dokumen baru berhasil ditambahkan ke repositori unduhan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $u     = Unduhan::findOrFail($id);
        $judul = $u->judul_dokumen;

        // Hapus berkas dari MinIO
        app(StorageService::class)->hapusFile($u->berkas_path);

        $u->delete();
        session()->flash('pesan', 'Dokumen "' . Str::limit($judul, 35) . '" berhasil dihapus.');
    }

    public function toggleStatusPublik(string $id): void
    {
        $u = Unduhan::findOrFail($id);
        $u->update(['status_publik' => !$u->status_publik]);
        session()->flash('pesan', 'Status publikasi dokumen diperbarui.');
    }

    public function resetForm(): void
    {
        $this->unduhanId       = null;
        $this->judul_dokumen   = '';
        $this->kategori_id     = '';
        $this->berkas_path     = '';
        $this->ekstensi_berkas = 'PDF';
        $this->ukuran_berkas   = '';
        $this->deskripsi_singkat = '';
        $this->status_publik   = true;
        $this->uploadBerkas    = null;
    }

    public function render()
    {
        $kategoriList = KategoriUnduhan::withCount('unduhan')->orderBy('nama_kategori')->get();

        $query = Unduhan::with('kategori', 'pengunggah')
            ->when($this->kategoriDipilih !== 'Semua', fn($q) => $q->where('kategori_id', $this->kategoriDipilih))
            ->when($this->cari, fn($q) => $q->where('judul_dokumen', 'like', '%' . $this->cari . '%'))
            ->orderByDesc('dibuat_pada');

        return view('livewire.admin.unduhan.unduhan-kelola', [
            'kategoriList'  => $kategoriList,
            'unduhanList'   => $query->paginate(10),
            'totalDokumen'  => Unduhan::count(),
            'totalPublik'   => Unduhan::where('status_publik', true)->count(),
            'totalHits'     => Unduhan::sum('jumlah_unduhan'),
        ]);
    }
}
