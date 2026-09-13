<?php

namespace App\Observers;

use App\Models\Core\LogAktivitas;
use Illuminate\Database\Eloquent\Model;

class AktivitasObserver
{
    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        // Jangan catat log jika model itu sendiri adalah LogAktivitas
        if ($model instanceof LogAktivitas) {
            return;
        }

        try {
            $dataBaru = $model->getAttributes();
            // Sensor password jika ada
            unset($dataBaru['kata_sandi'], $dataBaru['remember_token']);

            LogAktivitas::catat(
                jenisAksi: 'tambah',
                namaTabel: $model->getTable(),
                idEntitas: $model->getKey(),
                dataLama: null,
                dataBaru: $dataBaru
            );
        } catch (\Throwable $e) {
            // Silence exception agar tidak memutus flow utama
        }
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        if ($model instanceof LogAktivitas) {
            return;
        }

        try {
            $dataLama = $model->getOriginal();
            $dataBaru = $model->getChanges();

            unset($dataLama['kata_sandi'], $dataLama['remember_token']);
            unset($dataBaru['kata_sandi'], $dataBaru['remember_token']);

            LogAktivitas::catat(
                jenisAksi: 'ubah',
                namaTabel: $model->getTable(),
                idEntitas: $model->getKey(),
                dataLama: $dataLama,
                dataBaru: $dataBaru
            );
        } catch (\Throwable $e) {
            // Silence
        }
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        if ($model instanceof LogAktivitas) {
            return;
        }

        try {
            $dataLama = $model->getOriginal();
            unset($dataLama['kata_sandi'], $dataLama['remember_token']);

            LogAktivitas::catat(
                jenisAksi: 'hapus',
                namaTabel: $model->getTable(),
                idEntitas: $model->getKey(),
                dataLama: $dataLama,
                dataBaru: null
            );
        } catch (\Throwable $e) {
            // Silence
        }
    }
}
