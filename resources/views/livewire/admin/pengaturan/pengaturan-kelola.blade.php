<div class="space-y-6">

    <!-- FLASH NOTIFICATION -->
    @if(session()->has('pesan'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xs animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
                <span>{{ session('pesan') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1.5 rounded-lg transition-colors cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    <!-- 1. HEADER BANNER -->
    <x-form.header
        title="Pengaturan & Konfigurasi Portal"
        subtitle="Kelola identitas resmi, informasi kontak sekretariat, tautan media sosial, serta aset logo branding KORMI Kabupaten Bandung."
        badge="Konfigurasi Global"
        icon="settings"
    >
        <x-slot:actions>
            <x-form.button 
                type="button"
                variant="primary" 
                size="default" 
                icon="save" 
                loading-target="simpan"
                wire:click="simpan"
            >
                Simpan Semua Pengaturan
            </x-form.button>
        </x-slot:actions>
    </x-form.header>

    <!-- 2. SUB-NAVIGATION TABS -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none border-b border-slate-200">
        @php
            $tabs = [
                'umum' => ['label' => 'Profil & Umum', 'icon' => 'globe'],
                'kontak' => ['label' => 'Kontak & Sekretariat', 'icon' => 'phone-call'],
                'sosmed' => ['label' => 'Media Sosial & Tautan', 'icon' => 'share-2'],
                'branding' => ['label' => 'Logo & Identitas Visual', 'icon' => 'palette'],
            ];
        @endphp

        @foreach($tabs as $tabKey => $tabCfg)
            <button 
                type="button" 
                wire:click="setTab('{{ $tabKey }}')"
                class="px-4 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2 cursor-pointer shrink-0 {{ $tabAktif === $tabKey ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200/80' }}"
            >
                <i data-lucide="{{ $tabCfg['icon'] }}" class="w-4 h-4"></i>
                <span>{{ $tabCfg['label'] }}</span>
            </button>
        @endforeach
    </div>

    <!-- 3. FORM BODY (2 Columns: 8 cols Form + 4 cols Live Preview) -->
    <form wire:submit.prevent="simpan" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Column (8 cols): Active Tab Inputs -->
            <div class="lg:col-span-8 space-y-6">

                <!-- TAB 1: PROFIL & INFORMASI UMUM -->
                @if($tabAktif === 'umum')
                    <x-form.card 
                        title="Identitas & Profil Situs" 
                        subtitle="Informasi dasar institusi yang muncul pada judul browser, header, dan meta deskripsi pencarian."
                        icon="globe"
                    >
                        <!-- Nama Situs -->
                        <x-form.field label="Nama Portal / Situs" name="nama_situs" :required="true">
                            <x-form.input 
                                name="nama_situs" 
                                wire:model.live.debounce.300ms="nama_situs" 
                                placeholder="Contoh: KORMI Kabupaten Bandung" 
                                icon="globe"
                            />
                        </x-form.field>

                        <!-- Tagline / Slogan -->
                        <x-form.field label="Tagline / Slogan Resmi" name="tagline_situs">
                            <x-form.input 
                                name="tagline_situs" 
                                wire:model.live.debounce.300ms="tagline_situs" 
                                placeholder="Contoh: Sehat, Bugar, Gembira, Luar Biasa!" 
                                icon="award"
                            />
                        </x-form.field>

                        <!-- Deskripsi Situs -->
                        <x-form.field label="Deskripsi Profil Organisasi" name="deskripsi_situs" hint="Ditampilkan di footer dan meta tag search engine">
                            <x-form.textarea 
                                name="deskripsi_situs" 
                                wire:model.live.debounce.300ms="deskripsi_situs" 
                                rows="3" 
                                placeholder="Deskripsi ringkas mengenai peran dan fungsi KORMI Kabupaten Bandung..."
                            />
                        </x-form.field>

                        <!-- Alamat Kantor -->
                        <x-form.field label="Alamat Kantor Sekretariat" name="alamat_kantor">
                            <x-form.textarea 
                                name="alamat_kantor" 
                                wire:model.live.debounce.300ms="alamat_kantor" 
                                rows="2" 
                                placeholder="Jl. Raya Soreang No. ... Kompleks Stadion Si Jalak Harupat, Kabupaten Bandung..."
                            />
                        </x-form.field>

                        <!-- Google Maps Embed -->
                        <x-form.field label="Tautan / Embed Google Maps" name="gmaps_embed" hint="URL embed peta lokasi sekretariat">
                            <x-form.input 
                                name="gmaps_embed" 
                                wire:model="gmaps_embed" 
                                placeholder="https://www.google.com/maps/embed?..." 
                                icon="map-pin"
                            />
                        </x-form.field>
                    </x-form.card>
                @endif

                <!-- TAB 2: KONTAK & SEKRETARIAT -->
                @if($tabAktif === 'kontak')
                    <x-form.card 
                        title="Informasi Kontak & Layanan" 
                        subtitle="Kanal komunikasi resmi masyarakat dan induk organisasi olahraga rekreasi."
                        icon="phone-call"
                    >
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Email -->
                            <x-form.field label="Email Resmi Sekretariat" name="email_kontak">
                                <x-form.input 
                                    type="email" 
                                    name="email_kontak" 
                                    wire:model.live.debounce.300ms="email_kontak" 
                                    placeholder="sekretariat@kormikabbdg.id" 
                                    icon="mail"
                                />
                            </x-form.field>

                            <!-- Nomor Telepon -->
                            <x-form.field label="Nomor Telepon Kantor" name="nomor_telepon">
                                <x-form.input 
                                    name="nomor_telepon" 
                                    wire:model.live.debounce.300ms="nomor_telepon" 
                                    placeholder="022-8587xxxx" 
                                    icon="phone"
                                />
                            </x-form.field>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- WhatsApp -->
                            <x-form.field label="Nomor WhatsApp Helpdesk" name="nomor_whatsapp">
                                <x-form.input 
                                    name="nomor_whatsapp" 
                                    wire:model.live.debounce.300ms="nomor_whatsapp" 
                                    placeholder="081234567890" 
                                    icon="message-circle"
                                />
                            </x-form.field>

                            <!-- Jam Operasional -->
                            <x-form.field label="Jam Layanan Kantor" name="jam_operasional">
                                <x-form.input 
                                    name="jam_operasional" 
                                    wire:model="jam_operasional" 
                                    placeholder="Senin - Jumat: 08.00 - 16.00 WIB" 
                                    icon="clock"
                                />
                            </x-form.field>
                        </div>
                    </x-form.card>
                @endif

                <!-- TAB 3: MEDIA SOSIAL -->
                @if($tabAktif === 'sosmed')
                    <x-form.card 
                        title="Media Sosial & Portal Mitra" 
                        subtitle="Tautan akun media sosial publikasi kegiatan dan afiliasi KORMI Nasional / Jawa Barat."
                        icon="share-2"
                    >
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Instagram -->
                            <x-form.field label="Instagram URL" name="instagram">
                                <x-form.input 
                                    name="instagram" 
                                    wire:model.live.debounce.300ms="instagram" 
                                    placeholder="https://instagram.com/kormikabupatenbandung" 
                                    icon="instagram"
                                />
                            </x-form.field>

                            <!-- Facebook -->
                            <x-form.field label="Facebook Fanpage URL" name="facebook">
                                <x-form.input 
                                    name="facebook" 
                                    wire:model.live.debounce.300ms="facebook" 
                                    placeholder="https://facebook.com/kormikabbdg" 
                                    icon="facebook"
                                />
                            </x-form.field>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- YouTube -->
                            <x-form.field label="YouTube Channel URL" name="youtube">
                                <x-form.input 
                                    name="youtube" 
                                    wire:model.live.debounce.300ms="youtube" 
                                    placeholder="https://youtube.com/@kormikabupatenbandung" 
                                    icon="video"
                                />
                            </x-form.field>

                            <!-- TikTok -->
                            <x-form.field label="TikTok Account URL" name="tiktok">
                                <x-form.input 
                                    name="tiktok" 
                                    wire:model.live.debounce.300ms="tiktok" 
                                    placeholder="https://tiktok.com/@kormikabbdg" 
                                    icon="play"
                                />
                            </x-form.field>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                            <!-- KORMI Pusat -->
                            <x-form.field label="Website KORMI Nasional (Pusat)" name="website_kormi_pusat">
                                <x-form.input 
                                    name="website_kormi_pusat" 
                                    wire:model="website_kormi_pusat" 
                                    placeholder="https://kormi.or.id" 
                                    icon="external-link"
                                />
                            </x-form.field>

                            <!-- KORMI Jabar -->
                            <x-form.field label="Website KORMI Jawa Barat" name="website_kormi_jabar">
                                <x-form.input 
                                    name="website_kormi_jabar" 
                                    wire:model="website_kormi_jabar" 
                                    placeholder="https://kormijabar.or.id" 
                                    icon="external-link"
                                />
                            </x-form.field>
                        </div>
                    </x-form.card>
                @endif

                <!-- TAB 4: LOGO & BRANDING -->
                @if($tabAktif === 'branding')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Logo Utama -->
                        <x-form.card 
                            title="Logo Utama Portal" 
                            subtitle="Format PNG transparan atau WEBP / SVG."
                            icon="image"
                        >
                            <x-form.image-upload
                                :upload="$uploadLogo"
                                :saved-path="$logo_path"
                                name="uploadLogo"
                                input-id="uploadLogoUtama"
                                empty-title="Unggah Logo Utama KORMI"
                                empty-subtitle="Format PNG, SVG, WEBP (Maksimal 5MB)"
                                :max-size-m-b="5"
                                aspect-ratio="h-44 sm:h-52"
                            />
                        </x-form.card>

                        <!-- Favicon -->
                        <x-form.card 
                            title="Favicon / Icon Tab Browser" 
                            subtitle="Ikon kecil persegi pada browser tab."
                            icon="layout"
                        >
                            <x-form.image-upload
                                :upload="$uploadFavicon"
                                :saved-path="$favicon_path"
                                name="uploadFavicon"
                                input-id="uploadFaviconBrowser"
                                empty-title="Unggah Favicon"
                                empty-subtitle="Format PNG, ICO (Maksimal 2MB)"
                                :max-size-m-b="2"
                                aspect-ratio="h-44 sm:h-52"
                            />
                        </x-form.card>
                    </div>
                @endif

            </div>

            <!-- Right Column (4 cols): Live Brand Preview & Info Card -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Live Brand Preview Card -->
                <x-form.card 
                    title="Pratinjau Branding" 
                    subtitle="Simulasi tampilan identitas di portal publik."
                    icon="eye"
                >
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 text-white space-y-4 shadow-lg">
                        <!-- Header Mockup -->
                        <div class="flex items-center gap-3 pb-3 border-b border-white/10">
                            @if($uploadLogo)
                                <img src="{{ $uploadLogo->temporaryUrl() }}" class="h-10 w-auto object-contain" alt="Logo">
                            @elseif($logo_path)
                                <img src="{{ app(\App\Services\StorageService::class)->getTemporaryUrl($logo_path) }}" class="h-10 w-auto object-contain" alt="Logo">
                            @else
                                <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-black text-sm">
                                    KB
                                </div>
                            @endif

                            <div class="min-w-0">
                                <h4 class="text-xs font-black text-white truncate tracking-tight">
                                    {{ $nama_situs ?: 'KORMI Kabupaten Bandung' }}
                                </h4>
                                <p class="text-[10px] text-emerald-400 font-bold truncate">
                                    {{ $tagline_situs ?: 'Sehat, Bugar, Gembira, Luar Biasa!' }}
                                </p>
                            </div>
                        </div>

                        <!-- Description & Contact -->
                        <div class="space-y-2 text-xs text-slate-300">
                            @if($alamat_kantor)
                                <p class="line-clamp-2 text-[11px] leading-relaxed">
                                    📍 {{ $alamat_kantor }}
                                </p>
                            @endif
                            @if($nomor_telepon || $email_kontak)
                                <div class="flex flex-wrap gap-2 text-[10px] pt-1">
                                    @if($nomor_telepon)
                                        <span class="px-2 py-0.5 rounded-md bg-white/10 text-white font-mono">📞 {{ $nomor_telepon }}</span>
                                    @endif
                                    @if($email_kontak)
                                        <span class="px-2 py-0.5 rounded-md bg-white/10 text-white">✉️ {{ $email_kontak }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Social Media Mockup -->
                        <div class="pt-3 border-t border-white/10 flex items-center gap-2">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Sosmed:</span>
                            <div class="flex items-center gap-1.5 text-xs text-emerald-400">
                                @if($instagram)<i data-lucide="instagram" class="w-4 h-4"></i>@endif
                                @if($facebook)<i data-lucide="facebook" class="w-4 h-4"></i>@endif
                                @if($youtube)<i data-lucide="youtube" class="w-4 h-4"></i>@endif
                                @if($tiktok)<i data-lucide="play" class="w-4 h-4"></i>@endif
                            </div>
                        </div>
                    </div>
                </x-form.card>

                <!-- Information Guide Card -->
                <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-3xl p-5 space-y-3">
                    <h4 class="text-xs font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                        <span>Penyimpanan Aman</span>
                    </h4>
                    <p class="text-xs text-emerald-950 leading-relaxed">
                        Seluruh pengaturan situs disimpan dalam basis data terpusat dan aset logo secara otomatis disinkronkan dengan media storage MinIO S3 terenkripsi.
                    </p>
                </div>
            </div>
        </div>

        <!-- 4. ACTION BAR -->
        <x-form.action-bar>
            <div class="text-xs text-slate-500 font-medium">
                Perubahan pengaturan langsung diterapkan pada seluruh halaman portal publik.
            </div>

            <x-form.button 
                type="submit" 
                variant="primary" 
                icon="save" 
                loading-target="simpan"
            >
                Simpan Semua Pengaturan
            </x-form.button>
        </x-form.action-bar>
    </form>

</div>
