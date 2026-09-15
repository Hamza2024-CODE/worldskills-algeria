@props([
    'title' => '',
    'value' => '',
    'icon' => null,
    'trend' => null,
    'trendType' => 'up', // up, down, neutral
    'description' => null,
    'variant' => 'solid', // solid, elevated, interactive
])

@php
    $trendColors = [
        'up' => 'text-emerald-700 bg-emerald-50 border-emerald-200',
        'down' => 'text-rose-700 bg-rose-50 border-rose-200',
        'neutral' => 'text-slate-600 bg-slate-100 border-slate-200',
    ];
    $trendClass = $trendColors[$trendType] ?? $trendColors['neutral'];
@endphp

<x-ui.card :variant="$variant" padding="md" {{ $attributes }}>
    <div class="flex items-start justify-between gap-4">
        <div class="space-y-1.5 min-w-0">
            <span class="text-xs font-bold text-slate-500 block truncate uppercase tracking-wider">{{ $title }}</span>
            <div class="text-2xl sm:text-3xl font-black text-ws-navy tracking-tight font-sans">
                {{ $value }}
            </div>
        </div>

        @if($icon)
            <div class="w-11 h-11 rounded-ws-sm bg-blue-50 text-ws-primary flex items-center justify-center shrink-0 border border-blue-100/80">
                {!! $icon !!}
            </div>
        @endif
    </div>

    @if($trend || $description)
        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs gap-2">
            @if($trend)
                <span class="inline-flex items-center gap-1 font-bold px-1.5 py-0.5 rounded-ws-xs border {{ $trendClass }}">
                    @if($trendType === 'up')
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    @elseif($trendType === 'down')
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    @endif
                    <span>{{ $trend }}</span>
                </span>
            @endif

            @if($description)
                <span class="text-slate-500 truncate font-medium">{{ $description }}</span>
            @endif
        </div>
    @endif
</x-ui.card>
