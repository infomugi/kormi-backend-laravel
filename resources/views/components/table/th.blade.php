@props([
    'align' => 'left',
    'sortable' => false,
    'sortField' => null,
    'currentSort' => null,
    'currentDirection' => 'asc',
    'compact' => false,
])

@php
    $alignClass = match($align) {
        'center' => 'text-center justify-center',
        'right' => 'text-right justify-end',
        default => 'text-left justify-start',
    };

    $paddingClass = $compact ? 'px-3.5 sm:px-4 py-2.5 sm:py-3' : 'px-4 sm:px-5 py-3 sm:py-3.5';
@endphp

<th {{ $attributes->merge(['class' => "{$paddingClass} text-[10px] uppercase font-black tracking-wider text-slate-400 select-none align-middle"]) }}>
    @if($sortable && $sortField)
        <button 
            type="button" 
            wire:click="sortBy('{{ $sortField }}')" 
            class="inline-flex items-center gap-1.5 hover:text-indigo-600 transition-colors cursor-pointer group/th {{ $alignClass }}"
        >
            <span class="{{ $currentSort === $sortField ? 'text-indigo-600 font-black' : '' }}">{{ $slot }}</span>
            <span class="text-slate-300 group-hover/th:text-indigo-500 transition-colors">
                @if($currentSort === $sortField)
                    @if($currentDirection === 'asc')
                        <i data-lucide="arrow-up" class="w-3.5 h-3.5 text-indigo-600 font-black"></i>
                    @else
                        <i data-lucide="arrow-down" class="w-3.5 h-3.5 text-indigo-600 font-black"></i>
                    @endif
                @else
                    <i data-lucide="chevrons-up-down" class="w-3 h-3 opacity-30 group-hover/th:opacity-100"></i>
                @endif
            </span>
        </button>
    @else
        <div class="flex items-center {{ $alignClass }}">
            {{ $slot }}
        </div>
    @endif
</th>
