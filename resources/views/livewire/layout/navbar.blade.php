<nav x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 30)" :class="{ 'py-2.5 shadow-xl bg-white/95 border-slate-200/90': scrolled, 'py-3.5 bg-white/85 border-slate-200/60': !scrolled }" class="fixed top-3 left-1/2 -translate-x-1/2 w-[95%] max-w-[1360px] z-50 transition-all duration-300 rounded-full border glass backdrop-blur-xl">
    <div class="container mx-auto px-6 sm:px-8 flex justify-between items-center">
        <a href="{{ route('beranda') }}" wire:navigate class="flex items-center gap-3 group">
            <img src="{{ asset('assets/image/logo-kormi.png') }}" class="w-8 h-8 sm:w-9 sm:h-9 object-contain group-hover:scale-105 transition-transform" alt="Logo Kormi" />
            <div class="leading-none">
                <div class="flex items-center gap-1.5">
                    <span class="text-base font-black tracking-tight text-slate-900">KORMI</span>
                    <span class="px-1.5 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[9px] font-black uppercase tracking-wider">Kab. Bandung</span>
                </div>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Komite Olahraga Masyarakat</p>
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex items-center gap-6">
            @foreach($menuItems as $item)
                @php
                    $isActive = false;
                    if (isset($item['link']) && $item['link'] !== '#' && !str_starts_with($item['link'], '#')) {
                        $isActive = (url()->current() === $item['link']);
                    }
                    if (isset($item['sub'])) {
                        foreach ($item['sub'] as $sub) {
                            if (url()->current() === $sub['link']) {
                                $isActive = true;
                                break;
                            }
                        }
                    }
                @endphp
                <div class="relative group py-2">
                    <a href="{{ $item['link'] ?? '#' }}" {{ isset($item['sub']) || ($item['external'] ?? false) || str_starts_with($item['link'] ?? '', '#') ? '' : 'wire:navigate' }} class="flex items-center gap-1.5 text-[14px] font-extrabold transition-colors cursor-pointer tracking-wide uppercase {{ $isActive ? 'text-emerald-600' : 'text-slate-700 hover:text-emerald-600' }}">
                        <span>{{ $item['name'] }}</span>
                        @if(isset($item['sub']))
                            <i data-lucide="chevron-down" class="w-4 h-4 opacity-60"></i>
                        @endif
                    </a>
                    @if(isset($item['sub']))
                        <div class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-72 bg-white rounded-2xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.12)] border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-2 group-hover:translate-y-0 transition-all duration-200 p-2.5 z-50">
                            @foreach($item['sub'] as $sub)
                                @php
                                    $isSubActive = (url()->current() === $sub['link']);
                                    $isExternal = $sub['external'] ?? false;
                                @endphp
                                <a href="{{ $sub['link'] }}" {{ $isExternal ? '' : 'wire:navigate' }} class="block px-4 py-2.5 text-[13px] rounded-xl transition-all {{ $isSubActive ? 'bg-emerald-50 text-emerald-700 font-extrabold' : 'text-slate-600 font-bold hover:bg-emerald-50/60 hover:text-emerald-600' }}">
                                    {{ $sub['name'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="flex items-center gap-5">
            <button @click="$wire.toggleMenu()" class="lg:hidden p-2 text-slate-600" aria-label="Toggle menu">
                <i data-lucide="menu" class="w-8 h-8"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="$wire.isMenuOpen" x-transition.opacity class="fixed inset-0 z-[100] bg-slate-900/40 backdrop-blur-sm lg:hidden" @click="$wire.toggleMenu()" style="display: none;"></div>
    
    <div x-show="$wire.isMenuOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="fixed top-0 right-0 h-screen w-[85%] max-w-sm bg-white z-[101] shadow-2xl lg:hidden overflow-y-auto p-6" style="display: none;">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/image/logo-kormi.png') }}" class="w-8 h-8 object-contain" alt="Logo Kormi" />
                <h1 class="text-base font-black tracking-tight text-slate-900">KORMI</h1>
            </div>
            <button @click="$wire.toggleMenu()" class="p-2 text-slate-500 hover:text-red-500 rounded-full" aria-label="Close menu">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <div class="space-y-6">
            @foreach($menuItems as $item)
                @php
                    $isActiveMobile = false;
                    if (isset($item['link']) && $item['link'] !== '#' && !str_starts_with($item['link'], '#')) {
                        $isActiveMobile = (url()->current() === $item['link']);
                    }
                    if (isset($item['sub'])) {
                        foreach ($item['sub'] as $sub) {
                            if (url()->current() === $sub['link']) {
                                $isActiveMobile = true;
                                break;
                            }
                        }
                    }
                @endphp
                <div class="border-b border-slate-100 pb-4 last:border-0">
                    <a href="{{ $item['link'] ?? '#' }}" {{ isset($item['sub']) || ($item['external'] ?? false) || str_starts_with($item['link'] ?? '', '#') ? '' : 'wire:navigate' }} @click="!{{ isset($item['sub']) ? 'true' : 'false' }} && $wire.toggleMenu()" class="flex items-center justify-between text-base font-bold uppercase tracking-wide {{ $isActiveMobile ? 'text-emerald-600' : 'text-slate-800 hover:text-emerald-600' }}">
                        <span>{{ $item['name'] }}</span>
                    </a>
                    @if(isset($item['sub']))
                        <div class="pl-4 space-y-2 mt-3 border-l-2 border-slate-100">
                            @foreach($item['sub'] as $sub)
                                @php
                                    $isSubActiveMobile = (url()->current() === $sub['link']);
                                    $isExternalSub = $sub['external'] ?? false;
                                @endphp
                                <a href="{{ $sub['link'] }}" {{ $isExternalSub ? '' : 'wire:navigate' }} @click="$wire.toggleMenu()" class="block py-1 text-sm font-semibold transition-colors {{ $isSubActiveMobile ? 'text-emerald-600 font-bold' : 'text-slate-500 hover:text-emerald-600' }}">
                                    {{ $sub['name'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</nav>
