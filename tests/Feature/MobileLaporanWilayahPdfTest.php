<?php

namespace Tests\Feature;

use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\AngketApmo;
use App\Livewire\Mobile\Laporan;
use App\Models\Master\DesaKelurahan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class MobileLaporanWilayahPdfTest extends TestCase
{
    use DatabaseTransactions;

    private function desaUji(): DesaKelurahan
    {
        return DesaKelurahan::whereNotNull('kecamatan_id')->orderBy('kecamatan_id')->firstOrFail();
    }

    private function penggunaUji(?DesaKelurahan $desa = null): Pengguna
    {
        $pengguna = Pengguna::create([
            'peran_id' => Peran::where('slug', 'pegiat-olahraga')->firstOrFail()->id,
            'nama_lengkap' => 'Pelapor Wilayah APMO',
            'email' => 'uji.wilayah.' . uniqid() . '@contoh.id',
            'nomor_telepon' => '081200007777',
            'jenis_kelamin' => 'L',
            'kata_sandi' => 'sandi-uji-123',
            'status_aktif' => true,
        ]);

        if ($desa) {
            $pengguna->update([
                'kecamatan_id' => $desa->kecamatan_id,
                'desa_kelurahan_id' => $desa->id,
            ]);
        }

        return $pengguna;
    }

    private function isian(Pengguna $pengguna, DesaKelurahan $desa): void
    {
        AngketApmo::create([
            'pengguna_id' => $pengguna->id,
            'nama_lengkap' => $pengguna->nama_lengkap,
            'usia' => 30,
            'jenis_kelamin' => 'pria',
            'alamat' => 'Jl. Uji Wilayah',
            'kecamatan' => $desa->kecamatan->nama_kecamatan,
            'desa' => $desa->nama_desa_kelurahan,
            'kabupaten_kota' => 'Kabupaten Bandung',
            'pekerjaan' => 'pegawai_swasta',
            'melakukan_olahraga' => true,
        ]);
    }

    public function test_pengguna_desa_dapat_mengunduh_pdf_lingkup_desa(): void
    {
        $desa = $this->desaUji();
        $pengguna = $this->penggunaUji($desa);
        $this->isian($pengguna, $desa);

        $respons = $this->actingAs($pengguna)
            ->get(route('mobile.laporan.wilayah.pdf', ['lingkup' => 'desa']));

        $respons->assertOk();
        $respons->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('attachment', $respons->headers->get('content-disposition'));
        $this->assertStringStartsWith('%PDF', $respons->getContent());
    }

    public function test_pengguna_kecamatan_dapat_mengunduh_pdf_lingkup_kecamatan(): void
    {
        $desa = $this->desaUji();
        $pengguna = $this->penggunaUji($desa);

        $respons = $this->actingAs($pengguna)
            ->get(route('mobile.laporan.wilayah.pdf', ['lingkup' => 'kecamatan']));

        $respons->assertOk();
        $respons->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $respons->getContent());
    }

    public function test_tombol_unduh_pdf_wilayah_hanya_tampil_di_lingkup_desa_dan_kecamatan(): void
    {
        $desa = $this->desaUji();
        $pengguna = $this->penggunaUji($desa);

        $komponen = Livewire::actingAs($pengguna)->test(Laporan::class);

        $komponen->assertDontSee('Unduh PDF wilayah');

        $komponen->call('pilihLingkup', 'desa')
            ->assertSee('Unduh PDF wilayah')
            ->assertSee(route('mobile.laporan.wilayah.pdf', ['lingkup' => 'desa']), false)
            ->call('pilihLingkup', 'kecamatan')
            ->assertSee('Unduh PDF wilayah')
            ->assertSee(route('mobile.laporan.wilayah.pdf', ['lingkup' => 'kecamatan']), false);
    }

    public function test_lingkup_tidak_dikenal_menghasilkan_404(): void    {
        $desa = $this->desaUji();
        $pengguna = $this->penggunaUji($desa);

        $this->actingAs($pengguna)
            ->get(route('mobile.laporan.wilayah.pdf', ['lingkup' => 'provinsi']))
            ->assertNotFound();
    }

    public function test_pengguna_tanpa_wilayah_menghasilkan_404(): void
    {
        $pengguna = $this->penggunaUji();

        $this->actingAs($pengguna)
            ->get(route('mobile.laporan.wilayah.pdf', ['lingkup' => 'desa']))
            ->assertNotFound();
    }

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get(route('mobile.laporan.wilayah.pdf', ['lingkup' => 'desa']))
            ->assertRedirect('/login');
    }
}
