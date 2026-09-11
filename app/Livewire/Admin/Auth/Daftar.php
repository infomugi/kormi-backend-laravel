<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Pengguna;
use App\Models\Peran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.guest')]
#[Title('Daftar Akun CMS - KORMI Kabupaten Bandung')]
class Daftar extends Component
{
    public string $nama_lengkap = '';
    public string $email = '';
    public string $nomor_telepon = '';
    public string $kata_sandi = '';
    public string $konfirmasi_kata_sandi = '';
    public bool $showPassword = false;
    public bool $setuju_syarat = false;

    protected $rules = [
        'nama_lengkap' => 'required|min:3|max:100',
        'email' => 'required|email|unique:kormi_pengguna,email',
        'nomor_telepon' => 'nullable|min:9|max:15',
        'kata_sandi' => 'required|min:6|same:konfirmasi_kata_sandi',
        'konfirmasi_kata_sandi' => 'required',
        'setuju_syarat' => 'accepted',
    ];

    protected $messages = [
        'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format alamat email tidak valid.',
        'email.unique' => 'Alamat email sudah terdaftar. Silakan masuk atau gunakan email lain.',
        'nomor_telepon.min' => 'Nomor telepon/WhatsApp minimal 9 digit.',
        'kata_sandi.required' => 'Kata sandi wajib diisi.',
        'kata_sandi.min' => 'Kata sandi minimal berisi :min karakter.',
        'kata_sandi.same' => 'Konfirmasi kata sandi tidak cocok.',
        'konfirmasi_kata_sandi.required' => 'Konfirmasi kata sandi wajib diisi.',
        'setuju_syarat.accepted' => 'Anda harus menyetujui syarat & ketentuan penggunaan CMS KORMI.',
    ];

    public function toggleShowPassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function daftar()
    {
        $this->resetErrorBag();
        $this->validate();

        try {
            // Find default role or first role
            $peran = Peran::where('slug', 'super-admin')->first() ?? Peran::first();

            $pengguna = Pengguna::create([
                'id' => (string) Str::uuid(),
                'peran_id' => $peran ? $peran->id : null,
                'nama_lengkap' => trim($this->nama_lengkap),
                'email' => strtolower(trim($this->email)),
                'nomor_telepon' => trim($this->nomor_telepon),
                'kata_sandi' => Hash::make($this->kata_sandi),
                'status_aktif' => false,
                'terakhir_masuk' => null,
            ]);

            session()->flash('status', 'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan (approval) dari Administrator KORMI sebelum dapat digunakan untuk masuk.');
            return $this->redirect(route('login'), navigate: false);
        } catch (\Throwable $e) {
            $this->addError('email', 'Gagal mendaftarkan akun baru: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.auth.daftar');
    }
}
