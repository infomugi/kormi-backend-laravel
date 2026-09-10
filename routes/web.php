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
use App\Livewire\Admin\Sapras\SaprasKelola;
use App\Livewire\Admin\Sdi\SdiKelola;
use App\Livewire\Admin\Apmo\ApmoKelola;
use App\Livewire\Admin\Pengguna\PenggunaKelola;

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

// 4. Unduhan
Route::get('/unduhan', UnduhanIndex::class)->name('unduhan');

/*
|--------------------------------------------------------------------------
| Admin CMS Routes & Bypass Login
|--------------------------------------------------------------------------
*/

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

        $user = \App\Models\Pengguna::where('email', $email)->first();
        if (!$user) {
            return back()->withInput()->withErrors(['email' => 'Alamat email tidak terdaftar dalam sistem CMS KORMI.']);
        }

        if (isset($user->status_aktif) && !$user->status_aktif) {
            return back()->withInput()->withErrors(['email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Sekretariat KORMI.']);
        }

        if (!\Illuminate\Support\Facades\Hash::check($password, $user->kata_sandi)) {
            return back()->withInput()->withErrors(['kata_sandi' => 'Kata sandi yang Anda masukkan salah. Silakan periksa kembali.']);
        }

        Auth::login($user, $remember);
        try {
            $user->forceFill(['terakhir_masuk' => now()])->saveQuietly();
        } catch (\Throwable $t) {}

        request()->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    })->name('admin.masuk.post');
    
    Route::match(['get', 'post'], '/keluar', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('admin.keluar');
    
    Route::get('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', Dashboard::class)->name('admin.dashboard');
        Route::get('/dashboard', Dashboard::class);
        Route::get('/berita', BeritaKelola::class)->name('admin.berita');
        Route::get('/berita/tambah', BeritaForm::class)->name('admin.berita.tambah');
        Route::get('/berita/{id}/edit', BeritaForm::class)->name('admin.berita.edit');
        Route::get('/galeri', GaleriKelola::class)->name('admin.galeri');
        Route::get('/unduhan', UnduhanKelola::class)->name('admin.unduhan');
        Route::get('/inorga', InorgaKelola::class)->name('admin.inorga');
        Route::get('/duta', DutaKelola::class)->name('admin.duta');
        Route::get('/klasemen', KlasemenKelola::class)->name('admin.klasemen');
        Route::get('/sapras', SaprasKelola::class)->name('admin.sapras');
        Route::get('/sdi', SdiKelola::class)->name('admin.sdi');
        Route::get('/apmo', ApmoKelola::class)->name('admin.apmo');
        Route::get('/pengguna', PenggunaKelola::class)->name('admin.pengguna');
        Route::get('/users', PenggunaKelola::class);
    });
});
