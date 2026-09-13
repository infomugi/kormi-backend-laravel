@props([
    'type' => 'info', // 'info', 'success', 'warning', 'danger'
    'title' => null,
    'icon' => null,
    'dismissible' => false,
])

@php
    $typeClasses = [
        'info' => 'bg-sky-50/80 border-sky-200 text-sky-900',
        'success' => 'bg-emerald-50/80 border-emerald-200 text-emerald-900',
        'warning' => 'bg-amber-50/80 border-amber-200 text-amber-900',
        'danger' => 'bg-rose-50/80 border-rose-200 text-rose-900',
    ][$type] ?? 'bg-sky-50/80 border-sky-200 text-sky-900';

    $defaultIcons = [
        'info' => 'info',
        'success' => 'check-circle',
        'warning' => 'alert-triangle',
        'danger' => 'alert-circle',
    ];

    $iconName = $icon ?? ($defaultIcons[$type] ?? 'info');
@endphp

<div 
    x-data="{ open: true }" 
    x-show="open" 
    {{ $attributes->merge([
        'class' => "p-4 rounded-2xl border flex items-start gap-3 shadow-2xs {$typeClasses}"
    ]) }}
>
    <div class="shrink-0 mt-0.5">
        <i data-lucide="{{ $iconName }}" class="w-5 h-5"></i>
    </div>

    <div class="flex-1 text-xs sm:text-sm">
        @if($title)
            <h4 class="font-bold mb-0.5 leading-tight">{{ $title }}</h4>
        @endif
        <div class="leading-relaxed opacity-90">
            {{ $slot }}
        </div>
    </div>

    @if($dismissible)
        <button 
            type="button" 
            x-on:click="open = false" 
            class="shrink-0 opacity-60 hover:opacity-100 transition-opacity p-0.5 cursor-pointer"
        >
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    @endif
</div>
