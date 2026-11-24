<?php

namespace App\Livewire\Mobile;

use App\Models\Content\Berita;
use App\Models\Content\GaleriFoto;
use App\Models\Content\Unduhan;
use App\Models\Core\Pengguna;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Kormi\Event;
use App\Models\Kormi\Inorga;
use App\Models\Kormi\KomisiInorga;
use App\Models\Kormi\PartisipasiAktivitas;
use App\Models\Kormi\Sapras;
use App\Models\Master\Kecamatan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.mobile')]
#[Title('Dashboard - KORMI Kabupaten Bandung')]
class Dashboard extends Component
{
    public function mount()
    {
        $user = auth()->user();

        if (! $user || ! $this->bolehAkses($user)) {
            return redirect()->route('admin.dashboard');
        }
    }

    public function render()
    {
        $user = auth()->user();

        if ($user->isDutaOlahraga()) {
            return $this->dashboardDuta($user);
        }

        if ($user->isPegiatOlahraga()) {
            return $this->dashboardPegiat($user);
        }

        return view('livewire.mobile.dashboard-admin', $this->dataAdmin($user));
    }

    private function bolehAkses(Pengguna $user): bool
    {
        return $user->isDutaOlahraga()
            || $user->isPegiatOlahraga()
            || $user->hasRole('super-admin', 'admin-korcam', 'admin-inorga', 'editor-berita');
    }

    private function dataAktivitas(Pengguna $user): array
    {
        $aktivitas = PartisipasiAktivitas::where('pengguna_id', $user->id);

        $stats = [
            'total' => (clone $aktivitas)->count(),
            'valid' => (clone $aktivitas)->where('status_verifikasi', 'valid')->count(),
            'bulanIni' => (clone $aktivitas)
                ->whereMonth('tanggal_aktivitas', now()->month)
                ->whereYear('tanggal_aktivitas', now()->year)
                ->count(),
            'peserta' => (clone $aktivitas)->where('status_verifikasi', 'valid')->sum('jumlah_peserta'),
        ];

        $terbaru = (clone $aktivitas)
            ->orderByDesc('tanggal_aktivitas')
            ->limit(4)
            ->get();

        return compact('stats', 'terbaru');
    }

    private function dashboardDuta(Pengguna $user)
    {
        $duta = $user->duta
            ?? DutaOlahraga::where('pengguna_id', $user->id)->first();

        return view('livewire.mobile.dashboard', [
            'user' => $user,
            'duta' => $duta,
            ...$this->dataAktivitas($user),
        ]);
    }

    private function dashboardPegiat(Pengguna $user)
    {
        return view('livewire.mobile.dashboard-pegiat', [
            'user' => $user,
            'duta' => $user->duta,
            ...$this->dataAktivitas($user),
        ]);
    }

    private function dataAdmin(Pengguna $user): array
    {
        $peran = $user->peran;
        $isSuper = $user->isSuperAdmin();
        $isEditor = $user->isEditorBerita();
        $isKorcam = $user->isAdminKorcam();
        $isInorga = $user->isAdminInorga();

        $dutaDisetujui = DutaOlahraga::where('status_aktif', true)
            ->where('status_pendaftaran', DutaOlahraga::STATUS_DISETUJUI)
            ->count();
        $dutaMenunggu = DutaOlahraga::menunggu()->count();

        $modulTersedia = [
            'berita' => ['label' => 'Berita', 'icon' => 'newspaper', 'route' => 'admin.berita'],
            'galeri' => ['label' => 'Galeri', 'icon' => 'camera', 'route' => 'admin.galeri'],
            'unduhan' => ['label' => 'Unduhan', 'icon' => 'download', 'route' => 'admin.unduhan'],
            'duta' => ['label' => 'Duta', 'icon' => 'users', 'route' => 'admin.duta'],
            'kordik' => ['label' => 'Kordik', 'icon' => 'map', 'route' => 'admin.kordik'],
            'sapras' => ['label' => 'Sapras', 'icon' => 'building-2', 'route' => 'admin.sapras'],
            'inorga' => ['label' => 'INORGA', 'icon' => 'award', 'route' => 'admin.inorga'],
            'event' => ['label' => 'Event', 'icon' => 'flag', 'route' => 'admin.event'],
            'klasemen' => ['label' => 'Klasemen', 'icon' => 'trophy', 'route' => 'admin.klasemen'],
            'partisipasi' => ['label' => 'Partisipasi', 'icon' => 'activity', 'route' => 'admin.partisipasi.log'],
            'pengguna' => ['label' => 'Pengguna', 'icon' => 'user-cog', 'route' => 'admin.pengguna'],
            'pengaturan' => ['label' => 'Pengaturan', 'icon' => 'settings', 'route' => 'admin.pengaturan'],
        ];

        if ($isSuper) {
            $akses = ['berita', 'galeri', 'unduhan', 'duta', 'kordik', 'sapras', 'inorga', 'event', 'klasemen', 'partisipasi', 'pengguna', 'pengaturan'];

            $stats = [
                ['label' => 'Berita', 'value' => Berita::count(), 'icon' => 'newspaper'],
                ['label' => 'Duta', 'value' => $dutaDisetujui, 'icon' => 'users'],
                ['label' => 'INORGA', 'value' => Inorga::count(), 'icon' => 'award'],
                ['label' => 'Partisipasi', 'value' => PartisipasiAktivitas::valid()->count(), 'icon' => 'activity'],
            ];

            $terbaruJudul = 'Berita Terbaru';
            $terbaruIcon = 'newspaper';
            $terbaruLink = route('admin.berita');
            $terbaru = Berita::orderByDesc('tanggal_publikasi')->limit(3)->get()
                ->map(fn ($b) => [
                    'judul' => $b->judul,
                    'meta' => \Carbon\Carbon::parse($b->tanggal_publikasi)->translatedFormat('d M Y'),
                    'url' => route('admin.berita.edit', $b->id),
                ])->all();
        } elseif ($isEditor) {
            $akses = ['berita', 'galeri', 'unduhan'];

            $stats = [
                ['label' => 'Berita', 'value' => Berita::count(), 'icon' => 'newspaper'],
                ['label' => 'Galeri', 'value' => GaleriFoto::count(), 'icon' => 'camera'],
                ['label' => 'Unduhan', 'value' => Unduhan::count(), 'icon' => 'download'],
                ['label' => 'Dilihat', 'value' => number_format(Berita::sum('jumlah_dilihat') ?: 0), 'icon' => 'eye'],
            ];

            $terbaruJudul = 'Berita Terbaru';
            $terbaruIcon = 'newspaper';
            $terbaruLink = route('admin.berita');
            $terbaru = Berita::orderByDesc('tanggal_publikasi')->limit(3)->get()
                ->map(fn ($b) => [
                    'judul' => $b->judul,
                    'meta' => \Carbon\Carbon::parse($b->tanggal_publikasi)->translatedFormat('d M Y'),
                    'url' => route('admin.berita.edit', $b->id),
                ])->all();
        } elseif ($isKorcam) {
            $akses = ['duta', 'kordik', 'sapras'];

            $stats = [
                ['label' => 'Duta', 'value' => $dutaDisetujui, 'icon' => 'users'],
                ['label' => 'Menunggu', 'value' => $dutaMenunggu, 'icon' => 'clock'],
                ['label' => 'Kecamatan', 'value' => Kecamatan::count(), 'icon' => 'map-pin'],
                ['label' => 'Sapras', 'value' => Sapras::count(), 'icon' => 'building-2'],
            ];

            $terbaruJudul = 'Pendaftaran Duta Menunggu';
            $terbaruIcon = 'user-plus';
            $terbaruLink = route('admin.duta');
            $terbaru = DutaOlahraga::menunggu()->with(['desaKelurahan', 'kecamatan'])
                ->orderByDesc('dibuat_pada')
                ->limit(3)
                ->get()
                ->map(fn ($d) => [
                    'judul' => $d->nama_lengkap,
                    'meta' => trim(($d->desaKelurahan?->nama_desa_kelurahan ?? '-') . ' · ' . ($d->kecamatan?->nama_kecamatan ?? '-')),
                    'url' => route('admin.duta'),
                ])->all();
        } else {
            $akses = ['inorga', 'event', 'klasemen'];

            $stats = [
                ['label' => 'INORGA', 'value' => Inorga::count(), 'icon' => 'award'],
                ['label' => 'Event', 'value' => Event::count(), 'icon' => 'flag'],
                ['label' => 'Klub', 'value' => number_format(Inorga::sum('jumlah_klub_anggota') ?: 0), 'icon' => 'users'],
                ['label' => 'Komisi', 'value' => KomisiInorga::count(), 'icon' => 'layers'],
            ];

            $terbaruJudul = 'Event Terbaru';
            $terbaruIcon = 'flag';
            $terbaruLink = route('admin.event');
            $terbaru = Event::orderByDesc('tanggal_mulai')->limit(3)->get()
                ->map(fn ($e) => [
                    'judul' => $e->judul_event,
                    'meta' => ($e->tanggal_mulai ? \Carbon\Carbon::parse($e->tanggal_mulai)->translatedFormat('d M Y') : '-')
                        . ($e->lokasi_utama ? ' · ' . $e->lokasi_utama : ''),
                    'url' => route('admin.event'),
                ])->all();
        }

        return [
            'user' => $user,
            'roleLabel' => $peran?->nama_peran ?? 'Administrator',
            'stats' => $stats,
            'modul' => array_values(array_intersect_key($modulTersedia, array_flip($akses))),
            'terbaruJudul' => $terbaruJudul,
            'terbaruIcon' => $terbaruIcon,
            'terbaruLink' => $terbaruLink,
            'terbaru' => $terbaru,
            'dutaMenunggu' => $dutaMenunggu,
            'isSuper' => $isSuper,
        ];
    }
}
