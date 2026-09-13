<div class="min-h-screen w-full flex flex-col lg:flex-row bg-slate-50 lg:bg-white selection:bg-emerald-600 selection:text-white relative overflow-x-hidden">
    
    <!-- ========================================================================= -->
    <!-- LEFT PANEL (DESKTOP): ULTRA PREMIUM KORMI FOREST & EMBEDDED INFO         -->
    <!-- ========================================================================= -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#022c22] via-[#047857] to-[#064e3b] p-10 xl:p-14 flex-col justify-between relative overflow-hidden shrink-0">
        
        <!-- POLYGONAL / GEOMETRIC FACET OVERLAYS -->
        <div class="absolute inset-0 pointer-events-none opacity-30">
            <svg class="w-full h-full" viewBox="0 0 1000 1200" preserveAspectRatio="none" fill="none">
                <polygon points="0,0 1000,0 520,680" fill="url(#kormi-poly-reg-1)" />
                <polygon points="1000,0 1000,1200 420,750" fill="url(#kormi-poly-reg-2)" />
                <polygon points="0,400 700,1200 0,1200" fill="url(#kormi-poly-reg-3)" />
                <defs>
                    <linearGradient id="kormi-poly-reg-1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#8ed500" stop-opacity="0.4" />
                        <stop offset="100%" stop-color="#10b981" stop-opacity="0.05" />
                    </linearGradient>
                    <linearGradient id="kormi-poly-reg-2" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#34d399" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="#022c22" stop-opacity="0.2" />
                    </linearGradient>
                    <linearGradient id="kormi-poly-reg-3" x1="0%" y1="100%" x2="100%" y2="0%">
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
                <span class="text-[11px] font-bold text-emerald-100 uppercase tracking-wide">Akses Administrator & Pengurus</span>
            </div>
            
            <h1 class="text-3xl xl:text-4xl font-black text-white tracking-tight leading-snug mb-3">
                Registrasi Akun Pengelola
            </h1>
            <p class="text-sm text-emerald-100/90 leading-relaxed font-normal mb-6">
                Daftarkan akun pengelola Anda untuk koordinasi publikasi berita, galeri kegiatan, data inorga, medali FORKAB, dan 31 koordinator kecamatan se-Kabupaten Bandung.
            </p>

            <!-- Benefit Checkpoints -->
            <div class="space-y-3">
                <div class="flex items-center gap-3 text-white text-xs sm:text-sm font-semibold">
                    <div class="w-6 h-6 rounded-full bg-lime-400 text-emerald-950 flex items-center justify-center shrink-0 text-xs font-black shadow-sm">
                        <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                    </div>
                    <span class="text-emerald-50 font-medium">Akses Dashboard CMS Terintegrasi Realtime</span>
                </div>
                <div class="flex items-center gap-3 text-white text-xs sm:text-sm font-semibold">
                    <div class="w-6 h-6 rounded-full bg-lime-400 text-emerald-950 flex items-center justify-center shrink-0 text-xs font-black shadow-sm">
                        <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                    </div>
                    <span class="text-emerald-50 font-medium">Manajemen Berita, Inorga & Klasemen FORKAB</span>
                </div>
                <div class="flex items-center gap-3 text-white text-xs sm:text-sm font-semibold">
                    <div class="w-6 h-6 rounded-full bg-lime-400 text-emerald-950 flex items-center justify-center shrink-0 text-xs font-black shadow-sm">
                        <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                    </div>
                    <span class="text-emerald-50 font-medium">Verifikasi Duta Olahraga, Sapras & SDI Kecamatan</span>
                </div>
            </div>
        </div>

        <!-- FLOATING SECURITY / APPROVAL INFO PREVIEW -->
        <div class="relative z-10 bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-2xl border border-white/90 max-w-md">
            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="text-xs font-black text-slate-800">Verifikasi & Keamanan Sesi</span>
                </div>
                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/60">● Approval System</span>
            </div>

            <div class="grid grid-cols-3 gap-2 pt-2.5 text-center">
                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 block">ENKRIPSI</span>
                    <span class="text-xs font-black text-slate-800">Bcrypt</span>
                </div>
                <div class="p-2 rounded-xl bg-emerald-50/60 border border-emerald-100">
                    <span class="text-[10px] font-bold text-emerald-600 block">VALIDASI</span>
                    <span class="text-xs font-black text-emerald-800">Admin KORMI</span>
                </div>
                <div class="p-2 rounded-xl bg-lime-50/60 border border-lime-100">
                    <span class="text-[10px] font-bold text-lime-700 block">AKSES</span>
                    <span class="text-xs font-black text-lime-900">Protected</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- RIGHT PANEL (MOBILE & DESKTOP): ULTRA RESPONSIVE & COMPACT FORM CARD      -->
    <!-- ========================================================================= -->
    <div class="flex-1 flex flex-col justify-center items-center px-4 py-8 sm:px-8 lg:px-12 xl:px-16 min-h-screen relative z-10">
        
        <!-- Subtle Ambient Background Glow on Mobile -->
        <div class="lg:hidden absolute top-0 inset-x-0 h-48 bg-gradient-to-b from-emerald-800 via-emerald-900 to-transparent pointer-events-none"></div>

        <div class="w-full max-w-md relative z-10 my-auto py-4">
            
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
                        <span>Registrasi Akun CMS</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Daftar Akun Baru</h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Lengkapi data diri Anda untuk membuat akun pengelola CMS.</p>
                </div>

                <!-- ERROR ALERT BANNER -->
                @if ($errors->any() || session()->has('error'))
                    <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold mb-4 flex items-start gap-2.5 animate-in fade-in duration-200 shadow-2xs">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <span class="font-bold block text-rose-900">Pendaftaran Belum Berhasil</span>
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
                <form wire:submit="daftar" class="space-y-4">
                    <!-- Nama Lengkap Field -->
                    <div class="space-y-1.5">
                        <label for="nama_lengkap" class="block text-xs sm:text-sm font-bold text-slate-700">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </div>
                            <input 
                                type="text" 
                                id="nama_lengkap"
                                name="nama_lengkap"
                                wire:model="nama_lengkap" 
                                placeholder="Contoh: H. Agus Kurnia, S.Pd" 
                                required
                                autocomplete="name"
                                class="w-full h-11 sm:h-12 pl-10 pr-4 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border {{ $errors->has('nama_lengkap') ? 'border-rose-400 ring-2 ring-rose-400/20' : 'border-slate-200 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/10' }} rounded-xl sm:rounded-2xl text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 focus:outline-none transition-all"
                            >
                        </div>
                        @error('nama_lengkap') 
                            <p class="text-[11px] font-bold text-rose-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </p> 
                        @enderror
                    </div>

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

                    <!-- Nomor Telepon / WhatsApp -->
                    <div class="space-y-1.5">
                        <label for="nomor_telepon" class="block text-xs sm:text-sm font-bold text-slate-700">
                            Nomor WhatsApp / HP <span class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </div>
                            <input 
                                type="tel" 
                                id="nomor_telepon"
                                name="nomor_telepon"
                                wire:model="nomor_telepon" 
                                placeholder="081234567890" 
                                autocomplete="tel"
                                class="w-full h-11 sm:h-12 pl-10 pr-4 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border {{ $errors->has('nomor_telepon') ? 'border-rose-400 ring-2 ring-rose-400/20' : 'border-slate-200 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/10' }} rounded-xl sm:rounded-2xl text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 focus:outline-none transition-all"
                            >
                        </div>
                        @error('nomor_telepon') 
                            <p class="text-[11px] font-bold text-rose-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </p> 
                        @enderror
                    </div>

                    <!-- Grid Kata Sandi & Konfirmasi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <!-- Password Field -->
                        <div class="space-y-1.5">
                            <label for="kata_sandi" class="block text-xs sm:text-sm font-bold text-slate-700">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i data-lucide="lock" class="w-4 h-4"></i>
                                </div>
                                <input 
                                    type="{{ $showPassword ? 'text' : 'password' }}" 
                                    id="kata_sandi"
                                    name="kata_sandi"
                                    wire:model="kata_sandi" 
                                    placeholder="Min. 6 karakter" 
                                    required
                                    autocomplete="new-password"
                                    class="w-full h-11 sm:h-12 pl-10 pr-10 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border {{ $errors->has('kata_sandi') ? 'border-rose-400 ring-2 ring-rose-400/20' : 'border-slate-200 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/10' }} rounded-xl sm:rounded-2xl text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 focus:outline-none transition-all"
                                >
                                <button 
                                    type="button" 
                                    wire:click="toggleShowPassword" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700 focus:outline-none cursor-pointer transition-colors"
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

                        <!-- Konfirmasi Password Field -->
                        <div class="space-y-1.5">
                            <label for="konfirmasi_kata_sandi" class="block text-xs sm:text-sm font-bold text-slate-700">
                                Ulangi Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                                </div>
                                <input 
                                    type="{{ $showPassword ? 'text' : 'password' }}" 
                                    id="konfirmasi_kata_sandi"
                                    name="konfirmasi_kata_sandi"
                                    wire:model="konfirmasi_kata_sandi" 
                                    placeholder="Ulangi sandi" 
                                    required
                                    autocomplete="new-password"
                                    class="w-full h-11 sm:h-12 pl-10 pr-4 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border {{ $errors->has('konfirmasi_kata_sandi') ? 'border-rose-400 ring-2 ring-rose-400/20' : 'border-slate-200 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/10' }} rounded-xl sm:rounded-2xl text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 focus:outline-none transition-all"
                                >
                            </div>
                            @error('konfirmasi_kata_sandi') 
                                <p class="text-[11px] font-bold text-rose-600 flex items-center gap-1 mt-1">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                    <span>{{ $message }}</span>
                                </p> 
                            @enderror
                        </div>
                    </div>

                    <!-- Terms & Conditions Checkbox -->
                    <div class="pt-1">
                        <label class="flex items-start gap-2.5 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                id="terms" 
                                wire:model="setuju_syarat" 
                                class="w-4 h-4 mt-0.5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-colors cursor-pointer shrink-0"
                            >
                            <span class="text-xs font-medium text-slate-600 leading-snug">
                                Saya menyetujui <span class="font-bold text-emerald-700">Ketentuan Layanan</span> & <span class="font-bold text-emerald-700">Kebijakan Privasi</span> CMS KORMI Kab. Bandung.
                            </span>
                        </label>
                        @error('setuju_syarat') 
                            <p class="text-[11px] font-bold text-rose-600 flex items-center gap-1 mt-1.5 pl-6.5">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </p> 
                        @enderror
                    </div>

                    <!-- Submit Button with Emerald Gradient -->
                    <button 
                        type="submit" 
                        wire:target="daftar"
                        wire:loading.attr="disabled"
                        class="w-full h-11 sm:h-12 rounded-xl sm:rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-700 hover:from-emerald-500 hover:to-teal-600 text-white font-extrabold text-xs sm:text-sm uppercase tracking-wider shadow-lg shadow-emerald-600/25 hover:shadow-emerald-600/40 active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer mt-2"
                    >
                        <span wire:loading.remove wire:target="daftar" class="flex items-center gap-2">
                            <span>Daftar Akun CMS</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </span>
                        <span wire:loading.flex wire:target="daftar" class="items-center justify-center gap-2">
                            <svg class="animate-spin-custom w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-85" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Memproses Pendaftaran...</span>
                        </span>
                    </button>
                </form>

                <!-- Footer Sign In Navigation -->
                <div class="text-center pt-5 mt-5 border-t border-slate-100 text-xs font-medium text-slate-500">
                    <span>Sudah memiliki akun?</span>
                    <a href="{{ route('login') }}" wire:navigate class="font-extrabold text-emerald-700 hover:text-emerald-900 hover:underline ml-1">
                        Masuk Sekarang
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
