<?php

namespace Tests\Feature;

use App\Livewire\Backend\Kormi\Partisipasi\PartisipasiKelola;
use App\Livewire\Backend\Kormi\Partisipasi\PartisipasiStatistik;
use App\Livewire\Backend\Pengguna\PenggunaKelola;
use App\Livewire\Frontend\Kormi\Partisipasi\PartisipasiDutaInput;
use App\Livewire\Frontend\Kormi\Partisipasi\PartisipasiInput;
use App\Livewire\Frontend\Kormi\Partisipasi\PartisipasiRiwayat;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\Inorga;
use App\Models\Kormi\PartisipasiAktivitas;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class PartisipasiAktivitasTest extends TestCase
{
    use DatabaseTransactions;

    protected Pengguna $admin;
    protected Pengguna $warga;
    protected Pengguna $duta;
    protected Kecamatan $kecamatan;
    protected DesaKelurahan $desa;
    protected ?Inorga $inorga;

    protected function setUp(): void
    {
        parent::setUp();

        \Illuminate\Support\Facades\Storage::fake('minio');
        \Illuminate\Support\Facades\Storage::fake('public');

        $this->admin = Pengguna::where('email', 'admin@kormibdg.id')->first() ?? Pengguna::first();
        $this->kecamatan = Kecamatan::first() ?? Kecamatan::create(['kode_kecamatan' => '32.04.99', 'nama_kecamatan' => 'Kecamatan Uji']);
        $this->desa = DesaKelurahan::where('kecamatan_id', $this->kecamatan->id)->first() ?? DesaKelurahan::create([
            'kecamatan_id' => $this->kecamatan->id,
            'kode_desa' => '32.04.99.2001',
            'nama_desa' => 'Desa Uji'
        ]);
        $this->inorga = Inorga::first();

        // Pastikan peran pegiat & duta ada
        $peranPegiat = Peran::firstOrCreate(['slug' => 'pegiat-olahraga'], ['nama_peran' => 'Pegiat Olahraga', 'deskripsi' => 'Warga']);
        $peranDuta = Peran::firstOrCreate(['slug' => 'duta-olahraga'], ['nama_peran' => 'Duta Olahraga', 'deskripsi' => 'Duta']);

        // Buat akun warga
        $this->warga = Pengguna::create([
            'nama_lengkap' => 'Warga Pegiat Test',
            'email' => 'warga_' . uniqid() . '@kormibdg.id',
            'kata_sandi' => bcrypt('password123'),
            'peran_id' => $peranPegiat->id,
            'nik' => '320499' . rand(1000000000, 9999999999),
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1995-05-15',
            'kecamatan_id' => $this->kecamatan->id,
            'desa_kelurahan_id' => $this->desa->id,
            'status_aktif' => true,
            'disetujui_pada' => now(),
            'disetujui_oleh' => $this->admin->id,
        ]);

        // Buat akun duta olahraga
        $this->duta = Pengguna::create([
            'nama_lengkap' => 'Duta Olahraga Test',
            'email' => 'duta_' . uniqid() . '@kormibdg.id',
            'kata_sandi' => bcrypt('password123'),
            'peran_id' => $peranDuta->id,
            'nik' => '320488' . rand(1000000000, 9999999999),
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '1998-08-17',
            'kecamatan_id' => $this->kecamatan->id,
            'desa_kelurahan_id' => $this->desa->id,
            'status_aktif' => true,
            'disetujui_pada' => now(),
            'disetujui_oleh' => $this->admin->id,
        ]);
    }

    public function test_admin_can_approve_pending_user(): void
    {
        // Buat user pending
        $pendingUser = Pengguna::create([
            'nama_lengkap' => 'Calon Pegiat Menunggu Approval',
            'email' => 'pending_' . uniqid() . '@kormibdg.id',
            'kata_sandi' => bcrypt('password123'),
            'peran_id' => Peran::first()->id,
            'status_aktif' => false,
            'disetujui_pada' => null,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(PenggunaKelola::class)
            ->call('setujuiAkun', $pendingUser->id)
            ->assertHasNoErrors();

        $pendingUser->refresh();
        $this->assertTrue((bool)$pendingUser->status_aktif);
        $this->assertNotNull($pendingUser->disetujui_pada);
        $this->assertEquals($this->admin->id, $pendingUser->disetujui_oleh);
    }

    public function test_citizen_can_log_personal_sports_activity(): void
    {
        $this->actingAs($this->warga);

        Livewire::test(PartisipasiInput::class)
            ->set('tanggal_aktivitas', now()->toDateString())
            ->set('nama_aktivitas', 'Senam Pagi Bersama Warga RT 05')
            ->set('durasi_menit', 60)
            ->set('kategori_lokasi', 'lapangan_desa')
            ->set('nama_tempat', 'Lapangan Balai RW 05')
            ->set('kecamatan_id', $this->kecamatan->id)
            ->set('desa_kelurahan_id', $this->desa->id)
            ->set('inorga_id', $this->inorga?->id)
            ->set('catatan', 'Senam sehat 1 jam')
            ->call('simpan')
            ->assertHasNoErrors()
            ->assertSet('berhasilSimpan', true);

        $this->assertDatabaseHas('kormi_partisipasi_aktivitas', [
            'pengguna_id' => $this->warga->id,
            'metode_pencatatan' => 'mandiri',
            'nama_aktivitas' => 'Senam Pagi Bersama Warga RT 05',
            'durasi_menit' => 60,
            'status_verifikasi' => 'valid',
        ]);
    }

    public function test_duta_olahraga_can_log_mass_community_activity(): void
    {
        $this->actingAs($this->duta);

        Livewire::test(PartisipasiDutaInput::class)
            ->set('tanggal_aktivitas', now()->toDateString())
            ->set('nama_aktivitas', 'Festival Hadang & Dagongan Pemuda Desa')
            ->set('durasi_menit', 120)
            ->set('jenis_partisipasi', 'massal_komunitas')
            ->set('jumlah_peserta', 75)
            ->set('kategori_lokasi', 'lapangan_desa')
            ->set('nama_tempat', 'Alun-alun Kecamatan')
            ->set('kecamatan_id', $this->kecamatan->id)
            ->set('desa_kelurahan_id', $this->desa->id)
            ->set('inorga_id', $this->inorga?->id)
            ->set('foto_kegiatan', \Illuminate\Http\UploadedFile::fake()->image('kegiatan.jpg'))
            ->set('catatan', 'Diikuti karang taruna se-desa')
            ->call('simpan')
            ->assertHasNoErrors()
            ->assertSet('berhasilSimpan', true);

        $this->assertDatabaseHas('kormi_partisipasi_aktivitas', [
            'pengguna_id' => $this->duta->id,
            'metode_pencatatan' => 'via_duta',
            'nama_aktivitas' => 'Festival Hadang & Dagongan Pemuda Desa',
            'jumlah_peserta' => 75,
            'durasi_menit' => 120,
            'status_verifikasi' => 'valid',
        ]);
    }

    public function test_user_can_view_participation_history(): void
    {
        // Buat data partisipasi
        PartisipasiAktivitas::create([
            'pengguna_id' => $this->warga->id,
            'metode_pencatatan' => 'mandiri',
            'tanggal_aktivitas' => now()->toDateString(),
            'nama_aktivitas' => 'Jalan Santai Sore',
            'durasi_menit' => 45,
            'nama_tempat' => 'Taman Kota',
            'kecamatan_id' => $this->kecamatan->id,
            'status_verifikasi' => 'valid',
        ]);

        $this->actingAs($this->warga);

        Livewire::test(PartisipasiRiwayat::class)
            ->assertSee('Jalan Santai Sore')
            ->assertSee('45 Menit');
    }

    public function test_admin_can_manage_and_verify_participation_logs(): void
    {
        $log = PartisipasiAktivitas::create([
            'pengguna_id' => $this->warga->id,
            'metode_pencatatan' => 'mandiri',
            'tanggal_aktivitas' => now()->toDateString(),
            'nama_aktivitas' => 'Aerobik Bersama',
            'durasi_menit' => 60,
            'nama_tempat' => 'GOR Bulutangkis',
            'kecamatan_id' => $this->kecamatan->id,
            'status_verifikasi' => 'pending_review',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(PartisipasiKelola::class)
            ->assertSee('Aerobik Bersama')
            ->call('verifikasi', $log->id, 'valid')
            ->assertHasNoErrors();

        $log->refresh();
        $this->assertEquals('valid', $log->status_verifikasi);
        $this->assertEquals($this->admin->id, $log->diverifikasi_oleh);
    }

    public function test_admin_can_view_apmo_statistics(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PartisipasiStatistik::class)
            ->assertSee('Dashboard Statistik APMO')
            ->assertSee('Akumulasi Jam');
    }
}
