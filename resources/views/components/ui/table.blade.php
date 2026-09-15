@props([
    'headers' => [],
    'empty' => false,
    'emptyMessage' => null,
])

<div class="w-full overflow-hidden rounded-ws-md border border-ws-border bg-white shadow-xs">
    <div class="overflow-x-auto">
        <table {{ $attributes->merge(['class' => 'w-full text-start border-collapse text-xs sm:text-sm text-ws-slate']) }}>
            @if(count($headers) > 0 || isset($head))
                <thead class="bg-slate-50 border-b border-ws-border text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                    @if(isset($head))
                        {{ $head }}
                    @else
                        <tr>
                            @foreach($headers as $header)
                                <th scope="col" class="px-4 py-3 text-start whitespace-nowrap font-bold">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    @endif
                </thead>
            @endif

            <tbody class="divide-y divide-slate-100 bg-white">
                @if($empty)
                    <tr>
                        <td colspan="{{ count($headers) ?: 10 }}" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                <span class="font-bold text-xs">{{ $emptyMessage ?? __('messages.no_data_available') ?? 'لا توجد بيانات متاحة حالياً' }}</span>
                            </div>
                        </td>
                    </tr>
                @else
                    {{ $slot }}
                @endif
            </tbody>
        </table>
    </div>

    @if(isset($footer))
        <div class="px-4 py-3 border-t border-ws-border bg-slate-50/70 flex items-center justify-between">
            {{ $footer }}
        </div>
    @endif
</div>
