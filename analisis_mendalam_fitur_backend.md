# 🔬 ANALISIS MENDALAM: Fitur yang Belum Ada & Wajib Ada (KORMI Backend)

Dokumen ini merupakan hasil audit baris-per-baris (*deep code inspection*) dari seluruh controller Livewire, Model, Database Schema, dan Security Layer untuk membedah **fitur apa saja yang belum ada**, **mengapa fitur tersebut wajib ada**, dan **bagaimana spesifikasi teknis implementasinya**.

---

## 📑 DAFTAR ISI ANALISIS
1. [Security & Hak Akses (RBAC & Proteksi Akun)](#1-security--hak-akses-rbac--proteksi-akun)
2. [Audit Trail & Activity Log UI](#2-audit-trail--activity-log-ui)
3. [Layanan Publik Interaktif (Pendaftaran Inorga & SDI)](#3-layanan-publik-interaktif-pendaftaran-inorga--sdi)
4. [Kanal Interaksi Masyarakat & Helpdesk (Kontak Kami)](#4-kanal-interaksi-masyarakat--helpdesk-kontak-kami)
5. [Reporting & Reporting Engine (Export PDF & Excel)](#5-reporting--reporting-engine-export-pdf--excel)
6. [Fitur Manajemen Event Lanjutan (Peserta & Scoring)](#6-fitur-manajemen-event-lanjutan-peserta--scoring)
7. [API Layer, Webhook & Integrasi Eksternal](#7-api-layer-webhook--integrasi-eksternal)
8. [Matriks Perbandingan: Sudah Ada vs Belum Ada](#8-matriks-perbandingan-lengkap)

---

## 1. Security & Hak Akses (RBAC & Proteksi Akun)

### 🔴 Problem Statement:
Saat ini seluruh rute admin `/admin/*` hanya dilindungi oleh middleware bawaan `auth`. Pengguna yang memiliki akun (termasuk operator biasa) dapat:
- Mengubah/menghapus pengguna lain di menu Pengguna.
- Mengubah pengaturan situs KORMI (kontak, logo, sosmed).
- Mengedit data struktur organisasi, SK KORDIK, dan anggaran Proker.
- Form login belum memiliki throttle/rate limiter sehingga rentan terhadap serangan brute force.

### 🛠️ Fitur yang Belum Ada & Harus Dibuat:

#### A. Role-Based Access Control (RBAC) & Middleware Otorisasi
* **Komponen yang Dibutuhkan**:
  - Middleware: `App\Http\Middleware\PeranMiddleware.php`
  - Helper di Model `Pengguna.php`: `isSuperAdmin()`, `punyaPeran(array|string $roles)`
* **Matriks Hak Akses Peran**:
  | Modul Admin | Super Admin | Admin Organisasi | Editor Media | Admin Pertandingan | Operator Wilayah |
  | :--- | :---: | :---: | :---: | :---: | :---: |
  | Pengaturan Situs & Log | ✅ Full | ❌ No | ❌ No | ❌ No | ❌ No |
  | Kelola Pengguna (Users) | ✅ Full | ❌ No | ❌ No | ❌ No | ❌ No |
  | Berita, Galeri, Unduhan | ✅ Full | ❌ View | ✅ Full | ❌ View | ❌ View |
  | Inorga, Pengurus, KORDIK| ✅ Full | ✅ Full | ❌ View | ❌ View | ❌ View |
  | Event & Klasemen Medali | ✅ Full | ❌ View | ❌ View | ✅ Full | ❌ View |
  | Sapras, SDI, APMO | ✅ Full | ✅ Full | ❌ View | ❌ View | ❌ View |

#### B. Throttling / Rate Limiter pada Login Form
* **Komponen yang Dibutuhkan**:
  - Integrasi `Illuminate\Support\Facades\RateLimiter` di [Masuk.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Auth/Masuk.php) dan route POST `/admin/masuk`.
  - Aturan: Maksimal **5 percobaan gagal** dalam 1 menit, setelah itu akun/IP di-lockout selama 60 detik dengan hitung mundur di antarmuka.

#### C. Lockdown Tombol Bypass Login di Lingkungan Produksi
* **Komponen yang Dibutuhkan**:
  - Bungkus tombol bypass login di `masuk.blade.php` hanya untuk `app()->isLocal()`.
  - Guard throw 403 di method `directBypassLogin()` jika `app()->environment('production')`.

---

## 2. Audit Trail & Activity Log UI

### 🔴 Problem Statement:
[AktivitasObserver.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Observers/AktivitasObserver.php) sudah sangat bagus dan otomatis menyimpan riwayat setiap ada penambahan, perubahan, dan penghapusan data ke tabel `kormi_log_aktivitas`. Namun, **tidak ada halaman admin untuk melihat log tersebut**. Jika terjadi perubahan angka perolehan medali atau penghapusan data berita/inorga secara tidak sah, admin tidak dapat melakukan audit secara visual.

### 🛠️ Fitur yang Belum Ada & Harus Dibuat:
- **Komponen Livewire**: `App\Livewire\Admin\Log\LogKelola.php` (Rute: `/admin/log-aktivitas`).
- **Fitur Antarmuka**:
  1. Filter berdasarkan Pengguna (User), Jenis Aksi (`tambah`, `ubah`, `hapus`), dan Nama Tabel.
  2. Range picker tanggal aktivitas.
  3. Modal **JSON Diff Viewer**: Menampilkan komparasi side-by-side antara `data_lama` dan `data_baru` dengan highlight warna (merah = nilai lama, hijau = nilai baru).
  4. Deteksi otomatis IP Address & User Agent browser.
  5. Fitur **Purging Log**: Tombol hapus log lama (> 90 hari) khusus untuk Super Admin.

---

## 3. Layanan Publik Interaktif (Pendaftaran Inorga & SDI)

### 🔴 Problem Statement:
KORMI Kabupaten Bandung adalah organisasi pembina bagi puluhan Induk Olahraga (Inorga) dan rutin menyelenggarakan pelatihan juri/pelatih (SDI). Saat ini, backend bersifat **pasif / CMS satu arah**: semua data harus dimasukkan manual oleh admin CMS.

### 🛠️ Fitur yang Belum Ada & Harus Dibuat:

#### A. Formulir Pendaftaran Inorga Baru & Perpanjangan SK Online
* **Tujuan**: Memungkinkan pengurus Inorga tingkat cabang mendaftarkan organisasinya secara mandiri.
* **Fitur yang Dibutuhkan**:
  - Halaman Publik: `App\Livewire\Publik\Inorga\InorgaDaftar.php` (`/inorga/pendaftaran`).
  - Formulir multi-step: Profil Organisasi, Susunan Pengurus, Jumlah Klub Anggota, Kontak Sekretariat.
  - Upload Berkas Persyaratan (PDF/Gambar ke MinIO):
    - Salinan SK Kemenkumham / SK Pengprov.
    - AD/ART Inorga.
    - Susunan Pengurus & Surat Permohonan Rekomendasi KORMI.
  - Alur Verifikasi Admin: Tab "Verifikasi Pengajuan" di `InorgaKelola.php` dengan aksi **Setujui / Tolak / Minta Revisi** beserta catatan.

#### B. Formulir Pendaftaran Peserta Pelatihan SDI Online
* **Tujuan**: Pendaftaran peserta sertifikasi pelatih/juri olahraga masyarakat.
* **Fitur yang Dibutuhkan**:
  - Integrasi di [Sdi.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Publik/Informasi/Sdi.php): Tombol "Daftar Pelatihan" pada angkatan yang berstatus `dibuka`.
  - Validasi Kuota: Sistem otomatis mengubah status menjadi `penuh` jika jumlah pendaftar telah mencapai `kuota_peserta`.
  - Formulir Peserta: NIK, Nama Lengkap, Nomor WhatsApp, Email, Asal Kecamatan/Inorga, Upload Pas Foto.
  - Unduh Bukti Registrasi / E-Tiket Pendaftaran (PDF ber-QR Code).

---

## 4. Kanal Interaksi Masyarakat & Helpdesk (Kontak Kami)

### 🔴 Problem Statement:
Portal publik belum memiliki halaman Kontak & Pengaduan, sehingga masyarakat tidak memiliki saluran resmi untuk mengirimkan pertanyaan, proposal kegiatan, atau laporan sarana olahraga masyarakat yang rusak.

### 🛠️ Fitur yang Belum Ada & Harus Dibuat:
- **Tabel Database**: `kormi_pesan_kontak` (id, nama_pengirim, email, nomor_telepon, subjek, isi_pesan, status_baca, dibuat_pada).
- **Halaman Publik**: `App\Livewire\Publik\Kontak\KontakIndex.php` (`/kontak`).
  - Peta Lokasi Kantor Sekretariat KORMI Kab. Bandung (Google Maps Embed).
  - Info resmi (Email, Telepon Sekretariat, Jam Layanan, Tautan Media Sosial dari Pengaturan Situs).
  - Form Kirim Pesan dengan validasi anti-spam (Google reCAPTCHA / Cloudflare Turnstile / Honeypot).
- **Modul Admin CMS**: `App\Livewire\Admin\Pesan\PesanKelola.php` (`/admin/pesan`).
  - Inbox pesan masuk dengan badge belum dibaca.
  - Modal baca pesan dan update status (`baru`, `diproses`, `selesai`).

---

## 5. Reporting & Reporting Engine (Export PDF & Excel)

### 🔴 Problem Statement:
Seluruh modul admin (Klasemen Medali, Inorga, Sapras, SDI, Proker) tidak memiliki tombol ekspor. Pengurus KORMI kesulitan ketika harus menyusun laporan berkala ke Dinas Pemuda dan Olahraga (Dispora) Kabupaten Bandung maupun KORMI Jawa Barat.

### 🛠️ Fitur yang Belum Ada & Harus Dibuat:

| Jenis Laporan | Format | Target Pengguna | Isi Laporan |
| :--- | :---: | :---: | :--- |
| **Rekap Klasemen Medali FORKAB** | PDF & Excel | Panitia & Dispora | Tabel perolehan medali Emas, Perak, Perunggu 31 Kecamatan + Total Poin |
| **Buku Profil Inorga Aktif** | PDF | Pengurus & Umum | Daftar Inorga per komisi (OTDA, OKK, OPT), Ketua, SK, Jumlah Klub |
| **Database Sapras Olahraga** | Excel | Bidang Sapras & Dispora | Daftar lapangan/stadion per kecamatan, kondisi fasilitas, jenis olahraga |
| **Laporan Realisasi Program Kerja** | PDF & Excel | Bendahara & Sekretaris | Proker per bidang, target anggaran, bulan pelaksanaan, status capaian |
| **Daftar Kelulusan Peserta SDI** | PDF (Resmi) | Bidang SDI & Peserta | Rekap peserta lulus, nomor sertifikat, nilai kompetensi |

---

## 6. Fitur Manajemen Event Lanjutan (Peserta & Scoring)

### 🔴 Problem Statement:
[EventKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Event/EventKelola.php) sudah memiliki manajemen Master Event, Cabang, dan Jadwal, serta [KlasemenKelola.php](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Event/KlasemenKelola.php) untuk klasemen medali. Namun, alur pendaftaran kontingen/atlet dari 31 kecamatan dan bagan pertandingan (*tournament bracket*) belum tersedia.

### 🛠️ Fitur yang Belum Ada & Harus Dibuat:
- **Tabel Baru**: `kormi_event_peserta` (event_id, cabang_id, kecamatan_id, inorga_id, nama_atlet, no_id_atlet, status_verifikasi).
- **Modul Pendaftaran Kontingen Kecamatan**:
  - Halaman pendaftaran kontingen cabang lomba untuk masing-masing KORDIK Kecamatan.
  - Verifikasi keabsahan atlet (KTP/KK Kabupaten Bandung) untuk mencegah atlet luar daerah pada ajang FORKAB/FOTRADKAB.
- **Skema Bagan / Bracket Pertandingan**:
  - Visualisasi bagan babak gugur (Babak 32, 16 Besar, Perempat Final, Semifinal, Final).

---

## 7. API Layer, Webhook & Integrasi Eksternal

### 🔴 Problem Statement:
Backend ini belum memiliki layer REST API (`routes/api.php`). Hal ini menghambat kebutuhan integrasi dengan aplikasi mobile, widget website lain, atau videotron di venue event.

### 🛠️ Fitur yang Belum Ada & Harus Dibuat:
- **Konfigurasi `routes/api.php`** dengan rate limiting `throttle:60,1`.
- **Daftar Endpoint API Publik (`/api/v1`)**:
  1. `GET /api/v1/berita`: Feed berita terbaru dengan parameter kategori dan pencarian.
  2. `GET /api/v1/event/{slug}/klasemen`: Endpoint live score medali untuk layar videotron di venue.
  3. `GET /api/v1/inorga`: Direktori data induk organisasi terdaftar.
  4. `GET /api/v1/sapras/peta`: GeoJSON lokasi fasilitas olahraga untuk integrasi peta GIS Dispora Kab. Bandung.
  5. `GET /api/v1/sertifikat/cek/{nomorSertifikat}`: Endpoint validasi QR Code keaslian sertifikat SDI.

---

## 8. Matriks Perbandingan Lengkap

```
===================================================================================
STATUS KESIAPAN FITUR BACKEND KORMI KABUPATEN BANDUNG
===================================================================================
Domain Fitur              | Sudah Ada | Belum Ada | Urgensi | Catatan Teknis
-----------------------------------------------------------------------------------
1. Eloquent Models        |    33     |     0     |   -     | Lengkap 100%
2. Admin CMS Livewire     |    17     |     2     | 🟡 Sedang| Kurang Log UI & Pesan
3. Portal Publik Livewire |    17     |     1     | 🟡 Sedang| Kurang Kontak Kami
4. Role-Based Access      |     0     |     5     | 🔴 TINGGI| Perlu Middleware Peran
5. Keamanan Login (Rate)  |     0     |     1     | 🔴 TINGGI| Perlu Throttling Login
6. Log Aktivitas (UI)     | Observer  | UI Admin  | 🔴 TINGGI| Data ada, UI belum
7. Pendaftaran Online     |     0     |     2     | 🟡 Sedang| Inorga & SDI Online
8. Export PDF & Excel     |     0     |     5     | 🟡 Sedang| Laporan Rekapitulasi
9. REST API Layer         |     0     |     5     | 🟢 Normal| routes/api.php
10. Email & Notifikasi    |     0     |     3     | 🟢 Normal| Queue & Mailable
===================================================================================
```

---

## 🎯 Rekomendasi Urutan Eksekusi (Next Sprint)

1. **Sprint 1 (Keamanan & Integritas)**:
   - Implementasi `RoleMiddleware` & pembatasan menu admin berdasarkan peran pengguna.
   - Throttling pada login & lockdown bypass login.
   - Pembuatan Halaman UI Viewer Log Aktivitas (`LogKelola.php`).

2. **Sprint 2 (Interaksi Publik & Administrasi)**:
   - Pembuatan Halaman Publik Kontak Kami + Form Pesan & Admin Inbox Pesan.
   - Pendaftaran Peserta Pelatihan SDI Online di portal publik.
   - Fitur Export PDF & Excel untuk Klasemen Medali, Inorga, dan Sapras.

3. **Sprint 3 (Integrasi & Layanan Mandiri)**:
   - Formulir pendaftaran dan verifikasi Inorga baru secara online.
   - Penyediaan endpoint REST API v1 publik (`routes/api.php`).
   - Generator XML Sitemap dan RSS Feed berita.
