<?php

namespace Tests\Feature;

use App\Livewire\Admin\Berita\BeritaKelola;
use App\Livewire\Admin\Galeri\GaleriKelola;
use App\Livewire\Admin\Unduhan\UnduhanKelola;
use App\Livewire\Admin\Duta\DutaKelola;
use App\Livewire\Admin\Inorga\InorgaKelola;
use App\Livewire\Admin\Event\KlasemenKelola;
use App\Livewire\Admin\Sapras\SaprasKelola;
use App\Livewire\Admin\Sdi\SdiKelola;
use App\Livewire\Admin\Apmo\ApmoKelola;
use App\Models\Berita;
use App\Models\GaleriAlbum;
use App\Models\GaleriFoto;
use App\Models\Unduhan;
use App\Models\DutaOlahraga;
use App\Models\Inorga;
use App\Models\Sapras;
use App\Models\SdiProgram;
use App\Models\SdiJadwal;
use App\Models\ApmoTahun;
use App\Models\ApmoPenerima;
use App\Models\KategoriBerita;
use App\Models\KategoriUnduhan;
use App\Models\KomisiInorga;
use App\Models\Kecamatan;
use App\Models\Pengguna;
use Livewire\Livewire;
use Tests\TestCase;

class AdminCmsCrudTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $admin = Pengguna::first();
        if ($admin) {
            $this->actingAs($admin);
        }
    }

    public function test_berita_crud(): void
    {
        $kategori = KategoriBerita::first();

        Livewire::test(BeritaKelola::class)
            ->call('bukaModalTambah')
            ->set('judul', 'Berita Uji Coba KORMI 2026')
            ->set('kategori_id', $kategori->id)
            ->set('ringkasan', 'Ringkasan berita uji coba')
            ->set('isi_konten', 'Konten detail uji coba berita kormi')
            ->set('gambar_utama', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800')
            ->set('status_publikasi', 'published')
            ->call('simpan')
            ->assertHasNoErrors();

        $berita = Berita::where('judul', 'Berita Uji Coba KORMI 2026')->first();
        $this->assertNotNull($berita);

        Livewire::test(BeritaKelola::class)
            ->call('bukaModalEdit', $berita->id)
            ->set('judul', 'Berita Uji Coba KORMI 2026 Updated')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('Berita Uji Coba KORMI 2026 Updated', $berita->fresh()->judul);

        Livewire::test(BeritaKelola::class)
            ->call('hapus', $berita->id);

        $this->assertNull(Berita::find($berita->id));
    }

    public function test_berita_advanced_features(): void
    {
        $kategori = KategoriBerita::first();

        // 1. Buat Berita untuk pengujian
        $b1 = Berita::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'kategori_id' => $kategori->id,
            'penulis_id' => Pengguna::first()->id,
            'judul' => 'Berita Fitur Lanjutan 1',
            'slug' => 'berita-fitur-lanjutan-1',
            'ringkasan' => 'Ringkasan pengujian fitur lanjutan',
            'isi_konten' => 'Konten lengkap pengujian fitur lanjutan',
            'gambar_utama' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800',
            'status_publikasi' => 'draft',
            'status_unggulan' => false,
        ]);

        $b2 = Berita::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'kategori_id' => $kategori->id,
            'penulis_id' => Pengguna::first()->id,
            'judul' => 'Berita Fitur Lanjutan 2',
            'slug' => 'berita-fitur-lanjutan-2',
            'ringkasan' => 'Ringkasan pengujian fitur lanjutan 2',
            'isi_konten' => 'Konten lengkap pengujian fitur lanjutan 2',
            'gambar_utama' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800',
            'status_publikasi' => 'draft',
            'status_unggulan' => false,
        ]);

        // 2. Test Toggle Unggulan & Toggle Status
        Livewire::test(BeritaKelola::class)
            ->call('toggleUnggulan', $b1->id)
            ->assertHasNoErrors();
        $this->assertTrue((bool) $b1->fresh()->status_unggulan);

        Livewire::test(BeritaKelola::class)
            ->call('toggleStatus', $b1->id)
            ->assertHasNoErrors();
        $this->assertEquals('published', $b1->fresh()->status_publikasi);

        // 3. Test Duplikat Berita
        Livewire::test(BeritaKelola::class)
            ->call('duplikatBerita', $b1->id)
            ->assertHasNoErrors();
        $this->assertTrue(Berita::where('judul', 'like', '%[Salinan] Berita Fitur Lanjutan 1%')->exists());

        // 4. Test Bulk Publish
        Livewire::test(BeritaKelola::class)
            ->set('selectedBerita', [$b1->id, $b2->id])
            ->call('bulkPublish')
            ->assertHasNoErrors();
        $this->assertEquals('published', $b2->fresh()->status_publikasi);

        // 5. Test Bulk Delete
        Livewire::test(BeritaKelola::class)
            ->set('selectedBerita', [$b1->id, $b2->id])
            ->call('bulkDelete')
            ->assertHasNoErrors();
        $this->assertNull(Berita::find($b1->id));
        $this->assertNull(Berita::find($b2->id));
    }


    public function test_galeri_crud(): void
    {
        $album = GaleriAlbum::first();

        Livewire::test(GaleriKelola::class)
            ->call('bukaModalTambahFoto')
            ->set('album_id', $album->id)
            ->set('judul_foto', 'Foto Uji Coba Galeri')
            ->set('gambar_url', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800')
            ->set('tipe_grid', 'normal')
            ->set('urutan_foto', 1)
            ->call('simpanFoto')
            ->assertHasNoErrors();

        $foto = GaleriFoto::where('judul_foto', 'Foto Uji Coba Galeri')->first();
        $this->assertNotNull($foto);

        Livewire::test(GaleriKelola::class)
            ->call('bukaModalEditFoto', $foto->id)
            ->set('judul_foto', 'Foto Uji Coba Galeri Updated')
            ->call('simpanFoto')
            ->assertHasNoErrors();

        $this->assertEquals('Foto Uji Coba Galeri Updated', $foto->fresh()->judul_foto);

        Livewire::test(GaleriKelola::class)
            ->call('hapusFoto', $foto->id);

        $this->assertNull(GaleriFoto::find($foto->id));
    }

    public function test_unduhan_crud(): void
    {
        $kategori = KategoriUnduhan::first();

        Livewire::test(UnduhanKelola::class)
            ->call('bukaModalTambah')
            ->set('judul_dokumen', 'SK Uji Coba Unduhan 2026')
            ->set('kategori_id', $kategori->id)
            ->set('ekstensi_berkas', 'PDF')
            ->set('ukuran_berkas', '1.2 MB')
            ->set('status_publik', true)
            ->call('simpan')
            ->assertHasNoErrors();

        $unduhan = Unduhan::where('judul_dokumen', 'SK Uji Coba Unduhan 2026')->first();
        $this->assertNotNull($unduhan);

        Livewire::test(UnduhanKelola::class)
            ->call('bukaModalEdit', $unduhan->id)
            ->set('judul_dokumen', 'SK Uji Coba Unduhan 2026 Updated')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('SK Uji Coba Unduhan 2026 Updated', $unduhan->fresh()->judul_dokumen);

        Livewire::test(UnduhanKelola::class)
            ->call('hapus', $unduhan->id);

        $this->assertNull(Unduhan::find($unduhan->id));
    }

    public function test_duta_crud(): void
    {
        $kecamatan = Kecamatan::first();

        Livewire::test(DutaKelola::class)
            ->call('bukaModalTambah')
            ->set('kecamatan_id', $kecamatan->id)
            ->set('nama_lengkap', 'Duta Uji Coba Bandung')
            ->set('tahun_pemilihan', 2026)
            ->call('simpan')
            ->assertHasNoErrors();

        $duta = DutaOlahraga::where('nama_lengkap', 'Duta Uji Coba Bandung')->first();
        $this->assertNotNull($duta);

        Livewire::test(DutaKelola::class)
            ->call('bukaModalEdit', $duta->id)
            ->set('nama_lengkap', 'Duta Uji Coba Bandung Updated')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('Duta Uji Coba Bandung Updated', $duta->fresh()->nama_lengkap);

        Livewire::test(DutaKelola::class)
            ->call('hapus', $duta->id);

        $this->assertNull(DutaOlahraga::find($duta->id));
    }

    public function test_inorga_crud(): void
    {
        $komisi = KomisiInorga::first();

        Livewire::test(InorgaKelola::class)
            ->call('bukaModalTambah')
            ->set('komisi_id', $komisi->id)
            ->set('singkatan', 'UJI')
            ->set('nama_inorga', 'Inorga Uji Coba Bandung')
            ->set('status_keanggotaan', 'aktif')
            ->set('jumlah_klub_anggota', 5)
            ->call('simpan')
            ->assertHasNoErrors();

        $inorga = Inorga::where('singkatan', 'UJI')->first();
        $this->assertNotNull($inorga);

        Livewire::test(InorgaKelola::class)
            ->call('bukaModalEdit', $inorga->id)
            ->set('nama_inorga', 'Inorga Uji Coba Bandung Updated')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('Inorga Uji Coba Bandung Updated', $inorga->fresh()->nama_inorga);

        Livewire::test(InorgaKelola::class)
            ->call('hapus', $inorga->id);

        $this->assertNull(Inorga::find($inorga->id));
    }

    public function test_sapras_crud(): void
    {
        $kecamatan = Kecamatan::first();

        Livewire::test(SaprasKelola::class)
            ->call('bukaModalTambah')
            ->set('kecamatan_id', $kecamatan->id)
            ->set('nama_fasilitas', 'Stadion Uji Coba Soreang')
            ->set('kategori_fasilitas', 'Stadion')
            ->set('alamat_lengkap', 'Jl. Raya Soreang No. 123')
            ->set('status_kondisi', 'Baik')
            ->set('jenis_olahraga_tersedia', 'Sepak Bola, Atletik')
            ->call('simpan')
            ->assertHasNoErrors();

        $sapras = Sapras::where('nama_fasilitas', 'Stadion Uji Coba Soreang')->first();
        $this->assertNotNull($sapras);

        Livewire::test(SaprasKelola::class)
            ->call('bukaModalEdit', $sapras->id)
            ->set('nama_fasilitas', 'Stadion Uji Coba Soreang Updated')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('Stadion Uji Coba Soreang Updated', $sapras->fresh()->nama_fasilitas);

        Livewire::test(SaprasKelola::class)
            ->call('hapus', $sapras->id);

        $this->assertNull(Sapras::find($sapras->id));
    }

    public function test_sdi_crud(): void
    {
        Livewire::test(SdiKelola::class)
            ->call('bukaModalProgramTambah')
            ->set('judul_program', 'Program Pelatihan Uji Coba 2026')
            ->set('jenis_sertifikasi', 'Tingkat Dasar')
            ->set('sasaran_peserta', 'Instruktur')
            ->call('simpanProgram')
            ->assertHasNoErrors();

        $prog = SdiProgram::where('judul_program', 'Program Pelatihan Uji Coba 2026')->first();
        $this->assertNotNull($prog);

        Livewire::test(SdiKelola::class)
            ->call('bukaModalProgramEdit', $prog->id)
            ->set('judul_program', 'Program Pelatihan Uji Coba 2026 Updated')
            ->call('simpanProgram')
            ->assertHasNoErrors();

        $this->assertEquals('Program Pelatihan Uji Coba 2026 Updated', $prog->fresh()->judul_program);

        Livewire::test(SdiKelola::class)
            ->call('hapusProgram', $prog->id);

        $this->assertNull(SdiProgram::find($prog->id));
    }

    public function test_apmo_crud(): void
    {
        $edisi = ApmoTahun::first();

        Livewire::test(ApmoKelola::class)
            ->call('bukaModalPenerimaTambah')
            ->set('apmo_tahun_id', $edisi->id)
            ->set('nama_penerima', 'Tokoh Uji Coba APMO')
            ->set('kategori_penghargaan', 'Pembina Terbaik')
            ->set('deskripsi_capaian', 'Dedikasi tinggi dalam olahraga rekreasi')
            ->set('urutan', 1)
            ->call('simpanPenerima')
            ->assertHasNoErrors();

        $penerima = ApmoPenerima::where('nama_penerima', 'Tokoh Uji Coba APMO')->first();
        $this->assertNotNull($penerima);

        Livewire::test(ApmoKelola::class)
            ->call('bukaModalPenerimaEdit', $penerima->id)
            ->set('nama_penerima', 'Tokoh Uji Coba APMO Updated')
            ->call('simpanPenerima')
            ->assertHasNoErrors();

        $this->assertEquals('Tokoh Uji Coba APMO Updated', $penerima->fresh()->nama_penerima);

        Livewire::test(ApmoKelola::class)
            ->call('hapusPenerima', $penerima->id);

        $this->assertNull(ApmoPenerima::find($penerima->id));
    }

    public function test_pengguna_crud(): void
    {
        $testEmail = 'pengguna_test_' . time() . '@kormibdg.id';
        $peran = \App\Models\Peran::first();

        Livewire::test(\App\Livewire\Admin\Pengguna\PenggunaKelola::class)
            ->call('bukaFormTambah')
            ->set('nama_lengkap', 'Pengguna Uji Coba KORMI')
            ->set('email', $testEmail)
            ->set('nomor_telepon', '081234567890')
            ->set('peran_id', $peran?->id)
            ->set('kata_sandi', 'password123')
            ->set('status_aktif', true)
            ->call('simpan')
            ->assertHasNoErrors();

        $user = Pengguna::where('email', $testEmail)->first();
        $this->assertNotNull($user);

        Livewire::test(\App\Livewire\Admin\Pengguna\PenggunaKelola::class)
            ->call('bukaFormEdit', $user->id)
            ->set('nama_lengkap', 'Pengguna Uji Coba KORMI Updated')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('Pengguna Uji Coba KORMI Updated', $user->fresh()->nama_lengkap);

        Livewire::test(\App\Livewire\Admin\Pengguna\PenggunaKelola::class)
            ->call('toggleStatus', $user->id);

        $this->assertFalse((bool) $user->fresh()->status_aktif);

        Livewire::test(\App\Livewire\Admin\Pengguna\PenggunaKelola::class)
            ->call('hapus', $user->id);

        $this->assertNull(Pengguna::find($user->id));
    }

    public function test_pengguna_bulk_actions(): void
    {
        $peran = \App\Models\Peran::first();

        $u1 = Pengguna::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'peran_id' => $peran?->id,
            'nama_lengkap' => 'Bulk User 1',
            'email' => 'bulk1_' . time() . '@kormibdg.id',
            'kata_sandi' => \Illuminate\Support\Facades\Hash::make('password123'),
            'status_aktif' => true,
        ]);

        $u2 = Pengguna::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'peran_id' => $peran?->id,
            'nama_lengkap' => 'Bulk User 2',
            'email' => 'bulk2_' . time() . '@kormibdg.id',
            'kata_sandi' => \Illuminate\Support\Facades\Hash::make('password123'),
            'status_aktif' => true,
        ]);

        // Test bulk disable login
        Livewire::test(\App\Livewire\Admin\Pengguna\PenggunaKelola::class)
            ->set('selectedUsers', [(string) $u1->id, (string) $u2->id])
            ->call('bulkDisableLogin', [(string) $u1->id, (string) $u2->id]);

        $this->assertFalse((bool) $u1->fresh()->status_aktif);
        $this->assertFalse((bool) $u2->fresh()->status_aktif);

        // Test bulk enable login
        Livewire::test(\App\Livewire\Admin\Pengguna\PenggunaKelola::class)
            ->set('selectedUsers', [(string) $u1->id, (string) $u2->id])
            ->call('bulkEnableLogin', [(string) $u1->id, (string) $u2->id]);

        $this->assertTrue((bool) $u1->fresh()->status_aktif);
        $this->assertTrue((bool) $u2->fresh()->status_aktif);

        // Test bulk reset password
        Livewire::test(\App\Livewire\Admin\Pengguna\PenggunaKelola::class)
            ->set('selectedUsers', [(string) $u1->id, (string) $u2->id])
            ->set('bulkPasswordBaru', 'newpassword2026')
            ->call('simpanBulkResetPassword');

        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword2026', $u1->fresh()->kata_sandi));
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword2026', $u2->fresh()->kata_sandi));

        // Test bulk delete
        Livewire::test(\App\Livewire\Admin\Pengguna\PenggunaKelola::class)
            ->set('selectedUsers', [(string) $u1->id, (string) $u2->id])
            ->call('bulkHapus', [(string) $u1->id, (string) $u2->id]);

        $this->assertNull(Pengguna::find($u1->id));
        $this->assertNull(Pengguna::find($u2->id));
    }
}
