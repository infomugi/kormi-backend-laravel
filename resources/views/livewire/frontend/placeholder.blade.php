<div>
    <div class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-4xl text-center">
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 uppercase tracking-tight mb-4">{{ $title }}</h1>
            <p class="text-slate-500 font-medium mb-8">Halaman ini telah terhubung dalam sistem navigasi Laravel & Livewire.</p>
            <a href="{{ route('beranda') }}" wire:navigate class="px-8 py-3.5 bg-bedasGreen text-white font-bold rounded-full text-xs uppercase tracking-widest shadow-xl inline-flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
