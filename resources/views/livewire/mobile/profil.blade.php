{{-- Halaman Profil mobile — desain mobile_kormi.html --}}
<div class="kd-mobile min-h-screen">
    <div class="kd-header">
        <div class="kd-brand">
            <div class="kd-brand-icon">K</div>
            <span class="kd-brand-title">KORMI Kab. Bandung</span>
        </div>
        <p class="kd-brand-sub">Profil Saya</p>
    </div>

    <div class="kd-sheet">
        <div class="kd-section-head">
            <div>
                <h3>Akun Saya</h3>
                <p>Informasi akun dan keanggotaan Anda di KORMI Kabupaten Bandung.</p>
            </div>
            <span class="kd-badge">{{ $badgePeran }}</span>
        </div>

        <div class="kd-account" style="display: flex; align-items: center; gap: 12px;">
            <span class="kd-duta-avatar" style="width: 52px; height: 52px; font-size: 17px;">
                @if($user->foto_profil_url)
                    <img src="{{ $user->foto_profil_url }}" alt="{{ $user->nama_lengkap }}" loading="lazy">
                @else
                    {{ strtoupper(\Illuminate\Support\Str::substr($user->nama_lengkap, 0, 2)) }}
                @endif
            </span>
            <div style="min-width: 0; flex: 1;">
                <strong style="display: block; font-size: 13px; font-weight: 800; line-height: 1.35;">{{ $user->nama_lengkap }}</strong>
                <div class="kd-item-meta" style="text-transform: none; margin-top: 4px;">{{ $user->email }}</div>
                <div style="display: flex; flex-wrap: wrap; gap: 5px; margin-top: 6px;">
                    <span class="kd-chip">{{ $roleLabel }}</span>
                    @if($user->duta)
                        <span class="kd-chip kd-chip--dark">Duta Olahraga</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="kd-subhead">
            <h4>Detail Akun</h4>
            <span class="kd-chip {{ $user->status_aktif ? 'kd-chip--dark' : 'kd-chip--danger' }}">{{ $user->status_aktif ? 'Aktif' : 'Nonaktif' }}</span>
        </div>

        <div class="kd-item">
            <span class="kd-module-icon"><i data-lucide="mail"></i></span>
            <span class="kd-item-body">
                <span class="kd-item-title">{{ $user->email }}</span>
                <span class="kd-item-meta" style="text-transform: none;">Email akun</span>
            </span>
        </div>

        <div class="kd-item">
            <span class="kd-module-icon"><i data-lucide="phone"></i></span>
            <span class="kd-item-body">
                <span class="kd-item-title">{{ $user->nomor_telepon ?: 'Belum diisi' }}</span>
                <span class="kd-item-meta" style="text-transform: none;">Nomor telepon</span>
            </span>
        </div>

        @if($user->kecamatan || $user->desa)
            <div class="kd-item">
                <span class="kd-module-icon"><i data-lucide="map-pin"></i></span>
                <span class="kd-item-body">
                    <span class="kd-item-title">
                        {{ collect([$user->desa?->nama_desa_kelurahan, $user->kecamatan?->nama_kecamatan])->filter()->implode(', ') }}
                    </span>
                    <span class="kd-item-meta" style="text-transform: none;">Wilayah</span>
                </span>
            </div>
        @endif

        @if($user->pekerjaan)
            <div class="kd-item">
                <span class="kd-module-icon"><i data-lucide="briefcase"></i></span>
                <span class="kd-item-body">
                    <span class="kd-item-title">{{ $user->pekerjaan }}</span>
                    <span class="kd-item-meta" style="text-transform: none;">Pekerjaan</span>
                </span>
            </div>
        @endif

        <div class="kd-item">
            <span class="kd-module-icon"><i data-lucide="calendar-days"></i></span>
            <span class="kd-item-body">
                <span class="kd-item-title">{{ $user->dibuat_pada ? \Carbon\Carbon::parse($user->dibuat_pada)->translatedFormat('d M Y') : '-' }}</span>
                <span class="kd-item-meta" style="text-transform: none;">Bergabung sejak</span>
            </span>
        </div>

        <div class="kd-item">
            <span class="kd-module-icon"><i data-lucide="clock"></i></span>
            <span class="kd-item-body">
                <span class="kd-item-title">{{ $user->terakhir_masuk ? \Carbon\Carbon::parse($user->terakhir_masuk)->translatedFormat('d M Y H:i') : 'Belum pernah' }}</span>
                <span class="kd-item-meta" style="text-transform: none;">Terakhir masuk</span>
            </span>
        </div>

        <div class="kd-subhead" style="margin-top: 22px;">
            <h4>Ubah Data Akun</h4>
        </div>

        @if(session('pesan_akun'))
            <div class="kd-notice kd-notice-lime">
                <i data-lucide="check-circle"></i>
                <span>{{ session('pesan_akun') }}</span>
            </div>
        @endif

        <form wire:submit="simpanDataAkun">
            <div class="kd-group">
                <div class="kd-label-row">
                    <label class="kd-label" for="m-profil-nama">Nama Lengkap <span class="kd-req">*</span></label>
                </div>
                <div class="kd-control">
                    <input type="text" id="m-profil-nama" wire:model="nama_lengkap" class="kd-input" placeholder="Nama lengkap" autocomplete="name">
                </div>
                @error('nama_lengkap')<p class="kd-error">{{ $message }}</p>@enderror
            </div>

            <div class="kd-group">
                <div class="kd-label-row">
                    <label class="kd-label" for="m-profil-telepon">Nomor Telepon <span class="kd-optional">Opsional</span></label>
                </div>
                <div class="kd-control">
                    <input type="tel" id="m-profil-telepon" wire:model="nomor_telepon" class="kd-input" placeholder="08xxxxxxxxxx" autocomplete="tel">
                </div>
                @error('nomor_telepon')<p class="kd-error">{{ $message }}</p>@enderror
            </div>

            <div class="kd-group">
                <div class="kd-label-row">
                    <span class="kd-label">Foto Profil <span class="kd-optional">Opsional</span></span>
                </div>

                @if($foto_profil_baru)
                    @php $ekstensiFotoProfil = strtolower($foto_profil_baru->getClientOriginalExtension()); @endphp
                    @if(in_array($ekstensiFotoProfil, ['jpg', 'jpeg', 'png', 'webp']))
                        <div class="kd-photo-preview">
                            <img src="{{ $foto_profil_baru->temporaryUrl() }}" alt="Pratinjau foto profil baru">
                        </div>
                    @else
                        <div class="kd-file-chip">
                            <i data-lucide="file" class="w-4 h-4"></i>
                            <span>{{ $foto_profil_baru->getClientOriginalName() }}</span>
                        </div>
                    @endif
                @elseif($user->foto_profil_url)
                    <div class="kd-photo-preview">
                        <img src="{{ $user->foto_profil_url }}" alt="Foto profil saat ini">
                    </div>
                @endif

                <label class="kd-upload">
                    <i data-lucide="image-plus"></i>
                    <span class="kd-upload-title">{{ $foto_profil_baru ? 'Ganti Foto Profil' : 'Pilih Foto Profil' }}</span>
                    <span class="kd-upload-sub">JPG, JPEG, PNG, WEBP (Maks. 5 MB)</span>
                    <input type="file" id="m-profil-foto" wire:model="foto_profil_baru" accept="image/jpeg,image/png,image/webp" class="sr-only">
                </label>

                <div wire:loading wire:target="foto_profil_baru" class="kd-upload-status">
                    <span class="kd-spinner kd-spinner--dark"></span>
                    <span>Mengunggah foto...</span>
                </div>
                @error('foto_profil_baru')<p class="kd-error">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="kd-btn-primary" style="width: 100%;" wire:loading.attr="disabled" wire:target="simpanDataAkun, foto_profil_baru">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span wire:loading.remove wire:target="simpanDataAkun">Simpan Perubahan</span>
                <span wire:loading wire:target="simpanDataAkun">Menyimpan...</span>
            </button>
        </form>

        <div class="kd-subhead" style="margin-top: 22px;">
            <h4>Ganti Kata Sandi</h4>
        </div>

        @if(session('pesan_sandi'))
            <div class="kd-notice kd-notice-lime">
                <i data-lucide="check-circle"></i>
                <span>{{ session('pesan_sandi') }}</span>
            </div>
        @endif

        <form wire:submit="gantiKataSandi">
            <div class="kd-group">
                <div class="kd-label-row">
                    <label class="kd-label" for="m-profil-sandi-lama">Kata Sandi Saat Ini <span class="kd-req">*</span></label>
                </div>
                <div class="kd-control">
                    <input type="password" id="m-profil-sandi-lama" wire:model="kata_sandi_lama" class="kd-input" placeholder="Kata sandi saat ini" autocomplete="current-password">
                </div>
                @error('kata_sandi_lama')<p class="kd-error">{{ $message }}</p>@enderror
            </div>

            <div class="kd-group">
                <div class="kd-label-row">
                    <label class="kd-label" for="m-profil-sandi-baru">Kata Sandi Baru <span class="kd-req">*</span></label>
                </div>
                <div class="kd-control">
                    <input type="password" id="m-profil-sandi-baru" wire:model="kata_sandi_baru" class="kd-input" placeholder="Minimal 8 karakter" autocomplete="new-password">
                </div>
                @error('kata_sandi_baru')<p class="kd-error">{{ $message }}</p>@enderror
            </div>

            <div class="kd-group">
                <div class="kd-label-row">
                    <label class="kd-label" for="m-profil-sandi-konfirmasi">Konfirmasi Kata Sandi Baru <span class="kd-req">*</span></label>
                </div>
                <div class="kd-control">
                    <input type="password" id="m-profil-sandi-konfirmasi" wire:model="konfirmasi_kata_sandi" class="kd-input" placeholder="Ulangi kata sandi baru" autocomplete="new-password">
                </div>
                @error('konfirmasi_kata_sandi')<p class="kd-error">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="kd-btn-ghost" style="width: 100%;" wire:loading.attr="disabled" wire:target="gantiKataSandi">
                <i data-lucide="key-round" class="w-4 h-4"></i>
                <span wire:loading.remove wire:target="gantiKataSandi">Perbarui Kata Sandi</span>
                <span wire:loading wire:target="gantiKataSandi">Memproses...</span>
            </button>
        </form>

        <div class="kd-success-actions" style="margin-top: 18px;">
            @if($isAdmin)
                <a href="{{ route('admin.dashboard') }}" class="kd-btn-primary">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Buka Dashboard CMS</span>
                </a>
            @else
                <a href="{{ route('mobile.layanan') }}" wire:navigate class="kd-btn-primary">
                    <i data-lucide="blocks" class="w-4 h-4"></i>
                    <span>Lihat Layanan Saya</span>
                </a>
            @endif

            <form method="POST" action="{{ route('admin.keluar') }}">
                @csrf
                <button type="submit" class="kd-btn-ghost" style="width: 100%;">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Keluar dari Akun</span>
                </button>
            </form>
        </div>

        <p class="kd-footnote">Masuk sebagai {{ $user->email }}</p>
    </div>

    <x-mobile.tabbar aktif="profil" />
</div>
