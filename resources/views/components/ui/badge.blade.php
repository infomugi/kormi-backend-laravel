@props([
    'variant' => 'neutral', // 'emerald', 'amber', 'rose', 'sky', 'indigo', 'neutral', 'purple'
    'size' => 'default', // 'sm', 'default', 'lg'
    'icon' => null,
    'dot' => false,
])

@php
    $variantClasses = [
        'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
        'amber' => 'bg-amber-50 text-amber-700 border-amber-200/80',
        'rose' => 'bg-rose-50 text-rose-700 border-rose-200/80',
        'sky' => 'bg-sky-50 text-sky-700 border-sky-200/80',
        'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-200/80',
        'purple' => 'bg-purple-50 text-purple-700 border-purple-200/80',
        'neutral' => 'bg-slate-100 text-slate-700 border-slate-200',
    ][$variant] ?? 'bg-slate-100 text-slate-700 border-slate-200';

    $dotClasses = [
        'emerald' => 'bg-emerald-500',
        'amber' => 'bg-amber-500',
        'rose' => 'bg-rose-500',
        'sky' => 'bg-sky-500',
        'indigo' => 'bg-indigo-500',
        'purple' => 'bg-purple-500',
        'neutral' => 'bg-slate-500',
    ][$variant] ?? 'bg-slate-500';

    $sizeClasses = [
        'sm' => 'px-2 py-0.5 text-[10px] gap-1',
        'default' => 'px-2.5 py-1 text-xs gap-1.5',
        'lg' => 'px-3.5 py-1.5 text-sm gap-2',
    ][$size] ?? 'px-2.5 py-1 text-xs gap-1.5';
@endphp

<span {{ $attributes->merge([
    'class' => "inline-flex items-center font-bold rounded-full border shadow-2xs {$variantClasses} {$sizeClasses}"
]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotClasses }} shrink-0"></span>
    @endif

    @if($icon)
        <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 shrink-0"></i>
    @endif

    <span>{{ $slot }}</span>
</span>
