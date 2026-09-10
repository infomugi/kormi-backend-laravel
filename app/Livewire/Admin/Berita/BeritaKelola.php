<?php

namespace App\Livewire\Admin\Berita;

use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\Pengguna;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Berita & Artikel - KORMI CMS')]
class BeritaKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel'; // 'tabel' atau 'form'
    public string $cari = '';
    public string $kategoriDipilih = 'Semua';
    public string $statusDipilih = 'Semua';

    // Form state
    public bool $tampilkanModal = false;
    public bool $tampilkanModalHapus = false;
    public ?string $beritaId = null;
    public string $judul = '';
    public string $kategori_id = '';
    public string $ringkasan = '';
    public string $isi_konten = '';
    public string $gambar_utama = ''; // menyimpan path MinIO yang sudah diupload
    public string $status_publikasi = 'published';
    public bool $status_unggulan = false;

    // File upload sementara
    public $uploadGambar = null;

    // Progress/status upload
    public bool $uploadingGambar = false;

    protected function rules(): array
    {
        $rules = [
            'judul'            => 'required|min:5|max:255',
            'kategori_id'      => 'required|exists:kormi_kategori_berita,id',
            'ringkasan'        => 'required|max:500',
            'isi_konten'       => 'required|min:10',
            'status_publikasi' => 'required|in:draft,published,archived',
        ];

        // Saat buat baru, gambar wajib diupload
        if (!$this->beritaId) {
            $rules['uploadGambar'] = 'required|image|mimes:jpg,jpeg,png,webp|max:5120'; // max 5MB
        } else {
            $rules['uploadGambar'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120';
        }

        return $rules;
    }

    protected $messages = [
        'judul.required'           => 'Judul berita wajib diisi.',
        'judul.min'                => 'Judul minimal 5 karakter.',
        'kategori_id.required'     => 'Kategori berita wajib dipilih.',
        'ringkasan.required'       => 'Ringkasan berita wajib diisi.',
        'isi_konten.required'      => 'Isi konten wajib diisi.',
        'uploadGambar.required'    => 'Gambar utama wajib diunggah untuk berita baru.',
        'uploadGambar.image'       => 'File harus berupa gambar.',
        'uploadGambar.mimes'       => 'Format gambar harus: jpg, jpeg, png, atau webp.',
        'uploadGambar.max'         => 'Ukuran gambar maksimal 5 MB.',
    ];

    public function updatedCari(): void
    {
        $this->resetPage();
    }

    public function updatedKategoriDipilih(): void
    {
        $this->resetPage();
    }

    public function updatedStatusDipilih(): void
    {
        $this->resetPage();
    }

    public function bukaFormTambah(): void
    {
        $this->reset(['beritaId', 'judul', 'kategori_id', 'ringkasan', 'isi_konten', 'gambar_utama', 'status_unggulan', 'uploadGambar']);
        $this->status_publikasi = 'published';
        $firstKat = KategoriBerita::first();
        $this->kategori_id = $firstKat ? $firstKat->id : '';
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
        $berita = Berita::findOrFail($id);
        $this->beritaId     = $berita->id;
        $this->judul        = $berita->judul;
        $this->kategori_id  = $berita->kategori_id;
        $this->ringkasan    = $berita->ringkasan;
        $this->isi_konten   = $berita->isi_konten;
        $this->gambar_utama = $berita->gambar_utama;
        $this->status_publikasi = $berita->status_publikasi;
        $this->status_unggulan  = (bool) $berita->status_unggulan;
        $this->uploadGambar = null;
        $this->mode = 'form';
        $this->tampilkanModal = true;
        $this->resetErrorBag();
    }

    public function bukaModalEdit(string $id): void
    {
        $this->bukaFormEdit($id);
    }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->tampilkanModal = false;
        $this->reset(['beritaId', 'judul', 'ringkasan', 'isi_konten', 'gambar_utama', 'uploadGambar']);
    }

    public function simpan(): void
    {
        $this->validate();

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $penulisId = auth()->id() ?? Pengguna::first()?->id ?? Berita::first()?->penulis_id;

        // Upload gambar baru ke MinIO jika ada
        $pathGambar = $this->gambar_utama;
        if ($this->uploadGambar) {
            // Hapus gambar lama jika update
            if ($this->beritaId && !empty($this->gambar_utama)) {
                $storage->hapusFile($this->gambar_utama);
            }
            $pathGambar = $storage->uploadGambar($this->uploadGambar, 'berita');
        }

        $data = [
            'judul'            => $this->judul,
            'kategori_id'      => $this->kategori_id,
            'ringkasan'        => $this->ringkasan,
            'isi_konten'       => $this->isi_konten,
            'gambar_utama'     => $pathGambar,
            'status_publikasi' => $this->status_publikasi,
            'status_unggulan'  => $this->status_unggulan,
            'penulis_id'       => $penulisId,
        ];

        if ($this->beritaId) {
            $berita = Berita::findOrFail($this->beritaId);
            $berita->update($data);
            session()->flash('pesan', 'Berita "' . Str::limit($this->judul, 40) . '" berhasil diperbarui!');
        } else {
            $data['id']                = (string) Str::uuid();
            $data['slug']              = Str::slug($this->judul) . '-' . rand(100, 999);
            $data['tanggal_publikasi'] = now();
            $data['jumlah_dilihat']    = 0;
            Berita::create($data);
            session()->flash('pesan', 'Berita baru berhasil diterbitkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $berita = Berita::findOrFail($id);
        $judul  = $berita->judul;

        // Hapus gambar dari MinIO
        app(StorageService::class)->hapusFile($berita->gambar_utama);

        $berita->delete();
        session()->flash('pesan', 'Berita "' . Str::limit($judul, 35) . '" berhasil dihapus dari sistem!');
    }

    public function toggleUnggulan(string $id): void
    {
        $berita = Berita::findOrFail($id);
        $berita->status_unggulan = !$berita->status_unggulan;
        $berita->save();
        session()->flash('pesan', 'Status berita utama berhasil diperbarui!');
    }

    public function render()
    {
        $kategoriList = KategoriBerita::withCount('berita')->orderBy('nama_kategori')->get();

        $query = Berita::with('kategori', 'penulis')
            ->when($this->kategoriDipilih !== 'Semua', fn($q) => $q->where('kategori_id', $this->kategoriDipilih))
            ->when($this->statusDipilih !== 'Semua', fn($q) => $q->where('status_publikasi', $this->statusDipilih))
            ->when($this->cari, fn($q) => $q->where(fn($sub) => $sub->where('judul', 'like', '%' . $this->cari . '%')->orWhere('ringkasan', 'like', '%' . $this->cari . '%')))
            ->orderByDesc('kormi_berita.dibuat_pada');

        return view('livewire.admin.berita.berita-kelola', [
            'kategoriList'   => $kategoriList,
            'beritaList'     => $query->paginate(8),
            'totalBerita'    => Berita::count(),
            'totalPublished' => Berita::where('status_publikasi', 'published')->count(),
            'totalDraft'     => Berita::where('status_publikasi', 'draft')->count(),
            'totalViews'     => Berita::sum('jumlah_dilihat'),
        ]);
    }
}
