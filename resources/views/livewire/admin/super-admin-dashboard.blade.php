@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-8 pb-12">

    {{-- ═════════════════════════════════════════════════════════════════════
         1. HERO COMMAND HEADER (Royal Blue Executive Glass Banner)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-white/10">
        {{-- Ambient background light aura --}}
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                    {{ $t('مركز القيادة والتحكم الوطني — الإدارة العليا', 'Centre de Commandement National — Direction Générale', 'National Command & Control Center — Executive Board') }}
                </h1>
                <p class="text-xs sm:text-sm text-blue-100/90 font-medium max-w-2xl leading-relaxed">
                    {{ $t(
                        'متابعة فورية آنية للجاهزية الوطنية، إحصائيات الجداول حسب الاختصاص، أنظمة التحكيم CIS، والتحليلات البيانية والنسبية — أولمبياد المهن الجزائرية 2026.',
                        'Suivi en temps réel de la préparation nationale, des statistiques par domaine et du système CIS — WorldSkills Algeria 2026.',
                        'Real-time national monitoring, domain-specific analytics, CIS jury metrics, and visual distributions — WorldSkills Algeria 2026.'
                    ) }}
                </p>
            </div>

            {{-- Quick Action Hub --}}
            <div class="flex items-center gap-3 flex-wrap shrink-0">
                <a href="{{ route('admin.cms.homepage') }}" class="px-6 py-3.5 rounded-2xl bg-white text-[#0052CC] hover:bg-blue-50 font-black text-xs sm:text-sm shadow-xl hover:shadow-2xl transition-all duration-200 flex items-center gap-2.5 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                    <span>{{ $t('تخصيص وإدارة المنصة CMS', 'Gestionnaire CMS', 'CMS Manager') }}</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         2. HIGH-IMPACT KPI METRIC CARDS (4 Main Pillars)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div>
        <h2 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest mb-4 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[#0066FF]"></span>
            <span>{{ $t('المؤشرات والإحصائيات الرئيسية', 'Indicateurs de Performance', 'Key Performance Metrics') }}</span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- KPI 1: Accounts --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center border border-blue-100 dark:border-blue-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 text-[10px] font-black">
                        {{ $t('حسابات مفعلة', 'Comptes Actifs', 'Active Accounts') }}
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalUsers) }}</span>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-bold mt-1">{{ $t('إجمالي المسجلين والمستخدمين', 'Total Utilisateurs', 'Total Registered Accounts') }}</p>
                </div>
            </div>

            {{-- KPI 2: National Delegations & Wilayas --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-emerald-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm0 0h.01"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 text-[10px] font-black">
                        {{ $t('الجزائر 2026', 'Algérie 2026', 'Algeria 2026') }}
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalCountries) }}</span>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-bold mt-1">{{ $t('الوفود والولايات الوطنية', 'Délégations Nationales', 'National Delegations & Wilayas') }}</p>
                </div>
            </div>

            {{-- KPI 3: Skills --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center border border-purple-100 dark:border-purple-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-300 text-[10px] font-black">
                        {{ $t('معتمد WorldSkills', 'Agrée WSA', 'WSA Approved') }}
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalSkills) }}</span>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-bold mt-1">{{ $t('التخصصات والمهن الأولمبية', 'Compétences Olympiques', 'Official Olympic Skills') }}</p>
                </div>
            </div>

            {{-- KPI 4: Registrations --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center border border-amber-100 dark:border-amber-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300 text-[10px] font-black">
                        {{ $t('طلب جديد', 'Candidatures', 'Applications') }}
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalRegistrations) }}</span>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-bold mt-1">{{ $t('طلبات الترشح والتسجيلات', 'Demandes Inscription', 'Submitted Registrations') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         3. ADVANCED VISUAL CHARTS (دوائر نسبية وأعمدة بيانية متطورة من قاعدة البيانات)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#0052CC]"></span>
                <span>{{ $t('التحليلات المرئية المتقدمة: دوائر نسبية وأعمدة بيانية من قاعدة البيانات', 'Analyses Visuelles Avancées: Diagrammes Circulaires & Colonnes', 'Advanced Visual Analytics: Donut & Column Charts') }}</span>
            </h2>
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-700">
                تحديث حي وآني
            </span>
        </div>

        {{-- ROW 1: Donut Chart (دوائر نسبية) + Column Chart (أعمدة بيانية) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- 1. DONUT CHART: Users & Roles Breakdown (دائرة نسبية) --}}
            <div class="lg:col-span-5 bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700/80">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-900/40 text-[#0052CC] dark:text-blue-400 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white">توزيع الصلاحيات والحسابات</h3>
                                <p class="text-[11px] text-slate-500 font-bold">دائرة نسبية لتوزيع رتب المستخدمين الـ {{ $totalUsers }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-blue-50 dark:bg-blue-950/60 text-[#0052CC] dark:text-blue-400 text-[10px] font-black border border-blue-200/60 dark:border-blue-800">
                            نسبة مئوية
                        </span>
                    </div>

                    {{-- Chart Container --}}
                    <div class="pt-4 flex items-center justify-center min-h-[280px]">
                        <div id="rolesDonutChart" class="w-full flex items-center justify-center"></div>
                    </div>
                </div>

                {{-- Roles summary badges --}}
                <div class="pt-4 border-t border-slate-100 dark:border-slate-700/80 grid grid-cols-2 gap-2 text-xs font-bold">
                    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800">
                        <span class="text-slate-600 dark:text-slate-400 truncate">مسؤولو الوفود</span>
                        <span class="font-black text-[#0052CC] font-mono">60</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800">
                        <span class="text-slate-600 dark:text-slate-400 truncate">مسؤولون تنفيذيون</span>
                        <span class="font-black text-sky-500 font-mono">37</span>
                    </div>
                </div>
            </div>

            {{-- 2. COLUMN CHART: Skills Distribution by Sector (أعمدة بيانية) --}}
            <div class="lg:col-span-7 bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700/80">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white">توزيع المهن الأولمبية الـ {{ $totalSkills }} حسب القطاعات</h3>
                                <p class="text-[11px] text-slate-500 font-bold">أعمدة بيانية لتوزيع التخصصات المعتمدة عبر مجالات التكوين</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 text-[10px] font-black border border-emerald-200/60 dark:border-emerald-800">
                            64 تخصص رسمي
                        </span>
                    </div>

                    {{-- Chart Container --}}
                    <div class="pt-4 min-h-[280px]">
                        <div id="skillsBarChart" class="w-full"></div>
                    </div>
                </div>

                {{-- Key highlight --}}
                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/80 flex items-center justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400 font-bold">القطاع الرائد في عدد المهن:</span>
                    <span class="font-black text-[#0052CC] dark:text-sky-400 bg-blue-50 dark:bg-blue-900/40 px-3 py-1 rounded-full">التصنيع وتكنولوجيا الهندسة (23 مهنة)</span>
                </div>
            </div>

        </div>

        {{-- ROW 2: Top Wilayas Horizontal Bars + CIS Assessment Matrix --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- 3. HORIZONTAL BAR CHART: Top Wilayas by Organizations --}}
            <div class="lg:col-span-7 bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700/80">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white">كثافة المؤسسات التكوينية عبر الولايات</h3>
                                <p class="text-[11px] text-slate-500 font-bold">إحصائيات {{ number_format($totalOrganizations) }} مؤسسة تكوينية عبر {{ $totalWilayas }} ولاية</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-400 text-[10px] font-black border border-purple-200/60 dark:border-purple-800">
                            أعلى الولايات
                        </span>
                    </div>

                    {{-- Chart Container --}}
                    <div class="pt-4 min-h-[260px]">
                        <div id="wilayasBarChart" class="w-full"></div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/80 flex items-center justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400 font-bold">إجمالي شبكة التكوين والتعليم المهنيين:</span>
                    <span class="font-black text-purple-700 dark:text-purple-300 font-mono">1,987 مؤسسة ومركز وطني</span>
                </div>
            </div>

            {{-- 4. CIS ASSESSMENT & JURY INTEGRITY MATRIX --}}
            <div class="lg:col-span-5 bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700/80">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white">مصفوفة جاهزية التحكيم والنزاهة CIS</h3>
                                <p class="text-[11px] text-slate-500 font-bold">إحصائيات جداول التقييم والنزاهة الرقمية</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 text-[10px] font-black border border-amber-200/60 dark:border-amber-800">
                            معايير رسمية
                        </span>
                    </div>

                    {{-- 4 Live Stat Capsules --}}
                    <div class="grid grid-cols-2 gap-3 pt-4">
                        <div class="p-4 rounded-2xl bg-blue-50/50 dark:bg-blue-950/30 border border-blue-100 dark:border-blue-900/50 flex flex-col justify-between">
                            <span class="text-[11px] font-bold text-blue-700 dark:text-blue-300">معايير التقييم CIS</span>
                            <span class="text-2xl sm:text-3xl font-black text-[#0052CC] font-mono mt-2">{{ number_format($cisCriteriaCount) }}</span>
                            <span class="text-[10px] text-slate-500 font-bold mt-0.5">معيار معتمد وموثق</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/30 border border-emerald-100 dark:border-emerald-900/50 flex flex-col justify-between">
                            <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-300">وحدات الاختبار الميداني</span>
                            <span class="text-2xl sm:text-3xl font-black text-emerald-600 font-mono mt-2">{{ number_format($cisModulesCount) }}</span>
                            <span class="text-[10px] text-slate-500 font-bold mt-0.5">وحدة تقييم CIS</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-purple-50/50 dark:bg-purple-950/30 border border-purple-100 dark:border-purple-900/50 flex flex-col justify-between">
                            <span class="text-[11px] font-bold text-purple-700 dark:text-purple-300">سجلات الرقابة والنزاهة</span>
                            <span class="text-2xl sm:text-3xl font-black text-purple-600 font-mono mt-2">{{ number_format($auditLogsCount) }}</span>
                            <span class="text-[10px] text-slate-500 font-bold mt-0.5">سجل أمان مشفر</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-amber-50/50 dark:bg-amber-950/30 border border-amber-100 dark:border-amber-900/50 flex flex-col justify-between">
                            <span class="text-[11px] font-bold text-amber-700 dark:text-amber-300">تراخيص الدخول الميداني</span>
                            <span class="text-2xl sm:text-3xl font-black text-amber-600 font-mono mt-2">{{ number_format($accessDecisionsCount) }}</span>
                            <span class="text-[10px] text-slate-500 font-bold mt-0.5">قرار اعتماد ودخول</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-700/80 flex items-center justify-between text-xs">
                    <span class="text-slate-500 dark:text-slate-400 font-bold">مستوى الجاهزية لنظام التحكيم:</span>
                    <span class="font-black text-emerald-600 bg-emerald-50 dark:bg-emerald-950/60 px-3 py-1 rounded-full">100% مكتمل ومعتمد</span>
                </div>
            </div>

        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         4. DATABASE TABLES SPECIALTY HUBS (إحصائيات الجداول حسب كل اختصاص)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="space-y-4">
        <h2 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[#0066FF]"></span>
            <span>{{ $t('مراكز الإدارة والتحكم التنفيذية: إحصائيات الجداول حسب الاختصاص', 'Centres de Commandement par Spécialité', 'Executive Control Hubs by Domain') }}</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- HUB 1: Operations, Schedule & Logistics --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs space-y-4 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold border border-blue-100 dark:border-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="text-xs font-black text-blue-600 bg-blue-50 dark:bg-blue-950/60 px-2.5 py-1 rounded-full">3 جداول</span>
                    </div>
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">1. العمليات والجدولة والميدان</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                        محرك الجدولة، قاعات اللقاءات، ومخطط القرية الأولمبية.
                    </p>

                    <div class="space-y-1.5 pt-2 text-xs font-bold text-slate-600 dark:text-slate-400">
                        <div class="flex justify-between"><span>جدول الفعاليات والجدولة:</span><span class="font-black text-slate-900 dark:text-white font-mono">2</span></div>
                        <div class="flex justify-between"><span>غرف اللقاءات الدبلوماسية:</span><span class="font-black text-slate-900 dark:text-white font-mono">3</span></div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/80 space-y-2">
                    <a href="{{ route('admin.operations') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 transition">← محرك الجدولة والعمليات</a>
                    <a href="{{ route('admin.operations') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 transition">← العمليات المباشرة بالأرضية</a>
                </div>
            </div>

            {{-- HUB 2: Registrations, Delegations & Competitors --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs space-y-4 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold border border-emerald-100 dark:border-emerald-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="text-xs font-black text-emerald-600 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-1 rounded-full">4 جداول</span>
                    </div>
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">2. التسجيلات والوفود والمتنافسين</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                        ملفات المترشحين، قوائم الوفود، وتأكيدات الوصول اللوجستي.
                    </p>

                    <div class="space-y-1.5 pt-2 text-xs font-bold text-slate-600 dark:text-slate-400">
                        <div class="flex justify-between"><span>طلبات الترشح الرسمية:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ $totalRegistrations }}</span></div>
                        <div class="flex justify-between"><span>الوفود الوطنية والولايات:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ $totalCountries }}</span></div>
                        <div class="flex justify-between"><span>أعضاء الوفود المعتمدون:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ $delegationMembersCount }}</span></div>
                        <div class="flex justify-between"><span>تأكيدات الوصول المسجلة:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ $arrivalsCount }}</span></div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/80 space-y-2">
                    <a href="{{ route('admin.registrations') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 transition">← إدارة كافة التسجيلات ({{ $totalRegistrations }})</a>
                    <a href="{{ route('admin.countries') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 transition">← الوفود والولايات الوطنية ({{ $totalCountries }})</a>
                </div>
            </div>

            {{-- HUB 3: Jury, CIS & Integrity --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs space-y-4 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-2xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold border border-purple-100 dark:border-purple-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <span class="text-xs font-black text-purple-600 bg-purple-50 dark:bg-purple-950/60 px-2.5 py-1 rounded-full">4 جداول</span>
                    </div>
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">3. التحكيم والنزاهة ونظام CIS</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                        معايير التقييم، وحدات الاختبار CIS، وسجلات الرقابة.
                    </p>

                    <div class="space-y-1.5 pt-2 text-xs font-bold text-slate-600 dark:text-slate-400">
                        <div class="flex justify-between"><span>معايير التقييم CIS:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ number_format($cisCriteriaCount) }}</span></div>
                        <div class="flex justify-between"><span>وحدات الاختبار CIS:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ number_format($cisModulesCount) }}</span></div>
                        <div class="flex justify-between"><span>سجلات التدقيق الأمني:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ $auditLogsCount }}</span></div>
                        <div class="flex justify-between"><span>شارات الاعتماد الممنوحة:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ $badgesCount }}</span></div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/80 space-y-2">
                    <a href="{{ route('admin.skills') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200 hover:bg-purple-50 dark:hover:bg-slate-700 hover:text-purple-600 transition">← التخصصات ومعايير CIS</a>
                    <a href="{{ route('admin.users') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200 hover:bg-purple-50 dark:hover:bg-slate-700 hover:text-purple-600 transition">← سجلات المستخدمين والأمان</a>
                </div>
            </div>

            {{-- HUB 4: Content, Media & Partners --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs space-y-4 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold border border-amber-100 dark:border-amber-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-xs font-black text-amber-600 bg-amber-50 dark:bg-amber-950/60 px-2.5 py-1 rounded-full">4 جداول</span>
                    </div>
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">4. المحتوى والإعلام والشركاء</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                        المكتبة المرئية، الرعاة الرسميون، ومقالات المنصة العامة.
                    </p>

                    <div class="space-y-1.5 pt-2 text-xs font-bold text-slate-600 dark:text-slate-400">
                        <div class="flex justify-between"><span>الفيديوهات والتوثيق المرئي:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ $videosCount }}</span></div>
                        <div class="flex justify-between"><span>مكتبة الصور والألبومات:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ $albumsCount }} ألبومات ({{ $mediaCount }} صورة)</span></div>
                        <div class="flex justify-between"><span>الشركاء والرعاة المعتمدون:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ $partnersCount }}</span></div>
                        <div class="flex justify-between"><span>المقالات الإخبارية المنشورة:</span><span class="font-black text-slate-900 dark:text-white font-mono">{{ $newsArticlesCount }}</span></div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/80 space-y-2">
                    <a href="{{ route('admin.media.dashboard') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200 hover:bg-amber-50 dark:hover:bg-slate-700 hover:text-amber-600 transition">← مركز الوسائط والإعلام</a>
                    <a href="{{ route('admin.cms.homepage') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-800 dark:text-slate-200 hover:bg-amber-50 dark:hover:bg-slate-700 hover:text-amber-600 transition">← تخصيص البوابة الرسمية CMS</a>
                </div>
            </div>

        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         5. RECENT ACTIVITY DATA TABLES (جداول البيانات الحية الحديثة)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Table 1: Recent Registrations --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">أحدث طلبات الترشح والتسجيل</h3>
                </div>
                <a href="{{ route('admin.registrations') }}" class="text-xs font-bold text-[#0052CC] hover:underline">عرض الكل ({{ $totalRegistrations }})</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-start">
                    <thead>
                        <tr class="text-slate-400 dark:text-slate-500 border-b border-slate-100 dark:border-slate-700 text-[11px]">
                            <th class="pb-2 font-bold text-start">المترشح</th>
                            <th class="pb-2 font-bold text-start">التخصص الأولمبي</th>
                            <th class="pb-2 font-bold text-start">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                        @forelse($recentRegistrations as $reg)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
                                <td class="py-3 font-black text-slate-900 dark:text-white">
                                    {{ $reg->user?->name ?? 'مترشح وطني' }}
                                </td>
                                <td class="py-3 font-bold text-slate-600 dark:text-slate-300">
                                    {{ $reg->skill?->getLocalized('name') ?? 'تخصص أولمبي' }}
                                </td>
                                <td class="py-3">
                                    @if($reg->status === 'APPROVED')
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black">معتمد</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-black">قيد المراجعة</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-slate-400 font-bold">لا توجد طلبات مسجلة حديثاً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Table 2: Recent Users --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">أحدث المستخدمين بالمنصة</h3>
                </div>
                <a href="{{ route('admin.users') }}" class="text-xs font-bold text-[#0052CC] hover:underline">إدارة المستخدمين ({{ $totalUsers }})</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-start">
                    <thead>
                        <tr class="text-slate-400 dark:text-slate-500 border-b border-slate-100 dark:border-slate-700 text-[11px]">
                            <th class="pb-2 font-bold text-start">الاسم الكامل</th>
                            <th class="pb-2 font-bold text-start">البريد الإلكتروني</th>
                            <th class="pb-2 font-bold text-start">الرتبة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                        @forelse($recentUsers as $u)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
                                <td class="py-3 font-black text-slate-900 dark:text-white flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-[#06205C] text-white flex items-center justify-center font-bold text-[10px] shrink-0">
                                        {{ mb_substr($u->name, 0, 1) }}
                                    </div>
                                    <span class="truncate max-w-[140px]">{{ $u->name }}</span>
                                </td>
                                <td class="py-3 font-mono text-[11px] text-slate-500 dark:text-slate-400 truncate max-w-[160px]">
                                    {{ $u->email }}
                                </td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded-full bg-blue-50 dark:bg-blue-900/40 text-[#0052CC] dark:text-blue-400 text-[10px] font-black">
                                        {{ $u->roles->first()?->name ?? 'USER' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-slate-400 font-bold">لا يوجد مستخدمون جدد</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

{{-- ═════════════════════════════════════════════════════════════════════
     6. APEXCHARTS INITIALIZATION JAVASCRIPT ENGINE
═════════════════════════════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts === 'undefined') {
        console.warn('ApexCharts library not loaded yet');
        return;
    }

    const isRtl = document.dir === 'rtl';

    // ── 1. ROLES DONUT CHART (دوائر نسبية) ──
    const rolesData = @json($roleSeries);
    const rolesLabels = @json($roleLabels);

    const rolesOptions = {
        series: rolesData,
        labels: rolesLabels,
        chart: {
            type: 'donut',
            height: 280,
            fontFamily: 'Cairo, Outfit, sans-serif',
            toolbar: { show: false }
        },
        colors: ['#0052CC', '#00B8FF', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444'],
        plotOptions: {
            pie: {
                donut: {
                    size: '72%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'إجمالي الحسابات',
                            fontFamily: 'Cairo, sans-serif',
                            fontWeight: 900,
                            color: '#06205C',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        legend: {
            position: 'bottom',
            fontFamily: 'Cairo, sans-serif',
            fontWeight: 700,
            fontSize: '11px',
            markers: { radius: 12 }
        },
        stroke: { width: 2, colors: ['#ffffff'] },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + ' مستخدم معتمد';
                }
            }
        }
    };

    const rolesChartEl = document.querySelector("#rolesDonutChart");
    if (rolesChartEl) {
        const rolesChart = new ApexCharts(rolesChartEl, rolesOptions);
        rolesChart.render();
    }

    // ── 2. SKILLS COLUMN/BAR CHART (أعمدة بيانية) ──
    const skillsData = @json($skillSeries);
    const skillsLabels = @json($skillLabels);

    const skillsOptions = {
        series: [{
            name: 'عدد المهن والتخصصات',
            data: skillsData
        }],
        chart: {
            type: 'bar',
            height: 280,
            fontFamily: 'Cairo, Outfit, sans-serif',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '45%',
                distributed: true,
                dataLabels: { position: 'top' }
            }
        },
        colors: ['#0052CC', '#0077FF', '#0099FF', '#00B8FF', '#10B981', '#8B5CF6'],
        dataLabels: {
            enabled: true,
            formatter: function (val) { return val; },
            offsetY: -20,
            style: {
                fontSize: '11px',
                fontFamily: 'Outfit, sans-serif',
                fontWeight: 900,
                colors: ['#06205C']
            }
        },
        legend: { show: false },
        xaxis: {
            categories: skillsLabels,
            labels: {
                rotate: -25,
                style: {
                    fontSize: '10px',
                    fontFamily: 'Cairo, sans-serif',
                    fontWeight: 700
                }
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            title: { text: 'عدد المهن', style: { fontFamily: 'Cairo, sans-serif', fontWeight: 700 } }
        },
        grid: {
            borderColor: '#F1F5F9',
            strokeDashArray: 4
        }
    };

    const skillsChartEl = document.querySelector("#skillsBarChart");
    if (skillsChartEl) {
        const skillsChart = new ApexCharts(skillsChartEl, skillsOptions);
        skillsChart.render();
    }

    // ── 3. TOP WILAYAS HORIZONTAL BAR CHART ──
    const wilayasData = @json($wilayaSeries);
    const wilayasLabels = @json($wilayaLabels);

    const wilayasOptions = {
        series: [{
            name: 'المؤسسات التكوينية',
            data: wilayasData
        }],
        chart: {
            type: 'bar',
            height: 260,
            fontFamily: 'Cairo, Outfit, sans-serif',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                borderRadius: 6,
                barHeight: '55%',
                distributed: false
            }
        },
        colors: ['#0052CC'],
        dataLabels: {
            enabled: true,
            formatter: function (val) { return val + ' مؤسسة'; },
            style: {
                fontSize: '10px',
                fontFamily: 'Cairo, sans-serif',
                fontWeight: 900
            }
        },
        xaxis: {
            categories: wilayasLabels,
            labels: { style: { fontFamily: 'Cairo, sans-serif', fontWeight: 700 } }
        },
        yaxis: {
            labels: { style: { fontFamily: 'Cairo, sans-serif', fontWeight: 800, fontSize: '11px' } }
        },
        grid: {
            borderColor: '#F1F5F9',
            strokeDashArray: 4
        }
    };

    const wilayasChartEl = document.querySelector("#wilayasBarChart");
    if (wilayasChartEl) {
        const wilayasChart = new ApexCharts(wilayasChartEl, wilayasOptions);
        wilayasChart.render();
    }
});
</script>
