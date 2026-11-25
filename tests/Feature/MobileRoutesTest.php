<?php

namespace Tests\Feature;

use App\Models\Core\Pengguna;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MobileRoutesTest extends TestCase
{
    use DatabaseTransactions;

    private const UA_MOBILE = 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1';

    public function test_halaman_daftar_duta_mengalihkan_pengunjung_mobile(): void
    {
        $this->withHeader('User-Agent', self::UA_MOBILE)
            ->get('/daftar-duta')
            ->assertRedirect('/mobile/daftar-duta');
    }

    public function test_halaman_login_mengalihkan_pengunjung_mobile(): void
    {
        $this->withHeader('User-Agent', self::UA_MOBILE)
            ->get('/login')
            ->assertRedirect('/mobile/login');
    }

    public function test_halaman_mobile_tampil_tanpa_chrome_situs(): void
    {
        $this->get('/mobile/daftar-duta')
            ->assertOk()
            ->assertSee('kd-tabbar', false)
            ->assertDontSee('Daftar Menjadi Duta Olahraga');

        $this->get('/mobile/login')
            ->assertOk()
            ->assertSee('kd-mobile', false)
            ->assertDontSee('Panel Masuk CMS');
    }

    public function test_halaman_mobile_beranda_tampil(): void
    {
        $this->get('/mobile/beranda')
            ->assertOk()
            ->assertSee('kd-mobile', false)
            ->assertSee('Selamat Datang')
            ->assertSee('kd-tabbar', false);
    }

    public function test_halaman_mobile_direktori_duta_tampil(): void
    {
        $this->get('/mobile/direktori-duta')
            ->assertOk()
            ->assertSee('kd-mobile', false)
            ->assertSee('Duta Olahraga Desa')
            ->assertSee('kd-tabbar', false);
    }

    public function test_beranda_dan_direktori_desktop_tidak_mengalihkan_mobile(): void
    {
        $this->withHeader('User-Agent', self::UA_MOBILE)
            ->get('/')
            ->assertOk()
            ->assertDontSee('kd-mobile', false);

        $this->withHeader('User-Agent', self::UA_MOBILE)
            ->get('/duta-olahraga')
            ->assertOk();
    }

    public function test_halaman_desktop_tidak_memuat_markup_mobile(): void
    {
        $this->get('/daftar-duta')
            ->assertOk()
            ->assertSee('Daftar Menjadi Duta Olahraga')
            ->assertDontSee('kd-mobile', false);
    }

    public function test_admin_masuk_tetap_dapat_diakses_dari_mobile(): void
    {
        $this->withHeader('User-Agent', self::UA_MOBILE)
            ->get('/admin/masuk')
            ->assertOk();
    }

    public function test_halaman_mobile_lupa_password_tampil(): void
    {
        $this->get('/mobile/lupa-password')
            ->assertOk()
            ->assertSee('kd-mobile', false)
            ->assertSee('Lupa Kata Sandi')
            ->assertSee('/mobile/login', false);
    }

    public function test_halaman_mobile_daftar_akun_tampil(): void
    {
        $this->get('/mobile/daftar')
            ->assertOk()
            ->assertSee('kd-mobile', false)
            ->assertSee('Daftar Akun')
            ->assertSee('/mobile/login', false);
    }

    public function test_login_mobile_menautkan_halaman_lupa_password_dan_daftar(): void
    {
        $this->get('/mobile/login')
            ->assertOk()
            ->assertSee('href="' . url('/mobile/lupa-password') . '"', false)
            ->assertSee('href="' . url('/mobile/daftar') . '"', false);
    }

    public function test_halaman_admin_daftar_dan_lupa_password_mengalihkan_pengunjung_mobile(): void
    {
        $this->withHeader('User-Agent', self::UA_MOBILE)
            ->get('/admin/daftar')->assertRedirect('/mobile/daftar');
        $this->withHeader('User-Agent', self::UA_MOBILE)
            ->get('/admin/register')->assertRedirect('/mobile/daftar');
        $this->withHeader('User-Agent', self::UA_MOBILE)
            ->get('/admin/lupa-password')->assertRedirect('/mobile/lupa-password');
        $this->withHeader('User-Agent', self::UA_MOBILE)
            ->get('/admin/forgot-password')->assertRedirect('/mobile/lupa-password');
        $this->withHeader('User-Agent', self::UA_MOBILE)
            ->get('/admin/reset-password')->assertRedirect('/mobile/lupa-password');
    }

    public function test_halaman_admin_daftar_dan_lupa_password_tetap_desktop(): void
    {
        $this->get('/admin/daftar')->assertOk();
        $this->get('/admin/lupa-password')->assertOk();
    }

    public function test_login_mobile_duta_mengarahkan_ke_dashboard_mobile(): void
    {
        $this->assertNotNull(Pengguna::where('email', 'duta.olahraga@kormibdg.id')->first());

        \Livewire\Livewire::test(\App\Livewire\Mobile\Masuk::class)
            ->set('email', 'duta.olahraga@kormibdg.id')
            ->set('kata_sandi', 'password123')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('mobile.dashboard'));
    }

    public function test_login_desktop_duta_tetap_ke_dashboard_admin(): void
    {
        \Livewire\Livewire::test(\App\Livewire\Backend\Auth\Masuk::class)
            ->set('email', 'duta.olahraga@kormibdg.id')
            ->set('kata_sandi', 'password123')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_dashboard_mobile_butuh_login_dan_melayani_duta_serta_admin(): void
    {
        $this->get('/mobile/dashboard')->assertRedirect('/login');

        $duta = Pengguna::where('email', 'duta.olahraga@kormibdg.id')->firstOrFail();
        $this->actingAs($duta)
            ->get('/mobile/dashboard')
            ->assertOk()
            ->assertSee('kd-mobile', false)
            ->assertSee('Absensi hari ini')
            ->assertSee('Survei APMO');

        $admin = Pengguna::whereHas('peran', fn ($q) => $q->where('slug', 'super-admin'))->firstOrFail();
        $this->actingAs($admin)
            ->get('/mobile/dashboard')
            ->assertOk()
            ->assertDontSee('Absensi hari ini')
            ->assertDontSee('Isi Survei Sekarang')
            ->assertDontSee('Perbarui Jawaban Survei');
    }

    public function test_login_mobile_peran_admin_mengarahkan_ke_dashboard_mobile(): void
    {
        foreach ([
            'admin@kormibdg.id',
            'admin.korcam@kormibdg.id',
            'admin.inorga@kormibdg.id',
            'editor.berita@kormibdg.id',
        ] as $email) {
            \Livewire\Livewire::test(\App\Livewire\Mobile\Masuk::class)
                ->set('email', $email)
                ->set('kata_sandi', 'password123')
                ->call('login')
                ->assertHasNoErrors()
                ->assertRedirect(route('mobile.dashboard'));
        }
    }

    public function test_login_desktop_peran_admin_tetap_ke_dashboard_admin(): void
    {
        foreach ([
            'admin@kormibdg.id',
            'admin.korcam@kormibdg.id',
            'admin.inorga@kormibdg.id',
            'editor.berita@kormibdg.id',
        ] as $email) {
            \Livewire\Livewire::test(\App\Livewire\Backend\Auth\Masuk::class)
                ->set('email', $email)
                ->set('kata_sandi', 'password123')
                ->call('login')
                ->assertHasNoErrors()
                ->assertRedirect(route('admin.dashboard'));
        }
    }

    public function test_dashboard_mobile_peran_admin_menampilkan_ringkasan_sesuai_peran(): void
    {
        $harapan = [
            'admin@kormibdg.id' => ['Super Admin', 'admin.galeri'],
            'admin.korcam@kormibdg.id' => ['Korcam', 'admin.duta'],
            'admin.inorga@kormibdg.id' => ['Inorga', 'admin.inorga'],
            'editor.berita@kormibdg.id' => ['Editor', 'admin.berita'],
        ];

        foreach ($harapan as $email => [$badgePeran, $routeName]) {
            $user = Pengguna::where('email', $email)->firstOrFail();

            $this->actingAs($user)
                ->get('/mobile/dashboard')
                ->assertOk()
                ->assertSee('kd-mobile', false)
                ->assertSee($badgePeran)
                ->assertSee('Ringkasan data')
                ->assertDontSee('Buka Dashboard CMS')
                ->assertSee(route($routeName), false)
                ->assertSee('kd-tabbar', false);
        }

        $super = Pengguna::where('email', 'admin@kormibdg.id')->firstOrFail();

        $this->actingAs($super)
            ->get('/mobile/dashboard')
            ->assertOk()
            ->assertSee('Monitoring APMO')
            ->assertSee('Survei APMO')
            ->assertSee(route('mobile.apmo.wilayah'), false);

        foreach (['admin.korcam@kormibdg.id', 'admin.inorga@kormibdg.id', 'editor.berita@kormibdg.id'] as $email) {
            $this->actingAs(Pengguna::where('email', $email)->firstOrFail())
                ->get('/mobile/dashboard')
                ->assertOk()
                ->assertDontSee(route('mobile.apmo.wilayah'), false);
        }
    }

    public function test_login_mobile_pegiat_olahraga_mengarahkan_ke_dashboard_mobile(): void
    {
        \Livewire\Livewire::test(\App\Livewire\Mobile\Masuk::class)
            ->set('email', 'warga@kormibdg.id')
            ->set('kata_sandi', 'password123')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('mobile.dashboard'));
    }

    public function test_login_desktop_pegiat_olahraga_tetap_ke_dashboard_admin(): void
    {
        \Livewire\Livewire::test(\App\Livewire\Backend\Auth\Masuk::class)
            ->set('email', 'warga@kormibdg.id')
            ->set('kata_sandi', 'password123')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_dashboard_mobile_pegiat_olahraga_menampilkan_aktivitas(): void
    {
        $warga = Pengguna::where('email', 'warga@kormibdg.id')->firstOrFail();

        $this->actingAs($warga)
            ->get('/mobile/dashboard')
            ->assertOk()
            ->assertSee('kd-mobile', false)
            ->assertDontSee('Absensi hari ini')
            ->assertDontSee('Survei APMO')
            ->assertSee('Catat Aktivitas')
            ->assertSee('Riwayat APMO')
            ->assertSee(route('partisipasi.catat'), false)
            ->assertSee(route('partisipasi.riwayat'), false)
            ->assertSee('kd-tabbar', false);
    }

    public function test_menu_bawah_pegiat_tanpa_absensi_dan_apmo(): void
    {
        $warga = Pengguna::where('email', 'warga@kormibdg.id')->firstOrFail();

        $html = $this->actingAs($warga)
            ->get('/mobile/dashboard')
            ->assertOk()
            ->getContent();

        $tabbar = str($html)->between('<nav class="kd-tabbar', '</nav>')->toString();

        $this->assertStringContainsString('>Beranda<', $tabbar);
        $this->assertStringContainsString('>Laporan<', $tabbar);
        $this->assertStringContainsString('>Profil<', $tabbar);
        $this->assertStringNotContainsString('>APMO<', $tabbar);
        $this->assertStringNotContainsString('>Absensi<', $tabbar);
        $this->assertStringNotContainsString('kd-tab--fab', $tabbar);
        $this->assertStringNotContainsString('>Direktori<', $tabbar);
        $this->assertStringNotContainsString('>Masuk<', $tabbar);
        $this->assertStringContainsString('kd-tab is-active', $tabbar);
        $this->assertStringNotContainsString(route('mobile.angket'), $tabbar);
        $this->assertStringNotContainsString(route('mobile.absensi'), $tabbar);
        $this->assertStringContainsString(route('mobile.laporan'), $tabbar);
        $this->assertStringContainsString(route('mobile.profil'), $tabbar);
    }

    public function test_menu_bawah_duta_berisi_absensi_dan_apmo(): void
    {
        $duta = Pengguna::where('email', 'duta.olahraga@kormibdg.id')->firstOrFail();

        $html = $this->actingAs($duta)
            ->get('/mobile/dashboard')
            ->assertOk()
            ->getContent();

        $tabbar = str($html)->between('<nav class="kd-tabbar', '</nav>')->toString();

        $this->assertStringContainsString('>Beranda<', $tabbar);
        $this->assertStringContainsString('>APMO<', $tabbar);
        $this->assertStringContainsString('>Absensi<', $tabbar);
        $this->assertStringContainsString('>Laporan<', $tabbar);
        $this->assertStringContainsString('>Profil<', $tabbar);
        $this->assertStringContainsString('kd-tab--fab', $tabbar);
        $this->assertStringContainsString(route('mobile.angket'), $tabbar);
        $this->assertStringContainsString(route('mobile.absensi'), $tabbar);
    }

    public function test_menu_bawah_pengunjung_tetap_beranda_direktori_daftar_masuk(): void
    {
        $html = $this->get('/mobile/beranda')
            ->assertOk()
            ->getContent();

        $tabbar = str($html)->between('<nav class="kd-tabbar"', '</nav>')->toString();

        $this->assertStringContainsString('>Beranda<', $tabbar);
        $this->assertStringContainsString('>Direktori<', $tabbar);
        $this->assertStringContainsString('>Daftar<', $tabbar);
        $this->assertStringContainsString('>Masuk<', $tabbar);
        $this->assertStringNotContainsString('>Profil<', $tabbar);
    }

    public function test_halaman_mobile_layanan_dan_profil_butuh_login(): void
    {
        $this->get('/mobile/layanan')->assertRedirect('/login');
        $this->get('/mobile/profil')->assertRedirect('/login');
        $this->get('/mobile/laporan')->assertRedirect('/login');
    }

    public function test_halaman_mobile_layanan_tampil_sesuai_peran(): void
    {
        $warga = Pengguna::where('email', 'warga@kormibdg.id')->firstOrFail();
        $this->actingAs($warga)
            ->get('/mobile/layanan')
            ->assertOk()
            ->assertSee('Layanan Partisipasi')
            ->assertSee('Catat Aktivitas')
            ->assertSee(route('partisipasi.catat'), false)
            ->assertSee('Informasi Publik')
            ->assertDontSee('Kelola Organisasi');

        $korcam = Pengguna::where('email', 'admin.korcam@kormibdg.id')->firstOrFail();
        $this->actingAs($korcam)
            ->get('/mobile/layanan')
            ->assertOk()
            ->assertSee('Kelola Organisasi')
            ->assertDontSee('Buka Dashboard CMS')
            ->assertSee(route('admin.duta'), false)
            ->assertDontSee('Layanan Partisipasi');
    }

    public function test_halaman_mobile_profil_tampil(): void
    {
        $warga = Pengguna::where('email', 'warga@kormibdg.id')->firstOrFail();
        $this->actingAs($warga)
            ->get('/mobile/profil')
            ->assertOk()
            ->assertSee('Profil')
            ->assertSee('Ubah Data')
            ->assertSee('Keamanan')
            ->assertSee($warga->nama_lengkap)
            ->assertSee($warga->email)
            ->assertSee('Informasi Akun')
            ->assertSee('Keluar dari Akun')
            ->assertSee(route('admin.keluar'), false);

        $korcam = Pengguna::where('email', 'admin.korcam@kormibdg.id')->firstOrFail();
        $this->actingAs($korcam)
            ->get('/mobile/profil')
            ->assertOk()
            ->assertDontSee('Buka Dashboard CMS');
    }

    public function test_halaman_mobile_berita_tampil_dan_detail(): void
    {
        $berita = \App\Models\Content\Berita::where('status_publikasi', 'published')
            ->orderByDesc('tanggal_publikasi')
            ->firstOrFail();

        $this->get('/mobile/berita')
            ->assertOk()
            ->assertSee('Berita & Artikel', false)
            ->assertSee($berita->judul)
            ->assertSee('kd-tabbar', false);

        $this->get('/mobile/berita/' . $berita->slug)
            ->assertOk()
            ->assertSee($berita->judul)
            ->assertSee('Semua berita')
            ->assertSee('kd-tabbar', false);
    }
}
