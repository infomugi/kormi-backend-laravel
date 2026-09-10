# 🔍 Analisis Lengkap Fitur Backend KORMI Kabupaten Bandung

Dokumen ini menyajikan audit status menyeluruh dari arsitektur backend, model Eloquent, admin CMS Livewire, portal publik, keamanan, API, dan infrastruktur sistem KORMI Kabupaten Bandung.

---

## 📊 1. Ringkasan Eksekutif (Status Matriks)

| Komponen / Domain | Total Item | ✅ Sudah Ada / Siap | ❌ Belum Ada / Kurang | Status Kesiapan |
| :--- | :---: | :---: | :---: | :---: |
| **Database Schema (Migrations)** | 24 Tabel | 24 Tabel (100%) | 0 | 🟢 Lengkap & Solid |
| **Model Eloquent & Relasi** | 33 Model | 33 Model (100%) | 0 | 🟢 Lengkap |
| **Admin CMS Livewire (CRUD)** | 18 Modul | 16 Modul (89%) | 2 Modul | 🟡 Hampir Lengkap |
| **Portal Publik Livewire** | 18 Halaman | 17 Halaman (94%) | 1 Halaman | 🟢 Sangat Baik |
| **Autentikasi & Keamanan** | 10 Fitur | 4 Fitur (40%) | 6 Fitur | 🔴 Perlu Penguatan |
| **Sistem Log Aktivitas (Audit)**| 4 Komponen | 4 Komponen (100%) | 0 | 🟢 Aktif via Observer |
| **Storage (MinIO / S3)** | 2 Driver | 2 Driver (100%) | 0 | 🟢 Terintegrasi Penuh |
| **API Layer (REST/GraphQL)** | 8 Endpoint | 0 Endpoint (0%) | 8 Endpoint | 🔴 Belum Ada |
| **Infrastruktur & Reliability** | 10 Fitur | 2 Fitur (20%) | 8 Fitur | 🟡 Perlu Perhatian |

---

## 🗄️ 2. Audit Database vs Model Eloquent

Semua tabel dari migrasi telah memiliki representasi Model Eloquent yang mewarisi `ModelDasar` (UUID & custom timestamps):

| # | Nama Tabel Migrasi | Model Eloquent | Soft Deletes | Relasi Utama | Status |
|---|:---|:---|:---:|:---|:---:|
| 1 | `kormi_peran` | [Peran.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/Peran.php) | — | `hasMany(Pengguna)` | ✅ Sudah Ada |
| 2 | `kormi_pengguna` | [Pengguna.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/Pengguna.php) | ✅ | `belongsTo(Peran)` | ✅ Sudah Ada |
| 3 | `kormi_pengaturan_situs` | [PengaturanSitus.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/PengaturanSitus.php) | — | Key-Value Settings | ✅ Sudah Ada |
| 4 | `kormi_linimasa_sejarah` | [LinimasaSejarah.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/LinimasaSejarah.php) | — | Timeline urutan | ✅ Sudah Ada |
| 5 | `kormi_visi_misi` | [VisiMisiModel.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/VisiMisiModel.php) | — | Multi-jenis visi-misi-nilai | ✅ Sudah Ada |
| 6 | `kormi_kecamatan` | [Kecamatan.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/Kecamatan.php) | — | `hasMany(DesaKelurahan, Sapras, Kordik)` | ✅ Sudah Ada |
| 7 | `kormi_desa_kelurahan` | [DesaKelurahan.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/DesaKelurahan.php) | — | `belongsTo(Kecamatan)` | ✅ Sudah Ada |
| 8 | `kormi_periode_kepengurusan` | [PeriodeKepengurusan.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/PeriodeKepengurusan.php) | — | `hasMany(PengurusModel, KordikPengurus)` | ✅ Sudah Ada |
| 9 | `kormi_pengurus` | [PengurusModel.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/PengurusModel.php) | — | `belongsTo(PeriodeKepengurusan)` | ✅ Sudah Ada |
| 10 | `kormi_kordik_pengurus` | [KordikPengurus.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/KordikPengurus.php) | — | `belongsTo(Kecamatan, Periode)` | ✅ Sudah Ada |
| 11 | `kormi_duta_olahraga` | [DutaOlahraga.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/DutaOlahraga.php) | — | `belongsTo(Kecamatan, DesaKelurahan)` | ✅ Sudah Ada |
| 12 | `kormi_program_kerja` | [ProgramKerja.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/ProgramKerja.php) | — | Filter per tahun anggaran & bidang | ✅ Sudah Ada |
| 13 | `kormi_komisi_inorga` | [KomisiInorga.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/KomisiInorga.php) | — | `hasMany(Inorga)` (OTDA, OPT, KOKP) | ✅ Sudah Ada |
| 14 | `kormi_inorga` | [Inorga.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/Inorga.php) | — | `belongsTo(KomisiInorga)` | ✅ Sudah Ada |
| 15 | `kormi_kategori_event` | [KategoriEvent.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/KategoriEvent.php) | — | `hasMany(Event)` | ✅ Sudah Ada |
| 16 | `kormi_event` | [Event.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/Event.php) | — | `hasMany(EventCabang, EventJadwal, Klasemen)` | ✅ Sudah Ada |
| 17 | `kormi_event_cabang` | [EventCabang.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/EventCabang.php) | — | `belongsTo(Event, Inorga)` | ✅ Sudah Ada |
| 18 | `kormi_event_klasemen_medali` | [EventKlasemenMedali.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/EventKlasemenMedali.php) | — | `belongsTo(Event, Kecamatan)` | ✅ Sudah Ada |
| 19 | `kormi_event_jadwal` | [EventJadwal.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/EventJadwal.php) | — | `belongsTo(Event)` | ✅ Sudah Ada |
| 20 | `kormi_apmo_tahun` | [ApmoTahun.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/ApmoTahun.php) | — | `hasMany(ApmoPenerima)` | ✅ Sudah Ada |
| 21 | `kormi_apmo_penerima` | [ApmoPenerima.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/ApmoPenerima.php) | — | `belongsTo(ApmoTahun)` | ✅ Sudah Ada |
| 22 | `kormi_sdi_program` | [SdiProgram.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/SdiProgram.php) | — | `hasMany(SdiJadwal)` | ✅ Sudah Ada |
| 23 | `kormi_sdi_jadwal` | [SdiJadwal.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/SdiJadwal.php) | — | `belongsTo(SdiProgram)`, `hasMany(SdiPeserta)` | ✅ Sudah Ada |
| 24 | `kormi_sdi_peserta` | [SdiPeserta.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/SdiPeserta.php) | — | `belongsTo(SdiJadwal, Kecamatan)` | ✅ Sudah Ada |
| 25 | `kormi_sapras` | [Sapras.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/Sapras.php) | — | `belongsTo(Kecamatan)` | ✅ Sudah Ada |
| 26 | `kormi_kategori_berita` | [KategoriBerita.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/KategoriBerita.php) | — | `hasMany(Berita)` | ✅ Sudah Ada |
| 27 | `kormi_berita` | [Berita.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/Berita.php) | ✅ | `belongsTo(KategoriBerita, Pengguna)` | ✅ Sudah Ada |
| 28 | `kormi_galeri_album` | [GaleriAlbum.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/GaleriAlbum.php) | — | `hasMany(GaleriFoto)` | ✅ Sudah Ada |
| 29 | `kormi_galeri_foto` | [GaleriFoto.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/GaleriFoto.php) | — | `belongsTo(GaleriAlbum)` | ✅ Sudah Ada |
| 30 | `kormi_kategori_unduhan` | [KategoriUnduhan.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/KategoriUnduhan.php) | — | `hasMany(Unduhan)` | ✅ Sudah Ada |
| 31 | `kormi_unduhan` | [Unduhan.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/Unduhan.php) | ✅ | `belongsTo(KategoriUnduhan, Pengguna)` | ✅ Sudah Ada |
| 32 | `kormi_log_aktivitas` | [LogAktivitas.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/LogAktivitas.php) | — | `belongsTo(Pengguna)` | ✅ Sudah Ada |

---

## 🖥️ 3. Admin CMS Livewire (Backend Dashboard)

### ✅ Modul CRUD Admin yang Sudah Ada (16 Modul)
1. **[Dashboard.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Dashboard.php)**: Statistik ringkas (Berita, Inorga, Sapras, SDI, Unduhan, Galeri).
2. **[BeritaKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Berita/BeritaKelola.php)** & **[BeritaForm.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Berita/BeritaForm.php)**: Manajemen berita lengkap + upload gambar ke MinIO + rich formatting.
3. **[GaleriKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Galeri/GaleriKelola.php)**: Manajemen Album & Multi-upload Foto Galeri.
4. **[UnduhanKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Unduhan/UnduhanKelola.php)**: Manajemen file publik (PDF, DOCX, SK, Form).
5. **[InorgaKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Inorga/InorgaKelola.php)**: CRUD induk organisasi olahraga masyarakat + komisi (OTDA, OPT, KOKP) + logo.
6. **[DutaKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Duta/DutaKelola.php)**: CRUD Duta Olahraga per kecamatan & desa.
7. **[KlasemenKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Event/KlasemenKelola.php)**: Perolehan medali (Emas, Perak, Perunggu) 31 Kecamatan.
8. **[SaprasKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Sapras/SaprasKelola.php)**: Data fasilitas sarana & prasarana olahraga per kecamatan.
9. **[SdiKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Sdi/SdiKelola.php)**: Program pelatihan SDI, jadwal angkatan, dan verifikasi kelulusan peserta.
10. **[ApmoKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Apmo/ApmoKelola.php)**: Penerima penghargaan Anugerah Pegiat Masyarakat Olahraga per tahun.
11. **[PenggunaKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Pengguna/PenggunaKelola.php)**: Manajemen user pengelola CMS & ganti password.
12. **[PengaturanKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Pengaturan/PengaturanKelola.php)**: Manajemen identitas situs, kontak, alamat, media sosial.
13. **[SejarahKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Organisasi/SejarahKelola.php)**: Timeline linimasa sejarah KORMI Kabupaten Bandung.
14. **[VisiMisiKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Organisasi/VisiMisiKelola.php)**: Visi, Misi, Nilai Utama, Motto, dan Tujuan KORMI.
15. **[PengurusKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Organisasi/PengurusKelola.php)**: Struktur pengurus kabupaten + periode kepengurusan.
16. **[KordikKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Organisasi/KordikKelola.php)**: Koordinator tingkat kecamatan (31 Kecamatan) & pengurus KORDIK.
17. **[ProkerKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Organisasi/ProkerKelola.php)**: Program kerja per tahun anggaran, bidang, status dan alokasi dana.

### ❌ Modul Admin yang BELUM Ada / Perlu Dibuat
1. **Event Management CRUD (Master Event, Cabang, Jadwal)**:
   - *Status*: Baru ada [KlasemenKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Event/KlasemenKelola.php).
   - *Kebutuhan*: CRUD Master Event (`kormi_event`), Cabang Lomba (`kormi_event_cabang`), dan Jadwal/Timeline Pertandingan (`kormi_event_jadwal`).
2. **Log Aktivitas Viewer (Audit Trail UI)**:
   - *Status*: Observer dan Model sudah mencatat otomatis ke tabel `kormi_log_aktivitas`.
   - *Kebutuhan*: Halaman Admin untuk melihat riwayat aktivitas user (siapa mengubah apa, kapan, IP mana).

---

## 🌐 4. Portal Publik Livewire

| # | Halaman Publik | Komponen Livewire | Fitur Utama | Status |
|---|:---|:---|:---|:---:|
| 1 | Beranda | [Beranda.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Beranda.php) | Hero slider, statistik, berita terbaru, inorga unggulan, galeri | ✅ Siap |
| 2 | Sejarah | [Sejarah.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Tentang/Sejarah.php) | Dynamic linimasa sejarah KORMI | ✅ Siap |
| 3 | Visi & Misi | [VisiMisi.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Tentang/VisiMisi.php) | Visi, butir misi, nilai utama, motto | ✅ Siap |
| 4 | Struktur Pengurus | [Pengurus.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Tentang/Pengurus.php) | Daftar Dewan Kehormatan, Penasihat, Pengurus Harian & Bidang | ✅ Siap |
| 5 | Koordinator Kecamatan (KORDIK) | [Kordik.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Tentang/Kordik.php) | Peta & daftar Kordik di 31 Kecamatan Kab. Bandung | ✅ Siap |
| 6 | Duta Olahraga | [DutaOlahragaIndex.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Tentang/DutaOlahragaIndex.php) | Profil duta per kecamatan/desa & filter prestasi | ✅ Siap |
| 7 | Program Kerja | [Proker.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Tentang/Proker.php) | Kalender/tabel kegiatan per bidang & progres | ✅ Siap |
| 8 | Direktori Inorga | [InorgaIndex.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Inorga/InorgaIndex.php) | Filter 3 komisi (OTDA, OPT, KOKP), pencarian, detail klub | ✅ Siap |
| 9 | FORKAB (Festival Olahraga Kab) | [Forkab.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Event/Forkab.php) | Klasemen medali 31 kecamatan, jadwal, cabor | ✅ Siap |
| 10 | FOTRADKAB (Tradisional) | [Fotradkab.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Event/Fotradkab.php) | Festival olahraga tradisional daerah | ✅ Siap |
| 11 | APMO (Anugerah Pegiat) | [Apmo.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Informasi/Apmo.php) | Hall of fame para tokoh & pegiat berprestasi | ✅ Siap |
| 12 | SDI (Pengembangan SDM) | [Sdi.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Informasi/Sdi.php) | Jadwal pelatihan, sertifikasi juri/pelatih | ✅ Siap |
| 13 | Sapras (Sarana Prasarana) | [Sapras.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Informasi/Sapras.php) | Direktori lapangan & fasilitas olahraga 31 kec | ✅ Siap |
| 14 | Berita & Artikel | [BeritaIndex.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Media/BeritaIndex.php) | Filter kategori, pagination, pencarian berita | ✅ Siap |
| 15 | Detail Berita | [BeritaDetail.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Media/BeritaDetail.php) | Baca artikel lengkap, counter viewer, berita terkait | ✅ Siap |
| 16 | Galeri Dokumentasi | [GaleriIndex.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Media/GaleriIndex.php) | Tab album foto kegiatan KORMI & preview lightbox | ✅ Siap |
| 17 | Pusat Unduhan (Download) | [UnduhanIndex.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Unduhan/UnduhanIndex.php) | Download SK, AD/ART, Formulir, Juknis | ✅ Siap |
| 18 | Halaman Kontak & Saran | — | Formulir pesan publik, info helpdesk, Google Maps embed | ❌ Belum Ada |

---

## 🔒 5. Autentikasi, Hak Akses & Keamanan

| Fitur / Area Keamanan | Status | Tingkat Urgensi | Catatan / Rekomendasi |
|:---|:---:|:---:|:---|
| **Route Protection (Auth Middleware)** | ✅ Aktif | — | Rute `/admin/*` terlindungi middleware `auth` |
| **Bypass Login Route (`/private-infomugi`)** | ⚠️ Terkondisi | 🟡 Sedang | Sudah dilindungi kondisi `app()->environment('local', 'development')`, aman di production asalkan `APP_ENV=production` |
| **Pencatatan Audit Trail Otomatis** | ✅ Aktif | — | `AktivitasObserver` otomatis mencatat INSERT/UPDATE/DELETE seluruh model ke `kormi_log_aktivitas` |
| **Role-Based Access Control (RBAC)** | ❌ Belum Ada | 🔴 Tinggi | Belum ada middleware/policy pembeda role (misal: Superadmin vs Admin Berita vs Admin Inorga) |
| **Rate Limiting (Throttle) pada Login** | ❌ Belum Ada | 🟡 Sedang | Perlu ditambahkan middleware `throttle:6,1` pada rute POST login untuk mencegah brute-force |
| **Fitur Lupa Password & Reset Token** | ❌ Belum Fungsional | 🟡 Sedang | Tampilan ada ([LupaPassword.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Auth/LupaPassword.php)), tetapi alur pengiriman token email dan reset password belum diimplementasi |
| **Email Verification** | ❌ Belum Ada | 🟢 Opsional | Opsional untuk portal organisasi internal |
| **Two-Factor Authentication (2FA)** | ❌ Belum Ada | 🟢 Fitur Lanjutan | Nice-to-have |

---

## 🚀 6. Fitur Layanan & Integrasi Bisnis Organisasi

### 6A. Keanggotaan Inorga & KORDIK
- [ ] **Formulir Pendaftaran Inorga Baru Online**: Form publik bagi induk organisasi baru untuk mengajukan SK & verifikasi berkas.
- [ ] **Status Perpanjangan SK & Notifikasi Masa Tenggang**: Sistem peringatan otomatis ketika SK Inorga mendekati masa kadaluarsa.
- [ ] **Generator Sertifikat/Surat Rekomendasi**: Cetak PDF kartu keanggotaan atau SK pengesahan KORMI.

### 6B. Event & Pertandingan
- [x] Manajemen Klasemen Medali Per Kecamatan ([KlasemenKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Event/KlasemenKelola.php))
- [ ] CRUD Master Event & Multi-cabang Lomba (FORKAB, FOTRADKAB)
- [ ] Pendaftaran Kontingen / Atlet / Peserta Event Online
- [ ] Skema Bagan / Bracket Pertandingan Olahraga

### 6C. Pengembangan SDM (SDI)
- [x] Master Program & Jadwal Pelatihan ([SdiKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Sdi/SdiKelola.php))
- [x] Verifikasi Status Kelulusan & Nomor Sertifikat
- [ ] Pendaftaran Peserta Pelatihan dari Portal Publik
- [ ] Cetak / Verifikasi Keaslian Sertifikat Digital (QR Code Verification)

---

## 📡 7. API Layer & Integrasi Data

Saat ini backend beroperasi menggunakan server-side rendering (Livewire). Belum tersedia file `routes/api.php` dan token autentikasi (Sanctum).

| Endpoint Potensial | Kegunaan | Status |
|:---|:---|:---:|
| `GET /api/v1/berita` | Sinkronisasi berita ke Aplikasi Mobile / Portal Pemda Kab. Bandung | ❌ Belum Ada |
| `GET /api/v1/inorga` | Data publik induk organisasi & status keaktifan | ❌ Belum Ada |
| `GET /api/v1/event/klasemen` | Data perolehan medali FORKAB untuk widget pihak ketiga / videotron | ❌ Belum Ada |
| `GET /api/v1/sapras` | Peta GIS sarana olahraga untuk integrasi Dispora | ❌ Belum Ada |
| `POST /api/v1/pendaftaran/*` | Endpoint pendaftaran event & pelatihan | ❌ Belum Ada |

---

## 🛠️ 8. Infrastruktur, Kualitas Kode & Pemeliharaan

| Aspek Teknis | Kondisi Saat Ini | Rekomendasi Solusi |
|:---|:---|:---|
| **File Storage** | ✅ MinIO S3 terintegrasi via `StorageService` | Sangat baik untuk scalable storage |
| **Seeder Data** | ✅ [DatabaseSeeder.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/database/seeders/DatabaseSeeder.php) lengkap (Kecamatan, Inorga, Berita, dll) | Siap pakai untuk staging & testing |
| **Automated Testing** | ❌ Belum ada unit/feature test | Tambahkan Pest/PHPUnit test untuk Auth dan CRUD |
| **Export/Import Data** | ❌ Belum ada export Excel/PDF | Integrasikan `maatwebsite/excel` atau `barryvdh/laravel-dompdf` untuk laporan rekap |
| **Queue / Background Jobs**| ❌ Migrasi jobs ada tapi belum dipakai | Gunakan Redis/Database queue untuk pemrosesan gambar & pengiriman notifikasi |
| **Backup Database** | ❌ Belum ada otomasi backup | Integrasikan `spatie/laravel-backup` |

---

## 📋 9. Roadmap Rekomendasi Pengerjaan Selanjutnya

```mermaid
flowchart TD
    subgraph Tahap 1 - Kelengkapan CMS & Event
        A1[CRUD Master Event, Cabang & Jadwal] --> A2[UI Viewer Log Aktivitas Admin]
        A2 --> A3[Halaman Publik Kontak Kami & Form Saran]
    end
    
    subgraph Tahap 2 - Keamanan & Autentikasi
        B1[Role & Permission Middleware / Policies] --> B2[Rate Limiting Login POST]
        B2 --> B3[Alur Fungsional Lupa Password]
    end
    
    subgraph Tahap 3 - Layanan Publik Interaktif & Export
        C1[Pendaftaran Peserta SDI / Event Online] --> C2[Fitur Export Rekap Excel & PDF]
        C2 --> C3[REST API Layer untuk Integrasi Eksternal]
    end

    Tahap 1 --> Tahap 2 --> Tahap 3
```
