{{-- Langkah 3 (cabang "Tidak"): No. 20–21 --}}
<div class="kd-subhead">
    <h4>Alasan Tidak Berolahraga</h4>
    <span class="kd-chip">Bagian 4</span>
</div>

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">20</span> Mengapa Anda tidak melakukan kegiatan olahraga? <span class="kd-req">*</span></span>
    </div>
    @include('livewire.mobile.partials.angket-pilihan', ['field' => 'alasan_tidak_olahraga', 'opsi' => $opsiAlasan, 'live' => true])
    @error('alasan_tidak_olahraga')<p class="kd-error">{{ $message }}</p>@enderror
</div>

@if($alasan_tidak_olahraga === 'lainnya')
    <div class="kd-group">
        <div class="kd-label-row">
            <label class="kd-label" for="m-angket-alasan-lain">Sebutkan Alasan <span class="kd-req">*</span></label>
        </div>
        <div class="kd-control">
            <input type="text" id="m-angket-alasan-lain" wire:model="alasan_lainnya" class="kd-input" placeholder="Alasan Anda">
        </div>
        @error('alasan_lainnya')<p class="kd-error">{{ $message }}</p>@enderror
    </div>
@endif

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">21</span> Menurut pendapat Anda, bagaimanakah fasilitas olahraga di daerah Anda sekarang ini? <span class="kd-req">*</span></span>
    </div>
    @include('livewire.mobile.partials.angket-pilihan', ['field' => 'fasilitas_olahraga', 'opsi' => $opsiFasilitas])
    @error('fasilitas_olahraga')<p class="kd-error">{{ $message }}</p>@enderror
</div>
