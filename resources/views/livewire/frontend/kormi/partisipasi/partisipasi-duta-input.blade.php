<div class="min-h-[85vh] py-6 sm:py-12 bg-gradient-to-b from-amber-50/40 via-slate-50/50 to-white">
    <div class="max-w-4xl mx-auto px-3.5 sm:px-6 space-y-5">

        <!-- Top Navigation Bar & Context Breadcrumb -->
        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <a href="{{ route('partisipasi.riwayat') }}" wire:navigate class="p-2 sm:p-2.5 rounded-xl bg-white border border-slate-200/80 text-slate-500 hover:text-amber-700 hover:border-amber-300 transition-all shadow-xs group" title="Kembali ke Riwayat">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform"></i>
                </a>
                <div>
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-amber-50 text-amber-800 text-[10px] font-black uppercase tracking-wider border border-amber-200/60">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            Portal Duta Olahraga
                        </span>
                        <span class="text-xs font-semibold text-slate-400 hidden sm:inline">• Laporan Massal Komunitas Warga</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('partisipasi.riwayat') }}" wire:navigate class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-3.5 rounded-xl bg-white border border-slate-200/90 text-slate-700 font-bold text-[11px] sm:text-xs hover:bg-slate-50 hover:text-amber-700 transition shadow-xs">
                    <i data-lucide="award" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span>Riwayat & Portofolio</span>
                </a>
            </div>
        </div>

        @if($berhasilSimpan)
            <!-- ========================================== -->
            <!-- SUCCESS STATE: CELEBRATORY DUTA LAPORAN    -->
            <!-- ========================================== -->
            <div class="relative overflow-hidden bg-gradient-to-br from-white via-amber-50/40 to-orange-50/20 rounded-3xl border border-amber-200/90 p-6 sm:p-12 text-center shadow-xl shadow-amber-500/5 animate-fade-in">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-orange-400/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 space-y-5 max-w-lg mx-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-gradient-to-tr from-amber-500 to-orange-400 text-white flex items-center justify-center mx-auto shadow-lg shadow-amber-600/30 ring-8 ring-amber-100/60">
                        <i data-lucide="check" class="w-8 h-8 sm:w-10 sm:h-10 stroke-[3]"></i>
                    </div>

                    <div class="space-y-2">
                        <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-amber-800 bg-amber-100/80 px-3 py-1 rounded-full">
                            Laporan Duta Terverifikasi Otomatis
                        </span>
                        <h2 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight">Laporan Olahraga Massal Tercatat!</h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kegiatan <strong class="text-slate-900 font-extrabold">{{ $nama_aktivitas ?: 'Olahraga Massal' }}</strong> dengan estimasi <strong class="text-amber-700 font-extrabold">{{ $jumlah_peserta }} Peserta</strong> berhasil diarsipkan ke database APMO Kabupaten Bandung.
                        </p>
                    </div>

                    <div class="pt-3 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <button 
                            type="button" 
                            wire:click="resetForm" 
                            class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-amber-600 hover:bg-amber-700 active:scale-98 text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-md shadow-amber-600/25 cursor-pointer flex items-center justify-center gap-2"
                        >
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                            Lapor Kegiatan Lainnya
                        </button>
                        <a 
                            href="{{ route('partisipasi.riwayat') }}" 
                            wire:navigate
                            class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-white hover:bg-slate-50 active:scale-98 text-slate-800 font-bold text-xs uppercase tracking-wider border border-slate-200/90 transition shadow-xs flex items-center justify-center gap-2"
                        >
                            <i data-lucide="award" class="w-4 h-4 text-amber-500"></i>
                            Portofolio & Rekapitulasi
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- ========================================== -->
            <!-- COMPACT & PRO DUTA FORM WIZARD CONTAINER   -->
            <!-- ========================================== -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-900/[0.03] overflow-hidden">
                
                <!-- Hero Form Header Banner -->
                <div class="relative bg-gradient-to-r from-amber-900 via-slate-900 to-stone-950 p-5 sm:p-7 text-white">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <h1 class="text-lg sm:text-2xl font-black tracking-tight text-white flex items-center gap-2">
                                <span>Lapor Kegiatan Olahraga Massal</span>
                                <span class="text-[9px] sm:text-[10px] font-black bg-amber-400 text-slate-950 px-2 py-0.5 rounded-md uppercase tracking-wider">Duta Desa</span>
                            </h1>
                            <p class="text-[11px] sm:text-xs text-amber-200/80 max-w-lg leading-relaxed">
                                Formulir resmi pelaporan senam massal, jalan sehat, atau olahraga tradisional tingkat RT/RW dan Desa binaan.
                            </p>
                        </div>
                        <div class="flex items-center gap-2 self-start sm:self-auto shrink-0 bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/10">
                            <i data-lucide="target" class="w-4 h-4 text-amber-400"></i>
                            <div>
                                <span class="block text-[9px] uppercase tracking-wider text-amber-200/80 font-bold leading-none">Langkah Form</span>
                                <span class="text-xs font-black text-white">Step {{ $currentStep }} dari {{ $totalSteps }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP WIZARD HEADER BAR (RESPONSIVE FOR MOBILE) -->
                <div class="border-b border-slate-100 bg-slate-50/70 p-3 sm:px-8 sm:py-4">
                    <!-- Progress line in mobile -->
                    <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden mb-3 sm:hidden">
                        <div class="bg-gradient-to-r from-amber-500 to-orange-500 h-full transition-all duration-300" style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                    </div>

                    <!-- Step Indicators -->
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Step 1 Indicator -->
                        <button 
                            type="button" 
                            wire:click="setStep(1)"
                            class="flex items-center gap-2 p-2 sm:p-2.5 rounded-2xl text-left transition-all cursor-pointer {{ $currentStep === 1 ? 'bg-amber-600 text-white shadow-md shadow-amber-600/20' : ($currentStep > 1 ? 'bg-amber-50 text-amber-900 hover:bg-amber-100/60' : 'bg-white text-slate-400 hover:bg-slate-100/60 border border-slate-200/70') }}"
                        >
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl flex items-center justify-center font-black text-xs shrink-0 {{ $currentStep === 1 ? 'bg-white/20 text-white' : ($currentStep > 1 ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-500') }}">
                                @if($currentStep > 1)
                                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                                @else
                                    1
                                @endif
                            </div>
                            <div class="min-w-0">
                                <span class="block text-[9px] font-bold uppercase tracking-wider leading-none {{ $currentStep === 1 ? 'text-amber-100' : 'text-slate-400' }}">Langkah 1</span>
                                <span class="block text-[11px] sm:text-xs font-black truncate leading-tight mt-0.5">Acara & Peserta</span>
                            </div>
                        </button>

                        <!-- Step 2 Indicator -->
                        <button 
                            type="button" 
                            wire:click="setStep(2)"
                            class="flex items-center gap-2 p-2 sm:p-2.5 rounded-2xl text-left transition-all cursor-pointer {{ $currentStep === 2 ? 'bg-amber-600 text-white shadow-md shadow-amber-600/20' : ($currentStep > 2 ? 'bg-amber-50 text-amber-900 hover:bg-amber-100/60' : 'bg-white text-slate-400 hover:bg-slate-100/60 border border-slate-200/70') }}"
                        >
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl flex items-center justify-center font-black text-xs shrink-0 {{ $currentStep === 2 ? 'bg-white/20 text-white' : ($currentStep > 2 ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-500') }}">
                                @if($currentStep > 2)
                                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                                @else
                                    2
                                @endif
                            </div>
                            <div class="min-w-0">
                                <span class="block text-[9px] font-bold uppercase tracking-wider leading-none {{ $currentStep === 2 ? 'text-amber-100' : 'text-slate-400' }}">Langkah 2</span>
                                <span class="block text-[11px] sm:text-xs font-black truncate leading-tight mt-0.5">Lokasi Desa</span>
                            </div>
                        </button>

                        <!-- Step 3 Indicator -->
                        <button 
                            type="button" 
                            wire:click="setStep(3)"
                            class="flex items-center gap-2 p-2 sm:p-2.5 rounded-2xl text-left transition-all cursor-pointer {{ $currentStep === 3 ? 'bg-amber-600 text-white shadow-md shadow-amber-600/20' : 'bg-white text-slate-400 hover:bg-slate-100/60 border border-slate-200/70' }}"
                        >
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl flex items-center justify-center font-black text-xs shrink-0 {{ $currentStep === 3 ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                                3
                            </div>
                            <div class="min-w-0">
                                <span class="block text-[9px] font-bold uppercase tracking-wider leading-none {{ $currentStep === 3 ? 'text-amber-100' : 'text-slate-400' }}">Langkah 3</span>
                                <span class="block text-[11px] sm:text-xs font-black truncate leading-tight mt-0.5">Dokumentasi</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Form Content Body -->
                <form wire:submit.prevent="simpan" class="p-4 sm:p-8">

                    <!-- ========================================== -->
                    <!-- STEP 1: ACARA, PRESET & JUMLAH PESERTA     -->
                    <!-- ========================================== -->
                    @if($currentStep === 1)
                        <div class="space-y-6 animate-fade-in">
                            <!-- Header Substep -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div>
                                    <h3 class="text-sm sm:text-base font-black text-slate-900">Pilih Jenis Acara & Jumlah Peserta</h3>
                                    <p class="text-xs text-slate-500">Pilih dari preset cepat atau lengkapi detail acara komunitas.</p>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-800 px-2.5 py-1 rounded-lg">Wajib</span>
                            </div>

                            <!-- Preset Pilihan Cepat -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-wider text-slate-600 flex items-center justify-between">
                                    <span>Pilihan Cepat Kegiatan Komunal</span>
                                    <span class="text-slate-400 font-medium lowercase">1-klik terisi</span>
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                    @php
                                        $presets = [
                                            ['nama' => 'Senam Sehat Massal Desa', 'slug' => 'senam', 'icon' => 'activity', 'peserta' => 40],
                                            ['nama' => 'Jalan Santai Warga RW', 'slug' => 'jalan', 'icon' => 'footprints', 'peserta' => 60],
                                            ['nama' => 'Latihan Olahraga Tradisional', 'slug' => 'tradisional', 'icon' => 'swords', 'peserta' => 25],
                                            ['nama' => 'Gowes / Sepeda Santai Bersama', 'slug' => 'sepeda', 'icon' => 'bike', 'peserta' => 30],
                                        ];
                                    @endphp
                                    @foreach($presets as $p)
                                        @php $isActive = ($nama_aktivitas === $p['nama']); @endphp
                                        <button 
                                            type="button" 
                                            wire:click="setPresetKegiatan('{{ $p['nama'] }}', '{{ $p['slug'] }}')"
                                            class="p-2.5 rounded-2xl text-left transition-all border cursor-pointer flex flex-col justify-between gap-1.5 group {{ $isActive ? 'bg-amber-600 text-white border-amber-600 shadow-md shadow-amber-600/20 ring-2 ring-amber-400/30' : 'bg-slate-50/80 hover:bg-slate-100 text-slate-700 border-slate-200/70' }}"
                                        >
                                            <div class="w-6 h-6 rounded-lg flex items-center justify-center shrink-0 {{ $isActive ? 'bg-white/20 text-white' : 'bg-white text-amber-700 shadow-xs' }}">
                                                <i data-lucide="{{ $p['icon'] }}" class="w-3.5 h-3.5"></i>
                                            </div>
                                            <div>
                                                <p class="text-[11px] font-bold line-clamp-1 leading-tight {{ $isActive ? 'text-white' : 'text-slate-800' }}">{{ $p['nama'] }}</p>
                                                <span class="text-[10px] block mt-0.5 {{ $isActive ? 'text-amber-100' : 'text-slate-400' }}">Preset Duta</span>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Form Input Nama Aktivitas & Inorga -->
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                                <div class="sm:col-span-7">
                                    <x-form.field label="Nama Acara / Kegiatan Olahraga" name="nama_aktivitas" :required="true">
                                        <x-form.input 
                                            wire:model="nama_aktivitas" 
                                            icon="flag" 
                                            placeholder="Contoh: Senam Minggu Pagi RW 05, Jalan Santai Desa..." 
                                        />
                                    </x-form.field>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-form.field label="Induk Olahraga (INORGA)" name="inorga_id">
                                        <x-form.select wire:model="inorga_id">
                                            <option value="">-- Umum / Tanpa Inorga --</option>
                                            @foreach($daftarInorga as $ino)
                                                <option value="{{ $ino->id }}">{{ $ino->singkatan ? $ino->singkatan . ' - ' : '' }}{{ $ino->nama_inorga }}</option>
                                            @endforeach
                                        </x-form.select>
                                    </x-form.field>
                                </div>
                            </div>

                            <!-- Box Estimasi Peserta, Waktu & Durasi -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-amber-50/40 border border-amber-200/70 space-y-4">
                                <div class="flex items-center justify-between pb-2.5 border-b border-amber-200/60">
                                    <span class="text-xs font-black uppercase tracking-wider text-amber-900">Peserta & Waktu Pelaksanaan</span>
                                    <button 
                                        type="button" 
                                        wire:click="syncWaktuSekarang" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white hover:bg-amber-100 text-amber-800 text-[11px] font-bold transition border border-amber-200/80 cursor-pointer shadow-2xs"
                                    >
                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-600"></i>
                                        <span>Waktu Sekarang</span>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                                    <!-- Estimasi Peserta -->
                                    <div class="sm:col-span-5 space-y-2">
                                        <x-form.field label="Estimasi Jumlah Peserta (Orang)" name="jumlah_peserta" :required="true">
                                            <div class="space-y-2">
                                                <div class="grid grid-cols-4 gap-1.5">
                                                    @foreach([15, 30, 50, 100] as $jml)
                                                        <button 
                                                            type="button" 
                                                            wire:click="setPeserta({{ $jml }})"
                                                            class="py-1.5 rounded-xl text-xs font-bold transition cursor-pointer text-center {{ $jumlah_peserta === $jml ? 'bg-amber-600 text-white shadow-xs font-extrabold' : 'bg-white text-slate-700 hover:bg-amber-50 border border-slate-200/80' }}"
                                                        >
                                                            {{ $jml }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                                <x-form.input 
                                                    type="number" 
                                                    wire:model="jumlah_peserta" 
                                                    icon="users"
                                                    min="2" 
                                                    max="5000" 
                                                    placeholder="Ketik angka peserta..." 
                                                />
                                            </div>
                                        </x-form.field>
                                    </div>

                                    <!-- Tanggal & Jam -->
                                    <div class="sm:col-span-4">
                                        <x-form.field label="Tanggal Kegiatan" name="tanggal_aktivitas" :required="true">
                                            <x-form.input 
                                                type="date" 
                                                wire:model="tanggal_aktivitas" 
                                                max="{{ now()->toDateString() }}" 
                                            />
                                        </x-form.field>
                                    </div>

                                    <!-- Durasi Menit -->
                                    <div class="sm:col-span-3">
                                        <x-form.field label="Durasi (Menit)" name="durasi_menit" :required="true">
                                            <x-form.input 
                                                type="number" 
                                                wire:model="durasi_menit" 
                                                icon="timer"
                                                min="15" 
                                                max="360" 
                                                placeholder="Menit" 
                                            />
                                        </x-form.field>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- STEP 2: LOKASI & TITIK WILAYAH DESA        -->
                    <!-- ========================================== -->
                    @if($currentStep === 2)
                        <div class="space-y-6 animate-fade-in" x-data="{
                            isLocating: false,
                            errorMessage: '',
                            detectLocation() {
                                if (!navigator.geolocation) {
                                    this.errorMessage = 'Browser tidak mendukung GPS Geolocation.';
                                    return;
                                }
                                this.isLocating = true;
                                this.errorMessage = '';
                                navigator.geolocation.getCurrentPosition(
                                    async (pos) => {
                                        const lat = pos.coords.latitude;
                                        const lng = pos.coords.longitude;
                                        try {
                                            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                                            const data = await res.json();
                                            const addr = data.address || {};
                                            const subdistrict = addr.municipality || addr.suburb || addr.city_district || addr.district || '';
                                            const village = addr.village || addr.quarter || addr.neighbourhood || '';
                                            const road = addr.road || addr.building || data.display_name?.split(',')[0] || '';
                                            
                                            let fullPlace = road;
                                            if (village && !fullPlace.includes(village)) fullPlace += (fullPlace ? ', ' : '') + village;
                                            if (subdistrict && !fullPlace.includes(subdistrict)) fullPlace += (fullPlace ? ', Kec. ' : '') + subdistrict;

                                            @this.applyGeolocation(lat, lng, fullPlace, subdistrict, village);
                                        } catch (e) {
                                            @this.applyGeolocation(lat, lng, null, null, null);
                                        } finally {
                                            this.isLocating = false;
                                        }
                                    },
                                    (err) => {
                                        this.isLocating = false;
                                        this.errorMessage = 'Izin akses lokasi ditolak atau GPS tidak aktif.';
                                    },
                                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                                );
                            }
                        }">
                            <!-- Header Substep with GPS Auto-Detect Button -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                                <div>
                                    <h3 class="text-sm sm:text-base font-black text-slate-900">Lokasi & Wilayah Binaan Desa</h3>
                                    <p class="text-xs text-slate-500">Pilih wilayah desa atau gunakan GPS deteksi otomatis di lapangan.</p>
                                </div>
                                <button 
                                    type="button" 
                                    @click="detectLocation()"
                                    :disabled="isLocating"
                                    class="inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-xl bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white text-xs font-bold shadow-sm shadow-amber-600/20 active:scale-98 transition cursor-pointer disabled:opacity-60"
                                >
                                    <template x-if="!isLocating">
                                        <span class="inline-flex items-center gap-1.5">
                                            <i data-lucide="crosshair" class="w-3.5 h-3.5"></i>
                                            <span>Deteksi GPS Saya</span>
                                        </span>
                                    </template>
                                    <template x-if="isLocating">
                                        <span class="inline-flex items-center gap-1.5">
                                            <i data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i>
                                            <span>Mendeteksi Lokasi...</span>
                                        </span>
                                    </template>
                                </button>
                            </div>

                            <div x-show="errorMessage" class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-center gap-2" x-text="errorMessage"></div>

                            @if($lokasi_terdeteksi_label)
                                <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200/80 flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2.5 text-xs text-amber-900 min-w-0">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-amber-600 shrink-0"></i>
                                        <span class="font-bold truncate">GPS Terdeteksi: <strong class="text-amber-950 font-black">{{ $lokasi_terdeteksi_label }}</strong></span>
                                    </div>
                                    <button type="button" wire:click="$set('lokasi_terdeteksi_label', null)" class="text-[11px] font-bold text-slate-400 hover:text-slate-600 shrink-0 cursor-pointer">Reset</button>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <!-- Kecamatan -->
                                <div>
                                    <x-form.field label="Kecamatan" name="kecamatan_id" :required="true">
                                        <x-form.select wire:model.live="kecamatan_id">
                                            <option value="">-- Pilih Kecamatan --</option>
                                            @foreach($daftarKecamatan as $kec)
                                                <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                            @endforeach
                                        </x-form.select>
                                    </x-form.field>
                                </div>

                                <!-- Desa / Kelurahan -->
                                <div>
                                    <x-form.field label="Desa / Kelurahan" name="desa_kelurahan_id">
                                        <x-form.select wire:model="desa_kelurahan_id" :disabled="!$kecamatan_id">
                                            <option value="">-- Pilih Desa / Kelurahan --</option>
                                            @foreach($daftarDesa as $des)
                                                <option value="{{ $des->id }}">{{ $des->nama_desa_kelurahan }}</option>
                                            @endforeach
                                        </x-form.select>
                                    </x-form.field>
                                </div>

                                <!-- Tipe Lokasi -->
                                <div>
                                    <x-form.field label="Tipe Lokasi" name="kategori_lokasi" :required="true">
                                        <x-form.select wire:model="kategori_lokasi">
                                            <option value="lapangan_desa">Lapangan Desa / Terbuka</option>
                                            <option value="sapras_kormi">Sarana / GOR KORMI</option>
                                            <option value="taman">Taman / Ruang Publik</option>
                                            <option value="jalan_desa">Jalan / Komplek Perumahan</option>
                                            <option value="sekolah">Halaman Sekolah / Kampus</option>
                                            <option value="rumah">Halaman Warga</option>
                                            <option value="lainnya">Lainnya</option>
                                        </x-form.select>
                                    </x-form.field>
                                </div>
                            </div>

                            <div>
                                <x-form.field label="Nama Lokasi / Lapangan" name="nama_tempat" :required="true">
                                    <x-form.input 
                                        wire:model="nama_tempat" 
                                        icon="map-pin"
                                        placeholder="Contoh: Lapangan Sepak Bola Desa Soreang, Alun-alun..." 
                                    />
                                </x-form.field>
                            </div>
                        </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- STEP 3: DOKUMENTASI FOTO & REVIEW          -->
                    <!-- ========================================== -->
                    @if($currentStep === 3)
                        <div class="space-y-6 animate-fade-in">
                            <!-- Header Substep -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div>
                                    <h3 class="text-sm sm:text-base font-black text-slate-900">Dokumentasi Bukti Lapangan</h3>
                                    <p class="text-xs text-slate-500">Unggah foto keramaian kegiatan warga & berkas pendukung.</p>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg">Final Step</span>
                            </div>

                            <!-- Summary Card Preview -->
                            <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 space-y-2.5 text-xs">
                                <span class="text-[10px] font-black uppercase tracking-wider text-amber-900 block">Ringkasan Laporan Duta</span>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-slate-800">
                                    <div>
                                        <span class="text-[10px] text-slate-400 font-bold block">Acara</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">{{ $nama_aktivitas ?: '-' }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 font-bold block">Peserta</span>
                                        <strong class="font-extrabold text-amber-800 block">{{ $jumlah_peserta }} Warga</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 font-bold block">Tanggal & Durasi</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">{{ $tanggal_aktivitas }} • {{ $durasi_menit }}'</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 font-bold block">Lokasi</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">{{ $nama_tempat ?: '-' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Foto Utama / Keramaian -->
                                <div>
                                    <x-form.field label="Foto Suasana / Keramaian Kegiatan" name="foto_kegiatan" :required="true">
                                        <x-form.image-upload 
                                            :upload="$foto_kegiatan" 
                                            name="foto_kegiatan" 
                                            emptyTitle="Pilih Foto Keramaian / Warga" 
                                            emptySubtitle="Format JPG, PNG, WEBP maks 10MB" 
                                            aspectRatio="h-36 sm:h-40"
                                        />
                                    </x-form.field>
                                </div>

                                <!-- Foto Daftar Hadir / Spanduk -->
                                <div>
                                    <x-form.field label="Foto Daftar Hadir / Spanduk" name="foto_daftar_hadir" badge="Opsional">
                                        <x-form.image-upload 
                                            :upload="$foto_daftar_hadir" 
                                            name="foto_daftar_hadir" 
                                            emptyTitle="Pilih Foto Daftar Hadir / Banner" 
                                            emptySubtitle="Format JPG, PNG, WEBP maks 10MB" 
                                            aspectRatio="h-36 sm:h-40"
                                        />
                                    </x-form.field>
                                </div>
                            </div>

                            <!-- Catatan Tambahan -->
                            <div>
                                <x-form.field label="Catatan / Keterangan Tambahan Duta" name="catatan" badge="Opsional">
                                    <x-form.textarea 
                                        wire:model="catatan" 
                                        rows="3" 
                                        placeholder="Tuliskan catatan dinamika kegiatan, antusiasme warga, atau kebutuhan sarana olahraga di desa..."
                                    />
                                </x-form.field>
                            </div>
                        </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- WIZARD BOTTOM CONTROLS & ACTIONS           -->
                    <!-- ========================================== -->
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
                                    href="{{ route('partisipasi.riwayat') }}" 
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
                                    class="px-6 py-2.5 sm:px-8 sm:py-3 rounded-2xl bg-amber-600 hover:bg-amber-700 active:scale-98 text-white font-black text-xs uppercase tracking-wider transition-all shadow-md shadow-amber-600/20 flex items-center gap-2 cursor-pointer"
                                >
                                    <span>Lanjut</span>
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </button>
                            @else
                                <button 
                                    type="submit" 
                                    wire:loading.attr="disabled"
                                    class="px-6 py-2.5 sm:px-8 sm:py-3.5 rounded-2xl bg-gradient-to-r from-amber-600 via-amber-700 to-orange-700 hover:brightness-105 active:scale-98 text-white font-black text-xs uppercase tracking-wider transition-all shadow-lg shadow-amber-600/30 cursor-pointer disabled:opacity-50 flex items-center justify-center gap-2"
                                >
                                    <span wire:loading.remove wire:target="simpan" class="flex items-center gap-2">
                                        <i data-lucide="send" class="w-4 h-4"></i>
                                        <span>Kirim Laporan Duta</span>
                                    </span>
                                    <span wire:loading wire:target="simpan" class="flex items-center gap-2">
                                        <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                        <span>Mengirim Data Lapangan...</span>
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>

                </form>
            </div>
        @endif

    </div>
</div>

