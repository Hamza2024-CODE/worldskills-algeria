@props([
    'variant' => 'primary', // primary, secondary, outline, ghost, danger, dark
    'size' => 'md',        // sm, md, lg
    'type' => 'button',
    'href' => null,
    'icon' => null,
    'iconPosition' => 'start', // start, end
    'loading' => false,
    'disabled' => false,
])

@php
    $baseClasses = "inline-flex items-center justify-center font-bold ws-transition ws-focus-ring cursor-pointer select-none disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none rounded-ws-sm";

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs gap-1.5 min-h-[32px]',
        'md' => 'px-4 py-2 text-xs sm:text-sm gap-2 min-h-[40px]',
        'lg' => 'px-6 py-3 text-sm sm:text-base gap-2.5 min-h-[48px] rounded-ws-md',
    ];

    $variants = [
        'primary' => 'bg-ws-primary text-white hover:bg-ws-primary-hover shadow-sm active:translate-y-[1px]',
        'secondary' => 'bg-ws-slate text-white hover:bg-ws-navy shadow-sm active:translate-y-[1px]',
        'cyan' => 'bg-ws-cyan text-ws-navy hover:bg-[#38C6FF] font-black shadow-sm active:translate-y-[1px]',
        'outline' => 'bg-transparent text-ws-slate border border-ws-border hover:bg-slate-100 hover:border-slate-300',
        'ghost' => 'bg-transparent text-slate-600 hover:text-ws-primary hover:bg-slate-100',
        'danger' => 'bg-ws-rose text-white hover:bg-[#E11D48] shadow-sm active:translate-y-[1px]',
        'dark' => 'bg-ws-navy text-white hover:bg-[#020A24] border border-white/10 shadow-sm active:translate-y-[1px]',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $classes = "{$baseClasses} {$sizeClass} {$variantClass}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'start')
            <span class="shrink-0">{!! $icon !!}</span>
        @endif

        <span>{{ $slot }}</span>

        @if($icon && $iconPosition === 'end')
            <span class="shrink-0">{!! $icon !!}</span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <svg class="animate-spin w-4 h-4 shrink-0 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'start')
            <span class="shrink-0">{!! $icon !!}</span>
        @endif

        <span>{{ $slot }}</span>

        @if($icon && $iconPosition === 'end')
            <span class="shrink-0">{!! $icon !!}</span>
        @endif
    </button>
@endif
