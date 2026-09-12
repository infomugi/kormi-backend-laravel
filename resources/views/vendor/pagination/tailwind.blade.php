@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3">
        
        {{-- Summary Text --}}
        <div class="flex items-center text-xs text-slate-500 font-medium">
            @if ($paginator->firstItem())
                <span>Menampilkan <span class="font-bold text-slate-800">{{ $paginator->firstItem() }}</span> &ndash; <span class="font-bold text-slate-800">{{ $paginator->lastItem() }}</span> dari total <span class="font-bold text-slate-800">{{ $paginator->total() }}</span> data</span>
            @else
                <span>Total <span class="font-bold text-slate-800">{{ $paginator->total() }}</span> data</span>
            @endif
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex items-center gap-1.5 flex-wrap justify-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-300 bg-slate-50 border border-slate-200/60 rounded-xl cursor-not-allowed select-none">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </span>
            @else
                <button 
                    type="button" 
                    wire:click="previousPage('{{ $paginator->getPageName() }}')" 
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-600 bg-white border border-slate-200/80 rounded-xl hover:bg-slate-50 hover:border-slate-300 hover:text-indigo-600 active:scale-95 transition-all shadow-xs cursor-pointer disabled:opacity-50"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </button>
            @endif

            {{-- Pagination Elements --}}
            <div class="flex items-center gap-1">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="px-2 py-1 text-xs font-bold text-slate-400 select-none">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="inline-flex items-center justify-center min-w-[32px] h-8 px-2.5 text-xs font-bold text-white bg-indigo-600 rounded-xl shadow-xs shadow-indigo-200 select-none">
                                    {{ $page }}
                                </span>
                            @else
                                <button 
                                    type="button" 
                                    wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" 
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center justify-center min-w-[32px] h-8 px-2.5 text-xs font-semibold text-slate-600 bg-white border border-slate-200/80 rounded-xl hover:bg-slate-50 hover:border-slate-300 hover:text-indigo-600 active:scale-95 transition-all shadow-xs cursor-pointer disabled:opacity-50"
                                >
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button 
                    type="button" 
                    wire:click="nextPage('{{ $paginator->getPageName() }}')" 
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-600 bg-white border border-slate-200/80 rounded-xl hover:bg-slate-50 hover:border-slate-300 hover:text-indigo-600 active:scale-95 transition-all shadow-xs cursor-pointer disabled:opacity-50"
                >
                    <span class="hidden sm:inline">Berikutnya</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            @else
                <span aria-disabled="true" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-300 bg-slate-50 border border-slate-200/60 rounded-xl cursor-not-allowed select-none">
                    <span class="hidden sm:inline">Berikutnya</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
            @endif
        </div>

    </nav>
@endif
