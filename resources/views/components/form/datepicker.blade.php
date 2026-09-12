@props([
    'name' => null,
    'enableTime' => true,
    'dateFormat' => 'Y-m-d H:i',
    'altFormat' => 'j F Y, H:i',
    'placeholder' => 'Pilih tanggal & waktu...',
    'minDate' => null,
    'size' => 'default', // 'sm', 'default', 'lg'
])

@php
    $sizeClasses = [
        'sm' => 'py-2 text-xs rounded-xl !pl-10 !pr-10',
        'default' => 'py-2.5 sm:py-3 text-xs sm:text-sm rounded-xl sm:rounded-2xl !pl-11 !pr-10',
        'lg' => 'py-3 sm:py-4 text-sm sm:text-base font-bold rounded-xl sm:rounded-2xl !pl-12 !pr-10',
    ][$size] ?? 'py-2.5 sm:py-3 text-xs sm:text-sm rounded-xl sm:rounded-2xl !pl-11 !pr-10';
@endphp

<div 
    wire:ignore
    x-data="{
        picker: null,
        value: @entangle($attributes->wire('model')),
        init() {
            const initFlatpickr = () => {
                if (!window.flatpickr) return;
                
                if (this.picker) {
                    try { this.picker.destroy(); } catch (e) {}
                }

                this.picker = window.flatpickr(this.$refs.dateInput, {
                    enableTime: {{ $enableTime ? 'true' : 'false' }},
                    dateFormat: '{{ $enableTime ? 'Y-m-d\\TH:i' : 'Y-m-d' }}',
                    altInput: true,
                    altFormat: '{{ $altFormat }}',
                    altInputClass: 'w-full bg-slate-50/70 hover:bg-slate-100/70 focus:bg-white border border-slate-200 focus:border-emerald-600 focus:ring-3 focus:ring-emerald-600/15 focus:outline-none text-slate-900 font-bold transition-all duration-200 cursor-pointer shadow-2xs {{ $sizeClasses }}',
                    time_24hr: true,
                    defaultDate: this.value || null,
                    @if($minDate) minDate: '{{ $minDate }}', @endif
                    disableMobile: 'true',
                    onChange: (selectedDates, dateStr) => {
                        this.value = dateStr;
                    }
                });
            };

            this.$nextTick(() => {
                initFlatpickr();
            });

            this.$watch('value', (newVal) => {
                if (this.picker && newVal !== this.picker.input.value) {
                    this.picker.setDate(newVal || '', false);
                }
            });
        },
        openPicker() {
            if (this.picker) {
                this.picker.open();
            }
        },
        clearDate() {
            this.value = null;
            if (this.picker) this.picker.clear();
        }
    }" 
    @click="openPicker()"
    class="relative w-full group select-none cursor-pointer"
>
    <!-- Calendar Icon Indicator -->
    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 pointer-events-none z-10 flex items-center justify-center">
        <i data-lucide="calendar" class="w-4 h-4"></i>
    </div>

    <!-- Hidden native flatpickr target with fallback dimensions -->
    <input 
        x-ref="dateInput"
        type="text"
        @if($name) name="{{ $name }}" id="{{ $name }}" @endif
        placeholder="{{ $placeholder }}"
        class="w-full bg-slate-50/70 border border-slate-200 text-slate-900 font-bold transition-all duration-200 cursor-pointer shadow-2xs {{ $sizeClasses }}"
    >

    <!-- Clear / Reset Date Button -->
    <div 
        x-show="value" 
        x-transition.opacity 
        class="absolute right-3 top-1/2 -translate-y-1/2 z-10 flex items-center"
    >
        <button 
            type="button" 
            @click.stop="clearDate()"
            class="p-1 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition-colors cursor-pointer"
            title="Hapus Tanggal"
        >
            <i data-lucide="x" class="w-3.5 h-3.5"></i>
        </button>
    </div>
</div>
