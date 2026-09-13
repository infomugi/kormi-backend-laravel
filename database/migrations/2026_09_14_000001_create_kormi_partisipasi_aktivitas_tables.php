<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom profil dan approval pada sys_pengguna
        Schema::table('sys_pengguna', function (Blueprint $table) {
            if (!Schema::hasColumn('sys_pengguna', 'nik')) {
                $table->string('nik', 16)->nullable()->unique()->after('email');
            }
            if (!Schema::hasColumn('sys_pengguna', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('sys_pengguna', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('sys_pengguna', 'pekerjaan')) {
                $table->string('pekerjaan', 100)->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('sys_pengguna', 'kecamatan_id')) {
                $table->foreignUuid('kecamatan_id')->nullable()->after('nomor_telepon')->constrained('ref_kecamatan')->nullOnDelete();
            }
            if (!Schema::hasColumn('sys_pengguna', 'desa_kelurahan_id')) {
                $table->foreignUuid('desa_kelurahan_id')->nullable()->after('kecamatan_id')->constrained('ref_desa_kelurahan')->nullOnDelete();
            }
            if (!Schema::hasColumn('sys_pengguna', 'duta_id')) {
                $table->foreignUuid('duta_id')->nullable()->after('desa_kelurahan_id')->constrained('kormi_duta_olahraga')->nullOnDelete();
            }
            if (!Schema::hasColumn('sys_pengguna', 'disetujui_pada')) {
                $table->timestamp('disetujui_pada')->nullable()->after('status_aktif');
            }
            if (!Schema::hasColumn('sys_pengguna', 'disetujui_oleh')) {
                $table->foreignUuid('disetujui_oleh')->nullable()->after('disetujui_pada')->constrained('sys_pengguna')->nullOnDelete();
            }
        });

        // 2. Buat tabel kormi_partisipasi_aktivitas
        Schema::dropIfExists('kormi_partisipasi_aktivitas');
        Schema::create('kormi_partisipasi_aktivitas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pengguna_id')->constrained('sys_pengguna')->cascadeOnDelete();
            $table->enum('metode_pencatatan', ['mandiri', 'via_duta'])->default('mandiri');
            $table->foreignUuid('duta_id')->nullable()->constrained('kormi_duta_olahraga')->nullOnDelete();
            $table->foreignUuid('inorga_id')->nullable()->constrained('kormi_inorga')->nullOnDelete();
            $table->foreignUuid('kecamatan_id')->constrained('ref_kecamatan')->cascadeOnDelete();
            $table->foreignUuid('desa_kelurahan_id')->nullable()->constrained('ref_desa_kelurahan')->nullOnDelete();
            
            $table->string('nama_aktivitas', 200);
            $table->date('tanggal_aktivitas');
            $table->time('waktu_mulai')->nullable();
            $table->integer('durasi_menit')->default(30);
            
            $table->enum('jenis_partisipasi', ['individu', 'kelompok_kecil', 'massal_komunitas'])->default('individu');
            $table->integer('jumlah_peserta')->default(1);
            $table->text('daftar_nama_peserta')->nullable();
            
            $table->enum('kategori_lokasi', ['sapras_kormi', 'lapangan_desa', 'taman', 'jalan_desa', 'sekolah', 'rumah', 'lainnya'])->default('lapangan_desa');
            $table->foreignUuid('sapras_id')->nullable()->constrained('sarpras_fasilitas')->nullOnDelete();
            $table->string('nama_tempat', 255)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            $table->string('foto_kegiatan', 255)->nullable();
            $table->string('foto_daftar_hadir', 255)->nullable();
            $table->text('catatan')->nullable();
            
            $table->enum('status_verifikasi', ['valid', 'pending_review', 'ditolak'])->default('valid');
            $table->text('alasan_penolakan')->nullable();
            $table->foreignUuid('diverifikasi_oleh')->nullable()->constrained('sys_pengguna')->nullOnDelete();
            
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('dihapus_pada');

            $table->index(['tanggal_aktivitas', 'kecamatan_id']);
            $table->index(['duta_id', 'tanggal_aktivitas']);
            $table->index(['pengguna_id', 'tanggal_aktivitas']);
        });

        // 3. Buat tabel target tahunan APMO wilayah
        Schema::create('kormi_apmo_target_wilayah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('tahun');
            $table->foreignUuid('kecamatan_id')->constrained('ref_kecamatan')->cascadeOnDelete();
            $table->integer('estimasi_populasi')->default(50000);
            $table->decimal('target_persen_apmo', 5, 2)->default(40.00);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['tahun', 'kecamatan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kormi_apmo_target_wilayah');
        Schema::dropIfExists('kormi_partisipasi_aktivitas');
        
        Schema::table('sys_pengguna', function (Blueprint $table) {
            $table->dropForeign(['kecamatan_id']);
            $table->dropForeign(['desa_kelurahan_id']);
            $table->dropForeign(['duta_id']);
            $table->dropForeign(['disetujui_oleh']);
            $table->dropColumn([
                'nik',
                'jenis_kelamin',
                'tanggal_lahir',
                'pekerjaan',
                'kecamatan_id',
                'desa_kelurahan_id',
                'duta_id',
                'disetujui_pada',
                'disetujui_oleh',
            ]);
        });
    }
};
