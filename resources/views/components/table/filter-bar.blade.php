@props([
    'searchPlaceholder' => 'Cari data...',
    'searchModel' => 'cari',
    'searchDebounce' => '300ms',
])

<div {{ $attributes->merge(['class' => 'bg-white border border-slate-200/80 p-3.5 sm:p-4 rounded-2xl sm:rounded-3xl shadow-xs space-y-3']) }}>
    @if(isset($top))
        <div class="overflow-x-auto pb-1.5 scrollbar-none">
            {{ $top }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row items-center justify-between gap-3 {{ isset($top) ? 'pt-2.5 border-t border-slate-100' : '' }}">
        <!-- Left: Search Box (if search model provided) -->
        @if($searchModel)
            <div class="relative w-full lg:w-96 group">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 group-focus-within:text-indigo-600 absolute left-3.5 top-1/2 -translate-y-1/2 transition-colors"></i>
                <input 
                    type="text" 
                    wire:model.live.debounce.{{ $searchDebounce }}="{{ $searchModel }}" 
                    placeholder="{{ $searchPlaceholder }}" 
                    class="w-full pl-10 pr-10 py-2.5 bg-slate-50/80 border border-slate-200 text-slate-800 rounded-2xl text-xs font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 placeholder:font-normal shadow-2xs"
                >
                @if($this->{$searchModel} ?? false)
                    <button 
                        type="button" 
                        wire:click="$set('{{ $searchModel }}', '')" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer"
                        title="Hapus pencarian"
                    >
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </button>
                @endif
            </div>
        @else
            <div></div>
        @endif

        <!-- Right Controls / Filters -->
        @if(isset($actions) || $slot->isNotEmpty())
            <div class="flex items-center gap-2.5 w-full lg:w-auto flex-wrap justify-end">
                {{ $actions ?? $slot }}
            </div>
        @endif
    </div>
</div>
