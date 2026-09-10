-- ========================================================
-- KORMI Database MySQL Dump
-- Generated: 2026-09-09 11:10:45
-- Engine: InnoDB | Charset: utf8mb4 | Collate: utf8mb4_unicode_ci
-- Total Tables: 41
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Table structure for `cache`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `cache_locks`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `failed_jobs`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `job_batches`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` bigint NOT NULL,
  `pending_jobs` bigint NOT NULL,
  `failed_jobs` bigint NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` bigint DEFAULT NULL,
  `created_at` bigint NOT NULL,
  `finished_at` bigint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `jobs`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` bigint NOT NULL,
  `reserved_at` bigint DEFAULT NULL,
  `available_at` bigint NOT NULL,
  `created_at` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `kormi_apmo_penerima`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_apmo_penerima`;
CREATE TABLE `kormi_apmo_penerima` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apmo_tahun_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_penghargaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_penerima` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `asal_lembaga_wilayah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_capaian` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` bigint NOT NULL DEFAULT '0',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_apmo_penerima`
INSERT INTO `kormi_apmo_penerima` (`id`, `apmo_tahun_id`, `kategori_penghargaan`, `nama_penerima`, `asal_lembaga_wilayah`, `deskripsi_capaian`, `foto_url`, `urutan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-65f2-4115-84e3-777024dea93f', 'a2b40c67-6599-4873-8de6-2ae1e7154724', 'Tokoh Penggerak Olahraga Masyarakat', 'H. Dadang Supriatna, S.Ip., M.Si.', 'Bupati Bandung', 'Dedikasi luar biasa dalam memajukan dan mengalokasikan dukungan penuh bagi ekosistem olahraga masyarakat di Kabupaten Bandung.', NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-661d-4e07-9af1-69f1d63d9940', 'a2b40c67-6599-4873-8de6-2ae1e7154724', 'Atlet Tradisional Berprestasi', 'Rian Hidayat', 'Inorga PORTINA - Cabang Egrang', 'Meraih medali emas pada ajang FORNAS dan konsisten mengedukasi generasi muda dalam pelestarian permainan tradisional.', NULL, 2, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-663e-4dec-9175-8958f49fb0d3', 'a2b40c67-6599-4873-8de6-2ae1e7154724', 'Inorga Teraktif & Teladan', 'ASIAFI Kabupaten Bandung', 'Asosiasi Instruktur Aerobik dan Fitnes Indonesia', 'Paling aktif menyelenggarakan senam massal rutin di puluhan titik kecamatan dan desa setiap minggunya.', NULL, 3, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-6661-452d-a67f-2f36070eea48', 'a2b40c67-6599-4873-8de6-2ae1e7154724', 'Koordinator Kecamatan Terbaik', 'Koordinator Kecamatan Soreang', 'Kordik Soreang', 'Pengelolaan data duta olahraga desa tercepat dan penyelenggara festival olahraga desa terpadu.', NULL, 4, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-2a44-4026-91a4-fc318188274e', 'a2b44265-29bf-4783-89d9-2b420d94b440', 'Tokoh Penggerak Olahraga Masyarakat', 'H. Dadang Supriatna, S.Ip., M.Si.', 'Bupati Bandung', 'Dedikasi luar biasa dalam memajukan dan mengalokasikan dukungan penuh bagi ekosistem olahraga masyarakat di Kabupaten Bandung.', NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2b0f-4275-8131-360f0851e3c4', 'a2b44265-29bf-4783-89d9-2b420d94b440', 'Atlet Tradisional Berprestasi', 'Rian Hidayat', 'Inorga PORTINA - Cabang Egrang', 'Meraih medali emas pada ajang FORNAS dan konsisten mengedukasi generasi muda dalam pelestarian permainan tradisional.', NULL, 2, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2b2d-4eb1-8733-6c50e53f2ed9', 'a2b44265-29bf-4783-89d9-2b420d94b440', 'Inorga Teraktif & Teladan', 'ASIAFI Kabupaten Bandung', 'Asosiasi Instruktur Aerobik dan Fitnes Indonesia', 'Paling aktif menyelenggarakan senam massal rutin di puluhan titik kecamatan dan desa setiap minggunya.', NULL, 3, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2b56-4b71-9e05-ac6a85067ef8', 'a2b44265-29bf-4783-89d9-2b420d94b440', 'Koordinator Kecamatan Terbaik', 'Koordinator Kecamatan Soreang', 'Kordik Soreang', 'Pengelolaan data duta olahraga desa tercepat dan penyelenggara festival olahraga desa terpadu.', NULL, 4, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-8f06-4f0c-8292-929b60792341', 'a2b44566-8eba-4fc0-bc24-a00472c4b884', 'Tokoh Penggerak Olahraga Masyarakat', 'H. Dadang Supriatna, S.Ip., M.Si.', 'Bupati Bandung', 'Dedikasi luar biasa dalam memajukan dan mengalokasikan dukungan penuh bagi ekosistem olahraga masyarakat di Kabupaten Bandung.', NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8f70-448f-8929-9e67dd336c77', 'a2b44566-8eba-4fc0-bc24-a00472c4b884', 'Atlet Tradisional Berprestasi', 'Rian Hidayat', 'Inorga PORTINA - Cabang Egrang', 'Meraih medali emas pada ajang FORNAS dan konsisten mengedukasi generasi muda dalam pelestarian permainan tradisional.', NULL, 2, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8fa7-4bb6-abb2-eea2d2ce6c24', 'a2b44566-8eba-4fc0-bc24-a00472c4b884', 'Inorga Teraktif & Teladan', 'ASIAFI Kabupaten Bandung', 'Asosiasi Instruktur Aerobik dan Fitnes Indonesia', 'Paling aktif menyelenggarakan senam massal rutin di puluhan titik kecamatan dan desa setiap minggunya.', NULL, 3, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8fc4-471d-b631-e87031c1412c', 'a2b44566-8eba-4fc0-bc24-a00472c4b884', 'Koordinator Kecamatan Terbaik', 'Koordinator Kecamatan Soreang', 'Kordik Soreang', 'Pengelolaan data duta olahraga desa tercepat dan penyelenggara festival olahraga desa terpadu.', NULL, 4, '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_apmo_tahun`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_apmo_tahun`;
CREATE TABLE `kormi_apmo_tahun` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` bigint NOT NULL,
  `tema_acara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_penganugerahan` date DEFAULT NULL,
  `tempat_acara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_apmo_tahun`
INSERT INTO `kormi_apmo_tahun` (`id`, `tahun`, `tema_acara`, `tanggal_penganugerahan`, `tempat_acara`, `deskripsi`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-6599-4873-8de6-2ae1e7154724', 2025, 'Bangkit Bersama Olahraga Rekreasi Menuju Kabupaten Bandung BEDAS', '2025-12-20', 'Gedung Budaya Sabilulungan, Soreang', 'Apresiasi tertinggi tahunan bagi insan olahraga masyarakat.', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-65be-4352-a664-2ebb9cd7c79e', 2024, 'Kebugaran Masyarakat untuk Indonesia Maju', '2024-12-18', 'Hotel Grand Sunshine, Soreang', 'Apresiasi tahunan edisi 2024.', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-29bf-4783-89d9-2b420d94b440', 2025, 'Bangkit Bersama Olahraga Rekreasi Menuju Kabupaten Bandung BEDAS', '2025-12-20', 'Gedung Budaya Sabilulungan, Soreang', 'Apresiasi tertinggi tahunan bagi insan olahraga masyarakat.', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-29e1-415d-9446-8f134689e329', 2024, 'Kebugaran Masyarakat untuk Indonesia Maju', '2024-12-18', 'Hotel Grand Sunshine, Soreang', 'Apresiasi tahunan edisi 2024.', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-8eba-4fc0-bc24-a00472c4b884', 2025, 'Bangkit Bersama Olahraga Rekreasi Menuju Kabupaten Bandung BEDAS', '2025-12-20', 'Gedung Budaya Sabilulungan, Soreang', 'Apresiasi tertinggi tahunan bagi insan olahraga masyarakat.', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8eda-4bdd-b524-f743e4f10b35', 2024, 'Kebugaran Masyarakat untuk Indonesia Maju', '2024-12-18', 'Hotel Grand Sunshine, Soreang', 'Apresiasi tahunan edisi 2024.', '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_berita`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_berita`;
CREATE TABLE `kormi_berita` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penulis_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ringkasan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_konten` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_utama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_dilihat` bigint NOT NULL DEFAULT '0',
  `status_unggulan` bigint NOT NULL DEFAULT '0',
  `status_publikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `tanggal_publikasi` timestamp NULL DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dihapus_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_berita`
INSERT INTO `kormi_berita` (`id`, `kategori_id`, `penulis_id`, `judul`, `slug`, `ringkasan`, `isi_konten`, `gambar_utama`, `keterangan_gambar`, `jumlah_dilihat`, `status_unggulan`, `status_publikasi`, `tanggal_publikasi`, `dibuat_pada`, `diperbarui_pada`, `dihapus_pada`) VALUES
  ('a2b40c67-5f9a-4b00-828f-e1a99a34813b', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Persiapan Menuju FORKAB 2026: Rapat Koordinasi Wilayah', 'persiapan-menuju-forkab-2026-rapat-koordinasi-wilayah', 'KORMI Kabupaten Bandung melakukan sinkronisasi program kerja bersama seluruh pengurus kecamatan untuk mempersiapkan FORKAB 2026 yang akan segera diselenggarakan.', '<p>KORMI Kabupaten Bandung menyelenggarakan rapat koordinasi wilayah untuk mematangkan kesiapan pelaksanaan Festival Olahraga Rekreasi Masyarakat Kabupaten (FORKAB) 2026. Pertemuan yang dihadiri oleh seluruh koordinator kecamatan dan pimpinan induk organisasi olahraga (INORGA) ini bertujuan menyelaraskan teknis perlombaan dan kesiapan kontingen dari 31 kecamatan.</p><p>Ketua KORMI Kabupaten Bandung menyampaikan bahwa FORKAB tahun ini akan mengusung semangat kolaborasi dan kebugaran inklusif untuk seluruh lapisan masyarakat Kabupaten Bandung.</p>', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 1250, 1, 'published', '2026-09-07 22:17:39', '2026-09-09 22:17:39', '2026-09-09 11:09:52', NULL),
  ('a2b40c67-5fc1-414b-9a6c-8176d8fea5ba', 'a2b40c67-5e85-4c98-b5ca-c9ecb1153f15', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Atlet Inorga Kabupaten Bandung Raih Emas di Kejuaraan Nasional', 'atlet-inorga-kabupaten-bandung-raih-emas-di-kejuaraan-nasional', 'Kebanggaan bagi warga Bandung, perwakilan atlet tradisional kita berhasil menyabet podium utama di ajang nasional.', '<p>Prestasi membanggakan kembali diukir oleh atlet olahraga rekreasi Kabupaten Bandung pada ajang Kejuaraan Tingkat Nasional. Delegasi berhasil membawa pulang medali emas setelah unggul di kategori ketangkasan dan olahraga tradisional.</p>', 'https://images.unsplash.com/photo-1526676023641-72e042776856?q=80&w=800', NULL, 870, 0, 'published', '2026-09-04 22:17:39', '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b40c67-5fe8-4137-a1df-8fb36c320723', 'a2b40c67-5ea8-4bda-a02b-5c9824829e10', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Senam Massal Bedas di Soreang: Ribuan Warga Turut Memeriahkan', 'senam-massal-bedas-di-soreang-ribuan-warga-turut-memeriahkan', 'Peningkatan indeks kebugaran masyarakat menjadi target utama dalam kegiatan rutin mingguan ini yang diikuti ribuan peserta.', '<p>Ribuan warga memadati area Lapangan Upakarti Soreang untuk mengikuti Senam Massal Bedas. Kegiatan ini merupakan bagian dari gerakan pembudayaan olahraga yang digelorakan KORMI bekerjasama dengan ASIAFI dan STI.</p>', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800', NULL, 1520, 0, 'published', '2026-09-01 22:17:39', '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b40c67-6010-45be-992c-0832000ef13a', 'a2b40c67-5ed4-433c-81ba-a9c67f07ba86', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Audiensi KORMI Bersama Bupati Bandung Bahas Masa Depan Olahraga', 'audiensi-kormi-bersama-bupati-bandung-bahas-masa-depan-olahraga', 'Pertemuan strategis untuk memperkuat dukungan pemerintah daerah terhadap olahraga rekreasi masyarakat.', '<p>Jajaran pengurus KORMI Kabupaten Bandung diterima langsung oleh Bupati Bandung di Rumah Dinas Soreang. Pertemuan ini membahas rencana penguatan infrastruktur olahraga masyarakat serta pendukungan anggaran untuk pembinaan 31 kecamatan.</p>', 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=800', NULL, 960, 0, 'published', '2026-08-30 22:17:39', '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b40c67-6032-44b0-957c-276218847611', 'a2b40c67-5ef8-403b-b7a4-d7fba9c1cb80', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Pelatihan Pelatih Olahraga Tradisional Tingkat Kabupaten Bandung', 'pelatihan-pelatih-olahraga-tradisional-tingkat-kabupaten-bandung', 'Mencetak instruktur yang kompeten untuk melestarikan budaya olahraga asli daerah di setiap kecamatan.', '<p>Sebanyak 60 calon pelatih olahraga tradisional mengikuti sertifikasi dan bimbingan teknis PORTINA untuk meningkatkan standar perwasitan dan kepelatihan egrang, terompah panjang, dan hadang.</p>', 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', NULL, 640, 0, 'published', '2026-08-28 22:17:39', '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b40c67-6053-404f-ac45-f3e774b124d8', 'a2b40c67-5f1b-4d11-a26c-8158029010f4', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Bakti Sosial KORMI Berbagi: Sehat Raganya, Bahagia Jiwanya', 'bakti-sosial-kormi-berbagi-sehat-raganya-bahagia-jiwanya', 'Kegiatan kolaboratif antara olahraga dan kepedulian sosial di wilayah terdampak bencana alam.', '<p>KORMI menyalurkan bantuan paket logistik sekaligus mengadakan terapi senam bugar untuk warga terdampak di wilayah Kabupaten Bandung selatan.</p>', 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800', NULL, 510, 0, 'published', '2026-08-25 22:17:39', '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b40c67-609d-494f-8ec8-4b3fe4d0b517', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Bandung Bedas Run 2026: Pendaftaran Resmi Dibuka!', 'bandung-bedas-run-2026-pendaftaran-resmi-dibuka', 'Event lari terbesar di Kabupaten Bandung kembali hadir. Segera daftarkan diri Anda dan raihlah pengalaman berlari terbaik.', '<p>Pendaftaran Bandung Bedas Run 2026 kategori 5K dan 10K resmi dibuka. Rute akan melintasi ikon-ikon pariwisata Soreang dan Stadion Si Jalak Harupat.</p>', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', NULL, 2100, 0, 'published', '2026-08-22 22:17:39', '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b40c67-60c2-4d30-9e47-e101caf4e343', 'a2b40c67-5e85-4c98-b5ca-c9ecb1153f15', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Kecamatan Margahayu Juara Umum FOTRADKAB 2025', 'kecamatan-margahayu-juara-umum-fotradkab-2025', 'Dengan perolehan 10 emas, 6 perak, dan 4 perunggu, Margahayu keluar sebagai juara umum FOTRADKAB tahun ini.', '<p>Dominasi kontingen Margahayu di cabang hadang dan ketapel berhasil mengantarkan mereka mengukuhkan gelar Juara Umum FOTRADKAB.</p>', 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800', NULL, 1180, 0, 'published', '2026-08-20 22:17:39', '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b4425f-23e4-4614-ad3b-c557372ae442', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Berita Uji Coba KORMI 2026 Updated', 'berita-uji-coba-kormi-2026-341', 'Ringkasan berita uji coba', 'Konten detail uji coba berita kormi', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 0, 0, 'published', '2026-09-09 17:48:33', '2026-09-09 17:48:33', '2026-09-09 17:48:33', '2026-09-09 17:48:33'),
  ('a2b44265-2305-48c4-bf9f-bde493c1a8b4', 'a2b44265-20c9-4c44-9637-c506a95ad312', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'Persiapan Menuju FORKAB 2026: Rapat Koordinasi Wilayah', 'persiapan-menuju-forkab-2026-rapat-koordinasi-wilayah', 'KORMI Kabupaten Bandung melakukan sinkronisasi program kerja bersama seluruh pengurus kecamatan untuk mempersiapkan FORKAB 2026 yang akan segera diselenggarakan.', '<p>KORMI Kabupaten Bandung menyelenggarakan rapat koordinasi wilayah untuk mematangkan kesiapan pelaksanaan Festival Olahraga Rekreasi Masyarakat Kabupaten (FORKAB) 2026. Pertemuan yang dihadiri oleh seluruh koordinator kecamatan dan pimpinan induk organisasi olahraga (INORGA) ini bertujuan menyelaraskan teknis perlombaan dan kesiapan kontingen dari 31 kecamatan.</p><p>Ketua KORMI Kabupaten Bandung menyampaikan bahwa FORKAB tahun ini akan mengusung semangat kolaborasi dan kebugaran inklusif untuk seluruh lapisan masyarakat Kabupaten Bandung.</p>', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 1240, 1, 'published', '2026-09-07 17:48:37', '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44265-236a-49de-b676-14079e26e132', 'a2b44265-20fc-4961-a5b8-7c8e4e2e8b08', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'Atlet Inorga Kabupaten Bandung Raih Emas di Kejuaraan Nasional', 'atlet-inorga-kabupaten-bandung-raih-emas-di-kejuaraan-nasional', 'Kebanggaan bagi warga Bandung, perwakilan atlet tradisional kita berhasil menyabet podium utama di ajang nasional.', '<p>Prestasi membanggakan kembali diukir oleh atlet olahraga rekreasi Kabupaten Bandung pada ajang Kejuaraan Tingkat Nasional. Delegasi berhasil membawa pulang medali emas setelah unggul di kategori ketangkasan dan olahraga tradisional.</p>', 'https://images.unsplash.com/photo-1526676023641-72e042776856?q=80&w=800', NULL, 870, 0, 'published', '2026-09-04 17:48:37', '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44265-2390-4c2a-ab42-a1df2ff697d5', 'a2b44265-2120-4071-97be-641126cd0040', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'Senam Massal Bedas di Soreang: Ribuan Warga Turut Memeriahkan', 'senam-massal-bedas-di-soreang-ribuan-warga-turut-memeriahkan', 'Peningkatan indeks kebugaran masyarakat menjadi target utama dalam kegiatan rutin mingguan ini yang diikuti ribuan peserta.', '<p>Ribuan warga memadati area Lapangan Upakarti Soreang untuk mengikuti Senam Massal Bedas. Kegiatan ini merupakan bagian dari gerakan pembudayaan olahraga yang digelorakan KORMI bekerjasama dengan ASIAFI dan STI.</p>', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800', NULL, 1520, 0, 'published', '2026-09-01 17:48:37', '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44265-23bd-4219-b812-70a3f1acd15d', 'a2b44265-2145-4030-8a75-939e52cfbb06', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'Audiensi KORMI Bersama Bupati Bandung Bahas Masa Depan Olahraga', 'audiensi-kormi-bersama-bupati-bandung-bahas-masa-depan-olahraga', 'Pertemuan strategis untuk memperkuat dukungan pemerintah daerah terhadap olahraga rekreasi masyarakat.', '<p>Jajaran pengurus KORMI Kabupaten Bandung diterima langsung oleh Bupati Bandung di Rumah Dinas Soreang. Pertemuan ini membahas rencana penguatan infrastruktur olahraga masyarakat serta pendukungan anggaran untuk pembinaan 31 kecamatan.</p>', 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=800', NULL, 960, 0, 'published', '2026-08-30 17:48:37', '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44265-23e2-4d25-a079-74053f9054e1', 'a2b44265-216a-4c90-a7ba-71eced6f39c5', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'Pelatihan Pelatih Olahraga Tradisional Tingkat Kabupaten Bandung', 'pelatihan-pelatih-olahraga-tradisional-tingkat-kabupaten-bandung', 'Mencetak instruktur yang kompeten untuk melestarikan budaya olahraga asli daerah di setiap kecamatan.', '<p>Sebanyak 60 calon pelatih olahraga tradisional mengikuti sertifikasi dan bimbingan teknis PORTINA untuk meningkatkan standar perwasitan dan kepelatihan egrang, terompah panjang, dan hadang.</p>', 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', NULL, 640, 0, 'published', '2026-08-28 17:48:37', '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44265-2403-457a-bdcd-011273d7a16d', 'a2b44265-21a4-4ac4-9ada-3b2d8fea751d', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'Bakti Sosial KORMI Berbagi: Sehat Raganya, Bahagia Jiwanya', 'bakti-sosial-kormi-berbagi-sehat-raganya-bahagia-jiwanya', 'Kegiatan kolaboratif antara olahraga dan kepedulian sosial di wilayah terdampak bencana alam.', '<p>KORMI menyalurkan bantuan paket logistik sekaligus mengadakan terapi senam bugar untuk warga terdampak di wilayah Kabupaten Bandung selatan.</p>', 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800', NULL, 510, 0, 'published', '2026-08-25 17:48:37', '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44265-241f-49e8-97c8-429f63c063b4', 'a2b44265-20c9-4c44-9637-c506a95ad312', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'Bandung Bedas Run 2026: Pendaftaran Resmi Dibuka!', 'bandung-bedas-run-2026-pendaftaran-resmi-dibuka', 'Event lari terbesar di Kabupaten Bandung kembali hadir. Segera daftarkan diri Anda dan raihlah pengalaman berlari terbaik.', '<p>Pendaftaran Bandung Bedas Run 2026 kategori 5K dan 10K resmi dibuka. Rute akan melintasi ikon-ikon pariwisata Soreang dan Stadion Si Jalak Harupat.</p>', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', NULL, 2100, 0, 'published', '2026-08-22 17:48:37', '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44265-243b-40da-afd1-19760f7dad80', 'a2b44265-20fc-4961-a5b8-7c8e4e2e8b08', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'Kecamatan Margahayu Juara Umum FOTRADKAB 2025', 'kecamatan-margahayu-juara-umum-fotradkab-2025', 'Dengan perolehan 10 emas, 6 perak, dan 4 perunggu, Margahayu keluar sebagai juara umum FOTRADKAB tahun ini.', '<p>Dominasi kontingen Margahayu di cabang hadang dan ketapel berhasil mengantarkan mereka mengukuhkan gelar Juara Umum FOTRADKAB.</p>', 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800', NULL, 1180, 0, 'published', '2026-08-20 17:48:37', '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44566-8860-4398-88e9-d93cf5c1bd93', 'a2b44566-8775-45e4-bc25-2c6ca073621c', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'Persiapan Menuju FORKAB 2026: Rapat Koordinasi Wilayah', 'persiapan-menuju-forkab-2026-rapat-koordinasi-wilayah', 'KORMI Kabupaten Bandung melakukan sinkronisasi program kerja bersama seluruh pengurus kecamatan untuk mempersiapkan FORKAB 2026 yang akan segera diselenggarakan.', '<p>KORMI Kabupaten Bandung menyelenggarakan rapat koordinasi wilayah untuk mematangkan kesiapan pelaksanaan Festival Olahraga Rekreasi Masyarakat Kabupaten (FORKAB) 2026. Pertemuan yang dihadiri oleh seluruh koordinator kecamatan dan pimpinan induk organisasi olahraga (INORGA) ini bertujuan menyelaraskan teknis perlombaan dan kesiapan kontingen dari 31 kecamatan.</p><p>Ketua KORMI Kabupaten Bandung menyampaikan bahwa FORKAB tahun ini akan mengusung semangat kolaborasi dan kebugaran inklusif untuk seluruh lapisan masyarakat Kabupaten Bandung.</p>', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 1240, 1, 'published', '2026-09-07 10:57:01', '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b44566-888e-41c2-b2f9-0cde3deba72f', 'a2b44566-8799-40e1-929d-be62a36ab8de', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'Atlet Inorga Kabupaten Bandung Raih Emas di Kejuaraan Nasional', 'atlet-inorga-kabupaten-bandung-raih-emas-di-kejuaraan-nasional', 'Kebanggaan bagi warga Bandung, perwakilan atlet tradisional kita berhasil menyabet podium utama di ajang nasional.', '<p>Prestasi membanggakan kembali diukir oleh atlet olahraga rekreasi Kabupaten Bandung pada ajang Kejuaraan Tingkat Nasional. Delegasi berhasil membawa pulang medali emas setelah unggul di kategori ketangkasan dan olahraga tradisional.</p>', 'https://images.unsplash.com/photo-1526676023641-72e042776856?q=80&w=800', NULL, 870, 0, 'published', '2026-09-04 10:57:01', '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b44566-88ae-458b-899b-8e1ee8ac0eb7', 'a2b44566-87b4-4895-91c4-9e5673088002', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'Senam Massal Bedas di Soreang: Ribuan Warga Turut Memeriahkan', 'senam-massal-bedas-di-soreang-ribuan-warga-turut-memeriahkan', 'Peningkatan indeks kebugaran masyarakat menjadi target utama dalam kegiatan rutin mingguan ini yang diikuti ribuan peserta.', '<p>Ribuan warga memadati area Lapangan Upakarti Soreang untuk mengikuti Senam Massal Bedas. Kegiatan ini merupakan bagian dari gerakan pembudayaan olahraga yang digelorakan KORMI bekerjasama dengan ASIAFI dan STI.</p>', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800', NULL, 1520, 0, 'published', '2026-09-01 10:57:01', '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b44566-890c-448e-b124-a59b59049bc6', 'a2b44566-87cc-475a-8ff2-2f6e3b844daa', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'Audiensi KORMI Bersama Bupati Bandung Bahas Masa Depan Olahraga', 'audiensi-kormi-bersama-bupati-bandung-bahas-masa-depan-olahraga', 'Pertemuan strategis untuk memperkuat dukungan pemerintah daerah terhadap olahraga rekreasi masyarakat.', '<p>Jajaran pengurus KORMI Kabupaten Bandung diterima langsung oleh Bupati Bandung di Rumah Dinas Soreang. Pertemuan ini membahas rencana penguatan infrastruktur olahraga masyarakat serta pendukungan anggaran untuk pembinaan 31 kecamatan.</p>', 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=800', NULL, 960, 0, 'published', '2026-08-30 10:57:01', '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b44566-892f-4324-b02a-6147f8c9fc54', 'a2b44566-87e1-49a5-a6f7-faa05d872e9b', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'Pelatihan Pelatih Olahraga Tradisional Tingkat Kabupaten Bandung', 'pelatihan-pelatih-olahraga-tradisional-tingkat-kabupaten-bandung', 'Mencetak instruktur yang kompeten untuk melestarikan budaya olahraga asli daerah di setiap kecamatan.', '<p>Sebanyak 60 calon pelatih olahraga tradisional mengikuti sertifikasi dan bimbingan teknis PORTINA untuk meningkatkan standar perwasitan dan kepelatihan egrang, terompah panjang, dan hadang.</p>', 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', NULL, 640, 0, 'published', '2026-08-28 10:57:01', '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b44566-89a2-4b21-8716-4946e4d14e97', 'a2b44566-87f7-48ad-95e6-a480386b5b0d', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'Bakti Sosial KORMI Berbagi: Sehat Raganya, Bahagia Jiwanya', 'bakti-sosial-kormi-berbagi-sehat-raganya-bahagia-jiwanya', 'Kegiatan kolaboratif antara olahraga dan kepedulian sosial di wilayah terdampak bencana alam.', '<p>KORMI menyalurkan bantuan paket logistik sekaligus mengadakan terapi senam bugar untuk warga terdampak di wilayah Kabupaten Bandung selatan.</p>', 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800', NULL, 510, 0, 'published', '2026-08-25 10:57:01', '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b44566-89e5-4c6a-bcd0-7ab03e6ab41d', 'a2b44566-8775-45e4-bc25-2c6ca073621c', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'Bandung Bedas Run 2026: Pendaftaran Resmi Dibuka!', 'bandung-bedas-run-2026-pendaftaran-resmi-dibuka', 'Event lari terbesar di Kabupaten Bandung kembali hadir. Segera daftarkan diri Anda dan raihlah pengalaman berlari terbaik.', '<p>Pendaftaran Bandung Bedas Run 2026 kategori 5K dan 10K resmi dibuka. Rute akan melintasi ikon-ikon pariwisata Soreang dan Stadion Si Jalak Harupat.</p>', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', NULL, 2100, 0, 'published', '2026-08-22 10:57:01', '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b44566-8a02-4686-9bf3-18836f2d2c21', 'a2b44566-8799-40e1-929d-be62a36ab8de', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'Kecamatan Margahayu Juara Umum FOTRADKAB 2025', 'kecamatan-margahayu-juara-umum-fotradkab-2025', 'Dengan perolehan 10 emas, 6 perak, dan 4 perunggu, Margahayu keluar sebagai juara umum FOTRADKAB tahun ini.', '<p>Dominasi kontingen Margahayu di cabang hadang dan ketapel berhasil mengantarkan mereka mengukuhkan gelar Juara Umum FOTRADKAB.</p>', 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800', NULL, 1180, 0, 'published', '2026-08-20 10:57:01', '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b445c7-a185-4afb-8b13-2de783ff8e80', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Berita Uji Coba KORMI 2026 Updated', 'berita-uji-coba-kormi-2026-337', 'Ringkasan berita uji coba', 'Konten detail uji coba berita kormi', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 0, 0, 'published', '2026-09-09 10:58:05', '2026-09-09 10:58:05', '2026-09-09 10:58:05', '2026-09-09 10:58:05'),
  ('a2b445d5-1245-4be4-aae1-2bd68b14eb61', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Berita Uji Coba KORMI 2026 Updated', 'berita-uji-coba-kormi-2026-856', 'Ringkasan berita uji coba', 'Konten detail uji coba berita kormi', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 0, 0, 'published', '2026-09-09 10:58:14', '2026-09-09 10:58:14', '2026-09-09 10:58:14', '2026-09-09 10:58:14'),
  ('a2b447b3-e168-4393-af56-6a6c9531c628', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Berita Uji Coba KORMI 2026 Updated', 'berita-uji-coba-kormi-2026-568', 'Ringkasan berita uji coba', 'Konten detail uji coba berita kormi', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 0, 0, 'published', '2026-09-09 11:03:27', '2026-09-09 11:03:27', '2026-09-09 11:03:27', '2026-09-09 11:03:27'),
  ('a2b44810-af45-43f7-a54d-8edbbc0751d6', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Berita Uji Coba KORMI 2026 Updated', 'berita-uji-coba-kormi-2026-576', 'Ringkasan berita uji coba', 'Konten detail uji coba berita kormi', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 0, 0, 'published', '2026-09-09 11:04:28', '2026-09-09 11:04:28', '2026-09-09 11:04:28', '2026-09-09 11:04:28'),
  ('a2b4487b-1b93-4a51-bb3f-76b2db04de0b', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Berita Uji Coba KORMI 2026 Updated', 'berita-uji-coba-kormi-2026-438', 'Ringkasan berita uji coba', 'Konten detail uji coba berita kormi', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 0, 0, 'published', '2026-09-09 11:05:38', '2026-09-09 11:05:38', '2026-09-09 11:05:38', '2026-09-09 11:05:38'),
  ('a2b448a2-900c-4a18-abb8-4b23a0b6a341', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Berita Uji Coba KORMI 2026 Updated', 'berita-uji-coba-kormi-2026-792', 'Ringkasan berita uji coba', 'Konten detail uji coba berita kormi', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 0, 0, 'published', '2026-09-09 11:06:04', '2026-09-09 11:06:04', '2026-09-09 11:06:04', '2026-09-09 11:06:04'),
  ('a2b448f3-eb0f-46ff-9ede-2d71b3eb1cd2', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Berita Uji Coba KORMI 2026 Updated', 'berita-uji-coba-kormi-2026-651', 'Ringkasan berita uji coba', 'Konten detail uji coba berita kormi', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 0, 0, 'published', '2026-09-09 11:06:57', '2026-09-09 11:06:57', '2026-09-09 11:06:57', '2026-09-09 11:06:57'),
  ('a2b449ba-80e6-4708-a84e-38a7d0b97bec', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Berita Uji Coba KORMI 2026 Updated', 'berita-uji-coba-kormi-2026-542', 'Ringkasan berita uji coba', 'Konten detail uji coba berita kormi', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 0, 0, 'published', '2026-09-09 11:09:07', '2026-09-09 11:09:07', '2026-09-09 11:09:07', '2026-09-09 11:09:07'),
  ('a2b449fd-4948-4575-a130-ac1f7cf7583b', 'a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Berita Uji Coba KORMI 2026 Updated', 'berita-uji-coba-kormi-2026-378', 'Ringkasan berita uji coba', 'Konten detail uji coba berita kormi', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 0, 0, 'published', '2026-09-09 11:09:51', '2026-09-09 11:09:51', '2026-09-09 11:09:51', '2026-09-09 11:09:51');

-- --------------------------------------------------------
-- Table structure for `kormi_desa_kelurahan`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_desa_kelurahan`;
CREATE TABLE `kormi_desa_kelurahan` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_desa_kelurahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'desa',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_desa_kelurahan`
INSERT INTO `kormi_desa_kelurahan` (`id`, `kecamatan_id`, `nama_desa_kelurahan`, `slug`, `jenis`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-258c-493b-8d3b-c9c374608912', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'Patrolsari', 'patrolsari', 'desa', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-25f0-4daa-b1aa-0655e97d88e4', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'Pinggirsari', 'pinggirsari', 'desa', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-263b-47d3-b85f-45e4fd2e0c40', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'Rancakole', 'rancakole', 'desa', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2684-4f38-b04b-10a35d0e0253', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'Wargaluyu', 'wargaluyu', 'desa', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-26cd-440f-8453-11ba7d7399b9', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Andir', 'andir', 'desa', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2748-4b88-8c45-b049ded94905', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Baleendah', 'baleendah', 'desa', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2796-4020-b7d1-f72a1d337f63', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Bojongmalaka', 'bojongmalaka', 'desa', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-27fd-4c5f-8b57-9761453ab603', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Jelekong', 'jelekong', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2842-43ba-aa74-6af18baa0671', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Malakasari', 'malakasari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-288a-440c-8c82-8ce4669cb1ce', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Manggahang', 'manggahang', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-28d2-4023-a01d-c995fb42dad6', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Rancamanyar', 'rancamanyar', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-292e-449c-9711-e1c02f6fd5c4', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Wargamekar', 'wargamekar', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2998-426b-9a7a-a83acfbd54d4', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Banjaran Kulon', 'banjaran-kulon', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2a25-47e6-a137-c2822882e992', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Banjaran Wetan', 'banjaran-wetan', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2ad8-4a07-aa62-be3e441563a2', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Ciapus', 'ciapus', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2b94-4faa-b312-300672687259', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Kamasan', 'kamasan', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2bf1-4068-a648-77d7cef9a702', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Kiangroke', 'kiangroke', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2c47-4ce9-a4dc-16c28241e2cd', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Margahurip', 'margahurip', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2c8f-47c8-9cdc-689525ccea2c', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Mekarjaya', 'mekarjaya', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2cd6-4d9b-ada2-7a0066916d25', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Neglasari', 'neglasari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2d24-4b97-9a21-b9c0d5ca8fad', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Pasirmulya', 'pasirmulya', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2d92-45cb-9721-b0c79f999d69', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Sindangpanon', 'sindangpanon', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2de5-48d6-9cdf-cffb8f4f5fa7', 'a2b40c67-202d-4b46-9992-de88e8468387', 'Tarajusari', 'tarajusari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2e3d-4d94-a2ac-54e61919c237', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'Bojongsari', 'bojongsari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2eb9-417a-8d58-b9762ff619ab', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'Bojongsoang', 'bojongsoang', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2f04-486e-80fd-730341ac9f1f', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'Buahbatu', 'buahbatu', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2f5f-4018-8db9-74a572abc36e', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'Cipagalo', 'cipagalo', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2fc9-439a-88ef-85f80160eee3', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'Lengkong', 'lengkong', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3049-4009-83c1-a843f0a2f6c0', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'Tegalluar', 'tegalluar', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-309a-4148-bb25-0aca224aadf0', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'Bandasari', 'bandasari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-30e9-4c07-981e-e96c81d177b2', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'Ciluncat', 'ciluncat', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3135-4eeb-a08c-626badec2b8e', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'Jatisari', 'jatisari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-318c-4f63-b27d-41e2d61b52f0', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'Nagrak', 'nagrak', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-31ea-4c46-b7a9-74dcec331fee', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'Pananjung', 'pananjung', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-326e-46fa-9534-81d40d19884a', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'Tanjungsari', 'tanjungsari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-32ea-4a58-9de9-da92bde2eb26', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'Cangkuang', 'cangkuang', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-333e-46d7-80f1-582317748a70', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Babakan Peuteuy', 'babakan-peuteuy', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-33a7-4eb8-a407-7b2b193fe198', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Cicalengka Kulon', 'cicalengka-kulon', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-340d-48f0-bfbb-c2dd5bd5ef56', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Cicalengka Wetan', 'cicalengka-wetan', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3479-476f-bb0c-2d780c3698fb', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Cikuya', 'cikuya', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-34e4-42b7-93ef-0d3351e5bb51', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Dampit', 'dampit', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-352e-43b4-bbb9-68af4e0d99a0', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Margaasih', 'margaasih', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3586-471b-afe8-0372f65ecab3', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Nagrog', 'nagrog', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-35d3-4dff-9a1d-ab40a82426a9', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Narawita', 'narawita', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3626-4c8b-a7d4-864d57dc4412', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Penenjoan', 'penenjoan', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3681-48f2-8e86-e7608b288ee3', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Tanjung Wangi', 'tanjung-wangi', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3790-45f3-af38-53ba0dd56c0a', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Tenjolaya', 'tenjolaya', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-37e4-4a27-9425-c8b7e7978c9b', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'Waluya', 'waluya', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3834-4cfb-a022-b9d9e0fd11ef', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'Cihanyir', 'cihanyir', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-38ec-4053-a714-37de31665a8c', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'Cikancung', 'cikancung', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39');
INSERT INTO `kormi_desa_kelurahan` (`id`, `kecamatan_id`, `nama_desa_kelurahan`, `slug`, `jenis`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-393b-4a7f-95af-185e0b9e056b', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'Cikasungka', 'cikasungka', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-398a-4aff-8aa0-e92d560ce6ad', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'Ciluluk', 'ciluluk', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3a0a-4ecd-a712-3d2590064e79', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'Hegarmanah', 'hegarmanah', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3a71-46d7-a893-dac28a81f941', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'Mandalasari', 'mandalasari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3adb-4f09-b5b3-1df739302bab', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'Mekarlaksana', 'mekarlaksana', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3b48-4261-b4a9-dd58b2fbce9c', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'Srirahayu', 'srirahayu', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3bbf-4ee5-b220-441195720d37', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'Tanjunglaya', 'tanjunglaya', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3c8a-4642-8755-c161c3b2d463', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'Cilengkrang', 'cilengkrang', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3d18-4aea-9e6a-3296cca1b03a', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'Cipanjalu', 'cipanjalu', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3de7-4f0d-97d5-98171f147c51', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'Ciporeat', 'ciporeat', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3e50-40f7-b6bc-d9bfa810a6cf', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'Girimekar', 'girimekar', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3ea1-454f-a3ff-c93dc93bb3e8', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'Jatiendah', 'jatiendah', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3ef9-4c48-b27b-c65ab09b532f', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'Melatiwangi', 'melatiwangi', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3f6b-4ac1-ad54-8d059f9d79d8', 'a2b40c67-2135-481e-97b8-592488466ec6', 'Cibiru Hilir', 'cibiru-hilir', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3fd1-44b0-bb50-6be302aaa134', 'a2b40c67-2135-481e-97b8-592488466ec6', 'Cibiru Wetan', 'cibiru-wetan', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-402d-472a-8d78-4f8b35975c52', 'a2b40c67-2135-481e-97b8-592488466ec6', 'Cileunyi Kulon', 'cileunyi-kulon', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-407d-4dae-b87a-eca582496f18', 'a2b40c67-2135-481e-97b8-592488466ec6', 'Cileunyi Wetan', 'cileunyi-wetan', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-40c9-4927-8807-e5ae0adfc690', 'a2b40c67-2135-481e-97b8-592488466ec6', 'Cimekar', 'cimekar', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4165-4faf-b4ce-42af75a257b7', 'a2b40c67-2135-481e-97b8-592488466ec6', 'Cinunuk', 'cinunuk', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-41bf-4dcc-9813-d24172d7c960', 'a2b40c67-2163-4d41-b380-13297da90a64', 'Campakamulya', 'campakamulya', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4224-486f-abf2-2ac280139a86', 'a2b40c67-2163-4d41-b380-13297da90a64', 'Cikalong', 'cikalong', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-428a-4727-8122-74bc9037f844', 'a2b40c67-2163-4d41-b380-13297da90a64', 'Cimaung', 'cimaung', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-42ec-47a4-97d1-d9250554a641', 'a2b40c67-2163-4d41-b380-13297da90a64', 'Cipinang', 'cipinang', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4349-4bec-ab6b-0d670476f0e6', 'a2b40c67-2163-4d41-b380-13297da90a64', 'Jagabaya', 'jagabaya', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-43ad-4b65-801d-9d77826118c7', 'a2b40c67-2163-4d41-b380-13297da90a64', 'Malasari', 'malasari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4418-4fb5-bc84-ea935e42b0b5', 'a2b40c67-2163-4d41-b380-13297da90a64', 'Mekarsari', 'mekarsari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4477-4a9b-aeab-26af4d3057b0', 'a2b40c67-2163-4d41-b380-13297da90a64', 'Pasirhuni', 'pasirhuni', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-44cc-45c6-bd0f-ffd924e16c89', 'a2b40c67-2163-4d41-b380-13297da90a64', 'Sukamaju', 'sukamaju', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4519-4584-99e0-c6fd8c378a4d', 'a2b40c67-2163-4d41-b380-13297da90a64', 'Warjabakti', 'warjabakti', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4597-4fb8-9451-3e83aefa014e', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'Cibeunying', 'cibeunying', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-45f0-4423-8015-e61a0ac03abd', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'Ciburial', 'ciburial', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-463c-4130-817a-2d00d7a7e121', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'Cikadut', 'cikadut', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-46b0-4aec-906d-cd4f1b91dc9b', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'Cimenyan', 'cimenyan', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-46fe-4419-afc3-ae524de69140', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'Mandalamekar', 'mandalamekar', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-474b-487e-a620-b7945bbe05a2', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'Mekarmanik', 'mekarmanik', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4797-4af1-bbf1-97326bc33507', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'Mekarsaluyu', 'mekarsaluyu', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-47e5-4cf0-9d99-e67a775aaa6e', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'Padasuka', 'padasuka', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4832-4407-bcb4-1d4f5533421a', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'Sindanglaya', 'sindanglaya', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-487c-410c-9a56-adf3ffa706d6', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Babakan', 'babakan', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-48de-4ef8-ab0c-74c7ae164227', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Bumiwangi', 'bumiwangi', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-492a-46b6-b1b7-9c78711d3a4d', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Ciheulang', 'ciheulang', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-497f-45f6-98af-d9a61da7650f', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Cikoneng', 'cikoneng', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-49d6-415a-8dbe-838b9cb05be0', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Ciparay', 'ciparay', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4a24-4fc2-83b3-c53a215819ef', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Gunungleutik', 'gunungleutik', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4a75-4cc8-b82f-1a9f36ce9bae', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Mangunraharja', 'mangunraharja', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4ac2-40a8-9094-d1150445be87', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Mekarlaksana', 'mekarlaksana', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4b3a-4ee0-bf67-a698d95244e5', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Mekarsari', 'mekarsari', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4b8e-44f0-98fc-9095afc44120', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Pakutandang', 'pakutandang', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4bfa-48c5-843e-ed9f2b5e2c7a', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Sagaracipta', 'sagaracipta', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4c69-4472-991d-499c3dba90cd', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Sarimahi', 'sarimahi', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39');
INSERT INTO `kormi_desa_kelurahan` (`id`, `kecamatan_id`, `nama_desa_kelurahan`, `slug`, `jenis`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-4cba-4353-a406-9538421c84ac', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Serangmekar', 'serangmekar', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4d1f-4d31-9df9-5c2441aa6039', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Soreang', 'soreang', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4d79-4035-b614-899ce16db766', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Sekarwangi', 'sekarwangi', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4df4-4349-af94-90c65d75a418', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Panyirapan', 'panyirapan', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4e45-4eaf-835b-d011a5ffb132', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Sadu', 'sadu', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4ea2-4b45-9ad5-457598f9c2f2', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Cingcin', 'cingcin', 'desa', '2026-09-09 22:17:39', '2026-09-09 22:17:39');

-- --------------------------------------------------------
-- Table structure for `kormi_duta_olahraga`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_duta_olahraga`;
CREATE TABLE `kormi_duta_olahraga` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `desa_kelurahan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_pemilihan` bigint NOT NULL DEFAULT '2026',
  `kategori_duta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Duta Olahraga Masyarakat',
  `gelar_prestasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_prestasi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `akun_instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_unggulan` bigint NOT NULL DEFAULT '0',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_duta_olahraga`
INSERT INTO `kormi_duta_olahraga` (`id`, `kecamatan_id`, `desa_kelurahan_id`, `nama_lengkap`, `tahun_pemilihan`, `kategori_duta`, `gelar_prestasi`, `deskripsi_prestasi`, `akun_instagram`, `foto_url`, `status_unggulan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-25c8-48a6-b5be-4bf32f5302bc', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-258c-493b-8d3b-c9c374608912', 'Egi Septiana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2616-4327-8806-a025ea2f34d2', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-25f0-4daa-b1aa-0655e97d88e4', 'Khaeru Ahmad Rifaldi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2660-4ba2-b99c-a8e9350cb2a4', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-263b-47d3-b85f-45e4fd2e0c40', 'Dodi Juliana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-26a8-4dd7-a091-4014d8abcbb7', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-2684-4f38-b04b-10a35d0e0253', 'Zam Zam Fitrah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2713-4532-a113-4094a2cb3a88', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-26cd-440f-8453-11ba7d7399b9', 'Andi Mohamad Fauzi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2770-48ea-b31c-225026abb1d7', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-2748-4b88-8c45-b049ded94905', 'Aminnur Dwi Ariyanti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-27b9-4850-811c-631e7509cb9a', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-2796-4020-b7d1-f72a1d337f63', 'Fauzy Rahman Rukmana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2820-40b3-b6cf-5a6cd5e21aa9', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-27fd-4c5f-8b57-9761453ab603', 'Ginanjar Teguh Sagara, S.Pd', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2867-4299-b292-6e28202e0ee2', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-2842-43ba-aa74-6af18baa0671', 'Darmawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-28ad-4d4c-8a3c-0e980417a2aa', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-288a-440c-8c82-8ce4669cb1ce', 'Kania Sri Sucy Widara', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2906-4b59-889a-d86ec3198c8d', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-28d2-4023-a01d-c995fb42dad6', 'Asep Supriatna', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2957-4141-93cc-b16870afa463', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-292e-449c-9711-e1c02f6fd5c4', 'Rini Ridayanti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-29e6-483d-babf-ddf9f1bfa368', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2998-426b-9a7a-a83acfbd54d4', 'Puri Aulia Salsabila', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2a90-4071-aaf5-01540bcacadb', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2a25-47e6-a137-c2822882e992', 'Reza Miptah Dinulloh', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2b14-44ac-a2de-08092670717c', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2ad8-4a07-aa62-be3e441563a2', 'Aulia Rahmi Nur Fajriyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2bcc-434d-bfd2-2042593d6cf4', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2b94-4faa-b312-300672687259', 'Muhammad', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2c22-4e3f-a352-02832f2c7517', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2bf1-4068-a648-77d7cef9a702', 'Shofwan Zaini', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2c6b-4dc1-a47d-22ee50179bfb', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2c47-4ce9-a4dc-16c28241e2cd', 'Nurdiyana Firmansyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2cb1-4304-b752-835cf309f84c', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2c8f-47c8-9cdc-689525ccea2c', 'Nizar Rayhan Nur Rakhmat', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2cfb-4628-a5aa-351d1ab70693', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2cd6-4d9b-ada2-7a0066916d25', 'Aziz Ali Nurrochman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2d67-4287-8b69-8807c2fd664d', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2d24-4b97-9a21-b9c0d5ca8fad', 'Dinda Amalia Nur Fauziah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2db8-48e9-994c-7ed1f4b36f9a', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2d92-45cb-9721-b0c79f999d69', 'Tiara Shinta Dewi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2e16-4bbf-a226-26a31fc3892d', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2de5-48d6-9cdf-cffb8f4f5fa7', 'Arul Fadyah Dzulpaqor', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2e6f-42f3-85da-34f630849e2d', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2e3d-4d94-a2ac-54e61919c237', 'Lulurisma', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2edc-4f87-84f0-312a9ff97311', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2eb9-417a-8d58-b9762ff619ab', 'Frischha Dewi Octavia', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2f38-4b5c-bad1-e003bfeefa11', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2f04-486e-80fd-730341ac9f1f', 'Vian', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-2f92-4d75-a2ec-f9cc34913665', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2f5f-4018-8db9-74a572abc36e', 'Deyra Hylmy Yahya', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3018-4f8f-ab4b-944ce1745afe', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2fc9-439a-88ef-85f80160eee3', 'Sanif Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3071-435d-a903-1698b71e389b', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-3049-4009-83c1-a843f0a2f6c0', 'Syabina Fatwa Azzahra', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-30c0-444c-8c63-190900069745', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-309a-4148-bb25-0aca224aadf0', 'Nugie Herdiansyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-310d-4e8e-bf2c-3da6d4a0919a', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-30e9-4c07-981e-e96c81d177b2', 'Rahma Safitri', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3161-4040-b68f-2346fdcd404f', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-3135-4eeb-a08c-626badec2b8e', 'Dian Heryanto', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-31bc-40b0-8356-a28c70811a17', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-318c-4f63-b27d-41e2d61b52f0', 'Rissa Rosiana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3238-48c9-b60c-e4da5ea5da35', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-31ea-4c46-b7a9-74dcec331fee', 'Deden Gunawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-329e-4db5-b7d7-e8a25f686925', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-326e-46fa-9534-81d40d19884a', 'Jaka Nursahid', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3316-46e9-9787-8940e46e8d7b', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-32ea-4a58-9de9-da92bde2eb26', 'Irma Asmarani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-336a-44f3-b050-bec8edd629e4', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-333e-46d7-80f1-582317748a70', 'Ahmad Fahmi Faisal', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-33d2-4836-8545-9fa317822e7f', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-33a7-4eb8-a407-7b2b193fe198', 'Muhammad Fajar Nuriman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3433-49c7-861f-de003237f660', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-340d-48f0-bfbb-c2dd5bd5ef56', 'Seril Rizka D Laela', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-34a8-43e7-8c6f-ac9b85efc9e9', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3479-476f-bb0c-2d780c3698fb', 'Purnama Pramuditha', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3509-40b7-8289-e59de43d22f8', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-34e4-42b7-93ef-0d3351e5bb51', 'Galuh Hardianti Khoeriyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3552-4847-82b0-408659662fd3', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-352e-43b4-bbb9-68af4e0d99a0', 'Fikri Padilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-35ab-4535-84c1-f01f61c69bf2', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3586-471b-afe8-0372f65ecab3', 'Erisya Nurul Fauzia', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-35fd-436c-8e23-726c4efac770', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-35d3-4dff-9a1d-ab40a82426a9', 'Vianti Putri Lestari', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3651-4baf-8e93-946b751bdb1c', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3626-4c8b-a7d4-864d57dc4412', 'Ilham Nurzaman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-36ae-49b6-9805-0f6fdf21dc58', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3681-48f2-8e86-e7608b288ee3', 'Muhamad Rukhiat Sofia Ramdani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-37b9-445c-a23f-0ff4124eb4df', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3790-45f3-af38-53ba0dd56c0a', 'Mohammad Nabil Fadilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-380c-414d-8eb9-03f27e483e69', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-37e4-4a27-9425-c8b7e7978c9b', 'Annisa Maulidasawa', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-385b-40d3-9cca-137410384eb2', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3834-4cfb-a022-b9d9e0fd11ef', 'Putri Widia Ramdani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3913-4139-b473-67789d9e60f3', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-38ec-4053-a714-37de31665a8c', 'Muhamad Ridwan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39');
INSERT INTO `kormi_duta_olahraga` (`id`, `kecamatan_id`, `desa_kelurahan_id`, `nama_lengkap`, `tahun_pemilihan`, `kategori_duta`, `gelar_prestasi`, `deskripsi_prestasi`, `akun_instagram`, `foto_url`, `status_unggulan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-3960-460b-a237-7e9f512da89d', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-393b-4a7f-95af-185e0b9e056b', 'Rilvan Fadilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-39b3-4d6b-9c99-517983cbb57c', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-398a-4aff-8aa0-e92d560ce6ad', 'Dinar Fitranti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3a37-4882-891c-115d49e04bc5', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3a0a-4ecd-a712-3d2590064e79', 'Hera Iyadatul Fauziah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3a9b-4dcf-8e2e-7b7364298273', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3a71-46d7-a893-dac28a81f941', 'Yuda Maulana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3b02-4a88-ad60-25dca1ce1a0a', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3adb-4f09-b5b3-1df739302bab', 'Syafitri Nurpadilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3b79-4250-bd9e-8d48d7e3119d', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3b48-4261-b4a9-dd58b2fbce9c', 'Bagas Saparudin', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3c28-4add-9a8c-7b38a36b000e', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3bbf-4ee5-b220-441195720d37', 'Siti Ulfa Hasanatun Nur Wahida., S.H', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3cd5-4c17-b25c-fb06324f99ca', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3c8a-4642-8755-c161c3b2d463', 'Nurkholis Majid', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3d97-4693-a217-be2076bb8275', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3d18-4aea-9e6a-3296cca1b03a', 'Imas Marwati', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3e13-4223-87f8-8b8b7431ec3f', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3de7-4f0d-97d5-98171f147c51', 'Wahyu Wahyudin', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3e7a-48db-9bf3-971b88be0109', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3e50-40f7-b6bc-d9bfa810a6cf', 'Deaneira Choirunnisa Tedyaputri', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3ed3-46cd-86d9-dc92fb62eb91', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3ea1-454f-a3ff-c93dc93bb3e8', 'Wandi Suwanda', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3f2b-4353-ae69-97398de233fa', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3ef9-4c48-b27b-c65ab09b532f', 'Rizky Marwan Sarwana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3f93-4bbf-abfc-2aff03360182', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-3f6b-4ac1-ad54-8d059f9d79d8', 'Taufik Hidayat', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-3ff9-4ff3-98b8-8e44ac062c17', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-3fd1-44b0-bb50-6be302aaa134', 'Muhammad Rayhan Fauzi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4055-4ca2-b152-0b2780b55fdb', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-402d-472a-8d78-4f8b35975c52', 'Ajang', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-40a1-452b-ac75-d47424257c90', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-407d-4dae-b87a-eca582496f18', 'Irawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4114-4a60-bd33-5ae002bc706b', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-40c9-4927-8807-e5ae0adfc690', 'Sindy Oktaviani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4193-4c6b-8443-b1bd960ce4c4', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-4165-4faf-b4ce-42af75a257b7', 'Iis Isnia Rhobiati', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-41e2-49c2-a5f1-bd8d23512ae9', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-41bf-4dcc-9813-d24172d7c960', 'Fitria Nur Aisyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4257-4400-b0c6-9e6137f3cee9', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4224-486f-abf2-2ac280139a86', 'Erlina Nuranjani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-42c4-4253-815d-278c44381d7b', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-428a-4727-8122-74bc9037f844', 'Boyke Dwi Septiadi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-431e-448c-b353-c908722a474b', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-42ec-47a4-97d1-d9250554a641', 'Asti Apriyanti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4384-4a74-97a8-5ceafc2153f7', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4349-4bec-ab6b-0d670476f0e6', 'Taupik Tarisman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-43e3-4bf6-9232-28dc7426b3de', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-43ad-4b65-801d-9d77826118c7', 'Yoga Dwiswara', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-443f-4416-a200-330961dfc486', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4418-4fb5-bc84-ea935e42b0b5', 'Muhamad Yusup', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-44a2-4c44-b754-d69230b50d59', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4477-4a9b-aeab-26af4d3057b0', 'Tian Fauzi Agustien', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-44f1-42ef-b63e-3de7b020e5d7', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-44cc-45c6-bd0f-ffd924e16c89', 'Dewita Yunika Sabila', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-456c-412a-b8e8-fcd5913dd684', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4519-4584-99e0-c6fd8c378a4d', 'Ninda Nurazzizah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-45c6-4b7b-ba69-8aa3453705a7', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-4597-4fb8-9451-3e83aefa014e', 'Melly Noviany', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4614-42ab-bd98-a5880cb0d8fd', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-45f0-4423-8015-e61a0ac03abd', 'Arie Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-467a-4f46-82df-2fecba04b963', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-463c-4130-817a-2d00d7a7e121', 'Abdulhafizh Almubarok', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-46d6-4284-bc1c-2e88c97f4a08', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-46b0-4aec-906d-cd4f1b91dc9b', 'Novel Mulyani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4724-4fba-98c1-2de3588bc09a', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-46fe-4419-afc3-ae524de69140', 'Iwan Nugraha', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-476e-43ca-aba9-c509c9b65a1c', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-474b-487e-a620-b7945bbe05a2', 'Repan Eka Putra', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-47bc-4cdf-8547-b11540a9a743', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-4797-4af1-bbf1-97326bc33507', 'Riyana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-480a-4072-bc2d-e91d17082e09', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-47e5-4cf0-9d99-e67a775aaa6e', 'Tri Gunadi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4854-494d-a88d-fe6463dd1a2e', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-4832-4407-bcb4-1d4f5533421a', 'Reza Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-48b6-43a9-b370-f56aea30cbad', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-487c-410c-9a56-adf3ffa706d6', 'Sarah Dwi Nabila', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4900-4eb3-9f10-3b80a75d3b5d', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-48de-4ef8-ab0c-74c7ae164227', 'Muhamad Alif Fitrah Permana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4951-40e2-a9f9-4c788bcd64a9', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-492a-46b6-b1b7-9c78711d3a4d', 'Ahmad Syatibi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-49a2-490c-a6a0-a32f5224c6ae', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-497f-45f6-98af-d9a61da7650f', 'Seka Sundari', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-49fc-4551-a206-4d4fa64f6e62', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-49d6-415a-8dbe-838b9cb05be0', 'Zaenal Arifin', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4a49-45c9-b02a-9d27c5df8cb7', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4a24-4fc2-83b3-c53a215819ef', 'Luthfi Hidayatulloh', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4a99-4ffc-b2d7-d43d681b2ddd', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4a75-4cc8-b82f-1a9f36ce9bae', 'Aura Lia Anggraeni', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4b03-4339-859f-3679dfedf8f2', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4ac2-40a8-9094-d1150445be87', 'Rifad Insan Kamil', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4b61-46c1-9c91-a7c5a653e312', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4b3a-4ee0-bf67-a698d95244e5', 'Rizqi Syahrul Mubarok', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4bb2-450a-a71d-947373e2424a', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4b8e-44f0-98fc-9095afc44120', 'Arman Mulyanudin A', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4c39-43f7-b34f-41f6a2458743', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4bfa-48c5-843e-ed9f2b5e2c7a', 'Rudi Ardian', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4c90-4151-83ed-a7b82e81d668', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4c69-4472-991d-499c3dba90cd', 'Fiqih Arya Sandi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39');
INSERT INTO `kormi_duta_olahraga` (`id`, `kecamatan_id`, `desa_kelurahan_id`, `nama_lengkap`, `tahun_pemilihan`, `kategori_duta`, `gelar_prestasi`, `deskripsi_prestasi`, `akun_instagram`, `foto_url`, `status_unggulan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-4cdf-46b2-b173-c1980aa6f78b', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4cba-4353-a406-9538421c84ac', 'Zeni Firmansyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4d52-430b-af19-ae9fde9c60a8', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4d1f-4d31-9df9-5c2441aa6039', 'Rina Nurhasanah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4db7-4246-a2bf-b13a9e77574c', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4d79-4035-b614-899ce16db766', 'Dani Ramdani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4e1f-43fc-9a24-cde0626c9d71', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4df4-4349-af94-90c65d75a418', 'Agus Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4e72-4743-8160-1644e729dc9a', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4e45-4eaf-835b-d011a5ffb132', 'Hendi Suhendi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-4ec6-47f3-8ade-81aeb46ce2ea', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4ea2-4b45-9ad5-457598f9c2f2', 'Yulianti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44264-f827-47a1-b90f-52acd0cee508', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-258c-493b-8d3b-c9c374608912', 'Egi Septiana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-f88e-4f5e-b0d0-6b32c113eb6a', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-25f0-4daa-b1aa-0655e97d88e4', 'Khaeru Ahmad Rifaldi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-f8da-41e8-b3d8-69e42551d3ed', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-263b-47d3-b85f-45e4fd2e0c40', 'Dodi Juliana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-f91f-4e7f-b116-46d92343877f', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-2684-4f38-b04b-10a35d0e0253', 'Zam Zam Fitrah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-f960-4108-8fd9-1871a1479cf6', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-26cd-440f-8453-11ba7d7399b9', 'Andi Mohamad Fauzi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-f9a4-40a8-a238-c2c42e9f94fd', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-2748-4b88-8c45-b049ded94905', 'Aminnur Dwi Ariyanti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-f9f2-4fba-ae31-6123079623b6', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-2796-4020-b7d1-f72a1d337f63', 'Fauzy Rahman Rukmana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fa34-4993-9169-4b8f22ad7b70', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-27fd-4c5f-8b57-9761453ab603', 'Ginanjar Teguh Sagara, S.Pd', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fa90-4ae2-87c6-24417edad0a0', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-2842-43ba-aa74-6af18baa0671', 'Darmawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fabe-4fa5-85f3-30c9a9734f3a', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-288a-440c-8c82-8ce4669cb1ce', 'Kania Sri Sucy Widara', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fc31-486a-bcb3-cbdb1fc1fdfa', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-28d2-4023-a01d-c995fb42dad6', 'Asep Supriatna', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fc68-4a3f-9f94-a69c5adc4b1f', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-292e-449c-9711-e1c02f6fd5c4', 'Rini Ridayanti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fcd7-4eee-9836-2a5800409b0c', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2998-426b-9a7a-a83acfbd54d4', 'Puri Aulia Salsabila', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fd13-4cd3-9d27-2aaec7cc2403', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2a25-47e6-a137-c2822882e992', 'Reza Miptah Dinulloh', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fd45-46de-82af-6e3bdb57a5cf', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2ad8-4a07-aa62-be3e441563a2', 'Aulia Rahmi Nur Fajriyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fd80-4a60-95d5-de74ebeff3c3', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2b94-4faa-b312-300672687259', 'Muhammad', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fdbb-4851-b947-0356d08983f5', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2bf1-4068-a648-77d7cef9a702', 'Shofwan Zaini', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fdf9-4e66-b2e8-3471cceac353', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2c47-4ce9-a4dc-16c28241e2cd', 'Nurdiyana Firmansyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-fe7f-40c6-ad20-2c74d1ee32b2', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2c8f-47c8-9cdc-689525ccea2c', 'Nizar Rayhan Nur Rakhmat', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-ff2b-4a9b-b596-477bb2f67a6f', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2cd6-4d9b-ada2-7a0066916d25', 'Aziz Ali Nurrochman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-ff96-448e-89dc-62fd69da6ea2', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2d24-4b97-9a21-b9c0d5ca8fad', 'Dinda Amalia Nur Fauziah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44264-ffde-484d-a89a-77eec71624ec', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2d92-45cb-9721-b0c79f999d69', 'Tiara Shinta Dewi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0047-42a2-9866-e6f454d272ff', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2de5-48d6-9cdf-cffb8f4f5fa7', 'Arul Fadyah Dzulpaqor', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0081-48a9-b585-a479380ffdcf', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2e3d-4d94-a2ac-54e61919c237', 'Lulurisma', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-00ab-429b-bf19-358d7471cb7c', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2eb9-417a-8d58-b9762ff619ab', 'Frischha Dewi Octavia', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-00d7-4040-bc72-85d5b1181d05', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2f04-486e-80fd-730341ac9f1f', 'Vian', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0100-455a-b494-0543efee4b21', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2f5f-4018-8db9-74a572abc36e', 'Deyra Hylmy Yahya', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0128-4a12-b6fb-a3a2fd9db24c', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2fc9-439a-88ef-85f80160eee3', 'Sanif Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0154-453e-92bd-5c6305785fce', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-3049-4009-83c1-a843f0a2f6c0', 'Syabina Fatwa Azzahra', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0199-48ad-ba40-8283da960ab3', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-309a-4148-bb25-0aca224aadf0', 'Nugie Herdiansyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-01c9-4f13-850e-0ddd46d8752b', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-30e9-4c07-981e-e96c81d177b2', 'Rahma Safitri', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-01fc-4e53-afce-4b61befc9c34', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-3135-4eeb-a08c-626badec2b8e', 'Dian Heryanto', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0227-447d-87d5-81927b0d8897', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-318c-4f63-b27d-41e2d61b52f0', 'Rissa Rosiana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-02cf-4257-904e-ed274a380814', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-31ea-4c46-b7a9-74dcec331fee', 'Deden Gunawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-02fb-4a01-98f5-cb0dc6899d16', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-326e-46fa-9534-81d40d19884a', 'Jaka Nursahid', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-032a-431b-902b-b8758e8b9b23', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-32ea-4a58-9de9-da92bde2eb26', 'Irma Asmarani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0358-4bf8-8762-4eebc63cf671', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-333e-46d7-80f1-582317748a70', 'Ahmad Fahmi Faisal', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-038f-4c0b-ae23-8d3eec0cade2', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-33a7-4eb8-a407-7b2b193fe198', 'Muhammad Fajar Nuriman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-03bd-4fc2-8666-5aa913b0edf3', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-340d-48f0-bfbb-c2dd5bd5ef56', 'Seril Rizka D Laela', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-03f7-40dc-9877-cc6f75894ef5', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3479-476f-bb0c-2d780c3698fb', 'Purnama Pramuditha', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0422-4c96-b496-b1ebcb648733', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-34e4-42b7-93ef-0d3351e5bb51', 'Galuh Hardianti Khoeriyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0450-4ce1-9dd2-a85beaf14dc7', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-352e-43b4-bbb9-68af4e0d99a0', 'Fikri Padilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0485-4c04-9877-c0649b5974dc', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3586-471b-afe8-0372f65ecab3', 'Erisya Nurul Fauzia', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-04ae-4157-bd22-9dbedbe691bc', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-35d3-4dff-9a1d-ab40a82426a9', 'Vianti Putri Lestari', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37');
INSERT INTO `kormi_duta_olahraga` (`id`, `kecamatan_id`, `desa_kelurahan_id`, `nama_lengkap`, `tahun_pemilihan`, `kategori_duta`, `gelar_prestasi`, `deskripsi_prestasi`, `akun_instagram`, `foto_url`, `status_unggulan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b44265-04da-4dea-9bfd-2e26e59bf2da', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3626-4c8b-a7d4-864d57dc4412', 'Ilham Nurzaman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0536-4b90-a6fe-df9383e44be9', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3681-48f2-8e86-e7608b288ee3', 'Muhamad Rukhiat Sofia Ramdani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-05a1-4256-bdab-d4ee0940826b', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3790-45f3-af38-53ba0dd56c0a', 'Mohammad Nabil Fadilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-05f4-4dea-ac83-b7c706920811', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-37e4-4a27-9425-c8b7e7978c9b', 'Annisa Maulidasawa', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0643-4ee5-babd-8eced8447631', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3834-4cfb-a022-b9d9e0fd11ef', 'Putri Widia Ramdani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0684-4dad-a9eb-1e21e79af443', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-38ec-4053-a714-37de31665a8c', 'Muhamad Ridwan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-06d1-43b6-b401-2bd163a8e264', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-393b-4a7f-95af-185e0b9e056b', 'Rilvan Fadilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0738-4d28-9410-ea2339a1f045', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-398a-4aff-8aa0-e92d560ce6ad', 'Dinar Fitranti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0777-4e26-a2bd-79810cceb539', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3a0a-4ecd-a712-3d2590064e79', 'Hera Iyadatul Fauziah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-07a9-49ca-b616-064055feeb4e', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3a71-46d7-a893-dac28a81f941', 'Yuda Maulana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-07d7-41be-8bb4-d137a6bcd564', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3adb-4f09-b5b3-1df739302bab', 'Syafitri Nurpadilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0804-491f-ad19-047ca2c48a92', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3b48-4261-b4a9-dd58b2fbce9c', 'Bagas Saparudin', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0831-4c73-9a4c-d1aa11c8462a', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3bbf-4ee5-b220-441195720d37', 'Siti Ulfa Hasanatun Nur Wahida., S.H', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-085f-468a-87ac-a4aafea84cc8', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3c8a-4642-8755-c161c3b2d463', 'Nurkholis Majid', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-08de-4151-aa67-47e51323b49a', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3d18-4aea-9e6a-3296cca1b03a', 'Imas Marwati', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-091e-4e65-9382-004b73964dcf', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3de7-4f0d-97d5-98171f147c51', 'Wahyu Wahyudin', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0971-49b3-8c56-9fccb0986d45', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3e50-40f7-b6bc-d9bfa810a6cf', 'Deaneira Choirunnisa Tedyaputri', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-09b9-4d9f-8b94-28a8a555aed0', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3ea1-454f-a3ff-c93dc93bb3e8', 'Wandi Suwanda', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0a08-4397-82c4-81ce606549e6', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3ef9-4c48-b27b-c65ab09b532f', 'Rizky Marwan Sarwana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0a4c-4fb8-beed-bcd0d5006e0d', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-3f6b-4ac1-ad54-8d059f9d79d8', 'Taufik Hidayat', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0a84-43c2-bcd3-ba822586fb70', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-3fd1-44b0-bb50-6be302aaa134', 'Muhammad Rayhan Fauzi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0ab0-4788-87fe-6840e0c00b7c', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-402d-472a-8d78-4f8b35975c52', 'Ajang', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0ad9-4fde-be30-9efe6a1da0d7', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-407d-4dae-b87a-eca582496f18', 'Irawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0b05-40ea-80ee-460ae4d010f0', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-40c9-4927-8807-e5ae0adfc690', 'Sindy Oktaviani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0b33-4738-9646-9e6f59e8963d', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-4165-4faf-b4ce-42af75a257b7', 'Iis Isnia Rhobiati', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0b61-46ad-95b7-98fe7e9548c4', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-41bf-4dcc-9813-d24172d7c960', 'Fitria Nur Aisyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0b8e-4a44-a839-525eb861a0f6', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4224-486f-abf2-2ac280139a86', 'Erlina Nuranjani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0bb9-4ea8-a767-e02f735a9ac5', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-428a-4727-8122-74bc9037f844', 'Boyke Dwi Septiadi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0be1-4be7-a753-29fafd87c838', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-42ec-47a4-97d1-d9250554a641', 'Asti Apriyanti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0c0c-47cb-9c83-1882716f7613', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4349-4bec-ab6b-0d670476f0e6', 'Taupik Tarisman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0c35-48d5-be93-fce933dd5e90', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-43ad-4b65-801d-9d77826118c7', 'Yoga Dwiswara', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0c65-4723-ae4d-814d095a2917', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4418-4fb5-bc84-ea935e42b0b5', 'Muhamad Yusup', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0c96-4cb2-a543-4e0d23c213d0', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4477-4a9b-aeab-26af4d3057b0', 'Tian Fauzi Agustien', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0cc2-45cd-a3c9-854d85859454', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-44cc-45c6-bd0f-ffd924e16c89', 'Dewita Yunika Sabila', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0cee-484a-9bd1-6647de9984ab', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4519-4584-99e0-c6fd8c378a4d', 'Ninda Nurazzizah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0d16-4efc-983a-b5a9237706d7', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-4597-4fb8-9451-3e83aefa014e', 'Melly Noviany', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0d39-4072-8371-e88e9922a1ae', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-45f0-4423-8015-e61a0ac03abd', 'Arie Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0d5c-461a-b544-cdb7e99fd308', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-463c-4130-817a-2d00d7a7e121', 'Abdulhafizh Almubarok', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0d82-4752-a5c4-81071f07b847', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-46b0-4aec-906d-cd4f1b91dc9b', 'Novel Mulyani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0da4-4be9-a7f1-048220ee3f3a', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-46fe-4419-afc3-ae524de69140', 'Iwan Nugraha', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0dc7-421e-b076-b94586bdd5d5', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-474b-487e-a620-b7945bbe05a2', 'Repan Eka Putra', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0de8-48ee-ba36-494aa9a40a82', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-4797-4af1-bbf1-97326bc33507', 'Riyana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0e08-4552-b0c0-a6311dd1f878', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-47e5-4cf0-9d99-e67a775aaa6e', 'Tri Gunadi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0eb6-4b29-a1fe-a4963408f81f', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-4832-4407-bcb4-1d4f5533421a', 'Reza Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0ed9-4935-928f-adc8d4659bef', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-487c-410c-9a56-adf3ffa706d6', 'Sarah Dwi Nabila', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0efd-4cc6-ab0c-208ed0080cfe', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-48de-4ef8-ab0c-74c7ae164227', 'Muhamad Alif Fitrah Permana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0f1f-481e-89c4-c728706be22e', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-492a-46b6-b1b7-9c78711d3a4d', 'Ahmad Syatibi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0f4d-4031-a679-ab9ccbe1b8b5', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-497f-45f6-98af-d9a61da7650f', 'Seka Sundari', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0f76-4bfa-9653-c9eef54c4b25', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-49d6-415a-8dbe-838b9cb05be0', 'Zaenal Arifin', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0fa4-4f9e-9f44-0285d84d0437', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4a24-4fc2-83b3-c53a215819ef', 'Luthfi Hidayatulloh', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37');
INSERT INTO `kormi_duta_olahraga` (`id`, `kecamatan_id`, `desa_kelurahan_id`, `nama_lengkap`, `tahun_pemilihan`, `kategori_duta`, `gelar_prestasi`, `deskripsi_prestasi`, `akun_instagram`, `foto_url`, `status_unggulan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b44265-0fce-4ec0-af1f-1da55ea03328', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4a75-4cc8-b82f-1a9f36ce9bae', 'Aura Lia Anggraeni', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-0ff3-4a33-9257-62ae5b2cabea', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4ac2-40a8-9094-d1150445be87', 'Rifad Insan Kamil', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1020-404a-afea-9620ac04c18e', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4b3a-4ee0-bf67-a698d95244e5', 'Rizqi Syahrul Mubarok', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1067-4491-8cb4-b2fd02861486', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4b8e-44f0-98fc-9095afc44120', 'Arman Mulyanudin A', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1094-401d-8a2a-304a371ca250', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4bfa-48c5-843e-ed9f2b5e2c7a', 'Rudi Ardian', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-10bf-436e-8b02-8d63c6acbdac', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4c69-4472-991d-499c3dba90cd', 'Fiqih Arya Sandi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1101-414d-8e99-3a35ce2fdb83', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4cba-4353-a406-9538421c84ac', 'Zeni Firmansyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-112a-4034-b326-4af6c2a71e40', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4d1f-4d31-9df9-5c2441aa6039', 'Rina Nurhasanah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-114e-4ef0-b2fa-a4f9e3e9a24a', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4d79-4035-b614-899ce16db766', 'Dani Ramdani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1173-4ba8-a6a7-b99180231426', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4df4-4349-af94-90c65d75a418', 'Agus Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-119a-4280-ae32-bab45bc4abf6', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4e45-4eaf-835b-d011a5ffb132', 'Hendi Suhendi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1204-44f3-8f0e-2c5ac22efb82', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4ea2-4b45-9ad5-457598f9c2f2', 'Yulianti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-536e-4d2d-9d48-ef2622a453cb', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-258c-493b-8d3b-c9c374608912', 'Egi Septiana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5451-4074-8c16-6687425026b0', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-25f0-4daa-b1aa-0655e97d88e4', 'Khaeru Ahmad Rifaldi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-54bc-4988-9941-3cb43f0c9aba', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-263b-47d3-b85f-45e4fd2e0c40', 'Dodi Juliana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5528-4afb-af02-c71d5a68cf2d', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'a2b40c67-2684-4f38-b04b-10a35d0e0253', 'Zam Zam Fitrah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-556f-4744-b0f8-d3482c0ecd52', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-26cd-440f-8453-11ba7d7399b9', 'Andi Mohamad Fauzi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-55cf-4d10-8d17-31ef7371a02f', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-2748-4b88-8c45-b049ded94905', 'Aminnur Dwi Ariyanti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-561d-443b-bf69-2add161f304e', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-2796-4020-b7d1-f72a1d337f63', 'Fauzy Rahman Rukmana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5654-41b9-b05d-987f0313d20d', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-27fd-4c5f-8b57-9761453ab603', 'Ginanjar Teguh Sagara, S.Pd', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5718-45b4-9eb0-6afbef38c1da', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-2842-43ba-aa74-6af18baa0671', 'Darmawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-57fb-4b9b-a205-7c5318f8fed6', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-288a-440c-8c82-8ce4669cb1ce', 'Kania Sri Sucy Widara', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5866-4b04-80c5-2e621a349401', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-28d2-4023-a01d-c995fb42dad6', 'Asep Supriatna', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-58f0-445c-a7ed-e1666d39c4c8', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'a2b40c67-292e-449c-9711-e1c02f6fd5c4', 'Rini Ridayanti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-592e-4066-99b3-af1759fcdcd4', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2998-426b-9a7a-a83acfbd54d4', 'Puri Aulia Salsabila', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-597e-4dce-b546-2e3015f25432', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2a25-47e6-a137-c2822882e992', 'Reza Miptah Dinulloh', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-59da-462d-beb8-1c0490e04bdc', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2ad8-4a07-aa62-be3e441563a2', 'Aulia Rahmi Nur Fajriyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5a0c-40bf-b438-cd454274f753', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2b94-4faa-b312-300672687259', 'Muhammad', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5a64-4255-ae73-fcf841b7d26b', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2bf1-4068-a648-77d7cef9a702', 'Shofwan Zaini', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5ac3-4ec7-95c7-58d735ac6c81', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2c47-4ce9-a4dc-16c28241e2cd', 'Nurdiyana Firmansyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5b26-4af6-b90f-1fba56a9851c', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2c8f-47c8-9cdc-689525ccea2c', 'Nizar Rayhan Nur Rakhmat', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5b56-4129-8a56-b6d1b8264696', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2cd6-4d9b-ada2-7a0066916d25', 'Aziz Ali Nurrochman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5b88-4c75-8d88-45a503567205', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2d24-4b97-9a21-b9c0d5ca8fad', 'Dinda Amalia Nur Fauziah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5be9-4498-971b-fdfa7109a60a', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2d92-45cb-9721-b0c79f999d69', 'Tiara Shinta Dewi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5c1e-4813-85c7-500654c93c45', 'a2b40c67-202d-4b46-9992-de88e8468387', 'a2b40c67-2de5-48d6-9cdf-cffb8f4f5fa7', 'Arul Fadyah Dzulpaqor', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5c51-46a7-b1e1-a0f4a0f806be', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2e3d-4d94-a2ac-54e61919c237', 'Lulurisma', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5ca0-41fc-9f69-65f69409e937', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2eb9-417a-8d58-b9762ff619ab', 'Frischha Dewi Octavia', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5ced-436e-9337-aaffa0eff687', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2f04-486e-80fd-730341ac9f1f', 'Vian', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5d21-4693-8922-0585683411cb', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2f5f-4018-8db9-74a572abc36e', 'Deyra Hylmy Yahya', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5dd9-4da4-976a-f60a17139b95', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-2fc9-439a-88ef-85f80160eee3', 'Sanif Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5e43-4c3c-806a-b687b798c82f', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 'a2b40c67-3049-4009-83c1-a843f0a2f6c0', 'Syabina Fatwa Azzahra', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5e75-407c-bc9d-7908f5463b1b', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-309a-4148-bb25-0aca224aadf0', 'Nugie Herdiansyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5ec5-45a6-b9b4-4a1c07146355', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-30e9-4c07-981e-e96c81d177b2', 'Rahma Safitri', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5ef5-45f2-8508-83f8e02ceba8', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-3135-4eeb-a08c-626badec2b8e', 'Dian Heryanto', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5f99-4123-bad4-cb4f92b88bf6', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-318c-4f63-b27d-41e2d61b52f0', 'Rissa Rosiana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5fca-40fd-b90d-6ad2e95c6e21', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-31ea-4c46-b7a9-74dcec331fee', 'Deden Gunawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-5ffd-45e8-9c06-fcd6b0da81e3', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-326e-46fa-9534-81d40d19884a', 'Jaka Nursahid', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-602f-4769-aa95-616f27fef1cb', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 'a2b40c67-32ea-4a58-9de9-da92bde2eb26', 'Irma Asmarani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6061-4725-bf2e-2a63cbb3ef60', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-333e-46d7-80f1-582317748a70', 'Ahmad Fahmi Faisal', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-60b0-4b87-9745-d02a551d0703', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-33a7-4eb8-a407-7b2b193fe198', 'Muhammad Fajar Nuriman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01');
INSERT INTO `kormi_duta_olahraga` (`id`, `kecamatan_id`, `desa_kelurahan_id`, `nama_lengkap`, `tahun_pemilihan`, `kategori_duta`, `gelar_prestasi`, `deskripsi_prestasi`, `akun_instagram`, `foto_url`, `status_unggulan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b44566-60fe-4914-9059-fa4ce3ab42a5', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-340d-48f0-bfbb-c2dd5bd5ef56', 'Seril Rizka D Laela', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6186-4292-99c8-70be838bdc04', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3479-476f-bb0c-2d780c3698fb', 'Purnama Pramuditha', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-61b6-4025-a28c-affe3132cf4c', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-34e4-42b7-93ef-0d3351e5bb51', 'Galuh Hardianti Khoeriyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6211-4d59-bf56-54d43e3f3bbd', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-352e-43b4-bbb9-68af4e0d99a0', 'Fikri Padilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6273-4741-a921-4eaa54b646a9', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3586-471b-afe8-0372f65ecab3', 'Erisya Nurul Fauzia', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-62d7-4254-a326-216c5b5764a5', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-35d3-4dff-9a1d-ab40a82426a9', 'Vianti Putri Lestari', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6368-463c-b67a-5f9887c1d026', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3626-4c8b-a7d4-864d57dc4412', 'Ilham Nurzaman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-639d-41bf-a34c-f87551a9eefc', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3681-48f2-8e86-e7608b288ee3', 'Muhamad Rukhiat Sofia Ramdani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-63cf-4856-99f5-72b01fc98dbf', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-3790-45f3-af38-53ba0dd56c0a', 'Mohammad Nabil Fadilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6403-44fd-a246-dd18a443ba68', 'a2b40c67-20a3-4613-8c86-241248986fd0', 'a2b40c67-37e4-4a27-9425-c8b7e7978c9b', 'Annisa Maulidasawa', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-643e-4cd9-8b82-c3d9865c2f1a', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3834-4cfb-a022-b9d9e0fd11ef', 'Putri Widia Ramdani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6474-4cb7-978a-dbb142419174', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-38ec-4053-a714-37de31665a8c', 'Muhamad Ridwan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-64f0-47b8-be60-a1a87cdc2caa', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-393b-4a7f-95af-185e0b9e056b', 'Rilvan Fadilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6526-4b9b-a988-663e22cffeb6', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-398a-4aff-8aa0-e92d560ce6ad', 'Dinar Fitranti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-655c-4813-bc75-c3950ba6993f', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3a0a-4ecd-a712-3d2590064e79', 'Hera Iyadatul Fauziah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-65fa-4e54-9f0a-f370094a6954', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3a71-46d7-a893-dac28a81f941', 'Yuda Maulana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6664-4010-ada1-9d248cba6868', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3adb-4f09-b5b3-1df739302bab', 'Syafitri Nurpadilah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-66c1-4d41-a2af-9ad05a5cad2c', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3b48-4261-b4a9-dd58b2fbce9c', 'Bagas Saparudin', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6745-4601-95d2-2d4c4a851ded', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'a2b40c67-3bbf-4ee5-b220-441195720d37', 'Siti Ulfa Hasanatun Nur Wahida., S.H', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6779-40dd-9067-6ffc1befac12', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3c8a-4642-8755-c161c3b2d463', 'Nurkholis Majid', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6933-4408-9219-7d4ee5ccb090', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3d18-4aea-9e6a-3296cca1b03a', 'Imas Marwati', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6967-4df8-a85b-170ac003ca17', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3de7-4f0d-97d5-98171f147c51', 'Wahyu Wahyudin', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-69e6-45ed-a74a-7bf9cbf85025', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3e50-40f7-b6bc-d9bfa810a6cf', 'Deaneira Choirunnisa Tedyaputri', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6a1b-45c8-ab25-020004a07b91', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3ea1-454f-a3ff-c93dc93bb3e8', 'Wandi Suwanda', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6a96-440f-9331-ab4ab82f12e4', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'a2b40c67-3ef9-4c48-b27b-c65ab09b532f', 'Rizky Marwan Sarwana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6ac8-4f24-8241-6b8912d2eeb9', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-3f6b-4ac1-ad54-8d059f9d79d8', 'Taufik Hidayat', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6b0a-4e63-a67b-e40c7d1c938a', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-3fd1-44b0-bb50-6be302aaa134', 'Muhammad Rayhan Fauzi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6b3e-4780-b38f-739a20bc4c0f', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-402d-472a-8d78-4f8b35975c52', 'Ajang', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6b93-4c60-9f04-1fe1bcb8ce75', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-407d-4dae-b87a-eca582496f18', 'Irawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6c04-4bd2-993e-67b9c6a55873', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-40c9-4927-8807-e5ae0adfc690', 'Sindy Oktaviani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6c38-456b-b229-088b5c058d89', 'a2b40c67-2135-481e-97b8-592488466ec6', 'a2b40c67-4165-4faf-b4ce-42af75a257b7', 'Iis Isnia Rhobiati', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6c68-4ceb-b13c-6f8a9d573e49', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-41bf-4dcc-9813-d24172d7c960', 'Fitria Nur Aisyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6cb8-47c4-9055-361dfe8d492c', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4224-486f-abf2-2ac280139a86', 'Erlina Nuranjani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6cea-4875-82b8-82eb7772f0f8', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-428a-4727-8122-74bc9037f844', 'Boyke Dwi Septiadi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6d1c-47a1-8e7e-20e6ab3fd75c', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-42ec-47a4-97d1-d9250554a641', 'Asti Apriyanti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6d4d-4c29-97f5-792679f56a11', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4349-4bec-ab6b-0d670476f0e6', 'Taupik Tarisman', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6d9f-4f4f-a422-a15a5a19cdb7', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-43ad-4b65-801d-9d77826118c7', 'Yoga Dwiswara', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6df2-4f32-9376-67ebe4cee6aa', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4418-4fb5-bc84-ea935e42b0b5', 'Muhamad Yusup', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6e25-4edd-8a99-c7af3a58c277', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4477-4a9b-aeab-26af4d3057b0', 'Tian Fauzi Agustien', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6e59-4436-81af-d1df9a1b773b', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-44cc-45c6-bd0f-ffd924e16c89', 'Dewita Yunika Sabila', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6e8f-42d1-90fe-8dca7c1908ae', 'a2b40c67-2163-4d41-b380-13297da90a64', 'a2b40c67-4519-4584-99e0-c6fd8c378a4d', 'Ninda Nurazzizah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6eee-42d7-94fd-032294371329', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-4597-4fb8-9451-3e83aefa014e', 'Melly Noviany', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6f67-4473-869c-e5b4859dd1d8', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-45f0-4423-8015-e61a0ac03abd', 'Arie Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6f9d-4750-b331-9330f62ba34d', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-463c-4130-817a-2d00d7a7e121', 'Abdulhafizh Almubarok', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-6fd4-49ef-aea7-11ef6d7f1547', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-46b0-4aec-906d-cd4f1b91dc9b', 'Novel Mulyani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-7059-41ba-b696-70f9e253257a', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-46fe-4419-afc3-ae524de69140', 'Iwan Nugraha', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-70b2-49dd-b5af-28afaeece84d', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-474b-487e-a620-b7945bbe05a2', 'Repan Eka Putra', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-70e7-48f7-b879-fea15929ef97', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-4797-4af1-bbf1-97326bc33507', 'Riyana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-711f-45e9-b239-9e8eae3323b3', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-47e5-4cf0-9d99-e67a775aaa6e', 'Tri Gunadi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-7149-4dbb-b800-c3877cacdb22', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'a2b40c67-4832-4407-bcb4-1d4f5533421a', 'Reza Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01');
INSERT INTO `kormi_duta_olahraga` (`id`, `kecamatan_id`, `desa_kelurahan_id`, `nama_lengkap`, `tahun_pemilihan`, `kategori_duta`, `gelar_prestasi`, `deskripsi_prestasi`, `akun_instagram`, `foto_url`, `status_unggulan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b44566-7174-4ed2-b62e-98d94dcc3352', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-487c-410c-9a56-adf3ffa706d6', 'Sarah Dwi Nabila', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-71a8-4d64-a5cd-22be3178290b', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-48de-4ef8-ab0c-74c7ae164227', 'Muhamad Alif Fitrah Permana', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-71da-4036-9549-3cf6c5763a97', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-492a-46b6-b1b7-9c78711d3a4d', 'Ahmad Syatibi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-720b-45dc-952d-b9f5ed8143f9', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-497f-45f6-98af-d9a61da7650f', 'Seka Sundari', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-723e-4029-9258-5ffaa7d6f64f', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-49d6-415a-8dbe-838b9cb05be0', 'Zaenal Arifin', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-726f-4cc5-949b-d92b13eb7da0', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4a24-4fc2-83b3-c53a215819ef', 'Luthfi Hidayatulloh', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-72a1-485f-a15e-3c7204c6cc1f', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4a75-4cc8-b82f-1a9f36ce9bae', 'Aura Lia Anggraeni', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-7324-4df8-9b18-4079217d36cd', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4ac2-40a8-9094-d1150445be87', 'Rifad Insan Kamil', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-7357-4ecb-a435-49f9c5f38d33', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4b3a-4ee0-bf67-a698d95244e5', 'Rizqi Syahrul Mubarok', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-738b-440d-bc59-fd9fa94b1317', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4b8e-44f0-98fc-9095afc44120', 'Arman Mulyanudin A', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-73bf-4110-a428-a18ecb7f77c6', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4bfa-48c5-843e-ed9f2b5e2c7a', 'Rudi Ardian', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-7418-4ab3-9228-89d2858b2344', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4c69-4472-991d-499c3dba90cd', 'Fiqih Arya Sandi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-7441-4ad7-bd93-85be95ab0287', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'a2b40c67-4cba-4353-a406-9538421c84ac', 'Zeni Firmansyah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-746b-4d3c-8e5a-95a25e20e791', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4d1f-4d31-9df9-5c2441aa6039', 'Rina Nurhasanah', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-74c1-4b07-a0e0-8f608a2c6040', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4d79-4035-b614-899ce16db766', 'Dani Ramdani', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-750e-4fc8-b257-79f5f89d1820', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4df4-4349-af94-90c65d75a418', 'Agus Setiawan', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-7542-41f9-a2a9-a32328f01809', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4e45-4eaf-835b-d011a5ffb132', 'Hendi Suhendi', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-7573-41bd-8775-97a57d283b2f', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'a2b40c67-4ea2-4b45-9ad5-457598f9c2f2', 'Yulianti', 2026, 'Duta Olahraga Masyarakat', NULL, NULL, NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_event`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_event`;
CREATE TABLE `kormi_event` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_event_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_edisi` bigint NOT NULL,
  `lokasi_utama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `banner_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_event_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_lengkap` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tautan_eksternal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_publikasi` bigint NOT NULL DEFAULT '1',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_event`
INSERT INTO `kormi_event` (`id`, `kategori_event_id`, `judul_event`, `slug`, `tahun_edisi`, `lokasi_utama`, `tanggal_mulai`, `tanggal_selesai`, `banner_url`, `logo_event_url`, `deskripsi_lengkap`, `tautan_eksternal`, `status_publikasi`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', '6d4e2d32-c355-4197-9e0b-f5911ade9c79', 'Festival Olahraga Rekreasi Masyarakat Kabupaten (FORKAB) 2026', 'forkab-2026', 2026, 'Komplek Stadion Si Jalak Harupat, Kutawaringin', '2026-08-01', '2026-08-30', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=1200', NULL, 'Ajang festival olahraga rekreasi terbesar se-Kabupaten Bandung dengan partisipasi 31 kontingen kecamatan.', NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'babe8a25-0458-497a-9607-3a1b5086e917', 'Festival Olahraga Rekreasi Masyarakat Kabupaten (FORKAB) 2026', 'forkab-2026', 2026, 'Komplek Stadion Si Jalak Harupat, Kutawaringin', '2026-08-01', '2026-08-30', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=1200', NULL, 'Ajang festival olahraga rekreasi terbesar se-Kabupaten Bandung dengan partisipasi 31 kontingen kecamatan.', NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'b9ed8a9a-baeb-43db-aed5-de2bc622203c', 'Festival Olahraga Rekreasi Masyarakat Kabupaten (FORKAB) 2026', 'forkab-2026', 2026, 'Komplek Stadion Si Jalak Harupat, Kutawaringin', '2026-08-01', '2026-08-30', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=1200', NULL, 'Ajang festival olahraga rekreasi terbesar se-Kabupaten Bandung dengan partisipasi 31 kontingen kecamatan.', NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37');

-- --------------------------------------------------------
-- Table structure for `kormi_event_cabang`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_event_cabang`;
CREATE TABLE `kormi_event_cabang` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `inorga_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_peserta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aturan_juknis_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ikon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'award',
  `kode_warna_hex` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bg-amber-500',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_event_cabang`
INSERT INTO `kormi_event_cabang` (`id`, `event_id`, `inorga_id`, `nama_cabang`, `kategori_peserta`, `aturan_juknis_url`, `ikon`, `kode_warna_hex`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('0738a97f-5aab-410f-8b79-e06b19b63036', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', NULL, 'Panahan Tradisional', 'Umum & Pelajar', NULL, 'target', 'bg-emerald-500', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('10b82a90-b5a4-4e4b-b3ab-69b88a524de7', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', NULL, 'Petanque', 'Umum & Pelajar', NULL, 'circle-dot', 'bg-purple-500', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('1342a8e9-629a-4223-bf9b-5be1cbd4d036', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', NULL, 'Senam Aerobik', 'Umum & Pelajar', NULL, 'activity', 'bg-pink-500', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('1b649dc0-145b-4382-8419-77c4d98d2fb8', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', NULL, 'Bersepeda Santai', 'Umum & Pelajar', NULL, 'bike', 'bg-blue-500', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('21a86629-dcbd-4033-9de2-73af0e7b20b9', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', NULL, 'Senam Aerobik', 'Umum & Pelajar', NULL, 'activity', 'bg-pink-500', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('41c756f0-6210-49b7-a137-5189630c1922', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', NULL, 'Renang Rekreasi', 'Umum & Pelajar', NULL, 'waves', 'bg-cyan-500', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('459f19a7-28ba-45dd-96ba-92532e60fbf3', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', NULL, 'Tenis Meja', 'Umum & Pelajar', NULL, 'table', 'bg-orange-500', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('5217efff-8fc7-4834-b596-475e29dbe877', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', NULL, 'Tenis Meja', 'Umum & Pelajar', NULL, 'table', 'bg-orange-500', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('5e7a6e3d-ba75-4de1-a8a9-4d053f4246f4', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', NULL, 'Fun Run 5K', 'Umum & Pelajar', NULL, 'zap', 'bg-red-500', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('5fc4f7ba-a523-4f42-8e89-f22dff6f1a81', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', NULL, 'Panahan Tradisional', 'Umum & Pelajar', NULL, 'target', 'bg-emerald-500', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('5fe94aaa-613e-4bfd-8462-ede245601a18', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', NULL, 'Petanque', 'Umum & Pelajar', NULL, 'circle-dot', 'bg-purple-500', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('712f95f0-95cc-4322-ae6c-4a93ffc6a10b', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', NULL, 'Panahan Tradisional', 'Umum & Pelajar', NULL, 'target', 'bg-emerald-500', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('7bb0b148-2226-4ff1-8968-7f5742436df3', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', NULL, 'Tenis Meja', 'Umum & Pelajar', NULL, 'table', 'bg-orange-500', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('83e9c9b3-dee3-40e7-9a65-b4b89b102c37', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', NULL, 'Petanque', 'Umum & Pelajar', NULL, 'circle-dot', 'bg-purple-500', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('93d4fc4a-42e3-4079-8359-56c61397267c', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', NULL, 'Fun Run 5K', 'Umum & Pelajar', NULL, 'zap', 'bg-red-500', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('9748d926-9685-4b33-958d-31ea17679971', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', NULL, 'Fun Run 5K', 'Umum & Pelajar', NULL, 'zap', 'bg-red-500', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('9bff4925-4910-4197-82b4-216ad436ef2b', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', NULL, 'Layang-Layang', 'Umum & Pelajar', NULL, 'wind', 'bg-indigo-500', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('ab5cf9ab-5300-4a80-b5dd-9d70531aaac8', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', NULL, 'Bersepeda Santai', 'Umum & Pelajar', NULL, 'bike', 'bg-blue-500', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('afd53e2f-3a25-4f09-874b-f807366fa27b', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', NULL, 'Renang Rekreasi', 'Umum & Pelajar', NULL, 'waves', 'bg-cyan-500', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('c8b84b6d-0898-4b36-beeb-ed5b2b644b31', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', NULL, 'Layang-Layang', 'Umum & Pelajar', NULL, 'wind', 'bg-indigo-500', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('d2c6d142-f8e1-4fe7-bcc1-5a7768624315', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', NULL, 'Renang Rekreasi', 'Umum & Pelajar', NULL, 'waves', 'bg-cyan-500', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('d8cda369-d4ed-4065-9bd5-82077c639dd2', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', NULL, 'Layang-Layang', 'Umum & Pelajar', NULL, 'wind', 'bg-indigo-500', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('ddb5aa6c-7f18-471c-97f8-272422fe2bdc', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', NULL, 'Senam Aerobik', 'Umum & Pelajar', NULL, 'activity', 'bg-pink-500', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('f23e9b2d-c410-4ecd-9d82-203ba275f4ed', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', NULL, 'Bersepeda Santai', 'Umum & Pelajar', NULL, 'bike', 'bg-blue-500', '2026-09-09 22:17:39', '2026-09-09 22:17:39');

-- --------------------------------------------------------
-- Table structure for `kormi_event_jadwal`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_event_jadwal`;
CREATE TABLE `kormi_event_jadwal` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fase_tahapan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `nama_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_arena` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_tahapan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'akan_datang',
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_event_jadwal`
INSERT INTO `kormi_event_jadwal` (`id`, `event_id`, `fase_tahapan`, `tanggal`, `jam_mulai`, `jam_selesai`, `nama_kegiatan`, `tempat_arena`, `status_tahapan`, `keterangan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('05db7618-5fd0-43c5-b554-874f64077e16', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'Babak Penyisihan', '2026-08-01', NULL, NULL, 'Babak Penyisihan FORKAB 2026', 'Zona Wilayah Kab. Bandung', 'berlangsung', 'Pertandingan babak penyisihan di masing-masing zona wilayah.', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('0ade1259-fb36-45e8-a6ca-d6a3d787979b', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'Penutupan & Awarding', '2026-08-30', NULL, NULL, 'Penutupan & Awarding FORKAB 2026', 'Lapangan Upakarti Soreang', 'akan_datang', 'Upacara penutupan dan penyerahan piala bergilir Bupati Bandung.', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('2694678f-9aeb-4ecd-9355-67b097329ca4', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'Technical Meeting', '2026-07-15', NULL, NULL, 'Technical Meeting FORKAB 2026', 'Aula Dispora Kab. Bandung', 'selesai', 'Rapat teknis dan undian bagan pertandingan.', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('3954757a-c898-41cf-9478-fa0e232c055c', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'Babak Final', '2026-08-25', NULL, NULL, 'Babak Final FORKAB 2026', 'Stadion Si Jalak Harupat', 'akan_datang', 'Grand final seluruh cabor di Stadion Si Jalak Harupat.', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('3b748753-19c8-4bd6-88dc-cfff1d13b8f3', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'Technical Meeting', '2026-07-15', NULL, NULL, 'Technical Meeting FORKAB 2026', 'Aula Dispora Kab. Bandung', 'selesai', 'Rapat teknis dan undian bagan pertandingan.', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('59e3a581-eb7b-41f8-8372-eb3764e41f99', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'Babak Final', '2026-08-25', NULL, NULL, 'Babak Final FORKAB 2026', 'Stadion Si Jalak Harupat', 'akan_datang', 'Grand final seluruh cabor di Stadion Si Jalak Harupat.', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('6aa6e21e-26b2-492c-b985-e24c658462fa', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'Pendaftaran', '2026-06-01', NULL, NULL, 'Pendaftaran FORKAB 2026', 'Sekretariat KORMI', 'selesai', 'Pendaftaran kontingen kecamatan melalui Koordinator Kecamatan.', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('8585f828-9e50-4d35-92e0-39b3889bdb89', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'Babak Final', '2026-08-25', NULL, NULL, 'Babak Final FORKAB 2026', 'Stadion Si Jalak Harupat', 'akan_datang', 'Grand final seluruh cabor di Stadion Si Jalak Harupat.', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('956d9882-d008-4a3c-8898-bad8e939e3e5', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'Babak Penyisihan', '2026-08-01', NULL, NULL, 'Babak Penyisihan FORKAB 2026', 'Zona Wilayah Kab. Bandung', 'berlangsung', 'Pertandingan babak penyisihan di masing-masing zona wilayah.', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('9caf8d78-e3e8-4209-8d37-817b40b3023c', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'Penutupan & Awarding', '2026-08-30', NULL, NULL, 'Penutupan & Awarding FORKAB 2026', 'Lapangan Upakarti Soreang', 'akan_datang', 'Upacara penutupan dan penyerahan piala bergilir Bupati Bandung.', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('9d7ea0ac-26e7-4579-bc68-e01b7241b6ec', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'Pendaftaran', '2026-06-01', NULL, NULL, 'Pendaftaran FORKAB 2026', 'Sekretariat KORMI', 'selesai', 'Pendaftaran kontingen kecamatan melalui Koordinator Kecamatan.', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a38e48ab-17d8-4f30-8617-b0262745de75', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'Babak Penyisihan', '2026-08-01', NULL, NULL, 'Babak Penyisihan FORKAB 2026', 'Zona Wilayah Kab. Bandung', 'berlangsung', 'Pertandingan babak penyisihan di masing-masing zona wilayah.', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('abd3c237-5438-4ea1-bb7c-615cb0b31805', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'Penutupan & Awarding', '2026-08-30', NULL, NULL, 'Penutupan & Awarding FORKAB 2026', 'Lapangan Upakarti Soreang', 'akan_datang', 'Upacara penutupan dan penyerahan piala bergilir Bupati Bandung.', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('c5e3d1d6-e713-4786-b855-91bcc174a476', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'Technical Meeting', '2026-07-15', NULL, NULL, 'Technical Meeting FORKAB 2026', 'Aula Dispora Kab. Bandung', 'selesai', 'Rapat teknis dan undian bagan pertandingan.', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('ea3c5922-bd53-4dc6-9739-65c92ee47a82', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'Pendaftaran', '2026-06-01', NULL, NULL, 'Pendaftaran FORKAB 2026', 'Sekretariat KORMI', 'selesai', 'Pendaftaran kontingen kecamatan melalui Koordinator Kecamatan.', '2026-09-09 22:17:39', '2026-09-09 22:17:39');

-- --------------------------------------------------------
-- Table structure for `kormi_event_klasemen_medali`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_event_klasemen_medali`;
CREATE TABLE `kormi_event_klasemen_medali` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_emas` bigint NOT NULL DEFAULT '0',
  `jumlah_perak` bigint NOT NULL DEFAULT '0',
  `jumlah_perunggu` bigint NOT NULL DEFAULT '0',
  `total_medali` bigint NOT NULL DEFAULT '0',
  `peringkat` bigint NOT NULL DEFAULT '0',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_event_klasemen_medali`
INSERT INTO `kormi_event_klasemen_medali` (`id`, `event_id`, `kecamatan_id`, `jumlah_emas`, `jumlah_perak`, `jumlah_perunggu`, `total_medali`, `peringkat`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('0c8a315f-e633-416d-bbea-f257086955f5', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 7, 5, 7, 19, 3, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('2c716a65-b805-4bd1-bae2-6f57babfd116', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2135-481e-97b8-592488466ec6', 4, 5, 6, 15, 7, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('33d3c7cf-aa85-41a4-817c-de9354ecaa44', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'a2b40c67-24db-413e-892f-2333b7a653c1', 4, 3, 4, 11, 8, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('4cd72e1b-073c-4458-bfed-91d5a509da6d', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 6, 7, 3, 16, 4, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('4ef6985b-5778-4342-ad75-be1b83eea1dd', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-234c-4066-ade5-6ebdadfadd2f', 10, 6, 4, 20, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('4f912122-ba02-4d6d-aabd-7961ea5c97aa', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-224e-4072-a647-fc87c51c98cd', 5, 4, 5, 14, 6, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('568df932-dad6-4cca-86da-f9d62569bff8', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'a2b40c67-224e-4072-a647-fc87c51c98cd', 5, 4, 5, 14, 6, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('57fb6bff-89bc-4c72-8165-9400f8e64fe1', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2200-43d0-b5a3-58d1d395a033', 8, 8, 5, 21, 2, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('5852c46a-adac-4346-9998-17b4c1499fc8', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 7, 5, 7, 19, 3, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('69accf3c-5283-44a3-83eb-fee9f29371ae', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'a2b40c67-2200-43d0-b5a3-58d1d395a033', 8, 8, 5, 21, 2, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('6f4f125e-6826-4992-b485-889fcbf22416', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-234c-4066-ade5-6ebdadfadd2f', 10, 6, 4, 20, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('71cf96a5-594d-413e-b4b4-1877e5836fc1', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-224e-4072-a647-fc87c51c98cd', 5, 4, 5, 14, 6, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('811eb998-a5e1-42c0-a5a1-ab771cc74045', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 6, 7, 3, 16, 4, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('9516af44-9c44-4c94-afaa-cef48a961f60', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 7, 5, 7, 19, 3, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('9b4e3d15-edc4-460c-b20e-1065d1fa6d4e', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2135-481e-97b8-592488466ec6', 4, 5, 6, 15, 7, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a0259f4f-cb8e-48f4-a4a7-7f7723e34830', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 6, 7, 3, 16, 4, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44261-0e1d-4e52-aee0-a94cc849e78d', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-0e9b-4c1c-a03b-64d1d383f7de', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-202d-4b46-9992-de88e8468387', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-0ee6-4220-9f72-0fd0585da93f', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-0f37-42d8-849b-6537c0e54f75', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-0f7f-43e4-90d9-7066e15e7e4f', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-20a3-4613-8c86-241248986fd0', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-0fb9-4218-8da1-78fc7df5cb98', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-0ff4-4526-a02e-bb3146d59bdd', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-105a-44d1-8ffa-d6c8588bfabf', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2163-4d41-b380-13297da90a64', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-1097-457e-b882-1608a8ad2644', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-1116-4af8-b7bd-562df49c6db6', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-21d8-46f8-8925-45195a58f962', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-1174-42b2-b29d-cbb720e2ba66', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2228-4d0b-802a-63f0b16c9053', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-11bb-4169-9054-29f2a8ccb749', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-227f-4ec6-9c7e-85eb0ec80fa3', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-120d-4d4f-8204-901785847dfb', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-22ac-4984-a7a7-6f0c77b21a8f', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-1247-45ee-a155-69b279862400', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-22f6-4a59-857b-29a3036964b6', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-1287-4e48-8246-01857725374a', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2320-4fa2-964b-bc8c0168c8ff', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-12dc-44a4-a3b0-db6cf0fc60a4', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2378-4ef6-8a41-7b3db0adf1af', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-131b-47d4-bf82-87b939498ce9', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-239f-4581-86ca-80b199f142e3', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-1366-431f-9392-5f857d02e1c2', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-23df-4eb9-9f7a-0e81c96eb35b', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-13c7-447d-b515-84b18cb45aff', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-240d-4b48-84ed-bca47694438d', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-144d-4c5b-8c4f-63f50b0b4d77', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2438-4639-8bab-d74dac91f9ec', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-14ae-49b5-bed9-1c887da40fdf', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2468-4020-9b31-7a279780859c', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-14ee-468b-be36-0daf21d1415d', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-24a7-45b7-adfa-06e919c7f9db', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b44261-1601-455f-88f4-433e66889510', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-250b-47c9-ba2b-ef0567772ee5', 0, 0, 0, 0, 0, '2026-09-09 17:48:34', '2026-09-09 17:48:34'),
  ('a2b445c8-de22-4c24-9aa2-6802ba0ec691', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-dea5-4e58-b329-ef89bc244d37', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-202d-4b46-9992-de88e8468387', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-def2-46db-a438-51c26b0cb22b', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2055-4489-a532-a4a81f080c7f', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-df3e-4f9b-ab65-0e3b1a9484e3', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-df88-437c-a887-e3c9801813ad', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-20a3-4613-8c86-241248986fd0', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-dfcc-45fc-a78c-a27299716967', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e017-418e-91ed-55601f514d30', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e0a8-4e0a-94b7-9ac0ed2b1473', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2163-4d41-b380-13297da90a64', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e0f2-404a-828c-09c1ff8c825b', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e14a-4f4d-87a6-c93476b747ed', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-21d8-46f8-8925-45195a58f962', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e1b0-49c0-837e-ee0bd10af4bd', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2228-4d0b-802a-63f0b16c9053', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06');
INSERT INTO `kormi_event_klasemen_medali` (`id`, `event_id`, `kecamatan_id`, `jumlah_emas`, `jumlah_perak`, `jumlah_perunggu`, `total_medali`, `peringkat`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b445c8-e205-4c9c-9b52-256ef0769687', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-227f-4ec6-9c7e-85eb0ec80fa3', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e23f-4736-a52a-9be22e56c31c', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-22ac-4984-a7a7-6f0c77b21a8f', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e277-43e0-a41e-794e3e8f9059', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-22f6-4a59-857b-29a3036964b6', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e2ad-45ed-b1c0-9703dab80365', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2320-4fa2-964b-bc8c0168c8ff', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e2fb-4a3b-9d49-aa43c98f4d9d', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2378-4ef6-8a41-7b3db0adf1af', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e329-4e04-80c3-c37df5f0f6b6', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-239f-4581-86ca-80b199f142e3', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e357-458f-a5f8-40697a8df38e', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-23df-4eb9-9f7a-0e81c96eb35b', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e383-4bf3-a325-43391adc1ad6', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-240d-4b48-84ed-bca47694438d', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e3af-476d-b3c6-32ef5a349a24', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2438-4639-8bab-d74dac91f9ec', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e3db-40c7-88d0-fdc39d8046d0', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2468-4020-9b31-7a279780859c', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e40a-40c7-a5a6-8dfbec5a050e', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-24a7-45b7-adfa-06e919c7f9db', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a2b445c8-e449-4c58-b680-4b2d78a04bb3', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-250b-47c9-ba2b-ef0567772ee5', 0, 0, 0, 0, 0, '2026-09-09 10:58:06', '2026-09-09 10:58:06'),
  ('a96c08a6-a461-41ed-83ca-42392404882e', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2538-40be-82bc-3782bfaad813', 5, 6, 8, 19, 5, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('b0c14728-f86e-4944-b5ee-34e2cebfa489', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-24db-413e-892f-2333b7a653c1', 4, 3, 4, 11, 8, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('b8e91a8e-40c5-42f7-afa2-eefa61661580', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'a2b40c67-2135-481e-97b8-592488466ec6', 4, 5, 6, 15, 7, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('d147239f-ea95-4d22-af8a-61c536a30d9b', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'a2b40c67-2538-40be-82bc-3782bfaad813', 5, 6, 8, 19, 5, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('edd8ef2e-618c-4360-8d59-b06b4295c5b0', 'e2d9e0f4-32bf-422e-84a9-4b0b161ba54a', 'a2b40c67-234c-4066-ade5-6ebdadfadd2f', 10, 6, 4, 20, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('f3b11e51-a0b2-41bd-a8bc-062692c1616c', '5b7b2316-9cb0-4ee5-a776-bf13f4a5a1dd', 'a2b40c67-2538-40be-82bc-3782bfaad813', 5, 6, 8, 19, 5, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('f6f5a7a5-7260-487a-b5e8-3ce138860127', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-2200-43d0-b5a3-58d1d395a033', 8, 8, 5, 21, 2, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('fde942f0-002c-42bc-a594-6275e0dfdbfc', 'deae9563-68d5-4c84-9bef-99f0dbc5f5d0', 'a2b40c67-24db-413e-892f-2333b7a653c1', 4, 3, 4, 11, 8, '2026-09-09 22:17:39', '2026-09-09 22:17:39');

-- --------------------------------------------------------
-- Table structure for `kormi_galeri_album`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_galeri_album`;
CREATE TABLE `kormi_galeri_album` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_album` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_kegiatan` date DEFAULT NULL,
  `gambar_sampul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_tampil` bigint NOT NULL DEFAULT '1',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_galeri_album`
INSERT INTO `kormi_galeri_album` (`id`, `judul_album`, `slug`, `tanggal_kegiatan`, `gambar_sampul`, `deskripsi`, `status_tampil`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-6100-4f19-a2f5-71f70dab5267', 'FORKAB', 'forkab', '2025-08-15', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', 'Dokumentasi Festival Olahraga Rekreasi Masyarakat Tingkat Kabupaten Bandung.', 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-6124-4356-b1c4-649dd6f2a95f', 'FOTRADKAB', 'fotradkab', '2025-10-20', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800', 'Dokumentasi Festival Olahraga Tradisional Tingkat Kabupaten Bandung.', 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-614b-4fc2-99c0-5eda9028a705', 'Bedas Run', 'bedas-run', '2025-11-10', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', 'Dokumentasi Gelaran Bandung Bedas Run.', 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-6171-4906-af84-264822c81522', 'Senam Massal', 'senam-massal', '2026-05-01', 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800', 'Senam massal kebugaran di alun-alun dan stadion.', 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-6191-4916-94c9-3811a7927431', 'Rapat & Koordinasi', 'rapat-dan-koordinasi', '2026-04-12', 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', 'Rapat kerja, audiensi dan koordinasi pengurus KORMI.', 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-61b3-42fe-9ca5-d580e2af86bd', 'Kegiatan Sosial', 'kegiatan-sosial', '2026-03-25', 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800', 'Bakti sosial dan fun walk peduli lingkungan KORMI.', 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-24a0-4d71-b8f4-302c7071be71', 'FORKAB', 'forkab', '2025-08-15', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', 'Dokumentasi Festival Olahraga Rekreasi Masyarakat Tingkat Kabupaten Bandung.', 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-24d9-455b-9183-872d54ec42b1', 'FOTRADKAB', 'fotradkab', '2025-10-20', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800', 'Dokumentasi Festival Olahraga Tradisional Tingkat Kabupaten Bandung.', 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-24f8-4ce0-aba1-c39825e18ee1', 'Bedas Run', 'bedas-run', '2025-11-10', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', 'Dokumentasi Gelaran Bandung Bedas Run.', 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2514-4587-bf92-ab95a509dd11', 'Senam Massal', 'senam-massal', '2026-05-01', 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800', 'Senam massal kebugaran di alun-alun dan stadion.', 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2530-47e4-a5f3-ef309bff3c66', 'Rapat & Koordinasi', 'rapat-dan-koordinasi', '2026-04-12', 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', 'Rapat kerja, audiensi dan koordinasi pengurus KORMI.', 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2553-409f-8534-33661441099a', 'Kegiatan Sosial', 'kegiatan-sosial', '2026-03-25', 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800', 'Bakti sosial dan fun walk peduli lingkungan KORMI.', 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-8a44-4de0-acfa-0c9f163d48eb', 'FORKAB', 'forkab', '2025-08-15', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', 'Dokumentasi Festival Olahraga Rekreasi Masyarakat Tingkat Kabupaten Bandung.', 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8af4-43ad-b63c-16bcaa18d689', 'FOTRADKAB', 'fotradkab', '2025-10-20', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800', 'Dokumentasi Festival Olahraga Tradisional Tingkat Kabupaten Bandung.', 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8b11-43ef-9dd6-adc5afa7156a', 'Bedas Run', 'bedas-run', '2025-11-10', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', 'Dokumentasi Gelaran Bandung Bedas Run.', 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8b58-4ce5-a405-12ab3835c174', 'Senam Massal', 'senam-massal', '2026-05-01', 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800', 'Senam massal kebugaran di alun-alun dan stadion.', 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8b78-4805-8612-a3efe07f8576', 'Rapat & Koordinasi', 'rapat-dan-koordinasi', '2026-04-12', 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', 'Rapat kerja, audiensi dan koordinasi pengurus KORMI.', 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8b96-4438-9342-2168a00e894f', 'Kegiatan Sosial', 'kegiatan-sosial', '2026-03-25', 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800', 'Bakti sosial dan fun walk peduli lingkungan KORMI.', 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_galeri_foto`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_galeri_foto`;
CREATE TABLE `kormi_galeri_foto` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `album_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_foto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tipe_grid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `urutan` bigint NOT NULL DEFAULT '0',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_galeri_foto`
INSERT INTO `kormi_galeri_foto` (`id`, `album_id`, `judul_foto`, `gambar_url`, `keterangan_foto`, `tipe_grid`, `urutan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-61f8-4c01-a602-1249bcaab5c6', 'a2b40c67-6100-4f19-a2f5-71f70dab5267', 'Pembukaan FORKAB 2025', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 'col-span-2 row-span-2', 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-621d-4bd0-a593-0c8ac811ede5', 'a2b40c67-6171-4906-af84-264822c81522', 'Senam Pagi Bersama Warga', 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800', NULL, 'normal', 2, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-624c-4b19-8984-2dab3a6e05eb', 'a2b40c67-6124-4356-b1c4-649dd6f2a95f', 'Final Tarik Tambang FOTRADKAB', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800', NULL, 'normal', 3, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-6270-4361-8e92-4fe86ea9890d', 'a2b40c67-614b-4fc2-99c0-5eda9028a705', 'Start Line Bedas Run 2025', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', NULL, 'col-span-1 row-span-2', 4, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-629b-4ba0-a703-b3e416bf9297', 'a2b40c67-6191-4916-94c9-3811a7927431', 'Rapat Koordinasi Pengurus', 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', NULL, 'normal', 5, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-62c4-4c10-a708-01aef0abdba3', 'a2b40c67-6100-4f19-a2f5-71f70dab5267', 'Penyerahan Medali Juara Umum', 'https://images.unsplash.com/photo-1526676023641-72e042776856?q=80&w=800', NULL, 'normal', 6, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-62ea-46a4-a0c3-af848a5b5d70', 'a2b40c67-61b3-42fe-9ca5-d580e2af86bd', 'Fun Walk Peduli Lingkungan', 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800', NULL, 'normal', 7, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-630e-4caa-ba9e-c3b26012006f', 'a2b40c67-6124-4356-b1c4-649dd6f2a95f', 'Lomba Egrang Putra FOTRADKAB', 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800', NULL, 'col-span-2 row-span-1', 8, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-634a-48ce-a539-6933d3ae21ca', 'a2b40c67-6171-4906-af84-264822c81522', 'Aerobik Pagi di Alun-Alun', 'https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=800', NULL, 'normal', 9, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-636d-4abc-8e25-9e39ee144e74', 'a2b40c67-614b-4fc2-99c0-5eda9028a705', 'Bedas Run: Finish Line', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', NULL, 'normal', 10, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-6396-4a07-93e5-cdb06067a965', 'a2b40c67-6191-4916-94c9-3811a7927431', 'Audiensi dengan Bupati', 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=800', NULL, 'normal', 11, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-63be-4700-bde5-04d0f1f6ad66', 'a2b40c67-61b3-42fe-9ca5-d580e2af86bd', 'Bakti Sosial KORMI Berbagi', 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800', NULL, 'normal', 12, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-25d7-4b30-8c7e-db3291c3e2a4', 'a2b44265-24a0-4d71-b8f4-302c7071be71', 'Pembukaan FORKAB 2025', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 'col-span-2 row-span-2', 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2616-474e-99eb-a0f178c3d5bc', 'a2b44265-2514-4587-bf92-ab95a509dd11', 'Senam Pagi Bersama Warga', 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800', NULL, 'normal', 2, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2653-4634-a567-c0c4772b4fd9', 'a2b44265-24d9-455b-9183-872d54ec42b1', 'Final Tarik Tambang FOTRADKAB', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800', NULL, 'normal', 3, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2670-42a9-84e1-a48cb446eb58', 'a2b44265-24f8-4ce0-aba1-c39825e18ee1', 'Start Line Bedas Run 2025', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', NULL, 'col-span-1 row-span-2', 4, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2689-4c50-b8ef-51f9b01c280d', 'a2b44265-2530-47e4-a5f3-ef309bff3c66', 'Rapat Koordinasi Pengurus', 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', NULL, 'normal', 5, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-26a1-4fed-9ecd-bf91d3a53c35', 'a2b44265-24a0-4d71-b8f4-302c7071be71', 'Penyerahan Medali Juara Umum', 'https://images.unsplash.com/photo-1526676023641-72e042776856?q=80&w=800', NULL, 'normal', 6, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-26b8-4443-b843-cab273e12e14', 'a2b44265-2553-409f-8534-33661441099a', 'Fun Walk Peduli Lingkungan', 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800', NULL, 'normal', 7, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-26cd-4404-88a2-a7c59388a078', 'a2b44265-24d9-455b-9183-872d54ec42b1', 'Lomba Egrang Putra FOTRADKAB', 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800', NULL, 'col-span-2 row-span-1', 8, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-26e2-4787-904a-77e6016be280', 'a2b44265-2514-4587-bf92-ab95a509dd11', 'Aerobik Pagi di Alun-Alun', 'https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=800', NULL, 'normal', 9, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-26fa-4568-a676-d284811c2309', 'a2b44265-24f8-4ce0-aba1-c39825e18ee1', 'Bedas Run: Finish Line', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', NULL, 'normal', 10, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-270f-4761-8c49-b88c5d933d2d', 'a2b44265-2530-47e4-a5f3-ef309bff3c66', 'Audiensi dengan Bupati', 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=800', NULL, 'normal', 11, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2723-4b43-b0bc-b1222d687d9a', 'a2b44265-2553-409f-8534-33661441099a', 'Bakti Sosial KORMI Berbagi', 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800', NULL, 'normal', 12, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-8bca-4918-a012-abad4ef0d8f0', 'a2b44566-8a44-4de0-acfa-0c9f163d48eb', 'Pembukaan FORKAB 2025', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', NULL, 'col-span-2 row-span-2', 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8c12-4f5b-8c62-132b1f810b29', 'a2b44566-8b58-4ce5-a405-12ab3835c174', 'Senam Pagi Bersama Warga', 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800', NULL, 'normal', 2, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8c2d-47b5-9fb7-5339588d3bfc', 'a2b44566-8af4-43ad-b63c-16bcaa18d689', 'Final Tarik Tambang FOTRADKAB', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800', NULL, 'normal', 3, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8c48-4142-83f5-80307184fea2', 'a2b44566-8b11-43ef-9dd6-adc5afa7156a', 'Start Line Bedas Run 2025', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', NULL, 'col-span-1 row-span-2', 4, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8c62-4a68-8580-92c594cc99ae', 'a2b44566-8b78-4805-8612-a3efe07f8576', 'Rapat Koordinasi Pengurus', 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', NULL, 'normal', 5, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8c7a-4bcb-9ce3-7d787db3aba9', 'a2b44566-8a44-4de0-acfa-0c9f163d48eb', 'Penyerahan Medali Juara Umum', 'https://images.unsplash.com/photo-1526676023641-72e042776856?q=80&w=800', NULL, 'normal', 6, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8c90-42ce-90d4-25845817819d', 'a2b44566-8b96-4438-9342-2168a00e894f', 'Fun Walk Peduli Lingkungan', 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800', NULL, 'normal', 7, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8ca5-421c-ba2c-645073a7c199', 'a2b44566-8af4-43ad-b63c-16bcaa18d689', 'Lomba Egrang Putra FOTRADKAB', 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800', NULL, 'col-span-2 row-span-1', 8, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8cbc-427a-88a6-29bacc546c7b', 'a2b44566-8b58-4ce5-a405-12ab3835c174', 'Aerobik Pagi di Alun-Alun', 'https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=800', NULL, 'normal', 9, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8cd6-48dd-bcde-b889fe74db1a', 'a2b44566-8b11-43ef-9dd6-adc5afa7156a', 'Bedas Run: Finish Line', 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', NULL, 'normal', 10, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8cec-4b5b-890b-571d4c4b532f', 'a2b44566-8b78-4805-8612-a3efe07f8576', 'Audiensi dengan Bupati', 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=800', NULL, 'normal', 11, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8d01-4980-916a-6306b13fc1d5', 'a2b44566-8b96-4438-9342-2168a00e894f', 'Bakti Sosial KORMI Berbagi', 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800', NULL, 'normal', 12, '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_inorga`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_inorga`;
CREATE TABLE `kormi_inorga` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `komisi_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_inorga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `singkatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ketua` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kontak_person` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_sekretariat` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nomor_sk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_sk` date DEFAULT NULL,
  `jumlah_klub_anggota` bigint NOT NULL DEFAULT '0',
  `logo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_keanggotaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `deskripsi_kegiatan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_inorga`
INSERT INTO `kormi_inorga` (`id`, `komisi_id`, `nama_inorga`, `singkatan`, `slug`, `nama_ketua`, `kontak_person`, `nomor_telepon`, `email`, `alamat_sekretariat`, `nomor_sk`, `tanggal_sk`, `jumlah_klub_anggota`, `logo_url`, `status_keanggotaan`, `deskripsi_kegiatan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-56e0-4af4-bba6-3308d52260a7', 'a2b40c67-5644-477b-8e35-237a8e400b5f', 'Persatuan Olahraga Tradisional Indonesia', 'PORTINA', 'portina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, 'aktif', NULL, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-570d-416a-ade4-0b2174bd0ded', 'a2b40c67-5644-477b-8e35-237a8e400b5f', 'Asosiasi Silat Tradisi Indonesia', 'ASTI', 'asti', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, NULL, 'aktif', NULL, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-573d-4d0d-bd26-d935effb2a99', 'a2b40c67-5644-477b-8e35-237a8e400b5f', 'Persatuan Liong dan Barongsai Seluruh Indonesia', 'PLBSI', 'plbsi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, NULL, 'aktif', NULL, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5774-43dc-ab64-22df50b30b29', 'a2b40c67-5669-41a2-bbee-c30544934fe8', 'Asosiasi Instruktur Aerobik dan Fitnes Indonesia', 'ASIAFI', 'asiafi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, 'aktif', NULL, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-57c0-4565-925f-2a945280ca5d', 'a2b40c67-5669-41a2-bbee-c30544934fe8', 'Senam Tera Indonesia', 'STI', 'sti', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, 'aktif', NULL, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-57fd-46f9-af7e-4d71da4b50fd', 'a2b40c67-5669-41a2-bbee-c30544934fe8', 'Indonesia Drum Corps Association', 'IDCA', 'idca', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 22, NULL, 'aktif', NULL, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-581e-47ca-a6d7-8b3347e2a5d0', 'a2b40c67-5696-4ba4-945b-774cdcc84c12', 'Federasi Airsoft Indonesia', 'FAI', 'fai', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 'aktif', NULL, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5855-4d00-8ae8-60c4733de182', 'a2b40c67-5696-4ba4-945b-774cdcc84c12', 'Barisan Atlet E-Sport Tradisional', 'BEST', 'best', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, 'aktif', NULL, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-1af9-48b4-b554-8bb7b21eddd3', 'a2b44265-1a4d-48d4-ae9b-67677dfd5c14', 'Persatuan Olahraga Tradisional Indonesia', 'PORTINA', 'portina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 22, NULL, 'aktif', NULL, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1b34-49ba-890d-4a4e1d653217', 'a2b44265-1a4d-48d4-ae9b-67677dfd5c14', 'Asosiasi Silat Tradisi Indonesia', 'ASTI', 'asti', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 24, NULL, 'aktif', NULL, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1b4a-4b9a-b43b-06d7004376f3', 'a2b44265-1a4d-48d4-ae9b-67677dfd5c14', 'Persatuan Liong dan Barongsai Seluruh Indonesia', 'PLBSI', 'plbsi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, NULL, 'aktif', NULL, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1b60-4e03-97c6-047a01f3bde3', 'a2b44265-1a77-46c8-bf54-1db8f10dd67d', 'Asosiasi Instruktur Aerobik dan Fitnes Indonesia', 'ASIAFI', 'asiafi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, NULL, 'aktif', NULL, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1b75-4078-9f76-a884e63428ee', 'a2b44265-1a77-46c8-bf54-1db8f10dd67d', 'Senam Tera Indonesia', 'STI', 'sti', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, 'aktif', NULL, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1b87-4f76-b97b-d1a7de33706e', 'a2b44265-1a77-46c8-bf54-1db8f10dd67d', 'Indonesia Drum Corps Association', 'IDCA', 'idca', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, 'aktif', NULL, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1ba6-49b9-b407-ae58f46e9825', 'a2b44265-1a90-4859-9f6b-b1ce9b335fe4', 'Federasi Airsoft Indonesia', 'FAI', 'fai', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, 'aktif', NULL, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1bc4-4780-ad3d-0d5dc6db5f79', 'a2b44265-1a90-4859-9f6b-b1ce9b335fe4', 'Barisan Atlet E-Sport Tradisional', 'BEST', 'best', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 18, NULL, 'aktif', NULL, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-802a-44fa-b998-5d6cb5e93689', 'a2b44566-7f56-43ed-9f4a-caba19f7d2f6', 'Persatuan Olahraga Tradisional Indonesia', 'PORTINA', 'portina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, 'aktif', NULL, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-80b7-449e-bd79-072336abc89b', 'a2b44566-7f56-43ed-9f4a-caba19f7d2f6', 'Asosiasi Silat Tradisi Indonesia', 'ASTI', 'asti', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, NULL, 'aktif', NULL, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-80d5-4936-b006-30373025d51c', 'a2b44566-7f56-43ed-9f4a-caba19f7d2f6', 'Persatuan Liong dan Barongsai Seluruh Indonesia', 'PLBSI', 'plbsi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, 'aktif', NULL, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-810d-47e7-acf1-099f2390e400', 'a2b44566-7fbb-4e93-a141-dd140f0bd007', 'Asosiasi Instruktur Aerobik dan Fitnes Indonesia', 'ASIAFI', 'asiafi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, NULL, 'aktif', NULL, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8124-4267-89df-5d7c78f9000a', 'a2b44566-7fbb-4e93-a141-dd140f0bd007', 'Senam Tera Indonesia', 'STI', 'sti', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, 'aktif', NULL, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8168-4bd8-968c-6a4622d2bdcd', 'a2b44566-7fbb-4e93-a141-dd140f0bd007', 'Indonesia Drum Corps Association', 'IDCA', 'idca', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, 'aktif', NULL, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-817e-4b12-83dd-741b34075a88', 'a2b44566-7fd5-4b3f-bd22-2e3ef4db62f8', 'Federasi Airsoft Indonesia', 'FAI', 'fai', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 22, NULL, 'aktif', NULL, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8194-4d3f-8e22-3bd8a83ea1e8', 'a2b44566-7fd5-4b3f-bd22-2e3ef4db62f8', 'Barisan Atlet E-Sport Tradisional', 'BEST', 'best', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, 'aktif', NULL, '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_kategori_berita`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_kategori_berita`;
CREATE TABLE `kormi_kategori_berita` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_warna_hex` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1bb55c',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_kategori_berita`
INSERT INTO `kormi_kategori_berita` (`id`, `nama_kategori`, `slug`, `kode_warna_hex`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-5e5e-438d-a8a5-90e8afa3aaec', 'Event', 'event', '#16a34a', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5e85-4c98-b5ca-c9ecb1153f15', 'Prestasi', 'prestasi', '#f59e0b', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5ea8-4bda-a02b-5c9824829e10', 'Kesehatan', 'kesehatan', '#ef4444', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5ed4-433c-81ba-a9c67f07ba86', 'Internal', 'internal', '#3b82f6', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5ef8-403b-b7a4-d7fba9c1cb80', 'Edukasi', 'edukasi', '#a855f7', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5f1b-4d11-a26c-8158029010f4', 'Sosial', 'sosial', '#ec4899', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-20c9-4c44-9637-c506a95ad312', 'Event', 'event', '#16a34a', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-20fc-4961-a5b8-7c8e4e2e8b08', 'Prestasi', 'prestasi', '#f59e0b', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2120-4071-97be-641126cd0040', 'Kesehatan', 'kesehatan', '#ef4444', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-2145-4030-8a75-939e52cfbb06', 'Internal', 'internal', '#3b82f6', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-216a-4c90-a7ba-71eced6f39c5', 'Edukasi', 'edukasi', '#a855f7', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-21a4-4ac4-9ada-3b2d8fea751d', 'Sosial', 'sosial', '#ec4899', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-8775-45e4-bc25-2c6ca073621c', 'Event', 'event', '#16a34a', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8799-40e1-929d-be62a36ab8de', 'Prestasi', 'prestasi', '#f59e0b', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-87b4-4895-91c4-9e5673088002', 'Kesehatan', 'kesehatan', '#ef4444', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-87cc-475a-8ff2-2f6e3b844daa', 'Internal', 'internal', '#3b82f6', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-87e1-49a5-a6f7-faa05d872e9b', 'Edukasi', 'edukasi', '#a855f7', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-87f7-48ad-95e6-a480386b5b0d', 'Sosial', 'sosial', '#ec4899', '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_kategori_event`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_kategori_event`;
CREATE TABLE `kormi_kategori_event` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_kategori_event`
INSERT INTO `kormi_kategori_event` (`id`, `nama_kategori`, `slug`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('6d4e2d32-c355-4197-9e0b-f5911ade9c79', 'Multi Event Daerah', 'multi-event-daerah', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('b9ed8a9a-baeb-43db-aed5-de2bc622203c', 'Multi Event Daerah', 'multi-event-daerah', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('babe8a25-0458-497a-9607-3a1b5086e917', 'Multi Event Daerah', 'multi-event-daerah', '2026-09-09 22:17:39', '2026-09-09 22:17:39');

-- --------------------------------------------------------
-- Table structure for `kormi_kategori_unduhan`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_kategori_unduhan`;
CREATE TABLE `kormi_kategori_unduhan` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_kategori_unduhan`
INSERT INTO `kormi_kategori_unduhan` (`id`, `nama_kategori`, `slug`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'Regulasi & SK', 'regulasi-sk', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5d2f-48cf-88af-afe1fb0daf74', 'Program Kerja', 'program-kerja', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5d5b-48df-b7cf-a830e4d60dd7', 'Formulir', 'formulir', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-1ef0-4bde-8da3-53e6a9a26b0f', 'Regulasi & SK', 'regulasi-sk', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1f4d-440d-a93f-24fff1b20af9', 'Program Kerja', 'program-kerja', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1f74-4adf-8d35-b97365714201', 'Formulir', 'formulir', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-85b3-4134-96cc-0966674cdf38', 'Regulasi & SK', 'regulasi-sk', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-85d1-43e4-87d3-90adbbb68fb1', 'Program Kerja', 'program-kerja', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8617-4fd6-9baf-e632e3918668', 'Formulir', 'formulir', '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_kecamatan`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_kecamatan`;
CREATE TABLE `kormi_kecamatan` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kecamatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_kantor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(15,2) DEFAULT NULL,
  `longitude` decimal(15,2) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_kecamatan`
INSERT INTO `kormi_kecamatan` (`id`, `nama_kecamatan`, `slug`, `alamat_kantor`, `nomor_telepon`, `latitude`, `longitude`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', 'Arjasari', 'arjasari', 'Kantor Kecamatan Arjasari, Kabupaten Bandung', '022-5847128', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Baleendah', 'baleendah', 'Kantor Kecamatan Baleendah, Kabupaten Bandung', '022-5943378', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-202d-4b46-9992-de88e8468387', 'Banjaran', 'banjaran', 'Kantor Kecamatan Banjaran, Kabupaten Bandung', '022-5944030', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2055-4489-a532-a4a81f080c7f', 'Bojongsoang', 'bojongsoang', 'Kantor Kecamatan Bojongsoang, Kabupaten Bandung', '022-5841223', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-207c-45ba-8abe-d231f3e82e38', 'Cangkuang', 'cangkuang', 'Kantor Kecamatan Cangkuang, Kabupaten Bandung', '022-5890892', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-20a3-4613-8c86-241248986fd0', 'Cicalengka', 'cicalengka', 'Kantor Kecamatan Cicalengka, Kabupaten Bandung', '022-5920231', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-20ca-4f47-b2c4-318e28df2e07', 'Cikancung', 'cikancung', 'Kantor Kecamatan Cikancung, Kabupaten Bandung', '022-5873165', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', 'Cilengkrang', 'cilengkrang', 'Kantor Kecamatan Cilengkrang, Kabupaten Bandung', '022-5914845', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2135-481e-97b8-592488466ec6', 'Cileunyi', 'cileunyi', 'Kantor Kecamatan Cileunyi, Kabupaten Bandung', '022-5918240', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2163-4d41-b380-13297da90a64', 'Cimaung', 'cimaung', 'Kantor Kecamatan Cimaung, Kabupaten Bandung', '022-5985777', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-218d-4f74-a4b6-8766d6fbdafe', 'Cimeunyan', 'cimeunyan', 'Kantor Kecamatan Cimeunyan, Kabupaten Bandung', '022-5928765', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-21b3-45e0-bc98-0c8295ab12b7', 'Ciparay', 'ciparay', 'Kantor Kecamatan Ciparay, Kabupaten Bandung', '022-5829295', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-21d8-46f8-8925-45195a58f962', 'Ciwidey', 'ciwidey', 'Kantor Kecamatan Ciwidey, Kabupaten Bandung', '022-5837662', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2200-43d0-b5a3-58d1d395a033', 'Dayeuhkolot', 'dayeuhkolot', 'Kantor Kecamatan Dayeuhkolot, Kabupaten Bandung', '022-5807543', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2228-4d0b-802a-63f0b16c9053', 'Ibun', 'ibun', 'Kantor Kecamatan Ibun, Kabupaten Bandung', '022-5862998', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-224e-4072-a647-fc87c51c98cd', 'Katapang', 'katapang', 'Kantor Kecamatan Katapang, Kabupaten Bandung', '022-5882885', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-227f-4ec6-9c7e-85eb0ec80fa3', 'Kertasari', 'kertasari', 'Kantor Kecamatan Kertasari, Kabupaten Bandung', '022-5947075', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-22ac-4984-a7a7-6f0c77b21a8f', 'Kutawaringin', 'kutawaringin', 'Kantor Kecamatan Kutawaringin, Kabupaten Bandung', '022-5900930', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-22f6-4a59-857b-29a3036964b6', 'Majalaya', 'majalaya', 'Kantor Kecamatan Majalaya, Kabupaten Bandung', '022-5867803', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2320-4fa2-964b-bc8c0168c8ff', 'Margaasih', 'margaasih', 'Kantor Kecamatan Margaasih, Kabupaten Bandung', '022-5945636', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-234c-4066-ade5-6ebdadfadd2f', 'Margahayu', 'margahayu', 'Kantor Kecamatan Margahayu, Kabupaten Bandung', '022-5810918', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2378-4ef6-8a41-7b3db0adf1af', 'Nagreg', 'nagreg', 'Kantor Kecamatan Nagreg, Kabupaten Bandung', '022-5933361', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-239f-4581-86ca-80b199f142e3', 'Pacet', 'pacet', 'Kantor Kecamatan Pacet, Kabupaten Bandung', '022-5948415', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-23df-4eb9-9f7a-0e81c96eb35b', 'Pameungpeuk', 'pameungpeuk', 'Kantor Kecamatan Pameungpeuk, Kabupaten Bandung', '022-5898816', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-240d-4b48-84ed-bca47694438d', 'Pangalengan', 'pangalengan', 'Kantor Kecamatan Pangalengan, Kabupaten Bandung', '022-5978136', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2438-4639-8bab-d74dac91f9ec', 'Paseh', 'paseh', 'Kantor Kecamatan Paseh, Kabupaten Bandung', '022-5853926', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2468-4020-9b31-7a279780859c', 'Pasirjambu', 'pasirjambu', 'Kantor Kecamatan Pasirjambu, Kabupaten Bandung', '022-5969244', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-24a7-45b7-adfa-06e919c7f9db', 'Rancabali', 'rancabali', 'Kantor Kecamatan Rancabali, Kabupaten Bandung', '022-5972060', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-24db-413e-892f-2333b7a653c1', 'Rancaekek', 'rancaekek', 'Kantor Kecamatan Rancaekek, Kabupaten Bandung', '022-5829688', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-250b-47c9-ba2b-ef0567772ee5', 'Solokanjeruk', 'solokanjeruk', 'Kantor Kecamatan Solokanjeruk, Kabupaten Bandung', '022-5859373', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b40c67-2538-40be-82bc-3782bfaad813', 'Soreang', 'soreang', 'Kantor Kecamatan Soreang, Kabupaten Bandung', '022-5993283', NULL, NULL, '2026-09-09 22:17:38', '2026-09-09 22:17:38');

-- --------------------------------------------------------
-- Table structure for `kormi_komisi_inorga`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_komisi_inorga`;
CREATE TABLE `kormi_komisi_inorga` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_komisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `singkatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kode_warna_hex` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1bb55c',
  `urutan` bigint NOT NULL DEFAULT '0',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_komisi_inorga`
INSERT INTO `kormi_komisi_inorga` (`id`, `nama_komisi`, `singkatan`, `deskripsi`, `kode_warna_hex`, `urutan`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-5644-477b-8e35-237a8e400b5f', 'Olahraga Tradisional dan Kreasi Budaya', 'OTDA', NULL, '#16a34a', 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5669-41a2-bbee-c30544934fe8', 'Olahraga Kesehatan dan Kebugaran', 'OKK', NULL, '#2563eb', 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-5696-4ba4-945b-774cdcc84c12', 'Olahraga Petualangan dan Tantangan', 'OPT', NULL, '#f97316', 0, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-1a4d-48d4-ae9b-67677dfd5c14', 'Olahraga Tradisional dan Kreasi Budaya', 'OTDA', NULL, '#16a34a', 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1a77-46c8-bf54-1db8f10dd67d', 'Olahraga Kesehatan dan Kebugaran', 'OKK', NULL, '#2563eb', 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-1a90-4859-9f6b-b1ce9b335fe4', 'Olahraga Petualangan dan Tantangan', 'OPT', NULL, '#f97316', 0, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-7f56-43ed-9f4a-caba19f7d2f6', 'Olahraga Tradisional dan Kreasi Budaya', 'OTDA', NULL, '#16a34a', 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-7fbb-4e93-a141-dd140f0bd007', 'Olahraga Kesehatan dan Kebugaran', 'OKK', NULL, '#2563eb', 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-7fd5-4b3f-bd22-2e3ef4db62f8', 'Olahraga Petualangan dan Tantangan', 'OPT', NULL, '#f97316', 0, '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_kordik_pengurus`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_kordik_pengurus`;
CREATE TABLE `kormi_kordik_pengurus` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ketua` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_sekretaris` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_bendahara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_sk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_ketua_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_aktif` bigint NOT NULL DEFAULT '1',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_kordik_pengurus`
INSERT INTO `kormi_kordik_pengurus` (`id`, `kecamatan_id`, `periode_id`, `nama_ketua`, `nama_sekretaris`, `nama_bendahara`, `nomor_telepon`, `nomor_sk`, `foto_ketua_url`, `status_aktif`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('09046d6f-9225-485a-891e-ccb97665a50c', 'a2b40c67-234c-4066-ade5-6ebdadfadd2f', '38fa6574-029d-4e8c-980f-368fb7345728', 'YUYUN YUNINGSIH', NULL, NULL, '08122345021', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('0a1753d3-ea76-4006-adf1-94db8a31f9ef', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'ENDAH FERAWATI', NULL, NULL, '08122345005', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('0b4b5a18-e317-4807-980e-6d3125dcd16d', 'a2b40c67-2320-4fa2-964b-bc8c0168c8ff', '13899c0d-26dd-4edb-841e-349208335d3c', 'WENNY WINARNY, SE., MM', NULL, NULL, '08122345020', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('1c7c5ade-7c17-462b-b5c3-f1a69f0ee637', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', '38fa6574-029d-4e8c-980f-368fb7345728', 'POPY JAYANTHI', NULL, NULL, '08122345012', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('1e9a59a6-3a30-4b08-8805-d4cde3c9d5e7', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', '13899c0d-26dd-4edb-841e-349208335d3c', 'IKA KARTIKA HIDAYAT', NULL, NULL, '08122345002', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('207d9ed5-9cde-4d06-9a8a-d7b0707630da', 'a2b40c67-2538-40be-82bc-3782bfaad813', '13899c0d-26dd-4edb-841e-349208335d3c', 'HJ. RIA RESTIANA R', NULL, NULL, '08122345031', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('207df0d4-3257-4eb4-94ce-330c1a5505a7', 'a2b40c67-2378-4ef6-8a41-7b3db0adf1af', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'RETNO MULIAYANI', NULL, NULL, '08122345022', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('21d3f357-ea3b-441e-8d99-d861c8f99fa2', 'a2b40c67-2320-4fa2-964b-bc8c0168c8ff', '38fa6574-029d-4e8c-980f-368fb7345728', 'WENNY WINARNY, SE., MM', NULL, NULL, '08122345020', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('233ce290-51dd-497d-a49b-c121a7587d96', 'a2b40c67-2468-4020-9b31-7a279780859c', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'IKA KARTIKA SARI', NULL, NULL, '08122345027', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('2c781fa1-7c0b-4507-8eed-e17f7314835f', 'a2b40c67-2163-4d41-b380-13297da90a64', '13899c0d-26dd-4edb-841e-349208335d3c', 'RITA SUKARSO', NULL, NULL, '08122345010', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('2d2da022-b395-43ff-874c-919869822a2c', 'a2b40c67-2135-481e-97b8-592488466ec6', '13899c0d-26dd-4edb-841e-349208335d3c', 'LANNY MULIAMAH', NULL, NULL, '08122345009', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('2e444d40-256f-4680-8a65-4b21f6831363', 'a2b40c67-2135-481e-97b8-592488466ec6', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'LANNY MULIAMAH', NULL, NULL, '08122345009', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('2eed3e0a-c0e7-44d8-a679-e50e12dc92f5', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'NOPI GANDINI', NULL, NULL, '08122345001', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('2ffbde32-6305-4bda-89c2-9236cc041568', 'a2b40c67-22ac-4984-a7a7-6f0c77b21a8f', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'WIWIN WINARNI', NULL, NULL, '08122345018', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('333c1dd3-791a-4dc2-9c0c-c4d300059c35', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', '38fa6574-029d-4e8c-980f-368fb7345728', 'DEBBY HERAWATY', NULL, NULL, '08122345008', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('36854419-5067-4034-a5e9-c6711c57c5e5', 'a2b40c67-234c-4066-ade5-6ebdadfadd2f', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'YUYUN YUNINGSIH', NULL, NULL, '08122345021', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('3704778d-9b58-407a-bfd7-ce944187a476', 'a2b40c67-24a7-45b7-adfa-06e919c7f9db', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'DEDEH YUNINGSIH', NULL, NULL, '08122345028', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('381c8516-a401-4a62-bf9f-f5c9c3735757', 'a2b40c67-23df-4eb9-9f7a-0e81c96eb35b', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'RIKA HUMAIROH, S.Sos', NULL, NULL, '08122345024', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('38fb6e22-18b6-426a-bdf9-de5b2028c312', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'ADE ROMLAH, S. Ag', NULL, NULL, '08122345007', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('3bc9bb37-52f3-4951-9256-4dc45a728e9b', 'a2b40c67-2468-4020-9b31-7a279780859c', '13899c0d-26dd-4edb-841e-349208335d3c', 'IKA KARTIKA SARI', NULL, NULL, '08122345027', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('3d0907ce-15ed-4732-a7fe-c6ff84b60861', 'a2b40c67-20a3-4613-8c86-241248986fd0', '13899c0d-26dd-4edb-841e-349208335d3c', 'ANI TARYANI', NULL, NULL, '08122345006', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('3d801b32-377d-4c3e-85cd-adf03a11b227', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', '38fa6574-029d-4e8c-980f-368fb7345728', 'SRI HETY PERTAMAWATI', NULL, NULL, '08122345011', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('3d91a1ec-6715-46a6-b050-fc9b503f8171', 'a2b40c67-234c-4066-ade5-6ebdadfadd2f', '13899c0d-26dd-4edb-841e-349208335d3c', 'YUYUN YUNINGSIH', NULL, NULL, '08122345021', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('3ee3b724-4350-4745-9285-3460fc24f1f7', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', '13899c0d-26dd-4edb-841e-349208335d3c', 'POPY JAYANTHI', NULL, NULL, '08122345012', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('3f32d1e0-c3c5-4a5b-a209-3043f06c0709', 'a2b40c67-202d-4b46-9992-de88e8468387', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'HILDA HIDAYAH, SP', NULL, NULL, '08122345003', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('3fbe28c7-57d6-484c-b45c-22da9bf1a59b', 'a2b40c67-24db-413e-892f-2333b7a653c1', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'drg. NOVITA UTAMI', NULL, NULL, '08122345029', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('401bd5d1-2d37-4007-a2a5-1c29f42012c1', 'a2b40c67-250b-47c9-ba2b-ef0567772ee5', '13899c0d-26dd-4edb-841e-349208335d3c', 'YOIKA INDRAWATI', NULL, NULL, '08122345030', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('402fdb14-775d-4f88-a6dc-79fbf166dffd', 'a2b40c67-2055-4489-a532-a4a81f080c7f', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'ERNA AGUSTINA, A.Md. Far', NULL, NULL, '08122345004', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('439d9cb1-0b67-4d04-82c8-65e3cccb0713', 'a2b40c67-2055-4489-a532-a4a81f080c7f', '13899c0d-26dd-4edb-841e-349208335d3c', 'ERNA AGUSTINA, A.Md. Far', NULL, NULL, '08122345004', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('443cc1c5-b0c3-4c42-ba76-b48800fac8ad', 'a2b40c67-2055-4489-a532-a4a81f080c7f', '38fa6574-029d-4e8c-980f-368fb7345728', 'ERNA AGUSTINA, A.Md. Far', NULL, NULL, '08122345004', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('4a08313f-10a8-4ab5-a3ec-97ffbd7442e0', 'a2b40c67-202d-4b46-9992-de88e8468387', '38fa6574-029d-4e8c-980f-368fb7345728', 'HILDA HIDAYAH, SP', NULL, NULL, '08122345003', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('4bd1e52d-be61-4e8b-9762-cb4d6839ea2a', 'a2b40c67-2200-43d0-b5a3-58d1d395a033', '38fa6574-029d-4e8c-980f-368fb7345728', 'LINDA NURKANIA, SE.,M.Pd', NULL, NULL, '08122345014', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('4d0ce5f3-6f7b-4e02-877b-356528f6d738', 'a2b40c67-224e-4072-a647-fc87c51c98cd', '13899c0d-26dd-4edb-841e-349208335d3c', 'DR. ARLINA, M.Pd', NULL, NULL, '08122345016', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('4da5cdd9-3c0b-44a6-8e07-e1f0ca25d3d3', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'DEBBY HERAWATY', NULL, NULL, '08122345008', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('4eab4693-1443-4830-855c-2d40f5945292', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'SRI HETY PERTAMAWATI', NULL, NULL, '08122345011', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('5599b2c3-f3d9-4cde-971a-e8a35acd29b4', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', '38fa6574-029d-4e8c-980f-368fb7345728', 'IKA KARTIKA HIDAYAT', NULL, NULL, '08122345002', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('58345595-8046-4399-9bb4-e34f42577b14', 'a2b40c67-21d8-46f8-8925-45195a58f962', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'LALA SITI JAMILAH, S. Sos,Msi', NULL, NULL, '08122345013', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('58dde4c2-fc00-4dec-8c41-cc5d5cc7246f', 'a2b40c67-2228-4d0b-802a-63f0b16c9053', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'SUSI SUSILAWATI', NULL, NULL, '08122345015', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('5b966082-1a69-4918-8975-3e098c047f06', 'a2b40c67-24a7-45b7-adfa-06e919c7f9db', '13899c0d-26dd-4edb-841e-349208335d3c', 'DEDEH YUNINGSIH', NULL, NULL, '08122345028', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('608eeac9-e336-4bbe-8cb3-7b85fe396f8f', 'a2b40c67-21d8-46f8-8925-45195a58f962', '38fa6574-029d-4e8c-980f-368fb7345728', 'LALA SITI JAMILAH, S. Sos,Msi', NULL, NULL, '08122345013', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('6211386b-6e42-4a74-a511-6b06c904d92b', 'a2b40c67-227f-4ec6-9c7e-85eb0ec80fa3', '13899c0d-26dd-4edb-841e-349208335d3c', 'HENNA ENAYAH, SH', NULL, NULL, '08122345017', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('636aa7b8-522c-425b-b176-1df91fc88cc9', 'a2b40c67-22ac-4984-a7a7-6f0c77b21a8f', '13899c0d-26dd-4edb-841e-349208335d3c', 'WIWIN WINARNI', NULL, NULL, '08122345018', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('64dc6764-f987-4cd0-9a4d-9d7c73cd2ccc', 'a2b40c67-202d-4b46-9992-de88e8468387', '13899c0d-26dd-4edb-841e-349208335d3c', 'HILDA HIDAYAH, SP', NULL, NULL, '08122345003', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('680c4653-2dab-4c18-a998-65b4dc3f499b', 'a2b40c67-22f6-4a59-857b-29a3036964b6', '13899c0d-26dd-4edb-841e-349208335d3c', 'FARIDA', NULL, NULL, '08122345019', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('692c922a-c23a-44eb-8968-b9a227835986', 'a2b40c67-2438-4639-8bab-d74dac91f9ec', '38fa6574-029d-4e8c-980f-368fb7345728', 'WATWAT JULIAWATI', NULL, NULL, '08122345026', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('6ad08008-d64f-4035-8a3d-bc73a2d154c8', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', '38fa6574-029d-4e8c-980f-368fb7345728', 'NOPI GANDINI', NULL, NULL, '08122345001', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('6d776380-5b3c-450f-aeda-f6f5bb0b53f7', 'a2b40c67-227f-4ec6-9c7e-85eb0ec80fa3', '38fa6574-029d-4e8c-980f-368fb7345728', 'HENNA ENAYAH, SH', NULL, NULL, '08122345017', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('712f72ca-7e97-4a2a-9cfe-6e6accbd1881', 'a2b40c67-240d-4b48-84ed-bca47694438d', '13899c0d-26dd-4edb-841e-349208335d3c', 'NOVITA SARDI', NULL, NULL, '08122345025', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('71b36c8a-1860-4f65-94d8-6988bcf3fae4', 'a2b40c67-250b-47c9-ba2b-ef0567772ee5', '38fa6574-029d-4e8c-980f-368fb7345728', 'YOIKA INDRAWATI', NULL, NULL, '08122345030', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('769b179f-cef1-4514-b507-6f67dea9788e', 'a2b40c67-22f6-4a59-857b-29a3036964b6', '38fa6574-029d-4e8c-980f-368fb7345728', 'FARIDA', NULL, NULL, '08122345019', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37');
INSERT INTO `kormi_kordik_pengurus` (`id`, `kecamatan_id`, `periode_id`, `nama_ketua`, `nama_sekretaris`, `nama_bendahara`, `nomor_telepon`, `nomor_sk`, `foto_ketua_url`, `status_aktif`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('7cac1820-c5ea-43dd-85ee-5bbf7f69173c', 'a2b40c67-23df-4eb9-9f7a-0e81c96eb35b', '38fa6574-029d-4e8c-980f-368fb7345728', 'RIKA HUMAIROH, S.Sos', NULL, NULL, '08122345024', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('7ffaa21b-d089-4103-8c6d-23cc96fe63f8', 'a2b40c67-2228-4d0b-802a-63f0b16c9053', '13899c0d-26dd-4edb-841e-349208335d3c', 'SUSI SUSILAWATI', NULL, NULL, '08122345015', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('7fffa881-3f4d-4dca-affb-37c546f42c30', 'a2b40c67-21d8-46f8-8925-45195a58f962', '13899c0d-26dd-4edb-841e-349208335d3c', 'LALA SITI JAMILAH, S. Sos,Msi', NULL, NULL, '08122345013', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('84937d24-48ba-428b-9add-1a1a2c6ebf50', 'a2b40c67-2378-4ef6-8a41-7b3db0adf1af', '13899c0d-26dd-4edb-841e-349208335d3c', 'RETNO MULIAYANI', NULL, NULL, '08122345022', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('89a799c3-32d2-49a7-8ed5-afbb7c085c01', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', '38fa6574-029d-4e8c-980f-368fb7345728', 'ADE ROMLAH, S. Ag', NULL, NULL, '08122345007', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('9088b6ed-dfcf-41d8-9615-8ab5265bd087', 'a2b40c67-240d-4b48-84ed-bca47694438d', '38fa6574-029d-4e8c-980f-368fb7345728', 'NOVITA SARDI', NULL, NULL, '08122345025', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('95e749b6-7d9a-404d-bda7-24eeddb5ea0f', 'a2b40c67-20a3-4613-8c86-241248986fd0', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'ANI TARYANI', NULL, NULL, '08122345006', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('97528f77-07dc-443f-8b55-b90565365d9a', 'a2b40c67-227f-4ec6-9c7e-85eb0ec80fa3', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'HENNA ENAYAH, SH', NULL, NULL, '08122345017', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('9882736a-d560-45ba-a162-1d25e3d74ac1', 'a2b40c67-239f-4581-86ca-80b199f142e3', '13899c0d-26dd-4edb-841e-349208335d3c', 'NINING SARIPAH', NULL, NULL, '08122345023', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('98a3795d-86c1-44fe-aa3d-01d3aa7a50f6', 'a2b40c67-239f-4581-86ca-80b199f142e3', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'NINING SARIPAH', NULL, NULL, '08122345023', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a8faa1c5-7ab3-434b-9b8a-8317cf28c8e3', 'a2b40c67-2320-4fa2-964b-bc8c0168c8ff', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'WENNY WINARNY, SE., MM', NULL, NULL, '08122345020', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('ab271fc1-c8a6-4fb0-80d4-839612c2a2cd', 'a2b40c67-2228-4d0b-802a-63f0b16c9053', '38fa6574-029d-4e8c-980f-368fb7345728', 'SUSI SUSILAWATI', NULL, NULL, '08122345015', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('ae7da7c8-650a-4365-a8d0-8e60f263cc3b', 'a2b40c67-2200-43d0-b5a3-58d1d395a033', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'LINDA NURKANIA, SE.,M.Pd', NULL, NULL, '08122345014', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('af8446d7-243e-4eca-beaa-8e894407c6a5', 'a2b40c67-2468-4020-9b31-7a279780859c', '38fa6574-029d-4e8c-980f-368fb7345728', 'IKA KARTIKA SARI', NULL, NULL, '08122345027', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('b1c6b2cf-2e91-4343-9b26-461ebf2677e5', 'a2b40c67-2538-40be-82bc-3782bfaad813', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'HJ. RIA RESTIANA R', NULL, NULL, '08122345031', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('b32cab71-7d67-4360-8390-1c510c785475', 'a2b40c67-2200-43d0-b5a3-58d1d395a033', '13899c0d-26dd-4edb-841e-349208335d3c', 'LINDA NURKANIA, SE.,M.Pd', NULL, NULL, '08122345014', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('b44ffc1d-6a4a-4e03-9bfa-a46541dd7369', 'a2b40c67-2538-40be-82bc-3782bfaad813', '38fa6574-029d-4e8c-980f-368fb7345728', 'HJ. RIA RESTIANA R', NULL, NULL, '08122345031', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('b51344c0-8555-44e6-ab69-23742c299f88', 'a2b40c67-2163-4d41-b380-13297da90a64', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'RITA SUKARSO', NULL, NULL, '08122345010', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('b6e98e63-1bfa-4443-a87e-6b398e8f8d06', 'a2b40c67-24db-413e-892f-2333b7a653c1', '13899c0d-26dd-4edb-841e-349208335d3c', 'drg. NOVITA UTAMI', NULL, NULL, '08122345029', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('ba61ed33-0e35-4bae-87d0-85333298ae6e', 'a2b40c67-2135-481e-97b8-592488466ec6', '38fa6574-029d-4e8c-980f-368fb7345728', 'LANNY MULIAMAH', NULL, NULL, '08122345009', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('bc5b9cc7-fada-41b8-8167-fec1cacc59ec', 'a2b40c67-250b-47c9-ba2b-ef0567772ee5', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'YOIKA INDRAWATI', NULL, NULL, '08122345030', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('befba415-263e-43e7-9fb5-ab3efb047208', 'a2b40c67-2438-4639-8bab-d74dac91f9ec', '13899c0d-26dd-4edb-841e-349208335d3c', 'WATWAT JULIAWATI', NULL, NULL, '08122345026', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('c09b4e78-3c0a-4f52-b0b9-c361a2345008', 'a2b40c67-23df-4eb9-9f7a-0e81c96eb35b', '13899c0d-26dd-4edb-841e-349208335d3c', 'RIKA HUMAIROH, S.Sos', NULL, NULL, '08122345024', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('c48707f8-a5b4-49cb-b2d2-95b577189b03', 'a2b40c67-239f-4581-86ca-80b199f142e3', '38fa6574-029d-4e8c-980f-368fb7345728', 'NINING SARIPAH', NULL, NULL, '08122345023', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('c8066d0d-06de-4203-a4ba-9ac80567a822', 'a2b40c67-24db-413e-892f-2333b7a653c1', '38fa6574-029d-4e8c-980f-368fb7345728', 'drg. NOVITA UTAMI', NULL, NULL, '08122345029', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('c82e4242-4d25-4ed5-b793-e3688d416b13', 'a2b40c67-240d-4b48-84ed-bca47694438d', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'NOVITA SARDI', NULL, NULL, '08122345025', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('d934ef4c-e908-4210-90c3-79c18399f11a', 'a2b40c67-22ac-4984-a7a7-6f0c77b21a8f', '38fa6574-029d-4e8c-980f-368fb7345728', 'WIWIN WINARNI', NULL, NULL, '08122345018', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('d99687b3-c89e-45db-a8d0-8bc401d66e14', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', '13899c0d-26dd-4edb-841e-349208335d3c', 'ENDAH FERAWATI', NULL, NULL, '08122345005', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('d9d7372f-8d86-4c3f-a972-d38760f37fbb', 'a2b40c67-2438-4639-8bab-d74dac91f9ec', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'WATWAT JULIAWATI', NULL, NULL, '08122345026', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('dac2aac3-522d-433c-ba2c-fda35197a573', 'a2b40c67-224e-4072-a647-fc87c51c98cd', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'DR. ARLINA, M.Pd', NULL, NULL, '08122345016', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('e1c4b978-3dc1-41c5-aed7-3dd7ff8b2de9', 'a2b40c67-20ca-4f47-b2c4-318e28df2e07', '13899c0d-26dd-4edb-841e-349208335d3c', 'ADE ROMLAH, S. Ag', NULL, NULL, '08122345007', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('e2a93796-b67a-41d7-a060-b19a40bde9d0', 'a2b40c67-20a3-4613-8c86-241248986fd0', '38fa6574-029d-4e8c-980f-368fb7345728', 'ANI TARYANI', NULL, NULL, '08122345006', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('e86a8a18-eafb-4959-868a-a3c8c3f1edbb', 'a2b40c67-1fd1-4a56-8b6d-ef02065c4b79', '13899c0d-26dd-4edb-841e-349208335d3c', 'NOPI GANDINI', NULL, NULL, '08122345001', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('ea102f7d-2229-4a25-bdf7-caeb05cca782', 'a2b40c67-224e-4072-a647-fc87c51c98cd', '38fa6574-029d-4e8c-980f-368fb7345728', 'DR. ARLINA, M.Pd', NULL, NULL, '08122345016', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('eb3c26df-9fb1-4ff9-b97a-1acf04bc7329', 'a2b40c67-24a7-45b7-adfa-06e919c7f9db', '38fa6574-029d-4e8c-980f-368fb7345728', 'DEDEH YUNINGSIH', NULL, NULL, '08122345028', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('ecf3f65a-e3c6-46e3-b69f-2b0807f5065b', 'a2b40c67-21b3-45e0-bc98-0c8295ab12b7', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'POPY JAYANTHI', NULL, NULL, '08122345012', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('ed80f2db-35af-4fde-b2a0-43988bf76522', 'a2b40c67-2163-4d41-b380-13297da90a64', '38fa6574-029d-4e8c-980f-368fb7345728', 'RITA SUKARSO', NULL, NULL, '08122345010', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('eef89a2a-23f0-4a37-8835-36e638eee8ab', 'a2b40c67-2378-4ef6-8a41-7b3db0adf1af', '38fa6574-029d-4e8c-980f-368fb7345728', 'RETNO MULIAYANI', NULL, NULL, '08122345022', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('f0a850b0-c42c-4956-89c4-b22cb9d36b2c', 'a2b40c67-22f6-4a59-857b-29a3036964b6', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'FARIDA', NULL, NULL, '08122345019', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('f563f02b-8f3b-4c58-ab4c-261aa694c284', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'IKA KARTIKA HIDAYAT', NULL, NULL, '08122345002', NULL, NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('f5d9a365-5cd5-4376-9412-cc3dd4eeb6ab', 'a2b40c67-207c-45ba-8abe-d231f3e82e38', '38fa6574-029d-4e8c-980f-368fb7345728', 'ENDAH FERAWATI', NULL, NULL, '08122345005', NULL, NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('f99f4a55-6c20-4b37-930b-e84b257a8f95', 'a2b40c67-218d-4f74-a4b6-8766d6fbdafe', '13899c0d-26dd-4edb-841e-349208335d3c', 'SRI HETY PERTAMAWATI', NULL, NULL, '08122345011', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('ff25ab5d-73e0-4c87-86cc-56d616b1c47c', 'a2b40c67-20f0-4fa0-a3b3-6b2314ad775b', '13899c0d-26dd-4edb-841e-349208335d3c', 'DEBBY HERAWATY', NULL, NULL, '08122345008', NULL, NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_linimasa_sejarah`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_linimasa_sejarah`;
CREATE TABLE `kormi_linimasa_sejarah` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` bigint NOT NULL DEFAULT '0',
  `status_tampil` bigint NOT NULL DEFAULT '1',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_linimasa_sejarah`
INSERT INTO `kormi_linimasa_sejarah` (`id`, `tahun`, `judul`, `deskripsi`, `gambar_url`, `urutan`, `status_tampil`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('016be00d-04af-4926-b336-fdceedca1132', '2000 - 2010', 'Era Perintisan (FOMI)', 'Berdiri sebagai wadah awal penghimpun induk-induk olahraga tradisional dan senam rekreasi di Kabupaten Bandung dengan pembinaan berpusat di komunitas lokal.', NULL, 1, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('0f4e2b5d-1a0d-435c-b9af-240c691e2255', '2023 - 2026+', 'Era Akselerasi Menuju Indonesia Bugar', 'Pengukuhan Duta Olahraga di 280 desa/kelurahan, digitalisasi portal informasi, serta pembinaan berkelanjutan menuju masyarakat Kabupaten Bandung yang Bedas.', NULL, 4, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('25134c69-9416-47b9-95af-befb154ff248', '2011 - 2019', 'Transformasi & Penguatan (FORMI)', 'Bertransformasi menjadi FORMI Kabupaten Bandung dengan konsolidasi kelembagaan di 31 kecamatan dan penyelenggaraan Festival Olahraga Rekreasi skala massal.', NULL, 2, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('3b505f1d-2a5e-40ee-b3d6-abcf7a6eafea', '2011 - 2019', 'Transformasi & Penguatan (FORMI)', 'Bertransformasi menjadi FORMI Kabupaten Bandung dengan konsolidasi kelembagaan di 31 kecamatan dan penyelenggaraan Festival Olahraga Rekreasi skala massal.', NULL, 2, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('540392f0-ab5f-4f31-872e-82727796268b', '2020 - 2022', 'Restrukturisasi KORMI', 'Perubahan nomenklatur resmi menjadi KORMI sesuai dinamika regulasi nasional dan penataan 3 rumpun komisi olahraga (OTDA, OKK, OPT).', NULL, 3, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('6a9be1ba-6554-4bf6-b669-4aede395fe13', '2011 - 2019', 'Transformasi & Penguatan (FORMI)', 'Bertransformasi menjadi FORMI Kabupaten Bandung dengan konsolidasi kelembagaan di 31 kecamatan dan penyelenggaraan Festival Olahraga Rekreasi skala massal.', NULL, 2, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('7289ac18-eb3a-402f-9e14-a96cae0eed95', '2020 - 2022', 'Restrukturisasi KORMI', 'Perubahan nomenklatur resmi menjadi KORMI sesuai dinamika regulasi nasional dan penataan 3 rumpun komisi olahraga (OTDA, OKK, OPT).', NULL, 3, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('869550b4-341a-4aa9-b7cc-481c3789b225', '2023 - 2026+', 'Era Akselerasi Menuju Indonesia Bugar', 'Pengukuhan Duta Olahraga di 280 desa/kelurahan, digitalisasi portal informasi, serta pembinaan berkelanjutan menuju masyarakat Kabupaten Bandung yang Bedas.', NULL, 4, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('8ff1f897-d50f-4c4e-96e0-47a193759f05', '2000 - 2010', 'Era Perintisan (FOMI)', 'Berdiri sebagai wadah awal penghimpun induk-induk olahraga tradisional dan senam rekreasi di Kabupaten Bandung dengan pembinaan berpusat di komunitas lokal.', NULL, 1, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('9115175c-dae6-4103-8911-aa85db970c50', '2000 - 2010', 'Era Perintisan (FOMI)', 'Berdiri sebagai wadah awal penghimpun induk-induk olahraga tradisional dan senam rekreasi di Kabupaten Bandung dengan pembinaan berpusat di komunitas lokal.', NULL, 1, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('adef3d98-3127-44f5-ab14-e4ea1267b877', '2023 - 2026+', 'Era Akselerasi Menuju Indonesia Bugar', 'Pengukuhan Duta Olahraga di 280 desa/kelurahan, digitalisasi portal informasi, serta pembinaan berkelanjutan menuju masyarakat Kabupaten Bandung yang Bedas.', NULL, 4, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('f1b61a1a-22a9-4f41-b584-ca887b64bf01', '2020 - 2022', 'Restrukturisasi KORMI', 'Perubahan nomenklatur resmi menjadi KORMI sesuai dinamika regulasi nasional dan penataan 3 rumpun komisi olahraga (OTDA, OKK, OPT).', NULL, 3, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38');

-- --------------------------------------------------------
-- Table structure for `kormi_log_aktivitas`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_log_aktivitas`;
CREATE TABLE `kormi_log_aktivitas` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengguna_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_aksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_tabel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_entitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_lama` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `data_baru` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `alamat_ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agen_pengguna` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_log_aktivitas`
INSERT INTO `kormi_log_aktivitas` (`id`, `pengguna_id`, `jenis_aksi`, `nama_tabel`, `id_entitas`, `data_lama`, `data_baru`, `alamat_ip`, `agen_pengguna`, `dibuat_pada`) VALUES
  ('8bdea929-27ee-41d8-a25c-3e2e14e975eb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'INITIAL_SEED', 'kormi_pengaturan_situs', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', NULL, '{\"status\":\"System initialized with full KORMI data\"}', '127.0.0.1', 'Seeder Script', '2026-09-09 22:17:39'),
  ('c0332b11-de74-43de-bd96-99c936e53572', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'INITIAL_SEED', 'kormi_pengaturan_situs', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', NULL, '{\"status\":\"System initialized with full KORMI data\"}', '127.0.0.1', 'Seeder Script', '2026-09-09 17:48:37'),
  ('e42251b8-143f-41fa-9166-50037ddd6b0a', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'INITIAL_SEED', 'kormi_pengaturan_situs', 'a2b44566-43dc-4420-b0f0-228fb1225b26', NULL, '{\"status\":\"System initialized with full KORMI data\"}', '127.0.0.1', 'Seeder Script', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_pengaturan_situs`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_pengaturan_situs`;
CREATE TABLE `kormi_pengaturan_situs` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kunci_pengaturan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_pengaturan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kelompok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'umum',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_pengaturan_situs`
INSERT INTO `kormi_pengaturan_situs` (`id`, `kunci_pengaturan`, `nilai_pengaturan`, `kelompok`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('07f6f97f-52a0-4d1d-a10b-26963bc0cab5', 'nomor_telepon', '(022) 123 456 7890', 'kontak', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('0f5bbeb0-b2c4-45bf-b24e-11703be7eb46', 'tagline', 'Masyarakat Sehat, Bugar, dan Berkarakter Menuju Indonesia Bugar 2045', 'umum', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('20f20845-d0cf-4b3e-9e00-c6934b1d1df2', 'facebook', 'https://facebook.com/kormikabupatenbandung', 'sosial_media', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('29d8ab2a-191b-4781-bb46-db81763cc6b8', 'nomor_telepon', '(022) 123 456 7890', 'kontak', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('30ba7566-21b1-43a7-bbb2-a60db26d144f', 'alamat_kantor', 'Komplek Perkantoran Pemkab Bandung, Soreang, Jawa Barat', 'kontak', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('41646419-6232-47d0-b3bc-85410fe8f3f2', 'facebook', 'https://facebook.com/kormikabupatenbandung', 'sosial_media', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('44d4c6d0-6e36-45fb-a954-a853dd4330f1', 'nama_situs', 'KORMI Kabupaten Bandung', 'umum', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('560312f2-2713-4ff5-9e5e-167fd515b9ed', 'youtube', 'https://youtube.com/@kormikabbandung', 'sosial_media', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('5e72f83c-c201-4f2a-950b-72b9f910e8a6', 'facebook', 'https://facebook.com/kormikabupatenbandung', 'sosial_media', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('73b79386-b8f4-452b-9f06-260db3dcdda7', 'youtube', 'https://youtube.com/@kormikabbandung', 'sosial_media', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('794fd4df-9d17-4b8d-85a4-e3cf83d662c9', 'instagram', 'https://instagram.com/kormikabbandung', 'sosial_media', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('83c2ffbc-c227-4b12-99b5-37380c8cf7ec', 'alamat_kantor', 'Komplek Perkantoran Pemkab Bandung, Soreang, Jawa Barat', 'kontak', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('83fc6f38-5c19-4024-9f5a-8b96e536b784', 'nomor_telepon', '(022) 123 456 7890', 'kontak', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('8613cb58-1c2a-4d19-9f85-4c948af93c2b', 'youtube', 'https://youtube.com/@kormikabbandung', 'sosial_media', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('86672f37-8ec1-4c69-8f91-52f2880ebd6d', 'email_resmi', 'sekretariat@kormibdg.id', 'kontak', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('8b47ea6b-45ca-4ef7-a0eb-1787cdec899d', 'nama_situs', 'KORMI Kabupaten Bandung', 'umum', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('8b70e566-5f55-40f0-aff5-300dad50d073', 'tagline', 'Masyarakat Sehat, Bugar, dan Berkarakter Menuju Indonesia Bugar 2045', 'umum', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a67a3532-a92d-4f9c-ab15-cf7aebf611b6', 'alamat_kantor', 'Komplek Perkantoran Pemkab Bandung, Soreang, Jawa Barat', 'kontak', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('aa14ec67-9914-4fe0-90f2-ea68d9f9dda7', 'instagram', 'https://instagram.com/kormikabbandung', 'sosial_media', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('d9a924e9-5b92-4538-b1e3-fa85b78a9b33', 'nama_situs', 'KORMI Kabupaten Bandung', 'umum', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('e900acd3-3f5d-4ae7-84d4-bf0645753519', 'email_resmi', 'sekretariat@kormibdg.id', 'kontak', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('f1691d77-c941-4217-93ef-7de659afb170', 'instagram', 'https://instagram.com/kormikabbandung', 'sosial_media', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('f931130c-6f1e-4f08-ba82-c1cccde9876d', 'email_resmi', 'sekretariat@kormibdg.id', 'kontak', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('fe93cf2a-707c-4315-ab92-e32597ecffe0', 'tagline', 'Masyarakat Sehat, Bugar, dan Berkarakter Menuju Indonesia Bugar 2045', 'umum', '2026-09-09 17:48:37', '2026-09-09 17:48:37');

-- --------------------------------------------------------
-- Table structure for `kormi_pengguna`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_pengguna`;
CREATE TABLE `kormi_pengguna` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `peran_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kata_sandi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_profil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_aktif` bigint NOT NULL DEFAULT '1',
  `terakhir_masuk` timestamp NULL DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dihapus_pada` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_pengguna`
INSERT INTO `kormi_pengguna` (`id`, `peran_id`, `nama_lengkap`, `email`, `kata_sandi`, `nomor_telepon`, `foto_profil`, `status_aktif`, `terakhir_masuk`, `dibuat_pada`, `diperbarui_pada`, `dihapus_pada`, `remember_token`) VALUES
  ('a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'a2b40c66-c65b-4e84-aa6a-743b4485d7b5', 'Admin KORMI', 'admin@kormibdg.id', '$2y$12$8ozEZKERtAPjtU/FSkfA5.FJbxdL/MZlZU8C0igHrASmBs/PpSknS', '081234567890', NULL, 1, NULL, '2026-09-09 22:17:38', '2026-09-09 17:48:49', NULL, NULL),
  ('a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'a2b44264-2f44-499b-a3e9-1e62f543e7e0', 'Admin KORMI', 'admin@kormibdg.id', '$2y$12$8ozEZKERtAPjtU/FSkfA5.FJbxdL/MZlZU8C0igHrASmBs/PpSknS', '081234567890', NULL, 1, NULL, '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL, NULL),
  ('a2b44566-43dc-4420-b0f0-228fb1225b26', 'a2b44565-d7e6-4a1e-bd3c-e67c1f940146', 'Admin KORMI', 'admin@kormibdg.id', '$2y$12$7eehW4Flvrs0VkTqrQtSk.Fy0FuR.L6SpPAj0UomXmAR.EI6jM0xS', '081234567890', NULL, 1, NULL, '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL, NULL);

-- --------------------------------------------------------
-- Table structure for `kormi_pengurus`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_pengurus`;
CREATE TABLE `kormi_pengurus` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_bidang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` bigint NOT NULL DEFAULT '0',
  `status_tampil` bigint NOT NULL DEFAULT '1',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_pengurus`
INSERT INTO `kormi_pengurus` (`id`, `periode_id`, `nama_lengkap`, `jabatan`, `kategori_bidang`, `foto_url`, `urutan`, `status_tampil`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('0412ed62-c590-48e2-9ce9-f109acac6405', '38fa6574-029d-4e8c-980f-368fb7345728', 'Muhammad Iqbal Nurhidayatullah, S.IP.', 'Sekretaris Umum', 'Pengurus Harian', NULL, 3, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('193cbc57-a49b-4e15-bcd0-d8bebce9566e', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'H. Cucun Ahmad Syamsurijal, M.A.P', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 1, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('1c008f50-cee0-49cc-bb7e-3e409f7b959d', '13899c0d-26dd-4edb-841e-349208335d3c', 'H. Cucun Ahmad Syamsurijal, M.A.P', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 1, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('1c9164e8-7d40-4abc-9032-63ddfc6f2528', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Muhammad Iqbal Nurhidayatullah, S.IP.', 'Sekretaris Umum', 'Pengurus Harian', NULL, 3, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('1f4caad3-173b-4aa0-b52c-2833c2592d9d', '13899c0d-26dd-4edb-841e-349208335d3c', 'H. Asep Romy Romaya, S.E.', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 2, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('25cf4e10-b785-4fea-b55c-1dbd25d5d7e8', '13899c0d-26dd-4edb-841e-349208335d3c', 'Hj. Renie Rahayu Fauzie, S.H.', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 4, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('2661ebd6-92f8-482e-b9b5-6464d6922c4f', '13899c0d-26dd-4edb-841e-349208335d3c', 'Muhammad Iqbal Nurhidayatullah, S.IP.', 'Sekretaris Umum', 'Pengurus Harian', NULL, 3, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('277f4a13-30f0-4508-9e2a-4369075ec1be', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Kepala Dinas Pemuda dan Olahraga', 'Dewan Pembina', 'Dewan Pembina', NULL, 2, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('2e66989a-29e7-4aba-9db2-6d96d300c0ab', '38fa6574-029d-4e8c-980f-368fb7345728', 'Tohir', 'Ketua Komisi OKK', 'Komisi OKK', NULL, 2, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('35ad451f-0dd7-4549-95fb-76870448f95d', '13899c0d-26dd-4edb-841e-349208335d3c', 'Kepala Dinas Pemuda dan Olahraga', 'Dewan Pembina', 'Dewan Pembina', NULL, 2, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('3673c543-bae1-4a8a-b918-2eac6a84f660', '13899c0d-26dd-4edb-841e-349208335d3c', 'Sekretaris Daerah Kabupaten Bandung', 'Dewan Pembina', 'Dewan Pembina', NULL, 1, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('3c3d89e3-aba2-4e1b-a60c-0aafb9829f24', '13899c0d-26dd-4edb-841e-349208335d3c', 'Arya Wiranata, S.Pd.', 'Ketua Komisi OTKB', 'Komisi OTKB', NULL, 1, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('3d24845a-258a-4104-8e56-19f83a0ed550', '38fa6574-029d-4e8c-980f-368fb7345728', 'Witri Andayani, S.P.', 'Bendahara Umum', 'Pengurus Harian', NULL, 4, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('4dbce855-847d-4fd7-af77-e6362036d68a', '13899c0d-26dd-4edb-841e-349208335d3c', 'Wakil Bupati Bandung', 'Pelindung', 'Pelindung', NULL, 2, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('56bedfd6-2cfd-4037-bef7-7e129325f803', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Hj. Emma Dety Permanawati, S.Pd.I., M.M.', 'Ketua Umum', 'Pengurus Harian', NULL, 1, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('58955a8d-c996-4656-a79c-1eadd693555f', '38fa6574-029d-4e8c-980f-368fb7345728', 'H. Asep Romy Romaya, S.E.', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 2, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('6e071765-0df8-4b38-8264-c269f3c815c6', '13899c0d-26dd-4edb-841e-349208335d3c', 'Margin Winaya, S.H.', 'Wakil Ketua I', 'Pengurus Harian', NULL, 2, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('73241b9f-1ae6-4b01-9b4b-74abcdb9469b', '13899c0d-26dd-4edb-841e-349208335d3c', 'H. Agus Yasmin', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 3, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('7355a62d-082b-4cc8-b35b-89a2d8449fb7', '38fa6574-029d-4e8c-980f-368fb7345728', 'Hj. Renie Rahayu Fauzie, S.H.', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 4, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('88ac0a00-1eca-4e4e-8ac7-65307feecca8', '38fa6574-029d-4e8c-980f-368fb7345728', 'Bupati Bandung', 'Pelindung', 'Pelindung', NULL, 1, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('8fde33c5-e72e-4800-8e9f-b565d2e76e12', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'H. Agus Yasmin', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 3, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('955edec7-dd6c-4c8f-bd79-5985a4d0dc71', '38fa6574-029d-4e8c-980f-368fb7345728', 'Arya Wiranata, S.Pd.', 'Ketua Komisi OTKB', 'Komisi OTKB', NULL, 1, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('95798be6-b88e-45ea-b7c6-3f3990919ec4', '38fa6574-029d-4e8c-980f-368fb7345728', 'Wakil Bupati Bandung', 'Pelindung', 'Pelindung', NULL, 2, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('991c7564-3eed-4b77-bce2-8a733cbdfacf', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'H. Asep Romy Romaya, S.E.', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 2, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('9af7c3b7-d7e7-42d7-ab4c-c4a624b028b6', '13899c0d-26dd-4edb-841e-349208335d3c', 'Hj. Emma Dety Permanawati, S.Pd.I., M.M.', 'Ketua Umum', 'Pengurus Harian', NULL, 1, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('9e4170ff-d90c-4475-ae13-8523d360fb01', '38fa6574-029d-4e8c-980f-368fb7345728', 'Kepala Dinas Pemuda dan Olahraga', 'Dewan Pembina', 'Dewan Pembina', NULL, 2, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a4d42487-8c6e-425d-90f2-7ce5f7bb3582', '38fa6574-029d-4e8c-980f-368fb7345728', 'H. Agus Yasmin', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 3, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a5aa42cc-6e3c-4f45-84e8-92ba89a6ef99', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Margin Winaya, S.H.', 'Wakil Ketua I', 'Pengurus Harian', NULL, 2, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('aff01945-f3bd-4e56-bf32-c2e418cddf8d', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Zico Prasetya Aldrine', 'Ketua Komisi OPT', 'Komisi OPT', NULL, 3, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('b5e4e729-9870-4329-a68a-a46da00e5964', '38fa6574-029d-4e8c-980f-368fb7345728', 'Margin Winaya, S.H.', 'Wakil Ketua I', 'Pengurus Harian', NULL, 2, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('ba2a0c43-f4a0-43e0-9eff-b1eb76c848a1', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Wakil Bupati Bandung', 'Pelindung', 'Pelindung', NULL, 2, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('bd7cd6e8-2b03-4399-842d-4eab357befd5', '38fa6574-029d-4e8c-980f-368fb7345728', 'H. Cucun Ahmad Syamsurijal, M.A.P', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 1, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('c05c8045-faa3-465f-abdb-d7f9ff2114fb', '13899c0d-26dd-4edb-841e-349208335d3c', 'Tohir', 'Ketua Komisi OKK', 'Komisi OKK', NULL, 2, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('c0a3d3cf-33ad-4668-b14f-78e6040a40ec', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Witri Andayani, S.P.', 'Bendahara Umum', 'Pengurus Harian', NULL, 4, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('c5823eb0-6d51-40b3-b7be-7bcbe8950612', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Sekretaris Daerah Kabupaten Bandung', 'Dewan Pembina', 'Dewan Pembina', NULL, 1, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('cf4f1f6b-efc8-455f-bb82-2cd35a275a37', '13899c0d-26dd-4edb-841e-349208335d3c', 'Witri Andayani, S.P.', 'Bendahara Umum', 'Pengurus Harian', NULL, 4, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('dbf315b7-707c-4544-bf16-30c3fd195322', '13899c0d-26dd-4edb-841e-349208335d3c', 'Bupati Bandung', 'Pelindung', 'Pelindung', NULL, 1, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('df548b12-cd3c-4230-99d2-e89542e7c23a', '38fa6574-029d-4e8c-980f-368fb7345728', 'Hj. Emma Dety Permanawati, S.Pd.I., M.M.', 'Ketua Umum', 'Pengurus Harian', NULL, 1, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('dfd38861-9da3-4bbc-8527-1377d08a744e', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Tohir', 'Ketua Komisi OKK', 'Komisi OKK', NULL, 2, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('e01feb5b-4c6a-4ff9-83ba-425f87b2e51b', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Hj. Renie Rahayu Fauzie, S.H.', 'Dewan Kehormatan', 'Dewan Kehormatan', NULL, 4, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('e74d18b7-e64d-43c5-b6d9-01188fc09430', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Bupati Bandung', 'Pelindung', 'Pelindung', NULL, 1, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('eae80c15-a961-4862-930b-b6d5fadfee72', '13899c0d-26dd-4edb-841e-349208335d3c', 'Zico Prasetya Aldrine', 'Ketua Komisi OPT', 'Komisi OPT', NULL, 3, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('f092eef8-d820-4ec9-85cb-52217858e3e1', '7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Arya Wiranata, S.Pd.', 'Ketua Komisi OTKB', 'Komisi OTKB', NULL, 1, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('f7cdbc7a-dd30-4685-b87f-d255dd995a17', '38fa6574-029d-4e8c-980f-368fb7345728', 'Sekretaris Daerah Kabupaten Bandung', 'Dewan Pembina', 'Dewan Pembina', NULL, 1, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('ff20e08e-54cb-43ee-ae50-d59e03b6f9e2', '38fa6574-029d-4e8c-980f-368fb7345728', 'Zico Prasetya Aldrine', 'Ketua Komisi OPT', 'Komisi OPT', NULL, 3, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37');

-- --------------------------------------------------------
-- Table structure for `kormi_peran`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_peran`;
CREATE TABLE `kormi_peran` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_peran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_peran`
INSERT INTO `kormi_peran` (`id`, `nama_peran`, `slug`, `deskripsi`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c66-c65b-4e84-aa6a-743b4485d7b5', 'Super Administrator', 'super-admin', 'Pengelola sistem utama KORMI', '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('a2b44264-2f44-499b-a3e9-1e62f543e7e0', 'Super Administrator', 'super-admin', 'Pengelola sistem utama KORMI', '2026-09-09 17:48:36', '2026-09-09 17:48:36'),
  ('a2b44565-d7e6-4a1e-bd3c-e67c1f940146', 'Super Administrator', 'super-admin', 'Pengelola sistem utama KORMI', '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_periode_kepengurusan`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_periode_kepengurusan`;
CREATE TABLE `kormi_periode_kepengurusan` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_periode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_mulai` bigint NOT NULL,
  `tahun_selesai` bigint NOT NULL,
  `status_aktif` bigint NOT NULL DEFAULT '0',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_periode_kepengurusan`
INSERT INTO `kormi_periode_kepengurusan` (`id`, `nama_periode`, `tahun_mulai`, `tahun_selesai`, `status_aktif`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('13899c0d-26dd-4edb-841e-349208335d3c', 'Masa Bakti 2022 - 2026', 2022, 2026, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('38fa6574-029d-4e8c-980f-368fb7345728', 'Masa Bakti 2022 - 2026', 2022, 2026, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('7deb0de1-b259-43eb-bde7-4875f6e66a29', 'Masa Bakti 2022 - 2026', 2022, 2026, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39');

-- --------------------------------------------------------
-- Table structure for `kormi_program_kerja`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_program_kerja`;
CREATE TABLE `kormi_program_kerja` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_anggaran` bigint NOT NULL,
  `nama_bidang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan_kegiatan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `target_sasaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimasi_anggaran` decimal(15,2) DEFAULT NULL,
  `status_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rencana',
  `bulan_mulai` bigint DEFAULT NULL,
  `bulan_selesai` bigint DEFAULT NULL,
  `ikon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activity',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_program_kerja`
INSERT INTO `kormi_program_kerja` (`id`, `tahun_anggaran`, `nama_bidang`, `nama_kegiatan`, `tujuan_kegiatan`, `target_sasaran`, `estimasi_anggaran`, `status_kegiatan`, `bulan_mulai`, `bulan_selesai`, `ikon`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('1af2b05d-c8cf-45c2-89c9-2fe5c46769bf', 2026, 'OKK', 'Lomba Cipta Senam Kreasi Bedas', 'Kompetisi terbuka menciptakan gerakan senam kreasi baru memadukan budaya Sunda.', 'Komunitas Tari & Senam', '60000000.00', 'rencana', 7, 8, 'music', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('2723b0b2-2f47-4de3-86c8-b4e34fc0a3c5', 2026, 'OPT', 'Kejuaraan Panjat Tebing & Susur Gua Pemula', 'Kompetisi pencarian bibit pegiat olahraga petualangan dan tantangan dari kalangan pemuda.', 'Pelajar & Mahasiswa', '75000000.00', 'rencana', 8, 9, 'mountain', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('27723ebc-3dee-43c0-8238-d33215ee2f08', 2026, 'OKK', 'Senam Bedas Massal Terpadu', 'Kegiatan senam massal berskala besar yang melibatkan puluhan ribu peserta se-Kabupaten Bandung.', 'Masyarakat Umum & Komunitas Senam', '200000000.00', 'berjalan', 1, 12, 'users', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('2ba4252e-44a9-4729-b978-1357684f490e', 2026, 'SDM', 'Pelatihan & Sertifikasi Instruktur Senam', 'Peningkatan kapasitas instruktur senam lokal untuk disertifikasi dan ditempatkan di setiap desa.', 'Instruktur & Guru Olahraga', '50000000.00', 'selesai', 2, 4, 'award', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('37de8473-4326-49d7-90b2-424884f67b66', 2026, 'OTKB', 'Festival Olahraga Rekreasi Desa (FORDESWITA)', 'Menggabungkan olahraga tradisional dengan promosi destinasi wisata lokal di berbagai desa.', 'Seluruh Desa & Penggiat Budaya', '150000000.00', 'berjalan', 1, 12, 'map', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('4acdf64d-ac15-438c-b477-4d51823f139d', 2026, 'OKK', 'Lomba Cipta Senam Kreasi Bedas', 'Kompetisi terbuka menciptakan gerakan senam kreasi baru memadukan budaya Sunda.', 'Komunitas Tari & Senam', '60000000.00', 'rencana', 7, 8, 'music', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('4d17bfb8-a676-489e-ac75-495280cdc5f1', 2026, 'SDM', 'Pelatihan & Sertifikasi Instruktur Senam', 'Peningkatan kapasitas instruktur senam lokal untuk disertifikasi dan ditempatkan di setiap desa.', 'Instruktur & Guru Olahraga', '50000000.00', 'selesai', 2, 4, 'award', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('5e3b7c8e-611f-4392-ba67-075af63684d0', 2026, 'OTKB', 'Festival Olahraga Rekreasi Desa (FORDESWITA)', 'Menggabungkan olahraga tradisional dengan promosi destinasi wisata lokal di berbagai desa.', 'Seluruh Desa & Penggiat Budaya', '150000000.00', 'berjalan', 1, 12, 'map', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('7434989e-853d-4eab-ac30-9231314dbbe3', 2026, 'OKK', 'Lomba Cipta Senam Kreasi Bedas', 'Kompetisi terbuka menciptakan gerakan senam kreasi baru memadukan budaya Sunda.', 'Komunitas Tari & Senam', '60000000.00', 'rencana', 7, 8, 'music', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('76e9c786-4670-4d26-8bdb-a28a93f693d0', 2026, 'OPT', 'Kejuaraan Panjat Tebing & Susur Gua Pemula', 'Kompetisi pencarian bibit pegiat olahraga petualangan dan tantangan dari kalangan pemuda.', 'Pelajar & Mahasiswa', '75000000.00', 'rencana', 8, 9, 'mountain', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('7acc1757-406a-4cea-ac79-bad48db92fcc', 2026, 'OPT', 'Kejuaraan Panjat Tebing & Susur Gua Pemula', 'Kompetisi pencarian bibit pegiat olahraga petualangan dan tantangan dari kalangan pemuda.', 'Pelajar & Mahasiswa', '75000000.00', 'rencana', 8, 9, 'mountain', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('97471a7c-a348-405b-8890-4d83e99a836a', 2026, 'OTKB', 'Festival Olahraga Rekreasi Desa (FORDESWITA)', 'Menggabungkan olahraga tradisional dengan promosi destinasi wisata lokal di berbagai desa.', 'Seluruh Desa & Penggiat Budaya', '150000000.00', 'berjalan', 1, 12, 'map', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('9d59bc4c-5286-4153-92e6-5d93ce168ce2', 2026, 'SDM', 'Pelatihan & Sertifikasi Instruktur Senam', 'Peningkatan kapasitas instruktur senam lokal untuk disertifikasi dan ditempatkan di setiap desa.', 'Instruktur & Guru Olahraga', '50000000.00', 'selesai', 2, 4, 'award', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('c7646cb2-a61a-4486-8978-a2285e2f706b', 2026, 'OKK', 'Senam Bedas Massal Terpadu', 'Kegiatan senam massal berskala besar yang melibatkan puluhan ribu peserta se-Kabupaten Bandung.', 'Masyarakat Umum & Komunitas Senam', '200000000.00', 'berjalan', 1, 12, 'users', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('cb48351d-8cb6-4c03-930e-ed36bed1825f', 2026, 'OPT', 'Jelajah Alam Bedas (Hiking & Trail)', 'Eksplorasi jalur alam Kabupaten Bandung sambil melakukan kampanye pelestarian lingkungan.', 'Pecinta Alam & Komunitas Trail', '80000000.00', 'berjalan', 4, 11, 'compass', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('dd0a29df-b504-44b3-a5ae-14706e4eab84', 2026, 'OKK', 'Senam Bedas Massal Terpadu', 'Kegiatan senam massal berskala besar yang melibatkan puluhan ribu peserta se-Kabupaten Bandung.', 'Masyarakat Umum & Komunitas Senam', '200000000.00', 'berjalan', 1, 12, 'users', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('ee844efe-8bef-4537-990a-2fcc72483969', 2026, 'OPT', 'Jelajah Alam Bedas (Hiking & Trail)', 'Eksplorasi jalur alam Kabupaten Bandung sambil melakukan kampanye pelestarian lingkungan.', 'Pecinta Alam & Komunitas Trail', '80000000.00', 'berjalan', 4, 11, 'compass', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('fd7e9d71-f7dd-41c2-b706-7bce080c0064', 2026, 'OPT', 'Jelajah Alam Bedas (Hiking & Trail)', 'Eksplorasi jalur alam Kabupaten Bandung sambil melakukan kampanye pelestarian lingkungan.', 'Pecinta Alam & Komunitas Trail', '80000000.00', 'berjalan', 4, 11, 'compass', '2026-09-09 17:48:37', '2026-09-09 17:48:37');

-- --------------------------------------------------------
-- Table structure for `kormi_sapras`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_sapras`;
CREATE TABLE `kormi_sapras` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_fasilitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_fasilitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_lengkap` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kondisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baik',
  `jenis_olahraga_tersedia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak_pengelola` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(15,2) DEFAULT NULL,
  `longitude` decimal(15,2) DEFAULT NULL,
  `foto_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_sapras`
INSERT INTO `kormi_sapras` (`id`, `kecamatan_id`, `nama_fasilitas`, `kategori_fasilitas`, `alamat_lengkap`, `kapasitas`, `status_kondisi`, `jenis_olahraga_tersedia`, `kontak_pengelola`, `nomor_telepon`, `latitude`, `longitude`, `foto_url`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-63f8-4e0d-95db-f9c3ca0eb7ce', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Stadion Si Jalak Harupat', 'Stadion', 'Kutawaringin, Soreang', '27.000 penonton', 'Baik', 'Sepakbola, Atletik, Senam', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=600', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-6424-4c26-97d6-8137028403be', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Lapangan Upakarti Soreang', 'Lapangan', 'Komplek Pemkab Bandung, Soreang', '5.000 orang', 'Baik', 'Senam, Hadang, Terompah', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?q=80&w=600', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-644a-4544-abcd-55430a1f6061', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'GOR Baleendah', 'GOR', 'Jl. Raya Baleendah', '2.000 penonton', 'Baik', 'Silat, Senam, Tenis Meja', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=600', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-6470-41f6-8f5b-85d355b0141c', 'a2b40c67-2135-481e-97b8-592488466ec6', 'Lapangan Olahraga Cileunyi', 'Lapangan', 'Jl. Raya Cileunyi', '1.500 orang', 'Baik', 'Egrang, Tarik Tambang', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?q=80&w=600', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-2796-4bb4-b21b-8f3d1537e900', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Stadion Si Jalak Harupat', 'Stadion', 'Kutawaringin, Soreang', '27.000 penonton', 'Baik', 'Sepakbola, Atletik, Senam', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=600', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-27b7-47c4-9862-a4aa127d3080', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Lapangan Upakarti Soreang', 'Lapangan', 'Komplek Pemkab Bandung, Soreang', '5.000 orang', 'Baik', 'Senam, Hadang, Terompah', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?q=80&w=600', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-27d0-4291-b0ef-fa1c75b8c598', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'GOR Baleendah', 'GOR', 'Jl. Raya Baleendah', '2.000 penonton', 'Baik', 'Silat, Senam, Tenis Meja', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=600', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-27e8-432b-bba7-30ca7b77a073', 'a2b40c67-2135-481e-97b8-592488466ec6', 'Lapangan Olahraga Cileunyi', 'Lapangan', 'Jl. Raya Cileunyi', '1.500 orang', 'Baik', 'Egrang, Tarik Tambang', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?q=80&w=600', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-8d2d-45a3-b17e-c4d20c2c2dde', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Stadion Si Jalak Harupat', 'Stadion', 'Kutawaringin, Soreang', '27.000 penonton', 'Baik', 'Sepakbola, Atletik, Senam', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=600', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8d51-41bd-a953-a093adb56c50', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Lapangan Upakarti Soreang', 'Lapangan', 'Komplek Pemkab Bandung, Soreang', '5.000 orang', 'Baik', 'Senam, Hadang, Terompah', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?q=80&w=600', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8d69-4bab-8adf-0cd25d3c5b9c', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'GOR Baleendah', 'GOR', 'Jl. Raya Baleendah', '2.000 penonton', 'Baik', 'Silat, Senam, Tenis Meja', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=600', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8d92-4f32-9566-1cdad6bd39ec', 'a2b40c67-2135-481e-97b8-592488466ec6', 'Lapangan Olahraga Cileunyi', 'Lapangan', 'Jl. Raya Cileunyi', '1.500 orang', 'Baik', 'Egrang, Tarik Tambang', NULL, NULL, NULL, NULL, 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?q=80&w=600', '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_sdi_jadwal`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_sdi_jadwal`;
CREATE TABLE `kormi_sdi_jadwal` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_angkatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `lokasi_pelatihan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kuota_peserta` bigint NOT NULL DEFAULT '30',
  `jumlah_pendaftar` bigint NOT NULL DEFAULT '0',
  `status_pendaftaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dibuka',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_sdi_jadwal`
INSERT INTO `kormi_sdi_jadwal` (`id`, `program_id`, `nama_angkatan`, `tanggal_mulai`, `tanggal_selesai`, `lokasi_pelatihan`, `kuota_peserta`, `jumlah_pendaftar`, `status_pendaftaran`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-6509-4c3e-bf73-9f4cbb544f5a', 'a2b40c67-64ad-4821-beff-df9d91431b79', 'Angkatan I - Tahun 2026', '2026-07-15', '2026-07-17', 'Gedung KORMI Soreang', 30, 18, 'dibuka', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-6530-4350-9673-c59804f47261', 'a2b40c67-64d1-40e7-a132-3fba195a48cd', 'Angkatan II - Tahun 2026', '2026-08-20', '2026-08-22', 'Aula Dispora Kab. Bandung', 25, 25, 'penuh', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-291d-4460-af94-24bf49061ffc', 'a2b44265-289e-4b44-8ed4-2ab3fcb78230', 'Angkatan I - Tahun 2026', '2026-07-15', '2026-07-17', 'Gedung KORMI Soreang', 30, 18, 'dibuka', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-293d-4cda-a4b0-cb0612143296', 'a2b44265-28bf-456f-beb4-78ec5dcadb39', 'Angkatan II - Tahun 2026', '2026-08-20', '2026-08-22', 'Aula Dispora Kab. Bandung', 25, 25, 'penuh', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-8e08-45c7-a9cf-43f63c7d4d2d', 'a2b44566-8dbb-4694-96b0-697ec7720f08', 'Angkatan I - Tahun 2026', '2026-07-15', '2026-07-17', 'Gedung KORMI Soreang', 30, 18, 'dibuka', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8e2b-4db9-b467-8fa9796aa166', 'a2b44566-8dda-416b-8d8d-7b856ca62200', 'Angkatan II - Tahun 2026', '2026-08-20', '2026-08-22', 'Aula Dispora Kab. Bandung', 25, 25, 'penuh', '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_sdi_peserta`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_sdi_peserta`;
CREATE TABLE `kormi_sdi_peserta` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jadwal_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asal_lembaga_inorga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kelulusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `nomor_sertifikat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_sdi_peserta`
INSERT INTO `kormi_sdi_peserta` (`id`, `jadwal_id`, `kecamatan_id`, `nama_lengkap`, `nik`, `nomor_telepon`, `email`, `asal_lembaga_inorga`, `status_kelulusan`, `nomor_sertifikat`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('13a44ed3-48f3-47b5-abde-57cd1dcf75c6', 'a2b40c67-6509-4c3e-bf73-9f4cbb544f5a', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Dewi Sartika, M.Pd', NULL, '081234567822', 'dewi.sartika@gmail.com', 'Inorga STI', 'lulus', 'KORMI-SDI-2026-002', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('26adc845-2ed9-4082-9d99-d86a1ec12ccc', 'a2b44265-291d-4460-af94-24bf49061ffc', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Dewi Sartika, M.Pd', NULL, '081234567822', 'dewi.sartika@gmail.com', 'Inorga STI', 'lulus', 'KORMI-SDI-2026-002', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('60d1bd76-5d66-428e-b98f-fb218e0514fd', 'a2b44265-291d-4460-af94-24bf49061ffc', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Asep Kurniawan, S.Pd', NULL, '081234567811', 'asep.kurniawan@gmail.com', 'Inorga PORTINA', 'lulus', 'KORMI-SDI-2026-001', '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('91aa0e19-bd45-42be-a612-1c41a3b10f3d', 'a2b40c67-6509-4c3e-bf73-9f4cbb544f5a', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Asep Kurniawan, S.Pd', NULL, '081234567811', 'asep.kurniawan@gmail.com', 'Inorga PORTINA', 'lulus', 'KORMI-SDI-2026-001', '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('c43f046d-29b7-4b57-903e-c898224c697a', 'a2b44566-8e08-45c7-a9cf-43f63c7d4d2d', 'a2b40c67-2002-4c4a-856c-e137acb0b87e', 'Dewi Sartika, M.Pd', NULL, '081234567822', 'dewi.sartika@gmail.com', 'Inorga STI', 'lulus', 'KORMI-SDI-2026-002', '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('d3fd65de-94c3-4b92-98f1-005d31526b69', 'a2b44566-8e08-45c7-a9cf-43f63c7d4d2d', 'a2b40c67-2538-40be-82bc-3782bfaad813', 'Asep Kurniawan, S.Pd', NULL, '081234567811', 'asep.kurniawan@gmail.com', 'Inorga PORTINA', 'lulus', 'KORMI-SDI-2026-001', '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_sdi_program`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_sdi_program`;
CREATE TABLE `kormi_sdi_program` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_program` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sasaran_peserta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `standar_kompetensi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `jenis_sertifikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_aktif` bigint NOT NULL DEFAULT '1',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_sdi_program`
INSERT INTO `kormi_sdi_program` (`id`, `judul_program`, `slug`, `sasaran_peserta`, `standar_kompetensi`, `jenis_sertifikasi`, `banner_url`, `status_aktif`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('a2b40c67-64ad-4821-beff-df9d91431b79', 'Pelatihan Pelatih & Instruktur Olahraga Tradisional', 'pelatihan-pelatih-instruktur-olahraga-tradisional', 'Pelatih Inorga & Guru Olahraga', 'Sertifikasi Tingkat Dasar Kepelatihan KORMI', 'Sertifikat Kompetensi KORMI', NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b40c67-64d1-40e7-a132-3fba195a48cd', 'Bimbingan Teknis Wasit & Juri FOTRADKAB', 'bimtek-wasit-juri-fotradkab', 'Wasit Cabang Olahraga Tradisional', 'Standar Perwasitan PORTINA & KORMI', 'Lisensi Wasit Daerah', NULL, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39'),
  ('a2b44265-289e-4b44-8ed4-2ab3fcb78230', 'Pelatihan Pelatih & Instruktur Olahraga Tradisional', 'pelatihan-pelatih-instruktur-olahraga-tradisional', 'Pelatih Inorga & Guru Olahraga', 'Sertifikasi Tingkat Dasar Kepelatihan KORMI', 'Sertifikat Kompetensi KORMI', NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44265-28bf-456f-beb4-78ec5dcadb39', 'Bimbingan Teknis Wasit & Juri FOTRADKAB', 'bimtek-wasit-juri-fotradkab', 'Wasit Cabang Olahraga Tradisional', 'Standar Perwasitan PORTINA & KORMI', 'Lisensi Wasit Daerah', NULL, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('a2b44566-8dbb-4694-96b0-697ec7720f08', 'Pelatihan Pelatih & Instruktur Olahraga Tradisional', 'pelatihan-pelatih-instruktur-olahraga-tradisional', 'Pelatih Inorga & Guru Olahraga', 'Sertifikasi Tingkat Dasar Kepelatihan KORMI', 'Sertifikat Kompetensi KORMI', NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('a2b44566-8dda-416b-8d8d-7b856ca62200', 'Bimbingan Teknis Wasit & Juri FOTRADKAB', 'bimtek-wasit-juri-fotradkab', 'Wasit Cabang Olahraga Tradisional', 'Standar Perwasitan PORTINA & KORMI', 'Lisensi Wasit Daerah', NULL, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01');

-- --------------------------------------------------------
-- Table structure for `kormi_unduhan`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_unduhan`;
CREATE TABLE `kormi_unduhan` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengunggah_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_dokumen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `berkas_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ekstensi_berkas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran_berkas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ikon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'file-text',
  `jumlah_unduhan` bigint NOT NULL DEFAULT '0',
  `status_publik` bigint NOT NULL DEFAULT '1',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dihapus_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_unduhan`
INSERT INTO `kormi_unduhan` (`id`, `kategori_id`, `pengunggah_id`, `judul_dokumen`, `berkas_path`, `ekstensi_berkas`, `ukuran_berkas`, `nama_ikon`, `jumlah_unduhan`, `status_publik`, `dibuat_pada`, `diperbarui_pada`, `dihapus_pada`) VALUES
  ('a2b40c67-5da2-48d9-9b59-10c616873c29', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Pengurus KORMI Kab. Bandung 2022-2025', 'dokumen/sample.pdf', 'PDF', '2.4 MB', 'file-text', 342, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b40c67-5dcb-4577-b463-3c3d9bf67097', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'AD/ART KORMI Kabupaten Bandung', 'dokumen/sample.pdf', 'PDF', '1.8 MB', 'file-text', 215, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b40c67-5dfc-416b-8eb4-28b3167e5ca6', 'a2b40c67-5d2f-48cf-88af-afe1fb0daf74', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Program Kerja KORMI 2026', 'dokumen/sample.pdf', 'PDF', '4.5 MB', 'file-text', 128, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b40c67-5e22-403b-9e8e-bcea83236364', 'a2b40c67-5d5b-48df-b7cf-a830e4d60dd7', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'Formulir Pendaftaran Inorga Baru', 'dokumen/sample.pdf', 'DOCX', '450 KB', 'file-text', 89, 1, '2026-09-09 22:17:39', '2026-09-09 22:17:39', NULL),
  ('a2b4425f-68cf-4546-bf7b-9b9ee3ea6650', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Uji Coba Unduhan 2026 Updated', 'dokumen/sample-regulasi-kormi.pdf', 'PDF', '1.2 MB', 'file-text', 0, 1, '2026-09-09 17:48:33', '2026-09-09 17:48:33', '2026-09-09 17:48:33'),
  ('a2b44265-2010-4270-9294-19cb1e11dee2', 'a2b44265-1ef0-4bde-8da3-53e6a9a26b0f', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'SK Pengurus KORMI Kab. Bandung 2022-2025', 'dokumen/sample.pdf', 'PDF', '2.4 MB', 'file-text', 342, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44265-203d-4d2e-884c-f78594eb4732', 'a2b44265-1ef0-4bde-8da3-53e6a9a26b0f', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'AD/ART KORMI Kabupaten Bandung', 'dokumen/sample.pdf', 'PDF', '1.8 MB', 'file-text', 215, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44265-2061-42f6-808d-e04c0790b2aa', 'a2b44265-1f4d-440d-a93f-24fff1b20af9', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'Program Kerja KORMI 2026', 'dokumen/sample.pdf', 'PDF', '4.5 MB', 'file-text', 128, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44265-207d-4945-97f6-c548a9fd7d9a', 'a2b44265-1f74-4adf-8d35-b97365714201', 'a2b44264-ea2a-4dec-a3ab-ea2dfb253c58', 'Formulir Pendaftaran Inorga Baru', 'dokumen/sample.pdf', 'DOCX', '450 KB', 'file-text', 89, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37', NULL),
  ('a2b44566-865f-4bc1-ba38-1060d515ad51', 'a2b44566-85b3-4134-96cc-0966674cdf38', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'SK Pengurus KORMI Kab. Bandung 2022-2025', 'dokumen/sample.pdf', 'PDF', '2.4 MB', 'file-text', 342, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b44566-86a7-427f-a4c6-42109666adda', 'a2b44566-85b3-4134-96cc-0966674cdf38', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'AD/ART KORMI Kabupaten Bandung', 'dokumen/sample.pdf', 'PDF', '1.8 MB', 'file-text', 215, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b44566-86c1-4a71-a721-aac1f3003971', 'a2b44566-85d1-43e4-87d3-90adbbb68fb1', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'Program Kerja KORMI 2026', 'dokumen/sample.pdf', 'PDF', '4.5 MB', 'file-text', 128, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b44566-86dc-45b8-a7d0-36c8d0521764', 'a2b44566-8617-4fd6-9baf-e632e3918668', 'a2b44566-43dc-4420-b0f0-228fb1225b26', 'Formulir Pendaftaran Inorga Baru', 'dokumen/sample.pdf', 'DOCX', '450 KB', 'file-text', 89, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01', NULL),
  ('a2b445c7-ed17-4c41-86bb-ffef1f541a9b', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Uji Coba Unduhan 2026 Updated', 'dokumen/sample-regulasi-kormi.pdf', 'PDF', '1.2 MB', 'file-text', 0, 1, '2026-09-09 10:58:05', '2026-09-09 10:58:05', '2026-09-09 10:58:05'),
  ('a2b445d5-7180-448f-8e3d-1ea6bbe009e7', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Uji Coba Unduhan 2026 Updated', 'dokumen/sample-regulasi-kormi.pdf', 'PDF', '1.2 MB', 'file-text', 0, 1, '2026-09-09 10:58:14', '2026-09-09 10:58:14', '2026-09-09 10:58:14'),
  ('a2b447b4-39f2-4272-a75b-b6d09bf7ecba', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Uji Coba Unduhan 2026 Updated', 'dokumen/sample-regulasi-kormi.pdf', 'PDF', '1.2 MB', 'file-text', 0, 1, '2026-09-09 11:03:28', '2026-09-09 11:03:28', '2026-09-09 11:03:28'),
  ('a2b44811-025f-4f30-b5c3-411a80c8574b', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Uji Coba Unduhan 2026 Updated', 'dokumen/sample-regulasi-kormi.pdf', 'PDF', '1.2 MB', 'file-text', 0, 1, '2026-09-09 11:04:28', '2026-09-09 11:04:28', '2026-09-09 11:04:28'),
  ('a2b4487b-7d3f-4414-9d58-243ab78bb239', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Uji Coba Unduhan 2026 Updated', 'dokumen/sample-regulasi-kormi.pdf', 'PDF', '1.2 MB', 'file-text', 0, 1, '2026-09-09 11:05:38', '2026-09-09 11:05:38', '2026-09-09 11:05:38'),
  ('a2b448a2-ea67-40f5-9f81-8ba645f8bf07', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Uji Coba Unduhan 2026 Updated', 'dokumen/sample-regulasi-kormi.pdf', 'PDF', '1.2 MB', 'file-text', 0, 1, '2026-09-09 11:06:04', '2026-09-09 11:06:04', '2026-09-09 11:06:04'),
  ('a2b448f4-8de0-4b23-9b29-219758da175e', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Uji Coba Unduhan 2026 Updated', 'dokumen/sample-regulasi-kormi.pdf', 'PDF', '1.2 MB', 'file-text', 0, 1, '2026-09-09 11:06:57', '2026-09-09 11:06:58', '2026-09-09 11:06:58'),
  ('a2b449ba-dd90-4c14-b608-e93f5896fcda', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Uji Coba Unduhan 2026 Updated', 'dokumen/sample-regulasi-kormi.pdf', 'PDF', '1.2 MB', 'file-text', 0, 1, '2026-09-09 11:09:07', '2026-09-09 11:09:07', '2026-09-09 11:09:07'),
  ('a2b449fd-a184-4a03-bb00-649b082eb298', 'a2b40c67-5cf6-4eb0-9262-62faf62959cb', 'a2b40c67-1c3d-4bb5-8864-7b913d955dac', 'SK Uji Coba Unduhan 2026 Updated', 'dokumen/sample-regulasi-kormi.pdf', 'PDF', '1.2 MB', 'file-text', 0, 1, '2026-09-09 11:09:51', '2026-09-09 11:09:51', '2026-09-09 11:09:51');

-- --------------------------------------------------------
-- Table structure for `kormi_visi_misi`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `kormi_visi_misi`;
CREATE TABLE `kormi_visi_misi` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ikon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` bigint NOT NULL DEFAULT '0',
  `status_tampil` bigint NOT NULL DEFAULT '1',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `kormi_visi_misi`
INSERT INTO `kormi_visi_misi` (`id`, `jenis`, `konten`, `ikon`, `urutan`, `status_tampil`, `dibuat_pada`, `diperbarui_pada`) VALUES
  ('035138ec-009b-409a-ae3f-08f895b88f17', 'visi', 'Mewujudkan masyarakat Kabupaten Bandung yang sehat, bugar, berkarakter, dan berdaya saing melalui pemberdayaan olahraga masyarakat yang inklusif menuju Indonesia Bugar 2045.', NULL, 1, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('1061a072-be3a-44bb-8be3-2d541e2b64e6', 'misi', 'Memastikan kegiatan olahraga menjangkau seluruh 280 desa dan kelurahan di 31 kecamatan.', 'globe', 5, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('22efdf32-057e-4b8b-826b-5ef521d19840', 'misi', 'Mengintegrasikan olahraga masyarakat dengan promosi pariwisata alam Kabupaten Bandung.', 'map-pin', 6, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('2acb02af-c61b-4a13-80f2-2a93e4cab23c', 'misi', 'Memastikan kegiatan olahraga menjangkau seluruh 280 desa dan kelurahan di 31 kecamatan.', 'globe', 5, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('2af1f05d-5df7-4249-9eb7-eaa8d557633a', 'misi', 'Melaksanakan program edukasi dan sosialisasi untuk menumbuhkan kesadaran gaya hidup aktif dan bugar.', 'trending-up', 2, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('3929164b-6c27-4295-a073-c31a19d1a67d', 'misi', 'Memperkuat kapasitas kelembagaan dan kompetensi SDM induk-induk organisasi olahraga.', 'shield-check', 3, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('3b4c3493-bdb5-4ae5-b090-5a17e81fbff0', 'misi', 'Memastikan kegiatan olahraga menjangkau seluruh 280 desa dan kelurahan di 31 kecamatan.', 'globe', 5, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('42630a56-b4b1-4eba-9623-d0e6344cc1ba', 'misi', 'Mendorong dan memfasilitasi berbagai jenis olahraga yang mudah diakses oleh seluruh lapisan masyarakat.', 'activity', 1, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('49354506-802f-454a-942b-e05cc043f34c', 'misi', 'Memperkuat kapasitas kelembagaan dan kompetensi SDM induk-induk organisasi olahraga.', 'shield-check', 3, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('4ee06e7a-0416-4e17-8cfa-9fcba88aaf0e', 'misi', 'Menyelenggarakan FORKAB dan FOTRADKAB secara rutin sebagai ajang silaturahmi dan unjuk kemampuan.', 'calendar', 4, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('62d03f0f-45b9-4435-a316-2bb08270b865', 'visi', 'Mewujudkan masyarakat Kabupaten Bandung yang sehat, bugar, berkarakter, dan berdaya saing melalui pemberdayaan olahraga masyarakat yang inklusif menuju Indonesia Bugar 2045.', NULL, 1, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('64512764-fd01-460d-948c-c1518da60c38', 'misi', 'Mengintegrasikan olahraga masyarakat dengan promosi pariwisata alam Kabupaten Bandung.', 'map-pin', 6, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('6784959e-cf9b-430d-aaa2-8882b634c7f7', 'misi', 'Mendorong dan memfasilitasi berbagai jenis olahraga yang mudah diakses oleh seluruh lapisan masyarakat.', 'activity', 1, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('6d280bb4-3cc1-4b84-98e8-dfa4ba36ebb4', 'visi', 'Mewujudkan masyarakat Kabupaten Bandung yang sehat, bugar, berkarakter, dan berdaya saing melalui pemberdayaan olahraga masyarakat yang inklusif menuju Indonesia Bugar 2045.', NULL, 1, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('8813c1a0-b939-43cf-8bbb-9bfab32c8359', 'misi', 'Menyelenggarakan FORKAB dan FOTRADKAB secara rutin sebagai ajang silaturahmi dan unjuk kemampuan.', 'calendar', 4, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('999aafd9-9d8b-4402-9b0b-a4e987f61dcb', 'misi', 'Melaksanakan program edukasi dan sosialisasi untuk menumbuhkan kesadaran gaya hidup aktif dan bugar.', 'trending-up', 2, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('c415da16-f1e4-4df7-9dcf-6d5b68989e8b', 'misi', 'Menyelenggarakan FORKAB dan FOTRADKAB secara rutin sebagai ajang silaturahmi dan unjuk kemampuan.', 'calendar', 4, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('cfbbef70-cfca-4392-b5b1-315283319a31', 'misi', 'Mengintegrasikan olahraga masyarakat dengan promosi pariwisata alam Kabupaten Bandung.', 'map-pin', 6, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37'),
  ('e264a46f-2a40-4177-82c7-06e830b78cfa', 'misi', 'Mendorong dan memfasilitasi berbagai jenis olahraga yang mudah diakses oleh seluruh lapisan masyarakat.', 'activity', 1, 1, '2026-09-09 22:17:38', '2026-09-09 22:17:38'),
  ('fe1b0491-d1ae-4bc7-9c47-41305636b480', 'misi', 'Memperkuat kapasitas kelembagaan dan kompetensi SDM induk-induk organisasi olahraga.', 'shield-check', 3, 1, '2026-09-09 10:57:01', '2026-09-09 10:57:01'),
  ('fe34e5c7-e36f-4104-845b-50c266f747f7', 'misi', 'Melaksanakan program edukasi dan sosialisasi untuk menumbuhkan kesadaran gaya hidup aktif dan bugar.', 'trending-up', 2, 1, '2026-09-09 17:48:37', '2026-09-09 17:48:37');

-- --------------------------------------------------------
-- Table structure for `migrations`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
  (1, '0001_01_01_000000_create_users_table', 1),
  (2, '0001_01_01_000001_create_cache_table', 1),
  (3, '0001_01_01_000002_create_jobs_table', 1),
  (4, '2026_09_09_000001_create_kormi_cms_tables', 1);

-- --------------------------------------------------------
-- Table structure for `password_reset_tokens`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `sessions`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint DEFAULT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `sessions`
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
  ('TM11cVElljW37XX3g563jut5tD4g3YBY6fhoThUP', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 OPR/135.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieGJSd2M4YmxIVE43a25KSW9zdWc0SlJHTUJJY0hRYmh6RGFlaDV4MSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMjoiaHR0cHM6Ly9rb3JtaS1iYWNrZW5kLnRlc3QvYWRtaW4iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cHM6Ly9rb3JtaS1iYWNrZW5kLnRlc3QvYWRtaW4vbWFzdWsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1788950870);

-- --------------------------------------------------------
-- Table structure for `users`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
