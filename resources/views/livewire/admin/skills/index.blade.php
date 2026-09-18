<div class="space-y-6 pb-16">
    <!-- TOP HEADER BAR -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-slate-800/90 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs backdrop-blur-md">
        <div class="flex items-center gap-3.5">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700 text-white flex items-center justify-center font-black shadow-lg shadow-blue-600/20 border border-blue-400/40">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.606 15.12a2 2 0 01-1.022-.547l-1.096-1.096a2 2 0 010-2.828l1.096-1.096a2 2 0 011.022-.547l2.387-.477a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.022.547l1.096 1.096a2 2 0 010 2.828l-1.096 1.096z"/></svg>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    إدارة التخصصات والمهارات الأولمبية
                </h1>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-0.5">
                    إدارة المعايير الفنية، صور التخصصات، ملفات التوصيف PDF، والتحكم بإظهار التخصصات في الصفحة الرئيسية
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <button wire:click="exportExcel" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs transition flex items-center gap-2 border border-slate-200/60 dark:border-slate-600/60 shadow-xs">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>تصدير القائمة CSV</span>
            </button>
            <button wire:click="openCreate" class="px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 active:scale-98 text-white font-black text-xs transition flex items-center gap-2 shadow-lg shadow-blue-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>إضافة تخصص جديد</span>
            </button>
        </div>
    </div>

    <!-- STATS CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Skills -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">إجمالي التخصصات المعترف بها</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1 font-mono">{{ number_format($totalSkills) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
        </div>

        <!-- Card 2: Active Skills -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">التخصصات النشطة للتسجيل</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1 font-mono">{{ number_format($activeSkills) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- Card 3: Visible on Homepage -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">المعروضة بالصفحة الرئيسية</p>
                <p class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1 font-mono">{{ number_format($homepageSkillsCount) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
        </div>

        <!-- Card 4: Technical Description PDFs -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">ملفات التوصيف الفني (PDF)</p>
                <p class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1 font-mono">{{ number_format($skillsWithPdfCount) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
    </div>

    <!-- FILTER TOOLBAR & TABLE CARD -->
    <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs overflow-hidden backdrop-blur-md">
        <!-- Search & Filter Controls -->
        <div class="p-5 border-b border-slate-100 dark:border-slate-700/60 flex flex-col xl:flex-row gap-3 items-stretch xl:items-center justify-between">
            <!-- Search Bar -->
            <div class="relative flex-1 min-w-[240px] max-w-md">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث باسم التخصص (عربي / فرنسي) أو الكود..." class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="absolute left-3 top-3 text-slate-400 pointer-events-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Filters Grid Row -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                <!-- Category Filter -->
                <select wire:model.live="filterCategory" class="px-3 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع القطاعات والمهن</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name_ar }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select wire:model.live="filterStatus" class="px-3 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع الحالات</option>
                    <option value="1">نشط ومفعل للتسجيل</option>
                    <option value="0">معطّل</option>
                </select>

                <!-- Homepage Filter -->
                <select wire:model.live="filterHomepageStatus" class="px-3 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">عرض الصفحة الرئيسية</option>
                    <option value="1">ظاهر بالصفحة الرئيسية</option>
                    <option value="0">مخفي من الرئيسية</option>
                </select>

                <!-- PDF Filter -->
                <select wire:model.live="filterPdfStatus" class="px-3 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">ملفات PDF</option>
                    <option value="has_pdf">بها ملف توصيف PDF</option>
                    <option value="no_pdf">بدون ملف توصيف</option>
                </select>
            </div>
        </div>

        <!-- TABLE OF SKILLS -->
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-700/60">
                    <tr>
                        <th class="p-4 text-start whitespace-nowrap min-w-[220px]">الصورة والتخصص</th>
                        <th class="p-4 text-center whitespace-nowrap">الكود والأعمار</th>
                        <th class="p-4 text-center whitespace-nowrap">القطاع والمهنة</th>
                        <th class="p-4 text-center whitespace-nowrap">الملف الوصفي (PDF)</th>
                        <th class="p-4 text-center whitespace-nowrap">عرض بالرئيسية</th>
                        <th class="p-4 text-center whitespace-nowrap">تفعيل التسجيل</th>
                        <th class="p-4 text-center whitespace-nowrap min-w-[130px]">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-medium">
                    @forelse($skills as $skill)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition">
                            <!-- Skill Cover & Name -->
                            <td class="p-4 font-bold text-slate-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="relative w-12 h-12 rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 shrink-0 shadow-xs">
                                        <img src="{{ $skill->getImageUrl() }}" alt="{{ $skill->name_ar }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-900 dark:text-white text-xs">
                                            {{ $skill->name_ar }}
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-normal font-mono mt-0.5">
                                            {{ $skill->name_fr }} {{ $skill->name_en ? '• ' . $skill->name_en : '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Code & Age Limit -->
                            <td class="p-4 text-center whitespace-nowrap">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="px-2.5 py-0.5 rounded-xl font-mono font-black text-xs bg-slate-100 dark:bg-slate-900 text-blue-600 dark:text-blue-400 border border-slate-200 dark:border-slate-700">
                                        {{ $skill->code ?: ('SKILL-' . str_pad($skill->id, 2, '0', STR_PAD_LEFT)) }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                        {{ $skill->min_age ?? 16 }} - {{ $skill->max_age ?? 25 }} سنة
                                    </span>
                                </div>
                            </td>

                            <!-- Category / Sector -->
                            <td class="p-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-[11px] font-black bg-blue-50 text-blue-700 border border-blue-200/80 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800/60 whitespace-nowrap">
                                    {{ $skill->category?->name_ar ?? 'عام' }}
                                </span>
                            </td>

                            <!-- Technical Description PDF Action (In-Platform Viewer) -->
                            <td class="p-4 text-center whitespace-nowrap">
                                @if($skill->getPdfUrl())
                                    <button wire:click="openPdfModal({{ $skill->id }})" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-purple-50 hover:bg-purple-100 dark:bg-purple-950/80 dark:hover:bg-purple-900 text-purple-700 dark:text-purple-300 font-bold text-[11px] border border-purple-200 dark:border-purple-800 transition shadow-xs whitespace-nowrap">
                                        <span>معاينة PDF المباشرة</span>
                                        <svg class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                @else
                                    <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                        غير مرفق
                                    </span>
                                @endif
                            </td>

                            <!-- Homepage Display Toggle Switch -->
                            <td class="p-4 text-center whitespace-nowrap">
                                <button wire:click="toggleHomepage({{ $skill->id }})" class="inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black transition border whitespace-nowrap {{ ($skill->show_on_homepage ?? true) ? 'bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800/60 hover:bg-amber-100' : 'bg-slate-100 text-slate-500 border-slate-200 dark:bg-slate-900 dark:text-slate-400 dark:border-slate-700 hover:bg-slate-200' }}">
                                    <svg class="w-3 h-3 {{ ($skill->show_on_homepage ?? true) ? 'text-amber-600' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>{{ ($skill->show_on_homepage ?? true) ? 'ظاهر بالرئيسية' : 'مخفي' }}</span>
                                </button>
                            </td>

                            <!-- Active Registration Toggle Switch -->
                            <td class="p-4 text-center whitespace-nowrap">
                                <button wire:click="toggleActive({{ $skill->id }})" class="inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black transition border whitespace-nowrap {{ $skill->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800/60 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-200 dark:bg-slate-900 dark:text-slate-400 dark:border-slate-700 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $skill->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }} shrink-0"></span>
                                    <span>{{ $skill->is_active ? 'نشط ومفعل' : 'معطّلة' }}</span>
                                </button>
                            </td>

                            <!-- Actions Column -->
                            <td class="p-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button wire:click="openDrawer({{ $skill->id }})" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 transition" title="عرض التفاصيل كاملة">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="openEdit({{ $skill->id }})" class="p-2 rounded-xl bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 transition border border-amber-200 dark:border-amber-800/60" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $skill->id }})" class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 transition border border-rose-200 dark:border-rose-800/60" title="حذف">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400 dark:text-slate-500 font-bold">
                                لا توجد تخصصات مطابقة لخيارات البحث.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($skills->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/30">
                {{ $skills->links() }}
            </div>
        @endif
    </div>

    <!-- IN-PLATFORM PDF VIEWER MODAL (عرض داخل المنصة دون الخروج) -->
    @if(($pdfModalOpen ?? false) && !empty($pdfModalUrl))
        <div class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6 bg-slate-900/80 backdrop-blur-md transition-all">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-5xl w-full h-[88vh] flex flex-col overflow-hidden border border-slate-200 dark:border-slate-700 shadow-2xl">
                <!-- Modal Header -->
                <div class="p-4 px-6 bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">
                                {{ $pdfModalTitle ?? 'عرض ملف التوصيف الفني (Technical Description)' }}
                            </h3>
                            <p class="text-[10px] font-bold text-slate-400">قارئ المستندات الرسمي المدمج في المنصة — WorldSkills</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ $pdfModalUrl }}" download class="px-3 py-1.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs transition flex items-center gap-1.5 shadow-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>تحميل PDF</span>
                        </a>
                        <button wire:click="closePdfModal" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <!-- PDF Embedded View -->
                <div class="flex-1 bg-slate-900 relative">
                    <iframe src="{{ $pdfModalUrl }}" class="w-full h-full border-0"></iframe>
                </div>
            </div>
        </div>
    @endif

    <!-- CREATE / EDIT SKILL MODAL -->
    @if($formOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-xs transition-all">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 space-y-5 border border-slate-200 dark:border-slate-700 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span>{{ $isEditing ? 'تعديل بيانات التخصص والتوصيف الفني' : 'إضافة تخصص أولمبي جديد' }}</span>
                    </h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4 text-xs font-bold">
                    <!-- Names AR / FR -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">اسم التخصص بالعربية *</label>
                            <input type="text" wire:model="name_ar" required placeholder="مثال: التركيبات الكهربائية" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">اسم التخصص بالفرنسية *</label>
                            <input type="text" wire:model="name_fr" required placeholder="مثال: Installations Électriques" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Code & Category -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">الكود الرسمي (Skill Code)</label>
                            <input type="text" wire:model="code" placeholder="SKILL-01" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-mono font-bold uppercase text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">القطاع / المهنة *</label>
                            <select wire:model="category_id" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">اختر القطاع...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Image Cover Section -->
                    <div class="space-y-2 bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200 dark:border-slate-700">
                        <label class="block text-slate-800 dark:text-slate-200 font-bold">صورة التخصص والغلاف</label>
                        <div class="grid grid-cols-2 gap-3 items-center">
                            <div>
                                <label class="block text-[10px] text-slate-400 mb-1">رفع صورة جديدة من الجهاز</label>
                                <input type="file" wire:model="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div>
                                <label class="block text-[10px] text-slate-400 mb-1">أو رابط الصورة المباشر</label>
                                <input type="text" wire:model="image_path" placeholder="images/skills/trade_01.png" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-mono">
                            </div>
                        </div>
                    </div>

                    <!-- Technical Description PDF Section -->
                    <div class="space-y-2 bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200 dark:border-slate-700">
                        <label class="block text-slate-800 dark:text-slate-200 font-bold">ملف التوصيف الفني PDF (Technical Description)</label>

                        <!-- Option A: Pick from Existing PDFs in platform -->
                        <div>
                            <label class="block text-[10px] text-slate-400 mb-1">اختيار من ملفات PDF المتاحة على المنصة</label>
                            <select wire:model="selected_existing_pdf" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-mono text-slate-800 dark:text-slate-200">
                                <option value="">-- اختر ملفاً موجوداً بالمنصة --</option>
                                @foreach($this->availablePdfs as $pdfItem)
                                    <option value="{{ $pdfItem }}">{{ basename($pdfItem) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Option B: Upload new PDF file -->
                        <div class="pt-2 border-t border-slate-200/60 dark:border-slate-700/60">
                            <label class="block text-[10px] text-slate-400 mb-1">أو رفع ملف PDF جديد وتحديثه بالمنصة</label>
                            <input type="file" wire:model="pdf_file" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                        </div>
                    </div>

                    <!-- Toggles -->
                    <div class="space-y-2 bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200 dark:border-slate-700">
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">تفعيل التخصص متاحاً للتسجيل والمنافسة</span>
                            <input type="checkbox" wire:model="is_active" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                        </label>
                        <hr class="border-slate-200/60 dark:border-slate-700/60">
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">إظهار التخصص في الصفحة الرئيسية للمنصة</span>
                            <input type="checkbox" wire:model="show_on_homepage" class="rounded border-slate-300 text-amber-500 focus:ring-amber-500 w-4 h-4">
                        </label>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                        <button type="button" wire:click="$set('formOpen', false)" class="px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-2xl">إلغاء</button>
                        <button type="submit" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-2xl shadow-lg shadow-blue-600/20">حفظ وحفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- DETAILS DRAWER -->
    @if(($drawerOpen ?? false) && ($selectedSkill ?? null))
        <div class="fixed inset-0 z-50 overflow-hidden bg-slate-900/60 backdrop-blur-xs flex justify-end transition-opacity">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 h-full shadow-2xl flex flex-col justify-between overflow-y-auto p-6 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ $selectedSkill->getImageUrl() }}" alt="{{ $selectedSkill->name_ar }}" class="w-12 h-12 rounded-2xl object-cover border border-slate-200 dark:border-slate-700 shadow-xs">
                        <div>
                            <h2 class="text-lg font-black text-slate-900 dark:text-white">{{ $selectedSkill->name_ar }}</h2>
                            <span class="text-xs font-mono font-bold text-blue-600 dark:text-blue-400">{{ $selectedSkill->code }}</span>
                        </div>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4 text-xs font-semibold flex-1">
                    <div class="bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl space-y-3 border border-slate-100 dark:border-slate-700/60">
                        <div class="flex justify-between items-center"><span class="text-slate-400">الاسم بالفرنسية:</span><span class="font-bold text-slate-900 dark:text-white font-mono">{{ $selectedSkill->name_fr ?? '—' }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">القطاع:</span><span class="font-bold text-blue-600 dark:text-blue-400">{{ $selectedSkill->category?->name_ar ?? 'عام' }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">الحد العمري:</span><span class="font-bold text-slate-900 dark:text-white font-mono">{{ $selectedSkill->min_age ?? 16 }} - {{ $selectedSkill->max_age ?? 25 }} سنة</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">عدد المسجلين المعتمدين:</span><span class="font-black text-emerald-600 dark:text-emerald-400 font-mono">{{ number_format($selectedSkill->registrations_count ?? 0) }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">الصفحة الرئيسية:</span><span class="font-bold {{ ($selectedSkill->show_on_homepage ?? true) ? 'text-amber-600' : 'text-slate-400' }}">{{ ($selectedSkill->show_on_homepage ?? true) ? 'ظاهر بالرئيسية' : 'مخفي' }}</span></div>
                    </div>

                    @if($selectedSkill->getPdfUrl())
                        <button wire:click="openPdfModal({{ $selectedSkill->id }})" class="w-full p-3 rounded-2xl bg-purple-50 hover:bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 font-bold text-xs border border-purple-200 dark:border-purple-800 flex items-center justify-between transition">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>معاينة ملف التوصيف الفني PDF داخل المنصة</span>
                            </span>
                            <span class="text-[10px] font-mono font-bold">PDF</span>
                        </button>
                    @endif
                </div>

                <div class="flex gap-2 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="openEdit({{ $selectedSkill->id }})" class="flex-1 px-4 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs transition">تعديل البيانات والصور</button>
                    <button wire:click="confirmDelete({{ $selectedSkill->id }})" class="flex-1 px-4 py-2.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs transition">حذف التخصص</button>
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
                <h3 class="text-base font-black text-slate-900 dark:text-white">تأكيد حذف التخصص</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400">هل أنت متأكد من رغبتك في حذف هذا التخصص؟ الإجراء لا يمكن التراجع عنه.</p>
                <div class="flex justify-center gap-2 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl">إلغاء</button>
                    <button wire:click="deleteSkill" class="px-5 py-2 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif
</div>
