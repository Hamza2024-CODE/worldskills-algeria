<div class="space-y-5 pb-8">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-2">
        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-900">مركز النزاهة والرقابة الشاملة</h1>
            <p class="text-sm text-slate-500">سجل تدقيق موحد لكل طبقات حوكمة المنافسة</p>
        </div>
    </div>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs text-center">
            <div class="text-3xl font-black text-blue-600">{{ $totalCerts }}</div>
            <div class="text-xs font-bold text-slate-500 mt-1">شهادات مصدرة</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs text-center">
            <div class="text-3xl font-black text-indigo-600">{{ $totalBadges }}</div>
            <div class="text-xs font-bold text-slate-500 mt-1">بطاقات اعتماد</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs text-center">
            <div class="text-3xl font-black text-amber-600">{{ $openAppeals }}</div>
            <div class="text-xs font-bold text-slate-500 mt-1">طعون مفتوحة</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs text-center">
            <div class="text-3xl font-black text-emerald-600">{{ $publishedResults }}</div>
            <div class="text-xs font-bold text-slate-500 mt-1">نتائج منشورة</div>
        </div>
    </div>

    {{-- UNIFIED GOVERNANCE TIMELINE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="font-black text-slate-900 text-base">سجل الأحداث الموحد للحوكمة (آخر 50 حدثاً)</h2>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($events as $event)
                @php
                    $colorMap = [
                        'green'  => ['bg-emerald-50', 'text-emerald-700', 'bg-emerald-100'],
                        'red'    => ['bg-red-50', 'text-red-700', 'bg-red-100'],
                        'amber'  => ['bg-amber-50', 'text-amber-700', 'bg-amber-100'],
                        'blue'   => ['bg-blue-50', 'text-blue-700', 'bg-blue-100'],
                        'indigo' => ['bg-indigo-50', 'text-indigo-700', 'bg-indigo-100'],
                    ];
                    $colors = $colorMap[$event['color']] ?? $colorMap['blue'];
                @endphp
                <div class="px-5 py-3.5 flex items-start gap-4 hover:bg-slate-50 transition">
                    <div class="w-8 h-8 rounded-full {{ $colors[2] }} {{ $colors[1] }} flex items-center justify-center text-xs font-black shrink-0 mt-0.5">
                        @if($event['color'] === 'green') <x-ws.icon name="check-circle" class="w-4 h-4 text-emerald-500 inline-block" />
                        @elseif($event['color'] === 'red') <x-ws.icon name="x-circle" class="w-4 h-4 text-red-500 inline-block" />
                        @elseif($event['color'] === 'amber') <x-ws.icon name="scale" class="w-4 h-4 text-amber-500 inline-block" />
                        @else ●
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-900 leading-snug">{{ $event['label'] }}</p>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-xs text-slate-400 font-mono">{{ $event['actor'] }}</span>
                            <span class="text-xs text-slate-300">·</span>
                            <span class="text-xs text-slate-400 font-mono">{{ $event['time']?->format('Y-m-d H:i') }}</span>
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $colors[0] }} {{ $colors[1] }}">{{ $event['type'] }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-5 py-12 text-center text-slate-400 font-medium">لا توجد أحداث حوكمة مسجلة بعد</div>
            @endforelse
        </div>
    </div>

</div>
