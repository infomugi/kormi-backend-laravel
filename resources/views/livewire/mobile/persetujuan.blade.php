{{-- Pusat persetujuan mobile — khusus Super Admin --}}
<div class="kd-mobile kd-verify min-h-screen">
    <header class="kd-verify-head">
        <a href="{{ route('mobile.dashboard') }}" wire:navigate class="kd-backlink kd-verify-back">
            <i data-lucide="arrow-left"></i> Dashboard
        </a>

        <div class="kd-verify-title">
            <span class="kd-verify-title-icon"><i data-lucide="badge-check"></i></span>
            <div>
                <h1>Persetujuan</h1>
                <p>Verifikasi pendaftaran duta dan aktivasi akun baru.</p>
            </div>
        </div>
    </header>

    <div class="kd-verify-body">
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

        <div class="kd-verify-tabs" role="tablist" aria-label="Jenis persetujuan">
            <button type="button" role="tab" wire:click="pilihTab('duta')"
                    aria-selected="{{ $tab === 'duta' ? 'true' : 'false' }}"
                    class="kd-verify-tab {{ $tab === 'duta' ? 'is-active' : '' }}">
                <span>Pendaftaran Duta</span>
                <span class="kd-verify-count {{ $dutaMenunggu > 0 ? 'is-pending' : '' }}">{{ $dutaMenunggu }}</span>
            </button>
            <button type="button" role="tab" wire:click="pilihTab('akun')"
                    aria-selected="{{ $tab === 'akun' ? 'true' : 'false' }}"
                    class="kd-verify-tab {{ $tab === 'akun' ? 'is-active' : '' }}">
                <span>Akun Baru</span>
                <span class="kd-verify-count {{ $akunMenunggu > 0 ? 'is-pending' : '' }}">{{ $akunMenunggu }}</span>
            </button>
        </div>

        @if($tab === 'duta')
            @if($daftarDuta->isEmpty())
                <div class="kd-empty">
                    <i data-lucide="inbox"></i>
                    <strong>Tidak ada pendaftaran duta</strong>
                    <p>Semua pendaftaran duta olahraga sudah diverifikasi.</p>
                </div>
            @else
                <div class="kd-verify-list">
                    @foreach($daftarDuta as $duta)
                        <article class="kd-verify-card" wire:key="duta-{{ $duta->id }}">
                            <div class="kd-verify-item">
                                <span class="kd-verify-avatar">
                                    @if($duta->foto_duta_url)
                                        <img src="{{ $duta->foto_duta_url }}" alt="" loading="lazy">
                                    @else
                                        {{ $duta->initial_dua_huruf }}
                                    @endif
                                </span>

                                <span class="kd-verify-copy">
                                    <strong>{{ $duta->nama_lengkap }}</strong>
                                    <span class="kd-verify-sub">
                                        {{ $duta->desaKelurahan?->nama_desa_kelurahan ? 'Desa ' . $duta->desaKelurahan->nama_desa_kelurahan : 'Desa belum diisi' }}
                                        · {{ $duta->kecamatan?->nama_kecamatan ?? 'Kecamatan belum diisi' }}
                                    </span>
                                    <span class="kd-verify-meta">
                                        <i data-lucide="clock"></i>
                                        Mendaftar {{ \Carbon\Carbon::parse($duta->dibuat_pada)->locale('id')->isoFormat('D MMM Y') }}
                                        @if($duta->nomor_telepon)
                                            · {{ $duta->nomor_telepon }}
                                        @endif
                                    </span>
                                </span>

                                <span class="kd-chip kd-chip--warn">Duta</span>
                            </div>

                            <div class="kd-verify-facts">
                                <span class="kd-verify-fact">{{ $duta->kategori_duta ?: 'Duta Olahraga' }}</span>
                                <span class="kd-verify-fact">Tahun {{ $duta->tahun_pemilihan ?: '-' }}</span>
                                @if($duta->gelar_prestasi)
                                    <span class="kd-verify-fact">{{ $duta->gelar_prestasi }}</span>
                                @endif
                            </div>

                            @if($tolakId === $duta->id)
                                <div class="kd-verify-reject">
                                    <label for="catatan-{{ $duta->id }}">Catatan penolakan (opsional)</label>
                                    <textarea id="catatan-{{ $duta->id }}" wire:model="catatan" rows="2" maxlength="500"
                                              placeholder="Contoh: data prestasi belum lengkap"></textarea>
                                    @error('catatan')
                                        <p class="kd-error">{{ $message }}</p>
                                    @enderror
                                    <div class="kd-verify-actions">
                                        <button type="button" wire:click="batalTolak" class="kd-verify-btn is-ghost">Batal</button>
                                        <button type="button" wire:click="tolakDuta" class="kd-verify-btn is-danger">Tolak pendaftaran</button>
                                    </div>
                                </div>
                            @else
                                <div class="kd-verify-actions">
                                    <button type="button" wire:click="mulaiTolak('{{ $duta->id }}')" class="kd-verify-btn is-ghost">Tolak</button>
                                    <button type="button" wire:click="setujuiDuta('{{ $duta->id }}')"
                                            wire:confirm="Setujui pendaftaran {{ $duta->nama_lengkap }}? Akun pendaftar akan aktif sebagai Duta Olahraga."
                                            wire:loading.attr="disabled"
                                            class="kd-verify-btn is-approve">
                                        <i data-lucide="check"></i> Setujui
                                    </button>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>

                @if($daftarDuta->hasPages())
                    <div class="kd-verify-pager">
                        <button type="button" wire:click="previousPage('dutaPage')" @disabled($daftarDuta->onFirstPage())>Sebelumnya</button>
                        <span>{{ $daftarDuta->currentPage() }} / {{ $daftarDuta->lastPage() }}</span>
                        <button type="button" wire:click="nextPage('dutaPage')" @disabled(! $daftarDuta->hasMorePages())>Berikutnya</button>
                    </div>
                @endif
            @endif
        @else
            @if($daftarAkun->isEmpty())
                <div class="kd-empty">
                    <i data-lucide="inbox"></i>
                    <strong>Tidak ada akun menunggu</strong>
                    <p>Semua akun baru sudah diaktifkan.</p>
                </div>
            @else
                <div class="kd-verify-list">
                    @foreach($daftarAkun as $akun)
                        <article class="kd-verify-card" wire:key="akun-{{ $akun->id }}">
                            <div class="kd-verify-item">
                                <span class="kd-verify-avatar">
                                    @if($akun->foto_profil_url)
                                        <img src="{{ $akun->foto_profil_url }}" alt="" loading="lazy">
                                    @else
                                        {{ strtoupper(mb_substr($akun->nama_lengkap, 0, 2)) }}
                                    @endif
                                </span>

                                <span class="kd-verify-copy">
                                    <strong>{{ $akun->nama_lengkap }}</strong>
                                    <span class="kd-verify-sub">{{ $akun->email }}</span>
                                    <span class="kd-verify-meta">
                                        <i data-lucide="clock"></i>
                                        Terdaftar {{ \Carbon\Carbon::parse($akun->dibuat_pada)->locale('id')->isoFormat('D MMM Y') }}
                                        @if($akun->peran?->nama_peran)
                                            · {{ $akun->peran->nama_peran }}
                                        @endif
                                    </span>
                                </span>

                                <span class="kd-chip">Akun</span>
                            </div>

                            <div class="kd-verify-actions">
                                <button type="button" wire:click="setujuiAkun('{{ $akun->id }}')"
                                        wire:confirm="Aktifkan akun {{ $akun->nama_lengkap }}?"
                                        wire:loading.attr="disabled"
                                        class="kd-verify-btn is-approve">
                                    <i data-lucide="check"></i> Setujui akun
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($daftarAkun->hasPages())
                    <div class="kd-verify-pager">
                        <button type="button" wire:click="previousPage('akunPage')" @disabled($daftarAkun->onFirstPage())>Sebelumnya</button>
                        <span>{{ $daftarAkun->currentPage() }} / {{ $daftarAkun->lastPage() }}</span>
                        <button type="button" wire:click="nextPage('akunPage')" @disabled(! $daftarAkun->hasMorePages())>Berikutnya</button>
                    </div>
                @endif
            @endif
        @endif
    </div>

    <x-mobile.tabbar aktif="dashboard" />
</div>
