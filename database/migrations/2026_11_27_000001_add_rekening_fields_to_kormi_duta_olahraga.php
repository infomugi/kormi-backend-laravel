<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah data rekening bank pada profil Duta Olahraga.
     */
    public function up(): void
    {
        Schema::table('kormi_duta_olahraga', function (Blueprint $table) {
            $table->string('nama_bank', 50)->nullable()->after('akun_instagram');
            $table->string('nomor_rekening', 30)->nullable()->after('nama_bank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kormi_duta_olahraga', function (Blueprint $table) {
            $table->dropColumn(['nama_bank', 'nomor_rekening']);
        });
    }
};