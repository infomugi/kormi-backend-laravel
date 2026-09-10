<div style="min-height: 100vh; width: 100%; display: flex; flex-direction: row; background-color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
    
    <!-- LEFT PANEL: DEEP VIBRANT ROYAL BLUE WITH LOW POLY MESH AND MOCKUP PREVIEW (MATCHING DESIGN SYSTEM) -->
    <div style="width: 50%; background: linear-gradient(135deg, #1e4ed8 0%, #2563eb 50%, #1d40b0 100%); position: relative; padding: 48px 56px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; box-sizing: border-box;">
        
        <!-- POLYGONAL / GEOMETRIC FACET OVERLAYS -->
        <div style="position: absolute; inset: 0; pointer-events: none; opacity: 0.35;">
            <svg style="width: 100%; height: 100%;" viewBox="0 0 1000 1200" preserveAspectRatio="none" fill="none">
                <polygon points="0,0 1000,0 520,680" fill="url(#poly-grad-reg-1)" />
                <polygon points="1000,0 1000,1200 420,750" fill="url(#poly-grad-reg-2)" />
                <polygon points="0,400 700,1200 0,1200" fill="url(#poly-grad-reg-3)" />
                <polygon points="150,150 850,350 480,880" fill="url(#poly-grad-reg-1)" opacity="0.5"/>
                <defs>
                    <linearGradient id="poly-grad-reg-1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0.45" />
                        <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.05" />
                    </linearGradient>
                    <linearGradient id="poly-grad-reg-2" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#93c5fd" stop-opacity="0.4" />
                        <stop offset="100%" stop-color="#1e3a8a" stop-opacity="0.1" />
                    </linearGradient>
                    <linearGradient id="poly-grad-reg-3" x1="0%" y1="100%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="#1d4ed8" stop-opacity="0.05" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- TOP LOGO / ICON -->
        <div style="position: relative; z-index: 10;">
            <a href="{{ route('beranda') }}" wire:navigate style="display: inline-flex; align-items: center; gap: 14px; text-decoration: none;">
                <div style="width: 46px; height: 46px; border-radius: 14px; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3); display: flex; align-items: center; justify-content: center; padding: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
                    <img src="{{ asset('assets/image/logo-kormi.png') }}" style="width: 100%; height: 100%; object-fit: contain; filter: brightness(0) invert(1);" alt="KORMI">
                </div>
                <div style="color: #ffffff;">
                    <span style="display: block; font-weight: 900; font-size: 17px; letter-spacing: -0.01em; line-height: 1;">KORMI CMS</span>
                    <span style="display: block; font-size: 10px; font-weight: 700; letter-spacing: 0.15em; color: #bfdbfe; text-transform: uppercase; margin-top: 4px;">KABUPATEN BANDUNG</span>
                </div>
            </a>
        </div>

        <!-- HERO HEADLINE & TEXT -->
        <div style="position: relative; z-index: 10; margin-top: auto; margin-bottom: 24px; max-width: 480px;">
            <h1 style="font-size: 34px; font-weight: 800; color: #ffffff; letter-spacing: -0.02em; line-height: 1.2; margin: 0 0 12px 0;">
                Registrasi Akun Pengelola
            </h1>
            <p style="font-size: 14px; color: rgba(255, 255, 255, 0.88); line-height: 1.6; margin: 0 0 20px 0; font-weight: 400;">
                Daftarkan akun administrator untuk mengelola berita, galeri, data inorga, rekap medali, dan koordinasi 31 koordinator kecamatan se-Kabupaten Bandung.
            </p>

            <!-- BENEFIT PILLS -->
            <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 8px; color: #ffffff; font-size: 13px; font-weight: 600;">
                    <span style="width: 20px; height: 20px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 11px;">✓</span>
                    Akses Dashboard CMS Terintegrasi
                </div>
                <div style="display: flex; align-items: center; gap: 8px; color: #ffffff; font-size: 13px; font-weight: 600;">
                    <span style="width: 20px; height: 20px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 11px;">✓</span>
                    Manajemen Data Inorga & Klasemen FORKAB
                </div>
            </div>
        </div>

        <!-- BOTTOM FOOTER -->
        <div style="position: relative; z-index: 10; font-size: 12px; color: rgba(255, 255, 255, 0.6);">
            &copy; {{ date('Y') }} KORMI Kabupaten Bandung. All rights reserved.
        </div>
    </div>

    <!-- RIGHT PANEL: REGISTRATION FORM -->
    <div style="width: 50%; display: flex; align-items: center; justify-content: center; padding: 48px; background-color: #ffffff; box-sizing: border-box; overflow-y: auto; max-height: 100vh;">
        <div style="width: 100%; max-width: 440px;">
            
            <!-- HEADER -->
            <div style="margin-bottom: 24px;">
                <h2 style="font-size: 30px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; letter-spacing: -0.02em;">Daftar Akun Baru</h2>
                <p style="font-size: 14px; color: #64748b; margin: 0;">Lengkapi data diri Anda untuk membuat akun CMS</p>
            </div>

            <!-- ERROR ALERT BANNER -->
            @if ($errors->any())
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px; animation: fadeInDown 0.3s ease-out; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);">
                    <div style="color: #ef4444; margin-top: 1px; flex-shrink: 0;">
                        <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" stroke="currentColor"/>
                            <line x1="12" y1="8" x2="12" y2="12" stroke="currentColor"/>
                            <line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor"/>
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <span style="display: block; font-size: 13px; font-weight: 700; color: #991b1b;">
                            Pendaftaran Belum Berhasil
                        </span>
                        <ul style="margin: 3px 0 0 0; padding-left: 16px; font-size: 12px; color: #b91c1c; line-height: 1.5;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- FORM -->
            <form wire:submit="daftar" style="display: flex; flex-direction: column; gap: 16px;">
                
                <!-- Nama Lengkap -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: #475569;">
                        Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        wire:model="nama_lengkap" 
                        placeholder="Contoh: Budi Santoso" 
                        required
                        style="width: 100%; padding: 12px 16px; background-color: #ffffff; border: 1px solid {{ $errors->has('nama_lengkap') ? '#ef4444' : '#cbd5e1' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 4px rgba(37, 99, 235, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('nama_lengkap') ? '#ef4444' : '#cbd5e1' }}'; this.style.boxShadow='none';"
                    >
                    @error('nama_lengkap') 
                        <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Email address -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: #475569;">
                        Alamat Email
                    </label>
                    <input 
                        type="email" 
                        wire:model="email" 
                        placeholder="nama@kormibdg.id" 
                        required
                        autocomplete="email"
                        style="width: 100%; padding: 12px 16px; background-color: #ffffff; border: 1px solid {{ $errors->has('email') ? '#ef4444' : '#cbd5e1' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 4px rgba(37, 99, 235, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#cbd5e1' }}'; this.style.boxShadow='none';"
                    >
                    @error('email') 
                        <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Nomor Telepon / WhatsApp -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: #475569;">
                        Nomor WhatsApp / HP (Opsional)
                    </label>
                    <input 
                        type="tel" 
                        wire:model="nomor_telepon" 
                        placeholder="08123456789" 
                        style="width: 100%; padding: 12px 16px; background-color: #ffffff; border: 1px solid {{ $errors->has('nomor_telepon') ? '#ef4444' : '#cbd5e1' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 4px rgba(37, 99, 235, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('nomor_telepon') ? '#ef4444' : '#cbd5e1' }}'; this.style.boxShadow='none';"
                    >
                    @error('nomor_telepon') 
                        <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Password -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: #475569;">
                        Kata Sandi
                    </label>
                    <div style="position: relative; width: 100%;">
                        <input 
                            type="{{ $showPassword ? 'text' : 'password' }}" 
                            wire:model="kata_sandi" 
                            placeholder="Minimal 6 karakter" 
                            required
                            autocomplete="new-password"
                            style="width: 100%; padding: 12px 44px 12px 16px; background-color: #ffffff; border: 1px solid {{ $errors->has('kata_sandi') ? '#ef4444' : '#cbd5e1' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 4px rgba(37, 99, 235, 0.1)';"
                            onblur="this.style.borderColor='{{ $errors->has('kata_sandi') ? '#ef4444' : '#cbd5e1' }}'; this.style.boxShadow='none';"
                        >
                        <button 
                            type="button" 
                            wire:click="toggleShowPassword" 
                            style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; color: #94a3b8; cursor: pointer; display: flex; align-items: center;"
                        >
                            @if($showPassword)
                                <i data-lucide="eye-off" style="width: 18px; height: 18px;"></i>
                            @else
                                <i data-lucide="eye" style="width: 18px; height: 18px;"></i>
                            @endif
                        </button>
                    </div>
                    @error('kata_sandi') 
                        <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: #475569;">
                        Ulangi Kata Sandi
                    </label>
                    <input 
                        type="{{ $showPassword ? 'text' : 'password' }}" 
                        wire:model="konfirmasi_kata_sandi" 
                        placeholder="Ketik ulang kata sandi" 
                        required
                        autocomplete="new-password"
                        style="width: 100%; padding: 12px 16px; background-color: #ffffff; border: 1px solid {{ $errors->has('konfirmasi_kata_sandi') ? '#ef4444' : '#cbd5e1' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 4px rgba(37, 99, 235, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('konfirmasi_kata_sandi') ? '#ef4444' : '#cbd5e1' }}'; this.style.boxShadow='none';"
                    >
                    @error('konfirmasi_kata_sandi') 
                        <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Syarat & Ketentuan Checkbox -->
                <div style="display: flex; align-items: flex-start; gap: 8px; margin-top: 4px;">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        wire:model="setuju_syarat" 
                        style="width: 16px; height: 16px; margin-top: 2px; border-radius: 4px; border: 1px solid #cbd5e1; accent-color: #2563eb; cursor: pointer;"
                    >
                    <label for="terms" style="font-size: 12px; font-weight: 500; color: #64748b; cursor: pointer; user-select: none; line-height: 1.4;">
                        Saya menyetujui <span style="color: #2563eb; font-weight: 600;">Ketentuan Layanan</span> dan <span style="color: #2563eb; font-weight: 600;">Kebijakan Privasi</span> KORMI Kab. Bandung.
                    </label>
                </div>
                @error('setuju_syarat') 
                    <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                @enderror

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    wire:target="daftar"
                    wire:loading.attr="disabled"
                    style="width: 100%; padding: 14px 20px; margin-top: 8px; background-color: #2563eb; color: #ffffff; border: none; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4); transition: background-color 0.2s;"
                    onmouseover="this.style.backgroundColor='#1d4ed8';"
                    onmouseout="this.style.backgroundColor='#2563eb';"
                >
                    <span wire:loading.remove wire:target="daftar">Daftar Akun</span>
                    <span wire:loading.flex wire:target="daftar" style="align-items: center; justify-content: center; gap: 8px;">
                        <svg class="animate-spin-custom" style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24">
                            <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path style="opacity: 0.85;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Mendaftarkan...</span>
                    </span>
                </button>
            </form>

            <!-- Already have an account? Sign in -->
            <div style="text-align: center; margin-top: 24px; font-size: 13px; color: #64748b; font-weight: 500;">
                <span>Sudah memiliki akun?</span>
                <a href="{{ route('login') }}" wire:navigate style="margin-left: 4px; font-size: 13px; font-weight: 700; color: #2563eb; text-decoration: none;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
                    Masuk Sekarang
                </a>
            </div>

        </div>
    </div>

</div>
