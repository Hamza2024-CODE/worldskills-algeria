@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };

$dietaryOptions = [
    'GLUTEN_FREE'     => [
        'icon' => '<svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18m0-18l-3 3m3-3l3 3m-3 6l-4 4m4-4l4 4m-4 4l-3 3m3-3l3 3"/></svg>',
        'label' => $t('خالي من الغلوتين / القمح', 'Sans Gluten', 'Gluten-Free'),
        'style' => 'bg-amber-50 text-amber-900 border-amber-300'
    ],
    'LACTOSE_FREE'    => [
        'icon' => '<svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.594 15.12a2 2 0 00-1.801.572l-.707.707A1 1 0 003 17.107V19a2 2 0 002 2h14a2 2 0 002-2v-1.893a1 1 0 00-.293-.707l-.707-.707z"/></svg>',
        'label' => $t('خالي من اللاكتوز / الحليب', 'Sans Lactose', 'Lactose-Free'),
        'style' => 'bg-sky-50 text-sky-900 border-sky-300'
    ],
    'NUT_ALLERGY'     => [
        'icon' => '<svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        'label' => $t('حساسية المكسرات والفول السوداني', 'Allergie aux Fruits à Coque', 'Nut & Peanut Allergy'),
        'style' => 'bg-rose-50 text-rose-900 border-rose-300'
    ],
    'SEAFOOD_ALLERGY' => [
        'icon' => '<svg class="w-4 h-4 text-cyan-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
        'label' => $t('حساسية السمك والمأكولات البحرية', 'Allergie aux Fruits de Mer', 'Seafood Allergy'),
        'style' => 'bg-cyan-50 text-cyan-900 border-cyan-300'
    ],
    'HALAL_ONLY'      => [
        'icon' => '<svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'label' => $t('حلال فقط', 'Halal Uniquement', 'Halal Only'),
        'style' => 'bg-emerald-50 text-emerald-900 border-emerald-300'
    ],
    'VEGETARIAN'      => [
        'icon' => '<svg class="w-4 h-4 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>',
        'label' => $t('نباتي (Vegetarian)', 'Végétarien', 'Vegetarian'),
        'style' => 'bg-green-50 text-green-900 border-green-300'
    ],
    'VEGAN'           => [
        'icon' => '<svg class="w-4 h-4 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
        'label' => $t('نباتي تام (Vegan)', 'Végétalien (Vegan)', 'Vegan'),
        'style' => 'bg-teal-50 text-teal-900 border-teal-300'
    ],
    'DIABETIC'        => [
        'icon' => '<svg class="w-4 h-4 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
        'label' => $t('حمية لمرضى السكري', 'Régime Diabétique', 'Diabetic Diet'),
        'style' => 'bg-purple-50 text-purple-900 border-purple-300'
    ],
];
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER BAND --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#06205C] text-white flex items-center justify-center font-black shrink-0 shadow-md">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-[#06205C] dark:text-white tracking-tight">
                    {{ $t('مركز القيادة: سجل حساسيات الطعام والاحتياجات الغذائية العامة', 'Registre National des Allergies Alimentaires & Régimes', 'Central Kitchen & Food Allergies Control Register') }}
                </h1>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-1">
                    {{ $t('متابعة وطباعة السجل الموحد لحساسية الطعام والأنظمة الغذائية الخاصة لجميع الكوادر والوفود الأفريقية لتوجيه فريق المطعم المركزي.', 'Suivi global des régimes alimentaires et allergies pour toutes les délégations africaines.', 'Centralized audit register for food allergies, catering teams, and dietary needs across all African delegations.') }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>{{ $t('طباعة كشف المطبخ المركزي', 'Imprimer le rapport global', 'Print Central Kitchen Roster') }}</span>
            </button>
        </div>
    </div>

    {{-- FLASH NOTIFICATION --}}
    @if($flashMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ $flashMessage }}</span>
            </div>
            <button wire:click="$set('flashMessage', '')" class="text-emerald-700 hover:text-emerald-900 font-black text-xs"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
        </div>
    @endif

    {{-- SUMMARY KPI CARDS GRID --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3">
        
        {{-- Total Roster --}}
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1">
            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider block">
                {{ $t('إجمالي الكوادر والوفود', 'Total Tous Membres', 'Total Members') }}
            </span>
            <p class="text-2xl font-black text-[#06205C] dark:text-white">{{ $totalMembers }}</p>
            <span class="text-[10px] font-bold text-slate-500">{{ $t('عضو مسجل', 'Inscrits', 'Registered') }}</span>
        </div>

        {{-- Members with Allergies --}}
        <div class="bg-amber-50 dark:bg-amber-950/40 p-4 rounded-2xl border border-amber-200/80 dark:border-amber-900/60 shadow-xs text-center space-y-1">
            <span class="text-amber-700 dark:text-amber-400 text-[10px] font-black uppercase tracking-wider block">
                {{ $t('احتياجات غذائية خاصة', 'Cas Particuliers', 'Dietary Requirements') }}
            </span>
            <p class="text-2xl font-black text-amber-900 dark:text-amber-200">{{ $membersWithAllergiesCount }}</p>
            <span class="text-[10px] font-bold text-amber-700 dark:text-amber-400">
                {{ $totalMembers > 0 ? round(($membersWithAllergiesCount / $totalMembers) * 100) : 0 }}% {{ $t('من الإجمالي', 'du total', 'of total') }}
            </span>
        </div>

        {{-- Gluten Free --}}
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1">
            <span class="text-amber-600 text-[10px] font-black uppercase tracking-wider flex items-center justify-center gap-1">
                {!! $dietaryOptions['GLUTEN_FREE']['icon'] !!}
                <span>{{ $t('غلوتين', 'Sans Gluten', 'Gluten-Free') }}</span>
            </span>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $allergyBreakdown['GLUTEN_FREE'] ?? 0 }}</p>
        </div>

        {{-- Lactose Free --}}
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1">
            <span class="text-sky-600 text-[10px] font-black uppercase tracking-wider flex items-center justify-center gap-1">
                {!! $dietaryOptions['LACTOSE_FREE']['icon'] !!}
                <span>{{ $t('حليب', 'Sans Lactose', 'Lactose-Free') }}</span>
            </span>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $allergyBreakdown['LACTOSE_FREE'] ?? 0 }}</p>
        </div>

        {{-- Nut Allergy --}}
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1">
            <span class="text-rose-600 text-[10px] font-black uppercase tracking-wider flex items-center justify-center gap-1">
                {!! $dietaryOptions['NUT_ALLERGY']['icon'] !!}
                <span>{{ $t('مكسرات', 'Fruits à Coque', 'Nut Allergy') }}</span>
            </span>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $allergyBreakdown['NUT_ALLERGY'] ?? 0 }}</p>
        </div>

    </div>

    {{-- FILTER TOOLBAR --}}
    <div class="bg-white dark:bg-slate-800 p-4 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div class="flex-1 flex flex-col sm:flex-row flex-wrap items-center gap-3">
            {{-- Search --}}
            <div class="relative w-full sm:w-64">
                <input type="text" wire:model.live.debounce.300ms="searchQuery"
                       placeholder="{{ $t('بحث بالاسم أو جواز السفر...', 'Rechercher par nom ou passeport...', 'Search by name or passport...') }}"
                       class="w-full ps-9 pe-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:bg-white transition">
                <svg class="w-4 h-4 text-slate-400 absolute start-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            {{-- Country Filter --}}
            <select wire:model.live="selectedCountryId" class="px-3 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white max-w-xs">
                <option value="ALL">{{ $t('جميع الوفود الأفريقية والدول', 'Toutes les délégations', 'All African Delegations') }}</option>
                @foreach($countries as $c)
                    <option value="{{ $c->id }}">{{ $c->code }} — {{ $c->getLocalized('name') }}</option>
                @endforeach
            </select>

            {{-- Role Filter --}}
            <select wire:model.live="selectedRole" class="px-3 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <option value="ALL">{{ $t('جميع الفئات', 'Toutes les catégories', 'All Member Types') }}</option>
                <option value="PARTICIPANT">{{ $t('متنافسون', 'Compétiteurs', 'Competitors') }}</option>
                <option value="EXPERT">{{ $t('حكام وخبراء', 'Juges & Experts', 'Judges & Experts') }}</option>
                <option value="ORGANIZER">{{ $t('منظمون ومؤطرون', 'Organisateurs', 'Organizers') }}</option>
                <option value="PRESS">{{ $t('إعلام وصحافة', 'Presse & Médias', 'Press & Media') }}</option>
                <option value="VIP">{{ $t('وفود رسمية VIP', 'Délégations VIP', 'VIP Officials') }}</option>
            </select>

            {{-- Allergy Filter --}}
            <select wire:model.live="selectedAllergyFilter" class="px-3 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <option value="ALL">{{ $t('جميع الحالات الغذائية', 'Tous les régimes', 'All Dietary Statuses') }}</option>
                <option value="HAS_ALLERGY">{{ $t('لديهم حساسية / نظام خاص فقط', 'Avec allergies/régimes uniquement', 'With Dietary Requirements Only') }}</option>
                @foreach($dietaryOptions as $code => $opt)
                    <option value="{{ $code }}">{{ $opt['label'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- MEMBERS TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 font-black uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-4 text-start">{{ $t('عضو الوفد والدولة', 'Membre & Pays', 'Member & Country') }}</th>
                        <th class="p-4 text-start">{{ $t('الصفة والدور', 'Rôle / Discipline', 'Role & Skill') }}</th>
                        <th class="p-4 text-start">{{ $t('الحساسية والاحتياجات الغذائية', 'Allergies & Régimes Spéciaux', 'Allergies & Dietary Restrictions') }}</th>
                        <th class="p-4 text-start">{{ $t('ملاحظات وتوجيهات الإطعام', 'Notes & Instructions', 'Special Notes & Instructions') }}</th>
                        <th class="p-4 text-end">{{ $t('الإجراءات', 'Actions', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($members as $m)
                        @php
                            $reqs = is_array($m->dietary_requirements) ? $m->dietary_requirements : [];
                            $countryName = $m->delegation?->country?->getLocalized('name') ?? 'الجزائر';
                            $countryCode = $m->delegation?->country?->code ?? 'DZA';
                        @endphp
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/50 transition">
                            {{-- Member Info & Country --}}
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-[#06205C] text-white font-black flex items-center justify-center shrink-0 border border-white/20 uppercase">
                                        {{ mb_substr($m->first_name ?: 'M', 0, 1) }}{{ mb_substr($m->last_name ?: '', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-black text-slate-900 dark:text-slate-100 block text-xs">{{ $m->first_name }} {{ $m->last_name }}</span>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 font-mono font-black text-[10px]">
                                                {{ $countryCode }}
                                            </span>
                                            <span class="text-[11px] font-bold text-slate-500">{{ $countryName }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Role --}}
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase border bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 border-slate-200 dark:border-slate-600">
                                    {{ $m->member_type }}
                                </span>
                            </td>

                            {{-- Dietary Requirements Tags --}}
                            <td class="p-4">
                                @if(!empty($reqs))
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($reqs as $rCode)
                                            @if(isset($dietaryOptions[$rCode]))
                                                @php $opt = $dietaryOptions[$rCode]; @endphp
                                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black border flex items-center gap-1.5 {{ $opt['style'] }}">
                                                    {!! $opt['icon'] !!}
                                                    <span>{{ $opt['label'] }}</span>
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black bg-slate-100 text-slate-700 border border-slate-200">
                                                    {{ $rCode }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-emerald-600 dark:text-emerald-400 text-[11px] font-bold flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $t('عادي / لا توجد حساسية', 'Aucune restriction', 'Standard / No restrictions') }}
                                    </span>
                                @endif
                            </td>

                            {{-- Special Notes --}}
                            <td class="p-4 max-w-xs">
                                @if($m->dietary_notes)
                                    <p class="text-xs text-slate-700 dark:text-slate-300 font-bold bg-amber-50/60 dark:bg-amber-950/30 p-2 rounded-xl border border-amber-200/50 line-clamp-2">
                                        {{ $m->dietary_notes }}
                                    </p>
                                @else
                                    <span class="text-slate-400 text-[11px]">—</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="p-4 text-end">
                                <button wire:click="openEditModal({{ $m->id }})"
                                        class="px-3.5 py-2 rounded-xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-[11px] shadow-sm transition inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>{{ $t('تعديل الحساسية', 'Modifier Régime', 'Edit Dietary Info') }}</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400 font-bold text-xs">
                                {{ $t('لا يوجد أعضاء مطابقون للفلتر المحدد.', 'Aucun membre correspondant.', 'No delegation members match the current filter.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $members->links() }}
        </div>
    </div>

    {{-- EDIT DIETARY MODAL --}}
    @if($showEditModal && $editingMember)
        <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 space-y-5 shadow-2xl border border-slate-200 dark:border-slate-700 max-h-[85vh] overflow-y-auto my-auto">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-700 font-black flex items-center justify-center shrink-0 border border-amber-200">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white">
                                {{ $t('تحديد حساسية الطعام والاحتياجات الغذائية', 'Régime Alimentaire & Allergies', 'Set Food Allergies & Dietary Needs') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold">{{ $editingMember->first_name }} {{ $editingMember->last_name }} ({{ $editingMember->member_type }})</p>
                        </div>
                    </div>
                    <button wire:click="$set('showEditModal', false)" class="text-slate-400 hover:text-slate-600 font-black text-lg"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                {{-- Checkbox Options Grid --}}
                <div class="space-y-3">
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300">
                        {{ $t('اختر أنواع الحساسية والأنظمة الغذائية الخاصة *', 'Sélectionnez les allergies et régimes spéciaux *', 'Select Food Allergies & Dietary Restrictions *') }}
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach($dietaryOptions as $code => $opt)
                            @php $isSelected = in_array($code, $memberDietaryRequirements); @endphp
                            <div wire:click="toggleRequirement('{{ $code }}')"
                                 class="p-3 rounded-2xl border cursor-pointer transition-all flex items-center gap-3 select-none {{ $isSelected ? $opt['style'] . ' shadow-xs ring-2 ring-amber-400/40' : 'bg-slate-50 dark:bg-slate-900/60 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100' }}">
                                {!! $opt['icon'] !!}
                                <span class="text-xs font-bold flex-1">{{ $opt['label'] }}</span>
                                <div class="w-5 h-5 rounded-lg border flex items-center justify-center shrink-0 {{ $isSelected ? 'bg-amber-600 border-amber-600 text-white' : 'border-slate-300' }}">
                                    @if($isSelected)
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Custom Notes & Medical Instructions --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-700 dark:text-slate-300">
                        {{ $t('ملاحظات وتوجيهات طبية مخصصة للوجبات', 'Notes & Instructions Spéciales', 'Custom Medical Notes & Instructions') }}
                    </label>
                    <textarea wire:model="memberDietaryNotes" rows="3"
                              placeholder="{{ $t('مثال: حساسية شديدة من السمسم، يرجى عزل أدوات الطهي بالكامل...', 'Ex: Allergie sévère au sésame, séparer les ustensiles de cuisine...', 'Ex: Severe sesame allergy, use separate cooking utensils...') }}"
                              class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:bg-white transition"></textarea>
                </div>

                {{-- Modal Footer Actions --}}
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2.5 rounded-2xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="saveDietaryInfo" type="button" class="px-5 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition">
                        {{ $t('حفظ بيانات الحساسية', 'Enregistrer Régime', 'Save Dietary Information') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>
