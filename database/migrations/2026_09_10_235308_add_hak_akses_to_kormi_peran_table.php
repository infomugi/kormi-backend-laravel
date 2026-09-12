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
        // Handled directly in base migration (sys_peran.hak_akses)
        if (!Schema::hasColumn('sys_peran', 'hak_akses')) {
            Schema::table('sys_peran', function (Blueprint $table) {
                $table->json('hak_akses')->nullable()->after('deskripsi');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sys_peran', 'hak_akses')) {
            Schema::table('sys_peran', function (Blueprint $table) {
                $table->dropColumn('hak_akses');
            });
        }
    }
};
