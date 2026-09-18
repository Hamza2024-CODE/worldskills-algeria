<div class="space-y-6 pb-16">
    <!-- TOP HEADER BAR -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-slate-800/90 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs backdrop-blur-md">
        <div class="flex items-center gap-3.5">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-600 to-purple-700 text-white flex items-center justify-center font-black shadow-lg shadow-purple-600/20 border border-purple-400/40">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    إدارة الحكام والخبراء المحكمين
                </h1>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-0.5">
                    سجل الهيئة التحكيمية المعتمدة، وتعيين رؤساء اللجان والخبراء حسب التخصصات والمراكز والولايات
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <button wire:click="exportExcel" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs transition flex items-center gap-2 border border-slate-200/60 dark:border-slate-600/60 shadow-xs">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>تصدير القائمة CSV</span>
            </button>
            <button wire:click="openCreate" class="px-5 py-2.5 rounded-2xl bg-purple-600 hover:bg-purple-700 active:scale-98 text-white font-black text-xs transition flex items-center gap-2 shadow-lg shadow-purple-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>إضافة حكم / خبير جديد</span>
            </button>
        </div>
    </div>

    <!-- STATS CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Judges -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">إجمالي الحكام والخبراء</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1 font-mono">{{ number_format($totalJudges) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <!-- Card 2: Active Judges -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">الحكام المفعلون بالموقع</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1 font-mono">{{ number_format($activeJudgesCount) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- Card 3: Active Assignments -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">التعيينات التحكيمية النشطة</p>
                <p class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1 font-mono">{{ number_format($activeAssignments) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>

        <!-- Card 4: Centers Count -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">المراكز والهيئات الممثلة</p>
                <p class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1 font-mono">{{ count($organizations) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
            </div>
        </div>
    </div>

    <!-- MULTI-CRITERIA FILTERS HUB & TABLE -->
    <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs overflow-hidden backdrop-blur-md">
        <!-- Search & 5 Filters Controls Header -->
        <div class="p-5 border-b border-slate-100 dark:border-slate-700/60 flex flex-col xl:flex-row gap-3 items-stretch xl:items-center justify-between">
            <!-- Search Bar -->
            <div class="relative flex-1 min-w-[200px] max-w-xs">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث باسم الحكم أو البريد الإلكتروني..." class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-purple-500">
                <div class="absolute left-3 top-3 text-slate-400 pointer-events-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- 5 Dynamic Filters Row -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2.5 flex-1">
                <!-- 1. Country Filter -->
                <select wire:model.live="filterCountry" class="px-3 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">جميع الدول</option>
                    @foreach($countries as $cnt)
                        <option value="{{ $cnt->id }}">{{ $cnt->name_ar }}</option>
                    @endforeach
                </select>

                <!-- 2. Wilaya Filter -->
                <select wire:model.live="filterWilaya" class="px-3 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">جميع الولايات</option>
                    @foreach($wilayas as $w)
                        <option value="{{ $w->id }}">{{ $w->code }} - {{ $w->name_ar }}</option>
                    @endforeach
                </select>

                <!-- 3. Center/Organization Filter -->
                <select wire:model.live="filterOrganization" class="px-3 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">جميع المراكز والمؤسسات</option>
                    @foreach($organizations as $org)
                        <option value="{{ $org->id }}">{{ $org->name_ar }}</option>
                    @endforeach
                </select>

                <!-- 4. Skill/Specialty Filter -->
                <select wire:model.live="filterSkill" class="px-3 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">جميع التخصصات</option>
                    @foreach($skills as $sk)
                        <option value="{{ $sk->id }}">{{ $sk->name_ar }}</option>
                    @endforeach
                </select>

                <!-- 5. Status Filter -->
                <select wire:model.live="filterStatus" class="px-3 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">جميع الحالات</option>
                    <option value="active">نشط ومفعل</option>
                    <option value="inactive">معطّل / بدون تعيين</option>
                </select>
            </div>
        </div>

        <!-- TABLE OF JUDGES & EXPERTS -->
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-700/60">
                    <tr>
                        <th class="p-4 text-start whitespace-nowrap min-w-[200px]">الحكم / الخبير المحكم</th>
                        <th class="p-4 text-center whitespace-nowrap">الدولة والولاية</th>
                        <th class="p-4 text-center whitespace-nowrap">المركز / المؤسسة</th>
                        <th class="p-4 text-center whitespace-nowrap">التخصص والصفة المسندة</th>
                        <th class="p-4 text-center whitespace-nowrap">حالة الحساب</th>
                        <th class="p-4 text-center whitespace-nowrap min-w-[130px]">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-medium">
                    @forelse($judges as $judge)
                        @php
                            $activeAssignment = $judge->competitionAssignments->firstWhere('is_active', true);
                        @endphp
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition">
                            <!-- Judge Name & Info -->
                            <td class="p-4 font-bold text-slate-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 font-black text-sm flex items-center justify-center border border-purple-200 dark:border-purple-800 shrink-0 shadow-xs">
                                        {{ mb_substr($judge->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-900 dark:text-white text-xs">
                                            {{ $judge->name }}
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-normal font-mono mt-0.5">
                                            {{ $judge->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Country & Wilaya -->
                            <td class="p-4 text-center whitespace-nowrap">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="font-bold text-slate-800 dark:text-slate-200 text-xs">
                                        {{ $judge->country?->name_ar ?? 'الجزائر' }}
                                    </span>
                                    @if($judge->wilaya)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400">
                                            {{ $judge->wilaya->code }} - {{ $judge->wilaya->name_ar }}
                                        </span>
                                    @else
                                        <span class="text-[10px] text-slate-400">—</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Center / Organization -->
                            <td class="p-4 text-center whitespace-nowrap">
                                @if($judge->organization)
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-[11px] font-black bg-amber-50 text-amber-800 border border-amber-200/80 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800/60 whitespace-nowrap">
                                        {{ $judge->organization->name_ar }}
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                        مركز غير محدد
                                    </span>
                                @endif
                            </td>

                            <!-- Skill & Assignment Type -->
                            <td class="p-4 text-center whitespace-nowrap">
                                @if($activeAssignment && $activeAssignment->skill)
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-[11px] font-black bg-blue-50 text-blue-700 border border-blue-200/80 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800/60 whitespace-nowrap">
                                            {{ $activeAssignment->skill->name_ar }}
                                        </span>
                                        <span class="text-[10px] font-black text-purple-600 dark:text-purple-400">
                                            {{ $activeAssignment->assignment_type === 'CHIEF_JUDGE' ? 'رئيس لجنة التحكيم' : 'خبير محكم معتمد' }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                        بدون تخصص مسند
                                    </span>
                                @endif
                            </td>

                            <!-- Active Account Toggle -->
                            <td class="p-4 text-center whitespace-nowrap">
                                <button wire:click="toggleActive({{ $judge->id }})" class="inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black transition border whitespace-nowrap {{ $judge->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800/60 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-200 dark:bg-slate-900 dark:text-slate-400 dark:border-slate-700 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $judge->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }} shrink-0"></span>
                                    <span>{{ $judge->is_active ? 'نشط ومفعل' : 'معطّل' }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button wire:click="openDrawer({{ $judge->id }})" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 transition" title="عرض الملف والاعتماد">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="openEdit({{ $judge->id }})" class="p-2 rounded-xl bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 transition border border-amber-200 dark:border-amber-800/60" title="تعديل البيانات">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $judge->id }})" class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 transition border border-rose-200 dark:border-rose-800/60" title="حذف">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 dark:text-slate-500 font-bold">
                                لا يوجد حكام أو خبراء محكمون مطابقون لخيارات البحث المحددة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($judges->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/30">
                {{ $judges->links() }}
            </div>
        @endif
    </div>

    <!-- CREATE / EDIT JUDGE MODAL -->
    @if($createFormOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-xs transition-all">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 space-y-5 border border-slate-200 dark:border-slate-700 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span>{{ $isEditing ? 'تعديل بيانات الحكم الخبير' : 'إضافة حكم / خبير محكم جديد' }}</span>
                    </h3>
                    <button wire:click="$set('createFormOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveJudge" class="space-y-4 text-xs font-bold">
                    <!-- Name & Email -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">الاسم الكامل للحكم / الخبير *</label>
                        <input type="text" wire:model="name" required placeholder="الاسم واللقب..." class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">البريد الإلكتروني *</label>
                            <input type="email" wire:model="email" required placeholder="judge@worldskills.dz" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-mono font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">كلمة المرور {{ $isEditing ? '(اتركها فارغة للإبقاء عليها)' : '' }}</label>
                            <input type="password" wire:model="password" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-mono font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>

                    <!-- Country & Wilaya -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">الدولة</label>
                            <select wire:model="country_id" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">الجزائر (افتراضي)</option>
                                @foreach($countries as $cnt)
                                    <option value="{{ $cnt->id }}">{{ $cnt->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">الولاية (بالجزائر)</label>
                            <select wire:model="wilaya_id" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">اختر الولاية...</option>
                                @foreach($wilayas as $w)
                                    <option value="{{ $w->id }}">{{ $w->code }} - {{ $w->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Center / Organization -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">المركز / المؤسسة التدريبية</label>
                        <select wire:model="organization_id" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">اختر المركز أو المؤسسة...</option>
                            @foreach($organizations as $org)
                                <option value="{{ $org->id }}">{{ $org->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Skill & Role Assignment -->
                    <div class="grid grid-cols-2 gap-3 bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200 dark:border-slate-700">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">التخصص والمهارة الأولمبية</label>
                            <select wire:model="skill_id" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none">
                                <option value="">اختر التخصص...</option>
                                @foreach($skills as $sk)
                                    <option value="{{ $sk->id }}">{{ $sk->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">الصفة التحكيمية</label>
                            <select wire:model="assignment_type" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none">
                                <option value="CHIEF_JUDGE">رئيس لجنة التحكيم</option>
                                <option value="EXPERT">خبير محكم معتمد</option>
                                <option value="DEPUTY_JUDGE">محكم مساعد</option>
                            </select>
                        </div>
                    </div>

                    <!-- Active Toggle -->
                    <div class="bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200 dark:border-slate-700">
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">تفعيل حساب الحكم وصلاحيات التقييم</span>
                            <input type="checkbox" wire:model="is_active" class="rounded border-slate-300 text-purple-600 focus:ring-purple-500 w-4 h-4">
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                        <button type="button" wire:click="$set('createFormOpen', false)" class="px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-2xl">إلغاء</button>
                        <button type="submit" class="px-6 py-2.5 text-xs font-black text-white bg-purple-600 hover:bg-purple-700 rounded-2xl shadow-lg shadow-purple-600/20">حفظ البيانات والتكليف</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- DETAILS DRAWER -->
    @if(($drawerOpen ?? false) && ($selectedJudge ?? null))
        <div class="fixed inset-0 z-50 overflow-hidden bg-slate-900/60 backdrop-blur-xs flex justify-end transition-opacity">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 h-full shadow-2xl flex flex-col justify-between overflow-y-auto p-6 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-black text-xl border border-purple-500/20">
                            {{ mb_substr($selectedJudge->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-slate-900 dark:text-white">{{ $selectedJudge->name }}</h2>
                            <span class="text-xs font-mono font-bold text-purple-600 dark:text-purple-400">{{ $selectedJudge->email }}</span>
                        </div>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4 text-xs font-semibold flex-1">
                    <div class="bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl space-y-3 border border-slate-100 dark:border-slate-700/60">
                        <div class="flex justify-between items-center"><span class="text-slate-400">الدولة التابع لها:</span><span class="font-bold text-slate-900 dark:text-white">{{ $selectedJudge->country?->name_ar ?? 'الجزائر' }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">الولاية:</span><span class="font-bold text-slate-900 dark:text-white">{{ $selectedJudge->wilaya ? $selectedJudge->wilaya->code . ' - ' . $selectedJudge->wilaya->name_ar : 'غير محددة' }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">المركز / المؤسسة:</span><span class="font-bold text-amber-600 dark:text-amber-400">{{ $selectedJudge->organization?->name_ar ?? 'غير مسند لمركز' }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">حالة التفعيل:</span><span class="font-black {{ $selectedJudge->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}">{{ $selectedJudge->is_active ? 'نشط ومفعل' : 'معطّل' }}</span></div>
                    </div>

                    <!-- Assignments list -->
                    <div class="space-y-2">
                        <h4 class="font-black text-slate-900 dark:text-white text-xs">التخصصات والمهام التحكيمية المسندة:</h4>
                        @forelse($selectedJudge->competitionAssignments as $assign)
                            <div class="p-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/40 flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-slate-900 dark:text-white text-xs">{{ $assign->skill?->name_ar ?? 'تخصص' }}</div>
                                    <div class="text-[10px] text-purple-600 dark:text-purple-400 font-bold mt-0.5">{{ $assign->assignment_type === 'CHIEF_JUDGE' ? 'رئيس لجنة التحكيم' : 'خبير محكم معتمد' }}</div>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $assign->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $assign->is_active ? 'نشط' : 'سابق' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-slate-400 text-xs font-normal">لا توجد مهام تحكيمية مسندة حالياً.</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex gap-2 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="openEdit({{ $selectedJudge->id }})" class="flex-1 px-4 py-2.5 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white font-black text-xs transition">تعديل البيانات</button>
                    <button wire:click="confirmDelete({{ $selectedJudge->id }})" class="flex-1 px-4 py-2.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs transition">حذف الحكم</button>
                </div>
            </div>
        </div>
    @endif

    <!-- DELETE MODAL -->
    @if($deleteConfirmOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-sm w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl text-center">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-base font-black text-slate-900 dark:text-white">تأكيد حذف الحكم / الخبير</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400">هل أنت متأكد من رغبتك في حذف هذا الحكم من الهيئة التحكيمية؟ لا يمكن التراجع عن هذا الإجراء.</p>
                <div class="flex justify-center gap-2 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl">إلغاء</button>
                    <button wire:click="deleteJudge" class="px-5 py-2 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif
</div>
