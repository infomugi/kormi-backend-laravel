@props([
    'score' => 0,
    'checklist' => [],
    'slug' => '',
    'title' => '',
    'description' => '',
])

<div class="space-y-3.5 sm:space-y-4" x-data="{ bukaSeoDetail: false }">
    <!-- Header with dynamic score pill -->
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
            <i data-lucide="gauge" class="w-4 h-4 text-emerald-600"></i>
            <span>Audit SEO & Keterbacaan</span>
        </h3>
        <span class="text-[11px] sm:text-xs font-black px-2.5 py-0.5 rounded-full {{ $score >= 75 ? 'bg-emerald-100 text-emerald-800' : ($score >= 40 ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
            {{ $score }}/100
        </span>
    </div>

    <!-- Progress Bar SEO -->
    <div class="w-full h-1.5 sm:h-2 bg-slate-100 rounded-full overflow-hidden">
        <div class="h-full rounded-full transition-all duration-300 {{ $score >= 75 ? 'bg-emerald-500' : ($score >= 40 ? 'bg-amber-500' : 'bg-rose-500') }}" style="width: {{ $score }}%;"></div>
    </div>

    <!-- SEO Checklist Items -->
    <div class="space-y-1.5 sm:space-y-2 text-xs">
        @foreach($checklist as $item)
            <div class="flex items-center gap-2 {{ $item['pass'] ? 'text-emerald-800 font-semibold' : 'text-slate-400 font-medium' }}">
                <i data-lucide="{{ $item['pass'] ? 'check-circle-2' : 'circle' }}" class="w-3.5 h-3.5 {{ $item['pass'] ? 'text-emerald-600 shrink-0' : 'text-slate-300 shrink-0' }}"></i>
                <span class="text-[10px] sm:text-[11px] leading-tight">{{ $item['label'] }}</span>
            </div>
        @endforeach
    </div>

    <!-- Google Search Simulation Toggle Button on Mobile -->
    <div class="pt-2 border-t border-slate-100">
        <button 
            type="button" 
            @click="bukaSeoDetail = !bukaSeoDetail"
            class="w-full flex items-center justify-between text-[11px] font-bold text-slate-500 hover:text-slate-800 py-1 cursor-pointer select-none"
        >
            <span class="uppercase tracking-wider">Simulasi Google Snippet</span>
            <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-200" :class="bukaSeoDetail ? 'rotate-180' : ''"></i>
        </button>
        
        <div x-show="bukaSeoDetail" x-transition.opacity class="mt-2 p-3 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-200/80 space-y-1 font-sans">
            <div class="flex items-center gap-1.5 text-[9px] sm:text-[10px] text-slate-500">
                <span class="w-3 h-3 rounded-full bg-emerald-600 text-white text-[7px] flex items-center justify-center font-black">K</span>
                <span class="truncate">kormi.kabupatenbandung.go.id &rsaquo; berita &rsaquo; {{ $slug ?: 'url-berita' }}</span>
            </div>
            <h4 class="text-[11px] sm:text-xs font-bold text-blue-700 line-clamp-1">
                {{ $title ?: 'Judul Artikel Berita KORMI Kabupaten Bandung' }}
            </h4>
            <p class="text-[10px] sm:text-[11px] text-slate-600 line-clamp-2 leading-relaxed">
                {{ $description ?: 'Ringkasan cuplikan berita akan tampil sebagai meta deskripsi pada hasil penelusuran mesin pencari...' }}
            </p>
        </div>
    </div>
</div>
