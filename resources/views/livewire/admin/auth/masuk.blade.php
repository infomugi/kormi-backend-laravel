<div style="min-height: 100vh; width: 100%; display: flex; flex-direction: row; background-color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
    
    <!-- LEFT PANEL: SIGNATURE KORMI EMERALD & FORESTRY GREEN WITH DYNAMIC MESH & MOCKUP PREVIEW -->
    <div style="width: 50%; background: linear-gradient(145deg, #064e3b 0%, #047857 45%, #059669 80%, #0f766e 100%); position: relative; padding: 48px 56px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; box-sizing: border-box;">
        
        <!-- POLYGONAL / GEOMETRIC FACET OVERLAYS WITH KORMI LIME/EMERALD GLOW -->
        <div style="position: absolute; inset: 0; pointer-events: none; opacity: 0.38;">
            <svg style="width: 100%; height: 100%;" viewBox="0 0 1000 1200" preserveAspectRatio="none" fill="none">
                <polygon points="0,0 1000,0 520,680" fill="url(#kormi-poly-grad-1)" />
                <polygon points="1000,0 1000,1200 420,750" fill="url(#kormi-poly-grad-2)" />
                <polygon points="0,400 700,1200 0,1200" fill="url(#kormi-poly-grad-3)" />
                <polygon points="150,150 850,350 480,880" fill="url(#kormi-poly-grad-1)" opacity="0.45"/>
                <defs>
                    <linearGradient id="kormi-poly-grad-1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#8ed500" stop-opacity="0.45" />
                        <stop offset="100%" stop-color="#10b981" stop-opacity="0.05" />
                    </linearGradient>
                    <linearGradient id="kormi-poly-grad-2" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#34d399" stop-opacity="0.35" />
                        <stop offset="100%" stop-color="#022c22" stop-opacity="0.2" />
                    </linearGradient>
                    <linearGradient id="kormi-poly-grad-3" x1="0%" y1="100%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#a7f3d0" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="#059669" stop-opacity="0.05" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- AMBIENT GLOW CIRLCE -->
        <div style="position: absolute; top: -10%; right: -10%; width: 450px; height: 450px; background: radial-gradient(circle, rgba(142, 213, 0, 0.25) 0%, rgba(5, 150, 105, 0) 70%); border-radius: 50%; pointer-events: none;"></div>

        <!-- TOP LOGO & BRANDING -->
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

        <!-- HERO HEADLINE & TEXT (KORMI KABUPATEN BANDUNG FOCUSED) -->
        <div style="position: relative; z-index: 10; margin-top: auto; margin-bottom: 24px; max-width: 490px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 999px; background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.25); margin-bottom: 16px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #8ed500; display: inline-block; box-shadow: 0 0 10px #8ed500;"></span>
                <span style="font-size: 11px; font-weight: 700; color: #f0fdf4; letter-spacing: 0.05em; text-transform: uppercase;">Sistem Informasi Manajemen Olahraga</span>
            </div>
            
            <h1 style="font-size: 34px; font-weight: 900; color: #ffffff; letter-spacing: -0.03em; line-height: 1.25; margin: 0 0 14px 0;">
                KORMI Kabupaten Bandung
            </h1>
            <p style="font-size: 14px; color: rgba(240, 253, 244, 0.9); line-height: 1.65; margin: 0 0 20px 0; font-weight: 400;">
                Portal resmi pengelolaan olahraga rekreasi, integrasi data 31 Koordinator Kecamatan, ratusan Duta Desa/Kelurahan, dan klasemen medali FORKAB realtime.
            </p>

            <!-- DOT PAGINATION -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="width: 28px; height: 6px; border-radius: 4px; background: linear-gradient(90deg, #8ed500, #ffffff);"></span>
                <span style="width: 6px; height: 6px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.4);"></span>
                <span style="width: 6px; height: 6px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.4);"></span>
            </div>
        </div>

        <!-- FLOATING UI PREVIEW MOCKUP (KORMI DATA SPREADSHEET IN KORMI GREEN THEME) -->
        <div style="position: relative; z-index: 10; margin-bottom: -60px; margin-left: 10px;">
            
            <!-- TOP FLOATING AVATAR (Pengurus KORMI) -->
            <div style="position: absolute; top: -20px; right: 80px; z-index: 30; width: 46px; height: 46px; border-radius: 50%; border: 3px solid #ffffff; background-color: #064e3b; box-shadow: 0 12px 30px rgba(2, 44, 34, 0.35); overflow: hidden; display: flex; align-items: center; justify-content: center; color: #ffffff; font-weight: 800; font-size: 12px;">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&auto=format&fit=crop&q=80" style="width: 100%; height: 100%; object-fit: cover;" alt="Pengurus KORMI">
            </div>

            <!-- BOTTOM LEFT FLOATING AVATAR (Duta Desa) -->
            <div style="position: absolute; bottom: 35px; left: -15px; z-index: 30; width: 42px; height: 42px; border-radius: 50%; border: 3px solid #ffffff; background-color: #f1f5f9; box-shadow: 0 12px 30px rgba(2, 44, 34, 0.35); overflow: hidden;">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&auto=format&fit=crop&q=80" style="width: 100%; height: 100%; object-fit: cover;" alt="Duta Olahraga">
            </div>

            <!-- APP CARD WINDOW -->
            <div style="background-color: #ffffff; border-radius: 20px; box-shadow: 0 30px 60px -10px rgba(2, 44, 34, 0.45); border: 1px solid rgba(255, 255, 255, 0.9); display: flex; overflow: hidden; max-width: 500px;">
                
                <!-- MINI APP SIDEBAR IN KORMI GREEN -->
                <div style="width: 56px; background: linear-gradient(180deg, #047857 0%, #064e3b 100%); padding: 16px 10px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; color: #ffffff; flex-shrink: 0; box-sizing: border-box;">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 14px; width: 100%;">
                        <div style="width: 28px; height: 28px; border-radius: 8px; background-color: #ffffff; display: flex; align-items: center; justify-content: center; padding: 4px;">
                            <img src="{{ asset('assets/image/logo-kormi.png') }}" style="width: 100%; height: 100%; object-fit: contain;" alt="Logo">
                        </div>
                        <div style="width: 32px; height: 32px; border-radius: 10px; background-color: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; color: #8ed500;" title="Data Kecamatan">
                            <i data-lucide="map-pin" style="width: 16px; height: 16px;"></i>
                        </div>
                        <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; opacity: 0.7;" title="Medali FORKAB">
                            <i data-lucide="trophy" style="width: 16px; height: 16px;"></i>
                        </div>
                        <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; opacity: 0.7;" title="Inorga">
                            <i data-lucide="shapes" style="width: 16px; height: 16px;"></i>
                        </div>
                    </div>
                    <div style="opacity: 0.7; padding-bottom: 4px;">
                        <i data-lucide="settings" style="width: 16px; height: 16px;"></i>
                    </div>
                </div>

                <!-- MINI APP TABLE VIEW (DATA KORMI) -->
                <div style="flex: 1; background-color: #f8fafc; padding: 18px; min-width: 0; box-sizing: border-box;">
                    <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid #e2e8f0;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i data-lucide="database" style="width: 15px; height: 15px; color: #059669;"></i>
                            <span style="font-size: 13px; font-weight: 800; color: #1e293b;">Data 31 Kecamatan</span>
                        </div>
                        <span style="font-size: 10px; font-weight: 700; color: #047857; background-color: #d1fae5; padding: 2px 8px; border-radius: 6px; border: 1px solid #a7f3d0;">● Terkoneksi</span>
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
                            <span style="width: 55px; text-align: right; font-size: 10px; font-weight: 800; color: #059669;">12</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: #1e293b;">
                            <span style="width: 18px; font-size: 10px; color: #94a3b8;">2</span>
                            <span style="width: 80px; font-size: 10px; font-weight: 700;">Soreang</span>
                            <span style="flex: 1; font-size: 10px; color: #64748b;">Drs. Yayat Ruhyat</span>
                            <span style="width: 55px; text-align: right; font-size: 10px; font-weight: 800; color: #059669;">10</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: #1e293b;">
                            <span style="width: 18px; font-size: 10px; color: #94a3b8;">3</span>
                            <span style="width: 80px; font-size: 10px; font-weight: 700;">Baleendah</span>
                            <span style="flex: 1; font-size: 10px; color: #64748b;">Asep Saepudin</span>
                            <span style="width: 55px; text-align: right; font-size: 10px; font-weight: 800; color: #059669;">8</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: #1e293b;">
                            <span style="width: 18px; font-size: 10px; color: #94a3b8;">4</span>
                            <span style="width: 80px; font-size: 10px; font-weight: 700;">Banjaran</span>
                            <span style="flex: 1; font-size: 10px; color: #64748b;">Hj. Rina Marlina</span>
                            <span style="width: 55px; text-align: right; font-size: 10px; font-weight: 800; color: #059669;">7</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- RIGHT PANEL: CLEAN, CRISP WHITE AUTHENTICATION WITH KORMI EMERALD ACCENTS -->
    <div style="width: 50%; display: flex; align-items: center; justify-content: center; padding: 48px; background-color: #ffffff; box-sizing: border-box;">
        <div style="width: 100%; max-width: 410px;">
            
            <!-- HEADER -->
            <div style="margin-bottom: 28px;">
                <div style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 999px; background-color: #ecfdf5; border: 1px solid #a7f3d0; margin-bottom: 12px;">
                    <span style="font-size: 11px; font-weight: 800; color: #047857; text-transform: uppercase; letter-spacing: 0.05em;">Panel Masuk CMS</span>
                </div>
                <h2 style="font-size: 32px; font-weight: 900; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Masuk ke Akun</h2>
                <p style="font-size: 13px; color: #64748b; margin: 6px 0 0 0;">Silakan masukkan email & kata sandi administrator Anda.</p>
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
                    <label style="font-size: 13px; font-weight: 600; color: #334155;">
                        Alamat Email
                    </label>
                    <input 
                        type="email" 
                        name="email"
                        wire:model="email" 
                        placeholder="contoh: admin@kormibdg.id" 
                        required
                        autocomplete="email"
                        style="width: 100%; padding: 13px 16px; background-color: #ffffff; border: 1.5px solid {{ $errors->has('email') ? '#ef4444' : '#e2e8f0' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s; {{ $errors->has('email') ? 'background-color: #fffbfa;' : '' }}"
                        onfocus="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#059669' }}'; this.style.boxShadow='0 0 0 4px {{ $errors->has('email') ? 'rgba(239, 68, 68, 0.15)' : 'rgba(5, 150, 105, 0.12)' }}';"
                        onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#e2e8f0' }}'; this.style.boxShadow='none';"
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
                        <label style="font-size: 13px; font-weight: 600; color: #334155;">
                            Kata Sandi
                        </label>
                        <a 
                            href="{{ route('admin.lupa-password') }}" 
                            wire:navigate 
                            style="font-size: 12px; font-weight: 700; color: #059669; text-decoration: none;"
                            onmouseover="this.style.textDecoration='underline'; this.style.color='#047857';"
                            onmouseout="this.style.textDecoration='none'; this.style.color='#059669';"
                        >
                            Lupa Sandi?
                        </a>
                    </div>

                    <div style="position: relative; width: 100%;">
                        <input 
                            type="{{ $showPassword ? 'text' : 'password' }}" 
                            name="kata_sandi"
                            wire:model="kata_sandi" 
                            placeholder="Masukkan kata sandi..." 
                            required
                            autocomplete="current-password"
                            style="width: 100%; padding: 13px 44px 13px 16px; background-color: #ffffff; border: 1.5px solid {{ $errors->has('kata_sandi') ? '#ef4444' : '#e2e8f0' }}; border-radius: 12px; font-size: 14px; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; transition: all 0.2s; {{ $errors->has('kata_sandi') ? 'background-color: #fffbfa;' : '' }}"
                            onfocus="this.style.borderColor='{{ $errors->has('kata_sandi') ? '#ef4444' : '#059669' }}'; this.style.boxShadow='0 0 0 4px {{ $errors->has('kata_sandi') ? 'rgba(239, 68, 68, 0.15)' : 'rgba(5, 150, 105, 0.12)' }}';"
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
                        style="width: 17px; height: 17px; border-radius: 5px; border: 1px solid #cbd5e1; accent-color: #059669; cursor: pointer;"
                    >
                    <label for="remember_me" style="font-size: 13px; font-weight: 500; color: #475569; cursor: pointer; user-select: none;">
                        Ingat sesi saya di perangkat ini
                    </label>
                </div>

                <!-- KORMI Emerald Green Submit Button -->
                <button 
                    type="submit" 
                    wire:target="login"
                    wire:loading.attr="disabled"
                    style="width: 100%; padding: 14px 20px; background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff; border: none; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 22px -4px rgba(5, 150, 105, 0.45); transition: all 0.2s;"
                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 14px 26px -4px rgba(5, 150, 105, 0.55)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 22px -4px rgba(5, 150, 105, 0.45)';"
                >
                    <span wire:loading.remove wire:target="login">Masuk ke CMS</span>
                    <span wire:loading.flex wire:target="login" style="align-items: center; justify-content: center; gap: 8px;">
                        <svg class="animate-spin-custom" style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24">
                            <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path style="opacity: 0.85;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Memproses...</span>
                    </span>
                </button>
            </form>

            <!-- Quick Auto-fill Admin Button for Ease of Testing -->
            <div style="margin-top: 16px; padding: 12px; border-radius: 12px; background-color: #f8fafc; border: 1px dashed #cbd5e1; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 24px; height: 24px; border-radius: 6px; background-color: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                        ⚡
                    </div>
                    <span style="font-size: 12px; font-weight: 600; color: #64748b;">Akun Admin Demo</span>
                </div>
                <button 
                    type="button" 
                    wire:click="fillAdminCredentials"
                    style="font-size: 11px; font-weight: 700; color: #047857; background: #d1fae5; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 6px; cursor: pointer; transition: background 0.15s;"
                    onmouseover="this.style.background='#a7f3d0';"
                    onmouseout="this.style.background='#d1fae5';"
                >
                    Isi Otomatis
                </button>
            </div>

            <!-- Don't have an account? Sign up -->
            <div style="text-align: center; margin-top: 24px; font-size: 13px; color: #64748b; font-weight: 500;">
                <span>Belum memiliki akses akun?</span>
                <a href="{{ route('admin.daftar') }}" wire:navigate style="margin-left: 4px; font-size: 13px; font-weight: 800; color: #059669; text-decoration: none;" onmouseover="this.style.textDecoration='underline'; this.style.color='#047857';" onmouseout="this.style.textDecoration='none'; this.style.color='#059669';">
                    Daftar Akun
                </a>
            </div>

        </div>
    </div>

</div>
