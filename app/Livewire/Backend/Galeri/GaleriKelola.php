<?php

namespace App\Livewire\Backend\Galeri;

use App\Models\Content\GaleriAlbum;
use App\Models\Content\GaleriFoto;
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
    public string $tampilanMode = 'grid'; // 'grid' atau 'tabel'
    public string $cari = '';
    public string $albumDipilih = 'Semua';
    public string $sortField = 'urutan';
    public string $sortDirection = 'asc';
    public int $perPage = 12;

    // Album sort & filter
    public string $albumSortField = 'tanggal_kegiatan';
    public string $albumSortDirection = 'desc';
    public string $albumStatusFilter = 'semua'; // 'semua', 'publik', 'draft'

    // Bulk selection Foto
    public array $selectedFoto = [];
    public bool $pilihSemua = false;

    // Bulk selection Album
    public array $selectedAlbum = [];
    public bool $pilihSemuaAlbum = false;

    // Form Foto Tunggal
    public bool $tampilkanModalFoto = false;
    public ?string $editFotoId = null;
    public string $album_id = '';
    public string $judul_foto = '';
    public string $gambar_url = ''; // path MinIO
    public string $deskripsi_foto = '';
    public string $tipe_grid = 'normal';
    public int $urutan_foto = 1;
    public $uploadFoto = null; // file upload sementara

    // Form Upload Bulk Foto ke Album
    public string $bulk_album_id = '';
    public array $uploadBulkFoto = []; // array of UploadedFile
    public string $bulk_judul_prefix = '';
    public string $bulk_deskripsi = '';

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
    public array $uploadAlbumBulkFoto = []; // upload foto sekaligus saat buat/edit album

    protected function rulesFoto(): array
    {
        $rules = [
            'album_id'   => 'required|exists:media_galeri_album,id',
            'judul_foto' => 'required|min:3|max:150',
            'tipe_grid'  => 'required|in:normal,col-span-2,col-span-2 row-span-2,col-span-1 row-span-2,col-span-2 row-span-1',
            'urutan_foto'=> 'required|integer',
        ];

        $rules['uploadFoto'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240';

        return $rules;
    }

    protected function rulesBulkFoto(): array
    {
        return [
            'bulk_album_id'      => 'required|exists:media_galeri_album,id',
            'uploadBulkFoto'     => 'required|array|min:1',
            'uploadBulkFoto.*'   => 'image|mimes:jpg,jpeg,png,webp|max:10240',
            'bulk_judul_prefix'  => 'nullable|max:100',
        ];
    }

    protected function rulesAlbum(): array
    {
        $rules = [
            'judul_album'     => 'required|min:3|max:150',
            'tanggal_kegiatan'=> 'nullable|date',
        ];

        $rules['uploadSampul'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240';
        $rules['uploadAlbumBulkFoto.*'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240';

        return $rules;
    }

    protected $messages = [
        'album_id.required'      => 'Album wajib dipilih.',
        'judul_foto.required'    => 'Judul foto wajib diisi.',
        'uploadFoto.required'    => 'File foto wajib diunggah.',
        'uploadFoto.image'       => 'File harus berupa gambar.',
        'uploadFoto.mimes'       => 'Format gambar harus jpg, jpeg, png, atau webp.',
        'uploadFoto.max'         => 'Ukuran gambar maksimal 10 MB.',
        'bulk_album_id.required' => 'Album tujuan wajib dipilih.',
        'uploadBulkFoto.required'=> 'Pilih minimal 1 file foto untuk diunggah.',
        'uploadBulkFoto.min'     => 'Pilih minimal 1 file foto.',
        'uploadBulkFoto.*.image' => 'Setiap berkas harus berupa gambar.',
        'uploadBulkFoto.*.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
        'uploadBulkFoto.*.max'   => 'Ukuran setiap foto maksimal 10 MB.',
        'uploadAlbumBulkFoto.*.image' => 'File foto harus berupa gambar.',
        'uploadAlbumBulkFoto.*.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
        'uploadAlbumBulkFoto.*.max'   => 'Ukuran setiap foto maksimal 10 MB.',
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

    public function updatedCari(): void               { $this->resetPage(); }
    public function updatedAlbumDipilih(): void        { $this->resetPage(); }
    public function updatedTabAktif(): void            { $this->resetPage(); $this->resetSelection(); }
    public function updatedPerPage(): void             { $this->resetPage(); }
    public function updatedAlbumSortField(): void      { $this->resetPage(); }
    public function updatedAlbumSortDirection(): void  { $this->resetPage(); }
    public function updatedAlbumStatusFilter(): void   { $this->resetPage(); }

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

    public function sortAlbumBy(string $field): void
    {
        if ($this->albumSortField === $field) {
            $this->albumSortDirection = $this->albumSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->albumSortField = $field;
            $this->albumSortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function updatedPilihSemua(bool $value): void
    {
        if ($value) {
            $query = GaleriFoto::query()
                ->when($this->albumDipilih !== 'Semua', fn($q) => $q->where('album_id', $this->albumDipilih))
                ->when($this->cari, fn($q) => $q->where(fn($sub) => $sub->where('judul_foto', 'like', "%{$this->cari}%")->orWhere('deskripsi', 'like', "%{$this->cari}%")));
            $this->selectedFoto = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedFoto = [];
        }
    }

    public function updatedPilihSemuaAlbum(bool $value): void
    {
        if ($value) {
            $query = GaleriAlbum::query()
                ->when($this->albumStatusFilter === 'publik', fn($q) => $q->where('status_tampil', true))
                ->when($this->albumStatusFilter === 'draft', fn($q) => $q->where('status_tampil', false))
                ->when($this->cari, fn($q) => $q->where(fn($sub) => $sub->where('judul_album', 'like', "%{$this->cari}%")->orWhere('lokasi', 'like', "%{$this->cari}%")));
            $this->selectedAlbum = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedAlbum = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedFoto = [];
        $this->pilihSemua = false;
        $this->selectedAlbum = [];
        $this->pilihSemuaAlbum = false;
    }

    public function bulkDeleteFoto(): void
    {
        if (empty($this->selectedFoto)) return;

        $count = count($this->selectedFoto);
        $fotos = GaleriFoto::whereIn('id', $this->selectedFoto)->get();
        $storage = app(StorageService::class);

        foreach ($fotos as $foto) {
            $storage->hapusFile($foto->gambar_url);
            $foto->delete();
        }

        $this->resetSelection();
        session()->flash('pesan', "{$count} foto berhasil dihapus dari galeri!");
    }

    public function bulkDeleteAlbum(): void
    {
        if (empty($this->selectedAlbum)) return;

        $count = count($this->selectedAlbum);
        $albums = GaleriAlbum::with('foto')->whereIn('id', $this->selectedAlbum)->get();
        $storage = app(StorageService::class);

        foreach ($albums as $album) {
            $storage->hapusFile($album->gambar_sampul);
            foreach ($album->foto as $foto) {
                $storage->hapusFile($foto->gambar_url);
            }
            $album->delete();
        }

        $this->resetSelection();
        session()->flash('pesan', "{$count} album beserta fotonya berhasil dihapus!");
    }

    public function toggleStatusAlbum(string $id): void
    {
        $album = GaleriAlbum::findOrFail($id);
        $album->status_tampil = !$album->status_tampil;
        $album->save();

        session()->flash('pesan', 'Status album "' . Str::limit($album->judul_album, 30) . '" berhasil diubah menjadi ' . ($album->status_tampil ? 'Publik' : 'Disembunyikan') . '!');
    }

    public function setFilterAlbum(string $albumId): void
    {
        $this->albumDipilih = $albumId;
        $this->resetPage();
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->albumDipilih = 'Semua';
        $this->sortField = 'urutan';
        $this->sortDirection = 'asc';
        $this->albumSortField = 'tanggal_kegiatan';
        $this->albumSortDirection = 'desc';
        $this->albumStatusFilter = 'semua';
        $this->resetPage();
    }

    // ==========================================
    // BULK UPLOAD FOTO ACTIONS
    // ==========================================
    public function bukaFormBulkFoto(?string $albumId = null): void
    {
        $this->resetBulkFoto();
        if ($albumId && $albumId !== 'Semua') {
            $this->bulk_album_id = $albumId;
        } else {
            $firstAlbum = GaleriAlbum::first();
            if ($firstAlbum) {
                $this->bulk_album_id = $firstAlbum->id;
            }
        }
        $this->mode = 'form_bulk_foto';
        $this->resetErrorBag();
    }

    public function simpanBulkFoto(): void
    {
        $this->validate($this->rulesBulkFoto());

        /** @var StorageService $storage */
        $storage = app(StorageService::class);
        $album = GaleriAlbum::findOrFail($this->bulk_album_id);

        $maxUrutan = (int) GaleriFoto::where('album_id', $this->bulk_album_id)->max('urutan');
        $uploadedCount = 0;

        foreach ($this->uploadBulkFoto as $index => $file) {
            $pathGambar = $storage->uploadGambar($file, 'galeri/foto');
            
            // Format judul: jika user memasukkan prefix judul, tambahkan nomor (contoh: Dokumentasi FORKAB 01)
            // Jika kosong, gunakan nama file asli yang dibersihkan
            if (!empty(trim($this->bulk_judul_prefix))) {
                $judul = trim($this->bulk_judul_prefix) . ' ' . str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT);
            } else {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $judul = Str::headline(str_replace(['_', '-'], ' ', $originalName));
            }

            GaleriFoto::create([
                'id'         => (string) Str::uuid(),
                'album_id'   => $this->bulk_album_id,
                'judul_foto' => $judul,
                'gambar_url' => $pathGambar,
                'deskripsi'  => $this->bulk_deskripsi,
                'tipe_grid'  => 'normal',
                'urutan'     => $maxUrutan + $index + 1,
            ]);

            $uploadedCount++;
        }

        $this->setFilterAlbum($this->bulk_album_id);
        $this->tabAktif = 'foto';
        session()->flash('pesan', "Berhasil mengunggah {$uploadedCount} foto ke album \"{$album->judul_album}\"!");
        $this->kembaliKeTabel();
    }

    public function resetBulkFoto(): void
    {
        $this->bulk_album_id     = '';
        $this->uploadBulkFoto    = [];
        $this->bulk_judul_prefix = '';
        $this->bulk_deskripsi    = '';
    }

    public function hapusFileBulkUpload(int $index): void
    {
        if (isset($this->uploadBulkFoto[$index])) {
            unset($this->uploadBulkFoto[$index]);
            $this->uploadBulkFoto = array_values($this->uploadBulkFoto);
        }
    }

    public function hapusFileAlbumBulkUpload(int $index): void
    {
        if (isset($this->uploadAlbumBulkFoto[$index])) {
            unset($this->uploadAlbumBulkFoto[$index]);
            $this->uploadAlbumBulkFoto = array_values($this->uploadAlbumBulkFoto);
        }
    }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->tampilkanModalFoto  = false;
        $this->tampilkanModalAlbum = false;
        $this->resetFoto();
        $this->resetBulkFoto();
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
            $albumId = $album->id;
            session()->flash('pesan', 'Album galeri berhasil diperbarui!');
        } else {
            $album = GaleriAlbum::create([
                'id'           => (string) Str::uuid(),
                'judul_album'  => $this->judul_album,
                'slug'         => $slug,
                'deskripsi'    => $this->deskripsi_album,
                'gambar_sampul'=> $pathSampul,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'lokasi'       => $this->lokasi,
                'status_tampil'=> $this->status_tampil,
            ]);
            $albumId = $album->id;
            session()->flash('pesan', 'Album baru berhasil dibuat!');
        }

        // Jika ada foto tambahan yang diunggah secara bulk di dalam form album
        if (!empty($this->uploadAlbumBulkFoto)) {
            $maxUrutan = (int) GaleriFoto::where('album_id', $albumId)->max('urutan');
            $bulkCount = 0;
            foreach ($this->uploadAlbumBulkFoto as $idx => $photoFile) {
                $fotoPath = $storage->uploadGambar($photoFile, 'galeri/foto');
                $photoName = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $cleanJudul = Str::headline(str_replace(['_', '-'], ' ', $photoName));

                GaleriFoto::create([
                    'id'         => (string) Str::uuid(),
                    'album_id'   => $albumId,
                    'judul_foto' => $cleanJudul,
                    'gambar_url' => $fotoPath,
                    'deskripsi'  => $this->deskripsi_album,
                    'tipe_grid'  => 'normal',
                    'urutan'     => $maxUrutan + $idx + 1,
                ]);
                $bulkCount++;
            }
            session()->flash('pesan', "Album tersimpan & {$bulkCount} foto berhasil diunggah ke dalam album!");
        }

        $this->setFilterAlbum($albumId);
        $this->tabAktif = 'foto';
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
        $this->uploadAlbumBulkFoto = [];
    }

    public function render()
    {
        $albumList = GaleriAlbum::withCount('foto')->orderBy('judul_album')->get();

        $queryFoto = GaleriFoto::with('album')
            ->when($this->albumDipilih !== 'Semua', fn($q) => $q->where('album_id', $this->albumDipilih))
            ->when($this->cari, fn($q) => $q->where(fn($sub) => $sub->where('judul_foto', 'like', "%{$this->cari}%")->orWhere('deskripsi', 'like', "%{$this->cari}%")))
            ->orderBy($this->sortField, $this->sortDirection);

        $queryAlbum = GaleriAlbum::withCount('foto')
            ->when($this->albumStatusFilter === 'publik', fn($q) => $q->where('status_tampil', true))
            ->when($this->albumStatusFilter === 'draft', fn($q) => $q->where('status_tampil', false))
            ->when($this->cari, fn($q) => $q->where(fn($sub) => $sub->where('judul_album', 'like', "%{$this->cari}%")->orWhere('lokasi', 'like', "%{$this->cari}%")->orWhere('deskripsi', 'like', "%{$this->cari}%")))
            ->orderBy($this->albumSortField, $this->albumSortDirection);

        return view('livewire.backend.galeri.galeri-kelola', [
            'albumList'   => $albumList,
            'fotoList'    => $queryFoto->paginate($this->perPage, ['*'], 'fotoPage'),
            'daftarAlbum' => $queryAlbum->paginate($this->perPage, ['*'], 'albumPage'),
            'totalFoto'   => GaleriFoto::count(),
            'totalAlbum'  => GaleriAlbum::count(),
            'totalAlbumAktif' => GaleriAlbum::where('status_tampil', true)->count(),
        ]);
    }
}
