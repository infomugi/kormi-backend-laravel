<div class="space-y-6">

    <!-- FLASH NOTIFICATION -->
    @if(session()->has('pesan'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xs animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
                <span>{{ session('pesan') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1.5 rounded-lg transition-colors cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                <span>KONFIGURASI</span>
                <span>•</span>
                <span class="text-emerald-600">PENGATURAN SITUS</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Pengaturan Situs</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola informasi umum, kontak, media sosial, dan branding situs KORMI Kabupaten Bandung.</p>
        </div>
    </div>

    <form wire:submit="simpan" class="space-y-6">

        <!-- INFORMASI UMUM -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200/80">
                <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="globe" class="w-4 h-4 text-emerald-600"></i>
                    Informasi Umum
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Situs <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="nama_situs" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors" placeholder="KORMI Kabupaten Bandung">
                    @error('nama_situs') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Deskripsi Situs</label>
                    <textarea wire:model="deskripsi_situs" rows="3" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors resize-none" placeholder="Deskripsi singkat tentang KORMI..."></textarea>
                    @error('deskripsi_situs') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Alamat Kantor</label>
                    <textarea wire:model="alamat_kantor" rows="2" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors resize-none" placeholder="Jl. ..."></textarea>
                    @error('alamat_kantor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- KONTAK -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200/80">
                <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="phone" class="w-4 h-4 text-blue-600"></i>
                    Informasi Kontak
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Email Kontak</label>
                    <input type="email" wire:model="email_kontak" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors" placeholder="sekretariat@kormibdg.id">
                    @error('email_kontak') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nomor Telepon</label>
                    <input type="text" wire:model="nomor_telepon" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors" placeholder="022-xxxxxxx">
                    @error('nomor_telepon') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- MEDIA SOSIAL -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200/80">
                <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="share-2" class="w-4 h-4 text-purple-600"></i>
                    Media Sosial
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Instagram</label>
                    <input type="text" wire:model="instagram" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors" placeholder="https://instagram.com/kormibandung">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Facebook</label>
                    <input type="text" wire:model="facebook" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors" placeholder="https://facebook.com/...">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">YouTube</label>
                    <input type="text" wire:model="youtube" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors" placeholder="https://youtube.com/@...">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">TikTok</label>
                    <input type="text" wire:model="tiktok" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors" placeholder="https://tiktok.com/@...">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Website KORMI Pusat</label>
                    <input type="text" wire:model="website_kormi_pusat" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors" placeholder="https://kormi.or.id">
                </div>
            </div>
        </div>

        <!-- LOGO -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200/80">
                <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="image" class="w-4 h-4 text-amber-600"></i>
                    Logo & Branding
                </h2>
            </div>
            <div class="p-6">
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Upload Logo</label>
                <input type="file" wire:model="uploadLogo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                @error('uploadLogo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror

                @if($uploadLogo)
                    <div class="mt-3">
                        <img src="{{ $uploadLogo->temporaryUrl() }}" class="h-20 rounded-xl border border-slate-200" alt="Preview Logo">
                    </div>
                @endif
            </div>
        </div>

        <!-- SUBMIT -->
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer active:scale-95">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Simpan Pengaturan</span>
            </button>
        </div>

    </form>

</div>
