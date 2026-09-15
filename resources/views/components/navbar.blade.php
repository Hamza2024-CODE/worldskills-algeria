@php
    $siteLogo = app(\App\Services\SettingsEngine::class)->get('site_logo', '/logo.svg');
    $logoUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : asset($siteLogo);
    $locale = app()->getLocale();
@endphp

<header class="sticky top-3 sm:top-4 z-50 w-full px-3 sm:px-6 lg:px-8 pointer-events-none {{ request()->routeIs('home') ? '-mb-20 sm:-mb-24' : 'mb-6 sm:mb-10' }}" x-data="{ mobileMenuOpen: false, activeDropdown: null }">
    <div class="max-w-[1360px] mx-auto rounded-full bg-white/75 dark:bg-white/85 backdrop-blur-2xl border border-white/80 shadow-[0_10px_35px_rgba(0,0,0,0.08)] p-1.5 sm:p-2 flex items-center justify-between gap-2 pointer-events-auto">

        <!-- ═════════════════════════════════════════════════════════════════
             1. RIGHT: OFFICIAL LOGO CAPSULE (Translucent White Glass Pill)
             ═════════════════════════════════════════════════════════════════ -->
        <a href="{{ route('home') }}" class="bg-white/95 px-3 sm:px-4 py-1.5 rounded-full flex items-center gap-2 sm:gap-3 shrink-0 shadow-2xs border border-slate-200/60 group ws-transition hover:shadow-xs" title="الجمهورية الجزائرية الديمقراطية الشعبية — وزارة التكوين والتعليم المهنيين — أولمبياد المهن 2026">
            <!-- 1. Ministry Logo FIRST -->
            <img src="/ministry-logo-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-6 sm:h-8 w-auto object-contain ws-transition group-hover:scale-105">

            <!-- Separator -->
            <div class="h-4 sm:h-6 w-px bg-slate-200 shrink-0"></div>

            <!-- 2. WorldSkills Algeria Logo SECOND -->
            <img src="{{ $logoUrl }}" alt="WorldSkills Algeria Logo" class="h-6 sm:h-8 w-auto object-contain ws-transition group-hover:scale-105">
        </a>

        <!-- ═════════════════════════════════════════════════════════════════
             2. CENTER: NAVIGATION CAPSULE MENU (Frosted Glass Pill)
             ═════════════════════════════════════════════════════════════════ -->
        <nav class="hidden xl:flex items-center gap-1 bg-slate-100/80 p-1 rounded-full border border-slate-200/60 shadow-2xs">
            <!-- Home (Active Pill) -->
            <a href="{{ route('home') }}" class="px-4 py-1.5 rounded-full font-black text-xs sm:text-sm ws-transition {{ request()->routeIs('home') ? 'bg-[#0F172A] text-white shadow-xs' : 'text-slate-800 hover:text-ws-primary hover:bg-white/80' }}">
                {{ __('messages.home') }}
            </a>

            <!-- Skills / Trades Dropdown -->
            <div class="relative" @click.outside="if (activeDropdown === 'skills') activeDropdown = null">
                <button
                    @click="activeDropdown = (activeDropdown === 'skills' ? null : 'skills')"
                    class="px-3.5 py-1.5 rounded-full font-bold text-xs sm:text-sm flex items-center gap-1 ws-transition {{ request()->routeIs('skills*') ? 'bg-[#0F172A] text-white shadow-xs' : 'text-slate-800 hover:text-ws-primary hover:bg-white/80' }}"
                >
                    <span>{{ __('messages.skills') }}</span>
                    <svg class="w-3.5 h-3.5 text-slate-500 ws-transition" :class="activeDropdown === 'skills' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div
                    x-show="activeDropdown === 'skills'"
                    x-cloak
                    x-transition:enter="ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="absolute top-full mt-2 ltr:left-0 rtl:right-0 w-56 rounded-ws-md bg-white text-ws-slate shadow-2xl border border-ws-border py-2 z-50 text-start"
                >
                    <a href="{{ route('skills') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 hover:text-ws-primary ws-transition">
                        {{ __('messages.skills') }}
                    </a>
                    <a href="{{ route('guide.regulations') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 hover:text-ws-primary ws-transition">
                        {{ __('messages.guide_regulations_nav') }}
                    </a>
                </div>
            </div>

            <!-- Participation Guide (دليل المشاركة في أولمبياد المهن) -->
            <a href="{{ route('guide') }}" class="px-3.5 py-1.5 rounded-full font-bold text-xs sm:text-sm ws-transition {{ request()->routeIs('guide') ? 'bg-[#0F172A] text-white shadow-xs' : 'text-slate-800 hover:text-ws-primary hover:bg-white/80' }}">
                {{ app()->getLocale() === 'fr' ? 'Guide de Participation' : (app()->getLocale() === 'en' ? 'Participation Guide' : 'دليل المشاركة') }}
            </a>

            <!-- About / Regulations Dropdown -->
            <div class="relative" @click.outside="if (activeDropdown === 'about') activeDropdown = null">
                <button
                    @click="activeDropdown = (activeDropdown === 'about' ? null : 'about')"
                    class="px-3.5 py-1.5 rounded-full font-bold text-xs sm:text-sm flex items-center gap-1 ws-transition {{ request()->routeIs('regulations*') || request()->routeIs('schedule*') ? 'bg-[#0F172A] text-white shadow-xs' : 'text-slate-800 hover:text-ws-primary hover:bg-white/80' }}"
                >
                    <span>{{ $locale === 'fr' ? 'À Propos' : ($locale === 'en' ? 'About Olympiad' : 'عن الأولمبياد') }}</span>
                    <svg class="w-3.5 h-3.5 text-slate-500 ws-transition" :class="activeDropdown === 'about' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div
                    x-show="activeDropdown === 'about'"
                    x-cloak
                    x-transition:enter="ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="absolute top-full mt-2 ltr:left-0 rtl:right-0 w-56 rounded-ws-md bg-white text-ws-slate shadow-2xl border border-ws-border py-2 z-50 text-start"
                >
                    <a href="{{ route('regulations') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 hover:text-ws-primary ws-transition">
                        {{ __('messages.regulations') }}
                    </a>
                    <a href="{{ route('schedule') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 hover:text-ws-primary ws-transition">
                        {{ __('messages.schedule') }}
                    </a>
                    <a href="{{ route('results') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 hover:text-ws-primary ws-transition">
                        {{ __('messages.results') }}
                    </a>
                    <a href="{{ route('partners') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 hover:text-ws-primary ws-transition border-t border-slate-100 mt-1 pt-2">
                        {{ __('messages.partners') }}
                    </a>
                    <a href="{{ route('verify') }}" class="block px-4 py-2 text-xs font-bold text-emerald-600 hover:bg-emerald-50 ws-transition">
                        {{ __('messages.verify_nav') }}
                    </a>
                </div>
            </div>

            <!-- Media Dropdown -->
            <div class="relative" @click.outside="if (activeDropdown === 'media') activeDropdown = null">
                <button
                    @click="activeDropdown = (activeDropdown === 'media' ? null : 'media')"
                    class="px-3.5 py-1.5 rounded-full font-bold text-xs sm:text-sm flex items-center gap-1 ws-transition {{ request()->routeIs('news*') || request()->routeIs('events*') || request()->routeIs('gallery*') || request()->routeIs('videos*') ? 'bg-[#0F172A] text-white shadow-xs' : 'text-slate-800 hover:text-ws-primary hover:bg-white/80' }}"
                >
                    <span>{{ __('messages.media') }}</span>
                    <svg class="w-3.5 h-3.5 text-slate-500 ws-transition" :class="activeDropdown === 'media' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div
                    x-show="activeDropdown === 'media'"
                    x-cloak
                    x-transition:enter="ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="absolute top-full mt-2 ltr:left-0 rtl:right-0 w-56 rounded-ws-md bg-white text-ws-slate shadow-2xl border border-ws-border py-2 z-50 text-start"
                >
                    <a href="{{ route('news') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 hover:text-ws-primary ws-transition">
                        {{ __('messages.news') }}
                    </a>
                    <a href="{{ route('events') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 hover:text-ws-primary ws-transition">
                        {{ __('messages.events') }}
                    </a>
                    <a href="{{ route('gallery') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 hover:text-ws-primary ws-transition">
                        {{ __('messages.gallery') }}
                    </a>
                    <a href="{{ route('videos') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 hover:text-ws-primary ws-transition">
                        {{ __('messages.videos') }}
                    </a>
                    <a href="{{ route('live-tv') }}" target="_blank" class="block px-4 py-2 text-xs font-black text-rose-600 hover:bg-rose-50 border-t border-slate-100 mt-1 pt-2 flex items-center justify-between ws-transition">
                        <span>{{ $locale === 'fr' ? 'Direct TV (Écrans)' : ($locale === 'en' ? 'Live TV Broadcast' : 'شاشة البث المباشر (Live TV)') }}</span>
                        <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping"></span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- ═════════════════════════════════════════════════════════════════
             3. BADGES & TOOLS: STATUS PILL, LANG, MOON TOGGLE
             ═════════════════════════════════════════════════════════════════ -->
        <div class="hidden lg:flex items-center gap-2 shrink-0">
            <!-- Registrations Open Live Pulse Badge -->
            <a href="{{ route('registration') }}" class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/90 text-xs font-black flex items-center gap-2 ws-transition hover:bg-emerald-100 shadow-2xs" title="انطلاق التسجيلات الرسمية للأولمبياد">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shrink-0"></span>
                <span>{{ $locale === 'fr' ? 'Inscriptions Ouvertes' : ($locale === 'en' ? 'Registrations Open' : 'التسجيلات مفتوحة') }}</span>
            </a>

            <!-- Language Switcher Pill -->
            <div class="relative" x-data="{ langOpen: false }">
                <button
                    @click="langOpen = !langOpen"
                    @click.outside="langOpen = false"
                    type="button"
                    class="px-2.5 py-1.5 rounded-full bg-slate-100/90 text-slate-800 hover:bg-slate-200/80 border border-slate-200/80 text-xs font-bold flex items-center gap-1.5 ws-transition shadow-2xs"
                    aria-label="تغيير اللغة"
                >
                    <svg class="w-3.5 h-3.5 text-ws-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    <span class="uppercase font-mono text-[11px] font-black">{{ $locale }}</span>
                </button>

                <div
                    x-show="langOpen"
                    x-cloak
                    x-transition
                    class="absolute top-full mt-2 ltr:right-0 rtl:left-0 w-36 rounded-ws-md bg-white text-ws-slate shadow-2xl border border-ws-border py-1.5 z-50 text-start"
                >
                    <a href="{{ route('lang.switch', 'ar') }}" class="flex items-center justify-between px-3 py-1.5 text-xs font-bold hover:bg-slate-50 {{ $locale === 'ar' ? 'text-ws-primary font-black' : '' }}">
                        <span>العربية</span>
                        <span class="font-mono text-[10px] text-slate-400">AR</span>
                    </a>
                    <a href="{{ route('lang.switch', 'fr') }}" class="flex items-center justify-between px-3 py-1.5 text-xs font-bold hover:bg-slate-50 {{ $locale === 'fr' ? 'text-ws-primary font-black' : '' }}">
                        <span>Français</span>
                        <span class="font-mono text-[10px] text-slate-400">FR</span>
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" class="flex items-center justify-between px-3 py-1.5 text-xs font-bold hover:bg-slate-50 {{ $locale === 'en' ? 'text-ws-primary font-black' : '' }}">
                        <span>English</span>
                        <span class="font-mono text-[10px] text-slate-400">EN</span>
                    </a>
                </div>
            </div>

            <!-- Dark Mode Moon Icon Button -->
            <button
                type="button"
                class="w-8 h-8 rounded-full bg-slate-100/90 hover:bg-slate-200/80 text-slate-700 border border-slate-200/80 flex items-center justify-center ws-transition shadow-2xs"
                title="الوضع المظلم / الفاتح"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </button>
        </div>

        <!-- ═════════════════════════════════════════════════════════════════
             4. LEFT: CTA BUTTONS (+ تسجيل جديد & تسجيل الدخول)
             ═════════════════════════════════════════════════════════════════ -->
        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
            @auth
                <a
                    href="{{ auth()->user()->hasRole('SUPER_ADMIN') ? route('admin.dashboard') : (auth()->user()->hasRole('COUNTRY_ADMIN') ? route('country.dashboard') : route('profile')) }}"
                    class="bg-white text-ws-slate hover:bg-slate-50 font-black px-4 py-2 rounded-full text-xs sm:text-sm flex items-center gap-1.5 shadow-sm border border-slate-200/80 ws-transition"
                >
                    <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                    <span>{{ __('messages.my_space') ?? 'مساحتي' }}</span>
                </a>
            @else
                <!-- + تسجيل جديد (Cyan Button with Dropdown Choice) -->
                <div class="relative" @click.outside="if (activeDropdown === 'register') activeDropdown = null">
                    <button
                        type="button"
                        @click="activeDropdown = (activeDropdown === 'register' ? null : 'register')"
                        class="bg-[#00B8FF] hover:bg-[#38C6FF] text-[#041235] font-black px-3.5 sm:px-4 py-2 rounded-full text-xs sm:text-sm flex items-center gap-1.5 shadow-sm ws-transition active:translate-y-[1px] cursor-pointer"
                        aria-expanded="false"
                        :aria-expanded="activeDropdown === 'register'"
                    >
                        <span class="text-base leading-none font-bold">+</span>
                        <span>{{ $locale === 'fr' ? 'Inscription' : ($locale === 'en' ? 'Register' : 'تسجيل جديد') }}</span>
                        <svg class="w-3.5 h-3.5 text-[#041235] ws-transition shrink-0" :class="activeDropdown === 'register' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- Dropdown Options Menu -->
                    <div
                        x-show="activeDropdown === 'register'"
                        x-cloak
                        x-transition:enter="ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        class="absolute top-full mt-2 rtl:left-0 ltr:right-0 w-72 sm:w-80 rounded-ws-md bg-white/95 backdrop-blur-xl text-ws-slate shadow-[0_20px_50px_rgba(0,0,0,0.18)] border border-slate-200/90 p-2 z-50 text-start space-y-1.5"
                    >
                        <!-- Header inside Dropdown -->
                        <div class="px-3 py-1.5 border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-wider flex items-center justify-between">
                            <span>{{ $locale === 'fr' ? 'Choisir le type d inscription' : ($locale === 'en' ? 'Choose Registration Type' : 'اختر نوع التسجيل في الأولمبياد') }}</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        </div>

                        <!-- 1. Competitor Registration Option -->
                        <a
                            href="{{ route('registration') }}"
                            class="group flex items-start gap-3 p-2.5 sm:p-3 rounded-ws-sm hover:bg-sky-50/80 border border-transparent hover:border-sky-200 ws-transition"
                        >
                            <div class="w-9 h-9 rounded-full bg-sky-100 text-[#0052CC] flex items-center justify-center shrink-0 group-hover:scale-105 ws-transition shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-1">
                                    <span class="text-xs font-black text-slate-900 group-hover:text-ws-primary ws-transition">
                                        {{ $locale === 'fr' ? 'Inscription Compétiteur' : ($locale === 'en' ? 'Competitor Registration' : 'تسجيل متنافس / مترشح') }}
                                    </span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-sky-100 text-sky-800">
                                        {{ $locale === 'fr' ? 'Métiers' : ($locale === 'en' ? 'Skills' : 'مهن') }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">
                                    {{ $locale === 'fr' ? 'Pour les candidats aux épreuves et métiers WorldSkills.' : ($locale === 'en' ? 'For contestants competing in skills and trades.' : 'خاص بالمترشحين المتنافسين في مختلف تخصصات ومسابقات المهارات.') }}
                                </p>
                            </div>
                        </a>

                        <!-- 2. Official Delegation Option -->
                        <a
                            href="{{ route('official.registration') }}"
                            class="group flex items-start gap-3 p-2.5 sm:p-3 rounded-ws-sm hover:bg-amber-50/80 border border-transparent hover:border-amber-200 ws-transition"
                        >
                            <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 group-hover:scale-105 ws-transition shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-1">
                                    <span class="text-xs font-black text-slate-900 group-hover:text-amber-700 ws-transition">
                                        {{ $locale === 'fr' ? 'Délégations Officielles' : ($locale === 'en' ? 'Official Delegation' : 'تسجيل الوفود الرسمية') }}
                                    </span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-amber-100 text-amber-800">
                                        {{ $locale === 'fr' ? 'Officiel' : ($locale === 'en' ? 'Official' : 'رسمي') }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">
                                    {{ $locale === 'fr' ? 'Chefs de délégations, experts, jurys et invités officiels.' : ($locale === 'en' ? 'Delegation heads, experts, technical jury and VIPs.' : 'لرؤساء الوفود، الخبراء التقنيين، الحكام والمؤطرين والضيوف الرسميين.') }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- تسجيل الدخول (White Pill with Green Door Icon) -->
                <a
                    href="{{ route('login') }}"
                    class="bg-white text-slate-900 hover:bg-slate-50 font-black px-3.5 sm:px-4 py-2 rounded-full text-xs sm:text-sm flex items-center gap-1.5 shadow-sm border border-slate-200/90 ws-transition active:translate-y-[1px]"
                >
                    <span class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    </span>
                    <span>{{ __('messages.login') }}</span>
                </a>
            @endauth

            <!-- Mobile Drawer Toggle Button -->
            <button
                type="button"
                @click="mobileMenuOpen = !mobileMenuOpen"
                class="xl:hidden w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-800 flex items-center justify-center ws-transition border border-slate-200"
                aria-label="القائمة"
            >
                <svg class="w-5 h-5" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                <svg class="w-5 h-5" x-show="mobileMenuOpen" x-cloak fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

    </div>

    <!-- Mobile Drawer Off-Canvas Menu -->
    <div
        x-show="mobileMenuOpen"
        x-cloak
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="xl:hidden mt-2 max-w-[1360px] mx-auto rounded-3xl bg-white/95 backdrop-blur-2xl border border-white/80 p-5 shadow-2xl text-start pointer-events-auto space-y-3"
    >
        @guest
            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200 space-y-2 text-start">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">{{ $locale === 'fr' ? 'Portail d inscription' : ($locale === 'en' ? 'Registration Portal' : 'بوابات التسجيل في الأولمبياد') }}</span>
                <div class="grid grid-cols-1 gap-2">
                    <a href="{{ route('registration') }}" class="p-2.5 rounded-ws-sm bg-sky-50 hover:bg-sky-100 text-sky-900 border border-sky-200 flex items-center gap-2.5 font-bold text-xs ws-transition">
                        <span class="w-6 h-6 rounded-full bg-sky-500 text-white flex items-center justify-center text-xs shrink-0 font-bold">+</span>
                        <div class="flex flex-col">
                            <span>{{ $locale === 'fr' ? 'Inscription Compétiteur' : ($locale === 'en' ? 'Competitor Registration' : 'تسجيل متنافس / مترشح') }}</span>
                            <span class="text-[10px] text-sky-700 font-normal">{{ $locale === 'fr' ? 'Pour les candidats aux métiers' : 'خاص بالمترشحين المتنافسين' }}</span>
                        </div>
                    </a>
                    <a href="{{ route('official.registration') }}" class="p-2.5 rounded-ws-sm bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 flex items-center gap-2.5 font-bold text-xs ws-transition">
                        <span class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs shrink-0 font-bold"><x-ws.icon name="star" class="w-3.5 h-3.5" /></span>
                        <div class="flex flex-col">
                            <span>{{ $locale === 'fr' ? 'Délégations Officielles' : ($locale === 'en' ? 'Official Delegation' : 'تسجيل الوفود الرسمية') }}</span>
                            <span class="text-[10px] text-amber-700 font-normal">{{ $locale === 'fr' ? 'Chefs, experts et invités' : 'لرؤساء الوفود والمؤطرين والخبراء' }}</span>
                        </div>
                    </a>
                </div>
            </div>
        @endguest

        <div class="grid grid-cols-2 gap-2 text-slate-800 font-bold text-xs">
            <a href="{{ route('home') }}" class="p-2.5 rounded-ws-sm {{ request()->routeIs('home') ? 'bg-ws-primary text-white' : 'bg-slate-100 hover:bg-slate-200' }}">
                {{ __('messages.home') }}
            </a>
            <a href="{{ route('skills') }}" class="p-2.5 rounded-ws-sm {{ request()->routeIs('skills') ? 'bg-ws-primary text-white' : 'bg-slate-100 hover:bg-slate-200' }}">
                {{ __('messages.skills') }}
            </a>
            <a href="{{ route('guide') }}" class="p-2.5 rounded-ws-sm {{ request()->routeIs('guide') ? 'bg-ws-primary text-white' : 'bg-slate-100 hover:bg-slate-200' }}">
                {{ app()->getLocale() === 'fr' ? 'Guide de Participation' : (app()->getLocale() === 'en' ? 'Participation Guide' : 'دليل المشاركة') }}
            </a>
            <a href="{{ route('regulations') }}" class="p-2.5 rounded-ws-sm {{ request()->routeIs('regulations') ? 'bg-ws-primary text-white' : 'bg-slate-100 hover:bg-slate-200' }}">
                {{ __('messages.regulations') }}
            </a>
            <a href="{{ route('schedule') }}" class="p-2.5 rounded-ws-sm {{ request()->routeIs('schedule') ? 'bg-ws-primary text-white' : 'bg-slate-100 hover:bg-slate-200' }}">
                {{ __('messages.schedule') }}
            </a>
            <a href="{{ route('results') }}" class="p-2.5 rounded-ws-sm {{ request()->routeIs('results') ? 'bg-ws-primary text-white' : 'bg-slate-100 hover:bg-slate-200' }}">
                {{ __('messages.results') }}
            </a>
            <a href="{{ route('news') }}" class="p-2.5 rounded-ws-sm {{ request()->routeIs('news') ? 'bg-ws-primary text-white' : 'bg-slate-100 hover:bg-slate-200' }}">
                {{ __('messages.news') }}
            </a>
            <a href="{{ route('verify') }}" class="p-2.5 rounded-ws-sm bg-emerald-50 text-emerald-700 border border-emerald-200">
                {{ __('messages.verify_nav') }}
            </a>
        </div>

        <div class="pt-3 border-t border-slate-200 flex items-center justify-between text-xs text-slate-800">
            <span class="font-bold">اللغة / Langue:</span>
            <div class="flex items-center gap-2">
                <a href="{{ route('lang.switch', 'ar') }}" class="px-2.5 py-1 rounded-full {{ $locale === 'ar' ? 'bg-ws-primary text-white font-black' : 'bg-slate-100' }}">AR</a>
                <a href="{{ route('lang.switch', 'fr') }}" class="px-2.5 py-1 rounded-full {{ $locale === 'fr' ? 'bg-ws-primary text-white font-black' : 'bg-slate-100' }}">FR</a>
                <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1 rounded-full {{ $locale === 'en' ? 'bg-ws-primary text-white font-black' : 'bg-slate-100' }}">EN</a>
            </div>
        </div>
    </div>
</header>
