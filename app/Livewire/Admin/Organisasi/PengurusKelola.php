<?php

namespace App\Livewire\Admin\Organisasi;

use App\Models\PengurusModel;
use App\Models\PeriodeKepengurusan;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Struktur Pengurus - KORMI CMS')]
class PengurusKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel'; // 'tabel' atau 'form'
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'
    public string $cari = '';
    public string $filterPeriode = '';
    public string $filterBidang = 'semua';
    public string $statusFilter = 'Semua';

    // Sorting & Pagination
    public string $sortField = 'urutan';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    // Bulk selection
    public array $selectedPengurus = [];
    public bool $pilihSemua = false;

    // Backward compatibility for automated tests & modals
    public bool $tampilkanModal = false;
    public bool $tampilkanModalPratinjau = false;
    public ?PengurusModel $pratinjauPengurus = null;

    public bool $tampilkanModalHapus = false;
    public ?string $hapusId = null;
    public ?string $hapusNama = null;

    // Form fields (Detailed Inputs)
    public ?string $editId = null;
    public string $periode_id = '';
    public string $nama_lengkap = '';
    public string $jabatan = '';
    public string $kategori_bidang = '';
    public string $foto_url = '';
    public $uploadFoto = null;
    public int $urutan = 0;
    public bool $status_tampil = true;

    protected function rules(): array
    {
        return [
            'periode_id'      => 'required|exists:kormi_periode_kepengurusan,id',
            'nama_lengkap'    => 'required|string|min:2|max:150',
            'jabatan'         => 'required|string|min:2|max:100',
            'kategori_bidang' => 'nullable|string|max:100',
            'urutan'          => 'integer|min:0',
            'status_tampil'   => 'boolean',
            'uploadFoto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ];
    }

    protected $messages = [
        'periode_id.required'   => 'Periode masa bakti wajib dipilih.',
        'nama_lengkap.required' => 'Nama lengkap pengurus wajib diisi.',
        'nama_lengkap.min'      => 'Nama lengkap minimal 2 karakter.',
        'jabatan.required'      => 'Jabatan struktural wajib diisi.',
        'uploadFoto.image'      => 'Berkas harus berupa gambar foto.',
        'uploadFoto.mimes'      => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
        'uploadFoto.max'        => 'Ukuran foto maksimal 10 MB.',
    ];

    public function mount(): void
    {
        $periodeAktif = PeriodeKepengurusan::aktif()->first() ?? PeriodeKepengurusan::orderByDesc('tahun_mulai')->first();
        if ($periodeAktif) {
            $this->periode_id = $periodeAktif->id;
            $this->filterPeriode = $periodeAktif->id;
        }
    }

    public function updatedCari(): void           { $this->resetPage(); $this->resetSelection(); }
    public function updatedFilterPeriode(): void   { $this->resetPage(); $this->resetSelection(); }
    public function updatedFilterBidang(): void    { $this->resetPage(); $this->resetSelection(); }
    public function updatedStatusFilter(): void    { $this->resetPage(); $this->resetSelection(); }
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

    protected function getPengurusQuery()
    {
        return PengurusModel::with('periode')
            ->when($this->filterPeriode, fn($q) => $q->where('periode_id', $this->filterPeriode))
            ->when($this->filterBidang !== 'semua', fn($q) => $q->where('kategori_bidang', $this->filterBidang))
            ->when($this->statusFilter !== 'Semua', function ($q) {
                if ($this->statusFilter === 'Tampil') {
                    $q->where('status_tampil', true);
                } elseif ($this->statusFilter === 'Disembunyikan') {
                    $q->where('status_tampil', false);
                }
            })
            ->when($this->cari, fn($q) => $q->where(function($sub) {
                $sub->where('nama_lengkap', 'like', "%{$this->cari}%")
                    ->orWhere('jabatan', 'like', "%{$this->cari}%")
                    ->orWhere('kategori_bidang', 'like', "%{$this->cari}%");
            }));
    }

    public function updatedPilihSemua(bool $value): void
    {
        if ($value) {
            $this->selectedPengurus = $this->getPengurusQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedPengurus = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedPengurus = [];
        $this->pilihSemua = false;
    }

    public function setFilterPeriode(string $periodeId): void
    {
        $this->filterPeriode = $periodeId;
        $this->resetPage();
        $this->resetSelection();
    }

    public function setFilterStatus(string $status): void
    {
        $this->statusFilter = $status;
        $this->resetPage();
        $this->resetSelection();
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->filterBidang = 'semua';
        $this->statusFilter = 'Semua';
        $this->sortField = 'urutan';
        $this->sortDirection = 'asc';
        $this->resetPage();
        $this->resetSelection();
    }

    // ==========================================
    // INLINE EDITABLE & FAST ACTIONS
    // ==========================================
    public function updateFieldInline(string $id, string $field, $value): void
    {
        $pengurus = PengurusModel::findOrFail($id);

        if ($field === 'nama_lengkap') {
            $this->validate(['nama_lengkap' => 'required|string|min:2|max:150']);
            $pengurus->nama_lengkap = trim($value);
        } elseif ($field === 'jabatan') {
            $this->validate(['jabatan' => 'required|string|min:2|max:100']);
            $pengurus->jabatan = trim($value);
        } elseif ($field === 'kategori_bidang') {
            $pengurus->kategori_bidang = trim($value) ?: null;
        } elseif ($field === 'urutan') {
            $this->validate(['urutan' => 'integer|min:0']);
            $pengurus->urutan = (int) $value;
        }

        $pengurus->save();
        session()->flash('pesan', 'Berhasil memperbarui ' . ucwords(str_replace('_', ' ', $field)) . ' untuk ' . $pengurus->nama_lengkap);
    }

    public function toggleStatus(string $id): void
    {
        $item = PengurusModel::findOrFail($id);
        $item->status_tampil = !$item->status_tampil;
        $item->save();
        $statusText = $item->status_tampil ? 'Ditampilkan' : 'Disembunyikan';
        session()->flash('pesan', "Status visibilitas {$item->nama_lengkap} diubah menjadi {$statusText}.");
    }

    public function duplikatPengurus(string $id): void
    {
        $sumber = PengurusModel::findOrFail($id);

        $duplikat = $sumber->replicate();
        $duplikat->id = (string) Str::uuid();
        $duplikat->nama_lengkap = '[Salinan] ' . $sumber->nama_lengkap;
        $duplikat->urutan = $sumber->urutan + 1;
        $duplikat->status_tampil = false;
        $duplikat->save();

        session()->flash('pesan', "Data pengurus \"{$sumber->nama_lengkap}\" berhasil disalin!");
    }

    // ==========================================
    // BULK ACTIONS
    // ==========================================
    public function bulkSetStatus(bool $status): void
    {
        if (empty($this->selectedPengurus)) return;
        PengurusModel::whereIn('id', $this->selectedPengurus)->update(['status_tampil' => $status]);
        $text = $status ? 'ditampilkan di publik' : 'disembunyikan';
        session()->flash('pesan', count($this->selectedPengurus) . ' pengurus berhasil ' . $text . '.');
        $this->resetSelection();
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedPengurus)) return;
        $items = PengurusModel::whereIn('id', $this->selectedPengurus)->get();
        $storage = app(StorageService::class);
        foreach ($items as $item) {
            if ($item->foto_url) {
                $storage->hapusFile($item->foto_url);
            }
            $item->delete();
        }
        session()->flash('pesan', count($this->selectedPengurus) . ' data pengurus berhasil dihapus.');
        $this->resetSelection();
    }

    // ==========================================
    // MODALS & NAVIGATION
    // ==========================================
    public function bukaPratinjau(string $id): void
    {
        $this->pratinjauPengurus = PengurusModel::with('periode')->findOrFail($id);
        $this->tampilkanModalPratinjau = true;
    }

    public function tutupPratinjau(): void
    {
        $this->tampilkanModalPratinjau = false;
        $this->pratinjauPengurus = null;
    }

    public function konfirmasiHapus(string $id): void
    {
        $item = PengurusModel::findOrFail($id);
        $this->hapusId = $item->id;
        $this->hapusNama = $item->nama_lengkap . " (" . $item->jabatan . ")";
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
        $this->resetInput();
    }

    public function bukaFormTambah(): void
    {
        $this->resetInput();
        $periodeAktif = PeriodeKepengurusan::aktif()->first() ?? PeriodeKepengurusan::orderByDesc('tahun_mulai')->first();
        if ($periodeAktif) {
            $this->periode_id = $periodeAktif->id;
        }
        $maxUrutan = PengurusModel::where('periode_id', $this->periode_id)->max('urutan');
        $this->urutan = ($maxUrutan !== null) ? $maxUrutan + 1 : 1;

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
        $item = PengurusModel::findOrFail($id);
        $this->editId = $item->id;
        $this->periode_id = $item->periode_id;
        $this->nama_lengkap = $item->nama_lengkap;
        $this->jabatan = $item->jabatan;
        $this->kategori_bidang = $item->kategori_bidang ?? '';
        $this->foto_url = $item->foto_url ?? '';
        $this->urutan = (int) $item->urutan;
        $this->status_tampil = (bool) $item->status_tampil;
        $this->uploadFoto = null;
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

        $storage = app(StorageService::class);

        $pathFoto = $this->foto_url;
        if ($this->uploadFoto) {
            if ($this->editId && !empty($this->foto_url)) {
                $storage->hapusFile($this->foto_url);
            }
            $pathFoto = $storage->uploadGambar($this->uploadFoto, 'pengurus');
        }

        $data = [
            'periode_id'      => $this->periode_id,
            'nama_lengkap'    => trim($this->nama_lengkap),
            'jabatan'         => trim($this->jabatan),
            'kategori_bidang' => $this->kategori_bidang ? trim($this->kategori_bidang) : null,
            'foto_url'        => $pathFoto ?: null,
            'urutan'          => (int) $this->urutan,
            'status_tampil'   => (bool) $this->status_tampil,
        ];

        if ($this->editId) {
            PengurusModel::findOrFail($this->editId)->update($data);
            session()->flash('pesan', 'Data pengurus ' . $this->nama_lengkap . ' berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            PengurusModel::create($data);
            session()->flash('pesan', 'Pengurus baru ' . $this->nama_lengkap . ' berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $item = PengurusModel::findOrFail($id);
        if ($item->foto_url) {
            app(StorageService::class)->hapusFile($item->foto_url);
        }
        $nama = $item->nama_lengkap;
        $item->delete();
        session()->flash('pesan', 'Data pengurus ' . $nama . ' berhasil dihapus.');
    }

    public function resetInput(): void
    {
        $this->editId = null;
        $this->nama_lengkap = '';
        $this->jabatan = '';
        $this->kategori_bidang = '';
        $this->foto_url = '';
        $this->uploadFoto = null;
        $this->urutan = 0;
        $this->status_tampil = true;
    }

    public function render()
    {
        $periodeList = PeriodeKepengurusan::orderByDesc('tahun_mulai')->get();

        $bidangList = PengurusModel::whereNotNull('kategori_bidang')
            ->where('kategori_bidang', '!=', '')
            ->distinct()
            ->pluck('kategori_bidang')
            ->toArray();

        $query = $this->getPengurusQuery();

        if (in_array($this->sortField, ['urutan', 'nama_lengkap', 'jabatan', 'kategori_bidang', 'status_tampil', 'created_at'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->orderBy('urutan')->orderBy('nama_lengkap');
        }

        $baseCountQuery = PengurusModel::query()
            ->when($this->filterPeriode, fn($q) => $q->where('periode_id', $this->filterPeriode));

        return view('livewire.admin.organisasi.pengurus-kelola', [
            'periodeList'         => $periodeList,
            'bidangList'          => $bidangList,
            'pengurusList'        => $query->paginate($this->perPage),
            'totalPengurus'       => PengurusModel::count(),
            'totalPengurusPeriode'=> (clone $baseCountQuery)->count(),
            'totalTampil'         => (clone $baseCountQuery)->where('status_tampil', true)->count(),
            'totalSembunyi'       => (clone $baseCountQuery)->where('status_tampil', false)->count(),
            'totalBidang'         => count($bidangList),
            'namaPeriodeAktif'    => PeriodeKepengurusan::find($this->filterPeriode)?->nama_periode ?? 'Semua Periode',
        ]);
    }
}
