@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'iconColor' => 'text-indigo-600',
    'iconBg' => 'bg-indigo-50 border-indigo-100',
    'badge' => null,
    'badgeColor' => 'bg-indigo-50 text-indigo-700 border-indigo-200/60',
    'headerActions' => null,
    'padding' => 'p-0',
    'overflow' => 'overflow-hidden',
    'footer' => null,
])

<div {{ $attributes->merge(['class' => "bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl shadow-[0_2px_12px_-2px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_24px_-4px_rgba(0,0,0,0.06)] transition-all duration-200 relative {$overflow}"]) }}>
    <!-- Card Header (if header info provided) -->
    @if($title || $headerActions || $badge || $icon)
        <div class="px-5 py-4 border-b border-slate-100/90 rounded-t-2xl sm:rounded-t-3xl flex flex-wrap items-center justify-between gap-3 bg-gradient-to-r from-slate-50/80 via-white to-slate-50/40">
            <div class="flex items-center gap-3 min-w-0">
                @if($icon)
                    <div class="w-8 h-8 rounded-xl {{ $iconBg }} border flex items-center justify-center shrink-0 shadow-2xs">
                        <i data-lucide="{{ $icon }}" class="w-4 h-4 {{ $iconColor }}"></i>
                    </div>
                @endif
                <div class="min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        @if($title)
                            <h3 class="font-extrabold text-slate-900 text-sm tracking-tight truncate">{{ $title }}</h3>
                        @endif
                        @if($badge)
                            <span class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full border {{ $badgeColor }}">
                                {{ $badge }}
                            </span>
                        @endif
                    </div>
                    @if($subtitle)
                        <p class="text-[11px] text-slate-400 font-medium truncate mt-0.5">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>

            @if($headerActions)
                <div class="flex items-center gap-2 shrink-0">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    <!-- Card Body Content -->
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>

    <!-- Optional Footer -->
    @if($footer)
        <div class="px-5 sm:px-6 py-3.5 border-t border-slate-100 bg-slate-50/60 rounded-b-2xl sm:rounded-b-3xl">
            {{ $footer }}
        </div>
    @endif
</div>
