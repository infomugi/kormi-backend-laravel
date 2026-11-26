<?php

namespace Tests\Feature;

use App\Livewire\Mobile\Angket;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\AngketApmo;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class MobileAngketTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('minio');
    }

    private function fotoUji(): UploadedFile
    {
        return UploadedFile::fake()->image('selfie.jpg', 320, 320);
    }

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

    private function catatanUji(Pengguna $pengguna, DesaKelurahan $desa): AngketApmo
    {
        return AngketApmo::create([
            'pengguna_id' => $pengguna->id,
            'nama_lengkap' => 'Responden Uji Angket',
            'usia' => 33,
            'jenis_kelamin' => 'pria',
            'tinggi_badan' => 170,
            'berat_badan' => 66,
            'alamat' => 'Jl. Lama No. 5',
            'kecamatan' => $desa->kecamatan->nama_kecamatan,
            'desa' => $desa->nama_desa_kelurahan,
            'kabupaten_kota' => 'Kabupaten Bandung',
            'pekerjaan' => 'pegawai_swasta',
            'melakukan_olahraga' => true,
            'frekuensi_berat' => '2',
            'durasi_berat_jam' => 1,
            'durasi_berat_menit' => 20,
            'frekuensi_sedang' => '1',
            'durasi_sedang_jam' => 0,
            'durasi_sedang_menit' => 30,
            'frekuensi_jalan' => '3',
            'durasi_jalan_tidak_tahu' => true,
            'cabang_olahraga' => 'sepakbola',
            'tujuan_olahraga' => 'kesehatan',
            'jalur_olahraga' => 'sendiri',
            'pernah_malas' => 'tidak_pernah',
            'fasilitas_olahraga' => 'memadai',
            'foto_bukti' => 'angket/uji/foto-lama.jpg',
        ]);
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
            ->assertSee('Survey APMO')
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
            ->assertSee('Survey APMO')
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
            ->set('foto_bukti', $this->fotoUji())
            ->call('kirim')
            ->assertHasNoErrors()
            ->assertSet('selesai', true)
            ->assertSet('namaTersimpan', 'Responden Uji Angket');

        $angket = AngketApmo::where('nama_lengkap', 'Responden Uji Angket')->first();

        $this->assertNotNull($angket);
        $this->assertSame($user->id, $angket->pengguna_id);
        $this->assertNotNull($angket->foto_bukti);
        $this->assertStringStartsWith('angket/', $angket->foto_bukti);
        Storage::disk('minio')->assertExists($angket->foto_bukti);
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
            ->set('foto_bukti', $this->fotoUji())
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
        $this->assertNotNull($angket->foto_bukti);
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
            ->set('foto_bukti', $this->fotoUji())
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
                ->set('foto_bukti', $this->fotoUji())
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
            ->set('foto_bukti', $this->fotoUji())
            ->call('kirim')
            ->assertHasNoErrors()
            ->assertSet('selesai', true);

        $angket = AngketApmo::where('nama_lengkap', 'Responden Uji Angket')->firstOrFail();

        $this->assertSame('Panahan', $angket->cabang_lainnya);
        $this->assertSame('Bersosialisasi', $angket->tujuan_lainnya);
        $this->assertSame('Komunitas', $angket->jalur_lainnya);
        $this->assertSame('Wiraswasta mandiri', $angket->pekerjaan_lainnya);
    }

    public function test_ubah_isian_memuat_data_lama_dan_memperbarui_baris_yang_sama(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        $desa = $this->desaUji();
        $catatan = $this->catatanUji($user, $desa);
        $jumlahAwal = AngketApmo::count();

        Livewire::test(Angket::class, ['isian' => $catatan->id])
            ->assertSet('isianId', $catatan->id)
            ->assertSet('nama_lengkap', 'Responden Uji Angket')
            ->assertSet('usia', 33)
            ->assertSet('melakukan_olahraga', 'ya')
            ->assertSet('kecamatan_id', $desa->kecamatan_id)
            ->assertSet('desa_kelurahan_id', $desa->id)
            ->assertSet('langkah', 1)
            ->assertSet('selesai', false)
            ->assertSee('Ubah Isian APMO')
            ->set('alamat', 'Jl. Baru No. 8')
            ->call('lanjut')
            ->assertHasNoErrors()
            ->assertSet('langkah', 2)
            ->call('lanjut')
            ->assertHasNoErrors()
            ->assertSet('langkah', 3)
            ->assertSee('Simpan Perubahan')
            ->assertSee('Foto Bukti Survey')
            ->assertSee(route('mobile.laporan'), false)
            ->call('kirim')
            ->assertHasNoErrors()
            ->assertRedirect(route('mobile.laporan'));

        $this->assertSame($jumlahAwal, AngketApmo::count());

        $catatan->refresh();

        $this->assertSame('Jl. Baru No. 8', $catatan->alamat);
        $this->assertSame($user->id, $catatan->pengguna_id);
        $this->assertSame('angket/uji/foto-lama.jpg', $catatan->foto_bukti);
    }

    public function test_ubah_isian_tidak_berolahraga_memuat_pilihan_alasan(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);
        $desa = $this->desaUji();

        $catatan = AngketApmo::create([
            'pengguna_id' => $user->id,
            'nama_lengkap' => 'Responden Uji Angket',
            'usia' => 40,
            'jenis_kelamin' => 'wanita',
            'alamat' => 'Jl. Lama No. 6',
            'kecamatan' => $desa->kecamatan->nama_kecamatan,
            'desa' => $desa->nama_desa_kelurahan,
            'kabupaten_kota' => 'Kabupaten Bandung',
            'pekerjaan' => 'wiraswasta',
            'melakukan_olahraga' => false,
            'alasan_tidak_olahraga' => 'tidak_ada_waktu',
            'fasilitas_olahraga' => 'kurang',
        ]);

        Livewire::test(Angket::class, ['isian' => $catatan->id])
            ->assertSet('melakukan_olahraga', 'tidak')
            ->assertSet('alasan_tidak_olahraga', 'tidak_ada_waktu')
            ->assertSet('fasilitas_olahraga', 'kurang')
            ->assertSet('jenis_kelamin', 'wanita')
            ->set('alasan_tidak_olahraga', 'lelah')
            ->call('lanjut')
            ->assertHasNoErrors()
            ->call('lanjut')
            ->assertHasNoErrors()
            ->assertSet('langkah', 3)
            ->set('foto_bukti', $this->fotoUji())
            ->call('kirim')
            ->assertHasNoErrors()
            ->assertRedirect(route('mobile.laporan'));

        $catatan->refresh();

        $this->assertFalse($catatan->melakukan_olahraga);
        $this->assertSame('lelah', $catatan->alasan_tidak_olahraga);
        $this->assertNotNull($catatan->foto_bukti);
    }

    public function test_foto_bukti_wajib_diisi(): void
    {
        $komponen = $this->isiIdentitas(Livewire::test(Angket::class))
            ->call('lanjut')
            ->set('melakukan_olahraga', 'tidak')
            ->call('lanjut')
            ->assertSee('Foto Bukti Survey')
            ->set('alasan_tidak_olahraga', 'tidak_ada_waktu')
            ->set('fasilitas_olahraga', 'kurang')
            ->call('kirim')
            ->assertHasErrors(['foto_bukti'])
            ->assertSet('selesai', false);

        $this->assertSame('Ambil atau unggah foto selfie sebagai bukti survey.', $komponen->errors()->first('foto_bukti'));
        $this->assertSame(0, AngketApmo::where('nama_lengkap', 'Responden Uji Angket')->count());
    }

    public function test_ubah_isian_tanpa_foto_lama_mewajibkan_unggahan_foto(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);
        $desa = $this->desaUji();

        $catatan = AngketApmo::create([
            'pengguna_id' => $user->id,
            'nama_lengkap' => 'Responden Uji Angket',
            'usia' => 40,
            'jenis_kelamin' => 'wanita',
            'alamat' => 'Jl. Lama No. 6',
            'kecamatan' => $desa->kecamatan->nama_kecamatan,
            'desa' => $desa->nama_desa_kelurahan,
            'kabupaten_kota' => 'Kabupaten Bandung',
            'pekerjaan' => 'wiraswasta',
            'melakukan_olahraga' => false,
            'alasan_tidak_olahraga' => 'tidak_ada_waktu',
            'fasilitas_olahraga' => 'kurang',
        ]);

        Livewire::test(Angket::class, ['isian' => $catatan->id])
            ->call('lanjut')
            ->assertHasNoErrors()
            ->call('lanjut')
            ->assertHasNoErrors()
            ->call('kirim')
            ->assertHasErrors(['foto_bukti']);

        $this->assertNull($catatan->fresh()->foto_bukti);
    }

    public function test_ubah_isian_mengganti_foto_bukti_menghapus_foto_lama(): void
    {
        $user = $this->penggunaUji();
        $this->actingAs($user);

        $catatan = $this->catatanUji($user, $this->desaUji());
        Storage::disk('minio')->put('angket/uji/foto-lama.jpg', 'foto-lama');

        Livewire::test(Angket::class, ['isian' => $catatan->id])
            ->call('lanjut')
            ->assertHasNoErrors()
            ->call('lanjut')
            ->assertHasNoErrors()
            ->set('foto_bukti', $this->fotoUji())
            ->call('kirim')
            ->assertHasNoErrors()
            ->assertRedirect(route('mobile.laporan'));

        $catatan->refresh();

        $this->assertNotSame('angket/uji/foto-lama.jpg', $catatan->foto_bukti);
        Storage::disk('minio')->assertMissing('angket/uji/foto-lama.jpg');
        Storage::disk('minio')->assertExists($catatan->foto_bukti);
    }

    public function test_halaman_ubah_isian_dapat_diakses_pemilik(): void
    {
        $user = $this->penggunaUji();
        $catatan = $this->catatanUji($user, $this->desaUji());

        $this->actingAs($user)
            ->get(route('mobile.angket.ubah', $catatan))
            ->assertOk()
            ->assertSee('Ubah Isian APMO')
            ->assertSee('Simpan Perubahan')
            ->assertSee('Jl. Lama No. 5');

        $this->assertSame(1, AngketApmo::where('pengguna_id', $user->id)->count());
    }

    public function test_ubah_isian_pengguna_lain_ditolak_404(): void
    {
        $pemilik = $this->penggunaUji();
        $catatan = $this->catatanUji($pemilik, $this->desaUji());

        $this->actingAs($this->penggunaUji())
            ->get(route('mobile.angket.ubah', $catatan))
            ->assertNotFound();

        $this->assertNotNull(AngketApmo::find($catatan->id));
    }

    public function test_ubah_isian_guest_ditolak_404(): void
    {
        $pemilik = $this->penggunaUji();
        $catatan = $this->catatanUji($pemilik, $this->desaUji());

        Livewire::test(Angket::class, ['isian' => $catatan->id])
            ->assertNotFound();
    }
}
