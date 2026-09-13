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
        Schema::create('sys_menu', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('grup', ['frontend_header', 'frontend_footer', 'backend_sidebar'])->default('frontend_header')->index();
            $table->uuid('induk_id')->nullable()->index();
            $table->string('nama', 150);
            $table->string('tautan', 255)->default('#');
            $table->string('icon', 50)->nullable();
            $table->string('target', 20)->default('_self');
            $table->integer('urutan')->default(0);
            $table->boolean('status_aktif')->default(true)->index();
            $table->string('badge', 50)->nullable();
            $table->string('hak_akses', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('induk_id')->references('id')->on('sys_menu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_menu');
    }
};
