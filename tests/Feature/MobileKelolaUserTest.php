<?php

namespace Tests\Feature;

use App\Livewire\Mobile\KelolaUser;
use App\Models\Core\Pengguna;
use App\Models\Core\Peran;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class MobileKelolaUserTest extends TestCase
{
    use DatabaseTransactions;

    private Peran $peranSuper;
    private Peran $peranPegiat;
    private Peran $peranEditor;
    private Pengguna $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        // firstOrCreate agar test portabel pada DB tanpa seeder peran.
        $this->peranSuper = Peran::firstOrCreate(
            ['slug' => 'super-admin'],
            ['nama_peran' => 'Super Admin', 'deskripsi' => 'Akses penuh sistem']
        );
        $this->peranPegiat = Peran::firstOrCreate(
            ['slug' => 'pegiat-olahraga'],
            ['nama_peran' => 'Masyarakat / Pegiat Olahraga', 'deskripsi' => 'Warga']
        );
        $this->peranEditor = Peran::firstOrCreate(
            ['slug' => 'editor-berita'],
            ['nama_peran' => 'Editor Konten', 'deskripsi' => 'Editor berita']
        );

        // Nama berawalan "Aaa" agar berada di halaman pertama berapa pun jumlah data demo.
        $this->superAdmin = $this->buatPengguna('Aaa Super Uji Kelola', $this->peranSuper->id);
    }

    private function buatPengguna(string $nama, string $peranId, bool $aktif = true): Pengguna
    {
        return Pengguna::create([
            'peran_id' => $peranId,
            'nama_lengkap' => $nama,
            'email' => 'uji.kelola.' . uniqid() . '@contoh.id',
            'kata_sandi' => 'password123',
            'status_aktif' => $aktif,
        ]);
    }

    // ---------------------------------------------------------------
    // 1. Akses
    // ---------------------------------------------------------------

    public function test_guest_diarahkan_ke_login(): void
    {
        $this->get(route('mobile.kelola-user'))->assertRedirect('/login');
    }

    public function test_non_superadmin_mendapat_403(): void
    {
        $this->actingAs($this->buatPengguna('Aab Editor Uji Akses', $this->peranEditor->id))
            ->get(route('mobile.kelola-user'))
            ->assertForbidden();
    }

    /**
     * Regresi M1: guard superadmin harus berjalan pada SETIAP request Livewire,
     * bukan hanya saat mount. Snapshot lama (render sebagai superadmin) tidak boleh
     * bisa melakukan update setelah sesi berganti menjadi non-superadmin.
     */
    public function test_m1_update_livewire_ditolak_setelah_sesi_berubah_jadi_non_superadmin(): void
    {
        $editor = $this->buatPengguna('Aab Editor M1 Uji', $this->peranEditor->id);
        $target = $this->buatPengguna('Aab Target M1 Uji', $this->peranPegiat->id);

        // Render awal sebagai superadmin berhasil (membuktikan mount() lolos).
        Livewire::actingAs($this->superAdmin);
        $komponen = Livewire::test(KelolaUser::class)
            ->assertSee($target->nama_lengkap);

        // Kontrol: update yang sama berhasil selama sesi masih superadmin.
        $komponen->set('cari', 'zzq')->assertOk()->assertSet('cari', 'zzq');
        $komponen->set('cari', '')->assertOk();

        // Sesi berganti menjadi non-superadmin (mis. sesi lain login editor / snapshot lama).
        // Catatan: harness Livewire 4 tidak melempar HttpException pada request update;
        // ia mengembalikan respons non-OK dan state komponen kosong (lihat SubsequentRender).
        // Jadi guard booted diverifikasi lewat status respons 403 + HTML kosong.
        $this->actingAs($editor);
        $komponen->set('cari', 'M1')->assertStatus(403);

        $this->assertSame('', $komponen->html(), 'Respons 403 tidak boleh merender daftar user.');
        $this->assertNull($komponen->get('cari'), 'Update yang ditolak tidak boleh mengembalikan state komponen.');

        // Aksi eksplisit juga harus ditolak, bukan hanya update properti.
        Livewire::actingAs($this->superAdmin);
        $aksi = Livewire::test(KelolaUser::class);
        $this->actingAs($editor);
        $aksi->call('impersonate', $target->id)->assertStatus(403);
        $this->assertSame('', $aksi->html(), 'Respons 403 tidak boleh merender daftar user.');

        $this->assertSame($editor->id, auth()->id());
        $this->assertNull(session('impersonator_id'));
    }

    public function test_superadmin_melihat_daftar_user_dan_quick_action_dashboard(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(route('mobile.kelola-user'))
            ->assertOk()
            ->assertSee('Kelola User')
            ->assertSee('Cari nama / email')
            ->assertSee('Masuk sebagai')
            ->assertSee('Akun Anda')
            ->assertSee($this->superAdmin->nama_lengkap);

        // Quick action hanya untuk superadmin.
        $this->actingAs($this->superAdmin)
            ->get(route('mobile.dashboard'))
            ->assertOk()
            ->assertSee('Kelola User')
            ->assertSee(route('mobile.kelola-user'), false);

        $this->actingAs($this->buatPengguna('Aab Editor Uji Dashboard', $this->peranEditor->id))
            ->get(route('mobile.dashboard'))
            ->assertOk()
            ->assertDontSee('Kelola User')
            ->assertDontSee(route('mobile.kelola-user'), false);
    }

    // ---------------------------------------------------------------
    // 2. Filter peran & pencarian
    // ---------------------------------------------------------------

    public function test_filter_peran_dan_reset_ke_semua(): void
    {
        // Token unik dipakai pada nama & pencarian agar tidak bergantung data demo/pagination.
        $token = 'Zft' . substr(uniqid(), -7);
        $pegiat = $this->buatPengguna($token . ' Pegiat Filter', $this->peranPegiat->id);
        $editor = $this->buatPengguna($token . ' Editor Filter', $this->peranEditor->id);

        $this->actingAs($this->superAdmin);

        Livewire::test(KelolaUser::class)
            ->set('cari', $token)
            ->assertSee($pegiat->nama_lengkap)
            ->assertSee($editor->nama_lengkap)
            ->set('peranDipilih', $this->peranPegiat->id)
            ->assertSet('peranDipilih', $this->peranPegiat->id)
            ->assertSee($pegiat->nama_lengkap)
            ->assertDontSee($editor->nama_lengkap)
            ->set('peranDipilih', 'Semua')
            ->assertSet('peranDipilih', 'Semua')
            ->assertSee($pegiat->nama_lengkap)
            ->assertSee($editor->nama_lengkap);
    }

    public function test_pencarian_nama_dan_email_serta_reset_halaman(): void
    {
        $target = $this->buatPengguna('Aab Cari Nama Unik Zxq', $this->peranPegiat->id);
        $lain = $this->buatPengguna('Aac Lain Cari Uji', $this->peranEditor->id);

        $this->actingAs($this->superAdmin);

        $komponen = Livewire::test(KelolaUser::class)
            ->set('cari', 'Zxq')
            ->assertSee($target->nama_lengkap)
            ->assertDontSee($lain->nama_lengkap);

        // Pencarian via email.
        $komponen->set('cari', $target->email)
            ->assertSee($target->nama_lengkap)
            ->assertDontSee($lain->nama_lengkap);

        // Perubahan pencarian mereset halaman ke 1.
        Livewire::test(KelolaUser::class)
            ->call('setPage', 2)
            ->assertSet('paginators.page', 2)
            ->set('cari', 'Zxq')
            ->assertSet('paginators.page', 1)
            ->assertSee($target->nama_lengkap);
    }

    public function test_paginasi_per_halaman_dan_navigasi_tanpa_bergantung_data_demo(): void
    {
        // Prefix unik: hanya user uji ini yang ikut hasil pencarian, berapa pun data demo.
        $prefix = 'Zpg' . substr(uniqid(), -7);
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $users[] = $this->buatPengguna($prefix . ' ' . $i, $this->peranPegiat->id);
        }

        $this->actingAs($this->superAdmin);

        // Kontrak default: 12 per halaman.
        Livewire::test(KelolaUser::class)->assertSet('perPage', 12);

        $komponen = Livewire::test(KelolaUser::class)
            ->set('perPage', 2)
            ->set('cari', $prefix)
            ->assertSee('1 / 3')
            ->assertSee($users[0]->nama_lengkap)
            ->assertSee($users[1]->nama_lengkap)
            ->assertDontSee($users[2]->nama_lengkap)
            ->assertSee('Sebelumnya')
            ->assertSee('Berikutnya');

        $komponen->call('nextPage')
            ->assertSee('2 / 3')
            ->assertSee($users[2]->nama_lengkap)
            ->assertSee($users[3]->nama_lengkap)
            ->assertDontSee($users[0]->nama_lengkap);

        $komponen->call('nextPage')
            ->assertSee('3 / 3')
            ->assertSee($users[4]->nama_lengkap)
            ->assertDontSee($users[0]->nama_lengkap);

        $komponen->call('previousPage')
            ->assertSee('2 / 3');
    }

    // ---------------------------------------------------------------
    // 3. Impersonasi
    // ---------------------------------------------------------------

    public function test_impersonate_sukses_mengubah_sesi_dan_redirect_dashboard(): void
    {
        $target = $this->buatPengguna('Aab Target Impersonasi Uji', $this->peranPegiat->id);

        $this->actingAs($this->superAdmin);

        Livewire::test(KelolaUser::class)
            ->call('impersonate', $target->id)
            ->assertRedirect(route('mobile.dashboard'))
            ->assertHasNoErrors();

        $this->assertSame($target->id, auth()->id());
        $this->assertSame($this->superAdmin->id, session('impersonator_id'));
        $this->assertSame($this->superAdmin->nama_lengkap, session('impersonator_name'));
        $this->assertStringContainsString('Mode impersonasi aktif', (string) session('pesan'));
    }

    public function test_impersonate_diri_sendiri_ditolak(): void
    {
        $this->actingAs($this->superAdmin);

        Livewire::test(KelolaUser::class)
            ->call('impersonate', $this->superAdmin->id)
            ->assertSet('galat', 'Anda saat ini sudah masuk sebagai akun ini.')
            ->assertNoRedirect();

        $this->assertSame($this->superAdmin->id, auth()->id());
        $this->assertNull(session('impersonator_id'));
    }

    public function test_impersonate_akun_nonaktif_ditolak(): void
    {
        $nonaktif = $this->buatPengguna('Aab Nonaktif Uji', $this->peranPegiat->id, false);

        $this->actingAs($this->superAdmin);

        Livewire::test(KelolaUser::class)
            ->call('impersonate', $nonaktif->id)
            ->assertSet('galat', 'Akun ' . $nonaktif->nama_lengkap . ' sedang nonaktif. Aktifkan akun terlebih dahulu sebelum login.')
            ->assertNoRedirect();

        $this->assertSame($this->superAdmin->id, auth()->id());
        $this->assertNull(session('impersonator_id'));
    }

    public function test_impersonate_ditolak_bila_sudah_dalam_mode_impersonasi(): void
    {
        $target = $this->buatPengguna('Aab Target Ganda Uji', $this->peranPegiat->id);

        $this->actingAs($this->superAdmin);
        $this->withSession([
            'impersonator_id' => $this->superAdmin->id,
            'impersonator_name' => $this->superAdmin->nama_lengkap,
        ]);

        Livewire::test(KelolaUser::class)
            ->call('impersonate', $target->id)
            ->assertSet('galat', 'Selesaikan mode impersonasi terlebih dahulu sebelum masuk sebagai pengguna lain.')
            ->assertNoRedirect();

        $this->assertSame($this->superAdmin->id, auth()->id());
        $this->assertSame($this->superAdmin->id, session('impersonator_id'));
    }

    public function test_halaman_tetap_tertutup_saat_berimpersonasi_sebagai_non_superadmin(): void
    {
        $target = $this->buatPengguna('Aab Target Non Super Uji', $this->peranPegiat->id);

        $this->actingAs($target);
        $this->withSession([
            'impersonator_id' => $this->superAdmin->id,
            'impersonator_name' => $this->superAdmin->nama_lengkap,
        ]);

        $this->get(route('mobile.kelola-user'))->assertForbidden();

        // Dashboard sebagai pegiat hasil impersonasi tidak menampilkan menu Kelola User.
        $this->get(route('mobile.dashboard'))
            ->assertOk()
            ->assertSee('Kembali ke Super Admin')
            ->assertDontSee(route('mobile.kelola-user'), false);
    }

    // ---------------------------------------------------------------
    // 4. Banner & keluar dari impersonasi
    // ---------------------------------------------------------------

    public function test_banner_impersonasi_tampil_hanya_saat_mode_impersonasi(): void
    {
        $target = $this->buatPengguna('Aab Target Banner Uji', $this->peranPegiat->id);

        $this->actingAs($this->superAdmin)
            ->get(route('mobile.dashboard'))
            ->assertOk()
            ->assertDontSee('Kembali ke Super Admin');

        $this->actingAs($target);
        $this->withSession([
            'impersonator_id' => $this->superAdmin->id,
            'impersonator_name' => $this->superAdmin->nama_lengkap,
        ]);

        $this->get(route('mobile.dashboard'))
            ->assertOk()
            ->assertSee('Mode impersonasi')
            ->assertSee('Kembali ke Super Admin')
            ->assertSee('asal=mobile', false);
    }

    public function test_pesan_sukses_tampil_sekali_dan_hilang_setelah_filter_atau_pencarian(): void
    {
        $this->actingAs($this->superAdmin);

        // Pesan hasil restore impersonasi: tampil sekali lalu di-pull dari session.
        $this->withSession(['pesan' => 'Pesan uji pencarian.']);
        Livewire::test(KelolaUser::class)
            ->assertSee('Pesan uji pencarian.')
            ->set('cari', 'zzq')
            ->assertSet('pesan', null)
            ->assertDontSee('Pesan uji pencarian.');

        $this->assertNull(session('pesan'));

        $this->withSession(['pesan' => 'Pesan uji filter.']);
        Livewire::test(KelolaUser::class)
            ->assertSee('Pesan uji filter.')
            ->set('peranDipilih', $this->peranPegiat->id)
            ->assertSet('pesan', null)
            ->assertDontSee('Pesan uji filter.');
    }

    public function test_keluar_impersonasi_dengan_asal_mobile_kembali_ke_kelola_user(): void
    {
        $target = $this->buatPengguna('Aab Target Keluar Uji', $this->peranPegiat->id);

        $this->actingAs($target);
        $this->withSession([
            'impersonator_id' => $this->superAdmin->id,
            'impersonator_name' => $this->superAdmin->nama_lengkap,
        ]);

        $this->get(route('admin.impersonate.leave', ['asal' => 'mobile']))
            ->assertRedirect(route('mobile.kelola-user'));

        $this->assertSame($this->superAdmin->id, auth()->id());
        $this->assertNull(session('impersonator_id'));
        $this->assertNull(session('impersonator_name'));
        $this->assertStringContainsString('Berhasil kembali', (string) session('pesan'));
    }

    public function test_keluar_impersonasi_tanpa_asal_tetap_ke_halaman_pengguna_desktop(): void
    {
        $target = $this->buatPengguna('Aab Target Keluar Desktop', $this->peranPegiat->id);

        $this->actingAs($target);
        $this->withSession([
            'impersonator_id' => $this->superAdmin->id,
            'impersonator_name' => $this->superAdmin->nama_lengkap,
        ]);

        $this->get(route('admin.impersonate.leave'))
            ->assertRedirect(route('admin.pengguna'));

        $this->assertSame($this->superAdmin->id, auth()->id());
        $this->assertNull(session('impersonator_id'));
    }
}
