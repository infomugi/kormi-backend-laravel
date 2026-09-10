<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KORMI Kabupaten Bandung - Website Resmi' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/image/favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-white text-slate-900 transition-colors duration-500 overflow-x-hidden">
    
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
