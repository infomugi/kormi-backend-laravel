{{-- Dashboard mobile untuk peran pengelola (super admin, korcam, inorga, editor) — desain mobile_kormi.html --}}
<div class="kd-mobile min-h-screen">
    <div class="kd-header">
        <div class="kd-brand">
            <div class="kd-brand-icon">K</div>
            <span class="kd-brand-title">KORMI Kab. Bandung</span>
        </div>
        <p class="kd-brand-sub">Dashboard {{ $roleLabel }}</p>
    </div>

    <div class="kd-sheet">
        <div class="kd-section-head">
            <div>
                <h3>Halo, {{ \Illuminate\Support\Str::words($user->nama_lengkap, 2, '') }}</h3>
                <p>Ringkasan data dan menu cepat sesuai peran Anda.</p>
            </div>
            <span class="kd-badge">{{ $roleLabel }}</span>
        </div>

        <div class="kd-account" style="display: flex; align-items: center; gap: 12px;">
            <span class="kd-duta-avatar" style="width: 52px; height: 52px; font-size: 17px;">
                {{ strtoupper(\Illuminate\Support\Str::substr($user->nama_lengkap, 0, 2)) }}
            </span>
            <div style="min-width: 0; flex: 1;">
                <strong style="display: block; font-size: 13px; font-weight: 800; line-height: 1.35;">{{ $user->nama_lengkap }}</strong>
                <div class="kd-item-meta" style="text-transform: none; margin-top: 4px;">{{ $user->email }}</div>
            </div>
        </div>

        @if($isSuper && $dutaMenunggu > 0)
            <div class="kd-notice kd-notice-amber">
                <i data-lucide="clock"></i>
                <span><strong>{{ $dutaMenunggu }} pendaftaran duta</strong> menunggu verifikasi. <a href="{{ route('admin.duta') }}" wire:navigate style="font-weight: 800; color: inherit; text-decoration: underline;">Tinjau sekarang</a>.</span>
            </div>
        @endif

        <div class="kd-subhead">
            <h4>Ringkasan Data</h4>
            <span class="kd-chip kd-chip--dark">{{ count($modul) }} modul</span>
        </div>

        <div class="kd-stats">
            @foreach($stats as $stat)
                <div class="kd-stat">
                    <span class="kd-stat-icon"><i data-lucide="{{ $stat['icon'] }}"></i></span>
                    <span>
                        <span class="kd-stat-value">{{ $stat['value'] }}</span>
                        <span class="kd-stat-label">{{ $stat['label'] }}</span>
                    </span>
                </div>
            @endforeach
        </div>

        <div class="kd-success-actions" style="margin: 16px 0 4px;">
            <a href="{{ route('admin.dashboard') }}" class="kd-btn-primary">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                <span>Buka Dashboard CMS</span>
            </a>
        </div>

        <div class="kd-subhead" style="margin-top: 20px;">
            <h4>Menu Cepat</h4>
        </div>

        <div class="kd-modules">
            @foreach($modul as $item)
                <a href="{{ route($item['route']) }}" class="kd-module">
                    <span class="kd-module-icon"><i data-lucide="{{ $item['icon'] }}"></i></span>
                    <span>
                        <span class="kd-module-name">{{ $item['label'] }}</span>
                    </span>
                </a>
            @endforeach
        </div>

        <div class="kd-subhead" style="margin-top: 20px;">
            <h4>{{ $terbaruJudul }}</h4>
            <a href="{{ $terbaruLink }}" wire:navigate>Lihat semua</a>
        </div>

        @forelse($terbaru as $baris)
            <a href="{{ $baris['url'] }}" class="kd-item" style="text-decoration: none; color: inherit;">
                <span class="kd-module-icon"><i data-lucide="{{ $terbaruIcon }}"></i></span>
                <span class="kd-item-body">
                    <span class="kd-item-title">{{ $baris['judul'] }}</span>
                    <span class="kd-item-meta" style="text-transform: none;">{{ $baris['meta'] }}</span>
                </span>
                <i data-lucide="chevron-right" class="w-4 h-4" style="color: #c3c6bf; flex-shrink: 0;"></i>
            </a>
        @empty
            <div class="kd-empty">
                <i data-lucide="{{ $terbaruIcon }}"></i>
                <strong>Belum ada data</strong>
                <p>Data {{ strtolower($terbaruJudul) }} akan tampil di sini setelah ditambahkan melalui CMS.</p>
            </div>
        @endforelse

        <form method="POST" action="{{ route('admin.keluar') }}" style="margin-top: 18px;">
            @csrf
            <button type="submit" class="kd-btn-ghost" style="width: 100%;">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Keluar dari Akun</span>
            </button>
        </form>

        <p class="kd-footnote">Masuk sebagai {{ $user->email }}</p>
    </div>

        <x-mobile.tabbar aktif="dashboard" />
</div>
