@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'headerAction' => null,
    'footer' => null,
    'padding' => 'default', // 'none', 'sm', 'default', 'lg'
    'variant' => 'default', // 'default', 'glass', 'flat', 'elevated'
])

@php
    $paddingClasses = [
        'none' => 'p-0',
        'sm' => 'p-4',
        'default' => 'p-5 sm:p-6',
        'lg' => 'p-6 sm:p-8',
    ][$padding] ?? 'p-5 sm:p-6';

    $variantClasses = [
        'default' => 'bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow duration-200',
        'glass' => 'bg-white/80 backdrop-blur-md border border-white/60 shadow-lg shadow-emerald-950/5',
        'flat' => 'bg-slate-50 border border-slate-200',
        'elevated' => 'bg-white border border-slate-100 shadow-xl shadow-slate-200/50',
    ][$variant] ?? 'bg-white border border-slate-200/80 shadow-xs';
@endphp

<div {{ $attributes->merge([
    'class' => "rounded-2xl sm:rounded-3xl {$variantClasses} overflow-hidden"
]) }}>
    @if($title || $description || $icon || $headerAction)
        <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                @if($icon)
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                    </div>
                @endif
                <div>
                    @if($title)
                        <h3 class="font-black text-slate-900 text-sm sm:text-base leading-tight">{{ $title }}</h3>
                    @endif
                    @if($description)
                        <p class="text-xs text-slate-500 mt-0.5">{{ $description }}</p>
                    @endif
                </div>
            </div>

            @if($headerAction)
                <div class="shrink-0">
                    {{ $headerAction }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $paddingClasses }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-5 sm:px-6 py-3.5 bg-slate-50/80 border-t border-slate-100 text-xs text-slate-600">
            {{ $footer }}
        </div>
    @endif
</div>
