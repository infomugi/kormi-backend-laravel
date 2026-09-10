<?php

namespace App\Livewire\Admin\Inorga;

use App\Models\KomisiInorga;
use App\Models\Inorga;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

use App\Services\StorageService;
use Livewire\WithFileUploads;

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

    // Backward compatibility for automated tests
    public bool $tampilkanModal = false;

    // Form fields
    public ?string $inorgaId = null;
    public string $komisi_id = '';
    public string $singkatan = '';
    public string $nama_inorga = '';
    public string $deskripsi_singkat = '';
    public string $nama_ketua = '';
    public string $kontak_person = '';
    public string $logo_url = '';
    public string $status_keanggotaan = 'aktif';
    public int $jumlah_klub_anggota = 5;

    // File upload logo sementara
    public $uploadLogo = null;

    protected function rules(): array
    {
        $rules = [
            'komisi_id'           => 'required|exists:kormi_komisi_inorga,id',
            'singkatan'           => 'required|max:50',
            'nama_inorga'         => 'required|max:150',
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

    public function updatedCari(): void           { $this->resetPage(); }
    public function updatedKomisiDipilih(): void   { $this->resetPage(); }
    public function updatedStatusDipilih(): void   { $this->resetPage(); }
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

    public function updatedPilihSemua(bool $value): void
    {
        if ($value) {
            $query = Inorga::query()
                ->when($this->komisiDipilih !== 'Semua', fn($q) => $q->where('komisi_id', $this->komisiDipilih))
                ->when($this->statusDipilih !== 'Semua', fn($q) => $q->where('status_keanggotaan', $this->statusDipilih))
                ->when($this->cari, fn($q) => $q->where(function ($sub) {
                    $sub->where('singkatan', 'like', '%' . $this->cari . '%')
                        ->orWhere('nama_inorga', 'like', '%' . $this->cari . '%');
                }));
            $this->selectedInorga = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
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
    }

    public function setFilterStatus(string $status): void
    {
        $this->statusDipilih = $status;
        $this->resetPage();
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->komisiDipilih = 'Semua';
        $this->statusDipilih = 'Semua';
        $this->sortField = 'singkatan';
        $this->sortDirection = 'asc';
        $this->resetPage();
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
        $this->deskripsi_singkat  = $i->deskripsi_kegiatan ?? $i->deskripsi ?? '';
        $this->nama_ketua         = $i->nama_ketua ?? '';
        $this->kontak_person      = $i->kontak_person ?? '';
        $this->logo_url           = $i->logo_url ?? '';
        $this->status_keanggotaan = $i->status_keanggotaan;
        $this->jumlah_klub_anggota= (int) $i->jumlah_klub_anggota;
        $this->uploadLogo         = null;
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
            'nama_ketua'          => $this->nama_ketua ?: null,
            'kontak_person'       => $this->kontak_person ?: null,
            'logo_url'            => $pathLogo ?: null,
            'status_keanggotaan'  => $this->status_keanggotaan,
            'jumlah_klub_anggota' => $this->jumlah_klub_anggota,
            'deskripsi_kegiatan'  => $this->deskripsi_singkat ?: null,
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
        $this->deskripsi_singkat  = '';
        $this->nama_ketua         = '';
        $this->kontak_person      = '';
        $this->logo_url           = '';
        $this->status_keanggotaan = 'aktif';
        $this->jumlah_klub_anggota= 5;
        $this->uploadLogo         = null;
    }

    public function render()
    {
        $komisiList = KomisiInorga::withCount('inorga')->orderBy('singkatan')->get();

        $query = Inorga::with('komisi')
            ->when($this->komisiDipilih !== 'Semua', fn($q) => $q->where('komisi_id', $this->komisiDipilih))
            ->when($this->statusDipilih !== 'Semua', fn($q) => $q->where('status_keanggotaan', $this->statusDipilih))
            ->when($this->cari, fn($q) => $q->where(function ($sub) {
                $sub->where('singkatan', 'like', '%' . $this->cari . '%')
                    ->orWhere('nama_inorga', 'like', '%' . $this->cari . '%')
                    ->orWhere('nama_ketua', 'like', '%' . $this->cari . '%');
            }))
            ->orderBy($this->sortField, $this->sortDirection);

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
