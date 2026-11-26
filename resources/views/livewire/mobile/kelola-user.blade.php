{{-- Kelola user mobile — khusus Super Admin --}}
<div class="kd-mobile kd-users min-h-screen">
    <header class="kd-verify-head">
        <a href="{{ route('mobile.dashboard') }}" wire:navigate class="kd-backlink kd-verify-back">
            <i data-lucide="arrow-left"></i> Dashboard
        </a>

        <div class="kd-verify-title">
            <span class="kd-verify-title-icon"><i data-lucide="user-cog"></i></span>
            <div>
                <h1>Kelola User</h1>
                <p>Daftar akun pengguna, filter per peran, dan masuk sebagai pengguna.</p>
            </div>
        </div>
    </header>

    <div class="kd-users-body">
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

        <div class="kd-control kd-users-search">
            <input type="text" wire:model.live.debounce.400ms="cari" class="kd-input"
                   placeholder="Cari nama / email…" aria-label="Cari pengguna">
            <span class="kd-icon"><i data-lucide="search"></i></span>
        </div>

        <div class="kd-users-chips" role="group" aria-label="Filter peran pengguna">
            <button type="button" wire:click="$set('peranDipilih', 'Semua')"
                    class="kd-users-chip {{ $peranDipilih === 'Semua' ? 'is-active' : '' }}"
                    aria-pressed="{{ $peranDipilih === 'Semua' ? 'true' : 'false' }}">
                Semua
            </button>
            @foreach($daftarPeran as $peran)
                <button type="button" wire:click="$set('peranDipilih', '{{ $peran->id }}')"
                        class="kd-users-chip {{ $peranDipilih === $peran->id ? 'is-active' : '' }}"
                        aria-pressed="{{ $peranDipilih === $peran->id ? 'true' : 'false' }}">
                    {{ $peran->nama_peran }}
                </button>
            @endforeach
        </div>

        <p class="kd-users-count">
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
                    <article class="kd-users-card" wire:key="pengguna-{{ $pengguna->id }}">
                        <div class="kd-users-item">
                            <span class="kd-users-avatar">
                                @if($pengguna->foto_profil_url)
                                    <img src="{{ $pengguna->foto_profil_url }}" alt="" loading="lazy">
                                @else
                                    {{ strtoupper(mb_substr($pengguna->nama_lengkap, 0, 2)) }}
                                @endif
                            </span>

                            <span class="kd-users-copy">
                                <strong>{{ $pengguna->nama_lengkap }}</strong>
                                <span class="kd-users-mail">{{ $pengguna->email }}</span>
                                <span class="kd-users-tags">
                                    <span class="kd-chip">{{ $pengguna->peran?->nama_peran ?? 'Tanpa peran' }}</span>
                                    @if($pengguna->status_aktif)
                                        <span class="kd-chip kd-chip--lime">Aktif</span>
                                    @else
                                        <span class="kd-chip kd-chip--danger">Nonaktif</span>
                                    @endif
                                </span>
                            </span>
                        </div>

                        <div class="kd-users-actions">
                            @if($pengguna->id === auth()->id())
                                <button type="button" class="kd-users-btn" disabled>Akun Anda</button>
                            @elseif(! $pengguna->status_aktif)
                                <button type="button" class="kd-users-btn" disabled>Akun nonaktif</button>
                            @else
                                <button type="button" wire:click="impersonate('{{ $pengguna->id }}')"
                                        wire:confirm="Masuk sebagai {{ $pengguna->nama_lengkap }}? Anda dapat kembali ke akun Super Admin kapan saja."
                                        wire:loading.attr="disabled"
                                        class="kd-users-btn is-primary">
                                    <i data-lucide="log-in"></i> Masuk sebagai
                                </button>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            @if($penggunaList->hasPages())
                <div class="kd-pagination" wire:key="users-pager-{{ $penggunaList->currentPage() }}">
                    <button type="button" wire:click="previousPage" wire:loading.attr="disabled"
                            @disabled($penggunaList->onFirstPage()) class="kd-page-btn">
                        <i data-lucide="chevron-left"></i>
                        <span>Sebelumnya</span>
                    </button>
                    <span class="kd-page-info">{{ $penggunaList->currentPage() }} / {{ $penggunaList->lastPage() }}</span>
                    <button type="button" wire:click="nextPage" wire:loading.attr="disabled"
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