<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Kecamatan;
use App\Models\Master\DesaKelurahan;
use App\Models\Kormi\DutaOlahraga;
use App\Models\Kormi\KomisiInorga;
use App\Models\Kormi\Inorga;
use App\Models\Content\KategoriUnduhan;
use App\Models\Content\Unduhan;
use App\Models\Content\KategoriBerita;
use App\Models\Content\Berita;
use App\Models\Content\GaleriAlbum;
use App\Models\Content\GaleriFoto;
use App\Models\Core\Peran;
use App\Models\Core\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Role & Super Admin
        $peranSuperAdmin = Peran::updateOrCreate(
            ['slug' => 'super-admin'],
            [
                'nama_peran' => 'Super Admin',
                'deskripsi' => 'Pengelola sistem utama & seluruh hak akses modul KORMI',
                'hak_akses' => ['*'],
            ]
        );

        $peranKorcam = Peran::updateOrCreate(
            ['slug' => 'admin-korcam'],
            [
                'nama_peran' => 'Admin KORCAM',
                'deskripsi' => 'Pengelola data wilayah kecamatan, kordik, duta desa, & venue sarana prasarana',
                'hak_akses' => ['duta', 'kordik', 'sapras'],
            ]
        );

        $peranInorga = Peran::updateOrCreate(
            ['slug' => 'admin-inorga'],
            [
                'nama_peran' => 'Admin INORGA',
                'deskripsi' => 'Pengelola induk organisasi, komisi rumpun olahraga, & klasemen kompetisi',
                'hak_akses' => ['inorga', 'event', 'klasemen'],
            ]
        );

        $peranEditor = Peran::updateOrCreate(
            ['slug' => 'editor-berita'],
            [
                'nama_peran' => 'Editor Berita',
                'deskripsi' => 'Pengelola publikasi warta, artikel liputan, & album dokumentasi galeri',
                'hak_akses' => ['berita', 'galeri', 'unduhan'],
            ]
        );

        $peranDuta = Peran::updateOrCreate(
            ['slug' => 'duta-olahraga'],
            [
                'nama_peran' => 'Duta Olahraga Desa',
                'deskripsi' => 'Fasilitator penggerak olahraga desa & pencatat kegiatan massal masyarakat',
                'hak_akses' => ['partisipasi_log', 'duta'],
            ]
        );

        $peranPegiat = Peran::updateOrCreate(
            ['slug' => 'pegiat-olahraga'],
            [
                'nama_peran' => 'Masyarakat / Pegiat Olahraga',
                'deskripsi' => 'Masyarakat pencatat aktivitas olahraga mandiri',
                'hak_akses' => [],
            ]
        );

        $admin = Pengguna::updateOrCreate(
            ['email' => 'admin@kormibdg.id'],
            [
                'peran_id' => $peranSuperAdmin->id,
                'nama_lengkap' => 'Super Admin KORMI',
                'kata_sandi' => bcrypt('admin@kormibdg.id'),
                'nomor_telepon' => '081234567890',
                'status_aktif' => true,
            ]
        );

        // 2. Pengaturan Situs
        $settings = [
            ['kunci_pengaturan' => 'nama_situs', 'nilai_pengaturan' => 'KORMI Kabupaten Bandung', 'kelompok' => 'umum'],
            ['kunci_pengaturan' => 'tagline', 'nilai_pengaturan' => 'Masyarakat Sehat, Bugar, dan Berkarakter Menuju Indonesia Bugar 2045', 'kelompok' => 'umum'],
            ['kunci_pengaturan' => 'email_resmi', 'nilai_pengaturan' => 'sekretariat@kormibdg.id', 'kelompok' => 'kontak'],
            ['kunci_pengaturan' => 'nomor_telepon', 'nilai_pengaturan' => '(022) 123 456 7890', 'kelompok' => 'kontak'],
            ['kunci_pengaturan' => 'alamat_kantor', 'nilai_pengaturan' => 'Komplek Perkantoran Pemkab Bandung, Soreang, Jawa Barat', 'kelompok' => 'kontak'],
            ['kunci_pengaturan' => 'facebook', 'nilai_pengaturan' => 'https://facebook.com/kormikabupatenbandung', 'kelompok' => 'sosial_media'],
            ['kunci_pengaturan' => 'instagram', 'nilai_pengaturan' => 'https://instagram.com/kormikabbandung', 'kelompok' => 'sosial_media'],
            ['kunci_pengaturan' => 'youtube', 'nilai_pengaturan' => 'https://youtube.com/@kormikabbandung', 'kelompok' => 'sosial_media'],
        ];
        foreach ($settings as $s) {
            DB::table('sys_pengaturan_situs')->insert(array_merge($s, [
                'id' => (string) Str::uuid(),
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]));
        }

        // 3. Linimasa Sejarah
        $sejarahList = [
            [
                'tahun' => '2000 - 2010',
                'judul' => 'Era Perintisan (FOMI)',
                'deskripsi' => 'Berdiri sebagai wadah awal penghimpun induk-induk olahraga tradisional dan senam rekreasi di Kabupaten Bandung dengan pembinaan berpusat di komunitas lokal.',
                'urutan' => 1,
            ],
            [
                'tahun' => '2011 - 2019',
                'judul' => 'Transformasi & Penguatan (FORMI)',
                'deskripsi' => 'Bertransformasi menjadi FORMI Kabupaten Bandung dengan konsolidasi kelembagaan di 31 kecamatan dan penyelenggaraan Festival Olahraga Rekreasi skala massal.',
                'urutan' => 2,
            ],
            [
                'tahun' => '2020 - 2022',
                'judul' => 'Restrukturisasi KORMI',
                'deskripsi' => 'Perubahan nomenklatur resmi menjadi KORMI sesuai dinamika regulasi nasional dan penataan 3 rumpun komisi olahraga (OTDA, OKK, OPT).',
                'urutan' => 3,
            ],
            [
                'tahun' => '2023 - 2026+',
                'judul' => 'Era Akselerasi Menuju Indonesia Bugar',
                'deskripsi' => 'Pengukuhan Duta Olahraga di 280 desa/kelurahan, digitalisasi portal informasi, serta pembinaan berkelanjutan menuju masyarakat Kabupaten Bandung yang Bedas.',
                'urutan' => 4,
            ],
        ];
        foreach ($sejarahList as $sej) {
            DB::table('kormi_linimasa_sejarah')->insert(array_merge($sej, [
                'id' => (string) Str::uuid(),
                'status_tampil' => 1,
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]));
        }

        // 4. Visi & Misi
        DB::table('kormi_visi_misi')->insert([
            'id' => (string) Str::uuid(),
            'jenis' => 'visi',
            'konten' => 'Mewujudkan masyarakat Kabupaten Bandung yang sehat, bugar, berkarakter, dan berdaya saing melalui pemberdayaan olahraga masyarakat yang inklusif menuju Indonesia Bugar 2045.',
            'urutan' => 1,
            'status_tampil' => 1,
            'dibuat_pada' => now(),
            'diperbarui_pada' => now(),
        ]);

        $misiList = [
            ['title' => 'Pengembangan Olahraga Masyarakat', 'desc' => 'Mendorong dan memfasilitasi berbagai jenis olahraga yang mudah diakses oleh seluruh lapisan masyarakat.', 'icon' => 'activity', 'urutan' => 1],
            ['title' => 'Peningkatan Angka Partisipasi', 'desc' => 'Melaksanakan program edukasi dan sosialisasi untuk menumbuhkan kesadaran gaya hidup aktif dan bugar.', 'icon' => 'trending-up', 'urutan' => 2],
            ['title' => 'Pembinaan INORGA yang Komprehensif', 'desc' => 'Memperkuat kapasitas kelembagaan dan kompetensi SDM induk-induk organisasi olahraga.', 'icon' => 'shield-check', 'urutan' => 3],
            ['title' => 'Pelaksanaan Festival Olahraga', 'desc' => 'Menyelenggarakan FORKAB dan FOTRADKAB secara rutin sebagai ajang silaturahmi dan unjuk kemampuan.', 'icon' => 'calendar', 'urutan' => 4],
            ['title' => 'Pemasalan ke Tingkat Desa', 'desc' => 'Memastikan kegiatan olahraga menjangkau seluruh 280 desa dan kelurahan di 31 kecamatan.', 'icon' => 'globe', 'urutan' => 5],
            ['title' => 'Pengembangan Sport Tourism', 'desc' => 'Mengintegrasikan olahraga masyarakat dengan promosi pariwisata alam Kabupaten Bandung.', 'icon' => 'map-pin', 'urutan' => 6],
        ];
        foreach ($misiList as $m) {
            DB::table('kormi_visi_misi')->insert([
                'id' => (string) Str::uuid(),
                'jenis' => 'misi',
                'konten' => $m['desc'],
                'ikon' => $m['icon'],
                'urutan' => $m['urutan'],
                'status_tampil' => 1,
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        }

        // 5. Data 31 Kecamatan Lengkap se-Kabupaten Bandung
        $semuaKecamatan = [
            'Arjasari', 'Baleendah', 'Banjaran', 'Bojongsoang', 'Cangkuang',
            'Cicalengka', 'Cikancung', 'Cilengkrang', 'Cileunyi', 'Cimaung',
            'Cimeunyan', 'Ciparay', 'Ciwidey', 'Dayeuhkolot', 'Ibun',
            'Katapang', 'Kertasari', 'Kutawaringin', 'Majalaya', 'Margaasih',
            'Margahayu', 'Nagreg', 'Pacet', 'Pameungpeuk', 'Pangalengan',
            'Paseh', 'Pasirjambu', 'Rancabali', 'Rancaekek', 'Solokanjeruk',
            'Soreang'
        ];

        $kecamatanDbMap = [];
        foreach ($semuaKecamatan as $namaKec) {
            $kec = Kecamatan::firstOrCreate(
                ['slug' => Str::slug($namaKec)],
                [
                    'nama_kecamatan' => $namaKec,
                    'alamat_kantor' => "Kantor Kecamatan {$namaKec}, Kabupaten Bandung",
                    'nomor_telepon' => '022-' . rand(5800000, 5999999)
                ]
            );
            $kecamatanDbMap[$namaKec] = $kec;
        }

        // 6. Data Duta Olahraga Desa Riil
        $dataDuta = [
            ["Egi Septiana", "Patrolsari", "Arjasari"],
            ["Khaeru Ahmad Rifaldi", "Pinggirsari", "Arjasari"],
            ["Dodi Juliana", "Rancakole", "Arjasari"],
            ["Zam Zam Fitrah", "Wargaluyu", "Arjasari"],
            ["Andi Mohamad Fauzi", "Andir", "Baleendah"],
            ["Aminnur Dwi Ariyanti", "Baleendah", "Baleendah"],
            ["Fauzy Rahman Rukmana", "Bojongmalaka", "Baleendah"],
            ["Ginanjar Teguh Sagara, S.Pd", "Jelekong", "Baleendah"],
            ["Darmawan", "Malakasari", "Baleendah"],
            ["Kania Sri Sucy Widara", "Manggahang", "Baleendah"],
            ["Asep Supriatna", "Rancamanyar", "Baleendah"],
            ["Rini Ridayanti", "Wargamekar", "Baleendah"],
            ["Puri Aulia Salsabila", "Banjaran Kulon", "Banjaran"],
            ["Reza Miptah Dinulloh", "Banjaran Wetan", "Banjaran"],
            ["Aulia Rahmi Nur Fajriyah", "Ciapus", "Banjaran"],
            ["Muhammad", "Kamasan", "Banjaran"],
            ["Shofwan Zaini", "Kiangroke", "Banjaran"],
            ["Nurdiyana Firmansyah", "Margahurip", "Banjaran"],
            ["Nizar Rayhan Nur Rakhmat", "Mekarjaya", "Banjaran"],
            ["Aziz Ali Nurrochman", "Neglasari", "Banjaran"],
            ["Dinda Amalia Nur Fauziah", "Pasirmulya", "Banjaran"],
            ["Tiara Shinta Dewi", "Sindangpanon", "Banjaran"],
            ["Arul Fadyah Dzulpaqor", "Tarajusari", "Banjaran"],
            ["Lulurisma", "Bojongsari", "Bojongsoang"],
            ["Frischha Dewi Octavia", "Bojongsoang", "Bojongsoang"],
            ["Vian", "Buahbatu", "Bojongsoang"],
            ["Deyra Hylmy Yahya", "Cipagalo", "Bojongsoang"],
            ["Sanif Setiawan", "Lengkong", "Bojongsoang"],
            ["Syabina Fatwa Azzahra", "Tegalluar", "Bojongsoang"],
            ["Nugie Herdiansyah", "Bandasari", "Cangkuang"],
            ["Rahma Safitri", "Ciluncat", "Cangkuang"],
            ["Dian Heryanto", "Jatisari", "Cangkuang"],
            ["Rissa Rosiana", "Nagrak", "Cangkuang"],
            ["Deden Gunawan", "Pananjung", "Cangkuang"],
            ["Jaka Nursahid", "Tanjungsari", "Cangkuang"],
            ["Irma Asmarani", "Cangkuang", "Cangkuang"],
            ["Ahmad Fahmi Faisal", "Babakan Peuteuy", "Cicalengka"],
            ["Muhammad Fajar Nuriman", "Cicalengka Kulon", "Cicalengka"],
            ["Seril Rizka D Laela", "Cicalengka Wetan", "Cicalengka"],
            ["Purnama Pramuditha", "Cikuya", "Cicalengka"],
            ["Galuh Hardianti Khoeriyah", "Dampit", "Cicalengka"],
            ["Fikri Padilah", "Margaasih", "Cicalengka"],
            ["Erisya Nurul Fauzia", "Nagrog", "Cicalengka"],
            ["Vianti Putri Lestari", "Narawita", "Cicalengka"],
            ["Ilham Nurzaman", "Penenjoan", "Cicalengka"],
            ["Muhamad Rukhiat Sofia Ramdani", "Tanjung Wangi", "Cicalengka"],
            ["Mohammad Nabil Fadilah", "Tenjolaya", "Cicalengka"],
            ["Annisa Maulidasawa", "Waluya", "Cicalengka"],
            ["Putri Widia Ramdani", "Cihanyir", "Cikancung"],
            ["Muhamad Ridwan", "Cikancung", "Cikancung"],
            ["Rilvan Fadilah", "Cikasungka", "Cikancung"],
            ["Dinar Fitranti", "Ciluluk", "Cikancung"],
            ["Hera Iyadatul Fauziah", "Hegarmanah", "Cikancung"],
            ["Yuda Maulana", "Mandalasari", "Cikancung"],
            ["Syafitri Nurpadilah", "Mekarlaksana", "Cikancung"],
            ["Bagas Saparudin", "Srirahayu", "Cikancung"],
            ["Siti Ulfa Hasanatun Nur Wahida., S.H", "Tanjunglaya", "Cikancung"],
            ["Nurkholis Majid", "Cilengkrang", "Cilengkrang"],
            ["Imas Marwati", "Cipanjalu", "Cilengkrang"],
            ["Wahyu Wahyudin", "Ciporeat", "Cilengkrang"],
            ["Deaneira Choirunnisa Tedyaputri", "Girimekar", "Cilengkrang"],
            ["Wandi Suwanda", "Jatiendah", "Cilengkrang"],
            ["Rizky Marwan Sarwana", "Melatiwangi", "Cilengkrang"],
            ["Taufik Hidayat", "Cibiru Hilir", "Cileunyi"],
            ["Muhammad Rayhan Fauzi", "Cibiru Wetan", "Cileunyi"],
            ["Ajang", "Cileunyi Kulon", "Cileunyi"],
            ["Irawan", "Cileunyi Wetan", "Cileunyi"],
            ["Sindy Oktaviani", "Cimekar", "Cileunyi"],
            ["Iis Isnia Rhobiati", "Cinunuk", "Cileunyi"],
            ["Fitria Nur Aisyah", "Campakamulya", "Cimaung"],
            ["Erlina Nuranjani", "Cikalong", "Cimaung"],
            ["Boyke Dwi Septiadi", "Cimaung", "Cimaung"],
            ["Asti Apriyanti", "Cipinang", "Cimaung"],
            ["Taupik Tarisman", "Jagabaya", "Cimaung"],
            ["Yoga Dwiswara", "Malasari", "Cimaung"],
            ["Muhamad Yusup", "Mekarsari", "Cimaung"],
            ["Tian Fauzi Agustien", "Pasirhuni", "Cimaung"],
            ["Dewita Yunika Sabila", "Sukamaju", "Cimaung"],
            ["Ninda Nurazzizah", "Warjabakti", "Cimaung"],
            ["Melly Noviany", "Cibeunying", "Cimeunyan"],
            ["Arie Setiawan", "Ciburial", "Cimeunyan"],
            ["Abdulhafizh Almubarok", "Cikadut", "Cimeunyan"],
            ["Novel Mulyani", "Cimenyan", "Cimeunyan"],
            ["Iwan Nugraha", "Mandalamekar", "Cimeunyan"],
            ["Repan Eka Putra", "Mekarmanik", "Cimeunyan"],
            ["Riyana", "Mekarsaluyu", "Cimeunyan"],
            ["Tri Gunadi", "Padasuka", "Cimeunyan"],
            ["Reza Setiawan", "Sindanglaya", "Cimeunyan"],
            ["Sarah Dwi Nabila", "Babakan", "Ciparay"],
            ["Muhamad Alif Fitrah Permana", "Bumiwangi", "Ciparay"],
            ["Ahmad Syatibi", "Ciheulang", "Ciparay"],
            ["Seka Sundari", "Cikoneng", "Ciparay"],
            ["Zaenal Arifin", "Ciparay", "Ciparay"],
            ["Luthfi Hidayatulloh", "Gunungleutik", "Ciparay"],
            ["Aura Lia Anggraeni", "Mangunraharja", "Ciparay"],
            ["Rifad Insan Kamil", "Mekarlaksana", "Ciparay"],
            ["Rizqi Syahrul Mubarok", "Mekarsari", "Ciparay"],
            ["Arman Mulyanudin A", "Pakutandang", "Ciparay"],
            ["Rudi Ardian", "Sagaracipta", "Ciparay"],
            ["Fiqih Arya Sandi", "Sarimahi", "Ciparay"],
            ["Zeni Firmansyah", "Serangmekar", "Ciparay"],
            ["Rina Nurhasanah", "Soreang", "Soreang"],
            ["Dani Ramdani", "Sekarwangi", "Soreang"],
            ["Agus Setiawan", "Panyirapan", "Soreang"],
            ["Hendi Suhendi", "Sadu", "Soreang"],
            ["Yulianti", "Cingcin", "Soreang"]
        ];

        foreach ($dataDuta as $item) {
            $namaDuta = $item[0];
            $namaDesa = $item[1];
            $namaKec = $item[2];

            $kec = $kecamatanDbMap[$namaKec] ?? Kecamatan::first();

            $desa = DesaKelurahan::firstOrCreate(
                ['kecamatan_id' => $kec->id, 'slug' => Str::slug($namaDesa)],
                ['nama_desa_kelurahan' => $namaDesa]
            );

            DutaOlahraga::create([
                'kecamatan_id' => $kec->id,
                'desa_kelurahan_id' => $desa->id,
                'nama_lengkap' => $namaDuta,
                'tahun_pemilihan' => 2026,
                'kategori_duta' => 'Duta Olahraga Masyarakat',
                'status_unggulan' => rand(0, 5) === 1,
            ]);
        }

        // 7. Periode Kepengurusan & Struktur Pengurus
        $periodeId = (string) Str::uuid();
        DB::table('kormi_periode_kepengurusan')->insert([
            'id' => $periodeId,
            'nama_periode' => 'Masa Bakti 2022 - 2026',
            'tahun_mulai' => 2022,
            'tahun_selesai' => 2026,
            'status_aktif' => 1,
            'dibuat_pada' => now(),
            'diperbarui_pada' => now(),
        ]);

        $dataKordik = [
            ['NOPI GANDINI', 'Arjasari', '08122345001'],
            ['IKA KARTIKA HIDAYAT', 'Baleendah', '08122345002'],
            ['HILDA HIDAYAH, SP', 'Banjaran', '08122345003'],
            ['ERNA AGUSTINA, A.Md. Far', 'Bojongsoang', '08122345004'],
            ['ENDAH FERAWATI', 'Cangkuang', '08122345005'],
            ['ANI TARYANI', 'Cicalengka', '08122345006'],
            ['ADE ROMLAH, S. Ag', 'Cikancung', '08122345007'],
            ['DEBBY HERAWATY', 'Cilengkrang', '08122345008'],
            ['LANNY MULIAMAH', 'Cileunyi', '08122345009'],
            ['RITA SUKARSO', 'Cimaung', '08122345010'],
            ['SRI HETY PERTAMAWATI', 'Cimeunyan', '08122345011'],
            ['POPY JAYANTHI', 'Ciparay', '08122345012'],
            ['LALA SITI JAMILAH, S. Sos,Msi', 'Ciwidey', '08122345013'],
            ['LINDA NURKANIA, SE.,M.Pd', 'Dayeuhkolot', '08122345014'],
            ['SUSI SUSILAWATI', 'Ibun', '08122345015'],
            ['DR. ARLINA, M.Pd', 'Katapang', '08122345016'],
            ['HENNA ENAYAH, SH', 'Kertasari', '08122345017'],
            ['WIWIN WINARNI', 'Kutawaringin', '08122345018'],
            ['FARIDA', 'Majalaya', '08122345019'],
            ['WENNY WINARNY, SE., MM', 'Margaasih', '08122345020'],
            ['YUYUN YUNINGSIH', 'Margahayu', '08122345021'],
            ['RETNO MULIAYANI', 'Nagreg', '08122345022'],
            ['NINING SARIPAH', 'Pacet', '08122345023'],
            ['RIKA HUMAIROH, S.Sos', 'Pameungpeuk', '08122345024'],
            ['NOVITA SARDI', 'Pangalengan', '08122345025'],
            ['WATWAT JULIAWATI', 'Paseh', '08122345026'],
            ['IKA KARTIKA SARI', 'Pasirjambu', '08122345027'],
            ['DEDEH YUNINGSIH', 'Rancabali', '08122345028'],
            ['drg. NOVITA UTAMI', 'Rancaekek', '08122345029'],
            ['YOIKA INDRAWATI', 'Solokanjeruk', '08122345030'],
            ['HJ. RIA RESTIANA R', 'Soreang', '08122345031']
        ];

        foreach ($dataKordik as $kordik) {
            $kec = $kecamatanDbMap[$kordik[1]] ?? Kecamatan::first();
            DB::table('kormi_kordik_pengurus')->insert([
                'id' => (string) Str::uuid(),
                'kecamatan_id' => $kec->id,
                'periode_id' => $periodeId,
                'nama_ketua' => $kordik[0],
                'nomor_telepon' => $kordik[2],
                'status_aktif' => 1,
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        }

        $strukturPengurus = [
            ['Bupati Bandung', 'Pelindung', 'Pelindung', 1, 1],
            ['Wakil Bupati Bandung', 'Pelindung', 'Pelindung', 1, 2],
            ['H. Cucun Ahmad Syamsurijal, M.A.P', 'Dewan Kehormatan', 'Dewan Kehormatan', 2, 1],
            ['H. Asep Romy Romaya, S.E.', 'Dewan Kehormatan', 'Dewan Kehormatan', 2, 2],
            ['H. Agus Yasmin', 'Dewan Kehormatan', 'Dewan Kehormatan', 2, 3],
            ['Hj. Renie Rahayu Fauzie, S.H.', 'Dewan Kehormatan', 'Dewan Kehormatan', 2, 4],
            ['Sekretaris Daerah Kabupaten Bandung', 'Dewan Pembina', 'Dewan Pembina', 3, 1],
            ['Kepala Dinas Pemuda dan Olahraga', 'Dewan Pembina', 'Dewan Pembina', 3, 2],
            ['Hj. Emma Dety Permanawati, S.Pd.I., M.M.', 'Ketua Umum', 'Pengurus Harian', 4, 1],
            ['Margin Winaya, S.H.', 'Wakil Ketua I', 'Pengurus Harian', 4, 2],
            ['Muhammad Iqbal Nurhidayatullah, S.IP.', 'Sekretaris Umum', 'Pengurus Harian', 4, 3],
            ['Witri Andayani, S.P.', 'Bendahara Umum', 'Pengurus Harian', 4, 4],
            ['Arya Wiranata, S.Pd.', 'Ketua Komisi OTKB', 'Komisi OTKB', 5, 1],
            ['Tohir', 'Ketua Komisi OKK', 'Komisi OKK', 5, 2],
            ['Zico Prasetya Aldrine', 'Ketua Komisi OPT', 'Komisi OPT', 5, 3],
        ];

        foreach ($strukturPengurus as $p) {
            DB::table('kormi_pengurus')->insert([
                'id' => (string) Str::uuid(),
                'periode_id' => $periodeId,
                'nama_lengkap' => $p[0],
                'jabatan' => $p[1],
                'kategori_bidang' => $p[2],
                'urutan' => $p[4],
                'status_tampil' => 1,
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        }

        // 8. Program Kerja
        $prokerData = [
            [2026, 'OTKB', 'Festival Olahraga Rekreasi Desa (FORDESWITA)', 'Menggabungkan olahraga tradisional dengan promosi destinasi wisata lokal di berbagai desa.', 'Seluruh Desa & Penggiat Budaya', 150000000, 'berjalan', 1, 12, 'map'],
            [2026, 'OKK', 'Senam Bedas Massal Terpadu', 'Kegiatan senam massal berskala besar yang melibatkan puluhan ribu peserta se-Kabupaten Bandung.', 'Masyarakat Umum & Komunitas Senam', 200000000, 'berjalan', 1, 12, 'users'],
            [2026, 'OPT', 'Kejuaraan Panjat Tebing & Susur Gua Pemula', 'Kompetisi pencarian bibit pegiat olahraga petualangan dan tantangan dari kalangan pemuda.', 'Pelajar & Mahasiswa', 75000000, 'rencana', 8, 9, 'mountain'],
            [2026, 'SDM', 'Pelatihan & Sertifikasi Instruktur Senam', 'Peningkatan kapasitas instruktur senam lokal untuk disertifikasi dan ditempatkan di setiap desa.', 'Instruktur & Guru Olahraga', 50000000, 'selesai', 2, 4, 'award'],
            [2026, 'OKK', 'Lomba Cipta Senam Kreasi Bedas', 'Kompetisi terbuka menciptakan gerakan senam kreasi baru memadukan budaya Sunda.', 'Komunitas Tari & Senam', 60000000, 'rencana', 7, 8, 'music'],
            [2026, 'OPT', 'Jelajah Alam Bedas (Hiking & Trail)', 'Eksplorasi jalur alam Kabupaten Bandung sambil melakukan kampanye pelestarian lingkungan.', 'Pecinta Alam & Komunitas Trail', 80000000, 'berjalan', 4, 11, 'compass'],
        ];

        foreach ($prokerData as $pr) {
            DB::table('kormi_program_kerja')->insert([
                'id' => (string) Str::uuid(),
                'tahun_anggaran' => $pr[0],
                'nama_bidang' => $pr[1],
                'nama_kegiatan' => $pr[2],
                'tujuan_kegiatan' => $pr[3],
                'target_sasaran' => $pr[4],
                'estimasi_anggaran' => $pr[5],
                'status_kegiatan' => $pr[6],
                'bulan_mulai' => $pr[7],
                'bulan_selesai' => $pr[8],
                'ikon' => $pr[9],
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        }

        // 9. Komisi & Inorga Riil
        $komisiOTDA = KomisiInorga::create([
            'nama_komisi' => 'Olahraga Tradisional dan Kreasi Budaya',
            'singkatan' => 'OTDA',
            'kode_warna_hex' => '#16a34a'
        ]);

        $komisiOKK = KomisiInorga::create([
            'nama_komisi' => 'Olahraga Kesehatan dan Kebugaran',
            'singkatan' => 'OKK',
            'kode_warna_hex' => '#2563eb'
        ]);

        $komisiOPT = KomisiInorga::create([
            'nama_komisi' => 'Olahraga Petualangan dan Tantangan',
            'singkatan' => 'OPT',
            'kode_warna_hex' => '#f97316'
        ]);

        $inorgas = [
            ['PORTINA', 'Persatuan Olahraga Tradisional Indonesia', $komisiOTDA->id],
            ['ASTI', 'Asosiasi Silat Tradisi Indonesia', $komisiOTDA->id],
            ['PLBSI', 'Persatuan Liong dan Barongsai Seluruh Indonesia', $komisiOTDA->id],
            ['ASIAFI', 'Asosiasi Instruktur Aerobik dan Fitnes Indonesia', $komisiOKK->id],
            ['STI', 'Senam Tera Indonesia', $komisiOKK->id],
            ['IDCA', 'Indonesia Drum Corps Association', $komisiOKK->id],
            ['FAI', 'Federasi Airsoft Indonesia', $komisiOPT->id],
            ['BEST', 'Barisan Atlet E-Sport Tradisional', $komisiOPT->id],
        ];

        foreach ($inorgas as $ino) {
            Inorga::create([
                'komisi_id' => $ino[2],
                'nama_inorga' => $ino[1],
                'singkatan' => $ino[0],
                'slug' => Str::slug($ino[0]),
                'status_keanggotaan' => 'aktif',
                'jumlah_klub_anggota' => rand(5, 25),
            ]);
        }

        // 10. Event, Cabang, Klasemen, Jadwal (FORKAB)
        $katEventId = (string) Str::uuid();
        DB::table('event_kategori')->insert([
            'id' => $katEventId,
            'nama_kategori' => 'Multi Event Daerah',
            'slug' => 'multi-event-daerah',
            'dibuat_pada' => now(),
            'diperbarui_pada' => now(),
        ]);

        $eventForkabId = (string) Str::uuid();
        DB::table('event_kegiatan')->insert([
            'id' => $eventForkabId,
            'kategori_event_id' => $katEventId,
            'judul_event' => 'Festival Olahraga Rekreasi Masyarakat Kabupaten (FORKAB) 2026',
            'slug' => 'forkab-2026',
            'tahun_edisi' => 2026,
            'lokasi_utama' => 'Komplek Stadion Si Jalak Harupat, Kutawaringin',
            'tanggal_mulai' => '2026-08-01',
            'tanggal_selesai' => '2026-08-30',
            'banner_url' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=1200',
            'deskripsi_lengkap' => 'Ajang festival olahraga rekreasi terbesar se-Kabupaten Bandung dengan partisipasi 31 kontingen kecamatan.',
            'status_publikasi' => 1,
            'dibuat_pada' => now(),
            'diperbarui_pada' => now(),
        ]);

        $caborList = [
            ['Senam Aerobik', 'activity', 'bg-pink-500'],
            ['Fun Run 5K', 'zap', 'bg-red-500'],
            ['Bersepeda Santai', 'bike', 'bg-blue-500'],
            ['Renang Rekreasi', 'waves', 'bg-cyan-500'],
            ['Layang-Layang', 'wind', 'bg-indigo-500'],
            ['Panahan Tradisional', 'target', 'bg-emerald-500'],
            ['Tenis Meja', 'table', 'bg-orange-500'],
            ['Petanque', 'circle-dot', 'bg-purple-500'],
        ];

        foreach ($caborList as $c) {
            DB::table('event_cabang')->insert([
                'id' => (string) Str::uuid(),
                'event_id' => $eventForkabId,
                'nama_cabang' => $c[0],
                'ikon' => $c[1],
                'kode_warna_hex' => $c[2],
                'kategori_peserta' => 'Umum & Pelajar',
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        }

        $klasemenForkab = [
            ['Margahayu', 10, 6, 4, 1],
            ['Dayeuhkolot', 8, 8, 5, 2],
            ['Baleendah', 7, 5, 7, 3],
            ['Ciparay', 6, 7, 3, 4],
            ['Soreang', 5, 6, 8, 5],
            ['Katapang', 5, 4, 5, 6],
            ['Cileunyi', 4, 5, 6, 7],
            ['Rancaekek', 4, 3, 4, 8],
        ];

        foreach ($klasemenForkab as $kl) {
            $kec = $kecamatanDbMap[$kl[0]] ?? Kecamatan::first();
            DB::table('event_klasemen_medali')->insert([
                'id' => (string) Str::uuid(),
                'event_id' => $eventForkabId,
                'kecamatan_id' => $kec->id,
                'jumlah_emas' => $kl[1],
                'jumlah_perak' => $kl[2],
                'jumlah_perunggu' => $kl[3],
                'total_medali' => $kl[1] + $kl[2] + $kl[3],
                'peringkat' => $kl[4],
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        }

        $jadwalForkab = [
            ['Pendaftaran', '2026-06-01', 'Pendaftaran kontingen kecamatan melalui Koordinator Kecamatan.', 'selesai', 'Sekretariat KORMI'],
            ['Technical Meeting', '2026-07-15', 'Rapat teknis dan undian bagan pertandingan.', 'selesai', 'Aula Dispora Kab. Bandung'],
            ['Babak Penyisihan', '2026-08-01', 'Pertandingan babak penyisihan di masing-masing zona wilayah.', 'berlangsung', 'Zona Wilayah Kab. Bandung'],
            ['Babak Final', '2026-08-25', 'Grand final seluruh cabor di Stadion Si Jalak Harupat.', 'akan_datang', 'Stadion Si Jalak Harupat'],
            ['Penutupan & Awarding', '2026-08-30', 'Upacara penutupan dan penyerahan piala bergilir Bupati Bandung.', 'akan_datang', 'Lapangan Upakarti Soreang'],
        ];

        foreach ($jadwalForkab as $j) {
            DB::table('event_jadwal')->insert([
                'id' => (string) Str::uuid(),
                'event_id' => $eventForkabId,
                'fase_tahapan' => $j[0],
                'tanggal' => $j[1],
                'nama_kegiatan' => $j[0] . ' FORKAB 2026',
                'tempat_arena' => $j[4],
                'status_tahapan' => $j[3],
                'keterangan' => $j[2],
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        }

        // 11. Unduhan Dokumen Riil
        $katRegulasi = KategoriUnduhan::create(['nama_kategori' => 'Regulasi & SK', 'slug' => 'regulasi-sk']);
        $katProker = KategoriUnduhan::create(['nama_kategori' => 'Program Kerja', 'slug' => 'program-kerja']);
        $katFormulir = KategoriUnduhan::create(['nama_kategori' => 'Formulir', 'slug' => 'formulir']);

        $docs = [
            ['SK Pengurus KORMI Kab. Bandung 2022-2025', $katRegulasi->id, 'PDF', '2.4 MB', 342],
            ['AD/ART KORMI Kabupaten Bandung', $katRegulasi->id, 'PDF', '1.8 MB', 215],
            ['Program Kerja KORMI 2026', $katProker->id, 'PDF', '4.5 MB', 128],
            ['Formulir Pendaftaran Inorga Baru', $katFormulir->id, 'DOCX', '450 KB', 89],
        ];

        foreach ($docs as $doc) {
            Unduhan::create([
                'kategori_id' => $doc[1],
                'pengunggah_id' => $admin->id,
                'judul_dokumen' => $doc[0],
                'berkas_path' => 'dokumen/sample.pdf',
                'ekstensi_berkas' => $doc[2],
                'ukuran_berkas' => $doc[3],
                'jumlah_unduhan' => $doc[4],
                'status_publik' => true,
            ]);
        }

        // 12. Berita & Kategori Berita
        $katEvent = KategoriBerita::create(['nama_kategori' => 'Event', 'slug' => 'event', 'kode_warna_hex' => '#16a34a']);
        $katPrestasi = KategoriBerita::create(['nama_kategori' => 'Prestasi', 'slug' => 'prestasi', 'kode_warna_hex' => '#f59e0b']);
        $katKesehatan = KategoriBerita::create(['nama_kategori' => 'Kesehatan', 'slug' => 'kesehatan', 'kode_warna_hex' => '#ef4444']);
        $katInternal = KategoriBerita::create(['nama_kategori' => 'Internal', 'slug' => 'internal', 'kode_warna_hex' => '#3b82f6']);
        $katEdukasi = KategoriBerita::create(['nama_kategori' => 'Edukasi', 'slug' => 'edukasi', 'kode_warna_hex' => '#a855f7']);
        $katSosial = KategoriBerita::create(['nama_kategori' => 'Sosial', 'slug' => 'sosial', 'kode_warna_hex' => '#ec4899']);

        $beritaData = [
            [
                'kategori_id' => $katEvent->id,
                'judul' => 'Persiapan Menuju FORKAB 2026: Rapat Koordinasi Wilayah',
                'slug' => 'persiapan-menuju-forkab-2026-rapat-koordinasi-wilayah',
                'ringkasan' => 'KORMI Kabupaten Bandung melakukan sinkronisasi program kerja bersama seluruh pengurus kecamatan untuk mempersiapkan FORKAB 2026 yang akan segera diselenggarakan.',
                'isi_konten' => '<p>KORMI Kabupaten Bandung menyelenggarakan rapat koordinasi wilayah untuk mematangkan kesiapan pelaksanaan Festival Olahraga Rekreasi Masyarakat Kabupaten (FORKAB) 2026. Pertemuan yang dihadiri oleh seluruh koordinator kecamatan dan pimpinan induk organisasi olahraga (INORGA) ini bertujuan menyelaraskan teknis perlombaan dan kesiapan kontingen dari 31 kecamatan.</p><p>Ketua KORMI Kabupaten Bandung menyampaikan bahwa FORKAB tahun ini akan mengusung semangat kolaborasi dan kebugaran inklusif untuk seluruh lapisan masyarakat Kabupaten Bandung.</p>',
                'gambar_utama' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800',
                'status_unggulan' => true,
                'status_publikasi' => 'published',
                'tanggal_publikasi' => now()->subDays(2),
                'jumlah_dilihat' => 1240,
            ],
            [
                'kategori_id' => $katPrestasi->id,
                'judul' => 'Atlet Inorga Kabupaten Bandung Raih Emas di Kejuaraan Nasional',
                'slug' => 'atlet-inorga-kabupaten-bandung-raih-emas-di-kejuaraan-nasional',
                'ringkasan' => 'Kebanggaan bagi warga Bandung, perwakilan atlet tradisional kita berhasil menyabet podium utama di ajang nasional.',
                'isi_konten' => '<p>Prestasi membanggakan kembali diukir oleh atlet olahraga rekreasi Kabupaten Bandung pada ajang Kejuaraan Tingkat Nasional. Delegasi berhasil membawa pulang medali emas setelah unggul di kategori ketangkasan dan olahraga tradisional.</p>',
                'gambar_utama' => 'https://images.unsplash.com/photo-1526676023641-72e042776856?q=80&w=800',
                'status_unggulan' => false,
                'status_publikasi' => 'published',
                'tanggal_publikasi' => now()->subDays(5),
                'jumlah_dilihat' => 870,
            ],
            [
                'kategori_id' => $katKesehatan->id,
                'judul' => 'Senam Massal Bedas di Soreang: Ribuan Warga Turut Memeriahkan',
                'slug' => 'senam-massal-bedas-di-soreang-ribuan-warga-turut-memeriahkan',
                'ringkasan' => 'Peningkatan indeks kebugaran masyarakat menjadi target utama dalam kegiatan rutin mingguan ini yang diikuti ribuan peserta.',
                'isi_konten' => '<p>Ribuan warga memadati area Lapangan Upakarti Soreang untuk mengikuti Senam Massal Bedas. Kegiatan ini merupakan bagian dari gerakan pembudayaan olahraga yang digelorakan KORMI bekerjasama dengan ASIAFI dan STI.</p>',
                'gambar_utama' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800',
                'status_unggulan' => false,
                'status_publikasi' => 'published',
                'tanggal_publikasi' => now()->subDays(8),
                'jumlah_dilihat' => 1520,
            ],
            [
                'kategori_id' => $katInternal->id,
                'judul' => 'Audiensi KORMI Bersama Bupati Bandung Bahas Masa Depan Olahraga',
                'slug' => 'audiensi-kormi-bersama-bupati-bandung-bahas-masa-depan-olahraga',
                'ringkasan' => 'Pertemuan strategis untuk memperkuat dukungan pemerintah daerah terhadap olahraga rekreasi masyarakat.',
                'isi_konten' => '<p>Jajaran pengurus KORMI Kabupaten Bandung diterima langsung oleh Bupati Bandung di Rumah Dinas Soreang. Pertemuan ini membahas rencana penguatan infrastruktur olahraga masyarakat serta pendukungan anggaran untuk pembinaan 31 kecamatan.</p>',
                'gambar_utama' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=800',
                'status_unggulan' => false,
                'status_publikasi' => 'published',
                'tanggal_publikasi' => now()->subDays(10),
                'jumlah_dilihat' => 960,
            ],
            [
                'kategori_id' => $katEdukasi->id,
                'judul' => 'Pelatihan Pelatih Olahraga Tradisional Tingkat Kabupaten Bandung',
                'slug' => 'pelatihan-pelatih-olahraga-tradisional-tingkat-kabupaten-bandung',
                'ringkasan' => 'Mencetak instruktur yang kompeten untuk melestarikan budaya olahraga asli daerah di setiap kecamatan.',
                'isi_konten' => '<p>Sebanyak 60 calon pelatih olahraga tradisional mengikuti sertifikasi dan bimbingan teknis PORTINA untuk meningkatkan standar perwasitan dan kepelatihan egrang, terompah panjang, dan hadang.</p>',
                'gambar_utama' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800',
                'status_unggulan' => false,
                'status_publikasi' => 'published',
                'tanggal_publikasi' => now()->subDays(12),
                'jumlah_dilihat' => 640,
            ],
            [
                'kategori_id' => $katSosial->id,
                'judul' => 'Bakti Sosial KORMI Berbagi: Sehat Raganya, Bahagia Jiwanya',
                'slug' => 'bakti-sosial-kormi-berbagi-sehat-raganya-bahagia-jiwanya',
                'ringkasan' => 'Kegiatan kolaboratif antara olahraga dan kepedulian sosial di wilayah terdampak bencana alam.',
                'isi_konten' => '<p>KORMI menyalurkan bantuan paket logistik sekaligus mengadakan terapi senam bugar untuk warga terdampak di wilayah Kabupaten Bandung selatan.</p>',
                'gambar_utama' => 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800',
                'status_unggulan' => false,
                'status_publikasi' => 'published',
                'tanggal_publikasi' => now()->subDays(15),
                'jumlah_dilihat' => 510,
            ],
            [
                'kategori_id' => $katEvent->id,
                'judul' => 'Bandung Bedas Run 2026: Pendaftaran Resmi Dibuka!',
                'slug' => 'bandung-bedas-run-2026-pendaftaran-resmi-dibuka',
                'ringkasan' => 'Event lari terbesar di Kabupaten Bandung kembali hadir. Segera daftarkan diri Anda dan raihlah pengalaman berlari terbaik.',
                'isi_konten' => '<p>Pendaftaran Bandung Bedas Run 2026 kategori 5K dan 10K resmi dibuka. Rute akan melintasi ikon-ikon pariwisata Soreang dan Stadion Si Jalak Harupat.</p>',
                'gambar_utama' => 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800',
                'status_unggulan' => false,
                'status_publikasi' => 'published',
                'tanggal_publikasi' => now()->subDays(18),
                'jumlah_dilihat' => 2100,
            ],
            [
                'kategori_id' => $katPrestasi->id,
                'judul' => 'Kecamatan Margahayu Juara Umum FOTRADKAB 2025',
                'slug' => 'kecamatan-margahayu-juara-umum-fotradkab-2025',
                'ringkasan' => 'Dengan perolehan 10 emas, 6 perak, dan 4 perunggu, Margahayu keluar sebagai juara umum FOTRADKAB tahun ini.',
                'isi_konten' => '<p>Dominasi kontingen Margahayu di cabang hadang dan ketapel berhasil mengantarkan mereka mengukuhkan gelar Juara Umum FOTRADKAB.</p>',
                'gambar_utama' => 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800',
                'status_unggulan' => false,
                'status_publikasi' => 'published',
                'tanggal_publikasi' => now()->subDays(20),
                'jumlah_dilihat' => 1180,
            ]
        ];

        foreach ($beritaData as $b) {
            Berita::create(array_merge($b, ['penulis_id' => $admin->id]));
        }

        // 13. Galeri Album & Foto
        $albumForkab = GaleriAlbum::create([
            'judul_album' => 'FORKAB',
            'slug' => 'forkab',
            'tanggal_kegiatan' => '2025-08-15',
            'gambar_sampul' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800',
            'deskripsi' => 'Dokumentasi Festival Olahraga Rekreasi Masyarakat Tingkat Kabupaten Bandung.',
            'status_tampil' => true,
        ]);

        $albumFotradkab = GaleriAlbum::create([
            'judul_album' => 'FOTRADKAB',
            'slug' => 'fotradkab',
            'tanggal_kegiatan' => '2025-10-20',
            'gambar_sampul' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800',
            'deskripsi' => 'Dokumentasi Festival Olahraga Tradisional Tingkat Kabupaten Bandung.',
            'status_tampil' => true,
        ]);

        $albumBedasRun = GaleriAlbum::create([
            'judul_album' => 'Bedas Run',
            'slug' => 'bedas-run',
            'tanggal_kegiatan' => '2025-11-10',
            'gambar_sampul' => 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800',
            'deskripsi' => 'Dokumentasi Gelaran Bandung Bedas Run.',
            'status_tampil' => true,
        ]);

        $albumSenam = GaleriAlbum::create([
            'judul_album' => 'Senam Massal',
            'slug' => 'senam-massal',
            'tanggal_kegiatan' => '2026-05-01',
            'gambar_sampul' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800',
            'deskripsi' => 'Senam massal kebugaran di alun-alun dan stadion.',
            'status_tampil' => true,
        ]);

        $albumRakor = GaleriAlbum::create([
            'judul_album' => 'Rapat & Koordinasi',
            'slug' => 'rapat-dan-koordinasi',
            'tanggal_kegiatan' => '2026-04-12',
            'gambar_sampul' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800',
            'deskripsi' => 'Rapat kerja, audiensi dan koordinasi pengurus KORMI.',
            'status_tampil' => true,
        ]);

        $albumSosial = GaleriAlbum::create([
            'judul_album' => 'Kegiatan Sosial',
            'slug' => 'kegiatan-sosial',
            'tanggal_kegiatan' => '2026-03-25',
            'gambar_sampul' => 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800',
            'deskripsi' => 'Bakti sosial dan fun walk peduli lingkungan KORMI.',
            'status_tampil' => true,
        ]);

        $fotoData = [
            ['album_id' => $albumForkab->id, 'judul_foto' => 'Pembukaan FORKAB 2025', 'gambar_url' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800', 'tipe_grid' => 'col-span-2 row-span-2', 'urutan' => 1],
            ['album_id' => $albumSenam->id, 'judul_foto' => 'Senam Pagi Bersama Warga', 'gambar_url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800', 'tipe_grid' => 'normal', 'urutan' => 2],
            ['album_id' => $albumFotradkab->id, 'judul_foto' => 'Final Tarik Tambang FOTRADKAB', 'gambar_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800', 'tipe_grid' => 'normal', 'urutan' => 3],
            ['album_id' => $albumBedasRun->id, 'judul_foto' => 'Start Line Bedas Run 2025', 'gambar_url' => 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', 'tipe_grid' => 'col-span-1 row-span-2', 'urutan' => 4],
            ['album_id' => $albumRakor->id, 'judul_foto' => 'Rapat Koordinasi Pengurus', 'gambar_url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', 'tipe_grid' => 'normal', 'urutan' => 5],
            ['album_id' => $albumForkab->id, 'judul_foto' => 'Penyerahan Medali Juara Umum', 'gambar_url' => 'https://images.unsplash.com/photo-1526676023641-72e042776856?q=80&w=800', 'tipe_grid' => 'normal', 'urutan' => 6],
            ['album_id' => $albumSosial->id, 'judul_foto' => 'Fun Walk Peduli Lingkungan', 'gambar_url' => 'https://images.unsplash.com/photo-1506190506097-31133f7d3f97?q=80&w=800', 'tipe_grid' => 'normal', 'urutan' => 7],
            ['album_id' => $albumFotradkab->id, 'judul_foto' => 'Lomba Egrang Putra FOTRADKAB', 'gambar_url' => 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800', 'tipe_grid' => 'col-span-2 row-span-1', 'urutan' => 8],
            ['album_id' => $albumSenam->id, 'judul_foto' => 'Aerobik Pagi di Alun-Alun', 'gambar_url' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=800', 'tipe_grid' => 'normal', 'urutan' => 9],
            ['album_id' => $albumBedasRun->id, 'judul_foto' => 'Bedas Run: Finish Line', 'gambar_url' => 'https://images.unsplash.com/photo-1461896836934-bd45ba0fcf5b?q=80&w=800', 'tipe_grid' => 'normal', 'urutan' => 10],
            ['album_id' => $albumRakor->id, 'judul_foto' => 'Audiensi dengan Bupati', 'gambar_url' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=800', 'tipe_grid' => 'normal', 'urutan' => 11],
            ['album_id' => $albumSosial->id, 'judul_foto' => 'Bakti Sosial KORMI Berbagi', 'gambar_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800', 'tipe_grid' => 'normal', 'urutan' => 12],
        ];

        foreach ($fotoData as $f) {
            GaleriFoto::create($f);
        }

        // 14. Data Sarana & Prasarana (SAPRAS)
        $soreang = $kecamatanDbMap['Soreang'] ?? Kecamatan::first();
        $baleendah = $kecamatanDbMap['Baleendah'] ?? $soreang;
        $cileunyi = $kecamatanDbMap['Cileunyi'] ?? $soreang;

        $saprasList = [
            ['nama_fasilitas' => 'Stadion Si Jalak Harupat', 'kategori_fasilitas' => 'Stadion', 'kecamatan_id' => $soreang->id, 'kapasitas' => '27.000 penonton', 'status_kondisi' => 'Baik', 'alamat_lengkap' => 'Kutawaringin, Soreang', 'jenis_olahraga_tersedia' => 'Sepakbola, Atletik, Senam', 'foto_url' => 'https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=600'],
            ['nama_fasilitas' => 'Lapangan Upakarti Soreang', 'kategori_fasilitas' => 'Lapangan', 'kecamatan_id' => $soreang->id, 'kapasitas' => '5.000 orang', 'status_kondisi' => 'Baik', 'alamat_lengkap' => 'Komplek Pemkab Bandung, Soreang', 'jenis_olahraga_tersedia' => 'Senam, Hadang, Terompah', 'foto_url' => 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?q=80&w=600'],
            ['nama_fasilitas' => 'GOR Baleendah', 'kategori_fasilitas' => 'GOR', 'kecamatan_id' => $baleendah->id, 'kapasitas' => '2.000 penonton', 'status_kondisi' => 'Baik', 'alamat_lengkap' => 'Jl. Raya Baleendah', 'jenis_olahraga_tersedia' => 'Silat, Senam, Tenis Meja', 'foto_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=600'],
            ['nama_fasilitas' => 'Lapangan Olahraga Cileunyi', 'kategori_fasilitas' => 'Lapangan', 'kecamatan_id' => $cileunyi->id, 'kapasitas' => '1.500 orang', 'status_kondisi' => 'Baik', 'alamat_lengkap' => 'Jl. Raya Cileunyi', 'jenis_olahraga_tersedia' => 'Egrang, Tarik Tambang', 'foto_url' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?q=80&w=600'],
        ];

        foreach ($saprasList as $sp) {
            \App\Models\Kormi\Sapras::create($sp);
        }

        // 15. Data SDI (Sumber Daya Insani) Program, Jadwal, & Peserta
        $progPelatih = \App\Models\Kormi\SdiProgram::create([
            'judul_program' => 'Pelatihan Pelatih & Instruktur Olahraga Tradisional',
            'slug' => 'pelatihan-pelatih-instruktur-olahraga-tradisional',
            'sasaran_peserta' => 'Pelatih Inorga & Guru Olahraga',
            'standar_kompetensi' => 'Sertifikasi Tingkat Dasar Kepelatihan KORMI',
            'jenis_sertifikasi' => 'Sertifikat Kompetensi KORMI',
        ]);

        $progWasit = \App\Models\Kormi\SdiProgram::create([
            'judul_program' => 'Bimbingan Teknis Wasit & Juri FOTRADKAB',
            'slug' => 'bimtek-wasit-juri-fotradkab',
            'sasaran_peserta' => 'Wasit Cabang Olahraga Tradisional',
            'standar_kompetensi' => 'Standar Perwasitan PORTINA & KORMI',
            'jenis_sertifikasi' => 'Lisensi Wasit Daerah',
        ]);

        $jadwal1 = \App\Models\Kormi\SdiJadwal::create([
            'program_id' => $progPelatih->id,
            'nama_angkatan' => 'Angkatan I - Tahun 2026',
            'tanggal_mulai' => '2026-07-15',
            'tanggal_selesai' => '2026-07-17',
            'lokasi_pelatihan' => 'Gedung KORMI Soreang',
            'kuota_peserta' => 30,
            'jumlah_pendaftar' => 18,
            'status_pendaftaran' => 'dibuka',
        ]);

        $jadwal2 = \App\Models\Kormi\SdiJadwal::create([
            'program_id' => $progWasit->id,
            'nama_angkatan' => 'Angkatan II - Tahun 2026',
            'tanggal_mulai' => '2026-08-20',
            'tanggal_selesai' => '2026-08-22',
            'lokasi_pelatihan' => 'Aula Dispora Kab. Bandung',
            'kuota_peserta' => 25,
            'jumlah_pendaftar' => 25,
            'status_pendaftaran' => 'penuh',
        ]);

        DB::table('kormi_sdi_peserta')->insert([
            [
                'id' => (string) Str::uuid(),
                'jadwal_id' => $jadwal1->id,
                'kecamatan_id' => $soreang->id,
                'nama_lengkap' => 'Asep Kurniawan, S.Pd',
                'nomor_telepon' => '081234567811',
                'email' => 'asep.kurniawan@gmail.com',
                'asal_lembaga_inorga' => 'Inorga PORTINA',
                'status_kelulusan' => 'lulus',
                'nomor_sertifikat' => 'KORMI-SDI-2026-001',
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'jadwal_id' => $jadwal1->id,
                'kecamatan_id' => $baleendah->id,
                'nama_lengkap' => 'Dewi Sartika, M.Pd',
                'nomor_telepon' => '081234567822',
                'email' => 'dewi.sartika@gmail.com',
                'asal_lembaga_inorga' => 'Inorga STI',
                'status_kelulusan' => 'lulus',
                'nomor_sertifikat' => 'KORMI-SDI-2026-002',
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ],
        ]);

        // 16. Data APMO (Anugerah Prestasi Masyarakat Olahraga)
        $apmo2025 = \App\Models\Kormi\ApmoTahun::create([
            'tahun' => 2025,
            'tema_acara' => 'Bangkit Bersama Olahraga Rekreasi Menuju Kabupaten Bandung BEDAS',
            'tanggal_penganugerahan' => '2025-12-20',
            'tempat_acara' => 'Gedung Budaya Sabilulungan, Soreang',
            'deskripsi' => 'Apresiasi tertinggi tahunan bagi insan olahraga masyarakat.',
        ]);

        $apmo2024 = \App\Models\Kormi\ApmoTahun::create([
            'tahun' => 2024,
            'tema_acara' => 'Kebugaran Masyarakat untuk Indonesia Maju',
            'tanggal_penganugerahan' => '2024-12-18',
            'tempat_acara' => 'Hotel Grand Sunshine, Soreang',
            'deskripsi' => 'Apresiasi tahunan edisi 2024.',
        ]);

        $penerima2025 = [
            [
                'apmo_tahun_id' => $apmo2025->id,
                'kategori_penghargaan' => 'Tokoh Penggerak Olahraga Masyarakat',
                'nama_penerima' => 'H. Dadang Supriatna, S.Ip., M.Si.',
                'asal_lembaga_wilayah' => 'Bupati Bandung',
                'deskripsi_capaian' => 'Dedikasi luar biasa dalam memajukan dan mengalokasikan dukungan penuh bagi ekosistem olahraga masyarakat di Kabupaten Bandung.',
                'urutan' => 1,
            ],
            [
                'apmo_tahun_id' => $apmo2025->id,
                'kategori_penghargaan' => 'Atlet Tradisional Berprestasi',
                'nama_penerima' => 'Rian Hidayat',
                'asal_lembaga_wilayah' => 'Inorga PORTINA - Cabang Egrang',
                'deskripsi_capaian' => 'Meraih medali emas pada ajang FORNAS dan konsisten mengedukasi generasi muda dalam pelestarian permainan tradisional.',
                'urutan' => 2,
            ],
            [
                'apmo_tahun_id' => $apmo2025->id,
                'kategori_penghargaan' => 'Inorga Teraktif & Teladan',
                'nama_penerima' => 'ASIAFI Kabupaten Bandung',
                'asal_lembaga_wilayah' => 'Asosiasi Instruktur Aerobik dan Fitnes Indonesia',
                'deskripsi_capaian' => 'Paling aktif menyelenggarakan senam massal rutin di puluhan titik kecamatan dan desa setiap minggunya.',
                'urutan' => 3,
            ],
            [
                'apmo_tahun_id' => $apmo2025->id,
                'kategori_penghargaan' => 'Koordinator Kecamatan Terbaik',
                'nama_penerima' => 'Koordinator Kecamatan Soreang',
                'asal_lembaga_wilayah' => 'Kordik Soreang',
                'deskripsi_capaian' => 'Pengelolaan data duta olahraga desa tercepat dan penyelenggara festival olahraga desa terpadu.',
                'urutan' => 4,
            ],
        ];

        foreach ($penerima2025 as $p) {
            \App\Models\Kormi\ApmoPenerima::create($p);
        }

        // 17. Log Aktivitas
        DB::table('sys_log_aktivitas')->insert([
            'id' => (string) Str::uuid(),
            'pengguna_id' => $admin->id,
            'jenis_aksi' => 'INITIAL_SEED',
            'nama_tabel' => 'sys_pengaturan_situs',
            'id_entitas' => $admin->id,
            'data_lama' => null,
            'data_baru' => json_encode(['status' => 'System initialized with full KORMI data']),
            'alamat_ip' => '127.0.0.1',
            'agen_pengguna' => 'Seeder Script',
            'dibuat_pada' => now(),
        ]);

        // 18. Dummy Akun Setiap Role Akses
        $this->call(DummyAkunRoleSeeder::class);
    }
}
