<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-amber-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-emerald-500/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-500/15 text-amber-400 text-[10px] font-black tracking-[0.2em] uppercase border border-amber-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-400"></i>
                <span>Pelestarian Budaya & Kaulinan Urang Lembur</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Festival Olahraga <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-emerald-400 to-teal-300">Tradisional (FOTRADKAB)</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Menghidupkan kembali kearifan lokal, kegembiraan permainan rakyat, dan nilai luhur kaulinan tradisional masyarakat Tatar Pasundan Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. 3 NILAI FILOSOFI BUDAYA HIGHLIGHTS --}}
    <section class="py-6 bg-white border-b border-slate-100">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                        <i data-lucide="heart-handshake" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-800 uppercase">Silih Asih & Asuh</h4>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Memupuk kebersamaan dan kekeluargaan antar warga</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                        <i data-lucide="shield" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-800 uppercase">Sportivitas Luhur</h4>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Menjunjung kejujuran dan kegembiraan berolahraga</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 shrink-0">
                        <i data-lucide="smile" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-800 uppercase">Kaulinan Sunda</h4>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Warisan budaya tak benda yang lestari dan edukatif</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. CABANG OLAHRAGA TRADISIONAL (CABOR) --}}
    <section class="py-14 bg-slate-50/50">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100/70 text-amber-800 text-[10px] font-black uppercase tracking-wider mb-2">
                        <i data-lucide="gamepad-2" class="w-3.5 h-3.5"></i>
                        <span>8 Cabang Perlombaan</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">Cabang Olahraga Tradisional</h2>
                </div>
                <div class="text-xs font-bold text-slate-400 hidden sm:block">
                    Total <strong class="text-slate-700">{{ count($caborTradisional) }}</strong> Kaulinan Urang Lembur
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
                @foreach($caborTradisional as $cabor)
                    <div class="group bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm hover:shadow-xl hover:border-amber-300 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 text-white flex items-center justify-center mb-4 shadow-md shadow-amber-500/20 group-hover:scale-105 transition-transform shrink-0">
                                <i data-lucide="{{ $cabor['icon'] ?: 'footprints' }}" class="w-6 h-6"></i>
                            </div>
                            <h3 class="font-black text-slate-900 text-base leading-snug mb-1.5 group-hover:text-amber-700 transition-colors">
                                {{ $cabor['nama'] }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                {{ $cabor['desc'] }}
                            </p>
                        </div>
                        <div class="pt-3 mt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-400">
                            <span class="inline-flex items-center gap-1 text-slate-500">
                                <i data-lucide="users" class="w-3.5 h-3.5 text-amber-500"></i>
                                {{ $cabor['peserta'] ?? 'Kategori Umum' }}
                            </span>
                            <span class="text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200/60 text-[10px] font-black">
                                Tradisional
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. KLASEMEN PEROLEHAN MEDALI FOTRADKAB --}}
    <section class="py-14 bg-white border-t border-slate-100">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100/70 text-emerald-800 text-[10px] font-black uppercase tracking-wider mb-2">
                        <i data-lucide="medal" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>Peringkat Kontingen Kecamatan</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">Klasemen Perolehan Medali FOTRADKAB</h2>
                </div>
                <div class="text-[11px] font-bold text-slate-400 hidden sm:flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>Update Perolehan Medali</span>
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

