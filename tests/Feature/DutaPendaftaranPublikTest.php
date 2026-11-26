<?php

namespace Tests\Feature;

use App\Livewire\Backend\Kormi\Duta\DutaKelola;
use App\Livewire\Backend\Pengguna\PenggunaKelola;
use App\Livewire\Frontend\Kormi\Tentang\DutaOlahragaDaftar;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Acceptance test independen untuk wizard pendaftaran Duta Olahraga publik.
 *
 * Semantik yang diuji (setelah perbaikan review):
 * - submit() hanya memproses pada langkah terakhir (early-submit guard);
 * - tamu mendapat akun nonaktif tanpa duta_id, penautan terjadi saat approval;
 * - akun yang sudah login tidak diubah saat submit, hanya ditautkan saat approval;
 * - penolakan menghapus akun tamu otomatis (email bebas dipakai lagi) atau
 *   melepaskan tautan akun yang sudah ada dan menurunkan peran;
 * - aksi verifikasi hanya untuk super-admin / admin-korcam.
 *
 * Test ini hanya membaca/menguji aplikasi, tidak mengubah kode produksi.
 */
class DutaPendaftaranPublikTest extends TestCase
{
    use DatabaseTransactions;

    protected ?Pengguna $admin = null;
    protected Kecamatan $kecamatan;
    protected DesaKelurahan $desa;
    protected Peran $peranSuperAdmin;
    protected Peran $peranKorcam;
    protected Peran $peranPegiat;
    protected Peran $peranDuta;
    protected Peran $peranEditor;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('minio');
        Storage::fake('public');

        // Cache pada environment test bisa persisten antar test (store database),
        // jadi pembatas laju pendaftaran dibersihkan secara eksplisit.
        RateLimiter::clear('duta-daftar:127.0.0.1');

        $this->peranSuperAdmin = Peran::firstOrCreate(
            ['slug' => 'super-admin'],
            ['nama_peran' => 'Super Administrator', 'deskripsi' => 'Akses penuh sistem']
        );

        $this->peranKorcam = Peran::firstOrCreate(
            ['slug' => 'admin-korcam'],
            ['nama_peran' => 'Admin KORCAM', 'deskripsi' => 'Administrator tingkat kecamatan']
        );

        $this->peranPegiat = Peran::firstOrCreate(
            ['slug' => 'pegiat-olahraga'],
            ['nama_peran' => 'Pegiat Olahraga', 'deskripsi' => 'Warga / pegiat olahraga masyarakat']
        );

        $this->peranDuta = Peran::firstOrCreate(
            ['slug' => 'duta-olahraga'],
            ['nama_peran' => 'Duta Olahraga Desa', 'deskripsi' => 'Duta Olahraga Desa/Kelurahan']
        );

        $this->peranEditor = Peran::firstOrCreate(
            ['slug' => 'editor-berita'],
            ['nama_peran' => 'Editor Berita & Publikasi', 'deskripsi' => 'Pengelola konten berita']
        );

        // Admin fixture harus benar-benar super-admin, bukan sekadar baris pertama.
        $this->admin = Pengguna::query()
            ->whereHas('peran', fn ($q) => $q->where('slug', 'super-admin'))
            ->first();

        if (! $this->admin) {
            $this->admin = $this->buatPengguna([
                'peran_id'     => $this->peranSuperAdmin->id,
                'status_aktif' => true,
            ]);
        }

        $this->kecamatan = Kecamatan::first() ?? Kecamatan::create([
            'nama_kecamatan' => 'Kecamatan Uji Duta',
            'slug'           => 'kecamatan-uji-duta-' . Str::lower(Str::random(6)),
        ]);

        $this->desa = DesaKelurahan::where('kecamatan_id', $this->kecamatan->id)->first()
            ?? DesaKelurahan::create([
                'kecamatan_id'        => $this->kecamatan->id,
                'nama_desa_kelurahan' => 'Desa Uji Duta',
                'slug'                => 'desa-uji-duta-' . Str::lower(Str::random(6)),
                'jenis'               => 'desa',
            ]);
    }

    // =====================================================================
    // HELPERS
    // =====================================================================

    /**
     * Data formulir wizard yang valid (semua 4 langkah), dapat dioverride.
     */
    private function dataPendaftaranValid(array $override = []): array
    {
        return array_merge([
            'nama_lengkap'           => 'Duta Uji ' . Str::random(8),
            'jenis_kelamin'          => 'L',
            'tanggal_lahir'          => '1996-04-12',
            'pendidikan_terakhir'    => 'D4-S1',
            'pekerjaan_profesi'      => 'Penguji Perangkat Lunak',
            'kecamatan_id'           => $this->kecamatan->id,
            'desa_kelurahan_id'      => $this->desa->id,
            'alamat_domisili'        => 'Jl. Pengujian Otomatis No. 12, RT 01 RW 02',
            'nomor_telepon'          => '081234567890',
            'email'                  => 'duta.uji.' . Str::lower(Str::random(12)) . '@example.test',
            'kategori_duta'          => 'Duta Olahraga Masyarakat',
            'gelar_prestasi'         => 'Juara 1 Senam Kreasi Kabupaten',
            'deskripsi_prestasi'     => 'Aktif membina senam masyarakat desa sejak 2019.',
            'setuju_syarat'          => true,
            'pernyataan_kebenaran'   => true,
            'kata_sandi'             => 'rahasia12345',
            'konfirmasi_kata_sandi'  => 'rahasia12345',
        ], $override);
    }

    /**
     * Kirim formulir dari langkah terakhir (perilaku klien yang sah).
     */
    private function kirimPendaftaran(array $data = [], array $state = [])
    {
        $komponen = Livewire::test(DutaOlahragaDaftar::class)
            ->set($data ?: $this->dataPendaftaranValid());

        foreach ($state as $property => $value) {
            $komponen->set($property, $value);
        }

        return $komponen
            ->set('currentStep', 4)
            ->call('submit');
    }

    /**
     * Kunci pembatas laju berbasis konten (email + digit nomor telepon).
     */
    private function kunciKonten(string $email, string $nomorTelepon): string
    {
        return 'duta-daftar-akun:' . sha1(
            mb_strtolower(trim($email)) . '|' . preg_replace('/\D/', '', $nomorTelepon)
        );
    }

    private function buatDuta(array $override = []): DutaOlahraga
    {
        return DutaOlahraga::create(array_merge([
            'kecamatan_id'       => $this->kecamatan->id,
            'desa_kelurahan_id'  => $this->desa->id,
            'nama_lengkap'       => 'Duta Fixture ' . Str::random(8),
            'jenis_kelamin'      => 'L',
            'tanggal_lahir'      => '1995-01-01',
            'nomor_telepon'      => '081200000000',
            'email'              => 'fixture.' . Str::lower(Str::random(10)) . '@example.test',
            'alamat_domisili'    => 'Jl. Fixture No. 1',
            'tahun_pemilihan'    => now()->year,
            'kategori_duta'      => 'Duta Olahraga Masyarakat',
            'status_aktif'       => true,
            'status_unggulan'    => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_DISETUJUI,
        ], $override));
    }

    private function buatPengguna(array $override = []): Pengguna
    {
        return Pengguna::create(array_merge([
            'nama_lengkap' => 'Pengguna Uji ' . Str::random(8),
            'email'        => 'pengguna.uji.' . Str::lower(Str::random(12)) . '@example.test',
            'kata_sandi'   => Hash::make('rahasia12345'),
            'peran_id'     => $this->peranPegiat->id,
            'status_aktif' => true,
        ], $override));
    }

    // =====================================================================
    // 1. ROUTE PUBLIK
    // =====================================================================

    public function test_halaman_pendaftaran_duta_dapat_diakses_publik(): void
    {
        $route = Route::getRoutes()->getByName('dutaolahraga.daftar');

        $this->assertNotNull($route, 'Route dutaolahraga.daftar tidak terdaftar.');
        $this->assertNotContains(
            'auth',
            $route->gatherMiddleware(),
            'Route pendaftaran duta seharusnya tidak dilindungi middleware auth.'
        );

        $response = $this->get(route('dutaolahraga.daftar'));

        $response->assertOk();
        $response->assertSee('Daftar Menjadi Duta Olahraga');
        $response->assertSee('Pendaftaran Duta Olahraga');
        $this->assertGuest();
    }

    // =====================================================================
    // 2. VALIDASI PER LANGKAH
    // =====================================================================

    public function test_langkah_satu_wajib_mengisi_nama_jenis_kelamin_dan_tanggal_lahir(): void
    {
        Livewire::test(DutaOlahragaDaftar::class)
            ->call('nextStep')
            ->assertSet('currentStep', 1)
            ->assertHasErrors(['nama_lengkap', 'jenis_kelamin', 'tanggal_lahir']);
    }

    public function test_langkah_dua_wajib_mengisi_domisili_dan_kontak(): void
    {
        Livewire::test(DutaOlahragaDaftar::class)
            ->set('nama_lengkap', 'Calon Duta Validasi')
            ->set('jenis_kelamin', 'P')
            ->set('tanggal_lahir', '1997-02-20')
            ->call('nextStep')
            ->assertSet('currentStep', 2)
            ->assertHasNoErrors()
            ->call('nextStep')
            ->assertSet('currentStep', 2)
            ->assertHasErrors([
                'kecamatan_id',
                'desa_kelurahan_id',
                'alamat_domisili',
                'nomor_telepon',
                'email',
            ]);
    }

    // =====================================================================
    // 3. EARLY-SUBMIT GUARD
    // =====================================================================

    public function test_submit_di_langkah_awal_hanya_memajukan_wizard_tanpa_menyimpan_data(): void
    {
        $email = 'dini.' . Str::lower(Str::random(10)) . '@example.test';
        $jumlahDutaSebelum = DutaOlahraga::count();
        $jumlahPenggunaSebelum = Pengguna::count();

        Livewire::test(DutaOlahragaDaftar::class)
            ->set([
                'nama_lengkap'  => 'Calon Duta Submit Dini',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1996-04-12',
                'email'         => $email,
            ])
            ->assertSet('currentStep', 1)
            ->call('submit')
            ->assertSet('currentStep', 2)
            ->assertSet('berhasil', false)
            ->assertHasNoErrors();

        $this->assertSame(
            $jumlahDutaSebelum,
            DutaOlahraga::count(),
            'Submit dini tidak boleh membuat data pendaftaran.'
        );
        $this->assertSame(
            $jumlahPenggunaSebelum,
            Pengguna::count(),
            'Submit dini tidak boleh membuat akun pengguna.'
        );
        $this->assertDatabaseMissing('kormi_duta_olahraga', ['email' => $email]);
        $this->assertDatabaseMissing('sys_pengguna', ['email' => $email]);
    }

    // =====================================================================
    // 4. SUBMISSION GUEST BERHASIL
    // =====================================================================

    public function test_guest_dapat_mendaftar_dan_akun_dibuat_nonaktif(): void
    {
        $data = $this->dataPendaftaranValid();

        $this->kirimPendaftaran($data)
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $duta = DutaOlahraga::where('email', $data['email'])->first();
        $this->assertNotNull($duta, 'Data duta seharusnya tersimpan.');
        $this->assertSame(DutaOlahraga::STATUS_MENUNGGU, $duta->status_pendaftaran);
        $this->assertFalse((bool) $duta->status_aktif);
        $this->assertSame(now()->year, (int) $duta->tahun_pemilihan);

        $pengguna = Pengguna::where('email', $data['email'])->first();
        $this->assertNotNull($pengguna, 'Akun pengguna guest seharusnya dibuat.');
        $this->assertFalse((bool) $pengguna->status_aktif);
        $this->assertNull($pengguna->duta_id, 'Penautan akun tamu ditunda sampai approval.');
        $this->assertSame('duta-olahraga', $pengguna->peran?->slug);
        $this->assertTrue(Hash::check($data['kata_sandi'], $pengguna->kata_sandi));
        $this->assertSame($pengguna->id, $duta->pengguna_id);

        // Guest tidak otomatis login setelah mendaftar.
        $this->assertGuest();

        // Pendaftaran yang masih menunggu tidak boleh bocor ke direktori publik.
        $response = $this->get(route('dutaolahraga'));
        $response->assertOk();
        $response->assertDontSee($data['nama_lengkap']);
    }

    public function test_bank_dan_nomor_rekening_divalidasi_dan_tersimpan(): void
    {
        $data = $this->dataPendaftaranValid();

        $komponen = Livewire::test(DutaOlahragaDaftar::class)
            ->set($data)
            ->set('currentStep', 3)
            ->set('nama_bank', 'Bank Tidak Dikenal')
            ->call('nextStep')
            ->assertHasErrors('nama_bank');

        $komponen
            ->set('nama_bank', 'Bank BJB')
            ->set('nomor_rekening', 'bukan-angka')
            ->call('nextStep')
            ->assertHasErrors('nomor_rekening');

        $komponen
            ->set('nomor_rekening', '1234567890')
            ->call('nextStep')
            ->assertHasNoErrors()
            ->set('currentStep', 4)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $duta = DutaOlahraga::where('email', $data['email'])->first();
        $this->assertNotNull($duta);
        $this->assertSame('Bank BJB', $duta->nama_bank);
        $this->assertSame('1234567890', $duta->nomor_rekening);
    }

    // =====================================================================
    // 5. DUPLIKAT EMAIL
    // =====================================================================

    public function test_email_yang_sudah_terdaftar_ditolak(): void
    {
        $email = 'duplikat.' . Str::lower(Str::random(10)) . '@example.test';
        $this->buatPengguna(['email' => $email]);

        $this->kirimPendaftaran($this->dataPendaftaranValid(['email' => $email]))
            ->assertHasErrors(['email'])
            ->assertSet('berhasil', false);

        $this->assertDatabaseMissing('kormi_duta_olahraga', ['email' => $email]);
        $this->assertSame(1, Pengguna::where('email', $email)->count());
    }

    // =====================================================================
    // 6. FOTO INVALID
    // =====================================================================

    public function test_foto_bukan_gambar_ditolak_tanpa_membuat_data(): void
    {
        $data = $this->dataPendaftaranValid();

        $this->kirimPendaftaran($data, [
            'foto' => UploadedFile::fake()->create('dokumen.pdf', 50, 'application/pdf'),
        ])
            ->assertHasErrors(['foto'])
            ->assertSet('berhasil', false);

        $this->assertDatabaseMissing('kormi_duta_olahraga', ['email' => $data['email']]);
        $this->assertDatabaseMissing('sys_pengguna', ['email' => $data['email']]);
    }

    // =====================================================================
    // 7. FOTO VALID
    // =====================================================================

    public function test_foto_valid_tersimpan_dan_pendaftaran_berhasil(): void
    {
        $data = $this->dataPendaftaranValid();

        $this->kirimPendaftaran($data, [
            'foto' => UploadedFile::fake()->image('duta.jpg'),
        ])
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $duta = DutaOlahraga::where('email', $data['email'])->first();
        $this->assertNotNull($duta);
        $this->assertNotEmpty($duta->foto_url, 'foto_url seharusnya terisi setelah upload foto valid.');
        Storage::disk('minio')->assertExists($duta->foto_url);
    }

    // =====================================================================
    // 8. PRIVASI DIREKTORI PUBLIK
    // =====================================================================

    public function test_direktori_publik_hanya_menampilkan_duta_disetujui_dan_aktif(): void
    {
        $suffix = Str::upper(Str::random(6));

        // Prefix "AAA/AAB/AAC" agar berada di halaman pertama (data seed berjumlah 100+).
        $disetujui = $this->buatDuta([
            'nama_lengkap'       => 'AAA Duta Disetujui ' . $suffix,
            'status_aktif'       => true,
            'status_pendaftaran' => DutaOlahraga::STATUS_DISETUJUI,
        ]);

        $menunggu = $this->buatDuta([
            'nama_lengkap'       => 'AAB Duta Menunggu ' . $suffix,
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
        ]);

        $ditolak = $this->buatDuta([
            'nama_lengkap'       => 'AAC Duta Ditolak ' . $suffix,
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_DITOLAK,
        ]);

        // Disetujui namun nonaktif juga tidak boleh tampil.
        $disetujuiNonaktif = $this->buatDuta([
            'nama_lengkap'       => 'AAD Duta Disetujui Nonaktif ' . $suffix,
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_DISETUJUI,
        ]);

        $response = $this->get(route('dutaolahraga'));

        $response->assertOk();
        $response->assertSee($disetujui->nama_lengkap);
        $response->assertDontSee($menunggu->nama_lengkap);
        $response->assertDontSee($ditolak->nama_lengkap);
        $response->assertDontSee($disetujuiNonaktif->nama_lengkap);
    }

    // =====================================================================
    // 9. ADMIN MENYETUJUI
    // =====================================================================

    public function test_admin_dapat_menyetujui_pendaftaran_dan_mengaktifkan_akun(): void
    {
        $this->assertNotNull($this->admin, 'Admin fixture tidak tersedia.');
        $this->assertTrue($this->admin->hasRole('super-admin'), 'Fixture admin harus super-admin.');

        $duta = $this->buatDuta([
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
        ]);

        $pengguna = $this->buatPengguna([
            'duta_id'      => $duta->id,
            'status_aktif' => false,
            'peran_id'     => $this->peranDuta->id,
        ]);

        $this->actingAs($this->admin);

        // Catatan: Livewire (SupportRedirects) menghapus session flash pada response
        // non-redirect di environment test, sehingga pesan diverifikasi lewat HTML
        // komponen yang merender session('pesan') pada saat aksi dieksekusi.
        Livewire::test(DutaKelola::class)
            ->call('setujuiPendaftaran', $duta->id)
            ->assertSee('berhasil disetujui dan akun terkait telah diaktifkan');

        $duta->refresh();
        $this->assertSame(DutaOlahraga::STATUS_DISETUJUI, $duta->status_pendaftaran);
        $this->assertTrue((bool) $duta->status_aktif);
        $this->assertNotNull($duta->disetujui_pada);
        $this->assertSame($this->admin->id, $duta->disetujui_oleh);

        $pengguna->refresh();
        $this->assertTrue((bool) $pengguna->status_aktif);
        $this->assertSame($duta->id, $pengguna->duta_id);
        $this->assertNotNull($pengguna->disetujui_pada);
        $this->assertSame($this->admin->id, $pengguna->disetujui_oleh);
    }

    public function test_pratinjau_verifikasi_menampilkan_bank_dan_nomor_rekening(): void
    {
        $duta = $this->buatDuta([
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
            'nama_bank'          => 'Bank BJB',
            'nomor_rekening'     => '9876543210',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(DutaKelola::class)
            ->call('bukaPratinjau', $duta->id)
            ->assertSet('tampilkanModalPratinjau', true)
            ->assertSee('Bank BJB')
            ->assertSee('9876543210');
    }

    public function test_admin_dapat_memperbarui_bank_dan_nomor_rekening_lewat_form_edit(): void
    {
        $duta = $this->buatDuta();

        $this->actingAs($this->admin);

        Livewire::test(DutaKelola::class)
            ->call('bukaFormEdit', $duta->id)
            ->assertSet('nama_bank', '')
            ->set('nama_bank', 'BCA')
            ->set('nomor_rekening', '5550123456')
            ->call('simpan')
            ->assertHasNoErrors();

        $duta->refresh();
        $this->assertSame('BCA', $duta->nama_bank);
        $this->assertSame('5550123456', $duta->nomor_rekening);
    }

    public function test_daftar_duta_menampilkan_bank_dan_nomor_rekening(): void
    {
        $nama = 'Duta Rekening Uji ' . Str::random(6);

        $this->buatDuta([
            'nama_lengkap'   => $nama,
            'nama_bank'      => 'BRI',
            'nomor_rekening' => '1122334455',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(DutaKelola::class)
            ->set('cari', $nama)
            ->assertSee('1122334455')
            ->set('tampilanMode', 'grid')
            ->assertSee('BRI')
            ->assertSee('1122334455');
    }

    // =====================================================================
    // 10. OTORISASI AKSI VERIFIKASI
    // =====================================================================

    public function test_aksi_verifikasi_ditolak_untuk_peran_selain_super_admin_dan_admin_korcam(): void
    {
        $editor = $this->buatPengguna([
            'peran_id'     => $this->peranEditor->id,
            'status_aktif' => true,
        ]);

        $dutaSetuju = $this->buatDuta([
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
        ]);

        $dutaTolak = $this->buatDuta([
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
        ]);

        $this->actingAs($editor);
        $this->assertFalse($editor->hasRole('super-admin', 'admin-korcam'));

        $this->assertAksiVerifikasiDitolak('setujuiPendaftaran', $dutaSetuju->id);
        $this->assertAksiVerifikasiDitolak('tolakPendaftaran', $dutaTolak->id);

        $dutaSetuju->refresh();
        $dutaTolak->refresh();
        $this->assertSame(DutaOlahraga::STATUS_MENUNGGU, $dutaSetuju->status_pendaftaran);
        $this->assertSame(DutaOlahraga::STATUS_MENUNGGU, $dutaTolak->status_pendaftaran);
        $this->assertFalse((bool) $dutaSetuju->status_aktif);
        $this->assertFalse((bool) $dutaTolak->status_aktif);
    }

    /**
     * Panggil aksi verifikasi dan pastikan menghasilkan HTTP 403.
     *
     * Livewire 4 tidak menyediakan assertForbidden sendiri, tetapi Testable
     * mem-proxy method tak dikenal ke Illuminate\Testing\TestResponse milik
     * response Livewire terakhir, sehingga assertForbidden() tetap valid.
     */
    private function assertAksiVerifikasiDitolak(string $aksi, string $dutaId): void
    {
        Livewire::test(DutaKelola::class)
            ->call($aksi, $dutaId)
            ->assertForbidden();
    }

    public function test_admin_korcam_diizinkan_menyetujui_pendaftaran(): void
    {
        $korcam = $this->buatPengguna([
            'peran_id'     => $this->peranKorcam->id,
            'status_aktif' => true,
        ]);

        $duta = $this->buatDuta([
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
        ]);

        $this->actingAs($korcam);

        Livewire::test(DutaKelola::class)
            ->call('setujuiPendaftaran', $duta->id);

        $duta->refresh();
        $this->assertSame(DutaOlahraga::STATUS_DISETUJUI, $duta->status_pendaftaran);
        $this->assertTrue((bool) $duta->status_aktif);
        $this->assertSame($korcam->id, $duta->disetujui_oleh);
    }

    // =====================================================================
    // 11. ADMIN MENOLAK PENDAFTARAN TAMU (AKUN OTOMATIS DIHAPUS)
    // =====================================================================

    public function test_penolakan_guest_menghapus_akun_otomatis_dan_email_bebas_daftar_ulang(): void
    {
        $this->assertNotNull($this->admin, 'Admin fixture tidak tersedia.');

        $data = $this->dataPendaftaranValid();

        $this->kirimPendaftaran($data)
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $duta = DutaOlahraga::where('email', $data['email'])->firstOrFail();
        $pengguna = Pengguna::where('email', $data['email'])->firstOrFail();
        $penggunaId = $pengguna->id;
        $this->assertSame($penggunaId, $duta->pengguna_id);

        $this->actingAs($this->admin);

        Livewire::test(DutaKelola::class)
            ->call('tolakPendaftaran', $duta->id)
            ->assertSee('Akun yang dibuat otomatis telah dihapus');

        $duta->refresh();
        $this->assertSame(DutaOlahraga::STATUS_DITOLAK, $duta->status_pendaftaran);
        $this->assertFalse((bool) $duta->status_aktif);
        $this->assertNull($duta->pengguna_id, 'Tautan ke akun yang dihapus harus dilepas.');

        // Akun tamu otomatis dihapus permanen sehingga email bebas dipakai lagi.
        $this->assertDatabaseMissing('sys_pengguna', ['id' => $penggunaId]);
        $this->assertNull(Pengguna::withTrashed()->find($penggunaId));

        // Daftar ulang dengan email yang sama harus berhasil.
        Auth::logout();
        $this->assertGuest();

        $this->kirimPendaftaran($this->dataPendaftaranValid([
            'email'         => $data['email'],
            'nomor_telepon' => $data['nomor_telepon'],
            'nama_lengkap'  => 'Calon Duta Daftar Ulang',
        ]))
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $dutaBaru = DutaOlahraga::where('email', $data['email'])
            ->where('status_pendaftaran', DutaOlahraga::STATUS_MENUNGGU)
            ->first();

        $this->assertNotNull($dutaBaru, 'Pendaftaran ulang harus membuat data duta baru.');
        $this->assertNotSame($duta->id, $dutaBaru->id);
        $this->assertFalse((bool) $dutaBaru->status_aktif);

        $penggunaBaru = Pengguna::where('email', $data['email'])->first();
        $this->assertNotNull($penggunaBaru, 'Pendaftaran ulang harus membuat akun baru.');
        $this->assertNotSame($penggunaId, $penggunaBaru->id);
        $this->assertSame($penggunaBaru->id, $dutaBaru->pengguna_id);
    }

    // =====================================================================
    // 12. ADMIN MENOLAK PENDAFTARAN PENGGUNA LOGIN (TAUTAN DILEPAS)
    // =====================================================================

    public function test_penolakan_pendaftar_login_melepas_tautan_dan_menurunkan_peran(): void
    {
        $this->assertNotNull($this->admin, 'Admin fixture tidak tersedia.');

        $email = 'pendaftar.login.' . Str::lower(Str::random(8)) . '@example.test';

        // Akun aktif dengan peran duta-olahraga tanpa duta_id (mis. sisa data lama):
        // dipakai agar jalur penurunan peran saat penolakan benar-benar teruji.
        $pengguna = $this->buatPengguna([
            'email'        => $email,
            'peran_id'     => $this->peranDuta->id,
            'status_aktif' => true,
        ]);

        $this->actingAs($pengguna);

        $data = $this->dataPendaftaranValid([
            'email'        => $email,
            'nama_lengkap' => $pengguna->nama_lengkap,
        ]);

        $this->kirimPendaftaran($data)
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $duta = DutaOlahraga::where('email', $email)->firstOrFail();
        $this->assertSame($pengguna->id, $duta->pengguna_id);

        $this->actingAs($this->admin);

        Livewire::test(DutaKelola::class)
            ->call('tolakPendaftaran', $duta->id)
            ->assertSee('Tautan akun pendaftar telah dilepaskan');

        $duta->refresh();
        $this->assertSame(DutaOlahraga::STATUS_DITOLAK, $duta->status_pendaftaran);
        $this->assertFalse((bool) $duta->status_aktif);

        $pengguna->refresh();
        $this->assertNotNull(Pengguna::find($pengguna->id), 'Akun yang sudah ada tidak boleh dihapus.');
        $this->assertNull($pengguna->duta_id);
        $this->assertSame('pegiat-olahraga', $pengguna->peran?->slug, 'Peran duta harus diturunkan ke pegiat.');
        $this->assertTrue((bool) $pengguna->status_aktif, 'Status akun yang sudah aktif tidak boleh berubah.');

        // Daftar ulang sebagai pengguna login diizinkan.
        Auth::logout();
        $this->actingAs($pengguna->fresh());

        $this->kirimPendaftaran($this->dataPendaftaranValid([
            'email'        => $email,
            'nama_lengkap' => $pengguna->nama_lengkap,
        ]))
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $this->assertSame(2, DutaOlahraga::where('email', $email)->count());
        $this->assertSame(
            1,
            DutaOlahraga::where('email', $email)->where('status_pendaftaran', DutaOlahraga::STATUS_MENUNGGU)->count()
        );
    }

    // =====================================================================
    // 13. LOGIN AKUN PENDING DIBLOKIR, SETELAH DISETUJUI DIIZINKAN
    // =====================================================================

    public function test_login_diblokir_saat_pending_dan_diizinkan_setelah_disetujui(): void
    {
        $email = 'calon.duta.' . Str::lower(Str::random(10)) . '@example.test';
        $sandi = 'rahasia12345';

        $pengguna = $this->buatPengguna([
            'email'        => $email,
            'kata_sandi'   => Hash::make($sandi),
            'status_aktif' => false,
        ]);

        $this->post(route('admin.masuk.post'), [
            'email'      => $email,
            'kata_sandi' => $sandi,
        ])->assertSessionHasErrors('email');

        $this->assertGuest();

        $pengguna->update(['status_aktif' => true]);

        $this->post(route('admin.masuk.post'), [
            'email'      => $email,
            'kata_sandi' => $sandi,
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    // =====================================================================
    // 14. PENGHUBUNGAN AKUN YANG SUDAH LOGIN (DEFERRED LINKING)
    // =====================================================================

    public function test_pengguna_login_dihubungkan_tanpa_membuat_akun_baru_dan_status_tetap_aktif(): void
    {
        $email = 'pegiat.hubung.' . Str::lower(Str::random(10)) . '@example.test';

        $pengguna = $this->buatPengguna([
            'email'           => $email,
            'peran_id'        => $this->peranPegiat->id,
            'status_aktif'    => true,
            'jenis_kelamin'   => 'P',
            'tanggal_lahir'   => '1994-09-09',
            'nomor_telepon'   => '081298765432',
            'kecamatan_id'    => $this->kecamatan->id,
            'desa_kelurahan_id' => $this->desa->id,
        ]);

        $jumlahPenggunaSebelum = Pengguna::count();

        $this->actingAs($pengguna);

        $this->kirimPendaftaran($this->dataPendaftaranValid([
            'email'             => $email,
            'nama_lengkap'      => $pengguna->nama_lengkap,
            'jenis_kelamin'     => 'P',
            'tanggal_lahir'     => '1994-09-09',
            'alamat_domisili'   => 'Jl. Penghubungan Akun No. 99',
            'nomor_telepon'     => '081298765432',
        ]))
            ->assertHasNoErrors()
            ->assertSet('berhasil', true);

        $this->assertSame(
            $jumlahPenggunaSebelum,
            Pengguna::count(),
            'Pendaftaran oleh pengguna login tidak boleh membuat akun pengguna baru.'
        );

        $duta = DutaOlahraga::where('email', $email)->firstOrFail();

        // Saat submit: akun sama sekali belum diubah.
        $pengguna->refresh();
        $this->assertNull($pengguna->duta_id, 'Penautan akun ditunda sampai approval.');
        $this->assertSame($this->peranPegiat->id, $pengguna->peran_id, 'Peran tidak boleh berubah saat submit.');
        $this->assertTrue((bool) $pengguna->status_aktif);
        $this->assertNull($pengguna->disetujui_pada);

        $this->assertSame(DutaOlahraga::STATUS_MENUNGGU, $duta->status_pendaftaran);
        $this->assertFalse((bool) $duta->status_aktif);
        $this->assertSame($pengguna->id, $duta->pengguna_id);

        // Setelah disetujui: akun ditautkan, tetap aktif, peran dipromosikan.
        $this->actingAs($this->admin);

        Livewire::test(DutaKelola::class)
            ->call('setujuiPendaftaran', $duta->id);

        $duta->refresh();
        $this->assertSame(DutaOlahraga::STATUS_DISETUJUI, $duta->status_pendaftaran);
        $this->assertTrue((bool) $duta->status_aktif);
        $this->assertNotNull($duta->disetujui_pada);

        $pengguna->refresh();
        $this->assertSame($duta->id, $pengguna->duta_id);
        $this->assertTrue((bool) $pengguna->status_aktif);
        $this->assertSame('duta-olahraga', $pengguna->peran?->slug);
        $this->assertNotNull($pengguna->disetujui_pada, 'disetujui_pada akun harus terisi saat approval.');
        $this->assertSame($this->admin->id, $pengguna->disetujui_oleh);
    }

    // =====================================================================
    // 15. PENGELOLAAN PENGGUNA MENYINKRONKAN PENDAFTARAN DUTA
    // =====================================================================

    public function test_pengguna_kelola_menyetujui_akun_menyinkronkan_pendaftaran_duta(): void
    {
        $this->assertNotNull($this->admin, 'Admin fixture tidak tersedia.');

        $email = 'sinkron.akun.' . Str::lower(Str::random(8)) . '@example.test';

        $duta = $this->buatDuta([
            'email'              => $email,
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
        ]);

        $pengguna = $this->buatPengguna([
            'email'        => $email,
            'peran_id'     => $this->peranDuta->id,
            'status_aktif' => false,
            'duta_id'      => null,
            'disetujui_pada' => null,
        ]);

        $duta->update(['pengguna_id' => $pengguna->id]);

        $this->actingAs($this->admin);

        Livewire::test(PenggunaKelola::class)
            ->call('setujuiAkun', $pengguna->id)
            ->assertSee('berhasil disetujui dan diaktifkan');

        $duta->refresh();
        $this->assertSame(DutaOlahraga::STATUS_DISETUJUI, $duta->status_pendaftaran);
        $this->assertTrue((bool) $duta->status_aktif);
        $this->assertNotNull($duta->disetujui_pada);

        $pengguna->refresh();
        $this->assertTrue((bool) $pengguna->status_aktif);
        $this->assertSame($duta->id, $pengguna->duta_id);
        $this->assertSame('duta-olahraga', $pengguna->peran?->slug);
        $this->assertNotNull($pengguna->disetujui_pada);
        $this->assertSame($this->admin->id, $pengguna->disetujui_oleh);
    }

    // =====================================================================
    // 16. AKSI MASSAL MELEWATI PENDAFTARAN MENUNGGU
    // =====================================================================

    public function test_bulk_toggle_aktif_melewati_pendaftaran_yang_masih_menunggu(): void
    {
        $this->assertNotNull($this->admin, 'Admin fixture tidak tersedia.');

        $duta = $this->buatDuta([
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(DutaKelola::class)
            ->set('selectedDuta', [$duta->id])
            ->call('bulkToggleAktif', true)
            ->assertSee('harus disetujui terlebih dahulu');

        $duta->refresh();
        $this->assertFalse((bool) $duta->status_aktif, 'Pendaftaran menunggu tidak boleh diaktifkan massal.');
        $this->assertSame(DutaOlahraga::STATUS_MENUNGGU, $duta->status_pendaftaran);
    }

    // =====================================================================
    // 17. PEMBATAS LAJU BERBASIS KONTEN (EMAIL + TELEPON)
    // =====================================================================

    public function test_pendaftaran_dengan_email_dan_telepon_sama_dibatasi_setelah_tiga_kali(): void
    {
        $this->assertNotNull($this->admin, 'Admin fixture tidak tersedia.');

        $email = 'batas.konten.' . Str::lower(Str::random(8)) . '@example.test';
        $telepon = '081277778899';

        RateLimiter::clear('duta-daftar:127.0.0.1');
        RateLimiter::clear($this->kunciKonten($email, $telepon));

        $data = $this->dataPendaftaranValid([
            'email'         => $email,
            'nomor_telepon' => $telepon,
        ]);

        // Tiga pendaftaran sah (ditolak admin di antaranya agar email kembali bebas).
        for ($i = 1; $i <= 3; $i++) {
            $this->kirimPendaftaran($data)
                ->assertHasNoErrors()
                ->assertSet('berhasil', true);

            $duta = DutaOlahraga::where('email', $email)
                ->where('status_pendaftaran', DutaOlahraga::STATUS_MENUNGGU)
                ->firstOrFail();

            $this->actingAs($this->admin);
            Livewire::test(DutaKelola::class)->call('tolakPendaftaran', $duta->id);

            $duta->refresh();
            $this->assertSame(DutaOlahraga::STATUS_DITOLAK, $duta->status_pendaftaran);

            Auth::logout();
            $this->assertGuest();
        }

        $this->assertSame(3, DutaOlahraga::where('email', $email)->count());

        // Percobaan ke-4 diblokir oleh pembatas konten sebelum data disimpan.
        $this->kirimPendaftaran($data)
            ->assertHasErrors(['pendaftaran'])
            ->assertSet('berhasil', false)
            ->assertSee('sudah terlalu sering');

        $this->assertSame(
            3,
            DutaOlahraga::where('email', $email)->count(),
            'Pendaftaran ke-4 tidak boleh tersimpan.'
        );
        $this->assertDatabaseMissing('sys_pengguna', ['email' => $email]);
    }

    // =====================================================================
    // 18. HALAMAN ADMIN DUTA MENAMPILKAN BANNER PENDAFTARAN MENUNGGU
    // =====================================================================

    public function test_halaman_admin_duta_menampilkan_banner_pendaftaran_menunggu(): void
    {
        $this->assertNotNull($this->admin, 'Admin fixture tidak tersedia.');

        $this->buatDuta([
            'status_aktif'       => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
        ]);

        $this->actingAs($this->admin);

        $response = $this->get('/admin/duta');

        $response->assertOk();
        $response->assertSee('Tinjau Pendaftaran');
        $response->assertSee('menunggu verifikasi');
        $response->assertSee('menunggu');
    }
}
