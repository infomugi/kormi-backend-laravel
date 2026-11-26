    {{-- Versi mobile dari /daftar-duta — desain mobile_kormi.html --}}
    <div class="kd-mobile min-h-screen">
        <div class="kd-header">
            <div class="kd-brand">
                <div class="kd-brand-icon">K</div>
                <span class="kd-brand-title">KORMI Kab. Bandung</span>
            </div>
            <p class="kd-brand-sub">{{ $berhasil ? 'Pendaftaran Duta Olahraga Terkirim' : 'Registrasi Duta Olahraga Kecamatan' }}</p>
        </div>

        <div class="kd-sheet">
            @if($berhasil)
                <div class="kd-success">
                    <div class="kd-success-check">
                        <i data-lucide="check" class="stroke-[3]"></i>
                    </div>
                    <span class="kd-success-tag">Pendaftaran Berhasil Dikirim</span>
                    <h2>Terima kasih, {{ $namaPendaftar ?: 'Calon Duta' }}!</h2>
                    <p class="kd-success-text">
                        Data pendaftaran Duta Olahraga Anda telah kami terima dan kini berstatus
                        <strong>menunggu verifikasi administrator</strong>. Profil Anda akan tampil di direktori publik setelah disetujui.
                    </p>

                    <div class="kd-success-card">
                        <div class="kd-success-row">
                            <i data-lucide="shield-check"></i>
                            <p><strong>Data duta &amp; akun menunggu persetujuan admin.</strong> Tim KORMI Kabupaten Bandung akan memverifikasi identitas, domisili, dan kelengkapan berkas Anda.</p>
                        </div>
                        @if(! $terhubungAkun)
                            <div class="kd-success-row">
                                <i data-lucide="key-round"></i>
                                <p><strong>Simpan email dan kata sandi Anda.</strong> Akun yang dibuat belum dapat digunakan untuk masuk sampai administrator menyetujui pendaftaran.</p>
                            </div>
                        @else
                            <div class="kd-success-row">
                                <i data-lucide="link"></i>
                                <p><strong>Setelah disetujui administrator, profil Duta Anda akan ditautkan ke akun ini.</strong> Status akun saat ini tidak berubah.</p>
                            </div>
                        @endif
                    </div>

                    <div class="kd-success-actions">
                        <a href="{{ route('mobile.direktori-duta') }}" wire:navigate class="kd-btn-primary">
                            <i data-lucide="award" class="w-4 h-4"></i>
                            <span>Lihat Direktori Duta</span>
                        </a>
                        @if(! $terhubungAkun)
                            <a href="{{ route('mobile.login') }}" class="kd-btn-ghost">
                                <i data-lucide="log-in" class="w-4 h-4"></i>
                                <span>Masuk ke Akun</span>
                            </a>
                        @endif
                    </div>

                    @if(! $terhubungAkun)
                        <p class="kd-footnote">
                            Login baru aktif setelah akun disetujui administrator. Bila lupa kata sandi, hubungi pengurus KORMI Kabupaten Bandung.
                        </p>
                    @endif
                </div>
            @else
                <form wire:submit.prevent="submit">
                    {{-- Honeypot anti-bot (tersembunyi untuk manusia) --}}
                    <div class="hidden" aria-hidden="true">
                        <input type="text" wire:model="situs_web" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="kd-steps" role="tablist" aria-label="Langkah pendaftaran">
                        @foreach($langkahWizard as $nomor => $label)
                            <button
                                type="button"
                                wire:click="setStep({{ $nomor }})"
                                role="tab"
                                aria-selected="{{ $currentStep === $nomor ? 'true' : 'false' }}"
                                class="kd-step {{ $currentStep === $nomor ? 'is-active' : ($currentStep > $nomor ? 'is-done' : '') }}"
                            >
                                <span class="kd-step-num">
                                    @if($currentStep > $nomor)
                                        <i data-lucide="check" class="w-3 h-3"></i>
                                    @else
                                        {{ $nomor }}
                                    @endif
                                </span>
                                <span class="kd-step-label">{{ $label }}</span>
                            </button>
                        @endforeach
                    </div>

                    @if($sudahTerdaftarSebagaiDuta)
                        <div class="kd-notice kd-notice-amber">
                            <i data-lucide="alert-triangle"></i>
                            <span>Akun Anda sudah terhubung dengan data Duta Olahraga. Pendaftaran ulang tidak dapat diproses. Hubungi administrator KORMI untuk perubahan data.</span>
                        </div>
                    @endif

                    @if($terhubungAkun)
                        <div class="kd-notice kd-notice-lime">
                            <i data-lucide="user-check"></i>
                            <span>Anda masuk sebagai <strong>{{ $nama_lengkap ?: auth()->user()?->nama_lengkap }}</strong>. Pendaftaran ini ditautkan ke akun Anda setelah disetujui administrator.</span>
                        </div>
                    @endif

                    @error('pendaftaran')
                        <div class="kd-notice kd-notice-rose">
                            <i data-lucide="alert-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    {{-- STEP 1: IDENTITAS --}}
                    @if($currentStep === 1)
                        <div class="kd-section-head">
                            <div>
                                <h3>Identitas Calon Duta</h3>
                                <p>Lengkapi data diri sesuai dokumen kependudukan.</p>
                            </div>
                            <span class="kd-badge">Wajib</span>
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-nama_lengkap">Nama Lengkap <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <input id="m-nama_lengkap" type="text" wire:model="nama_lengkap" class="kd-input" placeholder="Contoh: Rian Hidayat" maxlength="150" autocomplete="name">
                                <span class="kd-icon"><i data-lucide="user"></i></span>
                            </div>
                            @error('nama_lengkap')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-jenis_kelamin">Jenis Kelamin <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-jenis_kelamin" wire:model="jenis_kelamin" class="kd-select">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <span class="kd-icon"><i data-lucide="chevron-down"></i></span>
                            </div>
                            @error('jenis_kelamin')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-tanggal_lahir">Tanggal Lahir <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <input id="m-tanggal_lahir" type="date" wire:model="tanggal_lahir" class="kd-input kd-input--date" max="{{ now()->toDateString() }}">
                            </div>
                            @error('tanggal_lahir')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-tempat_lahir">Tempat Lahir <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <input id="m-tempat_lahir" type="text" wire:model="tempat_lahir" class="kd-input" placeholder="Contoh: Bandung" maxlength="100">
                                <span class="kd-icon"><i data-lucide="map-pin"></i></span>
                            </div>
                            @error('tempat_lahir')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-pendidikan_terakhir">Pendidikan Terakhir <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-pendidikan_terakhir" wire:model="pendidikan_terakhir" class="kd-select">
                                    <option value="">-- Pilih Jenjang --</option>
                                    @foreach($daftarPendidikan as $pendidikan)
                                        <option value="{{ $pendidikan }}">{{ $pendidikan }}</option>
                                    @endforeach
                                </select>
                                <span class="kd-icon"><i data-lucide="chevron-down"></i></span>
                            </div>
                            @error('pendidikan_terakhir')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-pekerjaan_profesi">Pekerjaan / Profesi <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <input id="m-pekerjaan_profesi" type="text" wire:model="pekerjaan_profesi" class="kd-input" placeholder="Contoh: Guru / Wiraswasta" maxlength="100">
                                <span class="kd-icon"><i data-lucide="briefcase"></i></span>
                            </div>
                            @error('pekerjaan_profesi')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>
                    @endif

                    {{-- STEP 2: DOMISILI & KONTAK --}}
                    @if($currentStep === 2)
                        <div class="kd-section-head">
                            <div>
                                <h3>Domisili &amp; Kontak</h3>
                                <p>Wilayah penugasan duta serta kanal komunikasi yang aktif.</p>
                            </div>
                            <span class="kd-badge">Wajib</span>
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-kecamatan_id">Kecamatan Domisili <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-kecamatan_id" wire:model.live="kecamatan_id" class="kd-select">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach($daftarKecamatan as $kec)
                                        <option value="{{ $kec->id }}">Kec. {{ $kec->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                                <span class="kd-icon"><i data-lucide="chevron-down"></i></span>
                            </div>
                            @error('kecamatan_id')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-desa_kelurahan_id">Desa / Kelurahan <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-desa_kelurahan_id" wire:model="desa_kelurahan_id" class="kd-select" @disabled(! $kecamatan_id)>
                                    <option value="">-- Pilih Desa / Kelurahan --</option>
                                    @foreach($daftarDesa as $desa)
                                        <option value="{{ $desa->id }}">{{ $desa->nama_desa_kelurahan }}</option>
                                    @endforeach
                                </select>
                                <span class="kd-icon"><i data-lucide="chevron-down"></i></span>
                            </div>
                            @error('desa_kelurahan_id')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        @if($kecamatan_id && $daftarDesa->isEmpty())
                            <p class="kd-hint kd-hint--warn">Belum ada data desa untuk kecamatan ini. Silakan pilih kecamatan lain.</p>
                        @endif

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-alamat_domisili">Alamat Domisili Lengkap <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <textarea id="m-alamat_domisili" wire:model="alamat_domisili" rows="3" class="kd-textarea" placeholder="Contoh: Jl. Raya Soreang No. 12, RT 02/RW 05, Dusun Cibiru" maxlength="500"></textarea>
                            </div>
                            <p class="kd-hint">Sertakan nama jalan, RT/RW, dusun, atau patokan alamat.</p>
                            @error('alamat_domisili')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-nomor_telepon">Nomor Telepon / WhatsApp <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <input id="m-nomor_telepon" type="tel" inputmode="tel" wire:model="nomor_telepon" class="kd-input" placeholder="Contoh: 081234567890" maxlength="20">
                                <span class="kd-icon"><i data-lucide="phone"></i></span>
                            </div>
                            @error('nomor_telepon')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-email">Alamat Email <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <input id="m-email" type="email" wire:model="email" class="kd-input" placeholder="nama@email.com" maxlength="100" autocomplete="email">
                                <span class="kd-icon"><i data-lucide="mail"></i></span>
                            </div>
                            <p class="kd-hint">Email ini menjadi identitas akun Anda.</p>
                            @error('email')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>
                    @endif

                    {{-- STEP 3: PROFIL DUTA --}}
                    @if($currentStep === 3)
                        <div class="kd-section-head">
                            <div>
                                <h3>Profil Duta Olahraga</h3>
                                <p>Kategori pembinaan, rekam jejak, dan pas foto resmi.</p>
                            </div>
                            <span class="kd-badge">Profil</span>
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-kategori_duta">Kategori Duta <span class="kd-req">*</span></label>
                            </div>
                            <div class="kd-control">
                                <select id="m-kategori_duta" wire:model="kategori_duta" class="kd-select">
                                    @foreach($daftarKategori as $kategori)
                                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                                    @endforeach
                                </select>
                                <span class="kd-icon"><i data-lucide="chevron-down"></i></span>
                            </div>
                            @error('kategori_duta')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-gelar_prestasi">Gelar / Prestasi Utama <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <input id="m-gelar_prestasi" type="text" wire:model="gelar_prestasi" class="kd-input" placeholder="Contoh: Juara 1 Senam Bugar 2025" maxlength="150">
                                <span class="kd-icon"><i data-lucide="trophy"></i></span>
                            </div>
                            @error('gelar_prestasi')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-deskripsi_prestasi">Deskripsi Prestasi &amp; Pengalaman <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <textarea id="m-deskripsi_prestasi" wire:model="deskripsi_prestasi" rows="4" class="kd-textarea" placeholder="Tuliskan pengalaman keolahragaan, sertifikasi, atau peran penggerak di masyarakat..." maxlength="1500"></textarea>
                            </div>
                            @error('deskripsi_prestasi')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <label class="kd-label" for="m-akun_instagram">Akun Instagram <span class="kd-optional">Opsional</span></label>
                            </div>
                            <div class="kd-control">
                                <span class="kd-prefix">@</span>
                                <input id="m-akun_instagram" type="text" wire:model="akun_instagram" class="kd-input kd-input--prefix" placeholder="nama_instagram" maxlength="100">
                            </div>
                            @error('akun_instagram')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="kd-group">
                            <div class="kd-label-row">
                                <span class="kd-label">Pas Foto Duta <span class="kd-optional">Opsional</span></span>
                            </div>

                            @if($foto)
                                @php $ekstensiFotoMobile = strtolower($foto->getClientOriginalExtension()); @endphp
                                @if(in_array($ekstensiFotoMobile, ['jpg', 'jpeg', 'png', 'webp']))
                                    <div class="kd-photo-preview">
                                        <img src="{{ $foto->temporaryUrl() }}" alt="Pratinjau foto duta">
                                    </div>
                                @else
                                    <div class="kd-file-chip">
                                        <i data-lucide="file" class="w-4 h-4"></i>
                                        <span>{{ $foto->getClientOriginalName() }}</span>
                                    </div>
                                @endif
                            @endif

                            <label class="kd-upload">
                                <i data-lucide="image-plus"></i>
                                <span class="kd-upload-title">{{ $foto ? 'Ganti Foto Duta' : 'Pilih Foto Duta' }}</span>
                                <span class="kd-upload-sub">JPG, JPEG, PNG, WEBP — otomatis dikompres ≤ 1 MB</span>
                                <input type="file" wire:model="foto" accept="image/jpeg,image/png,image/webp" class="sr-only">
                            </label>

                            <div wire:loading wire:target="foto" class="kd-upload-status">
                                <span class="kd-spinner kd-spinner--dark"></span>
                                <span>Mengunggah foto...</span>
                            </div>
                            @error('foto')<p class="kd-error">{{ $message }}</p>@enderror
                        </div>
                    @endif

                    {{-- STEP 4: AKUN & KONFIRMASI --}}
                    @if($currentStep === 4)
                        <div class="kd-section-head">
                            <div>
                                <h3>Ringkasan &amp; Konfirmasi</h3>
                                <p>Periksa kembali data Anda sebelum dikirim untuk verifikasi.</p>
                            </div>
                            <span class="kd-badge">Final</span>
                        </div>

                        <div class="kd-summary">
                            <span class="kd-summary-title">Ringkasan Pendaftaran Duta</span>
                            <div class="kd-summary-row">
                                <span>Nama Lengkap</span>
                                <strong>{{ $nama_lengkap ?: '-' }}</strong>
                            </div>
                            <div class="kd-summary-row">
                                <span>Jenis Kelamin / Tgl. Lahir</span>
                                <strong>{{ $jenis_kelamin === 'P' ? 'Perempuan' : ($jenis_kelamin === 'L' ? 'Laki-laki' : '-') }} &bull; {{ $tanggal_lahir ? \Illuminate\Support\Carbon::parse($tanggal_lahir)->format('d/m/Y') : '-' }}</strong>
                            </div>
                            <div class="kd-summary-row">
                                <span>Kecamatan / Desa</span>
                                <strong>
                                    {{ $kecamatan_id ? 'Kec. ' . (\App\Models\Master\Kecamatan::find($kecamatan_id)?->nama_kecamatan ?? '-') : '-' }}
                                    &bull;
                                    {{ $desa_kelurahan_id ? 'Desa ' . (\App\Models\Master\DesaKelurahan::find($desa_kelurahan_id)?->nama_desa_kelurahan ?? '-') : '-' }}
                                </strong>
                            </div>
                            <div class="kd-summary-row">
                                <span>Kontak</span>
                                <strong>{{ $nomor_telepon ?: '-' }} &bull; {{ $email ?: '-' }}</strong>
                            </div>
                            <div class="kd-summary-row">
                                <span>Kategori Duta</span>
                                <strong>{{ $kategori_duta }}</strong>
                            </div>
                            <div class="kd-summary-row">
                                <span>Pas Foto</span>
                                <strong>{{ $foto ? 'Foto siap diunggah' : 'Belum dilampirkan' }}</strong>
                            </div>
                        </div>

                        @if(! $terhubungAkun)
                            <div class="kd-account">
                                <span class="kd-account-title">Akun Duta Olahraga</span>
                                <p>Akun dibuat otomatis dengan email <strong>{{ $email ?: '-' }}</strong> dan baru aktif setelah disetujui administrator.</p>

                                <div class="kd-group">
                                    <div class="kd-label-row">
                                        <label class="kd-label" for="m-kata_sandi">Kata Sandi <span class="kd-req">*</span></label>
                                    </div>
                                    <div class="kd-control" x-data="{ tampil: false }">
                                        <input id="m-kata_sandi" type="password" x-bind:type="tampil ? 'text' : 'password'" wire:model="kata_sandi" class="kd-input kd-input--password" placeholder="Minimal 8 karakter" autocomplete="new-password">
                                        <button type="button" class="kd-icon kd-icon--button" @click="tampil = !tampil" aria-label="Tampilkan kata sandi">
                                            <i data-lucide="eye"></i>
                                        </button>
                                    </div>
                                    @error('kata_sandi')<p class="kd-error">{{ $message }}</p>@enderror
                                </div>

                                <div class="kd-group" style="margin-bottom: 0;">
                                    <div class="kd-label-row">
                                        <label class="kd-label" for="m-konfirmasi_kata_sandi">Konfirmasi Kata Sandi <span class="kd-req">*</span></label>
                                    </div>
                                    <div class="kd-control" x-data="{ tampil: false }">
                                        <input id="m-konfirmasi_kata_sandi" type="password" x-bind:type="tampil ? 'text' : 'password'" wire:model="konfirmasi_kata_sandi" class="kd-input kd-input--password" placeholder="Ulangi kata sandi" autocomplete="new-password">
                                        <button type="button" class="kd-icon kd-icon--button" @click="tampil = !tampil" aria-label="Tampilkan kata sandi">
                                            <i data-lucide="eye"></i>
                                        </button>
                                    </div>
                                    @error('konfirmasi_kata_sandi')<p class="kd-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        @endif

                        <label class="kd-consent">
                            <input type="checkbox" wire:model="setuju_syarat">
                            <span>Saya menyetujui <strong>syarat &amp; ketentuan</strong> pendaftaran Duta Olahraga KORMI Kabupaten Bandung dan bersedia mengikuti pembinaan keolahragaan.</span>
                        </label>
                        @error('setuju_syarat')<p class="kd-error kd-error--spaced">{{ $message }}</p>@enderror

                        <label class="kd-consent">
                            <input type="checkbox" wire:model="pernyataan_kebenaran">
                            <span>Saya menyatakan bahwa seluruh data yang saya isi adalah <strong>benar dan dapat dipertanggungjawabkan</strong>.</span>
                        </label>
                        @error('pernyataan_kebenaran')<p class="kd-error kd-error--spaced">{{ $message }}</p>@enderror

                        @if($errors->any())
                            <div class="kd-errors">
                                <strong>Periksa kembali data berikut</strong>
                                <ul>
                                    @foreach($errors->all() as $pesanError)
                                        <li>{{ $pesanError }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif

                    <div class="kd-actions">
                        @if($currentStep > 1)
                            <button type="button" wire:click="previousStep" class="kd-btn-ghost">
                                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                <span>Kembali</span>
                            </button>
                        @endif

                        @if($currentStep < $totalSteps)
                            <button type="button" wire:click="nextStep" wire:loading.attr="disabled" wire:target="nextStep" class="kd-btn-primary">
                                <span>Lanjut</span>
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </button>
                        @else
                            <button type="submit" wire:loading.attr="disabled" @disabled($sudahTerdaftarSebagaiDuta) class="kd-btn-primary">
                                <span wire:loading.remove wire:target="submit" class="flex items-center gap-2">
                                    <i data-lucide="send" class="w-4 h-4"></i>
                                    <span>Kirim Pendaftaran</span>
                                </span>
                                <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                    <span class="kd-spinner"></span>
                                    <span>Mengirim Data...</span>
                                </span>
                            </button>
                        @endif
                    </div>

                    @if($currentStep === 1)
                        <p class="kd-bottom-switch">
                            <a href="{{ route('mobile.direktori-duta') }}" wire:navigate>Batal, kembali ke direktori duta</a>
                        </p>
                    @endif

                    @if(! $terhubungAkun)
                        <p class="kd-bottom-switch">Sudah punya akun Duta?<a href="{{ route('mobile.login') }}">Masuk</a></p>
                    @endif
                </form>
            @endif
        </div>

        <x-mobile.tabbar aktif="daftar" />
    </div>
