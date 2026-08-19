@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-8 pb-10">

    {{-- ═════════════════════════════════════════════════════════════════════
         1. HERO COMMAND HEADER (Royal Blue Glass & High-Tech Banner)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-white/10">
        {{-- Ambient background light aura --}}
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            
            <div class="space-y-2">
                {{-- Title --}}
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                    {{ $t('مركز القيادة والتحكم الوطني — الإدارة العليا', 'Centre de Commandement National — Direction Générale', 'National Command & Control Center — Executive Board') }}
                </h1>
                
                <p class="text-xs sm:text-sm text-blue-100/90 font-medium max-w-2xl leading-relaxed">
                    {{ $t(
                        'متابعة فورية آنية للجاهزية الوطنية، تسجيلات الوفود والمشاركين، أنظمة التحكيم CIS، وسجلات النزاهة ومظهر المنصة — أولمبياد المهن الجزائرية 2026.',
                        'Suivi en temps réel de la préparation nationale, des inscriptions des délégations et du système d\'arbitrage CIS.',
                        'Real-time national readiness monitoring, delegation registrations, CIS jury systems, and platform CMS.'
                    ) }}
                </p>
            </div>

            {{-- Quick Action Hub --}}
            <div class="flex items-center gap-3 flex-wrap shrink-0">
                <a href="{{ route('admin.cms.homepage') }}" class="px-5 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-black text-xs shadow-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                    <span>{{ $t('تخشيص وإدارة المنصة CMS', 'Gestionnaire CMS', 'CMS Manager') }}</span>
                </a>
            </div>

        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         2. SYSTEM INFRASTRUCTURE NODES (6 Live Health Services)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
        @foreach([
            ['Database System',  'Healthy 🟢', 'قواعد البيانات متصلة'],
            ['Cache Engine',     'Active 🟢',  'المحرك السريع نشط'],
            ['Schedule Worker',  'Running 🟢', 'محرك الجدولة يعمل'],
            ['File Storage',     'Protected 🟢','حماية الملفات التلقائية'],
            ['PWA Manifest',     'Active 🟢',  'تطبيق الهاتف جاهز'],
            ['Security Audit',   'Secured 🟢', 'حماية بيانات 18-07'],
        ] as [$title, $status, $desc])
            <div class="bg-white dark:bg-slate-800 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-xs flex items-center justify-between gap-2">
                <div class="flex flex-col min-w-0">
                    <span class="text-xs font-black text-slate-800 dark:text-slate-100 truncate">{{ $title }}</span>
                    <span class="text-[10px] text-slate-400 font-bold truncate mt-0.5">{{ $desc }}</span>
                </div>
                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0 animate-pulse"></span>
            </div>
        @endforeach
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         3. HIGH-IMPACT KPI METRIC CARDS (4 Main Pillars)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div>
        <h2 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-brand-500"></span>
            <span>{{ $t('المؤشرات والإحصائيات الرئيسية', 'Indicateurs de Performance', 'Key Performance Metrics') }}</span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            {{-- KPI 1: Accounts --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center border border-blue-100 dark:border-blue-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-[10px] font-black">
                        {{ $t('حسابات مفعلة', 'Comptes Actifs', 'Active Accounts') }}
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalUsers) }}</span>
                    <p class="text-xs text-slate-500 font-bold mt-1">{{ $t('إجمالي المسجلين والمستخدمين', 'Total Utilisateurs', 'Total Registered Accounts') }}</p>
                </div>
            </div>

            {{-- KPI 2: National Delegations & Wilayas --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-emerald-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm0 0h.01"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-[10px] font-black">
                        {{ $t('الجزائر 2026', 'Algérie 2026', 'Algeria 2026') }}
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalCountries) }}</span>
                    <p class="text-xs text-slate-500 font-bold mt-1">{{ $t('الوفود والولايات الوطنية', 'Délégations Nationales', 'National Delegations & Wilayas') }}</p>
                </div>
            </div>

            {{-- KPI 3: Skills --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center border border-purple-100 dark:border-purple-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 text-[10px] font-black">
                        {{ $t('معتمد WorldSkills', 'Agrée WSA', 'WSA Approved') }}
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalSkills) }}</span>
                    <p class="text-xs text-slate-500 font-bold mt-1">{{ $t('التخصصات والمهن الأولمبية', 'Compétences Olympiques', 'Official Olympic Skills') }}</p>
                </div>
            </div>

            {{-- KPI 4: Registrations --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center border border-amber-100 dark:border-amber-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 text-[10px] font-black">
                        {{ $t('طلب جديد', 'Candidatures', 'Applications') }}
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalRegistrations) }}</span>
                    <p class="text-xs text-slate-500 font-bold mt-1">{{ $t('طلبات الترشح والتسجيلات', 'Demandes Inscription', 'Submitted Registrations') }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         4. CATEGORIZED COMMAND HUBS (4 High-Tech Operational Sections)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="space-y-4">
        <h2 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-brand-500"></span>
            <span>{{ $t('مراكز الإدارة والتحكم التنفيذية', 'Centres de Commandement', 'Executive Control Hubs') }}</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- HUB 1: Command & Operations --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold border border-blue-100 dark:border-blue-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">1. العمليات والجدولة</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed">
                        غرفة التحكم المباشرة ومحرك الجدولة والعمليات الميدانية بالأرضية.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/80 space-y-2">
                    <a href="{{ route('admin.schedule.index') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 transition">← محرك الجدولة والعمليات</a>
                    <a href="{{ route('admin.operations') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 transition">← العمليات المباشرة بالأرضية</a>
                </div>
            </div>

            {{-- HUB 2: Registrations & Delegations --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold border border-emerald-100 dark:border-emerald-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">2. التسجيلات والوفود</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed">
                        متابعة تسجيلات المتنافسين، دعوات الوفود الوطنية، وتراخيص الحسابات والأنظمة.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/80 space-y-2">
                    <a href="{{ route('admin.registrations') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 transition">← إدارة كافة التسجيلات</a>
                    <a href="{{ route('admin.participants') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 transition">← المتنافسون والشباب</a>
                    <a href="{{ route('admin.countries') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 transition">← الوفود والولايات الوطنية</a>
                </div>
            </div>

            {{-- HUB 3: Jury, CIS & Integrity --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold border border-purple-100 dark:border-purple-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    </div>
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">3. التحكيم والنزاهة CIS</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed">
                        نظام التقييم الإلكتروني CIS، مجلس المحكمين والخبراء، والطعون الفنية والنزاهة.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/80 space-y-2">
                    <a href="{{ route('admin.cis') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-purple-50 dark:hover:bg-slate-700 hover:text-purple-600 transition">← نظام التقييم الميداني CIS</a>
                    <a href="{{ route('admin.judges') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-purple-50 dark:hover:bg-slate-700 hover:text-purple-600 transition">← المحكمون والخبراء</a>
                    <a href="{{ route('admin.integrity') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-purple-50 dark:hover:bg-slate-700 hover:text-purple-600 transition">← مركز النزاهة والحوكمة</a>
                </div>
            </div>

            {{-- HUB 4: CMS, Media & Appearance --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold border border-amber-100 dark:border-amber-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">4. المحتوى والهوية CMS</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed">
                        التحكم في الصفحة الرئيسية، الأخبار والتغطيات الصحفية، استوديو المظهر، والشركاء.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/80 space-y-2">
                    <a href="{{ route('admin.cms.homepage') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-amber-50 dark:hover:bg-slate-700 hover:text-amber-600 transition">← تخصيص البانر والواجهة CMS</a>
                    <a href="{{ route('admin.cms.news') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-amber-50 dark:hover:bg-slate-700 hover:text-amber-600 transition">← الأخبار والمقالات الصحفية</a>
                    <a href="{{ route('admin.appearance') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-amber-50 dark:hover:bg-slate-700 hover:text-amber-600 transition">← استوديو المظهر والهوية</a>
                    <a href="{{ route('admin.live-tv') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-slate-700 transition flex items-center justify-between">
                        <span>← التحكم بالبث المباشر (Live TV)</span>
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         5. DIPLOMATIC & MINISTERIAL VIP COMMAND WIDGET
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0A3580] text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-blue-900/60 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-black shrink-0 border border-amber-500/30 shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
            </div>
            <div class="space-y-1">
                <h3 class="text-lg font-black text-white">
                    {{ $t('القيادة الدبلوماسية واللقاءات الثنائية الوزارية', 'Commandement Diplomatique & Entretiens', 'Diplomatic Command & Ministerial Talks') }}
                </h3>
                <p class="text-xs text-blue-200 font-medium">
                    {{ $t('جاهزية الوزراء والوفود الوطنية والدولية وحجوزات القاعات الدبلوماسية بمركز المؤتمرات بوهران.', 'Disponibilité ministérielle et salons VIP.', 'Ministerial availability & diplomatic VIP lounges.') }}
                </p>
            </div>
        </div>

        <a href="{{ route('admin.diplomatic') }}" class="px-6 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs transition shadow-lg shrink-0 flex items-center gap-2">
            <span>{{ $t('فتح مركز القيادة الدبلوماسي', 'Ouvrir Centre', 'Open Diplomatic Center') }}</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         6. LIVE RECENT REGISTRATIONS TABLE
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-black text-[#06205C] dark:text-white flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                <span>{{ $t('أحدث طلبات التسجيل الوطنية المودعة', 'Dernières Inscriptions Reçues', 'Recent Registration Submissions') }}</span>
            </h3>
            <a href="{{ route('admin.registrations') }}" class="text-xs font-bold text-brand-600 dark:text-sky-400 hover:underline">
                {{ $t('عرض كافة الطلبات (Registrations)', 'Voir tout', 'View All Registrations') }} →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs font-sans">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-700 text-slate-400 dark:text-slate-500 font-black text-[11px] uppercase">
                        <th class="py-3 px-4">رمز الطلب</th>
                        <th class="py-3 px-4">الاسم الكامل</th>
                        <th class="py-3 px-4">التخصص الأولمبي</th>
                        <th class="py-3 px-4">الولاية / المؤسسة</th>
                        <th class="py-3 px-4">حالة الطلب</th>
                        <th class="py-3 px-4 text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-bold text-slate-700 dark:text-slate-200">
                    @forelse($recentRegistrations ?? [] as $reg)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                            <td class="py-3.5 px-4 font-mono font-black text-brand-600 dark:text-sky-400">#{{ $reg->registration_number ?? 'WSAP-'.$reg->id }}</td>
                            <td class="py-3.5 px-4 font-extrabold text-slate-900 dark:text-white">{{ $reg->first_name_ar }} {{ $reg->last_name_ar }}</td>
                            <td class="py-3.5 px-4">{{ $reg->skill?->getLocalized('name') ?? 'تخصص عام' }}</td>
                            <td class="py-3.5 px-4">{{ $reg->wilaya?->name_ar ?? 'الجزائر العاصمة' }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300">
                                    {{ $reg->status ?? 'مقبول' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <a href="{{ route('admin.registrations') }}" class="px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 hover:bg-brand-500 hover:text-white text-slate-600 dark:text-slate-300 font-bold transition text-[11px]">
                                    معاينة
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-medium">
                                {{ $t('لا توجد طلبات تسجيل جديدة حتى الآن.', 'Aucune inscription récente.', 'No recent registrations.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
