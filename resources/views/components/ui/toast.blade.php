@props([
    'type' => 'info', // success, error, warning, info
    'title' => null,
    'message' => null,
    'dismissible' => true,
])

@php
    $types = [
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
        'error' => 'bg-rose-50 border-rose-200 text-rose-800',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
        'info' => 'bg-blue-50 border-blue-200 text-ws-primary',
    ];
    $icons = [
        'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
        'error' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
        'info' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    ];

    $typeClass = $types[$type] ?? $types['info'];
    $iconPath = $icons[$type] ?? $icons['info'];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    {{ $attributes->merge(['class' => "rounded-ws-sm border p-4 flex items-start gap-3 shadow-xs ws-transition {$typeClass}"]) }}
    role="alert"
>
    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $iconPath !!}
    </svg>

    <div class="flex-1 min-w-0">
        @if($title)
            <h4 class="font-black text-xs sm:text-sm">{{ $title }}</h4>
        @endif
        <div class="text-xs font-medium {{ $title ? 'mt-0.5' : '' }}">
            {{ $message ?? $slot }}
        </div>
    </div>

    @if($dismissible)
        <button
            type="button"
            x-on:click="show = false"
            class="p-1 -me-1 rounded-ws-xs opacity-60 hover:opacity-100 ws-transition"
            aria-label="Close"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    @endif
</div>
