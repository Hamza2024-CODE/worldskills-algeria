@props([
    'variant' => 'solid', // solid, elevated, interactive, accent, dark
    'padding' => 'md',    // none, sm, md, lg
    'as' => 'div',
])

@php
    $baseClasses = "rounded-ws-md overflow-hidden relative";

    $paddings = [
        'none' => 'p-0',
        'sm' => 'p-3 sm:p-4',
        'md' => 'p-5 sm:p-6',
        'lg' => 'p-6 sm:p-8',
    ];

    $variants = [
        'solid' => 'bg-white border border-ws-border text-ws-slate shadow-xs',
        'elevated' => 'bg-white border border-ws-border text-ws-slate shadow-md',
        'interactive' => 'bg-white border border-ws-border text-ws-slate ws-card-interactive cursor-pointer',
        'accent' => 'ws-glass-accent text-ws-slate shadow-sm',
        'dark' => 'bg-ws-navy border border-white/10 text-white shadow-xl',
        'dark-glass' => 'ws-glass-dark-accent text-white shadow-xl',
    ];

    $paddingClass = $paddings[$padding] ?? $paddings['md'];
    $variantClass = $variants[$variant] ?? $variants['solid'];
    $classes = "{$baseClasses} {$variantClass} {$paddingClass}";
@endphp

<{{ $as }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</{{ $as }}>
