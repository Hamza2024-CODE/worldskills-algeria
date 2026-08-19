@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-6" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
    <!-- Header -->
    <x-dashboard.page-header
        :title="$t('إدارة الدول المشاركة والوفود الوطنية', 'Gestion des Pays & Délégations Nationales', 'Participating Countries & Delegations Management')"
        :subtitle="$t('إدارة واعتماد الوفود الوطنية والبلدان المشاركة في مسابقة WorldSkills Algeria', 'Gestion et accréditation des pays africains et délégations nationales.', 'Manage and accredit participating African nations and delegations.')"
    >
        <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-black transition backdrop-blur-md shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>{{ $t('تصدير الدول والوفود إلى Excel (CSV)', 'Exporter vers Excel (CSV)', 'Export Countries to Excel (CSV)') }}</span>
        </button>
        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-lg transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>{{ $t('إضافة دولة جديدة', 'Ajouter un Nouveau Pays', 'Add New Country') }}</span>
        </button>
    </x-dashboard.page-header>

    <!-- Stats Bar -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400">{{ $t('إجمالي الدول المشاركة', 'Total Pays Participants', 'Total Participating Countries') }}</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalCountries) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-brand-500 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V8.5M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400">{{ $t('الدول المعتمجة والنشطة', 'Pays Actifs & Accrédités', 'Active Accreditated Nations') }}</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($activeCountries) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400">{{ $t('نسبة التغطية الأفريقية', 'Couverture Africaine', 'African Coverage') }}</p>
                <p class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1">{{ round(($activeCountries / 54) * 100) }}%</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
    </div>

    <!-- Filters & Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row gap-3 justify-between">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث باسم الدولة أو الترميز..." class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 max-w-xs">
            <select wire:model.live="filterStatus" class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 font-bold focus:outline-none">
                <option value="">جميع الحالات</option>
                <option value="1">مفعّلة</option>
                <option value="0">معطّلة</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-3">الدولة</th>
                        <th class="p-3">الرمز ISO</th>
                        <th class="p-3">الرمز / القارة</th>
                        <th class="p-3">عدد التسجيلات</th>
                        <th class="p-3">الحالة</th>
                        <th class="p-3 text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($countries as $c)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3 font-bold text-slate-900">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 font-black text-xs flex items-center justify-center border border-blue-100 shrink-0">
                                        {{ mb_substr($c->name_ar, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-900 text-xs">{{ $c->name_ar }}</div>
                                        <div class="text-[10px] text-slate-400 font-normal font-mono">{{ $c->name_fr }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3 font-mono font-bold text-brand-600">{{ $c->iso2 ?? $c->code }}</td>
                            <td class="p-3 text-slate-600">{{ $c->continent ?? $c->iso3 ?? '—' }}</td>
                            <td class="p-3 font-mono font-bold text-slate-700">{{ $c->registrations_count ?? 0 }}</td>
                            <td class="p-3">
                                <button wire:click="toggleActive({{ $c->id }})" class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $c->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $c->is_active ? 'نشطة' : 'غير نشطة' }}
                                </button>
                            </td>
                            <td class="p-3 text-left">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="openDrawer({{ $c->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-slate-100 transition" title="التفاصيل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="openEdit({{ $c->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-slate-100 transition" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $c->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-slate-100 transition" title="حذف">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 font-medium">لا توجد دول مطابقة لخيارات البحث.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($countries->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $countries->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Form Modal -->
    @if($formOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white rounded-3xl p-6 max-w-lg w-full space-y-4 border border-slate-200 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">{{ $isEditing ? 'تعديل بيانات الدولة' : 'إضافة دولة جديدة' }}</h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form wire:submit.prevent="save" class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">الاسم بالعربية *</label>
                            <input type="text" wire:model="name_ar" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">الاسم بالفرنسية *</label>
                            <input type="text" wire:model="name_fr" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">الرمز (ISO2 / Code)</label>
                            <input type="text" wire:model="code" placeholder="DZ" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">القارة</label>
                            <input type="text" wire:model="continent" placeholder="أفريقيا" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" wire:click="$set('formOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                        <button type="submit" class="px-5 py-2 text-xs font-black text-white bg-brand-500 hover:bg-brand-600 rounded-xl shadow-md">حفظ البيانات</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- COUNTRY DETAILS DRAWER -->
    @if(($drawerOpen ?? false) && ($selected ?? null))
        <div class="fixed inset-0 z-50 overflow-hidden bg-slate-900/60 backdrop-blur-xs flex justify-end transition-opacity">
            <div class="w-full max-w-md bg-white h-full shadow-2xl flex flex-col justify-between overflow-y-auto p-6 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-brand-600 flex items-center justify-center text-xl font-black shrink-0 border border-blue-100">
                            {{ mb_substr($selected->name_ar, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-slate-900">{{ $selected->name_ar }}</h2>
                            <span class="text-xs font-mono font-bold text-brand-600">{{ $selected->code }}</span>
                        </div>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4 text-xs font-semibold flex-1">
                    <div class="bg-slate-50 p-4 rounded-2xl space-y-2.5 border border-slate-100">
                        <div class="flex justify-between"><span class="text-slate-400">الاسم بالفرنسية:</span><span class="font-bold text-slate-900 font-mono">{{ $selected->name_fr ?? '—' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">الاسم بالإنجليزية:</span><span class="font-bold text-slate-900 font-mono">{{ $selected->name_en ?? '—' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">القارة:</span><span class="font-bold text-purple-600">{{ $selected->continent ?? 'أفريقيا' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">عدد المشاركين المعتمدين:</span><span class="font-black text-brand-600 text-sm font-mono">{{ $selected->registrations_count ?? 0 }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">الحالة:</span><span class="font-black {{ $selected->is_active ? 'text-emerald-600' : 'text-slate-400' }}">{{ $selected->is_active ? 'نشطة' : 'معطلة' }}</span></div>
                    </div>
                </div>

                <div class="flex gap-2 pt-4 border-t border-slate-100">
                    <button wire:click="openEdit({{ $selected->id }})" class="flex-1 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs transition">تعديل البيانات</button>
                    <button wire:click="confirmDelete({{ $selected->id }})" class="flex-1 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs transition">حذف الدولة</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($deleteConfirmOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white rounded-3xl p-6 max-w-sm w-full space-y-4 border border-slate-200 shadow-2xl text-center">
                <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-xl font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-base font-black text-slate-900">تأكيد حذف الدولة</h3>
                <p class="text-xs text-slate-600">هل أنت متأكد من رغبتك في حذف هذه الدولة من النظام؟ هذا الإجراء لا يمكن التراجع عنه.</p>
                <div class="flex justify-center gap-2 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="deleteCountry" class="px-5 py-2 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif
</div>
