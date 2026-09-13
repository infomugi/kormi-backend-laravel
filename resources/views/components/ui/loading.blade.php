@props([
    'target' => null,
    'text' => 'Memuat data...',
    'size' => 'default', // 'sm', 'default', 'lg'
])

@php
    $sizeClasses = [
        'sm' => 'w-4 h-4',
        'default' => 'w-6 h-6',
        'lg' => 'w-8 h-8',
    ][$size] ?? 'w-6 h-6';
@endphp

<div 
    @if($target) wire:loading.flex wire:target="{{ $target }}" @endif 
    {{ $attributes->merge([
        'class' => "items-center justify-center gap-2.5 text-slate-500 py-4 text-xs sm:text-sm font-medium"
    ]) }}
>
    <i data-lucide="loader-2" class="{{ $sizeClasses }} text-emerald-600 animate-spin"></i>
    <span>{{ $text }}</span>
</div>
