{{-- Langkah 3 (penutup): foto selfie sebagai lampiran bukti survey --}}
<div class="kd-subhead" style="margin-top: 20px;">
    <h4>Foto Bukti Survey</h4>
    <span class="kd-chip">Wajib</span>
</div>

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;">Unggah foto selfie Anda sebagai lampiran bukti bahwa survey ini diisi langsung oleh responden. <span class="kd-req">*</span></span>
    </div>

    @php $fotoTersimpan = $modeUbah ? $isianDiubah?->foto_bukti_url : null; @endphp

    @if($foto_bukti)
        @php $ekstensiFoto = strtolower($foto_bukti->getClientOriginalExtension()); @endphp
        @if(in_array($ekstensiFoto, ['jpg', 'jpeg', 'png', 'webp', 'gif']))
            <div class="kd-photo-preview">
                <img src="{{ $foto_bukti->temporaryUrl() }}" alt="Pratinjau foto bukti survey">
            </div>
        @else
            <div class="kd-file-chip">
                <i data-lucide="file" class="w-4 h-4"></i>
                <span>{{ $foto_bukti->getClientOriginalName() }}</span>
            </div>
        @endif
    @elseif($fotoTersimpan)
        <div class="kd-photo-preview">
            <img src="{{ $fotoTersimpan }}" alt="Foto bukti survey tersimpan">
        </div>
    @endif

    <label class="kd-upload">
        <i data-lucide="camera"></i>
        <span class="kd-upload-title">{{ $foto_bukti || $fotoTersimpan ? 'Ganti Foto Selfie' : 'Ambil Foto Selfie' }}</span>
        <span class="kd-upload-sub">Kamera depan · JPG, JPEG, PNG, WEBP — otomatis dikompres ≤ 1 MB</span>
        <input type="file" wire:model="foto_bukti" accept="image/jpeg,image/png,image/webp" capture="user" class="sr-only">
    </label>

    <label class="kd-upload-galeri">
        <i data-lucide="image"></i>
        <span>atau pilih foto dari galeri</span>
        <input type="file" wire:model="foto_bukti" accept="image/jpeg,image/png,image/webp" class="sr-only">
    </label>

    <div wire:loading wire:target="foto_bukti" class="kd-upload-status">
        <span class="kd-spinner kd-spinner--dark"></span>
        <span>Mengunggah foto...</span>
    </div>
    @error('foto_bukti')<p class="kd-error">{{ $message }}</p>@enderror
</div>
