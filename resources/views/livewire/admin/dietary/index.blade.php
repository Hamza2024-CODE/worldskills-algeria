@php
    $locale = app()->getLocale();
    $t = function($ar, $fr, $en) use ($locale) {
        return match($locale) {
            'fr' => $fr,
            'en' => $en,
            default => $ar,
        };
    };

    $dietaryIcons = [
        'HALAL_ONLY' => '<svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'GLUTEN_FREE' => '<svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        'LACTOSE_FREE' => '<svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
        'NUT_ALLERGY' => '<svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'SEAFOOD_ALLERGY' => '<svg class="w-4 h-4 text-cyan-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
        'VEGETARIAN' => '<svg class="w-4 h-4 text-lime-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>',
        'VEGAN' => '<svg class="w-4 h-4 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
        'DIABETIC' => '<svg class="w-4 h-4 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
        'EGG_ALLERGY' => '<svg class="w-4 h-4 text-yellow-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/></svg>',
        'SOY_ALLERGY' => '<svg class="w-4 h-4 text-stone-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 00-1.18.173l-.488.244A2 2 0 003 17.32V18a2 2 0 002 2h14a2 2 0 002-2v-.68a2 2 0 00-.572-1.414l-.428-.478z"/></svg>',
    ];

    $roles = [
        'COMPETITOR'       => ['ar' => 'متنافس / كانديدا', 'fr' => 'Candidat', 'en' => 'Competitor'],
        'EXPERT'           => ['ar' => 'خبير مهارة', 'fr' => 'Expert', 'en' => 'Skill Expert'],
        'DELEGATION_HEAD'  => ['ar' => 'رئيس وفد', 'fr' => 'Chef de Délégation', 'en' => 'Head of Delegation'],
        'DELEGATE_OFFICIAL'=> ['ar' => 'مندوب رسمي', 'fr' => 'Délégué Officiel', 'en' => 'Official Delegate'],
        'STAFF'            => ['ar' => 'فريق تنظيم / ستـاف', 'fr' => 'Staff / Organisation', 'en' => 'Staff'],
        'GUEST'            => ['ar' => 'ضيف شرف', 'fr' => 'Invité d’Honneur', 'en' => 'VIP Guest'],
        'OBSERVER'         => ['ar' => 'مراقب دولي', 'fr' => 'Observateur', 'en' => 'Observer'],
        'MEDIA'            => ['ar' => 'صحفي / إعلامي', 'fr' => 'Média', 'en' => 'Media'],
        'MEDICAL_STAFF'    => ['ar' => 'طاقم طبي', 'fr' => 'Personnel Médical', 'en' => 'Medical Staff'],
        'KITCHEN_STAFF'    => ['ar' => 'طاقم مطعم', 'fr' => 'Personnel Restauration', 'en' => 'Catering Staff'],
    ];
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- PRINT ONLY HEADER (Visible only during printing) --}}
    <div class="hidden print:block space-y-4 mb-6 text-black">
        <div class="flex items-center justify-between border-b border-slate-900 pb-4">
            <div>
                <h1 class="text-xl font-black">WorldSkills Algeria 2026 - المركز الوطني للمأكولات والغذاء</h1>
                <h2 class="text-sm font-bold">تقرير كشف المطبخ المركزي: سجل حساسيات الطعام والأنظمة الغذائية الخاصة</h2>
                <p class="text-xs text-slate-700">تاريخ الاستخراج: {{ date('Y-m-d H:i') }} | إجمالي المسجلين: {{ $totalMembers }} | الحالات الخاصة: {{ $membersWithAllergiesCount }}</p>
            </div>
            <div class="text-end">
                <span class="text-xs font-black px-3 py-1 bg-slate-200 border border-slate-400 rounded-md inline-block">وثيقة رسمية للمطعم المركزي</span>
            </div>
        </div>
    </div>

    {{-- SCREEN HEADER BAND --}}
    <div class="print:hidden flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#06205C] text-white flex items-center justify-center font-black shrink-0 shadow-md">
                <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-[#06205C] dark:text-white tracking-tight">
                    {{ $t('مركز القيادة: سجل حساسيات الطعام والاحتياجات الغذائية', 'Registre National des Allergies Alimentaires & Régimes', 'Central Kitchen & Food Allergies Control Register') }}
                </h1>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-1">
                    {{ $t('إدارة شاملة وقاعدة بيانات 100% لإضافة، تعديل، مسح وحذف سجلات الحساسية وطباعة كشوفات المطبخ المركزي.', 'Gestion 100% base de données des régimes alimentaires et imprimeries de cuisine.', 'Full database management of food allergies, dietary profiles, and printable kitchen manifests.') }}
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button wire:click="openAddModal"
                    class="px-4 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>{{ $t('إضافة حالة جديدة', 'Ajouter un Membre', 'Add New Record') }}</span>
            </button>

            <button wire:click="exportDietaryCsv"
                    class="px-4 py-2.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>{{ $t('تصدير CSV', 'Exporter CSV', 'Export CSV') }}</span>
            </button>

            <button onclick="window.print()"
                    class="px-4 py-2.5 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>{{ $t('طباعة كشف المطبخ', 'Imprimer le Rapport', 'Print Kitchen Roster') }}</span>
            </button>
        </div>
    </div>

    {{-- FLASH NOTIFICATION --}}
    @if($flashMessage)
        @php
            $bgClass = match($flashMessageType) {
                'danger' => 'bg-rose-50 border-rose-200 text-rose-900 dark:bg-rose-950/40 dark:border-rose-900 dark:text-rose-200',
                'warning' => 'bg-amber-50 border-amber-200 text-amber-900 dark:bg-amber-950/40 dark:border-amber-900 dark:text-amber-200',
                default => 'bg-emerald-50 border-emerald-200 text-emerald-900 dark:bg-emerald-950/40 dark:border-emerald-900 dark:text-emerald-200',
            };
        @endphp
        <div class="print:hidden p-4 rounded-2xl border {{ $bgClass }} text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ $flashMessage }}</span>
            </div>
            <button wire:click="$set('flashMessage', '')" class="font-black text-xs hover:opacity-75">
                <x-ws.icon name="x-mark" class="w-5 h-5" />
            </button>
        </div>
    @endif

    {{-- SUMMARY KPI CARDS GRID (SCREEN ONLY) --}}
    <div class="print:hidden grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
        
        {{-- Total Roster --}}
        <div wire:click="$set('selectedAllergyFilter', 'ALL')"
             class="cursor-pointer bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1 hover:border-[#06205C] transition">
            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider block">
                {{ $t('إجمالي الكوادر', 'Total Tous Membres', 'Total Members') }}
            </span>
            <p class="text-2xl font-black text-[#06205C] dark:text-white">{{ $totalMembers }}</p>
            <span class="text-[10px] font-bold text-slate-500">{{ $t('مسجل في النظام', 'Inscrits', 'Registered') }}</span>
        </div>

        {{-- Special Dietary Requirements --}}
        <div wire:click="$set('selectedAllergyFilter', 'HAS_ALLERGY')"
             class="cursor-pointer bg-amber-50 dark:bg-amber-950/40 p-4 rounded-2xl border border-amber-200/80 dark:border-amber-900/60 shadow-xs text-center space-y-1 hover:border-amber-500 transition">
            <span class="text-amber-700 dark:text-amber-400 text-[10px] font-black uppercase tracking-wider block">
                {{ $t('حالات خاصة', 'Cas Particuliers', 'Dietary Requirements') }}
            </span>
            <p class="text-2xl font-black text-amber-900 dark:text-amber-200">{{ $membersWithAllergiesCount }}</p>
            <span class="text-[10px] font-bold text-amber-700 dark:text-amber-400">
                {{ $totalMembers > 0 ? round(($membersWithAllergiesCount / $totalMembers) * 100) : 0 }}% {{ $t('من الإجمالي', 'du total', 'of total') }}
            </span>
        </div>

        {{-- Gluten Free --}}
        <div wire:click="$set('selectedAllergyFilter', 'GLUTEN_FREE')"
             class="cursor-pointer bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1 hover:border-amber-500 transition">
            <span class="text-amber-600 text-[10px] font-black uppercase tracking-wider flex items-center justify-center gap-1">
                {!! $dietaryIcons['GLUTEN_FREE'] !!}
                <span>{{ $t('غلوتين', 'Sans Gluten', 'Gluten-Free') }}</span>
            </span>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $allergyBreakdown['GLUTEN_FREE'] ?? 0 }}</p>
        </div>

        {{-- Lactose Free --}}
        <div wire:click="$set('selectedAllergyFilter', 'LACTOSE_FREE')"
             class="cursor-pointer bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1 hover:border-sky-500 transition">
            <span class="text-sky-600 text-[10px] font-black uppercase tracking-wider flex items-center justify-center gap-1">
                {!! $dietaryIcons['LACTOSE_FREE'] !!}
                <span>{{ $t('حليب', 'Sans Lactose', 'Lactose-Free') }}</span>
            </span>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $allergyBreakdown['LACTOSE_FREE'] ?? 0 }}</p>
        </div>

        {{-- Nut Allergy --}}
        <div wire:click="$set('selectedAllergyFilter', 'NUT_ALLERGY')"
             class="cursor-pointer bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1 hover:border-rose-500 transition">
            <span class="text-rose-600 text-[10px] font-black uppercase tracking-wider flex items-center justify-center gap-1">
                {!! $dietaryIcons['NUT_ALLERGY'] !!}
                <span>{{ $t('مكسرات', 'Fruits à Coque', 'Nut Allergy') }}</span>
            </span>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $allergyBreakdown['NUT_ALLERGY'] ?? 0 }}</p>
        </div>

        {{-- Halal Only --}}
        <div wire:click="$set('selectedAllergyFilter', 'HALAL_ONLY')"
             class="cursor-pointer bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1 hover:border-emerald-500 transition">
            <span class="text-emerald-600 text-[10px] font-black uppercase tracking-wider flex items-center justify-center gap-1">
                {!! $dietaryIcons['HALAL_ONLY'] !!}
                <span>{{ $t('حلال', 'Halal', 'Halal Only') }}</span>
            </span>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $allergyBreakdown['HALAL_ONLY'] ?? 0 }}</p>
        </div>

    </div>

    {{-- FILTER TOOLBAR (SCREEN ONLY) --}}
    <div class="print:hidden bg-white dark:bg-slate-800 p-4 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div class="flex-1 flex flex-col sm:flex-row flex-wrap items-center gap-3">
            {{-- Search Input --}}
            <div class="relative w-full sm:w-64">
                <input type="text" wire:model.live.debounce.300ms="searchQuery"
                       placeholder="{{ $t('بحث بالاسم، جواز السفر أو الملاحظات...', 'Rechercher par nom, passeport ou notes...', 'Search by name, passport, or notes...') }}"
                       class="w-full ps-9 pe-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:bg-white transition">
                <svg class="w-4 h-4 text-slate-400 absolute start-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            {{-- Country Filter --}}
            <select wire:model.live="selectedCountryId"
                    class="w-full sm:w-48 py-2.5 px-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <option value="ALL">{{ $t('جميع الدول والوفود', 'Toutes les Délégations', 'All Country Delegations') }}</option>
                @foreach($countries as $c)
                    <option value="{{ $c->id }}">{{ $c->name_ar }} ({{ $c->iso3 }})</option>
                @endforeach
            </select>

            {{-- Role Filter --}}
            <select wire:model.live="selectedRole"
                    class="w-full sm:w-44 py-2.5 px-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <option value="ALL">{{ $t('جميع الأدوار', 'Tous les Rôles', 'All Member Roles') }}</option>
                @foreach($roles as $rKey => $rLabels)
                    <option value="{{ $rKey }}">{{ $t($rLabels['ar'], $rLabels['fr'], $rLabels['en']) }}</option>
                @endforeach
            </select>

            {{-- Allergy Filter --}}
            <select wire:model.live="selectedAllergyFilter"
                    class="w-full sm:w-52 py-2.5 px-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <option value="ALL">{{ $t('جميع الحالات', 'Toutes les Allergies', 'All Dietary Statuses') }}</option>
                <option value="HAS_ALLERGY">{{ $t('لديهم احتياجات غذائية فقط', 'Avec Rédictions Uniquement', 'Has Dietary Restrictions Only') }}</option>
                <option value="NO_ALLERGY">{{ $t('بدون حساسية غذائية', 'Sans Allergie', 'No Dietary Restrictions') }}</option>
                <hr>
                @foreach($dietaryOptions as $code => $opt)
                    <option value="{{ $code }}">{{ $opt['label_ar'] }}</option>
                @endforeach
            </select>
        </div>

        {{-- Per Page --}}
        <div class="flex items-center gap-2 shrink-0">
            <span class="text-xs font-bold text-slate-400">{{ $t('عرض:', 'Afficher:', 'Show:') }}</span>
            <select wire:model.live="perPage" class="py-2 px-3 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <option value="15">15</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    {{-- MAIN TABLE ROSTER CONTAINER --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden print:border-none print:shadow-none">
        
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-black text-[10px]">
                        <th class="p-4 text-start">#</th>
                        <th class="p-4 text-start">{{ $t('المشارك / العضو', 'Membre / Participant', 'Member / Participant') }}</th>
                        <th class="p-4 text-start">{{ $t('الوفد والدولة', 'Délégation & Pays', 'Delegation & Country') }}</th>
                        <th class="p-4 text-start">{{ $t('نوع الحساسية والاحتياجات الغذائية', 'Régimes & Allergies Specified', 'Specified Dietary Requirements') }}</th>
                        <th class="p-4 text-start">{{ $t('ملاحظات وتوجيهات المطبخ الطبي', 'Notes Spéciales Cuisine', 'Medical & Kitchen Notes') }}</th>
                        <th class="p-4 text-end print:hidden">{{ $t('الإجراءات والتحكم', 'Actions', 'Actions & Controls') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-bold">
                    @forelse($members as $index => $m)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-900/30 transition">
                            
                            {{-- Index --}}
                            <td class="p-4 text-slate-400 font-mono text-[11px]">
                                {{ $members->firstItem() + $index }}
                            </td>

                            {{-- Member Info --}}
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-[#06205C]/10 dark:bg-slate-700 text-[#06205C] dark:text-amber-400 font-black flex items-center justify-center shrink-0 border border-[#06205C]/20">
                                        {{ mb_substr($m->first_name, 0, 1) }}{{ mb_substr($m->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-900 dark:text-white text-xs sm:text-sm">
                                            {{ $m->full_name }}
                                        </p>
                                        <div class="flex items-center gap-2 text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">
                                            @if($m->passport_number)
                                                <span class="font-mono bg-slate-100 dark:bg-slate-700 px-1.5 py-0.5 rounded border border-slate-200 dark:border-slate-600">{{ $m->passport_number }}</span>
                                            @endif
                                            @if($m->gender)
                                                <span>{{ $m->gender === 'MALE' ? $t('ذكر', 'Homme', 'Male') : $t('أنثى', 'Femme', 'Female') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Country Delegation & Role --}}
                            <td class="p-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-black text-slate-800 dark:text-slate-200">
                                            {{ $m->delegation?->country?->name_ar ?? $t('غير محدد', 'Non Spécifié', 'Unspecified') }}
                                        </span>
                                    </div>
                                    <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                        {{ $roles[$m->member_type]['ar'] ?? $m->member_type }}
                                    </span>
                                </div>
                            </td>

                            {{-- Dietary Requirements Badges --}}
                            <td class="p-4">
                                @if(is_array($m->dietary_requirements) && count($m->dietary_requirements) > 0)
                                    <div class="flex flex-wrap gap-1.5 max-w-xs">
                                        @foreach($m->dietary_requirements as $reqCode)
                                            @php $opt = $dietaryOptions[$reqCode] ?? null; @endphp
                                            @if($opt)
                                                <span class="px-2.5 py-1 rounded-xl text-[11px] font-black border flex items-center gap-1.5 shadow-2xs {{ $opt['badge'] }}">
                                                    {!! $dietaryIcons[$reqCode] ?? '' !!}
                                                    <span>{{ $opt['label_ar'] }}</span>
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-300">
                                                    {{ $reqCode }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-emerald-600 dark:text-emerald-400 font-bold text-[11px] bg-emerald-50 dark:bg-emerald-950/30 px-2.5 py-1 rounded-xl border border-emerald-200/50 inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span>{{ $t('بدون حساسية (وجبات عادية)', 'Régime Normal Standard', 'Standard Diet (No Allergies)') }}</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Medical Notes --}}
                            <td class="p-4 max-w-xs">
                                @if($m->dietary_notes)
                                    <div class="text-xs text-amber-900 dark:text-amber-200 font-bold bg-amber-50 dark:bg-amber-950/40 p-2.5 rounded-2xl border border-amber-200/80 dark:border-amber-900/60 space-y-0.5">
                                        <div class="flex items-center gap-1 text-[10px] text-amber-700 dark:text-amber-400 font-black">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>{{ $t('توجيهات المطبخ الطبي:', 'Instruction Cuisine:', 'Kitchen Instruction:') }}</span>
                                        </div>
                                        <p class="leading-relaxed">{{ $m->dietary_notes }}</p>
                                    </div>
                                @else
                                    <span class="text-slate-400 text-[11px] font-normal">—</span>
                                @endif
                            </td>

                            {{-- Actions Column (SCREEN ONLY) --}}
                            <td class="p-4 text-end print:hidden">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Edit Button --}}
                                    <button wire:click="openEditModal({{ $m->id }})"
                                            title="{{ $t('تعديل البيانات والحساسية', 'Modifier', 'Edit Info & Dietary') }}"
                                            class="px-2.5 py-1.5 rounded-xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-[11px] shadow-2xs transition inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>{{ $t('تعديل', 'Modifier', 'Edit') }}</span>
                                    </button>

                                    {{-- Clear Dietary Button --}}
                                    @if((is_array($m->dietary_requirements) && count($m->dietary_requirements) > 0) || $m->dietary_notes)
                                        <button wire:click="confirmDelete({{ $m->id }}, 'CLEAR_DIETARY')"
                                                title="{{ $t('مسح وتفريغ سجل الحساسية فقط', 'Vider Allergies', 'Clear Dietary Info') }}"
                                                class="px-2.5 py-1.5 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-900 dark:bg-amber-900/40 dark:text-amber-200 font-bold text-[11px] transition inline-flex items-center gap-1 border border-amber-300 dark:border-amber-800">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span>{{ $t('مسح الحساسية', 'Vider', 'Clear') }}</span>
                                        </button>
                                    @endif

                                    {{-- Delete Member Button --}}
                                    <button wire:click="confirmDelete({{ $m->id }}, 'DELETE_MEMBER')"
                                            title="{{ $t('حذف السجل بالكامل من قاعدة البيانات', 'Supprimer Membre', 'Delete Member Record') }}"
                                            class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 font-bold text-xs">
                                {{ $t('لا يوجد سجلات طعام أو أعضاء مطابقين للفلتر المحدد.', 'Aucun membre correspondant.', 'No delegation members match the selected filters.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (SCREEN ONLY) --}}
        <div class="print:hidden p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $members->links() }}
        </div>
    </div>

    {{-- ==================== ADD MEMBER & DIETARY MODAL ==================== --}}
    @if($showAddModal)
        <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto print:hidden">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-2xl w-full p-6 space-y-5 shadow-2xl border border-slate-200 dark:border-slate-700 max-h-[90vh] overflow-y-auto my-auto">
                
                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-500 text-white font-black flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white">
                                {{ $t('إضافة حالة غذائية / عضو جديد لقاعدة البيانات', 'Nouveau Membre & Régime', 'Add New Member & Dietary Record') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold">{{ $t('إدخال بيانات المشارك وتحديد حساسية الطعام بالكامل', 'Saisissez les informations et spécifiez le régime alimentaire', 'Enter member details and specify dietary profile') }}</p>
                        </div>
                    </div>
                    <button wire:click="$set('showAddModal', false)" class="text-slate-400 hover:text-slate-600 font-black text-lg"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                {{-- Basic Member Fields Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الاسم الأول *', 'Prénom *', 'First Name *') }}</label>
                        <input type="text" wire:model="addFirstName" placeholder="مثال: محمد" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        @error('addFirstName') <span class="text-rose-600 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('اللقب / اسم العائلة *', 'Nom *', 'Last Name *') }}</label>
                        <input type="text" wire:model="addLastName" placeholder="مثال: بن علي" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        @error('addLastName') <span class="text-rose-600 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الدولة / الوفد *', 'Délégation *', 'Country Delegation *') }}</label>
                        <select wire:model="addCountryId" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                            @foreach($countries as $c)
                                <option value="{{ $c->id }}">{{ $c->name_ar }} ({{ $c->iso3 }})</option>
                            @endforeach
                        </select>
                        @error('addCountryId') <span class="text-rose-600 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الصفة / الدور *', 'Rôle *', 'Role / Member Type *') }}</label>
                        <select wire:model="addMemberType" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                            @foreach($roles as $rKey => $rLabels)
                                <option value="{{ $rKey }}">{{ $t($rLabels['ar'], $rLabels['fr'], $rLabels['en']) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('رقم جواز السفر', 'N° Passeport', 'Passport Number') }}</label>
                        <input type="text" wire:model="addPassport" placeholder="A12345678" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الجنس', 'Genre', 'Gender') }}</label>
                        <select wire:model="addGender" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                            <option value="MALE">{{ $t('ذكر', 'Homme', 'Male') }}</option>
                            <option value="FEMALE">{{ $t('أنثى', 'Femme', 'Female') }}</option>
                        </select>
                    </div>
                </div>

                {{-- Dietary Checkboxes Grid --}}
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300">
                        {{ $t('حدد أنواع الحساسية والاحتياجات الغذائية الخاصة', 'Sélectionnez les allergies alimentarires', 'Select Food Allergies & Dietary Restrictions') }}
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($dietaryOptions as $code => $opt)
                            @php $isSelected = in_array($code, $addDietaryRequirements); @endphp
                            <div wire:click="toggleAddRequirement('{{ $code }}')"
                                 class="p-3 rounded-2xl border cursor-pointer transition-all flex items-center gap-2.5 select-none {{ $isSelected ? $opt['style'] . ' shadow-xs ring-2 ring-amber-400/40' : 'bg-slate-50 dark:bg-slate-900/60 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100' }}">
                                {!! $dietaryIcons[$code] ?? '' !!}
                                <span class="text-xs font-bold flex-1">{{ $opt['label_ar'] }}</span>
                                <div class="w-5 h-5 rounded-lg border flex items-center justify-center shrink-0 {{ $isSelected ? 'bg-amber-600 border-amber-600 text-white' : 'border-slate-300' }}">
                                    @if($isSelected)
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Medical Notes --}}
                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300">
                        {{ $t('ملاحظات وتوجيهات طبية للمطعم الرئيسي', 'Instructions Spéciales Cuisine', 'Medical Notes & Kitchen Instructions') }}
                    </label>
                    <textarea wire:model="addDietaryNotes" rows="2"
                              placeholder="{{ $t('مثال: عدم تقديم المكسرات أو أي مشتقات فول سوداني نهائياً...', 'Ex: Ne pas servir d’arachides...', 'Ex: Severe peanut allergy, double check all sauces...') }}"
                              class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white"></textarea>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showAddModal', false)" type="button" class="px-4 py-2.5 rounded-2xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="createMemberDietary" type="button" class="px-5 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition">
                        {{ $t('حفظ وحفظ السجل', 'Enregistrer Membre', 'Save Record & Dietary Info') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ==================== EDIT DIETARY MODAL ==================== --}}
    @if($showEditModal)
        <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto print:hidden">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-2xl w-full p-6 space-y-5 shadow-2xl border border-slate-200 dark:border-slate-700 max-h-[90vh] overflow-y-auto my-auto">
                
                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#06205C] text-amber-400 font-black flex items-center justify-center shrink-0 border border-[#06205C]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white">
                                {{ $t('تعديل البيانات والحساسية الغذائية', 'Modifier Régime Alimentaire & Allergies', 'Edit Food Allergies & Member Info') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold">{{ $editFirstName }} {{ $editLastName }}</p>
                        </div>
                    </div>
                    <button wire:click="$set('showEditModal', false)" class="text-slate-400 hover:text-slate-600 font-black text-lg"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                {{-- Member Info Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الاسم الأول', 'Prénom', 'First Name') }}</label>
                        <input type="text" wire:model="editFirstName" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('اللقب', 'Nom', 'Last Name') }}</label>
                        <input type="text" wire:model="editLastName" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الدولة / الوفد', 'Délégation', 'Delegation') }}</label>
                        <select wire:model="editCountryId" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                            @foreach($countries as $c)
                                <option value="{{ $c->id }}">{{ $c->name_ar }} ({{ $c->iso3 }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الصفة / الدور', 'Rôle', 'Role') }}</label>
                        <select wire:model="editMemberType" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                            @foreach($roles as $rKey => $rLabels)
                                <option value="{{ $rKey }}">{{ $t($rLabels['ar'], $rLabels['fr'], $rLabels['en']) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Checkboxes Grid --}}
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300">
                        {{ $t('حدد أنواع الحساسية والأنظمة الغذائية الخاصة', 'Sélectionnez les régimes & allergies', 'Select Food Allergies & Dietary Restrictions') }}
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($dietaryOptions as $code => $opt)
                            @php $isSelected = in_array($code, $memberDietaryRequirements); @endphp
                            <div wire:click="toggleRequirement('{{ $code }}')"
                                 class="p-3 rounded-2xl border cursor-pointer transition-all flex items-center gap-2.5 select-none {{ $isSelected ? $opt['style'] . ' shadow-xs ring-2 ring-amber-400/40' : 'bg-slate-50 dark:bg-slate-900/60 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100' }}">
                                {!! $dietaryIcons[$code] ?? '' !!}
                                <span class="text-xs font-bold flex-1">{{ $opt['label_ar'] }}</span>
                                <div class="w-5 h-5 rounded-lg border flex items-center justify-center shrink-0 {{ $isSelected ? 'bg-amber-600 border-amber-600 text-white' : 'border-slate-300' }}">
                                    @if($isSelected)
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Custom Notes --}}
                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300">
                        {{ $t('توجيهات وملاحظات طبية مخصصة للوجبات', 'Notes & Instructions Spéciales', 'Custom Medical Notes & Instructions') }}
                    </label>
                    <textarea wire:model="memberDietaryNotes" rows="3"
                              placeholder="{{ $t('توجيهات موجهة للمطبخ المركزي...', 'Instructions pour la cuisine...', 'Instructions for catering staff...') }}"
                              class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white"></textarea>
                </div>

                {{-- Modal Footer Actions --}}
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2.5 rounded-2xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="saveDietaryInfo" type="button" class="px-5 py-2.5 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs shadow-md transition">
                        {{ $t('حفظ التعديلات', 'Enregistrer Modifications', 'Save Changes') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ==================== DELETE / CLEAR CONFIRMATION MODAL ==================== --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto print:hidden">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700 my-auto text-center">
                
                <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 font-black flex items-center justify-center mx-auto border border-rose-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>

                @if($deleteActionType === 'CLEAR_DIETARY')
                    <h3 class="text-base font-black text-slate-900 dark:text-white">
                        {{ $t('تأكيد مسح وتفريغ سجل الحساسية؟', 'Confirmer la réinitialisation du régime ?', 'Confirm clearing dietary info?') }}
                    </h3>
                    <p class="text-xs font-bold text-slate-500">
                        {{ $t('سيتم إعادة السجل إلى الوجبة العادية للمشارك: ', 'Le membre reviendra au régime standard: ', 'Member will return to standard diet: ') }}
                        <span class="text-slate-900 dark:text-white font-black">{{ $deletingMemberName }}</span>
                    </p>
                @else
                    <h3 class="text-base font-black text-rose-600">
                        {{ $t('تأكيد حذف المشارك نهائياً من قاعدة البيانات؟', 'Confirmer la suppression définitive ?', 'Confirm deleting member completely?') }}
                    </h3>
                    <p class="text-xs font-bold text-slate-500">
                        {{ $t('سيتم حذف السجل بالكامل للمشارك: ', 'Le membre suivant sera supprimé définitivement: ', 'The following member will be permanently deleted: ') }}
                        <span class="text-slate-900 dark:text-white font-black">{{ $deletingMemberName }}</span>
                    </p>
                @endif

                <div class="flex items-center justify-center gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showDeleteModal', false)" type="button" class="px-4 py-2.5 rounded-2xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="executeDeleteAction" type="button"
                            class="px-5 py-2.5 rounded-2xl {{ $deleteActionType === 'CLEAR_DIETARY' ? 'bg-amber-600 hover:bg-amber-700' : 'bg-rose-600 hover:bg-rose-700' }} text-white font-black text-xs shadow-md transition">
                        {{ $deleteActionType === 'CLEAR_DIETARY' ? $t('تأكيد المسح', 'Confirmer Vider', 'Confirm Clear') : $t('حذف نهائي', 'Supprimer', 'Delete Permanently') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>
