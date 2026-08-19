@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-5 pb-8" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER --}}
    <x-dashboard.page-header
        :title="$t('إدارة الولايات والتقسيم الجغرافي (58 ولاية)', 'Gestion des Wilayas & Régions', 'Wilayas & Geographic Regions')"
        :subtitle="$t('إجمالي الولايات: ', 'Total Wilayas: ', 'Total Wilayas: ') . $totalWilayas . ' — ' . $t('دليل التقسيمات الجغرافية الرسمية عبر كافة التراب الوطني', 'Répertoire géographique officiel', 'Official geographic directory')"
    >
        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>{{ $t('إضافة ولاية جديدة', 'Ajouter une Wilaya', 'Add New Wilaya') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- FILTERS --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ $t('بحث باسم الولاية أو الرمز...', 'Rechercher par nom ou code...', 'Search wilaya name or code...') }}"
                class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select wire:model.live="filterRegion"
            class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل المناطق', 'Toutes les Régions', 'All Regions') }}</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}">{{ $region->name_ar ?? $region->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-5 py-3.5 text-start w-16">الرمز</th>
                        <th class="px-5 py-3.5 text-start">الولاية (عربي)</th>
                        <th class="px-5 py-3.5 text-start">الولاية (فرنسي)</th>
                        <th class="px-5 py-3.5 text-start">المنطقة</th>
                        <th class="px-5 py-3.5 text-start">البلديات</th>
                        <th class="px-5 py-3.5 text-end">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($wilayas as $wilaya)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition group">
                            <td class="px-5 py-3.5 text-xs font-mono font-bold text-blue-600 dark:text-blue-400">{{ sprintf('%02d', $wilaya->code) }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900 dark:text-slate-100">
                                <button wire:click="openDrawer({{ $wilaya->id }})" class="hover:text-blue-600 transition">{{ $wilaya->name_ar }}</button>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 dark:text-slate-300 font-medium">{{ $wilaya->name_fr }}</td>
                            <td class="px-5 py-3.5">
                                @if($wilaya->region)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $wilaya->region->name_ar }}
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-xs font-bold text-slate-600 dark:text-slate-400">{{ $wilaya->communes_count }} بلدية</td>
                            <td class="px-5 py-3.5 text-end">
                                <div class="flex items-center justify-end gap-1.5 opacity-90">
                                    <button wire:click="openDrawer({{ $wilaya->id }})" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="عرض التفاصيل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="openEdit({{ $wilaya->id }})" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $wilaya->id }})" class="p-1.5 text-slate-500 hover:text-red-600 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="حذف">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400 font-medium">لا توجد ولايات مطابقة للبحث</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($wilayas->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700">{{ $wilayas->links() }}</div>
        @endif
    </div>

    {{-- MODAL FORM --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xl max-w-md w-full p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $isEditing ? 'تعديل ولاية' : 'إضافة ولاية جديدة' }}</h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">الرمز (Code) *</label>
                        <input wire:model="code" type="number" min="1" max="58" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                        @error('code') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">اسم الولاية (بالعربية) *</label>
                        <input wire:model="name_ar" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                        @error('name_ar') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">اسم الولاية (بالفرنسية) *</label>
                        <input wire:model="name_fr" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                        @error('name_fr') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">المنطقة الجغرافية</label>
                        <select wire:model="region_id" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                            <option value="">— اختر المنطقة —</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('formOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700 rounded-xl transition">إلغاء</button>
                    <button wire:click="save" class="px-5 py-2 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition shadow-xs">حفظ</button>
                </div>
            </div>
        </div>
    @endif

    {{-- DETAIL DRAWER --}}
    @if($drawerOpen && $selectedWilaya)
        <div class="fixed inset-0 z-50 flex justify-end bg-slate-900/40 backdrop-blur-xs">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 border-s border-slate-200 dark:border-slate-700 h-full p-6 overflow-y-auto space-y-6 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 dark:text-slate-100">{{ $selectedWilaya->name_ar }}</h2>
                        <p class="text-xs font-bold text-blue-600 dark:text-blue-400 font-mono">ولاية رقم {{ sprintf('%02d', $selectedWilaya->code) }}</p>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-xl space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-slate-500">الاسم بالفرنسية:</span><span class="font-bold text-slate-800 dark:text-slate-200">{{ $selectedWilaya->name_fr }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">المنطقة الجغرافية:</span><span class="font-bold text-blue-600">{{ $selectedWilaya->region?->name_ar ?? 'غير محددة' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">عدد البلديات التابعة:</span><span class="font-bold text-slate-800 dark:text-slate-200">{{ $selectedWilaya->communes->count() }} بلدية</span></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- CONFIRM DELETE --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-sm w-full space-y-4 text-center border border-slate-200 dark:border-slate-700 shadow-xl">
                <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">تأكيد الحذف</h3>
                <p class="text-sm text-slate-500">هل أنت متأكد من حذف هذه الولاية؟</p>
                <div class="flex justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="deleteWilaya" class="px-5 py-2 text-xs font-black text-white bg-red-600 hover:bg-red-700 rounded-xl">حذف</button>
                </div>
            </div>
        </div>
    @endif

</div>
