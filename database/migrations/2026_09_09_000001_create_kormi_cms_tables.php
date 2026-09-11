<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. PERAN & PENGGUNA
        Schema::create('kormi_peran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_peran', 50);
            $table->string('slug', 50)->unique();
            $table->string('deskripsi', 255)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_pengguna', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('peran_id')->constrained('kormi_peran')->restrictOnDelete();
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->unique();
            $table->string('kata_sandi', 255);
            $table->string('nomor_telepon', 25)->nullable();
            $table->string('foto_profil', 255)->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->rememberToken();
            $table->timestamp('terakhir_masuk')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('dihapus_pada');
        });

        // 2. PENGATURAN SITUS & SEJARAH
        Schema::create('kormi_pengaturan_situs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kunci_pengaturan', 100)->unique();
            $table->longText('nilai_pengaturan')->nullable();
            $table->string('kelompok', 50)->default('umum');
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_linimasa_sejarah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tahun', 30);
            $table->string('judul', 200);
            $table->text('deskripsi');
            $table->string('gambar_url', 255)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('status_tampil')->default(true);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_visi_misi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('jenis', ['visi', 'misi', 'nilai_utama', 'motto', 'tujuan']);
            $table->text('konten');
            $table->string('ikon', 50)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('status_tampil')->default(true);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        // 3. WILAYAH (31 KECAMATAN & DESA)
        Schema::create('kormi_kecamatan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kecamatan', 100);
            $table->string('slug', 100)->unique();
            $table->string('alamat_kantor', 255)->nullable();
            $table->string('nomor_telepon', 25)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_desa_kelurahan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kecamatan_id')->constrained('kormi_kecamatan')->cascadeOnDelete();
            $table->string('nama_desa_kelurahan', 100);
            $table->string('slug', 100);
            $table->enum('jenis', ['desa', 'kelurahan'])->default('desa');
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
            $table->unique(['kecamatan_id', 'slug']);
        });

        // 4. STRUKTUR PENGURUS, KORDIK, DUTA, PROKER
        Schema::create('kormi_periode_kepengurusan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_periode', 50);
            $table->year('tahun_mulai');
            $table->year('tahun_selesai');
            $table->boolean('status_aktif')->default(false);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_pengurus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('periode_id')->constrained('kormi_periode_kepengurusan')->cascadeOnDelete();
            $table->string('nama_lengkap', 150);
            $table->string('jabatan', 100);
            $table->string('kategori_bidang', 100)->nullable();
            $table->string('foto_url', 255)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('status_tampil')->default(true);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_kordik_pengurus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kecamatan_id')->constrained('kormi_kecamatan')->cascadeOnDelete();
            $table->foreignUuid('periode_id')->constrained('kormi_periode_kepengurusan')->cascadeOnDelete();
            $table->string('nama_ketua', 150);
            $table->string('nama_sekretaris', 150)->nullable();
            $table->string('nama_bendahara', 150)->nullable();
            $table->string('nomor_telepon', 25)->nullable();
            $table->string('nomor_sk', 100)->nullable();
            $table->string('foto_ketua_url', 255)->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_duta_olahraga', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kecamatan_id')->constrained('kormi_kecamatan')->restrictOnDelete();
            $table->foreignUuid('desa_kelurahan_id')->nullable()->constrained('kormi_desa_kelurahan')->nullOnDelete();
            $table->string('nama_lengkap', 150);
            $table->integer('tahun_pemilihan')->default(2026);
            $table->string('kategori_duta', 100)->default('Duta Olahraga Masyarakat');
            $table->string('gelar_prestasi', 150)->nullable();
            $table->text('deskripsi_prestasi')->nullable();
            $table->string('akun_instagram', 100)->nullable();
            $table->string('foto_url', 255)->nullable();
            $table->boolean('status_unggulan')->default(false);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_program_kerja', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('tahun_anggaran');
            $table->string('nama_bidang', 100);
            $table->string('nama_kegiatan', 255);
            $table->text('tujuan_kegiatan')->nullable();
            $table->string('target_sasaran', 255)->nullable();
            $table->decimal('estimasi_anggaran', 15, 2)->nullable();
            $table->enum('status_kegiatan', ['rencana', 'berjalan', 'selesai', 'ditunda'])->default('rencana');
            $table->tinyInteger('bulan_mulai')->nullable();
            $table->tinyInteger('bulan_selesai')->nullable();
            $table->string('ikon', 50)->default('activity');
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        // 5. INORGA & KOMISI
        Schema::create('kormi_komisi_inorga', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_komisi', 100);
            $table->string('singkatan', 20)->unique();
            $table->text('deskripsi')->nullable();
            $table->string('kode_warna_hex', 10)->default('#1bb55c');
            $table->integer('urutan')->default(0);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_inorga', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('komisi_id')->constrained('kormi_komisi_inorga')->restrictOnDelete();
            $table->string('nama_inorga', 150);
            $table->string('singkatan', 30);
            $table->string('slug', 150)->unique();
            $table->string('nama_ketua', 150)->nullable();
            $table->string('kontak_person', 100)->nullable();
            $table->string('nomor_telepon', 25)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('alamat_sekretariat')->nullable();
            $table->string('nomor_sk', 100)->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->integer('jumlah_klub_anggota')->default(0);
            $table->string('logo_url', 255)->nullable();
            $table->enum('status_keanggotaan', ['aktif', 'masa_tenggang', 'tidak_aktif', 'verifikasi'])->default('aktif');
            $table->text('deskripsi_kegiatan')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        // 6. EVENT, CABANG, KLASEMEN, JADWAL
        Schema::create('kormi_kategori_event', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kategori', 100);
            $table->string('slug', 100)->unique();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_event', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kategori_event_id')->constrained('kormi_kategori_event')->restrictOnDelete();
            $table->string('judul_event', 200);
            $table->string('slug', 200)->unique();
            $table->integer('tahun_edisi');
            $table->string('lokasi_utama', 255);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('banner_url', 255)->nullable();
            $table->string('logo_event_url', 255)->nullable();
            $table->longText('deskripsi_lengkap')->nullable();
            $table->string('tautan_eksternal', 255)->nullable();
            $table->boolean('status_publikasi')->default(true);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_event_cabang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')->constrained('kormi_event')->cascadeOnDelete();
            $table->foreignUuid('inorga_id')->nullable()->constrained('kormi_inorga')->nullOnDelete();
            $table->string('nama_cabang', 150);
            $table->string('kategori_peserta', 100)->nullable();
            $table->string('aturan_juknis_url', 255)->nullable();
            $table->string('ikon', 50)->default('award');
            $table->string('kode_warna_hex', 20)->default('bg-amber-500');
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_event_klasemen_medali', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')->constrained('kormi_event')->cascadeOnDelete();
            $table->foreignUuid('kecamatan_id')->constrained('kormi_kecamatan')->cascadeOnDelete();
            $table->integer('jumlah_emas')->default(0);
            $table->integer('jumlah_perak')->default(0);
            $table->integer('jumlah_perunggu')->default(0);
            $table->integer('total_medali')->default(0);
            $table->integer('peringkat')->default(0);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
            $table->unique(['event_id', 'kecamatan_id']);
        });

        Schema::create('kormi_event_jadwal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')->constrained('kormi_event')->cascadeOnDelete();
            $table->string('fase_tahapan', 100);
            $table->date('tanggal');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('nama_kegiatan', 200);
            $table->string('tempat_arena', 150);
            $table->enum('status_tahapan', ['selesai', 'berlangsung', 'akan_datang'])->default('akan_datang');
            $table->string('keterangan', 255)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        // 7. APMO
        Schema::create('kormi_apmo_tahun', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('tahun')->unique();
            $table->string('tema_acara', 255)->nullable();
            $table->date('tanggal_penganugerahan')->nullable();
            $table->string('tempat_acara', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_apmo_penerima', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('apmo_tahun_id')->constrained('kormi_apmo_tahun')->cascadeOnDelete();
            $table->string('kategori_penghargaan', 100);
            $table->string('nama_penerima', 150);
            $table->string('asal_lembaga_wilayah', 150)->nullable();
            $table->text('deskripsi_capaian');
            $table->string('foto_url', 255)->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        // 8. SDI
        Schema::create('kormi_sdi_program', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul_program', 200);
            $table->string('slug', 200)->unique();
            $table->string('sasaran_peserta', 150)->nullable();
            $table->text('standar_kompetensi')->nullable();
            $table->string('jenis_sertifikasi', 100)->nullable();
            $table->string('banner_url', 255)->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_sdi_jadwal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('program_id')->constrained('kormi_sdi_program')->cascadeOnDelete();
            $table->string('nama_angkatan', 100);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('lokasi_pelatihan', 255);
            $table->integer('kuota_peserta')->default(30);
            $table->integer('jumlah_pendaftar')->default(0);
            $table->enum('status_pendaftaran', ['dibuka', 'berlangsung', 'selesai', 'penuh'])->default('dibuka');
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_sdi_peserta', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('jadwal_id')->constrained('kormi_sdi_jadwal')->cascadeOnDelete();
            $table->foreignUuid('kecamatan_id')->nullable()->constrained('kormi_kecamatan')->nullOnDelete();
            $table->string('nama_lengkap', 150);
            $table->string('nik', 20)->nullable();
            $table->string('nomor_telepon', 25);
            $table->string('email', 100)->nullable();
            $table->string('asal_lembaga_inorga', 150)->nullable();
            $table->enum('status_kelulusan', ['menunggu', 'diverifikasi', 'lulus', 'tidak_lulus'])->default('menunggu');
            $table->string('nomor_sertifikat', 100)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        // 9. SAPRAS
        Schema::create('kormi_sapras', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kecamatan_id')->constrained('kormi_kecamatan')->restrictOnDelete();
            $table->string('nama_fasilitas', 150);
            $table->string('kategori_fasilitas', 100);
            $table->text('alamat_lengkap');
            $table->string('kapasitas', 50)->nullable();
            $table->enum('status_kondisi', ['Baik', 'Perlu Renovasi', 'Dalam Pembangunan'])->default('Baik');
            $table->string('jenis_olahraga_tersedia', 255);
            $table->string('kontak_pengelola', 100)->nullable();
            $table->string('nomor_telepon', 25)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('foto_url', 255)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        // 10. BERITA, GALERI & UNDUHAN
        Schema::create('kormi_kategori_berita', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kategori', 100);
            $table->string('slug', 100)->unique();
            $table->string('kode_warna_hex', 10)->default('#1bb55c');
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_berita', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kategori_id')->constrained('kormi_kategori_berita')->restrictOnDelete();
            $table->foreignUuid('penulis_id')->constrained('kormi_pengguna')->restrictOnDelete();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->text('ringkasan');
            $table->longText('isi_konten');
            $table->string('gambar_utama', 255);
            $table->string('keterangan_gambar', 255)->nullable();
            $table->integer('jumlah_dilihat')->default(0);
            $table->boolean('status_unggulan')->default(false);
            $table->enum('status_publikasi', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('tanggal_publikasi')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('dihapus_pada');
        });

        Schema::create('kormi_galeri_album', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul_album', 200);
            $table->string('slug', 200)->unique();
            $table->date('tanggal_kegiatan')->nullable();
            $table->string('gambar_sampul', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('status_tampil')->default(true);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_galeri_foto', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('album_id')->constrained('kormi_galeri_album')->cascadeOnDelete();
            $table->string('judul_foto', 200);
            $table->string('gambar_url', 255);
            $table->text('keterangan_foto')->nullable();
            $table->enum('tipe_grid', ['normal', 'col-span-2 row-span-2', 'col-span-1 row-span-2', 'col-span-2 row-span-1'])->default('normal');
            $table->integer('urutan')->default(0);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_kategori_unduhan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kategori', 100);
            $table->string('slug', 100)->unique();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kormi_unduhan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kategori_id')->constrained('kormi_kategori_unduhan')->restrictOnDelete();
            $table->foreignUuid('pengunggah_id')->constrained('kormi_pengguna')->restrictOnDelete();
            $table->string('judul_dokumen', 255);
            $table->string('berkas_path', 255);
            $table->string('ekstensi_berkas', 10);
            $table->string('ukuran_berkas', 20);
            $table->string('nama_ikon', 50)->default('file-text');
            $table->integer('jumlah_unduhan')->default(0);
            $table->boolean('status_publik')->default(true);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('dihapus_pada');
        });

        // 11. AUDIT LOG
        Schema::create('kormi_log_aktivitas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pengguna_id')->nullable()->constrained('kormi_pengguna')->nullOnDelete();
            $table->string('jenis_aksi', 50);
            $table->string('nama_tabel', 100);
            $table->uuid('id_entitas')->nullable();
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();
            $table->string('alamat_ip', 45)->nullable();
            $table->string('agen_pengguna', 255)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kormi_log_aktivitas');
        Schema::dropIfExists('kormi_unduhan');
        Schema::dropIfExists('kormi_kategori_unduhan');
        Schema::dropIfExists('kormi_galeri_foto');
        Schema::dropIfExists('kormi_galeri_album');
        Schema::dropIfExists('kormi_berita');
        Schema::dropIfExists('kormi_kategori_berita');
        Schema::dropIfExists('kormi_sapras');
        Schema::dropIfExists('kormi_sdi_peserta');
        Schema::dropIfExists('kormi_sdi_jadwal');
        Schema::dropIfExists('kormi_sdi_program');
        Schema::dropIfExists('kormi_apmo_penerima');
        Schema::dropIfExists('kormi_apmo_tahun');
        Schema::dropIfExists('kormi_event_jadwal');
        Schema::dropIfExists('kormi_event_klasemen_medali');
        Schema::dropIfExists('kormi_event_cabang');
        Schema::dropIfExists('kormi_event');
        Schema::dropIfExists('kormi_kategori_event');
        Schema::dropIfExists('kormi_inorga');
        Schema::dropIfExists('kormi_komisi_inorga');
        Schema::dropIfExists('kormi_program_kerja');
        Schema::dropIfExists('kormi_duta_olahraga');
        Schema::dropIfExists('kormi_kordik_pengurus');
        Schema::dropIfExists('kormi_pengurus');
        Schema::dropIfExists('kormi_periode_kepengurusan');
        Schema::dropIfExists('kormi_desa_kelurahan');
        Schema::dropIfExists('kormi_kecamatan');
        Schema::dropIfExists('kormi_visi_misi');
        Schema::dropIfExists('kormi_linimasa_sejarah');
        Schema::dropIfExists('kormi_pengaturan_situs');
        Schema::dropIfExists('kormi_pengguna');
        Schema::dropIfExists('kormi_peran');
    }
};
