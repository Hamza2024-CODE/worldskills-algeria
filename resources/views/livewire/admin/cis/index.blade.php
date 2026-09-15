<div class="space-y-6 pb-8 font-sans">

    {{-- HEADER & COMMAND CENTER METRICS IN SIGNATURE HERO CONTAINER --}}
    <div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-white/10 mb-6">
        {{-- Ambient background light aura --}}
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-start sm:items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white shrink-0 shadow-lg">
                    <svg class="w-7 h-7 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div class="space-y-2.5">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight leading-tight">
                            مركز القيادة والتقييم الدولي (CIS Command Center)
                        </h1>
                        <span class="px-2.5 py-0.5 rounded-full bg-blue-500/30 text-blue-200 border border-blue-400/40 text-[10px] font-mono font-black uppercase tracking-wider">CIS Core V8.2</span>
                    </div>

                    {{-- Metrics Enclosed in Containers --}}
                    <div class="flex items-center gap-2 flex-wrap">
                        <div class="px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-white text-xs font-bold flex items-center gap-2 shadow-xs">
                            <span class="text-blue-200 text-[11px]">الوحدات المعتمدة:</span>
                            <span class="font-mono font-black text-white text-sm">{{ $totalModules }}</span>
                        </div>
                        <div class="px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-white text-xs font-bold flex items-center gap-2 shadow-xs">
                            <span class="text-emerald-200 text-[11px]">نتائج معتمدة للنشر:</span>
                            <span class="font-mono font-black text-emerald-300 text-sm">{{ $publishedResults }}</span>
                        </div>
                        <div class="px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-white text-xs font-bold flex items-center gap-2 shadow-xs">
                            <span class="text-amber-200 text-[11px]">نتائج بانتظار الاعتماد:</span>
                            <span class="font-mono font-black text-amber-300 text-sm">{{ $pendingResults }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-3 rounded-2xl bg-white text-[#06205C] hover:bg-blue-50 text-xs font-black transition shadow-xl shrink-0 transform active:scale-95">
                    <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    <span>إضافة وحدة تقييم جديدة</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Official WorldSkills CIS Standard Compliance Notice -->
    <div class="p-4 rounded-2xl bg-gradient-to-r from-blue-950 via-slate-900 to-indigo-950 text-white border border-blue-800 shadow-md space-y-1.5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-amber-400 font-black text-xs uppercase tracking-wider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>ملاحظة معيارية رسمية — WSAP CIS EVALUATION METHODOLOGY</span>
            </div>
            <span class="px-2.5 py-0.5 rounded-full bg-blue-500/20 text-blue-300 text-[10px] font-mono font-bold border border-blue-400/30">WSAP V8.2 CIS METHODOLOGY</span>
        </div>
        <p class="text-xs text-slate-200 font-medium leading-relaxed">
            نظام تقييم WSAP مبني على مبادئ ومعايير <strong class="text-white font-bold">WorldSkills International</strong>، مع تكييف المعايير الوطنية حسب التخصص وإصدار المنافسة.
        </p>
        <p class="text-[11px] text-slate-400 font-mono italic">
            Système d’évaluation WSAP basé sur les principes et standards de WorldSkills International, avec adaptation aux référentiels nationaux selon le métier et l’édition de la compétition.
        </p>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-xl border border-emerald-200"><x-ws.icon name="check-circle" class="w-4 h-4 inline-block me-1 text-emerald-600" /> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-red-50 text-red-700 text-xs font-bold rounded-xl border border-red-200"><x-ws.icon name="x-circle" class="w-4 h-4 inline-block me-1 text-red-600" /> {{ session('error') }}</div>
    @endif

    <!-- UNIFIED COMMAND TABS CONTAINER -->
    <div class="bg-white dark:bg-slate-800 p-3 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center gap-2 overflow-x-auto">
        <button wire:click="setTab('modules')" class="px-4 py-2.5 rounded-2xl transition flex items-center gap-2 text-xs font-black {{ $activeTab === 'modules' ? 'bg-[#06205C] dark:bg-blue-600 text-white shadow-sm' : 'bg-slate-50 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100' }}">
            <x-ws.icon name="clipboard-document-list" class="w-4 h-4" />
            <span>وحدات ومعايير التقييم</span>
        </button>
        <button wire:click="setTab('skills')" class="px-4 py-2.5 rounded-2xl transition flex items-center gap-2 text-xs font-black {{ $activeTab === 'skills' ? 'bg-[#06205C] dark:bg-blue-600 text-white shadow-sm' : 'bg-slate-50 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100' }}">
            <x-ws.icon name="trophy" class="w-4 h-4" />
            <span>التخصصات المعتمدة (WSOS)</span>
        </button>
        <button wire:click="setTab('discrepancies')" class="px-4 py-2.5 rounded-2xl transition flex items-center gap-2 text-xs font-black {{ $activeTab === 'discrepancies' ? 'bg-[#06205C] dark:bg-blue-600 text-white shadow-sm' : 'bg-slate-50 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100' }}">
            <x-ws.icon name="exclamation-triangle" class="w-4 h-4 {{ $activeTab === 'discrepancies' ? 'text-amber-300' : 'text-amber-500' }}" />
            <span>مراقبة التباين بين الحكام</span>
            @if(count($discrepancies) > 0)
                <span class="px-2 py-0.5 rounded-full bg-amber-400 text-slate-950 font-black text-[10px]">{{ count($discrepancies) }}</span>
            @endif
        </button>
        <button wire:click="setTab('results')" class="px-4 py-2.5 rounded-2xl transition flex items-center gap-2 text-xs font-black {{ $activeTab === 'results' ? 'bg-[#06205C] dark:bg-blue-600 text-white shadow-sm' : 'bg-slate-50 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100' }}">
            <x-ws.icon name="medal" class="w-4 h-4 {{ $activeTab === 'results' ? 'text-amber-300' : 'text-amber-600' }}" />
            <span>النتائج والميداليات الاعتمادية</span>
        </button>
    </div>

    <!-- TAB 1: MODULES & CRITERIA -->
    @if($activeTab === 'modules')
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-slate-900 text-sm">وحدات التقييم المعتمدة لكل تخصص</h2>
            <input wire:model.live="search" type="text" placeholder="بحث باسم الوحدة..." class="px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 w-64">
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-start">الوحدة / التخصص</th>
                        <th class="px-5 py-3.5 text-start">الرمز</th>
                        <th class="px-5 py-3.5 text-start">الحد الأقصى</th>
                        <th class="px-5 py-3.5 text-end">إجراءات التحكم</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($modules as $module)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-slate-900">{{ $module->title_ar }}</div>
                                <div class="text-[11px] text-slate-400">{{ $module->skill?->name_ar }}</div>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-500">{{ $module->code ?? '—' }}</td>
                            <td class="px-5 py-3.5 font-black text-blue-600">{{ number_format($module->max_score, 2) }}</td>
                            <td class="px-5 py-3.5 text-end">
                                <div class="flex justify-end gap-1.5">
                                    <button wire:click="openEdit({{ $module->id }})" class="px-3 py-1 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg">تعديل</button>
                                    <button wire:click="calculateResults({{ $module->skill_id }})" class="px-3 py-1 text-xs font-bold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 rounded-lg">احتساب المحرك</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-slate-400 font-medium">لا توجد وحدات تقييم مضافة بعد</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($modules->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">{{ $modules->links() }}</div>
        @endif
    </div>
    @endif

    <!-- TAB 2: SKILLS (WSOS) -->
    @if($activeTab === 'skills')
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 space-y-4">
        <h2 class="font-black text-slate-900 text-sm border-b border-slate-100 pb-3">التخصصات المهنية المعرفية (WSOS Disciplines)</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($skills as $skill)
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-[10px] font-black px-2 py-0.5 rounded bg-blue-100 text-blue-700">{{ $skill->code }}</span>
                        <span class="text-[10px] font-bold text-emerald-600"><x-ws.icon name="check" class="w-3 h-3 inline-block me-0.5 text-emerald-600" /> نشط</span>
                    </div>
                    <h3 class="font-black text-slate-900 text-sm">{{ $skill->name_ar }}</h3>
                    <p class="text-[11px] text-slate-500 font-mono">{{ $skill->name_en }}</p>
                    <div class="pt-2 border-t border-slate-200/60 flex justify-between items-center text-[11px]">
                        <span class="text-slate-400">وحدات التقييم: {{ $skill->assessmentModules()->count() }}</span>
                        <button wire:click="calculateResults({{ $skill->id }})" class="text-blue-600 font-bold hover:underline">احتساب النتائج</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- TAB 3: DISCREPANCIES MONITOR -->
    @if($activeTab === 'discrepancies')
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h2 class="font-black text-slate-900 text-sm flex items-center gap-2">
                <x-ws.icon name="exclamation-triangle" class="w-4 h-4 text-amber-500 inline-block" />
                <span>كشف التباين بين الحكام (Judgement Discrepancies > 1.0)</span>
            </h2>
            <span class="text-xs text-slate-400">فحص تلقائي مستمر</span>
        </div>

        @if(count($discrepancies) > 0)
            <div class="space-y-3">
                @foreach($discrepancies as $disc)
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-black text-amber-900 block">{{ $disc['title'] }}</span>
                            <span class="text-[11px] text-amber-700 block">فارق النقاط بين الحكام: <strong class="font-mono text-rose-700">{{ $disc['range'] }}</strong> (الحد الأدنى: {{ $disc['min_score'] }} — الأعلى: {{ $disc['max_score'] }})</span>
                        </div>
                        <span class="px-3 py-1 rounded-lg bg-amber-200 text-amber-900 text-xs font-bold">يتطلب إعادة التقييم</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-12 text-center text-slate-400 space-y-2">
                <div class="flex justify-center text-emerald-500"><x-ws.icon name="check-circle" class="w-10 h-10" /></div>
                <p class="text-xs font-bold text-slate-600">لا توجد حالات تباين تتجاوز 1.0 بين الحكام حالياً.</p>
            </div>
        @endif
    </div>
    @endif

    <!-- TAB 4: RESULTS & MEDALS -->
    @if($activeTab === 'results')
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-slate-900 text-sm">ترتيب المتنافسين والميداليات (Control Center)</h2>
            <span class="text-xs text-slate-400 font-medium">الاعتماد والتثبيت النهائي</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-start w-12">المركز</th>
                        <th class="px-5 py-3.5 text-start">المتنافس</th>
                        <th class="px-5 py-3.5 text-start">التخصص</th>
                        <th class="px-5 py-3.5 text-start">المجموع المحسوب</th>
                        <th class="px-5 py-3.5 text-start">الجائزة</th>
                        <th class="px-5 py-3.5 text-end">حالة النشر</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($results as $result)
                        @php
                            $awardBadge = match($result->award) {
                                'GOLD'   => ['bg-amber-50 text-amber-700 border-amber-200', 'ذهبية (Gold)'],
                                'SILVER' => ['bg-slate-100 text-slate-700 border-slate-300', 'فضية (Silver)'],
                                'BRONZE' => ['bg-orange-50 text-orange-700 border-orange-200', 'برونزية (Bronze)'],
                                'MEDALLION_FOR_EXCELLENCE' => ['bg-purple-50 text-purple-700 border-purple-200', 'شهادة تميز (Excellence)'],
                                default  => ['bg-slate-50 text-slate-400 border-slate-200', '—'],
                            };
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 font-mono font-black text-slate-500">#{{ $result->rank }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">{{ $result->registration?->participant?->first_name_ar }} {{ $result->registration?->participant?->last_name_ar }}</td>
                            <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $result->skill?->name_ar }}</td>
                            <td class="px-5 py-3.5 font-black text-blue-600 font-mono">{{ number_format($result->final_score, 3) }} / 100</td>
                            <td class="px-5 py-3.5"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $awardBadge[0] }}">{{ $awardBadge[1] }}</span></td>
                            <td class="px-5 py-3.5 text-end">
                                @if($result->is_published)
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">منشور للجمهور</span>
                                @else
                                    <button wire:click="publishResults({{ $result->skill_id }})" class="px-3 py-1 rounded-lg bg-amber-500 hover:bg-amber-600 text-slate-950 text-[11px] font-black shadow-xs">اعتماد ونشر للجمهور</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400 font-medium">لم يتم احتساب نتائج حتى الآن</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- MODULE FORM MODAL --}}
    @if($moduleFormOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full space-y-4 border border-slate-200 shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-lg font-black text-slate-900">{{ $editingModuleId ? 'تعديل وحدة التقييم' : 'إضافة وحدة تقييم' }}</h3>
                    <button wire:click="$set('moduleFormOpen', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">التخصص *</label>
                        <select wire:model="skill_id_form" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 bg-slate-50">
                            <option value="">اختر التخصص</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}">{{ $skill->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">رمز الوحدة</label>
                            <input wire:model="code" type="text" placeholder="Module A" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 bg-slate-50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">الحد الأقصى *</label>
                            <input wire:model="max_score" type="number" min="0" step="0.01" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 bg-slate-50">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">اسم الوحدة (بالعربية) *</label>
                        <input wire:model="title_ar" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 bg-slate-50">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">اسم الوحدة (بالفرنسية) *</label>
                        <input wire:model="title_fr" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 bg-slate-50">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button wire:click="$set('moduleFormOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="save" class="px-5 py-2 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs">حفظ الوحدة</button>
                </div>
            </div>
        </div>
    @endif

</div>
