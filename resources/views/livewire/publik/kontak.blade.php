<div>
    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center justify-center pt-32 pb-16 overflow-hidden bg-slate-950 -mt-24">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/image/hero-bg.jpg') }}" class="w-full h-full object-cover opacity-20" alt="Hero" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-emerald-500/20 border border-emerald-500/30 rounded-full text-emerald-400 text-xs font-bold uppercase tracking-widest mb-4">Layanan Aspirasi & Informasi</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight mb-4">Hubungi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-lime-400">Kami</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base font-medium">Sampaikan saran, aspirasi, kerjasama, atau informasi kegiatan olahraga rekreasi kepada Sekretariat KORMI Kabupaten Bandung.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Info Kontak Kiri -->
                <div class="lg:col-span-5 space-y-8">
                    <div>
                        <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">Informasi Sekretariat</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">Siap Melayani Pegiat Olahraga</h2>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">Pintu sekretariat kami terbuka bagi Inorga, komunitas pegiat olahraga masyarakat, dan seluruh warga Kabupaten Bandung.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="p-5 bg-slate-50 rounded-3xl border border-slate-100 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-xs uppercase tracking-wider">Alamat Kantor</h4>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $alamat }}</p>
                            </div>
                        </div>

                        <div class="p-5 bg-slate-50 rounded-3xl border border-slate-100 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-xs uppercase tracking-wider">Telepon & WhatsApp</h4>
                                <p class="text-xs text-slate-600 mt-1 font-bold">{{ $telepon }}</p>
                            </div>
                        </div>

                        <div class="p-5 bg-slate-50 rounded-3xl border border-slate-100 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-xs uppercase tracking-wider">Email Resmi</h4>
                                <p class="text-xs text-slate-600 mt-1 font-bold">{{ $email }}</p>
                            </div>
                        </div>

                        <div class="p-5 bg-slate-50 rounded-3xl border border-slate-100 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-xs uppercase tracking-wider">Jam Pelayanan</h4>
                                <p class="text-xs text-slate-600 mt-1">{{ $jamKerja }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Kontak Kanan -->
                <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200/80 shadow-xl p-8 sm:p-10">
                    <h3 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2">
                        <i data-lucide="send" class="w-5 h-5 text-emerald-600"></i>
                        <span>Kirim Pesan & Aspirasi</span>
                    </h3>

                    @if(session()->has('pesan_sukses'))
                        <div class="p-5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl mb-6 flex items-start gap-3 shadow-xs">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5"></i>
                            <p class="text-xs font-bold leading-relaxed">{{ session('pesan_sukses') }}</p>
                        </div>
                    @endif

                    <form wire:submit="kirimPesan" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Nama Lengkap *</label>
                                <input type="text" wire:model="nama" placeholder="Nama Anda" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                                @error('nama') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Alamat Email *</label>
                                <input type="email" wire:model="email" placeholder="email@domain.com" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                                @error('email') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Nomor Telepon / WhatsApp</label>
                                <input type="text" wire:model="telepon" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Subjek Keperluan *</label>
                                <input type="text" wire:model="subjek" placeholder="Contoh: Pendaftaran Inorga Baru" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white">
                                @error('subjek') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Isi Pesan / Keterangan *</label>
                            <textarea wire:model="pesan" rows="5" placeholder="Tuliskan pesan, pertanyaan, atau usulan kegiatan Anda secara lengkap..." class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white"></textarea>
                            @error('pesan') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all cursor-pointer shadow-lg shadow-emerald-600/20">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                <span>Kirim Pesan Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>
