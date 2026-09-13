# Analisis Keamanan, Potensi Bug, dan Celah Kerentanan Sistem
**Proyek:** Backend CMS & Portal Publik KORMI Kabupaten Bandung (Laravel 11 + Livewire 3 + Alpine.js + Tailwind CSS)  
**Tanggal Audit:** 13 September 2026  
**Status:** Komprehensif / Full Audit

---

## 1. Ringkasan Eksekutif (Executive Summary)

Audit keamanan dan stabilitas kode ini dilakukan secara menyeluruh terhadap arsitektur backend, lapisan otentikasi/otorisasi, alur input-output data, manajemen file storage (S3/MinIO), serta komponen interaktif Livewire pada proyek CMS KORMI Kabupaten Bandung.

Secara umum, aplikasi telah menerapkan praktik keamanan modern seperti:
- **Rate Limiting** pada alur login (`RateLimiter` 5 percobaan / 60 detik).
- **Password Hashing** (`bcrypt` / `Hash::make`) dan sanitasi attribute model (`$hidden = ['kata_sandi', 'remember_token']`).
- **Pencegahan XSS / Blade Escaping** pada sebagian besar view template.
- **Validasi MIME Type dan Ekstensi File** pada form upload gambar & dokumen.
- **Middleware Role-Based Access Control (RBAC)** bertingkat pada route admin.

Namun demikian, terdapat **10 area temuan kritikal hingga minor** yang berpotensi menimbulkan celah keamanan, eskalasi hak akses, maupun bug fungsional di lingkungan produksi (production).

---

## 2. Matriks Temuan Keamanan & Bug (Risk Matrix)

| No | Kategori | Tingkat Risiko | Deskripsi Singkat | Rekomendasi Solusi |
|:---|:---|:---:|:---|:---|
| 1 | **Otorisasi / Autentikasi** | 🔴 **HIGH** | Default Role pada Self-Registration (`Daftar.php`) mengarahkan ke `super-admin` jika disetujui. | Ubah default peran menjadi role berhak akses terendah (`editor-berita` / role `tamu` / khusus permohonan). |
| 2 | **Otorisasi / Autentikasi** | 🔴 **HIGH** | Route Bypass Login (`/private-infomugi`) berisiko bocor jika env `APP_ENV` tidak diset ke `production`. | Pastikan proteksi ketat dan matikan atau hapus helper backdoor saat deploy production. |
| 3 | **CSRF / Session** | 🟡 **MEDIUM** | Pengecualian CSRF pada route `/admin/keluar` dan `/admin/logout` di `bootstrap/app.php`. | Gunakan `POST` method murni dengan proteksi token CSRF untuk aksi logout guna mencegah serangan *Forced Logout CSRF*. |
| 4 | **Mass Assignment & Scope** | 🟡 **MEDIUM** | Penggunaan `$guarded = []` pada hampir seluruh Model Eloquent. | Tentukan `$fillable` eksplisit atau pastikan controller / Livewire tidak pernah melakukan `Model::create($request->all())`. |
| 5 | **File Storage & Path Traversal** | 🟡 **MEDIUM** | Upload file storage publik / temp S3 URL expiration & nama file acak. | Gunakan nama file hash unik (UUID/SHA) dan sanitasi nama file asli untuk mencegah penimpaan file & Path Traversal. |
| 6 | **API Rate Limiting** | 🟡 **MEDIUM** | Endpoint publik `/api/v1/*` belum dibungkus middleware `throttle:api`. | Tambahkan middleware `throttle:60,1` atau `throttle:api` pada route group `routes/api.php`. |
| 7 | **Injeksi / Livewire Validation** | 🟢 **LOW** | Validasi sanitasi teks input pada form rich text / HTML konten deskripsi berita. | Terapkan HTML Purifier pada kolom deskripsi berita yang dirender via `{!! $berita->konten !!}`. |
| 8 | **Enumerasi Pengguna** | 🟢 **LOW** | Pesan error Login membedakan "Email tidak terdaftar" dan "Kata sandi salah". | Gunakan pesan error umum/generik: *"Email atau kata sandi tidak valid."* untuk mencegah akun user harvesting. |
| 9 | **Penanganan Soft Deletes & Foreign Keys** | 🟢 **LOW** | Relasi antar tabel dengan `SoftDeletes` berisiko meninggalkan *orphaned child records*. | Tambahkan pengecekan integritas data saat force delete atau cascade action. |
| 10 | **Error Handling & Environment Leakage** | 🟢 **LOW** | `APP_DEBUG=true` di server produksi dapat membocorkan kredensial DB dan kunci API S3/MinIO. | Pastikan `APP_DEBUG=false` di file `.env` produksi. |

---

## 3. Detail Analisis Celah & Bukti Kode

### 3.1. [HIGH] Default Role Self-Registration Berisiko Super-Admin
- **Lokasi File:** [`app/Livewire/Admin/Auth/Daftar.php`](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Livewire/Admin/Auth/Daftar.php#L61)
- **Kondisi Kode:**
  ```php
  // app/Livewire/Admin/Auth/Daftar.php baris 61
  $peran = Peran::where('slug', 'super-admin')->first() ?? Peran::first();
  ```
- **Potensi Celah:** Ketika seorang pengguna mendaftar melalui form publik `/admin/daftar`, akun mereka otomatis diberi `peran_id` milik `super-admin`. Meskipun akun membutuhkan approval (`status_aktif = false`), saat admin mengaktifkannya melalui tombol toggle "Aktifkan" di tabel Pengguna tanpa memeriksa dropdown peran, pengguna baru tersebut langsung mendapatkan wewenang tertinggi (`super-admin`).
- **Mitigasi:**
  Ubah query default peran ke role dengan level terendah atau buat field `peran_id` bernilai `null` / peran `editor-berita` / buat enum pendaftaran khusus.

---

### 3.2. [HIGH] Route Bypass Login (`/private-infomugi`)
- **Lokasi File:** [`routes/web.php`](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/routes/web.php#L104-L118)
- **Kondisi Kode:**
  ```php
  if (app()->environment('local', 'development')) {
      Route::get('/private-infomugi', function () {
          $admin = \App\Models\Pengguna::where('email', 'admin@kormibdg.id')->first();
          if ($admin) {
              Auth::login($admin);
              request()->session()->regenerate();
              return redirect()->route('admin.dashboard');
          }
      });
  }
  ```
- **Potensi Celah:** Jika server di-deploy dengan `APP_ENV=local` (kelalaian konfigurasi hosting/VPS), route ini dapat diakses publik oleh siapa saja untuk langsung masuk sebagai Super Admin tanpa password.
- **Mitigasi:**
  Pastikan checklist deployment otomatis memvalidasi `APP_ENV=production` dan `APP_DEBUG=false`, atau gunakan flag khusus di `.env` seperti `ALLOW_DEV_BYPASS=false`.

---

### 3.3. [MEDIUM] Pengecualian CSRF pada Endpoint Logout
- **Lokasi File:** [`bootstrap/app.php`](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/bootstrap/app.php#L19-L24)
- **Kondisi Kode:**
  ```php
  $middleware->validateCsrfTokens(except: [
      'admin/keluar',
      'admin/logout',
      'keluar',
      'logout',
  ]);
  ```
- **Potensi Celah:** Pengecualian token CSRF ditambah adanya method `GET` pada route `/admin/keluar` memungkinkan serangan *Forced Logout CSRF* (penyerang menyisipkan tag `<img src="https://domain.com/admin/keluar">` di forum publik/website lain yang memaksa admin ter-logout saat membuka halaman penyerang).
- **Mitigasi:**
  Jadikan aksi logout eksklusif menggunakan HTTP `POST` dengan directive `@csrf` pada tombol form logout dan hapus pengecualian CSRF dari `bootstrap/app.php`.

---

### 3.4. [MEDIUM] Mass Assignment Protection (`$guarded = []`)
- **Lokasi File:** [`app/Models/Pengguna.php`](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/Pengguna.php#L23), [`app/Models/DutaOlahraga.php`](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/app/Models/DutaOlahraga.php)
- **Potensi Celah:** Seluruh model mendefinisikan `protected $guarded = [];`. Jika di masa mendatang developer menggunakan `Model::create($request->all())` atau `Model::update($request->input())`, atribut sensitif seperti `peran_id`, `status_aktif`, atau `is_admin` dapat di-override oleh payload request berbahaya.
- **Mitigasi:**
  Tetapkan array `$fillable` eksplisit pada setiap model atau pastikan hanya menggunakan `$request->validated()` atau variabel terikat Livewire.

---

### 3.5. [MEDIUM] Ketiadaan Rate Limiting pada API Publik (`routes/api.php`)
- **Lokasi File:** [`routes/api.php`](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/routes/api.php#L17)
- **Potensi Celah:** Endpoint API `/api/v1/berita`, `/api/v1/event`, `/api/v1/inorga`, dll. belum dibatasi laju request-nya (*Unthrottled*). Penyerang dapat melakukan DoS/Spam scraping secara masif yang membebani resource database dan server.
- **Mitigasi:**
  Bungkus route group API dengan middleware `throttle:60,1` (60 request per menit per IP).
  ```php
  Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
      // API endpoints
  });
  ```

---

### 3.6. [LOW] Sanitasi Konten HTML (XSS Protection pada Berita)
- **Lokasi File:** [`resources/views/livewire/publik/media/berita-detail.blade.php`](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/resources/views/livewire/publik/media/berita-detail.blade.php)
- **Potensi Celah:** Berita yang dibuat oleh user dengan role `editor-berita` dirender menggunakan `{!! $berita->konten !!}`. Jika akun editor berita disusupi atau disalahgunakan, script berbahaya (`<script>` atau inline event handler `onload/onerror`) dapat dieksekusi di browser pengunjung portal publik (Stored XSS).
- **Mitigasi:**
  Gunakan library HTML Sanitizer (misal: `mewebstudio/purifier` atau helper `strip_tags()` terkonfigurasi) sebelum menyimpan field `konten` berita ke database.

---

### 3.7. [LOW] Account Harvesting via Respon Login
- **Lokasi File:** [`routes/web.php`](file:///Volumes/Data/Aplikasi%20-%20WEB/2026/kormi-backend-laravel/routes/web.php#L155-L165)
- **Potensi Celah:** Respon login secara spesifik memberi tahu:
  - *"Alamat email tidak terdaftar dalam sistem CMS KORMI."* vs
  - *"Kata sandi yang Anda masukkan salah."*
  Hal ini memudahkan penyerang memvalidasi daftar email admin yang aktif dalam sistem (*Username Enumeration*).
- **Mitigasi:**
  Samakan pesan kegagalan autentikasi menjadi: *"Alamat email atau kata sandi yang Anda masukkan tidak sesuai."*

---

## 4. Panduan & Checklist Perbaikan Keamanan (Action Plan)

- [ ] **Fix 1:** Ubah default peran pada `app/Livewire/Admin/Auth/Daftar.php` agar tidak mengarah ke `super-admin`.
- [ ] **Fix 2:** Tambahkan rate limiter `throttle:60,1` pada `routes/api.php`.
- [ ] **Fix 3:** Standarisasi pesan error pada `admin.masuk.post` untuk mitigasi user enumeration.
- [ ] **Fix 4:** Ubah tombol logout admin menjadi form `POST` dengan proteksi `@csrf` dan hapus exception di `bootstrap/app.php`.
- [ ] **Fix 5:** Pasang sanitasi tag HTML sebelum menyimpan konten deskripsi berita.
- [ ] **Fix 6:** Periksa konfigurasi `.env.production` untuk memastikan `APP_DEBUG=false` dan `APP_ENV=production`.

---
*Dokumen analisis keamanan ini disusun secara otomatis dan dapat diperbarui seiring perkembangan fitur sistem.*
