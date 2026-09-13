<?php

namespace App\Livewire\Frontend\Kormi\Partisipasi;

use App\Models\Kormi\PartisipasiAktivitas;
use App\Models\Kormi\Inorga;
use App\Models\Master\Kecamatan;
use App\Models\Master\DesaKelurahan;
use App\Models\Kormi\Sapras;
use App\Services\StorageService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.frontend')]
#[Title('Catat Aktivitas Olahraga - KORMI Kabupaten Bandung')]
class PartisipasiInput extends Component
{
    use WithFileUploads;

    public string $nama_aktivitas = '';
    public ?string $inorga_id = null;
    public string $tanggal_aktivitas = '';
    public string $waktu_mulai = '';
    public int $durasi_menit = 30;
    public string $kategori_lokasi = 'lapangan_desa';
    public ?string $sapras_id = null;
    public ?string $kecamatan_id = null;
    public ?string $desa_kelurahan_id = null;
    public string $nama_tempat = '';
    public ?float $latitude = null;
    public ?float $longitude = null;
    public ?string $lokasi_terdeteksi_label = null;
    public bool $isDetectingLocation = false;
    public $foto_kegiatan = null;
    public string $catatan = '';

    public int $currentStep = 1;
    public int $totalSteps = 3;

    public bool $berhasilSimpan = false;

    public array $presetOlahraga = [
        ['nama' => 'Jalan Santai / Jalan Pagi', 'icon' => 'footprints', 'durasi' => 30],
        ['nama' => 'Jogging / Lari Pagi', 'icon' => 'flame', 'durasi' => 30],
        ['nama' => 'Senam Sehat / Aerobik', 'icon' => 'activity', 'durasi' => 45],
        ['nama' => 'Bersepeda Santai', 'icon' => 'bike', 'durasi' => 45],
        ['nama' => 'Badminton / Bulutangkis', 'icon' => 'trophy', 'durasi' => 60],
        ['nama' => 'Permainan Tradisional (Egrang/Hadang)', 'icon' => 'sparkles', 'durasi' => 45],
    ];

    public function mount(): void
    {
        $this->syncWaktuSekarang();
        
        $user = auth()->user();
        if ($user) {
            $this->kecamatan_id = $user->kecamatan_id;
            $this->desa_kelurahan_id = $user->desa_kelurahan_id;
            if ($user->kecamatan && empty($this->nama_tempat)) {
                $this->nama_tempat = 'Area Wilayah Kec. ' . $user->kecamatan->nama_kecamatan;
            }
        }
    }

    public function syncWaktuSekarang(): void
    {
        $this->tanggal_aktivitas = now()->toDateString();
        $this->waktu_mulai = now()->format('H:i');
    }

    public function applyGeolocation(float $lat, float $lng, ?string $formattedAddress = null, ?string $kecamatanName = null, ?string $desaName = null): void
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
        $this->isDetectingLocation = false;

        // Auto-match Kecamatan jika ada nama kecamatan terdeteksi
        if ($kecamatanName) {
            $kecMatch = Kecamatan::where('nama_kecamatan', 'LIKE', '%' . trim(str_ireplace('Kecamatan', '', $kecamatanName)) . '%')->first();
            if ($kecMatch) {
                $this->kecamatan_id = $kecMatch->id;
                
                // Auto-match Desa jika ada
                if ($desaName) {
                    $desMatch = DesaKelurahan::where('kecamatan_id', $kecMatch->id)
                        ->where('nama_desa_kelurahan', 'LIKE', '%' . trim(str_ireplace(['Desa', 'Kelurahan'], '', $desaName)) . '%')
                        ->first();
                    if ($desMatch) {
                        $this->desa_kelurahan_id = $desMatch->id;
                    }
                }
            }
        }

        if ($formattedAddress) {
            $this->nama_tempat = $formattedAddress;
            $this->lokasi_terdeteksi_label = $formattedAddress;
        } else {
            $this->lokasi_terdeteksi_label = "Koordinat: {$lat}, {$lng}";
            if (empty($this->nama_tempat)) {
                $this->nama_tempat = "Lokasi GPS ({$lat}, {$lng})";
            }
        }
    }

    public function pilihPreset(string $nama, int $durasi): void
    {
        $this->nama_aktivitas = $nama;
        $this->durasi_menit = $durasi;
    }

    public function nextStep(): void
    {
        $this->validateCurrentStep();
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function setStep(int $step): void
    {
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
        } elseif ($step > $this->currentStep) {
            $this->validateCurrentStep();
            $this->currentStep = $step;
        }
    }

    public function validateCurrentStep(): void
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'nama_aktivitas' => 'required|min:3|max:150',
                'inorga_id' => 'nullable|exists:kormi_inorga,id',
                'tanggal_aktivitas' => 'required|date|before_or_equal:today',
                'durasi_menit' => 'required|integer|min:10|max:360',
            ], [
                'nama_aktivitas.required' => 'Nama aktivitas / olahraga wajib diisi.',
                'nama_aktivitas.min' => 'Nama aktivitas minimal 3 karakter.',
                'tanggal_aktivitas.required' => 'Tanggal aktivitas wajib diisi.',
                'tanggal_aktivitas.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.',
                'durasi_menit.required' => 'Durasi olahraga wajib diisi.',
                'durasi_menit.min' => 'Durasi minimal adalah 10 menit.',
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'kecamatan_id' => 'required|exists:ref_kecamatan,id',
                'desa_kelurahan_id' => 'nullable|exists:ref_desa_kelurahan,id',
                'nama_tempat' => 'required|min:3|max:200',
                'kategori_lokasi' => 'required|string',
            ], [
                'kecamatan_id.required' => 'Kecamatan lokasi olahraga wajib dipilih.',
                'nama_tempat.required' => 'Nama lokasi / tempat olahraga wajib diisi.',
            ]);
        }
    }

    protected function rules(): array
    {
        return [
            'nama_aktivitas' => 'required|min:3|max:150',
            'inorga_id' => 'nullable|exists:kormi_inorga,id',
            'tanggal_aktivitas' => 'required|date|before_or_equal:today',
            'durasi_menit' => 'required|integer|min:10|max:360',
            'kecamatan_id' => 'required|exists:ref_kecamatan,id',
            'desa_kelurahan_id' => 'nullable|exists:ref_desa_kelurahan,id',
            'nama_tempat' => 'required|min:3|max:200',
            'kategori_lokasi' => 'required|string',
            'foto_kegiatan' => 'nullable|image|max:10240', // Maks 10MB
            'catatan' => 'nullable|max:500',
        ];
    }

    protected $messages = [
        'nama_aktivitas.required' => 'Nama aktivitas / olahraga wajib diisi.',
        'tanggal_aktivitas.required' => 'Tanggal aktivitas wajib diisi.',
        'tanggal_aktivitas.before_or_equal' => 'Tanggal aktivitas tidak boleh melebihi hari ini.',
        'durasi_menit.required' => 'Durasi olahraga wajib diisi.',
        'durasi_menit.min' => 'Durasi minimal adalah 10 menit.',
        'kecamatan_id.required' => 'Kecamatan lokasi olahraga wajib dipilih.',
        'nama_tempat.required' => 'Nama lokasi / tempat olahraga wajib diisi.',
    ];

    public function updatedKecamatanId(): void
    {
        $this->desa_kelurahan_id = null;
    }

    public function setDurasi(int $menit): void
    {
        $this->durasi_menit = $menit;
    }

    public function simpan(): void
    {
        $this->validate();

        $pathFoto = null;
        if ($this->foto_kegiatan) {
            /** @var StorageService $storage */
            $storage = app(StorageService::class);
            $pathFoto = $storage->uploadGambar($this->foto_kegiatan, 'partisipasi/mandiri');
        }

        PartisipasiAktivitas::create([
            'pengguna_id' => auth()->id(),
            'metode_pencatatan' => 'mandiri',
            'inorga_id' => $this->inorga_id ?: null,
            'kecamatan_id' => $this->kecamatan_id,
            'desa_kelurahan_id' => $this->desa_kelurahan_id ?: null,
            'nama_aktivitas' => trim($this->nama_aktivitas),
            'tanggal_aktivitas' => $this->tanggal_aktivitas,
            'waktu_mulai' => $this->waktu_mulai ?: null,
            'durasi_menit' => $this->durasi_menit,
            'jenis_partisipasi' => 'individu',
            'jumlah_peserta' => 1,
            'kategori_lokasi' => $this->kategori_lokasi,
            'sapras_id' => $this->sapras_id ?: null,
            'nama_tempat' => trim($this->nama_tempat),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'foto_kegiatan' => $pathFoto,
            'catatan' => $this->catatan ?: null,
            'status_verifikasi' => 'valid',
        ]);

        $this->berhasilSimpan = true;
    }

    public function resetForm(): void
    {
        $this->reset(['nama_aktivitas', 'inorga_id', 'foto_kegiatan', 'catatan']);
        $this->durasi_menit = 30;
        $this->currentStep = 1;
        $this->tanggal_aktivitas = now()->toDateString();
        $this->waktu_mulai = now()->format('H:i');
        $this->berhasilSimpan = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        $daftarKecamatan = Kecamatan::orderBy('nama_kecamatan')->get();
        $daftarDesa = $this->kecamatan_id 
            ? DesaKelurahan::where('kecamatan_id', $this->kecamatan_id)->orderBy('nama_desa_kelurahan')->get() 
            : collect();
        $daftarInorga = Inorga::orderBy('nama_inorga')->get();
        $daftarSapras = Sapras::orderBy('nama_fasilitas')->get();

        return view('livewire.frontend.kormi.partisipasi.partisipasi-input', [
            'daftarKecamatan' => $daftarKecamatan,
            'daftarDesa' => $daftarDesa,
            'daftarInorga' => $daftarInorga,
            'daftarSapras' => $daftarSapras,
        ]);
    }
}
