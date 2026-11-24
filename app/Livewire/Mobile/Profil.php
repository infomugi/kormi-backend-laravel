<?php

namespace App\Livewire\Mobile;

use App\Services\StorageService;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.mobile')]
#[Title('Profil - KORMI Kabupaten Bandung')]
class Profil extends Component
{
    use WithFileUploads;

    public string $nama_lengkap = '';
    public string $nomor_telepon = '';
    public $foto_profil_baru = null;

    public string $kata_sandi_lama = '';
    public string $kata_sandi_baru = '';
    public string $konfirmasi_kata_sandi = '';

    protected $messages = [
        'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
        'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter.',
        'nomor_telepon.min' => 'Nomor telepon minimal 8 karakter.',
        'nomor_telepon.max' => 'Nomor telepon maksimal 20 karakter.',
        'foto_profil_baru.image' => 'Berkas foto harus berupa gambar.',
        'foto_profil_baru.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
        'foto_profil_baru.max' => 'Ukuran foto maksimal 5 MB.',
        'kata_sandi_lama.required' => 'Kata sandi saat ini wajib diisi.',
        'kata_sandi_baru.required' => 'Kata sandi baru wajib diisi.',
        'kata_sandi_baru.min' => 'Kata sandi baru minimal 8 karakter.',
        'kata_sandi_baru.max' => 'Kata sandi baru maksimal 72 karakter.',
        'konfirmasi_kata_sandi.required' => 'Konfirmasi kata sandi baru wajib diisi.',
        'konfirmasi_kata_sandi.same' => 'Konfirmasi kata sandi tidak sama dengan kata sandi baru.',
    ];

    public function mount(): void
    {
        $user = auth()->user();
        $this->nama_lengkap = $user->nama_lengkap;
        $this->nomor_telepon = (string) $user->nomor_telepon;
    }

    public function simpanDataAkun(): void
    {
        $this->resetValidation();

        $this->validate([
            'nama_lengkap' => 'required|min:3|max:100',
            'nomor_telepon' => 'nullable|min:8|max:20',
            'foto_profil_baru' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $user = auth()->user();

        $data = [
            'nama_lengkap' => strip_tags(trim($this->nama_lengkap)),
            'nomor_telepon' => trim(strip_tags($this->nomor_telepon)) ?: null,
        ];

        if ($this->foto_profil_baru) {
            $storage = app(StorageService::class);

            try {
                $path = $storage->uploadGambar($this->foto_profil_baru, 'pengguna/profil');
            } catch (\InvalidArgumentException $e) {
                $this->addError('foto_profil_baru', $e->getMessage());

                return;
            }

            if ($user->foto_profil && $user->foto_profil !== $path) {
                $storage->hapusFile($user->foto_profil);
            }

            $data['foto_profil'] = $path;
        }

        $user->update($data);

        $this->nama_lengkap = $user->nama_lengkap;
        $this->nomor_telepon = (string) $user->nomor_telepon;
        $this->foto_profil_baru = null;

        session()->flash('pesan_akun', 'Data akun berhasil diperbarui.');
    }

    public function gantiKataSandi(): void
    {
        $this->resetValidation();

        $this->validate([
            'kata_sandi_lama' => 'required|string',
            'kata_sandi_baru' => 'required|string|min:8|max:72',
            'konfirmasi_kata_sandi' => 'required|same:kata_sandi_baru',
        ]);

        $user = auth()->user();

        if (! Hash::check($this->kata_sandi_lama, $user->kata_sandi)) {
            $this->addError('kata_sandi_lama', 'Kata sandi saat ini tidak sesuai.');

            return;
        }

        if (Hash::check($this->kata_sandi_baru, $user->kata_sandi)) {
            $this->addError('kata_sandi_baru', 'Kata sandi baru harus berbeda dari kata sandi saat ini.');

            return;
        }

        $user->update(['kata_sandi' => Hash::make($this->kata_sandi_baru)]);

        $this->reset(['kata_sandi_lama', 'kata_sandi_baru', 'konfirmasi_kata_sandi']);

        session()->flash('pesan_sandi', 'Kata sandi berhasil diperbarui.');
    }

    public function render()
    {
        $user = auth()->user()->loadMissing(['peran', 'kecamatan', 'desa', 'duta']);

        $badgePeran = match (true) {
            $user->isSuperAdmin() => 'Super Admin',
            $user->isAdminKorcam() => 'Korcam',
            $user->isAdminInorga() => 'Inorga',
            $user->isEditorBerita() => 'Editor',
            $user->isDutaOlahraga() => 'Duta',
            default => 'Pegiat',
        };

        return view('livewire.mobile.profil', [
            'user' => $user,
            'roleLabel' => $user->peran?->nama_peran ?? 'Pengguna',
            'badgePeran' => $badgePeran,
            'isAdmin' => $user->isSuperAdmin() || $user->isAdminKorcam() || $user->isAdminInorga() || $user->isEditorBerita(),
        ]);
    }
}
