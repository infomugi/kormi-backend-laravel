<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.guest')]
#[Title('Lupa Password CMS - KORMI Kabupaten Bandung')]
class LupaPassword extends Component
{
    public string $email = '';
    public string $kata_sandi_baru = '';
    public string $konfirmasi_kata_sandi = '';
    public bool $isEmailVerified = false;
    public bool $isSuccess = false;
    public bool $showPassword = false;

    protected $rules = [
        'email' => 'required|email',
    ];

    protected $messages = [
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format alamat email tidak valid.',
    ];

    public function toggleShowPassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function checkEmail()
    {
        $this->resetErrorBag();
        $this->validate();

        $email = strtolower(trim($this->email));
        $user = Pengguna::where('email', $email)->first();

        if (!$user) {
            $this->addError('email', 'Alamat email tidak terdaftar dalam sistem CMS KORMI.');
            return;
        }

        $this->isEmailVerified = true;
    }

    public function resetPassword()
    {
        $this->validate([
            'kata_sandi_baru' => 'required|min:6|same:konfirmasi_kata_sandi',
            'konfirmasi_kata_sandi' => 'required',
        ], [
            'kata_sandi_baru.required' => 'Kata sandi baru wajib diisi.',
            'kata_sandi_baru.min' => 'Kata sandi baru minimal berisi :min karakter.',
            'kata_sandi_baru.same' => 'Konfirmasi kata sandi tidak cocok.',
            'konfirmasi_kata_sandi.required' => 'Konfirmasi kata sandi wajib diisi.',
        ]);

        $email = strtolower(trim($this->email));
        $user = Pengguna::where('email', $email)->first();

        if (!$user) {
            $this->addError('email', 'Akun pengguna tidak ditemukan.');
            return;
        }

        $user->forceFill([
            'kata_sandi' => Hash::make($this->kata_sandi_baru),
        ])->save();

        $this->isSuccess = true;
        session()->flash('status', 'Kata sandi berhasil diperbarui! Silakan masuk dengan kata sandi baru Anda.');
    }

    public function resetState()
    {
        $this->isEmailVerified = false;
        $this->isSuccess = false;
        $this->kata_sandi_baru = '';
        $this->konfirmasi_kata_sandi = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.admin.auth.lupa-password');
    }
}
