{{-- Halaman Absensi mobile — kehadiran berbasis foto & koordinat lokasi --}}
<div class="kd-mobile kd-absensi"
     x-data="absensiKamera()"
     x-on:livewire-upload-start="isUploading = true"
     x-on:livewire-upload-finish="isUploading = false"
     x-on:livewire-upload-error="isUploading = false; fotoError = 'Foto gagal diunggah. Periksa koneksi lalu coba lagi.'"
     x-on:absensi-tersimpan.window="window.scrollTo({ top: 0, behavior: 'smooth' }); setTimeout(() => deteksiLokasi(), 400)"
>
    <div class="kd-header">
        <div class="kd-brand">
            <div class="kd-brand-icon">K</div>
            <span class="kd-brand-title">KORMI Kab. Bandung</span>
        </div>
        <p class="kd-brand-sub">Absensi Harian</p>
    </div>

    <div class="kd-sheet">
        @php
            $adaFoto = (bool) $foto;
            $adaLokasi = ! is_null($latitude) && ! is_null($longitude);
            $siapKirim = $adaFoto && $adaLokasi;
        @endphp

        {{-- Ringkasan status kehadiran --}}
        <section class="kd-abs-status {{ $tahap === 'selesai' ? 'is-done' : ($tahap === 'pulang' ? 'is-open' : 'is-idle') }}"
                 aria-label="Ringkasan kehadiran hari ini">
            <div class="kd-abs-status-top">
                <span class="kd-abs-status-icon">
                    @if($tahap === 'selesai')
                        <i data-lucide="badge-check"></i>
                    @elseif($tahap === 'pulang')
                        <i data-lucide="timer"></i>
                    @else
                        <i data-lucide="fingerprint"></i>
                    @endif
                </span>
                <span class="kd-abs-status-copy">
                    <span class="kd-abs-status-eyebrow">
                        <span class="kd-abs-overline">
                            <span class="kd-abs-live" aria-hidden="true"></span>
                            Kehadiran hari ini
                        </span>
                        <span class="kd-chip {{ $tahap === 'selesai' ? 'kd-chip--dark' : ($tahap === 'pulang' ? 'kd-chip--go' : 'kd-chip--warn') }}">
                            {{ match ($tahap) { 'masuk' => 'Belum Absen', 'pulang' => 'Sudah Masuk', default => 'Lengkap' } }}
                        </span>
                    </span>
                    <strong class="kd-abs-status-title">
                        @if($tahap === 'selesai')
                            Absensi hari ini lengkap
                        @elseif($tahap === 'pulang')
                            Sudah absen masuk pukul {{ $absensiHariIni->jam_masuk_rapi }} WIB
                        @else
                            Belum absen masuk
                        @endif
                    </strong>
                    <span class="kd-abs-status-meta">
                        {{ now('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMM YYYY') }}
                        <span aria-hidden="true">·</span>
                        <span x-text="jamSekarang">— WIB</span>
                    </span>
                </span>
            </div>

            <span class="kd-abs-status-rule" aria-hidden="true"></span>

            <div class="kd-abs-timeline" aria-label="Status absensi masuk dan pulang">
                <div class="kd-abs-step {{ $absensiHariIni ? 'is-done' : 'is-active' }}">
                    <span class="kd-abs-dot"><i data-lucide="{{ $absensiHariIni ? 'check' : 'log-in' }}"></i></span>
                    <span class="kd-abs-step-body">
                        <strong>Masuk</strong>
                        <span>
                            @if($absensiHariIni)
                                {{ $absensiHariIni->jam_masuk_rapi }} WIB
                                @if($absensiHariIni->alamat)
                                    · {{ \Illuminate\Support\Str::limit($absensiHariIni->alamat, 34) }}
                                @endif
                            @else
                                Belum dilakukan
                            @endif
                        </span>
                    </span>
                </div>

                <span class="kd-abs-line {{ $absensiHariIni?->sudahPulang() ? 'is-done' : '' }}" aria-hidden="true"></span>

                <div class="kd-abs-step {{ $absensiHariIni?->sudahPulang() ? 'is-done' : ($tahap === 'pulang' ? 'is-active' : '') }}">
                    <span class="kd-abs-dot"><i data-lucide="{{ $absensiHariIni?->sudahPulang() ? 'check' : 'log-out' }}"></i></span>
                    <span class="kd-abs-step-body">
                        <strong>Pulang</strong>
                        <span>
                            @if($absensiHariIni?->sudahPulang())
                                {{ $absensiHariIni->jam_pulang_rapi }} WIB
                                @if($absensiHariIni->alamat_pulang)
                                    · {{ \Illuminate\Support\Str::limit($absensiHariIni->alamat_pulang, 34) }}
                                @endif
                            @else
                                Belum dilakukan
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </section>

        @if($berhasil)
            <div class="kd-notice kd-notice-lime" role="status" aria-live="polite">
                <i data-lucide="badge-check"></i>
                <span>{{ $pesanBerhasil }}</span>
            </div>
        @endif

        @php
            $fotoMasuk = $absensiHariIni?->foto_masuk_url;
            $fotoPulang = $absensiHariIni?->foto_pulang_url;
        @endphp
        @if($fotoMasuk || $fotoPulang)
            <div class="kd-abs-photos">
                @if($fotoMasuk)
                    <figure class="kd-abs-photo">
                        <img src="{{ $fotoMasuk }}" alt="Foto absen masuk" loading="lazy">
                        <figcaption>Masuk · {{ $absensiHariIni->jam_masuk_rapi }} WIB</figcaption>
                    </figure>
                @endif
                @if($fotoPulang)
                    <figure class="kd-abs-photo">
                        <img src="{{ $fotoPulang }}" alt="Foto absen pulang" loading="lazy">
                        <figcaption>Pulang · {{ $absensiHariIni->jam_pulang_rapi }} WIB</figcaption>
                    </figure>
                @endif
            </div>
        @endif

        @if($tahap === 'selesai')
            @unless($berhasil)
                <div class="kd-notice kd-notice-lime">
                    <i data-lucide="check-circle-2"></i>
                    <span>Absensi masuk dan pulang hari ini sudah lengkap. Terima kasih atas kedisiplinan Anda.</span>
                </div>
            @endunless
        @else
            {{-- Kartu 1: foto kehadiran lewat kamera + deteksi wajah --}}
            <section class="kd-abs-camcard {{ $foto ? 'is-preview' : '' }}">
                <div class="kd-abs-camcard-head">
                    <span class="kd-abs-camcard-icon"><i data-lucide="scan-face"></i></span>
                    <span class="kd-abs-camcard-copy">
                        <strong>Foto Kehadiran</strong>
                        <span>Kamera langsung dengan deteksi wajah</span>
                    </span>
                    <span class="kd-abs-camcard-tag {{ $foto ? 'is-ok' : '' }}">{{ $foto ? 'Siap' : 'Wajib' }}</span>
                </div>

                @if($foto)
                    @php
                        // Cegah 500 (FileNotPreviewableException) untuk berkas yang
                        // tidak bisa dipratinjaukan, mis. HEIC/HEIF dari iPhone.
                        try {
                            $urlPratinjau = $foto->isPreviewable() ? $foto->temporaryUrl() : null;
                        } catch (\Throwable $e) {
                            $urlPratinjau = null;
                        }
                    @endphp
                    <div class="kd-abs-shot">
                        @if($urlPratinjau)
                            <img src="{{ $urlPratinjau }}" alt="Pratinjau foto kehadiran">
                        @else
                            <span class="kd-file-chip" style="align-self: center; margin: 18px auto 8px;">
                                <i data-lucide="file"></i>
                                <span>{{ $foto->getClientOriginalName() }}</span>
                            </span>
                        @endif
                        <span class="kd-abs-shot-badge"><i data-lucide="check"></i> Siap dikirim</span>
                        <button type="button" class="kd-abs-shot-retake" @click="bukaKamera()">
                            <i data-lucide="refresh-cw"></i>
                            <span>Ambil ulang</span>
                        </button>
                    </div>
                @else
                    <button type="button" class="kd-abs-launch" @click="bukaKamera()"
                            aria-label="Buka kamera untuk mengambil foto kehadiran">
                        <span class="kd-abs-launch-glow" aria-hidden="true"></span>
                        <span class="kd-abs-launch-face" aria-hidden="true"><i data-lucide="scan-face"></i></span>
                        <span class="kd-abs-launch-text">
                            <strong>Ambil foto selfie</strong>
                            <span>Deteksi wajah membantu memastikan wajah terlihat jelas</span>
                        </span>
                        <span class="kd-abs-launch-cta">
                            <i data-lucide="camera"></i>
                            Buka Kamera
                        </span>
                    </button>
                @endif

                <input x-ref="kameraFallback" type="file" accept="image/*" capture="user" class="hidden" @change="unggahFoto($event)">

                <template x-if="isUploading">
                    <span class="kd-abs-inline-status" role="status">
                        <span class="kd-spinner kd-spinner--dark"></span>
                        Mengunggah foto...
                    </span>
                </template>
                <template x-if="fotoError">
                    <span class="kd-error" role="alert" x-text="fotoError"></span>
                </template>
                @error('foto')
                    <span class="kd-error" role="alert">{{ $message }}</span>
                @enderror
            </section>

            {{-- Kartu 2: koordinat GPS --}}
            <section class="kd-abs-card">
                <div class="kd-abs-card-head">
                    <span class="kd-abs-card-icon"><i data-lucide="map-pin"></i></span>
                    <span class="kd-abs-card-title">
                        <strong>Koordinat Lokasi</strong>
                        <span>Deteksi otomatis melalui GPS</span>
                    </span>
                    <button type="button" class="kd-abs-refresh" @click="deteksiLokasi()" :disabled="isLocating"
                            :class="isLocating ? 'is-loading' : ''" aria-label="Perbarui lokasi GPS">
                        <i data-lucide="locate-fixed"></i>
                    </button>
                </div>

                @if($adaLokasi)
                    <div class="kd-abs-geo is-ok">
                        <span class="kd-abs-geo-icon"><i data-lucide="map-pinned"></i></span>
                        <span class="kd-abs-geo-body">
                            <strong>{{ $alamat ?: 'Titik koordinat terekam' }}</strong>
                            <span class="kd-abs-geo-coord">
                                {{ number_format($latitude, 6, '.', '') }}, {{ number_format($longitude, 6, '.', '') }}
                                @if($akurasi_meter)
                                    · ±{{ number_format($akurasi_meter, 0, ',', '.') }} m
                                @endif
                            </span>
                        </span>
                    </div>
                    <a class="kd-abs-geolink" href="https://www.google.com/maps?q={{ $latitude }},{{ $longitude }}"
                       target="_blank" rel="noopener noreferrer">
                        <i data-lucide="map"></i>
                        <span>Lihat titik di Google Maps</span>
                    </a>
                @else
                    <div class="kd-abs-geo">
                        <span class="kd-abs-geo-icon" x-show="isLocating">
                            <span class="kd-spinner kd-spinner--dark"></span>
                        </span>
                        <span class="kd-abs-geo-icon" x-show="! isLocating" style="display: none;">
                            <i data-lucide="map-pin-off"></i>
                        </span>
                        <span class="kd-abs-geo-body">
                            <strong x-show="isLocating">Mendeteksi lokasi...</strong>
                            <strong x-show="! isLocating" style="display: none;">Lokasi belum terdeteksi</strong>
                            <span>Izinkan akses lokasi agar titik kehadiran ikut terekam.</span>
                        </span>
                    </div>
                @endif

                <template x-if="gpsError">
                    <span class="kd-error" role="alert" x-text="gpsError"></span>
                </template>
                @error('latitude')
                    <span class="kd-error" role="alert">{{ $message }}</span>
                @enderror
            </section>

            {{-- Kartu 3: catatan --}}
            <section class="kd-abs-card">
                <div class="kd-abs-card-head">
                    <span class="kd-abs-card-icon"><i data-lucide="notebook-pen"></i></span>
                    <span class="kd-abs-card-title">
                        <strong>Catatan</strong>
                        <span>Keterangan tambahan untuk admin</span>
                    </span>
                    <span class="kd-abs-card-tag">Opsional</span>
                </div>
                <textarea id="catatanAbsensi" wire:model="catatan" class="kd-textarea" maxlength="500"
                          placeholder="Contoh: hadir di sekretariat KORMI untuk rapat koordinasi."></textarea>
                @error('catatan')
                    <span class="kd-error" role="alert">{{ $message }}</span>
                @enderror
            </section>

            @error('absensi')
                <div class="kd-errors" role="alert" style="margin-bottom: 10px;">{{ $message }}</div>
            @enderror

            <div class="kd-abs-actions">
                <div class="kd-abs-ready" role="status" aria-live="polite">
                    <span class="kd-abs-ready-item {{ $adaFoto ? 'is-ok' : '' }}">
                        <i data-lucide="{{ $adaFoto ? 'check' : 'camera' }}"></i>
                        <span>Foto</span>
                    </span>
                    <span class="kd-abs-ready-item {{ $adaLokasi ? 'is-ok' : '' }}">
                        <i data-lucide="{{ $adaLokasi ? 'check' : 'map-pin' }}"></i>
                        <span>Lokasi GPS</span>
                    </span>
                    <span class="kd-abs-ready-status {{ $siapKirim ? 'is-ok' : '' }}">
                        {{ $siapKirim ? 'Siap dikirim' : 'Belum lengkap' }}
                    </span>
                </div>
                @unless($siapKirim)
                    <p class="kd-abs-submit-hint">
                        {{ $adaFoto
                            ? 'Menunggu titik GPS terekam sebelum absensi dikirim.'
                            : ($adaLokasi
                                ? 'Ambil foto kehadiran untuk melanjutkan.'
                                : 'Ambil foto dan aktifkan GPS untuk melanjutkan.') }}
                    </p>
                @endunless
                <button type="button" wire:click="simpan" class="kd-btn-primary kd-abs-submit"
                        x-bind:disabled="isUploading || isLocating || {{ $siapKirim ? 'false' : 'true' }}"
                        wire:loading.attr="disabled" wire:target="simpan">
                    <span wire:loading.remove wire:target="simpan">
                        <i data-lucide="{{ $tahap === 'masuk' ? 'log-in' : 'log-out' }}" class="w-4 h-4"></i>
                        {{ $tahap === 'masuk' ? 'Absen Masuk Sekarang' : 'Absen Pulang' }}
                    </span>
                    <span wire:loading wire:target="simpan">
                        <span class="kd-spinner"></span>
                        Menyimpan...
                    </span>
                </button>
            </div>
        @endif

        <div class="kd-subhead">
            <h4>Riwayat Absensi</h4>
            <span class="kd-chip">{{ $riwayat->count() }} hari</span>
        </div>

        @forelse($riwayat as $log)
            <div class="kd-abs-history">
                <span class="kd-abs-history-date">
                    <strong>{{ $log->tanggal->format('d') }}</strong>
                    <span>{{ $log->tanggal->locale('id')->isoFormat('MMM') }}</span>
                </span>
                <span class="kd-abs-history-body">
                    <strong>{{ $log->tanggal->locale('id')->isoFormat('dddd') }}</strong>
                    <span>
                        {{ $log->jam_masuk_rapi ?? '—' }} – {{ $log->jam_pulang_rapi ?? 'belum pulang' }} WIB
                        @if($log->alamat)
                            · {{ \Illuminate\Support\Str::limit($log->alamat, 30) }}
                        @endif
                    </span>
                </span>
                <span class="kd-chip {{ $log->sudahPulang() ? '' : 'kd-chip--warn' }}">
                    {{ $log->sudahPulang() ? 'Lengkap' : 'Masuk' }}
                </span>
            </div>
        @empty
            <div class="kd-notice">
                <i data-lucide="calendar-x"></i>
                <span>Belum ada riwayat absensi. Absensi hari ini akan muncul di sini besok.</span>
            </div>
        @endforelse

        <p class="kd-footnote">Foto dan koordinat lokasi hanya digunakan untuk verifikasi kehadiran.</p>
    </div>

    {{-- Overlay kamera langsung dengan deteksi wajah --}}
    <div class="kd-abs-cam" x-show="kameraTerbuka" style="display: none;"
         role="dialog" aria-modal="true" aria-label="Kamera foto kehadiran"
         @keydown.escape.window="tutupKamera()">
        <div class="kd-abs-cam-shell">
            <header class="kd-abs-cam-head">
                <span class="kd-abs-cam-head-copy">
                    <span class="kd-abs-overline">Foto kehadiran</span>
                    <strong>Ambil selfie absensi</strong>
                </span>
                <button type="button" class="kd-abs-cam-close" x-ref="tombolTutup" @click="tutupKamera()"
                        aria-label="Tutup kamera">
                    <i data-lucide="x"></i>
                </button>
            </header>

            <div class="kd-abs-cam-stage">
                <video x-ref="videoKamera" autoplay playsinline muted
                       :class="modeKamera === 'user' ? 'is-mirrored' : ''"></video>

                <div class="kd-abs-cam-guide" x-show="! izinKameraError">
                    <span class="kd-abs-cam-oval" :class="wajahTerdeteksi ? 'is-ok' : ''"></span>
                    <span class="kd-abs-cam-scan" x-show="statusDeteksi === 'aktif' && ! wajahTerdeteksi"
                          aria-hidden="true"></span>
                </div>

                <span class="kd-abs-cam-pill"
                      role="status" aria-live="polite"
                      :class="izinKameraError ? 'is-error' : (wajahTerdeteksi ? 'is-ok' : (statusDeteksi === 'tidak-didukung' ? 'is-muted' : 'is-warn'))">
                    <i data-lucide="scan-face"></i>
                    <span x-text="labelDeteksi()">Menyiapkan kamera...</span>
                </span>

                <div class="kd-abs-cam-fallback" x-show="izinKameraError" style="display: none;">
                    <span class="kd-abs-cam-fallback-icon"><i data-lucide="video-off"></i></span>
                    <p x-text="izinKameraError"></p>
                    <div class="kd-abs-cam-fallback-actions">
                        <button type="button" class="kd-abs-cam-btn is-solid" @click="bukaKamera()">Coba lagi</button>
                        <button type="button" class="kd-abs-cam-btn" @click="bukaKameraPerangkat()">Kamera perangkat</button>
                    </div>
                </div>
            </div>

            <p class="kd-abs-cam-error" role="alert" x-show="fotoError" style="display: none;"
               x-text="fotoError"></p>

            <footer class="kd-abs-cam-foot">
                <button type="button" class="kd-abs-cam-tool" @click="gantiKamera()"
                        :disabled="! kameraSiap || !! izinKameraError" aria-label="Ganti kamera depan atau belakang">
                    <i data-lucide="switch-camera"></i>
                </button>

                <button type="button" class="kd-abs-cam-shutter" @click="ambilFoto()"
                        :class="wajahTerdeteksi ? 'is-ready' : ''"
                        :disabled="! kameraSiap || !! izinKameraError"
                        aria-label="Ambil foto kehadiran">
                    <span class="kd-abs-cam-shutter-ring"></span>
                </button>

                <button type="button" class="kd-abs-cam-tool" @click="bukaKameraPerangkat()"
                        aria-label="Gunakan kamera perangkat">
                    <i data-lucide="camera"></i>
                </button>
            </footer>

            <p class="kd-abs-cam-hint">Pastikan wajah terlihat jelas dengan pencahayaan cukup. Deteksi wajah diproses di perangkat Anda.</p>
        </div>
    </div>

    <x-mobile.tabbar aktif="absensi" />
</div>
