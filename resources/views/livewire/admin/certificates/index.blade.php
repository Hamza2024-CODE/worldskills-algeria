@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-6 pb-12 font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <x-dashboard.page-header
        :title="$t('إدارة وتوثيق الشهادات الرسمية للمسابقات (Certificates Directory)', 'Gestion & Émission des Certificats Officiels', 'Official Certificates Management & Generation')"
        :subtitle="$t('استخراج وتوثيق شهادات المشاركة والتتويج والتقدير للخبراء والوفود والمتعاملين المعتمدين حصراً', 'Génération et vérification des certificats officiels par rôle et résultats', 'Issue and verify official certificates for approved members and dignitaries')"
    >
        <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-black transition backdrop-blur-md shadow-xs shrink-0 cursor-pointer">
            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>{{ $t('تصدير الشهادات إلى Excel (CSV)', 'Exporter vers Excel', 'Export Certificates to Excel') }}</span>
        </button>

        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-black transition shadow-md shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            <span>{{ $t('استخراج شهادة مخصصة', 'Émettre un Certificat Custom', 'Issue Custom Certificate') }}</span>
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

    {{-- FLOATING BULK SELECTION ACTION BAR --}}
    @if(count($selectedRegistrations) > 0)
        <div class="p-4 bg-slate-900 dark:bg-slate-800 text-white rounded-3xl shadow-xl border border-slate-700 flex flex-wrap items-center justify-between gap-4 animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center font-black text-sm">
                    {{ count($selectedRegistrations) }}
                </div>
                <span class="text-xs font-bold">
                    {{ $t('عنصر محدد لعمليات الطباعة والتصدير الجماعي للشهادات', 'certificats sélectionnés', 'certificates selected for bulk action') }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <button wire:click="exportExcel" class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs transition shadow-md flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>{{ $t('تصدير بيانات الشهادات المحددة', 'Exporter Sélectionnés', 'Export Selected') }}</span>
                </button>
                <button wire:click="clearSelection" class="px-4 py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition cursor-pointer">
                    {{ $t('إلغاء التحديد', 'Désélectionner', 'Clear Selection') }}
                </button>
            </div>
        </div>
    @endif

    {{-- STATS OVERVIEW CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Approved Members -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('إجمالي الأعضاء المعتمدين', 'Total Accrédités Éligibles', 'Total Approved Eligible Members') }}
                    </span>
                    <span class="text-3xl font-black text-slate-900 dark:text-white mt-1 block">
                        {{ number_format($totalApproved) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-blue-600 dark:text-blue-400 flex items-center gap-1">
                <span>{{ $t('أعضاء مقبولين وموثقين (يستبعد المرفوضين)', 'Exclusion stricte des rejetés', 'Excludes rejected applications') }}</span>
            </div>
        </div>

        <!-- Card 2: Medal Winners -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('المتوجون بالميداليات (🥇 🥈 🥉)', 'Médaillés (Or, Argent, Bronze)', 'Medal Winners (Gold, Silver, Bronze)') }}
                    </span>
                    <span class="text-3xl font-black text-amber-600 dark:text-amber-400 mt-1 block">
                        {{ number_format($winnersCount) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-amber-600 dark:text-amber-400 flex items-center gap-2">
                <span>{{ $goldCount }} ذهبية</span> • <span>{{ $silverCount }} فضية</span> • <span>{{ $bronzeCount }} برونزية</span>
            </div>
        </div>

        <!-- Card 3: Excellence Medallions -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('شهادات التميز (CIS >= 700)', 'Médaillons d\'Excellence (CIS >= 700)', 'Medallions for Excellence') }}
                    </span>
                    <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400 mt-1 block">
                        {{ number_format($excellenceCount) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.229-1.004l-1.9-3.8a2 2 0 01.371-2.434l3.193-3.193a2 2 0 012.434-.371l3.8 1.9a2 2 0 011.004 1.229l.477 2.387a6 6 0 00.517 3.86l.158.318a6 6 0 01.517 3.86l.477 2.387a2 2 0 00.547 1.022l2.387.477a2 2 0 002.434-.371l3.193-3.193a2 2 0 00.371-2.434l-1.9-3.8z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-1">
                <span>{{ $t('مجموع نقاط تميز فائق في التقييم', 'Score de performance élevé', 'High CIS performance score') }}</span>
            </div>
        </div>

        <!-- Card 4: Official Delegations & Experts -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">
                        {{ $t('شهادات الحكام، الوفود، والشركاء', 'Certificats Experts, Délégations, Partenaires', 'Experts, Delegations & Partners') }}
                    </span>
                    <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-1 block">
                        {{ number_format(max(0, $totalApproved - $winnersCount)) }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0v-4a1 1 0 011-1h2a1 1 0 011 1v4m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                <span>{{ $t('خبراء، رؤساء وفود، شركاء، وإعلاميون', 'Experts, Chefs de délégations, Partenaires', 'Experts, Delegation Heads, Partners') }}</span>
            </div>
        </div>
    </div>

    {{-- ADVANCED FILTER BAR WITH WILAYA & CENTER FILTERS --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 space-y-4 shadow-xs">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/60 pb-3">
            <h2 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>{{ $t('تصفية متطورة جداً حسب الدور، النقاط، الولاية، والمركز للمعتمدين فقط', 'Filtrage Avancé (Rôle, Score, Wilaya, Centre)', 'Advanced Filter (Role, Score, Wilaya, Center)') }}</span>
            </h2>
            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold">
                {{ $t('عرض ', 'Affichage de ', 'Displaying ') }} {{ $registrations->total() }} {{ $t(' عضو معتمد مستحق', ' membres éligibles', ' eligible members') }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-3">
            <!-- Search -->
            <div class="relative xl:col-span-2">
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="{{ $t('بحث باسم العضو، رقم التسجيل، الهوية...', 'Recherche par nom, numéro...', 'Search name, reg number, ID...') }}"
                    class="w-full ps-10 pe-4 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                <svg class="w-4 h-4 text-slate-400 absolute start-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Role Filter -->
            <div>
                <select wire:model.live="filterRole" class="w-full px-3 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">{{ $t('-- كل الأدوار والصفات --', '-- Tous les rôles --', '-- All Roles --') }}</option>
                    <option value="COMPETITOR">COMPETITOR / مشارك متنافس</option>
                    <option value="EXPERT_JUDGE">EXPERT JUDGE / حكم خبير</option>
                    <option value="DELEGATION_HEAD">DELEGATION HEAD / رئيس وفد</option>
                    <option value="SUPERVISOR">SUPERVISOR / مؤطر وقائد فريق</option>
                    <option value="ECONOMIC_PARTNER">ECONOMIC PARTNER / متعامل اقتصادي</option>
                    <option value="MEDIA">MEDIA / صحفي إعلامي</option>
                    <option value="VIP">VIP / ضيف شرف</option>
                    <option value="ORGANIZER">ORGANIZER / منظم وإداري</option>
                </select>
            </div>

            <!-- Award / CIS Score Filter -->
            <div>
                <select wire:model.live="filterAward" class="w-full px-3 py-2.5 text-xs rounded-2xl border border-amber-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-amber-900 dark:text-amber-300 font-bold focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value="">{{ $t('-- نتائج التقييم والنقاط --', '-- Tous les résultats --', '-- Results & Scores --') }}</option>
                    <option value="WINNERS_ONLY">🏆 المتوجون بالميداليات فقط</option>
                    <option value="WINNER_GOLD">🥇 الميدالية الذهبية (المركز 1)</option>
                    <option value="WINNER_SILVER">🥈 الميدالية الفضية (المركز 2)</option>
                    <option value="WINNER_BRONZE">🥉 الميدالية البرونزية (المركز 3)</option>
                    <option value="MEDALLION_EXCELLENCE">🎖️ شهادة التميز (CIS >= 700)</option>
                    <option value="PARTICIPATION">📜 شهادة مشاركة وتأهل عامة</option>
                </select>
            </div>

            <!-- Wilaya Filter -->
            <div>
                <select wire:model.live="filterWilaya" class="w-full px-3 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">{{ $t('-- كل الولايات --', '-- Toutes les Wilayas --', '-- All Wilayas --') }}</option>
                    @foreach($wilayas as $w)
                        <option value="{{ $w->id }}">{{ $w->code }} - {{ $w->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Center / Organization Filter -->
            <div>
                <select wire:model.live="filterCenter" class="w-full px-3 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">{{ $t('-- كل المراكز والمؤسسات --', '-- Tous les centres --', '-- All Centers --') }}</option>
                    @foreach($organizations as $org)
                        <option value="{{ $org->id }}">{{ Str::limit($org->name_ar, 30) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Skill Filter -->
            <div>
                <select wire:model.live="filterSkill" class="w-full px-3 py-2.5 text-xs rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">{{ $t('-- كل التخصصات --', '-- Tous les métiers --', '-- All Skills --') }}</option>
                    @foreach($skills as $s)
                        <option value="{{ $s->id }}">{{ $s->name_ar }} ({{ $s->code }})</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- CERTIFICATES DATA TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-xs text-start border-collapse align-middle">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-900/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200/80 dark:border-slate-700/80">
                        <th class="px-4 py-4 text-center w-10">
                            <input type="checkbox" wire:model.live="selectAll" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                        </th>
                        <th class="px-5 py-4 text-start min-w-[220px]">{{ $t('المستفيد / المترشح المعتمد', 'Membre Accrédité', 'Approved Member') }}</th>
                        <th class="px-5 py-4 text-start min-w-[150px] whitespace-nowrap">{{ $t('رقم التسجيل والتوثيق', 'N° Enregistrement', 'Registration Number') }}</th>
                        <th class="px-5 py-4 text-start min-w-[150px] whitespace-nowrap">{{ $t('الدور والقبول', 'Rôle & Statut', 'Role & Approval') }}</th>
                        <th class="px-5 py-4 text-start min-w-[200px] whitespace-nowrap">{{ $t('التخصص والمركز والولاية', 'Métier & Centre', 'Trade & Institution') }}</th>
                        <th class="px-5 py-4 text-start min-w-[170px] whitespace-nowrap">{{ $t('نقاط التقييم CIS والرتبة', 'Score CIS & Rang', 'CIS Score & Rank') }}</th>
                        <th class="px-5 py-4 text-center min-w-[340px] whitespace-nowrap">{{ $t('خيارات شهادات التتويج والتقدير الرسمية', 'Certificats Officiels', 'Official Certificate Links') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @forelse($registrations as $reg)
                        @php
                            $num       = $reg->registration_number;
                            $nameAr    = $reg->participant?->first_name_ar ? ($reg->participant->first_name_ar . ' ' . $reg->participant->last_name_ar) : $reg->user?->name;
                            $nameLatin = $reg->participant?->first_name_latin ? ($reg->participant->first_name_latin . ' ' . $reg->participant->last_name_latin) : $reg->user?->email;
                            $photoUrl  = $reg->photo_url;
                            $userRole  = $reg->user?->roles->first()?->name ?? 'PARTICIPANT';

                            $finalScore = $reg->result?->final_score;
                            $rank       = $reg->result?->rank;
                            $award      = $reg->result?->award;
                            $centerName = $reg->organization?->name_ar ?? '—';
                            $wilayaName = $reg->wilaya?->name_ar ?? '—';
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-900/40 transition">
                            <!-- Checkbox -->
                            <td class="px-4 py-4 text-center">
                                <input type="checkbox" wire:model.live="selectedRegistrations" value="{{ $reg->id }}" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            </td>

                            <!-- Beneficiary Info -->
                            <td class="px-5 py-4 min-w-[220px]">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $photoUrl }}" alt="{{ $nameAr }}" class="w-10 h-10 rounded-2xl object-cover border border-slate-200 dark:border-slate-700 shrink-0 bg-slate-100">
                                    <div>
                                        <span class="font-black text-slate-900 dark:text-white block text-xs leading-snug">
                                            {{ $nameAr }}
                                        </span>
                                        <span class="text-[11px] text-slate-500 dark:text-slate-400 font-mono block font-semibold">
                                            {{ $nameLatin }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Reg Number -->
                            <td class="px-5 py-4 font-mono font-bold text-slate-800 dark:text-slate-200 min-w-[150px] whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-700/60 border border-slate-200/60 dark:border-slate-700/60 inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $num }}</span>
                                </span>
                            </td>

                            <!-- Role & Status -->
                            <td class="px-5 py-4 min-w-[150px] whitespace-nowrap space-y-1">
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider block w-fit bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                                    {{ $userRole }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20 inline-block">
                                    مقبول معتمد
                                </span>
                            </td>

                            <!-- Skill & Institution & Wilaya -->
                            <td class="px-5 py-4 min-w-[200px] whitespace-nowrap">
                                <span class="block font-bold text-slate-800 dark:text-slate-200">{{ $reg->skill?->name_ar ?? 'تخصص مهني' }}</span>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 block font-medium truncate max-w-xs">{{ $centerName }} ({{ $wilayaName }})</span>
                            </td>

                            <!-- CIS Score & Rank -->
                            <td class="px-5 py-4 min-w-[170px] whitespace-nowrap">
                                @if($award === 'GOLD' || $rank == 1)
                                    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black bg-amber-500 text-white shadow-xs inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                        <span>المركز الأول (ذهبية)</span>
                                    </span>
                                @elseif($award === 'SILVER' || $rank == 2)
                                    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black bg-slate-400 text-white shadow-xs inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                        <span>المركز الثاني (فضية)</span>
                                    </span>
                                @elseif($award === 'BRONZE' || $rank == 3)
                                    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black bg-amber-700 text-white shadow-xs inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                        <span>المركز الثالث (برونزية)</span>
                                    </span>
                                @elseif($finalScore && $finalScore >= 700)
                                    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black bg-indigo-600 text-white shadow-xs inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ number_format($finalScore, 1) }} pts (تميز)</span>
                                    </span>
                                @elseif($finalScore)
                                    <span class="px-2.5 py-1 rounded-xl text-[10px] font-bold bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                                        {{ number_format($finalScore, 1) }} pts
                                    </span>
                                @else
                                    <span class="text-slate-400 font-bold">—</span>
                                @endif
                            </td>

                            <!-- Certificate Action Links -->
                            <td class="px-5 py-4 text-center min-w-[340px] whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1.5 flex-wrap">
                                    <!-- Gold -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'WINNER_GOLD']) }}" target="_blank"
                                        class="px-2.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-[10px] transition shadow-2xs inline-flex items-center gap-1 cursor-pointer" title="شهادة الميدالية الذهبية">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                        <span>ذهبية</span>
                                    </a>

                                    <!-- Silver -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'WINNER_SILVER']) }}" target="_blank"
                                        class="px-2.5 py-1.5 rounded-xl bg-slate-400 hover:bg-slate-500 text-white font-black text-[10px] transition shadow-2xs inline-flex items-center gap-1 cursor-pointer" title="شهادة الميدالية الفضية">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                        <span>فضية</span>
                                    </a>

                                    <!-- Bronze -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'WINNER_BRONZE']) }}" target="_blank"
                                        class="px-2.5 py-1.5 rounded-xl bg-amber-700 hover:bg-amber-800 text-white font-black text-[10px] transition shadow-2xs inline-flex items-center gap-1 cursor-pointer" title="شهادة الميدالية البرونزية">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                        <span>برونزية</span>
                                    </a>

                                    <!-- Participation -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'PARTICIPATION']) }}" target="_blank"
                                        class="px-2.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-[10px] transition shadow-2xs inline-flex items-center gap-1 cursor-pointer" title="شهادة مشاركة وتأهل">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>مشاركة</span>
                                    </a>

                                    <!-- Expert Judge -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'EXPERT_JUDGE']) }}" target="_blank"
                                        class="px-2.5 py-1.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-black text-[10px] transition shadow-2xs inline-flex items-center gap-1 cursor-pointer" title="شهادة تقدير حكم خبير">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5 5 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5 5 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                                        <span>حكم خبير</span>
                                    </a>

                                    <!-- Delegation Head -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'DELEGATION_HEAD']) }}" target="_blank"
                                        class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[10px] transition shadow-2xs inline-flex items-center gap-1 cursor-pointer" title="شهادة مسؤول ورئيس وفد">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0v-4a1 1 0 011-1h2a1 1 0 011 1v4m-4 0h4"/></svg>
                                        <span>رئيس وفد</span>
                                    </a>

                                    <!-- Economic Partner -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'ECONOMIC_PARTNER']) }}" target="_blank"
                                        class="px-2.5 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-black text-[10px] transition shadow-2xs inline-flex items-center gap-1 cursor-pointer" title="شهادة تقدير متعامل اقتصادي وراعي">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        <span>متعامل</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400 font-medium">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <svg class="w-10 h-10 mx-auto text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-xs font-bold text-slate-600 dark:text-slate-400">
                                        {{ $t('لا توجد نتائج تطابق الفلترة الحالية للشهادات المعتمدة', 'Aucun certificat trouvé', 'No certificates matching current filter') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="px-5 py-4 border-t border-slate-200/80 dark:border-slate-700/80 bg-slate-50/50 dark:bg-slate-900/40">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL: ISSUE CUSTOM CERTIFICATE --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-lg shadow-2xl border border-slate-200 dark:border-slate-700 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white">
                                {{ $t('استخراج وتوثيق شهادة رسمية مخصصة', 'Émettre un Certificat Officiel', 'Issue Custom Official Certificate') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $t('اختر العضو المسجل ونوع الشهادة المطلوبة للتوثيق', 'Sélectionnez le membre et le type de certificat', 'Select member and certificate type') }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('formOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4 text-xs font-semibold">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                            {{ $t('اختر العضو المسجل المعتمد *', 'Membre Inscrit *', 'Registered Approved Member *') }}
                        </label>
                        <select wire:model="registration_id" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="0">{{ $t('-- اختر مسجلاً / عضواً معتمداً --', '-- Choisir un membre --', '-- Select an approved member --') }}</option>
                            @foreach($allApprovedRegs as $r)
                                <option value="{{ $r->id }}">{{ $r->registration_number }} — {{ $r->participant?->first_name_ar }} {{ $r->participant?->last_name_ar }} ({{ $r->skill?->name_ar ?? 'تخصص' }})</option>
                            @endforeach
                        </select>
                        @error('registration_id') <span class="text-rose-500 text-[11px] font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">
                            {{ $t('نوع الشهادة الرسمية المطلوبة *', 'Type de Certificat Officiel *', 'Official Certificate Type *') }}
                        </label>
                        <select wire:model="certificate_type" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-black focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="PARTICIPATION">📜 شهادة مشاركة وتأهل (PARTICIPATION)</option>
                            <option value="WINNER_GOLD">🥇 شهادة الميدالية الذهبية - المركز الأول (WINNER_GOLD)</option>
                            <option value="WINNER_SILVER">🥈 شهادة الميدالية الفضية - المركز الثاني (WINNER_SILVER)</option>
                            <option value="WINNER_BRONZE">🥉 شهادة الميدالية البرونزية - المركز الثالث (WINNER_BRONZE)</option>
                            <option value="MEDALLION_EXCELLENCE">🎖️ شهادة التميز (MEDALLION_EXCELLENCE)</option>
                            <option value="EXPERT_JUDGE">⚖️ شهادة تقدير حكم خبير (EXPERT_JUDGE)</option>
                            <option value="DELEGATION_HEAD">🏛️ شهادة مسؤول ورئيس وفد (DELEGATION_HEAD)</option>
                            <option value="ECONOMIC_PARTNER">🏢 شهادة تقدير متعامل اقتصادي وراعي (ECONOMIC_PARTNER)</option>
                            <option value="ORGANIZER">💼 شهادة تقدير منظم معتمد (ORGANIZER)</option>
                            <option value="VOLUNTEER">🤝 شهادة تقدير متطوع (VOLUNTEER)</option>
                            <option value="MEDIA">📰 شهادة تقدير صحفي إعلامي (MEDIA)</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('formOpen', false)" class="px-5 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60 rounded-2xl transition cursor-pointer">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="issue" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-2xl shadow-md transition cursor-pointer">
                        {{ $t('إصدار الشهادة الرسمية', 'Émettre le Certificat', 'Issue Certificate') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
