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
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('Form Berita & Publikasi - KORMI CMS')]
class BeritaForm extends Component
{
    use WithFileUploads;

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

    // Modal Kategori Baru
    public bool $tampilkanModalKategori = false;
    public string $kategoriBaruNama = '';
    public string $kategoriBaruWarna = '#4f46e5';

    protected function rules(): array
    {
        $rules = [
            'judul'             => 'required|min:5|max:255',
            'slug'              => 'required|max:255',
            'kategori_id'       => 'required|exists:kormi_kategori_berita,id',
            'ringkasan'         => 'required|max:500',
            'isi_konten'        => 'required|min:10',
            'status_publikasi'  => 'required|in:draft,published,archived',
            'penulis_id'        => 'nullable|exists:kormi_pengguna,id',
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

    public function mount(?string $id = null): void
    {
        if ($id) {
            $berita = Berita::findOrFail($id);
            $this->beritaId          = $berita->id;
            $this->judul             = $berita->judul;
            $this->slug              = $berita->slug;
            $this->kategori_id       = $berita->kategori_id;
            $this->penulis_id        = $berita->penulis_id;
            $this->ringkasan         = $berita->ringkasan;
            $this->isi_konten        = $berita->isi_konten;
            $this->gambar_utama      = $berita->gambar_utama;
            $this->keterangan_gambar = $berita->keterangan_gambar ?? '';
            $this->status_publikasi  = $berita->status_publikasi;
            $this->status_unggulan   = (bool) $berita->status_unggulan;
            $this->tanggal_publikasi = $berita->tanggal_publikasi ? Carbon::parse($berita->tanggal_publikasi)->format('Y-m-d\TH:i') : null;
        } else {
            $this->status_publikasi = 'published';
            $this->tanggal_publikasi = now()->format('Y-m-d\TH:i');
            $this->penulis_id = auth()->id() ?? Pengguna::first()?->id;
            
            $firstKat = KategoriBerita::first();
            $this->kategori_id = $firstKat ? $firstKat->id : '';
        }
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

    public function simpan(): void
    {
        $this->validate();

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $penulisId = $this->penulis_id ?: (auth()->id() ?? Pengguna::first()?->id ?? Berita::first()?->penulis_id);

        $pathGambar = $this->gambar_utama;
        if ($this->uploadGambar) {
            if ($this->beritaId && !empty($this->gambar_utama)) {
                $storage->hapusFile($this->gambar_utama);
            }
            $pathGambar = $storage->uploadGambar($this->uploadGambar, 'berita');
        }

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
            session()->flash('pesan', 'Artikel berita "' . $berita->judul . '" berhasil diperbarui!');
        } else {
            $berita = Berita::create($data);
            session()->flash('pesan', 'Artikel berita baru berhasil diterbitkan!');
        }

        $this->redirect(route('admin.berita'), navigate: true);
    }

    public function simpanDraft(): void
    {
        $this->status_publikasi = 'draft';
        $this->simpan();
    }

    public function bukaModalTambahKategori(): void
    {
        $this->kategoriBaruNama = '';
        $this->kategoriBaruWarna = '#4f46e5';
        $this->tampilkanModalKategori = true;
    }

    public function tutupModalTambahKategori(): void
    {
        $this->tampilkanModalKategori = false;
    }

    public function simpanKategoriBaru(): void
    {
        $this->validate([
            'kategoriBaruNama' => 'required|min:3|max:100|unique:kormi_kategori_berita,nama_kategori',
            'kategoriBaruWarna' => 'required',
        ], [
            'kategoriBaruNama.required' => 'Nama kategori wajib diisi.',
            'kategoriBaruNama.unique' => 'Nama kategori sudah terdaftar.',
        ]);

        $kat = KategoriBerita::create([
            'nama_kategori' => $this->kategoriBaruNama,
            'slug' => Str::slug($this->kategoriBaruNama),
            'kode_warna_hex' => $this->kategoriBaruWarna,
            'urutan' => KategoriBerita::max('urutan') + 1,
        ]);

        $this->kategori_id = $kat->id;
        $this->tutupModalTambahKategori();
        session()->flash('pesan', 'Kategori baru "' . $kat->nama_kategori . '" berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.berita.berita-form', [
            'kategoriList' => KategoriBerita::withCount('berita')->orderBy('nama_kategori')->get(),
            'penulisList'  => Pengguna::orderBy('nama_lengkap')->get(),
        ]);
    }
}
