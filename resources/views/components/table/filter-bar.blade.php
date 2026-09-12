@props([
    'searchPlaceholder' => 'Cari data...',
    'searchModel' => 'cari',
    'searchDebounce' => '300ms',
])

<div {{ $attributes->merge(['class' => 'bg-white border border-slate-200/90 p-3 sm:p-4 rounded-2xl sm:rounded-3xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] space-y-3 transition-all']) }}>
    @if(isset($top))
        <div class="relative overflow-hidden">
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 pt-0.5 scrollbar-none no-scrollbar scroll-smooth">
                {{ $top }}
            </div>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-2.5 {{ isset($top) ? 'pt-3 border-t border-slate-100' : '' }}">
        <!-- Left: Search Box (if search model provided) -->
        @if($searchModel)
            <div class="relative w-full lg:w-80 xl:w-96 group shrink-0">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 group-focus-within:text-indigo-600 absolute left-3.5 top-1/2 -translate-y-1/2 transition-colors pointer-events-none"></i>
                <input 
                    type="text" 
                    wire:model.live.debounce.{{ $searchDebounce }}="{{ $searchModel }}" 
                    placeholder="{{ $searchPlaceholder }}" 
                    class="w-full h-10 pl-10 pr-9 bg-slate-50/80 hover:bg-slate-100/60 focus:bg-white border border-slate-200 text-slate-800 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 shadow-2xs"
                >
                
                <!-- Loading indicator when typing search -->
                <div wire:loading wire:target="{{ $searchModel }}" class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                    <svg class="animate-spin h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <!-- Clear button (when has search text and not loading) -->
                @if($this->{$searchModel} ?? false)
                    <button 
                        wire:loading.remove
                        wire:target="{{ $searchModel }}"
                        type="button" 
                        wire:click="$set('{{ $searchModel }}', '')" 
                        class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-200/60 transition-colors cursor-pointer"
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
            <div class="flex items-center gap-2 w-full lg:w-auto flex-wrap sm:flex-nowrap justify-start sm:justify-end overflow-x-auto pb-0.5 sm:pb-0 scrollbar-none">
                {{ $actions ?? $slot }}
            </div>
        @endif
    </div>
</div>
