@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-6 pb-8 font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER --}}
    <x-dashboard.page-header
        :title="$t('إدارة معدات وتجهيزات التخصصات المهنية (Infrastructure List)', 'Gestion des Équipements & Infrastructures', 'Skill Equipment & Infrastructure List')"
        :subtitle="$t('إجمالي المعدات والآلات المسجلة: ', 'Total Équipements: ', 'Total Equipment Items: ') . $totalItems . ' — ' . $t('إدارة قائمة البنية التحتية والمعدات التقنية المعتمدة', 'Répertoire des équipements techniques', 'Technical infrastructure directory')"
    >
        <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-black transition backdrop-blur-md shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>{{ $t('تصدير المعدات إلى Excel (CSV)', 'Exporter vers Excel (CSV)', 'Export Equipment to Excel (CSV)') }}</span>
        </button>
        <button wire:click="openCatCreate" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-black transition backdrop-blur-md shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ $t('إضافة فئة معدات', 'Ajouter une Catégorie', 'Add Category') }}</span>
        </button>
        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>{{ $t('إضافة معدة / تجهيز لتخصص', 'Ajouter un Équipement', 'Add Equipment Item') }}</span>
        </button>
    </x-dashboard.page-header>

    @if(session('success'))
        <div class="p-3 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-xl border border-emerald-200">✓ {{ session('success') }}</div>
    @endif

    {{-- FILTERS BAR WITH SKILL SELECTOR --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 space-y-3 shadow-xs">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                {{ $t('عرض وتصفية المعدات عند اختيار التخصص المهني', 'Filtrage par Compétence & Équipements', 'Filter Equipment by Skill') }}
            </h2>
            <span class="text-[11px] text-indigo-600 dark:text-indigo-400 font-bold">كل تخصص ومعداته الرسمية</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="بحث باسم المعدة أو المواصفات..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-medium">
            </div>
            <div>
                <select wire:model.live="filterSkill" class="w-full px-3 py-2 text-xs rounded-xl border border-indigo-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-indigo-900 dark:text-sky-300">
                    <option value="">🎯 اختر التخصص المهني لعرض معداته</option>
                    @foreach($skills as $s)
                        <option value="{{ $s->id }}">{{ $s->name_ar }} ({{ $s->code }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filterCategory" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold">
                    <option value="">كل الفئات</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name_ar }} ({{ $cat->items_count }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filterType" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold">
                    <option value="">كل أنواع التجهيز</option>
                    <option value="workstation">محطة عمل / طاولة</option>
                    <option value="machine">آلة / خادم</option>
                    <option value="tool">أداة قياس ومعايرة</option>
                    <option value="ppe">معدات الوقاية الشخصية</option>
                </select>
            </div>
        </div>
    </div>

    {{-- EQUIPMENT DATA TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-start">اسم المعدة / التجهيز بالكامل</th>
                        <th class="px-5 py-3.5 text-start">التخصص المهني المخصص</th>
                        <th class="px-5 py-3.5 text-start">الفئة والتصنيف</th>
                        <th class="px-5 py-3.5 text-start">المواصفات الفنية التفصيلية</th>
                        <th class="px-5 py-3.5 text-start">مستوى السلامة</th>
                        <th class="px-5 py-3.5 text-end">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 font-black text-slate-900">
                                <button wire:click="openDrawer({{ $item->id }})" class="hover:text-indigo-600 transition text-start leading-snug">
                                    {{ $item->name_ar }}
                                </button>
                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $item->name_fr }}</div>
                            </td>
                            <td class="px-5 py-3.5 font-bold">
                                @if($item->skill)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-indigo-50 text-indigo-700 border border-indigo-200 inline-block">
                                        {{ $item->skill->name_ar }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-slate-100 text-slate-600 inline-block">
                                        عام لكافة التخصصات
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-700 font-medium">
                                {{ $item->category?->name_ar ?? '—' }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-medium max-w-xs leading-snug">
                                {{ $item->specification_details ?: '—' }}
                            </td>
                            <td class="px-5 py-3.5">
                                @if($item->safety_level === 'HIGH_HAZARD' || $item->safety_level === 'STRICT_PPE_REQUIRED')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">⚠️ سلامة وحماية خاصة</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">معياري (Standard)</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-end">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button wire:click="openEdit({{ $item->id }})" class="p-1.5 text-slate-500 hover:text-indigo-600 rounded-lg hover:bg-slate-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $item->id }})" class="p-1.5 text-slate-500 hover:text-red-600 rounded-lg hover:bg-slate-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400 font-medium">لا توجد معدات مسجلة مطابقة للفلترة الحالية</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($items->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">{{ $items->links() }}</div>
        @endif
    </div>

    {{-- CREATE/EDIT ITEM MODAL --}}
    @if($formOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white rounded-3xl p-6 w-full max-w-lg shadow-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">{{ $isEditing ? 'تعديل معدة وتجهيز تخصص' : 'إضافة معدة وتجهيز جديد للتخصص' }}</h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="space-y-3 text-xs font-semibold">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">اختر التخصص المهني المخصص *</label>
                        <select wire:model="skill_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                            <option value="">-- معدة عامة لكافة التخصصات --</option>
                            @foreach($skills as $s)
                                <option value="{{ $s->id }}">{{ $s->name_ar }} ({{ $s->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">الاسم الكامل بالعربية (بدون اختصار) *</label>
                        <input wire:model="name_ar" type="text" placeholder="مثال: محطة عمل مجهزة لشاشتين وشبكة عالية السرعة" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">الاسم بالفرنسية *</label>
                        <input wire:model="name_fr" type="text" placeholder="Station de travail haute performance" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">الفئة الرئيسية</label>
                        <select wire:model="category_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                            <option value="">-- اختر الفئة --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">المواصفات الفنية التفصيلية والمعلمات</label>
                        <textarea wire:model="specification_details" rows="3" placeholder="المعالج، الذاكرة، الدقة، التيار، المعايرة المطلوبة..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-medium"></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button wire:click="$set('formOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="save" class="px-6 py-2.5 text-xs font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md">حفظ التجهيز والمعدة</button>
                </div>
            </div>
        </div>
    @endif

</div>
