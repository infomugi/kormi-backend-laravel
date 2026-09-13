<div style="min-height: 100vh; width: 100%; display: flex; flex-direction: row; background-color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
    
    <!-- LEFT PANEL: SIGNATURE KORMI EMERALD & FORESTRY GREEN (MATCHING DESIGN SYSTEM) -->
    <div style="width: 50%; background: linear-gradient(145deg, #064e3b 0%, #047857 45%, #059669 80%, #0f766e 100%); position: relative; padding: 48px 56px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; box-sizing: border-box;">
        
        <!-- POLYGONAL / GEOMETRIC FACET OVERLAYS -->
        <div style="position: absolute; inset: 0; pointer-events: none; opacity: 0.38;">
            <svg style="width: 100%; height: 100%;" viewBox="0 0 1000 1200" preserveAspectRatio="none" fill="none">
                <polygon points="0,0 1000,0 520,680" fill="url(#poly-grad-reg-1)" />
                <polygon points="1000,0 1000,1200 420,750" fill="url(#poly-grad-reg-2)" />
                <polygon points="0,400 700,1200 0,1200" fill="url(#poly-grad-reg-3)" />
                <polygon points="150,150 850,350 480,880" fill="url(#poly-grad-reg-1)" opacity="0.45"/>
                <defs>
                    <linearGradient id="poly-grad-reg-1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#8ed500" stop-opacity="0.45" />
                        <stop offset="100%" stop-color="#10b981" stop-opacity="0.05" />
                    </linearGradient>
                    <linearGradient id="poly-grad-reg-2" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#34d399" stop-opacity="0.35" />
                        <stop offset="100%" stop-color="#022c22" stop-opacity="0.2" />
                    </linearGradient>
                    <linearGradient id="poly-grad-reg-3" x1="0%" y1="100%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#a7f3d0" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="#059669" stop-opacity="0.05" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- AMBIENT GLOW -->
        <div style="position: absolute; top: -10%; right: -10%; width: 450px; height: 450px; background: radial-gradient(circle, rgba(142, 213, 0, 0.25) 0%, rgba(5, 150, 105, 0) 70%); border-radius: 50%; pointer-events: none;"></div>

        <!-- TOP LOGO / ICON -->
        <div style="position: relative; z-index: 10;">
            <a href="{{ route('beranda') }}" wire:navigate style="display: inline-flex; align-items: center; gap: 14px; text-decoration: none;">
                <div style="width: 50px; height: 50px; border-radius: 16px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border: 1.5px solid rgba(255, 255, 255, 0.8); display: flex; align-items: center; justify-content: center; padding: 7px; box-shadow: 0 12px 28px rgba(2, 44, 34, 0.35);">
                    <img src="{{ asset('assets/image/logo-kormi.png') }}" style="width: 100%; height: 100%; object-fit: contain;" alt="KORMI">
                </div>
                <div style="color: #ffffff;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-weight: 900; font-size: 19px; letter-spacing: -0.02em; line-height: 1;">KORMI CMS</span>
                        <span style="font-size: 9px; font-weight: 800; background: linear-gradient(90deg, #8ed500, #34d399); color: #022c22; padding: 2px 7px; border-radius: 999px; letter-spacing: 0.08em; text-transform: uppercase;">BEDAS</span>
                    </div>
                    <span style="display: block; font-size: 11px; font-weight: 700; letter-spacing: 0.16em; color: #a7f3d0; text-transform: uppercase; margin-top: 5px;">KABUPATEN BANDUNG</span>
                </div>
            </a>
        </div>

        <!-- HERO HEADLINE & TEXT -->
        <div style="position: relative; z-index: 10; margin-top: auto; margin-bottom: 24px; max-width: 480px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 999px; background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.25); margin-bottom: 16px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #8ed500; display: inline-block; box-shadow: 0 0 10px #8ed500;"></span>
                <span style="font-size: 11px; font-weight: 700; color: #f0fdf4; letter-spacing: 0.05em; text-transform: uppercase;">Akses Administrator & Pengurus</span>
            </div>

            <h1 style="font-size: 34px; font-weight: 900; color: #ffffff; letter-spacing: -0.03em; line-height: 1.25; margin: 0 0 14px 0;">
                Registrasi Akun Pengelola
            </h1>
            <p style="font-size: 14px; color: rgba(240, 253, 244, 0.9); line-height: 1.65; margin: 0 0 20px 0; font-weight: 400;">
                Daftarkan akun administrator untuk mengelola berita, galeri, data inorga, rekap medali, dan koordinasi 31 koordinator kecamatan se-Kabupaten Bandung.
            </p>

            <!-- BENEFIT PILLS -->
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 10px; color: #ffffff; font-size: 13px; font-weight: 600;">
                    <span style="width: 22px; height: 22px; border-radius: 50%; background: #8ed500; color: #022c22; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 900;">✓</span>
                    Akses Dashboard CMS Terintegrasi
                </div>
                <div style="display: flex; align-items: center; gap: 10px; color: #ffffff; font-size: 13px; font-weight: 600;">
                    <span style="width: 22px; height: 22px; border-radius: 50%; background: #8ed500; color: #022c22; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 900;">✓</span>
                    Manajemen Data Inorga & Klasemen FORKAB
                </div>
                <div style="display: flex; align-items: center; gap: 10px; color: #ffffff; font-size: 13px; font-weight: 600;">
                    <span style="width: 22px; height: 22px; border-radius: 50%; background: #8ed500; color: #022c22; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 900;">✓</span>
                    Verifikasi SK, Galeri, dan Pelatihan SDI
                </div>
            </div>
        </div>

        <!-- BOTTOM FOOTER -->
        <div style="position: relative; z-index: 10; font-size: 12px; color: rgba(255, 255, 255, 0.75);">
            &copy; {{ date('Y') }} KORMI Kabupaten Bandung. All rights reserved.
        </div>
    </div>

    <!-- RIGHT PANEL: REGISTRATION FORM -->
    <div style="width: 50%; display: flex; align-items: center; justify-content: center; padding: 48px; background-color: #ffffff; box-sizing: border-box; overflow-y: auto; max-height: 100vh;">
        <div style="width: 100%; max-width: 440px;">
            
            <!-- HEADER -->
            <div style="margin-bottom: 24px;">
                <div style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 999px; background-color: #ecfdf5; border: 1px solid #a7f3d0; margin-bottom: 12px;">
                    <span style="font-size: 11px; font-weight: 800; color: #047857; text-transform: uppercase; letter-spacing: 0.05em;">Pendaftaran Pengguna</span>
                </div>
                <h2 style="font-size: 30px; font-weight: 900; color: #0f172a; margin: 0 0 6px 0; letter-spacing: -0.02em;">Daftar Akun Baru</h2>
                <p style="font-size: 13px; color: #64748b; margin: 0;">Lengkapi data diri Anda untuk membuat akun CMS</p>
            </div>

            <!-- ERROR ALERT BANNER -->
            @if ($errors->any())
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px; animation: fadeInDown 0.3s ease-out; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);">
                    <div style="color: #ef4444; margin-top: 1px; flex-shrink: 0;">
                        <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
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
                    <label style="font-size: 13px; font-weight: 600; color: #334155;">
                        Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        wire:model="nama_lengkap" 
                        placeholder="Contoh: H. Agus Kurnia, S.Pd" 
                        required
                        style="width: 100%; padding: 12px 16px; background-color: #ffffff; border: 1.5px solid {{ $errors->has('nama_lengkap') ? '#ef4444' : '#e2e8f0' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#059669'; this.style.boxShadow='0 0 0 4px rgba(5, 150, 105, 0.12)';"
                        onblur="this.style.borderColor='{{ $errors->has('nama_lengkap') ? '#ef4444' : '#e2e8f0' }}'; this.style.boxShadow='none';"
                    >
                    @error('nama_lengkap') 
                        <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Email address -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: #334155;">
                        Alamat Email
                    </label>
                    <input 
                        type="email" 
                        wire:model="email" 
                        placeholder="nama@kormibdg.id" 
                        required
                        style="width: 100%; padding: 12px 16px; background-color: #ffffff; border: 1.5px solid {{ $errors->has('email') ? '#ef4444' : '#e2e8f0' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#059669'; this.style.boxShadow='0 0 0 4px rgba(5, 150, 105, 0.12)';"
                        onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#e2e8f0' }}'; this.style.boxShadow='none';"
                    >
                    @error('email') 
                        <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Nomor Telepon / WhatsApp -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: #334155;">
                        Nomor WhatsApp / HP (Opsional)
                    </label>
                    <input 
                        type="tel" 
                        wire:model="nomor_telepon" 
                        placeholder="contoh: 081234567890" 
                        style="width: 100%; padding: 12px 16px; background-color: #ffffff; border: 1.5px solid {{ $errors->has('nomor_telepon') ? '#ef4444' : '#e2e8f0' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#059669'; this.style.boxShadow='0 0 0 4px rgba(5, 150, 105, 0.12)';"
                        onblur="this.style.borderColor='{{ $errors->has('nomor_telepon') ? '#ef4444' : '#e2e8f0' }}'; this.style.boxShadow='none';"
                    >
                    @error('nomor_telepon') 
                        <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Password -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: #334155;">
                        Kata Sandi
                    </label>
                    <div style="position: relative; width: 100%;">
                        <input 
                            type="{{ $showPassword ? 'text' : 'password' }}" 
                            wire:model="kata_sandi" 
                            placeholder="Minimal 6 karakter" 
                            required
                            autocomplete="new-password"
                            style="width: 100%; padding: 12px 44px 12px 16px; background-color: #ffffff; border: 1.5px solid {{ $errors->has('kata_sandi') ? '#ef4444' : '#e2e8f0' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#059669'; this.style.boxShadow='0 0 0 4px rgba(5, 150, 105, 0.12)';"
                            onblur="this.style.borderColor='{{ $errors->has('kata_sandi') ? '#ef4444' : '#e2e8f0' }}'; this.style.boxShadow='none';"
                        >
                        <button 
                            type="button" 
                            wire:click="toggleShowPassword" 
                            style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; color: #94a3b8; cursor: pointer; display: flex; align-items: center;"
                        >
                            @if($showPassword)
                                <i data-lucide="eye-off" style="width: 18px; height: 18px; color: #059669;"></i>
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
                    <label style="font-size: 13px; font-weight: 600; color: #334155;">
                        Ulangi Kata Sandi
                    </label>
                    <input 
                        type="{{ $showPassword ? 'text' : 'password' }}" 
                        wire:model="konfirmasi_kata_sandi" 
                        placeholder="Ketik ulang kata sandi" 
                        required
                        autocomplete="new-password"
                        style="width: 100%; padding: 12px 16px; background-color: #ffffff; border: 1.5px solid {{ $errors->has('konfirmasi_kata_sandi') ? '#ef4444' : '#e2e8f0' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#059669'; this.style.boxShadow='0 0 0 4px rgba(5, 150, 105, 0.12)';"
                        onblur="this.style.borderColor='{{ $errors->has('konfirmasi_kata_sandi') ? '#ef4444' : '#e2e8f0' }}'; this.style.boxShadow='none';"
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
                        style="width: 17px; height: 17px; margin-top: 2px; border-radius: 5px; border: 1px solid #cbd5e1; accent-color: #059669; cursor: pointer;"
                    >
                    <label for="terms" style="font-size: 12px; font-weight: 500; color: #64748b; cursor: pointer; user-select: none; line-height: 1.4;">
                        Saya menyetujui <span style="color: #059669; font-weight: 700;">Ketentuan Layanan</span> dan <span style="color: #059669; font-weight: 700;">Kebijakan Privasi</span> KORMI Kab. Bandung.
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
                    style="width: 100%; padding: 14px 20px; margin-top: 8px; background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff; border: none; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 22px -4px rgba(5, 150, 105, 0.45); transition: all 0.2s;"
                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 14px 26px -4px rgba(5, 150, 105, 0.55)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 22px -4px rgba(5, 150, 105, 0.45)';"
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
                <a href="{{ route('login') }}" wire:navigate style="margin-left: 4px; font-size: 13px; font-weight: 800; color: #059669; text-decoration: none;" onmouseover="this.style.textDecoration='underline'; this.style.color='#047857';" onmouseout="this.style.textDecoration='none'; this.style.color='#059669';">
                    Masuk Sekarang
                </a>
            </div>

        </div>
    </div>

</div>
