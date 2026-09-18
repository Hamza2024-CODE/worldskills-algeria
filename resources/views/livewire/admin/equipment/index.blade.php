@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-6 pb-12 font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <x-dashboard.page-header
        :title="$t('إدارة معدات وتجهيزات التخصصات المهنية (Infrastructure List)', 'Gestion des Équipements & Infrastructures', 'Skill Equipment & Infrastructure List')"
        :subtitle="$t('قائمة البنية التحتية والمعدات التقنية المعتمدة للمسابقات والتخصصات', 'Répertoire des équipements techniques des métiers', 'Technical infrastructure & skill equipment directory')"
    >
        <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-black transition backdrop-blur-md shadow-xs shrink-0 cursor-pointer">
            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>{{ $t('تصدير إلى Excel (CSV)', 'Exporter Excel', 'Export to Excel') }}</span>
        </button>

        <button wire:click="openCatCreate" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-black transition backdrop-blur-md shrink-0 cursor-pointer">
            <svg class="w-4 h-4 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <span>{{ $t('فئات المعدات', 'Gestion Catégories', 'Categories') }}</span>
        </button>

        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-black transition shadow-md shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            <span>{{ $t('إضافة معدة / تجهيز جديد', 'Ajouter un Équipement', 'Add Equipment Item') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- ALERTS & FLASH NOTIFICATIONS --}}
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs font-bold rounded-2xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 text-xs font-bold rounded-2xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- STATS OVERVIEW CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Equipment -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('إجمالي المعدات المسجلة', 'Total Équipements', 'Total Equipment') }}
                    </span>
                    <span class="text-3xl font-black text-slate-900 dark:text-white mt-1 block">
                        {{ number_format($totalItems) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-blue-600 dark:text-blue-400 flex items-center gap-1">
                <span>{{ $t('شاملة لكافة الورش والتخصصات', 'Toutes les infrastructures', 'Across all skill workshops') }}</span>
            </div>
        </div>

        <!-- Card 2: Skill Assigned Items -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('تجهيزات مخصصة للمهن', 'Équipements par Métier', 'Skill-Assigned Items') }}
                    </span>
                    <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400 mt-1 block">
                        {{ number_format($assignedItemsCount) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-1">
                <span>{{ $t('مرتبطة بتخصصات أولمبية محددة', 'Liaison directe aux métiers', 'Directly linked to specific skills') }}</span>
            </div>
        </div>

        <!-- Card 3: General Infrastructure -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('تجهيزات عامة ومشتركة', 'Équipements Généraux', 'General Equipment') }}
                    </span>
                    <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-1 block">
                        {{ number_format($generalItemsCount) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0v-4a1 1 0 011-1h2a1 1 0 011 1v4m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                <span>{{ $t('بنية تحتية مشاعة لجميع القاعات', 'Partagées sur tous les espaces', 'Shared across all event areas') }}</span>
            </div>
        </div>

        <!-- Card 4: High Safety Hazard -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('تجهيزات الوقاية والحماية الفائقة', 'Sécurité & Protection Strictes', 'High Hazard / Strict PPE') }}
                    </span>
                    <span class="text-3xl font-black text-amber-600 dark:text-amber-400 mt-1 block">
                        {{ number_format($hazardItemsCount) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-amber-600 dark:text-amber-400 flex items-center gap-1">
                <span>{{ $t('تتطلب احتياطات سلامة مشددة', 'Normes de sécurité renforcées', 'Requires strict safety measures') }}</span>
            </div>
        </div>
    </div>

    {{-- FILTERS BAR --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 space-y-4 shadow-xs">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/60 pb-3">
            <h2 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>{{ $t('تصفية وحصر المعدات حسب التخصص والتصنيف', 'Filtrer les équipements par métier & catégorie', 'Filter Equipment by Skill & Category') }}</span>
            </h2>
            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold">
                {{ $t('يعرض ', 'Affichage de ', 'Displaying ') }} {{ $items->total() }} {{ $t(' عنصر', ' éléments', ' items') }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Search -->
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="{{ $t('بحث باسم المعدة أو المواصفات...', 'Rechercher par nom ou spécification...', 'Search by equipment name or spec...') }}"
                    class="w-full ps-10 pe-4 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                <svg class="w-4 h-4 text-slate-400 absolute start-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Skill Filter -->
            <div>
                <select wire:model.live="filterSkill" class="w-full px-3.5 py-2.5 text-xs rounded-2xl border border-indigo-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-indigo-900 dark:text-sky-300 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                    <option value="">{{ $t('-- اختر التخصص المهني المخصص --', '-- Filtrer par métier --', '-- Filter by skill --') }}</option>
                    @foreach($skills as $s)
                        <option value="{{ $s->id }}">{{ $s->name_ar }} ({{ $s->code }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <select wire:model.live="filterCategory" class="w-full px-3.5 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">{{ $t('-- كل فئات التجهيزات --', '-- Toutes les catégories --', '-- All categories --') }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name_ar }} ({{ $cat->items_count }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Type Filter -->
            <div>
                <select wire:model.live="filterType" class="w-full px-3.5 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">{{ $t('-- كل أنواع التجهيز --', '-- Tous les types d\'équipement --', '-- All equipment types --') }}</option>
                    <option value="workstation">{{ $t('محطة عمل / طاولة تنافس', 'Poste de travail / Table', 'Workstation / Bench') }}</option>
                    <option value="machine">{{ $t('آلة / جهاز متطور / خادم', 'Machine / Serveur', 'Machine / Server') }}</option>
                    <option value="tool">{{ $t('أداة قياس ومعايرة دقيقة', 'Instrument de mesure / Outil', 'Precision Tool / Instrument') }}</option>
                    <option value="ppe">{{ $t('معدات الوقاية والسلامة (PPE)', 'Équipement de Protection (EPI)', 'PPE / Safety Gear') }}</option>
                </select>
            </div>
        </div>
    </div>

    {{-- EQUIPMENT DATA TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-xs text-start border-collapse align-middle">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-900/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200/80 dark:border-slate-700/80">
                        <th class="px-5 py-4 text-start min-w-[220px]">{{ $t('اسم المعدة والتجهيز', 'Nom de l\'Équipement', 'Equipment Name') }}</th>
                        <th class="px-5 py-4 text-start min-w-[190px] whitespace-nowrap">{{ $t('التخصص المهني المرتبط', 'Métier Associé', 'Associated Skill') }}</th>
                        <th class="px-5 py-4 text-start min-w-[170px] whitespace-nowrap">{{ $t('الفئة والتصنيف', 'Catégorie', 'Category') }}</th>
                        <th class="px-5 py-4 text-start min-w-[220px]">{{ $t('المواصفات الفنية التفصيلية', 'Spécifications Techniques', 'Technical Specifications') }}</th>
                        <th class="px-5 py-4 text-start min-w-[150px] whitespace-nowrap">{{ $t('مستوى السلامة', 'Niveau de Sécurité', 'Safety Level') }}</th>
                        <th class="px-5 py-4 text-end min-w-[140px] whitespace-nowrap">{{ $t('إجراءات العمل', 'Actions', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @forelse($items as $item)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-900/40 transition">
                            <!-- Name & French/English -->
                            <td class="px-5 py-4 font-black text-slate-900 dark:text-white min-w-[220px]">
                                <button wire:click="openDrawer({{ $item->id }})" class="hover:text-blue-600 dark:hover:text-blue-400 transition text-start leading-snug cursor-pointer block">
                                    <span class="block text-sm font-black">{{ $item->name_ar }}</span>
                                    @if($item->name_fr || $item->name_en)
                                        <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400 font-semibold block mt-0.5 whitespace-normal">
                                            {{ $item->name_fr ?: $item->name_en }}
                                        </span>
                                    @endif
                                </button>
                            </td>

                            <!-- Skill Associated -->
                            <td class="px-5 py-4 font-bold min-w-[190px] whitespace-nowrap">
                                @if($item->skill)
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200/80 dark:border-indigo-800/80 whitespace-nowrap shrink-0">
                                        <svg class="w-3.5 h-3.5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.229-1.004l-1.9-3.8a2 2 0 01.371-2.434l3.193-3.193a2 2 0 012.434-.371l3.8 1.9a2 2 0 011.004 1.229l.477 2.387a6 6 0 00.517 3.86l.158.318a6 6 0 01.517 3.86l.477 2.387a2 2 0 00.547 1.022l2.387.477a2 2 0 002.434-.371l3.193-3.193a2 2 0 00.371-2.434l-1.9-3.8z"/></svg>
                                        <span class="whitespace-nowrap">{{ $item->skill->name_ar }}</span>
                                        <span class="text-[10px] font-mono opacity-80 whitespace-nowrap">(SKILL-{{ $item->skill->code }})</span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs bg-slate-100 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 font-bold whitespace-nowrap">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0v-4a1 1 0 011-1h2a1 1 0 011 1v4m-4 0h4"/></svg>
                                        <span class="whitespace-nowrap">{{ $t('بنية تحتية عامة لكافة التخصصات', 'Infrastructure Générale', 'General Infrastructure') }}</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Category -->
                            <td class="px-5 py-4 font-bold min-w-[170px] whitespace-nowrap">
                                <span class="inline-block px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-700/60 text-slate-800 dark:text-slate-200 border border-slate-200/60 dark:border-slate-700/60 whitespace-nowrap">
                                    {{ $item->category?->name_ar ?? '—' }}
                                </span>
                            </td>

                            <!-- Specification details -->
                            <td class="px-5 py-4 text-slate-600 dark:text-slate-300 font-medium leading-relaxed min-w-[220px]">
                                <span class="block max-w-sm line-clamp-2 leading-snug">
                                    {{ $item->specification_details ?: '—' }}
                                </span>
                            </td>

                            <!-- Safety Level -->
                            <td class="px-5 py-4 min-w-[150px] whitespace-nowrap">
                                @if($item->safety_level === 'HIGH_HAZARD' || $item->safety_level === 'STRICT_PPE_REQUIRED')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-black bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/20 whitespace-nowrap">
                                        <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <span class="whitespace-nowrap">{{ $t('سلامة وحماية فائقة (PPE)', 'Sécurité Renforcée', 'High Hazard PPE') }}</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-bold bg-slate-100 dark:bg-slate-700/60 text-slate-700 dark:text-slate-300 whitespace-nowrap">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="whitespace-nowrap">{{ $t('معياري (Standard)', 'Standard', 'Standard') }}</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-5 py-4 text-end min-w-[140px] whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <button wire:click="openDrawer({{ $item->id }})" title="{{ $t('عرض التفاصيل', 'Détails', 'View') }}" class="p-2 text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl bg-slate-100 dark:bg-slate-700/80 hover:bg-blue-50 dark:hover:bg-blue-900/40 border border-slate-200/60 dark:border-slate-700/60 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="openEdit({{ $item->id }})" title="{{ $t('تعديل', 'Modifier', 'Edit') }}" class="p-2 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl bg-slate-100 dark:bg-slate-700/80 hover:bg-indigo-50 dark:hover:bg-indigo-900/40 border border-slate-200/60 dark:border-slate-700/60 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $item->id }})" title="{{ $t('حذف', 'Supprimer', 'Delete') }}" class="p-2 text-slate-600 dark:text-slate-300 hover:text-rose-600 dark:hover:text-rose-400 rounded-xl bg-slate-100 dark:bg-slate-700/80 hover:bg-rose-50 dark:hover:bg-rose-900/40 border border-slate-200/60 dark:border-slate-700/60 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400 font-medium">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <svg class="w-10 h-10 mx-auto text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    <p class="text-xs font-bold text-slate-600 dark:text-slate-400">
                                        {{ $t('لا توجد معدات وتجهيزات مطابقة للفلترة الحالية', 'Aucun équipement trouvé', 'No equipment items found matching filter') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="px-5 py-4 border-t border-slate-200/80 dark:border-slate-700/80 bg-slate-50/50 dark:bg-slate-900/40">
                {{ $items->links() }}
            </div>
        @endif
    </div>

    {{-- CREATE / EDIT ITEM MODAL --}}
    @if($formOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-xl shadow-2xl border border-slate-200 dark:border-slate-700 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white">
                                {{ $isEditing ? $t('تعديل معدة وتجهيز تخصص', 'Modifier l\'Équipement', 'Edit Equipment Item') : $t('إضافة معدة وتجهيز جديد للتخصص', 'Ajouter un Équipement', 'Add New Equipment Item') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $t('حدد التخصص المهني والفئة والمواصفات الفنية المعتمدة', 'Renseignez les détails techniques du matériel', 'Specify skill, category, and technical details') }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('formOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4 text-xs font-semibold">
                    <!-- Skill Select -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                            {{ $t('التخصص المهني المخصص *', 'Métier Associé *', 'Associated Skill *') }}
                        </label>
                        <select wire:model="skill_id" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="">{{ $t('-- معدة عامة لكافة التخصصات (General Infrastructure) --', '-- Équipement général --', '-- General Infrastructure --') }}</option>
                            @foreach($skills as $s)
                                <option value="{{ $s->id }}">{{ $s->name_ar }} ({{ $s->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Name AR & FR -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                                {{ $t('الاسم بالعربية *', 'Nom (Arabe) *', 'Arabic Name *') }}
                            </label>
                            <input wire:model="name_ar" type="text" placeholder="محطة عمل مجهزة لشاشتين" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            @error('name_ar') <span class="text-rose-500 text-[11px] font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                                {{ $t('الاسم بالفرنسية *', 'Nom (Français) *', 'French Name *') }}
                            </label>
                            <input wire:model="name_fr" type="text" placeholder="Station de travail double écran" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            @error('name_fr') <span class="text-rose-500 text-[11px] font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Category & Type -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                                {{ $t('فئة المعدات', 'Catégorie d\'équipement', 'Equipment Category') }}
                            </label>
                            <select wire:model="category_id" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                <option value="">{{ $t('-- اختر الفئة --', '-- Sélectionner catégorie --', '-- Select Category --') }}</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                                {{ $t('نوع التجهيز والمعدة', 'Type d\'équipement', 'Equipment Type') }}
                            </label>
                            <select wire:model="item_type" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                <option value="workstation">{{ $t('محطة عمل / طاولة تنافس', 'Poste de travail', 'Workstation') }}</option>
                                <option value="machine">{{ $t('آلة / خادم / جهاز رئيسي', 'Machine / Serveur', 'Machine / Server') }}</option>
                                <option value="tool">{{ $t('أداة قياس ومعايرة دقيقة', 'Outil / Instrument', 'Tool / Instrument') }}</option>
                                <option value="ppe">{{ $t('معدات الوقاية والسلامة', 'Équipement de Protection (EPI)', 'PPE Safety Gear') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Safety Level -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                            {{ $t('مستوى الوقاية والسلامة المطلوب', 'Niveau de Sécurité', 'Safety Level') }}
                        </label>
                        <select wire:model="safety_level" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="STANDARD">{{ $t('معياري - إجراءات سلامة عامة', 'Standard', 'Standard') }}</option>
                            <option value="STRICT_PPE_REQUIRED">{{ $t('إلزامي - معدات حماية شخصية (خوذة / نظارات / قفازات)', 'EPI Obligatoire', 'Strict PPE Required') }}</option>
                            <option value="HIGH_HAZARD">{{ $t('مخاطر عالية - حماية فائقة وإشراف مباشر من الخبراء', 'Haute Dangerosité', 'High Hazard Safety Level') }}</option>
                        </select>
                    </div>

                    <!-- Technical Specs -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                            {{ $t('المواصفات الفنية التفصيلية والمعايير', 'Spécifications Techniques', 'Technical Specifications') }}
                        </label>
                        <textarea wire:model="specification_details" rows="3" placeholder="{{ $t('المعالج، الذاكرة، الدقة، الطاقة، المعايرة المطلوبة...', 'Processeur, mémoire, tension, précision requise...', 'Processor, RAM, power, voltage, calibration requirements...') }}" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('formOpen', false)" class="px-5 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60 rounded-2xl transition cursor-pointer">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="save" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-2xl shadow-md transition cursor-pointer">
                        {{ $t('حفظ التجهيز والمعدة', 'Enregistrer', 'Save Equipment') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- CATEGORY MANAGEMENT MODAL --}}
    @if($catFormOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-lg shadow-2xl border border-slate-200 dark:border-slate-700 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">
                        {{ $catEditing ? $t('تعديل فئة معدات', 'Modifier Catégorie', 'Edit Category') : $t('إضافة فئة معدات جديدة', 'Nouvelle Catégorie', 'Add Equipment Category') }}
                    </h3>
                    <button wire:click="$set('catFormOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-3 text-xs font-semibold">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">اسم الفئة بالعربية *</label>
                        <input wire:model="cat_name_ar" type="text" placeholder="مثال: معدات وتقنيات الحاسوب والشبكات" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold">
                        @error('cat_name_ar') <span class="text-rose-500 text-[11px] font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">اسم الفئة بالفرنسية *</label>
                        <input wire:model="cat_name_fr" type="text" placeholder="Équipements informatiques & Réseaux" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold">
                        @error('cat_name_fr') <span class="text-rose-500 text-[11px] font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Existing Categories List -->
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <h4 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">الفئات المسجلة حالياً</h4>
                    <div class="max-h-40 overflow-y-auto space-y-1.5 pe-1">
                        @foreach($categories as $cat)
                            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 dark:bg-slate-900/60 text-xs font-bold text-slate-800 dark:text-slate-200">
                                <span>{{ $cat->name_ar }} <span class="text-[10px] text-slate-400">({{ $cat->items_count }} معدة)</span></span>
                                <div class="flex items-center gap-1">
                                    <button wire:click="openCatEdit({{ $cat->id }})" class="p-1 text-slate-400 hover:text-indigo-600 transition cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="deleteCat({{ $cat->id }})" class="p-1 text-slate-400 hover:text-rose-600 transition cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('catFormOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60 rounded-xl cursor-pointer">إلغاء</button>
                    <button wire:click="saveCat" class="px-6 py-2.5 text-xs font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md cursor-pointer">حفظ الفئة</button>
                </div>
            </div>
        </div>
    @endif

    {{-- ITEM VIEW DRAWER --}}
    @if($drawerOpen && $selectedItem)
        <div class="fixed inset-0 z-50 overflow-hidden bg-slate-900/60 backdrop-blur-xs flex justify-end">
            <div class="bg-white dark:bg-slate-800 w-full max-w-lg h-full shadow-2xl p-6 overflow-y-auto space-y-6 flex flex-col justify-between border-s border-slate-200 dark:border-slate-700">
                <div class="space-y-6">
                    <!-- Drawer Header -->
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">بطاقة التفاصيل الفنية للمعدة</span>
                                <h3 class="text-base font-black text-slate-900 dark:text-white leading-tight">{{ $selectedItem->name_ar }}</h3>
                            </div>
                        </div>
                        <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Details Grid -->
                    <div class="space-y-4 text-xs">
                        <div class="bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 space-y-2">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">التخصص المهني المخصص</span>
                            @if($selectedItem->skill)
                                <div class="flex items-center gap-2">
                                    <span class="font-black text-sm text-indigo-600 dark:text-indigo-400">{{ $selectedItem->skill->name_ar }}</span>
                                    <span class="px-2 py-0.5 rounded-lg bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 font-mono font-bold text-[10px]">SKILL-{{ $selectedItem->skill->code }}</span>
                                </div>
                            @else
                                <span class="font-bold text-slate-600 dark:text-slate-300">عامة / كافة التخصصات الأولمبية</span>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700/80">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">الفئة الرئيسية</span>
                                <span class="font-black text-slate-800 dark:text-slate-200 mt-1 block">{{ $selectedItem->category?->name_ar ?? '—' }}</span>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700/80">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">نوع التجهيز</span>
                                <span class="font-black text-slate-800 dark:text-slate-200 mt-1 block">{{ $selectedItem->item_type ?? 'عام' }}</span>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 space-y-1.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">المواصفات الفنية التفصيلية والمعايير</span>
                            <p class="font-medium text-slate-700 dark:text-slate-300 leading-relaxed text-xs">
                                {{ $selectedItem->specification_details ?: 'لا توجد مواصفات إضافية مضافة.' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 space-y-1.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">معيار الوقاية والسلامة</span>
                            <div class="mt-1">
                                @if($selectedItem->safety_level === 'HIGH_HAZARD' || $selectedItem->safety_level === 'STRICT_PPE_REQUIRED')
                                    <span class="px-3 py-1 rounded-xl text-[10px] font-black bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/20 inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <span>يتطلب معدات الوقاية الشخصية المشددة (PPE) وإشراف مهني</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-xl text-[10px] font-bold bg-slate-200/60 dark:bg-slate-700 text-slate-700 dark:text-slate-300 inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>مستوى سلامة معياري قياسي (Standard Safety)</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between">
                    <button wire:click="openEdit({{ $selectedItem->id }}); $set('drawerOpen', false)" class="px-5 py-2.5 text-xs font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-2xl shadow-md transition cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>تعديل المعدة</span>
                    </button>
                    <button wire:click="$set('drawerOpen', false)" class="px-5 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-2xl cursor-pointer">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- DELETE CONFIRMATION MODAL --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-sm shadow-2xl border border-slate-200 dark:border-slate-700 space-y-4 text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white">تأكيد حذف المعدة والتجهيز</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">هل أنت تأكد من إزالة هذه المعدة من قائمة التجهيزات؟ لا يمكن التراجع عن هذا الإجراء.</p>
                </div>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-5 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-2xl cursor-pointer">إلغاء</button>
                    <button wire:click="deleteItem" class="px-6 py-2.5 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-2xl shadow-md cursor-pointer">تأكيد الحذف النهائي</button>
                </div>
            </div>
        </div>
    @endif

</div>
