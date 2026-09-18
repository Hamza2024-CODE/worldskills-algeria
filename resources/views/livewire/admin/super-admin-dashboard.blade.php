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
         1. HERO HEADER (Clean Minimalist Royal Blue Glass Banner)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-white/10">
        {{-- Ambient background light aura --}}
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-mono font-bold text-amber-300">
                    WORLDSKILLS ALGERIA 2026
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    أولمبياد المهن
                </h1>
                <p class="text-sm sm:text-base text-blue-100 font-bold">
                    مرحباً بك، <span class="text-amber-300 font-black">{{ $user?->name ?? 'المسؤول المحترم' }}</span>
                </p>
            </div>

            {{-- Quick Action Hub --}}
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('admin.cms.homepage') }}" class="px-5 py-3 rounded-2xl bg-white text-[#0052CC] hover:bg-blue-50 font-black text-xs sm:text-sm shadow-xl hover:shadow-2xl transition duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                    <span>تخصيص وإدارة المنصة CMS</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         2. CORE STATISTICAL KPI METRICS (الحسابات، طلبات الترشح، الجنس)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div>
        <h2 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest mb-4 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-[#0066FF]"></span>
            <span>المؤشرات والإحصائيات الشاملة للنظام</span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            {{-- Pillar 1: Users & Accounts --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/40 text-[#0066FF] dark:text-blue-400 flex items-center justify-center border border-blue-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 text-[10px] font-black">
                        المستخدمين والحسابات
                    </span>
                </div>
                <div>
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalUsers) }}</span>
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
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalRegistrations) }}</span>
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
                        <span>ذكوّر: {{ number_format($maleCandidatesCount) }} ({{ $malePercent }}%)</span>
                        <span>إناث: {{ number_format($femaleCandidatesCount) }} ({{ $femalePercent }}%)</span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden flex">
                        <div class="bg-[#0066FF] h-full" style="width: {{ $malePercent }}%"></div>
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
                    <span class="text-3xl sm:text-4xl font-black text-[#06205C] dark:text-white tracking-tight">{{ number_format($totalSkills) }}</span>
                    <p class="text-xs text-slate-500 font-bold mt-1">تخصص مهني معتمد في المنافسة</p>
                </div>
                <div class="pt-2 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs font-bold">
                    <span class="text-emerald-600 font-black">التخصصات النشطة: {{ number_format($activeSkillsCount) }}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         3. SECTOR BREAKDOWN & TOP REQUESTED SKILLS (إحصائيات التخصصات والقطاعات)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Column 1 & 2: Top Most Requested Skills & Sector Counts --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Top Skills Table / Card List --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-black text-[#06205C] dark:text-white">التخصصات الأكثر إقبالاً وطلباً</h3>
                        <p class="text-xs text-slate-500 font-bold mt-0.5">ترتيب التخصصات حسب أعداد المسجلين والمقبولين رسمياً</p>
                    </div>
                    <a href="{{ route('admin.skills') }}" class="text-xs font-black text-[#0066FF] hover:underline">عرض كل التخصصات ←</a>
                </div>

                <div class="space-y-3">
                    @forelse($topSkills as $sk)
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/40 text-[#0066FF] flex items-center justify-center font-mono font-black text-xs shrink-0">
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

            {{-- Sector Breakdown Grid --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="pb-3 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">إحصائيات المهن والمسجلين حسب القطاعات</h3>
                    <p class="text-xs text-slate-500 font-bold mt-0.5">توزيع التخصصات والأعداد المسجلة والمقبولة في كل قطاع</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($sectorStats as $sec)
                        <div class="p-4 rounded-2xl bg-blue-50/50 dark:bg-slate-900/40 border border-blue-100 dark:border-slate-800 space-y-2">
                            <h4 class="text-xs font-black text-[#06205C] dark:text-white">{{ $sec->name_ar }}</h4>
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

        {{-- Column 3: Organizations, Rejection Reasons & Top Wilayas --}}
        <div class="space-y-6">

            {{-- Top Wilayas Participation --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="pb-3 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">الولايات الأكثر مشاركة</h3>
                    <p class="text-xs text-slate-500 font-bold mt-0.5">ترتيب الولايات حسب أعداد المسجلين</p>
                </div>

                <div class="space-y-2.5">
                    @foreach($topWilayasParticipation as $index => $w)
                        <div class="flex items-center justify-between text-xs font-bold p-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-md bg-blue-100 text-[#0066FF] font-mono font-black flex items-center justify-center text-[10px]">
                                    {{ $w->code }}
                                </span>
                                <span class="text-slate-900 dark:text-white font-black">{{ $w->name_ar }}</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-blue-50 text-[#0066FF] font-black text-[11px]">
                                {{ number_format($w->candidates_count) }} مترشح
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Top Rejection Reasons --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="pb-3 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-base font-black text-rose-600">أسباب الرفض الأكثر شيوعاً</h3>
                    <p class="text-xs text-slate-500 font-bold mt-0.5">تحليل أسباب رفض طلبات الترشح الغير مستوفية</p>
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
                    <h3 class="text-base font-black text-[#06205C] dark:text-white">أبرز المؤسسات التكوينية</h3>
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

    {{-- ═════════════════════════════════════════════════════════════════════
         4. RECENT ACTIVITY LOGS & REGISTRATIONS
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
            <div>
                <h3 class="text-base font-black text-[#06205C] dark:text-white">آخر ملفات الترشح والأنشطة بالنظام</h3>
                <p class="text-xs text-slate-500 font-bold mt-0.5">سجل التحديثات الحية الفورية</p>
            </div>
            <a href="{{ route('admin.registrations') }}" class="text-xs font-black text-[#0066FF] hover:underline">عرض كل الملفات ←</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($recentRegistrations as $reg)
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3 text-xs">
                    <div>
                        <span class="font-mono font-black text-[#0066FF] block text-[11px]">{{ $reg->registration_number }}</span>
                        <h4 class="font-black text-slate-900 dark:text-white text-xs mt-0.5">{{ $reg->user?->name ?? 'مترشح مجهول' }}</h4>
                        <span class="text-[10px] font-bold text-slate-500 block">{{ $reg->skill?->getLocalized('name') ?? 'تخصص عام' }}</span>
                    </div>
                    <div class="text-end">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $reg->status === 'APPROVED' ? 'bg-emerald-100 text-emerald-800' : ($reg->status === 'REJECTED' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ $reg->status === 'APPROVED' ? 'مقبول' : ($reg->status === 'REJECTED' ? 'مرفوض' : 'انتظار') }}
                        </span>
                        <span class="text-[10px] font-mono text-slate-400 block mt-1">{{ $reg->created_at?->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
