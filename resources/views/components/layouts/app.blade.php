<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-full bg-[#F5F9FF]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- PWA Manifest & Mobile Meta Tags -->
    <link rel="manifest" href="/manifest.json">
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#020A24">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="WorldSkills DZ">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/icon-192.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/icon-512.png">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="64x64" href="/favicon.png">
    <link rel="icon" type="image/svg+xml" href="/logo.svg">

    <!-- Google Fonts: Outfit & Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script>
        (function(){const w=console.warn;console.warn=function(...a){if(a[0]&&typeof a[0]==='string'&&a[0].includes('cdn.tailwindcss.com'))return;w.apply(console,a);};})();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#EEF6FF',
                            100: '#E0F0FF',
                            500: '#0066FF',
                            600: '#0052CC',
                            700: '#063B8F',
                            sky: '#00B8FF',
                            dark: '#0B1F3A',
                            muted: '#5B6B82',
                            bg: '#F5F9FF'
                        }
                    },
                    fontFamily: {
                        sans: ['Cairo', 'Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Cairo', 'Outfit', sans-serif;
            background-color: #F5F9FF;
            color: #0B1F3A;
        }

        /* Glassmorphism & Micro-animations */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 102, 255, 0.08);
            box-shadow: 0 10px 30px -10px rgba(6, 59, 143, 0.05);
        }

        .wsap-btn-primary {
            background: linear-gradient(135deg, #0066FF 0%, #00B8FF 100%);
            color: #ffffff;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .wsap-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -4px rgba(0, 102, 255, 0.4);
        }

        .wsap-card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .wsap-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px -8px rgba(6, 59, 143, 0.1);
        }

        @media (prefers-reduced-motion: reduce) {
            *, ::before, ::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

    @livewireStyles
    
    <!-- Platform Media & Content Protection System -->
    <x-content-protection />
</head>
<body class="h-full antialiased font-sans flex flex-col">

    <!-- Top Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-brand-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Brand Logo & Identity -->
            <div class="flex items-center gap-4">
                <a href="/" class="flex items-center gap-3 group">
                    <img src="/logo.svg" alt="WorldSkills Algeria" class="h-10 w-auto object-contain group-hover:scale-105 transition-transform">
                    <div class="flex flex-col">
                        <span class="text-xl font-black text-brand-dark tracking-tight leading-none">WorldSkills <span class="text-brand-500">Algeria</span></span>
                        <span class="text-xs font-semibold text-brand-muted mt-1">منصة إدارة أولمبياد المهن — WSAP</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-6 font-bold text-xs sm:text-sm">
                @auth
                    @if(auth()->user()->hasRole(\App\Enums\RoleEnum::PARTICIPANT->value))
                        <a href="{{ route('participant.dashboard') }}" class="flex items-center gap-2 {{ request()->routeIs('participant.dashboard') ? 'text-brand-500 border-b-2 border-brand-500 pb-1' : 'text-slate-600 hover:text-brand-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Mon Espace' : (app()->getLocale() === 'en' ? 'My Dashboard' : 'لوحة المتنافس') }}</span>
                        </a>
                        <a href="{{ route('my.badge') }}" class="flex items-center gap-2 {{ request()->routeIs('my.badge') || request()->routeIs('accreditation.badge') ? 'text-brand-500 border-b-2 border-brand-500 pb-1' : 'text-slate-600 hover:text-brand-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Mon Badge Officiel' : (app()->getLocale() === 'en' ? 'My Official Badge' : 'شارة الاعتماد والشهادة') }}</span>
                        </a>
                    @elseif(auth()->user()->hasRole(\App\Enums\RoleEnum::COUNTRY_ADMIN->value))
                        <a href="{{ route('country.dashboard') }}" class="flex items-center gap-2 {{ request()->routeIs('country.dashboard') ? 'text-brand-500 border-b-2 border-brand-500 pb-1' : 'text-slate-600 hover:text-brand-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Délégation' : (app()->getLocale() === 'en' ? 'Delegation' : 'لوحة الدولة') }}</span>
                        </a>
                        <a href="{{ route('country.skills') }}" class="flex items-center gap-2 {{ request()->routeIs('country.skills') ? 'text-brand-500 border-b-2 border-brand-500 pb-1' : 'text-slate-600 hover:text-brand-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Métiers' : (app()->getLocale() === 'en' ? 'Trades' : 'اختيار التخصصات') }}</span>
                        </a>
                        <a href="{{ route('country.delegation') }}" class="flex items-center gap-2 {{ request()->routeIs('country.delegation') ? 'text-brand-500 border-b-2 border-brand-500 pb-1' : 'text-slate-600 hover:text-brand-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Membres' : (app()->getLocale() === 'en' ? 'Roster' : 'إدارة الوفد') }}</span>
                        </a>
                    @elseif(auth()->user()->hasRole(\App\Enums\RoleEnum::JUDGE->value))
                        <a href="{{ route('judge.dashboard') }}" class="flex items-center gap-2 {{ request()->routeIs('judge.dashboard') ? 'text-brand-500 border-b-2 border-brand-500 pb-1' : 'text-slate-600 hover:text-brand-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Centre du Jury' : (app()->getLocale() === 'en' ? 'Jury Center' : 'مركز لجنة التحكيم') }}</span>
                        </a>
                        <a href="{{ route('my.badge') }}" class="flex items-center gap-2 {{ request()->routeIs('my.badge') || request()->routeIs('accreditation.badge') ? 'text-brand-500 border-b-2 border-brand-500 pb-1' : 'text-slate-600 hover:text-brand-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Badge du Juge' : (app()->getLocale() === 'en' ? 'Judge Badge' : 'شارة الاعتماد للحكم') }}</span>
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-brand-500 font-bold">
                            <span>{{ app()->getLocale() === 'fr' ? 'Panneau d\'Administration' : (app()->getLocale() === 'en' ? 'Admin Dashboard' : 'مركز الإدارة الوطنية') }}</span>
                        </a>
                    @endif
                @else
                    <a href="/" class="text-slate-600 hover:text-brand-500">{{ app()->getLocale() === 'fr' ? 'Accueil' : (app()->getLocale() === 'en' ? 'Home' : 'الرئيسية') }}</a>
                    <a href="{{ route('skills') }}" class="text-slate-600 hover:text-brand-500">{{ app()->getLocale() === 'fr' ? 'Métiers' : (app()->getLocale() === 'en' ? 'Trades' : 'التخصصات') }}</a>
                    <a href="{{ route('registration') }}" class="text-brand-500 font-bold">{{ app()->getLocale() === 'fr' ? 'Inscription' : (app()->getLocale() === 'en' ? 'Register' : 'التسجيل الرسمي') }}</a>
                @endauth
            </nav>

            <!-- User Status, Language Switcher & Active Edition Badge -->
            <div class="flex items-center gap-3">

                {{-- Language Switcher --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-brand-50 text-xs font-bold text-[#06205C] border border-slate-200/80 hover:border-brand-200 transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.357 6 17.555"/></svg>
                        <span class="uppercase font-mono text-[11px] font-black">{{ app()->getLocale() }}</span>
                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition x-cloak
                        class="absolute top-full {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} mt-1.5 w-32 rounded-xl bg-white shadow-xl border border-slate-100 py-1 z-50">
                        <a href="{{ route('lang.switch', 'ar') }}" data-navigate-ignore rel="external"
                            class="flex items-center gap-2 px-3 py-2 text-xs font-bold hover:bg-slate-50 {{ app()->getLocale() === 'ar' ? 'text-brand-500 bg-brand-50' : 'text-[#06205C]' }}">
                            <span class="text-base leading-none">🇩🇿</span> العربية
                        </a>
                        <a href="{{ route('lang.switch', 'fr') }}" data-navigate-ignore rel="external"
                            class="flex items-center gap-2 px-3 py-2 text-xs font-bold hover:bg-slate-50 {{ app()->getLocale() === 'fr' ? 'text-brand-500 bg-brand-50' : 'text-[#06205C]' }}">
                            <span class="text-base leading-none">🇫🇷</span> Français
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}" data-navigate-ignore rel="external"
                            class="flex items-center gap-2 px-3 py-2 text-xs font-bold hover:bg-slate-50 {{ app()->getLocale() === 'en' ? 'text-brand-500 bg-brand-50' : 'text-[#06205C]' }}">
                            <span class="text-base leading-none">🇬🇧</span> English
                        </a>
                    </div>
                </div>

                <div class="hidden sm:flex items-center gap-2 bg-brand-50 border border-brand-100 px-3 py-1.5 rounded-xl text-xs font-bold text-brand-700">
                    <svg class="w-4 h-4 text-brand-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ app()->getLocale() === 'fr' ? 'Session 2027' : (app()->getLocale() === 'en' ? 'Edition 2027' : 'دورة 2027 النشطة') }}
                </div>

                <div class="flex items-center gap-3 {{ app()->getLocale() === 'ar' ? 'border-r' : 'border-l' }} border-brand-100 {{ app()->getLocale() === 'ar' ? 'pr-4' : 'pl-4' }}">
                    <div class="w-10 h-10 rounded-full bg-brand-700 text-white font-bold flex items-center justify-center text-sm shadow">
                        {{ strtoupper(substr(auth()->user()->name ?? 'DZ', 0, 2)) }}
                    </div>
                    <div class="hidden lg:flex flex-col {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        <span class="text-xs font-bold text-brand-dark">{{ auth()->user()->name ?? 'مسؤول الوفد' }}</span>
                        <span class="text-[10px] text-brand-muted">{{ auth()->user()->email ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-brand-100 py-6 mt-12 text-center text-xs text-brand-muted">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                © {{ date('Y') }} WorldSkills Algeria — جميع الحقوق محفوظة لوزارة التكوين والتعليم المهنيين.
            </div>
            <div class="flex items-center gap-4 font-semibold">
                <span class="text-brand-500">WSAP v1.0 Production-Grade</span>
                <span>•</span>
                <span>النظام الموحد للوفود والتصفيات</span>
            </div>
        </div>
    </footer>

    <x-cookie-banner />
    <x-pwa-installer />
    @livewireScripts
</body>
</html>
