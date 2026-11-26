<?php

namespace App\Livewire\Mobile;

use App\Livewire\Frontend\Kormi\Tentang\DutaOlahragaDaftar;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use App\Services\StorageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.mobile')]
#[Title('Profil - KORMI Kabupaten Bandung')]
class Profil extends Component
{
    use WithFileUploads;

    #[Url(as: 'tab')]
    public string $tab = 'profil';

    public string $nama_lengkap = '';
    public string $nomor_telepon = '';
    public $foto_profil_baru = null;

    public string $kata_sandi_lama = '';
    public string $kata_sandi_baru = '';
    public string $konfirmasi_kata_sandi = '';

    // Form profil duta — ikut tersimpan bersama data akun.
    public string $duta_kategori = '';
    public string $duta_jenis_kelamin = '';
    public string $duta_tempat_lahir = '';
    public ?string $duta_tanggal_lahir = null;
    public string $duta_pendidikan = '';
    public string $duta_pekerjaan = '';
    public ?string $duta_kecamatan_id = null;
    public ?string $duta_desa_kelurahan_id = null;
    public string $duta_alamat = '';
    public string $duta_instagram = '';
    public string $duta_nama_bank = '';
    public string $duta_nomor_rekening = '';
    public string $duta_gelar_prestasi = '';
    public string $duta_deskripsi_prestasi = '';
    public $foto_duta_baru = null;

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
        'duta_kategori.required' => 'Kategori duta wajib dipilih.',
        'duta_kategori.in' => 'Kategori duta yang dipilih tidak valid.',
        'duta_jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'duta_jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
        'duta_tempat_lahir.max' => 'Tempat lahir maksimal 100 karakter.',
        'duta_tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
        'duta_tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
        'duta_pendidikan.in' => 'Jenjang pendidikan terakhir tidak valid.',
        'duta_pekerjaan.max' => 'Pekerjaan / profesi maksimal 100 karakter.',
        'duta_kecamatan_id.required' => 'Kecamatan domisili wajib dipilih.',
        'duta_kecamatan_id.exists' => 'Kecamatan yang dipilih tidak valid.',
        'duta_desa_kelurahan_id.required' => 'Desa / kelurahan domisili wajib dipilih.',
        'duta_desa_kelurahan_id.exists' => 'Desa / kelurahan yang dipilih tidak sesuai dengan kecamatan.',
        'duta_alamat.min' => 'Alamat domisili minimal 10 karakter.',
        'duta_alamat.max' => 'Alamat domisili maksimal 500 karakter.',
        'duta_instagram.max' => 'Nama akun Instagram maksimal 100 karakter.',
        'duta_nama_bank.in' => 'Bank yang dipilih tidak valid.',
        'duta_nomor_rekening.digits_between' => 'Nomor rekening harus berupa angka 6-25 digit.',
        'duta_gelar_prestasi.max' => 'Gelar prestasi maksimal 150 karakter.',
        'duta_deskripsi_prestasi.max' => 'Deskripsi prestasi maksimal 1500 karakter.',
        'foto_duta_baru.image' => 'Berkas foto harus berupa gambar.',
        'foto_duta_baru.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
        'foto_duta_baru.max' => 'Ukuran foto maksimal 5 MB.',
    ];

    public function mount(): void
    {
        $user = auth()->user();
        $this->nama_lengkap = $user->nama_lengkap;
        $this->nomor_telepon = (string) $user->nomor_telepon;

        $this->isiFormDuta();
    }

    public function pilihTab(string $tab): void
    {
        if (! in_array($tab, ['profil', 'data', 'keamanan'], true)) {
            return;
        }

        $this->tab = $tab;
        $this->resetValidation();
    }

    public function updatedDutaKecamatanId(): void
    {
        $this->duta_desa_kelurahan_id = null;
    }

    public function updatedDutaInstagram(string $value): void
    {
        $this->duta_instagram = ltrim(trim($value), '@');
    }

    public function simpanDataAkun(): void
    {
        $this->resetValidation();

        $user = auth()->user();
        $duta = $this->dutaTerhubung();
        $kelolaDuta = $duta !== null || $user->isDutaOlahraga();

        $aturan = [
            'nama_lengkap' => 'required|min:3|max:100',
            'nomor_telepon' => 'nullable|min:8|max:20',
            'foto_profil_baru' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];

        if ($kelolaDuta) {
            $aturan += [
                'duta_kategori' => ['required', Rule::in(DutaOlahragaDaftar::KATEGORI_DUTA)],
                'duta_jenis_kelamin' => 'required|in:L,P',
                'duta_tempat_lahir' => 'nullable|max:100',
                'duta_tanggal_lahir' => 'nullable|date|before_or_equal:today',
                'duta_pendidikan' => ['nullable', Rule::in(DutaOlahragaDaftar::PENDIDIKAN_TERAKHIR)],
                'duta_pekerjaan' => 'nullable|max:100',
                'duta_kecamatan_id' => 'required|exists:ref_kecamatan,id',
                'duta_desa_kelurahan_id' => [
                    'required',
                    Rule::exists('ref_desa_kelurahan', 'id')->where(
                        fn ($query) => $query->where('kecamatan_id', $this->duta_kecamatan_id)
                    ),
                ],
                'duta_alamat' => 'nullable|min:10|max:500',
                'duta_instagram' => 'nullable|max:100',
                'duta_nama_bank' => ['nullable', Rule::in(DutaOlahragaDaftar::DAFTAR_BANK)],
                'duta_nomor_rekening' => 'nullable|digits_between:6,25',
                'duta_gelar_prestasi' => 'nullable|max:150',
                'duta_deskripsi_prestasi' => 'nullable|max:1500',
                'foto_duta_baru' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            ];
        }

        $this->validate($aturan);

        $storage = app(StorageService::class);

        $namaLengkap = strip_tags(trim($this->nama_lengkap));
        $nomorTelepon = trim(strip_tags($this->nomor_telepon)) ?: null;

        $dataAkun = [
            'nama_lengkap' => $namaLengkap,
            'nomor_telepon' => $nomorTelepon,
        ];

        if ($kelolaDuta) {
            // Identitas & wilayah dipakai bersama oleh akun dan profil duta.
            $dataAkun['jenis_kelamin'] = $this->duta_jenis_kelamin;
            $dataAkun['tanggal_lahir'] = $this->duta_tanggal_lahir ?: null;
            $dataAkun['pekerjaan'] = trim(strip_tags($this->duta_pekerjaan)) ?: null;
            $dataAkun['kecamatan_id'] = $this->duta_kecamatan_id;
            $dataAkun['desa_kelurahan_id'] = $this->duta_desa_kelurahan_id;
        }

        $fotoProfilTersimpan = false;
        $fotoDutaTersimpan = false;

        if ($this->foto_profil_baru) {
            try {
                $path = $storage->uploadGambar($this->foto_profil_baru, 'pengguna/profil');

                if ($user->foto_profil && $user->foto_profil !== $path) {
                    $storage->hapusFile($user->foto_profil);
                }

                $dataAkun['foto_profil'] = $path;
                $fotoProfilTersimpan = true;
            } catch (\InvalidArgumentException $e) {
                $this->addError('foto_profil_baru', $e->getMessage());
            } catch (\Throwable $e) {
                report($e);
                $this->addError('foto_profil_baru', 'Foto gagal diunggah. Silakan coba lagi.');
            }
        }

        $pathFotoDuta = null;

        if ($kelolaDuta && $this->foto_duta_baru) {
            try {
                $pathFotoDuta = $storage->uploadGambar($this->foto_duta_baru, 'duta/profil');
                $fotoDutaTersimpan = true;
            } catch (\InvalidArgumentException $e) {
                $this->addError('foto_duta_baru', $e->getMessage());
            } catch (\Throwable $e) {
                report($e);
                $this->addError('foto_duta_baru', 'Foto duta gagal diunggah. Silakan coba lagi.');
            }
        }

        $dutaBaru = $kelolaDuta && $duta === null;
        $fotoDutaLama = $duta?->foto_url;

        DB::transaction(function () use ($user, $dataAkun, $kelolaDuta, $duta, $pathFotoDuta, $namaLengkap, $nomorTelepon) {
            $user->update($dataAkun);

            if (! $kelolaDuta) {
                return;
            }

            $dataDuta = [
                'nama_lengkap' => $namaLengkap,
                'nomor_telepon' => $nomorTelepon,
                'email' => $user->email,
                'jenis_kelamin' => $this->duta_jenis_kelamin,
                'tempat_lahir' => trim(strip_tags($this->duta_tempat_lahir)) ?: null,
                'tanggal_lahir' => $this->duta_tanggal_lahir ?: null,
                'pendidikan_terakhir' => $this->duta_pendidikan !== '' ? $this->duta_pendidikan : null,
                'pekerjaan_profesi' => trim(strip_tags($this->duta_pekerjaan)) ?: null,
                'kecamatan_id' => $this->duta_kecamatan_id,
                'desa_kelurahan_id' => $this->duta_desa_kelurahan_id,
                'alamat_domisili' => trim(strip_tags($this->duta_alamat)) ?: null,
                'akun_instagram' => $this->duta_instagram !== '' ? ltrim(strip_tags(trim($this->duta_instagram)), '@') : null,
                'nama_bank' => $this->duta_nama_bank !== '' ? $this->duta_nama_bank : null,
                'nomor_rekening' => trim($this->duta_nomor_rekening) !== '' ? trim($this->duta_nomor_rekening) : null,
                'gelar_prestasi' => trim(strip_tags($this->duta_gelar_prestasi)) ?: null,
                'deskripsi_prestasi' => trim(strip_tags($this->duta_deskripsi_prestasi)) ?: null,
                'kategori_duta' => $this->duta_kategori,
            ];

            if ($pathFotoDuta) {
                $dataDuta['foto_url'] = $pathFotoDuta;
            }

            if ($duta) {
                $duta->update($dataDuta);
            } else {
                DutaOlahraga::create($dataDuta + [
                    'tahun_pemilihan' => now()->year,
                    'status_aktif' => false,
                    'status_unggulan' => false,
                    'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
                    'pengguna_id' => $user->id,
                ]);
            }
        });

        if ($pathFotoDuta && $fotoDutaLama && $fotoDutaLama !== $pathFotoDuta) {
            $storage->hapusFile($fotoDutaLama);
        }

        $user->refresh();

        $this->nama_lengkap = $user->nama_lengkap;
        $this->nomor_telepon = (string) $user->nomor_telepon;

        if ($fotoProfilTersimpan) {
            $this->foto_profil_baru = null;
        }

        if ($fotoDutaTersimpan) {
            $this->foto_duta_baru = null;
        }

        $this->isiFormDuta();

        $pesan = match (true) {
            $dutaBaru => 'Profil Duta Olahraga berhasil dihubungkan dan menunggu verifikasi administrator.',
            $kelolaDuta => 'Data akun dan profil Duta Olahraga berhasil diperbarui.',
            default => 'Data akun berhasil diperbarui.',
        };

        if ($this->foto_profil_baru) {
            $pesan = 'Data tersimpan, tetapi foto profil gagal diunggah.';
        }

        if ($kelolaDuta && $this->foto_duta_baru) {
            $pesan = 'Data tersimpan, tetapi foto duta gagal diunggah.';
        }

        session()->flash('pesan_akun', $pesan);
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

        $duta = $this->dutaTerhubung();
        $kelolaDuta = $duta !== null || $user->isDutaOlahraga();

        if ($duta) {
            $duta->loadMissing(['kecamatan', 'desaKelurahan']);
        }

        $badgePeran = match (true) {
            $user->isSuperAdmin() => 'Super Admin',
            $user->isAdminKorcam() => 'Korcam',
            $user->isAdminInorga() => 'Inorga',
            $user->isEditorBerita() => 'Editor',
            $user->isDutaOlahraga() => 'Duta',
            default => 'Pegiat',
        };

        $labelStatusDuta = match ($duta?->status_pendaftaran) {
            DutaOlahraga::STATUS_DISETUJUI => 'Disetujui',
            DutaOlahraga::STATUS_DITOLAK => 'Ditolak',
            default => 'Menunggu',
        };

        $data = [
            'user' => $user,
            'roleLabel' => $user->peran?->nama_peran ?? 'Pengguna',
            'badgePeran' => $badgePeran,
            'duta' => $duta,
            'kelolaDuta' => $kelolaDuta,
            'labelStatusDuta' => $labelStatusDuta,
        ];

        if ($kelolaDuta) {
            $data['daftarKecamatan'] = Kecamatan::orderBy('nama_kecamatan')->get();
            $data['daftarDesa'] = $this->duta_kecamatan_id
                ? DesaKelurahan::where('kecamatan_id', $this->duta_kecamatan_id)
                    ->orderBy('nama_desa_kelurahan')
                    ->get()
                : collect();
            $data['daftarKategori'] = DutaOlahragaDaftar::KATEGORI_DUTA;
            $data['daftarPendidikan'] = DutaOlahragaDaftar::PENDIDIKAN_TERAKHIR;
            $data['daftarBank'] = DutaOlahragaDaftar::DAFTAR_BANK;
        }

        return view('livewire.mobile.profil', $data);
    }

    /**
     * Profil duta milik akun yang sedang login (tautan langsung maupun pengajuan).
     */
    private function dutaTerhubung(): ?DutaOlahraga
    {
        $user = auth()->user();

        if (! $user) {
            return null;
        }

        if ($user->duta) {
            return $user->duta;
        }

        return DutaOlahraga::query()
            ->where('pengguna_id', $user->id)
            ->where('status_pendaftaran', '!=', DutaOlahraga::STATUS_DITOLAK)
            ->latest('dibuat_pada')
            ->first();
    }

    private function isiFormDuta(): void
    {
        $user = auth()->user();
        $duta = $this->dutaTerhubung();

        if (! $duta) {
            $this->duta_kategori = 'Duta Olahraga Masyarakat';
            $this->duta_jenis_kelamin = in_array($user->jenis_kelamin, ['L', 'P'], true) ? $user->jenis_kelamin : '';
            $this->duta_tempat_lahir = '';
            $this->duta_tanggal_lahir = $user->tanggal_lahir
                ? \Carbon\Carbon::parse($user->tanggal_lahir)->toDateString()
                : null;
            $this->duta_pendidikan = '';
            $this->duta_pekerjaan = (string) ($user->pekerjaan ?? '');
            $this->duta_kecamatan_id = $user->kecamatan_id ?: null;
            $this->duta_desa_kelurahan_id = $user->desa_kelurahan_id ?: null;
            $this->duta_alamat = '';
            $this->duta_instagram = '';
            $this->duta_nama_bank = '';
            $this->duta_nomor_rekening = '';
            $this->duta_gelar_prestasi = '';
            $this->duta_deskripsi_prestasi = '';
            $this->foto_duta_baru = null;

            return;
        }

        $this->duta_kategori = (string) ($duta->kategori_duta ?: 'Duta Olahraga Masyarakat');
        $this->duta_jenis_kelamin = (string) ($duta->jenis_kelamin ?? '');
        $this->duta_tempat_lahir = (string) ($duta->tempat_lahir ?? '');
        $this->duta_tanggal_lahir = $duta->tanggal_lahir ? $duta->tanggal_lahir->format('Y-m-d') : null;
        $this->duta_pendidikan = (string) ($duta->pendidikan_terakhir ?? '');
        $this->duta_pekerjaan = (string) ($duta->pekerjaan_profesi ?? '');
        $this->duta_kecamatan_id = $duta->kecamatan_id ?: null;
        $this->duta_desa_kelurahan_id = $duta->desa_kelurahan_id ?: null;
        $this->duta_alamat = (string) ($duta->alamat_domisili ?? '');
        $this->duta_instagram = (string) ($duta->akun_instagram ?? '');
        $this->duta_nama_bank = (string) ($duta->nama_bank ?? '');
        $this->duta_nomor_rekening = (string) ($duta->nomor_rekening ?? '');
        $this->duta_gelar_prestasi = (string) ($duta->gelar_prestasi ?? '');
        $this->duta_deskripsi_prestasi = (string) ($duta->deskripsi_prestasi ?? '');
        $this->foto_duta_baru = null;
    }
}
