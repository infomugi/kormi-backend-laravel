<?php

namespace Tests\Feature;

use App\Livewire\Mobile\Laporan;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\AngketApmo;
use App\Models\Master\DesaKelurahan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class MobileLaporanTest extends TestCase
{
    use DatabaseTransactions;

    private function penggunaUji(): Pengguna
    {
        return Pengguna::create([
            'peran_id' => Peran::where('slug', 'pegiat-olahraga')->firstOrFail()->id,
            'nama_lengkap' => 'Pelapor Uji APMO',
            'email' => 'uji.laporan.' . uniqid() . '@contoh.id',
            'nomor_telepon' => '081200005678',
            'jenis_kelamin' => 'L',
            'kata_sandi' => 'sandi-uji-123',
            'status_aktif' => true,
        ]);
    }

    private function desaUji(): DesaKelurahan
    {
        return DesaKelurahan::whereNotNull('kecamatan_id')->orderBy('kecamatan_id')->firstOrFail();
    }

    private function isian(Pengguna $pengguna, DesaKelurahan $desa, bool $olahraga = true): AngketApmo
    {
        return AngketApmo::create([
            'pengguna_id' => $pengguna->id,
            'nama_lengkap' => 'Pelapor Uji APMO',
            'usia' => 30,
            'jenis_kelamin' => 'pria',
            'alamat' => 'Jl. Uji Laporan',
            'kecamatan' => $desa->kecamatan->nama_kecamatan,
            'desa' => $desa->nama_desa_kelurahan,
            'kabupaten_kota' => 'Kabupaten Bandung',
            'pekerjaan' => 'pegawai_swasta',
            'melakukan_olahraga' => $olahraga,
        ]);
    }

    public function test_halaman_laporan_menampilkan_dua_tab_dan_tiga_lingkup(): void
    {
        $warga = Pengguna::where('email', 'warga@kormibdg.id')->firstOrFail();

        $this->actingAs($warga)
            ->get('/mobile/laporan')
            ->assertOk()
            ->assertSee('Riwayat APMO')
            ->assertSee('Statistik APMO')
            ->assertSee('Saya')
            ->assertSee('Desa')
            ->assertSee('Kecamatan')
            ->assertSee('kd-tabbar', false);
    }

    public function test_lingkup_desa_hanya_menghitung_isian_di_desa_pengguna(): void
    {
        $warga = $this->penggunaUji();
        $desa = $this->desaUji();

        $warga->update([
            'kecamatan_id' => $desa->kecamatan_id,
            'desa_kelurahan_id' => $desa->id,
        ]);

        $this->isian($warga, $desa);

        $desaLain = DesaKelurahan::where('kecamatan_id', $desa->kecamatan_id)
            ->where('id', '!=', $desa->id)
            ->first();

        if ($desaLain) {
            $this->isian($warga, $desaLain);
        }

        $komponen = Livewire::actingAs($warga)
            ->test(Laporan::class)
            ->call('pilihLingkup', 'desa')
            ->assertSet('lingkup', 'desa')
            ->assertSee('Desa ' . $desa->nama_desa_kelurahan)
            ->assertSee('1 isian');

        if ($desaLain) {
            $komponen->assertDontSee('Desa ' . $desaLain->nama_desa_kelurahan);
        }
    }

    public function test_lingkup_desa_tanpa_wilayah_menampilkan_ajakan_lengkapi_profil(): void
    {
        $warga = $this->penggunaUji();

        Livewire::actingAs($warga)
            ->test(Laporan::class)
            ->call('pilihLingkup', 'desa')
            ->assertSee('Desa belum diatur')
            ->assertSee('Lengkapi profil');
    }

    public function test_statistik_lingkup_kecamatan_merangkum_isian_wilayah(): void
    {
        $warga = $this->penggunaUji();
        $desa = $this->desaUji();

        $warga->update([
            'kecamatan_id' => $desa->kecamatan_id,
            'desa_kelurahan_id' => $desa->id,
        ]);

        $this->isian($warga, $desa, true);

        Livewire::actingAs($warga)
            ->test(Laporan::class)
            ->call('pilihLingkup', 'kecamatan')
            ->call('pilihTab', 'statistik')
            ->assertSet('tab', 'statistik')
            ->assertSee('Status olahraga')
            ->assertSee('Jenis kelamin');
    }

    public function test_pemilik_melihat_aksi_dan_dapat_menghapus_isian_sendiri(): void
    {
        $warga = $this->penggunaUji();
        $desa = $this->desaUji();
        $baris = $this->isian($warga, $desa);

        $jumlahAwal = AngketApmo::count();

        Livewire::actingAs($warga)
            ->test(Laporan::class)
            ->assertSee('isian-' . $baris->id, false)
            ->assertSee('Ubah')
            ->assertSee('Hapus')
            ->assertSee(route('mobile.angket.ubah', $baris), false)
            ->assertDontSee('Hapus permanen')
            ->call('konfirmasiHapus', $baris->id)
            ->assertSet('hapusId', $baris->id)
            ->assertSee('Hapus permanen')
            ->call('batalHapus')
            ->assertSet('hapusId', null)
            ->assertDontSee('Hapus permanen')
            ->call('konfirmasiHapus', $baris->id)
            ->call('hapus', $baris->id)
            ->assertSet('hapusId', null)
            ->assertDontSee('Hapus permanen')
            ->assertSee('Belum ada isian APMO');

        $this->assertNull(AngketApmo::find($baris->id));
        $this->assertSame($jumlahAwal - 1, AngketApmo::count());
    }

    public function test_hapus_isian_ikut_menghapus_foto_bukti(): void
    {
        Storage::fake('minio');

        $warga = $this->penggunaUji();
        $desa = $this->desaUji();
        $baris = $this->isian($warga, $desa);

        $baris->update(['foto_bukti' => 'angket/uji/bukti.jpg']);
        Storage::disk('minio')->put('angket/uji/bukti.jpg', 'foto-bukti');

        Livewire::actingAs($warga)
            ->test(Laporan::class)
            ->call('hapus', $baris->id);

        $this->assertNull(AngketApmo::find($baris->id));
        Storage::disk('minio')->assertMissing('angket/uji/bukti.jpg');
    }

    public function test_isian_pengguna_lain_tidak_dapat_dihapus(): void
    {
        $pemilik = $this->penggunaUji();
        $desa = $this->desaUji();
        $baris = $this->isian($pemilik, $desa);

        $lain = $this->penggunaUji();

        Livewire::actingAs($lain)
            ->test(Laporan::class)
            ->assertDontSee('Ubah')
            ->assertDontSee('Hapus')
            ->call('hapus', $baris->id)
            ->assertSet('hapusId', null);

        $this->assertNotNull(AngketApmo::find($baris->id));
    }

    public function test_aksi_ubah_dan_hapus_hanya_tampil_pada_lingkup_saya(): void
    {
        $warga = $this->penggunaUji();
        $desa = $this->desaUji();

        $warga->update([
            'kecamatan_id' => $desa->kecamatan_id,
            'desa_kelurahan_id' => $desa->id,
        ]);

        $baris = $this->isian($warga, $desa);

        Livewire::actingAs($warga)
            ->test(Laporan::class)
            ->call('pilihLingkup', 'desa')
            ->assertSee($baris->nama_lengkap)
            ->assertDontSee('Ubah')
            ->assertDontSee('Hapus')
            ->assertDontSee(route('mobile.angket.ubah', $baris), false)
            ->call('pilihLingkup', 'kecamatan')
            ->assertSee($baris->nama_lengkap)
            ->assertDontSee('Ubah')
            ->assertDontSee('Hapus')
            ->call('pilihTab', 'statistik')
            ->assertDontSee('Hapus permanen');
    }
}
