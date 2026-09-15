@props([
    'status'  => 'loading', // 'loading' | 'error'
    'message' => null,
])
<div class="flex flex-col items-center justify-center py-12 space-y-4">
    @if($status === 'loading')
        <div class="flex gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay:0ms"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-blue-400 animate-bounce" style="animation-delay:150ms"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-blue-300 animate-bounce" style="animation-delay:300ms"></span>
        </div>
        <p class="text-xs font-bold text-slate-400">{{ $message ?? __('جارٍ التحميل...') }}</p>
    @else
        <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500"><x-ws.icon name="exclamation-triangle" class="w-6 h-6" /></div>
        <p class="text-xs font-bold text-rose-600">{{ $message ?? __('حدث خطأ غير متوقع.') }}</p>
        {{ $slot }}
    @endif
</div>
