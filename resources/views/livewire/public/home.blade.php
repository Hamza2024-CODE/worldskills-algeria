
<div class="pb-16 relative overflow-hidden bg-[#FAFBFD] min-h-screen" x-data="{ showVideoModal: false }">

    <!-- The Hybrid Dynamic Background Experience (الشبكة الهندسية الدقيقة + الهالات المتنفسة + توهج الفأرة) -->
    <x-ui.dynamic-aurora-mesh />

@php
    $activeEvent = $activeEvent ?? null;
    $stats = $stats ?? [];
    $skills = $skills ?? collect();
    $news = $news ?? collect();
    $albums = $albums ?? collect();
    $videos = $videos ?? collect();
    $partners = $partners ?? collect();
    $skillCategories = $skillCategories ?? collect();
    $upcomingEvents = $upcomingEvents ?? collect();
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
    @php
        $rotatingPhrases = match(app()->getLocale()) {
            'fr' => [
                "L'Excellence Métiers & Compétences",
                "Les Talents & Savoir-Faire de Demain",
                "Innovation Technologique & Artisanat",
                "Leadership Professionnel Africain"
            ],
            'en' => [
                "Vocational Excellence & Skills",
                "Tomorrow's National Talents",
                "Industrial & Technological Innovation",
                "African Vocational Leadership"
            ],
            default => [
                "التميز المهني والحرفي",
                "طاقات وكفاءات الغد",
                "الابتكار الصناعي والتقني",
                "ريادة المهارات الجزائرية والأفريقية"
            ]
        };
    @endphp

    <section class="relative bg-[#020A24] text-white min-h-[92vh] lg:min-h-screen w-full overflow-hidden flex items-center justify-center pt-32 sm:pt-40 pb-20 px-4 sm:px-6 lg:px-8">
        
        <!-- Full-Bleed 100% Seamless Cover Video Background Layer -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none w-full h-full">
            <iframe 
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none" 
                style="width: 100vw; height: 56.25vw; min-height: 100vh; min-width: 177.78vh; object-fit: cover;"
                src="https://www.youtube-nocookie.com/embed/nzy4f7GBSVw?autoplay=1&mute=1&controls=0&loop=1&playlist=nzy4f7GBSVw&playsinline=1&rel=0&modestbranding=1&enablejsapi=1&iv_load_policy=3&disablekb=1&showinfo=0&vq=hd1080" 
                title="WorldSkills Background Video HD" 
                frameborder="0" 
                allow="autoplay; encrypted-media"></iframe>
            <!-- Subtle Dark Cinematic Gradient Overlay for Maximum Text Legibility -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#020A24] via-[#020A24]/45 to-black/35"></div>
        </div>

        <!-- Ambient Glow Particles -->
        <div class="absolute -top-24 -left-24 w-[32rem] h-[32rem] bg-sky-400/20 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-[32rem] h-[32rem] bg-blue-600/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="max-w-7xl mx-auto w-full relative z-10 text-start space-y-6">

            <!-- Animated Dynamic Typography Section with Typewriter Effect -->
            <div class="space-y-4 max-w-4xl" x-data="{
                phrases: {{ json_encode($rotatingPhrases) }},
                currentPhraseIndex: 0,
                currentText: '',
                isDeleting: false,
                init() {
                    this.type();
                },
                type() {
                    let fullText = this.phrases[this.currentPhraseIndex];
                    if (this.isDeleting) {
                        this.currentText = fullText.substring(0, this.currentText.length - 1);
                    } else {
                        this.currentText = fullText.substring(0, this.currentText.length + 1);
                    }

                    let delta = this.isDeleting ? 35 : 85;

                    if (!this.isDeleting && this.currentText === fullText) {
                        delta = 2400;
                        this.isDeleting = true;
                    } else if (this.isDeleting && this.currentText === '') {
                        this.isDeleting = false;
                        this.currentPhraseIndex = (this.currentPhraseIndex + 1) % this.phrases.length;
                        delta = 350;
                    }

                    setTimeout(() => this.type(), delta);
                }
            }">
                
                <!-- Pill Badge -->


                <!-- Main Title: Smooth Entrance + Pulse Glow -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.2] text-white">
                    {{ $activeEvent ? $activeEvent->getLocalized('title') : __('messages.hero_title') }}
                </h1>

                <!-- Dynamic Animated Moving Text Line -->
                <div class="flex items-center gap-2 text-lg sm:text-2xl font-black text-white/95">
                    <span class="text-slate-300 font-bold text-sm sm:text-lg">{{ app()->getLocale() === 'fr' ? 'Vers:' : (app()->getLocale() === 'en' ? 'Towards:' : 'نحو:') }}</span>
                    <span class="text-[#00B8FF] font-black border-e-2 border-[#00B8FF] pe-1.5 min-h-[1.5em] inline-block" x-text="currentText"></span>
                </div>

                <!-- Subtitle -->
                <p class="text-sm sm:text-base lg:text-lg text-slate-200 font-medium leading-relaxed max-w-3xl drop-shadow-md">
                    {{ $activeEvent ? $activeEvent->getLocalized('summary') : __('messages.hero_subtitle') }}
                </p>

            </div>

            <!-- Action Buttons Grid: Solid & Glowing Modern Buttons -->
            <div class="flex flex-wrap items-center gap-4 pt-4">
                <!-- 1. Explore More (Cyan / Primary Gradient Button) -->
                <a href="{{ route('guide') }}" class="px-8 py-3.5 rounded-full bg-gradient-to-r from-[#0052CC] via-[#0066FF] to-[#00B8FF] hover:from-[#0040A3] hover:to-[#00A3E0] text-white font-black text-xs sm:text-sm shadow-xl shadow-blue-500/25 ws-transition hover:scale-105 active:scale-95 flex items-center gap-2.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ __('messages.explore_more') }}</span>
                </a>

                <!-- 2. Register Now (High-Contrast Solid White Button) -->
                <a href="{{ route('registration') }}" class="px-8 py-3.5 rounded-full bg-white hover:bg-slate-100 text-[#041235] font-black text-xs sm:text-sm shadow-xl ws-transition hover:scale-105 active:scale-95 flex items-center gap-2 border border-white/90">
                    <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>{{ __('messages.register_now') }}</span>
                </a>
            </div>
        </div>

        <!-- ═════════════════════════════════════════════════════════════════
             ORGANIC WAVE & FOGGY MIST TRANSITION (Seamless Hero Blend)
             ═════════════════════════════════════════════════════════════════ -->
        <!-- Soft Foggy Mist Gradient Layer -->
        <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-[#FAFBFD] via-[#FAFBFD]/70 to-transparent pointer-events-none z-10"></div>

        <!-- Organic Fluid Wave Divider -->
        <div class="absolute inset-x-0 bottom-0 pointer-events-none z-20 overflow-hidden leading-none">
            <svg class="relative block w-full h-16 sm:h-24 lg:h-32 text-[#FAFBFD]" viewBox="0 0 1440 120" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Subtle Secondary Ambient Layer -->
                <path opacity="0.4" d="M0,35 C320,85 460,10 720,50 C980,90 1180,20 1440,60 L1440,120 L0,120 Z" fill="currentColor"/>
                <!-- Main Smooth Foreground Wave -->
                <path d="M0,65 C260,110 520,25 780,70 C1040,115 1260,35 1440,75 L1440,120 L0,120 Z" fill="currentColor"/>
            </svg>
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
                    <x-ws.icon name="star" class="w-3.5 h-3.5 text-amber-500 inline-block" />
                    <span>
                        @if(app()->getLocale() === 'fr')
                            {{ $countdownSubtitleFr }}
                        @elseif(app()->getLocale() === 'en')
                            {{ $countdownSubtitleEn }}
                        @else
                            {{ $countdownSubtitleAr }}
                        @endif
                    </span>
                    <x-ws.icon name="star" class="w-3.5 h-3.5 text-amber-500 inline-block" />
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

    <!-- 3. Dynamic Real DB Statistics Grid -->
    <div id="stats-section"></div>
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

    <!-- 3.5 Breaking News / Forum Ticker (شريط الأخبار والإعلانات التفاعلي) -->
    @include('partials.news-ticker')

    <!-- 4. Featured Skills Showcase -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 mb-16 sm:mb-20">
        <div class="p-6 sm:p-8 rounded-3xl bg-white/70 backdrop-blur-xl border border-white/80 shadow-[0_10px_35px_rgba(0,82,204,0.06)] hover:shadow-[0_20px_45px_rgba(0,82,204,0.12)] hover:-translate-y-1.5 transition-all duration-500 relative group/head cursor-default overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
            {{-- Ambient Decorative Glass Glow (Transforms from Blue to Cyan on Hover) --}}
            <div class="absolute -top-16 -start-16 w-60 h-60 bg-gradient-to-br from-blue-500/15 via-cyan-400/10 to-transparent rounded-full blur-3xl pointer-events-none group-hover/head:scale-125 group-hover/head:from-cyan-500/25 group-hover/head:via-blue-600/20 transition-all duration-700"></div>

            <div class="space-y-3 relative z-10">


                {{-- Luxury Dynamic Title with Color Shift --}}
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight flex items-center gap-3">
                    <span class="p-3 rounded-2xl bg-gradient-to-tr from-[#06205C] via-[#0052CC] to-[#00A3FF] group-hover/head:from-[#0052CC] group-hover/head:to-cyan-400 text-white shadow-lg shadow-blue-500/25 group-hover/head:scale-110 group-hover/head:rotate-3 transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.187-2.19l.732-4.393A2 2 0 017.11 6.814l3.176.635a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.642 1.964v6.22a2 2 0 01-.927 1.69z"/></svg>
                    </span>
                    <span class="bg-gradient-to-r from-[#041235] via-[#0052CC] to-[#00B8FF] group-hover/head:from-[#0052CC] group-hover/head:via-cyan-500 group-hover/head:to-[#041235] bg-clip-text text-transparent transition-all duration-500">
                        {{ app()->getLocale() === 'fr' ? 'Disciplines & Métiers Certifiés' : (app()->getLocale() === 'en' ? 'Certified Trade Categories' : 'التخصصات والمهن المعتمدة') }}
                    </span>
                </h2>

                <p class="text-xs sm:text-sm text-slate-500 font-bold max-w-xl group-hover/head:text-slate-700 transition-colors">
                    {{ app()->getLocale() === 'fr' ? 'Explorez les compétences officielles en compétition nationale et africaine' : (app()->getLocale() === 'en' ? 'Explore official skills and occupations competing in the Olympiad' : 'استكشف المهارات التنافسية والمهن التخصصية المشاركة في أولمبياد المهن') }}
                </p>
            </div>

            <a href="{{ route('skills') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-[#06205C] to-[#0052CC] hover:from-[#0052CC] hover:to-[#00B8FF] text-white text-xs font-black shadow-lg shadow-blue-900/20 hover:shadow-blue-500/40 transition-all duration-300 group/btn self-start md:self-auto border border-white/20 relative z-10 shrink-0 hover:scale-105 active:scale-95">
                <span>{{ __('messages.view_all_skills') }}</span>
                <svg class="w-4 h-4 text-white group-hover/btn:translate-x-1.5 rtl:group-hover/btn:-translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($skills as $skill)
                @php
                    $imgUrl = asset($skill->image_path ?: 'images/skills/trade_16.png');
                @endphp
                <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-slate-200/90 hover:shadow-2xl transition-all duration-400 transform mac-dock-hover relative overflow-hidden  group cursor-pointer flex flex-col justify-between hover:border-[#0066FF] wsap-hover-card">
                    
                    {{-- Photo Banner Header --}}
                    <div class="h-48 bg-slate-950 relative overflow-hidden">
                        <img src="{{ $imgUrl }}"
                             onerror="this.onerror=null; this.src='{{ asset('images/skills/ict.png') }}';"
                             alt="{{ $skill->getLocalized('name') }}"
                             class="w-full h-full object-cover group-mac-dock-hover relative overflow-hidden  transition-transform duration-700 opacity-95">
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
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 mb-16 sm:mb-20">
        <div class="p-6 sm:p-8 rounded-3xl bg-white/70 backdrop-blur-xl border border-white/80 shadow-[0_10px_35px_rgba(245,158,11,0.06)] hover:shadow-[0_20px_45px_rgba(245,158,11,0.15)] hover:-translate-y-1.5 transition-all duration-500 relative group/head cursor-default overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
            {{-- Ambient Decorative Glass Glow (Transforms from Amber to Orange on Hover) --}}
            <div class="absolute -top-16 -start-16 w-60 h-60 bg-gradient-to-br from-amber-500/15 via-orange-400/10 to-transparent rounded-full blur-3xl pointer-events-none group-hover/head:scale-125 group-hover/head:from-orange-500/25 group-hover/head:via-amber-600/20 transition-all duration-700"></div>

            <div class="space-y-3 relative z-10">


                {{-- Luxury Dynamic Title with Color Shift --}}
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight flex items-center gap-3">
                    <span class="p-3 rounded-2xl bg-gradient-to-tr from-amber-600 via-orange-500 to-amber-400 group-hover/head:from-orange-500 group-hover/head:to-amber-300 text-white shadow-lg shadow-amber-500/25 group-hover/head:scale-110 group-hover/head:-rotate-3 transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </span>
                    <span class="bg-gradient-to-r from-[#041235] via-amber-900 to-orange-600 group-hover/head:from-orange-600 group-hover/head:via-amber-500 group-hover/head:to-[#041235] bg-clip-text text-transparent transition-all duration-500">
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
            <div class="group bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 wsap-card-animated wsap-shine-effect flex flex-col justify-between">
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
            <div class="group bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 wsap-card-animated wsap-shine-effect flex flex-col justify-between">
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
            <div class="group bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 wsap-card-animated wsap-shine-effect flex flex-col justify-between">
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
                                    <h4 class="text-xs font-bold text-[#06205C] leading-snug line-clamp-1">WorldSkills Algeria 2026</h4>
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
            <div class="group bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 wsap-card-animated wsap-shine-effect flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#06205C] mb-4">
                        {{ app()->getLocale() === 'fr' ? 'Centre Vidéos' : (app()->getLocale() === 'en' ? 'Video Center' : 'مركز الفيديوهات والتغطيات') }}
                    </h3>
                    <button @click="showVideoModal = true" class="relative rounded-2xl overflow-hidden bg-[#020A24] group block w-full text-right focus:outline-none h-32 border border-slate-800 shadow-md">
                        @if($videos->first()?->thumbnail_path)
                            <img src="{{ $videos->first()->thumbnail_url }}" alt="Featured Video" class="w-full h-32 object-cover opacity-80 group-mac-dock-hover relative overflow-hidden  transition-transform duration-300">
                        @else
                            <div class="w-full h-32 bg-gradient-to-br from-[#020A24] via-[#06205C] to-blue-900 flex items-center justify-center p-4">
                                <img src="/logo.svg" alt="WorldSkills Algeria" class="h-12 w-auto opacity-30 filter drop-shadow">
                            </div>
                        @endif
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-[#0066FF] text-white flex items-center justify-center shadow-xl shadow-blue-500/50 group-mac-dock-hover relative overflow-hidden  transition-transform">
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
    @if(true)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 mb-16 sm:mb-20 overflow-hidden">
        <div class="p-6 sm:p-8 rounded-3xl bg-white/70 backdrop-blur-xl border border-white/80 shadow-[0_10px_35px_rgba(0,82,204,0.06)] hover:shadow-[0_20px_45px_rgba(0,82,204,0.12)] hover:-translate-y-1.5 transition-all duration-500 relative group/head cursor-default overflow-hidden flex flex-col items-center text-center space-y-3">
            {{-- Ambient Decorative Glass Glow (Transforms from Navy/Blue to Cyan on Hover) --}}
            <div class="absolute -top-16 inset-x-0 mx-auto w-72 h-48 bg-gradient-to-b from-blue-500/15 via-cyan-400/10 to-transparent rounded-full blur-3xl pointer-events-none group-hover/head:scale-125 group-hover/head:from-cyan-500/25 group-hover/head:via-blue-600/20 transition-all duration-700"></div>



            {{-- Luxury Dynamic Title with Color Shift --}}
            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight flex items-center justify-center gap-3 relative z-10">
                <span class="p-3 rounded-2xl bg-gradient-to-tr from-[#041235] to-[#0052CC] group-hover/head:from-[#0052CC] group-hover/head:to-cyan-400 text-white shadow-lg shadow-blue-500/25 group-hover/head:scale-110 group-hover/head:rotate-3 transition-all duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </span>
                <span class="bg-gradient-to-r from-[#041235] via-[#0052CC] to-[#00B8FF] group-hover/head:from-[#0052CC] group-hover/head:via-cyan-500 group-hover/head:to-[#041235] bg-clip-text text-transparent transition-all duration-500">
                    {{ app()->getLocale() === 'fr' ? 'Partenaires & Sponsors Officiels' : (app()->getLocale() === 'en' ? 'Official Partners & Sponsors' : 'الشركاء والرعاة المميزون') }}
                </span>
            </h3>

            <p class="text-xs sm:text-sm text-slate-500 font-bold max-w-lg mx-auto group-hover/head:text-slate-700 transition-colors relative z-10">
                {{ app()->getLocale() === 'fr' ? 'Soutien industriel et institutionnel' : (app()->getLocale() === 'en' ? 'Supporting Industrial & Institutional Partners' : 'المؤسسات الرائدة والهيئات الصناعية الداعمة لأولمبياد المهن 2026') }}
            </p>
        </div>

        <!-- Continuous Rotating Carousel Chain (حاويات الشركاء كسلسلة تدور بدون أي فراغ) -->
        <div class="relative w-full overflow-hidden py-3 ws-marquee-wrapper" dir="ltr">
            <style>
                @keyframes wsInfiniteTrackScroll {
                    0% {
                        transform: translate3d(0, 0, 0);
                    }
                    100% {
                        transform: translate3d(-50%, 0, 0);
                    }
                }
                .ws-marquee-wrapper {
                    direction: ltr !important;
                    text-align: left !important;
                }
                .ws-marquee-track {
                    display: flex;
                    align-items: center;
                    width: max-content;
                    user-select: none;
                    animation: wsInfiniteTrackScroll 40s linear infinite;
                    will-change: transform;
                    direction: ltr !important;
                }
                .ws-marquee-track:hover {
                    animation-play-state: paused;
                }
                @media (prefers-reduced-motion: reduce) {
                    .ws-marquee-track {
                        animation: none !important;
                    }
                }
            </style>

            <!-- Edge Gradient Masks -->
            <div class="pointer-events-none absolute inset-y-0 left-0 w-16 sm:w-28 bg-gradient-to-r from-[#F8FAFC] to-transparent z-10"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-16 sm:w-28 bg-gradient-to-l from-[#F8FAFC] to-transparent z-10"></div>

            <!-- The Unified Gapless Infinite Marquee Track (Repeated 4x for 100% Full Seamless Chain) -->
            <div class="ws-marquee-track py-2" dir="ltr">
                @for ($streamLoop = 0; $streamLoop < 4; $streamLoop++)
                    <div class="flex items-center gap-6 pr-6 shrink-0" aria-hidden="{{ $streamLoop > 0 ? 'true' : 'false' }}">
                        @foreach($partners as $p)
                            @php 
                                $logoUrl = $p->logo_path ? asset($p->logo_path) : null; 
                            @endphp
                            <!-- Partner Container / Capsule (حاوية الشريك) -->
                            <div 
                                class="w-48 sm:w-56 h-28 sm:h-32 px-4 py-3 rounded-2xl bg-white/95 border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-[#00B8FF] hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center gap-2 group shrink-0 cursor-pointer"
                                dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
                                title="{{ $p->getLocalized('name') }}"
                            >
                                <div class="h-12 sm:h-14 w-full flex items-center justify-center overflow-hidden">
                                    @if($logoUrl)
                                        <img 
                                            src="{{ $logoUrl }}" 
                                            alt="{{ $p->getLocalized('name') }}" 
                                            class="max-h-full max-w-[85%] object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300 group-hover:scale-105"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0052CC] font-black text-sm flex items-center justify-center border border-blue-100">
                                            {{ mb_substr($p->getLocalized('name'), 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <span class="text-xs font-black text-[#041235] group-hover:text-[#0052CC] transition tracking-tight text-center truncate max-w-full block">
                                    {{ $p->getLocalized('name') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endfor
            </div>
        </div></section>
    @endif

    <!-- 6.5 Africa Skills Policy Forum 2026 Showcase Section (متناسق مع مظهر المنصة الفاتح الفاخر) -->
    <section id="african-skills-policy-forum" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 sm:mb-20">
        <div class="relative rounded-3xl sm:rounded-[36px] overflow-hidden bg-gradient-to-br from-white via-[#F4F9FF] to-[#EBF5FE] border-2 border-sky-100 shadow-[0_20px_60px_-15px_rgba(2,132,199,0.12)] p-8 sm:p-10 lg:p-12 group/forum">
            
            {{-- Ambient Cyan & Sky Aurora Glows --}}
            <div class="absolute -top-28 -right-28 w-96 h-96 bg-[#00C4CC]/10 rounded-full blur-3xl pointer-events-none group-hover/forum:scale-125 transition-transform duration-1000"></div>
            <div class="absolute -bottom-28 -left-28 w-96 h-96 bg-[#0052CC]/10 rounded-full blur-3xl pointer-events-none group-hover/forum:scale-125 transition-transform duration-1000"></div>

            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-10">
                
                {{-- 1. Official Logo Pod (حاوية الشعار الرسمي) --}}
                <div class="flex flex-col items-center shrink-0">
                    <div class="relative p-6 rounded-3xl bg-white/95 backdrop-blur-xl border-2 border-sky-200/70 shadow-lg shadow-sky-950/5 flex items-center justify-center group-hover/forum:border-cyan-400 group-hover/forum:shadow-cyan-500/20 transition-all duration-500 w-48 sm:w-56 h-48 sm:h-56">
                        {{-- Electric Cyan Aura --}}
                        <div class="absolute -inset-1 rounded-[28px] bg-gradient-to-tr from-[#00C4CC]/25 via-[#00A3FF]/15 to-transparent blur-md -z-10 opacity-70 group-hover/forum:opacity-100 transition-opacity"></div>
                        
                        <img 
                            src="{{ asset('images/african_skills_policy_forum_logo.png') }}" 
                            alt="African Skills Policy Forum Logo" 
                            class="max-h-full max-w-full object-contain filter drop-shadow-sm group-hover/forum:scale-105 transition-transform duration-500"
                        >
                    </div>
                    <span class="mt-3 text-[11px] font-black tracking-widest uppercase text-[#0052CC] text-center drop-shadow-xs">
                        {{ app()->getLocale() === 'fr' ? 'Forum Politique Officiel 2026' : (app()->getLocale() === 'en' ? 'Official Political Forum 2026' : 'المنتدى القاري الرسمي 2026') }}
                    </span>
                </div>

                {{-- 2. Center Content Area (نصوص واضحة بألوان المنصة) --}}
                <div class="space-y-5 max-w-xl text-center {{ app()->getLocale() === 'ar' ? 'lg:text-right' : 'lg:text-left' }} flex-1">
                    
                    {{-- Title --}}
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#041235] tracking-tight leading-snug">
                        {{ app()->getLocale() === 'fr' ? 'Forum sur les Politiques Africaines des Compétences' : (app()->getLocale() === 'en' ? 'Africa Skills Policy Forum' : 'منتدى السياسات الإفريقية للمهارات') }}
                        <span class="bg-gradient-to-r from-[#0052CC] via-[#00A3FF] to-[#00C4CC] bg-clip-text text-transparent">2026</span>
                    </h2>

                    {{-- Executive Quote Box --}}
                    <div class="{{ app()->getLocale() === 'ar' ? 'border-r-4 pr-4 text-right' : 'border-l-4 pl-4 text-left' }} border-[#00C4CC] py-2.5 px-4 bg-sky-500/10 rounded-2xl">
                        <p class="text-sm sm:text-base font-extrabold text-[#007A87] tracking-wide leading-relaxed">
                            {{ app()->getLocale() === 'fr' ? "« Façonner l'avenir des compétences, autonomiser la jeunesse africaine »" : (app()->getLocale() === 'en' ? '“Shaping the Future of Skills, Empowering African Youth”' : '« صياغة مستقبل المهارات، تمكين الشباب الإفريقي »') }}
                        </p>
                    </div>

                    {{-- Description --}}
                    <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? "L'événement politique majeur de haut niveau réunissant ministres africains, experts techniques et partenaires institutionnels et internationaux, concrétisant un principe fondamental : l'avenir des compétences en Afrique doit être façonné par les Africains eux-mêmes." : (app()->getLocale() === 'en' ? "The flagship high-level political event bringing together African ministers, technical experts, institutional and international partners, embodying a core principle: Africa's skills future must be shaped by Africans themselves." : 'الحدث السياسي الرفيع المستوى الرئيسي الذي يجمع الوزراء الأفارقة والخبراء التقنيين والشركاء المؤسساتيين والدوليين، تجسيداً لمبدأ أساسي: مستقبل المهارات في إفريقيا يجب أن يُصاغ من قبل الأفارقة أنفسهم.') }}
                    </p>

                    {{-- Key Pillars / Highlights in Clean Soft Chips --}}
                    <div class="flex flex-wrap items-center justify-center {{ app()->getLocale() === 'ar' ? 'lg:justify-start' : 'lg:justify-start' }} gap-2.5 pt-1">
                        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white border border-slate-200/90 text-slate-700 text-xs font-bold shadow-xs hover:border-sky-300 transition">
                            <span class="w-2 h-2 rounded-full bg-[#00C4CC]"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Représentation Ministérielle' : (app()->getLocale() === 'en' ? 'Ministerial Delegations' : 'وفود وزارية قارية') }}</span>
                        </div>
                        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white border border-slate-200/90 text-slate-700 text-xs font-bold shadow-xs hover:border-sky-300 transition">
                            <span class="w-2 h-2 rounded-full bg-[#0052CC]"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Partenariats Stratégiques' : (app()->getLocale() === 'en' ? 'Strategic Partnerships' : 'شراكات استراتيجية دولية') }}</span>
                        </div>
                        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white border border-slate-200/90 text-slate-700 text-xs font-bold shadow-xs hover:border-sky-300 transition">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Emploi & Avenir des Jeunes' : (app()->getLocale() === 'en' ? 'Youth Skills & Employment' : 'تمكين وتشغيل الشباب') }}</span>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="pt-2 flex justify-center {{ app()->getLocale() === 'ar' ? 'lg:justify-start' : 'lg:justify-start' }}">
                        <a 
                            href="https://africaskills-policyforum.worldskills.dz/" 
                            target="_blank" 
                            class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-[#0052CC] via-[#0088FF] to-[#00C4CC] hover:from-[#0041A8] hover:to-[#00A3FF] text-white font-black text-xs sm:text-sm shadow-xl shadow-blue-600/20 hover:shadow-cyan-500/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3 group/btn"
                        >
                            <span>{{ app()->getLocale() === 'fr' ? 'Visiter le Portail Officiel du Forum' : (app()->getLocale() === 'en' ? 'Visit Official Forum Portal' : 'زيارة المنصة الرسمية للمنتدى') }}</span>
                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180 group-hover/btn:-translate-x-1' : 'group-hover/btn:translate-x-1' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- 3. Dedicated Interactive Africa Map Pod (شعار القارة الرسمي مع تدرج أزرق فاتح عند التحويم وحركة الارتفاع) --}}
                <div class="flex flex-col items-center shrink-0 group/map cursor-pointer">
                    <div class="relative p-6 rounded-3xl bg-white/95 backdrop-blur-xl border-2 border-sky-200/70 shadow-lg shadow-sky-950/5 w-56 sm:w-64 h-64 sm:h-72 flex flex-col items-center justify-center overflow-hidden transition-all duration-500 group-hover/map:border-cyan-400 group-hover/map:shadow-[0_20px_50px_rgba(0,196,204,0.25)]">
                        
                        {{-- Soft Ambient Base Backlight --}}
                        <div class="absolute inset-0 rounded-3xl bg-gradient-to-tr from-sky-50 via-cyan-50/50 to-transparent pointer-events-none"></div>

                        {{-- Vibrant Light Blue Gradient on Hover (خلفية تدرج أزرق فاتح ناصع عند تحريك الفأرة) --}}
                        <div class="absolute inset-0 rounded-3xl bg-gradient-to-tr from-[#bae6fd]/60 via-[#e0f2fe]/75 to-[#ccfbf1]/60 opacity-0 group-hover/map:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                        {{-- Ambient Upward Glow Beacon (هالة ضوئية متصاعدة تدفع القارة لأعلى) --}}
                        <div class="absolute bottom-0 inset-x-0 mx-auto w-44 h-16 bg-[#38bdf8]/20 rounded-full blur-2xl group-hover/map:bg-[#00E5FF]/40 group-hover/map:scale-150 transition-all duration-500 pointer-events-none"></div>

                        {{-- The Floating Africa Continent Symbol with Upward Hover Animation --}}
                        <div class="relative z-10 w-full h-full flex items-center justify-center transition-all duration-500 ease-out transform group-hover/map:-translate-y-6 group-hover/map:scale-105 filter drop-shadow-[0_10px_20px_rgba(2,132,199,0.2)] group-hover/map:drop-shadow-[0_16px_28px_rgba(0,196,204,0.35)]">
                            <img 
                                src="{{ asset('images/africa_continent_symbol.png') }}" 
                                alt="African Skills Policy Forum — Africa Continent" 
                                class="max-h-[90%] max-w-[90%] object-contain transition-transform duration-500"
                            >
                        </div>
                    </div>

                    {{-- Map Subtitle / Location Pin --}}
                    <div class="mt-3 flex items-center gap-2 text-[11px] font-black text-slate-700 group-hover/map:text-[#0052CC] transition-colors drop-shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-[#00C4CC] animate-ping"></span>
                        <span>{{ app()->getLocale() === 'fr' ? 'Oran, Algérie 2026' : (app()->getLocale() === 'en' ? 'Oran, Algeria 2026' : 'وهران، الجزائر 2026') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 7. Call to Action Banner -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 sm:mb-20">
        <div class="rounded-3xl bg-gradient-to-r from-[#0038A8] via-[#0066FF] to-[#00A3FF] text-white p-8 lg:p-12 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 group wsap-card-animated wsap-shine-effect">
            
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
            
            <a href="{{ route('registration') }}" class="px-8 py-3.5 rounded-2xl bg-white text-[#0052CC] font-bold text-xs shadow-xl hover:bg-blue-50 transition flex items-center gap-2 flex-shrink-0 mac-dock-hover relative overflow-hidden ">
                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>{{ __('messages.register_now') }}</span>
            </a>
        </div>
    </section>

        <!-- 8. Continuous Auto-Next Video Playlist Player Modal -->
    <div x-data="videoPlaylistPlayer()" 
         x-show="showVideoModal" 
         x-transition.opacity
         @keydown.escape.window="closeModal()"
         class="fixed inset-0 z-50 bg-black/85 backdrop-blur-xl flex items-center justify-center p-4 sm:p-6" 
         style="display: none;">
        
        <div class="bg-slate-900 rounded-3xl overflow-hidden max-w-5xl w-full shadow-2xl relative border border-slate-800 flex flex-col lg:flex-row max-h-[90vh]"
             @click.away="closeModal()">
            
            <!-- Close Button -->
            <button @click="closeModal()" class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-black/70 text-white flex items-center justify-center hover:bg-red-600 transition-colors font-bold shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <!-- Video Player Column (Left/Main) -->
            <div class="lg:w-2/3 flex flex-col justify-between bg-black">
                <div class="aspect-video w-full relative">
                    <iframe id="wsap-yt-player" 
                            class="w-full h-full" 
                            :src="'https://www.youtube-nocookie.com/embed/' + currentVideo.ytId + '?enablejsapi=1&autoplay=1&rel=0'" 
                            title="WorldSkills Video Player" 
                            frameborder="0" 
                            allow="autoplay; encrypted-media" 
                            allowfullscreen></iframe>
                </div>

                <!-- Active Video Info & Next/Prev Controls -->
                <div class="p-4 sm:p-6 bg-slate-950/90 border-t border-slate-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                            <span class="text-[11px] font-black text-emerald-400 uppercase tracking-wider">تشغيل تلقائي متواصل (Auto-Next Playlist)</span>
                        </div>
                        <h4 class="text-sm sm:text-base font-bold text-white mt-1 line-clamp-1" x-text="currentVideo.title"></h4>
                    </div>

                    <!-- Next & Previous Navigation Buttons -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <button @click="prevVideo()" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            <span>السابق</span>
                        </button>
                        <button @click="nextVideo()" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md transition-colors flex items-center gap-1">
                            <span>الفيديو التالي</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Playlist Sidebar Queue (Right Column) -->
            <div class="lg:w-1/3 p-4 sm:p-5 bg-slate-900 border-t lg:border-t-0 lg:border-r border-slate-800 overflow-y-auto max-h-[40vh] lg:max-h-full space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h5 class="text-xs font-black text-slate-300 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span>قائمة الفيديوهات (التسلسل التلقائي)</span>
                    </h5>
                    <span class="text-[10px] bg-slate-800 text-brand-400 font-bold px-2 py-0.5 rounded-full" x-text="(currentIndex + 1) + ' / ' + playlist.length"></span>
                </div>

                <div class="space-y-2.5">
                    <template x-for="(vid, idx) in playlist" :key="idx">
                        <div @click="selectVideo(idx)" 
                             :class="idx === currentIndex ? 'bg-brand-900/40 border-brand-500/60 text-white' : 'bg-slate-950/60 border-slate-800/80 text-slate-400 hover:bg-slate-800/80 hover:text-slate-200'"
                             class="p-3 rounded-2xl border transition-all duration-200 cursor-pointer flex items-center gap-3 group">
                            
                            <!-- Thumbnail with Playing Indicator -->
                            <div class="w-16 h-12 rounded-xl bg-slate-800 overflow-hidden relative flex-shrink-0">
                                <img :src="'https://img.youtube.com/vi/' + vid.ytId + '/hqdefault.jpg'" class="w-full h-full object-cover">
                                <div x-show="idx === currentIndex" class="absolute inset-0 bg-brand-600/70 flex items-center justify-center">
                                    <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h6 class="text-xs font-bold truncate group-hover:text-brand-400 transition-colors" x-text="vid.title"></h6>
                                <span class="text-[10px] text-slate-500 mt-0.5 block" x-text="idx === currentIndex ? 'قيد التشغيل الآن...' : 'انقر للتشغيل'"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>

    <!-- Alpine.js Auto-Next Playlist Controller Script -->
    <script>
        function videoPlaylistPlayer() {
            return {
                currentIndex: 0,
                playlist: [
                    { title: "تغطية ميكاترونكس والتحكم الآلي — WorldSkills Algeria", ytId: "nzy4f7GBSVw" },
                    { title: "تغطية حلول البرمجيات والأمن السيبراني — WorldSkills Algeria", ytId: "ee7fzNFUKIM" },
                    { title: "تغطية التصنيع وتكنولوجيا الهندسة — WorldSkills Algeria", ytId: "K0zLspMssns" },
                    { title: "تغطية تكنولوجيا البناء المستدام — WorldSkills Algeria", ytId: "nzy4f7GBSVw" }
                ],
                get currentVideo() {
                    return this.playlist[this.currentIndex] || this.playlist[0];
                },
                selectVideo(idx) {
                    this.currentIndex = idx;
                    this.reloadPlayer();
                },
                nextVideo() {
                    this.currentIndex = (this.currentIndex + 1) % this.playlist.length;
                    this.reloadPlayer();
                },
                prevVideo() {
                    this.currentIndex = (this.currentIndex - 1 + this.playlist.length) % this.playlist.length;
                    this.reloadPlayer();
                },
                reloadPlayer() {
                    var iframe = document.getElementById('wsap-yt-player');
                    if (iframe) {
                        iframe.src = 'https://www.youtube-nocookie.com/embed/' + this.currentVideo.ytId + '?enablejsapi=1&autoplay=1&rel=0';
                    }
                },
                closeModal() {
                    this.$data.showVideoModal = false;
                }
            };
        }
    </script>
    </div>

</div>
