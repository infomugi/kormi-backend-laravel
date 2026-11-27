<div class="min-h-[85vh] bg-gradient-to-b from-emerald-50/50 via-slate-50/60 to-white py-10">
    {{-- ============================================================ --}}
    {{-- TAMPILAN DESKTOP (tidak diubah)                               --}}
    {{-- ============================================================ --}}
    <div class="max-w-3xl mx-auto px-6 space-y-5">

        {{-- Top Navigation & Context --}}
        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-2 min-w-0">
                <a href="{{ route('dutaolahraga') }}" wire:navigate class="p-2 sm:p-2.5 rounded-xl bg-white border border-slate-200/80 text-slate-500 hover:text-emerald-700 hover:border-emerald-300 transition-all shadow-xs group shrink-0" title="Kembali ke Direktori Duta">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform"></i>
                </a>
                <div class="min-w-0">
                    <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-800 text-[10px] font-black uppercase tracking-wider border border-emerald-200/70">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Pendaftaran Duta Olahraga
                        </span>
                        <span class="text-[11px] font-semibold text-slate-400 hidden sm:inline">Kabupaten Bandung</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('dutaolahraga') }}" wire:navigate class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-slate-200/90 text-slate-700 font-bold text-[11px] hover:bg-slate-50 hover:text-emerald-700 transition shadow-xs shrink-0">
                <i data-lucide="users" class="w-3.5 h-3.5 text-emerald-600"></i>
                <span class="hidden sm:inline">Direktori Duta</span>
                <span class="sm:hidden">Direktori</span>
            </a>
        </div>

        @if($berhasil)
            {{-- ========================================== --}}
            {{-- SUCCESS STATE: MENUNGGU VERIFIKASI ADMIN   --}}
            {{-- ========================================== --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-white via-emerald-50/50 to-teal-50/30 rounded-3xl border border-emerald-200/90 p-6 sm:p-12 text-center shadow-xl shadow-emerald-500/5">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-teal-400/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 space-y-5 max-w-lg mx-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center mx-auto shadow-lg shadow-emerald-600/30 ring-8 ring-emerald-100/70">
                        <i data-lucide="check" class="w-8 h-8 sm:w-10 sm:h-10 stroke-[3]"></i>
                    </div>

                    <div class="space-y-2">
                        <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-emerald-800 bg-emerald-100/80 px-3 py-1 rounded-full">
                            Pendaftaran Berhasil Dikirim
                        </span>
                        <h1 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight">Terima kasih, {{ $namaPendaftar ?: 'Calon Duta' }}!</h1>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Data pendaftaran Duta Olahraga Anda telah kami terima dan kini berstatus
                            <strong class="text-amber-700 font-extrabold">menunggu verifikasi administrator</strong>.
                            Profil Anda akan tampil di direktori publik setelah disetujui.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/80 border border-emerald-200/80 text-left space-y-2.5">
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                            <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">
                                <strong class="text-slate-900">Data duta &amp; akun menunggu persetujuan admin.</strong>
                                Tim KORMI Kabupaten Bandung akan memverifikasi identitas, domisili, dan kelengkapan berkas Anda.
                            </p>
                        </div>

                        @if(! $terhubungAkun)
                            <div class="flex items-start gap-2.5">
                                <i data-lucide="key-round" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                                <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">
                                    <strong class="text-slate-900">Simpan email dan kata sandi Anda.</strong>
                                    Akun yang dibuat belum dapat digunakan untuk masuk sampai administrator menyetujui pendaftaran.
                                </p>
                            </div>
                        @else
                            <div class="flex items-start gap-2.5">
                                <i data-lucide="link" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                                <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">
                                    <strong class="text-slate-900">Setelah disetujui administrator, profil Duta Anda akan ditautkan ke akun ini.</strong>
                                    Status akun saat ini tidak berubah; akses fitur Duta aktif setelah administrator menyetujui pendaftaran ini.
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a
                            href="{{ route('dutaolahraga') }}"
                            wire:navigate
                            class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 active:scale-98 text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-md shadow-emerald-600/25 flex items-center justify-center gap-2"
                        >
                            <i data-lucide="award" class="w-4 h-4"></i>
                            Lihat Direktori Duta
                        </a>

                        @if(! $terhubungAkun)
                            <a
                                href="{{ route('login') }}"
                                class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-white hover:bg-slate-50 active:scale-98 text-slate-800 font-bold text-xs uppercase tracking-wider border border-slate-200/90 transition shadow-xs flex items-center justify-center gap-2"
                            >
                                <i data-lucide="log-in" class="w-4 h-4 text-emerald-600"></i>
                                Masuk ke Akun
                            </a>
                        @endif
                    </div>

                    @if(! $terhubungAkun)
                        <p class="text-[10px] sm:text-[11px] text-slate-400 leading-relaxed">
                            Login baru aktif setelah akun disetujui administrator. Bila lupa kata sandi, hubungi pengurus KORMI Kabupaten Bandung.
                        </p>
                    @endif
                </div>
            </div>
        @else
            {{-- ========================================== --}}
            {{-- WIZARD FORM CONTAINER                      --}}
            {{-- ========================================== --}}
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-900/[0.03] overflow-hidden">

                {{-- Hero Form Header --}}
                <div class="relative bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-950 p-5 sm:p-7 text-white">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1 min-w-0">
                            <h1 class="text-lg sm:text-2xl font-black tracking-tight text-white flex flex-wrap items-center gap-2">
                                <span>Daftar Menjadi Duta Olahraga</span>
                                <span class="text-[9px] sm:text-[10px] font-black bg-lime-300 text-emerald-950 px-2 py-0.5 rounded-md uppercase tracking-wider">Desa &amp; Kelurahan</span>
                            </h1>
                            <p class="text-[11px] sm:text-xs text-emerald-200/85 max-w-lg leading-relaxed">
                                Isi formulir pendaftaran kader penggerak olahraga masyarakat. Data akan diverifikasi administrator sebelum dipublikasikan.
                            </p>
                        </div>
                        <div class="flex items-center gap-2 self-start sm:self-auto shrink-0 bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/10">
                            <i data-lucide="target" class="w-4 h-4 text-lime-300"></i>
                            <div>
                                <span class="block text-[9px] uppercase tracking-wider text-emerald-200/80 font-bold leading-none">Langkah Form</span>
                                <span class="text-xs font-black text-white">Step {{ $currentStep }} dari {{ $totalSteps }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Step Indicator --}}
                <div class="border-b border-slate-100 bg-slate-50/70 p-3 sm:px-8 sm:py-4">
                    <div class="grid grid-cols-4 gap-1.5 sm:gap-2">
                        @foreach($langkahWizard as $nomor => $label)
                            <button
                                type="button"
                                wire:click="setStep({{ $nomor }})"
                                class="flex items-center gap-1.5 p-2 sm:p-2.5 rounded-2xl text-left transition-all cursor-pointer min-w-0 {{ $currentStep === $nomor ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : ($currentStep > $nomor ? 'bg-emerald-50 text-emerald-900 hover:bg-emerald-100/60' : 'bg-white text-slate-400 hover:bg-slate-100/60 border border-slate-200/70') }}"
                            >
                                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl flex items-center justify-center font-black text-xs shrink-0 {{ $currentStep === $nomor ? 'bg-white/20 text-white' : ($currentStep > $nomor ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-500') }}">
                                    @if($currentStep > $nomor)
                                        <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                                    @else
                                        {{ $nomor }}
                                    @endif
                                </div>
                                <div class="min-w-0 hidden sm:block">
                                    <span class="block text-[9px] font-bold uppercase tracking-wider leading-none {{ $currentStep === $nomor ? 'text-emerald-100' : 'text-slate-400' }}">Langkah {{ $nomor }}</span>
                                    <span class="block text-[11px] font-black truncate leading-tight mt-0.5">{{ $label }}</span>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>

                <form wire:submit.prevent="submit" class="p-4 sm:p-8">

                    {{-- Honeypot anti-bot (tersembunyi untuk manusia) --}}
                    <div class="hidden" aria-hidden="true">
                        <label for="situs_web">Situs Web</label>
                        <input type="text" id="situs_web" wire:model="situs_web" tabindex="-1" autocomplete="off">
                    </div>

                    @if($sudahTerdaftarSebagaiDuta)
                        <div class="mb-5 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-semibold flex items-start gap-2.5">
                            <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600 shrink-0 mt-0.5"></i>
                            <span>Akun Anda sudah terhubung dengan data Duta Olahraga. Pendaftaran ulang tidak dapat diproses. Hubungi administrator KORMI untuk perubahan data.</span>
                        </div>
                    @endif

                    @if($terhubungAkun)
                        <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-200/80 text-emerald-900 text-xs font-semibold flex items-start gap-2.5">
                            <i data-lucide="user-check" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                            <span>Anda masuk sebagai <strong class="font-black">{{ $nama_lengkap ?: auth()->user()?->nama_lengkap }}</strong>. Pendaftaran ini akan ditautkan ke akun Anda setelah disetujui administrator. Status akun saat ini tidak berubah.</span>
                        </div>
                    @endif

                    @error('pendaftaran')
                        <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold flex items-start gap-2.5">
                            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    {{-- ========================================== --}}
                    {{-- STEP 1: IDENTITAS                          --}}
                    {{-- ========================================== --}}
                    @if($currentStep === 1)
                        <div class="space-y-5">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div>
                                    <h3 class="text-sm sm:text-base font-black text-slate-900">Identitas Calon Duta</h3>
                                    <p class="text-xs text-slate-500">Lengkapi data diri sesuai dokumen kependudukan.</p>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 px-2.5 py-1 rounded-lg shrink-0">Wajib</span>
                            </div>

                            <x-form.field label="Nama Lengkap" name="nama_lengkap" :required="true">
                                <x-form.input name="nama_lengkap" wire:model="nama_lengkap" icon="user" placeholder="Contoh: Rian Hidayat" maxlength="150" />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Jenis Kelamin" name="jenis_kelamin" :required="true">
                                    <x-form.select name="jenis_kelamin" wire:model="jenis_kelamin">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </x-form.select>
                                </x-form.field>

                                <x-form.field label="Tanggal Lahir" name="tanggal_lahir" :required="true">
                                    <x-form.input type="date" name="tanggal_lahir" wire:model="tanggal_lahir" max="{{ now()->toDateString() }}" />
                                </x-form.field>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Tempat Lahir" name="tempat_lahir" badge="Opsional">
                                    <x-form.input name="tempat_lahir" wire:model="tempat_lahir" icon="map-pin" placeholder="Contoh: Bandung" maxlength="100" />
                                </x-form.field>

                                <x-form.field label="Pendidikan Terakhir" name="pendidikan_terakhir" badge="Opsional">
                                    <x-form.select name="pendidikan_terakhir" wire:model="pendidikan_terakhir">
                                        <option value="">-- Pilih Jenjang --</option>
                                        @foreach($daftarPendidikan as $pendidikan)
                                            <option value="{{ $pendidikan }}">{{ $pendidikan }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>
                            </div>

                            <x-form.field label="Pekerjaan / Profesi" name="pekerjaan_profesi" badge="Opsional">
                                <x-form.input name="pekerjaan_profesi" wire:model="pekerjaan_profesi" icon="briefcase" placeholder="Contoh: Guru Olahraga / Wiraswasta" maxlength="100" />
                            </x-form.field>
                        </div>
                    @endif

                    {{-- ========================================== --}}
                    {{-- STEP 2: DOMISILI & KONTAK                  --}}
                    {{-- ========================================== --}}
                    @if($currentStep === 2)
                        <div class="space-y-5">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div>
                                    <h3 class="text-sm sm:text-base font-black text-slate-900">Domisili &amp; Kontak</h3>
                                    <p class="text-xs text-slate-500">Wilayah penugasan duta serta kanal komunikasi yang aktif.</p>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 px-2.5 py-1 rounded-lg shrink-0">Wajib</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Kecamatan Domisili" name="kecamatan_id" :required="true">
                                    <x-form.select name="kecamatan_id" wire:model.live="kecamatan_id">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach($daftarKecamatan as $kec)
                                            <option value="{{ $kec->id }}">Kec. {{ $kec->nama_kecamatan }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <x-form.field label="Desa / Kelurahan" name="desa_kelurahan_id" :required="true">
                                    <x-form.select name="desa_kelurahan_id" wire:model="desa_kelurahan_id" :disabled="!$kecamatan_id">
                                        <option value="">-- Pilih Desa / Kelurahan --</option>
                                        @foreach($daftarDesa as $desa)
                                            <option value="{{ $desa->id }}">{{ $desa->nama_desa_kelurahan }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>
                            </div>

                            @if($kecamatan_id && $daftarDesa->isEmpty())
                                <p class="text-[11px] text-amber-700 font-semibold flex items-center gap-1.5">
                                    <i data-lucide="info" class="w-3.5 h-3.5"></i>
                                    Belum ada data desa untuk kecamatan ini. Silakan pilih kecamatan lain.
                                </p>
                            @endif

                            <x-form.field label="Alamat Domisili Lengkap" name="alamat_domisili" :required="true" hint="Sertakan nama jalan, RT/RW, dusun, atau patokan alamat.">
                                <x-form.textarea name="alamat_domisili" wire:model="alamat_domisili" rows="3" placeholder="Contoh: Jl. Raya Soreang No. 12, RT 02/RW 05, Dusun Cibiru" maxlength="500" />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Nomor Telepon / WhatsApp" name="nomor_telepon" :required="true">
                                    <x-form.input name="nomor_telepon" wire:model="nomor_telepon" icon="phone" placeholder="Contoh: 081234567890" inputmode="tel" maxlength="20" />
                                </x-form.field>

                                <x-form.field label="Alamat Email" name="email" :required="true" hint="Email ini menjadi identitas akun Anda.">
                                    <x-form.input type="email" name="email" wire:model="email" icon="mail" placeholder="nama@email.com" maxlength="100" />
                                </x-form.field>
                            </div>
                        </div>
                    @endif

                    {{-- ========================================== --}}
                    {{-- STEP 3: PROFIL DUTA                        --}}
                    {{-- ========================================== --}}
                    @if($currentStep === 3)
                        <div class="space-y-5">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div>
                                    <h3 class="text-sm sm:text-base font-black text-slate-900">Profil Duta Olahraga</h3>
                                    <p class="text-xs text-slate-500">Kategori pembinaan, rekam jejak, dan pas foto resmi.</p>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg shrink-0">Profil</span>
                            </div>

                            <x-form.field label="Kategori Duta" name="kategori_duta" :required="true">
                                <x-form.select name="kategori_duta" wire:model="kategori_duta">
                                    @foreach($daftarKategori as $kategori)
                                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                                    @endforeach
                                </x-form.select>
                            </x-form.field>

                            <x-form.field label="Gelar / Prestasi Utama" name="gelar_prestasi" badge="Opsional">
                                <x-form.input name="gelar_prestasi" wire:model="gelar_prestasi" icon="award" placeholder="Contoh: Juara 1 Senam Bugar Jabar 2025" maxlength="150" />
                            </x-form.field>

                            <x-form.field label="Deskripsi Prestasi & Pengalaman" name="deskripsi_prestasi" badge="Opsional">
                                <x-form.textarea name="deskripsi_prestasi" wire:model="deskripsi_prestasi" rows="4" placeholder="Tuliskan pengalaman keolahragaan, sertifikasi, atau peran penggerak di masyarakat..." maxlength="1500" />
                            </x-form.field>

                            <x-form.field label="Akun Instagram" name="akun_instagram" badge="Opsional">
                                <x-form.input name="akun_instagram" wire:model="akun_instagram" prefix="@" placeholder="nama_instagram" maxlength="100" />
                            </x-form.field>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-form.field label="Bank" name="nama_bank" badge="Opsional">
                                    <x-form.select name="nama_bank" wire:model="nama_bank">
                                        <option value="">Pilih bank</option>
                                        @foreach($daftarBank as $bank)
                                            <option value="{{ $bank }}">{{ $bank }}</option>
                                        @endforeach
                                    </x-form.select>
                                </x-form.field>

                                <x-form.field label="Nomor Rekening" name="nomor_rekening" badge="Opsional">
                                    <x-form.input name="nomor_rekening" wire:model="nomor_rekening" icon="credit-card" placeholder="Contoh: 1234567890" inputmode="numeric" maxlength="25" />
                                </x-form.field>
                            </div>

                            <x-form.field label="Pas Foto Duta" name="foto" badge="Opsional" hint="Format JPG, JPEG, PNG, atau WEBP. Otomatis dikompres ≤ 1 MB.">
                                <div class="space-y-3">
                                    @if($foto)
                                        @php
                                            try {
                                                $pratinjauFoto = $foto->isPreviewable() ? $foto->temporaryUrl() : null;
                                            } catch (\Throwable $e) {
                                                $pratinjauFoto = null;
                                            }
                                        @endphp
                                        @if($pratinjauFoto)
                                            <div class="relative w-full max-w-[220px] rounded-2xl overflow-hidden border border-emerald-200 bg-slate-50">
                                                <img src="{{ $pratinjauFoto }}" alt="Pratinjau foto duta" class="w-full h-56 object-cover">
                                            </div>
                                        @else
                                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-[11px] font-bold text-slate-600 flex items-center gap-2">
                                                <i data-lucide="file" class="w-4 h-4 text-slate-400"></i>
                                                <span>{{ $foto->getClientOriginalName() }}</span>
                                            </div>
                                        @endif
                                        <button type="button" wire:click="$set('foto', null)" class="text-[11px] font-bold text-rose-600 hover:text-rose-800 hover:underline">
                                            Hapus foto
                                        </button>
                                    @endif

                                    <label class="flex flex-col items-center justify-center gap-2 w-full px-4 py-6 rounded-2xl border-2 border-dashed border-emerald-200 bg-emerald-50/40 hover:bg-emerald-50 transition-colors cursor-pointer text-center">
                                        <i data-lucide="image-plus" class="w-6 h-6 text-emerald-600"></i>
                                        <span class="text-xs font-black text-slate-800">{{ $foto ? 'Ganti Foto Duta' : 'Pilih Foto Duta' }}</span>
                                        <span class="text-[10px] text-slate-400 font-semibold">JPG, JPEG, PNG, WEBP — otomatis dikompres ≤ 1 MB</span>
                                        <input type="file" wire:model="foto" accept="image/jpeg,image/png,image/webp" class="sr-only">
                                    </label>

                                    <div wire:loading wire:target="foto" class="text-[11px] font-bold text-emerald-700 flex items-center gap-1.5">
                                        <i data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i>
                                        <span>Mengunggah foto...</span>
                                    </div>
                                </div>
                            </x-form.field>
                        </div>
                    @endif

                    {{-- ========================================== --}}
                    {{-- STEP 4: AKUN & KONFIRMASI                  --}}
                    {{-- ========================================== --}}
                    @if($currentStep === 4)
                        <div class="space-y-5">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div>
                                    <h3 class="text-sm sm:text-base font-black text-slate-900">Ringkasan &amp; Konfirmasi</h3>
                                    <p class="text-xs text-slate-500">Periksa kembali data Anda sebelum dikirim untuk verifikasi.</p>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 px-2.5 py-1 rounded-lg shrink-0">Final</span>
                            </div>

                            {{-- Ringkasan Data --}}
                            <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 space-y-3">
                                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-900 block">Ringkasan Pendaftaran Duta</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 font-bold block">Nama Lengkap</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">{{ $nama_lengkap ?: '-' }}</strong>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 font-bold block">Jenis Kelamin / Tanggal Lahir</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">
                                            {{ $jenis_kelamin === 'P' ? 'Perempuan' : ($jenis_kelamin === 'L' ? 'Laki-laki' : '-') }}
                                            &bull;
                                            {{ $tanggal_lahir ? \Illuminate\Support\Carbon::parse($tanggal_lahir)->format('d/m/Y') : '-' }}
                                        </strong>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 font-bold block">Kecamatan / Desa</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">
                                            {{ $kecamatan_id ? 'Kec. ' . (\App\Models\Master\Kecamatan::find($kecamatan_id)?->nama_kecamatan ?? '-') : '-' }}
                                            &bull;
                                            {{ $desa_kelurahan_id ? 'Desa ' . (\App\Models\Master\DesaKelurahan::find($desa_kelurahan_id)?->nama_desa_kelurahan ?? '-') : '-' }}
                                        </strong>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 font-bold block">Kontak</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">{{ $nomor_telepon ?: '-' }} &bull; {{ $email ?: '-' }}</strong>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 font-bold block">Bank / Rekening</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">{{ $nama_bank ?: '-' }} &bull; {{ $nomor_rekening ?: '-' }}</strong>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 font-bold block">Kategori Duta</span>
                                        <strong class="font-extrabold text-emerald-800 block truncate">{{ $kategori_duta }}</strong>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 font-bold block">Pas Foto</span>
                                        <strong class="font-extrabold {{ $foto ? 'text-emerald-700' : 'text-slate-500' }} block truncate">{{ $foto ? 'Foto siap diunggah' : 'Belum dilampirkan (opsional)' }}</strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Akun: Kata Sandi hanya untuk tamu --}}
                            @if(! $terhubungAkun)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                                    <div>
                                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-700 block">Akun Duta Olahraga</span>
                                        <p class="text-[11px] text-slate-500 leading-relaxed mt-0.5">
                                            Akun dibuat otomatis dengan email <strong class="text-slate-800">{{ $email ?: '-' }}</strong> dan baru aktif setelah disetujui administrator.
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <x-form.field label="Kata Sandi" name="kata_sandi" :required="true">
                                            <x-form.input type="password" name="kata_sandi" wire:model="kata_sandi" icon="lock" placeholder="Minimal 8 karakter" autocomplete="new-password" />
                                        </x-form.field>

                                        <x-form.field label="Konfirmasi Kata Sandi" name="konfirmasi_kata_sandi" :required="true">
                                            <x-form.input type="password" name="konfirmasi_kata_sandi" wire:model="konfirmasi_kata_sandi" icon="lock" placeholder="Ulangi kata sandi" autocomplete="new-password" />
                                        </x-form.field>
                                    </div>
                                </div>
                            @endif

                            {{-- Persetujuan --}}
                            <div class="space-y-3">
                                <label class="flex items-start gap-3 p-3.5 rounded-2xl bg-white border border-slate-200/90 hover:border-emerald-300 transition-colors cursor-pointer">
                                    <input type="checkbox" wire:model="setuju_syarat" class="mt-0.5 w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer shrink-0">
                                    <span class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">
                                        Saya menyetujui <strong class="text-slate-900">syarat &amp; ketentuan</strong> pendaftaran Duta Olahraga KORMI Kabupaten Bandung dan bersedia mengikuti pembinaan keolahragaan.
                                    </span>
                                </label>
                                @error('setuju_syarat')
                                    <span class="text-xs text-rose-600 font-bold flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $message }}</span>
                                    </span>
                                @enderror

                                <label class="flex items-start gap-3 p-3.5 rounded-2xl bg-white border border-slate-200/90 hover:border-emerald-300 transition-colors cursor-pointer">
                                    <input type="checkbox" wire:model="pernyataan_kebenaran" class="mt-0.5 w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer shrink-0">
                                    <span class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">
                                        Saya menyatakan bahwa seluruh data yang saya isi adalah <strong class="text-slate-900">benar dan dapat dipertanggungjawabkan</strong>.
                                    </span>
                                </label>
                                @error('pernyataan_kebenaran')
                                    <span class="text-xs text-rose-600 font-bold flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>

                            {{-- Ringkasan Error --}}
                            @if($errors->any())
                                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0"></i>
                                        <span class="text-xs font-black uppercase tracking-wider">Periksa kembali data berikut</span>
                                    </div>
                                    <ul class="list-disc list-inside space-y-1 text-[11px] sm:text-xs font-semibold">
                                        @foreach($errors->all() as $pesanError)
                                            <li>{{ $pesanError }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- ========================================== --}}
                    {{-- WIZARD CONTROLS                            --}}
                    {{-- ========================================== --}}
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between gap-3">
                        <div>
                            @if($currentStep > 1)
                                <button
                                    type="button"
                                    wire:click="previousStep"
                                    class="px-4 py-2.5 sm:px-5 sm:py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 active:scale-98 text-slate-700 font-bold text-xs uppercase tracking-wider transition-all flex items-center gap-1.5 cursor-pointer"
                                >
                                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                    <span>Kembali</span>
                                </button>
                            @else
                                <a
                                    href="{{ route('dutaolahraga') }}"
                                    wire:navigate
                                    class="px-4 py-2.5 rounded-2xl text-slate-400 hover:text-slate-600 font-bold text-xs uppercase tracking-wider transition-all inline-flex items-center gap-1"
                                >
                                    Batal
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            @if($currentStep < $totalSteps)
                                <button
                                    type="button"
                                    wire:click="nextStep"
                                    wire:loading.attr="disabled"
                                    wire:target="nextStep"
                                    class="px-6 py-2.5 sm:px-8 sm:py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 active:scale-98 text-white font-black text-xs uppercase tracking-wider transition-all shadow-md shadow-emerald-600/20 flex items-center gap-2 cursor-pointer disabled:opacity-50"
                                >
                                    <span>Lanjut</span>
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </button>
                            @else
                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    @disabled($sudahTerdaftarSebagaiDuta)
                                    class="px-6 py-2.5 sm:px-8 sm:py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 hover:brightness-105 active:scale-98 text-white font-black text-xs uppercase tracking-wider transition-all shadow-lg shadow-emerald-600/30 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                                >
                                    <span wire:loading.remove wire:target="submit" class="flex items-center gap-2">
                                        <i data-lucide="send" class="w-4 h-4"></i>
                                        <span>Kirim Pendaftaran</span>
                                    </span>
                                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                        <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                        <span>Mengirim Data...</span>
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>

                </form>
            </div>

            <p class="text-center text-[10px] sm:text-[11px] text-slate-400 leading-relaxed px-4">
                Data pendaftaran diverifikasi administrator KORMI Kabupaten Bandung. Profil hanya ditampilkan di direktori publik setelah disetujui.
            </p>
        @endif

    </div>
</div>
