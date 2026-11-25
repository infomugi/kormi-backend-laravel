@props(['aktif' => null])

{{-- Menu bawah mobile: pengunjung vs pengguna yang sudah masuk --}}
@auth
    @php
        $isDuta = auth()->user()?->isDutaOlahraga() ?? false;

        // Absensi & Survei APMO hanya untuk akun duta olahraga.
        $tabDuta = $isDuta ? [
            ['kunci' => 'apmo', 'label' => 'APMO', 'icon' => 'clipboard-list', 'route' => 'mobile.angket'],
            ['kunci' => 'absensi', 'label' => 'Absensi', 'icon' => 'fingerprint', 'route' => 'mobile.absensi', 'fab' => true],
        ] : [];

        $tabs = array_merge(
            [['kunci' => 'dashboard', 'label' => 'Beranda', 'icon' => 'house', 'route' => 'mobile.dashboard']],
            $tabDuta,
            [
                ['kunci' => 'laporan', 'label' => 'Laporan', 'icon' => 'chart-column', 'route' => 'mobile.laporan'],
                ['kunci' => 'profil', 'label' => 'Profil', 'icon' => 'circle-user', 'route' => 'mobile.profil'],
            ]
        );
    @endphp
@else
    @php
        $tabs = [
            ['kunci' => 'beranda', 'label' => 'Beranda', 'icon' => 'home', 'route' => 'mobile.beranda'],
            ['kunci' => 'direktori', 'label' => 'Direktori', 'icon' => 'award', 'route' => 'mobile.direktori-duta'],
            ['kunci' => 'daftar', 'label' => 'Daftar', 'icon' => 'user-plus', 'route' => 'mobile.daftar-duta'],
            ['kunci' => 'masuk', 'label' => 'Masuk', 'icon' => 'log-in', 'route' => 'mobile.login'],
        ];
    @endphp
@endauth

<nav class="kd-tabbar @auth kd-tabbar--app @endauth" style="--kd-tabs: {{ count($tabs) }}" aria-label="Menu navigasi mobile">
    @foreach($tabs as $tab)
        @php $kelasTab = 'kd-tab' . (($tab['fab'] ?? false) ? ' kd-tab--fab' : ''); @endphp
        @if($aktif === $tab['kunci'])
            <span class="{{ $kelasTab }} is-active" aria-current="page">
                <span class="kd-tab-icon"><i data-lucide="{{ $tab['icon'] }}"></i></span>
                <span>{{ $tab['label'] }}</span>
            </span>
        @else
            <a href="{{ route($tab['route']) }}" wire:navigate class="{{ $kelasTab }}">
                <span class="kd-tab-icon"><i data-lucide="{{ $tab['icon'] }}"></i></span>
                <span>{{ $tab['label'] }}</span>
            </a>
        @endif
    @endforeach
</nav>
