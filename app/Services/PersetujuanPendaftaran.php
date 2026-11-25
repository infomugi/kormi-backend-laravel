<?php

namespace App\Services;

use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use App\Models\Kormi\DutaOlahraga;
use Illuminate\Support\Facades\DB;

class PersetujuanPendaftaran
{
    public function akunPendaftar(DutaOlahraga $duta): ?Pengguna
    {
        return $duta->akunPendaftar
            ?? Pengguna::where('duta_id', $duta->id)->first();
    }

    public function setujuiDuta(DutaOlahraga $duta, ?string $adminId): void
    {
        DB::transaction(function () use ($duta, $adminId) {
            $duta->update([
                'status_pendaftaran' => DutaOlahraga::STATUS_DISETUJUI,
                'status_aktif'       => true,
                'disetujui_pada'     => now(),
                'disetujui_oleh'     => $adminId,
                'catatan_verifikasi' => null,
            ]);

            $akun = $this->akunPendaftar($duta);

            if (! $akun) {
                return;
            }

            $dataAkun = [
                'duta_id'        => $duta->id,
                'status_aktif'   => true,
                'disetujui_pada' => now(),
                'disetujui_oleh' => $adminId,
            ];

            // Hanya promotekan peran warga/pegiat; jangan turunkan peran admin.
            $slugPeran = $akun->peran?->slug;

            if ($akun->peran_id === null || $slugPeran === 'pegiat-olahraga') {
                $dataAkun['peran_id'] = $this->peranDuta()->id;
            }

            $akun->update($dataAkun);
        });
    }

    public function tolakDuta(DutaOlahraga $duta, ?string $catatan = null): bool
    {
        $akunDihapus = false;

        DB::transaction(function () use ($duta, $catatan, &$akunDihapus) {
            $duta->update([
                'status_pendaftaran' => DutaOlahraga::STATUS_DITOLAK,
                'status_aktif'       => false,
                'catatan_verifikasi' => $catatan ?: 'Ditolak oleh administrator',
                'disetujui_pada'     => null,
                'disetujui_oleh'     => null,
            ]);

            $akun = $this->akunPendaftar($duta);

            if (! $akun) {
                return;
            }

            $otomatisDibuat = ! $akun->status_aktif && $akun->disetujui_pada === null;

            if ($otomatisDibuat) {
                // Akun hasil pendaftaran tamu: hapus permanen agar email bebas
                // dipakai untuk mendaftar ulang.
                $duta->update(['pengguna_id' => null]);
                $akun->forceDelete();
                $akunDihapus = true;

                return;
            }

            // Akun yang sudah aktif sebelum mendaftar: cukup lepaskan tautan.
            $dataAkun = ['duta_id' => null];

            if ($akun->peran?->slug === 'duta-olahraga') {
                $dataAkun['peran_id'] = $this->peranPegiat()->id;
            }

            $akun->update($dataAkun);
        });

        return $akunDihapus;
    }

    public function setujuiAkun(Pengguna $user, ?string $adminId): void
    {
        DB::transaction(function () use ($user, $adminId) {
            $duta = DutaOlahraga::where('pengguna_id', $user->id)
                ->where('status_pendaftaran', DutaOlahraga::STATUS_MENUNGGU)
                ->first();

            if (! $duta && ! empty($user->duta_id)) {
                $duta = DutaOlahraga::where('id', $user->duta_id)
                    ->where('status_pendaftaran', DutaOlahraga::STATUS_MENUNGGU)
                    ->first();
            }

            $dataAkun = [
                'status_aktif'   => true,
                'disetujui_pada' => now(),
                'disetujui_oleh' => $adminId,
            ];

            if ($duta) {
                $duta->update([
                    'status_pendaftaran' => DutaOlahraga::STATUS_DISETUJUI,
                    'status_aktif'       => true,
                    'disetujui_pada'     => now(),
                    'disetujui_oleh'     => $adminId,
                    'catatan_verifikasi' => null,
                ]);

                $dataAkun['duta_id'] = $duta->id;

                $slugPeran = $user->peran?->slug;

                if ($user->peran_id === null || $slugPeran === 'pegiat-olahraga') {
                    $dataAkun['peran_id'] = $this->peranDuta()->id;
                }
            }

            $user->update($dataAkun);
        });
    }

    protected function peranDuta(): Peran
    {
        return Peran::firstOrCreate(
            ['slug' => 'duta-olahraga'],
            [
                'nama_peran' => 'Duta Olahraga Desa',
                'deskripsi'  => 'Duta Olahraga Desa/Kelurahan',
            ]
        );
    }

    protected function peranPegiat(): Peran
    {
        return Peran::firstOrCreate(
            ['slug' => 'pegiat-olahraga'],
            [
                'nama_peran' => 'Masyarakat / Pegiat Olahraga',
                'deskripsi'  => 'Masyarakat pencatat aktivitas olahraga mandiri',
            ]
        );
    }
}
