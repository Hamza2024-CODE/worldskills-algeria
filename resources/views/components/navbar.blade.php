<header class="sticky top-0 z-50 wsap-glass bg-white/95 border-b border-slate-200/80 shadow-sm" x-data="{ mobileMenuOpen: false, activeMenu: null }" style="padding-top: env(safe-area-inset-top, 0px);">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20 gap-2">
            
            <!-- Official Brand Logos (Ministry Logo FIRST, WorldSkills Algeria SECOND) -->
            @php
                $siteLogo = app(\App\Services\SettingsEngine::class)->get('site_logo', '/logo.svg');
                $logoUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : asset($siteLogo);
            @endphp
            <a href="{{ route('home') }}" class="flex items-center gap-1.5 sm:gap-3.5 group shrink-0 py-1 max-w-[55%] sm:max-w-none" title="الجمهورية الجزائرية الديمقراطية الشعبية — وزارة التكوين والتعليم المهنيين — أولمبياد المهن 2026">
                <!-- 1. Official Ministry Logo FIRST -->
                <img src="/ministry-logo-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-7 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                
                <!-- Separator Line -->
                <div class="h-5 sm:h-9 w-px bg-slate-200/90 shrink-0"></div>

                <!-- 2. WorldSkills Algeria Logo SECOND -->
                <img src="{{ $logoUrl }}" alt="WorldSkills Algeria Logo" class="h-7 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </a>

            <!-- Desktop Menu Navigation -->
            <nav class="hidden lg:flex items-center gap-4 xl:gap-5">
                <a href="{{ route('home') }}" class="px-3.5 py-1.5 rounded-full {{ request()->routeIs('home') ? 'bg-brand-500 text-white shadow-sm' : 'text-[#06205C] hover:text-brand-500' }} font-bold text-xs transition">{{ __('messages.home') }}</a>
                <a href="{{ route('guide') }}" class="text-xs font-bold text-[#06205C] hover:text-brand-500 transition">{{ __('messages.about') }}</a>

                <!-- Competition Dropdown -->
                <div class="relative" @click.outside="if (activeMenu === 'comp') activeMenu = null">
                    <button @click="activeMenu = (activeMenu === 'comp' ? null : 'comp')" class="flex items-center gap-1 text-xs font-bold text-[#06205C] hover:text-brand-500 transition py-2">
                        <span>{{ __('messages.competition') }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="activeMenu === 'comp' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeMenu === 'comp'" x-cloak x-transition class="absolute top-full ltr:left-0 rtl:right-0 mt-2 w-52 rounded-2xl bg-white shadow-xl border border-slate-100 py-2 z-50">
                        <a href="{{ route('skills') }}" class="block px-4 py-2 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-500">{{ __('messages.skills') }}</a>
                        <a href="{{ route('regulations') }}" class="block px-4 py-2 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-500">{{ __('messages.regulations') }}</a>
                        <a href="{{ route('schedule') }}" class="block px-4 py-2 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-500">{{ __('messages.schedule') }}</a>
                        <a href="{{ route('guide.regulations') }}" class="block px-4 py-2 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-500 border-t border-slate-100 mt-1 pt-2 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            {{ __('messages.guide_regulations_nav') }}
                        </a>
                    </div>
                </div>

                <!-- Media Dropdown -->
                <div class="relative" @click.outside="if (activeMenu === 'media') activeMenu = null">
                    <button @click="activeMenu = (activeMenu === 'media' ? null : 'media')" class="flex items-center gap-1 text-xs font-bold text-[#06205C] hover:text-brand-500 transition py-2">
                        <span>{{ __('messages.media') }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="activeMenu === 'media' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeMenu === 'media'" x-cloak x-transition class="absolute top-full ltr:left-0 rtl:right-0 mt-2 w-52 rounded-2xl bg-white shadow-xl border border-slate-100 py-2 z-50">
                        <a href="{{ route('news') }}" class="block px-4 py-2 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-500">{{ __('messages.news') }}</a>
                        <a href="{{ route('events') }}" class="block px-4 py-2 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-500">{{ __('messages.events') }}</a>
                        <a href="{{ route('gallery') }}" class="block px-4 py-2 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-500">{{ __('messages.gallery') }}</a>
                        <a href="{{ route('videos') }}" class="block px-4 py-2 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-500">{{ __('messages.videos') }}</a>
                        <a href="{{ route('live-tv') }}" target="_blank" class="block px-4 py-2 text-xs font-black text-rose-600 hover:bg-rose-50 border-t border-slate-100 mt-1 pt-2 flex items-center justify-between">
                            <span>{{ app()->getLocale() === 'fr' ? 'Direct TV (Écrans)' : (app()->getLocale() === 'en' ? 'Live TV Broadcast' : 'شاشة البث المباشر (Live TV)') }}</span>
                            <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping"></span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('results') }}" class="text-xs font-bold text-[#06205C] hover:text-brand-500 transition">{{ __('messages.results') }}</a>

                @if(app(\App\Services\SettingsEngine::class)->get('page_partners_enabled', true))
                    <a href="{{ route('partners') }}" class="text-xs font-bold text-[#06205C] hover:text-brand-500 transition">{{ __('messages.partners') }}</a>
                @endif
                <a href="{{ route('contact') }}" class="text-xs font-bold text-[#06205C] hover:text-brand-500 transition">{{ __('messages.contact') }}</a>
            </nav>

            <!-- Actions Right Area (Responsive Mobile Friendly) -->
            <div class="flex items-center gap-1.5 sm:gap-2.5 shrink-0">
                
                <!-- PWA Install Trigger Button -->
                <button type="button" @click="window.dispatchEvent(new CustomEvent('open-pwa-installer'))" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-brand-50 hover:bg-brand-100 flex items-center justify-center text-brand-600 transition shrink-0 shadow-xs" title="{{ app()->getLocale() === 'fr' ? 'Installer l\'application PWA' : (app()->getLocale() === 'en' ? 'Install PWA App' : 'تثبيت تطبيق المنصة 📱') }}">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </button>

                <!-- Search Button -->
                <a href="{{ route('search') }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition shrink-0" title="Search">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </a>

                <!-- Language Switcher Component -->
                <div class="shrink-0">
                    <x-language-switcher />
                </div>

                @auth
                    @php
                        $user = auth()->user();
                        $dashboardRoute = match (true) {
                            $user->hasRole(\App\Enums\RoleEnum::SUPER_ADMIN->value) => route('admin.dashboard'),
                            $user->hasRole(\App\Enums\RoleEnum::MEDIA_MANAGER->value) => route('admin.media.dashboard'),
                            $user->hasRole(\App\Enums\RoleEnum::EXECUTIVE_VIEWER->value) => route('executive.dashboard'),
                            $user->hasRole(\App\Enums\RoleEnum::COUNTRY_ADMIN->value) => route('country.dashboard'),
                            $user->hasRole(\App\Enums\RoleEnum::ORGANIZATION_ADMIN->value) => route('organization.dashboard'),
                            $user->hasRole(\App\Enums\RoleEnum::JUDGE->value) => route('judge.dashboard'),
                            default => route('participant.dashboard'),
                        };
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="px-2.5 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-brand-50 text-brand-500 hover:bg-brand-100 font-bold text-xs transition whitespace-nowrap">
                        {{ __('messages.dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl border border-slate-300 hover:border-brand-400 text-[#06205C] hover:text-brand-600 hover:bg-blue-50 font-bold text-xs transition whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        {{ __('messages.login') }}
                    </a>
                    
                    @php
                        $settingsEngine = app(\App\Services\SettingsEngine::class);
                        $regCompetitors = (bool) $settingsEngine->get('registration_competitors_enabled', true);
                        $regSupporters  = (bool) $settingsEngine->get('registration_supporters_enabled', true);
                        $regAccreditation = (bool) $settingsEngine->get('registration_accreditation_enabled', true);
                    @endphp
                    <div class="relative shrink-0 hidden sm:block" @click.outside="if (activeMenu === 'reg') activeMenu = null">
                        <button @click="activeMenu = (activeMenu === 'reg' ? null : 'reg')" type="button" class="px-3 sm:px-4 py-1.5 sm:py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all flex items-center gap-1.5 whitespace-nowrap">
                            <span>{{ __('messages.register') }}</span>
                            <svg class="w-3.5 h-3.5 text-white/80 transition-transform duration-200" :class="activeMenu === 'reg' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="activeMenu === 'reg'" x-cloak x-transition class="absolute top-full ltr:right-0 rtl:left-0 mt-2 w-72 rounded-2xl bg-white shadow-xl border border-slate-100 py-2 z-50 text-start">
                            <a href="{{ route('registration') }}" class="block px-4 py-2.5 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-600 border-b border-slate-100">
                                <div class="font-extrabold text-slate-900 flex items-center justify-between gap-1.5">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-brand-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                        <span>{{ app()->getLocale() === 'fr' ? 'Inscription Compétiteurs & Jeunes' : (app()->getLocale() === 'en' ? 'Competitors & Youth Registration' : 'تسجيل المتنافسين والشباب') }}</span>
                                    </div>
                                    <span class="text-[9px] px-2 py-0.5 rounded-full font-black shrink-0 {{ $regCompetitors ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $regCompetitors ? 'مفتوح' : 'مغلق' }}
                                    </span>
                                </div>
                                <div class="text-[10px] text-slate-400 font-medium mt-0.5">
                                    {{ app()->getLocale() === 'fr' ? 'Inscription des candidats et participants aux métiers' : (app()->getLocale() === 'en' ? 'Registration of candidates and skill participants' : 'تسجيل المترشحين والمشاركين في التخصصات') }}
                                </div>
                            </a>

                            <a href="{{ route('official.registration') }}" class="block px-4 py-2.5 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-600 border-b border-slate-100">
                                <div class="font-extrabold text-indigo-900 flex items-center justify-between gap-1.5">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <span>{{ app()->getLocale() === 'fr' ? 'Inscription Supporteurs Officiels & Visiteurs' : (app()->getLocale() === 'en' ? 'Official Supporters Registration' : 'تسجيل التشجيع الرسمي والزوار') }}</span>
                                    </div>
                                    <span class="text-[9px] px-2 py-0.5 rounded-full font-black shrink-0 {{ $regSupporters ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $regSupporters ? 'مفتوح' : 'مغلق' }}
                                    </span>
                                </div>
                            </a>

                            <a href="{{ route('official.registration') }}" class="block px-4 py-2.5 text-xs font-bold text-[#06205C] hover:bg-slate-50 hover:text-brand-600">
                                <div class="font-extrabold text-indigo-900 flex items-center justify-between gap-1.5">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5 5 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5 5 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                                        <span>{{ app()->getLocale() === 'fr' ? 'Accréditation Officielle' : (app()->getLocale() === 'en' ? 'Official Accreditation' : 'تسجيل الاعتماد الشارات والحكام') }}</span>
                                    </div>
                                    <span class="text-[9px] px-2 py-0.5 rounded-full font-black shrink-0 {{ $regAccreditation ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $regAccreditation ? 'مفتوح' : 'مغلق' }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endauth

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen; window.dispatchEvent(new CustomEvent('mobile-menu-toggled', { detail: mobileMenuOpen }))" type="button" class="lg:hidden w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-[#06205C] transition shrink-0 ml-1" aria-label="Toggle Navigation Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <template x-teleport="body">
        <div x-show="mobileMenuOpen" x-cloak class="fixed inset-0 z-50 lg:hidden pointer-events-auto">
            
            <!-- Dark Backdrop Overlay -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileMenuOpen = false; window.dispatchEvent(new CustomEvent('mobile-menu-toggled', { detail: false }))"
                 class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-40"></div>

            <!-- Slide-Over Drawer Body -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="{{ app()->getLocale() === 'ar' ? '-translate-x-full' : 'translate-x-full' }}"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="{{ app()->getLocale() === 'ar' ? '-translate-x-full' : 'translate-x-full' }}"
                 class="fixed top-0 bottom-0 ltr:right-0 rtl:left-0 w-80 sm:w-96 max-w-[85vw] bg-white shadow-2xl z-50 flex flex-col justify-between overflow-y-auto p-5 sm:p-6 text-start border-s border-slate-200">
                
                <!-- Drawer Top Bar -->
                <div class="space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        @php
                            $siteLogo = app(\App\Services\SettingsEngine::class)->get('site_logo', '/logo.svg');
                            $logoUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : asset($siteLogo);
                        @endphp
                        <div class="flex items-center gap-2">
                            <img src="/ministry-logo-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-8.5 w-auto object-contain">
                            <div class="h-6 w-px bg-slate-200 shrink-0"></div>
                            <img src="{{ $logoUrl }}" alt="WorldSkills Logo" class="h-8.5 w-auto object-contain">
                        </div>
                        
                        <button @click="mobileMenuOpen = false; window.dispatchEvent(new CustomEvent('mobile-menu-toggled', { detail: false }))" type="button" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold flex items-center justify-center transition" aria-label="Close">
                            ✕
                        </button>
                    </div>

                    <!-- Menu Nav Links -->
                    <nav class="space-y-1.5">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black {{ request()->routeIs('home') ? 'bg-[#0066FF] text-white shadow-md' : 'text-[#06205C] hover:bg-slate-50' }} transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>{{ __('messages.home') }}</span>
                        </a>

                        <a href="{{ route('guide') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black text-[#06205C] hover:bg-slate-50 transition">
                            <svg class="w-4 h-4 text-brand-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ __('messages.about') }}</span>
                        </a>

                        <a href="{{ route('skills') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black text-[#06205C] hover:bg-slate-50 transition">
                            <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.187-2.19l.732-4.393A2 2 0 017.11 6.814l3.176.635a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.642 1.964v6.22a2 2 0 01-.927 1.69z"/></svg>
                            <span>{{ __('messages.skills') }}</span>
                        </a>

                        <a href="{{ route('registration') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black text-brand-600 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition">
                            <svg class="w-4 h-4 text-brand-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Inscription Compétiteurs & Jeunes' : (app()->getLocale() === 'en' ? 'Competitors Registration' : 'تسجيل المتنافسين والشباب') }}</span>
                        </a>

                        <a href="{{ route('official.registration') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 transition">
                            <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5 5 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5 5 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Accréditation & Inscription Officielle' : (app()->getLocale() === 'en' ? 'Official Registration & Accreditation' : 'التسجيل الرسمي والاعتماد (حكام / صحافة / وفود)') }}</span>
                        </a>

                        <a href="{{ route('regulations') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black text-[#06205C] hover:bg-slate-50 transition">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ __('messages.regulations') }}</span>
                        </a>

                        <a href="{{ route('schedule') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black text-[#06205C] hover:bg-slate-50 transition">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ __('messages.schedule') }}</span>
                        </a>

                        <a href="{{ route('guide.regulations') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black text-[#0066FF] bg-blue-50 hover:bg-blue-100 transition border border-blue-100">
                            <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>{{ __('messages.guide_regulations_title') }}</span>
                        </a>

                        <a href="{{ route('news') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black text-[#06205C] hover:bg-slate-50 transition">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            <span>{{ __('messages.news') }}</span>
                        </a>

                        <a href="{{ route('results') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black text-[#06205C] hover:bg-slate-50 transition">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 00-2 2h2a2 2 0 00-2-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span>{{ __('messages.results') }}</span>
                        </a>

                        <a href="{{ route('live-tv') }}" target="_blank" class="flex items-center justify-between px-4 py-3 rounded-2xl text-xs font-black text-rose-600 bg-rose-50 border border-rose-200 transition">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span>{{ app()->getLocale() === 'fr' ? 'Direct TV (Écrans)' : (app()->getLocale() === 'en' ? 'Live TV Broadcast' : 'شاشة البث المباشر (Live TV)') }}</span>
                            </div>
                            <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping"></span>
                        </a>
                    </nav>
                </div>

                <!-- Bottom Quick Action Buttons -->
                <div class="pt-6 border-t border-slate-100 space-y-3">
                    @auth
                        @php
                            $user = auth()->user();
                            $dashboardRoute = match (true) {
                                $user->hasRole(\App\Enums\RoleEnum::SUPER_ADMIN->value) => route('admin.dashboard'),
                                $user->hasRole(\App\Enums\RoleEnum::MEDIA_MANAGER->value) => route('admin.media.dashboard'),
                                $user->hasRole(\App\Enums\RoleEnum::EXECUTIVE_VIEWER->value) => route('executive.dashboard'),
                                $user->hasRole(\App\Enums\RoleEnum::COUNTRY_ADMIN->value) => route('country.dashboard'),
                                $user->hasRole(\App\Enums\RoleEnum::ORGANIZATION_ADMIN->value) => route('organization.dashboard'),
                                $user->hasRole(\App\Enums\RoleEnum::JUDGE->value) => route('judge.dashboard'),
                                default => route('participant.dashboard'),
                            };
                        @endphp
                        <a href="{{ $dashboardRoute }}" class="w-full py-3 rounded-xl bg-brand-500 hover:bg-brand-600 text-white text-center font-black text-xs shadow-md transition flex items-center justify-center gap-2">
                            <span>{{ __('messages.dashboard') }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full py-3 rounded-xl border-2 border-slate-200 text-center font-black text-xs text-[#06205C] hover:bg-slate-50 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            <span>{{ __('messages.login') }}</span>
                        </a>
                        <a href="{{ route('registration') }}" class="w-full py-3 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white text-center font-black text-xs shadow-lg shadow-blue-500/20 transition flex items-center justify-center gap-2">
                            <span>{{ __('messages.register') }}</span>
                        </a>
                    @endguest
                </div>

            </div>
        </div>
    </template>
</header>
