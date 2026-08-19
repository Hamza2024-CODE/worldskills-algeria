@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-6" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
    <!-- Header -->
    <x-dashboard.page-header
        :title="$t('إدارة المؤسسات التكوينية والمعاهد (SIG)', 'Gestion des Établissements & Instituts (SIG)', 'Training Institutes & Centers Management (SIG)')"
        :subtitle="$t('محتوى المستودع الوطني للمؤسسات المعاهد ومراكز التكوين المهني والتمهين عبر الـ 58 ولاية', 'Répertoire national des établissements et centres de formation professionnelle à travers les 58 wilayas.', 'National directory of vocational training institutes across all 58 wilayas.')"
    >
        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>{{ $t('إضافة مؤسسة جديدة', 'Ajouter un Établissement', 'Add New Institution') }}</span>
        </button>
    </x-dashboard.page-header>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400">{{ $t('إجمالي المؤسسات المسجلة', 'Total Établissements', 'Total Institutions') }}</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalOrgs) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-brand-500 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400">{{ $t('المؤسسات المعتمدة والنشطة', 'Établissements Actifs', 'Active Institutions') }}</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($activeOrgs) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400">{{ $t('تغطية الولايات الوطنية', 'Couverture des Wilayas', 'National Coverage') }}</p>
                <p class="text-2xl font-black text-brand-600 dark:text-brand-400 mt-1">58 / 58</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            </div>
        </div>
    </div>

    <!-- Filters & Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row gap-3 justify-between">
            <div class="flex-1 max-w-sm">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ $t('بحث باسم المؤسسة أو كود SIG...', 'Rechercher par nom ou code SIG...', 'Search by institution name or SIG code...') }}" class="w-full px-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-xs text-slate-800 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div class="flex flex-wrap gap-2">
                <select wire:model.live="filterWilaya" class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-xs text-slate-700 dark:text-slate-100 font-bold focus:outline-none">
                    <option value="">{{ $t('جميع الولايات (58 ولاية)', 'Toutes les Wilayas (58)', 'All Wilayas (58)') }}</option>
                    @foreach($wilayas as $w)
                        <option value="{{ $w->id }}">{{ $w->code }} - {{ $w->name_ar ?? $w->name }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterType" class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-xs text-slate-700 dark:text-slate-100 font-bold focus:outline-none">
                    <option value="">{{ $t('جميع أنواع المؤسسات', 'Tous les types d\'établissements', 'All Institution Types') }}</option>
                    @foreach($orgTypes as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-3">رمز المؤسسة</th>
                        <th class="p-3">اسم المؤسسة</th>
                        <th class="p-3">النوع</th>
                        <th class="p-3">الولاية</th>
                        <th class="p-3">رقم الهاتف / البريد</th>
                        <th class="p-3">الحالة</th>
                        <th class="p-3 text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($organizations as $org)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3 font-mono font-bold text-slate-500 text-[11px]">
                                {{ $org->code }}
                            </td>
                            <td class="p-3 font-bold text-slate-900">
                                <div>{{ $org->name_ar }}</div>
                                <div class="text-[10px] text-slate-400 font-normal font-sans">{{ $org->name_fr }}</div>
                            </td>
                            <td class="p-3">
                                @php
                                    $badgeStyle = match(strtolower($org->type)) {
                                        'insfp' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        'ifep'  => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'cfppa' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-md font-mono font-bold text-[10px] uppercase border {{ $badgeStyle }}">
                                    {{ strtoupper($org->type) }}
                                </span>
                            </td>
                            <td class="p-3 text-slate-700 font-bold">
                                {{ $org->wilaya ? ($org->wilaya->code . ' - ' . $org->wilaya->name_ar) : '—' }}
                            </td>
                            <td class="p-3 font-mono text-slate-500">
                                @if($org->phone) <span class="block text-[11px]">{{ $org->phone }}</span> @endif
                                @if($org->email) <span class="block text-[10px] text-slate-400">{{ $org->email }}</span> @endif
                                @if(!$org->phone && !$org->email) — @endif
                            </td>
                            <td class="p-3">
                                <button wire:click="toggleActive({{ $org->id }})" class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $org->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $org->is_active ? 'نشطة' : 'معطلة' }}
                                </button>
                            </td>
                            <td class="p-3 text-left">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="openDrawer({{ $org->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-slate-100 transition" title="عرض التفاصيل"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                                    <button wire:click="openEdit({{ $org->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-slate-100 transition" title="تعديل"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                    <button wire:click="confirmDelete({{ $org->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-slate-100 transition" title="حذف"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 font-medium">لا توجد مؤسسات مطابقة لخيارات البحث.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($organizations->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $organizations->links() }}
            </div>
        @endif
    </div>

    <!-- Create / Edit Form Modal -->
    @if($formOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white rounded-3xl p-6 max-w-lg w-full space-y-4 border border-slate-200 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">{{ $isEditing ? 'تعديل بيانات المؤسسة' : 'إضافة مؤسسة جديدة' }}</h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600">✕</button>
                </div>
                <form wire:submit.prevent="save" class="space-y-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">رمز المؤسسة (Code)</label>
                        <input type="text" wire:model="code" placeholder="مثال: SIG-108" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">الاسم بالعربية *</label>
                        <input type="text" wire:model="name_ar" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">الاسم بالفرنسية *</label>
                        <input type="text" wire:model="name_fr" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">نوع المؤسسة</label>
                            <select wire:model="type" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold focus:outline-none">
                                @foreach($orgTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">الولاية</label>
                            <select wire:model="wilaya_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold focus:outline-none">
                                <option value="">اختر الولاية...</option>
                                @foreach($wilayas as $w)
                                    <option value="{{ $w->id }}">{{ $w->code }} - {{ $w->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">رقم الهاتف</label>
                            <input type="text" wire:model="phone" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">البريد الإلكتروني</label>
                            <input type="email" wire:model="email" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">العنوان</label>
                        <input type="text" wire:model="address" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold focus:outline-none">
                    </div>
                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" wire:click="$set('formOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                        <button type="submit" class="px-5 py-2 text-xs font-black text-white bg-brand-500 hover:bg-brand-600 rounded-xl shadow-md">حفظ البيانات</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Drawer Details Modal -->
    @if(($drawerOpen ?? false) && ($selected ?? null))
        <div class="fixed inset-0 z-50 flex justify-end bg-slate-900/40 backdrop-blur-xs">
            <div class="bg-white w-full max-w-md h-full p-6 space-y-6 overflow-y-auto shadow-2xl border-r border-slate-200 animate-in slide-in-from-right duration-200">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-[10px] font-mono font-bold text-brand-600 bg-brand-50 px-2.5 py-1 rounded-full uppercase border border-brand-200">{{ $selected->code }}</span>
                        <h3 class="text-base font-black text-slate-900 mt-2">{{ $selected->name_ar }}</h3>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="text-slate-400 hover:text-slate-600">✕</button>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">الاسم بالفرنسية</span>
                        <p class="font-bold text-slate-800">{{ $selected->name_fr }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">النوع</span>
                            <p class="font-bold text-slate-800 uppercase">{{ $selected->type }}</p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">الولاية</span>
                            <p class="font-bold text-slate-800">{{ $selected->wilaya ? ($selected->wilaya->code . ' - ' . $selected->wilaya->name_ar) : '—' }}</p>
                        </div>
                    </div>

                    @if($selected->phone)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">رقم الهاتف</span>
                            <p class="font-mono font-bold text-slate-800">{{ $selected->phone }}</p>
                        </div>
                    @endif

                    @if($selected->email)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">البريد الإلكتروني</span>
                            <p class="font-mono font-bold text-slate-800">{{ $selected->email }}</p>
                        </div>
                    @endif

                    @if($selected->address)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">العنوان الكامل</span>
                            <p class="font-bold text-slate-800">{{ $selected->address }}</p>
                        </div>
                    @endif
                </div>

                <div class="pt-4 border-t border-slate-100 flex gap-2">
                    <button wire:click="openEdit({{ $selected->id }}); $set('drawerOpen', false);" class="flex-1 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md transition">تعديل البيانات</button>
                    <button wire:click="$set('drawerOpen', false)" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">إغلاق</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($deleteConfirmOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white rounded-2xl p-6 max-w-sm w-full space-y-4 border border-slate-200 shadow-xl">
                <h3 class="text-base font-black text-slate-900">تأكيد حذف المؤسسة</h3>
                <p class="text-xs text-slate-600">هل أنت متأكد من رغبتك في حذف هذه المؤسسة نهائياً؟</p>
                <div class="flex justify-end gap-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="deleteOrg" class="px-5 py-2 text-xs font-black text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-xs">حذف</button>
                </div>
            </div>
        </div>
    @endif
</div>
