<?php

namespace App\Livewire\Admin\Apmo;

use App\Models\ApmoTahun;
use App\Models\ApmoPenerima;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola APMO Anugerah Penghargaan - KORMI CMS')]
class ApmoKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel'; // 'tabel', 'form_penerima', 'form_edisi'
    public string $tabAktif = 'penerima'; // 'penerima' atau 'edisi'
    public string $cari = '';
    public string $tahunDipilih = 'Semua';
    public string $kategoriFilter = 'Semua';

    // Sorting & Pagination
    public string $sortField = 'urutan';
    public string $sortDirection = 'asc';
    public int $perPage = 9;
    public string $tampilanMode = 'grid'; // 'grid' atau 'tabel' untuk penerima

    // Bulk selection
    public array $selectedPenerima = [];
    public bool $pilihSemuaPenerima = false;
    public array $selectedEdisi = [];
    public bool $pilihSemuaEdisi = false;

    // Backward compatibility for automated tests
    public bool $tampilkanModalPenerima = false;
    public bool $tampilkanModalEdisi = false;

    // Form Penerima
    public ?string $editPenerimaId = null;
    public string $apmo_tahun_id = '';
    public string $kategori_penghargaan = 'Tokoh Olahraga Rekreasi';
    public string $nama_penerima = '';
    public string $asal_lembaga_wilayah = '';
    public string $deskripsi_capaian = '';
    public string $foto_url = '';  // path MinIO
    public $uploadFotoPenerima = null; // file upload sementara
    public int $urutan = 1;

    // Form Edisi Tahun
    public ?string $editEdisiId = null;
    public int $tahun = 2026;
    public string $tema_acara = '';
    public string $tanggal_penganugerahan = '';
    public string $tempat_acara = '';
    public string $deskripsi = '';

    public function mount(): void
    {
        $this->tahun = (int) now()->format('Y');
        $firstTahun = ApmoTahun::first();
        if ($firstTahun) {
            $this->apmo_tahun_id = $firstTahun->id;
        }
    }

    public function updatedCari(): void
    {
        $this->resetPage();
    }

    public function updatedTahunDipilih(): void
    {
        $this->resetPage();
    }

    public function updatedTabAktif(): void
    {
        $this->resetPage();
    }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->tampilkanModalPenerima = false;
        $this->tampilkanModalEdisi = false;
        $this->resetPenerimaInput();
        $this->resetEdisiInput();
    }

    // ==========================================
    // PENERIMA ACTIONS
    // ==========================================
    public function bukaFormPenerimaTambah(): void
    {
        $this->resetPenerimaInput();
        $firstTahun = ApmoTahun::first();
        if ($firstTahun) {
            $this->apmo_tahun_id = $firstTahun->id;
        }
        $this->mode = 'form_penerima';
        $this->tampilkanModalPenerima = true;
        $this->resetErrorBag();
    }

    public function bukaModalPenerimaTambah(): void
    {
        $this->bukaFormPenerimaTambah();
    }

    public function bukaFormPenerimaEdit(string $id): void
    {
        $penerima = ApmoPenerima::findOrFail($id);
        $this->editPenerimaId = $penerima->id;
        $this->apmo_tahun_id = $penerima->apmo_tahun_id;
        $this->kategori_penghargaan = $penerima->kategori_penghargaan;
        $this->nama_penerima = $penerima->nama_penerima;
        $this->asal_lembaga_wilayah = $penerima->asal_lembaga_wilayah ?? '';
        $this->deskripsi_capaian = $penerima->deskripsi_capaian;
        $this->foto_url = $penerima->foto_url ?? '';
        $this->urutan = (int) $penerima->urutan;
        $this->uploadFotoPenerima = null;
        $this->mode = 'form_penerima';
        $this->tampilkanModalPenerima = true;
        $this->resetErrorBag();
    }

    public function bukaModalPenerimaEdit(string $id): void
    {
        $this->bukaFormPenerimaEdit($id);
    }

    public function setPresetFotoPenerima(string $url): void
    {
        // Dipertahankan untuk kompatibilitas — tidak digunakan saat MinIO aktif
        $this->foto_url = $url;
    }

    public function simpanPenerima(): void
    {
        $rules = [
            'apmo_tahun_id'        => 'required|exists:kormi_apmo_tahun,id',
            'kategori_penghargaan' => 'required|min:3|max:100',
            'nama_penerima'        => 'required|min:3|max:150',
            'asal_lembaga_wilayah' => 'nullable|string|max:150',
            'deskripsi_capaian'    => 'required|min:5',
            'urutan'               => 'required|integer',
        ];

        $rules['uploadFotoPenerima'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120';

        $this->validate($rules, [
            'uploadFotoPenerima.required' => 'Foto penerima wajib diunggah untuk data baru.',
            'uploadFotoPenerima.image'    => 'File harus berupa gambar.',
            'uploadFotoPenerima.mimes'    => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'uploadFotoPenerima.max'      => 'Ukuran foto maksimal 5 MB.',
        ]);

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $pathFoto = $this->foto_url;
        if ($this->uploadFotoPenerima) {
            if ($this->editPenerimaId && !empty($this->foto_url)) {
                $storage->hapusFile($this->foto_url);
            }
            $pathFoto = $storage->uploadGambar($this->uploadFotoPenerima, 'apmo');
        }

        if ($this->editPenerimaId) {
            $penerima = ApmoPenerima::findOrFail($this->editPenerimaId);
            $penerima->update([
                'apmo_tahun_id'        => $this->apmo_tahun_id,
                'kategori_penghargaan' => $this->kategori_penghargaan,
                'nama_penerima'        => $this->nama_penerima,
                'asal_lembaga_wilayah' => $this->asal_lembaga_wilayah,
                'deskripsi_capaian'    => $this->deskripsi_capaian,
                'foto_url'             => $pathFoto,
                'urutan'               => $this->urutan,
            ]);
            session()->flash('pesan', 'Data penerima anugerah APMO berhasil diperbarui!');
        } else {
            ApmoPenerima::create([
                'id'                   => (string) Str::uuid(),
                'apmo_tahun_id'        => $this->apmo_tahun_id,
                'kategori_penghargaan' => $this->kategori_penghargaan,
                'nama_penerima'        => $this->nama_penerima,
                'asal_lembaga_wilayah' => $this->asal_lembaga_wilayah,
                'deskripsi_capaian'    => $this->deskripsi_capaian,
                'foto_url'             => $pathFoto,
                'urutan'               => $this->urutan,
            ]);
            session()->flash('pesan', 'Penerima anugerah APMO baru berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapusPenerima(string $id): void
    {
        $penerima = ApmoPenerima::findOrFail($id);
        $nama = $penerima->nama_penerima;
        app(StorageService::class)->hapusFile($penerima->foto_url);
        $penerima->delete();
        session()->flash('pesan', 'Penerima "' . $nama . '" berhasil dihapus.');
    }

    // ==========================================
    // EDISI TAHUN ACTIONS
    // ==========================================
    public function bukaFormEdisiTambah(): void
    {
        $this->resetEdisiInput();
        $this->tanggal_penganugerahan = now()->format('Y-m-d');
        $this->tempat_acara = 'Gedung Budaya Sabilulungan Soreang';
        $this->mode = 'form_edisi';
        $this->tampilkanModalEdisi = true;
    }

    public function bukaModalEdisiTambah(): void
    {
        $this->bukaFormEdisiTambah();
    }

    public function bukaFormEdisiEdit(string $id): void
    {
        $edisi = ApmoTahun::findOrFail($id);
        $this->editEdisiId = $edisi->id;
        $this->tahun = (int) $edisi->tahun;
        $this->tema_acara = $edisi->tema_acara ?? '';
        $this->tanggal_penganugerahan = $edisi->tanggal_penganugerahan ?? '';
        $this->tempat_acara = $edisi->tempat_acara ?? '';
        $this->deskripsi = $edisi->deskripsi ?? '';
        $this->mode = 'form_edisi';
        $this->tampilkanModalEdisi = true;
    }

    public function bukaModalEdisiEdit(string $id): void
    {
        $this->bukaFormEdisiEdit($id);
    }

    public function simpanEdisi(): void
    {
        $this->validate([
            'tahun' => 'required|integer|min:2000|max:2100',
            'tema_acara' => 'nullable|string|max:255',
            'tanggal_penganugerahan' => 'nullable|date',
            'tempat_acara' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        if ($this->editEdisiId) {
            $edisi = ApmoTahun::findOrFail($this->editEdisiId);
            $edisi->update([
                'tahun' => $this->tahun,
                'tema_acara' => $this->tema_acara,
                'tanggal_penganugerahan' => $this->tanggal_penganugerahan ?: null,
                'tempat_acara' => $this->tempat_acara,
                'deskripsi' => $this->deskripsi,
            ]);
            session()->flash('pesan', 'Edisi APMO berhasil diperbarui!');
        } else {
            ApmoTahun::create([
                'id' => (string) Str::uuid(),
                'tahun' => $this->tahun,
                'tema_acara' => $this->tema_acara,
                'tanggal_penganugerahan' => $this->tanggal_penganugerahan ?: null,
                'tempat_acara' => $this->tempat_acara,
                'deskripsi' => $this->deskripsi,
            ]);
            session()->flash('pesan', 'Edisi APMO baru berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapusEdisi(string $id): void
    {
        $edisi = ApmoTahun::findOrFail($id);
        $tahun = $edisi->tahun;
        $edisi->delete();
        session()->flash('pesan', 'Edisi APMO ' . $tahun . ' berhasil dihapus.');
    }

    private function resetPenerimaInput(): void
    {
        $this->editPenerimaId = null;
        $this->apmo_tahun_id = '';
        $this->kategori_penghargaan = 'Tokoh Olahraga Rekreasi';
        $this->nama_penerima = '';
        $this->asal_lembaga_wilayah = '';
        $this->deskripsi_capaian = '';
        $this->foto_url = '';
        $this->uploadFotoPenerima = null;
        $this->urutan = 1;
    }

    private function resetEdisiInput(): void
    {
        $this->editEdisiId = null;
        $this->tahun = (int) now()->format('Y');
        $this->tema_acara = '';
        $this->tanggal_penganugerahan = '';
        $this->tempat_acara = '';
        $this->deskripsi = '';
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage('penerimaPage');
        $this->resetPage('edisiPage');
    }

    public function updatedPilihSemuaPenerima(bool $value): void
    {
        if ($value) {
            $this->selectedPenerima = ApmoPenerima::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedPenerima = [];
        }
    }

    public function updatedPilihSemuaEdisi(bool $value): void
    {
        if ($value) {
            $this->selectedEdisi = ApmoTahun::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedEdisi = [];
        }
    }

    public function resetSelectionPenerima(): void
    {
        $this->selectedPenerima = [];
        $this->pilihSemuaPenerima = false;
    }

    public function resetSelectionEdisi(): void
    {
        $this->selectedEdisi = [];
        $this->pilihSemuaEdisi = false;
    }

    public function bulkDeletePenerima(): void
    {
        if (empty($this->selectedPenerima)) return;
        $penerimas = ApmoPenerima::whereIn('id', $this->selectedPenerima)->get();
        $storage = app(StorageService::class);
        foreach ($penerimas as $p) {
            $storage->hapusFile($p->foto_url);
            $p->delete();
        }
        session()->flash('pesan', count($this->selectedPenerima) . ' data penerima anugerah APMO berhasil dihapus.');
        $this->resetSelectionPenerima();
    }

    public function bulkDeleteEdisi(): void
    {
        if (empty($this->selectedEdisi)) return;
        ApmoTahun::whereIn('id', $this->selectedEdisi)->delete();
        session()->flash('pesan', count($this->selectedEdisi) . ' edisi tahunan APMO berhasil dihapus.');
        $this->resetSelectionEdisi();
    }

    public function setFilterKategori(string $kat): void
    {
        $this->kategoriFilter = $kat;
        $this->resetPage('penerimaPage');
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->tahunDipilih = 'Semua';
        $this->kategoriFilter = 'Semua';
        $this->resetPage('penerimaPage');
        $this->resetPage('edisiPage');
    }

    public function render()
    {
        $semuaEdisi = ApmoTahun::orderByDesc('tahun')->get();

        $queryPenerima = ApmoPenerima::with('tahun')
            ->when($this->tahunDipilih !== 'Semua', function ($q) {
                $q->whereHas('tahun', fn($t) => $t->where('tahun', $this->tahunDipilih));
            })
            ->when($this->kategoriFilter !== 'Semua', function ($q) {
                $q->where('kategori_penghargaan', $this->kategoriFilter);
            })
            ->when($this->cari, function ($q) {
                $q->where('nama_penerima', 'like', '%' . $this->cari . '%')
                  ->orWhere('kategori_penghargaan', 'like', '%' . $this->cari . '%')
                  ->orWhere('asal_lembaga_wilayah', 'like', '%' . $this->cari . '%');
            });

        if (in_array($this->sortField, ['urutan', 'nama_penerima', 'kategori_penghargaan', 'created_at'])) {
            $queryPenerima->orderBy($this->sortField, $this->sortDirection);
        } else {
            $queryPenerima->orderBy('urutan');
        }

        $queryEdisi = ApmoTahun::withCount('penerima')
            ->when($this->cari, function ($q) {
                $q->where('tahun', 'like', '%' . $this->cari . '%')
                  ->orWhere('tema_acara', 'like', '%' . $this->cari . '%')
                  ->orWhere('tempat_acara', 'like', '%' . $this->cari . '%');
            });

        if (in_array($this->sortField, ['tahun', 'tanggal_penganugerahan', 'tema_acara'])) {
            $queryEdisi->orderBy($this->sortField, $this->sortDirection);
        } else {
            $queryEdisi->orderByDesc('tahun');
        }

        $edisiTerbaru = ApmoTahun::orderByDesc('tahun')->first();

        return view('livewire.admin.apmo.apmo-kelola', [
            'daftarPenerima' => $queryPenerima->paginate($this->perPage, ['*'], 'penerimaPage'),
            'daftarEdisi' => $queryEdisi->paginate($this->perPage, ['*'], 'edisiPage'),
            'semuaEdisi' => $semuaEdisi,
            'totalPenerima' => ApmoPenerima::count(),
            'totalEdisi' => ApmoTahun::count(),
            'edisiTerbaru' => $edisiTerbaru,
        ]);
    }
}
