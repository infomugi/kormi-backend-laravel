<?php

namespace Tests\Feature;

use App\Livewire\Mobile\ApmoWilayah;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\AngketApmo;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class MobileApmoWilayahTest extends TestCase
{
    use DatabaseTransactions;

    private const UA_MOBILE = 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1';

    protected Pengguna $superAdmin;

    protected Pengguna $pegiat;

    protected Kecamatan $kecamatan;

    protected DesaKelurahan $desa;

    protected function setUp(): void
    {
        parent::setUp();

        $peranSuper = Peran::firstOrCreate(
            ['slug' => 'super-admin'],
            ['nama_peran' => 'Super Administrator', 'deskripsi' => 'Akses penuh sistem']
        );

        $peranPegiat = Peran::firstOrCreate(
            ['slug' => 'pegiat-olahraga'],
            ['nama_peran' => 'Masyarakat / Pegiat Olahraga', 'deskripsi' => 'Warga']
        );

        $this->superAdmin = $this->buatPengguna('Super Uji Mobile Monitor', $peranSuper->id);
        $this->pegiat = $this->buatPengguna('Pegiat Uji Mobile Monitor', $peranPegiat->id);

        $this->kecamatan = Kecamatan::create([
            'nama_kecamatan' => 'Kecamatan Mobile Uji '.Str::random(4),
            'slug' => 'kecamatan-mobile-uji-'.Str::lower(Str::random(6)),
        ]);

        $this->desa = DesaKelurahan::create([
            'kecamatan_id' => $this->kecamatan->id,
            'nama_desa_kelurahan' => 'Desa Mobile Uji '.Str::random(4),
            'slug' => 'desa-mobile-uji-'.Str::lower(Str::random(6)),
            'jenis' => 'desa',
        ]);
    }

    private function buatPengguna(string $nama, string $peranId): Pengguna
    {
        return Pengguna::create([
            'peran_id' => $peranId,
            'nama_lengkap' => $nama,
            'email' => 'uji.mobile.monitor.'.uniqid().'@contoh.id',
            'kata_sandi' => 'rahasia-uji-123',
            'status_aktif' => true,
        ]);
    }

    private function buatIsian(Pengguna $pengguna): AngketApmo
    {
        return AngketApmo::create([
            'pengguna_id' => $pengguna->id,
            'nama_lengkap' => $pengguna->nama_lengkap,
            'usia' => 30,
            'jenis_kelamin' => 'pria',
            'alamat' => 'Alamat uji',
            'kecamatan' => $this->kecamatan->nama_kecamatan,
            'desa' => $this->desa->nama_desa_kelurahan,
            'pekerjaan' => 'lainnya',
            'melakukan_olahraga' => true,
        ]);
    }

    public function test_halaman_mobile_hanya_untuk_super_admin(): void
    {
        $this->actingAs($this->pegiat)
            ->get(route('mobile.apmo.wilayah'))
            ->assertForbidden();

        $this->actingAs($this->superAdmin)
            ->get(route('mobile.apmo.wilayah'))
            ->assertOk()
            ->assertSee('Monitoring APMO')
            ->assertSee('kd-apmo-wilayah', false)
            ->assertSee('kd-tabbar', false);
    }

    public function test_halaman_admin_mengalihkan_pengunjung_mobile(): void
    {
        $this->actingAs($this->superAdmin)
            ->withHeader('User-Agent', self::UA_MOBILE)
            ->get(route('admin.apmo.wilayah'))
            ->assertRedirect(route('mobile.apmo.wilayah'));
    }

    public function test_kecamatan_tanpa_isian_ditandai_merah(): void
    {
        $this->buatIsian($this->pegiat);

        $this->actingAs($this->superAdmin);

        Livewire::test(ApmoWilayah::class)
            ->assertSet('tab', 'kecamatan')
            ->assertSee($this->kecamatan->nama_kecamatan)
            ->assertSee('Sudah')
            ->assertSee('Belum')
            ->assertSee('is-empty', false);

        Livewire::test(ApmoWilayah::class)
            ->call('pilihTab', 'desa')
            ->assertSet('tab', 'desa')
            ->set('cari', $this->desa->nama_desa_kelurahan)
            ->assertSee($this->desa->nama_desa_kelurahan)
            ->assertSee($this->kecamatan->nama_kecamatan);
    }

    public function test_urutkan_nama_dan_jumlah_isian(): void
    {
        $kecamatanKosong = Kecamatan::create([
            'nama_kecamatan' => 'Kecamatan Mobile Zeta '.Str::random(4),
            'slug' => 'kecamatan-mobile-zeta-'.Str::lower(Str::random(6)),
        ]);

        $this->buatIsian($this->pegiat);

        $this->actingAs($this->superAdmin);

        $komponen = Livewire::test(ApmoWilayah::class)
            ->call('urutkan', 'total')
            ->assertSet('urut', 'total')
            ->assertSet('arah', 'desc');

        $html = $komponen->html();
        $this->assertLessThan(
            strpos($html, 'Kec. '.$kecamatanKosong->nama_kecamatan),
            strpos($html, 'Kec. '.$this->kecamatan->nama_kecamatan),
            'Wilayah dengan isian terbanyak harus muncul lebih dulu saat diurutkan menurun.'
        );

        $komponen->call('urutkan', 'total')->assertSet('arah', 'asc');

        $html = $komponen->html();
        $this->assertGreaterThan(
            strpos($html, 'Kec. '.$kecamatanKosong->nama_kecamatan),
            strpos($html, 'Kec. '.$this->kecamatan->nama_kecamatan),
            'Wilayah tanpa isian harus muncul lebih dulu saat diurutkan menaik.'
        );

        $komponen->call('urutkan', 'nama')->assertSet('urut', 'nama')->assertSet('arah', 'asc');

        $html = $komponen->html();
        $this->assertLessThan(
            strpos($html, 'Kec. '.$kecamatanKosong->nama_kecamatan),
            strpos($html, 'Kec. '.$this->kecamatan->nama_kecamatan),
            'Urutan nama menaik harus mengikuti abjad.'
        );
    }

    public function test_pencarian_dan_muat_lebih_banyak(): void
    {
        $kecamatanLain = Kecamatan::create([
            'nama_kecamatan' => 'Kecamatan Mobile Lain '.Str::random(4),
            'slug' => 'kecamatan-mobile-lain-'.Str::lower(Str::random(6)),
        ]);

        $this->actingAs($this->superAdmin);

        Livewire::test(ApmoWilayah::class)
            ->call('pilihTab', 'desa')
            ->assertSet('batas', 40)
            ->call('muatLagi')
            ->assertSet('batas', 80)
            ->set('cari', $this->desa->nama_desa_kelurahan)
            ->assertSet('batas', 40)
            ->assertSee($this->desa->nama_desa_kelurahan)
            ->assertDontSee($kecamatanLain->nama_kecamatan)
            ->set('cari', 'nama-yang-tidak-ada-xyz')
            ->assertSee('Tidak ada wilayah yang cocok');
    }
}
