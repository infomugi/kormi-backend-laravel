<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom alur pendaftaran mandiri (self-registration) Duta Olahraga.
     * Default 'disetujui' agar data lama tetap tampil di halaman publik.
     */
    public function up(): void
    {
        Schema::table('kormi_duta_olahraga', function (Blueprint $table) {
            $table->enum('status_pendaftaran', ['menunggu', 'disetujui', 'ditolak'])
                ->default('disetujui')
                ->after('status_unggulan');
            $table->timestamp('disetujui_pada')->nullable()->after('status_pendaftaran');
            $table->foreignUuid('disetujui_oleh')
                ->nullable()
                ->after('disetujui_pada')
                ->constrained('sys_pengguna')
                ->nullOnDelete();
            $table->text('catatan_verifikasi')->nullable()->after('disetujui_oleh');

            $table->index('status_pendaftaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kormi_duta_olahraga', function (Blueprint $table) {
            $table->dropForeign(['disetujui_oleh']);
            $table->dropIndex(['status_pendaftaran']);
            $table->dropColumn([
                'status_pendaftaran',
                'disetujui_pada',
                'disetujui_oleh',
                'catatan_verifikasi',
            ]);
        });
    }
};
