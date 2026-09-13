<div {{ $attributes->merge([
    'class' => "sticky bottom-4 z-20 mt-8 p-3 sm:p-4 rounded-2xl sm:rounded-3xl bg-white/90 backdrop-blur-md border border-slate-200/80 shadow-xl flex flex-wrap items-center justify-between gap-3"
]) }}>
    {{ $slot }}
</div>
