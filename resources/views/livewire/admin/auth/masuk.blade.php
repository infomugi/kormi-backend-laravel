<div style="min-height: 100vh; width: 100%; display: flex; flex-direction: row; background-color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
    
    <!-- LEFT PANEL: DEEP VIBRANT ROYAL BLUE WITH LOW POLY MESH AND MOCKUP PREVIEW (EXACT REFERENCE) -->
    <div style="width: 50%; background: linear-gradient(135deg, #1e4ed8 0%, #2563eb 50%, #1d40b0 100%); position: relative; padding: 48px 56px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; box-sizing: border-box;">
        
        <!-- POLYGONAL / GEOMETRIC FACET OVERLAYS -->
        <div style="position: absolute; inset: 0; pointer-events: none; opacity: 0.35;">
            <svg style="width: 100%; height: 100%;" viewBox="0 0 1000 1200" preserveAspectRatio="none" fill="none">
                <polygon points="0,0 1000,0 520,680" fill="url(#poly-grad-1)" />
                <polygon points="1000,0 1000,1200 420,750" fill="url(#poly-grad-2)" />
                <polygon points="0,400 700,1200 0,1200" fill="url(#poly-grad-3)" />
                <polygon points="150,150 850,350 480,880" fill="url(#poly-grad-1)" opacity="0.5"/>
                <defs>
                    <linearGradient id="poly-grad-1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0.45" />
                        <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.05" />
                    </linearGradient>
                    <linearGradient id="poly-grad-2" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#93c5fd" stop-opacity="0.4" />
                        <stop offset="100%" stop-color="#1e3a8a" stop-opacity="0.1" />
                    </linearGradient>
                    <linearGradient id="poly-grad-3" x1="0%" y1="100%" x2="100%" y2="0%">
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

        <!-- HERO HEADLINE & TEXT (KORMI KABUPATEN BANDUNG FOCUSED) -->
        <div style="position: relative; z-index: 10; margin-top: auto; margin-bottom: 24px; max-width: 480px;">
            <h1 style="font-size: 36px; font-weight: 800; color: #ffffff; letter-spacing: -0.02em; line-height: 1.2; margin: 0 0 12px 0;">
                KORMI Kabupaten Bandung
            </h1>
            <p style="font-size: 14px; color: rgba(255, 255, 255, 0.88); line-height: 1.6; margin: 0 0 20px 0; font-weight: 400;">
                Pusat data terpadu olahraga rekreasi, binaan 31 Koordinator Kecamatan, ratusan duta desa, serta klasemen medali FORKAB realtime.
            </p>

            <!-- DOT PAGINATION -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="width: 24px; height: 6px; border-radius: 4px; background-color: #ffffff;"></span>
                <span style="width: 6px; height: 6px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.4);"></span>
                <span style="width: 6px; height: 6px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.4);"></span>
            </div>
        </div>

        <!-- FLOATING UI PREVIEW MOCKUP (KORMI DATA SPREADSHEET) -->
        <div style="position: relative; z-index: 10; margin-bottom: -60px; margin-left: 10px;">
            
            <!-- TOP FLOATING AVATAR (Ketua KORMI / Admin) -->
            <div style="position: absolute; top: -20px; right: 80px; z-index: 30; width: 46px; height: 46px; border-radius: 50%; border: 3px solid #ffffff; background-color: #1e3a8a; box-shadow: 0 12px 30px rgba(0,0,0,0.25); overflow: hidden; display: flex; align-items: center; justify-content: center; color: #ffffff; font-weight: 800; font-size: 12px;">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&auto=format&fit=crop&q=80" style="width: 100%; height: 100%; object-fit: cover;" alt="Pengurus KORMI">
            </div>

            <!-- BOTTOM LEFT FLOATING AVATAR (Duta Desa) -->
            <div style="position: absolute; bottom: 35px; left: -15px; z-index: 30; width: 42px; height: 42px; border-radius: 50%; border: 3px solid #ffffff; background-color: #f1f5f9; box-shadow: 0 12px 30px rgba(0,0,0,0.25); overflow: hidden;">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&auto=format&fit=crop&q=80" style="width: 100%; height: 100%; object-fit: cover;" alt="Duta Olahraga">
            </div>

            <!-- APP CARD WINDOW -->
            <div style="background-color: #ffffff; border-radius: 20px; box-shadow: 0 30px 60px -10px rgba(15, 23, 42, 0.4); border: 1px solid rgba(255, 255, 255, 0.8); display: flex; overflow: hidden; max-width: 500px;">
                
                <!-- MINI APP SIDEBAR -->
                <div style="width: 56px; background-color: #2563eb; padding: 16px 10px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; color: #ffffff; flex-shrink: 0; box-sizing: border-box;">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 14px; width: 100%;">
                        <div style="width: 28px; height: 28px; border-radius: 8px; background-color: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; padding: 4px;">
                            <img src="{{ asset('assets/image/logo-kormi.png') }}" style="width: 100%; height: 100%; object-fit: contain; filter: brightness(0) invert(1);" alt="Logo">
                        </div>
                        <div style="width: 32px; height: 32px; border-radius: 10px; background-color: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;" title="Data Kecamatan">
                            <i data-lucide="map-pin" style="width: 16px; height: 16px;"></i>
                        </div>
                        <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; opacity: 0.6;" title="Medali FORKAB">
                            <i data-lucide="trophy" style="width: 16px; height: 16px;"></i>
                        </div>
                        <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; opacity: 0.6;" title="Inorga">
                            <i data-lucide="shapes" style="width: 16px; height: 16px;"></i>
                        </div>
                    </div>
                    <div style="opacity: 0.6; padding-bottom: 4px;">
                        <i data-lucide="settings" style="width: 16px; height: 16px;"></i>
                    </div>
                </div>

                <!-- MINI APP TABLE VIEW (DATA KORMI) -->
                <div style="flex: 1; background-color: #f8fafc; padding: 18px; min-width: 0; box-sizing: border-box;">
                    <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid #e2e8f0;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i data-lucide="database" style="width: 15px; height: 15px; color: #2563eb;"></i>
                            <span style="font-size: 13px; font-weight: 800; color: #1e293b;">Data 31 Kecamatan</span>
                        </div>
                        <span style="font-size: 10px; font-weight: 700; color: #16a34a; background-color: #dcfce7; padding: 2px 8px; border-radius: 6px;">● Terkoneksi</span>
                    </div>

                    <!-- Toolbar -->
                    <div style="display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid #e2e8f0; color: #94a3b8; font-size: 11px;">
                        <span style="font-weight: 700; color: #475569;">KORCAM:</span>
                        <span style="background-color: #e2e8f0; color: #334155; padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 10px;">Soreang</span>
                        <span style="background-color: #e2e8f0; color: #334155; padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 10px;">Margahayu</span>
                        <span style="background-color: #e2e8f0; color: #334155; padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 10px;">Baleendah</span>
                    </div>

                    <!-- Spreadsheet Table (KORMI Columns) -->
                    <div style="margin-top: 10px;">
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 10px; font-weight: 700; color: #64748b; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px;">
                            <span style="width: 18px;">No</span>
                            <span style="width: 80px;">Kecamatan</span>
                            <span style="flex: 1;">Kordik / Ketua</span>
                            <span style="width: 55px; text-align: right;">Emas 🥇</span>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: #1e293b;">
                            <span style="width: 18px; font-size: 10px; color: #94a3b8;">1</span>
                            <span style="width: 80px; font-size: 10px; font-weight: 700;">Margahayu</span>
                            <span style="flex: 1; font-size: 10px; color: #64748b;">H. Agus Kurnia</span>
                            <span style="width: 55px; text-align: right; font-size: 10px; font-weight: 800; color: #2563eb;">12</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: #1e293b;">
                            <span style="width: 18px; font-size: 10px; color: #94a3b8;">2</span>
                            <span style="width: 80px; font-size: 10px; font-weight: 700;">Soreang</span>
                            <span style="flex: 1; font-size: 10px; color: #64748b;">Drs. Yayat Ruhyat</span>
                            <span style="width: 55px; text-align: right; font-size: 10px; font-weight: 800; color: #2563eb;">10</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: #1e293b;">
                            <span style="width: 18px; font-size: 10px; color: #94a3b8;">3</span>
                            <span style="width: 80px; font-size: 10px; font-weight: 700;">Baleendah</span>
                            <span style="flex: 1; font-size: 10px; color: #64748b;">Asep Saepudin</span>
                            <span style="width: 55px; text-align: right; font-size: 10px; font-weight: 800; color: #2563eb;">8</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: #1e293b;">
                            <span style="width: 18px; font-size: 10px; color: #94a3b8;">4</span>
                            <span style="width: 80px; font-size: 10px; font-weight: 700;">Banjaran</span>
                            <span style="flex: 1; font-size: 10px; color: #64748b;">Hj. Rina Marlina</span>
                            <span style="width: 55px; text-align: right; font-size: 10px; font-weight: 800; color: #2563eb;">7</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- RIGHT PANEL: CLEAN, CRISP WHITE AUTHENTICATION (CENTERED) -->
    <div style="width: 50%; display: flex; align-items: center; justify-content: center; padding: 48px; background-color: #ffffff; box-sizing: border-box;">
        <div style="width: 100%; max-width: 400px;">
            
            <!-- HEADER -->
            <div style="margin-bottom: 28px;">
                <h2 style="font-size: 34px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Login</h2>
            </div>

            <!-- ERROR ALERT BANNER -->
            @if ($errors->any() || session()->has('error'))
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 14px 16px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 12px; animation: fadeInDown 0.3s ease-out; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);">
                    <div style="color: #ef4444; margin-top: 1px; flex-shrink: 0;">
                        <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" stroke="currentColor"/>
                            <line x1="12" y1="8" x2="12" y2="12" stroke="currentColor"/>
                            <line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor"/>
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <span style="display: block; font-size: 13px; font-weight: 700; color: #991b1b;">
                            Gagal Masuk
                        </span>
                        @if(session()->has('error'))
                            <span style="display: block; font-size: 12px; color: #b91c1c; margin-top: 2px; line-height: 1.4;">
                                {{ session('error') }}
                            </span>
                        @else
                            <ul style="margin: 3px 0 0 0; padding-left: 16px; font-size: 12px; color: #b91c1c; line-height: 1.5;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif

            <!-- SUCCESS MESSAGE BANNER -->
            @if (session()->has('status') || session()->has('success'))
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; animation: fadeInDown 0.3s ease-out; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.08);">
                    <div style="color: #16a34a; flex-shrink: 0;">
                        <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span style="font-size: 13px; font-weight: 600; color: #166534;">
                        {{ session('status') ?? session('success') }}
                    </span>
                </div>
            @endif

            <!-- FORM -->
            <form action="{{ route('admin.masuk.post') }}" method="POST" wire:submit="login" style="display: flex; flex-direction: column; gap: 20px;">
                @csrf
                
                <!-- Email address -->
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 13px; font-weight: 600; color: #475569;">
                        Email address
                    </label>
                    <input 
                        type="email" 
                        name="email"
                        wire:model="email" 
                        placeholder="name@mail.com" 
                        required
                        autocomplete="email"
                        style="width: 100%; padding: 14px 16px; background-color: #ffffff; border: 1px solid {{ $errors->has('email') ? '#ef4444' : '#cbd5e1' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s; {{ $errors->has('email') ? 'background-color: #fffbfa;' : '' }}"
                        onfocus="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#2563eb' }}'; this.style.boxShadow='0 0 0 4px {{ $errors->has('email') ? 'rgba(239, 68, 68, 0.15)' : 'rgba(37, 99, 235, 0.1)' }}';"
                        onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#cbd5e1' }}'; this.style.boxShadow='none';"
                    >
                    @error('email') 
                        <div style="display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                            <svg style="width: 14px; height: 14px; color: #ef4444; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <label style="font-size: 13px; font-weight: 600; color: #475569;">
                            Password
                        </label>
                        <a 
                            href="{{ route('admin.lupa-password') }}" 
                            wire:navigate 
                            style="font-size: 12px; font-weight: 600; color: #2563eb; text-decoration: none;"
                            onmouseover="this.style.textDecoration='underline';"
                            onmouseout="this.style.textDecoration='none';"
                        >
                            Reset Password
                        </a>
                    </div>

                    <div style="position: relative; width: 100%;">
                        <input 
                            type="{{ $showPassword ? 'text' : 'password' }}" 
                            name="kata_sandi"
                            wire:model="kata_sandi" 
                            placeholder="***********" 
                            required
                            autocomplete="current-password"
                            style="width: 100%; padding: 14px 44px 14px 16px; background-color: #ffffff; border: 1px solid {{ $errors->has('kata_sandi') ? '#ef4444' : '#cbd5e1' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s; {{ $errors->has('kata_sandi') ? 'background-color: #fffbfa;' : '' }}"
                            onfocus="this.style.borderColor='{{ $errors->has('kata_sandi') ? '#ef4444' : '#2563eb' }}'; this.style.boxShadow='0 0 0 4px {{ $errors->has('kata_sandi') ? 'rgba(239, 68, 68, 0.15)' : 'rgba(37, 99, 235, 0.1)' }}';"
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
                        <div style="display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                            <svg style="width: 14px; height: 14px; color: #ef4444; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <span style="font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</span> 
                        </div>
                    @enderror
                </div>

                <!-- Remember Password -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <input 
                        type="checkbox" 
                        name="ingat_saya"
                        value="1"
                        id="remember_me" 
                        wire:model="ingat_saya" 
                        style="width: 16px; height: 16px; border-radius: 4px; border: 1px solid #cbd5e1; accent-color: #2563eb; cursor: pointer;"
                    >
                    <label for="remember_me" style="font-size: 13px; font-weight: 500; color: #475569; cursor: pointer; user-select: none;">
                        Remember Password
                    </label>
                </div>

                <!-- Solid Blue Login Button -->
                <button 
                    type="submit" 
                    wire:target="login"
                    wire:loading.attr="disabled"
                    style="width: 100%; padding: 14px 20px; background-color: #2563eb; color: #ffffff; border: none; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4); transition: background-color 0.2s;"
                    onmouseover="this.style.backgroundColor='#1d4ed8';"
                    onmouseout="this.style.backgroundColor='#2563eb';"
                >
                    <span wire:loading.remove wire:target="login">Login</span>
                    <span wire:loading.flex wire:target="login" style="align-items: center; justify-content: center; gap: 8px;">
                        <svg class="animate-spin-custom" style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24">
                            <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path style="opacity: 0.85;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Signing in...</span>
                    </span>
                </button>
            </form>

            <!-- Don't have an account? Sign up -->
            <div style="text-align: center; margin-top: 24px; font-size: 13px; color: #64748b; font-weight: 500;">
                <span>Don't have an account?</span>
                <a href="{{ route('admin.daftar') }}" wire:navigate style="margin-left: 4px; font-size: 13px; font-weight: 700; color: #2563eb; text-decoration: none;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
                    Sign up
                </a>
            </div>



            <!-- DEFAULT CREDENTIALS -->
            <div style="margin-top: 24px; text-align: center; font-size: 11px; color: #94a3b8;">
                Default Account: <button type="button" wire:click="fillAdminCredentials" style="background: none; border: none; padding: 0; font-weight: 700; color: #64748b; cursor: pointer;">admin@kormibdg.id</button> / <button type="button" wire:click="fillAdminCredentials" style="background: none; border: none; padding: 0; font-weight: 700; color: #64748b; cursor: pointer;">password</button>
            </div>

        </div>
    </div>

</div>
