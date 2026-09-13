<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Livewire Backend
use App\Livewire\Backend\Auth\Masuk;
use App\Livewire\Backend\Auth\Daftar;
use App\Livewire\Backend\Auth\LupaPassword;
use App\Livewire\Backend\Dashboard;
use App\Livewire\Backend\Berita\BeritaKelola;
use App\Livewire\Backend\Berita\BeritaForm;
use App\Livewire\Backend\Galeri\GaleriKelola;
use App\Livewire\Backend\Unduhan\UnduhanKelola;
use App\Livewire\Backend\Kormi\Inorga\InorgaKelola;
use App\Livewire\Backend\Kormi\Duta\DutaKelola;
use App\Livewire\Backend\Kormi\Event\KlasemenKelola;
use App\Livewire\Backend\Kormi\Event\EventKelola;
use App\Livewire\Backend\Kormi\Sapras\SaprasKelola;
use App\Livewire\Backend\Kormi\Sdi\SdiKelola;
use App\Livewire\Backend\Kormi\Apmo\ApmoKelola;
use App\Livewire\Backend\Pengguna\PenggunaKelola;
use App\Livewire\Backend\Pengguna\PeranKelola;
use App\Livewire\Backend\Pengaturan\PengaturanKelola;
use App\Livewire\Backend\Kormi\Organisasi\SejarahKelola;
use App\Livewire\Backend\Kormi\Organisasi\VisiMisiKelola;
use App\Livewire\Backend\Kormi\Organisasi\PengurusKelola;
use App\Livewire\Backend\Kormi\Organisasi\KordikKelola;
use App\Livewire\Backend\Kormi\Organisasi\ProkerKelola;
use App\Livewire\Backend\Kormi\Partisipasi\PartisipasiKelola;
use App\Livewire\Backend\Kormi\Partisipasi\PartisipasiStatistik;

/*
|--------------------------------------------------------------------------
| Backend CMS Routes & Authentication
|--------------------------------------------------------------------------
*/

// Bypass Login — HANYA aktif di environment local/development
if (app()->environment('local', 'development')) {
    Route::get('/private-infomugi', function () {
        $admin = \App\Models\Core\Pengguna::where('email', 'admin@kormibdg.id')->first();
        if (!$admin) {
            $admin = \App\Models\Core\Pengguna::first();
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

        $user = \App\Models\Core\Pengguna::where('email', $email)->first();
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
                $url = $storage->getTemporaryUrl($path, 525600) ?? $path;

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
            Route::get('/partisipasi', PartisipasiKelola::class)->name('admin.partisipasi.log');
            Route::get('/partisipasi/statistik', PartisipasiStatistik::class)->name('admin.partisipasi.statistik');
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
