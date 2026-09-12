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
    public string $kategoriBaruWarna = '#059669';

    // SEO Score & Tips
    public int $seoScore = 0;
    public array $seoChecklist = [];

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

        $this->hitungSeoScore();
    }

    public function updatedJudul(string $value): void
    {
        if (empty($this->beritaId) || empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
        $this->hitungSeoScore();
    }

    public function updatedSlug(): void
    {
        $this->hitungSeoScore();
    }

    public function updatedRingkasan(): void
    {
        $this->hitungSeoScore();
    }

    public function updatedIsiKonten(): void
    {
        $this->hitungSeoScore();
    }

    public function updatedUploadGambar(): void
    {
        $this->hitungSeoScore();
    }

    public function generateSlugOtomatis(): void
    {
        $this->slug = Str::slug($this->judul);
        $this->hitungSeoScore();
    }

    public function hitungSeoScore(): void
    {
        $score = 0;
        $checklist = [];

        // 1. Judul length (optimal 30-70 chars)
        $lenJudul = mb_strlen($this->judul);
        if ($lenJudul >= 20 && $lenJudul <= 100) {
            $score += 25;
            $checklist[] = ['label' => 'Panjang judul ideal (' . $lenJudul . ' karakter)', 'pass' => true];
        } elseif ($lenJudul > 0) {
            $score += 10;
            $checklist[] = ['label' => 'Judul terlalu pendek/panjang (' . $lenJudul . ' karakter, ideal 20-100)', 'pass' => false];
        } else {
            $checklist[] = ['label' => 'Judul artikel belum diisi', 'pass' => false];
        }

        // 2. Slug check
        if (!empty($this->slug) && !preg_match('/[^a-z0-9\-]/', $this->slug)) {
            $score += 15;
            $checklist[] = ['label' => 'Struktur Permalink / Slug SEO-friendly', 'pass' => true];
        } else {
            $checklist[] = ['label' => 'Slug belum diisi atau mengandung karakter tidak valid', 'pass' => false];
        }

        // 3. Ringkasan (optimal 80-250 chars)
        $lenRingkasan = mb_strlen($this->ringkasan);
        if ($lenRingkasan >= 50 && $lenRingkasan <= 300) {
            $score += 25;
            $checklist[] = ['label' => 'Ringkasan meta deskripsi optimal (' . $lenRingkasan . ' karakter)', 'pass' => true];
        } elseif ($lenRingkasan > 0) {
            $score += 10;
            $checklist[] = ['label' => 'Ringkasan terlalu singkat (' . $lenRingkasan . ' karakter, disarankan 50-300)', 'pass' => false];
        } else {
            $checklist[] = ['label' => 'Ringkasan belum diisi', 'pass' => false];
        }

        // 4. Content length (> 100 words)
        $wordCount = str_word_count(strip_tags($this->isi_konten));
        if ($wordCount >= 100) {
            $score += 20;
            $checklist[] = ['label' => 'Panjang naskah memadai (' . $wordCount . ' kata)', 'pass' => true];
        } elseif ($wordCount > 0) {
            $score += 10;
            $checklist[] = ['label' => 'Konten masih ringkas (' . $wordCount . ' kata, target minimal 100)', 'pass' => false];
        } else {
            $checklist[] = ['label' => 'Naskah isi berita belum dibuat', 'pass' => false];
        }

        // 5. Featured Image
        if ($this->uploadGambar || !empty($this->gambar_utama)) {
            $score += 15;
            $checklist[] = ['label' => 'Thumbnail / Gambar utama telah disematkan', 'pass' => true];
        } else {
            $checklist[] = ['label' => 'Gambar utama belum disematkan', 'pass' => false];
        }

        $this->seoScore = min(100, $score);
        $this->seoChecklist = $checklist;
    }

    public function terapkanTemplate(string $tipe): void
    {
        switch ($tipe) {
            case 'liputan':
                $this->judul = $this->judul ?: 'Penyelenggaraan Kegiatan KORMI di Kabupaten Bandung';
                $this->ringkasan = $this->ringkasan ?: 'KORMI Kabupaten Bandung sukses menggelar rangkaian kegiatan olahraga rekreasi yang diikuti ratusan pegiat dari berbagai kecamatan.';
                $this->isi_konten = "SOREANG — Komite Olahraga Rekreasi Masyarakat Indonesia (KORMI) Kabupaten Bandung kembali menggelar agenda pembinaan dan perhelatan olahraga masyarakat yang berlangsung meriah.\n\n" .
                    "Kegiatan ini dihadiri langsung oleh jajaran pengurus KORMI Kabupaten Bandung, perwakilan perangkat daerah, serta para pegiat dari induk-induk organisasi olahraga (INORGA).\n\n" .
                    "### Semangat Kebersamaan & Kebugaran\n" .
                    "Dalam sambutannya, pimpinan KORMI menegaskan pentingnya menumbuhkan budaya olahraga rekreasi demi terciptanya masyarakat yang sehat, bugar, dan berkarakter menuju Kabupaten Bandung yang Bedas.\n\n" .
                    "> \"Olahraga rekreasi bukan sekadar mengejar prestasi medali, melainkan merajut persaudaraan dan kebahagiaan seluruh elemen masyarakat.\"\n\n" .
                    "### Partisipasi Antusias Pegiat\n" .
                    "Seluruh peserta menunjukkan antusiasme yang luar biasa sepanjang perhelatan. KORMI Kabupaten Bandung berkomitmen untuk terus menghadirkan ruang-ruang aktivitas fisik yang inklusif dan berkelanjutan bagi seluruh warga.";
                break;

            case 'siaran_pers':
                $this->judul = $this->judul ?: 'Siaran Pers: KORMI Kabupaten Bandung Umumkan Langkah Strategis Pembinaan INORGA';
                $this->ringkasan = $this->ringkasan ?: 'Pernyataan resmi KORMI Kabupaten Bandung mengenai arah kebijakan dan akselerasi program olahraga masyarakat tahun 2026.';
                $this->isi_konten = "SIARAN PERS RESMI\nKORMI KABUPATEN BANDUNG\nNomor: SP/KORMI-BDG/" . date('Y') . "/01\n\n" .
                    "SOREANG, " . Carbon::now()->translatedFormat('d F Y') . " — KORMI Kabupaten Bandung merilis pernyataan resmi terkait langkah-langkah percepatan pembinaan keolahragaan masyarakat.\n\n" .
                    "## Poin-Poin Utama Kebijakan:\n" .
                    "1. Penguatan kelembagaan 31 Koordinator Kecamatan (Kordik).\n" .
                    "2. Pemasalan program olahraga tradisional (OTDA), kebugaran (OKK), dan petualangan (OPT) hingga tingkat desa.\n" .
                    "3. Standardisasi sertifikasi juri dan instruktur SDI berlisensi resmi.\n\n" .
                    "Sekretariat KORMI Kabupaten Bandung mengimbau seluruh Inorga terdaftar untuk terus mengoordinasikan agenda kerja agar selaras dengan target kebugaran nasional.";
                break;

            case 'pengumuman':
                $this->judul = $this->judul ?: 'Pengumuman Resmi KORMI Kabupaten Bandung';
                $this->ringkasan = $this->ringkasan ?: 'Informasi penting dan jadwal agenda terbaru untuk seluruh jajaran INORGA dan pegiat olahraga masyarakat.';
                $this->isi_konten = "Diberitahukan kepada seluruh Pengurus Induk Organisasi Olahraga (INORGA) dan Koordinator Kecamatan KORMI se-Kabupaten Bandung:\n\n" .
                    "Sehubungan dengan persiapan agenda mendatang, berikut kami sampaikan jadwal dan ketentuan teknis:\n\n" .
                    "- **Agenda**: Rapat Kerja & Sosialisasi Petunjuk Teknis\n" .
                    "- **Hari/Tanggal**: " . Carbon::now()->addDays(3)->translatedFormat('l, d F Y') . "\n" .
                    "- **Waktu**: 09.00 WIB s.d Selesai\n" .
                    "- **Tempat**: Sekretariat KORMI Kabupaten Bandung\n\n" .
                    "Mengingat pentingnya agenda tersebut, dimohon kehadiran tepat waktu perwakilan resmi masing-masing organisasi. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.";
                break;
        }

        $this->generateSlugOtomatis();
        $this->hitungSeoScore();
        session()->flash('pesan', 'Template "' . ucfirst(str_replace('_', ' ', $tipe)) . '" berhasil diterapkan ke formulir!');
    }

    public function generateRingkasanOtomatis(): void
    {
        if (empty($this->isi_konten)) {
            return;
        }

        $cleanText = strip_tags($this->isi_konten);
        $cleanText = preg_replace('/\s+/', ' ', $cleanText);
        $cleanText = trim($cleanText);

        $this->ringkasan = Str::limit($cleanText, 220, '...');
        $this->hitungSeoScore();
        session()->flash('pesan', 'Ringkasan berhasil diekstrak otomatis dari isi naskah!');
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
            $data['id'] = (string) Str::uuid();
            $data['jumlah_dilihat'] = 0;
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
        $this->kategoriBaruWarna = '#059669';
        $this->tampilkanModalKategori = true;
    }

    public function tutupModalTambahKategori(): void
    {
        $this->tampilkanModalKategori = false;
    }

    public function simpanKategoriBaru(): void
    {
        $this->validate([
            'kategoriBaruNama' => 'required|min:3|max:100|unique:media_kategori_berita,nama_kategori',
            'kategoriBaruWarna' => 'required',
        ], [
            'kategoriBaruNama.required' => 'Nama kategori wajib diisi.',
            'kategoriBaruNama.unique' => 'Nama kategori sudah terdaftar.',
        ]);

        $kat = KategoriBerita::create([
            'id'             => (string) Str::uuid(),
            'nama_kategori'  => trim($this->kategoriBaruNama),
            'slug'           => Str::slug($this->kategoriBaruNama),
            'kode_warna_hex' => $this->kategoriBaruWarna ?: '#059669',
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

