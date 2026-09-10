<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

<body class="bg-slate-50/60 text-slate-900 min-h-screen antialiased flex" x-data="{
    sidebarExpanded: localStorage.getItem('kormi_sidebar_expanded') !== 'false',
    mobileMenuOpen: false,
    toggleSidebar() {
        this.sidebarExpanded = !this.sidebarExpanded;
        localStorage.setItem('kormi_sidebar_expanded', this.sidebarExpanded);
    }
}">

    <!-- DESKTOP COLLAPSIBLE SIDEBAR -->
    <aside
        class="hidden md:flex flex-col justify-between bg-white border-r border-slate-200/80 sticky top-0 h-screen z-50 shrink-0 transition-all duration-300 ease-in-out select-none"
        :class="sidebarExpanded ? 'w-64' : 'w-20'">
        <!-- Top Section: Header Brand & Search & Navigation -->
        <div class="flex flex-col flex-1 min-h-0 overflow-y-auto scrollbar-none">

            <!-- Brand Header -->
            <div class="flex items-center px-4 h-20 shrink-0 border-b border-slate-100"
                :class="sidebarExpanded ? 'justify-between' : 'justify-center'">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 overflow-hidden group">
                    <div
                        class="w-11 h-11 rounded-2xl bg-indigo-600 text-white flex items-center justify-center p-2 shadow-md shadow-indigo-600/20 group-hover:scale-105 transition-transform shrink-0">
                        <img src="{{ asset('assets/image/logo-kormi.png') }}"
                            class="w-full h-full object-contain brightness-200" alt="Logo KORMI">
                    </div>
                    <div x-show="sidebarExpanded" x-transition.opacity.duration.200ms
                        class="whitespace-nowrap overflow-hidden">
                        <div class="font-black text-slate-900 text-base leading-tight tracking-tight">KORMI CMS</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kabupaten Bandung
                        </div>
                    </div>
                </a>

                <!-- Toggle Collapse Button (when expanded) -->
                <button type="button" x-show="sidebarExpanded" @click="toggleSidebar()"
                    title="Perkecil Sidebar"
                    class="w-8 h-8 rounded-xl text-slate-400 hover:text-slate-800 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer">
                    <i data-lucide="chevrons-left" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Mini Expand Button (when collapsed) -->
            <div x-show="!sidebarExpanded" class="flex justify-center py-2 shrink-0">
                <button type="button" @click="toggleSidebar()" title="Perluas Sidebar"
                    class="w-10 h-8 rounded-xl text-slate-400 hover:text-slate-800 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer">
                    <i data-lucide="chevrons-right" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Navigation Links Stack -->
            <nav class="flex flex-col gap-1.5 p-3 flex-1">

                <!-- Category: UTAMA -->
                <div x-show="sidebarExpanded"
                    class="px-3 pt-3 pb-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                    Menu Utama
                </div>

                <!-- 1. Dashboard -->
                <a href="{{ route('admin.dashboard') }}" wire:navigate title="Dashboard"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="home"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Dashboard</span>
                </a>

                <!-- 2. Berita & Artikel -->
                <a href="{{ route('admin.berita') }}" wire:navigate title="Berita & Artikel"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.berita*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="newspaper"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.berita*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Berita & Publikasi</span>
                </a>

                <!-- 3. Galeri Foto -->
                <a href="{{ route('admin.galeri') }}" wire:navigate title="Galeri Dokumentasi"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.galeri*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="image"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.galeri*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Galeri Dokumentasi</span>
                </a>

                <!-- 4. Dokumen Unduhan -->
                <a href="{{ route('admin.unduhan') }}" wire:navigate title="Dokumen Unduhan"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.unduhan*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="book-open"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.unduhan*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Dokumen Unduhan</span>
                </a>

                <!-- Category: KEOLAHRAGAAN -->
                <div x-show="sidebarExpanded"
                    class="px-3 pt-4 pb-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                    Keolahragaan & Organisasi
                </div>

                <!-- 5. Duta Olahraga -->
                <a href="{{ route('admin.duta') }}" wire:navigate title="Duta Olahraga"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.duta*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="user-check"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.duta*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Duta Olahraga</span>
                </a>

                <!-- 6. Inorga & Komisi -->
                <a href="{{ route('admin.inorga') }}" wire:navigate title="Inorga & Komisi"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.inorga*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="pie-chart"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.inorga*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Inorga & Komisi</span>
                </a>

                <!-- 7. Klasemen Medali -->
                <a href="{{ route('admin.klasemen') }}" wire:navigate title="Klasemen Medali"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.klasemen*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="trophy"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.klasemen*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Klasemen Medali</span>
                </a>

                <!-- 8. Sarana & Prasarana -->
                <a href="{{ route('admin.sapras') }}" wire:navigate title="Sarana & Prasarana"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.sapras*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="map-pin"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.sapras*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Sarana & Prasarana</span>
                </a>

                <!-- 9. Pelatihan & Sertifikasi SDI -->
                <a href="{{ route('admin.sdi') }}" wire:navigate title="Pelatihan & Sertifikasi SDI"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.sdi*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="graduation-cap"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.sdi*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Pelatihan & SDI</span>
                </a>

                <!-- 10. Anugerah APMO -->
                <a href="{{ route('admin.apmo') }}" wire:navigate title="Anugerah APMO"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.apmo*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="award"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.apmo*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Anugerah APMO</span>
                </a>

                <!-- Category: SISTEM & PENGATURAN -->
                <div x-show="sidebarExpanded"
                    class="px-3 pt-4 pb-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                    Sistem
                </div>

                <!-- 11. Kelola Pengguna -->
                <a href="{{ route('admin.pengguna') }}" wire:navigate title="Kelola Pengguna CMS"
                    class="group flex items-center rounded-2xl font-bold text-sm transition-all {{ request()->routeIs('admin.pengguna*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                    :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                    <i data-lucide="users"
                        class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.pengguna*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-900' }}"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Kelola Pengguna</span>
                </a>

            </nav>
        </div>

        <!-- Bottom Footer Section: Profile & Actions -->
        <div class="p-3 border-t border-slate-100 bg-slate-50/50 flex flex-col gap-2 shrink-0">

            <!-- Quick View Portal Button -->
            <a href="{{ route('beranda') }}" target="_blank" title="Buka Portal Publik"
                class="flex items-center rounded-2xl font-bold text-xs bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors"
                :class="sidebarExpanded ? 'px-3.5 py-2.5 gap-2.5' : 'w-11 h-11 justify-center mx-auto'">
                <i data-lucide="external-link" class="w-4 h-4 shrink-0"></i>
                <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Buka Portal Publik</span>
            </a>

            <!-- User Profile & Logout Box -->
            <div class="flex items-center rounded-2xl p-2 bg-white border border-slate-200/80 shadow-2xs"
                :class="sidebarExpanded ? 'justify-between' : 'justify-center'">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div
                        class="w-8 h-8 rounded-xl bg-amber-200 text-amber-900 flex items-center justify-center font-extrabold text-xs shrink-0">
                        {{ strtoupper(substr(auth()->user()?->nama_lengkap ?? 'AD', 0, 2)) }}
                    </div>
                    <div x-show="sidebarExpanded" class="min-w-0">
                        <p class="text-xs font-bold text-slate-900 truncate leading-tight">
                            {{ auth()->user()?->nama_lengkap ?? 'Administrator' }}</p>
                        <p class="text-[10px] text-slate-400 capitalize truncate">
                            {{ auth()->user()?->peran?->nama_peran ?? 'Super Administrator' }}</p>
                    </div>
                </div>

                <!-- Logout Button -->
                <form action="{{ route('admin.keluar') }}" method="POST" class="shrink-0"
                    :class="sidebarExpanded ? '' : 'hidden'">
                    @csrf
                    <button type="submit" title="Keluar dari CMS"
                        class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>

            <!-- Mini Logout when collapsed -->
            <div x-show="!sidebarExpanded" class="flex justify-center">
                <form action="{{ route('admin.keluar') }}" method="POST">
                    @csrf
                    <button type="submit" title="Keluar"
                        class="w-10 h-10 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-colors cursor-pointer">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>

        </div>
    </aside>

    <!-- RIGHT MAIN WORKSPACE -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- TOP MOBILE BAR -->
        <header
            class="md:hidden flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200/80 sticky top-0 z-40">
            <div class="flex items-center gap-3">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="p-2 rounded-xl text-slate-700 hover:bg-slate-100 focus:outline-none cursor-pointer">
                    <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
                    <i data-lucide="x" class="w-6 h-6" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
                <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center p-1.5">
                    <img src="{{ asset('assets/image/logo-kormi.png') }}"
                        class="w-full h-full object-contain brightness-200" alt="Logo KORMI">
                </div>
                <span class="font-black text-slate-900 text-base">KORMI CMS</span>
            </div>
            <a href="{{ route('beranda') }}" target="_blank"
                class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-700 font-bold text-xs">Portal</a>
        </header>

        <!-- MOBILE MENU DRAWER -->
        <div x-show="mobileMenuOpen"
            class="md:hidden bg-white border-b border-slate-200 px-6 py-4 space-y-1 shadow-lg" style="display: none;">
            <a href="{{ route('admin.dashboard') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="home" class="w-4 h-4"></i> Dashboard
            </a>
            <a href="{{ route('admin.berita') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.berita*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="newspaper" class="w-4 h-4"></i> Berita & Artikel
            </a>
            <a href="{{ route('admin.galeri') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.galeri*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="image" class="w-4 h-4"></i> Galeri Foto
            </a>
            <a href="{{ route('admin.unduhan') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.unduhan*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="book-open" class="w-4 h-4"></i> Dokumen Unduhan
            </a>
            <a href="{{ route('admin.duta') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.duta*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="user-check" class="w-4 h-4"></i> Duta Olahraga
            </a>
            <a href="{{ route('admin.inorga') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.inorga*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="pie-chart" class="w-4 h-4"></i> Inorga & Komisi
            </a>
            <a href="{{ route('admin.klasemen') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.klasemen*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="trophy" class="w-4 h-4"></i> Klasemen Medali
            </a>
            <a href="{{ route('admin.sapras') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.sapras*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="map-pin" class="w-4 h-4"></i> Sarana & Prasarana
            </a>
            <a href="{{ route('admin.sdi') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.sdi*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="graduation-cap" class="w-4 h-4"></i> Pelatihan SDI
            </a>
            <a href="{{ route('admin.apmo') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.apmo*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-lucide="award" class="w-4 h-4"></i> Anugerah APMO
            </a>
            <a href="{{ route('admin.pengguna') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.pengguna*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
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
