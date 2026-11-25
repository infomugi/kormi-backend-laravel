<?php

namespace Tests\Feature;

use App\Livewire\Backend\Kormi\Apmo\ApmoSurveiWilayah;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\AngketApmo;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class ApmoSurveiWilayahTest extends TestCase
{
    use DatabaseTransactions;

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

        $this->superAdmin = $this->buatPengguna('Super Uji Monitoring', $peranSuper->id);
        $this->pegiat = $this->buatPengguna('Pegiat Uji Monitoring', $peranPegiat->id);

        $this->kecamatan = Kecamatan::create([
            'nama_kecamatan' => 'Kecamatan Uji Monitor ' . Str::random(4),
            'slug' => 'kecamatan-uji-monitor-' . Str::lower(Str::random(6)),
        ]);

        $this->desa = DesaKelurahan::create([
            'kecamatan_id' => $this->kecamatan->id,
            'nama_desa_kelurahan' => 'Desa Uji Monitor ' . Str::random(4),
            'slug' => 'desa-uji-monitor-' . Str::lower(Str::random(6)),
            'jenis' => 'desa',
        ]);
    }

    private function buatPengguna(string $nama, string $peranId): Pengguna
    {
        return Pengguna::create([
            'peran_id' => $peranId,
            'nama_lengkap' => $nama,
            'email' => 'uji.monitor.' . uniqid() . '@contoh.id',
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

    public function test_halaman_monitoring_hanya_untuk_super_admin(): void
    {
        $this->actingAs($this->pegiat)
            ->get(route('admin.apmo.wilayah'))
            ->assertForbidden();

        $this->actingAs($this->superAdmin)
            ->get(route('admin.apmo.wilayah'))
            ->assertOk()
            ->assertSee('Monitoring Survei APMO per Wilayah');
    }

    public function test_kecamatan_dan_desa_tanpa_isian_ditandai_belum_input(): void
    {
        $this->buatIsian($this->pegiat);

        $this->actingAs($this->superAdmin);

        Livewire::test(ApmoSurveiWilayah::class)
            ->assertSet('tab', 'kecamatan')
            ->assertSee($this->kecamatan->nama_kecamatan)
            ->assertSee('Sudah input')
            ->assertSee('Belum input')
            ->assertSee('bg-rose-50/70', false);

        Livewire::test(ApmoSurveiWilayah::class)
            ->call('pilihTab', 'desa')
            ->assertSet('tab', 'desa')
            ->assertSee($this->desa->nama_desa_kelurahan)
            ->assertSee($this->kecamatan->nama_kecamatan);
    }

    public function test_urutkan_berdasarkan_nama_dan_total(): void
    {
        $kecamatanKosong = Kecamatan::create([
            'nama_kecamatan' => 'Kecamatan Uji Zeta ' . Str::random(4),
            'slug' => 'kecamatan-uji-zeta-' . Str::lower(Str::random(6)),
        ]);

        $this->buatIsian($this->pegiat);

        $this->actingAs($this->superAdmin);

        $komponen = Livewire::test(ApmoSurveiWilayah::class)
            ->call('urutkan', 'total')
            ->assertSet('urut', 'total')
            ->assertSet('arah', 'desc');

        $html = $komponen->html();
        $this->assertLessThan(
            strpos($html, 'Kec. ' . $kecamatanKosong->nama_kecamatan),
            strpos($html, 'Kec. ' . $this->kecamatan->nama_kecamatan),
            'Wilayah dengan isian terbanyak harus muncul lebih dulu saat diurutkan menurun.'
        );

        $komponen->call('urutkan', 'total')->assertSet('arah', 'asc');

        $html = $komponen->html();
        $this->assertGreaterThan(
            strpos($html, 'Kec. ' . $kecamatanKosong->nama_kecamatan),
            strpos($html, 'Kec. ' . $this->kecamatan->nama_kecamatan),
            'Wilayah tanpa isian harus muncul lebih dulu saat diurutkan menaik.'
        );

        $komponen->call('urutkan', 'nama')->assertSet('urut', 'nama')->assertSet('arah', 'asc');

        $html = $komponen->html();
        $this->assertLessThan(
            strpos($html, 'Kec. ' . $kecamatanKosong->nama_kecamatan),
            strpos($html, 'Kec. ' . $this->kecamatan->nama_kecamatan),
            'Urutan nama menaik harus mengikuti abjad.'
        );
    }

    public function test_pencarian_wilayah_menyaring_baris(): void
    {
        $kecamatanLain = Kecamatan::create([
            'nama_kecamatan' => 'Kecamatan Lain Uji ' . Str::random(4),
            'slug' => 'kecamatan-lain-uji-' . Str::lower(Str::random(6)),
        ]);

        $this->actingAs($this->superAdmin);

        Livewire::test(ApmoSurveiWilayah::class)
            ->set('cari', $this->kecamatan->nama_kecamatan)
            ->assertSee($this->kecamatan->nama_kecamatan)
            ->assertDontSee($kecamatanLain->nama_kecamatan)
            ->set('cari', 'nama-yang-tidak-ada-xyz')
            ->assertSee('Tidak ada wilayah yang cocok');
    }
}
