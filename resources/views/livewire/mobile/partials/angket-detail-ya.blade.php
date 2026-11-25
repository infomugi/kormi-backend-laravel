{{-- Langkah 3 (cabang "Ya"): No. 8–19 --}}
<div class="kd-subhead">
    <h4>Jenis &amp; Durasi Olahraga</h4>
    <span class="kd-chip">Bagian 3</span>
</div>

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">8</span> Berapa kali Anda berolahraga berat seperti senam aerobik, bersepeda cepat, dsb. yang membuat napas Anda terengah-engah dalam satu minggu terakhir ini? <span class="kd-req">*</span></span>
    </div>
    @include('livewire.mobile.partials.angket-pilihan', ['field' => 'frekuensi_berat', 'opsi' => $opsiFrekuensi])
    @error('frekuensi_berat')<p class="kd-error">{{ $message }}</p>@enderror
</div>

@include('livewire.mobile.partials.angket-durasi', [
    'prefix' => 'durasi_berat',
    'nomor' => 9,
    'pertanyaan' => 'Berapa waktu yang Anda gunakan untuk berolahraga berat?',
])

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">10</span> Berapa kali Anda berolahraga sedang seperti berenang, bersepeda santai, dsb (tidak termasuk jalan kaki) yang membuat napas Anda agak terengah-engah dalam seminggu terakhir ini? <span class="kd-req">*</span></span>
    </div>
    @include('livewire.mobile.partials.angket-pilihan', ['field' => 'frekuensi_sedang', 'opsi' => $opsiFrekuensi])
    @error('frekuensi_sedang')<p class="kd-error">{{ $message }}</p>@enderror
</div>

@include('livewire.mobile.partials.angket-durasi', [
    'prefix' => 'durasi_sedang',
    'nomor' => 11,
    'pertanyaan' => 'Berapa waktu yang Anda gunakan untuk berolahraga sedang?',
])

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">12</span> Berapa kali Anda melakukan jalan kaki dalam satu minggu terakhir? <span class="kd-req">*</span></span>
    </div>
    @include('livewire.mobile.partials.angket-pilihan', ['field' => 'frekuensi_jalan', 'opsi' => $opsiFrekuensi])
    @error('frekuensi_jalan')<p class="kd-error">{{ $message }}</p>@enderror
</div>

@include('livewire.mobile.partials.angket-durasi', [
    'prefix' => 'durasi_jalan',
    'nomor' => 13,
    'pertanyaan' => 'Berapa waktu yang Anda gunakan untuk berjalan kaki?',
])

<div class="kd-subhead" style="margin-top: 20px;">
    <h4>Cabang &amp; Tujuan</h4>
</div>

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">14</span> Dalam berolahraga, jenis olahraga (cabang olahraga) apa yang sering Anda lakukan? <span class="kd-req">*</span></span>
    </div>
    @include('livewire.mobile.partials.angket-pilihan', ['field' => 'cabang_olahraga', 'opsi' => $opsiCabang, 'live' => true])
    @error('cabang_olahraga')<p class="kd-error">{{ $message }}</p>@enderror
</div>

@if($cabang_olahraga === 'lainnya')
    <div class="kd-group">
        <div class="kd-label-row">
            <label class="kd-label" for="m-angket-cabang-lain">Sebutkan Cabang Olahraga <span class="kd-req">*</span></label>
        </div>
        <div class="kd-control">
            <input type="text" id="m-angket-cabang-lain" wire:model="cabang_lainnya" class="kd-input" placeholder="Cabang olahraga Anda">
        </div>
        @error('cabang_lainnya')<p class="kd-error">{{ $message }}</p>@enderror
    </div>
@endif

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">15</span> Apakah tujuan utama Anda berolahraga? <span class="kd-req">*</span></span>
    </div>
    @include('livewire.mobile.partials.angket-pilihan', ['field' => 'tujuan_olahraga', 'opsi' => $opsiTujuan, 'live' => true])
    @error('tujuan_olahraga')<p class="kd-error">{{ $message }}</p>@enderror
</div>

@if($tujuan_olahraga === 'lainnya')
    <div class="kd-group">
        <div class="kd-label-row">
            <label class="kd-label" for="m-angket-tujuan-lain">Sebutkan Tujuan <span class="kd-req">*</span></label>
        </div>
        <div class="kd-control">
            <input type="text" id="m-angket-tujuan-lain" wire:model="tujuan_lainnya" class="kd-input" placeholder="Tujuan Anda berolahraga">
        </div>
        @error('tujuan_lainnya')<p class="kd-error">{{ $message }}</p>@enderror
    </div>
@endif

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">16</span> Melalui jalur apa Anda melakukan olahraga? <span class="kd-req">*</span></span>
    </div>
    @include('livewire.mobile.partials.angket-pilihan', ['field' => 'jalur_olahraga', 'opsi' => $opsiJalur, 'live' => true])
    @error('jalur_olahraga')<p class="kd-error">{{ $message }}</p>@enderror
</div>

@if($jalur_olahraga === 'lainnya')
    <div class="kd-group">
        <div class="kd-label-row">
            <label class="kd-label" for="m-angket-jalur-lain">Sebutkan Jalur <span class="kd-req">*</span></label>
        </div>
        <div class="kd-control">
            <input type="text" id="m-angket-jalur-lain" wire:model="jalur_lainnya" class="kd-input" placeholder="Jalur olahraga Anda">
        </div>
        @error('jalur_lainnya')<p class="kd-error">{{ $message }}</p>@enderror
    </div>
@endif

<div class="kd-subhead" style="margin-top: 20px;">
    <h4>Kebiasaan &amp; Fasilitas</h4>
</div>

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">17</span> Pernahkah Anda merasa malas untuk melakukan kegiatan olahraga? <span class="kd-req">*</span></span>
    </div>
    @include('livewire.mobile.partials.angket-pilihan', ['field' => 'pernah_malas', 'opsi' => ['pernah' => 'Pernah', 'tidak_pernah' => 'Tidak Pernah'], 'live' => true])
    @error('pernah_malas')<p class="kd-error">{{ $message }}</p>@enderror
</div>

@if($pernah_malas === 'pernah')
    @include('livewire.mobile.partials.angket-durasi', [
        'prefix' => 'duduk',
        'nomor' => 18,
        'pertanyaan' => 'Dalam 7 hari terakhir ini, berapa lama Anda duduk dalam satu hari?',
    ])
@endif

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">19</span> Menurut pendapat Anda, bagaimanakah fasilitas olahraga di daerah Anda sekarang ini? <span class="kd-req">*</span></span>
    </div>
    @include('livewire.mobile.partials.angket-pilihan', ['field' => 'fasilitas_olahraga', 'opsi' => $opsiFasilitas])
    @error('fasilitas_olahraga')<p class="kd-error">{{ $message }}</p>@enderror
</div>
