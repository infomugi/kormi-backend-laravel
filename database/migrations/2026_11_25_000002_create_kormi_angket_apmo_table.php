<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kormi_angket_apmo', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pengguna_id')->nullable()->constrained('sys_pengguna')->nullOnDelete();

            // Bagian 1: identitas responden
            $table->string('nama_lengkap', 100);
            $table->unsignedTinyInteger('usia');
            $table->string('jenis_kelamin', 10);
            $table->unsignedSmallInteger('tinggi_badan')->nullable();
            $table->unsignedSmallInteger('berat_badan')->nullable();
            $table->text('alamat');
            $table->string('kecamatan', 100);
            $table->string('kabupaten_kota', 100)->default('Kabupaten Bandung');
            $table->string('pekerjaan', 40);
            $table->string('pekerjaan_lainnya', 100)->nullable();

            // Bagian 2: apakah berolahraga
            $table->boolean('melakukan_olahraga');

            // Bagian 3: jika berolahraga
            $table->string('frekuensi_berat', 20)->nullable();
            $table->unsignedTinyInteger('durasi_berat_jam')->nullable();
            $table->unsignedTinyInteger('durasi_berat_menit')->nullable();
            $table->boolean('durasi_berat_tidak_tahu')->default(false);
            $table->string('frekuensi_sedang', 20)->nullable();
            $table->unsignedTinyInteger('durasi_sedang_jam')->nullable();
            $table->unsignedTinyInteger('durasi_sedang_menit')->nullable();
            $table->boolean('durasi_sedang_tidak_tahu')->default(false);
            $table->string('frekuensi_jalan', 20)->nullable();
            $table->unsignedTinyInteger('durasi_jalan_jam')->nullable();
            $table->unsignedTinyInteger('durasi_jalan_menit')->nullable();
            $table->boolean('durasi_jalan_tidak_tahu')->default(false);
            $table->string('cabang_olahraga', 30)->nullable();
            $table->string('cabang_lainnya', 100)->nullable();
            $table->string('tujuan_olahraga', 30)->nullable();
            $table->string('tujuan_lainnya', 100)->nullable();
            $table->string('jalur_olahraga', 20)->nullable();
            $table->string('jalur_lainnya', 100)->nullable();
            $table->string('pernah_malas', 20)->nullable();
            $table->unsignedTinyInteger('duduk_jam')->nullable();
            $table->unsignedTinyInteger('duduk_menit')->nullable();
            $table->boolean('duduk_tidak_tahu')->default(false);

            // Bagian 4: jika tidak berolahraga
            $table->string('alasan_tidak_olahraga', 30)->nullable();
            $table->string('alasan_lainnya', 100)->nullable();

            // Penilaian fasilitas (No. 19 / No. 21)
            $table->string('fasilitas_olahraga', 20)->nullable();

            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();

            $table->index('pengguna_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kormi_angket_apmo');
    }
};
