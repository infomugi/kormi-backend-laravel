<?php

namespace App\Livewire\Backend\Pengguna;

use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Services\StorageService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Pengguna - KORMI CMS')]
class PenggunaKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel'; // 'tabel' atau 'form'
    public string $cari = '';
    public string $peranDipilih = 'Semua';
    public string $statusDipilih = 'Semua';

    // Sorting & Pagination
    public string $sortField = 'dibuat_pada';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'

    // Bulk Selection State
    public array $selectedUsers = [];
    public bool $selectAll = false;
    public bool $tampilkanModalBulkReset = false;
    public string $bulkPasswordBaru = '';

    // Form state
    public bool $tampilkanModal = false;
    public bool $tampilkanModalReset = false;
    public ?string $penggunaId = null;
    public string $nama_lengkap = '';
    public string $email = '';
    public string $nomor_telepon = '';
    public string $peran_id = '';
    public string $kata_sandi = '';
    public string $foto_profil = '';   // path MinIO
    public $uploadFotoProfil = null;   // file upload sementara
    public bool $status_aktif = true;
    public bool $showPassword = false;

    // Reset password modal state
    public ?string $resetUserId = null;
    public string $resetUserName = '';
    public string $resetPasswordBaru = '';

    protected function rules(): array
    {
        $rules = [
            'nama_lengkap' => 'required|min:3|max:100',
            'email' => 'required|email|unique:sys_pengguna,email,' . ($this->penggunaId ?? 'NULL') . ',id,dihapus_pada,NULL',
            'nomor_telepon' => 'nullable|min:8|max:20',
            'peran_id' => 'required|exists:sys_peran,id',
            'status_aktif' => 'boolean',
            'uploadFotoProfil' => 'nullable|image|max:5120',
        ];

        if (!$this->penggunaId) {
            $rules['kata_sandi'] = 'required|min:6';
        } else {
            $rules['kata_sandi'] = 'nullable|min:6';
        }

        return $rules;
    }

    protected $messages = [
        'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format alamat email tidak valid.',
        'email.unique' => 'Alamat email sudah digunakan oleh akun lain.',
        'peran_id.required' => 'Peran pengguna wajib dipilih.',
        'peran_id.exists' => 'Peran yang dipilih tidak valid.',
        'kata_sandi.required' => 'Kata sandi wajib diisi untuk pengguna baru.',
        'kata_sandi.min' => 'Kata sandi minimal berisi :min karakter.',
        'nomor_telepon.min' => 'Nomor telepon minimal 8 digit.',
    ];

    public function updatedCari(): void
    {
        $this->resetPage();
        $this->selectedUsers = [];
        $this->selectAll = false;
    }

    public function updatedPeranDipilih(): void
    {
        $this->resetPage();
        $this->selectedUsers = [];
        $this->selectAll = false;
    }

    public function updatedStatusDipilih(): void
    {
        $this->resetPage();
        $this->selectedUsers = [];
        $this->selectAll = false;
    }

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

    public function setFilterStatus(string $status): void
    {
        $this->statusDipilih = $status;
        $this->resetPage();
    }

    public function setFilterPeran(string $peran): void
    {
        $this->peranDipilih = $peran;
        $this->resetPage();
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->peranDipilih = 'Semua';
        $this->statusDipilih = 'Semua';
        $this->resetPage();
    }

    protected function getFilteredQuery()
    {
        $query = Pengguna::with('peran')
            ->when($this->peranDipilih !== 'Semua', fn($q) => $q->where('peran_id', $this->peranDipilih))
            ->when($this->statusDipilih !== 'Semua', function ($q) {
                if ($this->statusDipilih === 'Aktif') {
                    $q->where('status_aktif', true);
                } elseif ($this->statusDipilih === 'Pending') {
                    $q->where('status_aktif', false)->whereNull('disetujui_pada');
                } elseif ($this->statusDipilih === 'Non-Aktif') {
                    $q->where('status_aktif', false);
                }
            })
            ->when($this->cari, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nama_lengkap', 'like', '%' . $this->cari . '%')
                        ->orWhere('email', 'like', '%' . $this->cari . '%')
                        ->orWhere('nomor_telepon', 'like', '%' . $this->cari . '%');
                });
            });

        if (in_array($this->sortField, ['nama_lengkap', 'email', 'status_aktif', 'dibuat_pada', 'created_at', 'terakhir_login_pada'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->orderByDesc('dibuat_pada');
        }

        return $query;
    }

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $currentPageItems = $this->getFilteredQuery()->paginate($this->perPage)->items();
            $this->selectedUsers = array_map(fn($item) => (string) $item->id, $currentPageItems);
        } else {
            $this->selectedUsers = [];
        }
    }

    public function updatedSelectedUsers(): void
    {
        $currentPageIds = array_map(fn($item) => (string) $item->id, $this->getFilteredQuery()->paginate($this->perPage)->items());
        if (!empty($currentPageIds) && count(array_intersect($currentPageIds, $this->selectedUsers)) === count($currentPageIds)) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }
    }

    public function toggleShowPassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    public function bukaFormTambah(): void
    {
        $this->reset(['penggunaId', 'nama_lengkap', 'email', 'nomor_telepon', 'kata_sandi', 'foto_profil', 'uploadFotoProfil', 'showPassword']);
        $this->status_aktif = true;
        $this->foto_profil = '';
        $firstRole = Peran::first();
        $this->peran_id = $firstRole ? $firstRole->id : '';
        $this->mode = 'form';
        $this->tampilkanModal = true;
        $this->resetErrorBag();
    }

    public function bukaFormEdit(string $id): void
    {
        $user = Pengguna::findOrFail($id);
        $this->penggunaId = $user->id;
        $this->nama_lengkap = $user->nama_lengkap;
        $this->email = $user->email;
        $this->nomor_telepon = $user->nomor_telepon ?? '';
        $this->peran_id = $user->peran_id ?? '';
        $this->kata_sandi = '';
        $this->foto_profil = $user->foto_profil ?? '';
        $this->uploadFotoProfil = null;
        $this->showPassword = false;
        $this->status_aktif = (bool) $user->status_aktif;
        $this->mode = 'form';
        $this->tampilkanModal = true;
        $this->resetErrorBag();
    }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->tampilkanModal = false;
        $this->tampilkanModalReset = false;
        $this->reset(['penggunaId', 'nama_lengkap', 'email', 'nomor_telepon', 'kata_sandi', 'foto_profil', 'uploadFotoProfil', 'showPassword', 'resetUserId', 'resetPasswordBaru']);
        $this->resetErrorBag();
    }

    public function simpan(): void
    {
        $this->validate();

        // Pastikan peran_id selalu terisi (NOT NULL di DB)
        $peranId = $this->peran_id;
        if (empty($peranId)) {
            $defaultPeran = Peran::first();
            $peranId = $defaultPeran?->id;
        }

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        // Upload foto profil baru jika ada
        $pathFoto = $this->foto_profil ?: null;
        if ($this->uploadFotoProfil) {
            if ($this->penggunaId && !empty($this->foto_profil)) {
                $storage->hapusFile($this->foto_profil);
            }
            $pathFoto = $storage->uploadGambar($this->uploadFotoProfil, 'pengguna/profil');
        }

        $data = [
            'nama_lengkap'  => trim($this->nama_lengkap),
            'email'         => strtolower(trim($this->email)),
            'nomor_telepon' => trim($this->nomor_telepon),
            'peran_id'      => $peranId,
            'foto_profil'   => $pathFoto,
            'status_aktif'  => $this->status_aktif,
        ];

        if (!empty($this->kata_sandi)) {
            $data['kata_sandi'] = Hash::make($this->kata_sandi);
        }

        if ($this->penggunaId) {
            $user = Pengguna::findOrFail($this->penggunaId);
            $user->update($data);
            session()->flash('pesan', 'Data pengguna "' . $this->nama_lengkap . '" berhasil diperbarui!');
        } else {
            $data['id']         = (string) Str::uuid();
            $data['dibuat_pada']= now();
            Pengguna::create($data);
            session()->flash('pesan', 'Pengguna baru "' . $this->nama_lengkap . '" berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function toggleStatus(string $id): void
    {
        $user = Pengguna::findOrFail($id);
        
        // Prevent disabling current logged-in user
        if (auth()->id() === $user->id) {
            session()->flash('error', 'Anda tidak dapat menonaktifkan akun yang sedang digunakan saat ini.');
            return;
        }

        $user->status_aktif = !$user->status_aktif;
        $user->save();
        session()->flash('pesan', 'Status akun ' . $user->nama_lengkap . ' berhasil diubah!');
    }

    public function bukaModalResetPassword(string $id): void
    {
        $user = Pengguna::findOrFail($id);
        $this->resetUserId = $user->id;
        $this->resetUserName = $user->nama_lengkap;
        $this->resetPasswordBaru = 'kormi' . rand(1000, 9999);
        $this->tampilkanModalReset = true;
    }

    public function simpanResetPassword(): void
    {
        if (!$this->resetUserId || empty($this->resetPasswordBaru)) {
            return;
        }

        $user = Pengguna::findOrFail($this->resetUserId);
        $user->forceFill([
            'kata_sandi' => Hash::make($this->resetPasswordBaru),
        ])->save();

        session()->flash('pesan', 'Kata sandi untuk ' . $user->nama_lengkap . ' berhasil direset menjadi: ' . $this->resetPasswordBaru);
        $this->tampilkanModalReset = false;
        $this->reset(['resetUserId', 'resetUserName', 'resetPasswordBaru']);
    }

    public function bulkDisableLogin(mixed $ids = []): void
    {
        $target = is_array($ids) && !empty($ids) ? $ids : $this->selectedUsers;
        if (empty($target)) {
            return;
        }

        $authId = auth()->id();
        $targetIds = array_values(array_filter((array) $target, fn($id) => (string)$id !== (string)$authId));

        if (empty($targetIds)) {
            session()->flash('error', 'Anda tidak dapat menonaktifkan akun yang sedang login.');
            return;
        }

        $count = Pengguna::whereIn('id', $targetIds)->update(['status_aktif' => false]);
        session()->flash('pesan', $count . ' akun pengguna berhasil dinonaktifkan (akses login ditutup)!');
        $this->selectedUsers = [];
    }

    public function bulkEnableLogin(mixed $ids = []): void
    {
        $target = is_array($ids) && !empty($ids) ? $ids : $this->selectedUsers;
        if (empty($target)) {
            return;
        }

        $count = Pengguna::whereIn('id', (array) $target)->update(['status_aktif' => true]);
        session()->flash('pesan', $count . ' akun pengguna berhasil diaktifkan kembali!');
        $this->selectedUsers = [];
    }

    public function bulkHapus(mixed $ids = []): void
    {
        $target = is_array($ids) && !empty($ids) ? $ids : $this->selectedUsers;
        if (empty($target)) {
            return;
        }

        $authId = auth()->id();
        $targetIds = array_values(array_filter((array) $target, fn($id) => (string)$id !== (string)$authId));

        if (empty($targetIds)) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        $count = Pengguna::whereIn('id', $targetIds)->delete();
        session()->flash('pesan', $count . ' akun pengguna berhasil dihapus secara massal!');
        $this->selectedUsers = [];
        $this->resetPage();
    }

    public function bukaModalBulkResetPassword(mixed $ids = []): void
    {
        if (is_array($ids) && !empty($ids)) {
            $this->selectedUsers = array_values($ids);
        }

        if (empty($this->selectedUsers)) {
            return;
        }

        $this->bulkPasswordBaru = 'kormi' . rand(1000, 9999);
        $this->tampilkanModalBulkReset = true;
    }

    public function simpanBulkResetPassword(): void
    {
        if (empty($this->selectedUsers) || empty($this->bulkPasswordBaru)) {
            return;
        }

        if (strlen($this->bulkPasswordBaru) < 6) {
            $this->addError('bulkPasswordBaru', 'Kata sandi minimal 6 karakter.');
            return;
        }

        $count = count($this->selectedUsers);
        Pengguna::whereIn('id', $this->selectedUsers)->update([
            'kata_sandi' => Hash::make($this->bulkPasswordBaru),
        ]);

        session()->flash('pesan', 'Kata sandi untuk ' . $count . ' akun pengguna berhasil direset menjadi: ' . $this->bulkPasswordBaru);
        $this->tampilkanModalBulkReset = false;
        $this->selectedUsers = [];
    }

    public function setujuiAkun(string $id): void
    {
        $user = Pengguna::findOrFail($id);
        $user->update([
            'status_aktif' => true,
            'disetujui_pada' => now(),
            'disetujui_oleh' => auth()->id(),
        ]);

        session()->flash('pesan', 'Akun "' . $user->nama_lengkap . '" berhasil disetujui dan diaktifkan!');
    }

    public function bulkSetujuiAkun(mixed $ids = []): void
    {
        $target = is_array($ids) && !empty($ids) ? $ids : $this->selectedUsers;
        if (empty($target)) {
            return;
        }

        $count = Pengguna::whereIn('id', (array) $target)->update([
            'status_aktif' => true,
            'disetujui_pada' => now(),
            'disetujui_oleh' => auth()->id(),
        ]);

        session()->flash('pesan', $count . ' akun pengguna berhasil disetujui dan diaktifkan secara massal!');
        $this->selectedUsers = [];
    }

    public function hapus(string $id): void
    {
        $user = Pengguna::findOrFail($id);

        // Prevent self deletion
        if (auth()->id() === $user->id) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        $nama = $user->nama_lengkap;
        $user->delete();
        session()->flash('pesan', 'Pengguna "' . $nama . '" berhasil dihapus!');
    }

    public function render()
    {
        $peranList = Peran::orderBy('nama_peran')->get();

        return view('livewire.backend.pengguna.pengguna-kelola', [
            'peranList' => $peranList,
            'penggunaList' => $this->getFilteredQuery()->paginate($this->perPage),
            'totalPengguna' => Pengguna::count(),
            'totalAktif' => Pengguna::where('status_aktif', true)->count(),
            'totalPending' => Pengguna::where('status_aktif', false)->whereNull('disetujui_pada')->count(),
            'totalNonAktif' => Pengguna::where('status_aktif', false)->count(),
            'totalAdmin' => Pengguna::whereNotNull('peran_id')->count(),
        ]);
    }
}
