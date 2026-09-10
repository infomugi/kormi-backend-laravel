<?php

namespace App\Livewire\Admin\Organisasi;

use App\Models\KordikPengurus;
use App\Models\Kecamatan;
use App\Models\PeriodeKepengurusan;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Koordinator Kecamatan - KORMI CMS')]
class KordikKelola extends Component
{
    use WithPagination, WithFileUploads;

    public string $mode = 'tabel';
    public string $cari = '';
    public string $filterPeriode = '';
    public string $filterKecamatan = 'semua';
    public string $statusFilter = 'Semua';

    // Sorting & Pagination
    public string $sortField = 'dibuat_pada';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'

    // Bulk selection
    public array $selectedKordik = [];
    public bool $pilihSemua = false;

    // Form fields
    public ?string $editId = null;
    public string $kecamatan_id = '';
    public string $periode_id = '';
    public string $nama_ketua = '';
    public string $nama_sekretaris = '';
    public string $nama_bendahara = '';
    public string $nomor_telepon = '';
    public string $nomor_sk = '';
    public string $foto_ketua_url = '';
    public $uploadFoto = null;
    public bool $status_aktif = true;

    protected function rules(): array
    {
        return [
            'kecamatan_id' => 'required|exists:kormi_kecamatan,id',
            'periode_id' => 'required|exists:kormi_periode_kepengurusan,id',
            'nama_ketua' => 'required|string|min:2|max:150',
            'nama_sekretaris' => 'nullable|string|max:150',
            'nama_bendahara' => 'nullable|string|max:150',
            'nomor_telepon' => 'nullable|string|max:25',
            'nomor_sk' => 'nullable|string|max:100',
            'status_aktif' => 'boolean',
            'uploadFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ];
    }

    public function mount(): void
    {
        $periodeAktif = PeriodeKepengurusan::aktif()->first() ?? PeriodeKepengurusan::orderByDesc('tahun_mulai')->first();
        if ($periodeAktif) {
            $this->periode_id = $periodeAktif->id;
            $this->filterPeriode = $periodeAktif->id;
        }
        $firstKec = Kecamatan::first();
        if ($firstKec) {
            $this->kecamatan_id = $firstKec->id;
        }
    }

    public function updatedCari(): void { $this->resetPage(); }
    public function updatedFilterPeriode(): void { $this->resetPage(); }
    public function updatedFilterKecamatan(): void { $this->resetPage(); }
    public function updatedStatusFilter(): void { $this->resetPage(); }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->resetInput();
    }

    public function bukaFormTambah(): void
    {
        $this->resetInput();
        $periodeAktif = PeriodeKepengurusan::aktif()->first() ?? PeriodeKepengurusan::orderByDesc('tahun_mulai')->first();
        if ($periodeAktif) $this->periode_id = $periodeAktif->id;
        $firstKec = Kecamatan::first();
        if ($firstKec) $this->kecamatan_id = $firstKec->id;
        $this->mode = 'form';
        $this->resetErrorBag();
    }

    public function bukaFormEdit(string $id): void
    {
        $item = KordikPengurus::findOrFail($id);
        $this->editId = $item->id;
        $this->kecamatan_id = $item->kecamatan_id;
        $this->periode_id = $item->periode_id;
        $this->nama_ketua = $item->nama_ketua;
        $this->nama_sekretaris = $item->nama_sekretaris ?? '';
        $this->nama_bendahara = $item->nama_bendahara ?? '';
        $this->nomor_telepon = $item->nomor_telepon ?? '';
        $this->nomor_sk = $item->nomor_sk ?? '';
        $this->foto_ketua_url = $item->foto_ketua_url ?? '';
        $this->status_aktif = (bool) $item->status_aktif;
        $this->uploadFoto = null;
        $this->mode = 'form';
        $this->resetErrorBag();
    }

    public function simpan(): void
    {
        $this->validate();

        $storage = app(StorageService::class);
        $pathFoto = $this->foto_ketua_url;
        if ($this->uploadFoto) {
            if ($this->editId && !empty($this->foto_ketua_url)) {
                $storage->hapusFile($this->foto_ketua_url);
            }
            $pathFoto = $storage->uploadGambar($this->uploadFoto, 'kordik');
        }

        $data = [
            'kecamatan_id' => $this->kecamatan_id,
            'periode_id' => $this->periode_id,
            'nama_ketua' => trim($this->nama_ketua),
            'nama_sekretaris' => $this->nama_sekretaris ? trim($this->nama_sekretaris) : null,
            'nama_bendahara' => $this->nama_bendahara ? trim($this->nama_bendahara) : null,
            'nomor_telepon' => $this->nomor_telepon ? trim($this->nomor_telepon) : null,
            'nomor_sk' => $this->nomor_sk ? trim($this->nomor_sk) : null,
            'foto_ketua_url' => $pathFoto,
            'status_aktif' => $this->status_aktif,
        ];

        if ($this->editId) {
            KordikPengurus::findOrFail($this->editId)->update($data);
            session()->flash('pesan', 'Data koordinator kecamatan ' . ($item->kecamatan->nama_kecamatan ?? '') . ' berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            KordikPengurus::create($data);
            session()->flash('pesan', 'Koordinator kecamatan baru berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        $item = KordikPengurus::findOrFail($id);
        if ($item->foto_ketua_url) {
            app(StorageService::class)->hapusFile($item->foto_ketua_url);
        }
        $nama = $item->nama_ketua;
        $item->delete();
        session()->flash('pesan', 'Data koordinator kecamatan (' . $nama . ') berhasil dihapus.');
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function updatedPilihSemua(bool $value): void
    {
        if ($value) {
            $query = KordikPengurus::query()
                ->when($this->filterPeriode, fn($q) => $q->where('periode_id', $this->filterPeriode));
            $this->selectedKordik = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedKordik = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedKordik = [];
        $this->pilihSemua = false;
    }

    public function setFilterPeriode(string $periodeId): void
    {
        $this->filterPeriode = $periodeId;
        $this->resetPage();
    }

    public function setFilterStatus(string $status): void
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->filterKecamatan = 'semua';
        $this->statusFilter = 'Semua';
        $this->resetPage();
    }

    public function toggleStatus(string $id): void
    {
        $item = KordikPengurus::findOrFail($id);
        $item->status_aktif = !$item->status_aktif;
        $item->save();
        session()->flash('pesan', 'Status keaktifan Kordik Kecamatan ' . ($item->kecamatan?->nama_kecamatan ?? '') . ' berhasil diperbarui!');
    }

    public function bulkSetStatus(bool $status): void
    {
        if (empty($this->selectedKordik)) return;
        KordikPengurus::whereIn('id', $this->selectedKordik)->update(['status_aktif' => $status]);
        $text = $status ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('pesan', count($this->selectedKordik) . ' data koordinator kecamatan berhasil ' . $text . '.');
        $this->resetSelection();
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedKordik)) return;
        $items = KordikPengurus::whereIn('id', $this->selectedKordik)->get();
        $storage = app(StorageService::class);
        foreach ($items as $item) {
            if ($item->foto_ketua_url) {
                $storage->hapusFile($item->foto_ketua_url);
            }
            $item->delete();
        }
        session()->flash('pesan', count($this->selectedKordik) . ' data koordinator kecamatan berhasil dihapus.');
        $this->resetSelection();
    }

    public function resetInput(): void
    {
        $this->editId = null;
        $this->nama_ketua = '';
        $this->nama_sekretaris = '';
        $this->nama_bendahara = '';
        $this->nomor_telepon = '';
        $this->nomor_sk = '';
        $this->foto_ketua_url = '';
        $this->uploadFoto = null;
        $this->status_aktif = true;
    }

    public function render()
    {
        $periodeList = PeriodeKepengurusan::orderByDesc('tahun_mulai')->get();
        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();
        $totalKecamatan = Kecamatan::count();

        $query = KordikPengurus::with(['kecamatan', 'periode'])
            ->when($this->filterPeriode, fn($q) => $q->where('periode_id', $this->filterPeriode))
            ->when($this->filterKecamatan !== 'semua', fn($q) => $q->where('kecamatan_id', $this->filterKecamatan))
            ->when($this->statusFilter !== 'Semua', function ($q) {
                if ($this->statusFilter === 'Aktif') {
                    $q->where('status_aktif', true);
                } elseif ($this->statusFilter === 'Non-Aktif') {
                    $q->where('status_aktif', false);
                }
            })
            ->when($this->cari, fn($q) => $q->where(function($sub) {
                $sub->where('nama_ketua', 'like', "%{$this->cari}%")
                    ->orWhere('nama_sekretaris', 'like', "%{$this->cari}%")
                    ->orWhere('nama_bendahara', 'like', "%{$this->cari}%")
                    ->orWhere('nomor_sk', 'like', "%{$this->cari}%")
                    ->orWhereHas('kecamatan', fn($k) => $k->where('nama_kecamatan', 'like', "%{$this->cari}%"));
            }));

        if (in_array($this->sortField, ['nama_ketua', 'status_aktif', 'dibuat_pada', 'created_at'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->orderBy('dibuat_pada', 'desc');
        }

        $baseCountQuery = KordikPengurus::query()
            ->when($this->filterPeriode, fn($q) => $q->where('periode_id', $this->filterPeriode));

        return view('livewire.admin.organisasi.kordik-kelola', [
            'periodeList' => $periodeList,
            'kecamatanList' => $kecamatanList,
            'kordikList' => $query->paginate($this->perPage),
            'totalKordik' => KordikPengurus::count(),
            'totalKordikPeriode' => (clone $baseCountQuery)->count(),
            'totalAktif' => (clone $baseCountQuery)->where('status_aktif', true)->count(),
            'totalNonAktif' => (clone $baseCountQuery)->where('status_aktif', false)->count(),
            'totalKecamatanTerisi' => (clone $baseCountQuery)->distinct('kecamatan_id')->count('kecamatan_id'),
            'totalKecamatan' => $totalKecamatan,
            'namaPeriodeAktif' => PeriodeKepengurusan::find($this->filterPeriode)?->nama_periode ?? 'Semua Periode',
        ]);
    }
}
