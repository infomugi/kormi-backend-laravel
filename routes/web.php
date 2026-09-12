<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Livewire Publik
use App\Livewire\Publik\Beranda;
use App\Livewire\Publik\Tentang\Sejarah;
use App\Livewire\Publik\Tentang\VisiMisi;
use App\Livewire\Publik\Tentang\Pengurus;
use App\Livewire\Publik\Tentang\Kordik;
use App\Livewire\Publik\Tentang\DutaOlahragaIndex;
use App\Livewire\Publik\Tentang\Proker;
use App\Livewire\Publik\Inorga\InorgaIndex;
use App\Livewire\Publik\Event\Fotradkab;
use App\Livewire\Publik\Event\Forkab;
use App\Livewire\Publik\Informasi\Apmo;
use App\Livewire\Publik\Informasi\Sdi;
use App\Livewire\Publik\Informasi\Sapras;
use App\Livewire\Publik\Media\BeritaIndex;
use App\Livewire\Publik\Media\BeritaDetail;
use App\Livewire\Publik\Media\GaleriIndex;
use App\Livewire\Publik\Unduhan\UnduhanIndex;

// Livewire Admin CMS
use App\Livewire\Admin\Auth\Masuk;
use App\Livewire\Admin\Auth\Daftar;
use App\Livewire\Admin\Auth\LupaPassword;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Berita\BeritaKelola;
use App\Livewire\Admin\Berita\BeritaForm;
use App\Livewire\Admin\Galeri\GaleriKelola;
use App\Livewire\Admin\Unduhan\UnduhanKelola;
use App\Livewire\Admin\Inorga\InorgaKelola;
use App\Livewire\Admin\Duta\DutaKelola;
use App\Livewire\Admin\Event\KlasemenKelola;
use App\Livewire\Admin\Event\EventKelola;
use App\Livewire\Admin\Sapras\SaprasKelola;
use App\Livewire\Admin\Sdi\SdiKelola;
use App\Livewire\Admin\Apmo\ApmoKelola;
use App\Livewire\Admin\Pengguna\PenggunaKelola;
use App\Livewire\Admin\Pengguna\PeranKelola;
use App\Livewire\Admin\Pengaturan\PengaturanKelola;
use App\Livewire\Admin\Organisasi\SejarahKelola;
use App\Livewire\Admin\Organisasi\VisiMisiKelola;
use App\Livewire\Admin\Organisasi\PengurusKelola;
use App\Livewire\Admin\Organisasi\KordikKelola;
use App\Livewire\Admin\Organisasi\ProkerKelola;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Publik KORMI Kabupaten Bandung
|--------------------------------------------------------------------------
*/

Route::get('/', Beranda::class)->name('beranda');

// 1. Tentang Kami
Route::prefix('tentang')->group(function () {
    Route::get('/sejarah', Sejarah::class)->name('sejarah');
    Route::get('/visi-misi', VisiMisi::class)->name('visimisi');
    Route::get('/pengurus', Pengurus::class)->name('pengurus');
    Route::get('/koordinator-kecamatan', Kordik::class)->name('kordikecamatan');
    Route::get('/duta-olahraga', DutaOlahragaIndex::class)->name('dutaolahraga');
    Route::get('/program-kerja', Proker::class)->name('proker');
});

// Alias direct routes
Route::get('/sejarah', Sejarah::class);
Route::get('/visimisi', VisiMisi::class);
Route::get('/visi-misi', VisiMisi::class);
Route::get('/pengurus', Pengurus::class);
Route::get('/kordikecamatan', Kordik::class);
Route::get('/koordinator-kecamatan', Kordik::class);
Route::get('/duta-olahraga', DutaOlahragaIndex::class);
Route::get('/dutaolahraga', DutaOlahragaIndex::class);
Route::get('/proker', Proker::class);
Route::get('/program-kerja', Proker::class);

// 2. Informasi & Inorga
Route::get('/inorga', InorgaIndex::class)->name('inorga');
Route::get('/fotradkab', Fotradkab::class)->name('fotradkab');
Route::get('/forkab', Forkab::class)->name('forkab');
Route::get('/apmo', Apmo::class)->name('apmo');
Route::get('/sdi', Sdi::class)->name('sdi');
Route::get('/sapras', Sapras::class)->name('sapras');

// 3. Media
Route::get('/berita', BeritaIndex::class)->name('berita');
Route::get('/berita/{slug}', BeritaDetail::class)->name('berita.detail');
Route::get('/galeri', GaleriIndex::class)->name('galeri');

// 4. Unduhan & Kontak
Route::get('/unduhan', UnduhanIndex::class)->name('unduhan');
Route::get('/kontak', \App\Livewire\Publik\Kontak::class)->name('kontak');
Route::get('/hubungi-kami', \App\Livewire\Publik\Kontak::class);

/*
|--------------------------------------------------------------------------
| Admin CMS Routes & Bypass Login
|--------------------------------------------------------------------------
*/

// Bypass Login — HANYA aktif di environment local/development
if (app()->environment('local', 'development')) {
    Route::get('/private-infomugi', function () {
        $admin = \App\Models\Pengguna::where('email', 'admin@kormibdg.id')->first();
        if (!$admin) {
            $admin = \App\Models\Pengguna::first();
        }
        if ($admin) {
            Auth::login($admin);
            request()->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('login')->with('error', 'Akun admin belum tersedia di database.');
    })->name('admin.bypass');
}

Route::prefix('admin')->group(function () {
    Route::get('/masuk', Masuk::class)->name('login');
    Route::get('/login', Masuk::class);
    Route::get('/daftar', Daftar::class)->name('admin.daftar');
    Route::get('/register', Daftar::class);
    Route::get('/lupa-password', LupaPassword::class)->name('admin.lupa-password');
    Route::get('/forgot-password', LupaPassword::class);
    Route::get('/reset-password', LupaPassword::class);
    
    Route::post('/masuk', function () {
        request()->validate([
            'email' => 'required|email',
            'kata_sandi' => 'required|min:4',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'kata_sandi.required' => 'Kata sandi wajib diisi.',
            'kata_sandi.min' => 'Kata sandi minimal berisi :min karakter.',
        ]);

        $email = strtolower(trim(request('email')));
        $password = request('kata_sandi') ?? request('password');
        $remember = request()->boolean('ingat_saya');
        $throttleKey = 'login-attempt:' . request()->ip() . '|' . $email;

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            return back()->withInput()->withErrors([
                'email' => "Terlalu banyak percobaan masuk yang gagal. Silakan coba lagi dalam {$seconds} detik."
            ]);
        }

        $user = \App\Models\Pengguna::where('email', $email)->first();
        if (!$user) {
            \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);
            return back()->withInput()->withErrors(['email' => 'Alamat email atau kata sandi yang Anda masukkan tidak sesuai.']);
        }

        if (isset($user->status_aktif) && !$user->status_aktif) {
            return back()->withInput()->withErrors(['email' => 'Akun Anda belum disetujui oleh Administrator KORMI atau sedang dinonaktifkan. Silakan hubungi pengelola CMS.']);
        }

        if (!\Illuminate\Support\Facades\Hash::check($password, $user->kata_sandi)) {
            \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);
            return back()->withInput()->withErrors(['email' => 'Alamat email atau kata sandi yang Anda masukkan tidak sesuai.']);
        }

        \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);

        Auth::login($user, $remember);
        try {
            $user->forceFill(['terakhir_masuk' => now()])->saveQuietly();
        } catch (\Throwable $t) {}

        request()->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    })->name('admin.masuk.post');
    
    Route::post('/keluar', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('admin.keluar');
    
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    });

    Route::middleware('auth')->group(function () {
        // Semua role terautentikasi dapat mengakses Dashboard
        Route::get('/', Dashboard::class)->name('admin.dashboard');
        Route::get('/dashboard', Dashboard::class);

        // 1. Modul Publikasi Media & Dokumentasi (Super Admin, Editor Berita)
        Route::middleware('peran:super-admin,editor-berita')->group(function () {
            Route::get('/berita', BeritaKelola::class)->name('admin.berita');
            Route::get('/berita/tambah', BeritaForm::class)->name('admin.berita.tambah');
            Route::get('/berita/{id}/edit', BeritaForm::class)->name('admin.berita.edit');
            Route::post('/berita/upload-foto-konten', function (\Illuminate\Http\Request $request) {
                $request->validate([
                    'foto' => 'required|image|max:10240', // Maks 10MB
                ]);

                /** @var \App\Services\StorageService $storage */
                $storage = app(\App\Services\StorageService::class);
                $path = $storage->uploadGambar($request->file('foto'), 'berita/konten');
                $url = $storage->getTemporaryUrl($path, 525600) ?? $path; // 1 year signed URL

                return response()->json([
                    'success' => true,
                    'path' => $path,
                    'url' => $url,
                ]);
            })->name('admin.berita.upload-foto-konten');
            Route::get('/galeri', GaleriKelola::class)->name('admin.galeri');
            Route::get('/unduhan', UnduhanKelola::class)->name('admin.unduhan');
        });

        // 2. Modul Wilayah, Duta, Venue, & Kordik (Super Admin, Admin KORCAM)
        Route::middleware('peran:super-admin,admin-korcam')->group(function () {
            Route::get('/duta', DutaKelola::class)->name('admin.duta');
            Route::get('/kordik', KordikKelola::class)->name('admin.kordik');
            Route::get('/sapras', SaprasKelola::class)->name('admin.sapras');
        });

        // 3. Modul Induk Organisasi, Event, & Klasemen (Super Admin, Admin INORGA)
        Route::middleware('peran:super-admin,admin-inorga')->group(function () {
            Route::get('/inorga', InorgaKelola::class)->name('admin.inorga');
            Route::get('/event', EventKelola::class)->name('admin.event');
            Route::get('/klasemen', KlasemenKelola::class)->name('admin.klasemen');
        });

        // 4. Modul Khusus Super Administrator (Pengguna, Organisasi, APMO, SDI, Pengaturan)
        Route::middleware('peran:super-admin')->group(function () {
            Route::get('/sdi', SdiKelola::class)->name('admin.sdi');
            Route::get('/apmo', ApmoKelola::class)->name('admin.apmo');
            Route::get('/pengguna', PenggunaKelola::class)->name('admin.pengguna');
            Route::get('/users', PenggunaKelola::class);
            Route::get('/peran', PeranKelola::class)->name('admin.peran');
            Route::get('/roles', PeranKelola::class);
            Route::get('/pengaturan', PengaturanKelola::class)->name('admin.pengaturan');
            Route::get('/sejarah', SejarahKelola::class)->name('admin.sejarah');
            Route::get('/visi-misi', VisiMisiKelola::class)->name('admin.visimisi');
            Route::get('/pengurus', PengurusKelola::class)->name('admin.pengurus');
            Route::get('/proker', ProkerKelola::class)->name('admin.proker');
        });
    });
});
