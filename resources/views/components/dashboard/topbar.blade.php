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
        dark: localStorage.getItem('wsap_dark_mode') === 'true',
        toggleDark() {
            this.dark = !this.dark;
            localStorage.setItem('wsap_dark_mode', this.dark);
            document.documentElement.classList.toggle('dark', this.dark);
        }
    }"
    x-init="document.documentElement.classList.toggle('dark', dark)"
    class="sticky top-0 z-40 h-16 flex items-center justify-between px-3 sm:px-6 border-b shadow-xs select-none"
    :style="dark
        ? 'background:rgba(15,23,42,0.97);border-color:#1E293B;backdrop-filter:blur(12px);'
        : 'background:rgba(255,255,255,0.97);border-color:rgba(226,232,240,0.8);backdrop-filter:blur(12px);'"
>
    {{-- ════ START / LEFT ════ --}}
    <div class="flex items-center gap-2 sm:gap-3 shrink-0 min-w-0">

        {{-- Mobile hamburger --}}
        <button type="button"
                @click="mobileNavOpen = true"
                class="lg:hidden p-2 rounded-xl transition touch-target shrink-0"
                :style="dark ? 'color:#94A3B8;' : 'color:#64748B;'"
                aria-label="{{ __('القائمة') }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Official WorldSkills Algeria Brand Logo & Title --}}
        <a href="{{ $dashboardRoute }}" class="flex items-center gap-2 sm:gap-3 group shrink-0" aria-label="أولمبياد المهن الجزائرية">
            {{-- Official Ministry Logo (FIRST) --}}
            <div class="h-9 sm:h-11 shrink-0 flex items-center justify-center px-2 py-1 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/90 dark:border-slate-700 shadow-sm group-hover:scale-105 transition-transform">
                <img src="/ministry-logo-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-full w-auto object-contain max-h-8">
            </div>

            <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 shrink-0"></div>

            {{-- WorldSkills Logo (SECOND) --}}
            <div class="h-9 sm:h-11 shrink-0 flex items-center justify-center px-2 py-1 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/90 dark:border-slate-700 shadow-sm group-hover:scale-105 transition-transform">
                <img src="/logo.svg" alt="WorldSkills Algeria" class="h-full w-auto object-contain max-h-8">
            </div>

            {{-- Brand text --}}
            <div class="hidden sm:flex flex-col">
                <span class="text-xs sm:text-sm font-black tracking-tight leading-snug whitespace-nowrap"
                      :style="dark ? 'color:#F8FAFC;' : 'color:#06205C;'">
                    {{ app()->getLocale() === 'fr' ? 'WorldSkills Algeria' : (app()->getLocale() === 'en' ? 'WorldSkills Algeria' : 'أولمبياد المهن الجزائرية') }}
                </span>
                <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 whitespace-nowrap">
                    {{ $wsapLabel }}
                </span>
            </div>
        </a>

        {{-- Active Event Pill --}}
        @if(!empty($activeEvent))
            <div class="hidden xl:flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-bold whitespace-nowrap max-w-[220px] truncate shrink-0"
                 :style="dark ? 'background:rgba(30,58,138,0.3);border-color:#1D4ED8;color:#93C5FD;' : 'background:#EFF6FF;border-color:#BFDBFE;color:#1D4ED8;'">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                <span class="truncate">{{ $activeEvent->getLocalized('title') }}</span>
            </div>
        @endif
    </div>

    {{-- ════ END / RIGHT ════ --}}
    <div class="flex items-center gap-1.5 sm:gap-2.5 shrink-0">

        {{-- Dark Mode Switcher Button --}}
        <button type="button" @click="toggleDark()"
                class="p-2 rounded-xl transition border shrink-0 flex items-center justify-center"
                :class="dark ? 'bg-slate-800 border-slate-700 text-amber-300 hover:bg-slate-700' : 'bg-slate-100 border-slate-200 text-slate-700 hover:bg-slate-200'"
                title="{{ $locale === 'fr' ? 'Basculer Mode Sombre/Clair' : ($locale === 'en' ? 'Toggle Dark/Light Mode' : 'تبديل الوضع الليلي / النهار') }}">
            <template x-if="dark">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </template>
            <template x-if="!dark">
                <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </template>
        </button>

        {{-- Language Switcher --}}
        <div class="flex items-center p-0.5 sm:p-1 rounded-xl text-xs font-bold shrink-0"
             :style="dark ? 'background:#1E293B;' : 'background:#F1F5F9;'">
            @foreach(['ar' => 'عربي', 'fr' => 'FR', 'en' => 'EN'] as $lang => $langLabel)
                <a href="{{ route('lang.switch', $lang) }}" data-navigate-ignore rel="external"
                   class="px-2 sm:px-2.5 py-1 rounded-lg transition text-[11px] sm:text-xs whitespace-nowrap {{ $locale === $lang ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-slate-200' }}"
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
           class="relative p-2 rounded-xl transition touch-target shrink-0 flex items-center justify-center"
           :style="dark ? 'color:#64748B;' : 'color:#94A3B8;'"
           aria-label="{{ $locale === 'fr' ? 'Notifications' : ($locale === 'en' ? 'Notifications' : 'الإشعارات') }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                      d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            @if($unreadBellCount > 0)
            <span class="absolute top-1 right-1 w-4 h-4 bg-rose-500 text-white rounded-full text-[9px] font-black flex items-center justify-center animate-pulse shadow-sm">
                {{ $unreadBellCount > 9 ? '9+' : $unreadBellCount }}
            </span>
            @endif
        </a>



        {{-- Profile Dropdown --}}
        <div class="relative shrink-0">
            <button @click="dropdownOpen = !dropdownOpen" type="button"
                    class="flex items-center gap-2 p-1 rounded-xl transition touch-target"
                    aria-label="{{ $locale === 'ar' ? 'الحساب' : ($locale === 'fr' ? 'Compte' : 'Account') }}">
                {{-- Avatar --}}
                <div class="w-8 h-8 rounded-xl bg-[#06205C] overflow-hidden shadow-sm shrink-0 border border-slate-200">
                    <img src="{{ $user?->avatar_url }}" alt="{{ $user?->name }}" class="w-full h-full object-cover">
                </div>
                {{-- Name --}}
                <span class="hidden md:block text-xs font-bold max-w-[120px] truncate whitespace-nowrap"
                      :style="dark ? 'color:#CBD5E1;' : 'color:#334155;'">
                    {{ $user?->name ?? '' }}
                </span>
                {{-- Chevron --}}
                <svg class="w-3.5 h-3.5 hidden md:block transition-transform duration-200 shrink-0"
                     :class="dropdownOpen ? 'rotate-180' : ''"
                     :style="dark ? 'color:#475569;' : 'color:#94A3B8;'"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>

            {{-- Dropdown --}}
            <div x-show="dropdownOpen"
                 @click.away="dropdownOpen = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute {{ $locale === 'ar' ? 'start-0' : 'end-0' }} mt-2 w-56 rounded-2xl shadow-xl border py-1 z-50"
                 :style="dark ? 'background:#0F172A;border-color:#1E293B;' : 'background:white;border-color:#E2E8F0;'"
                 x-cloak>

                {{-- User info --}}
                <div class="px-4 py-3 border-b" :style="dark ? 'border-color:#1E293B;' : 'border-color:#F1F5F9;'">
                    <p class="text-xs font-black truncate" :style="dark ? 'color:#E2E8F0;' : 'color:#1E293B;'">
                        {{ $user?->name ?? '' }}
                    </p>
                    <p class="text-[11px] font-medium truncate mt-0.5" :style="dark ? 'color:#475569;' : 'color:#94A3B8;'">
                        {{ $user?->email ?? '' }}
                    </p>
                </div>

                {{-- Profile --}}
                <a href="{{ route('profile') }}"
                   class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold transition"
                   :style="dark ? 'color:#94A3B8;' : 'color:#475569;'"
                   @mouseenter="$el.style.background = dark ? '#1E293B' : '#F8FAFC'; $el.style.color = dark ? '#E2E8F0' : '#1E293B';"
                   @mouseleave="$el.style.background = 'transparent'; $el.style.color = dark ? '#94A3B8' : '#475569';"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    {{ $locale === 'fr' ? 'Mon Profil' : ($locale === 'en' ? 'My Profile' : 'الملف الشخصي') }}
                </a>

                {{-- Divider --}}
                <div class="my-1 border-t" :style="dark ? 'border-color:#1E293B;' : 'border-color:#F1F5F9;'"></div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-rose-500 transition"
                            @mouseenter="$el.style.background = dark ? 'rgba(244,63,94,0.1)' : '#FFF1F2';"
                            @mouseleave="$el.style.background = 'transparent';"
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
