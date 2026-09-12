@props([
    'name' => null,
    'options' => [], // array of ['value' => '', 'label' => '', 'description' => '', 'badge' => '', 'color' => '']
    'placeholder' => '-- Pilih Opsi --',
    'searchPlaceholder' => 'Cari opsi...',
    'emptyText' => 'Tidak ada hasil yang cocok',
    'size' => 'default', // 'sm', 'default', 'lg'
    'required' => false,
])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-xs rounded-xl',
        'default' => 'px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-bold rounded-xl sm:rounded-2xl',
        'lg' => 'px-4 sm:px-5 py-3 sm:py-4 text-sm sm:text-base font-extrabold rounded-xl sm:rounded-2xl',
    ][$size] ?? 'px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-bold rounded-xl sm:rounded-2xl';
@endphp

<div 
    x-data="{
        open: false,
        search: '',
        value: @entangle($attributes->wire('model')),
        options: {{ json_encode($options) }},
        get selectedOption() {
            return this.options.find(opt => String(opt.value) === String(this.value));
        },
        get filteredOptions() {
            if (!this.search.trim()) return this.options;
            const q = this.search.toLowerCase();
            return this.options.filter(opt => {
                return (opt.label && opt.label.toLowerCase().includes(q)) ||
                       (opt.description && opt.description.toLowerCase().includes(q)) ||
                       (opt.badge && opt.badge.toLowerCase().includes(q));
            });
        },
        selectOption(opt) {
            this.value = opt.value;
            this.open = false;
            this.search = '';
        }
    }"
    @click.away="open = false"
    class="relative w-full select-none"
    :class="open ? 'z-40' : ''"
>
    <!-- Trigger Button -->
    <button 
        type="button" 
        @click="open = !open; if(open) $nextTick(() => $refs.searchInput?.focus())"
        class="w-full flex items-center justify-between text-left bg-slate-50/70 hover:bg-slate-100/60 focus:bg-white border border-slate-200 focus:border-emerald-600 focus:ring-3 focus:ring-emerald-600/15 focus:outline-none transition-all duration-200 cursor-pointer shadow-2xs {{ $sizeClasses }}"
        :class="open ? 'ring-3 ring-emerald-600/15 border-emerald-600 bg-white' : ''"
    >
        <div class="flex items-center gap-2 min-w-0 flex-1 pr-2">
            <template x-if="selectedOption">
                <div class="flex items-center gap-2 min-w-0">
                    <template x-if="selectedOption.color">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0 shadow-2xs" :style="'background-color: ' + selectedOption.color"></span>
                    </template>
                    <span class="font-bold text-slate-900 truncate" x-text="selectedOption.label"></span>
                    <template x-if="selectedOption.badge">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200/60 shrink-0" x-text="selectedOption.badge"></span>
                    </template>
                </div>
            </template>
            <template x-if="!selectedOption">
                <span class="text-slate-400 font-normal truncate">{{ $placeholder }}</span>
            </template>
        </div>

        <div class="flex items-center gap-1.5 shrink-0 text-slate-400">
            <template x-if="value && !{{ $required ? 'true' : 'false' }}">
                <span 
                    @click.stop="value = ''; search = ''" 
                    class="p-0.5 hover:text-rose-500 rounded cursor-pointer transition-colors"
                    title="Kosongkan pilihan"
                >
                    <i data-lucide="x" class="w-3.5 h-3.5"></i>
                </span>
            </template>
            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180 text-emerald-600' : ''"></i>
        </div>
    </button>

    <!-- Hidden Native Input for standard forms -->
    <input type="hidden" @if($name) name="{{ $name }}" @endif x-model="value">

    <!-- Dropdown Menu with Live Search Filter -->
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-1 scale-98"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-1 scale-98"
        class="absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200 rounded-2xl shadow-2xl z-50 overflow-hidden max-h-64 flex flex-col p-1.5 space-y-1 ring-1 ring-black/5"
        style="display: none;"
    >
        <!-- Search Input Bar -->
        <div class="relative px-1 pt-1 pb-1 shrink-0">
            <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input 
                x-ref="searchInput"
                type="text" 
                x-model="search" 
                placeholder="{{ $searchPlaceholder }}"
                @keydown.escape="open = false"
                class="w-full pl-8 pr-7 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-600/20 transition-all"
            >
            <button 
                type="button" 
                x-show="search.length > 0" 
                @click="search = ''; $refs.searchInput.focus()"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs p-0.5"
            >
                <i data-lucide="x" class="w-3 h-3"></i>
            </button>
        </div>

        <!-- Options List -->
        <div class="overflow-y-auto space-y-0.5 flex-1 pr-1 scrollbar-none">
            <template x-for="opt in filteredOptions" :key="opt.value">
                <button 
                    type="button" 
                    @click="selectOption(opt)" 
                    class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs transition-colors cursor-pointer text-left group"
                    :class="String(opt.value) === String(value) ? 'bg-emerald-50 text-emerald-950 font-black' : 'hover:bg-slate-50 text-slate-700 font-bold'"
                >
                    <div class="flex items-center gap-2 min-w-0 flex-1 pr-2">
                        <template x-if="opt.color">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0" :style="'background-color: ' + opt.color"></span>
                        </template>
                        <div class="min-w-0">
                            <p class="truncate" x-text="opt.label"></p>
                            <template x-if="opt.description">
                                <p class="text-[10px] text-slate-400 font-normal truncate" x-text="opt.description"></p>
                            </template>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 shrink-0">
                        <template x-if="opt.badge">
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-slate-100 text-slate-600 group-hover:bg-slate-200 transition-colors" x-text="opt.badge"></span>
                        </template>
                        <template x-if="String(opt.value) === String(value)">
                            <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                        </template>
                    </div>
                </button>
            </template>

            <template x-if="filteredOptions.length === 0">
                <div class="py-4 text-center text-xs text-slate-400 font-medium">
                    <i data-lucide="search-x" class="w-5 h-5 mx-auto text-slate-300 mb-1"></i>
                    <span>{{ $emptyText }}</span>
                </div>
            </template>
        </div>
    </div>
</div>
