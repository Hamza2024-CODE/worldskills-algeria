@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-5 pb-8" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER --}}
    <x-dashboard.page-header
        :title="$t('إدارة مسارات النقل والرحلات', 'Gestion des Lignes de Transport & Navettes', 'Transport Lines & Shuttle Schedules')"
        :subtitle="$t('إجمالي المسارات: ', 'Total Lignes: ', 'Total Routes: ') . $totalRoutes . ' — ' . $t('الرحلات: ', 'Trajets: ', 'Trips: ') . $totalTrips"
    >
        <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-black transition backdrop-blur-md shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>{{ $t('تصدير المسارات إلى Excel (CSV)', 'Exporter vers Excel (CSV)', 'Export Routes to Excel (CSV)') }}</span>
        </button>
        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>{{ $t('إضافة مسار', 'Ajouter une Ligne', 'Add Route') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- FILTERS --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ $t('بحث باسم المسار أو المحطة...', 'Rechercher par ligne ou station...', 'Search route or station name...') }}"
                class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select wire:model.live="filterStatus"
            class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل الحالات', 'Tous les Statuts', 'All Statuses') }}</option>
            <option value="ACTIVE">{{ $t('نشط', 'Actif', 'Active') }}</option>
            <option value="SUSPENDED">{{ $t('موقوف', 'Suspendu', 'Suspended') }}</option>
        </select>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-5 py-3.5 text-start">المسار</th>
                        <th class="px-5 py-3.5 text-start">من ← إلى</th>
                        <th class="px-5 py-3.5 text-start">السعة</th>
                        <th class="px-5 py-3.5 text-start">الرحلات</th>
                        <th class="px-5 py-3.5 text-start">الحالة</th>
                        <th class="px-5 py-3.5 text-end">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($routes as $route)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition group">
                            <td class="px-5 py-3.5 font-bold text-slate-900 dark:text-slate-100">
                                <button wire:click="openDrawer({{ $route->id }})" class="hover:text-blue-600 transition">{{ $route->name_ar }}</button>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 dark:text-slate-300 font-medium">{{ $route->origin ?: '—' }} ← {{ $route->destination ?: '—' }}</td>
                            <td class="px-5 py-3.5 font-mono text-xs font-bold text-slate-700 dark:text-slate-300">{{ $route->vehicle_capacity ?? 0 }} مقعد</td>
                            <td class="px-5 py-3.5">
                                <button wire:click="openTrips({{ $route->id }})" class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ $route->trips_count }} رحلة
                                </button>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">نشط</span>
                            </td>
                            <td class="px-5 py-3.5 text-end">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button wire:click="openEdit({{ $route->id }})" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $route->id }})" class="p-1.5 text-slate-500 hover:text-red-600 rounded-lg hover:bg-slate-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400 font-medium">لا توجد مسارات مسجلة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($routes->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700">{{ $routes->links() }}</div>
        @endif
    </div>

    {{-- MODAL FORM --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-md w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $isEditing ? 'تعديل المسار' : 'إضافة مسار جديد' }}</h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">اسم المسار (بالعربية) *</label>
                        <input wire:model="name_ar" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">اسم المسار (بالفرنسية) *</label>
                        <input wire:model="name_fr" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">الانطلاق</label>
                            <input wire:model="origin" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">الوصول</label>
                            <input wire:model="destination" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
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

</div>
