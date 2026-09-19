@php
    $locale = app()->getLocale();
    $t = function($ar, $fr, $en) use ($locale) {
        return match($locale) {
            'fr' => $fr,
            'en' => $en,
            default => $ar,
        };
    };
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- TOP BANNER / HEADER --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#06205C] via-[#0A2E80] to-[#06205C] p-6 md:p-8 text-white shadow-xl border border-blue-900/40">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 border border-amber-400/30 text-amber-300 text-xs font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>{{ $t('مركز إدارة الطبعات والدورات الرسمية National Editions', 'Centre de Gestion des Éditions', 'National Editions & Sessions Hub') }}</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight text-white">
                    {{ $t('إدارة الطبعات والدورات الوطنية الأولمبية', 'Gestion des Éditions et Compétitions', 'Editions & National Olympic Sessions') }}
                </h1>
                <p class="text-xs md:text-sm text-blue-200/90 max-w-3xl leading-relaxed">
                    {{ $t('إدارة وتفعيل الطبعات الرسمية لمسابقة مهارات الجزائر. تحديد السنة الفعالة والتجريبية وضبط التواريخ والمحطات التنظيمية.', 'Gérer les éditions officielles et définir l’édition active.', 'Manage official editions and set active national competition sessions.') }}
                </p>
            </div>

            {{-- ADD BUTTON --}}
            <div class="shrink-0">
                <button 
                    wire:click="openCreate" 
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg hover:shadow-amber-500/20 transition-all active:scale-95 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                    <span>{{ $t('إضافة طبعة جديدة', 'Ajouter une Édition', 'Add New Edition') }}</span>
                </button>
            </div>
        </div>
    </div>

    {{-- STATS KPIS GRID --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- KPI 1: TOTAL EDITIONS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-5 shadow-sm space-y-3 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-2 h-full bg-blue-600"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('إجمالي الطبعات', 'Total Éditions', 'Total Editions') }}</span>
                <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white font-mono tracking-tight">
                {{ number_format($totalEditions) }}
            </div>
            <p class="text-xs text-slate-400 font-medium pt-1">
                {{ $t('دورة مسجلة بالنظام', 'éditions enregistrées', 'registered editions') }}
            </p>
        </div>

        {{-- KPI 2: ACTIVE EDITION --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-5 shadow-sm space-y-3 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-2 h-full bg-emerald-500"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('الطبعة النشطة حالياً', 'Édition Active', 'Active Edition') }}</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 font-mono tracking-tight flex items-center gap-2">
                @if($activeEdition)
                    <span>{{ $activeEdition->year }}</span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                        {{ $t('نشط', 'Active', 'Active') }}
                    </span>
                @else
                    <span class="text-slate-400 text-sm font-normal">{{ $t('غير محددة', 'Non définie', 'Not defined') }}</span>
                @endif
            </div>
            <p class="text-xs text-slate-400 font-medium pt-1 line-clamp-1">
                {{ $activeEdition->name_ar ?? $t('لا توجد طبعة نشطة حالياً', 'Aucune édition active', 'No active edition set') }}
            </p>
        </div>

        {{-- KPI 3: COMPLETED EDITIONS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-5 shadow-sm space-y-3 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-2 h-full bg-purple-600"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('الطبعات المكتملة', 'Éditions Terminées', 'Completed Editions') }}</span>
                <div class="w-8 h-8 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white font-mono tracking-tight">
                {{ number_format($completedCount) }}
            </div>
            <p class="text-xs text-slate-400 font-medium pt-1">
                {{ $t('دورات سابقة مختتمة بنجاح', 'éditions archivées', 'archived editions') }}
            </p>
        </div>

        {{-- KPI 4: DRAFT EDITIONS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-5 shadow-sm space-y-3 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-2 h-full bg-amber-500"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('المسودات والقيد الإعداد', 'Brouillons', 'Draft Editions') }}</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white font-mono tracking-tight">
                {{ number_format($draftCount) }}
            </div>
            <p class="text-xs text-slate-400 font-medium pt-1">
                {{ $t('طبعات قيد التحضير والتخطيط', 'en préparation', 'under preparation') }}
            </p>
        </div>

    </div>

    {{-- FILTERS & SEARCH CONTROL --}}
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <input 
                wire:model.live.debounce.300ms="search" 
                type="text" 
                placeholder="{{ $t('بحث باسم الطبعة، السنة...', 'Rechercher par nom ou année...', 'Search by name, year...') }}"
                class="w-full px-4 py-2.5 text-xs font-medium rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
        <select 
            wire:model.live="filterStatus"
            class="px-4 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 shrink-0"
        >
            <option value="">{{ $t('جميع الحالات', 'Tous les statuts', 'All Statuses') }}</option>
            <option value="ACTIVE">{{ $t('نشطة (ACTIVE)', 'Active', 'Active') }}</option>
            <option value="ONGOING">{{ $t('جارية (ONGOING)', 'En cours', 'Ongoing') }}</option>
            <option value="DRAFT">{{ $t('مسودة (DRAFT)', 'Brouillon', 'Draft') }}</option>
            <option value="COMPLETED">{{ $t('مكتملة (COMPLETED)', 'Terminée', 'Completed') }}</option>
        </select>
    </div>

    {{-- EDITIONS TABLE --}}
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-700">
                        <th class="p-3.5 rounded-r-xl">{{ $t('السنة', 'Année', 'Year') }}</th>
                        <th class="p-3.5">{{ $t('اسم الطبعة الوطنية', 'Nom de l\'Édition', 'Edition Name') }}</th>
                        <th class="p-3.5 text-center">{{ $t('إجمالي المسجلين', 'Inscriptions', 'Registrations') }}</th>
                        <th class="p-3.5 text-center">{{ $t('طبعة نشطة حالياً', 'Édition Active', 'Primary Active') }}</th>
                        <th class="p-3.5 text-center">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                        <th class="p-3.5 rounded-l-xl text-left">{{ $t('الإجراءات', 'Actions', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @forelse($editions as $edition)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-700/30 transition-colors">
                            {{-- YEAR --}}
                            <td class="p-3.5 font-mono font-black text-sm text-blue-600 dark:text-blue-400">
                                <span class="px-2.5 py-1 rounded-xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800/60">
                                    {{ $edition->year }}
                                </span>
                            </td>

                            {{-- NAME --}}
                            <td class="p-3.5 space-y-0.5">
                                <div class="font-black text-slate-900 dark:text-white text-sm">
                                    {{ $edition->name_ar }}
                                </div>
                                <div class="text-[11px] text-slate-400 font-medium">
                                    {{ $edition->name_fr }} {{ $edition->name_en ? ' • ' . $edition->name_en : '' }}
                                </div>
                            </td>

                            {{-- REGISTRATIONS --}}
                            <td class="p-3.5 text-center font-mono font-bold text-slate-700 dark:text-slate-300">
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold">
                                    {{ number_format($edition->registrations_count) }} {{ $t('مسجل', 'inscrits', 'registered') }}
                                </span>
                            </td>

                            {{-- ACTIVE TOGGLE --}}
                            <td class="p-3.5 text-center">
                                <button 
                                    wire:click="toggleActive({{ $edition->id }})" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold transition-all cursor-pointer {{ $edition->is_active ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/20' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-200' }}"
                                >
                                    <span class="w-2 h-2 rounded-full {{ $edition->is_active ? 'bg-white animate-pulse' : 'bg-slate-400' }}"></span>
                                    <span>{{ $edition->is_active ? $t('نشطة أساسية', 'Active', 'Primary Active') : $t('غير نشطة', 'Inactive', 'Inactive') }}</span>
                                </button>
                            </td>

                            {{-- STATUS BADGE --}}
                            <td class="p-3.5 text-center">
                                @php
                                    $stBadge = match(strtoupper($edition->status ?? 'ACTIVE')) {
                                        'ACTIVE' => ['bg' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300', 'label' => $t('نشطة', 'Active', 'Active')],
                                        'ONGOING' => ['bg' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300', 'label' => $t('جارية', 'En cours', 'Ongoing')],
                                        'COMPLETED' => ['bg' => 'bg-purple-100 text-purple-800 dark:bg-purple-950/60 dark:text-purple-300', 'label' => $t('مكتملة', 'Terminée', 'Completed')],
                                        'DRAFT' => ['bg' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300', 'label' => $t('مسودة', 'Brouillon', 'Draft')],
                                        default => ['bg' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300', 'label' => $edition->status],
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold inline-block {{ $stBadge['bg'] }}">
                                    {{ $stBadge['label'] }}
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td class="p-3.5 text-left">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button 
                                        wire:click="openDrawer({{ $edition->id }})" 
                                        title="{{ $t('التفاصيل', 'Détails', 'Details') }}"
                                        class="p-2 rounded-xl text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-950/60 transition-colors cursor-pointer"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>

                                    <button 
                                        wire:click="openEdit({{ $edition->id }})" 
                                        title="{{ $t('تعديل', 'Modifier', 'Edit') }}"
                                        class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-950/60 transition-colors cursor-pointer"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <button 
                                        wire:click="confirmDelete({{ $edition->id }})" 
                                        title="{{ $t('حذف', 'Supprimer', 'Delete') }}"
                                        class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/60 transition-colors cursor-pointer"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-xs text-slate-400">
                                {{ $t('لا توجد طبعات مسجلة مطابقة لخيارات البحث', 'Aucune édition trouvée', 'No registered editions matching filters') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($editions->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700/60">
                {{ $editions->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL FORM (CREATE / EDIT) --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-2xl max-w-xl w-full p-6 space-y-5">
                
                {{-- MODAL HEADER --}}
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ $isEditing ? $t('تعديل بيانيات الطبعة الوطنية', 'Modifier l\'Édition', 'Edit Edition') : $t('إضافة طبعة وطنية جديدة', 'Nouvelle Édition', 'Create New Edition') }}</span>
                    </h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- FORM FIELDS --}}
                <div class="space-y-4 max-h-[70vh] overflow-y-auto px-1">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- YEAR --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">{{ $t('سنة الطبعة *', 'Année *', 'Year *') }}</label>
                            <input 
                                wire:model="year" 
                                type="number" 
                                class="w-full px-3.5 py-2.5 text-xs font-mono font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            >
                            @error('year') <span class="text-[11px] text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- STATUS --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">{{ $t('حالة الطبعة *', 'Statut *', 'Status *') }}</label>
                            <select 
                                wire:model="status" 
                                class="w-full px-3.5 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            >
                                <option value="ACTIVE">{{ $t('نشطة (ACTIVE)', 'Active', 'Active') }}</option>
                                <option value="ONGOING">{{ $t('جارية (ONGOING)', 'En cours', 'Ongoing') }}</option>
                                <option value="DRAFT">{{ $t('مسودة (DRAFT)', 'Brouillon', 'Draft') }}</option>
                                <option value="COMPLETED">{{ $t('مكتملة (COMPLETED)', 'Terminée', 'Completed') }}</option>
                            </select>
                            @error('status') <span class="text-[11px] text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- ARABIC NAME --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">{{ $t('اسم الطبعة (بالعربية) *', 'Nom (Arabe) *', 'Name (Arabic) *') }}</label>
                        <input 
                            wire:model="name_ar" 
                            type="text" 
                            placeholder="أولمبياد المهن الجزائرية 2026"
                            class="w-full px-3.5 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                        @error('name_ar') <span class="text-[11px] text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- FRENCH NAME --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">{{ $t('اسم الطبعة (بالفرنسية) *', 'Nom (Français) *', 'Name (French) *') }}</label>
                        <input 
                            wire:model="name_fr" 
                            type="text" 
                            placeholder="WorldSkills Algeria 2026"
                            class="w-full px-3.5 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                        @error('name_fr') <span class="text-[11px] text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- ENGLISH NAME --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">{{ $t('اسم الطبعة (بالإنكليزية)', 'Nom (Anglais)', 'Name (English)') }}</label>
                        <input 
                            wire:model="name_en" 
                            type="text" 
                            placeholder="WorldSkills Algeria 2026"
                            class="w-full px-3.5 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    {{-- ACTIVE TOGGLE --}}
                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">{{ $t('تعيين كطبعة نشطة أساسية', 'Définir comme édition active', 'Set as primary active edition') }}</span>
                            <span class="text-[11px] text-slate-400 font-medium block">{{ $t('سيتم تفعيل هذه الطبعة وإيقاف الطبعات الأخرى تلقائياً', 'Désactive automatiquement les autres éditions', 'Will set this active and deactivate others') }}</span>
                        </div>
                        <input 
                            type="checkbox" 
                            wire:model="is_active" 
                            class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                        >
                    </div>

                </div>

                {{-- MODAL FOOTER --}}
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button 
                        wire:click="$set('formOpen', false)" 
                        class="px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl transition-all cursor-pointer"
                    >
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button 
                        wire:click="save" 
                        wire:loading.attr="disabled"
                        class="px-5 py-2.5 text-xs font-black text-slate-950 bg-amber-500 hover:bg-amber-400 rounded-xl shadow-lg transition-all active:scale-95 cursor-pointer disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="save">{{ $t('حفظ البيانات', 'Enregistrer', 'Save Edition') }}</span>
                        <span wire:loading wire:target="save">{{ $t('جاري الحفظ...', 'Enregistrement...', 'Saving...') }}</span>
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- DETAIL DRAWER --}}
    @if($drawerOpen && $selectedEdition)
        <div class="fixed inset-0 z-50 flex justify-end bg-slate-950/60 backdrop-blur-xs">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 border-s border-slate-200 dark:border-slate-700 h-full p-6 overflow-y-auto space-y-6 shadow-2xl">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <span class="text-xs font-mono font-bold px-2.5 py-0.5 rounded-full bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300">
                            {{ $selectedEdition->year }}
                        </span>
                        <h2 class="text-lg font-black text-slate-900 dark:text-white mt-1">{{ $selectedEdition->name_ar }}</h2>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-700/60 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">{{ $t('الاسم بالفرنسية', 'Nom FR', 'French Name') }}:</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $selectedEdition->name_fr }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">{{ $t('الاسم بالإنكليزية', 'Nom EN', 'English Name') }}:</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $selectedEdition->name_en ?: '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">{{ $t('إجمالي طلبات التسجيل', 'Total Inscriptions', 'Total Registrations') }}:</span>
                            <span class="font-bold font-mono text-emerald-600 dark:text-emerald-400">{{ number_format($selectedEdition->registrations_count) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">{{ $t('حالة التفعيل الرئيسية', 'Statut d\'activation', 'Active Status') }}:</span>
                            <span class="font-bold {{ $selectedEdition->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                {{ $selectedEdition->is_active ? $t('نشطة أساسية', 'Active Primary', 'Primary Active') : $t('غير نشطة', 'Invasive', 'Inactive') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button 
                        wire:click="$set('drawerOpen', false)" 
                        class="w-full py-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 rounded-xl transition-all"
                    >
                        {{ $t('إغلاق التفاصيل', 'Fermer', 'Close Details') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- DELETE CONFIRMATION MODAL --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-sm w-full space-y-4 text-center border border-slate-200 dark:border-slate-700 shadow-2xl">
                <div class="w-12 h-12 rounded-full bg-rose-100 dark:bg-rose-950/60 text-rose-600 mx-auto flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-base font-black text-slate-900 dark:text-white">{{ $t('تأكيد حذف الطبعة', 'Confirmer la Suppression', 'Confirm Edition Deletion') }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    {{ $t('هل أنت متأكد من رغبتك في حذف هذه الطبعة؟ قد يؤثر ذلك على التوثيق التاريخي المسجل.', 'Êtes-vous sûr de vouloir supprimer cette édition ?', 'Are you sure you want to delete this edition?') }}
                </p>
                <div class="flex justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="deleteEdition" class="px-5 py-2 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">
                        {{ $t('حذف الآن', 'Supprimer', 'Delete Now') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
