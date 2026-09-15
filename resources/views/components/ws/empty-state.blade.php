@props([
    'icon'    => 'archive-box',
    'title'   => null,
    'message' => null,
    'action'  => null,
    'actionUrl' => '#',
])
<div class="flex flex-col items-center justify-center py-16 px-8 text-center space-y-4">
    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400"><x-ws.icon :name="$icon" class="w-8 h-8" /></div>
    @if($title)
        <h3 class="text-sm font-black text-slate-700">{{ $title }}</h3>
    @endif
    @if($message)
        <p class="text-xs font-medium text-slate-400 max-w-xs leading-relaxed">{{ $message }}</p>
    @endif
    @if($action)
        <a href="{{ $actionUrl }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-blue-600 transition-colors">
            {{ $action }}
        </a>
    @endif
    {{ $slot }}
</div>
