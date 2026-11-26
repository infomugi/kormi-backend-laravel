{{-- Halaman Profil mobile — desain mobile_kormi.html --}}
<div class="kd-mobile min-h-screen">
    <div class="kd-header">
        <div class="kd-brand">
            <div class="kd-brand-icon">K</div>
            <span class="kd-brand-title">KORMI Kab. Bandung</span>
        </div>
        <p class="kd-brand-sub">Profil Saya</p>
    </div>

    <div class="kd-sheet">
        <div class="kd-account" style="display: flex; align-items: center; gap: 12px;">
            <span class="kd-duta-avatar" style="width: 52px; height: 52px; font-size: 17px;">
                @if($user->foto_profil_url)
                    <img src="{{ $user->foto_profil_url }}" alt="{{ $user->nama_lengkap }}" loading="lazy">
                @else
                    {{ strtoupper(\Illuminate\Support\Str::substr($user->nama_lengkap, 0, 2)) }}
                @endif
            </span>
            <div style="min-width: 0; flex: 1;">
                <strong style="display: block; font-size: 13px; font-weight: 800; line-height: 1.35;">{{ $user->nama_lengkap }}</strong>
                <div class="kd-item-meta" style="text-transform: none; margin-top: 4px;">{{ $user->email }}</div>
                <div style="display: flex; flex-wrap: wrap; gap: 5px; margin-top: 6px;">
                    <span class="kd-chip">{{ $roleLabel }}</span>
                    @if($duta)
                        <span class="kd-chip kd-chip--dark">Duta Olahraga</span>
                    @endif
                    <span class="kd-chip {{ $user->status_aktif ? 'kd-chip--dark' : 'kd-chip--danger' }}">{{ $user->status_aktif ? 'Aktif' : 'Nonaktif' }}</span>
                </div>
            </div>
        </div>

        <div class="kd-segment" role="tablist" aria-label="Bagian profil">
            <button type="button" role="tab" id="tab-profil" aria-controls="panel-profil"
                aria-selected="{{ $tab === 'profil' ? 'true' : 'false' }}"
                class="kd-segment-btn {{ $tab === 'profil' ? 'is-active' : '' }}"
                wire:click="pilihTab('profil')">
                <i data-lucide="user-round"></i>
                <span>Profil</span>
            </button>
            <button type="button" role="tab" id="tab-data" aria-controls="panel-data"
                aria-selected="{{ $tab === 'data' ? 'true' : 'false' }}"
                class="kd-segment-btn {{ $tab === 'data' ? 'is-active' : '' }}"
                wire:click="pilihTab('data')">
                <i data-lucide="square-pen"></i>
                <span>Ubah Data</span>
            </button>
            <button type="button" role="tab" id="tab-keamanan" aria-controls="panel-keamanan"
                aria-selected="{{ $tab === 'keamanan' ? 'true' : 'false' }}"
                class="kd-segment-btn {{ $tab === 'keamanan' ? 'is-active' : '' }}"
                wire:click="pilihTab('keamanan')">
                <i data-lucide="shield-check"></i>
                <span>Keamanan</span>
            </button>
        </div>

        @if($tab === 'profil')
            <div class="kd-panel" role="tabpanel" id="panel-profil" aria-labelledby="tab-profil">
                <div class="kd-subhead">
                    <h4>Informasi Akun</h4>
                    <span class="kd-chip">{{ $badgePeran }}</span>
                </div>

                <div class="kd-item">
                    <span class="kd-module-icon"><i data-lucide="mail"></i></span>
                    <span class="kd-item-body">
                        <span class="kd-item-title">{{ $user->email }}</span>
                        <span class="kd-item-meta" style="text-transform: none;">Email akun</span>
                    </span>
                </div>

                <div class="kd-item">
                    <span class="kd-module-icon"><i data-lucide="phone"></i></span>
                    <span class="kd-item-body">
                        <span class="kd-item-title">{{ $user->nomor_telepon ?: 'Belum diisi' }}</span>
                        <span class="kd-item-meta" style="text-transform: none;">Nomor telepon</span>
                    </span>
                </div>

                @if($user->kecamatan || $user->desa)
                    <div class="kd-item">
                        <span class="kd-module-icon"><i data-lucide="map-pin"></i></span>
                        <span class="kd-item-body">
                            <span class="kd-item-title">
                                {{ collect([$user->desa?->nama_desa_kelurahan, $user->kecamatan?->nama_kecamatan])->filter()->implode(', ') }}
                            </span>
                            <span class="kd-item-meta" style="text-transform: none;">Wilayah</span>
                        </span>
                    </div>
                @endif

                @if($user->pekerjaan)
                    <div class="kd-item">
                        <span class="kd-module-icon"><i data-lucide="briefcase"></i></span>
                        <span class="kd-item-body">
                            <span class="kd-item-title">{{ $user->pekerjaan }}</span>
                            <span class="kd-item-meta" style="text-transform: none;">Pekerjaan</span>
                        </span>
                    </div>
                @endif

                <div class="kd-item">
                    <span class="kd-module-icon"><i data-lucide="calendar-days"></i></span>
                    <span class="kd-item-body">
                        <span class="kd-item-title">{{ $user->dibuat_pada ? \Carbon\Carbon::parse($user->dibuat_pada)->translatedFormat('d M Y') : '-' }}</span>
                        <span class="kd-item-meta" style="text-transform: none;">Bergabung sejak</span>
                    </span>
                </div>

                <div class="kd-item">
                    <span class="kd-module-icon"><i data-lucide="clock"></i></span>
                    <span class="kd-item-body">
                        <span class="kd-item-title">{{ $user->terakhir_masuk ? \Carbon\Carbon::parse($user->terakhir_masuk)->translatedFormat('d M Y H:i') : 'Belum pernah' }}</span>
                        <span class="kd-item-meta" style="text-transform: none;">Terakhir masuk</span>
                    </span>
                </div>

                <div class="kd-subhead" style="margin-top: 22px;">
                    <h4>Profil Duta Olahraga</h4>
                    @if($duta)
                        <span class="kd-chip {{ $duta->status_pendaftaran === \App\Models\Kormi\DutaOlahraga::STATUS_DISETUJUI ? 'kd-chip--lime' : 'kd-chip--warn' }}">{{ $labelStatusDuta }}</span>
                    @endif
                </div>

                @if($duta)
                    <div class="kd-item">
                        <span class="kd-duta-avatar" style="width: 46px; height: 46px; font-size: 15px;">
                            @if($duta->foto_duta_url)
                                <img src="{{ $duta->foto_duta_url }}" alt="{{ $duta->nama_lengkap }}" loading="lazy">
                            @else
                                {{ $duta->initial_dua_huruf }}
                            @endif
                        </span>
                        <span class="kd-item-body">
                            <span class="kd-item-title">{{ $duta->nama_lengkap }}</span>
                            <span class="kd-item-meta" style="text-transform: none;">
                                {{ $duta->kategori_duta }}
                                @php
                                    $wilayahDuta = collect([$duta->desaKelurahan?->nama_desa_kelurahan, $duta->kecamatan?->nama_kecamatan])->filter()->implode(', ');
                                @endphp
                                @if($wilayahDuta)
                                    · {{ $wilayahDuta }}
                                @endif
                            </span>
                        </span>
                    </div>

                    <div class="kd-item">
                        <span class="kd-module-icon"><i data-lucide="calendar-days"></i></span>
                        <span class="kd-item-body">
                            <span class="kd-item-title">{{ $duta->tahun_pemilihan ?: '-' }}</span>
                            <span class="kd-item-meta" style="text-transform: none;">Tahun pemilihan</span>
                        </span>
                    </div>

                    @if($duta->nama_bank)
                        <div class="kd-item">
                            <span class="kd-module-icon"><i data-lucide="landmark"></i></span>
                            <span class="kd-item-body">
                                <span class="kd-item-title">{{ $duta->nama_bank }}</span>
                                <span class="kd-item-meta" style="text-transform: none;">Bank</span>
                            </span>
                        </div>
                    @endif

                    @if($duta->nomor_rekening)
                        <div class="kd-item">
                            <span class="kd-module-icon"><i data-lucide="credit-card"></i></span>
                            <span class="kd-item-body">
                                <span class="kd-item-title">{{ $duta->nomor_rekening }}</span>
                                <span class="kd-item-meta" style="text-transform: none;">Nomor rekening</span>
                            </span>
                        </div>
                    @endif

                    @if($duta->gelar_prestasi || $duta->deskripsi_prestasi)
                        <div class="kd-item">
                            <span class="kd-module-icon"><i data-lucide="trophy"></i></span>
                            <span class="kd-item-body">
                                <span class="kd-item-title">{{ $duta->gelar_prestasi ?: 'Prestasi duta' }}</span>
                                <span class="kd-item-meta" style="text-transform: none;">{{ \Illuminate\Support\Str::limit($duta->deskripsi_prestasi ?: '-', 90) }}</span>
                            </span>
                        </div>
                    @endif

                    @if($duta->status_pendaftaran === \App\Models\Kormi\DutaOlahraga::STATUS_MENUNGGU)
                        <div class="kd-notice kd-notice-amber">
                            <i data-lucide="clock"></i>
                            <span>Profil duta menunggu verifikasi administrator. Data tetap dapat Anda perbarui.</span>
                        </div>
                    @endif

                    <button type="button" class="kd-btn-ghost" style="width: 100%;" wire:click="pilihTab('data')">
                        <i data-lucide="square-pen" class="w-4 h-4"></i>
                        <span>Edit Profil Duta</span>
                    </button>
                @elseif($kelolaDuta)
                    <div class="kd-notice kd-notice-amber">
                        <i data-lucide="link"></i>
                        <span>Akun ini belum terhubung dengan profil Duta Olahraga. Lengkapi data pada tab Ubah Data agar akun dan profil duta tersambung.</span>
                    </div>

                    <button type="button" class="kd-btn-primary" style="width: 100%;" wire:click="pilihTab('data')">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Hubungkan Profil Duta</span>
                    </button>
                @else
                    <p class="kd-footnote" style="margin-top: 0;">Akun ini belum terhubung dengan profil Duta Olahraga. Daftar melalui formulir pendaftaran duta agar profil akun dan data duta tersambung.</p>

                    <a href="{{ route('mobile.daftar-duta') }}" wire:navigate class="kd-btn-ghost" style="width: 100%;">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Daftar Sebagai Duta Olahraga</span>
                    </a>
                @endif

                <div class="kd-subhead" style="margin-top: 22px;">
                    <h4>Aksi Akun</h4>
                </div>

                <div class="kd-success-actions">
                    <a href="{{ route('mobile.layanan') }}" wire:navigate class="kd-btn-primary">
                        <i data-lucide="blocks" class="w-4 h-4"></i>
                        <span>Lihat Layanan Saya</span>
                    </a>

                    <form method="POST" action="{{ route('admin.keluar') }}">
                        @csrf
                        <button type="submit" class="kd-btn-ghost" style="width: 100%;">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span>Keluar dari Akun</span>
                        </button>
                    </form>
                </div>

                <p class="kd-footnote">Masuk sebagai {{ $user->email }}</p>
            </div>
        @elseif($tab === 'data')
            <div class="kd-panel" role="tabpanel" id="panel-data" aria-labelledby="tab-data">
                <div class="kd-subhead">
                    <h4>{{ $kelolaDuta ? 'Ubah Data Profil' : 'Ubah Data Akun' }}</h4>
                </div>

                @if(session('pesan_akun'))
                    <div class="kd-notice kd-notice-lime">
                        <i data-lucide="check-circle"></i>
                        <span>{{ session('pesan_akun') }}</span>
                    </div>
                @endif

                <form wire:submit="simpanDataAkun">
                    <div class="kd-group">
                        <div class="kd-label-row">
                            <label class="kd-label" for="m-profil-nama">Nama Lengkap <span class="kd-req">*</span></label>
                        </div>
                        <div class="kd-control">
                            <input type="text" id="m-profil-nama" wire:model="nama_lengkap" class="kd-input" placeholder="Nama lengkap" autocomplete="name">
                        </div>
                        @error('nama_lengkap')<p class="kd-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="kd-group">
                        <div class="kd-label-row">
                            <label class="kd-label" for="m-profil-telepon">Nomor Telepon <span class="kd-optional">Opsional</span></label>
                        </div>
                        <div class="kd-control">
                            <input type="tel" id="m-profil-telepon" wire:model="nomor_telepon" class="kd-input" placeholder="08xxxxxxxxxx" autocomplete="tel">
                        </div>
                        @error('nomor_telepon')<p class="kd-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="kd-group">
                        <div class="kd-label-row">
                            <span class="kd-label">Foto Profil <span class="kd-optional">Opsional</span></span>
                        </div>

                        @if($foto_profil_baru)
                            @php $ekstensiFotoProfil = strtolower($foto_profil_baru->getClientOriginalExtension()); @endphp
                            @if(in_array($ekstensiFotoProfil, ['jpg', 'jpeg', 'png', 'webp']))
                                <div class="kd-photo-preview">
                                    <img src="{{ $foto_profil_baru->temporaryUrl() }}" alt="Pratinjau foto profil baru">
                                </div>
                            @else
                                <div class="kd-file-chip">
                                    <i data-lucide="file" class="w-4 h-4"></i>
                                    <span>{{ $foto_profil_baru->getClientOriginalName() }}</span>
                                </div>
                            @endif
                        @elseif($user->foto_profil_url)
                            <div class="kd-photo-preview">
                                <img src="{{ $user->foto_profil_url }}" alt="Foto profil saat ini">
                            </div>
                        @endif

                        <label class="kd-upload">
                            <i data-lucide="image-plus"></i>
                            <span class="kd-upload-title">{{ $foto_profil_baru ? 'Ganti Foto Profil' : 'Pilih Foto Profil' }}</span>
                            <span class="kd-upload-sub">JPG, JPEG, PNG, WEBP — otomatis dikompres ≤ 1 MB</span>
                            <input type="file" id="m-profil-foto" wire:model="foto_profil_baru" accept="image/jpeg,image/png,image/webp" class="sr-only">
                        </label>

                        <div wire:loading wire:target="foto_profil_baru" class="kd-upload-status">
                            <span class="kd-spinner kd-spinner--dark"></span>
                            <span>Mengunggah foto...</span>
                        </div>
                        @error('foto_profil_baru')<p class="kd-error">{{ $message }}</p>@enderror
                    </div>

                    @if($kelolaDuta)
                        <div class="kd-subhead" style="margin-top: 22px;">
                            <h4>Profil Duta Olahraga</h4>
                            <span class="kd-chip {{ $duta ? 'kd-chip--dark' : '' }}">{{ $duta ? 'Terhubung' : 'Belum terhubung' }}</span>
                        </div>

                        @if(! $duta)
                            <div class="kd-notice kd-notice-amber">
                                <i data-lucide="link"></i>
                                <span>Lengkapi data berikut untuk menghubungkan akun dengan profil Duta Olahraga. Pendaftaran akan diverifikasi administrator.</span>
                            </div>
                        @endif

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-kategori">Kategori Duta <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-duta-kategori" wire:model="duta_kategori" class="kd-select">
                                    @foreach($daftarKategori as $kategori)
                                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('duta_kategori')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-jk">Jenis Kelamin <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-duta-jk" wire:model="duta_jenis_kelamin" class="kd-select">
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            @error('duta_jenis_kelamin')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-lahir">Tempat Lahir <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <input type="text" id="m-duta-lahir" wire:model="duta_tempat_lahir" class="kd-input" placeholder="Kota / kabupaten lahir">
                            </div>
                            @error('duta_tempat_lahir')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-tanggal-lahir">Tanggal Lahir <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <input type="date" id="m-duta-tanggal-lahir" wire:model="duta_tanggal_lahir" class="kd-input kd-input--date" max="{{ now()->toDateString() }}">
                            </div>
                            @error('duta_tanggal_lahir')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-pendidikan">Pendidikan Terakhir <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-duta-pendidikan" wire:model="duta_pendidikan" class="kd-select">
                                    <option value="">Pilih pendidikan</option>
                                    @foreach($daftarPendidikan as $pendidikan)
                                        <option value="{{ $pendidikan }}">{{ $pendidikan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('duta_pendidikan')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-pekerjaan">Pekerjaan / Profesi <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <input type="text" id="m-duta-pekerjaan" wire:model="duta_pekerjaan" class="kd-input" placeholder="Pekerjaan saat ini">
                            </div>
                            @error('duta_pekerjaan')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-kecamatan">Kecamatan <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-duta-kecamatan" wire:model.live="duta_kecamatan_id" class="kd-select">
                                    <option value="">Pilih kecamatan</option>
                                    @foreach($daftarKecamatan as $kecamatan)
                                        <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('duta_kecamatan_id')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-desa">Desa / Kelurahan <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-duta-desa" wire:model="duta_desa_kelurahan_id" class="kd-select" @disabled(! $duta_kecamatan_id)>
                                    <option value="">Pilih desa / kelurahan</option>
                                    @foreach($daftarDesa as $desa)
                                        <option value="{{ $desa->id }}">{{ $desa->nama_desa_kelurahan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('duta_desa_kelurahan_id')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-alamat">Alamat Domisili <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <textarea id="m-duta-alamat" wire:model="duta_alamat" class="kd-textarea" rows="3" placeholder="Alamat lengkap domisili"></textarea>
                            </div>
                            @error('duta_alamat')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-instagram">Akun Instagram <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <input type="text" id="m-duta-instagram" wire:model.blur="duta_instagram" class="kd-input" placeholder="namaakun" autocomplete="off">
                            </div>
                            @error('duta_instagram')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-bank">Bank <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-duta-bank" wire:model="duta_nama_bank" class="kd-select">
                                    <option value="">Pilih bank</option>
                                    @foreach($daftarBank as $bank)
                                        <option value="{{ $bank }}">{{ $bank }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('duta_nama_bank')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-rekening">Nomor Rekening <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <input type="text" id="m-duta-rekening" wire:model="duta_nomor_rekening" class="kd-input" placeholder="Contoh: 1234567890" inputmode="numeric" autocomplete="off">
                            </div>
                            @error('duta_nomor_rekening')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-gelar">Gelar Prestasi <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <input type="text" id="m-duta-gelar" wire:model="duta_gelar_prestasi" class="kd-input" placeholder="Contoh: Juara 1 Senam Kreasi Kab. Bandung">
                            </div>
                            @error('duta_gelar_prestasi')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-duta-deskripsi">Deskripsi Prestasi <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <textarea id="m-duta-deskripsi" wire:model="duta_deskripsi_prestasi" class="kd-textarea" rows="3" placeholder="Ceritakan prestasi atau kontribusi Anda"></textarea>
                            </div>
                            @error('duta_deskripsi_prestasi')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <span class="kd-label">Foto Duta <span class="kd-optional">Opsional</span></span>
                            </div>

                            @if($foto_duta_baru)
                                @php $ekstensiFotoDuta = strtolower($foto_duta_baru->getClientOriginalExtension()); @endphp
                                @if(in_array($ekstensiFotoDuta, ['jpg', 'jpeg', 'png', 'webp']))
                                    <div class="kd-photo-preview">
                                        <img src="{{ $foto_duta_baru->temporaryUrl() }}" alt="Pratinjau foto duta baru">
                                    </div>
                                @else
                                    <div class="kd-file-chip">
                                        <i data-lucide="file" class="w-4 h-4"></i>
                                        <span>{{ $foto_duta_baru->getClientOriginalName() }}</span>
                                    </div>
                                @endif
                            @elseif($duta?->foto_duta_url)
                                <div class="kd-photo-preview">
                                    <img src="{{ $duta->foto_duta_url }}" alt="Foto duta saat ini">
                                </div>
                            @endif

                            <label class="kd-upload">
                                <i data-lucide="image-plus"></i>
                                <span class="kd-upload-title">{{ $foto_duta_baru ? 'Ganti Foto Duta' : 'Pilih Foto Duta' }}</span>
                                <span class="kd-upload-sub">JPG, JPEG, PNG, WEBP — otomatis dikompres ≤ 1 MB</span>
                                <input type="file" id="m-duta-foto" wire:model="foto_duta_baru" accept="image/jpeg,image/png,image/webp" class="sr-only">
                            </label>

                            <div wire:loading wire:target="foto_duta_baru" class="kd-upload-status">
                                <span class="kd-spinner kd-spinner--dark"></span>
                                <span>Mengunggah foto...</span>
                            </div>
                            @error('foto_duta_baru')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <p class="kd-footnote" style="margin-top: 0;">Nama, nomor telepon, jenis kelamin, pekerjaan, dan wilayah dipakai bersama oleh akun dan profil duta.</p>
                    @endif

                    <button type="submit" class="kd-btn-primary" style="width: 100%;" wire:loading.attr="disabled" wire:target="simpanDataAkun, foto_profil_baru, foto_duta_baru">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span wire:loading.remove wire:target="simpanDataAkun">{{ $kelolaDuta && ! $duta ? 'Simpan & Hubungkan Profil Duta' : 'Simpan Perubahan' }}</span>
                        <span wire:loading wire:target="simpanDataAkun">Menyimpan...</span>
                    </button>
                </form>
            </div>
        @else
            <div class="kd-panel" role="tabpanel" id="panel-keamanan" aria-labelledby="tab-keamanan">
                <div class="kd-subhead">
                    <h4>Ganti Kata Sandi</h4>
                </div>

                @if(session('pesan_sandi'))
                    <div class="kd-notice kd-notice-lime">
                        <i data-lucide="check-circle"></i>
                        <span>{{ session('pesan_sandi') }}</span>
                    </div>
                @endif

                <form wire:submit="gantiKataSandi">
                    <div class="kd-group">
                        <div class="kd-label-row">
                            <label class="kd-label" for="m-profil-sandi-lama">Kata Sandi Saat Ini <span class="kd-req">*</span></label>
                        </div>
                        <div class="kd-control">
                            <input type="password" id="m-profil-sandi-lama" wire:model="kata_sandi_lama" class="kd-input" placeholder="Kata sandi saat ini" autocomplete="current-password">
                        </div>
                        @error('kata_sandi_lama')<p class="kd-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="kd-group">
                        <div class="kd-label-row">
                            <label class="kd-label" for="m-profil-sandi-baru">Kata Sandi Baru <span class="kd-req">*</span></label>
                        </div>
                        <div class="kd-control">
                            <input type="password" id="m-profil-sandi-baru" wire:model="kata_sandi_baru" class="kd-input" placeholder="Minimal 8 karakter" autocomplete="new-password">
                        </div>
                        @error('kata_sandi_baru')<p class="kd-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="kd-group">
                        <div class="kd-label-row">
                            <label class="kd-label" for="m-profil-sandi-konfirmasi">Konfirmasi Kata Sandi Baru <span class="kd-req">*</span></label>
                        </div>
                        <div class="kd-control">
                            <input type="password" id="m-profil-sandi-konfirmasi" wire:model="konfirmasi_kata_sandi" class="kd-input" placeholder="Ulangi kata sandi baru" autocomplete="new-password">
                        </div>
                        @error('konfirmasi_kata_sandi')<p class="kd-error">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="kd-btn-primary" style="width: 100%;" wire:loading.attr="disabled" wire:target="gantiKataSandi">
                        <i data-lucide="key-round" class="w-4 h-4"></i>
                        <span wire:loading.remove wire:target="gantiKataSandi">Perbarui Kata Sandi</span>
                        <span wire:loading wire:target="gantiKataSandi">Memproses...</span>
                    </button>
                </form>

                <p class="kd-footnote">Gunakan kombinasi huruf, angka, dan simbol agar akun tetap aman.</p>
            </div>
        @endif
    </div>

    <x-mobile.tabbar aktif="profil" />
</div>
