@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};

$roleColors = [
    'COMPETITOR'      => 'bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-500/20',
    'EXPERT JUDGE'    => 'bg-purple-500/10 text-purple-700 dark:text-purple-400 border-purple-500/20',
    'DELEGATION HEAD' => 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-500/20',
    'MEDIA'           => 'bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-500/20',
    'VIP'             => 'bg-gradient-to-r from-amber-500/20 to-purple-500/20 text-amber-800 dark:text-amber-300 border-amber-500/30',
    'ORGANIZER'       => 'bg-rose-500/10 text-rose-700 dark:text-rose-400 border-rose-500/20',
    'VOLUNTEER'       => 'bg-teal-500/10 text-teal-700 dark:text-teal-400 border-teal-500/20',
    'SPEAKER'         => 'bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border-indigo-500/20',
];
@endphp

<div class="space-y-6 pb-12 font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <x-dashboard.page-header
        :title="$t('مركز الاعتمادات وشارات الأمان الرقمية (Accreditation & Badges)', 'Accréditations & Badges de Sécurité', 'Accreditation & Security Badges Center')"
        :subtitle="$t('إدارة الاعتمادات الرقمية والمناطق الأمنية وشارات الدخول الفردية والجماعية', 'Gestion des badges d\'accès et zones de sécurité', 'Manage accreditation badges & security zone access')"
    >
        <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-black transition backdrop-blur-md shadow-xs shrink-0 cursor-pointer">
            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>{{ $t('تصدير إلى Excel (CSV)', 'Exporter Excel', 'Export to Excel') }}</span>
        </button>

        <a href="{{ route('admin.accreditations.batch-print', array_filter(['role' => $filterRole, 'country_id' => $filterCountry])) }}" target="_blank" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-black transition backdrop-blur-md shrink-0 cursor-pointer">
            <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            <span>{{ $t('طباعة دفعة الاعتمادات المصفاة', 'Impression en Lot', 'Batch Print Filtered') }}</span>
        </a>

        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-black transition shadow-md shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            <span>{{ $t('إصدار شارة اعتماد جديدة', 'Émettre un Badge', 'Issue New Badge') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- ALERTS & FLASH NOTIFICATIONS --}}
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs font-bold rounded-2xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- FLOATING BULK SELECTION ACTION BAR --}}
    @if(count($selectedUsers) > 0)
        <div class="p-4 bg-slate-900 dark:bg-slate-800 text-white rounded-3xl shadow-xl border border-slate-700 flex flex-wrap items-center justify-between gap-4 animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center font-black text-sm">
                    {{ count($selectedUsers) }}
                </div>
                <span class="text-xs font-bold">
                    {{ $t('عنصر محدد لعمليات الاعتماد والطباعة الجماعية', 'éléments sélectionnés', 'items selected for bulk action') }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.accreditations.batch-print', ['ids' => implode(',', $selectedUsers)]) }}" target="_blank"
                    class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs transition shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>{{ $t('طباعة الشارات المحددة (' . count($selectedUsers) . ')', 'Imprimer Badges Sélectionnés', 'Print Selected Badges (' . count($selectedUsers) . ')') }}</span>
                </a>
                <button wire:click="clearSelection" class="px-4 py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition">
                    {{ $t('إلغاء التحديد', 'Désélectionner', 'Clear Selection') }}
                </button>
            </div>
        </div>
    @endif

    {{-- STATS OVERVIEW CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Users -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('إجمالي الأعضاء المعتمدين', 'Total Accrédités', 'Total Accredited Members') }}
                    </span>
                    <span class="text-3xl font-black text-slate-900 dark:text-white mt-1 block">
                        {{ number_format($totalUsers) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-blue-600 dark:text-blue-400 flex items-center gap-1">
                <span>{{ $t('شارات دخول موثقة ومحدثة', 'Badges actifs validés', 'Verified active security badges') }}</span>
            </div>
        </div>

        <!-- Card 2: Competitor Badges -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('شارات المتنافسين والخبراء', 'Badges Compétiteurs & Experts', 'Competitor & Expert Badges') }}
                    </span>
                    <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400 mt-1 block">
                        {{ number_format($competitorCount) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-1">
                <span>{{ $t('دخول الميدان والورشات الحرة', 'Accès ateliers & compétition', 'Workshop & competition floor access') }}</span>
            </div>
        </div>

        <!-- Card 3: VIP & Delegations -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('شارات الوفود و VIP', 'Délégations & VIP', 'VIP & Delegation Badges') }}
                    </span>
                    <span class="text-3xl font-black text-amber-600 dark:text-amber-400 mt-1 block">
                        {{ number_format($vipCount) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-amber-600 dark:text-amber-400 flex items-center gap-1">
                <span>{{ $t('دخول المنصة الشرفية والصالونات', 'Accès tribune & salons VIP', 'VIP Lounge & Stage access') }}</span>
            </div>
        </div>

        <!-- Card 4: Security Zones -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('المناطق الأمنية المعتمدة', 'Zones de Sécurité', 'Security Zones') }}
                    </span>
                    <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-1 block">
                        {{ number_format($zonesCount) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                <span>{{ $t('مناطق دخول محددة بالرموز Z1-Z5', 'Zones réglementées Z1-Z5', 'Strict access zones Z1-Z5') }}</span>
            </div>
        </div>
    </div>

    {{-- ADVANCED 6-WAY FILTER BAR --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 space-y-4 shadow-xs">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/60 pb-3">
            <h2 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>{{ $t('فلترة متطورة جداً للاعتمادات وشارات الأمان', 'Filtrage Avancé des Badges', 'Advanced Accreditation Filtering') }}</span>
            </h2>
            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold">
                {{ $t('عرض ', 'Affichage de ', 'Displaying ') }} {{ $users->total() }} {{ $t(' عضو معتمد', ' membre accrédité', ' accredited members') }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3">
            <!-- Search -->
            <div class="relative xl:col-span-2">
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="{{ $t('بحث باسم العضو، الإيميل، رقم الشارة...', 'Recherche par nom, email, badge...', 'Search name, email, badge ID...') }}"
                    class="w-full ps-10 pe-4 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                <svg class="w-4 h-4 text-slate-400 absolute start-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Role / Category Filter -->
            <div>
                <select wire:model.live="filterRole" class="w-full px-3.5 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">{{ $t('-- كل الأدوار المعتمدة --', '-- Tous les rôles --', '-- All Roles --') }}</option>
                    <option value="COMPETITOR">COMPETITOR / مشارك متنافس</option>
                    <option value="EXPERT JUDGE">EXPERT JUDGE / حكم خبير</option>
                    <option value="DELEGATION HEAD">DELEGATION HEAD / رئيس وفد</option>
                    <option value="MEDIA">MEDIA / صحفي إعلامي</option>
                    <option value="VIP">VIP / ضيف شرف</option>
                    <option value="ORGANIZER">ORGANIZER / منظم</option>
                    <option value="VOLUNTEER">VOLUNTEER / متطوع</option>
                </select>
            </div>

            <!-- Country Filter -->
            <div>
                <select wire:model.live="filterCountry" class="w-full px-3.5 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">{{ $t('-- كل الدول والوفود --', '-- Tous les pays --', '-- All Countries --') }}</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name_ar }} ({{ $c->iso_code }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Skill Filter -->
            <div>
                <select wire:model.live="filterSkill" class="w-full px-3.5 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">{{ $t('-- كل التخصصات المهنية --', '-- Tous les métiers --', '-- All Skills --') }}</option>
                    @foreach($skills as $s)
                        <option value="{{ $s->id }}">{{ $s->name_ar }} ({{ $s->code }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <select wire:model.live="filterStatus" class="w-full px-3.5 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">{{ $t('-- كل حالات الاعتماد --', '-- Tous les statuts --', '-- All Badge Status --') }}</option>
                    <option value="ACTIVE">{{ $t('مفعل وموثق (ACTIVE)', 'Actif & Validé', 'Active & Issued') }}</option>
                    <option value="BLOCKED">{{ $t('محظور / موقوف (BLOCKED)', 'Bloqué / Suspendu', 'Blocked / Suspended') }}</option>
                </select>
            </div>
        </div>
    </div>

    {{-- ACCREDITATION DATA TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-xs text-start border-collapse align-middle">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-900/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200/80 dark:border-slate-700/80">
                        <th class="px-4 py-4 text-center w-10">
                            <input type="checkbox" wire:model.live="selectAll" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                        </th>
                        <th class="px-5 py-4 text-start min-w-[220px]">{{ $t('العضو المعتمد والصورة', 'Membre Accrédité', 'Accredited Member') }}</th>
                        <th class="px-5 py-4 text-start min-w-[160px] whitespace-nowrap">{{ $t('رقم الشارة والتسجيل', 'N° Badge / Enregistrement', 'Badge / Reg Number') }}</th>
                        <th class="px-5 py-4 text-start min-w-[160px] whitespace-nowrap">{{ $t('الدور والصفة المعتمدة', 'Rôle & Statut Officiel', 'Role & Badge Title') }}</th>
                        <th class="px-5 py-4 text-start min-w-[180px] whitespace-nowrap">{{ $t('الوفد والتخصص', 'Délégation & Métier', 'Delegation & Trade') }}</th>
                        <th class="px-5 py-4 text-start min-w-[170px] whitespace-nowrap">{{ $t('المناطق الأمنية المسموحة', 'Zones d\'Accès Autorisées', 'Allowed Security Zones') }}</th>
                        <th class="px-5 py-4 text-start min-w-[130px] whitespace-nowrap">{{ $t('حالة الاعتماد', 'Statut Badge', 'Accreditation Status') }}</th>
                        <th class="px-5 py-4 text-end min-w-[160px] whitespace-nowrap">{{ $t('إجراءات العمل', 'Actions', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @forelse($users as $u)
                        @php
                            $reg         = $u->participant?->registrations->first();
                            $badge       = $u->badges->first();
                            $roleTitle   = strtoupper($badge?->role_title ?? $u->roles->first()?->name ?? 'COMPETITOR');
                            $badgeColor  = $roleColors[$roleTitle] ?? 'bg-slate-500/10 text-slate-700 dark:text-slate-300 border-slate-500/20';
                            $identifier  = $badge?->access_token ?? $u->email;
                            $nameAr      = $u->participant?->first_name_ar ? ($u->participant->first_name_ar . ' ' . $u->participant->last_name_ar) : $u->name;
                            $nameLatin   = $u->participant?->first_name_latin ? ($u->participant->first_name_latin . ' ' . $u->participant->last_name_latin) : $u->email;
                            $regNumber   = $reg?->registration_number ?? ($badge?->badge_uuid ? ('BDG-' . substr($badge->badge_uuid, 0, 8)) : ('USR-' . str_pad($u->id, 5, '0', STR_PAD_LEFT)));
                            $countryName = $reg?->country?->name_ar ?? $u->country?->name_ar ?? 'الجزائر';
                            $skillOrOrg  = $reg?->skill?->name_ar ?? $u->organization?->name_ar ?? 'المنصة الوطنية';
                            $photoUrl    = $u->avatar_url;
                            $isBlocked   = ($badge?->status === 'BLOCKED');
                            $allowedZoneIds = $badge?->allowed_zone_ids ?? [1, 4];
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-900/40 transition {{ $isBlocked ? 'bg-rose-500/5 dark:bg-rose-950/20' : '' }}">
                            <!-- Checkbox -->
                            <td class="px-4 py-4 text-center">
                                <input type="checkbox" wire:model.live="selectedUsers" value="{{ $u->id }}" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            </td>

                            <!-- Member Info -->
                            <td class="px-5 py-4 min-w-[220px]">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $photoUrl }}" alt="{{ $nameAr }}" class="w-10 h-10 rounded-2xl object-cover border border-slate-200 dark:border-slate-700 shrink-0 bg-slate-100">
                                    <div>
                                        <span class="font-black text-slate-900 dark:text-white block text-xs leading-snug">
                                            {{ $nameAr }}
                                        </span>
                                        <span class="text-[11px] text-slate-500 dark:text-slate-400 font-mono block font-semibold">
                                            {{ $nameLatin }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Reg / Badge Code -->
                            <td class="px-5 py-4 font-mono font-bold text-slate-800 dark:text-slate-200 min-w-[160px] whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-700/60 border border-slate-200/60 dark:border-slate-700/60 inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                    <span>{{ $regNumber }}</span>
                                </span>
                            </td>

                            <!-- Badge Role Title -->
                            <td class="px-5 py-4 min-w-[160px] whitespace-nowrap">
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black border uppercase tracking-wider inline-block {{ $badgeColor }}">
                                    {{ $roleTitle }}
                                </span>
                            </td>

                            <!-- Country & Skill -->
                            <td class="px-5 py-4 min-w-[180px] whitespace-nowrap">
                                <span class="block font-bold text-slate-800 dark:text-slate-200">{{ $countryName }}</span>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 block font-medium">{{ $skillOrOrg }}</span>
                            </td>

                            <!-- Allowed Zones -->
                            <td class="px-5 py-4 min-w-[170px] whitespace-nowrap">
                                <div class="flex items-center gap-1 flex-wrap">
                                    @foreach($zones as $z)
                                        @if(in_array($z->id, $allowedZoneIds))
                                            <span title="{{ $z->name_ar }}" class="px-2 py-0.5 rounded-lg text-[10px] font-mono font-bold text-white shadow-2xs" style="background-color: {{ $z->color_hex }};">
                                                {{ $z->code }}
                                            </span>
                                        @endif
                                    @endforeach
                                    <button wire:click="openEditZones({{ $u->id }})" title="{{ $t('تعديل المناطق', 'Modifier Zones', 'Edit Zones') }}" class="p-1 text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-5 py-4 min-w-[130px] whitespace-nowrap">
                                @if($isBlocked)
                                    <span class="px-3 py-1 rounded-xl text-[10px] font-black bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-500/20 inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        <span>{{ $t('موقوف / محظور', 'Bloqué', 'Blocked') }}</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-xl text-[10px] font-black bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20 inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $t('مفعل معتمد', 'Actif Validé', 'Active') }}</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-5 py-4 text-end min-w-[160px] whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-2">
                                    <a href="{{ route('accreditation.badge', ['identifier' => $identifier]) }}" target="_blank"
                                        title="{{ $t('طباعة بطاقة الاعتماد', 'Imprimer Badge', 'Print Badge') }}"
                                        class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-[11px] transition inline-flex items-center gap-1.5 shadow-xs cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                        <span>{{ $t('طباعة', 'Imprimer', 'Print') }}</span>
                                    </a>

                                    <button wire:click="toggleBlockUser({{ $u->id }})"
                                        title="{{ $isBlocked ? $t('إعادة التفعيل', 'Débloquer', 'Unblock') : $t('حظر البطاقة', 'Bloquer', 'Block') }}"
                                        class="p-1.5 rounded-xl border transition cursor-pointer {{ $isBlocked ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 border-emerald-200 dark:border-emerald-800 hover:bg-emerald-100' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 border-slate-200/60 dark:border-slate-700' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($isBlocked)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            @endif
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-slate-400 font-medium">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <svg class="w-10 h-10 mx-auto text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6"/>
                                    </svg>
                                    <p class="text-xs font-bold text-slate-600 dark:text-slate-400">
                                        {{ $t('لا يوجد أعضاء معتمدين يطابقون خيارات التصفية والبحث حالياً', 'Aucun membre trouvé', 'No accredited members matching filter') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-5 py-4 border-t border-slate-200/80 dark:border-slate-700/80 bg-slate-50/50 dark:bg-slate-900/40">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL FORM: ISSUE CUSTOM BADGE --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-lg shadow-2xl border border-slate-200 dark:border-slate-700 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white">
                                {{ $t('إصدار شارة اعتماد جديدة', 'Émettre un Nouveau Badge', 'Issue New Accreditation Badge') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $t('حدد العضو المسجل والدور والمناطق الأمنية المسموحة', 'Sélectionnez le membre et les zones autorisées', 'Select user, role title, and allowed security zones') }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('formOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4 text-xs font-semibold">
                    <!-- User Select -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                            {{ $t('اختر المسجل / العضو *', 'Membre *', 'Member *') }}
                        </label>
                        <select wire:model="user_id_badge" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="0">{{ $t('-- اختر مسجلاً / عضواً من النظام --', '-- Choisir un membre --', '-- Select a registered member --') }}</option>
                            @foreach($allUsers as $usr)
                                <option value="{{ $usr->id }}">{{ $usr->name }} ({{ $usr->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id_badge') <span class="text-rose-500 text-[11px] font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Role Title -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                            {{ $t('الدور والصفة المعتمدة للشارة *', 'Rôle Officiel du Badge *', 'Official Role Title *') }}
                        </label>
                        <select wire:model="role_title" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-black uppercase focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="COMPETITOR">COMPETITOR / مشارك متنافس</option>
                            <option value="EXPERT JUDGE">EXPERT JUDGE / حكم خبير</option>
                            <option value="DELEGATION HEAD">DELEGATION HEAD / رئيس وفد</option>
                            <option value="MEDIA">MEDIA / صحفي إعلامي</option>
                            <option value="VIP">VIP / ضيف شرف</option>
                            <option value="SPEAKER">SPEAKER / محاضر متحدث</option>
                            <option value="ORGANIZER">ORGANIZER / منظم</option>
                            <option value="VOLUNTEER">VOLUNTEER / متطوع</option>
                        </select>
                    </div>

                    <!-- Security Zones -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-2">
                            {{ $t('المناطق الأمنية المسموح بدخولها', 'Zones d\'Accès Autorisées', 'Allowed Security Zones') }}
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($zones as $z)
                                <label class="flex items-center gap-2 p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/60 dark:border-slate-700/60 text-slate-800 dark:text-slate-200 text-xs font-bold cursor-pointer hover:bg-slate-100 transition">
                                    <input type="checkbox" wire:model="selected_zones" value="{{ $z->id }}" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    <span class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $z->color_hex }};"></span>
                                    <span>{{ $z->code }}: {{ $z->name_ar }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Expiry Date -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                            {{ $t('تاريخ انتهاء الصلاحية (اختياري)', 'Date d\'expiration', 'Expiry Date') }}
                        </label>
                        <input wire:model="valid_until" type="date" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('formOpen', false)" class="px-5 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60 rounded-2xl transition cursor-pointer">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="issue" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-2xl shadow-md transition cursor-pointer">
                        {{ $t('إصدار شارة الاعتماد', 'Émettre le Badge', 'Issue Badge') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL: EDIT SECURITY ZONES FOR A USER --}}
    @if($editZonesOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-md shadow-2xl border border-slate-200 dark:border-slate-700 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">
                        {{ $t('تعديل المناطق الأمنية المسموحة', 'Modifier Zones d\'Accès', 'Edit Security Zones') }}
                    </h3>
                    <button wire:click="$set('editZonesOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-2">
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-bold">
                        {{ $t('حدد المناطق الأمني المصرح بدخول صاحب الشارة إليها:', 'Sélectionnez les zones d\'accès autorisées :', 'Select allowed security zones for this badge:') }}
                    </p>
                    <div class="space-y-2">
                        @foreach($zones as $z)
                            <label class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/60 dark:border-slate-700/60 text-slate-800 dark:text-slate-200 text-xs font-bold cursor-pointer hover:bg-slate-100 transition">
                                <input type="checkbox" wire:model="userEditingZoneIds" value="{{ $z->id }}" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span class="w-3.5 h-3.5 rounded-full shrink-0" style="background-color: {{ $z->color_hex }};"></span>
                                <span>{{ $z->code }}: {{ $z->name_ar }} ({{ $z->name_fr }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('editZonesOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60 rounded-xl cursor-pointer">إلغاء</button>
                    <button wire:click="saveUserZones" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md cursor-pointer">حفظ المناطق الأمنية</button>
                </div>
            </div>
        </div>
    @endif

</div>
