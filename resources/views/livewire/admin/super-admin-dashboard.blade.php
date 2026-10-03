@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
$user = auth()->user();

$malePercent = ($maleCandidatesCount + $femaleCandidatesCount) > 0 
    ? round(($maleCandidatesCount / ($maleCandidatesCount + $femaleCandidatesCount)) * 100) 
    : 50;
$femalePercent = 100 - $malePercent;
@endphp

<div class="space-y-8 pb-12">

    {{-- ═════════════════════════════════════════════════════════════════════
         1. ROYAL DARK EXECUTIVE HEADER (Solid Dark Obsidian Banner)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-slate-950 text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-slate-800">
        {{-- Ambient background light aura --}}
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/80 border border-blue-800/60 text-xs font-mono font-bold text-amber-400">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span>WORLDSKILLS ALGERIA 2026</span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    أولمبياد المهن
                </h1>
                <p class="text-sm sm:text-base text-slate-300 font-bold">
                    مرحباً بك، <span class="text-amber-400 font-black">{{ $user?->name ?? 'المسؤول المحترم' }}</span>
                </p>
            </div>

            {{-- Quick Action Hub --}}
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('admin.cms.homepage') }}" class="px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-black text-xs sm:text-sm shadow-xl hover:shadow-2xl transition duration-200 flex items-center gap-2 border border-blue-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                    <span>تخصيص وإدارة المنصة CMS</span>
                </a>
            </div>
        </div>
    </div>

    
    {{-- ═════════════════════════════════════════════════════════════════════
         NATIONAL FINALISTS EXPORT & LIST MANAGEMENT (استخراج وتصدير القائمة الرسمية)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-emerald-950 via-teal-950 to-slate-950 rounded-3xl p-6 sm:p-7 shadow-2xl border-2 border-emerald-500/50 relative overflow-hidden text-white">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs font-black">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>القائمة الرسمية المعتمدة للنهائي الوطني (536 متنافس)</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-white">
                    قائمة المتأهلين للنهائيات الوطنية WorldSkills Algeria 2026
                </h3>
                <p class="text-xs sm:text-sm text-emerald-100/90 font-medium">
                    استخراج وتحميل القوائم الاسمية الرسمية للمتنافسين مصنفة ومؤشرة حسب الولايات والمؤسسات التكوينية والتخصصات مع ترويسة الجمهورية الجزائرية.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Excel Export Button --}}
                <button wire:click="exportExcel" type="button" class="px-5 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs sm:text-sm shadow-xl hover:shadow-2xl transition duration-200 flex items-center gap-2.5 border border-emerald-300 cursor-pointer">
                    <svg class="w-5 h-5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>تصدير قائمة النهائي الوطني (Excel)</span>
                </button>

                {{-- PDF Print Button --}}
                <button wire:click="exportPdf" type="button" class="px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-black text-xs sm:text-sm shadow-xl hover:shadow-2xl transition duration-200 flex items-center gap-2.5 border border-blue-400/40 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>طباعة القائمة الرسمية (PDF)</span>
                </button>

                {{-- View All Participants --}}
                <a href="{{ route('admin.participants') }}" class="px-5 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs sm:text-sm shadow transition flex items-center gap-2 border border-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>إدارة المتنافسين</span>
                </a>
            </div>
        </div>
    </div>


    {{-- ═════════════════════════════════════════════════════════════════════
         2. CORE STATISTICAL KPI METRICS (الحسابات، طلبات الترشح، الجنس)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div>
        <h2 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest mb-4 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
            <span>المؤشرات والإحصائيات الشاملة للنظام</span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            {{-- Pillar 1: Users & Accounts --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center border border-blue-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 text-[10px] font-black">
                        المستخدمين والحسابات
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">{{ number_format($totalUsers) }}</span>
                    <p class="text-xs text-slate-500 font-bold mt-1">إجمالي الحسابات المسجلة بالنظام</p>
                </div>
                <div class="pt-2 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs font-bold">
                    <span class="text-emerald-600 font-black">مفعلة: {{ number_format($activeUsersCount) }}</span>
                    <span class="text-rose-500 font-black">غير مفعلة: {{ number_format($inactiveUsersCount) }}</span>
                </div>
            </div>

            {{-- Pillar 2: Candidate Applications & Registrations --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 text-[10px] font-black">
                        طلبات الترشح
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">{{ number_format($totalRegistrations) }}</span>
                    <p class="text-xs text-slate-500 font-bold mt-1">إجمالي الملفات والترشيحات المقدمة</p>
                </div>
                <div class="pt-2 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-[11px] font-bold">
                    <span class="text-emerald-600 font-black">مقبول: {{ number_format($approvedRegistrations) }}</span>
                    <span class="text-amber-600 font-black">انتظار: {{ number_format($pendingRegistrations) }}</span>
                    <span class="text-rose-600 font-black">مرفوض: {{ number_format($rejectedRegistrations) }}</span>
                </div>
            </div>

            {{-- Pillar 3: Gender Demographics (الذكور والإناث) --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center border border-indigo-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-800 dark:text-indigo-300 text-[10px] font-black">
                        التوزيع حسب الجنس
                    </span>
                </div>
                <div>
                    <div class="flex items-center justify-between text-xs font-black text-slate-900 dark:text-white mb-1.5">
                        <span>ذكور: {{ number_format($maleCandidatesCount) }} ({{ $malePercent }}%)</span>
                        <span>إناث: {{ number_format($femaleCandidatesCount) }} ({{ $femalePercent }}%)</span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden flex">
                        <div class="bg-blue-600 h-full" style="width: {{ $malePercent }}%"></div>
                        <div class="bg-pink-500 h-full" style="width: {{ $femalePercent }}%"></div>
                    </div>
                </div>
                <p class="text-[11px] text-slate-500 font-bold pt-1">نسبة التكافئ والمشاركة للنوع التنافسي</p>
            </div>

            {{-- Pillar 4: Skills & Specialties --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center border border-amber-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.187-2.19l.732-4.393A2 2 0 017.11 6.814l3.176.635a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.642 1.964v6.22a2 2 0 01-.927 1.69z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300 text-[10px] font-black">
                        التخصصات الأولمبية
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">{{ number_format($totalSkills) }}</span>
                    <p class="text-xs text-slate-500 font-bold mt-1">تخصص مهني معتمد في المنافسة</p>
                </div>
                <div class="pt-2 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs font-bold">
                    <span class="text-emerald-600 font-black">التخصصات النشطة: {{ number_format($activeSkillsCount) }}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         3. APEXCHARTS VISUAL ANALYTICS (دوائر نسبية، أعمدة بيانية ومخططات)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div>
        <h2 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest mb-4 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
            <span>الرسومات البيانية والمخططات النسبية (Interactive Analytics Charts)</span>
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Chart 1: User Roles Distribution Donut Chart (دائرة نسبية لأدوار المستخدمين) --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">توزيع حسابات المستخدمين حسب الأدوار</h3>
                        <p class="text-xs text-slate-500 font-bold mt-0.5">مخطط دائري نسبي (Donut Chart) للأدوار والمسؤوليات</p>
                    </div>
                </div>
                <div id="rolesDonutChart" class="w-full min-h-[300px]"></div>
            </div>

            {{-- Chart 2: Registration Status Pie Chart (دائرة نسبية لحالة الترشحات) --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">النسب المئوية لحالة طلبات الترشح</h3>
                        <p class="text-xs text-slate-500 font-bold mt-0.5">مخطط دائري (Pie Chart) للقبول والرفض والانتظار</p>
                    </div>
                </div>
                <div id="statusPieChart" class="w-full min-h-[300px]"></div>
            </div>

            {{-- Chart 3: Sector Skills & Candidates Bar Chart (أعمدة بيانية للقطاعات) --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">إحصائية المهن والمسجلين حسب القطاعات</h3>
                        <p class="text-xs text-slate-500 font-bold mt-0.5">أعمدة بيانية (Column Bar Chart) للقطاعات الـ 6</p>
                    </div>
                </div>
                <div id="sectorBarChart" class="w-full min-h-[300px]"></div>
            </div>

            {{-- Chart 4: Top Wilayas Participation Horizontal Bar Chart (مخطط أفقي للولايات) --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">التوزيع الجغرافي للولايات الأكثر مشاركة</h3>
                        <p class="text-xs text-slate-500 font-bold mt-0.5">مخطط أفقي (Horizontal Bar Chart) لترتيب الولايات</p>
                    </div>
                </div>
                <div id="wilayaBarChart" class="w-full min-h-[300px]"></div>
            </div>

        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         4. DETAILED ANALYTICS TABLES & CARDS
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Column 1 & 2: Top Skills List & Sector Details --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Top Requested Skills List --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">التخصصات الأكثر إقبالاً وطلباً</h3>
                        <p class="text-xs text-slate-500 font-bold mt-0.5">ترتيب التخصصات حسب أعداد المسجلين والمقبولين رسمياً</p>
                    </div>
                    <a href="{{ route('admin.skills') }}" class="text-xs font-black text-blue-600 hover:underline">عرض كل التخصصات ←</a>
                </div>

                <div class="space-y-3">
                    @forelse($topSkills as $sk)
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 flex items-center justify-center font-mono font-black text-xs shrink-0">
                                    {{ $sk->code }}
                                </div>
                                <div class="truncate">
                                    <h4 class="text-xs font-black text-slate-900 dark:text-white truncate">{{ $sk->getLocalized('name') }}</h4>
                                    <span class="text-[10px] font-bold text-slate-500">{{ $sk->category?->getLocalized('name') ?? 'قطاع عام' }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 shrink-0 text-xs font-bold text-right">
                                <div>
                                    <span class="block text-slate-900 dark:text-white font-black">{{ number_format($sk->registrations_count) }}</span>
                                    <span class="text-[10px] text-slate-400">مسجل</span>
                                </div>
                                <div>
                                    <span class="block text-emerald-600 font-black">{{ number_format($sk->approved_count) }}</span>
                                    <span class="text-[10px] text-emerald-500">مقبول</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs font-bold text-slate-500 text-center py-4">لا توجد بيانات تخصصات مسجلة حتى الآن.</p>
                    @endforelse
                </div>
            </div>

            {{-- Sector Details Grid --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="pb-3 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">تفاصيل المهن والمسجلين حسب القطاعات</h3>
                    <p class="text-xs text-slate-500 font-bold mt-0.5">توزيع التخصصات والأعداد المسجلة والمقبولة في كل قطاع</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($sectorStats as $sec)
                        <div class="p-4 rounded-2xl bg-blue-50/40 dark:bg-slate-900/40 border border-blue-100 dark:border-slate-800 space-y-2">
                            <h4 class="text-xs font-black text-slate-900 dark:text-white">{{ $sec->name_ar }}</h4>
                            <div class="flex items-center justify-between text-xs font-bold text-slate-600 dark:text-slate-300">
                                <span>عدد التخصصات: <strong class="text-blue-600">{{ $sec->skills_count }}</strong></span>
                                <span>المسجلين: <strong class="text-slate-900 dark:text-white">{{ $sec->total_candidates }}</strong></span>
                            </div>
                            <div class="text-xs font-bold text-emerald-600">
                                المقبولين رسمياً: <strong>{{ $sec->approved_candidates }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Column 3: Rejection Reasons & Organizations --}}
        <div class="space-y-6">

            {{-- Rejection Reasons --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="pb-3 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-base font-black text-rose-600">أسباب الرفض الأكثر شيوعاً</h3>
                    <p class="text-xs text-slate-500 font-bold mt-0.5">تحليل أسباب رفض طلبات الترشح غير المستوفية</p>
                </div>

                <div class="space-y-2.5">
                    @forelse($rejectionReasons as $rr)
                        <div class="p-3 rounded-xl bg-rose-50/60 dark:bg-rose-950/30 border border-rose-100 dark:border-rose-900/50 space-y-1">
                            <p class="text-xs font-bold text-rose-800 dark:text-rose-300 leading-relaxed">{{ $rr->rejection_reason }}</p>
                            <span class="text-[10px] font-black text-rose-600 block text-start">تكرر {{ $rr->count }} مرة</span>
                        </div>
                    @empty
                        <p class="text-xs font-bold text-slate-500 text-center py-2">لا توجد حالات رفض مسجلة بسبب محدد حتى الآن.</p>
                    @endforelse
                </div>
            </div>

            {{-- Top Organizations --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="pb-3 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">أبرز المؤسسات التكوينية</h3>
                    <p class="text-xs text-slate-500 font-bold mt-0.5">المؤسسات الأكثر تقديمات للمترشحين</p>
                </div>

                <div class="space-y-2.5">
                    @foreach($topOrganizations as $org)
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 flex items-center justify-between text-xs font-bold">
                            <div class="truncate">
                                <h4 class="text-slate-900 dark:text-white font-black truncate">{{ $org->name_ar }}</h4>
                                <span class="text-[10px] text-slate-400">{{ $org->wilaya?->name_ar ?? '—' }}</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-white font-black shrink-0 text-[10px]">
                                {{ $org->participant_profiles_count }} مترشح
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>

{{-- ═════════════════════════════════════════════════════════════════════
     APEXCHARTS INITIALIZATION SCRIPT
═════════════════════════════════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
function initSuperAdminCharts() {
    if (typeof ApexCharts === 'undefined') {
        setTimeout(initSuperAdminCharts, 120);
        return;
    }

    const rolesEl = document.querySelector("#rolesDonutChart");
    const statusEl = document.querySelector("#statusPieChart");
    const sectorEl = document.querySelector("#sectorBarChart");
    const wilayaEl = document.querySelector("#wilayaBarChart");

    if (!statusEl || !rolesEl) return;

    rolesEl.innerHTML = '';
    statusEl.innerHTML = '';
    if (sectorEl) sectorEl.innerHTML = '';
    if (wilayaEl) wilayaEl.innerHTML = '';

    // 1. Roles Donut Chart (توزيع الأدوار)
    var roleSeries = @json($roleSeries);
    var roleLabels = @json($roleLabels);
    if (roleSeries && roleSeries.length > 0) {
        var roleOptions = {
            series: roleSeries.map(Number),
            labels: roleLabels,
            chart: { type: 'donut', height: 320, fontFamily: 'Cairo, Outfit, sans-serif' },
            colors: ['#0066FF', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899', '#6366F1', '#3B82F6'],
            legend: { position: 'bottom', fontSize: '12px', fontWeight: 700 },
            dataLabels: { enabled: true },
            tooltip: { y: { formatter: function(val) { return val + " حساب"; } } }
        };
        new ApexCharts(rolesEl, roleOptions).render();
    }

    // 2. Status Donut Chart (النسب المئوية ونسبة القبول)
    var approved = {{ (int)$approvedRegistrations }};
    var pending = {{ (int)$pendingRegistrations }};
    var rejected = {{ (int)$rejectedRegistrations }};
    var totalRegs = approved + pending + rejected;

    var rawStatus = [
        { label: 'مقبول ومؤهل رسمياً (Approved)', val: approved, color: '#10B981' },
        { label: 'قيد الدراسة والانتظار (Pending)', val: pending, color: '#F59E0B' },
        { label: 'طلب ترشح مرفوض (Rejected)', val: rejected, color: '#EF4444' }
    ];

    // Filter to active items to prevent zero-slice SVG arc glitches
    var activeStatus = rawStatus.filter(function(item) { return item.val > 0; });
    if (activeStatus.length === 0) {
        activeStatus = [{ label: 'لا توجد بيانات', val: 1, color: '#CBD5E1' }];
    }

    var statusSeries = activeStatus.map(function(item) { return item.val; });
    var statusLabels = activeStatus.map(function(item) { return item.label; });
    var statusColors = activeStatus.map(function(item) { return item.color; });

    var acceptanceRate = totalRegs > 0 ? Math.round((approved / totalRegs) * 100) : 0;

    var statusOptions = {
        series: statusSeries,
        labels: statusLabels,
        colors: statusColors,
        chart: {
            type: 'donut',
            height: 320,
            fontFamily: 'Cairo, Outfit, sans-serif',
            animations: { enabled: true, easing: 'easeinout', speed: 800 }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '72%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '13px',
                            fontWeight: 700,
                            color: '#64748B',
                            offsetY: -6
                        },
                        value: {
                            show: true,
                            fontSize: '20px',
                            fontWeight: 900,
                            color: '#0F172A',
                            offsetY: 6,
                            formatter: function (val) {
                                return val + " مترشح";
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'نسبة القبول الكلية',
                            fontSize: '12px',
                            fontWeight: 800,
                            color: '#10B981',
                            formatter: function (w) {
                                return acceptanceRate + "% (" + approved + ")";
                            }
                        }
                    }
                }
            }
        },
        legend: {
            position: 'bottom',
            fontSize: '12px',
            fontWeight: 700,
            markers: { radius: 12 }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opts) {
                return Math.round(val) + "%";
            },
            style: {
                fontSize: '12px',
                fontWeight: 'bold'
            },
            dropShadow: { enabled: false }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " مترشح";
                }
            }
        }
    };
    new ApexCharts(statusEl, statusOptions).render();

    // 3. Sector Bar Chart
    if (sectorEl) {
        var sectorSeries = @json($sectorSeries);
        var sectorLabels = @json($sectorLabels);
        var sectorOptions = {
            series: [{ name: 'إجمالي المتنافسين', data: sectorSeries.map(Number) }],
            chart: { type: 'bar', height: 340, fontFamily: 'Cairo, Outfit, sans-serif', toolbar: { show: false } },
            colors: ['#2563EB', '#0D9488', '#F59E0B', '#8B5CF6', '#EC4899', '#10B981'],
            plotOptions: { 
                bar: { 
                    borderRadius: 8, 
                    columnWidth: '55%', 
                    distributed: true,
                    dataLabels: { position: 'top' }
                } 
            },
            dataLabels: {
                enabled: true,
                offsetY: -20,
                style: { fontSize: '12px', fontWeight: 800, colors: ['#0f172a'] }
            },
            xaxis: { 
                categories: sectorLabels, 
                labels: { 
                    rotate: -30,
                    trim: false,
                    style: { fontSize: '11px', fontWeight: 700 } 
                } 
            },
            yaxis: {
                labels: { style: { fontSize: '11px', fontWeight: 600 } }
            },
            legend: { show: false },
            tooltip: { y: { formatter: function(val) { return val + " متنافس مؤهل"; } } }
        };
        new ApexCharts(sectorEl, sectorOptions).render();
    }

    // 4. Wilaya Horizontal Bar Chart
    if (wilayaEl) {
        var wilayaSeries = @json($wilayaSeries);
        var wilayaLabels = @json($wilayaLabels);
        var wilayaOptions = {
            series: [{ name: 'عدد المترشحين', data: wilayaSeries.map(Number) }],
            chart: { type: 'bar', height: 320, fontFamily: 'Cairo, Outfit, sans-serif', toolbar: { show: false } },
            colors: ['#10B981'],
            plotOptions: { bar: { borderRadius: 6, horizontal: true, barHeight: '60%' } },
            xaxis: { categories: wilayaLabels, labels: { style: { fontSize: '11px', fontWeight: 700 } } },
            tooltip: { y: { formatter: function(val) { return val + " مترشح"; } } }
        };
        new ApexCharts(wilayaEl, wilayaOptions).render();
    }
}

document.addEventListener('DOMContentLoaded', initSuperAdminCharts);
document.addEventListener('livewire:navigated', initSuperAdminCharts);
if (document.readyState === 'complete' || document.readyState === 'interactive') {
    setTimeout(initSuperAdminCharts, 100);
}
</script>

