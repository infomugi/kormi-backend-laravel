<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KORMI Kabupaten Bandung - Website Resmi' }}</title>
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
        }
    </style>
</head>
<body class="min-h-screen bg-white text-slate-900 transition-colors duration-500 overflow-x-hidden selection:bg-emerald-600 selection:text-white">
    
    @if(session()->has('impersonator_id'))
    <!-- IMPERSONATION FLOATING ALERT BANNER (FRONTEND) -->
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 text-white px-4 py-2.5 shadow-lg flex flex-wrap items-center justify-between gap-3 sticky top-0 z-[100] border-b border-white/20 text-xs font-bold">
        <div class="flex items-center gap-2.5">
            <span class="px-2 py-0.5 rounded-full bg-black/20 text-amber-100 uppercase tracking-wider text-[10px] font-black flex items-center gap-1 shrink-0">
                <svg class="w-3.5 h-3.5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Mode Impersonasi</span>
            </span>
            <span class="leading-tight">
                Anda sedang masuk sebagai <strong class="text-white underline underline-offset-2">{{ auth()->user()?->nama_lengkap }}</strong> <span class="opacity-90">({{ auth()->user()?->peran?->nama_peran ?? 'Pengguna' }})</span>
                @if(session('impersonator_name'))
                    <span class="hidden sm:inline text-amber-100 font-normal">&mdash; Administrator Asli: <strong class="font-bold text-white">{{ session('impersonator_name') }}</strong></span>
                @endif
            </span>
        </div>
        <a href="{{ route('admin.impersonate.leave') }}" class="px-3.5 py-1.5 rounded-xl bg-white text-rose-700 hover:bg-rose-50 font-black text-xs uppercase tracking-wider shadow-sm active:scale-95 transition-all flex items-center gap-1.5 shrink-0">
            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span>Kembali ke Super Admin</span>
        </a>
    </div>
    @endif

    <!-- HEADER NAVBAR -->
    <livewire:layout.navbar />

    <!-- MAIN CONTENT -->
    <main class="pt-24 min-h-[75vh]">
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <livewire:layout.footer />

    @livewireScripts
</body>
</html>
