<?php

namespace Tests\Feature;

use App\Livewire\Mobile\Dashboard;
use App\Livewire\Mobile\Persetujuan;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class MobilePersetujuanTest extends TestCase
{
    use DatabaseTransactions;

    protected Pengguna $superAdmin;
    protected Peran $peranSuper;
    protected Peran $peranPegiat;
    protected Kecamatan $kecamatan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->peranSuper = Peran::firstOrCreate(
            ['slug' => 'super-admin'],
            ['nama_peran' => 'Super Administrator', 'deskripsi' => 'Akses penuh sistem']
        );

        $this->peranPegiat = Peran::firstOrCreate(
            ['slug' => 'pegiat-olahraga'],
            ['nama_peran' => 'Masyarakat / Pegiat Olahraga', 'deskripsi' => 'Warga']
        );

        $this->superAdmin = $this->buatPengguna('Super Uji Persetujuan', $this->peranSuper->id);

        $this->kecamatan = Kecamatan::first() ?? Kecamatan::create([
            'nama_kecamatan' => 'Kecamatan Uji Setuju',
            'slug' => 'kecamatan-uji-setuju-' . Str::lower(Str::random(6)),
        ]);
    }

    private function buatPengguna(string $nama, string $peranId, bool $aktif = true): Pengguna
    {
        return Pengguna::create([
            'peran_id' => $peranId,
            'nama_lengkap' => $nama,
            'email' => 'uji.setuju.' . uniqid() . '@contoh.id',
            'kata_sandi' => 'rahasia-uji-123',
            'status_aktif' => $aktif,
        ]);
    }

    private function buatDutaMenunggu(Pengguna $akun, string $nama = 'Duta Uji Setuju'): DutaOlahraga
    {
        $desa = DesaKelurahan::where('kecamatan_id', $this->kecamatan->id)->first()
            ?? DesaKelurahan::create([
                'kecamatan_id' => $this->kecamatan->id,
                'nama_desa_kelurahan' => 'Desa Uji Setuju',
                'slug' => 'desa-uji-setuju-' . Str::lower(Str::random(6)),
                'jenis' => 'desa',
            ]);

        return DutaOlahraga::create([
            'kecamatan_id' => $this->kecamatan->id,
            'desa_kelurahan_id' => $desa->id,
            'nama_lengkap' => $nama,
            'tahun_pemilihan' => 2026,
            'kategori_duta' => 'Duta Olahraga Masyarakat',
            'nomor_telepon' => '081200009999',
            'email' => $akun->email,
            'status_aktif' => false,
            'status_pendaftaran' => DutaOlahraga::STATUS_MENUNGGU,
            'pengguna_id' => $akun->id,
        ]);
    }

    public function test_halaman_persetujuan_hanya_untuk_super_admin(): void
    {
        $pegiat = $this->buatPengguna('Pegiat Uji', $this->peranPegiat->id);

        $this->actingAs($pegiat)
            ->get(route('mobile.persetujuan'))
            ->assertForbidden();

        $this->actingAs($this->superAdmin)
            ->get(route('mobile.persetujuan'))
            ->assertOk()
            ->assertSee('Persetujuan');
    }

    public function test_dashboard_super_admin_menampilkan_antrean_persetujuan(): void
    {
        $akunDuta = $this->buatPengguna('Akun Pendaftar Uji', $this->peranPegiat->id, false);
        $this->buatDutaMenunggu($akunDuta, 'Duta Antrean Uji');
        $this->buatPengguna('Akun Mandiri Uji', $this->peranPegiat->id, false);

        $this->actingAs($this->superAdmin)
            ->get(route('mobile.dashboard'))
            ->assertOk()
            ->assertSee('Persetujuan')
            ->assertSee('Duta Antrean Uji')
            ->assertSee('Akun Mandiri Uji')
            ->assertDontSee('Akun Pendaftar Uji');
    }

    public function test_setujui_duta_dari_dashboard_mengaktifkan_akun_dan_menautkan(): void
    {
        $akun = $this->buatPengguna('Akun Duta Uji', $this->peranPegiat->id, false);
        $duta = $this->buatDutaMenunggu($akun, 'Duta Disetujui Uji');

        $this->actingAs($this->superAdmin);

        Livewire::test(Dashboard::class)
            ->call('setujuiDuta', $duta->id)
            ->assertSet('galatPersetujuan', false);

        $duta->refresh();
        $akun->refresh();

        $this->assertSame(DutaOlahraga::STATUS_DISETUJUI, $duta->status_pendaftaran);
        $this->assertTrue((bool) $duta->status_aktif);
        $this->assertSame($this->superAdmin->id, $duta->disetujui_oleh);

        $this->assertTrue((bool) $akun->status_aktif);
        $this->assertNotNull($akun->disetujui_pada);
        $this->assertSame($duta->id, $akun->duta_id);
        $this->assertSame('duta-olahraga', $akun->peran?->slug);
    }

    public function test_tolak_duta_dari_halaman_menyimpan_catatan_dan_menghapus_akun_otomatis(): void
    {
        $akun = $this->buatPengguna('Akun Ditolak Uji', $this->peranPegiat->id, false);
        $duta = $this->buatDutaMenunggu($akun, 'Duta Ditolak Uji');

        $this->actingAs($this->superAdmin);

        Livewire::test(Persetujuan::class)
            ->call('mulaiTolak', $duta->id)
            ->set('catatan', 'Data prestasi belum lengkap')
            ->call('tolakDuta')
            ->assertSet('galat', null);

        $duta->refresh();

        $this->assertSame(DutaOlahraga::STATUS_DITOLAK, $duta->status_pendaftaran);
        $this->assertFalse((bool) $duta->status_aktif);
        $this->assertSame('Data prestasi belum lengkap', $duta->catatan_verifikasi);
        $this->assertNull($duta->pengguna_id);
        $this->assertDatabaseMissing('sys_pengguna', ['id' => $akun->id, 'dihapus_pada' => null]);
    }

    public function test_setujui_akun_dari_halaman_menyinkronkan_pendaftaran_duta(): void
    {
        $akun = $this->buatPengguna('Akun Sinkron Uji', $this->peranPegiat->id, false);
        $duta = $this->buatDutaMenunggu($akun, 'Duta Sinkron Uji');

        $this->actingAs($this->superAdmin);

        Livewire::test(Persetujuan::class)
            ->call('setujuiAkun', $akun->id)
            ->assertSet('galat', null);

        $akun->refresh();
        $duta->refresh();

        $this->assertTrue((bool) $akun->status_aktif);
        $this->assertSame($duta->id, $akun->duta_id);
        $this->assertSame(DutaOlahraga::STATUS_DISETUJUI, $duta->status_pendaftaran);
        $this->assertSame($this->superAdmin->id, $duta->disetujui_oleh);
    }

    public function test_aksi_setujui_ditolak_untuk_bukan_super_admin(): void
    {
        $pegiat = $this->buatPengguna('Pegiat Aksi Uji', $this->peranPegiat->id);
        $akun = $this->buatPengguna('Akun Aksi Uji', $this->peranPegiat->id, false);
        $duta = $this->buatDutaMenunggu($akun, 'Duta Aksi Uji');

        $this->actingAs($pegiat);

        try {
            (new Persetujuan())->setujuiDuta($duta->id);
            $this->fail('Aksi persetujuan seharusnya menolak pengguna non-super-admin.');
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            $this->assertSame(403, $e->getStatusCode());
        }

        $this->assertSame(DutaOlahraga::STATUS_MENUNGGU, $duta->fresh()->status_pendaftaran);
    }
}
