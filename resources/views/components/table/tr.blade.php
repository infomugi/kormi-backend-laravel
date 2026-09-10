@props([
    'selected' => false,
    'striped' => false
])

<tr {{ $attributes->merge(['class' => 'group/tr border-b border-slate-100 last:border-b-0 transition-colors duration-150 ' . ($selected ? 'bg-indigo-50/50 hover:bg-indigo-50/70' : ($striped ? 'odd:bg-slate-50/40 hover:bg-slate-50/80' : 'hover:bg-slate-50/80'))]) }}>
    {{ $slot }}
</tr>
