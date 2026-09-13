<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="flame" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Pesta Olahraga Akbar Kabupaten Bandung</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Festival Olahraga <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Rekreasi (FORKAB)</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Pesta akbar olahraga rekreasi tahunan Kabupaten Bandung yang mempertemukan ribuan pegiat dan atlet dari 31 kontingen kecamatan.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. TAHAPAN PELAKSANAAN & TIMELINE --}}
    <section class="py-12 bg-white border-b border-slate-100">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[10px] font-black uppercase tracking-wider mb-1.5">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>Roadmap & Timeline</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">Tahapan Pelaksanaan FORKAB</h2>
                </div>
                <div class="text-xs font-bold text-slate-400 hidden sm:flex items-center gap-1.5">
                    <i data-lucide="calendar" class="w-4 h-4 text-emerald-500"></i>
                    <span>Tahun Anggaran 2026</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3.5">
                @foreach($timeline as $t)
                    @php
                        $isDone = $t['status'] === 'done';
                        $isActive = $t['status'] === 'active';
                        $statusBadge = match($t['status']) {
                            'done' => 'bg-slate-100 text-slate-600 border-slate-200',
                            'active' => 'bg-emerald-500 text-white border-emerald-500 shadow-sm shadow-emerald-500/30',
                            default => 'bg-slate-50 text-slate-400 border-slate-200/60'
                        };
                    @endphp
                    <div class="p-5 rounded-3xl border transition-all duration-300 {{ $isActive ? 'bg-emerald-50/40 border-emerald-300 shadow-lg shadow-emerald-500/5 ring-2 ring-emerald-500/20' : 'bg-white border-slate-200/80 hover:border-slate-300' }} flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider border {{ $statusBadge }}">
                                    @if($isActive)
                                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                        <span>Sedang Berjalan</span>
                                    @elseif($isDone)
                                        <i data-lucide="check" class="w-3 h-3"></i>
                                        <span>Selesai</span>
                                    @else
                                        <span>Akan Datang</span>
                                    @endif
                                </span>
                            </div>

                            <h4 class="font-black text-slate-900 text-sm leading-snug mb-1">{{ $t['phase'] }}</h4>
                            <p class="text-[11px] text-emerald-600 font-bold mb-2">{{ $t['date'] }}</p>
                            <p class="text-[11px] text-slate-500 leading-relaxed">{{ $t['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. CABANG OLAHRAGA REKREASI (CABOR) --}}
    <section class="py-14 bg-slate-50/50">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100/70 text-emerald-800 text-[10px] font-black uppercase tracking-wider mb-2">
                        <i data-lucide="trophy" class="w-3.5 h-3.5"></i>
                        <span>Kompetisi & Eksibisi</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">Cabang Olahraga Rekreasi Dipertandingkan</h2>
                </div>
                <div class="text-xs font-bold text-slate-400 hidden sm:block">
                    Total <strong class="text-slate-700">{{ count($caborRekreasi) }}</strong> Cabang Olahraga
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
                @foreach($caborRekreasi as $cabor)
                    <div class="group bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center mb-4 shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform shrink-0">
                                <i data-lucide="{{ $cabor['icon'] ?: 'activity' }}" class="w-6 h-6"></i>
                            </div>
                            <h3 class="font-black text-slate-900 text-base leading-snug mb-1.5 group-hover:text-emerald-700 transition-colors">
                                {{ $cabor['nama'] }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                {{ $cabor['desc'] }}
                            </p>
                        </div>
                        <div class="pt-3 mt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-400">
                            <span>Resmi KORMI</span>
                            <span class="text-emerald-600 flex items-center gap-1">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Terdaftar
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. KLASEMEN PEROLEHAN MEDALI --}}
    <section class="py-14 bg-white border-t border-slate-100">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100/70 text-amber-800 text-[10px] font-black uppercase tracking-wider mb-2">
                        <i data-lucide="medal" class="w-3.5 h-3.5 text-amber-600"></i>
                        <span>Peringkat Kontingen</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">Klasemen Perolehan Medali FORKAB</h2>
                </div>
                <div class="text-[11px] font-bold text-slate-400 hidden sm:flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Live Perolehan Medali</span>
                </div>
            </div>

            {{-- Table Medali Container --}}
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-[10px] font-black uppercase text-slate-400 tracking-wider">
                                <th class="py-4 px-6 text-center w-20">Peringkat</th>
                                <th class="py-4 px-6">Kontingen Kecamatan</th>
                                <th class="py-4 px-6 text-center text-amber-600">
                                    <span class="inline-flex items-center gap-1"><i data-lucide="medal" class="w-3.5 h-3.5"></i> Emas</span>
                                </th>
                                <th class="py-4 px-6 text-center text-slate-500">
                                    <span class="inline-flex items-center gap-1"><i data-lucide="medal" class="w-3.5 h-3.5"></i> Perak</span>
                                </th>
                                <th class="py-4 px-6 text-center text-amber-800">
                                    <span class="inline-flex items-center gap-1"><i data-lucide="medal" class="w-3.5 h-3.5"></i> Perunggu</span>
                                </th>
                                <th class="py-4 px-6 text-center font-black text-slate-800">Total Medali</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @foreach($klasemen as $k)
                                @php
                                    $isTop3 = $k['peringkat'] <= 3;
                                    $podiumBg = match($k['peringkat']) {
                                        1 => 'bg-amber-400 text-slate-950 font-black',
                                        2 => 'bg-slate-300 text-slate-950 font-black',
                                        3 => 'bg-amber-700 text-white font-black',
                                        default => 'bg-slate-100 text-slate-600 font-bold'
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors {{ $isTop3 ? 'bg-amber-50/15' : '' }}">
                                    {{-- Rank --}}
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-xl text-xs {{ $podiumBg }}">
                                            {{ $k['peringkat'] }}
                                        </span>
                                    </td>

                                    {{-- Kecamatan --}}
                                    <td class="py-4 px-6">
                                        <div class="font-black text-slate-900 text-sm">
                                            Kecamatan {{ $k['kecamatan'] }}
                                        </div>
                                    </td>

                                    {{-- Emas --}}
                                    <td class="py-4 px-6 text-center font-black text-slate-900 text-sm">
                                        <span class="inline-block px-2.5 py-1 rounded-lg bg-amber-50 text-amber-800 border border-amber-200/80 min-w-[32px]">
                                            {{ $k['emas'] }}
                                        </span>
                                    </td>

                                    {{-- Perak --}}
                                    <td class="py-4 px-6 text-center font-black text-slate-800 text-sm">
                                        <span class="inline-block px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 min-w-[32px]">
                                            {{ $k['perak'] }}
                                        </span>
                                    </td>

                                    {{-- Perunggu --}}
                                    <td class="py-4 px-6 text-center font-black text-slate-800 text-sm">
                                        <span class="inline-block px-2.5 py-1 rounded-lg bg-amber-50/80 text-amber-900 border border-amber-200/60 min-w-[32px]">
                                            {{ $k['perunggu'] }}
                                        </span>
                                    </td>

                                    {{-- Total --}}
                                    <td class="py-4 px-6 text-center font-black text-slate-900 text-base">
                                        {{ $k['emas'] + $k['perak'] + $k['perunggu'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

