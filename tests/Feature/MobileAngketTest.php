<?php

namespace Tests\Feature;

use App\Livewire\Mobile\Angket;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\AngketApmo;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class MobileAngketTest extends TestCase
{
    use DatabaseTransactions;

    private function penggunaUji(): Pengguna
    {
        return Pengguna::create([
            'peran_id' => Peran::where('slug', 'pegiat-olahraga')->firstOrFail()->id,
            'nama_lengkap' => 'Responden Uji Angket',
            'email' => 'uji.angket.' . uniqid() . '@contoh.id',
            'nomor_telepon' => '081200001234',
            'jenis_kelamin' => 'L',
            'kata_sandi' => 'sandi-uji-123',
            'status_aktif' => true,
        ]);
    }

    private function desaUji(): DesaKelurahan
    {
        return DesaKelurahan::whereNotNull('kecamatan_id')->orderBy('kecamatan_id')->firstOrFail();
    }

    private function isiIdentitas($component)
    {
        $desa = $this->desaUji();

        return $component
            ->set('nama_lengkap', 'Responden Uji Angket')
            ->set('usia', 32)
            ->set('jenis_kelamin', 'pria')
            ->set('alamat', 'Jl. Uji No. 1, Desa Uji')
            ->set('kecamatan_id', $desa->kecamatan_id)
            ->set('desa_kelurahan_id', $desa->id)
            ->set('pekerjaan', 'pegawai_swasta');
    }

    private function isiDetailOlahraga($component)
    {
        return $component
            ->set('frekuensi_berat', '2')
            ->set('durasi_berat_jam', 1)
            ->set('durasi_berat_menit', 30)
            ->set('frekuensi_sedang', '1')
            ->set('durasi_sedang_jam', 0)
            ->set('durasi_sedang_menit', 45)
            ->set('frekuensi_jalan', '3')
            ->set('durasi_jalan_tidak_tahu', true)
            ->set('cabang_olahraga', 'sepakbola')
            ->set('tujuan_olahraga', 'kesehatan')
            ->set('jalur_olahraga', 'sendiri')
            ->set('pernah_malas', 'tidak_pernah')
            ->set('fasilitas_olahraga', 'memadai');
    }

    public function test_halaman_angket_dapat_diakses_publik(): void
    {
        $this->get('/mobile/angket')
            ->assertOk()
            ->assertSee('Angket APMO')
            ->assertSee('Identitas')
            ->assertSee('kd-steps', false)
            ->assertSee('Nama Lengkap')
            ->assertSee('novalidate', false)
            ->assertSee('Kabupaten Bandung');
    }

    public function test_beranda_dan_layanan_menautkan_angket(): void
    {
        $this->get('/mobile/beranda')
            ->assertOk()
            ->assertSee('Angket APMO')
            ->assertSee(route('mobile.angket'), false);

        $this->actingAs($this->penggunaUji())
            ->get('/mobile/layanan')
            ->assertOk()
            ->assertSee('Survei &amp; Angket', false)
            ->assertSee(route('mobile.angket'), false);
    }

    public function test_detail_belum_lengkap_tidak_tersimpan(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        $desa = $this->desaUji();

        Livewire::test(Angket::class)
            ->set('nama_lengkap', 'Responden Uji Angket')
            ->set('usia', 32)
            ->set('jenis_kelamin', 'pria')
            ->set('tinggi_badan', 170)
            ->set('berat_badan', 65)
            ->set('alamat', 'Jl. Uji No. 1, Desa Uji')
            ->set('kecamatan_id', $desa->kecamatan_id)
            ->set('desa_kelurahan_id', $desa->id)
            ->set('pekerjaan', 'pegawai_swasta')
            ->call('lanjut')
            ->assertHasNoErrors()
            ->assertSet('langkah', 2)
            ->set('melakukan_olahraga', 'ya')
            ->call('lanjut')
            ->assertHasNoErrors()
            ->assertSet('langkah', 3)
            ->call('kirim')
            ->assertHasErrors(['frekuensi_berat'])
            ->assertSet('selesai', false)
            ->call('kembali')
            ->assertSet('langkah', 2);

        $this->assertSame(0, AngketApmo::where('nama_lengkap', 'Responden Uji Angket')->count());
    }

    public function test_alur_lengkap_ya_tersimpan(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        $komponen = $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'ya')
            ->call('lanjut');

        $this->isiDetailOlahraga($komponen)
            ->call('kirim')
            ->assertHasNoErrors()
            ->assertSet('selesai', true)
            ->assertSet('namaTersimpan', 'Responden Uji Angket');

        $angket = AngketApmo::where('nama_lengkap', 'Responden Uji Angket')->first();

        $this->assertNotNull($angket);
        $this->assertSame($user->id, $angket->pengguna_id);
        $this->assertTrue($angket->melakukan_olahraga);
        $this->assertSame('2', $angket->frekuensi_berat);
        $this->assertSame(1, $angket->durasi_berat_jam);
        $this->assertSame(30, $angket->durasi_berat_menit);
        $this->assertTrue($angket->durasi_jalan_tidak_tahu);
        $this->assertNull($angket->durasi_jalan_jam);
        $this->assertSame('tidak_pernah', $angket->pernah_malas);
        $this->assertSame('memadai', $angket->fasilitas_olahraga);
        $this->assertNull($angket->alasan_tidak_olahraga);

        $desa = $this->desaUji();
        $this->assertSame(Kecamatan::find($desa->kecamatan_id)->nama_kecamatan, $angket->kecamatan);
        $this->assertSame($desa->nama_desa_kelurahan, $angket->desa);
        $this->assertSame('Kabupaten Bandung', $angket->kabupaten_kota);
    }

    public function test_alur_tidak_berolahraga_tersimpan(): void
    {
        $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'tidak')
            ->call('lanjut')
            ->assertSet('langkah', 3)
            ->set('alasan_tidak_olahraga', 'tidak_ada_waktu')
            ->set('fasilitas_olahraga', 'kurang')
            ->call('kirim')
            ->assertHasNoErrors()
            ->assertSet('selesai', true);

        $angket = AngketApmo::where('nama_lengkap', 'Responden Uji Angket')->first();

        $this->assertNotNull($angket);
        $this->assertNull($angket->pengguna_id);
        $this->assertFalse($angket->melakukan_olahraga);
        $this->assertSame('tidak_ada_waktu', $angket->alasan_tidak_olahraga);
        $this->assertNull($angket->frekuensi_berat);
        $this->assertSame('kurang', $angket->fasilitas_olahraga);
    }

    public function test_identitas_wajib_lengkap_sebelum_lanjut(): void
    {
        Livewire::test(Angket::class)
            ->call('lanjut')
            ->assertHasErrors(['nama_lengkap', 'usia', 'jenis_kelamin', 'alamat', 'kecamatan_id', 'desa_kelurahan_id', 'pekerjaan'])
            ->assertSet('langkah', 1);
    }

    public function test_desa_dari_kecamatan_lain_ditolak(): void
    {
        $desa = $this->desaUji();
        $kecamatanLain = Kecamatan::where('id', '!=', $desa->kecamatan_id)->firstOrFail();

        Livewire::test(Angket::class)
            ->set('nama_lengkap', 'Responden Uji Angket')
            ->set('usia', 32)
            ->set('jenis_kelamin', 'pria')
            ->set('alamat', 'Jl. Uji No. 1, Desa Uji')
            ->set('kecamatan_id', $kecamatanLain->id)
            ->set('desa_kelurahan_id', $desa->id)
            ->set('pekerjaan', 'pegawai_swasta')
            ->call('lanjut')
            ->assertHasErrors(['desa_kelurahan_id'])
            ->assertSet('langkah', 1);
    }

    public function test_ganti_kecamatan_mengosongkan_desa(): void
    {
        $desa = $this->desaUji();
        $kecamatanLain = Kecamatan::where('id', '!=', $desa->kecamatan_id)->firstOrFail();

        Livewire::test(Angket::class)
            ->set('kecamatan_id', $desa->kecamatan_id)
            ->set('desa_kelurahan_id', $desa->id)
            ->set('kecamatan_id', $kecamatanLain->id)
            ->assertSet('desa_kelurahan_id', null);
    }

    public function test_pekerjaan_lainnya_wajib_diisi(): void
    {
        $desa = $this->desaUji();

        Livewire::test(Angket::class)
            ->set('nama_lengkap', 'Responden Uji Angket')
            ->set('usia', 32)
            ->set('jenis_kelamin', 'wanita')
            ->set('alamat', 'Jl. Uji No. 1')
            ->set('kecamatan_id', $desa->kecamatan_id)
            ->set('desa_kelurahan_id', $desa->id)
            ->set('pekerjaan', 'lainnya')
            ->call('lanjut')
            ->assertHasErrors(['pekerjaan_lainnya'])
            ->assertSet('langkah', 1);
    }

    public function test_pertanyaan_duduk_wajib_saat_pernah_malas(): void
    {
        $komponen = $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'ya')
            ->call('lanjut');

        $this->isiDetailOlahraga($komponen)
            ->set('pernah_malas', 'pernah')
            ->set('durasi_jalan_tidak_tahu', false)
            ->set('durasi_jalan_jam', 0)
            ->set('durasi_jalan_menit', 30)
            ->call('kirim')
            ->assertHasErrors(['duduk_jam']);

        $this->assertSame(0, AngketApmo::where('nama_lengkap', 'Responden Uji Angket')->count());
    }

    public function test_durasi_nol_ditolak(): void
    {
        $komponen = $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'ya')
            ->call('lanjut');

        $this->isiDetailOlahraga($komponen)
            ->set('durasi_berat_jam', 0)
            ->set('durasi_berat_menit', 0)
            ->call('kirim')
            ->assertHasErrors(['durasi_berat_jam']);
    }

    public function test_form_memuat_seluruh_pertanyaan_bagian_3(): void
    {
        $komponen = $this->isiIdentitas(Livewire::test(Angket::class))
            ->assertSee('Identitas Responden')
            ->assertSee('Bagian 1')
            ->call('lanjut')
            ->assertSee('Pertanyaan Olahraga')
            ->assertSee('Bagian 2')
            ->set('melakukan_olahraga', 'ya')
            ->call('lanjut');

        $komponen
            ->assertSee('Bagian 3')
            ->assertSee('napas Anda terengah-engah dalam satu minggu terakhir ini', false)
            ->assertSee('agak terengah-engah dalam seminggu terakhir ini', false)
            ->assertSee('tidak termasuk jalan kaki', false)
            ->assertSee('Dalam berolahraga, jenis olahraga (cabang olahraga) apa yang sering Anda lakukan', false)
            ->assertSee('Apakah tujuan utama Anda berolahraga', false)
            ->assertSee('Melalui jalur apa Anda melakukan olahraga', false)
            ->assertSee('Pernahkah Anda merasa malas untuk melakukan kegiatan olahraga', false)
            ->assertSee('bagaimanakah fasilitas olahraga di daerah Anda sekarang ini', false)
            ->assertSee('Tidak tahu/Tidak pasti')
            ->assertSee('Lebih dari 3 kali')
            ->assertSee('Sepakbola')
            ->assertSee('Beladiri')
            ->assertSee('Sendiri');

        $komponen
            ->set('pernah_malas', 'pernah')
            ->assertSee('Dalam 7 hari terakhir ini, berapa lama Anda duduk dalam satu hari', false);
    }

    public function test_form_memuat_seluruh_pertanyaan_bagian_4(): void
    {
        $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'tidak')
            ->call('lanjut')
            ->assertSee('Bagian 4')
            ->assertSee('Mengapa Anda tidak melakukan kegiatan olahraga', false)
            ->assertSee('Tidak Ada Sarana/Prasarana')
            ->assertSee('Sudah cukup melalui pekerjaan yang saya lakukan')
            ->assertSee('Sangat Kurang')
            ->assertDontSee('Berolahraga berat');
    }

    public function test_pilihan_lainnya_menampilkan_isian_tambahan(): void
    {
        $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'ya')
            ->call('lanjut')
            ->assertDontSee('m-angket-cabang-lain', false)
            ->assertDontSee('m-angket-tujuan-lain', false)
            ->assertDontSee('m-angket-jalur-lain', false)
            ->set('cabang_olahraga', 'lainnya')
            ->assertSee('m-angket-cabang-lain', false)
            ->set('tujuan_olahraga', 'lainnya')
            ->assertSee('m-angket-tujuan-lain', false)
            ->set('jalur_olahraga', 'lainnya')
            ->assertSee('m-angket-jalur-lain', false);

        $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'tidak')
            ->call('lanjut')
            ->assertDontSee('m-angket-alasan-lain', false)
            ->set('alasan_tidak_olahraga', 'lainnya')
            ->assertSee('m-angket-alasan-lain', false);
    }

    public function test_isian_lainnya_dikosongkan_saat_opsi_diganti(): void
    {
        $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'ya')
            ->call('lanjut')
            ->set('cabang_olahraga', 'lainnya')
            ->set('cabang_lainnya', 'Panahan')
            ->set('tujuan_olahraga', 'lainnya')
            ->set('tujuan_lainnya', 'Bersosialisasi')
            ->set('jalur_olahraga', 'lainnya')
            ->set('jalur_lainnya', 'Komunitas')
            ->set('cabang_olahraga', 'sepakbola')
            ->assertSet('cabang_lainnya', '')
            ->set('tujuan_olahraga', 'kesehatan')
            ->assertSet('tujuan_lainnya', '')
            ->set('jalur_olahraga', 'sendiri')
            ->assertSet('jalur_lainnya', '');

        $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'tidak')
            ->call('lanjut')
            ->set('alasan_tidak_olahraga', 'lainnya')
            ->set('alasan_lainnya', 'Sibuk')
            ->set('alasan_tidak_olahraga', 'lelah')
            ->assertSet('alasan_lainnya', '');
    }

    public function test_pesan_validasi_durasi_menggunakan_bahasa_indonesia(): void
    {
        $komponen = $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'ya')
            ->call('lanjut');

        $komponen = $this->isiDetailOlahraga($komponen)
            ->set('durasi_berat_jam', 1)
            ->set('durasi_berat_menit', '')
            ->set('durasi_sedang_jam', 24)
            ->set('durasi_sedang_menit', 60)
            ->call('kirim')
            ->assertHasErrors(['durasi_berat_menit', 'durasi_sedang_jam', 'durasi_sedang_menit']);

        $this->assertSame('Isi durasi olahraga berat (jam dan menit).', $komponen->errors()->first('durasi_berat_menit'));
        $this->assertSame('Jam olahraga sedang maksimal 23.', $komponen->errors()->first('durasi_sedang_jam'));
        $this->assertSame('Menit olahraga sedang maksimal 59.', $komponen->errors()->first('durasi_sedang_menit'));
    }

    public function test_isi_lagi_mengosongkan_jawaban_tapi_mempertahankan_identitas_akun(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        $komponen = $this->isiIdentitas(Livewire::test(Angket::class))
            ->set('alamat', 'Jl. Uji No. 9')
            ->call('isiLagi')
            ->assertSet('langkah', 1)
            ->assertSet('selesai', false)
            ->assertSet('nama_lengkap', $user->nama_lengkap)
            ->assertSet('alamat', '')
            ->assertSet('pekerjaan', '')
            ->assertSet('kecamatan_id', null);

        $this->assertSame(0, AngketApmo::where('nama_lengkap', $user->nama_lengkap)->count());
    }

    public function test_waktu_tersimpan_menggunakan_zona_waktu_indonesia(): void
    {
        \Illuminate\Support\Carbon::setTestNow('2026-08-10 20:00:00');

        try {
            $komponen = $this->isiIdentitas(Livewire::test(Angket::class))
                ->call('lanjut')
                ->set('melakukan_olahraga', 'ya')
                ->call('lanjut');

            $this->isiDetailOlahraga($komponen)
                ->call('kirim')
                ->assertSet('selesai', true)
                ->assertSet('waktuTersimpan', '11 Agt 2026 03:00');
        } finally {
            \Illuminate\Support\Carbon::setTestNow();
        }
    }

    public function test_isian_lainnya_tersimpan_lengkap(): void
    {
        $komponen = $this->isiIdentitas(Livewire::test(Angket::class))
            ->set('pekerjaan', 'lainnya')
            ->set('pekerjaan_lainnya', 'Wiraswasta mandiri')
            ->call('lanjut')
            ->set('melakukan_olahraga', 'ya')
            ->call('lanjut');

        $this->isiDetailOlahraga($komponen)
            ->set('cabang_olahraga', 'lainnya')
            ->set('cabang_lainnya', 'Panahan')
            ->set('tujuan_olahraga', 'lainnya')
            ->set('tujuan_lainnya', 'Bersosialisasi')
            ->set('jalur_olahraga', 'lainnya')
            ->set('jalur_lainnya', 'Komunitas')
            ->call('kirim')
            ->assertHasNoErrors()
            ->assertSet('selesai', true);

        $angket = AngketApmo::where('nama_lengkap', 'Responden Uji Angket')->firstOrFail();

        $this->assertSame('Panahan', $angket->cabang_lainnya);
        $this->assertSame('Bersosialisasi', $angket->tujuan_lainnya);
        $this->assertSame('Komunitas', $angket->jalur_lainnya);
        $this->assertSame('Wiraswasta mandiri', $angket->pekerjaan_lainnya);
    }
}
