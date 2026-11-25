<?php

namespace App\Livewire\Mobile;

use App\Models\Kormi\AngketApmo;
use App\Models\Master\DesaKelurahan;
use App\Models\Master\Kecamatan;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.mobile')]
#[Title('Angket APMO - KORMI Kabupaten Bandung')]
class Angket extends Component
{
    public const OPSI_PEKERJAAN = [
        'pelajar' => 'Pelajar/Mahasiswa',
        'pns_tni_polri_bumn' => 'PNS/TNI/POLRI/BUMN',
        'pegawai_swasta' => 'Pegawai Swasta',
        'wiraswasta' => 'Wiraswasta/Wirausaha',
        'petani_nelayan' => 'Petani/Nelayan',
        'lainnya' => 'Lainnya',
    ];

    public const OPSI_FREKUENSI = [
        '1' => '1 kali',
        '2' => '2 kali',
        '3' => '3 kali',
        'lebih' => 'Lebih dari 3 kali',
    ];

    public const OPSI_CABANG = [
        'sepakbola' => 'Sepakbola',
        'bola_voli' => 'Bola Voli',
        'bulutangkis' => 'Bulutangkis',
        'atletik' => 'Atletik',
        'senam_aerobik' => 'Senam Aerobik',
        'bersepeda' => 'Bersepeda',
        'basket' => 'Basket',
        'renang' => 'Renang',
        'beladiri' => 'Beladiri',
        'jalan' => 'Jalan',
        'lainnya' => 'Lainnya',
    ];

    public const OPSI_TUJUAN = [
        'kesehatan' => 'Menjaga Kesehatan',
        'turun_berat_badan' => 'Menurunkan Berat Badan',
        'pergaulan' => 'Menambah Pergaulan',
        'prestasi' => 'Berprestasi dalam Olahraga',
        'lainnya' => 'Lainnya',
    ];

    public const OPSI_JALUR = [
        '1' => '1 kali',
        '2' => '2 kali',
        '3' => '3 kali',
        'sendiri' => 'Sendiri',
        'lainnya' => 'Lainnya',
    ];

    public const OPSI_FASILITAS = [
        'memadai' => 'Memadai',
        'kurang' => 'Kurang',
        'sangat_kurang' => 'Sangat Kurang',
    ];

    public const OPSI_ALASAN = [
        'tidak_berminat' => 'Tidak Berminat',
        'tidak_ada_waktu' => 'Tidak Ada Waktu',
        'tidak_ada_sarana' => 'Tidak Ada Sarana/Prasarana',
        'lelah' => 'Lelah',
        'cukup_pekerjaan' => 'Sudah cukup melalui pekerjaan yang saya lakukan',
        'lainnya' => 'Lainnya',
    ];

    public int $langkah = 1;

    public bool $selesai = false;

    public string $namaTersimpan = '';
    public string $waktuTersimpan = '';

    // Bagian 1: identitas responden
    public string $nama_lengkap = '';
    public $usia = '';
    public string $jenis_kelamin = '';
    public $tinggi_badan = '';
    public $berat_badan = '';
    public string $alamat = '';
    public ?string $kecamatan_id = null;
    public ?string $desa_kelurahan_id = null;
    public string $kabupaten_kota = 'Kabupaten Bandung';
    public string $pekerjaan = '';
    public string $pekerjaan_lainnya = '';

    // Bagian 2: kebiasaan olahraga
    public string $melakukan_olahraga = '';

    // Bagian 3: jika berolahraga
    public string $frekuensi_berat = '';
    public $durasi_berat_jam = '';
    public $durasi_berat_menit = '';
    public bool $durasi_berat_tidak_tahu = false;
    public string $frekuensi_sedang = '';
    public $durasi_sedang_jam = '';
    public $durasi_sedang_menit = '';
    public bool $durasi_sedang_tidak_tahu = false;
    public string $frekuensi_jalan = '';
    public $durasi_jalan_jam = '';
    public $durasi_jalan_menit = '';
    public bool $durasi_jalan_tidak_tahu = false;
    public string $cabang_olahraga = '';
    public string $cabang_lainnya = '';
    public string $tujuan_olahraga = '';
    public string $tujuan_lainnya = '';
    public string $jalur_olahraga = '';
    public string $jalur_lainnya = '';
    public string $pernah_malas = '';
    public $duduk_jam = '';
    public $duduk_menit = '';
    public bool $duduk_tidak_tahu = false;
    public string $fasilitas_olahraga = '';

    // Bagian 4: jika tidak berolahraga
    public string $alasan_tidak_olahraga = '';
    public string $alasan_lainnya = '';

    protected $messages = [
        'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
        'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter.',
        'usia.required' => 'Usia wajib diisi.',
        'usia.integer' => 'Usia harus berupa angka bulat.',
        'usia.min' => 'Usia minimal 10 tahun.',
        'usia.max' => 'Usia maksimal 100 tahun.',
        'jenis_kelamin.required' => 'Pilih jenis kelamin.',
        'tinggi_badan.integer' => 'Tinggi badan harus berupa angka bulat.',
        'tinggi_badan.min' => 'Tinggi badan minimal 80 cm.',
        'tinggi_badan.max' => 'Tinggi badan maksimal 250 cm.',
        'berat_badan.integer' => 'Berat badan harus berupa angka bulat.',
        'berat_badan.min' => 'Berat badan minimal 20 kg.',
        'berat_badan.max' => 'Berat badan maksimal 300 kg.',
        'alamat.required' => 'Alamat lengkap wajib diisi.',
        'alamat.min' => 'Alamat minimal 5 karakter.',
        'alamat.max' => 'Alamat maksimal 500 karakter.',
        'kecamatan_id.required' => 'Pilih kecamatan.',
        'desa_kelurahan_id.required' => 'Pilih desa/kelurahan.',
        'desa_kelurahan_id.exists' => 'Desa/kelurahan tidak sesuai dengan kecamatan yang dipilih.',
        'kabupaten_kota.required' => 'Kabupaten/kota wajib diisi.',
        'pekerjaan.required' => 'Pilih pekerjaan sekarang.',
        'pekerjaan_lainnya.required_if' => 'Sebutkan pekerjaan Anda.',
        'pekerjaan_lainnya.max' => 'Sebutan pekerjaan maksimal 100 karakter.',
        'melakukan_olahraga.required' => 'Pilih jawaban terlebih dahulu.',
        'frekuensi_berat.required' => 'Pilih frekuensi olahraga berat.',
        'frekuensi_sedang.required' => 'Pilih frekuensi olahraga sedang.',
        'frekuensi_jalan.required' => 'Pilih frekuensi jalan kaki.',
        'durasi_berat_jam.required' => 'Isi durasi olahraga berat (jam dan menit).',
        'durasi_berat_jam.integer' => 'Jam olahraga berat harus berupa angka bulat.',
        'durasi_berat_jam.min' => 'Jam olahraga berat tidak boleh negatif.',
        'durasi_berat_jam.max' => 'Jam olahraga berat maksimal 23.',
        'durasi_berat_menit.required' => 'Isi durasi olahraga berat (jam dan menit).',
        'durasi_berat_menit.integer' => 'Menit olahraga berat harus berupa angka bulat.',
        'durasi_berat_menit.min' => 'Menit olahraga berat tidak boleh negatif.',
        'durasi_berat_menit.max' => 'Menit olahraga berat maksimal 59.',
        'durasi_sedang_jam.required' => 'Isi durasi olahraga sedang (jam dan menit).',
        'durasi_sedang_jam.integer' => 'Jam olahraga sedang harus berupa angka bulat.',
        'durasi_sedang_jam.min' => 'Jam olahraga sedang tidak boleh negatif.',
        'durasi_sedang_jam.max' => 'Jam olahraga sedang maksimal 23.',
        'durasi_sedang_menit.required' => 'Isi durasi olahraga sedang (jam dan menit).',
        'durasi_sedang_menit.integer' => 'Menit olahraga sedang harus berupa angka bulat.',
        'durasi_sedang_menit.min' => 'Menit olahraga sedang tidak boleh negatif.',
        'durasi_sedang_menit.max' => 'Menit olahraga sedang maksimal 59.',
        'durasi_jalan_jam.required' => 'Isi durasi jalan kaki (jam dan menit).',
        'durasi_jalan_jam.integer' => 'Jam jalan kaki harus berupa angka bulat.',
        'durasi_jalan_jam.min' => 'Jam jalan kaki tidak boleh negatif.',
        'durasi_jalan_jam.max' => 'Jam jalan kaki maksimal 23.',
        'durasi_jalan_menit.required' => 'Isi durasi jalan kaki (jam dan menit).',
        'durasi_jalan_menit.integer' => 'Menit jalan kaki harus berupa angka bulat.',
        'durasi_jalan_menit.min' => 'Menit jalan kaki tidak boleh negatif.',
        'durasi_jalan_menit.max' => 'Menit jalan kaki maksimal 59.',
        'pernah_malas.required' => 'Pilih jawaban terlebih dahulu.',
        'cabang_olahraga.required' => 'Pilih cabang olahraga.',
        'cabang_lainnya.required_if' => 'Sebutkan cabang olahraga Anda.',
        'cabang_lainnya.max' => 'Sebutan cabang olahraga maksimal 100 karakter.',
        'tujuan_olahraga.required' => 'Pilih tujuan utama berolahraga.',
        'tujuan_lainnya.required_if' => 'Sebutkan tujuan Anda.',
        'tujuan_lainnya.max' => 'Sebutan tujuan maksimal 100 karakter.',
        'jalur_olahraga.required' => 'Pilih jalur melakukan olahraga.',
        'jalur_lainnya.required_if' => 'Sebutkan jalur olahraga Anda.',
        'jalur_lainnya.max' => 'Sebutan jalur maksimal 100 karakter.',
        'duduk_jam.required' => 'Isi lama duduk dalam sehari (jam dan menit).',
        'duduk_jam.integer' => 'Jam lama duduk harus berupa angka bulat.',
        'duduk_jam.min' => 'Jam lama duduk tidak boleh negatif.',
        'duduk_jam.max' => 'Jam lama duduk maksimal 23.',
        'duduk_menit.required' => 'Isi lama duduk dalam sehari (jam dan menit).',
        'duduk_menit.integer' => 'Menit lama duduk harus berupa angka bulat.',
        'duduk_menit.min' => 'Menit lama duduk tidak boleh negatif.',
        'duduk_menit.max' => 'Menit lama duduk maksimal 59.',
        'fasilitas_olahraga.required' => 'Pilih penilaian fasilitas olahraga.',
        'alasan_tidak_olahraga.required' => 'Pilih alasan tidak berolahraga.',
        'alasan_lainnya.required_if' => 'Sebutkan alasan Anda.',
        'alasan_lainnya.max' => 'Sebutan alasan maksimal 100 karakter.',
    ];

    public function mount(): void
    {
        $user = auth()->user();

        if ($user) {
            $this->nama_lengkap = $user->nama_lengkap;
            $this->jenis_kelamin = match ($user->jenis_kelamin) {
                'L' => 'pria',
                'P' => 'wanita',
                default => '',
            };
            $this->kecamatan_id = $user->kecamatan_id ?: null;
            $this->desa_kelurahan_id = $user->desa_kelurahan_id ?: null;
        }
    }

    public function lanjut(): void
    {
        $this->resetValidation();

        $this->validate(match ($this->langkah) {
            1 => $this->aturanIdentitas(),
            default => $this->aturanOlahraga(),
        });

        $this->langkah = min(3, $this->langkah + 1);
    }

    public function kembali(): void
    {
        $this->resetValidation();
        $this->langkah = max(1, $this->langkah - 1);
    }

    public function updatedMelakukanOlahraga(): void
    {
        $this->resetValidation();
    }

    public function updatedKecamatanId(): void
    {
        $this->desa_kelurahan_id = null;
        $this->resetValidation();
    }

    public function updatedPekerjaan(): void
    {
        if ($this->pekerjaan !== 'lainnya') {
            $this->pekerjaan_lainnya = '';
        }
    }

    public function updatedCabangOlahraga(): void
    {
        if ($this->cabang_olahraga !== 'lainnya') {
            $this->cabang_lainnya = '';
        }
    }

    public function updatedTujuanOlahraga(): void
    {
        if ($this->tujuan_olahraga !== 'lainnya') {
            $this->tujuan_lainnya = '';
        }
    }

    public function updatedJalurOlahraga(): void
    {
        if ($this->jalur_olahraga !== 'lainnya') {
            $this->jalur_lainnya = '';
        }
    }

    public function updatedAlasanTidakOlahraga(): void
    {
        if ($this->alasan_tidak_olahraga !== 'lainnya') {
            $this->alasan_lainnya = '';
        }
    }

    public function kirim(): void
    {
        $this->resetValidation();

        $this->validate($this->aturanDetail());

        if ($this->melakukan_olahraga === 'ya') {
            $this->periksaDurasiOlahraga();

            if ($this->getErrorBag()->isNotEmpty()) {
                return;
            }
        }

        AngketApmo::create($this->dataSimpan());

        $this->namaTersimpan = trim(strip_tags($this->nama_lengkap));
        $this->waktuTersimpan = now('Asia/Jakarta')->locale('id')->translatedFormat('d M Y H:i');
        $this->selesai = true;
        $this->langkah = 1;
    }

    public function isiLagi(): void
    {
        $this->reset();
        $this->mount();
    }

    private function aturanIdentitas(): array
    {
        return [
            'nama_lengkap' => 'required|min:3|max:100',
            'usia' => 'required|integer|min:10|max:100',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'tinggi_badan' => 'nullable|integer|min:80|max:250',
            'berat_badan' => 'nullable|integer|min:20|max:300',
            'alamat' => 'required|min:5|max:500',
            'kecamatan_id' => 'required|exists:ref_kecamatan,id',
            'desa_kelurahan_id' => [
                'required',
                Rule::exists('ref_desa_kelurahan', 'id')->where(
                    fn ($query) => $query->where('kecamatan_id', $this->kecamatan_id)
                ),
            ],
            'kabupaten_kota' => 'required|max:100',
            'pekerjaan' => 'required|in:' . implode(',', array_keys(self::OPSI_PEKERJAAN)),
            'pekerjaan_lainnya' => 'nullable|required_if:pekerjaan,lainnya|max:100',
        ];
    }

    private function aturanOlahraga(): array
    {
        return [
            'melakukan_olahraga' => 'required|in:ya,tidak',
        ];
    }

    private function aturanDetail(): array
    {
        if ($this->melakukan_olahraga !== 'ya') {
            return [
                'alasan_tidak_olahraga' => 'required|in:' . implode(',', array_keys(self::OPSI_ALASAN)),
                'alasan_lainnya' => 'nullable|required_if:alasan_tidak_olahraga,lainnya|max:100',
                'fasilitas_olahraga' => 'required|in:' . implode(',', array_keys(self::OPSI_FASILITAS)),
            ];
        }

        $aturan = [
            'frekuensi_berat' => 'required|in:' . implode(',', array_keys(self::OPSI_FREKUENSI)),
            'frekuensi_sedang' => 'required|in:' . implode(',', array_keys(self::OPSI_FREKUENSI)),
            'frekuensi_jalan' => 'required|in:' . implode(',', array_keys(self::OPSI_FREKUENSI)),
            'cabang_olahraga' => 'required|in:' . implode(',', array_keys(self::OPSI_CABANG)),
            'cabang_lainnya' => 'nullable|required_if:cabang_olahraga,lainnya|max:100',
            'tujuan_olahraga' => 'required|in:' . implode(',', array_keys(self::OPSI_TUJUAN)),
            'tujuan_lainnya' => 'nullable|required_if:tujuan_olahraga,lainnya|max:100',
            'jalur_olahraga' => 'required|in:' . implode(',', array_keys(self::OPSI_JALUR)),
            'jalur_lainnya' => 'nullable|required_if:jalur_olahraga,lainnya|max:100',
            'pernah_malas' => 'required|in:pernah,tidak_pernah',
            'fasilitas_olahraga' => 'required|in:' . implode(',', array_keys(self::OPSI_FASILITAS)),
        ];

        foreach (['berat', 'sedang', 'jalan'] as $jenis) {
            $aturan["durasi_{$jenis}_jam"] = $this->{"durasi_{$jenis}_tidak_tahu"} ? 'nullable' : 'required|integer|min:0|max:23';
            $aturan["durasi_{$jenis}_menit"] = $this->{"durasi_{$jenis}_tidak_tahu"} ? 'nullable' : 'required|integer|min:0|max:59';
        }

        if ($this->pernah_malas === 'pernah') {
            $aturan['duduk_jam'] = $this->duduk_tidak_tahu ? 'nullable' : 'required|integer|min:0|max:23';
            $aturan['duduk_menit'] = $this->duduk_tidak_tahu ? 'nullable' : 'required|integer|min:0|max:59';
        }

        return $aturan;
    }

    private function periksaDurasiOlahraga(): void
    {
        foreach (['berat' => 'olahraga berat', 'sedang' => 'olahraga sedang', 'jalan' => 'jalan kaki'] as $jenis => $label) {
            if ($this->{"durasi_{$jenis}_tidak_tahu"}) {
                continue;
            }

            $total = (int) $this->{"durasi_{$jenis}_jam"} * 60 + (int) $this->{"durasi_{$jenis}_menit"};

            if ($total <= 0) {
                $this->addError("durasi_{$jenis}_jam", 'Isi durasi ' . $label . ' lebih dari 0 menit.');
            }
        }

        if ($this->pernah_malas === 'pernah' && ! $this->duduk_tidak_tahu
            && ((int) $this->duduk_jam * 60 + (int) $this->duduk_menit) <= 0) {
            $this->addError('duduk_jam', 'Isi lama duduk lebih dari 0 menit.');
        }
    }

    private function dataSimpan(): array
    {
        $ya = $this->melakukan_olahraga === 'ya';
        $dudukDiisi = $ya && $this->pernah_malas === 'pernah' && ! $this->duduk_tidak_tahu;

        return [
            'pengguna_id' => auth()->id(),
            'nama_lengkap' => trim(strip_tags($this->nama_lengkap)),
            'usia' => (int) $this->usia,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tinggi_badan' => $this->angka($this->tinggi_badan),
            'berat_badan' => $this->angka($this->berat_badan),
            'alamat' => trim(strip_tags($this->alamat)),
            'kecamatan' => Kecamatan::find($this->kecamatan_id)?->nama_kecamatan ?? '',
            'desa' => DesaKelurahan::find($this->desa_kelurahan_id)?->nama_desa_kelurahan ?? '',
            'kabupaten_kota' => 'Kabupaten Bandung',
            'pekerjaan' => $this->pekerjaan,
            'pekerjaan_lainnya' => $this->pekerjaan === 'lainnya' ? trim(strip_tags($this->pekerjaan_lainnya)) : null,
            'melakukan_olahraga' => $ya,
            'frekuensi_berat' => $ya ? $this->frekuensi_berat : null,
            'durasi_berat_jam' => $ya && ! $this->durasi_berat_tidak_tahu ? $this->angka($this->durasi_berat_jam) : null,
            'durasi_berat_menit' => $ya && ! $this->durasi_berat_tidak_tahu ? $this->angka($this->durasi_berat_menit) : null,
            'durasi_berat_tidak_tahu' => $ya && $this->durasi_berat_tidak_tahu,
            'frekuensi_sedang' => $ya ? $this->frekuensi_sedang : null,
            'durasi_sedang_jam' => $ya && ! $this->durasi_sedang_tidak_tahu ? $this->angka($this->durasi_sedang_jam) : null,
            'durasi_sedang_menit' => $ya && ! $this->durasi_sedang_tidak_tahu ? $this->angka($this->durasi_sedang_menit) : null,
            'durasi_sedang_tidak_tahu' => $ya && $this->durasi_sedang_tidak_tahu,
            'frekuensi_jalan' => $ya ? $this->frekuensi_jalan : null,
            'durasi_jalan_jam' => $ya && ! $this->durasi_jalan_tidak_tahu ? $this->angka($this->durasi_jalan_jam) : null,
            'durasi_jalan_menit' => $ya && ! $this->durasi_jalan_tidak_tahu ? $this->angka($this->durasi_jalan_menit) : null,
            'durasi_jalan_tidak_tahu' => $ya && $this->durasi_jalan_tidak_tahu,
            'cabang_olahraga' => $ya ? $this->cabang_olahraga : null,
            'cabang_lainnya' => $ya && $this->cabang_olahraga === 'lainnya' ? trim(strip_tags($this->cabang_lainnya)) : null,
            'tujuan_olahraga' => $ya ? $this->tujuan_olahraga : null,
            'tujuan_lainnya' => $ya && $this->tujuan_olahraga === 'lainnya' ? trim(strip_tags($this->tujuan_lainnya)) : null,
            'jalur_olahraga' => $ya ? $this->jalur_olahraga : null,
            'jalur_lainnya' => $ya && $this->jalur_olahraga === 'lainnya' ? trim(strip_tags($this->jalur_lainnya)) : null,
            'pernah_malas' => $ya ? $this->pernah_malas : null,
            'duduk_jam' => $dudukDiisi ? $this->angka($this->duduk_jam) : null,
            'duduk_menit' => $dudukDiisi ? $this->angka($this->duduk_menit) : null,
            'duduk_tidak_tahu' => $ya && $this->pernah_malas === 'pernah' && $this->duduk_tidak_tahu,
            'alasan_tidak_olahraga' => $ya ? null : $this->alasan_tidak_olahraga,
            'alasan_lainnya' => ! $ya && $this->alasan_tidak_olahraga === 'lainnya' ? trim(strip_tags($this->alasan_lainnya)) : null,
            'fasilitas_olahraga' => $this->fasilitas_olahraga,
        ];
    }

    private function angka($nilai): ?int
    {
        return is_numeric($nilai) ? (int) $nilai : null;
    }

    public function render()
    {
        $pengisianTerakhir = auth()->check()
            ? AngketApmo::where('pengguna_id', auth()->id())->latest('dibuat_pada')->first()
            : null;

        $daftarDesa = $this->kecamatan_id
            ? DesaKelurahan::where('kecamatan_id', $this->kecamatan_id)->orderBy('nama_desa_kelurahan')->get()
            : collect();

        return view('livewire.mobile.angket', [
            'pengisianTerakhir' => $pengisianTerakhir,
            'daftarKecamatan' => Kecamatan::orderBy('nama_kecamatan')->get(),
            'daftarDesa' => $daftarDesa,
            'opsiPekerjaan' => self::OPSI_PEKERJAAN,
            'opsiFrekuensi' => self::OPSI_FREKUENSI,
            'opsiCabang' => self::OPSI_CABANG,
            'opsiTujuan' => self::OPSI_TUJUAN,
            'opsiJalur' => self::OPSI_JALUR,
            'opsiFasilitas' => self::OPSI_FASILITAS,
            'opsiAlasan' => self::OPSI_ALASAN,
        ]);
    }
}
