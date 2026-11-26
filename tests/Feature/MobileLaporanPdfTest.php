<?php

namespace Tests\Feature;

use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\AngketApmo;
use App\Models\Master\DesaKelurahan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MobileLaporanPdfTest extends TestCase
{
    use DatabaseTransactions;

    private function penggunaUji(): Pengguna
    {
        return Pengguna::create([
            'peran_id' => Peran::where('slug', 'pegiat-olahraga')->firstOrFail()->id,
            'nama_lengkap' => 'Pemilik Isian APMO',
            'email' => 'uji.pdf.' . uniqid() . '@contoh.id',
            'nomor_telepon' => '081200009876',
            'jenis_kelamin' => 'L',
            'kata_sandi' => 'sandi-uji-123',
            'status_aktif' => true,
        ]);
    }

    private function isianUji(Pengguna $pengguna): AngketApmo
    {
        $desa = DesaKelurahan::whereNotNull('kecamatan_id')->orderBy('kecamatan_id')->firstOrFail();

        return AngketApmo::create([
            'pengguna_id' => $pengguna->id,
            'nama_lengkap' => $pengguna->nama_lengkap,
            'usia' => 31,
            'jenis_kelamin' => 'pria',
            'tinggi_badan' => 170,
            'berat_badan' => 70,
            'alamat' => 'Jl. Uji PDF',
            'kecamatan' => $desa->kecamatan->nama_kecamatan,
            'desa' => $desa->nama_desa_kelurahan,
            'kabupaten_kota' => 'Kabupaten Bandung',
            'pekerjaan' => 'pegawai_swasta',
            'melakukan_olahraga' => true,
            'frekuensi_sedang' => '3',
            'durasi_sedang_jam' => 1,
            'durasi_sedang_menit' => 0,
            'cabang_olahraga' => 'bulutangkis',
            'tujuan_olahraga' => 'kesehatan',
            'jalur_olahraga' => 'sendiri',
            'pernah_malas' => 'pernah',
            'duduk_jam' => 2,
            'duduk_menit' => 30,
            'fasilitas_olahraga' => 'memadai',
        ]);
    }

    public function test_pemilik_isian_dapat_mengunduh_pdf_hasil_survey(): void
    {
        $pengguna = $this->penggunaUji();
        $isian = $this->isianUji($pengguna);

        $respons = $this->actingAs($pengguna)
            ->get(route('mobile.laporan.pdf', $isian));

        $respons->assertOk();
        $respons->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('attachment', $respons->headers->get('content-disposition'));
        $this->assertStringStartsWith('%PDF', $respons->getContent());
    }

    public function test_pengguna_lain_tidak_dapat_mengunduh_pdf_isian_orang_lain(): void
    {
        $pemilik = $this->penggunaUji();
        $isian = $this->isianUji($pemilik);

        $penggunaLain = $this->penggunaUji();

        $this->actingAs($penggunaLain)
            ->get(route('mobile.laporan.pdf', $isian))
            ->assertForbidden();
    }

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $pemilik = $this->penggunaUji();
        $isian = $this->isianUji($pemilik);

        $this->get(route('mobile.laporan.pdf', $isian))
            ->assertRedirect('/login');
    }
}
