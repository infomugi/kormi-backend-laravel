<?php

namespace App\Livewire\Backend\Kormi\Duta;

use App\Models\Master\DesaKelurahan;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Master\Kecamatan;
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
    public string $statusDipilih = 'Semua';
    public string $unggulanDipilih = 'Semua';
    public string $sortField = 'nama_lengkap';
    public string $sortDirection = 'asc';
    public int $perPage = 12;

    // Bulk actions
    public array $selectedDuta = [];
    public bool $pilihSemua = false;

    // Backward compatibility for automated tests & modals
    public bool $tampilkanModal = false;
    public bool $tampilkanModalPratinjau = false;
    public ?DutaOlahraga $pratinjauDuta = null;

    public bool $tampilkanModalHapus = false;
    public ?string $hapusId = null;
    public ?string $hapusNama = null;

    // Form fields (Detailed Inputs)
    public ?string $dutaId = null;
    public string $kecamatan_id = '';
    public string $desa_kelurahan_id = '';
    public string $nama_lengkap = '';
    public string $jenis_kelamin = 'L';
    public string $tempat_lahir = '';
    public ?string $tanggal_lahir = null;
    public string $nomor_telepon = '';
    public string $email = '';
    public string $alamat_domisili = '';
    public string $pekerjaan_profesi = '';
    public string $pendidikan_terakhir = '';
    public int $tahun_pemilihan = 2026;
    public string $kategori_duta = 'Duta Olahraga Masyarakat';
    public string $gelar_prestasi = '';
    public string $deskripsi_prestasi = '';
    public string $akun_instagram = '';
    public string $foto_url = '';    // path MinIO
    public $uploadFotoDuta = null;   // file upload sementara
    public bool $status_aktif = true;
    public bool $status_unggulan = false;

    // Backward compatibility aliases
    public string $prestasi = '';
    public string $kontak = '';

    protected function rules(): array
    {
        return [
            'kecamatan_id'        => 'required|exists:ref_kecamatan,id',
            'desa_kelurahan_id'   => 'nullable|exists:ref_desa_kelurahan,id',
            'nama_lengkap'        => 'required|min:3|max:150',
            'jenis_kelamin'       => 'required|in:L,P',
            'tempat_lahir'        => 'nullable|max:100',
            'tanggal_lahir'       => 'nullable|date',
            'nomor_telepon'       => 'nullable|max:25',
            'email'               => 'nullable|email|max:100',
            'alamat_domisili'     => 'nullable|max:500',
            'pekerjaan_profesi'   => 'nullable|max:100',
            'pendidikan_terakhir' => 'nullable|max:50',
            'tahun_pemilihan'     => 'required|integer|min:2020|max:2030',
            'kategori_duta'       => 'required|string|max:100',
            'gelar_prestasi'      => 'nullable|max:150',
            'deskripsi_prestasi'  => 'nullable',
            'akun_instagram'      => 'nullable|max:100',
            'status_aktif'        => 'boolean',
            'status_unggulan'     => 'boolean',
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

    public function updatedCari(): void             { $this->resetPage(); $this->resetSelection(); }
    public function updatedKecamatanDipilih(): void  { $this->resetPage(); $this->resetSelection(); }
    public function updatedTahunDipilih(): void      { $this->resetPage(); $this->resetSelection(); }
    public function updatedKategoriDipilih(): void   { $this->resetPage(); $this->resetSelection(); }
    public function updatedStatusDipilih(): void     { $this->resetPage(); $this->resetSelection(); }
    public function updatedUnggulanDipilih(): void   { $this->resetPage(); $this->resetSelection(); }
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

    protected function getDutaQuery()
    {
        return DutaOlahraga::with(['kecamatan', 'desaKelurahan'])
            ->when($this->kecamatanDipilih !== 'Semua', fn($q) => $q->where('kecamatan_id', $this->kecamatanDipilih))
            ->when($this->tahunDipilih !== 'Semua', fn($q) => $q->where('tahun_pemilihan', $this->tahunDipilih))
            ->when($this->kategoriDipilih !== 'Semua', fn($q) => $q->where('kategori_duta', $this->kategoriDipilih))
            ->when($this->statusDipilih !== 'Semua', fn($q) => $q->where('status_aktif', $this->statusDipilih === 'aktif'))
            ->when($this->unggulanDipilih !== 'Semua', fn($q) => $q->where('status_unggulan', $this->unggulanDipilih === 'ya'))
            ->when($this->cari, fn($q) => $q->where(function ($sub) {
                $sub->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                    ->orWhere('gelar_prestasi', 'like', '%' . $this->cari . '%')
                    ->orWhere('deskripsi_prestasi', 'like', '%' . $this->cari . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $this->cari . '%')
                    ->orWhere('akun_instagram', 'like', '%' . $this->cari . '%')
                    ->orWhere('pekerjaan_profesi', 'like', '%' . $this->cari . '%')
                    ->orWhereHas('desaKelurahan', fn($dq) => $dq->where('nama_desa_kelurahan', 'like', '%' . $this->cari . '%'))
                    ->orWhereHas('kecamatan', fn($kq) => $kq->where('nama_kecamatan', 'like', '%' . $this->cari . '%'));
            }));
    }

    public function updatedPilihSemua(bool $value): void
    {
        if ($value) {
            $this->selectedDuta = $this->getDutaQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
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
        $this->reset(['cari', 'kecamatanDipilih', 'tahunDipilih', 'kategoriDipilih', 'statusDipilih', 'unggulanDipilih']);
        $this->resetPage();
        $this->resetSelection();
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
        $this->jenis_kelamin = 'L';
        $this->status_aktif = true;
        $this->status_unggulan = false;
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
        $this->dutaId              = $d->id;
        $this->kecamatan_id        = $d->kecamatan_id;
        $this->desa_kelurahan_id   = $d->desa_kelurahan_id ?? '';
        $this->nama_lengkap        = $d->nama_lengkap;
        $this->jenis_kelamin       = $d->jenis_kelamin ?? 'L';
        $this->tempat_lahir        = $d->tempat_lahir ?? '';
        $this->tanggal_lahir       = $d->tanggal_lahir ? $d->tanggal_lahir->format('Y-m-d') : null;
        $this->nomor_telepon       = $d->nomor_telepon ?? ($d->kontak ?? '');
        $this->email               = $d->email ?? '';
        $this->alamat_domisili     = $d->alamat_domisili ?? '';
        $this->pekerjaan_profesi   = $d->pekerjaan_profesi ?? '';
        $this->pendidikan_terakhir = $d->pendidikan_terakhir ?? '';
        $this->tahun_pemilihan     = (int) $d->tahun_pemilihan;
        $this->kategori_duta       = $d->kategori_duta ?: 'Duta Olahraga Masyarakat';
        $this->gelar_prestasi      = $d->gelar_prestasi ?? '';
        $this->deskripsi_prestasi  = $d->deskripsi_prestasi ?? ($d->prestasi ?? '');
        $this->akun_instagram      = $d->akun_instagram ?? '';
        $this->foto_url            = $d->foto_url ?? '';
        $this->status_aktif        = (bool) $d->status_aktif;
        $this->status_unggulan     = (bool) $d->status_unggulan;
        $this->uploadFotoDuta      = null;
        
        // Aliases
        $this->prestasi = $this->deskripsi_prestasi;
        $this->kontak = $this->nomor_telepon;

        $this->mode = 'form';
        $this->tampilkanModal = true;
        $this->resetErrorBag();
    }

    public function bukaModalEdit(string $id): void
    {
        $this->bukaFormEdit($id);
    }

    public function bukaPratinjau(string $id): void
    {
        $this->pratinjauDuta = DutaOlahraga::with(['kecamatan', 'desaKelurahan'])->findOrFail($id);
        $this->tampilkanModalPratinjau = true;
    }

    public function tutupPratinjau(): void
    {
        $this->tampilkanModalPratinjau = false;
        $this->pratinjauDuta = null;
    }

    // ==========================================
    // INLINE EDITABLE & FAST TOGGLES
    // ==========================================
    public function updateFieldInline(string $id, string $field, $value): void
    {
        $duta = DutaOlahraga::findOrFail($id);
        
        if ($field === 'nama_lengkap') {
            $this->validate(['nama_lengkap' => 'required|min:3|max:150'], [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
                'nama_lengkap.min' => 'Nama minimal 3 karakter.'
            ]);
            $duta->nama_lengkap = trim($value);
        } elseif ($field === 'gelar_prestasi') {
            $duta->gelar_prestasi = trim($value) ?: null;
        } elseif ($field === 'nomor_telepon') {
            $duta->nomor_telepon = trim($value) ?: null;
        } elseif ($field === 'kategori_duta') {
            $duta->kategori_duta = trim($value);
        } elseif ($field === 'tahun_pemilihan') {
            $duta->tahun_pemilihan = (int) $value;
        }

        $duta->save();
        session()->flash('pesan', 'Berhasil memperbarui ' . ucwords(str_replace('_', ' ', $field)) . ' untuk ' . $duta->nama_lengkap);
    }

    public function toggleUnggulan(string $id): void
    {
        $d = DutaOlahraga::findOrFail($id);
        $d->status_unggulan = !$d->status_unggulan;
        $d->save();

        $status = $d->status_unggulan ? 'Duta Utama / Unggulan' : 'Duta Reguler';
        session()->flash('pesan', "Status {$d->nama_lengkap} diubah menjadi {$status}.");
    }

    public function toggleAktif(string $id): void
    {
        $d = DutaOlahraga::findOrFail($id);
        $d->status_aktif = !$d->status_aktif;
        $d->save();

        $status = $d->status_aktif ? 'Aktif' : 'Non-Aktif';
        session()->flash('pesan', "Status keaktifan {$d->nama_lengkap} diubah menjadi {$status}.");
    }

    public function duplikatDuta(string $id): void
    {
        $sumber = DutaOlahraga::findOrFail($id);
        
        $duplikat = $sumber->replicate();
        $duplikat->id = (string) Str::uuid();
        $duplikat->nama_lengkap = '[Salinan] ' . $sumber->nama_lengkap;
        $duplikat->status_unggulan = false;
        $duplikat->save();

        session()->flash('pesan', "Data Duta \"{$sumber->nama_lengkap}\" berhasil disalin!");
    }

    // ==========================================
    // BULK ACTIONS
    // ==========================================
    public function bulkToggleUnggulan(bool $status): void
    {
        if (empty($this->selectedDuta)) return;

        DutaOlahraga::whereIn('id', $this->selectedDuta)->update([
            'status_unggulan' => $status,
        ]);

        $label = $status ? 'dijadikan Duta Unggulan' : 'dihapus dari Duta Unggulan';
        session()->flash('pesan', count($this->selectedDuta) . " data duta {$label}!");
        $this->resetSelection();
    }

    public function bulkToggleAktif(bool $status): void
    {
        if (empty($this->selectedDuta)) return;

        DutaOlahraga::whereIn('id', $this->selectedDuta)->update([
            'status_aktif' => $status,
        ]);

        $label = $status ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('pesan', count($this->selectedDuta) . " data duta berhasil {$label}!");
        $this->resetSelection();
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

    // ==========================================
    // SIMPAN FORM
    // ==========================================
    public function simpan(): void
    {
        // Handle fallback aliases jika inputan diisi lewat test
        if (!empty($this->prestasi) && empty($this->deskripsi_prestasi)) {
            $this->deskripsi_prestasi = $this->prestasi;
        }
        if (!empty($this->kontak) && empty($this->nomor_telepon)) {
            $this->nomor_telepon = $this->kontak;
        }

        $rules = $this->rules();
        if ($this->uploadFotoDuta) {
            $rules['uploadFotoDuta'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120';
        }

        $this->validate($rules, [
            'kecamatan_id.required'   => 'Kecamatan penugasan wajib dipilih.',
            'nama_lengkap.required'   => 'Nama lengkap duta wajib diisi.',
            'nama_lengkap.min'        => 'Nama lengkap minimal 3 karakter.',
            'tahun_pemilihan.required'=> 'Tahun pemilihan wajib diisi.',
            'kategori_duta.required'  => 'Kategori duta wajib dipilih.',
            'uploadFotoDuta.image'    => 'Berkas harus berupa gambar.',
            'uploadFotoDuta.mimes'    => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
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
            'kecamatan_id'        => $this->kecamatan_id,
            'desa_kelurahan_id'   => !empty($this->desa_kelurahan_id) ? $this->desa_kelurahan_id : null,
            'nama_lengkap'        => trim($this->nama_lengkap),
            'jenis_kelamin'       => $this->jenis_kelamin ?: 'L',
            'tempat_lahir'        => trim($this->tempat_lahir) ?: null,
            'tanggal_lahir'       => $this->tanggal_lahir ?: null,
            'nomor_telepon'       => trim($this->nomor_telepon) ?: null,
            'email'               => trim($this->email) ?: null,
            'alamat_domisili'     => trim($this->alamat_domisili) ?: null,
            'pekerjaan_profesi'   => trim($this->pekerjaan_profesi) ?: null,
            'pendidikan_terakhir' => trim($this->pendidikan_terakhir) ?: null,
            'tahun_pemilihan'     => (int) $this->tahun_pemilihan,
            'kategori_duta'       => $this->kategori_duta,
            'gelar_prestasi'      => trim($this->gelar_prestasi) ?: null,
            'deskripsi_prestasi'  => trim($this->deskripsi_prestasi) ?: null,
            'akun_instagram'      => trim(str_replace('@', '', $this->akun_instagram)) ?: null,
            'foto_url'            => $pathFoto,
            'status_aktif'        => (bool) $this->status_aktif,
            'status_unggulan'     => (bool) $this->status_unggulan,
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

    public function konfirmasiHapus(string $id): void
    {
        $d = DutaOlahraga::findOrFail($id);
        $this->hapusId = $d->id;
        $this->hapusNama = $d->nama_lengkap;
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
        $this->dutaId              = null;
        $this->kecamatan_id        = '';
        $this->desa_kelurahan_id   = '';
        $this->nama_lengkap        = '';
        $this->jenis_kelamin       = 'L';
        $this->tempat_lahir        = '';
        $this->tanggal_lahir       = null;
        $this->nomor_telepon       = '';
        $this->email               = '';
        $this->alamat_domisili     = '';
        $this->pekerjaan_profesi   = '';
        $this->pendidikan_terakhir = '';
        $this->tahun_pemilihan     = 2026;
        $this->kategori_duta       = 'Duta Olahraga Masyarakat';
        $this->gelar_prestasi      = '';
        $this->deskripsi_prestasi  = '';
        $this->akun_instagram      = '';
        $this->foto_url            = '';
        $this->uploadFotoDuta      = null;
        $this->status_aktif        = true;
        $this->status_unggulan     = false;
        $this->prestasi            = '';
        $this->kontak              = '';
    }

    public function render()
    {
        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();
        $desaList = DesaKelurahan::where('kecamatan_id', $this->kecamatan_id)->orderBy('nama_desa_kelurahan')->get();

        $query = $this->getDutaQuery()->orderBy($this->sortField, $this->sortDirection);

        $totalDuta = DutaOlahraga::count();
        $totalKecamatanTerwakili = DutaOlahraga::distinct('kecamatan_id')->count('kecamatan_id');
        $dutaTahunIni = DutaOlahraga::where('tahun_pemilihan', 2026)->count();
        $dutaUnggulanCount = DutaOlahraga::where('status_unggulan', true)->count();
        $tahunList = DutaOlahraga::distinct()->orderByDesc('tahun_pemilihan')->pluck('tahun_pemilihan');

        return view('livewire.backend.kormi.duta.duta-kelola', [
            'kecamatanList'           => $kecamatanList,
            'desaList'                => $desaList,
            'dutaList'                => $query->paginate($this->perPage),
            'totalDuta'               => $totalDuta,
            'totalKecamatanTerwakili' => $totalKecamatanTerwakili,
            'dutaTahunIni'            => $dutaTahunIni,
            'dutaUnggulanCount'       => $dutaUnggulanCount,
            'tahunList'               => $tahunList,
        ]);
    }
}
