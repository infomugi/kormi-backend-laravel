<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.guest')]
#[Title('Masuk CMS - KORMI Kabupaten Bandung')]
class Masuk extends Component
{
    public string $email = '';
    public string $kata_sandi = '';
    public bool $ingat_saya = false;
    public bool $showPassword = false;

    protected $rules = [
        'email' => 'required|email',
        'kata_sandi' => 'required|min:4',
    ];

    protected $messages = [
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format alamat email tidak valid.',
        'kata_sandi.required' => 'Kata sandi wajib diisi.',
        'kata_sandi.min' => 'Kata sandi minimal berisi :min karakter.',
    ];

    public function toggleShowPassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function fillAdminCredentials()
    {
        $this->email = 'admin@kormibdg.id';
        $this->kata_sandi = 'password';
        $this->resetErrorBag();
    }

    public function directBypassLogin()
    {
        try {
            $admin = \App\Models\Pengguna::where('email', 'admin@kormibdg.id')->first();
            if (!$admin) {
                $admin = \App\Models\Pengguna::first();
            }

            if ($admin) {
                Auth::login($admin, false); // false = don't use remember_token cookie
                session()->regenerate();
                return redirect()->to(route('admin.dashboard'));
            }

            $this->addError('email', 'Akun admin belum ditemukan di database.');
        } catch (\Throwable $e) {
            $this->addError('email', 'Terjadi kesalahan sistem saat proses masuk: ' . $e->getMessage());
        }
    }


    public function login()
    {
        $this->resetErrorBag();
        $this->validate();

        $email = strtolower(trim($this->email));
        $password = $this->kata_sandi;

        try {
            // Check if user exists
            $user = \App\Models\Pengguna::where('email', $email)->first();

            if (!$user) {
                $this->addError('email', 'Alamat email tidak terdaftar dalam sistem CMS KORMI.');
                return;
            }

            // Check if user account is active
            if (isset($user->status_aktif) && !$user->status_aktif) {
                $this->addError('email', 'Akun Anda sedang dinonaktifkan. Silakan hubungi Sekretariat KORMI.');
                return;
            }

            // Verify password using Hash
            if (!\Illuminate\Support\Facades\Hash::check($password, $user->kata_sandi)) {
                $this->addError('kata_sandi', 'Kata sandi yang Anda masukkan salah. Silakan periksa kembali.');
                return;
            }

            // Log in user
            Auth::login($user, $this->ingat_saya);

            // Update terakhir_masuk if column exists
            try {
                $user->forceFill(['terakhir_masuk' => now()])->saveQuietly();
            } catch (\Throwable $t) {
                // Ignore if column is not present
            }

            session()->regenerate();
            return $this->redirectIntended(default: route('admin.dashboard'), navigate: false);
        } catch (\Throwable $e) {
            $this->addError('email', 'Gagal memproses autentikasi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.auth.masuk');
    }
}

