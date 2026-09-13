<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="graduation-cap" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Pengembangan Kapasitas & Sertifikasi</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Sumber Daya <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Insani (SDI)</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Pusat standardisasi, pelatihan pelatih, bimbingan teknis juri/wasit, dan peningkatan mutu instruktur olahraga rekreasi di Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. 3 PILAR KOMPETENSI HIGHLIGHTS --}}
    <section class="py-6 bg-white border-b border-slate-100">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                        <i data-lucide="award" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-800 uppercase">Sertifikasi Resmi</h4>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Lisensi terakreditasi KORMI Nasional & Daerah</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-lime-50 border border-lime-100 flex items-center justify-center text-lime-600 shrink-0">
                        <i data-lucide="book-open" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-800 uppercase">Kurikulum Standar</h4>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Modul kepelatihan terstruktur & berbasis praktik</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 shrink-0">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-800 uppercase">Instruktur Andal</h4>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Mencetak SDM pegiat olahraga yang berdedikasi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. PROGRAM DIKLAT KURIKULUM --}}
    <section class="py-14 bg-slate-50/50">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100/70 text-emerald-800 text-[10px] font-black uppercase tracking-wider mb-2">
                        <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                        <span>Program Utama</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">Kurikulum Pelatihan & Bimtek</h2>
                </div>
                <div class="text-xs font-bold text-slate-400 hidden sm:block">
                    Total <strong class="text-slate-700">{{ $programList->count() }}</strong> Program Tersedia
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($programList as $prog)
                    <div class="group bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            {{-- Header Card --}}
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform shrink-0">
                                    <i data-lucide="award" class="w-6 h-6"></i>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200/80">
                                    {{ $prog->jenis_sertifikasi ?? 'Sertifikasi KORMI' }}
                                </span>
                            </div>

                            {{-- Title & Competency --}}
                            <h3 class="text-base sm:text-lg font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition-colors mb-2">
                                {{ $prog->judul_program }}
                            </h3>
                            
                            <p class="text-xs text-slate-600 leading-relaxed mb-4">
                                {{ $prog->standar_kompetensi ?? 'Standar Sertifikasi Nasional KORMI Kabupaten Bandung' }}
                            </p>
                        </div>

                        {{-- Meta Footer --}}
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2 text-xs">
                            <div class="flex items-center gap-1.5 text-slate-500">
                                <i data-lucide="user-check" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                                <span class="text-[11px] font-medium">Sasaran: <strong class="text-slate-800">{{ $prog->sasaran_peserta }}</strong></span>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                {{ $prog->jadwal_count }} Angkatan
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl border border-slate-200/80 p-8 text-center text-slate-400 text-xs">
                        Belum ada data kurikulum program yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 4. JADWAL GELOMBANG PELATIHAN SECTION --}}
    <section class="py-14 bg-white border-t border-slate-100">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-lime-100/70 text-lime-800 text-[10px] font-black uppercase tracking-wider mb-2">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        <span>Agenda Terbuka</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">Jadwal Gelombang & Kuota</h2>
                </div>

                {{-- Status Filter Tabs --}}
                <div class="flex items-center gap-2">
                    <button 
                        wire:click="filterStatus('Semua')"
                        class="px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider transition-all {{ $statusFilter === 'Semua' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        Semua
                    </button>
                    <button 
                        wire:click="filterStatus('dibuka')"
                        class="px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider transition-all {{ $statusFilter === 'dibuka' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        Pendaftaran Dibuka
                    </button>
                    <button 
                        wire:click="filterStatus('penuh')"
                        class="px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider transition-all {{ $statusFilter === 'penuh' ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        Kuota Penuh
                    </button>
                </div>
            </div>

            {{-- Schedule Table Container --}}
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-[10px] font-black uppercase text-slate-400 tracking-wider">
                                <th class="py-4 px-6">Pelaksanaan</th>
                                <th class="py-4 px-6">Program & Angkatan</th>
                                <th class="py-4 px-6">Lokasi Pelatihan</th>
                                <th class="py-4 px-6">Kapasitas Kuota</th>
                                <th class="py-4 px-6 text-right">Status Pendaftaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($jadwalList as $j)
                                @php
                                    $isFull = $j->status_pendaftaran === 'penuh' || $j->jumlah_pendaftar >= $j->kuota_peserta;
                                    $percent = $j->kuota_peserta > 0 ? min(100, round(($j->jumlah_pendaftar / $j->kuota_peserta) * 100)) : 0;
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    {{-- Tanggal --}}
                                    <td class="py-5 px-6 whitespace-nowrap">
                                        <div class="font-bold text-slate-800">
                                            {{ \Carbon\Carbon::parse($j->tanggal_mulai)->translatedFormat('d M Y') }}
                                        </div>
                                        @if($j->tanggal_selesai && $j->tanggal_selesai !== $j->tanggal_mulai)
                                            <span class="text-[10px] text-slate-400 block mt-0.5">
                                                s/d {{ \Carbon\Carbon::parse($j->tanggal_selesai)->translatedFormat('d M Y') }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Program --}}
                                    <td class="py-5 px-6">
                                        <div class="font-black text-slate-900 text-sm">
                                            {{ $j->program->judul_program ?? 'Program SDI' }}
                                        </div>
                                        <div class="text-[11px] font-bold text-emerald-600 mt-0.5">
                                            {{ $j->nama_angkatan }}
                                        </div>
                                    </td>

                                    {{-- Lokasi --}}
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-1.5 text-slate-600 font-medium">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                                            <span>{{ $j->lokasi_pelatihan }}</span>
                                        </div>
                                    </td>

                                    {{-- Kuota Progress --}}
                                    <td class="py-5 px-6 min-w-[180px]">
                                        <div class="flex items-center justify-between text-[11px] font-bold mb-1.5">
                                            <span class="text-slate-700">{{ $j->jumlah_pendaftar }} / {{ $j->kuota_peserta }} Peserta</span>
                                            <span class="text-slate-400">{{ $percent }}%</span>
                                        </div>
                                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                            <div class="h-full rounded-full {{ $isFull ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </td>

                                    {{-- Status Badge --}}
                                    <td class="py-5 px-6 text-right whitespace-nowrap">
                                        @if($isFull)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                <span>Penuh</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                <span>Dibuka</span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 px-6 text-center text-slate-400">
                                        <div class="max-w-xs mx-auto text-center">
                                            <i data-lucide="calendar-x" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                            <p class="font-bold text-slate-600 text-xs">Tidak ada jadwal pelatihan untuk filter ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Info Notice Callout --}}
            <div class="mt-8 p-5 bg-slate-50 border border-slate-200/80 rounded-2xl flex items-start gap-3.5">
                <i data-lucide="info" class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5"></i>
                <div class="text-xs text-slate-600 leading-relaxed">
                    <strong class="text-slate-800 font-bold block mb-0.5">Informasi & Pendaftaran SDI:</strong>
                    Pendaftaran pelatihan, sertifikasi wasit, dan instruktur dikoordinasikan langsung melalui sekretariat KORMI Kabupaten Bandung atau perwakilan pengurus induk organisasi olahraga (INORGA) terkait.
                </div>
            </div>
        </div>
    </section>
</div>

