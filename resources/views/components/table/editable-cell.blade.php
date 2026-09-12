@props([
    'modelId',
    'field',
    'value' => '',
    'type' => 'text', // text, textarea, select, toggle
    'options' => [], // for select type: [['value' => '', 'label' => '', 'color' => '']]
    'display' => null, // custom display template/text if any
    'placeholder' => 'Klik untuk edit...',
    'align' => 'left',
    'saveAction' => 'updateFieldInline',
])

@php
    $alignClass = match($align) {
        'center' => 'justify-center text-center',
        'right' => 'justify-end text-right',
        default => 'justify-start text-left',
    };
@endphp

<div 
    x-data="{
        editing: false,
        saving: false,
        val: @js($value),
        originalVal: @js($value),
        startEdit() {
            this.originalVal = this.val;
            this.editing = true;
            this.$nextTick(() => {
                const input = this.$refs.inlineInput;
                if (input) {
                    input.focus();
                    if (input.select && typeof input.select === 'function') {
                        input.select();
                    }
                }
            });
        },
        cancelEdit() {
            this.val = this.originalVal;
            this.editing = false;
        },
        async saveEdit() {
            if (this.val === this.originalVal) {
                this.editing = false;
                return;
            }
            this.saving = true;
            try {
                await $wire.{{ $saveAction }}(@js($modelId), @js($field), this.val);
                this.originalVal = this.val;
                this.editing = false;
            } catch (err) {
                console.error(err);
            } finally {
                this.saving = false;
            }
        }
    }"
    class="relative group/inline inline-block w-full"
>
    <!-- VIEW MODE -->
    <div 
        x-show="!editing" 
        @click="startEdit()"
        class="cursor-pointer rounded-lg p-1 -m-1 transition-all duration-150 hover:bg-indigo-50/70 hover:ring-1 hover:ring-indigo-300/60 relative flex items-center {{ $alignClass }} group-hover/inline:shadow-2xs"
        title="Klik untuk mengedit langsung"
    >
        <div class="truncate max-w-full">
            @if($slot->isNotEmpty())
                {{ $slot }}
            @elseif($type === 'select')
                @php
                    $selectedOption = collect($options)->firstWhere('value', $value) ?? ['label' => $value, 'color' => null];
                @endphp
                <span class="inline-flex items-center gap-1.5 font-bold">
                    @if(!empty($selectedOption['color']))
                        <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $selectedOption['color'] }}"></span>
                    @endif
                    <span>{{ $selectedOption['label'] ?? ($value ?: $placeholder) }}</span>
                </span>
            @else
                @if($value)
                    <span class="font-medium text-slate-800">{{ $value }}</span>
                @else
                    <span class="text-slate-400 italic text-xs">{{ $placeholder }}</span>
                @endif
            @endif
        </div>

        <!-- Hover Edit Indicator Icon -->
        <span class="opacity-0 group-hover/inline:opacity-100 ml-1.5 p-0.5 rounded bg-white text-indigo-600 shadow-xs border border-indigo-200 transition-opacity shrink-0 flex items-center justify-center">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
            </svg>
        </span>
    </div>

    <!-- EDIT MODE -->
    <div 
        x-show="editing" 
        x-cloak
        @click.outside="saveEdit()"
        @keydown.escape.prevent="cancelEdit()"
        class="relative flex items-center gap-1.5 z-20"
    >
        @if($type === 'textarea')
            <div class="w-full relative">
                <textarea
                    x-ref="inlineInput"
                    x-model="val"
                    rows="2"
                    @keydown.ctrl.enter.prevent="saveEdit()"
                    @keydown.meta.enter.prevent="saveEdit()"
                    :disabled="saving"
                    class="w-full text-xs font-medium p-2 rounded-xl bg-white border-2 border-indigo-500 shadow-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 resize-none transition-all disabled:opacity-60"
                ></textarea>
                <div class="flex items-center justify-between mt-1 text-[10px] text-slate-400">
                    <span>Tekan Ctrl+Enter atau centang untuk simpan</span>
                    <div class="flex items-center gap-1">
                        <button 
                            type="button" 
                            @click="saveEdit()" 
                            :disabled="saving"
                            class="p-1 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition-all shadow-xs cursor-pointer"
                            title="Simpan (Enter)"
                        >
                            <svg x-show="!saving" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <svg x-show="saving" class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                        <button 
                            type="button" 
                            @click="cancelEdit()" 
                            :disabled="saving"
                            class="p-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition-all cursor-pointer"
                            title="Batal (Esc)"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        @elseif($type === 'select')
            <div class="w-full flex items-center gap-1.5">
                <select
                    x-ref="inlineInput"
                    x-model="val"
                    @change="saveEdit()"
                    :disabled="saving"
                    class="w-full h-8 text-xs font-semibold px-2.5 py-1 rounded-xl bg-white border-2 border-indigo-500 shadow-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer disabled:opacity-60"
                >
                    @foreach($options as $opt)
                        <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                    @endforeach
                </select>

                <button 
                    type="button" 
                    @click="cancelEdit()" 
                    :disabled="saving"
                    class="h-8 w-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition-all shrink-0 flex items-center justify-center cursor-pointer"
                    title="Batal"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @else
            <!-- TEXT / NUMBER INPUT -->
            <div class="w-full flex items-center gap-1">
                <input
                    x-ref="inlineInput"
                    type="{{ $type }}"
                    x-model="val"
                    @keydown.enter.prevent="saveEdit()"
                    :disabled="saving"
                    class="w-full h-8 text-xs font-medium px-2.5 rounded-xl bg-white border-2 border-indigo-500 shadow-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all disabled:opacity-60"
                />

                <button 
                    type="button" 
                    @click="saveEdit()" 
                    :disabled="saving"
                    class="h-8 w-8 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition-all shadow-xs shrink-0 flex items-center justify-center cursor-pointer"
                    title="Simpan"
                >
                    <svg x-show="!saving" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <svg x-show="saving" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>

                <button 
                    type="button" 
                    @click="cancelEdit()" 
                    :disabled="saving"
                    class="h-8 w-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition-all shrink-0 flex items-center justify-center cursor-pointer"
                    title="Batal"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif
    </div>
</div>
