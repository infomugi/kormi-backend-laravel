<?php

namespace App\Livewire\Admin\Berita;

use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\Pengguna;
use App\Services\StorageService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Berita & Publikasi Media - KORMI CMS')]
class BeritaKelola extends Component
{
    use WithPagination, WithFileUploads;

    // View state
    public string $mode = 'tabel'; // 'tabel' atau 'form'
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'

    // Filter & Search
    #[Url(as: 'q')]
    public string $cari = '';

    #[Url(as: 'kat')]
    public string $kategoriDipilih = 'Semua';

    #[Url(as: 'status')]
    public string $statusDipilih = 'Semua';

    #[Url(as: 'unggulan')]
    public string $unggulanDipilih = 'Semua';

    #[Url(as: 'urut')]
    public string $urutkan = 'terbaru'; // terbaru, terlama, terpopuler, judul_asc

    #[Url(as: 'sort_field')]
    public string $sortField = 'dibuat_pada';

    #[Url(as: 'sort_dir')]
    public string $sortDirection = 'desc';

    public int $perPage = 10;

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

    // Checkbox Bulk Selection
    public array $selectedBerita = [];
    public bool $pilihSemua = false;

    // Form fields
    public ?string $beritaId = null;
    public string $judul = '';
    public string $slug = '';
    public string $kategori_id = '';
    public ?string $penulis_id = null;
    public string $ringkasan = '';
    public string $isi_konten = '';
    public string $gambar_utama = '';
    public string $keterangan_gambar = '';
    public string $status_publikasi = 'published';
    public bool $status_unggulan = false;
    public ?string $tanggal_publikasi = null;
    public string $tabEditor = 'editor'; // 'editor' atau 'preview'

    // File upload
    public $uploadGambar = null;

    // Modals
    public bool $tampilkanModal = false; // Backward compatibility
    public bool $tampilkanModalHapus = false;
    public ?string $hapusId = null;
    public ?string $hapusJudul = null;

    public bool $tampilkanModalPratinjau = false;
    public ?Berita $pratinjauBerita = null;

    public bool $tampilkanModalKategori = false;
    public string $kategoriBaruNama = '';
    public string $kategoriBaruWarna = '#4f46e5';

    protected function rules(): array
    {
        $rules = [
            'judul'             => 'required|min:5|max:255',
            'slug'              => 'required|max:255',
            'kategori_id'       => 'required|exists:media_kategori_berita,id',
            'ringkasan'         => 'required|max:500',
            'isi_konten'        => 'required|min:10',
            'status_publikasi'  => 'required|in:draft,published,archived',
            'penulis_id'        => 'nullable|exists:sys_pengguna,id',
            'keterangan_gambar' => 'nullable|max:255',
            'tanggal_publikasi' => 'nullable|date',
        ];

        if (!$this->beritaId && empty($this->gambar_utama)) {
            $rules['uploadGambar'] = 'required|image|mimes:jpg,jpeg,png,webp|max:5120';
        } else {
            $rules['uploadGambar'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120';
        }

        return $rules;
    }

    protected $messages = [
        'judul.required'        => 'Judul artikel berita wajib diisi.',
        'judul.min'             => 'Judul minimal 5 karakter.',
        'slug.required'         => 'Slug URL wajib diisi.',
        'kategori_id.required'  => 'Kategori berita wajib dipilih.',
        'kategori_id.exists'    => 'Kategori yang dipilih tidak valid.',
        'ringkasan.required'    => 'Ringkasan / sinopsis berita wajib diisi.',
        'ringkasan.max'         => 'Ringkasan maksimal 500 karakter.',
        'isi_konten.required'   => 'Naskah isi konten berita wajib diisi.',
        'uploadGambar.required' => 'Gambar utama / thumbnail wajib diunggah untuk berita baru.',
        'uploadGambar.image'    => 'File harus berupa file gambar.',
        'uploadGambar.mimes'    => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
        'uploadGambar.max'      => 'Ukuran gambar maksimal 5 MB.',
    ];

    public function mount(): void
    {
        // Set default penulis jika ada user login
        $this->penulis_id = auth()->id() ?? Pengguna::first()?->id;
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

    public function updatedStatusDipilih(): void
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedUnggulanDipilih(): void
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedUrutkan(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function updatedJudul(string $value): void
    {
        if (empty($this->beritaId) || empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function generateSlugOtomatis(): void
    {
        $this->slug = Str::slug($this->judul);
    }

    public function setFilterKategori(string $id): void
    {
        $this->kategoriDipilih = $id;
        $this->resetPage();
        $this->resetSelection();
    }

    public function setFilterStatus(string $status): void
    {
        $this->statusDipilih = $status;
        $this->resetPage();
        $this->resetSelection();
    }

    public function setFilterUnggulan(string $val): void
    {
        $this->unggulanDipilih = $val;
        $this->resetPage();
        $this->resetSelection();
    }

    public function resetSemuaFilter(): void
    {
        $this->reset(['cari', 'kategoriDipilih', 'statusDipilih', 'unggulanDipilih', 'urutkan']);
        $this->resetPage();
        $this->resetSelection();
    }

    // ==========================================
    // SELECTION & BULK ACTIONS
    // ==========================================

    public function updatedPilihSemua(bool $value): void
    {
        if ($value) {
            $this->selectedBerita = $this->getBeritaQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedBerita = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedBerita = [];
        $this->pilihSemua = false;
    }

    public function bulkPublish(): void
    {
        if (empty($this->selectedBerita)) return;

        Berita::whereIn('id', $this->selectedBerita)->update([
            'status_publikasi' => 'published',
            'tanggal_publikasi' => now(),
        ]);

        session()->flash('pesan', count($this->selectedBerita) . ' artikel berita berhasil dipublikasikan!');
        $this->resetSelection();
    }

    public function bulkDraft(): void
    {
        if (empty($this->selectedBerita)) return;

        Berita::whereIn('id', $this->selectedBerita)->update([
            'status_publikasi' => 'draft',
        ]);

        session()->flash('pesan', count($this->selectedBerita) . ' artikel berita diubah menjadi Draf.');
        $this->resetSelection();
    }

    public function bulkArchive(): void
    {
        if (empty($this->selectedBerita)) return;

        Berita::whereIn('id', $this->selectedBerita)->update([
            'status_publikasi' => 'archived',
        ]);

        session()->flash('pesan', count($this->selectedBerita) . ' artikel berita diarsipkan.');
        $this->resetSelection();
    }

    public function bulkToggleUnggulan(bool $status): void
    {
        if (empty($this->selectedBerita)) return;

        Berita::whereIn('id', $this->selectedBerita)->update([
            'status_unggulan' => $status,
        ]);

        $label = $status ? 'dijadikan Berita Utama' : 'dihapus dari Berita Utama';
        session()->flash('pesan', count($this->selectedBerita) . ' artikel ' . $label . '!');
        $this->resetSelection();
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedBerita)) return;

        $count = count($this->selectedBerita);
        $beritas = Berita::whereIn('id', $this->selectedBerita)->get();
        $storage = app(StorageService::class);

        foreach ($beritas as $b) {
            $storage->hapusFile($b->gambar_utama);
            $b->delete();
        }

        session()->flash('pesan', $count . ' artikel berita berhasil dihapus dari sistem!');
        $this->resetSelection();
    }

    // ==========================================
    // FORM CRUD OPERATIONS
    // ==========================================

    public function bukaFormTambah(): void
    {
        $this->redirect(route('admin.berita.tambah'), navigate: true);
    }

    public function bukaModalTambah(): void
    {
        $this->bukaFormTambah();
    }

    public function bukaFormEdit(string $id): void
    {
        $this->redirect(route('admin.berita.edit', $id), navigate: true);
    }

    public function bukaModalEdit(string $id): void
    {
        $this->bukaFormEdit($id);
    }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->tampilkanModal = false;
        $this->reset([
            'beritaId', 'judul', 'slug', 'ringkasan', 'isi_konten', 
            'gambar_utama', 'keterangan_gambar', 'uploadGambar'
        ]);
        $this->resetErrorBag();
    }

    public function simpan(): void
    {
        $this->validate();

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $penulisId = $this->penulis_id ?: (auth()->id() ?? Pengguna::first()?->id ?? Berita::first()?->penulis_id);

        // Upload gambar baru ke MinIO jika ada
        $pathGambar = $this->gambar_utama;
        if ($this->uploadGambar) {
            // Hapus gambar lama jika ada dan bukan URL eksternal
            if ($this->beritaId && !empty($this->gambar_utama)) {
                $storage->hapusFile($this->gambar_utama);
            }
            $pathGambar = $storage->uploadGambar($this->uploadGambar, 'berita');
        }

        // Generate slug unik jika duplikat
        $finalSlug = Str::slug($this->slug ?: $this->judul);
        $slugCount = Berita::where('slug', $finalSlug)
            ->when($this->beritaId, fn($q) => $q->where('id', '!=', $this->beritaId))
            ->count();

        if ($slugCount > 0) {
            $finalSlug .= '-' . rand(100, 999);
        }

        $tanggalPublikasi = $this->tanggal_publikasi 
            ? Carbon::parse($this->tanggal_publikasi) 
            : ($this->status_publikasi === 'published' ? now() : null);

        $data = [
            'judul'             => $this->judul,
            'slug'              => $finalSlug,
            'kategori_id'       => $this->kategori_id,
            'penulis_id'        => $penulisId,
            'ringkasan'         => $this->ringkasan,
            'isi_konten'        => $this->isi_konten,
            'gambar_utama'      => $pathGambar,
            'keterangan_gambar' => $this->keterangan_gambar ?: null,
            'status_publikasi'  => $this->status_publikasi,
            'status_unggulan'   => $this->status_unggulan,
            'tanggal_publikasi' => $tanggalPublikasi,
        ];

        if ($this->beritaId) {
            $berita = Berita::findOrFail($this->beritaId);
            $berita->update($data);
            session()->flash('pesan', 'Berita "' . Str::limit($this->judul, 40) . '" berhasil diperbarui!');
        } else {
            $data['id']             = (string) Str::uuid();
            $data['jumlah_dilihat'] = 0;
            Berita::create($data);
            session()->flash('pesan', 'Berita baru "' . Str::limit($this->judul, 40) . '" berhasil diterbitkan!');
        }

        $this->kembaliKeTabel();
    }

    public function simpanDraft(): void
    {
        $this->status_publikasi = 'draft';
        $this->simpan();
    }

    // ==========================================

    public function toggleUnggulan(string $id): void
    {
        $berita = Berita::findOrFail($id);
        $berita->status_unggulan = !$berita->status_unggulan;
        $berita->save();

        $pesan = $berita->status_unggulan ? 'dijadikan Berita Utama (Headline)!' : 'dilepas dari Berita Utama.';
        session()->flash('pesan', 'Status Berita "' . Str::limit($berita->judul, 30) . '" ' . $pesan);
    }

    public function updateFieldInline(string $id, string $field, $value): void
    {
        $berita = Berita::findOrFail($id);

        if (!in_array($field, ['judul', 'ringkasan', 'kategori_id', 'status_publikasi', 'jumlah_dilihat', 'status_unggulan'])) {
            return;
        }

        if ($field === 'judul') {
            $value = trim((string) $value);
            if (strlen($value) < 5) {
                session()->flash('pesan', 'Gagal: Judul artikel minimal harus 5 karakter.');
                return;
            }
            $berita->judul = $value;
            // Update slug jika berita belum pernah diubah manual
            $berita->slug = Str::slug($value);
        } elseif ($field === 'ringkasan') {
            $berita->ringkasan = trim((string) $value);
        } elseif ($field === 'kategori_id') {
            if (KategoriBerita::where('id', $value)->exists()) {
                $berita->kategori_id = $value;
            }
        } elseif ($field === 'status_publikasi') {
            if (in_array($value, ['published', 'draft', 'archived'])) {
                $berita->status_publikasi = $value;
                if ($value === 'published' && !$berita->tanggal_publikasi) {
                    $berita->tanggal_publikasi = now();
                }
            }
        } elseif ($field === 'jumlah_dilihat') {
            $berita->jumlah_dilihat = max(0, (int) $value);
        }

        $berita->save();
        session()->flash('pesan', 'Berhasil memperbarui ' . ucwords(str_replace('_', ' ', $field)) . ' untuk berita "' . Str::limit($berita->judul, 30) . '"');
    }

    public function toggleStatus(string $id): void
    {
        $berita = Berita::findOrFail($id);
        $nextStatus = match ($berita->status_publikasi) {
            'published' => 'draft',
            'draft'     => 'published',
            'archived'  => 'published',
            default     => 'published',
        };

        $berita->status_publikasi = $nextStatus;
        if ($nextStatus === 'published' && !$berita->tanggal_publikasi) {
            $berita->tanggal_publikasi = now();
        }
        $berita->save();

        session()->flash('pesan', 'Status berita diubah menjadi: ' . strtoupper($nextStatus));
    }


    public function duplikatBerita(string $id): void
    {
        $sumber = Berita::findOrFail($id);
        
        $duplikat = $sumber->replicate();
        $duplikat->id = (string) Str::uuid();
        $duplikat->judul = '[Salinan] ' . $sumber->judul;
        $duplikat->slug = Str::slug($duplikat->judul) . '-' . rand(100, 999);
        $duplikat->status_publikasi = 'draft';
        $duplikat->status_unggulan = false;
        $duplikat->jumlah_dilihat = 0;
        $duplikat->tanggal_publikasi = null;
        $duplikat->save();

        session()->flash('pesan', 'Berita berhasil diduplikasi sebagai draf baru.');
    }

    public function konfirmasiHapus(string $id): void
    {
        $berita = Berita::findOrFail($id);
        $this->hapusId = $berita->id;
        $this->hapusJudul = $berita->judul;
        $this->tampilkanModalHapus = true;
    }

    public function batalHapus(): void
    {
        $this->hapusId = null;
        $this->hapusJudul = null;
        $this->tampilkanModalHapus = false;
    }

    public function prosesHapus(): void
    {
        if ($this->hapusId) {
            $this->hapus($this->hapusId);
            $this->batalHapus();
        }
    }

    public function hapus(string $id): void
    {
        $berita = Berita::findOrFail($id);
        $judul  = $berita->judul;

        // Hapus gambar dari MinIO
        app(StorageService::class)->hapusFile($berita->gambar_utama);

        $berita->delete();
        session()->flash('pesan', 'Berita "' . Str::limit($judul, 35) . '" berhasil dihapus dari sistem.');
        $this->resetSelection();
    }

    // Modal Live Preview
    public function bukaModalPratinjau(string $id): void
    {
        $this->pratinjauBerita = Berita::with('kategori', 'penulis')->findOrFail($id);
        $this->tampilkanModalPratinjau = true;
    }

    public function tutupModalPratinjau(): void
    {
        $this->pratinjauBerita = null;
        $this->tampilkanModalPratinjau = false;
    }

    // Modal Tambah Kategori Cepat
    public function bukaModalTambahKategori(): void
    {
        $this->kategoriBaruNama = '';
        $this->kategoriBaruWarna = '#4f46e5';
        $this->tampilkanModalKategori = true;
        $this->resetErrorBag(['kategoriBaruNama']);
    }

    public function tutupModalTambahKategori(): void
    {
        $this->tampilkanModalKategori = false;
    }

    public function simpanKategoriBaru(): void
    {
        $this->validate([
            'kategoriBaruNama' => 'required|min:3|max:100|unique:media_kategori_berita,nama_kategori',
            'kategoriBaruWarna' => 'required|regex:/^#[a-fA-F0-9]{6}$/',
        ], [
            'kategoriBaruNama.required' => 'Nama kategori wajib diisi.',
            'kategoriBaruNama.unique'   => 'Nama kategori sudah ada.',
            'kategoriBaruWarna.regex'   => 'Format kode warna harus heksadesimal (contoh: #4f46e5).',
        ]);

        $kategori = KategoriBerita::create([
            'id'             => (string) Str::uuid(),
            'nama_kategori'  => trim($this->kategoriBaruNama),
            'slug'           => Str::slug($this->kategoriBaruNama),
            'kode_warna_hex' => $this->kategoriBaruWarna ?: '#4f46e5',
        ]);

        $this->kategori_id = $kategori->id;
        $this->tutupModalTambahKategori();
        session()->flash('pesan', 'Kategori "' . $kategori->nama_kategori . '" berhasil ditambahkan!');
    }

    // ==========================================
    // QUERY BUILDER & RENDER
    // ==========================================

    protected function getBeritaQuery()
    {
        $query = Berita::with('kategori', 'penulis')
            ->when($this->kategoriDipilih !== 'Semua', fn($q) => $q->where('kategori_id', $this->kategoriDipilih))
            ->when($this->statusDipilih !== 'Semua', fn($q) => $q->where('status_publikasi', $this->statusDipilih))
            ->when($this->unggulanDipilih !== 'Semua', fn($q) => $q->where('status_unggulan', (bool) $this->unggulanDipilih))
            ->when($this->cari, function ($q) {
                $term = '%' . trim($this->cari) . '%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('judul', 'like', $term)
                        ->orWhere('ringkasan', 'like', $term)
                        ->orWhere('isi_konten', 'like', $term);
                });
            });

        // Apply sorting based on sortField if specified
        $direction = strtolower($this->sortDirection) === 'asc' ? 'asc' : 'desc';

        if (in_array($this->sortField, ['judul', 'dibuat_pada', 'tanggal_publikasi', 'jumlah_dilihat', 'status_publikasi'])) {
            return $query->orderBy($this->sortField, $direction);
        }

        return match ($this->urutkan) {
            'terlama'   => $query->orderBy('dibuat_pada', 'asc'),
            'terpopuler'=> $query->orderBy('jumlah_dilihat', 'desc'),
            'judul_asc' => $query->orderBy('judul', 'asc'),
            default     => $query->orderBy('dibuat_pada', 'desc'),
        };
    }

    public function render()
    {
        $kategoriList = KategoriBerita::withCount('berita')->orderBy('nama_kategori')->get();
        $penulisList = Pengguna::where('status_aktif', true)->orderBy('nama_lengkap')->get();

        $beritaList = $this->getBeritaQuery()->paginate($this->perPage);

        $totalBerita    = Berita::count();
        $totalPublished = Berita::where('status_publikasi', 'published')->count();
        $totalDraft     = Berita::where('status_publikasi', 'draft')->count();
        $totalArchived  = Berita::where('status_publikasi', 'archived')->count();
        $totalUnggulan  = Berita::where('status_unggulan', true)->count();
        $totalViews     = (int) Berita::sum('jumlah_dilihat');
        $rataRataViews  = $totalBerita > 0 ? round($totalViews / $totalBerita) : 0;

        return view('livewire.admin.berita.berita-kelola', [
            'kategoriList'   => $kategoriList,
            'penulisList'    => $penulisList,
            'beritaList'     => $beritaList,
            'totalBerita'    => $totalBerita,
            'totalPublished' => $totalPublished,
            'totalDraft'     => $totalDraft,
            'totalArchived'  => $totalArchived,
            'totalUnggulan'  => $totalUnggulan,
            'totalViews'     => $totalViews,
            'rataRataViews'  => $rataRataViews,
        ]);
    }
}
