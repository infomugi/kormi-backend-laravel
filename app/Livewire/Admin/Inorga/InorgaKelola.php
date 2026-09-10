<?php

namespace App\Livewire\Admin\Inorga;

use App\Models\KomisiInorga;
use App\Models\Inorga;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Induk Organisasi (INORGA) - KORMI CMS')]
class InorgaKelola extends Component
{
    use WithPagination;

    public string $mode = 'tabel'; // 'tabel' atau 'form'
    public string $cari = '';
    public string $komisiDipilih = 'Semua';

    // Backward compatibility for automated tests
    public bool $tampilkanModal = false;

    // Form fields
    public ?string $inorgaId = null;
    public string $komisi_id = '';
    public string $singkatan = '';
    public string $nama_inorga = '';
    public string $deskripsi_singkat = '';
    public string $nama_ketua = '';
    public string $kontak_person = '';
    public string $logo_url = '';
    public string $status_keanggotaan = 'aktif';
    public int $jumlah_klub_anggota = 5;

    protected function rules(): array
    {
        return [
            'komisi_id' => 'required|exists:kormi_komisi_inorga,id',
            'singkatan' => 'required|max:50',
            'nama_inorga' => 'required|max:150',
            'status_keanggotaan' => 'required|in:aktif,masa_tenggang,tidak_aktif,verifikasi',
            'jumlah_klub_anggota' => 'required|integer|min:0',
        ];
    }

    public function mount(): void
    {
        $firstKomisi = KomisiInorga::first();
        if ($firstKomisi) {
            $this->komisi_id = $firstKomisi->id;
        }
    }

    public function updatedCari(): void
    {
        $this->resetPage();
    }

    public function updatedKomisiDipilih(): void
    {
        $this->resetPage();
    }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->tampilkanModal = false;
        $this->resetForm();
    }

    public function bukaFormTambah(): void
    {
        $this->resetForm();
        $firstKomisi = KomisiInorga::first();
        if ($firstKomisi) {
            $this->komisi_id = $firstKomisi->id;
        }
        $this->mode = 'form';
        $this->tampilkanModal = true;
    }

    public function bukaModalTambah(): void
    {
        $this->bukaFormTambah();
    }

    public function bukaFormEdit(string $id): void
    {
        $i = Inorga::findOrFail($id);
        $this->inorgaId = $i->id;
        $this->komisi_id = $i->komisi_id;
        $this->singkatan = $i->singkatan;
        $this->nama_inorga = $i->nama_inorga;
        $this->deskripsi_singkat = $i->deskripsi ?? '';
        $this->nama_ketua = $i->nama_ketua ?? '';
        $this->kontak_person = $i->kontak_person ?? '';
        $this->logo_url = $i->logo_url ?? '';
        $this->status_keanggotaan = $i->status_keanggotaan;
        $this->jumlah_klub_anggota = (int) $i->jumlah_klub_anggota;
        $this->mode = 'form';
        $this->tampilkanModal = true;
    }

    public function bukaModalEdit(string $id): void
    {
        $this->bukaFormEdit($id);
    }

    public function simpan(): void
    {
        $this->validate();

        $data = [
            'komisi_id' => $this->komisi_id,
            'singkatan' => strtoupper(trim($this->singkatan)),
            'nama_inorga' => trim($this->nama_inorga),
            'slug' => Str::slug($this->singkatan . '-' . $this->nama_inorga),
            'nama_ketua' => $this->nama_ketua ?: null,
            'kontak_person' => $this->kontak_person ?: null,
            'logo_url' => $this->logo_url ?: null,
            'status_keanggotaan' => $this->status_keanggotaan,
            'jumlah_klub_anggota' => $this->jumlah_klub_anggota,
            'deskripsi_kegiatan' => $this->deskripsi_singkat ?: null,
        ];

        if ($this->inorgaId) {
            Inorga::findOrFail($this->inorgaId)->update($data);
            session()->flash('pesan', 'Data Inorga ' . $this->singkatan . ' berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            Inorga::create($data);
            session()->flash('pesan', 'Inorga baru ' . $this->singkatan . ' berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $i = Inorga::findOrFail($id);
        $nama = $i->singkatan ?: $i->nama_inorga;
        $i->delete();
        session()->flash('pesan', 'Inorga "' . $nama . '" berhasil dihapus.');
    }

    public function resetForm(): void
    {
        $this->inorgaId = null;
        $this->singkatan = '';
        $this->nama_inorga = '';
        $this->deskripsi_singkat = '';
        $this->nama_ketua = '';
        $this->kontak_person = '';
        $this->logo_url = '';
        $this->status_keanggotaan = 'aktif';
        $this->jumlah_klub_anggota = 5;
    }

    public function render()
    {
        $komisiList = KomisiInorga::withCount('inorga')->orderBy('singkatan')->get();

        $query = Inorga::with('komisi')
            ->when($this->komisiDipilih !== 'Semua', fn($q) => $q->where('komisi_id', $this->komisiDipilih))
            ->when($this->cari, fn($q) => $q->where(function ($sub) {
                $sub->where('singkatan', 'like', '%' . $this->cari . '%')
                    ->orWhere('nama_inorga', 'like', '%' . $this->cari . '%');
            }))
            ->orderBy('singkatan');

        $totalInorga = Inorga::count();
        $totalAktif = Inorga::where('status_keanggotaan', 'aktif')->count();
        $totalKlub = Inorga::sum('jumlah_klub_anggota');

        return view('livewire.admin.inorga.inorga-kelola', [
            'komisiList' => $komisiList,
            'inorgaList' => $query->paginate(12),
            'totalInorga' => $totalInorga,
            'totalAktif' => $totalAktif,
            'totalKlub' => $totalKlub,
        ]);
    }
}
