<?php

namespace App\Livewire\Admin\Galeri;

use App\Models\GaleriAlbum;
use App\Models\GaleriFoto;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Galeri & Album - KORMI CMS')]
class GaleriKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel'; // 'tabel', 'form_foto', 'form_album'
    public string $tabAktif = 'foto'; // 'foto' atau 'album'
    public string $cari = '';
    public string $albumDipilih = 'Semua';

    // Form Foto
    public bool $tampilkanModalFoto = false;
    public ?string $editFotoId = null;
    public string $album_id = '';
    public string $judul_foto = '';
    public string $gambar_url = ''; // path MinIO
    public string $deskripsi_foto = '';
    public string $tipe_grid = 'normal';
    public int $urutan_foto = 1;
    public $uploadFoto = null; // file upload sementara

    // Form Album
    public bool $tampilkanModalAlbum = false;
    public ?string $editAlbumId = null;
    public string $judul_album = '';
    public string $deskripsi_album = '';
    public string $gambar_sampul = ''; // path MinIO
    public string $tanggal_kegiatan = '';
    public string $lokasi = '';
    public bool $status_tampil = true;
    public $uploadSampul = null; // file upload sementara

    protected function rulesFoto(): array
    {
        $rules = [
            'album_id'   => 'required|exists:kormi_galeri_album,id',
            'judul_foto' => 'required|min:3|max:150',
            'tipe_grid'  => 'required|in:normal,col-span-2 row-span-2,col-span-1 row-span-2,col-span-2 row-span-1',
            'urutan_foto'=> 'required|integer',
        ];

        $rules['uploadFoto'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240';

        return $rules;
    }

    protected function rulesAlbum(): array
    {
        $rules = [
            'judul_album'     => 'required|min:3|max:150',
            'tanggal_kegiatan'=> 'nullable|date',
        ];

        $rules['uploadSampul'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240';

        return $rules;
    }

    protected $messages = [
        'album_id.required'      => 'Album wajib dipilih.',
        'judul_foto.required'    => 'Judul foto wajib diisi.',
        'uploadFoto.required'    => 'File foto wajib diunggah.',
        'uploadFoto.image'       => 'File harus berupa gambar.',
        'uploadFoto.mimes'       => 'Format gambar harus jpg, jpeg, png, atau webp.',
        'uploadFoto.max'         => 'Ukuran gambar maksimal 10 MB.',
        'judul_album.required'   => 'Judul album wajib diisi.',
        'uploadSampul.required'  => 'Sampul album wajib diunggah.',
        'uploadSampul.image'     => 'Sampul harus berupa gambar.',
        'uploadSampul.mimes'     => 'Format sampul harus jpg, jpeg, png, atau webp.',
        'uploadSampul.max'       => 'Ukuran sampul maksimal 10 MB.',
    ];

    public function mount(): void
    {
        $firstAlbum = GaleriAlbum::first();
        if ($firstAlbum) {
            $this->album_id = $firstAlbum->id;
        }
        $this->tanggal_kegiatan = date('Y-m-d');
    }

    public function updatedCari(): void        { $this->resetPage(); }
    public function updatedAlbumDipilih(): void { $this->resetPage(); }
    public function updatedTabAktif(): void     { $this->resetPage(); }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->tampilkanModalFoto  = false;
        $this->tampilkanModalAlbum = false;
        $this->resetFoto();
        $this->resetAlbum();
    }

    // ==========================================
    // FOTO ACTIONS
    // ==========================================
    public function bukaFormTambahFoto(): void
    {
        $this->resetFoto();
        $firstAlbum = GaleriAlbum::first();
        if ($firstAlbum) {
            $this->album_id = $firstAlbum->id;
        }
        $this->mode = 'form_foto';
        $this->tampilkanModalFoto = true;
        $this->resetErrorBag();
    }

    public function bukaModalTambahFoto(): void { $this->bukaFormTambahFoto(); }

    public function bukaFormEditFoto(string $id): void
    {
        $foto = GaleriFoto::findOrFail($id);
        $this->editFotoId   = $foto->id;
        $this->album_id     = $foto->album_id;
        $this->judul_foto   = $foto->judul_foto;
        $this->gambar_url   = $foto->gambar_url;
        $this->deskripsi_foto = $foto->deskripsi ?? '';
        $this->tipe_grid    = $foto->tipe_grid ?? 'normal';
        $this->urutan_foto  = (int) $foto->urutan;
        $this->uploadFoto   = null;
        $this->mode = 'form_foto';
        $this->tampilkanModalFoto = true;
        $this->resetErrorBag();
    }

    public function bukaModalEditFoto(string $id): void { $this->bukaFormEditFoto($id); }

    public function simpanFoto(): void
    {
        $this->validate($this->rulesFoto());

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $pathGambar = $this->gambar_url;
        if ($this->uploadFoto) {
            if ($this->editFotoId && !empty($this->gambar_url)) {
                $storage->hapusFile($this->gambar_url);
            }
            $pathGambar = $storage->uploadGambar($this->uploadFoto, 'galeri/foto');
        }

        if ($this->editFotoId) {
            $foto = GaleriFoto::findOrFail($this->editFotoId);
            $foto->update([
                'album_id'   => $this->album_id,
                'judul_foto' => $this->judul_foto,
                'gambar_url' => $pathGambar,
                'deskripsi'  => $this->deskripsi_foto,
                'tipe_grid'  => $this->tipe_grid,
                'urutan'     => $this->urutan_foto,
            ]);
            session()->flash('pesan', 'Foto galeri berhasil diperbarui!');
        } else {
            GaleriFoto::create([
                'id'        => (string) Str::uuid(),
                'album_id'  => $this->album_id,
                'judul_foto'=> $this->judul_foto,
                'gambar_url'=> $pathGambar,
                'deskripsi' => $this->deskripsi_foto,
                'tipe_grid' => $this->tipe_grid,
                'urutan'    => $this->urutan_foto,
            ]);
            session()->flash('pesan', 'Foto baru berhasil ditambahkan ke album!');
        }

        $this->kembaliKeTabel();
    }

    public function hapusFoto(string $id): void
    {
        $foto  = GaleriFoto::findOrFail($id);
        $judul = $foto->judul_foto;

        app(StorageService::class)->hapusFile($foto->gambar_url);

        $foto->delete();
        session()->flash('pesan', 'Foto "' . Str::limit($judul, 35) . '" berhasil dihapus dari galeri.');
    }

    public function resetFoto(): void
    {
        $this->editFotoId   = null;
        $this->judul_foto   = '';
        $this->gambar_url   = '';
        $this->deskripsi_foto = '';
        $this->tipe_grid    = 'normal';
        $this->urutan_foto  = 1;
        $this->uploadFoto   = null;
    }

    // ==========================================
    // ALBUM ACTIONS
    // ==========================================
    public function bukaFormTambahAlbum(): void
    {
        $this->resetAlbum();
        $this->mode = 'form_album';
        $this->tampilkanModalAlbum = true;
        $this->resetErrorBag();
    }

    public function bukaModalTambahAlbum(): void { $this->bukaFormTambahAlbum(); }

    public function bukaFormEditAlbum(string $id): void
    {
        $album = GaleriAlbum::findOrFail($id);
        $this->editAlbumId    = $album->id;
        $this->judul_album    = $album->judul_album;
        $this->deskripsi_album= $album->deskripsi ?? '';
        $this->gambar_sampul  = $album->gambar_sampul ?? '';
        $this->tanggal_kegiatan = $album->tanggal_kegiatan ? $album->tanggal_kegiatan->format('Y-m-d') : date('Y-m-d');
        $this->lokasi         = $album->lokasi ?? '';
        $this->status_tampil  = (bool) $album->status_tampil;
        $this->uploadSampul   = null;
        $this->mode = 'form_album';
        $this->tampilkanModalAlbum = true;
        $this->resetErrorBag();
    }

    public function bukaModalEditAlbum(string $id): void { $this->bukaFormEditAlbum($id); }

    public function simpanAlbum(): void
    {
        $this->validate($this->rulesAlbum());

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $pathSampul = $this->gambar_sampul;
        if ($this->uploadSampul) {
            if ($this->editAlbumId && !empty($this->gambar_sampul)) {
                $storage->hapusFile($this->gambar_sampul);
            }
            $pathSampul = $storage->uploadGambar($this->uploadSampul, 'galeri/album');
        }

        $slug = Str::slug($this->judul_album);

        if ($this->editAlbumId) {
            $album = GaleriAlbum::findOrFail($this->editAlbumId);
            $album->update([
                'judul_album'    => $this->judul_album,
                'slug'           => $slug,
                'deskripsi'      => $this->deskripsi_album,
                'gambar_sampul'  => $pathSampul,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'lokasi'         => $this->lokasi,
                'status_tampil'  => $this->status_tampil,
            ]);
            session()->flash('pesan', 'Album galeri berhasil diperbarui!');
        } else {
            GaleriAlbum::create([
                'id'           => (string) Str::uuid(),
                'judul_album'  => $this->judul_album,
                'slug'         => $slug,
                'deskripsi'    => $this->deskripsi_album,
                'gambar_sampul'=> $pathSampul,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'lokasi'       => $this->lokasi,
                'status_tampil'=> $this->status_tampil,
            ]);
            session()->flash('pesan', 'Album baru berhasil dibuat!');
        }

        $this->kembaliKeTabel();
    }

    public function hapusAlbum(string $id): void
    {
        $album = GaleriAlbum::findOrFail($id);
        $judul = $album->judul_album;

        // Hapus sampul album
        app(StorageService::class)->hapusFile($album->gambar_sampul);

        // Hapus semua foto dalam album dari MinIO
        $storage = app(StorageService::class);
        foreach ($album->foto as $foto) {
            $storage->hapusFile($foto->gambar_url);
        }

        $album->delete();
        session()->flash('pesan', 'Album "' . Str::limit($judul, 35) . '" berhasil dihapus.');
    }

    public function resetAlbum(): void
    {
        $this->editAlbumId    = null;
        $this->judul_album    = '';
        $this->deskripsi_album= '';
        $this->gambar_sampul  = '';
        $this->tanggal_kegiatan = date('Y-m-d');
        $this->lokasi         = '';
        $this->status_tampil  = true;
        $this->uploadSampul   = null;
    }

    public function render()
    {
        $albumList = GaleriAlbum::withCount('foto')->orderBy('judul_album')->get();

        $queryFoto = GaleriFoto::with('album')
            ->when($this->albumDipilih !== 'Semua', fn($q) => $q->where('album_id', $this->albumDipilih))
            ->when($this->cari, fn($q) => $q->where(fn($sub) => $sub->where('judul_foto', 'like', "%{$this->cari}%")->orWhere('deskripsi', 'like', "%{$this->cari}%")))
            ->orderBy('urutan');

        $queryAlbum = GaleriAlbum::withCount('foto')
            ->when($this->cari, fn($q) => $q->where(fn($sub) => $sub->where('judul_album', 'like', "%{$this->cari}%")->orWhere('lokasi', 'like', "%{$this->cari}%")))
            ->orderByDesc('tanggal_kegiatan');

        return view('livewire.admin.galeri.galeri-kelola', [
            'albumList'   => $albumList,
            'fotoList'    => $queryFoto->paginate(12, ['*'], 'fotoPage'),
            'daftarAlbum' => $queryAlbum->paginate(8, ['*'], 'albumPage'),
            'totalFoto'   => GaleriFoto::count(),
            'totalAlbum'  => GaleriAlbum::count(),
            'totalAlbumAktif' => GaleriAlbum::where('status_tampil', true)->count(),
        ]);
    }
}
