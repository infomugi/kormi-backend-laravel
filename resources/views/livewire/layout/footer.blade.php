<footer id="footer" class="bg-darkBlue text-white pt-24 pb-12 relative overflow-hidden text-left">
    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-green-600 via-emerald-400 to-blue-600"></div>
    
    <div class="container mx-auto px-12 grid md:grid-cols-2 lg:grid-cols-4 gap-16 mb-20">
        <div class="space-y-8">
            <a href="{{ route('beranda') }}" wire:navigate.hover class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-darkBlue font-black text-2xl shadow-xl transition-transform hover:rotate-6">K</div>
                <h2 class="text-2xl font-black tracking-tighter leading-[0.8]">KORMI <br/><span class="text-slate-500 text-[10px] tracking-[0.5em] uppercase font-bold">Bandung</span></h2>
            </a>
            <p class="text-slate-400 font-medium leading-relaxed opacity-70 text-sm">{{ $deskripsiSitus }}</p>
        </div>
        <div class="space-y-8">
            <h5 class="font-black text-[11px] uppercase tracking-[0.4em] text-green-500 border-l-4 border-green-500 pl-4">Layanan Cepat</h5>
            <ul class="space-y-4 text-slate-400 font-bold text-[11px] uppercase tracking-widest">
                <li><a href="{{ route('visimisi') }}" wire:navigate.hover class="hover:text-green-500 transition-colors flex items-center gap-3"><i data-lucide="chevron-right" class="w-4 h-4"></i> Visi & Misi</a></li>
                <li><a href="{{ route('pengurus') }}" wire:navigate.hover class="hover:text-green-500 transition-colors flex items-center gap-3"><i data-lucide="chevron-right" class="w-4 h-4"></i> Struktur Pengurus</a></li>
                <li><a href="{{ route('inorga') }}" wire:navigate.hover class="hover:text-green-500 transition-colors flex items-center gap-3"><i data-lucide="chevron-right" class="w-4 h-4"></i> Daftar Inorga</a></li>
                <li><a href="{{ route('unduhan') }}" wire:navigate.hover class="hover:text-green-500 transition-colors flex items-center gap-3"><i data-lucide="chevron-right" class="w-4 h-4"></i> Pusat Unduhan</a></li>
            </ul>
        </div>
        <div class="space-y-8">
            <h5 class="font-black text-[11px] uppercase tracking-[0.4em] text-green-500 border-l-4 border-green-500 pl-4">Alamat Kantor</h5>
            <div class="space-y-6 text-slate-400 font-medium text-[12px] leading-relaxed">
                <p class="flex gap-4"><i data-lucide="map-pin" class="w-5 h-5 text-green-500 shrink-0"></i> {{ $alamatKantor }}</p>
                <p class="flex gap-4"><i data-lucide="phone" class="w-5 h-5 text-green-500 shrink-0"></i> {{ $teleponKantor }}</p>
                <p class="flex gap-4"><i data-lucide="mail" class="w-5 h-5 text-green-500 shrink-0"></i> {{ $emailKantor }}</p>
            </div>
        </div>
        <div class="space-y-8">
            <h5 class="font-black text-[11px] uppercase tracking-[0.4em] text-green-500 border-l-4 border-green-500 pl-4">Media Sosial</h5>
            <div class="flex flex-wrap gap-4">
                <a href="{{ $instagram }}" target="_blank" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-green-600 hover:scale-110 transition-all cursor-pointer shadow-2xl group active:scale-90" title="Instagram">
                    <i data-lucide="instagram" class="w-5 h-5 group-hover:text-white transition-colors"></i>
                </a>
                <a href="{{ $facebook }}" target="_blank" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-green-600 hover:scale-110 transition-all cursor-pointer shadow-2xl group active:scale-90" title="Facebook">
                    <i data-lucide="facebook" class="w-5 h-5 group-hover:text-white transition-colors"></i>
                </a>
                <a href="{{ $youtube }}" target="_blank" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-green-600 hover:scale-110 transition-all cursor-pointer shadow-2xl group active:scale-90" title="YouTube">
                    <i data-lucide="youtube" class="w-5 h-5 group-hover:text-white transition-colors"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-12 pt-10 border-t border-white/5 text-center">
        <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.6em]">&copy; 2026 KORMI KABUPATEN BANDUNG. SELURUH HAK CIPTA DILINDUNGI.</p>
    </div>
</footer>
