<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-bedasGreen/20 border border-bedasGreen/30 rounded-full text-bedasGreen text-xs font-bold uppercase tracking-widest mb-4">Pesta Olahraga Terbesar</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Festival Olahraga Rekreasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedasGreen to-bedasLime">(FORKAB)</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Ajang pesta olahraga rekreasi akbar tingkat Kabupaten Bandung mempertemukan ribuan pegiat olahraga dari 31 kecamatan.</p>
        </div>
    </section>

    <!-- TIMELINE -->
    <section class="py-16 bg-white border-b border-slate-100">
        <div class="container mx-auto px-6 max-w-5xl">
            <h3 class="text-xl font-black uppercase text-slate-800 text-center mb-10">Tahapan Pelaksanaan FORKAB</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                @foreach($timeline as $t)
                    <div class="p-5 rounded-2xl border {{ $t['status'] === 'active' ? 'bg-green-50/50 border-bedasGreen shadow-sm' : 'bg-slate-50 border-slate-100' }} text-left">
                        <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider {{ $t['status'] === 'done' ? 'bg-slate-200 text-slate-600' : ($t['status'] === 'active' ? 'bg-bedasGreen text-white' : 'bg-slate-200 text-slate-400') }} mb-2">
                            {{ $t['status'] }}
                        </span>
                        <h4 class="font-bold text-slate-800 text-sm mb-1 leading-tight">{{ $t['phase'] }}</h4>
                        <p class="text-[11px] text-bedasGreen font-semibold mb-2">{{ $t['date'] }}</p>
                        <p class="text-[11px] text-slate-500 leading-relaxed">{{ $t['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CABOR REKREASI & KLASEMEN -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1 bg-green-50 text-bedasGreen text-xs font-black uppercase tracking-widest rounded-full mb-3">Cabang Kejuaraan</span>
                <h3 class="text-2xl sm:text-4xl font-black uppercase text-slate-900">Cabang Olahraga Rekreasi</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-20">
                @foreach($caborRekreasi as $cabor)
                    <div class="p-6 bg-white border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 {{ $cabor['color'] }} text-white rounded-2xl flex items-center justify-center mb-4 shadow-md">
                                <i data-lucide="{{ $cabor['icon'] }}" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-black text-slate-800 text-lg mb-2 group-hover:text-bedasGreen transition-colors">{{ $cabor['nama'] }}</h4>
                            <p class="text-slate-500 text-xs leading-relaxed">{{ $cabor['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- KLASEMEN MEDALI -->
            <div class="bg-white border border-slate-100 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black uppercase text-slate-800">Klasemen Perolehan Medali FORKAB</h3>
                        <p class="text-xs text-slate-400 font-medium">Perolehan medali kontingen 31 kecamatan</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                                <th class="p-5 text-center w-16">Peringkat</th>
                                <th class="p-5">Kecamatan</th>
                                <th class="p-5 text-center text-amber-500">Emas</th>
                                <th class="p-5 text-center text-slate-400">Perak</th>
                                <th class="p-5 text-center text-amber-700">Perunggu</th>
                                <th class="p-5 text-center font-black">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($klasemen as $k)
                                <tr class="border-b border-slate-50 hover:bg-slate-50/60 transition-colors">
                                    <td class="p-5 text-center font-black {{ $k['peringkat'] <= 3 ? 'text-bedasGreen' : 'text-slate-400' }}">{{ $k['peringkat'] }}</td>
                                    <td class="p-5 font-bold text-slate-800">Kecamatan {{ $k['kecamatan'] }}</td>
                                    <td class="p-5 text-center font-bold text-slate-700">{{ $k['emas'] }}</td>
                                    <td class="p-5 text-center font-bold text-slate-700">{{ $k['perak'] }}</td>
                                    <td class="p-5 text-center font-bold text-slate-700">{{ $k['perunggu'] }}</td>
                                    <td class="p-5 text-center font-black text-slate-900">{{ $k['emas'] + $k['perak'] + $k['perunggu'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
