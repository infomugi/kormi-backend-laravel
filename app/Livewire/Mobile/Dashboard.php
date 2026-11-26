<?php

namespace App\Livewire\Mobile;

use App\Models\Content\Berita;
use App\Models\Content\GaleriFoto;
use App\Models\Content\Unduhan;
use App\Models\Core\Pengguna;
use App\Models\Kormi\Absensi as AbsensiHarian;
use App\Models\Kormi\AngketApmo;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Kormi\Event;
use App\Models\Kormi\Inorga;
use App\Models\Kormi\KomisiInorga;
use App\Models\Kormi\PartisipasiAktivitas;
use App\Models\Kormi\Sapras;
use App\Models\Master\Kecamatan;
use App\Services\PersetujuanPendaftaran;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.mobile')]
#[Title('Dashboard - KORMI Kabupaten Bandung')]
class Dashboard extends Component
{
    public ?string $pesanPersetujuan = null;
    public bool $galatPersetujuan = false;

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
        $isDuta = $user->isDutaOlahraga();
        $isPengelola = ! $isDuta && ! $user->isPegiatOlahraga();
        $duta = $user->duta
            ?? ($isDuta ? DutaOlahraga::where('pengguna_id', $user->id)->first() : null);
        $aktivitas = $this->dataAktivitas($user);
        $absensi = $this->dataAbsensi($user);

        $data = [
            'user' => $user,
            'duta' => $duta,
            'roleLabel' => $user->peran?->nama_peran ?? 'Pengguna',
            'badgePeran' => $this->badgePeran($user),
            'sapaan' => $this->sapaan(),
            'absensi' => $absensi,
            'apmo' => $this->dataApmo($user),
            'metrik' => [
                'kehadiran' => $absensi['bulanIni'],
                'aktivitas' => $aktivitas['stats']['total'],
                'valid' => $aktivitas['stats']['valid'],
            ],
            'aksiCepat' => $this->aksiCepat($isPengelola, $isDuta, $user->isSuperAdmin()),
            'berita' => Berita::orderByDesc('tanggal_publikasi')->limit(5)->get(),
            'isPengelola' => $isPengelola,
            'isDuta' => $isDuta,
        ];

        if ($isPengelola) {
            $admin = $this->dataAdmin($user);
            $data['adminStats'] = $admin['stats'];
            $data['modul'] = $admin['modul'];
            $data['terbaruJudul'] = $admin['terbaruJudul'];
            $data['terbaruIcon'] = $admin['terbaruIcon'];
            $data['terbaruLink'] = $admin['terbaruLink'];
            $data['terbaruAdmin'] = $admin['terbaru'];
            $data['dutaMenunggu'] = $admin['dutaMenunggu'];
            $data['akunMenunggu'] = $admin['akunMenunggu'];
            $data['antreanPersetujuan'] = $admin['antreanPersetujuan'];
            $data['isSuper'] = $admin['isSuper'];
        } else {
            $data['terbaruAktivitas'] = $aktivitas['terbaru'];
        }

        return view('livewire.mobile.dashboard', $data);
    }

    private function bolehAkses(Pengguna $user): bool
    {
        return $user->isDutaOlahraga()
            || $user->isPegiatOlahraga()
            || $user->hasRole('super-admin', 'admin-korcam', 'admin-inorga', 'editor-berita');
    }

    private function badgePeran(Pengguna $user): string
    {
        return match (true) {
            $user->isSuperAdmin() => 'Super Admin',
            $user->isAdminKorcam() => 'Korcam',
            $user->isAdminInorga() => 'Inorga',
            $user->isEditorBerita() => 'Editor',
            $user->isDutaOlahraga() => 'Duta',
            default => 'Pegiat',
        };
    }

    private function sapaan(): string
    {
        $jam = (int) now('Asia/Jakarta')->format('H');

        return match (true) {
            $jam < 11 => 'Selamat pagi',
            $jam < 15 => 'Selamat siang',
            $jam < 18 => 'Selamat sore',
            default => 'Selamat malam',
        };
    }

    private function dataAbsensi(Pengguna $user): array
    {
        $sekarang = now('Asia/Jakarta');
        $absensi = AbsensiHarian::where('pengguna_id', $user->id)
            ->where('tanggal', $sekarang->toDateString())
            ->first();

        return [
            'hariIni' => $absensi,
            'tahap' => match (true) {
                ! $absensi => 'masuk',
                $absensi->sudahPulang() => 'selesai',
                default => 'pulang',
            },
            'bulanIni' => AbsensiHarian::where('pengguna_id', $user->id)
                ->whereYear('tanggal', $sekarang->year)
                ->whereMonth('tanggal', $sekarang->month)
                ->count(),
            'jamSekarang' => $sekarang->format('H:i'),
            'tanggalRapi' => $sekarang->locale('id')->isoFormat('dddd, D MMMM Y'),
        ];
    }

    private function dataApmo(Pengguna $user): array
    {
        $terakhir = AngketApmo::where('pengguna_id', $user->id)
            ->latest('dibuat_pada')
            ->first();

        return [
            'terakhir' => $terakhir,
            'jumlah' => AngketApmo::where('pengguna_id', $user->id)->count(),
            'sudah' => $terakhir !== null,
            'waktuRapi' => $terakhir
                ? Carbon::parse($terakhir->dibuat_pada)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM Y')
                : null,
        ];
    }

    private function aksiCepat(bool $isPengelola, bool $isDuta, bool $isSuper = false): array
    {
        $aksi = [];

        if ($isDuta) {
            $aksi[] = ['label' => 'Absensi', 'icon' => 'fingerprint', 'route' => 'mobile.absensi', 'tint' => 'lime'];
            $aksi[] = ['label' => 'Survei APMO', 'icon' => 'clipboard-list', 'route' => 'mobile.angket', 'tint' => 'amber'];
        }

        $aksi[] = $isPengelola
            ? ['label' => 'Kelola Situs', 'icon' => 'layout-grid', 'route' => 'admin.dashboard', 'tint' => 'sky']
            : ['label' => 'Catat Aktivitas', 'icon' => 'clipboard-pen', 'route' => 'partisipasi.catat', 'tint' => 'sky'];

        if ($isSuper) {
            $aksi[] = ['label' => 'Monitoring APMO', 'icon' => 'radar', 'route' => 'mobile.apmo.wilayah', 'tint' => 'amber'];
            $aksi[] = ['label' => 'Kelola User', 'icon' => 'user-cog', 'route' => 'mobile.kelola-user', 'tint' => 'rose'];
        }

        $aksi[] = $isPengelola
            ? ['label' => 'Unduhan', 'icon' => 'download', 'route' => 'admin.unduhan', 'tint' => 'violet']
            : ['label' => 'Riwayat APMO', 'icon' => 'history', 'route' => 'partisipasi.riwayat', 'tint' => 'violet'];

        $aksi[] = ['label' => 'Layanan', 'icon' => 'blocks', 'route' => 'mobile.layanan', 'tint' => 'slate'];
        $aksi[] = ['label' => 'Direktori', 'icon' => 'users', 'route' => 'mobile.direktori-duta', 'tint' => 'mint'];
        $aksi[] = ['label' => 'Berita', 'icon' => 'newspaper', 'route' => 'mobile.berita', 'tint' => 'rose'];
        $aksi[] = ['label' => 'Profil', 'icon' => 'circle-user', 'route' => 'mobile.profil', 'tint' => 'sun'];

        return $aksi;
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

    private function dataAdmin(Pengguna $user): array
    {
        $isSuper = $user->isSuperAdmin();
        $isEditor = $user->isEditorBerita();
        $isKorcam = $user->isAdminKorcam();

        $dutaDisetujui = DutaOlahraga::where('status_aktif', true)
            ->where('status_pendaftaran', DutaOlahraga::STATUS_DISETUJUI)
            ->count();
        $dutaMenunggu = DutaOlahraga::menunggu()->count();

        $modulTersedia = [
            'berita' => ['label' => 'Berita', 'icon' => 'newspaper', 'route' => 'admin.berita'],
            'galeri' => ['label' => 'Galeri', 'icon' => 'camera', 'route' => 'admin.galeri'],
            'unduhan' => ['label' => 'Unduhan', 'icon' => 'download', 'route' => 'admin.unduhan'],
            'duta' => ['label' => 'Duta', 'icon' => 'users', 'route' => 'admin.duta'],
            'survei' => ['label' => 'Survei APMO', 'icon' => 'radar', 'route' => 'mobile.apmo.wilayah'],
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
            $akses = ['berita', 'galeri', 'unduhan', 'duta', 'survei', 'kordik', 'sapras', 'inorga', 'event', 'klasemen', 'partisipasi', 'pengguna', 'pengaturan'];

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
                    'meta' => Carbon::parse($b->tanggal_publikasi)->translatedFormat('d M Y'),
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
                    'meta' => Carbon::parse($b->tanggal_publikasi)->translatedFormat('d M Y'),
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
                    'meta' => ($e->tanggal_mulai ? Carbon::parse($e->tanggal_mulai)->translatedFormat('d M Y') : '-')
                        . ($e->lokasi_utama ? ' · ' . $e->lokasi_utama : ''),
                    'url' => route('admin.event'),
                ])->all();
        }

        $dutaTerhubung = DutaOlahraga::menunggu()
            ->whereNotNull('pengguna_id')
            ->pluck('pengguna_id');

        $akunMenunggu = $isSuper
            ? Pengguna::where('status_aktif', false)
                ->whereNull('disetujui_pada')
                ->whereNotIn('id', $dutaTerhubung)
                ->count()
            : 0;

        return [
            'stats' => $stats,
            'modul' => array_values(array_intersect_key($modulTersedia, array_flip($akses))),
            'terbaruJudul' => $terbaruJudul,
            'terbaruIcon' => $terbaruIcon,
            'terbaruLink' => $terbaruLink,
            'terbaru' => $terbaru,
            'dutaMenunggu' => $dutaMenunggu,
            'akunMenunggu' => $akunMenunggu,
            'antreanPersetujuan' => $isSuper ? $this->antreanPersetujuan() : [],
            'isSuper' => $isSuper,
        ];
    }

    private function antreanPersetujuan(): array
    {
        $duta = DutaOlahraga::menunggu()
            ->with(['kecamatan', 'desaKelurahan'])
            ->orderByDesc('dibuat_pada')
            ->limit(3)
            ->get()
            ->map(fn (DutaOlahraga $d) => [
                'jenis' => 'duta',
                'id' => $d->id,
                'judul' => $d->nama_lengkap,
                'meta' => 'Duta · ' . collect([
                    $d->desaKelurahan?->nama_desa_kelurahan,
                    $d->kecamatan?->nama_kecamatan,
                ])->filter()->implode(' · '),
                'waktu' => $d->dibuat_pada,
            ]);

        $akun = Pengguna::query()
            ->where('status_aktif', false)
            ->whereNull('disetujui_pada')
            ->whereNotIn('id', DutaOlahraga::menunggu()->whereNotNull('pengguna_id')->pluck('pengguna_id'))
            ->orderByDesc('dibuat_pada')
            ->limit(3)
            ->get()
            ->map(fn (Pengguna $u) => [
                'jenis' => 'akun',
                'id' => $u->id,
                'judul' => $u->nama_lengkap,
                'meta' => 'Akun · ' . $u->email,
                'waktu' => $u->dibuat_pada,
            ]);

        return $duta->concat($akun)
            ->sortByDesc(fn ($baris) => (string) $baris['waktu'])
            ->take(3)
            ->values()
            ->all();
    }

    public function setujuiDuta(string $id): void
    {
        $this->pastikanSuperAdmin();

        $duta = DutaOlahraga::find($id);

        if (! $duta || ! $duta->sedangMenunggu()) {
            $this->galatPersetujuan = true;
            $this->pesanPersetujuan = 'Pendaftaran tersebut sudah diproses sebelumnya.';
            return;
        }

        app(PersetujuanPendaftaran::class)->setujuiDuta($duta, auth()->id());

        $this->galatPersetujuan = false;
        $this->pesanPersetujuan = 'Pendaftaran "' . $duta->nama_lengkap . '" disetujui.';
    }

    public function setujuiAkun(string $id): void
    {
        $this->pastikanSuperAdmin();

        $akun = Pengguna::find($id);

        if (! $akun || $akun->status_aktif) {
            $this->galatPersetujuan = true;
            $this->pesanPersetujuan = 'Akun tersebut sudah aktif atau tidak ditemukan.';
            return;
        }

        app(PersetujuanPendaftaran::class)->setujuiAkun($akun, auth()->id());

        $this->galatPersetujuan = false;
        $this->pesanPersetujuan = 'Akun "' . $akun->nama_lengkap . '" diaktifkan.';
    }

    private function pastikanSuperAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403);
    }
}
