<?php

namespace App\Livewire\Backend\Kormi\Sdi;

use App\Models\Kormi\SdiProgram;
use App\Models\Kormi\SdiJadwal;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola SDI Pelatihan & Sertifikasi - KORMI CMS')]
class SdiKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel'; // 'tabel', 'form_program', 'form_jadwal'
    public string $tabAktif = 'program'; // 'program' atau 'jadwal'
    public string $cari = '';
    public string $jenisSertifikasiFilter = 'Semua';
    public string $statusPendaftaranFilter = 'Semua';

    // Sorting & Pagination
    public string $sortField = 'dibuat_pada';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public string $tampilanMode = 'grid'; // 'grid' atau 'tabel' untuk program

    // Bulk actions
    public array $selectedProgram = [];
    public bool $pilihSemuaProgram = false;
    public array $selectedJadwal = [];
    public bool $pilihSemuaJadwal = false;

    // Backward compatibility for automated tests
    public bool $tampilkanModalProgram = false;
    public bool $tampilkanModalJadwal = false;

    // Form Program
    public ?string $editProgramId = null;
    public string $judul_program = '';
    public string $sasaran_peserta = '';
    public string $standar_kompetensi = '';
    public string $jenis_sertifikasi = 'Nasional KORMI';
    public string $banner_url = '';  // path MinIO
    public $uploadBanner = null;    // file upload sementara
    public bool $status_aktif = true;

    // Form Jadwal
    public ?string $editJadwalId = null;
    public string $program_id = '';
    public string $nama_angkatan = '';
    public string $tanggal_mulai = '';
    public string $tanggal_selesai = '';
    public string $lokasi_pelatihan = '';
    public int $kuota_peserta = 30;
    public string $status_pendaftaran = 'dibuka';

    public function updatedCari(): void
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
        $this->tampilkanModalProgram = false;
        $this->tampilkanModalJadwal = false;
        $this->resetProgramInput();
        $this->resetJadwalInput();
    }

    // ==========================================
    // PROGRAM PELATIHAN ACTIONS
    // ==========================================
    public function bukaFormProgramTambah(): void
    {
        $this->resetProgramInput();
        $this->mode = 'form_program';
        $this->tampilkanModalProgram = true;
        $this->resetErrorBag();
    }

    public function bukaModalProgramTambah(): void
    {
        $this->bukaFormProgramTambah();
    }

    public function bukaFormProgramEdit(string $id): void
    {
        $prog = SdiProgram::findOrFail($id);
        $this->editProgramId = $prog->id;
        $this->judul_program = $prog->judul_program;
        $this->sasaran_peserta = $prog->sasaran_peserta ?? '';
        $this->standar_kompetensi = $prog->standar_kompetensi ?? '';
        $this->jenis_sertifikasi = $prog->jenis_sertifikasi ?? 'Nasional KORMI';
        $this->banner_url  = $prog->banner_url ?? '';
        $this->status_aktif = (bool) $prog->status_aktif;
        $this->uploadBanner = null;
        $this->mode = 'form_program';
        $this->tampilkanModalProgram = true;
        $this->resetErrorBag();
    }

    public function bukaModalProgramEdit(string $id): void
    {
        $this->bukaFormProgramEdit($id);
    }

    public function setPresetBanner(string $url): void
    {
        // Dipertahankan untuk kompatibilitas — tidak digunakan saat MinIO aktif
        $this->banner_url = $url;
    }

    public function simpanProgram(): void
    {
        $rules = [
            'judul_program'     => 'required|min:3|max:200',
            'sasaran_peserta'   => 'nullable|string|max:150',
            'standar_kompetensi'=> 'nullable|string',
            'jenis_sertifikasi' => 'nullable|string|max:100',
        ];

        $rules['uploadBanner'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240';

        $this->validate($rules, [
            'uploadBanner.required' => 'Banner program wajib diunggah untuk data baru.',
            'uploadBanner.image'    => 'File harus berupa gambar.',
            'uploadBanner.mimes'    => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'uploadBanner.max'      => 'Ukuran banner maksimal 10 MB.',
        ]);

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $pathBanner = $this->banner_url;
        if ($this->uploadBanner) {
            if ($this->editProgramId && !empty($this->banner_url)) {
                $storage->hapusFile($this->banner_url);
            }
            $pathBanner = $storage->uploadGambar($this->uploadBanner, 'sdi');
        }

        $slug = Str::slug($this->judul_program);

        if ($this->editProgramId) {
            $prog = SdiProgram::findOrFail($this->editProgramId);
            $prog->update([
                'judul_program'     => $this->judul_program,
                'slug'              => $slug,
                'sasaran_peserta'   => $this->sasaran_peserta,
                'standar_kompetensi'=> $this->standar_kompetensi,
                'jenis_sertifikasi' => $this->jenis_sertifikasi,
                'banner_url'        => $pathBanner,
                'status_aktif'      => $this->status_aktif,
            ]);
            session()->flash('pesan', 'Program pelatihan SDI berhasil diperbarui!');
        } else {
            SdiProgram::create([
                'id'                => (string) Str::uuid(),
                'judul_program'     => $this->judul_program,
                'slug'              => $slug,
                'sasaran_peserta'   => $this->sasaran_peserta,
                'standar_kompetensi'=> $this->standar_kompetensi,
                'jenis_sertifikasi' => $this->jenis_sertifikasi,
                'banner_url'        => $pathBanner,
                'status_aktif'      => $this->status_aktif,
            ]);
            session()->flash('pesan', 'Program pelatihan baru berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapusProgram(string $id): void
    {
        $prog = SdiProgram::findOrFail($id);
        $nama = $prog->judul_program;
        app(StorageService::class)->hapusFile($prog->banner_url);
        $prog->delete();
        session()->flash('pesan', 'Program "' . Str::limit($nama, 35) . '" berhasil dihapus.');
    }

    // ==========================================
    // JADWAL PELATIHAN ACTIONS
    // ==========================================
    public function bukaFormJadwalTambah(): void
    {
        $this->resetJadwalInput();
        $firstProg = SdiProgram::first();
        if ($firstProg) {
            $this->program_id = $firstProg->id;
        }
        $this->tanggal_mulai = now()->format('Y-m-d');
        $this->tanggal_selesai = now()->addDays(2)->format('Y-m-d');
        $this->lokasi_pelatihan = 'Gedung Ormas KORMI Kab. Bandung';
        $this->mode = 'form_jadwal';
        $this->tampilkanModalJadwal = true;
    }

    public function bukaModalJadwalTambah(): void
    {
        $this->bukaFormJadwalTambah();
    }

    public function bukaFormJadwalEdit(string $id): void
    {
        $jadwal = SdiJadwal::findOrFail($id);
        $this->editJadwalId = $jadwal->id;
        $this->program_id = $jadwal->program_id;
        $this->nama_angkatan = $jadwal->nama_angkatan;
        $this->tanggal_mulai = $jadwal->tanggal_mulai;
        $this->tanggal_selesai = $jadwal->tanggal_selesai;
        $this->lokasi_pelatihan = $jadwal->lokasi_pelatihan;
        $this->kuota_peserta = (int) $jadwal->kuota_peserta;
        $this->status_pendaftaran = $jadwal->status_pendaftaran;
        $this->mode = 'form_jadwal';
        $this->tampilkanModalJadwal = true;
    }

    public function bukaModalJadwalEdit(string $id): void
    {
        $this->bukaFormJadwalEdit($id);
    }

    public function simpanJadwal(): void
    {
        $this->validate([
            'program_id' => 'required|exists:kormi_sdi_program,id',
            'nama_angkatan' => 'required|min:3|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi_pelatihan' => 'required|min:3|max:255',
            'kuota_peserta' => 'required|integer|min:1',
            'status_pendaftaran' => 'required|in:dibuka,berlangsung,selesai,penuh',
        ]);

        if ($this->editJadwalId) {
            $jadwal = SdiJadwal::findOrFail($this->editJadwalId);
            $jadwal->update([
                'program_id' => $this->program_id,
                'nama_angkatan' => $this->nama_angkatan,
                'tanggal_mulai' => $this->tanggal_mulai,
                'tanggal_selesai' => $this->tanggal_selesai,
                'lokasi_pelatihan' => $this->lokasi_pelatihan,
                'kuota_peserta' => $this->kuota_peserta,
                'status_pendaftaran' => $this->status_pendaftaran,
            ]);
            session()->flash('pesan', 'Jadwal angkatan pelatihan berhasil diperbarui!');
        } else {
            SdiJadwal::create([
                'id' => (string) Str::uuid(),
                'program_id' => $this->program_id,
                'nama_angkatan' => $this->nama_angkatan,
                'tanggal_mulai' => $this->tanggal_mulai,
                'tanggal_selesai' => $this->tanggal_selesai,
                'lokasi_pelatihan' => $this->lokasi_pelatihan,
                'kuota_peserta' => $this->kuota_peserta,
                'jumlah_pendaftar' => 0,
                'status_pendaftaran' => $this->status_pendaftaran,
            ]);
            session()->flash('pesan', 'Jadwal angkatan baru berhasil dibuka!');
        }

        $this->kembaliKeTabel();
    }

    public function hapusJadwal(string $id): void
    {
        $jadwal = SdiJadwal::findOrFail($id);
        $nama = $jadwal->nama_angkatan;
        $jadwal->delete();
        session()->flash('pesan', 'Jadwal "' . $nama . '" berhasil dihapus.');
    }

    private function resetProgramInput(): void
    {
        $this->editProgramId      = null;
        $this->judul_program      = '';
        $this->sasaran_peserta    = '';
        $this->standar_kompetensi = '';
        $this->jenis_sertifikasi  = 'Nasional KORMI';
        $this->banner_url         = '';
        $this->uploadBanner       = null;
        $this->status_aktif       = true;
    }

    private function resetJadwalInput(): void
    {
        $this->editJadwalId = null;
        $this->program_id = '';
        $this->nama_angkatan = '';
        $this->tanggal_mulai = '';
        $this->tanggal_selesai = '';
        $this->lokasi_pelatihan = '';
        $this->kuota_peserta = 30;
        $this->status_pendaftaran = 'dibuka';
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage('programPage');
        $this->resetPage('jadwalPage');
    }

    public function updatedPilihSemuaProgram(bool $value): void
    {
        if ($value) {
            $this->selectedProgram = SdiProgram::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedProgram = [];
        }
    }

    public function updatedPilihSemuaJadwal(bool $value): void
    {
        if ($value) {
            $this->selectedJadwal = SdiJadwal::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedJadwal = [];
        }
    }

    public function resetSelectionProgram(): void
    {
        $this->selectedProgram = [];
        $this->pilihSemuaProgram = false;
    }

    public function resetSelectionJadwal(): void
    {
        $this->selectedJadwal = [];
        $this->pilihSemuaJadwal = false;
    }

    public function bulkSetStatusProgram(bool $status): void
    {
        if (empty($this->selectedProgram)) return;
        SdiProgram::whereIn('id', $this->selectedProgram)->update(['status_aktif' => $status]);
        $statusText = $status ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('pesan', count($this->selectedProgram) . ' program pelatihan berhasil ' . $statusText . '.');
        $this->resetSelectionProgram();
    }

    public function bulkDeleteProgram(): void
    {
        if (empty($this->selectedProgram)) return;
        $progs = SdiProgram::whereIn('id', $this->selectedProgram)->get();
        $storage = app(StorageService::class);
        foreach ($progs as $p) {
            $storage->hapusFile($p->banner_url);
            $p->delete();
        }
        session()->flash('pesan', count($this->selectedProgram) . ' program pelatihan berhasil dihapus.');
        $this->resetSelectionProgram();
    }

    public function bulkSetStatusJadwal(string $status): void
    {
        if (empty($this->selectedJadwal)) return;
        SdiJadwal::whereIn('id', $this->selectedJadwal)->update(['status_pendaftaran' => $status]);
        session()->flash('pesan', count($this->selectedJadwal) . ' jadwal angkatan berhasil diubah status menjadi ' . $status . '.');
        $this->resetSelectionJadwal();
    }

    public function bulkDeleteJadwal(): void
    {
        if (empty($this->selectedJadwal)) return;
        SdiJadwal::whereIn('id', $this->selectedJadwal)->delete();
        session()->flash('pesan', count($this->selectedJadwal) . ' jadwal angkatan berhasil dihapus.');
        $this->resetSelectionJadwal();
    }

    public function setFilterJenisSertifikasi(string $jenis): void
    {
        $this->jenisSertifikasiFilter = $jenis;
        $this->resetPage('programPage');
    }

    public function setFilterStatusPendaftaran(string $status): void
    {
        $this->statusPendaftaranFilter = $status;
        $this->resetPage('jadwalPage');
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->jenisSertifikasiFilter = 'Semua';
        $this->statusPendaftaranFilter = 'Semua';
        $this->resetPage('programPage');
        $this->resetPage('jadwalPage');
    }

    public function render()
    {
        $semuaProgram = SdiProgram::orderBy('judul_program')->get();

        $queryProgram = SdiProgram::withCount('jadwal')
            ->when($this->cari, function ($q) {
                $q->where('judul_program', 'like', '%' . $this->cari . '%')
                  ->orWhere('sasaran_peserta', 'like', '%' . $this->cari . '%');
            })
            ->when($this->jenisSertifikasiFilter !== 'Semua', function ($q) {
                $q->where('jenis_sertifikasi', $this->jenisSertifikasiFilter);
            });

        if (in_array($this->sortField, ['judul_program', 'jenis_sertifikasi', 'status_aktif', 'dibuat_pada', 'created_at'])) {
            $queryProgram->orderBy($this->sortField, $this->sortDirection);
        } else {
            $queryProgram->orderByDesc('dibuat_pada');
        }

        $queryJadwal = SdiJadwal::with('program')
            ->when($this->cari, function ($q) {
                $q->where('nama_angkatan', 'like', '%' . $this->cari . '%')
                  ->orWhere('lokasi_pelatihan', 'like', '%' . $this->cari . '%');
            })
            ->when($this->statusPendaftaranFilter !== 'Semua', function ($q) {
                $q->where('status_pendaftaran', $this->statusPendaftaranFilter);
            });

        if (in_array($this->sortField, ['nama_angkatan', 'tanggal_mulai', 'status_pendaftaran', 'kuota_peserta', 'jumlah_pendaftar'])) {
            $queryJadwal->orderBy($this->sortField, $this->sortDirection);
        } else {
            $queryJadwal->orderByDesc('tanggal_mulai');
        }

        return view('livewire.backend.kormi.sdi.sdi-kelola', [
            'daftarProgram' => $queryProgram->paginate($this->perPage, ['*'], 'programPage'),
            'daftarJadwal' => $queryJadwal->paginate($this->perPage, ['*'], 'jadwalPage'),
            'semuaProgram' => $semuaProgram,
            'totalProgram' => SdiProgram::count(),
            'totalProgramAktif' => SdiProgram::where('status_aktif', true)->count(),
            'totalJadwal' => SdiJadwal::count(),
            'totalJadwalDibuka' => SdiJadwal::where('status_pendaftaran', 'dibuka')->count(),
            'totalPendaftar' => SdiJadwal::sum('jumlah_pendaftar'),
        ]);
    }
}
