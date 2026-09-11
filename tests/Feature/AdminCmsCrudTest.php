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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminCmsCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
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
            ->set('beritaId', $berita->id)
            ->set('judul', 'Berita Uji Coba KORMI 2026 Updated')
            ->set('slug', 'berita-uji-coba-kormi-2026-updated')
            ->set('kategori_id', $kategori->id)
            ->set('ringkasan', 'Ringkasan berita uji coba')
            ->set('isi_konten', 'Konten detail uji coba berita kormi')
            ->set('gambar_utama', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800')
            ->set('status_publikasi', 'published')
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

    public function test_sapras_bulk_actions(): void
    {
        $kecamatan = Kecamatan::first();

        $s1 = Sapras::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'kecamatan_id' => $kecamatan->id,
            'nama_fasilitas' => 'Lap Uji Bulk 1',
            'kategori_fasilitas' => 'Lapangan',
            'alamat_lengkap' => 'Jl. Uji 1',
            'status_kondisi' => 'Baik',
            'jenis_olahraga_tersedia' => 'Senam',
        ]);

        $s2 = Sapras::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'kecamatan_id' => $kecamatan->id,
            'nama_fasilitas' => 'Lap Uji Bulk 2',
            'kategori_fasilitas' => 'Lapangan',
            'alamat_lengkap' => 'Jl. Uji 2',
            'status_kondisi' => 'Baik',
            'jenis_olahraga_tersedia' => 'Senam',
        ]);

        Livewire::test(SaprasKelola::class)
            ->set('selectedSapras', [$s1->id, $s2->id])
            ->call('bulkSetKondisi', 'Perlu Renovasi');

        $this->assertEquals('Perlu Renovasi', $s1->fresh()->status_kondisi);
        $this->assertEquals('Perlu Renovasi', $s2->fresh()->status_kondisi);

        Livewire::test(SaprasKelola::class)
            ->set('selectedSapras', [$s1->id, $s2->id])
            ->call('bulkDelete');

        $this->assertNull(Sapras::find($s1->id));
        $this->assertNull(Sapras::find($s2->id));
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

    public function test_event_crud_and_bulk_actions(): void
    {
        $kategori = \App\Models\KategoriEvent::first();

        // 1. Create Event
        Livewire::test(\App\Livewire\Admin\Event\EventKelola::class)
            ->call('bukaFormTambahEvent')
            ->set('judul_event', 'FORKAB Uji Coba 2026')
            ->set('slug', 'forkab-uji-coba-2026')
            ->set('kategori_event_id', $kategori->id)
            ->set('tahun_edisi', 2026)
            ->set('lokasi_utama', 'Stadion Si Jalak Harupat')
            ->set('tanggal_mulai', '2026-10-01')
            ->set('tanggal_selesai', '2026-10-05')
            ->set('status_publikasi', true)
            ->call('simpanEvent')
            ->assertHasNoErrors();

        $event = \App\Models\Event::where('judul_event', 'FORKAB Uji Coba 2026')->first();
        $this->assertNotNull($event);

        // 2. Edit Event
        Livewire::test(\App\Livewire\Admin\Event\EventKelola::class)
            ->call('bukaFormEditEvent', $event->id)
            ->set('judul_event', 'FORKAB Uji Coba 2026 Updated')
            ->call('simpanEvent')
            ->assertHasNoErrors();

        $this->assertEquals('FORKAB Uji Coba 2026 Updated', $event->fresh()->judul_event);

        // 3. Toggle Status & Bulk Actions
        Livewire::test(\App\Livewire\Admin\Event\EventKelola::class)
            ->call('toggleStatusPublikasi', $event->id);

        $this->assertFalse((bool) $event->fresh()->status_publikasi);

        Livewire::test(\App\Livewire\Admin\Event\EventKelola::class)
            ->set('selectedEvent', [$event->id])
            ->call('bulkPublish');

        $this->assertTrue((bool) $event->fresh()->status_publikasi);

        // 4. Bulk Delete
        Livewire::test(\App\Livewire\Admin\Event\EventKelola::class)
            ->set('selectedEvent', [$event->id])
            ->call('bulkDelete');

        $this->assertNull(\App\Models\Event::find($event->id));
    }

    public function test_sejarah_crud_and_bulk_actions(): void
    {
        // 1. Create Sejarah
        Livewire::test(\App\Livewire\Admin\Organisasi\SejarahKelola::class)
            ->call('bukaFormTambah')
            ->set('tahun', '2026')
            ->set('judul', 'Tonggak Sejarah Uji Coba')
            ->set('deskripsi', 'Deskripsi narasi pengujian linimasa sejarah KORMI Kabupaten Bandung.')
            ->set('urutan', 1)
            ->set('status_tampil', true)
            ->call('simpan')
            ->assertHasNoErrors();

        $sejarah = \App\Models\LinimasaSejarah::where('judul', 'Tonggak Sejarah Uji Coba')->first();
        $this->assertNotNull($sejarah);

        // 2. Edit Sejarah
        Livewire::test(\App\Livewire\Admin\Organisasi\SejarahKelola::class)
            ->call('bukaFormEdit', $sejarah->id)
            ->set('judul', 'Tonggak Sejarah Uji Coba Updated')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('Tonggak Sejarah Uji Coba Updated', $sejarah->fresh()->judul);

        // 3. Toggle Status & Bulk Actions
        Livewire::test(\App\Livewire\Admin\Organisasi\SejarahKelola::class)
            ->call('toggleStatus', $sejarah->id);

        $this->assertFalse((bool) $sejarah->fresh()->status_tampil);

        Livewire::test(\App\Livewire\Admin\Organisasi\SejarahKelola::class)
            ->set('selectedSejarah', [$sejarah->id])
            ->call('bulkSetStatus', true);

        $this->assertTrue((bool) $sejarah->fresh()->status_tampil);

        // 4. Bulk Delete
        Livewire::test(\App\Livewire\Admin\Organisasi\SejarahKelola::class)
            ->set('selectedSejarah', [$sejarah->id])
            ->call('bulkDelete');

        $this->assertNull(\App\Models\LinimasaSejarah::find($sejarah->id));
    }

    public function test_visimisi_crud_and_bulk_actions(): void
    {
        // 1. Create VisiMisi
        Livewire::test(\App\Livewire\Admin\Organisasi\VisiMisiKelola::class)
            ->call('bukaFormTambah')
            ->set('jenis', 'misi')
            ->set('konten', 'Membangun ekosistem olahraga rekreasi yang inklusif dan berkelanjutan.')
            ->set('ikon', 'target')
            ->set('urutan', 1)
            ->set('status_tampil', true)
            ->call('simpan')
            ->assertHasNoErrors();

        $item = \App\Models\VisiMisiModel::where('konten', 'Membangun ekosistem olahraga rekreasi yang inklusif dan berkelanjutan.')->first();
        $this->assertNotNull($item);

        // 2. Edit VisiMisi
        Livewire::test(\App\Livewire\Admin\Organisasi\VisiMisiKelola::class)
            ->call('bukaFormEdit', $item->id)
            ->set('konten', 'Membangun ekosistem olahraga rekreasi yang inklusif dan berkelanjutan di Kab Bandung.')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('Membangun ekosistem olahraga rekreasi yang inklusif dan berkelanjutan di Kab Bandung.', $item->fresh()->konten);

        // 3. Toggle Status & Bulk Actions
        Livewire::test(\App\Livewire\Admin\Organisasi\VisiMisiKelola::class)
            ->call('toggleStatus', $item->id);

        $this->assertFalse((bool) $item->fresh()->status_tampil);

        Livewire::test(\App\Livewire\Admin\Organisasi\VisiMisiKelola::class)
            ->set('selectedVisiMisi', [$item->id])
            ->call('bulkSetStatus', true);

        $this->assertTrue((bool) $item->fresh()->status_tampil);

        // 4. Bulk Delete
        Livewire::test(\App\Livewire\Admin\Organisasi\VisiMisiKelola::class)
            ->set('selectedVisiMisi', [$item->id])
            ->call('bulkDelete');

        $this->assertNull(\App\Models\VisiMisiModel::find($item->id));
    }

    public function test_pengurus_crud_and_bulk_actions(): void
    {
        $periode = \App\Models\PeriodeKepengurusan::first();

        // 1. Create Pengurus
        Livewire::test(\App\Livewire\Admin\Organisasi\PengurusKelola::class)
            ->call('bukaFormTambah')
            ->set('periode_id', $periode->id)
            ->set('nama_lengkap', 'Drs. H. Uji Coba Pengurus, M.Si.')
            ->set('jabatan', 'Wakil Ketua Bidang Umum')
            ->set('kategori_bidang', 'Pimpinan Harian')
            ->set('urutan', 2)
            ->set('status_tampil', true)
            ->call('simpan')
            ->assertHasNoErrors();

        $pengurus = \App\Models\PengurusModel::where('nama_lengkap', 'Drs. H. Uji Coba Pengurus, M.Si.')->first();
        $this->assertNotNull($pengurus);

        // 2. Edit Pengurus
        Livewire::test(\App\Livewire\Admin\Organisasi\PengurusKelola::class)
            ->call('bukaFormEdit', $pengurus->id)
            ->set('jabatan', 'Wakil Ketua Umum I')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('Wakil Ketua Umum I', $pengurus->fresh()->jabatan);

        // 3. Toggle Status & Bulk Actions
        Livewire::test(\App\Livewire\Admin\Organisasi\PengurusKelola::class)
            ->call('toggleStatus', $pengurus->id);

        $this->assertFalse((bool) $pengurus->fresh()->status_tampil);

        Livewire::test(\App\Livewire\Admin\Organisasi\PengurusKelola::class)
            ->set('selectedPengurus', [$pengurus->id])
            ->call('bulkSetStatus', true);

        $this->assertTrue((bool) $pengurus->fresh()->status_tampil);

        // 4. Bulk Delete
        Livewire::test(\App\Livewire\Admin\Organisasi\PengurusKelola::class)
            ->set('selectedPengurus', [$pengurus->id])
            ->call('bulkDelete');

        $this->assertNull(\App\Models\PengurusModel::find($pengurus->id));
    }

    public function test_kordik_crud_and_bulk_actions(): void
    {
        $kecamatan = \App\Models\Kecamatan::first();
        $periode = \App\Models\PeriodeKepengurusan::first();

        // 1. Create Kordik
        Livewire::test(\App\Livewire\Admin\Organisasi\KordikKelola::class)
            ->call('bukaFormTambah')
            ->set('kecamatan_id', $kecamatan->id)
            ->set('periode_id', $periode->id)
            ->set('nama_ketua', 'Ahmad Subarkah, S.Pd.')
            ->set('nama_sekretaris', 'Budi Santoso')
            ->set('nama_bendahara', 'Citra Dewi')
            ->set('nomor_telepon', '081298765432')
            ->set('nomor_sk', 'SK/KORDIK/001/2026')
            ->set('status_aktif', true)
            ->call('simpan')
            ->assertHasNoErrors();

        $kordik = \App\Models\KordikPengurus::where('nama_ketua', 'Ahmad Subarkah, S.Pd.')->first();
        $this->assertNotNull($kordik);

        // 2. Edit Kordik
        Livewire::test(\App\Livewire\Admin\Organisasi\KordikKelola::class)
            ->call('bukaFormEdit', $kordik->id)
            ->set('nama_ketua', 'Ahmad Subarkah, S.Pd., M.M.')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('Ahmad Subarkah, S.Pd., M.M.', $kordik->fresh()->nama_ketua);

        // 3. Toggle Status & Bulk Actions
        Livewire::test(\App\Livewire\Admin\Organisasi\KordikKelola::class)
            ->call('toggleStatus', $kordik->id);

        $this->assertFalse((bool) $kordik->fresh()->status_aktif);

        Livewire::test(\App\Livewire\Admin\Organisasi\KordikKelola::class)
            ->set('selectedKordik', [$kordik->id])
            ->call('bulkSetStatus', true);

        $this->assertTrue((bool) $kordik->fresh()->status_aktif);

        // 4. Bulk Delete
        Livewire::test(\App\Livewire\Admin\Organisasi\KordikKelola::class)
            ->set('selectedKordik', [$kordik->id])
            ->call('bulkDelete');

        $this->assertNull(\App\Models\KordikPengurus::find($kordik->id));
    }

    public function test_proker_crud_and_bulk_actions(): void
    {
        // 1. Create Proker
        Livewire::test(\App\Livewire\Admin\Organisasi\ProkerKelola::class)
            ->call('bukaFormTambah')
            ->set('tahun_anggaran', 2026)
            ->set('nama_bidang', 'Bidang Olahraga Tradisional')
            ->set('nama_kegiatan', 'Festival Olahraga Tradisional Jawa Barat 2026')
            ->set('tujuan_kegiatan', 'Pelestarian permainan dan olahraga tradisional warisan budaya.')
            ->set('target_sasaran', '500 Peserta Pelajar & Umum')
            ->set('estimasi_anggaran', 50000000)
            ->set('status_kegiatan', 'rencana')
            ->set('bulan_mulai', 6)
            ->set('bulan_selesai', 6)
            ->call('simpan')
            ->assertHasNoErrors();

        $proker = \App\Models\ProgramKerja::where('nama_kegiatan', 'Festival Olahraga Tradisional Jawa Barat 2026')->first();
        $this->assertNotNull($proker);

        // 2. Edit Proker
        Livewire::test(\App\Livewire\Admin\Organisasi\ProkerKelola::class)
            ->call('bukaFormEdit', $proker->id)
            ->set('estimasi_anggaran', 75000000)
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals(75000000, (float) $proker->fresh()->estimasi_anggaran);

        // 3. Quick Status Update & Bulk Status
        Livewire::test(\App\Livewire\Admin\Organisasi\ProkerKelola::class)
            ->call('updateStatus', $proker->id, 'berjalan');

        $this->assertEquals('berjalan', $proker->fresh()->status_kegiatan);

        Livewire::test(\App\Livewire\Admin\Organisasi\ProkerKelola::class)
            ->set('selectedProker', [$proker->id])
            ->call('bulkSetStatus', 'selesai');

        $this->assertEquals('selesai', $proker->fresh()->status_kegiatan);

        // 4. Bulk Delete
        Livewire::test(\App\Livewire\Admin\Organisasi\ProkerKelola::class)
            ->set('selectedProker', [$proker->id])
            ->call('bulkDelete');

        $this->assertNull(\App\Models\ProgramKerja::find($proker->id));
    }

    public function test_pengaturan_situs_save(): void
    {
        Livewire::test(\App\Livewire\Admin\Pengaturan\PengaturanKelola::class)
            ->set('nama_situs', 'KORMI Kabupaten Bandung Official')
            ->set('tagline_situs', 'Sehat, Bugar, Gembira, Luar Biasa!')
            ->set('email_kontak', 'kontak@kormikabbdg.id')
            ->set('nomor_telepon', '022-85871234')
            ->set('nomor_whatsapp', '081234567890')
            ->set('instagram', 'https://instagram.com/kormikabupatenbandung')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertEquals('KORMI Kabupaten Bandung Official', \App\Models\PengaturanSitus::ambil('nama_situs'));
        $this->assertEquals('kontak@kormikabbdg.id', \App\Models\PengaturanSitus::ambil('email_kontak'));
        $this->assertEquals('https://instagram.com/kormikabupatenbandung', \App\Models\PengaturanSitus::ambil('instagram'));
    }
}






