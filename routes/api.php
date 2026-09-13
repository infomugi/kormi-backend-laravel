<?php

use Illuminate\Support\Facades\Route;
use App\Models\Content\Berita;
use App\Models\Kormi\Inorga;
use App\Models\Kormi\Event;
use App\Models\Kormi\Sapras;
use App\Models\Core\PengaturanSitus;

/*
|--------------------------------------------------------------------------
| API Routes - KORMI Kabupaten Bandung
|--------------------------------------------------------------------------
| Menyediakan data publik untuk Mobile App, Widget Web, & Integrasi
*/

Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
    // 1. Pengaturan & Profil Situs
    Route::get('/pengaturan', function () {
        $settings = PengaturanSitus::pluck('nilai_pengaturan', 'kunci_pengaturan');
        return response()->json([
            'sukses' => true,
            'pesan' => 'Data profil & pengaturan KORMI',
            'data' => $settings
        ]);
    });

    // 2. Berita & Artikel
    Route::get('/berita', function () {
        $cari = request('cari');
        $kategori = request('kategori');

        $berita = Berita::with('kategori')
            ->where('status_publikasi', 'published')
            ->when($cari, fn($q) => $q->where('judul', 'like', "%{$cari}%"))
            ->when($kategori, fn($q) => $q->whereHas('kategori', fn($kq) => $kq->where('slug', $kategori)))
            ->orderByDesc('tanggal_publikasi')
            ->paginate(request('per_page', 10));

        return response()->json([
            'sukses' => true,
            'data' => $berita
        ]);
    });

    Route::get('/berita/{slug}', function ($slug) {
        $berita = Berita::with('kategori')
            ->where('slug', $slug)
            ->where('status_publikasi', 'published')
            ->firstOrFail();

        return response()->json([
            'sukses' => true,
            'data' => $berita
        ]);
    });

    // 3. Inorga (Induk Organisasi Olahraga)
    Route::get('/inorga', function () {
        $komisi = request('komisi');
        $inorga = Inorga::with('komisi')
            ->when($komisi, fn($q) => $q->whereHas('komisi', fn($kq) => $kq->where('singkatan', $komisi)))
            ->orderBy('nama_inorga')
            ->get();

        return response()->json([
            'sukses' => true,
            'total' => $inorga->count(),
            'data' => $inorga
        ]);
    });

    // 4. Event & Klasemen Medali
    Route::get('/event', function () {
        $events = Event::with(['kategoriEvent', 'cabang.inorga', 'jadwal'])
            ->where('status_publikasi', true)
            ->orderByDesc('tanggal_mulai')
            ->get();

        return response()->json([
            'sukses' => true,
            'total' => $events->count(),
            'data' => $events
        ]);
    });

    Route::get('/event/{id}/klasemen', function ($id) {
        $event = Event::findOrFail($id);
        $klasemen = $event->klasemen()
            ->with('kecamatan')
            ->orderByDesc('jumlah_emas')
            ->orderByDesc('jumlah_perak')
            ->orderByDesc('jumlah_perunggu')
            ->get();

        return response()->json([
            'sukses' => true,
            'event' => $event->judul_event,
            'tahun' => $event->tahun_edisi,
            'data' => $klasemen
        ]);
    });

    // 5. Sarana & Prasarana
    Route::get('/sapras', function () {
        $kategori = request('kategori');
        $sapras = Sapras::with('kecamatan')
            ->when($kategori, fn($q) => $q->where('kategori_fasilitas', $kategori))
            ->orderBy('nama_fasilitas')
            ->get();

        return response()->json([
            'sukses' => true,
            'total' => $sapras->count(),
            'data' => $sapras
        ]);
    });
});
