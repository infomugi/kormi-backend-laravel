<?php

namespace App\Livewire\Mobile;

use App\Models\Kormi\Absensi as AbsensiHarian;
use App\Services\StorageService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.mobile')]
#[Title('Absensi - KORMI Kabupaten Bandung')]
class Absensi extends Component
{
    use WithFileUploads;

    public $foto = null;
    public ?float $latitude = null;
    public ?float $longitude = null;
    public ?float $akurasi_meter = null;
    public ?string $alamat = null;
    public string $catatan = '';
    public bool $berhasil = false;
    public string $pesanBerhasil = '';

    public function terapkanLokasi(float $lat, float $lng, ?string $alamat = null, ?float $akurasi = null): void
    {
        if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
            return;
        }

        $this->latitude = $lat;
        $this->longitude = $lng;
        $this->akurasi_meter = $akurasi;
        $this->alamat = $alamat ? mb_substr(strip_tags(trim($alamat)), 0, 255) : null;

        $this->resetValidation(['latitude', 'longitude']);
    }

    public function simpan(): void
    {
        $user = auth()->user();
        $sekarang = now('Asia/Jakarta');
        $absensi = $this->absensiHariIni();

        if ($absensi?->sudahPulang()) {
            $this->addError('absensi', 'Absensi masuk dan pulang hari ini sudah lengkap.');

            return;
        }

        $this->validate([
            'foto' => 'required|image|max:10240',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'catatan' => 'nullable|string|max:500',
        ], [
            'foto.required' => 'Ambil foto kehadiran terlebih dahulu.',
            'foto.image' => 'Foto kehadiran harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 10MB.',
            'latitude.required' => 'Koordinat lokasi belum terdeteksi. Aktifkan GPS lalu coba lagi.',
            'longitude.required' => 'Koordinat lokasi belum terdeteksi. Aktifkan GPS lalu coba lagi.',
            'latitude.between' => 'Koordinat lokasi tidak valid.',
            'longitude.between' => 'Koordinat lokasi tidak valid.',
            'catatan.max' => 'Catatan maksimal 500 karakter.',
        ]);

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        try {
            $pathFoto = $storage->uploadGambar($this->foto, 'absensi/' . now()->format('Y-m'));
        } catch (\InvalidArgumentException $e) {
            $this->addError('foto', $e->getMessage());

            return;
        } catch (\Throwable $e) {
            report($e);
            $this->addError('foto', 'Foto gagal diunggah. Periksa koneksi lalu coba lagi.');

            return;
        }

        $sekarang = now('Asia/Jakarta');
        $catatan = $this->catatan !== '' ? mb_substr(strip_tags(trim($this->catatan)), 0, 500) : null;

        $dataMasuk = [
            'jam_masuk' => $sekarang->format('H:i:s'),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'akurasi_meter' => $this->akurasi_meter,
            'alamat' => $this->alamat,
            'foto_masuk' => $pathFoto,
            'catatan' => $catatan,
        ];

        $absensiTerhapus = AbsensiHarian::onlyTrashed()
            ->where('pengguna_id', $user->id)
            ->where('tanggal', $sekarang->toDateString())
            ->first();

        if (! $absensi && $absensiTerhapus) {
            // Baris hari ini pernah dihapus (soft delete) dan masih memegang
            // indeks unik (pengguna_id, tanggal). Pulihkan sebagai absen masuk
            // baru agar tidak gagal dengan duplicate entry.
            $fotoLama = array_filter([$absensiTerhapus->foto_masuk, $absensiTerhapus->foto_pulang]);

            $absensiTerhapus->restore();
            $absensiTerhapus->update($dataMasuk + [
                'jam_pulang' => null,
                'latitude_pulang' => null,
                'longitude_pulang' => null,
                'akurasi_meter_pulang' => null,
                'alamat_pulang' => null,
                'foto_pulang' => null,
            ]);

            foreach ($fotoLama as $berkas) {
                $storage->hapusFile($berkas);
            }

            $this->pesanBerhasil = 'Absensi masuk tercatat pukul ' . $sekarang->format('H:i') . ' WIB. Selamat beraktivitas!';
        } elseif ($absensi) {
            $absensi->update([
                'jam_pulang' => $sekarang->format('H:i:s'),
                'latitude_pulang' => $this->latitude,
                'longitude_pulang' => $this->longitude,
                'akurasi_meter_pulang' => $this->akurasi_meter,
                'alamat_pulang' => $this->alamat,
                'foto_pulang' => $pathFoto,
                'catatan' => $catatan ?: $absensi->catatan,
            ]);

            $this->pesanBerhasil = 'Absensi pulang tercatat pukul ' . $sekarang->format('H:i') . ' WIB. Hati-hati di jalan!';
        } else {
            AbsensiHarian::create($dataMasuk + [
                'pengguna_id' => $user->id,
                'tanggal' => $sekarang->toDateString(),
            ]);

            $this->pesanBerhasil = 'Absensi masuk tercatat pukul ' . $sekarang->format('H:i') . ' WIB. Selamat beraktivitas!';
        }

        $this->reset(['foto', 'catatan', 'latitude', 'longitude', 'akurasi_meter', 'alamat']);
        $this->resetValidation();
        $this->berhasil = true;
        $this->dispatch('absensi-tersimpan');
    }

    public function render()
    {
        $hariIni = now('Asia/Jakarta')->toDateString();
        $absensi = $this->absensiHariIni();

        $tahap = match (true) {
            ! $absensi => 'masuk',
            $absensi->sudahPulang() => 'selesai',
            default => 'pulang',
        };

        $riwayat = AbsensiHarian::where('pengguna_id', auth()->id())
            ->where('tanggal', '<', $hariIni)
            ->orderByDesc('tanggal')
            ->limit(7)
            ->get();

        return view('livewire.mobile.absensi', [
            'absensiHariIni' => $absensi,
            'tahap' => $tahap,
            'riwayat' => $riwayat,
        ]);
    }

    private function absensiHariIni(): ?AbsensiHarian
    {
        return AbsensiHarian::where('pengguna_id', auth()->id())
            ->where('tanggal', now('Asia/Jakarta')->toDateString())
            ->first();
    }
}
