@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
$userRole = $user?->roles->first()?->name ?? 'PARTICIPANT';

$userRoleKey = match($userRole) {
    'EXECUTIVE_VIEWER'                  => 'MINISTERIAL EXECUTIVE OBSERVER',
    'COUNTRY_ADMIN'                     => 'DELEGATION HEAD',
    'JUDGE', 'EXPERT'                   => 'EXPERT JUDGE',
    'MEDIA_MANAGER'                     => 'MEDIA',
    'ORGANIZATION_ADMIN', 'SUPER_ADMIN' => 'ORGANIZER',
    default                             => 'COMPETITOR',
};

$badgeTheme = match($userRoleKey) {
    'MINISTERIAL EXECUTIVE OBSERVER' => [
        'bg'     => 'radial-gradient(circle at 20% 20%, #7C3AED 0%, #4C1D95 40%, #1E1B4B 70%, #D97706 100%)',
        'badge'  => 'وزير / مراقب تنفيذي — MINISTERIAL EXECUTIVE OBSERVER',
        'accent' => '#FDE047',
        'pill'   => 'bg-purple-900/80 text-purple-200 border-purple-400/40',
    ],
    'DELEGATION HEAD' => [
        'bg'     => 'radial-gradient(circle at 80% 20%, #059669 0%, #047857 35%, #022C22 75%, #B45309 100%)',
        'badge'  => 'مسؤول الوفد — DELEGATION HEAD',
        'accent' => '#FEF08A',
        'pill'   => 'bg-emerald-900/80 text-emerald-200 border-emerald-400/40',
    ],
    'EXPERT JUDGE' => [
        'bg'     => 'radial-gradient(circle at 50% 20%, #4338CA 0%, #312E81 40%, #0F172A 80%, #6D28D9 100%)',
        'badge'  => 'خبير محكّم — EXPERT JUDGE',
        'accent' => '#A5B4FC',
        'pill'   => 'bg-indigo-900/80 text-indigo-200 border-indigo-400/40',
    ],
    'MEDIA' => [
        'bg'     => 'radial-gradient(circle at 30% 70%, #D97706 0%, #B45309 40%, #451A03 80%, #78350F 100%)',
        'badge'  => 'وفد إعلامي — MEDIA / PRESS',
        'accent' => '#FDE68A',
        'pill'   => 'bg-amber-900/80 text-amber-200 border-amber-400/40',
    ],
    'ORGANIZER' => [
        'bg'     => 'linear-gradient(135deg, #0A192F 0%, #06205C 35%, #0B48A8 70%, #0284C7 100%)',
        'badge'  => 'منظم رئيسي للمسابقة — ORGANIZER',
        'accent' => '#38BDF8',
        'pill'   => 'bg-blue-900/80 text-blue-200 border-blue-400/40',
    ],
    default => [
        'bg'     => 'linear-gradient(135deg, #042F2E 0%, #0D9488 40%, #0284C7 80%, #0369A1 100%)',
        'badge'  => 'متنافس رسمي — COMPETITOR',
        'accent' => '#5EEAD4',
        'pill'   => 'bg-teal-900/80 text-teal-200 border-teal-400/40',
    ],
};

$roleLabel = match($userRoleKey) {
    'MINISTERIAL EXECUTIVE OBSERVER' => $t('وزير / مراقب تنفيذي', 'Ministre / Observateur Exécutif', 'Minister & Executive Observer'),
    'DELEGATION HEAD'                => $t('مسؤول الوفد (Head of Delegation)', 'Chef de Délégation', 'Head of Delegation'),
    'EXPERT JUDGE'                   => $t('خبير محكّم (Expert Judge)', 'Expert Juge', 'Expert Judge'),
    'MEDIA'                          => $t('مسؤول الإعلام والصحافة', 'Responsable Médias & Presse', 'Press & Media Manager'),
    'ORGANIZER'                      => $t('منظم رئيسي للمسابقة', 'Organisateur Officiel', 'Official Organizer'),
    default                          => $t('متنافس رسمي', 'Compétiteur Officiel', 'Official Competitor'),
};

$countryName = $user?->country ? ($locale === 'fr' ? ($user->country->name_fr ?? $user->country->name_en) : ($locale === 'en' ? $user->country->name_en : $user->country->name_ar)) : $t('الجمهورية الجزائرية', 'Algérie', 'Algeria');

$badgeVerifyUrl = route('accreditation.badge', ['identifier' => $user?->uuid ?? ($user?->id ?? 1)]);
$badgeQrUrl = \App\Services\QrCodeService::generateDataUri($badgeVerifyUrl, 300);
@endphp

<div class="space-y-8 pb-16 font-sans text-slate-900 dark:text-white" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ── 1. UNIFIED LUXURY PAGE HEADER ── --}}
    <x-dashboard.page-header
        :title="$t('الملف الشخصي وشارة الاعتماد الرقمية VIP', 'Profil & Badge d\'Accréditation VIP', 'User Profile & Official Badge Pass')"
        :subtitle="$user?->name . ' — ' . $roleLabel . ' — ' . $countryName . ' (' . $user?->email . ')'"
    >
        <a href="{{ $badgeVerifyUrl }}" target="_blank" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs transition shadow-lg shrink-0">
            <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>{{ $t('طباعة الشارة الرسمية (PVC Pass) ↗', 'Imprimer Badge (PVC) ↗', 'Print PVC Badge Pass ↗') }}</span>
        </a>
    </x-dashboard.page-header>

    {{-- SUCCESS NOTIFICATION --}}
    @if($successMessage ?? null)
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 text-xs font-black flex items-center justify-between shadow-xs animate-fade-in">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $successMessage }}</span>
            </div>
        </div>
    @endif

    {{-- ── 2. HERO SPLIT SECTION: PROFILE SUMMARY & 3D BADGE PASS CARD ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- LEFT COLUMN: USER AVATAR & CREDENTIAL HIGHLIGHTS (5 COLS) --}}
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-700 shadow-xl relative overflow-hidden space-y-6">
                
                {{-- Ambient Decorative Glow --}}
                <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-blue-600/10 dark:bg-blue-500/20 blur-3xl pointer-events-none"></div>

                {{-- User Avatar Upload Box --}}
                <div class="flex flex-col items-center text-center space-y-4 relative z-10">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-3xl overflow-hidden ring-4 ring-blue-600/30 dark:ring-sky-400/40 shadow-2xl bg-slate-100 dark:bg-slate-900 flex items-center justify-center">
                            <img src="{{ ($photo ?? null) ? $photo->temporaryUrl() : ($user?->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user?->name ?? 'U').'&background=06205C&color=fff') }}" 
                                 alt="{{ $user?->name }}" 
                                 class="w-full h-full object-cover">
                        </div>

                        {{-- Change Photo Overlay Label Button --}}
                        <label for="photo-upload-hero" class="absolute -bottom-2 -right-2 bg-gradient-to-r from-[#06205C] to-blue-700 hover:from-blue-700 hover:to-blue-900 text-white p-3 rounded-2xl cursor-pointer shadow-xl transition transform hover:scale-110 border-2 border-white dark:border-slate-800 flex items-center justify-center" title="{{ $t('تغيير الصورة الشخصية', 'Changer la photo', 'Change profile picture') }}">
                            <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </label>
                        <input type="file" id="photo-upload-hero" wire:model="photo" accept="image/*" class="hidden">
                    </div>

                    <div class="space-y-1.5">
                        <h2 class="text-2xl font-black text-[#06205C] dark:text-white tracking-tight">{{ $user?->name }}</h2>
                        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black {{ $badgeTheme['pill'] }} border shadow-xs">
                            {{ $roleLabel }}
                        </span>
                    </div>

                    <div class="space-y-1 text-xs font-bold text-slate-500 dark:text-slate-400">
                        <p class="flex items-center justify-center gap-2">
                            <span>🇩🇿 {{ $countryName }}</span>
                            <span class="text-slate-300 dark:text-slate-700">•</span>
                            <span class="font-mono text-blue-600 dark:text-blue-400">{{ $user?->email }}</span>
                        </p>
                    </div>
                </div>

                {{-- Official Logos Branding Panel --}}
                <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700/80 space-y-3 relative z-10">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block text-center">
                        اللوغو الرسمي والجهة الراعية
                    </span>
                    <div class="flex items-center justify-center gap-6">
                        {{-- 1. Official Ministry Logo --}}
                        <img src="/ministry-logo-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-9 w-auto object-contain dark:brightness-0 dark:invert">

                        <div class="h-6 w-px bg-slate-200 dark:bg-slate-700"></div>

                        {{-- 2. Platform Logo --}}
                        <img src="/logo.svg" alt="WorldSkills Algeria" class="h-9 w-auto object-contain dark:brightness-0 dark:invert">
                    </div>
                </div>

                {{-- Account Badges Status --}}
                <div class="space-y-2 pt-2 border-t border-slate-100 dark:border-slate-700 relative z-10">
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="text-slate-500 dark:text-slate-400">حالة التوثيق:</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-black flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>حساب معتمد نشط</span>
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="text-slate-500 dark:text-slate-400">الدورة الرسمية:</span>
                        <span class="text-amber-600 dark:text-amber-300 font-mono font-black">WorldSkills Africa 2027</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT COLUMN: 3D SOVEREIGN ACCREDITATION DIPLOMATIC BADGE PASS CARD (7 COLS) --}}
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-700 shadow-xl space-y-6">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-700/80 pb-4">
                    <div>
                        <h3 class="text-base font-black text-[#06205C] dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
                            <span>{{ $t('شارة الاعتماد الرسمية المعتمدة لصفة حسابك:', 'Votre Badge Officiel d\'Accréditation:', 'Your Official Accredited Sovereign Badge Pass:') }}</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold mt-0.5">
                            تم إصدار هذه الشارة رسميًا وتتضمن كود QR مفتاح الوصول الأمني المباشر.
                        </p>
                    </div>

                    <a href="{{ $badgeVerifyUrl }}" target="_blank" class="px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition flex items-center gap-2 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>{{ $t('طباعة (Print PVC)', 'Imprimer', 'Print Badge') }}</span>
                    </a>
                </div>

                {{-- 3D DIPLOMATIC CREDENTIAL PASS CONTAINER --}}
                <div class="flex justify-center py-2">
                    <div class="w-full max-w-sm rounded-[2.5rem] p-6 shadow-2xl border-4 border-white/80 space-y-5 text-white text-center transition transform hover:scale-102 relative overflow-hidden" style="background: {{ $badgeTheme['bg'] }};">
                        
                        {{-- Clip Lanyard Simulation Slot --}}
                        <div class="w-16 h-4 bg-slate-950/80 border border-white/30 rounded-full mx-auto shadow-inner flex items-center justify-center -mt-2">
                            <div class="w-8 h-1 bg-white/40 rounded-full"></div>
                        </div>

                        {{-- 1. TOP CENTER LOGO: MINISTRY OF VOCATIONAL TRAINING (ENGRAVED & CENTERED) --}}
                        <div class="pt-4 pb-2 border-b border-white/20 flex justify-center items-center w-full text-center px-2 mt-1">
                            <img src="/ministry-logo-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-9 sm:h-10 w-auto max-w-[85%] object-contain mx-auto" style="filter: brightness(0) invert(1) drop-shadow(0px -1px 1px rgba(255,255,255,0.75)) drop-shadow(0px 3px 5px rgba(0,0,0,0.92));">
                        </div>

                        {{-- 2. CENTER: ENGRAVED GLASSMORPHISM QR CODE PLATE --}}
                        <div class="w-48 h-48 bg-white/20 backdrop-blur-xl p-3 rounded-3xl mx-auto shadow-2xl flex flex-col items-center justify-between border-2 border-white/40 shadow-[0_15px_30px_rgba(0,0,0,0.5),inset_0_1px_2px_rgba(255,255,255,0.6)]">
                            <div class="w-36 h-36 bg-white p-1.5 rounded-2xl flex items-center justify-center shadow-inner border border-slate-100">
                                <img src="{{ $badgeQrUrl }}" alt="QR Code Access Token" class="w-full h-full object-contain">
                            </div>
                            <span class="text-[7.5px] font-mono font-black text-white/90 uppercase tracking-wider drop-shadow-xs">SECURED BY WSAP ZERO-TRUST</span>
                        </div>

                        {{-- 3. BOTTOM SECTION: USER DETAILS + EVENT PLATFORM LOGO (BOTTOM LEFT) --}}
                        <div class="pt-3 pb-2 flex items-center justify-between border-t border-white/20 px-2 text-right">
                            {{-- User Name & Email --}}
                            <div class="space-y-0.5 truncate max-w-[210px]">
                                <h2 class="text-lg font-black text-white tracking-tight truncate leading-tight">{{ $user?->name }}</h2>
                                <p class="text-[11px] font-mono font-bold text-slate-200 truncate" dir="ltr">{{ $user?->email }}</p>
                            </div>

                            {{-- Bottom Left Event Logo --}}
                            <div class="shrink-0 pl-2">
                                <img src="/logo.svg" alt="WorldSkills Event Logo" class="h-9 w-auto object-contain brightness-0 invert opacity-95">
                            </div>
                        </div>

                        {{-- 4. SOVEREIGN ROLE TITLE BANNER --}}
                        <div class="pt-3 border-t border-white/20">
                            <span class="text-xs font-black tracking-widest uppercase block text-center py-1.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/20" style="color: {{ $badgeTheme['accent'] }};">
                                {{ $badgeTheme['badge'] }}
                            </span>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- ── 3. COMPREHENSIVE ACCOUNT OVERVIEW GRID ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-700 shadow-xl space-y-6">
        <h3 class="text-base font-black text-[#06205C] dark:text-white uppercase tracking-wider flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
            <span>{{ $t('معلومات وسجل صاحب الحساب الشاملة:', 'Informations Complètes du Compte:', 'Comprehensive Account Overview:') }}</span>
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            
            <div class="p-5 rounded-3xl bg-slate-50/80 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700 space-y-1">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">{{ $t('الرتبة والصفة المعتمدة', 'Rôle Officiel', 'Official Role') }}</span>
                <p class="text-sm font-black text-slate-900 dark:text-white">{{ $roleLabel }}</p>
            </div>

            <div class="p-5 rounded-3xl bg-slate-50/80 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700 space-y-1">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">{{ $t('الدولة والوفد التابع له', 'Pays & Délégation', 'Country & Delegation') }}</span>
                <p class="text-sm font-black text-blue-600 dark:text-blue-400">🇩🇿 {{ $countryName }}</p>
            </div>

            <div class="p-5 rounded-3xl bg-slate-50/80 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700 space-y-1">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">{{ $t('المؤسسة / القطاع المعين', 'Organisation / Secteur', 'Organization / Sector') }}</span>
                <p class="text-sm font-black text-slate-900 dark:text-white">{{ $user?->organization?->getLocalized('name') ?? $t('قطاع رسمي معتمد', 'Secteur Officiel', 'Official Sector') }}</p>
            </div>

            <div class="p-5 rounded-3xl bg-slate-50/80 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700 space-y-1">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">{{ $t('الولاية / المنطقة الإقليمية', 'Wilaya / Région', 'Wilaya / Region') }}</span>
                <p class="text-sm font-black text-slate-900 dark:text-white">{{ $user?->wilaya?->name_ar ?? $t('الجزائر العاصمة', 'Alger', 'Algiers') }}</p>
            </div>

            <div class="p-5 rounded-3xl bg-slate-50/80 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700 space-y-1">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">{{ $t('حالة تفعيل الحساب', 'Statut du Compte', 'Account Status') }}</span>
                <p class="text-sm font-black text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>{{ $t('مفعل ومعتمد رسمي (ACTIVE)', 'Compte Actif', 'Active Account') }}</span>
                </p>
            </div>

            <div class="p-5 rounded-3xl bg-slate-50/80 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700 space-y-1">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">{{ $t('طبعة المسابقة الرسمية', 'Édition de la Compétition', 'Official Edition') }}</span>
                <p class="text-sm font-black text-amber-600 dark:text-amber-300">WorldSkills Africa 2027</p>
            </div>

        </div>
    </div>

    {{-- ── 4. PROFILE & PERSONAL DETAILS EDIT FORM ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-700 shadow-xl space-y-6">
        <h3 class="text-base font-black text-[#06205C] dark:text-white uppercase tracking-wider flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
            <span>{{ $t('تحديث البيانات الشخصية والمعلومات الإضافية:', 'Mise à jour des informations personnelles:', 'Update Personal & Profile Details:') }}</span>
        </h3>

        <form wire:submit.prevent="updateProfile" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <div>
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ $t('الاسم الكامل لصاحب الحساب', 'Nom Complet', 'Full Name') }} *
                    </label>
                    <input type="text" wire:model="name" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition outline-none">
                    @error('name') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ $t('البريد الإلكتروني المعتمد', 'Adresse E-mail', 'Email Address') }} *
                    </label>
                    <input type="email" wire:model="email" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition outline-none">
                    @error('email') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ $t('رقم الهاتف للتواصل الرسمي', 'Numéro de Téléphone', 'Phone Number') }}
                    </label>
                    <input type="text" wire:model="phone" placeholder="+213..." class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition outline-none">
                    @error('phone') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ $t('اللغة المفضلة للنظام والواجهة', 'Langue Préférée', 'Preferred Language') }}
                    </label>
                    <select wire:model="locale" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition outline-none">
                        <option value="ar">العربية (Arabic - RTL)</option>
                        <option value="fr">Français (French - LTR)</option>
                        <option value="en">English (English - LTR)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ $t('رقم جواز السفر الدولي', 'Numéro de Passeport', 'Passport Number') }}
                    </label>
                    <input type="text" wire:model="passport_number" placeholder="DZ-1234567" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs font-mono font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition outline-none">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ $t('رقم التعريف الوطني (NIN)', 'Numéro NIN', 'NIN Number') }}
                    </label>
                    <input type="text" wire:model="nin_number" placeholder="10000200..." class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs font-mono font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition outline-none">
                </div>

            </div>

            <div class="flex items-center justify-end pt-4 border-t border-slate-100 dark:border-slate-700">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ $t('حفظ وتحديث البيانات الشخصية', 'Enregistrer les Modifications', 'Save Account Details') }}</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ── 5. CHANGE PASSWORD & SECURITY FORM ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-700 shadow-xl space-y-6">
        <h3 class="text-base font-black text-[#06205C] dark:text-white uppercase tracking-wider flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
            <span>{{ $t('تغيير كلمة المرور وتأمين الحساب:', 'Changer le Mot de Passe:', 'Change Password & Security:') }}</span>
        </h3>

        <form wire:submit.prevent="updatePassword" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ $t('كلمة المرور الحالية', 'Mot de Passe Actuel', 'Current Password') }} *
                    </label>
                    <input type="password" wire:model="current_password" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition outline-none">
                    @error('current_password') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ $t('كلمة المرور الجديدة', 'Nouveau Mot de Passe', 'New Password') }} *
                    </label>
                    <input type="password" wire:model="new_password" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition outline-none">
                    @error('new_password') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ $t('تأكيد كلمة المرور الجديدة', 'Confirmer le Mot de Passe', 'Confirm New Password') }} *
                    </label>
                    <input type="password" wire:model="new_password_confirmation" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition outline-none">
                </div>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-slate-100 dark:border-slate-700">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs shadow-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>{{ $t('تحديث كلمة المرور', 'Mettre à jour le mot de passe', 'Update Password') }}</span>
                </button>
            </div>
        </form>
    </div>

</div>
