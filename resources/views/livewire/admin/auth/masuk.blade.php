<div class="min-h-screen w-full flex flex-col lg:flex-row bg-slate-50 lg:bg-white selection:bg-emerald-600 selection:text-white relative overflow-x-hidden">
    
    <!-- ========================================================================= -->
    <!-- LEFT PANEL (DESKTOP): ULTRA PREMIUM KORMI FOREST & MOCKUP DATA EMBEDDED -->
    <!-- ========================================================================= -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#022c22] via-[#047857] to-[#064e3b] p-10 xl:p-14 flex-col justify-between relative overflow-hidden shrink-0">
        
        <!-- POLYGONAL / GEOMETRIC FACET OVERLAYS -->
        <div class="absolute inset-0 pointer-events-none opacity-30">
            <svg class="w-full h-full" viewBox="0 0 1000 1200" preserveAspectRatio="none" fill="none">
                <polygon points="0,0 1000,0 520,680" fill="url(#kormi-poly-1)" />
                <polygon points="1000,0 1000,1200 420,750" fill="url(#kormi-poly-2)" />
                <polygon points="0,400 700,1200 0,1200" fill="url(#kormi-poly-3)" />
                <defs>
                    <linearGradient id="kormi-poly-1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#8ed500" stop-opacity="0.4" />
                        <stop offset="100%" stop-color="#10b981" stop-opacity="0.05" />
                    </linearGradient>
                    <linearGradient id="kormi-poly-2" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#34d399" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="#022c22" stop-opacity="0.2" />
                    </linearGradient>
                    <linearGradient id="kormi-poly-3" x1="0%" y1="100%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#a7f3d0" stop-opacity="0.25" />
                        <stop offset="100%" stop-color="#059669" stop-opacity="0.05" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- Ambient Glow Orbs -->
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-lime-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <!-- TOP LOGO & BRANDING (DESKTOP) -->
        <div class="relative z-10">
            <a href="{{ route('beranda') }}" wire:navigate class="inline-flex items-center gap-3.5 group">
                <div class="w-12 h-12 rounded-2xl bg-white/95 backdrop-blur-md border border-white/80 flex items-center justify-center p-2 shadow-xl shadow-black/20 group-hover:scale-105 transition-transform">
                    <img src="{{ asset('assets/image/logo-kormi.png') }}" class="w-full h-full object-contain" alt="Logo KORMI">
                </div>
                <div class="text-white">
                    <div class="flex items-center gap-2">
                        <span class="font-black text-xl tracking-tight leading-tight">KORMI CMS</span>
                        <span class="text-[9px] font-black bg-gradient-to-r from-lime-400 to-emerald-300 text-emerald-950 px-2 py-0.5 rounded-full uppercase tracking-wider shadow-xs">Bedas</span>
                    </div>
                    <span class="block text-[11px] font-extrabold tracking-widest text-emerald-200 uppercase mt-0.5">Kabupaten Bandung</span>
                </div>
            </a>
        </div>

        <!-- HERO HEADLINE (DESKTOP) -->
        <div class="relative z-10 my-auto py-8 max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-4 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-lime-400 animate-pulse shadow-[0_0_8px_#a3e635]"></span>
                <span class="text-[11px] font-bold text-emerald-100 uppercase tracking-wide">Sistem Informasi Olahraga Terpadu</span>
            </div>
            
            <h1 class="text-3xl xl:text-4xl font-black text-white tracking-tight leading-snug mb-3">
                KORMI Kabupaten Bandung
            </h1>
            <p class="text-sm text-emerald-100/90 leading-relaxed font-normal">
                Portal manajemen olahraga rekreasi, integrasi 31 Koordinator Kecamatan, data Duta Olahraga, dan perolehan medali FORKAB realtime.
            </p>
        </div>

        <!-- FLOATING MINI SPREADSHEET PREVIEW -->
        <div class="relative z-10 bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-2xl border border-white/90 max-w-md">
            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <i data-lucide="database" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="text-xs font-black text-slate-800">31 Kecamatan Terpadu</span>
                </div>
                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/60">● Realtime Sync</span>
            </div>

            <div class="grid grid-cols-3 gap-2 pt-2.5 text-center">
                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 block">KORCAM</span>
                    <span class="text-xs font-black text-slate-800">31 Wilayah</span>
                </div>
                <div class="p-2 rounded-xl bg-emerald-50/60 border border-emerald-100">
                    <span class="text-[10px] font-bold text-emerald-600 block">INORGA</span>
                    <span class="text-xs font-black text-emerald-800">Komisi Aktif</span>
                </div>
                <div class="p-2 rounded-xl bg-lime-50/60 border border-lime-100">
                    <span class="text-[10px] font-bold text-lime-700 block">FORKAB</span>
                    <span class="text-xs font-black text-lime-900">Klasemen</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- RIGHT PANEL (MOBILE & DESKTOP): ULTRA RESPONSIVE & COMPACT LOGIN CARD     -->
    <!-- ========================================================================= -->
    <div class="flex-1 flex flex-col justify-center items-center px-4 py-8 sm:px-8 lg:px-12 xl:px-16 min-h-screen relative z-10">
        
        <!-- Subtle Ambient Background Glow on Mobile -->
        <div class="lg:hidden absolute top-0 inset-x-0 h-48 bg-gradient-to-b from-emerald-800 via-emerald-900 to-transparent pointer-events-none"></div>

        <div class="w-full max-w-md relative z-10">
            
            <!-- MOBILE HEADER BRANDING (COMPACT & MODERN) -->
            <div class="lg:hidden flex flex-col items-center text-center mb-6 pt-2">
                <a href="{{ route('beranda') }}" wire:navigate class="inline-flex items-center justify-center gap-3 mb-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-xl shadow-emerald-950/20 border border-white/80 p-2 flex items-center justify-center">
                        <img src="{{ asset('assets/image/logo-kormi.png') }}" class="w-full h-full object-contain" alt="Logo KORMI">
                    </div>
                </a>
                <div class="flex items-center gap-1.5 justify-center">
                    <span class="font-black text-lg text-white sm:text-slate-900 tracking-tight">KORMI CMS</span>
                    <span class="text-[9px] font-black bg-lime-400 text-slate-950 px-1.5 py-0.5 rounded uppercase tracking-wider shadow-xs">Bedas</span>
                </div>
                <p class="text-[11px] font-bold text-emerald-200 sm:text-slate-400 uppercase tracking-widest mt-0.5">Kabupaten Bandung</p>
            </div>

            <!-- CARD CONTAINER (CRISP WHITE ON MOBILE & DESKTOP) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 sm:shadow-xl sm:border sm:border-slate-200/80 shadow-2xl border border-white/80">
                
                <!-- TITLE HEADING -->
                <div class="mb-5 sm:mb-6">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-[10px] sm:text-xs font-black uppercase tracking-wider mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                        <span>Panel Masuk CMS</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Masuk ke Akun</h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Masukkan email & kata sandi administrator Anda.</p>
                </div>

                <!-- ERROR ALERT BANNER -->
                @if ($errors->any() || session()->has('error'))
                    <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold mb-4 flex items-start gap-2.5 animate-in fade-in duration-200 shadow-2xs">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <span class="font-bold block text-rose-900">Gagal Masuk</span>
                            @if(session()->has('error'))
                                <span class="block text-rose-700 mt-0.5 leading-snug">{{ session('error') }}</span>
                            @else
                                <ul class="list-disc list-inside mt-0.5 space-y-0.5 text-rose-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- SUCCESS BANNER -->
                @if (session()->has('status') || session()->has('success'))
                    <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold mb-4 flex items-center gap-2.5 animate-in fade-in duration-200 shadow-2xs">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                        <span>{{ session('status') ?? session('success') }}</span>
                    </div>
                @endif

                <!-- FORM -->
                <form action="{{ route('admin.masuk.post') }}" method="POST" wire:submit="login" class="space-y-4">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs sm:text-sm font-bold text-slate-700">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <input 
                                type="email" 
                                id="email"
                                name="email"
                                wire:model="email" 
                                placeholder="nama@kormibdg.id" 
                                required
                                autocomplete="email"
                                class="w-full h-11 sm:h-12 pl-10 pr-4 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border {{ $errors->has('email') ? 'border-rose-400 ring-2 ring-rose-400/20' : 'border-slate-200 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/10' }} rounded-xl sm:rounded-2xl text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 focus:outline-none transition-all"
                            >
                        </div>
                        @error('email') 
                            <p class="text-[11px] font-bold text-rose-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </p> 
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="kata_sandi" class="block text-xs sm:text-sm font-bold text-slate-700">
                                Kata Sandi
                            </label>
                            <a 
                                href="{{ route('admin.lupa-password') }}" 
                                wire:navigate 
                                class="text-[11px] sm:text-xs font-bold text-emerald-700 hover:text-emerald-900 hover:underline transition-colors"
                            >
                                Lupa Sandi?
                            </a>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </div>
                            <input 
                                type="{{ $showPassword ? 'text' : 'password' }}" 
                                id="kata_sandi"
                                name="kata_sandi"
                                wire:model="kata_sandi" 
                                placeholder="••••••••" 
                                required
                                autocomplete="current-password"
                                class="w-full h-11 sm:h-12 pl-10 pr-11 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border {{ $errors->has('kata_sandi') ? 'border-rose-400 ring-2 ring-rose-400/20' : 'border-slate-200 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/10' }} rounded-xl sm:rounded-2xl text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 focus:outline-none transition-all"
                            >
                            <button 
                                type="button" 
                                wire:click="toggleShowPassword" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 focus:outline-none cursor-pointer transition-colors"
                            >
                                @if($showPassword)
                                    <i data-lucide="eye-off" class="w-4 h-4 text-emerald-600"></i>
                                @else
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                @endif
                            </button>
                        </div>
                        @error('kata_sandi') 
                            <p class="text-[11px] font-bold text-rose-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </p> 
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                name="ingat_saya"
                                value="1"
                                id="remember_me" 
                                wire:model="ingat_saya" 
                                class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-colors cursor-pointer"
                            >
                            <span class="text-xs font-semibold text-slate-600">
                                Ingat sesi saya
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button with Emerald Gradient -->
                    <button 
                        type="submit" 
                        wire:target="login"
                        wire:loading.attr="disabled"
                        class="w-full h-11 sm:h-12 rounded-xl sm:rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-700 hover:from-emerald-500 hover:to-teal-600 text-white font-extrabold text-xs sm:text-sm uppercase tracking-wider shadow-lg shadow-emerald-600/25 hover:shadow-emerald-600/40 active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer mt-2"
                    >
                        <span wire:loading.remove wire:target="login" class="flex items-center gap-2">
                            <span>Masuk ke CMS</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </span>
                        <span wire:loading.flex wire:target="login" class="items-center justify-center gap-2">
                            <svg class="animate-spin-custom w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-85" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Memproses...</span>
                        </span>
                    </button>
                </form>

                <!-- Footer Sign Up Navigation -->
                <div class="text-center pt-5 mt-5 border-t border-slate-100 text-xs font-medium text-slate-500">
                    <span>Belum memiliki akun?</span>
                    <a href="{{ route('admin.daftar') }}" wire:navigate class="font-extrabold text-emerald-700 hover:text-emerald-900 hover:underline ml-1">
                        Daftar Akun Baru
                    </a>
                </div>

            </div>

            <!-- Bottom Copyright / Portal Back Link -->
            <div class="text-center mt-6">
                <a href="{{ route('beranda') }}" wire:navigate class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-emerald-700 transition-colors">
                    <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                    <span>Kembali ke Portal KORMI</span>
                </a>
            </div>

        </div>
    </div>

</div>
