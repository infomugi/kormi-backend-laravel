<?php

use Illuminate\Support\Facades\Route;

// Livewire Frontend
use App\Livewire\Frontend\Beranda;
use App\Livewire\Frontend\Kontak;
use App\Livewire\Frontend\Kormi\Tentang\Sejarah;
use App\Livewire\Frontend\Kormi\Tentang\VisiMisi;
use App\Livewire\Frontend\Kormi\Tentang\Pengurus;
use App\Livewire\Frontend\Kormi\Tentang\Kordik;
use App\Livewire\Frontend\Kormi\Tentang\DutaOlahragaIndex;
use App\Livewire\Frontend\Kormi\Tentang\Proker;
use App\Livewire\Frontend\Kormi\Inorga\InorgaIndex;
use App\Livewire\Frontend\Kormi\Event\Fotradkab;
use App\Livewire\Frontend\Kormi\Event\Forkab;
use App\Livewire\Frontend\Kormi\Informasi\Apmo;
use App\Livewire\Frontend\Kormi\Informasi\Sdi;
use App\Livewire\Frontend\Kormi\Informasi\Sapras;
use App\Livewire\Frontend\Media\BeritaIndex;
use App\Livewire\Frontend\Media\BeritaDetail;
use App\Livewire\Frontend\Media\GaleriIndex;
use App\Livewire\Frontend\Unduhan\UnduhanIndex;

/*
|--------------------------------------------------------------------------
| Frontend Routes - Portal Publik KORMI Kabupaten Bandung
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
Route::get('/kontak', Kontak::class)->name('kontak');
Route::get('/hubungi-kami', Kontak::class);

// 5. Modul Partisipasi Olahraga Masyarakat (APMO Tracker)
Route::middleware(['auth', 'throttle:60,1'])->prefix('partisipasi')->group(function () {
    Route::get('/catat', \App\Livewire\Frontend\Kormi\Partisipasi\PartisipasiInput::class)->name('partisipasi.catat');
    Route::get('/duta', \App\Livewire\Frontend\Kormi\Partisipasi\PartisipasiDutaInput::class)->name('partisipasi.duta');
    Route::get('/riwayat', \App\Livewire\Frontend\Kormi\Partisipasi\PartisipasiRiwayat::class)->name('partisipasi.riwayat');
});
