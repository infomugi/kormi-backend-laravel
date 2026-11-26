<?php

namespace App\Livewire\Mobile;

use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.mobile')]
#[Title('Kelola User - KORMI Kabupaten Bandung')]
class KelolaUser extends Component
{
    use WithPagination;

    public string $cari = '';
    public string $peranDipilih = 'Semua';
    public int $perPage = 12;

    public ?string $pesan = null;
    public ?string $galat = null;

    public function mount(): void
    {
        $this->pastikanSuperAdmin();

        // Tampilkan pesan hasil aksi sebelumnya (mis. kembali dari mode impersonasi).
        $this->pesan = session()->pull('pesan');
    }

    /**
     * Berjalan pada mount dan setiap request update/aksi Livewire.
     * Mencegah snapshot halaman tetap bisa di-update setelah sesi berganti peran.
     *
     * Catatan: Livewire memanggil hook ini lewat Component::__call sehingga
     * method harus public (protected akan dianggap tidak ada).
     */
    public function booted(): void
    {
        $this->pastikanSuperAdmin();
    }

    public function updatedCari(): void
    {
        $this->pesan = null;
        $this->resetPage();
    }

    public function updatedPeranDipilih(): void
    {
        $this->pesan = null;
        $this->resetPage();
    }

    public function impersonate(string $id): mixed
    {
        $this->pastikanSuperAdmin();
        $this->pesan = null;
        $this->galat = null;

        if (session()->has('impersonator_id')) {
            $this->galat = 'Selesaikan mode impersonasi terlebih dahulu sebelum masuk sebagai pengguna lain.';
            return null;
        }

        $currentUser = auth()->user();
        $targetUser = Pengguna::with('peran')->find($id);

        if (! $targetUser) {
            $this->galat = 'Pengguna tidak ditemukan.';
            return null;
        }

        if ($targetUser->id === $currentUser->id) {
            $this->galat = 'Anda saat ini sudah masuk sebagai akun ini.';
            return null;
        }

        if (! $targetUser->status_aktif) {
            $this->galat = 'Akun ' . $targetUser->nama_lengkap . ' sedang nonaktif. Aktifkan akun terlebih dahulu sebelum login.';
            return null;
        }

        $originalAdminId = $currentUser->id;
        $originalAdminName = $currentUser->nama_lengkap;

        Auth::login($targetUser);
        session()->regenerate();

        session()->put('impersonator_id', $originalAdminId);
        session()->put('impersonator_name', $originalAdminName);

        session()->flash('pesan', 'Mode impersonasi aktif: Anda sekarang masuk sebagai ' . $targetUser->nama_lengkap . ' (' . ($targetUser->peran?->nama_peran ?? 'Pengguna') . ').');

        return redirect()->route('mobile.dashboard');
    }

    public function render()
    {
        $kataKunci = trim($this->cari);

        $penggunaList = Pengguna::with('peran')
            ->when($this->peranDipilih !== 'Semua', fn ($q) => $q->where('peran_id', $this->peranDipilih))
            ->when($kataKunci !== '', function ($q) use ($kataKunci) {
                $q->where(function ($sub) use ($kataKunci) {
                    $sub->where('nama_lengkap', 'like', '%' . $kataKunci . '%')
                        ->orWhere('email', 'like', '%' . $kataKunci . '%');
                });
            })
            ->orderBy('nama_lengkap')
            ->paginate($this->perPage);

        return view('livewire.mobile.kelola-user', [
            'daftarPeran' => Peran::orderBy('nama_peran')->get(['id', 'nama_peran', 'slug']),
            'penggunaList' => $penggunaList,
        ]);
    }

    private function pastikanSuperAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403);
    }
}