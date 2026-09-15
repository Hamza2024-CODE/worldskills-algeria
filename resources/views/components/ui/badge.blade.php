@props([
    'variant' => 'primary', // primary, cyan, emerald, gold, amber, rose, slate, dark
    'size' => 'md',        // sm, md
    'dot' => false,
    'icon' => null,
])

@php
    $baseClasses = "inline-flex items-center font-bold select-none rounded-ws-full shrink-0 tracking-wide";

    $sizes = [
        'sm' => 'px-2 py-0.5 text-[11px] gap-1',
        'md' => 'px-2.5 py-1 text-xs gap-1.5',
    ];

    $variants = [
        'primary' => 'bg-blue-50 text-ws-primary border border-blue-200/80',
        'cyan' => 'bg-sky-50 text-sky-700 border border-sky-200/80',
        'emerald' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/80',
        'gold' => 'bg-amber-50 text-amber-800 border border-amber-200/80',
        'amber' => 'bg-orange-50 text-orange-800 border border-orange-200/80',
        'rose' => 'bg-rose-50 text-rose-700 border border-rose-200/80',
        'slate' => 'bg-slate-100 text-slate-700 border border-slate-200',
        'dark' => 'bg-ws-navy text-white border border-white/20',
    ];

    $dotColors = [
        'primary' => 'bg-ws-primary',
        'cyan' => 'bg-sky-500',
        'emerald' => 'bg-emerald-500',
        'gold' => 'bg-amber-500',
        'amber' => 'bg-orange-500',
        'rose' => 'bg-rose-500',
        'slate' => 'bg-slate-500',
        'dark' => 'bg-white',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $dotColor = $dotColors[$variant] ?? 'bg-ws-primary';
    $classes = "{$baseClasses} {$sizeClass} {$variantClass}";
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }} animate-pulse shrink-0"></span>
    @endif

    @if($icon)
        <span class="shrink-0">{!! $icon !!}</span>
    @endif

    <span>{{ $slot }}</span>
</span>
