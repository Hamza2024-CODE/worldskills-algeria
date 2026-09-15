@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'icon' => null,
    'error' => null,
    'hint' => null,
    'required' => false,
])

<div class="space-y-1.5 w-full">
    @if($label)
        <label for="{{ $name }}" class="block text-xs font-bold text-ws-slate">
            {{ $label }}
            @if($required)
                <span class="text-ws-rose">*</span>
            @endif
        </label>
    @endif

    <div class="relative rounded-ws-sm shadow-2xs">
        @if($icon)
            <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none text-slate-400">
                {!! $icon !!}
            </div>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'block w-full rounded-ws-sm border ' .
                    ($error ? 'border-ws-rose text-ws-rose focus:ring-ws-rose focus:border-ws-rose ' : 'border-ws-border text-ws-slate focus:ring-ws-primary focus:border-ws-primary ') .
                    ($icon ? 'ps-10 pe-3.5 ' : 'px-3.5 ') .
                    'py-2 text-xs sm:text-sm bg-white placeholder-slate-400 ws-transition ws-focus-ring disabled:bg-slate-50 disabled:text-slate-400'
            ]) }}
        >
    </div>

    @if($error)
        <p class="text-xs text-ws-rose font-bold mt-1 flex items-center gap-1">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ $error }}</span>
        </p>
    @elseif($hint)
        <p class="text-xs text-slate-400 font-medium mt-1">{{ $hint }}</p>
    @endif
</div>
