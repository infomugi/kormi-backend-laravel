<div>
    {{-- 1. HERO HEADER SECTION --}}
    <section class="relative min-h-[44vh] flex items-center justify-center pt-28 pb-14 overflow-hidden bg-slate-950 -mt-24">
        <!-- Ambient background & mesh glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?q=80&w=2000" class="w-full h-full object-cover opacity-20 scale-105" alt="Hero Background" />
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/90 to-slate-950"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/15 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[300px] h-[300px] bg-lime-400/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-black tracking-[0.2em] uppercase border border-emerald-500/30 mb-4 backdrop-blur-md">
                <i data-lucide="message-square" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Layanan Aspirasi & Informasi</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight text-white uppercase">
                Hubungi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-400">Kami</span>
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed opacity-85 mt-2">
                Sampaikan pertanyaan, usulan program, kemitraan, atau aspirasi olahraga rekreasi kepada Sekretariat KORMI Kabupaten Bandung.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-slate-900 to-transparent pointer-events-none"></div>
    </section>

    {{-- 2. MAIN CONTENT SECTION --}}
    <section class="py-14 bg-slate-50/50 min-h-[50vh]">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                {{-- LEFT COLUMN: CONTACT INFO & SOCIAL CARDS --}}
                <div class="lg:col-span-5 space-y-6">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-emerald-800 block mb-1">Sekretariat Resmi</span>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">Siap Melayani Pegiat Olahraga</h2>
                        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed font-medium">
                            Pintu sekretariat kami terbuka bagi seluruh pengurus INORGA, koordinator kecamatan, duta olahraga desa, dan masyarakat Kabupaten Bandung.
                        </p>
                    </div>

                    {{-- Info Cards --}}
                    <div class="space-y-3.5">
                        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm hover:border-emerald-300 transition-all flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100">
                                <i data-lucide="map-pin" class="w-5 h-5 text-emerald-600"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">Alamat Kantor</span>
                                <p class="text-xs sm:text-sm font-bold text-slate-800 leading-relaxed">{{ $alamat }}</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm hover:border-emerald-300 transition-all flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0 border border-teal-100">
                                <i data-lucide="phone-call" class="w-5 h-5 text-teal-600"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">Telepon / WhatsApp</span>
                                <p class="text-xs sm:text-sm font-bold text-slate-800 leading-relaxed">{{ $telepon }}</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm hover:border-emerald-300 transition-all flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0 border border-blue-100">
                                <i data-lucide="mail" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">Email Resmi</span>
                                <p class="text-xs sm:text-sm font-bold text-slate-800 leading-relaxed">{{ $email }}</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm hover:border-emerald-300 transition-all flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 border border-amber-100">
                                <i data-lucide="clock" class="w-5 h-5 text-amber-600"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">Jam Pelayanan</span>
                                <p class="text-xs sm:text-sm font-bold text-slate-800 leading-relaxed">{{ $jamKerja }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <div class="bg-gradient-to-br from-slate-900 to-slate-950 rounded-3xl p-6 text-white border border-slate-800 shadow-md">
                        <span class="text-[10px] font-black uppercase tracking-widest text-emerald-400 block mb-1">Kanal Resmi</span>
                        <h3 class="text-base font-black text-white uppercase mb-4">Media Sosial KORMI</h3>
                        <div class="flex items-center gap-2.5 flex-wrap">
                            @if(!empty($instagram))
                                <a href="{{ $instagram }}" target="_blank" rel="noopener" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-emerald-600 text-xs font-bold transition-all inline-flex items-center gap-2 border border-white/10">
                                    <i data-lucide="instagram" class="w-4 h-4 text-emerald-400"></i>
                                    <span>Instagram</span>
                                </a>
                            @endif
                            @if(!empty($youtube))
                                <a href="{{ $youtube }}" target="_blank" rel="noopener" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-red-600 text-xs font-bold transition-all inline-flex items-center gap-2 border border-white/10">
                                    <i data-lucide="youtube" class="w-4 h-4 text-red-400"></i>
                                    <span>YouTube</span>
                                </a>
                            @endif
                            @if(!empty($facebook))
                                <a href="{{ $facebook }}" target="_blank" rel="noopener" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-blue-600 text-xs font-bold transition-all inline-flex items-center gap-2 border border-white/10">
                                    <i data-lucide="facebook" class="w-4 h-4 text-blue-400"></i>
                                    <span>Facebook</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: CONTACT & ASPIRASI FORM --}}
                <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200/90 shadow-xl shadow-slate-100/50 p-6 sm:p-10">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-black">
                                <i data-lucide="send" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-black text-slate-900 uppercase">Formulir Aspirasi</h3>
                                <span class="text-[11px] font-semibold text-slate-400">Kirim pesan langsung ke Sekretariat KORMI</span>
                            </div>
                        </div>
                    </div>

                    @if(session()->has('pesan_sukses'))
                        <div class="p-5 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl mb-6 flex items-start gap-3 shadow-xs">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5"></i>
                            <div>
                                <span class="font-black text-xs block mb-0.5">Pesan Berhasil Terkirim!</span>
                                <p class="text-xs font-medium leading-relaxed text-emerald-800">{{ session('pesan_sukses') }}</p>
                            </div>
                        </div>
                    @endif

                    <form wire:submit="kirimPesan" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input 
                                    type="text" 
                                    wire:model="nama" 
                                    placeholder="Nama Lengkap Anda" 
                                    class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200/90 rounded-2xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-xs"
                                />
                                @error('nama') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700">Alamat Email <span class="text-rose-500">*</span></label>
                                <input 
                                    type="email" 
                                    wire:model="email" 
                                    placeholder="nama@email.com" 
                                    class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200/90 rounded-2xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-xs"
                                />
                                @error('email') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700">Nomor WhatsApp / Telepon</label>
                                <input 
                                    type="text" 
                                    wire:model="telepon" 
                                    placeholder="08xxxxxxxxxx" 
                                    class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200/90 rounded-2xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-xs"
                                />
                                @error('telepon') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700">Subjek Keperluan <span class="text-rose-500">*</span></label>
                                <input 
                                    type="text" 
                                    wire:model="subjek" 
                                    placeholder="Contoh: Konsultasi Pembentukan INORGA" 
                                    class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200/90 rounded-2xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-xs"
                                />
                                @error('subjek') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Isi Pesan / Aspirasi <span class="text-rose-500">*</span></label>
                            <textarea 
                                wire:model="pesan" 
                                rows="5" 
                                placeholder="Tuliskan secara lengkap pesan, pertanyaan, saran, atau usulan kegiatan olahraga yang ingin Anda sampaikan..." 
                                class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200/90 rounded-2xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-xs leading-relaxed"
                            ></textarea>
                            @error('pesan') <p class="text-[10px] font-bold text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-2">
                            <button 
                                type="submit" 
                                class="w-full sm:w-auto px-8 py-3.5 bg-slate-900 hover:bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition-all cursor-pointer shadow-lg shadow-slate-950/20 hover:shadow-emerald-600/30"
                            >
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
