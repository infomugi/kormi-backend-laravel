{{-- Langkah 3 (penutup): foto selfie sebagai lampiran bukti survey --}}
@php
    $fotoTersimpan = $modeUbah ? $isianDiubah?->foto_bukti_url : null;
    $fotoOpsional = $fotoTersimpan !== null;
@endphp

<div class="kd-subhead" style="margin-top: 20px;">
    <h4>Foto Bukti Survey</h4>
    <span class="kd-chip">{{ $fotoOpsional ? 'Opsional' : 'Wajib' }}</span>
</div>

<div class="kd-group">
    <div class="kd-label-row" style="align-items: flex-start;">
        <span class="kd-label" style="line-height: 1.45;">
            @if($fotoOpsional)
                Foto selfie saat ini sudah tersimpan. Unggah foto baru bila ingin menggantinya, atau biarkan kosong untuk tetap memakai foto lama.
            @else
                Unggah foto selfie Anda sebagai lampiran bukti bahwa survey ini diisi langsung oleh responden. <span class="kd-req">*</span>
            @endif
        </span>
    </div>

    @if($foto_bukti)
        @php
            // Cegah 500 (FileNotPreviewableException) untuk berkas yang tidak bisa
            // dipratinjaukan, mis. HEIC/HEIF dari iPhone yang belum dikonversi.
            try {
                $bisaPratinjau = $foto_bukti->isPreviewable();
                $urlPratinjau = $bisaPratinjau ? $foto_bukti->temporaryUrl() : null;
            } catch (\Throwable $e) {
                $bisaPratinjau = false;
                $urlPratinjau = null;
            }
        @endphp
        @if($bisaPratinjau && $urlPratinjau)
            <div class="kd-photo-preview">
                <img src="{{ $urlPratinjau }}" alt="Pratinjau foto bukti survey">
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
        <span class="kd-upload-sub">Kamera depan · JPG, PNG, WEBP, HEIC · maks 10 MB, otomatis dikompres ≤ 1 MB</span>
        <input type="file" wire:model="foto_bukti" accept="image/jpeg,image/png,image/webp,image/heic,image/heif" capture="user" class="sr-only">
    </label>

    <label class="kd-upload-galeri">
        <i data-lucide="image"></i>
        <span>atau pilih foto dari galeri</span>
        <input type="file" wire:model="foto_bukti" accept="image/jpeg,image/png,image/webp,image/heic,image/heif" class="sr-only">
    </label>

    <p class="kd-upload-sub" style="display: block; margin-top: 6px; text-align: center;">
        Foto HEIC/HEIF dari iPhone otomatis dikonversi ke JPG.
    </p>

    <div wire:loading wire:target="foto_bukti" class="kd-upload-status">
        <span class="kd-spinner kd-spinner--dark"></span>
        <span>Mengunggah foto...</span>
    </div>
    @error('foto_bukti')<p class="kd-error">{{ $message }}</p>@enderror
</div>
