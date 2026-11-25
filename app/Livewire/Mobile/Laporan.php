<?php

namespace App\Livewire\Mobile;

use App\Models\Core\Pengguna;
use App\Models\Kormi\AngketApmo;
use App\Models\Kormi\DutaOlahraga;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.mobile')]
#[Title('Laporan APMO - KORMI Kabupaten Bandung')]
class Laporan extends Component
{
    use WithPagination;

    #[Url(as: 'tab')]
    public string $tab = 'riwayat';

    #[Url(as: 'lingkup')]
    public string $lingkup = 'saya';

    public function mount()
    {
        $user = auth()->user();

        if (! $user || ! $this->bolehAkses($user)) {
            return redirect()->route('admin.dashboard');
        }

        if (! in_array($this->tab, ['riwayat', 'statistik'], true)) {
            $this->tab = 'riwayat';
        }

        if (! in_array($this->lingkup, ['saya', 'desa', 'kecamatan'], true)) {
            $this->lingkup = 'saya';
        }
    }

    public function pilihTab(string $tab): void
    {
        if (! in_array($tab, ['riwayat', 'statistik'], true)) {
            return;
        }

        $this->tab = $tab;
        $this->resetPage();
    }

    public function pilihLingkup(string $lingkup): void
    {
        if (! in_array($lingkup, ['saya', 'desa', 'kecamatan'], true)) {
            return;
        }

        $this->lingkup = $lingkup;
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        $wilayah = $this->wilayah($user);
        $aktifWilayah = match ($this->lingkup) {
            'desa' => (bool) $wilayah['desa'],
            'kecamatan' => (bool) $wilayah['kecamatan'],
            default => true,
        };

        $kueri = $this->kueri($user, $wilayah);

        $data = [
            'user' => $user,
            'wilayah' => $wilayah,
            'aktifWilayah' => $aktifWilayah,
            'namaLingkup' => $this->namaLingkup($wilayah),
            'ringkasan' => $aktifWilayah ? $this->ringkasan($kueri) : null,
            'daftar' => null,
            'statistik' => null,
            'opsiFrekuensi' => Angket::OPSI_FREKUENSI,
        ];

        if ($this->tab === 'riwayat') {
            $data['daftar'] = $kueri->orderByDesc('dibuat_pada')->paginate(10);
        } else {
            $data['statistik'] = $this->lingkup === 'saya'
                ? $this->statistikPribadi($user)
                : $this->statistikWilayah($kueri);
        }

        return view('livewire.mobile.laporan', $data);
    }

    private function bolehAkses(Pengguna $user): bool
    {
        return $user->isDutaOlahraga()
            || $user->isPegiatOlahraga()
            || $user->hasRole('super-admin', 'admin-korcam', 'admin-inorga', 'editor-berita');
    }

    private function wilayah(Pengguna $user): array
    {
        $duta = $user->duta ?? DutaOlahraga::where('pengguna_id', $user->id)->first();

        return [
            'desa' => $duta?->desaKelurahan?->nama_desa_kelurahan ?? $user->desa?->nama_desa_kelurahan,
            'kecamatan' => $duta?->kecamatan?->nama_kecamatan ?? $user->kecamatan?->nama_kecamatan,
        ];
    }

    private function namaLingkup(array $wilayah): string
    {
        return match ($this->lingkup) {
            'desa' => $wilayah['desa'] ? 'Desa ' . $wilayah['desa'] : 'Desa belum diatur',
            'kecamatan' => $wilayah['kecamatan'] ? 'Kec. ' . $wilayah['kecamatan'] : 'Kecamatan belum diatur',
            default => 'Isian akun ' . auth()->user()->nama_lengkap,
        };
    }

    private function kueri(Pengguna $user, array $wilayah): Builder
    {
        $kueri = AngketApmo::query();

        return match ($this->lingkup) {
            'desa' => $wilayah['desa']
                ? $kueri->where('desa', $wilayah['desa'])
                : $kueri->whereRaw('1 = 0'),
            'kecamatan' => $wilayah['kecamatan']
                ? $kueri->where('kecamatan', $wilayah['kecamatan'])
                : $kueri->whereRaw('1 = 0'),
            default => $kueri->where('pengguna_id', $user->id),
        };
    }

    private function ringkasan(Builder $kueri): array
    {
        $total = (clone $kueri)->count();
        $aktif = (clone $kueri)->where('melakukan_olahraga', true)->count();
        $usiaRata = (clone $kueri)->avg('usia');
        $terakhir = (clone $kueri)->max('dibuat_pada');

        return [
            'total' => $total,
            'aktif' => $aktif,
            'persenAktif' => $total > 0 ? (int) round($aktif / $total * 100) : 0,
            'usiaRata' => $usiaRata !== null ? round((float) $usiaRata, 1) : null,
            'terakhir' => $terakhir ? $this->tanggal($terakhir) : null,
        ];
    }

    private function statistikPribadi(Pengguna $user): array
    {
        $isian = AngketApmo::where('pengguna_id', $user->id)
            ->orderByDesc('dibuat_pada')
            ->get();

        $terakhir = $isian->first();

        if (! $terakhir) {
            return ['ada' => false, 'jumlah' => 0];
        }

        $tinggi = (int) $terakhir->tinggi_badan;
        $berat = (int) $terakhir->berat_badan;
        $imt = ($tinggi > 0 && $berat > 0) ? round($berat / (($tinggi / 100) ** 2), 1) : null;

        $aktivitas = [];
        $totalMenitMinggu = 0;

        foreach (['berat' => 'Olahraga berat', 'sedang' => 'Olahraga sedang', 'jalan' => 'Jalan kaki'] as $jenis => $label) {
            $frekuensi = $terakhir->{'frekuensi_' . $jenis};
            $jam = (int) $terakhir->{'durasi_' . $jenis . '_jam'};
            $menit = (int) $terakhir->{'durasi_' . $jenis . '_menit'};
            $tidakTahu = (bool) $terakhir->{'durasi_' . $jenis . '_tidak_tahu'};
            $menitMinggu = $this->menitPerMinggu($frekuensi, $jam, $menit, $tidakTahu);
            $totalMenitMinggu += $menitMinggu ?? 0;

            $aktivitas[] = [
                'label' => $label,
                'frekuensi' => Angket::OPSI_FREKUENSI[$frekuensi] ?? '—',
                'durasi' => $tidakTahu ? 'Tidak tahu' : $this->formatDurasi($jam, $menit),
                'menitMinggu' => $menitMinggu,
            ];
        }

        return [
            'ada' => true,
            'jumlah' => $isian->count(),
            'tanggal' => $this->tanggal($terakhir->dibuat_pada),
            'imt' => $imt,
            'imtLabel' => $this->labelImt($imt),
            'olahraga' => (bool) $terakhir->melakukan_olahraga,
            'profil' => [
                ['label' => 'Usia', 'nilai' => $terakhir->usia . ' tahun'],
                ['label' => 'Jenis kelamin', 'nilai' => match ($terakhir->jenis_kelamin) {
                    'pria' => 'Laki-laki',
                    'wanita' => 'Perempuan',
                    default => '—',
                }],
                ['label' => 'Desa / kelurahan', 'nilai' => $terakhir->desa ?: '—'],
                ['label' => 'Kecamatan', 'nilai' => $terakhir->kecamatan ?: '—'],
                ['label' => 'Pekerjaan', 'nilai' => Angket::OPSI_PEKERJAAN[$terakhir->pekerjaan] ?? '—'],
            ],
            'aktivitas' => $aktivitas,
            'totalMenitMinggu' => $totalMenitMinggu,
            'duduk' => ! $terakhir->pernah_malas || $terakhir->pernah_malas !== 'pernah'
                ? '—'
                : ($terakhir->duduk_tidak_tahu ? 'Tidak tahu' : $this->formatDurasi((int) $terakhir->duduk_jam, (int) $terakhir->duduk_menit)),
            'cabang' => $this->labelOpsi(Angket::OPSI_CABANG, $terakhir->cabang_olahraga, $terakhir->cabang_lainnya),
            'tujuan' => $this->labelOpsi(Angket::OPSI_TUJUAN, $terakhir->tujuan_olahraga, $terakhir->tujuan_lainnya),
            'jalur' => $this->labelOpsi(Angket::OPSI_JALUR, $terakhir->jalur_olahraga, $terakhir->jalur_lainnya),
            'fasilitas' => $this->labelOpsi(Angket::OPSI_FASILITAS, $terakhir->fasilitas_olahraga),
            'alasan' => $this->labelOpsi(Angket::OPSI_ALASAN, $terakhir->alasan_tidak_olahraga, $terakhir->alasan_lainnya),
        ];
    }

    private function statistikWilayah(Builder $kueri): array
    {
        $total = (clone $kueri)->count();

        if ($total === 0) {
            return ['ada' => false];
        }

        $aktif = (clone $kueri)->where('melakukan_olahraga', true)->count();
        $usiaRata = (clone $kueri)->avg('usia');
        $terakhir = (clone $kueri)->max('dibuat_pada');

        $gender = (clone $kueri)
            ->selectRaw('jenis_kelamin as kunci, COUNT(*) as jumlah')
            ->groupBy('jenis_kelamin')
            ->pluck('jumlah', 'kunci');

        $cabang = (clone $kueri)
            ->where('melakukan_olahraga', true)
            ->whereNotNull('cabang_olahraga')
            ->selectRaw('cabang_olahraga as kunci, COUNT(*) as jumlah')
            ->groupBy('cabang_olahraga')
            ->orderByDesc('jumlah')
            ->limit(5)
            ->get()
            ->map(fn ($baris) => [
                'label' => Angket::OPSI_CABANG[$baris->kunci] ?? ucfirst(str_replace('_', ' ', $baris->kunci)),
                'jumlah' => (int) $baris->jumlah,
                'persen' => $aktif > 0 ? (int) round($baris->jumlah / $aktif * 100) : 0,
            ])
            ->all();

        $frekuensiRaw = (clone $kueri)
            ->where('melakukan_olahraga', true)
            ->whereNotNull('frekuensi_sedang')
            ->selectRaw('frekuensi_sedang as kunci, COUNT(*) as jumlah')
            ->groupBy('frekuensi_sedang')
            ->pluck('jumlah', 'kunci');

        $frekuensi = collect(Angket::OPSI_FREKUENSI)
            ->map(fn ($label, $kunci) => [
                'label' => $label,
                'jumlah' => $jumlah = (int) ($frekuensiRaw[$kunci] ?? 0),
                'persen' => $aktif > 0 ? (int) round($jumlah / $aktif * 100) : 0,
            ])
            ->values()
            ->all();

        $fasilitasRaw = (clone $kueri)
            ->whereNotNull('fasilitas_olahraga')
            ->selectRaw('fasilitas_olahraga as kunci, COUNT(*) as jumlah')
            ->groupBy('fasilitas_olahraga')
            ->pluck('jumlah', 'kunci');

        $fasilitas = collect(Angket::OPSI_FASILITAS)
            ->map(fn ($label, $kunci) => [
                'label' => $label,
                'jumlah' => $jumlah = (int) ($fasilitasRaw[$kunci] ?? 0),
                'persen' => $total > 0 ? (int) round($jumlah / $total * 100) : 0,
            ])
            ->values()
            ->all();

        return [
            'ada' => true,
            'total' => $total,
            'aktif' => $aktif,
            'pasif' => $total - $aktif,
            'usiaRata' => $usiaRata !== null ? round((float) $usiaRata, 1) : null,
            'terakhir' => $terakhir ? $this->tanggal($terakhir) : null,
            'gender' => [
                ['label' => 'Laki-laki', 'jumlah' => $genderPria = (int) ($gender['pria'] ?? 0), 'persen' => (int) round($genderPria / $total * 100)],
                ['label' => 'Perempuan', 'jumlah' => $genderWanita = (int) ($gender['wanita'] ?? 0), 'persen' => (int) round($genderWanita / $total * 100)],
            ],
            'cabang' => $cabang,
            'frekuensi' => $frekuensi,
            'fasilitas' => $fasilitas,
        ];
    }

    private function tanggal($nilai): string
    {
        return Carbon::parse($nilai)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM Y');
    }

    private function formatDurasi(int $jam, int $menit): string
    {
        if ($jam <= 0 && $menit <= 0) {
            return '—';
        }

        $bagian = [];

        if ($jam > 0) {
            $bagian[] = $jam . ' jam';
        }

        if ($menit > 0) {
            $bagian[] = $menit . ' menit';
        }

        return implode(' ', $bagian);
    }

    private function menitPerMinggu(?string $frekuensi, int $jam, int $menit, bool $tidakTahu): ?int
    {
        $kali = match ($frekuensi) {
            '1' => 1,
            '2' => 2,
            '3' => 3,
            'lebih' => 4,
            default => null,
        };

        $perSesi = $jam * 60 + $menit;

        if ($kali === null || $tidakTahu || $perSesi <= 0) {
            return null;
        }

        return $kali * $perSesi;
    }

    private function labelImt(?float $imt): ?string
    {
        if ($imt === null) {
            return null;
        }

        return match (true) {
            $imt < 18.5 => 'Kurang',
            $imt < 25 => 'Normal',
            $imt < 30 => 'Berlebih',
            default => 'Obesitas',
        };
    }

    private function labelOpsi(array $opsi, ?string $kunci, ?string $lainnya = null): string
    {
        if (! $kunci) {
            return '—';
        }

        if ($kunci === 'lainnya' && $lainnya) {
            return $lainnya;
        }

        return $opsi[$kunci] ?? ucfirst(str_replace('_', ' ', $kunci));
    }
}
