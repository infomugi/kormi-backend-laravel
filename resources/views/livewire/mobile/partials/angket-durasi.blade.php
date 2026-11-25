{{-- Isian durasi jam & menit; parameter: $prefix, $nomor, $pertanyaan --}}
<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;"><span class="kd-qnum">{{ $nomor }}</span> {{ $pertanyaan }} <span class="kd-req">*</span></span>
    </div>

    @if(! $this->{$prefix . '_tidak_tahu'})
        <div class="kd-durasi">
            <div class="kd-control">
                <input type="number" id="{{ $prefix }}-jam" wire:model="{{ $prefix }}_jam" class="kd-input" placeholder="0" min="0" max="23" inputmode="numeric">
                <span class="kd-durasi-unit">jam</span>
            </div>
            <div class="kd-control">
                <input type="number" id="{{ $prefix }}-menit" wire:model="{{ $prefix }}_menit" class="kd-input" placeholder="0" min="0" max="59" inputmode="numeric">
                <span class="kd-durasi-unit">menit</span>
            </div>
        </div>
    @endif

    <label class="kd-check">
        <input type="checkbox" id="{{ $prefix }}-tidak-tahu" wire:model.live="{{ $prefix }}_tidak_tahu">
        <span class="kd-check-box"><i data-lucide="check"></i></span>
        <span>Tidak tahu/Tidak pasti</span>
    </label>

    @error($prefix . '_jam')<p class="kd-error">{{ $message }}</p>@enderror
    @error($prefix . '_menit')<p class="kd-error">{{ $message }}</p>@enderror
</div>
