{{-- Angket APMO mobile — desain mobile_kormi.html --}}
<div class="kd-mobile min-h-screen">
    <div class="kd-header">
        <div class="kd-brand">
            <div class="kd-brand-icon">K</div>
            <span class="kd-brand-title">KORMI Kab. Bandung</span>
        </div>
        <p class="kd-brand-sub">{{ $modeUbah ? 'Ubah Isian APMO' : 'Survey APMO' }}</p>
    </div>

    <div class="kd-sheet">
        @if($selesai)
            @include('livewire.mobile.partials.angket-selesai')
        @else
            <div class="kd-section-head">
                <div>
                    <h3>{{ $modeUbah ? 'Ubah Isian APMO' : 'Survey APMO' }}</h3>
                    <p>Isilah titik-titik atau pilih jawaban sesuai kondisi Anda. Jawaban tidak dinilai benar atau salah, yang penting sesuai keadaan sebenarnya.</p>
                </div>
                <span class="kd-badge">{{ $modeUbah ? 'Ubah' : 'Responden' }}</span>
            </div>

            @if($modeUbah)
                @php $tanggalDiubah = $isianDiubah?->dibuat_pada ?? $pengisianTerakhir?->dibuat_pada; @endphp
                <div class="kd-notice kd-notice-amber" style="margin-bottom: 14px;">
                    <i data-lucide="alert-triangle"></i>
                    <span>Anda mengubah isian{{ $tanggalDiubah ? ' tanggal ' . \Carbon\Carbon::parse($tanggalDiubah)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM Y') : '' }}. Data lama akan ditimpa setelah Anda menekan Simpan Perubahan.</span>
                </div>
            @elseif($pengisianTerakhir)
                <div class="kd-notice kd-notice-lime" style="margin-bottom: 14px;">
                    <i data-lucide="history"></i>
                    <span>Anda sudah mengisi survey ini pada {{ \Carbon\Carbon::parse($pengisianTerakhir->dibuat_pada)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM Y') }}. Pengisian baru akan disimpan sebagai data terbaru.</span>
                </div>
            @endif

            <div class="kd-steps kd-steps--3">
                @foreach([[1, 'Identitas'], [2, 'Olahraga'], [3, 'Detail']] as [$nomor, $label])
                    <div class="kd-step {{ $langkah === $nomor ? 'is-active' : ($langkah > $nomor ? 'is-done' : '') }}">
                        <span class="kd-step-num">{{ $nomor }}</span>
                        <span class="kd-step-label">{{ $label }}</span>
                    </div>
                @endforeach
            </div>

            @if($langkah === 1)
                <form wire:submit="lanjut" novalidate>
                    @include('livewire.mobile.partials.angket-identitas')

                    <button type="submit" class="kd-btn-primary" style="width: 100%; margin-top: 6px;" wire:loading.attr="disabled" wire:target="lanjut">
                        <span wire:loading.remove wire:target="lanjut">Lanjut ke Pertanyaan Olahraga</span>
                        <span wire:loading wire:target="lanjut">Memeriksa...</span>
                    </button>
                </form>
            @elseif($langkah === 2)
                <form wire:submit="lanjut" novalidate>
                    @include('livewire.mobile.partials.angket-olahraga')

                    <div class="kd-form-nav">
                        <button type="button" wire:click="kembali" class="kd-btn-ghost">Kembali</button>
                        <button type="submit" class="kd-btn-primary" wire:loading.attr="disabled" wire:target="lanjut">
                            <span wire:loading.remove wire:target="lanjut">Lanjut</span>
                            <span wire:loading wire:target="lanjut">Memeriksa...</span>
                        </button>
                    </div>
                </form>
            @else
                <form wire:submit="kirim" novalidate>
                    @if($melakukan_olahraga === 'ya')
                        @include('livewire.mobile.partials.angket-detail-ya')
                    @else
                        @include('livewire.mobile.partials.angket-detail-tidak')
                    @endif

                    @include('livewire.mobile.partials.angket-foto-bukti')

                    <div class="kd-form-nav">
                        <button type="button" wire:click="kembali" class="kd-btn-ghost">Kembali</button>
                        <button type="submit" class="kd-btn-primary" wire:loading.attr="disabled" wire:target="kirim">
                            <i data-lucide="{{ $modeUbah ? 'save' : 'send' }}" class="w-4 h-4"></i>
                            <span wire:loading.remove wire:target="kirim">{{ $modeUbah ? 'Simpan Perubahan' : 'Kirim Survey' }}</span>
                            <span wire:loading wire:target="kirim">{{ $modeUbah ? 'Menyimpan...' : 'Mengirim...' }}</span>
                        </button>
                    </div>

                    @if($modeUbah)
                        <a href="{{ route('mobile.laporan') }}" wire:navigate class="kd-btn-ghost" style="width: 100%; margin-top: 10px;">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            <span>Batal, kembali ke laporan</span>
                        </a>
                    @endif
                </form>
            @endif

            <p class="kd-footnote">Jawaban Anda disimpan untuk program APMO KORMI Kabupaten Bandung.</p>
        @endif
    </div>

    <x-mobile.tabbar aktif="apmo" />
</div>
