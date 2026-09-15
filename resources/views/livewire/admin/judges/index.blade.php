@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-5 pb-8" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER --}}
    <x-dashboard.page-header
        :title="$t('إدارة المحكمين والتحكيم', 'Gestion des Juges & Arbitres', 'Jury & Expert Judges Management')"
        :subtitle="$t('إجمالي المحكمين: ', 'Total Juges: ', 'Total Judges: ') . $totalJudges . ' — ' . $t('التعيينات النشطة: ', 'Affectations Actives: ', 'Active Assignments: ') . $activeAssignments"
    >
        <button wire:click="openAssign"
            class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-white text-[#06205C] hover:bg-blue-50 text-xs font-black transition shadow-xl shrink-0">
            <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>{{ $t('تعيين محكم', 'Affecter un Juge', 'Assign Judge') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- FILTERS --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ $t('بحث باسم المحكم أو البريد الإلكتروني...', 'Rechercher par nom ou email...', 'Search judge name or email...') }}"
                class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select wire:model.live="filterSkill"
            class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل التخصصات', 'Tous les Métiers', 'All Skills') }}</option>
            @foreach($skills as $skill)
                <option value="{{ $skill->id }}">{{ $skill->getLocalized('name') }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterStatus"
            class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل المحكمين', 'Tous les Juges', 'All Judges') }}</option>
            <option value="active">{{ $t('لديهم تعيين نشط', 'Avec Affectation', 'Assigned') }}</option>
            <option value="inactive">{{ $t('بدون تعيين', 'Sans Affectation', 'Unassigned') }}</option>
        </select>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-5 py-3.5 text-start">المحكم</th>
                        <th class="px-5 py-3.5 text-start">البريد الإلكتروني</th>
                        <th class="px-5 py-3.5 text-start">التعيينات النشطة</th>
                        <th class="px-5 py-3.5 text-start">الحالة</th>
                        <th class="px-5 py-3.5 text-end">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($judges as $judge)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition group">
                            <td class="px-5 py-3.5 font-bold text-slate-900 dark:text-slate-100">
                                <button wire:click="openDrawer({{ $judge->id }})" class="hover:text-blue-600 transition">{{ $judge->name }}</button>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600 dark:text-slate-300">{{ $judge->email }}</td>
                            <td class="px-5 py-3.5">
                                @if($judge->active_assignments_count > 0)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $judge->active_assignments_count }} تعيين
                                    </span>
                                @else
                                    <span class="text-slate-400 text-xs">لا تعيينات</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">نشط</span>
                            </td>
                            <td class="px-5 py-3.5 text-end">
                                <button wire:click="openDrawer({{ $judge->id }})" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-slate-400 font-medium">لا يوجد محكمون مطبقون للبحث</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($judges->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700">{{ $judges->links() }}</div>
        @endif
    </div>

    {{-- ASSIGN FORM MODAL --}}
    @if($assignFormOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-md w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">تعيين محكم جديد</h3>
                    <button wire:click="$set('assignFormOpen', false)" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">المستخدم *</label>
                        <select wire:model="selectedUserId" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100">
                            <option value="">— اختر مستخدمًا —</option>
                            @foreach($availableUsers as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">التخصص *</label>
                        <select wire:model="selectedSkillId" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100">
                            <option value="">— اختر التخصص —</option>
                            @foreach($skills as $sk)
                                <option value="{{ $sk->id }}">{{ $sk->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">صفة التحكيم *</label>
                        <select wire:model="assignmentType" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100">
                            <option value="CHIEF_JUDGE">رئيس المحكمين</option>
                            <option value="JUDGE">محكم</option>
                            <option value="DEPUTY_JUDGE">محكم مساعد</option>
                            <option value="OBSERVER">مراقب</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('assignFormOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="saveAssignment" class="px-5 py-2 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs">تأكيد التعيين</button>
                </div>
            </div>
        </div>
    @endif

    {{-- DETAIL DRAWER --}}
    @if($drawerOpen && $selectedJudge)
        <div class="fixed inset-0 z-50 flex justify-end bg-slate-900/40 backdrop-blur-xs">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 border-s border-slate-200 dark:border-slate-700 h-full p-6 overflow-y-auto space-y-6 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 dark:text-slate-100">{{ $selectedJudge->name }}</h2>
                        <p class="text-xs font-bold text-blue-600 font-mono">{{ $selectedJudge->email }}</p>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <h4 class="text-xs font-black text-slate-500 uppercase">سجل التعيينات</h4>
                    @foreach($selectedJudge->competitionAssignments as $asgn)
                        <div class="p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-200 dark:border-slate-600 space-y-1">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $asgn->skill?->name_ar }}</span>
                                <span class="text-xs font-bold text-blue-600">{{ $asgn->assignment_type }}</span>
                            </div>
                            @if($asgn->is_active)
                                <button wire:click="confirmRevoke({{ $asgn->id }})" class="text-xs text-red-600 hover:underline pt-1 block">إلغاء التعيين</button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</div>
