<?php

namespace Database\Seeders;

use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyAkunRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passwordHash = Hash::make('password123');

        $accounts = [
            [
                'role_slug' => 'super-admin',
                'nama_lengkap' => 'Super Administrator KORMI',
                'email' => 'superadmin@kormibdg.id',
                'nomor_telepon' => '081220000001',
            ],
            [
                'role_slug' => 'super-admin',
                'nama_lengkap' => 'Super Admin KORMI',
                'email' => 'admin@kormibdg.id',
                'nomor_telepon' => '081234567890',
            ],
            [
                'role_slug' => 'admin-korcam',
                'nama_lengkap' => 'Admin KORCAM Soreang',
                'email' => 'admin.korcam@kormibdg.id',
                'nomor_telepon' => '081220000002',
            ],
            [
                'role_slug' => 'admin-inorga',
                'nama_lengkap' => 'Admin INORGA Kab. Bandung',
                'email' => 'admin.inorga@kormibdg.id',
                'nomor_telepon' => '081220000003',
            ],
            [
                'role_slug' => 'editor-berita',
                'nama_lengkap' => 'Editor Berita & Publikasi',
                'email' => 'editor.berita@kormibdg.id',
                'nomor_telepon' => '081220000004',
            ],
            [
                'role_slug' => 'duta-olahraga',
                'nama_lengkap' => 'Duta Olahraga Desa Ciburial',
                'email' => 'duta.olahraga@kormibdg.id',
                'nomor_telepon' => '081220000005',
            ],
            [
                'role_slug' => 'pegiat-olahraga',
                'nama_lengkap' => 'Warga Pegiat Olahraga',
                'email' => 'warga@kormibdg.id',
                'nomor_telepon' => '081220000006',
            ],
        ];

        foreach ($accounts as $acc) {
            $peran = Peran::where('slug', $acc['role_slug'])->first();

            if (!$peran) {
                continue;
            }

            $user = Pengguna::where('email', $acc['email'])->first();

            if ($user) {
                $user->update([
                    'peran_id' => $peran->id,
                    'nama_lengkap' => $acc['nama_lengkap'],
                    'nomor_telepon' => $acc['nomor_telepon'],
                    'kata_sandi' => $passwordHash,
                    'status_aktif' => true,
                    'terakhir_masuk' => now(),
                ]);
            } else {
                Pengguna::create([
                    'id' => (string) Str::uuid(),
                    'peran_id' => $peran->id,
                    'nama_lengkap' => $acc['nama_lengkap'],
                    'email' => $acc['email'],
                    'nomor_telepon' => $acc['nomor_telepon'],
                    'kata_sandi' => $passwordHash,
                    'status_aktif' => true,
                    'terakhir_masuk' => now(),
                ]);
            }
        }
    }
}
