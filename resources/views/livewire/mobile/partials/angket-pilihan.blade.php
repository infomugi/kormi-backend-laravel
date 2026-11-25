{{-- Daftar pilihan radio; parameter: $field, $opsi, $live --}}
<div class="kd-choice-list">
    @foreach($opsi as $nilai => $label)
        <label class="kd-choice">
            @if($live ?? false)
                <input type="radio" id="{{ $field }}-{{ $nilai }}" wire:model.live="{{ $field }}" value="{{ $nilai }}">
            @else
                <input type="radio" id="{{ $field }}-{{ $nilai }}" wire:model="{{ $field }}" value="{{ $nilai }}">
            @endif
            <span class="kd-choice-dot"></span>
            <span>{{ $label }}</span>
        </label>
    @endforeach
</div>
