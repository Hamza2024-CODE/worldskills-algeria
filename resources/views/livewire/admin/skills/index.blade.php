@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-5 pb-8"
     x-data="{ formOpen: $wire.entangle('formOpen'), drawerOpen: $wire.entangle('drawerOpen'), deleteConfirmOpen: $wire.entangle('deleteConfirmOpen'), pdfModalOpen: $wire.entangle('pdfModalOpen') }">

    {{-- ── Page Header ── --}}
    <x-dashboard.page-header
        :title="$t('إدارة التخصصات الأولمبية، الصور، والكراسات التقنية (PDF)', 'Gestion des Compétences, Photos & PDFs', 'Skills, Photos & Technical Description Management')"
        :subtitle="$totalSkills . ' ' . $t('تخصص أولمبي معتمد', 'compétences homologuées', 'accredited skills') . ' — ' . $activeSkills . ' ' . $t('نشط', 'actives', 'active')"
    >
        <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-black transition backdrop-blur-md shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>تصدير إلى Excel (CSV)</span>
        </button>
        <button wire:click="openCreate"
                class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            {{ $t('إضافة تخصص جديد', 'Ajouter Compétence', 'Add New Skill') }}
        </button>
    </x-dashboard.page-header>

    {{-- ── Filters ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <svg class="absolute {{ $locale==='ar'?'end-3':'start-3' }} top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input wire:model.live.debounce.300ms="search" type="search"
                   placeholder="{{ $t('بحث بالاسم، الكود، أو ملف الـ PDF...', 'Rechercher...', 'Search name, code, or PDF...') }}"
                   class="w-full {{ $locale==='ar'?'pe-10 ps-4':'ps-10 pe-4' }} py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <select wire:model.live="filterCategory"
                class="px-3 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل الفئات والتخصصات', 'Toutes catégories', 'All Categories') }}</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name_ar ?? $cat->name_fr ?? $cat->name }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterStatus"
                class="px-3 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل الحالات', 'Tous statuts', 'All Statuses') }}</option>
            <option value="1">{{ $t('نشط', 'Actif', 'Active') }}</option>
            <option value="0">{{ $t('معطل', 'Désactivé', 'Inactive') }}</option>
        </select>
    </div>

    {{-- ── Skills Grid ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-5 py-3.5 text-start w-8">#</th>
                        <th class="px-5 py-3.5 text-start">{{ $t('التخصص والصورة المرفقة', 'Compétence & Photo', 'Skill & Photo') }}</th>
                        <th class="px-5 py-3.5 text-start hidden md:table-cell">{{ $t('الاسم بالفرنسية', 'Français', 'French Name') }}</th>
                        <th class="px-5 py-3.5 text-start hidden lg:table-cell">{{ $t('الفئة / القطاع', 'Catégorie', 'Category') }}</th>
                        <th class="px-5 py-3.5 text-start">{{ $t('ملف التوصيف الفني (PDF)', 'Fiche Technique PDF', 'Technical Description PDF') }}</th>
                        <th class="px-5 py-3.5 text-start">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                        <th class="px-5 py-3.5 text-end">{{ $t('الإجراءات', 'Actions', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($skills as $skill)
                        @php $pdfUrl = $skill->getPdfUrl(); @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition group">
                            <td class="px-5 py-3.5 text-xs font-mono font-bold text-slate-400">{{ $skill->sort_order }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-10 rounded-xl bg-slate-900 overflow-hidden shrink-0 border border-slate-200 relative shadow-xs">
                                        <img src="{{ $skill->getImageUrl() }}"
                                             alt="{{ $skill->name_ar }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <button wire:click="openDrawer({{ $skill->id }})" class="text-sm font-black text-slate-900 dark:text-slate-100 hover:text-blue-600 dark:hover:text-blue-400 block text-start">
                                            {{ $skill->name_ar ?? '—' }}
                                        </button>
                                        @if($skill->code)
                                            <span class="text-[10px] font-mono font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md border border-blue-200 inline-block mt-0.5">{{ $skill->code }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell text-sm font-medium text-slate-600 dark:text-slate-300">{{ $skill->name_fr ?? '—' }}</td>
                            <td class="px-5 py-3.5 hidden lg:table-cell">
                                @if($skill->category)
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300 border border-purple-200">
                                        {{ $skill->category->name_ar ?? $skill->category->name_fr ?? '—' }}
                                    </span>
                                @else
                                    <span class="text-slate-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                @if($pdfUrl)
                                    <button wire:click="openPdfModal({{ $skill->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 text-blue-600 dark:text-blue-300 border border-blue-200 dark:border-blue-800 text-xs font-bold transition">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z"/></svg>
                                        <span>عرض ملف PDF</span>
                                    </button>
                                @else
                                    <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200">غير مرفق</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <button wire:click="toggleActive({{ $skill->id }})"
                                        class="px-2.5 py-1 rounded-full text-xs font-bold transition {{ $skill->is_active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                    {{ $skill->is_active ? $t('نشط ومعتمد', 'Actif', 'Active') : $t('معطل', 'Désactivé', 'Disabled') }}
                                </button>
                            </td>
                            <td class="px-5 py-3.5 text-end">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="openEdit({{ $skill->id }})"
                                            title="تعديل التخصص والصور والـ PDF"
                                            class="p-2 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $skill->id }})"
                                            title="حذف التخصص"
                                            class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-321q-.412 0-.766.196L17.25 4.5H6.75L5.548 6.196Q5.194 6 4.782 6H3.75m16.5 0v11.25A2.25 2.25 0 0118 19.5H6a2.25 2.25 0 01-2.25-2.25V6m16.5 0H3.75"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400 text-sm font-bold">
                                {{ $t('لا توجد تخصصات مطابقة لخيارات البحث.', 'Aucune compétence trouvée.', 'No skills found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($skills->hasPages())
            <div class="px-5 py-3.5 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/30">
                {{ $skills->links() }}
            </div>
        @endif
    </div>

    {{-- ════ CREATE / EDIT FORM MODAL ════ --}}
    <div x-show="formOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 space-y-5 max-h-[90vh] overflow-y-auto" @click.away="formOpen = false">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">
                    {{ $isEditing ? 'تعديل بيانات التخصص والصور والـ PDF' : 'إضافة تخصص جديد' }}
                </h3>
                <button type="button" @click="formOpen = false" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
            </div>

            <form wire:submit="save" class="space-y-4">
                
                {{-- Names --}}
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 block">اسم التخصص بالعربية *</label>
                        <input wire:model="name_ar" type="text" placeholder="مثال: الميكانيكا الصناعية والمحركات" class="w-full px-3 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white">
                        @error('name_ar') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 block">الاسم بالفرنسية *</label>
                            <input wire:model="name_fr" type="text" placeholder="Mécanique Industrielle" class="w-full px-3 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white">
                            @error('name_fr') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 block">الاسم بالإنكليزية</label>
                            <input wire:model="name_en" type="text" placeholder="Industrial Mechanics" class="w-full px-3 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>
                    </div>
                </div>

                {{-- Code & Category --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 block">كود التخصص المعياري</label>
                        <input wire:model="code" type="text" placeholder="SKILL-01" class="w-full px-3 py-2.5 text-xs font-mono font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 block">القطاع / الفئة</label>
                        <select wire:model="category_id" class="w-full px-3 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white">
                            <option value="">اختيار الفئة</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Trade Image Upload & Image Path --}}
                <div class="p-4 rounded-2xl bg-purple-50/60 dark:bg-purple-950/40 border border-purple-200 dark:border-purple-800 space-y-3">
                    <label class="text-xs font-black text-purple-900 dark:text-purple-200 block flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>رفع صورة التخصص / تعديل رابط الصورة:</span>
                    </label>
                    <input type="file" wire:model="image_file" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-purple-600 file:text-white hover:file:bg-purple-700">
                    <input wire:model="image_path" type="text" placeholder="أو أدخل رابط صورة مباشر URL..." class="w-full px-3 py-2 text-xs font-mono rounded-xl border border-purple-200 dark:border-purple-700 bg-white dark:bg-slate-900 dark:text-white">
                </div>

                {{-- Age limits --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 block">الحد الأدنى للأعمار</label>
                        <input wire:model="min_age" type="number" placeholder="16" class="w-full px-3 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 block">الحد الأقصى للأعمار</label>
                        <input wire:model="max_age" type="number" placeholder="25" class="w-full px-3 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                </div>

                {{-- PDF Upload Input & Path --}}
                <div class="p-4 rounded-2xl bg-blue-50/60 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 space-y-3">
                    <label class="text-xs font-black text-blue-900 dark:text-blue-200 block flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <span>رفع / تعديل ملف التوصيف الفني (PDF):</span>
                    </label>
                    <input type="file" wire:model="pdf_file" accept=".pdf" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <input wire:model="pdf_path" type="text" placeholder="أو أدخل مسار ملف PDF مباشر (مثال: docs/td/WSC2026_TD01_en.pdf)..." class="w-full px-3 py-2 text-xs font-mono rounded-xl border border-blue-200 dark:border-blue-700 bg-white dark:bg-slate-900 dark:text-white">
                    @error('pdf_file') <span class="text-xs text-rose-500 font-bold block">{{ $message }}</span> @enderror
                    <p class="text-[10px] text-slate-500 font-medium">يمكنك رفع ملف PDF جديد أو إدخال مسار كراسة التخصص المعتمدة يدويًا.</p>
                </div>

                {{-- Description AR --}}
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 block">الوصف والتفاصيل بالعربية</label>
                    <textarea wire:model="description_ar" rows="3" class="w-full px-3 py-2 text-xs font-medium rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white"></textarea>
                </div>

                {{-- Status & Submit --}}
                <div class="flex items-center justify-between pt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="w-4 h-4 text-blue-600 rounded border-slate-300">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">تفعيل وتنشيط التخصص</span>
                    </label>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs transition shadow-sm">
                        {{ $isEditing ? 'حفظ التعديلات والملف' : 'إضافة التخصص والملف' }}
                    </button>
                    <button type="button" @click="formOpen = false" class="flex-1 px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 font-black text-xs text-slate-600 dark:text-slate-300">
                        إلغاء
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ════ IN-PLATFORM PDF PREVIEW MODAL FOR ADMIN ════ --}}
    <div x-show="pdfModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-5xl h-[92vh] flex flex-col overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-700">
            {{-- Modal Top Header --}}
            <div class="px-6 py-4 bg-[#06205C] text-white flex items-center justify-between border-b border-blue-900 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center font-black">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white leading-tight">{{ $pdfModalTitle ?? 'معاينة ملف التوصيف الفني PDF' }}</h3>
                        <span class="text-[10px] text-amber-300 font-mono font-bold block">مستند التوصيف الفني والمعايير المعتمد — WorldSkills</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @if($pdfModalUrl)
                        <a href="{{ $pdfModalUrl }}" download class="px-3.5 py-1.5 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-950 font-black text-xs transition shadow-sm flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>تحميل نسخة</span>
                        </a>
                    @endif
                    <button wire:click="closePdfModal" class="p-2 text-white/70 hover:text-white font-bold text-lg">✕</button>
                </div>
            </div>

            {{-- PDF Iframe Body --}}
            <div class="flex-1 bg-slate-100 dark:bg-slate-950 p-2 overflow-hidden">
                @if($pdfModalUrl)
                    <iframe src="{{ $pdfModalUrl }}#toolbar=1&navpanes=0" class="w-full h-full rounded-2xl border border-slate-300 dark:border-slate-800 shadow-inner"></iframe>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 font-bold space-y-3">
                        <svg class="w-16 h-16 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p>لا يوجد ملف PDF مخصص لهذا التخصص حالياً.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
