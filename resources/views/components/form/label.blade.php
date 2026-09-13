@props([
    'value' => null,
    'required' => false,
])

<label {{ $attributes->merge(['class' => 'block text-xs font-black text-slate-700 uppercase tracking-wider mb-2']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-rose-500 font-black ml-0.5">*</span>
    @endif
</label>
