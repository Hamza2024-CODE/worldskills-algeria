@php
    $currentLocale = app()->getLocale();
    $tickerBadge = $currentLocale === 'fr' 
        ? (!empty($newsTickerBadgeFr) ? $newsTickerBadgeFr : 'Annonce Officielle | Forum 2026') 
        : ($currentLocale === 'en' 
            ? (!empty($newsTickerBadgeEn) ? $newsTickerBadgeEn : 'Official Announcement | Forum 2026') 
            : (!empty($newsTickerBadgeAr) ? $newsTickerBadgeAr : 'إعلان رسمي | منتدى 2026'));

    $tickerText = $currentLocale === 'fr' 
        ? (!empty($newsTickerTextFr) ? $newsTickerTextFr : 'Tenue du Forum sur les Politiques Africaines des Compétences 2026 en marge des Olympiades des Métiers — Centre des Conventions Oran') 
        : ($currentLocale === 'en' 
            ? (!empty($newsTickerTextEn) ? $newsTickerTextEn : 'The African Skills Policy Forum 2026 to be held concurrently with WorldSkills Algeria 2026 — Oran Convention Center') 
            : (!empty($newsTickerTextAr) ? $newsTickerTextAr : 'انعقاد منتدى السياسات الإفريقية للمهارات 2026 بالتزامن مع أولمبياد المهن الجزائرية — مركز المؤتمرات محمد بن أحمد وهران'));

    $tickerUrl = !empty($newsTickerUrl) ? $newsTickerUrl : 'https://africaskills-policyforum.worldskills.dz/';
    $tickerTheme = !empty($newsTickerTheme) ? $newsTickerTheme : 'royal_gradient';
    $tickerSpeed = !empty($newsTickerSpeed) ? $newsTickerSpeed : 'normal';
    $speedDuration = $tickerSpeed === 'fast' ? '18s' : ($tickerSpeed === 'slow' ? '45s' : '28s');
    
    $themeClasses = match($tickerTheme) {
        'electric_cyan'     => 'bg-gradient-to-r from-[#0052CC] via-[#00A3FF] to-[#00C4CC] border-cyan-300/40 text-white shadow-[0_12px_35px_rgba(0,196,204,0.25)]',
        'emerald_gold'      => 'bg-gradient-to-r from-[#006233] via-[#008744] to-[#D4AF37] border-amber-300/40 text-white shadow-[0_12px_35px_rgba(0,98,51,0.25)]',
        'dark_presidential' => 'bg-gradient-to-r from-[#020B1E] via-[#041A3A] to-[#0b2b5c] border-cyan-400/40 text-cyan-100 shadow-[0_12px_35px_rgba(0,0,0,0.35)]',
        default             => 'bg-gradient-to-r from-[#003B99] via-[#0052CC] to-[#00A3FF] border-cyan-400/30 text-white shadow-[0_12px_35px_rgba(0,82,204,0.22)]',
    };
@endphp

@if(($newsTickerEnabled ?? true) && !empty($tickerText))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-2 sm:-mt-3 mb-10 sm:mb-14">
    <style>
        @keyframes wsTickerFlowRTL {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(50%, 0, 0); }
        }
        @keyframes wsTickerFlowLTR {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-50%, 0, 0); }
        }
        .ws-ticker-track-rtl {
            animation: wsTickerFlowRTL {{ $speedDuration }} linear infinite;
        }
        .ws-ticker-track-ltr {
            animation: wsTickerFlowLTR {{ $speedDuration }} linear infinite;
        }
        .group\/ticker:hover .ws-ticker-track-rtl,
        .group\/ticker:hover .ws-ticker-track-ltr {
            animation-play-state: paused !important;
        }
    </style>

    <div class="relative rounded-2xl sm:rounded-3xl border overflow-hidden backdrop-blur-xl transition-all duration-500 hover:shadow-xl group/ticker cursor-pointer flex items-stretch {{ $themeClasses }}"
         onclick="window.open('{{ $tickerUrl }}', '_blank')">
        
        {{-- Stationary Badge Capsule (شارة الإعلان الثابتة مع نبض راداري) --}}
        <div class="relative z-20 px-4 sm:px-6 py-3.5 sm:py-4 bg-black/20 backdrop-blur-xl flex items-center gap-2.5 shrink-0 border-e border-white/20 shadow-md">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-400"></span>
            </span>
            
            <svg class="w-4 h-4 text-amber-300 shrink-0 hidden sm:block animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>

            <span class="text-xs sm:text-sm font-black tracking-wide uppercase whitespace-nowrap text-white drop-shadow-xs">
                {{ $tickerBadge }}
            </span>
        </div>

        {{-- Moving Marquee Ticker Track --}}
        <div class="relative flex-1 overflow-hidden py-3 sm:py-3.5 flex items-center min-w-0" dir="{{ $currentLocale === 'ar' ? 'rtl' : 'ltr' }}">
            
            {{-- Fade Edges --}}
            <div class="absolute inset-y-0 start-0 w-8 sm:w-12 bg-gradient-to-r from-black/10 to-transparent pointer-events-none z-10"></div>
            <div class="absolute inset-y-0 end-0 w-8 sm:w-12 bg-gradient-to-l from-black/10 to-transparent pointer-events-none z-10"></div>

            <div class="flex items-center whitespace-nowrap will-change-transform {{ $currentLocale === 'ar' ? 'ws-ticker-track-rtl' : 'ws-ticker-track-ltr' }}">
                @for($t = 0; $t < 4; $t++)
                <div class="flex items-center gap-6 sm:gap-8 shrink-0 px-4 sm:px-6">
                    <span class="text-xs sm:text-sm font-black tracking-normal text-white/95 drop-shadow-xs hover:text-white transition-colors">
                        {{ $tickerText }}
                    </span>

                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 hover:bg-white/30 text-white text-[11px] font-black backdrop-blur-md shadow-xs transition-transform group-hover/ticker:scale-105 shrink-0">
                        <span>{{ $currentLocale === 'fr' ? 'Détails du Forum' : ($currentLocale === 'en' ? 'Forum Details' : 'تفاصيل المنتدى') }}</span>
                        <svg class="w-3.5 h-3.5 {{ $currentLocale === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>

                    <x-ws.icon name="sparkles" class="w-3 h-3 text-cyan-300 inline-block me-1 opacity-70" />
                </div>
                @endfor
            </div>

        </div>

    </div>
</div>
@endif
