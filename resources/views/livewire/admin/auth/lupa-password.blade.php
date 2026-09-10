<div style="min-height: 100vh; width: 100%; display: flex; flex-direction: row; background-color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
    
    <!-- LEFT PANEL: DEEP VIBRANT ROYAL BLUE WITH LOW POLY MESH AND MOCKUP PREVIEW -->
    <div style="width: 50%; background: linear-gradient(135deg, #1e4ed8 0%, #2563eb 50%, #1d40b0 100%); position: relative; padding: 48px 56px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; box-sizing: border-box;">
        
        <!-- POLYGONAL / GEOMETRIC FACET OVERLAYS -->
        <div style="position: absolute; inset: 0; pointer-events: none; opacity: 0.35;">
            <svg style="width: 100%; height: 100%;" viewBox="0 0 1000 1200" preserveAspectRatio="none" fill="none">
                <polygon points="0,0 1000,0 520,680" fill="url(#poly-grad-fp-1)" />
                <polygon points="1000,0 1000,1200 420,750" fill="url(#poly-grad-fp-2)" />
                <polygon points="0,400 700,1200 0,1200" fill="url(#poly-grad-fp-3)" />
                <polygon points="150,150 850,350 480,880" fill="url(#poly-grad-fp-1)" opacity="0.5"/>
                <defs>
                    <linearGradient id="poly-grad-fp-1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0.45" />
                        <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.05" />
                    </linearGradient>
                    <linearGradient id="poly-grad-fp-2" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#93c5fd" stop-opacity="0.4" />
                        <stop offset="100%" stop-color="#1e3a8a" stop-opacity="0.1" />
                    </linearGradient>
                    <linearGradient id="poly-grad-fp-3" x1="0%" y1="100%" x2="100%" y2="0%">
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
                Pemulihan Kata Sandi
            </h1>
            <p style="font-size: 14px; color: rgba(255, 255, 255, 0.88); line-height: 1.6; margin: 0 0 20px 0; font-weight: 400;">
                Lupa kata sandi akun CMS Anda? Verifikasi alamat email terdaftar dan buat kata sandi baru yang aman dalam hitungan detik.
            </p>

            <div style="display: flex; align-items: center; gap: 12px; background: rgba(255, 255, 255, 0.12); padding: 14px 18px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.2);">
                <div style="font-size: 20px;">🛡️</div>
                <div style="font-size: 12px; color: #ffffff; line-height: 1.4;">
                    Keamanan data terjamin dengan enkripsi bcrypt dan proteksi sesi ganda.
                </div>
            </div>
        </div>

        <!-- BOTTOM FOOTER -->
        <div style="position: relative; z-index: 10; font-size: 12px; color: rgba(255, 255, 255, 0.6);">
            &copy; {{ date('Y') }} KORMI Kabupaten Bandung. All rights reserved.
        </div>
    </div>

    <!-- RIGHT PANEL: RESET PASSWORD FORM -->
    <div style="width: 50%; display: flex; align-items: center; justify-content: center; padding: 48px; background-color: #ffffff; box-sizing: border-box;">
        <div style="width: 100%; max-width: 400px;">
            
            <!-- HEADER -->
            <div style="margin-bottom: 28px;">
                <h2 style="font-size: 32px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; letter-spacing: -0.02em;">Lupa Kata Sandi</h2>
                <p style="font-size: 14px; color: #64748b; margin: 0;">
                    @if($isSuccess)
                        Kata sandi Anda berhasil diperbarui
                    @elseif($isEmailVerified)
                        Masukkan kata sandi baru untuk <strong>{{ $email }}</strong>
                    @else
                        Masukkan email akun Anda untuk proses verifikasi
                    @endif
                </p>
            </div>

            <!-- SUCCESS STATE -->
            @if($isSuccess)
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 16px; padding: 24px; text-align: center; margin-bottom: 24px;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background-color: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto;">
                        <svg style="width: 28px; height: 28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 style="font-size: 17px; font-weight: 700; color: #166534; margin: 0 0 8px 0;">Kata Sandi Berhasil Diubah!</h3>
                    <p style="font-size: 13px; color: #15803d; line-height: 1.5; margin: 0 0 20px 0;">
                        Akun Anda sekarang telah diperbarui dengan kata sandi baru. Silakan masuk kembali ke CMS.
                    </p>
                    <a 
                        href="{{ route('login') }}" 
                        wire:navigate
                        style="display: inline-flex; align-items: center; justify-content: center; width: 100%; padding: 13px 20px; background-color: #2563eb; color: #ffffff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);"
                    >
                        Masuk ke CMS
                    </a>
                </div>
            @else

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
                                Terjadi Kesalahan
                            </span>
                            <span style="display: block; font-size: 12px; color: #b91c1c; margin-top: 2px;">
                                {{ $errors->first() }}
                            </span>
                        </div>
                    </div>
                @endif

                @if(!$isEmailVerified)
                    <!-- STEP 1: VERIFIKASI EMAIL -->
                    <form wire:submit="checkEmail" style="display: flex; flex-direction: column; gap: 20px;">
                        
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569;">
                                Alamat Email Terdaftar
                            </label>
                            <input 
                                type="email" 
                                wire:model="email" 
                                placeholder="name@mail.com" 
                                required
                                autocomplete="email"
                                style="width: 100%; padding: 14px 16px; background-color: #ffffff; border: 1px solid {{ $errors->has('email') ? '#ef4444' : '#cbd5e1' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 4px rgba(37, 99, 235, 0.1)';"
                                onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#cbd5e1' }}'; this.style.boxShadow='none';"
                            >
                            @error('email') 
                                <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                            @enderror
                        </div>

                        <button 
                            type="submit" 
                            wire:target="checkEmail"
                            wire:loading.attr="disabled"
                            style="width: 100%; padding: 14px 20px; background-color: #2563eb; color: #ffffff; border: none; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4); transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='#1d4ed8';"
                            onmouseout="this.style.backgroundColor='#2563eb';"
                        >
                            <span wire:loading.remove wire:target="checkEmail">Lanjutkan Pemulihan</span>
                            <span wire:loading.flex wire:target="checkEmail" style="align-items: center; justify-content: center; gap: 8px;">
                                <svg class="animate-spin-custom" style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24">
                                    <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path style="opacity: 0.85;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memverifikasi Email...</span>
                            </span>
                        </button>
                    </form>
                @else
                    <!-- STEP 2: INPUT KATA SANDI BARU -->
                    <form wire:submit="resetPassword" style="display: flex; flex-direction: column; gap: 16px;">
                        
                        <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 12px; color: #1e40af; font-weight: 600;">{{ $email }}</span>
                            <button type="button" wire:click="resetState" style="background: none; border: none; padding: 0; font-size: 11px; font-weight: 700; color: #2563eb; cursor: pointer;">
                                Ganti Email
                            </button>
                        </div>

                        <!-- Kata Sandi Baru -->
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569;">
                                Kata Sandi Baru
                            </label>
                            <div style="position: relative; width: 100%;">
                                <input 
                                    type="{{ $showPassword ? 'text' : 'password' }}" 
                                    wire:model="kata_sandi_baru" 
                                    placeholder="Minimal 6 karakter" 
                                    required
                                    style="width: 100%; padding: 12px 44px 12px 16px; background-color: #ffffff; border: 1px solid {{ $errors->has('kata_sandi_baru') ? '#ef4444' : '#cbd5e1' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 4px rgba(37, 99, 235, 0.1)';"
                                    onblur="this.style.borderColor='{{ $errors->has('kata_sandi_baru') ? '#ef4444' : '#cbd5e1' }}'; this.style.boxShadow='none';"
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
                            @error('kata_sandi_baru') 
                                <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Konfirmasi Kata Sandi Baru -->
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569;">
                                Ulangi Kata Sandi Baru
                            </label>
                            <input 
                                type="{{ $showPassword ? 'text' : 'password' }}" 
                                wire:model="konfirmasi_kata_sandi" 
                                placeholder="Ketik ulang kata sandi baru" 
                                required
                                style="width: 100%; padding: 12px 16px; background-color: #ffffff; border: 1px solid {{ $errors->has('konfirmasi_kata_sandi') ? '#ef4444' : '#cbd5e1' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 4px rgba(37, 99, 235, 0.1)';"
                                onblur="this.style.borderColor='{{ $errors->has('konfirmasi_kata_sandi') ? '#ef4444' : '#cbd5e1' }}'; this.style.boxShadow='none';"
                            >
                            @error('konfirmasi_kata_sandi') 
                                <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                            @enderror
                        </div>

                        <button 
                            type="submit" 
                            wire:target="resetPassword"
                            wire:loading.attr="disabled"
                            style="width: 100%; padding: 14px 20px; margin-top: 6px; background-color: #2563eb; color: #ffffff; border: none; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4); transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='#1d4ed8';"
                            onmouseout="this.style.backgroundColor='#2563eb';"
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

            @endif

            <!-- Back to Login -->
            <div style="text-align: center; margin-top: 24px; font-size: 13px; color: #64748b; font-weight: 500;">
                <span>Ingat kata sandi Anda?</span>
                <a href="{{ route('login') }}" wire:navigate style="margin-left: 4px; font-size: 13px; font-weight: 700; color: #2563eb; text-decoration: none;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
                    Kembali ke Login
                </a>
            </div>

        </div>
    </div>

</div>
