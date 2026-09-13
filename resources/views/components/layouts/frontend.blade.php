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
