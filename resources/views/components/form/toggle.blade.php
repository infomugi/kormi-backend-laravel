@props([
    'label' => null,
    'description' => null,
    'name' => null,
])

<label class="relative flex items-start gap-3 cursor-pointer select-none">
    <div class="relative mt-0.5">
        <input 
            type="checkbox" 
            {{ $attributes->whereStartsWith('wire:model') }}
            @if($name) name="{{ $name }}" @endif
            class="sr-only peer"
        >
        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner"></div>
    </div>
    @if($label || $description)
        <div class="flex-1">
            @if($label)
                <span class="block text-xs font-bold text-slate-800">{{ $label }}</span>
            @endif
            @if($description)
                <span class="block text-[11px] text-slate-500 mt-0.5">{{ $description }}</span>
            @endif
        </div>
    @endif
</label>
