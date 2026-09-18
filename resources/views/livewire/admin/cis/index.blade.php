<div class="space-y-6 pb-16">
    <!-- TOP HEADER BAR -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-slate-800/90 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs backdrop-blur-md">
        <div class="flex items-center gap-3.5">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-700 text-white flex items-center justify-center font-black shadow-lg shadow-indigo-600/20 border border-indigo-400/40">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        نظام التقييم والنتائج الأولمبي (CIS Engine)
                    </h1>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300 border border-indigo-300/60 dark:border-indigo-800/60">
                        WorldSkills Standard
                    </span>
                </div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-0.5">
                    إدارة وحدات التقييم المعيارية، رصد التناقضات بين المحكمين، وحساب النتائج والميداليات
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <button wire:click="setTab('guide')" class="px-4 py-2.5 rounded-2xl bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 font-bold text-xs transition flex items-center gap-2 border border-amber-300/60 dark:border-amber-800/60 shadow-xs">
                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>دليل وشرح عمل النظام</span>
            </button>
            <button wire:click="openCreate" class="px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 active:scale-98 text-white font-black text-xs transition flex items-center gap-2 shadow-lg shadow-indigo-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>إضافة وحدة تقييم جديدة</span>
            </button>
        </div>
    </div>

    <!-- STATS CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Modules -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">وحدات التقييم المعيارية</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1 font-mono">{{ number_format($totalModules) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>

        <!-- Card 2: Published Results -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">نتائج معتمدة ومحسوبة</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1 font-mono">{{ number_format($publishedResults) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- Card 3: Pending Results -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">نتائج بانتظار الاعتماد</p>
                <p class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1 font-mono">{{ number_format($pendingResults) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- Card 4: Discrepancies Monitor -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">حالات التباين المرصودة</p>
                <p class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1 font-mono">{{ count($discrepancies) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
    </div>

    <!-- NAVIGATION TABS BAR -->
    <div class="flex items-center gap-2 p-1.5 rounded-2xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60 overflow-x-auto">
        <button wire:click="setTab('modules')" class="px-4 py-2.5 rounded-xl text-xs font-black transition flex items-center gap-2 whitespace-nowrap {{ ($activeTab ?? "modules") === 'modules' ? 'bg-white dark:bg-slate-700 text-indigo-600 dark:text-indigo-400 shadow-sm border border-slate-200/60 dark:border-slate-600/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <span>وحدات ومعايير التقييم</span>
        </button>

        <button wire:click="setTab('skills')" class="px-4 py-2.5 rounded-xl text-xs font-black transition flex items-center gap-2 whitespace-nowrap {{ ($activeTab ?? "modules") === 'skills' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-sm border border-slate-200/60 dark:border-slate-600/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>التخصصات وحساب النتائج</span>
        </button>

        <button wire:click="setTab('discrepancies')" class="px-4 py-2.5 rounded-xl text-xs font-black transition flex items-center gap-2 whitespace-nowrap {{ ($activeTab ?? "modules") === 'discrepancies' ? 'bg-white dark:bg-slate-700 text-amber-600 dark:text-amber-400 shadow-sm border border-slate-200/60 dark:border-slate-600/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>مراقبة التباين بين الحكام</span>
            @if(count($discrepancies) > 0)
                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 dark:bg-amber-950 dark:text-amber-300 font-mono font-black text-[10px]">
                    {{ count($discrepancies) }}
                </span>
            @endif
        </button>

        <button wire:click="setTab('results')" class="px-4 py-2.5 rounded-xl text-xs font-black transition flex items-center gap-2 whitespace-nowrap {{ ($activeTab ?? "modules") === 'results' ? 'bg-white dark:bg-slate-700 text-emerald-600 dark:text-emerald-400 shadow-sm border border-slate-200/60 dark:border-slate-600/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            <span>النتائج والميداليات</span>
        </button>

        <button wire:click="setTab('guide')" class="px-4 py-2.5 rounded-xl text-xs font-black transition flex items-center gap-2 whitespace-nowrap {{ ($activeTab ?? "modules") === 'guide' ? 'bg-white dark:bg-slate-700 text-purple-600 dark:text-purple-400 shadow-sm border border-slate-200/60 dark:border-slate-600/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>دليل وشرح عمل الصفحة</span>
        </button>
    </div>

    <!-- TAB 1: MODULES & CRITERIA -->
    @if(($activeTab ?? "modules") === 'modules')
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs overflow-hidden backdrop-blur-md">
            <!-- Search & Filters Header -->
            <div class="p-5 border-b border-slate-100 dark:border-slate-700/60 flex flex-col md:flex-row gap-3 items-stretch md:items-center justify-between">
                <div class="relative w-full max-w-md">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث باسم وحدة التقييم..." class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <div class="absolute left-3 top-3 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <select wire:model.live="filterSkill" class="px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">جميع التخصصات</option>
                        @foreach($skills as $sk)
                            <option value="{{ $sk->id }}">{{ $sk->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Table of Modules -->
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-700/60">
                        <tr>
                            <th class="p-4 text-start whitespace-nowrap">عنوان وحدة التقييم</th>
                            <th class="p-4 text-center whitespace-nowrap">التخصص المرفق</th>
                            <th class="p-4 text-center whitespace-nowrap">الكود الرمزي</th>
                            <th class="p-4 text-center whitespace-nowrap">الحد الأقصى للعلامة</th>
                            <th class="p-4 text-center whitespace-nowrap min-w-[120px]">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-medium">
                        @forelse($modules as $module)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition">
                                <td class="p-4 font-bold text-slate-900 dark:text-white">
                                    <div class="font-black text-slate-900 dark:text-white text-xs">{{ $module->title_ar }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">{{ $module->title_fr }}</div>
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-[11px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200/80 dark:bg-indigo-950/60 dark:text-indigo-300 dark:border-indigo-800/60">
                                        {{ $module->skill?->name_ar ?? 'تخصص عام' }}
                                    </span>
                                </td>
                                <td class="p-4 text-center font-mono font-bold text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                    {{ $module->code ?: '—' }}
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-black font-mono bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800/60">
                                        {{ $module->max_score }} نقطة
                                    </span>
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button wire:click="openEdit({{ $module->id }})" class="p-2 rounded-xl bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 transition border border-amber-200 dark:border-amber-800/60" title="تعديل">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $module->id }})" class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 transition border border-rose-200 dark:border-rose-800/60" title="حذف">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-400 dark:text-slate-500 font-bold">
                                    لا توجد وحدات تقييم مسجلة حالياً.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($modules->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/30">
                    {{ $modules->links() }}
                </div>
            @endif
        </div>
    @endif

    <!-- TAB 2: SKILLS & CALCULATION ENGINE -->
    @if(($activeTab ?? "modules") === 'skills')
        <div class="bg-white dark:bg-slate-800/90 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($skills as $sk)
                    <div class="bg-slate-50 dark:bg-slate-900/60 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 flex flex-col justify-between space-y-4">
                        <div>
                            <span class="px-2.5 py-0.5 rounded-xl bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300 font-mono font-black text-[10px]">
                                {{ $sk->code }}
                            </span>
                            <h3 class="text-base font-black text-slate-900 dark:text-white mt-2">
                                {{ $sk->name_ar }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">
                                {{ $sk->name_fr }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2 pt-3 border-t border-slate-200/60 dark:border-slate-700/60">
                            <button wire:click="calculateResults({{ $sk->id }})" class="flex-1 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs transition shadow-xs">
                                احتساب النتائج والميداليات
                            </button>
                            <button wire:click="publishResults({{ $sk->id }})" class="flex-1 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition shadow-xs">
                                نشر التخصص
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- TAB 3: DISCREPANCIES MONITOR -->
    @if(($activeTab ?? "modules") === 'discrepancies')
        <div class="bg-white dark:bg-slate-800/90 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs space-y-4">
            <h3 class="text-base font-black text-slate-900 dark:text-white">رصد التباين والتناقض بين درجات المحكمين (Discrepancy Monitor)</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold">
                يقوم محرك CIS بفحص الفروقات بين تقييمات أعضاء لجنة التحكيم عند تجاوز الفارق الحاد المسموح به.
            </p>

            <div class="space-y-3">
                @forelse($discrepancies as $disc)
                    <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 flex items-center justify-between gap-4">
                        <div>
                            <div class="font-black text-amber-900 dark:text-amber-200 text-xs">
                                تنبيه تباين في الدرجة: {{ $disc['criterion'] ?? 'معيار التقييم' }}
                            </div>
                            <div class="text-[11px] text-amber-800 dark:text-amber-300 font-bold mt-0.5">
                                الفارق المرصود: <strong class="font-mono">{{ $disc['difference'] ?? 0 }}</strong> نقطة بين تقييمات اللجنة
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-slate-400 dark:text-slate-500 font-bold">
                        لم يتم رصد أي حالات تباين حادة بين درجات المحكمين حالياً.
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- TAB 4: RESULTS TABLE -->
    @if(($activeTab ?? "modules") === 'results')
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 dark:border-slate-700/60 font-black text-slate-900 dark:text-white text-sm">
                النتائج والترتيب المعتمد (WorldSkills Standard Scores)
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-700/60">
                        <tr>
                            <th class="p-4 text-center whitespace-nowrap">الترتيب</th>
                            <th class="p-4 text-start whitespace-nowrap">المترشح والمشارك</th>
                            <th class="p-4 text-center whitespace-nowrap">التخصص الأولمبي</th>
                            <th class="p-4 text-center whitespace-nowrap">النتيجة المعيارية (CIS Score)</th>
                            <th class="p-4 text-center whitespace-nowrap">الميدالية والاعتماد</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-medium">
                        @forelse($results as $res)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition">
                                <td class="p-4 text-center font-mono font-black text-base text-slate-900 dark:text-white">
                                    #{{ $res->rank }}
                                </td>
                                <td class="p-4 font-bold text-slate-900 dark:text-white">
                                    {{ $res->registration?->participant?->first_name_ar }} {{ $res->registration?->participant?->last_name_ar }}
                                </td>
                                <td class="p-4 text-center font-bold text-indigo-600 dark:text-indigo-400 whitespace-nowrap">
                                    {{ $res->skill?->name_ar }}
                                </td>
                                <td class="p-4 text-center font-mono font-black text-emerald-600 dark:text-emerald-400 text-sm whitespace-nowrap">
                                    {{ number_format($res->normalized_score, 2) }} / 500
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-black bg-amber-100 text-amber-900 dark:bg-amber-950 dark:text-amber-300">
                                        {{ $res->medal_type ?? 'شهادة مشاركة' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-400 dark:text-slate-500 font-bold">
                                    لم يتم احتساب أو نشر نتائج معتمدة بعد.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- TAB 5: OPERATIONAL GUIDE (دليل وشرح طريقة عمل النظام) -->
    @if(($activeTab ?? "modules") === 'guide')
        <div class="bg-white dark:bg-slate-800/90 p-8 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-200 dark:border-slate-700">
                <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">دليل وشرح نظام التقييم الأولمبي (CIS Scoring Engine)</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-bold">آلية رصد الدرجات، كشف التناقضات، وحساب الترتيب المعتمد من WorldSkills International</p>
                </div>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Step 1 -->
                <div class="bg-slate-50 dark:bg-slate-900/60 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 space-y-2">
                    <div class="flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-black text-xs">
                        <span class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-950 flex items-center justify-center font-mono">1</span>
                        <span>إدخال وحدات ومعايير التقييم (Assessment Modules)</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                        يتم تقسيم التقييم الفني لكل تخصص إلى وحدات معيارية (Modules)، حيث تحتوي كل وحدة على علامة قصوى ووزن نسبي محدد بدقة حسب معيار WSOS.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-slate-50 dark:bg-slate-900/60 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 space-y-2">
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-black text-xs">
                        <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-950 flex items-center justify-center font-mono">2</span>
                        <span>أنواع التقييم (Subjective vs Objective Rubrics)</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                        - <strong>التقييم الموضوعي (Objective):</strong> يعتمد على نتائج حتمية ومقاييس رقمية مباشرة.<br>
                        - <strong>التقييم الذاتي (Subjective):</strong> يعتمد على رصد الحكام المستقلين للدرجات وفق سلم التقدير الأولمبي (0-3).
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-slate-50 dark:bg-slate-900/60 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 space-y-2">
                    <div class="flex items-center gap-2 text-amber-600 dark:text-amber-400 font-black text-xs">
                        <span class="w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-950 flex items-center justify-center font-mono">3</span>
                        <span>مراقبة ورصد التباين بين المحكمين (Discrepancy Detection)</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                        يقوم محرك النظام تلقائياً برصد أي فارق يتجاوز الحد المسموح به بين تقييمات أعضاء لجنة التحكيم للأنشطة ذاتها وتنبيه رئيس اللجنة للمراجعة قبل الاعتماد.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="bg-slate-50 dark:bg-slate-900/60 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 space-y-2">
                    <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-black text-xs">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-950 flex items-center justify-center font-mono">4</span>
                        <span>حساب النتيجة المعيارية والميداليات (500-Point CIS Score)</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                        يتم تحويل العلامات الخام إلى سلم النتيجة المعيارية المعتمد (500 نقطة) وحساب الترتيب والميداليات (ذهبية، فضية، برونزية، وشهادة تميز Medallion for Excellence).
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- CREATE / EDIT MODULE MODAL -->
    @if($moduleFormOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-xs transition-all">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 space-y-5 border border-slate-200 dark:border-slate-700 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span>{{ $editingModuleId ? 'تعديل وحدة التقييم' : 'إضافة وحدة تقييم جديدة' }}</span>
                    </h3>
                    <button wire:click="$set('moduleFormOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4 text-xs font-bold">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">التخصص والمهارة *</label>
                        <select wire:model="skill_id_form" required class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">اختر التخصص...</option>
                            @foreach($skills as $sk)
                                <option value="{{ $sk->id }}">{{ $sk->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">عنوان الوحدة بالعربية *</label>
                            <input type="text" wire:model="title_ar" required placeholder="الوحدة الأولى..." class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">العنوان بالفرنسية *</label>
                            <input type="text" wire:model="title_fr" required placeholder="Module A..." class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">الكود الرمزي (Module Code)</label>
                            <input type="text" wire:model="code" placeholder="MOD-A" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-mono font-bold uppercase text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">الحد الأقصى للعلامة *</label>
                            <input type="number" step="0.01" wire:model="max_score" required placeholder="100" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-mono font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                        <button type="button" wire:click="$set('moduleFormOpen', false)" class="px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-2xl">إلغاء</button>
                        <button type="submit" class="px-6 py-2.5 text-xs font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-2xl shadow-lg shadow-indigo-600/20">حفظ البيانات</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- DELETE CONFIRMATION MODAL -->
    @if($deleteConfirmOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-sm w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl text-center">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-base font-black text-slate-900 dark:text-white">تأكيد حذف وحدة التقييم</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400">هل أنت متأكد من رغبتك في حذف هذه الوحدة والمعايير التابعة لها؟ الإجراء لا يمكن التراجع عنه.</p>
                <div class="flex justify-center gap-2 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl">إلغاء</button>
                    <button wire:click="deleteModule" class="px-5 py-2 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif
</div>
