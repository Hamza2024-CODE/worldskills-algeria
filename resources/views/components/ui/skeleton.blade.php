@props([
    'type' => 'text', // text, line, card, circle, table
    'lines' => 3,
])

@if($type === 'circle')
    <div {{ $attributes->merge(['class' => 'rounded-full bg-slate-200 animate-pulse shrink-0']) }}></div>
@elseif($type === 'card')
    <div {{ $attributes->merge(['class' => 'rounded-ws-md border border-slate-100 bg-white p-5 space-y-4 shadow-xs']) }}>
        <div class="h-4 bg-slate-200 rounded-ws-xs w-1/3 animate-pulse"></div>
        <div class="h-8 bg-slate-200 rounded-ws-xs w-2/3 animate-pulse"></div>
        <div class="h-3 bg-slate-100 rounded-ws-xs w-1/2 animate-pulse"></div>
    </div>
@elseif($type === 'table')
    <div {{ $attributes->merge(['class' => 'space-y-3 p-4 bg-white rounded-ws-md border border-slate-100']) }}>
        @for($i = 0; $i < $lines; $i++)
            <div class="flex items-center gap-4 animate-pulse">
                <div class="h-4 bg-slate-200 rounded-ws-xs w-1/4"></div>
                <div class="h-4 bg-slate-100 rounded-ws-xs w-1/3"></div>
                <div class="h-4 bg-slate-200 rounded-ws-xs w-1/6"></div>
                <div class="h-4 bg-slate-100 rounded-ws-xs w-1/4"></div>
            </div>
        @endfor
    </div>
@else
    <div {{ $attributes->merge(['class' => 'space-y-2.5']) }}>
        @for($i = 0; $i < $lines; $i++)
            <div class="h-3 bg-slate-200 rounded-ws-xs animate-pulse {{ $i === $lines - 1 ? 'w-2/3' : 'w-full' }}"></div>
        @endfor
    </div>
@endif
