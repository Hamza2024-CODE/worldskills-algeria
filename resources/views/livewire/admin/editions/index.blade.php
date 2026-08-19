@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-5 pb-8" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER --}}
    <x-dashboard.page-header
        :title="$t('إدارة الطبعات والدورات الوطنية والرسمية', 'Gestion des Éditions Nationales', 'Editions & Olympic Sessions Management')"
        :subtitle="$t('إجمالي الطبعات المسجلة: ', 'Total Éditions: ', 'Total Editions: ') . $totalEditions . ' — ' . $t('متابعة وإدارة دورات مسابقة WorldSkills Algeria', 'Suivi des compétitions nationales', 'National competitions management')"
    >
        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>{{ $t('إضافة طبعة جديدة', 'Ajouter une Édition', 'Add New Edition') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- FILTERS --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ $t('بحث باسم الطبعة أو السنة...', 'Rechercher par nom ou année...', 'Search edition or year...') }}"
                class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select wire:model.live="filterStatus"
            class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل الحالات', 'Tous les Statuts', 'All Statuses') }}</option>
            <option value="DRAFT">{{ $t('مسودة', 'Brouillon', 'Draft') }}</option>
            <option value="ONGOING">{{ $t('جارية الآن', 'En cours', 'Ongoing') }}</option>
            <option value="COMPLETED">{{ $t('مكتملة', 'Terminée', 'Completed') }}</option>
        </select>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-5 py-3.5 text-start">السنة</th>
                        <th class="px-5 py-3.5 text-start">اسم الطبعة</th>
                        <th class="px-5 py-3.5 text-start">المدينة / المقر</th>
                        <th class="px-5 py-3.5 text-start">الحالة</th>
                        <th class="px-5 py-3.5 text-start">طبعة نشطة</th>
                        <th class="px-5 py-3.5 text-end">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($editions as $edition)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition group">
                            <td class="px-5 py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">{{ $edition->year }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900 dark:text-slate-100">
                                <button wire:click="openDrawer({{ $edition->id }})" class="hover:text-blue-600 transition">{{ $edition->name_ar }}</button>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 dark:text-slate-300 font-medium">{{ $edition->city ?: '—' }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ $edition->status }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <button wire:click="toggleActive({{ $edition->id }})"
                                    class="px-3 py-1 rounded-xl text-xs font-black transition {{ $edition->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $edition->is_active ? 'نشطة' : 'تعطيل' }}
                                </button>
                            </td>
                            <td class="px-5 py-3.5 text-end">
                                <div class="flex items-center justify-end gap-1.5 opacity-90">
                                    <button wire:click="openDrawer({{ $edition->id }})" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="عرض التفاصيل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="openEdit({{ $edition->id }})" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $edition->id }})" class="p-1.5 text-slate-500 hover:text-red-600 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="حذف">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400 font-medium">لا توجد طبعات مسجلة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($editions->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700">{{ $editions->links() }}</div>
        @endif
    </div>

    {{-- MODAL FORM --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xl max-w-lg w-full p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $isEditing ? 'تعديل الطبعة' : 'إضافة طبعة جديدة' }}</h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">السنة *</label>
                            <input wire:model="year" type="number" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">المدينة المقر</label>
                            <input wire:model="city" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">الاسم (بالعربية) *</label>
                        <input wire:model="name_ar" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">الاسم (بالفرنسية) *</label>
                        <input wire:model="name_fr" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">تاريخ البداية</label>
                            <input wire:model="start_date" type="date" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">تاريخ النهاية</label>
                            <input wire:model="end_date" type="date" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('formOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="save" class="px-5 py-2 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs">حفظ</button>
                </div>
            </div>
        </div>
    @endif

    {{-- DETAIL DRAWER --}}
    @if($drawerOpen && $selectedEdition)
        <div class="fixed inset-0 z-50 flex justify-end bg-slate-900/40 backdrop-blur-xs">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 border-s border-slate-200 dark:border-slate-700 h-full p-6 overflow-y-auto space-y-6 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 dark:text-slate-100">{{ $selectedEdition->name_ar }}</h2>
                        <p class="text-xs font-bold text-blue-600 font-mono">طبعة سنة {{ $selectedEdition->year }}</p>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-xl space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500">الاسم بالفرنسية:</span><span class="font-bold text-slate-800 dark:text-slate-200">{{ $selectedEdition->name_fr }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">المدينة:</span><span class="font-bold text-blue-600">{{ $selectedEdition->city ?: 'غير محددة' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">تاريخ الفعالية:</span><span class="font-bold text-slate-800 dark:text-slate-200">{{ $selectedEdition->start_date }} ← {{ $selectedEdition->end_date }}</span></div>
                </div>
            </div>
        </div>
    @endif

    {{-- CONFIRM DELETE --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-sm w-full space-y-4 text-center border border-slate-200 dark:border-slate-700 shadow-xl">
                <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">تأكيد الحذف</h3>
                <p class="text-sm text-slate-500">هل أنت متأكد من حذف هذه الطبعة؟</p>
                <div class="flex justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="deleteEdition" class="px-5 py-2 text-xs font-black text-white bg-red-600 hover:bg-red-700 rounded-xl">حذف</button>
                </div>
            </div>
        </div>
    @endif

</div>
