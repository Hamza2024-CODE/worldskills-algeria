@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-6 pb-8" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER --}}
    <x-dashboard.page-header
        :title="$t('إدارة الشركاء والرعاة الرسميّين', 'Gestion des Partenaires & Sponsors', 'Official Partners & Sponsors Management')"
        :subtitle="$t('إجمالي الشركاء: ', 'Total Partenaires: ', 'Total Partners: ') . $totalPartners . ' — ' . $t('إدارة وتفعيل/إيقاف ظهور الشركاء في البوابة الوطنية', 'Gestion de l\'affichage des partenaires', 'Manage partner visibility on national portal')"
    >
        <button wire:click="openCreate" class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>{{ $t('إضافة شريك جديد', 'Ajouter un Partenaire', 'Add New Partner') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- SEARCH & FILTERS --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 shadow-xs flex flex-col sm:flex-row gap-3 items-center justify-between">
        <div class="relative w-full sm:w-80">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ $t('بحث باسم الشريك...', 'Rechercher par nom...', 'Search partner name...') }}" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <select wire:model.live="filterType" class="px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                <option value="">{{ $t('كافة الأنواع والشركاء', 'Tous les types', 'All Partner Types') }}</option>
                @foreach($partnerTypes as $tOpt)
                    <option value="{{ $tOpt }}">{{ $tOpt }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterStatus" class="px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                <option value="">{{ $t('كافة الحالات', 'Tous les Statuts', 'All Statuses') }}</option>
                @foreach($statuses as $st)
                    <option value="{{ $st }}">{{ $st }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-5 py-3.5 text-start">الشعار والشريك</th>
                        <th class="px-5 py-3.5 text-start">نوع الشريك</th>
                        <th class="px-5 py-3.5 text-start">الشريك المميز</th>
                        <th class="px-5 py-3.5 text-start">الموقع الإلكتروني</th>
                        <th class="px-5 py-3.5 text-start">الحالة</th>
                        <th class="px-5 py-3.5 text-end">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($partners as $partner)
                        @php
                            $logoUrl = $partner->logo_path ? asset($partner->logo_path) : null;
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-10 rounded-xl bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 flex items-center justify-center p-1 overflow-hidden shrink-0 shadow-xs">
                                        @if($logoUrl)
                                            <img src="{{ $logoUrl }}" alt="{{ $partner->name_ar }}" class="max-h-full max-w-full object-contain">
                                        @else
                                            <span class="font-black text-xs text-blue-600 uppercase tracking-tighter">{{ mb_substr($partner->name_ar, 0, 8) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-900 dark:text-slate-100 text-xs">{{ $partner->name_ar }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">{{ $partner->name_fr ?: $partner->name_en }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 font-bold text-xs text-blue-600 dark:text-blue-400">
                                {{ $partner->partner_type }}
                            </td>
                            <td class="px-5 py-3.5">
                                <button wire:click="toggleFeatured({{ $partner->id }})" class="px-3 py-1 rounded-full text-[10px] font-black transition {{ $partner->is_featured ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $partner->is_featured ? 'شركاء مميزون ★' : 'عادي' }}
                                </button>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-500 dir-ltr text-right">
                                {{ $partner->website_url ?: '—' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <button wire:click="toggleStatus({{ $partner->id }})" class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $partner->status === 'ACTIVE' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $partner->status === 'ACTIVE' ? 'نشط' : 'غير نشط' }}
                                </button>
                            </td>
                            <td class="px-5 py-3.5 text-end">
                                <div class="flex justify-end gap-1">
                                    <button wire:click="openDrawer({{ $partner->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-slate-100 transition" title="عرض التفاصيل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="openEdit({{ $partner->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-slate-100 transition" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $partner->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-slate-100 transition" title="حذف">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-400 font-medium">
                                لا يوجد شركاء مضافين حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($partners->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700">
                {{ $partners->links() }}
            </div>
        @endif
    </div>

    {{-- CREATE / EDIT MODAL --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-lg w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $isEditing ? 'تعديل بيانات الشريك' : 'إضافة شريك جديد' }}</h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>

                <div class="space-y-3 text-xs font-semibold">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">اسم الشريك (بالعربية) *</label>
                        <input wire:model="name_ar" type="text" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                        @error('name_ar') <span class="text-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">اسم الشريك (بالفرنسية) *</label>
                            <input wire:model="name_fr" type="text" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">اسم الشريك (بالإنجليزية)</label>
                            <input wire:model="name_en" type="text" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                        </div>
                    </div>

                    <!-- Logo Upload -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">شعار الشريك (صورة الشعار Logo):</label>
                        <input type="file" wire:model="logo_file" accept="image/*" class="w-full p-2 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">نوع الشريك *</label>
                            <select wire:model="partner_type" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                                @foreach($partnerTypes as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">تصنيف التمييز</label>
                            <div class="flex items-center gap-2 mt-2">
                                <input type="checkbox" wire:model="is_featured" id="is_feat" class="w-4 h-4 text-blue-600 rounded">
                                <label for="is_feat" class="text-xs font-bold text-slate-700 dark:text-slate-300">شركاء مميزون ★</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">الموقع الإلكتروني</label>
                        <input wire:model="website_url" type="url" placeholder="https://example.com" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-mono dir-ltr">
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">الوصف بالعربية</label>
                        <textarea wire:model="description_ar" rows="2" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('formOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="save" class="px-5 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">حفظ البيانات</button>
                </div>
            </div>
        </div>
    @endif

    {{-- DETAILS DRAWER --}}
    @if($drawerOpen && $selected)
        <div class="fixed inset-0 z-50 overflow-hidden bg-slate-900/60 backdrop-blur-xs flex justify-end transition-opacity">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 h-full shadow-2xl flex flex-col justify-between overflow-y-auto p-6 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 p-1 flex items-center justify-center overflow-hidden shrink-0 shadow-xs">
                            @if($selected->logo_path)
                                <img src="{{ asset($selected->logo_path) }}" alt="{{ $selected->name_ar }}" class="max-h-full max-w-full object-contain">
                            @else
                                <span class="font-black text-xs text-blue-600 uppercase">{{ mb_substr($selected->name_ar, 0, 8) }}</span>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $selected->name_ar }}</h2>
                            <span class="text-xs font-mono font-bold text-blue-600">{{ $selected->partner_type }}</span>
                        </div>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>

                <div class="space-y-4 text-xs font-semibold flex-1">
                    <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-2xl space-y-2 border border-slate-100 dark:border-slate-600">
                        <div class="flex justify-between"><span class="text-slate-400">الاسم بالفرنسية:</span><span class="font-bold text-slate-900 dark:text-slate-100 font-mono">{{ $selected->name_fr ?? '—' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">التصنيف المميز:</span><span class="font-bold text-amber-600">{{ $selected->is_featured ? 'شركاء مميزون ★' : 'عادي' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">الموقع الإلكتروني:</span><span class="font-mono text-blue-600 dir-ltr">{{ $selected->website_url ?: '—' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">الحالة:</span><span class="font-black {{ $selected->status === 'ACTIVE' ? 'text-emerald-600' : 'text-rose-500' }}">{{ $selected->status === 'ACTIVE' ? 'نشط' : 'غير نشط' }}</span></div>
                    </div>
                </div>

                <div class="flex gap-2 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="toggleStatus({{ $selected->id }})" class="flex-1 px-3 py-2.5 rounded-xl {{ $selected->status === 'ACTIVE' ? 'bg-slate-600 hover:bg-slate-700' : 'bg-emerald-600 hover:bg-emerald-700' }} text-white font-black text-xs transition">
                        {{ $selected->status === 'ACTIVE' ? 'تعطيل الشريك' : 'تنشيط الشريك الآن' }}
                    </button>
                    <button wire:click="openEdit({{ $selected->id }})" class="flex-1 px-3 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs transition">تعديل البيانات</button>
                    <button wire:click="confirmDelete({{ $selected->id }})" class="flex-1 px-3 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs transition">حذف الشريك</button>
                </div>
            </div>
        </div>
    @endif

    {{-- DELETE CONFIRM MODAL --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-sm w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl text-center">
                <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-xl font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">تأكيد حذف الشريك</h3>
                <p class="text-xs text-slate-500 font-medium">هل أنت متأكد من رغبتك في حذف هذا الشريك من النظام؟</p>
                <div class="flex justify-center gap-2 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="deletePartner" class="px-5 py-2.5 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif

</div>
