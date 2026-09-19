@php
    $locale = app()->getLocale();
    $t = function($ar, $fr, $en) use ($locale) {
        return match($locale) {
            'fr' => $fr,
            'en' => $en,
            default => $ar,
        };
    };
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER BAND --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#06205C] text-amber-400 flex items-center justify-center font-black shrink-0 shadow-md">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-[#06205C] dark:text-white tracking-tight">
                    {{ $t('مركز القيادة الموحد لإدارة المحتوى والإعلام (CMS Hub)', 'Centre Commandement CMS & Média Unifié', 'Unified CMS & Media Command Hub') }}
                </h1>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-1">
                    {{ $t('إدارة شاملة 100% للصفحة الرئيسية، البث المباشر، الأخبار، الفيديوهات، معارض الصور، الوثائق القانونية، ومظهر المنصة.', 'Gestion intégrée 100% de la page d\'accueil, direct TV, actualités, vidéos, galerie, juridique et apparence.', 'Centralized 100% database management for homepage, live TV, news, videos, photo gallery, legal pages, and appearance.') }}
                </p>
            </div>
        </div>

        {{-- Quick Stats Bar --}}
        <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-900/60 p-2.5 rounded-2xl border border-slate-200/80 dark:border-slate-700 text-xs">
            <div class="text-center px-3">
                <span class="text-[10px] font-black text-slate-400 block uppercase">{{ $t('المقالات', 'Articles', 'News') }}</span>
                <span class="font-black text-[#06205C] dark:text-amber-400 text-base">{{ $newsCount }}</span>
            </div>
            <div class="h-6 w-px bg-slate-200 dark:bg-slate-700"></div>
            <div class="text-center px-3">
                <span class="text-[10px] font-black text-slate-400 block uppercase">{{ $t('الفيديوهات', 'Vidéos', 'Videos') }}</span>
                <span class="font-black text-sky-600 text-base">{{ $videosCount }}</span>
            </div>
            <div class="h-6 w-px bg-slate-200 dark:bg-slate-700"></div>
            <div class="text-center px-3">
                <span class="text-[10px] font-black text-slate-400 block uppercase">{{ $t('الألبومات', 'Albums', 'Albums') }}</span>
                <span class="font-black text-emerald-600 text-base">{{ $albumsCount }}</span>
            </div>
            <div class="h-6 w-px bg-slate-200 dark:bg-slate-700"></div>
            <div class="text-center px-3">
                <span class="text-[10px] font-black text-slate-400 block uppercase">{{ $t('البث', 'Direct', 'Stream') }}</span>
                <span class="inline-flex items-center gap-1 font-black text-xs {{ $liveTvStatus ? 'text-emerald-600' : 'text-slate-400' }}">
                    <span class="w-2 h-2 rounded-full {{ $liveTvStatus ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                    <span>{{ $liveTvStatus ? $t('نشط', 'Actif', 'Live') : $t('متوقف', 'Inactif', 'Off') }}</span>
                </span>
            </div>
        </div>
    </div>

    {{-- FLASH NOTIFICATION --}}
    @if($flashMessage)
        @php
            $bgClass = match($flashMessageType) {
                'danger' => 'bg-rose-50 border-rose-200 text-rose-900 dark:bg-rose-950/40 dark:border-rose-900 dark:text-rose-200',
                'warning' => 'bg-amber-50 border-amber-200 text-amber-900 dark:bg-amber-950/40 dark:border-amber-900 dark:text-amber-200',
                default => 'bg-emerald-50 border-emerald-200 text-emerald-900 dark:bg-emerald-950/40 dark:border-emerald-900 dark:text-emerald-200',
            };
        @endphp
        <div class="p-4 rounded-2xl border {{ $bgClass }} text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ $flashMessage }}</span>
            </div>
            <button wire:click="$set('flashMessage', '')" class="font-black text-xs hover:opacity-75">
                <x-ws.icon name="x-mark" class="w-5 h-5" />
            </button>
        </div>
    @endif

    {{-- UNIFIED TAB NAVIGATION BAR --}}
    <div class="bg-white dark:bg-slate-800 p-2 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-x-auto">
        <div class="flex items-center gap-1.5 min-w-max">
            
            {{-- Dashboard Overview Tab --}}
            <button wire:click="setTab('dashboard')"
                    class="px-4 py-2.5 rounded-xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'dashboard' ? 'bg-[#06205C] text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>{{ $t('نظرة عامة', 'Vue d’ensemble', 'Overview') }}</span>
            </button>

            {{-- Homepage Tab --}}
            <button wire:click="setTab('homepage')"
                    class="px-4 py-2.5 rounded-xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'homepage' ? 'bg-[#06205C] text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>{{ $t('الصفحة الرئيسية', 'Page d’Accueil', 'Homepage CMS') }}</span>
            </button>

            {{-- Live TV Tab --}}
            <button wire:click="setTab('livetv')"
                    class="px-4 py-2.5 rounded-xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'livetv' ? 'bg-[#06205C] text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <span>{{ $t('البث المباشر (Live TV)', 'Direct TV', 'Live TV & Streams') }}</span>
            </button>

            {{-- News Tab --}}
            <button wire:click="setTab('news')"
                    class="px-4 py-2.5 rounded-xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'news' ? 'bg-[#06205C] text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <span>{{ $t('الأخبار والمقالات', 'Actualités', 'News & Articles') }}</span>
            </button>

            {{-- Videos Tab --}}
            <button wire:click="setTab('videos')"
                    class="px-4 py-2.5 rounded-xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'videos' ? 'bg-[#06205C] text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $t('مكتبة الفيديوهات', 'Vidéos', 'Video Library') }}</span>
            </button>

            {{-- Gallery Tab --}}
            <button wire:click="setTab('gallery')"
                    class="px-4 py-2.5 rounded-xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'gallery' ? 'bg-[#06205C] text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ $t('معرض الصور', 'Galerie Photos', 'Photo Gallery') }}</span>
            </button>

            {{-- Legal Tab --}}
            <button wire:click="setTab('legal')"
                    class="px-4 py-2.5 rounded-xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'legal' ? 'bg-[#06205C] text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>{{ $t('الوثائق القانونية', 'Juridique & Guide', 'Legal & Guide') }}</span>
            </button>

            {{-- Appearance Tab --}}
            <button wire:click="setTab('appearance')"
                    class="px-4 py-2.5 rounded-xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'appearance' ? 'bg-[#06205C] text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                <span>{{ $t('مظهر المنصة', 'Apparence', 'Appearance') }}</span>
            </button>

        </div>
    </div>

    {{-- TAB CONTENTS --}}

    {{-- 1. DASHBOARD OVERVIEW TAB --}}
    @if($activeTab === 'dashboard')
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                {{-- Homepage Control Box --}}
                <div wire:click="setTab('homepage')" class="cursor-pointer bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm hover:border-[#06205C] transition space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-black border border-sky-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 dark:text-white text-base">{{ $t('إعدادات الصفحة الرئيسية', 'Page d’Accueil', 'Homepage CMS') }}</h3>
                        <p class="text-xs text-slate-500 font-bold mt-1">{{ $t('التحكم في العناوين، نوارة الأخبار، ومفاتيح التسجيل', 'Gérer les titres, bannières et inscriptions', 'Manage hero sections, ticker, and registration switches') }}</p>
                    </div>
                </div>

                {{-- Live TV Control Box --}}
                <div wire:click="setTab('livetv')" class="cursor-pointer bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm hover:border-rose-500 transition space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-black border border-rose-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 dark:text-white text-base">{{ $t('استوديو البث المباشر', 'Direct TV', 'Live TV Control') }}</h3>
                        <p class="text-xs text-slate-500 font-bold mt-1">{{ $t('رابط القناة، شريط الأخبار العاجلة، وإدارة السلايدات', 'Règles du direct et annonces urgentes', 'Manage live stream, urgent tickers, and slides') }}</p>
                    </div>
                </div>

                {{-- News Control Box --}}
                <div wire:click="setTab('news')" class="cursor-pointer bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm hover:border-emerald-500 transition space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black border border-emerald-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 dark:text-white text-base">{{ $t('مركز الأخبار والمقالات', 'Actualités', 'News Articles') }}</h3>
                        <p class="text-xs text-slate-500 font-bold mt-1">{{ $t('إعادة نشر وتحرير المقالات والإعلانات الرسمية', 'Gérer les articles et communiqués', 'Manage news articles and announcements') }}</p>
                    </div>
                </div>

                {{-- Gallery & Videos Control Box --}}
                <div wire:click="setTab('videos')" class="cursor-pointer bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm hover:border-purple-500 transition space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-black border border-purple-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 dark:text-white text-base">{{ $t('مكتبة الميديا والمعارض', 'Médiathèque', 'Media & Gallery') }}</h3>
                        <p class="text-xs text-slate-500 font-bold mt-1">{{ $t('مكتبة الفيديوهات، استيراد يوتيوب، ومعارض الصور', 'Vidéos, synchronisation YouTube et albums', 'Video library, YouTube sync, and photo albums') }}</p>
                    </div>
                </div>

            </div>
        </div>
    @endif

    {{-- 2. HOMEPAGE CMS TAB --}}
    @if($activeTab === 'homepage')
        <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                <h2 class="text-lg font-black text-[#06205C] dark:text-white">
                    {{ $t('تخصيص واجهة وعناصر الصفحة الرئيسية', 'Personnalisation Page d’Accueil', 'Homepage Sections Customizer') }}
                </h2>
                <button wire:click="saveHomepageSettings" class="px-5 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition">
                    {{ $t('حفظ التعديلات', 'Enregistrer Tout', 'Save All Changes') }}
                </button>
            </div>

            {{-- Master Registration Switches --}}
            <div class="space-y-3">
                <h3 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-wider">{{ $t('مفاتيح فتح وإغلاق التسجيلات والصفحات', 'Activation des Inscriptions', 'Master Registration Switches') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                    <label class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center justify-between cursor-pointer bg-slate-50 dark:bg-slate-900">
                        <span class="font-bold">{{ $t('تسجيل المتنافسين الشباب', 'Inscription Candidats', 'Competitor Registration') }}</span>
                        <input type="checkbox" wire:model="registration_competitors_enabled" class="w-5 h-5 accent-amber-600 rounded">
                    </label>

                    <label class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center justify-between cursor-pointer bg-slate-50 dark:bg-slate-900">
                        <span class="font-bold">{{ $t('تسجيل التشجيع والجمهور', 'Inscription Supporters', 'Supporters Registration') }}</span>
                        <input type="checkbox" wire:model="registration_supporters_enabled" class="w-5 h-5 accent-amber-600 rounded">
                    </label>

                    <label class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center justify-between cursor-pointer bg-slate-50 dark:bg-slate-900">
                        <span class="font-bold">{{ $t('اعتمادات والشارات الرسمية', 'Accréditations', 'Accreditation Center') }}</span>
                        <input type="checkbox" wire:model="registration_accreditation_enabled" class="w-5 h-5 accent-amber-600 rounded">
                    </label>

                    <label class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center justify-between cursor-pointer bg-slate-50 dark:bg-slate-900">
                        <span class="font-bold">{{ $t('عرض قسم الشركاء والرعاة', 'Section Partenaires', 'Partners Section') }}</span>
                        <input type="checkbox" wire:model="page_partners_enabled" class="w-5 h-5 accent-amber-600 rounded">
                    </label>
                </div>
            </div>

            {{-- News Ticker Settings --}}
            <div class="space-y-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-wider">{{ $t('إعدادات شريط الإعلانات والأخبار العاجلة العلوي (Ticker)', 'Bannière d\'actualité défilante', 'News Ticker Settings') }}</h3>
                    <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700 dark:text-slate-300">
                        <span>{{ $t('تفعيل الشريط', 'Activer le bandeau', 'Enable Ticker') }}</span>
                        <input type="checkbox" wire:model="news_ticker_enabled" class="w-5 h-5 accent-amber-600 rounded">
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('وسام التنبيه (بالعربية)', 'Badge Text (AR)', 'Badge Text (AR)') }}</label>
                        <input type="text" wire:model="news_ticker_badge_ar" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('رابط التوجه عند النقر', 'URL du lien', 'Click Destination URL') }}</label>
                        <input type="text" wire:model="news_ticker_url" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('نص الإعلان أو التنبيه المتحرك', 'Texte de l\'annonce', 'Ticker Message Content') }}</label>
                        <input type="text" wire:model="news_ticker_text_ar" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                </div>
            </div>

            {{-- Hero Titles Settings --}}
            <div class="space-y-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                <h3 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-wider">{{ $t('العنوان الرئيسي والوصف (Hero Banner)', 'Titre Principal Hero', 'Hero Banner Headings') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('العنوان الرئيسي (عربي)', 'Titre (AR)', 'Title (AR)') }}</label>
                        <input type="text" wire:model="hero_title_ar" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('العنوان الفرعي (عربي)', 'Sous-titre (AR)', 'Subtitle (AR)') }}</label>
                        <input type="text" wire:model="hero_subtitle_ar" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('نص زر الإجراء (عربي)', 'Texte Bouton (AR)', 'CTA Button (AR)') }}</label>
                        <input type="text" wire:model="cta_text_ar" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                </div>
            </div>

        </div>
    @endif

    {{-- 3. LIVE TV TAB --}}
    @if($activeTab === 'livetv')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Stream Settings Card --}}
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h2 class="text-base font-black text-slate-900 dark:text-white">
                        {{ $t('إعدادات قناة وتدفق البث المباشر', 'Paramètres Flux Direct TV', 'Live TV Stream Control') }}
                    </h2>
                    <label class="flex items-center gap-2 cursor-pointer text-xs font-bold">
                        <span>{{ $t('حالة البث', 'Statut Direct', 'Live Status') }}</span>
                        <input type="checkbox" wire:model="liveStreamIsActive" class="w-5 h-5 accent-emerald-600 rounded">
                    </label>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('عنوان البث المباشر', 'Titre du Direct', 'Stream Title') }}</label>
                        <input type="text" wire:model="liveStreamTitle" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('رابط تضمين البث المباشر (YouTube Embed / HLS)', 'URL Embed / Stream URL', 'Embed / Stream URL') }}</label>
                        <input type="text" wire:model="liveStreamUrl" placeholder="https://www.youtube.com/embed/..." class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                </div>

                <button wire:click="saveLiveTvSettings" class="px-5 py-2.5 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs shadow-md transition">
                    {{ $t('حفظ إعدادات البث', 'Enregistrer Stream', 'Save Stream Settings') }}
                </button>
            </div>

            {{-- Live Announcements Sidebar --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <h2 class="text-base font-black text-slate-900 dark:text-white">
                    {{ $t('إضافة خبر عاجل لشاشة البث', 'Ajouter Annonce Ugent', 'Add Live Ticker Alert') }}
                </h2>

                <div class="space-y-2 text-xs">
                    <textarea wire:model="tickerTextAr" rows="3" placeholder="{{ $t('نص الخبر العاجل بالعربية...', 'Texte d\'urgence...', 'Urgent ticker message...') }}" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white"></textarea>
                    <button wire:click="addLiveTvAnnouncement" class="w-full py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition">
                        {{ $t('إضافة للشاشة', 'Ajouter', 'Publish Ticker Alert') }}
                    </button>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-700 pt-2 max-h-60 overflow-y-auto">
                    @foreach($tvAnnouncements as $tvAnn)
                        <div class="py-2 flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-800 dark:text-slate-200 leading-snug">{{ $tvAnn->text_ar }}</span>
                            <button wire:click="confirmDelete({{ $tvAnn->id }}, 'TV_ANNOUNCEMENT', '{{ $tvAnn->text_ar }}')" class="text-slate-400 hover:text-rose-600 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    @endif

    {{-- 4. NEWS CMS TAB --}}
    @if($activeTab === 'news')
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <input type="text" wire:model.live.debounce.300ms="newsSearch" placeholder="{{ $t('بحث في المقالات والإعلانات...', 'Rechercher actualités...', 'Search articles...') }}" class="px-3.5 py-2 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                </div>
                <button wire:click="openCreateNews" class="px-4 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>{{ $t('إضافة مقال جديد', 'Nouveau Article', 'Create Article') }}</span>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-start text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 uppercase font-black text-[10px]">
                            <th class="p-3 text-start">#</th>
                            <th class="p-3 text-start">{{ $t('عنوان المقال', 'Titre', 'Article Title') }}</th>
                            <th class="p-3 text-start">{{ $t('التصنيف', 'Catégorie', 'Category') }}</th>
                            <th class="p-3 text-start">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                            <th class="p-3 text-start">{{ $t('تاريخ النشر', 'Date', 'Published At') }}</th>
                            <th class="p-3 text-end">{{ $t('الإجراءات', 'Actions', 'Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-bold">
                        @forelse($articles as $art)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-900/30">
                                <td class="p-3 text-slate-400 font-mono">{{ $art->id }}</td>
                                <td class="p-3 font-black text-slate-900 dark:text-white">{{ $art->title_ar }}</td>
                                <td class="p-3"><span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-[10px] font-bold">{{ $art->category }}</span></td>
                                <td class="p-3"><span class="px-2 py-0.5 rounded-lg text-[10px] font-bold {{ $art->status === 'PUBLISHED' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">{{ $art->status }}</span></td>
                                <td class="p-3 text-slate-400 font-mono text-[11px]">{{ $art->published_at?->format('Y-m-d') ?? '—' }}</td>
                                <td class="p-3 text-end">
                                    <button wire:click="openEditNews({{ $art->id }})" class="px-2.5 py-1 rounded-xl bg-[#06205C] text-white text-[11px] font-black me-1">{{ $t('تعديل', 'Edit', 'Edit') }}</button>
                                    <button wire:click="confirmDelete({{ $art->id }}, 'NEWS', '{{ $art->title_ar }}')" class="p-1 text-rose-600 hover:bg-rose-50 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-8 text-center text-slate-400 font-bold text-xs">{{ $t('لا يوجد مقالات إخبارية مسجلة.', 'Aucun article.', 'No news articles available.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-2">{{ $articles->links() }}</div>
        </div>
    @endif

    {{-- 5. VIDEOS CMS TAB --}}
    @if($activeTab === 'videos')
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <input type="text" wire:model.live.debounce.300ms="videoSearch" placeholder="{{ $t('بحث في مكتبة الفيديوهات...', 'Rechercher vidéos...', 'Search videos...') }}" class="px-3.5 py-2 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <div class="flex items-center gap-2">
                    <button wire:click="syncYouTubeChannel" class="px-4 py-2.5 rounded-2xl bg-rose-700 hover:bg-rose-800 text-white font-black text-xs shadow-md transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>{{ $t('استيراد من YouTube', 'Sync YouTube', 'Sync YouTube') }}</span>
                    </button>

                    <button wire:click="openCreateVideo" class="px-4 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>{{ $t('إضافة فيديو جديد', 'Nouveau Vidéo', 'Add Video') }}</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($videos as $v)
                    <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 space-y-2">
                        <h4 class="font-black text-slate-900 dark:text-white text-xs line-clamp-1">{{ $v->title_ar }}</h4>
                        <p class="text-[11px] text-slate-500 font-mono truncate">{{ $v->video_url }}</p>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-200 dark:border-slate-700">
                            <span class="text-[10px] font-bold px-2 py-0.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded">{{ $v->video_type }}</span>
                            <div class="flex items-center gap-1">
                                <button wire:click="openEditVideo({{ $v->id }})" class="px-2 py-1 bg-[#06205C] text-white rounded-lg text-[10px] font-black">{{ $t('تعديل', 'Edit', 'Edit') }}</button>
                                <button wire:click="confirmDelete({{ $v->id }}, 'VIDEO', '{{ $v->title_ar }}')" class="p-1 text-rose-600 hover:bg-rose-100 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center text-slate-400 font-bold text-xs">{{ $t('لا يوجد فيديوهات في المكتبة.', 'Aucune vidéo.', 'No videos in library.') }}</div>
                @endforelse
            </div>

            <div class="pt-2">{{ $videos->links() }}</div>
        </div>
    @endif

    {{-- 6. GALLERY CMS TAB --}}
    @if($activeTab === 'gallery')
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <input type="text" wire:model.live.debounce.300ms="gallerySearch" placeholder="{{ $t('بحث في ألبومات الصور...', 'Rechercher albums...', 'Search albums...') }}" class="px-3.5 py-2 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <button wire:click="openCreateAlbum" class="px-4 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>{{ $t('إنشاء ألبوم جديد', 'Nouveau Album', 'Create Album') }}</span>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($albums as $alb)
                    <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="font-black text-slate-900 dark:text-white text-sm">{{ $alb->title_ar }}</h4>
                            <span class="text-[10px] font-bold px-2 py-0.5 bg-amber-100 text-amber-800 rounded">{{ $alb->photos_count ?? ($alb->photos?->count() ?? 0) }} {{ $t('صورة', 'Photos', 'Photos') }}</span>
                        </div>
                        <p class="text-xs text-slate-500 font-bold line-clamp-2">{{ $alb->description_ar ?? '—' }}</p>
                        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-200 dark:border-slate-700">
                            <button wire:click="confirmDelete({{ $alb->id }}, 'ALBUM', '{{ $alb->title_ar }}')" class="p-1.5 text-rose-600 hover:bg-rose-100 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center text-slate-400 font-bold text-xs">{{ $t('لا يوجد ألبومات صور.', 'Aucun album.', 'No photo albums.') }}</div>
                @endforelse
            </div>

            <div class="pt-2">{{ $albums->links() }}</div>
        </div>
    @endif

    {{-- 7. LEGAL & GUIDE TAB --}}
    @if($activeTab === 'legal')
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-5">
            <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-700 pb-3">
                <button wire:click="loadLegalDocument('privacy')" class="px-4 py-2 rounded-xl text-xs font-black {{ $legalActiveKey === 'privacy' ? 'bg-[#06205C] text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">{{ $t('سياسة الخصوصية', 'Confidentialité', 'Privacy Policy') }}</button>
                <button wire:click="loadLegalDocument('terms')" class="px-4 py-2 rounded-xl text-xs font-black {{ $legalActiveKey === 'terms' ? 'bg-[#06205C] text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">{{ $t('شروط الاستخدام', 'Conditions', 'Terms of Service') }}</button>
                <button wire:click="loadLegalDocument('guide')" class="px-4 py-2 rounded-xl text-xs font-black {{ $legalActiveKey === 'guide' ? 'bg-[#06205C] text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">{{ $t('دليل الأولمبياد والقوانين', 'Guide', 'User Guide & Rules') }}</button>
            </div>

            <div class="space-y-4 text-xs">
                <div>
                    <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('عنوان الوثيقة (عربي)', 'Titre (AR)', 'Title (AR)') }}</label>
                    <input type="text" wire:model="legal_title_ar" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                </div>

                <div>
                    <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('نص ومحتوى الوثيقة الرسمي (عربي)', 'Contenu (AR)', 'Content Text (AR)') }}</label>
                    <textarea wire:model="legal_content_ar" rows="8" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white"></textarea>
                </div>

                <button wire:click="saveLegalDocument" class="px-5 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition">
                    {{ $t('حفظ الوثيقة القانونية', 'Enregistrer Document', 'Save Document') }}
                </button>
            </div>
        </div>
    @endif

    {{-- 8. APPEARANCE TAB --}}
    @if($activeTab === 'appearance')
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-5">
            <h2 class="text-base font-black text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-700 pb-3">
                {{ $t('مظهر المنصة والتطوير البصري', 'Apparence & Thème', 'Platform Identity & Theme') }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('اسم المنصة الرسمي', 'Nom du site', 'Platform Name') }}</label>
                    <input type="text" wire:model="site_name" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                </div>

                <div>
                    <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('رابط الشعار الرسمي (Logo URL)', 'Logo URL', 'Logo URL') }}</label>
                    <input type="text" wire:model="site_logo_url" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                </div>

                <div>
                    <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('اللون الرئيسي للهوية (Primary Color)', 'Couleur Principale', 'Primary Color') }}</label>
                    <input type="color" wire:model="primary_color" class="w-full h-10 p-1 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer">
                </div>

                <div>
                    <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('اللون الثانوي (Accent Color)', 'Couleur Secondaire', 'Accent Color') }}</label>
                    <input type="color" wire:model="accent_color" class="w-full h-10 p-1 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer">
                </div>
            </div>

            <button wire:click="saveAppearanceSettings" class="px-5 py-2.5 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs shadow-md transition">
                {{ $t('حفظ إعدادات المظهر', 'Enregistrer Apparence', 'Save Appearance Settings') }}
            </button>
        </div>
    @endif

    {{-- MODALS --}}

    {{-- News Modal --}}
    @if($showNewsModal)
        <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700 my-auto text-xs">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="font-black text-slate-900 dark:text-white text-sm">{{ $editingNewsId ? $t('تعديل مقال إخباري', 'Modifier Article', 'Edit Article') : $t('إضافة مقال جديد', 'Nouveau Article', 'Create Article') }}</h3>
                    <button wire:click="$set('showNewsModal', false)" class="text-slate-400 hover:text-slate-600"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block font-black mb-1">{{ $t('العنوان بالعربية *', 'Titre AR *', 'Title AR *') }}</label>
                        <input type="text" wire:model="news_title_ar" class="w-full px-3.5 py-2 rounded-xl border font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-black mb-1">{{ $t('ملخص المقال', 'Résumé', 'Excerpt') }}</label>
                        <textarea wire:model="news_excerpt_ar" rows="2" class="w-full px-3.5 py-2 rounded-xl border font-bold bg-slate-50 dark:bg-slate-900 dark:text-white"></textarea>
                    </div>
                    <div>
                        <label class="block font-black mb-1">{{ $t('محتوى المقال الكامل', 'Contenu', 'Content') }}</label>
                        <textarea wire:model="news_content_ar" rows="4" class="w-full px-3.5 py-2 rounded-xl border font-bold bg-slate-50 dark:bg-slate-900 dark:text-white"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showNewsModal', false)" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 font-bold">{{ $t('إلغاء', 'Annuler', 'Cancel') }}</button>
                    <button wire:click="saveNewsArticle" class="px-5 py-2 rounded-xl bg-amber-600 text-white font-black shadow-md">{{ $t('حفظ ونشر', 'Enregistrer', 'Save & Publish') }}</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Video Modal --}}
    @if($showVideoModal)
        <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700 my-auto text-xs">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="font-black text-slate-900 dark:text-white text-sm">{{ $editingVideoId ? $t('تعديل فيديو', 'Modifier Vidéo', 'Edit Video') : $t('إضافة فيديو جديد', 'Nouveau Vidéo', 'Add Video') }}</h3>
                    <button wire:click="$set('showVideoModal', false)" class="text-slate-400 hover:text-slate-600"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block font-black mb-1">{{ $t('عنوان الفيديو بالعربية *', 'Titre AR *', 'Video Title AR *') }}</label>
                        <input type="text" wire:model="video_title_ar" class="w-full px-3.5 py-2 rounded-xl border font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-black mb-1">{{ $t('رابط الفيديو (YouTube URL) *', 'URL Vidéo *', 'Video URL *') }}</label>
                        <input type="text" wire:model="video_url" class="w-full px-3.5 py-2 rounded-xl border font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showVideoModal', false)" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 font-bold">{{ $t('إلغاء', 'Annuler', 'Cancel') }}</button>
                    <button wire:click="saveVideo" class="px-5 py-2 rounded-xl bg-amber-600 text-white font-black shadow-md">{{ $t('حفظ', 'Enregistrer', 'Save') }}</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Gallery Modal --}}
    @if($showGalleryModal)
        <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700 my-auto text-xs">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="font-black text-slate-900 dark:text-white text-sm">{{ $editingAlbumId ? $t('تعديل الألبوم', 'Modifier Album', 'Edit Album') : $t('إنشاء ألبوم صور جديد', 'Nouveau Album', 'Create Album') }}</h3>
                    <button wire:click="$set('showGalleryModal', false)" class="text-slate-400 hover:text-slate-600"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block font-black mb-1">{{ $t('عنوان الألبوم بالعربية *', 'Titre Album AR *', 'Album Title AR *') }}</label>
                        <input type="text" wire:model="album_title_ar" class="w-full px-3.5 py-2 rounded-xl border font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-black mb-1">{{ $t('وصف الألبوم', 'Description', 'Description') }}</label>
                        <textarea wire:model="album_description_ar" rows="2" class="w-full px-3.5 py-2 rounded-xl border font-bold bg-slate-50 dark:bg-slate-900 dark:text-white"></textarea>
                    </div>
                    <div>
                        <label class="block font-black mb-1">{{ $t('رفع صور جديدة للألبوم', 'Téléverser des photos', 'Upload Photos') }}</label>
                        <input type="file" wire:model="newPhotos" multiple class="w-full text-xs">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showGalleryModal', false)" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 font-bold">{{ $t('إلغاء', 'Annuler', 'Cancel') }}</button>
                    <button wire:click="saveAlbum" class="px-5 py-2 rounded-xl bg-amber-600 text-white font-black shadow-md">{{ $t('حفظ الألبوم', 'Enregistrer Album', 'Save Album') }}</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700 my-auto text-center">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 font-black flex items-center justify-center mx-auto border border-rose-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-base font-black text-rose-600">{{ $t('تأكيد الحذف النهائي؟', 'Confirmer la suppression ?', 'Confirm deletion?') }}</h3>
                <p class="text-xs font-bold text-slate-500">{{ $deletingItemTitle }}</p>

                <div class="flex items-center justify-center gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 rounded-2xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">{{ $t('إلغاء', 'Annuler', 'Cancel') }}</button>
                    <button wire:click="executeDeleteAction" class="px-5 py-2 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-md transition">{{ $t('حذف نهائي', 'Supprimer', 'Delete') }}</button>
                </div>
            </div>
        </div>
    @endif

</div>
