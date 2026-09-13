<?php

namespace App\Livewire\Frontend\Kormi\Partisipasi;

use App\Models\Kormi\PartisipasiAktivitas;
use App\Models\Kormi\DutaOlahraga;
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
#[Title('Portal Duta Olahraga - Lapor Kegiatan Warga')]
class PartisipasiDutaInput extends Component
{
    use WithFileUploads;

    public ?string $duta_id = null;
    public string $nama_aktivitas = '';
    public ?string $inorga_id = null;
    public string $tanggal_aktivitas = '';
    public string $waktu_mulai = '';
    public int $durasi_menit = 45;
    public string $jenis_partisipasi = 'massal_komunitas'; // 'kelompok_kecil', 'massal_komunitas'
    public int $jumlah_peserta = 25;
    public string $kategori_lokasi = 'lapangan_desa';
    public ?string $kecamatan_id = null;
    public ?string $desa_kelurahan_id = null;
    public string $nama_tempat = '';
    public $foto_kegiatan = null;
    public $foto_daftar_hadir = null;
    public string $catatan = '';

    public bool $berhasilSimpan = false;

    public function mount(): void
    {
        $user = auth()->user();
        $this->tanggal_aktivitas = now()->toDateString();
        $this->waktu_mulai = now()->format('H:i');

        if ($user) {
            $this->duta_id = $user->duta_id;
            // If user has duta_id or linked duta
            if ($user->duta) {
                $this->kecamatan_id = $user->duta->kecamatan_id;
                $this->desa_kelurahan_id = $user->duta->desa_kelurahan_id;
            } else {
                $this->kecamatan_id = $user->kecamatan_id;
                $this->desa_kelurahan_id = $user->desa_kelurahan_id;
            }
        }
    }

    protected function rules(): array
    {
        return [
            'nama_aktivitas' => 'required|min:3|max:150',
            'inorga_id' => 'nullable|exists:kormi_inorga,id',
            'tanggal_aktivitas' => 'required|date|before_or_equal:today',
            'durasi_menit' => 'required|integer|min:15|max:360',
            'jumlah_peserta' => 'required|integer|min:2|max:5000',
            'kecamatan_id' => 'required|exists:ref_kecamatan,id',
            'desa_kelurahan_id' => 'nullable|exists:ref_desa_kelurahan,id',
            'nama_tempat' => 'required|min:3|max:200',
            'foto_kegiatan' => 'required|image|max:10240', // Wajib untuk Duta
            'foto_daftar_hadir' => 'nullable|image|max:10240',
            'catatan' => 'nullable|max:500',
        ];
    }

    protected $messages = [
        'nama_aktivitas.required' => 'Nama kegiatan senam / olahraga massal wajib diisi.',
        'jumlah_peserta.required' => 'Estimasi jumlah peserta wajib diisi.',
        'jumlah_peserta.min' => 'Jumlah peserta untuk laporan Duta minimal 2 orang.',
        'foto_kegiatan.required' => 'Foto dokumentasi kegiatan wajib dilampirkan oleh Duta Olahraga.',
        'nama_tempat.required' => 'Nama lapangan / lokasi kegiatan wajib diisi.',
    ];

    public function setPeserta(int $jumlah): void
    {
        $this->jumlah_peserta = $jumlah;
    }

    public function setPresetKegiatan(string $nama, ?string $inorgaSlug = null): void
    {
        $this->nama_aktivitas = $nama;
        if ($inorgaSlug) {
            $in = Inorga::where('slug', 'like', "%{$inorgaSlug}%")->first();
            if ($in) {
                $this->inorga_id = $in->id;
            }
        }
    }

    public function simpan(): void
    {
        $this->validate();

        /** @var StorageService $storage */
        $storage = app(StorageService::class);
        $pathKegiatan = $storage->uploadGambar($this->foto_kegiatan, 'partisipasi/duta/kegiatan');
        
        $pathAbsen = null;
        if ($this->foto_daftar_hadir) {
            $pathAbsen = $storage->uploadGambar($this->foto_daftar_hadir, 'partisipasi/duta/absensi');
        }

        PartisipasiAktivitas::create([
            'pengguna_id' => auth()->id(),
            'metode_pencatatan' => 'via_duta',
            'duta_id' => $this->duta_id ?: null,
            'inorga_id' => $this->inorga_id ?: null,
            'kecamatan_id' => $this->kecamatan_id,
            'desa_kelurahan_id' => $this->desa_kelurahan_id ?: null,
            'nama_aktivitas' => trim($this->nama_aktivitas),
            'tanggal_aktivitas' => $this->tanggal_aktivitas,
            'waktu_mulai' => $this->waktu_mulai ?: null,
            'durasi_menit' => $this->durasi_menit,
            'jenis_partisipasi' => $this->jenis_partisipasi,
            'jumlah_peserta' => $this->jumlah_peserta,
            'kategori_lokasi' => $this->kategori_lokasi,
            'nama_tempat' => trim($this->nama_tempat),
            'foto_kegiatan' => $pathKegiatan,
            'foto_daftar_hadir' => $pathAbsen,
            'catatan' => $this->catatan ?: null,
            'status_verifikasi' => 'valid',
        ]);

        $this->berhasilSimpan = true;
    }

    public function resetForm(): void
    {
        $this->reset(['nama_aktivitas', 'inorga_id', 'foto_kegiatan', 'foto_daftar_hadir', 'catatan']);
        $this->durasi_menit = 45;
        $this->jumlah_peserta = 25;
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

        return view('livewire.frontend.kormi.partisipasi.partisipasi-duta-input', [
            'daftarKecamatan' => $daftarKecamatan,
            'daftarDesa' => $daftarDesa,
            'daftarInorga' => $daftarInorga,
        ]);
    }
}
