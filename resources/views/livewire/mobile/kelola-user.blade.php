{{-- Kelola user mobile — khusus Super Admin --}}
<div class="kd-mobile kd-users min-h-screen">
    <div class="kd-header">
        <div class="kd-brand">
            <div class="kd-brand-icon">K</div>
            <span class="kd-brand-title">KORMI Kab. Bandung</span>
        </div>
        <p class="kd-brand-sub">Kelola User</p>
    </div>

    <div class="kd-sheet">
        <a href="{{ route('mobile.dashboard') }}" wire:navigate class="kd-backlink kd-users-back">
            <i data-lucide="chevron-left"></i>
            <span>Dashboard</span>
        </a>

        @if($pesan)
            <div class="kd-notice kd-notice-lime" role="status" aria-live="polite">
                <i data-lucide="check-circle"></i>
                <span>{{ $pesan }}</span>
            </div>
        @endif

        @if($galat)
            <div class="kd-notice kd-notice-rose" role="alert">
                <i data-lucide="alert-circle"></i>
                <span>{{ $galat }}</span>
            </div>
        @endif

        <div class="kd-account kd-users-intro">
            <span class="kd-users-avatar kd-users-avatar--lg">
                @if(auth()->user()?->foto_profil_url)
                    <img src="{{ auth()->user()->foto_profil_url }}" alt="{{ auth()->user()->nama_lengkap }}" loading="lazy">
                @else
                    {{ strtoupper(mb_substr(auth()->user()?->nama_lengkap ?? 'SA', 0, 2)) }}
                @endif
            </span>
            <div class="kd-users-intro-copy">
                <strong>{{ auth()->user()?->nama_lengkap }}</strong>
                <span class="kd-users-intro-meta">{{ auth()->user()?->email }}</span>
                <span class="kd-users-tags">
                    <span class="kd-chip kd-chip--dark">{{ auth()->user()?->peran?->nama_peran ?? 'Super Admin' }}</span>
                    <span class="kd-chip">Akses penuh</span>
                </span>
            </div>
        </div>

        <div class="kd-control kd-users-search">
            <input type="text" wire:model.live.debounce.400ms="cari" class="kd-input"
                   placeholder="Cari nama / email…" aria-label="Cari pengguna" autocomplete="off">
            <span class="kd-icon"><i data-lucide="search"></i></span>
        </div>

        <div class="kd-users-filter" role="group" aria-label="Filter peran pengguna">
            <button type="button" wire:click="$set('peranDipilih', 'Semua')"
                    class="kd-users-filter-btn {{ $peranDipilih === 'Semua' ? 'is-active' : '' }}"
                    aria-pressed="{{ $peranDipilih === 'Semua' ? 'true' : 'false' }}">
                Semua
            </button>
            @foreach($daftarPeran as $peran)
                <button type="button" wire:click="$set('peranDipilih', '{{ $peran->id }}')"
                        class="kd-users-filter-btn {{ $peranDipilih === $peran->id ? 'is-active' : '' }}"
                        aria-pressed="{{ $peranDipilih === $peran->id ? 'true' : 'false' }}">
                    {{ $peran->nama_peran }}
                </button>
            @endforeach
        </div>

        <p class="kd-users-count" aria-live="polite">
            Menampilkan <strong>{{ number_format($penggunaList->total()) }}</strong> pengguna
            @if(trim($cari) !== '')
                untuk "<strong>{{ $cari }}</strong>"
            @endif
        </p>

        @if($penggunaList->isEmpty())
            <div class="kd-empty">
                <i data-lucide="user-x"></i>
                <strong>Pengguna tidak ditemukan</strong>
                <p>Tidak ada akun yang cocok dengan kata kunci atau peran terpilih.</p>
                @if(trim($cari) !== '' || $peranDipilih !== 'Semua')
                    <button type="button" wire:click="$set('cari', ''); $set('peranDipilih', 'Semua')" class="kd-page-btn">
                        Reset filter
                    </button>
                @endif
            </div>
        @else
            <div class="kd-users-list">
                @foreach($penggunaList as $pengguna)
                    <article class="kd-users-row" wire:key="pengguna-{{ $pengguna->id }}">
                        <span class="kd-users-avatar">
                            @if($pengguna->foto_profil_url)
                                <img src="{{ $pengguna->foto_profil_url }}" alt="" loading="lazy">
                            @else
                                {{ strtoupper(mb_substr($pengguna->nama_lengkap, 0, 2)) }}
                            @endif
                        </span>

                        <div class="kd-users-copy">
                            <div class="kd-users-headline">
                                <strong>{{ $pengguna->nama_lengkap }}</strong>
                                @if($pengguna->id === auth()->id())
                                    <span class="kd-chip kd-chip--dark">Anda</span>
                                @elseif($pengguna->status_aktif)
                                    <button type="button" wire:click="impersonate('{{ $pengguna->id }}')"
                                            wire:confirm="Masuk sebagai {{ $pengguna->nama_lengkap }}? Anda dapat kembali ke akun Super Admin kapan saja."
                                            wire:loading.attr="disabled" wire:target="impersonate"
                                            aria-label="Masuk sebagai {{ $pengguna->nama_lengkap }}"
                                            class="kd-users-open">
                                        <i data-lucide="log-in"></i>
                                        <span>Masuk</span>
                                    </button>
                                @endif
                            </div>
                            <span class="kd-users-mail">{{ $pengguna->email }}</span>
                            @php $online = $pengguna->isOnline(); @endphp
                            <span class="kd-users-presence">
                                <span class="kd-users-online {{ $online ? 'is-online' : '' }}">
                                    <span class="kd-users-online-dot"></span>
                                    {{ $online ? 'Online' : 'Offline' }}
                                </span>
                                <span class="kd-users-login" @if($pengguna->terakhir_masuk) title="{{ $pengguna->terakhir_masuk->translatedFormat('d M Y H:i') }}" @endif>
                                    <i data-lucide="clock"></i>
                                    @if($pengguna->terakhir_masuk)
                                        Login {{ $pengguna->terakhir_masuk->locale('id')->diffForHumans() }}
                                    @else
                                        Belum pernah login
                                    @endif
                                </span>
                            </span>
                            <span class="kd-users-tags">
                                <span class="kd-chip">{{ $pengguna->peran?->nama_peran ?? 'Tanpa peran' }}</span>
                                @if($pengguna->status_aktif)
                                    <span class="kd-chip kd-chip--lime">Aktif</span>
                                @else
                                    <span class="kd-chip kd-chip--danger">Nonaktif</span>
                                @endif
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($penggunaList->hasPages())
                <div class="kd-pagination" wire:key="users-pager-{{ $penggunaList->currentPage() }}">
                    <button type="button" wire:click="previousPage" wire:loading.attr="disabled" wire:target="previousPage"
                            @disabled($penggunaList->onFirstPage()) class="kd-page-btn">
                        <i data-lucide="chevron-left"></i>
                        <span>Sebelumnya</span>
                    </button>
                    <span class="kd-page-info">{{ $penggunaList->currentPage() }} / {{ $penggunaList->lastPage() }}</span>
                    <button type="button" wire:click="nextPage" wire:loading.attr="disabled" wire:target="nextPage"
                            @disabled(! $penggunaList->hasMorePages()) class="kd-page-btn">
                        <span>Berikutnya</span>
                        <i data-lucide="chevron-right"></i>
                    </button>
                </div>
            @endif
        @endif
    </div>

    <x-mobile.tabbar aktif="dashboard" />
</div>
