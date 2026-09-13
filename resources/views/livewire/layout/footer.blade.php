<footer id="footer" class="{{ auth()->check() ? 'hidden md:block' : '' }} bg-slate-900 text-slate-300 pt-16 pb-10 relative overflow-hidden border-t border-slate-800">
    <!-- Top accent bar -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-lime-400"></div>
    
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-slate-800">
            <!-- Brand & Info -->
            <div class="lg:col-span-4 space-y-4 text-left">
                <a href="{{ route('beranda') }}" wire:navigate class="flex items-center gap-3 group">
                    <img src="{{ asset('assets/image/logo-kormi.png') }}" class="w-10 h-10 object-contain group-hover:scale-105 transition-transform" alt="Logo Kormi" />
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-black tracking-tight text-white">KORMI</span>
                            <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-wider border border-emerald-500/30">Kab. Bandung</span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Komite Olahraga Masyarakat</p>
                    </div>
                </a>
                <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                    {{ $deskripsiSitus }}
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <img src="{{ asset('assets/image/logo-kab-bandung.png') }}" class="h-6 object-contain opacity-70 hover:opacity-100 transition-opacity" alt="Logo Kab Bandung" />
                    <div class="w-px h-4 bg-slate-700"></div>
                    <img src="{{ asset('assets/image/logo-bedas.png') }}" class="h-6 object-contain opacity-70 hover:opacity-100 transition-opacity" alt="Logo Bedas" />
                </div>
            </div>

            <!-- Layanan Cepat -->
            <div class="lg:col-span-2 space-y-4 text-left">
                <h5 class="text-xs font-black uppercase tracking-wider text-white border-l-2 border-emerald-500 pl-3">Navigasi</h5>
                <ul class="space-y-2.5 text-xs text-slate-400 font-semibold">
                    @foreach($footerLinks as $link)
                        <li>
                            <a href="{{ $link['tautan'] }}" target="{{ $link['target'] }}" {{ $link['external'] ? '' : 'wire:navigate' }} class="hover:text-emerald-400 transition-colors flex items-center gap-1.5">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-emerald-500"></i>
                                <span>{{ $link['nama'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Alamat Kontak -->
            <div class="lg:col-span-3 space-y-4 text-left">
                <h5 class="text-xs font-black uppercase tracking-wider text-white border-l-2 border-emerald-500 pl-3">Sekretariat</h5>
                <div class="space-y-3 text-xs text-slate-400">
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5"></i>
                        <span class="leading-relaxed">{{ $alamatKantor }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="phone" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                        <span>{{ $teleponKantor }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="mail" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                        <span>{{ $emailKantor }}</span>
                    </div>
                </div>
            </div>

            <!-- Media Sosial & Link Resmi -->
            <div class="lg:col-span-3 space-y-4 text-left">
                <h5 class="text-xs font-black uppercase tracking-wider text-white border-l-2 border-emerald-500 pl-3">Media Sosial</h5>
                <p class="text-xs text-slate-400">Ikuti kegiatan dan pembaruan seputar KORMI Kabupaten Bandung.</p>
                <div class="flex items-center gap-2.5 pt-1">
                    <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-emerald-600 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-200 border border-slate-700/60 shadow-sm" title="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-200 border border-slate-700/60 shadow-sm" title="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="{{ $youtube }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-red-600 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-200 border border-slate-700/60 shadow-sm" title="YouTube">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
            <p class="text-[11px] font-semibold text-slate-500">
                &copy; {{ date('Y') }} <span class="text-slate-400 font-bold">KORMI Kabupaten Bandung</span>. Hak cipta dilindungi.
            </p>
            <div class="flex flex-wrap items-center justify-center sm:justify-end gap-3 sm:gap-4 text-[11px] text-slate-500">
                <a href="{{ route('visimisi') }}" wire:navigate class="hover:text-slate-400 transition-colors">Tentang Kami</a>
                <span>•</span>
                <a href="{{ route('kontak') }}" wire:navigate class="hover:text-slate-400 transition-colors">Kontak</a>
                <span>•</span>
                @auth
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="text-emerald-400 hover:text-emerald-300 font-bold transition-colors flex items-center gap-1">
                        <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                        <span>Dashboard</span>
                    </a>
                    <span>•</span>
                    <form action="{{ route('admin.keluar') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-rose-400 hover:text-rose-300 font-bold transition-colors cursor-pointer flex items-center gap-1">
                            <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-emerald-500 hover:text-emerald-400 font-bold transition-colors">Portal Admin</a>
                @endauth
            </div>
        </div>
    </div>
</footer>

