@props([
    'title' => 'لا توجد بيانات',
    'description' => null,
    'icon' => null,
    'actionText' => null,
    'actionHref' => null,
    'actionWireClick' => null,
])

<div {{ $attributes->merge(['class' => 'p-8 sm:p-12 text-center flex flex-col items-center justify-center rounded-ws-md border border-dashed border-slate-200 bg-slate-50/50']) }}>
    <div class="w-14 h-14 rounded-full bg-slate-100 border border-slate-200 text-slate-400 flex items-center justify-center mb-4">
        @if($icon)
            {!! $icon !!}
        @else
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        @endif
    </div>

    <h3 class="font-black text-sm sm:text-base text-ws-slate mb-1">
        {{ $title }}
    </h3>

    @if($description)
        <p class="text-xs sm:text-sm text-slate-400 font-medium max-w-sm mb-5 leading-relaxed">
            {{ $description }}
        </p>
    @endif

    @if($actionText)
        <x-ui.button
            variant="primary"
            size="sm"
            :href="$actionHref"
            :wire:click="$actionWireClick"
        >
            {{ $actionText }}
        </x-ui.button>
    @endif

    {{ $slot }}
</div>
