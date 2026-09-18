@props(['user', 'activeEvent'])

@php
$user = $user ?? auth()->user();
$locale = app()->getLocale();
$rawRole = $user?->roles->first()?->name ?? 'USER';

$roleLabels = [
    'SUPER_ADMIN'        => ['ar' => 'مدير النظام الأقصى',      'fr' => 'Super Administrateur',   'en' => 'Super Admin'],
    'EXECUTIVE_VIEWER'   => ['ar' => 'وزير / مسؤول تنفيذي', 'fr' => 'Ministre & Observateur Exécutif', 'en' => 'Minister & Executive Viewer'],
    'COUNTRY_ADMIN'      => ['ar' => 'مسؤول الوفد الوطني',       'fr' => 'Admin Délégation',       'en' => 'Delegation Admin'],
    'ORGANIZATION_ADMIN' => ['ar' => 'مسؤول المؤسسة التكوينية',  'fr' => 'Admin Établissement',    'en' => 'Institution Admin'],
    'MEDIA_MANAGER'      => ['ar' => 'مسؤول الإعلام',            'fr' => 'Gestionnaire Média',     'en' => 'Media Manager'],
    'JUDGE'              => ['ar' => 'حكم أولمبي معتمد',          'fr' => 'Juge Expert',            'en' => 'Expert Judge'],
    'PARTICIPANT'        => ['ar' => 'متنافس أولمبي معتمد',       'fr' => 'Compétiteur Officiel',   'en' => 'Official Competitor'],
    'SPONSOR'            => ['ar' => 'شريك ورعاة',               'fr' => 'Partenaire',             'en' => 'Sponsor'],
];

$roleDisplay = $roleLabels[$rawRole][$locale] ?? ($roleLabels[$rawRole]['ar'] ?? $rawRole);

$wsapLabel = match($locale) {
    'fr' => 'Espace Administratif National',
    'en' => 'National Administrative Workspace',
    default => 'مساحة الإدارة الوطنية',
};

$dashboardRoute = match($rawRole) {
    'SUPER_ADMIN', 'NATIONAL_ADMIN' => route('admin.dashboard'),
    'EXECUTIVE_VIEWER'              => route('executive.dashboard'),
    'COUNTRY_ADMIN'                 => route('country.dashboard'),
    'ORGANIZATION_ADMIN'            => route('organization.dashboard'),
    'JUDGE', 'EXPERT'               => route('judge.dashboard'),
    'PARTICIPANT'                   => route('participant.dashboard'),
    'MEDIA_MANAGER'                 => route('admin.media.dashboard'),
    default                         => route('home'),
};
@endphp

<header
    x-data="{
        dropdownOpen: false,
        dark: document.documentElement.classList.contains('dark'),
        toggleDark() {
            this.dark = !this.dark;
            localStorage.setItem('wsap_dark_mode', this.dark);
            document.documentElement.classList.toggle('dark', this.dark);
        }
    }"
    
    class="sticky top-0 z-40 h-16 w-full flex items-center justify-between px-3 sm:px-6 bg-white/85 dark:bg-[#0B1120]/90 backdrop-blur-2xl border-b border-slate-200/80 dark:border-slate-800/80 shadow-xs select-none transition-colors"
>
    {{-- ════ START / LEFT (Logos & Identity) ════ --}}
    <div class="flex items-center gap-2 sm:gap-3 shrink-0 min-w-0">

        {{-- Mobile hamburger --}}
        <button type="button"
                @click="mobileNavOpen = true"
                class="lg:hidden w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-200/80 dark:border-slate-700 flex items-center justify-center text-slate-700 dark:text-slate-200 transition shadow-2xs touch-target shrink-0"
                aria-label="{{ __('القائمة') }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Official WorldSkills Algeria Brand Logo & Title Capsule --}}
        <a href="{{ $dashboardRoute }}" class="bg-slate-50/90 dark:bg-slate-800/90 px-3.5 sm:px-4 py-1.5 rounded-full flex items-center gap-2 sm:gap-3 shrink-0 shadow-2xs border border-slate-200/80 dark:border-slate-700 group hover:shadow-xs transition" aria-label="أولمبياد المهن الجزائرية">
            {{-- Official Ministry Logo (FIRST) --}}
            <img src="/ministry-logo-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-6 sm:h-7 w-auto object-contain transition-transform group-hover:scale-105 hidden sm:block">

            <div class="h-4 sm:h-5 w-px bg-slate-200 dark:bg-slate-700 shrink-0 hidden sm:block"></div>

            {{-- WorldSkills Logo (SECOND) --}}
            <img src="/logo.svg" alt="WorldSkills Algeria" class="h-6 sm:h-7 w-auto object-contain transition-transform group-hover:scale-105">

            {{-- Brand text --}}
            <div class="hidden sm:flex flex-col ms-0.5">
                <span class="text-xs sm:text-[13px] font-black tracking-tight leading-none text-[#041235] dark:text-white whitespace-nowrap">
                    {{ app()->getLocale() === 'fr' ? 'WorldSkills Algeria' : (app()->getLocale() === 'en' ? 'WorldSkills Algeria' : 'أولمبياد المهن الجزائرية') }}
                </span>
                <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 whitespace-nowrap leading-tight mt-0.5">
                    {{ $wsapLabel }}
                </span>
            </div>
        </a>
    </div>

    {{-- ════ END / RIGHT (Controls, Lang, Mode, User) ════ --}}
    <div class="flex items-center gap-1 sm:gap-2 shrink-0">

        {{-- Return to Public Platform Button --}}
        <a href="{{ route('home') }}" class="hidden md:flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 border border-slate-200/80 dark:border-slate-700 text-xs font-bold transition shadow-2xs" title="{{ __('messages.home') ?? 'الرئيسية' }}">
            <svg class="w-3.5 h-3.5 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>{{ __('messages.home') ?? 'الرئيسية' }}</span>
        </a>

        {{-- Dark Mode Switcher Button --}}
        <button type="button" @click="toggleDark()"
                class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-amber-300 border border-slate-200/80 dark:border-slate-700 flex items-center justify-center transition shadow-2xs"
                title="{{ $locale === 'fr' ? 'Basculer Mode Sombre/Clair' : ($locale === 'en' ? 'Toggle Dark/Light Mode' : 'تبديل الوضع الليلي / النهار') }}">
            <template x-if="dark">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </template>
            <template x-if="!dark">
                <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </template>
        </button>

        {{-- Language Switcher Pill Capsule (Active is Vibrant Royal Blue with White text) --}}
        <div class="flex items-center p-0.5 sm:p-1 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-2xs text-xs font-bold shrink-0">
            @foreach(['ar' => 'عربي', 'fr' => 'FR', 'en' => 'EN'] as $lang => $langLabel)
                <a href="{{ route('lang.switch', $lang) }}" data-navigate-ignore rel="external"
                   class="px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full transition text-[10px] sm:text-[11px] font-black whitespace-nowrap {{ $locale === $lang ? 'bg-[#0052CC] text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200' }}"
                >{{ $langLabel }}</a>
            @endforeach
        </div>

        {{-- Notifications --}}
        @php
            $unreadBellCount = auth()->check() ? \App\Models\UserNotification::where('user_id', auth()->id())
                ->whereIn('status', ['PENDING', 'DELIVERED'])
                ->count() : 0;
        @endphp
        <a href="{{ route('user.notifications') }}"
           class="relative w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200/80 dark:border-slate-700 flex items-center justify-center transition shadow-2xs shrink-0"
           aria-label="{{ $locale === 'fr' ? 'Notifications' : ($locale === 'en' ? 'Notifications' : 'الإشعارات') }}"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                      d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            @if($unreadBellCount > 0)
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 text-white rounded-full text-[9px] font-black flex items-center justify-center animate-pulse shadow-sm">
                {{ $unreadBellCount > 9 ? '9+' : $unreadBellCount }}
            </span>
            @endif
        </a>

        {{-- Profile Dropdown Capsule --}}
        <div class="relative shrink-0">
            <button @click="dropdownOpen = !dropdownOpen" type="button"
                    class="flex items-center gap-2 p-1 pe-3 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-sm transition"
                    aria-label="{{ $locale === 'ar' ? 'الحساب' : ($locale === 'fr' ? 'Compte' : 'Account') }}">
                {{-- Avatar --}}
                <div class="w-7 h-7 rounded-full bg-[#06205C] overflow-hidden shadow-2xs shrink-0 border border-slate-200 dark:border-slate-700">
                    <img src="{{ $user?->avatar_url }}" alt="{{ $user?->name }}" class="w-full h-full object-cover">
                </div>
                {{-- Name --}}
                <span class="hidden md:block text-xs font-black max-w-[120px] truncate whitespace-nowrap text-slate-800 dark:text-slate-100">
                    {{ $user?->name ?? '' }}
                </span>
                {{-- Chevron --}}
                <svg class="w-3.5 h-3.5 hidden md:block transition-transform duration-200 shrink-0 text-slate-500 dark:text-slate-400"
                     :class="dropdownOpen ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>

            {{-- Frosted Glass Dropdown Menu --}}
            <div x-show="dropdownOpen"
                 @click.away="dropdownOpen = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                 class="absolute {{ $locale === 'ar' ? 'start-0' : 'end-0' }} mt-2 w-60 rounded-3xl bg-white/95 dark:bg-[#0F172A]/95 backdrop-blur-2xl border border-white/80 dark:border-slate-800 shadow-2xl p-2 z-50 text-start"
                 x-cloak>

                {{-- User info --}}
                <div class="px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800/80 mb-1 border border-slate-100 dark:border-slate-700/60">
                    <p class="text-xs font-black truncate text-slate-900 dark:text-white">
                        {{ $user?->name ?? '' }}
                    </p>
                    <p class="text-[11px] font-medium truncate mt-0.5 text-slate-500 dark:text-slate-400">
                        {{ $user?->email ?? '' }}
                    </p>
                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-600 dark:text-blue-400 text-[10px] font-black">
                        {{ $roleDisplay }}
                    </span>
                </div>

                {{-- Profile --}}
                <a href="{{ route('profile') }}"
                   class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-bold transition text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    {{ $locale === 'fr' ? 'Mon Profil' : ($locale === 'en' ? 'My Profile' : 'الملف الشخصي') }}
                </a>

                {{-- Divider --}}
                <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-bold text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                        {{ $locale === 'fr' ? 'Déconnexion' : ($locale === 'en' ? 'Sign Out' : 'تسجيل الخروج') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
