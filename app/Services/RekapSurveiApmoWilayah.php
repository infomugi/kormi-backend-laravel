<?php

namespace App\Services;

use App\Models\Kormi\AngketApmo;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RekapSurveiApmoWilayah
{
    /**
     * Rekap isian Survei APMO per kecamatan dan desa/kelurahan.
     *
     * @return array{kecamatan: array, desa: array, ringkasan: array}
     */
    public function rekap(): array
    {
        $agregatKecamatan = $this->agregatKecamatan();
        $agregatDesa = $this->agregatDesa();

        $semuaKecamatan = Kecamatan::withCount('desaKelurahan')
            ->orderBy('nama_kecamatan')
            ->get(['id', 'nama_kecamatan']);

        $semuaDesa = DesaKelurahan::with('kecamatan:id,nama_kecamatan')
            ->orderBy('nama_desa_kelurahan')
            ->get(['id', 'kecamatan_id', 'nama_desa_kelurahan']);

        $desa = $this->rekapDesa($semuaDesa, $agregatDesa);
        $kecamatan = $this->rekapKecamatan($semuaKecamatan, $agregatKecamatan, $desa);

        $kecamatanTerisi = collect($kecamatan)->where('total', '>', 0)->count();
        $desaTerisi = collect($desa)->where('total', '>', 0)->count();

        $kunciMaster = $semuaKecamatan
            ->map(fn (Kecamatan $kecamatan) => $this->kunci($kecamatan->nama_kecamatan))
            ->flip();

        $isianTanpaWilayah = AngketApmo::where(fn ($q) => $q->whereNull('kecamatan')->orWhere('kecamatan', ''))->count();
        $isianTanpaMaster = $agregatKecamatan
            ->reject(fn ($baris, $kunci) => $kunciMaster->has($kunci))
            ->sum('total');

        return [
            'kecamatan' => $kecamatan,
            'desa' => $desa,
            'ringkasan' => [
                'totalIsian' => AngketApmo::count(),
                'kecamatanTerisi' => $kecamatanTerisi,
                'kecamatanTotal' => $semuaKecamatan->count(),
                'kecamatanBelum' => $semuaKecamatan->count() - $kecamatanTerisi,
                'desaTerisi' => $desaTerisi,
                'desaTotal' => $semuaDesa->count(),
                'desaBelum' => $semuaDesa->count() - $desaTerisi,
                'isianTanpaMaster' => (int) $isianTanpaMaster + $isianTanpaWilayah,
            ],
        ];
    }

    public function saringDanUrut(array $baris, string $cari, string $urut, string $arah): array
    {
        $koleksi = collect($baris);

        if (trim($cari) !== '') {
            $kata = Str::lower(trim($cari));
            $koleksi = $koleksi->filter(fn ($item) => Str::contains(Str::lower($item['nama']), $kata)
                || ($item['wilayah'] && Str::contains(Str::lower($item['wilayah']), $kata)));
        }

        $arah = $arah === 'desc' ? 'desc' : 'asc';
        $koleksi = $urut === 'total'
            ? $koleksi->sortBy([['total', $arah], ['nama', 'asc']])
            : $koleksi->sortBy([['nama', $arah], ['total', 'desc']]);

        return $koleksi->values()->all();
    }

    private function agregatKecamatan(): Collection
    {
        return AngketApmo::query()
            ->selectRaw('LOWER(TRIM(kecamatan)) as kunci, COUNT(*) as total, MAX(dibuat_pada) as terakhir')
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '!=', '')
            ->groupByRaw('LOWER(TRIM(kecamatan))')
            ->get()
            ->keyBy('kunci');
    }

    private function agregatDesa(): Collection
    {
        return AngketApmo::query()
            ->selectRaw('LOWER(TRIM(kecamatan)) as kunci_kecamatan, LOWER(TRIM(desa)) as kunci_desa, COUNT(*) as total, MAX(dibuat_pada) as terakhir')
            ->whereNotNull('desa')
            ->where('desa', '!=', '')
            ->groupByRaw('LOWER(TRIM(kecamatan)), LOWER(TRIM(desa))')
            ->get()
            ->keyBy(fn ($baris) => $baris->kunci_kecamatan.'|'.$baris->kunci_desa);
    }

    private function rekapDesa(Collection $semuaDesa, Collection $agregat): array
    {
        return $semuaDesa->map(function (DesaKelurahan $desa) use ($agregat) {
            $kecamatan = $desa->kecamatan?->nama_kecamatan ?? '';
            $data = $agregat->get($this->kunci($kecamatan).'|'.$this->kunci($desa->nama_desa_kelurahan));

            return [
                'id' => $desa->id,
                'nama' => $desa->nama_desa_kelurahan,
                'wilayah' => $kecamatan,
                'total' => (int) ($data->total ?? 0),
                'terakhir' => $this->tanggal($data->terakhir ?? null),
            ];
        })->all();
    }

    private function rekapKecamatan(Collection $semuaKecamatan, Collection $agregat, array $rekapDesa): array
    {
        $desaTerisi = collect($rekapDesa)
            ->where('total', '>', 0)
            ->countBy(fn ($baris) => $this->kunci($baris['wilayah']));

        return $semuaKecamatan->map(function (Kecamatan $kecamatan) use ($agregat, $desaTerisi) {
            $kunci = $this->kunci($kecamatan->nama_kecamatan);
            $data = $agregat->get($kunci);

            return [
                'id' => $kecamatan->id,
                'nama' => $kecamatan->nama_kecamatan,
                'wilayah' => null,
                'jumlah_desa' => (int) $kecamatan->desa_kelurahan_count,
                'desa_terisi' => (int) ($desaTerisi[$kunci] ?? 0),
                'total' => (int) ($data->total ?? 0),
                'terakhir' => $this->tanggal($data->terakhir ?? null),
            ];
        })->all();
    }

    private function kunci(?string $nama): string
    {
        return Str::lower(trim((string) $nama));
    }

    private function tanggal($nilai): ?string
    {
        if (! $nilai) {
            return null;
        }

        return Carbon::parse($nilai)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM Y, HH:mm');
    }
}
