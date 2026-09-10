<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-cyan-500/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-cyan-500/20 border border-cyan-500/30 rounded-full text-cyan-400 text-xs font-bold uppercase tracking-widest mb-4">Pengembangan Kapasitas</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Sumber Daya <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Insani (SDI)</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Program pelatihan, peningkatan kompetensi, dan sertifikasi pelatih serta wasit olahraga masyarakat.</p>
        </div>
    </section>

    <!-- PROGRAM DIKLAT -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1 bg-green-50 text-bedasGreen text-xs font-black uppercase tracking-widest rounded-full mb-3">Kurikulum Pelatihan</span>
                <h3 class="text-2xl sm:text-4xl font-black uppercase text-slate-900">Program Diklat Keolahragaan</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-20">
                @foreach($programList as $prog)
                    <div class="p-8 bg-slate-50 border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-emerald-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-md">
                                <i data-lucide="award" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-black text-slate-800 text-xl leading-tight mb-2 group-hover:text-bedasGreen transition-colors">{{ $prog->judul_program }}</h4>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6">{{ $prog->standar_kompetensi ?? 'Standar Sertifikasi Nasional KORMI' }}</p>
                        </div>
                        <div class="pt-4 border-t border-slate-200/60 flex justify-between items-center text-xs text-slate-400 font-bold">
                            <span>Sertifikasi: {{ $prog->jenis_sertifikasi ?? 'Resmi KORMI' }}</span>
                            <span>Sasaran: {{ $prog->sasaran_peserta }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- JADWAL PELATIHAN -->
            <div class="bg-white border border-slate-100 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black uppercase text-slate-800">Jadwal Gelombang Pelatihan</h3>
                        <p class="text-xs text-slate-400 font-medium">Informasi angkatan dan status kuota pendaftaran</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                                <th class="p-5">Waktu</th>
                                <th class="p-5">Program Pelatihan</th>
                                <th class="p-5">Lokasi</th>
                                <th class="p-5">Kuota</th>
                                <th class="p-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwalList as $j)
                                <tr class="border-b border-slate-50 hover:bg-slate-50/60 transition-colors">
                                    <td class="p-5 text-xs font-bold text-slate-500">
                                        {{ \Carbon\Carbon::parse($j->tanggal_mulai)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="p-5 font-bold text-slate-800 text-sm">
                                        {{ $j->program->judul_program ?? $j->nama_angkatan }}
                                    </td>
                                    <td class="p-5 text-xs text-slate-600 font-medium">{{ $j->lokasi_pelatihan }}</td>
                                    <td class="p-5 text-xs text-slate-500">{{ $j->jumlah_pendaftar }} / {{ $j->kuota_peserta }} Peserta</td>
                                    <td class="p-5 text-right">
                                        <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $j->status_pendaftaran === 'dibuka' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                            {{ ucfirst($j->status_pendaftaran) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-400">Belum ada jadwal pelatihan aktif saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
