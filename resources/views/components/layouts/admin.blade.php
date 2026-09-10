<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KORMI CMS - Kabupaten Bandung' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/image/favicon.ico') }}">
    
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="bg-slate-50/60 text-slate-900 min-h-screen antialiased flex" x-data="{ mobileMenuOpen: false }">
    
    <!-- LEFT MINI ICON SIDEBAR (EXACTLY LIKE REFERENCE) -->
    <aside class="hidden md:flex flex-col items-center justify-between w-20 py-6 bg-white border-r border-slate-200/80 sticky top-0 h-screen z-50 shrink-0">
        <!-- Top Logo & Main Nav -->
        <div class="flex flex-col items-center gap-7 w-full">
            <!-- Brand Mark -->
            <a href="{{ route('admin.dashboard') }}" wire:navigate.hover class="w-11 h-11 rounded-2xl bg-indigo-600 text-white flex items-center justify-center p-2 shadow-md shadow-indigo-600/20 hover:scale-105 transition-transform">
                <img src="{{ asset('assets/image/logo-kormi.png') }}" class="w-full h-full object-contain brightness-200" alt="Logo KORMI">
            </a>

            <!-- Navigation Icons Stack -->
            <nav class="flex flex-col items-center gap-3 w-full px-3">
                <a href="{{ route('admin.dashboard') }}" wire:navigate.hover title="Dashboard" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="home" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('admin.berita') }}" wire:navigate.hover title="Berita & Artikel" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.berita*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="newspaper" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('admin.galeri') }}" wire:navigate.hover title="Galeri Dokumentasi" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.galeri*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="image" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('admin.unduhan') }}" wire:navigate.hover title="Dokumen Unduhan" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.unduhan*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('admin.duta') }}" wire:navigate.hover title="Duta Olahraga" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.duta*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('admin.inorga') }}" wire:navigate.hover title="Inorga & Komisi" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.inorga*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="pie-chart" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('admin.klasemen') }}" wire:navigate.hover title="Klasemen Medali" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.klasemen*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="trophy" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('admin.sapras') }}" wire:navigate.hover title="Sarana & Prasarana" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.sapras*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('admin.sdi') }}" wire:navigate.hover title="Pelatihan & Sertifikasi SDI" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.sdi*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('admin.apmo') }}" wire:navigate.hover title="Anugerah APMO" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.apmo*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('admin.pengguna') }}" wire:navigate.hover title="Kelola Pengguna CMS" class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all {{ request()->routeIs('admin.pengguna*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </a>
            </nav>
        </div>

        <!-- Bottom Stack (Portal, Help, User Avatar) -->
        <div class="flex flex-col items-center gap-3 w-full px-3">
            <a href="{{ route('beranda') }}" target="_blank" title="Buka Portal Publik" class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-700 shadow-sm transition-colors">
                <i data-lucide="plus" class="w-5 h-5"></i>
            </a>

            <div class="w-10 h-10 rounded-2xl bg-amber-400 text-slate-900 flex items-center justify-center font-black text-xs shadow-xs">
                <i data-lucide="zap" class="w-4 h-4 fill-slate-900"></i>
            </div>

            <form action="{{ route('admin.keluar') }}" method="POST" class="w-full flex justify-center">
                @csrf
                <button type="submit" title="Keluar" class="w-10 h-10 rounded-2xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-colors">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>

            <a href="{{ route('admin.pengguna') }}" wire:navigate.hover title="{{ auth()->user()?->nama_lengkap ?? 'Administrator' }}" class="w-10 h-10 rounded-2xl bg-amber-200 text-amber-900 flex items-center justify-center font-extrabold text-xs hover:ring-2 hover:ring-indigo-500 transition-all">
                {{ strtoupper(substr(auth()->user()?->nama_lengkap ?? 'AD', 0, 2)) }}
            </a>
        </div>
    </aside>

    <!-- RIGHT MAIN WORKSPACE -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- TOP MOBILE BAR -->
        <header class="md:hidden flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200/80 sticky top-0 z-40">
            <div class="flex items-center gap-3">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-xl text-slate-700 hover:bg-slate-100 focus:outline-none">
                    <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
                    <i data-lucide="x" class="w-6 h-6" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
                <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center p-1.5">
                    <img src="{{ asset('assets/image/logo-kormi.png') }}" class="w-full h-full object-contain brightness-200" alt="Logo KORMI">
                </div>
                <span class="font-black text-slate-900 text-base">KORMI CMS</span>
            </div>
            <a href="{{ route('beranda') }}" target="_blank" class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-700 font-bold text-xs">Portal</a>
        </header>

        <!-- MOBILE MENU DRAWER -->
        <div x-show="mobileMenuOpen" class="md:hidden bg-white border-b border-slate-200 px-6 py-4 space-y-1 shadow-lg" style="display: none;">
            <a href="{{ route('admin.dashboard') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="home" class="w-4 h-4"></i> Dashboard
            </a>
            <a href="{{ route('admin.berita') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.berita*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="newspaper" class="w-4 h-4"></i> Berita & Artikel
            </a>
            <a href="{{ route('admin.galeri') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.galeri*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="image" class="w-4 h-4"></i> Galeri Foto
            </a>
            <a href="{{ route('admin.unduhan') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.unduhan*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="book-open" class="w-4 h-4"></i> Dokumen Unduhan
            </a>
            <a href="{{ route('admin.duta') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.duta*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="user-check" class="w-4 h-4"></i> Duta Olahraga
            </a>
            <a href="{{ route('admin.inorga') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.inorga*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="pie-chart" class="w-4 h-4"></i> Inorga & Komisi
            </a>
            <a href="{{ route('admin.klasemen') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.klasemen*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="trophy" class="w-4 h-4"></i> Klasemen Medali
            </a>
            <a href="{{ route('admin.sapras') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.sapras*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="map-pin" class="w-4 h-4"></i> Sarana & Prasarana
            </a>
            <a href="{{ route('admin.sdi') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.sdi*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="graduation-cap" class="w-4 h-4"></i> Pelatihan SDI
            </a>
            <a href="{{ route('admin.apmo') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.apmo*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="award" class="w-4 h-4"></i> Anugerah APMO
            </a>
            <a href="{{ route('admin.pengguna') }}" wire:navigate.hover @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.pengguna*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="users" class="w-4 h-4"></i> Kelola Pengguna
            </a>
        </div>

        <!-- MAIN FULL WIDTH CONTENT CONTAINER -->
        <main class="w-full flex-1 p-6 sm:p-8 lg:p-10 max-w-[1700px]">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>

