@php
    $siteLogo = app(\App\Services\SettingsEngine::class)->get('site_logo', '/logo.svg');
    $logoUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : asset($siteLogo);
    $locale = app()->getLocale();
@endphp

<!-- ═════════════════════════════════════════════════════════════════
     FOOTER CONTAINER WITH ORGANIC FLUID WAVE & KEN BURNS ARENA PHOTO
     ═════════════════════════════════════════════════════════════════ -->
<div class="relative w-full overflow-hidden bg-[#041235] text-white text-start mt-12 sm:mt-20">

    <style>
        @keyframes footerKenBurnsZoom {
            0% {
                transform: scale(1.0) translate3d(0, 0, 0);
            }
            50% {
                transform: scale(1.12) translate3d(-1%, -1%, 0);
            }
            100% {
                transform: scale(1.0) translate3d(0, 0, 0);
            }
        }
        .animate-footer-ken-burns {
            animation: footerKenBurnsZoom 22s ease-in-out infinite alternate;
            will-change: transform;
            transform-origin: center center;
        }
        @media (prefers-reduced-motion: reduce) {
            .animate-footer-ken-burns {
                animation: none !important;
                transform: none !important;
            }
        }
    </style>

    <!-- Official Ceremony Arena Photo Layer (Subtly Blended with Ken Burns Zoom In/Out) -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none bg-[#030d24]">
        <img
            src="{{ asset('images/footer_bg.jpg') }}"
            alt="WorldSkills Algeria Official Arena Ceremony"
            class="w-full h-full object-cover object-center opacity-45 filter brightness-85 contrast-115 saturate-110 animate-footer-ken-burns"
            loading="lazy"
            decoding="async"
        >
        <!-- Balanced Deep Navy Vignette & Atmosphere Gradient (Legible Text + Clearly Visible Arena) -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#041235]/85 via-[#041235]/65 to-[#020A24]/90"></div>
        <!-- WorldSkills Brand Cyan Ambient Radial Glow -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(0,184,255,0.12),transparent_75%)]"></div>
    </div>

    <!-- Organic Fluid Wave Divider seamlessly transitioning from the page above -->
    <div class="w-full overflow-hidden leading-none relative z-10 pointer-events-none -mt-px">
        <svg class="block w-full h-12 sm:h-20 lg:h-28 text-ws-bg fill-current" viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Atmospheric Translucent Ambient Wave Crest -->
            <path opacity="0.35" d="M0,0 L1440,0 L1440,30 C1200,80 980,15 720,55 C460,95 240,25 0,65 Z"/>
            <!-- Primary Organic Fluid Wave Cut -->
            <path d="M0,0 L1440,0 L1440,48 C1180,95 920,20 640,68 C360,116 160,35 0,78 Z"/>
        </svg>
    </div>

    <!-- Footer Content Grid -->
    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-4 sm:pt-6 pb-12" role="contentinfo">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-slate-700/60">

            <!-- Col 1: Brand & Venue Info -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <img src="{{ $logoUrl }}" alt="WorldSkills Logo" class="h-12 sm:h-14 w-auto object-contain brightness-0 invert filter drop-shadow-md">
                </div>
                <p class="text-xs text-slate-200 font-medium leading-relaxed drop-shadow-sm">
                    {{ $locale === 'fr' ? 'La plus grande compétition nationale et africaine des métiers et compétences professionnelles — Centre des Conventions Mohamed Benahmed à Oran.' : ($locale === 'en' ? 'The premier national and African vocational skills competition — Mohamed Benahmed Convention Center in Oran.' : 'التظاهرة الوطنية والأفريقية الأبرز لمهارات وتخصصات التعليم والتكوين المهني — مركز المؤتمرات محمد بن أحمد بمدينة وهران.') }}
                </p>
                <div class="inline-flex items-center gap-2 text-xs font-bold text-sky-300 bg-[#041235]/70 px-3 py-1.5 rounded-ws-sm border border-white/15 backdrop-blur-md shadow-sm">
                    <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    <span>{{ $locale === 'fr' ? 'CCO Oran — 25 au 30 Nov 2026' : ($locale === 'en' ? 'CCO Oran — Nov 25-30, 2026' : 'مركز المؤتمرات بوهران — 25 إلى 30 نوفمبر 2026') }}</span>
                </div>
            </div>

            <!-- Col 2: Competition Navigation -->
            <div>
                <h4 class="text-xs font-black text-white uppercase tracking-wider mb-4 border-s-2 border-ws-cyan ps-2.5 drop-shadow-sm">
                    {{ __('messages.competition') }}
                </h4>
                <ul class="space-y-2.5 text-xs text-slate-200 font-medium">
                    <li><a href="{{ route('skills') }}" class="hover:text-ws-cyan ws-transition drop-shadow-sm">{{ __('messages.skills') }}</a></li>
                    <li><a href="{{ route('schedule') }}" class="hover:text-ws-cyan ws-transition drop-shadow-sm">{{ __('messages.schedule') }}</a></li>
                    <li><a href="{{ route('results') }}" class="hover:text-ws-cyan ws-transition drop-shadow-sm">{{ __('messages.results') }}</a></li>
                    <li><a href="{{ route('events') }}" class="hover:text-ws-cyan ws-transition drop-shadow-sm">{{ __('messages.events') }}</a></li>
                    <li>
                        <a href="https://africaskills-policyforum.worldskills.dz/" target="_blank" rel="noopener noreferrer" class="text-amber-400 hover:text-amber-300 font-bold ws-transition flex items-center gap-1.5 drop-shadow-sm">
                            <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                            <span>{{ $locale === 'fr' ? 'Forum Politique 2026' : ($locale === 'en' ? 'Africa Policy Forum 2026' : 'منتدى السياسات الأفريقية 2026') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('live-tv') }}" target="_blank" class="text-rose-400 hover:text-rose-300 font-bold ws-transition flex items-center gap-1.5 drop-shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping shrink-0"></span>
                            <span>{{ $locale === 'fr' ? 'Direct TV (Écrans)' : ($locale === 'en' ? 'Live TV Broadcast' : 'شاشة البث المباشر (Live TV)') }}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 3: Guide, Verification & Legal -->
            <div>
                <h4 class="text-xs font-black text-white uppercase tracking-wider mb-4 border-s-2 border-ws-cyan ps-2.5 drop-shadow-sm">
                    {{ __('messages.guide') }}
                </h4>
                <ul class="space-y-2.5 text-xs text-slate-200 font-medium">
                    <li><a href="{{ route('guide') }}" class="hover:text-ws-cyan ws-transition drop-shadow-sm">{{ __('messages.guide') }}</a></li>
                    <li><a href="{{ route('regulations') }}" class="hover:text-ws-cyan ws-transition drop-shadow-sm">{{ __('messages.regulations') }}</a></li>
                    <li><a href="{{ route('verify') }}" class="hover:text-ws-cyan ws-transition font-bold text-emerald-400 drop-shadow-sm">{{ __('messages.verify_nav') }}</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-ws-cyan ws-transition drop-shadow-sm">{{ __('messages.faq') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-ws-cyan ws-transition drop-shadow-sm">{{ __('messages.contact') }}</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-ws-cyan ws-transition drop-shadow-sm">{{ __('messages.privacy') }}</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-ws-cyan ws-transition drop-shadow-sm">{{ __('messages.terms') }}</a></li>
                </ul>
            </div>

            <!-- Col 4: Newsletter & Subscription -->
            <div class="space-y-4">
                <h4 class="text-xs font-black text-white uppercase tracking-wider mb-2 border-s-2 border-ws-cyan ps-2.5 drop-shadow-sm">
                    {{ $locale === 'fr' ? 'Restez Informé' : ($locale === 'en' ? 'Stay Updated' : 'ابق على اطلاع دائم') }}
                </h4>
                <p class="text-xs text-slate-200 drop-shadow-sm">
                    {{ $locale === 'fr' ? 'Recevez les dernières actualités et résultats officiels.' : ($locale === 'en' ? 'Receive the latest news and official results.' : 'اشترك للحصول على آخر التحديثات والنتائج الرسمية.') }}
                </p>

                <form action="#" onsubmit="event.preventDefault(); alert('شكراً لاشتراكك!');" class="space-y-2">
                    <div class="relative">
                        <input
                            type="email"
                            placeholder="name@example.com"
                            class="w-full px-3.5 py-2.5 rounded-ws-sm bg-[#041235]/85 border border-slate-600/80 text-xs text-white placeholder-slate-400 ws-focus-ring backdrop-blur-md"
                            required
                        >
                    </div>
                    <button
                        type="submit"
                        class="w-full py-2.5 rounded-ws-sm bg-[#00B8FF] hover:bg-[#38C6FF] text-[#041235] font-black text-xs shadow-md ws-transition active:translate-y-[1px]"
                    >
                        {{ $locale === 'fr' ? "S'abonner" : ($locale === 'en' ? 'Subscribe' : 'اشتراك') }}
                    </button>
                </form>
            </div>

        </div>

        <!-- Bottom Copyright Bar -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-300">
            <div class="drop-shadow-sm">
                © {{ date('Y') }} {{ config('app.name', 'WorldSkills Algeria') }} — {{ $locale === 'fr' ? 'Tous droits réservés.' : ($locale === 'en' ? 'All rights reserved.' : 'جميع الحقوق محفوظة.') }}
            </div>

            <div class="flex items-center gap-4 text-slate-300 text-xs drop-shadow-sm">
                <span>الجمهورية الجزائرية الديمقراطية الشعبية</span>
                <span>•</span>
                <span>وزارة التكوين والتعليم المهنيين</span>
            </div>
        </div>
    </footer>
</div>
