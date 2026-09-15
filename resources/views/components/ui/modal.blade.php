@props([
    'name',
    'title' => null,
    'size' => 'lg', // sm, md, lg, xl, 2xl, full
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '4xl' => 'max-w-4xl',
        'full' => 'max-w-6xl',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['lg'];
@endphp

<div
    x-data="{ show: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center"
    role="dialog"
    aria-modal="true"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="show = false"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm ws-transition"
    ></div>

    {{-- Modal Box --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="bg-white rounded-ws-lg border border-ws-border shadow-2xl overflow-hidden w-full {{ $sizeClass }} relative z-10 my-8 text-ws-slate"
    >
        {{-- Header --}}
        @if($title || isset($header))
            <div class="px-6 py-4 border-b border-ws-border flex items-center justify-between bg-slate-50/50">
                <div class="font-black text-base sm:text-lg text-ws-navy">
                    {{ $header ?? $title }}
                </div>

                <button
                    type="button"
                    x-on:click="show = false"
                    class="p-1 rounded-ws-xs text-slate-400 hover:text-slate-700 hover:bg-slate-100 ws-transition"
                    aria-label="{{ __('messages.close') ?? 'Close' }}"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        {{-- Body --}}
        <div class="p-6">
            {{ $slot }}
        </div>

        {{-- Footer / Actions --}}
        @if(isset($actions))
            <div class="px-6 py-4 bg-slate-50 border-t border-ws-border flex items-center justify-end gap-3">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
