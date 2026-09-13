# Panduan Arsitektur Modular: Pemisahan Backend & Frontend Starterkit

Dokumen ini menjelaskan arsitektur pemisahan penuh antara **Backend** dan **Frontend** pada lapisan Models, Livewire Components, Blade Views, dan Routing.

---

## 1. Pemisahan Routing (`routes/`)

Routing dipisahkan menjadi file-file modular:
- **`routes/frontend.php`** : Mengelola seluruh rute Portal Publik KORMI (Landing page, Berita, Event, Inorga, Tentang, Unduhan, Kontak).
- **`routes/backend.php`** : Mengelola seluruh rute Admin CMS Panel & Autentikasi (Login, Register, Dashboard, Kelola Berita, Modul KORMI, Pengguna, Pengaturan).
- **`routes/api.php`** : Mengelola endpoint RESTful API v1.
- **`routes/web.php`** : Entry point yang memuat `frontend.php` dan `backend.php`.

---

## 2. Struktur Komponen Livewire (`app/Livewire/`)

### A. Livewire Backend (`app/Livewire/Backend/`)
- **Starterkit Core**:
  - `Auth/` (`Masuk`, `Daftar`, `LupaPassword`)
  - `Pengguna/` (`PenggunaKelola`, `PeranKelola`)
  - `Pengaturan/` (`PengaturanKelola`)
  - `Dashboard.php`
- **Content CMS**:
  - `Berita/` (`BeritaKelola`, `BeritaForm`)
  - `Galeri/` (`GaleriKelola`)
  - `Unduhan/` (`UnduhanKelola`)
- **Modul Kormi (`Backend/Kormi/`)**:
  - `Inorga/` (`InorgaKelola`)
  - `Duta/` (`DutaKelola`)
  - `Sapras/` (`SaprasKelola`)
  - `Event/` (`EventKelola`, `KlasemenKelola`)
  - `Organisasi/` (`PengurusKelola`, `VisiMisiKelola`, `SejarahKelola`, `ProkerKelola`, `KordikKelola`)
  - `Apmo/` (`ApmoKelola`)
  - `Sdi/` (`SdiKelola`)

### B. Livewire Frontend (`app/Livewire/Frontend/`)
- **Portal Core**:
  - `Beranda.php`
  - `Kontak.php`
  - `Media/` (`BeritaIndex`, `BeritaDetail`, `GaleriIndex`)
  - `Unduhan/` (`UnduhanIndex`)
- **Modul Kormi (`Frontend/Kormi/`)**:
  - `Inorga/` (`InorgaIndex`)
  - `Event/` (`Forkab`, `Fotradkab`)
  - `Informasi/` (`Apmo`, `Sapras`, `Sdi`)
  - `Tentang/` (`Pengurus`, `VisiMisi`, `Sejarah`, `Proker`, `Kordik`, `DutaOlahragaIndex`)

---

## 3. Struktur Views Blade (`resources/views/livewire/`)
- **`resources/views/livewire/backend/`** : Seluruh blade views backend & CMS panel.
- **`resources/views/livewire/frontend/`** : Seluruh blade views frontend & portal publik.
- **`resources/views/components/layouts/backend.blade.php`** : Layout master backend.
- **`resources/views/components/layouts/frontend.blade.php`** : Layout master frontend.

---

## 4. Struktur Models (`app/Models/`)
- **`Core/`** : Model pondasi starterkit (`ModelDasar`, `User`, `Pengguna`, `Peran`, `PengaturanSitus`, `LogAktivitas`).
- **`Master/`** : Master data wilayah (`Kecamatan`, `DesaKelurahan`).
- **`Content/`** : CMS Konten (`Berita`, `KategoriBerita`, `GaleriAlbum`, `GaleriFoto`, `Unduhan`, `KategoriUnduhan`).
- **`Kormi/`** : Seluruh model bisnis KORMI (`Inorga`, `KomisiInorga`, `DutaOlahraga`, `Sapras`, `Event`, `KategoriEvent`, `EventCabang`, `EventJadwal`, `EventKlasemenMedali`, `PeriodeKepengurusan`, `PengurusModel`, `VisiMisiModel`, `LinimasaSejarah`, `ProgramKerja`, `KordikPengurus`, `ApmoPenerima`, `ApmoTahun`, `SdiProgram`, `SdiJadwal`, `SdiPeserta`).
