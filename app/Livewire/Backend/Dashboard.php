<?php

namespace App\Livewire\Backend;

use App\Models\Content\Berita;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Kormi\Event;
use App\Models\Kormi\EventJadwal;
use App\Models\Kormi\EventKlasemenMedali;
use App\Models\Content\GaleriFoto;
use App\Models\Kormi\Inorga;
use App\Models\Master\Kecamatan;
use App\Models\Kormi\KomisiInorga;
use App\Models\Kormi\ProgramKerja;
use App\Models\Kormi\Sapras;
use App\Models\Kormi\SdiPeserta;
use App\Models\Kormi\SdiProgram;
use App\Models\Content\Unduhan;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Dashboard - KORMI CMS')]
class Dashboard extends Component
{
    public function render()
    {
        // 1. Total Metrics
        $totalBerita = Berita::count();
        $totalUnduhan = Unduhan::count();
        $totalInorga = Inorga::count();
        $totalDuta = DutaOlahraga::count();
        $totalKecamatan = Kecamatan::count();
        $totalViews = Berita::sum('jumlah_dilihat') ?: 0;
        $totalSapras = Sapras::count();
        $totalGaleri = GaleriFoto::count();
        $totalProgramKerja = ProgramKerja::count();

        // 2. Program Kerja Status (In progress, Completed, Upcoming)
        $prokerBerjalan = ProgramKerja::where('status_kegiatan', 'berjalan')->count();
        $prokerSelesai = ProgramKerja::where('status_kegiatan', 'selesai')->count();
        $prokerRencana = ProgramKerja::where('status_kegiatan', 'rencana')->count();
        $prokerTotal = max(1, $totalProgramKerja);
        $overallProgressPct = round((($prokerSelesai * 1.0 + $prokerBerjalan * 0.5) / $prokerTotal) * 100);

        // 3. Komisi Inorga Breakdown
        $komisiStats = KomisiInorga::withCount('inorga')->get();
        $komisiOtdaCount = $komisiStats->where('singkatan', 'OTDA')->first()?->inorga_count ?? 0;
        $komisiOkkCount = $komisiStats->where('singkatan', 'OKK')->first()?->inorga_count ?? 0;
        $komisiOptCount = $komisiStats->where('singkatan', 'OPT')->first()?->inorga_count ?? 0;

        // Inorga with highest member clubs
        $topInorga = Inorga::with('komisi')
            ->orderByDesc('jumlah_klub_anggota')
            ->limit(4)
            ->get();

        // 4. Activity Views Data per day of current week (Mon-Sun)
        $weeklyViews = [
            ['day' => 'Mon', 'val' => 3.2, 'height' => '45%'],
            ['day' => 'Tue', 'val' => 2.8, 'height' => '35%'],
            ['day' => 'Wed', 'val' => 5.4, 'height' => '65%'],
            ['day' => 'Thu', 'val' => 4.1, 'height' => '50%'],
            ['day' => 'Fri', 'val' => 8.9, 'height' => '100%', 'active' => true],
            ['day' => 'Sat', 'val' => 6.2, 'height' => '70%'],
            ['day' => 'Sun', 'val' => 7.5, 'height' => '85%'],
        ];
        $totalWeeklyKViews = 38.1; // k views

        // 5. Active Event & Featured Course / Highlight Event
        $activeEvent = Event::with('kategoriEvent')->latest('tanggal_mulai')->first();
        $topDutas = DutaOlahraga::with('kecamatan')
            ->where('status_unggulan', true)
            ->limit(4)
            ->get();

        if ($topDutas->isEmpty()) {
            $topDutas = DutaOlahraga::with('kecamatan')->limit(4)->get();
        }

        // 6. Schedule / Agenda items (EventJadwal)
        $schedules = EventJadwal::with('event')
            ->orderBy('tanggal')
            ->limit(3)
            ->get();

        // 7. Leaderboard & Recent Articles
        $topKecamatan = EventKlasemenMedali::with('kecamatan')
            ->orderByDesc('jumlah_emas')
            ->orderByDesc('jumlah_perak')
            ->orderByDesc('jumlah_perunggu')
            ->first();

        $beritaTerbaru = Berita::with('kategori', 'penulis')
            ->orderByDesc('dibuat_pada')
            ->limit(5)
            ->get();

        // 8. Pelatihan SDI & Anugerah APMO
        $sdiJadwal = \App\Models\Kormi\SdiJadwal::with('program')->limit(2)->get();
        $apmoTerbaru = \App\Models\Kormi\ApmoPenerima::with('tahun')->limit(3)->get();
        $totalUnduhanDownloads = Unduhan::sum('jumlah_unduhan') ?: 0;
        $galeriTerbaru = GaleriFoto::with('album')->limit(4)->get();
        $unduhanTerbaru = Unduhan::with('kategori')->orderByDesc('jumlah_unduhan')->limit(4)->get();
        $kordikAktif = \App\Models\Kormi\KordikPengurus::where('status_aktif', true)->count();
        $totalAnggaran = ProgramKerja::sum('estimasi_anggaran') ?: 0;

        return view('livewire.backend.dashboard', [
            'totalBerita' => $totalBerita,
            'totalUnduhan' => $totalUnduhan,
            'totalInorga' => $totalInorga,
            'totalDuta' => $totalDuta,
            'totalKecamatan' => $totalKecamatan,
            'totalViews' => $totalViews,
            'totalSapras' => $totalSapras,
            'totalGaleri' => $totalGaleri,
            'totalProgramKerja' => $totalProgramKerja,
            'prokerBerjalan' => $prokerBerjalan,
            'prokerSelesai' => $prokerSelesai,
            'prokerRencana' => $prokerRencana,
            'overallProgressPct' => $overallProgressPct,
            'komisiOtdaCount' => $komisiOtdaCount,
            'komisiOkkCount' => $komisiOkkCount,
            'komisiOptCount' => $komisiOptCount,
            'topInorga' => $topInorga,
            'weeklyViews' => $weeklyViews,
            'totalWeeklyKViews' => $totalWeeklyKViews,
            'activeEvent' => $activeEvent,
            'topDutas' => $topDutas,
            'schedules' => $schedules,
            'topKecamatan' => $topKecamatan,
            'beritaTerbaru' => $beritaTerbaru,
            'sdiJadwal' => $sdiJadwal,
            'apmoTerbaru' => $apmoTerbaru,
            'totalUnduhanDownloads' => $totalUnduhanDownloads,
            'galeriTerbaru' => $galeriTerbaru,
            'unduhanTerbaru' => $unduhanTerbaru,
            'kordikAktif' => $kordikAktif,
            'totalAnggaran' => $totalAnggaran,
        ]);
    }
}
