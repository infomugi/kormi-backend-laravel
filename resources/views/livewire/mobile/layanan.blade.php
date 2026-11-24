{{-- Halaman Layanan mobile — desain mobile_kormi.html --}}
<div class="kd-mobile min-h-screen">
    <div class="kd-header">
        <div class="kd-brand">
            <div class="kd-brand-icon">K</div>
            <span class="kd-brand-title">KORMI Kab. Bandung</span>
        </div>
        <p class="kd-brand-sub">Layanan KORMI</p>
    </div>

    <div class="kd-sheet">
        <div class="kd-section-head">
            <div>
                <h3>Layanan</h3>
                <p>Akses cepat fitur KORMI sesuai peran Anda ({{ $roleLabel }}).</p>
            </div>
            <span class="kd-badge">{{ $badgePeran }}</span>
        </div>

        @if(count($layananPartisipasi))
            <div class="kd-subhead">
                <h4>Layanan Partisipasi</h4>
                <span class="kd-chip">{{ count($layananPartisipasi) }} layanan</span>
            </div>

            <div class="kd-modules">
                @foreach($layananPartisipasi as $item)
                    <a href="{{ route($item['route']) }}" wire:navigate class="kd-module">
                        <span class="kd-module-icon"><i data-lucide="{{ $item['icon'] }}"></i></span>
                        <span>
                            <span class="kd-module-name">{{ $item['nama'] }}</span>
                            <span class="kd-module-desc">{{ $item['desc'] }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        @endif

        @if(count($modulCms))
            <div class="kd-subhead" style="margin-top: 20px;">
                <h4>Kelola Organisasi</h4>
                <span class="kd-chip kd-chip--dark">{{ count($modulCms) }} modul</span>
            </div>

            <div class="kd-success-actions" style="margin-bottom: 14px;">
                <a href="{{ route('admin.dashboard') }}" class="kd-btn-primary">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Buka Dashboard CMS</span>
                </a>
            </div>

            <div class="kd-modules">
                @foreach($modulCms as $item)
                    <a href="{{ route($item['route']) }}" wire:navigate class="kd-module">
                        <span class="kd-module-icon"><i data-lucide="{{ $item['icon'] }}"></i></span>
                        <span>
                            <span class="kd-module-name">{{ $item['nama'] }}</span>
                            <span class="kd-module-desc">{{ $item['desc'] }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="kd-subhead" style="margin-top: 20px;">
            <h4>Informasi Publik</h4>
            <span class="kd-chip">{{ count($informasiPublik) }} tautan</span>
        </div>

        <div class="kd-modules">
            @foreach($informasiPublik as $item)
                <a href="{{ route($item['route']) }}" wire:navigate class="kd-module">
                    <span class="kd-module-icon"><i data-lucide="{{ $item['icon'] }}"></i></span>
                    <span>
                        <span class="kd-module-name">{{ $item['nama'] }}</span>
                        <span class="kd-module-desc">{{ $item['desc'] }}</span>
                    </span>
                </a>
            @endforeach
        </div>

        <p class="kd-footnote">Masuk sebagai {{ $user->email }}</p>
    </div>

    <x-mobile.tabbar aktif="layanan" />
</div>
