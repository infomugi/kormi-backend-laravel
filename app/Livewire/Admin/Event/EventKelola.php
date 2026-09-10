<?php

namespace App\Livewire\Admin\Event;

use App\Models\Event;
use App\Models\EventCabang;
use App\Models\EventJadwal;
use App\Models\Inorga;
use App\Models\KategoriEvent;
use App\Services\StorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Event & Festival Olahraga - KORMI CMS')]
class EventKelola extends Component
{
    use WithPagination, WithFileUploads;

    // Mode: 'tabel', 'form_event', 'detail_event', 'form_kategori'
    public string $mode = 'tabel';
    public string $tampilanMode = 'tabel'; // 'tabel' atau 'grid'
    public string $tabAktif = 'info'; // 'info', 'cabang', 'jadwal'
    public string $cari = '';
    public string $kategoriDipilih = 'Semua';
    public string $statusPublikasiFilter = 'Semua'; // 'Semua', '1', '0'
    public string $sortField = 'tanggal_mulai';
    public string $sortDirection = 'desc';
    public int $perPage = 10;

    // Bulk Actions
    public array $selectedEvent = [];
    public bool $pilihSemua = false;

    // Form Event Utama
    public ?string $editEventId = null;
    public string $kategori_event_id = '';
    public string $judul_event = '';
    public string $slug = '';
    public int $tahun_edisi = 2026;
    public string $lokasi_utama = '';
    public string $tanggal_mulai = '';
    public string $tanggal_selesai = '';
    public string $deskripsi_lengkap = '';
    public string $tautan_eksternal = '';
    public bool $status_publikasi = true;
    public string $banner_url = '';
    public string $logo_event_url = '';
    public $uploadBanner = null;
    public $uploadLogo = null;

    // Event Aktif yang sedang dibuka detailnya
    public ?string $activeEventId = null;
    public ?Event $activeEvent = null;

    // Form Cabang Lomba
    public ?string $editCabangId = null;
    public ?string $cabang_inorga_id = null;
    public string $cabang_nama = '';
    public string $cabang_kategori_peserta = 'Umum / Terbuka';
    public string $cabang_ikon = 'award';
    public string $cabang_kode_warna = 'bg-emerald-500';
    public string $cabang_juknis_url = '';
    public $uploadJuknis = null;
    public bool $bukaModalCabang = false;

    // Form Jadwal & Fase
    public ?string $editJadwalId = null;
    public string $jadwal_fase = 'Penyisihan';
    public string $jadwal_tanggal = '';
    public string $jadwal_jam_mulai = '08:00';
    public string $jadwal_jam_selesai = '12:00';
    public string $jadwal_nama_kegiatan = '';
    public string $jadwal_tempat_arena = '';
    public string $jadwal_status = 'akan_datang';
    public string $jadwal_keterangan = '';
    public bool $bukaModalJadwal = false;

    // Kelola Kategori Event
    public ?string $editKategoriId = null;
    public string $nama_kategori = '';
    public bool $bukaModalKategori = false;

    public function mount(): void
    {
        $this->tahun_edisi = (int) date('Y');
        $this->tanggal_mulai = date('Y-m-d');
        $this->tanggal_selesai = date('Y-m-d', strtotime('+3 days'));
        $this->jadwal_tanggal = date('Y-m-d');
    }

    public function updatedCari(): void
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedKategoriDipilih(): void
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedStatusPublikasiFilter(): void
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedSortField(): void
    {
        $this->resetPage();
    }

    public function updatedSortDirection(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
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
            $this->selectedEvent = $this->getCurrentPageEventIds();
        } else {
            $this->selectedEvent = [];
        }
    }

    public function resetSelection(): void
    {
        $this->selectedEvent = [];
        $this->pilihSemua = false;
    }

    public function resetSemuaFilter(): void
    {
        $this->cari = '';
        $this->kategoriDipilih = 'Semua';
        $this->statusPublikasiFilter = 'Semua';
        $this->sortField = 'tanggal_mulai';
        $this->sortDirection = 'desc';
        $this->resetPage();
        $this->resetSelection();
    }

    public function setFilterKategori(string $kategoriId): void
    {
        $this->kategoriDipilih = $kategoriId;
        $this->resetPage();
        $this->resetSelection();
    }

    public function setFilterStatus(string $status): void
    {
        $this->statusPublikasiFilter = $status;
        $this->resetPage();
        $this->resetSelection();
    }

    public function toggleStatusPublikasi(string $id): void
    {
        $item = Event::findOrFail($id);
        $item->update(['status_publikasi' => !$item->status_publikasi]);
        session()->flash('pesan', 'Status publikasi event "' . $item->judul_event . '" berhasil diubah.');
    }

    public function bulkPublish(): void
    {
        if (empty($this->selectedEvent)) return;

        Event::whereIn('id', $this->selectedEvent)->update(['status_publikasi' => true]);
        session()->flash('pesan', count($this->selectedEvent) . ' event berhasil dipublikasikan.');
        $this->resetSelection();
    }

    public function bulkDraft(): void
    {
        if (empty($this->selectedEvent)) return;

        Event::whereIn('id', $this->selectedEvent)->update(['status_publikasi' => false]);
        session()->flash('pesan', count($this->selectedEvent) . ' event diubah statusnya menjadi draft.');
        $this->resetSelection();
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedEvent)) return;

        $events = Event::whereIn('id', $this->selectedEvent)->get();
        $storage = app(StorageService::class);

        foreach ($events as $ev) {
            if ($ev->banner_url) {
                $storage->hapusFile($ev->banner_url);
            }
            if ($ev->logo_event_url) {
                $storage->hapusFile($ev->logo_event_url);
            }
            $ev->delete();
        }

        session()->flash('pesan', count($this->selectedEvent) . ' event berhasil dihapus.');
        $this->resetSelection();
    }

    protected function getCurrentPageEventIds(): array
    {
        return $this->getEventQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
    }

    protected function getEventQuery()
    {
        $allowedSorts = ['judul_event', 'tanggal_mulai', 'tahun_edisi', 'lokasi_utama', 'created_at'];
        $sort = in_array($this->sortField, $allowedSorts) ? $this->sortField : 'tanggal_mulai';
        $direction = strtolower($this->sortDirection) === 'asc' ? 'asc' : 'desc';

        return Event::with(['kategoriEvent', 'cabang', 'jadwal'])
            ->when($this->kategoriDipilih !== 'Semua', fn($q) => $q->where('kategori_event_id', $this->kategoriDipilih))
            ->when($this->statusPublikasiFilter !== 'Semua', fn($q) => $q->where('status_publikasi', (bool) $this->statusPublikasiFilter))
            ->when($this->cari, fn($q) => $q->where(function ($sub) {
                $sub->where('judul_event', 'like', "%{$this->cari}%")
                    ->orWhere('lokasi_utama', 'like', "%{$this->cari}%");
            }))
            ->orderBy($sort, $direction);
    }

    public function updatedJudulEvent(): void
    {
        if (!$this->editEventId) {
            $this->slug = Str::slug($this->judul_event);
        }
    }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->activeEventId = null;
        $this->activeEvent = null;
        $this->resetInputEvent();
    }

    // ==========================================
    // EVENT UTAMA CRUD
    // ==========================================
    public function bukaFormTambahEvent(): void
    {
        $this->resetInputEvent();
        $firstKat = KategoriEvent::first();
        if ($firstKat) {
            $this->kategori_event_id = $firstKat->id;
        }
        $this->mode = 'form_event';
        $this->resetErrorBag();
    }

    public function bukaFormEditEvent(string $id): void
    {
        $event = Event::findOrFail($id);
        $this->editEventId        = $event->id;
        $this->kategori_event_id  = $event->kategori_event_id;
        $this->judul_event        = $event->judul_event;
        $this->slug               = $event->slug;
        $this->tahun_edisi        = $event->tahun_edisi;
        $this->lokasi_utama       = $event->lokasi_utama;
        $this->tanggal_mulai      = $event->tanggal_mulai ? $event->tanggal_mulai->format('Y-m-d') : '';
        $this->tanggal_selesai    = $event->tanggal_selesai ? $event->tanggal_selesai->format('Y-m-d') : '';
        $this->deskripsi_lengkap  = $event->deskripsi_lengkap ?? '';
        $this->tautan_eksternal   = $event->tautan_eksternal ?? '';
        $this->status_publikasi   = (bool) $event->status_publikasi;
        $this->banner_url         = $event->banner_url ?? '';
        $this->logo_event_url     = $event->logo_event_url ?? '';
        $this->uploadBanner       = null;
        $this->uploadLogo         = null;
        $this->mode               = 'form_event';
        $this->resetErrorBag();
    }

    public function bukaDetailEvent(string $id): void
    {
        $this->activeEventId = $id;
        $this->activeEvent = Event::with(['kategoriEvent', 'cabang.inorga', 'jadwal'])->findOrFail($id);
        $this->tabAktif = 'info';
        $this->mode = 'detail_event';
    }

    public function simpanEvent(): void
    {
        $rules = [
            'kategori_event_id' => 'required|exists:kormi_kategori_event,id',
            'judul_event'       => 'required|min:3|max:200',
            'slug'              => 'required|max:200|unique:kormi_event,slug,' . ($this->editEventId ?? 'NULL') . ',id',
            'tahun_edisi'       => 'required|integer|min:2000|max:2099',
            'lokasi_utama'      => 'required|string|max:255',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date|after_or_equal:tanggal_mulai',
            'uploadBanner'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'uploadLogo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ];

        $this->validate($rules);

        /** @var StorageService $storage */
        $storage = app(StorageService::class);

        $pathBanner = $this->banner_url;
        if ($this->uploadBanner) {
            if ($this->editEventId && !empty($this->banner_url)) {
                $storage->hapusFile($this->banner_url);
            }
            $pathBanner = $storage->uploadGambar($this->uploadBanner, 'event/banner');
        }

        $pathLogo = $this->logo_event_url;
        if ($this->uploadLogo) {
            if ($this->editEventId && !empty($this->logo_event_url)) {
                $storage->hapusFile($this->logo_event_url);
            }
            $pathLogo = $storage->uploadGambar($this->uploadLogo, 'event/logo');
        }

        $data = [
            'kategori_event_id' => $this->kategori_event_id,
            'judul_event'       => trim($this->judul_event),
            'slug'              => Str::slug($this->slug ?: $this->judul_event),
            'tahun_edisi'       => $this->tahun_edisi,
            'lokasi_utama'      => trim($this->lokasi_utama),
            'tanggal_mulai'     => $this->tanggal_mulai,
            'tanggal_selesai'   => $this->tanggal_selesai,
            'deskripsi_lengkap' => $this->deskripsi_lengkap,
            'tautan_eksternal'  => $this->tautan_eksternal,
            'status_publikasi'  => $this->status_publikasi,
            'banner_url'        => $pathBanner,
            'logo_event_url'    => $pathLogo,
        ];

        if ($this->editEventId) {
            $item = Event::findOrFail($this->editEventId);
            $item->update($data);
            session()->flash('pesan', 'Event "' . $this->judul_event . '" berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            $newEvent = Event::create($data);
            session()->flash('pesan', 'Event baru "' . $this->judul_event . '" berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapusEvent(string $id): void
    {
        $item = Event::findOrFail($id);
        $nama = $item->judul_event;

        $storage = app(StorageService::class);
        if ($item->banner_url) {
            $storage->hapusFile($item->banner_url);
        }
        if ($item->logo_event_url) {
            $storage->hapusFile($item->logo_event_url);
        }

        $item->delete();
        session()->flash('pesan', 'Event "' . $nama . '" beserta cabang dan jadwalnya berhasil dihapus.');
    }

    public function resetInputEvent(): void
    {
        $this->editEventId        = null;
        $this->judul_event        = '';
        $this->slug               = '';
        $this->tahun_edisi        = (int) date('Y');
        $this->lokasi_utama       = '';
        $this->tanggal_mulai      = date('Y-m-d');
        $this->tanggal_selesai    = date('Y-m-d', strtotime('+3 days'));
        $this->deskripsi_lengkap  = '';
        $this->tautan_eksternal   = '';
        $this->status_publikasi   = true;
        $this->banner_url         = '';
        $this->logo_event_url     = '';
        $this->uploadBanner       = null;
        $this->uploadLogo         = null;
    }

    // ==========================================
    // CABANG LOMBA CRUD (Nested inside activeEvent)
    // ==========================================
    public function bukaModalTambahCabang(): void
    {
        $this->resetInputCabang();
        $this->bukaModalCabang = true;
    }

    public function bukaModalEditCabang(string $id): void
    {
        $cab = EventCabang::findOrFail($id);
        $this->editCabangId           = $cab->id;
        $this->cabang_inorga_id       = $cab->inorga_id;
        $this->cabang_nama            = $cab->nama_cabang;
        $this->cabang_kategori_peserta= $cab->kategori_peserta ?? 'Umum';
        $this->cabang_ikon            = $cab->ikon ?? 'award';
        $this->cabang_kode_warna      = $cab->kode_warna_hex ?? 'bg-emerald-500';
        $this->cabang_juknis_url      = $cab->aturan_juknis_url ?? '';
        $this->uploadJuknis           = null;
        $this->bukaModalCabang        = true;
    }

    public function simpanCabang(): void
    {
        $this->validate([
            'cabang_nama' => 'required|min:3|max:150',
            'cabang_inorga_id' => 'nullable|exists:kormi_inorga,id',
            'uploadJuknis' => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $pathJuknis = $this->cabang_juknis_url;
        if ($this->uploadJuknis) {
            $storage = app(StorageService::class);
            if ($this->editCabangId && !empty($this->cabang_juknis_url)) {
                $storage->hapusFile($this->cabang_juknis_url);
            }
            $pathJuknis = $storage->uploadDokumen($this->uploadJuknis, 'event/juknis');
        }

        $data = [
            'event_id'          => $this->activeEventId,
            'inorga_id'         => $this->cabang_inorga_id ?: null,
            'nama_cabang'       => trim($this->cabang_nama),
            'kategori_peserta'  => $this->cabang_kategori_peserta,
            'ikon'              => $this->cabang_ikon,
            'kode_warna_hex'    => $this->cabang_kode_warna,
            'aturan_juknis_url' => $pathJuknis,
        ];

        if ($this->editCabangId) {
            EventCabang::findOrFail($this->editCabangId)->update($data);
            session()->flash('pesan_sub', 'Cabang lomba berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            EventCabang::create($data);
            session()->flash('pesan_sub', 'Cabang lomba baru berhasil ditambahkan!');
        }

        $this->bukaModalCabang = false;
        $this->resetInputCabang();
        $this->activeEvent = Event::with(['kategoriEvent', 'cabang.inorga', 'jadwal'])->findOrFail($this->activeEventId);
    }

    public function hapusCabang(string $id): void
    {
        $cab = EventCabang::findOrFail($id);
        if ($cab->aturan_juknis_url) {
            app(StorageService::class)->hapusFile($cab->aturan_juknis_url);
        }
        $cab->delete();
        session()->flash('pesan_sub', 'Cabang lomba berhasil dihapus.');
        $this->activeEvent = Event::with(['kategoriEvent', 'cabang.inorga', 'jadwal'])->findOrFail($this->activeEventId);
    }

    public function resetInputCabang(): void
    {
        $this->editCabangId           = null;
        $this->cabang_inorga_id       = null;
        $this->cabang_nama            = '';
        $this->cabang_kategori_peserta= 'Umum / Terbuka';
        $this->cabang_ikon            = 'award';
        $this->cabang_kode_warna      = 'bg-emerald-500';
        $this->cabang_juknis_url      = '';
        $this->uploadJuknis           = null;
        $this->resetErrorBag();
    }

    // ==========================================
    // JADWAL & FASE CRUD (Nested inside activeEvent)
    // ==========================================
    public function bukaModalTambahJadwal(): void
    {
        $this->resetInputJadwal();
        $this->bukaModalJadwal = true;
    }

    public function bukaModalEditJadwal(string $id): void
    {
        $jdw = EventJadwal::findOrFail($id);
        $this->editJadwalId           = $jdw->id;
        $this->jadwal_fase            = $jdw->fase_tahapan;
        $this->jadwal_tanggal         = $jdw->tanggal ? $jdw->tanggal->format('Y-m-d') : date('Y-m-d');
        $this->jadwal_jam_mulai       = $jdw->jam_mulai ? substr($jdw->jam_mulai, 0, 5) : '08:00';
        $this->jadwal_jam_selesai     = $jdw->jam_selesai ? substr($jdw->jam_selesai, 0, 5) : '12:00';
        $this->jadwal_nama_kegiatan   = $jdw->nama_kegiatan;
        $this->jadwal_tempat_arena    = $jdw->tempat_arena;
        $this->jadwal_status          = $jdw->status_tahapan;
        $this->jadwal_keterangan      = $jdw->keterangan ?? '';
        $this->bukaModalJadwal        = true;
    }

    public function simpanJadwal(): void
    {
        $this->validate([
            'jadwal_nama_kegiatan' => 'required|min:3|max:200',
            'jadwal_fase'          => 'required|string|max:100',
            'jadwal_tanggal'       => 'required|date',
            'jadwal_tempat_arena'  => 'required|string|max:150',
            'jadwal_status'        => 'required|in:selesai,berlangsung,akan_datang',
        ]);

        $data = [
            'event_id'       => $this->activeEventId,
            'fase_tahapan'   => $this->jadwal_fase,
            'tanggal'        => $this->jadwal_tanggal,
            'jam_mulai'      => $this->jadwal_jam_mulai,
            'jam_selesai'    => $this->jadwal_jam_selesai,
            'nama_kegiatan'  => trim($this->jadwal_nama_kegiatan),
            'tempat_arena'   => trim($this->jadwal_tempat_arena),
            'status_tahapan' => $this->jadwal_status,
            'keterangan'     => $this->jadwal_keterangan,
        ];

        if ($this->editJadwalId) {
            EventJadwal::findOrFail($this->editJadwalId)->update($data);
            session()->flash('pesan_sub', 'Jadwal kegiatan berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            EventJadwal::create($data);
            session()->flash('pesan_sub', 'Jadwal kegiatan baru berhasil ditambahkan!');
        }

        $this->bukaModalJadwal = false;
        $this->resetInputJadwal();
        $this->activeEvent = Event::with(['kategoriEvent', 'cabang.inorga', 'jadwal'])->findOrFail($this->activeEventId);
    }

    public function hapusJadwal(string $id): void
    {
        EventJadwal::findOrFail($id)->delete();
        session()->flash('pesan_sub', 'Jadwal berhasil dihapus.');
        $this->activeEvent = Event::with(['kategoriEvent', 'cabang.inorga', 'jadwal'])->findOrFail($this->activeEventId);
    }

    public function resetInputJadwal(): void
    {
        $this->editJadwalId           = null;
        $this->jadwal_fase            = 'Penyisihan';
        $this->jadwal_tanggal         = date('Y-m-d');
        $this->jadwal_jam_mulai       = '08:00';
        $this->jadwal_jam_selesai     = '12:00';
        $this->jadwal_nama_kegiatan   = '';
        $this->jadwal_tempat_arena    = '';
        $this->jadwal_status          = 'akan_datang';
        $this->jadwal_keterangan      = '';
        $this->resetErrorBag();
    }

    // ==========================================
    // KATEGORI EVENT MODAL CRUD
    // ==========================================
    public function bukaModalKelolaKategori(): void
    {
        $this->nama_kategori = '';
        $this->editKategoriId = null;
        $this->bukaModalKategori = true;
    }

    public function editKategori(string $id): void
    {
        $kat = KategoriEvent::findOrFail($id);
        $this->editKategoriId = $kat->id;
        $this->nama_kategori = $kat->nama_kategori;
    }

    public function simpanKategori(): void
    {
        $this->validate([
            'nama_kategori' => 'required|min:3|max:100',
        ]);

        $data = [
            'nama_kategori' => trim($this->nama_kategori),
            'slug'          => Str::slug($this->nama_kategori),
        ];

        if ($this->editKategoriId) {
            KategoriEvent::findOrFail($this->editKategoriId)->update($data);
            session()->flash('pesan_kategori', 'Kategori berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            KategoriEvent::create($data);
            session()->flash('pesan_kategori', 'Kategori baru berhasil ditambahkan!');
        }

        $this->nama_kategori = '';
        $this->editKategoriId = null;
    }

    public function hapusKategori(string $id): void
    {
        $kat = KategoriEvent::withCount('events')->findOrFail($id);
        if ($kat->events_count > 0) {
            session()->flash('error_kategori', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $kat->events_count . ' event.');
            return;
        }

        $kat->delete();
        session()->flash('pesan_kategori', 'Kategori berhasil dihapus.');
    }

    public function render()
    {
        $kategoriList = KategoriEvent::withCount('events')->orderBy('nama_kategori')->get();
        $inorgaList = Inorga::orderBy('nama_inorga')->get();

        $eventList = $this->getEventQuery()->paginate($this->perPage);

        $totalEvent = Event::count();
        $totalPublish = Event::where('status_publikasi', true)->count();
        $totalDraft = Event::where('status_publikasi', false)->count();
        $totalCabang = EventCabang::count();

        return view('livewire.admin.event.event-kelola', [
            'eventList'     => $eventList,
            'kategoriList'  => $kategoriList,
            'inorgaList'    => $inorgaList,
            'totalEvent'    => $totalEvent,
            'totalPublish'  => $totalPublish,
            'totalDraft'    => $totalDraft,
            'totalCabang'   => $totalCabang,
        ]);
    }
}
