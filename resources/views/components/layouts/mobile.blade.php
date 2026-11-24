<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'KORMI Kabupaten Bandung' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/image/favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        @media (min-width: 480px) {
            .kd-tabbar {
                left: 50%;
                right: auto;
                width: 480px;
                transform: translateX(-50%);
            }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 antialiased overflow-x-hidden">
    <div class="mx-auto w-full max-w-[480px] min-h-screen bg-white shadow-xl">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
