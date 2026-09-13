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

        /* iOS Liquid Glass Dynamics */
        @keyframes iosLiquidPulse {
            0% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
            33% {
                transform: translate(12px, -8px) scale(1.12) rotate(120deg);
            }
            66% {
                transform: translate(-10px, 6px) scale(0.92) rotate(240deg);
            }
            100% {
                transform: translate(0, 0) scale(1) rotate(360deg);
            }
        }

        @keyframes iosMeshShimmer {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .ios-liquid-dock {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(28px) saturate(210%);
            -webkit-backdrop-filter: blur(28px) saturate(210%);
            border: 1px solid rgba(255, 255, 255, 0.85);
            box-shadow: 
                0 20px 40px -10px rgba(2, 44, 34, 0.15),
                0 1px 3px 0 rgba(0, 0, 0, 0.04),
                inset 0 1px 1px 0 rgba(255, 255, 255, 0.9),
                inset 0 -1px 2px 0 rgba(0, 0, 0, 0.03);
        }

        .ios-liquid-orb-1 {
            animation: iosLiquidPulse 10s ease-in-out infinite alternate;
        }

        .ios-liquid-orb-2 {
            animation: iosLiquidPulse 14s ease-in-out infinite alternate-reverse;
        }

        .ios-liquid-orb-3 {
            animation: iosLiquidPulse 8s ease-in-out infinite alternate;
        }

        .ios-active-pill {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.12) 0%, rgba(16, 185, 129, 0.2) 100%);
            box-shadow: 
                0 4px 12px rgba(5, 150, 105, 0.12),
                inset 0 1px 1px rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(16, 185, 129, 0.25);
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
        class="hidden md:flex flex-col justify-between bg-gradient-to-b from-[#021f17] via-[#053d2e] to-[#011711] text-white border-r border-emerald-500/20 sticky top-0 h-screen z-50 shrink-0 transition-all duration-300 ease-in-out select-none shadow-[4px_0_30px_rgba(0,0,0,0.35)] relative overflow-hidden"
        :class="sidebarExpanded ? 'w-72' : 'w-20'"
        x-data="{ 
            menuSearch: '',
            init() {
                window.addEventListener('keydown', (e) => {
                    if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                        e.preventDefault();
                        if (!this.sidebarExpanded) this.toggleSidebar();
                        this.$nextTick(() => this.$refs.searchInput?.focus());
                    }
                });
            }
        }">

        <!-- Subtle Ambient Glow Overlay -->
        <div class="pointer-events-none absolute -top-28 -left-28 w-80 h-80 bg-emerald-500/15 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute top-1/2 -right-32 w-64 h-64 bg-lime-500/10 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-28 -left-20 w-80 h-80 bg-emerald-600/15 rounded-full blur-3xl"></div>

        <!-- Top Section: Header Brand & Search & Navigation -->
        <div class="flex flex-col flex-1 min-h-0 overflow-y-auto scrollbar-none relative z-10">

            <!-- Brand Header -->
            <div class="flex items-center px-4 h-20 shrink-0 border-b border-white/[0.08] bg-black/10 backdrop-blur-xs"
                :class="sidebarExpanded ? 'justify-between' : 'justify-center'">
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3 overflow-hidden group">
                    <div
                        class="w-11 h-11 rounded-2xl bg-gradient-to-br from-white via-emerald-50 to-lime-100 text-emerald-950 flex items-center justify-center p-2 shadow-lg shadow-black/40 group-hover:scale-105 group-hover:shadow-emerald-500/30 transition-all duration-200 shrink-0 border border-white/50 ring-2 ring-emerald-400/20">
                        <img src="{{ asset('assets/image/logo-kormi.png') }}"
                            class="w-full h-full object-contain drop-shadow-xs" alt="Logo KORMI">
                    </div>
                    <div x-show="sidebarExpanded" x-transition.opacity.duration.200ms
                        class="whitespace-nowrap overflow-hidden">
                        <div class="flex items-center gap-1.5">
                            <span class="font-black text-white text-base leading-tight tracking-tight drop-shadow-sm">KORMI CMS</span>
                            <span class="text-[9px] font-black bg-gradient-to-r from-lime-400 to-emerald-300 text-slate-950 px-1.5 py-0.5 rounded-md uppercase tracking-wider shadow-xs ring-1 ring-white/30">Bedas</span>
                        </div>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-lime-500"></span>
                            </span>
                            <span class="text-[10px] font-bold text-emerald-200/90 uppercase tracking-widest">Kab. Bandung</span>
                        </div>
                    </div>
                </a>

                <!-- Toggle Collapse Button (when expanded) -->
                <button type="button" x-show="sidebarExpanded" @click="toggleSidebar()"
                    title="Perkecil Sidebar (Collapse)"
                    class="w-8 h-8 rounded-xl text-emerald-200/70 hover:text-white hover:bg-white/10 flex items-center justify-center transition-all duration-150 cursor-pointer border border-transparent hover:border-white/10">
                    <i data-lucide="chevrons-left" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Mini Expand Button (when collapsed) -->
            <div x-show="!sidebarExpanded" class="flex justify-center py-2.5 shrink-0 border-b border-white/[0.06]">
                <button type="button" @click="toggleSidebar()" title="Perluas Sidebar (Expand)"
                    class="w-10 h-8 rounded-xl text-emerald-200/80 hover:text-white hover:bg-white/10 flex items-center justify-center transition-all duration-150 cursor-pointer border border-transparent hover:border-white/10">
                    <i data-lucide="chevrons-right" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Quick Filter Bar with Keyboard Shortcut (When Expanded) -->
            <div x-show="sidebarExpanded" x-transition.opacity.duration.200ms class="px-3.5 pt-3 pb-1.5 shrink-0">
                <div class="relative w-full">
                    <!-- Search Icon (Left) -->
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none z-20 flex items-center justify-center text-emerald-300/80">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>

                    <!-- Input Element with explicit left and right padding -->
                    <input type="text" x-ref="searchInput" x-model="menuSearch" placeholder="Cari menu & modul..."
                        style="padding-left: 2.5rem !important; padding-right: 3.25rem !important;"
                        class="w-full h-9 bg-white/[0.07] hover:bg-white/[0.11] focus:bg-white/[0.15] border border-white/10 focus:border-lime-400/60 rounded-xl py-2 text-xs text-white placeholder:text-emerald-200/50 focus:outline-none focus:ring-1 focus:ring-lime-400/40 transition-all font-medium">

                    <!-- Right Shortcut or Clear Button -->
                    <div class="absolute right-2.5 top-1/2 -translate-y-1/2 flex items-center z-20">
                        <div x-show="!menuSearch" class="pointer-events-none">
                            <kbd class="text-[9px] font-bold text-emerald-200/70 bg-white/10 px-1.5 py-0.5 rounded border border-white/15 shadow-xs">⌘K</kbd>
                        </div>
                        <button type="button" x-show="menuSearch.length > 0" @click="menuSearch = ''"
                            class="text-emerald-300/80 hover:text-white text-xs cursor-pointer p-1 rounded-md hover:bg-white/15 transition-colors">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
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

                <!-- ========================================================= -->
                <!-- 1. IKHTISAR & UTAMA                                       -->
                <!-- ========================================================= -->
                <div x-show="sidebarExpanded && (!menuSearch || 'ikhtisar utama dashboard beranda'.includes(menuSearch.toLowerCase()))"
                    class="px-3 pt-2 pb-1 text-[10px] font-black uppercase tracking-wider text-emerald-300/70 flex items-center justify-between">
                    <span>Ikhtisar</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/40"></span>
                </div>

                <!-- Dashboard -->
                <div x-show="!menuSearch || 'dashboard beranda home statistik kpi ringkasan'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.dashboard'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="layout-dashboard"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.dashboard') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Dashboard</span>
                        @if(request()->routeIs('admin.dashboard'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Dashboard
                    </div>
                </div>

                @if($isEditor)
                <!-- ========================================================= -->
                <!-- 2. PUBLIKASI & MEDIA INFORMASI                            -->
                <!-- ========================================================= -->
                <div x-show="sidebarExpanded && (!menuSearch || 'publikasi media warta berita artikel galeri foto dokumentasi unduhan berkas dokumen'.includes(menuSearch.toLowerCase()))"
                    class="px-3 pt-4 pb-1 text-[10px] font-black uppercase tracking-wider text-emerald-300/70 flex items-center justify-between">
                    <span>Publikasi & Media</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/40"></span>
                </div>

                <!-- Berita & Artikel -->
                <div x-show="!menuSearch || 'berita artikel publikasi kabar informasi warta siaran pers liputan'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.berita') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.berita*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.berita*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="newspaper"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.berita*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Berita & Warta</span>
                        @if(request()->routeIs('admin.berita*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Berita & Warta
                    </div>
                </div>

                <!-- Galeri Dokumentasi -->
                <div x-show="!menuSearch || 'galeri foto dokumentasi album visual kegiatan foto kegiatan'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.galeri') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.galeri*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.galeri*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="image"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.galeri*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Galeri Foto</span>
                        @if(request()->routeIs('admin.galeri*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Galeri Foto
                    </div>
                </div>

                <!-- Dokumen Unduhan -->
                <div x-show="!menuSearch || 'dokumen unduhan download berkas surat pdf sk form regulasi edaran'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.unduhan') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.unduhan*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.unduhan*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="file-down"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.unduhan*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Dokumen & Unduhan</span>
                        @if(request()->routeIs('admin.unduhan*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Dokumen & Unduhan
                    </div>
                </div>
                @endif

                @if($isInorga)
                <!-- ========================================================= -->
                <!-- 3. KEOLAHRAGAAN & INORGA                                  -->
                <!-- ========================================================= -->
                <div x-show="sidebarExpanded && (!menuSearch || 'keolahragaan inorga komisi induk organisasi duta atlet penghargaan apmo sdi pelatihan sertifikasi'.includes(menuSearch.toLowerCase()))"
                    class="px-3 pt-4 pb-1 text-[10px] font-black uppercase tracking-wider text-emerald-300/70 flex items-center justify-between">
                    <span>Keolahragaan & Inorga</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/40"></span>
                </div>

                <!-- Inorga & Komisi -->
                <div x-show="!menuSearch || 'inorga komisi induk organisasi olahraga tradisional petualangan kesehatan kebugaran opti otfo okk'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.inorga') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.inorga*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.inorga*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="boxes"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.inorga*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Inorga & Komisi</span>
                        @if(request()->routeIs('admin.inorga*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Inorga & Komisi
                    </div>
                </div>

                <!-- Duta Olahraga -->
                <div x-show="!menuSearch || 'duta olahraga atlet pegiat peraih prestasi tokoh muda'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.duta') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.duta*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.duta*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="award"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.duta*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Duta Olahraga</span>
                        @if(request()->routeIs('admin.duta*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Duta Olahraga
                    </div>
                </div>

                <!-- ========================================================= -->
                <!-- 4. PARTISIPASI OLAHRAGA (APMO TRACKER)                    -->
                <!-- ========================================================= -->
                <div x-show="sidebarExpanded && (!menuSearch || 'partisipasi olahraga apmo tracker log kegiatan warga duta angka statistik kebugaran analitik capaian'.includes(menuSearch.toLowerCase()))"
                    class="px-3 pt-4 pb-1 text-[10px] font-black uppercase tracking-wider text-emerald-300/70 flex items-center justify-between">
                    <span>Partisipasi APMO</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/40"></span>
                </div>

                <!-- Log Data Partisipasi -->
                <div x-show="!menuSearch || 'partisipasi log data aktivitas olahraga entri verifikasi approval riwayat'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.partisipasi.log') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.partisipasi.log') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.partisipasi.log'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="clipboard-list"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.partisipasi.log') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Log Partisipasi</span>
                        @if(request()->routeIs('admin.partisipasi.log'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Log Partisipasi
                    </div>
                </div>

                <!-- Statistik & Analitik APMO -->
                <div x-show="!menuSearch || 'statistik analitik apmo grafik target wilayah kpi angka partisipasi kebugaran'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.partisipasi.statistik') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.partisipasi.statistik') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.partisipasi.statistik'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="bar-chart-3"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.partisipasi.statistik') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Statistik APMO</span>
                        @if(request()->routeIs('admin.partisipasi.statistik'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Statistik APMO
                    </div>
                </div>

                @if($isSuper)
                <!-- Pelatihan & Sertifikasi SDI -->
                <div x-show="!menuSearch || 'pelatihan sertifikasi sdi instruktur juri wasit sumber daya manusia pembina'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.sdi') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.sdi*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.sdi*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="graduation-cap"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.sdi*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Pelatihan SDI</span>
                        @if(request()->routeIs('admin.sdi*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Pelatihan SDI
                    </div>
                </div>

                <!-- Anugerah APMO -->
                <div x-show="!menuSearch || 'anugerah apmo penghargaan tokoh penggerak apresiasi dedikasi piala insan'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.apmo') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.apmo*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.apmo*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="sparkles"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.apmo*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Anugerah APMO</span>
                        @if(request()->routeIs('admin.apmo*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Anugerah APMO
                    </div>
                </div>
                @endif
                @endif

                @if($isInorga)
                <!-- ========================================================= -->
                <!-- 4. EVENT & PERTANDINGAN                                   -->
                <!-- ========================================================= -->
                <div x-show="sidebarExpanded && (!menuSearch || 'event pertandingan turnamen kejuaraan lomba forkab fotradkab klasemen medali'.includes(menuSearch.toLowerCase()))"
                    class="px-3 pt-4 pb-1 text-[10px] font-black uppercase tracking-wider text-emerald-300/70 flex items-center justify-between">
                    <span>Event & Kompetisi</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/40"></span>
                </div>

                <!-- Kelola Event -->
                <div x-show="!menuSearch || 'event forkab forda fornas fotradkab jadwal cabang kategori lomba pertandingan turnamen'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.event') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.event*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.event*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="calendar-days"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.event*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Kelola Event</span>
                        @if(request()->routeIs('admin.event*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Kelola Event
                    </div>
                </div>

                <!-- Klasemen Medali -->
                <div x-show="!menuSearch || 'klasemen medali fornas forda forprov forkab juara emas perak perunggu kontingen peringkat'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.klasemen') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.klasemen*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.klasemen*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="trophy"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.klasemen*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Klasemen Medali</span>
                        @if(request()->routeIs('admin.klasemen*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Klasemen Medali
                    </div>
                </div>
                @endif

                @if($isKorcam)
                <!-- ========================================================= -->
                <!-- 5. WILAYAH & FASILITAS                                    -->
                <!-- ========================================================= -->
                <div x-show="sidebarExpanded && (!menuSearch || 'wilayah fasilitas kecamatan korcam kordik sarana prasarana sapras venue gedung lapangan'.includes(menuSearch.toLowerCase()))"
                    class="px-3 pt-4 pb-1 text-[10px] font-black uppercase tracking-wider text-emerald-300/70 flex items-center justify-between">
                    <span>Wilayah & Fasilitas</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/40"></span>
                </div>

                <!-- Kordik Kecamatan -->
                <div x-show="!menuSearch || 'kordik koordinator kecamatan korcam wilayah tingkat cabang koordinator'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.kordik') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.kordik*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.kordik*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="network" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.kordik*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Kordik Kecamatan</span>
                        @if(request()->routeIs('admin.kordik*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Kordik Kecamatan
                    </div>
                </div>

                <!-- Sarana & Prasarana -->
                <div x-show="!menuSearch || 'sarana prasarana sapras fasilitas venue lapangan gedung gelanggang aset olahraga'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.sapras') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.sapras*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.sapras*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="map-pin"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.sapras*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Sarana & Prasarana</span>
                        @if(request()->routeIs('admin.sapras*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Sarana & Prasarana
                    </div>
                </div>
                @endif

                @if($isSuper)
                <!-- ========================================================= -->
                <!-- 6. PROFIL & KELEMBAGAAN KORMI                             -->
                <!-- ========================================================= -->
                <div class="flex items-center justify-between px-3 pt-4 pb-1" x-show="sidebarExpanded && (!menuSearch || 'organisasi kelembagaan sejarah visi misi pengurus kepengurusan proker program kerja'.includes(menuSearch.toLowerCase()))">
                    <span class="text-[10px] font-black text-emerald-300/70 uppercase tracking-wider">Kelembagaan</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/40"></span>
                </div>

                <!-- Sejarah -->
                <div x-show="!menuSearch || 'sejarah timeline linimasa profil pembentukan latar belakang'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.sejarah') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.sejarah*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.sejarah*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="history" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.sejarah*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Sejarah KORMI</span>
                        @if(request()->routeIs('admin.sejarah*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Sejarah KORMI
                    </div>
                </div>

                <!-- Visi & Misi -->
                <div x-show="!menuSearch || 'visi misi motto nilai tujuan arah sasaran'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.visimisi') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.visimisi*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.visimisi*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="target" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.visimisi*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Visi & Misi</span>
                        @if(request()->routeIs('admin.visimisi*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Visi & Misi
                    </div>
                </div>

                <!-- Struktur Pengurus -->
                <div x-show="!menuSearch || 'pengurus struktur jabatan dewan kabid biro pimpinan susunan kepengurusan'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.pengurus') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.pengurus*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.pengurus*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="user-check" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.pengurus*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Struktur Pengurus</span>
                        @if(request()->routeIs('admin.pengurus*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Struktur Pengurus
                    </div>
                </div>

                <!-- Program Kerja -->
                <div x-show="!menuSearch || 'program kerja proker kegiatan agenda tahunan rencana kerja target'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.proker') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.proker*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.proker*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="clipboard-check" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.proker*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Program Kerja</span>
                        @if(request()->routeIs('admin.proker*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Program Kerja
                    </div>
                </div>

                <!-- ========================================================= -->
                <!-- 7. PENGATURAN & AKSES SISTEM                              -->
                <!-- ========================================================= -->
                <div x-show="sidebarExpanded && (!menuSearch || 'sistem pengaturan pengguna user admin hak akses keamanan rbac peran konfigurasi setting'.includes(menuSearch.toLowerCase()))"
                    class="px-3 pt-4 pb-1 text-[10px] font-black uppercase tracking-wider text-emerald-300/70 flex items-center justify-between">
                    <span>Akses & Sistem</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/40"></span>
                </div>

                <!-- Kelola Pengguna -->
                <div x-show="!menuSearch || 'pengguna user admin akun profil staf kelola pengguna'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.pengguna') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.pengguna*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.pengguna*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="users-round"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.pengguna*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Kelola Pengguna</span>
                        @if(request()->routeIs('admin.pengguna*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Kelola Pengguna
                    </div>
                </div>

                <!-- Peran & Hak Akses -->
                <div x-show="!menuSearch || 'peran role hak akses permission wewenang rbac otoritas'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.peran') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.peran*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.peran*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="shield-check"
                                class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.peran*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Peran & Hak Akses</span>
                        @if(request()->routeIs('admin.peran*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded"
                        class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Peran & Hak Akses
                    </div>
                </div>

                <!-- Pengaturan Situs -->
                <div x-show="!menuSearch || 'pengaturan situs konfigurasi setting kontak sosmed logo footer meta umum'.includes(menuSearch.toLowerCase())" class="relative group">
                    <a href="{{ route('admin.pengaturan') }}" wire:navigate
                        class="flex items-center rounded-xl font-bold text-xs sm:text-sm transition-all duration-150 relative overflow-hidden {{ request()->routeIs('admin.pengaturan*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold shadow-md border border-lime-400/40 backdrop-blur-md' : 'text-emerald-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                        :class="sidebarExpanded ? 'px-3 py-2.5 gap-3' : 'w-11 h-11 justify-center mx-auto'">
                        @if(request()->routeIs('admin.pengaturan*'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-5 bg-gradient-to-b from-lime-400 to-emerald-400 rounded-r-md shadow-sm shadow-lime-400/50"></div>
                        @endif
                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                            <i data-lucide="sliders-horizontal" class="w-4.5 h-4.5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.pengaturan*') ? 'text-lime-300' : 'text-emerald-300/80 group-hover:text-lime-300' }}"></i>
                        </div>
                        <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Pengaturan Situs</span>
                        @if(request()->routeIs('admin.pengaturan*'))
                            <span x-show="sidebarExpanded" class="ml-auto flex items-center">
                                <span class="w-2 h-2 rounded-full bg-lime-400 shadow-sm shadow-lime-400 animate-pulse"></span>
                            </span>
                        @endif
                    </a>
                    <div x-show="!sidebarExpanded" class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                        Pengaturan Situs
                    </div>
                </div>
                @endif

            </nav>
        </div>

        <!-- Bottom Footer Section: Profile & Actions -->
        <div class="p-3 border-t border-white/[0.08] bg-black/30 backdrop-blur-md flex flex-col gap-2 shrink-0 relative z-10">

            <!-- Quick View Portal Button -->
            <div class="relative group">
                <a href="{{ route('beranda') }}" target="_blank"
                    class="flex items-center rounded-xl font-bold text-xs bg-white/[0.06] hover:bg-white/[0.14] text-emerald-100 hover:text-white transition-all duration-150 border border-white/10 shadow-xs hover:border-lime-400/40"
                    :class="sidebarExpanded ? 'px-3 py-2.5 gap-2.5' : 'w-11 h-10 justify-center mx-auto'">
                    <i data-lucide="external-link" class="w-3.5 h-3.5 shrink-0 text-lime-400"></i>
                    <span x-show="sidebarExpanded" class="truncate whitespace-nowrap">Lihat Portal Publik</span>
                </a>
                <div x-show="!sidebarExpanded"
                    class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-slate-950/95 text-white text-xs font-bold rounded-xl shadow-2xl border border-emerald-500/30 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
                    Lihat Portal Publik
                </div>
            </div>

            <!-- User Profile & Logout Box -->
            <div class="flex items-center rounded-2xl p-2 bg-white/[0.06] hover:bg-white/[0.09] border border-white/10 backdrop-blur-md shadow-lg shadow-black/25 transition-all"
                :class="sidebarExpanded ? 'justify-between' : 'justify-center'">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="relative shrink-0">
                        <div
                            class="w-9 h-9 rounded-xl bg-gradient-to-br from-lime-400 via-emerald-400 to-teal-500 text-slate-950 flex items-center justify-center font-black text-xs shadow-md shadow-emerald-900/40 ring-2 ring-white/20">
                            {{ strtoupper(substr(auth()->user()?->nama_lengkap ?? 'AD', 0, 2)) }}
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-lime-400 border-2 border-emerald-950 rounded-full"></span>
                    </div>
                    <div x-show="sidebarExpanded" class="min-w-0">
                        <p class="text-xs font-extrabold text-white truncate leading-tight">
                            {{ auth()->user()?->nama_lengkap ?? 'Administrator' }}</p>
                        <p class="text-[10px] font-semibold text-emerald-300/80 capitalize truncate">
                            {{ auth()->user()?->peran?->nama_peran ?? 'Super Administrator' }}</p>
                    </div>
                </div>

                <!-- Logout Button (Expanded) -->
                <form action="{{ route('admin.keluar') }}" method="POST" class="shrink-0"
                    :class="sidebarExpanded ? '' : 'hidden'">
                    @csrf
                    <button type="submit" title="Keluar dari CMS"
                        class="p-2 rounded-xl text-emerald-200/70 hover:text-rose-300 hover:bg-rose-500/20 hover:border hover:border-rose-500/30 transition-all duration-150 cursor-pointer">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>

            <!-- Mini Logout when collapsed -->
            <div x-show="!sidebarExpanded" class="flex justify-center relative group">
                <form action="{{ route('admin.keluar') }}" method="POST">
                    @csrf
                    <button type="submit" title="Keluar"
                        class="w-10 h-10 rounded-xl text-emerald-200/70 hover:text-rose-300 hover:bg-rose-500/20 flex items-center justify-center transition-all duration-150 cursor-pointer border border-transparent hover:border-rose-500/30">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
                <div
                    class="pointer-events-none absolute left-full top-1/2 -translate-y-1/2 ml-3 px-3 py-1.5 bg-rose-950/95 text-rose-200 text-xs font-bold rounded-xl shadow-2xl border border-rose-800/60 opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-150 z-50 whitespace-nowrap backdrop-blur-md flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                    Keluar dari CMS
                </div>
            </div>

        </div>
    </aside>

    <!-- RIGHT MAIN WORKSPACE -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- TOP MOBILE BAR -->
        <header
            class="md:hidden flex items-center justify-between px-5 py-3.5 bg-gradient-to-r from-[#021f17] to-[#043629] text-white border-b border-emerald-800/60 sticky top-0 z-40 shadow-md">
            <div class="flex items-center gap-3">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="p-2 rounded-xl text-emerald-200 hover:text-white hover:bg-white/10 focus:outline-none cursor-pointer">
                    <i data-lucide="menu" class="w-5 h-5" x-show="!mobileMenuOpen"></i>
                    <i data-lucide="x" class="w-5 h-5" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
                <div class="w-8 h-8 rounded-xl bg-white text-emerald-950 flex items-center justify-center p-1.5 shadow-sm">
                    <img src="{{ asset('assets/image/logo-kormi.png') }}"
                        class="w-full h-full object-contain" alt="Logo KORMI">
                </div>
                <div>
                    <span class="font-black text-white text-sm tracking-tight block">KORMI CMS</span>
                    <span class="text-[9px] font-bold text-lime-300 block leading-none">Kab. Bandung</span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('beranda') }}" target="_blank"
                    class="px-2.5 py-1 rounded-lg bg-white/10 text-emerald-100 hover:bg-white/20 hover:text-white border border-white/15 font-bold text-xs flex items-center gap-1.5 transition-colors">
                    <i data-lucide="external-link" class="w-3 h-3 text-lime-300"></i>
                    <span>Portal</span>
                </a>
            </div>
        </header>

        <!-- MOBILE MENU DRAWER -->
        <div x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden bg-gradient-to-b from-[#021f17] via-[#053d2e] to-[#011711] text-white border-b border-emerald-800/80 px-4 py-4 space-y-1 shadow-2xl max-h-[85vh] overflow-y-auto" style="display: none;">
            
            <!-- 1. Ikhtisar -->
            <p class="px-3 pt-1 pb-1 text-[10px] font-black text-emerald-300/60 uppercase tracking-widest">Ikhtisar</p>
            <a href="{{ route('admin.dashboard') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Dashboard
            </a>

            @if($isEditor)
            <!-- 2. Publikasi & Media -->
            <p class="px-3 pt-3 pb-1 text-[10px] font-black text-emerald-300/60 uppercase tracking-widest border-t border-white/10 mt-2">Publikasi & Media</p>
            <a href="{{ route('admin.berita') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.berita*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="newspaper" class="w-4 h-4 {{ request()->routeIs('admin.berita*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Berita & Warta
            </a>
            <a href="{{ route('admin.galeri') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.galeri*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="image" class="w-4 h-4 {{ request()->routeIs('admin.galeri*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Galeri Foto
            </a>
            <a href="{{ route('admin.unduhan') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.unduhan*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="file-down" class="w-4 h-4 {{ request()->routeIs('admin.unduhan*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Dokumen & Unduhan
            </a>
            @endif

            @if($isInorga)
            <!-- 3. Keolahragaan & Inorga -->
            <p class="px-3 pt-3 pb-1 text-[10px] font-black text-emerald-300/60 uppercase tracking-widest border-t border-white/10 mt-2">Keolahragaan & Inorga</p>
            <a href="{{ route('admin.inorga') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.inorga*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="boxes" class="w-4 h-4 {{ request()->routeIs('admin.inorga*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Inorga & Komisi
            </a>
            <a href="{{ route('admin.duta') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.duta*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="award" class="w-4 h-4 {{ request()->routeIs('admin.duta*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Duta Olahraga
            </a>
            <a href="{{ route('admin.partisipasi.log') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.partisipasi.log') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="clipboard-list" class="w-4 h-4 {{ request()->routeIs('admin.partisipasi.log') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Log Partisipasi (APMO)
            </a>
            <a href="{{ route('admin.partisipasi.statistik') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.partisipasi.statistik') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="bar-chart-3" class="w-4 h-4 {{ request()->routeIs('admin.partisipasi.statistik') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Statistik APMO
            </a>
            @if($isSuper)
            <a href="{{ route('admin.sdi') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.sdi*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="graduation-cap" class="w-4 h-4 {{ request()->routeIs('admin.sdi*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Pelatihan SDI
            </a>
            <a href="{{ route('admin.apmo') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.apmo*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="sparkles" class="w-4 h-4 {{ request()->routeIs('admin.apmo*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Anugerah APMO
            </a>
            @endif
            @endif

            @if($isInorga)
            <!-- 4. Event & Kompetisi -->
            <p class="px-3 pt-3 pb-1 text-[10px] font-black text-emerald-300/60 uppercase tracking-widest border-t border-white/10 mt-2">Event & Kompetisi</p>
            <a href="{{ route('admin.event') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.event*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="calendar-days" class="w-4 h-4 {{ request()->routeIs('admin.event*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Kelola Event
            </a>
            <a href="{{ route('admin.klasemen') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.klasemen*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="trophy" class="w-4 h-4 {{ request()->routeIs('admin.klasemen*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Klasemen Medali
            </a>
            @endif

            @if($isKorcam)
            <!-- 5. Wilayah & Fasilitas -->
            <p class="px-3 pt-3 pb-1 text-[10px] font-black text-emerald-300/60 uppercase tracking-widest border-t border-white/10 mt-2">Wilayah & Fasilitas</p>
            <a href="{{ route('admin.kordik') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.kordik*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="network" class="w-4 h-4 {{ request()->routeIs('admin.kordik*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Kordik Kecamatan
            </a>
            <a href="{{ route('admin.sapras') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.sapras*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="map-pin" class="w-4 h-4 {{ request()->routeIs('admin.sapras*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Sarana & Prasarana
            </a>
            @endif

            @if($isSuper)
            <!-- 6. Kelembagaan -->
            <p class="px-3 pt-3 pb-1 text-[10px] font-black text-emerald-300/60 uppercase tracking-widest border-t border-white/10 mt-2">Kelembagaan</p>
            <a href="{{ route('admin.sejarah') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.sejarah*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="history" class="w-4 h-4 {{ request()->routeIs('admin.sejarah*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Sejarah KORMI
            </a>
            <a href="{{ route('admin.visimisi') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.visimisi*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="target" class="w-4 h-4 {{ request()->routeIs('admin.visimisi*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Visi & Misi
            </a>
            <a href="{{ route('admin.pengurus') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.pengurus*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="user-check" class="w-4 h-4 {{ request()->routeIs('admin.pengurus*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Struktur Pengurus
            </a>
            <a href="{{ route('admin.proker') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.proker*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="clipboard-check" class="w-4 h-4 {{ request()->routeIs('admin.proker*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Program Kerja
            </a>

            <!-- 7. Akses & Sistem -->
            <p class="px-3 pt-3 pb-1 text-[10px] font-black text-emerald-300/60 uppercase tracking-widest border-t border-white/10 mt-2">Akses & Sistem</p>
            <a href="{{ route('admin.pengguna') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.pengguna*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="users-round" class="w-4 h-4 {{ request()->routeIs('admin.pengguna*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Kelola Pengguna
            </a>
            <a href="{{ route('admin.peran') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.peran*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="shield-check" class="w-4 h-4 {{ request()->routeIs('admin.peran*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Peran & Hak Akses
            </a>
            <a href="{{ route('admin.pengaturan') }}" wire:navigate @click="mobileMenuOpen = false"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs {{ request()->routeIs('admin.pengaturan*') ? 'bg-gradient-to-r from-emerald-500/30 to-lime-500/20 text-white font-extrabold border border-lime-400/40 shadow-sm' : 'text-emerald-100 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="sliders-horizontal" class="w-4 h-4 {{ request()->routeIs('admin.pengaturan*') ? 'text-lime-300' : 'text-emerald-300' }}"></i> Pengaturan Situs
            </a>
            @endif

            <div class="pt-3 border-t border-white/10 mt-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-lime-400 text-slate-950 font-bold text-xs flex items-center justify-center">
                        {{ strtoupper(substr(auth()->user()?->nama_lengkap ?? 'AD', 0, 2)) }}
                    </div>
                    <div class="text-xs">
                        <p class="font-bold text-white leading-tight">{{ auth()->user()?->nama_lengkap ?? 'Admin' }}</p>
                        <p class="text-[10px] text-emerald-300/80">{{ auth()->user()?->peran?->nama_peran ?? 'Super Admin' }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.keluar') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-500/20 text-rose-300 border border-rose-500/30 font-bold text-xs flex items-center gap-1">
                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- MAIN FULL WIDTH CONTENT CONTAINER -->
        <main class="w-full flex-1 p-4 sm:p-6 lg:p-8 min-w-0 pb-24 md:pb-8">
            {{ $slot }}
        </main>
    </div>

    <!-- ========================================================= -->
    <!-- MOBILE BOTTOM APP NAVIGATION BAR (SEAMLESS INTEGRATED iOS BAR) -->
    <!-- ========================================================= -->
    <div class="md:hidden fixed bottom-0 inset-x-0 z-40">
        <!-- Full Width Seamless iOS Liquid Glass Bar Attached to Screen Bottom -->
        <nav class="relative border-t border-white/80 ios-liquid-dock px-3 pt-2 pb-5 sm:pb-3 shadow-[0_-8px_30px_rgba(0,0,0,0.08)]">
            
            <!-- Fluid Ambient Liquid Orbs Under The Glass -->
            <div class="absolute -top-10 left-10 w-36 h-24 bg-emerald-400/25 rounded-full blur-2xl pointer-events-none ios-liquid-orb-1"></div>
            <div class="absolute -top-10 right-10 w-36 h-24 bg-lime-400/25 rounded-full blur-2xl pointer-events-none ios-liquid-orb-2"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-20 bg-teal-400/20 rounded-full blur-xl pointer-events-none ios-liquid-orb-3"></div>

            <!-- iOS Specular Bevel & Top Line Reflection -->
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white to-transparent pointer-events-none"></div>

            <!-- Inner Navigation Buttons Row -->
            <div class="flex items-center justify-around relative z-10 max-w-lg mx-auto">
                
                <!-- 1. Beranda / Dashboard -->
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    class="flex flex-col items-center justify-center flex-1 py-1 transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'text-emerald-900 font-extrabold scale-105' : 'text-slate-500 hover:text-slate-900 font-semibold' }}">
                    <div class="relative flex items-center justify-center w-12 h-8 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'ios-active-pill text-emerald-800' : 'group-hover:bg-black/5' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'stroke-[2.5] text-emerald-700' : 'stroke-[1.75]' }}"></i>
                        @if(request()->routeIs('admin.dashboard'))
                            <span class="absolute -bottom-1 w-1.5 h-1.5 rounded-full bg-emerald-600 shadow-[0_0_8px_rgba(5,150,105,0.8)]"></span>
                        @endif
                    </div>
                    <span class="text-[10px] mt-0.5 tracking-tight font-bold">Dashboard</span>
                </a>

                @if($isEditor)
                <!-- 2. Berita & Warta -->
                <a href="{{ route('admin.berita') }}" wire:navigate
                    class="flex flex-col items-center justify-center flex-1 py-1 transition-all duration-300 group {{ request()->routeIs('admin.berita*') ? 'text-emerald-900 font-extrabold scale-105' : 'text-slate-500 hover:text-slate-900 font-semibold' }}">
                    <div class="relative flex items-center justify-center w-12 h-8 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.berita*') ? 'ios-active-pill text-emerald-800' : 'group-hover:bg-black/5' }}">
                        <i data-lucide="newspaper" class="w-5 h-5 {{ request()->routeIs('admin.berita*') ? 'stroke-[2.5] text-emerald-700' : 'stroke-[1.75]' }}"></i>
                        @if(request()->routeIs('admin.berita*'))
                            <span class="absolute -bottom-1 w-1.5 h-1.5 rounded-full bg-emerald-600 shadow-[0_0_8px_rgba(5,150,105,0.8)]"></span>
                        @endif
                    </div>
                    <span class="text-[10px] mt-0.5 tracking-tight font-bold">Berita</span>
                </a>
                @endif

                @if($isInorga)
                <!-- 3. Inorga & Olahraga -->
                <a href="{{ route('admin.inorga') }}" wire:navigate
                    class="flex flex-col items-center justify-center flex-1 py-1 transition-all duration-300 group {{ request()->routeIs('admin.inorga*') ? 'text-emerald-900 font-extrabold scale-105' : 'text-slate-500 hover:text-slate-900 font-semibold' }}">
                    <div class="relative flex items-center justify-center w-12 h-8 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.inorga*') ? 'ios-active-pill text-emerald-800' : 'group-hover:bg-black/5' }}">
                        <i data-lucide="boxes" class="w-5 h-5 {{ request()->routeIs('admin.inorga*') ? 'stroke-[2.5] text-emerald-700' : 'stroke-[1.75]' }}"></i>
                        @if(request()->routeIs('admin.inorga*'))
                            <span class="absolute -bottom-1 w-1.5 h-1.5 rounded-full bg-emerald-600 shadow-[0_0_8px_rgba(5,150,105,0.8)]"></span>
                        @endif
                    </div>
                    <span class="text-[10px] mt-0.5 tracking-tight font-bold">Inorga</span>
                </a>
                @endif

                @if($isInorga)
                <!-- 4. Event / Kejuaraan -->
                <a href="{{ route('admin.event') }}" wire:navigate
                    class="flex flex-col items-center justify-center flex-1 py-1 transition-all duration-300 group {{ request()->routeIs('admin.event*') || request()->routeIs('admin.klasemen*') ? 'text-emerald-900 font-extrabold scale-105' : 'text-slate-500 hover:text-slate-900 font-semibold' }}">
                    <div class="relative flex items-center justify-center w-12 h-8 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.event*') || request()->routeIs('admin.klasemen*') ? 'ios-active-pill text-emerald-800' : 'group-hover:bg-black/5' }}">
                        <i data-lucide="trophy" class="w-5 h-5 {{ request()->routeIs('admin.event*') || request()->routeIs('admin.klasemen*') ? 'stroke-[2.5] text-emerald-700' : 'stroke-[1.75]' }}"></i>
                        @if(request()->routeIs('admin.event*'))
                            <span class="absolute -bottom-1 w-1.5 h-1.5 rounded-full bg-emerald-600 shadow-[0_0_8px_rgba(5,150,105,0.8)]"></span>
                        @endif
                    </div>
                    <span class="text-[10px] mt-0.5 tracking-tight font-bold">Event</span>
                </a>
                @elseif($isKorcam)
                <!-- 4 Alt for Korcam: Kordik / Wilayah -->
                <a href="{{ route('admin.kordik') }}" wire:navigate
                    class="flex flex-col items-center justify-center flex-1 py-1 transition-all duration-300 group {{ request()->routeIs('admin.kordik*') ? 'text-emerald-900 font-extrabold scale-105' : 'text-slate-500 hover:text-slate-900 font-semibold' }}">
                    <div class="relative flex items-center justify-center w-12 h-8 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.kordik*') ? 'ios-active-pill text-emerald-800' : 'group-hover:bg-black/5' }}">
                        <i data-lucide="network" class="w-5 h-5 {{ request()->routeIs('admin.kordik*') ? 'stroke-[2.5] text-emerald-700' : 'stroke-[1.75]' }}"></i>
                        @if(request()->routeIs('admin.kordik*'))
                            <span class="absolute -bottom-1 w-1.5 h-1.5 rounded-full bg-emerald-600 shadow-[0_0_8px_rgba(5,150,105,0.8)]"></span>
                        @endif
                    </div>
                    <span class="text-[10px] mt-0.5 tracking-tight font-bold">Kordik</span>
                </a>
                @endif

                <!-- 5. Menu Lainnya / Drawer Trigger -->
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                    class="flex flex-col items-center justify-center flex-1 py-1 transition-all duration-300 group cursor-pointer"
                    :class="mobileMenuOpen ? 'text-emerald-950 font-extrabold scale-105' : 'text-slate-500 hover:text-slate-900 font-semibold'">
                    <div class="relative flex items-center justify-center w-12 h-8 rounded-2xl transition-all duration-300"
                        :class="mobileMenuOpen ? 'bg-gradient-to-tr from-emerald-600 to-teal-500 text-white shadow-md shadow-emerald-600/30' : 'group-hover:bg-black/5'">
                        <i data-lucide="layout-grid" class="w-5 h-5" :class="mobileMenuOpen ? 'stroke-[2.5]' : 'stroke-[1.75]'"></i>
                    </div>
                    <span class="text-[10px] mt-0.5 tracking-tight font-bold">Menu</span>
                </button>

            </div>
        </nav>
    </div>

    @livewireScripts
</body>

</html>
