<?php

namespace App\Livewire\Mobile;

use App\Models\Core\Pengguna;
use App\Models\Kormi\DutaOlahraga;
use App\Services\PersetujuanPendaftaran;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.mobile')]
#[Title('Persetujuan - KORMI Kabupaten Bandung')]
class Persetujuan extends Component
{
    use WithPagination;

    public string $tab = 'duta';
    public ?string $tolakId = null;
    public string $catatan = '';
    public ?string $pesan = null;
    public ?string $galat = null;

    public function mount(): void
    {
        $this->pastikanSuperAdmin();
    }

    public function pilihTab(string $tab): void
    {
        if (! in_array($tab, ['duta', 'akun'], true)) {
            return;
        }

        $this->tab = $tab;
        $this->batalTolak();
        $this->pesan = null;
        $this->galat = null;
    }

    public function setujuiDuta(string $id): void
    {
        $this->pastikanSuperAdmin();
        $this->pesan = null;
        $this->galat = null;

        $duta = DutaOlahraga::find($id);

        if (! $duta || ! $duta->sedangMenunggu()) {
            $this->galat = 'Pendaftaran tersebut sudah diproses sebelumnya.';
            return;
        }

        app(PersetujuanPendaftaran::class)->setujuiDuta($duta, auth()->id());
        $this->resetPage('dutaPage');

        $this->pesan = 'Pendaftaran "' . $duta->nama_lengkap . '" disetujui. Akun pendaftar diaktifkan dan tertaut sebagai Duta Olahraga.';
    }

    public function mulaiTolak(string $id): void
    {
        $this->tolakId = $id;
        $this->catatan = '';
        $this->galat = null;
        $this->pesan = null;
    }

    public function batalTolak(): void
    {
        $this->tolakId = null;
        $this->catatan = '';
        $this->resetValidation('catatan');
    }

    public function tolakDuta(): void
    {
        $this->pastikanSuperAdmin();
        $this->pesan = null;
        $this->galat = null;

        $this->validate([
            'catatan' => 'nullable|string|max:500',
        ], [
            'catatan.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $duta = $this->tolakId ? DutaOlahraga::find($this->tolakId) : null;

        if (! $duta || ! $duta->sedangMenunggu()) {
            $this->galat = 'Pendaftaran tersebut sudah diproses sebelumnya.';
            $this->batalTolak();
            return;
        }

        $akunDihapus = app(PersetujuanPendaftaran::class)->tolakDuta($duta, trim($this->catatan) ?: null);
        $this->resetPage('dutaPage');

        $this->pesan = 'Pendaftaran "' . $duta->nama_lengkap . '" ditolak. '
            . ($akunDihapus
                ? 'Akun otomatisnya dihapus sehingga email tersebut bisa dipakai mendaftar ulang.'
                : 'Tautan akun pendaftar dilepas dan perannya dikembalikan.');

        $this->batalTolak();
    }

    public function setujuiAkun(string $id): void
    {
        $this->pastikanSuperAdmin();
        $this->pesan = null;
        $this->galat = null;

        $akun = Pengguna::find($id);

        if (! $akun || $akun->status_aktif) {
            $this->galat = 'Akun tersebut sudah aktif atau tidak ditemukan.';
            return;
        }

        app(PersetujuanPendaftaran::class)->setujuiAkun($akun, auth()->id());
        $this->resetPage('akunPage');

        $this->pesan = 'Akun "' . $akun->nama_lengkap . '" disetujui dan diaktifkan.';
    }

    public function render()
    {
        $dutaMenunggu = DutaOlahraga::menunggu()->count();

        $akunTerhubungDuta = DutaOlahraga::menunggu()
            ->whereNotNull('pengguna_id')
            ->pluck('pengguna_id');

        $akunMenunggu = Pengguna::query()
            ->where('status_aktif', false)
            ->whereNull('disetujui_pada')
            ->whereNotIn('id', $akunTerhubungDuta)
            ->count();

        $duta = DutaOlahraga::menunggu()
            ->with(['kecamatan', 'desaKelurahan', 'akunPendaftar'])
            ->orderByDesc('dibuat_pada')
            ->paginate(8, ['*'], 'dutaPage');

        $akun = Pengguna::with(['peran', 'duta', 'kecamatan', 'desa'])
            ->where('status_aktif', false)
            ->whereNull('disetujui_pada')
            ->whereNotIn('id', $akunTerhubungDuta)
            ->orderByDesc('dibuat_pada')
            ->paginate(8, ['*'], 'akunPage');

        return view('livewire.mobile.persetujuan', [
            'daftarDuta' => $duta,
            'daftarAkun' => $akun,
            'dutaMenunggu' => $dutaMenunggu,
            'akunMenunggu' => $akunMenunggu,
        ]);
    }

    private function pastikanSuperAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403);
    }
}
