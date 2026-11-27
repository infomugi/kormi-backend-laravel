<div class="kd-success">
    <div class="kd-success-check">
        <i data-lucide="check" class="stroke-[3]"></i>
    </div>
    <span class="kd-success-tag">Survey Terkirim</span>
    <h2>Terima kasih, {{ $namaTersimpan ?: 'Responden' }}!</h2>
    <p class="kd-success-text">
        Jawaban Anda telah kami simpan untuk program <strong>APMO KORMI Kabupaten Bandung</strong>.
        Masukan Anda membantu pemetaan kebiasaan dan fasilitas olahraga masyarakat.
    </p>

    <div class="kd-success-card">
        <div class="kd-success-row">
            <i data-lucide="user-round"></i>
            <p>Responden: <strong>{{ $namaTersimpan }}</strong></p>
        </div>
        <div class="kd-success-row">
            <i data-lucide="clock"></i>
            <p>Waktu pengisian: <strong>{{ $waktuTersimpan }}</strong></p>
        </div>
        <div class="kd-success-row">
            <i data-lucide="camera"></i>
            <p>Foto bukti: <strong>{{ $fotoDilampirkan ? 'terlampir' : 'tidak dilampirkan' }}</strong></p>
        </div>
        <div class="kd-success-row">
            <i data-lucide="database"></i>
            <p>Status: <strong>tersimpan</strong></p>
        </div>
    </div>

    <div class="kd-success-actions">
        <a href="{{ route('mobile.beranda') }}" wire:navigate class="kd-btn-primary">
            <i data-lucide="home" class="w-4 h-4"></i>
            <span>Kembali ke Beranda</span>
        </a>
        @auth
            <a href="{{ route('mobile.layanan') }}" wire:navigate class="kd-btn-ghost">
                <i data-lucide="blocks" class="w-4 h-4"></i>
                <span>Buka Layanan</span>
            </a>
        @endauth
        <button type="button" wire:click="isiLagi" class="kd-btn-ghost">
            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
            <span>Isi Survey Lagi</span>
        </button>
    </div>
</div>
