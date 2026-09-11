<?php

namespace App\Livewire\Admin\Pengguna;

use App\Models\Peran;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Kelola Peran & Hak Akses - KORMI CMS')]
class PeranKelola extends Component
{
    public string $mode = 'tabel'; // 'tabel' atau 'form'
    public string $cari = '';

    // Form state
    public bool $tampilkanModal = false;
    public ?string $peranId = null;
    public string $nama_peran = '';
    public string $slug = '';
    public string $deskripsi = '';
    public array $hak_akses = [];

    // Delete confirmation modal
    public bool $tampilkanModalHapus = false;
    public ?string $hapusPeranId = null;
    public string $hapusPeranNama = '';

    protected function rules(): array
    {
        return [
            'nama_peran' => 'required|string|max:50|min:3',
            'slug' => 'required|string|max:50|regex:/^[a-z0-9\-]+$/|unique:kormi_peran,slug,' . ($this->peranId ?? 'NULL') . ',id',
            'deskripsi' => 'nullable|string|max:255',
            'hak_akses' => 'array',
        ];
    }

    protected $messages = [
        'nama_peran.required' => 'Nama peran wajib diisi.',
        'nama_peran.min' => 'Nama peran minimal 3 karakter.',
        'nama_peran.max' => 'Nama peran maksimal 50 karakter.',
        'slug.required' => 'Slug identifikasi peran wajib diisi.',
        'slug.regex' => 'Format slug hanya boleh berupa huruf kecil, angka, dan tanda hubung (-).',
        'slug.unique' => 'Slug peran sudah digunakan.',
        'deskripsi.max' => 'Deskripsi maksimal 255 karakter.',
    ];

    public function mount()
    {
        $user = auth()->user();
        if (!$user || !$user->isSuperAdmin()) {
            abort(403, 'Akses khusus Super Administrator. Anda tidak memiliki wewenang untuk mengelola peran dan hak akses sistem.');
        }
    }

    public function updatedNamaPeran($value)
    {
        if (empty($this->peranId)) {
            $this->slug = Str::slug($value);
        }
    }

    public function bukaFormTambah()
    {
        $this->mount();
        $this->resetErrorBag();
        $this->peranId = null;
        $this->nama_peran = '';
        $this->slug = '';
        $this->deskripsi = '';
        $this->hak_akses = [];
        $this->tampilkanModal = true;
    }

    public function editPeran(string $id)
    {
        $this->resetErrorBag();
        $peran = Peran::findOrFail($id);
        $this->peranId = $peran->id;
        $this->nama_peran = $peran->nama_peran;
        $this->slug = $peran->slug;
        $this->deskripsi = $peran->deskripsi ?? '';
        $this->hak_akses = is_array($peran->hak_akses) ? $peran->hak_akses : [];
        $this->tampilkanModal = true;
    }

    public function toggleAkses(string $modulKey)
    {
        if (in_array($modulKey, $this->hak_akses, true)) {
            $this->hak_akses = array_values(array_diff($this->hak_akses, [$modulKey]));
        } else {
            $this->hak_akses[] = $modulKey;
        }
    }

    public function pilihSemuaAkses()
    {
        $semuaKeys = [];
        foreach (Peran::DAFTAR_MODUL as $grup) {
            foreach ($grup['items'] as $key => $item) {
                $semuaKeys[] = $key;
            }
        }
        $this->hak_akses = $semuaKeys;
    }

    public function kosongkanSemuaAkses()
    {
        $this->hak_akses = [];
    }

    public function simpan()
    {
        $this->validate();

        try {
            $isSuperAdminRole = in_array($this->slug, ['super-admin', 'superadmin'], true);

            $data = [
                'nama_peran' => trim($this->nama_peran),
                'slug' => Str::slug($this->slug),
                'deskripsi' => trim($this->deskripsi),
                'hak_akses' => $isSuperAdminRole ? ['*'] : $this->hak_akses,
            ];

            if ($this->peranId) {
                $peran = Peran::findOrFail($this->peranId);
                $peran->update($data);
                session()->flash('pesan', 'Peran "' . $peran->nama_peran . '" dan hak akses berhasil diperbarui.');
            } else {
                $data['id'] = (string) Str::uuid();
                $peran = Peran::create($data);
                session()->flash('pesan', 'Peran baru "' . $peran->nama_peran . '" berhasil dibuat.');
            }

            $this->tampilkanModal = false;
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal menyimpan peran: ' . $e->getMessage());
        }
    }

    public function konfirmasiHapus(string $id)
    {
        $peran = Peran::withCount('pengguna')->findOrFail($id);

        if (in_array($peran->slug, ['super-admin', 'admin-korcam', 'admin-inorga', 'editor-berita'], true)) {
            session()->flash('error', 'Peran bawaan sistem (' . $peran->nama_peran . ') tidak dapat dihapus.');
            return;
        }

        if ($peran->pengguna_count > 0) {
            session()->flash('error', 'Peran tidak dapat dihapus karena masih digunakan oleh ' . $peran->pengguna_count . ' pengguna.');
            return;
        }

        $this->hapusPeranId = $peran->id;
        $this->hapusPeranNama = $peran->nama_peran;
        $this->tampilkanModalHapus = true;
    }

    public function hapus()
    {
        if (!$this->hapusPeranId) return;

        try {
            $peran = Peran::findOrFail($this->hapusPeranId);
            $nama = $peran->nama_peran;
            $peran->delete();

            $this->tampilkanModalHapus = false;
            $this->hapusPeranId = null;
            session()->flash('pesan', 'Peran "' . $nama . '" berhasil dihapus dari sistem.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal menghapus peran: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $peranList = Peran::withCount('pengguna')
            ->when($this->cari, function ($q) {
                $q->where('nama_peran', 'like', '%' . $this->cari . '%')
                  ->orWhere('slug', 'like', '%' . $this->cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->cari . '%');
            })
            ->orderBy('dibuat_pada', 'asc')
            ->get();

        $daftarModul = Peran::DAFTAR_MODUL;

        return view('livewire.admin.pengguna.peran-kelola', [
            'peranList' => $peranList,
            'daftarModul' => $daftarModul,
        ]);
    }
}
