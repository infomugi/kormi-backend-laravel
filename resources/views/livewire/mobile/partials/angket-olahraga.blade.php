{{-- Langkah 2: apakah melakukan olahraga (No. 7) --}}
<div class="kd-subhead">
    <h4>Pertanyaan Olahraga</h4>
    <span class="kd-chip">Bagian 2</span>
</div>

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">7</span> Apakah dalam satu minggu terakhir ini, Anda melakukan kegiatan olahraga? <span class="kd-req">*</span></span>
    </div>

    <div class="kd-choice-list">
        <label class="kd-choice">
            <input type="radio" id="melakukan_olahraga-ya" wire:model.live="melakukan_olahraga" value="ya">
            <span class="kd-choice-dot"></span>
            <span>Ya</span>
        </label>
        <label class="kd-choice">
            <input type="radio" id="melakukan_olahraga-tidak" wire:model.live="melakukan_olahraga" value="tidak">
            <span class="kd-choice-dot"></span>
            <span>Tidak</span>
        </label>
    </div>

    @error('melakukan_olahraga')<p class="kd-error">{{ $message }}</p>@enderror
</div>

<div class="kd-notice kd-notice-lime">
    <i data-lucide="info"></i>
    <span>
        @if($melakukan_olahraga === 'ya')
            Selanjutnya Anda akan mengisi pertanyaan seputar jenis dan durasi olahraga.
        @elseif($melakukan_olahraga === 'tidak')
            Selanjutnya Anda akan mengisi alasan tidak berolahraga.
        @else
            Pilih salah satu jawaban untuk melanjutkan.
        @endif
    </span>
</div>
