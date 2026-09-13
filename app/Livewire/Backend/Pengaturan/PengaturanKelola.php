<?php

namespace App\Livewire\Backend\Pengaturan;

use App\Models\Core\PengaturanSitus;
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

    public string $tabAktif = 'umum';

    // Umum & Profil
    public string $nama_situs = '';
    public string $tagline_situs = '';
    public string $deskripsi_situs = '';
    public string $alamat_kantor = '';
    public string $gmaps_embed = '';

    // Kontak
    public string $email_kontak = '';
    public string $nomor_telepon = '';
    public string $nomor_whatsapp = '';
    public string $jam_operasional = '';

    // Media Sosial
    public string $instagram = '';
    public string $facebook = '';
    public string $youtube = '';
    public string $tiktok = '';
    public string $website_kormi_pusat = '';
    public string $website_kormi_jabar = '';

    // Logo & Branding
    public string $logo_path = '';
    public $uploadLogo = null;
    public string $favicon_path = '';
    public $uploadFavicon = null;

    protected function rules(): array
    {
        return [
            'nama_situs' => 'required|string|max:200',
            'tagline_situs' => 'nullable|string|max:255',
            'deskripsi_situs' => 'nullable|string|max:1000',
            'alamat_kantor' => 'nullable|string|max:500',
            'gmaps_embed' => 'nullable|string|max:2000',
            'email_kontak' => 'nullable|email|max:100',
            'nomor_telepon' => 'nullable|string|max:25',
            'nomor_whatsapp' => 'nullable|string|max:25',
            'jam_operasional' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:200',
            'facebook' => 'nullable|string|max:200',
            'youtube' => 'nullable|string|max:200',
            'tiktok' => 'nullable|string|max:200',
            'website_kormi_pusat' => 'nullable|string|max:200',
            'website_kormi_jabar' => 'nullable|string|max:200',
            'uploadLogo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'uploadFavicon' => 'nullable|image|mimes:jpg,jpeg,png,webp,ico|max:2048',
        ];
    }

    public function mount(): void
    {
        $this->nama_situs = PengaturanSitus::ambil('nama_situs', 'KORMI Kabupaten Bandung');
        $this->tagline_situs = PengaturanSitus::ambil('tagline_situs', 'Sehat, Bugar, Gembira, Luar Biasa!');
        $this->deskripsi_situs = PengaturanSitus::ambil('deskripsi_situs', '');
        $this->alamat_kantor = PengaturanSitus::ambil('alamat_kantor', '');
        $this->gmaps_embed = PengaturanSitus::ambil('gmaps_embed', '');

        $this->email_kontak = PengaturanSitus::ambil('email_kontak', '');
        $this->nomor_telepon = PengaturanSitus::ambil('nomor_telepon', '');
        $this->nomor_whatsapp = PengaturanSitus::ambil('nomor_whatsapp', '');
        $this->jam_operasional = PengaturanSitus::ambil('jam_operasional', 'Senin - Jumat: 08.00 - 16.00 WIB');

        $this->instagram = PengaturanSitus::ambil('instagram', '');
        $this->facebook = PengaturanSitus::ambil('facebook', '');
        $this->youtube = PengaturanSitus::ambil('youtube', '');
        $this->tiktok = PengaturanSitus::ambil('tiktok', '');
        $this->website_kormi_pusat = PengaturanSitus::ambil('website_kormi_pusat', '');
        $this->website_kormi_jabar = PengaturanSitus::ambil('website_kormi_jabar', '');

        $this->logo_path = PengaturanSitus::ambil('logo_path', '');
        $this->favicon_path = PengaturanSitus::ambil('favicon_path', '');
    }

    public function setTab(string $tab): void
    {
        $this->tabAktif = $tab;
    }

    public function simpan(): void
    {
        $this->validate();

        $storage = app(StorageService::class);

        if ($this->uploadLogo) {
            if (!empty($this->logo_path)) {
                $storage->hapusFile($this->logo_path);
            }
            $this->logo_path = $storage->uploadGambar($this->uploadLogo, 'pengaturan');
            $this->uploadLogo = null;
        }

        if ($this->uploadFavicon) {
            if (!empty($this->favicon_path)) {
                $storage->hapusFile($this->favicon_path);
            }
            $this->favicon_path = $storage->uploadGambar($this->uploadFavicon, 'pengaturan');
            $this->uploadFavicon = null;
        }

        $pengaturan = [
            'nama_situs' => ['nilai' => $this->nama_situs, 'kelompok' => 'umum'],
            'tagline_situs' => ['nilai' => $this->tagline_situs, 'kelompok' => 'umum'],
            'deskripsi_situs' => ['nilai' => $this->deskripsi_situs, 'kelompok' => 'umum'],
            'alamat_kantor' => ['nilai' => $this->alamat_kantor, 'kelompok' => 'umum'],
            'gmaps_embed' => ['nilai' => $this->gmaps_embed, 'kelompok' => 'umum'],

            'email_kontak' => ['nilai' => $this->email_kontak, 'kelompok' => 'kontak'],
            'nomor_telepon' => ['nilai' => $this->nomor_telepon, 'kelompok' => 'kontak'],
            'nomor_whatsapp' => ['nilai' => $this->nomor_whatsapp, 'kelompok' => 'kontak'],
            'jam_operasional' => ['nilai' => $this->jam_operasional, 'kelompok' => 'kontak'],

            'instagram' => ['nilai' => $this->instagram, 'kelompok' => 'sosmed'],
            'facebook' => ['nilai' => $this->facebook, 'kelompok' => 'sosmed'],
            'youtube' => ['nilai' => $this->youtube, 'kelompok' => 'sosmed'],
            'tiktok' => ['nilai' => $this->tiktok, 'kelompok' => 'sosmed'],
            'website_kormi_pusat' => ['nilai' => $this->website_kormi_pusat, 'kelompok' => 'sosmed'],
            'website_kormi_jabar' => ['nilai' => $this->website_kormi_jabar, 'kelompok' => 'sosmed'],

            'logo_path' => ['nilai' => $this->logo_path, 'kelompok' => 'branding'],
            'favicon_path' => ['nilai' => $this->favicon_path, 'kelompok' => 'branding'],
        ];

        foreach ($pengaturan as $kunci => $data) {
            PengaturanSitus::simpan($kunci, $data['nilai'], $data['kelompok']);
        }

        session()->flash('pesan', 'Pengaturan portal situs berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.backend.pengaturan.pengaturan-kelola');
    }
}
