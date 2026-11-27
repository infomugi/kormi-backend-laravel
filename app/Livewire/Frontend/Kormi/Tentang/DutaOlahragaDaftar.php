<?php

namespace App\Livewire\Frontend\Kormi\Tentang;

use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use App\Services\StorageService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Pendaftaran Duta Olahraga - KORMI Kabupaten Bandung')]
class DutaOlahragaDaftar extends Component
{
    use WithFileUploads;

    public const KATEGORI_DUTA = [
        'Duta Olahraga Masyarakat',
        'Duta Pemuda & Kebugaran',
        'Duta Lansia Bugar',
        'Duta Pelajar Berprestasi',
        'Duta Senam & Kesehatan',
        'Duta Olahraga Tradisional',
    ];

    public const DAFTAR_BANK = [
        'Bank BJB',
        'Bank BJB Syariah',
        'BCA',
        'BRI',
        'BNI',
        'Bank Mandiri',
        'BSI',
        'BTN',
        'CIMB Niaga',
        'Bank Permata',
        'Bank Danamon',
        'OCBC',
        'Bank Panin',
        'Bank Mega',
        'Bank DKI',
        'Bank Jateng',
        'Bank Nagari',
        'Bank Sumsel Babel',
        'Bank Kalsel',
        'Bank Sulselbar',
    ];

    public const PENDIDIKAN_TERAKHIR = [
        'SD',
        'SMP',
        'SMA-SMK',
        'D3',
        'D4-S1',
        'S2',
        'S3',
    ];

    public int $currentStep = 1;
    public int $totalSteps = 4;

    // Step 1 - Identitas
    public string $nama_lengkap = '';
    public string $jenis_kelamin = '';
    public string $tempat_lahir = '';
    public ?string $tanggal_lahir = null;
    public string $pendidikan_terakhir = '';
    public string $pekerjaan_profesi = '';

    // Step 2 - Domisili & Kontak
    public ?string $kecamatan_id = null;
    public ?string $desa_kelurahan_id = null;
    public string $alamat_domisili = '';
    public string $nomor_telepon = '';
    public string $email = '';

    // Step 3 - Profil Duta
    public string $kategori_duta = 'Duta Olahraga Masyarakat';
    public string $gelar_prestasi = '';
    public string $deskripsi_prestasi = '';
    public string $akun_instagram = '';
    public string $nama_bank = '';
    public string $nomor_rekening = '';
    public $foto = null;

    // Step 4 - Akun & Konfirmasi
    public string $kata_sandi = '';
    public string $konfirmasi_kata_sandi = '';
    public bool $setuju_syarat = false;
    public bool $pernyataan_kebenaran = false;

    // Honeypot anti-bot: harus tetap kosong.
    public string $situs_web = '';

    public bool $terhubungAkun = false;
    public bool $sudahTerdaftarSebagaiDuta = false;
    public bool $berhasil = false;
    public ?string $namaPendaftar = null;

    public function mount(): void
    {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        $this->terhubungAkun = true;

        $this->nama_lengkap = (string) ($user->nama_lengkap ?? '');
        $this->email = (string) ($user->email ?? '');
        $this->nomor_telepon = (string) ($user->nomor_telepon ?? '');
        $this->jenis_kelamin = in_array($user->jenis_kelamin, ['L', 'P'], true) ? $user->jenis_kelamin : '';
        $this->tanggal_lahir = $user->tanggal_lahir
            ? Carbon::parse($user->tanggal_lahir)->toDateString()
            : null;
        $this->kecamatan_id = $user->kecamatan_id ?: null;
        $this->desa_kelurahan_id = $user->desa_kelurahan_id ?: null;
        $this->pekerjaan_profesi = (string) ($user->pekerjaan ?? '');

        if (! empty($user->duta_id)) {
            $this->sudahTerdaftarSebagaiDuta = true;

            $duta = $user->duta;
            if ($duta) {
                $this->kecamatan_id = $this->kecamatan_id ?: $duta->kecamatan_id;
                $this->desa_kelurahan_id = $this->desa_kelurahan_id ?: $duta->desa_kelurahan_id;
                $this->jenis_kelamin = $this->jenis_kelamin ?: (string) $duta->jenis_kelamin;
                $this->tempat_lahir = (string) ($duta->tempat_lahir ?? '');
                $this->tanggal_lahir = $this->tanggal_lahir
                    ?: ($duta->tanggal_lahir ? $duta->tanggal_lahir->format('Y-m-d') : null);
                $this->pendidikan_terakhir = (string) ($duta->pendidikan_terakhir ?? '');
                $this->pekerjaan_profesi = $this->pekerjaan_profesi ?: (string) ($duta->pekerjaan_profesi ?? '');
                $this->nama_bank = (string) ($duta->nama_bank ?? '');
                $this->nomor_rekening = (string) ($duta->nomor_rekening ?? '');
            }
        }

        // Sudah ada pendaftaran (menunggu/disetujui) milik akun ini: tampilkan
        // peringatan agar tidak mendaftar ganda. Validasi final tetap di submit().
        if (! $this->sudahTerdaftarSebagaiDuta && DutaOlahraga::query()
            ->where('pengguna_id', $user->id)
            ->where('status_pendaftaran', '!=', DutaOlahraga::STATUS_DITOLAK)
            ->exists()
        ) {
            $this->sudahTerdaftarSebagaiDuta = true;
        }
    }

    /**
     * Aturan validasi per langkah wizard.
     */
    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'nama_lengkap'        => 'required|min:3|max:150',
                'jenis_kelamin'       => 'required|in:L,P',
                'tempat_lahir'        => 'nullable|max:100',
                'tanggal_lahir'       => 'required|date|before_or_equal:today',
                'pendidikan_terakhir' => ['nullable', 'max:50', Rule::in(self::PENDIDIKAN_TERAKHIR)],
                'pekerjaan_profesi'   => 'nullable|max:100',
            ],
            2 => [
                'kecamatan_id'       => 'required|exists:ref_kecamatan,id',
                'desa_kelurahan_id'  => [
                    'required',
                    Rule::exists('ref_desa_kelurahan', 'id')->where(
                        fn ($query) => $query->where('kecamatan_id', $this->kecamatan_id)
                    ),
                ],
                'alamat_domisili'    => 'required|min:10|max:500',
                'nomor_telepon'      => ['required', 'regex:/^[0-9+\-\s]{9,20}$/'],
                'email'              => $this->emailRules(),
            ],
            3 => [
                'kategori_duta'       => ['required', Rule::in(self::KATEGORI_DUTA)],
                'gelar_prestasi'      => 'nullable|max:150',
                'deskripsi_prestasi'  => 'nullable|max:1500',
                'akun_instagram'      => 'nullable|max:100',
                'nama_bank'           => ['nullable', Rule::in(self::DAFTAR_BANK)],
                'nomor_rekening'      => 'nullable|digits_between:6,25',
                'foto'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            ],
            4 => $this->stepEmpatRules(),
            default => [],
        };
    }

    protected function emailRules(): array
    {
        $unique = Rule::unique('sys_pengguna', 'email')->whereNull('dihapus_pada');

        // Akun yang sedang login boleh memakai email miliknya sendiri.
        // Sumber kebenaran adalah sesi auth, bukan property publik komponen.
        if (auth()->check()) {
            $unique = $unique->ignore(auth()->id());
        }

        return [
            'required',
            'email',
            'max:100',
            $unique,
            function (string $attribute, $value, $fail) {
                $email = mb_strtolower(trim((string) $value));

                $sudahMendaftar = DutaOlahraga::query()
                    ->whereRaw('LOWER(email) = ?', [$email])
                    ->where('status_pendaftaran', '!=', DutaOlahraga::STATUS_DITOLAK)
                    ->exists();

                if ($sudahMendaftar) {
                    $fail('Email ini sudah digunakan pada pendaftaran Duta Olahraga sebelumnya.');
                }
            },
        ];
    }

    protected function stepEmpatRules(): array
    {
        $rules = [
            'setuju_syarat'         => 'accepted',
            'pernyataan_kebenaran'  => 'accepted',
            'situs_web'             => 'prohibited',
        ];

        if (auth()->guest()) {
            $rules['kata_sandi'] = 'required|min:8|same:konfirmasi_kata_sandi';
            $rules['konfirmasi_kata_sandi'] = 'required|min:8';
        }

        return $rules;
    }

    protected function rules(): array
    {
        return array_merge(
            $this->rulesForStep(1),
            $this->rulesForStep(2),
            $this->rulesForStep(3),
            $this->rulesForStep(4),
        );
    }

    protected $messages = [
        'nama_lengkap.required'        => 'Nama lengkap wajib diisi.',
        'nama_lengkap.min'             => 'Nama lengkap minimal 3 karakter.',
        'nama_lengkap.max'             => 'Nama lengkap maksimal 150 karakter.',
        'jenis_kelamin.required'       => 'Jenis kelamin wajib dipilih.',
        'jenis_kelamin.in'             => 'Jenis kelamin harus Laki-laki (L) atau Perempuan (P).',
        'tempat_lahir.max'             => 'Tempat lahir maksimal 100 karakter.',
        'tanggal_lahir.required'       => 'Tanggal lahir wajib diisi.',
        'tanggal_lahir.date'           => 'Format tanggal lahir tidak valid.',
        'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
        'pendidikan_terakhir.in'       => 'Jenjang pendidikan terakhir tidak valid.',
        'pendidikan_terakhir.max'      => 'Pendidikan terakhir maksimal 50 karakter.',
        'pekerjaan_profesi.max'        => 'Pekerjaan / profesi maksimal 100 karakter.',
        'kecamatan_id.required'        => 'Kecamatan domisili wajib dipilih.',
        'kecamatan_id.exists'          => 'Kecamatan yang dipilih tidak valid.',
        'desa_kelurahan_id.required'   => 'Desa / kelurahan domisili wajib dipilih.',
        'desa_kelurahan_id.exists'     => 'Desa / kelurahan yang dipilih tidak sesuai dengan kecamatan.',
        'alamat_domisili.required'     => 'Alamat domisili wajib diisi.',
        'alamat_domisili.min'          => 'Alamat domisili minimal 10 karakter agar mudah diverifikasi.',
        'alamat_domisili.max'          => 'Alamat domisili maksimal 500 karakter.',
        'nomor_telepon.required'       => 'Nomor telepon / WhatsApp wajib diisi.',
        'nomor_telepon.regex'          => 'Nomor telepon hanya boleh berisi angka, spasi, tanda + atau -, 9 sampai 20 karakter.',
        'email.required'               => 'Alamat email wajib diisi.',
        'email.email'                  => 'Format alamat email tidak valid.',
        'email.max'                    => 'Alamat email maksimal 100 karakter.',
        'email.unique'                 => 'Alamat email sudah terdaftar. Silakan masuk atau gunakan email lain.',
        'kategori_duta.required'       => 'Kategori duta wajib dipilih.',
        'kategori_duta.in'             => 'Kategori duta yang dipilih tidak valid.',
        'gelar_prestasi.max'           => 'Gelar prestasi maksimal 150 karakter.',
        'deskripsi_prestasi.max'       => 'Deskripsi prestasi maksimal 1500 karakter.',
        'akun_instagram.max'           => 'Nama akun Instagram maksimal 100 karakter.',
        'nama_bank.in'                 => 'Bank yang dipilih tidak valid.',
        'nomor_rekening.digits_between' => 'Nomor rekening harus berupa angka 6-25 digit.',
        'foto.image'                   => 'Berkas foto harus berupa gambar.',
        'foto.mimes'                   => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
        'foto.max'                     => 'Ukuran foto maksimal 5 MB.',
        'kata_sandi.required'          => 'Kata sandi wajib diisi.',
        'kata_sandi.min'               => 'Kata sandi minimal 8 karakter.',
        'kata_sandi.same'              => 'Konfirmasi kata sandi tidak cocok.',
        'konfirmasi_kata_sandi.required' => 'Konfirmasi kata sandi wajib diisi.',
        'konfirmasi_kata_sandi.min'    => 'Konfirmasi kata sandi minimal 8 karakter.',
        'setuju_syarat.accepted'       => 'Anda harus menyetujui syarat & ketentuan pendaftaran duta.',
        'pernyataan_kebenaran.accepted' => 'Anda harus menyatakan bahwa seluruh data yang diisi benar.',
        'situs_web.prohibited'         => 'Pendaftaran tidak dapat diproses. Silakan muat ulang halaman.',
    ];

    public function updatedKecamatanId(): void
    {
        $this->desa_kelurahan_id = null;
    }

    public function updatedAkunInstagram(string $value): void
    {
        $this->akun_instagram = ltrim(trim($value), '@');
    }

    /**
     * Validasi berkas foto segera setelah diunggah ke penyimpanan sementara,
     * sehingga kesalahan format/ukuran tampil dalam bahasa Indonesia dan tidak
     * baru ketahuan saat submit. Berkas yang tidak valid langsung dibuang.
     */
    public function updatedFoto(): void
    {
        $this->resetErrorBag('foto');

        if (! $this->foto) {
            return;
        }

        // Foto HEIC dari iPhone yang tidak sempat dikonversi browser diberi
        // pesan khusus agar pengguna tahu langkah berikutnya.
        $namaFoto = strtolower((string) $this->foto->getClientOriginalName());
        $tipeFoto = strtolower((string) $this->foto->getMimeType());

        if (
            str_ends_with($namaFoto, '.heic') || str_ends_with($namaFoto, '.heif')
            || in_array($tipeFoto, ['image/heic', 'image/heif', 'image/heic-sequence', 'image/heif-sequence'], true)
        ) {
            $this->addError('foto', 'Foto berformat HEIC belum bisa diproses di perangkat ini. Pilih ulang foto dari galeri (biasanya otomatis dikonversi) atau gunakan foto JPG/PNG.');
            $this->foto = null;

            return;
        }

        $validator = validator(
            ['foto' => $this->foto],
            ['foto' => 'image|mimes:jpg,jpeg,png,webp|max:5120'],
            [
                'foto.image' => 'Berkas foto harus berupa gambar.',
                'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
                'foto.max'   => 'Ukuran foto maksimal 5 MB.',
            ],
        );

        if ($validator->fails()) {
            $this->addError('foto', $validator->errors()->first('foto'));
            $this->foto = null;
        }
    }

    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->currentStep));

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function setStep(int $step): void
    {
        $step = max(1, min($this->totalSteps, $step));

        if ($step === $this->currentStep) {
            return;
        }

        if ($step < $this->currentStep) {
            $this->currentStep = $step;

            return;
        }

        // Maju hanya boleh setelah seluruh langkah sebelumnya valid.
        for ($i = $this->currentStep; $i < $step; $i++) {
            $this->validate($this->rulesForStep($i));
        }

        $this->currentStep = $step;
    }

    public function submit(): void
    {
        // Cegah submit dini: hanya langkah terakhir yang boleh mengirim pendaftaran.
        if ($this->currentStep < $this->totalSteps) {
            $this->nextStep();

            return;
        }

        // Kebenaran autentikasi diambil dari sesi, bukan property publik
        // (property Livewire dapat dikirim ulang oleh klien).
        $user = auth()->user();

        if ($user && ! empty($user->duta_id)) {
            $this->addError('pendaftaran', 'Akun Anda sudah terhubung dengan data Duta Olahraga. Silakan hubungi administrator KORMI bila ingin memperbarui data.');

            return;
        }

        if ($user && DutaOlahraga::query()
            ->where('pengguna_id', $user->id)
            ->where('status_pendaftaran', '!=', DutaOlahraga::STATUS_DITOLAK)
            ->exists()
        ) {
            $this->addError('pendaftaran', 'Anda sudah memiliki pendaftaran duta yang sedang diproses. Silakan hubungi administrator KORMI bila ingin memperbarui data.');

            return;
        }

        // Guard berbasis IP bersifat best-effort (X-Forwarded-For dapat dipalsukan
        // selama seluruh proxy dipercaya), sehingga dilengkapi guard berbasis konten.
        $rateKey = 'duta-daftar:' . request()->ip();

        if (RateLimiter::tooManyAttempts($rateKey, 10)) {
            $detik = RateLimiter::availableIn($rateKey);
            $menit = max(1, (int) ceil($detik / 60));

            $this->addError('pendaftaran', "Terlalu banyak percobaan pendaftaran dari jaringan Anda. Silakan coba lagi dalam {$menit} menit.");

            return;
        }

        RateLimiter::hit($rateKey, 3600);

        $this->validate($this->rules());

        $email = mb_strtolower(trim($this->email));
        $nomorTelepon = trim($this->nomor_telepon);

        // Guard berbasis konten: kunci dari email + nomor telepon sehingga
        // rotasi IP / header X-Forwarded-For tidak melewati batas percobaan.
        $kunciKonten = 'duta-daftar-akun:' . sha1($email . '|' . preg_replace('/\D/', '', $nomorTelepon));

        if (RateLimiter::tooManyAttempts($kunciKonten, 3)) {
            $detik = RateLimiter::availableIn($kunciKonten);
            $menit = max(1, (int) ceil($detik / 60));

            $this->addError('pendaftaran', "Pendaftaran dengan email / nomor telepon ini sudah terlalu sering dilakukan. Silakan coba lagi dalam {$menit} menit atau hubungi administrator KORMI.");

            return;
        }

        $pathFoto = null;

        if ($this->foto) {
            try {
                /** @var StorageService $storage */
                $storage = app(StorageService::class);
                $pathFoto = $storage->uploadGambar($this->foto, 'duta/pendaftaran');
            } catch (\InvalidArgumentException $e) {
                $this->addError('foto', $e->getMessage());

                return;
            } catch (\Throwable $e) {
                // Penyimpanan (MinIO) sedang bermasalah: jangan tampilkan error
                // 500 yang menghapus seluruh isian. Beri pesan yang bisa ditindak.
                report($e);
                $this->addError('foto', 'Foto gagal diunggah ke penyimpanan. Coba lagi beberapa saat, atau hapus pas foto untuk melanjutkan tanpa foto.');

                return;
            }
        }

        // Sanitasi teks bebas (anti XSS / deface injection).
        $namaLengkap = strip_tags(trim($this->nama_lengkap));
        $tempatLahir = $this->tempat_lahir !== '' ? strip_tags(trim($this->tempat_lahir)) : null;
        $alamatDomisili = strip_tags(trim($this->alamat_domisili));
        $pekerjaan = $this->pekerjaan_profesi !== '' ? strip_tags(trim($this->pekerjaan_profesi)) : null;
        $gelarPrestasi = $this->gelar_prestasi !== '' ? strip_tags(trim($this->gelar_prestasi)) : null;
        $deskripsiPrestasi = $this->deskripsi_prestasi !== '' ? strip_tags(trim($this->deskripsi_prestasi)) : null;
        $akunInstagram = $this->akun_instagram !== '' ? ltrim(strip_tags(trim($this->akun_instagram)), '@') : null;

        try {
            DB::transaction(function () use (
                $user,
                $namaLengkap,
                $tempatLahir,
                $alamatDomisili,
                $pekerjaan,
                $gelarPrestasi,
                $deskripsiPrestasi,
                $akunInstagram,
                $email,
                $nomorTelepon,
                $pathFoto
            ) {
                $dataDuta = [
                    'kecamatan_id'        => $this->kecamatan_id,
                    'desa_kelurahan_id'   => $this->desa_kelurahan_id,
                    'nama_lengkap'        => $namaLengkap,
                    'jenis_kelamin'       => $this->jenis_kelamin,
                    'tempat_lahir'        => $tempatLahir,
                    'tanggal_lahir'       => $this->tanggal_lahir,
                    'nomor_telepon'       => $nomorTelepon,
                    'email'               => $email,
                    'alamat_domisili'     => $alamatDomisili,
                    'pekerjaan_profesi'   => $pekerjaan,
                    'pendidikan_terakhir' => $this->pendidikan_terakhir !== '' ? $this->pendidikan_terakhir : null,
                    'tahun_pemilihan'     => now()->year,
                    'kategori_duta'       => $this->kategori_duta,
                    'gelar_prestasi'      => $gelarPrestasi,
                    'deskripsi_prestasi'  => $deskripsiPrestasi,
                    'akun_instagram'      => $akunInstagram,
                    'nama_bank'           => $this->nama_bank !== '' ? $this->nama_bank : null,
                    'nomor_rekening'      => $this->nomor_rekening !== '' ? trim($this->nomor_rekening) : null,
                    'foto_url'            => $pathFoto,
                    'status_aktif'        => false,
                    'status_unggulan'     => false,
                    'status_pendaftaran'  => DutaOlahraga::STATUS_MENUNGGU,
                    'pengguna_id'         => $user?->id,
                ];

                if ($user === null) {
                    // Tamu: buat akun nonaktif TANPA duta_id. Penautan akun
                    // (duta_id + aktivasi + peran) dilakukan saat approval admin.
                    $peran = Peran::firstOrCreate(
                        ['slug' => 'duta-olahraga'],
                        [
                            'nama_peran' => 'Duta Olahraga Desa',
                            'deskripsi'  => 'Duta Olahraga Desa/Kelurahan',
                        ]
                    );

                    $akunBaru = Pengguna::create([
                        'peran_id'          => $peran->id,
                        'nama_lengkap'      => $namaLengkap,
                        'email'             => $email,
                        'jenis_kelamin'     => $this->jenis_kelamin,
                        'tanggal_lahir'     => $this->tanggal_lahir !== null ? Carbon::parse($this->tanggal_lahir)->toDateString() : null,
                        'pekerjaan'         => $pekerjaan,
                        'nomor_telepon'     => $nomorTelepon,
                        'kecamatan_id'      => $this->kecamatan_id,
                        'desa_kelurahan_id' => $this->desa_kelurahan_id,
                        'kata_sandi'        => Hash::make($this->kata_sandi),
                        'status_aktif'      => false,
                        'disetujui_pada'    => null,
                        'disetujui_oleh'    => null,
                        'duta_id'           => null,
                    ]);

                    $dataDuta['pengguna_id'] = $akunBaru->id;
                }

                // Untuk pengguna yang sudah login: data akun/profil/peran TIDAK
                // diubah pada tahap submit. Penautan terjadi saat approval.
                DutaOlahraga::create($dataDuta);
            });
        } catch (\Throwable $e) {
            // Jangan tinggalkan berkas yatim di storage bila penyimpanan DB gagal.
            if ($pathFoto !== null) {
                app(StorageService::class)->hapusFile($pathFoto);
            }

            if ($e instanceof QueryException && $this->adalahDuplikatEmail($e)) {
                $this->addError('email', 'Email atau data pendaftaran ini sudah terdaftar. Silakan gunakan email lain atau masuk ke akun Anda.');

                return;
            }

            throw $e;
        }

        // Hit guard konten hanya untuk pendaftaran yang benar-benar tersimpan.
        RateLimiter::hit($kunciKonten, 3600);

        $this->namaPendaftar = $namaLengkap;
        $this->berhasil = true;
        $this->currentStep = $this->totalSteps;
        $this->resetErrorBag();
    }

    /**
     * Deteksi pelanggaran unique email pada sys_pengguna dari QueryException.
     */
    protected function adalahDuplikatEmail(QueryException $e): bool
    {
        if ((string) $e->getCode() !== '23000') {
            return false;
        }

        $pesan = $e->getMessage();

        if (stripos($pesan, 'Duplicate entry') === false) {
            return false;
        }

        return stripos($pesan, 'sys_pengguna') !== false || stripos($pesan, 'email') !== false;
    }

    protected function dataTampilan(): array
    {
        return [
            'daftarKecamatan'  => Kecamatan::orderBy('nama_kecamatan')->get(),
            'daftarDesa'       => $this->kecamatan_id
                ? DesaKelurahan::where('kecamatan_id', $this->kecamatan_id)
                    ->orderBy('nama_desa_kelurahan')
                    ->get()
                : collect(),
            'daftarKategori'   => self::KATEGORI_DUTA,
            'daftarPendidikan' => self::PENDIDIKAN_TERAKHIR,
            'daftarBank'       => self::DAFTAR_BANK,
            'langkahWizard'    => [
                1 => 'Identitas',
                2 => 'Domisili',
                3 => 'Profil Duta',
                4 => 'Akun',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.frontend.kormi.tentang.duta-olahraga-daftar', $this->dataTampilan())
            ->layout('components.layouts.app');
    }
}
