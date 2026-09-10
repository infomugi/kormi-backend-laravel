<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-bedasGreen/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-bedasGreen/20 border border-bedasGreen/30 rounded-full text-bedasGreen text-xs font-bold uppercase tracking-widest mb-4">Festival Budaya</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Festival Olahraga Tradisional <span class="text-transparent bg-clip-text bg-gradient-to-r from-bedasGreen to-bedasLime">(FOTRADKAB)</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Melestarikan nilai luhur budaya dan permainan tradisional masyarakat Sunda di Kabupaten Bandung.</p>
        </div>
    </section>

    <!-- CABOR TRADISIONAL -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1 bg-green-50 text-bedasGreen text-xs font-black uppercase tracking-widest rounded-full mb-3">8 Cabang Lomba</span>
                <h3 class="text-2xl sm:text-4xl font-black uppercase text-slate-900">Cabang Olahraga Tradisional</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-20">
                @foreach($caborTradisional as $cabor)
                    <div class="p-6 bg-slate-50 border border-slate-100 rounded-3xl hover:shadow-lg transition-all group flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 {{ $cabor['color'] }} text-white rounded-2xl flex items-center justify-center mb-4 shadow-md">
                                <i data-lucide="{{ $cabor['icon'] }}" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-black text-slate-800 text-lg mb-2 group-hover:text-bedasGreen transition-colors">{{ $cabor['nama'] }}</h4>
                            <p class="text-slate-500 text-xs leading-relaxed mb-4">{{ $cabor['desc'] }}</p>
                        </div>
                        <span class="inline-block px-3 py-1 bg-white border border-slate-100 rounded-full text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                            {{ $cabor['peserta'] }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- KLASEMEN MEDALI -->
            <div class="bg-white border border-slate-100 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black uppercase text-slate-800">Klasemen Perolehan Medali</h3>
                        <p class="text-xs text-slate-400 font-medium">Peringkat kontingen kecamatan FOTRADKAB</p>
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
