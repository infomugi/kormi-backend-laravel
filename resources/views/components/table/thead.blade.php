@props([])

<thead {{ $attributes->merge(['class' => 'bg-slate-50/90 text-[10px] uppercase font-black tracking-wider text-slate-400 border-b border-slate-200/80 sticky top-0 z-10 backdrop-blur-xs']) }}>
    {{ $slot }}
</thead>
