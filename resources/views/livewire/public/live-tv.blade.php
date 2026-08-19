<div class="h-screen w-screen flex flex-col bg-[#F8FAFC] relative overflow-hidden text-start font-sans"
     x-data="{
        currentSlide: 0,
        slides: {{ $slides->count() }},
        init() {
            if (this.slides > 0) {
                setInterval(() => {
                    this.currentSlide = (this.currentSlide + 1) % Math.max(this.slides, 1);
                }, 10000);
            }
        }
     }">

    {{-- Ambient Light Glow Blobs in Brand Blue & Sky Blue --}}
    <div class="absolute -top-40 -right-40 w-[45rem] h-[45rem] bg-[#0066FF]/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-[45rem] h-[45rem] bg-[#00A3FF]/15 rounded-full blur-3xl pointer-events-none"></div>

    {{-- ============================================================ --}}
    {{-- TOP BAR: Brand Header (White & Blue Theme)                    --}}
    {{-- ============================================================ --}}
    <div class="relative z-20 flex items-center justify-between px-8 py-4 bg-white border-b border-slate-200 shadow-sm shrink-0">
        <div class="flex items-center gap-4">
            @php
                $siteLogo = app(\App\Services\SettingsEngine::class)->get('site_logo', '/logo.svg');
                $logoUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : asset($siteLogo);
            @endphp
            <img src="{{ $logoUrl }}" alt="WorldSkills Algeria Logo" class="h-11 w-auto object-contain">
            <div>
                <h1 class="text-lg font-black text-[#06205C] tracking-wide leading-none">WorldSkills Algeria</h1>
                <p class="text-[11px] font-bold text-[#0066FF] tracking-wider uppercase mt-1">منصة البث المباشر والشاشات التلفزيونية الرسمية</p>
            </div>
        </div>

        {{-- Live Badge & Clock --}}
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-rose-600 text-white shadow-md border border-rose-500/50 animate-pulse">
                <span class="w-2.5 h-2.5 rounded-full bg-white animate-ping"></span>
                <span class="text-xs font-black tracking-widest uppercase">LIVE BROADCAST</span>
            </div>
            <div class="text-base font-mono font-black text-[#06205C] bg-slate-100 px-4 py-2 rounded-2xl border border-slate-200 shadow-inner" 
                 x-data="{ t: '' }" 
                 x-init="setInterval(() => { const d = new Date(); t = d.toLocaleTimeString('ar-DZ', {hour12: false}); }, 1000)" 
                 x-text="t"></div>
        </div>

        {{-- Active Edition --}}
        <div class="text-right hidden sm:block">
            <div class="text-sm font-black text-[#06205C]">{{ $edition?->getLocalized('name') ?? 'WorldSkills Algeria 2026 / 2027' }}</div>
            <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">OFFICIAL LIVE STREAM STAGE</div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MAIN FULL-SCREEN BROADCAST STAGE (White & Blue Layout Only)  --}}
    {{-- ============================================================ --}}
    <div class="flex-1 bg-white relative z-20 flex flex-col items-center justify-center p-4 sm:p-8 overflow-hidden shadow-inner border-b border-slate-200">

        @php
            $embedUrl = null;
            if (!empty($liveStreamUrl)) {
                if (str_contains($liveStreamUrl, 'youtube.com/watch?v=')) {
                    $vId = explode('v=', $liveStreamUrl)[1] ?? '';
                    $vId = explode('&', $vId)[0];
                    $embedUrl = "https://www.youtube.com/embed/{$vId}?autoplay=1&mute=1&enablejsapi=1&controls=1";
                } elseif (str_contains($liveStreamUrl, 'youtu.be/')) {
                    $vId = explode('youtu.be/', $liveStreamUrl)[1] ?? '';
                    $vId = explode('?', $vId)[0];
                    $embedUrl = "https://www.youtube.com/embed/{$vId}?autoplay=1&mute=1&enablejsapi=1&controls=1";
                } elseif (str_contains($liveStreamUrl, 'youtube.com/embed/')) {
                    $embedUrl = $liveStreamUrl;
                } else {
                    $embedUrl = $liveStreamUrl;
                }
            }
        @endphp

        @if($embedUrl)
            {{-- 1. DYNAMIC LIVE VIDEO STREAM EMBED STAGE --}}
            <div class="w-full h-full max-w-7xl mx-auto rounded-3xl overflow-hidden shadow-2xl border-4 border-blue-500/20 bg-black relative">
                <iframe src="{{ $embedUrl }}" 
                        title="WorldSkills Algeria Live Stream" 
                        class="w-full h-full border-0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen></iframe>
            </div>

        @elseif($slides->isNotEmpty())
            {{-- 2. ROTATING CUSTOM PRESENTATION SLIDES STAGE --}}
            @foreach($slides as $idx => $slide)
                <div x-show="currentSlide === {{ $idx }}" 
                     x-transition:enter="transition ease-out duration-700 transform"
                     x-transition:enter-start="opacity-0 scale-95" 
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute inset-0 flex flex-col items-center justify-center p-8 sm:p-16 text-center space-y-6 max-w-5xl mx-auto">
                    
                    <span class="text-xs font-black text-[#0066FF] uppercase tracking-widest px-4 py-1.5 rounded-full bg-blue-50 border border-blue-200 inline-block shadow-xs">
                        ✦ {{ $slide->slide_type }}
                    </span>
                    
                    <h2 class="text-4xl sm:text-6xl font-black text-[#06205C] leading-tight drop-shadow-xs max-w-4xl">
                        {{ $slide->title_ar }}
                    </h2>
                    
                    @if($slide->content)
                        <p class="text-lg sm:text-2xl text-slate-600 font-medium leading-relaxed max-w-3xl">
                            {{ $slide->content }}
                        </p>
                    @endif
                    
                    @if($slide->image_url)
                        <div class="mt-4 p-3 bg-slate-50 rounded-3xl border border-slate-200 shadow-2xl">
                            <img src="{{ $slide->image_url }}" alt="{{ $slide->title_ar }}" class="max-h-72 object-contain rounded-2xl">
                        </div>
                    @endif
                </div>
            @endforeach

            {{-- Slide Dot Navigation --}}
            <div class="absolute bottom-8 flex items-center gap-3 z-30">
                @foreach($slides as $idx => $slide)
                    <button @click="currentSlide = {{ $idx }}"
                        class="h-3 rounded-full transition-all duration-500 shadow-sm"
                        :class="currentSlide === {{ $idx }} ? 'bg-[#0066FF] w-10' : 'bg-slate-300 w-3 hover:bg-blue-400'">
                    </button>
                @endforeach
            </div>

        @else
            {{-- 3. STANDARD LIVE STREAM PRESENTATION STAGE --}}
            <div class="text-center space-y-8 max-w-4xl mx-auto">
                <div class="relative inline-block">
                    <div class="w-32 h-32 rounded-3xl bg-blue-50 border-2 border-blue-200 flex items-center justify-center mx-auto shadow-xl transform hover:rotate-3 transition-transform">
                        <img src="{{ $logoUrl }}" alt="WorldSkills Algeria" class="h-20 w-auto object-contain">
                    </div>
                    <span class="absolute -top-2 -end-2 w-6 h-6 rounded-full bg-rose-600 text-white text-[10px] font-black flex items-center justify-center border-2 border-white shadow-md animate-bounce">LIVE</span>
                </div>

                <div class="space-y-3">
                    <h1 class="text-4xl sm:text-6xl font-black text-[#06205C] tracking-tight leading-tight">
                        WorldSkills Algeria
                    </h1>
                    <h2 class="text-2xl sm:text-3xl font-black text-[#0066FF]">
                        البث المباشر لأولمبياد المهن الوطنية والإفريقية 2026
                    </h2>
                </div>

                <div class="w-48 h-1.5 bg-gradient-to-r from-[#0066FF] via-[#00A3FF] to-blue-400 mx-auto rounded-full shadow-md"></div>

                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 shadow-md max-w-xl mx-auto space-y-2">
                    <p class="text-sm font-black text-[#06205C] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>المركز الدولي للمؤتمرات عبد اللطيف رحال (CIC) — الجزائر العاصمة</span>
                    </p>
                    <p class="text-xs text-slate-500 font-bold">
                        تغطية مباشرة وشاملة للتصفيات والورش التقنية في المهن الـ 64 الرسمية.
                    </p>
                </div>
            </div>
        @endif

    </div>

    {{-- ============================================================ --}}
    {{-- BOTTOM TICKER BAR (Brand Blue Theme)                          --}}
    {{-- ============================================================ --}}
    <div class="relative z-20 h-14 bg-[#06205C] text-white border-t border-slate-300 flex items-center overflow-hidden shrink-0 shadow-2xl">
        <div class="shrink-0 bg-[#0066FF] px-6 h-full flex items-center gap-2 text-xs font-black tracking-widest uppercase whitespace-nowrap shadow-md">
            <span class="w-2.5 h-2.5 rounded-full bg-white animate-ping"></span>
            <span>تنبيهات البث</span>
        </div>
        <div class="flex-1 overflow-hidden">
            @if($announcements->isNotEmpty())
                <div class="animate-ticker whitespace-nowrap text-xs sm:text-sm font-black text-white">
                    @foreach($announcements as $ann)
                        <span class="mx-10">{{ $ann->ticker_text_ar }}</span>
                        <span class="mx-4 text-[#00A3FF]">◆</span>
                    @endforeach
                    {{-- Repeat for seamless loop --}}
                    @foreach($announcements as $ann)
                        <span class="mx-10">{{ $ann->ticker_text_ar }}</span>
                        <span class="mx-4 text-[#00A3FF]">◆</span>
                    @endforeach
                </div>
            @else
                <div class="animate-ticker whitespace-nowrap text-xs sm:text-sm font-black text-white">
                    <span class="mx-10">مرحباً بكم في البث المباشر الرسمي لأولمبياد المهن الوطنية — WorldSkills Algeria 2026</span>
                    <span class="mx-4 text-[#00A3FF]">◆</span>
                    <span class="mx-10">Bienvenue au direct officiel des Olympiades des Métiers — WorldSkills Algeria 2026</span>
                    <span class="mx-4 text-[#00A3FF]">◆</span>
                    <span class="mx-10">Welcome to the Official Live Stream — WorldSkills Algeria 2026</span>
                    <span class="mx-4 text-[#00A3FF]">◆</span>
                </div>
            @endif
        </div>
    </div>

</div>
