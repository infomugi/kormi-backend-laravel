<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sys_pengguna', function (Blueprint $table) {
            $table->timestamp('terakhir_aktif')->nullable()->after('terakhir_masuk');
        });
    }

    public function down(): void
    {
        Schema::table('sys_pengguna', function (Blueprint $table) {
            $table->dropColumn('terakhir_aktif');
        });
    }
};
