    {{-- Versi mobile dari /admin/daftar — desain mobile_kormi.html --}}
    <div class="kd-mobile min-h-screen">
        <div class="kd-header">
            <div class="kd-brand">
                <div class="kd-brand-icon">K</div>
                <span class="kd-brand-title">KORMI Kab. Bandung</span>
            </div>
            <p class="kd-brand-sub">Pendaftaran Akun CMS</p>
        </div>

        <div class="kd-sheet">
            <div class="kd-section-head">
                <div>
                    <h3>Daftar Akun</h3>
                    <p>Akun akan aktif setelah disetujui Admin KORMI.</p>
                </div>
                <span class="kd-badge">Akun</span>
            </div>

            @if(session()->has('error'))
                <div class="kd-notice kd-notice-rose">
                    <i data-lucide="alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="kd-notice kd-notice-amber">
                <i data-lucide="info"></i>
                <span>Pendaftaran ini untuk <strong>akun CMS pengelola</strong>. Ingin menjadi Duta Olahraga? <a href="{{ route('mobile.daftar-duta') }}" wire:navigate>Isi formulir pendaftaran duta</a>.</span>
            </div>

            <form wire:submit="daftar">
                <div class="kd-group">
                    <div class="kd-label-row">
                        <label class="kd-label" for="m-daftar-nama">Nama Lengkap <span class="kd-req">*</span></label>
                    </div>
                    <div class="kd-control">
                        <input id="m-daftar-nama" type="text" wire:model="nama_lengkap" class="kd-input" placeholder="Nama sesuai identitas" required autocomplete="name">
                        <span class="kd-icon"><i data-lucide="user"></i></span>
                    </div>
                    @error('nama_lengkap')<p class="kd-error">{{ $message }}</p>@enderror
                </div>

                <div class="kd-group">
                    <div class="kd-label-row">
                        <label class="kd-label" for="m-daftar-email">Alamat Email <span class="kd-req">*</span></label>
                    </div>
                    <div class="kd-control">
                        <input id="m-daftar-email" type="email" wire:model="email" class="kd-input" placeholder="nama@kormibdg.id" required autocomplete="email">
                        <span class="kd-icon"><i data-lucide="mail"></i></span>
                    </div>
                    @error('email')<p class="kd-error">{{ $message }}</p>@enderror
                </div>

                <div class="kd-group">
                    <div class="kd-label-row">
                        <label class="kd-label" for="m-daftar-telepon">Nomor WhatsApp</label>
                    </div>
                    <div class="kd-control">
                        <input id="m-daftar-telepon" type="tel" inputmode="tel" wire:model="nomor_telepon" class="kd-input" placeholder="08xxxxxxxxxx" autocomplete="tel">
                        <span class="kd-icon"><i data-lucide="phone"></i></span>
                    </div>
                    @error('nomor_telepon')<p class="kd-error">{{ $message }}</p>@enderror
                </div>

                <div class="kd-group">
                    <div class="kd-label-row">
                        <label class="kd-label" for="m-daftar-kata_sandi">Kata Sandi <span class="kd-req">*</span></label>
                    </div>
                    <div class="kd-control" x-data="{ tampil: false }">
                        <input id="m-daftar-kata_sandi" type="password" x-bind:type="tampil ? 'text' : 'password'" wire:model="kata_sandi" class="kd-input kd-input--password" placeholder="Minimal 6 karakter" required autocomplete="new-password">
                        <button type="button" class="kd-icon kd-icon--button" @click="tampil = !tampil" aria-label="Tampilkan kata sandi">
                            <i data-lucide="eye"></i>
                        </button>
                    </div>
                    @error('kata_sandi')<p class="kd-error">{{ $message }}</p>@enderror
                </div>

                <div class="kd-group">
                    <div class="kd-label-row">
                        <label class="kd-label" for="m-daftar-konfirmasi">Konfirmasi Kata Sandi <span class="kd-req">*</span></label>
                    </div>
                    <div class="kd-control" x-data="{ tampil: false }">
                        <input id="m-daftar-konfirmasi" type="password" x-bind:type="tampil ? 'text' : 'password'" wire:model="konfirmasi_kata_sandi" class="kd-input kd-input--password" placeholder="Ulangi kata sandi" required autocomplete="new-password">
                        <button type="button" class="kd-icon kd-icon--button" @click="tampil = !tampil" aria-label="Tampilkan kata sandi">
                            <i data-lucide="eye"></i>
                        </button>
                    </div>
                    @error('konfirmasi_kata_sandi')<p class="kd-error">{{ $message }}</p>@enderror
                </div>

                <label class="kd-consent">
                    <input type="checkbox" wire:model="setuju_syarat">
                    <span>Saya menyetujui syarat &amp; ketentuan penggunaan CMS KORMI.</span>
                </label>
                @error('setuju_syarat')<p class="kd-error kd-error--spaced">{{ $message }}</p>@enderror

                <div class="kd-actions">
                    <button type="submit" wire:target="daftar" wire:loading.attr="disabled" class="kd-btn-primary">
                        <span wire:loading.remove wire:target="daftar" class="flex items-center gap-2">
                            <span>Daftar Sekarang</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </span>
                        <span wire:loading wire:target="daftar" class="flex items-center gap-2">
                            <span class="kd-spinner"></span>
                            <span>Mendaftarkan...</span>
                        </span>
                    </button>
                </div>
            </form>

            <p class="kd-bottom-switch">Sudah memiliki akun?<a href="{{ route('mobile.login') }}" wire:navigate>Masuk</a></p>
        </div>

        <x-mobile.tabbar />
    </div>
