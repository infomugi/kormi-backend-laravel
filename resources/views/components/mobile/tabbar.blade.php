@props(['aktif' => null])

{{-- Menu bawah mobile: pengunjung vs pengguna yang sudah masuk --}}
<nav class="kd-tabbar" aria-label="Menu navigasi mobile">
    @auth
        @php
            $tabs = [
                ['kunci' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => 'mobile.dashboard'],
                ['kunci' => 'layanan', 'label' => 'Layanan', 'icon' => 'blocks', 'route' => 'mobile.layanan'],
                ['kunci' => 'berita', 'label' => 'Berita', 'icon' => 'newspaper', 'route' => 'mobile.berita'],
                ['kunci' => 'profil', 'label' => 'Profil', 'icon' => 'circle-user', 'route' => 'mobile.profil'],
            ];
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

    @foreach($tabs as $tab)
        @if($aktif === $tab['kunci'])
            <span class="kd-tab is-active" aria-current="page">
                <span class="kd-tab-icon"><i data-lucide="{{ $tab['icon'] }}"></i></span>
                <span>{{ $tab['label'] }}</span>
            </span>
        @else
            <a href="{{ route($tab['route']) }}" wire:navigate class="kd-tab">
                <span class="kd-tab-icon"><i data-lucide="{{ $tab['icon'] }}"></i></span>
                <span>{{ $tab['label'] }}</span>
            </a>
        @endif
    @endforeach
</nav>
