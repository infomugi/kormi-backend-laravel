@props([
    'name' => null,
    'id' => null,
    'label' => null,
    'description' => null,
    'checked' => false,
    'color' => 'emerald', // emerald, indigo, blue, amber, rose
    'size' => 'default', // sm, default, lg
    'type' => 'checkbox', // checkbox, radio, toggle
])

@php
    $inputId = $id ?? $name ?? 'input-' . \Illuminate\Support\Str::random(8);

    $colorClasses = [
        'emerald' => [
            'checkbox' => 'text-emerald-600 focus:ring-emerald-500/20 border-slate-300 checked:bg-emerald-600 checked:border-emerald-600',
            'toggle' => 'peer-checked:bg-emerald-600 peer-focus:ring-emerald-500/20',
        ],
        'indigo' => [
            'checkbox' => 'text-indigo-600 focus:ring-indigo-500/20 border-slate-300 checked:bg-indigo-600 checked:border-indigo-600',
            'toggle' => 'peer-checked:bg-indigo-600 peer-focus:ring-indigo-500/20',
        ],
        'blue' => [
            'checkbox' => 'text-blue-600 focus:ring-blue-500/20 border-slate-300 checked:bg-blue-600 checked:border-blue-600',
            'toggle' => 'peer-checked:bg-blue-600 peer-focus:ring-blue-500/20',
        ],
        'amber' => [
            'checkbox' => 'text-amber-600 focus:ring-amber-500/20 border-slate-300 checked:bg-amber-600 checked:border-amber-600',
            'toggle' => 'peer-checked:bg-amber-600 peer-focus:ring-amber-500/20',
        ],
        'rose' => [
            'checkbox' => 'text-rose-600 focus:ring-rose-500/20 border-slate-300 checked:bg-rose-600 checked:border-rose-600',
            'toggle' => 'peer-checked:bg-rose-600 peer-focus:ring-rose-500/20',
        ],
    ][$color] ?? [
        'checkbox' => 'text-emerald-600 focus:ring-emerald-500/20 border-slate-300 checked:bg-emerald-600 checked:border-emerald-600',
        'toggle' => 'peer-checked:bg-emerald-600 peer-focus:ring-emerald-500/20',
    ];
@endphp

@if($type === 'toggle')
    <label for="{{ $inputId }}" class="relative inline-flex items-start gap-3.5 cursor-pointer select-none group">
        <div class="relative shrink-0 mt-0.5">
            <input 
                type="checkbox" 
                id="{{ $inputId }}" 
                @if($name) name="{{ $name }}" @endif
                {{ $attributes->merge(['class' => 'sr-only peer']) }}
            >
            <div class="w-11 h-6 bg-slate-200 group-hover:bg-slate-300 peer-focus:outline-none peer-focus:ring-3 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:shadow-sm transition-all {{ $colorClasses['toggle'] }}"></div>
        </div>
        @if($label || $description || $slot->isNotEmpty())
            <div class="space-y-0.5 min-w-0">
                @if($label)
                    <span class="block text-xs font-bold text-slate-800 group-hover:text-slate-900 transition-colors">{{ $label }}</span>
                @endif
                @if($description)
                    <p class="text-[11px] text-slate-400 font-normal leading-normal">{{ $description }}</p>
                @endif
                {{ $slot }}
            </div>
        @endif
    </label>
@else
    <label for="{{ $inputId }}" class="relative inline-flex items-start gap-2.5 cursor-pointer select-none group">
        <input 
            type="{{ $type }}" 
            id="{{ $inputId }}" 
            @if($name) name="{{ $name }}" @endif
            {{ $attributes->merge([
                'class' => "w-4 h-4 rounded-md transition-all duration-150 cursor-pointer shadow-2xs focus:ring-2 focus:ring-offset-0 {$colorClasses['checkbox']}"
            ]) }}
        >
        @if($label || $description || $slot->isNotEmpty())
            <div class="space-y-0.5 min-w-0">
                @if($label)
                    <span class="block text-xs font-bold text-slate-800 group-hover:text-slate-900 transition-colors leading-tight">{{ $label }}</span>
                @endif
                @if($description)
                    <p class="text-[11px] text-slate-400 font-normal leading-normal">{{ $description }}</p>
                @endif
                {{ $slot }}
            </div>
        @endif
    </label>
@endif
