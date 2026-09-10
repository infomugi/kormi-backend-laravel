<div style="min-height: 100vh; width: 100%; display: flex; flex-direction: row; background-color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
    
    <!-- LEFT PANEL: SIGNATURE KORMI EMERALD & FORESTRY GREEN (MATCHING DESIGN SYSTEM) -->
    <div style="width: 50%; background: linear-gradient(145deg, #064e3b 0%, #047857 45%, #059669 80%, #0f766e 100%); position: relative; padding: 48px 56px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; box-sizing: border-box;">
        
        <!-- POLYGONAL / GEOMETRIC FACET OVERLAYS -->
        <div style="position: absolute; inset: 0; pointer-events: none; opacity: 0.38;">
            <svg style="width: 100%; height: 100%;" viewBox="0 0 1000 1200" preserveAspectRatio="none" fill="none">
                <polygon points="0,0 1000,0 520,680" fill="url(#poly-grad-fp-1)" />
                <polygon points="1000,0 1000,1200 420,750" fill="url(#poly-grad-fp-2)" />
                <polygon points="0,400 700,1200 0,1200" fill="url(#poly-grad-fp-3)" />
                <polygon points="150,150 850,350 480,880" fill="url(#poly-grad-fp-1)" opacity="0.45"/>
                <defs>
                    <linearGradient id="poly-grad-fp-1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#8ed500" stop-opacity="0.45" />
                        <stop offset="100%" stop-color="#10b981" stop-opacity="0.05" />
                    </linearGradient>
                    <linearGradient id="poly-grad-fp-2" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#34d399" stop-opacity="0.35" />
                        <stop offset="100%" stop-color="#022c22" stop-opacity="0.2" />
                    </linearGradient>
                    <linearGradient id="poly-grad-fp-3" x1="0%" y1="100%" x2="100%" y2="0%">
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
                <span style="font-size: 11px; font-weight: 700; color: #f0fdf4; letter-spacing: 0.05em; text-transform: uppercase;">Layanan Mandiri Akun</span>
            </div>

            <h1 style="font-size: 34px; font-weight: 900; color: #ffffff; letter-spacing: -0.03em; line-height: 1.25; margin: 0 0 14px 0;">
                Lupa Kata Sandi
            </h1>
            <p style="font-size: 14px; color: rgba(240, 253, 244, 0.9); line-height: 1.65; margin: 0 0 20px 0; font-weight: 400;">
                Lupa kata sandi akun CMS Anda? Verifikasi alamat email terdaftar dan buat kata sandi baru yang aman dalam hitungan detik.
            </p>

            <div style="display: flex; align-items: center; gap: 12px; background: rgba(255, 255, 255, 0.14); padding: 14px 18px; border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.25); backdrop-filter: blur(10px);">
                <div style="font-size: 22px;">🛡️</div>
                <div style="font-size: 12px; color: #ffffff; line-height: 1.4; font-weight: 500;">
                    Keamanan data terjamin dengan enkripsi bcrypt dan proteksi sesi ganda KORMI.
                </div>
            </div>
        </div>

        <!-- BOTTOM FOOTER -->
        <div style="position: relative; z-index: 10; font-size: 12px; color: rgba(255, 255, 255, 0.75);">
            &copy; {{ date('Y') }} KORMI Kabupaten Bandung. All rights reserved.
        </div>
    </div>

    <!-- RIGHT PANEL: PASSWORD RESET FORM -->
    <div style="width: 50%; display: flex; align-items: center; justify-content: center; padding: 48px; background-color: #ffffff; box-sizing: border-box; overflow-y: auto; max-height: 100vh;">
        <div style="width: 100%; max-width: 420px;">
            
            <!-- HEADER -->
            <div style="margin-bottom: 28px;">
                <div style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 999px; background-color: #ecfdf5; border: 1px solid #a7f3d0; margin-bottom: 12px;">
                    <span style="font-size: 11px; font-weight: 800; color: #047857; text-transform: uppercase; letter-spacing: 0.05em;">Reset Kredensial</span>
                </div>
                <h2 style="font-size: 32px; font-weight: 900; color: #0f172a; margin: 0 0 6px 0; letter-spacing: -0.02em;">Lupa Kata Sandi</h2>
                <p style="font-size: 13px; color: #64748b; margin: 0;">
                    @if(!$isEmailVerified)
                        Masukkan email akun Anda untuk verifikasi identitas
                    @else
                        Buat kata sandi baru untuk akun <strong>{{ $email }}</strong>
                    @endif
                </p>
            </div>

            <!-- SUCCESS MESSAGE BANNER -->
            @if ($isSuccess || session()->has('status'))
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 16px; margin-bottom: 24px; animation: fadeInDown 0.3s ease-out;">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <div style="color: #16a34a; flex-shrink: 0; margin-top: 2px;">
                            <svg style="width: 22px; height: 22px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span style="display: block; font-size: 14px; font-weight: 700; color: #166534;">
                                Berhasil!
                            </span>
                            <span style="display: block; font-size: 12px; color: #15803d; margin-top: 4px; line-height: 1.5;">
                                {{ session('status') ?? 'Kata sandi berhasil diperbarui! Silakan masuk dengan kata sandi baru Anda.' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- ERROR ALERT BANNER -->
            @if ($errors->any() && !$isSuccess)
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px; animation: fadeInDown 0.3s ease-out;">
                    <div style="color: #ef4444; margin-top: 1px; flex-shrink: 0;">
                        <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <span style="display: block; font-size: 13px; font-weight: 700; color: #991b1b;">
                            Terjadi Kesalahan
                        </span>
                        <ul style="margin: 3px 0 0 0; padding-left: 16px; font-size: 12px; color: #b91c1c; line-height: 1.5;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (!$isEmailVerified)
                <!-- STEP 1: VERIFY EMAIL -->
                <form wire:submit="checkEmail" style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label style="font-size: 13px; font-weight: 600; color: #334155;">
                            Alamat Email Terdaftar
                        </label>
                        <input 
                            type="email" 
                            wire:model="email" 
                            placeholder="contoh: admin@kormibdg.id" 
                            required
                            autocomplete="email"
                            style="width: 100%; padding: 13px 16px; background-color: #ffffff; border: 1.5px solid {{ $errors->has('email') ? '#ef4444' : '#e2e8f0' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#059669'; this.style.boxShadow='0 0 0 4px rgba(5, 150, 105, 0.12)';"
                            onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#e2e8f0' }}'; this.style.boxShadow='none';"
                        >
                        @error('email') 
                            <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        wire:target="checkEmail"
                        wire:loading.attr="disabled"
                        style="width: 100%; padding: 14px 20px; background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff; border: none; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 22px -4px rgba(5, 150, 105, 0.45); transition: all 0.2s;"
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 14px 26px -4px rgba(5, 150, 105, 0.55)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 22px -4px rgba(5, 150, 105, 0.45)';"
                    >
                        <span wire:loading.remove wire:target="checkEmail">Periksa Akun</span>
                        <span wire:loading.flex wire:target="checkEmail" style="align-items: center; justify-content: center; gap: 8px;">
                            <svg class="animate-spin-custom" style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24">
                                <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path style="opacity: 0.85;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Memeriksa...</span>
                        </span>
                    </button>
                </form>
            @else
                <!-- STEP 2: SET NEW PASSWORD -->
                <form wire:submit="resetPassword" style="display: flex; flex-direction: column; gap: 16px;">
                    
                    <!-- Kata Sandi Baru -->
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <label style="font-size: 13px; font-weight: 600; color: #334155;">
                            Kata Sandi Baru
                        </label>
                        <div style="position: relative; width: 100%;">
                            <input 
                                type="{{ $showPassword ? 'text' : 'password' }}" 
                                wire:model="kata_sandi_baru" 
                                placeholder="Minimal 6 karakter" 
                                required
                                style="width: 100%; padding: 12px 44px 12px 16px; background-color: #ffffff; border: 1.5px solid {{ $errors->has('kata_sandi_baru') ? '#ef4444' : '#e2e8f0' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#059669'; this.style.boxShadow='0 0 0 4px rgba(5, 150, 105, 0.12)';"
                                onblur="this.style.borderColor='{{ $errors->has('kata_sandi_baru') ? '#ef4444' : '#e2e8f0' }}'; this.style.boxShadow='none';"
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
                        @error('kata_sandi_baru') 
                            <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Konfirmasi Kata Sandi Baru -->
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <label style="font-size: 13px; font-weight: 600; color: #334155;">
                            Ulangi Kata Sandi Baru
                        </label>
                        <input 
                            type="{{ $showPassword ? 'text' : 'password' }}" 
                            wire:model="konfirmasi_kata_sandi" 
                            placeholder="Ketik ulang kata sandi baru" 
                            required
                            style="width: 100%; padding: 12px 16px; background-color: #ffffff; border: 1.5px solid {{ $errors->has('konfirmasi_kata_sandi') ? '#ef4444' : '#e2e8f0' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#059669'; this.style.boxShadow='0 0 0 4px rgba(5, 150, 105, 0.12)';"
                            onblur="this.style.borderColor='{{ $errors->has('konfirmasi_kata_sandi') ? '#ef4444' : '#e2e8f0' }}'; this.style.boxShadow='none';"
                        >
                        @error('konfirmasi_kata_sandi') 
                            <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        wire:target="resetPassword"
                        wire:loading.attr="disabled"
                        style="width: 100%; padding: 14px 20px; margin-top: 8px; background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff; border: none; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 22px -4px rgba(5, 150, 105, 0.45); transition: all 0.2s;"
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 14px 26px -4px rgba(5, 150, 105, 0.55)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 22px -4px rgba(5, 150, 105, 0.45)';"
                    >
                        <span wire:loading.remove wire:target="resetPassword">Simpan Kata Sandi Baru</span>
                        <span wire:loading.flex wire:target="resetPassword" style="align-items: center; justify-content: center; gap: 8px;">
                            <svg class="animate-spin-custom" style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24">
                                <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path style="opacity: 0.85;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Menyimpan...</span>
                        </span>
                    </button>
                </form>
            @endif

            <!-- Back to Login -->
            <div style="text-align: center; margin-top: 24px; font-size: 13px; color: #64748b; font-weight: 500;">
                <span>Ingat kata sandi Anda?</span>
                <a href="{{ route('login') }}" wire:navigate style="margin-left: 4px; font-size: 13px; font-weight: 800; color: #059669; text-decoration: none;" onmouseover="this.style.textDecoration='underline'; this.style.color='#047857';" onmouseout="this.style.textDecoration='none'; this.style.color='#059669';">
                    Kembali ke Login
                </a>
            </div>

        </div>
    </div>

</div>
