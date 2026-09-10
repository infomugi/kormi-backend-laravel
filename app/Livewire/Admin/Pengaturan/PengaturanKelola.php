<?php

namespace App\Livewire\Admin\Pengaturan;

use App\Models\PengaturanSitus;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\StorageService;

#[Layout('components.layouts.admin')]
#[Title('Pengaturan Situs - KORMI CMS')]
class PengaturanKelola extends Component
{
    use WithFileUploads;

    // Umum
    public string $nama_situs = '';
    public string $deskripsi_situs = '';
    public string $email_kontak = '';
    public string $nomor_telepon = '';
    public string $alamat_kantor = '';

    // Media Sosial
    public string $instagram = '';
    public string $facebook = '';
    public string $youtube = '';
    public string $tiktok = '';
    public string $website_kormi_pusat = '';

    // Logo & Branding
    public string $logo_path = '';
    public $uploadLogo = null;

    protected function rules(): array
    {
        return [
            'nama_situs' => 'required|string|max:200',
            'deskripsi_situs' => 'nullable|string|max:1000',
            'email_kontak' => 'nullable|email|max:100',
            'nomor_telepon' => 'nullable|string|max:25',
            'alamat_kantor' => 'nullable|string|max:500',
            'instagram' => 'nullable|string|max:200',
            'facebook' => 'nullable|string|max:200',
            'youtube' => 'nullable|string|max:200',
            'tiktok' => 'nullable|string|max:200',
            'website_kormi_pusat' => 'nullable|string|max:200',
            'uploadLogo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120',
        ];
    }

    public function mount(): void
    {
        $this->nama_situs = PengaturanSitus::ambil('nama_situs', 'KORMI Kabupaten Bandung');
        $this->deskripsi_situs = PengaturanSitus::ambil('deskripsi_situs', '');
        $this->email_kontak = PengaturanSitus::ambil('email_kontak', '');
        $this->nomor_telepon = PengaturanSitus::ambil('nomor_telepon', '');
        $this->alamat_kantor = PengaturanSitus::ambil('alamat_kantor', '');
        $this->instagram = PengaturanSitus::ambil('instagram', '');
        $this->facebook = PengaturanSitus::ambil('facebook', '');
        $this->youtube = PengaturanSitus::ambil('youtube', '');
        $this->tiktok = PengaturanSitus::ambil('tiktok', '');
        $this->website_kormi_pusat = PengaturanSitus::ambil('website_kormi_pusat', '');
        $this->logo_path = PengaturanSitus::ambil('logo_path', '');
    }

    public function simpan(): void
    {
        $this->validate();

        if ($this->uploadLogo) {
            $storage = app(StorageService::class);
            if (!empty($this->logo_path)) {
                $storage->hapusFile($this->logo_path);
            }
            $this->logo_path = $storage->uploadGambar($this->uploadLogo, 'pengaturan');
            $this->uploadLogo = null;
        }

        $pengaturan = [
            'nama_situs' => ['nilai' => $this->nama_situs, 'kelompok' => 'umum'],
            'deskripsi_situs' => ['nilai' => $this->deskripsi_situs, 'kelompok' => 'umum'],
            'email_kontak' => ['nilai' => $this->email_kontak, 'kelompok' => 'kontak'],
            'nomor_telepon' => ['nilai' => $this->nomor_telepon, 'kelompok' => 'kontak'],
            'alamat_kantor' => ['nilai' => $this->alamat_kantor, 'kelompok' => 'kontak'],
            'instagram' => ['nilai' => $this->instagram, 'kelompok' => 'sosmed'],
            'facebook' => ['nilai' => $this->facebook, 'kelompok' => 'sosmed'],
            'youtube' => ['nilai' => $this->youtube, 'kelompok' => 'sosmed'],
            'tiktok' => ['nilai' => $this->tiktok, 'kelompok' => 'sosmed'],
            'website_kormi_pusat' => ['nilai' => $this->website_kormi_pusat, 'kelompok' => 'sosmed'],
            'logo_path' => ['nilai' => $this->logo_path, 'kelompok' => 'branding'],
        ];

        foreach ($pengaturan as $kunci => $data) {
            PengaturanSitus::simpan($kunci, $data['nilai'], $data['kelompok']);
        }

        session()->flash('pesan', 'Pengaturan situs berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.admin.pengaturan.pengaturan-kelola');
    }
}
