<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom penghubung data pendaftaran Duta Olahraga ke akun pengguna pendaftar.
     *
     * Berbeda dengan sys_pengguna.duta_id (diisi saat pendaftaran disetujui),
     * kolom ini mencatat siapa pemilik pendaftaran sejak data dibuat sehingga
     * penautan akun dapat dilakukan (deferred) pada saat approval administrator.
     */
    public function up(): void
    {
        Schema::table('kormi_duta_olahraga', function (Blueprint $table) {
            $table->foreignUuid('pengguna_id')
                ->nullable()
                ->after('disetujui_oleh')
                ->constrained('sys_pengguna')
                ->nullOnDelete();

            $table->index('pengguna_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kormi_duta_olahraga', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropIndex(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });
    }
};
