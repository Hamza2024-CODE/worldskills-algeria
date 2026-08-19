@props([
    'title'       => '',
    'subtitle'    => '',
    'badge'       => null,
    'location'    => null,
])

<div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-white/10 mb-6">
    {{-- Ambient background light aura --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-400/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        
        <div class="space-y-2">
            {{-- Title --}}
            <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                {{ $title }}
            </h1>
            
            {{-- Subtitle --}}
            @if($subtitle)
                <p class="text-xs sm:text-sm text-blue-100/90 font-medium max-w-3xl leading-relaxed">
                    {{ $subtitle }} — أولمبياد المهن الجزائرية 2026.
                </p>
            @endif
        </div>

        {{-- Action Buttons Slot --}}
        @if(isset($slot) && $slot->isNotEmpty())
            <div class="flex items-center gap-3 flex-wrap shrink-0">
                {{ $slot }}
            </div>
        @endif

    </div>
</div>
