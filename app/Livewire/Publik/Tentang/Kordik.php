<?php

namespace App\Livewire\Publik\Tentang;

use Livewire\Component;

class Kordik extends Component
{
    public string $cari = '';

    public function render()
    {
        $dbKordik = \App\Models\KordikPengurus::with('kecamatan')
            ->when($this->cari, function ($q) {
                $q->where('nama_ketua', 'like', "%{$this->cari}%")
                  ->orWhereHas('kecamatan', fn($kq) => $kq->where('nama_kecamatan', 'like', "%{$this->cari}%"));
            })
            ->orderBy('nama_ketua')
            ->get();

        if ($dbKordik->isNotEmpty() || (!empty($this->cari) && \App\Models\KordikPengurus::count() > 0)) {
            $dataKoordinator = $dbKordik->map(fn($item) => [
                'nama' => $item->nama_ketua ?? $item->nama_lengkap ?? '',
                'kec' => $item->kecamatan ? 'Kecamatan ' . $item->kecamatan->nama_kecamatan : 'Kecamatan Umum',
                'sekretaris' => $item->nama_sekretaris ?? '',
                'bendahara' => $item->nama_bendahara ?? '',
                'telepon' => $item->nomor_telepon ?? '',
            ])->toArray();
        } else {
            $dataKoordinator = [
                ['nama' => 'NOPI GANDINI', 'kec' => 'Kecamatan Arjasari'],
                ['nama' => 'IKA KARTIKA HIDAYAT', 'kec' => 'Kecamatan Baleendah'],
                ['nama' => 'HILDA HIDAYAH, SP', 'kec' => 'Kecamatan Banjaran'],
                ['nama' => 'ERNA AGUSTINA, A.Md. Far', 'kec' => 'Kecamatan Bojongsoang'],
                ['nama' => 'ENDAH FERAWATI', 'kec' => 'Kecamatan Cangkuang'],
                ['nama' => 'ANI TARYANI', 'kec' => 'Kecamatan Cicalengka'],
                ['nama' => 'ADE ROMLAH, S. Ag', 'kec' => 'Kecamatan Cikancung'],
                ['nama' => 'DEBBY HERAWATY', 'kec' => 'Kecamatan Cilengkrang'],
                ['nama' => 'LANNY MULIAMAH', 'kec' => 'Kecamatan Cileunyi'],
                ['nama' => 'RITA SUKARSO', 'kec' => 'Kecamatan Cimaung'],
                ['nama' => 'SRI HETY PERTAMAWATI', 'kec' => 'Kecamatan Cimeunyan'],
                ['nama' => 'POPY JAYANTHI', 'kec' => 'Kecamatan Ciparay'],
                ['nama' => 'LALA SITI JAMILAH, S. Sos,Msi', 'kec' => 'Kecamatan Ciwidey'],
                ['nama' => 'LINDA NURKANIA, SE.,M.Pd', 'kec' => 'Kecamatan Dayeuhkolot'],
                ['nama' => 'SUSI SUSILAWATI', 'kec' => 'Kecamatan Ibun'],
                ['nama' => 'DR. ARLINA, M.Pd', 'kec' => 'Kecamatan Katapang'],
                ['nama' => 'HENNA ENAYAH, SH', 'kec' => 'Kecamatan Kertasari'],
                ['nama' => 'WIWIN WINARNI', 'kec' => 'Kecamatan Kutawaringin'],
                ['nama' => 'FARIDA', 'kec' => 'Kecamatan Majalaya'],
                ['nama' => 'WENNY WINARNY, SE., MM', 'kec' => 'Kecamatan Margaasih'],
                ['nama' => 'YUYUN YUNINGSIH', 'kec' => 'Kecamatan Margahayu'],
                ['nama' => 'RETNO MULIAYANI', 'kec' => 'Kecamatan Nagreg'],
                ['nama' => 'NINING SARIPAH', 'kec' => 'Kecamatan Pacet'],
                ['nama' => 'RIKA HUMAIROH, S.Sos', 'kec' => 'Kecamatan Pameungpeuk'],
                ['nama' => 'NOVITA SARDI', 'kec' => 'Kecamatan Pangalengan'],
                ['nama' => 'WATWAT JULIAWATI', 'kec' => 'Kecamatan Paseh'],
                ['nama' => 'IKA KARTIKA SARI', 'kec' => 'Kecamatan Pasirjambu'],
                ['nama' => 'DEDEH YUNINGSIH', 'kec' => 'Kecamatan Rancabali'],
                ['nama' => 'drg. NOVITA UTAMI', 'kec' => 'Kecamatan Rancaekek'],
                ['nama' => 'YOIKA INDRAWATI', 'kec' => 'Kecamatan Solokanjeruk'],
                ['nama' => 'HJ. RIA RESTIANA R', 'kec' => 'Kecamatan Soreang']
            ];

            if ($this->cari !== '') {
                $dataKoordinator = array_filter($dataKoordinator, function ($item) {
                    return stripos($item['nama'], $this->cari) !== false || stripos($item['kec'], $this->cari) !== false;
                });
            }
        }

        return view('livewire.publik.tentang.kordik', [
            'kordikList' => $dataKoordinator,
        ])->layout('components.layouts.app', ['title' => 'Koordinator Kecamatan - KORMI Kabupaten Bandung']);
    }
}
