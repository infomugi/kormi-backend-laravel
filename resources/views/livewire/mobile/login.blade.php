    {{-- Versi mobile dari /login — desain mobile_kormi.html --}}
    <div class="kd-mobile min-h-screen">
        <div class="kd-header">
            <div class="kd-brand">
                <div class="kd-brand-icon">K</div>
                <span class="kd-brand-title">KORMI Kab. Bandung</span>
            </div>
            <p class="kd-brand-sub">Masuk ke Akun KORMI</p>
        </div>

        <div class="kd-sheet">
            <div class="kd-section-head">
                <div>
                    <h3>Masuk ke Akun</h3>
                    <p>Gunakan email &amp; kata sandi yang terdaftar.</p>
                </div>
                <span class="kd-badge">Akun</span>
            </div>

            @if (session()->has('error'))
                <div class="kd-notice kd-notice-rose">
                    <i data-lucide="alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session()->has('status') || session()->has('success'))
                <div class="kd-notice kd-notice-lime">
                    <i data-lucide="check-circle-2"></i>
                    <span>{{ session('status') ?? session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.masuk.post') }}" method="POST" wire:submit="login">
                @csrf

                <div class="kd-group">
                    <div class="kd-label-row">
                        <label class="kd-label" for="m-masuk-email">Alamat Email <span class="kd-req">*</span></label>
                    </div>
                    <div class="kd-control">
                        <input id="m-masuk-email" type="email" name="email" wire:model="email" class="kd-input" placeholder="nama@kormibdg.id" required autocomplete="email">
                        <span class="kd-icon"><i data-lucide="mail"></i></span>
                    </div>
                    @error('email')<p class="kd-error">{{ $message }}</p>@enderror
                </div>

                <div class="kd-group">
                    <div class="kd-label-row">
                        <label class="kd-label" for="m-masuk-kata_sandi">Kata Sandi <span class="kd-req">*</span></label>
                        <a href="{{ route('mobile.lupa-password') }}" wire:navigate class="kd-label-link">Lupa sandi?</a>
                    </div>
                    <div class="kd-control" x-data="{ tampil: false }">
                        <input id="m-masuk-kata_sandi" type="password" name="kata_sandi" x-bind:type="tampil ? 'text' : 'password'" wire:model="kata_sandi" class="kd-input kd-input--password" placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="kd-icon kd-icon--button" @click="tampil = !tampil" aria-label="Tampilkan kata sandi">
                            <i data-lucide="eye"></i>
                        </button>
                    </div>
                    @error('kata_sandi')<p class="kd-error">{{ $message }}</p>@enderror
                </div>

                <label class="kd-consent">
                    <input type="checkbox" name="ingat_saya" value="1" wire:model="ingat_saya">
                    <span>Ingat sesi saya di perangkat ini.</span>
                </label>

                <div class="kd-actions">
                    <button type="submit" wire:target="login" wire:loading.attr="disabled" class="kd-btn-primary">
                        <span wire:loading.remove wire:target="login" class="flex items-center gap-2">
                            <span>Masuk</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </span>
                        <span wire:loading wire:target="login" class="flex items-center gap-2">
                            <span class="kd-spinner"></span>
                            <span>Memproses...</span>
                        </span>
                    </button>
                </div>
            </form>

            <p class="kd-bottom-switch">Belum memiliki akun?<a href="{{ route('mobile.daftar') }}" wire:navigate>Daftar Akun</a></p>

            @if($errors->has('email') && $errors->has('kata_sandi'))
                <div class="kd-errors">
                    <strong>Periksa kembali data berikut</strong>
                    <ul>
                        @foreach($errors->all() as $pesanError)
                            <li>{{ $pesanError }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <x-mobile.tabbar aktif="masuk" />
    </div>
