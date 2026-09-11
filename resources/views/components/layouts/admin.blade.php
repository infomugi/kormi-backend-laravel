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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="bg-slate-50/60 text-slate-900 min-h-screen antialiased flex selection:bg-emerald-600 selection:text-white" x-data="{
    sidebarExpanded: localStorage.getItem('kormi_sidebar_expanded') !== 'false',
    mobileMenuOpen: false,
    toggleSidebar() {
        this.sidebarExpanded = !this.sidebarExpanded;
        localStorage.setItem('kormi_sidebar_expanded', this.sidebarExpanded);
    }
}">

    <!-- DESKTOP COLLAPSIBLE SIDEBAR: ULTRA PRO & PREMIUM KORMI EMERALD -->
    <aside
        class="hidden md:flex flex-col justify-between bg-gradient-to-b from-[#03261d] via-[#053d2e] to-[#021f17] text-white border-r border-emerald-800/40 sticky top-0 h-screen z-50 shrink-0 transition-all duration-300 ease-in-out select-none shadow-[4px_0_24px_rgba(0,0,0,0.25)] relative overflow-hidden"
        :class="sidebarExpanded ? 'w-68' : 'w-20'"
        x-data="{ menuSearch: '' }">

        <!-- Subtle Ambient Glow Overlay -->
        <div class="pointer-events-none absolute -top-24 -left-24 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 w-72 h-72 bg-lime-500/10 rounded-full blur-3xl"></div>

        <!-- Top Section: Header Brand & Search & Navigation -->
        <div class="flex flex-col flex-1 min-h-0 overflow-y-auto scrollbar-none relative z-10">

            <!-- Brand Header -->
            <div class="flex items-center px-4 h-20 shrink-0 border-b border-white/[0.08]"
                :class="sidebarExpanded ? 'justify-between' : 'justify-center'">
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3 overflow-hidden group">
                    <div
                        class="w-11 h-11 rounded-2xl bg-gradient-to-br from-white to-emerald-50 text-emerald-900 flex items-center justify-center p-2 shadow-lg shadow-black/30 group-hover:scale-105 group-hover:shadow-emerald-500/20 transition-all duration-200 shrink-0 border border-white/40 ring-2 ring-white/10">
                        <img src="{{ asset('assets/image/logo-kormi.png') }}"
                            class="w-full h-full object-contain" alt="Logo KORMI">
                    </div>
                    <div x-show="sidebarExpanded" x-transition.opacity.duration.200ms
                        class="whitespace-nowrap overflow-hidden">
                        <div class="flex items-center gap-1.5">
                            <span class="font-black text-white text-base leading-tight tracking-tight drop-shadow-xs">KORMI CMS</span>
                            <span class="text-[9px] font-black bg-gradient-to-r from-lime-400 to-emerald-400 text-slate-950 px-1.5 py-0.5 rounded-md uppercase tracking-wider shadow-xs">Bedas</span>
                        </div>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-lime-400 animate-pulse"></span>
                            <span class="text-[10px] font-bold text-emerald-200/80 uppercase tracking-widest">Kab. Bandung</span>
                        </div>
                    </div>
                </a>

                <!-- Toggle Collapse Button (when expanded) -->
                <button type="button" x-show="sidebarExpanded" @click="toggleSidebar()"
                    title="Perkecil Sidebar"
                    class="w-8 h-8 rounded-xl text-emerald-200/80 hover:text-white hover:bg-white/10 flex items-center justify-center transition-all duration-150 cursor-pointer border border-transparent hover:border-white/10">
                    <i data-lucide="chevrons-left" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Mini Expand Button (when collapsed) -->
            <div x-show="!sidebarExpanded" class="flex justify-center py-2 shrink-0">
                <button type="button" @click="toggleSidebar()" title="Perluas Sidebar"
                    class="w-10 h-8 rounded-xl text-emerald-200/80 hover:text-white hover:bg-white/10 flex items-center justify-center transition-all duration-150 cursor-pointer border border-transparent hover:border-white/10">
                    <i data-lucide="chevrons-right" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Quick Filter Bar (When Expanded) -->
            <div x-show="sidebarExpanded" x-transition.opacity.duration.200ms class="px-3 pt-3 pb-1 shrink-0">
                <div class="relative flex items-center">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-emerald-300/60 absolute left-3 pointer-events-none"></i>
                    <input type="text" x-model="menuSearch" placeholder="Cari menu..."
                        class="w-full bg-white/[0.06] hover:bg-white/[0.09] focus:bg-white/[0.12] border border-white/10 focus:border-lime-400/60 rounded-xl pl-8 pr-7 py-1.5 text-xs text-white placeholder-emerald-200/50 focus:outline-none focus:ring-1 focus:ring-lime-400/40 transition-all">
                    <button type="button" x-show="menuSearch.length > 0" @click="menuSearch = ''"
                        class="absolute right-2.5 text-emerald-300/70 hover:text-white text-xs">
                        <i data-lucide="x" class="w-3 h-3"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation Links Stack -->
            <nav class="flex flex-col gap-1 p-3 flex-1">

                @php
                    $user = auth()->user();
                    $isSuper = $user?->isSuperAdmin() ?? true;
                    $isEditor = $isSuper || ($user?->isEditorBerita() ?? false);
                    $isKorcam = $isSuper || ($user?->isAdminKorcam() ?? false);
                    $isInorga = $isSuper || ($user?->isAdminInorga() ?? false);
                @endphp

                <!-- Category: UTAMA -->
                <div x-show="sidebarExpanded && (!menuSearch || 'menu utama dashboard berita galeri publikasi unduhan'.includes(menuSearch.toLowerCase()))"
                    class="px-3 pt-3 pb-1 text-[10px] font-black uppercase tracking-widest text-emerald-400/70 flex items-center gap-2">
                    <span>Menu Utama</span>
                    <div class="flex-1 h-px bg-white/[0.08]"></div>
                </div>

                <!-- 1. Dashboard -->
                <div x-show="!menuSearch || 'dashboard beranda home statistik'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.dashboard') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.dashboard'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="layout-dashboard"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.dashboard') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Dashboard</span>
                        @if(request()->routeIs('admin.dashboard'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <!-- Floating Tooltip (Collapsed State) -->
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Dashboard
                    </div>
                </div>

                @if($isEditor)
                <!-- 2. Berita & Artikel -->
                <div x-show="!menuSearch || 'berita artikel publikasi kabar'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.berita') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.berita*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.berita*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="newspaper"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.berita*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Berita & Publikasi</span>
                        @if(request()->routeIs('admin.berita*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Berita & Publikasi
                    </div>
                </div>

                <!-- 3. Galeri Foto -->
                <div x-show="!menuSearch || 'galeri foto dokumentasi album visual'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.galeri') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.galeri*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.galeri*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="image"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.galeri*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Galeri Dokumentasi</span>
                        @if(request()->routeIs('admin.galeri*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Galeri Dokumentasi
                    </div>
                </div>

                <!-- 4. Dokumen Unduhan -->
                <div x-show="!menuSearch || 'dokumen unduhan download berkas surat pdf sk'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.unduhan') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.unduhan*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.unduhan*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="file-down"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.unduhan*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Dokumen Unduhan</span>
                        @if(request()->routeIs('admin.unduhan*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Dokumen Unduhan
                    </div>
                </div>
                @endif

                @if($isKorcam || $isInorga)
                <!-- Category: KEOLAHRAGAAN -->
                <div x-show="sidebarExpanded && (!menuSearch || 'keolahragaan duta inorga komisi klasemen medali sapras sarana sdi pelatihan apmo anugerah'.includes(menuSearch.toLowerCase()))"
                    class="px-3 pt-4 pb-1 text-[10px] font-black uppercase tracking-widest text-emerald-400/70 flex items-center gap-2">
                    <span>Keolahragaan & Data</span>
                    <div class="flex-1 h-px bg-white/[0.08]"></div>
                </div>
                @endif

                @if($isKorcam)
                <!-- 5. Duta Olahraga -->
                <div x-show="!menuSearch || 'duta olahraga atlet pegiat peraih'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.duta') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.duta*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.duta*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="user-check"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.duta*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Duta Olahraga</span>
                        @if(request()->routeIs('admin.duta*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Duta Olahraga
                    </div>
                </div>

                <!-- 8. Sarana & Prasarana -->
                <div x-show="!menuSearch || 'sarana prasarana sapras fasilitas venue lapangan gedung'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.sapras') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.sapras*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.sapras*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="map-pin"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.sapras*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Sarana & Prasarana</span>
                        @if(request()->routeIs('admin.sapras*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Sarana & Prasarana
                    </div>
                </div>

                <!-- Kordik Kecamatan -->
                <div x-show="!menuSearch || 'kordik koordinator kecamatan'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.kordik') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.kordik*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.kordik*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="map-pin" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.kordik*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Kordik Kecamatan</span>
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">Kordik Kecamatan</div>
                </div>
                @endif

                @if($isInorga)
                <!-- 6. Inorga & Komisi -->
                <div x-show="!menuSearch || 'inorga komisi induk organisasi olahraga tradisional petualangan kesehatan kebugaran'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.inorga') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.inorga*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.inorga*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="boxes"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.inorga*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Inorga & Komisi</span>
                        @if(request()->routeIs('admin.inorga*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Inorga & Komisi
                    </div>
                </div>

                <!-- 7. Kelola Event -->
                <div x-show="!menuSearch || 'event forkab forda fornas jadwal cabang kategori lomba pertandingan'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.event') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.event*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.event*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="calendar"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.event*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Kelola Event</span>
                        @if(request()->routeIs('admin.event*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Kelola Event
                    </div>
                </div>

                <!-- 7. Klasemen Medali -->
                <div x-show="!menuSearch || 'klasemen medali fornas forda forprov juara emas perak perunggu'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.klasemen') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.klasemen*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.klasemen*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="trophy"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.klasemen*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Klasemen Medali</span>
                        @if(request()->routeIs('admin.klasemen*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Klasemen Medali
                    </div>
                </div>
                @endif

                @if($isSuper)
                <!-- 9. Pelatihan & Sertifikasi SDI -->
                <div x-show="!menuSearch || 'pelatihan sertifikasi sdi instruktur juri wasit sumber daya'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.sdi') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.sdi*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.sdi*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="graduation-cap"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.sdi*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Pelatihan & SDI</span>
                        @if(request()->routeIs('admin.sdi*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Pelatihan & SDI
                    </div>
                </div>

                <!-- 10. Anugerah APMO -->
                <div x-show="!menuSearch || 'anugerah apmo penghargaan tokoh penggerak apresiasi'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.apmo') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.apmo*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.apmo*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="award"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.apmo*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Anugerah APMO</span>
                        @if(request()->routeIs('admin.apmo*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Anugerah APMO
                    </div>
                </div>

                <!-- Category: SISTEM & PENGATURAN -->
                <div x-show="sidebarExpanded && (!menuSearch || 'sistem pengaturan pengguna user admin hak akses'.includes(menuSearch.toLowerCase()))"
                    class="px-3 pt-4 pb-1 text-[10px] font-black uppercase tracking-widest text-emerald-400/70 flex items-center gap-2">
                    <span>Sistem & Akses</span>
                    <div class="flex-1 h-px bg-white/[0.08]"></div>
                </div>

                <!-- 11. Kelola Pengguna -->
                <div x-show="!menuSearch || 'pengguna user admin akun'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.pengguna') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.pengguna*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.pengguna*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="users-round"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.pengguna*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Kelola Pengguna</span>
                        @if(request()->routeIs('admin.pengguna*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Kelola Pengguna
                    </div>
                </div>

                <!-- 12. Peran & Hak Akses -->
                <div x-show="!menuSearch || 'peran role hak akses permission wewenang rbac'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.peran') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.peran*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.peran*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="shield-check"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.peran*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Peran & Hak Akses</span>
                        @if(request()->routeIs('admin.peran*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                        Peran & Hak Akses
                    </div>
                </div>

                <!-- DIVIDER: ORGANISASI -->
                <div class="flex items-center gap-2 pt-3 pb-1" x-show="sidebarExpanded && (!menuSearch || 'organisasi sejarah visi misi pengurus kordik proker pengaturan'.includes(menuSearch.toLowerCase()))">
                    <span class="text-[10px] font-black text-emerald-400/60 uppercase tracking-widest">Organisasi</span>
                    <div class="flex-1 h-px bg-white/[0.08]"></div>
                </div>

                <!-- Sejarah -->
                <div x-show="!menuSearch || 'sejarah timeline linimasa'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.sejarah') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.sejarah*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.sejarah*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="clock" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.sejarah*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Sejarah</span>
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">Sejarah</div>
                </div>

                <!-- Visi & Misi -->
                <div x-show="!menuSearch || 'visi misi motto nilai tujuan'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.visimisi') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.visimisi*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.visimisi*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="target" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.visimisi*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Visi & Misi</span>
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">Visi & Misi</div>
                </div>

                <!-- Pengurus -->
                <div x-show="!menuSearch || 'pengurus struktur jabatan'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.pengurus') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.pengurus*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.pengurus*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="user-check" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.pengurus*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Pengurus</span>
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">Pengurus</div>
                </div>

                <!-- Program Kerja -->
                <div x-show="!menuSearch || 'program kerja proker kegiatan'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.proker') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.proker*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.proker*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="clipboard-list" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.proker*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Program Kerja</span>
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">Program Kerja</div>
                </div>

                <!-- DIVIDER: PENGATURAN -->
                <div class="flex items-center gap-2 pt-3 pb-1" x-show="sidebarExpanded && (!menuSearch || 'pengaturan konfigurasi setting'.includes(menuSearch.toLowerCase()))">
                    <span class="text-[10px] font-black text-emerald-400/60 uppercase tracking-widest">Konfigurasi</span>
                    <div class="flex-1 h-px bg-white/[0.08]"></div>
                </div>

                <!-- Pengaturan Situs -->
                <div x-show="!menuSearch || 'pengaturan situs konfigurasi setting kontak sosmed'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.pengaturan') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.pengaturan*') ? 'bg-white text-emerald-950 font-black shadow-lg shadow-black/25 ring-1 ring-white/80' : 'text-emerald-100/85 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.pengaturan*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-lime-500 rounded-r-md"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="settings" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.pengaturan*') ? 'text-emerald-700' : 'text-emerald-300/90 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Pengaturan Situs</span>
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">Pengaturan Situs</div>
                </div>
                @endif

            </nav>
        </div>

        <!-- Bottom Footer Section: Profile & Actions -->
        <div class="p-3 border-t border-white/[0.08] bg-black/25 flex flex-col gap-2 shrink-0 relative z-10">

            <!-- Quick View Portal Button -->
            <div class="relative group">
                <a href="{{ route('beranda') }}" target="_blank"
                    class="flex items-center rounded-xl font-bold text-xs bg-white/[0.07] hover:bg-white/[0.14] text-emerald-100 hover:text-white transition-all duration-150 border border-white/10 shadow-xs"
                    :class="sidebarExpanded ? 'px-3 py-2 gap-2.5' : 'w-11 h-10 justify-center mx-auto'">
                    <i data-lucide="external-link" class="w-3.5 h-3.5 shrink-0 text-lime-400"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Buka Portal Publik</span>
                </a>
                <div x-show="!sidebarExpanded"
                    class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-slate-900/95 text-white text-xs font-bold rounded-lg shadow-xl border border-white/10 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                    Buka Portal Publik
                </div>
            </div>

            <!-- User Profile & Logout Box -->
            <div class="flex items-center rounded-2xl p-2 bg-white/[0.08] border border-white/15 backdrop-blur-md shadow-lg shadow-black/20"
                :class="sidebarExpanded ? 'justify-between' : 'justify-center'">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="relative shrink-0">
                        <div
                            class="w-8.5 h-8.5 rounded-xl bg-gradient-to-br from-lime-400 to-emerald-400 text-slate-950 flex items-center justify-center font-black text-xs shadow-md">
                            {{ strtoupper(substr(auth()->user()?->nama_lengkap ?? 'AD', 0, 2)) }}
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-lime-400 border-2 border-emerald-950 rounded-full"></span>
                    </div>
                    <div x-show="sidebarExpanded" class="min-w-0">
                        <p class="text-xs font-extrabold text-white truncate leading-tight">
                            {{ auth()->user()?->nama_lengkap ?? 'Administrator' }}</p>
                        <p class="text-[10px] font-semibold text-emerald-200/80 capitalize truncate">
                            {{ auth()->user()?->peran?->nama_peran ?? 'Super Administrator' }}</p>
                    </div>
                </div>

                <!-- Logout Button (Expanded) -->
                <form action="{{ route('admin.keluar') }}" method="POST" class="shrink-0"
                    :class="sidebarExpanded ? '' : 'hidden'">
                    @csrf
                    <button type="submit" title="Keluar dari CMS"
                        class="p-1.5 rounded-xl text-emerald-200/70 hover:text-rose-300 hover:bg-rose-500/20 transition-all duration-150 cursor-pointer">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>

            <!-- Mini Logout when collapsed -->
            <div x-show="!sidebarExpanded" class="flex justify-center relative group">
                <form action="{{ route('admin.keluar') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-10 h-10 rounded-xl text-emerald-200/70 hover:text-rose-300 hover:bg-rose-500/20 flex items-center justify-center transition-all duration-150 cursor-pointer border border-transparent hover:border-rose-500/30">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
                <div
                    class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2.5 py-1 bg-rose-950 text-rose-200 text-xs font-bold rounded-lg shadow-xl border border-rose-800 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap">
                    Keluar
                </div>
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
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center p-1.5">
                    <img src="{{ asset('assets/image/logo-kormi.png') }}"
                        class="w-full h-full object-contain brightness-200" alt="Logo KORMI">
                </div>
                <span class="font-black text-slate-900 text-base">KORMI CMS</span>
            </div>
            <a href="{{ route('beranda') }}" target="_blank"
                class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold text-xs">Portal</a>
        </header>

        <!-- MOBILE MENU DRAWER -->
        <div x-show="mobileMenuOpen"
            class="md:hidden bg-gradient-to-b from-[#064e3b] via-[#047857] to-[#022c22] text-white border-b border-emerald-800/80 px-4 py-4 space-y-1 shadow-2xl" style="display: none;">
            <a href="{{ route('admin.dashboard') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="home" class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Dashboard
            </a>

            @if($isEditor)
            <a href="{{ route('admin.berita') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.berita*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="newspaper" class="w-4 h-4 {{ request()->routeIs('admin.berita*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Berita & Artikel
            </a>
            <a href="{{ route('admin.galeri') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.galeri*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="image" class="w-4 h-4 {{ request()->routeIs('admin.galeri*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Galeri Foto
            </a>
            <a href="{{ route('admin.unduhan') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.unduhan*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="book-open" class="w-4 h-4 {{ request()->routeIs('admin.unduhan*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Dokumen Unduhan
            </a>
            @endif

            @if($isKorcam)
            <a href="{{ route('admin.duta') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.duta*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="user-check" class="w-4 h-4 {{ request()->routeIs('admin.duta*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Duta Olahraga
            </a>
            <a href="{{ route('admin.sapras') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.sapras*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="map-pin" class="w-4 h-4 {{ request()->routeIs('admin.sapras*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Sarana & Prasarana
            </a>
            <a href="{{ route('admin.kordik') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.kordik*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="network" class="w-4 h-4"></i> Kordik Kecamatan
            </a>
            @endif

            @if($isInorga)
            <a href="{{ route('admin.inorga') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.inorga*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="pie-chart" class="w-4 h-4 {{ request()->routeIs('admin.inorga*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Inorga & Komisi
            </a>
            <a href="{{ route('admin.event') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.event*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="calendar" class="w-4 h-4 {{ request()->routeIs('admin.event*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Kelola Event
            </a>
            <a href="{{ route('admin.klasemen') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.klasemen*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="trophy" class="w-4 h-4 {{ request()->routeIs('admin.klasemen*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Klasemen Medali
            </a>
            @endif

            @if($isSuper)
            <a href="{{ route('admin.sdi') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.sdi*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="graduation-cap" class="w-4 h-4 {{ request()->routeIs('admin.sdi*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Pelatihan SDI
            </a>
            <a href="{{ route('admin.apmo') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.apmo*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="award" class="w-4 h-4 {{ request()->routeIs('admin.apmo*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Anugerah APMO
            </a>
            <a href="{{ route('admin.pengguna') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.pengguna*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="users" class="w-4 h-4 {{ request()->routeIs('admin.pengguna*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Kelola Pengguna
            </a>
            <a href="{{ route('admin.peran') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-sm {{ request()->routeIs('admin.peran*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="shield-check" class="w-4 h-4 {{ request()->routeIs('admin.peran*') ? 'text-emerald-700' : 'text-emerald-300' }}"></i> Peran & Hak Akses
            </a>
            <div class="pt-2 border-t border-white/10 my-1">
                <p class="px-4 text-[10px] font-black text-emerald-300/60 uppercase tracking-widest mb-1">Organisasi & Web</p>
            </div>
            <a href="{{ route('admin.sejarah') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2 rounded-xl font-bold text-sm {{ request()->routeIs('admin.sejarah*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="history" class="w-4 h-4"></i> Sejarah
            </a>
            <a href="{{ route('admin.visimisi') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2 rounded-xl font-bold text-sm {{ request()->routeIs('admin.visimisi*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="target" class="w-4 h-4"></i> Visi & Misi
            </a>
            <a href="{{ route('admin.pengurus') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2 rounded-xl font-bold text-sm {{ request()->routeIs('admin.pengurus*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="user-check" class="w-4 h-4"></i> Pengurus
            </a>
            <a href="{{ route('admin.proker') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2 rounded-xl font-bold text-sm {{ request()->routeIs('admin.proker*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="check-square" class="w-4 h-4"></i> Program Kerja
            </a>
            <a href="{{ route('admin.pengaturan') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-4 py-2 rounded-xl font-bold text-sm {{ request()->routeIs('admin.pengaturan*') ? 'bg-white text-emerald-950 font-black shadow-md' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="settings" class="w-4 h-4"></i> Pengaturan Situs
            </a>
            @endif
        </div>

        <!-- MAIN FULL WIDTH CONTENT CONTAINER -->
        <main class="w-full flex-1 p-4 sm:p-6 lg:p-8 min-w-0">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>

</html>
