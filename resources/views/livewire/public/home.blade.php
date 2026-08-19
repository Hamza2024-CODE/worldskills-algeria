<div class="pb-16" x-data="{ showVideoModal: false }">
@php
    $activeEvent = $activeEvent ?? null;
    $stats = $stats ?? [];
    $countdownEnabled = $countdownEnabled ?? true;
    $countdownStatus = $countdownStatus ?? 'COUNTDOWN';
    $countdownTargetDate = $countdownTargetDate ?? '2026-09-15 09:00:00';
    $countdownFlipAnimation = $countdownFlipAnimation ?? true;
    $countdownColorSec = $countdownColorSec ?? '#0284C7';
    $countdownColorMin = $countdownColorMin ?? '#059669';
    $countdownColorHrs = $countdownColorHrs ?? '#D97706';
    $countdownColorDays = $countdownColorDays ?? '#7C3AED';
    $countdownTitleFr = $countdownTitleFr ?? 'Décompte du Lancement des Olympiades des Métiers 2026';
    $countdownTitleEn = $countdownTitleEn ?? 'Countdown to the Opening of the 2026 Olympiad of Professions';
    $countdownTitleAr = $countdownTitleAr ?? 'العد التنازلي لافتتاح أولمبياد المهن 2026';
    $countdownSubtitleFr = $countdownSubtitleFr ?? 'Olympiades des Métiers 2026 — Centre des Conventions Mohamed Benahmed - Oran';
    $countdownSubtitleEn = $countdownSubtitleEn ?? 'Olympiad of Professions 2026 — Mohamed Benahmed Convention Center - Oran';
    $countdownSubtitleAr = $countdownSubtitleAr ?? 'أولمبياد المهن 2026 — مركز المؤتمرات محمد بن أحمد - وهران';
@endphp
    
    <style>
        @keyframes heroFadeInUp {
            0% {
                opacity: 0;
                transform: translateY(25px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes heroGlowPulse {
            0%, 100% {
                text-shadow: 0 4px 24px rgba(0,0,0,0.95), 0 0 15px rgba(0, 163, 255, 0.3);
            }
            50% {
                text-shadow: 0 4px 28px rgba(0,0,0,0.98), 0 0 35px rgba(0, 163, 255, 0.7);
            }
        }
        .animate-hero-title {
            animation: heroFadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards, heroGlowPulse 4s ease-in-out infinite 1s;
            transition: color 0.5s ease, text-shadow 0.5s ease;
        }
        .animate-hero-sub {
            opacity: 0;
            animation: heroFadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards;
            transition: color 0.5s ease, text-shadow 0.5s ease;
        }
        .animate-hero-btns {
            opacity: 0;
            animation: heroFadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) 0.55s forwards;
        }
        .hero-text-block {
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .hero-text-block:hover {
            transform: translateY(-6px);
        }
        .hero-text-block:hover .animate-hero-title {
            color: #FCD34D !important;
            text-shadow: 0 8px 32px rgba(252, 211, 77, 0.55), 0 0 40px rgba(0, 163, 255, 0.85) !important;
        }
        .hero-text-block:hover .animate-hero-sub {
            color: #FFFFFF !important;
            text-shadow: 0 4px 20px rgba(0,0,0,0.98) !important;
        }
    </style>

    <!-- 1. Hero Section with Full-Bleed High-Definition Video Background -->
    <section class="relative bg-[#020A24] text-white min-h-[70vh] sm:min-h-[78vh] py-20 sm:py-32 px-4 sm:px-6 lg:px-8 overflow-hidden rounded-b-[3rem] border-b border-brand-500/20 shadow-2xl flex items-center">
        
        <!-- Full-Bleed 100% Seamless Cover Video Background Layer (Expands to cover full space) -->
        <div class="absolute inset-0 z-0 overflow-hidden opacity-90 pointer-events-none">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200vw] h-[200vh] min-w-[177.77vh] min-h-[56.25vw]">
                <iframe class="w-full h-full pointer-events-none object-cover" 
                        src="https://www.youtube-nocookie.com/embed/nzy4f7GBSVw?autoplay=1&mute=1&controls=0&loop=1&playlist=nzy4f7GBSVw&playsinline=1&rel=0&modestbranding=1&enablejsapi=1&iv_load_policy=3&disablekb=1&showinfo=0&vq=hd1080" 
                        title="WorldSkills Background Video HD" 
                        frameborder="0" 
                        allow="autoplay; encrypted-media"></iframe>
            </div>
            <!-- Elegant Light Cinematic Gradient Overlay for Maximum Text Legibility & Video Clarity -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#020A24] via-[#020A24]/40 to-black/20"></div>
        </div>

        <!-- Dynamic Animated Ambient Glow Particles -->
        <div class="absolute -top-24 -left-24 w-[32rem] h-[32rem] bg-brand-sky/20 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-[32rem] h-[32rem] bg-brand-500/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="max-w-7xl mx-auto w-full relative z-10 text-right space-y-6">

            <!-- Animated Interactive Typography Section -->
            <div class="hero-text-block space-y-4 max-w-4xl cursor-pointer">
                
                <!-- Main Title: Smooth Entrance + Pulse Glow + Hover Golden Glow -->
                <h1 class="animate-hero-title text-2xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-[1.25] text-white">
                    {{ $activeEvent ? $activeEvent->getLocalized('title') : __('messages.hero_title') }}
                </h1>

                <!-- Subtitle: Staggered Fade Up + Hover White Highlight -->
                <p class="animate-hero-sub text-sm sm:text-lg text-slate-100 font-semibold leading-relaxed drop-shadow-[0_2px_14px_rgba(0,0,0,0.95)] max-w-3xl">
                    {{ $activeEvent ? $activeEvent->getLocalized('summary') : __('messages.hero_subtitle') }}
                </p>

            </div>

            <!-- Action Buttons Grid: Animated Entrance -->
            <div class="animate-hero-btns flex flex-wrap items-center gap-4 pt-4">
                <a href="{{ route('guide') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-black text-sm shadow-xl shadow-brand-500/30 transition-all transform hover:-translate-y-1 hover:scale-[1.02] active:scale-95">
                    {{ __('messages.explore_more') }}
                </a>

                <a href="{{ route('registration') }}" class="px-8 py-4 rounded-2xl bg-white hover:bg-slate-100 text-[#06205C] font-black text-sm shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-1 hover:scale-[1.02] active:scale-95">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>{{ __('messages.register_now') }}</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 2. WSAP V8.4 — Vintage 3D Spiral Paper Notebook Chronometer Section -->
    @if($countdownEnabled && $countdownStatus !== 'DISABLED')
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-10 relative" 
             wire:ignore 
             id="wsap-countdown-widget" 
             data-target-timestamp="{{ strtotime($countdownTargetDate ?? '2026-09-15 09:00:00') * 1000 }}"
             data-flip-anim="{{ $countdownFlipAnimation ? '1' : '0' }}">
        
        <style>
            #wsap-countdown-widget {
                --sec-bg: {{ $countdownColorSec }};
                --min-bg: {{ $countdownColorMin }};
                --hrs-bg: {{ $countdownColorHrs }};
                --days-bg: {{ $countdownColorDays }};
            }
            #card-box-sec { background-color: var(--sec-bg); }
            #card-box-min { background-color: var(--min-bg); }
            #card-box-hrs { background-color: var(--hrs-bg); }
            #card-box-days { background-color: var(--days-bg); }

            @keyframes wsapPaperLeafFold {
                0% {
                    transform: perspective(600px) rotateX(0deg) translateY(0) scale(1);
                    filter: brightness(1);
                }
                40% {
                    transform: perspective(600px) rotateX(-45deg) translateY(-6px) scale(0.93);
                    filter: brightness(1.25);
                    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.35);
                }
                75% {
                    transform: perspective(600px) rotateX(15deg) translateY(2px) scale(1.03);
                    filter: brightness(0.95);
                }
                100% {
                    transform: perspective(600px) rotateX(0deg) translateY(0) scale(1);
                    filter: brightness(1);
                }
            }

            .wsap-paper-flip-3d {
                animation: wsapPaperLeafFold 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
                transform-origin: center top !important;
                will-change: transform, filter, box-shadow;
            }
        </style>

        <!-- Spiral Binder Rings at Top Edge -->
        <div class="flex items-center justify-around px-8 -mb-4 relative z-30 pointer-events-none">
            @for($i = 0; $i < 14; $i++)
                <div class="flex flex-col items-center">
                    <div class="w-2.5 sm:w-3.5 h-7 sm:h-9 bg-gradient-to-r from-slate-400 via-slate-200 to-slate-500 rounded-full shadow-md border border-slate-400/80"></div>
                </div>
            @endfor
        </div>

        <!-- Main Vintage Paper Sheet Card Container -->
        <div class="bg-[#FDFBF7] dark:bg-[#F9F6EE] rounded-3xl p-6 sm:p-12 shadow-[0_25px_70px_rgba(6,32,92,0.15)] border-2 border-[#EADFC9] relative overflow-hidden text-slate-900">
            
            <!-- Background Decorative Watermark Elements -->
            <!-- 1. Postal Stamp Mark Top-Right -->
            <div class="absolute top-4 right-4 sm:top-8 sm:right-8 w-24 h-24 sm:w-32 sm:h-32 border-2 border-red-800/25 rounded-full flex flex-col items-center justify-center p-2 transform rotate-12 pointer-events-none select-none">
                <span class="text-[9px] sm:text-[10px] font-black text-red-900/40 uppercase tracking-widest text-center leading-tight">ALGERIA 2026<br>WORLDSKILLS</span>
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-red-900/30 my-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>
                <span class="text-[8px] font-mono text-red-900/40">OFFICIAL STAMP</span>
            </div>

            <!-- 2. Monument Sketch Watermark (مقام الشهيد) Bottom-Left -->
            <div class="absolute -bottom-6 -left-6 opacity-[0.08] pointer-events-none select-none">
                <svg class="w-48 h-48 sm:w-64 sm:h-64 text-[#06205C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 2L9 9l-7 3 7 3 3 7 3-7 7-3-7-3-3-9zM12 22V12"/>
                </svg>
            </div>

            <!-- 3. Paper Curl Corner Accent (Right Edge) -->
            <div class="absolute bottom-0 right-0 w-16 h-16 bg-gradient-to-bl from-amber-200/60 to-transparent border-t border-l border-amber-300/40 rounded-tl-3xl shadow-xs pointer-events-none"></div>

            <!-- Top Left Paper Clip & Post-It Live Clock Badge -->
            <div class="absolute top-6 left-6 z-20 hidden sm:flex flex-col items-center">
                <!-- Metallic Paperclip -->
                <div class="w-4 h-9 border-2 border-slate-500 rounded-full shadow-xs -mb-3 z-30 bg-slate-300/40 backdrop-blur-xs"></div>
                <!-- Post-It Card -->
                <div class="bg-amber-100/90 border border-amber-300 shadow-md rounded-xl p-2.5 text-center transform -rotate-3 text-slate-800 w-28">
                    <div class="flex items-center justify-center gap-1 text-[10px] font-black text-rose-600 mb-0.5">
                        <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping"></span>
                        <span>مباشر</span>
                    </div>
                    <div id="wsap-live-clock" class="font-mono text-xs font-black text-slate-900 leading-tight">14:30:22</div>
                    <div id="wsap-live-date" class="text-[9px] font-bold text-slate-600 mt-0.5 leading-none">16 - 21 نوفمبر 2026</div>
                </div>
            </div>

            <!-- Center Logo & Titles -->
            <div class="text-center space-y-2 mb-8 relative z-10 pt-2">
                <img src="/logo.svg" alt="WorldSkills Algeria 2026" class="h-12 sm:h-16 w-auto mx-auto drop-shadow-xs mb-3">
                <h3 class="text-lg sm:text-2xl font-black text-[#06205C] tracking-tight">
                    @if(app()->getLocale() === 'fr')
                        {{ $countdownTitleFr }}
                    @elseif(app()->getLocale() === 'en')
                        {{ $countdownTitleEn }}
                    @else
                        {{ $countdownTitleAr }}
                    @endif
                </h3>
                <div class="flex items-center justify-center gap-2 text-xs font-bold text-slate-600">
                    <span class="text-amber-500">★</span>
                    <span>
                        @if(app()->getLocale() === 'fr')
                            {{ $countdownSubtitleFr }}
                        @elseif(app()->getLocale() === 'en')
                            {{ $countdownSubtitleEn }}
                        @else
                            {{ $countdownSubtitleAr }}
                        @endif
                    </span>
                    <span class="text-amber-500">★</span>
                </div>
            </div>

            <!-- 4 Vibrant 3D Split-Flap Cards Grid -->
            <div class="grid grid-cols-4 gap-3 sm:gap-6 text-center relative z-10">
                
                <!-- 1. SECONDS CARD (Electric Blue) -->
                <div class="space-y-2">
                    <div id="card-box-sec" 
                         class="relative p-3 sm:p-6 rounded-2xl border-2 border-white/40 shadow-[0_12px_25px_rgba(2,132,197,0.3)] overflow-hidden min-h-[95px] sm:min-h-[125px] flex flex-col items-center justify-center group">
                        
                        <!-- Top Flap Shade for 3D Split-Flap Effect -->
                        <div class="absolute inset-x-0 top-0 h-1/2 bg-black/15 z-10 pointer-events-none rounded-t-2xl"></div>
                        <!-- Crease Line -->
                        <div class="absolute inset-x-0 top-1/2 h-[1px] bg-black/25 shadow-[0_1px_2px_rgba(0,0,0,0.3)] z-20 pointer-events-none"></div>

                        <span id="cd-seconds" class="text-3xl sm:text-6xl font-mono font-black text-white block tracking-widest relative z-10 drop-shadow-md">{{ $eventCountdown['seconds'] ?? '24' }}</span>
                    </div>
                    
                    <div class="space-y-0.5">
                        <span class="text-xs sm:text-sm font-black text-slate-800 block uppercase tracking-wider">{{ __('messages.seconds') }}</span>
                        <span class="text-[9px] sm:text-[10px] font-extrabold text-slate-500 block tracking-widest">SECONDS</span>
                    </div>
                </div>

                <!-- 2. MINUTES CARD (Emerald Teal) -->
                <div class="space-y-2">
                    <div id="card-box-min" 
                         class="relative p-3 sm:p-6 rounded-2xl border-2 border-white/40 shadow-[0_12px_25px_rgba(5,150,105,0.3)] overflow-hidden min-h-[95px] sm:min-h-[125px] flex flex-col items-center justify-center group">
                        
                        <div class="absolute inset-x-0 top-0 h-1/2 bg-black/15 z-10 pointer-events-none rounded-t-2xl"></div>
                        <div class="absolute inset-x-0 top-1/2 h-[1px] bg-black/25 shadow-[0_1px_2px_rgba(0,0,0,0.3)] z-20 pointer-events-none"></div>

                        <span id="cd-minutes" class="text-3xl sm:text-6xl font-mono font-black text-white block tracking-widest relative z-10 drop-shadow-md">{{ $eventCountdown['minutes'] ?? '58' }}</span>
                    </div>
                    
                    <div class="space-y-0.5">
                        <span class="text-xs sm:text-sm font-black text-slate-800 block uppercase tracking-wider">{{ __('messages.minutes') }}</span>
                        <span class="text-[9px] sm:text-[10px] font-extrabold text-slate-500 block tracking-widest">MINUTES</span>
                    </div>
                </div>

                <!-- 3. HOURS CARD (Amber Gold) -->
                <div class="space-y-2">
                    <div id="card-box-hrs" 
                         class="relative p-3 sm:p-6 rounded-2xl border-2 border-white/40 shadow-[0_12px_25px_rgba(217,119,6,0.3)] overflow-hidden min-h-[95px] sm:min-h-[125px] flex flex-col items-center justify-center group">
                        
                        <div class="absolute inset-x-0 top-0 h-1/2 bg-black/15 z-10 pointer-events-none rounded-t-2xl"></div>
                        <div class="absolute inset-x-0 top-1/2 h-[1px] bg-black/25 shadow-[0_1px_2px_rgba(0,0,0,0.3)] z-20 pointer-events-none"></div>

                        <span id="cd-hours" class="text-3xl sm:text-6xl font-mono font-black text-white block tracking-widest relative z-10 drop-shadow-md">{{ $eventCountdown['hours'] ?? '00' }}</span>
                    </div>
                    
                    <div class="space-y-0.5">
                        <span class="text-xs sm:text-sm font-black text-slate-800 block uppercase tracking-wider">{{ __('messages.hours') }}</span>
                        <span class="text-[9px] sm:text-[10px] font-extrabold text-slate-500 block tracking-widest">HOURS</span>
                    </div>
                </div>

                <!-- 4. DAYS CARD (Deep Purple) -->
                <div class="space-y-2">
                    <div id="card-box-days" 
                         class="relative p-3 sm:p-6 rounded-2xl border-2 border-white/40 shadow-[0_12px_25px_rgba(124,58,237,0.3)] overflow-hidden min-h-[95px] sm:min-h-[125px] flex flex-col items-center justify-center group">
                        
                        <div class="absolute inset-x-0 top-0 h-1/2 bg-black/15 z-10 pointer-events-none rounded-t-2xl"></div>
                        <div class="absolute inset-x-0 top-1/2 h-[1px] bg-black/25 shadow-[0_1px_2px_rgba(0,0,0,0.3)] z-20 pointer-events-none"></div>

                        <span id="cd-days" class="text-3xl sm:text-6xl font-mono font-black text-white block tracking-widest relative z-10 drop-shadow-md">{{ $eventCountdown['days'] ?? '29' }}</span>
                    </div>
                    
                    <div class="space-y-0.5">
                        <span class="text-xs sm:text-sm font-black text-slate-800 block uppercase tracking-wider">{{ __('messages.days') }}</span>
                        <span class="text-[9px] sm:text-[10px] font-extrabold text-slate-500 block tracking-widest">DAYS</span>
                    </div>
                </div>

            </div>
        </div>

        <script>
            (function initWsapChronometer() {
                var widgetEl = document.getElementById('wsap-countdown-widget');
                var targetAttr = widgetEl ? widgetEl.getAttribute('data-target-timestamp') : null;
                var allowFlip = widgetEl ? widgetEl.getAttribute('data-flip-anim') !== '0' : true;
                var targetTime = targetAttr ? parseInt(targetAttr, 10) : (Date.now() + 2500000000);
                
                function triggerPaperFold(boxId) {
                    var box = document.getElementById(boxId);
                    if (box) {
                        box.classList.remove('wsap-paper-flip-3d');
                        void box.offsetWidth;
                        box.classList.add('wsap-paper-flip-3d');
                        setTimeout(function() {
                            box.classList.remove('wsap-paper-flip-3d');
                        }, 450);
                    }
                }

                function tickWsapClock() {
                    var now = Date.now();
                    
                    // Update Post-It Real-Time Clock
                    var dObj = new Date();
                    var clockEl = document.getElementById('wsap-live-clock');
                    if (clockEl) {
                        clockEl.textContent = dObj.toTimeString().split(' ')[0];
                    }

                    var diff = targetTime - now;
                    if (isNaN(diff) || diff <= 0) diff = Math.abs(diff);
                    if (isNaN(diff) || diff <= 0) diff = 2500000000;

                    var d = String(Math.floor(diff / 86400000)).padStart(2, '0');
                    var h = String(Math.floor((diff % 86400000) / 3600000)).padStart(2, '0');
                    var m = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
                    var s = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');

                    var elD = document.getElementById('cd-days');
                    var elH = document.getElementById('cd-hours');
                    var elM = document.getElementById('cd-minutes');
                    var elS = document.getElementById('cd-seconds');

                    if (elD && elD.textContent !== d) { elD.textContent = d; triggerPaperFold('card-box-days'); }
                    if (elH && elH.textContent !== h) { elH.textContent = h; triggerPaperFold('card-box-hrs'); }
                    if (elM && elM.textContent !== m) { elM.textContent = m; triggerPaperFold('card-box-min'); }
                    if (elS && elS.textContent !== s) { elS.textContent = s; triggerPaperFold('card-box-sec'); }
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', tickWsapClock);
                } else {
                    tickWsapClock();
                }
                setInterval(tickWsapClock, 1000);
            })();
        </script>
    </section>
    @endif

    <!-- 3. Dynamic Real DB Statistics Grid with Image Logos, Text & Animated Counters -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <x-animated-counter :target="!empty($stats['partners']) ? $stats['partners'] : 10" :label="app()->getLocale() === 'fr' ? 'Partenaires Officiels' : (app()->getLocale() === 'en' ? 'Official Partners' : 'الشركاء والرعاة')" :description="app()->getLocale() === 'fr' ? 'Soutien industriel & institutionnel' : (app()->getLocale() === 'en' ? 'Industrial & Institutional Support' : 'الدعم الصناعي والمؤسساتي')" image="/logo.svg" color="text-brand-500" />
            <x-animated-counter :target="!empty($stats['organizations']) ? $stats['organizations'] : 150" :label="app()->getLocale() === 'fr' ? 'Centres de Formation' : (app()->getLocale() === 'en' ? 'Training Institutes' : 'المؤسسات التدريبية')" :description="app()->getLocale() === 'fr' ? 'Instituts & Établissements' : (app()->getLocale() === 'en' ? 'Institutes & Establishments' : 'المعاهد والمؤسسات التكوينية')" color="text-brand-sky" />
            <x-animated-counter :target="!empty($stats['experts']) ? $stats['experts'] : 250" :label="app()->getLocale() === 'fr' ? 'Experts & Juges' : (app()->getLocale() === 'en' ? 'Experts & Judges' : 'الخبراء والحكام')" :description="app()->getLocale() === 'fr' ? 'Jury international certifié' : (app()->getLocale() === 'en' ? 'Certified International Jury' : 'لجان التحكيم المعتمدة')" color="text-purple-600" />
            <x-animated-counter :target="!empty($stats['participants']) ? $stats['participants'] : 1250" :label="app()->getLocale() === 'fr' ? 'Candidats Inscrits' : (app()->getLocale() === 'en' ? 'Registered Competitors' : 'المشاركين المسجلين')" :description="app()->getLocale() === 'fr' ? 'Jeunes talents compétiteurs' : (app()->getLocale() === 'en' ? 'Young Competitor Talents' : 'المتنافسون الشباب')" color="text-emerald-600" />
            <x-animated-counter :target="!empty($stats['skills']) ? $stats['skills'] : 64" :label="app()->getLocale() === 'fr' ? 'Métiers & Compétences' : (app()->getLocale() === 'en' ? 'Skills & Occupations' : 'التخصصات والمهن')" :description="app()->getLocale() === 'fr' ? 'Disciplines Olympiques' : (app()->getLocale() === 'en' ? 'Olympic Skill Disciplines' : 'التخصصات التنافسية')" color="text-amber-500" />
            <x-animated-counter :target="!empty($stats['countries']) ? $stats['countries'] : 54" :label="app()->getLocale() === 'fr' ? 'Pays Africains' : (app()->getLocale() === 'en' ? 'African Nations' : 'الدول الإفريقية')" :description="app()->getLocale() === 'fr' ? 'Délégations souveraines' : (app()->getLocale() === 'en' ? 'Sovereign Delegations' : 'الوفود الوطنية الرسمية')" color="text-red-500" />
        </div>
    </section>

    <!-- 4. Featured Skills Showcase -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 border-b-2 border-slate-100/80 relative group/head cursor-default">
            {{-- Dynamic Ambient Light Glow with Hover Shimmer --}}
            <div class="absolute -top-12 start-0 w-64 h-24 bg-gradient-to-r from-blue-600/10 via-cyan-500/15 to-indigo-600/10 rounded-full blur-3xl pointer-events-none group-hover/head:scale-125 group-hover/head:from-blue-600/25 group-hover/head:to-cyan-400/25 transition-all duration-700"></div>

            <div class="space-y-2 relative z-10">
                {{-- Luxury Pill Badge with SVG Icon instead of emoji --}}
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-blue-50 via-indigo-50/80 to-cyan-50 border border-blue-200/80 shadow-xs group-hover/head:border-blue-400 group-hover/head:shadow-md transition-all duration-300">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0066FF] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#0066FF]"></span>
                    </span>
                    <svg class="w-3.5 h-3.5 text-[#0066FF] group-hover/head:rotate-45 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="text-[11px] font-black text-[#0066FF] tracking-wider uppercase">
                        {{ app()->getLocale() === 'fr' ? 'Compétences Olympiques' : (app()->getLocale() === 'en' ? 'Olympic Skills' : 'الأولمبياد الوطني للمهارات') }}
                    </span>
                </div>

                {{-- Luxury Dynamic Title with Interactive Color Shift --}}
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight flex items-center gap-3">
                    <span class="p-3 rounded-2xl bg-gradient-to-tr from-[#06205C] via-[#0066FF] to-[#00A3FF] text-white shadow-lg shadow-blue-500/20 transform group-hover/head:rotate-6 group-hover/head:scale-110 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.187-2.19l.732-4.393A2 2 0 017.11 6.814l3.176.635a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.642 1.964v6.22a2 2 0 01-.927 1.69z"/></svg>
                    </span>
                    <span class="bg-gradient-to-r from-[#06205C] via-[#0038A8] to-[#0066FF] group-hover/head:from-[#0066FF] group-hover/head:via-[#00A3FF] group-hover/head:to-[#06205C] bg-clip-text text-transparent transition-all duration-500">
                        {{ app()->getLocale() === 'fr' ? 'Disciplines & Métiers Certifiés' : (app()->getLocale() === 'en' ? 'Certified Trade Categories' : 'التخصصات والمهن المعتمدة') }}
                    </span>
                </h2>

                <p class="text-xs sm:text-sm text-slate-500 font-bold max-w-xl group-hover/head:text-slate-700 transition-colors">
                    {{ app()->getLocale() === 'fr' ? 'Découvrez les compétences officielles engagées dans les Olympiades' : (app()->getLocale() === 'en' ? 'Explore official competition skills & occupations' : 'استكشف المهارات التنافسية والمهن التخصصية المشاركة في أولمبياد المهن') }}
                </p>
            </div>

            <a href="{{ route('skills') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-[#06205C] to-[#0066FF] hover:from-[#0066FF] hover:to-[#00A3FF] text-white text-xs font-black shadow-lg shadow-blue-900/20 hover:shadow-blue-500/40 hover:scale-105 transition-all duration-300 group/btn self-start md:self-auto border border-white/20">
                <span>{{ __('messages.view_all_skills') }}</span>
                <svg class="w-4 h-4 text-white group-hover/btn:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($skills as $skill)
                @php
                    $imgUrl = asset($skill->image_path ?: 'images/skills/trade_16.png');
                @endphp
                <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-slate-200/90 hover:shadow-2xl transition-all duration-400 transform hover:-translate-y-2 group cursor-pointer flex flex-col justify-between hover:border-[#0066FF] wsap-hover-card">
                    
                    {{-- Photo Banner Header --}}
                    <div class="h-48 bg-slate-950 relative overflow-hidden">
                        <img src="{{ $imgUrl }}"
                             onerror="this.onerror=null; this.src='{{ asset('images/skills/ict.png') }}';"
                             alt="{{ $skill->getLocalized('name') }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-95">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-black/20 to-black/10"></div>

                        {{-- Code Badge (Top-Start) --}}
                        <div class="absolute top-4 start-4 px-3.5 py-1.5 rounded-full bg-[#0066FF] text-white font-mono font-black text-xs shadow-md border border-white/30">
                            {{ $skill->code }}
                        </div>

                        {{-- Sector Badge (Top-End) --}}
                        <div class="absolute top-4 end-4 px-3.5 py-1.5 rounded-full bg-black/75 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-wider border border-white/20">
                            {{ $skill->category ? $skill->category->getLocalized('name') : 'تكنولوجيا المعلومات والاتصالات' }}
                        </div>
                    </div>

                    {{-- Card Body Details --}}
                    <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="text-lg font-black text-[#06205C] group-hover:text-[#0066FF] transition-colors leading-snug">
                                {{ $skill->getLocalized('name') }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-medium">
                                {{ $skill->getLocalized('description') }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('skills') }}" class="inline-flex items-center gap-1.5 text-xs font-black text-[#0066FF] hover:text-blue-700 transition">
                                <span>{{ __('messages.skills') }} — {{ app()->getLocale() === 'fr' ? 'Détails' : (app()->getLocale() === 'en' ? 'Details' : 'عرض التفاصيل والمعايير') }}</span>
                                <svg class="w-4 h-4 text-[#0066FF] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-3 bg-white rounded-3xl p-8 text-center text-slate-400 font-medium text-sm">
                    {{ app()->getLocale() === 'fr' ? 'Aucune discipline disponible actuellement.' : (app()->getLocale() === 'en' ? 'No trade categories added yet.' : 'لا توجد تخصصات مضافة حالياً.') }}
                </div>
            @endforelse
        </div>
    </section>

    <!-- 5. Media & Event Highlights Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 border-b-2 border-slate-100/80 relative group/head cursor-default">
            {{-- Dynamic Ambient Light Glow with Hover Shimmer --}}
            <div class="absolute -top-12 start-0 w-64 h-24 bg-gradient-to-r from-amber-500/10 via-orange-500/15 to-rose-500/10 rounded-full blur-3xl pointer-events-none group-hover/head:scale-125 group-hover/head:from-amber-500/25 group-hover/head:to-orange-400/25 transition-all duration-700"></div>

            <div class="space-y-2 relative z-10">
                {{-- Luxury Pill Badge with SVG Icon instead of emoji --}}
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-amber-50 via-orange-50/80 to-amber-100/60 border border-amber-200/80 shadow-xs group-hover/head:border-amber-400 group-hover/head:shadow-md transition-all duration-300">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                    </span>
                    <svg class="w-3.5 h-3.5 text-amber-600 group-hover/head:rotate-12 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[11px] font-black text-amber-800 tracking-wider uppercase">
                        {{ app()->getLocale() === 'fr' ? 'Espace Média & Presse' : (app()->getLocale() === 'en' ? 'Media & Newsroom' : 'المركز الإعلامي الرسمي') }}
                    </span>
                </div>

                {{-- Luxury Dynamic Title with Interactive Color Shift --}}
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight flex items-center gap-3">
                    <span class="p-3 rounded-2xl bg-gradient-to-tr from-amber-600 via-orange-500 to-amber-400 text-white shadow-lg shadow-amber-500/20 transform group-hover/head:-rotate-6 group-hover/head:scale-110 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </span>
                    <span class="bg-gradient-to-r from-[#06205C] via-amber-900 to-orange-600 group-hover/head:from-orange-600 group-hover/head:via-amber-500 group-hover/head:to-[#06205C] bg-clip-text text-transparent transition-all duration-500">
                        {{ app()->getLocale() === 'fr' ? 'Centre Média & Presse' : (app()->getLocale() === 'en' ? 'Media & Press Center' : 'المركز الإعلامي والتغطيات') }}
                    </span>
                </h2>

                <p class="text-xs sm:text-sm text-slate-500 font-bold max-w-xl group-hover/head:text-slate-700 transition-colors">
                    {{ app()->getLocale() === 'fr' ? 'Actualités, événements, galeries photos et médias' : (app()->getLocale() === 'en' ? 'Latest news, events, photos and video coverage' : 'متابعة حية لجميع المستجدات، الفعاليات، المعارض والتغطيات المصورة للأولمبياد') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1: معرض الصور المميز -->
            <div class="bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#06205C] mb-4">
                        {{ app()->getLocale() === 'fr' ? 'Galerie Photos' : (app()->getLocale() === 'en' ? 'Photo Gallery' : 'معرض الصور') }}
                    </h3>
                    <div class="space-y-3">
                        @forelse($albums as $album)
                            <a href="{{ route('gallery') }}" class="flex items-center gap-3 group">
                                @if($album->coverMedia?->storage_path || $album->mediaItems->first()?->storage_path)
                                    <img src="{{ $album->cover_url }}" alt="{{ $album->getLocalized('title') }}" class="w-12 h-10 rounded-lg object-cover flex-shrink-0 bg-slate-200 border border-slate-200">
                                @else
                                    <div class="w-12 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 border border-amber-200/60 shadow-xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-[#06205C] group-hover:text-brand-500 transition-colors leading-snug line-clamp-1">{{ $album->getLocalized('title') }}</h4>
                                    <span class="text-[10px] text-slate-400">{{ optional($album->published_at)->format('Y-m-d') ?? now()->format('Y-m-d') }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0 border border-slate-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-[#06205C] leading-snug line-clamp-1">WorldSkills Algeria 2026</h4>
                                    <span class="text-[10px] text-slate-400">2026-08-04</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <a href="{{ route('gallery') }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 mt-6 inline-flex items-center gap-1">
                    <span>{{ __('messages.view_all_gallery') }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Card 2: الأجندة والفعاليات القادمة -->
            <div class="bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#06205C] mb-4">
                        {{ app()->getLocale() === 'fr' ? 'Agenda & Événements' : (app()->getLocale() === 'en' ? 'Events & Calendar' : 'الأجندة والفعاليات') }}
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-500 flex flex-col items-center justify-center flex-shrink-0 font-bold border border-brand-100">
                                <span class="text-xs leading-none">25</span>
                                <span class="text-[9px] uppercase">{{ app()->getLocale() === 'fr' ? 'NOV' : (app()->getLocale() === 'en' ? 'NOV' : 'نوفمبر') }}</span>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-[#06205C]">
                                    {{ app()->getLocale() === 'fr' ? 'Cérémonie d\'Ouverture des Olympiades' : (app()->getLocale() === 'en' ? 'Official Opening Ceremony' : 'حفل الافتتاح الرسمي للأولمبياد الإفريقي') }}
                                </h4>
                                <span class="text-[10px] text-slate-400">CIC — Oran / Alger</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('events') }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 mt-6 inline-flex items-center gap-1">
                    <span>{{ __('messages.view_all_events') }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Card 3: الأخبار والمستجدات -->
            <div class="bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#06205C] mb-4">
                        {{ app()->getLocale() === 'fr' ? 'Actualités & Articles' : (app()->getLocale() === 'en' ? 'News & Updates' : 'الأخبار والمشاركات') }}
                    </h3>
                    <div class="space-y-3">
                        @forelse($news as $article)
                            <a href="{{ route('news') }}" class="flex items-center gap-3 group">
                                @if($article->featured_image)
                                    <img src="{{ $article->cover_url }}" alt="{{ $article->getLocalized('title') }}" class="w-12 h-10 rounded-lg object-cover flex-shrink-0 bg-slate-200 border border-slate-200">
                                @else
                                    <div class="w-12 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 border border-blue-200/60 shadow-xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-[#06205C] group-hover:text-brand-500 transition-colors leading-snug line-clamp-1">{{ $article->getLocalized('title') }}</h4>
                                    <span class="text-[10px] text-slate-400">{{ optional($article->published_at)->format('Y-m-d') ?? now()->format('Y-m-d') }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0 border border-slate-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-[#06205C] leading-snug line-clamp-1">WorldSkills Algeria 2027</h4>
                                    <span class="text-[10px] text-slate-400">2026-08-04</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <a href="{{ route('news') }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 mt-6 inline-flex items-center gap-1">
                    <span>{{ __('messages.view_all_news') }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Card 4: فيديو مميز -->
            <div class="bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#06205C] mb-4">
                        {{ app()->getLocale() === 'fr' ? 'Centre Vidéos' : (app()->getLocale() === 'en' ? 'Video Center' : 'مركز الفيديوهات والتغطيات') }}
                    </h3>
                    <button @click="showVideoModal = true" class="relative rounded-2xl overflow-hidden bg-[#020A24] group block w-full text-right focus:outline-none h-32 border border-slate-800 shadow-md">
                        @if($videos->first()?->thumbnail_path)
                            <img src="{{ $videos->first()->thumbnail_url }}" alt="Featured Video" class="w-full h-32 object-cover opacity-80 group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-32 bg-gradient-to-br from-[#020A24] via-[#06205C] to-blue-900 flex items-center justify-center p-4">
                                <img src="/logo.svg" alt="WorldSkills Algeria" class="h-12 w-auto opacity-30 filter drop-shadow">
                            </div>
                        @endif
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-[#0066FF] text-white flex items-center justify-center shadow-xl shadow-blue-500/50 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 fill-current translate-x-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                        <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/70 text-white text-[10px] font-mono">{{ $videos->first()?->duration ?: '02:45' }}</span>
                    </button>
                    <h4 class="text-xs font-bold text-[#06205C] mt-3 leading-snug line-clamp-1">{{ $videos->first()?->getLocalized('title') ?? 'WorldSkills International' }}</h4>
                </div>
                <a href="{{ route('videos') }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 mt-6 inline-flex items-center gap-1">
                    <span>{{ __('messages.view_all_videos') }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

        </div>
    </section>

    <!-- 6. Featured Partners & Sponsors Banner Grid -->
    @if(app(\App\Services\SettingsEngine::class)->get('page_partners_enabled', true))
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col items-center text-center space-y-2 relative pb-4 group/head cursor-default">
            {{-- Dynamic Ambient Light Glow with Hover Shimmer --}}
            <div class="absolute -top-12 inset-x-0 mx-auto w-72 h-24 bg-gradient-to-r from-blue-600/10 via-indigo-500/15 to-purple-600/10 rounded-full blur-3xl pointer-events-none group-hover/head:scale-125 group-hover/head:from-blue-600/25 group-hover/head:to-purple-500/25 transition-all duration-700"></div>

            {{-- Luxury Pill Badge with SVG Icon instead of emoji --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border border-blue-200/80 shadow-xs group-hover/head:border-indigo-400 group-hover/head:shadow-md transition-all duration-300">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0066FF] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#0066FF]"></span>
                </span>
                <svg class="w-3.5 h-3.5 text-[#0066FF] group-hover/head:scale-125 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span class="text-[11px] font-black text-[#0066FF] tracking-wider uppercase">
                    {{ app()->getLocale() === 'fr' ? 'Confiance & Excellence' : (app()->getLocale() === 'en' ? 'Trust & Excellence' : 'الشراكات الاستراتيجية والتميز') }}
                </span>
            </div>

            {{-- Luxury Dynamic Title with Interactive Color Shift --}}
            <h3 class="text-2xl sm:text-3xl font-black tracking-tight flex items-center justify-center gap-3">
                <span class="p-2.5 rounded-2xl bg-gradient-to-tr from-[#06205C] via-[#0066FF] to-indigo-600 text-white shadow-md transform group-hover/head:rotate-6 group-hover/head:scale-110 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </span>
                <span class="bg-gradient-to-r from-[#06205C] via-[#0038A8] to-[#0066FF] group-hover/head:from-[#0066FF] group-hover/head:via-purple-600 group-hover/head:to-[#06205C] bg-clip-text text-transparent transition-all duration-500">
                    {{ app()->getLocale() === 'fr' ? 'Partenaires & Sponsors Officiels' : (app()->getLocale() === 'en' ? 'Official Partners & Sponsors' : 'الشركاء والرعاة المميزون') }}
                </span>
            </h3>

            <p class="text-xs sm:text-sm text-slate-500 font-bold max-w-lg group-hover/head:text-slate-700 transition-colors">
                {{ app()->getLocale() === 'fr' ? 'Soutien industriel et institutionnel' : (app()->getLocale() === 'en' ? 'Supporting Industrial & Institutional Partners' : 'المؤسسات الرائدة والهيئات الصناعية الداعمة لأولمبياد المهن 2026') }}
            </p>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-md border border-slate-200/80 flex items-center justify-center flex-wrap gap-8 sm:gap-12">
            @forelse($partners as $p)
                @php $logoUrl = $p->logo_path ? asset($p->logo_path) : null; @endphp
                <div class="flex flex-col items-center justify-center gap-2 group transition transform hover:scale-105 py-2 px-3">
                    <div class="h-10 sm:h-12 w-auto flex items-center justify-center">
                        @if($logoUrl)
                            <img src="{{ $logoUrl }}" alt="{{ $p->getLocalized('name') }}" class="h-10 sm:h-12 w-auto object-contain filter grayscale group-hover:grayscale-0 transition duration-300">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 font-black text-sm flex items-center justify-center border border-blue-100">
                                {{ mb_substr($p->getLocalized('name'), 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="text-xs font-black text-[#06205C] group-hover:text-blue-600 transition tracking-tight text-center block">
                        {{ $p->getLocalized('name') }}
                    </span>
                </div>
            @empty
                <div class="text-xs text-slate-400 font-bold">
                    {{ app()->getLocale() === 'fr' ? 'Aucun partenaire disponible' : (app()->getLocale() === 'en' ? 'No featured partners yet' : 'لا يوجد شركاء مميزون حالياً.') }}
                </div>
            @endforelse
        </div>
    </section>
    @endif

    <!-- 7. Call to Action Banner -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-r from-[#0038A8] via-[#0066FF] to-[#00A3FF] text-white p-8 lg:p-12 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 group">
            
            @php
                $siteLogo = app(\App\Services\SettingsEngine::class)->get('site_logo', '/logo.svg');
                $logoUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : asset($siteLogo);
            @endphp
            <div class="flex items-center flex-shrink-0 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 shadow-inner">
                <img src="{{ $logoUrl }}" alt="WorldSkills Logo" class="h-16 w-auto object-contain brightness-0 invert filter drop-shadow-md">
            </div>

            <div class="space-y-3 max-w-xl text-center {{ app()->getLocale() === 'ar' ? 'md:text-right' : 'md:text-left' }}">
                <h2 class="text-2xl sm:text-3xl font-black leading-tight">
                    {{ app()->getLocale() === 'fr' ? 'Rejoignez le plus grand événement des compétences en Algérie !' : (app()->getLocale() === 'en' ? 'Join the Largest Skills Event in Algeria!' : 'كن جزءاً من أكبر حدث للمهارات في الجزائر!') }}
                </h2>
                <p class="text-xs text-blue-100 font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Inscrivez-vous maintenant pour participer au développement des compétences nationales à Oran.' : (app()->getLocale() === 'en' ? 'Register now to shape the future of national skill standards in Oran.' : 'سجل الآن وشارك في صناعة المستقبل وتطوير المهارات الوطنية بمركز المؤتمرات بوهران.') }}
                </p>
            </div>
            
            <a href="{{ route('registration') }}" class="px-8 py-3.5 rounded-2xl bg-white text-[#0052CC] font-bold text-xs shadow-xl hover:bg-blue-50 transition flex items-center gap-2 flex-shrink-0 hover:scale-105">
                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>{{ __('messages.register_now') }}</span>
            </a>
        </div>
    </section>

    <!-- 8. Inline Video Pop-Up Modal (Plays video directly inside site without redirecting) -->
    <div x-show="showVideoModal" x-transition.opacity class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md flex items-center justify-center p-4" style="display: none;">
        <div @click.outside="showVideoModal = false" class="bg-slate-900 rounded-3xl overflow-hidden max-w-4xl w-full shadow-2xl border border-slate-700 relative">
            <button @click="showVideoModal = false" class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-black/60 text-white flex items-center justify-center hover:bg-black transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="aspect-video w-full">
                <iframe class="w-full h-full" src="https://www.youtube-nocookie.com/embed/nzy4f7GBSVw?autoplay=1&rel=0&modestbranding=1&iv_load_policy=3&showinfo=0&vq=hd1080" title="WorldSkills Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

</div>
