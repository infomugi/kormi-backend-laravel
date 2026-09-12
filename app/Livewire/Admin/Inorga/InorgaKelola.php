<?php

namespace App\Livewire\Admin\Inorga;

use App\Models\KomisiInorga;
use App\Models\Inorga;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Induk Organisasi (INORGA) - KORMI CMS')]
class InorgaKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel'; // 'tabel' atau 'form'
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'
    public string $cari = '';
    public string $komisiDipilih = 'Semua';
    public string $statusDipilih = 'Semua';
    public string $sortField = 'singkatan';
    public string $sortDirection = 'asc';
    public int $perPage = 12;

    // Bulk selection
    public array $selectedInorga = [];
    public bool $pilihSemua = false;

    // Backward compatibility for automated tests & modals
    public bool $tampilkanModal = false;
    public bool $tampilkanModalPratinjau = false;
    public ?Inorga $pratinjauInorga = null;

    public bool $tampilkanModalHapus = false;
    public ?string $hapusId = null;
    public ?string $hapusNama = null;

    // Form fields (Detailed Inputs)
    public ?string $inorgaId = null;
    public string $komisi_id = '';
    public string $singkatan = '';
    public string $nama_inorga = '';
    public string $nomor_sk = '';
    public ?string $tanggal_sk = null;
    public string $nama_ketua = '';
    public string $kontak_person = '';
    public string $nomor_telepon = '';
    public string $email = '';
    public string $alamat_sekretariat = '';
    public string $deskripsi_kegiatan = '';
    public string $logo_url = '';
    public string $status_keanggotaan = 'aktif';
    public int $jumlah_klub_anggota = 5;

    // Aliases / fallback
    public string $deskripsi_singkat = '';

    // File upload logo sementara
    public $uploadLogo = null;

    protected function rules(): array
    {
        $rules = [
            'komisi_id'           => 'required|exists:kormi_komisi_inorga,id',
            'singkatan'           => 'required|max:50',
            'nama_inorga'         => 'required|max:150',
            'nomor_sk'            => 'nullable|max:100',
            'tanggal_sk'          => 'nullable|date',
            'nama_ketua'          => 'nullable|max:150',
            'kontak_person'       => 'nullable|max:100',
            'nomor_telepon'       => 'nullable|max:50',
            'email'               => 'nullable|email|max:100',
            'alamat_sekretariat'  => 'nullable|max:500',
            'deskripsi_kegiatan'  => 'nullable',
            'status_keanggotaan'  => 'required|in:aktif,masa_tenggang,tidak_aktif,verifikasi',
            'jumlah_klub_anggota' => 'required|integer|min:0',
        ];

        $rules['uploadLogo'] = 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120';

        return $rules;
    }

    protected $messages = [
        'komisi_id.required'           => 'Komisi induk wajib dipilih.',
        'singkatan.required'           => 'Singkatan Inorga wajib diisi.',
        'nama_inorga.required'         => 'Nama lengkap Inorga wajib diisi.',
        'status_keanggotaan.required'  => 'Status keanggotaan wajib dipilih.',
        'jumlah_klub_anggota.required' => 'Jumlah klub wajib diisi.',
        'uploadLogo.image'             => 'Berkas logo harus berupa gambar.',
        'uploadLogo.mimes'             => 'Format logo harus jpg, jpeg, png, webp, atau svg.',
        'uploadLogo.max'               => 'Ukuran logo maksimal 5 MB.',
    ];

    public function mount(): void
    {
        $firstKomisi = KomisiInorga::first();
        if ($firstKomisi) {
            $this->komisi_id = $firstKomisi->id;
        }
    }

    public function updatedCari(): void           { $this->resetPage(); $this->resetSelection(); }
    public function updatedKomisiDipilih(): void   { $this->resetPage(); $this->resetSelection(); }
    public function updatedStatusDipilih(): void   { $this->resetPage(); $this->resetSelection(); }
    public function updatedPerPage(): void         { $this->resetPage(); }

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

    protected function getInorgaQuery()
    {
        return Inorga::with('komisi')
            ->when($this->komisiDipilih !== 'Semua', fn($q) => $q->where('komisi_id', $this->komisiDipilih))
            ->when($this->statusDipilih !== 'Semua', fn($q) => $q->where('status_keanggotaan', $this->statusDipilih))
            ->when($this->cari, fn($q) => $q->where(function ($sub) {
                $sub->where('singkatan', 'like', '%' . $this->cari . '%')
                    ->orWhere('nama_inorga', 'like', '%' . $this->cari . '%')
                    ->orWhere('nama_ketua', 'like', '%' . $this->cari . '%')
                    ->orWhere('nomor_sk', 'like', '%' . $this->cari . '%')
                    ->orWhere('kontak_person', 'like', '%' . $this->cari . '%')
                    ->orWhere('email', 'like', '%' . $this->cari . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $this->cari . '%');
            }));
    }

    public function updatedPilihSemua(bool $value): void
    {
        if ($value) {
            $this->selectedInorga = $this->getInorgaQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedInorga = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedInorga = [];
        $this->pilihSemua = false;
    }

    public function setFilterKomisi(string $komisiId): void
    {
        $this->komisiDipilih = $komisiId;
        $this->resetPage();
        $this->resetSelection();
    }

    public function setFilterStatus(string $status): void
    {
        $this->statusDipilih = $status;
        $this->resetPage();
        $this->resetSelection();
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->komisiDipilih = 'Semua';
        $this->statusDipilih = 'Semua';
        $this->sortField = 'singkatan';
        $this->sortDirection = 'asc';
        $this->resetPage();
        $this->resetSelection();
    }

    // ==========================================
    // INLINE EDITABLE & FAST TOGGLES
    // ==========================================
    public function updateFieldInline(string $id, string $field, $value): void
    {
        $inorga = Inorga::findOrFail($id);

        if ($field === 'singkatan') {
            $this->validate(['singkatan' => 'required|max:50']);
            $inorga->singkatan = strtoupper(trim($value));
            $inorga->slug = Str::slug($inorga->singkatan . '-' . $inorga->nama_inorga);
        } elseif ($field === 'nama_inorga') {
            $this->validate(['nama_inorga' => 'required|max:150']);
            $inorga->nama_inorga = trim($value);
            $inorga->slug = Str::slug($inorga->singkatan . '-' . $inorga->nama_inorga);
        } elseif ($field === 'nama_ketua') {
            $inorga->nama_ketua = trim($value) ?: null;
        } elseif ($field === 'kontak_person') {
            $inorga->kontak_person = trim($value) ?: null;
        } elseif ($field === 'nomor_telepon') {
            $inorga->nomor_telepon = trim($value) ?: null;
        } elseif ($field === 'nomor_sk') {
            $inorga->nomor_sk = trim($value) ?: null;
        } elseif ($field === 'status_keanggotaan') {
            $this->validate(['status_keanggotaan' => 'required|in:aktif,masa_tenggang,tidak_aktif,verifikasi']);
            $inorga->status_keanggotaan = $value;
        } elseif ($field === 'jumlah_klub_anggota') {
            $this->validate(['jumlah_klub_anggota' => 'required|integer|min:0']);
            $inorga->jumlah_klub_anggota = (int) $value;
        } elseif ($field === 'komisi_id') {
            $this->validate(['komisi_id' => 'required|exists:kormi_komisi_inorga,id']);
            $inorga->komisi_id = $value;
        }

        $inorga->save();
        session()->flash('pesan', 'Berhasil memperbarui ' . ucwords(str_replace('_', ' ', $field)) . ' untuk ' . $inorga->singkatan);
    }

    public function duplikatInorga(string $id): void
    {
        $sumber = Inorga::findOrFail($id);

        $duplikat = $sumber->replicate();
        $duplikat->id = (string) Str::uuid();
        $duplikat->singkatan = $sumber->singkatan . ' [COPY]';
        $duplikat->nama_inorga = '[Salinan] ' . $sumber->nama_inorga;
        $duplikat->slug = Str::slug($duplikat->singkatan . '-' . $duplikat->nama_inorga);
        $duplikat->status_keanggotaan = 'verifikasi';
        $duplikat->save();

        session()->flash('pesan', "Inorga \"{$sumber->singkatan}\" berhasil disalin!");
    }

    public function bulkSetStatus(string $status): void
    {
        if (empty($this->selectedInorga)) return;
        Inorga::whereIn('id', $this->selectedInorga)->update(['status_keanggotaan' => $status]);
        $count = count($this->selectedInorga);
        $this->resetSelection();
        session()->flash('pesan', "Status {$count} Inorga berhasil diperbarui!");
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedInorga)) return;
        $count = count($this->selectedInorga);
        $inorgas = Inorga::whereIn('id', $this->selectedInorga)->get();
        $storage = app(StorageService::class);

        foreach ($inorgas as $i) {
            $storage->hapusFile($i->logo_url);
            $i->delete();
        }

        $this->resetSelection();
        session()->flash('pesan', "{$count} Inorga berhasil dihapus secara permanen!");
    }

    public function bukaPratinjau(string $id): void
    {
        $this->pratinjauInorga = Inorga::with('komisi')->findOrFail($id);
        $this->tampilkanModalPratinjau = true;
    }

    public function tutupPratinjau(): void
    {
        $this->tampilkanModalPratinjau = false;
        $this->pratinjauInorga = null;
    }

    public function konfirmasiHapus(string $id): void
    {
        $i = Inorga::findOrFail($id);
        $this->hapusId = $i->id;
        $this->hapusNama = $i->singkatan . ' - ' . $i->nama_inorga;
        $this->tampilkanModalHapus = true;
    }

    public function batalHapus(): void
    {
        $this->tampilkanModalHapus = false;
        $this->hapusId = null;
        $this->hapusNama = null;
    }

    public function prosesHapus(): void
    {
        if (!$this->hapusId) return;

        $this->hapus($this->hapusId);
        $this->batalHapus();
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
        $firstKomisi = KomisiInorga::first();
        if ($firstKomisi) {
            $this->komisi_id = $firstKomisi->id;
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
        $i = Inorga::findOrFail($id);
        $this->inorgaId           = $i->id;
        $this->komisi_id          = $i->komisi_id;
        $this->singkatan          = $i->singkatan;
        $this->nama_inorga        = $i->nama_inorga;
        $this->nomor_sk           = $i->nomor_sk ?? '';
        $this->tanggal_sk         = $i->tanggal_sk ? $i->tanggal_sk->format('Y-m-d') : null;
        $this->nama_ketua         = $i->nama_ketua ?? '';
        $this->kontak_person      = $i->kontak_person ?? '';
        $this->nomor_telepon      = $i->nomor_telepon ?? '';
        $this->email              = $i->email ?? '';
        $this->alamat_sekretariat = $i->alamat_sekretariat ?? '';
        $this->deskripsi_kegiatan = $i->deskripsi_kegiatan ?? ($i->deskripsi ?? '');
        $this->logo_url           = $i->logo_url ?? '';
        $this->status_keanggotaan = $i->status_keanggotaan;
        $this->jumlah_klub_anggota= (int) $i->jumlah_klub_anggota;
        $this->uploadLogo         = null;

        // Alias
        $this->deskripsi_singkat  = $this->deskripsi_kegiatan;

        $this->mode = 'form';
        $this->tampilkanModal = true;
        $this->resetErrorBag();
    }

    public function bukaModalEdit(string $id): void
    {
        $this->bukaFormEdit($id);
    }

    public function simpan(): void
    {
        // Handle alias fallback
        if (!empty($this->deskripsi_singkat) && empty($this->deskripsi_kegiatan)) {
            $this->deskripsi_kegiatan = $this->deskripsi_singkat;
        }

        $this->validate();

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $pathLogo = $this->logo_url;
        if ($this->uploadLogo) {
            if ($this->inorgaId && !empty($this->logo_url)) {
                $storage->hapusFile($this->logo_url);
            }
            $pathLogo = $storage->uploadGambar($this->uploadLogo, 'inorga/logo');
        }

        $data = [
            'komisi_id'           => $this->komisi_id,
            'singkatan'           => strtoupper(trim($this->singkatan)),
            'nama_inorga'         => trim($this->nama_inorga),
            'slug'                => Str::slug($this->singkatan . '-' . $this->nama_inorga),
            'nomor_sk'            => trim($this->nomor_sk) ?: null,
            'tanggal_sk'          => $this->tanggal_sk ?: null,
            'nama_ketua'          => trim($this->nama_ketua) ?: null,
            'kontak_person'       => trim($this->kontak_person) ?: null,
            'nomor_telepon'       => trim($this->nomor_telepon) ?: null,
            'email'               => trim($this->email) ?: null,
            'alamat_sekretariat'  => trim($this->alamat_sekretariat) ?: null,
            'logo_url'            => $pathLogo ?: null,
            'status_keanggotaan'  => $this->status_keanggotaan,
            'jumlah_klub_anggota' => (int) $this->jumlah_klub_anggota,
            'deskripsi_kegiatan'  => trim($this->deskripsi_kegiatan) ?: null,
        ];

        if ($this->inorgaId) {
            Inorga::findOrFail($this->inorgaId)->update($data);
            session()->flash('pesan', 'Data Inorga ' . $this->singkatan . ' berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            Inorga::create($data);
            session()->flash('pesan', 'Inorga baru ' . $this->singkatan . ' berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $i = Inorga::findOrFail($id);
        $nama = $i->singkatan ?: $i->nama_inorga;

        // Hapus file logo jika ada
        app(StorageService::class)->hapusFile($i->logo_url);

        $i->delete();
        session()->flash('pesan', 'Inorga "' . $nama . '" berhasil dihapus.');
    }

    public function resetForm(): void
    {
        $this->inorgaId           = null;
        $this->singkatan          = '';
        $this->nama_inorga        = '';
        $this->nomor_sk           = '';
        $this->tanggal_sk         = null;
        $this->nama_ketua         = '';
        $this->kontak_person      = '';
        $this->nomor_telepon      = '';
        $this->email              = '';
        $this->alamat_sekretariat = '';
        $this->deskripsi_kegiatan = '';
        $this->deskripsi_singkat  = '';
        $this->logo_url           = '';
        $this->status_keanggotaan = 'aktif';
        $this->jumlah_klub_anggota= 5;
        $this->uploadLogo         = null;
    }

    public function render()
    {
        $komisiList = KomisiInorga::withCount('inorga')->orderBy('singkatan')->get();

        $query = $this->getInorgaQuery()->orderBy($this->sortField, $this->sortDirection);

        $totalInorga   = Inorga::count();
        $totalAktif    = Inorga::where('status_keanggotaan', 'aktif')->count();
        $totalTenggang = Inorga::whereIn('status_keanggotaan', ['masa_tenggang', 'verifikasi'])->count();
        $totalKlub     = Inorga::sum('jumlah_klub_anggota');

        return view('livewire.admin.inorga.inorga-kelola', [
            'komisiList'    => $komisiList,
            'inorgaList'    => $query->paginate($this->perPage),
            'totalInorga'   => $totalInorga,
            'totalAktif'    => $totalAktif,
            'totalTenggang' => $totalTenggang,
            'totalKlub'     => $totalKlub,
        ]);
    }
}
