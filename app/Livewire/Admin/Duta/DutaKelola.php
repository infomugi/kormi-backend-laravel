<?php

namespace App\Livewire\Admin\Duta;

use App\Models\DesaKelurahan;
use App\Models\DutaOlahraga;
use App\Models\Kecamatan;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Duta Olahraga - KORMI CMS')]
class DutaKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel'; // 'tabel' atau 'form'
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'
    public string $cari = '';
    public string $kecamatanDipilih = 'Semua';
    public string $tahunDipilih = 'Semua';
    public string $kategoriDipilih = 'Semua';
    public string $sortField = 'nama_lengkap';
    public string $sortDirection = 'asc';
    public int $perPage = 12;

    // Bulk actions
    public array $selectedDuta = [];
    public bool $pilihSemua = false;

    // Backward compatibility for automated tests
    public bool $tampilkanModal = false;

    // Form fields
    public ?string $dutaId = null;
    public string $kecamatan_id = '';
    public string $desa_kelurahan_id = '';
    public string $nama_lengkap = '';
    public int $tahun_pemilihan = 2026;
    public string $kategori_duta = 'Duta Olahraga Masyarakat';
    public string $foto_url = '';    // path MinIO
    public $uploadFotoDuta = null;   // file upload sementara
    public string $prestasi = '';
    public string $kontak = '';

    protected function rules(): array
    {
        return [
            'kecamatan_id'    => 'required|exists:kormi_kecamatan,id',
            'nama_lengkap'    => 'required|max:150',
            'tahun_pemilihan' => 'required|integer|min:2020|max:2030',
            'kategori_duta'   => 'required|string|max:100',
        ];
    }

    public function mount(): void
    {
        $firstKec = Kecamatan::first();
        if ($firstKec) {
            $this->kecamatan_id = $firstKec->id;
            $firstDesa = DesaKelurahan::where('kecamatan_id', $this->kecamatan_id)->first();
            $this->desa_kelurahan_id = $firstDesa?->id ?? '';
        }
    }

    public function updatedCari(): void             { $this->resetPage(); }
    public function updatedKecamatanDipilih(): void  { $this->resetPage(); }
    public function updatedTahunDipilih(): void      { $this->resetPage(); }
    public function updatedKategoriDipilih(): void   { $this->resetPage(); }
    public function updatedPerPage(): void           { $this->resetPage(); }

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
            $query = DutaOlahraga::query()
                ->when($this->kecamatanDipilih !== 'Semua', fn($q) => $q->where('kecamatan_id', $this->kecamatanDipilih))
                ->when($this->tahunDipilih !== 'Semua', fn($q) => $q->where('tahun_pemilihan', $this->tahunDipilih))
                ->when($this->kategoriDipilih !== 'Semua', fn($q) => $q->where('kategori_duta', $this->kategoriDipilih))
                ->when($this->cari, fn($q) => $q->where(function ($sub) {
                    $sub->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                        ->orWhereHas('desaKelurahan', fn($dq) => $dq->where('nama_desa_kelurahan', 'like', '%' . $this->cari . '%'));
                }));
            $this->selectedDuta = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedDuta = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedDuta = [];
        $this->pilihSemua = false;
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->kecamatanDipilih = 'Semua';
        $this->tahunDipilih = 'Semua';
        $this->kategoriDipilih = 'Semua';
        $this->resetPage();
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedDuta)) return;

        $count = count($this->selectedDuta);
        $dutas = DutaOlahraga::whereIn('id', $this->selectedDuta)->get();
        $storage = app(StorageService::class);

        foreach ($dutas as $duta) {
            $storage->hapusFile($duta->foto_url);
            $duta->delete();
        }

        $this->resetSelection();
        session()->flash('pesan', "{$count} data Duta Olahraga berhasil dihapus!");
    }

    public function updatedKecamatanId(string $value): void
    {
        $firstDesa = DesaKelurahan::where('kecamatan_id', $value)->first();
        $this->desa_kelurahan_id = $firstDesa?->id ?? '';
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
        $firstKec = Kecamatan::first();
        if ($firstKec) {
            $this->kecamatan_id = $firstKec->id;
            $firstDesa = DesaKelurahan::where('kecamatan_id', $this->kecamatan_id)->first();
            $this->desa_kelurahan_id = $firstDesa?->id ?? '';
        }
        $this->tahun_pemilihan = 2026;
        $this->kategori_duta = 'Duta Olahraga Masyarakat';
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
        $d = DutaOlahraga::findOrFail($id);
        $this->dutaId            = $d->id;
        $this->kecamatan_id      = $d->kecamatan_id;
        $this->desa_kelurahan_id = $d->desa_kelurahan_id ?? '';
        $this->nama_lengkap      = $d->nama_lengkap;
        $this->tahun_pemilihan   = (int) $d->tahun_pemilihan;
        $this->kategori_duta     = $d->kategori_duta ?: 'Duta Olahraga Masyarakat';
        $this->foto_url          = $d->foto_url ?? '';
        $this->prestasi          = $d->prestasi ?? '';
        $this->kontak            = $d->kontak ?? '';
        $this->uploadFotoDuta    = null;
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
        $rules = [
            'kecamatan_id'    => 'required|exists:kormi_kecamatan,id',
            'nama_lengkap'    => 'required|max:150',
            'tahun_pemilihan' => 'required|integer|min:2020|max:2030',
            'kategori_duta'   => 'required|string|max:100',
            'prestasi'        => 'nullable|string',
            'kontak'          => 'nullable|string|max:100',
        ];

        $rules['uploadFotoDuta'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120';

        $this->validate($rules, [
            'uploadFotoDuta.required' => 'Foto duta wajib diunggah untuk data baru.',
            'uploadFotoDuta.image'    => 'File harus berupa gambar.',
            'uploadFotoDuta.mimes'    => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'uploadFotoDuta.max'      => 'Ukuran foto maksimal 5 MB.',
        ]);

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $pathFoto = $this->foto_url;
        if ($this->uploadFotoDuta) {
            if ($this->dutaId && !empty($this->foto_url)) {
                $storage->hapusFile($this->foto_url);
            }
            $pathFoto = $storage->uploadGambar($this->uploadFotoDuta, 'duta');
        }

        $data = [
            'kecamatan_id'     => $this->kecamatan_id,
            'desa_kelurahan_id'=> !empty($this->desa_kelurahan_id) ? $this->desa_kelurahan_id : null,
            'nama_lengkap'     => trim($this->nama_lengkap),
            'tahun_pemilihan'  => $this->tahun_pemilihan,
            'kategori_duta'    => $this->kategori_duta,
            'foto_url'         => $pathFoto,
            'prestasi'         => $this->prestasi,
            'kontak'           => $this->kontak,
        ];

        if ($this->dutaId) {
            DutaOlahraga::findOrFail($this->dutaId)->update($data);
            session()->flash('pesan', 'Data Duta Olahraga ' . $this->nama_lengkap . ' berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            DutaOlahraga::create($data);
            session()->flash('pesan', 'Duta Olahraga baru berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $d = DutaOlahraga::findOrFail($id);
        $nama = $d->nama_lengkap;
        app(StorageService::class)->hapusFile($d->foto_url);
        $d->delete();
        session()->flash('pesan', 'Duta Olahraga "' . $nama . '" berhasil dihapus.');
    }

    public function resetForm(): void
    {
        $this->dutaId            = null;
        $this->kecamatan_id      = '';
        $this->desa_kelurahan_id = '';
        $this->nama_lengkap      = '';
        $this->tahun_pemilihan   = 2026;
        $this->kategori_duta     = 'Duta Olahraga Masyarakat';
        $this->foto_url          = '';
        $this->uploadFotoDuta    = null;
        $this->prestasi          = '';
        $this->kontak            = '';
    }

    public function render()
    {
        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();
        $desaList = DesaKelurahan::where('kecamatan_id', $this->kecamatan_id)->orderBy('nama_desa_kelurahan')->get();

        $query = DutaOlahraga::with('kecamatan', 'desaKelurahan')
            ->when($this->kecamatanDipilih !== 'Semua', fn($q) => $q->where('kecamatan_id', $this->kecamatanDipilih))
            ->when($this->tahunDipilih !== 'Semua', fn($q) => $q->where('tahun_pemilihan', $this->tahunDipilih))
            ->when($this->kategoriDipilih !== 'Semua', fn($q) => $q->where('kategori_duta', $this->kategoriDipilih))
            ->when($this->cari, fn($q) => $q->where(function ($sub) {
                $sub->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                    ->orWhere('prestasi', 'like', '%' . $this->cari . '%')
                    ->orWhere('kontak', 'like', '%' . $this->cari . '%')
                    ->orWhereHas('desaKelurahan', fn($dq) => $dq->where('nama_desa_kelurahan', 'like', '%' . $this->cari . '%'))
                    ->orWhereHas('kecamatan', fn($kq) => $kq->where('nama_kecamatan', 'like', '%' . $this->cari . '%'));
            }))
            ->orderBy($this->sortField, $this->sortDirection);

        $totalDuta = DutaOlahraga::count();
        $totalKecamatanTerwakili = DutaOlahraga::distinct('kecamatan_id')->count('kecamatan_id');
        $dutaTahunIni = DutaOlahraga::where('tahun_pemilihan', 2026)->count();
        $tahunList = DutaOlahraga::distinct()->orderByDesc('tahun_pemilihan')->pluck('tahun_pemilihan');

        return view('livewire.admin.duta.duta-kelola', [
            'kecamatanList' => $kecamatanList,
            'desaList' => $desaList,
            'dutaList' => $query->paginate($this->perPage),
            'totalDuta' => $totalDuta,
            'totalKecamatanTerwakili' => $totalKecamatanTerwakili,
            'dutaTahunIni' => $dutaTahunIni,
            'tahunList' => $tahunList,
        ]);
    }
}
