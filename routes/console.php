<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('kormi:backup-db', function () {
    $dbPath = database_path('database.sqlite');
    if (!file_exists($dbPath)) {
        $this->error('File database.sqlite tidak ditemukan di folder database/');
        return;
    }

    $backupDir = storage_path('app/backups');
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0755, true);
    }

    $backupName = 'kormi_backup_' . date('Y-m-d_His') . '.sqlite';
    $targetPath = $backupDir . '/' . $backupName;

    if (copy($dbPath, $targetPath)) {
        $this->info("Database berhasil dicadangkan ke: {$targetPath} (" . round(filesize($targetPath) / 1024, 2) . " KB)");
    } else {
        $this->error('Gagal mencadangkan file database.');
    }
})->purpose('Cadangkan database SQLite KORMI ke storage lokal');
