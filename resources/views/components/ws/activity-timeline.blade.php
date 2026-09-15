@props([
    'items' => [], // array of ['icon'=>'','label'=>'','time'=>'','color'=>'slate']
])
<div {{ $attributes->merge(['class' => 'space-y-1']) }}>
    @forelse($items as $item)
        @php
        $dotColors = [
            'blue'    => 'bg-blue-500',
            'emerald' => 'bg-emerald-500',
            'amber'   => 'bg-amber-400',
            'rose'    => 'bg-rose-500',
            'slate'   => 'bg-slate-300',
            'violet'  => 'bg-violet-500',
        ];
        $dot = $dotColors[$item['color'] ?? 'slate'] ?? $dotColors['slate'];
        @endphp
        <div class="flex items-start gap-3 py-2.5 border-b border-slate-50 last:border-0">
            <div class="flex flex-col items-center gap-0.5 pt-0.5 shrink-0">
                <span class="w-2 h-2 rounded-full {{ $dot }}"></span>
                <span class="w-px flex-1 bg-slate-100"></span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-slate-700 leading-snug truncate">{{ $item['label'] ?? '' }}</p>
                @if(!empty($item['sub']))
                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $item['sub'] }}</p>
                @endif
            </div>
            @if(!empty($item['time']))
                <span class="text-[10px] font-bold text-slate-400 shrink-0">{{ $item['time'] }}</span>
            @endif
        </div>
    @empty
        <x-ws.empty-state icon="clipboard-document-list" :message="__('لا توجد نشاطات مسجلة بعد.')" />
    @endforelse
</div>
