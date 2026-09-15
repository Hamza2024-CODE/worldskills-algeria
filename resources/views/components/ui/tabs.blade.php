@props([
    'active' => '',
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-1.5 p-1 rounded-ws-sm bg-slate-100 border border-slate-200/80 overflow-x-auto select-none']) }}>
    {{ $slot }}
</div>
