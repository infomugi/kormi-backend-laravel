<div class="min-h-[85vh] py-6 sm:py-12 bg-gradient-to-b from-slate-50 via-slate-50/50 to-white">
    <div class="max-w-4xl mx-auto px-3.5 sm:px-6 space-y-5">

        <!-- Top Navigation Bar & Context Breadcrumb -->
        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <a href="{{ route('partisipasi.riwayat') }}" wire:navigate class="p-2 sm:p-2.5 rounded-xl bg-white border border-slate-200/80 text-slate-500 hover:text-emerald-700 hover:border-emerald-300 transition-all shadow-xs group" title="Kembali ke Riwayat">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform"></i>
                </a>
                <div>
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-800 text-[10px] font-black uppercase tracking-wider border border-emerald-200/60">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            APMO Live Tracker
                        </span>
                        <span class="text-xs font-semibold text-slate-400 hidden sm:inline">• Form Partisipasi Warga</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('partisipasi.riwayat') }}" wire:navigate class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-3.5 rounded-xl bg-white border border-slate-200/90 text-slate-700 font-bold text-[11px] sm:text-xs hover:bg-slate-50 hover:text-emerald-700 transition shadow-xs">
                    <i data-lucide="award" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span>Riwayat Saya</span>
                </a>
            </div>
        </div>

        @if($berhasilSimpan)
            <!-- ========================================== -->
            <!-- SUCCESS STATE: ULTRA CLEAN & CELEBRATORY   -->
            <!-- ========================================== -->
            <div class="relative overflow-hidden bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/20 rounded-3xl border border-emerald-200/90 p-6 sm:p-12 text-center shadow-xl shadow-emerald-500/5 animate-fade-in">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-lime-400/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 space-y-5 max-w-lg mx-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center mx-auto shadow-lg shadow-emerald-600/30 ring-8 ring-emerald-100/60">
                        <i data-lucide="check" class="w-8 h-8 sm:w-10 sm:h-10 stroke-[3]"></i>
                    </div>

                    <div class="space-y-2">
                        <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-emerald-700 bg-emerald-100/80 px-3 py-1 rounded-full">
                            Tercatat di Database APMO
                        </span>
                        <h2 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight">Kebugaran Anda Meningkat!</h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Aktivitas <strong class="text-slate-900 font-extrabold">{{ $nama_aktivitas ?: 'Olahraga' }}</strong> berhasil disimpan. Sesi ini menambah akumulasi indeks partisipasi Kabupaten Bandung Bedas.
                        </p>
                    </div>

                    <div class="pt-3 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <button 
                            type="button" 
                            wire:click="resetForm" 
                            class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 active:scale-98 text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-md shadow-emerald-600/25 cursor-pointer flex items-center justify-center gap-2"
                        >
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                            Catat Sesi Lainnya
                        </button>
                        <a 
                            href="{{ route('partisipasi.riwayat') }}" 
                            wire:navigate
                            class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-white hover:bg-slate-50 active:scale-98 text-slate-800 font-bold text-xs uppercase tracking-wider border border-slate-200/90 transition shadow-xs flex items-center justify-center gap-2"
                        >
                            <i data-lucide="history" class="w-4 h-4 text-slate-400"></i>
                            Lihat Riwayat & Streak
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- ========================================== -->
            <!-- COMPACT & PRO FORM WIZARD CONTAINER        -->
            <!-- ========================================== -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-900/[0.03] overflow-hidden">
                
                <!-- Hero Form Header Banner -->
                <div class="relative bg-gradient-to-r from-emerald-900 via-slate-900 to-teal-950 p-5 sm:p-7 text-white">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <h1 class="text-lg sm:text-2xl font-black tracking-tight text-white flex items-center gap-2">
                                <span>Catat Aktivitas Olahraga</span>
                                <span class="text-[9px] sm:text-[10px] font-black bg-lime-400 text-slate-950 px-2 py-0.5 rounded-md uppercase tracking-wider">Mandiri</span>
                            </h1>
                            <p class="text-[11px] sm:text-xs text-emerald-200/80 max-w-lg leading-relaxed">
                                Kontribusikan durasi olahraga rutin Anda untuk pemetaan Indeks KORMI.
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

                <!-- STEP WIZARD HEADER BAR (RESPONSIVE FOR MOBILE) -->
                <div class="border-b border-slate-100 bg-slate-50/70 p-3 sm:px-8 sm:py-4">
                    <!-- Progress line in mobile -->
                    <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden mb-3 sm:hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-full transition-all duration-300" style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                    </div>

                    <!-- Step Indicators -->
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Step 1 Indicator -->
                        <button 
                            type="button" 
                            wire:click="setStep(1)"
                            class="flex items-center gap-2 p-2 sm:p-2.5 rounded-2xl text-left transition-all cursor-pointer {{ $currentStep === 1 ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : ($currentStep > 1 ? 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100/60' : 'bg-white text-slate-400 hover:bg-slate-100/60 border border-slate-200/70') }}"
                        >
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl flex items-center justify-center font-black text-xs shrink-0 {{ $currentStep === 1 ? 'bg-white/20 text-white' : ($currentStep > 1 ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-500') }}">
                                @if($currentStep > 1)
                                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                                @else
                                    1
                                @endif
                            </div>
                            <div class="min-w-0">
                                <span class="block text-[9px] font-bold uppercase tracking-wider leading-none {{ $currentStep === 1 ? 'text-emerald-100' : 'text-slate-400' }}">Langkah 1</span>
                                <span class="block text-[11px] sm:text-xs font-black truncate leading-tight mt-0.5">Aktivitas & Waktu</span>
                            </div>
                        </button>

                        <!-- Step 2 Indicator -->
                        <button 
                            type="button" 
                            wire:click="setStep(2)"
                            class="flex items-center gap-2 p-2 sm:p-2.5 rounded-2xl text-left transition-all cursor-pointer {{ $currentStep === 2 ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : ($currentStep > 2 ? 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100/60' : 'bg-white text-slate-400 hover:bg-slate-100/60 border border-slate-200/70') }}"
                        >
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl flex items-center justify-center font-black text-xs shrink-0 {{ $currentStep === 2 ? 'bg-white/20 text-white' : ($currentStep > 2 ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-500') }}">
                                @if($currentStep > 2)
                                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                                @else
                                    2
                                @endif
                            </div>
                            <div class="min-w-0">
                                <span class="block text-[9px] font-bold uppercase tracking-wider leading-none {{ $currentStep === 2 ? 'text-emerald-100' : 'text-slate-400' }}">Langkah 2</span>
                                <span class="block text-[11px] sm:text-xs font-black truncate leading-tight mt-0.5">Lokasi Tempat</span>
                            </div>
                        </button>

                        <!-- Step 3 Indicator -->
                        <button 
                            type="button" 
                            wire:click="setStep(3)"
                            class="flex items-center gap-2 p-2 sm:p-2.5 rounded-2xl text-left transition-all cursor-pointer {{ $currentStep === 3 ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-slate-400 hover:bg-slate-100/60 border border-slate-200/70' }}"
                        >
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl flex items-center justify-center font-black text-xs shrink-0 {{ $currentStep === 3 ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                                3
                            </div>
                            <div class="min-w-0">
                                <span class="block text-[9px] font-bold uppercase tracking-wider leading-none {{ $currentStep === 3 ? 'text-emerald-100' : 'text-slate-400' }}">Langkah 3</span>
                                <span class="block text-[11px] sm:text-xs font-black truncate leading-tight mt-0.5">Dokumentasi</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Form Content Body -->
                <form wire:submit.prevent="simpan" class="p-4 sm:p-8">
                    
                    <!-- ========================================== -->
                    <!-- STEP 1: AKTIVITAS, PRESET & WAKTU          -->
                    <!-- ========================================== -->
                    @if($currentStep === 1)
                        <div class="space-y-6 animate-fade-in">
                            <!-- Header Substep -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div>
                                    <h3 class="text-sm sm:text-base font-black text-slate-900">Pilih Olahraga & Waktu Pelaksanaan</h3>
                                    <p class="text-xs text-slate-500">Gunakan pilihan cepat atau masukkan cabor secara mandiri.</p>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg">Wajib</span>
                            </div>

                            <!-- Quick Chips Presets -->
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-wider text-slate-600 flex items-center justify-between">
                                    <span>Pilihan Cepat Aktivitas</span>
                                    <span class="text-slate-400 font-medium lowercase">1-klik terisi</span>
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
                                    @foreach($presetOlahraga as $preset)
                                        @php
                                            $isPresetActive = ($nama_aktivitas === $preset['nama']);
                                        @endphp
                                        <button 
                                            type="button"
                                            wire:click="pilihPreset('{{ $preset['nama'] }}', {{ $preset['durasi'] }})"
                                            class="p-2.5 rounded-2xl text-left transition-all border cursor-pointer flex flex-col justify-between gap-2 group {{ $isPresetActive ? 'bg-emerald-600 text-white border-emerald-600 shadow-md shadow-emerald-600/20 ring-2 ring-emerald-400/30' : 'bg-slate-50/80 hover:bg-slate-100 text-slate-700 border-slate-200/70' }}"
                                        >
                                            <div class="w-7 h-7 rounded-xl flex items-center justify-center shrink-0 {{ $isPresetActive ? 'bg-white/20 text-white' : 'bg-white text-emerald-700 shadow-xs' }}">
                                                <i data-lucide="{{ $preset['icon'] }}" class="w-3.5 h-3.5"></i>
                                            </div>
                                            <div>
                                                <p class="text-[11px] font-bold line-clamp-2 leading-tight {{ $isPresetActive ? 'text-white' : 'text-slate-800' }}">{{ $preset['nama'] }}</p>
                                                <span class="text-[10px] mt-0.5 block {{ $isPresetActive ? 'text-emerald-100' : 'text-slate-400' }}">{{ $preset['durasi'] }} mnt</span>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Custom Name Input & Inorga Selector using Design System Components -->
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                                <div class="sm:col-span-7">
                                    <x-form.field label="Nama Aktivitas / Cabor Spesifik" name="nama_aktivitas" :required="true">
                                        <x-form.input 
                                            wire:model="nama_aktivitas" 
                                            icon="dumbbell"
                                            placeholder="Contoh: Senam Bedas, Jogging Sore, Egrang..." 
                                        />
                                    </x-form.field>
                                </div>

                                <div class="sm:col-span-5">
                                    <x-form.field label="Rumpun Inorga KORMI (Opsional)" name="inorga_id">
                                        <x-form.select wire:model="inorga_id">
                                            <option value="">-- Umum / Tanpa Inorga --</option>
                                            @foreach($daftarInorga as $ino)
                                                <option value="{{ $ino->id }}">{{ $ino->singkatan ? $ino->singkatan . ' - ' : '' }}{{ $ino->nama_inorga }}</option>
                                            @endforeach
                                        </x-form.select>
                                    </x-form.field>
                                </div>
                            </div>

                            <!-- Waktu & Durasi Grid -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50/80 border border-slate-200/70 space-y-4">
                                <div class="flex items-center justify-between pb-2.5 border-b border-slate-200/60">
                                    <span class="text-xs font-black uppercase tracking-wider text-slate-700">Waktu & Tanggal Olahraga</span>
                                    <button 
                                        type="button" 
                                        wire:click="syncWaktuSekarang" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-[11px] font-bold transition border border-emerald-200/60 cursor-pointer shadow-2xs"
                                    >
                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-emerald-600"></i>
                                        <span>Gunakan Waktu Sekarang</span>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Tanggal -->
                                    <div>
                                        <x-form.field label="Tanggal Olahraga" name="tanggal_aktivitas" :required="true">
                                            <x-form.input 
                                                type="date" 
                                                wire:model="tanggal_aktivitas" 
                                                max="{{ now()->toDateString() }}"
                                            />
                                        </x-form.field>
                                    </div>

                                    <!-- Jam Mulai -->
                                    <div>
                                        <x-form.field label="Jam Mulai" name="waktu_mulai">
                                            <x-form.input 
                                                type="time" 
                                                wire:model="waktu_mulai"
                                            />
                                        </x-form.field>
                                    </div>

                                    <!-- Durasi Slider / Shortcuts -->
                                    <div>
                                        <div class="flex items-center justify-between mb-1.5">
                                            <label class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                                <span>Durasi Sesi</span>
                                                <span class="text-rose-500 font-bold">*</span>
                                            </label>
                                            <span class="text-xs font-black text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-md">{{ $durasi_menit }} Menit</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            @foreach([15, 30, 45, 60, 90] as $dur)
                                                <button 
                                                    type="button" 
                                                    wire:click="setDurasi({{ $dur }})"
                                                    class="flex-1 py-2 rounded-xl text-xs font-bold transition cursor-pointer text-center {{ $durasi_menit === $dur ? 'bg-emerald-600 text-white shadow-xs font-extrabold' : 'bg-white text-slate-700 hover:bg-slate-200 border border-slate-200/80' }}"
                                                >
                                                    {{ $dur }}'
                                                </button>
                                            @endforeach
                                        </div>
                                        @error('durasi_menit')
                                            <span class="text-xs text-rose-600 font-bold flex items-center gap-1 mt-1">
                                                <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                                                <span>{{ $message }}</span>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- STEP 2: LOKASI & TEMPAT OLAHRAGA           -->
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
                                    <h3 class="text-sm sm:text-base font-black text-slate-900">Lokasi & Titik Pelaksanaan</h3>
                                    <p class="text-xs text-slate-500">Pilih wilayah kecamatan atau gunakan deteksi GPS otomatis.</p>
                                </div>
                                <button 
                                    type="button" 
                                    @click="detectLocation()"
                                    :disabled="isLocating"
                                    class="inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-sm shadow-emerald-600/20 active:scale-98 transition cursor-pointer disabled:opacity-60"
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
                                <div class="p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-200/80 flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2.5 text-xs text-emerald-900 min-w-0">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                                        <span class="font-bold truncate">GPS Terdeteksi: <strong class="text-emerald-950 font-black">{{ $lokasi_terdeteksi_label }}</strong></span>
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
                                            <option value="">-- Pilih Desa/Kelurahan --</option>
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
                                            <option value="rumah">Halaman Rumah Sendiri</option>
                                            <option value="lainnya">Lainnya</option>
                                        </x-form.select>
                                    </x-form.field>
                                </div>
                            </div>

                            <!-- Nama Tempat Detail -->
                            <div>
                                <x-form.field label="Nama Tempat / Alamat Fasilitas" name="nama_tempat" :required="true">
                                    <x-form.input 
                                        wire:model="nama_tempat" 
                                        icon="map-pin"
                                        placeholder="Contoh: Lapangan Voli RW 04, GOR Sabilulungan Soreang, Alun-alun..." 
                                    />
                                </x-form.field>
                            </div>
                        </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- STEP 3: FOTO DOKUMENTASI & REVIEW          -->
                    <!-- ========================================== -->
                    @if($currentStep === 3)
                        <div class="space-y-6 animate-fade-in">
                            <!-- Header Substep -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div>
                                    <h3 class="text-sm sm:text-base font-black text-slate-900">Dokumentasi & Ringkasan Sesi</h3>
                                    <p class="text-xs text-slate-500">Unggah foto selfie atau suasana olahraga (opsional) sebelum menyimpan.</p>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg">Final Step</span>
                            </div>

                            <!-- Summary Card Preview -->
                            <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 space-y-2.5 text-xs">
                                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 block">Ringkasan Entri Partisipasi</span>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-slate-800">
                                    <div>
                                        <span class="text-[10px] text-slate-400 font-bold block">Aktivitas</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">{{ $nama_aktivitas ?: '-' }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 font-bold block">Tanggal & Jam</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">{{ $tanggal_aktivitas }} {{ $waktu_mulai ? '• ' . $waktu_mulai : '' }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 font-bold block">Durasi</span>
                                        <strong class="font-extrabold text-emerald-700 block">{{ $durasi_menit }} Menit</strong>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 font-bold block">Lokasi</span>
                                        <strong class="font-extrabold text-slate-900 block truncate">{{ $nama_tempat ?: '-' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Foto & Catatan -->
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                                <!-- Upload Foto Dropzone -->
                                <div class="sm:col-span-6 space-y-2">
                                    <x-form.field label="Foto Selfie / Suasana Olahraga" name="foto_kegiatan" badge="Opsional">
                                        <div class="relative">
                                            @if($foto_kegiatan)
                                                <div class="relative rounded-2xl overflow-hidden border-2 border-emerald-500/40 bg-slate-900 p-1 flex items-center justify-center h-32 group">
                                                    <img src="{{ $foto_kegiatan->temporaryUrl() }}" alt="Preview" class="h-full w-full object-cover rounded-xl">
                                                    <button 
                                                        type="button" 
                                                        wire:click="$set('foto_kegiatan', null)" 
                                                        class="absolute top-2 right-2 p-1.5 rounded-lg bg-slate-900/80 text-rose-300 hover:text-white hover:bg-rose-600 transition cursor-pointer"
                                                        title="Hapus foto"
                                                    >
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <label class="flex flex-col items-center justify-center h-32 px-4 border-2 border-dashed border-slate-200/90 rounded-2xl hover:border-emerald-500/50 hover:bg-emerald-50/20 transition-all cursor-pointer text-center group">
                                                    <div class="w-9 h-9 rounded-xl bg-slate-100 group-hover:bg-emerald-100 text-slate-500 group-hover:text-emerald-700 flex items-center justify-center transition-colors mb-1">
                                                        <i data-lucide="camera" class="w-4 h-4"></i>
                                                    </div>
                                                    <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-700">Pilih Foto Kamera / Galeri</span>
                                                    <span class="text-[10px] text-slate-400 mt-0.5">JPG, PNG maks 10MB</span>
                                                    <input 
                                                        type="file" 
                                                        wire:model="foto_kegiatan" 
                                                        accept="image/*"
                                                        class="hidden"
                                                    >
                                                </label>
                                            @endif
                                        </div>
                                        <div wire:loading wire:target="foto_kegiatan" class="text-[11px] font-semibold text-emerald-600 flex items-center gap-1.5 mt-1">
                                            <i data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i>
                                            Mengunggah berkas gambar...
                                        </div>
                                    </x-form.field>
                                </div>

                                <!-- Catatan Ringkas -->
                                <div class="sm:col-span-6">
                                    <x-form.field label="Catatan / Kesan Olahraga" name="catatan" badge="Opsional">
                                        <x-form.textarea 
                                            wire:model="catatan" 
                                            rows="4" 
                                            placeholder="Ceritakan singkat sesi olahraga Anda hari ini..."
                                            class="resize-none h-32"
                                        />
                                    </x-form.field>
                                </div>
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
                                    class="px-6 py-2.5 sm:px-8 sm:py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 active:scale-98 text-white font-black text-xs uppercase tracking-wider transition-all shadow-md shadow-emerald-600/20 flex items-center gap-2 cursor-pointer"
                                >
                                    <span>Lanjut</span>
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </button>
                            @else
                                <button 
                                    type="submit" 
                                    wire:loading.attr="disabled"
                                    class="px-6 py-2.5 sm:px-8 sm:py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 hover:brightness-105 active:scale-98 text-white font-black text-xs uppercase tracking-wider transition-all shadow-lg shadow-emerald-600/30 cursor-pointer disabled:opacity-50 flex items-center justify-center gap-2"
                                >
                                    <span wire:loading.remove wire:target="simpan" class="flex items-center gap-2">
                                        <i data-lucide="send" class="w-4 h-4"></i>
                                        <span>Simpan Aktivitas</span>
                                    </span>
                                    <span wire:loading wire:target="simpan" class="flex items-center gap-2">
                                        <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                        <span>Menyimpan...</span>
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <!-- Compact Info / FAQ Footer Strip -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
            <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="flame" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800">Streak Mingguan</h4>
                    <p class="text-[10px] text-slate-500">Target minimal 3x seminggu.</p>
                </div>
            </div>

            <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800">Tingkat Badge APMO</h4>
                    <p class="text-[10px] text-slate-500">12 sesi/bulan raih level Emas.</p>
                </div>
            </div>

            <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center shrink-0">
                    <i data-lucide="users-round" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800">Duta Olahraga</h4>
                    <p class="text-[10px] text-slate-500">Bisa dicatat via Duta Desa.</p>
                </div>
            </div>
        </div>

    </div>
</div>
