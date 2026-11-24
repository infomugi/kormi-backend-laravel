    {{-- Versi mobile dari /admin/lupa-password — desain mobile_kormi.html --}}
    <div class="kd-mobile min-h-screen">
        <div class="kd-header">
            <div class="kd-brand">
                <div class="kd-brand-icon">K</div>
                <span class="kd-brand-title">KORMI Kab. Bandung</span>
            </div>
            <p class="kd-brand-sub">Pemulihan Akun KORMI</p>
        </div>

        <div class="kd-sheet">
            @if($isSuccess)
                <div class="kd-success">
                    <div class="kd-success-check">
                        <i data-lucide="check" class="stroke-[3]"></i>
                    </div>
                    <span class="kd-success-tag">Kata Sandi Diperbarui</span>
                    <h2>Kata sandi berhasil diganti!</h2>
                    <p class="kd-success-text">
                        Silakan masuk kembali menggunakan <strong>kata sandi baru</strong> Anda untuk mengakses akun KORMI.
                    </p>

                    <div class="kd-success-actions">
                        <a href="{{ route('mobile.login') }}" wire:navigate class="kd-btn-primary">
                            <i data-lucide="log-in" class="w-4 h-4"></i>
                            <span>Masuk Sekarang</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="kd-section-head">
                    <div>
                        <h3>Lupa Kata Sandi</h3>
                        @if(! $isEmailVerified)
                            <p>Masukkan email terdaftar untuk verifikasi.</p>
                        @else
                            <p>Buat kata sandi baru untuk <strong>{{ $email }}</strong>.</p>
                        @endif
                    </div>
                    <span class="kd-badge">{{ $isEmailVerified ? 'Langkah 2' : 'Langkah 1' }}</span>
                </div>

                @if(session()->has('error'))
                    <div class="kd-notice kd-notice-rose">
                        <i data-lucide="alert-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if(! $isEmailVerified)
                    <form wire:submit="checkEmail">
                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-lupa-email">Alamat Email <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <input id="m-lupa-email" type="email" wire:model="email" class="kd-input" placeholder="nama@kormibdg.id" required autocomplete="email">
                                <span class="kd-icon"><i data-lucide="mail"></i></span>
                            </div>
                            @error('email')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <p class="kd-hint">Gunakan email yang terdaftar pada akun KORMI Anda.</p>

                        <div class="kd-actions">
                            <button type="submit" wire:target="checkEmail" wire:loading.attr="disabled" class="kd-btn-primary">
                                <span wire:loading.remove wire:target="checkEmail" class="flex items-center gap-2">
                                    <span>Verifikasi Email</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </span>
                                <span wire:loading wire:target="checkEmail" class="flex items-center gap-2">
                                    <span class="kd-spinner"></span>
                                    <span>Memeriksa...</span>
                                </span>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="kd-notice kd-notice-lime">
                        <i data-lucide="shield-check"></i>
                        <span>Email <strong>{{ $email }}</strong> terverifikasi. Buat kata sandi baru Anda.</span>
                    </div>

                    <form wire:submit="resetPassword">
                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-lupa-sandi-baru">Kata Sandi Baru <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control" x-data="{ tampil: false }">
                                <input id="m-lupa-sandi-baru" type="password" x-bind:type="tampil ? 'text' : 'password'" wire:model="kata_sandi_baru" class="kd-input kd-input--password" placeholder="Minimal 6 karakter" autocomplete="new-password" required>
                                <button type="button" class="kd-icon kd-icon--button" @click="tampil = !tampil" aria-label="Tampilkan kata sandi">
                                    <i data-lucide="eye"></i>
                                </button>
                            </div>
                            @error('kata_sandi_baru')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-lupa-konfirmasi">Konfirmasi Kata Sandi <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control" x-data="{ tampil: false }">
                                <input id="m-lupa-konfirmasi" type="password" x-bind:type="tampil ? 'text' : 'password'" wire:model="konfirmasi_kata_sandi" class="kd-input kd-input--password" placeholder="Ulangi kata sandi baru" autocomplete="new-password" required>
                                <button type="button" class="kd-icon kd-icon--button" @click="tampil = !tampil" aria-label="Tampilkan kata sandi">
                                    <i data-lucide="eye"></i>
                                </button>
                            </div>
                            @error('konfirmasi_kata_sandi')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-actions">
                            <button type="button" wire:click="resetState" wire:loading.attr="disabled" class="kd-btn-ghost">
                                <span>Ganti Email</span>
                            </button>
                            <button type="submit" wire:target="resetPassword" wire:loading.attr="disabled" class="kd-btn-primary">
                                <span wire:loading.remove wire:target="resetPassword" class="flex items-center gap-2">
                                    <i data-lucide="save" class="w-4 h-4"></i>
                                    <span>Simpan</span>
                                </span>
                                <span wire:loading wire:target="resetPassword" class="flex items-center gap-2">
                                    <span class="kd-spinner"></span>
                                    <span>Menyimpan...</span>
                                </span>
                            </button>
                        </div>
                    </form>
                @endif

                <p class="kd-bottom-switch">Kembali ke<a href="{{ route('mobile.login') }}" wire:navigate>halaman masuk</a></p>
            @endif
        </div>

        <x-mobile.tabbar aktif="masuk" />
    </div>
